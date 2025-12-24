<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Agama extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_agama','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Agama";
		
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
		$data['list_agama']=$this->m_agama->q_agama()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/agama/v_agama',$data);
    }
	function add_agama(){
		$kdagama=trim(strtoupper(str_replace(" ","",$this->input->post('kdagama'))));
		$nmagama=$this->input->post('nmagama');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdagama'=>$kdagama,
			'nmagama'=>strtoupper($nmagama),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_agama->q_cekagama($kdagama)->num_rows();
		if ($cek>0){
			redirect('master/agama/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.agama',$info);
			redirect('master/agama/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_agama(){
		$kdagama=trim($this->input->post('kdagama'));
		$nmagama=$this->input->post('nmagama');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdagama'=>$kdagama,
			'nmagama'=>strtoupper($nmagama),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdagama',$kdagama);
			$this->db->update('sc_mst.agama',$info);
			redirect('master/agama/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_agama($kdagama){
		$this->db->where('kdagama',$kdagama);
		$this->db->delete('sc_mst.agama');
		redirect('master/agama/index/del_succes');
	}
	
}	