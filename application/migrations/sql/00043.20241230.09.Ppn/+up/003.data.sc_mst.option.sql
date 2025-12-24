INSERT INTO sc_mst.option 
    (kdoption,nmoption,value1,status,keterangan,input_by,input_date,group_option) 
VALUES
    ('PPN','SETUP PPN','12','T','NILAI PERSENTASE PPN','SYSTEM','2024-12-27 00:00:01','TAX')
ON CONFLICT(kdoption)
    DO NOTHING;