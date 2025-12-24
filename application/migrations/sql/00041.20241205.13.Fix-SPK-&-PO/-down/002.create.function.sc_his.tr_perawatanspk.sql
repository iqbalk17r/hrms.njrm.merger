-- DROP FUNCTION sc_his.tr_perawatanspk();

CREATE OR REPLACE FUNCTION sc_his.tr_perawatanspk()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/06/2019
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);
begin    

	IF TG_OP ='INSERT' THEN 

		IF (new.status='I') THEN 

		END IF;
	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN
			/* NO RESOURCE UPDATE */
		if (new.status='E' and old.status='A') then
		
			insert into sc_tmp.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp,laporanpk,laporanpsp,laporanksp)
			(select new.updateby,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'E' as status,inputdate,inputby,updatedate,updateby,new.nodok,laporanpk,laporanpsp,laporanksp from sc_his.perawatanspk where nodok=new.nodok);

			insert into sc_tmp.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select new.updateby,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_his.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_tmp.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select new.updateby,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'E' as status,exppn,pkp,ndpp,nppn from sc_his.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_tmp.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select new.updateby,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_his.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');
		elseif (new.status='E' and old.status='A1') then
		
			insert into sc_tmp.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp,laporanpk,laporanpsp,laporanksp)
			(select new.updateby,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'E' as status,inputdate,inputby,updatedate,updateby,new.nodok,laporanpk,laporanpsp,laporanksp from sc_his.perawatanspk where nodok=new.nodok);

			insert into sc_tmp.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select new.updateby,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_his.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_tmp.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select new.updateby,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'E' as status,exppn,pkp,ndpp,nppn from sc_his.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_tmp.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select new.updateby,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_his.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');	

		elseif (new.status='E' and old.status='P') then
		
			insert into sc_tmp.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp,laporanpk,laporanpsp,laporanksp)
			(select new.updateby,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'XE' as status,inputdate,inputby,updatedate,updateby,new.nodok,laporanpk,laporanpsp,laporanksp from sc_his.perawatanspk where nodok=new.nodok);

			insert into sc_tmp.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select new.updateby,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_his.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_tmp.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select new.updateby,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'E' as status,exppn,pkp,ndpp,nppn from sc_his.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_tmp.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select new.updateby,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_his.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');	

		elseif (new.status='E' and old.status='AF1') then
		
			insert into sc_tmp.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp,laporanpk,laporanpsp,laporanksp)
			(select new.updateby,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'XE' as status,inputdate,inputby,updatedate,updateby,new.nodok,laporanpk,laporanpsp,laporanksp from sc_his.perawatanspk where nodok=new.nodok);

			insert into sc_tmp.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select new.updateby,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_his.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_tmp.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select new.updateby,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'E' as status,exppn,pkp,ndpp,nppn from sc_his.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_tmp.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select new.updateby,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_his.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');	

		elseif (new.status='IP' and old.status='P') then
	
			insert into sc_tmp.perawatanspk_pembayaran 
			(nodok,nodokref,tgl,tipe_pembayaran,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,status,nodoktmp)
			(select new.updateby,nodokref,now()::date,'TUNAI',keterangan,ttlservis,ttldiskon,ttldpp,ttlppn,ttlnetto,jnsperawatanref,now(),new.updateby,now(),new.updateby,'E',new.nodok from sc_his.perawatanspk where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');	

		end if;
	
	RETURN NEW;
	END IF;
   
    return new;
        
end;
$function$
;
