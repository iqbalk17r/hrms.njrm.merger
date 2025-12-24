CREATE TABLE IF NOT EXISTS sc_trx.checklist_tanggal (
    id_checklist CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    tanggal_mulai TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    tanggal_selesai TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    off CHARACTER(1) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT checklist_tanggal_pkey PRIMARY KEY (id_checklist, tanggal_mulai, tanggal_selesai)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_trx.checklist_tanggal
    OWNER to postgres;
