DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'checkinout' AND column_name = 'customertype') THEN
        ALTER TABLE IF EXISTS sc_tmp.checkinout ADD COLUMN customertype CHARACTER(1) COLLATE pg_catalog."default";
    END IF;
END
$$
