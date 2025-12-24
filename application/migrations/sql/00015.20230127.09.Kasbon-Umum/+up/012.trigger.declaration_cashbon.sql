CREATE OR REPLACE FUNCTION sc_tmp.tr_declaration_cashbon_after_update()
    RETURNS trigger AS
$BODY$
DECLARE
    number VARCHAR;
BEGIN
    IF ( UPPER(NEW.status) = 'F' AND UPPER(OLD.status) <> 'F' ) THEN
        DELETE FROM sc_mst.penomoran WHERE TRUE AND userid = NEW.declarationid;
        IF NOT EXISTS ( SELECT TRUE FROM sc_mst.nomor WHERE TRUE AND dokumen = 'DECLCASHB' ) THEN
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
                'DECLCASHB',
                '',
                4,
                CONCAT('DC', TO_CHAR(NOW(), 'YY')),
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
            NEW.declarationid,
            'DECLCASHB',
            '',
            0,
            '',
            1,
            0
        );

        SELECT COALESCE(TRIM(nomor), '') INTO number
        FROM sc_mst.penomoran WHERE TRUE
        AND userid = new.declarationid;

        if (COALESCE(TRIM(number), '') <> '') THEN
            DELETE FROM sc_trx.declaration_cashbon WHERE TRUE
            AND declarationid = NEW.declarationid;

            INSERT INTO sc_trx.declaration_cashbon (
                branch,
                declarationid,
                cashbonid,
                dutieid,
                superior,
                status,
                paymenttype,
                totalcashbon,
                totaldeclaration,
                returnamount,
                inputby,
                inputdate,
                updateby,
                updatedate,
                approveby,
                approvedate
            ) SELECT
                branch,
                number AS declarationid,
                cashbonid,
                dutieid,
                superior,
                OLD.status AS status,
                paymenttype,
                totalcashbon,
                totaldeclaration,
                returnamount,
                inputby,
                inputdate,
                updateby,
                updatedate,
                approveby,
                approvedate
            FROM sc_tmp.declaration_cashbon WHERE TRUE
            AND declarationid = NEW.declarationid;

            DELETE FROM sc_trx.declaration_cashbon_component WHERE TRUE
            AND declarationid = NEW.declarationid;

            INSERT INTO sc_trx.declaration_cashbon_component (
                branch,
                declarationid,
                componentid,
                perday,
                nominal,
                description,
                inputby,
                inputdate,
                updateby,
                updatedate
            ) SELECT
                branch,
                number AS declarationid,
                componentid,
                perday,
                nominal,
                description,
                inputby,
                inputdate,
                updateby,
                updatedate
            FROM sc_tmp.declaration_cashbon_component WHERE TRUE
            AND declarationid = NEW.declarationid;

            DELETE FROM sc_tmp.declaration_cashbon WHERE TRUE
            AND declarationid = NEW.declarationid;

            DELETE FROM sc_tmp.declaration_cashbon_component WHERE TRUE
            AND declarationid = NEW.declarationid;
        END IF;
    END IF;

    IF ( UPPER(NEW.status) = 'U' AND UPPER(OLD.status) <> 'U' ) THEN
        DELETE FROM sc_trx.declaration_cashbon WHERE TRUE
        AND declarationid = NEW.declarationid;

        INSERT INTO sc_trx.declaration_cashbon (
            branch,
            declarationid,
            cashbonid,
            dutieid,
            superior,
            status,
            paymenttype,
            totalcashbon,
            totaldeclaration,
            returnamount,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        ) SELECT
            branch,
            declarationid,
            cashbonid,
            dutieid,
            superior,
            OLD.status AS status,
            paymenttype,
            totalcashbon,
            totaldeclaration,
            returnamount,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        FROM sc_tmp.declaration_cashbon WHERE TRUE
        AND declarationid = NEW.declarationid;

        DELETE FROM sc_trx.declaration_cashbon_component WHERE TRUE
        AND declarationid = NEW.declarationid;

        INSERT INTO sc_trx.declaration_cashbon_component (
            branch,
            declarationid,
            componentid,
            perday,
            nominal,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        ) SELECT
            branch,
            declarationid,
            componentid,
            perday,
            nominal,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        FROM sc_tmp.declaration_cashbon_component WHERE TRUE
        AND declarationid = NEW.declarationid;

        DELETE FROM sc_tmp.declaration_cashbon WHERE TRUE
        AND declarationid = NEW.declarationid;

        DELETE FROM sc_tmp.declaration_cashbon_component WHERE TRUE
        AND declarationid = NEW.declarationid;
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE COST 100;
DROP TRIGGER IF EXISTS tr_declaration_cashbon_after_update ON sc_tmp.declaration_cashbon;
CREATE TRIGGER tr_declaration_cashbon_after_update AFTER UPDATE ON sc_tmp.declaration_cashbon FOR EACH ROW EXECUTE PROCEDURE sc_tmp.tr_declaration_cashbon_after_update();

