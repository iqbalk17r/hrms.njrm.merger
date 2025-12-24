-- DROP FUNCTION sc_trx.tr_trx_sppb_dtl();

CREATE OR REPLACE FUNCTION sc_trx.tr_trx_sppb_dtl()
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

		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
				vr_countdtl:=count(*)::numeric FROM SC_TRX.SPPB_DTL WHERE (STATUS='P' or status='U' or status='S') and nodoktmp=new.nodoktmp and nodok=new.nodok;
				vr_countdtl_rbbk:=count(*)::numeric FROM SC_TRX.SPPB_DTL WHERE STATUS='U' and qtysppbminta=qtypo and nodoktmp=new.nodoktmp and nodok=new.nodok;
				vr_countdtl_cbbk:=count(*)::numeric FROM SC_TRX.SPPB_DTL WHERE qtypo=0 and nodoktmp=new.nodoktmp and nodok=new.nodok;
				vr_countdtl_sbbk:=count(*)::numeric FROM SC_TRX.SPPB_DTL WHERE STATUS='S' and nodoktmp=new.nodoktmp and nodok=new.nodok;
				
				/* UPDATE U=FULL TRX JIKA BARANG SAMA - SAMA PENUH */
				IF (vr_countdtl=vr_countdtl_rbbk) then
					-- update SC_TRX.SPPB_MST SET STATUS='U' where NODOK=NEW.NODOK AND NIK=NEW.NIK AND coalesce(STATUS,'N')<>'C';
				ELSEIF(vr_countdtl_cbbk=vr_countdtl	) THEN
					-- update SC_TRX.SPPB_MST SET STATUS='P' where NODOK=NEW.NODOK AND NIK=NEW.NIK AND coalesce(STATUS,'N')<>'C';
				ELSEIF(vr_countdtl_sbbk>0 OR vr_countdtl_rbbk<vr_countdtl) THEN
					-- update SC_TRX.SPPB_MST SET STATUS='S' where NODOK=NEW.NODOK AND NIK=NEW.NIK AND coalesce(STATUS,'N')<>'C';
				END IF; 

				/*update status U untuk permintaan yang sudah terpenuhi */
				-- update SC_TRX.SPPB_DTL set status='U', 
				-- qtypokecil= case 
				-- when coalesce(stockcode,'')='' and coalesce(qtypo,0)>0 then qtypo
				-- when coalesce(stockcode,'')!='' and coalesce(qtypo,0)>0 then round((coalesce(qtysppbkecil,0)/coalesce(qtysppbminta,0))*coalesce(qtypo,0)) else 0  end
				-- where nodok=new.nodok and nik=new.nik and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and 
				-- loccode=new.loccode and stockcode=new.stockcode and qtysppbminta=new.qtypo and qtypo>0  and coalesce(STATUS,'N') NOT IN ('U','C');-- and (status='P' or status='S');

				-- update SC_TRX.SPPB_DTL set status='S',
				-- qtypokecil= case 
				-- when coalesce(stockcode,'')='' and coalesce(qtypo,0)>0 then qtypo
				-- when coalesce(stockcode,'')!='' and coalesce(qtypo,0)>0  then round((coalesce(qtysppbkecil,0)/coalesce(qtysppbminta,0))*coalesce(qtypo,0)) else 0  end
				-- where nodok=new.nodok and nik=new.nik and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and 
				-- loccode=new.loccode and stockcode=new.stockcode and qtysppbminta>new.qtypo and qtypo>0 and coalesce(STATUS,'N') NOT IN ('S','C');-- and (status='U' OR STATUS='P');

				-- update SC_TRX.SPPB_DTL set status='P',
				-- qtypokecil= case 
				-- when coalesce(stockcode,'')='' and coalesce(qtypo,0)>0 then qtypo
				-- when coalesce(stockcode,'')!='' and coalesce(qtypo,0) >0 then round((coalesce(qtysppbkecil,0)/coalesce(qtysppbminta,0))*coalesce(qtypo,0)) else 0 end
				-- where nodok=new.nodok and nik=new.nik and kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and 
				-- loccode=new.loccode and stockcode=new.stockcode and new.qtypo=0 and coalesce(STATUS,'N') NOT IN ('P','C');--- and (status='U' or status='S' );
				
		RETURN NEW;
	ELSEIF tg_op = 'DELETE' THEN

		RETURN old;	
	END IF;
	
END;
$function$
;
