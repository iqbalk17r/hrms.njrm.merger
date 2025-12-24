CREATE TABLE IF NOT EXISTS sc_tmp.checklist_realisasi (
    id_checklist CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    nik CHARACTER(12) COLLATE pg_catalog."default" NOT NULL,
    tanggal_mulai TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    tanggal_selesai TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    kode_parameter CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    off CHARACTER(1) COLLATE pg_catalog."default" NOT NULL,
    hasil CHARACTER VARYING(1) COLLATE pg_catalog."default",
    keterangan TEXT COLLATE pg_catalog."default",
    tanggal_hasil TIMESTAMP WITHOUT TIME ZONE,
    CONSTRAINT checklist_realisasi_pkey PRIMARY KEY (id_checklist, nik, tanggal_mulai, tanggal_selesai, kode_parameter)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_tmp.checklist_realisasi
    OWNER to postgres;
