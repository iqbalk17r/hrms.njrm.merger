DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'cashbon' AND column_name = 'type') THEN
        ALTER TABLE sc_tmp.cashbon ADD type varchar default 'DN';
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon' AND column_name = 'type') THEN
        ALTER TABLE sc_trx.cashbon ADD type varchar default 'DN';
    END IF;

END
$$