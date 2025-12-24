INSERT INTO sc_mst.option
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, input_date, group_option)
VALUES
    ('DEFACS', 'DEFAULT USER ACCESS', 'I.T.B.4/I.T.B.16/I.T.A.15', null, null, 'T', 'AKSES DASAR UNTUK USER BARU DARI RECRUITMENT', 'SYSTEM', NOW(), 'RECRUITMENT')
ON CONFLICT ( kdoption,group_option )
    DO NOTHING;