INSERT INTO
    sc_mst.option (
        kdoption,
        nmoption,
        value1,
        status,
        keterangan,
        input_by,
        input_date,
        group_option
    )
VALUES (
        'HR:SETUP',
        'SETUP KODE HR',
        'HA.HR',
        'T',
        'SETUP KODE HR (format: departemen.subdepartemen1,subdepartemen2 tanpa spasi)',
        'SYSTEM',
        now(),
        'HRSETUP'
    )
ON CONFLICT (kdoption, group_option) DO
UPDATE
SET (
        nmoption,
        value1,
        status,
        keterangan,
        update_by,
        update_date
    ) = (
        EXCLUDED.nmoption,
        EXCLUDED.value1,
        EXCLUDED.status,
        EXCLUDED.keterangan,
        'SYSTEM',
        now()
    );