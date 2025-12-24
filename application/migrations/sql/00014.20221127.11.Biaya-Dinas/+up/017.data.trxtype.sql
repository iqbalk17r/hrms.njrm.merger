    INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES
    ('C', 'PAYTYPE', 'Tunai'),
    ('T', 'PAYTYPE', 'Transfer')
ON CONFLICT ( kdtrx, jenistrx )
    DO NOTHING;

INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES
    ('B', 'TRANSP', 'Becak'),
    ('SM', 'TRANSP', 'Sepeda Motor'),
    ('ST', 'TRANSP', 'Sepeda Terbang'),
    ('K', 'TRANSP', 'Kapal'),
    ('P', 'TRANSP', 'Pesawat Terbang')
    ON CONFLICT ( kdtrx, jenistrx )
    DO NOTHING;