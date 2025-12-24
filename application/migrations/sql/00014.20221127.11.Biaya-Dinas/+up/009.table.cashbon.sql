DROP TABLE IF EXISTS sc_trx.cashbon;
CREATE TABLE IF NOT EXISTS sc_trx.cashbon (
    branch VARCHAR NOT NULL,
    cashbonid VARCHAR NOT NULL,
    dutieid VARCHAR NOT NULL, /* from : sc_trx.dinas.nodok */
    superior VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    paymenttype VARCHAR NOT NULL, /* from : sc_mst.trxtype */
    totalcashbon NUMERIC NOT NULL,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    approveby VARCHAR,
    approvedate TIMESTAMP,
    CONSTRAINT cashbon_pkey PRIMARY KEY ( branch, cashbonid )
);

COMMENT ON COLUMN sc_trx.cashbon.dutieid IS 'from : sc_trx.dinas.nodok';
COMMENT ON COLUMN sc_trx.cashbon.paymenttype IS 'from : sc_mst.trxtype';

DROP TABLE IF EXISTS sc_tmp.cashbon;
CREATE TABLE IF NOT EXISTS sc_tmp.cashbon (
    branch VARCHAR NOT NULL,
    cashbonid VARCHAR NOT NULL,
    dutieid VARCHAR NOT NULL, /* from : sc_trx.dinas.nodok */
    superior VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    paymenttype VARCHAR NOT NULL, /* from : sc_mst.trxtype */
    totalcashbon NUMERIC NOT NULL,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    approveby VARCHAR,
    approvedate TIMESTAMP,
    CONSTRAINT cashbon_pkey PRIMARY KEY ( branch, cashbonid )
);

COMMENT ON COLUMN sc_tmp.cashbon.dutieid IS 'from : sc_trx.dinas.nodok';
COMMENT ON COLUMN sc_tmp.cashbon.paymenttype IS 'from : sc_mst.trxtype';
