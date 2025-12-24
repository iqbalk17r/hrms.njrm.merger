INSERT INTO sc_mst.component_cashbon
(branch, componentid, description, unit, sort, calculated, active, readonly,multiplication, inputby, inputdate, type)
VALUES
    ('SBYNSA', 'SWK', 'SEWA KENDARAAN', 'NOMINAL', '11', true, true, true,true, 'postgres', NOW(), 'DN'),
    ('MJKCNI', 'UM', 'UANG MAKAN', 'NOMINAL', '07', true, false, true,true, 'postgres', '2023-08-22 14:09:51.065223', 'DN')
ON CONFLICT ( branch, componentid )
    DO UPDATE SET
    (branch, componentid, description, unit, sort, calculated, active, readonly, multiplication, inputby, inputdate, type) =
        (EXCLUDED.branch,EXCLUDED.componentid,EXCLUDED.description,EXCLUDED.unit,EXCLUDED.sort,EXCLUDED.calculated,EXCLUDED.active,EXCLUDED.readonly,EXCLUDED.multiplication,EXCLUDED.inputby,EXCLUDED.inputdate,EXCLUDED.type);
