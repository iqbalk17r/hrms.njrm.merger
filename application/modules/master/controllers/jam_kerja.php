<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Jam_kerja extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_jam_kerja','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master jam_kerja";
		
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
		$data['list_jam_kerja']=$this->m_jam_kerja->q_jam_kerja()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/jam_kerja/v_jam_kerja',$data);
    }
	function add_jam_kerja(){
		$kdjam_kerja=trim(strtoupper(str_replace(" ","",$this->input->post('kdjam_kerja'))));
		$nmjam_kerja=$this->input->post('nmjam_kerja');
		$shiftke=$this->input->post('shiftke');
		$jam_masuk=$this->input->post('jam_masuk');
		$jam_masuk_min=$this->input->post('jam_masuk_min');
		$jam_masuk_max=$this->input->post('jam_masuk_max');
		$jam_istirahat=$this->input->post('jam_istirahat');
		$jam_istirahat_min=$this->input->post('jam_istirahat_min');
		$jam_istirahat_max=$this->input->post('jam_istirahat_max');
		$jam_istirahatselesai=$this->input->post('jam_istirahatselesai');
		$jam_istirahatselesai_min=$this->input->post('jam_istirahatselesai_min');
		$jam_istirahatselesai_max=$this->input->post('jam_istirahatselesai_max');
		$jam_pulang=$this->input->post('jam_pulang');
		$jam_pulang_min=$this->input->post('jam_pulang_min');
		$jam_pulang_max=$this->input->post('jam_pulang_max');
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdjam_kerja'=>$kdjam_kerja,
			'nmjam_kerja'=>strtoupper($nmjam_kerja),
			'shiftke'=>$shiftke,
			'jam_masuk'=>$jam_masuk,
			'jam_masuk_min'=>$jam_masuk_min,
			'jam_masuk_max'=>$jam_masuk_max,
			  'jam_istirahat'=>$jam_istirahat,
			  'jam_istirahat_min'=>$jam_istirahat_min,
			  'jam_istirahat_max'=>$jam_istirahat_max,
			  'jam_istirahatselesai'=>$jam_istirahatselesai,
			  'jam_istirahatselesai_min'=>$jam_istirahatselesai_min,
			  'jam_istirahatselesai_max'=>$jam_istirahatselesai_max,	
			   'jam_pulang'=>$jam_pulang,
			   'jam_pulang_min'=>$jam_pulang_min,
			   'jam_pulang_max'=>$jam_pulang_max,	
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $shiftke;
		
		//$this->db->where('custcode',$kode);
		$cek=$this->m_jam_kerja->q_cekjam_kerja($kdjam_kerja)->num_rows();
		if ($cek>0){
			redirect('master/jam_kerja/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.jam_kerja',$info);
			redirect('master/jam_kerja/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_jam_kerja(){
		$kdjam_kerja=trim(strtoupper(str_replace(" ","",$this->input->post('kdjam_kerja'))));
		$nmjam_kerja=$this->input->post('nmjam_kerja');
		$shiftke=$this->input->post('shiftke');
		$jam_masuk=$this->input->post('jam_masuk');
		$jam_masuk_min=$this->input->post('jam_masuk_min');
		$jam_masuk_max=$this->input->post('jam_masuk_max');
		$jam_istirahat=$this->input->post('jam_istirahat');
		$jam_istirahat_min=$this->input->post('jam_istirahat_min');
		$jam_istirahat_max=$this->input->post('jam_istirahat_max');
		$jam_istirahatselesai=$this->input->post('jam_istirahatselesai');
		$jam_istirahatselesai_min=$this->input->post('jam_istirahatselesai_min');
		$jam_istirahatselesai_max=$this->input->post('jam_istirahatselesai_max');
		$jam_pulang=$this->input->post('jam_pulang');
		$jam_pulang_min=$this->input->post('jam_pulang_min');
		$jam_pulang_max=$this->input->post('jam_pulang_max');
		$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'nmjam_kerja'=>strtoupper($nmjam_kerja),
			'shiftke'=>$shiftke,
			'jam_masuk'=>$jam_masuk,
			'jam_masuk_min'=>$jam_masuk_min,
			'jam_masuk_max'=>$jam_masuk_max,
			  'jam_istirahat'=>$jam_istirahat,
			  'jam_istirahat_min'=>$jam_istirahat_min,
			  'jam_istirahat_max'=>$jam_istirahat_max,
			  'jam_istirahatselesai'=>$jam_istirahatselesai,
			  'jam_istirahatselesai_min'=>$jam_istirahatselesai_min,
			  'jam_istirahatselesai_max'=>$jam_istirahatselesai_max,	
			   'jam_pulang'=>$jam_pulang,
			   'jam_pulang_min'=>$jam_pulang_min,
			   'jam_pulang_max'=>$jam_pulang_max,	
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdjam_kerja',$kdjam_kerja);
			$this->db->update('sc_mst.jam_kerja',$info);
			redirect('master/jam_kerja/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_jam_kerja($kdjam_kerja){
		$this->db->where('kdjam_kerja',$kdjam_kerja);
		$this->db->delete('sc_mst.jam_kerja');
		redirect('master/jam_kerja/index/del_succes');
	}
	
	
	
}	