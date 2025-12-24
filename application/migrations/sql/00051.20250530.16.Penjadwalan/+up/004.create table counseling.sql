CREATE OR REPLACE FUNCTION sc_tmp.pr_counseling_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
    vr_nomor char(30);
begin
    IF (new.status = 'F' AND old.status <> 'F') THEN
        delete from sc_mst.penomoran where userid = new.session_id;

        IF NOT EXISTS (SELECT TRUE FROM sc_mst.nomor WHERE TRUE AND dokumen = 'COUNSELING') THEN
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
            VALUES ('COUNSELING',
                    '',
                    4,
                    CONCAT('CO', TO_CHAR(NOW(), 'YY')),
                    '',
                    0,
                    NEW.session_id,
                    '',
                    TO_CHAR(NOW(), 'YYYY'),
                    'T');
        END IF;
        insert into sc_mst.penomoran
            (userid, dokumen, nomor, errorid, partid, counterid, xno)
        values (new.session_id, 'COUNSELING', ' ', 0, ' ', 1, 0);
        vr_nomor := trim(coalesce(nomor, '')) from sc_mst.penomoran where userid = new.session_id;
        if (trim(vr_nomor) != '') or (not vr_nomor is null) then
            INSERT INTO sc_trx.counseling_session(session_id,
                                                  branch_id,
                                                  counselee,
                                                  counselor,
                                                  session_date,
                                                  begin_time,
                                                  end_time,
                                                  location,
                                                  description,
                                                  status,
                                                  score,
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
                                                  delete_reason)
            SELECT vr_nomor,
                   branch_id,
                   counselee,
                   counselor,
                   session_date,
                   begin_time,
                   end_time,
                   location,
                   description,
                   'I' as status,
                   score,
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
            from sc_tmp.counseling_session
            where session_id = new.session_id
              and counselee = new.counselee;

            delete
            from sc_tmp.counseling_session
            where session_id = new.session_id
              and counselee = new.counselee;

        end if;


    END IF;
    IF (new.status = 'U' AND old.status <> 'U') THEN
        DELETE FROM sc_trx.counseling_session WHERE TRUE AND session_id = NEW.session_id;
        INSERT INTO sc_trx.counseling_session(session_id,
                                              branch_id,
                                              counselee,
                                              counselor,
                                              session_date,
                                              begin_time,
                                              end_time,
                                              location,
                                              description,
                                              status,
                                              score,
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
                                              delete_reason)
        SELECT session_id,
               branch_id,
               counselee,
               counselor,
               session_date,
               begin_time,
               end_time,
               location,
               description,
               old.status as status,
               score,
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
        from sc_tmp.counseling_session
        where session_id = new.session_id;
        delete
        from sc_tmp.counseling_session
        where session_id = new.session_id;
    end if;

    RETURN NEW;
end;
$function$
;

-- sc_tmp.counseling_session definition

-- Drop table

-- DROP TABLE sc_tmp.counseling_session;

CREATE TABLE sc_tmp.counseling_session (
	session_id varchar NOT NULL,
	branch_id varchar NULL,
	counselee varchar NOT NULL,
	counselor varchar NULL,
	session_date varchar NULL,
	begin_time time NULL,
	end_time time NULL,
	"location" varchar NULL,
	description varchar NULL,
	status varchar NULL,
	score numeric NULL,
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
	CONSTRAINT counseling_session_pkey PRIMARY KEY (session_id)
);

-- Table Triggers

create trigger tr_counseling_after after
update
    on
    sc_tmp.counseling_session for each row execute procedure sc_tmp.pr_counseling_after();

--===============================================================================================

-- DROP FUNCTION sc_trx.pr_counseling_after();

CREATE OR REPLACE FUNCTION sc_trx.pr_counseling_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
    vr_nomor char(30);
begin
    IF (new.status = 'U' AND old.status <> 'U') THEN
        DELETE FROM sc_tmp.counseling_session WHERE TRUE AND session_id = NEW.session_id;
        INSERT INTO sc_tmp.counseling_session(session_id,
                                              branch_id,
                                              counselee,
                                              counselor,
                                              session_date,
                                              begin_time,
                                              end_time,
                                              location,
                                              description,
                                              status,
                                              score,
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
                                              delete_reason)
        SELECT session_id,
               branch_id,
               counselee,
               counselor,
               session_date,
               begin_time,
               end_time,
               location,
               description,
               old.status as status,
               score,
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
        from sc_trx.counseling_session
        where session_id = new.session_id;

        UPDATE sc_trx.counseling_session
        SET status      = OLD.status,
            update_by   = OLD.update_by,
            update_date = OLD.update_date
        WHERE TRUE
          AND session_id = NEW.session_id;
    end if;

    RETURN NEW;
end;
$function$
;


-- sc_trx.counseling_session definition

-- Drop table

-- DROP TABLE sc_trx.counseling_session;

CREATE TABLE sc_trx.counseling_session (
	session_id varchar NOT NULL,
	branch_id varchar NULL,
	counselee varchar NOT NULL,
	counselor varchar NOT NULL,
	session_date varchar NULL,
	begin_time time NULL,
	end_time time NULL,
	"location" varchar NULL,
	description varchar NULL,
	status varchar NULL,
	score numeric NULL,
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
	CONSTRAINT counseling_session_pkey PRIMARY KEY (session_id)
);

-- Table Triggers

create trigger tr_counseling_after after
update
    on
    sc_trx.counseling_session for each row execute procedure sc_trx.pr_counseling_after();

--===========================================================================

CREATE TABLE sc_trx.counseling_session_detail (
	detail_id serial4 NOT NULL,
	session_id varchar NULL,
	sort numeric NULL,
	problem varchar NULL,
	solution varchar NULL,
	score numeric NULL,
	input_by varchar NULL,
	input_date timestamp NULL,
	update_by varchar NULL,
	update_date timestamp NULL
);

--=============================================================================

-- sc_his.counseling_schedule definition

-- Drop table

-- DROP TABLE sc_his.counseling_schedule;

CREATE TABLE sc_his.counseling_schedule (
	session_id varchar NULL,
	session_date varchar NULL,
	begin_time time NULL,
	end_time time NULL,
	"location" varchar NULL,
	reason varchar NULL,
	input_by varchar NULL,
	input_date timestamp NULL
);
