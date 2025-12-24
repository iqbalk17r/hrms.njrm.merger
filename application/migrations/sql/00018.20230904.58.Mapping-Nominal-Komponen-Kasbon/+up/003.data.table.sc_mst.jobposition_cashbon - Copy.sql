INSERT INTO sc_mst.jobposition_cashbon
    (branch, jobposition, componentid, destinationid, nominal, inputby, inputdate)
VALUES
    ('SBYNSA', 'D', 'SWK:SM', 'LK', 11000, 'postgres', now()),
    ('SBYNSA', 'D', 'SWK:M', 'LK', 20000, 'postgres', now())
ON CONFLICT (branch,jobposition, componentid, destinationid)
DO UPDATE
    set (branch, jobposition, componentid, destinationid, nominal, inputby, inputdate) =
            (EXCLUDED.branch ,EXCLUDED.jobposition ,EXCLUDED.componentid ,EXCLUDED.destinationid ,EXCLUDED.nominal ,EXCLUDED.inputby ,EXCLUDED.inputdate );