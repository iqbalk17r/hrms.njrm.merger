-- sc_trx.status_kepegawaian_document definition

-- Drop table

-- DROP TABLE sc_trx.status_kepegawaian_document;

INSERT INTO sc_mst."option"
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES('C:G:S:1', 'Contract Group Status 1', 'PK,P1,P2,P3,P4,P5,P6', NULL, NULL, 'T', 'Grup status kontrak 1 (PKWT)', 'SYSTEM', NULL, '2024-09-13 00:00:11.000', NULL, 'CONTRACT');
INSERT INTO sc_mst."option"
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES('C:G:S:2', 'Contract Group Status 2', 'KT', NULL, NULL, 'T', 'Grup status kontrak 2 (PKWTT)', 'SYSTEM', NULL, '2024-09-13 00:00:11.000', NULL, 'CONTRACT');
INSERT INTO sc_mst."option"
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES('DCMS', 'URL DCMS ', 'HTTP://192.168.223.160:88/DMS/LOGIN/LOGIN_WITH_TOKEN?', NULL, NULL, 'T', 'URL DCMS LOGIN WITH TOKEN', '1221.480', NULL, '2025-03-19 01:48:15.000', NULL, '');
INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) 
VALUES('BEGINDATE:APPRAISAL', 'BATAS BAWAH TANGGAL TARIK KONDITE', '2025-03-01', NULL, NULL, 'T', 'BATAS BAWAH TANGGAL TARIK KONDITE', 'SYSTEM', NULL, '2024-05-21 17:59:23.309', NULL, 'DASHBOARD');




