create OR REPLACE function sc_trx.pr_capture_approvals_system() returns SETOF void
    language plpgsql
as
$$
    --author by : Fiky Ashariza 01-01-2020
--update by : Capturing Module on 1 Tabels
DECLARE
    vr_deskripsi text;
/*
insert into sc_mst.trxtype
(kdtrx,jenistrx,uraian)
values
('PSPB','mob_approvals','PERMINTAAN PEMBELIAN'),
('PMST','mob_approvals','PO MST OSIN'),
('BBMP','mob_approvals','BBM PO'),
('UMMK','mob_approvals','UANG MAKAN'),
('PSAS','mob_approvals','PERAWATAN ASSET'),
('ASKD','mob_approvals','ASURANSI KENDARAAN'),
('STNK','mob_approvals','PERPANJANGAN STNKB'),
('SIMX','mob_approvals','PERPANJANGAN SIM'),
('BBMK','mob_approvals','BAHAN BAKAR KENDARAAN'),
('SWKB','mob_approvals','SEWA KENDARAAN'),
('MCTI','mob_approvals','CUTI KARYAWAN'),
('MIJN','mob_approvals','IJIN KARYAWAN'),
('MLBR','mob_approvals','LEMBUR KARYAWAN'),
('MDNS','mob_approvals','DINAS KARYAWAN');

*/
    DECLARE vr_type char(10);
BEGIN


    /* ('MCTI','mob_approvals','CUTI KARYAWAN'), */
    insert into sc_trx.approvals_system
    (docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,
     description,
     status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname,erptype,branch)
        (
            select nodok as docno,tgl_dok as docdate, nik as docref,'MCTI' as doctype,'CUTI KARYAWAN' as doctypename,''::text kdgroup,''::text kdsubgroup,''::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,'' as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,0 as ttlnetto,
                   '
                   Nomor Dokumen : '||coalesce(nodok,'')||'
Nama          : '||coalesce(nmlengkap,'')||'
Jumlah Cuti   : '||coalesce(jumlah_cuti,0)||' hari
Tanggal       : '||to_char(tgl_mulai,'dd-mm-yyyy')||' s/d
                '||to_char(tgl_selesai,'dd-mm-yyyy')||'
Keterangan    : '||coalesce(keterangan,'') as deskription,
                   'A' as status,status as asstatus,input_date as inputdate,input_by as inputby,update_date as updatedate,update_by as updateby,null as approvaldate,null as approvalby,cancel_date as canceldate,cancel_by as cancelby,null as docnotmp,'sc_trx.cuti_karyawan' as tabelname,'sc_trx.approvals_system' as astabelname,'HRMS' as erptype,branch as branch from
                (select a.*,b.branch,dx.nmlengkap from sc_trx.cuti_karyawan a
                                                           left outer join sc_mst.branch b on coalesce(cdefault,'')='YES'
                                                           left outer join sc_mst.karyawan dx on a.nik=dx.nik
                )  as x
            where nodok in (select nodok from sc_trx.cuti_karyawan where coalesce(status,'') in ('A') and to_char(tgl_dok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '3 month')::date)::text and (now()::date)::text )
              and nodok not in (select docno from sc_trx.approvals_system)
        );


/* ('MIJN','mob_approvals','IJIN KARYAWAN'), */
    insert into sc_trx.approvals_system
    (docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,
     description,
     status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname,erptype,branch)
        (
            select nodok as docno,tgl_dok as docdate, nik as docref,'MIJN' as doctype,'IJIN KARYAWAN' as doctypename,''::text kdgroup,''::text kdsubgroup,''::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,'' as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,0 as ttlnetto,
                   '
                   Nomor Dokumen : '||coalesce(nodok,'')||'
Nama          : '||coalesce(nmlengkap,'')||'
Tanggal       : '||to_char(tgl_kerja,'dd-mm-yyyy')||'
Jam           : '||coalesce(tgl_jam_mulai::text,'')||' - '||coalesce(tgl_jam_selesai::text,'')||'
Kategori      : '||coalesce(nmijin_absensi,'')||'
Type Ijin     : '||coalesce(typeijin,'')||'
Keterangan    : '||coalesce(keterangan,'') as deskription,
                   'A' as status,status as asstatus,input_date as inputdate,input_by as inputby,update_date as updatedate,update_by as updateby,null as approvaldate,null as approvalby,cancel_date as canceldate,cancel_by as cancelby,null as docnotmp,'sc_trx.ijin_karyawan' as tabelname,'sc_trx.approvals_system' as astabelname,'HRMS' as erptype,branch as branch from
                (select a.*,b.branch,dx.nmlengkap,dy.nmijin_absensi,case when a.type_ijin='PB' then 'PRIBADI' when a.type_ijin='DN' then 'DINAS' end as typeijin from sc_trx.ijin_karyawan a
                                                                                                                                                                          left outer join sc_mst.branch b on coalesce(cdefault,'')='YES'
                                                                                                                                                                          left outer join sc_mst.karyawan dx on a.nik=dx.nik
                                                                                                                                                                          left outer join sc_mst.ijin_absensi dy on a.kdijin_absensi=dy.kdijin_absensi
                )  as x
            where nodok in (select nodok from sc_trx.ijin_karyawan where coalesce(status,'') in ('A') and to_char(tgl_dok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '3 month')::date)::text and (now()::date)::text )
              and nodok not in (select docno from sc_trx.approvals_system)
        );

