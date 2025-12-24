INSERT INTO
    sc_mst.trxtype (kdtrx, jenistrx, uraian)
VALUES (
        'AF1',
        'PASSET',
        'APPROVAL SUPERVISOR HRGA'
    ),
    (
        'AF2',
        'PASSET',
        'APPROVAL MANAGER'
    ),
    (
        'AF3',
        'PASSET',
        'APPROVAL RSM'
    ),
    (
        'AF4',
        'PASSET',
        'APPROVAL GM'
    ),
    (
        'AF5',
        'PASSET',
        'APPROVAL MANAGER KEUANGAN'
    ),
    (
        'AF6',
        'PASSET',
        'APPROVAL DIREKSI'
    )
ON CONFLICT DO NOTHING;