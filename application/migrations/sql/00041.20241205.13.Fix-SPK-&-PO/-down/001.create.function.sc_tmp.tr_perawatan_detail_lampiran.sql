-- DROP FUNCTION sc_tmp.tr_perawatan_detail_lampiran();

CREATE OR REPLACE FUNCTION sc_tmp.tr_perawatan_detail_lampiran()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE 
	--author by fiky: 12/06/2019
	--update by fiky: 16/06/2019
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);  
     vr_qtypbk numeric;  
     vr_qtybbk numeric;  
     vr_qtyonhand numeric;  

BEGIN		
	IF tg_op = 'INSERT' THEN

			update  sc_tmp.perawatan_detail_lampiran a set id=a1.urutnya
			from (select a1.*,row_number() over(partition by nodok,nodokref,idfaktur order by nodok,idfaktur,inputdate asc) as urutnya
			from sc_tmp.perawatan_detail_lampiran a1) a1
			where a.id=a1.id and a.nodok=a1.nodok and a.inputdate=a1.inputdate and a.nodokref=a1.nodokref and a.idfaktur=a1.idfaktur 
			and a.inputdate=new.inputdate and a.nodok=new.nodok and a.idfaktur=new.idfaktur;

			update sc_tmp.perawatan_detail_lampiran set status='H' where inputdate=new.inputdate and nodok=new.nodok and idfaktur=new.idfaktur;
		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
		if (new.status='H' and old.status!='H') then 
			update sc_tmp.perawatan_detail_lampiran a set nnetto=b.ttlnetto ,status=old.status,ndpp=b.ndpp,nppn=b.nppn from 
			(select inputdate,nodok,id,idfaktur,nodokref,
			case when coalesce(pkp,'')='YES' and coalesce(exppn,'')='EXC' then
			round(coalesce(nservis,0)-coalesce(ndiskon,0))
			when coalesce(pkp,'')='YES' and coalesce(exppn,'')='INC' then
			round(round(coalesce(nservis,0)-coalesce(ndiskon,0))/1.1)
			else round(round(coalesce(nservis,0)-coalesce(ndiskon,0))) end as ndpp,
			case 
			when coalesce(pkp,'')='YES' and coalesce(exppn,'')='EXC' then
			round(round(round(coalesce(nservis,0)-coalesce(ndiskon,0)))*(10::numeric/100))
			when coalesce(pkp,'')='YES' and coalesce(exppn,'')='INC' then
			(round(coalesce(nservis,0)-coalesce(ndiskon,0)))-round(round(coalesce(nservis,0)-coalesce(ndiskon,0))/1.1)
			else 0 end nppn,
			case 
			when coalesce(pkp,'')='YES' and coalesce(exppn,'')='EXC' then
			round(coalesce(nservis,0)-coalesce(ndiskon,0)) +
			round(round(coalesce(nservis,0)-coalesce(ndiskon,0))*(10::numeric/100))
			when coalesce(pkp,'')='YES' and coalesce(exppn,'')='INC' then
			round(round(coalesce(nservis,0)-coalesce(ndiskon,0))/1.1) +
			(round(coalesce(nservis,0)-coalesce(ndiskon,0)))-round(round(round(coalesce(nservis,0)-coalesce(ndiskon,0)))/1.1)
			else round(round(coalesce(nservis,0)-coalesce(ndiskon,0)))
			end as ttlnetto from 
			sc_tmp.perawatan_detail_lampiran) b  where a.inputdate=b.inputdate and a.nodok=b.nodok and a.nodok=new.nodok and a.inputdate=new.inputdate and a.idfaktur=b.idfaktur and a.id=b.id
			and a.idfaktur=new.idfaktur and a.id=new.id; 


			update sc_tmp.perawatan_mst_lampiran a set 
			nservis=b.nservis,
			ndiskon=b.ndiskon,
			ndpp=b.ndpp,
			nppn=b.nppn,
			nnetto=b.nnetto
			from (select nodok,nodokref,idfaktur, sum(nservis) as nservis,sum(ndiskon) as ndiskon,sum(nnetto) as nnetto,sum(ndpp) as ndpp,sum(nppn) as nppn from sc_tmp.perawatan_detail_lampiran
			group by nodok,nodokref,idfaktur) b
			where a.nodok=b.nodok and a.nodokref=b.nodokref and a.idfaktur=b.idfaktur and
			a.nodok=new.nodok and b.nodokref=new.nodokref and a.idfaktur=new.idfaktur;
			
