INSERT INTO sc_mst.option
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES
    ('OVERTIME:MIN', 'MINIMAL DURASI LEMBUR', '1', NULL, NULL, 'T', 'DURASI DALAM UNIT JAM', 'RKM', NULL, NOW(), NULL, 'LEMBUR'),
    ('OVERTIME:MAX', 'MAKSIMAL DURASI LEMBUR', '4', NULL, NULL, 'T', 'DURASI DALAM UNIT JAM', 'RKM', NULL, NOW(), NULL, 'LEMBUR'),
    ('OVERTIME:CALC:REST', 'KALKULASI ISTIRAHAT ', 'T', NULL, NULL, 'T', 'KALKULASI ISTIRAHAT DURASI ISTIRAHAT SAAT MENGHITUNG DURASI LEMBUR', 'RKM', NULL, NOW(), NULL, 'LEMBUR')
ON CONFLICT (kdoption, group_option)
    DO UPDATE SET
    (nmoption, value1, value2, value3, status, keterangan, update_by, update_date) =
        (EXCLUDED.nmoption, EXCLUDED.value1, EXCLUDED.value2, EXCLUDED.value3, EXCLUDED.status, EXCLUDED.keterangan, 'ARBI', NOW())
