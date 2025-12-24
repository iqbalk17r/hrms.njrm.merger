-------------------------------------------------- SC_IM.PR_LOAD_NEW_DATA --------------------------------------------------
CREATE OR REPLACE FUNCTION sc_im.pr_load_new_data(vr_userid CHARACTER)
    RETURNS character AS
$BODY$
DECLARE
    vr_nik CHAR(12);
    vr_tglawal DATE;
BEGIN
-- sc_mst.option --
    /* delete */
    delete from sc_mst.option
    where kdoption || group_option not in (
        select kdoption || group_option
        from sc_im.option
    );

    /* if exist */
	update sc_mst.option a set
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
	from sc_im.option b
    where a.kdoption || a.group_option = b.kdoption || b.group_option;

	/* not exist */
	insert into sc_mst.option (
        select *
        from sc_im.option
        where kdoption || group_option not in (
            select kdoption || group_option
            from sc_mst.option
        )
    );
-- sc_mst.option --

    vr_tglawal:=to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date;

-- sc_mst.detail_formula --
    /* delete */
    delete from sc_mst.detail_formula
    where kdrumus || no_urut not in (
        select kdrumus || no_urut
        from sc_im.detail_formula
    );

    /* if exist */
	update sc_mst.detail_formula a set
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
	from sc_im.detail_formula b
    where a.kdrumus || a.no_urut = b.kdrumus || b.no_urut;

	/* not exist */
	insert into sc_mst.detail_formula (
        select *
        from sc_im.detail_formula
        where kdrumus || no_urut not in (
            select kdrumus || no_urut
            from sc_mst.detail_formula
        )
    );
-- sc_mst.detail_formula --

-- sc_mst.group_penggajian --
    /* delete */
    delete from sc_mst.group_penggajian
    where kdgroup_pg not in (
        select kdgroup_pg
        from sc_im.group_penggajian
    );

    /* if exist */
	update sc_mst.group_penggajian a set
        kdgroup_pg  = b.kdgroup_pg  ,
        nmgroup_pg  = b.nmgroup_pg  ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by
	from sc_im.group_penggajian b
    where a.kdgroup_pg = b.kdgroup_pg;

	/* not exist */
	insert into sc_mst.group_penggajian (
        select *
        from sc_im.group_penggajian
        where kdgroup_pg not in (
            select kdgroup_pg
            from sc_mst.group_penggajian
        )
    );
-- sc_mst.group_penggajian --

-- sc_mst.departmen --
    /* delete */
    delete from sc_mst.departmen
    where kddept not in (
        select kddept
        from sc_im.departmen
    );

    /* if exist */
	update sc_mst.departmen a set
        branch      = b.branch      ,
        kddept      = b.kddept      ,
        nmdept      = b.nmdept      ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by
	from sc_im.departmen b
    where a.kddept = b.kddept;

	/* not exist */
	insert into sc_mst.departmen (
        select *
        from sc_im.departmen
        where kddept not in (
            select kddept
            from sc_mst.departmen
        )
    );
-- sc_mst.departmen --

-- sc_mst.komponen_bpjs --
    /* delete */
    delete from sc_mst.komponen_bpjs
    where kode_bpjs || kodekomponen not in (
        select kode_bpjs || kodekomponen
        from sc_im.komponen_bpjs
    );

    /* if exist */
	update sc_mst.komponen_bpjs a set
        kode_bpjs           = b.kode_bpjs           ,
        kodekomponen        = b.kodekomponen        ,
        namakomponen        = b.namakomponen        ,
        besaranperusahaan   = b.besaranperusahaan   ,
        besarankaryawan     = b.besarankaryawan     ,
        totalbesaran        = b.totalbesaran
	from sc_im.komponen_bpjs b
    where a.kode_bpjs || a.kodekomponen = b.kode_bpjs || b.kodekomponen;

	/* not exist */
	insert into sc_mst.komponen_bpjs (
        select *
        from sc_im.komponen_bpjs
        where kode_bpjs || kodekomponen not in (
            select kode_bpjs || kodekomponen
            from sc_mst.komponen_bpjs
        )
    );
-- sc_mst.komponen_bpjs --

-- sc_mst.karyawan --
    /* delete */
    delete from sc_mst.karyawan
    where nik not in (
        select nik
        from sc_im.karyawan
    );

	/* if exist */
	update sc_mst.karyawan a set
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
        deviceid            = b.deviceid
	from sc_im.karyawan b
    where a.nik = b.nik;

	/* not exist */
	insert into sc_mst.karyawan (
        select *
        from sc_im.karyawan
        where nik not in (
            select nik
            from sc_mst.karyawan
        )
    );
