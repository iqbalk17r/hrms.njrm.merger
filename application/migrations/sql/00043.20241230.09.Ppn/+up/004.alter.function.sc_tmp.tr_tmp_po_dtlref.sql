CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_po_dtlref()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 12/10/2019
	--update by rkm: 31/12/2024
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);  
     vr_qtypbk numeric;  
     vr_qtybbk numeric;  
     vr_qtyonhand numeric;  
     vr_statusmst character(6) ;

BEGIN		
	IF tg_op = 'INSERT' THEN
		--select * from sc_tmp.po_dtlref
/*select a.*,b.uraian as desc_satkecil,c.uraian as desc_satbesar from sc_mst.mapping_satuan_brg a
	left outer join sc_mst.trxtype b on a.satkecil=b.kdtrx and b.jenistrx='QTYUNIT'
	left outer join sc_mst.trxtype c on a.satbesar=c.kdtrx and c.jenistrx='QTYUNIT' 
select * from sc_mst.stkgdw
select * from sc_mst.trxtype where jenistrx='QTYUNIT'
select * from sc_mst.mapping_satuan_brg 
alter table sc_mst.mapping_satuan_brg add column kdgroup character(20),add column kdsubgroup character(20),add column stockcode character(50)
*/
		if (new.stockcode<>'' OR new.stockcode IS NOT NULL) then 
			
			update sc_tmp.po_dtlref a set satkecil=b.satkecil from sc_mst.stkgdw b where
			b.kdgroup=a.kdgroup and b.kdsubgroup=a.kdsubgroup and b.stockcode=a.stockcode and b.loccode=a.loccode and nodok=a.nodok and id=new.id and
			b.kdgroup=new.kdgroup and b.kdsubgroup=new.kdsubgroup and b.stockcode=new.stockcode and b.loccode=a.loccode and nodok=new.nodok and id=new.id;
			
			update sc_tmp.po_dtlref a set qtykecil=coalesce(a.qtyminta,0)*coalesce(b.qty,0) from sc_mst.mapping_satuan_brg b
			where b.satbesar=a.satminta and b.satkecil=a.satkecil and b.kdgroup=a.kdgroup and b.kdsubgroup=a.kdsubgroup and b.stockcode=a.stockcode and nodok=a.nodok 
			and b.kdgroup=new.kdgroup and b.kdsubgroup=new.kdsubgroup and b.stockcode=new.stockcode
			and a.nodok=new.nodok and a.id=new.id;

		/*	update  sc_tmp.po_dtlref a set id_nomor=a1.urutnya
			from (select a1.*,row_number() over(partition by nodok order by id asc) as urutnya
			from sc_tmp.po_dtlref a1) a1
			where a.id=a1.id and a.nodok=a1.nodok and a.nodok=new.nodok and a.id>=new.id ; 
			select * from sc_mst.stkgdw where stockcode='KRTS0001'
			*/

		end if ;

		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
		IF (OLD.STATUS='I' AND NEW.STATUS='M') THEN
			/*ITEM TELAH TER MAPPING */
			--select * from sc_tmp.po_dtl
			--select * from sc_tmp.po_dtlref 
			--select * from sc_mst.mapping_satuan_brg;
			update sc_tmp.po_dtlref set qtykecil=round((coalesce(old.qtykecil,0)/coalesce(old.qtyminta,0))*coalesce(new.qtyminta,0))
			where nodok=new.nodok and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and loccode=new.loccode and id=new.id and desc_barang=new.desc_barang;

			IF(left(new.nodokref,3)='PPB') THEN
			/*	update sc_tmp.po_dtlref a set qtykecil=b.qtykecilbaru
				from (select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtyminta*b.qty) as qtykecilbaru,a.satkecil,'I',a.id,a.desc_barang from sc_tmp.po_dtlref a
					left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
					and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
					where a.status='M'
					and a.nodok=new.nodok and a.branch=new.branch
					and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode and a.desc_barang=new.desc_barang and a.id=new.id
					group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,a.id,a.desc_barang) b
					
					where 
					a.nodok=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.loccode=b.loccode and a.id=b.id and a.desc_barang=b.desc_barang and
					a.nodok=new.nodok and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode and a.id=new.id and a.desc_barang=new.desc_barang;
			*/

			
			
				update sc_trx.sppb_dtl set qtypo=coalesce(qtypo,0)+coalesce(new.qtyminta,0)
				where nodok=new.nodokref and loccode=new.loccode and nik=new.nik and desc_barang=trim(new.desc_barang) ;
			ELSEIF (left(new.nodokref,3)='PBK') THEN
				/*
				update sc_tmp.po_dtlref a set qtykecil=b.qtykecilbaru
				from (select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtyminta*b.qty) as qtykecilbaru,a.satkecil,'I',a.id,a.desc_barang from sc_tmp.po_dtlref a
					left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
					and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
					where a.status='M'
					and a.nodok=new.nodok and a.branch=new.branch
					and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode and a.desc_barang=new.desc_barang and a.id=new.id
					group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,a.id,a.desc_barang) b
					where 
					a.nodok=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.loccode=b.loccode and a.id=b.id and a.desc_barang=b.desc_barang and
					a.nodok=new.nodok and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode and a.id=new.id and a.desc_barang=new.desc_barang;
					
				*/

				update sc_trx.stpbk_dtl set qtypo=coalesce(qtypo,0)+coalesce(new.qtyminta,0)
				where nodok=new.nodokref and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and loccode=new.loccode and nik=new.nik;
			END IF;

			
			delete from sc_tmp.po_dtl where 
			branch=new.branch and nodok=new.nodok ;
			--and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode;

			--select * from sc_mst.pricelst

			insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,qtykecil,satkecil,status,ttlbrutto,id,qtyminta,satminta,exppn,pkp,unitprice)
				(select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtykecil) as qtykecil,a.satkecil,'I',round(coalesce(c.unitprice,0)*sum(a.qtykecil)) as ttlbrutto,0 as id,sum(a.qtykecil) as qtyminta,a.satkecil,d.exppn,d.pkp,round(coalesce(c.unitprice,0)) from sc_tmp.po_dtlref a
				left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
				left outer join sc_tmp.po_mst d on a.nodok=d.nodok
				left outer join (select a.* 
				from sc_mst.pricelst a,
					(select kdgroup,kdsubgroup,stockcode,qtykecil,satkecil,max(pricedate) as pricedate from sc_mst.pricelst 
					group by kdgroup,kdsubgroup,stockcode,qtykecil,satkecil) b 
				where a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.pricedate=b.pricedate) c on 
				a.kdgroup=c.kdgroup and a.kdsubgroup=c.kdsubgroup and a.stockcode=c.stockcode 
				and d.kdgroupsupplier=c.kdgroupsupplier and d.kdsupplier=c.kdsupplier and d.kdsubsupplier=c.kdsubsupplier

				where a.status='M' and 
				a.nodok=new.nodok and a.branch=new.branch
				---and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode
				group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,c.unitprice,d.exppn,d.pkp);

