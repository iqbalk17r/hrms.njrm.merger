<?php
/*
	@author : hanif_anak_metal
	7-9-2014
*/
error_reporting(0);

class Hrd extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_hrd','m_uang','m_geografis'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('username')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Daftar Pegawai";		
		$data['list_pegawai']=$this->m_hrd->q_pegawai()->result();
		$data['qjabatan']=$this->m_hrd->q_jabatan()->result();
		$data['qdepartement']=$this->m_hrd->q_departement()->result();
        $this->template->display('hrd/hrd/view_pegawai',$data);
    }
}