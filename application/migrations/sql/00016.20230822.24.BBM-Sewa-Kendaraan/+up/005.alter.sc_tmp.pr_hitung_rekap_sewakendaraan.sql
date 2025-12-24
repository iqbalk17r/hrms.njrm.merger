create OR REPLACE function sc_tmp.pr_hitung_rekap_sewakendaraan(vr_kdcabang character, vr_tglawal date, vr_tglakhir date) returns SETOF void
    language plpgsql
as
$$
DECLARE
    -- Author By FIKY : 02/02/2017
    -- Update By ANDIKA : 21/03/2023
    vr_tglapproval DATE;
    vr_tgl_act DATE;
    vr_tgl_dok DATE;
    vr_nodok_ref CHARACTER(12);
    vr_nominal_sewakendaraan NUMERIC;
    vr_cek_nominal_sewakendaraan NUMERIC;
    vr_nik CHARACTER(12);
    vr_callplan CHARACTER(5) := (SELECT value1 from sc_mst.option where kdoption = 'USK');
BEGIN
    FOR vr_nik IN SELECT TRIM(nik) FROM sc_mst.karyawan WHERE tglkeluarkerja IS NULL AND kdcabang = vr_kdcabang
        LOOP
            vr_nominal_sewakendaraan := (select value3 as nominal
                                         from sc_mst.option where kdoption = 'USK');

            FOR vr_nodok_ref IN SELECT TRIM(dok_ref)
                                FROM sc_trx.sewakendaraan
                                WHERE nik = vr_nik AND dok_ref IS NOT NULL AND (LEFT(dok_ref, 2) = 'IK' OR LEFT(dok_ref, 2) = 'PA' OR LEFT(dok_ref,2) = 'DT')
                                  AND (TO_CHAR(tgl, 'YYYY-MM-DD') BETWEEN TO_CHAR(vr_tglawal - INTERVAL '1 WEEK', 'YYYY-MM-DD') AND TO_CHAR(vr_tglakhir, 'YYYY-MM-DD'))
                LOOP
                    SELECT CAST(TO_CHAR(approval_date, 'YYYY-MM-DD') AS DATE) INTO vr_tglapproval FROM sc_trx.ijin_karyawan WHERE nodok = vr_nodok_ref;
                    SELECT nominal INTO vr_cek_nominal_sewakendaraan FROM sc_trx.sewakendaraan WHERE dok_ref = vr_nodok_ref AND nik = vr_nik;

                    IF(vr_cek_nominal_sewakendaraan = 0 OR vr_cek_nominal_sewakendaraan IS NULL) THEN
                        UPDATE sc_trx.sewakendaraan SET nominal = vr_nominal_sewakendaraan, keterangan = SPLIT_PART(keterangan, ' + ', 1) || ' + IJIN NO IJIN : ' || vr_nodok_ref where tgl = vr_tglapproval AND nik = vr_nik;
                    END IF;

                    RETURN NEXT vr_nodok_ref;
                END LOOP;

            RETURN NEXT vr_nik;
        END LOOP;

    IF (vr_callplan = 'YES') THEN

        UPDATE sc_trx.sewakendaraan AS a
        SET rencanacallplan = x.rencanacallplan, realisasicallplan = x.realisasicallplan, nominal = x.nominal, keterangan = x.keterangan
        FROM (
                 SELECT a.nik, a.tgl, d.jumlah AS rencanacallplan, e.jumlah AS realisasicallplan,
                        CASE
                            WHEN ((d.jumlah > 0 AND e.jumlah >= d.jumlah AND a.checkin IS NOT NULL AND a.checkout IS NOT NULL)) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
                            --ELSE NULL
                            END AS nominal,
                        CASE
                            WHEN (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.tgl_jam_mulai < f.jam_masuk AND h.tgl_jam_selesai >= jam_pulang)
                                OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'PA' AND a.checkin < f.jam_masuk AND a.checkout >= jam_pulang_min)
                                OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi NOT IN ('DT'))
                                OR (a.checkin IS NULL AND a.checkout IS NULL) OR a.keterangan SIMILAR TO '(DINAS|CUTI)%' THEN SPLIT_PART(a.keterangan, ' + ', 1)
                            WHEN d.jumlah = 0 THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + TIDAK ADA RENCANA CALLPLAN'
                            WHEN e.jumlah >= d.jumlah THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TERPENUHI'
                            ELSE SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TIDAK TERPENUHI'
                            END AS keterangan
                 FROM sc_trx.sewakendaraan a
                          INNER JOIN sc_mst.karyawan b ON b.nik = a.nik AND b.tglkeluarkerja IS NULL AND b.callplan = 't' AND b.kdcabang = vr_kdcabang
                          INNER JOIN sc_mst.regu_opr c ON c.nik = b.nik
                          LEFT JOIN LATERAL (
                     SELECT COUNT(x.custcode) AS jumlah
                     FROM (
                              SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
                              FROM sc_tmp.scheduletolocation xa
                              WHERE xa.nik = a.nik AND xa.scheduledate = a.tgl
                              GROUP BY 1
                          ) x
                     ) d ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT COUNT(x.custcode1) AS jumlah
                     FROM (
                              SELECT xa.userid, COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode1,
                                     COALESCE(NULLIF(xb.locationid, ''), NULLIF(xb.locationidlocal, '')) AS custcode2,
                                     xa.custname, xb.custname
                              FROM sc_tmp.checkinout xa
                                       LEFT OUTER JOIN sc_tmp.scheduletolocation xb
                                                       ON xa.userid = xb.userid
                              WHERE xa.checktime::DATE = a.tgl AND xa.nik = a.nik AND COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) = COALESCE(NULLIF(xb.locationid, ''), NULLIF(xb.locationidlocal, ''))
                              GROUP BY 1, xa.custname, xa.userid, xb.locationid, xa.customeroutletcode, xa.customercodelocal, xb.locationidlocal, xa.custname, xb.custname
                          ) x
                     ) e ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT jam_masuk, jam_pulang, jam_pulang_min
                     FROM sc_mst.jam_kerja
                     WHERE kdjam_kerja = CASE
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'SL' THEN 'SL1'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'SL' THEN 'SL2'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'SL' THEN 'SL3'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'NC' THEN 'NC1'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'NC' THEN 'NC2'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'NC' THEN 'NC3'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) THEN 'NSA'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) THEN 'NSB'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) THEN 'NSC'
                         END
                     ) f ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT value1 AS callplan, value3 AS nominal
                     from sc_mst.option where kdoption = 'USK'
                     ) g ON TRUE
                          LEFT JOIN sc_trx.ijin_karyawan h ON h.nodok = a.dok_ref AND h.status = 'P'
                 WHERE a.tgl::DATE BETWEEN vr_tglawal AND vr_tglakhir
                 ORDER BY b.kdcabang, b.nmlengkap, a.tgl
             ) AS x
        WHERE a.nik = x.nik AND a.tgl = x.tgl;

    ELSEIF (vr_callplan = 'NO') THEN

        UPDATE sc_trx.sewakendaraan AS a
        SET rencanacallplan = x.rencanacallplan, realisasicallplan = x.realisasicallplan, nominal = x.nominal, keterangan = x.keterangan
        FROM (
                 SELECT a.nik, a.tgl, d.jumlah AS rencanacallplan, e.jumlah AS realisasicallplan,
                        CASE
                            WHEN ((d.jumlah > 0 AND e.jumlah > 0 AND a.checkin IS NOT NULL AND a.checkout IS NOT NULL)) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
                            --ELSE NULL
                            END AS nominal,
                        CASE
                            WHEN (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.tgl_jam_mulai < f.jam_masuk AND h.tgl_jam_selesai >= jam_pulang)
                                OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'PA' AND a.checkin < f.jam_masuk AND a.checkout >= jam_pulang_min)
                                OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi NOT IN ('DT'))
                                OR (a.checkin IS NULL AND a.checkout IS NULL) OR a.keterangan SIMILAR TO '(DINAS|CUTI)%' THEN SPLIT_PART(a.keterangan, ' + ', 1)
                            WHEN d.jumlah = 0 THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + TIDAK ADA RENCANA CALLPLAN'
                            WHEN e.jumlah >= d.jumlah THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TERPENUHI'
                            ELSE SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TIDAK TERPENUHI'
                            END AS keterangan
                 FROM sc_trx.sewakendaraan a
                          INNER JOIN sc_mst.karyawan b ON b.nik = a.nik AND b.tglkeluarkerja IS NULL AND b.callplan = 't' AND b.kdcabang = vr_kdcabang
                          INNER JOIN sc_mst.regu_opr c ON c.nik = b.nik
                          LEFT JOIN LATERAL (
                     SELECT COUNT(x.custcode) AS jumlah
                     FROM (
                              SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
                              FROM sc_tmp.scheduletolocation xa
                              WHERE xa.nik = a.nik AND xa.scheduledate = a.tgl
                              GROUP BY 1
                          ) x
                     ) d ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT COUNT(x.custcode1) AS jumlah
                     FROM (
                              SELECT xa.userid, COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode1,
                                     COALESCE(NULLIF(xb.locationid, ''), NULLIF(xb.locationidlocal, '')) AS custcode2,
                                     xa.custname, xb.custname
                              FROM sc_tmp.checkinout xa
                                       LEFT OUTER JOIN sc_tmp.scheduletolocation xb
                                                       ON xa.userid = xb.userid
                              WHERE xa.checktime::DATE = a.tgl AND xa.nik = a.nik AND COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) = COALESCE(NULLIF(xb.locationid, ''), NULLIF(xb.locationidlocal, ''))
                              GROUP BY 1, xa.custname, xa.userid, xb.locationid, xa.customeroutletcode, xa.customercodelocal, xb.locationidlocal, xa.custname, xb.custname
                          ) x
                     ) e ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT jam_masuk, jam_pulang, jam_pulang_min
                     FROM sc_mst.jam_kerja
                     WHERE kdjam_kerja = CASE
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'SL' THEN 'SL1'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'SL' THEN 'SL2'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'SL' THEN 'SL3'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'NC' THEN 'NC1'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'NC' THEN 'NC2'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'NC' THEN 'NC3'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) THEN 'NSA'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) THEN 'NSB'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) THEN 'NSC'
                         END
                     ) f ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT value1 AS callplan, value3 AS nominal
                     from sc_mst.option where kdoption = 'USK'
                     ) g ON TRUE
                          LEFT JOIN sc_trx.ijin_karyawan h ON h.nodok = a.dok_ref AND h.status = 'P'
                 WHERE a.tgl::DATE BETWEEN vr_tglawal AND vr_tglakhir
                 ORDER BY b.kdcabang, b.nmlengkap, a.tgl
             ) AS x
        WHERE a.nik = x.nik AND a.tgl = x.tgl;

    ELSE

        UPDATE sc_trx.sewakendaraan AS a
        SET rencanacallplan = x.rencanacallplan, realisasicallplan = x.realisasicallplan, nominal = x.nominal, keterangan = x.keterangan
        FROM (
                 SELECT a.nik, a.tgl, d.jumlah AS rencanacallplan, e.jumlah AS realisasicallplan,
                        CASE
                            WHEN a.checkin IS NOT NULL AND a.checkout IS NOT NULL AND a.keterangan NOT SIMILAR TO '(DINAS LUAR|CUTI)%' THEN g.nominal
                            --ELSE NULL
                            END AS nominal,
--             CASE
--                 WHEN (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.tgl_jam_mulai < f.jam_masuk AND h.tgl_jam_selesai >= jam_pulang)
--                     OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'PA' AND a.checkin < f.jam_masuk AND a.checkout >= jam_pulang_min)
--                     OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi NOT IN ('DT'))
--                     OR (a.checkin IS NULL AND a.checkout IS NULL) OR a.keterangan SIMILAR TO '(DINAS LUAR|CUTI)%' THEN SPLIT_PART(a.keterangan, ' + ', 1)
--                 WHEN d.jumlah = 0 THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + TIDAK ADA RENCANA CALLPLAN'
--                 WHEN d.jumlah > 0 THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + ADA RENCANA CALLPLAN'
--                 ELSE
                        SPLIT_PART(a.keterangan, ' + ', 1)
