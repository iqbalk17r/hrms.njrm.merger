CREATE TABLE IF NOT EXISTS sc_tmp.checklist_parameter (
    id_checklist CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    kode_parameter CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    nama_parameter TEXT COLLATE pg_catalog."default" NOT NULL,
    target_parameter CHARACTER VARYING(30) COLLATE pg_catalog."default",
    urutan INTEGER NOT NULL,
    kddept TEXT COLLATE pg_catalog."default" NOT NULL,
    nmdept TEXT COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT checklist_parameter_pkey PRIMARY KEY (id_checklist, kode_parameter)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_tmp.checklist_parameter
    OWNER to postgres;
