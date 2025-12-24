DROP TABLE sc_tmp.sk_peringatan;
CREATE TABLE sc_tmp.sk_peringatan (
	docno varchar(30) NOT NULL,
	nik bpchar(12) NULL,
	docdate timestamp NULL,
	status bpchar(6) NULL,
	startdate date NULL,
	enddate date NULL,
	tindakan bpchar(20) NULL,
	docref bpchar(20) NULL,
	description text NULL,
	solusi text NULL,
	att_name bpchar(50) NULL,
	att_dir text NULL,
	docnotmp varchar(30) NULL,
	inputby bpchar(20) NULL,
	inputdate timestamp NULL,
	updateby bpchar(20) NULL,
	updatedate timestamp NULL,
	cancelby bpchar(20) NULL,
	canceldate timestamp NULL,
	approveby bpchar(20) NULL,
	approvedate timestamp NULL,
	CONSTRAINT sk_peringatan_pkey PRIMARY KEY (docno)
);

DROP TABLE sc_trx.sk_peringatan;
drop view sc_trx.v_surat_peringatan_approval 

CREATE TABLE sc_trx.sk_peringatan (
	docno varchar(30) NOT NULL,
	nik bpchar(12) NULL,
	docdate timestamp NULL,
	status bpchar(6) NULL,
	startdate date NULL,
	enddate date NULL,
	tindakan bpchar(20) NULL,
	docref bpchar(20) NULL,
	description text NULL,
	solusi text NULL,
	att_name bpchar(50) NULL,
	att_dir text NULL,
	docnotmp varchar(30) NULL,
	inputby bpchar(20) NULL,
	inputdate timestamp NULL,
	updateby bpchar(20) NULL,
	updatedate timestamp NULL,
	cancelby bpchar(20) NULL,
	canceldate timestamp NULL,
	approveby bpchar(20) NULL,
	approvedate timestamp NULL,
	CONSTRAINT sk_peringatan_pkey PRIMARY KEY (docno)
);