--             END
                                               AS keterangan
                 FROM sc_trx.sewakendaraan a
                          INNER JOIN sc_mst.karyawan b ON b.nik = a.nik AND b.tglkeluarkerja IS NULL AND b.callplan = 't' AND b.kdcabang = vr_kdcabang
                          INNER JOIN sc_mst.regu_opr c ON c.nik = b.nik
                          LEFT JOIN LATERAL (
                     SELECT COUNT(x.custcode) AS jumlah
                     FROM (
                              SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
                              FROM sc_tmp.scheduletolocation xa
                              WHERE xa.nik = a.nik AND xa.scheduledate = a.tgl
                              GROUP BY 1
                          ) x
                     ) d ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT COUNT(x.custcode1) AS jumlah
                     FROM (
                              SELECT xa.userid, COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode1,
                                     COALESCE(NULLIF(xb.locationid, ''), NULLIF(xb.locationidlocal, '')) AS custcode2,
                                     xa.custname, xb.custname
                              FROM sc_tmp.checkinout xa
                                       LEFT OUTER JOIN sc_tmp.scheduletolocation xb
                                                       ON xa.userid = xb.userid
                              WHERE xa.checktime::DATE = a.tgl AND xa.nik = a.nik AND COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) = COALESCE(NULLIF(xb.locationid, ''), NULLIF(xb.locationidlocal, ''))
                              GROUP BY 1, xa.custname, xa.userid, xb.locationid, xa.customeroutletcode, xa.customercodelocal, xb.locationidlocal, xa.custname, xb.custname
                          ) x
                     ) e ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT jam_masuk, jam_pulang, jam_pulang_min
                     FROM sc_mst.jam_kerja
                     WHERE kdjam_kerja = CASE
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'SL' THEN 'SL1'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'SL' THEN 'SL2'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'SL' THEN 'SL3'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'NC' THEN 'NC1'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'NC' THEN 'NC2'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'NC' THEN 'NC3'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) THEN 'NSA'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (5) THEN 'NSB'
                                             WHEN EXTRACT(DOW FROM a.tgl) IN (6) THEN 'NSC'
                         END
                     ) f ON TRUE
                          LEFT JOIN LATERAL (
                     SELECT value1 AS callplan, value3 AS nominal
                     from sc_mst.option where kdoption = 'USK'
                     ) g ON TRUE
                          LEFT JOIN sc_trx.ijin_karyawan h ON h.nodok = a.dok_ref AND h.status = 'P'
                 WHERE a.tgl::DATE BETWEEN vr_tglawal AND vr_tglakhir
                 ORDER BY b.kdcabang, b.nmlengkap, a.tgl
             ) AS x
        WHERE a.nik = x.nik AND a.tgl = x.tgl;

    END IF;
END;
$$;

