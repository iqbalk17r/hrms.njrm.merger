CREATE OR REPLACE FUNCTION sc_tmp.tr_sk_peringatan()
RETURNS trigger
LANGUAGE plpgsql
AS $function$
DECLARE
    vr_lastdoc NUMERIC;
    vr_nomor TEXT;
BEGIN
    IF (new.status = 'B' AND old.status = 'I') THEN
        -- Hitung nomor urut terakhir
        vr_lastdoc := COALESCE(MAX(
                            CASE
                                WHEN SUBSTRING(docno FROM '^(\d{3})/SP/HRD/NUSA/\d{4}\.\d{2}$') IS NOT NULL
                                THEN CAST(SUBSTRING(docno FROM '^(\d{3})/SP/HRD/NUSA/\d{4}\.\d{2}$') AS NUMERIC)
                                ELSE NULL
                            END
                        ), 0) + 1
                      FROM sc_trx.sk_peringatan
                      WHERE TO_CHAR(docdate, 'YYYYMM') = TO_CHAR(new.docdate, 'YYYYMM');

        -- Buat format nomor
        vr_nomor := LPAD(vr_lastdoc::TEXT, 3, '0') || '/SP/HRD/NUSA/' || TO_CHAR(new.docdate, 'YYYY') || '.' || TO_CHAR(new.docdate, 'MM');

        -- Gunakan nomor yang sudah dibuat ke semua tempat
        INSERT INTO sc_trx.sk_peringatan (
            docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, 
            att_name, att_dir, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
        SELECT vr_nomor, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, 
               att_name, att_dir, docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
        FROM sc_tmp.sk_peringatan
        WHERE docno IS NOT NULL AND docno = new.docno;

        -- Bersihkan dan simpan log error
        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 0, vr_nomor, '', 'I.T.B.27');

        -- Hapus data sementara
        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    -- Kasus untuk status baru 'A' dan status lama 'E'
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
        VALUES (new.docno, 0, new.docnotmp, '', 'I.T.B.27');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'B' AND old.status = 'EB') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                                          docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
            (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                    NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
             FROM sc_tmp.sk_peringatan
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 0, new.docnotmp, '', 'I.T.B.27');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'B' AND old.status = 'AP') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                                          docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
            (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                    NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
             FROM sc_tmp.sk_peringatan
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 1, new.docnotmp, '', 'I.T.B.27');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    ELSEIF(new.status = 'P' AND old.status = 'BP') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                                          docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
            (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                    NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
             FROM sc_tmp.sk_peringatan
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 1, new.docnotmp, '', 'I.T.B.27');

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
        VALUES (new.docno, 2, new.docnotmp, '', 'I.T.B.27');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
     ELSEIF(new.status = 'X' AND old.status = 'BP') THEN
        DELETE FROM sc_trx.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docnotmp;

        INSERT INTO sc_trx.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                                          docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
            (SELECT new.docnotmp, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
                    NULL AS docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
             FROM sc_tmp.sk_peringatan
             WHERE docno IS NOT NULL AND docno = new.docno);

        DELETE FROM sc_mst.trxerror WHERE userid = new.docno;

        INSERT INTO sc_mst.trxerror (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (new.docno, 2, new.docnotmp, '', 'I.T.B.27');

        DELETE FROM sc_tmp.sk_peringatan WHERE docno IS NOT NULL AND docno = new.docno;
    END IF;

    RETURN new;
END;
$function$;