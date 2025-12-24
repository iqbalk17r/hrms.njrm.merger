<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Generate extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_generate');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index($nik){
      
		echo 'test';
			
	
		
    }
	
	function generate_tmp($tgl,$tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
	
		//$nodok=$this->session->userdata('nik');
		//$txt1='select lihat_jadwal('.chr(39).trim($tgl).chr(39).','.chr(39).trim($nodok).chr(39).','.chr(39).chr(39).')';
		//$pr=$this->db->query($txt1);	
		//echo $tgl;
		//echo 'test';
		//$tglakhirfix=date('Y-m-d',strtotime($tglref));
		//$tgl3=date('Y-m-d',strtotime('-1 month',strtotime($tglref)));	
		$data=$this->m_generate->list_karyawan($tgl,$kdgroup_pg,$kddept)->result();
		//INSERT REKAP
		$master_rekap=array(
			'nodok'=>$this->session->userdata('nik'),
			'input_by'=>$this->session->userdata('nik'),
			'input_date'=>date('Y-m-d H:i:s'),
			'status'=>'I',
			'periode_mulai'=>$tglawalfix,
			'periode_akhir'=>$tglakhirfix,
			
		
		);
		$this->db->insert('sc_tmp.payroll_rekap',$master_rekap);
		foreach ($data as $dt) {
			$nik=$dt->nik;
			$sisa_cuti=$dt->sisa_cuti;
			$periode_mulai=$tglawalfix;
			$periode_akhir=$tglakhirfix;
			//insert master 
				$master=array(
					'nodok'=>$this->session->userdata('nik'),
					'nik'=>$nik,
					'sisa_cuti'=>$sisa_cuti,
					'input_by'=>$this->session->userdata('nik'),
					'input_date'=>date('Y-m-d H:i:s'),
					'periode_mulai'=>$periode_mulai,
					'periode_akhir'=>$periode_akhir,
				
				);
			$this->db->insert('sc_tmp.payroll_master',$master);
			//$nodok=$this->session->userdata('nik');
			//$txt1='select lihat_jadwal('.chr(39).trim($tgl).chr(39).','.chr(39).trim($nodok).chr(39).','.chr(39).chr(39).')';
			//$pr=$this->db->query($txt1);	
		
			$data_formula=$this->m_generate->q_setup_formula()->result();
			foreach ($data_formula as $dtf){
			
				$no_urut=$dtf->no_urut;
				$keterangan=$dtf->keterangan;
				$tipe=$dtf->tipe;
				$aksi_tipe=$dtf->aksi_tipe;
				$nodok=$this->session->userdata('nik');
				/*if ($no_urut==2){
				echo $nik.'| '.$no_urut.'| '.$keterangan.'| '.$tipe.'| '.$aksi_tipe.'<br>';
				
				}*/ 
				if (trim($tipe)=='LINK'){
				//$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','$no_urut'.'.chr(39).$nodok.chr(39).') as nominal';
				//$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).') as nominal';
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					//echo $txt.'<br>';
					$pr=$this->db->query($txt)->row_array();
				//$gajipokok=$pr['nominal'];
				//echo $gajipokok;
				
				} else if (trim($tipe)=='OTOMATIS'){
				
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					$pr=$this->db->query($txt)->row_array();
				
				} else {
					$txt='select sc_trx.pr_input_global('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					$pr=$this->db->query($txt)->row_array();
					
				}
				
			}
		
			
			
			
		
		
		}
		
		
		
		//redirect('payroll/generate/utama/rep_succes');
		redirect('payroll/detail_payroll/master');
		
		
    }
	
	
	function generate_pph($tgl,$tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
	
	
		$data=$this->m_generate->list_karyawan($tgl,$kdgroup_pg,$kddept)->result();
		//INSERT REKAP
		$master_rekap=array(
			'nodok'=>$this->session->userdata('nik'),
			'input_by'=>$this->session->userdata('nik'),
			'input_date'=>date('Y-m-d H:i:s'),
			'status'=>'I',
			'periode_mulai'=>$tglawalfix,
			'periode_akhir'=>$tglakhirfix,
			
		
		);
		$this->db->insert('sc_tmp.p21_rekap',$master_rekap);
		foreach ($data as $dt) {
			$nik=$dt->nik;
			$periode_mulai=$tglawalfix;
			$periode_akhir=$tglakhirfix;
			//insert master 
				$master=array(
					'nodok'=>$this->session->userdata('nik'),
					'nik'=>$nik,
					'input_by'=>$this->session->userdata('nik'),
					'input_date'=>date('Y-m-d H:i:s'),
					'periode_mulai'=>$periode_mulai,
					'periode_akhir'=>$periode_akhir,
				
				);
			$this->db->insert('sc_tmp.p21_master',$master);
			//$nodok=$this->session->userdata('nik');
			//$txt1='select lihat_jadwal('.chr(39).trim($tgl).chr(39).','.chr(39).trim($nodok).chr(39).','.chr(39).chr(39).')';
			//$pr=$this->db->query($txt1);	
		
			$data_formula=$this->m_generate->q_setup_formula_21()->result();
			foreach ($data_formula as $dtf){
			
				$no_urut=$dtf->no_urut;
				$keterangan=$dtf->keterangan;
				$tipe=$dtf->tipe;
				$aksi_tipe=$dtf->aksi_tipe;
				$nodok=$this->session->userdata('nik');
				/*if ($no_urut==2){
				echo $nik.'| '.$no_urut.'| '.$keterangan.'| '.$tipe.'| '.$aksi_tipe.'<br>';
				
				}*/ 
				if (trim($tipe)=='LINK'){
				//$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','$no_urut'.'.chr(39).$nodok.chr(39).') as nominal';
				//$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).') as nominal';
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					//echo $txt.'<br>';
					$pr=$this->db->query($txt)->row_array();
				//$gajipokok=$pr['nominal'];
				//echo $gajipokok;
				
				} else if (trim($tipe)=='OTOMATIS'){
				
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					$pr=$this->db->query($txt)->row_array();
				
				} 
				
			}
		
		
		}
		
		//redirect('payroll/generate/utama/rep_succes');
		redirect('payroll/detail_payroll/master_pph');
		//echo 'sukses';
		
    }

	

	function karyawan(){
		
		$data['title']="List Karyawan Payroll";
		$data['list_karyawan']=$this->m_generate->list_karyawan()->result();
		$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/generate/v_list_karyawan',$data);
		
	}
	
	function detail_tmp($nik){
		$data['title']="List Detail Payroll";
	
	
	}
	
	function utama(){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="lembur_failed")
            $data['message']="<div class='alert alert-danger'>Dokumen Lembur Ada yang Belum Di Generate Untuk Periode Bulan Ini</div>";
		else if($this->uri->segment(4)=="borong_failed")
            $data['message']="<div class='alert alert-danger'>Dokumen Upah Borong Ada yang Belum Di Generate Untuk Periode Bulan Ini</div>";
		else if($this->uri->segment(4)=="absen_failed")
            $data['message']="<div class='alert alert-danger'>Dokumen Potongan Absen Ada yang Belum Di Generate Untuk Periode Bulan Ini</div>";	
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="gaji_failed")
            $data['message']="<div class='alert alert-danger'>Proses Generate Tidak Dapat Dilanjutan, Silahkan Cek Gaji Tetap Department ini terlebih Dahulu</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$this->template->display('payroll/generate/v_utama',$data);
	}
	
	function utama_21(){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="lembur_failed")
            $data['message']="<div class='alert alert-danger'>Dokumen Lembur Ada yang Belum Di Generate Untuk Periode Bulan Ini</div>";
		else if($this->uri->segment(4)=="borong_failed")
            $data['message']="<div class='alert alert-danger'>Dokumen Upah Borong Ada yang Belum Di Generate Untuk Periode Bulan Ini</div>";
		else if($this->uri->segment(4)=="absen_failed")
            $data['message']="<div class='alert alert-danger'>Dokumen Potongan Absen Ada yang Belum Di Generate Untuk Periode Bulan Ini</div>";	
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="gaji_failed")
            $data['message']="<div class='alert alert-danger'>Proses Generate Tidak Dapat Dilanjutan, Silahkan Cek Gaji Tetap Department ini terlebih Dahulu</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['title']="Halaman Utama Generate";
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$this->template->display('payroll/generate/v_utama_21',$data);
	}
	
	function proses(){
		$this->delete_tmp();
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');	
		if ($kdgroup_pg=='P2'){
		
			redirect('payroll/generate/utama/kode_failed');
		
		} else {
		
		
		$cek_gt=$this->m_generate->q_cek_gt($kddept,$kdgroup_pg)->num_rows();
		if ($cek_gt>0){
		
			redirect('payroll/generate/utama/gaji_failed');
		}
		
		
		
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
		//echo $tglakhirfix.'|'.$tglawalfix;
		$q1=$this->m_generate->q_nominal_shift2()->row_array();
		$tj_shift2=$q1['value3'];
		$q2=$this->m_generate->q_nominal_shift3()->row_array();
		$tj_shift3=$q2['value3'];
		
		$cek_lembur=$this->m_generate->q_cek_tgl_lembur($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
		if ($cek_lembur>0){
			redirect('payroll/generate/utama/lembur_failed');
		}
		
		$cek_borong=$this->m_generate->q_cek_tgl_borong($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
		
		if ($cek_borong>0){
			redirect('payroll/generate/utama/borong_failed');
		
		}
		
		$cek_absen=$this->m_generate->q_cek_tgl_absen($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
		
		if ($cek_absen>0){
			redirect('payroll/generate/utama/absen_failed');
		}
		
		$datane=$this->m_generate->q_transready_shift($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->result();
			
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
			
			$this->db->insert('sc_tmp.tunjangan_shift',$looping_shift);
		
			//echo $nik2.'|'.$jam_masuk.'|'.$jam_pulang.'|'.$tgl_absen.'<br>';
		
		}
		/*
		$datane2=$this->m_generate->q_transready_absen($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->result();
		
		foreach ($datane2 as $dta2){
		
			$nik=$dta2->nik;
			//$jam_masuk_min=$dta2->jam_masuk_absen;
			//$jam_pulang=$dta2->jam_pulang_absen;
			$tgl_absen=$dta2->tgl_kerja;
			$nodok_ref=$dta2->nodok_ref;
			$shiftke=$dta2->shiftke;	
			$flag_cuti=$dta2->flag_cuti;	
			$cuti_nominal=$dta2->cuti_nominal;	
			$status='I';
			
			$looping_absen=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'tgl_kerja'=>$tgl_absen,
			'shiftke'=>$shiftke,
			'status'=>$status,
			'flag_cuti'=>$flag_cuti,
			'cuti_nominal'=>$cuti_nominal,
			//'nominal'=>100000,
			
			
			);
			$this->db->insert('sc_tmp.potongan_absen',$looping_absen);
			//$status2='P';
			//$nodok=$this->session->userdata('nik');
			//$txt='update sc_tmp.potongan_absen set status='.chr(39).trim($status2).chr(39).' where nik='.chr(39).trim($nik).chr(39).'
			//and tgl_kerja='.chr(39).$tgl_absen.chr(39).' and nodok='.chr(39).$nodok.chr(39);
			//$this->db->query($txt);
			//update sc_tmp.potongan_absen set status='P' where nik='02521306' and tgl_kerja='2016-01-26' and nodok='12345'
			
			
		}
		
		$datane3=$this->m_generate->q_lembur($tglawalfix,$tglakhirfix)->result();
		
		foreach ($datane3 as $dta3) {
			$nodok=$this->session->userdata('nik');
			$nik=$dta3->nik;
			$nodok_ref=$dta3->nodok;
			$tgl_dok=$dta3->tgl_dok;
			$tplembur=$dta3->kdlembur;
			$jam_mulai=$dta3->tgl_jam_mulai;
			$jam_selesai=$dta3->tgl_jam_selesai;
			$jumlah_jam=$dta3->durasi;
			$tgl_kerja=$dta3->tgl_kerja;
			//$tgl_jadwal=$dta3->tgl;
			//$kdjamkerja=$dta3->kdjamkerja;
			//$jam_masuk_absen=$dta3->jam_masuk_absen;
			$jam_pulang_absen=$dta3->jam_absen;
			if (empty($jam_pulang_absen)) {
				$jam_pulang_absen1=null;
			} else {
				$jam_pulang_absen1=$jam_pulang_absen;
			}
			
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
				'jam_selesai_absen'=>$jam_pulang_absen1,
				'status'=>'I',
				
				
			
			);
			
			$this->db->insert('sc_tmp.detail_lembur',$looping_lembur);
			$this->db->query("update sc_tmp.detail_lembur set status='P' where nodok_ref='$nodok_ref' and nodok='$nodok'");
		
		}
		
		$datane4=$this->m_generate->q_upah_borong($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->result();
		
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
				'total_upah'=>$total_upah,
			);
			//echo $nik.'|'.$nodok_ref;
			$this->db->insert('sc_tmp.payroll_borong',$looping_upahborong);
		
		}
		//echo 'sukses';
		//redirect('payroll/generate/utama/rep_succes');
		
		*/
		$this->generate_tmp($tgl,$tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept);
		}
	}
	
	
	
	function proses_pph(){
		
		$this->delete_tmp_21();
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept=$this->input->post('kddept');
		
		if ($kdgroup_pg=='P2'){
		
			redirect('payroll/generate/utama_21/kode_failed');
		
		} else {
		
		
			$cek_gt=$this->m_generate->q_cek_gt($kddept,$kdgroup_pg)->num_rows();
			if ($cek_gt>0){
			
				redirect('payroll/generate/utama_21/gaji_failed');
			}
			
			
			
			
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
			
			
			
			$cek_lembur=$this->m_generate->q_cek_tgl_lembur($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
			if ($cek_lembur>0){
				redirect('payroll/generate/utama_21/lembur_failed');
			}
			
			$cek_borong=$this->m_generate->q_cek_tgl_borong($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
			
			if ($cek_borong>0){
				redirect('payroll/generate/utama_21/borong_failed');
			
			}
			
			$cek_absen=$this->m_generate->q_cek_tgl_absen($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
			
			if ($cek_absen>0){
				redirect('payroll/generate/utama_21/absen_failed');
			}
		
		
		}
		$this->generate_pph($tgl,$tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept);
		
	}
	
	
	function delete_tmp(){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.tunjangan_shift where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.potongan_absen where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.detail_lembur where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.payroll_borong where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_detail where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_master where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_rekap where nodok='$nodok'");

	}
	
	function delete_tmp_21(){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.p21_rekap where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.p21_master where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.p21_detail where nodok='$nodok'");
		

	}
	
	

}	