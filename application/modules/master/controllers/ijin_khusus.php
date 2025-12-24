<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Ijin_khusus extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_ijin_khusus','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Ijin Khusus";
		
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
		$data['list_ijin_khusus']=$this->m_ijin_khusus->q_ijin_khusus()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/ijin_khusus/v_ijin_khusus',$data);
    }
	function add_ijin_khusus(){
		$kdijin_khusus=trim(strtoupper(str_replace(" ","",$this->input->post('kdijin_khusus'))));
		$nmijin_khusus=$this->input->post('nmijin_khusus');
		$jumlah=str_replace("_","",$this->input->post('jumlah'));
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdijin_khusus'=>$kdijin_khusus,
			'nmijin_khusus'=>strtoupper($nmijin_khusus),
			'jumlah'=>$jumlah,
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_ijin_khusus->q_cekijin_khusus($kdijin_khusus)->num_rows();
		if ($cek>0){
			redirect('master/ijin_khusus/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.ijin_khusus',$info);
			redirect('master/ijin_khusus/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_ijin_khusus(){
		$kdijin_khusus=trim($this->input->post('kdijin_khusus'));
		$nmijin_khusus=$this->input->post('nmijin_khusus');
		$jumlah=str_replace("_","",$this->input->post('jumlah'));
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdijin_khusus'=>$kdijin_khusus,
			'nmijin_khusus'=>strtoupper($nmijin_khusus),
			'jumlah'=>$jumlah,
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdijin_khusus',$kdijin_khusus);
			$this->db->update('sc_mst.ijin_khusus',$info);
			redirect('master/ijin_khusus/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_ijin_khusus($kdijin_khusus){
		$this->db->where('kdijin_khusus',$kdijin_khusus);
		$this->db->delete('sc_mst.ijin_khusus');
		redirect('master/ijin_khusus/index/del_succes');
	}
	
	
	
}	