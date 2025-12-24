DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'uangmakan' AND column_name = 'bbm' ) THEN
            ALTER TABLE sc_trx.uangmakan ADD bbm numeric ;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'uangmakan' AND column_name = 'sewa_kendaraan' ) THEN
            ALTER TABLE sc_trx.uangmakan ADD sewa_kendaraan numeric ;
        END IF;
    END
$$;