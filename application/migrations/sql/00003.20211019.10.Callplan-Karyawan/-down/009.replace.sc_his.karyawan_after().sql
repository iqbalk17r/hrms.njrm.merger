CREATE OR REPLACE FUNCTION sc_his.karyawan_after()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$

DECLARE
    vr_nik CHARACTER(30);
BEGIN
    vr_nik := COUNT(COALESCE(TRIM(nik), '')) FROM sc_mst.karyawan WHERE nik = trim(new.nik);

    if(vr_nik = '0') THEN
        INSERT INTO SC_MST.KARYAWAN SELECT * FROM SC_HIS.KARYAWAN WHERE NIK = NEW.NIK;
    END IF;

    IF(vr_nik > '0') THEN
        UPDATE SC_MST.KARYAWAN SET
            nmlengkap = new.nmlengkap,
            callname = new.callname,
            jk = new.jk,
            neglahir = new.neglahir,
            provlahir = new.provlahir,
            kotalahir = new.kotalahir,
            tgllahir = new.tgllahir,
            kd_agama = new.kd_agama,
            stswn = new.stswn,
            stsfisik = new.stsfisik,
            ketfisik = new.ketfisik,
            noktp = new.noktp,
            ktp_seumurhdp = new.ktp_seumurhdp,
            ktpdikeluarkan = new.ktpdikeluarkan,
            tgldikeluarkan = new.tgldikeluarkan,
            stastus_pernikahan = new.stastus_pernikahan,
            gol_darah = new.gol_darah,
            negktp = new.negktp,
            provktp = new.provktp,
            kotaktp = new.kotaktp,
            kecktp = new.kecktp,
            kelktp = new.kelktp,
            alamatktp = new.alamatktp,
            negtinggal = new.negtinggal,
            provtinggal = new.provtinggal,
            kotatinggal = new.kotatinggal,
            kectinggal = new.kectinggal,
            keltinggal = new.keltinggal,
            alamattinggal = new.alamattinggal,
            nohp1 = new.nohp1,
            nohp2 = new.nohp2,
            npwp = new.npwp,
            tglnpwp = new.tglnpwp,
            bag_dept = new.bag_dept,
            subbag_dept = new.subbag_dept,
            jabatan = new.jabatan,
            lvl_jabatan = new.lvl_jabatan,
            grade_golongan = new.grade_golongan,
            nik_atasan = new.nik_atasan,
            status_ptkp = new.status_ptkp,
            tglmasukkerja = new.tglmasukkerja,
            tglkeluarkerja = new.tglkeluarkerja,
            masakerja = new.masakerja,
            statuskepegawaian = new.statuskepegawaian,
            grouppenggajian = new.grouppenggajian,
            namabank = new.namabank,
            namapemilikrekening = new.namapemilikrekening,
            norek = new.norek,
            shift = new.shift,
            idabsen = new.idabsen,
            email = new.email,
            bolehcuti = new.bolehcuti,
            sisacuti = new.sisacuti,
            inputdate = new.inputdate,
            inputby = new.inputby,
            updatedate = new.updatedate,
            updateby = new.updateby,
            image = new.image,
            idmesin = new.idmesin,
            cardnumber = new.cardnumber,
            status = new.status,
            tgl_ktp = new.tgl_ktp,
            nik_atasan2 = new.nik_atasan2,
            costcenter = new.costcenter
        WHERE nik = new.nik;
    END IF;
    RETURN new;
END;
$BODY$;

ALTER FUNCTION sc_his.karyawan_after()
    OWNER TO postgres;
