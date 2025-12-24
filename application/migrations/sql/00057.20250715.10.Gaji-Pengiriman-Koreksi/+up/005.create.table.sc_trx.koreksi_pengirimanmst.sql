-- sc_trx.koreksi_pengirimanmst definition

-- Drop table

-- DROP TABLE sc_trx.koreksi_pengirimanmst;

CREATE TABLE sc_trx.koreksi_pengirimanmst (
	id_koreksi varchar(50) NOT NULL,
	nopol varchar(50) NOT NULL,
	fleet_type bpchar(10) NULL,
	user_id varchar(30) NOT NULL,
	tanggal date NULL,
	customer_count int4 DEFAULT 0 NULL,
	rittage int4 DEFAULT 0 NULL,
	jarak_cust_terjauh numeric NULL,
	nik_atasan varchar(20) NULL,
	status varchar(1) DEFAULT 'A'::character varying NULL,
	approval_by varchar(20) NULL,
	approval_date timestamp NULL,
	alasan_reject text NULL,
	input_by varchar(20) NULL,
	input_date timestamp NULL,
	update_by varchar(20) NULL,
	update_date timestamp NULL
);