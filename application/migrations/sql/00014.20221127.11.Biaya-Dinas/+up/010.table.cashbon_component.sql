DROP TABLE IF EXISTS sc_trx.cashbon_component;
CREATE TABLE IF NOT EXISTS sc_trx.cashbon_component (
    branch VARCHAR NOT NULL,
    cashbonid VARCHAR NOT NULL, /* from : sc_trx.cashbon.cashbonid */
    componentid VARCHAR NOT NULL, /* from : sc_mst.component_cashbon.componentid */
    nominal NUMERIC NOT NULL,
    quantityday NUMERIC NOT NULL,
    totalcashbon NUMERIC NOT NULL,
    description TEXT,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT cashbon_component_pkey PRIMARY KEY ( branch, cashbonid, componentid )
);

COMMENT ON COLUMN sc_trx.cashbon_component.cashbonid IS 'from : sc_trx.cashbon.cashbonid';
COMMENT ON COLUMN sc_trx.cashbon_component.componentid IS 'from : sc_mst.component_cashbon.componentid';

DROP TABLE IF EXISTS sc_tmp.cashbon_component;
CREATE TABLE IF NOT EXISTS sc_tmp.cashbon_component (
    branch VARCHAR NOT NULL,
    cashbonid VARCHAR NOT NULL, /* from : sc_trx.cashbon.cashbonid */
    componentid VARCHAR NOT NULL, /* from : sc_mst.component_cashbon.componentid */
    nominal NUMERIC NOT NULL,
    quantityday NUMERIC NOT NULL,
    totalcashbon NUMERIC NOT NULL,
    description TEXT,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT cashbon_component_pkey PRIMARY KEY ( branch, cashbonid, componentid )
);

COMMENT ON COLUMN sc_tmp.cashbon_component.cashbonid IS 'from : sc_trx.cashbon.cashbonid';
COMMENT ON COLUMN sc_tmp.cashbon_component.componentid IS 'from : sc_mst.component_cashbon.componentid';
