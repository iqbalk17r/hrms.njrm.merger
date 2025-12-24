-- Table: sc_trx.sk_peringatan

-- DROP TABLE sc_trx.sk_peringatan;

CREATE TABLE sc_trx.sk_peringatan
(
  docno character varying(30) NOT NULL,
  nik character(12),
  docdate timestamp without time zone,
  status character(6),
  startdate date,
  enddate date,
  tindakan character(20),
  docref character(20),
  description text,
  solusi text,
  att_name character(50),
  att_dir text,
  docnotmp character varying(30),
  inputby character(20),
  inputdate timestamp without time zone,
  updateby character(20),
  updatedate timestamp without time zone,
  cancelby character(20),
  canceldate timestamp without time zone,
  approveby character(20),
  approvedate timestamp without time zone,
  CONSTRAINT sk_peringatan_pkey PRIMARY KEY (docno)
)
WITH (
  OIDS=FALSE
);