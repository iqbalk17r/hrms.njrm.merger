CREATE TABLE IF NOT EXISTS sc_trx.checklist (
    id_checklist CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    kode_periode CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    kode_lokasi CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    tanggal_mulai TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    tanggal_selesai TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    status CHARACTER(1) COLLATE pg_catalog."default" NOT NULL,
    input_date TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    input_by CHARACTER(12) COLLATE pg_catalog."default" NOT NULL,
    update_date TIMESTAMP WITHOUT TIME ZONE,
    update_by CHARACTER VARYING(12) COLLATE pg_catalog."default",
    delete_date TIMESTAMP WITHOUT TIME ZONE,
    delete_by CHARACTER VARYING(12) COLLATE pg_catalog."default",
    CONSTRAINT checklist_pkey PRIMARY KEY (id_checklist)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_trx.checklist
    OWNER to postgres;
