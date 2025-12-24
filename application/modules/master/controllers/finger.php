<?php
/*
	@author : Fiky Ashariza
	01-01-2017
*/
//error_reporting(0);

class Finger extends MX_Controller{
    
    function __construct(){
        parent::__construct();
	
        $this->load->model(array('m_finger'));
        $this->load->library(array('form_validation','template','pdf'));
        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
		if($this->uri->segment(4)=="success"){
			$data['message']="<div class='alert alert-success'>Data Sukses Di Simpan</div>";
		} else if($this->uri->segment(4)=="exist"){
			$data['message']="<div class='alert alert-danger'>Peringatan Data Sudah Ada !!!</div>";
		} else if($this->uri->segment(4)=="del_exist"){
			$data['message']="<div class='alert alert-danger'>Ada data yang terkait</div>";
		} else if($this->uri->segment(4)=="del_success"){
			$data['message']="<div class='alert alert-danger'>Data Sukses Di Hapus.. !!!</div>";
		} else {
			$data['message']='';
		}
        $data['title']="Daftar Finger Print Per Wilayah";
		$nama=$this->session->userdata('nik');
		$data['list_finger']=$this->m_finger->q_finger()->result();
		$data['list_wil']=$this->m_finger->q_listwilayah()->result();
		$data['list_editwil']=$this->m_finger->q_listwilayahdtl($kdcabang)->row_array();
		$data['list_userfinger']=$this->m_finger->list_userfinger()->result();
        $this->template->display('master/finger/view_finger',$data);
    }
	
	function add_finger(){
        $branch='SBYNSA';
		$kdcabang=$this->input->post('kdcabang');
		$ipaddress=$this->input->post('ipaddress');
		$dbname=$this->input->post('dbname');
		$desc=$this->m_finger->q_listwilayahdtl($kdcabang)->row_array();
		$desc_cabang=$desc['desc_cabang'];
		$tipe=$this->input->post('tipe');
		
		if($tipe=='INPUT') {	if(!empty($kdcabang) and !empty($ipaddress)){
					$info = array(
							'branch' => strtoupper($branch),
							'fingerid' => strtoupper($kdcabang),
							'wilayah' => $desc_cabang,
							'ipaddress' => $ipaddress,
							'dbname' => strtoupper($dbname),
							'kodecabang' => strtoupper($kdcabang),
							'inputby' => $this->session->userdata('nama'),
							'inputdate' => date('Y-m-d'),
					);
					
				$this->db->insert('sc_mst.fingerprint',$info);
				redirect('master/finger/index/success');
				} else {
				redirect('master/finger/index');
				}
		} else if($tipe=='EDIT'){	if(!empty($kdcabang) and !empty($ipaddress)){
					$info = array(
							'branch' => strtoupper($branch),
							'wilayah' => $desc_cabang,
							'ipaddress' => $ipaddress,
							'dbname' => strtoupper($dbname),
							'kodecabang' => strtoupper($kdcabang),
							'editby' => $this->session->userdata('nama'),
							'editdate' => date('Y-m-d'),
					);
				$this->db->where('fingerid',$kdcabang);	
				$this->db->update('sc_mst.fingerprint',$info);
				redirect('master/finger/index/success');
				} else {
				redirect('master/finger/index');
				}
			
		} else{ redirect('master/finger/index'); }		
    }

	function hps_finger(){
		$fingerid=$this->uri->segment(4);
		if(!empty($fingerid)){
			$this->db->where('fingerid',$fingerid);
			$this->db->delete('sc_mst.fingerprint');
			redirect('master/finger/index/del_success');
		}else{
			redirect('master/finger/index');
		}
		
	}
	
	function edit_finger(){
		$fingerid=$this->uri->segment(4);
		$data['dtl']=$this->m_finger->q_edit_finger($fingerid)->row_array();
		$this->template->display('master/finger/edit_finger',$data);
	}
	
}