/* ('MDNS','mob_approvals','DINAS KARYAWAN'), */
    insert into sc_trx.approvals_system
    (docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,
     description,
     status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname,erptype,branch)
        (
            select nodok as docno,tgl_dok as docdate, nik as docref,'MDNS' as doctype,'DINAS KARYAWAN' as doctypename,''::text kdgroup,''::text kdsubgroup,''::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,'' as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,0 as ttlnetto,
                   '
                   Nomor Dokumen : '||coalesce(nodok,'')||'
Nama          : '||coalesce(nmlengkap,'')||'
Tgl Dokumen   : '||to_char(tgl_dok,'dd-mm-yyyy')||'
Kategori      : '||coalesce(nmkategori::text,'')||'
Tanggal       : '||to_char(tgl_mulai,'dd-mm-yyyy')||' s/d
                '||to_char(tgl_selesai,'dd-mm-yyyy')||'
Tujuan        : '||coalesce(tujuan,'')||'
Keperluan     : '||coalesce(keperluan,'') as description,
                   'A' as status,status as asstatus,input_date as inputdate,input_by as inputby,update_date as updatedate,update_by as updateby,null as approvaldate,null as approvalby,cancel_date as canceldate,cancel_by as cancelby,null as docnotmp,'sc_trx.dinas' as tabelname,'sc_trx.approvals_system' as astabelname,'HRMS' as erptype,branch as branch from
                (select a.*,b.branch,dx.nmlengkap,dy.nmkategori from sc_trx.dinas a
                                                                         left outer join sc_mst.branch b on coalesce(cdefault,'')='YES'
                                                                         left outer join sc_mst.karyawan dx on a.nik=dx.nik
                                                                         left outer join sc_mst.kategori dy on a.kdkategori=dy.kdkategori and dy.typekategori='DINAS'
                )  as x
            where nodok in (select nodok from sc_trx.dinas where coalesce(status,'') in ('A') and to_char(tgl_dok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '3 month')::date)::text and (now()::date)::text )
              and nodok not in (select docno from sc_trx.approvals_system)
        );


/* ('MLBR','mob_approvals','LEMBUR'), */
    insert into sc_trx.approvals_system
    (docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,
     description,
     status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname,erptype,branch)
        (
            select nodok as docno,tgl_dok as docdate, nik as docref,'MLBR' as doctype,'LEMBUR' as doctypename,''::text kdgroup,''::text kdsubgroup,''::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,'' as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,0 as ttlnetto,
                   '
                   Nomor Dokumen : '||coalesce(nodok,'')||'
Nama          : '||coalesce(nmlengkap,'')||'
Tgl Dokumen   : '||to_char(tgl_dok,'dd-mm-yyyy')||'
Kategori      : '||coalesce(kategori_lembur::text,'')||'
Jenis Lembur  : '||coalesce(nmjenis_lembur::text,'')||'
Tanggal       : '||to_char(tgl_jam_mulai,'dd-mm-yyyy hh24:mi:ss')||' s/d
                '||to_char(tgl_jam_selesai,'dd-mm-yyyy hh24:mi:ss')||'
Keterangan    : '||coalesce(keterangan,'') as description,
                   'A' as status,status as asstatus,input_date as inputdate,input_by as inputby,update_date as updatedate,update_by as updateby,null as approvaldate,null as approvalby,cancel_date as canceldate,cancel_by as cancelby,null as docnotmp,'sc_trx.lembur' as tabelname,'sc_trx.approvals_system' as astabelname,'HRMS' as erptype,branch as branch from
                (select a.*,b.branch,dx.nmlengkap,kdlembur as kategori_lembur, case when jenis_lembur='D1' then 'DURASI ABSEN' when jenis_lembur='D2' then 'NON DURASI ABSEN' end as nmjenis_lembur   from sc_trx.lembur a
                                                                                                                                                                                                               left outer join sc_mst.branch b on coalesce(cdefault,'')='YES'
                                                                                                                                                                                                               left outer join sc_mst.karyawan dx on a.nik=dx.nik
                )  as x
            where nodok in (select nodok from sc_trx.lembur where coalesce(status,'') in ('A') and to_char(tgl_dok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '3 month')::date)::text and (now()::date)::text )
              and nodok not in (select docno from sc_trx.approvals_system)
        );

