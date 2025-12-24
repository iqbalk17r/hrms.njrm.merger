create OR REPLACE function sc_tmp.pr_hitung_rekap_um(vr_kdcabang character, vr_tglawal date, vr_tglakhir date) returns SETOF void
    language plpgsql
as
$$
DECLARE
    -- Author By FIKY : 02/02/2017
    -- Update By ARBI : 29/10/2021
    -- Penyesuaian Realisasi Callplan Dengan Kolom NIK
    -- UPDATE By RKM : 26/08/2023
    -- Penambahan bbm dan sewa kendaraan
    vr_tglapproval DATE;
    vr_tgl_act DATE;
    vr_tgl_dok DATE;
    vr_nodok_ref CHARACTER(12);
    vr_nominal_um NUMERIC;
    vr_cek_nominal_um NUMERIC;
    vr_nik CHARACTER(12);
BEGIN
    FOR vr_nik IN SELECT TRIM(nik) FROM sc_mst.karyawan WHERE tglkeluarkerja IS NULL AND kdcabang = vr_kdcabang
        LOOP
            vr_nominal_um := CASE
                                 WHEN a.kdcabang = 'SMGDMK' THEN
                                    CASE
                                        WHEN callplan = 't' THEN b.besaran
                                        ELSE b.besaran - c.besaran
                                    END
                                    ELSE b.besaran
                                 END AS nominal
                             FROM sc_mst.karyawan a
                                      LEFT OUTER JOIN sc_mst.uangmakan b ON a.lvl_jabatan = b.kdlvl
                                      LEFT OUTER JOIN sc_mst.kantin c ON a.kdcabang = c.kdcabang
                                      LEFT OUTER JOIN sc_mst.regu_opr d ON a.nik = d.nik
                             WHERE a.nik = vr_nik;

            FOR vr_nodok_ref IN SELECT TRIM(dok_ref)
                                FROM sc_trx.uangmakan
                                WHERE nik = vr_nik AND dok_ref IS NOT NULL AND (LEFT(dok_ref, 2) = 'IK' OR LEFT(dok_ref, 2) = 'PA' OR LEFT(dok_ref,2) = 'DT')
                                  AND (TO_CHAR(tgl, 'YYYY-MM-DD') BETWEEN TO_CHAR(vr_tglawal - INTERVAL '1 WEEK', 'YYYY-MM-DD') AND TO_CHAR(vr_tglakhir, 'YYYY-MM-DD'))
                LOOP
                    SELECT CAST(TO_CHAR(approval_date, 'YYYY-MM-DD') AS DATE) INTO vr_tglapproval FROM sc_trx.ijin_karyawan WHERE nodok = vr_nodok_ref;
                    SELECT nominal INTO vr_cek_nominal_um FROM sc_trx.uangmakan WHERE dok_ref = vr_nodok_ref AND nik = vr_nik;

                    IF(vr_cek_nominal_um = 0 OR vr_cek_nominal_um IS NULL) THEN
                        UPDATE sc_trx.uangmakan SET
                            nominal = vr_nominal_um,
                            keterangan = '+ PERSETUJUAN NO IJIN : ' || vr_nodok_ref
                        where tgl = vr_tglapproval AND nik = vr_nik;
                    END IF;

                    RETURN NEXT vr_nodok_ref;
                END LOOP;

            RETURN NEXT vr_nik;
        END LOOP;

    UPDATE sc_trx.uangmakan AS a
    SET
        rencanacallplan = x.rencanacallplan,
        realisasicallplan = x.realisasicallplan,
        nominal = CASE
        WHEN callplan = 't' THEN
            CASE
                /*callplan terpenuhi*/
                WHEN x.realisasicallplan >= 1 AND x.realisasicallplan = x.rencanacallplan THEN
                    CASE
                        /*checkin & checkout sesuai jam kerja*/
                        WHEN x.checkin <= x.jam_masuk AND x.checkout >= x.jam_pulang THEN x.nominal
                        ELSE 0
                        END
                /*callplan tidak terpenuhi*/
                ELSE 0
            END
        ELSE x.nominal

        END,
        keterangan = x.keterangan,
        bbm = CASE
            WHEN x.tbbm = 'T' THEN
                case
                    when x.checkin <= x.jam_masuk_max AND x.checkout > x.jam_pulang_min THEN
                        CASE
                            WHEN x.worktime > 4 THEN
                                CASE
                                    WHEN nodok is not null AND type_ijin = 'DN' AND kendaraan = 'PRIBADI' THEN y.nominal
                                    WHEN x.checkin is not null AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN y.nominal
                                    ELSE 0
                                END
                            ELSE 0
                        END
                    else 0
                END
            ELSE 0
            END,
        sewa_kendaraan = CASE
             WHEN x.tsewa = 'T' THEN
                 case
                     when x.checkin <= x.jam_masuk_max AND x.checkout > x.jam_pulang_min THEN
                         CASE
                             WHEN x.worktime > 4 THEN
                                 CASE
                                     WHEN nodok is not null AND type_ijin = 'DN' AND kendaraan = 'PRIBADI' THEN z.nominal
                                     WHEN x.checkin is not null AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN z.nominal
                                     ELSE 0
                                 END
                             ELSE 0
                             END
                     else 0
                     END
             ELSE 0
            END
    FROM (
             SELECT
                 a.nik,
                 a.tgl,
                 d.jumlah AS rencanacallplan,
                 e.jumlah AS realisasicallplan,
                 a.checkin,
                 a.checkout,
                 EXTRACT(HOUR FROM (a.checkout - a.checkin)) AS worktime,
                    CASE WHEN b.callplan = 't' THEN
                         CASE
                             WHEN ((a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND h.tgl_jam_selesai >= checkout )
                                 OR (d.jumlah > 0 AND e.jumlah >= d.jumlah) AND (d.jumlah > 1) AND ( checkout >= jam_pulang AND checkin < jam_masuk)
                                      ) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
                             WHEN extract(day from now()::timestamp - b.tglmasukkerja::timestamp) <= 30
                                 AND (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND (h.tgl_jam_mulai <= checkin AND h.tgl_jam_selesai >= checkout ))
                                 AND (d.jumlah > 1)
                                 AND ( checkout >= jam_pulang AND checkin < jam_masuk)
                                 AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%'
                                 THEN g.nominal
                             WHEN (
                                          (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND (h.tgl_jam_mulai <= checkin AND h.tgl_jam_selesai >= checkout ))
                                          OR (d.jumlah > 0 AND e.jumlah >= d.jumlah) AND (d.jumlah > 1) AND ( checkout >= jam_pulang AND checkin < jam_masuk)
                                      ) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
                             ELSE null
                             END
                    ELSE
                        CASE
                            WHEN ((a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND h.tgl_jam_selesai >= checkout ) AND ( checkout >= jam_pulang AND checkin < jam_masuk)
                                     ) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
                            WHEN extract(day from now()::timestamp - b.tglmasukkerja::timestamp) <= 30
                                AND (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND (h.tgl_jam_mulai <= checkin AND h.tgl_jam_selesai >= checkout ))
                                AND ( checkout >= jam_pulang AND checkin < jam_masuk)
                                AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%'
                                THEN g.nominal
                            WHEN ( (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND (h.tgl_jam_mulai <= checkin AND h.tgl_jam_selesai >= checkout ))
                                          AND ( checkout >= jam_pulang AND checkin < jam_masuk)
                                     ) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
                            ELSE 0
                            END
                    END
                    AS nominal,
                    CASE
                        /*WHEN d.jumlah = 0 THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + TIDAK ADA RENCANA CALLPLAN'
                        WHEN e.jumlah >= d.jumlah THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TERPENUHI'
                        ELSE SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TIDAK TERPENUHI'*/
                        --WHEN a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND  h.status = 'P' AND ((h.tgl_jam_mulai <= f.jam_masuk AND h.tgl_jam_selesai <= jam_pulang) OR (h.tgl_jam_mulai >= f.jam_masuk AND h.tgl_jam_selesai <= jam_pulang)) THEN 'PULANG AWAL TOK'
                        WHEN (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND a.keterangan SIMILAR TO 'TEPAT WAKTU' AND e.jumlah < d.jumlah AND d.jumlah > 0 ) THEN a.keterangan || ' + IJIN DENGAN NO. '||a.dok_ref || ' + CALLPLAN TIDAK TERPENUHI'
                        WHEN (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.status = 'P' AND h.tgl_jam_mulai <= f.jam_masuk AND h.tgl_jam_selesai >= jam_pulang)
                            OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi NOT IN ('IK', 'DT', 'PA'))
                            OR (a.checkin IS NULL AND a.checkout IS NULL) OR a.keterangan SIMILAR TO '(DINAS|CUTI)%' THEN SPLIT_PART(a.keterangan, ' + ', 1)
                        WHEN d.jumlah = 0 AND c.kdregu = 'SL' THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + TIDAK ADA RENCANA CALLPLAN'
                        WHEN d.jumlah = 0 THEN SPLIT_PART(a.keterangan, ' + ', 1)
                        WHEN e.jumlah >= d.jumlah THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TERPENUHI'
                        ELSE SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TIDAK TERPENUHI'
                        END AS keterangan,
                h.nodok,
                h.type_ijin,
                h.kendaraan,
                COALESCE(TRIM(i.sewakendaraan),'') AS tsewa,
                COALESCE(TRIM(i.bbm),'') AS tbbm,
                jam_masuk,
                jam_pulang,
                jam_pulang_min,
                jam_masuk_max,
                c.kdregu,
                b.callplan
             FROM sc_trx.uangmakan a
                  INNER JOIN sc_mst.karyawan b ON b.nik = a.nik AND b.tglkeluarkerja IS NULL AND callplan = 't' AND b.kdcabang = vr_kdcabang
                  left OUTER JOIN sc_mst.jabatan i ON b.bag_dept = i.kddept AND b.subbag_dept = i.kdsubdept AND b.jabatan = i.kdjabatan
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
                     SELECT COUNT(x.custcode) AS jumlah
                     FROM (
                              SELECT COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode
                              FROM sc_tmp.checkinout xa
                              WHERE xa.checktime::DATE = a.tgl
                                AND xa.nik = a.nik
                                AND xa.customertype = 'C'
                                AND COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) IN (
                                  SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
                                  FROM sc_tmp.scheduletolocation xa
                                  WHERE xa.nik = a.nik AND xa.scheduledate = a.tgl
                                  GROUP BY 1
                              )
                              GROUP BY 1
                          ) x
                ) e ON TRUE
                      LEFT JOIN LATERAL (
                 SELECT jam_masuk, jam_pulang, jam_masuk_max, jam_pulang_min
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
                 SELECT
                     CASE
                         WHEN b.kdcabang = 'SMGDMK' THEN
                             CASE
                                 WHEN (c.kdregu = 'SL' OR b.callplan = 't') THEN xa.besaran
                                 ELSE xa.besaran - xb.besaran
                             END
                         ELSE xa.besaran
                         END AS nominal
                 FROM sc_mst.uangmakan xa
                 LEFT JOIN sc_mst.kantin xb ON xb.kdcabang = b.kdcabang
                 WHERE xa.kdlvl = b.lvl_jabatan
                 ) g ON TRUE
                LEFT JOIN sc_trx.ijin_karyawan h ON h.nodok = a.dok_ref AND h.status = 'P'
             WHERE a.tgl::DATE BETWEEN vr_tglawal AND vr_tglakhir
             ORDER BY b.kdcabang, b.nmlengkap, a.tgl
         ) AS x
             LEFT JOIN LATERAL (
        SELECT value3 as nominal from sc_mst.option where kdoption = 'UB'
        ) y ON TRUE
             LEFT JOIN LATERAL (
        SELECT value3 as nominal from sc_mst.option where kdoption = 'USK'
        ) z ON TRUE
    WHERE a.nik = x.nik AND a.tgl = x.tgl;
END;
$$;

