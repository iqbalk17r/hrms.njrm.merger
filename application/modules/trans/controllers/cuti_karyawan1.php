<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Cuti_karyawan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		//$this->load->model('m_cuti_karyawan');
        $this->load->model(array('m_cuti_karyawan','master/m_akses'));	
		$this->load->library(array('form_validation','template','upload','pdf','Excel_generator')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Cuti/Cuti Khusus/Cuti Dinas Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve Atau Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes"){
			$nik=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Cuti NIK : <b>$nik</b> Sukses Disimpan </div>";
		}	
		else if($this->uri->segment(4)=="del_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Dihapus </div>";
		}	
		else if($this->uri->segment(4)=="app_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Di Approval</div>";
		}
		else if($this->uri->segment(4)=="data_kembar"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Nik pada hari itu sudah mengajukan cuti !!!!</div>";
		}
		else if($this->uri->segment(4)=="cancel_succes"){	
            $nodok=$this->uri->segment(5);
			$data['message']="<div class='alert alert-danger'>Dokumen Dengan Nomor <b>$nodok</b> Telah Dibatalkan</div>";
		}
		else if($this->uri->segment(4)=="edit_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Data dengan Nomor: <b>$nodok</b> Berhasil Diubah</div>";
		}
        else if($this->uri->segment(4)=="nohakcuti")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Memilik Hak Cuti</div>";
		else
            $data['message']='';
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$nikatasan='';		
		$status1=$this->input->post('status');
		/* pending 27-04-2016 trial ceklist per department per atasan dsb
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	
		$cekdept=$this->m_akses->list_aksesperdep($nama)->num_rows();
		
		//cekdepartemen($nama)=bacasetup('') (on progress yaaa )
	
		if (($cekdept)>=1){
			$nikatasan='';	
		}
		else if (($ceknikatasan2)>=1){		
			$nikatasan="where x1.nik_atasan2='$nama' and x1.status='A2'";	
		}
		else if (($ceknikatasan1)>=1){
			$nikatasan="where x1.nik_atasan2='$nama' and x1.status='A1'";	
			
		}
		else{
			$nikatasan="where x1.nik='$nama'";
		}
		*/
		if (empty($thn) and empty($status1)){
			$tahun=date('Y'); $bulan=date('m'); 
			$tgl=$bulan.$tahun;
			$status='is not NULL';
			
		} 
		else if (empty($status1)){
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			$status='is not NULL';
			
		}
		else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			$status="='$status1'";
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
		
		
		//$data['list_lk']=$this->m_cuti_karyawan->list_karyawan_index($nik)->row_array();
		$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();
		$data['list_cuti_karyawan']=$this->m_cuti_karyawan->q_cuti_karyawan($tgl,$status,$nikatasan)->result();
		//$data['list_cuti_karyawan_dtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl()->result();
		//$data['list_cutidtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl()->row_array();
		$data['list_karyawan']=$this->m_cuti_karyawan->list_karyawan()->result();
		$data['cek_tglmskkerja']=$this->m_cuti_karyawan->cek_tglmsukkerja()->row_array();
		$data['cekclosing']=$this->m_cuti_karyawan->cek_closing()->row_array();
		//$data['list_trxtype']=$this->m_cuti_karyawan->list_trxtype()->result();
		//$data['list_cuti_karyawan']=$this->m_cuti_karyawan->list_cuti_karyawan()->result();
		//$data['list_rk']=$this->m_cuti_karyawan->q_cuti_karyawan($nik)->row_array();
		
		//$nike=$this->session->userdata('nik');
		$kmenu='I.T.B.2';
		$data['aksesapprovene']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['aksesatasan1']=$this->m_akses->list_aksesatasan1($nama)->num_rows();
		//$data['aksesatasan2']=$this->m_akses->list_aksesatasan2($nama)->num_rows();
		//$data['aksesdept']=$this->m_akses->list_aksesperdep($nama)->num_rows();
		//$cekakses=$this->m_akses->list_aksespermenu($nike,$kmenu)->row_array();
		
		
        $this->template->display('trans/cuti_karyawan/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		//echo "test";
		
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_cuti_karyawan->list_karyawan()->result();

		
		$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();
		//$data['list_trxtype']=$this->m_cuti_karyawan->list_trxtype()->result();
		//$data['list_lk2']=$this->m_cuti_karyawan->list_karyawan_index($nik)->row_array();
		//$data['list_lk']=$this->m_cuti_karyawan->list_karyawan_index()->result();
		$this->template->display('trans/cuti_karyawan/v_list_karyawan',$data);
		
	}
	
	function input($nik){
		$data['title']="Input Cuti Karyawan";
		$data['list_pelimpahan']=$this->m_cuti_karyawan->list_pelimpahan($nik)->result();
		$data['list_lk']=$this->m_cuti_karyawan->list_karyawan_index($nik)->result();
		$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();	
		$this->template->display('trans/cuti_karyawan/v_input_cuti',$data);
		
	}
	function add_cuti_karyawan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		//$atasan=$this->input->post('atasan');
		//$atasan2=$this->input->post('atasan2');
		$kdijin_khusus1=$this->input->post('kdijin_khusus');
		
		/*CEKHER cuti jika belum 1 tahun g dioleh karo mas andik
		
		$cekhakcuti=$this->m_cuti_karyawan->q_cekhakcuti($nik)->num_rows();
		if (empty($nik)) {
			redirect('trans/cuti_karyawan/index');
		} else if ($cekhakcuti>0){			
			redirect('trans/cuti_karyawan/index/nohakcuti');
		} */
		
		
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		$tgl_awal1=$this->input->post('tgl_awal');
		if ($tgl_awal1==''){
			$tgl_awal=NULL;
		} else {
			$tgl_awal=$tgl_awal1;
		}
		$tgl_selesai1=$this->input->post('tgl_selesai');
		if ($tgl_selesai1==''){
			$tgl_selesai=NULL;
		} else {
			$tgl_selesai=$tgl_selesai1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		//$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$alamat=$this->input->post('alamat');
		$pelimpahan=$this->input->post('pelimpahan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$statusptg=$this->input->post('statptg');
		
		//$cekdouble=$this->m_cuti_karyawan->cek_cuti_karyawan($nik)->row_array();
		$cekdb2=$this->m_cuti_karyawan->cek_cuti_karyawan2($nik,$tgl_awal,$tgl_selesai)->num_rows();
		
		if(trim($cekdb2)>0){
			redirect("trans/cuti_karyawan/index/data_kembar");
		}

		
		//echo $tpcuti;
		$info=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'kddept'=>strtoupper($kddept),
			'kdsubdept'=>strtoupper($kdsubdept),
			'tpcuti'=>strtoupper($tpcuti),
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			//'nmatasan'=>$atasan,
			//'nmatasan2'=>$atasan2,
			'tgl_dok'=>$tgl_dok,
			'kdijin_khusus'=>$kdijin_khusus,
			'tgl_mulai'=>$tgl_awal,
			'tgl_selesai'=>$tgl_selesai,
			'jumlah_cuti'=>$jumlah_cuti,
			'pelimpahan'=>$pelimpahan,
			'keterangan'=>strtoupper($keterangan),
			'alamat'=>strtoupper($alamat),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
			'status_ptg'=>strtoupper($statusptg)
		);
		
		$this->db->insert('sc_tmp.cuti_karyawan',$info);
		redirect("trans/cuti_karyawan/index/rep_succes/$nik");
		
	}
	//edit cuti karyawan
	function edit(){
		
			$data['title']='Edit Cuti Karyawan';
			$nodok=$this->uri->segment(4);
			$nama=$this->session->userdata('nik');
			//$data['nik']=$nik;
			$kmenu='I.T.B.2';
			$data['aksesapprovene']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
			$data['aksesatasan1']=$this->m_akses->list_aksesatasan1($nama)->num_rows();
			//$data['aksesatasan2']=$this->m_akses->list_aksesatasan2($nama)->num_rows();
			//$data['aksesdept']=$this->m_akses->list_aksesperdep($nama)->num_rows();
			//$cekakses=$this->m_akses->list_aksespermenu($nike,$kmenu)->row_array();
			$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();
			$data['dtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl($nodok)->row_array();
			$data['cekclosing']=$this->m_cuti_karyawan->cek_closing()->row_array();
			$data['list_cutidtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl($nodok)->row_array();
			$data['list_karyawan']=$this->m_cuti_karyawan->list_karyawan()->result();
			$this->template->display('trans/cuti_karyawan/edit_cuti',$data);
	
	}
	//detail cuti karyawan
	function detail(){
		
			$data['title']='Detail Cuti Karyawan';
			$nodok=$this->uri->segment(4);
			$nama=$this->session->userdata('nik');
			//$data['nik']=$nik;
			$kmenu='I.T.B.2';
			$data['aksesapprovene']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
			$data['aksesatasan1']=$this->m_akses->list_aksesatasan1($nama)->num_rows();
			//$data['aksesatasan2']=$this->m_akses->list_aksesatasan2($nama)->num_rows();
			//$data['aksesdept']=$this->m_akses->list_aksesperdep($nama)->num_rows();
			//$cekakses=$this->m_akses->list_aksespermenu($nike,$kmenu)->row_array();
			$data['dtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl($nodok)->row_array();
			$data['cekclosing']=$this->m_cuti_karyawan->cek_closing()->row_array();
			$data['list_cutidtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl($nodok)->row_array();
			$data['list_karyawan']=$this->m_cuti_karyawan->list_karyawan()->result();
			$this->template->display('trans/cuti_karyawan/detail_cuti',$data);
			
	}
	function edit_cuti_karyawan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdijin_khusus1=$this->input->post('kdijin_khusus');
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		$tgl_awal1=$this->input->post('tgl_awal');
		if ($tgl_awal1==''){
			$tgl_awal=NULL;
		} else {
			$tgl_awal=$tgl_awal1;
		}
		$tgl_selesai1=$this->input->post('tgl_selesai');
		if ($tgl_selesai1==''){
			$tgl_selesai=NULL;
		} else {
			$tgl_selesai=$tgl_selesai1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		//$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$alamat=$this->input->post('alamat');
		$pelimpahan=$this->input->post('pelimpahan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$statusptg=$this->input->post('statptg');
		$info=array(
		
			'jumlah_cuti'=>$jumlah_cuti,
			'kdijin_khusus'=>$kdijin_khusus,
			'tpcuti'=>strtoupper($tpcuti),
			'tgl_mulai'=>$tgl_awal,
			'tgl_selesai'=>$tgl_selesai,
			'pelimpahan'=>$pelimpahan,
			'alamat'=>strtoupper($pelimpahan),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
			'status_ptg'=>strtoupper($statusptg)
			
		);
		
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		
		if($cek==0){
			redirect("trans/cuti_karyawan/index/kode_failed");
		} else
		{
			$this->db->where('nodok',$nodok);				
				$this->db->update('sc_trx.cuti_karyawan',$info);
				redirect("trans/cuti_karyawan/index/edit_succes/$nodok");
		}	
	}
	
	function hps_cuti_karyawan($nik,$nodok){
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		
			if ($cek==0) {
				redirect("trans/cuti_karyawan/index/kode_failed");
			} else {
				
				$this->db->query("update sc_trx.cuti_karyawan set status='D' where nodok='$nodok'");
				redirect("trans/cuti_karyawan/index/del_succes/$nodok");
			}
		
	}
	
	function approval(){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//$nike=$this->session->userdata('nik');
		//$kmenu='I.T.B.2';
		//$cekakses=$this->m_akses->list_aksespermenu($nike,$kmenu)->row_array();
		$cek1=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_cuti_karyawan->cek_dokumen($nodok)->row_array();

	
			if (trim($cek2['status'])=='A') {
					/*aproval 1
					//echo $cek2['status'];
					$this->m_cuti_karyawan->tr_appa1($nodok,$inputby,$tgl_input);	
					redirect("trans/cuti_karyawan/index/app_succes/$nodok");
					}
					//aproval 2
					else if (trim($cek2['status'])=='A1') {
					$this->m_cuti_karyawan->tr_appa2($nodok,$inputby,$tgl_input);	
					redirect("trans/cuti_karyawan/index/app_succes/$nodok");
					} 
					//aproval 3
					else if (trim($cek2['status'])=='A2') {*/
					$this->m_cuti_karyawan->tr_appa3($nodok,$inputby,$tgl_input);	
					redirect("trans/cuti_karyawan/index/app_succes/$nodok");
					} 
					
					
					else {
				
					redirect("trans/cuti_karyawan/index/kode_failed");
			}
				
	}
	
	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		
			if ($cek==0) {
				redirect("trans/cuti_karyawan/index/kode_failed");
			} else {
				$this->m_cuti_karyawan->tr_cancel($nodok,$inputby,$tgl_input);	
				redirect("trans/cuti_karyawan/index/cancel_succes/$nodok");
			}
	
		
	
	}
	//menampilkan log cuti bersama
	function cutibersama(){
		
		$data['title']='CUTI BERSAMA';	
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Final </div>";
        else if($this->uri->segment(4)=="rep_succes"){
			$nik=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Cuti NIK : <b>$nik</b> Sukses Disimpan </div>";
		}	
		else if($this->uri->segment(4)=="del_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Dihapus </div>";
		}	
		else if($this->uri->segment(4)=="app_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Di Approval</div>";
		}
		else if($this->uri->segment(4)=="cancel_succes"){	
            $nodok=$this->uri->segment(5);
			$data['message']="<div class='alert alert-danger'>Dokumen Dengan Nomor <b>$nodok</b> Telah Dibatalkan</div>";
		}
		else if($this->uri->segment(4)=="edit_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Data dengan Nomor: <b>$nodok</b> Berhasil Diubah</div>";
		}
        else if($this->uri->segment(4)=="nohakcuti")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Memilik Hak Cuti</div>";
		else
            $data['message']='';
		
		$data['listhiscuti']=$this->m_cuti_karyawan->q_hiscuti()->result();
		$data['listkary']=$this->m_cuti_karyawan->list_karyawan()->result();	
		$data['listblc']=$this->m_cuti_karyawan->list_blc()->result();	
		$this->template->display('trans/cuti_karyawan/v_cutibersama',$data);
	}
	//input cuti bersama
	function addcutibersama(){
		$data['title']='INPUT CUTI BERSAMA';
		$this->template->display('trans/cuti_karyawan/v_input_cbersama',$data);
	}
	
	function list_tmp_cb(){
		$data['title']='LIST KARYAWAN POTONG CUTI';
		$nodok=$this->uri->segment(4);
		//$tahune=$this->input->post('pilihtahun');
		$depte=$this->input->post('lsdept');
		$jabatane=$this->input->post('jabatan');
			
		if (empty($jabatan) and empty($depte)){
			$dept='is not NULL';
			$jabatan='is not NULL';
		} else if (!empty($jabatan) and empty($depte)){
			$dept='is not NULL';
			$jabatan="='$jabatane'";
		}
		 else {
			$dept="='$depte'";
			$jabatan='is not NULL';
		}

		$data['listdepartmen']=$this->m_cuti_karyawan->q_departmen()->result();
		$data['listjabatan']=$this->m_cuti_karyawan->q_jabatan()->result();
		$data['list_tmp_cb']=$this->m_cuti_karyawan->list_tmp_cb($nodok,$dept,$jabatan)->result();
		$data['list_tmp_cb_c']=$this->m_cuti_karyawan->list_tmp_cb_c($nodok,$dept,$jabatan)->result();
		$data['nodok']=$nodok;
		$this->template->display('trans/cuti_karyawan/v_list_cb_tmp',$data);
	}
	
	function update_tmp_cb(){
		$nik=$this->uri->segment(4);
		$nodok=$this->uri->segment(5);
		$cek=$this->m_cuti_karyawan->cek_tmp_cb($nik,$nodok)->row_array();
		$statuscancel='C';
		$statusbalik='F';
		
		//echo trim($cek['status']);
		
		if (trim($cek['status'])=='F') {
			$info=array('status'=>strtoupper($statuscancel));
					$this->db->where('no_dokumen',$nodok);
					$this->db->where('nik',$nik);
					$this->db->update('sc_tmp.cuti_blc',$info);
					redirect("trans/cuti_karyawan/list_tmp_cb/$nodok");
			} 
			else if (trim($cek['status'])=='C') {
			$info=array('status'=>strtoupper($statusbalik));
					$this->db->where('no_dokumen',$nodok);
					$this->db->where('nik',$nik);
					$this->db->update('sc_tmp.cuti_blc',$info);
					redirect("trans/cuti_karyawan/list_tmp_cb/$nodok");
			}
			else {	
					redirect("trans/cuti_karyawan/cutibersama");
			}
		
	}
	
	//view otoritas
	function cutibersamaoto($nodok){
		$data['title']='SAVE FINAL CUTI BERSAMA';
		
		$data['dtl']=$this->m_cuti_karyawan->cek_cbersama($nodok)->row_array();
		$this->template->display('trans/cuti_karyawan/v_detail_cbersama',$data);
	}
	
	
	
	//otoritas cuti bersama
	function otoritascutibersama(){
		$nodok=$this->input->post('nodok');
		$tpcuti='P';
		$tglmulai=$this->input->post('tgl_awal');
		$tglselesai=$this->input->post('tgl_selesai');
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		$keterangan=$this->input->post('keterangan');
		$tglinput=$this->input->post('tgl');
		$tgldok=$this->input->post('tgl_dok');
		$inputby=$this->input->post('inputby');
		$info=array(
			///'nodok'=>strtoupper($nodok),
			'status'=>strtoupper($tpcuti),
			'tgl_awal'=>strtoupper($tglmulai),
			'tgl_akhir'=>strtoupper($tglselesai),
			'jumlahcuti'=>strtoupper($jumlah_cuti),
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tglinput,
			'tgl_dok'=>$tgldok,
			'input_by'=>strtoupper($inputby),
			
		);
		
		$cek=$this->m_cuti_karyawan->cek_cbersama($nodok)->row_array();

			if (trim($cek['status'])=='I') {

					$this->db->where('nodok',$nodok);
					$this->db->update('sc_trx.cutibersama',$info);
					redirect("trans/cuti_karyawan/cutibersama/index/app_succes/$nodok");
			} 	
			else {	
					redirect("trans/cuti_karyawan/cutibersama/kode_failed");
			}
			
	}
	
	function hps_cutibersama($nodok){
		$cek=$this->m_cuti_karyawan->cek_cbersama($nodok)->num_rows();
		//$nodok=$this->uri->segment(4);
			
			if ($cek==0) {
				redirect("trans/cuti_karyawan/cutibersama/index/kode_failed");
			} else {
				
				$this->db->query("delete from sc_trx.cutibersama where nodok='$nodok'");
				redirect("trans/cuti_karyawan/cutibersama/del_succes/$nodok");
			}
		
	}
	
	
	function savecutibersama(){
		$nodok='';
		$tpcuti=$this->input->post('tpcuti');
		//$statusptg=$this->input->post('statptg');
		$tglmulai=$this->input->post('tgl_awal');
		$tglselesai=$this->input->post('tgl_selesai');
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		$keterangan=$this->input->post('keterangan');
		$tglinput=$this->input->post('tgl');
		$tgldok=$this->input->post('tgl_dok');
		$inputby=$this->input->post('inputby');
		
		
		$info=array(
			'nodok'=>strtoupper($nodok),
			'status'=>strtoupper($tpcuti),
			'tgl_awal'=>strtoupper($tglmulai),
			'tgl_akhir'=>strtoupper($tglselesai),
			'jumlahcuti'=>strtoupper($jumlah_cuti),
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tglinput,
			'tgl_dok'=>$tgldok,
			'input_by'=>strtoupper($inputby),
			//'status_ptg'=>strtoupper($statusptg)
		);
		
		$this->db->insert('sc_tmp.cutibersama',$info);
		redirect("trans/cuti_karyawan/cutibersama/");
	}
	
	
	
	
	// menampilkan cuti balance karyawan awal
	function cutibalance(){
		$data['title']='Sisa Cuti Per Karyawan';
		$tahune=$this->input->post('pilihtahun');
		$depte=$this->input->post('lsdept');
			
		if (empty($tahune) and empty($depte)){
			$tahun=date('Y');
			$dept='is not NULL';
		} else if ( empty ($depte)){
			$tahun=$tahune;
			$dept='is not NULL';
		} else {
			$tahun=$tahune;
			$dept="='$depte'";
		}
		
		
		$data['tahune']=$tahun;
		$data['kddept']=$dept;
		//$data['nmdept']=$nmdept;
		$data['listdepartmen']=$this->m_cuti_karyawan->q_departmen()->result();
		$data['listblc']=$this->m_cuti_karyawan->q_cutiblc($tahun,$dept)->result();
		$this->template->display('trans/cuti_karyawan/v_listblc',$data);
	}
	// menampilkan cuti balance karyawan detail
	function cutibalancedtl(){
		
		$nik=$this->input->post('kdkaryawan');
		$tahun=$this->input->post('tahunlek');
		$nikht=$this->input->post('htgkry');
		
		
		
		
		$data['title']='List Balance';	
		$data['listkaryawan']=$this->m_cuti_karyawan->list_karyawan_index_2()->result();
		$data['listblc']=$this->m_cuti_karyawan->q_cutiblcdtl($nik,$tahun)->result();
		$data['tahun']=$tahun;
		$this->m_cuti_karyawan->q_proc_htg($nikht);
		$this->template->display('trans/cuti_karyawan/v_listblcdtl',$data);
		
	}
	
	
	function cutilalu(){
		$data['title']='Sisa Cuti Lalu KARYAWAN per Periode Masuk Kerja';
		$tahune=$this->input->post('pilihtahun');
		$depte=$this->input->post('lsdept');
			
		if (empty($tahune) and empty($depte)){
			$tahun=date('Y');
			$dept='is not NULL';
		} else if ( empty ($depte)){
			$tahun=$tahune;
			$dept='is not NULL';
		} else {
			$tahun=$tahune;
			$dept="='$depte'";
		}
		
		
		$data['tahune']=$tahun;
		$data['kddept']=$dept;
		//$data['nmdept']=$nmdept;
		$data['listdepartmen']=$this->m_cuti_karyawan->q_departmen()->result();
		$data['listlalu']=$this->m_cuti_karyawan->q_cutilalu($tahun,$dept)->result();
		$this->template->display('trans/cuti_karyawan/v_listlalu',$data);
	}
	// menampilkan cuti balance karyawan detail
	function cutilaludtl(){
		
		$nik=$this->input->post('kdkaryawan');
		$tahun=$this->input->post('tahunlek');
		$nikht=$this->input->post('htgkry');
		
		
		$data['title']='List Balance';	
		$data['listkaryawan']=$this->m_cuti_karyawan->list_karyawan_index_2()->result();
		$data['listblc']=$this->m_cuti_karyawan->q_cutilaludtl($nik,$tahun)->result();
		$data['tahun']=$tahun;
		$this->m_cuti_karyawan->q_proc_htg($nikht);
		$this->template->display('trans/cuti_karyawan/v_listlaludtl',$data);
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// memunculkan tombol cuti pada karyawan baru yang telah 1 tahun
	function pr_addcutikrybr(){
		$this->m_cuti_karyawan->q_addprctbr();
		redirect ("trans/cuti_karyawan");
	}
	// memunculkan tombol cuti pada saat 1 januari per tahun
	function pr_addcutirata(){
		$this->m_cuti_karyawan->q_addprctrata();
		redirect ("trans/cuti_karyawan");
	}
		// memunculkan tombol hangus cuti pada saat 1 januari per tahun
	function pr_hanguscuti(){
		$this->m_cuti_karyawan->q_prhgscuti();
		redirect ("trans/cuti_karyawan");
	}
	  //hitung all cuti
	function pr_hitungallcuti(){
		$this->m_cuti_karyawan->q_hitungallcuti();
		redirect ("trans/cuti_karyawan/cutibalance");
	}
	
		//reporting excel
	public function excel_blc(){
		$tahun=$this->uri->segment(4);
		$dept=$this->uri->segment(5);
	
		$datane=$this->m_cuti_karyawan->excel_cutiblc($tahun,$dept);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK','Nama Lengkap','Tanggal Cuti','Department','Sub Bagian','IN CUTI','OUT CUTI','SALDO AKHIR','STATUS'	
													));
	    $this->excel_generator->set_column(array('nik','nmlengkap','tanggal','bag_dept','in_cuti','out_cuti','sisacuti','doctype','status'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20,20,20,20
												));
        $this->excel_generator->exportTo2007("SALDO AKHIR CUTI");
	}
	
	public function excel_blc_dtl(){
		$tahun=$this->uri->segment(4);
	
		$datane=$this->m_cuti_karyawan->excel_cutiblcdtl($tahun);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK','Nama Lengkap','Tanggal Cuti','Dokumen Cuti','IN CUTI','OUT CUTI','SALDO AKHIR','STATUS'	
													));
	    $this->excel_generator->set_column(array('nik','nmlengkap','tanggal','no_dokumen','in_cuti','out_cuti','sisacuti','status'
													));
        $this->excel_generator->set_width(array(20,20,20,20,20,20,20,20
												));
        $this->excel_generator->exportTo2007("SALDO DETAIL CUTI");
	}
		
	
	public function ajax_list()
	{
		$list = $this->m_cuti_karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->nik;		
			$row[] = $person->nmlengkap;		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-success" href="'.site_url('trans/karyawan/detail').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
					<a class="btn btn-sm btn-success" href="'.site_url('trans/mutprom/index').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Mutasi</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->nik)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_karyawan->count_all(),
						"recordsFiltered" => $this->m_karyawan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	

}	