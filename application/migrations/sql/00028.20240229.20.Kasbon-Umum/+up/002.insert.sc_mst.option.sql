INSERT INTO sc_mst.option
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES
    ('DUTIE:LIMIT:DATE', 'LIMIT DOKUMEN DINAS', '202309', NULL, NULL, 'T', 'LIMIT DOKUMEN DINAS DI DEKLARASI / KASBON', 'RKM', NULL, NOW(), NULL, 'DINAS')
ON CONFLICT (kdoption, group_option)
    DO UPDATE SET
    (nmoption, value1, value2, value3, status, keterangan, update_by, update_date) =
        (EXCLUDED.nmoption, EXCLUDED.value1, EXCLUDED.value2, EXCLUDED.value3, EXCLUDED.status, EXCLUDED.keterangan, 'RKM', NOW())
