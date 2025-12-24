ALTER TABLE sc_tmp.agenda ADD calendar_id varchar NULL;
ALTER TABLE sc_trx.agenda ADD calendar_id varchar NULL;

--=====================Function: sc_tmp.pr_agenda_after()==================
-- Function: sc_tmp.pr_agenda_after()

-- DROP FUNCTION sc_tmp.pr_agenda_after();

CREATE OR REPLACE FUNCTION sc_tmp.pr_agenda_after()
  RETURNS trigger AS
$BODY$
declare
    vr_nomor char(30);
begin
    IF (new.status = 'F' AND old.status <> 'F') THEN
        delete from sc_mst.penomoran where userid = new.agenda_id;

        IF NOT EXISTS (SELECT TRUE FROM sc_mst.nomor WHERE TRUE AND dokumen = 'AGENDA') THEN
            INSERT INTO sc_mst.nomor (dokumen,
                                      part,
                                      count3,
                                      prefix,
                                      sufix,
                                      docno,
                                      userid,
                                      modul,
                                      periode,
                                      cekclose)
            VALUES ('AGENDA',
                    '',
                    4,
                    CONCAT('AG', TO_CHAR(NOW(), 'YYYYMM')),
                    '',
                    0,
                    NEW.agenda_id,
                    '',
                    TO_CHAR(NOW(), 'YYYY'),
                    'T');
        END IF;
        UPDATE sc_mst.nomor SET prefix = CONCAT('AG', TO_CHAR(NOW(), 'YYYYMM')) WHERE dokumen = 'AGENDA';
        insert into sc_mst.penomoran
        (userid, dokumen, nomor, errorid, partid, counterid, xno)
        values (new.agenda_id, 'AGENDA', ' ', 0, ' ', 1, 0);
        vr_nomor := trim(coalesce(nomor, '')) from sc_mst.penomoran where userid = new.agenda_id;
        if (trim(vr_nomor) != '') or (not vr_nomor is null) then
            INSERT INTO sc_trx.agenda(
                agenda_id,
                branch_id,
                agenda_name,
                agenda_type,
                organizer_type,
                organizer_name,
                description,
                resulttext,
                sertificate_validity_period,
                participant_count,
                begin_date,
                end_date,
                location,
                link,
                status,
                properties,
                input_by,
                input_date,
                update_by,
                update_date,
                approve_by,
                approve_date,
                cancel_by,
                cancel_date,
                cancel_reason,
                delete_by,
                delete_date,
                delete_reason,
                calendar_id
            )
            SELECT
                vr_nomor,
                branch_id,
                agenda_name,
                agenda_type,
                organizer_type,
                organizer_name,
                description,
                resulttext,
                sertificate_validity_period,
                participant_count,
                begin_date,
                end_date,
                location,
                link,
                'S' AS status,
                properties,
                input_by,
                input_date,
                update_by,
                update_date,
                approve_by,
                approve_date,
                cancel_by,
                cancel_date,
                cancel_reason,
                delete_by,
                delete_date,
                delete_reason,
                calendar_id
            from sc_tmp.agenda
            where agenda_id = new.agenda_id;
            delete
            from sc_tmp.agenda
            where agenda_id = new.agenda_id;
        end if;


    END IF;
    IF (new.status = 'U' AND old.status <> 'U') THEN
        DELETE FROM sc_trx.agenda WHERE TRUE AND agenda_id = NEW.agenda_id;
        INSERT INTO sc_trx.agenda(
            agenda_id,
            branch_id,
            agenda_name,
            agenda_type,
            organizer_type,
            organizer_name,
            description,
            resulttext,
            sertificate_validity_period,
            participant_count,
            begin_date,
            end_date,
            location,
            link,
            status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason,
            calendar_id
        )
        SELECT
            agenda_id,
            branch_id,
            agenda_name,
            agenda_type,
            organizer_type,
            organizer_name,
            description,
            resulttext,
            sertificate_validity_period,
            participant_count,
            begin_date,
            end_date,
            location,
            link,
            old.status AS status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason,
            calendar_id
        from sc_tmp.agenda
        where agenda_id = new.agenda_id;

        DELETE FROM sc_trx.agenda_attendance WHERE TRUE AND trim(agenda_id) = trim(NEW.agenda_id);
        INSERT INTO sc_trx.agenda_attendance(
            agenda_id,
            nik,
            branch_id,
            confirm_status,
            attend_status,
            status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason
        )
        SELECT
            agenda_id,
            nik,
            branch_id,
            confirm_status,
            attend_status,
            'F' AS status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason
        from sc_tmp.agenda_attendance
        where agenda_id = new.agenda_id;

        delete
        from sc_tmp.agenda
        where trim(agenda_id) = trim(new.agenda_id);
        delete
        from sc_tmp.agenda_attendance
        where trim(agenda_id) = trim(new.agenda_id);
    end if;

    RETURN NEW;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.pr_agenda_after()
  OWNER TO postgres;
  
