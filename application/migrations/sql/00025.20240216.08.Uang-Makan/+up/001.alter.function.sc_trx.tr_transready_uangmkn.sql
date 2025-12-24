-- Function: sc_trx.tr_transready_uangmkn()

-- DROP FUNCTION sc_trx.tr_transready_uangmkn();

CREATE OR REPLACE FUNCTION sc_trx.tr_transready_uangmkn()
  RETURNS trigger AS
$BODY$
DECLARE
    -- Update By ARBI : 27/10/2021
    -- Penyesuaian Uang Makan Lembur & Level Jabatan B
    -- Update By Andika: 23/02/2023
    -- Penyesuaian uang makan untuk ijin pulang awal, ijin keluar, ijin datang terlambat
    -- Update By RKM: 16/08/2023
    -- Penyesuaian untuk multi ijin dalam sehari
    -- Update By RKM: 23/08/2023
    --Update By Bagos : 29-09-2023
    --Update By Bagos : 16-02-2024
    --Penyesuaian uang makan saat ijin dinas full
    vr_um_max01 TIME WITHOUT TIME ZONE;
    vr_um_max02 TIME WITHOUT TIME ZONE;
    vr_um_min01 TIME WITHOUT TIME ZONE;
    vr_um_min02 TIME WITHOUT TIME ZONE;
    vr_date_now DATE;
    vr_dok_lembur CHARACTER(25);
