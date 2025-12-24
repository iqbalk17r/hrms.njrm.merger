<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Gridview extends CI_Controller{
    
    function __construct(){
        parent::__construct();
		
		$this->load->model('payroll/m_final');
		


    }
	function index(){
    echo 'AKSES DENIED';    
    }

	function grid_karkon(){
		$this->load->view('leavesession/v_grid_karkon');
	}

	function grid_karpen(){
		$this->load->view('leavesession/v_grid_karpen');
	}
	
	function view_1721pdf($nik,$kddept,$kdgroup_pg){
	//echo $nik,$kddept,$kdgroup_pg;		
	$data['dtl_pph']=$this->m_final->q_1721nik($nik,$kddept,$kdgroup_pg)->row_array();
	$data['dtl_kar']=$this->m_final->q_dtl_kary($nik,$kddept,$kdgroup_pg)->row_array();
	$this->load->view('leavesession/testpdf.php',$data);
	
	}
}	