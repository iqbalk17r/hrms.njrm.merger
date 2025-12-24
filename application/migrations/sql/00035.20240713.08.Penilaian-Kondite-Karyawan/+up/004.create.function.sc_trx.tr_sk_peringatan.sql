-- Function: sc_trx.tr_sk_peringatan()

-- DROP FUNCTION sc_trx.tr_sk_peringatan();

CREATE OR REPLACE FUNCTION sc_trx.tr_sk_peringatan()
  RETURNS trigger AS
$BODY$
DECLARE
     vr_nomor CHAR(30);
     vr_lastdoc NUMERIC;
BEGIN
    IF(new.status = 'E' AND old.status = 'A') THEN
		INSERT INTO sc_tmp.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
		(SELECT new.updateby, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
		FROM sc_trx.sk_peringatan
		WHERE docno IS NOT NULL AND docno = new.docno);
    ELSEIF(new.status = 'AP' AND old.status = 'A') THEN
        INSERT INTO sc_tmp.sk_peringatan (docno, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate)
        (SELECT new.approveby, nik, docdate, status, startdate, enddate, tindakan, docref, description, solusi, att_name, att_dir,
            docnotmp, inputby, inputdate, updateby, updatedate, cancelby, canceldate, approveby, approvedate
        FROM sc_trx.sk_peringatan
        WHERE docno IS NOT NULL AND docno = new.docno);
    END IF;

    RETURN new;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_trx.tr_sk_peringatan()
  OWNER TO postgres;
