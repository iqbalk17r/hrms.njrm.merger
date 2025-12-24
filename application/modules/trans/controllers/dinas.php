<?php
/*
@author : Fiky
01-12-2017
*/
//error_reporting(0)
class Dinas extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		//$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
		//$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$this->load->model(array('m_dinas', 'master/m_akses', 'master/m_option'));
		$this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'Excel_generator', 'Fiky_encryption', 'Fiky_version', 'fiky_notification_push'));
		if (!$this->session->userdata('nik')) {
			redirect('dashboard');
		}
	}

	function index()
	{
		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.T.B.16';
		$versirelease = 'I.T.B.16/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		$data['title'] = "Pengajuan Dinas Karyawan";

		$paramerror = " and userid='$nama' and modul='DINAS'";
		$dtlerror = $this->m_dinas->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_dinas->q_trxerror($paramerror)->num_rows();
		if (isset($dtlerror['description'])) {
			$errordesc = trim($dtlerror['description']);
		} else {
			$errordesc = '';
		}
		if (isset($dtlerror['nomorakhir1'])) {
			$nomorakhir1 = trim($dtlerror['nomorakhir1']);
		} else {
			$nomorakhir1 = '';
		}
		if (isset($dtlerror['errorcode'])) {
			$errorcode = trim($dtlerror['errorcode']);
		} else {
			$errorcode = '';
		}

		if ($count_err > 0 and $errordesc <> '') {
			if ($dtlerror['errorcode'] == 0) {
				$data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-info'>$errordesc</div>";
			}

		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}

		$thn = $this->input->post('tahun');
		$bln = $this->input->post('bulan');
		$status1 = $this->input->post('status');
		if (empty($thn)) {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl = $bulan . $tahun;
			$status = 'is not NULL';
		} else {
			$tahun = $thn;
			$bulan = $bln;
			$tgl = $bulan . $tahun;
			if ($status1 == null) {
				$status = 'is not NULL';
			} else {
				$status = "='$status1'";
			}
		}
		switch ($bulan) {
			case '01':
				$bul = 'Januari';
				break;
			case '02':
				$bul = 'Februari';
				break;
			case '03':
				$bul = 'Maret';
				break;
			case '04':
				$bul = 'April';
				break;
			case '05':
				$bul = 'Mei';
				break;
			case '06':
				$bul = 'Juni';
				break;
			case '07':
				$bul = 'Juli';
				break;
			case '08':
				$bul = 'Agustus';
				break;
			case '09':
				$bul = 'September';
				break;
			case '10':
				$bul = 'Oktober';
				break;
			case '11':
				$bul = 'November';
				break;
			case '12':
				$bul = 'Desember';
				break;
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();

		$level_akses = strtoupper(trim($userinfo['level_akses']));

		if (($userhr > 0 or $level_akses == 'A')) {
			$nikatasan = '';
		} else if (($ceknikatasan1) > 0 and $userhr == 0 and ($level_akses == 'B' or $level_akses == 'C' or $level_akses == 'D')) {
			$nikatasan = "where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or x1.nik='$nama'";

		} else if (($ceknikatasan2) > 0 and $userhr == 0 and ($level_akses == 'B' or $level_akses == 'C' or $level_akses == 'D')) {
			$nikatasan = "where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or x1.nik='$nama'";
		} else {
			$nikatasan = "where x1.nik='$nama'";
		}
		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;
		/* END APPROVE ATASAN */

		/*cek jika ada inputan edit atau input*/
		$param3_1_1 = " and nodok='$nama'";
		$cekmst_na = $this->m_dinas->cek_tmp_dinas_param($param3_1_1)->num_rows(); //input
		$dtledit = $this->m_dinas->cek_tmp_dinas_param($param3_1_1)->row_array(); //input

		$enc_nama = bin2hex($this->encrypt->encode($nama));
		$data['enc_nama'] = bin2hex($this->encrypt->encode($nama));
		if ($cekmst_na > 0) { //cek inputan
			$this->db->cache_delete('trans', 'dinas');
			$enc_nik = bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
			$enc_tglberangkat = bin2hex($this->encrypt->encode(trim($dtledit['tgl_mulai'])));
			$enc_tglkembali = bin2hex($this->encrypt->encode(trim($dtledit['tgl_selesai'])));
			redirect("trans/dinas/input_dinas_dtl/$enc_tglberangkat/$enc_tglkembali");
		}
		$data['akses'] = $this->m_akses->list_aksespermenu($nama, $kodemenu)->row_array();
		$data['list_dinas'] = $this->m_dinas->q_dinas_karyawan($tgl, $status, $nikatasan)->result();

		$this->template->display('trans/dinas/v_list', $data);

		$paramerror = " and userid='$nama'";
		//$dtlerror=$this->m_dinas->q_deltrxerror($paramerror);

	}
	function input()
	{
		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.T.B.16';
		$versirelease = 'I.T.B.16/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$cek = $this->m_dinas->cek_tmp($nama)->num_rows();
		$cek_array = $this->m_dinas->cek_tmp($nama)->row_array();


		if ($cek > 0) {
			$tglberangkat = $cek_array['tgl_mulai'];
			$tglkembali = $cek_array['tgl_selesai'];
			redirect("trans/dinas/input_dinas_dtl/$tglberangkat/$tglkembali");
		}

		$data['title'] = "STEP 1";
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();
		if ($userhr > 0 or $level_akses === 'A') {
			$data['list_karyawan'] = $this->m_akses->list_karyawan()->result();
		} else {
			$data['list_karyawan'] = $this->m_akses->list_akses_alone()->result();
		}
		$data['default_date'] = date('d-m-Y');
		$data['opsi_dinas'] = null;
		if ($userhr == 0) {
			$opsi_dinas = $this->m_option->q_cekoption('BLKDN')->row();
			if ($opsi_dinas->status == "T") {
				$value = strtolower($opsi_dinas->value1);
				$value = str_replace("d", " day", $value);
				$data['default_date'] = $data['opsi_dinas'] = date('d-m-Y', strtotime($value));
			}
		}
		$this->template->display('trans/dinas/v_list_karyawan', $data);
	}

	function inputdtl($nik)
	{
		$data['title'] = "Form Pengajuan Dinas Karyawan";
		if ($this->uri->segment(5) == "input_failed") {
			$data['message'] = "<div class='alert alert-danger'>Nik: $nik  Pada Hari Tersebut Sudah Melakukan Input Dinas</div>";
		} else {
			$data['message'] = '';
		}
		$data['list_lk'] = $this->m_dinas->list_karyawan_index($nik)->result();
		$this->template->display('trans/dinas/v_input', $data);
	}

	function add_dinas()
	{
		$nik = $this->input->post('nik');
		$kddept = $this->input->post('department');
		$kdsubdept = $this->input->post('subdepartment');
		$kdjabatan = $this->input->post('jabatan');
		$kdlvljabatan = $this->input->post('kdlvl');
		$atasan = $this->input->post('atasan');
		$kepdinas = $this->input->post('kepdinas');
		$tujdinas = $this->input->post('tujdinas');
		$tglberangkat1 = $this->input->post('tglberangkat');
		$tglkembali1 = $this->input->post('tglkembali');
		$kdkategori = $this->input->post('kdkategori');

		if ($tglberangkat1 == '') {
			$tglberangkat = NULL;
		} else {
			$tglberangkat = $tglberangkat1;
		}
		if ($tglkembali1 == '') {
			$tglkembali = NULL;
		} else {
			$tglkembali = $tglkembali1;
		}

		$tgl_dok = date('Y-m-d');
		$status = 'A';
		$tgl_input = date('Y-m-d');
		$inputby = $this->session->userdata('nik');

		$info = array(
			'nik' => $nik,
			'nodok' => $this->session->userdata('nik'),
			'tgl_dok' => $tgl_dok,
			'nmatasan' => $atasan,
			'tgl_mulai' => $tglberangkat,
			'tgl_selesai' => $tglkembali,
			'keperluan' => strtoupper($kepdinas),
			'tujuan' => strtoupper($tujdinas),
			'status' => strtoupper($status),
			'input_date' => date('Y-m-d H:i:s'),
			'input_by' => strtoupper($inputby),
			'kdkategori' => strtoupper($kdkategori),
		);

		$cek = $this->m_dinas->cek_double($nik, $tglberangkat, $tglkembali)->num_rows();
		if ($cek == 0) {
			$this->db->insert('sc_tmp.dinas', $info);
			redirect("trans/dinas/index/rep_succes");
		} else {


			redirect("trans/dinas/inputdtl/$nik/input_failed");
		}

	}

	function save_dinas()
	{
		$nik = $this->input->post('nik');
		$nodok = $this->input->post('nodok');
		$kepdinas = $this->input->post('kepdinas');
		$tujdinas = $this->input->post('tujdinas');
		//$tglberangkat1=$this->input->post('tglberangkat');
		//$tglkembali1=$this->input->post('tglkembali');
		$tgl = explode(' - ', $this->input->post('tgl'));
		$kdkategori = $this->input->post('kdkategori');
		$tglberangkat1 = $tgl[0];
		$tglkembali1 = $tgl[1];

		if ($tglberangkat1 == '') {
			$tglberangkat = NULL;
		} else {
			$tglberangkat = $tglberangkat1;
		}
		if ($tglkembali1 == '') {
			$tglkembali = NULL;
		} else {
			$tglkembali = $tglkembali1;
		}

		$tgl_dok = date('Y-m-d');
		$tgl_input = date('Y-m-d');
		$inputby = $this->session->userdata('nik');

		$info = array(
			//'nik'=>$nik,
			'tgl_dok' => $tgl_dok,
			'nmatasan' => '',
			'tgl_mulai' => $tglberangkat,
			'tgl_selesai' => $tglkembali,
			'keperluan' => strtoupper($kepdinas),
			'tujuan' => strtoupper($tujdinas),
			'update_date' => date('Y-m-d H:i:s'),
			'update_by' => strtoupper($inputby),
			'kdkategori' => strtoupper($kdkategori),
		);
		//	$cek=$this->m_dinas->cek_double($nik,$tglberangkat,$tglkembali)->num_rows();
		//if ($cek==0){
		$this->db->where('nodok', $nodok);
		$this->db->update('sc_trx.dinas', $info);
		redirect("trans/dinas/index/rep_succes");
		//	} else {
		//	redirect("trans/dinas/edit/$nodok/$nik/input_failed");
		//}


	}

	function approval()
	{
		$nodok = $this->input->post('nodok');
		$tgl = date('Y-m-d');
		$nama = $this->session->userdata('nik');
		$info = array(
			'status' => 'P',
			'approval_date' => $tgl,
			'approval_by' => $nama,
		);
		$this->db->where('nodok', $nodok);
		$this->db->update('sc_trx.dinas', $info);
		redirect("trans/dinas/index/app_succes");

	}

	function cancel()
	{
		$nodok = $this->input->post('nodok');
		$tgl = date('Y-m-d');
		$nama = $this->session->userdata('nik');
		$info = array(
			'status' => 'C',
			'cancel_date' => $tgl,
			'cancel_by' => $nama,
		);
		$this->db->where('nodok', $nodok);
		$this->db->update('sc_trx.dinas', $info);
		redirect("trans/dinas/index/cancel_succes");
	}
	function hapus()
	{
		$nodok = trim($this->uri->segment(4));
		$tgl = date('Y-m-d');
		$nama = $this->session->userdata('nik');
		$info = array(
			'status' => 'D',
			'delete_date' => $tgl,
			'delete_by' => $nama,
		);
		$this->db->where('nodok', $nodok);
		$this->db->update('sc_trx.dinas', $info);
		redirect("trans/dinas/index/del_succes");
	}

	function resend_sms()
	{
		$nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$cek = $this->m_dinas->cek_input($nodok)->num_rows();

		if ($cek == 0) {
			redirect("trans/dinas/index/kode_failed");
		} else {

			$this->db->query("update sc_trx.dinas set status='M' where nodok='$nodok'");
			redirect("trans/dinas/index/sendsms_succes/$nodok");
		}
	}

	function batal_dinas()
	{
		$nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$tgl = date('Y-m-d');
		$nama = $this->session->userdata('nik');
		$info = array(
			'status' => 'C',
			'delete_date' => $tgl,
			'delete_by' => $nama,
		);
		$this->db->where('nodok', $nodok);
		$this->db->update('sc_trx.dinas', $info);
		redirect("trans/dinas/index/up_succes");
	}

	function edit()
	{
		//echo "test";
		$nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$data['title'] = 'EDIT DATA DINAS KARYAWAN';
		if ($this->uri->segment(5) == "upsuccess") {
			$data['message'] = "<div class='alert alert-success'>Data Berhasil di update </div>";
		} else if ($this->uri->segment(6) == "input_failed") {
			$nik = $this->uri->segment(5);
			$data['message'] = "<div class='alert alert-danger'>Nik: $nik  Pada Hari Tersebut Sudah Melakukan Input Dinas</div>";
		} else {
			$data['message'] = '';
		}
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();
		$data['list_dinas_karyawan'] = $this->m_dinas->q_dinas_karyawan_dtl($nodok)->result();
		//$cok=$this->m_dinas->q_dinas_karyawan_dtl($nodok)->row_array();
		//echo $cok['kdkategori'];
		$data['default_date'] = date('d-m-Y');
		$data['opsi_dinas'] = null;
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		if ($userhr == 0) {
			$opsi_dinas = $this->m_option->q_cekoption('BLKDN')->row();
			if ($opsi_dinas->status == "T") {
				$value = strtolower($opsi_dinas->value1);
				$value = str_replace("d", " day", $value);
				$data['default_date'] = $data['opsi_dinas'] = date('d-m-Y', strtotime($value));
			}
		}

		$this->template->display('trans/dinas/v_edit', $data);

	}

	function detail()
	{
		//echo "test";
		$nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$data['title'] = 'DETAIL DINAS KARYAWAN';
		$nama = $this->session->userdata('nik');
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();
		$data['userhr'] = $userhr;
		$data['nama'] = $nama;
		$data['level_akses'] = $level_akses;
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();
		$data['list_dinas_karyawan'] = $this->m_dinas->q_dinas_karyawan_dtl($nodok)->result();
		$this->template->display('trans/dinas/v_detail', $data);

	}


	function add_multinik()
	{
		$this->db->cache_delete('trans', 'dinas');
		$nama = $this->session->userdata('nik');
		$lb = $this->input->post('centang');
		$kepdinas = $this->input->post('kepdinas');
		$tujdinas = $this->input->post('tujdinas');
		//$tglberangkat1=$this->input->post('tglberangkat');
		//	$tglkembali1=$this->input->post('tglkembali');
		$tgl = explode(' - ', $this->input->post('tgl'));
		$kdkategori = $this->input->post('kdkategori');
		$tglberangkat1 = $tgl[0];
		$tglkembali1 = $tgl[1];
		if ($tglberangkat1 == '') {
			$tglberangkat = NULL;
		} else {
			$tglberangkat = $tglberangkat1;
		}
		if ($tglkembali1 == '') {
			$tglkembali = NULL;
		} else {
			$tglkembali = $tglkembali1;
		}

		$tgl_dok = date('Y-m-d');
		$status = 'A';
		$tgl_input = date('Y-m-d H:i:s');
		$inputby = $this->session->userdata('nik');

		foreach ($lb as $index => $temp) {
			$nik = trim($lb[$index]);
			$lihat_nik = $this->m_dinas->list_karyawan_index($nik)->row_array();
			$info[$index]['nik'] = $nik;
			$info[$index]['nodok'] = $inputby;
			$info[$index]['tgl_dok'] = $tgl_dok;
			$info[$index]['nmatasan'] = $lihat_nik['nik_atasan'];
			$info[$index]['tgl_mulai'] = $tglberangkat;
			$info[$index]['tgl_selesai'] = $tglkembali;
			$info[$index]['keperluan'] = strtoupper($kepdinas);
			$info[$index]['tujuan'] = strtoupper($tujdinas);
			$info[$index]['status'] = strtoupper($status);
			$info[$index]['input_date'] = $tgl_input;
			$info[$index]['input_by'] = strtoupper($inputby);
			$info[$index]['kdkategori'] = strtoupper($kdkategori);
		}

		$cek = $this->m_dinas->cek_double($nik, $tglberangkat, $tglkembali)->num_rows();
		$cek2 = $this->m_dinas->cek_tmp_dinas($nik)->num_rows();

		if ($cek == 0 and !empty($info) and $cek2 == 0) {
			$insert = $this->m_dinas->add_multinik($info);
			$enc_tglberangkat = $this->fiky_encryption->enkript($tglberangkat);
			$enc_tglkembali = $this->fiky_encryption->enkript($tglkembali);
			redirect("trans/dinas/input_dinas_dtl/$enc_tglberangkat/$enc_tglkembali");
		} else {

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'DINAS');
			$this->db->delete('sc_mst.trxerror');
			/* error handling */
			$infotrxerror = array(
				'userid' => $nama,
				'errorcode' => 1,
				'nomorakhir1' => '',
				'nomorakhir2' => '',
				'modul' => 'DINAS',
			);
			$this->db->insert('sc_mst.trxerror', $infotrxerror);
			redirect("trans/dinas/index");
		}

	}

	function input_dinas_dtl($enc_tglberangkat, $enc_tglkembali)
	{
		$this->db->cache_delete('trans', 'dinas');
		$tglberangkat = $this->fiky_encryption->dekript($enc_tglberangkat);
		$tglkembali = $this->fiky_encryption->dekript($enc_tglkembali);
		$this->db->cache_delete('validatorMailer', 'test_del_cache');
		if ((empty($tglberangkat)) or (empty($tglkembali))) {
			redirect("trans/dinas/index");
		}

		$data['title'] = "STEP 2 DINAS-KARYAWAN";
		$nama = $this->session->userdata('nik');
		$nodok = $nama;
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();
		$data['list_dtl'] = $this->m_dinas->list_tmp_dinas($nama, $tglberangkat, $tglkembali)->result();
		$data['dtl_dn'] = $this->m_dinas->list_tmp_dinas($nama, $tglberangkat, $tglkembali)->row_array();

		$this->template->display('trans/dinas/v_list_karyawan_dtl', $data);
	}

	function final_dinas_dtl()
	{
		$this->db->cache_delete('trans', 'dinas');
		$tglberangkat1 = $this->input->post('tglberangkat');
		$tglkembali1 = $this->input->post('tglkembali');
		$nama = $this->session->userdata('nik');

		if ($tglberangkat1 == '') {
			$tglberangkat = NULL;
		} else {
			$tglberangkat = $tglberangkat1;
		}
		if ($tglkembali1 == '') {
			$tglkembali = NULL;
		} else {
			$tglkembali = $tglkembali1;
		}

		$info = array('status' => 'I');
		$this->db->where('nodok', $nama);
		$this->db->update('sc_tmp.dinas', $info);



		$paramerror = " and userid='$nama' and modul='DINAS'";
		$dtlerrorcount = $this->m_dinas->q_trxerror($paramerror)->num_rows();
		$dtlerror = $this->m_dinas->q_trxerror($paramerror)->row_array();

		if ($dtlerrorcount > 0) {
			$dtrx = $this->m_dinas->cek_trx_dinas(trim($dtlerror['nomorakhir1']))->row_array();
			$nix = $dtrx['nik'];
			$dtl_push = $this->m_akses->q_lv_mkaryawan(" and nik='$nix'")->row_array();
			if ($this->fiky_notification_push->onePushVapeApprovalHrms($nix, trim($dtl_push['nik_atasan']), trim($dtlerror['nomorakhir1']))) {
				$this->db->where('nodok', $nama);
				$this->db->delete('sc_tmp.dinas');
				redirect("trans/dinas/index");
			}
		} else {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'DINAS');
			$this->db->delete('sc_mst.trxerror');
			/* error handling */
			$infotrxerror = array(
				'userid' => $nama,
				'errorcode' => 1,
				'nomorakhir1' => '',
				'nomorakhir2' => '',
				'modul' => 'DINAS',
			);
			$this->db->insert('sc_mst.trxerror', $infotrxerror);
			redirect("trans/dinas/index");
		}

	}

	function cleartmp()
	{
		$nama = $this->session->userdata('nik');
		$this->db->where('nodok', $nama);
		$this->db->delete('sc_tmp.dinas');
		redirect("trans/dinas/index");
	}

	function cetak_tok()
	{
		$nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		// $nodok = 'a';
		$data['jsonfile'] = "trans/dinas/sti_dinas_ajax/$nodok";
		$data['report_file'] = 'assets/mrt/sp_dinas.mrt';
		$this->load->view("trans/dinas/sti_form_dinas", $data);
	}
	function sti_dinas_ajax($nodok)
	{
		header('Content-Type: application/json');
		echo json_encode(
			array(
				'dinas' => $this->m_dinas->q_sti_dinas_dtl('
                and (nodok)=(\'' . $nodok . '\')
                ')->result(),

			),
			JSON_PRETTY_PRINT
		);

	}

	function index_deklarasi()
	{

		$data['message'] = '';
		$data['title'] = "DEKLARASI DINAS";
		$tipe = $this->input->post('tpdeclare');

		if ($tipe == 'TRX') {
			redirect("trans/dinas/deklarasi_dinas_trx");
		} else if ($tipe == 'TMP') {
			redirect("trans/dinas/deklarasi_dinas_tmp");
		}
		$this->template->display('trans/dinas/v_index_deklarasi', $data);
	}

	function deklarasi_dinas_trx()
	{

		$data['message'] = '';
		$data['title'] = "DEKLARASI DINAS FINAL";

		$thn = $this->input->post('tahun');
		$bln = $this->input->post('bulan');
		$nik = $this->input->post('nik');
		//$parameter='';
		if (empty($thn) or empty($bln)) {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl = $bulan . $tahun;
			$parameter = "and to_char(x.tgl_dok,'mmYYYY')='$tgl'";
		} else if (!empty($nik)) {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl = $bulan . $tahun;
			$parameter = "and to_char(x.tgl_dok,'mmYYYY')='$tgl' and x.nik='$nik'";
			;
		} else {
			$tahun = $thn;
			$bulan = $bln;
			$tgl = $bulan . $tahun;
			if (empty($nik)) {
				$parameter = "and to_char(x.tgl_dok,'mmYYYY')='$tgl'";
			} else {
				$parameter = "and x.nik='$nik'";
				;
			}

		}
		switch ($bulan) {
			case '01':
				$bul = 'Januari';
				break;
			case '02':
				$bul = 'Februari';
				break;
			case '03':
				$bul = 'Maret';
				break;
			case '04':
				$bul = 'April';
				break;
			case '05':
				$bul = 'Mei';
				break;
			case '06':
				$bul = 'Juni';
				break;
			case '07':
				$bul = 'Juli';
				break;
			case '08':
				$bul = 'Agustus';
				break;
			case '09':
				$bul = 'September';
				break;
			case '10':
				$bul = 'Oktober';
				break;
			case '11':
				$bul = 'November';
				break;
			case '12':
				$bul = 'Desember';
				break;
		}


		$data['list_deklarasi'] = $this->m_dinas->q_trx_deklarasi_mst($parameter)->result();
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();

		if ($userhr > 0 or $level_akses == 'A') {
			$data['list_karyawan'] = $this->m_akses->list_karyawan()->result();
		} else {
			$data['list_karyawan'] = $this->m_akses->list_akses_alone()->result();
		}
		$data['list_dinas'] = $this->m_dinas->q_dinas_nik()->result();
		$this->template->display('trans/dinas/v_deklarasi_trx', $data);
	}


	function deklarasi_dinas_tmp()
	{

		$data['message'] = '';
		$data['title'] = "DEKLARASI DINAS TEMPORARY";
		$thn = $this->input->post('tahun');
		$bln = $this->input->post('bulan');
		$nik = $this->input->post('nik');
		//$parameter='';
		if (empty($thn) or empty($bln)) {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl = $bulan . $tahun;
			$parameter = "and to_char(x.tgl_dok,'mmYYYY')='$tgl'";
		} else if (!empty($nik)) {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl = $bulan . $tahun;
			$parameter = "and to_char(x.tgl_dok,'mmYYYY')='$tgl' and x.nik='$nik'";
			;
		} else {
			$tahun = $thn;
			$bulan = $bln;
			$tgl = $bulan . $tahun;
			if (empty($nik)) {
				$parameter = "and to_char(x.tgl_dok,'mmYYYY')='$tgl'";
			} else {
				$parameter = "and x.nik='$nik'";
				;
			}

		}
		switch ($bulan) {
			case '01':
				$bul = 'Januari';
				break;
			case '02':
				$bul = 'Februari';
				break;
			case '03':
				$bul = 'Maret';
				break;
			case '04':
				$bul = 'April';
				break;
			case '05':
				$bul = 'Mei';
				break;
			case '06':
				$bul = 'Juni';
				break;
			case '07':
				$bul = 'Juli';
				break;
			case '08':
				$bul = 'Agustus';
				break;
			case '09':
				$bul = 'September';
				break;
			case '10':
				$bul = 'Oktober';
				break;
			case '11':
				$bul = 'November';
				break;
			case '12':
				$bul = 'Desember';
				break;
		}

		$data['list_deklarasi'] = $this->m_dinas->q_deklarasi_mst($parameter)->result();
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$data['list_kategori'] = $this->m_dinas->q_ktg_dinas()->result();

		if ($userhr > 0 or $level_akses == 'A') {
			$data['list_karyawan'] = $this->m_akses->list_karyawan()->result();
		} else {
			$data['list_karyawan'] = $this->m_akses->list_akses_alone()->result();
		}
		$data['list_dinas'] = $this->m_dinas->q_dinas_nik()->result();
		$this->template->display('trans/dinas/v_deklarasi_tmp', $data);
	}



	function input_deklarasi_tmp()
	{
		$branch = 'SBYNSA';
		$nik = $this->input->post('nikum');
		$nodok_ref = $this->input->post('nodokdinas');
		$type = strtoupper($this->input->post('type'));
		$tglclaim = $this->input->post('tglclaim');
		$km_awal = $this->input->post('kmawal');
		$km_akhir = $this->input->post('kmakhir');
		$bbm_liter = $this->input->post('bbmliter');
		$bbm_rupiah = $this->input->post('bbmrupiah');
		$parkir = $this->input->post('parkir');
		$tol = $this->input->post('tol');
		$uangsaku = $this->input->post('uangsaku');
		$laundry = $this->input->post('laundry');
		$transport = $this->input->post('transport');
		$lain = $this->input->post('lain');
		$total = $this->input->post('total');
		$sisa = $this->input->post('sisa');
		$uangmuka = $this->input->post('uangmuka');
		$keterangan = $this->input->post('keterangan');
		$nama = $this->session->userdata('nik');

		if ($type == 'DEK_MASTER') {
			$info = array(
				'branch' => $branch,
				'nik' => $nik,
				'nodok' => $nama,
				'nodok_ref' => $nodok_ref,
				'tgl_dok' => date('Y-m-d'),
				'status' => 'I',
				'total' => 0,
				'uangmuka' => $uangmuka,
				'sisa' => 0,
				'keterangan' => $keterangan,
				'input_date' => date('Y-m-d'),
				'input_by' => $nama,
			);

			$this->db->insert('sc_tmp.deklarasi_mst', $info);
			redirect("trans/dinas/view_input_tmp/$nodok_ref/$nik");
		} else if ($type == 'DEK_DTL') {
			$info = array(
				'branch' => $branch,
				'nik' => $nik,
				'nodok' => $nama,
				'nodok_ref' => $nodok_ref,
				'tgl' => $tglclaim,
				'status' => 'I',
				'km_awal' => $km_awal,
				'km_akhir' => $km_akhir,
				'bbm_liter' => $bbm_liter,
				'bbm_rupiah' => $bbm_rupiah,
				'parkir' => $parkir,
				'tol' => $tol,
				'uangsaku' => $uangsaku,
				'laundry' => $laundry,
				'transport' => $transport,
				'lain' => $lain,
				'keterangan' => $keterangan,
				'input_date' => date('Y-m-d'),
				'input_by' => $nama,
			);

			$this->db->insert('sc_tmp.deklarasi_dtl', $info);
			redirect("trans/dinas/view_input_tmp/$nodok_ref/$nik");
		}

	}




	function view_input_tmp()
	{
		$nama = $this->session->userdata('nik');
		$nodok = $this->uri->segment(4);
		$nik = $this->uri->segment(5);
		;

		if (empty($nodok) or empty($nik)) {
			redirect("trans/dinas/deklarasi_dinas_tmp");
		}

		$data['nik'] = $nik;
		$data['nodok_ref'] = $nodok;
		$data['title'] = "INPUT DEKLARASI DINAS";
		$data['message'] = "";
		$data['dtl_dinas'] = $this->m_dinas->q_dinas_karyawan_dtl($nodok)->row_array();
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$parameter = "and x.nodok_ref='$nodok' and x.nik='$nik'";
		$data['list_deklarasi'] = $this->m_dinas->q_deklarasi_mst($parameter)->result();
		$data['list_deklarasi_dtl'] = $this->m_dinas->q_deklarasi_dtl('and (nodok_ref)=(\'' . $nodok . '\')', 'and (nik)=(\'' . $nik . '\')')->result();

		$this->template->display('trans/dinas/v_deklarasi_inputdtl', $data);
	}


	function view_dtl_trx()
	{
		$nama = $this->session->userdata('nik');
		$nodok = $this->uri->segment(4);
		$nik = $this->uri->segment(5);
		;

		if (empty($nodok) or empty($nik)) {
			redirect("trans/dinas/deklarasi_dinas_tmp");
		}

		$data['nik'] = $nik;
		$data['nodok'] = $nodok;
		$data['title'] = "INPUT DEKLARASI DINAS";
		$data['message'] = "";
		$data['dtl_dinas'] = $this->m_dinas->q_dinas_karyawan_dtl($nodok)->row_array();
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$parameter = "and x.nodok='$nodok' and x.nik='$nik'";
		$data['list_deklarasi'] = $this->m_dinas->q_trx_deklarasi_mst($parameter)->result();
		$data['list_deklarasi_dtl'] = $this->m_dinas->q_trxdeklarasi_dtl('and (nodok)=(\'' . $nodok . '\')', 'and (nik)=(\'' . $nik . '\')')->result();

		$this->template->display('trans/dinas/v_deklarasidtl_trx', $data);
	}

	function hapus_deklarasi()
	{
		$nodok = $this->uri->segment(4);
		$nik = $this->uri->segment(5);
		$nodok_ref = $this->uri->segment(6);
		$id = $this->uri->segment(7);

		$this->db->where('nik', $nik);
		$this->db->where('nodok', $nodok);
		$this->db->where('nodok_ref', $nodok_ref);
		$this->db->where('id', $id);
		$this->db->delete('sc_tmp.deklarasi_dtl');
		redirect("trans/dinas/view_input_tmp/$nodok_ref/$nik");
	}

	function editdeklarasi_mst_tmp()
	{
		$nik = $this->input->post('nikum');
		$nodok_ref = $this->input->post('nodok_ref');
		$uangmuka = $this->input->post('uangmuka');
		$keterangan = $this->input->post('keterangan');
		$data = array(
			'uangmuka' => $uangmuka,
			'keterangan' => $keterangan,
			'status' => 'H', //UNTUK HITUNG ULANG
		);

		$this->db->where('nik', $nik);
		$this->db->where('nodok_ref', $nodok_ref);
		$this->db->update('sc_tmp.deklarasi_mst', $data);
		redirect("trans/dinas/view_input_tmp/$nodok_ref/$nik");
	}

	function editdeklarasi_dtl_tmp()
	{
		$branch = 'SBYNSA';
		$nik = $this->input->post('nikum');
		$nodok_ref = $this->input->post('nodokdinas');
		$type = strtoupper($this->input->post('type'));
		$tglclaim = $this->input->post('tglclaim');
		$km_awal = $this->input->post('kmawal');
		$km_akhir = $this->input->post('kmakhir');
		$bbm_liter = $this->input->post('bbmliter');
		$bbm_rupiah = $this->input->post('bbmrupiah');
		$parkir = $this->input->post('parkir');
		$tol = $this->input->post('tol');
		$uangsaku = $this->input->post('uangsaku');
		$laundry = $this->input->post('laundry');
		$transport = $this->input->post('transport');
		$lain = $this->input->post('lain');
		$total = $this->input->post('total');
		$sisa = $this->input->post('sisa');
		$uangmuka = $this->input->post('uangmuka');
		$keterangan = $this->input->post('keterangan');
		$nama = $this->session->userdata('nik');
		$id = $this->input->post('idnya');
		$data = array(
			'branch' => $branch,
			'nik' => $nik,
			'nodok' => $nama,
			'nodok_ref' => $nodok_ref,
			'tgl' => $tglclaim,
			'km_awal' => $km_awal,
			'km_akhir' => $km_akhir,
			'bbm_liter' => $bbm_liter,
			'bbm_rupiah' => $bbm_rupiah,
			'parkir' => $parkir,
			'tol' => $tol,
			'uangsaku' => $uangsaku,
			'laundry' => $laundry,
			'transport' => $transport,
			'lain' => $lain,
			'keterangan' => $keterangan,
			'update_date' => date('Y-m-d'),
			'update_by' => $nama,
		);

		$this->db->where('nik', $nik);
		$this->db->where('nodok_ref', $nodok_ref);
		$this->db->where('id', $id);
		$this->db->update('sc_tmp.deklarasi_dtl', $data);
		redirect("trans/dinas/view_input_tmp/$nodok_ref/$nik");
	}

	function final_deklarasi()
	{
		$nodok = $this->uri->segment(4);
		$nik = $this->uri->segment(5);
		$nodok_ref = $this->uri->segment(6);
		$uangmuka = $this->input->post('uangmuka');
		$keterangan = $this->input->post('keterangan');
		$data = array(
			'status' => 'P',
		);

		$this->db->where('nik', $nik);
		$this->db->where('nodok_ref', $nodok_ref);
		$this->db->update('sc_tmp.deklarasi_mst', $data);
		redirect("trans/dinas/deklarasi_dinas_tmp/$nodok_ref/$nik");
	}

	function create()
	{
		$this->load->library(array('datatablessp'));
		$this->load->model(array('m_employee'));
		if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
			$this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover', true)
				->columns('branch, nik, nmlengkap, nmdept, nmsubdept')
				->addcolumn('no', 'no')
				->addcolumn('createdinas', '<a href=\'' . site_url('trans/dinas/createdinas/$1') . '\' class=\'text-green\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Input Dinas</i></a>', 'branch, nik', true)
				->querystring($this->m_employee->q_mst_txt_where(' AND TRUE '))
				->header('No.', 'no', false, false, true)
				->header('Action', 'action', false, false, true, array('createdinas'))
				->header('<u>N</u>ik', 'nik', true, true, true)
				->header('<u>N</u>ama Karyawan', 'nmlengkap', true, true, true)
				->header('Departemen', 'nmdept', true, true, true, array('nmdept', 'nmsubdept'));
			$this->datatablessp->generateajax();
			$data['title'] = 'Input Dinas Pilih Karyawan';
			$this->template->display('trans/dinas/v_create', $data);
		} else if ($this->m_employee->q_mst_read_where(' AND search ILIKE \'%' . $this->session->userdata('nik') . '%\' ')->num_rows() > 1) {
			$this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover', true)
				->columns('branch, nik, nmlengkap, nmdept, nmsubdept')
				->addcolumn('no', 'no')
				->addcolumn('createdinas', '<a href=\'' . site_url('trans/dinas/createdinas/$1') . '\' class=\'text-green\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Input Dinas</i></a>', 'branch, nik', true)
				->querystring($this->m_employee->q_mst_txt_where(' AND search ILIKE \'%' . $this->session->userdata('nik') . '%\' '))
				->header('No.', 'no', false, false, true)
				->header('Action', 'action', false, false, true, array('createdinas'))
				->header('<u>N</u>ik', 'nik', true, true, true)
				->header('<u>N</u>ama Karyawan', 'nmlengkap', true, true, true)
				->header('Departemen', 'nmdept', true, true, true, array('nmdept', 'nmsubdept'));
			$this->datatablessp->generateajax();
			$data['title'] = 'Input Dinas Pilih Karyawan';
			$this->template->display('trans/dinas/v_create', $data);
		} else {
			redirect('trans/dinas/createdinas/' . bin2hex(json_encode(array('nik' => trim($this->session->userdata('nik'))))));
		}
	}

	function createdinas($param = null)
	{
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$data['default_date'] = date('d-m-Y 08:00');
		$data['opsi_dinas'] = null;
		if ($userhr == 0) {
			$opsi_dinas = $this->m_option->q_cekoption('BLKDN')->row();
			if ($opsi_dinas->status == "T") {
				$value = strtolower($opsi_dinas->value1);
				$value = str_replace("d", " day", $value);
				$data['default_date'] = json_encode(date('d-m-Y 08:00', strtotime($value)));
			}
		}
		$json = json_decode(
			hex2bin($param)
		);
        $level = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A';
		$this->load->library(array('datatablessp'));
		$this->load->model(array('m_employee'));
		$this->m_dinas->q_temporary_delete(array('nodok' => trim($this->session->userdata('nik'))));
		$this->template->display(
			'trans/dinas/v_createdinas',
			array(
                'userhr' => ($userhr or $level),
				'title' => 'Input Dinas Karyawan',
				'employee' => $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->nik . '\' ')->row(),
				'date' => $data['default_date'],
			)
		);
	}

	function docreate($param = null)
	{
		$json = json_decode(
			hex2bin($param)
		);
		$this->load->library(array('datatablessp'));
		$this->load->model(array('m_employee'));

		$no_telp = $this->input->post('no_telp');
		$jenis_tujuan = $this->input->post('jenis_tujuan');
		$tujuan_kota = $this->input->post('tujuan_kota');
		$kdkategori = $this->input->post('kdkategori');
		$keperluan = $this->input->post('keperluan');
		$callplan = $this->input->post('callplan');
		$tgl_mulai = date('Y-m-d', strtotime($this->input->post('tgl_mulai')));
		$jam_mulai = '00:00:00';
//		$jam_mulai = date('H:i:s', strtotime($this->input->post('tgl_mulai')));
		$tgl_selesai = date('Y-m-d', strtotime($this->input->post('tgl_selesai')));
		$jam_selesai = '23:59:59';
        $format_mulai = date('d-m-Y H:i', strtotime($tgl_mulai.' '.$jam_mulai));
//		$jam_selesai = date('H:i:s', strtotime($this->input->post('tgl_selesai')));
		$transportasi = $this->input->post('transportasi');
		$tipe_transportasi = $this->input->post('tipe_transportasi');
        $destination = implode(",",$tujuan_kota);
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();

		if (strtotime($tgl_mulai) > strtotime($tgl_selesai)){
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => '<b>Tanggal mulai</b> tidak boleh lebih besar dari <b>tanggal selesai</b>',
				)
			);
			exit();
		}
		if ($userhr == 0) {
			$opsi_dinas = $this->m_option->q_cekoption('BLKDN')->row();
			if ($opsi_dinas->status == "T") {
				$value = strtolower($opsi_dinas->value1);
				$value = str_replace("d", " day", $value);
//                var_dump(date('Y-m-d H:i', strtotime($format_mulai)),date('Y-m-d 08:00', strtotime($value)));die();
//				if ($this->input->post('tgl_mulai') < date('d-m-Y 08:00', strtotime($value))) {
//				if (date('Y-m-d H:i', strtotime($format_mulai)) < date('Y-m-d 08:00', strtotime($value))) {
				if (date('Y-m-d', strtotime($tgl_mulai)) < date('Y-m-d', strtotime($value))) {
					header('Content-Type: application/json');
					http_response_code(404);
					echo json_encode(
						array(
							'data' => array(),
							'message' => 'Tanggal Dinas Minimal H-1'
						)
					);
				} else {
					$employee = $this->m_employee->q_mst_read_where(' AND branch = \'' . $json->branch . '\' AND nik = \'' . $json->nik . '\' ')->row();
					if (
						$this->m_dinas->q_transaction_read_where(' 
            AND nik = \'' . $employee->nik . '\' 
            AND (tgl_mulai::DATE >= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE >= \'' . $tgl_mulai . '\'::DATE)
            AND (tgl_mulai::DATE <= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE <= \'' . $tgl_mulai . '\'::DATE) 
            AND (status = \'P\' OR status = \'A\' )
            ')->num_rows() > 0
					) {
						header('Content-Type: application/json');
						http_response_code(404);
						echo json_encode(
							array(
								'data' => array(),
								'message' => 'Data dinas karyawan sudah pernah dibuat diantara periode tersebut'
							)
						);
					} else {
						$this->db->trans_start();
						if (
							$this->m_dinas->q_temporary_create(
								array(
									'nik' => $employee->nik,
									'nodok' => trim($this->session->userdata('nik')),
									'tgl_dok' => date('Y-m-d'),
//									'nmatasan' => $employee->nmatasan,
									'nmatasan' => $employee->nik_atasan,
									'tgl_mulai' => $tgl_mulai,
									'jam_mulai' => $jam_mulai,
									'tgl_selesai' => $tgl_selesai,
									'jam_selesai' => $jam_selesai,
									'keperluan' => strtoupper($keperluan),
									'callplan' => $callplan,
									'tujuan_kota' => $destination,
									'input_date' => date('Y-m-d H:i:s'),
									'input_by' => trim($this->session->userdata('nik')),
									'kdkategori' => $kdkategori,
									'transportasi' => $transportasi,
									'tipe_transportasi' => $tipe_transportasi,
									'jenis_tujuan' => $jenis_tujuan,
									'no_telp' => $no_telp,
									'status' => 'I',
								)
							) && $this->m_dinas->q_temporary_update(
								array(
									'status' => 'F',
								),
								array(
									'nik' => $employee->nik,
									'nodok' => $this->session->userdata('nik'),
								)
							)
						) {
							$this->db->trans_complete();
							$transaction = $this->m_dinas->q_transaction_read_where(' 
                    AND nik = \'' . $employee->nik . '\' 
                    AND input_by = \'' . trim($this->session->userdata('nik')) . '\' 
                    ORDER BY input_date DESC 
                    ')->row();
							header('Content-Type: application/json');
							if (!is_null($transaction) && !is_nan($transaction)) {
								echo json_encode(
									array(
										'data' => $transaction,
										'message' => 'Data dinas karyawan berhasil dibuat dengan nomer <b>' . $transaction->nodok . '</b>'
									)
								);
							} else {
								http_response_code(404);
								echo json_encode(
									array(
										'data' => array(),
										'message' => 'Data dinas karyawan gagal dibuat'
									)
								);
							}
						}
					}
				}
			}
		} else {
			$employee = $this->m_employee->q_mst_read_where(' AND branch = \'' . $json->branch . '\' AND nik = \'' . $json->nik . '\' ')->row();
			if (
				$this->m_dinas->q_transaction_read_where(' 
            AND nik = \'' . $employee->nik . '\' 
            AND (tgl_mulai::DATE >= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE >= \'' . $tgl_mulai . '\'::DATE)
            AND (tgl_mulai::DATE <= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE <= \'' . $tgl_mulai . '\'::DATE) 
            AND (status = \'P\' OR status = \'A\' )
            ')->num_rows() > 0
			) {
				header('Content-Type: application/json');
				http_response_code(404);
				echo json_encode(
					array(
						'data' => array(),
						'message' => 'Data dinas karyawan sudah pernah dibuat diantara periode tersebut'
					)
				);
			} else {
				$this->db->trans_start();
				if (
					$this->m_dinas->q_temporary_create(
						array(
							'nik' => $employee->nik,
							'nodok' => trim($this->session->userdata('nik')),
							'tgl_dok' => date('Y-m-d'),
//							'nmatasan' => $employee->nmatasan,
							'nmatasan' => $employee->nik_atasan,
							'tgl_mulai' => $tgl_mulai,
							'jam_mulai' => $jam_mulai,
							'tgl_selesai' => $tgl_selesai,
							'jam_selesai' => $jam_selesai,
							'keperluan' => strtoupper($keperluan),
							'callplan' => $callplan,
							'tujuan_kota' => $destination,
							'input_date' => date('Y-m-d H:i:s'),
							'input_by' => trim($this->session->userdata('nik')),
							'kdkategori' => $kdkategori,
							'transportasi' => $transportasi,
							'tipe_transportasi' => $tipe_transportasi,
							'jenis_tujuan' => $jenis_tujuan,
							'no_telp' => $no_telp,
							'status' => 'I',
						)
					) && $this->m_dinas->q_temporary_update(
						array(
							'status' => 'F',
						),
						array(
							'nik' => $employee->nik,
							'nodok' => $this->session->userdata('nik'),
						)
					)
				) {
					$this->db->trans_complete();
					$transaction = $this->m_dinas->q_transaction_read_where(' 
                    AND nik = \'' . $employee->nik . '\' 
                    AND input_by = \'' . trim($this->session->userdata('nik')) . '\' 
                    ORDER BY input_date DESC 
                    ')->row();
					header('Content-Type: application/json');
					if (!is_null($transaction) && !is_nan($transaction)) {
						echo json_encode(
							array(
								'data' => $transaction,
								'message' => 'Data dinas karyawan berhasil dibuat dengan nomer <b>' . $transaction->nodok . '</b>'
							)
						);
					} else {
						http_response_code(404);
						echo json_encode(
							array(
								'data' => array(),
								'message' => 'Data dinas karyawan gagal dibuat'
							)
						);
					}
				}
			}
		}
	}

	function docancel()
	{
		$this->db->trans_start();
		if ($this->m_dinas->q_temporary_delete(array('nodok' => trim($this->session->userdata('nik')))) && $this->m_dinas->q_temporary_delete(array('update_by' => trim($this->session->userdata('nik'))))) {
			$this->db->trans_complete();
			header('Content-Type: application/json');
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Data dinas karyawan berhasil direset'
				)
			);
		}
	}

	function updatedinas($param = null)
	{
		$json = json_decode(
			hex2bin($param)
		);
		$this->load->library(array('datatablessp'));
		$this->load->model(array('M_TrxType', 'm_employee', 'M_DestinationType', 'M_Kategori', 'M_CityCashbon', ));
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        $level = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A';
		$this->db->trans_start();
		$this->m_dinas->q_temporary_delete(array('update_by' => trim($this->session->userdata('nik'))));
		$edited = $this->m_dinas->q_temporary_read_where(' 
            AND nik = \'' . $json->nik . '\' 
            AND nodok = \'' . $json->nodok . '\' 
            AND TRIM(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY update_date DESC 
            ')->row();
		if (!is_null($edited) && !is_nan($edited)) {
			$this->flashmessage
				->set(array('Data dinas dinas karyawan nomer <b>' . $edited->nodok . '</b> sedang diupdate oleh <b>' . $edited->update_by . '</b>', 'warning'))
				->redirect('trans/dinas/');
		}
		$this->m_dinas->q_transaction_update(
			array(
				'status' => 'U',
				'update_by' => trim($this->session->userdata('nik')),
				'update_date' => date('Y-m-d H:i:s'),
			),
			array(
				'nik' => $json->nik,
				'nodok' => $json->nodok,
			)
		);
		$temporary = $this->m_dinas->q_temporary_read_where(' 
            AND nik = \'' . $json->nik . '\' 
            AND nodok = \'' . $json->nodok . '\' 
            AND update_by = \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY update_date DESC 
            ')->row();
		if (!is_null($temporary) && !is_nan($temporary)) {
            $destinationIn = "'".implode("','",explode(",",$temporary->tujuan_kota))."'";
			$this->db->trans_complete();
            if ($temporary->status == 'P' AND date('Y-m-d') >= $temporary->tgl_mulai AND $json->config == 'extend'){
                $canextend = TRUE;
                $content = 'trans/dinas/v_updatedinas_hasapproved';
            }else{
                $canextend = FALSE;
                $content = 'trans/dinas/v_updatedinas';
            }
			$this->template->display(
				$content,
				array(
					'title' => 'Update Dinas Karyawan : <b>' . $temporary->nodok . '</b>',
					'employee' => $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->nik . '\' ')->row(),
                    'canextend' => $canextend,
                    'userhr' => ($userhr OR $level),
                    'level_akses' => $level_akses,
					'default' => json_decode(
						json_encode(
							array(
								'temporary' => $temporary,
								'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $temporary->jenis_tujuan . '\' ')->result(),
//								'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $temporary->tujuan_kota . '\' ')->result(),
                                'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id IN ('.$destinationIn.') AND a.group = \''.$temporary->jenis_tujuan.'\'  ')->result(),
								'kategori' => $this->M_Kategori->q_master_search_where(' AND id = \'' . $temporary->kdkategori . '\' ')->result(),
								'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \'' . $temporary->transportasi . '\' ')->result(),
								'tipe_transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSPTYPE\' AND id = \'' . $temporary->tipe_transportasi . '\' ')->result(),
							)
						)
					),
				)
			);
		}
	}

	function doupdate($param = null)
	{
		$json = json_decode(
			hex2bin($param)
		);
		$this->load->library(array('datatablessp'));
		$this->load->model(array('m_employee'));

		$no_telp = $this->input->post('no_telp');
		$jenis_tujuan = $this->input->post('jenis_tujuan');
		$tujuan_kota = $this->input->post('tujuan_kota');
		$kdkategori = $this->input->post('kdkategori');
		$keperluan = $this->input->post('keperluan');
		$callplan = $this->input->post('callplan');
		$tgl_mulai = date('Y-m-d', strtotime($this->input->post('tgl_mulai')));
		$jam_mulai = '00:00:00';
        $format_mulai = date('d-m-Y H:i', strtotime($tgl_mulai.' '.$jam_mulai));
//		$jam_mulai = date('H:i:s', strtotime($this->input->post('tgl_mulai')));
		$tgl_selesai = date('Y-m-d', strtotime($this->input->post('tgl_selesai')));
		$jam_selesai = '00:00:00';
//		$jam_selesai = date('H:i:s', strtotime($this->input->post('tgl_selesai')));
		$transportasi = $this->input->post('transportasi');
		$tipe_transportasi = $this->input->post('tipe_transportasi');
        $destination = implode(",",$tujuan_kota);
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		if (strtotime($tgl_mulai) > strtotime($tgl_selesai)){
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => '<b>Tanggal mulai</b> tidak boleh lebih besar dari <b>tanggal selesai</b>',
				)
			);
			exit();
		}
		if ($userhr == 0) {
			$opsi_dinas = $this->m_option->q_cekoption('BLKDN')->row();
			if ($opsi_dinas->status == "T") {
				$value = strtolower($opsi_dinas->value1);
				$value = str_replace("d", " day", $value);
                if (date('Y-m-d', strtotime($format_mulai)) < date('Y-m-d', strtotime($value)) AND $json->config == 'update' ) {
					header('Content-Type: application/json');
					http_response_code(404);
					echo json_encode(
						array(
							'data' => array(),
							'message' => 'Pengajuan Tanggal Berangkat Dinas Minimal H-1'
						)
					);
				} else {
					if (
						$this->m_dinas->q_transaction_read_where(' 
						AND nik = \'' . $json->nik . '\' 
						AND (tgl_mulai::DATE >= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE >= \'' . $tgl_mulai . '\'::DATE)
						AND (tgl_mulai::DATE <= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE <= \'' . $tgl_mulai . '\'::DATE) 
						AND (status = \'P\' OR status = \'A\' )
						AND nodok <> \'' . $json->nodok . '\' 
						')->num_rows() > 0
					) {
						header('Content-Type: application/json');
						http_response_code(404);
						echo json_encode(
							array(
								'data' => array(),
								'message' => 'Data dinas karyawan sudah pernah dibuat diantara periode tersebut'
							)
						);
					} else {
						$this->db->trans_start();
						$temporary = $this->m_dinas->q_temporary_read_where(' AND nik = \'' . $json->nik . '\' AND nodok = \'' . $json->nodok . '\' ')->row();
						if (
							$this->m_dinas->q_temporary_update(
								array(
									'nik' => $temporary->nik,
									'nodok' => $json->nodok,
									'tgl_mulai' => $tgl_mulai,
									'jam_mulai' => $jam_mulai,
									'tgl_selesai' => $tgl_selesai,
									'jam_selesai' => $jam_selesai,
									'keperluan' => strtoupper($keperluan),
									'callplan' => $callplan,
									'tujuan_kota' => $destination,
									'update_date' => date('Y-m-d H:i:s'),
									'update_by' => trim($this->session->userdata('nik')),
									'kdkategori' => $kdkategori,
									'transportasi' => $transportasi,
									'tipe_transportasi' => $tipe_transportasi,
									'jenis_tujuan' => $jenis_tujuan,
									'no_telp' => $no_telp,
									'status' => ($json->config == 'update' ? 'U' : 'EX'),
								),
								array(
									'nik' => $temporary->nik,
									'nodok' => $temporary->nodok,
								)
							)
						) {
							$this->db->trans_complete();
							$transaction = $this->m_dinas->q_transaction_read_where(' 
								AND nik = \'' . $temporary->nik . '\' 
								AND input_by = \'' . trim($this->session->userdata('nik')) . '\' 
								ORDER BY input_date DESC 
								')->row();
							header('Content-Type: application/json');
							if (!is_null($transaction) && !is_nan($transaction)) {
								echo json_encode(
									array(
										'data' => $transaction,
										'message' => 'Data dinas karyawan berhasil dibuat dengan nomer <b>' . $transaction->nodok . '</b>'
									)
								);
							} else {
								echo json_encode(
									array(
										'data' => array(),
										'message' => 'Data dinas karyawan gagal dibuat'
									)
								);
							}
						}
					}
				}
			}
		} else {

			if (
				$this->m_dinas->q_transaction_read_where(' 
				AND nik = \'' . $json->nik . '\' 
				AND (tgl_mulai::DATE >= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE >= \'' . $tgl_mulai . '\'::DATE)
				AND (tgl_mulai::DATE <= \'' . $tgl_selesai . '\'::DATE OR tgl_selesai::DATE <= \'' . $tgl_mulai . '\'::DATE) 
				AND (status = \'P\' OR status = \'A\' )
				AND nodok <> \'' . $json->nodok . '\' 
				')->num_rows() > 0
			) {
				header('Content-Type: application/json');
				http_response_code(404);
				echo json_encode(
					array(
						'data' => array(),
						'message' => 'Data dinas karyawan sudah pernah dibuat diantara periode tersebut'
					)
				);
			} else {
				$this->db->trans_start();
				$temporary = $this->m_dinas->q_temporary_read_where(' AND nik = \'' . $json->nik . '\' AND nodok = \'' . $json->nodok . '\' ')->row();
                if ($json->config != 'update') {
                    $destination = $temporary->tujuan_kota;
                }
				if (
					$this->m_dinas->q_temporary_update(
						array(
							'nik' => $temporary->nik,
							'nodok' => $json->nodok,
							'tgl_mulai' => $tgl_mulai,
							'jam_mulai' => $jam_mulai,
							'tgl_selesai' => $tgl_selesai,
							'jam_selesai' => $jam_selesai,
							'keperluan' => strtoupper($keperluan),
							'callplan' => $callplan,
							'tujuan_kota' => $destination,
							'update_date' => date('Y-m-d H:i:s'),
							'update_by' => trim($this->session->userdata('nik')),
							'kdkategori' => $kdkategori,
							'transportasi' => $transportasi,
							'tipe_transportasi' => $tipe_transportasi,
							'jenis_tujuan' => $jenis_tujuan,
							'no_telp' => $no_telp,
							'status' => 'U',
						),
						array(
							'nik' => $temporary->nik,
							'nodok' => $temporary->nodok,
						)
					)
				) {
					$this->db->trans_complete();
					$transaction = $this->m_dinas->q_transaction_read_where(' 
						AND nik = \'' . $temporary->nik . '\' 
						AND input_by = \'' . trim($this->session->userdata('nik')) . '\' 
						ORDER BY input_date DESC 
						')->row();
					header('Content-Type: application/json');
					if (!is_null($transaction) && !is_nan($transaction)) {
						echo json_encode(
							array(
								'data' => $transaction,
								'message' => 'Data dinas karyawan berhasil diubah dengan nomer <b>' . $transaction->nodok . '</b>'
							)
						);
					} else {
						echo json_encode(
							array(
								'data' => array(),
								'message' => 'Data dinas karyawan gagal dibuat'
							)
						);
					}
				}
			}
		}
	}

	function detaildinas($param = null)
	{
		$json = json_decode(
			hex2bin($param)
		);
		$this->load->library(array('datatablessp'));
		$this->load->model(array('M_TrxType', 'm_employee', 'M_DestinationType', 'M_Kategori', 'M_CityCashbon', ));
		$transaction = $this->m_dinas->q_transaction_read_where(' AND nik = \'' . $json->nik . '\' AND nodok = \'' . $json->nodok . '\' ')->row();
		if (!is_null($transaction) && !is_nan($transaction)) {
            $destinationIn = "'".implode("','",explode(",",$transaction->tujuan_kota))."'";
			$this->template->display(
				'trans/dinas/v_detaildinas',
				array(
					'title' => 'Detail Dinas Karyawan : <b>' . $transaction->nodok . '</b>',
					'employee' => $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->nik . '\' ')->row(),
					'canapprove' => $this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->m_employee->q_mst_read_where(' AND search ILIKE \'%' . $this->session->userdata('nik') . '%\' ')->num_rows() > 1,
					'default' => json_decode(
						json_encode(
							array(
								'transaction' => $transaction,
								'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $transaction->jenis_tujuan . '\' ')->row(),
//								'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $transaction->tujuan_kota . '\' ')->row(),
                                'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id IN ('.$destinationIn.') AND a.group = \''.$transaction->jenis_tujuan.'\' ')->result(),
								'kategori' => $this->M_Kategori->q_master_search_where(' AND id = \'' . $transaction->kdkategori . '\' ')->row(),
								'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \'' . $transaction->transportasi . '\' ')->row(),
								'tipe_transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSPTYPE\' AND id = \'' . $transaction->tipe_transportasi . '\' ')->row(),
							)
						)
					),
				)
			);
		}
	}
	function doapprove($param = null)
	{
		$json = json_decode(
			hex2bin($param)
		);
		$this->load->library(array('datatablessp'));
		$this->load->model(array('m_employee'));
		$edited = $this->m_dinas->q_temporary_read_where(' 
            AND nik = \'' . $json->nik . '\' 
            AND nodok = \'' . $json->nodok . '\' 
            AND TRIM(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY update_date DESC 
            ')->row();
		if (!is_null($edited) && !is_nan($edited)) {
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Data dinas dinas karyawan nomer <b>' . $edited->nodok . '</b> sedang diupdate oleh <b>' . $edited->update_by . '</b>'
				)
			);
			exit;
		}
		$this->m_dinas->q_transaction_update(
			array(
				'status' => 'P',
				'approval_by' => trim($this->session->userdata('nik')),
				'approval_date' => date('Y-m-d H:i:s'),
			),
			array(
				'nik' => $json->nik,
				'nodok' => $json->nodok,
			)
		);
		$transaction = $this->m_dinas->q_transaction_read_where(' 
            AND nik = \'' . $json->nik . '\' 
            AND nodok = \'' . $json->nodok . '\' 
            AND TRIM(approval_by) = \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY approval_date DESC 
            ')->row();
		if (!is_null($transaction) && !is_nan($transaction)) {
			echo json_encode(
				array(
					'data' => $transaction,
					'message' => 'Data dinas karyawan berhasil disetujui'
				)
			);
		} else {
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Data dinas karyawan gagal disetujui'
				)
			);
		}
	}
	function dodelete($param = null)
	{
		$json = json_decode(
			hex2bin($param)
		);
		$this->load->library(array('datatablessp'));
		$this->load->model(array('m_employee'));
		$edited = $this->m_dinas->q_temporary_read_where(' 
            AND nik = \'' . $json->nik . '\' 
            AND nodok = \'' . $json->nodok . '\' 
            AND TRIM(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY update_date DESC 
            ')->row();
		if (!is_null($edited) && !is_nan($edited)) {
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Data dinas dinas karyawan nomer <b>' . $edited->nodok . '</b> sedang diupdate oleh <b>' . $edited->update_by . '</b>'
				)
			);
			exit;
		}
		$transaction = $this->m_dinas->q_transaction_read_where(' AND nik = \'' . $json->nik . '\' AND nodok = \'' . $json->nodok . '\' ')->row();
		$this->m_dinas->q_transaction_update(
			array(
				'status' => 'C',
				'cancel_date' => date('Y-m-d'),
				'cancel_by' => trim($this->session->userdata('nik')),
			),
			array(
				'nik' => $json->nik,
				'nodok' => $json->nodok,
			)
		);
		if (!is_null($transaction) && !is_nan($transaction)) {
			echo json_encode(
				array(
					'data' => $transaction,
					'message' => 'Data dinas karyawan berhasil dibatalkan'
				)
			);
		} else {
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Data dinas karyawan gagal dibatalkan'
				)
			);
		}
	}

    public function dutiecheck()
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->load->model(array('trans/M_Dinas'));
        $begindate = date('Y-m-d', strtotime($data->body->begindate));
        $enddate = date('Y-m-d', strtotime($data->body->enddate));
        $nik = $data->body->nik;
        if ($this->M_Dinas->q_transaction_read_where(' AND nik = \''.$nik.'\' AND status = \'P\' AND ( tgl_mulai between \''.$begindate.'\' AND \''.$enddate.'\' OR tgl_selesai between \''.$begindate.'\' AND \''.$enddate.'\' ) ')->num_rows() > 0){
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Ada dokumen dinas di rentang tanggal tersebut',
            ));
        }else{
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(array(
                'data' => array(),
                'message' => 'OKE',
            ));
        }
    }

    public function search() {
        $this->load->model(array('trans/m_dinas', 'master/m_option'));
        header('Content-Type: application/json');
        $filter = ' AND status = \'P\'  ';
        $setup= $this->m_option->read(' AND kdoption =\'DUTIE:LIMIT:DATE\' AND group_option = \'DINAS\' ');
        $limitDate = (($setup->num_rows() > 0) ? $setup->row()->value1 : date('Ym') );
        $filter .= ' AND TO_CHAR(tgl_dok,\'yyyymm\') >= \''.$limitDate.'\' ';
        if (!is_null($this->input->get_post('user'))){
            $filter .= ' AND nik = \''.$this->input->get_post('user').'\' ';
        }
        if (!empty($setup)){
            $filter .= ' AND to_char(input_date, \'yyyy-mm-dd\') >= \''.$setup.'\' ';
        }else{
            $filter .= ' AND to_char(input_date, \'yyyy-mm-dd\') >= \'2023-01-01\' ';
        }
        if (!is_null($this->input->get_post('config'))){
            switch (strtoupper($this->input->get_post('config'))){
                case "CREATE":
                    $filter .= ' AND (COALESCE(TRIM(nodok), \'\') NOT IN ( SELECT unnest(string_to_array(trim(dutieid),\',\')) FROM sc_trx.cashbon WHERE TRUE AND (status IN (\'P\',\'I\') ) )) ';
                    $filter .= ' AND (COALESCE(TRIM(nodok), \'\') NOT IN ( SELECT unnest(string_to_array(trim(dutieid),\',\')) FROM sc_trx.declaration_cashbon WHERE TRUE AND (status IN (\'P\',\'I\') ) )) ';
                    break;
                case "UPDATE":
//                    var_dump('dddd');die();
                    $cashbonid = (!is_null($this->input->get_post('cashbonid')) ? $this->input->get_post('cashbonid') : null );
                    $filter .= ' AND (COALESCE(TRIM(nodok), \'\') NOT IN ( SELECT unnest(string_to_array(trim(dutieid),\',\')) FROM sc_trx.cashbon WHERE TRUE AND (status IN (\'P\',\'I\') ) AND cashbonid <> \''.$cashbonid.'\'  )) ';
                    $filter .= ' AND (COALESCE(TRIM(nodok), \'\') NOT IN ( SELECT unnest(string_to_array(trim(dutieid),\',\')) FROM sc_trx.declaration_cashbon WHERE TRUE AND (status IN (\'P\',\'I\') ) AND cashbonid <> \''.$cashbonid.'\'  )) ';
                    break;
            }
        }
    //    var_dump($filter);die();
        $count = $this->m_dinas->q_transaction_read_where($filter.'
			
			')->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->m_dinas->q_transaction_read_where($filter.'
            
            AND ( LOWER(id) LIKE \'%'.$search.'%\'
            OR LOWER(text) LIKE \'%'.$search.'%\'
            )
            ORDER BY tgl_dok DESC
            LIMIT '.$perpage.' OFFSET '.$limit.'
            ')->result();
        echo json_encode(array(
            'totalcount' => $count,
            'search' => $search,
            'perpage' => $perpage,
            'page' => $page,
            'limit' => $limit,
            'location' => $result
        ), JSON_NUMERIC_CHECK);
    }

}