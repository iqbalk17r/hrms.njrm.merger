INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES
    ('TPB','TRANSPTYPE','PRIBADI'),
    ('TDN','TRANSPTYPE','DINAS'),
    ('M','TRANSP','Mobil')
ON CONFLICT ( kdtrx, jenistrx )
    DO NOTHING;