CREATE OR REPLACE FUNCTION sc_trx.pr_checklist_au()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$

DECLARE
    -- Created By ARBI : 08/11/2021
BEGIN
     IF(old.status = 'P' AND new.status = 'E') THEN
        INSERT INTO sc_tmp.checklist
        SELECT *
        FROM sc_trx.checklist
        WHERE id_checklist = new.id_checklist;

        INSERT INTO sc_tmp.checklist_user
        SELECT *
        FROM sc_trx.checklist_user
        WHERE id_checklist = new.id_checklist;

        INSERT INTO sc_tmp.checklist_parameter
        SELECT *
        FROM sc_trx.checklist_parameter
        WHERE id_checklist = new.id_checklist;

        INSERT INTO sc_tmp.checklist_tanggal
        SELECT *
        FROM sc_trx.checklist_tanggal
        WHERE id_checklist = new.id_checklist;

        INSERT INTO sc_tmp.checklist_realisasi
        SELECT *
        FROM sc_trx.checklist_realisasi
        WHERE id_checklist = new.id_checklist;
    END IF;
RETURN new;
END;
$BODY$;

ALTER FUNCTION sc_trx.pr_checklist_au()
    OWNER TO postgres;
