<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Rekam_medis extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_rekam_medis');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Rekam Medis";
		
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
		$data['list_rekam_medis']=$this->m_rekam_medis->q_rekam_medis()->result();
		$data['list_trxtype']=$this->m_rekam_medis->q_trxtype()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/rekam_medis/v_rekam_medis',$data);
    }
	function add_rekam_medis(){
		
		$kdrekam_medis=trim(strtoupper(str_replace(" ","",$this->input->post('kdrekam_medis'))));
		$nmrekam_medis=$this->input->post('nmrekam_medis');
		$kdtrx=$this->input->post('kdtrx');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdrekam_medis'=>$kdrekam_medis,
			'nmrekam_medis'=>strtoupper($nmrekam_medis),
			'kdtrx'=>strtoupper($kdtrx),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_rekam_medis->q_cekrekam_medis($kdrekam_medis)->num_rows();
		if ($cek>0){
			redirect('master/rekam_medis/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.rekam_medis',$info);
			redirect('master/rekam_medis/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_rekam_medis(){
		$kdrekam_medis=trim($this->input->post('kdrekam_medis'));
		$nmrekam_medis=$this->input->post('nmrekam_medis');
		$kdtrx=$this->input->post('kdtrx');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdrekam_medis'=>$kdrekam_medis,
			'nmrekam_medis'=>strtoupper($nmrekam_medis),
			'kdtrx'=>strtoupper($kdtrx),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdrekam_medis',$kdrekam_medis);
			$this->db->update('sc_mst.rekam_medis',$info);
			redirect('master/rekam_medis/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_rekam_medis($kdrekam_medis){
		$this->db->where('kdrekam_medis',$kdrekam_medis);
		$this->db->delete('sc_mst.rekam_medis');
		redirect('master/rekam_medis/index/del_succes');
	}
	
}	