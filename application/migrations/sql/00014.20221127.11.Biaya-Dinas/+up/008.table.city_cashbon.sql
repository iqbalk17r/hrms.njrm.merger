DROP TABLE IF EXISTS sc_mst.city_cashbon;
CREATE TABLE IF NOT EXISTS sc_mst.city_cashbon (
    branch VARCHAR NOT NULL,
    destinationid VARCHAR NOT NULL, /* from : sc_mst.destination_type.destinationid */
    cityid VARCHAR NOT NULL, /* from : sc_mst.kotakab.kodekotakab */
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT city_cashbon_pkey PRIMARY KEY ( branch, destinationid, cityid )
);

COMMENT ON COLUMN sc_mst.city_cashbon.destinationid IS 'from : sc_mst.destination_type.destinationid';
COMMENT ON COLUMN sc_mst.city_cashbon.cityid IS 'from : sc_mst.kotakab.kodekotakab';

INSERT INTO sc_mst.city_cashbon
(branch, destinationid, cityid, inputby, inputdate)
VALUES
    ('MJKCNI', 'DK', '3515', 'postgres', NOW()),
    ('MJKCNI', 'LK', '3515', 'postgres', NOW()),
    ('MJKCNI', 'LP', '6371', 'postgres', NOW()),
    ('MJKCNI', 'DK', '3516', 'postgres', NOW())
ON CONFLICT ( branch, destinationid, cityid )
    DO NOTHING;
