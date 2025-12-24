-- DROP FUNCTION sc_tmp.tr_perawatanspk();

CREATE OR REPLACE FUNCTION sc_tmp.tr_perawatanspk_pembayaran()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/06/2019
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);
     vr_statustx char(6);
begin    

	IF TG_OP ='INSERT' THEN 

		IF (new.status='I') THEN 

	
		END IF;
	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN
		if (new.status='F' and old.status='E') then
			vr_statustx:= coalesce(status,'') from sc_his.perawatanspk where nodok=new.nodoktmp;
			
			-- delete from sc_his.perawatanspk_pembayaran where nodok=new.nodoktmp;
				
			insert into sc_his.perawatanspk_pembayaran 
			(nodok,nodokref,id,tgl,tipe_pembayaran,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,status,nodoktmp)
			(select new.nodoktmp,nodokref,id,tgl,tipe_pembayaran,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,'P',new.nodoktmp from sc_tmp.perawatanspk_pembayaran where nodoktmp=new.nodoktmp);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');

			delete from sc_tmp.perawatanspk_pembayaran where nodoktmp=new.nodoktmp;

			UPDATE sc_his.perawatanspk SET status='P' where nodok=new.nodoktmp;
			
		end if;
	
	RETURN NEW;
	END IF;
  
    return new;
        
end;
$function$
;
