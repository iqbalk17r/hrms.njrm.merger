<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Kompetensi extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_kompetensi','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
	 function index(){
			//echo "test";
			$nama=$this->session->userdata('nik');
			$data['title']="List Master Kompetensi";
			
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
			
			//$data['list_department']=$this->m_department->q_department()->result();
			//$data['list_subdepartment']=$this->m_department->q_subdepartment()->result();
			//$data['list_jobgrade']=$this->m_jabatan->q_jobgrade()->result();
			//$data['list_jabatan']=$this->m_jabatan->q_jabatan()->result();
			$data['list_kompetensi']=$this->m_kompetensi->q_kompetensi()->result();
			$data['list_jeniskom']=$this->m_kompetensi->q_jeniskom()->result();
			$data['list_ind_prilaku']=$this->m_kompetensi->q_ind_prilaku()->result();
			//$data['message']="List SMS Masuk";
			$this->template->display('master/kompetensi/v_kompetensi',$data);
		}
	function dk_jabatan(){
		//echo "tes";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Detail Kompetensi Jabatan";
		
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
		$data['list_kompetensi']=$this->m_kompetensi->q_kompetensi()->result();
		$data['list_dkjabatan']=$this->m_kompetensi->q_dk_jabatan()->result();
		$data['list_jabatan']=$this->m_jabatan->q_jabatan()->result();
		 $this->template->display('master/dkjabatan/v_dkjabatan',$data);
		
		}
	
		function add_kompetensi(){
		$kdkom=trim(strtoupper(str_replace(" ","",$this->input->post('kdkom'))));
		$nmkom=$this->input->post('nmkom');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$jenis=$this->input->post('jeniskom');
		$lvl_indikator=$this->input->post('lvl_indikator');
		$ket=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdkom'=>$kdkom,
			'nmkom'=>strtoupper($nmkom),
			'jeniskom'=>strtoupper($jenis),
			'lvl_indikator'=>strtoupper($lvl_indikator),
			'keterangan'=>strtoupper($ket),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_kompetensi->q_cekkompetensi($kdkom)->num_rows();
		if ($cek>0){
			redirect('master/kompetensi/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.kompetensi',$info);
			redirect('master/kompetensi/index');
		}
		//echo $inputby;
	}
	function add_dkjabatan(){
		$kdjabatan=trim(strtoupper(str_replace(" ","",$this->input->post('kdjabatan'))));
		$kdkom=trim(strtoupper(str_replace(" ","",$this->input->post('kdkom'))));
		//$nmkom=$this->input->post('nmkom');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$jenis=$this->input->post('jeniskom');
		//$lvl_indikator=$this->input->post('lvl_indikator');
		$ket=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdjabatan'=>$kdjabatan,	
			'kdkom'=>$kdkom,			
			'keterangan'=>strtoupper($ket),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		//$cek=$this->m_kompetensi->q_cekkompetensi($kdkom)->num_rows();
		/*if ($cek>0){
			redirect('master/kompetensi/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.kompetensi',$info);
			redirect('master/kompetensi/index');
		}*/
		//echo $inputby;
		$this->db->insert('sc_mst.dk_jabatan',$info);
			redirect('master/kompetensi/dk_jabatan');
	}
	
	function edit_kompetensi(){
		$kdkom=trim($this->input->post('kdkom'));
		$nmkom=$this->input->post('nmkom');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$jenis=$this->input->post('jeniskom');
		$lvl_indikator=$this->input->post('lvl_indikator');
		$ket=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdkom'=>$kdkom,
			'nmkom'=>strtoupper($nmkom),
			'jeniskom'=>strtoupper($jenis),
			'lvl_indikator'=>strtoupper($lvl_indikator),
			'keterangan'=>strtoupper($ket),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdkom',$kdkom);
			$this->db->update('sc_mst.kompetensi',$info);
			redirect('master/kompetensi/index');
		
		//echo $inputby;
	}
	
	function edit_dkjabatan($no_dk){
		$no_dk=trim($this->input->post('no_dk'));
		$kdjabatan=trim(strtoupper(str_replace(" ","",$this->input->post('kdjabatan'))));
		$kdkom=trim(strtoupper(str_replace(" ","",$this->input->post('kdkom'))));
		//$nmkom=$this->input->post('nmkom');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$jenis=$this->input->post('jeniskom');
		//$lvl_indikator=$this->input->post('lvl_indikator');
		$ket=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdjabatan'=>$kdjabatan,	
			'kdkom'=>$kdkom,			
			'keterangan'=>strtoupper($ket),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
			//echo $ket;
			$this->db->where('no_dk',$no_dk);
			$this->db->update('sc_mst.dk_jabatan',$info);
			redirect('master/kompetensi/dk_jabatan');
	}
	
	function hps_kompetensi($kdkom){
		$this->db->where('kdkom',$kdkom);
		$this->db->delete('sc_mst.kompetensi');
		redirect('master/kompetensi/index');
	}
	
	function hps_dkjabatan($no_dk){
		$this->db->where('no_dk',$no_dk);
		$this->db->delete('sc_mst.dk_jabatan');
		redirect('master/kompetensi/dk_jabatan');
	}
}