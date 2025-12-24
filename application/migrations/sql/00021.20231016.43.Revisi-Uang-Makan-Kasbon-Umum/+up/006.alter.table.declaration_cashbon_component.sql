DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'declaration_cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE sc_tmp.declaration_cashbon_component ADD COLUMN dutieid VARCHAR DEFAULT '0';
            COMMENT ON COLUMN sc_tmp.declaration_cashbon_component.dutieid IS 'reference declaration multi dinas';
        END IF;
        IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'declaration_cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE IF EXISTS sc_tmp.declaration_cashbon_component DROP CONSTRAINT IF EXISTS declaration_cashbon_component_pkey;
            ALTER TABLE IF EXISTS sc_tmp.declaration_cashbon_component ADD constraint declaration_cashbon_component_pkey PRIMARY KEY (branch, declarationid, componentid, dutieid,perday);
        END IF;

        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'declaration_cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE sc_trx.declaration_cashbon_component ADD COLUMN dutieid VARCHAR DEFAULT '0';
            COMMENT ON COLUMN sc_trx.declaration_cashbon_component.dutieid IS 'reference declaration multi dinas';
        END IF;
        IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'declaration_cashbon_component' AND column_name = 'dutieid' ) THEN
            ALTER TABLE IF EXISTS sc_trx.declaration_cashbon_component DROP CONSTRAINT IF EXISTS declaration_cashbon_component_pkey;
            ALTER TABLE IF EXISTS sc_trx.declaration_cashbon_component ADD constraint declaration_cashbon_component_pkey PRIMARY KEY (branch, declarationid, componentid, dutieid, perday);
        END IF;
    END
$$;
