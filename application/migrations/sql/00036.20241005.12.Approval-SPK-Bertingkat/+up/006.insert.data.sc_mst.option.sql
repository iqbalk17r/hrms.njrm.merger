INSERT INTO
    sc_mst."option" (
        kdoption,
        nmoption,
        value3,
        status,
        keterangan,
        input_by,
        input_date,
        group_option
    )
VALUES (
        'SPK:APPROVAL:LEVEL',
        'SETUP SPK APPROVAL LEVEL',
        3,
        'T',
        'Terdapat 5 level approval, 1 spv, 2 mgr, 3 rsm, 4 mgr keu, 5 dir. Isi  value3, sesuai level approval nilai 0-1jt yang tertinggi',
        'MIGRATION',
        now(),
        'PERAWATAN ASSET'
    )
ON CONFLICT DO NOTHING;