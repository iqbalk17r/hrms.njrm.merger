CREATE OR REPLACE FUNCTION sc_tmp.pr_nipnbi_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE
    vr_nik_final    VARCHAR(30);
    vr_prefix       VARCHAR(20);
    vr_partid       VARCHAR(10);
    vr_dokumen      VARCHAR(20);
    vr_nomor        TEXT;
    v_exists        INTEGER;
	v_error_msg     TEXT;
BEGIN
    DELETE FROM sc_mst.trxerror WHERE userid = NEW.nik;

    BEGIN
        IF (NEW.tjborong = 't') THEN
            -- BORONG: tetap global
            vr_prefix  := TO_CHAR(NEW.tglmasukkerja, 'YY');
            vr_dokumen := 'NIP-BORONG';
            vr_partid  := '';
        ELSE
            -- PEGAWAI BIASA: per cabang
            vr_prefix  := TRIM(NEW.kdcabang) || '.' || TO_CHAR(NEW.tglmasukkerja, 'MMYY') || '.';
            vr_dokumen := 'NIP-PEGAWAI';
            vr_partid  := TRIM(NEW.idbu);
        END IF;

        -- KHUSUS PEGAWAI BIASA: Auto create setting di sc_mst.nomor jika belum ada
        IF (NEW.tjborong = 'f') THEN
            SELECT COUNT(*) INTO v_exists
            FROM sc_mst.nomor
            WHERE dokumen = vr_dokumen
              AND part = vr_partid;

            IF v_exists = 0 THEN
                INSERT INTO sc_mst.nomor (dokumen, part, docno, prefix, sufix, count3)
                VALUES (vr_dokumen, vr_partid, 0, '', '', 3);  -- mulai dari 0 → jadi 001
            END IF;
        END IF;

        DELETE FROM sc_mst.penomoran WHERE userid = NEW.nik;

        -- Insert ke penomoran → trigger pr_beri_nomor_after akan generate
        INSERT INTO sc_mst.penomoran (
            userid, dokumen, nomor, errorid, partid, counterid, xno
        ) VALUES (
            NEW.nik, vr_dokumen, ' ', 0, vr_partid, 1, 0
        );

        SELECT TRIM(nomor)
        INTO vr_nomor
        FROM sc_mst.penomoran
        WHERE userid = NEW.nik;

        IF vr_nomor IS NULL OR TRIM(vr_nomor) = '' THEN
            RAISE EXCEPTION 'Gagal generate nomor untuk dokumen=% partid=%', vr_dokumen, vr_partid;
        END IF;

        -- Format NIK akhir
        IF (NEW.tjborong = 't') THEN
            vr_nik_final := vr_prefix || vr_nomor;
        ELSE
            vr_nik_final := vr_prefix || vr_nomor;  -- sudah 3 digit dari trigger (001, 002, dst.)
        END IF;

        -- Insert ke master karyawan
        INSERT INTO sc_mst.karyawan (
            branch, nik, nmlengkap, callname, jk, neglahir, provlahir, kotalahir, tgllahir, kd_agama,
            stswn, stsfisik, ketfisik, noktp, ktp_seumurhdp, ktpdikeluarkan, tgldikeluarkan,
            status_pernikahan, gol_darah, negktp, provktp, kotaktp, kecktp, kelktp, alamatktp,
            negtinggal, provtinggal, kotatinggal, kectinggal, keltinggal, alamattinggal,
            nohp1, nohp2, npwp, tglnpwp, bag_dept, subbag_dept, jabatan, lvl_jabatan,
            grade_golongan, nik_atasan, nik_atasan2, status_ptkp, besaranptkp,
            tglmasukkerja, tglkeluarkerja, masakerja, statuskepegawaian, kdcabang,
            branchaktif, grouppenggajian, gajipokok, gajibpjs, namabank, namapemilikrekening,
            norek, tjshift, idabsen, email, bolehcuti, sisacuti, inputdate, inputby,
            updatedate, updateby, image, idmesin, cardnumber, status, tgl_ktp, costcenter,
            tj_tetap, gajitetap, gajinaker, tjlembur, tjborong, nokk, kdwilayahnominal,
            kdlvlgp, pinjaman, kdgradejabatan, deviceid, callplan, idbu
        )
        SELECT
            branch, vr_nik_final, nmlengkap, callname, jk, neglahir, provlahir, kotalahir, tgllahir, kd_agama,
            stswn, stsfisik, ketfisik, noktp, ktp_seumurhdp, ktpdikeluarkan, tgldikeluarkan,
            status_pernikahan, gol_darah, negktp, provktp, kotaktp, kecktp, kelktp, alamatktp,
            negtinggal, provtinggal, kotatinggal, kectinggal, keltinggal, alamattinggal,
            nohp1, nohp2, npwp, tglnpwp, bag_dept, subbag_dept, jabatan, lvl_jabatan,
            grade_golongan, nik_atasan, nik_atasan2, status_ptkp, besaranptkp,
            tglmasukkerja, tglkeluarkerja, masakerja, statuskepegawaian, kdcabang,
            branchaktif, grouppenggajian, gajipokok, gajibpjs, namabank, namapemilikrekening,
            norek, tjshift, idabsen, email, bolehcuti, sisacuti, inputdate, inputby,
            updatedate, updateby, image, idmesin, cardnumber, status, tgl_ktp, costcenter,
            tj_tetap, gajitetap, gajinaker, tjlembur, tjborong, nokk, kdwilayahnominal,
            kdlvlgp, pinjaman, kdgradejabatan, deviceid, callplan, idbu
        FROM sc_tmp.karyawan
        WHERE nik = NEW.nik;

        DELETE FROM sc_tmp.karyawan WHERE nik = NEW.nik;

        -- Log sukses
        INSERT INTO sc_mst.trxerror (
            userid, errorcode, nomorakhir1, nomorakhir2, modul, error_detail
        ) VALUES (
            NEW.nik, '0', vr_nomor, vr_nik_final, 'KARYAWAN',
            jsonb_build_object(
                'timestamp', CURRENT_TIMESTAMP,
                'status', 'success',
                'message', 'NIK berhasil digenerate (auto create counter per cabang)',
                'nik', vr_nik_final,
                'nomor_urut', vr_nomor,
                'kdcabang', NEW.kdcabang
            )
        );

    EXCEPTION WHEN OTHERS THEN
        GET STACKED DIAGNOSTICS v_error_msg = MESSAGE_TEXT;

        INSERT INTO sc_mst.trxerror (
            userid, errorcode, nomorakhir1, nomorakhir2, modul, error_detail
        ) VALUES (
            NEW.nik, '1', 'ERROR', '',
            'KARYAWAN',
            jsonb_build_object(
                'timestamp', CURRENT_TIMESTAMP,
                'status', 'error',
                'message', COALESCE(v_error_msg, 'Unknown error'),
                'dokumen', vr_dokumen,
                'partid', vr_partid
            )
        );

        RAISE;
    END;

    RETURN NEW;
END;
$function$;

alter table sc_mst.kantorwilayah 
add column idbu varchar(2)

alter table sc_tmp.karyawan
add column idbu varchar(2)