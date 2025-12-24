DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'uangmakan' AND column_name = 'realisasicallplan') THEN
        ALTER TABLE IF EXISTS sc_trx.uangmakan ADD COLUMN realisasicallplan INTEGER;
    END IF;
END
$$
