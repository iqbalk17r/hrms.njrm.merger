
-- sc_trx.document_contract definition

-- Drop table

-- DROP TABLE sc_trx.document_contract;

CREATE TABLE sc_trx.document_contract (
	nodoc serial4 NOT NULL,
	kdcontract bpchar(20) NOT NULL,
	nik bpchar(20) NOT NULL,
	file_name varchar(255) NOT NULL,
	full_path text NOT NULL,
	orig_name varchar(255) NOT NULL,
	file_ext varchar(255) NOT NULL,
	file_size int4 NOT NULL,
	input_date timestamp NULL,
	input_by bpchar(20) NULL,
	update_date timestamp NULL,
	update_by varchar(20) NULL,
	CONSTRAINT document_contract_kdcontract_key UNIQUE (kdcontract),
	CONSTRAINT document_contract_pkey PRIMARY KEY (nodoc)
);