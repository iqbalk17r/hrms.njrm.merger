-- sc_trx.pengiriman_dtl definition

-- Drop table

-- DROP TABLE sc_trx.pengiriman_dtl;

CREATE TABLE sc_trx.pengiriman_dtl (
	inspeksi varchar NOT NULL,
	fleet_id varchar NULL,
	fleet_type bpchar(1) NULL,
	tanggal date NULL,
	latitude_office numeric NULL,
	longitude_office numeric NULL,
	customer_id varchar NOT NULL,
	latitude_unloading numeric NULL,
	longitude_unloading numeric NULL,
	jarak numeric NULL,
	customer_name varchar(50) NULL,
	sjpno varchar(12) NULL,
	CONSTRAINT pengiriman_dtl_pkey PRIMARY KEY (inspeksi, customer_id)
);