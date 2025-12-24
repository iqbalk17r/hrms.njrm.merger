<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Bank extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_bank','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master bank";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_bank']=$this->m_bank->q_bank()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/bank/v_bank',$data);
    }
	function add_bank(){
		$kdbank=trim(strtoupper(str_replace(" ","",$this->input->post('kdbank'))));
		$nmbank=$this->input->post('nmbank');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdbank'=>$kdbank,
			'nmbank'=>strtoupper($nmbank),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_bank->q_cekbank($kdbank)->num_rows();
		if ($cek>0){
			redirect('master/bank/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bank',$info);
			redirect('master/bank/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_bank(){
		$kdbank=trim($this->input->post('kdbank'));
		$nmbank=$this->input->post('nmbank');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdbank'=>$kdbank,
			'nmbank'=>strtoupper($nmbank),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdbank',$kdbank);
			$this->db->update('sc_mst.bank',$info);
			redirect('master/bank/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_bank($kdbank){
		$this->db->where('kdbank',$kdbank);
		$this->db->delete('sc_mst.bank');
		redirect('master/bank/index/del_succes');
	}
	
}	