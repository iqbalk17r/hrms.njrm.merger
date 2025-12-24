<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Final_payroll extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_final','m_generate'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_string')); 
        $this->load->helper(array('url')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Final Payroll Karyawan";
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
		
		//$data['list_karyawan']=$this->m_detail->list_karyawan()->result();
		
		$data['list_rekap']=$this->m_final->list_rekap($nodok)->result();
        $this->template->display('payroll/final/v_utama',$data);
    }
	
	function index_pph(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Final PPH Karyawan";
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
		
		//$data['list_karyawan']=$this->m_detail->list_karyawan()->result();
		
		$data['list_rekap']=$this->m_final->list_rekap_pph($nodok)->result();
        $this->template->display('payroll/final/v_utama_pph',$data);
    }
	
	function utama_setahun(){
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
		$data['title']="Halaman Master PPH (Setahun)";
		//$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		//$data['list_dept']=$this->m_generate->q_departmen()->result();
		$data['list_karyawan']=$this->m_final->list_karyawan()->result();
		$this->template->display('payroll/final/v_utama_setahun',$data);
	}
	
	function master($nodok){
		
		//$nodok=$this->session->userdata('nik');
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
		$data['list_master']=$this->m_final->list_master($nodok)->result();
		$data['list_rekap']=$this->m_final->list_rekap($nodok)->result();
		$data['nodok']=$nodok;
		//$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		//$nama=$karyawan['nmlengkap'];
		//$data['nama']=$nama;
		//$data['nik']=$nik;
	
		$this->template->display('payroll/final/v_list',$data);
		
	}
	
	function master_pph($nodok){
		
		//$nodok=$this->session->userdata('nik');
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
		$data['list_master']=$this->m_final->list_master_pph($nodok)->result();
		$data['list_rekap']=$this->m_final->list_rekap_pph($nodok)->result();
		$data['nodok']=$nodok;
		//$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		//$nama=$karyawan['nmlengkap'];
		//$data['nama']=$nama;
		//$data['nik']=$nik;
	
		$this->template->display('payroll/final/v_list_pph',$data);
		
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
		
		$data['title']="List Final Payroll";
		$data['list_master']=$this->m_detail->list_master($nik)->result();
		$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$data['nik']=$nik;
	
		//$data['list_lk']=$this->m_gaji_pokok->list_karyawan()->result();
		$this->template->display('payroll/detail/v_list',$data);
		
	}
	
	

	function detail($nodok,$nik){
		//echo $nodok;
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
		$data['title']="List Detail Payroll";	
		$data['nik']=$nik;
		$data['list_detail']=$this->m_final->list_detail($nodok,$nik)->result();
		$karyawan=$this->m_final->list_karyawan_detail($nik)->row_array();
		$total_upah=$this->m_final->total_gaji($nodok,$nik)->row_array();
		$data['total_upah']=$total_upah['total_upah1'];
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$data['nodok']=$nodok;
		
		$this->template->display('payroll/final/v_detail',$data);
	}
	
	function detail_pph($nodok,$nik){
		//echo $nodok;
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
		$data['title']="List Detail Payroll";	
		$data['nik']=$nik;
		$data['list_detail']=$this->m_final->list_detail_pph($nodok,$nik)->result();
		$karyawan=$this->m_final->list_karyawan_detail($nik)->row_array();
		$total_pajak=$this->m_final->total_pajak($nodok,$nik)->row_array();
		//$data['total_pajak']=$total_upah['total_pajak1'];
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$data['nodok']=$nodok;
		
		$this->template->display('payroll/final/v_detail_pph',$data);
	}
	
	function detail_setahun(){
		
		$nik=$this->input->post('karyawan');
		//echo 'test';
		//echo $nik;
		/*if (empty($nik)){
			redirect('payroll/final_payroll/utama_setahun');
		}*/
		
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
			
		$data['title']="List Detail PPH (Setahun)";	
		$data['nik']=$nik;
		$nmlengkap1=$this->m_final->list_karyawan_detail($nik)->row_array();
		$nmlengkap=$nmlengkap1['nmlengkap'];
		$data['nmlengkap']=$nmlengkap;
		$data['list_detail_setahun']=$this->m_final->q_detail_setahun($nik)->result();
		//$karyawan=$this->m_final->list_karyawan_detail($nik)->row_array();
		//$total_pajak=$this->m_final->total_pajak($nodok,$nik)->row_array();
		//$data['total_pajak']=$total_upah['total_pajak1'];
		//$nama=$karyawan['nmlengkap'];
		//$data['nama']=$nama;
		//$data['nodok']=$nodok;
		//echo 'test';
		$this->template->display('payroll/final/v_detail_setahun',$data);
	}
	
	function update_detail(){
		$no_urut=$this->input->post('no_urut');
		$nik=$this->input->post('nik');
		$nominal=str_replace("_","",$this->input->post('nominal'));
		
		$this->db->query("update sc_tmp.payroll_detail set nominal=$nominal where no_urut='$no_urut' and nik='$nik'");
		redirect("payroll/detail_payroll/detail/$nik/edit_succes");
	}

	
	function detail_tunjangan($no_urut1,$nik){
		
		$nodok=$this->session->userdata('nik');
		//echo $no_urut.'|'.$nik;
		$no_urut=trim($no_urut1);
		if ($no_urut=='4'){
			
			$data['title']="List Detail Potongan Absensi";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$data['detail_absensi']=$this->m_detail->q_absensi($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_absensi',$data);
		} else if ($no_urut=='6'){
			$data['title']="List Detail Upah Borong";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$data['detail_upah']=$this->m_detail->q_upah_borong($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_upah',$data);
		} else if ($no_urut=='10'){
			$data['title']="List Detail Tunjangan Shift";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
			$data['detail_shift']=$this->m_detail->q_shift($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_shift',$data);
		
		} else if ($no_urut=='11'){
			$data['title']="List Detail Tunjangan Lembur";
			$data['nik']=$nik;
			$data['no_urut']=$no_urut;
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
					$this->db->query("update sc_tmp.potongan_absen set nominal='$nominal' where urut=$urut");
					$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.potongan_absen
										where nik='$nik')
										where no_urut='4' and nik='$nik'");
					redirect("payroll/detail_payroll/detail/$nik/rep_succes");
				
		}
		function update_detail_borong(){
			$no_urut=$this->input->post('no_urut');
			$nik2=$this->input->post('nik');
			$tgl_kerja2=$this->input->post('tgl_kerja');
			$urut2=$this->input->post('urut');
			$nominal2=str_replace("_","",$this->input->post('nominal'));
			$this->db->query("update sc_tmp.payroll_borong set nominal='$nominal2' where urut=$urut2");
			$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.payroll_borong
								where nik='$nik2')
								where no_urut='6' and nik='$nik2'");
			redirect("payroll/detail_payroll/detail/$nik/rep_succes");
		
		
		
		}
				
		function update_detail_shift(){
			$no_urut=$this->input->post('no_urut');
			$nik=$this->input->post('nik');
			$tgl_kerja=$this->input->post('tgl_kerja');
			$urut=$this->input->post('urut');
			$nominal=str_replace("_","",$this->input->post('nominal'));
			$this->db->query("update sc_tmp.tunjangan_shift set nominal='$nominal' where urut=$urut");
			$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.tunjangan_shift
								where nik='$nik')
								where no_urut='10' and nik='$nik'");
			redirect("payroll/detail_payroll/detail/$nik/rep_succes");
		
		
		}	
			
		function update_detail_lembur(){
			$no_urut=$this->input->post('no_urut');
			$nik=$this->input->post('nik');
			$tgl_kerja=$this->input->post('tgl_kerja');
			$urut=$this->input->post('urut');
			$nominal=str_replace("_","",$this->input->post('nominal'));
			$this->db->query("update sc_tmp.detail_lembur set nominal='$nominal' where urut=$urut");
			$this->db->query("update sc_tmp.payroll_detail set nominal=(select sum(nominal) from sc_tmp.detail_lembur
								where nik='$nik')
								where no_urut='11' and nik='$nik'");
			redirect("payroll/detail_payroll/detail/$nik/rep_succes");
		
		} 
		
	
	
	function final_payroll($nodok){
		$periode_mulai=date('mY');
		$periode_akhir=date('mY');
		$this->db->query("update sc_tmp.payroll_rekap set status='P' where nodok='$nodok'");
		redirect('payroll/detail_payroll/master/rep_succes');
	
	}
	
	public function excel_report($nodok){
		
		$datane=$this->m_final->list_masterexcel($nodok);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Rekening', 'Gaji(Rp.)'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'norek','total_upah1'));
        $this->excel_generator->set_width(array(10,50,20,20));
        $this->excel_generator->exportTo2007('Master Payroll');
	}
	
	public function excel_report_pph($nodok){
		
		$datane=$this->m_final->list_master_pph($nodok);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Total Pajak (Rp.)'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap','total_pajak1'));
        $this->excel_generator->set_width(array(10,50,20));
        $this->excel_generator->exportTo2007("Master PPH $nodok");
	}
	
	function excel_report_detail($nodok){
		
		$datane=$this->m_final->q_report_payrolldetail($nodok);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Department','Rekening','Gaji Pokok (Rp.)','Tunjangan Jabatan (Rp.)', 
		'Tunjangan Masa Kerja (Rp.)','Tunjangan Prestasi (Rp.)','Tunjangan Shift (Rp.)','Lembur (Rp.)','Upah Borong (Rp.)','Insentif Produksi (Rp.)','Bonus (Rp.)',
		'THR (Rp.)','Koreksi Bulan Lalu (Rp.)','JKK (Rp.)','JKM (Rp.)', 'Total Gaji Bruto (Rp.)',
		'JHT (Rp.)','JP (Rp.)','BPJS Kesehatan (Rp.)','Potongan Absensi (Rp.)','Potongan ID card (Rp.)','Potongan Lain (Rp.)'
		,'PPH 21 (Rp.)','Potongan Koprasi (Rp.)','THP (Rp.)'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'nmdept','norek','gajipokok','tj_jabatan','tj_masakerja','tj_prestasi','tj_shift',
		'lembur','upah_borong','insentif_produksi','bonus','thr','koreksibulanlalu','jkk','jkm','gajikotor','jht','jp','bpjs','ptg_absensi','ptg_idcard','ptg_lain','pph21','ptg_koperasi','totalupah'));
        $this->excel_generator->set_width(array(10,40,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Detail Payroll $nodok");
	}
	
	function excel_report_detail_borong($nodok){
		
		$datane=$this->m_final->q_report_payrolldetail_borong($nodok);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Department','Rekening','Gaji Pokok (Rp.)','Tunjangan Jabatan (Rp.)', 
		'Tunjangan Masa Kerja (Rp.)','Tunjangan Prestasi (Rp.)','Tunjangan Shift (Rp.)','Lembur (Rp.)','Upah Borong (Rp.)','Insentif Produksi (Rp.)','Bonus (Rp.)',
		'THR (Rp.)','Koreksi Bulan Lalu (Rp.)','JKK (Rp.)','JKM (Rp.)', 'Total Gaji Bruto (Rp.)',
		'JHT (Rp.)','JP (Rp.)','BPJS Kesehatan (Rp.)','Potongan Absensi (Rp.)','Potongan ID card (Rp.)','Potongan Lain (Rp.)'
		,'PPH 21 (Rp.)','THP (Rp.)'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'nmdept','norek','gajipokok','tj_jabatan','tj_masakerja','tj_prestasi','tj_shift',
		'lembur','upah_borong','insentif_produksi','bonus','thr','koreksibulanlalu','jkk','jkm','gajikotor','jht','jp','bpjs','ptg_absensi','ptg_idcard','ptg_lain','pph21','totalupah'));
        $this->excel_generator->set_width(array(10,40,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Detail Payroll $nodok");
	}
	
	function excel_payroll_detail($nik,$nodok){
		
		//echo $nodok;
		$datane=$this->m_final->list_detail_excel($nodok,$nik);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Komponen', 'Keterangan', 'Nominal (Rp.)'));
        $this->excel_generator->set_column(array('keterangan', 'uraian', 'nominal1'));
        $this->excel_generator->set_width(array(30,30,30));
        $this->excel_generator->exportTo2007("Detail Payroll $nik");
	}
	
	function excel_pph_detailbulanan($nik,$nodok){
		
		//echo $nodok;
		$datane=$this->m_final->list_detail_pph($nodok,$nik);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Komponen', 'Keterangan', 'Nominal (Rp.)'));
        $this->excel_generator->set_column(array('keterangan', 'uraian', 'nominal1'));
        $this->excel_generator->set_width(array(30,30,30));
        $this->excel_generator->exportTo2007("Detail PPH $nik");
	}
	
	function excel_pph_detail($nik){
		
		//echo $nodok;
		$datane=$this->m_final->q_detail_setahun($nik);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Komponen', 'Januari (Rp.)','Februari (Rp.)','Maret (Rp.)',
		'April (Rp.)','Mei (Rp.)','Juni (Rp.)','Juli (Rp.)',
		'Agustus (Rp.)','September (Rp.)','Oktober (Rp.)','November (Rp.)','Desember (Rp.)'));
        $this->excel_generator->set_column(array('keterangan','januari','februari','maret','april','mei','juni',
		'juli','agustus','september','oktober','november','desember'));
        $this->excel_generator->set_width(array(30,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Detail PPH $nik");
	}
	
	function download_pdf($nik,$nodok){
		$tahun1=substr($nodok,5,-2);
		$tahun='20'.$tahun1;
		$bulan=substr($nodok,7);
		$periode=$tahun.'-'.$bulan;
		//echo $periode;
		
		$data['periode']=$periode;
		$data['lo']=$this->m_final->q_slipgaji($nodok,$nik)->row_array();
		$data['li']=$this->m_final->list_karyawan_detail($nik)->row_array();
        
        $this->pdf->load_view('payroll/final/v_slipgaji',$data);
        $this->pdf->set_paper('f4','potrait');
        $this->pdf->render();       
        $this->pdf->stream("Slip Gaji.pdf");
        //redirect('web/index/add_succes');       
    }
	
	function edit_final($nodok){
		$user=trim($this->session->userdata('nik'));
		$kddept1=$this->db->query("select trim(kddept) as kddept from sc_trx.payroll_rekap where nodok='$nodok'")->row_array();
		$periode1=$this->db->query("select to_char(periode_akhir,'MM') as periode from sc_trx.payroll_rekap where nodok='$nodok'")->row_array();
		$keluarkerja1=$this->db->query("select to_char(periode_akhir,'YYYYMM') as keluarkerja from sc_trx.payroll_rekap where nodok='$nodok'")->row_array();
		$kddept=$kddept1['kddept'];
		$periode=$periode1['periode'];
		$keluarkerja=$keluarkerja1['keluarkerja'];
		$bulan1=$this->db->query("select cast(to_char(periode_akhir,'MM')as integer) as bulan from sc_trx.payroll_rekap where nodok='$nodok'")->row_array();
		$bulan=$bulan1['bulan'];
		$tahun1=$this->db->query("select to_char(periode_akhir,'YYYY') as tahun from sc_trx.payroll_rekap where nodok='$nodok'")->row_array();
		$tahun=$tahun1['tahun'];
		$nodokpph=$kddept.$tahun.'-'.$bulan;
		$kdgroup_pg='P1';
		$this->db->query("insert into sc_tmp.payroll_rekap
						  select * from sc_trx.payroll_rekap where nodok='$nodok'");
		$this->db->query("insert into sc_tmp.payroll_master
						select * from sc_trx.payroll_master where nodok='$nodok'
						");				  
		$this->db->query("insert into sc_tmp.payroll_detail
						select * from sc_trx.payroll_detail where nodok='$nodok'
						");
				
		$this->db->query("update sc_tmp.payroll_rekap set nodok='$user',status='I' where nodok='$nodok'");
		$this->db->query("update sc_tmp.payroll_master set nodok='$user' where nodok='$nodok'");
		$this->db->query("update sc_tmp.payroll_detail set nodok='$user' where nodok='$nodok'");
		$this->db->query("delete from sc_trx.payroll_rekap where nodok='$nodok'");				
		$this->db->query("delete from sc_trx.payroll_master where nodok='$nodok'");				
		$this->db->query("delete from sc_trx.payroll_detail where nodok='$nodok'");	
		$this->db->query("delete from sc_trx.p21_rekap where nodok='$nodokpph'");				
		$this->db->query("delete from sc_trx.p21_master where nodok='$nodokpph'");				
		$this->db->query("delete from sc_trx.p21_detail where nodok='$nodokpph'");				
		redirect("payroll/detail_payroll/master/$kdgroup_pg/$kddept/$periode/$keluarkerja");
	}
	
	function download_exceldetailnyamping($nodok){ 
		$this->db->query("delete from sc_his.pph21rekap");
		$this->m_final->q_exceldetail_pph21($nodok);
		$datane=$this->db->query("select * from sc_his.pph21rekap order by nama asc");
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'NAMA','GAJI POKOK','TUNJANGAN JABATAN','TUNJANGAN MASA KERJA','TUNJANGAN PRESTASI','TUNJANGAN SHIFT','TUNJANGAN LAIN-LAIN','UPAH BORONG PROGRESIF','LEMBUR','PENGOBATAN','JKK',
		'JKM','BPJS KESEHATAN - PERUSAHAAN','SUBTOTAL PENGHASILAN REGULAR','PENGHASILAN NON REGULAR','SUBTOTAL PENGHASILAN BRUTO','BIAYA JABATAN','JHT - KARYAWAN','JP - KARYAWAN','SUBTOTAL POTONGAN','TOTAL PENGHASILAN NETTO',
		'PENGHASILAN REGULAR S/D BULAN BERJALAN','PROYEKSI SISA PENGHASILAN REGULAR TAHUN BERJALAN','TOTAL PERKIRAAN PENGHASILAN REGULAR DISETAHUNKAN','PENGHASILAN NON REGULAR S/D BULAN BERJALAN','TOTAL PERKIRAAN PENGHASILAN BRUTO DISETAHUNKAN','BIAYA JABATAN (DARI PENGHASILAN YANG DISETAHUNKAN)','POTONGAN JHT S/D BULAN BERJALAN','PROYEKSI SISA POTONGAN JHT S/D AKHIR TAHUN','POTONGAN JP S/D BULAN BERJALAN','PROYEKSI SISA POTONGAN JP S/D AKHIR TAHUN',
		'TOTAL POTONGAN DISETAHUNKAN','TOTAL PENGHASILAN NETTO (DISETAHUNKAN)','PTKP','PKP DISETAHUNKAN','PERHITUNGAN PPH 21 (SETAHUN)','BIAYA JABATAN (REGULER)','POTONGAN JHT REGULER','PROYEKSI SISA POTONGAN JHT REGULER','POTONGAN JP REGULER','PROYEKSI SISA POTONGAN JP REGULER',
		'TOTAL POTONGAN DISETAHUNKAN(REGULER)','TOTAL PENGHASILAN NETTO (DISETAHUNKAN) REGULER','PTKP REGULER','PKP DISETAHUNKAN REGULER','PERHITUNGAN PPH 21 (SETAHUN) REGULER','RATIO PENGHASILAN BRUTO BULAN BERJALAN','RATIO PENGHASILAN BRUTO BULAN S/D BULAN BERJALAN','PPH 21 BULAN BERJALAN','PPH 21 S/D BULAN BERJALAN','SELISIH',
		'PPH 21 BULAN BERJALAN (BELUM NORMALISASI)','PPH 21 KURANG DIBAYAR S/D BULAN BERJALAN','SELISIH (2-1)','SISA BULAN AMORTISASI','AMORTISASI BULAN BERJALAN','PPH 21 BULAN BERJALAN DINORMALISASI','PPH 21 PENGHASILAN DISETAHUNKAN (ALL)','PPH 21 PENGHASILAN DISETAHUNKAN (REGULER)','PPH 21 PENGHASILAN DISETAHUNKAN (NON REGULER)','PPH 21 PENGHASILAN NON REGULAR BULAN BERJALAN',
		'PPH 21 PENGHASILAN REGULAR','PPH 21 PENGHASILAN NON REGULAR','TOTAL PPH 21'));
        $this->excel_generator->set_column(array('nik','nama','k01','k02','k03','k04','k05','k06','k07','k08','k09','k10',
		'k11','k12','k13','k14','k15','k16','k17','k18','k19','k20',
		'k21','k22','k23','k24','k25','k26','k27','k28','k29','k30',
		'k31','k32','k33','k34','k35','k36','k37','k38','k39','k40',
		'k41','k42','k43','k44','k45','k46','k47','k48','k49','k50',
		'k51','k52','k53','k54','k55','k56','k57','k58','k59','k60',
		'k61','k62','k63'));
        $this->excel_generator->set_width(array(20,30,20,20,20,20,20,20,20,20,
												20,30,20,20,20,20,20,20,20,20,
												20,30,20,20,20,20,20,20,20,20,
												20,30,20,20,20,20,20,20,20,20,
												20,30,20,20,20,20,20,20,20,20,
												20,30,20,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Report Detail PPH 21 $nodok");
	}
	
	/*pph21 p1721 */
	
	function utama_view_p1721(){
		$data['message']='';
		$data['title']='REPORT FINAL PELAPORAN MODEL 1721 A1';
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();
		$this->template->display("payroll/final/v_utama_all1721",$data);
		
	}
	
	function alltrx_p1721(){
		$tahun1=$this->input->post('tahun');
		$kdgroup_pg1=$this->input->post('kdgroup_pg');
		if(empty($tahun1) and empty($kdgroup_pg1)){
			$tahun2=$this->uri->segment(4);
			$kdgroup_pg2=$this->uri->segment(5);
			$tahun=$tahun2; $kdgroup_pg=$kdgroup_pg2;
		} else {
			$tahun=$tahun1; $kdgroup_pg=$kdgroup_pg1;
		}
		
		$data['title']="REKAP ALL SESUDAH FINAL DIVISI REPORT P1721 TAHUN $tahun";	
		$data['tahun']=$tahun;$data['kdgroup_pg']=$kdgroup_pg;
		$data['list_trxrekap1721']=$this->m_final->q_1721rekaptrx($tahun,$kdgroup_pg)->result();
		$this->template->display("payroll/final/v_lihattrx1721",$data);
	}
/*	
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
		$data['list_tmprekap1721']=$this->m_final->q_1721rekaptmp($nodoktemp,$kddept,$tahun,$kdgroup_pg)->result();
		$this->template->display("payroll/generate/v_lihattmp1721",$data);
	}
	
*/
		
	function detail_1721($tahun,$kddept,$kdgroup_pg){
		$data['title']="DETAIL REKAP TAHUNAN REPORT P1721 TAHUN $tahun";	
		$nodoktemp=trim($this->session->userdata('nik'));
		$data['tahun']=$tahun;$data['kddept']=$kddept;$data['kdgroup_pg']=$kdgroup_pg;$data['nodoktemp']=$nodoktemp;
	
		$data['list_tmprekap1721']=$this->m_final->q_1721detail($kddept,$tahun,$kdgroup_pg)->result();
		$this->template->display("payroll/final/v_detail1721",$data);
	}

	
	function detail_nik1721($tahun,$nik,$kddept,$kdgroup_pg){
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
		$data['list_nik']=$this->m_final->q_1721detailnik($nik)->result();
		$data['dtl_kary']=$this->m_final->list_karyawan_detail($nik)->row_array();
		$this->template->display("payroll/final/v_detail_nik1721",$data);
		
		
	}
/*
	function simpan_edit1721(){
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
		
		$this->edit_nik1721($tahun,$nik,$kddept,$kdgroup_pg);
	}

	function final_1721($tahun,$kddept1,$kdgroup_pg){
		$nik=$this->session->userdata('nik');
		$nodoktemp=$nik;
		$kddept="and kddept='$kddept1'";
		$cek_nodok=$this->m_final->q_1721rekaptmp($nodoktemp,$kddept,$tahun,$kdgroup_pg)->num_rows();
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

*/


	function template_form1721($nik,$kddept,$kdgroup_pg){
		
		$data['dtl_pph']=$this->m_final->q_1721nik($nik,$kddept,$kdgroup_pg)->row_array();
		$data['dtl_kar']=$this->m_final->q_dtl_kary($nik,$kddept,$kdgroup_pg)->row_array();
	
		
	//$json_data1=$this->m_final->q_1721nik($nik,$kddept,$kdgroup_pg)->result();
	//$json_data2=$this->m_final->q_dtl_kary($nik,$kddept,$kdgroup_pg)->result();
	//header('Content-Type: application/json');


	//echo json_encode(array('master'=>$json_data1,'detail'=>$json_data2),JSON_PRETTY_PRINT);
	
	//$get_kontent=file_get_contents("http://php.net/manual/en/function.file-get-contents.php");
	
	//$get_kontent=file_get_contents(base_url("/gridview/view_1721pdf/$nik/$kddept/$kdgroup_pg"));
	//$this->load->view($get_kontent);
//	$this->pdf->load_view($get_kontent);
	////	$this->pdf->load_view("payroll/generate/v_form_1721_pdf",$data);
	//$this->pdf->load_view("payroll/final/testpdf",$data);
	//$this->pdf->set_paper('A4','potrait');
	//$this->pdf->render();		
	//$this->pdf->stream(" $nik $kddept hingga $kdgroup_pg.pdf");			
		
	
	//$this->fiky_string->coba();
	//$this->load->view("payroll/final/testpdf",$data);
	$this->load->view("payroll/final/v_form_1721_pdf",$data);
	}
	
	
	

}	