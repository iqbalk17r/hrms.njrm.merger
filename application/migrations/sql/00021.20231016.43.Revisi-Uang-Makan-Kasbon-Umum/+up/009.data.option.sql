INSERT INTO sc_mst.option
    (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES
    ('CBN:MAX:DUTIEID', 'Maksimal dokumen dinas yang dapat digunakan dalam satu dokumen', null, null, 3, 'T', 'Maksimal dokumen dinas yang dapat digunakan dalam satu dokumen', 'SYSTEM', null, now(), null, 'CASHBON'),
    ('DCL:MAX:DUTIEID', 'Maksimal dokumen dinas yang dapat digunakan dalam satu dokumen', null, null, 3, 'T', 'Maksimal dokumen dinas yang dapat digunakan dalam satu dokumen', 'SYSTEM', null, now(), null, 'DECLARATION')
ON CONFLICT
DO NOTHING
