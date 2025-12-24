INSERT INTO
    sc_mst.trxtype (kdtrx, jenistrx, uraian)
VALUES (
        'A1',
        'PASSET',
        'APPROVAL SUPERVISOR HRGA'
    )
    ,(
        'A2',
        'PASSET',
        'APPROVAL MANAGER'
    ),
    (
        'A3',
        'PASSET',
        'APPROVAL RSM'
    ),
    (
        'A4',
        'PASSET',
        'APPROVAL GM'
    ),
    (
        'A5',
        'PASSET',
        'APPROVAL MANAGER KEUANGAN'
    ),
    (
        'A6',
        'PASSET',
        'APPROVAL DIREKSI'
    )
ON CONFLICT DO NOTHING;