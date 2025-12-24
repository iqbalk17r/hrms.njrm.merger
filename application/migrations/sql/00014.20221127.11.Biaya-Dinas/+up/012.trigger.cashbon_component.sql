CREATE OR REPLACE FUNCTION sc_tmp.tr_cashbon_component_after_insert_update()
    RETURNS trigger AS
$BODY$
DECLARE
BEGIN
    UPDATE sc_tmp.cashbon SET
        totalcashbon = ( SELECT SUM(a.totalcashbon) FROM sc_tmp.cashbon_component a WHERE TRUE AND a.cashbonid = NEW.cashbonid )
    WHERE TRUE
    AND cashbonid = NEW.cashbonid;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE COST 100;
DROP TRIGGER IF EXISTS tr_cashbon_component_after_insert_update ON sc_tmp.cashbon_component;
CREATE TRIGGER tr_cashbon_component_after_insert_update AFTER INSERT OR UPDATE ON sc_tmp.cashbon_component FOR EACH ROW EXECUTE PROCEDURE sc_tmp.tr_cashbon_component_after_insert_update();