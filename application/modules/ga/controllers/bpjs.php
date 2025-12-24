<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Bpjs extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('m_bpjs'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			echo 'SELAMAT DATANG DI MODULE GA';
	}
	
	function form_bpjs(){

		$data['title']="SMS HRD";		
		$data['title1']="List Inbox SMS HRD";
		$data['title2']="List Sent Item SMS HRD";		
		$data['title3']="List Trash Inbox SMS HRD";
		$data['title4']="List Trash Outbox SMS HRD";
		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
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
		
		//echo $tgl;	
		$data['list_sms']=$this->m_bpjs->q_list_sms($tgl)->result();
		$data['list_outbox']=$this->m_bpjs->q_list_outbox($tgl)->result();
		$data['list_trash_inbox']=$this->m_bpjs->q_list_trash_inbox($tgl)->result();
		$data['list_trash_outbox']=$this->m_bpjs->q_list_trash_outbox($tgl)->result();
        $this->template->display('ga/bpjs/v_bpjs',$data);
	}
	
	
	
		
}