/* ('PSPB','mob_approvals','PERMINTAAN PEMBELIAN'), */
    insert into sc_trx.approvals_system
    (docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,
     description,
     status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname,erptype,branch)
        (select nodok as docno,tgldok as docdate, nik as docref,'PSPB' as doctype,'PERMINTAAN PEMBELIAN' as doctypename,''::text kdgroup,''::text kdsubgroup,''::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,'' as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,0 as ttlnetto,
                '
                Nomor Dokumen : '||coalesce(nodok,'')||'
Nama Pemohon  : '||coalesce(nmlengkap,'')||'
Tgl Dokumen   : '||to_char(tgldok,'dd-mm-yyyy')||'
Nama Barang   : '||nmbarang||'
Qty           : '||qty||'
Satuan        : '||satuan||'
Keterangan    : '||coalesce(ket_detail,'') as description,
                'A' as status,status as asstatus,inputdate as inputdate,inputby as inputby,updatedate as updatedate,updateby as updateby,null as approvaldate,null as approvalby,canceldate as canceldate,cancelby as cancelby,null as docnotmp,'sc_trx.sppb_mst' as tabelname,'sc_trx.approvals_system' as astabelname,'HRMS' as erptype,branch as branch from
             (select a.*,dx.nmlengkap,c.nmbarang,c.qty,c.satuan,c.ket_detail  from sc_trx.sppb_mst a
                                                                                       left outer join sc_mst.branch b on coalesce(cdefault,'')='YES'
                                                                                       left outer join sc_mst.karyawan dx on a.nik=dx.nik
                                                                                       left outer join (select a.stockcode,coalesce(b.nmbarang,'') as nmbarang,a.nodok,coalesce(a.qtysppbkecil,0) as qty,c.uraian as satuan,a.keterangan as ket_detail  from sc_trx.sppb_dtl a
                                                                                                                                                                                                                                                                 left outer join sc_mst.mbarang b on a.stockcode=b.nodok
                                                                                                                                                                                                                                                                 left outer join sc_mst.trxtype c on c.kdtrx=a.satminta and c.jenistrx='QTYUNIT'
                                                                                                        where id=1
             ) c on a.nodok=c.nodok

             )  as x
         where nodok in (select nodok from sc_trx.sppb_mst where coalesce(status,'') in ('A') and to_char(tgldok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '3 month')::date)::text and (now()::date)::text )
           and nodok not in (select docno from sc_trx.approvals_system));
    --select * from sc_mst.trxtype

