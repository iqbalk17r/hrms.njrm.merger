DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'declaration_cashbon' AND column_name = 'flag' ) THEN
        ALTER TABLE sc_trx.declaration_cashbon ADD flag varchar default 'NO';
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'declaration_cashbon' AND column_name = 'voucher' ) THEN
        ALTER TABLE sc_trx.declaration_cashbon ADD voucher varchar default null;
    END IF;
END
$$