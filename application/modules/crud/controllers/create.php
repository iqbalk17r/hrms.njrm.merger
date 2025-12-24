<?php
/*
	@author : Randy
	02-12-2015
*/
error_reporting(0);

class Create extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geografis'));
        $this->load->library(array('form_validation','template','upload','pdf'));        
		/*
        if(!$this->session->userdata('username')){
            redirect('dashboard');
        }
		*/
    }
    
    function index(){
        $data['title']="Master Departement";					
        $this->template->display('master/department/v_departement',$data);
    }
}