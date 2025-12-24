-- sc_mst.sk_peringatan definition

-- Drop table

-- DROP TABLE sc_mst.sk_peringatan;

CREATE TABLE sc_mst.sk_peringatan (
	docno bpchar(20) NOT NULL,
	docname bpchar(30) NULL,
	chold bpchar(4) NULL,
	description text NULL,
	inputby bpchar(20) NULL,
	inputdate timestamp NULL,
	updateby bpchar(20) NULL,
	updatedate timestamp NULL,
	period_value varchar NULL,
	period_type varchar NULL,
	CONSTRAINT sk_peringatan_pkey PRIMARY KEY (docno)
);

begin transaction;
INSERT INTO sc_mst.sk_peringatan (docno, docname, chold, description, inputby, inputdate, updateby, updatedate, period_value, period_type) 
VALUES('SP1', 'SURAT PERINGATAN 1', 'NO', '.', 'ADMIN', '2020-08-05 19:33:05.448', NULL, NULL, '6', 'M');

INSERT INTO sc_mst.sk_peringatan (docno, docname, chold, description, inputby, inputdate, updateby, updatedate, period_value, period_type) 
VALUES('SP2', 'SURAT PERINGATAN 2', 'NO', '.', 'ADMIN', '2020-08-05 19:33:16.658', NULL, NULL, '6', 'M');

INSERT INTO sc_mst.sk_peringatan (docno, docname, chold, description, inputby, inputdate, updateby, updatedate, period_value, period_type) 
VALUES('SP3', 'SURAT PERINGATAN 3', 'NO', '.', 'ADMIN', '2020-08-05 19:33:27.193', NULL, NULL, '6', 'M');

INSERT INTO sc_mst.sk_peringatan (docno, docname, chold, description, inputby, inputdate, updateby, updatedate, period_value, period_type) 
VALUES('TT', 'TEGURAN TERTULIS', 'NO', '.', 'ADMIN', '2021-03-29 13:30:00.000', NULL, NULL, '1', 'D');

INSERT INTO sc_mst.sk_peringatan (docno, docname, chold, description, inputby, inputdate, updateby, updatedate, period_value, period_type) 
VALUES('TL', 'TEGURAN LISAN', 'NO', '.', 'ADMIN', '2021-03-29 13:31:15.000', NULL, NULL, '1', 'D');

INSERT INTO sc_mst.sk_peringatan (docno, docname, chold, description, inputby, inputdate, updateby, updatedate, period_value, period_type) 
VALUES('LL', 'LAIN - LAIN', 'NO', '.', 'ADMIN', '2021-03-29 13:31:55.000', NULL, NULL, '1', 'D');



ALTER TABLE sc_mst.nomor ALTER COLUMN sufix TYPE varchar(30) USING sufix::varchar(30);
commit;