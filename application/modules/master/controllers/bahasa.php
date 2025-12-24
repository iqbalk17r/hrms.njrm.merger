<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Bahasa extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_bahasa','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Bahasa";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_exist")
            $data['message']="<div class='alert alert-danger'>Hapus Data Child Terlebih Dahulu</div>";
        else
            $data['message']='';
		$data['list_bahasa']=$this->m_bahasa->q_bahasa()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/bahasa/v_bahasa',$data);
    }
	function add_bahasa(){
		$kdbahasa=trim(strtoupper(str_replace(" ","",$this->input->post('kdbahasa'))));
		$nmbahasa=$this->input->post('nmbahasa');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdbahasa'=>$kdbahasa,
			'nmbahasa'=>strtoupper($nmbahasa),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_bahasa->q_cekbahasa($kdbahasa)->num_rows();
		if ($cek>0){
			redirect('master/bahasa/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bahasa',$info);
			redirect('master/bahasa/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_bahasa(){
		$kdbahasa=trim($this->input->post('kdbahasa'));
		$nmbahasa=$this->input->post('nmbahasa');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdbahasa'=>$kdbahasa,
			'nmbahasa'=>strtoupper($nmbahasa),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdbahasa',$kdbahasa);
			$this->db->update('sc_mst.bahasa',$info);
			redirect('master/bahasa/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_bahasa($kdbahasa){
		$cek_delete=$this->m_bahasa->q_cekdel_bahasa(kdbahasa);
		if ($cek_delete>0){
			redirect('master/bahasa/index/del_exist');
		} else {
		$this->db->where('kdbahasa',$kdbahasa);
		$this->db->delete('sc_mst.bahasa');
		redirect('master/bahasa/index/del_succes');
		}
	}
	
}	