-- sc_mst.karyawan --

-- sc_trx.status_kepegawaian --
    /* delete */
    delete from sc_trx.status_kepegawaian
    where nodok not in (
        select nodok
        from sc_im.status_kepegawaian
    );

    /* if exist */
    update sc_trx.status_kepegawaian a set
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
    from sc_im.status_kepegawaian b
    where a.nodok = b.nodok;

	/* not exist */
	insert into sc_trx.status_kepegawaian (
        select *
        from sc_im.status_kepegawaian
        where nodok not in (
            select nodok
            from sc_trx.status_kepegawaian
        )
    );
-- sc_trx.status_kepegawaian --

-- sc_trx.bpjs_karyawan --
    /* delete */
    delete from sc_trx.bpjs_karyawan
    where kode_bpjs || kodekomponen || nik not in (
        select kode_bpjs || kodekomponen || nik
        from sc_im.bpjs_karyawan
    );

    /* if exist */
    update sc_trx.bpjs_karyawan a set
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
    from sc_im.bpjs_karyawan b
    where a.kode_bpjs || a.kodekomponen || a.nik = b.kode_bpjs || b.kodekomponen || b.nik;

	/* not exist */
	insert into sc_trx.bpjs_karyawan (
        select *
        from sc_im.bpjs_karyawan
        where kode_bpjs || kodekomponen || nik not in (
            select kode_bpjs || kodekomponen || nik
            from sc_trx.bpjs_karyawan
        )
    );
-- sc_trx.bpjs_karyawan --

-- sc_trx.riwayat_keluarga --
    /* delete */
    delete from sc_trx.riwayat_keluarga
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_keluarga
    );

    /* if exist */
    update sc_trx.riwayat_keluarga a set
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
    from sc_im.riwayat_keluarga b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_keluarga (
        select *
        from sc_im.riwayat_keluarga
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_keluarga
        )
    );
-- sc_trx.riwayat_keluarga --

-- sc_trx.riwayat_kesehatan --
    /* delete */
    delete from sc_trx.riwayat_kesehatan
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_kesehatan
    );

    /* if exist */
    update sc_trx.riwayat_kesehatan a set
        nik         = b.nik         ,
        no_urut     = b.no_urut     ,
        kdpenyakit  = b.kdpenyakit  ,
        periode     = b.periode     ,
        keterangan  = b.keterangan  ,
        input_date  = b.input_date  ,
        input_by    = b.input_by    ,
        update_date = b.update_date ,
        update_by   = b.update_by
    from sc_im.riwayat_kesehatan b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_kesehatan (
        select *
        from sc_im.riwayat_kesehatan
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_kesehatan
        )
    );
-- sc_trx.riwayat_kesehatan --

-- sc_trx.riwayat_kompetensi --
    /* delete */
    delete from sc_trx.riwayat_kompetensi
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_kompetensi
    );

    /* if exist */
    update sc_trx.riwayat_kompetensi a set
        nik             = b.nik             ,
        no_urut         = b.no_urut         ,
        kdkom           = b.kdkom           ,
        lvl_indikator   = b.lvl_indikator   ,
        keterangan      = b.keterangan      ,
        input_date      = b.input_date      ,
        input_by        = b.input_by        ,
        update_date     = b.update_date     ,
        update_by       = b.update_by
    from sc_im.riwayat_kompetensi b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_kompetensi (
        select *
        from sc_im.riwayat_kompetensi
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_kompetensi
        )
    );
-- sc_trx.riwayat_kompetensi --

-- sc_trx.riwayat_pendidikan --
    /* delete */
    delete from sc_trx.riwayat_pendidikan
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_pendidikan
    );

    /* if exist */
    update sc_trx.riwayat_pendidikan a set
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
    from sc_im.riwayat_pendidikan b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_pendidikan (
        select *
        from sc_im.riwayat_pendidikan
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_pendidikan
        )
    );
-- sc_trx.riwayat_pendidikan --

-- sc_trx.riwayat_pendidikan_nf --
    /* delete */
    delete from sc_trx.riwayat_pendidikan_nf
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_pendidikan_nf
    );

    /* if exist */
    update sc_trx.riwayat_pendidikan_nf a set
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
    from sc_im.riwayat_pendidikan_nf b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_pendidikan_nf (
        select *
        from sc_im.riwayat_pendidikan_nf
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_pendidikan_nf
        )
    );
