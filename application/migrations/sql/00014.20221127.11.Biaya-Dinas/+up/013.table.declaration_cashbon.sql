DROP TABLE IF EXISTS sc_trx.declaration_cashbon;
CREATE TABLE IF NOT EXISTS sc_trx.declaration_cashbon (
    branch VARCHAR NOT NULL,
    declarationid VARCHAR NOT NULL,
    cashbonid VARCHAR, /* from : sc_trx.cashbon.cashbonid */
    dutieid VARCHAR NOT NULL, /* from : sc_trx.dinas.nodok */
    superior VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    paymenttype VARCHAR, /* from : sc_mst.trxtype */
    totalcashbon NUMERIC NOT NULL, /* from : sc_mst.cashbon.totalcashbon */
    totaldeclaration NUMERIC NOT NULL,
    returnamount NUMERIC NOT NULL,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    approveby VARCHAR,
    approvedate TIMESTAMP,
    CONSTRAINT declaration_cashbon_pkey PRIMARY KEY ( branch, declarationid )
);

COMMENT ON COLUMN sc_trx.declaration_cashbon.cashbonid IS 'from : sc_trx.cashbon.cashbonid';
COMMENT ON COLUMN sc_trx.declaration_cashbon.dutieid IS 'from : sc_trx.dinas.nodok';
COMMENT ON COLUMN sc_trx.declaration_cashbon.totalcashbon IS 'from : sc_mst.cashbon.totalcashbon';

DROP TABLE IF EXISTS sc_tmp.declaration_cashbon;
CREATE TABLE IF NOT EXISTS sc_tmp.declaration_cashbon (
    branch VARCHAR NOT NULL,
    declarationid VARCHAR NOT NULL,
    cashbonid VARCHAR, /* from : sc_trx.cashbon.cashbonid */
    dutieid VARCHAR NOT NULL, /* from : sc_trx.dinas.nodok */
    superior VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    paymenttype VARCHAR, /* from : sc_mst.trxtype */
    totalcashbon NUMERIC NOT NULL, /* from : sc_mst.cashbon.totalcashbon */
    totaldeclaration NUMERIC NOT NULL,
    returnamount NUMERIC NOT NULL,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    approveby VARCHAR,
    approvedate TIMESTAMP,
    CONSTRAINT declaration_cashbon_pkey PRIMARY KEY ( branch, declarationid )
);

COMMENT ON COLUMN sc_tmp.declaration_cashbon.cashbonid IS 'from : sc_trx.cashbon.cashbonid';
COMMENT ON COLUMN sc_tmp.declaration_cashbon.dutieid IS 'from : sc_trx.dinas.nodok';
COMMENT ON COLUMN sc_tmp.declaration_cashbon.totalcashbon IS 'from : sc_mst.cashbon.totalcashbon';
