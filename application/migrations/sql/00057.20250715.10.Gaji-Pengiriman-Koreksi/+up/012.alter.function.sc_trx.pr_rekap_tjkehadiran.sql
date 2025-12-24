-- DROP FUNCTION sc_trx.pr_rekap_tjkehadiran();

CREATE OR REPLACE FUNCTION sc_trx.pr_rekap_tjkehadiran()
 RETURNS void
 LANGUAGE plpgsql
AS $function$
BEGIN
    
    DELETE FROM sc_trx.rekap_tjkehadiran;

    INSERT INTO sc_trx.rekap_tjkehadiran (nik, nmlengkap, tanggal_mulai, tanggal_selesai, nmjabatan, kdjabatan, kdcabang, tjkehadiran, periode)
    
    WITH weekly_attendance AS (
        SELECT
            nik,
            tanggal_mulai,
            COUNT(day) AS hari_hadir
        FROM (
            SELECT
                e.nik,
                (d.day - (EXTRACT(DOW FROM d.day)::int - 1) * INTERVAL '1 day')::DATE AS tanggal_mulai,
                d.day
            FROM
                (SELECT DISTINCT nik FROM sc_trx.gajipengiriman) e
            CROSS JOIN (
                SELECT generate_series(min(tgl), max(tgl), '1 day'::interval)::date AS day
                FROM sc_trx.transready
            ) d
            LEFT JOIN sc_trx.transready tr ON e.nik = tr.nik AND d.day = tr.tgl
            LEFT JOIN sc_trx.dtljadwalkerja jw ON e.nik = jw.nik AND d.day = jw.tgl
            WHERE
                EXTRACT(DOW FROM d.day) BETWEEN 1 AND 6
                AND (
                    (tr.nik IS NOT NULL AND (tr.jam_masuk_absen IS NOT NULL OR tr.jam_pulang_absen IS NOT NULL))
                    OR
                    (tr.nik IS NULL AND jw.nik IS NULL)
                )
        ) AS valid_days
        GROUP BY
            nik,
            tanggal_mulai
    ),
    final_result AS (
        SELECT DISTINCT ON (wa.nik, wa.tanggal_mulai)
            wa.nik,
            k.nmlengkap,
            wa.tanggal_mulai,
            (wa.tanggal_mulai + INTERVAL '5 days')::DATE AS tanggal_selesai,
            j.nmjabatan,
            CASE
                WHEN j.nmjabatan = 'DRIVER' THEN 'DR'
                WHEN j.nmjabatan = 'HELPER' THEN 'HK'
                ELSE 'HG'
            END AS kdjabatan,
            k.kdcabang,
            CASE
                WHEN wa.hari_hadir = 6 THEN COALESCE(gp_mst.uang_kehadiran, 0)
                ELSE 0
            END AS tjkehadiran,
            TO_CHAR((wa.tanggal_mulai + INTERVAL '5 days')::DATE, 'YYYYMM') AS periode
        FROM
            weekly_attendance wa
        INNER JOIN sc_mst.karyawan k ON wa.nik = k.nik
        INNER JOIN sc_mst.jabatan j ON k.bag_dept = j.kddept
                                   AND k.subbag_dept = j.kdsubdept
                                   AND k.jabatan = j.kdjabatan
        LEFT JOIN sc_mst.gajipengiriman gp_mst ON k.kdcabang = gp_mst.kdcabang
                                             AND (CASE
                                                    WHEN j.nmjabatan = 'DRIVER' THEN 'DR'
                                                    WHEN j.nmjabatan = 'HELPER' THEN 'HK'
                                                    ELSE 'HG'
                                                 END) = gp_mst.kdjabatan
        ORDER BY
            wa.nik, wa.tanggal_mulai DESC
    )
    SELECT * FROM final_result;

END;
$function$
;
