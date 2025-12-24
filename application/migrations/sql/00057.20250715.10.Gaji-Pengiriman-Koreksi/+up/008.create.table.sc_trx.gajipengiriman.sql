-- sc_trx.gajipengiriman definition

-- Drop table

-- DROP TABLE sc_trx.gajipengiriman;

CREATE TABLE sc_trx.gajipengiriman (
	nik bpchar(50) NULL,
	tanggal timestamp NULL,
	kdcabang bpchar(6) NULL,
	kdjabatan bpchar(2) NULL,
	armada bpchar(2) NULL,
	upah_harian numeric(18, 2) NULL,
	rit1 numeric(18, 2) NULL,
	rit2 numeric(18, 2) NULL,
	jml_toko numeric(18, 2) NULL,
	jml_jarak1 numeric(18, 2) NULL,
	jml_jarak2 numeric(18, 2) NULL,
	uang_makan numeric(18, 2) NULL
);