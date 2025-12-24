-- sc_mst.kejadian definition

-- Drop table

-- DROP TABLE sc_mst.kejadian;

CREATE TABLE sc_mst.kejadian (
	kdkejadian bpchar(25) NOT NULL,
	nmkejadian varchar(35) NULL,
	inputby bpchar(20) NULL,
	inputdate timestamp NULL,
	updateby bpchar(20) NULL,
	updatedate timestamp NULL,
	CONSTRAINT kejadian_pkey PRIMARY KEY (kdkejadian)
);

INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('AM', 'AKSI MASSA / HURU - HARA', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('AP', 'PENCURIAN / KEHILANGAN', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('KK', 'KECELAKAAN KERJA', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('KL', 'KECELAKAAN LALU LINTAS', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('LL', 'LAIN - LAIN', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('PA', 'PERMASALAHAN ABSENSI', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('TK', 'PERKELAHIAN / TINDAK KEKERASAN', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
INSERT INTO sc_mst.kejadian (kdkejadian, nmkejadian, inputby, inputdate, updateby, updatedate) VALUES('UP', 'UPAYA PENCURIAN / PENGERUSAKAN', 'ARBI', '2021-09-29 14:35:56.063', NULL, NULL);
