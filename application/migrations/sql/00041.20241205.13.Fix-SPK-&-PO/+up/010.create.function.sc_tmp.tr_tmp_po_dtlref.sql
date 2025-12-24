-- DROP FUNCTION sc_tmp.tr_tmp_po_dtlref();

CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_po_dtlref()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 12/10/2017
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);  
     vr_qtypbk numeric;  
     vr_qtybbk numeric;  
     vr_qtyonhand numeric;  
     vr_statusmst character(6) ;

BEGIN		
	IF tg_op = 'INSERT' THEN

		if (new.stockcode<>'' OR new.stockcode IS NOT NULL) then 
			
			update sc_tmp.po_dtlref a set satkecil=b.satkecil from sc_mst.stkgdw b where
			b.kdgroup=a.kdgroup and b.kdsubgroup=a.kdsubgroup and b.stockcode=a.stockcode and b.loccode=a.loccode and nodok=a.nodok and id=new.id and
			b.kdgroup=new.kdgroup and b.kdsubgroup=new.kdsubgroup and b.stockcode=new.stockcode and b.loccode=a.loccode and nodok=new.nodok and id=new.id;
			
			update sc_tmp.po_dtlref a set qtykecil=coalesce(a.qtyminta,0)*coalesce(b.qty,0) from sc_mst.mapping_satuan_brg b
			where b.satbesar=a.satminta and b.satkecil=a.satkecil and b.kdgroup=a.kdgroup and b.kdsubgroup=a.kdsubgroup and b.stockcode=a.stockcode and nodok=a.nodok 
			and b.kdgroup=new.kdgroup and b.kdsubgroup=new.kdsubgroup and b.stockcode=new.stockcode
			and a.nodok=new.nodok and a.id=new.id;

		end if ;

		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
		IF (OLD.STATUS='I' AND NEW.STATUS='M') THEN
			update sc_tmp.po_dtlref set qtykecil=round((coalesce(old.qtykecil,0)/coalesce(old.qtyminta,0))*coalesce(new.qtyminta,0))
			where nodok=new.nodok and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and loccode=new.loccode and id=new.id and desc_barang=new.desc_barang;

			IF(left(new.nodokref,3)='PPB') THEN
				update sc_trx.sppb_dtl set qtypo=coalesce(qtypo,0)+coalesce(new.qtyminta,0)
				where nodok=new.nodokref and loccode=new.loccode and nik=new.nik and desc_barang=trim(new.desc_barang) ;
			ELSEIF (left(new.nodokref,3)='PBK') THEN
				update sc_trx.stpbk_dtl set qtypo=coalesce(qtypo,0)+coalesce(new.qtyminta,0)
				where nodok=new.nodokref and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and loccode=new.loccode and nik=new.nik;
			END IF;
			
			delete from sc_tmp.po_dtl where 
			branch=new.branch and nodok=new.nodok ;
			insert into sc_tmp.po_dtl (branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,qtykecil,satkecil,status,ttlbrutto,id,qtyminta,satminta,exppn,pkp,unitprice)
			(select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtykecil) as qtykecil,a.satkecil,'I',round(coalesce(c.unitprice,0)*sum(a.qtykecil)) as ttlbrutto,0 as id,0 as qtyminta,'' AS satminta,d.exppn,d.pkp,round(coalesce(c.unitprice,0)) 
				from sc_tmp.po_dtlref a
				left outer join sc_mst.mapping_satuan_brg b on a.satkecil=b.satkecil and a.satminta=b.satbesar and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode
				left outer join sc_tmp.po_mst d on a.nodok=d.nodok
				left outer join (select a.* from sc_mst.pricelst a,
					(select kdgroup,kdsubgroup,stockcode,qtykecil,satkecil,max(pricedate) as pricedate from sc_mst.pricelst 
					group by kdgroup,kdsubgroup,stockcode,qtykecil,satkecil) b 
					where a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.pricedate=b.pricedate) c on a.kdgroup=c.kdgroup and a.kdsubgroup=c.kdsubgroup and a.stockcode=c.stockcode and d.kdgroupsupplier=c.kdgroupsupplier and d.kdsupplier=c.kdsupplier and d.kdsubsupplier=c.kdsubsupplier
				where a.status='M' and 
				a.nodok=new.nodok and a.branch=new.branch
				group by a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.satkecil,c.unitprice,d.exppn,d.pkp);
		END IF;

		RETURN new;
	ELSEIF tg_op = 'DELETE' THEN
			delete from sc_tmp.po_dtl where 
			branch=old.branch and nodok=old.nodok and kdgroup=old.kdgroup
			and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode and loccode=old.loccode;

			insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,qtykecil,satkecil,status,ttlbrutto,id,qtyminta,satminta,exppn,pkp,unitprice)
				(select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,sum(a.qtykecil) as qtykecil,a.satkecil,'I',round(coalesce(c.unitprice,0)*sum(a.qtykecil)) as ttlbrutto,0 as id,0 as qtyminta,'' AS satminta,d.exppn,d.pkp,round(coalesce(c.unitprice,0)) from sc_tmp.po_dtlref a
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
		
		RETURN old;	
	END IF;
	
END;
$function$
;