/*			if ((select count(*) from sc_mst.pricelst where kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode)=0) then 
				 old query fix 
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,qtykecil,satkecil,status,id,qtyminta,satminta,exppn,pkp)
				(select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtyminta*b.qty),a.satkecil,'I',0 as id,sum(a.qtyminta) as qtyminta,a.satminta,d.exppn,d.pkp  from sc_tmp.po_dtlref a
				left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
				left outer join sc_tmp.po_mst d on a.nodok=d.nodok
				where a.status='M'
				and a.nodok=new.nodok and a.branch=new.branch
				and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode
				group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,a.satminta,d.exppn,d.pkp); 	

			else
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,qtykecil,satkecil,status,ttlbrutto,id,qtyminta,satminta,exppn,pkp)
				(select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtykecil) as qtykecil,a.satkecil,'I',round(coalesce(c.unitprice,0)*sum(a.qtykecil)) as ttlbrutto,0 as id,sum(a.qtyminta) as qtyminta,a.satminta,d.exppn,d.pkp from sc_tmp.po_dtlref a
				left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
				left outer join sc_tmp.po_mst d on a.nodok=d.nodok
				left outer join (select a.* 
				from sc_mst.pricelst a,
					(select kdgroup,kdsubgroup,stockcode,qtykecil,satkecil,max(pricedate) as pricedate from sc_mst.pricelst 
					group by kdgroup,kdsubgroup,stockcode,qtykecil,satkecil) b 
				where a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.pricedate=b.pricedate) c on 
				a.kdgroup=c.kdgroup and a.kdsubgroup=c.kdsubgroup and a.stockcode=c.stockcode 
				and d.kdgroupsupplier=c.kdgroupsupplier and d.kdsupplier=c.kdsupplier and d.kdsubsupplier=c.kdsubsupplier

				where a.status='M'
				and a.nodok=new.nodok and a.branch=new.branch
				and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.stockcode=new.stockcode and a.loccode=new.loccode
				group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,a.satminta,c.unitprice,d.exppn,d.pkp);
			
			end if; */

			---select * from sc_tmp.po_mst

		

		END IF;

		RETURN new;
	ELSEIF tg_op = 'DELETE' THEN
			/*update  sc_tmp.po_dtlref a set id_nomor=a1.urutnya
			from (select a1.*,row_number() over(partition by nodok order by id asc) as urutnya
			from sc_tmp.po_dtlref a1) a1
			where a.id=a1.id and a.nodok=a1.nodok and a.nodok=old.nodok and a.id>=old.id ; */

			--select * from sc_tmp.po_dtl
			--select * from sc_tmp.po_dtlref
			delete from sc_tmp.po_dtl where 
			branch=old.branch and nodok=old.nodok and kdgroup=old.kdgroup
			and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode and loccode=old.loccode;

			insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,qtykecil,satkecil,status,ttlbrutto,id,qtyminta,satminta,exppn,pkp,unitprice)
				(select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtykecil) as qtykecil,a.satkecil,'I',round(coalesce(c.unitprice,0)*sum(a.qtykecil)) as ttlbrutto,0 as id,sum(a.qtykecil) as qtyminta,a.satkecil AS satminta,d.exppn,d.pkp,round(coalesce(c.unitprice,0)) from sc_tmp.po_dtlref a
				left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
				left outer join sc_tmp.po_mst d on a.nodok=d.nodok
				left outer join (select a.* 
				from sc_mst.pricelst a,
					(select kdgroup,kdsubgroup,stockcode,qtykecil,satkecil,max(pricedate) as pricedate from sc_mst.pricelst 
					group by kdgroup,kdsubgroup,stockcode,qtykecil,satkecil) b 
				where a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.pricedate=b.pricedate) c on 
				a.kdgroup=c.kdgroup and a.kdsubgroup=c.kdsubgroup and a.stockcode=c.stockcode 
				and d.kdgroupsupplier=c.kdgroupsupplier and d.kdsupplier=c.kdsupplier and d.kdsubsupplier=c.kdsubsupplier

				where a.status='M' and 
				a.nodok=old.nodok and a.branch=old.branch
				and a.kdgroup=old.kdgroup and a.kdsubgroup=old.kdsubgroup and a.stockcode=old.stockcode and a.loccode=old.loccode
				group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,c.unitprice,d.exppn,d.pkp);			


			--select * from sc_tmp.po_dtlref	
			IF (coalesce(trim(old.status),'')='M') THEN
				IF(left(trim(old.nodokref),3)='PPB' and  coalesce(trim(old.status),'') not in ('C','H','D')) THEN
					update sc_trx.sppb_dtl set qtypo=coalesce(qtypo,0)-coalesce(old.qtyminta,0)
					where nodok=old.nodokref and loccode=old.loccode and nik=old.nik and id=old.id;
					
				ELSEIF (left(trim(old.nodokref),3)='PBK' and  coalesce(trim(old.status),'') not in ('C','H','D')) THEN
					update sc_trx.stpbk_dtl set qtypo=coalesce(qtypo,0)-coalesce(old.qtyminta,0)
					where nodok=old.nodokref and kdgroup=old.kdgroup and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode and loccode=old.loccode and nik=old.nik;
				END IF;
			ELSEIF (coalesce(trim(old.status),'')='H') THEN
				IF(left(trim(old.nodokref),3)='PPB' and  coalesce(old.status,'') not in ('C','D')) THEN
					update sc_trx.sppb_dtl set qtypo=coalesce(qtypo,0)-(coalesce(qtypo,0)-coalesce(old.qtyterima,0))
					where nodok=old.nodokref and loccode=old.loccode and nik=old.nik and desc_barang=trim(old.desc_barang) ;
				ELSEIF (left(trim(old.nodokref),3)='PBK' and  coalesce(old.status,'') not in ('C','D')) THEN
					update sc_trx.stpbk_dtl set qtypo=coalesce(qtypo,0)-(coalesce(qtypo,0)-coalesce(old.qtyterima,0))
					where nodok=old.nodokref and kdgroup=old.kdgroup and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode and loccode=old.loccode and nik=old.nik;
				END IF;
			END IF;

			RAISE NOTICE 'TEST  (%)', old.qtyminta ;
	

		
			--select * from sc_mst.pricelst


		
		RETURN old;	
	END IF;
	
END;
$function$
;
