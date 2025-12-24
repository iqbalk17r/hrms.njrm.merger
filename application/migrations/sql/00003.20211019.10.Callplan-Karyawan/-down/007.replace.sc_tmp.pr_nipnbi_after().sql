CREATE OR REPLACE FUNCTION sc_tmp.pr_nipnbi_after()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$

DECLARE
    -- Created By FIKY : 03/04/2016
    vr_idabsen CHAR(12);
    vr_nik CHAR(12);
    vr_nomor CHAR(12);
    vr_tglmasukkerja CHAR(4);
BEGIN
    vr_idabsen := TRIM(COALESCE(idabsen, '')) FROM sc_tmp.karyawan WHERE idabsen = new.idabsen AND nik = new.nik;
    vr_nik := TRIM(COALESCE(nik, '')) FROM sc_tmp.karyawan WHERE idabsen = new.idabsen AND nik = new.nik;

    DELETE FROM sc_mst.penomoran WHERE userid = vr_nik;
    DELETE FROM sc_mst.trxerror WHERE userid = vr_nik;

    INSERT INTO sc_mst.penomoran
    (userid, dokumen, nomor, errorid, partid, counterid, xno)
    VALUES (vr_nik, 'NIP-PEGAWAI', ' ', 0, ' ', 1, 0);

    vr_nomor := TRIM(COALESCE(nomor, '')) FROM sc_mst.penomoran WHERE userid = vr_nik;
    IF(TRIM(vr_nomor) != '') OR (NOT vr_nomor IS NULL) THEN
        INSERT INTO sc_mst.karyawan (branch, nik, nmlengkap, callname, jk, neglahir, provlahir, kotalahir, tgllahir, kd_agama, stswn, stsfisik, ketfisik, noktp, ktp_seumurhdp,
            ktpdikeluarkan, tgldikeluarkan, status_pernikahan, gol_darah, negktp, provktp, kotaktp, kecktp, kelktp, alamatktp, negtinggal, provtinggal, kotatinggal, kectinggal,
            keltinggal, alamattinggal, nohp1, nohp2, npwp, tglnpwp, bag_dept, subbag_dept, jabatan, lvl_jabatan, grade_golongan, nik_atasan, nik_atasan2, status_ptkp, besaranptkp,
            tglmasukkerja, tglkeluarkerja, masakerja, statuskepegawaian, kdcabang, branchaktif, grouppenggajian, gajipokok, gajibpjs, namabank, namapemilikrekening, norek, tjshift,
            idabsen, email, bolehcuti, sisacuti, inputdate, inputby, updatedate, updateby, image, idmesin, cardnumber, status, tgl_ktp, costcenter, tj_tetap, gajitetap, gajinaker,
            tjlembur, tjborong, nokk, kdwilayahnominal, kdlvlgp, pinjaman, kdgradejabatan, deviceid)
        SELECT branch, to_char(tglmasukkerja, 'MMYY') || '.' || vr_nomor AS nik, nmlengkap, callname, jk, neglahir, provlahir, kotalahir, tgllahir, kd_agama, stswn, stsfisik,
            ketfisik, noktp, ktp_seumurhdp, ktpdikeluarkan, tgldikeluarkan, status_pernikahan, gol_darah, negktp, provktp, kotaktp, kecktp, kelktp, alamatktp, negtinggal,
            provtinggal, kotatinggal, kectinggal, keltinggal, alamattinggal, nohp1, nohp2, npwp, tglnpwp, bag_dept, subbag_dept, jabatan, lvl_jabatan, grade_golongan, nik_atasan,
            nik_atasan2, status_ptkp, besaranptkp, tglmasukkerja, tglkeluarkerja, masakerja, statuskepegawaian, kdcabang, branchaktif, grouppenggajian, gajipokok, gajibpjs, namabank,
            namapemilikrekening, norek, tjshift, idabsen, email, bolehcuti, sisacuti, inputdate, inputby, updatedate, updateby, image, idmesin, cardnumber, status, tgl_ktp, costcenter,
            tj_tetap, gajitetap, gajinaker, tjlembur, tjborong, nokk, kdwilayahnominal, kdlvlgp, pinjaman, kdgradejabatan, deviceid
        FROM sc_tmp.karyawan
        WHERE nik = new.nik;

        DELETE FROM sc_tmp.karyawan WHERE nik = vr_nik;
        INSERT INTO sc_mst.trxerror
        (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (vr_nik, '0', vr_nomor, vr_nomor, 'KARYAWAN');
    ELSE
        INSERT INTO sc_mst.trxerror
        (userid, errorcode, nomorakhir1, nomorakhir2, modul)
        VALUES (vr_nik, '1', '', '', 'KARYAWAN');
    END IF;
    RETURN new;
END;
$BODY$;

ALTER FUNCTION sc_tmp.pr_nipnbi_after()
    OWNER TO postgres;
