<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Eg_jabatan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_eg_jabatan','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Group Penggajian";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_jabatan']=$this->m_jabatan->q_jabatan()->result();
		$data['list_eg_jabatan']=$this->m_eg_jabatan->q_eg_jabatan()->result();
		$data['list_trxtype']=$this->m_eg_jabatan->q_trxtype()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/egjabatan/v_egjabatan',$data);
    }
	
	function add_egjabatan(){
		$kdjabatan=trim(strtoupper(str_replace(" ","",$this->input->post('kdjabatan'))));
		$kdtrx=trim(strtoupper(str_replace(" ","",$this->input->post('kdtrx'))));
		//$nmkeahlian=$this->input->post('nmkeahlian');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$jenis=$this->input->post('jeniskom');
		//$lvl_indikator=$this->input->post('lvl_indikator');
		$ket=$this->input->post('nmeg_jabatan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdjabatan'=>$kdjabatan,	
			'kdtrx'=>$kdtrx,			
			'nmeg_jabatan'=>strtoupper($ket),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		//$cek=$this->m_keahlian->q_cekkeahlian($kdtrx)->num_rows();
		/*if ($cek>0){
			redirect('master/keahlian/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.keahlian',$info);
			redirect('master/keahlian/index');
		}*/
		//echo $inputby;
		$this->db->insert('sc_mst.eg_jabatan',$info);
		redirect('master/eg_jabatan/index');
	}
	
	function hps_egjabatan($no_eg){
		$this->db->where('no_eg',$no_eg);
		$this->db->delete('sc_mst.eg_jabatan');
		redirect('master/eg_jabatan/index');
	}
	
	function edit_egjabatan($no_eg){
		$no_eg=trim($this->input->post('no_eg'));
		$kdjabatan=trim(strtoupper(str_replace(" ","",$this->input->post('kdjabatan'))));
		$kdtrx=trim(strtoupper(str_replace(" ","",$this->input->post('kdtrx'))));
		//$nmkeahlian=$this->input->post('nmkeahlian');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$jenis=$this->input->post('jeniskom');
		//$lvl_indikator=$this->input->post('lvl_indikator');
		$ket=$this->input->post('nmeg_jabatan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdjabatan'=>$kdjabatan,	
			'kdtrx'=>$kdtrx,			
			'nmeg_jabatan'=>strtoupper($ket),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
			//echo $ket;
			$this->db->where('no_dk',$no_eg);
			$this->db->update('sc_mst.eg_jabatan',$info);
			redirect('master/eg_jabatan/index');
	}
	
	function keahlian(){
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Bidang Keahlian";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		//$data['list_jabatan']=$this->m_jabatan->q_jabatan()->result();
		//$data['list_eg_jabatan']=$this->m_eg_jabatan->q_eg_jabatan()->result();
		$data['list_keahlian']=$this->m_eg_jabatan->q_keahlian()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/keahlian/v_keahlian',$data);
	
	}
	
	function add_keahlian(){
		$kdkeahlian=trim(strtoupper(str_replace(" ","",$this->input->post('kdkeahlian'))));
		$nmkeahlian=$this->input->post('nmkeahlian');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdkeahlian'=>$kdkeahlian,
			'nmkeahlian'=>strtoupper($nmkeahlian),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_eg_jabatan->q_cekkeahlian($kdkeahlian)->num_rows();
		if ($cek>0){
			redirect('master/eg_jabatan/keahlian/kode_failed');
		} else {
			$this->db->insert('sc_mst.keahlian',$info);
			redirect('master/eg_jabatan/keahlian');
		}
		//echo $inputby;
	}
	
	function edit_keahlian(){
		$kdkeahlian=trim($this->input->post('kdkeahlian'));
		$nmkeahlian=$this->input->post('nmkeahlian');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdkeahlian'=>$kdkeahlian,
			'nmkeahlian'=>strtoupper($nmkeahlian),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdkeahlian',$kdkeahlian);
			$this->db->update('sc_mst.keahlian',$info);
			redirect('master/eg_jabatan/keahlian');
		
		//echo $inputby;
	}
	
	function hps_keahlian($kdkeahlian){
		$this->db->where('kdkeahlian',$kdkeahlian);
		$this->db->delete('sc_mst.keahlian');
		redirect('master/eg_jabatan/keahlian');
	}
}