/* ('BBMP','master_ga','BBM PO')
insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select nodok as docno,nodokdate as docdate,nodokref as docref,'BBMP' as doctype,'BBM PO' as doctypename,'' as kdgroup,'' askdsubgroup,'' as stockcode,kdsupplier as suppcode,kdsubsupplier as subsuppcode,nmsubsupplier as suppname,null as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,ttlnetto,keterangan as description,
	'P' as status,status as asstatus,inputdate,inputby,updatedate,updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.stbbm_mst' as tabelname,'d_transaksi..t_replication_stbbm_mst_ga' as astabelname from
	(select a.*,b.kdsupplier,b.kdsubsupplier,b.nmsubsupplier,b.addsupplier from sc_trx.stbbm_mst a
		left outer join sc_trx.po_mst a1 on a1.nodok=a.nodokref
		left outer join sc_mst.msubsupplier b on a1.kdsubsupplier=b.kdsubsupplier) as x
	where nodok in (select nodok from sc_trx.stbbm_mst where coalesce(status,'') in ('P') and to_char(nodokdate,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and nodok not in (select docno from sc_trx.replication_hrms)
	);
		--delete from sc_trx.replication_hrms where doctype='BBMP'
	select * from sc_trx.replication_hrms where doctype='BBMP'
*/
/* ('PSAS','master_ga','PERAWATAN ASSET')
insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select nodok as docno,tgldok as docdate,nodokref as docref,'PSAS' as doctype,'PERAWATAN ASSET' as doctypename,kdgroup,kdsubgroup,stockcode,kdbengkel as suppcode,kdsubbengkel as subsuppcode,nmbengkel as suppname,nmbarang as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,ttlservis as ttlnetto,keterangan as description,
	'P' as status,status as asstatus,inputdate,inputby,updatedate,updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_his.perawatanspk' as tabelname,'d_transaksi..t_replication_perawatanspk_ga' as astabelname from
	(select a.*,b.nmbengkel,c.nmbarang from sc_his.perawatanspk a
	left outer join sc_mst.mbengkel b on a.kdbengkel=b.kdbengkel
	left outer join sc_mst.mbarang c on a.stockcode=c.nodok) as x
	where nodok in (select nodok from sc_his.perawatanspk where coalesce(status,'') in ('X') and to_char(tgldok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and nodok not in (select docno from sc_trx.replication_hrms)
	);
*/
/* ('UMMK','master_ga','UANG MAKAN')

insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select nodok as docno,tgldok as docdate,kdcabang as docref,'UMMK' as doctype,'UANG MAKAN' as doctypename,''::text as kdgroup,''::text as kdsubgroup,''::text as stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,''::text as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,nominal as ttlnetto,desc_cabang as description,
	'P' as status,status as asstatus,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.rekap_um' as tabelname,'d_transaksi..t_um_rekap_replication' as astabelname from
	(select a.*,b.desc_cabang from sc_trx.rekap_um a
	left outer join sc_mst.kantorwilayah b on a.kdcabang=b.kdcabang
	) as x
	where nodok in (select nodok from sc_trx.rekap_um where coalesce(status,'') in ('P') and to_char(tgldok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and nodok not in (select docno from sc_trx.replication_hrms)
	);
*/
/* ('BBMK','master_ga','BAHAN BAKAR KENDARAAN')

insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select docno,docdate,bahanbakar docref,'BBMK' as doctype,'BAHAN BAKAR KENDARAAN' as doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,nmsubsupplier as suppname,nmbarang as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,ttlvalue as ttlnetto,coalesce(bahanbakar,'')||' '||coalesce(description,''),
	'P' as status,status as asstatus,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.replication_hrms' as tabelname,'d_transaksi..t_replication_hrms' as astabelname from
	(select a.*,c.nmbarang,c.nopol from sc_his.bbmkendaraan_mst a
	left outer join sc_mst.mbarang c on a.stockcode=c.nodok
	left outer join sc_mst.msubsupplier d on a.subsuppcode=d.kdsubsupplier) as x
	where docno in (select docno from sc_his.bbmkendaraan_mst where coalesce(status,'') in ('P') and to_char(docdate,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and docno not in (select docno from sc_trx.replication_hrms)
	);
*/
/* ('ASKD','master_ga','ASURANSI KENDARAAN')

insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select docno,docdate,kdsubasuransi as docref,'ASKD' as doctype,'ASURANSI KENDARAAN' as doctypename,kdgroup,kdsubgroup,stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,nmbarang as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,ttlvalue as ttlnetto,coalesce(description,''),
	'P' as status,status as asstatus,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.replication_hrms' as tabelname,'d_transaksi..t_replication_hrms' as astabelname from
	(select a.*,c.nmbarang,c.nopol from sc_his.asnkendaraan_mst a
	left outer join sc_mst.mbarang c on a.stockcode=c.nodok) as x
	where docno in (select docno from sc_his.asnkendaraan_mst where coalesce(status,'') in ('P') and to_char(docdate,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and docno not in (select docno from sc_trx.replication_hrms)
	);
*/
/* ('KIRM','master_ga','KIR KENDARAAN')

insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select docno,docdate, docref,'KIRM' as doctype,'KIR KENDARAAN' as doctypename,kdgroup,kdsubgroup,stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,nmbarang as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,ttlvalue as ttlnetto,coalesce(description,''),
	'P' as status,status as asstatus,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.replication_hrms' as tabelname,'d_transaksi..t_replication_hrms' as astabelname from
	(select a.*,c.nmbarang,c.nopol from sc_his.kir_mst a
	left outer join sc_mst.mbarang c on a.stockcode=c.nodok) as x
	where docno in (select docno from sc_his.kir_mst where coalesce(status,'') in ('P') and to_char(docdate,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and docno not in (select docno from sc_trx.replication_hrms)
	);
*/
/* ('SIMX','master_ga','PERPANJANGAN SIM'),
insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select docno,docdate, docsim as docref,'SIMX' as doctype,'PERPANJANGAN SIM' as doctypename,''::text kdgroup,''::text kdsubgroup,''::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,''::text as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,ttlvalue as ttlnetto,coalesce(description,''),
	'P' as status,status as asstatus,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.replication_hrms' as tabelname,'d_transaksi..t_replication_hrms' as astabelname from
	(select * from sc_his.sim_mst) as x
	where docno in (select docno from sc_his.sim_mst where coalesce(status,'') in ('P') and to_char(docdate,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and docno not in (select docno from sc_trx.replication_hrms)
	);
*/

