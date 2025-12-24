<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Ceklembur extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_ceklembur','m_generate'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
      
		//echo 'test';
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
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
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['title']='Generate Lembur';
		$this->template->display('payroll/ceklembur/v_utama',$data);	
	
		
    }
	
	function shift(){
	
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
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
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_ceklembur->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['title']='Generate Tunjangan Shift';
		$this->template->display('payroll/ceklembur/v_utama_shift',$data);	
	
	
	}
	
	function upah_borong(){
	
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukes Disimpan, Silahkan Generate Ulang</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="tgl_failed")
            $data['message']="<div class='alert alert-warning'>Anda Belum Memproses Tanggal Sebelum Ini</div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['title']='Generate Upah Borong';
		$this->template->display('payroll/ceklembur/v_utama_borong',$data);	
	
	
	}
	
	function absen(){
	
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="tgl_failed")
            $data['message']="<div class='alert alert-warning'>Anda Belum Memproses Tanggal Sebelum Ini</div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['title']='Generate Potongan Absen';
		$this->template->display('payroll/ceklembur/v_utama_absen',$data);	
	
	
	}
	
	

	function lihat_lembur($tglawal,$tglakhir,$kddept){
		$nodok=$this->session->userdata('nik');
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Nomor $nodok Sukses Diubah</div>";
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
		
		$data['title']="List Lembur Periode $tglawal Hingga $tglakhir";
		$data['list_lembur']=$this->m_ceklembur->list_lembur_nominal($tglawal,$tglakhir,$nodok,$kddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/ceklembur/v_list',$data);
		
	}
	
	function lihat_shift_all($tglawal,$tglakhir,$kddept){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Absensi NIK $nik Sukses Diubah</div>";
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
		
		$nodok=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Periode $tglawal Hingga $tglakhir";
		$data['list_shift']=$this->m_ceklembur->q_shiftall($tglawal,$tglakhir,$kddept)->result();
		$data['list_jamkerja']=$this->m_ceklembur->q_jamkerja()->result();
		//$total_nominal1=$this->m_ceklembur->total_nominal_shift($nodok,$nik)->row_array();
		//$data['total_nominal']=$total_nominal1['total_nominal'];
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/ceklembur/v_list_shiftall',$data);
		
	}
	
	
	function lihat_shift($tglawal,$tglakhir,$kddept,$nik){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Absensi NIK $nik Sukses Diubah</div>";
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
		
		$nodok=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Periode $tglawal Hingga $tglakhir";
		$data['list_shift']=$this->m_ceklembur->q_shift($nodok,$nik)->result();
		$data['list_jamkerja']=$this->m_ceklembur->q_jamkerja()->result();
		$total_nominal1=$this->m_ceklembur->total_nominal_shift($nodok,$nik)->row_array();
		$data['total_nominal']=$total_nominal1['total_nominal'];
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nik']=$nik;
		$data['kddept']=$kddept;
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/ceklembur/v_list_shift',$data);
		
	}
	
	function lihat_borong($tglawal,$tglakhir,$nodok,$kddept){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Nomor $nodok Sukses Diubah</div>";
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
		$nodok=$this->session->userdata('nik');
		$data['title']="List Borong Periode $tglawal Hingga $tglakhir";
		$data['list_borong']=$this->m_ceklembur->q_cek_borong($nodok,$tglawal,$tglakhir,$kddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$this->template->display('payroll/ceklembur/v_list_borong',$data);
		
	}
	
	
	function lihat_borong_detail($tglawal,$tglakhir,$nik,$kddept){
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Nomor $nodok Sukses Diubah</div>";
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
		$nodok=$this->session->userdata('nik');
		$data['title']="List Borong Periode $tglawal Hingga $tglakhir";
		$data['list_borong']=$this->m_ceklembur->q_cek_borong_detail($nodok,$tglawal,$tglakhir,$nik)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['nodok']=$nodok;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		//echo $nik;
		$this->template->display('payroll/ceklembur/v_list_dtl_borong',$data);
		
		
	}
	
	function lihat_absen($tglawal,$tglakhir,$kddept){
		//$nodok=$this->session->userdata('nik');
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Data Absen Sukses Disimpan</div>";
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
		$nodok=$this->session->userdata('nik');
		$data['title']="List Potongan Absen Periode $tglawal Hingga $tglakhir";
		$data['list_absen']=$this->m_ceklembur->q_cek_absen($nodok,$tglawal,$tglakhir,$kddept)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		$data['kddept']=$kddept;
		
		$this->template->display('payroll/ceklembur/v_list_absen',$data);
		
	}
	
	
	
	
	function proses_lembur(){
		
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		if (empty($tanggal)) {
			redirect('payroll/ceklembur/index');
		}
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		
		$this->delete_tmp_lembur($tglawal,$tglakhir,$kddept);
		
		$datane3=$this->m_ceklembur->q_lembur($tglawal,$tglakhir,$kdgroup_pg,$kddept)->result();
		$cek=$this->m_ceklembur->q_lembur_gt($tglawal,$tglakhir,$kdgroup_pg,$kddept)->num_rows();
		/*if ($cek>0){
			redirect ('payroll/ceklembur/index/kode_failed');
		
		}*/
		foreach ($datane3 as $dta3) {
			$nodok=$this->session->userdata('nik');
			$nik=$dta3->nik;
			$nodok_ref=$dta3->nodok;
			$tgl_dok=$dta3->tgl_dok;
			$tplembur=$dta3->kdlembur;
			//$jam_mulai=$dta3->tgl_kerja.' '.$dta3->tgl_jam_mulai;
			//$jam_selesai=$dta3->tgl_kerja.' '.$dta3->tgl_jam_selesai;
			$jam_mulai=$dta3->tgl_jam_mulai;
			$jam_selesai=$dta3->tgl_jam_selesai;
			
			$jumlah_jam=$dta3->durasi;
			$tgl_kerja=$dta3->tgl_kerja;
			$jenis_lembur=$dta3->jenis_lembur;
			if (trim($jenis_lembur)=='D1'){
				$cik=$this->m_ceklembur->cek_absen($nik,$tgl_kerja)->num_rows();
				if ($cik>0){
					$cok=$this->m_ceklembur->q_lembur_trans($nik,$tgl_kerja)->row_array();
					$jam_masuk_absen=$cok['tgl'].' '.$cok['jam_masuk_absen'];
					$jam_pulang_absen=$cok['tgl'].' '.$cok['jam_pulang_absen'];
					if ($cok['jam_masuk_absen']==null or $cok['jam_pulang_absen']==null) {
						$cuk=$this->m_ceklembur->q_lembur_checkinout($nik,$tgl_kerja)->num_rows(); 
						if ($cuk>0) {
							$cak=$this->m_ceklembur->q_lembur_checkinout($nik,$tgl_kerja)->row_array();
							$jam_masuk_absen=$cak['jam_masuk_absen'];
							$jam_pulang_absen=$cak['jam_pulang_absen'];
						} else {
							$jam_masuk_absen=null;
							$jam_pulang_absen=null;
					
						}
						
						
					}    
						
				} else {
					//$jam_masuk_absen=null;
					//$jam_pulang_absen=null;
					$ck=$this->m_ceklembur->q_lembur_checkinout($nik,$tgl_kerja)->num_rows(); 
					if ($ck>0) {
						$ck1=$this->m_ceklembur->q_lembur_checkinout($nik,$tgl_kerja)->row_array(); 
						$jam_masuk_absen=$ck1['jam_masuk_absen'];
						$jam_pulang_absen=$ck1['jam_pulang_absen'];
					} else {
						$jam_masuk_absen=null;
						$jam_pulang_absen=null;
					
					}
				}
			} else {
				$jam_masuk_absen=null;
				$jam_pulang_absen=null;
			
			} 
			//$jam_pulang_absen=$dta3->jam_absen;
			/*if (empty($jam_pulang_absen)) {
				$jam_pulang_absen1=null;
			} else {
				$jam_pulang_absen1=$jam_pulang_absen;
			}*/
			//$jam_masuk_trans=$dta3->jam_masuk_absen;
			//$jam_pulang_trans=$dta3->jam_pulang_absen;
			
			$looping_lembur=array(
			
				'nik'=>$nik,
				'nodok'=>$this->session->userdata('nik'),
				'nodok_ref'=>$nodok_ref,
				'tgl_nodok_ref'=>$tgl_dok,
				'tplembur'=>$tplembur,
				'jam_mulai'=>$jam_mulai,
				'jam_selesai'=>$jam_selesai,
				'jumlah_jam'=>$jumlah_jam,
				'tgl_kerja'=>$tgl_kerja,
				//'tgl_jadwal'=>$tgl_jadwal,
				//'kdjamkerja'=>$kdjamkerja,
				'jam_selesai_absen'=>$jam_pulang_absen,
				'jam_mulai_absen'=>$jam_masuk_absen,
				'status'=>'I',
				'jenis_lembur'=>trim($jenis_lembur),
				
				
			
			);
			//echo $jam_masuk_absen.'<br>';
			//echo $jam_masuk_absen;
			$this->db->insert('sc_tmp.cek_lembur',$looping_lembur);
			$this->db->query("update sc_tmp.cek_lembur set status='P' where nodok_ref='$nodok_ref' and nodok='$nodok'");
		
		}
		$nodok=$this->session->userdata('nik');
		$this->lihat_lembur($tglawal,$tglakhir,$kddept);
	}
	
	
	function proses_shift(){
		
		//$nik=$this->input->post('karyawan');
		$kddept=$this->input->post('kddept');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		if (empty($tanggal)) {
			redirect('payroll/ceklembur/shift');
		}
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$this->delete_tmp_shift($tglawal,$tglakhir,$kddept);
		$q1=$this->m_ceklembur->q_nominal_shift2()->row_array();
		$tj_shift2=$q1['value3'];
		$q2=$this->m_ceklembur->q_nominal_shift3()->row_array();
		$tj_shift3=$q2['value3'];
		$datane=$this->m_ceklembur->q_transready_shift($tglawal,$tglakhir,$kddept)->result();
			
		foreach ($datane as $dta) {
		
			$nik=$dta->nik;
			$jam_masuk=$dta->jam_masuk_absen;
			$jam_pulang=$dta->jam_pulang_absen;
			$tgl_absen=$dta->tgl;
			$shiftke=$dta->shiftke;
			
			
			if ($shiftke=='2'){
				$nominal=$tj_shift2; 
			} else {
				$nominal=$tj_shift3;
			
			}
			
			$looping_shift=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'jam_mulai_absen'=>$jam_masuk,
			'jam_selesai_absen'=>$jam_pulang,
			'tgl_kerja'=>$tgl_absen,
			'nominal'=>$nominal,
			'tpshift'=>$shiftke,
			
			
			);
			
			$this->db->insert('sc_tmp.cek_shift',$looping_shift);
		
			
		
		}
		$this->lihat_shift_all($tglawal,$tglakhir,$kddept);
	}
	
	function proses_borong(){
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$querytglawal=$this->m_generate->q_tglclosingawal()->row_array();
		$tglawal=$querytglawal['value3'];
		$querytglakhir=$this->m_generate->q_tglclosingakhir()->row_array();
		$tglakhir=$querytglakhir['value3'];
			
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tglref=$tglakhir.'-'.$bulan.'-'.$tahun; $tgl=$bulan.$tahun;
			
		} else {
			$tahun=$thn; $bulan=$bln; $tglref=$tglakhir.'-'.$bulan.'-'.$tahun; $tgl=$bulan.$tahun;
			
		}
		switch ($bulan){
			case '01': $bul='Januari'; break;
			case '02': $bul='Februari'; break;
			case '03': $bul='Maret'; break;
			case '04': $bul='April'; break;
			case '05': $bul='Mei'; break;
			case '06': $bul='Juni'; break;
			case '07': $bul='Juli'; break;
			case '08': $bul='Agustus'; break;
			case '09': $bul='September'; break;
			case '10': $bul='Oktober'; break;
			case '11': $bul='November'; break;
			case '12': $bul='Desember'; break;
		}
		
		$tglakhirfix=date('Y-m-d',strtotime($tglref));
		$tgl3=date('Y-m-d',strtotime('-1 month',strtotime($tglref)));	
		$tgl4=date('Y',strtotime($tgl3));
		$tgl5=date('m',strtotime($tgl3));
		$tglawalfix=$tgl4.'-'.$tgl5.'-'.$tglawal;		
		
		/*$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];*/
		
		$tglawal=date('Y-m-d',strtotime($tglawalfix));
		$tglakhir=date('Y-m-d',strtotime($tglakhirfix));
		$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
		$tgle=date('d',strtotime($tglawal));
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		//echo $tgle;
		
		
		$this->delete_tmp_borong($tglawal,$tglakhir,$kdgroup_pg,$kddept);
		$datane4=$this->m_ceklembur->q_upah_borong($tglawal,$tglakhir,$kdgroup_pg,$kddept)->result();
		
		foreach ($datane4 as $dta4){
			$nik=$dta4->nik;
			$nodok_ref=$dta4->nodok;
			$tgl_dok=$dta4->tgl_dok;
			$periode=$dta4->periode;
			$tgl_kerja=$dta4->tgl_kerja;
			$total_upah=$dta4->total_upah;
			
			$looping_upahborong=array(
				'nik'=>$nik,
				'nodok'=>$this->session->userdata('nik'),	
				'nodok_ref'=>$nodok_ref,
				'periode'=>$periode,
				'tgl_kerja'=>$tgl_kerja,
				'tgl_dok'=>$tgl_dok,
				'total_upah'=>$total_upah,
			);
			/*if ($tgle==01) {
				$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);
			} else {
				$cekbelum=$this->m_ceklembur->q_borongbelum($tglbelum,$kdgroup_pg,$kddept)->num_rows();
				if ($cekbelum==0){
					redirect("payroll/ceklembur/upah_borong/tgl_failed");
				} else {
					$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);

				}	
				//$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);
			
			}*/
			$this->db->insert('sc_tmp.cek_borong',$looping_upahborong);
		}	
		$nodok=$this->session->userdata('nik');
		$this->lihat_borong($tglawal,$tglakhir,$nodok,$kddept);
	
	}
	
	function proses_absen(){
		
		$tanggal=$this->input->post('tgl');				
		if (empty($tanggal)) {
			redirect('payroll/ceklembur/absen');
		}
		$tgl=explode(' - ',$tanggal);
		
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		$tglawal=date('Y-m-d',strtotime($tgl1));
		$tglakhir=date('Y-m-d',strtotime($tgl2));
		$tglbelum=date('Y-m-d',strtotime('-1 day',strtotime($tglawal)));
		$tgle=date('d',strtotime($tglawal));		
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		/*$cekbelum=$this->m_ceklembur->q_absenbelum($tglbelum,$kdgroup_pg,$kddept)->num_rows();
		if ($cekbelum==0){
			redirect("payroll/ceklembur/absen/tgl_failed");
		}*/	
		
		
		$this->delete_tmp_absen($tglawal,$tglakhir,$kddept);
				
			
		/*$cek=$this->m_ceklembur->q_transready_absen_gt($tglawal,$tglakhir,$kdgroup_pg,$kddept)->num_rows();
		if ($cek>0){
			redirect ('payroll/ceklembur/absen/kode_failed');
		
		}*/
		$datane2=$this->m_ceklembur->q_transready_absen($tglawal,$tglakhir,$kdgroup_pg,$kddept)->result();
		
		foreach ($datane2 as $dta2){
		
			$nik=$dta2->nik;
			//$jam_masuk=$dta2->jam_masuk_absen;
			//$jam_pulang=$dta2->jam_pulang_absen;
			$tgl_absen=$dta2->tgl;
			$shiftke=$dta2->shiftke;	
			$status='I';
			
			$looping_absen=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'tgl_kerja'=>$tgl_absen,
			'shiftke'=>$shiftke,
			'status'=>$status,
			//'jam_masuk_absen'=>$jam_masuk,
			//'jam_selesai_absen'=>$jam_pulang,
			//'nominal'=>100000,
			
			
			);
			/*if ($tgle==01) {
				$this->db->insert('sc_tmp.cek_absen',$looping_absen);
			
			} else {
				$cekbelum=$this->m_ceklembur->q_absenbelum($tglbelum,$kdgroup_pg,$kddept)->num_rows();
				if ($cekbelum==0){
					redirect("payroll/ceklembur/absen/tgl_failed");
				} else {
					$this->db->insert('sc_tmp.cek_absen',$looping_absen);
				}
			}*/	
			
			$this->db->insert('sc_tmp.cek_absen',$looping_absen);
			
			
			
		}
		$nik=$this->session->userdata('nik');
		$nodok=$this->session->userdata('nik');
		$txt1='select cek_jadwal('.chr(39).$tglawal.chr(39).','.chr(39).$tglakhir.chr(39).','.chr(39).trim($nodok).chr(39).','.chr(39).chr(39).')';
		$pr=$this->db->query($txt1);	
		$this->lihat_absen($tglawal,$tglakhir,$kddept);
		
	}
	
	function delete_tmp($tglawal,$tglakhir){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.cek_shift where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.cek_absen where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' and nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.cek_lembur where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.cek_borong where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' nodok='$nodok'");
		
		

	}
	
	
	function delete_tmp_lembur($tglawal,$tglakhir,$kddept){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.cek_lembur where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'  
						and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
	}
	
	function delete_tmp_absen($tglawal,$tglakhir,$kddept){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.cek_absen where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' 
						and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
	}
	
	function delete_tmp_borong($tglawal,$tglakhir,$kdgroup_pg,$kddept){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.cek_borong
						where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' 
						and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
	}
	
	function delete_tmp_shift($tglawal,$tglakhir,$kddept){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.cek_shift where to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' 
						and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
	}				
	
	function edit_borong($nodok,$tglawal,$tglakhir,$nik,$kddept){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Generate Tidak Dapat Dilanjutkan, Silahlan Mengisi Gaji Tetap terlebih Dahulu</div>";
        else if($this->uri->segment(7)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Data Absen $nik Sukses Disimpan</div>";
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
		$data['title']="List Detail Upah Borong No. Dokumen $nodok";
		$data['total_upah']=$this->m_ceklembur->total_upah_dtl($nodok)->row_array();
		$data['list_upah_dtl']=$this->m_ceklembur->q_upah_borong_detail($nodok)->result();
		$data['tglawal']=$tglawal;
		$data['tglakhir']=$tglakhir;
		//$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['nik']=$nik;
		$this->template->display('payroll/ceklembur/v_edit_borong',$data);
	
	}
	
	function edit_borong_master(){
		$nodok=$this->input->post('nodok');
		$nik=$this->input->post('nik');
		$total_upah=$this->input->post('total_upah');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$this->db->query("update sc_trx.upah_borong_mst set total_upah='$total_upah' where nik='$nik' and nodok='$nodok'");
		$this->db->query("update sc_tmp.cek_borong set total_upah='$total_upah' where nik='$nik' and nodok_ref='$nodok'");
		redirect("payroll/ceklembur/lihat_borong/$tglawal/$tglakhir/$nodok/rep_succes");
	
	}
	
	function edit_borong_detail(){
		
		$nik=trim($this->input->post('nik'));
		$nodok=$this->input->post('nodok');
		$tarif_satuan=$this->input->post('tarif_satuan');
		$total_target=$this->input->post('total_target');
		$catatan=$this->input->post('catatan');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$kddept=$this->input->post('kddept');
		$pencapaian=str_replace(",",".",$this->input->post('pencapaian'));
		$upah_borong1=($pencapaian-$total_target)*$tarif_satuan;
		$no_urut=trim($this->input->post('no_urut'));
		if ($upah_borong1<=0){
			$upah_borong=0;
		} else {
			$upah_borong=$upah_borong1;
		}
		
		
		//echo $tpcuti;
		$info=array(
			
			
			'pencapaian'=>$pencapaian,
			'upah_borong'=>$upah_borong,
			'catatan'=>strtoupper($catatan),
		);
		//echo $kdupah_borong;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_upah_borong->q_upah_borong($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->where('no_urut',$no_urut);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.upah_borong_dtl',$info);
		$this->db->query("update sc_trx.upah_borong_mst set total_upah=(select sum(upah_borong) as total_upah from sc_trx.upah_borong_dtl where nodok='$nodok')
							where nodok='$nodok'");
		$this->db->query("update sc_tmp.cek_borong set total_upah=(
						select total_upah from sc_trx.upah_borong_mst
						where nodok='$nodok')
						where nodok_ref='$nodok'");					
		//echo $kddept.$kdgroup_pg;
		redirect("payroll/ceklembur/edit_borong/$nodok/$tglawal/$tglakhir/$nik/$kdgroup_pg/$kddept");
		
	}
	
	function edit_lembur(){
		$nodok=$this->input->post('nodok');
		$nik=$this->input->post('nik');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=$this->input->post('jam_mulai_absen');
		$jam_selesai=$this->input->post('jam_selesai_absen');
		//$this->db->query("update sc_trx.lembur set status='U',tgl_jam_mulai='$jam_mulai',tgl_jam_selesai='$jam_selesai' where nodok='$nodok' and nik='$nik'");
		//$this->db->query("update sc_trx.lembur set status='P' where nodok='$nodok' and nik='$nik'");
		
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where tgl='$tgl_kerja' and nik='$nik'");
		redirect("payroll/ceklembur/lihat_lembur/$tglawal/$tglakhir/$nodok/rep_succes");
	
	
	}
	
	function edit_absen(){
	
		$nik=$this->input->post('nik');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=$this->input->post('jam_mulai');
		$jam_selesai=$this->input->post('jam_selesai');
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$kddept=$this->input->post('kddept');
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where nik='$nik' and tgl='$tgl_kerja'");
		redirect("payroll/ceklembur/lihat_absen/$tglawal/$tglakhir/$kddept/rep_succes");
	}
	
	function edit_shift(){
	
		$nik=$this->input->post('nik');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=str_replace("_","",$this->input->post('jam_mulai'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		$kddept=$this->input->post('kddept');
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where nik='$nik' and tgl='$tgl_kerja'");
		redirect("payroll/ceklembur/lihat_shift/$tglawal/$tglakhir/$kddept/$nik/rep_succes");
	}
	
	function hapus_shift($nik,$tgl_kerja){
		$this->db->query("update sc_trx.transready set jam_masuk_absen=null,jam_pulang_absen=null where nik='$nik' and tgl='$tgl_kerja'");
		redirect("payroll/ceklembur/shift");
	
	}
	
	function input_shift(){
		$nik=$this->input->post('nik');
		$tgl_kerja=$this->input->post('tgl_kerja');
		$jam_mulai=str_replace("_","",$this->input->post('jam_mulai'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$kdjamkerja=$this->input->post('kdjamkerja');
		
		$cek=$this->m_ceklembur->cek_absen($nik,$tgl_kerja)->num_rows();
		if ($cek>0){
			$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_mulai',jam_pulang_absen='$jam_selesai' where nik='$nik' and tgl='$tgl_kerja'");
		
		} else {
			$absen=array(
				'nik'=>$nik,
				'tgl'=>$tgl_kerja,
				'kdjamkerja'=>$kdjamkerja,
				'jam_masuk_absen'=>$jam_mulai,
				'jam_pulang_absen'=>$jam_selesai,
				
			);
			$this->db->insert('sc_trx.transready',$absen);
		
		}
		redirect("payroll/ceklembur/shift/rep_succes");
	}
	
	 
	
	

}	