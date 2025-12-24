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
		return $this->db->query("select * from exportcsv");
	}
	
	function e_exportcsvmst(){
		return $this->db->query("select * from exportcsv where left(nodok,3)='MST' order by nodok asc");
	}
	
	function e_cek_patch($nodokdir){
		return $this->db->query("select * from exportcsv where nodok='$nodokdir'");
	}
	
	function e_csvcek_absen($date,$patch){
		return $this->db->query("truncate sc_im.cek_absen;
								insert into sc_im.cek_absen select * from sc_tmp.cek_absen $date;
								copy  sc_im.cek_absen to '$patch' using delimiters ';' csv header;
								");
	}
	
	function e_csvcek_borong($date,$patch){
		return $this->db->query("truncate sc_im.cek_borong;
									insert into sc_im.cek_borong select * from sc_tmp.cek_borong $date;
									copy  sc_im.cek_borong to '$patch' using delimiters ';' csv header;
								");
	}
	function e_csvcek_lembur($date,$patch){
		return $this->db->query("truncate sc_im.cek_lembur;
								insert into sc_im.cek_lembur select * from sc_tmp.cek_lembur $date;
								copy  sc_im.cek_lembur to '$patch' using delimiters ';' csv header;
								");
	}
	function e_csvcek_shift($date,$patch){
		return $this->db->query("truncate sc_im.cek_shift;
								insert into sc_im.cek_shift select * from sc_tmp.cek_shift $date;
								copy  sc_im.cek_shift to '$patch' using delimiters ';' csv header;
								");
	}
	
	function e_csvjadwal_kerja($patch){
		return $this->db->query("truncate sc_im.dtljadwalkerja;
								insert into sc_im.dtljadwalkerja select * from sc_trx.dtljadwalkerja;
								copy  sc_im.dtljadwalkerja to '$patch' using delimiters ';' csv header;
								");
	}
	
	/* START KARYAWAN EXPORT*/
	function e_csvmstkaryawan($patch){   /*MST0001*/
		return $this->db->query("truncate sc_im.karyawan;
								insert into sc_im.karyawan select * from sc_mst.karyawan;
								copy  sc_im.karyawan to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvmststatpeg($patch){   /*MST0002*/
		return $this->db->query("truncate sc_im.status_kepegawaian;
								insert into sc_im.status_kepegawaian select * from sc_trx.status_kepegawaian;
								copy  sc_im.status_kepegawaian to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvmstbpjs($patch){      /*MST0003*/
		return $this->db->query("truncate sc_im.bpjs_karyawan;
								insert into sc_im.bpjs_karyawan select * from sc_trx.bpjs_karyawan;
								copy  sc_im.bpjs_karyawan to '$patch' using delimiters ';' csv header;
								");
	}

	function e_csvmstriwkel($patch){     /*MST0004*/
		return $this->db->query("truncate sc_im.riwayat_keluarga;
							insert into sc_im.riwayat_keluarga select * from sc_trx.riwayat_keluarga;
							copy  sc_im.riwayat_keluarga to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwkes($patch){     /*MST0005*/
		return $this->db->query("truncate sc_im.riwayat_kesehatan;
							insert into sc_im.riwayat_kesehatan select * from sc_trx.riwayat_kesehatan;
							copy  sc_im.riwayat_kesehatan to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwkompt($patch){     /*MST0006*/
		return $this->db->query("truncate sc_im.riwayat_kompetensi;
							insert into sc_im.riwayat_kompetensi select * from sc_trx.riwayat_kompetensi;
							copy  sc_im.riwayat_kompetensi to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwpend($patch){     /*MST0007*/
							return $this->db->query("truncate sc_im.riwayat_pendidikan;
							insert into sc_im.riwayat_pendidikan select * from sc_trx.riwayat_pendidikan;
							copy  sc_im.riwayat_pendidikan to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwpend_nf($patch){     /*MST0008*/
		return $this->db->query("truncate sc_im.riwayat_pendidikan_nf;
							insert into sc_im.riwayat_pendidikan_nf select * from sc_trx.riwayat_pendidikan_nf;
							copy  sc_im.riwayat_pendidikan_nf to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwpeng($patch){        /*MST0009*/
	return $this->db->query("truncate sc_im.riwayat_pengalaman;
							insert into sc_im.riwayat_pengalaman select * from sc_trx.riwayat_pengalaman;
							copy  sc_im.riwayat_pengalaman to '$patch' using delimiters ';' csv header;
							");
	}

	function e_csvmstriwrkmds($patch){       /*MST0010*/
	return $this->db->query("truncate sc_im.riwayat_rekam_medis;
							insert into sc_im.riwayat_rekam_medis select * from sc_trx.riwayat_rekam_medis;
							copy  sc_im.riwayat_rekam_medis to '$patch' using delimiters ';' csv header;
							");
	}
	
	
	
	
	
	////import csv value //////
	function i_importcsv(){
		return $this->db->query("select * from importcsv");
	}
	
	function i_cek_patch($nodokdir){
		return $this->db->query("select * from importcsv where nodok='$nodokdir'");
	}
	
	function i_csvcek_absen($patch){
		return $this->db->query("truncate sc_tmp.cek_absen;
									copy sc_tmp.cek_absen from '$patch'  using delimiters ';' csv header;
								");
	}
	
	function i_csvcek_borong($patch){
		return $this->db->query("truncate sc_tmp.cek_borong;
									copy sc_tmp.cek_borong from '$patch'  using delimiters ';' csv header;
								");
	}
	function i_csvcek_lembur($patch){
		return $this->db->query("truncate sc_tmp.cek_lembur;
									copy sc_tmp.cek_lembur from '$patch'  using delimiters ';' csv header;
								");
	}
	function i_csvcek_shift($patch){
		return $this->db->query("truncate sc_tmp.cek_shift;
									copy sc_tmp.cek_shift from '$patch'  using delimiters ';' csv header;
								");
	}
	
	/* KARYAWAN IMPORT*/
	function i_csvmstkaryawan($patch){ /*MST0001*/
		return $this->db->query("truncate sc_im.karyawan;
								copy sc_im.karyawan from '$patch'  using delimiters ';' csv header;
								");
	}


	function i_csvmststatpeg($patch){   /*MST0002*/
		return $this->db->query("truncate sc_im.status_kepegawaian;
								copy  sc_im.status_kepegawaian from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstbpjs($patch){      /*MST0003*/
		return $this->db->query("truncate sc_im.bpjs_karyawan;
								copy  sc_im.bpjs_karyawan from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwkel($patch){     /*MST0004*/
		return $this->db->query("truncate sc_im.riwayat_keluarga;
								copy  sc_im.riwayat_keluarga from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwkes($patch){     /*MST0005*/
		return $this->db->query("truncate sc_im.riwayat_kesehatan;
								copy  sc_im.riwayat_kesehatan from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwkompt($patch){     /*MST0006*/
		return $this->db->query("truncate sc_im.riwayat_kompetensi;
								copy  sc_im.riwayat_kompetensi from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwpend($patch){     /*MST0007*/
		return $this->db->query("truncate sc_im.riwayat_pendidikan;
								copy  sc_im.riwayat_pendidikan from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwpend_nf($patch){     /*MST0008*/
		return $this->db->query("truncate sc_im.riwayat_pendidikan_nf;
								copy  sc_im.riwayat_pendidikan_nf from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwpeng($patch){        /*MST0009*/
		return $this->db->query("truncate sc_im.riwayat_pengalaman;
								copy  sc_im.riwayat_pengalaman from '$patch' using delimiters ';' csv header;
								");
	}

	function i_csvmstriwrkmds($patch){       /*MST0010*/
		return $this->db->query("truncate sc_im.riwayat_rekam_medis;
								copy  sc_im.riwayat_rekam_medis from '$patch' using delimiters ';' csv header;
								");
	}
	/* END OF MASTER KARYAWAN EXIM*/

	
	
	
}	