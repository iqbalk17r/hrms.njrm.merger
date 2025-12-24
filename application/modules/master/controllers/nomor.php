<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Nomor extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_nomor','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Nomor";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['list_nomor']=$this->m_nomor->q_nomor()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/nomor/v_nomor',$data);
    
	}
	function add_nomor(){
		$dokumen=trim(strtoupper($this->input->post('dokumen')));
		$part1=$this->input->post('part');
		if ($part1==''){
			$part==' ';
		} else {
			$part=$part1;
		}
		$count31=trim(strtoupper(str_replace("_","",$this->input->post('count3'))));
		if ($count31==''){
			$count3==NULL;
		} else {
			$count3=$count31;
		}
		$prefix=$this->input->post('prefix');
		$docno1=trim(strtoupper(str_replace("_","",$this->input->post('docno'))));
		if ($docno1==''){
			$docno=0;
		} else {
			$docno=$docno1;
		}
		$sufix=$this->input->post('sufix');
		$periode=$this->input->post('periode');
		$modul=$this->input->post('modul');
		$cekclose=$this->input->post('cekclose');
		//$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $count3;
		$info=array(
			'dokumen'=>$dokumen,
			'part'=>strtoupper($part),
			'prefix'=>strtoupper($prefix),
			'count3'=>$count3,
			'docno'=>$docno,
			'sufix'=>strtoupper($sufix),
			'periode'=>strtoupper($periode),
			'modul'=>strtoupper($modul),
			'cekclose'=>strtoupper($cekclose),
			'userid'=>$this->session->userdata('nik'),
		);
		
		//$this->db->where('custcode',$kode);
		$cek=$this->m_nomor->q_ceknomor($dokumen,$part)->num_rows();
		if ($cek>0){
			redirect('master/nomor/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.nomor',$info);
			redirect('master/nomor/index/rep_succes');
		}
		//echo $inputby;
		//$this->db->insert('sc_mst.nomor',$info);
		//redirect('master/nomor/index/rep_succes');
	
	}
	
	function edit_nomor(){
		$dokumen=trim(strtoupper(str_replace(" ","",$this->input->post('dokumen'))));
		$part1=$this->input->post('part');
		if ($part1==''){
			$part==' ';
		} else {
			$part=$part1;
		}
		$count3=trim(strtoupper(str_replace("_","",$this->input->post('count3'))));
		if ($count3==''){
			$count3==NULL;
		} else {
			$count3=$count3;
		}
		$prefix=$this->input->post('prefix');
		$docno1=trim(strtoupper(str_replace("_","",$this->input->post('docno'))));
		if ($docno1==''){
			$docno=NULL;
		} else {
			$docno=$docno1;
		}
		$sufix=$this->input->post('sufix');
		$periode=$this->input->post('periode');
		$modul=$this->input->post('modul');
		$cekclose=$this->input->post('cekclose');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $sub;
		$info=array(
			
			'prefix'=>strtoupper($prefix),
			'count3'=>$count3,
			'docno'=>$docno,
			'sufix'=>strtoupper($sufix),
			'periode'=>strtoupper($periode),
			'modul'=>strtoupper($modul),
			'cekclose'=>strtoupper($cekclose),
			'userid'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('dokumen',$dokumen);
			//$this->db->where('part',$part);
			$this->db->update('sc_mst.nomor',$info);
			redirect('master/nomor/index/edit_succes');
		
		//echo $inputby;
	}
	
	function hps_nomor($dokumen){
		$this->db->where('dokumen',$dokumen);
		$this->db->delete('sc_mst.nomor');
		redirect('master/nomor/index/del_succes');
	}
	
	function nomorlalu(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Nomor Lalu";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['list_nomor']=$this->m_nomor->q_nomorlalu()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/nomor/v_nomorlalu',$data);
    
	}
	
	function add_nomorlalu(){
		$dokumen=trim(strtoupper($this->input->post('dokumen')));
		$part1=$this->input->post('part');
		if ($part1==''){
			$part==' ';
		} else {
			$part=$part1;
		}
		$count31=trim(strtoupper(str_replace("_","",$this->input->post('count3'))));
		if ($count31==''){
			$count3==NULL;
		} else {
			$count3=$count31;
		}
		$prefix=$this->input->post('prefix');
		$docno1=trim(strtoupper(str_replace("_","",$this->input->post('docno'))));
		if ($docno1==''){
			$docno=NULL;
		} else {
			$docno=$docno1;
		}
		$sufix=$this->input->post('sufix');
		$periode=$this->input->post('periode');
		$modul=$this->input->post('modul');
		$cekclose=$this->input->post('cekclose');
		//$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $count3;
		$info=array(
			'dokumen'=>$dokumen,
			'part'=>strtoupper($part),
			'prefix'=>strtoupper($prefix),
			'count3'=>$count3,
			'docno'=>$docno,
			'sufix'=>strtoupper($sufix),
			'periode'=>strtoupper($periode),
			'modul'=>strtoupper($modul),
			'cekclose'=>strtoupper($cekclose),
			'userid'=>strtoupper($inputby),
		);
		
		//$this->db->where('custcode',$kode);
		$cek=$this->m_nomor->q_ceknomorlalu($dokumen,$part)->num_rows();
		if ($cek>0){
			redirect('master/nomor/nomorlalu/kode_failed');
		} else {
			$this->db->insert('sc_mst.nomorlalu',$info);
			redirect('master/nomor/nomorlalu/rep_succes');
		}
		//echo $inputby;
		//$this->db->insert('sc_mst.nomor',$info);
		//redirect('master/nomor/index/rep_succes');
	
	}
	
	function edit_nomorlalu(){
		$dokumen=trim(strtoupper(str_replace(" ","",$this->input->post('dokumen'))));
		$part1=$this->input->post('part');
		if ($part1==''){
			$part==' ';
		} else {
			$part=$part1;
		}
		$count3=trim(strtoupper(str_replace("_","",$this->input->post('count3'))));
		if ($count3==''){
			$count3==NULL;
		} else {
			$count3=$count3;
		}
		$prefix=$this->input->post('prefix');
		$docno1=trim(strtoupper(str_replace("_","",$this->input->post('docno'))));
		if ($docno1==''){
			$docno=NULL;
		} else {
			$docno=$docno1;
		}
		$sufix=$this->input->post('sufix');
		$periode=$this->input->post('periode');
		$modul=$this->input->post('modul');
		$cekclose=$this->input->post('cekclose');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $sub;
		$info=array(
			
			'prefix'=>strtoupper($prefix),
			'count3'=>$count3,
			'docno'=>$docno,
			'sufix'=>strtoupper($sufix),
			'periode'=>strtoupper($periode),
			'modul'=>strtoupper($modul),
			'cekclose'=>strtoupper($cekclose),
			'userid'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('dokumen',$dokumen);
			$this->db->where('part',$part);
			$this->db->update('sc_mst.nomorlalu',$info);
			redirect('master/nomor/nomorlalu/edit_succes');
		
		//echo $inputby;
	}
	function hps_nomorlalu($dokumen){
		$this->db->where('dokumen',$dokumen);
		$this->db->delete('sc_mst.nomorlalu');
		redirect('master/nomor/nomorlalu/del_succes');
	}
	
}	