/*
			select sum(nservis) as nservis,sum(ndiskon) as ndiskon,sum(nnetto) as nnetto,sum(ndpp) as ndpp,sum(nppn) as nppn from sc_tmp.perawatan_detail_lampiran;
*/
		end if;
/*
		--select * from sc_tmp.perawatanspk;
		--select * from sc_tmp.perawatan_mst_lampiran;
		--select * from sc_tmp.perawatan_detail_lampiran;
		if (new.status='H' and old.status!='H') then 
			update sc_tmp.perawatan_detail_lampiran a set nnetto=
			select 
			case 
			when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
			round(coalesce(b.nservis,0)-coalesce(ndiskon,0)) +
			round(round(coalesce(b.nservis,0)-coalesce(ndiskon,0))*(10::numeric/100))
			when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
			round(round(coalesce(b.nservis,0)-coalesce(ndiskon,0))/1.1) +
			(round(coalesce(b.nservis,0)-coalesce(ndiskon,0)))-round(round(round(coalesce(b.nservis,0)-coalesce(ndiskon,0)))/1.1)
			else round(round(coalesce(b.nservis,0)-coalesce(ndiskon,0)))
			end as ttlnetto from 
			sc_tmp.perawatan_detail_lampiran b
		end if;
		update sc_tmp.po_dtl a 	set 
					ttldiskon=b.ttldiskon,
					ttldpp=b.ttldpp,
					ttlppn=b.ttlppn,
					ttlnetto=b.ttlnetto, 
					status=old.status from 
					(select	b.branch,b.nodok,b.kdgroup,b.kdsubgroup,b.stockcode,b.loccode,b.nodokref,b.desc_barang,b.id,b.pkp,b.exppn,ttlbrutto,round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0) as ttldiskon,
						case when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
						round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))
						when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
						round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/1.1)
						else 0 end as ttldpp,
						case 
						when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
						round(round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0)))*(10::numeric/100))
						when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
						(coalesce(ttlbrutto,0)-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))-round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/1.1)
						else 0 end ttlppn,
						case 
							when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
							round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0)) +
							round(round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0)))*(10::numeric/100))
							when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
							round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/1.1) +
							(coalesce(ttlbrutto,0)-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))-round(round(b.ttlbrutto-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))/1.1)
							else round(coalesce(b.ttlbrutto,0)-round(qtyminta*(unitprice-(unitprice*(1-(disc1/100))*(1-(disc2/100))*(1-(disc3/100)))),0))
							end as ttlnetto
						from sc_tmp.po_dtl b) b
				where a.nodok=b.nodok and a.stockcode=b.stockcode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.id=b.id and
				a.nodok=new.nodok and a.stockcode=new.stockcode and a.kdgroup=new.kdgroup and a.kdsubgroup=new.kdsubgroup and a.id=new.id;
*/
		
		RETURN new;
	ELSEIF tg_op = 'DELETE' THEN

			update  sc_tmp.perawatan_detail_lampiran a set id=a1.urutnya
			from (select a1.*,row_number() over(partition by nodok,nodokref,idfaktur order by nodok,idfaktur,inputdate asc) as urutnya
			from sc_tmp.perawatan_detail_lampiran a1) a1
			where a.id=a1.id and a.nodok=a1.nodok and a.inputdate=a1.inputdate and a.nodokref=a1.nodokref and a.idfaktur=a1.idfaktur 
			and a.inputdate=old.inputdate and a.nodok=old.nodok;
				
			update sc_tmp.perawatan_mst_lampiran a set 
			nservis=b.nservis,
			ndiskon=b.ndiskon,
			ndpp=b.ndpp,
			nppn=b.nppn,
			nnetto=b.nnetto
			from (select nodok,nodokref,idfaktur, sum(nservis) as nservis,sum(ndiskon) as ndiskon,sum(nnetto) as nnetto,sum(ndpp) as ndpp,sum(nppn) as nppn from sc_tmp.perawatan_detail_lampiran
			group by nodok,nodokref,idfaktur) b
			where a.nodok=b.nodok and a.nodokref=b.nodokref and a.idfaktur=b.idfaktur and
			a.nodok=old.nodok and b.nodokref=old.nodokref and a.idfaktur=old.idfaktur;	
		RETURN old;	
	END IF;
	
END;
$function$
;
