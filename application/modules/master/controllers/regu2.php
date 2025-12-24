<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Regu extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_regu','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Regu";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_alert")
            $data['message']="<div class='alert alert-warning'>Data Sudah Digunakan, Hapus Data Child Terlebih Dahulu</div>";	
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_regu']=$this->m_regu->q_regu()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/regu/v_regu',$data);
    }
	function add_regu(){
		$kdregu=trim(strtoupper(str_replace(" ","",$this->input->post('kdregu'))));
		$nmregu=$this->input->post('nmregu');
		$keterangan=$this->input->post('keterangan');
		$warna=$this->input->post('warna');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdregu'=>$kdregu,
			'nmregu'=>strtoupper($nmregu),
			'keterangan'=>strtoupper($keterangan),
			'warna'=>strtoupper($warna),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_regu->q_cekregu($kdregu)->num_rows();
		if ($cek>0){
			redirect('master/regu/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.regu',$info);
			redirect('master/regu/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_regu(){
		$kdregu=trim($this->input->post('kdregu'));
		$nmregu=$this->input->post('nmregu');
		$keterangan=$this->input->post('keterangan');
		$warna=$this->input->post('warna');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdregu'=>$kdregu,
			'nmregu'=>strtoupper($nmregu),
			'keterangan'=>strtoupper($keterangan),
			'warna'=>strtoupper($warna),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdregu',$kdregu);
			$this->db->update('sc_mst.regu',$info);
			redirect('master/regu/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_regu($kdregu){
		$cek=$this->m_regu->q_cek_del_regu($kdregu)->num_rows();
		if ($cek>0) {
			redirect('master/regu/index/del_alert');
		} else {
			$this->db->where('kdregu',$kdregu);
			$this->db->delete('sc_mst.regu');
			redirect('master/regu/index/del_succes');
		}
	}
	
	function regu_opr(){
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Regu Operator";
		
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_alert")
            $data['message']="<div class='alert alert-warning'>Data Sudah Digunakan, Hapus Data Child Terlebih Dahulu</div>";	
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_regu']=$this->m_regu->q_regu()->result();
		$data['list_nik']=$this->m_regu->q_list_nik()->result();
		$data['list_regu_opr']=$this->m_regu->q_regu_opr()->result();
        $this->template->display('master/regu/v_regu_opr',$data);
	
	}
	function add_regu_opr(){
		$kdregu1=explode('|',$this->input->post('kdregu'));
		$kdregu=$kdregu1[0];
		//$nmregu=$this->input->post('nmregu');
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdregu'=>$kdregu,
			'nik'=>$nik,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_regu->q_cekregu_opr($kdregu,$nik)->num_rows();
		if ($cek>0){
			redirect('master/regu/regu_opr/kode_failed');
		} else {
			$this->db->insert('sc_mst.regu_opr',$info);
			redirect('master/regu/regu_opr/rep_succes');
		}
		//$this->db->insert('sc_mst.regu_opr',$info);
			//redirect('master/regu/regu_opr');
	}
	
	function hps_regu_opr($no_urut){
		$kdregu=$this->uri->segment(5);
		$cek=$this->m_regu->q_cek_del_regu($kdregu)->num_rows();
		//echo $kdregu;
		//echo $no_urut;
		if ($cek>0){
			redirect('master/regu/regu_opr/del_alert');
		} else {
			$this->db->where('no_urut',$no_urut);
			//$this->db->where('kdregu',$kdregu);
			$this->db->delete("sc_mst.regu_opr");
			redirect('master/regu/regu_opr/del_succes');
		}
	}
	
	function edit_regu_opr(){
		$kdregu=trim($this->input->post('kdregu'));
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		//$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		//echo $sub;
		$info=array(
			//'kdregu'=>$kdregu,
			'nik'=>$nik,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('no_urut',$no_urut);
			$this->db->update('sc_mst.regu_opr',$info);
			redirect('master/regu/regu_opr/rep_succes');
		
		//echo $inputby;
	}
	
}	