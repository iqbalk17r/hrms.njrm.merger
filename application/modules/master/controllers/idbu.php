<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)

class idbu extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_idbu');
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Fiky_wilayah','Fiky_grade'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
 function index(){
        //echo "test";
		$nama=$this->session->userdata('username');
		$data['title']="List Master IDBU";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="kode_succes")
            $data['message']="<div class='alert alert-success'>Kode Berhasil Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		
		$data['list_idbu']=$this->m_idbu->q_idbu()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/idbu/v_idbu',$data);
    }
	
	function add_idbu(){
		$kddept=trim(strtoupper(str_replace(" ","",$this->input->post('kddept'))));
		$nmdept=$this->input->post('nmdept');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$info=array(
			'kddept'=>$kddept,
			'nmdept'=>strtoupper($nmdept),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		
		$cek=$this->m_idbu->q_cekidbu($kddept)->num_rows();
		if ($cek>0){
			redirect('master/idbu/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.departmen',$info);
			redirect('master/idbu/index/kode_succes');
		}
		//$this->db->where('custcode',$kode);
		
		
		//echo $inputby;
	}
	
	
	function edit_idbu($kddept){
		$kddept=$this->input->post('kddept');
		$nmdept=$this->input->post('nmdept');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		$info=array(
			//'kodeopt'=>strtoupper($kodeopt),
			//'kddept'=>strtoupper($kddept),
			'nmdept'=>strtoupper($nmdept),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
				
			);
		$this->db->where('kddept',$kddept);	
		$this->db->update("sc_mst.departmen",$info);
		//echo "sukses";
		redirect('master/idbu/index/rep_succes');
	}
	
}
    
