CREATE TABLE IF NOT EXISTS sc_tmp.checklist_user (
    id_checklist CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    nik CHARACTER(12) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT checklist_user_pkey PRIMARY KEY (id_checklist, nik)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_tmp.checklist_user
    OWNER to postgres;
