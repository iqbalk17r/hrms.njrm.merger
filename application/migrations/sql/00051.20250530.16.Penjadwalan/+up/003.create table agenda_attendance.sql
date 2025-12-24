-- DROP TABLE sc_tmp.agenda_attendance;

CREATE TABLE sc_tmp.agenda_attendance
(
  agenda_id character varying NOT NULL,
  nik character varying NOT NULL,
  branch_id character varying,
  confirm_status boolean,
  attend_status boolean,
  status character varying,
  properties json,
  input_by character varying,
  input_date timestamp without time zone,
  update_by character varying,
  update_date timestamp without time zone,
  approve_by character varying,
  approve_date timestamp without time zone,
  cancel_by character varying,
  cancel_date timestamp without time zone,
  cancel_reason character varying,
  delete_by character varying,
  delete_date timestamp without time zone,
  delete_reason character varying,
  ojt_status boolean,
  CONSTRAINT agenda_attendance_pkey PRIMARY KEY (agenda_id, nik)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE sc_tmp.agenda_attendance
  OWNER TO postgres;

-- Trigger: tr_agenda_attendance_after on sc_tmp.agenda_attendance

-- Function: sc_tmp.pr_agenda_attendance_after()

-- DROP FUNCTION sc_tmp.pr_agenda_attendance_after();

CREATE OR REPLACE FUNCTION sc_tmp.pr_agenda_attendance_after()
  RETURNS trigger AS
$BODY$
declare
begin
    /*IF (new.status = 'F' AND old.status <> 'F') THEN
        DELETE FROM sc_trx.agenda_attendance WHERE TRUE AND agenda_id = NEW.agenda_id AND nik = new.nik;
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
        from sc_tmp.agenda_attendance
        where agenda_id = new.agenda_id
        AND nik = new.nik
        ;

        DELETE
        FROM sc_tmp.agenda_attendance
        where agenda_id = new.agenda_id
          AND nik = new.nik;
    END IF;*/
    RETURN NEW;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.pr_agenda_attendance_after()
  OWNER TO postgres;

-- DROP TRIGGER tr_agenda_attendance_after ON sc_tmp.agenda_attendance;

CREATE TRIGGER tr_agenda_attendance_after
  AFTER UPDATE
  ON sc_tmp.agenda_attendance
  FOR EACH ROW
  EXECUTE PROCEDURE sc_tmp.pr_agenda_attendance_after();


  --==============================================================

  CREATE TABLE sc_trx.agenda_attendance
(
  agenda_id character varying NOT NULL,
  nik character varying NOT NULL,
  branch_id character varying,
  confirm_status boolean,
  attend_status boolean,
  status character varying,
  properties json,
  input_by character varying,
  input_date timestamp without time zone,
  update_by character varying,
  update_date timestamp without time zone,
  approve_by character varying,
  approve_date timestamp without time zone,
  cancel_by character varying,
  cancel_date timestamp without time zone,
  cancel_reason character varying,
  delete_by character varying,
  delete_date timestamp without time zone,
  delete_reason character varying,
  ojt_status boolean,
  CONSTRAINT agenda_attendance_pkey PRIMARY KEY (agenda_id, nik)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE sc_trx.agenda_attendance
  OWNER TO postgres;


-- DROP FUNCTION sc_trx.pr_agenda_attendance_after();

CREATE OR REPLACE FUNCTION sc_trx.pr_agenda_attendance_after()
  RETURNS trigger AS
$BODY$
declare
begin
    IF (new.status = 'U' AND old.status <> 'U') THEN
        DELETE FROM sc_tmp.agenda_attendance WHERE TRUE AND trim(agenda_id) = trim(NEW.agenda_id);
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
            ojt_status
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
            ojt_status
        from sc_trx.agenda_attendance
        where trim(agenda_id) = trim(new.agenda_id);

    END IF;
    RETURN NEW;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_trx.pr_agenda_attendance_after()
  OWNER TO postgres;


-- Trigger: tr_agenda_attendance_after on sc_trx.agenda_attendance

-- DROP TRIGGER tr_agenda_attendance_after ON sc_trx.agenda_attendance;

CREATE TRIGGER tr_agenda_attendance_after
  AFTER UPDATE
  ON sc_trx.agenda_attendance
  FOR EACH ROW
  EXECUTE PROCEDURE sc_trx.pr_agenda_attendance_after();

--=================================================================
  
CREATE TABLE sc_his.agenda_schedule (
	agenda_id varchar NULL,
	begin_date timestamp NULL,
	end_date timestamp NULL,
	reason varchar NULL,
	input_by varchar NULL,
	input_date timestamp NULL
);

CREATE TABLE sc_his.agenda_attendance (
	agenda_id varchar NULL,
	nik varchar NULL,
	confirm_status bool NULL,
	attend_status bool NULL,
	input_by varchar NULL,
	input_date timestamp DEFAULT now() NULL
);