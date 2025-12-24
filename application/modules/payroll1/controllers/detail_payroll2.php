<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Detail_payroll extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_detail','m_generate'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Proses Cut Off Payroll";
		$nodok=$this->session->userdata('nik');
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
			
		//$thn=$this->input->post('tahun');
		//$bln=$this->input->post('bulan');		
		//$nik=$this->input->post('nik');		
		
		//$data['list_gp']=$this->m_detail->q_gaji_pokok($nik)->result();	
		
		$data['list_karyawan']=$this->m_detail->list_karyawan()->result();
		$data['list_departmen']=$this->m_detail->list_department()->result();
		
		
        $this->template->display('payroll/detail/v_utama',$data);
    }
	
	
	
	function tangkap(){
		$kdgroup_pg=$this->input->post('grouppenggajian');
		$kddept=$this->input->post('kddept');
		$periode=$this->input->post('periode');
		$tahun=$this->input->post('tahun');
		$keluarkerja=$tahun.$periode;
		redirect("payroll/detail_payroll/master/$kdgroup_pg/$kddept/$periode/$keluarkerja");	
	}
	
	function tangkap_pph(){
		$kdgroup_pg=$this->input->post('grouppenggajian');
		$kddept=$this->input->post('kddept');
		$periode=$this->input->post('periode');
		$tahun=$this->input->post('tahun');
		$keluarkerja=$tahun.$periode;
		redirect("payroll/detail_payroll/master_pph/$kdgroup_pg/$kddept/$periode/$keluarkerja");	
	}
	
	
	function index_pph(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Proses Countinue Generate PPH 21";
		$nodok=$this->session->userdata('nik');
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
			
		//$thn=$this->input->post('tahun');
		//$bln=$this->input->post('bulan');		
		//$nik=$this->input->post('nik');		
		
		//$data['list_gp']=$this->m_detail->q_gaji_pokok($nik)->result();	
		
		$data['list_karyawan']=$this->m_detail->list_karyawan()->result();
		$data['list_departmen']=$this->m_detail->list_department()->result();
		
		
        $this->template->display('payroll/detail/v_utama_21',$data);
    }
	
	
	
	function master(){
		
		$nodok=trim($this->session->userdata('nik'));
		//echo $kdgroup_pg;
		//echo $kddept;
		//echo $periode;
		if($this->uri->segment(8)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Proses Generate Dibatalkan Terdapat Data Yang Salah</div>";
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
		
		$data['title']="STEP 1";
		
		//$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		//$nama=$karyawan['nmlengkap'];
		//$data['nama']=$nama;
		//$data['nik']=$nik;
		$kdgroup_pg=trim($this->uri->segment(4));
		$kddept=trim($this->uri->segment(5));
		$periode=trim($this->uri->segment(6));
		$keluarkerja=trim($this->uri->segment(7));
		$data['nodok']=$nodok;
		$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['periode']=$periode;
		$data['keluarkerja']=$keluarkerja;
		$data['list_master']=$this->m_detail->list_master($nodok,$kddept,$periode)->result();
		$data['list_rekap']=$this->m_detail->list_rekap($nodok,$kddept,$periode)->result();
		$data['list_karyawan_new']=$this->m_detail->list_karyawan_susulan($kdgroup_pg,$kddept)->result();
		//echo $keluarkerja;
		$this->template->display('payroll/detail/v_list',$data);
		
	}
	
	function master_old(){
		$nik=$this->input->post('karyawan');
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
		
		$data['title']="List Master Payroll";
		$data['list_master']=$this->m_detail->list_master($nik)->result();
		$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$data['nik']=$nik;
	
		//$data['list_lk']=$this->m_gaji_pokok->list_karyawan()->result();
		$this->template->display('payroll/detail/v_list',$data);
		
	}
	
	
	
	
	function master_pph(){
		
		$nodok=$this->session->userdata('nik');
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
		
		$data['title']="STEP 2";
		
		//$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		//$nama=$karyawan['nmlengkap'];
		//$data['nama']=$nama;
		//$data['nik']=$nik;
		$data['nodok']=$nodok;
		$kdgroup_pg=$this->uri->segment(4);
		$kddept=$this->uri->segment(5);
		$periode=$this->uri->segment(6);
		$keluarkerja=$this->uri->segment(7);
		$data['nodok']=$nodok;
		$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['periode']=$periode;
		$data['keluarkerja']=$keluarkerja;
		$data['list_master']=$this->m_detail->list_master_pph($nodok,$kddept)->result();
		$data['list_rekap']=$this->m_detail->list_rekap_pph($nodok,$kddept)->result();
		$this->template->display('payroll/detail/v_list_pph',$data);
		
	}
	
	function detail($nik){
		$nodok=$this->session->userdata('nik');
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
        else if($this->uri->segment(9)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(5)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Tidak Berhasil Diubah</div>";
		else if($this->uri->segment(9)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['title']="List Detail Payroll";	
		$data['nik']=$nik;
		$data['list_detail']=$this->m_detail->list_detail($nik,$nodok)->result();
		$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$kdgroup_pg=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
		$periode=$this->uri->segment(7);
		$keluarkerja=$this->uri->segment(8);
		$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['periode']=$periode;
		$data['keluarkerja']=$keluarkerja;
		$this->template->display('payroll/detail/v_detail',$data);
	}
	
	function detail_pph($nik){
		$nodok=$this->session->userdata('nik');
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(5)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Tidak Berhasil Diubah</div>";
		else if($this->uri->segment(5)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['title']="List Detail PPH 21";	
		$data['nik']=$nik;
		$data['list_detail']=$this->m_detail->list_detail_pph($nik,$nodok)->result();
		$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$data['nodok']=$nodok;
		$kdgroup_pg=$this->uri->segment(5);
		$kddept=$this->uri->segment(6);
		$periode=$this->uri->segment(7);
		$keluarkerja=$this->uri->segment(8);
		$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['periode']=$periode;
		$data['keluarkerja']=$keluarkerja;
		$this->template->display('payroll/detail/v_detail_pph',$data);
	}
	
	function update_detail(){
		$no_urut=$this->input->post('no_urut');
		$nik=$this->input->post('nik');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$kddept=$this->input->post('kddept');
		$periode=$this->input->post('periode');
		$keluarkerja=$this->input->post('keluarkerja');
		$nominal=str_replace("_","",$this->input->post('nominal'));
		
		$this->db->query("update sc_tmp.payroll_detail set nominal=$nominal where no_urut='$no_urut' and nik='$nik'");
		$this->db->query("update sc_mst.dtlgaji_karyawan  set nominal=$nominal where no_urut='$no_urut' and nik='$nik'");
		redirect("payroll/detail_payroll/detail/$nik/$kdgroup_pg/$kddept/$periode/$keluarkerja/edit_succes");
	}

	
	function detail_tunjangan($no_urut1,$nik){
		
		$nodok=$this->session->userdata('nik');
		//echo $no_urut.'|'.$nik;
		$no_urut=trim($no_urut1);
		
		if ($no_urut=='4'){
			
			$data['title']="List Detail Potongan Absensi";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$kdgroup_pg=$this->uri->segment(6);
			$kddept=$this->uri->segment(7);
			$periode=$this->uri->segment(8);
			$keluarkerja=$this->uri->segment(9);
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;
			$data['periode']=$periode;
			$data['keluarkerja']=$keluarkerja;
			$data['detail_absensi']=$this->m_detail->q_absensi($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_absensi',$data);
		} else if ($no_urut=='6'){
			$data['title']="List Detail Upah Borong";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$kdgroup_pg=$this->uri->segment(6);
			$kddept=$this->uri->segment(7);
			$periode=$this->uri->segment(8);
			$keluarkerja=$this->uri->segment(9);
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;
			$data['periode']=$periode;
			$data['keluarkerja']=$keluarkerja;
			$data['detail_upah']=$this->m_detail->q_upah_borong($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_upah',$data);
		} else if ($no_urut=='10'){
			$data['title']="List Detail Tunjangan Shift";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$kdgroup_pg=$this->uri->segment(6);
			$kddept=$this->uri->segment(7);
			$periode=$this->uri->segment(8);
			$keluarkerja=$this->uri->segment(9);
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;
			$data['periode']=$periode;
			$data['keluarkerja']=$keluarkerja;
			$data['detail_shift']=$this->m_detail->q_shift($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_shift',$data);
		
		} else if ($no_urut=='11'){
			$data['title']="List Detail Tunjangan Lembur";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$kdgroup_pg=$this->uri->segment(6);
			$kddept=$this->uri->segment(7);
			$periode=$this->uri->segment(8);
			$keluarkerja=$this->uri->segment(9);
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;
			$data['periode']=$periode;
			$data['keluarkerja']=$keluarkerja;
			$data['detail_lembur']=$this->m_detail->q_lembur($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_lembur',$data);
		
		} else {
			redirect("payroll/detail_payroll/detail/$nik");
		
		}
		
	
	}
	
		function update_detail_absen(){
				$no_urut=$this->input->post('no_urut');
				$nik=$this->input->post('nik');
				$tgl_kerja=$this->input->post('tgl_kerja');
				$urut=$this->input->post('urut');
				$nominal=str_replace("_","",$this->input->post('nominal'));
				$kdgroup_pg=$this->input->post('kdgroup_pg');
				$kddept=$this->input->post('kddept');
				$periode=$this->input->post('periode');
				$this->db->query("update sc_tmp.cek_absen set nominal='$nominal' where urut=$urut");
				$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.potongan_absen
									where nik='$nik')
									where no_urut='4' and nik='$nik'");
				redirect("payroll/detail_payroll/detail/$nik/$kdgroup_pg/$kddept/$periode/rep_succes");
				
		}
		function update_detail_borong(){
			$no_urut=$this->input->post('no_urut');
			$nik2=$this->input->post('nik');
			$tgl_kerja2=$this->input->post('tgl_kerja');
			$urut2=$this->input->post('urut');
			$nominal2=str_replace("_","",$this->input->post('nominal'));
			$kdgroup_pg=$this->input->post('kdgroup_pg');
			$kddept=$this->input->post('kddept');
			$periode=$this->input->post('periode');
			$this->db->query("update sc_tmp.cek_borong set total_upah='$nominal2' where urut=$urut2");
			$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(total_upah) from sc_tmp.cek_borong
								where nik='$nik2')
								where no_urut='6' and nik='$nik2'");
			redirect("payroll/detail_payroll/detail/$nik2/$kdgroup_pg/$kddept/$periode/rep_succes");
		
		
		
		}
				
		function update_detail_shift(){
			$no_urut=$this->input->post('no_urut');
			$nik=$this->input->post('nik');
			$tgl_kerja=$this->input->post('tgl_kerja');
			$urut=$this->input->post('urut');
			$nominal=str_replace("_","",$this->input->post('nominal'));
			$kdgroup_pg=$this->input->post('kdgroup_pg');
			$kddept=$this->input->post('kddept');
			$periode=$this->input->post('periode');
			$this->db->query("update sc_tmp.tunjangan_shift set nominal='$nominal' where urut=$urut");
			$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.tunjangan_shift
								where nik='$nik')
								where no_urut='10' and nik='$nik'");
			redirect("payroll/detail_payroll/detail/$nik/$kdgroup_pg/$kddept/$periode/rep_succes");
		
		
		}	
			
		function update_detail_lembur(){
			$no_urut=$this->input->post('no_urut');
			$nik=$this->input->post('nik');
			$tgl_kerja=$this->input->post('tgl_kerja');
			$urut=$this->input->post('urut');
			$nominal=str_replace("_","",$this->input->post('nominal'));
			$kdgroup_pg=$this->input->post('kdgroup_pg');
			$kddept=$this->input->post('kddept');
			$periode=$this->input->post('periode');
			$this->db->query("update sc_tmp.cek_lembur set nominal='$nominal' where urut=$urut");
			$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.detail_lembur
								where nik='$nik')
								where no_urut='11' and nik='$nik'");
			redirect("payroll/detail_payroll/detail/$nik/$kdgroup_pg/$kddept/$periode/rep_succes");
		
		} 
		
	
	
	function final_payroll($nodok,$kdgroup_pg,$kddept,$periode,$keluarkerja){
		//$periode_mulai=date('mY');
		//$periode_akhir=date('mY');
		//$tgl1=$this->m_detail->q_tglperiode($nodok)->row_array();
		//$tgl=$tgl1['periode_akhir'];
		//$periode=date('m',strtotime($tgl));
		$this->harap_tunggu1($kdgroup_pg,$kddept,$periode,$keluarkerja);
		//$this->generate_pph($kdgroup_pg,$kddept,$periode,$keluarkerja);
		
	
	}
	
	function harap_tunggu1($kdgroup_pg,$kddept,$periode,$keluarkerja){
			//echo 'HARAP TUNGGU...';
			$data['title']="HARAP TUNGGU";
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;
			$data['periode']=$periode;
			$data['keluarkerja']=$keluarkerja;
			$this->template->display('payroll/detail/v_harap_tunggu_pph',$data);
			
		/*	$page = $_SERVER['HTTP_HOST'];
			$sec = "3";
			header("Refresh: $sec; url=http://$page/nbi/payroll/detail_payroll/generate_pph/$kdgroup_pg/$kddept/$periode/$keluarkerja");
		*/
	}
	
	
	function generate_pph($kdgroup_pg,$kddept,$periode,$keluarkerja){
	
		//$this->delete_tmp_21($kddept);
		///$periode=date('m',strtotime($tglakhirfix));
		$nodok=$this->session->userdata('nik');
		$data=$this->m_generate->list_karyawan_new($kdgroup_pg,$kddept,$keluarkerja)->result();
		//$keluarkerja=date('Y').$keluarkerja1;
		//INSERT REKAP
		$cek_p21rekap=$this->m_detail->cek_p21rekap($nodok,$periode,$kddept)->num_rows();
		if ($cek_p21rekap==0) {
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
		}
		$this->db->query("
		delete from sc_mst.trxerror where userid='$nodok' and modul='PPH21_GEN';
		insert into sc_mst.trxerror (userid,errorcode,modul) values ('$nodok','1','PPH21_GEN');");
		
		/*foreach ($data as $dt) {
			$nik=$dt->nik;
			$tglkeluarkerja1=$dt->tglkeluarkerja;
			if (empty($tglkeluarkerja1)) {
				$bulankeluar=12;
			} else {
				$bulankeluar=date('m',strtotime($tglkeluarkerja1));
			}
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
					'kddept'=>$kddept,
				
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
				/*if (trim($tipe)=='LINK'){
				//$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','$no_urut'.'.chr(39).$nodok.chr(39).') as nominal';
				//$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).') as nominal';
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).','.$periode.','.$bulankeluar.') as nominal';
					//echo $txt.'<br>';
					$pr=$this->db->query($txt)->row_array();
				//$gajipokok=$pr['nominal'];
				//echo $gajipokok;
				
				} else if (trim($tipe)=='OTOMATIS'){
				
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).','.$periode.','.$bulankeluar.') as nominal';
					$pr=$this->db->query($txt)->row_array();
				
				} 
				
			}
		
		
		}*/
		
		//redirect('payroll/generate/utama/rep_succes');
		
		$txt='select sc_tmp.pr_generate_p21('.chr(39).trim($nodok).chr(39).','.$periode.','.chr(39).trim($keluarkerja).chr(39).','.chr(39).$kdgroup_pg.chr(39).','.chr(39).$kddept.chr(39).') as nominal';
		
		$this->db->query($txt);
	//	redirect("payroll/detail_payroll/master_pph/$kdgroup_pg/$kddept/$periode/$keluarkerja");
		$cektrx=$this->m_detail->cektrx($nodok)->num_rows();
		
	//	if($cektrx>0){
					$output = array(
					"success"=> TRUE,
					"status" => TRUE,
							//"url" => 'dashboard',						
							);
					echo json_encode($output);
			
	/* 	} else {
					$output = array(
					"success"=> FALSE,
					"status" => FALSE,
							//"url" => 'dashboard',						
							);
					echo json_encode($output);
			
		}
 */
	
	
    }

	function delete_tmp_21($kddept){
		$nodok=$this->session->userdata('nik');
		$this->db->query("delete from sc_tmp.p21_rekap where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.p21_master where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.p21_detail where nodok='$nodok' and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
	}	
	
	function final_pph($nodok,$kddept){
		$periode_mulai=date('mY');
		$periode_akhir=date('mY');
		$this->db->query("update sc_tmp.payroll_rekap set status='P' where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("update sc_tmp.p21_rekap set status='P' where nodok='$nodok' and kddept='$kddept'");
		redirect('payroll/final_payroll/index/rep_succes');
	
	}
	
	public function excel_pph($nodok){
		
		$datane=$this->m_detail->list_master_pph($nodok);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Potongan PPH 21', 'Gaji Netto'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'total_pajak1','gaji_netto1'));
        $this->excel_generator->set_width(array(10,20,20,20));
        $this->excel_generator->exportTo2007('Master PPH 21');
	}
	
	public function excel_pph_detail($nik,$nodok){
		
		$datane=$this->m_detail->list_detail_pph($nik,$nodok);
        $this->excel_generator->set_query($datane);
        //$this->excel_generator->set_header('NIK KARYAWAN'.$nik);
        $this->excel_generator->set_header(array('Nama Komponen', 'Keterangan', 'Nominal (Rp.)'));
        $this->excel_generator->set_column(array('keterangan', 'uraian', 'nominal1'));
        $this->excel_generator->set_width(array(20,20,20));
        $this->excel_generator->exportTo2007("Detail PPH 21 $nik");
	}
	
	function clear_tmp($nodok,$kddept){

		$this->db->query("delete from sc_tmp.payroll_rekap where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.payroll_master where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.payroll_detail where nodok='$nodok' and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
		redirect("payroll/generate/utama");
	}
	
	function generate_tmp_new(){
		$tgl=$this->input->post('tgl');
		$periode=$this->input->post('periode');
		$keluarkerja=$this->input->post('keluarkerja');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$kddept=$this->input->post('kddept');
		$nik=$this->input->post('nik');
		$nodok=$this->session->userdata('nik');
		$bulan=substr($keluarkerja,-2);
		$tahun=substr($keluarkerja,0,-2);
		$querytglawal=$this->m_generate->q_tglclosingawal()->row_array();
		$tglawal=$querytglawal['value3'];
		$querytglakhir=$this->m_generate->q_tglclosingakhir()->row_array();
		$tglakhir=$querytglakhir['value3'];
		$tglref=$tglakhir.'-'.$bulan.'-'.$tahun; 
		$tgl=$bulan.$tahun;
			
		
		
		$tglakhirfix=date('Y-m-d',strtotime($tglref));
		$tgl3=date('Y-m-d',strtotime('-1 month',strtotime($tglref)));	
		$tgl4=date('Y',strtotime($tgl3));
		$tgl5=date('m',strtotime($tgl3));
		$tglawalfix=$tgl4.'-'.$tgl5.'-'.$tglawal;
		
		//$periode=date('m',strtotime($tglakhirfix));
		//$keluarkerja=date('Ym',strtotime($tglakhirfix));
		
		$dt1=$this->m_detail->list_karyawan_detail($nik)->row_array();
		$tglkeluarkerja=$dt1['tglkeluarkerja'];
		
			
			$periode_akhir=$tglakhirfix;
			$periode_mulai=$tglawalfix;
			//insert master 
				$master=array(
					'nodok'=>$this->session->userdata('nik'),
					'nik'=>$nik,
					'input_by'=>$this->session->userdata('nik'),
					'input_date'=>date('Y-m-d H:i:s'),
					'periode_mulai'=>$periode_mulai,
					'periode_akhir'=>$periode_akhir,
					'tglkeluarkerja'=>$tglkeluarkerja,
					'kddept'=>$kddept,
				
				);
			$this->db->insert('sc_tmp.payroll_master',$master);
			
			$data_formula=$this->m_generate->q_setup_formula()->result();
			foreach ($data_formula as $dtf){
			
				$no_urut=$dtf->no_urut;
				$keterangan=$dtf->keterangan;
				$tipe=$dtf->tipe;
				$aksi_tipe=$dtf->aksi_tipe;
				$nodok=$this->session->userdata('nik');
				if (trim($tipe)=='LINK'){
				
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					$pr=$this->db->query($txt)->row_array();
				
				} else if (trim($tipe)=='OTOMATIS'){
				
					$txt='select '.$aksi_tipe.'('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					$pr=$this->db->query($txt)->row_array();
				
				} else {
					$txt='select sc_trx.pr_input_global('.chr(39).trim($nik).chr(39).','.$no_urut.','.chr(39).trim($nodok).chr(39).') as nominal';
					$pr=$this->db->query($txt)->row_array();
					
				}
				
			}
		
			
			
			
		redirect("payroll/detail_payroll/master/$kdgroup_pg/$kddept/$periode/$keluarkerja");
    }

}	