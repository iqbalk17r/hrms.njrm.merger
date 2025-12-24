INSERT INTO sc_mst.option
    (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES
    ('BCDASH', 'BROADCAST DASHBOARD', 'INI ADALAH SITUS HR PT NUSA UNGGUL SARANA ADICIPTA', NULL, NULL, 'T', 'BROADCAST DASHBOARD', 'ARBI', NULL, NOW(), NULL, 'DASHBOARD')
ON CONFLICT (kdoption, group_option)
DO UPDATE SET
    (nmoption, value1, value2, value3, status, keterangan, update_by, update_date) =
    (EXCLUDED.nmoption, EXCLUDED.value1, EXCLUDED.value2, EXCLUDED.value3, EXCLUDED.status, EXCLUDED.keterangan, 'ARBI', NOW())
