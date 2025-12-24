INSERT INTO sc_mst.jobposition_cashbon
(branch, jobposition, componentid, destinationid, nominal, inputby, inputdate)
VALUES
    ('SBYNSA', 'A', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'A', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'A', 'SWK', 'LK',10000, 'postgres', NOW()),
    ('SBYNSA', 'B', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'B', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'B', 'SWK', 'LK',10000, 'postgres', NOW()),
    ('SBYNSA', 'C', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'C', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'C', 'SWK', 'LK',10000, 'postgres', NOW()),
    ('SBYNSA', 'D', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'D', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'D', 'SWK', 'LK',10000, 'postgres', NOW()),
    ('SBYNSA', 'E', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'E', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'E', 'SWK', 'LK',10000, 'postgres', NOW()),
    ('SBYNSA', 'F', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'F', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'F', 'SWK', 'LK',10000, 'postgres', NOW()),
    ('SBYNSA', 'G', 'UM', 'LK',90000, 'postgres', NOW()),
    ('SBYNSA', 'G', 'UD', 'LK',50000, 'postgres', NOW()),
    ('SBYNSA', 'G', 'SWK', 'LK',10000, 'postgres', NOW())
ON CONFLICT ( branch, jobposition, componentid, destinationid )
    DO NOTHING;

