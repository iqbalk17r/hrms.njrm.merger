CREATE OR REPLACE FUNCTION sc_tmp.pr_generate_transready(
    vr_tglawal  character,
    vr_tglakhir character,
    vr_kdcabang character
)
    RETURNS timestamp without time zone
    LANGUAGE plpgsql
AS $function$
DECLARE
    vr_nik              char(12);
    vr_badgenumber      char(12);
    vr_tgl_min_masuk    timestamp without time zone;
    vr_tgl_max_pulang   timestamp without time zone;
    vr_jam_masuk_absen  time without time zone;
    vr_jam_pulang_absen time without time zone;
    vr_kdjamkerja       char(12);
    vr_jam_masuk        time without time zone;
    vr_jam_pulang       time without time zone;
    vr_shiftke          char(12);
    vr_tgl              char(12);
    vr_kdregu           char(20);
    vr_jam_masuk_min    time without time zone;
    vr_jam_pulang_min   time without time zone;
    vr_jam_masuk_max    time without time zone;
    vr_jam_pulang_max   time without time zone;

BEGIN
    RAISE NOTICE 'Cabang: % | Dari: % | Sampai: %', vr_kdcabang, vr_tglawal, vr_tglakhir;

    ----------------------------------------------------------------------------
    -- TANPA DELETE! Diganti UPSERT agar tidak menimpa editan = 't'
    ----------------------------------------------------------------------------

    FOR vr_nik, vr_tgl IN
        SELECT DISTINCT a.nik,
                        to_char(a.tgl,'YYYY-MM-DD')
        FROM sc_trx.dtljadwalkerja a
                 LEFT JOIN sc_mst.karyawan c ON a.nik = c.nik
        WHERE to_char(a.tgl,'YYYY-MM-DD') BETWEEN vr_tglawal AND vr_tglakhir
          AND c.kdcabang = vr_kdcabang
          AND COALESCE(c.statuskepegawaian,'') <> 'KO'
          AND COALESCE(a.kdjamkerja,'OFF') <> 'OFF'
        ORDER BY a.nik, to_char(a.tgl,'YYYY-MM-DD')
        LOOP

        ----------------------------------------------------------------------------
        -- Ambil jam kerja & atur tanggal min-max untuk absen
        ----------------------------------------------------------------------------
            SELECT
                a.kdjamkerja,
                b.jam_masuk,
                b.jam_masuk_min,
                b.jam_masuk_max,
                b.jam_pulang,
                b.jam_pulang_min,
                b.jam_pulang_max,
                b.shiftke,

                CASE
                    WHEN b.shiftke='2' AND b.kdharimasuk='H-'
                        THEN (a.tgl::date - 1)::text || ' ' || to_char(b.jam_masuk_min,'HH24:MI:SS')
                    ELSE a.tgl::date::text || ' ' || to_char(b.jam_masuk_min,'HH24:MI:SS')
                    END::timestamp AS tgl_min_masuk,

                CASE
                    WHEN b.shiftke='3' AND b.kdharipulang='H+'
                        THEN (a.tgl::date + 1)::text || ' ' || to_char(b.jam_pulang_max,'HH24:MI:SS')
                    ELSE a.tgl::date::text || ' ' || to_char(b.jam_pulang_max,'HH24:MI:SS')
                    END::timestamp AS tgl_max_pulang,

                a.kdregu
            INTO
                vr_kdjamkerja,
                vr_jam_masuk,
                vr_jam_masuk_min,
                vr_jam_masuk_max,
                vr_jam_pulang,
                vr_jam_pulang_min,
                vr_jam_pulang_max,
                vr_shiftke,
                vr_tgl_min_masuk,
                vr_tgl_max_pulang,
                vr_kdregu
            FROM sc_trx.dtljadwalkerja a
                     JOIN sc_mst.jam_kerja b ON a.kdjamkerja = b.kdjam_kerja
            WHERE to_char(a.tgl,'YYYY-MM-DD') = vr_tgl
              AND a.nik = vr_nik
            LIMIT 1;

            ----------------------------------------------------------------------------
            -- Ambil checkin & checkout aktual
            ----------------------------------------------------------------------------
            SELECT
                MIN(a.checktime),
                MAX(a.checktime)
            INTO
                vr_jam_masuk_absen,
                vr_jam_pulang_absen
            FROM sc_tmp.checkinout a
                     JOIN sc_mst.karyawan b ON a.badgenumber = b.idabsen
            WHERE b.nik = vr_nik
              AND a.checktime >= vr_tgl_min_masuk
              AND a.checktime <= vr_tgl_max_pulang;

            ----------------------------------------------------------------------------
            -- UPSERT: Insert jika belum ada, Update jika ada (Kecuali editan = 't')
            ----------------------------------------------------------------------------
            INSERT INTO sc_trx.transready (
                badgenumber,
                nik,
                tgl,
                kdjamkerja,
                jam_masuk,
                jam_masuk_min,
                jam_pulang,
                jam_pulang_max,
                shiftke,
                jam_masuk_absen,
                jam_pulang_absen,
                kdregu
            )
            VALUES (
                       vr_badgenumber,
                       vr_nik,
                       CAST(vr_tgl AS date),
                       vr_kdjamkerja,
                       vr_jam_masuk,
                       vr_jam_masuk_min,
                       vr_jam_pulang,
                       vr_jam_pulang_max,
                       vr_shiftke,
                       vr_jam_masuk_absen,
                       vr_jam_pulang_absen,
                       vr_kdregu
                   )
            ON CONFLICT (nik, tgl, kdjamkerja)
                DO UPDATE SET
                              badgenumber        = EXCLUDED.badgenumber,
                              kdjamkerja         = EXCLUDED.kdjamkerja,
                              jam_masuk          = EXCLUDED.jam_masuk,
                              jam_masuk_min      = EXCLUDED.jam_masuk_min,
                              jam_pulang         = EXCLUDED.jam_pulang,
                              jam_pulang_max     = EXCLUDED.jam_pulang_max,
                              shiftke            = EXCLUDED.shiftke,
                              jam_masuk_absen    = EXCLUDED.jam_masuk_absen,
                              jam_pulang_absen   = EXCLUDED.jam_pulang_absen,
                              kdregu             = EXCLUDED.kdregu
            WHERE sc_trx.transready.editan IS DISTINCT FROM 't';

        END LOOP;

    RETURN now();
END;
$function$;