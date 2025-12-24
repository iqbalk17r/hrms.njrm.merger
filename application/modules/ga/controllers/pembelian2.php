<?php
/*
	@author : Fiky
	@modul	: Permintaan Barang Dan Permintaan Pembelian
	13-10-2017
*/
//error_reporting(0)
class Pembelian extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_kendaraan','master/m_akses','m_supplier','m_pembelian'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','encryption')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA PEMBELIAN, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/pembelian/v_index',$data);
	}
	
	function js_viewstock_back(){
		$param_buff1=trim($this->uri->segment(4));
		$param_buff2=trim($this->uri->segment(5));
		$param_buff3=trim($this->uri->segment(6));
		$param_buff4=trim($this->uri->segment(7));
		
		if(empty($param_buff1)or $param_buff1=='' or $param_buff1==null){
			$param_buff1_1="";
		} else {
			$param_buff1_1=" and kdgroup='$param_buff1'";
		}
		
		if(empty($param_buff2)or $param_buff2=='' or $param_buff2==null){
			$param_buff2_1="";

		} else {
			$param_buff2_1=" and kdsubgroup='$param_buff2'";
		}
		
		if(empty($param_buff3)or $param_buff3=='' or $param_buff3==null){
			$param_buff3_1="";

		} else {
			$param_buff3_1=" and stockcode='$param_buff3'";
		}
		
		if(empty($param_buff4)or $param_buff4=='' or $param_buff4==null){
			$param_buff4_1="";

		} else {
			$param_buff4_1=" and loccode='$param_buff4'";
		}
		
		$param1=$param_buff1_1.$param_buff2_1.$param_buff3_1.$param_buff4_1;
		
		$data = $this->m_pembelian->q_stkgdw_param1($param1)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
	}
	
	function js_viewstock_name(){
		$param_buff1=str_replace('%20',' ',trim($this->uri->segment(4)));

		
		if(empty($param_buff1)or $param_buff1=='' or $param_buff1==null){
			$param_buff1_1="";
		} else {
			$param_buff1_1=" and nmbarang = '$param_buff1'";
		}
		
	
		$param1=$param_buff1_1;
		
		$data = $this->m_pembelian->q_mstbarang_atk_param($param1)->row_array();
		$cek = $this->m_pembelian->q_mstbarang_atk_param($param1)->num_rows();
	///	echo json_encode($data, JSON_PRETTY_PRINT);
		
		
		if ($cek>0) {
			echo json_encode($data, JSON_PRETTY_PRINT);
			echo json_encode(array("statusajax" => TRUE));
		} else {
			echo json_encode(array("statusajax" => FALSE));
		}
	
	}
	
	function js_tmp_name(){
		$param_buff1=strtoupper(str_replace('%20',' ',trim($this->uri->segment(4))));

		
		if(empty($param_buff1)or $param_buff1=='' or $param_buff1==null){
			$param_buff1_1="";
		} else {
			$param_buff1_1=" and desc_barang = '$param_buff1'";
		}
		
		$nama=$this->session->userdata('nik');
		$param_buff_0=" and nodok='$nama' ";
		$param1=$param_buff_0.$param_buff1_1;
		
		$data = $this->m_pembelian->q_sppb_tmp_dtl_param($param1)->row_array();
		$cek = $this->m_pembelian->q_sppb_tmp_dtl_param($param1)->num_rows();
	///	echo json_encode($data, JSON_PRETTY_PRINT);
		
		
		if ($cek>0) {
			echo json_encode($data, JSON_PRETTY_PRINT);
		//	echo json_encode(array("statusajax" => TRUE));
		} else {
			echo json_encode(array("statusajax" => FALSE));
		}
	
	}
	
	function js_mapping_satuan(){
		$param_buff1=trim($this->uri->segment(4));
		$param_buff2=trim($this->uri->segment(5));
		$param_buff3=trim($this->uri->segment(6));
		$param_buff4=trim($this->uri->segment(7));
		$param_buff5=trim($this->uri->segment(8));
		
		if(empty($param_buff1)or $param_buff1=='' or $param_buff1==null){
			$param_buff1_1="";
		} else {
			$param_buff1_1=" and kdgroup='$param_buff1'";
		}
		
		if(empty($param_buff2)or $param_buff2=='' or $param_buff2==null){
			$param_buff2_1="";

		} else {
			$param_buff2_1=" and kdsubgroup='$param_buff2'";
		}
		
		if(empty($param_buff3)or $param_buff3=='' or $param_buff3==null){
			$param_buff3_1="";

		} else {
			$param_buff3_1=" and stockcode='$param_buff3'";
		}
		
		if(empty($param_buff4)or $param_buff4=='' or $param_buff4==null){
			$param_buff4_1="";

		} else {
			$param_buff4_1=" and satkecil='$param_buff4'";
		}
		if(empty($param_buff5)or $param_buff5=='' or $param_buff5==null){
			$param_buff5_1="";

		} else {
			$param_buff5_1=" and satbesar='$param_buff5'";
		}
		$param=$param_buff1_1.$param_buff2_1.$param_buff3_1.$param_buff4_1.$param_buff5_1;
		
		$data = $this->m_pembelian->q_mapsatuan_barang_param($param)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
	}
	
	function js_mbarang(){
		$param_buff1=trim($this->uri->segment(4));
		$param_buff2=trim($this->uri->segment(5));
		$param_buff3=trim($this->uri->segment(6));
		
		if(empty($param_buff1)or $param_buff1=='' or $param_buff1==null){
			$param_buff1_1="";
		} else {
			$param_buff1_1=" and kdgroup='$param_buff1'";
		}
		
		if(empty($param_buff2)or $param_buff2=='' or $param_buff2==null){
			$param_buff2_1="";

		} else {
			$param_buff2_1=" and kdsubgroup='$param_buff2'";
		}
		
		if(empty($param_buff3)or $param_buff3=='' or $param_buff3==null){
			$param_buff3_1="";

		} else {
			$param_buff3_1=" and nodok='$param_buff3'";
		}

		$param=$param_buff1_1.$param_buff2_1.$param_buff3_1;
		
		$data = $this->m_pembelian->q_mstbarang_atk_param($param)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
	}
	
	function js_supplier(){
		$param_buff1=trim($this->uri->segment(4));
		$param_buff2=trim($this->uri->segment(5));
		$param_buff3=trim($this->uri->segment(6));

		
		if(empty($param_buff1)or $param_buff1=='' or $param_buff1==null){
			$param_buff1_1="";
		} else {
			$param_buff1_1=" and kdgroupsupplier='$param_buff1'";
		}
		
		if(empty($param_buff2)or $param_buff2=='' or $param_buff2==null){
			$param_buff2_1="";

		} else {
			$param_buff2_1=" and kdsupplier='$param_buff2'";
		}
		
		if(empty($param_buff3)or $param_buff3=='' or $param_buff3==null){
			$param_buff3_1="";

		} else {
			$param_buff3_1=" and kdsubsupplier='$param_buff3'";
		}
	
		$param=$param_buff1_1.$param_buff2_1.$param_buff3_1;
		
		$data = $this->m_pembelian->q_msubsupplier_param($param)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
	}
	
	function form_sppb(){
		$data['title']="LIST SURAT PERMINTAAN PEMBELIAN BARANG";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.H.4';
						$versirelease='I.G.H.4/ALPHA.001';
						$userid=$this->session->userdata('nama');
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						if($versidb<>$versirelease){
							$infoversiold= array (
								'vreleaseold'   => $versidb,
								'vdateold'      => $vdb['vdate'],
								'vauthorold'    => $vdb['vauthor'],
								'vketeranganold'=> $vdb['vketerangan'],
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversiold);
							
							$infoversi= array (
								'vrelease'   => $versirelease,
								'vdate'      => date('2017-07-10 11:18:00'),
								'vauthor'    => 'FIKY',
								'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
								'update_date' => date('Y-m-d H:i:s'),
								'update_by'   => $userid,
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversi);
						}
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						$data['version']=$versidb;
						/* END CODE UNTUK VERSI */
								

		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="final_succes") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DOKUMEN $nodokfinal SELESAI DI INPUT</div>";
		} else if($this->uri->segment(4)=="app_succes") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DOKUMEN $nodokfinal SUKSES DI APPROVAL</div>";
		} else if($this->uri->segment(4)=="edit_succes") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DOKUMEN $nodokfinal SELESAI DI UBAH</div>";
		}  else if($this->uri->segment(4)=="edit_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF DOKUMEN INI SEDANG DIPROSES OLEH USER :: $nodokfirst</div>";
		}   else if($this->uri->segment(4)=="approv_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF DOKUMEN INI SEDANG DIPROSES OLEH USER :: $nodokfirst</div>";
		}   else if($this->uri->segment(4)=="process_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>MOHON MAAF DOKUMEN INI SUDAH TER PROSES :: $nodokfirst</div>";
		}
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="inp_fail")
            $data['message']="<div class='alert alert-danger'>Dokumen tidak berhasil di input / sedang di proses akses user lain</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes/Proses Transaksi Dibatalkan</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
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
		
		//echo $tgl;
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and nodok='$nama' and status='I'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param3_1_3=" and nodok='$nama' and status='A'";
		$param3_1_4=" and nodok='$nama' and status='H'";
		$param3_1_5=" and nodok='$nama' and status='C'";
		$param3_1_R=" and nodok='$nama'";
			$ceksppbdtl_na=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_1)->num_rows(); //input
			$ceksppbdtl_ne=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->num_rows(); //edit
			$ceksppbdtl_napp=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_3)->num_rows(); //edit
			$ceksppbdtl_hangus=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_4)->num_rows(); //edit
			$dtledit=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($ceksppbdtl_na>0) { //cek inputan
					$enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
					redirect("ga/pembelian/input_sppb/$enc_nik");
					//redirect("ga/pembelian/direct_lost_input");
			} else if ($ceksppbdtl_ne>0){	//cek edit
					redirect("ga/pembelian/edit_sppb/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			}  else if ($ceksppbdtl_napp>0){	//cek edit
					redirect("ga/pembelian/approval_sppb/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			}   else if ($ceksppbdtl_hangus>0){	//cek hangus
					redirect("ga/pembelian/hangus_sppb/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			}
			
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0 )){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
					
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$data['ceknikatasan1']=$ceknikatasan1;
		/* END APPROVE ATASAN */
		

		//$data['list_sppb']=$this->m_pembelian->q_lisppb()->result();
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_sppb']=$this->m_pembelian->q_list_sppbparam($param_list_akses)->result();
        $this->template->display('ga/pembelian/v_sppb',$data);
	}
	
			
	function list_niksppb(){
		$data['title']='DATA KARYAWAN UNTUK SURAT PERMINTAAN PEMBELIAN BARANG';
		$nama=$this->session->userdata('nik');
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param_list_akses="and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */


		$data['list_niksppb']=$this->m_akses->list_karyawan_param($param_list_akses)->result();
		$this->template->display('ga/pembelian/v_list_niksppb',$data);
	}
	
	
	function input_sppb(){
		
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		
		$branch=strtoupper(trim($dtlbranch['branch']));
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$loccode'";
		$param_kanwil="";
		$param_inp=" and nodok='$nama' or nik='$nik'";
		$param_inp_sc=" and nodok='$nama'";
		///st_not_null
		/* user hr akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/*user hr end */
		
		$ceksppbmst_inp=$this->m_pembelian->q_sppb_tmp_mst_param($param_inp)->num_rows();
		$ceksppbmst_inp_sc=$this->m_pembelian->q_sppb_tmp_mst_param($param_inp_sc)->num_rows();
			
		if ($ceksppbmst_inp==0) {
			$info_mst = array (
					'branch' => $branch,
					'nodok' => $nama,
					'nik' => $nik,
					'loccode' => $loccode,
					'status' => 'I',
					'keterangan' => '',
					'inputdate' => date('Y-m-d H:i:s'),
					'inputby' => $nama	);	 
			$this->db->insert('sc_tmp.sppb_mst',$info_mst);
		}
		
		if ($ceksppbmst_inp_sc==0) {
			redirect("ga/pembelian/form_sppb/inp_fail");
		}
		
		
		if($this->uri->segment(5)=="fail_input")
            $data['message']="<div class='alert alert-warning'>Barang Belum ada yang di Sisipkan Atau Belum Terinput</div>";
		else if($this->uri->segment(5)=="st_not_null")
            $data['message']="<div class='alert alert-warning'>Qty Barang Tidak Boleh Kosong/ Minus</div>";
		else if($this->uri->segment(5)=="fail_fill")
            $data['message']="<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
		else if($this->uri->segment(5)=="warn_onhand")
            $data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Detail Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['title']=' INPUT SPPB ';
				$paramx='';
		//$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit_sppb($paramx)->result();
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_sppb_tmp_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param_inp_sc)->result();
		$data['list_sppb_tmp_dtl']=$this->m_pembelian->q_sppb_tmp_dtl_param($param_inp_sc)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_kanwil']=$this->m_pembelian->q_mstkantor($param_kanwil)->result();
		$data['dtlmst']=$this->m_pembelian->q_sppb_tmp_mst_param($param_inp)->row_array();
		$this->template->display('ga/pembelian/v_input_niksppb',$data);
	
	}
	
	function add_map_satuan($paramsatuan){
		//$query = $this->db->get_where('sc_mst.kotakab',array('kodeprov'=>$id_prov));
		//$query = $this->db->query("select * from sc_mst.kotakab where kodeprov='$id_prov' order by namakotakab");
		$paramsat=" and strtrim='$paramsatuan'";
		$query = $this->m_pembelian->q_mapsatuan_barang_param($paramsat);
		$data = "<option value=''>- Pilih Satuan -</option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->satbesar."'>".$value->desc_satbesar."</option>";
		}
		echo $data;
	}
	
	function clear_tmp_sppb(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/pembelian/form_sppb");
		}		
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  */
		if (trim($dtledit['status'])<>'A') {
			$info = array (
						'updatedate' => null,
						'updateby' => '',
						'approvaldate' => null,
						'approvalby' => '',
						'canceldate' => null,
						'cancelby' => '',
						'status' => 'A',
		
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.sppb_mst',$info);
		}
	////		$this->db->where('nodok',$nodoktmp);
	////		$this->db->update('sc_trx.sppb_dtl',$info);
			
			
			/* clearing temporary  */
			$this->db->where('nodok',$nama);
			$this->db->delete('sc_tmp.sppb_mst');
			$this->db->where('nodok',$nama);
			$this->db->delete('sc_tmp.sppb_dtl');
				
			redirect("ga/pembelian/form_sppb/del_succes");
	}
	
	function clear_tmp_sppb_hangus(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/pembelian/form_sppb");
		}	else	{
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  */
			$info = array (
					'status' => 'P',
			);
			$this->db->where('nodok',$nodoktmp);
			$this->db->update('sc_trx.sppb_mst',$info);
		}
	////		$this->db->where('nodok',$nodoktmp);
	////		$this->db->update('sc_trx.sppb_dtl',$info);
			
			
			/* clearing temporary  */
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.sppb_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.sppb_dtl');
				
			redirect("ga/pembelian/form_sppb/del_succes");
	}
	

	function cancel_tmp_sppb_dtl(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$enc_nik=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
			$status=trim($dtledit['status']); //inisial nodok tmp

		if(empty($nama)){
			redirect("ga/pembelian/form_sppb");
		}		
			if ($status=='I') {
				$this->db->where('nodok',$nama);
				$this->db->delete('sc_tmp.sppb_dtl');
				redirect("ga/pembelian/input_sppb/$enc_nik/del_succes");
			} else if ($status=='E') {
				$this->db->where('nodok',$nama);
				$this->db->delete('sc_tmp.sppb_dtl');
				redirect("ga/pembelian/edit_sppb/$enc_nodok/del_succes");
			}
	}
		
	
	function save_sppb(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nik=strtoupper($this->input->post('nik'));
		$nodok=strtoupper($this->input->post('nodok'));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		$loccode=strtoupper($this->input->post('loccode'));
		$desc_barang=strtoupper($this->input->post('desc_barang'));
		$fromstock=strtoupper($this->input->post('daristock'));
		$satkecil=strtoupper($this->input->post('satkecil'));
		$satminta=strtoupper($this->input->post('satminta'));
		$satminta2=strtoupper($this->input->post('satminta2'));
		$onhand=strtoupper($this->input->post('onhand'));
		
		if ($onhand=='' or empty($onhand)){
				$qtyonhand=0;
		} else {
				$qtyonhand=$onhand;
		}

		$qtysppbkecil1=strtoupper($this->input->post('qtykonversi'));
		$qtysppbminta1=strtoupper($this->input->post('qtysppbminta'));
		if ($qtysppbkecil1=='' or empty($qtysppbkecil1)){
				$qtysppbkecil=0;
		} else {
				$qtysppbkecil=$qtysppbkecil1;
		}
		
		if ($qtysppbminta1=='' or empty($qtysppbminta1)){
				$qtysppbminta=0;
		} else {
				$qtysppbminta=$qtysppbminta1;
		} 	
		$onhand=strtoupper($this->input->post('onhand'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$nodoktmp=strtoupper($this->input->post('nodoktmp'));
		$id=strtoupper($this->input->post('id'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_nodok=bin2hex($this->encrypt->encode($nodok));
		// if(empty($nodok)){
			// redirect("ga/pembelian/form_pembelian");
		// }
		if ($type=='INPUTTMPDTLINPUT'){

			$param_item_kembar=" and nodok='$nama' and desc_barang='$desc_barang'";
			$cek_sppb_kembar=$this->m_pembelian->q_sppb_tmp_dtl_param($param_item_kembar)->num_rows();
			
			if($qtysppbminta<=0){
				redirect("ga/pembelian/input_sppb/$enc_nik/st_not_null");
			} else if ($cek_sppb_kembar>0){
				redirect("ga/pembelian/input_sppb/$enc_nik/fail_fill");
			}
			
			if($fromstock=='YES'){
				$satminta=$satminta2;
			} else { $satminta=$satminta; }	
			
			$info_dtl = array (
						'branch' => $branch,
						'nodok' => $nama,
						'nik' => $nik,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtyrefonhand' => $qtyonhand,
						'qtysppbkecil' => $qtysppbkecil,
						'qtysppbminta' => $qtysppbminta,
						'satkecil' => $satkecil,
						'satminta' => $satminta,
						'status' => 'I',
						'keterangan' => $keterangan,
						'inputdate' => $inputdate,
						'inputby' => $inputby,		
						'fromstock' => $fromstock,	
						'id' => 99999,							
			);
			
				$this->db->insert('sc_tmp.sppb_dtl',$info_dtl);
				redirect("ga/pembelian/input_sppb/$enc_nik/inp_succes");

			
		} else if ($type=='INPUTTMPDTLEDIT') {
			$param_item_kembar=" and nodok='$nama' and desc_barang='$desc_barang'";
			$cek_sppb_kembar=$this->m_pembelian->q_sppb_tmp_dtl_param($param_item_kembar)->num_rows();
			
			if($qtysppbminta<=0){
				redirect("ga/pembelian/edit_sppb/$enc_nik/st_not_null");
			} else if ($cek_sppb_kembar>0){
				redirect("ga/pembelian/edit_sppb/$enc_nik/fail_fill");
			}
			
			if($fromstock=='YES'){
				$satminta=$satminta2;
			} else { $satminta=$satminta; }	
			
			$info_dtl = array (
						'branch' => $branch,
						'nodok' => $nama,
						'nik' => $nik,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtyrefonhand' => $qtyonhand,
						'qtysppbkecil' => $qtysppbkecil,
						'qtysppbminta' => $qtysppbminta,
						'satkecil' => $satkecil,
						'satminta' => $satminta,
						'status' => 'A',
						'keterangan' => $keterangan,
						'inputdate' => $inputdate,
						'inputby' => $inputby,		
						'fromstock' => $fromstock,		
						'nodoktmp' => $nodoktmp,					
						'id' => 99999,		
			);
			
				$this->db->insert('sc_tmp.sppb_dtl',$info_dtl);
				redirect("ga/pembelian/edit_sppb/$enc_nik/inp_succes");

			
		} else if ($type=='EDITTMPDTLINPUT') {
			if($qtysppbminta<=0){
				redirect("ga/pembelian/input_sppb/$enc_nodok/st_not_null");
			}
				$info = array (
			
						'desc_barang' => $desc_barang,
						'qtyrefonhand' => $qtyonhand,
						'qtysppbminta' => $qtysppbminta,
						'satminta' => $satminta,
						'status' => '',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby,
											
				);
				$this->db->where('nodok',$nama);
				$this->db->where('id',$id);
				$this->db->update('sc_tmp.sppb_dtl',$info);
				if($onhand==0){
				redirect("ga/pembelian/input_sppb/$enc_nodok/warn_onhand");	
				} else {
				redirect("ga/pembelian/input_sppb/$enc_nodok/edit_succes");
				}
		} else if ($type=='EDITTMPDTL') {
			if($qtysppbminta<=0){
				redirect("ga/pembelian/edit_sppb/$enc_nodok/st_not_null");
			} else {
				$info = array (
							'desc_barang' => $desc_barang,
							'qtysppbminta' => $qtysppbminta,
							'satminta' => $satminta,
							'status' => '',
							'keterangan' => $keterangan,
							'updatedate' => $inputdate,
							'updateby' => $inputby,
												
					);
					$this->db->where('nodok',$nama);
					$this->db->where('id',$id);
					$this->db->update('sc_tmp.sppb_dtl',$info);
					if($onhand==0){
					redirect("ga/pembelian/edit_sppb/$enc_nodok/warn_onhand");	
					} else {
					redirect("ga/pembelian/edit_sppb/$enc_nodok/edit_succes");
					}
			}	
		}  else if ($type=='EDITTMPMST') {
				//echo $type;
				//echo $loccode;
				$info_mst = array (
					'loccode' => $loccode,
					'status' => 'I',
					'keterangan' => $keterangan,
					'updatedate' => date('Y-m-d H:i:s'),
					'updateby' => $nama	
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.sppb_mst',$info_mst);
				redirect("ga/pembelian/input_sppb/$enc_nik/edit_succes");		
		} else if ($type=='APPROVETMPMST') {
				$param_apv=" and nodok='$nama' and status='A'";
				$ceksppbdtl_approv=$this->m_pembelian->q_sppb_tmp_dtl_param($param_apv)->num_rows();
				if ($ceksppbdtl_approv>0) {
						redirect("ga/pembelian/approval_sppb/$enc_nik/cant_final");
				} else {
					$info = array (
							'status' => 'F',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.sppb_mst',$info);
					redirect("ga/pembelian/form_sppb/app_succes");
				}
		} else if ($type=='APPRDTLTRX') {
					$info = array (
							'status' => 'P',
					);
					$this->db->where('nodok',$nama);
					$this->db->where('id',$id);
					$this->db->update('sc_tmp.sppb_dtl',$info);
					redirect("ga/pembelian/approval_sppb/$enc_nik/succ_dtlfinal");
				
		}  else if ($type=='REJAPPDTL') { /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
							'status' => 'C',
					);
					$this->db->where('nodok',$nama);
					$this->db->where('id',$id);
					$this->db->update('sc_tmp.sppb_dtl',$info);
					redirect("ga/pembelian/approval_sppb/$enc_nik/succ_rejectdtlfinal");
				
		}   else if ($type=='CAPPRDTL') {  /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
							'status' => 'A',
					);
					$this->db->where('nodok',$nama);
					$this->db->where('id',$id);
					$this->db->update('sc_tmp.sppb_dtl',$info);
					redirect("ga/pembelian/approval_sppb/$enc_nik/succ_dtlfinal");
				
		} else if ($type=='DELETE') {
				$info = array (
						'status' => 'C',
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.sppb_mst',$info);
				redirect("ga/pembelian/form_sppb/del_succes");
		} else if ($type=='DELTRXMST') {
				$info = array (
						'status' => 'F',
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.sppb_mst',$info);
				redirect("ga/pembelian/form_sppb/del_succes");
		} else if ($type=='DELETETMPDTLINPUT') {
				$this->db->where('nodok',$nama);
				$this->db->where('id',$id);
				$this->db->delete('sc_tmp.sppb_dtl');
				redirect("ga/pembelian/input_sppb/$enc_nik/del_succes");
		} else if ($type=='DELETETMPDTLEDIT') {
				$this->db->where('nodok',$nama);
				$this->db->where('id',$id);
				$this->db->delete('sc_tmp.sppb_dtl');
				redirect("ga/pembelian/edit_sppb/$enc_nodok/del_succes");
		}  else if ($type=='HANGUSFINAL') {
					/* FINAL SETELAH PENGHANGUSAN */
					$info = array (
							'status' => 'F',
							'updatedate' => date('Y-m-d H:i:s'),
							'updateby' => $nama	
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.sppb_mst',$info);
					redirect("ga/pembelian/form_sppb/inp_succes");
		} else {
			redirect("ga/pembelian/form_sppb");
		}
	}
	
	function final_input_sppb(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

		$enc_nik=trim($this->uri->segment(4));

		$nama=trim($this->session->userdata('nik'));
		
		if(empty($nama)){
			redirect("ga/pembelian/form_sppb");
		}	
		
		$param3_1=" and nodok='$nama'";
		$param_inputby=" and inputby='$nama'";
		$param3_1_2=" and nodok='$nama'";
		$dtledit=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
		$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
		$status=trim($dtledit['status']); //inisial nodok tmp
	 	$nodoktmp=trim($dtledit['nodoktmp']); //inisial nodok tmp
	 	$cek_tmp_sppb_dtl=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_1)->num_rows();

 		if($cek_tmp_sppb_dtl>0 and $status=='I'){	//finish input
 			$info = array (
						'status' => 'A',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.sppb_mst',$info);
				$dtl=$this->m_pembelian->q_sppb_trx_mst_param_inputby($param_inputby)->row_array();
				$nodokfinal=trim($dtl['nodok']);
				redirect("ga/pembelian/form_sppb/final_succes/$nodokfinal"); 
				//ECHO 'FINAL INPUT';
				
		} else if($cek_tmp_sppb_dtl>0 and $status=='E'){ //finish edit
		 		$info = array (
						'status' => 'A',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.sppb_mst',$info);
				redirect("ga/pembelian/form_sppb/edit_succes/$nodoktmp"); 
				
				//ECHO 'FINAL EDIT';
		} else if($cek_tmp_sppb_dtl<=0 and $status=='E'){ //finish edit
				//ECHO 'EDIT FAIL';
				redirect("ga/pembelian/edit_sppb/$enc_nodok/edit_fail");
		} else {
				//ECHO 'CONCLUSION';
				redirect("ga/pembelian/input_sppb/$enc_nik/fail_input");
		}  
		 
			
	}
	
	
	function detail_sppb(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/pembelian/form_pembelian");
		}
		$nama=$this->session->userdata('nik');
				
		$param3_1=" and nodok='$nodok'";
		$param3_2=" and nodok='$nodok'";
		$sppb_mst=$this->m_pembelian->q_sppb_trx_mst_param($param3_1)->row_array();
		$data['list_sppb_trx_mst']=$this->m_pembelian->q_sppb_trx_mst_param($param3_1)->result();
		$sppb_dtl=$this->m_pembelian->q_sppb_trx_dtl_param($param3_2)->row_array();
		$data['list_sppb_trx_dtl']=$this->m_pembelian->q_sppb_trx_dtl_param($param3_2)->result();
		$nik=trim($sppb_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']='DETAIL INPUT SPPB ';
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="fail_fill")
            $data['message']="<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();

		$this->template->display('ga/pembelian/v_detail_sppb',$data);
		
	}
	
	function edit_sppb(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/pembelian/form_sppb");
		}
		
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_sppb/process_fail/$nodok");
		}
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_sppb/edit_fail/$nodokfirst");
		} else {
			$info = array (
					
					'updateby' => $nama,
					'updatedate' => date('Y-m-d H:i:s'),
					'status' => 'E',
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.sppb_mst',$info);
		}
		

		
				
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$sppb_mst=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['sppb_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['list_sppb_tmp_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
		$sppb_dtl=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
		$data['list_sppb_tmp_dtl']=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
		$nik=trim($sppb_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" EDIT INPUT SPPB DETAIL";
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
		else if($this->uri->segment(5)=="edit_fail")
            $data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="st_not_null")
            $data['message']="<div class='alert alert-warning'>Qty Barang Tidak Boleh Kosong/ Minus</div>";
		else if($this->uri->segment(5)=="fail_fill")
            $data['message']="<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
		else if($this->uri->segment(5)=="warn_onhand")
            $data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(5)=="warn_onhand")
            $data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
        else
            $data['message']='';
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit_sppb($paramx)->result();
		//$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['dtlmst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$this->template->display('ga/pembelian/v_edit_sppb',$data);
		
	}
	
	function approval_sppb(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/pembelian/form_sppb");
		}
		$nama=$this->session->userdata('nik');
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_sppb/process_fail/$nodok");
		}
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
		$data['nama']=$this->session->userdata('nik');
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_sppb/approv_fail/$nodokfirst");
		} else {
			$info = array (
					'approvalby' => $nama,
					'approvaldate' => date('Y-m-d H:i:s'),
					'status' => 'A',
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.sppb_mst',$info);
		}
		
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$sppb_mst=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['sppb_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['list_sppb_tmp_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
		$sppb_dtl=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
		$data['list_sppb_tmp_dtl']=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
		$nik=trim($sppb_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" PERSETUJUAN PERMINTAAN PEMBELIAN BARANG KELUAR";
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
		else if($this->uri->segment(5)=="edit_fail")
            $data['message']="<div class='alert alert-danger'>Peringatan Stok Tidak Boleh Kosong </div>";
		else if($this->uri->segment(5)=="cant_final")
            $data['message']="<div class='alert alert-danger'>Peringatan Seluruh Permintaan Detail Harus Teraprove/Ter Reject Terlebih Dahulu </div>";
		else if($this->uri->segment(5)=="succ_dtlfinal")
            $data['message']="<div class='alert alert-success'>Detail sukses Terapprove </div>";
		else if($this->uri->segment(5)=="succ_rejectdtlfinal")
            $data['message']="<div class='alert alert-success'> Reject Permintaan Barang Sukses Di Lakukan </div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit_sppb($paramx)->result();
		//$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['dtlmst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$this->template->display('ga/pembelian/v_approval_sppb',$data);
		
	}
	
	function hapus_sppb(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/pembelian/form_sppb");
		}
		$nama=$this->session->userdata('nik');
		$param_trxapprov=" and nodok='$nodok' and status in ('H','P','F')";
		$cek_trxapprov=$this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_sppb/process_fail/$nodok");
		}
			
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_sppb/approv_fail/$nodokfirst");
		} else {
			$info = array (
					'cancelby' => $nama,
					'canceldate' => date('Y-m-d H:i:s'),
					'status' => 'C',
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.sppb_mst',$info);
		}
			
			
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$sppb_mst=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
					
		$data['nama']=$this->session->userdata('nik');
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['sppb_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['list_sppb_tmp_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
		$sppb_dtl=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
		$data['list_sppb_tmp_dtl']=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
		$nik=trim($sppb_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" PEMBATALAN PBK";
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['dtlmst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$this->template->display('ga/pembelian/v_hapus_sppb',$data);
		
	}
	
	function hangus_sppb(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/pembelian/form_sppb");
		}
		$nama=$this->session->userdata('nik');
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H')";
		$cek_trxapprov=$this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/permintaan/form_sppb/process_fail/$nodok");
		}	
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_sppb/approv_fail/$nodokfirst");
		} else {
			$data['nama']=$this->session->userdata('nik');
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			$info = array (
					'hangusby' => $nama,
					'hangusdate' => date('Y-m-d H:i:s'),
					'status' => 'H',
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.sppb_mst',$info);
		}

			
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$sppb_mst=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['sppb_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
		$data['list_sppb_tmp_mst']=$this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
		$sppb_dtl=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
		$data['list_sppb_tmp_dtl']=$this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
		$nik=trim($sppb_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" PENGHANGUSAN SURAT PERMINTAAN PEMBELIAN BARANG";
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/pembelian/v_hangus_sppb',$data);
		
	}
	
	function sti_sppb_final(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$data['jsonfile'] = "ga/pembelian/json_sppb_final/$nodok";
		$data['report_file'] = 'assets/mrt/form_sppb.mrt';
		$this->load->view("ga/pembelian/sti_v_form.php",$data);
	}
	function json_sppb_final(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$param1=" and nodok='$nodok'";
		$param2=" and nodok='$nodok' and status in ('P','U','S')";
		$databranch = $this->m_pembelian->q_master_branch()->result();
		$datamst = $this->m_pembelian->q_sppb_trx_mst_param($param1)->result();
		$datadtl = $this->m_pembelian->q_sppb_trx_dtl_param($param2)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'branch' => $databranch,
				'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	
	
	
	/// PEMBELIAN 	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN
	
	function form_pembelian(){
		$data['title']="LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR";
		//$data['title']=$this->encryption->encrypt('HALO');
		//$data['title2']=$this->encryption->decrypt('HALO');
			//$this->encrypt->encode($smtp_pass);
			//$this->encrypt->decode($smtp_pass);
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$nama=$this->session->userdata('nik');
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.H.1';
						$versirelease='I.G.H.1/ALPHA.001';
						$userid=$this->session->userdata('nama');
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						if($versidb<>$versirelease){
							$infoversiold= array (
								'vreleaseold'   => $versidb,
								'vdateold'      => $vdb['vdate'],
								'vauthorold'    => $vdb['vauthor'],
								'vketeranganold'=> $vdb['vketerangan'],
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversiold);
							
							$infoversi= array (
								'vrelease'   => $versirelease,
								'vdate'      => date('2017-07-10 11:18:00'),
								'vauthor'    => 'FIKY',
								'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
								'update_date' => date('Y-m-d H:i:s'),
								'update_by'   => $userid,
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversi);
						}
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						$data['version']=$versidb;
						/* END CODE UNTUK VERSI */
								
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pembelian->q_trxerror($paramerror)->row_array();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
	
		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_failed")
            $data['message']="<div class='alert alert-danger'>User masih ada dokumen yang belum selesai</div>";
		else if($this->uri->segment(4)=="edit_failed_doc") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen sedang diakses user $nodokfirst</div>";
		} else if($this->uri->segment(4)=="process_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen Sudah Terproses No Rev:: $nodokfirst</div>";
		} else if($this->uri->segment(4)=="inp_kembar") {
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		} else if($this->uri->segment(4)=="success_input") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DATA PO SUKSES DISIMPAN DOKUMEN : $nodokfirst </div>";
		}	
		else if($this->uri->segment(4)=="wrong_format") {
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        } else {
			if($this->uri->segment(4)!=""){
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}else {
				$data['message']="";
			}
            
		}
			
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
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
		
		//echo $tgl;

		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and nodok='$nama' and status='I'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param3_1_3=" and nodok='$nama' and status='A'";
		$param3_1_4=" and nodok='$nama' and status='C'";
		$param3_1_5=" and nodok='$nama' and status='H'";
		$param3_1_R=" and nodok='$nama'";
			$cekmstpo_na=$this->m_pembelian->q_tmp_po_mst_param($param3_1_1)->num_rows(); //input
			$cekmstpo_ne=$this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->num_rows(); //edit
			$cekmstpo_napp=$this->m_pembelian->q_tmp_po_mst_param($param3_1_3)->num_rows(); //approv
			$cekmstpo_cancel=$this->m_pembelian->q_tmp_po_mst_param($param3_1_4)->num_rows(); //cancel
			$cekmstpo_hangus=$this->m_pembelian->q_tmp_po_mst_param($param3_1_5)->num_rows(); //hangus
			$dtledit=$this->m_pembelian->q_tmp_po_mst_param($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			$enc_nik=bin2hex($this->encrypt->encode($nama));
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekmstpo_na>0) { //cek inputan
					redirect("ga/pembelian/input_po/$enc_nik");
					//redirect("ga/pembelian/direct_lost_input");
			} else if ($cekmstpo_ne>0){	//cek edit
					redirect("ga/pembelian/edit_po_atk/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			} else if ($cekmstpo_napp>0){	//cek approv
					redirect("ga/pembelian/approval_po_atk/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			} else if ($cekmstpo_cancel>0){	//cek cancel
					redirect("ga/pembelian/batal_po_atk/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			} else if ($cekmstpo_hangus>0){	//cek cancel
					redirect("ga/pembelian/hangus_po_atk/$enc_nodok");
					//redirect("ga/pembelian/direct_lost_input");
			}
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_po']=$this->m_pembelian->q_listpembelian()->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
        $this->template->display('ga/pembelian/v_list_po',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pembelian->q_deltrxerror($paramerror);
	}

	function sti_po_final(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$data['jsonfile'] = "ga/pembelian/json_po_final/$nodok";
		$data['report_file'] = 'assets/mrt/form_po.mrt';
		$this->load->view("ga/pembelian/sti_v_form.php",$data);
	}
	function json_po_final(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$param=" and nodok='$nodok'";
		$databranch = $this->m_pembelian->q_master_branch()->result();
		$datamst = $this->m_pembelian->q_trx_po_mst_param($param)->result();
		$datadtl = $this->m_pembelian->q_trx_po_dtl_param($param)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'branch' => $databranch,
				'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	
	
	function input_po(){
		$nama=$this->session->userdata('nik');
		$tgl=explode(' - ',trim($this->input->post('tgl')));
		if(isset($tgl[0]) and isset($tgl[1])) {
			$tgl1=date('Y-m-d', strtotime(trim($tgl[0])));
			$tgl2=date('Y-m-d', strtotime(trim($tgl[1])));
		} else {
			$tgl2=date('Y-m-d');
			$tgl1=date('Y-m-d',strtotime($tgl2 . "-5 days"));
					
		}

		
		
		
		$data['title']='INPUT PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		$param_dtlref_query=" and to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2'";
		$param_cekmapdtlref=" and nodok='$nama' and status<>'M'";
		
				
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pembelian->q_trxerror($paramerror)->row_array();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
	
			if($this->uri->segment(4)!=""){
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}else {
				$data['message']="";
			}
		
		$cek_tmp_po=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->num_rows();
		if ($cek_tmp_po==0){
			$info = array (
			'branch'	=> $branch,
			'nodok'     => $nama,
			'loccode'   => $kdcabang,
			'podate'    => date('Y-m-d H:i:s'),
			'status'    => 'I',
			'inputby'   => $nama,
			'inputdate' => date('Y-m-d H:i:s'),
			
			);
			$this->db->insert('sc_tmp.po_mst',$info);
		} 
		$paramx='';
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_tmp_po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
		$data['list_tmp_po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
		$data['list_tmp_po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
		$data['row_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
		$data['list_tmp_po_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
		$data['row_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
		$data['cek_full_mappdtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
		
		$this->template->display('ga/pembelian/v_input_po',$data);
		$this->m_pembelian->q_deltrxerror($paramerror);
	}
	function clear_tmp_po(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/pembelian/form_pembelian");
		}		
			$param3_1_2=" and nodok='$nodok'";
			$dtledit=$this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  kecuali A */
			if ($status=='E') {
				$info = array (
						'status' => 'A',
						'updatedate' => null,
						'updateby' => null,										
				);
				$infodtl = array (
						'status' => 'A',								
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtl',$infodtl);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtlref',$infodtl);
				
				
				$info2 = array (
					'status' => '',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.po_dtlref',$info2); 
						
				
			} else if ($status=='I'){
				$info = array (
						'status' => 'A',
						'inputdate' => null,
						'inputby' => null,										
				);
				$infodtl = array (
						'status' => 'A',								
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtl',$infodtl);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtlref',$infodtl);
			} else if ($status=='C'){
				$info = array (
						'status' => 'A',
						'canceldate' => null,
						'cancelby' => null,										
				);
				$infodtl = array (
						'status' => 'A',								
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtl',$infodtl);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtlref',$infodtl);
			}
				
			
			/* clearing temporary  */
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.po_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.po_dtl');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.po_dtlref');
				
		redirect("ga/pembelian/form_pembelian/del_succes");
	}
	
	function clear_tmp_po_hangus(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/pembelian/form_pembelian");
		}		
			$param3_1_2=" and nodok='$nodok'";
			$dtledit=$this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  kecuali A */
			if ($status=='H') {
				$info = array (
						'status' => 'P',
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtl',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.po_dtlref',$info);
			} 
				
			$info2 = array (
				'status' => '',
			);
			$this->db->where('nodok',$nama);
			$this->db->update('sc_tmp.po_dtlref',$info2);
				
			/*}
	////		$this->db->where('nodok',$nodoktmp);
	////		$this->db->update('sc_trx.sppb_dtl',$info); */
			
			
			/* clearing temporary  */
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.po_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.po_dtl');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.po_dtlref');
				
			redirect("ga/pembelian/form_pembelian/del_succes");
	}
		
	function tambah_itempo(){
		$lb=$this->input->post('centang');
		$nik=$this->input->post('nik');
		$nama=$this->session->userdata('nik');
		$username=$this->input->post('username');
		
		if(empty($lb)){
			redirect("ga/pembelian/input_po");
		}
		foreach($lb as $index => $temp){
			$strtrimref=trim(preg_replace('/\s\s+/', ' ', $lb[$index]));
			$strtrimref=trim($lb[$index]);
			$param_dtlref_query=" and strtrimref='$strtrimref'";
			//$param_dtlref_query=" and rowid='$strtrimref'";
			$dtl=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->row_array();
			
			$this->db->where('nodok',$nama);
			$this->db->where('nodokref',trim(strtoupper($dtl['nodok'])));
			$this->db->where('nik',trim(strtoupper($dtl['nik'])));
			$this->db->where('desc_barang',trim(strtoupper($dtl['desc_barang'])));
			$this->db->delete('sc_tmp.po_dtlref');
			
			$cekpodtlref=$this->m_pembelian->q_tmp_po_dtlref_param($param_dtlref_query)->num_rows();
			if ($cekpodtlref>0){
				//redirect("ga/pembelian/input_po/data_used");
							$this->db->where('userid',$nama);
							$this->db->where('modul','TMPPO');
							$this->db->delete('sc_mst.trxerror');
							$insinfo = array (
								'userid' => $nama,
								'errorcode' => 5,
								'modul' => 'TMPPO'
							);
							$this->db->insert('sc_mst.trxerror',$insinfo);
							redirect('/ga/pembelian/form_pembelian');
			}
			
			
			
			$info[$index]['branch']=trim(strtoupper($dtl['branch']));
			$info[$index]['nodok']=$nama;
			$info[$index]['nik']=trim(strtoupper($dtl['nik']));
			$info[$index]['nodokref']=trim(strtoupper($dtl['nodok']));
			$info[$index]['kdgroup']=trim(strtoupper($dtl['kdgroup']));
			$info[$index]['kdsubgroup']=trim(strtoupper($dtl['kdsubgroup']));
			$info[$index]['stockcode']=trim(strtoupper($dtl['stockcode']));
			$info[$index]['loccode']=trim(strtoupper($dtl['loccode']));
			$info[$index]['desc_barang']=trim(strtoupper($dtl['desc_barang']));
			$info[$index]['qtykecil']=0;
			$info[$index]['qtyminta']=trim(strtoupper($dtl['qtyminta']));
			$info[$index]['satminta']=trim(strtoupper($dtl['satminta']));
			$info[$index]['status']='I';
			$info[$index]['keterangan']=trim(strtoupper($dtl['keterangan']));
			$info[$index]['qtyminta_tmp']=trim(strtoupper($dtl['qtyminta']));
			$info[$index]['id']=trim(strtoupper($dtl['id']));;

		}
		$insert = $this->m_pembelian->add_po_dtlref($info);
		redirect("ga/pembelian/form_pembelian");
	}
	
	function kurang_itempo(){
		$lb=$this->input->post('centang');
		$nik=$this->input->post('nik');
		$nama=$this->session->userdata('nik');
		$username=$this->input->post('username');
		$param_dtlref_cekmap=" nodok=$nama and status='M'";
		if(empty($lb)){
			redirect("ga/pembelian/form_pembelian");
		}
		
		/*$cek_po_dtlref=$this->m_pembelian->q_tmp_po_dtlref_param($param_dtlref_cekmap)->num_rows();
		if($cek_po_dtlref>0){
			redirect("ga/pembelian/input_po/fail_after_mapping");
		}*/
		
		foreach($lb as $index => $temp){
			$rowid.=trim($lb[$index]).',';
		}
		$newrow=rtrim($rowid,',');
		///echo substr_replace($rowid, "", -1);
		$param_dtlref=" and rowid in ($newrow)";
		$dtl_result=$this->m_pembelian->q_tmp_po_dtlref_param($param_dtlref)->result();
		foreach ($dtl_result as $ls) {
			
				$this->db->delete('sc_tmp.po_dtlref', array(
				'nodok' => $nama,
				'desc_barang' => trim(strtoupper($ls->desc_barang)),
				'nodokref' => trim(strtoupper($ls->nodokref))));
		}
		redirect("ga/pembelian/form_pembelian"); 
	}

	function reset_po_dtlrev(){
				$nama=$this->session->userdata('nik');
				$this->db->delete('sc_tmp.po_dtlref', array('nodok' => $nama));
				$this->db->delete('sc_tmp.po_dtl', array('nodok' => $nama));
		redirect("ga/pembelian/form_pembelian/reset_success"); 
	}
	
	function mapping_po_dtlrev(){
		$rowid=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama' and rowid='$rowid'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$dtlforparam=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->row_array();
/* 		$kdgroup=trim($dtlforparam['kdgroup']);
		$kdsubgroup=trim($dtlforparam['kdsubgroup']);
		$stockcode=trim($dtlforparam['stockcode']); */
		//$paramx=" and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
		//$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$paramx="";
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit_full($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_tmp_po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
		$data['po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->row_array();
		$this->template->display('ga/pembelian/v_mapping_po_dtlrev',$data);
	}
	
	function remapping_po_dtl(){
		$rowid=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		
		$param_tmp_mst=" and nodok='$nama'";
		$param_tmp_po=" and nodok='$nama' and id='$rowid'";
		
		/* CEK MASTER SUPPLIER HARUS TERISI TERLEBIH DAHULU*/
		$param_cek_supplier=" and nodok='$nama' and coalesce(kdsubsupplier,'')='' ";
		$cek_sup=$this->m_pembelian->q_tmp_po_mst_param($param_cek_supplier)->num_rows();
		if($cek_sup>0){
			$this->db->where('userid',$nama);
			$this->db->where('modul','TMPPO');
			$this->db->delete('sc_mst.trxerror');
			$insinfo = array (
				'userid' => $nama,
				'errorcode' => 4,
				'modul' => 'TMPPO'
			);
			$this->db->insert('sc_mst.trxerror',$insinfo);
			redirect('/ga/pembelian/form_pembelian');
			
		}
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$po_dtl=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();
		$kdgroup=trim($po_dtl['kdgroup']);
		$kdsubgroup=trim($po_dtl['kdsubgroup']);
		$stockcode=trim($po_dtl['stockcode']);
		$param1=" and loccode='$kdcabang' ";
		$param2=" and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode' ";
		
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_mst)->row_array();
		$data['po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();

		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($param2)->result();
		
		//$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		
		
		
		$this->template->display('ga/pembelian/v_remapping_po_dtl',$data);
	}
	
	function hapus_detail_inputpo(){
		$rowid=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$param1="and nodok='$nama' and id='$rowid'";
		$dtl=$this->m_pembelian->q_tmp_po_dtl_param($param1)->row_array();
		
		
		$this->db->where('nodok',$nama);
		$this->db->where('id',$rowid);
		$this->db->delete('sc_tmp.po_dtl');
		
		
		$nodok=$nama;
		$kdgroup=trim($dtl['kdgroup']);
		$kdsubgroup=trim($dtl['kdsubgroup']);
		$stockcode=trim($dtl['stockcode']);
		
		$this->db->where('nodok',$nodok);
		$this->db->where('kdgroup',$kdgroup);
		$this->db->where('kdsubgroup',$kdsubgroup);
		$this->db->where('stockcode',$stockcode);
		$this->db->delete('sc_tmp.po_dtlref');
		
		redirect("ga/pembelian/input_po/del_succes");
	}
	
	function detail_po_dtl(){
		$rowid=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nodok=substr(trim($this->encrypt->decode(hex2bin(trim($this->uri->segment(4))))), 0,10);
		$nama=$this->session->userdata('nik');
		$data['title']='MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$param_trx_mst=" and nodok='$nodok'";
		$param_trx_po=" and rowselect='$rowid'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit_full($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_trx_po_mst_param($param_trx_mst)->row_array();
		$data['po_dtl']=$this->m_pembelian->q_trx_po_dtl_param($param_trx_po)->row_array();
		$this->template->display('ga/pembelian/v_detail_po_dtl',$data);
	}
	
	function detail_po_dtl_tmp(){
		$rowid=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_mst=" and nodok='$nama'";
		$param_tmp_po=" and nodok='$nama' and id='$rowid'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_mst)->row_array();
		$data['po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();
		$this->template->display('ga/pembelian/v_detail_po_dtl_tmp.php',$data);
	}
	
	function detail_po_dtl_tmp_hangus(){
		$rowid=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='UBAH HARGA HANGUS ITEM PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_mst=" and nodok='$nama'";
		$param_tmp_po=" and nodok='$nama' and id='$rowid'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_mst)->row_array();
		$data['po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();
		$this->template->display('ga/pembelian/v_detail_po_dtl_tmp_hangus.php',$data);
	}
	
	function input_supplier_po_mst(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='Input/Edit Supplier Master PO';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
		$this->template->display('ga/pembelian/v_input_supplier_po_mst',$data);
	}
	
	function detail_supplier_po_mst_tmp(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='Detail Supplier Master PO';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
		$this->template->display('ga/pembelian/v_detail_supplier_po_mst_tmp',$data);
	}
	
	function detail_supplier_po_mst(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$data['title']='Detail Supplier Master PO';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_trx_po=" and nodok='$nodok'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['po_mst']=$this->m_pembelian->q_trx_po_mst_param($param_trx_po)->row_array();
		$this->template->display('ga/pembelian/v_detail_supplier_po_mst',$data);
	}
	
	function save_po(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nik=strtoupper($this->input->post('nik'));
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper($this->input->post('nodokref'));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		$loccode=strtoupper($this->input->post('loccode'));
		$desc_barang=strtoupper($this->input->post('desc_barang'));
		$qtyunit=strtoupper($this->input->post('qtyunit'));
		$satminta=strtoupper($this->input->post('satminta'));
		$pkp=strtoupper($this->input->post('pkp'));
		$podate=strtoupper($this->input->post('podate'));
		$exppn=strtoupper($this->input->post('exppn'));
		$qtyminta=(strtoupper(trim($this->input->post('qtyminta')))=='' ? '0' : strtoupper(trim($this->input->post('qtyminta'))));
		$satkecil=strtoupper($this->input->post('satkecil'));
		$qtykecil=(strtoupper(trim($this->input->post('qtykecil')))=='' ? '0' : strtoupper(trim($this->input->post('qtykecil'))));
		$unitprice=(strtoupper(trim($this->input->post('unitprice')))=='' ? '0' : str_replace('.','',(trim($this->input->post('unitprice')))));	
		$checkdisc=strtoupper($this->input->post('checkdisc'));
		if ($checkdisc=='NO') {
			$disc1=0;
			$disc2=0;
			$disc3=0;
			$disc4=0;
		} else {
			$disc1=str_replace(',','.',(strtoupper(trim($this->input->post('disc1')))=='' ? '0' : str_replace('.','',(trim($this->input->post('disc1'))))));
			$disc2=str_replace(',','.',(strtoupper(trim($this->input->post('disc2')))=='' ? '0' : str_replace('.','',(trim($this->input->post('disc2'))))));
			$disc3=str_replace(',','.',(strtoupper(trim($this->input->post('disc3')))=='' ? '0' : str_replace('.','',(trim($this->input->post('disc3'))))));
			$disc4=str_replace(',','.',(strtoupper(trim($this->input->post('disc4')))=='' ? '0' : str_replace('.','',(trim($this->input->post('disc4'))))));
		}

		$ttldpp=(strtoupper(trim($this->input->post('ttldpp')))=='' ? '0' : str_replace('.','',(trim($this->input->post('ttldpp')))));
		$ttldiskon=(strtoupper(trim($this->input->post('ttldiskon')))=='' ? '0' : str_replace('.','',(trim($this->input->post('ttldiskon')))));
		$ttlbrutto=(strtoupper(trim($this->input->post('ttlbrutto')))=='' ? '0' : str_replace('.','',(trim($this->input->post('ttlbrutto')))));
		$ttlnetto=(strtoupper(trim($this->input->post('ttlnetto')))=='' ? '0' : str_replace('.','',(trim($this->input->post('ttlnetto')))));
		$payterm=strtoupper(trim($this->input->post('payterm')));
		$ttlppn=(strtoupper(trim($this->input->post('ttlppn')))=='' ? '0' : str_replace('.','',(trim($this->input->post('ttlppn')))));
		$qtypo=(strtoupper(trim($this->input->post('qtypo')))=='' ?  '0' : strtoupper(trim($this->input->post('qtypo'))));
		$qtyreceipt=(strtoupper(trim($this->input->post('qtyreceipt')))=='' ?  '0' : strtoupper(trim($this->input->post('qtyreceipt'))));
		$kdgroupsupplier=strtoupper(trim($this->input->post('kdgroupsupplier')));
		$kdsupplier=strtoupper(trim($this->input->post('kdsupplier')));
		$kdsubsupplier=strtoupper(trim($this->input->post('kdsubsupplier')));
		$kdcabangsupplier=strtoupper(trim($this->input->post('kdcabangsupplier')));
		$rowid=strtoupper(trim($this->input->post('id')));
		
		$keterangan=strtoupper($this->input->post('keterangan'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		
		if ($type=='INPUT'){
			if (empty($stockcode)) {
					redirect("ga/pembelian/form_pembelian");
			}
			$info = array (
				'branch' => $branch,
				'nodok' => $nama,
				'nodokref' => $nodokref,
				'kdgroup' => $kdgroup,
				'kdsubgroup' => $kdsubgroup,
				'stockcode' => $stockcode,
				'loccode' => $loccode,
				'desc_barang' => $desc_barang,
				'unitprice' => $unitprice,
				'qtytotalprice' => $qtytotalprice,
				'qtypo' => $qtypo,
				'qtyreceipt' => $qtyreceipt,
				'qtyunit' => $qtyunit,
				'kdgroupsup' => $kdgroupsup,
				'kdsupplier' => $kdsupplier,
				'kdsubsupplier' => $kdsubsupplier,
				'status' => 'I',
				'keterangan' => $keterangan,
				'inputdate' => $inputdate,
				'inputby' => $inputby,
		
				);
				$this->db->insert('sc_tmp.po_order',$info);
				redirect("ga/pembelian/form_pembelian/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
						'nodokref' => $nodokref,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'unitprice' => $unitprice,
						'qtytotalprice' => $qtytotalprice,
						'qtypo' => $qtypo,
						'qtyreceipt' => $qtyreceipt,
						'qtyunit' => $qtyunit,
						'kdgroupsup' => $kdgroupsup,
						'kdsupplier' => $kdsupplier,
						'kdsubsupplier' => $kdsubsupplier,
						'status' => 'A',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/inp_succes");
		}  else if ($type=='MAPREVITEM') {
				$info = array (
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'satminta' => $satminta,
						'qtyminta' => $qtyminta,
						'satkecil' => $satkecil,
						'qtykecil' => $qtykecil,
						'status' => 'I',
				);
				$this->db->where('desc_barang',$desc_barang);
				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('nik',$nik);
				$this->db->update('sc_tmp.po_dtlref',$info);
				redirect("ga/pembelian/input_po/app_succes");
		}   else if ($type=='MAP_PODTL_ITEM') {
				$info = array (
						'unitprice' => $unitprice,
						'disc1' => $disc1,
						'disc2' => $disc2,
						'disc3' => $disc3,
						'disc4' => $disc4,
						'pkp' => $pkp,
						'exppn' => $exppn,
						'satminta' => $satminta,
						'qtyminta' => $qtyminta,
						'satkecil' => $satkecil,
						'qtykecil' => $qtykecil,
						'ttlbrutto' => $ttlbrutto,
						'status' => '',
						'keterangan' => $keterangan,
				);
				//$this->db->where('id',$rowid);
				$this->db->where('nodok',$nodok);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_tmp.po_dtl',$info);
				redirect("ga/pembelian/input_po/app_succes");
		}   else if ($type=='MAP_PODTL_ITEM_EDIT') {
			$param_tmpmst=" and nodok='$nama'";
			$dtl_tmpmst=$this->m_pembelian->q_tmp_po_mst_param($param_tmpmst)->row_array();
			$nodoktmp=trim($dtl_tmpmst['nodoktmp']);
			$enc_nodoktmp=bin2hex($this->encrypt->encode(trim($nodoktmp)));
		
			
				$info = array (
						'unitprice' => $unitprice,
						'disc1' => $disc1,
						'disc2' => $disc2,
						'disc3' => $disc3,
						'disc4' => $disc4,
						'pkp' => $pkp,
						'exppn' => $exppn,
						'satminta' => $satminta,
						'qtyminta' => $qtyminta,
						'satkecil' => $satkecil,
						'qtykecil' => $qtykecil,
						'ttlbrutto' => $ttlbrutto,

						'status' => '',
						'keterangan' => $keterangan,
				);
				//$this->db->where('id',$rowid);
				$this->db->where('nodok',$nodok);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_tmp.po_dtl',$info); 
				redirect("ga/pembelian/edit_po_atk/$enc_nodoktmp/app_succes");
		}   else if ($type=='ADD_SUPPLIER_MST') {
				$info = array (

						'podate' => $podate,
						'disc1' => $disc1,
						'disc2' => $disc2,
						'disc3' => $disc3,
						'disc4' => $disc4,
						'pkp' => $pkp,
						'exppn' => $exppn,
						'payterm' => $payterm,
						'kdgroupsupplier' => $kdgroupsupplier,
						'kdsupplier' => $kdsupplier,
						'kdsubsupplier' => $kdsubsupplier,
						'kdcabangsupplier' => $kdcabangsupplier,
						'status' => '',
						'keterangan' => $keterangan,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.po_mst',$info);
				/* INSERT TRX ERROR */
				$param1error=0;
				$param2error=$nama;
				$this->m_pembelian->ins_trxerror($param1error,$param2error);
				
				redirect("ga/pembelian/input_po/app_succes");
		} else if ($type=='EDIT_SUPPLIER_MST') {
				$param_tmpmst=" and nodok='$nama'";
				$dtl_tmpmst=$this->m_pembelian->q_tmp_po_mst_param($param_tmpmst)->row_array();
				$nodoktmp=trim($dtl_tmpmst['nodoktmp']);
				$enc_nodoktmp=bin2hex($this->encrypt->encode(trim($nodoktmp)));
				$info = array (
						'podate' => $podate,
						'disc1' => $disc1,
						'disc2' => $disc2,
						'disc3' => $disc3,
						'disc4' => $disc4,
						'pkp' => $pkp,
						'exppn' => $exppn,
						'payterm' => $payterm,
						'kdgroupsupplier' => $kdgroupsupplier,
						'kdsupplier' => $kdsupplier,
						'kdsubsupplier' => $kdsubsupplier,
						'kdcabangsupplier' => $kdcabangsupplier,
						'status' => '',
						'keterangan' => $keterangan,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.po_mst',$info);
				/* INSERT TRX ERROR */
				$param1error=0;
				$param2error=$nama;
				$this->m_pembelian->ins_trxerror($param1error,$param2error);
				redirect("ga/pembelian/edit_po_atk/$enc_nodoktmp/edit_succes");
		} else if ($type=='APPROVAL') {
				$info = array (
						'status' => 'P',
						'approvaldate' => $inputdate,
						'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/app_succes");
		}   else if ($type=='APPMAPING') {
						/* CEK MASTER SUPPLIER HARUS TERISI TERLEBIH DAHULU*/
				$param_cek_supplier=" and nodok='$nama' and coalesce(kdsubsupplier,'')='' ";
				$cek_sup=$this->m_pembelian->q_tmp_po_mst_param($param_cek_supplier)->num_rows();
				if($cek_sup>0){
					$this->db->where('userid',$nama);
					$this->db->where('modul','TMPPO');
					$this->db->delete('sc_mst.trxerror');
					$insinfo = array (
						'userid' => $nama,
						'errorcode' => 4,
						'modul' => 'TMPPO'
					);
					$this->db->insert('sc_mst.trxerror',$insinfo);
					redirect('/ga/pembelian/form_pembelian');
					
				} else {
				
					$info1 = array (
							'qtyminta' => $qtyminta,
							'status' => 'M',
					);
					$this->db->where('nodok',$nodok);
					$this->db->where('nodokref',$nodokref);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->where('id',$rowid);
					$this->db->update('sc_tmp.po_dtlref',$info1);
					
					
					$info_dtl = array (
							'status' => '',
					);
					$this->db->update('sc_tmp.po_dtl',$info_dtl);
					
					
					redirect("ga/pembelian/input_po/app_succes");
				}
		} else if ($type=='DELETE') {
				$info = array (
						'status' => 'C',
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/del_succes");
		} else if ($type=='UPDATE_HARGA_HANGUS') {
				$param_tmpmst=" and nodok='$nama'";
				$dtl_tmpmst=$this->m_pembelian->q_tmp_po_mst_param($param_tmpmst)->row_array();
				$nodoktmp=trim($dtl_tmpmst['nodoktmp']);
				$enc_nodoktmp=bin2hex($this->encrypt->encode(trim($nodoktmp)));
				$info = array (

						'ttlbrutto' => $ttlbrutto,
						'status' => ''
				);
				$this->db->where('id',$rowid);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.po_dtl',$info);
				redirect("ga/pembelian/hangus_po_atk/$enc_nodoktmp/app_succes");
		} else {
			redirect("ga/pembelian/form_pembelian");
		}
	}
	
	function final_input_po(){
		$enc_nik=trim($this->uri->segment(4));
		$nama=trim($this->session->userdata('nik'));
		$nodok=$this->encrypt->decode(hex2bin($enc_nik));
			$info = array (
					'status' => 'A',
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_tmp.po_mst',$info);
			
			$paramerror=" and userid='$nama'";
			$dtlerror=$this->m_pembelian->q_trxerror($paramerror)->row_array();
			if (isset($dtlerror['errorcode'])) { $errorcode=(trim($dtlerror['errorcode'])); $nodoktmp=($dtlerror['nomorakhir1']); } else { $errorcode=''; };
			
			if ($errorcode>0) {
				redirect("ga/pembelian/form_pembelian/inp_succes");
			} else if ($errorcode==0) {
				redirect("ga/pembelian/form_pembelian/success_input/$nodoktmp");
			}
			
	}
	
	function final_approval_po(){
		$enc_nik=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');
		$nodok=$this->encrypt->decode(hex2bin($enc_nik));
			$info = array (
					'status' => 'F',
					'approvaldate' => date('Y-m-d H:i:s'),
					'approvalby' => $nama,
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_tmp.po_mst',$info);
			redirect("ga/pembelian/form_pembelian/inp_succes");
	}
	
	function final_batal_po(){
		$enc_nik=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');
		$nodok=$this->encrypt->decode(hex2bin($enc_nik));
			$info = array (
					'status' => 'F',
					'canceldate' => date('Y-m-d H:i:s'),
					'cancelby' => $nama,
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_tmp.po_mst',$info);
			redirect("ga/pembelian/form_pembelian/inp_succes");
	}
	function final_hangus_po(){
		$enc_nik=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');
		$nodok=$this->encrypt->decode(hex2bin($enc_nik));
			$info = array (
					'status' => 'F',
					'hangusdate' => date('Y-m-d H:i:s'),
					'hangusby' => $nama,
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_tmp.po_mst',$info);
			redirect("ga/pembelian/form_pembelian/inp_succes");
	}
	
	function cobapagin(){
		$nama=$this->session->userdata('nik');
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if (($ceknikatasan1)>0 and $userhr==0 ){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			$param_list2=1;
		}
		else if (($ceknikatasan2)>0 and $userhr==0 ){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
			$param_list2=1;		
		}
		else {
			$param_list_akses=" and nik='$nama' ";
			$param_list2=0;
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		
		
		
		
		$list = $this->m_pembelian->get_list_po();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lpo) {
			$enc_nodok=bin2hex($this->encrypt->encode(trim($lpo->nodok)));
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $lpo->nodok;		
			$row[] = $lpo->nmsubsupplier;
			$row[] = $lpo->ketstatus;
			$row[] = ' <span class="pull-right" >'.number_format($lpo->ttlnetto).' </span>';
			$row[] = $lpo->inputby;
			if (isset($lpo->inputdate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->inputdate))); } else { $row[] = ''; } 
			$row[] = $lpo->approvalby;
			if(isset($lpo->approvaldate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->approvaldate))); } else { $row[] ='';} 
			$row[] = $lpo->keterangan;
			if ((trim($lpo->status)!='A') AND (trim($lpo->status)!='P')) {
			$row[] = 
			'<a class="btn btn-sm btn-default" href="'.site_url('ga/pembelian/detail_po_atk').'/'.$enc_nodok.'" title="Edit PO"><i class="glyphicon glyphicon-search"></i> Detail </a>';
			} else if (trim($lpo->status)=='P' or trim($lpo->status)=='S') {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/pembelian/detail_po_atk').'/'.$enc_nodok.'" title="Edit PO"><i class="glyphicon glyphicon-search"></i> Detail </a>
			<a class="btn btn-sm btn-warning" href="'.site_url('ga/pembelian/sti_po_final').'/'.trim($lpo->nodok).'" title="Cetak PO"><i class="glyphicon glyphicon-search"></i> Cetak </a>
			<a class="btn btn-sm btn-danger" href="'.site_url('ga/pembelian/hangus_po_atk').'/'.$enc_nodok.'" title="Hangus PO"><i class="glyphicon glyphicon-search"></i> Hangus </a>';
			} else if ((trim($lpo->status)=='A' and $param_list2==1) or $userhr>0) {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/pembelian/detail_po_atk').'/'.$enc_nodok.'" title="Edit PO"><i class="glyphicon glyphicon-search"></i> Detail </a>
			<a class="btn btn-sm btn-primary" href="'.site_url('ga/pembelian/edit_po_atk').'/'.$enc_nodok.'" title="Edit PO"><i class="glyphicon glyphicon-pencil"></i> Edit </a>
			<a class="btn btn-sm btn-danger" href="'.site_url('ga/pembelian/batal_po_atk').'/'.$enc_nodok.'" title="Hapus PO"><i class="glyphicon glyphicon-trash"></i> Batal </a>'.
			'<a class="btn btn-sm btn-success" href="'.site_url('ga/pembelian/approval_po_atk').'/'.$enc_nodok.'" title="Approval PO"><i class="glyphicon glyphicon-pencil"></i> Approval </a>';
			
			} else if (trim($lpo->status)=='A' and $param_list2==0) {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/pembelian/detail_po_atk').'/'.$enc_nodok.'" title="Edit PO"><i class="glyphicon glyphicon-search"></i> Detail </a>
			<a class="btn btn-sm btn-primary" href="'.site_url('ga/pembelian/edit_po_atk').'/'.$enc_nodok.'" title="Edit PO"><i class="glyphicon glyphicon-pencil"></i> Edit </a>
			<a class="btn btn-sm btn-danger" href="'.site_url('ga/pembelian/batal_po_atk').'/'.$enc_nodok.'" title="Hapus PO"><i class="glyphicon glyphicon-trash"></i> Batal </a>';		
			}
 	
			/*
			<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
			<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
			<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a>
			<a  data-url="'.site_url('ga/pembelian/form_pembelian/modal_edit_po_atk').'/'.trim($lpo->nodok).'" data-toggle="modal" data-target=".pp" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT
			*/
			$data[] = $row;
		}
    
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_pembelian->q_listpembelian()->num_rows(),
						"recordsFiltered" => $this->m_pembelian->q_listpembelian()->num_rows(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
				//echo '1342';
	}
	
	function edit_po_atk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	
	 	$nama=trim($this->session->userdata('nik'));
		$data['title']='EDIT PEMBELIAN/PURCHASE ORDER (PO)';
		
		
		$tgl=explode(' - ',trim($this->input->post('tgl')));
		if(isset($tgl[0]) and isset($tgl[1])) {
			$tgl1=date('Y-m-d', strtotime(trim($tgl[0])));
			$tgl2=date('Y-m-d', strtotime(trim($tgl[1])));
		} else {
			$tgl2=date('Y-m-d');
			$tgl1=date('Y-m-d',strtotime($tgl2 . "-5 days"));
					
		}
		
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		$param_dtlref_query="";
		$param_cekmapdtlref=" and nodok='$nama' and status<>'M'";
		
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pembelian->q_trxerror($paramerror)->row_array();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if($this->uri->segment(5)!=""){
			$data['message']="<div class='alert alert-info'>$errordesc</div>";
		}else {
			$data['message']="";
		}
	
		$param_trxapprov=" and nodok='$nodok' and status in ('P','D','C','H')";
		$cek_trxapprov=$this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
		}	
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodoktmp='$nodok'";
		$param4_first=" and nodok='$nama'";
		$cek_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
		$cek_first_nik=$this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();
		
		
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_pembelian/edit_failed_doc/$nodokfirst");
		} else {
				$info = array (
					'status' => 'E',
					'updateby' => $nama,
					'updatedate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_mst',$info);
		}
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_tmp_po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
		$data['list_tmp_po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
		$data['list_tmp_po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
		$data['row_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
		$data['list_tmp_po_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
		$data['row_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
		$data['cek_full_mappdtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
		
		$this->template->display('ga/pembelian/v_edit_po',$data); 
		$this->m_pembelian->q_deltrxerror($paramerror);
	}
	
	function approval_po_atk($enc_nodok){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	
	 	$nama=trim($this->session->userdata('nik'));
		$data['title']='APPROVAL PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		$param_dtlref_query=" and nodok='x'";
		$param_cekmapdtlref=" and nodok='$nama' and status<>'M'";
		
		$param_trxapprov=" and nodok='$nodok' and status in ('P','D','C','H')";
		$cek_trxapprov=$this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
		}	
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodoktmp='$nodok'";
		$param4_first=" and nodok='$nama'";
		$cek_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
		$cek_first_nik=$this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();
		
		
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_pembelian/edit_failed_doc/$nodokfirst");
		} else {
				$info = array (
					'status' => 'A',
					'updateby' => $nama,
					'updatedate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_mst',$info);
		}
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit_full($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_tmp_po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
		$data['list_tmp_po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
		$data['list_tmp_po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
		$data['row_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
		$data['list_tmp_po_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
		$data['row_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
		$data['cek_full_mappdtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
		
		$this->template->display('ga/pembelian/v_approval_po',$data);
				
	}
	
	function detail_po_atk($enc_nodok){
		$nodok=$this->encrypt->decode(hex2bin($enc_nodok));
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param2_1=" and nodok='$nodok'";
		$param_trx_po=" and nodok='$nodok'";
		$param_dtlref_query="and nodok='xaeradFAWEFADSFAS3eadAEawdf123sfQESEDGASD'";
		$param_cekmapdtlref=" and nodok='x'";
		
		$data['title']='DETAIL ORDER PEMBELIAN ATK';
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_trx_po_mst']=$this->m_pembelian->q_trx_po_mst_param($param_trx_po)->result();
		$data['list_trx_po_dtl']=$this->m_pembelian->q_trx_po_dtl_param($param_trx_po)->result();
		$data['list_trx_po_dtlref']=$this->m_pembelian->q_trx_po_dtlref_param($param_trx_po)->result();
		$data['row_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_trx_po)->num_rows();
		$data['list_trx_po_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->result();
		$data['row_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->num_rows();
		$data['cek_full_mappdtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
		
		$this->template->display('ga/pembelian/v_detail_po',$data);
				
	}
	
	function batal_po_atk($enc_nodok){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	
	 	$nama=trim($this->session->userdata('nik'));
		$data['title']='BATAL PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		$param_dtlref_query=" and nodok='x'";
		$param_cekmapdtlref=" and nodok='$nama' and status<>'M'";
		
		$param_trxapprov=" and nodok='$nodok' and status in ('P','H')";
		$cek_trxapprov=$this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
		}	
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodoktmp='$nodok'";
		$param4_first=" and nodok='$nama'";
		$cek_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
		$cek_first_nik=$this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();
		
		
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_pembelian/edit_failed_doc/$nodokfirst");
		} else {
				$info = array (
					'status' => 'C',
					'cancelby' => $nama,
					'canceldate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_mst',$info);
		}
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_tmp_po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
		$data['list_tmp_po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
		$data['list_tmp_po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
		$data['row_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
		$data['list_tmp_po_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
		$data['row_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
		$data['cek_full_mappdtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
		
		$this->template->display('ga/pembelian/v_batal_po',$data);
	}
	
	function hangus_po_atk($enc_nodok){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	
	 	$nama=trim($this->session->userdata('nik'));
		$data['title']='HANGUS PEMBELIAN/PURCHASE ORDER (PO)';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$param_tmp_po=" and nodok='$nama'";
		$param_dtlref_query="";
		$param_cekmapdtlref=" and nodok='$nama' and status<>'M'";
		
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pembelian->q_trxerror($paramerror)->row_array();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
	
			if($this->uri->segment(5)!=""){
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}else {
				$data['message']="";
			}
		
	
		$param_trxapprov=" and nodok='$nodok' and status in ('U')";
		$cek_trxapprov=$this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
		}	
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodoktmp='$nodok'";
		$param4_first=" and nodok='$nama'";
		$cek_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
		$cek_first_nik=$this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
		$dtl_first=$this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();
		
		
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/pembelian/form_pembelian/hangus_failed_doc/$nodokfirst");
		} else {
				$info = array (
					'status' => 'H',
					'hangusby' => $nama,
					'hangusdate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_mst',$info);
		}
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['list_tmp_po_mst']=$this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
		$data['list_tmp_po_dtl']=$this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
		$data['list_tmp_po_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
		$data['row_dtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
		$data['list_tmp_po_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
		$data['row_dtlref_query']=$this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
		$data['cek_full_mappdtlref']=$this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
		
		$this->template->display('ga/pembelian/v_hangus_po',$data); 
		$this->m_pembelian->q_deltrxerror($paramerror);
	}
	
	
	function inquiry_pembelian(){
		$data['title']="FILTER HISTORY LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR";
		$data['kanwil']=$this->m_pembelian->q_mstkantor()->result();
		$this->template->display('ga/pembelian/v_filter_his_po',$data);
	}

	function dtl_inquiry_pembelian(){
		
		//$data['title']=$this->encryption->encrypt('HALO');
		//$data['title2']=$this->encryption->decrypt('HALO');
			//$this->encrypt->encode($smtp_pass);
			//$this->encrypt->decode($smtp_pass);
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.H.2';
						$versirelease='I.G.H.2/ALPHA.001';
						$userid=$this->session->userdata('nama');
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						if($versidb<>$versirelease){
							$infoversiold= array (
								'vreleaseold'   => $versidb,
								'vdateold'      => $vdb['vdate'],
								'vauthorold'    => $vdb['vauthor'],
								'vketeranganold'=> $vdb['vketerangan'],
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversiold);
							
							$infoversi= array (
								'vrelease'   => $versirelease,
								'vdate'      => date('2017-07-10 11:18:00'),
								'vauthor'    => 'FIKY',
								'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
								'update_date' => date('Y-m-d H:i:s'),
								'update_by'   => $userid,
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversi);
						}
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						$data['version']=$versidb;
						/* END CODE UNTUK VERSI */
								

		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
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
		
		//echo $tgl;
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		//$kdcabang=trim($dtlnik['kdcabang']);
		//$param1=" and loccode='$kdcabang'";
		
		$tgl=explode(' - ',trim($this->input->post('tgl')));
		$data['tgl1']=$tgl1=date('Y-m-d', strtotime(trim($tgl[0])));
		$data['tgl2']=$tgl2=date('Y-m-d', strtotime(trim($tgl[1])));
		$data['kdcabang']=$kdcabang=trim(strtoupper($this->input->post('loccode')));
		if (empty($kdcabang)){
			redirect("ga/pembelian/inquiry_pembelian");
		}
		
		$param2_1=" and (to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2') and loccode='$kdcabang' and status='P'";
		$data['title']="HISTORY LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR $kdcabang";
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_po']=$this->m_pembelian->q_listpembelian_param($param2_1)->result();
		//$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
        $this->template->display('ga/pembelian/v_list_po_historis',$data);
	}
	
	function filter_po_receipt(){
		$data['title']="FILTER PENERIMAAN BARANG DARI PEMBELIAN / PO RECEIPT";
		$data['kanwil']=$this->m_pembelian->q_mstkantor()->result();
		$this->template->display('ga/pembelian/v_filter_po_receipt',$data);
	}

	function dtl_po_receipt(){
		
		//$data['title']=$this->encryption->encrypt('HALO');
		//$data['title2']=$this->encryption->decrypt('HALO');
			//$this->encrypt->encode($smtp_pass);
			//$this->encrypt->decode($smtp_pass);
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.H.3';
						$versirelease='I.G.H.2/ALPHA.001';
						$userid=$this->session->userdata('nama');
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						if($versidb<>$versirelease){
							$infoversiold= array (
								'vreleaseold'   => $versidb,
								'vdateold'      => $vdb['vdate'],
								'vauthorold'    => $vdb['vauthor'],
								'vketeranganold'=> $vdb['vketerangan'],
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversiold);
							
							$infoversi= array (
								'vrelease'   => $versirelease,
								'vdate'      => date('2017-07-10 11:18:00'),
								'vauthor'    => 'FIKY',
								'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
								'update_date' => date('Y-m-d H:i:s'),
								'update_by'   => $userid,
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversi);
						}
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						$data['version']=$versidb;
						/* END CODE UNTUK VERSI */
								

		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
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
		
		//echo $tgl;
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		//$kdcabang=trim($dtlnik['kdcabang']);
		//$param1=" and loccode='$kdcabang'";
		
		$tgl=explode(' - ',trim($this->input->post('tgl')));
		$data['tgl1']=$tgl1=date('Y-m-d', strtotime(trim($tgl[0])));
		$data['tgl2']=$tgl2=date('Y-m-d', strtotime(trim($tgl[1])));
		$data['kdcabang']=$kdcabang=trim(strtoupper($this->input->post('loccode')));
		if (empty($kdcabang)){
			redirect("ga/pembelian/filter_po_receipt");
		}
		
		$param2_1=" and (to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2') and loccode='$kdcabang' and status='P'";
		$data['title']="DETAIL LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR $kdcabang";
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_po']=$this->m_pembelian->q_listpembelian_param($param2_1)->result();
		//$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
        $this->template->display('ga/pembelian/v_list_po_final',$data);
	}
	
	function po_receipt($enc_nodok){
		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$nodok=$this->encrypt->decode(hex2bin($enc_nodok));
		$data['title']="LIST TERIMA BARANG PO RECEIPT $nodok";
		$data['nodok']=$nodok;
		$param2_1=" and nodok='$nodok'";
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
				$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['dtl_po']=$this->m_pembelian->q_listpembelian_param($param2_1)->row_array();
		$data['qtypo']="QTY PO OUTSTANDING: 10";
		$data['list_po_receipt']=$this->m_pembelian->q_po_receipt($nodok)->result();
        $this->template->display('ga/pembelian/v_list_po_receipt',$data);
	}
	
	function save_po_receipt(){
		$nodokpo=strtoupper(trim($this->input->post('$nodokpo')));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$qtyreceipt=(strtoupper(trim($this->input->post('qtyreceipt')))=='' ?  '0' : strtoupper(trim($this->input->post('qtyreceipt'))));
		$enc_nodok=bin2hex(trim($this->encrypt->encode($nodokpo)));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		
		if ($type=='INPUT'){
			if (empty($nodokpo)) {
					redirect("ga/pembelian/po_receipt/$enc_nodok/fail_input");
			}
			$info = array (
					'nodokpo' => $nodokpo,
					'nodokref' => '',
					'qtyreceipt' => $qtyreceipt,
					'receiptdate' => $inputdate,
					'status' => $status,
					'keterangan' => $keterangan,
					'inputdate' => $inputdate,
					'inputby' => $inputby,
				
		
				);
				$this->db->insert('sc_trx.po_receipt',$info);
				redirect("ga/pembelian/po_receipt/$enc_nodok/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
						'nodokref' => $nodokref,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtyunitprice' => $qtyunitprice,
						'qtytotalprice' => $qtytotalprice,
						'qtypo' => $qtypo,
						'qtyreceipt' => $qtyreceipt,
						'qtyunit' => $qtyunit,
						'kdgroupsup' => $kdgroupsup,
						'kdsupplier' => $kdsupplier,
						'kdsubsupplier' => $kdsubsupplier,
						'status' => 'A',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/inp_succes");
		}  else if ($type=='APPROVAL') {
				$info = array (
						'status' => 'P',
						'approvaldate' => $inputdate,
						'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/app_succes");
		} else if ($type=='DELETE') {
				$info = array (
						'status' => 'C',
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/del_succes");
		} else {
			redirect("ga/pembelian/form_pembelian");
		}
		
	}
	
	
	function history_pricelist(){
		$data['title']="HISTORY PRICE LIST TERBARU ";
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$nama=$this->session->userdata('nik');
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.H.5';
						$versirelease='I.G.H.5/ALPHA.001';
						$userid=$this->session->userdata('nama');
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						if($versidb<>$versirelease){
							$infoversiold= array (
								'vreleaseold'   => $versidb,
								'vdateold'      => $vdb['vdate'],
								'vauthorold'    => $vdb['vauthor'],
								'vketeranganold'=> $vdb['vketerangan'],
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversiold);
							
							$infoversi= array (
								'vrelease'   => $versirelease,
								'vdate'      => date('2017-07-10 11:18:00'),
								'vauthor'    => 'FIKY',
								'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
								'update_date' => date('Y-m-d H:i:s'),
								'update_by'   => $userid,
							);               
							$this->db->where('kodemenu',$kodemenu);
							$this->db->update('sc_mst.version',$infoversi);
						}
						$vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
						$versidb=$vdb['vrelease'];
						$data['version']=$versidb;
						/* END CODE UNTUK VERSI */
								
	
		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_failed")
            $data['message']="<div class='alert alert-danger'>User masih ada dokumen yang belum selesai</div>";
		else if($this->uri->segment(4)=="edit_failed_doc") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen sedang diakses user $nodokfirst</div>";
		} else if($this->uri->segment(4)=="process_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen Sudah Terproses No Rev:: $nodokfirst</div>";
		} else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']="<div class='alert alert-success'></div>";
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
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
        $this->template->display('ga/pembelian/v_list_master_pricelist',$data);

	}
	
	function pagin_history_pricelist(){
		$nama=$this->session->userdata('nik');
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if (($ceknikatasan1)>0 and $userhr==0 ){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			$param_list2=1;
		}
		else if (($ceknikatasan2)>0 and $userhr==0 ){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
			$param_list2=1;		
		}
		else {
			$param_list_akses=" and nik='$nama' ";
			$param_list2=0;
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		

		$list = $this->m_pembelian->get_list_pricelist();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lpo) {
			$enc_stockcode=bin2hex($this->encrypt->encode(trim($lpo->stockcode)));
			$id=trim($lpo->id);
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = trim($lpo->stockcode);		
			$row[] = trim($lpo->nmbarang);		
			$row[] = ' <span class="pull-right" >'.number_format($lpo->qtykecil).' </span>'; 		
			$row[] = trim($lpo->nmsatkecil);		
			$row[] = ' <span class="pull-right" >'.number_format($lpo->unitprice).' </span>'; 		
			if (isset($lpo->pricedate)) { $row[] = date('d-m-Y H:i:s', strtotime(trim($lpo->pricedate))); } else { $row[] = ''; } 		
			$row[] = trim($lpo->nodokref);		
			$row[] = 			
			'<a class="btn btn-sm btn-default" href="'.site_url('ga/pembelian/edit_pricelst').'/'.$id.'" title="Edit PRICE LIST"><i class="glyphicon glyphicon-search"></i> DETAIL </a>';
			/*
			<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
			<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
			<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a>
			<a  data-url="'.site_url('ga/pembelian/form_pembelian/modal_edit_po_atk').'/'.trim($lpo->nodok).'" data-toggle="modal" data-target=".pp" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT
			*/
			$data[] = $row;
		}
    
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_pembelian->q_listpricelist()->num_rows(),
						"recordsFiltered" => $this->m_pembelian->q_listpricelist()->num_rows(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
				//echo '1342';
	}
	
	
	function edit_pricelst(){
		$id=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');
		///$data['title']='Input/Edit Supplier Master PO';
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		$pricelstparam=" and id='$id'";
		
		
		
		$enc_nik=bin2hex($this->encrypt->encode($nama));
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$data['list_scgroupatk']=$this->m_pembelian->q_scgroup_atk()->result(); //GROUP ATK
		$data['list_scsubgroup']=$this->m_pembelian->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_pembelian->q_mstbarang_atk()->result();
		$paramx='';
		$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
		$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
		$data['list_scgroup']=$this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
		$data['list_msupplier']=$this->m_pembelian->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_pembelian->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_pembelian->q_trxsupplier()->result();
		$data['pricelst']=$this->m_pembelian->q_pricelist_param($pricelstparam)->row_array();
		$this->template->display('ga/pembelian/v_edit_pricelst',$data);
	}
	
	function save_history_pricelst(){
		$id=trim($this->input->post('id'));
		$type=trim($this->input->post('type'));
		$unitprice=trim($this->input->post('unitprice'));
		$kdgroupsupplier=strtoupper(trim($this->input->post('kdgroupsupplier')));
		$kdsupplier=strtoupper(trim($this->input->post('kdsupplier')));
		$kdsubsupplier=strtoupper(trim($this->input->post('kdsubsupplier')));
		$kdgroupbarang=strtoupper(trim($this->input->post('kdgroupbarang')));
		$kdsubgroupbarang=strtoupper(trim($this->input->post('kdsubgroupbarang')));
		$stockcode=strtoupper(trim($this->input->post('stockcode')));
		$pkp=strtoupper(trim($this->input->post('pkp')));
		$qtykecil=strtoupper(trim($this->input->post('qtykecil')));
		$satkecil=strtoupper(trim($this->input->post('satkecil')));
		$unitprice=strtoupper(trim($this->input->post('unitprice')));
		$payterm=strtoupper(trim($this->input->post('payterm')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		
		if ($type=='EDIT_PRICELST') {
				$info = array (
					'branch          ' => $branch     ,
					'jenisprice      ' => 'I'        ,
					'satkecil        ' => $satkecil   ,
					'qtykecil        ' => $qtykecil   ,
					'payterm         ' => $payterm    ,
					'unitprice       ' => $unitprice  ,
					'updateby        ' => $updateby   ,
					'updatedate      ' => $updatedate ,
					'nodokref        ' => $nodokref   ,
					'pkp             ' => $pkp,
					'exppn           ' => $exppn,

				);
				$this->db->where('id',$id);
				$this->db->update('sc_mst.pricelst',$info);
				redirect("ga/pembelian/history_pricelist");
		} else if ($type=='DELETE') {
				$info = array (
						'status' => 'C',
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.po_order',$info);
				redirect("ga/pembelian/form_pembelian/del_succes");
		} else {
			redirect("ga/pembelian/form_pembelian");
		}
		
	}
	
	
	
	
	
	
	
}