-- sc_trx.riwayat_pendidikan_nf --

-- sc_trx.riwayat_pengalaman --
    /* delete */
    delete from sc_trx.riwayat_pengalaman
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_pengalaman
    );

    /* if exist */
    update sc_trx.riwayat_pengalaman a set
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
    from sc_im.riwayat_pengalaman b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_pengalaman (
        select *
        from sc_im.riwayat_pengalaman
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_pengalaman
        )
    );
-- sc_trx.riwayat_pengalaman --

-- sc_trx.riwayat_rekam_medis --
    /* delete */
    delete from sc_trx.riwayat_rekam_medis
    where no_urut not in (
        select no_urut
        from sc_im.riwayat_rekam_medis
    );

    /* if exist */
    update sc_trx.riwayat_rekam_medis a set
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
    from sc_im.riwayat_rekam_medis b
    where a.no_urut = b.no_urut;

	/* not exist */
	insert into sc_trx.riwayat_rekam_medis (
        select *
        from sc_im.riwayat_rekam_medis
        where no_urut not in (
            select no_urut
            from sc_trx.riwayat_rekam_medis
        )
    );
-- sc_trx.riwayat_rekam_medis --

-- sc_tmp.cek_absen --
    /* delete */
    delete from sc_tmp.cek_absen
    where urut not in (
        select urut
        from sc_im.cek_absen
        where tgl_kerja >= vr_tglawal
    ) and tgl_kerja >= vr_tglawal;

    /* if exist */
    update sc_tmp.cek_absen a set
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
    from sc_im.cek_absen b
    where a.urut = b.urut and a.tgl_kerja >= vr_tglawal and b.tgl_kerja >= vr_tglawal;

	/* not exist */
	insert into sc_tmp.cek_absen (
        select nodok, nik, nodok_ref, tgl_nodok_ref, tgl_kerja, kdijin, kdtrx, nominal, 'I' AS status, keterangan, input_date, approval_date, input_by,
            approval_by, delete_by, cancel_by, update_date, delete_date, cancel_date, update_by, shiftke, flag_cuti, cuti_nominal, jam_masuk_absen, jam_pulang_absen,
            urut, gajipokok, periode_gaji, nikmap, nodoktmp
        from sc_im.cek_absen
        where urut not in (
            select urut
            from sc_tmp.cek_absen
            where tgl_kerja >= vr_tglawal
        ) and tgl_kerja >= vr_tglawal
    );
-- sc_tmp.cek_absen --

-- sc_tmp.cek_lembur --
    /* delete */
    delete from sc_tmp.cek_lembur
    where nik || nodok_ref not in (
        select nik || nodok_ref
        from sc_im.cek_lembur
        where tgl_kerja >= vr_tglawal
    ) and tgl_kerja >= vr_tglawal;

    /* if exist */
    update sc_tmp.cek_lembur a set
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
    from sc_im.cek_lembur b
    where a.nik || a.nodok_ref = b.nik || b.nodok_ref and a.tgl_kerja >= vr_tglawal and b.tgl_kerja >= vr_tglawal;

	/* not exist */
	insert into sc_tmp.cek_lembur (
        select nodok, nik, nodok_ref, tgl_nodok_ref, tplembur, tgl_kerja, jumlah_jam, jumlah_jam_absen, 'I' AS status, keterangan, input_date, approval_date,
            input_by, approval_by, delete_by, cancel_by, update_date, delete_date, cancel_date, update_by, nominal, kdjamkerja, tgl_jadwal, jenis_lembur,
            jam_mulai, jam_selesai, jam_mulai_absen, jam_selesai_absen, gajipokok, periode_gaji, nikmap, nodoktmp
        from sc_im.cek_lembur
        where nik || nodok_ref not in (
            select nik || nodok_ref
            from sc_tmp.cek_lembur
            where tgl_kerja >= vr_tglawal
        ) and tgl_kerja >= vr_tglawal
    );
-- sc_tmp.cek_lembur --

