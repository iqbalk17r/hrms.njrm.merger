CREATE OR REPLACE FUNCTION sc_im.pr_load_new_data(vr_userid CHARACTER)
    RETURNS CHARACTER
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE
AS $BODY$

DECLARE
    -- Update By ARBI : 19/10/2021
    -- Tambahan Kolom "callplan" Pada Tabel "Karyawan"
    vr_nik CHAR(12);
    vr_tglawal DATE;
BEGIN
    -- sc_mst.option --
    /* DELETE */
    DELETE FROM sc_mst.option
    WHERE kdoption || group_option NOT IN (
        SELECT kdoption || group_option
        FROM sc_im.option
    );

    /* IF EXIST */
	UPDATE sc_mst.option a SET
        kdoption        = b.kdoption        ,
        nmoption        = b.nmoption        ,
        value1          = b.value1          ,
        value2          = b.value2          ,
        value3          = b.value3          ,
        status          = b.status          ,
        keterangan      = b.keterangan      ,
        input_by        = b.input_by        ,
        update_by       = b.update_by       ,
        input_date      = b.input_date      ,
        update_date     = b.update_date     ,
        group_option    = b.group_option
	FROM sc_im.option b
    WHERE a.kdoption || a.group_option = b.kdoption || b.group_option;

	/* NOT EXIST */
	INSERT INTO sc_mst.option (
        SELECT *
        FROM sc_im.option
        WHERE kdoption || group_option NOT IN (
            SELECT kdoption || group_option
            FROM sc_mst.option
        )
    );
    -- sc_mst.option --

    vr_tglawal := to_char(current_date - (SELECT value3 || ' month' FROM sc_mst.option WHERE kdoption = 'SEI')::interval, 'YYYY-MM-01')::DATE;

    -- sc_mst.detail_formula --
    /* DELETE */
    DELETE FROM sc_mst.detail_formula
    WHERE kdrumus || no_urut NOT IN (
        SELECT kdrumus || no_urut
        FROM sc_im.detail_formula
    );

    /* IF EXIST */
	UPDATE sc_mst.detail_formula a SET
        kdrumus     = b.kdrumus     ,
        no_urut     = b.no_urut     ,
        tipe        = b.tipe        ,
        keterangan  = b.keterangan  ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by   ,
        aksi_tipe   = b.aksi_tipe   ,
        aksi        = b.aksi        ,
        taxable     = b.taxable     ,
        tetap       = b.tetap       ,
        deductible  = b.deductible  ,
        regular     = b.regular     ,
        cash        = b.cash        ,
        kode        = b.kode
	FROM sc_im.detail_formula b
    WHERE a.kdrumus || a.no_urut = b.kdrumus || b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_mst.detail_formula (
        SELECT *
        FROM sc_im.detail_formula
        WHERE kdrumus || no_urut NOT IN (
            SELECT kdrumus || no_urut
            FROM sc_mst.detail_formula
        )
    );
    -- sc_mst.detail_formula --

    -- sc_mst.group_penggajian --
    /* DELETE */
    DELETE FROM sc_mst.group_penggajian
    WHERE kdgroup_pg NOT IN (
        SELECT kdgroup_pg
        FROM sc_im.group_penggajian
    );

    /* IF EXIST */
	UPDATE sc_mst.group_penggajian a SET
        kdgroup_pg  = b.kdgroup_pg  ,
        nmgroup_pg  = b.nmgroup_pg  ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by
	FROM sc_im.group_penggajian b
    WHERE a.kdgroup_pg = b.kdgroup_pg;

	/* NOT EXIST */
	INSERT INTO sc_mst.group_penggajian (
        SELECT *
        FROM sc_im.group_penggajian
        WHERE kdgroup_pg NOT IN (
            SELECT kdgroup_pg
            FROM sc_mst.group_penggajian
        )
    );
    -- sc_mst.group_penggajian --

    -- sc_mst.departmen --
    /* DELETE */
    DELETE FROM sc_mst.departmen
    WHERE kddept NOT IN (
        SELECT kddept
        FROM sc_im.departmen
    );

    /* IF EXIST */
	UPDATE sc_mst.departmen a SET
        branch      = b.branch      ,
        kddept      = b.kddept      ,
        nmdept      = b.nmdept      ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by
	FROM sc_im.departmen b
    WHERE a.kddept = b.kddept;

	/* NOT EXIST */
	INSERT INTO sc_mst.departmen (
        SELECT *
        FROM sc_im.departmen
        WHERE kddept NOT IN (
            SELECT kddept
            FROM sc_mst.departmen
        )
    );
    -- sc_mst.departmen --

    -- sc_mst.komponen_bpjs --
    /* DELETE */
    DELETE FROM sc_mst.komponen_bpjs
    WHERE kode_bpjs || kodekomponen NOT IN (
        SELECT kode_bpjs || kodekomponen
        FROM sc_im.komponen_bpjs
    );

    /* IF EXIST */
	UPDATE sc_mst.komponen_bpjs a SET
        kode_bpjs           = b.kode_bpjs           ,
        kodekomponen        = b.kodekomponen        ,
        namakomponen        = b.namakomponen        ,
        besaranperusahaan   = b.besaranperusahaan   ,
        besarankaryawan     = b.besarankaryawan     ,
        totalbesaran        = b.totalbesaran
	FROM sc_im.komponen_bpjs b
    WHERE a.kode_bpjs || a.kodekomponen = b.kode_bpjs || b.kodekomponen;

	/* NOT EXIST */
	INSERT INTO sc_mst.komponen_bpjs (
        SELECT *
        FROM sc_im.komponen_bpjs
        WHERE kode_bpjs || kodekomponen NOT IN (
            SELECT kode_bpjs || kodekomponen
            FROM sc_mst.komponen_bpjs
        )
    );
    -- sc_mst.komponen_bpjs --

    -- sc_mst.karyawan --
    /* DELETE */
    DELETE FROM sc_mst.karyawan
    WHERE nik NOT IN (
        SELECT nik
        FROM sc_im.karyawan
    );

	/* IF EXIST */
	UPDATE sc_mst.karyawan a SET
        branch              = b.branch              ,
        nik                 = b.nik                 ,
        nmlengkap           = b.nmlengkap           ,
        callname            = b.callname            ,
        jk                  = b.jk                  ,
        neglahir            = b.neglahir            ,
        provlahir           = b.provlahir           ,
        kotalahir           = b.kotalahir           ,
        tgllahir            = b.tgllahir            ,
        kd_agama            = b.kd_agama            ,
        stswn               = b.stswn               ,
        stsfisik            = b.stsfisik            ,
        ketfisik            = b.ketfisik            ,
        noktp               = b.noktp               ,
        ktp_seumurhdp       = b.ktp_seumurhdp       ,
        ktpdikeluarkan      = b.ktpdikeluarkan      ,
        tgldikeluarkan      = b.tgldikeluarkan      ,
        status_pernikahan   = b.status_pernikahan   ,
        gol_darah           = b.gol_darah           ,
        negktp              = b.negktp              ,
        provktp             = b.provktp             ,
        kotaktp             = b.kotaktp             ,
        kecktp              = b.kecktp              ,
        kelktp              = b.kelktp              ,
        alamatktp           = b.alamatktp           ,
        negtinggal          = b.negtinggal          ,
        provtinggal         = b.provtinggal         ,
        kotatinggal         = b.kotatinggal         ,
        kectinggal          = b.kectinggal          ,
        keltinggal          = b.keltinggal          ,
        alamattinggal       = b.alamattinggal       ,
        nohp1               = b.nohp1               ,
        nohp2               = b.nohp2               ,
        npwp                = b.npwp                ,
        tglnpwp             = b.tglnpwp             ,
        bag_dept            = b.bag_dept            ,
        subbag_dept         = b.subbag_dept         ,
        jabatan             = b.jabatan             ,
        lvl_jabatan         = b.lvl_jabatan         ,
        grade_golongan      = b.grade_golongan      ,
        nik_atasan          = b.nik_atasan          ,
        nik_atasan2         = b.nik_atasan2         ,
        status_ptkp         = b.status_ptkp         ,
        besaranptkp         = b.besaranptkp         ,
        tglmasukkerja       = b.tglmasukkerja       ,
        tglkeluarkerja      = b.tglkeluarkerja      ,
        masakerja           = b.masakerja           ,
        statuskepegawaian   = b.statuskepegawaian   ,
        kdcabang            = b.kdcabang            ,
        branchaktif         = b.branchaktif         ,
        grouppenggajian     = b.grouppenggajian     ,
      --gajipokok           = b.gajipokok           ,
      --gajibpjs            = b.gajibpjs            ,
        namabank            = b.namabank            ,
        namapemilikrekening = b.namapemilikrekening ,
        norek               = b.norek               ,
        tjshift             = b.tjshift             ,
        idabsen             = b.idabsen             ,
        email               = b.email               ,
        bolehcuti           = b.bolehcuti           ,
        sisacuti            = b.sisacuti            ,
        inputdate           = b.inputdate           ,
        inputby             = b.inputby             ,
        updatedate          = b.updatedate          ,
        updateby            = b.updateby            ,
        image               = b.image               ,
        idmesin             = b.idmesin             ,
        cardnumber          = b.cardnumber          ,
        status              = b.status              ,
        tgl_ktp             = b.tgl_ktp             ,
        costcenter          = b.costcenter          ,
      --tj_tetap            = b.tj_tetap            ,
      --gajitetap           = b.gajitetap           ,
      --gajinaker           = b.gajinaker           ,
      --tjlembur            = b.tjlembur            ,
      --tjborong            = b.tjborong            ,
        nokk                = b.nokk                ,
        kdwilayahnominal    = b.kdwilayahnominal    ,
        kdlvlgp             = b.kdlvlgp             ,
        pinjaman            = b.pinjaman            ,
        kdgradejabatan      = b.kdgradejabatan      ,
        deviceid            = b.deviceid            ,
        callplan            = b.callplan
	FROM sc_im.karyawan b
    WHERE a.nik = b.nik;

	/* NOT EXIST */
	INSERT INTO sc_mst.karyawan (
        SELECT *
        FROM sc_im.karyawan
        WHERE nik NOT IN (
            SELECT nik
            FROM sc_mst.karyawan
        )
    );
    -- sc_mst.karyawan --

    -- sc_trx.status_kepegawaian --
    /* DELETE */
    DELETE FROM sc_trx.status_kepegawaian
    WHERE nodok NOT IN (
        SELECT nodok
        FROM sc_im.status_kepegawaian
    );

    /* IF EXIST */
    UPDATE sc_trx.status_kepegawaian a SET
        nik             = b.nik             ,
        nodok           = b.nodok           ,
        kdkepegawaian   = b.kdkepegawaian   ,
        tgl_mulai       = b.tgl_mulai       ,
        tgl_selesai     = b.tgl_selesai     ,
        cuti            = b.cuti            ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by       ,
        nosk            = b.nosk            ,
        actremind       = b.actremind
    FROM sc_im.status_kepegawaian b
    WHERE a.nodok = b.nodok;

	/* NOT EXIST */
	INSERT INTO sc_trx.status_kepegawaian (
        SELECT *
        FROM sc_im.status_kepegawaian
        WHERE nodok NOT IN (
            SELECT nodok
            FROM sc_trx.status_kepegawaian
        )
    );
    -- sc_trx.status_kepegawaian --

    -- sc_trx.bpjs_karyawan --
    /* DELETE */
    DELETE FROM sc_trx.bpjs_karyawan
    WHERE kode_bpjs || kodekomponen || nik NOT IN (
        SELECT kode_bpjs || kodekomponen || nik
        FROM sc_im.bpjs_karyawan
    );

    /* IF EXIST */
    UPDATE sc_trx.bpjs_karyawan a SET
        kode_bpjs       = b.kode_bpjs       ,
        kodekomponen    = b.kodekomponen    ,
        kodefaskes      = b.kodefaskes      ,
        kodefaskes2     = b.kodefaskes2     ,
        nik             = b.nik             ,
        id_bpjs         = b.id_bpjs         ,
        tgl_berlaku     = b.tgl_berlaku     ,
        kelas           = b.kelas           ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    FROM sc_im.bpjs_karyawan b
    WHERE a.kode_bpjs || a.kodekomponen || a.nik = b.kode_bpjs || b.kodekomponen || b.nik;

	/* NOT EXIST */
	INSERT INTO sc_trx.bpjs_karyawan (
        SELECT *
        FROM sc_im.bpjs_karyawan
        WHERE kode_bpjs || kodekomponen || nik NOT IN (
            SELECT kode_bpjs || kodekomponen || nik
            FROM sc_trx.bpjs_karyawan
        )
    );
    -- sc_trx.bpjs_karyawan --
    
    -- sc_trx.riwayat_keluarga --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_keluarga
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_keluarga
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_keluarga a SET
        no_urut                 = b.no_urut                 ,
        kode_bpjs               = b.kode_bpjs               ,
        kodekomponen            = b.kodekomponen            ,
        kodefaskes              = b.kodefaskes              ,
        kodefaskes2             = b.kodefaskes2             ,
        nik                     = b.nik                     ,
        kdkeluarga              = b.kdkeluarga              ,
        kelamin                 = b.kelamin                 ,
        nama                    = b.nama                    ,
        tgl_lahir               = b.tgl_lahir               ,
        kodenegara              = b.kodenegara              ,
        kodeprov                = b.kodeprov                ,
        kodekotakab             = b.kodekotakab             ,
        pekerjaan               = b.pekerjaan               ,
        kdjenjang_pendidikan    = b.kdjenjang_pendidikan    ,
        status_hidup            = b.status_hidup            ,
        status_tanggungan       = b.status_tanggungan       ,
        no_npwp                 = b.no_npwp                 ,
        npwp_tgl                = b.npwp_tgl                ,
        id_bpjs                 = b.id_bpjs                 ,
        tgl_berlaku             = b.tgl_berlaku             ,
        kelas                   = b.kelas                   ,
        keterangan              = b.keterangan              ,
        input_date              = b.input_date              ,
        input_by                = b.input_by                ,
        update_date             = b.update_date             ,
        update_by               = b.update_by
    FROM sc_im.riwayat_keluarga b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_keluarga (
        SELECT *
        FROM sc_im.riwayat_keluarga
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_keluarga
        )
    );
    -- sc_trx.riwayat_keluarga --
    
    -- sc_trx.riwayat_kesehatan --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_kesehatan
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_kesehatan
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_kesehatan a SET
        nik         = b.nik         ,
        no_urut     = b.no_urut     ,
        kdpenyakit  = b.kdpenyakit  ,
        periode     = b.periode     ,
        keterangan  = b.keterangan  ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by
    FROM sc_im.riwayat_kesehatan b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_kesehatan (
        SELECT *
        FROM sc_im.riwayat_kesehatan
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_kesehatan
        )
    );
    -- sc_trx.riwayat_kesehatan --
    
    -- sc_trx.riwayat_kompetensi --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_kompetensi
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_kompetensi
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_kompetensi a SET
        nik             = b.nik             ,
        no_urut         = b.no_urut         ,
        kdkom           = b.kdkom           ,
        lvl_indikator   = b.lvl_indikator   ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    FROM sc_im.riwayat_kompetensi b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_kompetensi (
        SELECT *
        FROM sc_im.riwayat_kompetensi
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_kompetensi
        )
    );
    -- sc_trx.riwayat_kompetensi --
    
    -- sc_trx.riwayat_pendidikan --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_pendidikan
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_pendidikan
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_pendidikan a SET
        nik             = b.nik             ,
        no_urut         = b.no_urut         ,
        kdpendidikan    = b.kdpendidikan    ,
        nmsekolah       = b.nmsekolah       ,
        kotakab         = b.kotakab         ,
        jurusan         = b.jurusan         ,
        program_studi   = b.program_studi   ,
        tahun_masuk     = b.tahun_masuk     ,
        tahun_keluar    = b.tahun_keluar    ,
        nilai           = b.nilai           ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    FROM sc_im.riwayat_pendidikan b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_pendidikan (
        SELECT *
        FROM sc_im.riwayat_pendidikan
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_pendidikan
        )
    );
    -- sc_trx.riwayat_pendidikan --
    
    -- sc_trx.riwayat_pendidikan_nf --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_pendidikan_nf
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_pendidikan_nf
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_pendidikan_nf a SET
        nik             = b.nik             ,
        no_urut         = b.no_urut         ,
        kdkeahlian      = b.kdkeahlian      ,
        nmkursus        = b.nmkursus        ,
        nminstitusi     = b.nminstitusi     ,
        tahun_masuk     = b.tahun_masuk     ,
        tahun_keluar    = b.tahun_keluar    ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    FROM sc_im.riwayat_pendidikan_nf b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_pendidikan_nf (
        SELECT *
        FROM sc_im.riwayat_pendidikan_nf
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_pendidikan_nf
        )
    );
    -- sc_trx.riwayat_pendidikan_nf --
    
    -- sc_trx.riwayat_pengalaman --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_pengalaman
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_pengalaman
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_pengalaman a SET
        nik             = b.nik             ,
        no_urut         = b.no_urut         ,
        nmperusahaan    = b.nmperusahaan    ,
        bidang_usaha    = b.bidang_usaha    ,
        bagian          = b.bagian          ,
        jabatan         = b.jabatan         ,
        nmatasan        = b.nmatasan        ,
        jbtatasan       = b.jbtatasan       ,
        tahun_masuk     = b.tahun_masuk     ,
        tahun_keluar    = b.tahun_keluar    ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    FROM sc_im.riwayat_pengalaman b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_pengalaman (
        SELECT *
        FROM sc_im.riwayat_pengalaman
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_pengalaman
        )
    );
    -- sc_trx.riwayat_pengalaman --
    
    -- sc_trx.riwayat_rekam_medis --
    /* DELETE */
    DELETE FROM sc_trx.riwayat_rekam_medis
    WHERE no_urut NOT IN (
        SELECT no_urut
        FROM sc_im.riwayat_rekam_medis
    );

    /* IF EXIST */
    UPDATE sc_trx.riwayat_rekam_medis a SET
        nik             = b.nik             ,
        no_urut         = b.no_urut         ,
        kdrekam_medis   = b.kdrekam_medis   ,
        kdtipe          = b.kdtipe          ,
        kdlevel         = b.kdlevel         ,
        tgl_tes         = b.tgl_tes         ,
        tempat_periksa  = b.tempat_periksa  ,
        dokter_periksa  = b.dokter_periksa  ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    FROM sc_im.riwayat_rekam_medis b
    WHERE a.no_urut = b.no_urut;

	/* NOT EXIST */
	INSERT INTO sc_trx.riwayat_rekam_medis (
        SELECT *
        FROM sc_im.riwayat_rekam_medis
        WHERE no_urut NOT IN (
            SELECT no_urut
            FROM sc_trx.riwayat_rekam_medis
        )
    );
    -- sc_trx.riwayat_rekam_medis --
    
    -- sc_tmp.cek_absen --
    /* DELETE */
    DELETE FROM sc_tmp.cek_absen
    WHERE urut NOT IN (
        SELECT urut
        FROM sc_im.cek_absen
        WHERE tgl_kerja >= vr_tglawal
    ) AND tgl_kerja >= vr_tglawal;

    /* IF EXIST */
    UPDATE sc_tmp.cek_absen a SET
        nodok               = b.nodok               ,
        nik                 = b.nik                 ,
        nodok_ref           = b.nodok_ref           ,
        tgl_nodok_ref       = b.tgl_nodok_ref       ,
        tgl_kerja           = b.tgl_kerja           ,
        kdijin              = b.kdijin              ,
        kdtrx               = b.kdtrx               ,
        nominal             = b.nominal             ,
        status              = 'I'                   ,
        keterangan          = b.keterangan          ,
        input_date          = b.input_date          ,
        approval_date       = b.approval_date       ,
        input_by            = b.input_by            ,
        approval_by         = b.approval_by         ,
        delete_by           = b.delete_by           ,
        cancel_by           = b.cancel_by           ,
        update_date         = b.update_date         ,
        delete_date         = b.delete_date         ,
        cancel_date         = b.cancel_date         ,
        update_by           = b.update_by           ,
        shiftke             = b.shiftke             ,
        flag_cuti           = b.flag_cuti           ,
      --cuti_nominal        = b.cuti_nominal        ,
        jam_masuk_absen     = b.jam_masuk_absen     ,
        jam_pulang_absen    = b.jam_pulang_absen    ,
        urut                = b.urut                ,
      --gajipokok           = b.gajipokok           ,
        periode_gaji        = b.periode_gaji        ,
        nikmap              = b.nikmap              ,
        nodoktmp            = b.nodoktmp
    FROM sc_im.cek_absen b
    WHERE a.urut = b.urut AND a.tgl_kerja >= vr_tglawal AND b.tgl_kerja >= vr_tglawal;

	/* NOT EXIST */
	INSERT INTO sc_tmp.cek_absen (
        SELECT nodok, nik, nodok_ref, tgl_nodok_ref, tgl_kerja, kdijin, kdtrx, nominal, 'I' AS status, keterangan, input_date, approval_date, input_by,
            approval_by, delete_by, cancel_by, update_date, delete_date, cancel_date, update_by, shiftke, flag_cuti, cuti_nominal, jam_masuk_absen, jam_pulang_absen,
            urut, gajipokok, periode_gaji, nikmap, nodoktmp
        FROM sc_im.cek_absen
        WHERE urut NOT IN (
            SELECT urut
            FROM sc_tmp.cek_absen
            WHERE tgl_kerja >= vr_tglawal
        ) AND tgl_kerja >= vr_tglawal
    );
    -- sc_tmp.cek_absen --
    
    -- sc_tmp.cek_lembur --
    /* DELETE */
    DELETE FROM sc_tmp.cek_lembur
    WHERE nik || nodok_ref NOT IN (
        SELECT nik || nodok_ref
        FROM sc_im.cek_lembur
        WHERE tgl_kerja >= vr_tglawal
    ) AND tgl_kerja >= vr_tglawal;

    /* IF EXIST */
    UPDATE sc_tmp.cek_lembur a SET
        nodok               = b.nodok               ,
        nik                 = b.nik                 ,
        nodok_ref           = b.nodok_ref           ,
        tgl_nodok_ref       = b.tgl_nodok_ref       ,
        tplembur            = b.tplembur            ,
        tgl_kerja           = b.tgl_kerja           ,
        jumlah_jam          = b.jumlah_jam          ,
        jumlah_jam_absen    = b.jumlah_jam_absen    ,
        status              = 'I'                   ,
        keterangan          = b.keterangan          ,
        input_date          = b.input_date          ,
        approval_date       = b.approval_date       ,
        input_by            = b.input_by            ,
        approval_by         = b.approval_by         ,
        delete_by           = b.delete_by           ,
        cancel_by           = b.cancel_by           ,
        update_date         = b.update_date         ,
        delete_date         = b.delete_date         ,
        cancel_date         = b.cancel_date         ,
        update_by           = b.update_by           ,
      --nominal             = b.nominal             ,
        kdjamkerja          = b.kdjamkerja          ,
        tgl_jadwal          = b.tgl_jadwal          ,
        jenis_lembur        = b.jenis_lembur        ,
        jam_mulai           = b.jam_mulai           ,
        jam_selesai         = b.jam_selesai         ,
        jam_mulai_absen     = b.jam_mulai_absen     ,
        jam_selesai_absen   = b.jam_selesai_absen   ,
        gajipokok           = b.gajipokok           ,
        periode_gaji        = b.periode_gaji        ,
        nikmap              = b.nikmap              ,
        nodoktmp            = b.nodoktmp
    FROM sc_im.cek_lembur b
    WHERE a.nik || a.nodok_ref = b.nik || b.nodok_ref AND a.tgl_kerja >= vr_tglawal AND b.tgl_kerja >= vr_tglawal;

	/* NOT EXIST */
	INSERT INTO sc_tmp.cek_lembur (
        SELECT nodok, nik, nodok_ref, tgl_nodok_ref, tplembur, tgl_kerja, jumlah_jam, jumlah_jam_absen, 'I' AS status, keterangan, input_date, approval_date,
            input_by, approval_by, delete_by, cancel_by, update_date, delete_date, cancel_date, update_by, nominal, kdjamkerja, tgl_jadwal, jenis_lembur,
            jam_mulai, jam_selesai, jam_mulai_absen, jam_selesai_absen, gajipokok, periode_gaji, nikmap, nodoktmp
        FROM sc_im.cek_lembur
        WHERE nik || nodok_ref NOT IN (
            SELECT nik || nodok_ref
            FROM sc_tmp.cek_lembur
            WHERE tgl_kerja >= vr_tglawal
        ) AND tgl_kerja >= vr_tglawal
    );
    -- sc_tmp.cek_lembur --
    
    -- sc_tmp.cek_borong --
    /* DELETE */
    DELETE FROM sc_tmp.cek_borong
    WHERE urut NOT IN (
        SELECT urut
        FROM sc_im.cek_borong
        WHERE tgl_kerja >= vr_tglawal
    ) AND tgl_kerja >= vr_tglawal;

    /* IF EXIST */
    UPDATE sc_tmp.cek_borong a SET
        nodok           = b.nodok           ,
        nik             = b.nik             ,
        nodok_ref       = b.nodok_ref       ,
        tgl_dok         = b.tgl_dok         ,
        periode         = b.periode         ,
        tgl_kerja       = b.tgl_kerja       ,
        total_upah      = b.total_upah      ,
        status          = b.status          ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        approval_date   = b.approval_date   ,
        input_by        = b.input_by        ,
        approval_by     = b.approval_by     ,
        delete_by       = b.delete_by       ,
        cancel_by       = b.cancel_by       ,
        update_date     = b.update_date     ,
        delete_date     = b.delete_date     ,
        cancel_date     = b.cancel_date     ,
        update_by       = b.update_by       ,
        urut            = b.urut            ,
        nodoktmp        = b.nodoktmp
    FROM sc_im.cek_borong b
    WHERE a.urut = b.urut AND a.tgl_kerja >= vr_tglawal AND b.tgl_kerja >= vr_tglawal;

	/* NOT EXIST */
	INSERT INTO sc_tmp.cek_borong (
        SELECT *
        FROM sc_im.cek_borong
        WHERE urut NOT IN (
            SELECT urut
            FROM sc_tmp.cek_borong
            WHERE tgl_kerja >= vr_tglawal
        ) AND tgl_kerja >= vr_tglawal
    );
    -- sc_tmp.cek_borong --
    
    -- sc_tmp.cek_shift --
    /* DELETE */
    DELETE FROM sc_tmp.cek_shift
    WHERE urut NOT IN (
        SELECT urut
        FROM sc_im.cek_shift
        WHERE tgl_kerja >= vr_tglawal
    ) AND tgl_kerja >= vr_tglawal;

    /* IF EXIST */
    UPDATE sc_tmp.cek_shift a SET
        nodok               = b.nodok               ,
        nik                 = b.nik                 ,
        tpshift             = b.tpshift             ,
        tgl_kerja           = b.tgl_kerja           ,
        kdjam_kerja         = b.kdjam_kerja         ,
        jam_mulai           = b.jam_mulai           ,
        jam_selesai         = b.jam_selesai         ,
        jam_mulai_absen     = b.jam_mulai_absen     ,
        jam_selesai_absen   = b.jam_selesai_absen   ,
        status              = b.status              ,
        keterangan          = b.keterangan          ,
        input_date          = b.input_date          ,
        approval_date       = b.approval_date       ,
        input_by            = b.input_by            ,
        approval_by         = b.approval_by         ,
        delete_by           = b.delete_by           ,
        cancel_by           = b.cancel_by           ,
        update_date         = b.update_date         ,
        delete_date         = b.delete_date         ,
        cancel_date         = b.cancel_date         ,
        update_by           = b.update_by           ,
        nominal             = b.nominal             ,
        urut                = b.urut                ,
        nodoktmp            = b.nodoktmp
    FROM sc_im.cek_shift b
    WHERE a.urut = b.urut AND a.tgl_kerja >= vr_tglawal AND b.tgl_kerja >= vr_tglawal;

	/* NOT EXIST */
	INSERT INTO sc_tmp.cek_shift (
        SELECT *
        FROM sc_im.cek_shift
        WHERE urut NOT IN (
            SELECT urut
            FROM sc_tmp.cek_shift
            WHERE tgl_kerja >= vr_tglawal
        ) AND tgl_kerja >= vr_tglawal
    );
    -- sc_tmp.cek_shift --

    -- sc_trx.jadwalkerja --
    /* DELETE */
    DELETE FROM sc_trx.jadwalkerja
    WHERE id NOT IN (
        SELECT id
        FROM sc_im.jadwalkerja
        WHERE tgl >= vr_tglawal
    ) AND tgl >= vr_tglawal;

    /* IF EXIST */
    UPDATE sc_trx.jadwalkerja a SET
        shift_tipe      = b.shift_tipe      ,
        nik             = b.nik             ,
        kdregu          = b.kdregu          ,
        kodejamkerja    = b.kodejamkerja    ,
        inputdate       = b.inputdate       ,
        inputby         = b.inputby         ,
        updatedate      = b.updatedate      ,
        updateby        = b.updateby        ,
        id              = b.id              ,
        tgl             = b.tgl
    FROM sc_im.jadwalkerja b
    WHERE a.id = b.id AND a.tgl >= vr_tglawal AND b.tgl >= vr_tglawal;

	/* NOT EXIST */
	INSERT INTO sc_trx.jadwalkerja (
        SELECT *
        FROM sc_im.jadwalkerja
        WHERE id NOT IN (
            SELECT id
            FROM sc_trx.jadwalkerja
            WHERE tgl >= vr_tglawal
        ) AND tgl >= vr_tglawal
    );
    -- sc_trx.jadwalkerja --

    -- sc_trx.transready --
    ALTER TABLE sc_trx.transready DISABLE trigger tr_transready_uangmkn;

    /* DELETE */
    DELETE FROM sc_trx.transready
    WHERE id NOT IN (
        SELECT id
        FROM sc_im.transready
        WHERE tgl >= vr_tglawal
    ) AND tgl >= vr_tglawal;

    /* IF EXIST */
    UPDATE sc_trx.transready a SET
        userid              = b.userid              ,
        badgenumber         = b.badgenumber         ,
        editan              = b.editan              ,
        id                  = b.id                  ,
        nik                 = b.nik                 ,
        tgl                 = b.tgl                 ,
        kdjamkerja          = b.kdjamkerja          ,
        kdregu              = b.kdregu              ,
        shift               = b.shift               ,
        shiftke             = b.shiftke             ,
        jam_masuk           = b.jam_masuk           ,
        jam_masuk_min       = b.jam_masuk_min       ,
        jam_masuk_max       = b.jam_masuk_max       ,
        jam_pulang          = b.jam_pulang          ,
        jam_pulang_min      = b.jam_pulang_min      ,
        jam_pulang_max      = b.jam_pulang_max      ,
        keterangan          = b.keterangan          ,
        status              = b.status              ,
        kdhari_masuk        = b.kdhari_masuk        ,
        kdhari_pulang       = b.kdhari_pulang       ,
        jam_masuk_absen     = b.jam_masuk_absen     ,
        jam_pulang_absen    = b.jam_pulang_absen
    FROM sc_im.transready b
    WHERE a.id = b.id AND a.tgl >= vr_tglawal AND b.tgl >= vr_tglawal;

	/* NOT EXIST */
	INSERT INTO sc_trx.transready (
        SELECT *
        FROM sc_im.transready
        WHERE id NOT IN (
            SELECT id
            FROM sc_trx.transready
            WHERE tgl >= vr_tglawal
        ) AND tgl >= vr_tglawal
    );

	ALTER TABLE sc_trx.transready ENABLE trigger tr_transready_uangmkn;
    -- sc_trx.transready --

    -- sc_mst.m_lvlgp --
    /* DELETE */
    DELETE FROM sc_mst.m_lvlgp
    WHERE kdlvlgp NOT IN (
        SELECT kdlvlgp
        FROM sc_im.m_lvlgp
    );

    /* IF EXIST */
	UPDATE sc_mst.m_lvlgp a SET
        branch      = b.branch      ,
        kdlvlgp     = b.kdlvlgp     ,
	    c_hold      = b.c_hold      ,
      --nominal     = b.nominal     ,
	    inputby     = b.inputby     ,
	    inputdate   = b.inputdate
	FROM sc_im.m_lvlgp b
    WHERE a.kdlvlgp = b.kdlvlgp;

	/* NOT EXIST */
	INSERT INTO sc_mst.m_lvlgp (
        SELECT *
        FROM sc_im.m_lvlgp
        WHERE kdlvlgp NOT IN (
            SELECT kdlvlgp
            FROM sc_mst.m_lvlgp
        )
    );
