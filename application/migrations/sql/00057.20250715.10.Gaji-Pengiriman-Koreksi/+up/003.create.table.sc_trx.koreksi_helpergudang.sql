-- sc_trx.koreksi_helpergudang definition

-- Drop table

-- DROP TABLE sc_trx.koreksi_helpergudang;

CREATE TABLE sc_trx.koreksi_helpergudang (
	id_koreksi_hg serial4 NOT NULL,
	tanggal date NOT NULL,
	nik varchar(50) NOT NULL,
	kdcabang varchar(10) NOT NULL,
	input_by varchar(50) NULL,
	input_date timestamp DEFAULT now() NULL,
	CONSTRAINT koreksi_helpergudang_pkey PRIMARY KEY (id_koreksi_hg)
);