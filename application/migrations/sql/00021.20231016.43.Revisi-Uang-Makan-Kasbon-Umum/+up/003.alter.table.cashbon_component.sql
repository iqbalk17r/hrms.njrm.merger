DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE sc_tmp.cashbon_component ADD COLUMN dutieid VARCHAR DEFAULT '0';
            COMMENT ON COLUMN sc_tmp.cashbon_component.dutieid IS 'reference cashbon multi dinas';
        END IF;
        IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE IF EXISTS sc_tmp.cashbon_component DROP CONSTRAINT IF EXISTS cashbon_component_pkey;
            ALTER TABLE IF EXISTS sc_tmp.cashbon_component ADD constraint cashbon_component_pkey PRIMARY KEY (branch, cashbonid, componentid, dutieid);
        END IF;

        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE sc_trx.cashbon_component ADD COLUMN dutieid VARCHAR DEFAULT '0';
            COMMENT ON COLUMN sc_trx.cashbon_component.dutieid IS 'reference cashbon multi dinas';
        END IF;
        IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE IF EXISTS sc_trx.cashbon_component DROP CONSTRAINT IF EXISTS cashbon_component_pkey;
            ALTER TABLE IF EXISTS sc_trx.cashbon_component ADD constraint cashbon_component_pkey PRIMARY KEY (branch, cashbonid, componentid, dutieid);
        END IF;
    END
$$;
