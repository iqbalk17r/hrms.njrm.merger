<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Kenaikan_grade extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_kenaikan_grade','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Kenaikan Grade";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$nik=$this->uri->segment(4);
		$kmenu='I.T.A.6';
		$data['nik']=$nik;
		$data['list_karyawan']=$this->m_kenaikan_grade->list_karyawan()->result();
		$data['list_grade']=$this->m_kenaikan_grade->list_grade()->result();
		$data['list_group_pg']=$this->m_kenaikan_grade->list_group_pg()->result();
		$data['list_lk']=$this->m_kenaikan_grade->list_karyawan_index($nik)->row_array();
		$data['list_kenaikan_grade']=$this->m_kenaikan_grade->q_kenaikan_grade($nik)->result();
		$data['list_rk']=$this->m_kenaikan_grade->q_kenaikan_grade($nik)->row_array();
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		
        $this->template->display('trans/kenaikan_grade/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_kenaikan_grade->list_karyawan()->result();
		$this->template->display('trans/kenaikan_grade/v_list_karyawan',$data);
	}
	
	function add_kenaikan_grade(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		//$nodok=$this->input->post('nodok');
		$kdgrade=$this->input->post('kdgrade');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$no_sk=$this->input->post('no_sk');
		$tgl_sk1=$this->input->post('tgl_sk');
		if ($tgl_sk1==''){
			$tgl_sk=NULL;
		} else {
			$tgl_sk=$tgl_sk1;
		}
		$gaji_pokok1=$this->input->post('gaji_pokok');
		if ($gaji_pokok1==''){
			$gaji_pokok=NULL;
		} else {
			$gaji_pokok=$gaji_pokok1;
		}
		$gaji_bpjs1=$this->input->post('gaji_bpjs');
		if ($gaji_bpjs1==NULL){
			$gaji_bpjs=NULL;
		} else {
			$gaji_bpjs=$gaji_bpjs1;
		}
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $gaji_bpjs;
		$info=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'kdgrade'=>strtoupper($kdgrade),
			'kdgroup_pg'=>strtoupper($kdgroup_pg),
			'gaji_pokok'=>$gaji_pokok,
			'gaji_bpjs'=>$gaji_bpjs,
			'no_sk'=>strtoupper($no_sk),
			'tgl_sk'=>$tgl_sk,
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_berlaku;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_kenaikan_grade->q_kenaikan_grade($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_tmp.kenaikan_grade',$info);
		redirect("trans/kenaikan_grade/index/$nik/rep_succes");
		
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/kenaikan_grade/index/$nik");
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
			$data['list_keluarga']=$this->m_kenaikan_grade->list_keluarga()->result();
			$data['list_negara']=$this->m_kenaikan_grade->list_negara()->result();
			$data['list_prov']=$this->m_kenaikan_grade->list_prov()->result();
			$data['list_kotakab']=$this->m_kenaikan_grade->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_kenaikan_grade->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_kenaikan_grade->q_kenaikan_grade_edit($nik,$nodok)->row_array();
			$this->template->display('trans/kenaikan_grade/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/kenaikan_grade/index/$nik");
		} else {
			$data['title']='DETAIL DATA RIWAYAT PENGALAMAN KERJA';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$nik=$this->uri->segment(4);
			$data['nik']=$nik;
			
			$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_rk']=$this->m_kenaikan_grade->q_kenaikan_grade_edit($nik,$nodok)->row_array();
			$this->template->display('trans/kenaikan_grade/v_detail',$data);
		}	
	}
	function edit_kenaikan_grade(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kdgrade=$this->input->post('kdgrade');
		$tgl_sk1=$this->input->post('tgl_sk');
		if ($tgl_sk1==''){
			$tgl_sk=NULL;
		} else {
			$tgl_sk=$tgl_sk1;
		}
		$tahun_keluar=$this->input->post('tahun_keluar');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$gaji_pokok1=$this->input->post('gaji_pokok');
		if ($gaji_pokok1==''){
			$gaji_pokok=NULL;
		} else {
			$gaji_pokok=$gaji_pokok1;
		}
		$gaji_bpjs1=$this->input->post('gaji_bpjs');
		if ($gaji_bpjs1==''){
			$gaji_bpjs=NULL;
		} else {
			$gaji_bpjs=$gaji_bpjs1;
		}
		$no_sk=$this->input->post('no_sk');
		$keterangan=$this->input->post('keterangan');
		$inputby=$this->input->post('inputby');
		//$no_urut=$this->input->post('no_urut');
		
		$info=array(
			//'nodok'=>strtoupper($nodok),
			'kdgrade'=>strtoupper($kdgrade),
			'kdgroup_pg'=>strtoupper($kdgroup_pg),
			'gaji_pokok'=>$gaji_pokok,
			'gaji_bpjs'=>$gaji_bpjs,
			'no_sk'=>strtoupper($no_sk),
			'tgl_sk'=>$tgl_sk,
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('nodok',$nodok);
			//$this->db->where('nik',$nik);
			//$this->db->where('kdpengalaman',$kdpengalaman);
			$this->db->update('sc_trx.kenaikan_grade',$info);
			redirect("trans/kenaikan_grade/index/$nik/edit_succes");
		
		//echo $inputby;
	}
	
	function hps_kenaikan_grade($nik,$nodok){
		$this->db->where('nodok',$nodok);
		$this->db->delete('sc_trx.kenaikan_grade');
		redirect("trans/kenaikan_grade/index/$nik/del_succes");
	}
	
	function approval($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kdgrade=$this->input->post('kdgrade');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$gaji_pokok=$this->input->post('gaji_pokok');
		$gaji_bpjs=$this->input->post('gaji_bpjs');
		//echo $nik;
		//echo $nodok;
		$this->m_kenaikan_grade->tr_app($nodok);
		//$this->db->query("update sc_mst.karyawan set grade_golongan='$kdgrade',grouppenggajian='$kdgroup_pg',gajipokok='$gaji_pokok',gajibpjs='$gaji_bpjs' where nik='$nik'");	
		redirect("trans/kenaikan_grade/index/$nik/rep_succes");
	}
	
	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		//echo $nik;
		//echo $nodok;
		$this->m_kenaikan_grade->tr_cancel($nodok);	
		redirect("trans/kenaikan_grade/index/$nik/rep_succes");
	}
}	