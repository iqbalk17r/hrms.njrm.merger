DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'checklist_realisasi' AND column_name = 'realisasi') THEN
        ALTER TABLE IF EXISTS sc_tmp.checklist_realisasi ADD COLUMN realisasi CHARACTER VARYING(30) COLLATE pg_catalog."default";
    END IF;
END
$$
