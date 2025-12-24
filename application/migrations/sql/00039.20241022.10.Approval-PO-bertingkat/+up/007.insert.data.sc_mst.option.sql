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
        'PO:APPROVAL:GM',
        'SETUP PO APPROVAL GM',
        'N',
        'T',
        'Value1 Y untuk aktif N untuk non aktif',
        'MIGRATION',
        now(),
        'PO SPPB'
    )
ON CONFLICT DO NOTHING;