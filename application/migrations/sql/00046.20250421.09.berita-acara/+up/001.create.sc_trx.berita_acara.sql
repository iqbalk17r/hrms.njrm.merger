-- sc_trx.berita_acara definition

-- Drop table

-- DROP TABLE sc_trx.berita_acara;

CREATE TABLE sc_trx.berita_acara (
	docno bpchar(30) NOT NULL,
	nik bpchar(12) NULL,
	docdate timestamp NULL,
	status bpchar(6) NULL,
	saksi bpchar(20) NULL,
	saksi1 bpchar(30) NULL,
	saksi1_approvedate timestamp NULL,
	saksi2 bpchar(30) NULL,
	saksi2_approvedate timestamp NULL,
	laporan text NULL,
	lokasi text NULL,
	uraian text NULL,
	solusi text NULL,
	peringatan bpchar(20) NULL,
	tindakan bpchar(20) NULL,
	tindaklanjut bpchar(500) NULL,
	docnotmp bpchar(30) NULL,
	inputby bpchar(20) NULL,
	inputdate timestamp NULL,
	updateby bpchar(20) NULL,
	updatedate timestamp NULL,
	cancelby bpchar(20) NULL,
	canceldate timestamp NULL,
	approveby bpchar(20) NULL,
	approvedate timestamp NULL,
	hrd_approveby bpchar(20) NULL,
	hrd_approvedate timestamp NULL,
	subjek bpchar(250) NULL,
	todepartmen bpchar(6) NULL,
	CONSTRAINT berita_acara_pkey PRIMARY KEY (docno)
);
-- Table Function

-- DROP FUNCTION sc_trx.tr_berita_acara();


CREATE OR REPLACE FUNCTION sc_trx.tr_berita_acara()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE

BEGIN
    IF(new.status = 'E' AND old.status IN ('S1', 'A')) THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.updateby, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'S1P' AND old.status = 'S1') THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.saksi1, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'S2P' AND old.status = 'S2') THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.saksi2, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'AP' AND old.status = 'A') THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.approveby, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'AP1' AND old.status = 'A1') THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.approveby, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'AP2' AND old.status = 'A2') THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.approveby, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'BP' AND old.status = 'B') THEN
        INSERT INTO sc_tmp.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.hrd_approveby, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_trx.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);
    END IF;

    RETURN new;
END;
$function$
;

-- Table Triggers

create trigger tr_berita_acara after
update
    on
    sc_trx.berita_acara for each row execute procedure sc_trx.tr_berita_acara();