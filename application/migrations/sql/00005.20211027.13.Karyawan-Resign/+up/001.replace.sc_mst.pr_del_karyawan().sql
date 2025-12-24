CREATE OR REPLACE FUNCTION sc_mst.pr_del_karyawan()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$

DECLARE
    -- Update By ARBI : 27/10/2021
    -- Hapus User
BEGIN
	IF(new.status = 'D') AND (old.status = '' OR old.status IS NULL) THEN
		INSERT INTO sc_his.karyawan_del (branch, nik, nmlengkap, callname, jk, neglahir, provlahir, kotalahir, tgllahir, kd_agama, stswn, stsfisik, ketfisik, noktp,
            ktp_seumurhdp, ktpdikeluarkan, tgldikeluarkan, status_pernikahan, gol_darah, negktp, provktp, kotaktp, kecktp, kelktp, alamatktp, negtinggal, provtinggal, kotatinggal,
            kectinggal, keltinggal, alamattinggal, nohp1, nohp2, npwp, tglnpwp, bag_dept, subbag_dept, jabatan, lvl_jabatan, grade_golongan, nik_atasan, nik_atasan2, status_ptkp,
            besaranptkp, tglmasukkerja, tglkeluarkerja, masakerja, statuskepegawaian, kdcabang, branchaktif, grouppenggajian, gajipokok, gajibpjs, namabank, namapemilikrekening,
            norek, tjshift, idabsen, email, bolehcuti, sisacuti, inputdate, inputby, updatedate, updateby, image, idmesin, cardnumber, status, tgl_ktp, costcenter, tj_tetap,
            gajitetap, gajinaker, tjlembur, tjborong, nokk, tgl_delete, delete_by, nokk, kdwilayahnominal, kdlvlgp, pinjaman, kdgradejabatan, deviceid, callplan)
        SELECT branch, nik, nmlengkap, callname, jk, neglahir, provlahir, kotalahir, tgllahir, kd_agama, stswn, stsfisik, ketfisik, noktp, ktp_seumurhdp, ktpdikeluarkan,
            tgldikeluarkan, status_pernikahan, gol_darah, negktp, provktp, kotaktp, kecktp, kelktp, alamatktp, negtinggal, provtinggal, kotatinggal, kectinggal, keltinggal,
            alamattinggal, nohp1, nohp2, npwp, tglnpwp, bag_dept, subbag_dept, jabatan, lvl_jabatan, grade_golongan, nik_atasan, nik_atasan2, status_ptkp, besaranptkp, tglmasukkerja,
            tglkeluarkerja, masakerja, statuskepegawaian, kdcabang, branchaktif, grouppenggajian, gajipokok, gajibpjs, namabank, namapemilikrekening, norek, tjshift, idabsen, email,
            bolehcuti, sisacuti, inputdate, inputby, updatedate, updateby, image, idmesin, cardnumber, status, tgl_ktp, costcenter, tj_tetap, gajitetap, gajinaker, tjlembur, tjborong,
            nokk, TO_TIMESTAMP(TO_CHAR(NOW(), 'YYYY-MM-DD HH:MI:SS'), 'YYYY-MM-DD HH:MI:SS'), updateby, nokk, kdwilayahnominal, kdlvlgp, pinjaman, kdgradejabatan, deviceid, callplan
        FROM sc_mst.karyawan
        WHERE nik = new.nik;

        DELETE FROM sc_mst.user WHERE nik = new.nik;
        DELETE FROM sc_mst.karyawan WHERE nik = new.nik;
        DELETE FROM sc_trx.riwayat_keluarga WHERE nik = new.nik;
        DELETE FROM sc_trx.riwayat_pengalaman WHERE nik = new.nik;
        DELETE FROM sc_trx.riwayat_pendidikan WHERE nik = new.nik;
        DELETE FROM sc_trx.bpjs_karyawan WHERE nik = new.nik;
        DELETE FROM sc_trx.riwayat_kesehatan WHERE nik = new.nik;
	END IF;
	RETURN new;
END;
$BODY$;

ALTER FUNCTION sc_mst.pr_del_karyawan()
    OWNER TO postgres;
