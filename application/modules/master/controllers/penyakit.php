<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Penyakit extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_penyakit','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Penyakit";
		
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
		$data['list_penyakit']=$this->m_penyakit->q_penyakit()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/penyakit/v_penyakit',$data);
    }
	function add_penyakit(){
		$kdpenyakit=trim(strtoupper(str_replace(" ","",$this->input->post('kdpenyakit'))));
		$nmpenyakit=$this->input->post('nmpenyakit');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdpenyakit'=>$kdpenyakit,
			'nmpenyakit'=>strtoupper($nmpenyakit),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_penyakit->q_cekpenyakit($kdpenyakit)->num_rows();
		if ($cek>0){
			redirect('master/penyakit/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.penyakit',$info);
			redirect('master/penyakit/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_penyakit(){
		$kdpenyakit=trim($this->input->post('kdpenyakit'));
		$nmpenyakit=$this->input->post('nmpenyakit');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdpenyakit'=>$kdpenyakit,
			'nmpenyakit'=>strtoupper($nmpenyakit),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdpenyakit',$kdpenyakit);
			$this->db->update('sc_mst.penyakit',$info);
			redirect('master/penyakit/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_penyakit($kdpenyakit){
		$this->db->where('kdpenyakit',$kdpenyakit);
		$this->db->delete('sc_mst.penyakit');
		redirect('master/penyakit/index/del_succes');
	}
	
}	