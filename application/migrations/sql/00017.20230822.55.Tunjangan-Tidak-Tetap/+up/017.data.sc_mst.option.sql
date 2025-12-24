insert into sc_mst.option
    (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, input_date, group_option)
values
    ('BRANCH:CITY','Kota cabang utama','Surabaya',null,null,'T','Untuk Keperluan cetak','SYSTEM',now(),'CASHBON'),
    ('REGIONAL:OFFICE','Opsi Kota Berdasarkan kode cabang',null,null,null,'F','Untuk Keperluan cetak','SYSTEM',now(),'CASHBON')
ON CONFLICT ( kdoption,group_option )
    DO NOTHING;