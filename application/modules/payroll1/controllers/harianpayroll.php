<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Harianpayroll extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_harianpayroll','m_ceklembur','m_generate','trans/m_karyawan'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	/*-------------------- START OF LEMBUR------------------ */
	function index(){
      
		//echo 'test';
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
		else if($this->uri->segment(4)=="fail_list"){
			$tglawal=$this->uri->segment(5);
			$tglakhir=$this->uri->segment(6);
            $data['message']="<div class='alert alert-danger'>Periode $tglawal s/d $tglakhir Belum Dilakukan Generate Harian</div>";
		}
        else
            $data['message']='';

        $data['title']='LIHAT LEMBUR KARYAWAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.E.2'; $versirelease='I.P.E.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['list_kary']=$this->m_karyawan->list_karyawan()->result();
		$this->template->display('payroll/harianpayroll/v_utama',$data);	
	
		
    }
	
	function lihat_lembur_nik(){
		
        $data['message']='';
		$nodok=$this->session->userdata('nik');
		$tptr1=$this->input->post('tptr');
		$tanggal=$this->input->post('tglnik');
		$niklp=$this->uri->segment(4);
		$nikps=$this->input->post('nik');
		if (empty($niklp) and !empty($nikps)){
			$nik=$nikps;
			$tglnik=explode(' - ',$tanggal);
			$tgl1=$tglnik[0];
			$tgl2=$tglnik[1];
			
			$tglawal=date('Y-m-d',strtotime($tgl1));
			$tglakhir=date('Y-m-d',strtotime($tgl2));
			$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
			$tgle=date('d',strtotime($tglawal));
			//$kdgroup_pg=$this->input->post('kdgroup_pg');	
			//$kddept=$this->input->post('kddept');
		
		} else if (empty($nikps) and !empty($niklp) ){
			$nik=$niklp;
			$tglawal=$this->uri->segment(5);	
			$tglakhir=$this->uri->segment(6);
			$tptr2=$this->uri->segment(8);
			
		} else {
			$nik='';
		}
		
		$kddept=0;

		if (empty($tanggal) and empty($nik)) {
			redirect('payroll/harianpayroll/index');
			
		} else if (!empty($tanggal) and !empty($nik)){
		
		
		} 
		
		if(empty($tptr1)){
			$data['tptr']=$tptr2;
			$tptr=$tptr2;	
		}else{
			$data['tptr']=$tptr1;
			$tptr=$tptr1;
		}
		if($tptr=='tmp'){
				$cek=$this->m_harianpayroll->q_sumlembur_nik($tglawal,$tglakhir,$nik)->num_rows();
				if($cek==0){
				redirect("payroll/harianpayroll/index/fail_list/$tglawal/$tglakhir");
				}
				$data['list_lembur']=$this->m_harianpayroll->q_sumlembur_nik($tglawal,$tglakhir,$nik)->result();
		}else{
				$cek=$this->m_harianpayroll->q_sumlembur_niktrx($tglawal,$tglakhir,$nik)->num_rows();
				if($cek==0){
				redirect("payroll/harianpayroll/index/fail_list/$tglawal/$tglakhir");
				}
				$data['list_lembur']=$this->m_harianpayroll->q_sumlembur_niktrx($tglawal,$tglakhir,$nik)->result();
		}

		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['nik']=$nik;
		$data['title']="List Lembur Periode $tglawal Hingga $tglakhir";

		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/harianpayroll/v_list',$data);
		
	}
	
	function lihat_lembur(){
		
        $data['message']='';
		$nodok=$this->session->userdata('nik');
		
		$tanggal=$this->input->post('tgl');	
		$tptr1=$this->input->post('tptr');	//type transaksi
		$test=$this->uri->segment(6);
		$nik='';

		if (empty($tanggal) and empty($test)) {
			redirect('payroll/harianpayroll/index');
			
		} else if (!empty($tanggal) and empty($test)){
		
		$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
		$tgle=date('d',strtotime($tglawal));
		$kddept=$this->input->post('kddept');
		
		} else if (empty($tanggal) and !empty($test) and empty($tptr)){
		
		$nik=$this->uri->segment(4);
		$tglawal=$this->uri->segment(5);
		$tglakhir=$this->uri->segment(6);
		$kddept=$this->uri->segment(7);
		$tptr2=$this->uri->segment(8);

		
		}
		if(empty($tptr1)){
			$data['tptr']=$tptr2;
			$tptr=$tptr2;	
		}else{
			$data['tptr']=$tptr1;
			$tptr=$tptr1;
		}
		
		if($tptr=='tmp' or $tptr2='tmp'){ //seleksi trx
			$cek=$this->m_harianpayroll->q_sumlembur($tglawal,$tglakhir,$kddept)->num_rows();
			if($cek=0){
				redirect("payroll/harianpayroll/index/fail_list/$tglawal/$tglakhir");
			}
			$data['list_lembur']=$this->m_harianpayroll->q_sumlembur($tglawal,$tglakhir,$kddept)->result();
		}else{
			$cek=$this->m_harianpayroll->q_sumlemburtrx($tglawal,$tglakhir,$kddept)->num_rows();
			if($cek=0){
				redirect("payroll/harianpayroll/index/fail_list/$tglawal/$tglakhir");
			}
			$data['list_lembur']=$this->m_harianpayroll->q_sumlemburtrx($tglawal,$tglakhir,$kddept)->result();
		}
		$data['title']="List Lembur Periode $tglawal Hingga $tglakhir";
		
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		$data['nik']=$nik;

		$this->template->display('payroll/harianpayroll/v_list',$data);
		
	}
	
	
	function lihat_lembur_dtl($nik,$tglawal,$tglakhir,$kddept,$tptr){
		
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
		
		$data['title']="List Lembur Periode $tglawal Hingga $tglakhir";
		$data['list_lembur']=$this->m_harianpayroll->list_lembur_nominal($nik,$tglawal,$tglakhir)->result();
		$data['nik']=$nik;
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		$data['tptr']=$tptr;
		
		$this->template->display('payroll/harianpayroll/v_list_dtl_lembur',$data);
		
	}
	
		
	public function excel_sumlemburdept(){
		
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
		$nik=trim($this->uri->segment(7));
		$nodok=$this->session->userdata('nik');
		
		if ($kddept==0 and !empty($nik)){

		$datane=$this->m_harianpayroll->q_sumlembur_nik($tglawal,$tglakhir,$nik);
		//echo $nik;
		}
		else {
	
		$datane=$this->m_harianpayroll->q_sumlembur($tglawal,$tglakhir,$kddept);
		//echo $kddept;
		}
		$this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Lengkap','Group Penggajian','Nominal'));
	    $this->excel_generator->set_column(array('nik','nmlengkap','grouppenggajian','nominal'));
        $this->excel_generator->set_width(array(20,20,20,20));
        $this->excel_generator->exportTo2007('Summary Lembur ');

	
	
	
	}

		
	public function excel_dtllemburdept(){
		$nik=$this->uri->segment(4);
		$tglawal=$this->uri->segment(5);
		$tglakhir=$this->uri->segment(6);
		//$kdgroup_pg=$this->uri->segment(7);
		
		
		$datane=$this->m_harianpayroll->list_lembur_nominal($nik,$tglawal,$tglakhir);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nomor Dokumen','Nama Karyawan','Group Penggajian','Tanggal Kerja','Jam Mulai','Jam Selesai','Jam Mulai Mesin','Jam Selesai Mesin','Durasi SPL','Durasi Absen','Nominal','Keterangan'
													));
	   $this->excel_generator->set_column(array('nik','nodok_ref','nmlengkap','grouppenggajian','tgl_kerja1','jam_mulai','jam_selesai','jam_mulai_absen','jam_selesai_absen','jam','jam2','nominal1','ketsts'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20,20,20,20,20,20,20,80
												));
        $this->excel_generator->exportTo2007('Summary Lembur Detail');
	}

	
	function sliplembur_pdf(){
		
		$nik=$this->uri->segment(4);
		$data['ta']=$tglawal=$this->uri->segment(5);
		$data['tk']=$tglakhir=$this->uri->segment(6);
		$data['list_lembur']=$this->m_harianpayroll->q_sliplembur($nik,$tglawal,$tglakhir)->result();
		$data['lo']=$this->m_harianpayroll->q_sliplembur($nik,$tglawal,$tglakhir)->row_array();
		//$this->load->view('pdf_reader/v_sliplembur_pdf',$data);
		$this->pdf->load_view('harianpayroll/v_sliplembur_pdf',$data);
		$this->pdf->set_paper('f4','landscape');
		$this->pdf->render();		
		$this->pdf->stream("Slip Lembur.pdf");	
	
	}
	
	public function report_lembur(){
		$tanggal=$this->input->post('tgl');
		$tgl=explode(' - ',$tanggal);
		$tptr=$this->input->post('tptr');		
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		if($tptr=='tmp'){
		$datane=$this->m_harianpayroll->q_report_lembur($tgl1,$tgl2);}
		else{
		$datane=$this->m_harianpayroll->q_report_lemburtrx($tgl1,$tgl2);}	
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','No Dokumen','Nama Karyawan','Bagian/Department','Tgl Kerja','Durasi SPL','Durasi Absensi','Upah Lembur','Keterangan','Group'
													));
	    $this->excel_generator->set_column(array('nik','nodok_ref','nmlengkap','nmdept','tgl_kerja','jam','jam2','nominal','keterangan','grouppenggajian'
													));
        $this->excel_generator->set_width(array(20,20,40,20,20,20,20,20,20,20
												));
        $this->excel_generator->exportTo2007("Report Lembur All Department Periode $tgl1 sampai $tgl2");
	}
	
	/* --------------END VIEW OF LEMBUR --------------*/
	
	/* --------------START OF SHIFT --------------*/
	function shift(){
	
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
		
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_harianpayroll->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['title']='SUMMARY Tunjangan Shift';
		$this->template->display('payroll/harianpayroll/v_utama_shift',$data);	
	
	
	}
		
		
	
	function lihat_shift(){
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
		
		$nik=$this->input->post('karyawan');
		$kddept=$this->input->post('kddept');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		if (empty($tanggal)) {
			redirect('payroll/harianpayroll/shift');
		}
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		
		$nodok=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Periode $tglawal Hingga $tglakhir";
		$data['list_shift']=$this->m_harianpayroll->q_sum_shift($kddept)->result();
		$data['list_jamkerja']=$this->m_harianpayroll->q_jamkerja()->result();
		$total_nominal1=$this->m_harianpayroll->total_nominal_shift($nodok,$nik)->row_array();
		$data['total_nominal']=$total_nominal1['total_nominal'];
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nik']=$nik;	
		$data['kddept']=$kddept;
		$this->template->display('payroll/harianpayroll/v_list_shift',$data);
		
	}
	
	function lihat_dtl_shift(){

			$tglawal=$this->uri->segment(6);
			$tglakhir=$this->uri->segment(7);
			$kddept=$this->uri->segment(5);
			$nik=$this->uri->segment(4);
		$nodok=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Periode $tglawal Hingga $tglakhir";
		$data['list_shift']=$this->m_harianpayroll->q_shift($kddept,$nik)->result();
		$data['list_jamkerja']=$this->m_harianpayroll->q_jamkerja()->result();
		$total_nominal1=$this->m_harianpayroll->total_nominal_shift($nik)->row_array();
		$data['total_nominal']=$total_nominal1['total_nominal'];
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nik']=$nik;
		$data['kddept']=$kddept;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/harianpayroll/v_list_dtl_shift',$data);
		
	}
	
	public function excel_sumshift(){
		
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
		$datane=$this->m_harianpayroll->q_sum_shift($kddept);
		$this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Lengkap','Departemen','Nominal'));
	    $this->excel_generator->set_column(array('nik','nmlengkap','nmdept','nominal1'));
        $this->excel_generator->set_width(array(20,20,20,20));
        $this->excel_generator->exportTo2007('Summary Tunjangan Shift');

	}

		
	public function excel_dtlshift(){
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
		$nik=$this->uri->segment(7);
		$datane=$this->m_harianpayroll->q_shift($kddept,$nik);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Karyawan','Tanggal Kerja','Shift','Jam Masuk','Jam Selesai','Nominal'
													));
	    $this->excel_generator->set_column(array('nik','nmlengkap','tgl_kerja','tpshift','jam_mulai_absen','jam_selesai_absen','nominal1'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20,24
												));
        $this->excel_generator->exportTo2007('Shift Detail');
	}

	/* ----------------( END VIEW OF SHIFT) --------------- */
	
	
	/*------------------ ( START VIEW UPAH BORONG)--------------  */
	function upah_borong(){
	
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
		else if($this->uri->segment(4)=="fail_list"){
			$tglawal=$this->uri->segment(5);
			$tglakhir=$this->uri->segment(6);
            $data['message']="<div class='alert alert-danger'>Periode $tglawal s/d $tglakhir Belum Dilakukan Generate Harian</div>";
		}
        else
            $data['message']='';
		
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['title']='LIHAT SUMMARY UPAH BORONG';
		$this->template->display('payroll/harianpayroll/v_utama_borong',$data);	
	
	
	}
	
	function lihat_borong(){
	
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
		
		$tanggal=$this->input->post('tgl');				
		$test=$this->uri->segment(6);
		if (empty($tanggal) and empty($test)) {
			redirect('payroll/harianpayroll/upah_borong');
			
		} else if (!empty($tanggal) and empty($test)){
		
		$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
		$tgle=date('d',strtotime($tglawal));
		//$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		
		} else if (empty($tanggal) and !empty($test)){
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		//$kdgroup_pg=$this->uri->segment(6);
		$kddept=$this->uri->segment(6);
		}
		
		$ceknull=$this->m_harianpayroll->q_cek_borong($tglawal,$tglakhir,$kddept)->num_rows();
		if ($ceknull==0){

			redirect("payroll/harianpayroll/upah_borong/fail_list/$tglawal/$tglakhir");
		}
		
		$data['title']="List Borong Periode $tglawal Hingga $tglakhir";
		$data['list_borong']=$this->m_harianpayroll->q_cek_borong($tglawal,$tglakhir,$kddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		
		$this->template->display('payroll/harianpayroll/v_list_borong',$data);

	}
	

	function lihat_borong_detail(){
		
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
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$nik=$this->uri->segment(6);
		$kddept=$this->uri->segment(7);

		$data['title']="List Borong Periode $tglawal Hingga $tglakhir";
		$data['list_borong']=$this->m_harianpayroll->q_cek_borong_detail($tglawal,$tglakhir,$nik,$kddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nik']=$nik;
		$data['nodok']=$nodok;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
	
		$this->template->display('payroll/harianpayroll/v_list_dtl_borong',$data);

	}
	
	function vedit_borong(){
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$nodok_ref=$this->uri->segment(6);
		$nik=$this->uri->segment(7);
		$kddept=$this->uri->segment(8);
		$data['title']="List Detail Upah Borong No. Dokumen $nodok_ref";
		$data['total_upah']=$this->m_harianpayroll->total_upah_dtl($nodok_ref)->row_array();
		$data['list_upah_dtl']=$this->m_harianpayroll->q_upah_borong_detail($nodok_ref)->result();
		$data['tglawal']=$tglawal;
		$data['nodok_ref']=$nodok_ref;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['nik']=$nik;
		$this->template->display('payroll/harianpayroll/v_edit_borong',$data);
	
	}
	
	
	public function excel_sum_borong(){
		
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
	
		$datane=$this->m_harianpayroll->q_cek_borong($tglawal,$tglakhir,$kddept);
		$this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Karyawan','Total Upah'));
	    $this->excel_generator->set_column(array('nik','nmlengkap','total_upah'));
        $this->excel_generator->set_width(array(20,20,20));
        $this->excel_generator->exportTo2007("Summary Upah Borong $tglawal s/d $tglakhir");
	
	}
	
	public function excel_dtl_borong(){
		$nik=$this->uri->segment(4);
		$tglawal=$this->uri->segment(5);
		$tglakhir=$this->uri->segment(6);
	
		$datane=$this->m_harianpayroll->q_cek_borong_detail($nodok,$tglawal,$tglakhir,$nik);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Karyawan','Nomor Dokumen','Tanggal Kerja','Nominal','Keterangan'
													));
	    $this->excel_generator->set_column(array('nik','nmlengkap','nodok_ref','tgl_kerja','total_upah','keterangan'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20
												));
        $this->excel_generator->exportTo2007("Detail Summary Borong $nik");
	}
	
	public function excel_edit_borong(){
		$nodok_ref=$this->uri->segment(4);
	
		$datane=$this->m_harianpayroll->q_upah_borong_detail($nodok_ref);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nodok','KD Borong','KD Sub Borong','Metrik','Satuan','Tarif Satuan','Upah Borong','Total Target','Pencapaian',
												'Nama Borong','Nama Sub Borong','Catatan'	
													));
	    $this->excel_generator->set_column(array('nodok','kdborong','kdsub_borong','metrix','satuan','tarif_satuan','upah_borong','total_target','pencapaian',
												'nmborong','nmsub_borong','catatan'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20,20,20,20,
												20,20,20
												));
        $this->excel_generator->exportTo2007("Detail Upah Borong");
	}
	
	
	/*------------------- ( END VIEW UPAH BORONG) ----------------- */
	
	/*------------------- ( START OF VIEW ABSEN) ----------------- */
	
	function absen(){
	
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
		else if($this->uri->segment(4)=="fail_list"){
			$tglawal=$this->uri->segment(5);
			$tglakhir=$this->uri->segment(6);
            $data['message']="<div class='alert alert-danger'>Periode $tglawal s/d $tglakhir Belum Dilakukan Generate Harian</div>";
		}
        else
            $data['message']='';
        /* CODE UNTUK VERSI*/
        $data['title']='Lihat Potongan Absen Karyawan';
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.E.2'; $versirelease='I.P.E.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $data['list_kary']=$this->m_karyawan->list_karyawan()->result();
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();

		$this->template->display('payroll/harianpayroll/v_utama_absen',$data);	
	
	
	}
	
	function lihat_absen(){
		
		
		$kddept1=trim($this->uri->segment(6));
		$kddept2=$this->input->post('kddept');
		$tptr=$this->input->post('tptr');
		if (!empty($kddept2) and empty($kddept1)){
				$tanggal=$this->input->post('tgl');				
				if (empty($tanggal)) {
					redirect('payroll/harianpayroll/absen');
				}
				$tgl=explode(' - ',$tanggal);
				
				$tgl1=$tgl[0];
				$tgl2=$tgl[1];
				
				$tglawal=date('Y-m-d',strtotime($tgl1));
				$tglakhir=date('Y-m-d',strtotime($tgl2));
				$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
				$tgle=date('d',strtotime($tglawal));		
				$kdgroup_pg=$this->input->post('kdgroup_pg');
				$kddept=$kddept2;
		} else if(!empty($kddept1)and empty($kddept2)){
			$tglawal=$this->uri->segment(4);
			$tglakhir=$this->uri->segment(5);
			$kddept=$kddept1;
		}
				
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Data Absen Sukses Disimpan</div>";
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
		$data['title']="List Potongan Absen Periode $tglawal Hingga $tglakhir";

		if ($tptr==='trx'){
            $cek=$this->m_harianpayroll->q_sum_absen_trx($tglawal,$tglakhir,$kddept)->num_rows();
            if($cek==0){
                redirect("payroll/harianpayroll/absen/fail_list/$tglawal/$tglakhir");
            }

            $data['list_absen']=$this->m_harianpayroll->q_cek_absen_trx($nodok,$tglawal,$tglakhir)->result();
            $data['list_sum_absen']=$this->m_harianpayroll->q_sum_absen_trx($tglawal,$tglakhir,$kddept)->result();
        } else {
            $cek=$this->m_harianpayroll->q_sum_absen($tglawal,$tglakhir,$kddept)->num_rows();
            if($cek==0){
                redirect("payroll/harianpayroll/absen/fail_list/$tglawal/$tglakhir");
            }

            $data['list_absen']=$this->m_harianpayroll->q_cek_absen($nodok,$tglawal,$tglakhir)->result();
            $data['list_sum_absen']=$this->m_harianpayroll->q_sum_absen($tglawal,$tglakhir,$kddept)->result();
        }
        $data['list_karyawan']=$this->m_harianpayroll->list_karyawan()->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		
		$this->template->display('payroll/harianpayroll/v_list_absen',$data);
		
	}

    function lihat_absen_nik(){


        $nik1=trim($this->uri->segment(6));
        $nik2=$this->input->post('nik');
        $tptr=$this->input->post('tptr');
        if (!empty($nik2) and empty($nik1)){
            $tanggal=$this->input->post('tgl');
            if (empty($tanggal)) {
                redirect('payroll/harianpayroll/absen');
            }
            $tgl=explode(' - ',$tanggal);

            $tgl1=$tgl[0];
            $tgl2=$tgl[1];

            $tglawal=date('Y-m-d',strtotime($tgl1));
            $tglakhir=date('Y-m-d',strtotime($tgl2));
            $tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
            $tgle=date('d',strtotime($tglawal));
            $kdgroup_pg=$this->input->post('kdgroup_pg');
            $nik=$nik2;
        } else if(!empty($nik1)and empty($nik2)){
            $tglawal=$this->uri->segment(4);
            $tglakhir=$this->uri->segment(5);
            $nik=$nik1;
        }

        if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Data Absen Sukses Disimpan</div>";
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
        $data['title']="List Potongan Absen Periode $tglawal Hingga $tglakhir";

        if ($tptr==='trx'){
            $cek=$this->m_harianpayroll->q_sum_absen_trx_nik($tglawal,$tglakhir,$nik)->num_rows();
            if($cek==0){
                redirect("payroll/harianpayroll/absen/fail_list/$tglawal/$tglakhir");
            }

            $data['list_absen']=$this->m_harianpayroll->q_cek_absen_trx_nik($nodok,$tglawal,$tglakhir)->result();
            $data['list_sum_absen']=$this->m_harianpayroll->q_sum_absen_trx_nik($tglawal,$tglakhir,$nik)->result();
        } else {
            $cek=$this->m_harianpayroll->q_sum_absen_nik($tglawal,$tglakhir,$nik)->num_rows();
            if($cek==0){
                redirect("payroll/harianpayroll/absen/fail_list/$tglawal/$tglakhir");
            }

            $data['list_absen']=$this->m_harianpayroll->q_cek_absen_nik($nodok,$tglawal,$tglakhir)->result();
            $data['list_sum_absen']=$this->m_harianpayroll->q_sum_absen_nik($tglawal,$tglakhir,$nik)->result();
        }
        $data['list_karyawan']=$this->m_harianpayroll->list_karyawan()->result();
        $data['tglawal']=$tglawal;
        $data['tglakhir']=$tglakhir;
        $data['kddept']=$nik;

        $this->template->display('payroll/harianpayroll/v_list_absen',$data);

    }
		
	function lihat_absen_dtl(){
		
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
		$tglawal=$this->uri->segment(5);
		$tglakhir=$this->uri->segment(6);
		$nik=$this->uri->segment(4);
		$kddept=$this->uri->segment(7);
		$data['title']="List Lembur Periode $tglawal Hingga $tglakhir";
		$data['list_absen']=$this->m_harianpayroll->q_cek_absen($nik,$tglawal,$tglakhir)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		$data['nik']=$nik;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/harianpayroll/v_list_dtl_absen',$data);
		
	}
	
	
	public function excel_sum_absen(){
		
		
		$tglawal=$this->uri->segment(4);
		$tglakhir=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
	
		$datane=$this->m_harianpayroll->q_sum_absen($tglawal,$tglakhir,$kddept);
		$this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Karyawan','Nominal'));
	    $this->excel_generator->set_column(array('nik','nmlengkap','cuti_nominal'));
        $this->excel_generator->set_width(array(20,20,20));
        $this->excel_generator->exportTo2007("Summary Potongan Absen $tglawal s/d $tglakhir");
	
	}
	
	public function excel_sum_absendtl(){
		$nik=$this->uri->segment(4);
		$tglawal=$this->uri->segment(5);
		$tglakhir=$this->uri->segment(6);
	
		$datane=$this->m_harianpayroll->q_cek_absen($nik,$tglawal,$tglakhir);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Karyawan','Tanggal Kerja','Golongan Shift','Nominal','Keterangan'
													));
	    $this->excel_generator->set_column(array('nik','nmlengkap','tgl_kerja','shiftke','cuti_nominal','ketsts'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20
												));
        $this->excel_generator->exportTo2007("Detail Summary Lembur Detail $nik");
	}


    public function report_absen(){
        $tanggal=$this->input->post('tgl');
        $tgl=explode(' - ',$tanggal);
        $tptr=$this->input->post('tptr');
        $tgl1=$tgl[0];
        $tgl2=$tgl[1];

        if($tptr=='tmp'){
            $datane=$this->m_harianpayroll->q_report_absen_tmp($tgl1,$tgl2);}
        else{
            $datane=$this->m_harianpayroll->q_report_absen_trx($tgl1,$tgl2);}

        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama Lengkap','Jumlah Potongan'
        ));
        $this->excel_generator->set_column(array('nik','nmlengkap','cuti_nominal'
        ));
        $this->excel_generator->set_width(array(20,40,20
        ));
        $this->excel_generator->exportTo2007("Report Jumlah Absensi Periode $tgl1 sampai $tgl2");
    }
	/*------------------- ( END VIEW ABSEN) ----------------- */
	

	
	
}	