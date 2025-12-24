CREATE TABLE IF NOT EXISTS sc_mst.checklist_lokasi (
    kode_lokasi CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    nama_lokasi CHARACTER VARYING(100) COLLATE pg_catalog."default" NOT NULL,
    hold CHARACTER VARYING(1) COLLATE pg_catalog."default" NOT NULL,
    input_date TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    input_by CHARACTER VARYING(20) COLLATE pg_catalog."default" NOT NULL,
    update_date TIMESTAMP WITHOUT TIME ZONE,
    update_by CHARACTER VARYING(20) COLLATE pg_catalog."default",
    CONSTRAINT checklist_lokasi_pkey PRIMARY KEY (kode_lokasi)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_mst.checklist_lokasi
    OWNER to postgres;
