CREATE TABLE IF NOT EXISTS sc_pk.m_aspek_kriteria (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	kdaspek bpchar(12) NOT NULL,
	kdkriteria bpchar(12) NOT NULL,
	description text NULL,
	fulldescription text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status varchar(12) NULL,
	chold varchar(12) NULL,
	orderid int4 NULL,
	CONSTRAINT m_aspek_kriteria_pkey PRIMARY KEY (branch, idbu, kdaspek, kdkriteria)
);

CREATE TABLE IF NOT EXISTS sc_pk.m_aspek_question (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	kdkriteria bpchar(12) NOT NULL,
	questionid bpchar(12) NOT NULL,
	point INT NOT NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status varchar(12) NULL,
	chold varchar(12) NULL,
	CONSTRAINT m_aspek_question_pkey PRIMARY KEY (branch, idbu, kdkriteria, questionid)
);