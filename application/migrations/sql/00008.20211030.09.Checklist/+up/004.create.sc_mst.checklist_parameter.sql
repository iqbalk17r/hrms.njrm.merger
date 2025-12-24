CREATE TABLE IF NOT EXISTS sc_mst.checklist_parameter (
    kode_parameter CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    kode_periode CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    kode_lokasi CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    nama_parameter TEXT COLLATE pg_catalog."default" NOT NULL,
    target_parameter CHARACTER VARYING(30) COLLATE pg_catalog."default",
    urutan INTEGER NOT NULL,
    hold CHARACTER VARYING(1) COLLATE pg_catalog."default" NOT NULL,
    input_date TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    input_by CHARACTER VARYING(20) COLLATE pg_catalog."default" NOT NULL,
    update_date TIMESTAMP WITHOUT TIME ZONE,
    update_by CHARACTER VARYING(20) COLLATE pg_catalog."default",
    CONSTRAINT checklist_parameter_pkey PRIMARY KEY (kode_parameter)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_mst.checklist_parameter
    OWNER to postgres;
