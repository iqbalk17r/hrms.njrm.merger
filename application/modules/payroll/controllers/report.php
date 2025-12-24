<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Report extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_report','m_final','m_generate','m_ceklembur','trans/m_absensi'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Master Report";
		
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
		$data['list_master']=$this->m_report->q_master_report()->result();	
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_ceklembur->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();		
        $this->template->display('payroll/report/v_utama',$data);
    }
	
	function absensi(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Report Absensi";
		
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
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_ceklembur->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();	
			
        $this->template->display('payroll/report/v_absensi',$data);
    }
	
	function payroll(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Report Payroll";
		
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
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_ceklembur->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();	
			
        $this->template->display('payroll/report/v_payroll',$data);
    }
	
	function pph(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Report PPH";
		
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
		$data['list_group']=$this->m_generate->q_group_penggajian()->result();
		$data['list_karyawan']=$this->m_ceklembur->list_karyawan()->result();
		$data['list_dept']=$this->m_generate->q_departmen()->result();	
			
        $this->template->display('payroll/report/v_pph',$data);
    }
	
	function show_karout(){
		$data['title']="List Karyawan Keluar";
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		
		
		
		switch ($bln){
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
		
		$periode=$thn.$bln;
		$data['list_karout']=$this->m_report->list_karout($periode)->result();
		$data['jumlah']=$this->m_report->list_karout($periode)->num_rows();
		$data['periode']=$periode;
		$this->template->display('payroll/report/v_show_karout',$data);
		
	}
	
	function show_karin(){
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		
		
		
		switch ($bln){
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
		$data['title']="List Karyawan Masuk Periode Bulan $bul Tahun $thn";
		$periode=$thn.$bln;
		$data['list_karin']=$this->m_report->list_karin($periode)->result();
		$data['jumlah']=$this->m_report->list_karin($periode)->num_rows();
		$data['periode']=$periode;
		$this->template->display('payroll/report/v_show_karin',$data);
		
	}
	
	function show_transready(){
		$nik=$this->input->post('nik');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tglawal=$tgl[0];
		$tglakhir=$tgl[1];
		
		$tgl1=date('Y-m-d',strtotime($tglawal));
		$tgl2=date('Y-m-d',strtotime($tglakhir));
		
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}
		
		switch ($ketsts){
			case " is not null": $ketsts2='01'; break;
			case "='TERLAMBAT'": $ketsts2='02'; break;
			case "='TIDAK MASUK KERJA'": $ketsts2='03'; break;
			
		}
		
		
		$data['title']="Laporan Presensi Karyawan  Periode Tanggal $tglawal S/D $tglakhir";
		$data['list_absen']=$this->m_absensi->q_transready($nik,$tgl1,$tgl2,$ketsts)->result();
		$data['nik']=$nik;
		$data['tgl1']=$tgl1;
		$data['tgl2']=$tgl2;
		$data['ketsts']=trim($ketsts2);
		$this->template->display('payroll/report/v_show_transready',$data);
		
		
		
		
	}
	
	function show_transreadydept(){
		$kddept=$this->input->post('kddept');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tglawal=$tgl[0];
		$tglakhir=$tgl[1];
		
		$tgl1=date('Y-m-d',strtotime($tglawal));
		$tgl2=date('Y-m-d',strtotime($tglakhir));
		
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}
		
		switch ($ketsts){
			case " is not null": $ketsts2='01'; break;
			case "='TERLAMBAT'": $ketsts2='02'; break;
			case "='TIDAK MASUK KERJA'": $ketsts2='03'; break;
			
		}
		
		
		$data['title']="Laporan Presensi Department  Periode Tanggal $tglawal S/D $tglakhir";
		$data['list_absen']=$this->m_absensi->q_transready_dept($kddept,$tgl1,$tgl2,$ketsts)->result();
		$data['kddept']=$kddept;
		$data['tgl1']=$tgl1;
		$data['tgl2']=$tgl2;
		$data['ketsts']=trim($ketsts2);
		$this->template->display('payroll/report/v_show_transreadydept',$data);
		
		
		
		
	}
	
	function show_checkinout(){
		$nik=$this->input->post('nik');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tglawal=$tgl[0];
		$tglakhir=$tgl[1];
		
		$tgl1=date('Y-m-d',strtotime($tglawal));
		$tgl2=date('Y-m-d',strtotime($tglakhir));
		
		
		
		$data['title']="Laporan Absensi Mesin Periode Tanggal $tglawal S/D $tglakhir";
		
		$data['list_absen']=$this->m_report->q_absensimesin($nik,$tgl1,$tgl2)->result();
		$data['tgl1']=$tgl1;
		$data['tgl2']=$tgl2;
		$this->template->display('payroll/report/v_show_checkinout',$data);
		
		
	}
	
	function show_report_absensi(){
		$bln=$this->input->post('bln');
		$thn=$this->input->post('thn');
		$this->m_absensi->q_prreportabsensi($bln,$thn);
		$data['list_absen']=$this->m_absensi->excel_reportabsensi($bln,$thn)->result();
		
 	
		$data['title']="Laporan Presensi Bulan $bln Tahun $thn";
		
		$data['bln']=$bln;
		$data['thn']=$thn;
		$this->template->display('payroll/report/v_show_reportabsensi',$data);
		
	}
	
	function show_payrollsetahun(){
		
		$tahun=$this->input->post('tahun');
		
		
		$data['title']="Laporan Payroll Tahunan  Periode  Tahun 20$tahun";
		$data['list_payroll']=$this->m_report->q_reportpayrollsetahun($tahun)->result();
		$data['tahun']=$tahun;
		$this->template->display('payroll/report/v_show_payrollsetahun',$data);
       
		//echo $nik.'-'.$tahun;
		
		
	}
	
	function show_detail_payrollnik(){
		$nik=$this->input->post('nik');
		$tahun=$this->input->post('tahun');
		
		
		
		$data['list_payroll']=$this->m_report->q_detailpayrollsetahun($nik,$tahun)->result();
        $data['title']="Report Payroll Tahunan nik $nik tahun 20$tahun";
		$data['nik']=$nik;
		$data['tahun']=$tahun;
		$this->template->display('payroll/report/v_show_detailpayrollsetahun',$data);
		//echo $nik.'-'.$tahun;
		
		
	}
	
	function show_report_detail(){
		
		$bln=$this->input->post('bulan');
		$thn=$this->input->post('tahun');
		$periode=$thn.$bln;
		$data['list_payroll']=$this->m_report->q_reportpayrollbulanan($periode)->result();
		$data['title']="Report Detail Payroll Periode $periode";
		$data['periode']=$periode;
		$this->template->display('payroll/report/v_show_payrolldetail',$data);
	}
	
	function show_pphdetailbulanan(){ 
		$bulan=$this->input->post('bulan');
		$this->db->query("delete from sc_his.pph21rekap");
		$this->m_report->q_detailpphsebulan($bulan);
		$data['list_payroll']=$this->db->query("select * from sc_his.pph21rekap order by nama asc")->result();
       /*$this->excel_generator->set_query($datane);
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
        $this->excel_generator->exportTo2007("Report Detail PPH 21 Periode Bulan $bulan");*/
		$data['title']="Report Detail PPH 21 Periode Bulan  $bulan";
		$data['bulan']=$bulan;
		$this->template->display('payroll/report/v_show_pphdetailbulanan',$data);
	}
	
	function show_pph_detail(){
		
		$nik=$this->input->post('nik');
		$data['list_payroll']=$this->m_final->q_detail_setahun($nik)->result();
        /*$this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Komponen', 'Januari (Rp.)','Februari (Rp.)','Maret (Rp.)',
		'April (Rp.)','Mei (Rp.)','Juni (Rp.)','Juli (Rp.)',
		'Agustus (Rp.)','September (Rp.)','Oktober (Rp.)','November (Rp.)','Desember (Rp.)'));
        $this->excel_generator->set_column(array('keterangan','januari','februari','maret','april','mei','juni',
		'juli','agustus','september','oktober','november','desember'));
        $this->excel_generator->set_width(array(30,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Detail PPH $nik");*/
		$data['title']="Report Detail PPH 21 nik $nik";
		$data['nik']=$nik;
		$this->template->display('payroll/report/v_show_pphdetail',$data);
	}
	
	
	function excel_karout($periode){
		
		/*$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		
		
		
		switch ($bln){
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
		
		$periode=$thn.$bln;*/
		$datane=$this->m_report->q_karout($periode);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'NAMA LENGKAP', 'TANGGAL KELUAR', 'DEPARTMENT/BAGIAN'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'tglkeluarkerja','nmdept'));
        $this->excel_generator->set_width(array(10,40,20,20));
        $this->excel_generator->exportTo2007("Report Karyawan Keluar Periode $periode");
		
	}
	
	
	
	function excel_karin(){
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		
		
		
		switch ($bln){
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
		
		$periode=$thn.$bln;
		$datane=$this->m_report->q_karin($periode);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'NAMA LENGKAP', 'TANGGAL MASUK', 'DEPARTMENT/BAGIAN'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'tglmasukkerja','nmdept'));
        $this->excel_generator->set_width(array(10,40,20,20));
        $this->excel_generator->exportTo2007("Report Karyawan Masuk Periode $bul tahun $thn");
		
	}
	
	function excel_transready($nik,$tgl1,$tgl2,$ketsts){
		/*$nik=$this->input->post('nik');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tglawal=$tgl[0];
		$tglakhir=$tgl[1];
		
		$tgl1=date('Y-m-d',strtotime($tglawal));
		$tgl2=date('Y-m-d',strtotime($tglakhir));
		
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}*/
		
		
		
		switch ($ketsts){
			case "01": $ketsts1=' is not null'; break;
			case "02": $ketsts1="='TERLAMBAT'"; break;
			case "03": $ketsts1="='TIDAK MASUK KERJA'"; break;
			
		}
		
		$datane=$this->m_absensi->q_transready($nik,$tgl1,$tgl2,$ketsts1);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'NAMA LENGKAP', 'TANGGAL KERJA','SHIFT', 'JAM MASUK', 'JAM PULANG','KETERANGAN','DOKUMEN CUTI','DOKUMEN IJIN'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'tgl','shiftke','jam_masuk_absen','jam_pulang_absen','ketsts','ketcuti','ketijin'));
        $this->excel_generator->set_width(array(10,40,30,20,30,30,40,40,40));
        $this->excel_generator->exportTo2007("Report Presensi Karyawan Periode $tgl1 S/D $tgl2");
		
		//echo $tgl1.'-'.$nik.'-'.$ketsts;
		
		
	}
	
	function excel_transreadydept($kddept,$tgl1,$tgl2,$ketsts){
		/*$kddept=$this->input->post('kddept');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tglawal=$tgl[0];
		$tglakhir=$tgl[1];
		
		$tgl1=date('Y-m-d',strtotime($tglawal));
		$tgl2=date('Y-m-d',strtotime($tglakhir));
		
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}*/
		
		switch ($ketsts){
			case "01": $ketsts1=' is not null'; break;
			case "02": $ketsts1="='TERLAMBAT'"; break;
			case "03": $ketsts1="='TIDAK MASUK KERJA'"; break;
			
		}
		
		
		
		$datane=$this->m_absensi->q_transready_dept($kddept,$tgl1,$tgl2,$ketsts1);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'NAMA LENGKAP', 'TANGGAL KERJA','SHIFT', 'JAM MASUK', 'JAM PULANG','KETERANGAN','DOKUMEN CUTI','DOKUMEN IJIN'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'tgl','shiftke','jam_masuk_absen','jam_pulang_absen','ketsts','ketcuti','ketijin'));
        $this->excel_generator->set_width(array(10,40,30,20,30,30,40,40,40));
        $this->excel_generator->exportTo2007("Report Presensi Department Periode $tgl1 S/D $tgl2");
		
		//echo $tgl1.'-'.$nik.'-'.$ketsts;
		
		
	}
	
	function excel_checkinout($tgl1,$tgl2){
		/*$nik=$this->input->post('nik');
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tglawal=$tgl[0];
		$tglakhir=$tgl[1];
		
		$tgl1=date('Y-m-d',strtotime($tglawal));
		$tgl2=date('Y-m-d',strtotime($tglakhir));
		
		*/
		
		
		
		$datane=$this->m_report->q_absensimesin($nik,$tgl1,$tgl2);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('BADGENUMBER', 'NAMA LENGKAP', 'DEPARTMENT/BAGIAN','TANGGAL KERJA','JAM'));
        $this->excel_generator->set_column(array('badgenumber', 'nmlengkap','nmdept', 'tgl','jam'));
        $this->excel_generator->set_width(array(10,40,30,20,20));
        $this->excel_generator->exportTo2007("Report Absensi Karyawan (Dari Mesin) Periode $tgl1 S/D $tgl2");
		
		//echo $tgl1.'-'.$nik.'-'.$ketsts;
		
		
	}
	
	function excel_detail_payrollnik($nik,$tahun){
		//$nik=$this->input->post('nik');
		//$tahun=$this->input->post('tahun');
		
		
		
		$datane=$this->m_report->q_detailpayrollsetahun($nik,$tahun);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('KETERANGAN', 'JANUARI', 'FEBRUARI','MARET', 'APRIL', 'MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'));
        $this->excel_generator->set_column(array('keterangan', 'januari', 'februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'));
        $this->excel_generator->set_width(array(30,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Report Payroll Tahunan nik $nik tahun 20$tahun");
		
		//echo $nik.'-'.$tahun;
		
		
	}
	
	function excel_payrollsetahun($tahun){
		
		//$tahun=$this->input->post('tahun');
		
		
		
		$datane=$this->m_report->q_reportpayrollsetahun($tahun);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK','NAMA LENGKAP', 'JANUARI', 'FEBRUARI','MARET', 'APRIL', 'MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap','januari', 'februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'));
        $this->excel_generator->set_width(array(10,30,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Report Payroll Tahunan  Periode 20$tahun");
		
		//echo $nik.'-'.$tahun;
		
		
	}
	
	function excel_report_pph($nodok){
		
		$datane=$this->m_final->list_master_pph($nodok);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Total Pajak (Rp.)'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap','total_pajak1'));
        $this->excel_generator->set_width(array(10,50,20));
        $this->excel_generator->exportTo2007("Master PPH $nodok");
	}
	
	function excel_report_detail($periode){
		
		//$bln=$this->input->post('bulan');
		//$thn=$this->input->post('tahun');
		//$periode=$thn.$bln;
		$datane=$this->m_report->q_reportpayrollbulanan($periode);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Department','Rekening','Gaji Pokok (Rp.)','Tunjangan Jabatan (Rp.)', 
		'Tunjangan Masa Kerja (Rp.)','Tunjangan Prestasi (Rp.)','Tunjangan Shift (Rp.)','Lembur (Rp.)','Upah Borong (Rp.)','Insentif Produksi (Rp.)','Bonus (Rp.)',
		'THR (Rp.)','Koreksi Bulan Lalu (Rp.)','JKK (Rp.)','JKM (Rp.)', 'Total Gaji Bruto (Rp.)',
		'JHT (Rp.)','JP (Rp.)','BPJS Kesehatan (Rp.)','Potongan Absensi (Rp.)','Potongan ID card (Rp.)','Potongan Lain (Rp.)'
		,'PPH 21 (Rp.)','THP (Rp.)'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'nmdept','norek','gajipokok','tj_jabatan','tj_masakerja','tj_prestasi','tj_shift',
		'lembur','upah_borong','insentif_produksi','bonus','thr','koreksibulanlalu','jkk','jkm','gajikotor','jht','jp','bpjs','ptg_absensi','ptg_idcard','ptg_lain','pph21','totalupah'));
        $this->excel_generator->set_width(array(10,40,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Report Detail Payroll Periode $periode");
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
		
		//$nik=$this->input->post('nik');
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
	
	function pdf_slipgaji(){
		$nik=$this->input->post('nik');
		$tahun=$this->input->post('tahun');
		$tahun1='20'.$tahun;
		$bulan=$this->input->post('bulan');
		$nodok=$tahun.$bulan;
		$periode=$tahun1.'-'.$bulan;
		//echo $periode;
		
		$data['periode']=$periode;
		$data['lo']=$this->m_report->q_slipgaji($nik,$nodok)->row_array();
		$data['li']=$this->m_final->list_karyawan_detail($nik)->row_array();
        
        $this->pdf->load_view('payroll/final/v_slipgaji',$data);
        $this->pdf->set_paper('f4','potrait');
        $this->pdf->render();       
        $this->pdf->stream("Slip Gaji.pdf");
		
        //echo $nodok;      
    }
	
	
	function excel_pphdetailbulanan($bulan){ 
		//$bulan=$this->input->post('bulan');
		//$this->db->query("delete from sc_his.pph21rekap");
		//$this->m_report->q_detailpphsebulan($bulan);
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
        $this->excel_generator->exportTo2007("Report Detail PPH 21 Periode Bulan $bulan");
	}
	
	function excel_report_absensi($bln,$thn){
		//$bln=$this->input->post('bln');
		//$thn=$this->input->post('thn');
		$this->m_absensi->q_prreportabsensi($bln,$thn);
		$info=$this->m_absensi->excel_reportabsensi($bln,$thn);
        $this->excel_generator->set_query($info);
		$this->excel_generator->set_header(array('NIK','NAMALENGKAP','DEPARTMENT','JABATAN','REGU',
												'tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
												'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31',
												'SHIFT2','SHIFT3','ALPHA','CUTI','IJIN KHUSUS'	
												));
 	    $this->excel_generator->set_column(array('nik','nmlengkap','nmdept','nmjabatan','kdregu',
												'tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
												'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31',
												'shift2','shift3','alpha','cuti','ijin'
												));
        $this->excel_generator->set_width(array(12,20,20,20,10,
												6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,
												6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,	
												6,6,6,6,6
												));
        $this->excel_generator->exportTo2007("REPORT ABSENSI BULAN $bln TAHUN $thn");
		
	}

}	