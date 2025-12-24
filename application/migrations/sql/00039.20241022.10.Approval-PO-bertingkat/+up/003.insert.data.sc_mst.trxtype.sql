INSERT INTO
    sc_mst.trxtype (kdtrx, jenistrx, uraian)
VALUES (
        'A1',
        'POATK',
        'APPROVAL SUPERVISOR HRGA'
    )
    ,(
        'A2',
        'POATK',
        'APPROVAL MANAGER'
    ),
    (
        'A3',
        'POATK',
        'APPROVAL RSM'
    ),
    (
        'A4',
        'POATK',
        'APPROVAL GM'
    ),
    (
        'A5',
        'POATK',
        'APPROVAL MANAGER KEUANGAN'
    ),
    (
        'A6',
        'POATK',
        'APPROVAL DIREKSI'
    ),
    (
        'AF1',
        'POATK',
        'APPROVAL SUPERVISOR HRGA'
    )
    ,(
        'AF2',
        'POATK',
        'APPROVAL MANAGER'
    ),
    (
        'AF3',
        'POATK',
        'APPROVAL RSM'
    ),
    (
        'AF4',
        'POATK',
        'APPROVAL GM'
    ),
    (
        'AF5',
        'POATK',
        'APPROVAL MANAGER KEUANGAN'
    ),
    (
        'AF6',
        'POATK',
        'APPROVAL DIREKSI'
    ),
    (
        'FP',
        'POATK',
        'SELESAI'
    )
ON CONFLICT DO NOTHING;
