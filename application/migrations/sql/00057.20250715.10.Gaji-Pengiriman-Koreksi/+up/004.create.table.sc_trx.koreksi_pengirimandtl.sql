-- sc_trx.koreksi_pengirimandtl definition

-- Drop table

-- DROP TABLE sc_trx.koreksi_pengirimandtl;

CREATE TABLE sc_trx.koreksi_pengirimandtl (
	id_dtl serial4 NOT NULL,
	id_koreksi varchar(50) NOT NULL,
	sjp_no varchar(50) NULL,
	customer_id varchar(30) NULL,
	customer_name varchar(255) NULL,
	nopol varchar(50) NULL,
	tanggal date NULL,
	driver varchar(255) NULL,
	helper text NULL,
	ritase int4 NULL,
	user_create varchar(30) NULL,
	tgl_create timestamp NULL,
	CONSTRAINT koreksi_pengirimandtl_pkey PRIMARY KEY (id_dtl)
);