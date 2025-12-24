<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Jenjang_pendidikan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_jenjang_pendidikan','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Status Jenjang Pendidikan";
		
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
		$data['list_jenjang_pendidikan']=$this->m_jenjang_pendidikan->q_jenjang_pendidikan()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/jenjang_pendidikan/v_jenjang_pendidikan',$data);
    }
	function add_jenjang_pendidikan(){
		$kdjenjang_pendidikan=trim(strtoupper(str_replace(" ","",$this->input->post('kdjenjang_pendidikan'))));
		$nmjenjang_pendidikan=$this->input->post('nmjenjang_pendidikan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdjenjang_pendidikan'=>$kdjenjang_pendidikan,
			'nmjenjang_pendidikan'=>strtoupper($nmjenjang_pendidikan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_jenjang_pendidikan->q_cekjenjang_pendidikan($kdjenjang_pendidikan)->num_rows();
		if ($cek>0){
			redirect('master/jenjang_pendidikan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.jenjang_pendidikan',$info);
			redirect('master/jenjang_pendidikan/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_jenjang_pendidikan(){
		$kdjenjang_pendidikan=trim($this->input->post('kdjenjang_pendidikan'));
		$nmjenjang_pendidikan=$this->input->post('nmjenjang_pendidikan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdjenjang_pendidikan'=>$kdjenjang_pendidikan,
			'nmjenjang_pendidikan'=>strtoupper($nmjenjang_pendidikan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdjenjang_pendidikan',$kdjenjang_pendidikan);
			$this->db->update('sc_mst.jenjang_pendidikan',$info);
			redirect('master/jenjang_pendidikan/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_jenjang_pendidikan($kdjenjang_pendidikan){
		$this->db->where('kdjenjang_pendidikan',$kdjenjang_pendidikan);
		$this->db->delete('sc_mst.jenjang_pendidikan');
		redirect('master/jenjang_pendidikan/index/del_succes');
	}
	
}	