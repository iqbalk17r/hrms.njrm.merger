<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Patchmob extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_patch'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','fiky_hexstring','image_lib')); 
	
/*    if(!$this->session->userdata('nama')){
            redirect('dashboard');
        }*/
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU,SILAHKAN PILIH MENU YANG ADA";
			$this->template->display('intern/cr_sj/v_index',$data);
	}
	
	
	function downloadPatch(){
		$startDate=$this->input->post('startDate');
		$endDate=$this->input->post('endDate');
		$userId=$this->input->post('userId');
		$patchid=$this->input->post('patchid');
		$useridspecification=$this->input->post('$useridspecification');
		$patchdate=$this->input->post('patchdate');

		if ($patchdate =='' or isset($patchdate)) {
		    $patd = " ";
        } else {
            $patd = "and patchdate > $patchdate ";
        }
		$param=" 
		$patd 
		and (
		(coalesce(userspecification,'')='YES' and coalesce(useridspecification,'') in ('$userId'))
		OR 
		(coalesce(userspecification,'')='NO' and coalesce(useridspecification,'') in (''))
		) and id!='$patchid' and patchstatus='F'
		";

        $order=" order by patchdate asc";

        $patchquery = $this->m_patch->q_patch_query($param,$order)->result();
        $row_patch = $this->m_patch->q_patch_query($param,$order)->num_rows();
		header("Content-Type: text/json");
		echo json_encode(
			array(
			'row' => $row_patch,
			'success' => true,
			'message' => "Data Berhasil Di Perbaharui",
			'body' => array(
				'patch' => $patchquery,
                )
			)
		, JSON_PRETTY_PRINT);
	}


}