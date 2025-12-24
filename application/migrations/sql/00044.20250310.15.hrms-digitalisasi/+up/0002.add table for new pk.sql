begin transaction;
CREATE TABLE sc_pk.master_pk (
    kddok varchar(20) PRIMARY key,
    kdcontract bpchar(20) not null,
    nik bpchar(12) NOT NULL,
    summary varchar(20),
    description text NULL,
    inputdate timestamp NULL,
    inputby bpchar(12) NULL,
    updatedate timestamp NULL,
    updateby bpchar(25) NULL,
    approvedate timestamp NULL,
    approveby bpchar(25) NULL,
    cancelappr boolean default false,
    canceldate timestamp NULL,
    cancelby bpchar(25) NULL,
    status bpchar(12) NULL default 'N'
);

CREATE TABLE sc_pk.score_aspect_pk (
	kd_aspect varchar(10) PRIMARY key not null,
	aspect_question varchar(60) not null,
	enabled boolean default true
);

CREATE TABLE sc_pk.detail_pk (
    detailid serial PRIMARY key not null,
	kddok bpchar(20)not null,
	kd_aspect bpchar(10)not null,
	score int not null,
	desc_aspect varchar(20)
);

CREATE TABLE sc_pk.master_appr (
    kdappr varchar(20) PRIMARY key,
    description varchar(50) not null,
    active boolean default TRUE
);

CREATE TABLE sc_pk.master_appr_list(
    nik bpchar(20) primary key,
    jobposition bpchar(20),
    status boolean default true
)

INSERT INTO sc_pk.master_appr 
    (kdappr, description) 
VALUES 
    ('N', 'MENUNGGU PERSETUJUAN ATASAN 2'),
    ('A2', 'MENUNGGU PERSETUJUAN HRGA'),
    ('HR', 'MENUNGGU PERSETUJUAN GM'),
    ('GM', 'MENUNGGU PERSETUJUAN DIREKTUR'),
    ('P', 'PERSETUJUAN FINAL'),
    ('C', 'DI BATALKAN');

INSERT INTO sc_pk.master_appr_list 
    (nik, jobposition) 
VALUES 
    ('0321.438', 'HRGA'),
    ('0223.540', 'GM'),
    ('0112.001', 'D');

insert into sc_pk.score_aspect_pk 
values
('M001','Kemampuan Kerja',true),
('M002','Inisatif dan Kreatifitas',true),
('M003','Tanggung jawab',true),
('M004','Kerjasama',true),
('M005','Ketelitian',true),
('M006','Disiplin',true),
('M007','Sikap terhadap atasan',true)

commit;

-- ============================= TRIGGER =====================
CREATE OR REPLACE FUNCTION sc_mst.pr_generate_numbering(
    module_name TEXT,
    input_by TEXT,
    properties JSONB
)
    RETURNS TEXT AS $$
DECLARE
    get_code RECORD;
    doc_exists BOOLEAN;
BEGIN
    -- Start a transaction
    PERFORM pg_advisory_xact_lock(hashtext(module_name || input_by)); -- Ensure exclusive operation per user and module

    -- Check if the document exists in sc_mst.nomor
    SELECT EXISTS(SELECT 1 FROM sc_mst.nomor WHERE dokumen = module_name)
    INTO doc_exists;

    IF NOT doc_exists THEN
        -- If it doesn't exist, insert into sc_mst.nomor
        INSERT INTO sc_mst.nomor (
            dokumen, part, count3, prefix, sufix, docno, userid
        ) VALUES (
                     module_name,
                     COALESCE(properties->>'part', ''),
                     COALESCE((properties->>'count3')::INT, 3),
                     COALESCE(properties->>'prefix', 'ZZZ'),
                     COALESCE(properties->>'sufix', ''),
                     COALESCE((properties->>'docno')::INT, 0),
                     input_by
                 );

        -- Insert into sc_mst.penomoran
        INSERT INTO sc_mst.penomoran (
            dokumen, userid, errorid, partid, counterid, xno
        ) VALUES (
                     module_name,
                     input_by,
                     COALESCE((properties->>'errorid')::INT, 0),
                     COALESCE(properties->>'partid', ''),
                     COALESCE((properties->>'counterid')::INT, 1),
                     COALESCE((properties->>'xno')::INT, 0)
                 );

    ELSE
        -- If it exists, delete from sc_mst.penomoran first
        DELETE FROM sc_mst.penomoran
        WHERE dokumen = module_name AND userid = input_by;

        -- Then insert a new record into sc_mst.penomoran
        INSERT INTO sc_mst.penomoran (
            dokumen, userid, errorid, partid, counterid, xno
        ) VALUES (
                     module_name,
                     input_by,
                     COALESCE((properties->>'errorid')::INT, 0),
                     COALESCE(properties->>'partid', ''),
                     COALESCE((properties->>'counterid')::INT, 1),
                     COALESCE((properties->>'xno')::INT, 0)
                 );
    END IF;

    -- Get the generated code
    SELECT nomor INTO get_code
    FROM sc_mst.penomoran
    WHERE dokumen = module_name AND userid = input_by
    LIMIT 1;

    -- Return the generated code
    RETURN get_code.nomor;

EXCEPTION
    WHEN OTHERS THEN
        -- Rollback the transaction in case of error
        RAISE EXCEPTION 'Database transaction failed: %', SQLERRM;
        RETURN NULL;
END;
$$ LANGUAGE plpgsql;

-- SELECT sc_mst.pr_generate_numbering('TEST MODULE', 'SYSTEM_TEST', '{"count3": 9, "prefix": "SYS", "counterid": 1, "xno": 1}');