-- sc_tmp.cek_borong --
    /* delete */
    delete from sc_tmp.cek_borong
    where urut not in (
        select urut
        from sc_im.cek_borong
        where tgl_kerja >= vr_tglawal
    ) and tgl_kerja >= vr_tglawal;

    /* if exist */
    update sc_tmp.cek_borong a set
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
    from sc_im.cek_borong b
    where a.urut = b.urut and a.tgl_kerja >= vr_tglawal and b.tgl_kerja >= vr_tglawal;

	/* not exist */
	insert into sc_tmp.cek_borong (
        select *
        from sc_im.cek_borong
        where urut not in (
            select urut
            from sc_tmp.cek_borong
            where tgl_kerja >= vr_tglawal
        ) and tgl_kerja >= vr_tglawal
    );
-- sc_tmp.cek_borong --

-- sc_tmp.cek_shift --
    /* delete */
    delete from sc_tmp.cek_shift
    where urut not in (
        select urut
        from sc_im.cek_shift
        where tgl_kerja >= vr_tglawal
    ) and tgl_kerja >= vr_tglawal;

    /* if exist */
    update sc_tmp.cek_shift a set
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
    from sc_im.cek_shift b
    where a.urut = b.urut and a.tgl_kerja >= vr_tglawal and b.tgl_kerja >= vr_tglawal;

	/* not exist */
	insert into sc_tmp.cek_shift (
        select *
        from sc_im.cek_shift
        where urut not in (
            select urut
            from sc_tmp.cek_shift
            where tgl_kerja >= vr_tglawal
        ) and tgl_kerja >= vr_tglawal
    );
-- sc_tmp.cek_shift --

-- sc_trx.jadwalkerja --
    /* delete */
    delete from sc_trx.jadwalkerja
    where id not in (
        select id
        from sc_im.jadwalkerja
        where tgl >= vr_tglawal
    ) and tgl >= vr_tglawal;

    /* if exist */
    update sc_trx.jadwalkerja a set
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
    from sc_im.jadwalkerja b
    where a.id = b.id and a.tgl >= vr_tglawal and b.tgl >= vr_tglawal;

	/* not exist */
	insert into sc_trx.jadwalkerja (
        select *
        from sc_im.jadwalkerja
        where id not in (
            select id
            from sc_trx.jadwalkerja
            where tgl >= vr_tglawal
        ) and tgl >= vr_tglawal
    );
-- sc_trx.jadwalkerja --

-- sc_trx.transready --
    alter table sc_trx.transready disable trigger tr_transready_uangmkn;

    /* delete */
    delete from sc_trx.transready
    where id not in (
        select id
        from sc_im.transready
        where tgl >= vr_tglawal
    ) and tgl >= vr_tglawal;

    /* if exist */
    update sc_trx.transready a set
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
    from sc_im.transready b
    where a.id = b.id and a.tgl >= vr_tglawal and b.tgl >= vr_tglawal;

	/* not exist */
	insert into sc_trx.transready (
        select *
        from sc_im.transready
        where id not in (
            select id
            from sc_trx.transready
            where tgl >= vr_tglawal
        ) and tgl >= vr_tglawal
    );

	alter table sc_trx.transready enable trigger tr_transready_uangmkn;
-- sc_trx.transready --

-- sc_mst.m_lvlgp --
    /* delete */
    delete from sc_mst.m_lvlgp
    where kdlvlgp not in (
        select kdlvlgp
        from sc_im.m_lvlgp
    );

    /* if exist */
	update sc_mst.m_lvlgp a set
        branch      = b.branch      ,
        kdlvlgp     = b.kdlvlgp     ,
	    c_hold      = b.c_hold      ,
      --nominal     = b.nominal     ,
	    inputby     = b.inputby     ,
	    inputdate   = b.inputdate
	from sc_im.m_lvlgp b
    where a.kdlvlgp = b.kdlvlgp;

	/* not exist */
	insert into sc_mst.m_lvlgp (
        select *
        from sc_im.m_lvlgp
        where kdlvlgp not in (
            select kdlvlgp
            from sc_mst.m_lvlgp
        )
    );
-- sc_mst.m_lvlgp --

-- sc_mst.m_masakerja --
    /* delete */
    delete from sc_mst.m_masakerja
    where kdmasakerja not in (
        select kdmasakerja
        from sc_im.m_masakerja
    );

    /* if exist */
	update sc_mst.m_masakerja a set
        branch      = b.branch      ,
        kdmasakerja = b.kdmasakerja ,
	    nmmasakerja = b.nmmasakerja ,
	    awal        = b.awal        ,
	    akhir       = b.akhir       ,
	    c_hold      = b.c_hold      ,
      --nominal     = b.nominal     ,
	    inputby     = b.inputby     ,
	    inputdate   = b.inputdate
	from sc_im.m_masakerja b
    where a.kdmasakerja = b.kdmasakerja;

	/* not exist */
	insert into sc_mst.m_masakerja (
        select *
        from sc_im.m_masakerja where kdmasakerja not in (
            select kdmasakerja
            from sc_mst.m_masakerja
        )
    );
