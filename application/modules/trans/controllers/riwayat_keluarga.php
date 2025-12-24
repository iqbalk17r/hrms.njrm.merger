<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Riwayat_keluarga extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_bpjs','m_riwayat_keluarga','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Riwayat Keluarga";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Keluarga Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$nik=$this->uri->segment(4);
		$kmenu='I.T.A.3';
		$nama=$this->session->userdata('nik');
		$data['nik']=$nik;
		$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();	
		$data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
		$data['list_bpjskaryawan']=$this->m_bpjs->q_bpjs_karyawan()->result();
		$data['list_faskes']=$this->m_bpjs->list_faskes()->result();
		$data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
		$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
		$data['list_lk']=$this->m_riwayat_keluarga->list_karyawan_index($nik)->row_array();
		$data['list_keluarga']=$this->m_riwayat_keluarga->list_keluarga()->result();
		$data['list_negara']=$this->m_riwayat_keluarga->list_negara()->result();
		$data['list_prov']=$this->m_riwayat_keluarga->list_prov()->result();
		$data['list_kotakab']=$this->m_riwayat_keluarga->list_kotakab()->result();
		$data['list_jenjang_pendidikan']=$this->m_riwayat_keluarga->list_jenjang_pendidikan()->result();
		$data['list_riwayat_keluarga']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->result();
		$data['list_rk']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->row_array();
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		
        $this->template->display('trans/riwayat_keluarga/v_list',$data);
    }
	function karyawan(){
		$data['title']="List Master Riwayat Keluarga";
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
		$this->template->display('trans/riwayat_keluarga/v_list_karyawan',$data);
	}
	
	function add_riwayat_keluarga(){
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		$kdkeluarga=$this->input->post('kdkeluarga');
		$nama=$this->input->post('nama');
		$kelamin=$this->input->post('kelamin');
		$kodenegara=$this->input->post('kodenegara');
		$kodeprov=$this->input->post('kodeprov');
		$kodekotakab=$this->input->post('kodekotakab');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$kdjenjang_pendidikan=$this->input->post('kdjenjang_pendidikan');
		$pekerjaan=$this->input->post('pekerjaan');
		$status_hidup=$this->input->post('status_hidup');
		$status_tanggungan=$this->input->post('status_tanggungan');
		$npwp_tgl1=$this->input->post('npwp_tgl');
		if ($npwp_tgl1==''){
			$npwp_tgl=NULL;
		} else {
			$npwp_tgl=$npwp_tgl1;
		}
		$id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
		$no_npwp1=str_replace("_","",$this->input->post('no_npwp'));
		if ($no_npwp1==''){
			$no_npwp=NULL;
		} else {
			$no_npwp=$no_npwp1;
		}
		$kode_bpjs1=explode('|',$this->input->post('kode_bpjs'));
		$kode_bpjs=$kode_bpjs1[0];
		$kodekomponen1=explode('|',$this->input->post('kodekomponen'));
		$kodekomponen=$kodekomponen1[0];
		$kodefaskes1=explode('|',$this->input->post('kodefaskes'));
		$kodefaskes=$kodefaskes1[0];
		$kodefaskes3=explode('|',$this->input->post('kodefaskes2'));
		$kodefaskes2=$kodefaskes3[0];
		$kelas=$this->input->post('kelas');
		$keterangan=$this->input->post('keterangan');
		$tgl_berlaku1=$this->input->post('tgl_berlaku');
		if ($tgl_berlaku1==''){
			$tgl_berlaku=NULL;
		} else {
			$tgl_berlaku=$tgl_berlaku1;
		}
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $tgl_berlaku;
		$info=array(
			'nik'=>$nik,
			'kdkeluarga'=>$kdkeluarga,
			'nama'=>strtoupper($nama),
			'kelamin'=>$kelamin,
			'kodenegara'=>$kodenegara,
			'kodeprov'=>$kodeprov,
			'kodekotakab'=>$kodekotakab,
			'tgl_lahir'=>$tgl_lahir,
			'kdjenjang_pendidikan'=>$kdjenjang_pendidikan,
			'pekerjaan'=>strtoupper($pekerjaan),
			'status_hidup'=>strtoupper($status_hidup),
			'status_tanggungan'=>strtoupper($status_tanggungan),
			'no_npwp'=>$no_npwp,
			'npwp_tgl'=>$npwp_tgl,
			'id_bpjs'=>$id_bpjs,
			'kode_bpjs'=>$kode_bpjs,
			'kodekomponen'=>$kodekomponen,
			'kodefaskes'=>$kodefaskes,
			'kodefaskes2'=>$kodefaskes2,	
			'kelas'=>strtoupper($kelas),
			'keterangan'=>strtoupper($keterangan),
			'tgl_berlaku'=>$tgl_berlaku,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $tgl_berlaku;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_bpjs->q_cek_bpjs($id_bpjs)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_trx.riwayat_keluarga',$info);
		redirect("trans/riwayat_keluarga/index/$nik/rep_succes");
		//echo $inputby;
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/riwayat_keluarga/index/$nik");
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
			$data['list_keluarga']=$this->m_riwayat_keluarga->list_keluarga()->result();
			$data['list_negara']=$this->m_riwayat_keluarga->list_negara()->result();
			$data['list_prov']=$this->m_riwayat_keluarga->list_prov()->result();
			$data['list_kotakab']=$this->m_riwayat_keluarga->list_kotakab()->result();
			$data['list_jenjang_pendidikan']=$this->m_riwayat_keluarga->list_jenjang_pendidikan()->result();
			$data['list_rk']=$this->m_riwayat_keluarga->q_riwayat_keluarga_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/riwayat_keluarga/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/riwayat_keluarga/index/$nik");
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
			$data['list_keluarga']=$this->m_riwayat_keluarga->list_keluarga()->result();
			$data['list_negara']=$this->m_riwayat_keluarga->list_negara()->result();
			$data['list_prov']=$this->m_riwayat_keluarga->list_prov()->result();
			$data['list_kotakab']=$this->m_riwayat_keluarga->list_kotakab()->result();
			$data['list_jenjang_pendidikan']=$this->m_riwayat_keluarga->list_jenjang_pendidikan()->result();
			$data['list_rk']=$this->m_riwayat_keluarga->q_riwayat_keluarga_edit($nik,$no_urut)->row_array();
			$this->template->display('trans/riwayat_keluarga/v_detail',$data);
		}	
	}
	function edit_riwayat_keluarga(){
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		$kdkeluarga=$this->input->post('kdkeluarga');
		$nama=$this->input->post('nama');
		$kelamin=$this->input->post('kelamin');
		$kodenegara=$this->input->post('kodenegara');
		$kodeprov=$this->input->post('kodeprov');
		$kodekotakab=$this->input->post('kodekotakab');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$kdjenjang_pendidikan=$this->input->post('kdjenjang_pendidikan');
		$pekerjaan=$this->input->post('pekerjaan');
		$status_hidup=$this->input->post('status_hidup');
		$status_tanggungan=$this->input->post('status_tanggungan');
		$npwp_tgl1=$this->input->post('npwp_tgl');
		if ($npwp_tgl1==''){
			$npwp_tgl=NULL;
		} else {
			$npwp_tgl=$npwp_tgl1;
		}
		$id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
		$no_npwp1=str_replace("_","",$this->input->post('no_npwp'));
		if ($no_npwp1==''){
			$no_npwp=NULL;
		} else {
			$no_npwp=$no_npwp1;
		}
		$kode_bpjs1=explode('|',$this->input->post('kode_bpjs'));
		$kode_bpjs=$kode_bpjs1[0];
		$kodekomponen1=explode('|',$this->input->post('kodekomponen'));
		$kodekomponen=$kodekomponen1[0];
		$kodefaskes1=explode('|',$this->input->post('kodefaskes'));
		$kodefaskes=$kodefaskes1[0];
		$kodefaskes3=explode('|',$this->input->post('kodefaskes2'));
		$kodefaskes2=$kodefaskes3[0];
		$kelas=$this->input->post('kelas');
		$keterangan=$this->input->post('keterangan');
		$tgl_berlaku1=$this->input->post('tgl_berlaku');
		if ($tgl_berlaku1==''){
			$tgl_berlaku=NULL;
		} else {
			$tgl_berlaku=$tgl_berlaku1;
		}
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		$info=array(
			'nik'=>$nik,
			'kdkeluarga'=>$kdkeluarga,
			'nama'=>strtoupper($nama),
			'kelamin'=>$kelamin,
			'kodenegara'=>$kodenegara,
			'kodeprov'=>$kodeprov,
			'kodekotakab'=>$kodekotakab,
			'tgl_lahir'=>$tgl_lahir,
			'kdjenjang_pendidikan'=>$kdjenjang_pendidikan,
			'pekerjaan'=>strtoupper($pekerjaan),
			'status_hidup'=>strtoupper($status_hidup),
			'status_tanggungan'=>strtoupper($status_tanggungan),
			'no_npwp'=>$no_npwp,
			'npwp_tgl'=>$npwp_tgl,
			'id_bpjs'=>$id_bpjs,
			'kode_bpjs'=>$kode_bpjs,
			'kodekomponen'=>$kodekomponen,
			'kodefaskes'=>$kodefaskes,
			'kodefaskes2'=>$kodefaskes2,	
			'kelas'=>strtoupper($kelas),
			'keterangan'=>strtoupper($keterangan),
			'tgl_berlaku'=>$tgl_berlaku,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('no_urut',$no_urut);
			$this->db->update('sc_trx.riwayat_keluarga',$info);
			redirect("trans/riwayat_keluarga/index/$nik/rep_succes");
		//echo $tgl_berlaku;
		//echo $inputby;
	}
	
	function hps_riwayat_keluarga($nik,$no_urut){
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_trx.riwayat_keluarga');
		redirect("trans/riwayat_keluarga/index/$nik/del_succes");
	}
	
}	