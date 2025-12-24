<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Group_penggajian extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_group_penggajian','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
 function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Group Penggajian";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_group_penggajian']=$this->m_group_penggajian->q_group_penggajian()->result();
		
		//$data['message']="List SMS Masuk";
        $this->template->display('master/group_penggajian/v_group_penggajian',$data);
    }
	
	function add_group_pg(){
		$kdgroup_pg=trim(strtoupper(str_replace(" ","",$this->input->post('kdgroup_pg'))));
		$nmgroup_pg=$this->input->post('nmgroup_pg');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdgroup_pg'=>$kdgroup_pg,
			'nmgroup_pg'=>strtoupper($nmgroup_pg),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_group_penggajian->q_cekpg($kdgroup_pg)->num_rows();
		if ($cek>0){
			redirect('master/group_penggajian/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.group_penggajian',$info);
			redirect('master/group_penggajian/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_group_pg($kdgroup_pg){
		
		$kdgroup_pg=trim(strtoupper(str_replace(" ","",$this->input->post('kdgroup_pg'))));
		
		$nmgroup_pg=strtoupper($this->input->post('nmgroup_pg'));
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdgroup_pg'=>$kdgroup_pg,	
			'nmgroup_pg'=>$nmgroup_pg,			
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
			//echo $ket;
			$this->db->where('kdgroup_pg',$kdgroup_pg);
			$this->db->update('sc_mst.group_penggajian',$info);
			redirect('master/group_penggajian/index');
	}
	
	function hps_group_pg($kdgroup_pg){
		$this->db->where('kdgroup_pg',$kdgroup_pg);
		$this->db->delete('sc_mst.group_penggajian');
		redirect('master/group_penggajian/index');
	}
	
}