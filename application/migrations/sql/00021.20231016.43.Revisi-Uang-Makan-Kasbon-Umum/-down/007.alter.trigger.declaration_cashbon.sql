create OR REPLACE function sc_trx.tr_declaration_cashbon_after_update() returns trigger
    language plpgsql
as
$$
DECLARE
    total_cashbon INT;
    number VARCHAR;
    vr_nik VARCHAR;
    vr_type VARCHAR;
    vr_ref VARCHAR;
    val_cashin INT;
    val_cashout INT;
    val_balance INT;
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

    IF ( UPPER(NEW.status) = 'P' AND UPPER(OLD.status) <> 'P' ) THEN
        vr_type:=TRIM(COALESCE(type),'') FROM sc_trx.cashbon WHERE TRIM(cashbonid) = NEW.cashbonid;
        IF( vr_type = 'DN' OR vr_type is null) THEN
            vr_nik:=TRIM(COALESCE(nik),'') FROM sc_trx.dinas WHERE trim(nodok) = NEW.dutieid;
            vr_ref = NEW.dutieid;
        END IF;
        IF( vr_type <> 'DN' OR vr_type is not NULL) THEN
            vr_nik:= NEW.dutieid;
            vr_ref = NEW.cashbonid;
        END IF;
        IF((SELECT balance from sc_trx.cashbon_blc where trim(nik)= vr_nik ORDER BY inputdate DESC LIMIT 1 ) IS NULL) OR ((SELECT balance from sc_trx.cashbon_blc where trim(nik)= vr_nik ORDER BY inputdate DESC LIMIT 1 ) = 0 ) THEN
            total_cashbon = 0;
        ELSE
            total_cashbon:= balance from sc_trx.cashbon_blc where trim(nik)= vr_nik ORDER BY inputdate DESC LIMIT 1;
        END IF;

        IF vr_type IS NULL THEN
            val_cashout = NEW.totaldeclaration;
            val_cashin = NEW.totaldeclaration;
            val_balance = val_cashout - val_cashin;
        ELSE
            val_cashout = NEW.totalcashbon;
            val_cashin = 0;
            val_balance = total_cashbon - NEW.totalcashbon;
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
                  val_cashin,
                  val_cashout,
                  val_balance,
                  'DECLARATION',
                  'OUT',
                  vr_ref,
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
$$;

alter function sc_trx.tr_declaration_cashbon_after_update() owner to postgres;

