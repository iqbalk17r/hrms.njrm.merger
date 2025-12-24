-- sc_trx.status_kepegawaian_document definition

-- Drop table

-- DROP TABLE sc_trx.status_kepegawaian_document;

CREATE TABLE sc_trx.status_kepegawaian_document (
	id bigserial NOT NULL,
	nodok varchar NOT NULL,
	uniquekey varchar NULL,
	input_date timestamp NULL,
	input_by varchar NULL,
	update_date timestamp NULL,
	update_by varchar NULL,
	status varchar NULL,
	file varchar NULL,
	pages int4 NULL,
	CONSTRAINT status_kepegawaian_document_pkey PRIMARY KEY (id)
);
