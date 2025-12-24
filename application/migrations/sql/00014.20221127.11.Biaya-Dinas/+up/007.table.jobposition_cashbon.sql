DROP TABLE IF EXISTS sc_mst.jobposition_cashbon;
CREATE TABLE IF NOT EXISTS sc_mst.jobposition_cashbon (
    branch VARCHAR NOT NULL,
    jobposition VARCHAR NOT NULL,
    componentid VARCHAR NOT NULL, /* from : sc_mst.component_cashbon.componentid */
    destinationid VARCHAR NOT NULL, /* from : sc_mst.destination_type.destinationid */
    nominal NUMERIC NOT NULL,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT jobposition_cashbon_pkey PRIMARY KEY ( branch, jobposition, componentid, destinationid )
);

COMMENT ON COLUMN sc_mst.jobposition_cashbon.componentid IS 'from : sc_mst.component_cashbon.componentid';
COMMENT ON COLUMN sc_mst.jobposition_cashbon.destinationid IS 'from : sc_mst.destination_type.destinationid';

INSERT INTO sc_mst.jobposition_cashbon
(branch, jobposition, componentid, destinationid, nominal, inputby, inputdate)
VALUES
    ('SBYNSA', 'A', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'A', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'B', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'B', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'C', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'C', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'D', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'D', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'E', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'E', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'F', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'F', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'G', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'G', 'UD', 'LK',50000, 'postgres', NOW())
ON CONFLICT ( branch, jobposition, componentid, destinationid )
    DO NOTHING;

