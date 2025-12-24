begin transaction;

INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES('COACH', 'EVENT', 'PELATIHAN');
INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES('MEET', 'EVENT', 'MEETING');
INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES('IN', 'ORGANIZERTYPE', 'INTERNAL');
INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES('EX', 'ORGANIZERTYPE', 'EKSTERNAL');

CREATE TABLE sc_tmp.agenda (
	agenda_id varchar NULL,
	branch_id varchar NULL,
	agenda_name varchar NULL,
	agenda_type varchar NULL,
	organizer_type varchar NULL,
	organizer_name varchar NULL,
	description varchar NULL,
	resulttext varchar NULL,
	sertificate_validity_period date NULL,
	participant_count numeric NULL,
	begin_date varchar NULL,
	end_date varchar NULL,
	"location" varchar NULL,
	status varchar NULL,
	properties json NULL,
	input_by varchar NULL,
	input_date timestamp NULL,
	update_by varchar NULL,
	update_date timestamp NULL,
	approve_by varchar NULL,
	approve_date timestamp NULL,
	cancel_by varchar NULL,
	cancel_date timestamp NULL,
	cancel_reason varchar NULL,
	delete_by varchar NULL,
	delete_date timestamp NULL,
	delete_reason varchar NULL,
	link varchar NULL
);

CREATE TABLE sc_trx.agenda (
	agenda_id varchar NOT NULL,
	branch_id varchar NULL,
	agenda_name varchar NULL,
	agenda_type varchar NULL,
	organizer_type varchar NULL,
	organizer_name varchar NULL,
	description varchar NULL,
	resulttext varchar NULL,
	sertificate_validity_period date NULL,
	participant_count numeric NULL,
	begin_date varchar NULL,
	end_date varchar NULL,
	"location" varchar NULL,
	status varchar NULL,
	properties json NULL,
	input_by varchar NULL,
	input_date timestamp NULL,
	update_by varchar NULL,
	update_date timestamp NULL,
	approve_by varchar NULL,
	approve_date timestamp NULL,
	cancel_by varchar NULL,
	cancel_date timestamp NULL,
	cancel_reason varchar NULL,
	delete_by varchar NULL,
	delete_date timestamp NULL,
	delete_reason varchar NULL,
	link varchar NULL,
	CONSTRAINT agenda_pkey PRIMARY KEY (agenda_id)
);

-- DROP FUNCTION sc_tmp.pr_agenda_after();

CREATE OR REPLACE FUNCTION sc_tmp.pr_agenda_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
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
                delete_reason
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
                delete_reason
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
            delete_reason
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
            delete_reason
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
$function$
;

CREATE OR REPLACE FUNCTION sc_trx.pr_agenda_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
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
            delete_reason
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
            delete_reason
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
            delete_reason
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
            delete_reason
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
$function$
;

-- Table Triggers

create trigger tr_agenda_after after
update
    on
    sc_tmp.agenda for each row execute procedure sc_tmp.pr_agenda_after();

-- Table Triggers

create trigger tr_agenda_after after
update
    on
    sc_trx.agenda for each row execute procedure sc_trx.pr_agenda_after();


commit transaction;