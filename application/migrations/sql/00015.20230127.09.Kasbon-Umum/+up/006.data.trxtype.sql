INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES
    ('PO','CASHBONTYPE','PO (SPPB)'),
    ('DN','CASHBONTYPE','DINAS'),
    ('AI','CASHBONTYPE','ANGKUT INTERNAL'),
    ('BL','CASHBONTYPE','BIAYA LANGSUNG')
ON CONFLICT ( kdtrx, jenistrx )
    DO NOTHING;

INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES
    ('D','CASHBONSTATUS','Disetujui'),
    ('M','CASHBONSTATUS','Menunggu Persetujuan'),
    ('B','CASHBONSTATUS','Dibatalkan')
    ON CONFLICT ( kdtrx, jenistrx )
    DO NOTHING;