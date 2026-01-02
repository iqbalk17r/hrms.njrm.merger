-- Active: 1766459170620@@192.168.101.62@5432@HRMS.NSNJRM
-- DROP FUNCTION sc_trx.tr_editfinalrekapum();

CREATE OR REPLACE FUNCTION sc_trx.tr_editfinalrekapum()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare

     vr_kdcabang char(30);
     vr_nodok char(30);
     vr_dokref char(30);

begin

	if (old.status='P')and(new.status='E') then
	select kdcabang,nodok,dokref from sc_trx.rekap_um into vr_kdcabang,vr_nodok,vr_dokref where nodok=new.nodok and status='E';

	insert into sc_tmp.rekap_um (branch,nodok,dokref,kdcabang,tgldok,tglawal,tglakhir,status,nominal,keterangan)
	(select branch,vr_nodok,vr_dokref,kdcabang,tgldok,tglawal,tglakhir,'E' as status,nominal,keterangan from sc_trx.rekap_um where nodok=new.nodok and status='E');

	insert into sc_tmp.master_um (branch,nik,kdcabang,nodok,dokref,tgl,status,total,uangmkn,potongan,sewa,lembur_um,keterangan)
	(select branch,nik,kdcabang,vr_nodok,vr_dokref,tgl,'E' as status,total,uangmkn,potongan,sewa,lembur_um,keterangan from sc_trx.master_um where nodok=vr_dokref);

	insert into sc_tmp.uangmakan (branch,nodok,nik,kdcabang,dokref,tgl,checkin,checkout,nominal,keterangan,status)
	(select branch,vr_nodok,nik,kdcabang,vr_dokref,tgl,checkin,checkout,nominal,keterangan,'E' as status from sc_trx.detail_um where nodok=vr_dokref);

	insert into sc_tmp.komplembur_um (branch,nik,kdcabang,nodok,dokref,tglawal,tglakhir,status,flag,nominal,keterangan,jamawal,jamakhir)
	(select branch,nik,kdcabang,vr_nodok,vr_dokref,tglawal,tglakhir,'E' as status,flag,nominal,keterangan,jamawal,jamakhir from sc_trx.komplembur_um where nodok=vr_dokref);

	insert into sc_tmp.potongan_um (branch,nik,kdcabang,nodok,dokref,doktype,tgl,status,flag,nominal,jam_istirahat_in,jam_istirahat_out,keterangan,durasi_ist)
	(select branch,nik,kdcabang,vr_nodok,vr_dokref,doktype,tgl,'E' as status,flag,nominal,jam_istirahat_in,jam_istirahat_out,keterangan,durasi_ist from sc_trx.potongan_um where nodok=vr_dokref);

	delete from sc_trx.rekap_um where dokref=vr_dokref and branch=new.branch;
	delete from sc_trx.master_um where nodok=vr_dokref and branch=new.branch;
	delete from sc_trx.potongan_um where nodok=vr_dokref and branch=new.branch;
	delete from sc_trx.komplembur_um where nodok=vr_dokref and branch=new.branch;
	delete from sc_trx.detail_um where nodok=vr_dokref and branch=new.branch;

	end if;
return new;

end;
$function$
;


-- DROP FUNCTION sc_tmp.tr_rekap_um();

CREATE OR REPLACE FUNCTION sc_tmp.tr_rekap_um()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare

     vr_nomor char(30);
     vr_nodok char(30);
     vr_dokref char(30);
     vr_kdcabang char(30);

begin


