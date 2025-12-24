<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Pendidikan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_pendidikan','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Status pendidikan";
		
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
		$data['list_pendidikan']=$this->m_pendidikan->q_pendidikan()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/pendidikan/v_pendidikan',$data);
    }
	function add_pendidikan(){
		$kdpendidikan=trim(strtoupper(str_replace(" ","",$this->input->post('kdpendidikan'))));
		$nmpendidikan=$this->input->post('nmpendidikan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdpendidikan'=>$kdpendidikan,
			'nmpendidikan'=>strtoupper($nmpendidikan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_pendidikan->q_cekpendidikan($kdpendidikan)->num_rows();
		if ($cek>0){
			redirect('master/pendidikan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.pendidikan',$info);
			redirect('master/pendidikan/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_pendidikan(){
		$kdpendidikan=trim($this->input->post('kdpendidikan'));
		$nmpendidikan=$this->input->post('nmpendidikan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdpendidikan'=>$kdpendidikan,
			'nmpendidikan'=>strtoupper($nmpendidikan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdpendidikan',$kdpendidikan);
			$this->db->update('sc_mst.pendidikan',$info);
			redirect('master/pendidikan/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_pendidikan($kdpendidikan){
		$this->db->where('kdpendidikan',$kdpendidikan);
		$this->db->delete('sc_mst.pendidikan');
		redirect('master/pendidikan/index/del_succes');
	}
	
}	