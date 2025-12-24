-- DROP FUNCTION sc_tmp.tr_perawatanasset();

CREATE OR REPLACE FUNCTION sc_tmp.tr_perawatanasset()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/07/2017
--update by Fiky ::18/10/2018
--update case ::perubahan hanya approval 1
	vr_nomor char(12); 
	vr_cekprefix char(4);
	vr_nowprefix char(4);
	vr_lastdoc numeric;
begin    

	IF TG_OP ='INSERT' THEN 

		IF (new.status='I') THEN 
		--select * from sc_his.perawatanasset
		--select * from sc_his.perawatanasset
		--select * from sc_mst.nomor
		--delete from sc_his.perawatanasset
		--select * from sc_mst.penomoran
			delete from sc_mst.penomoran where userid=new.nodok;
			delete from sc_mst.trxerror where userid=new.nodok;  

			
/*
			select case 
			when max((right(trim(nodok),4))) is null or max((right(trim(nodok),4)))='' then '0'::numeric
			else max((right(trim(nodok),4)))::numeric end lastdoc
			from sc_his.perawatanasset
			where to_char(tgldok,'yyyymm')='201801';

			
			select * from sc_mst.nomor
			--update sc_mst.nomor set prefiX='PAS1801' where dokumen='PERAWATAN-ASSET';
			select trim(split_part(trim(prefix),'PAS',2)) as cekprefix from sc_mst.nomor where dokumen='PERAWATAN-ASSET';
			select to_char(tgldok,'YYMM') as cekbulan into vr_nowprefix  from sc_tmp.perawatanasset where nodok=new.nodok ;
			
			if(vr_nowprefix<>vr_cekprefix) then 
				update sc_mst.nomor set prefix='PAS'||vr_nowprefix,docno=0 where dokumen='PERAWATAN-ASSET';
			end if;
*/
			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.nodok,'PERAWATAN-ASSET',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok and dokumen='PERAWATAN-ASSET';
			---select * from sc_mst.penomoran where dokumen='PERAWATAN-ASSET';

			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,status,
			inputdate,inputby,updatedate,updateby,km_awal,km_akhir)
			(select vr_nomor,dokref,kdgroup,kdsubgroup,stockcode,descbarang,
			(select coalesce(userpakai,'') as nikpakai from sc_mst.mbarang where kdgroup=new.kdgroup and kdsubgroup=new.kdsubgroup and nodok=new.stockcode),
			nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,'A' as status,
			inputdate,inputby,updatedate,updateby,km_awal,km_akhir from sc_tmp.perawatanasset where nodok=new.nodok);
				
			delete from sc_mst.trxerror where userid=new.nodok and modul='PERAWATANASSET';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','PERAWATANASSET');

			delete from sc_tmp.perawatanasset where nodok=new.nodok;

			
		END IF;
	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN
			/* NO RESOURCE UPDATE */
		if (new.status='F' and old.status='E') then
			delete from sc_his.perawatanasset where nodok=new.nodoktmp;
		
			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,nodoktmp,status,km_awal,km_akhir)
			(select nodoktmp,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,'','A' AS status,km_awal,km_akhir from sc_tmp.perawatanasset where nodok=new.nodok);	

			delete from sc_tmp.perawatanasset where nodok=new.nodok;
		elseif (new.status='F' and old.status='C') then
			delete from sc_his.perawatanasset where nodok=new.nodoktmp;
		
			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,nodoktmp,status,km_awal,km_akhir)
			(select nodoktmp,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,'','C' AS status,km_awal,km_akhir from sc_tmp.perawatanasset where nodok=new.nodok);	

			delete from sc_tmp.perawatanasset where nodok=new.nodok;	
		elseif (new.status='F' and old.status='A') then
			delete from sc_his.perawatanasset where nodok=new.nodoktmp;
		
			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,nodoktmp,status,km_awal,km_akhir)
			(select nodoktmp,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,'','P' AS status,km_awal,km_akhir from sc_tmp.perawatanasset where nodok=new.nodok);	

			delete from sc_tmp.perawatanasset where nodok=new.nodok;
		elseif (new.status='F' and old.status='A1') then
			delete from sc_his.perawatanasset where nodok=new.nodoktmp;
		
			insert into sc_his.perawatanasset 
			(nodok,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,nodoktmp,status,km_awal,km_akhir)
			(select nodoktmp,dokref,kdgroup,kdsubgroup,stockcode,descbarang,nikpakai,nikmohon,jnsperawatan,tgldok,keterangan,laporanpk,laporanpsp,laporanksp,
			inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,'','P' AS status,km_awal,km_akhir from sc_tmp.perawatanasset where nodok=new.nodok);	

			delete from sc_tmp.perawatanasset where nodok=new.nodok;	
		end if;
			
	RETURN NEW;
	END IF;
/*

select * from sc_mst.nomor
insert into sc_mst.nomor VALUES
('PERAWATAN-ASSET','',4,'PAS1706','',0,'66666','','201606','T')
--delete from sc_mst.nomor where dokumen='PERAWATAN-ASSET';
*/
     
    
    return new;
        
end;
$function$
;
