-- sc_trx.rekap_tjkehadiran definition

-- Drop table

-- DROP TABLE sc_trx.rekap_tjkehadiran;

CREATE TABLE sc_trx.rekap_tjkehadiran (
	nik varchar(50) NULL,
	nmlengkap varchar(50) NULL,
	tanggal_mulai date NULL,
	tanggal_selesai date NULL,
	nmjabatan varchar(50) NULL,
	kdjabatan bpchar(2) NULL,
	kdcabang bpchar(6) NULL,
	tjkehadiran numeric NULL,
	periode text NULL
);