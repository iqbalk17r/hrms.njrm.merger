CREATE TABLE IF NOT EXISTS sc_tmp.scheduletolocation (
    branch CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
    userid CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
    nik CHARACTER(12) COLLATE pg_catalog."default" NOT NULL,
    scheduleid CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
    scheduledate DATE NOT NULL,
    locationid CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
    locationidlocal CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
    custname CHARACTER VARYING(70) COLLATE pg_catalog."default",
    customertype CHARACTER(1) COLLATE pg_catalog."default",
    createby CHARACTER VARYING COLLATE pg_catalog."default",
    createdate TIMESTAMP WITHOUT TIME ZONE,
    CONSTRAINT scheduletolocation_pkey PRIMARY KEY (branch, scheduleid, locationid, locationidlocal)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS sc_tmp.scheduletolocation
    OWNER to postgres;
