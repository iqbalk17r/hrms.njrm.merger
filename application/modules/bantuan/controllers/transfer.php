<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Transfer extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('m_transfer'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        
		$data['title']="Selamat Datang Di Modul Bantuan Tarik Data ABSENSI Wilayah";
		
		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="send_success")
            $data['message']="<div class='alert alert-success'>Data Sudah Sukses Di Transfer </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="failed")
            $data['message']="<div class='alert alert-danger'>Data Gagal di Transfer</div>";
		else if($this->uri->segment(4)=="failed_ex")
            $data['message']="<div class='alert alert-danger'>Data Finger Belum Ditarik Wilayah/Sambungan Gagal </div>";
        else
            $data['message']='';
		$data['ipwil']=$this->m_transfer->q_finger()->result();
        $this->template->display('bantuan/transfer/v_transfer',$data);
    }
	
	function ajax_ipfinger($kdcabang){
		$data = $this->m_transfer->q_finger_list($kdcabang)->row_array();
		echo json_encode($data);
	}
	
	function proses_tarik(){
		$tgl=explode(' - ',$this->input->post('tgl'));				
		$awal=$tgl[0];
		$akhir=$tgl[1];
		$kdcabang=$this->input->post('kdcabang');
		$hostaddr='192.168.15.8';
		$dbname='DBTRKABSEN';
		$userpg='postgres';
		$passpg='111111';
		
		$cek_client = $this->m_transfer->cek_wilayah($kdcabang,$awal,$akhir,$hostaddr,$dbname,$userpg,$passpg)->num_rows();
		
		if ($cek_client>0) {
			$this->m_transfer->del_checkinout($kdcabang,$awal,$akhir);
			$this->m_transfer->ins_checkinout($kdcabang,$awal,$akhir,$hostaddr,$dbname,$userpg,$passpg);	
		} else {
			redirect("bantuan/transfer/index/failed");
		}
		
		
		
		$cek_lokal = $this->m_transfer->cek_lokal($kdcabang,$awal,$akhir)->num_rows();

		if($cek_client==$cek_lokal){
			redirect("bantuan/transfer/index/send_success");
		}else{
			redirect("bantuan/transfer/index/failed");
		}
		
		
		//$this->m_transfer->q_finger_list($kdcabang)->row_array();
		//echo json_encode($cek_client);
		//echo json_encode($cek_lokal);
		//echo json_encode($tgl);
	}
	
	
	function tester(){
		echo base_url('/gridview/grid_karkon');
	}


	
	
}	