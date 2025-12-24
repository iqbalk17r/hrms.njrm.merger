CREATE TABLE IF NOT EXISTS sc_pk.m_area (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	kdarea bpchar(12) NOT NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status varchar(12) NULL,
	chold varchar(12) NULL,
	pic bpchar(20) NULL,
	CONSTRAINT m_area_pkey PRIMARY KEY (branch, idbu, kdarea)
);
