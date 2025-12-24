<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Bpjskaryawan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_bpjs','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master BPJS Karyawan";
		
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
		$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();	
		$data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
		$data['list_bpjskaryawan']=$this->m_bpjs->list_bpjs_karyawan()->result();
		$data['list_faskes']=$this->m_bpjs->list_faskes()->result();
		$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
        $this->template->display('master/bpjs/bpjskaryawan/v_list',$data);
    }
	function add_bpjs(){
		$id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
		//$nmbpjs=$this->input->post('nmbpjs');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$kode_bpjs1=explode('|',$this->input->post('kode_bpjs'));
		$kode_bpjs=$kode_bpjs1[0];
		$kodekomponen1=explode('|',$this->input->post('kodekomponen'));
		$kodekomponen=$kodekomponen1[0];
		$kodefaskes1=explode('|',$this->input->post('kodefaskes'));
		$kodefaskes=$kodefaskes1[0];
		$kodefaskes3=explode('|',$this->input->post('kodefaskes2'));
		$kodefaskes2=$kodefaskes3[0];
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		$kelas=$this->input->post('kelas');
		$keterangan=$this->input->post('keterangan');
		$tgl_berlaku=$this->input->post('tgl_berlaku');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'id_bpjs'=>$id_bpjs,
			'kode_bpjs'=>$kode_bpjs,
			'kodekomponen'=>$kodekomponen,
			'kodefaskes'=>$kodefaskes,
			'kodefaskes2'=>$kodefaskes2,	
			'nik'=>$nik,
			'kelas'=>strtoupper($kelas),
			'keterangan'=>strtoupper($keterangan),
			'tgl_berlaku'=>$tgl_berlaku,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_berlaku;
		//$this->db->where('custcode',$kode);
		$cek=$this->m_bpjs->q_cek_bpjs($id_bpjs)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}
		//$this->db->insert('sc_mst.bpjs_karyawan',$info);
			//redirect('master/bpjskaryawan/index/rep_succes');
		//echo $inputby;
	}
	
	function edit_bpjs(){
		$id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
		//$nmbpjs=$this->input->post('nmbpjs');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$kode_bpjs1=explode('|',$this->input->post('kode_bpjs'));
		$kode_bpjs=$kode_bpjs1[0];
		$kodekomponen1=explode('|',$this->input->post('kodekomponen'));
		$kodekomponen=$kodekomponen1[0];
		$kodefaskes1=explode('|',$this->input->post('kodefaskes'));
		$kodefaskes=$kodefaskes1[0];
		$kodefaskes3=explode('|',$this->input->post('kodefaskes2'));
		$kodefaskes2=$kodefaskes3[0];
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		$kelas=$this->input->post('kelas');
		$keterangan=$this->input->post('keterangan');
		$tgl_berlaku=$this->input->post('tgl_berlaku');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$info=array(
			'kode_bpjs'=>$kode_bpjs,
			'kodekomponen'=>$kodekomponen,
			'kodefaskes'=>$kodefaskes,
			'kodefaskes2'=>$kodefaskes2,	
			'nik'=>$nik,
			'kelas'=>strtoupper($kelas),
			'keterangan'=>strtoupper($keterangan),
			'tgl_berlaku'=>$tgl_berlaku,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('id_bpjs',$id_bpjs);
			$this->db->update('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index');
		
		//echo $inputby;
	}
	
	function hps_bpjs($id_bpjs){
		$this->db->where('id_bpjs',$id_bpjs);
		$this->db->delete('sc_mst.bpjs_karyawan');
		redirect('master/bpjskaryawan/index');
	}
	
}	