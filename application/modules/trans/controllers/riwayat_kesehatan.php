<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Riwayat_kesehatan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_riwayat_kesehatan','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Riwayat Kesehatan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kesehatan Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$kmenu='I.T.A.10';
		$nik=$this->uri->segment(4);
		$data['nik']=$nik;
		$data['list_karyawan']=$this->m_riwayat_kesehatan->list_karyawan()->result();
		$data['list_lk']=$this->m_riwayat_kesehatan->list_karyawan_index($nik)->row_array();
		$data['list_penyakit']=$this->m_riwayat_kesehatan->list_penyakit()->result();
		$data['list_riwayat_kesehatan']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->result();
		$data['list_rk']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->row_array();
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        $this->template->display('trans/riwayat_kesehatan/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_riwayat_kesehatan->list_karyawan()->result();
		$this->template->display('trans/riwayat_kesehatan/v_list_karyawan',$data);
	}
	
	function add_riwayat_kesehatan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$kdpenyakit=$this->input->post('kdpenyakit');
		$periode=$this->input->post('periode');
		$keterangan=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'nik'=>$nik,
			'kdpenyakit'=>strtoupper($kdpenyakit),
			'periode'=>$periode,
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_berlaku;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik,$kdpenyakit)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_trx.riwayat_kesehatan',$info);
		redirect("trans/riwayat_kesehatan/index/$nik/rep_succes");
		//echo $inputby;
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/riwayat_kesehatan/index/$nik");
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
			$data['list_keluarga']=$this->m_riwayat_kesehatan->list_keluarga()->result();
			$data['list_negara']=$this->m_riwayat_kesehatan->list_negara()->result();
			$data['list_prov']=$this->m_riwayat_kesehatan->list_prov()->result();
			$data['list_kotakab']=$this->m_riwayat_kesehatan->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_riwayat_kesehatan->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/riwayat_kesehatan/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/riwayat_kesehatan/index/$nik");
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
			$data['list_keluarga']=$this->m_riwayat_kesehatan->list_keluarga()->result();
			$data['list_negara']=$this->m_riwayat_kesehatan->list_negara()->result();
			$data['list_prov']=$this->m_riwayat_kesehatan->list_prov()->result();
			$data['list_kotakab']=$this->m_riwayat_kesehatan->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_riwayat_kesehatan->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/riwayat_kesehatan/v_detail',$data);
		}	
	}
	function edit_riwayat_kesehatan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$kdpenyakit=$this->input->post('kdpenyakit');
		$periode=$this->input->post('periode');
		$keterangan=$this->input->post('keterangan');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		$info=array(
			'kdpenyakit'=>strtoupper($kdpenyakit),
			'periode'=>strtoupper($periode),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('no_urut',$no_urut);
			//$this->db->where('nik',$nik);
			//$this->db->where('kdpenyakit',$kdpenyakit);
			$this->db->update('sc_trx.riwayat_kesehatan',$info);
			redirect("trans/riwayat_kesehatan/index/$nik/rep_succes");
		
		//echo $inputby;
	}
	
	function hps_riwayat_kesehatan($nik,$no_urut){
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_trx.riwayat_kesehatan');
		redirect("trans/riwayat_kesehatan/index/$nik/del_succes");
	}
	
}	