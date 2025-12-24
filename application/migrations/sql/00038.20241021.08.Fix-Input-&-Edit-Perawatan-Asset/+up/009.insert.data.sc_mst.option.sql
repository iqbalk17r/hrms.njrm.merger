INSERT INTO
    sc_mst."option" (
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
        'SPK:APPROVAL:GM',
        'SETUP SPK APPROVAL GM',
        'N',
        'T',
        'Value1 Y untuk aktif N untuk non aktif',
        'MIGRATION',
        now(),
        'PERAWATAN ASSET'
    )
ON CONFLICT DO NOTHING;