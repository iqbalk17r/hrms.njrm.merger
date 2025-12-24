<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Keluarga extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_keluarga','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Silsilah keluarga";
		
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
		$data['list_keluarga']=$this->m_keluarga->q_keluarga()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/keluarga/v_keluarga',$data);
    }
	function add_keluarga(){
		$kdkeluarga=trim(strtoupper(str_replace(" ","",$this->input->post('kdkeluarga'))));
		$nmkeluarga=$this->input->post('nmkeluarga');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdkeluarga'=>$kdkeluarga,
			'nmkeluarga'=>strtoupper($nmkeluarga),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_keluarga->q_cekkeluarga($kdkeluarga)->num_rows();
		if ($cek>0){
			redirect('master/keluarga/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.keluarga',$info);
			redirect('master/keluarga/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_keluarga(){
		$kdkeluarga=trim($this->input->post('kdkeluarga'));
		$nmkeluarga=$this->input->post('nmkeluarga');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdkeluarga'=>$kdkeluarga,
			'nmkeluarga'=>strtoupper($nmkeluarga),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdkeluarga',$kdkeluarga);
			$this->db->update('sc_mst.keluarga',$info);
			redirect('master/keluarga/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_keluarga($kdkeluarga){
		$this->db->where('kdkeluarga',$kdkeluarga);
		$this->db->delete('sc_mst.keluarga');
		redirect('master/keluarga/index/del_succes');
	}
	
}	