CREATE TABLE IF NOT EXISTS sc_mst.checklist_parameter_dept (
    kode_parameter CHARACTER VARYING(14) COLLATE pg_catalog."default" NOT NULL,
    kddept CHARACTER VARYING(6) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT checklist_parameter_dept_pkey PRIMARY KEY (kode_parameter, kddept)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_mst.checklist_parameter_dept
    OWNER to postgres;
