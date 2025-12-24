<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Riwayat_pendidikan_nf extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_riwayat_pendidikan_nf','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Riwayat Pendidikan Non Formal";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Pendidikan Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$kmenu='I.T.A.8';
		$nik=$this->uri->segment(4);
		$data['nik']=$nik;
		$data['list_karyawan']=$this->m_riwayat_pendidikan_nf->list_karyawan()->result();
		$data['list_lk']=$this->m_riwayat_pendidikan_nf->list_karyawan_index($nik)->row_array();
		$data['list_keahlian']=$this->m_riwayat_pendidikan_nf->list_keahlian()->result();
		$data['list_riwayat_pendidikan_nf']=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf($nik)->result();
		$data['list_rk']=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf($nik)->row_array();
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        $this->template->display('trans/riwayat_pendidikan_nf/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_riwayat_pendidikan_nf->list_karyawan()->result();
		$this->template->display('trans/riwayat_pendidikan_nf/v_list_karyawan',$data);
	}
	
	function add_riwayat_pendidikan_nf(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$kdkeahlian=$this->input->post('kdkeahlian');
		$nmkursus=$this->input->post('nmkursus');
		$nminstitusi=$this->input->post('nminstitusi');
		$tahun_masuk=str_replace("_","",$this->input->post('tahun_masuk'));
		$tahun_keluar=str_replace("_","",$this->input->post('tahun_keluar'));
		$keterangan=$this->input->post('keterangan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'nik'=>$nik,
			'kdkeahlian'=>$kdkeahlian,
			'nmkursus'=>strtoupper($nmkursus),
			'nminstitusi'=>strtoupper($nminstitusi),
			'tahun_keluar'=>strtoupper($tahun_keluar),
			'tahun_masuk'=>strtoupper($tahun_masuk),
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_berlaku;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf($nik,$kdkeahlian)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_trx.riwayat_pendidikan_nf',$info);
		redirect("trans/riwayat_pendidikan_nf/index/$nik/rep_succes");
		//echo $inputby;
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/riwayat_pendidikan_nf/index/$nik");
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
			$data['list_keluarga']=$this->m_riwayat_pendidikan_nf->list_keluarga()->result();
			$data['list_negara']=$this->m_riwayat_pendidikan_nf->list_negara()->result();
			$data['list_prov']=$this->m_riwayat_pendidikan_nf->list_prov()->result();
			$data['list_kotakab']=$this->m_riwayat_pendidikan_nf->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_riwayat_pendidikan_nf->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/riwayat_pendidikan_nf/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/riwayat_pendidikan_nf/index/$nik");
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
			$data['list_keluarga']=$this->m_riwayat_pendidikan_nf->list_keluarga()->result();
			$data['list_negara']=$this->m_riwayat_pendidikan_nf->list_negara()->result();
			$data['list_prov']=$this->m_riwayat_pendidikan_nf->list_prov()->result();
			$data['list_kotakab']=$this->m_riwayat_pendidikan_nf->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_riwayat_pendidikan_nf->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/riwayat_pendidikan_nf/v_detail',$data);
		}	
	}
	function edit_riwayat_pendidikan_nf(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$kdkeahlian=$this->input->post('kdkeahlian');
		$nmkursus=$this->input->post('nmkursus');
		$nminstitusi=$this->input->post('nminstitusi');
		$tahun_masuk=str_replace("_","",$this->input->post('tahun_masuk'));
		$tahun_keluar=str_replace("_","",$this->input->post('tahun_keluar'));
		$keterangan=$this->input->post('keterangan');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		$info=array(
			'nmkursus'=>strtoupper($nmkursus),
			'kdkeahlian'=>strtoupper($kdkeahlian),
			'nminstitusi'=>strtoupper($nminstitusi),
			'tahun_keluar'=>strtoupper($tahun_keluar),
			'tahun_masuk'=>strtoupper($tahun_masuk),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('no_urut',$no_urut);
			//$this->db->where('nik',$nik);
			//$this->db->where('kdkeahlian',$kdkeahlian);
			$this->db->update('sc_trx.riwayat_pendidikan_nf',$info);
			redirect("trans/riwayat_pendidikan_nf/index/$nik/rep_succes");
		
		//echo $inputby;
	}
	
	function hps_riwayat_pendidikan_nf($nik,$no_urut){
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_trx.riwayat_pendidikan_nf');
		redirect("trans/riwayat_pendidikan_nf/index/$nik/del_succes");
	}
	
}	