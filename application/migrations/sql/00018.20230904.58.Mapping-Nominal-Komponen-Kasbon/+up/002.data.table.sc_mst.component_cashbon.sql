INSERT INTO sc_mst.component_cashbon
    (branch, componentid, description, unit, sort, calculated, active, readonly, inputby, inputdate,updateby, updatedate, type, rules, multiplication)
VALUES
    ('SBYNSA', 'SWK', 'SEWA KENDARAAN', 'NOMINAL', '11', true, true, true, 'postgres', '2023-08-28 04:58:37.041229', 'SYSTEM', now(), '-', 0, true),
    ('SBYNSA', 'SWK:M', 'SEWA MOBIL', 'NOMINAL', '11', true, true, true, 'postgres', '2023-08-28 04:58:37.041229', null, null, 'M', 0, true),
    ('SBYNSA', 'SWK:SM', 'SEWA MOTOR', 'NOMINAL', '11', true, true, true, 'postgres', '2023-08-28 04:58:37.041229', null, null, 'SM', 0, true)
ON CONFLICT (componentid)
DO UPDATE
    set
        (branch, componentid, description, unit, sort, calculated, active, readonly, inputby, inputdate, updateby, updatedate, type, rules, multiplication) =
            (EXCLUDED.branch ,EXCLUDED.componentid ,EXCLUDED.description ,EXCLUDED.unit ,EXCLUDED.sort ,EXCLUDED.calculated ,EXCLUDED.active ,EXCLUDED.readonly ,EXCLUDED.inputby ,EXCLUDED.inputdate ,EXCLUDED.updateby ,EXCLUDED.updatedate ,EXCLUDED.type ,EXCLUDED.rules ,EXCLUDED.multiplication );
