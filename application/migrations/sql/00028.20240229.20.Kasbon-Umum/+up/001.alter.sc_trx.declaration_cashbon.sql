DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'declaration_cashbon' AND column_name = 'employeeid' ) THEN
            ALTER TABLE sc_trx.declaration_cashbon ADD COLUMN employeeid VARCHAR DEFAULT NULL;
            COMMENT ON COLUMN sc_trx.declaration_cashbon.employeeid IS 'reference employee identity';
			update sc_trx.declaration_cashbon cc set employeeid = (
			    select
			        TRIM(b.nik) AS employeeid
			    FROM sc_trx.declaration_cashbon a
			    LEFT OUTER JOIN sc_trx.dinas b ON TRIM(b.nodok) = ANY(string_to_array(a.dutieid, ','))
			    WHERE a.declarationid = cc.declarationid
			) WHERE employeeid is null;
        END IF;
    END
$$;