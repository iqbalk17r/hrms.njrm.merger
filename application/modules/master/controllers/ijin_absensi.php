<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Ijin_absensi extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_ijin_absensi','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Ijin Absensi";
		
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
		$data['list_ijin_absensi']=$this->m_ijin_absensi->q_ijin_absensi()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/ijin_absensi/v_ijin_absensi',$data);
    }
	function add_ijin_absensi(){
		$kdijin_absensi=trim(strtoupper(str_replace(" ","",$this->input->post('kdijin_absensi'))));
		$nmijin_absensi=$this->input->post('nmijin_absensi');
		$ptg_cuti1=$this->input->post('ptg_cuti');
		if ($ptg_cuti1=='YES'){
			$ptg_cuti='T';
		} else {
			$ptg_cuti='F';
		}  
		/*$ptg_gaji1=$this->input->post('ptg_gaji');
		if ($ptg_gaji1=='YES'){
			$ptg_gaji='T';
		} else {
			$ptg_gaji='F';
		}*/  
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdijin_absensi'=>$kdijin_absensi,
			'nmijin_absensi'=>strtoupper($nmijin_absensi),
			'ptg_cuti'=>$ptg_cuti,
			//'ptg_gaji'=>$ptg_gaji,
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_ijin_absensi->q_cekijin_absensi($kdijin_absensi)->num_rows();
		if ($cek>0){
			redirect('master/ijin_absensi/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.ijin_absensi',$info);
			redirect('master/ijin_absensi/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_ijin_absensi(){
		$kdijin_absensi=trim($this->input->post('kdijin_absensi'));
		$nmijin_absensi=$this->input->post('nmijin_absensi');
		$ptg_cuti1=$this->input->post('ptg_cuti');
		if ($ptg_cuti1=='YES'){
			$ptg_cuti='T';
		} else {
			$ptg_cuti='F';
		}  
		/*$ptg_gaji1=$this->input->post('ptg_gaji');
		if ($ptg_gaji1=='YES'){
			$ptg_gaji='T';
		} else {
			$ptg_gaji='F';
		}*/  
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdijin_absensi'=>$kdijin_absensi,
			'nmijin_absensi'=>strtoupper($nmijin_absensi),
			'ptg_cuti'=>$ptg_cuti,
			//'ptg_gaji'=>$ptg_gaji,
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdijin_absensi',$kdijin_absensi);
			$this->db->update('sc_mst.ijin_absensi',$info);
			redirect('master/ijin_absensi/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_ijin_absensi($kdijin_absensi){
		$this->db->where('kdijin_absensi',$kdijin_absensi);
		$this->db->delete('sc_mst.ijin_absensi');
		redirect('master/ijin_absensi/index/del_succes');
	}
	
	
	
}	