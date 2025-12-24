INSERT INTO sc_mst.nomor
    (dokumen, part, count3, prefix, sufix, docno, userid, modul, periode, cekclose, group_nomor)
VALUES
    ('NIP-BORONG', '', 3, NULL, NULL, 0, 'SYSTEM', NULL, '202201', 'F', NULL)
ON CONFLICT (dokumen, part)
DO UPDATE SET
    (count3, prefix, sufix, docno, userid, modul, periode, cekclose, group_nomor) =
    (EXCLUDED.count3, EXCLUDED.prefix, EXCLUDED.sufix, EXCLUDED.docno, EXCLUDED.userid, EXCLUDED.modul, EXCLUDED.periode, EXCLUDED.cekclose, EXCLUDED.group_nomor)
;
