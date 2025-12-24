CREATE TABLE if not EXISTS sc_log.success_notifications
(
  success_id serial NOT NULL,
  modul character varying,
  message json,
  status character varying,
  properties json,
  branch_id character varying,
  input_by character varying,
  input_date timestamp without time zone,
  update_by character varying,
  update_date timestamp without time zone,
  CONSTRAINT success_notifications_success_id_key UNIQUE (success_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE sc_log.success_notifications
  OWNER TO postgres;

CREATE TABLE if not EXISTS sc_log.error_notifications
(
  success_id serial NOT NULL,
  modul character varying,
  message json,
  status character varying,
  properties json,
  branch_id character varying,
  input_by character varying,
  input_date timestamp without time zone,
  update_by character varying,
  update_date timestamp without time zone,
  CONSTRAINT error_notifications_success_id_key UNIQUE (success_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE sc_log.error_notifications
  OWNER TO postgres;
