DROP TRIGGER IF EXISTS tr_checklist_au ON sc_tmp.checklist;

CREATE TRIGGER tr_checklist_au
    AFTER UPDATE
    ON sc_tmp.checklist
    FOR EACH ROW
    EXECUTE PROCEDURE sc_tmp.pr_checklist_au();