CREATE OR REPLACE FUNCTION sc_trx.tr_declaration_cashbon_after_update()
    RETURNS trigger AS
$BODY$
DECLARE
    total_cashbon INT;
    number VARCHAR;
	vr_nik VARCHAR;
	vr_type VARCHAR;
BEGIN
    IF ( UPPER(NEW.status) = 'U' AND UPPER(OLD.status) <> 'U' ) THEN
        IF ( NEW.updateby = OLD.updateby AND NEW.updatedate = OLD.updatedate ) THEN
            RAISE EXCEPTION 'Update data harus merubah nilai updateby dan updatedate';
        END IF;

        IF EXISTS ( SELECT TRUE FROM sc_tmp.declaration_cashbon WHERE TRUE AND declarationid = NEW.declarationid AND updateby <> NEW.updateby ) THEN
            RAISE EXCEPTION 'Data % sedang diupdate oleh %', NEW.declarationid, NEW.updateby;
        END IF;

        DELETE FROM sc_tmp.declaration_cashbon WHERE TRUE
        AND declarationid = NEW.declarationid
        AND updateby = NEW.updateby;

        INSERT INTO sc_tmp.declaration_cashbon (
            branch,
            declarationid,
            cashbonid,
            dutieid,
            superior,
            status,
            paymenttype,
            totalcashbon,
            totaldeclaration,
            returnamount,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        ) SELECT
            branch,
            declarationid,
            cashbonid,
            dutieid,
            superior,
            OLD.status AS status,
            paymenttype,
            totalcashbon,
            totaldeclaration,
            returnamount,
            inputby,
            inputdate,
            updateby,
            updatedate,
            approveby,
            approvedate
        FROM sc_trx.declaration_cashbon WHERE TRUE
        AND declarationid = NEW.declarationid;

        DELETE FROM sc_tmp.declaration_cashbon_component WHERE TRUE
        AND declarationid = NEW.declarationid;

        INSERT INTO sc_tmp.declaration_cashbon_component (
            branch,
            declarationid,
            componentid,
            perday,
            nominal,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        ) SELECT
            branch,
            declarationid,
            componentid,
            perday,
            nominal,
            description,
            inputby,
            inputdate,
            updateby,
            updatedate
        FROM sc_trx.declaration_cashbon_component WHERE TRUE
        AND declarationid = NEW.declarationid;

        UPDATE sc_trx.declaration_cashbon SET
            status = OLD.status,
            updateby = OLD.updateby,
            updatedate = OLD.updatedate
        WHERE TRUE
        AND declarationid = NEW.declarationid;
    END IF;

    IF ( UPPER(NEW.status) = 'P' AND UPPER(OLD.status) <> 'P' ) THEN vr_type:=TRIM(COALESCE(type),'') FROM sc_trx.cashbon WHERE TRIM(cashbonid) = NEW.cashbonid;
        IF( vr_type = 'DN') THEN
            vr_nik:=TRIM(COALESCE(nik),'') FROM sc_trx.dinas WHERE trim(nodok) = NEW.dutieid;
        END IF;
        IF( vr_type <> 'DN') THEN
            vr_nik:= NEW.dutieid;
        END IF;

        IF((SELECT balance from sc_trx.cashbon_blc where trim(nik)= vr_nik ORDER BY inputdate DESC LIMIT 1 ) IS NULL) OR ((SELECT balance from sc_trx.cashbon_blc where trim(nik)= vr_nik ORDER BY inputdate DESC LIMIT 1 ) = 0 ) THEN
            total_cashbon = 0;
        ELSE
            total_cashbon:= balance from sc_trx.cashbon_blc where trim(nik)= vr_nik ORDER BY inputdate DESC LIMIT 1;
        END IF;

        INSERT INTO sc_trx.cashbon_blc(
            nik,
            docno,
            cash_in,
            cash_out,
            balance,
            doctype,
            status,
            reference,
            inputby,
            inputdate
        )
        VALUES(
            vr_nik,
            NEW.declarationid,
            0,
            NEW.totalcashbon,
            total_cashbon - NEW.totalcashbon,
            'DECLARATION',
            'OUT',
            NEW.cashbonid,
            NEW.inputby,
            now()
          ) ;
        END IF;

        IF ( TRIM(NEW.flag) = 'YES' and TRIM(OLD.flag) <> 'YES') THEN
            UPDATE sc_trx.cashbon_blc SET
                "flag" = NEW."flag",
                voucher = NEW.voucher
            WHERE docno = NEW.declarationid;
        END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE COST 100;
DROP TRIGGER IF EXISTS tr_declaration_cashbon_after_update ON sc_trx.declaration_cashbon;
CREATE TRIGGER tr_declaration_cashbon_after_update AFTER UPDATE ON sc_trx.declaration_cashbon FOR EACH ROW EXECUTE PROCEDURE sc_trx.tr_declaration_cashbon_after_update();
