CREATE OR REPLACE FUNCTION sc_trx.pr_stspeg_after()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$

DECLARE
    -- Created By FIKY : 28/04/2016
BEGIN
	IF(new.kdkepegawaian = 'KO') THEN --KELUAR KERJA
		UPDATE sc_mst.karyawan SET statuskepegawaian = new.kdkepegawaian, tglkeluarkerja = new.tgl_selesai WHERE nik = new.nik;

		DELETE FROM sc_mst.regu_opr WHERE nik = new.nik;
		DELETE FROM sc_trx.dtljadwalkerja WHERE nik = new.nik AND tgl > new.tgl_selesai;
		DELETE FROM sc_trx.uangmakan WHERE nik = new.nik AND tgl > new.tgl_selesai;
	ELSEIF(new.kdkepegawaian = 'HL') THEN --HARIAN LEPAS
		UPDATE sc_mst.karyawan SET statuskepegawaian = new.kdkepegawaian, tglkeluarkerja = NULL WHERE nik = new.nik;
	ELSEIF(new.kdkepegawaian = 'KK') THEN --KONTRAK
		UPDATE sc_mst.karyawan SET statuskepegawaian = new.kdkepegawaian, tglkeluarkerja = NULL WHERE nik = new.nik;
	ELSEIF(new.kdkepegawaian = 'KT') THEN --KARYAWAN TETAP
		UPDATE sc_mst.karyawan SET statuskepegawaian = new.kdkepegawaian, tglkeluarkerja = NULL WHERE nik = new.nik;
	ELSEIF(new.kdkepegawaian = 'MG') THEN --MAGANG
		UPDATE sc_mst.karyawan SET statuskepegawaian = new.kdkepegawaian, tglkeluarkerja = NULL WHERE nik = new.nik;
	ELSEIF(new.kdkepegawaian = 'KP') THEN --PENSIUN
		UPDATE sc_mst.karyawan SET statuskepegawaian = new.kdkepegawaian, tglkeluarkerja = NULL WHERE nik = new.nik;
	END IF;

	RETURN new;
END;
$BODY$;

ALTER FUNCTION sc_trx.pr_stspeg_after()
    OWNER TO postgres;
