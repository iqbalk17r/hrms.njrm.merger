<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Ceklembur extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_ceklembur','m_generate','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){

        $data['title']='Generate Lembur';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.2'; $versirelease='I.P.A.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['dtlopt']=$this->m_generate->q_setup_option_dept()->row_array();
		$this->template->display('payroll/ceklembur/v_utama',$data);	
	
		
    }
	
	function shift(){

        $data['title']='Generate Shift';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.5'; $versirelease='I.P.A.5/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_ceklembur->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['dtlopt']=$this->m_generate->q_setup_option_dept()->row_array();
		$this->template->display('payroll/ceklembur/v_utama_shift',$data);	
	
	
	}
	
	function upah_borong(){

        $data['title']='Generate Upah Borong';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.1'; $versirelease='I.P.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukes Disimpan, Silahkan Generate Ulang</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="tgl_failed")
            $data['message']="<div class='alert alert-warning'>Anda Belum Memproses Tanggal Sebelum Ini</div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['dtlopt']=$this->m_generate->q_setup_option_dept()->row_array();
		$this->template->display('payroll/ceklembur/v_utama_borong',$data);	
	
	
	}
	
	function absen(){

        $data['title']='Generate Potongan Absen';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.4'; $versirelease='I.P.A.4/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="tgl_failed")
            $data['message']="<div class='alert alert-warning'>Anda Belum Memproses Tanggal Sebelum Ini</div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['dtlopt']=$this->m_generate->q_setup_option_dept()->row_array();
		$this->template->display('payroll/ceklembur/v_utama_absen',$data);
	
	
	}
	
	

	function lihat_lembur(){

        $data['title']='Generate Lembur';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.2'; $versirelease='I.P.A.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */


		$nodok=$this->session->userdata('nik');
		$tglawal=trim($this->uri->segment(4));
		$tglakhir=trim($this->uri->segment(5));
		$kddept=trim($this->uri->segment(6));

		$dtlsetup=$this->m_ceklembur->q_setup_option_dept()->row_array();
		if (trim($dtlsetup['status'])!='T'){
			$pkddept="";
		} else {
			
			$pkddept=" and kddept='$kddept'";
		}
		
		$data['message']='';
		$data['title']="List Lembur Periode $tglawal Hingga $tglakhir";
		$data['list_lembur']=$this->m_ceklembur->list_lembur_nominal($tglawal,$tglakhir,$nodok,$pkddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/ceklembur/v_list',$data);
		
	}
	
	function lihat_shift_all($tglawal,$tglakhir,$kddept){
        $data['title']='Generate Shift';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.5'; $versirelease='I.P.A.5/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */


		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Absensi NIK $nik Sukses Diubah</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		
		$nodok=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Periode $tglawal Hingga $tglakhir";
		$data['list_shift']=$this->m_ceklembur->q_shiftall($tglawal,$tglakhir,$kddept)->result();
		$data['list_jamkerja']=$this->m_ceklembur->q_jamkerja()->result();
		//$total_nominal1=$this->m_ceklembur->total_nominal_shift($nodok,$nik)->row_array();
		//$data['total_nominal']=$total_nominal1['total_nominal'];
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/ceklembur/v_list_shiftall',$data);
		
	}
	
	
	function lihat_shift($tglawal,$tglakhir,$kddept,$nik){
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.5'; $versirelease='I.P.A.5/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Absensi NIK $nik Sukses Diubah</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		
		$nodok=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Periode $tglawal Hingga $tglakhir";
		$data['list_shift']=$this->m_ceklembur->q_shift($nodok,$nik)->result();
		$data['list_jamkerja']=$this->m_ceklembur->q_jamkerja()->result();
		$total_nominal1=$this->m_ceklembur->total_nominal_shift($nodok,$nik)->row_array();
		$data['total_nominal']=$total_nominal1['total_nominal'];
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nik']=$nik;
		//$data['kddept']=$kddept;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/ceklembur/v_list_shift',$data);
		
	}
	
	function lihat_borong($tglawal,$tglakhir,$nodok,$kddept){
        $data['title']='Generate Upah Borong';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.A.1'; $versirelease='I.P.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Nomor $nodok Sukses Diubah</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$nodok=$this->session->userdata('nik');
		$data['title']="List Borong Periode $tglawal Hingga $tglakhir";
		$data['list_borong']=$this->m_ceklembur->q_cek_borong($nodok,$tglawal,$tglakhir,$kddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$this->template->display('payroll/ceklembur/v_list_borong',$data);
		
	}
	
	
	function lihat_borong_detail($tglawal,$tglakhir,$nik,$kddept){
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Nomor $nodok Sukses Diubah</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$nodok=$this->session->userdata('nik');
		$data['title']="List Borong Periode $tglawal Hingga $tglakhir";
		$data['list_borong']=$this->m_ceklembur->q_cek_borong_detail($nodok,$tglawal,$tglakhir,$nik)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nodok']=$nodok;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		//echo $nik;
		$this->template->display('payroll/ceklembur/v_list_dtl_borong',$data);
		
		
	}
	
	function lihat_absen(){
		$nodok=$this->session->userdata('nik');
		$tglawal=trim($this->uri->segment(4));
		$tglakhir=trim($this->uri->segment(5));
		$kddept=trim($this->uri->segment(6));

		$data['message']="";
		$dtlsetup=$this->m_ceklembur->q_setup_option_dept()->row_array();
		if (trim($dtlsetup['status'])!='T'){
			$pkddept="";
		} else {
			
			$pkddept=" and kddept='$kddept'";
		}
		
		
		$data['title']="List Potongan Absen Periode $tglawal Hingga $tglakhir";
		$data['list_absen']=$this->m_ceklembur->q_cek_absen($nodok,$tglawal,$tglakhir,$pkddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kddept']=$kddept;
		
		$this->template->display('payroll/ceklembur/v_list_absen',$data);
		
	}


    function proses_lembur(){
        $nama=$this->session->userdata('nik');
        $tanggal=$this->input->post('tgl');
        $tgl=explode(' - ',$tanggal);
        if (empty($tanggal)) {
            redirect('payroll/ceklembur/index');
        }
        $tgl1=$tgl[0];
        $tgl2=$tgl[1];

        $tglawal=date('Y-m-d',strtotime($tgl1));
        $tglakhir=date('Y-m-d',strtotime($tgl2));
        $kdgroup_pg=trim($this->input->post('kdgroup_pg'));
        $kddept=trim($this->input->post('kddept'));

        if (empty($kddept) or $kddept==''){
            $pkddept=" and grouppenggajian='$kdgroup_pg' ";
        } else {

            $pkddept=" and kddept='$kddept'";
        }
        $txtin = "select sc_his.pr_up_history_gaji('$tglawal'||'|'||'$nama')";
        $txtout = "select sc_his.pr_up_history_gaji('$tglakhir'||'|'||'$nama')";
        $txt = "select sc_tmp.pr_lembur_generate('$tglawal'||'|'||'$tglakhir'||'|'||'$kddept'||'|'||'$kdgroup_pg'||'|'||''||'|'||'$nama')";
        $this->db->query($txt);
        $this->db->query($txtin);
        /* PENAMBAHAN OPTION SETTING UNTUK PERHITUNGAN GAJIPOKOK DAN TETAP*/
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        /* SYSTEM01  SYS01: GENERAL MODE , SYS02: STANDLONE MODE*/
        $optstandlone = $this->m_akses->q_option(" and kdoption='SYSTEM01'")->row_array();
        if (trim($optstandlone['value1']) == 'SYS01') //GENERAL MODE SYS01, STANDELONE MODE SYS01
        { $this->db->query($txtout); }
        redirect("payroll/ceklembur/lihat_lembur/$tglawal/$tglakhir/$kddept");
    }
	
	
	function proses_shift(){
		
		//$nik=$this->input->post('karyawan');
		$kddept=$this->input->post('kddept');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		
		$dtlsetup=$this->m_ceklembur->q_setup_option_dept()->row_array();
		if (trim($dtlsetup['status'])!='T'){
			$pkddept="  and grouppenggajian='$kdgroup_pg'";
		} else {
			
			$pkddept=" and kddept='$kddept'";
		}


		if (empty($tanggal)) {
			redirect('payroll/ceklembur/shift');
		}
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$this->delete_tmp_shift($tglawal,$tglakhir,$kddept);
		$q1=$this->m_ceklembur->q_nominal_shift2()->row_array();
		$tj_shift2=$q1['value3'];
		$q2=$this->m_ceklembur->q_nominal_shift3()->row_array();
		$tj_shift3=$q2['value3'];
		$datane=$this->m_ceklembur->q_transready_shift($tglawal,$tglakhir,$pkddept)->result();
        /*SYSTEM01  SYS01: GENERAL MODE , SYS02: STANDLONE MODE*/
        $optstandlone = $this->m_akses->q_option(" and kdoption='SYSTEM01'")->row_array();
        if (trim($optstandlone['value1']) == 'SYS01') //GENERAL MODE SYS01, STANDELONE MODE SYS01
        { foreach ($datane as $dta) {

            $nik=$dta->nik;
            /*pengecekan mapping karyawan*/
            $cek_map_kary=$this->m_ceklembur->q_cek_map($nik)->row_array();
            $nikmap=null;
            if(!empty($cek_map_kary['nikmap'])) {
                $nikmap=trim($cek_map_kary['nikmap']);
            }

            if ($nikmap==$nik){
                $nik=trim($cek_map_kary['nik']);
                //$nikmap=trim($cek_map_kary['nikmap']);
            }


            $jam_masuk=$dta->jam_masuk_absen;
            $jam_pulang=$dta->jam_pulang_absen;
            $tgl_absen=$dta->tgl;
            $shiftke=$dta->shiftke;


            if ($shiftke=='2'){
                $nominal=$tj_shift2;
            } else {
                $nominal=$tj_shift3;

            }

            $looping_shift=array(
                'nik'=>$nik,
                'nodok'=>$this->session->userdata('nik'),
                'jam_mulai_absen'=>$jam_masuk,
                'jam_selesai_absen'=>$jam_pulang,
                'tgl_kerja'=>$tgl_absen,
                'nominal'=>$nominal,
                'tpshift'=>$shiftke,


            );

            $this->db->insert('sc_tmp.cek_shift',$looping_shift);



        } }

		$this->lihat_shift_all($tglawal,$tglakhir,$kddept);
	}
	
	function proses_borong(){
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$querytglawal=$this->m_generate->q_tglclosingawal()->row_array();
		$tglawal=$querytglawal['value3'];
		$querytglakhir=$this->m_generate->q_tglclosingakhir()->row_array();
		$tglakhir=$querytglakhir['value3'];
			
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tglref=$tglakhir.'-'.$bulan.'-'.$tahun; $tgl=$bulan.$tahun;
			
		} else {
			$tahun=$thn; $bulan=$bln; $tglref=$tglakhir.'-'.$bulan.'-'.$tahun; $tgl=$bulan.$tahun;
			
		}
		switch ($bulan){
			case '01': $bul='Januari'; break;
			case '02': $bul='Februari'; break;
			case '03': $bul='Maret'; break;
			case '04': $bul='April'; break;
			case '05': $bul='Mei'; break;
			case '06': $bul='Juni'; break;
			case '07': $bul='Juli'; break;
			case '08': $bul='Agustus'; break;
			case '09': $bul='September'; break;
			case '10': $bul='Oktober'; break;
			case '11': $bul='November'; break;
			case '12': $bul='Desember'; break;
		}
		
		$tglakhirfix=date('Y-m-d',strtotime($tglref));
		$tgl3=date('Y-m-d',strtotime('-1 month',strtotime($tglref)));	
		$tgl4=date('Y',strtotime($tgl3));
		$tgl5=date('m',strtotime($tgl3));
		$tglawalfix=$tgl4.'-'.$tgl5.'-'.$tglawal;		
		
		/*$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];*/
		
		$tglawal=date('Y-m-d',strtotime($tglawalfix));
		$tglakhir=date('Y-m-d',strtotime($tglakhirfix));
		$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
		$tgle=date('d',strtotime($tglawal));
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		
		$dtlsetup=$this->m_ceklembur->q_setup_option_dept()->row_array();
		if (trim($dtlsetup['status'])!='T'){
			$pkddept="  and grouppenggajian='$kdgroup_pg'";
		} else {
			
			$pkddept=" and kddept='$kddept'";
		};
		
		
		$this->delete_tmp_borong($tglawal,$tglakhir,$kdgroup_pg,$kddept);
		$datane4=$this->m_ceklembur->q_upah_borong($tglawal,$tglakhir,$kdgroup_pg,$kddept)->result();
		
		foreach ($datane4 as $dta4){
			$nik=$dta4->nik;
			/*pengecekan mapping karyawan*/
			$cek_map_kary=$this->m_ceklembur->q_cek_map($nik)->row_array();
				$nikmap=null;
			if(!empty($cek_map_kary['nikmap'])) { 
			$nikmap=trim($cek_map_kary['nikmap']); 
			}
			
			if ($nikmap==$nik){
				$nik=trim($cek_map_kary['nik']);
				//$nikmap=trim($cek_map_kary['nikmap']);
			}
			$nodok_ref=$dta4->nodok;
			$tgl_dok=$dta4->tgl_dok;
			$periode=$dta4->periode;
			$tgl_kerja=$dta4->tgl_kerja;
			$total_upah=$dta4->total_upah;
			
			$looping_upahborong=array(
				'nik'=>$nik,
				'nodok'=>$this->session->userdata('nik'),	
				'nodok_ref'=>$nodok_ref,
				'periode'=>$periode,
				'tgl_kerja'=>$tgl_kerja,
				'tgl_dok'=>$tgl_dok,
				'total_upah'=>$total_upah,
			);
			/*if ($tgle==01) {
				$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);
			} else {
				$cekbelum=$this->m_ceklembur->q_borongbelum($tglbelum,$kdgroup_pg,$kddept)->num_rows();
				if ($cekbelum==0){
					redirect("payroll/ceklembur/upah_borong/tgl_failed");
				} else {
					$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);

				}	
				//$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);
			
			}*/
			$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);
		}	
		$nodok=$this->session->userdata('nik');
		$this->lihat_borong($tglawal,$tglakhir,$nodok,$kddept);
	
	}
	
	function proses_absen(){
/* ADA TAMBAH OPTION SETING  */
		$tanggal=$this->input->post('tgl');				
		if (empty($tanggal)) {
			redirect('payroll/ceklembur/absen');
		}
		$tgl=explode(' - ',$tanggal);
		
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
		$tgle=date('d',strtotime($tglawal));		
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		
		$dtlsetup=$this->m_ceklembur->q_setup_option_dept()->row_array();
		if (trim($dtlsetup['status'])!='T'){
			$pkddept="  and grouppenggajian='$kdgroup_pg'";
		} else {
			
			$pkddept=" and kddept='$kddept'";
		}

		/*penambahan kolom gaji+ log history gaji 22/01/2017*/
		$tglinput=date('Y-m-d');
		$nama=$this->session->userdata('nik');
/* PENAMBAHAN OPTION SETTING UNTUK PERHITUNGAN GAJIPOKOK DAN TETAP*/
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
/* PAYROL04  A: GAJIPOKOK , B: GAJITETAP*/
        $optiongp = $this->m_akses->q_option(" and kdoption='PAYROL04'")->row_array();
		$datane2=$this->m_ceklembur->q_transready_absen($tglawal,$tglakhir,$kdgroup_pg,$pkddept)->result();
/* SYSTEM01  SYS01: GENERAL MODE , SYS02: STANDLONE MODE*/
        $optstandlone = $this->m_akses->q_option(" and kdoption='SYSTEM01'")->row_array();
        if (trim($optstandlone['value1']) == 'SYS01') //GENERAL MODE SYS01, STANDELONE MODE SYS01
        {

            $this->m_ceklembur->delete_tmp_absen($tglawal,$tglakhir);
            foreach ($datane2 as $dta2) {

                $nik = trim($dta2->nik);
                /*pengecekan mapping karyawan*/
                $cek_map_kary = $this->m_ceklembur->q_cek_map($nik)->row_array();
                $nikmap = null;
                if (!empty($cek_map_kary['nikmap'])) {
                    $nikmap = trim($cek_map_kary['nikmap']);
                }

                if ($nikmap == $nik) {
                    $nik = trim($cek_map_kary['nik']);
                    //$nikmap=trim($cek_map_kary['nikmap']);
                }

                $tgl_absen = $dta2->tgl;
                $shiftke = $dta2->shiftke;
                $status = 'I';

                /*penambahan kolom gaji dan kolom periode*/
                $periodegaji = date('Ym', strtotime($tgl_absen));
                $cekhistorygaji = $this->m_ceklembur->q_history_gaji($nik, $periodegaji)->num_rows();
                $mstpeg = $this->m_ceklembur->q_karyawan($nik)->row_array();


                $gajitetap = $mstpeg['gajitetap'] ?: 0;
                $gajipokok = $mstpeg['gajipokok'] ?: 0;
                $gajitj = $mstpeg['tj_tetap'] ?: 0;

                if (trim($optiongp['value1']) == 'A') //GAJI POKOK
                {
                    $gajihitung = $gajipokok;
                } else if (trim($optiongp['value1']) == 'B') {
                    $gajihitung = $gajitetap;
                } else {
                    $gajihitung = 0;
                }
                if ($cekhistorygaji == 0) {
                    $this->db->query("insert into sc_his.history_gaji (branch,nik,periode,nominal,inputdate,inputby,updatedate,updateby,gajipokok,gajitj)
				values ($branch,'$nik','$periodegaji',$gajitetap,'$tglinput','$nama',null,null,$gajipokok,$gajitj);");
                }
                $looping_absen = array(
                    'nik' => $nik,
                    'nodok' => $this->session->userdata('nik'),
                    'tgl_kerja' => $tgl_absen,
                    'shiftke' => $shiftke,
                    'status' => $status,
                    'nikmap' => $nikmap,
                    'gajipokok' => $gajihitung,
                    'periode_gaji' => trim($periodegaji),
                    'jam_masuk_absen' => $dta2->jam_masuk_absen,
                    'jam_pulang_absen' => $dta2->jam_pulang_absen,
                );
                $this->db->insert('sc_tmp.cek_absen', $looping_absen);


            }
        }
		$nik=$this->session->userdata('nik');
		$nodok=$this->session->userdata('nik');
		$txt1='select cek_jadwal('.chr(39).$tglawal.chr(39).','.chr(39).$tglakhir.chr(39).','.chr(39).trim($nodok).chr(39).','.chr(39).chr(39).')';
		$pr=$this->db->query($txt1);	
		//$this->lihat_absen($tglawal,$tglakhir,$kddept);
		redirect("payroll/ceklembur/lihat_absen/$tglawal/$tglakhir/$kddept");
		
	}
	
	function delete_tmp($tglawal,$tglakhir){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.cek_shift where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.cek_absen where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' and nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.cek_lembur where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.cek_borong where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' nodok='$nodok'");
		
		

	}
	
	function delete_tmp_borong($tglawal,$tglakhir,$kdgroup_pg){
		$nodok=trim($this->session->userdata('nik'));
		$this->db->query("delete from sc_tmp.cek_borong
						where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' 
						and nodok='$nodok'");
	}
	
	function delete_tmp_shift($tglawal,$tglakhir,$kddept){
		$nodok=($this->session->userdata('nik'));
		$this->db->query("delete from sc_tmp.cek_shift where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' 
						and nodok='$nodok'");
	}				
	
	function edit_borong($nodok,$tglawal,$tglakhir,$nik,$kddept){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Data Absen $nik Sukses Disimpan</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['title']="List Detail Upah Borong No. Dokumen $nodok";
		$data['total_upah']=$this->m_ceklembur->total_upah_dtl($nodok)->row_array();
		$data['list_upah_dtl']=$this->m_ceklembur->q_upah_borong_detail($nodok)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['nik']=$nik;
		$this->template->display('payroll/ceklembur/v_edit_borong',$data);
	
	}
	
	function edit_borong_master(){
		$nodok=$this->input->post('nodok');
		$nik=$this->input->post('nik');
		$total_upah=$this->input->post('total_upah');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$this->db->query("update sc_trx.upah_borong_mst set total_upah='$total_upah' where nik='$nik' and nodok='$nodok'");
		$this->db->query("update sc_tmp.cek_borong set total_upah='$total_upah' where nik='$nik' and nodok_ref='$nodok'");
		redirect("payroll/ceklembur/lihat_borong/$tglawal/$tglakhir/$nodok/rep_succes");
	
	}
	
	function edit_borong_detail(){
		
		$nik=trim($this->input->post('nik'));
		$nodok=$this->input->post('nodok');
		$tarif_satuan=$this->input->post('tarif_satuan');
		$total_target=$this->input->post('total_target');
		$catatan=$this->input->post('catatan');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$kddept=$this->input->post('kddept');
		$pencapaian=str_replace(",",".",$this->input->post('pencapaian'));
		$upah_borong1=($pencapaian-$total_target)*$tarif_satuan;
		$no_urut=trim($this->input->post('no_urut'));
		if ($upah_borong1<=0){
			$upah_borong=0;
		} else {
			$upah_borong=$upah_borong1;
		}
		
		
		//echo $tpcuti;
		$info=array(
			
			
			'pencapaian'=>$pencapaian,
			'upah_borong'=>$upah_borong,
			'catatan'=>strtoupper($catatan),
		);
		//echo $kdupah_borong;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_upah_borong->q_upah_borong($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->where('no_urut',$no_urut);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.upah_borong_dtl',$info);
		$this->db->query("update sc_trx.upah_borong_mst set total_upah=(select sum(upah_borong) as total_upah from sc_trx.upah_borong_dtl where nodok='$nodok')
							where nodok='$nodok'");
		$this->db->query("update sc_tmp.cek_borong set total_upah=(
						select total_upah from sc_trx.upah_borong_mst
						where nodok='$nodok')
						where nodok_ref='$nodok'");					
		//echo $kddept.$kdgroup_pg;
		redirect("payroll/ceklembur/edit_borong/$nodok/$tglawal/$tglakhir/$nik/$kdgroup_pg/$kddept");
		
	}
	
	function edit_lembur(){

		$nodok=$this->input->post('nodok');
		$nik=$this->input->post('nik');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=$this->input->post('jam_mulai_absen');
		$jam_selesai=$this->input->post('jam_selesai_absen');
		
		
		if (empty($nodok)){
			redirect("payroll/ceklembur");
		}
		
	///	$this->db->query("update sc_trx.lembur set status='U',tgl_jam_mulai='$jam_mulai',tgl_jam_selesai='$jam_selesai' where nodok='$nodok' and nik='$nik'");
	///	$this->db->query("update sc_trx.lembur set status='P' where nodok='$nodok' and nik='$nik'");
		
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where tgl='$tgl_kerja' and nik='$nik'");
		redirect("payroll/ceklembur/lihat_lembur/$tglawal/$tglakhir/$nodok/rep_succes");
	
	
	}
	
	function edit_absen(){
	
		$nik=$this->input->post('nik');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=$this->input->post('jam_mulai');
		$jam_selesai=$this->input->post('jam_selesai');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$kddept=$this->input->post('kddept');
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where nik='$nik' and tgl='$tgl_kerja'");
		redirect("payroll/ceklembur/lihat_absen/$tglawal/$tglakhir/$kddept/rep_succes");
	}
	
	function edit_shift(){
	
		$nik=$this->input->post('nik');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=str_replace("_","",$this->input->post('jam_mulai'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$kddept=$this->input->post('kddept');
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where nik='$nik' and tgl='$tgl_kerja'");
		redirect("payroll/ceklembur/lihat_shift/$tglawal/$tglakhir/$kddept/$nik/rep_succes");
	}
	
	function hapus_shift($nik,$tgl_kerja){
		$this->db->query("update sc_trx.transready set jam_masuk_absen=null,jam_pulang_absen=null where nik='$nik' and tgl='$tgl_kerja'");
		redirect("payroll/ceklembur/shift");
	
	}
	
	function input_shift(){
		$nik=$this->input->post('nik');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=str_replace("_","",$this->input->post('jam_mulai'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$kdjamkerja=$this->input->post('kdjamkerja');
		
		$cek=$this->m_ceklembur->cek_absen($nik,$tgl_kerja)->num_rows();
		if ($cek>0){
			$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where nik='$nik' and tgl='$tgl_kerja'");
		
		} else {
			$absen=array(
				'nik'=>$nik,
				'tgl'=>$tgl_kerja,
				'kdjamkerja'=>$kdjamkerja,
				'jam_masuk_absen'=>$jam_mulai,
				'jam_pulang_absen'=>$jam_selesai,
				
			);
			$this->db->insert('sc_trx.transready',$absen);
		
		}
		redirect("payroll/ceklembur/shift/rep_succes");
	}
	
	 
	
	

}	