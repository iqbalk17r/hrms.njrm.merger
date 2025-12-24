DROP TABLE IF EXISTS sc_mst.component_cashbon;
CREATE TABLE IF NOT EXISTS sc_mst.component_cashbon (
    branch VARCHAR NOT NULL,
    componentid VARCHAR NOT NULL,
    description TEXT,
    unit VARCHAR NOT NULL,
    sort VARCHAR NOT NULL,
    calculated BOOLEAN,
    active BOOLEAN,
    readonly BOOLEAN,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT component_cashbon_pkey PRIMARY KEY ( branch, componentid )
);

INSERT INTO sc_mst.component_cashbon
(branch, componentid, description, unit, sort, calculated, active, readonly, inputby, inputdate)
VALUES
    ('MJKCNI', 'UM', 'UANG MAKAN', 'NOMINAL', '07', TRUE, TRUE, TRUE, 'postgres', NOW()),
    ('MJKCNI', 'UD', 'UANG DINAS', 'NOMINAL', '08', TRUE, TRUE, TRUE, 'postgres', NOW()),
    ('MJKCNI', 'BBM', 'BBM NOMINAL', 'NOMINAL', '06', TRUE, TRUE, FALSE, 'postgres', NOW()),
    ('MJKCNI', 'TRS', 'TRANSPORTASI', 'NOMINAL', '02', TRUE, FALSE, FALSE, 'postgres', NOW()),
    ('MJKCNI', 'PGN', 'PENGINAPAN', 'NOMINAL', '01', TRUE, TRUE, FALSE, 'postgres', NOW()),
    ('MJKCNI', 'BBL', 'BBM LITER', 'LITER', '05', FALSE, FALSE, FALSE, 'postgres', NOW()),
    ('MJKCNI', 'KMAW', 'KM AWAL', 'KM', '03', FALSE, FALSE, FALSE, 'postgres', NOW()),
    ('MJKCNI', 'KMAK', 'KM AKHIR', 'KM', '04', FALSE, FALSE, FALSE, 'postgres', NOW()),
    ('MJKCNI', 'LAIN', 'LAIN-LAIN', 'NOMINAL', '09', TRUE, TRUE, FALSE, 'postgres', NOW())
ON CONFLICT ( branch, componentid )
    DO NOTHING;
