<?php
/*
	@author : excel
	18-03-2015
*/
error_reporting(0);

class Report extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
        $this->load->model(array('m_geografis','m_report'));
        $this->load->library(array('form_validation','template','upload','Excel_generator','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Filter Laporan HRD";		
		$data['kantor']=$this->m_report->q_kantor()->result();
		$data['qlaporan']=$this->m_report->q_laporan()->result();
        $this->template->display('trans/report/view_filter_reporthrd',$data);
    }
	
	function filter(){
		 $tahun=$this->input->post('tahun'); 
		 $bulan=$this->input->post('bulan'); 
		 $kantor=$this->input->post('kantor'); 
		 $laporan=$this->input->post('laporan');
		$periode=$tahun.$bulan;
		switch ($bulan){
			case 01:$bln='Januari'; break;
			case 02:$bln='Februari'; break;
			case 03:$bln='Maret'; break;
			case 04:$bln='April'; break;
			case 05:$bln='Mei'; break;
			case 06:$bln='Juni'; break;
			case 07:$bln='Juli'; break;
			case 08:$bln='Agustus'; break;
			case 09:$bln='September'; break;
			case 10:$bln='Oktober'; break;
			case 11:$bln='November'; break;
			case 12:$bln='Desember'; break;
		}
		
		switch($laporan){
			case 'MP':
				$data['title']="Filter Man Power";
				$data['list_manpower']=$this->m_report->q_man_power($tahun,$bulan)->result();
				$this->template->display('trans/report/view_manpower',$data);
				break;
			case 'DM':
				$data['title']="Detail MAN POWER $bln $tahun";				
				$data['list_detmp']=$this->m_reporthrd->q_detail_mp($tahun,$bulan)->result();				
				$this->template->display('trans/report/view_detailmp',$data);
				break;
			case 'SK':
				$data['title']="Status Kepegawaian $bln $tahun";
				$data['list_stspeg']=$this->m_reporthrd->q_status_kepegawaian($tahun,$bulan)->result();		
				$data['ttl_stspeg']=$this->m_reporthrd->q_total_status_kepegawaian($tahun,$bulan)->row_array();		
				$data['chart']=$this->m_reporthrd->q_chart()->result();
				$this->template->display('trans/report/view_stskepegawaian',$data);
				break;
			case 'TO':
				$data['title']="Turn Over $bln $tahun";
				$data['periode']=$periode;
				$data['kantor']=$kantor;
				$data['list_turnover']=$this->m_reporthrd->q_turn_over($periode,$kantor)->result();
				$this->template->display('trans/report/view_turn_over',$data);
				break;
			case 'AR':redirect("trans/report/attendance_report/$periode"); break;
			case 'DA':redirect('trans/report/detail_attendance'); break;
			case 'KS':
				$data['title']="Filter Karyawan Selesai Kontrak $bln $tahun";
				$data['list_karslskontrak']=$this->m_reporthrd->q_kar_slskontrak($tahun,$bulan)->result();
				$this->template->display('trans/report/view_kar_slskontrak',$data);
				break;
			case 'LP':redirect('trans/report/lap_pemakaianatk'); break;
			case 'SA':redirect('trans/report/stock_atk'); break;
			case 'MC':redirect('trans/report/mtc_cost'); break;
			case 'LR':redirect("trans/report/late_report/$periode/$kantor"); break;
			case 'LI':redirect("trans/report/ijin_report/$periode"); break;
			case 'LC':redirect("trans/report/cuti_report/$periode"); break;
			case 'IS':redirect("trans/report/izin_sakit/$periode"); break;
			case 'LL':redirect("trans/report/lembur_report/$periode"); break;
			
			
		}

		if (empty($tahun)){
			redirect('trans/report',$data);
		}		
	}
	
	function attendance_report($periode){
		
		$bulan=substr(trim($periode),4);
        //$nama = trim($this->session->userdata('nik'));
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		//echo $periode;die();

		$data['title']="Laporan Presensi Periode Bulan $bln Tahun $tahun ";
		//$this->db->query("select sc_trx.pr_reportabsen_user('$bulan','$tahun','$nama')");
		$data['list_att']=$this->m_report->q_att_new($periode)->result();
		
		$data['periode']=$periode;
		//$data['kantor']=$kantor;
		$this->template->display('trans/report/view_attandance',$data);
	}
	
	function detail_attendance(){
		$data['title']="Filter Detail Attendance";
		$data['list_turnover']=$this->m_reporthrd->q_turn_over()->result();
		$this->template->display('hrd/report/view_turn_over',$data);
	}
	function lap_pemakaianatk(){
		$data['title']="Filter Laporan Pemakaian ATK";
		$data['list_pemakaianatk']=$this->m_reporthrd->q_lap_pemakaianatk()->result();
		$this->template->display('hrd/report/view_pemakaianatk',$data);
	}
	function stock_atk(){
		$data['title']="Filter Stock ATK";
		$data['list_stockatk']=$this->m_reporthrd->q_stock_atk()->result();
		$this->template->display('hrd/report/view_stokatk',$data);
	}
	function mtc_cost(){
		$data['title']="Filter MTC Cost";
		$data['list_mstccost']=$this->m_reporthrd->q_mtc_cost()->result();
		$this->template->display('hrd/report/view_mtccost',$data);
	}
	
	function late_report($periode,$kantor){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		switch (trim($kantor)){
			case 'NAS':$ktr='NASIONAL'; break;
			case 'SBYMRG':$ktr='SURABAYA'; break;
			case 'SMGDMK':$ktr='DEMAK'; break;
			case 'SMGCND':$ktr='SEMARANG'; break;
			case 'JKTKPK':$ktr='JAKARTA'; break;
			
		}
		
		
		$data['title']="Laporan Keterlambatan Periode Bulan $bln Tahun $tahun Kantor NUSA $ktr";
		$data['periode']=$periode;
		$data['kantor']=$kantor;
		$data['list_att']=$this->m_report->q_late_report_new($periode,$kantor)->result();
		//$cl=$this->m_reporthrd->q_late_report($periode)->row_array();
		$this->template->display('trans/report/view_latereport',$data);
		//echo $cl;
	}
	
	function ijin_report($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		$data['title']="Laporan Ijin Karyawan Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_ijin']=$this->m_report->q_ijin_report($periode)->result();
		$this->template->display('trans/report/view_ijinreport',$data);
	
	}
	
	function lembur_report($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		$data['title']="Laporan Lembur Karyawan Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_ijin']=$this->m_report->q_lembur_report($periode)->result();
		$this->template->display('trans/report/view_lemburreport',$data);
	
	}
	
	
	function cuti_report($periode){

		$bulan=substr(trim($periode),4);

		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}

		$data['title']="Laporan Cuti Karyawan Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_cuti']=$this->m_report->q_cuti_report($periode)->result();
		$this->template->display('trans/report/view_cutireport',$data);

	}
	
	function izin_sakit($periode){

		$bulan=substr(trim($periode),4);

		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}

		$data['title']="Laporan Cuti Khusus Keterangan Dokter Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_cuti']=$this->m_report->izin_sakit($periode)->result();
		$this->template->display('trans/report/view_izin_sakit',$data);
		
	}
	
	function excel_late($periode,$kantor){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		switch (trim($kantor)){
			case 'NAS':$ktr='NASIONAL'; break;
			case 'SBYMRG':$ktr='SURABAYA'; break;
			case 'SMGDMK':$ktr='DEMAK'; break;
			case 'SMGCND':$ktr='SEMARANG'; break;
			case 'JKTKPK':$ktr='JAKARTA'; break;
			
		}
		
		
		$datane=$this->m_report->q_late_report_new($periode,$kantor);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK','Nama Karyawan','Tanggal Absen', 'Jam Absen','Durasi Keterlambatan','Ref Doc'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap','tgl', 'jam_masuk_absen','total_terlambat','nodok_ref'));
        $this->excel_generator->set_width(array(20,30,20,20,30,10));
        $this->excel_generator->exportTo2007("Laporan Keterlambatan Periode Bulan $bln Tahun $tahun Tahun $tahun Kantor NUSA $ktr");
	}
	
	function excel_ijin($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_report->q_ijin_report_excel($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Karyawan', 'Department', 'No. Dokumen',
		'Nama Ijin','Tanggal Ijin','Jam Mulai','Jam Akhir','Keterangan',));
        $this->excel_generator->set_column(array('nmlengkap', 'nmdept', 'nodok_new','nmijin_absensi','tgl_kerja','tgl_jam_mulai'
		,'tgl_jam_selesai','keterangan'));
        $this->excel_generator->set_width(array(40,20,20,30,20,20,20,40));
        $this->excel_generator->exportTo2007("Laporan Ijin Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_cuti($periode){
		
		$bulan=substr(trim($periode),4);

		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}

		///$datane=$this->m_report->q_cuti_report_excel($periode);
		$datane=$this->m_report->q_cuti_report($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('No','Nik','Nama Karyawan','Department','Sub Department','Regu','jabatan','Group Penggajian','Tanggal Masuk Kerja',
		'No. Dokumen','Tipe Cuti','Nama Ijin Khusus','Tanggal Mulai','Tanggal Selesai','Keterangan','Jumlah Cuti','Sisa Cuti'));
        $this->excel_generator->set_column(array('no','nik','nmlengkap','nmdept','nmsubdept','nmregu','nmjabatan','grouppenggajian','tglmasukkerja','nodok','tpcuti',
		'nmijin_khusus','tgl_mulai','tgl_selesai','keterangan','jumlah_cuti','sisacuti'));
        $this->excel_generator->set_width(array(10,10,40,40,40,30,30,10,30,30,20,20,60,10,10));
        $this->excel_generator->exportTo2007("Laporan Cuti Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_lembur($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_report->q_lembur_report_excel($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Karyawan', 'Department', 'No. Dokumen',
		'Tanggal Lembur','Jam Mulai','Jam Akhir','Durasi','Keterangan',));
        $this->excel_generator->set_column(array('nmlengkap', 'nmdept', 'nodok_new','tgl_kerja1','jammulai'
		,'jamselesai','durasi','keterangan'));
        $this->excel_generator->set_width(array(40,20,20,20,20,20,20,40));
        $this->excel_generator->exportTo2007("Laporan Lembur Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_izin_sakit($periode){
		
		$bulan=substr(trim($periode),4);

		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}

		///$datane=$this->m_report->q_cuti_report_excel($periode);
		$datane=$this->m_report->izin_sakit($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('No','Nik','Nama Karyawan','Department','Sub Department','Regu','jabatan','Group Penggajian','Tanggal Masuk Kerja',
		'No. Dokumen','Nama Ijin Absensi','Tanggal Kerja','Keterangan'));
        $this->excel_generator->set_column(array('no','nik','nmlengkap','nmdept','nmsubdept','nmregu','nmjabatan','grouppenggajian','tglmasukkerja','nodok',
		'nmijin_absensi','tgl_kerja','keterangan'));
        $this->excel_generator->set_width(array(10,10,40,40,40,30,30,10,30,30,20,20,60,10,10));
        $this->excel_generator->exportTo2007("Laporan Izin Surat Keterangan Dokter Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_attendence($periode){
        $bulan=substr(trim($periode),4);

        $tahun=substr($periode,0,4);
        switch (trim($bulan)){
            case '01':$bln='Januari'; break;
            case '02':$bln='Februari'; break;
            case '03':$bln='Maret'; break;
            case '04':$bln='April'; break;
            case '05':$bln='Mei'; break;
            case '06':$bln='Juni'; break;
            case '07':$bln='Juli'; break;
            case '08':$bln='Agustus'; break;
            case '09':$bln='September'; break;
            case '10':$bln='Oktober'; break;
            case '11':$bln='November'; break;
            case '12':$bln='Desember'; break;
        }

        $datane=$this->m_report->q_att_new($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('No','NIK','Nama Lengkap','Departemen','Sub Department','Regu','Jabatan','Group Penggajian','Tgl Masuk Kerja','Jumlah Jadwal','Cuti',
            'Cuti Potong Gaji','Cuti Khusus','Izin Datang Terlambat','Izin Pulang Awal','Izin Keluar','Izin Sakit','Alpha','Datang Terlambat','Pulang Awal','Dinas',
			'Cuti Bersama','Jumlah Cuti Terpakai','Sisa Cuti'));
        $this->excel_generator->set_column(array('no','nik','nmlengkap','nmdept','nmsubdept','nmregu','nmjabatan','grouppenggajian','tglmasukkerja','jumlah_jadwal','cuti','cuti_ptggaji',
			'cuti_khusus','izin_dt','izin_pa','izin_keluar','izin_sakit','alpha','dt','pa','dinas','cuti_bersama','cuti_terpakai','sisa_cuti'));
        $this->excel_generator->set_width(array(10,10,40,40,40,40,40,10,20,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10));
        $this->excel_generator->exportTo2007("Laporan Absensi Periode Bulan $bln Tahun $tahun");

    }
	
	function download_pdf_to($tahun,$bulan){
		
		
		//$data['periode']=$periode;
		$data['title']="Turn Over $bulan $tahun";
		$data['list_turnover']=$this->m_reporthrd->q_turn_over($tahun,$bulan)->result();
        
        $this->pdf->load_view('hrd/report/view_turn_over',$data);
        $this->pdf->set_paper('f4','potrait');
        $this->pdf->render();       
        $this->pdf->stream("Turn Over.pdf");
        //redirect('web/index/add_succes');       
    }
	
	function excel_turnover($periode,$kantor){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_reporthrd->q_turnover_excel($periode,$kantor);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Kantor', 'Keterangan','NIP','Nama Karyawan',
		'Department','Sub Department','Jabatan','Tanggal Masuk','Tanggal Keluar','Pendidikan Terakhir'));
        $this->excel_generator->set_column(array('desc_cabang','status', 'nip', 'nmlengkap','departement','subdepartement','deskripsi','masuk','keluar','desc_pendidikan'));
        $this->excel_generator->set_width(array(30,20,10,30,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Laporan Turn Over Periode Bulan $bln Tahun $tahun");
	
	}

    function op_index(){
        $data['title']="Filter Laporan OP";
        $data['idbu']=$this->m_report->q_idbu()->result();
        $this->template->display('trans/report/view_filter_reportop',$data);
    }

    function op_filter(){
        $idbu = $this->input->post('idbu');
        $tanggal_awal = explode(" - ", $this->input->post('tanggal'))[0];
        $tanggal_selesai = explode(" - ", $this->input->post('tanggal'))[1];
        $tanggal_awal = date_format(date_create($tanggal_awal),"Y-m-d");
        $tanggal_selesai = date_format(date_create($tanggal_selesai),"Y-m-d");

        $data['title'] = "Filter Laporan OP";
        $data["idbu"] = $idbu;
        $data["tanggal_awal"] = $tanggal_awal;
        $data["tanggal_selesai"] = $tanggal_selesai;
        $this->template->display('trans/report/view_op',$data);
    }

    function op_json($idbu, $tanggal_awal, $tanggal_selesai){
        $idbu = $this->input->get('idbu');
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_selesai = $this->input->get('tanggal_selesai');
        $data['list_op']=$this->m_report->q_op($idbu, $tanggal_awal, $tanggal_selesai)->result();
//        $bulan = [
//            1 => 'Januari',
//                 'Februari',
//                 'Maret',
//                 'April',
//                 'Mei',
//                 'Juni',
//                 'Juli',
//                 'Agustus',
//                 'September',
//                 'Oktober',
//                 'November',
//                 'Desember'
//        ];
        $list_op = [];
        $no = 1;
        foreach($data['list_op'] as $v) {
//            $tanggal = implode(" ", [
//                explode("-", $v->orderdate)[2],
//                $bulan[(int)explode("-", $v->orderdate)[1]],
//                explode("-", $v->orderdate)[0]
//            ]);
            $tanggal = date_format(date_create($v->orderdate),"d-m-Y");
            $list_op[] = [
                $no,
                trim($v->nip),
                trim($v->nmlengkap),
                trim($v->areaname),
                $tanggal,
                number_format($v->jmlorder,0,",","."),
                trim($v->orderid),
                trim($v->status)
            ];
            $no++;
        }
        echo json_encode($list_op);
    }
	
}
