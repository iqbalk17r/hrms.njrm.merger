DROP TABLE IF EXISTS sc_trx.declaration_cashbon_component;
CREATE TABLE IF NOT EXISTS sc_trx.declaration_cashbon_component (
    branch VARCHAR NOT NULL,
    declarationid VARCHAR NOT NULL, /* from : sc_trx.declaration_cashbon.declarationid */
    componentid VARCHAR NOT NULL, /* from : sc_mst.component_cashbon.componentid */
    perday DATE NOT NULL,
    nominal NUMERIC NOT NULL,
    description TEXT,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT declaration_cashbon_component_pkey PRIMARY KEY ( branch, declarationid, componentid, perday )
);

COMMENT ON COLUMN sc_trx.declaration_cashbon_component.declarationid IS 'from : sc_trx.declaration_cashbon.declarationid';
COMMENT ON COLUMN sc_trx.declaration_cashbon_component.componentid IS 'from : sc_mst.component_cashbon.componentid';

DROP TABLE IF EXISTS sc_tmp.declaration_cashbon_component;
CREATE TABLE IF NOT EXISTS sc_tmp.declaration_cashbon_component (
    branch VARCHAR NOT NULL,
    declarationid VARCHAR NOT NULL, /* from : sc_trx.declaration_cashbon.declarationid */
    componentid VARCHAR NOT NULL, /* from : sc_mst.component_cashbon.componentid */
    perday DATE NOT NULL,
    nominal NUMERIC NOT NULL,
    description TEXT,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT declaration_cashbon_component_pkey PRIMARY KEY ( branch, declarationid, componentid, perday )
);

COMMENT ON COLUMN sc_tmp.declaration_cashbon_component.declarationid IS 'from : sc_trx.declaration_cashbon.declarationid';
COMMENT ON COLUMN sc_tmp.declaration_cashbon_component.componentid IS 'from : sc_mst.component_cashbon.componentid';
