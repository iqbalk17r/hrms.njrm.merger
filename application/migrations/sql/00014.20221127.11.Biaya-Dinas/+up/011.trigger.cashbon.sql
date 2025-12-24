CREATE OR REPLACE FUNCTION sc_tmp.tr_cashbon_after_update()
    RETURNS trigger AS
$BODY$
DECLARE
    number VARCHAR;
BEGIN
    IF ( NEW.status = 'F' and OLD.status <> 'F' ) THEN
        DELETE FROM sc_mst.penomoran WHERE TRUE AND userid = NEW.cashbonid;
        IF NOT EXISTS ( SELECT TRUE FROM sc_mst.nomor WHERE TRUE AND dokumen = 'CASHBON' ) THEN
            INSERT INTO sc_mst.nomor (
                dokumen,
                part,
                count3,
                prefix,
                sufix,
                docno,
                userid,
                modul,
                periode,
                cekclose
            ) VALUES (
                'CASHBON',
                '',
                4,
                CONCAT('CB', TO_CHAR(NOW(), 'YY')),
                '',
                0,
                NEW.inputby,
                '',
                TO_CHAR(NOW(), 'YYYY'),
                'T'
                );
        END IF;

        INSERT INTO sc_mst.penomoran (
            userid,
            dokumen,
            nomor,
            errorid,
            partid,
            counterid,
            xno
        ) VALUES (
            NEW.cashbonid,
            'CASHBON',
            '',
            0,
            '',
            1,
            0
        );

        SELECT COALESCE(TRIM(nomor), '') INTO number
        FROM sc_mst.penomoran WHERE TRUE
        AND userid = new.cashbonid;

        if (COALESCE(TRIM(number), '') <> '') THEN
            DELETE FROM sc_trx.cashbon WHERE TRUE
            AND cashbonid = NEW.cashbonid;

            INSERT INTO sc_trx.cashbon (
                branch,
                cashbonid,
                dutieid,
                superior,
                status,
                paymenttype,
                totalcashbon,
                inputby,
                inputdate,
                updateby,
                updatedate,
                approveby,
                approvedate
            ) SELECT
                branch,
                number AS cashbonid,
                dutieid,
                superior,
                OLD.status AS status,
                paymenttype,
                totalcashbon,
                inputby,
                inputdate,
                updateby,
                updatedate,
                approveby,
                approvedate
            FROM sc_tmp.cashbon WHERE TRUE
            AND cashbonid = NEW.cashbonid;

            DELETE FROM sc_trx.cashbon_component WHERE TRUE
            AND cashbonid = NEW.cashbonid;

            INSERT INTO sc_trx.cashbon_component (
                branch,
                cashbonid,
                componentid,
                nominal,
                quantityday,
                totalcashbon,
                description,
                inputby,
                inputdate,
                updateby,
                updatedate
            ) SELECT
                branch,
                number AS cashbonid,
                componentid,
                nominal,
                quantityday,
                totalcashbon,
                description,
                inputby,
                inputdate,
                updateby,
                updatedate
            FROM sc_tmp.cashbon_component WHERE TRUE
            AND cashbonid = NEW.cashbonid;

            DELETE FROM sc_tmp.cashbon WHERE TRUE
            AND cashbonid = NEW.cashbonid;

            DELETE FROM sc_tmp.cashbon_component WHERE TRUE
            AND cashbonid = NEW.cashbonid;
        END IF;
    END IF;

    IF ( NEW.status = 'U' and OLD.status <> 'U' ) THEN
        DELETE FROM sc_trx.cashbon WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        INSERT INTO sc_trx.cashbon (
            branch,
            cashbonid,
            dutieid,
            superior,
            status,
            paymenttype,
            totalcashbon,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        ) SELECT
            branch,
            cashbonid,
            dutieid,
            superior,
            OLD.status AS status,
            paymenttype,
            totalcashbon,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        FROM sc_tmp.cashbon WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_trx.cashbon_component WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        INSERT INTO sc_trx.cashbon_component (
            branch,
            cashbonid,
            componentid,
            nominal,
            quantityday,
            totalcashbon,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        ) SELECT
            branch,
            cashbonid,
            componentid,
            nominal,
            quantityday,
            totalcashbon,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        FROM sc_tmp.cashbon_component WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_tmp.cashbon WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_tmp.cashbon_component WHERE TRUE
        AND cashbonid = NEW.cashbonid;
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE COST 100;
DROP TRIGGER IF EXISTS tr_cashbon_after_update ON sc_tmp.cashbon;
CREATE TRIGGER tr_cashbon_after_update AFTER UPDATE ON sc_tmp.cashbon FOR EACH ROW EXECUTE PROCEDURE sc_tmp.tr_cashbon_after_update();

CREATE OR REPLACE FUNCTION sc_trx.tr_cashbon_after_update()
    RETURNS trigger AS
$BODY$
DECLARE
    number VARCHAR;
BEGIN
    IF ( NEW.status = 'U' and OLD.status <> 'U' ) THEN
        DELETE FROM sc_tmp.cashbon WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        INSERT INTO sc_tmp.cashbon (
            branch,
            cashbonid,
            dutieid,
            superior,
            status,
            paymenttype,
            totalcashbon,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        ) SELECT
            branch,
            cashbonid,
            dutieid,
            superior,
            OLD.status AS status,
            paymenttype,
            totalcashbon,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        FROM sc_trx.cashbon WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_tmp.cashbon_component WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        INSERT INTO sc_tmp.cashbon_component (
            branch,
            cashbonid,
            componentid,
            nominal,
            quantityday,
            totalcashbon,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        ) SELECT
            branch,
            cashbonid,
            componentid,
            nominal,
            quantityday,
            totalcashbon,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        FROM sc_trx.cashbon_component WHERE TRUE
        AND cashbonid = NEW.cashbonid;

        UPDATE sc_trx.cashbon SET
            status = OLD.status,
            updateby = OLD.updateby,
            updatedate = OLD.updatedate
        WHERE TRUE
        AND cashbonid = NEW.cashbonid;
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE COST 100;
DROP TRIGGER IF EXISTS tr_cashbon_after_update ON sc_trx.cashbon;
CREATE TRIGGER tr_cashbon_after_update AFTER UPDATE ON sc_trx.cashbon FOR EACH ROW EXECUTE PROCEDURE sc_trx.tr_cashbon_after_update();
