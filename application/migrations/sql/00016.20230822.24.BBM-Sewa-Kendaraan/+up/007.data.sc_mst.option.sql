INSERT INTO sc_mst.option
    (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES
    ('UB', 'SETUP BBM', null, null, 25000, 'T', 'VALUE1 (CALLPLAN YES/NO/NULL), VALUE3 (NOMINAL)', 'SYSTEM', 'SYSTEM', now(), now(), 'TRANS'),
    ('USK', 'SETUP SEWA KENDARAAN', null, null, 15000, 'T', 'VALUE1 (CALLPLAN YES/NO/NULL), VALUE3 (NOMINAL)', 'SYSTEM', 'SYSTEM', now(), now(), 'TRANS')
ON CONFLICT
DO NOTHING ;
