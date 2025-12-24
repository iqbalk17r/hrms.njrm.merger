DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_blc' ) THEN
        create table sc_trx.cashbon_blc
        (
            nik        char(12)  not null,
            docno varchar   not null,
            cash_in    numeric,
            cash_out   numeric,
            balance   numeric,
            doctype    varchar   not null,
            status     varchar,
            inputby      varchar   not null,
            inputdate    timestamp not null,
            primary key (nik, docno, inputdate, doctype)
        );
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_blc' AND column_name = 'reference' ) THEN
        ALTER TABLE sc_trx.cashbon_blc ADD reference varchar ;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_blc' AND column_name = 'flag' ) THEN
        ALTER TABLE sc_trx.cashbon_blc ADD flag varchar default 'NO';
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_blc' AND column_name = 'voucher' ) THEN
        ALTER TABLE sc_trx.cashbon_blc ADD voucher varchar ;
    END IF;
END
$$
