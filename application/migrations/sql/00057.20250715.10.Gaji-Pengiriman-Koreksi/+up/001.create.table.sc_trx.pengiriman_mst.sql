-- sc_trx.pengiriman_mst definition

-- Drop table

-- DROP TABLE sc_trx.pengiriman_mst;

CREATE TABLE sc_trx.pengiriman_mst (
	inspeksi varchar(50) NOT NULL,
	fleet_id varchar(50) NOT NULL,
	fleet_type bpchar(1) NULL,
	user_id varchar(30) NOT NULL,
	tanggal date NULL,
	customer_id text NULL,
	customer_count int4 DEFAULT 0 NULL,
	rittage int4 DEFAULT 0 NULL,
	jarak_cust_terjauh numeric NULL,
	nopol varchar NULL,
	realisasi float8 NULL,
	status varchar(1) DEFAULT 'A'::character varying NULL
);