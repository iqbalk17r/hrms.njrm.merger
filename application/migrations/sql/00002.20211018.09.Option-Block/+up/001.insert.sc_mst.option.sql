INSERT INTO sc_mst.option
    (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES
    ('BLKCT', 'BLOCK HARI CUTI', '+7D', NULL, NULL, 'T', 'BISA INPUT DIMULAI DARI H(VALUE1) DARI HARI INI', 'ARBI', NULL, NOW(), NULL, 'CUTI'),
    ('BLKDN', 'BLOCK HARI DINAS', '+1D', NULL, NULL, 'F', 'BISA INPUT DIMULAI DARI H(VALUE1) DARI HARI INI', 'ARBI', NULL, NOW(), NULL, 'DINAS'),
    ('BLKLB', 'BLOK HARI LEMBUR', '-1D', NULL, NULL, 'F', 'BISA INPUT DIMULAI DARI H(VALUE1) DARI HARI INI', 'ARBI', NULL, NOW(), NULL, 'LEMBUR')
ON CONFLICT (kdoption, group_option)
DO UPDATE SET
    (nmoption, value1, value2, value3, status, keterangan, update_by, update_date) =
    (EXCLUDED.nmoption, EXCLUDED.value1, EXCLUDED.value2, EXCLUDED.value3, EXCLUDED.status, EXCLUDED.keterangan, 'ARBI', NOW())