--=============================================================================

-- Function: sc_trx.pr_agenda_after()

-- DROP FUNCTION sc_trx.pr_agenda_after();

CREATE OR REPLACE FUNCTION sc_trx.pr_agenda_after()
  RETURNS trigger AS
$BODY$
declare
    vr_nomor char(30);
begin
    IF (new.status = 'U' AND old.status <> 'U') THEN
        DELETE FROM sc_tmp.agenda WHERE TRUE AND agenda_id = NEW.agenda_id;
        INSERT INTO sc_tmp.agenda(
            agenda_id,
            branch_id,
            agenda_name,
            agenda_type,
            organizer_type,
            organizer_name,
            description,
            resulttext,
            sertificate_validity_period,
            participant_count,
            begin_date,
            end_date,
            location,
            link,
            status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason,
            calendar_id
        )
        SELECT
            agenda_id,
            branch_id,
            agenda_name,
            agenda_type,
            organizer_type,
            organizer_name,
            description,
            resulttext,
            sertificate_validity_period,
            participant_count,
            begin_date,
            end_date,
            location,
            link,
            old.status AS status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason,
            calendar_id
        from sc_trx.agenda
        where agenda_id = new.agenda_id;

        /*DELETE FROM sc_tmp.agenda_attendance WHERE TRUE AND trim(agenda_id) = trim(NEW.agenda_id);
        INSERT INTO sc_tmp.agenda_attendance(
            agenda_id,
            nik,
            branch_id,
            confirm_status,
            attend_status,
            status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason,
            calendar_id
        )
        SELECT
            agenda_id,
            nik,
            branch_id,
            confirm_status,
            attend_status,
            'I' AS status,
            properties,
            input_by,
            input_date,
            update_by,
            update_date,
            approve_by,
            approve_date,
            cancel_by,
            cancel_date,
            cancel_reason,
            delete_by,
            delete_date,
            delete_reason,
            calendar_id
        from sc_trx.agenda_attendance
        where trim(agenda_id) = trim(new.agenda_id);*/

        UPDATE sc_trx.agenda
        SET status      = OLD.status,
            update_by   = OLD.update_by,
            update_date = OLD.update_date
        WHERE TRUE
          AND agenda_id = NEW.agenda_id;
    end if;

    RETURN NEW;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_trx.pr_agenda_after()
  OWNER TO postgres;


--=====================OPTION GOOGLE CALENDAR=========================
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:CLIENTID', 'CLIENTID API GOOGLE', '821509559352-s6gl7ckk1biikrfqh3mul9r79ridece2.apps.googleusercontent.com', NULL, NULL, 'T', 'SETUP CLIENT ID GOOGLE CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL, 'GOOGLE');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:CLIENTSECRET', 'CLIENT SECRET API GOOGLE', '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', NULL, NULL, 'T', 'SETUP CLIENT SECRET GOOGLE CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL, 'GOOGLE');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:REDIRECT_URI', 'REDIRECT_URI API GOOGLE', 'http://localhost:88/hrms.nusa/api/auth/callback', NULL, NULL, 'T', 'SETUP REDIRECT URI GOOGLE CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL, 'GOOGLE');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:ACCESS-TOKEN', 'ACCESS-TOKEN API GOOGLE', 'ya29.a0AW4XtxjBQU_oefHAeM_vbHU2_gp52ULYLw3xExV3O2hLLvmKBQyQR0xrqOzd8lpy06RpQ2jtIpXIFB0FBycHfU1a3tz2Ytaz9HyH3U7CbUgjOvavPXhZrvFqiSrSgVUycS3T9yjJ-5JS7JuMRMRqF4C7SH6BJzDBcvckjluGaCgYKAWcSARcSFQHGX2MiXb-1Lz7VK5XYXAEV-I0nOw0175', NULL, NULL, 'T', 'SETUP ACCESS TOKEN GOOGLE CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL , 'GOOGLE');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:REFRESH-TOKEN', 'REFRESH-TOKEN API GOOGLE', '1//0gReQba8ce_GICgYIARAAGBASNwF-L9IrXvwKWvejxTwyUJIiDaKYpRSipFnjp0px1DmjWlr4lOpXFntg5BinQ87ztgeC2v5L4xU', NULL, NULL, 'T', 'SETUP REFRESH TOKEN GOOGLE CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL, 'GOOGLE');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:EMAILREMIND', 'EMAIL REMIND API GOOGLE', '50', NULL, NULL, 'T', 'REMINDER EMAIL GOOGLE CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL, 'GOOGLE');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) VALUES('GO:POPUPREMIND', 'POPUP REMIND API GOOGLE', '10', NULL, NULL, 'T', 'REMINDER POPUP CALENDAR', 'SYSTEM', NULL, '2025-06-18 21:37:38.636', NULL, 'GOOGLE');