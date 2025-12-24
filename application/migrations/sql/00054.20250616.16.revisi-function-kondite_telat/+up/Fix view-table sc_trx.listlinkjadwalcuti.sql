-- sc_trx.listlinkjadwalcuti source

CREATE OR REPLACE VIEW sc_trx.listlinkjadwalcuti
AS SELECT t3.nik,
    t3.tgl,
    t3.kdjamkerja,
    t3.kdregu,
        CASE
            WHEN t3.dokcuti IS NOT NULL THEN t3.dokcuti
            WHEN t3.doksd IS NOT NULL THEN t3.doksd
            WHEN t3.dokdinas IS NOT NULL THEN t3.dokdinas
            WHEN t3.dokcb IS NOT NULL THEN t3.dokcb
            ELSE NULL::bpchar
        END AS nodok,
    t3.tgl_mulai,
    t3.tgl_selesai,
    t3.kdpokok,
    t3.masuk,
    t3.keluar
   FROM ( SELECT a.nik,
            a.tgl,
            a.kdjamkerja,
            a.kdregu,
            t2.dokcuti,
            t2.dokdinas,
            t2.dokcb,
            t2.doksd,
            t2.tgl_mulai,
            t2.tgl_selesai,
                CASE
                    WHEN a.kdjamkerja IS NOT NULL AND t1.masuk IS NULL AND t1.keluar IS NULL AND (t2.dokcuti = ''::bpchar OR t2.dokcuti IS NULL) AND (t2.dokdinas = ''::bpchar OR t2.dokdinas IS NULL) AND (t2.dokcb = ''::bpchar OR t2.dokcb IS NULL) AND (t2.doksd = ''::bpchar OR t2.doksd IS NULL) THEN 'AL'::bpchar
                    WHEN t2.dokcuti IS NOT NULL AND t2.tpcuti = 'A'::bpchar THEN 'CT'::bpchar
                    WHEN t2.dokcuti IS NOT NULL AND t2.tpcuti = 'B'::bpchar THEN 'CK'::bpchar
                    WHEN t2.doksd IS NOT NULL THEN 'SD'::bpchar
                    WHEN t2.dokdinas IS NOT NULL THEN 'DN'::bpchar
                    WHEN t2.dokcb IS NOT NULL THEN 'CB'::bpchar
                    ELSE a.kdjamkerja
                END AS kdpokok,
            t1.masuk,
            t1.keluar
           FROM sc_trx.dtljadwalkerja a
             LEFT JOIN ( SELECT transready.nik,
                    transready.tgl,
                    min(transready.jam_masuk_absen) AS masuk,
                    max(transready.jam_pulang_absen) AS keluar
                   FROM sc_trx.transready
                  GROUP BY transready.nik, transready.tgl
                  ORDER BY transready.tgl) t1 ON t1.nik = a.nik AND t1.tgl = a.tgl
             LEFT JOIN ( SELECT a_1.nik,
                    a_1.tgl,
                    a_1.kdjamkerja,
                    a_1.kdregu,
                    a_1.kdmesin,
                    a_1.inputby,
                    a_1.inputdate,
                    a_1.updateby,
                    a_1.updatedate,
                    a_1.shift,
                    a_1.id,
                        CASE
                            WHEN b.tgl_mulai IS NOT NULL THEN b.tgl_mulai::timestamp without time zone
                            WHEN c.tgl_mulai IS NOT NULL THEN c.tgl_mulai::timestamp without time zone
                            WHEN d.tgl_mulai IS NOT NULL THEN d.tgl_mulai
                            ELSE NULL::timestamp without time zone
                        END AS tgl_mulai,
                        CASE
                            WHEN b.tgl_selesai IS NOT NULL THEN b.tgl_selesai::timestamp without time zone
                            WHEN c.tgl_selesai IS NOT NULL THEN c.tgl_selesai::timestamp without time zone
                            WHEN d.tgl_selesai IS NOT NULL THEN d.tgl_selesai
                            ELSE NULL::timestamp without time zone
                        END AS tgl_selesai,
                    b.tpcuti,
                    b.nodok AS dokcuti,
                    c.nodok AS dokdinas,
                    d.nodok AS dokcb,
                    ik.nodok AS doksd
                   FROM sc_trx.dtljadwalkerja a_1
                     LEFT JOIN sc_trx.cuti_karyawan b ON a_1.nik = b.nik AND a_1.tgl >= b.tgl_mulai AND a_1.tgl <= b.tgl_selesai AND b.status = 'P'::bpchar
                     LEFT JOIN sc_trx.dinas c ON a_1.nik = c.nik AND a_1.tgl >= c.tgl_mulai AND a_1.tgl <= c.tgl_selesai AND c.status::bpchar = 'P'::bpchar
                     LEFT JOIN sc_trx.ijin_karyawan ik ON a_1.nik = ik.nik AND a_1.tgl = ik.tgl_kerja AND ik.status = 'P'::bpchar AND ik.kdijin_absensi = 'KD'::bpchar
                     LEFT JOIN ( SELECT a_2.nik,
                            b_1.nodok,
                            b_1.tgl_dok,
                            b_1.status,
                            b_1.tgl_awal AS tgl_mulai,
                            b_1.tgl_akhir AS tgl_selesai,
                            b_1.input_by,
                            b_1.input_date,
                            b_1.update_by,
                            b_1.update_date,
                            b_1.jumlahcuti,
                            b_1.keterangan
                           FROM sc_trx.cuti_blc a_2
                             LEFT JOIN sc_trx.cutibersama b_1 ON a_2.no_dokumen::bpchar = b_1.nodok AND b_1.status = 'P'::bpchar AND a_2.status::text = 'F'::text) d ON a_1.nik = d.nik AND a_1.tgl >= to_char(d.tgl_selesai, 'yyyy-mm-dd'::text)::date AND a_1.tgl <= to_char(d.tgl_selesai, 'yyyy-mm-dd'::text)::date AND d.status = 'P'::bpchar) t2 ON a.nik = t2.nik AND a.tgl = t2.tgl
          GROUP BY a.nik, a.tgl, a.kdjamkerja, a.kdregu, t2.dokcuti, t2.tgl_mulai, t2.tgl_selesai, t1.masuk, t1.keluar, t2.tpcuti, t2.dokdinas, t2.dokcb, t2.doksd) t3
  ORDER BY t3.tgl;