/*select * from sc_mst.nomor
	AUTHOR FIKY ASHARIZA:
	CREATE DATE: 24/05/2017
	UPDATE DATE: 15/08/2019
	TITLE: PENAMBAHAN FORMAT 1 & FORMAT 2 PERUBAHAN PADA UANG KEHADIRAN
*/

 if (old.status='I' and new.status='P') then
	delete from sc_mst.penomoran where userid=new.nodok;
	insert into sc_mst.penomoran
		(userid,dokumen,nomor,errorid,partid,counterid,xno)
		values(new.nodok,'UANGMAKAN',' ',0,' ',1,0);

	vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
	update sc_tmp.master_um a set keterangan=b.keterangan||''||case
	when coalesce(b.potongan,0)>0 then ' -POTONGAN UM '
	else ''  end from sc_tmp.master_um b
	where a.branch=b.branch and a.nodok=new.nodok and a.nik=b.nik and a.tgl=b.tgl ;

	update sc_tmp.master_um a set keterangan=b.keterangan||''||case
	when coalesce(b.lembur_um,0)>0 then ' +UANG KEHADIRAN'
	else ''  end from sc_tmp.master_um b
	where a.branch=b.branch and a.nodok=new.nodok and a.nik=b.nik and a.tgl=b.tgl ;

	update sc_tmp.master_um a set keterangan=b.keterangan||''||case
	when coalesce(b.sewa,0)>0 then ' +SEWA KENDARAAN'
	else ''  end from sc_tmp.master_um b
	where a.branch=b.branch and a.nodok=new.nodok and a.nik=b.nik and a.tgl=b.tgl ;
	--select * from sc_tmp.master_um
	--select * from sc_tmp.uang_makan
	insert into sc_trx.detail_um
	(branch,nodok,nik,kdcabang,dokref,tgl,checkin,checkout,nominal,keterangan)
	(select branch,vr_nomor,nik,kdcabang,dokref,tgl,checkin,checkout,nominal,keterangan from sc_tmp.uangmakan where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.komplembur_um
	(branch,nik,kdcabang,nodok,dokref,tglawal,tglakhir,status,flag,nominal,keterangan,jamawal,jamakhir)
	(select branch,nik,kdcabang,vr_nomor,dokref,tglawal,tglakhir,'P' as status,flag,nominal,keterangan,jamawal,jamakhir from sc_tmp.komplembur_um where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.potongan_um
	(branch,nik,kdcabang,nodok,dokref,doktype,tgl,status,flag,nominal,jam_istirahat_in,jam_istirahat_out,keterangan,durasi_ist)
	(select branch,nik,kdcabang,vr_nomor,dokref,doktype,tgl,'P' as status,flag,nominal,jam_istirahat_in,jam_istirahat_out,keterangan,durasi_ist from sc_tmp.potongan_um where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.master_um
	(branch,nik,kdcabang,nodok,dokref,tgl,status,total,uangmkn,potongan,sewa,lembur_um,keterangan)
	(select branch,nik,kdcabang,vr_nomor,dokref,tgl,'P' as status,total,uangmkn,potongan,sewa,lembur_um,keterangan from sc_tmp.master_um where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.rekap_um
	(branch,nodok,dokref,kdcabang,tgldok,tglawal,tglakhir,status,nominal,keterangan)
	(select branch,vr_nomor,dokref,kdcabang,tgldok,tglawal,tglakhir,'P' as status,nominal,keterangan from sc_tmp.rekap_um where nodok=new.nodok and branch=new.branch);

	delete from sc_tmp.rekap_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.master_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.potongan_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.komplembur_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.uangmakan where nodok=new.nodok and branch=new.branch;
elseif(old.status='E' and new.status='P') then
	select kdcabang,nodok,dokref from sc_tmp.rekap_um into vr_kdcabang,vr_nodok,vr_dokref where nodok=new.nodok and status=new.status;
	--select * from sc_tmp.rekap_um
	--select * from sc_tmp.master_um
	update sc_tmp.master_um a set keterangan=b.keterangan||''||case
	when coalesce(b.potongan,0)>0 then ' -POTONGAN UM '
	else ''  end from sc_tmp.master_um b
	where a.branch=b.branch and a.nodok=new.nodok and a.nik=b.nik and a.tgl=b.tgl ;

	update sc_tmp.master_um a set keterangan=b.keterangan||''||case
	when coalesce(b.lembur_um,0)>0 then ' +UANG KEHADIRAN'
	else ''  end from sc_tmp.master_um b
	where a.branch=b.branch and a.nodok=new.nodok and a.nik=b.nik and a.tgl=b.tgl ;

	update sc_tmp.master_um a set keterangan=b.keterangan||''||case
	when coalesce(b.sewa,0)>0 then ' +SEWA KENDARAAN'
	else ''  end from sc_tmp.master_um b
	where a.branch=b.branch and a.nodok=new.nodok and a.nik=b.nik and a.tgl=b.tgl ;
	--select * from sc_tmp.master_um
	--select * from sc_tmp.uang_makan
	insert into sc_trx.detail_um
	(branch,nodok,nik,kdcabang,dokref,tgl,checkin,checkout,nominal,keterangan)
	(select branch,vr_dokref,nik,kdcabang,vr_nodok,tgl,checkin,checkout,nominal,keterangan from sc_tmp.uangmakan where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.komplembur_um
	(branch,nik,kdcabang,nodok,dokref,tglawal,tglakhir,status,flag,nominal,keterangan,jamawal,jamakhir)
	(select branch,nik,kdcabang,vr_dokref,vr_nodok,tglawal,tglakhir,'P' as status,flag,nominal,keterangan,jamawal,jamakhir from sc_tmp.komplembur_um where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.potongan_um
	(branch,nik,kdcabang,nodok,dokref,doktype,tgl,status,flag,nominal,jam_istirahat_in,jam_istirahat_out,keterangan,durasi_ist)
	(select branch,nik,kdcabang,vr_dokref,vr_nodok,doktype,tgl,'P' as status,flag,nominal,jam_istirahat_in,jam_istirahat_out,keterangan,durasi_ist from sc_tmp.potongan_um where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.master_um
	(branch,nik,kdcabang,nodok,dokref,tgl,status,total,uangmkn,potongan,sewa,lembur_um,keterangan)
	(select branch,nik,kdcabang,vr_dokref,vr_nodok,tgl,'P' as status,total,uangmkn,potongan,sewa,lembur_um,keterangan from sc_tmp.master_um where nodok=new.nodok and branch=new.branch);

	insert into sc_trx.rekap_um
	(branch,nodok,dokref,kdcabang,tgldok,tglawal,tglakhir,status,nominal,keterangan)
	(select branch,vr_dokref,vr_nodok,kdcabang,tgldok,tglawal,tglakhir,'P' as status,nominal,keterangan from sc_tmp.rekap_um where nodok=new.nodok and branch=new.branch);

	delete from sc_tmp.rekap_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.master_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.potongan_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.komplembur_um where nodok=new.nodok and branch=new.branch;
	delete from sc_tmp.uangmakan where nodok=new.nodok and branch=new.branch;

end if;

return new;

end;
$function$
;

-- DROP FUNCTION sc_tmp.tr_master_um();

CREATE OR REPLACE FUNCTION sc_tmp.tr_master_um()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE 
	--title: triger master um ke rekap um
	--author by fiky: 23/05/2017
	--update by fiky: 23/05/2017
    vr_tglawal date;
    vr_tglakhir date;
    
BEGIN		
	IF tg_op = 'INSERT' THEN
		vr_tglawal:=min(tgl) from sc_tmp.master_um where nodok=new.nodok and branch=new.branch;
		vr_tglakhir:=max(tgl) from sc_tmp.master_um where nodok=new.nodok and branch=new.branch;
		IF NEW.STATUS='I' THEN
			if not exists(select * from sc_tmp.rekap_um where nodok=new.nodok and branch=new.branch) then
				insert into sc_tmp.rekap_um (branch,nodok,dokref,kdcabang,tgldok,tglawal,tglakhir,status,nominal,keterangan)
				values
				(new.branch,new.nodok,'',(select trim(kdcabang) from sc_mst.karyawan where nik=new.nik),to_char(now(),'yyyy-mm-dd')::date,vr_tglawal,vr_tglakhir,'I',0,'');
			end if;
				update sc_tmp.rekap_um set nominal=(select sum(total) from sc_tmp.master_um 
				where nodok=new.nodok and branch=new.branch ),tglawal=vr_tglawal,tglakhir=vr_tglakhir
				where nodok=new.nodok and branch=new.branch;
		ELSEIF NEW.STATUS='E' THEN
				update sc_tmp.rekap_um set nominal=(select sum(total) from sc_tmp.master_um 
				where nodok=new.nodok and branch=new.branch ),tglawal=vr_tglawal,tglakhir=vr_tglakhir
				where nodok=new.nodok and branch=new.branch;
		END IF;
		RETURN new;
	ELSEIF tg_op = 'UPDATE'	 THEN
		vr_tglawal:=min(tgl) from sc_tmp.master_um where nodok=new.nodok and branch=new.branch;
		vr_tglakhir:=max(tgl) from sc_tmp.master_um where nodok=new.nodok and branch=new.branch;
		IF NEW.STATUS='I' THEN
			if not exists(select * from sc_tmp.rekap_um where nodok=new.nodok and branch=new.branch) then
				insert into sc_tmp.rekap_um (branch,nodok,dokref,kdcabang,tgldok,tglawal,tglakhir,status,nominal,keterangan)
				values
				(new.branch,new.nodok,'',(select trim(kdcabang) from sc_mst.karyawan where nik=new.nik),to_char(now(),'yyyy-mm-dd')::date,vr_tglawal,vr_tglakhir,'I',0,'');
			end if;
				update sc_tmp.rekap_um set nominal=(select sum(total) from sc_tmp.master_um 
				where nodok=new.nodok and branch=new.branch ),tglawal=vr_tglawal,tglakhir=vr_tglakhir
				where nodok=new.nodok and branch=new.branch;
		ELSEIF NEW.STATUS='E' THEN
				update sc_tmp.rekap_um set nominal=(select sum(total) from sc_tmp.master_um 
				where nodok=new.nodok and branch=new.branch ),tglawal=vr_tglawal,tglakhir=vr_tglakhir
				where nodok=new.nodok and branch=new.branch;
		END IF;
		RETURN new;
	ELSEIF tg_op = 'DELETE' THEN
		if exists(select * from sc_tmp.rekap_um where nodok=old.nodok and branch=old.branch ) then
			update sc_tmp.rekap_um set nominal=(select sum(total) from sc_tmp.master_um 
			where nodok=old.nodok and branch=old.branch )
			where nodok=old.nodok and branch=old.branch;
		end if; 
		RETURN old;
	END IF;
	
END;
$function$
;





  
-- sc_tmp.master_um definition

-- Drop table

-- DROP TABLE sc_tmp.master_um;

CREATE TABLE sc_tmp.master_um (
	branch bpchar(6) NOT NULL,
	nik bpchar(20) NOT NULL,
	kdcabang bpchar(20) NULL,
	nodok bpchar(20) NOT NULL,
	dokref bpchar(20) NULL,
	tgl date NOT NULL,
	status bpchar(4) NULL,
	total numeric(18, 2) NULL,
	uangmkn numeric(18, 2) NULL,
	potongan numeric(18, 2) NULL,
	sewa numeric(18, 2) NULL,
	lembur_um numeric(18, 2) NULL,
	keterangan text NULL,
	CONSTRAINT master_um_pkey PRIMARY KEY (branch, nodok, nik, tgl)
);

-- Table Triggers

create trigger tr_master_um after
insert
    or
delete
    or
update
    on
    sc_tmp.master_um for each row execute procedure sc_tmp.tr_master_um();
 
   
-- sc_trx.master_um definition

-- Drop table

-- DROP TABLE sc_trx.master_um;

CREATE TABLE sc_trx.master_um (
	branch bpchar(6) NOT NULL,
	nik bpchar(20) NOT NULL,
	kdcabang bpchar(20) NULL,
	nodok bpchar(20) NOT NULL,
	dokref bpchar(20) NULL,
	tgl date NOT NULL,
	status bpchar(4) NULL,
	total numeric(18, 2) NULL,
	uangmkn numeric(18, 2) NULL,
	potongan numeric(18, 2) NULL,
	sewa numeric(18, 2) NULL,
	lembur_um numeric(18, 2) NULL,
	keterangan text NULL,
	CONSTRAINT master_um_pkey PRIMARY KEY (branch, nodok, nik, tgl)
);   
   
 -- sc_trx.detail_um definition

-- Drop table

-- DROP TABLE sc_trx.detail_um;

CREATE TABLE sc_trx.detail_um (
	branch bpchar(6) NOT NULL,
	nodok bpchar(23) NOT NULL,
	nik bpchar(12) NOT NULL,
	kdcabang bpchar(20) NULL,
	dokref bpchar(25) NULL,
	tgl date NOT NULL,
	checkin time NULL,
	checkout time NULL,
	nominal numeric NULL,
	keterangan text NULL,
	status bpchar(4) NULL,
	CONSTRAINT detail_um_pkey PRIMARY KEY (branch, nodok, nik, tgl)
);
   
   
-- sc_tmp.rekap_um definition

-- Drop table

-- DROP TABLE sc_tmp.rekap_um;

CREATE TABLE sc_tmp.rekap_um (
	branch bpchar(6) NOT NULL,
	nodok bpchar(20) NOT NULL,
	dokref bpchar(20) NULL,
	kdcabang bpchar(20) NULL,
	tgldok date NULL,
	tglawal date NULL,
	tglakhir date NULL,
	status bpchar(4) NULL,
	nominal numeric(18, 2) NULL,
	keterangan text NULL,
	CONSTRAINT rekap_um_pkey PRIMARY KEY (branch, nodok)
);

-- Table Triggers

create trigger tr_rekap_um after
update
    on
    sc_tmp.rekap_um for each row execute procedure sc_tmp.tr_rekap_um();
   
   
 -- sc_trx.rekap_um definition

-- Drop table

-- DROP TABLE sc_trx.rekap_um;

CREATE TABLE sc_trx.rekap_um (
	branch bpchar(6) NOT NULL,
	nodok bpchar(20) NOT NULL,
	dokref bpchar(20) NULL,
	kdcabang bpchar(20) NULL,
	tgldok date NULL,
	tglawal date NULL,
	tglakhir date NULL,
	status bpchar(4) NULL,
	nominal numeric(18, 2) NULL,
	keterangan text NULL,
	CONSTRAINT rekap_um_pkey PRIMARY KEY (branch, nodok)
);

-- Table Triggers

create trigger tr_editfinalrekapum after
update
    on
    sc_trx.rekap_um for each row execute procedure sc_trx.tr_editfinalrekapum(); 