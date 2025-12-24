DROP TRIGGER IF EXISTS tr_checklist_au ON sc_trx.checklist;

CREATE TRIGGER tr_checklist_au
    AFTER UPDATE
    ON sc_trx.checklist
    FOR EACH ROW
    EXECUTE PROCEDURE sc_trx.pr_checklist_au();
