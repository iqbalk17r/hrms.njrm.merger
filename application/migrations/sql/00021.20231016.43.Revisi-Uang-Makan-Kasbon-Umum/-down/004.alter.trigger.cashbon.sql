create OR REPLACE function sc_tmp.tr_cashbon_after_update() returns trigger
    language plpgsql
as
$$
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
                approvedate,
                type
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
                  approvedate,
                  type
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

            DELETE FROM sc_trx.cashbon_component WHERE TRUE
                                                   AND cashbonid = NEW.cashbonid;

            INSERT INTO sc_trx.cashbon_component_po (
                branch,
                cashbonid,
                pono,
                nomor,
                stockcode,
                stockname,
                qty,
                pricelist,
                brutto,
                netto,
                dpp,
                ppn,
                inputby,
                inputdate,
                updateby,
                updatedate
            ) SELECT
                  branch,
                  number AS cashbonid,
                  pono,
                  nomor,
                  stockcode,
                  stockname,
                  qty,
                  pricelist,
                  brutto,
                  netto,
                  dpp,
                  ppn,
                  inputby,
                  inputdate,
                  updateby,
                  updatedate
            FROM sc_tmp.cashbon_component_po WHERE TRUE
                                               AND cashbonid = NEW.cashbonid;

            DELETE FROM sc_tmp.cashbon WHERE TRUE
                                         AND cashbonid = NEW.cashbonid;

            DELETE FROM sc_tmp.cashbon_component WHERE TRUE
                                                   AND cashbonid = NEW.cashbonid;

            DELETE FROM sc_tmp.cashbon_component_po WHERE TRUE
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
            type,
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
              type,
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

        DELETE FROM sc_trx.cashbon_component_po WHERE TRUE
                                                  AND cashbonid = NEW.cashbonid;
        INSERT INTO sc_trx.cashbon_component_po (
            branch,
            cashbonid,
            pono,
            nomor,
            stockcode,
            stockname,
            qty,
            pricelist,
            brutto,
            netto,
            dpp,
            ppn,
            inputby,
            inputdate,
            updateby,
            updatedate
        ) SELECT
              branch,
              cashbonid,
              pono,
              nomor,
              stockcode,
              stockname,
              qty,
              pricelist,
              brutto,
              netto,
              dpp,
              ppn,
              inputby,
              inputdate,
              updateby,
              updatedate
        FROM sc_tmp.cashbon_component_po WHERE TRUE
                                           AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_tmp.cashbon WHERE TRUE
                                     AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_tmp.cashbon_component WHERE TRUE
                                               AND cashbonid = NEW.cashbonid;

        DELETE FROM sc_tmp.cashbon_component_po WHERE TRUE
                                                  AND cashbonid = NEW.cashbonid;
    END IF;
    RETURN NEW;
END;
$$;


create OR REPLACE function sc_trx.tr_cashbon_after_update() returns trigger
    language plpgsql
as
$$
DECLARE
    number VARCHAR;
    total_cashbon INT;
    vr_nik VARCHAR;
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
            type,
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
              type,
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

        INSERT INTO sc_tmp.cashbon_component_po (
            branch,
            cashbonid,
            pono,
            nomor,
            stockcode,
            stockname,
            qty,
            pricelist,
            brutto,
            netto,
            dpp,
            ppn,
            inputby,
            inputdate,
            updateby,
            updatedate
        ) SELECT
              branch,
              cashbonid,
              pono,
              nomor,
              stockcode,
              stockname,
              qty,
              pricelist,
              brutto,
              netto,
              dpp,
              ppn,
              inputby,
              inputdate,
              updateby,
              updatedate
        FROM sc_trx.cashbon_component_po WHERE TRUE
                                           AND cashbonid = NEW.cashbonid;

        UPDATE sc_trx.cashbon SET
                                  status = OLD.status,
                                  updateby = OLD.updateby,
                                  updatedate = OLD.updatedate
        WHERE TRUE
          AND cashbonid = NEW.cashbonid;
    END IF;

    IF ( NEW.status = 'P' and OLD.status <> 'P' ) THEN
        IF( NEW.type = 'DN') THEN
            vr_nik:=TRIM(COALESCE(nik),'') FROM sc_trx.dinas WHERE trim(nodok) = NEW.dutieid;
        END IF;
        IF( NEW.type <> 'DN') THEN
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
            inputby,
            inputdate
        )
        VALUES(
                  vr_nik,
                  NEW.cashbonid,
                  NEW.totalcashbon,
                  0,
                  NEW.totalcashbon + total_cashbon,
                  'CASHBON',
                  'IN',
                  NEW.inputby,
                  now()
              );
    END IF;

    IF ( TRIM(NEW.flag) = 'YES' and TRIM(OLD.flag) <> 'YES') THEN
        UPDATE sc_trx.cashbon_blc SET
                                      "flag" = NEW."flag",
                                      voucher = NEW.voucher
        WHERE docno = NEW.cashbonid;
    END IF;

    RETURN NEW;
END;
$$;


