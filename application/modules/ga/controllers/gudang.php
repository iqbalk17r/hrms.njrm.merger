<?php
/*
	@author : Fiky
	02-12-2018
*/
//error_reporting(0);

class Gudang extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_gudang'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index() {
		$data['title']="MASTER GUDANG WILAYAH";
		$data['message']="";
        $data['list_gudang']=$this->m_gudang->q_mgudang()->result();
		//echo "MENU MASTER GUDANG";
		$this->template->display('ga/gudang/v_gudang', $data);
	}
	

	
}