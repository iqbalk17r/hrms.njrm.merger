CREATE TABLE IF NOT EXISTS sc_pk.m_aspek (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	kdaspek bpchar(12) NOT NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status bpchar(12) NULL,
	chold varchar(12) NULL,
	CONSTRAINT m_aspek_pkey PRIMARY KEY (branch, idbu, kdaspek)
);
