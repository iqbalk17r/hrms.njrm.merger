<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Libur extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_libur','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Hari libur";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Tanggal Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Tanggal Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_libur']=$this->m_libur->q_libur()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/libur/v_libur',$data);
    }
	function add_libur(){
		$tgl_libur=$this->input->post('tgl_libur');
		$ket_libur=$this->input->post('ket_libur');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'tgl_libur'=>$tgl_libur,
			'ket_libur'=>strtoupper($ket_libur),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_libur;
		//$this->db->where('custcode',$kode);
		$cek=$this->m_libur->q_ceklibur($tgl_libur)->num_rows();
		if ($cek>0){
			redirect('master/libur/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.libur',$info);
			redirect('master/libur/index/rep_succes/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_libur(){
		$tgl_libur=$this->input->post('tgl_libur');
		$ket_libur=$this->input->post('ket_libur');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'tgl_libur'=>$tgl_libur,
			'ket_libur'=>strtoupper($ket_libur),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('tgl_libur',$tgl_libur);
			$this->db->update('sc_mst.libur',$info);
			redirect('master/libur/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_libur($tgl_libur){
		$this->db->where('tgl_libur',$tgl_libur);
		$this->db->delete('sc_mst.libur');
		redirect('master/libur/index/del_succes');
	}
	
}	