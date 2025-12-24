-- DROP FUNCTION sc_tmp.tr_perawatanspk();

CREATE OR REPLACE FUNCTION sc_tmp.tr_perawatanspk()
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
			/* NO RESOURCE UPDATE */
		if (new.status='F' and old.status='I') then
		
			delete from sc_mst.penomoran where userid=new.nodok;
			delete from sc_mst.trxerror where userid=new.nodok;  

			select trim(split_part(trim(prefix),'PSPK',2)) as cekprefix into vr_cekprefix from sc_mst.nomor where dokumen='PERAWATAN-ASSET';
			select to_char(now(),'YYMM') as cekbulan into vr_nowprefix;
			if(vr_nowprefix<>vr_cekprefix) then 
				update sc_mst.nomor set prefix='PSPK'||vr_nowprefix,docno=0 where dokumen='PERAWATAN-ASSET';
			end if;
			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.nodok,'PERAWATAN-SPK',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;

			insert into sc_his.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp)
			(select vr_nomor,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'A1' as status,inputdate,inputby,updatedate,updateby,nodoktmp from sc_tmp.perawatanspk where nodok=new.nodok);

			insert into sc_his.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select vr_nomor,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_tmp.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_his.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select vr_nomor,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'A' as status,exppn,pkp,ndpp,nppn from sc_tmp.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_his.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select vr_nomor,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_tmp.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');

			delete from sc_tmp.perawatanspk where nodok=new.nodok;
			delete from sc_tmp.perawatan_mst_lampiran where nodok=new.nodok;
			delete from sc_tmp.perawatan_detail_lampiran where nodok=new.nodok;
			delete from sc_tmp.perawatan_lampiran where nodok=new.nodok;

		elseif (new.status='F' and old.status='E') then
			vr_statustx:= coalesce(status,'') from sc_his.perawatanspk where nodok=new.nodoktmp;
			
			delete from sc_his.perawatanspk where nodok=new.nodoktmp;
			delete from sc_his.perawatan_mst_lampiran where nodok=new.nodoktmp;
			delete from sc_his.perawatan_detail_lampiran where nodok=new.nodoktmp;
			delete from sc_his.perawatan_lampiran where nodok=new.nodoktmp;
				
			insert into sc_his.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp)
			(select new.nodoktmp,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'A1' as status,inputdate,inputby,updatedate,updateby,nodoktmp from sc_tmp.perawatanspk where nodok=new.nodok);

			insert into sc_his.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select new.nodoktmp,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_tmp.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_his.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select new.nodoktmp,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'A' as status,exppn,pkp,ndpp,nppn from sc_tmp.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_his.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select new.nodoktmp,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_tmp.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');

			delete from sc_tmp.perawatanspk where nodok=new.nodok;
			delete from sc_tmp.perawatan_mst_lampiran where nodok=new.nodok;
			delete from sc_tmp.perawatan_detail_lampiran where nodok=new.nodok;
			delete from sc_tmp.perawatan_lampiran where nodok=new.nodok;
			
		elseif (new.status='F' and old.status='C') then
			delete from sc_his.perawatanasset where nodok=new.nodoktmp;
		
			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,nodoktmp,status)
			(select nodoktmp,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,'','C' AS status from sc_tmp.perawatanasset where nodok=new.nodok);	

			delete from sc_tmp.perawatanasset where nodok=new.nodok;	
		elseif (new.status='F' and old.status='A') then
			delete from sc_his.perawatanasset where nodok=new.nodoktmp;
		
			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,nodoktmp,status)
			(select nodoktmp,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,'','A1' AS status from sc_tmp.perawatanasset where nodok=new.nodok);	

			delete from sc_tmp.perawatanasset where nodok=new.nodok;
		elseif (new.status='F' and old.status='XE') then
			vr_statustx:= coalesce(status,'') from sc_his.perawatanspk where nodok=new.nodoktmp;
			
			delete from sc_his.perawatanspk where nodok=new.nodoktmp;
			delete from sc_his.perawatan_mst_lampiran where nodok=new.nodoktmp;
			delete from sc_his.perawatan_detail_lampiran where nodok=new.nodoktmp;
			delete from sc_his.perawatan_lampiran where nodok=new.nodoktmp;
				
			insert into sc_his.perawatanspk 
			(nodok,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,status,inputdate,inputby,updatedate,updateby,nodoktmp)
			(select new.nodoktmp,nodokref,descbarang,kdgroup,kdsubgroup,stockcode,kdbengkel,kdsubbengkel,upbengkel,jnsperawatan,jnsperawatanref,tgldok,tglawal,
			tglakhir,km_awal,km_akhir,ttlservis,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,typeservis,keterangan,'AF1' as status,inputdate,inputby,updatedate,updateby,nodoktmp from sc_tmp.perawatanspk where nodok=new.nodok);

			insert into sc_his.perawatan_mst_lampiran
			(nodok,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,status)
			(select new.nodoktmp,nodokref,id,idfaktur,tgl,keterangan,nservis,ndiskon,ndpp,nppn,nnetto,jnsperawatan,inputdate,inputby,updatedate,updateby,ref_type,'A' as status from sc_tmp.perawatan_mst_lampiran where nodok=new.nodok);

			insert into sc_his.perawatan_detail_lampiran
			(nodok,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,status,exppn,pkp,ndpp,nppn)
			(select new.nodoktmp,nodokref,idfaktur,id,keterangan,nservis,ndiskon,nnetto,typeservis,inputdate,inputby,updatedate,updateby,ref_type,'A' as status,exppn,pkp,ndpp,nppn from sc_tmp.perawatan_detail_lampiran where nodok=new.nodok);
			
			insert into sc_his.perawatan_lampiran
			(nodok,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type)
			(select new.nodoktmp,nodokref,idfaktur,id,file_name,file_type,full_path,orig_name,file_ext,file_size,keterangan,typeservis,inputdate,inputby,updatedate,updateby,ref_type from sc_tmp.perawatan_lampiran where nodok=new.nodok);

			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATAN-SPK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATAN-SPK');

			delete from sc_tmp.perawatanspk where nodok=new.nodok;
			delete from sc_tmp.perawatan_mst_lampiran where nodok=new.nodok;
			delete from sc_tmp.perawatan_detail_lampiran where nodok=new.nodok;
			delete from sc_tmp.perawatan_lampiran where nodok=new.nodok;
		end if;
	
	RETURN NEW;
	END IF;
  
    return new;
        
end;
$function$
;
