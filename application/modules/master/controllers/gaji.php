<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Gaji extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_gaji','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master gaji";
		
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
		$data['list_gaji']=$this->m_gaji->q_gaji()->result();
		$data['list_grade']=$this->m_gaji->q_jobgrade()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/gaji/v_gaji',$data);
    }
	
	function add_gaji(){
		$kdgrade=trim(strtoupper(str_replace(" ","",$this->input->post('kdgrade'))));
		$gp_eskalasi=str_replace("_","",$this->input->post('gp_eskalasi'));
		$gp_min=str_replace("_","",$this->input->post('gp_min'));
		$gp_max=str_replace("_","",$this->input->post('gp_max'));
		$tunjangan_jbt=str_replace("_","",$this->input->post('tunjangan_jbt'));
		$periode=$this->input->post('periode');
		$total_upah=$gp_min+$tunjangan_jbt;
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdgrade'=>$kdgrade,
			'gp_eskalasi'=>$gp_eskalasi,
			'gp_min'=>$gp_min,
			'gp_max'=>$gp_max,
			'tunjangan_jbt'=>$tunjangan_jbt,
			'periode'=>$periode,
			'total_upah'=>$total_upah,
			'inputdate'=>$tgl_input,
			'inputby'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_gaji->q_cekgaji($kdgrade,$periode)->num_rows();
		if ($cek>0){
			redirect('master/gaji/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.gaji',$info);
			redirect('master/gaji/index/rep_succes');
		}
		
	}
	
	function edit_gaji(){
		$kdgrade=trim(strtoupper(str_replace(" ","",$this->input->post('kdgrade'))));
		$gp_eskalasi=str_replace("_","",$this->input->post('gp_eskalasi'));
		$gp_min=str_replace("_","",$this->input->post('gp_min'));
		$gp_max=str_replace("_","",$this->input->post('gp_max'));
		$tunjangan_jbt=str_replace("_","",$this->input->post('tunjangan_jbt'));
		$periode=$this->input->post('periode');
		$total_upah=$gp_min+$tunjangan_jbt;
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'gp_eskalasi'=>$gp_eskalasi,
			'gp_min'=>$gp_min,
			'gp_max'=>$gp_max,
			'tunjangan_jbt'=>$tunjangan_jbt,
			'total_upah'=>$total_upah,
			'updatedate'=>$tgl_input,
			'updateby'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdgrade',$kdgrade);
			$this->db->where('periode',$periode);
			$this->db->update('sc_mst.gaji',$info);
			redirect('master/gaji/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_gaji($id){
		$this->db->where('id',$id);
		$this->db->delete('sc_mst.gaji');
		redirect('master/gaji/index/del_succes');
	}
	
	function kodegaji(){
	
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Kode Komponen Gaji";
		
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
		$data['list_kodegaji']=$this->m_gaji->q_kodegaji()->result();
		//$data['list_grade']=$this->m_gaji->q_jobgrade()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/gaji/v_kodegaji',$data);
	
		
	
	}
	
	function add_kodegaji(){
		$kdgaji=trim(strtoupper(str_replace(" ","",$this->input->post('kdgaji'))));
		$uraian=strtoupper($this->input->post('uraian'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		

		//echo $sub;
		$info=array(
			'kdgaji'=>$kdgaji,
			'uraian'=>$uraian,
			'keterangan'=>$keterangan,
			'inputdate'=>$tgl_input,
			'inputby'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_gaji->q_cekkodegaji($kdgaji,$uraian)->num_rows();
		if ($cek>0){
			redirect('master/gaji/kodegaji/kode_failed');
		} else {
			$this->db->insert('sc_mst.kodegaji',$info);
			redirect('master/gaji/kodegaji/rep_succes');
		}
		
	}
	
	function edit_kodegaji(){
		$kdgaji=trim(strtoupper(str_replace(" ","",$this->input->post('kdgaji'))));
		$uraian=strtoupper($this->input->post('uraian'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$tgl_input=$this->input->post('tgl');
		$id=$this->input->post('id');
		$inputby=$this->input->post('inputby');
		
	
		$info=array(
			'kdgaji'=>$kdgaji,
			'uraian'=>$uraian,
			'keterangan'=>$keterangan,
			'updatedate'=>$tgl_input,
			'updateby'=>strtoupper($inputby),
		);
		
		$this->db->where('id',$id);
		$this->db->update('sc_mst.kodegaji',$info);
		redirect("master/gaji/kodegaji/rep_succes");
	}
	
	function hps_kodegaji($id){
		$this->db->where('id',$id);
		$this->db->delete('sc_mst.kodegaji');
		redirect('master/gaji/kodegaji/del_succes');
	}
	
}	