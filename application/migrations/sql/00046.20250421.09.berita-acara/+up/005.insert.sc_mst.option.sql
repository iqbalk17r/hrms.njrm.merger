begin transaction;

INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('A1', 'I.T.B.27', 'BUTUH PERSETUJUAN ATASAN SATU');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('AP1', 'I.T.B.27', 'PROSES PERSETUJUAN ATASAN SATU');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('A2', 'I.T.B.27', 'BUTUH PERSETUJUAN ATASAN DUA');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('AP2', 'I.T.B.27', 'PROSES PERSETUJUAN ATASAN DUA');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('E', 'I.T.B.27', 'PROSES EDIT');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('I', 'I.T.B.27', 'PROSES INPUT');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('P', 'I.T.B.27', 'CETAK/PRINT');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('X', 'I.T.B.27', 'BATAL');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('B', 'I.T.B.27', 'BUTUH PERSETUJUAN HRGA SPV');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('BP', 'I.T.B.27', 'PROSES PERSETUJUAN HRGA SPV');
INSERT INTO sc_mst.trxtype (kdtrx, jenistrx, uraian) VALUES('EB', 'I.T.B.27', 'PROSES EDIT');
UPDATE sc_mst.trxtype SET uraian='PROSES PERSETUJUAN HRD' WHERE kdtrx='B' AND jenistrx='I.T.C.1';

INSERT INTO sc_mst.nomor (dokumen, part, count3, prefix, sufix, docno, userid, modul, periode, cekclose) VALUES('I.T.B.27', '', 3, 'SP.', '/NUSA/IV/2025', 1, 'SYSTEM      ', 'SURAT PERINGATAN', '202407', 'F  ');
INSERT INTO sc_mst.nomor (dokumen, part, count3, prefix, sufix, docno, userid, modul, periode, cekclose) VALUES('BAC/IM', '', 3, '', '/HR/NUSA/IV/2025', 2, '01.0019     ', 'BAC/IM', NULL, 'T  ')

ALTER TABLE sc_mst.penomoran ALTER COLUMN nomor TYPE bpchar(30) USING nomor::bpchar(30);
ALTER TABLE sc_mst.nomor ALTER COLUMN prefix TYPE varchar(30) USING prefix::varchar(30);

commit;

