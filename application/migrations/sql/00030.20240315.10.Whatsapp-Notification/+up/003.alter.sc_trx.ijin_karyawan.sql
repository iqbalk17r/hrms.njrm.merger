DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'ijin_karyawan' AND column_name = 'properties' ) THEN
            ALTER TABLE sc_trx.ijin_karyawan ADD COLUMN properties jsonb;
            COMMENT ON COLUMN sc_trx.ijin_karyawan.properties IS 'reference multi purpose properties';
        END IF;
    END
$$;