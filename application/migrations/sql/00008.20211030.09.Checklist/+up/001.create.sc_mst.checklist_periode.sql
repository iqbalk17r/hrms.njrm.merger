CREATE TABLE IF NOT EXISTS sc_mst.checklist_periode (
    kode_periode CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    nama_periode CHARACTER VARYING(30) COLLATE pg_catalog."default" NOT NULL,
    hold CHARACTER VARYING(1) COLLATE pg_catalog."default" NOT NULL,
    urutan INTEGER NOT NULL,
    input_date TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    input_by CHARACTER VARYING(20) COLLATE pg_catalog."default" NOT NULL,
    update_date TIMESTAMP WITHOUT TIME ZONE,
    update_by CHARACTER VARYING(20) COLLATE pg_catalog."default",
    CONSTRAINT checklist_periode_pkey PRIMARY KEY (kode_periode)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_mst.checklist_periode
    OWNER to postgres;
