DROP function if EXISTS sc_mst.update_employee_status_changes();
CREATE OR REPLACE FUNCTION sc_mst.update_employee_status_changes()
RETURNS TABLE (
    nik VARCHAR,
    nmlengkap VARCHAR,
    statuskepegawaian VARCHAR,
    tgl_mulai DATE,
    status VARCHAR,
    latest_status VARCHAR
)
LANGUAGE plpgsql
AS $function$
DECLARE
    contract RECORD;
BEGIN
    FOR contract IN
        SELECT a.nik, a.nmlengkap, a.statuskepegawaian, b.tgl_mulai, b.status, b.kdkepegawaian as latest_status
        FROM sc_mst.karyawan a
        INNER JOIN sc_trx.status_kepegawaian b ON a.nik = b.nik AND b.status = 'B'
        WHERE a.statuskepegawaian <> b.kdkepegawaian
    LOOP
        UPDATE sc_mst.karyawan
        SET
            statuskepegawaian = contract.latest_status,
            updateby = 'SYSTEM',
            updatedate = now()
        WHERE
            sc_mst.karyawan.nik = contract.nik;
    END LOOP;
END;
$function$;