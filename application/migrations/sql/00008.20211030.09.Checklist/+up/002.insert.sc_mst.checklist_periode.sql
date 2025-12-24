INSERT INTO sc_mst.checklist_periode
    (kode_periode, nama_periode, hold, urutan, input_date, input_by, update_date, update_by)
VALUES
    ('JAM', 'JAM', 'F', 1, NOW(), 'SYSTEM', NULL, NULL),
    ('HARI', 'HARI', 'F', 2, NOW(), 'SYSTEM', NULL, NULL),
    ('BULAN', 'BULAN', 'F', 3, NOW(), 'SYSTEM', NULL, NULL),
    ('TAHUN', 'TAHUN', 'F', 4, NOW(), 'SYSTEM', NULL, NULL)
ON CONFLICT (kode_periode)
DO UPDATE SET
    (nama_periode, hold, urutan, update_date, update_by) =
    (EXCLUDED.nama_periode, EXCLUDED.hold, EXCLUDED.urutan, NOW(), 'SYSTEM')
;
