-- Function: sc_tmp.tr_sk_peringatan()

-- DROP FUNCTION sc_tmp.tr_sk_peringatan();

CREATE OR REPLACE FUNCTION sc_tmp.tr_sk_peringatan()
  RETURNS trigger AS
$BODY$
DECLARE
     vr_nomor CHAR(30);
     vr_lastdoc NUMERIC;
BEGIN
    IF(new.status = 'A' AND old.status = 'I') THEN
        DELETE FROM sc_mst.penomoran WHERE userid = new.docno;

        vr_lastdoc := CASE
            WHEN MAX((LEFT(TRIM(docno), 2))) IS NULL OR MAX((LEFT(TRIM(docno), 2))) = '' THEN '0'::NUMERIC
            ELSE MAX((LEFT(TRIM(docno), 2)))::NUMERIC END lastdoc
        FROM sc_trx.sk_peringatan
        WHERE TO_CHAR(docdate, 'YYYYMM') = TO_CHAR(new.docdate, 'YYYYMM');

        UPDATE sc_mst.nomor
        SET prefix = '', sufix = '/SP.HRD/SNI/' || TRIM(TO_CHAR(new.docdate, 'RM')) || TO_CHAR(new.docdate, '/YYYY'), docno = vr_lastdoc
        WHERE dokumen = 'I.T.B.26';

        INSERT INTO sc_mst.penomoran (userid, dokumen, nomor, errorid, partid, counterid, xno)
        VALUES (new.docno, 'I.T.B.26', ' ', 0, ' ', 1, 0);

        vr_nomor := TRIM(COALESCE(nomor, '')) FROM sc_mst.penomoran WHERE userid = new.docno;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
        (SELECT vr_nomor, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
        FROM sc_tmp.sk_peringatan
        WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 0, vr_nomor, '', 'I.T.B.26');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'A' AND old.status = 'E') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
        (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
        FROM sc_tmp.sk_peringatan
        WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 0, new.docnotmp, '', 'I.T.B.26');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'P' AND old.status = 'AP') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
        (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
        FROM sc_tmp.sk_peringatan
        WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 1, new.docnotmp, '', 'I.T.B.26');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'X' AND old.status = 'AP') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
        (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
        FROM sc_tmp.sk_peringatan
        WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 2, new.docnotmp, '', 'I.T.B.26');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    END IF;

    RETURN new;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_sk_peringatan()
  OWNER TO postgres;
