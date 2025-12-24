CREATE OR REPLACE FUNCTION sc_tmp.tr_declaration_cashbon_component_after_insert_update()
    RETURNS trigger AS
$BODY$
DECLARE
BEGIN
    UPDATE sc_tmp.declaration_cashbon SET
        totalcashbon = (
            SELECT COALESCE(b.totalcashbon, 0)
            FROM sc_tmp.declaration_cashbon a
            LEFT OUTER JOIN sc_trx.cashbon b ON TRUE
            AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
            WHERE TRUE
            AND TRIM(a.declarationid) = TRIM(NEW.declarationid)
        ),
        totaldeclaration = (
            SELECT SUM(a.nominal)
            FROM sc_tmp.declaration_cashbon_component a
            LEFT OUTER JOIN sc_mst.component_cashbon b ON TRUE
            AND TRIM(b.componentid) = TRIM(a.componentid)
            WHERE TRUE
            AND TRIM(a.declarationid) = TRIM(NEW.declarationid)
            AND b.calculated
        )
    WHERE TRUE
    AND declarationid = NEW.declarationid;
    UPDATE sc_tmp.declaration_cashbon SET
        returnamount = totalcashbon - totaldeclaration
    WHERE TRUE
    AND declarationid = NEW.declarationid;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE COST 100;
DROP TRIGGER IF EXISTS tr_declaration_cashbon_component_after_insert_update ON sc_tmp.declaration_cashbon_component;
CREATE TRIGGER tr_declaration_cashbon_component_after_insert_update AFTER INSERT OR UPDATE ON sc_tmp.declaration_cashbon_component FOR EACH ROW EXECUTE PROCEDURE sc_tmp.tr_declaration_cashbon_component_after_insert_update();