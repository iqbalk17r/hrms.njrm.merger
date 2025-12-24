DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon' AND column_name = 'cancelby' ) THEN
            ALTER TABLE sc_trx.cashbon ADD cancelby varchar ;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon' AND column_name = 'canceldate' ) THEN
            ALTER TABLE sc_trx.cashbon ADD canceldate timestamp ;
        END IF;
    END
$$;