-- sc_mst.m_lvlgp --

-- sc_mst.m_masakerja --
    /* DELETE */
    DELETE FROM sc_mst.m_masakerja
    WHERE kdmasakerja NOT IN (
        SELECT kdmasakerja
        FROM sc_im.m_masakerja
    );

    /* IF EXIST */
	UPDATE sc_mst.m_masakerja a SET
        branch      = b.branch      ,
        kdmasakerja = b.kdmasakerja ,
	    nmmasakerja = b.nmmasakerja ,
	    awal        = b.awal        ,
	    akhir       = b.akhir       ,
	    c_hold      = b.c_hold      ,
      --nominal     = b.nominal     ,
	    inputby     = b.inputby     ,
	    inputdate   = b.inputdate
	FROM sc_im.m_masakerja b
    WHERE a.kdmasakerja = b.kdmasakerja;

	/* NOT EXIST */
	INSERT INTO sc_mst.m_masakerja (
        SELECT *
        FROM sc_im.m_masakerja WHERE kdmasakerja NOT IN (
            SELECT kdmasakerja
            FROM sc_mst.m_masakerja
        )
    );
    -- sc_mst.m_masakerja --

    -- sc_mst.m_wilayah --
    /* DELETE */
    DELETE FROM sc_mst.m_wilayah
    WHERE kdwilayah NOT IN (
        SELECT kdwilayah
        FROM sc_im.m_wilayah
    );

    /* IF EXIST */
	UPDATE sc_mst.m_wilayah a SET
        branch      = b.branch      ,
        kdwilayah   = b.kdwilayah   ,
        nmwilayah   = b.nmwilayah   ,
        c_hold      = b.c_hold      ,
        inputby     = b.inputby     ,
        inputdate   = b.inputdate
	FROM sc_im.m_wilayah b
    WHERE a.kdwilayah = b.kdwilayah;

	/* NOT EXIST */
	INSERT INTO sc_mst.m_wilayah (
        SELECT *
        FROM sc_im.m_wilayah
        WHERE kdwilayah NOT IN (
            SELECT kdwilayah
            FROM sc_mst.m_wilayah
        )
    );
    -- sc_mst.m_wilayah --

    -- sc_mst.m_wilayah_nominal --
	ALTER TABLE sc_mst.m_wilayah_nominal DISABLE trigger tr_m_wilayah_nominal;

    /* DELETE */
    DELETE FROM sc_mst.m_wilayah_nominal
    WHERE kdwilayahnominal NOT IN (
        SELECT kdwilayahnominal
        FROM sc_im.m_wilayah_nominal
    );

    /* IF EXIST */
	UPDATE sc_mst.m_wilayah_nominal a SET
        branch              = b.branch              ,
        kdwilayahnominal    = b.kdwilayahnominal    ,
        kdwilayah           = b.kdwilayah           ,
        nmwilayahnominal    = b.nmwilayahnominal    ,
        golongan            = b.golongan            ,
        c_hold              = b.c_hold              ,
      --nominal             = b.nominal             ,
        inputby             = b.inputby             ,
        inputdate           = b.inputdate
	FROM sc_im.m_wilayah_nominal b
    WHERE a.kdwilayahnominal = b.kdwilayahnominal;

    /* NOT EXIST */
	INSERT INTO sc_mst.m_wilayah_nominal (
        SELECT *
        FROM sc_im.m_wilayah_nominal
        WHERE kdwilayahnominal NOT IN (
            SELECT kdwilayahnominal
            FROM sc_mst.m_wilayah_nominal
        )
    );

    ALTER TABLE sc_mst.m_wilayah_nominal ENABLE trigger tr_m_wilayah_nominal;
    -- sc_mst.m_wilayah_nominal --

    -- sc_mst.jobgrade --
    /* DELETE */
    DELETE FROM sc_mst.jobgrade
    WHERE kdgrade NOT IN (
        SELECT kdgrade
        FROM sc_im.jobgrade
    );

    /* IF EXIST */
	UPDATE sc_mst.jobgrade a SET
        kdgrade     = b.kdgrade     ,
        nmgrade     = b.nmgrade     ,
        golongan    = b.golongan    ,
        bobot1      = b.bobot1      ,
        bobot2      = b.bobot2      ,
        keterangan  = b.keterangan  ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by   ,
        kdlvl       = b.kdlvl       ,
        kdlvlgpmin  = b.kdlvlgpmin  ,
        kdlvlgpmax  = b.kdlvlgpmax
	FROM sc_im.jobgrade b
    WHERE a.kdgrade = b.kdgrade;

	/* NOT EXIST */
	INSERT INTO sc_mst.jobgrade (
        SELECT *
        FROM sc_im.jobgrade
        WHERE kdgrade NOT IN (
            SELECT kdgrade
            FROM sc_mst.jobgrade
        )
    );
    -- sc_mst.jobgrade --

    -- sc_mst.jabatan --
    /* DELETE */
    DELETE FROM sc_mst.jabatan
    WHERE kdjabatan || kddept || kdsubdept NOT IN (
        SELECT kdjabatan || kddept || kdsubdept
        FROM sc_im.jabatan
    );

    /* IF EXIST */
	UPDATE sc_mst.jabatan a SET
        branch      = b.branch      ,
        kdjabatan   = b.kdjabatan   ,
        nmjabatan   = b.nmjabatan   ,
        kddept      = b.kddept      ,
        kdsubdept   = b.kdsubdept   ,
        kdgrade     = b.kdgrade     ,
        costcenter  = b.costcenter  ,
        uraian      = b.uraian      ,
        shift       = b.shift       ,
        lembur      = b.lembur      ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by   ,
        kdlvl       = b.kdlvl     --,
      --nominal     = b.nominal
	FROM sc_im.jabatan b
    WHERE a.kdjabatan || a.kddept || a.kdsubdept = b.kdjabatan || b.kddept || b.kdsubdept;

	/* NOT EXIST */
	INSERT INTO sc_mst.jabatan (
        SELECT *
        FROM sc_im.jabatan
        WHERE kdjabatan || kddept || kdsubdept NOT IN (
            SELECT kdjabatan || kddept || kdsubdept
            FROM sc_mst.jabatan
        )
    );
    -- sc_mst.jabatan --

	UPDATE sc_tmp.cek_lembur SET nodok = vr_userid, status = 'P' WHERE status = 'I';
	UPDATE sc_tmp.cek_borong SET nodok = vr_userid;
	UPDATE sc_tmp.cek_shift  SET nodok = vr_userid;
	UPDATE sc_tmp.cek_absen  SET nodok = vr_userid, status = 'P' WHERE status = 'I';

	RETURN vr_userid;
END;
$BODY$;

ALTER FUNCTION sc_im.pr_load_new_data(CHARACTER)
    OWNER TO postgres;
