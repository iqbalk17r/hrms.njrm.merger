<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class mesin extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_mesin','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master mesin";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_alert")
            $data['message']="<div class='alert alert-warning'>Data Sudah Digunakan, Hapus Data Child Terlebih Dahulu</div>";	
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_mesin']=$this->m_mesin->q_mesin()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/mesin/v_mesin',$data);
    }
	function add_mesin(){
		$kdmesin=trim(strtoupper(str_replace(" ","",$this->input->post('kdmesin'))));
		$nmmesin=$this->input->post('nmmesin');
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdmesin'=>$kdmesin,
			'nmmesin'=>strtoupper($nmmesin),
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_mesin->q_cekmesin($kdmesin)->num_rows();
		if ($cek>0){
			redirect('master/mesin/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.mesin',$info);
			redirect('master/mesin/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_mesin(){
		$kdmesin=trim($this->input->post('kdmesin'));
		$nmmesin=$this->input->post('nmmesin');
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdmesin'=>$kdmesin,
			'nmmesin'=>strtoupper($nmmesin),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdmesin',$kdmesin);
			$this->db->update('sc_mst.mesin',$info);
			redirect('master/mesin/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_mesin($kdmesin){
		$cek=$this->m_mesin->q_cekdel_mesin($kdmesin)->num_rows();
		if ($cek>0){
			redirect('master/mesin/index/del_alert');
		} else {
			$this->db->where('kdmesin',$kdmesin);
			$this->db->delete('sc_mst.mesin');
			redirect('master/mesin/index/del_succes');
		}
	}
	
}	