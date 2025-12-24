delete from sc_mst.trxtype where jenistrx = 'CBN:COMPONENT:TYPE';
insert into sc_mst.trxtype(kdtrx, jenistrx, uraian)
values
    ('BL','CBN:COMPONENT:TYPE','BIAYA LANGSUNG'),
    ('AI','CBN:COMPONENT:TYPE','ANGKUT INTERNAL'),
    ('PO','CBN:COMPONENT:TYPE','PO (SPPB)'),
    ('DN','CBN:COMPONENT:TYPE','DINAS'),
    ('DC','CBN:COMPONENT:TYPE','DEKLARASI'),
    ('M','CBN:COMPONENT:TYPE','SEWA MOBIL'),
    ('SM','CBN:COMPONENT:TYPE','SEWA SEPEDA MOTOR'),
    ('-','CBN:COMPONENT:TYPE','LAIN LAIN')
ON CONFLICT
DO NOTHING ;