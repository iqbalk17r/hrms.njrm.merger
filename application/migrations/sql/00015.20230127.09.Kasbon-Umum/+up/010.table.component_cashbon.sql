
DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'type') THEN
        ALTER TABLE sc_mst.component_cashbon ADD type varchar ;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'type') THEN
        UPDATE sc_mst.component_cashbon SET type = 'DN' WHERE type is null;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'rules') THEN
        ALTER TABLE sc_mst.component_cashbon ADD rules integer default 0;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'rules') THEN
        UPDATE sc_mst.component_cashbon SET readonly = false WHERE componentid = 'BPO';
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'rules') THEN
        UPDATE sc_mst.component_cashbon SET rules = -1 WHERE componentid = 'UD';
    END IF;

    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'multiplication') THEN
        ALTER TABLE sc_mst.component_cashbon ADD multiplication boolean default false;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'component_cashbon' AND column_name = 'multiplication') THEN
        UPDATE sc_mst.component_cashbon SET multiplication = true WHERE componentid in ('BBM','UM','UD','SWK') ;
    END IF;
END
$$;

INSERT INTO sc_mst.component_cashbon
(branch, componentid, description, unit, sort, calculated, active, readonly, inputby, inputdate, type)
VALUES
    ('MJKCNI', 'LAIN-BL', 'LAIN-LAIN', 'NOMINAL', '01', true, true, false, 'postgres', NOW(), 'BL'),
    ('MJKCNI', 'LAIN-AI', 'LAIN-LAIN', 'NOMINAL', '01', true, true, false, 'postgres', NOW(), 'AI'),
    ('MJKCNI', 'LAIN-PO', 'LAIN-LAIN', 'NOMINAL', '02', true, true, false, 'postgres', NOW(), 'PO'),
    ('MJKCNI', 'BPO', 'BARANG PO', 'NOMINAL', '01', true, true, false , 'postgres', NOW(), 'PO')
ON CONFLICT ( branch, componentid )
    DO NOTHING;

INSERT INTO sc_mst.component_cashbon
(branch, componentid, description, unit, sort, calculated, active, readonly, inputby, inputdate, type, rules, multiplication)
VALUES
    ('MJKCNI', 'DCBBM', 'BBM', 'NOMINAL', '01', true, true, false, 'postgres', NOW(), 'DC', 0, false),
    ('MJKCNI', 'DCPRK', 'PARKIR', 'NOMINAL', '02', true, true, false, 'postgres', NOW(), 'DC', 0, false)
    ON CONFLICT ( branch, componentid )
    DO NOTHING;




