CREATE OR REPLACE FUNCTION sc_tmp.pr_hitung_rekap_um(vr_kdcabang CHARACTER, vr_tglawal DATE, vr_tglakhir DATE)
    RETURNS SETOF void
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE
    ROWS 1000
AS $BODY$
DECLARE
    -- Author By FIKY : 02/02/2017
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
                WHEN a.kdcabang = 'SMGDMK' THEN b.besaran - c.besaran
                ELSE b.besaran
                END AS nominal
            FROM sc_mst.karyawan a
            LEFT OUTER JOIN sc_mst.uangmakan b ON a.lvl_jabatan = b.kdlvl
            LEFT OUTER JOIN sc_mst.kantin c ON a.kdcabang = c.kdcabang
            WHERE a.nik = vr_nik;

        FOR vr_nodok_ref IN SELECT TRIM(dok_ref)
            FROM sc_trx.uangmakan
            WHERE nik = vr_nik AND dok_ref IS NOT NULL AND (LEFT(dok_ref, 2) = 'IK' OR LEFT(dok_ref, 2) = 'PA' OR LEFT(dok_ref,2) = 'DT')
            AND (TO_CHAR(tgl, 'YYYY-MM-DD') BETWEEN TO_CHAR(vr_tglawal - INTERVAL '1 WEEK', 'YYYY-MM-DD') AND TO_CHAR(vr_tglakhir, 'YYYY-MM-DD'))
        LOOP
            SELECT CAST(TO_CHAR(approval_date, 'YYYY-MM-DD') AS DATE) INTO vr_tglapproval FROM sc_trx.ijin_karyawan WHERE nodok = vr_nodok_ref;
            SELECT nominal INTO vr_cek_nominal_um FROM sc_trx.uangmakan WHERE dok_ref = vr_nodok_ref AND nik = vr_nik;

            IF(vr_cek_nominal_um = 0 OR vr_cek_nominal_um IS NULL) THEN
                UPDATE sc_trx.uangmakan SET nominal = vr_nominal_um, keterangan = '+ PERSETUJUAN NO IJIN : ' || vr_nodok_ref where tgl = vr_tglapproval AND nik = vr_nik;
            END IF;

            RETURN NEXT vr_nodok_ref;
        END LOOP;

        RETURN NEXT vr_nik;
    END LOOP;
END;
$BODY$;

ALTER FUNCTION sc_tmp.pr_hitung_rekap_um(CHARACTER, DATE, DATE)
    OWNER TO postgres;
