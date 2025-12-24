DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'karyawan' AND column_name = 'callplan') THEN
        ALTER TABLE IF EXISTS sc_tmp.karyawan ADD COLUMN callplan CHARACTER(2) COLLATE pg_catalog."default" DEFAULT 'f'::bpchar;
    END IF;
END
$$
