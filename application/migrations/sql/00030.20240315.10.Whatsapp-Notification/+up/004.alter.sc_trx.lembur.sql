DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'lembur' AND column_name = 'properties' ) THEN
            ALTER TABLE sc_trx.lembur ADD COLUMN properties jsonb;
            COMMENT ON COLUMN sc_trx.lembur.properties IS 'reference multi purpose properties';
        END IF;
    END
$$;