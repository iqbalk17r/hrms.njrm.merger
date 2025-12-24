<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Lembur extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_lembur','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Lembur";
		
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
		$data['list_lembur']=$this->m_lembur->q_lembur()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/lembur/v_lembur',$data);
    }
	function add_lembur(){
		//$kdlembur=trim(strtoupper(str_replace(" ","",$this->input->post('kdlembur'))));
		$tplembur=$this->input->post('tplembur');
		$rentang_bawah=str_replace("_","",$this->input->post('rentang_bawah'));
		$rentang_atas=str_replace("_","",$this->input->post('rentang_atas'));
		$jml_pengkali=str_replace("_","",$this->input->post('jml_pengkali'));
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'tplembur'=>strtoupper($tplembur),
			'rentang_bawah'=>$rentang_bawah,
			'rentang_atas'=>$rentang_atas,
			'jml_pengkali'=>$jml_pengkali,
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_lembur->q_ceklembur($kdlembur)->num_rows();
		if ($cek>0){
			redirect('master/lembur/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.lembur',$info);
			redirect('master/lembur/index');
		}*/
		$this->db->insert('sc_mst.lembur',$info);
		redirect('master/lembur/index/rep_succes');
		
	}
	
	function edit_lembur(){
		$kdlembur=trim(strtoupper(str_replace(" ","",$this->input->post('kdlembur'))));
		$tplembur=$this->input->post('tplembur');
		$rentang_bawah=str_replace("_","",$this->input->post('rentang_bawah'));
		$rentang_atas=str_replace("_","",$this->input->post('rentang_atas'));
		$jml_pengkali=str_replace("_","",$this->input->post('jml_pengkali'));
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'tplembur'=>strtoupper($tplembur),
			'rentang_bawah'=>$rentang_bawah,
			'rentang_atas'=>$rentang_atas,
			'jml_pengkali'=>$jml_pengkali,
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdlembur',$kdlembur);
			$this->db->update('sc_mst.lembur',$info);
			redirect('master/lembur/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_lembur($kdlembur){
		$this->db->where('kdlembur',$kdlembur);
		$this->db->delete('sc_mst.lembur');
		redirect('master/lembur/index/del_succes');
	}
	
	
	
}	