<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Nikah extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_nikah','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master nikah";
		
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
		$data['list_nikah']=$this->m_nikah->q_nikah()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/nikah/v_nikah',$data);
    }
	function add_nikah(){
		$kdnikah=trim(strtoupper(str_replace(" ","",$this->input->post('kdnikah'))));
		$nmnikah=$this->input->post('nmnikah');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdnikah'=>$kdnikah,
			'nmnikah'=>strtoupper($nmnikah),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_nikah->q_ceknikah($kdnikah)->num_rows();
		if ($cek>0){
			redirect('master/nikah/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.status_nikah',$info);
			redirect('master/nikah/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_nikah(){
		$kdnikah=trim($this->input->post('kdnikah'));
		$nmnikah=$this->input->post('nmnikah');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdnikah'=>$kdnikah,
			'nmnikah'=>strtoupper($nmnikah),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdnikah',$kdnikah);
			$this->db->update('sc_mst.status_nikah',$info);
			redirect('master/nikah/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_nikah($kdnikah){
		$this->db->where('kdnikah',$kdnikah);
		$this->db->delete('sc_mst.status_nikah');
		redirect('master/nikah/index/del_succes');
	}
	
}	