-- sc_mst.m_masakerja --

-- sc_mst.m_wilayah --
    /* delete */
    delete from sc_mst.m_wilayah
    where kdwilayah not in (
        select kdwilayah
        from sc_im.m_wilayah
    );

    /* if exist */
	update sc_mst.m_wilayah a set
        branch      = b.branch      ,
        kdwilayah   = b.kdwilayah   ,
        nmwilayah   = b.nmwilayah   ,
        c_hold      = b.c_hold      ,
        inputby     = b.inputby     ,
        inputdate   = b.inputdate
	from sc_im.m_wilayah b
    where a.kdwilayah = b.kdwilayah;

	/* not exist */
	insert into sc_mst.m_wilayah (
        select *
        from sc_im.m_wilayah
        where kdwilayah not in (
            select kdwilayah
            from sc_mst.m_wilayah
        )
    );
-- sc_mst.m_wilayah --

-- sc_mst.m_wilayah_nominal --
	alter table sc_mst.m_wilayah_nominal disable trigger tr_m_wilayah_nominal;

    /* delete */
    delete from sc_mst.m_wilayah_nominal
    where kdwilayahnominal not in (
        select kdwilayahnominal
        from sc_im.m_wilayah_nominal
    );

    /* if exist */
	update sc_mst.m_wilayah_nominal a set
        branch              = b.branch              ,
        kdwilayahnominal    = b.kdwilayahnominal    ,
        kdwilayah           = b.kdwilayah           ,
        nmwilayahnominal    = b.nmwilayahnominal    ,
        golongan            = b.golongan            ,
        c_hold              = b.c_hold              ,
      --nominal             = b.nominal             ,
        inputby             = b.inputby             ,
        inputdate           = b.inputdate
	from sc_im.m_wilayah_nominal b
    where a.kdwilayahnominal = b.kdwilayahnominal;

    /* not exist */
	insert into sc_mst.m_wilayah_nominal (
        select *
        from sc_im.m_wilayah_nominal
        where kdwilayahnominal not in (
            select kdwilayahnominal
            from sc_mst.m_wilayah_nominal
        )
    );

    alter table sc_mst.m_wilayah_nominal enable trigger tr_m_wilayah_nominal;
-- sc_mst.m_wilayah_nominal --

-- sc_mst.jobgrade --
    /* delete */
    delete from sc_mst.jobgrade
    where kdgrade not in (
        select kdgrade
        from sc_im.jobgrade
    );

    /* if exist */
	update sc_mst.jobgrade a set
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
	from sc_im.jobgrade b
    where a.kdgrade = b.kdgrade;

	/* not exist */
	insert into sc_mst.jobgrade (
        select *
        from sc_im.jobgrade
        where kdgrade not in (
            select kdgrade
            from sc_mst.jobgrade
        )
    );
-- sc_mst.jobgrade --

-- sc_mst.jabatan --
    /* delete */
    delete from sc_mst.jabatan
    where kdjabatan || kddept || kdsubdept not in (
        select kdjabatan || kddept || kdsubdept
        from sc_im.jabatan
    );

    /* if exist */
	update sc_mst.jabatan a set
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
	from sc_im.jabatan b
    where a.kdjabatan || a.kddept || a.kdsubdept = b.kdjabatan || b.kddept || b.kdsubdept;

	/* not exist */
	insert into sc_mst.jabatan (
        select *
        from sc_im.jabatan
        where kdjabatan || kddept || kdsubdept not in (
            select kdjabatan || kddept || kdsubdept
            from sc_mst.jabatan
        )
    );
-- sc_mst.jabatan --

	update sc_tmp.cek_lembur set nodok = vr_userid, status = 'P' where status = 'I';
	update sc_tmp.cek_borong set nodok = vr_userid;
	update sc_tmp.cek_shift  set nodok = vr_userid;
	update sc_tmp.cek_absen  set nodok = vr_userid, status = 'P' where status = 'I';

	RETURN vr_userid;
END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_im.pr_load_new_data(CHARACTER)
    OWNER TO postgres;
-------------------------------------------------- END OF: SC_IM.PR_LOAD_NEW_DATA --------------------------------------------------
