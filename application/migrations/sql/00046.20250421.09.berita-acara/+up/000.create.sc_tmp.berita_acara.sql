
-- sc_tmp.berita_acara definition

-- Drop table

-- DROP TABLE sc_tmp.berita_acara;

CREATE TABLE sc_tmp.berita_acara (
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
-- DROP FUNCTION sc_tmp.tr_berita_acara();

CREATE OR REPLACE FUNCTION sc_tmp.tr_berita_acara()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE
    vr_nomor CHAR(30);
    /*vr_lastdoc NUMERIC;
    vr_lastdocnew NUMERIC;
    vr_dokumen CHAR(12);*/
    vr_dept CHAR(6);
BEGIN
    /*vr_dokumen := 'ALL';*/

    vr_dept := CASE
                   WHEN bag_dept = '' THEN 'XXX'::CHAR(6)
                   ELSE bag_dept::CHAR(6) END AS bag_dept
               FROM sc_mst.lv_m_karyawan
               WHERE nik = new.docno;
    /*raise notice '%',vr_dept;*/

    IF(new.status IN ('S1', 'A','A1','A2', 'B') AND old.status = 'I') THEN
        if not exists(select true from sc_mst.nomor where dokumen='BAC/IM') then
            INSERT INTO sc_mst.nomor (dokumen, part, count3, prefix, sufix, docno, userid, modul, cekclose) VALUES ('BAC/IM', '', 3, '', concat('/',trim(vr_dept),'/NJRBJM/',TRIM(TO_CHAR(new.docdate, 'RM')),TO_CHAR(new.docdate, '/YYYY') ), 1, new.docno, 'BAC/IM', 'T  ');
        else
            update sc_mst.nomor set sufix=concat('/',trim(vr_dept),'/NUSA/',TRIM(TO_CHAR(new.docdate, 'RM')),TO_CHAR(new.docdate, '/YYYY') ) where dokumen='BAC/IM';
        end if;
        DELETE FROM sc_mst.penomoran WHERE userid = new.docno;
        INSERT INTO sc_mst.penomoran (userid, dokumen, nomor, errorid, partid, counterid, xno)
        VALUES (new.docno, 'BAC/IM', ' ', 0, ' ', 1, 0);

        vr_nomor := TRIM(COALESCE(nomor, '')) FROM sc_mst.penomoran WHERE userid = new.docno;

        /*raise notice '%',vr_nomor;*/

        /*if(SELECT SUBSTRING (MAX((RIGHT(TRIM(docno), 4))), 0, 3)::text FROM sc_trx.berita_acara) = 'BA' then /*FROMAT LAMA*/
            vr_lastdoc := CASE
                  WHEN MAX((RIGHT(TRIM(docno), 4))) IS NULL OR MAX((RIGHT(TRIM(docno), 4))) = '' THEN '0'::NUMERIC
                  ELSE MAX((RIGHT(TRIM(docno), 4)))::NUMERIC END AS lastdoc
              FROM sc_trx.berita_acara
              WHERE TO_CHAR(docdate, 'YYYYMM') = TO_CHAR(new.docdate, 'YYYYMM');
            ELSE
            vr_lastdoc := CASE
                  WHEN MAX((LEFT(TRIM(docno), 2))) IS NULL OR MAX((LEFT(TRIM(docno), 2))) = '' THEN '0'::NUMERIC
                  ELSE MAX((LEFT(TRIM(docno), 2)))::NUMERIC
                  END lastdoc
              FROM sc_trx.berita_acara
              WHERE TO_CHAR(docdate, 'YYYYMM') = TO_CHAR(new.docdate, 'YYYYMM');
        end if;*/


        /*vr_lastdocnew := vr_lastdoc;

        UPDATE sc_mst.nomor
            SET prefix = '', sufix = '/TES/SNI/' || TRIM(TO_CHAR(new.docdate, 'RM')) || TO_CHAR(new.docdate, '/YYYY'), docno = vr_lastdocnew
            WHERE dokumen = vr_dokumen;

        INSERT INTO sc_mst.penomoran (userid, dokumen, nomor, errorid, partid, counterid, xno)
        VALUES (new.docno, vr_dokumen, ' ', 0, ' ', 1, 0);

        vr_nomor := TRIM(COALESCE(nomor, '')) FROM sc_mst.penomoran WHERE userid = new.docno;*/

        INSERT INTO sc_trx.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT vr_nomor, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_tmp.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 0, vr_nomor, '', 'BAC/IM');

        DELETE FROM sc_tmp.berita_acara WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status IN ('S1', 'B') AND old.status = 'E') THEN
        DELETE FROM sc_trx.berita_acara WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.docnotmp, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_tmp.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 0, new.docnotmp, '', 'BAC/IM');

        DELETE FROM sc_tmp.berita_acara WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF((new.status IN ('S2', 'B') AND old.status = 'S1P') OR (new.status = 'B' AND old.status = 'S2P') 
    OR (new.status = 'A2' AND old.status = 'AP1') OR (new.status = 'B' AND old.status = 'AP2') OR (new.status = 'P' AND old.status = 'BP')) THEN
        DELETE FROM sc_trx.berita_acara WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.docnotmp, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_tmp.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 1, new.docnotmp, '', 'BAC/IM');

        DELETE FROM sc_tmp.berita_acara WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'X' AND old.status IN ('S1P', 'S2P', 'AP1','AP2', 'BP')) THEN
        DELETE FROM sc_trx.berita_acara WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.berita_acara (docno, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                                         lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                                         approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen)
            (SELECT new.docnotmp, nik, docdate, status, saksi, saksi1, saksi1_approvedate, saksi2, saksi2_approvedate, laporan,
                    lokasi, uraian, solusi, peringatan, tindakan, tindaklanjut, NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate,
                    approveby, approvedate, hrd_approveby, hrd_approvedate, subjek, todepartmen
             FROM sc_tmp.berita_acara
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 2, new.docnotmp, '', 'BAC/IM');

        DELETE FROM sc_tmp.berita_acara WHERE docno IS NOT NULL AND docno = new.docno;
    END IF;

    RETURN new;

END;
$function$
;



-- Table Triggers

create trigger tr_berita_acara after
update
    on
    sc_tmp.berita_acara for each row execute procedure sc_tmp.tr_berita_acara();