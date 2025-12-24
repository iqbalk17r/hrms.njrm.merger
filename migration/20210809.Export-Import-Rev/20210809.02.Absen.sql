-------------------------------------------------- SC_TMP.CEK_ABSEN --------------------------------------------------
CREATE OR REPLACE FUNCTION sc_tmp.pr_cek_absen()
    RETURNS trigger AS
$BODY$
DECLARE
    vr_hari INTEGER;
    vr_opsigaji CHARACTER;
    vr_gaji NUMERIC(18,2);
    vr_patokan NUMERIC(18,2);
BEGIN
	IF(new.status = 'P' AND old.status = 'I') THEN
	    SELECT value3 INTO vr_hari FROM sc_mst.option WHERE kdoption = 'E';
    	SELECT value1 INTO vr_opsigaji	FROM sc_mst.option WHERE kdoption = 'PAYROL04';

        IF(new.flag_cuti = 'YES') THEN
            IF(vr_opsigaji = 'A') THEN
                SELECT gajipokok INTO vr_gaji FROM sc_mst.karyawan WHERE nik = new.nik;
                vr_patokan := vr_gaji / vr_hari;
            ELSEIF(vr_opsigaji = 'B') THEN
                SELECT gajitetap INTO vr_gaji FROM sc_mst.karyawan WHERE nik = new.nik;
                vr_patokan := vr_gaji / vr_hari;
            END IF;
        ELSE
            vr_patokan := 0;
        END IF;

        UPDATE sc_tmp.cek_absen SET cuti_nominal = vr_patokan, gajipokok = vr_gaji where urut = new.urut;
	END IF;

    RETURN new;
END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_tmp.pr_cek_absen()
    OWNER TO postgres;
--#
DROP TRIGGER IF EXISTS tr_cek_absen_nominal ON sc_tmp.cek_absen;
--#
CREATE TRIGGER tr_cek_absen_nominal
    AFTER UPDATE
    ON sc_tmp.cek_absen
    FOR EACH ROW
    EXECUTE PROCEDURE sc_tmp.pr_cek_absen();
-------------------------------------------------- END OF: SC_TMP.CEK_ABSEN --------------------------------------------------
