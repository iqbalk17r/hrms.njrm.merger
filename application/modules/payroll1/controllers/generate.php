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
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
		$nik=$this->session->userdata('nik');
		$data['title']="HALLO : $nik , SELAMAT DATANG DI MENU PAYROLL KARYAWAN";
		$this->template->display('payroll/generate/v_index',$data);
		
    }
	
	function generate_tmp(){

		$tgl=$this->fiky_encryption->dekript($this->uri->segment(4));
		$tglawalfix=$this->fiky_encryption->dekript($this->uri->segment(5));
		$tglakhirfix=$this->fiky_encryption->dekript($this->uri->segment(6));
		$kdgroup_pg=$this->fiky_encryption->dekript($this->uri->segment(7));
		$kddept=$this->fiky_encryption->dekript($this->uri->segment(8));

		$nodok=trim($this->session->userdata('nik'));
		$periode=date('m',strtotime($tglakhirfix));
		$keluarkerja=date('Ym',strtotime($tglakhirfix));
        $this->db->query("select sc_trx.pr_ambil_pinjaman('$nodok'||'|'||''||'|'||'$nodok')");
		
		//$data=$this->m_generate->list_karyawan_new($kdgroup_pg,$kddept,$keluarkerja)->result();
		/*INSERT REKAP
		$master_rekap=array(
			'nodok'=>$this->session->userdata('nik'),
			'input_by'=>$this->session->userdata('nik'),
			'input_date'=>date('Y-m-d H:i:s'),
			'status'=>'I',
			'periode_mulai'=>$tglawalfix,
			'periode_akhir'=>$tglakhirfix,
			'kddept'=>$kddept,
		);
		$this->db->insert('sc_tmp.payroll_rekap',$master_rekap); */
		$this->db->query("delete from sc_mst.trxerror where userid='$nodok' and modul='PAYROLL_GEN'");
		$this->db->query("insert into sc_mst.trxerror (userid,errorcode,modul) values ('$nodok','1','PAYROLL_GEN')");
		$this->db->query("delete from sc_tmp.payroll_rekap where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_master where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_detail where nodok='$nodok'");


		
		if(empty($kddept) or $kddept==''){
					$txt="select sc_tmp.pr_generate_payroll('$nodok','$keluarkerja','$tglawalfix','$tglakhirfix','$kdgroup_pg')";
					//echo $txt;
					$this->db->query($txt);
					$output = array(
								"success"=> TRUE,
								"status" => TRUE,
										//"url" => 'dashboard',						
										);
					echo json_encode($output);
		} else {
					$txt="select sc_tmp.pr_generate_payroll_dept('$nodok','$keluarkerja','$tglawalfix','$tglakhirfix','$kdgroup_pg','$kddept')";
					//echo $txt;
					$this->db->query($txt);
					$output = array(
								"success"=> TRUE,
								"status" => TRUE,
										//"url" => 'dashboard',						
										);
					echo json_encode($output);

		}
		

	
    }
	
	
	function generate_pph($kdgroup_pg,$kddept,$periode){
	
		///$periode=date('m',strtotime($tglakhirfix));
		$data=$this->m_generate->list_karyawan($kdgroup_pg,$kddept)->result();
		//INSERT REKAP
		$master_rekap=array(
			'nodok'=>$this->session->userdata('nik'),
			'input_by'=>$this->session->userdata('nik'),
			'input_date'=>date('Y-m-d H:i:s'),
			'status'=>'I',
			'periode_mulai'=>$periode,
			'periode_akhir'=>$periode,
			'kddept'=>$kddept,
			
		
		);
		
		$this->db->insert('sc_tmp.p21_rekap',$master_rekap);
		foreach ($data as $dt) {
			$nik=$dt->nik;
			$periode_mulai=$periode;
			$periode_akhir=$periode;
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
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).','.$periode.') as nominal';
					//echo $txt.'<br>';
					$pr=$this->db->query($txt)->row_array();
				//$gajipokok=$pr['nominal'];
				//echo $gajipokok;
				
				} else if (trim($tipe)=='OTOMATIS'){
				
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).','.$periode.') as nominal';
					$pr=$this->db->query($txt)->row_array();
				
				} 
				
			}
		
		
		}
		
		//redirect('payroll/generate/utama/rep_succes');
		redirect('payroll/detail_payroll/master_pph');
		//redirect("payroll/detail_payroll/master_pph/$kdgroup_pg/$kddept/$periode");
		//echo $kdgroup_pg;
		//echo $kddept;
		//echo $periode;
		
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
		else if($this->uri->segment(4)=="close_failed")
            $data['message']="<div class='alert alert-danger'>Periode Tersebut Sudah Di Closing</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
		else if($this->uri->segment(4)=="gr_failed") {
		$nodok=$this->uri->segment(5);
		$data['message']="<div class='alert alert-danger'>Periode Tersebut Sudah Di Final Di Proses Dengan Dokumen : $nodok Silahakan Lihat Pada Menu Final Closing/List Payroll</div>";}
		else if($this->uri->segment(4)=="gr_failedtmp") {
		$nodok=$this->uri->segment(5);
		$data['message']="<div class='alert alert-danger'>Periode Tersebut Sedang Di Proses Nik : $nodok , Silahkan Lanjutkan/Clear Dengan Nik Pada Menu Lanjutan Payroll</div>";}
        else
            $data['message']='';
        $data['title']='Halaman Utaman Generate';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.B.1'; $versirelease='I.P.B.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['dtlopt']=$this->m_generate->q_setup_option_dept()->row_array();
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
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$kdgroup_pg=$this->input->post('kdgroup_pg');	
		$kddept1=$this->input->post('kddept');	
		if ($kdgroup_pg=='P2'){
		
			redirect('payroll/generate/utama/kode_failed');
		
		} else {

		$ceksetup=$this->m_generate->q_setup_option_dept()->row_array();
		if (trim($ceksetup['status'])=='F'){
					$kddept='';
					$kddept_block=$kdgroup_pg;
		} else { 	$kddept=$kddept1;
					$kddept_block=$kddept1;
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
		$periodeclose=date('Ym',strtotime($tglakhirfix));
		//echo $tglakhirfix.'|'.$tglawalfix;
		$q1=$this->m_generate->q_nominal_shift2()->row_array();
		$tj_shift2=$q1['value3'];
		$q2=$this->m_generate->q_nominal_shift3()->row_array();
		$tj_shift3=$q2['value3'];



		$cek_trx=$this->m_generate->q_cek_trxpayroll($tglawalfix,$tglakhirfix,$kddept_block)->num_rows();
		$dtl_trx=$this->m_generate->q_cek_trxpayroll($tglawalfix,$tglakhirfix,$kddept_block)->row_array();
		$cek_tmp=$this->m_generate->q_cek_tmppayroll($tglawalfix,$tglakhirfix,$kddept_block)->num_rows();
		$dtl_tmp=$this->m_generate->q_cek_tmppayroll($tglawalfix,$tglakhirfix,$kddept_block)->row_array();
		
		if ($cek_trx>0){
			redirect('payroll/generate/utama/gr_failed/'.$dtl_trx['nodok']);
		} else if ($cek_tmp>0){
			redirect('payroll/generate/utama/gr_failedtmp/'.$dtl_tmp['nodok']);
		} 
		    $enc_tgl=$this->fiky_encryption->enkript($tgl);
		    $enc_tglawalfix=$this->fiky_encryption->enkript($tglawalfix);
		    $enc_tglakhirfix=$this->fiky_encryption->enkript($tglakhirfix);
		    $enc_kdgroup_pg=$this->fiky_encryption->enkript($kdgroup_pg);
		    $enc_kddept=$this->fiky_encryption->enkript($kddept);

			$this->harap_tunggu($enc_tgl,$enc_tglawalfix,$enc_tglakhirfix,$enc_kdgroup_pg,$enc_kddept);

		}
	}
	
	function harap_tunggu($enc_tgl,$enc_tglawalfix,$enc_tglakhirfix,$enc_kdgroup_pg,$enc_kddept){
            $tgl=$this->fiky_encryption->dekript($enc_tgl);
            $tglawalfix=$this->fiky_encryption->dekript($enc_tglawalfix);
            $tglakhirfix=$this->fiky_encryption->dekript($enc_tglakhirfix);
            $kdgroup_pg=$this->fiky_encryption->dekript($enc_kdgroup_pg);
            $kddept=$this->fiky_encryption->dekript($enc_kddept);
			//echo 'HARAP TUNGGU...';
			$data['title']="HARAP TUNGGU";
/*			$data['tgl']=$tgl;
			$data['tglawalfix']=$tglawalfix;
			$data['tglakhirfix']=$tglakhirfix;
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;*/

            $data['tgl']=$enc_tgl;
            $data['tglawalfix']=$enc_tglawalfix;
            $data['tglakhirfix']=$enc_tglakhirfix;
            $data['kdgroup_pg']=$enc_kdgroup_pg;
            $data['kddept']=$enc_kddept;
            $data['vkddept']=$kddept;

			$data['periode']=$this->fiky_encryption->enkript(date('m',strtotime($tglakhirfix)));
			$data['keluarkerja']=$this->fiky_encryption->enkript(date('Ym',strtotime($tglakhirfix)));
			$this->template->display('payroll/detail/v_harap_tunggu',$data);
			
			
			//header( "Refresh:3; url=http://localhost/nbi/payroll/generate/generate_tmp/$tgl/$tglawalfix/$tglakhirfix/$kdgroup_pg/$kddept", true, 303);
			////header( "Refresh:3; url=generate_tmp/$tgl/$tglawalfix/$tglakhirfix/$kdgroup_pg/$kddept", true, 303);
			
			//header("location=payroll/detail_payroll/generate_pph/$kdgroup_pg/$kddept/$periode/$keluarkerja");
			//redirect("payroll/detail_payroll//$kdgroup_pg/$kddept/$periode/$keluarkerja");
			
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
			
			
			
			/*$cek_lembur=$this->m_generate->q_cek_tgl_lembur($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept)->num_rows();
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
			}*/
		
		
		}
		//$this->generate_pph($tgl,$tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept);
		$this->generate_pph($tglakhirfix,$kdgroup_pg,$kddept);
		
	}
	
	
	function delete_tmp($kddept){
		$nodok=trim($this->session->userdata('nik'));
		$this->db->query("delete from sc_tmp.tunjangan_shift where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.potongan_absen where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.detail_lembur where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.payroll_borong where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_detail where nodok='$nodok' and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
		$this->db->query("delete from sc_tmp.payroll_master where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.payroll_rekap where nodok='$nodok' and kddept='$kddept'");

	}
	
	function delete_tmp_21(){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.p21_rekap where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.p21_master where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.p21_detail where nodok='$nodok'");
			
		
	
	}
	
	function payroll_resign(){
		$data['title']="Generate Payroll Karyawan Resign";
		$bulan=$this->input->post('bulan');
		$tahun=$this->input->post('tahun');
		if(empty($bulan) or empty($tahun)){
			$periode=date('Ym');
		}else{
			$periode=$tahun.$bulan;
		}
		$data['list_karyawan']=$this->m_generate->list_karyawan_resign($periode)->result();
		//$data['list_lk']=$this->m_generate->list_karyawan()->result();
		$this->template->display('payroll/generate/v_list_karyawan',$data);	
	
	
	}
	
	function proses_resign($nik){
		$nodok=$this->session->userdata('nik');
		$dtlkary=$this->m_generate->detail_karyawan($nik)->row_array();
		$periode= (int)date('m', strtotime($dtlkary['tglkeluarkerja'])); 
		$grouppg= trim($dtlkary['grouppenggajian']); 
		$info=array(
			'nik'=>$nik,
			'nodok'=>$nodok,
			
		
		);
		
		$this->db->query("delete from sc_tmp.payroll_resign where nik='$nik' and nodok='$nodok'");
		$this->db->insert('sc_tmp.payroll_resign',$info);
		$this->db->query(" select sc_tmp.pr_generate_p21_resign('$nodok',$periode, '$grouppg', '$nik')");
		/*pindah generate pph self karyawan keluar */
		$this->db->query(" 
		delete from sc_tmp.p21_resign_detail  where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;
		delete from sc_tmp.p21_resign_master  where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;		
		
		insert into sc_tmp.p21_resign_detail select * from sc_tmp.p21_detail where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;
		insert into sc_tmp.p21_resign_master select * from sc_tmp.p21_master where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;
		");
		/*pindah ke trx pph karyawan */
	///	$this->db->query("	
	///	delete from sc_trx.p21_detail  where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;
	///	delete from sc_trx.p21_master  where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;	
	///	
	///		insert into sc_trx.p21_detail select * from sc_tmp.p21_resign_detail where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;
	///		insert into sc_trx.p21_master select nodok,nik,total_pajak,total_pendapatan,total_potongan,input_date,approval_date,input_by,approval_by,delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,gaji_netto,periode_mulai,periode_akhir 
	///		from sc_tmp.p21_resign_master where nik='$nik' and periode_mulai=$periode and periode_akhir=$periode;");
	
		redirect("payroll/generate/view_inputresign/$nik");
	}
	
	function view_inputresign($nik){
		$data['title']="Proses Penggajian Karyawan Resign";
		$data['nik']=$nik;
		$data['nodok']=$this->session->userdata('nik');
		$detail=$this->m_generate->list_karyawan_detail($nik)->row_array();
		$gajitetap=$detail['gajitetap'];
		$nmlengkap=$detail['nmlengkap'];
		$nmdept=$detail['nmdept'];
		$masakerja=$detail['masa_bekerja'];
		$kta_awal = array('years','year','mons','mon','days','day');
		$kta_akhir = array('tahun','tahun','bulan','bulan','hari','hari');
		$pesan= str_replace($kta_awal,$kta_akhir,$detail['masa_bekerja']);
		$data['gajitetap']=$gajitetap;
		$data['nmlengkap']=$nmlengkap;
		$data['nmdept']=$nmdept;
		$data['pesan']=$pesan;
		$data['list_lembur']=$this->m_generate->list_lembur_resign($nik)->result();
		$data['list_shift']=$this->m_generate->list_shift_resign($nik)->result();
		$data['list_absen']=$this->m_generate->list_absen_resign($nik)->result();
		$data['list_borong']=$this->m_generate->list_borong_resign($nik)->result();
		$data['sum_lembur']=$this->m_generate->q_sum_lembur($nik)->row_array();
		$data['sum_borong']=$this->m_generate->q_sum_borong($nik)->row_array();
		$data['sum_shift']=$this->m_generate->q_sum_shift($nik)->row_array();
		$this->template->display('payroll/generate/v_input',$data);	
		
	}
	
	function view_pph21_resign($nik){
		$data['title']="LIHAT PAYROLL RESIGN KARYAWAN";
		$dtlkary=$this->m_generate->detail_karyawan($nik)->row_array();
		$nmlengkap=$dtlkary['nmlengkap'];
		$data['nik']=$nik;
		$data['nmlengkap']=$nmlengkap;
		$data['list_phh21_resign']=$this->m_generate->q_detail_pph21setahun($nik)->result();
		$this->template->display('payroll/generate/v_detail_pph21_resign',$data);
		
	}
	
	function view_pph21_resign_slip($nik){
		$data['title']="LIHAT PAYROLL RESIGN KARYAWAN";
		$dtlkary=$this->m_generate->detail_karyawan($nik)->row_array();
		$nmlengkap=$dtlkary['nmlengkap'];
		$data['nik']=$nik;
		$data['nmlengkap']=$nmlengkap;
		$data['list_phh21_resign']=$this->m_generate->q_detail_pph21setahun($nik)->result();
		$this->template->display('payroll/generate/v_detail_pph21_resign_slip',$data);
		
	}
	
	function add_gajiresign(){
		
		$nodok=$this->session->userdata('nik');
		$nik=$this->input->post('nik');
		$gajitetap=$this->input->post('gajitetap');
		$kom_pesangon=$this->input->post('kom_pesangon');
		$tj_pesangon=$this->input->post('ttlpesangon');
		$kom_masakerja=$this->input->post('kom_masakerja');
		$tj_masakerja=$this->input->post('ttlmasakerja');
		$kom_penggantianhak=$this->input->post('kom_penggantianhak');
		$tj_penggantianhak=$this->input->post('ttlpenggantianhak');
		$kom_cuti=$this->input->post('kom_cuti');
		$tj_cuti=$this->input->post('ttlcuti');
		$kom_absen=$this->input->post('kom_absen');
		$tj_absen=$this->input->post('ttlabsen');
		$tj_lain=$this->input->post('tj_lain');
		$potongan=$this->input->post('potongan');
		$total_upah=$this->input->post('ttltarget');
	
		$info=array(
			'gajitetap'=>$gajitetap,
			'kom_pesangon'=>$kom_pesangon,
			'tj_pesangon'=>$tj_pesangon,
			'kom_masakerja'=>$kom_masakerja,
			'tj_masakerja'=>$tj_masakerja,
			'kom_penggantianhak'=>$kom_penggantianhak,
			'tj_penggantianhak'=>$tj_penggantianhak,
			'kom_cuti'=>$kom_cuti,
			'tj_cuti'=>$tj_cuti,
			'kom_absen'=>$kom_absen,
			'tj_absen'=>$tj_absen,
			'tj_lain'=>$tj_lain,
			'potongan'=>$potongan,
			'total_upah'=>$total_upah,
			'status'=>'I',
		
		);
		$this->db->where('nik',$nik);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_tmp.payroll_resign',$info);
		$this->db->query("update sc_tmp.payroll_resign set status='F' where nik='$nik' and nodok='$nodok'");
		$this->db->query("select sc_tmp.hitung_pph_resign()");
		//echo 'sukses';
		redirect('payroll/generate/view_finalresign');
	
	}
	
	function view_finalresign(){
		$data['title']="Final Penggajian Karyawan Resign";
		$data['list_karyawan']=$this->m_generate->q_finalresign()->result();
		$this->template->display('payroll/generate/v_finalresign',$data);	
	
	}
	
	function view_detailfinalresign($nik){
		$data['title']="Detail Penggajian Karyawan Resign";
		$data['nik']=$nik;
		$data['nodok']=$this->session->userdata('nik');
		$data['list_lembur']=$this->m_generate->list_lembur_resign($nik)->result();
		$data['list_shift']=$this->m_generate->list_shift_resign($nik)->result();
		$data['list_absen']=$this->m_generate->list_absen_resign($nik)->result();
		$data['list_borong']=$this->m_generate->list_borong_resign($nik)->result();
		$data['sum_lembur']=$this->m_generate->q_sum_lembur($nik)->row_array();
		$data['sum_borong']=$this->m_generate->q_sum_borong($nik)->row_array();
		$data['sum_shift']=$this->m_generate->q_sum_shift($nik)->row_array();
		$data['detail']=$this->m_generate->q_detailfinalresign($nik)->result();
		
		$this->template->display('payroll/generate/v_detailfinalresign',$data);
	
	}
	function final_slipgaji_resign(){
		
		$nik=$this->input->post('nik');
		/*penambahan edit penggantian hak*/
		$ttlpenggantianhak=$this->input->post('ttlpenggantianhak');
		$ttltarget=$this->input->post('ttltarget');
		$tgl_bayar=$this->input->post('tgl_bayar');
		
		$this->db->where('nik',$nik);
		$info=array(
			'tgl_pembayaran'=>$tgl_bayar,
			'tj_penggantianhak'=>$ttlpenggantianhak,
			'total_upah'=>$ttltarget,
			'status'=>'P',
		);
		$this->db->update('sc_trx.payroll_resign',$info);
		$this->db->query("select sc_tmp.hitung_pph_resign()");
		redirect("payroll/generate/view_detailfinalresign/$nik");
	}
	function pdf_slipgaji_resign($nik){
			
		$data['detail']=$this->m_generate->q_detailfinalresign_pdf($nik)->result();
        $this->pdf->load_view('payroll/generate/v_slipgajiresign',$data);
        $this->pdf->set_paper('f4','potrait');
        $this->pdf->render();       
        $this->pdf->stream("Slip Gaji Karyawan Resign.pdf");
		
		
          
    }
	
	function ajax_cekstatusresign($nik){
		$data = $this->m_generate->q_detailfinalresign_pdf($nik)->row_array();
		echo json_encode($data);
	}
		
//modul p1721-----------------------------------------------------------------
	function utama_p1721(){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Berhak Generate Dokumen Ini</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Generate Sukses</div>";
		else if($this->uri->segment(4)=="gr_failed") {
			$tahun=$this->uri->segment(5);
			$kddept=$this->uri->segment(6);
			$kdgroup_pg=$this->uri->segment(7);
            $data['message']="<div class='alert alert-danger'>Dokumen sudah dilakukan proses Generate Tahun: $tahun , Department: $kddept , Group: $kdgroup_pg </div>";
		}
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
		
		$data['title']='GENERATE MODUL PELAPORAN MODEL 1721 A1';
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$this->template->display("payroll/generate/v_utama1721",$data);
		
	}
	function utama_view_p1721(){
		$data['message']='';
		$data['title']='PROSES LANJUTAN PELAPORAN MODEL 1721 A1';
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$this->template->display("payroll/generate/v_utama_all1721",$data);
		
	}
	
	function generate_p1721(){
		$tahun=$this->input->post('tahun');
		$kddept=$this->input->post('kddept');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$nodoktemp=$this->session->userdata('nik');
		$cek_exist=$this->m_generate->q_1721rekaptmpcek($nodoktemp,$kddept,$tahun,$kdgroup_pg)->num_rows();
		if($cek_exist>0){
				redirect("payroll/generate/utama_p1721/gr_failed/$tahun/$kddept/$kdgroup_pg");
				
		}else {
				$this->db->query("select sc_tmp.pr_generate_p1721('$tahun','$kddept','$nodoktemp','$kdgroup_pg')");
				$this->db->query("select sc_tmp.pr_hitungulang_p1721('$tahun', '$kddept', '$nodoktemp', '$kdgroup_pg')");
				$this->lihattmp_p1721($tahun,$kddept,$nodoktemp,$kdgroup_pg);
		}
		
		
	}
	
	function hitung_ulangp1721($tahun,$kddept,$nodoktemp,$kdgroup_pg){
		
		$this->db->query("select sc_tmp.pr_hitungulang_p1721('$tahun', '$kddept', '$nodoktemp', '$kdgroup_pg')");
		$this->detail_1721($tahun,$kddept,$kdgroup_pg);
	}
	function hitung_ulangp1721nik($tahun,$kddept,$kdgroup_pg,$nik){
		$nodoktemp=trim($this->session->userdata('nik'));
		$this->db->query("select sc_tmp.pr_hitungulang_p1721('$tahun', '$kddept', '$nodoktemp', '$kdgroup_pg')");
		$this->edit_nik1721($tahun,$nik,$kddept,$kdgroup_pg);
	}
	
	function lihattmp_p1721($tahun,$kddept1,$nodoktemp,$kdgroup_pg){
		$data['title']="REKAP PER DIVISI REPORT P1721 TAHUN $tahun";
		if($this->uri->segment(4)=="kode_failed")
            $message="<div class='alert alert-danger'>Anda Tidak Berhak Approval Dokumen Ini</div>";
        else if($this->uri->segment(9)=="rep_succes")
			$message="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $message="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $message="<div onload='app_succes'></div>";
		else if($this->uri->segment(5)=="cancel_succes")
            $message="<div class='alert alert-danger'>Dokumen Tidak Berhasil Diubah</div>";
		else if($this->uri->segment(9)=="edit_succes")
            $message="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $message='';		
		$data['tahun']=$tahun;$data['kddept']=$kddept1;$data['kdgroup_pg']=$kdgroup_pg;
		$kddept="and kddept='$kddept1'";
		$data['list_tmprekap1721']=$this->m_generate->q_1721rekaptmp($nodoktemp,$kddept,$tahun,$kdgroup_pg)->result();
		$this->template->display("payroll/generate/v_lihattmp1721",$data);
	}
	
	function alltmp_p1721(){
		$tahun=$this->input->post('tahun');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$nodoktemp=$this->session->userdata('nik');
		
		$kddept="";
		
		$data['title']="REKAP ALL BELUM FINAL DIVISI REPORT P1721 TAHUN $tahun";	
		$data['tahun']=$tahun;$data['kddept']=$kddept;$data['kdgroup_pg']=$kdgroup_pg;
		$data['list_tmprekap1721']=$this->m_generate->q_1721rekaptmp($nodoktemp,$kddept,$tahun,$kdgroup_pg)->result();
		$this->template->display("payroll/generate/v_lihattmp1721",$data);
	}
		
	function detail_1721($tahun,$kddept,$kdgroup_pg){
		$data['title']="DETAIL REKAP TAHUNAN REPORT P1721 TAHUN $tahun";	
		$nodoktemp=trim($this->session->userdata('nik'));
		$data['tahun']=$tahun;$data['kddept']=$kddept;$data['kdgroup_pg']=$kdgroup_pg;$data['nodoktemp']=$nodoktemp;
	
		$data['list_tmprekap1721']=$this->m_generate->q_1721detail($kddept,$tahun,$kdgroup_pg)->result();
		$this->template->display("payroll/generate/v_detail1721",$data);
	}

	
	function edit_nik1721($tahun,$nik,$kddept,$kdgroup_pg){
		//$nodok=$this->session->userdata('nik');
		if($this->uri->segment(4)=="kode_failed")
            $message="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
        else if($this->uri->segment(9)=="rep_succes")
			$message="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $message="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $message="<div onload='app_succes'></div>";
		else if($this->uri->segment(5)=="cancel_succes")
            $message="<div class='alert alert-danger'>Dokumen Tidak Berhasil Diubah</div>";
		else if($this->uri->segment(9)=="edit_succes")
            $message="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $message='';
		$title="List Detail Payroll Untuk Pelaporan Form 1721";	
		$data=array('nik' => $nik,'kddept' => $kddept,'kdgroup_pg' => $kdgroup_pg, 'title' => $title,'message' => $message,'tahun' => $tahun); 
		$data['list_nik']=$this->m_generate->q_1721detailnik($nik)->result();
		$data['dtl_kary']=$this->m_generate->list_karyawan_detail($nik)->row_array();
		
		$this->template->display("payroll/generate/v_edit_nik1721",$data);
		
		
	}

	function simpan_edit1721(){
		$nodoktemp=trim($this->session->userdata('nik'));
		$nik=$this->input->post('nik');
		$kddept=$this->input->post('kddept');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$no_urut=$this->input->post('no_urut');
		$tahun=$this->input->post('tahun');
		$nominal=str_replace("_","",$this->input->post('nominal'));
		$info=array( 'nominal' => $nominal
		);
		$this->db->where('nik',$nik);	
		$this->db->where('no_urut',$no_urut);	
		$this->db->update('sc_tmp.p1721_detail',$info);	
		$this->db->query("select sc_tmp.pr_hitungulang_p1721('$tahun', '$kddept', '$nodoktemp', '$kdgroup_pg')");
		$this->edit_nik1721($tahun,$nik,$kddept,$kdgroup_pg);
	}

	function final_1721($tahun,$kddept1,$kdgroup_pg){
		$nik=$this->session->userdata('nik');
		$nodoktemp=$nik;
		$kddept="and kddept='$kddept1'";
		$cek_nodok=$this->m_generate->q_1721rekaptmp($nodoktemp,$kddept,$tahun,$kdgroup_pg)->num_rows();
	if($cek_nodok=1){
				$this->db->where('kddept',$kddept1);
				$this->db->where('grouppenggajian',$kdgroup_pg);
				$this->db->where('nodok',$nodoktemp);
				$this->db->set('status','P');
				$this->db->update('sc_tmp.p1721_rekap');
		$this->lihattmp_p1721($tahun,$kddept1,$nodoktemp,$kdgroup_pg);		
		}else{
			redirect("payroll/generate/lihattmp_p1721/$tahun/$kddept1/$nodoktemp/$kdgroup_pg/kode_failed");
		}	
	}



	function template_form1721($nik,$kddept,$kdgroup_pg){
		
		$data['dtl_pph']=$this->m_generate->q_1721nik($nik,$kddept,$kdgroup_pg)->row_array();
		$data['dtl_kar']=$this->m_generate->q_dtl_kary($nik,$kddept,$kdgroup_pg)->row_array();
		
		$get_kontent=file_get_contents(base_url("/gridview/view_1721pdf/$nik/$kddept/$kdgroup_pg"));
		$this->load->view($get_kontent);
		//$this->pdf->load_view(file_get_contents(base_url("/gridview/view_1721pdf/$nik/$kddept/$kdgroup_pg")));
	//	$this->pdf->load_view("payroll/generate/v_form_1721_pdf",$data);
	/////////$this->pdf->load_view("payroll/generate/testpdf",$data);
	/////////$this->pdf->set_paper('F4','potrait');
	/////////$this->pdf->render();		
	/////////$this->pdf->stream(" $nik $kddept hingga $kdgroup_pg.pdf");			
		
	
		
		//$this->load->view("payroll/generate/testpdf",$data);
		//$this->load->view("payroll/generate/v_form_1721_pdf",$data);
	}
	


	
}	