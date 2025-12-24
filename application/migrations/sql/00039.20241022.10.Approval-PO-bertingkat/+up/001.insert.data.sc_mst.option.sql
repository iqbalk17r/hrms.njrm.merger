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
        'PO:APPROVAL:LEVEL',
        'SETUP PO APPROVAL LEVEL',
        3,
        'T',
        'Terdapat 6 level approval, 1 spv ga, 2 mgr, 3 rsm, 4 gm, 5 mgr keu, 6 dir. Isi  value3, sesuai level approval nilai 0-1jt yang tertinggi',
        'MIGRATION',
        now(),
        'PO SPPB'
    )
ON CONFLICT DO NOTHING;