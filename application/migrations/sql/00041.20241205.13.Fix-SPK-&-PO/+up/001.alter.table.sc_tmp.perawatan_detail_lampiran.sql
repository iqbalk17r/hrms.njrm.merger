drop table sc_tmp.perawatan_detail_lampiran;

CREATE TABLE sc_tmp.perawatan_detail_lampiran (
	nodok bpchar(20) NOT NULL,
	nodokref bpchar(20) NOT NULL,
	idfaktur bpchar(100) NULL,
	id serial,
	keterangan bpchar(100) NULL,
	nservis numeric(18, 2) NULL,
	ndiskon numeric(18, 2) NULL,
	nnetto numeric(18, 2) NULL,
	typeservis bpchar(20) NULL,
	inputdate timestamp NULL,
	inputby bpchar(20) NULL,
	updatedate timestamp NULL,
	updateby varchar(20) NULL,
	ref_type bpchar(12) NULL,
	status bpchar(12) NULL,
	exppn bpchar(18) NULL,
	pkp bpchar(12) NULL,
	ndpp numeric(18, 2) NULL,
	nppn numeric(18, 2) NULL,
	CONSTRAINT perawatan_detail_lampiran_pkey PRIMARY KEY (id, nodok)
);

-- Table Triggers

create trigger tr_tmp_perawatan_detail_lampiran after
insert
    or
delete
    or
update
    on
    sc_tmp.perawatan_detail_lampiran for each row execute procedure sc_tmp.tr_perawatan_detail_lampiran();