/* ('STNK','master_ga','PERPANJANGAN STNKB'),
insert into sc_trx.replication_hrms
	(docno,docdate,docref,doctype,doctypename,kdgroup,kdsubgroup,stockcode,suppcode,subsuppcode,suppname,stockname,ppny,exppn,ttldiskon,ttldpp,ttlppn,ttlppnbm,ttlnetto,description,
	status,asstatus,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,canceldate,cancelby,docnotmp,tabelname,astabelname)
	(
	select nodok as docno,tgldok as docdate, jenispengurusan as docref,'STNK' as doctype,'PERPANJANGAN STNKB' as doctypename,''::text kdgroup,''::text kdsubgroup,kdrangka::text stockcode,''::text as suppcode,''::text as subsuppcode,''::text as suppname,nmkendaraan as stockname,null as ppny,null as exppn,null as ttldiskon,null as ttldpp,null as ttlppn,null as ttlppnbm,nominalpkb as ttlnetto,coalesce(nopol,''),
	'P' as status,status as asstatus,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as canceldate,null as cancelby,null as docnotmp,'sc_trx.replication_hrms' as tabelname,'d_transaksi..t_replication_hrms' as astabelname from
	(select a.*,c.nmbarang from sc_his.stnkb a
	left outer join sc_mst.mbarang c on a.kdrangka=c.nodok)  as x
	where nodok in (select nodok from sc_his.stnkb where coalesce(status,'') in ('P') and to_char(tgldok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '10 month')::date)::text and (now()::date)::text )
	and nodok not in (select docno from sc_trx.replication_hrms)
	);
*/



/*
('KIRM','master_ga','KIR KENDARAAN'),
(select * from sc_trx.master_ga_replication)
(select * from sc_his.perawatanspk where nodok in (select nodok from sc_his.perawatanspk where coalesce(status,'') in ('X') and to_char(tgldok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '12 month')::date)::text and (now()::date)::text ))

select * from
(select a.*,b.nmbengkel,c.nmbarang from sc_his.perawatanspk a
left outer join sc_mst.mbengkel b on a.kdbengkel=b.kdbengkel
left outer join sc_mst.mbarang c on a.stockcode=c.nodok) as x
where nodok in (select nodok from sc_his.perawatanspk where coalesce(status,'') in ('X') and to_char(tgldok,'yyyy-mm-dd') between (date_trunc('day', NOW() - interval '12 month')::date)::text and (now()::date)::text )

(select a.*,c.nmbarang,c.nopol from sc_his.bbmkendaraan_mst a
left outer join sc_mst.mbarang c on a.stockcode=c.nodok) as x

select * from sc_his.bbmkendaraan_mst
select * from sc_his.asnkendaraan_mst
select * from sc_his.kir_mst
select * from sc_his.sim_mst
select * from sc_his.stnkb

*/
    RETURN;


END;
$$;