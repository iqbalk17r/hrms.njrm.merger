<?php

/**
 * author : Fiky Ashariza
 * modifier: DK
 */

class Pk extends MX_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('master/m_akses', 'm_pk', 'master/M_ApprovalRule'));
		$this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'Excel_generator', 'zip', 'Fiky_report', 'PHPExcel/PHPExcel/IOFactory'));

		if (!$this->session->userdata('nik')) {
			redirect('dashboard');
		}
	}

	function index()
	{
		$data['title'] = "SELAMAT DATANG DI PROGRAM PERFORMACE APPRAISAL KARYAWAN";
		$this->template->display('pk/pk/v_index', $data);
	}
	function underconstruction()
	{
		$data['title'] = "!!!!! WARNING ......... !!  UNDER CONSTRUCTION";
		$this->template->display('pk/pk/v_index', $data);
	}

	function form_pk()
	{
		$data['title'] = "PERFORMANCE APPRAISAL";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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

		/*cek jika ada inputan edit atau input */
		$param3_1_1 = " and nodok='$nama' and status='I'";
		$param3_1_2 = " and nodok='$nama' and status='E'";
		$param3_1_3 = " and nodok='$nama' and status in ('A','AP')";
		$param3_1_4 = " and nodok='$nama' and status='C'";
		$param3_1_5 = " and nodok='$nama' and status='H'";
		$param3_1_6 = " and nodok='$nama' and status='R'";
		$param3_1_7 = " and nodok='$nama' and status='O'";
		$param3_1_R = " and nodok='$nama'";
		$cekmst_na = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_1)->num_rows(); //input
		$cekmst_ne = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_2)->num_rows(); //edit
		$cekmst_napp = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_7)->num_rows(); //approv
		$cekmst_cancel = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_4)->num_rows(); //cancel
		$cekmst_hangus = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_5)->num_rows(); //hangus
		$cekmst_ra = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_6)->num_rows(); //REALISASI
		$cekmst_ch = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_7)->num_rows(); //REALISASI
		$dtledit = $this->m_pk->q_tx_form_pa_tmp_mst($param3_1_R)->row_array(); //edit row array


		if ($cekmst_na > 0) { //cek inputan
			$enc_nik = $this->fiky_encryption->enkript((trim($dtledit['nik'])));
			$enc_periode = $this->fiky_encryption->enkript((trim($dtledit['periode'])));
			redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
		} else if ($cekmst_ne > 0) { //cek edit
			$enc_nik = $this->fiky_encryption->enkript((trim($dtledit['nik'])));
			$enc_periode = $this->fiky_encryption->enkript((trim($dtledit['periode'])));
			redirect("pk/pk/edit_generate_pa/$enc_nik/$enc_periode");
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		// $userhr=$this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$fnik = strtoupper(trim($this->input->post('nik')));
		$cek_option_pa = $this->m_pk->q_pk_atasan()->num_rows();

		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}
		;

		if (!empty($startPeriode) and !empty($endPeriode)) {
			$param_postperiode = " and periode='$periode' ";
		} else {
			// $periode = date('Ym');
			// $param_postperiode = " and periode='$periode' ";
			$param_postperiode = " ";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and (nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))) ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and (nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))) ";
		} else if ($userhr > 0) {
			$param_list_akses = "";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;
		$data['cek_option_pa'] = $cek_option_pa;
		$data['ceknikatasan1'] = $ceknikatasan1;
		$data['ceknikatasan2'] = $ceknikatasan2;
		$data['range_option'] = trim($this->m_pk->q_option(['kdoption' => 'PKPARP', 'status' => 'T'])->row()->value1);
		$data['range_option_semester'] = trim($this->m_pk->q_option(['kdoption' => 'PKPARPS', 'status' => 'T'])->row()->value1);
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($param_list_akses)->result();
		$data['list_tx_pa'] = $this->m_pk->q_view_generate_kriteria($paramnya)->result();

		$data['year'] = $this->m_pk->q_option(['kdoption' => 'PKPAPY'])->row()-value3;
		$this->template->display('pk/pk/v_list_form_pa', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function list_nik_from_nik_atasan()
	{
		$nama = trim($this->session->userdata('nik'));
		$startPeriode = str_replace('-', '', trim($this->input->post('startPeriode')));
		$endPeriode = str_replace('-', '', trim($this->input->post('endPeriode')));
		$periode = $startPeriode . '-' . $endPeriode;

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') 
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x) ";
		} else if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x)";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses_nik = " and nik='$nama' 
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x)";
			} else {
				$param_list_akses_nik = "
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x)";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;
		$data['periode'] = $periode;
		$formatPeriode = date("m Y", strtotime(substr($startPeriode, 0, 4) . '-' . substr($startPeriode, 4) . '-01')) . ' S/D ' . date("m Y", strtotime(substr($endPeriode, 0, 4) . '-' . substr($endPeriode, 4) . '-01'));
		$data['title'] = "PILIH KARYAWAN INTUK INPUT PENILAIAN KARYAWAN PERIODE $formatPeriode";

		//$data['list_nik']=$this->m_akses->q_master_akses_karyawan($param_list_akses_nik)->result();
		$this->template->display('pk/pk/v_list_nik_from_nikatasan', $data);
	}

	function list_paginate_input_nik_pa($periode)
	{
		$nama = $this->session->userdata('nik');
		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$hr = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'PST\' AND groupid =\'PA\' ');
		if ($this->m_pk->q_pk_atasan()->num_rows() > 0) {
			$option = false;
		} else {
			$option = $hr;
		}
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if ($ceknikatasan2 > 0 and !$option) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') 
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x) ";
		} else if ($ceknikatasan1 > 0 and !$option) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x)";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses_nik = " and nik='$nama' 
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x)";
			} else {
				$param_list_akses_nik = "
									and nik not in 
									(select distinct nik from (
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')
									union all
									select nik from sc_pk.pa_form_pa_trx_mst where periode='$periode' and coalesce(status,'') not in ('D','C')) as x)";
			}
		}

		$list = $this->m_pk->get_t_lv_karyawan_kondite($param_list_akses_nik);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lm) {
			$enc_nik = $this->fiky_encryption->enkript($lm->nik);
			$enc_periode = $this->fiky_encryption->enkript($periode);
			$no++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="' . site_url("pk/pk/input_generate_pa/$enc_nik/$enc_periode") . '" class="btn btn-info  btn-sm">
                                        <i class="fa fa-edit"></i> Input PA
                                    </a>';
			$row[] = $lm->nik;
			$row[] = $lm->nmlengkap;
			$row[] = $lm->nmdept;
			$row[] = $periode;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_pk->t_lv_karyawan_kondite_count_all($param_list_akses_nik),
			"recordsFiltered" => $this->m_pk->t_lv_karyawan_kondite_count_filtered($param_list_akses_nik),
			"data" => $data,
		);
		echo $this->fiky_encryption->jDatatable($output);
	}

	function input_generate_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$param_following = " and nik='$nik' and nikatasan='$nama'";
		$cek_first_tmp = $this->m_pk->q_tx_form_pa_tmp_mst($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_tx_form_pa_trx_mst($param_first)->num_rows();
		$cek_folowing_nik = $this->m_pk->q_folowing_atasan($param_following)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_tx_form_pa_tmp_mst($param_first)->row_array();
		$cek_option_pa = $this->m_pk->q_pk_atasan()->num_rows();
		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/form_pk");
			}
		} else if ($cek_folowing_nik == 0 and $cek_option_pa > 0) {  //cek nik terkait dan option pa
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 8,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/form_pk");
		}
		if ($cek_first_trx > 0) {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 1,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/form_pk");
		}

		if ($cek_first_tmp == 0 and $cek_first_trx == 0) {
			$this->db->query("select sc_pk.pr_pk_generate_nik('$nama', '$periode', '$nik')");
		}


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$tahun = substr($periode, 0, 4);
		$array_period = explode('-', $periode);
		$param_list_kondite = " and a.nik='$nik' and periode between '$array_period[0]' and '$array_period[1]'";
		$param_list_kpi = " and nik='$nik' and tahun='$tahun'";
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' INPUT PERFORMA APPRAISAL ';
		$data['nama'] = $nama;

		if ($cek_option_pa > 0) {
			$data['dtlrow'] = $this->m_pk->q_tx_form_pa_tmp_mst($param_list_akses)->row_array();
		} else {
			$data['dtlrow'] = $this->m_pk->q_tx_form_pa_tmp_mst_nonatasan($param_list_akses)->row_array();
		}

		$data['cek_option_pa'] = $cek_option_pa;

		$data['list_report_kondite'] = $this->m_pk->q_summary_kondite_report($param_list_kondite)->result();
		$data['list_report_kpi'] = $this->m_pk->q_list_kpi_report_yearly($param_list_kpi)->result();
		$data['list_tmp_pa_mst'] = $this->m_pk->q_tx_form_pa_tmp_mst($param_list_akses)->result();
		$data['list_tmp_pa_dtl'] = $this->m_pk->q_tx_form_pa_tmp_dtl($param_list_akses)->result();
		$data['list_question'] = $this->m_pk->list_pa_questions()->result();
		$this->template->display('pk/pk/v_input_form_pa', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function get_pa_questions()
	{

	}

	function edit_generate_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$param_following = " and nik='$nik' and nikatasan='$nama'";
		$cek_first_tmp = $this->m_pk->q_tx_form_pa_tmp_mst($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_tx_form_pa_tmp_mst($param_first)->row_array();
		$cek_first_trx = $this->m_pk->q_tx_form_pa_trx_mst($param_first)->num_rows();
		$cek_folowing_nik = $this->m_pk->q_folowing_atasan($param_following)->num_rows();
		$cek_option_pa = $this->m_pk->q_pk_atasan()->num_rows();

		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/form_pk");
			}
		} else if ($cek_folowing_nik == 0 and $cek_option_pa > 0) {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 8,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/form_pk");
		}

		if ($cek_first_tmp == 0) {
			$info = array(
				'status' => 'E',
				'updateby' => $inputby,
				'updatedate' => $inputdate,
			);
			$this->db->where('nik', $nik);
			$this->db->where('periode', $periode);
			$this->db->update('sc_pk.pa_form_pa_trx_mst', $info);
		}

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' UBAH DATA PERFORMA APPRAISAL ATASAN ';
		$data['nama'] = $nama;

		if ($cek_option_pa > 0) {
			$data['dtlrow'] = $this->m_pk->q_tx_form_pa_tmp_mst($param_list_akses)->row_array();
		} else {
			$data['dtlrow'] = $this->m_pk->q_tx_form_pa_tmp_mst_nonatasan($param_list_akses)->row_array();
		}

		$data['cek_option_pa'] = $cek_option_pa;

		$data['list_tmp_pa_mst'] = $this->m_pk->q_tx_form_pa_tmp_mst($param_list_akses)->result();
		$data['list_tmp_pa_dtl'] = $this->m_pk->q_tx_form_pa_tmp_dtl($param_list_akses)->result();
		$data['list_question'] = $this->m_pk->list_pa_questions()->result();
		$this->template->display('pk/pk/v_edit_form_pa', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function detail_generate_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$cek_option_pa = $this->m_pk->q_pk_atasan()->num_rows();
		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}

		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$approver = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'PST\' AND groupid =\'PA\' ');

		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' DETAIL DATA PERFORMA APPRAISAL ATASAN ';
		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['approver'] = $approver;
		$data['cek_option_pa'] = $cek_option_pa;
		$data['dtlrow'] = $this->m_pk->q_tx_form_pa_trx_mst($param_list_akses)->row_array();
		$data['list_trx_pa_mst'] = $this->m_pk->q_tx_form_pa_trx_mst($param_list_akses)->result();
		$data['list_trx_pa_dtl'] = $this->m_pk->q_tx_form_pa_trx_dtl($param_list_akses)->result();
		$data['list_question'] = $this->m_pk->list_pa_questions()->result();
		$this->template->display('pk/pk/v_detail_form_pa', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function delete_generate_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' HAPUS DATE DATA PERFORMANCE APPRAISAL';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_tx_form_pa_trx_mst($param_list_akses)->row_array();
		$data['list_trx_pa_mst'] = $this->m_pk->q_tx_form_pa_trx_mst($param_list_akses)->result();
		$data['list_trx_pa_dtl'] = $this->m_pk->q_tx_form_pa_trx_dtl($param_list_akses)->result();
		$data['list_question'] = $this->m_pk->list_pa_questions()->result();
		$this->template->display('pk/pk/v_delete_form_pa', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function save_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = strtoupper($this->input->post('nik'));
		$kdaspek = strtoupper($this->input->post('kdaspek'));
		$kdkriteria = $this->input->post('kdkriteria');
		$periode = strtoupper($this->input->post('periode'));
		$type = strtoupper($this->input->post('type'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = strtoupper(trim($dtlbranch['branch']));
		$value1 = json_decode($this->input->post('value1'));
		$value2 = $this->input->post('value2');
		$nikatasan1 = strtoupper($this->input->post('nikatasan1'));
		$note = strtoupper($this->input->post('note'));
		$suggestion = strtoupper($this->input->post('suggestion'));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$cek_option_pa = $this->m_pk->q_pk_atasan()->num_rows();
		$data['cek_option_pa'] = $cek_option_pa;

		if (count($kdkriteria) != count($value1)) {
			$data = array(
				'type' => 'error',
				'message' => 'Penilaian belum lengkap, silahkan periksa terlebih dahulu',
			);

			echo json_encode($data);
			return;
		}

		if ($note == '' or $suggestion == '') {
			$data = array(
				'type' => 'error',
				'message' => 'Penilaian belum lengkap, silahkan isi catatan & saran terlebih dahulu',
			);

			echo json_encode($data);
			return;
		}

		if ($type == 'INPUTDTLPA') {
			if ($cek_option_pa == 0 or $nikatasan1 == $nama) {
				$no = 1;
				foreach ($kdkriteria as $index => $temp) {
					if (trim($value1[$index]) != 0) {
						$info = array(
							'value1' => (int) trim($value1[$index]),
							'value2' => (int) trim($value1[$index]),
							'status' => 'R2',
							'inputby' => $inputby,
							'inputdate' => $inputdate,
						);
					} else if (trim($value1[$index]) > 5) {
						$this->db->where('userid', $nama);
						$this->db->where('modul', 'PKPA');
						$this->db->delete('sc_mst.trxerror');
						$insinfo = array(
							'userid' => $nama,
							'errorcode' => 9,
							'modul' => 'PKPA'
						);
						$this->db->insert('sc_mst.trxerror', $insinfo);
						$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
						$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
						redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
					}

					$this->db->where('nodok', $nama);
					$this->db->where('nik', $nik);
					$this->db->where('periode', $periode);
					$this->db->where('kdkriteria', trim($kdkriteria[$index]));
					$this->db->update('sc_pk.pa_form_pa_tmp_dtl', $info);
					$no++;
				}

				$info = array(
					'note' => $note,
					'suggestion' => $suggestion,
					'inputby' => $inputby,
					'inputdate' => $inputdate,
				);

				$this->db->where('nodok', $nama);
				$this->db->where('nik', $nik);
				$this->db->where('periode', $periode);
				$this->db->update('sc_pk.pa_form_pa_tmp_mst', $info);

				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 0,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
				$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
				$data = array(
					'type' => 'success',
					'message' => 'Detail penilaian berhasil disimpan',
				);

				echo json_encode($data);
				// redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
			} else {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 2,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
				$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
				$data = array(
					'type' => 'error',
					'message' => 'Failed',
				);

				echo json_encode($data);
				// redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
			}
		} else if ($type == 'EDITDTLPA') {
			$param_edit = " and nodok='$nama' and periode='$periode' and nik='$nik' and kdkriteria='$kdkriteria' ";
			$ed_dtl = $this->m_pk->q_tx_form_pa_tmp_dtl($param_edit)->row_array();
			if ($cek_option_pa == 0 or $nikatasan1 == $nama) {
				$no = 1;
				foreach ($kdkriteria as $index => $temp) {
					if (trim($value1[$index]) != 0) {
						$info = array(
							'value1' => (int) trim($value1[$index]),
							'value2' => (int) trim($value1[$index]),
							'status' => 'R2',
							'updateby' => $inputby,
							'updatedate' => $inputdate,
						);
					} else if (trim($value1[$index]) > 5) {
						$this->db->where('userid', $nama);
						$this->db->where('modul', 'PKPA');
						$this->db->delete('sc_mst.trxerror');
						$insinfo = array(
							'userid' => $nama,
							'errorcode' => 9,
							'modul' => 'PKPA'
						);
						$this->db->insert('sc_mst.trxerror', $insinfo);
						$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
						$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
						redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
					}

					$this->db->where('nodok', $nama);
					$this->db->where('nik', $nik);
					$this->db->where('periode', $periode);
					$this->db->where('kdkriteria', trim($kdkriteria[$index]));
					$this->db->update('sc_pk.pa_form_pa_tmp_dtl', $info);
					$no++;
				}

				$info = array(
					'note' => $note,
					'suggestion' => $suggestion,
					'inputby' => $inputby,
					'inputdate' => $inputdate,
				);

				$this->db->where('nodok', $nama);
				$this->db->where('nik', $nik);
				$this->db->where('periode', $periode);
				$this->db->update('sc_pk.pa_form_pa_tmp_mst', $info);

				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 0,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
				$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
				$data = array(
					'type' => 'success',
					'message' => 'Detail penilaian berhasil disimpan',
				);

				echo json_encode($data);
				// redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
			} else {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 2,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
				$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
				$data = array(
					'type' => 'error',
					'message' => 'Failed',
				);

				echo json_encode($data);
				// redirect("pk/pk/edit_generate_pa/$enc_nik/$enc_periode");
			}
		} else {
			redirect("pk/form_pk");
		}
	}

	function clear_input_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$paramcekmst = " and nodok='$nama'";
		$paramcekdtl = " and nodok='$nama' and status in ('R1','R2')";
		$dtlmst = $this->m_pk->q_tx_form_pa_tmp_mst($paramcekmst)->row_array();
		$dtldtl = $this->m_pk->q_tx_form_pa_tmp_dtl($paramcekdtl)->num_rows();
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$status = trim($dtlmst['status']);
		if ($status == 'I') {
			/* clearing temporary  */
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.pa_form_pa_tmp_mst');
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.pa_form_pa_tmp_dtl');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/form_pk');
		} else if ($status == 'E') {
			/* clearing temporary  */
			$txinfo = array(
				'status' => 'A',
				'updatedate' => null,
				'updateby' => ''
			);
			$this->db->where('nik', trim($dtlmst['nik']));
			$this->db->where('periode', trim($dtlmst['periode']));
			$this->db->update('sc_pk.pa_form_pa_trx_mst', $txinfo);

			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.pa_form_pa_tmp_mst');
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.pa_form_pa_tmp_dtl');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/form_pk');
		}
	}

	function final_input_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$paramcekmst = " and nodok='$nama'";
		$cek_option_pa = $this->m_pk->q_pk_atasan()->num_rows();
		if ($cek_option_pa > 0) {
			$dtlmst = $this->m_pk->q_tx_form_pa_tmp_mst($paramcekmst)->row_array();
		} else {
			$dtlmst = $this->m_pk->q_tx_form_pa_tmp_mst_nonatasan($paramcekmst)->row_array();
		}

		$paramcekdtl = " and nodok='$nama' and status in ('R2')";

		$dtldtl = $this->m_pk->q_tx_form_pa_tmp_dtl($paramcekdtl)->num_rows();
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		if (trim($dtlmst['status']) == 'I') {
			if ($dtldtl >= 11) {
				$info = array('status' => 'F', 'inputdate' => $inputdate, 'inputby' => $inputby);
				$this->db->where('nodok', $nama);
				$this->db->update("sc_pk.pa_form_pa_tmp_mst", $info);

				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 0,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				// redirect('pk/form_pk');
				$data = array(
					'type' => 'success',
					'message' => 'Penilaian berhasil disimpan',
				);

				echo json_encode($data);
				return;
			} else {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 3,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($dtlmst['nik'])));
				$enc_periode = $this->fiky_encryption->enkript((trim($dtlmst['periode'])));
				// redirect("pk/pk/input_generate_pa/$enc_nik/$enc_periode");
				$data = array(
					'type' => 'error',
					'message' => 'Belum ada penilaian, atau anda belum menyimpan penilaian',
				);

				echo json_encode($data);
				return;
			}
		} else if (trim($dtlmst['status']) == 'E') {
			if ($dtldtl >= 11) {
				$info = array('status' => 'F', 'updatedate' => $inputdate, 'updateby' => $inputby);
				$this->db->where('nodok', $nama);
				$this->db->update("sc_pk.pa_form_pa_tmp_mst", $info);

				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 0,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect('pk/form_pk');
			} else {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 3,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($dtlmst['nik'])));
				$enc_periode = $this->fiky_encryption->enkript((trim($dtlmst['periode'])));
				redirect("pk/pk/edit_generate_pa/$enc_nik/$enc_periode");
			}
		}
	}

	function delete_input_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$this->db->where('nik', $nik);
		$this->db->where('periode', $periode);
		$this->db->delete('sc_pk.pa_form_pa_trx_mst');

		$this->db->where('nik', $nik);
		$this->db->where('periode', $periode);
		$this->db->delete('sc_pk.pa_form_pa_trx_dtl');

		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'errorcode' => 10,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);
		//$enc_nik=$this->fiky_encryption->enkript((trim($dtlmst['nik'])));
		//$enc_periode=$this->fiky_encryption->enkript((trim($dtlmst['periode'])));
		redirect("pk/form_pk");
	}

	function approval_input_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$info = array(
			'status' => 'P',
			'updatedate' => date('Y-m-d H:i:s'),
			'updateby' => $nama,
		);

		$this->db->where('nik', $nik);
		$this->db->where('periode', $periode);
		$this->db->update('sc_pk.pa_form_pa_trx_mst', $info);

		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'errorcode' => 0,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);
		//$enc_nik=$this->fiky_encryption->enkript((trim($dtlmst['nik'])));
		//$enc_periode=$this->fiky_encryption->enkript((trim($dtlmst['periode'])));
		redirect("pk/form_pk");
	}

	function pk_generate_all_karyawan_kriteria()
	{
		$nama = trim($this->session->userdata('nik'));
		$periode = str_replace('-', '', trim($this->input->post('periode')));
		$this->db->query("select sc_pk.pr_pk_generate_all_karyawan_kriteria('$nama','$periode');");
		redirect("pk/form_pk");
	}

	function generate_pa_nik()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$this->db->query("select sc_pk.pr_pk_generate_nik('$nama', '$periode', '$nik')");
		redirect("pk/pk/form_detail_edit_pa/$enc_nik/$enc_periode");
	}

	function form_report_pa()
	{
		$data['title'] = "REPORT PENILAIN KARYAWAN PERFORMA APPRAISAL ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($startPeriode) and !empty($endPeriode)) {
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and a.nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and a.nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
			$paramnik = " and nik_atasan='$nama'";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and a.nik='$nama' ";
				$paramnik = " and nik='$nama'";
			} else {
				$param_list_akses = "";
				$paramnik = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		// $param_list_akses = " and userid='$nama'";
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		$data['list_report'] = $this->m_pk->q_list_report_new($paramnya)->result();
		$this->template->display('pk/pk/v_list_report_pa', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function generatePaReport()
	{
		$nama = trim($this->session->userdata('nik'));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = trim($startPeriode . '-' . $endPeriode);

		$this->db->query("select sc_pk.pr_report_final('$nama','$periode');");
		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'errorcode' => 0,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);
		redirect("pk/pk/form_report_pa");
	}

	function form_kondite()
	{
		$data['title'] = "KONDITE KARYAWAN ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.2';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */
		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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

		/*cek jika ada inputan edit atau input  */
		$param3_1_1 = " and nodok='$nama' and status='I'";
		$param3_1_2 = " and nodok='$nama' and status='E'";
		$param3_1_3 = " and nodok='$nama' and status in ('A','AP')";
		$param3_1_4 = " and nodok='$nama' and status='C'";
		$param3_1_5 = " and nodok='$nama' and status='H'";
		$param3_1_6 = " and nodok='$nama' and status='R'";
		$param3_1_7 = " and nodok='$nama' and status='O'";
		$param3_1_R = " and nodok='$nama'";
		$cekmst_na = $this->m_pk->q_kondite_tmp_rekap($param3_1_1)->num_rows(); //input
		$cekmst_ne = $this->m_pk->q_kondite_tmp_rekap($param3_1_2)->num_rows(); //edit
		$cekmst_napp = $this->m_pk->q_kondite_tmp_rekap($param3_1_7)->num_rows(); //approv
		$cekmst_cancel = $this->m_pk->q_kondite_tmp_rekap($param3_1_4)->num_rows(); //cancel
		$cekmst_hangus = $this->m_pk->q_kondite_tmp_rekap($param3_1_5)->num_rows(); //hangus
		$cekmst_ra = $this->m_pk->q_kondite_tmp_rekap($param3_1_6)->num_rows(); //REALISASI
		$cekmst_ch = $this->m_pk->q_kondite_tmp_rekap($param3_1_7)->num_rows(); //REALISASI
		$dtledit = $this->m_pk->q_kondite_tmp_rekap($param3_1_R)->row_array(); //edit row array

		$startPeriode = trim(substr($dtledit['periode'], 0, 6));
		$endPeriode = trim(substr($dtledit['periode'], 7, 6));
		$enc_nik = $this->fiky_encryption->enkript((trim($dtledit['nik'])));
		$enc_startperiode = $this->fiky_encryption->enkript(trim($startPeriode));
		$enc_endperiode = $this->fiky_encryption->enkript(trim($endPeriode));

		if ($cekmst_na > 0) { //cek inputan
			redirect("pk/pk/input_kondite/$enc_nik/$enc_startperiode/$enc_endperiode");
		} else if ($cekmst_ne > 0) { //cek edit
			redirect("pk/pk/edit_kondite/$enc_nik/$enc_startperiode/$enc_endperiode");
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));

		$fnik = strtoupper(trim($this->input->post('nik')));

		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		if (!empty($startPeriode) and !empty($endPeriode)) {
			$param_postperiode = " and periode='$periode' ";
		} else {
			$periode = date('Ym') . '-' . date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;
		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($param_list_akses)->result();
		$data['list_tx_kondite'] = $this->m_pk->q_view_final_kondite($paramnya)->result();
		$this->template->display('pk/pk/v_list_form_kondite', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function list_nik_from_nik_atasan_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.2';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */
		// $nik=trim($this->uri->segment(4));
		$startPeriode = str_replace('-', '', trim($this->input->post('startPeriode')));
		$endPeriode = str_replace('-', '', trim($this->input->post('endPeriode')));

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') 
             and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
		} else if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')
         	 and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses_nik = " and nik='$nama' and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
			} else {
				$param_list_akses_nik = " and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;
		$data['startPeriode'] = $startPeriode;
		$data['endPeriode'] = $endPeriode;
		$data['param_list_akses_nik'] = $param_list_akses_nik;
		$formatPeriode = date("m Y", strtotime(substr($startPeriode, 0, 4) . '-' . substr($startPeriode, 4) . '-01')) . ' S/D ' . date("m Y", strtotime(substr($endPeriode, 0, 4) . '-' . substr($endPeriode, 4) . '-01'));
		$data['title'] = "PILIH KARYAWAN INTUK INPUT KONDITE KARYAWAN PERIODE $formatPeriode";

		$this->template->display('pk/pk/v_list_nik_from_nikatasan_kondite', $data);
	}

	function list_paginate_input_nik_kondite($startPeriode, $endPeriode)
	{
		$nama = $this->session->userdata('nik');
		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') 
             and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
		} else if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')
         	 and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses_nik = " and nik between '$startPeriode' and '$endPeriode' and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where period between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
			} else {
				$param_list_akses_nik = " and nik not in (select nik from (
select nik from sc_pk.kondite_trx_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')
union all
select nik from sc_pk.kondite_tmp_mst where periode between '$startPeriode' and '$endPeriode' and coalesce(status,'') not in ('D','C')) as x )";
			}
		}

		$list = $this->m_pk->get_t_lv_karyawan_kondite($param_list_akses_nik);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lm) {
			$enc_nik = $this->fiky_encryption->enkript($lm->nik);
			$enc_startPeriode = $this->fiky_encryption->enkript($startPeriode);
			$enc_endPeriode = $this->fiky_encryption->enkript($endPeriode);
			$no++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="' . site_url("pk/pk/input_kondite/$enc_nik/$enc_startPeriode/$enc_endPeriode/") . '" class="btn btn-info  btn-sm">
                                        <i class="fa fa-edit"></i> Input Kondite
                                    </a>';
			$row[] = $lm->nik;
			$row[] = $lm->nmlengkap;
			$row[] = $lm->nmdept;
			$row[] = $startPeriode . '-' . $endPeriode;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_pk->t_lv_karyawan_kondite_count_all($param_list_akses_nik),
			"recordsFiltered" => $this->m_pk->t_lv_karyawan_kondite_count_filtered($param_list_akses_nik),
			"data" => $data,
		);
		echo $this->fiky_encryption->jDatatable($output);
	}

	function input_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		/* CODE UNTUK VERSI*/
		$kodemenu = 'I.A.A.2';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$startPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$endPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$rangeperiode = $startPeriode . '-' . $endPeriode;
		$paramceknama = " and nik='$nik'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode' ";
		$param_first_rekap = " and nik='$nik' and periode = '$rangeperiode' ";
		$cek_first_tmp_rekap = $this->m_pk->q_kondite_tmp_rekap($param_first_rekap)->num_rows();
		$cek_first_trx_rekap = $this->m_pk->q_kondite_trx_rekap($param_first_rekap)->num_rows();
		$cek_first_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_kondite_trx_mst($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->row_array();
		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/form_kondite");
			}
		} else if ($cek_first_trx > 0 or $ceknik <= 0) {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 1,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/form_kondite");
		}

		if ($cek_first_tmp_rekap == 0 and $cek_first_trx_rekap == 0 and $cek_first_tmp == 0 and $cek_first_trx == 0) {
			$periode = $startPeriode;
			$joindate = new DateTime($this->m_akses->q_master_akses_karyawan(" and nik='$nik' ")->row()->tglmasukkerja);
			$joindate = $joindate->format('Ym');

			if ($joindate > $periode) {
				$periode = $joindate;
			}

			while ($periode <= $endPeriode) {
				$this->db->query("select sc_pk.pr_kondite_nik('$nama', '$periode', '$nik')");

				$year = substr($periode, 0, 4);
				$month = substr($periode, 4, 2);
				$month++;

				if ($month > 12) {
					$month = 1;
					$year++;
				}

				$year = str_pad($year, 4, '0', STR_PAD_LEFT);
				$month = str_pad($month, 2, '0', STR_PAD_LEFT);
				$periode = $year . $month;
			}

			$this->db->query("select sc_pk.pr_kondite_tmp_rekap('$nama', '$rangeperiode', '$nik', 'INSERT')");
		}

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses_rekap = " and nik='$nik' and periode = '$rangeperiode'";
		$param_list_akses = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode'";
		$data['title'] = ' INPUT KONDITE KARYAWAN ';
		$data['nama'] = $nama;
		$data['startPeriode'] = $startPeriode;
		$data['endPeriode'] = $endPeriode;
		$data['kondite_tmp_rekap'] = $this->m_pk->q_kondite_tmp_rekap($param_list_akses_rekap)->result();
		$data['dtlrow'] = $this->m_pk->q_kondite_tmp_mst($param_list_akses)->row_array();
		$data['list_tmp_kondite_mst'] = $this->m_pk->q_kondite_tmp_mst($param_list_akses)->result();
		$this->template->display('pk/pk/v_input_kondite', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function edit_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$startPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$endPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$rangeperiode = $startPeriode . '-' . $endPeriode;
		$paramceknama = " and nik='$nik'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode' ";
		$param_first_rekap = " and nik='$nik' and periode = '$rangeperiode' ";
		$cek_first_tmp_rekap = $this->m_pk->q_kondite_tmp_rekap($param_first_rekap)->num_rows();
		$cek_first_trx_rekap = $this->m_pk->q_kondite_trx_rekap($param_first_rekap)->num_rows();
		$cek_first_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_kondite_trx_mst($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->row_array();
		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/form_kondite");
			}
		}

		if ($cek_first_tmp_rekap == 0 and $cek_first_trx_rekap == 0 and $cek_first_tmp == 0 and $cek_first_trx == 0) {
			$periode = $startPeriode;
			while ($periode <= $endPeriode) {
				$this->db->query("select sc_pk.pr_kondite_nik('$nama', '$periode', '$nik')");

				$year = substr($periode, 0, 4);
				$month = substr($periode, 4, 2);
				$month++;

				if ($month > 12) {
					$month = 1;
					$year++;
				}

				$year = str_pad($year, 4, '0', STR_PAD_LEFT);
				$month = str_pad($month, 2, '0', STR_PAD_LEFT);
				$periode = $year . $month;
			}

			$this->db->query("select sc_pk.pr_kondite_tmp_rekap('$nama', '$rangeperiode', '$nik', 'INSERT')");
		}

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		if ($cek_first_trx_rekap > 0 and $cek_first_trx > 0) {
			$info = array(
				'status' => 'E',
				'updateby' => $inputby,
				'updatedate' => $inputdate,
			);
			$this->db->where('nik', $nik);
			$this->db->where("periode BETWEEN '$startPeriode' AND '$endPeriode' ");
			$this->db->update('sc_pk.kondite_trx_mst', $info);

			$this->db->where('nik', $nik);
			$this->db->where('periode', $rangeperiode);
			$this->db->update('sc_pk.kondite_trx_rekap', $info);
		}

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode'";
		$param_list_akses_rekap = " and nik='$nik' and periode = '$rangeperiode'";
		$data['title'] = ' UBAH KONDITE KARYAWAN ';
		$data['startPeriode'] = $startPeriode;
		$data['endPeriode'] = $endPeriode;
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_kondite_tmp_mst($param_list_akses)->row_array();
		$data['list_tmp_kondite_mst'] = $this->m_pk->q_kondite_tmp_mst($param_list_akses)->result();
		$data['kondite_tmp_rekap'] = $this->m_pk->q_kondite_tmp_rekap($param_list_akses_rekap)->result();
		$this->template->display('pk/pk/v_edit_kondite', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function detail_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$startPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$endPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$rangePeriode = $startPeriode . '-' . $endPeriode;
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode'";
		$cek_first_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_kondite_trx_mst($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->row_array();

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}

		$data['cek_option_pa'] = $this->m_pk->q_pk_atasan()->num_rows();

		$param_list_akses = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode'";
		$param_list_akses_rekap = " and nik='$nik' and periode = '$rangePeriode'";
		$data['title'] = ' DETAIL KONDITE KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_kondite_trx_mst($param_list_akses)->row_array();
		$data['list_trx_kondite_mst'] = $this->m_pk->q_kondite_trx_mst($param_list_akses)->result();
		$data['kondite_trx_rekap'] = $this->m_pk->q_kondite_trx_rekap($param_list_akses_rekap)->row_array();
		$this->template->display('pk/pk/v_detail_kondite', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function delete_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$startPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$endPeriode = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$rangePeriode = $startPeriode . '-' . $endPeriode;
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode'";
		$cek_first_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_kondite_trx_mst($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_kondite_tmp_mst($param_first)->row_array();

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode between '$startPeriode' and '$endPeriode'";
		$param_list_akses_rekap = " and nik='$nik' and periode = '$rangePeriode'";
		$data['title'] = ' PENGHAPUSAN KONDITE KARYAWAN ';
		$data['nama'] = $nama;
		$data['startPeriode'] = $startPeriode;
		$data['endPeriode'] = $endPeriode;
		$data['dtlrow'] = $this->m_pk->q_kondite_trx_mst($param_list_akses)->row_array();
		$data['list_trx_kondite_mst'] = $this->m_pk->q_kondite_trx_mst($param_list_akses)->result();
		$data['kondite_trx_rekap'] = $this->m_pk->q_kondite_trx_rekap($param_list_akses_rekap)->result();
		$this->template->display('pk/pk/v_delete_kondite', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function save_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = strtoupper($this->input->post('nik'));
		$nodok = strtoupper($this->input->post('nodok'));
		$periode = strtoupper($this->input->post('periode'));
		$startPeriode = strtoupper($this->input->post('startPeriode'));
		$endPeriode = strtoupper($this->input->post('endPeriode'));
		$rangeperiode = $startPeriode . '-' . $endPeriode;
		$type = strtoupper($this->input->post('type'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = strtoupper(trim($dtlbranch['branch']));
		$ttlvalueip = (int) trim($this->input->post('ttlvalueip'));
		$ttlvaluesd = (int) trim($this->input->post('ttlvaluesd'));
		$ttlvalueal = (int) trim($this->input->post('ttlvalueal'));
		$ttlvaluetl = (int) trim($this->input->post('ttlvaluetl'));
		$ttlvalueitl = (int) trim($this->input->post('ttlvalueitl'));
		$ttlvalueipa = (int) trim($this->input->post('ttlvalueipa'));
		$ttlvaluesp1 = (int) trim($this->input->post('ttlvaluesp1'));
		$ttlvaluesp2 = (int) trim($this->input->post('ttlvaluesp2'));
		$ttlvaluesp3 = (int) trim($this->input->post('ttlvaluesp3'));
		$ttlvalueik = (int) trim($this->input->post('ttlvalueik'));
		$ttlvaluect = (int) trim($this->input->post('ttlvaluect'));

		$description = strtoupper($this->input->post('description'));
		$nikatasan1 = strtoupper($this->input->post('nikatasan1'));
		$nikatasan2 = strtoupper($this->input->post('nikatasan2'));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		if ($type == 'INPUTMSTKONDITE') {
			var_dump($this->input->post());
			$info = array(
				'ttlvaluesd' => $ttlvaluesd,
				'ttlvaluetl' => $ttlvaluetl,
				'ttlvalueitl' => $ttlvalueitl,
				'ttlvalueipa' => $ttlvalueipa,
				'ttlvalueik' => $ttlvalueik,
				'ttlvaluect' => $ttlvaluect,
				'ttlvalueip' => $ttlvalueip,
				'ttlvalueal' => $ttlvalueal,
				'ttlvaluesp1' => $ttlvaluesp1,
				'ttlvaluesp2' => $ttlvaluesp2,
				'ttlvaluesp3' => $ttlvaluesp3,
				'description' => $description,
				'status' => '',
				'inputby' => $inputby,
				'inputdate' => $inputdate,
			);
			$this->db->where('nodok', $nodok);
			$this->db->where('nik', $nik);
			$this->db->where('periode', trim($periode));
			$this->db->update('sc_pk.kondite_tmp_mst', $info);

			$this->db->query("select sc_pk.pr_kondite_tmp_rekap('$nama', '$rangeperiode', '$nik', 'UPDATE')");

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
			$enc_startperiode = $this->fiky_encryption->enkript((trim($startPeriode)));
			$enc_endperiode = $this->fiky_encryption->enkript((trim($endPeriode)));
			redirect("pk/pk/input_kondite/$enc_nik/$enc_startperiode/$enc_endperiode");
		} else if ($type == 'EDITMSTKONDITE') {
			$info = array(
				'ttlvaluesd' => $ttlvaluesd,
				'ttlvaluetl' => $ttlvaluetl,
				'ttlvalueitl' => $ttlvalueitl,
				'ttlvalueipa' => $ttlvalueipa,
				'ttlvalueik' => $ttlvalueik,
				'ttlvaluect' => $ttlvaluect,
				'ttlvalueip' => $ttlvalueip,
				'ttlvalueal' => $ttlvalueal,
				'ttlvaluesp1' => $ttlvaluesp1,
				'ttlvaluesp2' => $ttlvaluesp2,
				'ttlvaluesp3' => $ttlvaluesp3,
				'description' => $description,
				'status' => '',
				'updateby' => $inputby,
				'updatedate' => $inputdate,
			);
			$this->db->where('nodok', $nama);
			$this->db->where('nik', $nik);
			$this->db->where('periode', trim($periode));
			$this->db->update('sc_pk.kondite_tmp_mst', $info);
			$this->db->query("select sc_pk.pr_kondite_tmp_rekap('$nama', '$rangeperiode', '$nik', 'UPDATE')");

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
			$enc_startperiode = $this->fiky_encryption->enkript((trim($startPeriode)));
			$enc_endperiode = $this->fiky_encryption->enkript((trim($endPeriode)));
			redirect("pk/pk/edit_kondite/$enc_nik/$enc_startperiode/$enc_endperiode");
		} else {
			redirect("pk/form_kondite");
		}
	}


	function clear_input_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$paramcekmst = " and nodok='$nama'";
		$dtlmst = $this->m_pk->q_kondite_tmp_mst($paramcekmst)->row_array();
		$dtlrekap = $this->m_pk->q_kondite_tmp_rekap($paramcekmst)->row_array();
		$startPeriode = trim(substr($dtlrekap['periode'], 0, 6));
		$endPeriode = trim(substr($dtlrekap['periode'], 7, 6));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$status = trim($dtlmst['status']);
		if ($status == 'I') {
			/* clearing temporary  */
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.kondite_tmp_mst');

			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.kondite_tmp_rekap');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/form_kondite');
		} else if ($status == 'E') {
			/* clearing temporary  */
			$txinfo = array(
				'status' => 'A',
				'updatedate' => null,
				'updateby' => ''
			);
			$this->db->where('nik', trim($dtlmst['nik']));
			$this->db->where("periode between '$startPeriode' and '$endPeriode'");
			$this->db->update('sc_pk.kondite_trx_mst', $txinfo);

			$this->db->where('nik', trim($dtlrekap['nik']));
			$this->db->where('periode', trim($dtlrekap['periode']));
			$this->db->update('sc_pk.kondite_trx_rekap', $txinfo);

			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.kondite_tmp_mst');

			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.kondite_tmp_rekap');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/form_kondite');
		}
	}

	function final_input_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$paramcekmst = " and nodok='$nama'";
		$dtlmst = $this->m_pk->q_kondite_tmp_mst($paramcekmst)->row_array();
		$dtlrkp = $this->m_pk->q_kondite_tmp_rekap($paramcekmst)->row_array();
		$startPeriode = trim(substr($dtlrkp['periode'], 0, 6));
		$endPeriode = trim(substr($dtlrkp['periode'], 7, 6));

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		if (trim($dtlmst['status']) == 'I') {
			if (isset($dtlmst['f_score_k'])) {
				$info = array('status' => 'F', 'inputdate' => $inputdate, 'inputby' => $inputby);
				$this->db->where('nodok', $nama);
				$this->db->update("sc_pk.kondite_tmp_mst", $info);

				$this->db->where('nodok', $nama);
				$this->db->update("sc_pk.kondite_tmp_rekap", $info);

				redirect('pk/form_kondite');
			} else {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 6,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($dtlmst['nik'])));
				$enc_startperiode = $this->fiky_encryption->enkript((trim($startPeriode)));
				$enc_endperiode = $this->fiky_encryption->enkript((trim($endPeriode)));
				redirect("pk/input_kondite/$enc_nik/$enc_startperiode/$enc_endperiode");
			}
		} else if (trim($dtlmst['status']) == 'E') {
			if (isset($dtlmst['f_score_k'])) {
				$info = array('status' => 'F', 'updatedate' => $inputdate, 'updateby' => $inputby);
				$this->db->where('nodok', $nama);
				$this->db->where("periode between '$startPeriode' and '$endPeriode'");
				$this->db->update("sc_pk.kondite_tmp_mst", $info);

				$this->db->where('nodok', $nama);
				$this->db->where('periode', $dtlrkp['periode']);
				$this->db->update("sc_pk.kondite_tmp_rekap", $info);

				redirect('pk/form_kondite');
			} else {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 6,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				$enc_nik = $this->fiky_encryption->enkript((trim($dtlmst['nik'])));
				$enc_startperiode = $this->fiky_encryption->enkript((trim($startPeriode)));
				$enc_endperiode = $this->fiky_encryption->enkript((trim($endPeriode)));
				redirect("pk/edit_kondite/$enc_nik/$enc_startperiode/$enc_endperiode");
			}
		}
	}

	function delete_input_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$startperiode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$endperiode = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$rangeperiode = $startperiode . '-' . $endperiode;

		$this->db->where('nik', $nik);
		$this->db->where("periode between '$startperiode' and '$endperiode'");
		$this->db->delete('sc_pk.kondite_trx_mst');

		$this->db->where('nik', $nik);
		$this->db->where('periode', $rangeperiode);
		$this->db->delete('sc_pk.kondite_trx_rekap');

		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'errorcode' => 10,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);
		redirect("pk/form_kondite");
	}

	function approval_input_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$startPeriode = trim(substr($periode, 0, 6));
		$endPeriode = trim(substr($periode, 7, 6));
		$code = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		if ($code == 'p')
			$info = array('status' => strtoupper($code), 'updatedate' => $inputdate, 'updateby' => $inputby, 'a1_approved' => 't', 'a2_approved' => 't');
		elseif ($code == 'a2')
			$info = array('status' => strtoupper('p'), 'updatedate' => $inputdate, 'updateby' => $inputby, 'a1_approved' => 't', 'a2_approved' => 't');

		$this->db->where('nik', $nik);
		$this->db->where("periode between '$startPeriode' and '$endPeriode' ");
		$this->db->update("sc_pk.kondite_trx_mst", $info);

		$this->db->where('nik', $nik);
		$this->db->where("periode='$periode'");
		$this->db->update("sc_pk.kondite_trx_rekap", $info);

		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'errorcode' => 0,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);
		redirect('pk/form_kondite');
	}

	function form_kpi()
	{
		$data['title'] = "IMPORT KPI";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2023-11-01');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		if ($this->uri->segment(4) == "exist")
			$data['message'] = "<div class='alert alert-warning'>Data Sudah Ada atau kode transaksi pernah di Upload</div>";
		else if ($this->uri->segment(4) == "add_success")
			$data['message'] = "<div class='alert alert-success'>Data Berhasil disimpan</div>";
		else if ($this->uri->segment(4) == "wrong_format")
			$data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
		else if ($this->uri->segment(4) == "conf_succes")
			$data['message'] = "<div class='alert alert-success'>Konfirmasi SUKSES</div>";
		else
			$data['message'] = '';
		$this->template->display('pk/import/v_import', $data);
	}

	function download_template_kpi()
	{
		$this->load->helper('download');

		$pathToFile = './assets/templateimport/KPI.xlsx';
		$data = file_get_contents($pathToFile);
		$name = 'Template Import KPI.xlsx';

		force_download($name, $data);
	}

	function import_kpi()
	{
		if ($this->input->post('save')) {
			$dir = './assets/files/';
			if (!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}

			$fileName = $_FILES['import']['name'];
			$fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
			if (!in_array($fileExt, array('xls', 'xlsx'))) {
				redirect('pk/pk/form_kpi/wrong_format');
			}

			$config['upload_path'] = $dir;
			$config['file_name'] = $fileName;
			$config['allowed_types'] = '*';
			$config['max_size'] = 10000;

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('import'))
				echo $this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = $dir . $media['file_name'];

			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
			}

			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			for ($row = 2; $row <= $highestRow; $row++) {
				$rowData = $sheet->rangeToArray(
					'A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE
				);

				$data = array(
					'branch' => 'SBYNSA',
					'idbu' => 'AR',
					'periode' => (string) $rowData[0][0],
					'nik' => (string) $rowData[0][1]
				);

				$this->db->where($data);
				if ($this->db->get("sc_pk.kpi_trx_mst")->num_rows() < 1) {
					$data_import = array(
						'branch' => 'SBYNSA',
						'idbu' => 'AR',
						'nodok' => $this->session->userdata('nik'),
						'periode' => $rowData[0][0],
						'nik' => $rowData[0][1],
						'kpi_point' => str_replace(",", ".", $rowData[0][2]),
						'kpi_score' => str_replace(",", ".", $rowData[0][3]),
						'status' => 'P',
						'inputby' => $this->session->userdata('nik'),
						'inputdate' => date("Y-m-d H:i:s")
					);
					$this->db->insert("sc_pk.kpi_tmp_mst", $data_import);
				} else {
					$data_import = array(
						'kpi_point' => round(str_replace(",", ".", $rowData[0][2]), 2),
						'kpi_score' => round(str_replace(",", ".", $rowData[0][3]), 2),
						'updateby' => $this->session->userdata('nik'),
						'updatedate' => date("Y-m-d H:i:s")
					);
					$this->db->where($data);
					$this->db->update("sc_pk.kpi_trx_mst", $data_import);
				}
			}
		}

		$fileUploaded = $dir . str_replace(" ", "_", $fileName);

		if (file_exists($fileUploaded)) {
			unlink($fileUploaded);
			redirect('pk/pk/form_kpi/add_success');
		} else {
			redirect('pk/pk/form_kpi/wrong_format');
		}
	}

	function form_report_kpi()
	{
		$data['title'] = "REPORT KPI KARYAWAN ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2023-11-01');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and a.nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
			$paramnik = " and nik_atasan='$nama'";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and a.nik='$nama' ";
				$paramnik = " and nik='$nama'";
			} else {
				$param_list_akses = "";
				$paramnik = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		// $data['list_report'] = $this->m_pk->q_list_kpi_report($paramnya)->result();
		$this->template->display('pk/import/v_list_report_kpi', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function form_report_kpi_karyawan($fnik)
	{
		$data['title'] = "REPORT KPI KARYAWAN ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2023-11-01');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = empty($fnik) ? strtoupper(trim($this->input->post('nik'))) : $fnik;
		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['fnik'] = $fnik;
		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnik = "";
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		$data['list_report'] = $this->m_pk->q_list_kpi_report($paramnya)->result();
		$this->template->display('pk/import/v_list_report_kpi_perkaryawan', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function form_report_kpi_yearly()
	{
		$data['title'] = "REKAP KPI KARYAWAN TAHUNAN";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2023-11-01');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tahun = ($this->input->post('tahun'));
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($tahun)) {
			$periode = $tahun;
			$param_postperiode = " and tahun='$tahun'";
		} else {
			$periode = date('Y');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
			$paramnik = " and nik_atasan='$nama'";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and a.nik='$nama' ";
				$paramnik = " and nik='$nama'";
			} else {
				$param_list_akses = "";
				$paramnik = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		$data['list_report'] = $this->m_pk->q_list_kpi_report_yearly($paramnya)->result();
		$this->template->display('pk/import/v_list_report_kpi_yearly', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function form_report_final()
	{
		$data['title'] = "REPORT FINAL PENILAIAN KARYAWAN";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$fnik = strtoupper(trim($this->input->post('nik')));
		$dept = strtoupper(trim($this->input->post('dept')));

		if (!empty($startPeriode)) {
			// $periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			// $periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}
		if (!empty($dept)) {
			$param_postdept = " and bag_dept='$dept'";
		} else {
			$param_postdept = "";
		}



		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnya = $param_list_akses . $param_postnik . $param_postperiode . $param_postdept;
		$paramdept = "";

		$data['list_tx_final_pk'] = $this->m_pk->q_final_report_pk_trx($paramnya)->result();
		$data['list_dept'] = $this->m_pk->q_mstdepartmen($paramdept)->result();
		$this->template->display('pk/pk/v_list_form_final_pk', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function list_nik_from_nik_atasan_final_pk()
	{
		$nama = trim($this->session->userdata('nik'));
		// $nik=trim($this->uri->segment(4));
		$periode = str_replace('-', '', trim($this->input->post('periode')));

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses_nik = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses_nik = " and nik='$nama' ";
			} else {
				$param_list_akses_nik = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;
		$data['periode'] = $periode;
		$data['title'] = "PILIH KARYAWAN UNTUK GENERATE FINAL PENILAIAN KARYAWAN";

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($param_list_akses_nik)->result();
		$this->template->display('pk/pk/v_list_nik_from_nikatasan_final_pk', $data);
	}

	function input_final_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$param_final_trx = " and nik='$nik' and periode='$periode' and status='P'";
		$cek_first_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_final_report_pk_trx($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();

		$cek_f_pa = $this->m_pk->q_tx_form_pa_trx_mst($param_final_trx)->num_rows();
		$cek_f_inspek = $this->m_pk->q_inspek_trx_mst($param_final_trx)->num_rows();
		$cek_f_kondite = $this->m_pk->q_kondite_trx_mst($param_final_trx)->num_rows();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/pk/form_report_final");
			}
		}
		/*		if ($cek_f_pa==0 or $cek_f_inspek==0 or $cek_f_kondite==0){
															$this->db->where('userid',$nama);
																$this->db->where('modul','PKPA');
																$this->db->delete('sc_mst.trxerror');
																$insinfo = array (
																	'userid' => $nama,
																	'errorcode' => 11,
																	'modul' => 'PKPA'
																);
																$this->db->insert('sc_mst.trxerror',$insinfo);
															redirect("pk/pk/form_report_final");
															
														} 
												*/

		if ($cek_first_trx > 0) {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 1,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/pk/form_report_final");
		}

		if ($cek_first_tmp == 0 and $cek_first_trx == 0) {
			$this->db->query("select sc_pk.final_report_pk('$nama','$periode','$nik');");
		}


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";

		$data['title'] = ' INPUT FINAL PENILAIAN KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->row_array();
		$data['KPI'] = $this->m_pk->q_pk_option(" and kdpk='KPI' and condition1='UNLINK'")->num_rows();
		$data['PA'] = $this->m_pk->q_pk_option(" and kdpk='PA' and condition1='UNLINK'")->num_rows();
		$data['KD'] = $this->m_pk->q_pk_option(" and kdpk='KD' and condition1='UNLINK'")->num_rows();
		$data['IK'] = $this->m_pk->q_pk_option(" and kdpk='IK' and condition1='UNLINK'")->num_rows();
		$data['list_tmp_final_pk'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->result();
		$this->template->display('pk/pk/v_input_final_pk', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function edit_final_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$cek_first_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_final_report_pk_trx($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/pk/form_report_final");
			}
		}


		if ($cek_first_tmp == 0) {
			$info = array('status' => 'E', 'updateby' => $inputby, 'updatedate' => $inputdate);
			$this->db->where('nik', $nik);
			$this->db->where('periode', $periode);
			$this->db->update('sc_pk.final_report_pk', $info);
		}


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' EDIT FINAL PENILAIAN KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();
		$data['KPI'] = $this->m_pk->q_pk_option(" and kdpk='KPI' and condition1='UNLINK'")->num_rows();
		$data['PA'] = $this->m_pk->q_pk_option(" and kdpk='PA' and condition1='UNLINK'")->num_rows();
		$data['KD'] = $this->m_pk->q_pk_option(" and kdpk='KD' and condition1='UNLINK'")->num_rows();
		$data['IK'] = $this->m_pk->q_pk_option(" and kdpk='IK' and condition1='UNLINK'")->num_rows();
		$data['list_tmp_final_pk'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->result();
		$this->template->display('pk/pk/v_edit_final_pk', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function detail_final_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$cek_first_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_final_report_pk_trx($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' DETAIL FINAL PENILAIAN KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_final_report_pk_trx($param_list_akses)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_trx($param_first)->row_array();
		$data['list_tmp_final_pk'] = $this->m_pk->q_final_report_pk_trx($param_list_akses)->result();
		$this->template->display('pk/pk/v_detail_final_pk', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function detail_final_penilaian_karyawan_trx()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$cek_first_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_final_report_pk_trx($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' DETAIL FINAL PENILAIAN KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_final_report_pk_trx($param_list_akses)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_trx($param_first)->row_array();
		$data['list_tmp_final_pk'] = $this->m_pk->q_final_report_pk_trx($param_list_akses)->result();
		$this->template->display('pk/pk/v_detail_final_pk_trx', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function delete_final_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$cek_first_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_final_report_pk_trx($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' HAPUS FINAL PENILAIAN KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_final_report_pk_trx($param_list_akses)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_trx($param_first)->row_array();
		$data['list_tmp_final_pk'] = $this->m_pk->q_final_report_pk_trx($param_list_akses)->result();
		$this->template->display('pk/pk/v_delete_final_pk', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function save_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$nodok = trim($this->input->post('nodok'));
		$nik = strtoupper($this->input->post('nik'));
		$periode = strtoupper($this->input->post('periode'));
		$type = strtoupper($this->input->post('type'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = strtoupper(trim($dtlbranch['branch']));

		$fs1_kpi = (int) trim($this->input->post('fs1_kpi'));
		$fs1_kondite = (int) trim($this->input->post('fs1_kondite'));
		$fs1_pa = (int) trim($this->input->post('fs1_pa'));
		$fs1_inspek = (int) trim($this->input->post('fs1_inspek'));

		$description = strtoupper($this->input->post('description'));
		$note = strtoupper($this->input->post('note'));
		$suggestion = strtoupper($this->input->post('suggestion'));
		$nikatasan1 = strtoupper($this->input->post('nikatasan1'));
		$nikatasan2 = strtoupper($this->input->post('nikatasan2'));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		// if ($type == 'INPUTMSTFINALPK') {
		// 	$info = array(
		// 		'note' => $note,
		// 		'suggestion' => $suggestion,
		// 		'status' => 'A',
		// 		'inputby' => $inputby,
		// 		'inputdate' => $inputdate,
		// 	);
		// 	$this->db->where('nodok', $nama);
		// 	$this->db->where('nik', $nik);
		// 	$this->db->where('periode', $periode);
		// 	$this->db->update('sc_pk.final_report_pk', $info);

		// 	$this->db->where('userid', $nama);
		// 	$this->db->where('modul', 'PKPA');
		// 	$this->db->delete('sc_mst.trxerror');
		// 	$insinfo = array(
		// 		'userid' => $nama,
		// 		'errorcode' => 0,
		// 		'modul' => 'PKPA'
		// 	);
		// 	$this->db->insert('sc_mst.trxerror', $insinfo);
		// 	$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
		// 	$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
		// 	redirect("pk/pk/input_final_penilaian_karyawan/$enc_nik/$enc_periode");
		// } else
		if ($type == 'EDITMSTFINALPK') {
			$info = array(
				'note' => $note,
				'suggestion' => $suggestion,
				'status' => 'A',
				'inputby' => $inputby,
				'inputdate' => $inputdate,
			);
			$this->db->where('nodok', trim($nodok));
			$this->db->where('nik', trim($nik));
			$this->db->where('periode', trim($periode));
			$this->db->update('sc_pk.final_report_pk', $info);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
			$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
			redirect("pk/pk/detail_final_penilaian_karyawan_trx/$enc_nik/$enc_periode");
		} elseif ($type == 'EDITDESCFINALPK') {
			$info = array(
				'description' => $description,
				'inputby' => $inputby,
				'inputdate' => $inputdate,
			);
			$this->db->where('nodok', $nama);
			$this->db->where('nik', $nik);
			$this->db->where('periode', $periode);
			$this->db->update('sc_pk.final_report_pk_tmp', $info);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
			$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
			redirect("pk/pk/edit_final_penilaian_karyawan_tmp/$enc_nik/$enc_periode");
		} else {
			redirect("pk/pk/form_report_final");
		}
	}


	function clear_input_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$paramcekmst = " and nodok='$nama'";
		$dtlmst = $this->m_pk->q_final_score_pk_rekap_tmp($paramcekmst)->row_array();
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		$status = trim($dtlmst['status']);
		if ($status == 'I') {
			/* clearing temporary  */
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.final_report_pk_tmp');
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.rekap_final_report_pk_tmp');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/pk/form_report_final_close');
		} else if ($status == 'E') {
			$txinfo = array(
				'status' => 'A',
				'updatedate' => null,
				'updateby' => ''
			);
			$this->db->where('kddept', trim($dtlmst['kddept']));
			$this->db->where('periode', trim($dtlmst['periode']));
			$this->db->update('sc_pk.rekap_final_report_pk_trx', $txinfo);

			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.final_report_pk_tmp');
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.rekap_final_report_pk_tmp');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/pk/form_report_final_close');
		} else if ($status == 'A') {
			/* clearing temporary  */
			$txinfo = array(
				'status' => 'A',
				'updatedate' => null,
				'updateby' => ''
			);
			$this->db->where('kddept', trim($dtlmst['kddept']));
			$this->db->where('periode', trim($dtlmst['periode']));
			$this->db->update('sc_pk.rekap_final_report_pk_trx', $txinfo);

			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.final_report_pk_tmp');
			$this->db->where('nodok', $nama);
			$this->db->delete('sc_pk.rekap_final_report_pk_tmp');

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 0,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect('pk/pk/form_report_final_close');
		}

		redirect('pk/pk/form_report_final_close');
	}

	function final_input_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$paramcekmst = " and nodok='$nama'";
		$dtlmst = $this->m_pk->q_final_score_pk_rekap_tmp($paramcekmst)->row_array();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;
		if (trim($dtlmst['status']) == 'I') {

			$info = array('status' => 'F', 'inputdate' => $inputdate, 'inputby' => $inputby);
			$this->db->where('nodok', $nama);
			$this->db->update("sc_pk.rekap_final_report_pk_tmp", $info);

			redirect('pk/pk/form_report_final_close');
		} else if (trim($dtlmst['status']) == 'E') {

			$info = array('status' => 'F', 'updatedate' => $inputdate, 'updateby' => $inputby);
			$this->db->where('nodok', $nama);
			$this->db->update("sc_pk.rekap_final_report_pk_tmp", $info);

			redirect('pk/pk/form_report_final_close');
		} else if (trim($dtlmst['status']) == 'A') {

			$info = array('status' => 'F', 'approvedate' => $inputdate, 'approveby' => $inputby);
			$this->db->where('nodok', $nama);
			$this->db->update("sc_pk.rekap_final_report_pk_tmp", $info);

			redirect('pk/pk/form_report_final_close');
		}
	}

	function approval_input_penilaian_karyawan()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$code = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

		if ($code == 'p')
			$info = array('status' => strtoupper($code), 'updatedate' => $inputdate, 'updateby' => $inputby, 'a1_approved' => 't', 'a2_approved' => 't');
		elseif ($code == 'a2')
			$info = array('status' => strtoupper($code), 'updatedate' => $inputdate, 'updateby' => $inputby, 'a1_approved' => 't');

		$this->db->where('nik', $nik);
		$this->db->where('periode', $periode);
		$this->db->update("sc_pk.final_report_pk", $info);

		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'errorcode' => 0,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);

		$enc_nik = bin2hex($this->encrypt->encode(trim($nik)));
		$enc_periode = bin2hex($this->encrypt->encode(trim($periode)));
		redirect('pk/pk/detail_final_penilaian_karyawan_trx/' . $enc_nik . '/' . $enc_periode);
	}


	function delete_input_penilaian_karyawan()
	{
		$nama = $this->session->userdata('nik');
		$nik = trim($this->uri->segment(4));
		$periode = trim($this->uri->segment(5));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;


		$this->db->where('nik', $nik);
		$this->db->where('periode', $periode);
		$this->db->delete("sc_pk.final_report_pk");


		$this->db->where('userid', $nama);
		$this->db->where('modul', 'PKPA');
		$this->db->delete('sc_mst.trxerror');
		$insinfo = array(
			'userid' => $nama,
			'nomorakhir1' => '',
			'errorcode' => 10,
			'modul' => 'PKPA'
		);
		$this->db->insert('sc_mst.trxerror', $insinfo);

		redirect('pk/pk/form_report_final');
	}

	function report_penilaian_karyawan()
	{
		$data['title'] = "REPORT PENILAIAN KARYAWAN (PK) ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and status = 'P' and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and status = 'P' and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and status = 'P' ";
				//                $param_list_akses=" and nik='$nama' ";
			} else {
				$param_list_akses = " and status = 'P' ";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;



		///  $param_list_akses=" and userid='$nama'";
		$paramnik = "";
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		///$this->db->query("select sc_pk.pr_report_inspek_final('$nama', '$periode');");

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		$data['list_report'] = $this->m_pk->q_final_report_pk_trx($paramnya)->result();
		$this->template->display('pk/pk/v_list_report_penilaian_karyawan', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}


	function report_kondite()
	{
		$data['title'] = "REPORT KONDITE KARYAWAN ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnik = "";
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		// $data['list_report'] = $this->m_pk->q_list_kondite_report($paramnya)->result();
		$this->template->display('pk/pk/v_list_report_kondite', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function report_kondite_karyawan($fnik)
	{
		$data['title'] = "REPORT KONDITE KARYAWAN ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$fnik = empty($fnik) ? strtoupper(trim($this->input->post('nik'))) : $fnik;

		if (!empty($startPeriode)) {
			// $periode = $tglYM;
			$param_postperiode = " and periode between '$startPeriode' and '$endPeriode' ";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama'))";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['fnik'] = $fnik;
		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnik = "";
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$data['list_nik'] = $this->m_akses->q_master_akses_karyawan($paramnik)->result();
		$data['list_report'] = $this->m_pk->q_list_kondite_report($paramnya)->result();
		$this->template->display('pk/pk/v_list_report_kondite_karyawan', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function submit_test()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$param_following = " and nik='$nik' and nikatasan='$nama'";
		$cek_first_tmp = $this->m_pk->q_tx_form_pa_tmp_mst($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_tx_form_pa_trx_mst($param_first)->num_rows();
		$cek_folowing_nik = $this->m_pk->q_folowing_atasan($param_following)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_tx_form_pa_tmp_mst($param_first)->row_array();
		if ($cek_first_tmp > 0) {
			if (trim($dtl_mst_tmp['nodok']) != $nama) {
				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'errorcode' => 4,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/form_pk");
			}
		} else if ($cek_folowing_nik == 0) {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 8,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/form_pk");
		}
		if ($cek_first_trx > 0) {
			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'errorcode' => 1,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/pk/form_inspeksi");
		}

		if ($cek_first_tmp == 0 and $cek_first_trx == 0) {
			$this->db->query("select sc_pk.pr_pk_generate_nik('$nama', '$periode', '$nik')");
		}


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' TEST TESTING INPUT ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_tx_form_pa_tmp_mst($param_list_akses)->row_array();
		$data['list_tmp_pa_mst'] = $this->m_pk->q_tx_form_pa_tmp_mst($param_list_akses)->result();
		$data['list_tmp_pa_dtl'] = $this->m_pk->q_tx_form_pa_tmp_dtl($param_list_akses)->result();
		$this->template->display('pk/pk/v_input_submit_test', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function save_test()
	{
		$nama = trim($this->session->userdata('nik'));
		$kdkriteria = $this->input->post('kdkriteria');
		$nik = trim($this->input->post('nik'));
		$periode = trim($this->input->post('periode'));
		$value1 = $this->input->post('value1');
		$value2 = $this->input->post('value2');
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;



		$no = 1;
		foreach ($kdkriteria as $index => $temp) {
			//echo (trim($kdkriteria[$index]))."\n";
			//echo (trim($value1[$index]))."\n";
			if (trim($value1[$index]) == 0) {
				$info = array(
					'value1' => trim($value1[$index]),
					///'value2' => trim($value2[$index]),
					'status' => 'I'
				);
			} else {
				$info = array(
					'value1' => trim($value1[$index]),
					///'value2' => trim($value2[$index]),
					'status' => 'R1'
				);
			}

			$this->db->where('nodok', $nama);
			$this->db->where('nik', $nik);
			$this->db->where('periode', $periode);
			$this->db->where('kdkriteria', trim($kdkriteria[$index]));
			$this->db->update('sc_pk.pa_form_pa_tmp_dtl', $info);
			$no++;
		}

		////$insert = $this->m_pk->add_mapping_inspek_tmp($info);
		////
		$enc_nik = $this->fiky_encryption->enkript((trim($nik)));
		$enc_periode = $this->fiky_encryption->enkript((trim($periode)));
		redirect("pk/pk/submit_test/$enc_nik/$enc_periode");
	}

	function excel_report_form_kondite()
	{
		$nama = trim($this->session->userdata('nik'));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));

		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		if (!empty($startPeriode)) {
			$param_postperiode = " and periode between '$startPeriode' and '$endPeriode' ";
		} else {
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;
		$dataexcel = $this->m_pk->q_list_kondite_report($paramnya);
		$this->excel_generator->set_query($dataexcel);
		$this->excel_generator->set_header(
			array(
				'NIK',
				'NAMA LENGKAP',
				'BAGIAN',
				'JABATAN',
				'PERIODE',
				'IP',
				'SD',
				'AL',
				'TL',
				'DT',
				'PA',
				'SP1',
				'SP2',
				'SP3',
				'CT',
				'IK',
				'N_IP',
				'N_SD',
				'N_AL',
				'N_TL',
				'N_DT',
				'N_PA',
				'N_SP1',
				'N_SP2',
				'N_SP3',
				'N_CT',
				'N_IK',
				'FS',
				'KATEGORI FS',
				'FS_DESC'
			)
		);

		$this->excel_generator->set_column(
			array(
				'nik',
				'nmlengkap',
				'nmsubdept',
				'nmjabatan',
				'periode',
				'ttlvalueip',
				'ttlvaluesd',
				'ttlvalueal',
				'ttlvaluetl',
				'ttlvalueitl',
				'ttlvalueipa',
				'ttlvaluesp1',
				'ttlvaluesp2',
				'ttlvaluesp3',
				'ttlvaluect',
				'ttlvalueik',
				'c2_ttlvalueip',
				'c2_ttlvaluesd',
				'c2_ttlvalueal',
				'c2_ttlvaluetl',
				'c2_ttlvalueitl',
				'c2_ttlvalueipa',
				'c2_ttlvaluesp1',
				'c2_ttlvaluesp2',
				'c2_ttlvaluesp3',
				'c2_ttlvaluect',
				'c2_ttlvalueik',
				'f_score_k',
				'f_ktg_fs',
				'bpa'
			)
		);

		$this->excel_generator->set_width(
			array(
				12,
				40,
				40,
				40,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				20
			)
		);
		$this->excel_generator->exportTo2007("Report Kondite Karyawan Periode");
	}

	function excel_report_form_pa()
	{
		$nama = trim($this->session->userdata('nik'));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$firstperiode = $startPeriode . '-' . $startPeriode;
		$secondperiode = $endPeriode . '-' . $endPeriode;
		$fnik = strtoupper(trim($this->input->post('nik')));

		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and a.nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		if (!empty($startPeriode)) {
			$param_postperiode = " and periode between '$firstperiode' and '$secondperiode'";
		} else {
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and a.nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		// $param_list_akses = " and userid='$nama'";
		$paramnya = $param_list_akses . $param_postnik . $param_postperiode;

		$dataexcel = $this->m_pk->q_list_report_new($paramnya);
		$this->excel_generator->set_query($dataexcel);
		$this->excel_generator->set_header(
			array(
				'NIK',
				'NAMA LENGKAP',
				'BAGIAN',
				'JABATAN',
				'PERIODE',
				'KATEGORI 1',
				'KATEGORI 2',
				'KATEGORI 3',
				'KATEGORI 4',
				'KATEGORI 5',
				'KATEGORI 6',
				'KATEGORI 7',
				'KATEGORI 8',
				'KATEGORI 9',
				'KATEGORI 10',
				'KATEGORI 11',
				'KATEGORI 12',
				'KATEGORI 13',
				'FS PA',
				'FS KATEGORI',
				'K PA',
				'DESC PA',
				'CATATAN',
				'SARAN'
			)
		);



		$this->excel_generator->set_column(
			array(
				'nik',
				'nmlengkap',
				'nmsubdept',
				'nmjabatan',
				'periode',
				'na1',
				'na2',
				'na3',
				'na4',
				'na5',
				'na6',
				'na7',
				'na8',
				'na9',
				'na10',
				'na11',
				'na12',
				'na13',
				'ttlvalue1',
				'f_value_ktg',
				'kdbpa',
				'bpa',
				'note',
				'suggestion'
			)
		);

		$this->excel_generator->set_width(
			array(
				12,
				30,
				30,
				30,
				20,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				10,
				20,
				20,
				20
			)
		);
		$this->excel_generator->exportTo2007("Report PA Karyawan Periode $startPeriode - $endPeriode");
	}

	function excel_report_form_kpi()
	{
		$nama = trim($this->session->userdata('nik'));
		$tahun = $this->input->post('tahun');
		$fnik = strtoupper(trim($this->input->post('nik')));

		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		if (!empty($tahun)) {
			$param_postperiode = " and tahun = '$tahun'";
		} else {
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		// $param_list_akses = " and userid='$nama'";
		$paramnya = $param_list_akses . 
			$param_postnik . $param_postperiode;

		$dataexcel = $this->m_pk->q_list_kpi_report_yearly($paramnya);
		$this->excel_generator->set_query($dataexcel);
		$this->excel_generator->set_header(
			array(
				'NIK',
				'NAMA LENGKAP',
				'BAGIAN',
				'JABATAN',
				'TAHUN',
				'JANUARI',
				'FEBRUARI',
				'MARET',
				'APRIL',
				'MEI',
				'JUNI',
				'JULI',
				'AGUSTUS',
				'SEPTEMBER',
				'OKTOBER',
				'NOVEMBER',
				'DESEMBER',
				'RATA-RATA'
			)
		);

		$this->excel_generator->set_column(
			array(
				'nik',
				'nmlengkap',
				'nmsubdept',
				'nmjabatan',
				'tahun',
				'januari',
				'februari',
				'maret',
				'april',
				'mei',
				'juni',
				'juli',
				'agustus',
				'september',
				'oktober',
				'november',
				'desember',
				'average'
			)
		);

		$this->excel_generator->set_width(
			array(
				12,
				30,
				30,
				30,
				20,
				15,
				15,
				15,
				15,
				15,
				15,
				15,
				15,
				15,
				15,
				15,
				15,
				15
			)
		);
		$this->excel_generator->exportTo2007("Report KPI Karyawan $tahun");
	}

	function excel_report_form_inspeksi()
	{
		$nama = trim($this->session->userdata('nik'));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " and periode='$periode'";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}


		$paramnya = $param_postnik . $param_postperiode;

		$this->db->query("select sc_pk.pr_report_inspek_final('$nama', '$periode');");
		$dataexcel = $this->m_pk->q_list_inspek_report($paramnya);
		$this->excel_generator->set_query($dataexcel);
		$this->excel_generator->set_header(
			array(
				'NIK',
				'NAMA LENGKAP',
				'BAGIAN',
				'JABATAN',
				'PERIODE',
				'( A )',
				'( S )',
				'( K )',
				'1',
				'2',
				'3',
				'4',
				'5',
				'6',
				'7',
				'8',
				'9',
				'10',
				'11',
				'12',
				'13',
				'14',
				'15',
				'16',
				'17',
				'18',
				'19',
				'20',
				'21',
				'22',
				'23',
				'24',
				'25',
				'26',
				'27',
				'28',
				'29',
				'30',
				'31',
				'32',
				'33',
				'34',
				'35',
				'36',
				'37',
				'38',
				'39',
				'40',
				'41',
				'42',
				'43',
				'44',
				'45',
				'46',
				'47',
				'48',
				'49',
				'50',
				'51',
				'52',
				'53',
				'54',
				'55',
				'56',
				'57',
				'58',
				'59',
				'60',
				'61',
				'62',
				'63',
				'64',
				'65',
				'66',
				'67',
				'68',
				'69',
				'70',
				'TTL IK',
				'TTL ASK',
				'BOBOT ASK',
				'BOBOT IK',
				'FS',
				'FS DESC'
			)
		);



		$this->excel_generator->set_column(
			array(
				'nik',
				'nmlengkap',
				'nmsubdept',
				'nmjabatan',
				'periode',
				'ttlvalue1',
				'ttlvalue2',
				'ttlvalue3',
				'na1',
				'na2',
				'na3',
				'na4',
				'na5',
				'na6',
				'na7',
				'na8',
				'na9',
				'na10',
				'na11',
				'na12',
				'na13',
				'na14',
				'na15',
				'na16',
				'na17',
				'na18',
				'na19',
				'na20',
				'na21',
				'na22',
				'na23',
				'na24',
				'na25',
				'na26',
				'na27',
				'na28',
				'na29',
				'na30',
				'na31',
				'na32',
				'na33',
				'na34',
				'na35',
				'na36',
				'na37',
				'na38',
				'na39',
				'na40',
				'na41',
				'na42',
				'na43',
				'na44',
				'na45',
				'na46',
				'na47',
				'na48',
				'na49',
				'na50',
				'na51',
				'na52',
				'na53',
				'na54',
				'na55',
				'na56',
				'na57',
				'na58',
				'na59',
				'na60',
				'na61',
				'na62',
				'na63',
				'na64',
				'na65',
				'na66',
				'na67',
				'na68',
				'na69',
				'na70',
				'f_avg_valueik',
				'f_avg_valueask',
				'b_valueask',
				'b_valueik',
				'kdbpa',
				'bpa'
			)
		);

		$this->excel_generator->set_width(
			array(
				12,
				40,
				40,
				40,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				20
			)
		);
		$this->excel_generator->exportTo2007("Report Inspeksi Karyawan Periode $periode");
	}

	function excel_report_final_report()
	{
		$nama = trim($this->session->userdata('nik'));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$fnik = strtoupper(trim($this->input->post('nik')));

		if (!empty($startPeriode)) {
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		$paramnya = $param_postnik . $param_postperiode;
		$dataexcel = $this->m_pk->q_final_report_pk_trx($paramnya);
		$this->excel_generator->set_query($dataexcel);
		$this->excel_generator->set_header(
			array(
				'NIK',
				'NAMA LENGKAP',
				'BAGIAN',
				'JABATAN',
				'PERIODE',
				'FS KPI',
				'FS KONDITE',
				'FS PA',
				'B1 KPI 70%',
				'B1 KONDITE 20%',
				'B1 PA 10%',
				'T SCORE',
				'KATEGORI',
				'FS DESC'
			)
		);

		$this->excel_generator->set_column(
			array(
				'nik',
				'nmlengkap',
				'nmsubdept',
				'nmjabatan',
				'periode',
				'fs1_kpi',
				'fs1_kondite',
				'fs1_pa',
				'b1_kpi',
				'b1_kondite',
				'b1_pa',
				'ttls1',
				'ktgs1',
				'nmfs1'
			)
		);

		$this->excel_generator->set_width(
			array(
				12,
				40,
				40,
				40,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				8,
				50
			)
		);
		$this->excel_generator->exportTo2007("Report Final PA Periode $periode");
	}

	function php_test()
	{
		echo json_encode($_REQUEST);
		$nodok = $this->input->post('nodok');
		$periode = $this->input->post('periode');
		$kdkriteria = $this->input->post('kdkriteria');
		$nik = $this->input->post('nik');
		$value1 = $this->input->post('value1');
		$value2 = $this->input->post('value2');
		$info = array(
			'value1' => $value1,
			'value2' => $value2
		);
		$this->db->where('nodok', $nodok);
		$this->db->where('periode', $periode);
		$this->db->where('kdkriteria', $kdkriteria);
		$this->db->where('nik', $nik);
		$this->db->update('sc_pk.pa_form_pa_tmp_dtl', $info);
		$arr = array('a1' => $nodok, 'a' => $periode, 'b' => $value1, 'c' => $value2);

		echo json_encode($arr);
	}

	function generate_perdept_final_pk()
	{
		$nama = trim($this->session->userdata('nik'));
		$dept = $this->input->post('dept');
		$periode = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));

		if (!empty($dept) and !empty($periode)) {
			$this->db->query("select sc_pk.final_report_pk_perdept('$nama', '$periode','$dept');");
		}

		redirect("pk/pk/form_report_final");
	}
	/* GENERATENYA FINAL SCORE */
	function generate_perdept_final_pk_rekap_tmp()
	{
		$nama = trim($this->session->userdata('nik'));
		$dept = $this->input->post('dept');
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$paramnya = " and kddept='$dept' and periode='$periode' ";
		$counttx = $this->m_pk->q_final_score_pk_rekap_trx($paramnya)->num_rows();
		$counttmp = $this->m_pk->q_final_score_pk_rekap_tmp($paramnya)->num_rows();
		$dtltmp = $this->m_pk->q_final_score_pk_rekap_tmp($paramnya)->row_array();
		$dtltrx = $this->m_pk->q_final_score_pk_rekap_trx($paramnya)->row_array();

		/* CEK CLOSING MASING - MASING MENU ERROR CODE 12 */
		$paramcekclose = " and bag_dept='$dept' and periode='$periode' and statustx in ('A','I')";
		$paramncekclosekpi = " and bag_dept='$dept' and periode between '$startPeriode' and '$endPeriode' and statustx in ('A','I')";
		$cekkpi = $this->m_pk->q_view_final_kpi($paramncekclosekpi)->num_rows();
		$cekpa = $this->m_pk->q_tx_form_pa_trx_mst($paramcekclose)->num_rows();
		$cekkondite = $this->m_pk->q_view_final_kondite($paramcekclose)->num_rows();
		$dtlclose = $this->m_pk->q_option_close_fs()->row_array();

		if ($counttmp > 0) {
			$paramerror = " and userid='$nama'";
			$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'nomorakhir1' => trim($dtltmp['nodok']),
				'errorcode' => 4,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/pk/form_report_final_close");
		} else if ($counttx > 0) {
			$paramerror = " and userid='$nama'";
			$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'nomorakhir1' => trim($dtltrx['nodok']),
				'errorcode' => 11,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
			redirect("pk/pk/form_report_final_close");
		} else if (!empty($dept) and !empty($startPeriode) and !empty($endPeriode)) {

			if (($cekkpi > 0 and trim($dtlclose['statusclose']) == 'T') or ($cekpa > 0 and trim($dtlclose['statusclose']) == 'T') or ($cekkondite > 0 and trim($dtlclose['statusclose']) == 'T')) {
				$paramerror = " and userid='$nama'";
				$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'nomorakhir1' => trim($nama),
					'errorcode' => 12,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/pk/form_report_final_close");
			} else {
				$this->db->query("select sc_pk.final_report_pk_perdept_tmp('$nama', '$periode','$dept');");
				$postperiod = $this->fiky_encryption->enkript((trim($periode)));
				$uridept = $this->fiky_encryption->enkript((trim($dept)));

				$paramerror = " and userid='$nama'";
				$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

				$this->db->where('userid', $nama);
				$this->db->where('modul', 'PKPA');
				$this->db->delete('sc_mst.trxerror');
				$insinfo = array(
					'userid' => $nama,
					'nomorakhir1' => '',
					'errorcode' => 0,
					'modul' => 'PKPA'
				);
				$this->db->insert('sc_mst.trxerror', $insinfo);
				redirect("pk/pk/form_report_final_close_tmp" . '/' . $postperiod . '/' . $uridept);
			}
		}
	}

	function form_report_final_close()
	{
		$data['title'] = "REPORT FINAL DEPARTMENT PENILAIAN KARYAWAN";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];

		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */

		/*cek jika ada inputan edit atau input  */
		$param3_1_1 = " and nodok='$nama' and status='I'";
		$param3_1_2 = " and nodok='$nama' and status='E'";
		$param3_1_3 = " and nodok='$nama' and status in ('A','A1')";
		$param3_1_4 = " and nodok='$nama' and status='C'";
		$param3_1_5 = " and nodok='$nama' and status='H'";
		$param3_1_6 = " and nodok='$nama' and status='R'";
		$param3_1_7 = " and nodok='$nama' and status='O'";
		$param3_1_R = " and nodok='$nama'";
		$cekmst_na = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_1)->num_rows(); //input
		$cekmst_ne = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_2)->num_rows(); //edit
		$cekmst_napp = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_3)->num_rows(); //approv
		$cekmst_cancel = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_4)->num_rows(); //cancel
		$cekmst_hangus = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_5)->num_rows(); //hangus
		$cekmst_ra = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_6)->num_rows(); //REALISASI
		$cekmst_ch = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_7)->num_rows(); //REALISASI
		$dtledit = $this->m_pk->q_final_score_pk_rekap_tmp($param3_1_R)->row_array(); //edit row array

		if ($cekmst_na > 0) { //cek inputan
			$enc_kddept = $this->fiky_encryption->enkript((trim($dtledit['kddept'])));
			$enc_periode = $this->fiky_encryption->enkript((trim($dtledit['periode'])));
			redirect("pk/pk/form_report_final_close_tmp/$enc_periode/$enc_kddept");
		} else if ($cekmst_ne > 0) { //cek edit
			$enc_kddept = $this->fiky_encryption->enkript((trim($dtledit['nik'])));
			$enc_periode = $this->fiky_encryption->enkript((trim($dtledit['periode'])));
			redirect("pk/pk/form_report_final_close_tmp/$enc_periode/$enc_kddept");
		} else if ($cekmst_napp > 0) { //cek edit
			$enc_kddept = $this->fiky_encryption->enkript((trim($dtledit['nik'])));
			$enc_periode = $this->fiky_encryption->enkript((trim($dtledit['periode'])));
			redirect("pk/pk/form_report_final_close_tmp/$enc_periode/$enc_kddept");
		}

		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$startPeriode = str_replace('-', '', strtoupper(trim($this->input->post('startPeriode'))));
		$endPeriode = str_replace('-', '', strtoupper(trim($this->input->post('endPeriode'))));
		$periode = $startPeriode . '-' . $endPeriode;
		$fnik = strtoupper(trim($this->input->post('nik')));
		$dept = strtoupper(trim($this->input->post('dept')));

		if (!empty($startPeriode)) {
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = date('Ym');
			$param_postperiode = " ";
		}
		if (!empty($fnik)) {
			$param_postnik = " and nik='$fnik'";
		} else {
			$param_postnik = "";
		}

		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				//                $param_list_akses=" and nik='$nama' ";
				$param_list_akses = "";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;
		$data['approver'] = $this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'PA\' ');

		$paramnya = $param_list_akses . $param_postperiode;
		$paramdept = "";
		$data['list_tx_final_pk'] = $this->m_pk->q_final_score_pk_rekap_trx($paramnya)->result();
		$data['list_dept'] = $this->m_pk->q_mstdepartmen($paramdept)->result();
		$this->template->display('pk/pk/v_list_form_final_pk_close', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function form_report_final_close_tmp()
	{
		$data['title'] = "GENERATE CEKLIST PENILAIAN KARYAWAN PER DEPARTMENT ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];


		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));
		$dept = strtoupper(trim($this->input->post('dept')));

		$postperiod = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$uridept = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = $postperiod; /*$periode=date('Ym'); */
			$param_postperiode = " and periode='$periode'";
		}
		if (!empty($deptpost)) {
			$dept = $deptpost;
		} else {
			$dept = $uridept;
		}



		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;

		$paramnya = $param_list_akses . $param_postperiode;
		$paramdept = "";

		$data['dtlcoll'] = $this->m_pk->q_final_score_pk_rekap_tmp($paramnya)->row_array();
		$data['list_rkp_final_pk'] = $this->m_pk->q_final_score_pk_rekap_tmp($paramnya)->result();
		$data['list_dtl_final_pk'] = $this->m_pk->q_final_report_pk_tmp($paramnya)->result();
		$data['list_dept'] = $this->m_pk->q_mstdepartmen($paramdept)->result();
		$this->template->display('pk/pk/v_list_form_final_pk_close_tmp', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}


	function form_report_final_close_trx()
	{
		$data['title'] = "DETAIL CEKLIST PENILAIAN KARYAWAN PER DEPARTMENT ";
		$nama = trim($this->session->userdata('nik'));
		$dtlbranch = $this->m_akses->q_branch()->row_array();
		$branch = $dtlbranch['branch'];


		/* CODE UNTUK VERSI*/
		$nama = trim($this->session->userdata('nik'));
		$kodemenu = 'I.A.A.1';
		$versirelease = 'I.A.A.1/ALPHA.002';
		$releasedate = date('2019-04-12 00:00:00');
		$versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
		$x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
		$data['x'] = $x['rows'];
		$data['y'] = $x['res'];
		$data['t'] = $x['xn'];
		$data['kodemenu'] = $kodemenu;
		$data['version'] = $versidb;
		/* END CODE UNTUK VERSI */


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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


		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$inputfill = strtoupper(trim($this->input->post('inputfill')));
		$tglYM = str_replace('-', '', strtoupper(trim($this->input->post('periode'))));
		$fnik = strtoupper(trim($this->input->post('nik')));
		$dept = strtoupper(trim($this->input->post('dept')));

		$postperiod = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$uridept = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		if (!empty($tglYM)) {
			$periode = $tglYM;
			$param_postperiode = " and periode='$periode'";
		} else {
			$periode = $postperiod; /*$periode=date('Ym'); */
			$param_postperiode = " and periode='$periode'";
		}
		if (!empty($deptpost)) {
			$dept = $deptpost;
		} else {
			$dept = $uridept;
		}



		/* akses approve atasan */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep_pk($nama)->num_rows();
		$level_akses = strtoupper(trim($userinfo['level_akses']));
		$paramceknama = " and nik='$nama'";
		$ceknik = $this->m_akses->q_master_akses_karyawan($paramceknama)->num_rows();

		if (($ceknikatasan1) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else if (($ceknikatasan2) > 0 and $userhr == 0) {
			$param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where (nik_atasan='$nama')) ";
		} else {
			if ($ceknik > 0 and $userhr == 0) {
				$param_list_akses = " and nik='$nama' ";
			} else {
				$param_list_akses = "";
			}
		}

		$data['nama'] = $nama;
		$data['userhr'] = $userhr;
		$data['level_akses'] = $level_akses;


		$paramdept = " and kddept='$dept'";
		$paramnya = $param_list_akses . $param_postperiode . $paramdept;

		$data['dtlcoll'] = $this->m_pk->q_final_score_pk_rekap_trx($paramnya)->row_array();
		$data['list_rkp_final_pk'] = $this->m_pk->q_final_score_pk_rekap_trx($paramnya)->result();
		$data['list_dtl_final_pk'] = $this->m_pk->q_final_report_pk_trx($paramnya)->result();
		$data['list_dept'] = $this->m_pk->q_mstdepartmen($paramdept)->result();
		$this->template->display('pk/pk/v_list_form_final_pk_close_trx', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function edit_final_penilaian_karyawan_tmp()
	{
		$nama = trim($this->session->userdata('nik'));
		$nik = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));

		$enc_nik = trim($this->uri->segment(4));
		$enc_periode = trim($this->uri->segment(5));
		$param_first = " and nik='$nik' and periode='$periode'";
		$cek_first_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->num_rows();
		$cek_first_trx = $this->m_pk->q_final_report_pk_trx($param_first)->num_rows();
		$dtl_mst_tmp = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();

		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;


		$paramerror = " and userid='$nama' and modul='PKPA'";
		$dtlerror = $this->m_pk->q_trxerror($paramerror)->row_array();
		$count_err = $this->m_pk->q_trxerror($paramerror)->num_rows();
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
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "<div class='alert alert-danger'>$errordesc</div>";
			}
		} else {
			if ($errorcode == '0') {
				$data['message'] = "<div class='alert alert-success'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message'] = "";
			}
		}
		$param_list_akses = " and nik='$nik' and periode='$periode'";
		$data['title'] = ' UBAH DATA FINAL PENILAIAN KARYAWAN ';
		$data['nama'] = $nama;
		$data['dtlrow'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->row_array();
		$data['dtl_mst_trx'] = $this->m_pk->q_final_report_pk_tmp($param_first)->row_array();
		$data['KPI'] = $this->m_pk->q_pk_option(" and kdpk='KPI' and condition1='UNLINK'")->num_rows();
		$data['PA'] = $this->m_pk->q_pk_option(" and kdpk='PA' and condition1='UNLINK'")->num_rows();
		$data['KD'] = $this->m_pk->q_pk_option(" and kdpk='KD' and condition1='UNLINK'")->num_rows();
		$data['IK'] = $this->m_pk->q_pk_option(" and kdpk='IK' and condition1='UNLINK'")->num_rows();
		$data['list_tmp_final_pk'] = $this->m_pk->q_final_report_pk_tmp($param_list_akses)->result();
		$this->template->display('pk/pk/v_edit_final_pk_tmp', $data);

		$paramerror = " and userid='$nama'";
		$dtlerror = $this->m_pk->q_deltrxerror($paramerror);
	}

	function router_final_score_rekap()
	{
		$nama = trim($this->session->userdata('nik'));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$dept = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$type = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$inputby = $nama;
		$inputdate = date('Y-m-d H:i:s');

		if ($type == 'EDITREKAPFS') {

			$info = array('status' => 'E', 'updatedate' => $inputdate, 'updateby' => $inputby);
			$this->db->where('kddept', $dept);
			$this->db->where('periode', $periode);
			$this->db->update("sc_pk.rekap_final_report_pk_trx", $info);
			redirect("pk/pk/form_report_final_close_tmp" . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
		} else if ($type == 'APPROVREKAPFS') {

			$info = array('status' => 'A1', 'approvedate' => $inputdate, 'approveby' => $inputby);
			$this->db->where('kddept', $dept);
			$this->db->where('periode', $periode);
			$this->db->update("sc_pk.rekap_final_report_pk_trx", $info);
			redirect("pk/pk/form_report_final_close_tmp" . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
		} else if ($type == 'DETAILREKAPFS') {
			redirect("pk/pk/form_report_final_close_trx" . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
		} else {
			$paramerror = " and userid='$nama'";
			$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'nomorakhir1' => '',
				'errorcode' => 1,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);

			redirect("pk/pk/form_report_final_close");
		}
	}

	function hitung_ulang_final_score()
	{
		$nama = trim($this->session->userdata('nik'));
		$periode = $this->fiky_encryption->dekript((trim($this->uri->segment(4))));
		$dept = $this->fiky_encryption->dekript((trim($this->uri->segment(5))));
		$type = $this->fiky_encryption->dekript((trim($this->uri->segment(6))));
		$inputby = $nama;
		$inputdate = date('Y-m-d H:i:s');

		if ($periode == '' or $dept == '') {
			$paramerror = " and userid='$nama'";
			$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'nomorakhir1' => '',
				'errorcode' => 1,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
		} else {
			$this->db->query("select sc_pk.hitung_final_report_pk_perdept_tmp('$nama', '$periode', '$dept')");

			$paramerror = " and userid='$nama'";
			$dtlerror = $this->m_pk->q_deltrxerror($paramerror);

			$this->db->where('userid', $nama);
			$this->db->where('modul', 'PKPA');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array(
				'userid' => $nama,
				'nomorakhir1' => '',
				'errorcode' => 13,
				'modul' => 'PKPA'
			);
			$this->db->insert('sc_mst.trxerror', $insinfo);
		}

		redirect("pk/pk/form_report_final_close_tmp" . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
	}

	function cetak($enc_nik, $enc_periode)
	{
		$periode = $this->fiky_encryption->dekript($enc_periode);
		$nik = $this->fiky_encryption->dekript($enc_nik);

		$nama = trim($this->session->userdata('nik'));
		// $enc_docno = $this->input->get('enc_docno');
		$title = "Cetak Penilaian Karyawan";

		$datajson = base_url("pk/pk/api_cetak/$enc_nik/$enc_periode");
		$datamrt = base_url("assets/mrt/final_report_pk.mrt");
		return $this->fiky_report->render($datajson, $datamrt, $title, $nama);
	}

	function api_cetak($enc_nik, $enc_periode)
	{
		$periode = $this->fiky_encryption->dekript($enc_periode);
		$nik = $this->fiky_encryption->dekript($enc_nik);

		$datamst = array_map('trim', $this->m_pk->get_final_penilaian_karyawan($nik, $periode)->row_array());
		// $dtoption = $this->m_berita_acara->q_select_setup_option_ctk()->row_array();
		$datapa = $this->m_pk->get_penilaian_pa($nik, $periode)->result_array();
		$list_pa = array_map(function ($item) {
			return array_map('trim', $item);
		}, $datapa);
		$datakondite = array_map('trim', $this->m_pk->get_penilaian_kondite($nik, $periode)->row_array());
		// $dtlbag = $this->m_berita_acara->q_select_detail_perbagian($idrekap)->result_array();
		header("Content-Type: text/json");
		echo json_encode(
			[
				'detail' => $datamst,
				'list_pa' => $list_pa,
				'data_kondite' => $datakondite
				// 'detailbag' => $dtlbag
			],
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
		);
	}

	function actionpopuppa($param)
	{
		$this->load->model(array('master/M_ApprovalRule'));
		$json = json_decode(
			hex2bin($param)
		);
		$transaction = $this->m_pk->q_transaction_read_where_pa(' AND status IN (\'A\') AND nodok = \'' . $json->nodok . '\' ')->row();
		header('Content-Type: application/json');
		if (!is_null($transaction->nodok) && !is_null($transaction->nodok) && !empty($transaction->nodok)) {
			if (
				$this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'PA\' ')
				// or $this->m_pk->q_transaction_read_where_pa(' AND nodok = \''.$transaction->nodok.'\' AND superiors ILIKE \'%'.TRIM($this->session->userdata('nik')).'%\' ')->num_rows() > 0
			) {
				echo json_encode(
					array(
						'data' => $transaction,
						'statustext' => 'Apakah anda yakin ?',
						'type' => 'Dokumen PA',
						'canapprove' => true,
						'next' => array(
							// 'update' => site_url('trans/dinas/update/' . bin2hex(json_encode(array('branch' => empty($transaction->branch) ? $this->session->userdata('branch') : $transaction->branch, 'nodok' => $transaction->nodok)))),
							'approve' => site_url('pk/pk/detail_generate_pa/' . bin2hex($this->encrypt->encode(trim($transaction->nik))) . '/' . bin2hex($this->encrypt->encode(trim($transaction->periode))))
						),
					)
				);
			} else {
				header('Content-Type: application/json');
				http_response_code(403);
				echo json_encode(
					array(
						'data' => array(),
						'message' => 'Anda tidak memiliki akses'
					)
				);
			}
		} else {
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Dokumen tidak ditemukan'
				)
			);
		}
	}
	function actionpopupkondite($param)
	{
		$this->load->model(array('master/M_ApprovalRule'));
		$json = json_decode(
			hex2bin($param)
		);
		$transaction = $this->m_pk->q_transaction_read_where_kondite(' AND status IN (\'A\') AND nodok = \'' . $json->nodok . '\' ')->row();
		header('Content-Type: application/json');
		if (!is_null($transaction->nodok) && !is_null($transaction->nodok) && !empty($transaction->nodok)) {
			if ( // $this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'IJ\' ') or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or
				$this->m_pk->q_transaction_read_where_kondite(' AND nodok = \'' . $transaction->nodok . '\' AND superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' ')->num_rows() > 0
			) {
				echo json_encode(
					array(
						'data' => $transaction,
						'statustext' => 'Apakah anda yakin ?',
						'type' => 'Dokumen Kondite',
						'canapprove' => true,
						'next' => array(
							// 'update' => site_url('trans/dinas/update/' . bin2hex(json_encode(array('branch' => empty($transaction->branch) ? $this->session->userdata('branch') : $transaction->branch, 'nodok' => $transaction->nodok)))),
							'approve' => site_url('pk/pk/detail_kondite/' . bin2hex($this->encrypt->encode(trim($transaction->nik))) . '/' . bin2hex($this->encrypt->encode(trim(substr($transaction->periode, 0, 6)))) . '/' . bin2hex($this->encrypt->encode(trim(substr($transaction->periode, 7, 6)))))
						),
					)
				);
			} else {
				header('Content-Type: application/json');
				http_response_code(403);
				echo json_encode(
					array(
						'data' => array(),
						'message' => 'Anda tidak memiliki akses'
					)
				);
			}
		} else {
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Dokumen tidak ditemukan'
				)
			);
		}
	}

	function actionpopupfpk($param)
	{
		$this->load->model(array('master/M_ApprovalRule'));
		$json = json_decode(
			hex2bin($param)
		);
		$transaction = $this->m_pk->q_transaction_read_where_fpk(' AND status IN (\'A\') AND nodok = \'' . $json->nodok . '\' ')->row();
		header('Content-Type: application/json');
		if (!is_null($transaction->nodok) && !is_null($transaction->nodok) && !empty($transaction->nodok)) {
			if (
				$this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'PA\' ')
				// or $this->m_pk->q_transaction_read_where_pa(' AND nodok = \''.$transaction->nodok.'\' AND superiors ILIKE \'%'.TRIM($this->session->userdata('nik')).'%\' ')->num_rows() > 0
			) {
				echo json_encode(
					array(
						'data' => $transaction,
						'statustext' => 'Apakah anda yakin ?',
						'type' => 'Dokumen Final Penilaian',
						'canapprove' => true,
						'next' => array(
							// 'update' => site_url('trans/dinas/update/' . bin2hex(json_encode(array('branch' => empty($transaction->branch) ? $this->session->userdata('branch') : $transaction->branch, 'nodok' => $transaction->nodok)))),
							'approve' => site_url('pk/pk/router_final_score_rekap/' . bin2hex($this->encrypt->encode(trim($transaction->periode))) . '/' . bin2hex($this->encrypt->encode(trim($transaction->kddept))) . '/' . bin2hex($this->encrypt->encode(trim('APPROVREKAPFS'))))
						),
					)
				);
			} else {
				header('Content-Type: application/json');
				http_response_code(403);
				echo json_encode(
					array(
						'data' => array(),
						'message' => 'Anda tidak memiliki akses'
					)
				);
			}
		} else {
			header('Content-Type: application/json');
			http_response_code(404);
			echo json_encode(
				array(
					'data' => array(),
					'message' => 'Dokumen tidak ditemukan'
				)
			);
		}
	}

	public function recalculateConditee()
	{
		header('Content-Type: application/json');
		$this->load->model(array('pk/m_pk'));
		$selectedPeriod = $this->input->post('selectedPeriod');
		$selectedEmployee = $this->input->post('selectedEmployee');
		if (empty($selectedPeriod) && empty($selectedEmployee)) {
			http_response_code(402);
			echo json_encode(
				array(
					'message' => 'Periode tidak boleh kosong',
				)
			);
		} else {
			$selectedPeriod = date('Ymt', strtotime($selectedPeriod));
			if ($this->m_pk->recalculateConditeeBySelection($selectedPeriod, $selectedEmployee)) {
				http_response_code(200);
				echo json_encode(
					array(
						'message' => 'Berhasil dihitung ulang',
					)
				);
			} else {
				http_response_code(402);
				echo json_encode(
					array(
						'message' => 'Gagal hitung ulang',
					)
				);
			}
		}

	}
}
