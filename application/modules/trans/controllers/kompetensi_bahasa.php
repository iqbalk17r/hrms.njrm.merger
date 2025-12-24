<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Kompetensi_bahasa extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_kompetensi_bahasa','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Kompetensi Bahasa ";
		
		if($this->uri->segment(5)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Bahasa Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Bahasa Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$nik=$this->uri->segment(4);
		$kmenu='I.T.A.9';
		$data['nik']=$nik;
		$data['list_karyawan']=$this->m_kompetensi_bahasa->list_karyawan()->result();
		$data['list_lk']=$this->m_kompetensi_bahasa->list_karyawan_index($nik)->row_array();
		$data['list_bahasa']=$this->m_kompetensi_bahasa->list_bahasa()->result();
		$data['list_kompetensi_bahasa']=$this->m_kompetensi_bahasa->q_kompetensi_bahasa($nik)->result();
		$data['list_rk']=$this->m_kompetensi_bahasa->q_kompetensi_bahasa($nik)->row_array();
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        $this->template->display('trans/kompetensi_bahasa/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_kompetensi_bahasa->list_karyawan()->result();
		$this->template->display('trans/kompetensi_bahasa/v_list_karyawan',$data);
	}
	
	function add_kompetensi_bahasa(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$kdbahasa=$this->input->post('kdbahasa');
		$kem_baca=$this->input->post('kem_baca');
		$kem_dengar=$this->input->post('kem_dengar');
		$kem_tulis=str_replace("_","",$this->input->post('kem_tulis'));
		$kem_bicara=str_replace("_","",$this->input->post('kem_bicara'));
		$keterangan=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'nik'=>$nik,
			'kdbahasa'=>$kdbahasa,
			'kem_baca'=>strtoupper($kem_baca),
			'kem_dengar'=>strtoupper($kem_dengar),
			'kem_bicara'=>strtoupper($kem_bicara),
			'kem_tulis'=>strtoupper($kem_tulis),
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_berlaku;
		//$this->db->where('custcode',$kode);
		$cek=$this->m_kompetensi_bahasa->q_cek_bahasa($nik,$kdbahasa)->num_rows();
		if ($cek>0){
			redirect("trans/kompetensi_bahasa/index/$nik/kode_failed");
		} else {
			$this->db->insert('sc_trx.kompetensi_bahasa',$info);
			redirect("trans/kompetensi_bahasa/index/$nik/rep_succes");
		}
		//$this->db->insert('sc_trx.kompetensi_bahasa',$info);
		//redirect("trans/kompetensi_bahasa/index/$nik/rep_succes");
		//echo $inputby;
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/kompetensi_bahasa/index/$nik");
		} else {
			$data['title']='EDIT DATA RIWAYAT KELUARGA';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$nik=$this->uri->segment(4);
			$data['nik']=$nik;
			$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();	
			$data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
			$data['list_bpjskaryawan']=$this->m_bpjs->q_bpjs_karyawan()->result();
			$data['list_faskes']=$this->m_bpjs->list_faskes()->result();
			$data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
			$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_keluarga']=$this->m_kompetensi_bahasa->list_keluarga()->result();
			$data['list_negara']=$this->m_kompetensi_bahasa->list_negara()->result();
			$data['list_prov']=$this->m_kompetensi_bahasa->list_prov()->result();
			$data['list_kotakab']=$this->m_kompetensi_bahasa->list_kotakab()->result();
			$data['list_jenjang_kdbahasa']=$this->m_kompetensi_bahasa->list_jenjang_kdbahasa()->result();
			$data['list_rk']=$this->m_kompetensi_bahasa->q_kompetensi_bahasa_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/kompetensi_bahasa/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/kompetensi_bahasa/index/$nik");
		} else {
			$data['title']='DETAIL DATA RIWAYAT KELUARGA';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$nik=$this->uri->segment(4);
			$data['nik']=$nik;
			$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();	
			$data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
			$data['list_bpjskaryawan']=$this->m_bpjs->q_bpjs_karyawan()->result();
			$data['list_faskes']=$this->m_bpjs->list_faskes()->result();
			$data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
			$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_keluarga']=$this->m_kompetensi_bahasa->list_keluarga()->result();
			$data['list_negara']=$this->m_kompetensi_bahasa->list_negara()->result();
			$data['list_prov']=$this->m_kompetensi_bahasa->list_prov()->result();
			$data['list_kotakab']=$this->m_kompetensi_bahasa->list_kotakab()->result();
			$data['list_jenjang_kdbahasa']=$this->m_kompetensi_bahasa->list_jenjang_kdbahasa()->result();
			$data['list_rk']=$this->m_kompetensi_bahasa->q_kompetensi_bahasa_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/kompetensi_bahasa/v_detail',$data);
		}	
	}
	function edit_kompetensi_bahasa(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$kdbahasa=$this->input->post('kdbahasa');
		$kem_baca=$this->input->post('kem_baca');
		$kem_dengar=$this->input->post('kem_dengar');
		$kem_tulis=str_replace("_","",$this->input->post('kem_tulis'));
		$kem_bicara=str_replace("_","",$this->input->post('kem_bicara'));
		$keterangan=$this->input->post('keterangan');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		$info=array(
			'kem_baca'=>strtoupper($kem_baca),
			'kem_dengar'=>strtoupper($kem_dengar),
			'kem_bicara'=>strtoupper($kem_bicara),
			'kem_tulis'=>strtoupper($kem_tulis),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('no_urut',$no_urut);
			//$this->db->where('kdbahasa',$kdbahasa);
			//$this->db->where('nik',$nik);
			//$this->db->where('kdkdbahasa',$kdkdbahasa);
			$this->db->update('sc_trx.kompetensi_bahasa',$info);
			redirect("trans/kompetensi_bahasa/index/$nik/rep_succes");
		
		//echo $inputby;
	}
	
	function hps_kompetensi_bahasa($nik,$no_urut){
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_trx.kompetensi_bahasa');
		redirect("trans/kompetensi_bahasa/index/$nik/del_succes");
	}
	
}	