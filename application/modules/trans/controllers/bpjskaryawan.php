<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Bpjskaryawan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_bpjs','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.T.A.2'; $versirelease='I.T.A.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		$nama=$this->session->userdata('nik');
		$data['title']="List Master BPJS Karyawan";
		
		if($this->uri->segment(5)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$nik=$this->fiky_encryption->dekript($this->uri->segment(4));
		$data['nik']=$nik;
		$data['akses_list']=$this->m_akses->list_aksespermenu($nama,$kodemenu)->row_array();
		$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();	
		$data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
		$data['list_bpjskaryawan']=$this->m_bpjs->list_bpjs_karyawan($nik)->result();
		$data['list_faskes']=$this->m_bpjs->list_faskes()->result();
		$data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
		$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
		$data['list_lk']=$this->m_bpjs->list_karyawan_index($nik)->row_array();
        $this->template->display('trans/bpjskaryawan/v_list',$data);
    }
	
	function karyawan(){
		//$data['title']="List Master BPJS Karyawan";
		$data['title']="List Karyawan";
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.T.A.2'; $versirelease='I.T.A.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
		$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
		$this->template->display('trans/bpjskaryawan/v_list_karyawan',$data);
	}
	
	function add_bpjs(){
		$id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
		//$nmbpjs=$this->input->post('nmbpjs');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$kode_bpjs1=explode('|',);
		$kode_bpjs=strtoupper($this->input->post('kode_bpjs'));
		//$kodekomponen1=explode('|',;
		$kodekomponen=strtoupper($this->input->post('kodekomponen'));
		//$kodefaskes1=explode
		$kodefaskes=strtoupper($this->input->post('kodefaskes'));
		//$kodefaskes3=explode('|',;
		$kodefaskes2=strtoupper($this->input->post('kodefaskes2'));
		$nik=$this->input->post('nik');
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
		$cek=$this->m_bpjs->q_cek_bpjs($kode_bpjs,$nik,$kodekomponen,$id_bpjs)->num_rows();
		$enc_nik=$this->fiky_encryption->enkript($nik);
		if ($cek>0){
			redirect("trans/bpjskaryawan/index/$enc_nik/kode_failed");
		} else {
			$this->db->insert('sc_trx.bpjs_karyawan',$info);
			redirect("trans/bpjskaryawan/index/$enc_nik/rep_succes");
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
		//$kode_bpjs1=explode('|',);
		$kode_bpjs=strtoupper($this->input->post('kode_bpjs'));
		//$kodekomponen1=explode('|',;
		$kodekomponen=strtoupper($this->input->post('kodekomponen'));
		//$kodefaskes1=explode
		$kodefaskes=strtoupper($this->input->post('kodefaskes'));
		//$kodefaskes3=explode('|',;
		$kodefaskes2=strtoupper($this->input->post('kodefaskes2'));
		$nik=$this->input->post('nik');
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
        $enc_nik=$this->fiky_encryption->enkript($nik);
			$this->db->where('nik',$nik);
			$this->db->where('kode_bpjs',$kode_bpjs);
			$this->db->where('kodekomponen',$kodekomponen);
			$this->db->where('id_bpjs',$id_bpjs);
			$this->db->update('sc_trx.bpjs_karyawan',$info);
			redirect("trans/bpjskaryawan/index/$enc_nik/rep_succes");

		//echo $inputby;
	}
	
	function hps_bpjs($_nik,$_id_bpjs){
        $nik = $this->fiky_encryption->dekript($_nik);
        $id_bpjs = $this->fiky_encryption->dekript($_id_bpjs);
        $enc_nik=$this->fiky_encryption->enkript($nik);
		$this->db->where('nik',$nik);
		$this->db->where('id_bpjs',$id_bpjs);
		$this->db->delete('sc_trx.bpjs_karyawan');
		redirect("trans/bpjskaryawan/index/$enc_nik/del_succes");
	}
	
}	