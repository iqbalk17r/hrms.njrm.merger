<?php
class M_import extends CI_Model{
	function q_option(){
		return $this->db->query("select status,
									case 
									when status='T' then 'AKTIF' 
									when status='F' then 'TIDAK AKTIF'
									end as status1,
									* from sc_mst.option order by kdoption asc
									 ");
	}

	function q_cekoption($kdoption){
		return $this->db->query("select * from sc_mst.option where trim(kdoption)='$kdoption'");
	}
	///export csv ///
	function e_exportcsv(){
		return $this->db->query("select * from exportcsv order by nodok asc");
	}

	function e_exportcsvmst(){
		return $this->db->query("select * from exportcsv order by nodok asc");
	}

	function e_cek_patch($nodokdir){
		return $this->db->query("select * from exportcsv where nodok='$nodokdir'");
	}

	function e_csvcek_absen($date,$patch){
		return $this->db->query("drop table if exists sc_im.cek_absen;
								select * into sc_im.cek_absen from sc_tmp.cek_absen $date;
								/*insert into sc_im.cek_absen select * from sc_tmp.cek_absen $date;*/
								copy  sc_im.cek_absen to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvcek_borong($date,$patch){
		return $this->db->query("drop table if exists sc_im.cek_borong;
									select * into sc_im.cek_borong from sc_tmp.cek_borong $date;
									/*insert into sc_im.cek_borong select * from sc_tmp.cek_borong $date;*/
									copy  sc_im.cek_borong to '$patch' using delimiters ';' csv header;
								");
	}
	function e_csvcek_lembur($date,$patch){
		return $this->db->query("drop table if exists sc_im.cek_lembur;
								select * into sc_im.cek_lembur from sc_tmp.cek_lembur $date;
								/*insert into sc_im.cek_lembur select * from sc_tmp.cek_lembur $date;*/
								copy  sc_im.cek_lembur to '$patch' using delimiters ';' csv header;
								");
	}
	function e_csvcek_shift($date,$patch){
		return $this->db->query("drop table if exists sc_im.cek_shift;
								select * into sc_im.cek_shift from sc_tmp.cek_shift $date;
								/*insert into sc_im.cek_shift select * from sc_tmp.cek_shift $date;*/
								copy  sc_im.cek_shift to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvjadwal_kerja($patch){
		return $this->db->query("drop table if exists sc_im.dtljadwalkerja;
								select * into sc_im.dtljadwalkerja from sc_trx.dtljadwalkerja;
								/*insert into sc_im.dtljadwalkerja select * from sc_trx.dtljadwalkerja;*/
								copy  sc_im.dtljadwalkerja to '$patch' using delimiters ';' csv header;
								");
	}

	/* EXPORT / IMPORT */
    function e_export_csv($patch){       /*EXPORT*/
        return $this->db->query("drop table if exists sc_im.exportcsv;
							select * into sc_im.exportcsv from exportcsv;
							copy  sc_im.exportcsv to '$patch' using delimiters ';' csv header;
							");
    }

    function e_import_csv($patch){       /*IMPORT*/
        return $this->db->query("drop table if exists sc_im.importcsv;
							select * into sc_im.importcsv from importcsv;
							copy  sc_im.importcsv to '$patch' using delimiters ';' csv header;
							");
    }

	/* START KARYAWAN EXPORT*/
	function e_csvmstkaryawan($patch){   /*MST0001*/
		return $this->db->query("drop table if exists sc_im.karyawan;
								/* insert into sc_im.karyawan select * from sc_mst.karyawan; */
								select * into sc_im.karyawan from sc_mst.karyawan;
								copy  sc_im.karyawan to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvmststatpeg($patch){   /*MST0002*/
		return $this->db->query("drop table if exists sc_im.status_kepegawaian;
								/*insert into sc_im.status_kepegawaian select * from sc_trx.status_kepegawaian;*/
								select * into sc_im.status_kepegawaian from sc_trx.status_kepegawaian;
								copy  sc_im.status_kepegawaian to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvmstbpjs($patch){      /*MST0003*/
		return $this->db->query("drop table if exists sc_im.bpjs_karyawan;
								/*insert into sc_im.bpjs_karyawan select * from sc_trx.bpjs_karyawan;*/
								select * into sc_im.bpjs_karyawan from sc_trx.bpjs_karyawan;
								copy  sc_im.bpjs_karyawan to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvmstriwkel($patch){     /*MST0004*/
		return $this->db->query("drop table if exists sc_im.riwayat_keluarga;
							/*insert into sc_im.riwayat_keluarga select * from sc_trx.riwayat_keluarga;*/
							select * into sc_im.riwayat_keluarga from sc_trx.riwayat_keluarga;
							copy  sc_im.riwayat_keluarga to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwkes($patch){     /*MST0005*/
		return $this->db->query("drop table if exists sc_im.riwayat_kesehatan;
							/*insert into sc_im.riwayat_kesehatan select * from sc_trx.riwayat_kesehatan;*/
							select * into sc_im.riwayat_kesehatan from sc_trx.riwayat_kesehatan;
							copy  sc_im.riwayat_kesehatan to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwkompt($patch){     /*MST0006*/
		return $this->db->query("drop table if exists sc_im.riwayat_kompetensi;
							/*insert into sc_im.riwayat_kompetensi select * from sc_trx.riwayat_kompetensi;*/
							select * into sc_im.riwayat_kompetensi from sc_trx.riwayat_kompetensi;
							copy  sc_im.riwayat_kompetensi to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwpend($patch){     /*MST0007*/
							return $this->db->query("drop table if exists sc_im.riwayat_pendidikan;
							/*insert into sc_im.riwayat_pendidikan select * from sc_trx.riwayat_pendidikan;*/
							select * into sc_im.riwayat_pendidikan from sc_trx.riwayat_pendidikan;
							copy  sc_im.riwayat_pendidikan to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwpend_nf($patch){     /*MST0008*/
		return $this->db->query("drop table if exists sc_im.riwayat_pendidikan_nf;
							/*insert into sc_im.riwayat_pendidikan_nf select * from sc_trx.riwayat_pendidikan_nf; */
							select * into sc_im.riwayat_pendidikan_nf from sc_trx.riwayat_pendidikan_nf;
							copy  sc_im.riwayat_pendidikan_nf to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwpeng($patch){        /*MST0009*/
	return $this->db->query("drop table if exists sc_im.riwayat_pengalaman;
							/*insert into sc_im.riwayat_pengalaman select * from sc_trx.riwayat_pengalaman;*/
							select * into sc_im.riwayat_pengalaman from sc_trx.riwayat_pengalaman;
							copy  sc_im.riwayat_pengalaman to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwrkmds($patch){       /*MST0010*/
	return $this->db->query("drop table if exists sc_im.riwayat_rekam_medis;
							/*insert into sc_im.riwayat_rekam_medis select * from sc_trx.riwayat_rekam_medis;*/
							select * into sc_im.riwayat_rekam_medis from sc_trx.riwayat_rekam_medis;
							copy  sc_im.riwayat_rekam_medis to '$patch' using delimiters ';' csv header;
							");
	}

    function e_csvmstjabatan($patch){       /*MST0011*/
        return $this->db->query("drop table if exists sc_im.jabatan;
							/*insert into sc_im.riwayat_rekam_medis select * from sc_trx.riwayat_rekam_medis;*/
							select * into sc_im.jabatan from sc_mst.jabatan;
							copy  sc_im.jabatan to '$patch' using delimiters ';' csv header;
							");
    }

    function e_detail_formula($patch){       /*MST0012*/
        return $this->db->query("drop table if exists sc_im.detail_formula;
							select * into sc_im.detail_formula from sc_mst.detail_formula;
							copy  sc_im.detail_formula to '$patch' using delimiters ';' csv header;
							");
    }

    function e_group_penggajian($patch){       /*MST0013*/
        return $this->db->query("drop table if exists sc_im.group_penggajian;
							select * into sc_im.group_penggajian from sc_mst.group_penggajian;
							copy  sc_im.group_penggajian to '$patch' using delimiters ';' csv header;
							");
    }

    function e_departmen($patch){       /*MST0014*/
        return $this->db->query("drop table if exists sc_im.departmen;
							select * into sc_im.departmen from sc_mst.departmen;
							copy  sc_im.departmen to '$patch' using delimiters ';' csv header;
							");
    }

    function e_komponen_bpjs($patch){       /*MST0015*/
        return $this->db->query("drop table if exists sc_im.komponen_bpjs;
							select * into sc_im.komponen_bpjs from sc_mst.komponen_bpjs;
							copy  sc_im.komponen_bpjs to '$patch' using delimiters ';' csv header;
							");
    }

    function e_option($patch){       /*MST0016*/
        return $this->db->query("drop table if exists sc_im.option;
							select * into sc_im.option from sc_mst.option;
							copy  sc_im.option to '$patch' using delimiters ';' csv header;
							");
    }

	//mst payroll
    function e_transready($patch){       /*006*/
        return $this->db->query("drop table if exists sc_im.transready;
							select * into sc_im.transready from sc_trx.transready where tgl >= (to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date);
							copy  sc_im.transready to '$patch' using delimiters ';' csv header;
							");
    }
    function e_jadwalkerja($patch){       /*005*/
        return $this->db->query("drop table if exists sc_im.jadwalkerja;
							select * into sc_im.jadwalkerja from sc_trx.jadwalkerja where tgl >= (to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date);
							copy  sc_im.jadwalkerja to '$patch' using delimiters ';' csv header;
							");
    }
    function e_cekabsen($patch){       /*001*/
        return $this->db->query("drop table if exists sc_im.cek_absen;
							select * into sc_im.cek_absen from sc_tmp.cek_absen where tgl_kerja >= (to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date);
							copy  sc_im.cek_absen to '$patch' using delimiters ';' csv header;
							");
    }
    function e_cekborong($patch){       /*002*/
        return $this->db->query("drop table if exists sc_im.cek_borong;
							select * into sc_im.cek_borong from sc_tmp.cek_borong where tgl_kerja >= (to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date);
							copy  sc_im.cek_borong to '$patch' using delimiters ';' csv header;
							");
    }
    function e_ceklembur($patch){       /*003*/
        return $this->db->query("drop table if exists sc_im.cek_lembur;
							select * into sc_im.cek_lembur from sc_tmp.cek_lembur where tgl_kerja >= (to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date);
							copy  sc_im.cek_lembur to '$patch' using delimiters ';' csv header;
							");
    }
    function e_cekshift($patch){       /*004*/
        return $this->db->query("drop table if exists sc_im.cek_shift;
							select * into sc_im.cek_shift from sc_tmp.cek_shift where tgl_kerja >= (to_char(current_date - (select value3 || ' month' from sc_mst.option where kdoption = 'SEI')::interval, 'YYYY-MM-01')::date);
							copy  sc_im.cek_shift to '$patch' using delimiters ';' csv header;
							");
    }
    //PAYROLL FROM
    function e_m_lvlgp($patch){       /*PY0001*/
        return $this->db->query("drop table if exists sc_im.m_lvlgp;
							select * into sc_im.m_lvlgp from sc_mst.m_lvlgp;
							copy  sc_im.m_lvlgp to '$patch' using delimiters ';' csv header;
							");
    }
    function e_m_masakerja($patch){       /*PY0002*/
        return $this->db->query("drop table if exists sc_im.m_masakerja;
							select * into sc_im.m_masakerja from sc_mst.m_masakerja;
							copy  sc_im.m_masakerja to '$patch' using delimiters ';' csv header;
							");
    }
    function e_m_wilayah($patch){       /*PY0003*/
        return $this->db->query("drop table if exists sc_im.m_wilayah;
							select * into sc_im.m_wilayah from sc_mst.m_wilayah;
							copy  sc_im.m_wilayah to '$patch' using delimiters ';' csv header;
							");
    }
    function e_m_wilayah_nominal($patch){       /*PY0004*/
        return $this->db->query("drop table if exists sc_im.m_wilayah_nominal;
							select * into sc_im.m_wilayah_nominal from sc_mst.m_wilayah_nominal;
							copy  sc_im.m_wilayah_nominal to '$patch' using delimiters ';' csv header;
							");
    }
    function e_jobgrade($patch){       /*PY0005*/
        return $this->db->query("drop table if exists sc_im.jobgrade;
							select * into sc_im.jobgrade from sc_mst.jobgrade;
							copy  sc_im.jobgrade to '$patch' using delimiters ';' csv header;
							");
    }
    function e_m_grade_jabatan($patch){       /*PY0006*/
        return $this->db->query("drop table if exists sc_im.m_grade_jabatan;
							select * into sc_im.m_grade_jabatan from sc_mst.m_grade_jabatan;
							copy  sc_im.m_grade_jabatan to '$patch' using delimiters ';' csv header;
							");
    }



    ////import csv value //////
	function i_importcsv(){
		return $this->db->query("select * from importcsv order by nodok");
	}

	function i_cek_patch($nodokdir){
		return $this->db->query("select * from importcsv where nodok='$nodokdir'");
	}

    /* EXPORT / IMPORT */
    function i_export_csv($patch){       /*EXPORT*/
        return $this->db->query("drop table if exists sc_im.exportcsv;
							select * into sc_im.exportcsv from exportcsv limit 1;
                            truncate sc_im.exportcsv;
                            copy sc_im.exportcsv from '$patch'  using delimiters ';' csv header;
							");
    }

    function i_import_csv($patch){       /*IMPORT*/
        return $this->db->query("drop table if exists sc_im.importcsv;
							select * into sc_im.importcsv from importcsv limit 1;
                            truncate sc_im.importcsv;
                            copy sc_im.importcsv from '$patch'  using delimiters ';' csv header;
							");
    }

	/*------------------------ KARYAWAN IMPORT -----------------------*/
	function i_csvmstkaryawan($patch){ /*MST0001*/
		return $this->db->query("drop table if exists sc_im.karyawan;
		                        select * into sc_im.karyawan from sc_mst.karyawan limit 1;
		                        truncate sc_im.karyawan;
								copy sc_im.karyawan from '$patch'  using delimiters ';' csv header;
								");
	}


	function i_csvmststatpeg($patch){   /*MST0002*/
		return $this->db->query("drop table if exists sc_im.status_kepegawaian;
		                        select * into sc_im.status_kepegawaian from sc_trx.status_kepegawaian limit 1;
		                        truncate sc_im.status_kepegawaian;
								copy  sc_im.status_kepegawaian from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstbpjs($patch){      /*MST0003*/
		return $this->db->query("drop table if exists sc_im.bpjs_karyawan;
		                        select * into sc_im.bpjs_karyawan from sc_trx.bpjs_karyawan limit 1;
		                        truncate sc_im.bpjs_karyawan;
								copy  sc_im.bpjs_karyawan from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwkel($patch){     /*MST0004*/
		return $this->db->query("drop table if exists sc_im.riwayat_keluarga;
		                        select * into sc_im.riwayat_keluarga from sc_trx.riwayat_keluarga limit 1;
		                        truncate sc_im.riwayat_keluarga;
								copy  sc_im.riwayat_keluarga from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwkes($patch){     /*MST0005*/
		return $this->db->query("drop table if exists sc_im.riwayat_kesehatan;
		                        select * into sc_im.riwayat_kesehatan from sc_trx.riwayat_kesehatan limit 1;
		                        truncate sc_im.riwayat_kesehatan;
								copy  sc_im.riwayat_kesehatan from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwkompt($patch){     /*MST0006*/
		return $this->db->query("drop table if exists sc_im.riwayat_kompetensi;
		                        select * into sc_im.riwayat_kompetensi from sc_trx.riwayat_kompetensi limit 1;
		                        truncate sc_im.riwayat_kompetensi;
								copy  sc_im.riwayat_kompetensi from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwpend($patch){     /*MST0007*/
		return $this->db->query("drop table if exists sc_im.riwayat_pendidikan;
		                        select * into sc_im.riwayat_pendidikan from sc_trx.riwayat_pendidikan limit 1;
		                        truncate sc_im.riwayat_pendidikan;
								copy  sc_im.riwayat_pendidikan from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwpend_nf($patch){     /*MST0008*/
		return $this->db->query("drop table if exists sc_im.riwayat_pendidikan_nf;
		                        select * into sc_im.riwayat_pendidikan_nf from sc_trx.riwayat_pendidikan_nf limit 1;
		                        truncate sc_im.riwayat_pendidikan_nf;
								copy  sc_im.riwayat_pendidikan_nf from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwpeng($patch){        /*MST0009*/
		return $this->db->query("drop table if exists sc_im.riwayat_pengalaman;
		                        select * into sc_im.riwayat_pengalaman from sc_trx.riwayat_pengalaman limit 1;
		                        truncate sc_im.riwayat_pengalaman;
								copy  sc_im.riwayat_pengalaman from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwrkmds($patch){       /*MST0010*/
		return $this->db->query("drop table if exists sc_im.riwayat_rekam_medis;
		                        select * into sc_im.riwayat_rekam_medis from sc_trx.riwayat_rekam_medis limit 1;
		                        truncate sc_im.riwayat_rekam_medis;
								copy  sc_im.riwayat_rekam_medis from '$patch' using delimiters ';' csv header;
								");
	}

    function i_csvmstjabatan($patch){       /*MST0011*/
        return $this->db->query("drop table if exists sc_im.jabatan;
		                        select * into sc_im.jabatan from sc_mst.jabatan limit 1;
		                        truncate sc_im.jabatan;
								copy  sc_im.jabatan from '$patch' using delimiters ';' csv header;
								");
    }

    function i_detail_formula($patch){     /*MST0012*/
        return $this->db->query("drop table if exists sc_im.detail_formula;
		                        select * into sc_im.detail_formula from sc_mst.detail_formula limit 1;
		                        truncate sc_im.detail_formula;
								copy  sc_im.detail_formula from '$patch' using delimiters ';' csv header;
								");
    }

    function i_group_penggajian($patch){        /*MST0013*/
        return $this->db->query("drop table if exists sc_im.group_penggajian;
		                        select * into sc_im.group_penggajian from sc_mst.group_penggajian limit 1;
		                        truncate sc_im.group_penggajian;
								copy  sc_im.group_penggajian from '$patch' using delimiters ';' csv header;
								");
    }

    function i_departmen($patch){       /*MST0014*/
        return $this->db->query("drop table if exists sc_im.departmen;
		                        select * into sc_im.departmen from sc_mst.departmen limit 1;
		                        truncate sc_im.departmen;
								copy  sc_im.departmen from '$patch' using delimiters ';' csv header;
								");
    }

    function i_komponen_bpjs($patch){       /*MST0015*/
        return $this->db->query("drop table if exists sc_im.komponen_bpjs;
		                        select * into sc_im.komponen_bpjs from sc_mst.komponen_bpjs limit 1;
		                        truncate sc_im.komponen_bpjs;
								copy  sc_im.komponen_bpjs from '$patch' using delimiters ';' csv header;
								");
    }

    function i_option($patch){       /*MST0016*/
        return $this->db->query("drop table if exists sc_im.option;
		                        select * into sc_im.option from sc_mst.option limit 1;
		                        truncate sc_im.option;
								copy  sc_im.option from '$patch' using delimiters ';' csv header;
								");
    }
	/* END OF MASTER KARYAWAN EXIM*/
    /* START MASTER TRANSAKSIONAL */
    //001
    function i_csvcek_absen($patch){
        return $this->db->query("drop table if exists sc_im.cek_absen;
		                        select * into sc_im.cek_absen from sc_tmp.cek_absen limit 1;
		                        truncate sc_im.cek_absen;
								copy  sc_im.cek_absen from '$patch' using delimiters ';' csv header;
								");
    }
    //002
    function i_csvcek_borong($patch){
        return $this->db->query("drop table if exists sc_im.cek_borong;
		                        select * into sc_im.cek_borong from sc_tmp.cek_borong limit 1;
		                        truncate sc_im.cek_borong;
								copy  sc_im.cek_borong from '$patch' using delimiters ';' csv header;
								");
    }
    //003
    function i_csvcek_lembur($patch){
        return $this->db->query("drop table if exists sc_im.cek_lembur;
		                        select * into sc_im.cek_lembur from sc_tmp.cek_lembur limit 1;
		                        truncate sc_im.cek_lembur;
								copy  sc_im.cek_lembur from '$patch' using delimiters ';' csv header;
								");
    }
    //004
    function i_csvcek_shift($patch){
        return $this->db->query("drop table if exists sc_im.cek_shift;
		                        select * into sc_im.cek_shift from sc_tmp.cek_shift limit 1;
		                        truncate sc_im.cek_shift;
								copy  sc_im.cek_shift from '$patch' using delimiters ';' csv header;
								");
    }
    //005
    function i_csvjadwal_kerja($patch){
        return $this->db->query("drop table if exists sc_im.jadwalkerja;
		                        select * into sc_im.jadwalkerja from sc_trx.jadwalkerja limit 1;
		                        truncate sc_im.jadwalkerja;
								copy  sc_im.jadwalkerja from '$patch' using delimiters ';' csv header;
								");
    }
    function i_csvtransready($patch){
        return $this->db->query("drop table if exists sc_im.transready;
		                        select * into sc_im.transready from sc_trx.transready limit 1;
		                        truncate sc_im.transready;
								copy  sc_im.transready from '$patch' using delimiters ';' csv header;
								");
    }
    /**/
    //PAYROLL FROM
    function i_m_lvlgp($patch){       /*PY0001*/
        return $this->db->query("drop table if exists sc_im.m_lvlgp;
		                        select * into sc_im.m_lvlgp from sc_mst.m_lvlgp limit 1;
		                        truncate sc_im.m_lvlgp;
								copy  sc_im.m_lvlgp from '$patch' using delimiters ';' csv header;
								");
    }
    function i_m_masakerja($patch){       /*PY0002*/
        return $this->db->query("drop table if exists sc_im.m_masakerja;
		                        select * into sc_im.m_masakerja from sc_mst.m_masakerja limit 1;
		                        truncate sc_im.m_masakerja;
								copy  sc_im.m_masakerja from '$patch' using delimiters ';' csv header;
								");
    }
    function i_m_wilayah($patch){       /*PY0003*/
        return $this->db->query("drop table if exists sc_im.m_wilayah;
		                        select * into sc_im.m_wilayah from sc_mst.m_wilayah limit 1;
		                        truncate sc_im.m_wilayah;
								copy  sc_im.m_wilayah from '$patch' using delimiters ';' csv header;
								");
    }
    function i_m_wilayah_nominal($patch){       /*PY0004*/
        return $this->db->query("drop table if exists sc_im.m_wilayah_nominal;
		                        select * into sc_im.m_wilayah_nominal from sc_mst.m_wilayah_nominal limit 1;
		                        truncate sc_im.m_wilayah_nominal;
								copy  sc_im.m_wilayah_nominal from '$patch' using delimiters ';' csv header;
								");
    }
    function i_jobgrade($patch){       /*PY0005*/
        return $this->db->query("drop table if exists sc_im.jobgrade;
		                        select * into sc_im.jobgrade from sc_mst.jobgrade limit 1;
		                        truncate sc_im.jobgrade;
								copy  sc_im.jobgrade from '$patch' using delimiters ';' csv header;
								");
    }

    function i_m_grade_jabatan($patch){       /*PY0006*/
        return $this->db->query("drop table if exists sc_im.m_grade_jabatan;
		                        select * into sc_im.m_grade_jabatan from sc_mst.m_grade_jabatan limit 1;
		                        truncate sc_im.m_grade_jabatan;
								copy  sc_im.m_grade_jabatan from '$patch' using delimiters ';' csv header;
								");
    }

    function m_karyawan(){
        return $this->db->query("select * from sc_mst.karyawan where nik is not null order by nmlengkap asc");
    }

}
