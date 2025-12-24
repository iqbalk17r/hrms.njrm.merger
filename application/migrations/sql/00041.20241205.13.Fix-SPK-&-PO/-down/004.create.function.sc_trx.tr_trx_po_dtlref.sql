-- DROP FUNCTION sc_trx.tr_trx_po_dtlref();

CREATE OR REPLACE FUNCTION sc_trx.tr_trx_po_dtlref()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 12/08/2017
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4); 
     vr_countdtl numeric;  
     vr_countdtl_rbbk numeric;  
     vr_countdtl_cbbk numeric;  
     vr_countdtl_sbbk numeric;  

BEGIN		
	IF tg_op = 'INSERT' THEN
		/*	IF(left(new.nodokref,3)='PPB' and  coalesce(new.status,'') not in ('C','H','D')) THEN
				update sc_trx.sppb_dtl set qtypo=coalesce(qtypo,0)+coalesce(new.qtyminta,0)
				where nodok=new.nodokref and loccode=new.loccode and nik=new.nik and desc_barang=trim(new.desc_barang) ;
			ELSEIF (left(new.nodokref,3)='PBK' and  coalesce(new.status,'') not in ('C','H','D')) THEN
				update sc_trx.stpbk_dtl set qtypo=coalesce(qtypo,0)+coalesce(new.qtyminta,0)
				where nodok=new.nodokref and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and loccode=new.loccode and nik=new.nik;
			END IF;
		*/
		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
			IF EXISTS(select * from sc_trx.po_mst where nodok=new.nodok and status not in ('A','C','H','I','D','E')) THEN
				--select * from sc_trx.po_dtlref
				vr_countdtl:=count(*)::numeric FROM sc_trx.po_dtlref WHERE kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and (STATUS IN ('S','P','U')) and nodok=new.nodok;
				vr_countdtl_rbbk:=count(*)::numeric FROM sc_trx.po_dtlref WHERE kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and STATUS='U' and coalesce(qtyminta,0)=coalesce(qtyterima,0) and nodok=new.nodok ;
				vr_countdtl_cbbk:=count(*)::numeric FROM sc_trx.po_dtlref WHERE kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and coalesce(qtyterima,0)=0 and nodok=new.nodok;
				vr_countdtl_sbbk:=count(*)::numeric FROM sc_trx.po_dtlref WHERE kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and STATUS='S' and nodok=new.nodok;
				--select count(*)::numeric FROM SC_TRX.SPPB_DTL WHERE STATUS='U' and qtysppbminta=qtypo ;
				/* UPDATE U=FULL TRX JIKA BARANG SAMA - SAMA PENUH */

				IF (vr_countdtl=vr_countdtl_rbbk) then
					update SC_TRX.po_dtl SET STATUS='U' where kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and NODOK=NEW.NODOK AND coalesce(STATUS,'N') not in ('C','U');
				ELSEIF(vr_countdtl_cbbk=vr_countdtl	) THEN
					update SC_TRX.po_dtl SET STATUS='P' where kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and NODOK=NEW.NODOK AND coalesce(STATUS,'N') not in ('C','P');
				ELSEIF(vr_countdtl_sbbk>0 OR vr_countdtl_rbbk<vr_countdtl) THEN
					update SC_TRX.po_dtl SET STATUS='S' where kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and stockcode=new.stockcode and NODOK=NEW.NODOK AND coalesce(STATUS,'N') not in ('C','S');
				END IF; 

				--select * from sc_trx.stbbm_dtlref
				--select * from sc_trx.po_dtlref

				/*update status U untuk permintaan yang sudah terpenuhi */
				update sc_trx.po_dtlref set status='U'
				where nodok=new.nodok and nik=new.nik and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and 
				loccode=new.loccode and stockcode=new.stockcode and nodokref=new.nodokref and coalesce(qtyminta,0)=coalesce(new.qtyterima,0) and coalesce(qtyterima,0)>0  and coalesce(STATUS,'N') NOT IN ('U','C') and id=new.id;-- and (status='P' or status='S');

				update SC_TRX.po_dtlref set status='S'
				where nodok=new.nodok and nik=new.nik and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and 
				loccode=new.loccode and stockcode=new.stockcode and nodokref=new.nodokref and qtyminta>coalesce(new.qtyterima,0)  and coalesce(new.qtyterima,0) >0 and coalesce(STATUS,'N') NOT IN ('S','C') and id=new.id;-- and (status='U' OR STATUS='P');

				update SC_TRX.po_dtlref set status='P'
				where nodok=new.nodok and nik=new.nik and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and 
				loccode=new.loccode and stockcode=new.stockcode and nodokref=new.nodokref and coalesce(new.qtyterima,0) =0 and coalesce(STATUS,'N') NOT IN ('P','C') and id=new.id;--- and (status='U' or status='S' );

				END IF;

		RETURN new;
	ELSEIF tg_op = 'DELETE' THEN
		/*	IF(left(old.nodokref,3)='PPB' and coalesce(old.status,'') not in ('H')) THEN
				update sc_trx.sppb_dtl set qtypo=coalesce(qtypo,0)-coalesce(old.qtyminta,0)
				where nodok=old.nodokref and loccode=old.loccode and NIK=old.nik and desc_barang=trim(old.desc_barang) ;
			ELSEIF (left(old.nodokref,3)='PBK' and coalesce(old.status,'') not in ('C','H','D')) THEN
				update sc_trx.stpbk_dtl set qtypo=coalesce(qtypo,0)-coalesce(old.qtyminta,0)
				where nodok=old.nodokref and kdgroup=old.kdgroup and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode and loccode=old.loccode and nik=old.nik;
			END IF;
		*/	
		RETURN old;	
	END IF;
	
END;
$function$
;
