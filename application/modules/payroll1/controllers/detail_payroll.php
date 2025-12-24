<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Detail_payroll extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_detail','m_generate','master/m_akses','pinjaman/m_pinjaman'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=trim($this->session->userdata('nik'));
		$data['title']="Proses Cut Off Payroll";
		$nodok=trim($this->session->userdata('nik'));
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Ada kesalahan data dimuat !!</div>";
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
        else if($this->uri->segment(9)=="fail_pinjaman")
            $data['message']="<div class='alert alert-danger'>Gagal ada kesalahan data dimuat nominal tidak boleh lebih dari sisa pinjaman !!!</div>";
        else
            $data['message']='';
			
		//$thn=$this->input->post('tahun');
		//$bln=$this->input->post('bulan');		
		//$nik=$this->input->post('nik');		
		
		//$data['list_gp']=$this->m_detail->q_gaji_pokok($nik)->result();	
		
		$data['list_karyawan']=$this->m_detail->list_karyawan()->result();
		$data['list_departmen']=$this->m_detail->list_department()->result();
		$data['dtlopt']=$this->m_generate->q_setup_option_dept()->row_array();
		
        $this->template->display('payroll/detail/v_utama',$data);
    }
	
	
	
	function tangkap(){
		$kdgroup_pg=$this->input->post('grouppenggajian');
		$kddept=$this->input->post('kddept');
		$periode=$this->input->post('periode');
		$tahun=$this->input->post('tahun');
		$keluarkerja=$tahun.$periode;


        $enc_kdgroup_pg=$this->fiky_encryption->enkript($kdgroup_pg);
        $enc_kddept=$this->fiky_encryption->enkript($kddept);
        $enc_periode=$this->fiky_encryption->enkript($periode);
        $enc_tahun=$this->fiky_encryption->enkript($tahun);
        $enc_keluarkerja=$this->fiky_encryption->enkript($keluarkerja);


		if (empty($kddept) or $kddept==''){
				redirect("payroll/detail_payroll/master/$enc_kdgroup_pg/$enc_kdgroup_pg/$enc_periode/$enc_keluarkerja");
		} else {
				redirect("payroll/detail_payroll/master/$enc_kdgroup_pg/$enc_kddept/$enc_periode/$enc_keluarkerja");
		}
		
	}
	
	function tangkap_pph(){
		$kdgroup_pg=$this->input->post('grouppenggajian');
		$kddept=$this->input->post('kddept');
		$periode=$this->input->post('periode');
		$tahun=$this->input->post('tahun');
		$keluarkerja=$tahun.$periode;
		if (empty($kddept) or $kddept==''){
			redirect("payroll/detail_payroll/master_pph/$kdgroup_pg/$kdgroup_pg/$periode/$keluarkerja");	
		} else {
			redirect("payroll/detail_payroll/master_pph/$kdgroup_pg/$kddept/$periode/$keluarkerja");	
		}
		
	}
	
	
	function index_pph(){
        //echo "test";
		//$nama=trim($this->session->userdata('nik'));
		$data['title']="Proses Countinue Generate PPH 21";
		$nodok=trim($this->session->userdata('nik'));
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
		$data['dtlopt']=$this->m_detail->q_setup_option_dept()->row_array();
		
        $this->template->display('payroll/detail/v_utama_21',$data);
    }
	
	
	
	function master(){
		
		$nama=trim($this->session->userdata('nik'));
		$userlvl=strtoupper(trim($this->session->userdata('nik')));
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
		
		if($userlvl=='A'){
            $nodok="and nodok='$nama'";
		} else {
			$nodok="and nodok='$nama'";
		}
		
		
		//$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		//$nama=$karyawan['nmlengkap'];
		//$data['nama']=$nama;
		//$data['nik']=$nik;
		$kdgroup_pg=trim($this->fiky_encryption->dekript($this->uri->segment(4)));
        $kddept=trim($this->fiky_encryption->dekript($this->uri->segment(5)));
        $periode=trim($this->fiky_encryption->dekript($this->uri->segment(6)));
        $keluarkerja=trim($this->fiky_encryption->dekript($this->uri->segment(7)));

        $data['enc_kdgroup_pg'] = $enc_kdgroup_pg=trim($this->uri->segment(4));
        $data['enc_kddept'] = $enc_kddept=trim($this->uri->segment(5));
        $data['enc_periode'] = $enc_periode=trim($this->uri->segment(6));
        $data['enc_keluarkerja'] = $enc_keluarkerja=trim($this->uri->segment(7));

        $data['title']='Detail Penggajian Karyawan - STEP 1';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.B.1'; $versirelease='I.P.B.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		$data['nodok']=$nama;
		$data['enc_nodok']=$this->fiky_encryption->enkript($nama);
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
		
		$userlvl=strtoupper(trim($this->session->userdata('nik')));
		$nama=trim($this->session->userdata('nik'));
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
				
		if($userlvl=='A'){
			$nodok="";
		} else {
			$nodok="$nama";
			$nodokp="and nodok='$nama'";
		}
		
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
		$data['nama']=$nama;
		$data['keluarkerja']=$keluarkerja;

        $data['enc_nodok']=$this->fiky_encryption->enkript($nodok);
        $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript($kdgroup_pg);
        $data['enc_kddept']=$this->fiky_encryption->enkript($kddept);
        $data['enc_periode']=$this->fiky_encryption->enkript($periode);
        $data['enc_nama']=$this->fiky_encryption->enkript($nama);
        $data['enc_keluarkerja']=$this->fiky_encryption->enkript($keluarkerja);

		$data['list_master']=$this->m_detail->list_master_pph($nodokp,$kddept)->result();
		$data['list_rekap']=$this->m_detail->list_rekap_pph($nodokp,$kddept)->result();
		$data['dtluser']=$this->m_akses->mstuser($nama)->row_array();
		
		$this->template->display('payroll/detail/v_list_pph',$data);
		
	}
	
	function detail(){
        $data['enc_nik'] = $enc_nik=$this->uri->segment(4);
        $data['enc_kdgroup_pg'] = $enc_kdgroup_pg=$this->uri->segment(5);
        $data['enc_kddept'] = $enc_kddept=$this->uri->segment(6);
        $data['enc_periode'] = $enc_periode=$this->uri->segment(7);
        $data['enc_keluarkerja'] = $enc_keluarkerja=$this->uri->segment(8);

        $nik = $this->fiky_encryption->dekript($enc_nik);
        $kdgroup_pg = $this->fiky_encryption->dekript($enc_kdgroup_pg);
        $kddept = $this->fiky_encryption->dekript($enc_kddept);
        $periode = $this->fiky_encryption->dekript($enc_periode);
        $keluarkerja = $this->fiky_encryption->dekript($enc_keluarkerja);

		$nodok=trim($this->session->userdata('nik'));
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
            $data['message']="<div class='alert alert-success'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		$data['title']="List Detail Payroll";	
		$data['nik']=$nik;
		$data['list_detail']=$this->m_detail->list_detail($nik,$nodok)->result();
		$karyawan=$this->m_detail->list_karyawan_detail($nik)->row_array();
		$nama=$karyawan['nmlengkap'];
		$data['nama']=$nama;
		$data['kdgroup_pg']=$kdgroup_pg;
		$data['kddept']=$kddept;
		$data['periode']=$periode;
		$data['keluarkerja']=$keluarkerja;
		$this->template->display('payroll/detail/v_detail',$data);
	}
	
	function detail_pph($nik){
		$nodok=trim($this->session->userdata('nik'));
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
		if (empty($nominal)) {
			$nominal=0;
		}
		$this->db->query("update sc_tmp.payroll_detail set nominal=$nominal,status='H' where no_urut='$no_urut' and nik='$nik'");
		$this->db->query("update sc_mst.dtlgaji_karyawan  set nominal=$nominal where no_urut='$no_urut' and nik='$nik'");

        $enc_nik = $this->fiky_encryption->enkript($nik);
        $enc_kdgroup_pg = $this->fiky_encryption->enkript($kdgroup_pg);
        $enc_kddept = $this->fiky_encryption->enkript($kddept);
        $enc_periode = $this->fiky_encryption->enkript($periode);
        $enc_keluarkerja = $this->fiky_encryption->enkript($keluarkerja);

		redirect("payroll/detail_payroll/detail/$enc_nik/$enc_kdgroup_pg/$enc_kddept/$enc_periode/$enc_keluarkerja/edit_succes");
	}

	
	function detail_tunjangan($no_urut1,$nik){
		
		$nodok=trim($this->session->userdata('nik'));
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

            $data['enc_nik']=$this->fiky_encryption->enkript($nik);
            $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript($kdgroup_pg);
            $data['enc_kddept']=$this->fiky_encryption->enkript($kddept);
            $data['enc_periode']=$this->fiky_encryption->enkript($periode);
            $data['enc_keluarkerja']=$this->fiky_encryption->enkript($keluarkerja);
			$data['enc_detail_absensi']=$this->m_detail->q_absensi($nodok,$nik)->result();
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

            $data['enc_nik']=$this->fiky_encryption->enkript($nik);
            $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript($kdgroup_pg);
            $data['enc_kddept']=$this->fiky_encryption->enkript($kddept);
            $data['enc_periode']=$this->fiky_encryption->enkript($periode);
            $data['enc_keluarkerja']=$this->fiky_encryption->enkript($keluarkerja);
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

            $data['enc_nik']=$this->fiky_encryption->enkript($nik);
            $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript($kdgroup_pg);
            $data['enc_kddept']=$this->fiky_encryption->enkript($kddept);
            $data['enc_periode']=$this->fiky_encryption->enkript($periode);
            $data['enc_keluarkerja']=$this->fiky_encryption->enkript($keluarkerja);
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

            $data['enc_nik']=$this->fiky_encryption->enkript($nik);
            $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript($kdgroup_pg);
            $data['enc_kddept']=$this->fiky_encryption->enkript($kddept);
            $data['enc_periode']=$this->fiky_encryption->enkript($periode);
            $data['enc_keluarkerja']=$this->fiky_encryption->enkript($keluarkerja);
			$data['detail_lembur']=$this->m_detail->q_lembur($nodok,$nik)->result();			
			$this->template->display('payroll/detail/v_detail_lembur',$data);
		
		}  else {
			redirect("payroll/detail_payroll/detail/$nik");
		
		}
		
	
	}

	function detail_potongan($no_urut,$nik){
        $nodok=trim($this->session->userdata('nik'));
        if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
        else if($this->uri->segment(9)=="fail_pinjaman")
            $data['message']="<div class='alert alert-danger'>Gagal nominal tidak boleh lebih dari sisa pinjaman </div>";
        else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
        else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
        else if($this->uri->segment(5)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Tidak Berhasil Diubah</div>";
        else if($this->uri->segment(9)=="edit_succes")
            $data['message']="<div class='alert alert-success'>Data Berhasil Diubah</div>";
        else
            $data['message']='';


        if ($no_urut=='26') {
            $data['title'] = "List Detail Potongan Gaji Dari Pinjaman";
            $data['nik'] = $nik;
            $data['no_urut'] = $no_urut;
            $kdgroup_pg = $this->uri->segment(6);
            $kddept = $this->uri->segment(7);
            $periode = $this->uri->segment(8);
            $keluarkerja = $this->uri->segment(9);

            $data['kdgroup_pg'] = $kdgroup_pg;
            $data['kddept'] = $kddept;
            $data['periode'] = $periode;
            $data['keluarkerja'] = $keluarkerja;
            $data['nodok'] = $nodok;

            $data['enc_nik']=$this->fiky_encryption->enkript($nik);
            $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript($kdgroup_pg);
            $data['enc_kddept']=$this->fiky_encryption->enkript($kddept);
            $data['enc_periode']=$this->fiky_encryption->enkript($periode);
            $data['enc_keluarkerja']=$this->fiky_encryption->enkript($keluarkerja);

            $param = " and nik = '$nik' and docref='$nodok' and doctype='OUT' and statusmst not in ('C','I')";
            $data['detail_potongan'] = $this->m_detail->q_capture_pinjaman($param)->result();
            $this->template->display('payroll/detail/v_detail_potongan', $data);
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

    function ubah_pinjaman(){
        $nama = $this->session->userdata('nik');
        $type=$this->input->post('type');
        $docno=$this->input->post('docno');
        $nodok=$this->input->post('docref');
        $no_urut=$this->input->post('no_urut');
        $nik=$this->input->post('nik');
        $tgl=$this->input->post('tgl');
        $urut=$this->input->post('urut');
        $old_nominal=str_replace("_","",$this->input->post('old_nominal'));
        if ($old_nominal =='') { $o_nominal=0; } else { $o_nominal=$old_nominal;  }
        $nominal=str_replace("_","",$this->input->post('nominal'));
        $kdgroup_pg=$this->input->post('kdgroup_pg');
        $kddept=$this->input->post('kddept');
        $periode=$this->input->post('periode');
        if ($type === 'EDIT'){

           $paramceknominal = " and (sisa + $o_nominal) >=  $nominal
            and docno='$docno' and nik='$nik'";
           $ceknominal = $this->m_detail->q_pinjaman_mst($paramceknominal)->num_rows();
            if ($ceknominal > 0){

                $info = array (
                    'out_sld' => $nominal,
                );
                $this->db->where(array('docref'=>$nodok,'docno'=>$docno,'nik' => $nik, 'doctype' =>'OUT', 'tgl' => $tgl));
                $this->db->update("sc_trx.payroll_pinjaman_inq",$info);
                $this->db->query("select sc_trx.pr_hitung_pinjaman('$nodok'||'|'||''||'|'||'$nama')");
                $this->db->query("update sc_tmp.payroll_detail set nominal=( select  round(sum(out_sld)) as npotong from (
                                select a.*,b.nmlengkap,c.status as statusmst from sc_trx.payroll_pinjaman_inq a
                                left outer join sc_mst.karyawan b on a.nik=b.nik
                                join sc_trx.payroll_pinjaman_mst c on a.docno=c.docno
                                ) as x where nik is not null and nik = '$nik' and docref='$nodok' and doctype='OUT' and statusmst in ('P','F'))
                                where no_urut='26' and nik='$nik'");
            } else {
                redirect("payroll/detail_payroll/detail_potongan/$no_urut/$nik/$kdgroup_pg/$kddept/$periode/fail_pinjaman");
            }


        } else if ($type === 'DELETE'){
            $this->db->where(array('docref'=>$nodok,'docno'=>$docno,'nik' => $nik, 'doctype' =>'OUT'));
            $this->db->delete("sc_trx.payroll_pinjaman_inq");
            $this->db->query("select sc_trx.pr_hitung_pinjaman('$nodok'||'|'||''||'|'||'$nama')");

            $this->db->query("update sc_tmp.payroll_detail set nominal=( select  round(sum(out_sld)) as npotong from (
                                select a.*,b.nmlengkap,c.status as statusmst from sc_trx.payroll_pinjaman_inq a
                                left outer join sc_mst.karyawan b on a.nik=b.nik
                                join sc_trx.payroll_pinjaman_mst c on a.docno=c.docno
                                ) as x where nik is not null and nik = '$nik' and docref='$nodok' and doctype='OUT' and statusmst in ('P','F'))
                                where no_urut='26' and nik='$nik'");

        } else if ($type === 'RESET'){
            $this->db->query("select sc_trx.pr_ambil_pinjaman('$nodok'||'|'||'$nik'||'|'||'$nama')");

            $this->db->query("update sc_tmp.payroll_detail set nominal=( select  round(sum(out_sld)) as npotong from (
                                select a.*,b.nmlengkap,c.status as statusmst from sc_trx.payroll_pinjaman_inq a
                                left outer join sc_mst.karyawan b on a.nik=b.nik
                                join sc_trx.payroll_pinjaman_mst c on a.docno=c.docno
                                ) as x where nik is not null and nik = '$nik' and docref='$nodok' and doctype='OUT' and statusmst in ('P','F'))
                                where no_urut='26' and nik='$nik'");
        }


        //redirect("payroll/detail_payroll/detail/$nik/$kdgroup_pg/$kddept/$periode/rep_succes");
        redirect("payroll/detail_payroll/detail_potongan/$no_urut/$nik/$kdgroup_pg/$kddept/$periode/rep_succes");

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
	
	function harap_tunggu1(){
            $kdgroup_pg=trim($this->uri->segment(4));
            $kddept=trim($this->uri->segment(5));
            $periode=trim($this->uri->segment(6));
            $keluarkerja=trim($this->uri->segment(7));
			$data['title']="HARAP TUNGGU";
			$data['kdgroup_pg']=$kdgroup_pg;
			$data['kddept']=$kddept;
			$data['periode']=$periode;
			$data['keluarkerja']=$keluarkerja;
			$data['statussetup']=$this->m_detail->q_setup_option_dept()->row_array();
            //$this->m_akses->reduce_progress();
			$this->template->display('payroll/detail/v_harap_tunggu_pph',$data);
	}
	
	
	function generate_pph($kdgroup_pg,$kddept,$periode,$keluarkerja){
	
		//$this->delete_tmp_21($kddept);
		///$periode=date('m',strtotime($tglakhirfix));
		$nodok=trim($this->session->userdata('nik'));
		//$data=$this->m_generate->list_karyawan_new($kdgroup_pg,$kddept,$keluarkerja)->result();
		//$keluarkerja=date('Y').$keluarkerja1;
		$input_by=trim($this->session->userdata('nik'));
		$input_date=date('Y-m-d H:i:s');
		//INSERT REKAP
		$cek_p21rekap=$this->m_detail->cek_p21rekap($nodok,$periode,$kddept)->num_rows();
		if ($cek_p21rekap==0) {
			/*$master_rekap=array(
				'nodok'=>$this->session->userdata('nik'),
				'input_by'=>$this->session->userdata('nik'),
				'input_date'=>date('Y-m-d H:i:s'),
				'status'=>'I',
				'periode_mulai'=>$periode,
				'periode_akhir'=>$periode,
				'kddept'=>$kddept,
			);
			$this->db->insert('sc_tmp.p21_rekap',$master_rekap); */
			$this->db->query("insert into sc_tmp.p21_rekap (nodok,status,periode_mulai,periode_akhir,kddept,input_by,input_date) VALUES
			('$nodok','I','$periode','$periode','$kddept','$input_by','$input_date');");
		}
		
		$this->db->query("
		delete from sc_mst.trxerror where userid='$nodok' and modul='PPH21_GEN';
		insert into sc_mst.trxerror (userid,errorcode,modul) values ('$nodok','1','PPH21_GEN');");
		
		$statusetup=$this->m_detail->q_setup_option_dept()->row_array();
		if (trim($statusetup['status'])=='F'){
			$txt='select sc_tmp.pr_generate_p21('.chr(39).trim($nodok).chr(39).','.$periode.','.chr(39).trim($keluarkerja).chr(39).','.chr(39).$kdgroup_pg.chr(39).','.chr(39).$kddept.chr(39).') as nominal';
		} else { //with kddept
			$txt='select sc_tmp.pr_generate_p21_dept('.chr(39).trim($nodok).chr(39).','.$periode.','.chr(39).trim($keluarkerja).chr(39).','.chr(39).$kdgroup_pg.chr(39).','.chr(39).$kddept.chr(39).') as nominal';
		}
		
		
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
		$nodok=trim($this->session->userdata('nik'));
		$this->db->query("delete from sc_tmp.p21_rekap where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.p21_master where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("delete from sc_tmp.p21_detail where nodok='$nodok' and nik in (select nik from sc_mst.karyawan where bag_dept='$kddept')");
	}	
	
	function approvfinal_pph(){
		$periode_mulai=date('mY');
		$periode_akhir=date('mY');
		$kdgroup_pg=$this->uri->segment(4);
		$kddept=$this->uri->segment(5);
		$periode=$this->uri->segment(6);
		$keluarkerja=$this->uri->segment(7);
		$nodok=$this->uri->segment(8);
		$this->db->query("update sc_tmp.payroll_rekap set status='F' where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("update sc_tmp.p21_rekap set status='F' where nodok='$nodok' and kddept='$kddept'");
		redirect("payroll/detail_payroll/master_pph/$kdgroup_pg/$kddept/$periode/$keluarkerja");
	
	}
	
	function final_pph($nodok,$kddept){
        $this->m_akses->reduce_progress();
		$periode_mulai=date('mY');
		$periode_akhir=date('mY');
		$this->db->query("update sc_tmp.payroll_rekap set status='F' where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("update sc_tmp.p21_rekap set status='F' where nodok='$nodok' and kddept='$kddept'");
		
		$this->db->query("update sc_tmp.payroll_rekap set status='P' where nodok='$nodok' and kddept='$kddept'");
		$this->db->query("update sc_tmp.p21_rekap set status='P' where nodok='$nodok' and kddept='$kddept'");
		redirect('payroll/final_payroll/index/rep_succes');
	
	}

	
	public function excel_pph($nodok){
		
		$datane=$this->m_detail->report_master_pph($nodok);
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
	
	function clear_tmp(){
        $nodok=  $this->fiky_encryption->dekript($this->uri->segment(4));
        $kddept=  $this->fiky_encryption->dekript($this->uri->segment(5));

		$this->db->query("delete from sc_tmp.payroll_rekap where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_master where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.payroll_detail where nodok='$nodok'");
		
		$this->db->query("delete from sc_tmp.p21_rekap where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.p21_master where nodok='$nodok'");
		$this->db->query("delete from sc_tmp.p21_detail where nodok='$nodok'");
		
		$this->db->query("delete from sc_trx.payroll_pinjaman_inq where docref='$nodok'");

        $this->m_pinjaman->q_hitung_pinjaman($nodok,$nodok);
		redirect("payroll/generate/utama");
	}
	
	function generate_tmp_new(){
		$tgl=$this->input->post('tgl');
		$periode=$this->input->post('periode');
		$keluarkerja=$this->input->post('keluarkerja');
		$kdgroup_pg=$this->input->post('kdgroup_pg');
		$kddept=$this->input->post('kddept');
		$nik=$this->input->post('nik');
		$nodok=trim($this->session->userdata('nik'));
		$bulan=substr($keluarkerja,-2);
		$tahun=substr($keluarkerja,0,-2);
		$querytglawal=$this->m_generate->q_tglclosingawal()->row_array();
		$tglawal=$querytglawal['value3'];
		$querytglakhir=$this->m_generate->q_tglclosingakhir()->row_array();
		$tglakhir=$querytglakhir['value3'];
		$tglref=$tglakhir.'-'.$bulan.'-'.$tahun; 
		$tgl=$bulan.$tahun;

        $enc_kdgroup_pg = $this->fiky_encryption->enkript($kdgroup_pg);
        $enc_kddept = $this->fiky_encryption->enkript($kddept);
        $enc_periode = $this->fiky_encryption->enkript($periode);
        $enc_keluarkerja = $this->fiky_encryption->enkript($keluarkerja);

		if (empty($nik)){
            redirect("payroll/detail_payroll/master/$enc_kdgroup_pg/$enc_kddept/$enc_periode/$enc_keluarkerja");
        } else {
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
                $nodok=trim($this->session->userdata('nik'));
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




            redirect("payroll/detail_payroll/master/$enc_kdgroup_pg/$enc_kddept/$enc_periode/$enc_keluarkerja");
        }



    }


}	