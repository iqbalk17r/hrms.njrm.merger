DROP VIEW IF EXISTS sc_mst.v_dtlgaji_karyawan;

CREATE OR REPLACE VIEW sc_mst.v_dtlgaji_karyawan AS
SELECT a.branch,
    a.nik,
    a.nmlengkap,
    a.callname,
    a.jk,
    a.neglahir,
    a.provlahir,
    a.kotalahir,
    a.tgllahir,
    a.kd_agama,
    a.stswn,
    a.stsfisik,
    a.ketfisik,
    a.noktp,
    a.ktp_seumurhdp,
    a.ktpdikeluarkan,
    a.tgldikeluarkan,
    a.status_pernikahan,
    a.gol_darah,
    a.negktp,
    a.provktp,
    a.kotaktp,
    a.kecktp,
    a.kelktp,
    a.alamatktp,
    a.negtinggal,
    a.provtinggal,
    a.kotatinggal,
    a.kectinggal,
    a.keltinggal,
    a.alamattinggal,
    a.nohp1,
    a.nohp2,
    a.npwp,
    a.tglnpwp,
    a.bag_dept,
    a.subbag_dept,
    a.jabatan,
    a.lvl_jabatan,
    a.grade_golongan,
    a.nik_atasan,
    a.nik_atasan2,
    a.status_ptkp,
    a.besaranptkp,
    a.tglmasukkerja,
    a.tglkeluarkerja,
    a.masakerja,
    a.statuskepegawaian,
    a.kdcabang,
    a.branchaktif,
    a.grouppenggajian,
    a.gajipokok,
    a.gajibpjs,
    a.namabank,
    a.namapemilikrekening,
    a.norek,
    a.tjshift,
    a.idabsen,
    a.email,
    a.bolehcuti,
    a.sisacuti,
    a.inputdate,
    a.inputby,
    a.updatedate,
    a.updateby,
    a.image,
    a.idmesin,
    a.cardnumber,
    a.status,
    a.tgl_ktp,
    a.costcenter,
    ROUND(a.tj_tetap) AS tj_tetap,
    ROUND(a.gajitetap) AS gajitetap,
    ROUND(a.gajinaker) AS gajinaker,
    a.tjlembur,
    a.tjborong,
    a.nokk,
    a.kdwilayahnominal,
    a.kdgradejabatan,
    b.gaji,
    b.tj_prestasi,
    b.tj_jabatan,
    b.tj_masakerja,
    b1.nmdept,
    c.nmsubdept,
    d.nmlvljabatan,
    e.nmjabatan,
    f.nmlengkap AS nmatasan,
    g.nmlengkap AS nmatasan2,
    TO_CHAR(ROUND(a.gajibpjs, 0), '999G999G999G990D'::TEXT) AS gajibpjs1,
    TO_CHAR(ROUND(a.gajinaker, 0), '999G999G999G990D'::TEXT) AS gajinaker1,
    h.nmwilayahnominal,
    i.kdlvlgp,
    j.nmgradejabatan
FROM sc_mst.karyawan a
LEFT JOIN (
    SELECT x.nik,
        TO_CHAR(ROUND(SUM(x.gaji), 0), '999G999G999G990D'::TEXT) AS gaji,
        TO_CHAR(ROUND(SUM(x.tj_prestasi), 0), '999G999G999G990D'::TEXT) AS tj_prestasi,
        TO_CHAR(ROUND(SUM(x.tj_jabatan), 0), '999G999G999G990D'::TEXT) AS tj_jabatan,
        TO_CHAR(ROUND(SUM(x.tj_masakerja), 0), '999G999G999G990D'::TEXT) AS tj_masakerja
    FROM (
        SELECT dtlgaji_karyawan.nik,
            dtlgaji_karyawan.nominal AS gaji,
            0.00 AS tj_prestasi,
            0.00 AS tj_jabatan,
            0.00 AS tj_masakerja
        FROM sc_mst.dtlgaji_karyawan
        WHERE dtlgaji_karyawan.no_urut = 1
        UNION ALL
        SELECT dtlgaji_karyawan.nik,
            0.00 AS gaji,
            dtlgaji_karyawan.nominal AS tj_prestasi,
            0.00 AS tj_jabatan,
            0.00 AS tj_masakerja
        FROM sc_mst.dtlgaji_karyawan
        WHERE dtlgaji_karyawan.no_urut = 9
        UNION ALL
        SELECT dtlgaji_karyawan.nik,
            0.00 AS gaji,
            0.00 AS tj_prestasi,
            dtlgaji_karyawan.nominal AS tj_jabatan,
            0.00 AS tj_masakerja
        FROM sc_mst.dtlgaji_karyawan
        WHERE dtlgaji_karyawan.no_urut = 7
        UNION ALL
        SELECT dtlgaji_karyawan.nik,
            0.00 AS gaji,
            0.00 AS tj_prestasi,
            0.00 AS tj_jabatan,
        dtlgaji_karyawan.nominal AS tj_masakerja
        FROM sc_mst.dtlgaji_karyawan
        WHERE dtlgaji_karyawan.no_urut = 8
    ) x
    GROUP BY x.nik
) b ON a.nik = b.nik
LEFT JOIN sc_mst.departmen b1 ON a.bag_dept = b1.kddept
LEFT JOIN sc_mst.subdepartmen c ON a.subbag_dept = c.kdsubdept AND c.kddept = a.bag_dept
LEFT JOIN sc_mst.lvljabatan d ON a.lvl_jabatan = d.kdlvl
LEFT JOIN sc_mst.jabatan e ON a.jabatan = e.kdjabatan AND e.kdsubdept = a.subbag_dept AND e.kddept = a.bag_dept
LEFT JOIN sc_mst.karyawan f ON a.nik_atasan = f.nik
LEFT JOIN sc_mst.karyawan g ON a.nik_atasan2 = g.nik
LEFT JOIN sc_mst.m_wilayah_nominal h ON a.kdwilayahnominal = h.kdwilayahnominal
LEFT JOIN sc_mst.m_lvlgp i ON a.kdlvlgp = i.kdlvlgp
LEFT JOIN sc_mst.m_grade_jabatan j ON a.kdgradejabatan = j.kdgradejabatan
WHERE COALESCE(a.statuskepegawaian, ''::BPCHAR) <> 'KO'::BPCHAR AND a.nik IS NOT NULL;

ALTER TABLE sc_mst.v_dtlgaji_karyawan
    OWNER TO postgres;