BEGIN
    DELETE FROM sc_trx.uangmakan WHERE nik = new.nik AND tgl = new.tgl;
    vr_date_now := CAST(TO_CHAR(NOW(), 'YYYY-MM-DD') AS DATE);

    IF(TRIM(new.kdregu) = 'NC') THEN
        vr_um_max01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX01' AND group_option = 'NC'; --'13:00:00'
        vr_um_max02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX02' AND group_option = 'NC'; --'11:00:00'
        vr_um_min01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN01' AND group_option = 'NC'; --'07:55:00'
        vr_um_min02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN02' AND group_option = 'NC'; --'07:55:00'
    ELSE
        vr_um_max01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX01' AND group_option = 'DEFAULT'; --'13:00:00'
        vr_um_max02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX02' AND group_option = 'DEFAULT'; --'11:00:00'
        vr_um_min01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN01' AND group_option = 'DEFAULT'; --'07:55:00'
        vr_um_min02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN02' AND group_option = 'DEFAULT'; --'07:55:00'
    END IF;

    INSERT INTO sc_trx.uangmakan (
        with
            core AS (
                SELECT
                    'SBYNSA'                        AS branch,
                    a.nik,
                    b.nmlengkap,
                    c.kddept,
                    c.nmdept,
                    e.kdjabatan,
                    e.nmjabatan,
                    a.tgl,
                    CASE
                        WHEN a.jam_masuk_absen = a.jam_pulang_absen AND a.jam_masuk_absen > vr_um_max01 THEN NULL
                        ELSE a.jam_masuk_absen
                        END  AS checkin,
                    CASE
                        WHEN a.jam_masuk_absen = a.jam_pulang_absen AND a.jam_pulang_absen <= vr_um_max01 THEN NULL
                        ELSE a.jam_pulang_absen
                        END AS checkout,
                    NULL                            AS nominal,
                    ''                              AS keterangan,
                    b.kdcabang,
                    b.lvl_jabatan,
                    a.jam_masuk,
                    a.jam_pulang,
                    f.besaran                       AS kantin,
                    a.kdregu,
                    h.jam_masuk AS schedule_in,
                    h.jam_pulang AS schedule_out,
                    h.jam_pulang_min AS min_schedule_out
                from sc_trx.transready a
                         LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
                         LEFT OUTER JOIN sc_mst.departmen c ON b.bag_dept = c.kddept
                         LEFT OUTER JOIN sc_mst.subdepartmen d ON b.subbag_dept = d.kdsubdept AND b.bag_dept = d.kddept
                         LEFT OUTER JOIN sc_mst.jabatan e ON b.jabatan = e.kdjabatan AND b.subbag_dept = e.kdsubdept AND b.bag_dept = e.kddept
                         LEFT OUTER JOIN sc_mst.kantin f ON b.kdcabang = f.kdcabang
                         LEFT OUTER JOIN sc_trx.dtljadwalkerja g ON a.nik = g.nik AND a.tgl = g.tgl
                         LEFT OUTER JOIN sc_mst.jam_kerja h ON h.kdjam_kerja = g.kdjamkerja
                where TRUE
                  AND (b.tglkeluarkerja is null or statuskepegawaian <> 'KO')
                  --AND b.kdcabang = 'SMGDMK'
                  AND a.nik = new.nik
                  AND a.tgl = new.tgl
                  AND b.lvl_jabatan <> 'A'
            )
        select
            'SBYNSA',
            aaa.nik,
            aaa.tgl,
            aaa.checkin,
            aaa.checkout,
            CASE
                WHEN aaa.kdcabang <> 'SMGDMK' THEN
                    CASE
                        WHEN holiday IS NOT NULL THEN null
                        WHEN aaa.docno_leave IS NOT NULL THEN NULL
                        WHEN (checkin IS NOT NULL OR checkout IS NOT NULL) AND holiday is null AND lvl_jabatan = 'A' THEN besaran
                        WHEN ik_full IS NOT NULL THEN besaran
                        WHEN ikdn_dt IS NOT NULL AND ikdn_pa IS NOT NULL THEN besaran
                        WHEN ikdn_dt IS NOT NULL THEN
                            CASE
                                WHEN checkin <= ikdn_dt_start AND checkout >= schedule_out THEN besaran
                                WHEN checkin <= ikdn_dt_start AND checkout < schedule_out AND ikdn_pa IS NULL THEN null
                                END
                        WHEN ikdn_pa IS NOT NULL THEN
                            CASE
                                WHEN checkin < schedule_in AND checkout >= ikdn_pa_end THEN besaran
                                WHEN checkin > schedule_in AND checkout >= ikdn_pa_end AND ikdn_dt IS NULL THEN null
                                END
                        WHEN ikdn_ik is not null THEN
                            CASE
                                when checkin is not null AND checkout is not null THEN besaran
                                END
                        WHEN ik_pb is not null THEN
                            CASE
                                when ik_pb_type = 'DT' THEN null
                                when ik_pb_type = 'PA' THEN
                                    CASE
                                        WHEN checkout >= (select aaa.min_schedule_out from core) THEN besaran
                                        ELSE null
                                        END
                                END

                        WHEN checkin is null AND checkout is null THEN NULL
                        when (checkin is not null or checkout is not null) AND holiday is null AND  lvl_jabatan = 'A' THEN besaran
                        WHEN checkin is not null AND checkout is not null THEN
                            CASE
                                WHEN checkin < schedule_in AND checkout >= schedule_out AND lmb_dok IS NOT null THEN besaran + besaran
                                WHEN checkin < schedule_in AND checkout >= schedule_out THEN besaran
                                WHEN checkin > schedule_in AND checkout >= schedule_out THEN null
                                WHEN checkin < schedule_in AND checkout < schedule_out THEN null
                                END
                        WHEN (checkin is null OR checkout is null ) THEN null
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' THEN besaran
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND (docno_leave is null) AND ik_full IS NULL THEN besaran
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND (docno_leave is not null AND LEFT(docno_leave, 2) = 'DL' )  THEN NULL
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' AND (docno_leave is not null AND LEFT(docno_leave, 2) = 'DL' )  THEN NULL
                        END
                WHEN aaa.kdcabang = 'SMGDMK' THEN
                    CASE
                        WHEN holiday IS NOT NULL THEN null
                        WHEN aaa.docno_leave IS NOT NULL THEN NULL
                        WHEN (checkin IS NOT NULL OR checkout IS NOT NULL) AND holiday is null AND lvl_jabatan = 'A' THEN besaran - kantin
                        WHEN ik_full IS NOT NULL THEN besaran -kantin
                        WHEN ikdn_dt IS NOT NULL AND ikdn_pa IS NOT NULL THEN besaran-kantin
                        WHEN ikdn_dt IS NOT NULL THEN
                            CASE
                                WHEN checkin <= ikdn_dt_start AND checkout >= schedule_out THEN besaran-kantin
                                WHEN checkin <= ikdn_dt_start AND checkout < schedule_out AND ikdn_pa IS NULL THEN null
                                END
                        WHEN ikdn_pa IS NOT NULL THEN
                            CASE
                                WHEN checkin < schedule_in AND checkout >= ikdn_pa_end THEN besaran-kantin
                                WHEN checkin > schedule_in AND checkout >= ikdn_pa_end AND ikdn_dt IS NULL THEN null
                                END
                        WHEN ikdn_ik is not null THEN
                            CASE
                                when checkin is not null AND checkout is not null THEN besaran-kantin
                                END
                        WHEN ik_pb is not null THEN
                            CASE
                                when ik_pb_type = 'DT' THEN null
                                when ik_pb_type = 'PA' THEN
                                    CASE
                                        WHEN checkout >= (select aaa.min_schedule_out from core) THEN besaran
                                        ELSE null
                                        END
                                END

                        WHEN checkin is null AND checkout is null THEN NULL
                        when (checkin is not null or checkout is not null) AND holiday is null AND  lvl_jabatan = 'A' THEN besaran-kantin
                        WHEN checkin is not null AND checkout is not null THEN
                            CASE
                                WHEN checkin < schedule_in AND checkout >= schedule_out THEN besaran-kantin
                                WHEN checkin > schedule_in AND checkout >= schedule_out THEN null
                                WHEN checkin < schedule_in AND checkout < schedule_out THEN null
                                END
                        WHEN (checkin is null OR checkout is null ) THEN null
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' THEN besaran - kantin
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND (docno_leave is null) AND ik_full IS NULL THEN besaran - kantin
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND (docno_leave is not null AND LEFT(docno_leave, 2) = 'DL' )  THEN NULL
                        WHEN checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' AND (docno_leave is not null AND LEFT(docno_leave, 2) = 'DL' )  THEN NULL
                        END
                END AS nominal,
            CASE
                WHEN aaa.docno_leave IS NOT NULL THEN aaa.status_text
                WHEN aaa.ikdn_dt IS NOT NULL THEN 'IJIN KELUAR DINAS DENGAN NO: '||ikdn_dt|| CASE when ikdn_dt_approvedate is not null THEN '|| APP TGL: ' || TO_CHAR(ikdn_dt_approvedate, 'YYYY-MM-DD') ELSE '' END
                WHEN aaa.ikdn_pa IS NOT NULL THEN 'IJIN KELUAR DINAS DENGAN NO: '||ikdn_pa|| CASE when ikdn_pa_approvedate is not null THEN '|| APP TGL: ' || TO_CHAR(ikdn_pa_approvedate, 'YYYY-MM-DD') ELSE '' END
				WHEN aaa.ik_full IS NOT NULL THEN 'IJIN KELUAR DINAS DENGAN NO: '||ik_full|| CASE when ik_full_approvedate is not null THEN '|| APP TGL: ' || TO_CHAR(ik_full_approvedate, 'YYYY-MM-DD') ELSE '' END
                WHEN aaa.ik_pb IS NOT NULL THEN
                    CASE
                        WHEN ik_pb_type = 'DT' THEN 'IZIN DT PRIBADI DENGAN NO: '||ik_pb|| CASE when ik_pb_approvedate is not null THEN '|| APP TGL: ' || TO_CHAR(ik_pb_approvedate, 'YYYY-MM-DD') ELSE '' END
                        WHEN ik_pb_type = 'PA' THEN 'IZIN PA PRIBADI DENGAN NO: '||ik_pb|| CASE when ik_pb_approvedate is not null THEN '|| APP TGL: ' || TO_CHAR(ik_pb_approvedate, 'YYYY-MM-DD') ELSE '' END
                    END

                WHEN checkin is not null AND checkout IS NOT NULL THEN
                    CASE
                        WHEN checkin < schedule_in AND checkout >= schedule_out AND lmb_dok IS NOT NULL THEN 'TEPAT WAKTU + LEMBUR :'||lmb_dok
                        WHEN checkin < schedule_in AND checkout >= schedule_out THEN 'TEPAT WAKTU'
                        WHEN checkin > schedule_in AND checkout >= schedule_out THEN 'TERLAMBAT'
                        WHEN checkin < schedule_in AND checkout < schedule_out THEN  'PULANG AWAL'
                        END
                WHEN checkin is null AND checkout is null THEN 'TIDAK MASUK KANTOR'
                WHEN (checkin is null OR checkout is null) THEN
                    CASE
                        WHEN checkin is null THEN 'TIDAK CEKLOG MASUK'
                        WHEN checkout is null THEN 'TIDAK CEKLOG PULANG'
                    END
                END AS keterangan,
            current_date AS docdate,
            CASE
                WHEN aaa.docno_leave IS NOT NULL THEN aaa.docno_leave
                WHEN aaa.ikdn_dt IS NOT NULL THEN aaa.ikdn_dt
                WHEN aaa.ikdn_pa IS NOT NULL THEN aaa.ikdn_pa
                WHEN aaa.ik_pb IS NOT NULL THEN aaa.ik_pb
                END AS nodok
        from (
                 select
                     core.*,
                     c.docno AS docno_leave,
                     c.approve_by AS approve_by_leave,
                     c.approve_date AS approve_date_leave,
                     c.status_text,
                     lmb.nodok AS lmb_dok,
                     ikfull.nodok AS ik_full,
					 ikfull.kdijin_absensi AS ik_full_type,
                     ikfull.approval_date AS ik_full_approvedate,
                     ikdndt.nodok AS ikdn_dt,
                     ikdndt.kdijin_absensi AS ikdn_dt_type,
                     ikdndt.tgl_jam_mulai AS ikdn_dt_start,
                     ikdndt.tgl_jam_selesai AS ikdn_dt_end,
                     ikdndt.approval_date AS ikdn_dt_approvedate,
                     ikdnpa.nodok AS ikdn_pa,
                     ikdnpa.kdijin_absensi AS ikdn_pa_type,
                     ikdnpa.tgl_jam_mulai AS ikdn_pa_start,
                     ikdnpa.tgl_jam_selesai AS ikdn_pa_end,
                     ikdnpa.approval_date AS ikdn_pa_approvedate,
                     ikdnik.nodok AS ikdn_ik,
                     ikdnik.kdijin_absensi AS ikdn_ik_type,
                     ikdnik.tgl_jam_mulai AS ikdn_ik_start,
                     ikdnik.tgl_jam_selesai AS ikdn_ik_end,
                     ikdnik.approval_date AS ikdn_ik_approvedate,
                     ikpb.nodok AS ik_pb,
                     ikpb.kdijin_absensi AS ik_pb_type,
                     ikpb.approval_date AS ik_pb_approvedate,
                     lmb.nodok AS lb,
                     lb.tgl_libur AS holiday,
                     lb.ket_libur AS holiday_text,
                     b.besaran
                 from core
                          LEFT OUTER JOIN sc_mst.uangmakan b ON b.kdlvl = core.lvl_jabatan
                          LEFT OUTER JOIN (
                     select
                         docno,
                         type,
                         approve_by,
                         approve_date,
                         CASE
                             WHEN type = 'KD' THEN 'IJIN KETERANGAN DOKTER NO :' || docno || case when approve_date is not null THEN '|| APP TGL: ' || TO_CHAR(approve_date, 'YYYY-MM-DD') ELSE '' END
                             WHEN type = 'DN' THEN 'DINAS DENGAN NO DINAS :' || docno || '|| APP TGL: ' || TO_CHAR(approve_date, 'YYYY-MM-DD')
                             WHEN type = 'CT' THEN 'CUTI DENGAN NO CUTI :' || docno || '|| APP TGL: ' || TO_CHAR(approve_date, 'YYYY-MM-DD')
                             END AS status_text
                     from (
                              select
                                  ik.nodok as docno,
                                  ik.approval_by AS approve_by,
                                  ik.approval_date AS approve_date,
                                  'KD' AS type,
                                  1 AS sort
                              from sc_trx.ijin_karyawan ik
                              where TRUE
                                AND ik.nik = (select nik from core)
                                and ik.tgl_kerja = (select tgl from core)
                                AND ik.kdijin_absensi = 'KD'
                              union all
                              select
                                  dn.nodok as docno,
                                  dn.approval_by AS approve_by,
                                  dn.approval_date AS approve_date,
                                  'DN' AS type,
                                  2 AS sort
                              from sc_trx.dinas as dn
                              WHERE TRUE
                                AND dn.nik = (select nik from core)
                                AND (select tgl from core) between dn.tgl_mulai AND dn.tgl_selesai
                                AND dn.status = 'P'
                              union all
                              select
                                  ct.nodok as docno,
                                  ct.approval_by AS approve_by,
                                  ct.approval_date AS approve_date,
                                  'CT' AS type,
                                  3 AS sort
                              from sc_trx.cuti_karyawan as ct
                              WHERE TRUE
                                AND ct.nik = (select nik from core)
                                AND (select tgl from core) between ct.tgl_mulai AND ct.tgl_selesai
                                AND ct.status = 'P'

                          ) as absent order by sort asc limit 1
                 ) c ON TRUE
                          LEFT OUTER JOIN (select * from  sc_trx.ijin_karyawan WHERE nik = (select nik from core) AND tgl_kerja = (select tgl from core) AND status = 'P' AND tgl_jam_mulai <= (select schedule_in from core) AND tgl_jam_selesai >= (select schedule_out from core)  AND type_ijin = 'DN' order by nodok DESC LIMIT 1) ikfull ON TRUE
                          LEFT OUTER JOIN (select * from sc_trx.ijin_karyawan WHERE nik =(select nik from core) AND tgl_kerja = (select tgl from core) AND status = 'P' AND type_ijin = 'DN' AND kdijin_absensi = 'DT' order by nodok DESC limit 1) ikdndt ON TRUE AND ikdndt.nik = (select nik from core)
                          LEFT OUTER JOIN (select * from sc_trx.ijin_karyawan WHERE nik =(select nik from core) AND tgl_kerja = (select tgl from core) AND status = 'P' AND type_ijin = 'DN' AND kdijin_absensi = 'PA' order by nodok DESC limit 1) ikdnpa ON TRUE AND ikdnpa.nik = (select nik from core)
                          LEFT OUTER JOIN (select * from sc_trx.ijin_karyawan WHERE nik =(select nik from core) AND tgl_kerja = (select tgl from core) AND status = 'P' AND type_ijin = 'DN' AND kdijin_absensi = 'IK' and ( (tgl_jam_mulai>(select schedule_in from core) and tgl_jam_selesai>=(select schedule_out from core))
                     OR (tgl_jam_mulai<=(select schedule_in from core) and tgl_jam_selesai<(select schedule_out from core)) ) order by nodok DESC limit 1) ikdnik ON TRUE AND ikdnik.nik = (select nik from core)
                          LEFT OUTER JOIN sc_trx.ijin_karyawan ikpb ON ikpb.nik = core.nik AND ikpb.tgl_kerja = core.tgl AND ikpb.status = 'P' AND ikpb.type_ijin = 'PB'
                          LEFT OUTER JOIN sc_trx.lembur lmb ON lmb.nik = core.nik AND lmb.tgl_kerja = core.tgl AND TO_CHAR(core.checkout, 'HH24:MI:SS') >= '18:00:00' AND TO_CHAR(lmb.tgl_jam_selesai, 'HH24:MI:SS') >= '18:00:00' AND (lmb.status = 'P' OR lmb.status = 'F') AND lmb.kdlembur = 'BIASA' AND TO_CHAR(lmb.tgl_jam_mulai, 'HH24:MI:SS') >= '13:00:00'
                          LEFT OUTER JOIN sc_mst.libur lb ON lb.tgl_libur = core.tgl
                 WHERE TRUE
            ) aaa
    );

    RETURN new;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_trx.tr_transready_uangmkn()
  OWNER TO postgres;
