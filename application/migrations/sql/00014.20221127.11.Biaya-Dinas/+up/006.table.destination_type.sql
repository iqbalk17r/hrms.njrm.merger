DROP TABLE IF EXISTS sc_mst.destination_type;
CREATE TABLE IF NOT EXISTS sc_mst.destination_type (
    branch VARCHAR NOT NULL,
    destinationid VARCHAR NOT NULL,
    description TEXT,
    active BOOLEAN,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT destination_type_pkey PRIMARY KEY ( branch, destinationid )
);

INSERT INTO sc_mst.destination_type
(branch, destinationid, description, active, inputby, inputdate)
VALUES
    ('MJKCNI', 'LK', 'LUAR KOTA', TRUE, 'postgres', NOW()),
    ('MJKCNI', 'DK', 'DALAM KOTA', TRUE, 'postgres', NOW()),
    ('MJKCNI', 'LP', 'LUAR PULAU', TRUE, 'postgres', NOW())
ON CONFLICT ( branch, destinationid )
    DO NOTHING;

