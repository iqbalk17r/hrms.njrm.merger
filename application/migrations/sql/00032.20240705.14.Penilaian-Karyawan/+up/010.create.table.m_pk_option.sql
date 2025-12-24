CREATE TABLE IF NOT EXISTS sc_pk.m_pk_option (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	kdpk bpchar(20) NOT NULL,
	condition1 bpchar(20) NULL,
	condition2 bpchar(20) NULL,
	description text NULL,
	lastperiod bpchar(12) NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status bpchar(6) NULL,
	chold varchar(6) NULL,
	CONSTRAINT m_pk_option_pkey PRIMARY KEY (branch, idbu, kdpk)
);

