INSERT INTO sc_mst.option (
    kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by,input_date, update_date, group_option
)
VALUES ('EMPLOYEE:ENTRY:DATE', 'PARAMETER TANGGAL MASUK KARYAWAN', '2022-01-15', null, null, 'T', 'PERHITUNGAN PARAMETER CUTI BERDASARKAN TANGGAL MASUK KARYAWAN', 'SYSTEM', null, now(), null, 'CUTI')
ON CONFLICT (kdoption,group_option)
    DO NOTHING;