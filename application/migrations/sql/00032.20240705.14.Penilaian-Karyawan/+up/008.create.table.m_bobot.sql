CREATE TABLE IF NOT EXISTS sc_pk.m_bobot (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	kdcategory bpchar(12) NOT NULL,
	kdvalue bpchar(12) NOT NULL,
	description text NULL,
	value1 bpchar(20) NULL,
	value2 bpchar(20) NULL,
	value3 bpchar(20) NULL,
	value4 bpchar(20) NULL,
	value5 bpchar(20) NULL,
	cgroup bpchar(20) NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status bpchar(12) NULL,
	chold bpchar(12) NULL,
	CONSTRAINT m_bobot_pkey PRIMARY KEY (branch, idbu, kdcategory, kdvalue)
);

