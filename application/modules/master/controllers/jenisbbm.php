<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Jenisbbm extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_jenisbbm'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Jenis BBM";
		
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
		$data['list_jenisbbm']=$this->m_jenisbbm->q_jenisbbm()->result();
        $this->template->display('master/jenisbbm/v_jenisbbm',$data);
    }

	function add_jenisbbm(){
		$kdjenisbbm=trim(strtoupper(str_replace(" ","",$this->input->post('kdjenisbbm'))));
		$nmjenisbbm=$this->input->post('nmjenisbbm');
		$hargasatuan=$this->input->post('hargasatuan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');

		$info=array(
			'kdjenisbbm'=>$kdjenisbbm,
			'nmjenisbbm'=>strtoupper($nmjenisbbm),
			'hargasatuan'=>$hargasatuan,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		$cek=$this->m_jenisbbm->q_cekjenisbbm($kdjenisbbm)->num_rows();
		if ($cek>0){
			redirect('master/jenisbbm/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.jenisbbm',$info);
			redirect('master/jenisbbm/index/rep_succes');
		}
	}
	
	function edit_jenisbbm(){
		$kdjenisbbm=trim($this->input->post('kdjenisbbm'));
		$nmjenisbbm=$this->input->post('nmjenisbbm');
        $hargasatuan=$this->input->post('hargasatuan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');

		$info=array(
			'nmjenisbbm'=>strtoupper($nmjenisbbm),
            'hargasatuan'=>$hargasatuan,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);

        $this->db->where('kdjenisbbm',$kdjenisbbm);
        $this->db->update('sc_mst.jenisbbm',$info);
        redirect('master/jenisbbm/index/rep_succes');
	}
	
	function hps_jenisbbm($kdjenisbbm){
		$this->db->where('kdjenisbbm',$kdjenisbbm);
		$this->db->delete('sc_mst.jenisbbm');
		redirect('master/jenisbbm/index/del_succes');
	}
	
}	
