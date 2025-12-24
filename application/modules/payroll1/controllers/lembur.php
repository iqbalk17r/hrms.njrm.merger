<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Lembur extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_lembur');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Upah Borong Progresif Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$nik=$this->uri->segment(4);
		//$data['nik']=$nik;
		
		//$data['list_lk']=$this->m_lembur->list_karyawan_index($nik)->row_array();
		//$data['list_ijin_khusus']=$this->m_lembur->list_ijin_khusus()->result();
		//$data['list_lembur']=$this->m_lembur->q_lembur_mst()->result();
		//$data['total_upah']=$this->m_lembur->total_upah($nodok)->result();
		//$data['list_lembur_dtl']=$this->m_lembur->q_lembur_dtl($nodok)->result();
		$data['list_karyawan']=$this->m_lembur->list_karyawan()->result();
		//$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		//$data['list_lembur']=$this->m_lembur->list_lembur()->result();
		//$data['list_rk']=$this->m_lembur->q_lembur($nik)->row_array();
		
        $this->template->display('trans/lembur/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		//echo "test";
		
		$data['title']="List Karyawan Payroll";
		$data['list_karyawan']=$this->m_lembur->list_karyawan()->result();
		//$data['list_ijin_khusus']=$this->m_lembur->list_ijin_khusus()->result();
		//$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		//$data['list_lk2']=$this->m_lembur->list_karyawan_index($nik)->row_array();
		$data['list_lk']=$this->m_lembur->list_karyawan_index()->result();
		$this->template->display('payroll/lembur/v_list_karyawan',$data);
		
	}
	
	function add_lembur(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		//$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		/*$kdijin_khusus1=$this->input->post('kdijin_khusus');
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		*/
		$tgl_kerja1=$this->input->post('tgl_kerja');
		if ($tgl_kerja1==''){
			$tgl_kerja=NULL;
		} else {
			$tgl_kerja=$tgl_kerja1;
		}
		
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		//$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		$periode=str_replace("_","",$this->input->post('periode'));
		//$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$alamat=$this->input->post('alamat');
		$pelimpahan=$this->input->post('pelimpahan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $tpcuti;
		$info=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'kddept'=>strtoupper($kddept),
			'kdsubdept'=>strtoupper($kdsubdept),
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			'nmatasan'=>$atasan,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_dok'=>$tgl_dok,
			'periode'=>$periode,
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $kdlembur;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_lembur->q_lembur($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_tmp.lembur_mst',$info);
		redirect("payroll/lembur/detail_mst/$nik/$nodok/");
		
	}
	
	
	function add_lembur_dtl(){
		$nodok=$this->session->userdata('nik');
		$no_urut1=$this->m_lembur->beri_no_urut($nodok)->row_array();
		$no_urut=$no_urut1['nomor']+1;
		//$data['no_urut']=$this->m_lembur->beri_no_urut($nodok)->result();
		//$data['no_urut']=$no_urut;
		//$no_urut1=$no_urut+1;
		$nik=$this->input->post('nik');
		//$no=1;
		//$nodok=$this->session->userdata('nik');
		//$nodok=$this->input->post('nodok');
		$total_upah1=$this->input->post('total_upah');
		if ($total_upah1==''){
			$total_upah=0;
		} else {
			$total_upah=$total_upah1;
		}
		$kdborong=$this->input->post('kdborong');
		$kdsub_borong=$this->input->post('kdsub_borong');
		$metrix=$this->input->post('metrix');
		$satuan=$this->input->post('satuan');
		$tarif_satuan=$this->input->post('tarif_satuan');
		$total_target=$this->input->post('total_target');
		$lembur=$this->input->post('lembur');
		$catatan=$this->input->post('catatan');
		$pencapaian=$this->input->post('pencapaian');
		
		
		//echo 'aaa',$no_urut1;
		//echo 'bbb',$no_urut;
		//echo $no_urut1;
		//echo $tpcuti;
		$info=array(
			'nik'=>$nik,
			'nodok'=>$nodok,
			'kdborong'=>strtoupper($kdborong),
			'kdsub_borong'=>strtoupper($kdsub_borong),
			'metrix'=>$metrix,
			'satuan'=>$satuan,
			'tarif_satuan'=>$tarif_satuan,
			'total_target'=>$total_target,
			'pencapaian'=>$pencapaian,
			'lembur'=>$lembur,
			'catatan'=>strtoupper($catatan),
			'no_urut'=>$no_urut,
		);
		//echo $kdlembur;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_lembur->q_lembur($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_tmp.lembur_dtl',$info);
		redirect("payroll/lembur/detail_mst/$nik");
		
	}
	
	function edit_lembur_dtl(){
		
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kdborong=$this->input->post('kdborong');
		$kdsub_borong=$this->input->post('kdsub_borong');
		$metrix=$this->input->post('metrix');
		$satuan=$this->input->post('satuan');
		$tarif_satuan=$this->input->post('tarif_satuan');
		$total_target=$this->input->post('total_target');
		$lembur=$this->input->post('lembur');
		$catatan=$this->input->post('catatan');
		$pencapaian=$this->input->post('pencapaian');
		$no_urut=trim($this->input->post('no_urut'));
		
		
		
		//echo $tpcuti;
		$info=array(
			
			'kdborong'=>strtoupper($kdborong),
			'kdsub_borong'=>strtoupper($kdsub_borong),
			'metrix'=>$metrix,
			'satuan'=>$satuan,
			'tarif_satuan'=>$tarif_satuan,
			'total_target'=>$total_target,
			'pencapaian'=>$pencapaian,
			'lembur'=>$lembur,
			'catatan'=>strtoupper($catatan),
		);
		//echo $kdlembur;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_lembur->q_lembur($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->where('no_urut',$no_urut);
		$this->db->update('sc_trx.lembur_dtl',$info);
		redirect("payroll/lembur/detail/$nik/$nodok/edit_succes");
		
	}
	
	function edit_lembur_dtl_2(){
		
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kdborong=$this->input->post('kdborong');
		$kdsub_borong=$this->input->post('kdsub_borong');
		$metrix=$this->input->post('metrix');
		$satuan=$this->input->post('satuan');
		$tarif_satuan=$this->input->post('tarif_satuan');
		$total_target=$this->input->post('total_target');
		$lembur=$this->input->post('lembur');
		$catatan=$this->input->post('catatan');
		$pencapaian=$this->input->post('pencapaian');
		$no_urut=trim($this->input->post('no_urut'));
		
		
		
		//echo $tpcuti;
		$info=array(
			
			'kdborong'=>strtoupper($kdborong),
			'kdsub_borong'=>strtoupper($kdsub_borong),
			'metrix'=>$metrix,
			'satuan'=>$satuan,
			'tarif_satuan'=>$tarif_satuan,
			'total_target'=>$total_target,
			'pencapaian'=>$pencapaian,
			'lembur'=>$lembur,
			'catatan'=>strtoupper($catatan),
		);
		//echo $kdlembur;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_lembur->q_lembur($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->where('no_urut',$no_urut);
		$this->db->update('sc_tmp.lembur_dtl',$info);
		redirect("payroll/lembur/detail_mst/$nik");
		
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("payroll/lembur/index/$nik");
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
			$data['list_keluarga']=$this->m_lembur->list_keluarga()->result();
			$data['list_negara']=$this->m_lembur->list_negara()->result();
			$data['list_prov']=$this->m_lembur->list_prov()->result();
			$data['list_kotakab']=$this->m_lembur->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_lembur->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_lembur->q_lembur_edit($nik,$nodok)->row_array();
			$this->template->display('trans/lembur/v_edit',$data);
		}	
	}
	
	/*function detail($nodok){
		//echo "test";
		
			
			
		if (empty($nodok)){
			redirect("payroll/lembur/index/");
		} else {
			$data['title']='DETAIL DATA UPAH BORONG PROGRESIF';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			if($this->uri->segment(5)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Ada</div>";
			else if($this->uri->segment(6)=="rep_succes")
				$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
			else if($this->uri->segment(6)=="del_succes")
				$data['message']="<div class='alert alert-success'>Delete Succes</div>";
			else if($this->uri->segment(6)=="app_succes")
				$data['message']="<div class='alert alert-success'>Approve Succes</div>";
			else if($this->uri->segment(6)=="cancel_succes")
				$data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
			else if($this->uri->segment(6)=="edit_succes")
				$data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
			else
				$data['message']='';
			$nodok=$this->uri->segment(5);
			$nik=$this->uri->segment(4);
			$data['nodok']=$nodok;
			$data['nik']=$nik;
			$data['total_upah']=$this->m_lembur->total_upah($nodok)->row_array();
			//$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_lembur']=$this->m_lembur->q_lembur_mst()->result();
			$data['list_borong']=$this->m_lembur->list_borong()->result();
			$data['list_sub_borong']=$this->m_lembur->list_sub_borong()->result();
			$data['list_target_borong']=$this->m_lembur->list_target_borong()->result();
			$data['list_upah_dtl']=$this->m_lembur->q_lembur_dtl($nodok)->result();
			$this->template->display('trans/lembur/v_detail',$data);
		}	
	}*/
	
	function detail_lembur($nik){
		//echo "test";
		//$nodok=$this->session->userdata('nik');
		//echo $nodok;
			
		$data['title']='DETAIL DATA LEMBUR KARYAWAN';			
		/*if (empty($nik)){
			redirect("payroll/lembur/index/");
		} else {
				
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}*/
			if($this->uri->segment(5)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Detail Transaksi Belum Ada</div>";
			else if($this->uri->segment(5)=="rep_succes")
				$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
			else if($this->uri->segment(5)=="del_succes")
				$data['message']="<div class='alert alert-success'>Delete Succes</div>";
			else if($this->uri->segment(5)=="app_succes")
				$data['message']="<div class='alert alert-success'>Approve Succes</div>";
			else if($this->uri->segment(5)=="cancel_succes")
				$data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
			else if($this->uri->segment(5)=="edit_succes")
				$data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
			else
				$data['message']='';
			$nodok=$this->session->userdata('nik');
			$nik=$this->uri->segment(4);
			$data['nodok']=$nodok;
			$data['nik']=$nik;
			//echo $nik;
			
			$data['list_karyawan']=$this->m_lembur->list_karyawan_detail($nik)->row_array();
			//$data['total_upah']=$this->m_lembur->total_upah_mst($nodok)->row_array();
			//$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_lembur']=$this->m_lembur->q_lembur_mst_detail($nik)->result();
			//$data['list_borong']=$this->m_lembur->list_borong()->result();
			//$data['list_sub_borong']=$this->m_lembur->list_sub_borong()->result();
			//$data['list_target_borong']=$this->m_lembur->list_target_borong()->result();
			//$data['list_upah_dtl']=$this->m_lembur->q_lembur_dtl_2($nodok)->result();
			
			$this->template->display('payroll/lembur/v_detail',$data);
		//}
	}
	
	function edit_lembur(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdijin_khusus1=$this->input->post('kdijin_khusus');
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		$tgl_awal1=$this->input->post('tgl_awal');
		if ($tgl_awal1==''){
			$tgl_awal=NULL;
		} else {
			$tgl_awal=$tgl_awal1;
		}
		$tgl_selesai1=$this->input->post('tgl_selesai');
		if ($tgl_selesai1==''){
			$tgl_selesai=NULL;
		} else {
			$tgl_selesai=$tgl_selesai1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		//$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$alamat=$this->input->post('alamat');
		$pelimpahan=$this->input->post('pelimpahan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//$no_urut=$this->input->post('no_urut');
		
		$info=array(
			//'nodok'=>strtoupper($nodok),
			
			'jumlah_cuti'=>$jumlah_cuti,
			'kdijin_khusus'=>$kdijin_khusus,
			'tpcuti'=>strtoupper($tpcuti),
			'tgl_mulai'=>$tgl_awal,
			'tgl_selesai'=>$tgl_selesai,
			'pelimpahan'=>$pelimpahan,
			'alamat'=>strtoupper($pelimpahan),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			//echo $tgl_selesai;
			$this->db->where('nodok',$nodok);
			//$this->db->where('nik',$nik);
			//$this->db->where('kdpengalaman',$kdpengalaman);
			$this->db->update('sc_trx.lembur',$info);
			redirect("payroll/lembur/index/edit_succes");
		
		//echo $inputby;
	}
	
	function hps_lembur_dtl($no_urut){
		//$nodok=$this->uri->segment(5);
		$nik=$this->uri->segment(5);
		//$no_urut=$this->uri->segment(6);
		//$data['nodok']=$nodok;
		//$data['nik']=$nik;
		//$this->db->where('no_urut',$no_urut);
		//echo $nik;
		$this->db->query("delete from sc_tmp.lembur_dtl where no_urut='$no_urut'");
		redirect("payroll/lembur/detail_mst/$nik/");
	}
	
	
	function hps_lembur($nodok){
		//$this->db->where('nodok',$nodok);
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		if ($cek>0) {
			redirect("payroll/lembur/index/kode_failed");
		} else {
		$this->db->query("update sc_trx.lembur_mst set status='D' where nodok='$nodok'");
		redirect("payroll/lembur/index/del_succes");
		}
	}
	
	function approval($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$inputby=$this->input->post('inputby');
		$tgl_input=$this->input->post('tgl');
		
		//echo $tgl_input;
		//echo $nodok;
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		if ($cek>0 or $cek2>0) {
			redirect("payroll/lembur/index/kode_failed");
		} else {
		$this->m_lembur->tr_app($nodok,$inputby,$tgl_input);	
		redirect("payroll/lembur/index/app_succes");
		}
	}
		
	
	function final_mst($nik,$nodok){
		$nik=$this->uri->segment(5);
		$nodok=trim($this->session->userdata('nik'));
		$cek=$this->m_lembur->cek_detail($nodok)->num_rows();
		if ($cek==0){
			redirect("payroll/lembur/detail_mst/$nik/kode_failed");
		} else {
			$this->db->query("update sc_tmp.lembur_mst set status='F' where nodok='$nodok'");	
			redirect("payroll/lembur/index/app_succes");
		}
		
	}
	
	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$inputby=$this->input->post('inputby');
		$tgl_input=$this->input->post('tgl');
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		if ($cek>0 or $cek2>0) {
			redirect("payroll/lembur/index/kode_failed");
		} else {
		$this->m_lembur->tr_cancel($nodok,$inputby,$tgl_input);	
		redirect("payroll/lembur/index/cancel_succes");
		}
		
	}
	
	public function ajax_list()
	{
		$list = $this->m_lembur->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->nik;		
			$row[] = $person->nmlengkap;		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-success" href="'.site_url('trans/karyawan/detail').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
					<a class="btn btn-sm btn-success" href="'.site_url('trans/mutprom/index').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Mutasi</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->nik)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_karyawan->count_all(),
						"recordsFiltered" => $this->m_karyawan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	

}	