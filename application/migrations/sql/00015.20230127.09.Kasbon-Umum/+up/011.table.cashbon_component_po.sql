DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cashbon_component_po' ) THEN
        create table sc_trx.cashbon_component_po(
            branch     varchar not null,
            cashbonid  varchar not null,
            pono       varchar not null,
            nomor      numeric not null,
            stockcode  varchar,
            stockname  varchar,
            qty        numeric,
            pricelist  numeric,
            brutto     numeric,
            netto      numeric,
            dpp        numeric,
            ppn        numeric,
            inputby    varchar,
            inputdate  timestamp,
            updateby   varchar,
            updatedate timestamp,
            primary key (branch, cashbonid, pono, nomor)
        );
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'cashbon_component_po' ) THEN
        create table sc_tmp.cashbon_component_po(
            branch     varchar not null,
            cashbonid  varchar not null,
            pono       varchar not null,
            nomor      numeric not null,
            stockcode  varchar,
            stockname  varchar,
            qty        numeric,
            pricelist  numeric,
            brutto     numeric,
            netto      numeric,
            dpp        numeric,
            ppn        numeric,
            inputby    varchar,
            inputdate  timestamp,
            updateby   varchar,
            updatedate timestamp,
            primary key (branch, cashbonid, pono, nomor)
        );
    END IF;
END
$$