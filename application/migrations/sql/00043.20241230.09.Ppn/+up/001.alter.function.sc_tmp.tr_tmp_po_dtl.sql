CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_po_dtl()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$

DECLARE 

	--author by fiky: 12/08/2017

	--update by fiky: 30/10/2019

	--update pembenahan update nama barang ke desc barang
	
	--update by RKM ::27/12/2024 => penambahan setup ppn

     vr_nomor char(12); 

     vr_cekprefix char(4);

     vr_nowprefix char(4);  

     vr_qtypbk numeric;  

     vr_qtybbk numeric;  

     vr_qtyonhand numeric;  
	
    n_ppn numeric;

BEGIN		

	IF tg_op = 'INSERT' THEN

		update  sc_tmp.po_dtl a set id=a1.urutnya
		from (select a1.*,row_number() over(partition by nodok order by id asc) as urutnya
			from sc_tmp.po_dtl a1) a1
		where a.id=a1.id and a.nodok=a1.nodok and a.kdgroup=a1.kdgroup and a.kdsubgroup=a1.kdsubgroup and a.stockcode=a1.stockcode
		and a.nodok=new.nodok and a.id>=new.id ;

		update sc_tmp.po_mst set ttlbrutto=(select sum(coalesce(ttlbrutto,0)) from sc_tmp.po_dtl where nodok=new.nodok) 
		where nodok=new.nodok;

		/* UPDATE REBALANCE */
		update sc_trx.po_dtl a set status='' ,desc_barang=b.nmbarang from sc_mst.mbarang b where  a.stockcode=b.nodok and a.id=new.id and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and coalesce(a.status,'')!='';

		delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';

		insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,new.nodok,'','TMPPO');

		RETURN new;

	ELSEIF tg_op = 'UPDATE' THEN
		IF (coalesce(new.status,'')='' and coalesce(old.status,'')!='') then
			if (SELECT count(*) FROM sc_mst.option WHERE trim(kdoption) = 'PPN' AND trim(group_option) = 'TAX') > 0 THEN
                n_ppn := value1 from sc_mst.option where trim(kdoption) = 'PPN' and trim(group_option)= 'TAX';
            else
                INSERT INTO sc_mst.option 
                    (kdoption,nmoption,value1,status,keterangan,input_by,input_date,group_option) 
                VALUES
                    ('PPN','SETUP PPN','12','T','NILAI PERSENTASE PPN','SYSTEM','2024-12-27 00:00:01','TAX');
                n_ppn := value1 from sc_mst.option where trim(kdoption) = 'PPN' and trim(group_option)= 'TAX';
            end if;
			update sc_tmp.po_dtl set 
			qtyminta=round(coalesce(qtykecil,0)/(select coalesce(qty,0) from sc_mst.mapping_satuan_brg where kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and satkecil=new.satkecil and satbesar=new.satminta))
			where nodok=new.nodok and stockcode=new.stockcode and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and id=new.id;

			update sc_tmp.po_dtl a 
			set ttlbrutto=coalesce(b.qtyminta,0)*coalesce(b.unitprice,0) from sc_tmp.po_dtl b
			where a.nodok=b.nodok and a.stockcode=b.stockcode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.id=b.id and

			a.nodok=new.nodok and a.stockcode=new.stockcode and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.id=new.id;

			update sc_tmp.po_dtl a set 
				ttldiskon=b.ttldiskon,
				ttldpp=b.ttldpp,
				ttlppn=b.ttlppn,
				ttlnetto=b.ttlnetto from 
				(select	b.branch,b.nodok,b.kdgroup,b.kdsubgroup,b.stockcode,b.loccode,b.nodokref,b.desc_barang,b.id,b.pkp,b.exppn,ttlbrutto,round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0) as ttldiskon,
					case when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
					round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
					round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/(n_ppn::numeric/10))
					else 0 end as ttldpp,
					case 
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
					round(round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0)))*(n_ppn::numeric/100))
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
					(coalesce(ttlbrutto,0)-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))-round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/(n_ppn::numeric/10))
					else 0 end ttlppn,
					case 
						when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
						round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0)) +
						round(round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0)))*(n_ppn::numeric/100))
						when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
						round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/(n_ppn::numeric/10)) +
						(coalesce(ttlbrutto,0)-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))-round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/(n_ppn::numeric/10))
						else round(coalesce(b.ttlbrutto,0)-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))
						end as ttlnetto
					from sc_tmp.po_dtl b) b
			where a.nodok=b.nodok and a.stockcode=b.stockcode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.id=b.id and
			a.nodok=new.nodok and a.stockcode=new.stockcode and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.id=new.id;

			update sc_tmp.po_mst set 
				ttlbrutto=(select sum(coalesce(ttlbrutto,0)) from sc_tmp.po_dtl where nodok=new.nodok),
				ttldiskon=(select sum(coalesce(ttldiskon,0)) from sc_tmp.po_dtl where nodok=new.nodok),
				ttldpp=(select sum(coalesce(ttldpp,0)) from sc_tmp.po_dtl where nodok=new.nodok),
				ttlppn=(select sum(coalesce(ttlppn,0)) from sc_tmp.po_dtl where nodok=new.nodok),
				ttlnetto=(select sum(coalesce(ttlnetto,0)) from sc_tmp.po_dtl where nodok=new.nodok)
			where nodok=new.nodok;

			update sc_tmp.po_dtl set status=trim(old.status) where nodok=new.nodok and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode;

		end if;

		delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';

		insert into sc_mst.trxerror
		(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
		(new.nodok,0,new.nodok,'','TMPPO');
		RETURN new;

	ELSEIF tg_op = 'DELETE' THEN

		update  sc_tmp.po_dtl a set id=a1.urutnya
		from (select a1.*,row_number() over(partition by nodok order by id asc) as urutnya
		from sc_tmp.po_dtl a1) a1
		where a.id=a1.id and a.nodok=a1.nodok and a.kdgroup=a1.kdgroup and a.kdsubgroup=a1.kdsubgroup and a.stockcode=a1.stockcode
		and a.nodok=old.nodok and a.id>=old.id ;

		update sc_tmp.po_mst set 
		ttlbrutto=(select sum(coalesce(ttlbrutto,0)) from sc_tmp.po_dtl where nodok=old.nodok),
		ttldiskon=(select sum(coalesce(ttldiskon,0)) from sc_tmp.po_dtl where nodok=old.nodok) ,
		ttldpp=(select sum(coalesce(ttldpp,0)) from sc_tmp.po_dtl where nodok=old.nodok) ,
		ttlppn=(select sum(coalesce(ttlppn,0)) from sc_tmp.po_dtl where nodok=old.nodok) ,
		ttlnetto=(select sum(coalesce(ttlnetto,0)) from sc_tmp.po_dtl where nodok=old.nodok) 
		where nodok=old.nodok;		

		delete from sc_mst.trxerror where userid=old.nodok and modul='TMPPO';
		insert into sc_mst.trxerror
		(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
		(old.nodok,0,old.nodok,'','TMPPO');
		RETURN old;	
	END IF;

END;

$function$
;
