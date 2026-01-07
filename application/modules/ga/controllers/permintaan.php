<?php
/*
	@author : Fiky
	@modul	: Permintaan Barang Dan Permintaan Pembelian
	13-10-2017
*/
//error_reporting(0)
class Permintaan extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_kendaraan','master/m_akses','m_supplier','m_permintaan','m_itemtrans'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/permintaan/v_index',$data);
	}
	

	function js_viewstock($stockcode){
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang' and stockcode='$stockcode'";
		$data = $this->m_permintaan->q_stkgdw_param1($param1)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
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
		
		$data = $this->m_permintaan->q_stkgdw_param1($param1)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
	}
			
	function form_permintaan(){
		$data['title']="LIST FORM PERMINTAAN BARANG KELUAR (PERSONAL)";
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.C.1';
						$versirelease='I.G.C.1/ALPHA.001';
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
		}  else if($this->uri->segment(4)=="process_fail") {
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF DOKUMEN INI SUDAH TERKUNCI TRANSAKSI KARENA SUDAH TERPROSES DOKUMEN:: $nodok</div>";
		}
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="inp_fail")
            $data['message']="<div class='alert alert-danger'>Dokumen tidak berhasil di input</div>";
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
        $tgl=explode(' - ',$this->input->post('tgl'));
        if(!empty($this->input->post('tgl')) or ($this->input->post('tgl'))<>'') {
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $paramdate=" and to_char(tgldok,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
        } else {
            $paramdate=" and to_char(tgldok,'yyyymm') = to_char(now(),'yyyymm') ";
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
		$param3_1_R=" and nodok='$nama'";
			$cekpbkdtl_na=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_1)->num_rows(); //input
			$cekpbkdtl_ne=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->num_rows(); //edit
			$cekpbkdtl_napp=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_3)->num_rows(); //edit
			$dtledit=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekpbkdtl_na>0) { //cek inputan
					$enc_nik=bin2hex($this->encrypt->encode($dtledit['nik']));
					redirect("ga/permintaan/input_personalpbk/$enc_nik");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekpbkdtl_ne>0){	//cek edit
					redirect("ga/permintaan/edit_pbk/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}  else if ($cekpbkdtl_napp>0){	//cek edit
					redirect("ga/permintaan/approval_pbk/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}
			
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0 )){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
					
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 

		$parameter=$param_list_akses.$paramdate;
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$data['ceknikatasan1']=$ceknikatasan1;
		/* END APPROVE ATASAN */
		

		//$data['list_pbk']=$this->m_permintaan->q_listpbk()->result();
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$data['list_pbk']=$this->m_permintaan->q_listpbk_param($parameter)->result();
        $this->template->display('ga/permintaan/v_listpersonalpbk',$data);
	}

		
	function list_personalnikpbk(){
		$data['title']='DATA KARYAWAN UNTUK PERMINTAAN BARANG KELUAR';
		$nama=$this->session->userdata('nik');
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses="and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */


		$data['list_nikpbk']=$this->m_akses->list_karyawan_param($param_list_akses)->result();
		$this->template->display('ga/permintaan/v_list_personalnikpbk',$data);
	}
	
	function input_personalpbk(){
		
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		
		$branch=strtoupper(trim($dtlbranch['branch']));
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$loccode'";
		$param_kanwil="";
	//	$param_inp=" and nodok='$nama'";
		///st_not_null
			$param_inp=" and nodok='$nama' or nik='$nik'";
			$param_inp_sc=" and nodok='$nama'";
		/* user hr akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/*user hr end */
		
		$cekpbkmst_inp=$this->m_permintaan->q_pbk_tmp_mst_param($param_inp)->num_rows();
		$cekpbkmst_inp_sc=$this->m_permintaan->q_pbk_tmp_mst_param($param_inp_sc)->num_rows();
		
		if ($cekpbkmst_inp==0) {
			$info_mst = array (
					'branch' => $branch,
					'nodok' => $nama,
					'nik' => $nik,
					'loccode' => $loccode,
					'status' => 'I',
					'keterangan' => '',
					'tgldok' => date('Y-m-d H:i:s'),
					'inputdate' => date('Y-m-d H:i:s'),
					'inputby' => $nama
			);	
			$this->db->insert('sc_tmp.stpbk_mst',$info_mst);
		}
		
		if ($cekpbkmst_inp_sc==0) {
			redirect("ga/permintaan/form_permintaan/inp_fail");
		}
		
		if($this->uri->segment(5)=="fail_input")
            $data['message']="<div class='alert alert-warning'>Barang Belum ada yang di Sisipkan Atau Belum Terinput</div>";
		else if($this->uri->segment(5)=="st_not_null")
            $data['message']="<div class='alert alert-warning'>Qty Barang Tidak Boleh Kosong/QTY Minus</div>";
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
		
		$data['title']='INPUT PERMINTAAN PBK';
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_pbk_tmp_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param_inp)->result();
		$data['list_pbk_tmp_dtl']=$this->m_permintaan->q_pbk_tmp_dtl_param($param_inp)->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$data['list_kanwil']=$this->m_permintaan->q_mstkantor($param_kanwil)->result();
		$data['dtlmst']=$this->m_permintaan->q_pbk_tmp_mst_param($param_inp)->row_array();
		$this->template->display('ga/permintaan/v_input_personalpbk',$data);
	}
	
	function save_personalpbk(){
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
		$qtypbk=strtoupper($this->input->post('qtypbk'));
		$onhand=strtoupper($this->input->post('onhand'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$nodoktmp=strtoupper($this->input->post('nodoktmp'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_nodok=bin2hex($this->encrypt->encode($nodok));
		// if(empty($nodok)){
			// redirect("ga/permintaan/form_permintaan");
		// }
		if ($type=='INPUT'){
			$param1=" and nodok='$nama' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$cekpbkdtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param1)->num_rows();
			if ($cekpbkdtl>0) {
					redirect("ga/permintaan/input_personalpbk/$enc_nik/inp_kembar");
			} 
			if($qtypbk<=0){
				redirect("ga/permintaan/input_personalpbk/$enc_nik/st_not_null");
			}
			$info_dtl = array (
						'branch' => $branch,
						'nodok' => $nama,
						'nik' => $nik,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtypbk' => $qtypbk,
						'qtyonhand' => $onhand,
						'status' => 'I',
						'keterangan' => $keterangan,
						'inputdate' => $inputdate,
						'inputby' => $inputby		
			);
			
				$this->db->insert('sc_tmp.stpbk_dtl',$info_dtl);
				if($onhand==0){
				redirect("ga/permintaan/input_personalpbk/$enc_nik/warn_onhand");	
				} else {
				redirect("ga/permintaan/input_personalpbk/$enc_nik/inp_succes");
				}
			
		} else if ($type=='INPUTTRX'){
			echo $param3_2=" and nodok='$nodok' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$cekpbktrxdtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->num_rows();
			if ($cekpbktrxdtl>0) {
					redirect("ga/permintaan/edit_pbk/$enc_nodok/inp_kembar");
			} else if($qtypbk<=0){
				redirect("ga/permintaan/edit_pbk/$enc_nodok/st_not_null");
			}
			$info_dtl = array (
						'branch' => $branch,
						'nodok' => $nodok,
						'nik' => $nik,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtypbk' => $qtypbk,
						'qtyonhand' => $onhand,
						'status' => 'A',
						'keterangan' => $keterangan,
						'inputdate' => $inputdate,
						'inputby' => $inputby,		
						'nodoktmp' => $nodoktmp,		
			);
			
				$this->db->insert('sc_tmp.stpbk_dtl',$info_dtl);
				if($onhand==0){
				redirect("ga/permintaan/edit_pbk/$enc_nodok/warn_onhand");	
				} else {
				redirect("ga/permintaan/edit_pbk/$enc_nodok/inp_succes");
				}
				
			
		} else if ($type=='EDIT') {
				$info = array (
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtypbk' => $qtypbk,
						'qtyonhand' => $onhand,
						'status' => 'A',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby	
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_trx.stpbk_dtl',$info);
				redirect("ga/permintaan/form_permintaan/inp_succes");
		} else if ($type=='EDITTRX') {
			/* $param1=" and nodok='$nama' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$cekpbkdtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param1)->num_rows();
			if ($cekpbkdtl>0) {
					redirect("ga/permintaan/edit_pbk/$enc_nik/inp_kembar");
			}  */
			if($qtypbk<=0){
				redirect("ga/permintaan/edit_pbk/$enc_nodok/st_not_null");
			}
				$info = array (
						'desc_barang' => $desc_barang,
						'qtypbk' => $qtypbk,
						'status' => 'A',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby	
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_tmp.stpbk_dtl',$info);
				
				if($onhand==0){
				redirect("ga/permintaan/edit_pbk/$enc_nodok/warn_onhand");	
				} else {
				redirect("ga/permintaan/edit_pbk/$enc_nodok/edit_succes");
				}
				
		}  else if ($type=='EDITTMPDTLINPUT') {
			if($qtypbk<=0){
				redirect("ga/permintaan/input_personalpbk/$enc_nodok/st_not_null");
			}
				$info = array (
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtypbk' => $qtypbk,
						'qtyonhand' => $onhand,
						'status' => 'I',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby	
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nama);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_tmp.stpbk_dtl',$info);
				if($onhand==0){
				redirect("ga/permintaan/input_personalpbk/$enc_nodok/warn_onhand");	
				} else {
				redirect("ga/permintaan/input_personalpbk/$enc_nodok/edit_succes");
				}
		} else if ($type=='EDITTMPDTL') {
			if($qtypbk<=0){
				redirect("ga/permintaan/edit_pbk/$enc_nodok/st_not_null");
			}
				$info = array (
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtypbk' => $qtypbk,
						'qtyonhand' => $onhand,
						'status' => 'I',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby	
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nama);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_tmp.stpbk_dtl',$info);
				if($onhand==0){
				redirect("ga/permintaan/edit_pbk/$enc_nodok/warn_onhand");	
				} else {
				redirect("ga/permintaan/edit_pbk/$enc_nodok/edit_succes");
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
				$this->db->update('sc_tmp.stpbk_mst',$info_mst);
				redirect("ga/permintaan/input_personalpbk/$enc_nik/edit_succes");		
		} else if ($type=='APPROVETMP') {
				$param_apv=" and nodok='$nama' and nik='$nik' and status='A'";
				$cekpbkdtl_approv=$this->m_permintaan->q_pbk_tmp_dtl_param($param_apv)->num_rows();
				if ($cekpbkdtl_approv>0) {
						redirect("ga/permintaan/approval_pbk/$enc_nik/cant_final");
				} else {
					$info = array (
							'status' => 'F',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.stpbk_mst',$info);
					redirect("ga/permintaan/form_permintaan/app_succes");
				}
		} else if ($type=='APPRDTLTRX') {
					$info = array (
							'status' => 'P',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nama);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->update('sc_tmp.stpbk_dtl',$info);
					redirect("ga/permintaan/approval_pbk/$enc_nik/succ_dtlfinal");
				
		}  else if ($type=='REJAPPDTL') { /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
							'status' => 'C',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nama);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->update('sc_tmp.stpbk_dtl',$info);
					redirect("ga/permintaan/approval_pbk/$enc_nik/succ_rejectdtlfinal");
				
		}   else if ($type=='CAPPRDTL') {  /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
							'status' => 'A',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nama);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->update('sc_tmp.stpbk_dtl',$info);
					redirect("ga/permintaan/approval_pbk/$enc_nik/succ_dtlfinal");
				
		}  else if ($type=='DELETE') {
				$info = array (
						'status' => 'F',
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.stpbk_mst',$info);
				redirect("ga/permintaan/form_permintaan/del_succes");
		} else if ($type=='DELETETMPDTL') {
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nama);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->delete('sc_tmp.stpbk_dtl');
				redirect("ga/permintaan/input_personalpbk/$enc_nik/del_succes");
		} else if ($type=='DELETETRX') {
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nodok);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->delete('sc_tmp.stpbk_dtl');
				redirect("ga/permintaan/edit_pbk/$enc_nodok/del_succes");
		}  else if ($type=='HANGUSFINAL') {
					/* FINAL SETELAH PENGHANGUSAN */
					$info = array (
							'status' => 'F',
							'hangusdate' => date('Y-m-d H:i:s'),
							'hangusby' => $nama	
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.stpbk_mst',$info);
					redirect("ga/permintaan/form_permintaan/inp_succes");
		} else {
			redirect("ga/permintaan/form_permintaan");
		}
	}
	
	function final_tmp_pbk(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

		$enc_nik=trim($this->uri->segment(4));

		$nama=trim($this->session->userdata('nik'));
		
		if(empty($nama)){
			redirect("ga/permintaan/form_permintaan");
		}	
		
		$param3_1=" and nodok='$nama'";
		$param_inputby=" and inputby='$nama'";
		$param3_1_2=" and nodok='$nama'";
		$dtledit=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
		$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
	 
		$status=trim($dtledit['status']); //inisial nodok tmp
		
	 	$nodoktmp=trim($dtledit['nodoktmp']); //inisial nodok tmp
	 	$cek_tmp_pbk_dtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_1)->num_rows();

 		if($cek_tmp_pbk_dtl>0 and $status=='I'){	//finish input
 			$info = array (
						'status' => 'A',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stpbk_mst',$info);
				$dtl=$this->m_permintaan->q_pbk_trx_mst_param_inputby($param_inputby)->row_array();
				$nodokfinal=trim($dtl['nodok']);
				redirect("ga/permintaan/form_permintaan/final_succes/$nodokfinal"); 
				//ECHO 'FINAL INPUT';
				
		} else if($cek_tmp_pbk_dtl>0 and $status=='E'){ //finish edit
		 		$info = array (
						'status' => 'A',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stpbk_mst',$info);
				redirect("ga/permintaan/form_permintaan/edit_succes/$nodoktmp"); 
				
				//ECHO 'FINAL EDIT';
		} else if($cek_tmp_pbk_dtl<=0 and $status=='E'){ //finish edit
				//ECHO 'EDIT FAIL';
				redirect("ga/permintaan/edit_pbk/$enc_nodok/edit_fail");
		} else {
				//ECHO 'CONCLUSION';
				redirect("ga/permintaan/input_personalpbk/$enc_nik/fail_input");
		}  
		 
			
	}
	
	function clear_tmp_pbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}		
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  */
			if($status<>'A'){
				$info = array (
						'status' => 'A',
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.stpbk_mst',$info);
			}
	////		$this->db->where('nodok',$nodoktmp);
	////		$this->db->update('sc_trx.stpbk_dtl',$info);
			
			
			/* clearing temporary  */
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stpbk_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stpbk_dtl');
				
			redirect("ga/permintaan/form_permintaan/del_succes");
	}
	
	function clear_tmp_pbk_hangus(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}		
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  */
			$info = array (
					'status' => 'P',
			);
			$this->db->where('nodok',$nodoktmp);
			$this->db->update('sc_trx.stpbk_mst',$info);
	////		$this->db->where('nodok',$nodoktmp);
	////		$this->db->update('sc_trx.stpbk_dtl',$info);
			
			
			/* clearing temporary  */
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stpbk_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stpbk_dtl');
				
			redirect("ga/permintaan/form_permintaan/del_succes");
	}
	

	function cancel_tmp_pbk_dtl(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$enc_nik=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
			$status=trim($dtledit['status']); //inisial nodok tmp

		if(empty($nama)){
			redirect("ga/permintaan/form_permintaan");
		}		
			if ($status=='A') {
				$this->db->where('nodok',$nama);
				$this->db->delete('sc_tmp.stpbk_dtl');
				redirect("ga/permintaan/input_personalpbk/$enc_nik/del_succes");
			} else if ($status=='E') {
				$this->db->where('nodok',$nama);
				$this->db->delete('sc_tmp.stpbk_dtl');
				redirect("ga/permintaan/edit_pbk/$enc_nodok/del_succes");
			}  else if ($status=='I') {
				$this->db->where('nodok',$nama);
				$this->db->delete('sc_tmp.stpbk_dtl');
				redirect("ga/permintaan/input_personalpbk/$enc_nik/del_succes");
			}
	}
		
	function detail_pbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}
		$nama=$this->session->userdata('nik');
				
		$param3_1=" and nodok='$nodok'";
		$param3_2=" and nodok='$nodok'";
		$pbk_mst=$this->m_permintaan->q_pbk_trx_mst_param($param3_1)->row_array();
		$data['list_pbk_trx_mst']=$this->m_permintaan->q_pbk_trx_mst_param($param3_1)->result();
		$pbk_dtl=$this->m_permintaan->q_pbk_trx_dtl_param($param3_2)->row_array();
		$data['list_pbk_trx_dtl']=$this->m_permintaan->q_pbk_trx_dtl_param($param3_2)->result();
		$nik=trim($pbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']='DETAIL INPUT PBK';
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
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();

		
		$this->template->display('ga/permintaan/v_detail_personalpbk',$data);
		
	}
	
	function edit_pbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}
		
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok' and coalesce(nodoktmp,'')!='' ";
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_pbk_trx_mst_param($param_trxapprov)->num_rows();
		$cek_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/permintaan/form_permintaan/edit_fail/$nodokfirst");
		} else if($cek_trxapprov>0){
			redirect("ga/permintaan/form_permintaan/process_fail/$nodok");
		}
		
		
		$info = array (
				'status' => 'E',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stpbk_mst',$info);
		
				
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$pbk_mst=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['pbk_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['list_pbk_trx_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->result();
		$pbk_dtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->row_array();
		$data['list_pbk_trx_dtl']=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->result();
		$nik=trim($pbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" EDIT INPUT PBK";
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
		else if($this->uri->segment(5)=="edit_fail")
            $data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
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
		else if($this->uri->segment(5)=="warn_onhand")
            $data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
        else
            $data['message']='';
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_edit_personalpbk',$data);
		
	}
	
	function approval_pbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}
		$nama=$this->session->userdata('nik');

				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_pbk_trx_mst_param($param_trxapprov)->num_rows();
		$cek_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/permintaan/form_permintaan/approv_fail/$nodokfirst");
		} else if($cek_trxapprov>0){
			redirect("ga/permintaan/form_permintaan/process_fail/$nodok");
		}
	
		$data['nama']=$this->session->userdata('nik');
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$info = array (
				'approvalby' => $nama,
				'approvaldate' => date('Y-m-d H:i:s'),
				'status' => 'A',
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stpbk_mst',$info);
		
				
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$pbk_mst=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['pbk_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['list_pbk_trx_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->result();
		$pbk_dtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->row_array();
		$data['list_pbk_trx_dtl']=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->result();
		$nik=trim($pbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" PERSETUJUAN PERMINTAAN BARANG KELUAR";
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
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_approval_personalpbk',$data);
		
	}
	
	function hapus_pbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}
		$nama=$this->session->userdata('nik');
			
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_pbk_trx_mst_param($param_trxapprov)->num_rows();
		$cek_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/permintaan/form_permintaan/approv_fail/$nodokfirst");
		} else if($cek_trxapprov>0){
			redirect("ga/permintaan/form_permintaan/process_fail/$nodok");
		}
	
		$data['nama']=$this->session->userdata('nik');
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$info = array (
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
				'status' => 'C',
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stpbk_mst',$info);
			
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$pbk_mst=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['pbk_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['list_pbk_trx_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->result();
		$pbk_dtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->row_array();
		$data['list_pbk_trx_dtl']=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->result();
		$nik=trim($pbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
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
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_hapus_personalpbk',$data);
		
	}
	
	/* HANGUS PBK SETELAH FINAL */
	function hangus_pbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_permintaan");
		}
		$nama=$this->session->userdata('nik');
		
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama'";
		$cek_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_pbk_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/permintaan/form_permintaan/approv_fail/$nodokfirst");
		}
		
		
		
		
		$data['nama']=$this->session->userdata('nik');
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$info = array (
				'approvalby' => $nama,
				'approvaldate' => date('Y-m-d H:i:s'),
				'status' => 'H',
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stpbk_mst',$info);
		
				
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama'";
		$pbk_mst=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['pbk_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->row_array();
		$data['list_pbk_trx_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1)->result();
		$pbk_dtl=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->row_array();
		$data['list_pbk_trx_dtl']=$this->m_permintaan->q_pbk_tmp_dtl_param($param3_2)->result();
		$nik=trim($pbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" PENGHANGUSAN SISA PERMINTAAN BARANG KELUAR";
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
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_hangus_personalpbk',$data);
		
	}
	
	
	function form_view_hangus_pbk(){
		$data['title']="LIST HANGUS PERMINTAAN PERSONAL BARANG KELUAR";	
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
		else if($this->uri->segment(5)=="edit_fail")
            $data['message']="<div class='alert alert-danger'>Peringatan Stok Tidak Boleh Kosong </div>";
        else
            $data['message']='';
		$nama=$this->session->userdata('nik');
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.C.3';
						$versirelease='I.G.C.3/ALPHA.001';
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
								

	
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
					
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		

		//$data['list_pbk']=$this->m_permintaan->q_listpbk()->result();
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		//$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$data['list_pbk']=$this->m_permintaan->q_listpbk_hangus_param($param_list_akses)->result();
        $this->template->display('ga/permintaan/v_list_hangus_pbk',$data);
	}
	
	function detail_hanguspbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_view_hangus_pbk");
		}
		$nama=$this->session->userdata('nik');
				
		$param3_1=" and nodok='$nodok'";
		$param3_2=" and nodok='$nodok'";
		$pbk_mst=$this->m_permintaan->q_pbk_his_mst_param($param3_1)->row_array();
		$data['list_pbk_trx_mst']=$this->m_permintaan->q_pbk_his_mst_param($param3_1)->result();
		$pbk_dtl=$this->m_permintaan->q_pbk_his_dtl_param($param3_2)->row_array();
		$data['list_pbk_trx_dtl']=$this->m_permintaan->q_pbk_his_dtl_param($param3_2)->result();
		$nik=trim($pbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']='DETAIL PBK YANG HANGUS';
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
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_detail_hangus_pbk',$data);
		
	}
	
	
	function direct_lost_input(){
		$nama=$this->session->userdata('nik');
		$param3_1_1=" and nodok='$nama' and status='A'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param_list=" and nodok='$nama' ";
			$cekpbkdtl_na=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_1)->num_rows(); //input
			$cekpbkdtl_ne=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->num_rows(); //edit
			$dtledit=$this->m_permintaan->q_pbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$data['dtlnik']=$this->m_permintaan->q_pbk_tmp_mst_param($param_list)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			$enc_nik=bin2hex($this->encrypt->encode($nama));
			if ($cekpbkdtl_na>0) { //cek inputan
					$param_list=" and nodok='$nama' ";
					$data['list_pbk_tmp_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param_list)->result(); //input
				//	redirect("ga/permintaan/input_personalpbk/$enc_nik");
			} else if ($cekpbkdtl_ne>0){	//cek edit
					$param_list=" and nodok='$nama' ";
					$data['list_pbk_tmp_mst']=$this->m_permintaan->q_pbk_tmp_mst_param($param_list)->result(); //input
				//	redirect("ga/permintaan/edit_pbk/$enc_nodok");
			}
		$data['title']='SILAHKAN LANJUTKAN ATAU HAPUS INPUTAN PBK ANDA';
		$this->template->display('ga/permintaan/v_direct_lostinput',$data);
	}

	
	
	
	
	/* BBK BUKTI BARANG KELUAR  __---------------------------------------------------------------------------------------------------------------------------*/
	
	function form_bbk(){
		$data['title']="LIST FORM BUKTI BARANG KELUAR";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.C.2';
						$versirelease='I.G.C.2/ALPHA.001';
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
		else if($this->uri->segment(4)=="input_fail") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>DOKUMEN PBK SEDANG DALAM PROSES PENGINPUTAN OLEH USER $nodokfinal </div>";
        } else if($this->uri->segment(4)=="final_succes") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DOKUMEN $nodokfinal SELESAI DI PROSES</div>";
		} else if($this->uri->segment(4)=="approve_succes") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DOKUMEN $nodokfinal SELESAI DI APPROVE</div>";
		} else if($this->uri->segment(4)=="edit_succes") {
			$nodokfinal=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>DOKUMEN $nodokfinal SELESAI DI UBAH</div>";
		}  else if($this->uri->segment(4)=="edit_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF DOKUMEN INI SEDANG DIPROSES OLEH USER :: $nodokfirst</div>";
		}  else if($this->uri->segment(4)=="batal_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF DOKUMEN INI SEDANG DIPROSES OLEH USER :: $nodokfirst</div>";
		}  else if($this->uri->segment(4)=="approv_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF DOKUMEN INI SEDANG DIPROSES OLEH USER :: $nodokfirst</div>";
		}  else if($this->uri->segment(4)=="process_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>MOHON MAAF TRANSAKSI SUDAH TERKUNCI TELAH TER PROSESS NO DOKUMEN::$nodokfirst</div>";
		} else if($this->uri->segment(4)=="inp_succes") {
            $nodokfirst=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Data Succes Di Input Dengan Dokumen $nodokfirst </div>";		
		}
		else if($this->uri->segment(4)=="inp_fail")
            $data['message']="<div class='alert alert-danger'>Dokumen tida berhasil di input</div>";
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

		
		//echo $tgl;
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and nodok='$nama' and status='I'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param3_1_3=" and nodok='$nama' and status='A'";
		$param3_1_R=" and nodok='$nama'";
			$cekbbkdtl_na=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_1)->num_rows(); //input
			$cekbbkdtl_ne=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_2)->num_rows(); //edit
			$cekbbkdtl_napp=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_3)->num_rows(); //edit
			$dtledit=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));	
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekbbkdtl_na>0) { //cek inputan
					$enc_nodokref=bin2hex($this->encrypt->encode(trim($dtledit['nodokref'])));
					redirect("ga/permintaan/input_bbk/$enc_nodokref");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekbbkdtl_ne>0){	//cek edit
					$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
					redirect("ga/permintaan/edit_bbk/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}  else if ($cekbbkdtl_napp>0){	//cek APPROVAL
					$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
					redirect("ga/permintaan/approval_bbk/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}
			
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
					
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		}
        /* */
        $tgl=explode(' - ',$this->input->post('tgl'));
        if(!empty($this->input->post('tgl')) or ($this->input->post('tgl'))<>'') {
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $paramdate=" and to_char(nodokdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
        } else {
            $paramdate=" and to_char(nodokdate,'yyyymm') = to_char(now(),'yyyymm') ";
        }
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		
        $parameter=$param_list_akses.$paramdate;
		//$data['list_pbk']=$this->m_permintaan->q_listpbk()->result();
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$data['list_bbk']=$this->m_permintaan->q_listbbk_param($parameter)->result();
        $this->template->display('ga/permintaan/v_listbbk',$data);
	}
	
		
	function chose_optionbbk(){
		$inputfill=strtoupper(trim($this->input->post('inputfill')));
		$nama=trim($this->session->userdata('nik'));
		if ($inputfill=='PBK'){
			redirect("ga/permintaan/list_pbk_final");
		} else if ($inputfill=='AJS') {
			$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
			$nodokref=bin2hex($this->encrypt->encode('AJS'.$nama));
			redirect("ga/permintaan/input_bbk/$nodokref");
		}
	}
	
	function list_pbk_final(){  // final ini untuk referensi bbk
		$data['title']='PBK YANG TELAH DISETUJUI UNTUK BUKTI BARANG KELUAR';
		$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
				/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param3_1=" and status in ('P','S')";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param3_1=" and status in ('P','S') and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/){
			$param3_1=" and status in ('P','S') and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param3_1=" and status in ('P','S') and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		
		
		
		$param1=" and loccode='$kdcabang'";
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_pbk_final']=$this->m_permintaan->q_pbk_trx_mst_param($param3_1)->result();
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_listpbk_final',$data);
	}
	
	function input_bbk(){
		$nodokbbk=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$param_cek_1pbk=" and nodokref='$nodokbbk'";
		$cek_tmp=$this->m_permintaan->q_bbk_tmp_mst_param($param_cek_1pbk)->num_rows();
		
		$nama=$this->session->userdata('nik');
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$param3_1=" and nodokref='$nodokbbk' and nodok='$nama'";
		$param3_2=" and nodokref='$nodokbbk' and nodok='$nama'";
		$inputdate=date('Y-m-d H:i:s');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";

		if (substr($nodokbbk, 0,3)=='PBK') { 
				/* bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
				if ($cek_tmp==0 and !empty($nodokbbk)) {
					if($cek_tmp>0) {
						redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
					} else {
						$this->m_permintaan->insert_trx_pbk_to_bbk($nodokbbk,$nama,$inputdate);
										
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBK');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 0,
							'nomorakhir1' => $nodokbbk,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBK',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
					}
				} else if ($cek_tmp>0 and !empty($nodokbbk)) {
					$dtl_tmp1pbk=$this->m_permintaan->q_bbk_tmp_mst_param($param_cek_1pbk)->row_array();
					if (isset($dtl_tmp1pbk['nodok'])){ $nodok_isset=trim($dtl_tmp1pbk['nodok']); } else { $nodok_isset='';	} 
					
					if ($nodok_isset<>trim($nama)) {
						redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
					}
				}
				/* end bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
		} else if (substr($nodokbbk, 0,3)=='AJS') {
				
				if ($cek_tmp==0 and !empty($nodokbbk)) {
					if($cek_tmp>0) {
						redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
					} else {
						$this->m_permintaan->insert_ajs_to_bbk($branch,$nodokbbk,$nama,$inputdate,$kdcabang);
										
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBK');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 0,
							'nomorakhir1' => $nodokbbk,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBK',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
					}
				} else if ($cek_tmp>0 and !empty($nodokbbk)) {
					$dtl_tmp1pbk=$this->m_permintaan->q_bbk_tmp_mst_param($param_cek_1pbk)->row_array();
					if (isset($dtl_tmp1pbk['nodok'])){ $nodok_isset=trim($dtl_tmp1pbk['nodok']); } else { $nodok_isset='';	} 
					
					if ($nodok_isset<>trim($nama)) {
						redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
					}
				}
		}
		
		$data['bbk_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
		$bbk_mst=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
		$nik=trim($bbk_mst['nik']);
		$data['list_bbk_tmp_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->result();
		$bbk_dtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->row_array();
		$data['list_bbk_tmp_dtl']=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->result();
		
		$data['title']='INPUT PERMINTAAN BARANG KELUAR';
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
	
		$param_inp=" and nodok='$nama'";
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		/* user hr akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/*user hr end */

		
		if($this->uri->segment(5)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
		else if($this->uri->segment(5)=="fail_value")
            $data['message']="<div class='alert alert-danger'>Keluar barang tidak boleh lebih besar dari permintaan barang atau Qty BBK Tidak Boleh Di Input Kosong </div>";
		else if($this->uri->segment(5)=="fail_value2")
            $data['message']="<div class='alert alert-danger'>Stok tidak tersedia / stok sedang digunakan user lain</div>";
		else if($this->uri->segment(5)=="save_fail")
            $data['message']="<div class='alert alert-danger'>QTY BBK Detail Masih Kosong Belum Ada Input Barang Keluar</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(5)=="clear_succes")
            $data['message']="<div class='alert alert-success'>Reset Qty Succes</div>";
		else if($this->uri->segment(5)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(5)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		
		$this->template->display('ga/permintaan/v_input_bbk',$data);
	}
	
	function save_bbk(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nik=strtoupper($this->input->post('nik'));
		$nodok=strtoupper($this->input->post('nodok'));
		$nodokref=strtoupper($this->input->post('nodokref'));
		$nodoktmp=strtoupper($this->input->post('nodoktmp'));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		$loccode=strtoupper($this->input->post('loccode'));
		$desc_barang=strtoupper($this->input->post('desc_barang'));
		$qtypbk=strtoupper($this->input->post('qtypbk'));
		$qtybbk=strtoupper($this->input->post('qtybbk'));
		$qtyonhand=strtoupper($this->input->post('onhand'));
		$onhand=strtoupper($this->input->post('onhand'));
		$status=strtoupper($this->input->post('status'));
		$nodokdate=strtoupper($this->input->post('nodokdate'));
		$nodoktype=strtoupper($this->input->post('nodoktype'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_nodok=bin2hex($this->encrypt->encode($nodok));
		$enc_nodokref=bin2hex($this->encrypt->encode($nodokref));
		$enc_nodoktmp=bin2hex($this->encrypt->encode($nodoktmp));
		// if(empty($nodok)){
			// redirect("ga/permintaan/form_permintaan");
		// }
		if ($type=='INPUT'){
			$param1=" and nodok='$nama' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$cekbbkdtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param1)->num_rows();
			if ($cekbbkdtl>0) {
					redirect("ga/permintaan/input_personalbbk/$enc_nik/inp_kembar");
			} 
			$info_dtl = array (
						'branch' => $branch,
						'nodok' => $nama,
						'nik' => $nik,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'stockcode' => $stockcode,
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtybbk' => $qtybbk,
						'qtyonhand' => $onhand,
						'status' => 'I',
						'keterangan' => $keterangan,
						'nodokdate' => $nodokdate,
						'inputdate' => $inputdate,
						'inputby' => $inputby		
			);
			
				$this->db->insert('sc_tmp.stbbk_dtl',$info_dtl);	
				redirect("ga/permintaan/input_personalbbk/$enc_nik/inp_succes");
			
		} else if ($type=='MOVETRX'){
			$param3_2=" and nodok='$nama'";
			$param=" and inputby='$nama'";
			$ceksumbbkdtl=$this->m_permintaan->q_bbk_tmp_dtl_normal($param3_2)->row_array();
			$dtlopen=$this->m_permintaan->q_bbk_trx_mst_normal($param)->row_array();
			
			 if ($ceksumbbkdtl['ttlqtybbk']<=0) {
					redirect("ga/permintaan/input_bbk/$enc_nodokref/save_fail");
			} else {
					$info_dtl = array (
						'status' => 'A',
						'keterangan' => $keterangan,
						'inputdate' => $inputdate,
						'inputby' => $inputby		
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nodok);
					$this->db->where('nodokref',$nodokref);
					$this->db->update('sc_tmp.stbbk_mst',$info_dtl);
					
					$paramerror=" and userid='$nama' and modul='TMPSTBBK'";
					$dtltrxerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
					redirect("ga/permintaan/form_bbk/inp_succes/".trim($dtltrxerror['nomorakhir1']));	

			}			
		} else if ($type=='INPUTTMPDTLBBK_NO_REFERENSI') {
			$param1=" and nodok='$nama' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$dtlbbk=$this->m_permintaan->q_bbk_tmp_dtl_param($param1)->row_array();
			$rowdtlbbk=$this->m_permintaan->q_bbk_tmp_dtl_param($param1)->num_rows();
			if ($qtybbk<0 or $rowdtlbbk>0){
					redirect("ga/permintaan/input_bbk/$enc_nodokref/fail_value");
			}	else {
					$info = array (
								'branch' => $branch,
								'nik' => $nik,
								'nodok' => $nodok,
								'nodokref' => $nodokref,
								'nodoktype' => $nodoktype,
								'kdgroup' => $kdgroup,
								'kdsubgroup' => $kdsubgroup,
								'stockcode' => $stockcode,
								'loccode' => $loccode,
								'desc_barang' => $desc_barang,
								'qtypbk' => $qtybbk,
								'qtybbk' => $qtybbk,
								'qtyonhand' => $qtyonhand,
								'status' => 'I',
								'keterangan' => $keterangan,
								'inputdate' => $inputdate,
								'inputby' => $inputby	
						);

						$this->db->insert('sc_tmp.stbbk_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBK'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/input_bbk/$enc_nodokref/fail_value2");
					} else {
						redirect("ga/permintaan/input_bbk/$enc_nodokref/inp_succes");
					}
			}

		} else if ($type=='EDITTMP') {
			$param1=" and nodok='$nama' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$dtlbbk=$this->m_permintaan->q_bbk_tmp_dtl_param($param1)->row_array();
			if ($qtybbk>$qtypbk or $qtybbk<0){
					redirect("ga/permintaan/input_bbk/$enc_nodokref/fail_value");
			}	else {
					if($nodoktype=='AJS') {
						$info = array (
								'qtypbk' => $qtybbk,
								'qtybbk' => $qtybbk,
								'status' => '',
								'keterangan' => $keterangan,
								'updatedate' => $inputdate,
								'updateby' => $inputby	
						);
					} else {
						$info = array (
								'qtybbk' => $qtybbk,
								'status' => '',
								'keterangan' => $keterangan,
								'updatedate' => $inputdate,
								'updateby' => $inputby	
						);
					}

						$this->db->where('nik',$nik);
						$this->db->where('nodok',$nodok);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->update('sc_tmp.stbbk_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBK'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/input_bbk/$enc_nodokref/fail_value2");
					} else {
						redirect("ga/permintaan/input_bbk/$enc_nodokref/inp_succes");
					}
			}

		} else if ($type=='EDITTRXDTL') {
			$param1=" and nodok='$nama' and nik='$nik' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
			$dtlbbk=$this->m_permintaan->q_bbk_tmp_dtl_param($param1)->row_array();
		
					if($nodoktype=='AJS') {
						if ($qtybbk>$qtyonhand or $qtybbk<0){
								redirect("ga/permintaan/edit_bbk/$enc_nodoktmp/fail_value");
						} else {
							$info = array (
									'qtypbk' => $qtybbk,
									'qtybbk' => $qtybbk,
									'status' => '',
									'keterangan' => $keterangan,
									'updatedate' => $inputdate,
									'updateby' => $inputby	
							);
									
								$this->db->where('nik',$nik);
								$this->db->where('nodok',$nodok);
								$this->db->where('kdgroup',$kdgroup);
								$this->db->where('kdsubgroup',$kdsubgroup);
								$this->db->where('stockcode',$stockcode);
								$this->db->update('sc_tmp.stbbk_dtl',$info); 
							
							$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBK'";
							$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
							if ($trxerror>0){
								redirect("ga/permintaan/edit_bbk/$enc_nodoktmp/fail_value");
							} else {
								redirect("ga/permintaan/edit_bbk/$enc_nodoktmp/edit_succes");
							}
						}
					} else {
						if ($qtybbk>$qtypbk or $qtybbk<0){
							redirect("ga/permintaan/edit_bbk/$enc_nodoktmp/fail_value");
							} else {
								$info = array (
										'qtybbk' => $qtybbk,
										'status' => '',
										'keterangan' => $keterangan,
										'updatedate' => $inputdate,
										'updateby' => $inputby	
								);
							}
						
							$this->db->where('nik',$nik);
							$this->db->where('nodok',$nodok);
							$this->db->where('kdgroup',$kdgroup);
							$this->db->where('kdsubgroup',$kdsubgroup);
							$this->db->where('stockcode',$stockcode);
							$this->db->update('sc_tmp.stbbk_dtl',$info); 
						
						$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBK'";
						$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
						if ($trxerror>0){
							redirect("ga/permintaan/edit_bbk/$enc_nodoktmp/fail_value");
						} else {
							redirect("ga/permintaan/edit_bbk/$enc_nodoktmp/edit_succes");
						}
					}
			}  else if ($type=='EDITTMPDTL') {
				$info = array (
						'loccode' => $loccode,
						'desc_barang' => $desc_barang,
						'qtybbk' => $qtybbk,
						'qtyonhand' => $onhand,
						'status' => 'A',
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby	
				);
				$this->db->where('nik',$nik);
				$this->db->where('nodok',$nama);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->update('sc_tmp.stbbk_dtl',$info);
				redirect("ga/permintaan/input_personalbbk/$enc_nik/del_succes");
		}  else if ($type=='APPROVETMPMST') {
			$param3_2=" and nodok='$nama'"; // PARAM APROV NAMA
			$param3_3=" and nodok='$nama' and status='A'"; // PARAM KUNCI DETAIL
			$ceksumbbkdtl=$this->m_permintaan->q_bbk_tmp_dtl_normal($param3_2)->row_array();
			$cekdtlbbk=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_3)->num_rows();
			
				if ($ceksumbbkdtl['ttlqtybbk']<=0 or $cekdtlbbk>0) {
						redirect("ga/permintaan/approval_bbk/$enc_nik/approv_fail");
				} else {
						$info = array (
								'status' => 'F',
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbk_mst',$info);
						redirect("ga/permintaan/form_bbk/final_succes/$nodoktmp"); 
				}
				
		} else if ($type=='APPRDTLTRX') {
					$info = array (
							'status' => 'P',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nama);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->update('sc_tmp.stbbk_dtl',$info);
					redirect("ga/permintaan/approval_bbk/$enc_nik/succ_dtlfinal");
				
		}  else if ($type=='REJAPPDTL') { /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
							'status' => 'C',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nama);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->update('sc_tmp.stbbk_dtl',$info);
					redirect("ga/permintaan/approval_bbk/$enc_nik/succ_rejectdtlfinal");
				
		}   else if ($type=='CAPPRDTL') {  /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
							'status' => 'A',
					);
					$this->db->where('nik',$nik);
					$this->db->where('nodok',$nama);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->update('sc_tmp.stbbk_dtl',$info);
					redirect("ga/permintaan/approval_bbk/$enc_nik/succ_dtlfinal");
				
		}  else if ($type=='CANCELTRXMST') {
					/* FINAL SETELAH BATAL */
					$info = array (
							'status' => 'F',
							'updatedate' => date('Y-m-d H:i:s'),
							'updateby' => $nama	
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.stbbk_mst',$info);
					redirect("ga/permintaan/form_bbk/cancel_succes");
		} else if ($type=='HANGUSFINAL') {
					/* FINAL SETELAH PENGHANGUSAN */
					$info = array (
							'status' => 'F',
							'updatedate' => date('Y-m-d H:i:s'),
							'updateby' => $nama	
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.stbbk_mst',$info);
					redirect("ga/permintaan/form_bbk/inp_succes");
		} else if ($type=='DELETETRXMST') {
			$info = array (
						'status' => 'C',
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.stbbk_mst',$info);
				redirect("ga/permintaan/form_bbk/cancel_succes");
		}  else {
			redirect("ga/permintaan/form_bbk");
		}
	}
	/* clear bbk temporary */
	function clear_tmp_bbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbk");
		}		
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktype=trim($dtledit['nodoktype']); 
			
			if ($nodoktype=='PBK') {
				if ($status<>'I' and $status<>'E'){
						$nodoktmp=trim($dtledit['nodoktmp']); 
						/* restoring status  */
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nodoktmp);
						$this->db->update('sc_trx.stbbk_mst',$info);
						
						$info2 = array (
								'status' => 'A'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbk_dtl',$info2); 
				} else if ($status=='E'){
						$nodoktmp=trim($dtledit['nodoktmp']); 
						/* restoring status  */
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nodoktmp);
						$this->db->update('sc_trx.stbbk_mst',$info);
						
						$info2 = array (
								'status' => 'AE'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbk_dtl',$info2); 
				} else if ($status=='I') {
						$info2 = array (
								'status' => 'C'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbk_dtl',$info2); 
				}
			} else if ($nodoktype=='AJS') {
				
				if ($status<>'I' and $status<>'E'){
						$nodoktmp=trim($dtledit['nodoktmp']); 
						/* restoring status  */
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nodoktmp);
						$this->db->update('sc_trx.stbbk_mst',$info);
						
						$info2 = array (
								'status' => 'A'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbk_dtl',$info2); 
				} else if ($status=='E'){
						$nodoktmp=trim($dtledit['nodoktmp']); 
						/* restoring status  */
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nodoktmp);
						$this->db->update('sc_trx.stbbk_mst',$info);
				} 
				
			}
			/* clearing temporary  */
					
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbk_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbk_dtl');
				
			redirect("ga/permintaan/form_bbk/del_succes");
	}
	
	function cancel_tmp_bbk_dtl(){
		$enc_nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
 		$nama=$this->session->userdata('nik');
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
			$enc_nodok_inp=bin2hex($this->encrypt->encode(trim($dtledit['nodokref']))); //inisial nodok tmp
			$status=trim($dtledit['status']); //inisial nodok tmp
			echo $nodoktype=trim($dtledit['nodoktype']); //inisial nodok tmp
		if(empty($nama)){
			redirect("ga/permintaan/form_bbk");
		}		
		
		if($nodoktype=='PBK') {
			if ($status=='I') {
				$info = array (
					'qtybbk' => 0,
					'status' => '',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stbbk_dtl',$info);

				redirect("ga/permintaan/input_bbk/$enc_nodok_inp/clear_succes");
			} else if ($status=='E') {
				$info = array (
					'qtybbk' => 0,
					'status' => ''
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stbbk_dtl',$info);
				redirect("ga/permintaan/edit_bbk/$enc_nodok/clear_succes");
			} 
		} else if($nodoktype=='AJS') {
			if ($status=='I') {

				$this->db->where('nodok',$nama);
				$this->db->delete('sc_tmp.stbbk_dtl');

				
			}  else if ($status=='E') {
				$info = array (
					'qtybbk' => 0,
					'status' => ''
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stbbk_dtl',$info);
			}
			redirect("ga/permintaan/form_bbk");
		}
	}
	
	function final_tmp_bbk(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$enc_nik=trim($this->uri->segment(4));
		$nama=trim($this->session->userdata('nik'));
		
		if(empty($nama)){
			redirect("ga/permintaan/form_bbk");
		}	
		
		$param3_1=" and nodok='$nama'";
		$param_inputby=" and inputby='$nama'";
		$param3_1_2=" and nodok='$nama'";
		$dtledit=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
		$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
	 
		$status=trim($dtledit['status']); //inisial nodok tmp
		
	 	$nodoktmp=trim($dtledit['nodoktmp']); //inisial nodok tmp
	 	$cek_tmp_bbk_dtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_1)->num_rows();

 		if($cek_tmp_bbk_dtl>0 and $status=='I'){	//finish input
 			$info = array (
						'status' => 'A',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stbbk_mst',$info);
				$dtl=$this->m_permintaan->q_bbk_trx_mst_param_inputby($param_inputby)->row_array();
				$nodokfinal=trim($dtl['nodok']);
				redirect("ga/permintaan/form_bbk/final_succes/$nodokfinal"); 
				//ECHO 'FINAL INPUT';
				
		} else if($cek_tmp_bbk_dtl>0 and $status=='E'){ //finish edit
				/* KETIKA BARANG BBK KOSONG */
				$param3_2=" and nodok='$nama'";
				$ceksumbbkdtl=$this->m_permintaan->q_bbk_tmp_dtl_normal($param3_2)->row_array();
				 if ($ceksumbbkdtl['ttlqtybbk']<=0) {
						redirect("ga/permintaan/edit_bbk/$enc_nodok/edit_fail");
				} else {
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbk_mst',$info);
						redirect("ga/permintaan/form_bbk/edit_succes/$nodoktmp"); 
				}
				
				//ECHO 'FINAL EDIT';
		} else if($cek_tmp_bbk_dtl<=0 and $status=='E'){ //finish edit
				//ECHO 'EDIT FAIL';
				redirect("ga/permintaan/edit_bbk/$enc_nodok/edit_fail");
		} else {
				//ECHO 'CONCLUSION';
				redirect("ga/permintaan/input_bbk/$enc_nik/fail_input");
		}  
		 
			
	}
	
	function edit_bbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	 	$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			//redirect("ga/permintaan/form_bbk");
		}
		
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_bbk_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
		//	redirect("ga/permintaan/form_bbk/process_fail/$nodok");
		}
		//// REDIRECT JIKA USER LAIN KALAH CEPAT 
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->row_array();
		$param3_1=" and nodoktmp='$nodok'";
		$param3_2=" and nodoktmp='$nodok'";
		$param3_3=" and nodok='$nodok'";
		$dtldokref=$this->m_permintaan->q_bbk_trx_mst_param($param3_3)->row_array();
		
		$info = array (
				'status' => 'E',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stbbk_mst',$info);

		
		
		if (isset($dtldokref['nodokref'])) {
			$nodokref=trim($dtldokref['nodokref']);
		} else {
			$nodokref=""; 
		}
		
		$paramceknodokref_one=" and nodokref='$nodokref' ";
		$paramceknodokref_two=" and nodokref='$nodokref' and nodok='$nama'";
		$paramceknodokref_three=" and nodok='$nama'";
		$cek_first_nodokref_one=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_one)->num_rows();
		$cek_first_nodokref_two=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_two)->num_rows();
		$cek_first_nodokref_three=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_three)->num_rows();
		$dtl_first_nodokref=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_one)->row_array();
		
		if($cek_first_nodokref_one>0 and $cek_first_nodokref_two==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			//redirect("ga/permintaan/form_bbk/edit_fail/$nodokfirst");
		}  else {
			$bbk_mst=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
			$data['bbk_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
			$data['list_bbk_tmp_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->result();
			$bbk_dtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->row_array();
			$data['list_bbk_tmp_dtl']=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->result();
			$nik=trim($bbk_mst['nik']);
			
			$data['nik']=$nik;
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
			$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
			
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" EDIT INPUT BBK";
			if($this->uri->segment(5)=="bc_failed")
				$data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
			else if($this->uri->segment(5)=="edit_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
			else if($this->uri->segment(5)=="rep_succes")
				$data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
			else if($this->uri->segment(5)=="inp_succes")
				$data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
			else if($this->uri->segment(5)=="edit_succes")
				$data['message']="<div class='alert alert-success'>Ubah data Qty BBK berhasil</div>";
			else if($this->uri->segment(5)=="del_succes")
				$data['message']="<div class='alert alert-success'>Delete Succes</div>";
			else if($this->uri->segment(5)=="del_failed")
				$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
			else if($this->uri->segment(5)=="fail_value")
				$data['message']="<div class='alert alert-danger'>Stok harus tidak lebih besar dari referensi PBK</div>";
			else if($this->uri->segment(5)=="inp_kembar")
				$data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
			else if($this->uri->segment(5)=="wrong_format")
				$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
			else if($this->uri->segment(5)=="warn_onhand")
				$data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
			else
				$data['message']='';
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_edit_bbk',$data);					  
		}
	}
	
	function batal_bbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbk");
		}
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_bbk_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/permintaan/form_bbk/process_fail/$nodok");
		}
		//// REDIRECT JIKA USER LAIN KALAH CEPAT 
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->row_array();
		$param3_3=" and nodok='$nodok'";
		$dtldokref=$this->m_permintaan->q_bbk_trx_mst_param($param3_3)->row_array();
		
				
			$info = array (
					'status' => 'C',
					'updateby' => $nama,
					'updatedate' => date('Y-m-d H:i:s'),
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.stbbk_mst',$info);

		
		
		if (isset($dtldokref['nodokref'])) {
			$nodokref=trim($dtldokref['nodokref']);
		} else {
			$nodokref=""; 
		}
		
		$paramceknodokref_one=" and nodokref='$nodokref' ";
		$paramceknodokref_two=" and nodokref='$nodokref' and nodok='$nama'";
		$paramceknodokref_three=" and nodok='$nama'";

		
		$cek_first_nodokref_one=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_one)->num_rows();
		$cek_first_nodokref_two=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_two)->num_rows();
		$cek_first_nodokref_three=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_three)->num_rows();
		$dtl_first_nodokref=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_one)->row_array();
		
		if($cek_first_nodokref_one>0 and $cek_first_nodokref_two==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbk/batal_fail/$nodokfirst");
/*		} else if($cek_first_nodokref_three==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbk/batal_fail/$nodokfirst"); */
		} else {				
			$param3_1=" and nodok='$nama'";
			$param3_2=" and nodok='$nama'";
			$bbk_mst=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
			$data['bbk_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
			$data['list_bbk_tmp_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->result();
			$bbk_dtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->row_array();
			$data['list_bbk_tmp_dtl']=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->result();
			$nik=trim($bbk_mst['nik']);
			
			$data['nik']=$nik;
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
			$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" BATAL BBK";
			if($this->uri->segment(5)=="bc_failed")
				$data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
			else if($this->uri->segment(5)=="edit_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
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
			else if($this->uri->segment(5)=="warn_onhand")
				$data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
			else
				$data['message']='';
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_batal_bbk',$data); 
		}
	}
	
	function detail_bbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbk");
		}
		$nama=$this->session->userdata('nik');
				
		$param3_1=" and nodok='$nodok'";
		$param3_2=" and nodok='$nodok'";
		$bbk_mst=$this->m_permintaan->q_bbk_trx_mst_param($param3_1)->row_array();
		$data['bbk_mst']=$this->m_permintaan->q_bbk_trx_mst_param($param3_1)->row_array();
		$data['list_bbk_trx_mst']=$this->m_permintaan->q_bbk_trx_mst_param($param3_1)->result();
		$bbk_dtl=$this->m_permintaan->q_bbk_trx_dtl_param($param3_2)->row_array();
		$data['list_bbk_trx_dtl']=$this->m_permintaan->q_bbk_trx_dtl_param($param3_2)->result();
		$nik=trim($bbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" DETAIL BBK REFRENSI PBK";
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
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_detail_bbk',$data);
		
	}
	
	function approval_bbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbk");
		}
		$nama=$this->session->userdata('nik');
		
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_bbk_trx_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/permintaan/form_bbk/process_fail/$nodok");
		}
		
		
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->row_array();
		$param3_3=" and nodok='$nodok'";
		$dtldokref=$this->m_permintaan->q_bbk_trx_mst_param($param3_3)->row_array();
		$info = array (
				'approvalby' => $nama,
				'approvaldate' => date('Y-m-d H:i:s'),
				'status' => 'AP',
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stbbk_mst',$info);
		
		if (isset($dtldokref['nodokref'])) {
			$nodokref=trim($dtldokref['nodokref']);
		} else {
			$nodokref=""; 
		}
		

		
		
		$paramceknodokref_one=" and nodokref='$nodokref' ";
		$paramceknodokref_two=" and nodokref='$nodokref' and nodok='$nama'";
		$paramceknodokref_three=" and nodok='$nama'";


		$cek_first_nodokref_one=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_one)->num_rows();
		$cek_first_nodokref_two=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_two)->num_rows();
		$cek_first_nodokref_three=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_three)->num_rows();
		$dtl_first_nodokref=$this->m_permintaan->q_bbk_tmp_mst_param($paramceknodokref_one)->row_array();
		
		if($cek_first_nodokref_one>0 and $cek_first_nodokref_two==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbk/approv_fail/$nodokfirst");
/*		} else if($cek_first_nodokref_three==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbk/approv_fail/$nodokfirst"); */
		} else {		
			$data['nama']=$this->session->userdata('nik');
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));		
			$param3_1=" and nodok='$nama'";
			$param3_2=" and nodok='$nama'";
			$bbk_mst=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
			$data['bbk_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
			$data['list_bbk_tmp_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->result();
			$bbk_dtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->row_array();
			$data['list_bbk_tmp_dtl']=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->result();
			$nik=trim($bbk_mst['nik']);
			
			$data['nik']=$nik;
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			//$data['list_nikbbk']=$this->m_akses->list_karyawan()->result();
			$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
			$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
			
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" PERSETUJUAN PERMINTAAN BARANG KELUAR";
			if($this->uri->segment(5)=="bc_failed")
				$data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
			else if($this->uri->segment(5)=="edit_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan Stok Tidak Boleh Kosong </div>";
			else if($this->uri->segment(5)=="cant_final")
				$data['message']="<div class='alert alert-danger'>Peringatan Seluruh Permintaan Detail Harus Teraprove/Ter Reject Terlebih Dahulu </div>";
			else if($this->uri->segment(5)=="approv_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan seluruh detail harus dikondisikan teraprove atau ter reject </div>";
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
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_approval_bbk',$data);
		}
	}
	
		/* HANGUS BBK SETELAH FINAL */
	function hangus_bbk(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbk");
		}
		$nama=$this->session->userdata('nik');
		
				/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodok<>'$nama'";
		$cek_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_bbk_tmp_mst_param($param3_first)->row_array();
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/permintaan/form_bbk/approv_fail/$nodokfirst");
		}
		
		
		
		
		$data['nama']=$this->session->userdata('nik');
		$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
		$info = array (
				'approvalby' => $nama,
				'approvaldate' => date('Y-m-d H:i:s'),
				'status' => 'H',
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stbbk_mst',$info);
		
				
		$param3_1=" and nodok='$nama'";
		$param3_2=" and nodok='$nama' and (status='P' or status='S')";
		$bbk_mst=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
		$data['bbk_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->row_array();
		$data['list_bbk_trx_mst']=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1)->result();
		$bbk_dtl=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->row_array();
		$data['list_bbk_trx_dtl']=$this->m_permintaan->q_bbk_tmp_dtl_param($param3_2)->result();
		$nik=trim($bbk_mst['nik']);
		
		$data['nik']=$nik;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		//$data['list_nikbbk']=$this->m_akses->list_karyawan()->result();
		$data['list_lk']=$this->m_akses->list_karyawan_index($nik)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nik)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		$param1=" and loccode='$kdcabang'";
		
		$data['title']=" PENGHANGUSAN SISA PERMINTAAN BARANG KELUAR";
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
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_hangus_bbk',$data);
		
	}
	
	function clear_tmp_bbk_hangus(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbk");
		}		
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_bbk_tmp_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
			$nodoktmp=trim($dtledit['nodoktmp']); 
			/* restoring status  */
			$info = array (
					'status' => 'P',
			);
			$this->db->where('nodok',$nodoktmp);
			$this->db->update('sc_trx.stbbk_mst',$info);
	////		$this->db->where('nodok',$nodoktmp);
	////		$this->db->update('sc_trx.stpbk_dtl',$info);
			
			
			/* clearing temporary  */
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbk_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbk_dtl');
				
			redirect("ga/permintaan/form_bbk/del_succes");
	}
	
	function form_bbm(){
	
		$data['title']="LIST BUKTI BARANG MASUK BARANG";
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$nama=$this->session->userdata('nik');
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.H.3';
						$versirelease='I.G.H.3/ALPHA.001';
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
								
		$paramerror=" and userid='$nama' and modul='TMPSTBBM'";
		$dtlerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
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
		else if($this->uri->segment(4)=="edit_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen sedang diakses user $nodokfirst</div>";
		} else if($this->uri->segment(4)=="input_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen sedang diakses user $nodokfirst</div>";
		} else if($this->uri->segment(4)=="process_fail") {
			$nodokfirst=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Dokumen Sudah Terproses No Rev:: $nodokfirst</div>";
		} else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else {
			if(empty($errordesc)){
				$data['message']="";
			} else {
				$data['message']="<div class='alert alert-success'>$errordesc</div>";
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
		$param3_1_3=" and nodok='$nama' and status in ('A','AP')";
		$param3_1_4=" and nodok='$nama' and status='C'";
		$param3_1_5=" and nodok='$nama' and status='H'";
		$param3_1_R=" and nodok='$nama'";
			$cekmstbbm_na=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_1)->num_rows(); //input
			$cekmstbbm_ne=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_2)->num_rows(); //edit
			$cekmstbbm_napp=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_3)->num_rows(); //approv
			$cekmstbbm_cancel=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_4)->num_rows(); //cancel
			$cekmstbbm_hangus=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_5)->num_rows(); //hangus
			$dtledit=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			
			
			$enc_nik=bin2hex($this->encrypt->encode($nama));
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekmstbbm_na>0) { //cek inputan
					$enc_nodokref=bin2hex($this->encrypt->encode(trim($dtledit['nodokref'])));
					redirect("ga/permintaan/input_bbm/$enc_nodokref");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekmstbbm_ne>0){	//cek edit
					$enc_nodoktmp=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
					redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekmstbbm_napp>0){	//cek approv
					$enc_nodoktmp=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
					redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekmstbbm_cancel>0){	//cek cancel
					$enc_nodok=bin2hex($this->encrypt->encode(trim($nama)));
					redirect("ga/permintaan/batal_bbm/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekmstbbm_hangus>0){	//cek cancel
					$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
					redirect("ga/permintaan/hangus_bbm/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['trxqtyunit']=$this->m_permintaan->q_trxqtyunit()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$data['list_msupplier']=$this->m_permintaan->q_msupplier()->result();
		$data['list_msubsupplier']=$this->m_permintaan->q_msubsupplier()->result();
		$data['trxsupplier']=$this->m_permintaan->q_trxsupplier()->result();
        $this->template->display('ga/permintaan/v_list_bbm',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_permintaan->q_deltrxerror($paramerror);
	}
	
	function bbmpagin(){
		$nama=$this->session->userdata('nik');
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if (($ceknikatasan1)>0 or $userhr>0 ){
			//$param_list_akses=" and nodokopr in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nodokopr='$nama'";	
			$param_list_akses=" ";	
			$param_list2=1;
		}
		else if (($ceknikatasan2)>0 or $userhr>0 ){
			//$param_list_akses=" and nodokopr in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nodokopr='$nama'";
			$param_list_akses=" ";
			$param_list2=1;		
		}
		else {
			//$param_list_akses=" and nodokopr='$nama' ";
			$param_list_akses="";
			$param_list2=0;
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		
		$list = $this->m_permintaan->get_list_bbm($param_list_akses);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lpo) {
			$enc_nodok=bin2hex($this->encrypt->encode(trim($lpo->nodok)));
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $lpo->nodok;
			$row[] = $lpo->nmstatus;	
			$row[] = $lpo->nodoktype;	
			$row[] = $lpo->inputby;
			if (isset($lpo->inputdate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->inputdate))); } else { $row[] = ''; } 
			$row[] = $lpo->approvalby;
			if(isset($lpo->approvaldate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->approvaldate))); } else { $row[] ='';} 
			$row[] = $lpo->keterangan;			
			if ((trim($lpo->status)!='A') AND (trim($lpo->status)!='P')) {
			$row[] = 
			'<a class="btn btn-sm btn-default" href="'.site_url('ga/permintaan/detail_bbm').'/'.$enc_nodok.'" title="Detail BBM"><i class="fa fa-bars"></i> </a>';
			} else if (trim($lpo->status)=='P') {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/permintaan/detail_bbm').'/'.$enc_nodok.'" title="Detail BBM"><i class="fa fa-bars"></i> </a>
			<!--a class="btn btn-sm btn-danger" href="'.site_url('ga/permintaan/hangus_po_atk').'/'.$enc_nodok.'" title="Hangus BBM"><i class="glyphicon glyphicon-search"></i> Hangus </a--->';
		/// ini	} else if ((trim($lpo->status)=='A' and $param_list2==1) or $userhr>0 ) {
			//} else if (trim($lpo->status)=='A' and $param_list2==1) {
			} else if (trim($lpo->status)=='A') {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/permintaan/detail_bbm').'/'.$enc_nodok.'" title="Detail BBM"><i class="fa fa-bars"></i> </a>
			<a class="btn btn-sm btn-primary" href="'.site_url('ga/permintaan/edit_bbm').'/'.$enc_nodok.'" title="Edit BBM"><i class="fa fa-edit"></i> </a>
			<a class="btn btn-sm btn-danger" href="'.site_url('ga/permintaan/batal_bbm').'/'.$enc_nodok.'" title="Hapus BBM"><i class="fa fa-trash-o"></i> </a>'.
			'<a class="btn btn-sm btn-success" href="'.site_url('ga/permintaan/approval_bbm').'/'.$enc_nodok.'" title="Approval BBM"><i class="fa fa-check"></i> </a>';
			
			} /*else if (trim($lpo->status)=='A' and $param_list2==0) {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/permintaan/detail_bbm').'/'.$enc_nodok.'" title="Detail BBM"><i class="glyphicon glyphicon-search"></i> Detail </a>
			<a class="btn btn-sm btn-primary" href="'.site_url('ga/permintaan/edit_bbm').'/'.$enc_nodok.'" title="Edit BBM"><i class="glyphicon glyphicon-pencil"></i> Edit </a>
			<a class="btn btn-sm btn-danger" href="'.site_url('ga/permintaan/batal_bbm').'/'.$enc_nodok.'" title="Hapus BBM"><i class="glyphicon glyphicon-trash"></i> Batal </a>';
			} */
			
			
			
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
						"recordsTotal" => $this->m_permintaan->q_row_bbm()->num_rows(),
						"recordsFiltered" => $this->m_permintaan->q_row_bbm()->num_rows(),
						"data" => $data,
						"d" => $param_list2,
				);
		//output to json format
		echo json_encode($output);
	
				
	}
	
	function chose_optionbbm(){
		$inputfill=strtoupper(trim($this->input->post('inputfill')));
		$nama=trim($this->session->userdata('nik'));
		if ($inputfill=='PO'){
			redirect("ga/permintaan/form_list_po_final");
		} else if ($inputfill=='TRG') {
			redirect("ga/permintaan/form_list_trg_final");
		} else if ($inputfill=='AJS') {
			$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
			$nodokref=bin2hex($this->encrypt->encode('AJS'.$nama));
			redirect("ga/permintaan/input_bbm/$nodokref");
		}
	}
	
	
	function form_list_po_final(){
		$data['title']='FORM LIST PO FINAL/OUTSTANDING PO';
		$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
				/* akses approve atasan 
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param3_1=" and status in ('P','S')";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param3_1=" status in ('P','S') and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param3_1=" status in ('P','S') and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param3_1=" and status in ('P','S') and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses; */
		/* END APPROVE ATASAN */
		
		$param1_1=" and itemtype='BRG' and loccode='$kdcabang' and status IN ('P','S')";
		$param1=" and loccode='$kdcabang'";
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_po_final']=$this->m_permintaan->q_trx_po_mst_param($param1_1)->result();
		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		$this->template->display('ga/permintaan/v_listpo_final',$data);
	}
	
	function form_list_trg_final(){

		$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
		$nama=$this->session->userdata('nik');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$kdcabang=trim($dtlnik['kdcabang']);
		
		/* akses approve atasan 
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param3_1=" and status in ('P','S')";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param3_1=" status in ('P','S') and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$param3_1=" status in ('P','S') and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param3_1=" and status in ('P','S') and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses; */
		/* END APPROVE ATASAN */
		
		$param=" and loccode_destination='$kdcabang' and status IN ('P','S')";
		$data['title']="FORM LIST  BARANG TERKIRIM DI GUDANG $kdcabang";
		$data['list_itemtrans_in_trgd']=$this->m_itemtrans->q_trx_itemtrans_mst_param($param)->result();
		$this->template->display('ga/permintaan/v_list_in_trgd_final',$data);
	}
	
	
	
	
	
	
/*			-----------------------------------------------------------------------------------------------------------------------						*/	

	function input_bbm(){
		/* input sebagai nodok rev karena load po */
		/* dokumen referensi yg diload*/
		$nodokref=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$param_cek_1bbm=" and nodokref='$nodokref'";
		$cek_tmp=$this->m_permintaan->q_tmp_bbm_mst_param($param_cek_1bbm)->num_rows();
		$nama=$this->session->userdata('nik');
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$param3_1=" and nodokref='$nodokref' and nodok='$nama'";
		$param3_2=" and nodokref='$nodokref' and nodok='$nama'";
		$inputdate=date('Y-m-d H:i:s');
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		
		if (substr($nodokref, 0,2)=='PO') { 
						/* UNTUK INPUT TYPE PO */
						/* bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
						if ($cek_tmp==0 and !empty($nodokref)) {
							if($cek_tmp>0) {
								redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
							} else {
								$this->m_permintaan->insert_trx_po_to_bbm($nodokref,$nama,$inputdate);
												
								$this->db->where('userid',$nama);
								$this->db->where('modul','TMPSTBBM');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 0,
									'nomorakhir1' => $nodokref,
									'nomorakhir2' => '',
									'modul' => 'TMPSTBBM',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);
							}
						} else if ($cek_tmp>0 and !empty($nodokref)) {
							$dtl_tmp1bbm=$this->m_permintaan->q_tmp_bbm_mst_param($param_cek_1bbm)->row_array();
							if (isset($dtl_tmp1bbm['nodok'])){ $nodok_isset=trim($dtl_tmp1bbm['nodok']); } else { $nodok_isset='';	} 
							
							if ($nodok_isset<>trim($nama)) {
								redirect("ga/permintaan/form_bbm/input_fail/$nodok_isset");
							}
						}
						/* end bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
						
						
						$data['bbm_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
						$bbm_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
						$data['list_bbm_tmp_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->result();
						$bbm_dtl=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->row_array();
						$data['list_bbm_tmp_dtl']=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->result();
						$bbm_dtlref=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->row_array();
						$data['list_bbm_tmp_dtlref']=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->result();
						
						
						
						$data['title']='INPUT BUKTI BARANG MASUK';
						//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
						$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
						$kdcabang=trim($dtlnik['kdcabang']);
						$param1=" and loccode='$kdcabang'";
					
						$param_inp=" and nodok='$nama'";
						$dtlbranch=$this->m_akses->q_branch()->row_array();
						$branch=$dtlbranch['branch'];
						/* user hr akses */
						$userinfo=$this->m_akses->q_user_check()->row_array();
						$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
						$level_akses=strtoupper(trim($userinfo['level_akses']));
						$data['nama']=$nama;
						$data['userhr']=$userhr;
						$data['level_akses']=$level_akses;
						/*user hr end */
						
						$paramerror=" and userid='$nama' and modul='TMPSTBBM'";
						$dtlerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
						if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
					
							if($this->uri->segment(4)!="" and $errordesc<>''){
								$data['message']="<div class='alert alert-info'>$errordesc</div>";
							}else {
								$data['message']="";
							}
						$data['nodoktype']=trim($bbm_mst['nodoktype']);
						$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
						$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
						$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
						$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
						
						$this->template->display('ga/permintaan/v_bbm_input_bbm',$data);
						
						$paramerror=" and userid='$nama'";
						$dtlerror=$this->m_permintaan->q_deltrxerror($paramerror);
						/* ENDING TYPE PO */
		} else if (substr($nodokref, 0,3)=='TRG') { 
						/* UNTUK INPUT TYPE TRANSFER ANTAR GUDANG */
						/* bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
						if ($cek_tmp==0 and !empty($nodokref)) {
							if($cek_tmp>0) {
								redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
							} else {
								$this->m_permintaan->insert_trgd_po_to_bbm($nodokref,$nama,$inputdate);
												
								$this->db->where('userid',$nama);
								$this->db->where('modul','TMPSTBBM');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 0,
									'nomorakhir1' => $nodokref,
									'nomorakhir2' => '',
									'modul' => 'TMPSTBBM',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);
							}
						} else if ($cek_tmp>0 and !empty($nodokref)) {
							$dtl_tmp1bbm=$this->m_permintaan->q_tmp_bbm_mst_param($param_cek_1bbm)->row_array();
							if (isset($dtl_tmp1bbm['nodok'])){ $nodok_isset=trim($dtl_tmp1bbm['nodok']); } else { $nodok_isset='';	} 
							
							if ($nodok_isset<>trim($nama)) {
								redirect("ga/permintaan/form_bbm/input_fail/$nodok_isset");
							}
						}
						/* end bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
						
						
						$data['bbm_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
						$bbm_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
						$data['list_bbm_tmp_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->result();
						$bbm_dtl=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->row_array();
						$data['list_bbm_tmp_dtl']=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->result();
						$bbm_dtlref=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->row_array();
						$data['list_bbm_tmp_dtlref']=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->result();
						
						
						
						$data['title']='INPUT BUKTI BARANG MASUK';
						//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
						$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
						$kdcabang=trim($dtlnik['kdcabang']);
						$param1=" and loccode='$kdcabang'";
					
						$param_inp=" and nodok='$nama'";
						$dtlbranch=$this->m_akses->q_branch()->row_array();
						$branch=$dtlbranch['branch'];
						/* user hr akses */
						$userinfo=$this->m_akses->q_user_check()->row_array();
						$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
						$level_akses=strtoupper(trim($userinfo['level_akses']));
						$data['nama']=$nama;
						$data['userhr']=$userhr;
						$data['level_akses']=$level_akses;
						/*user hr end */
						
						$paramerror=" and userid='$nama' and modul='TMPSTBBM'";
						$dtlerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
						if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
					
							if($this->uri->segment(4)!="" and $errordesc<>''){
								$data['message']="<div class='alert alert-info'>$errordesc</div>";
							}else {
								$data['message']="";
							}
						$data['nodoktype']=trim($bbm_mst['nodoktype']);
						$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
						$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
						$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
						$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
						
						$this->template->display('ga/permintaan/v_bbm_input_bbm',$data);
						
						$paramerror=" and userid='$nama'";
						$dtlerror=$this->m_permintaan->q_deltrxerror($paramerror);
						/* ENDING TYPE PO */
		} else if (substr($nodokref, 0,3)=='AJS'){
			/////ECHO 'AJUSTMENT';
						/* UNTUK INPUT TYPE TRANSFER ANTAR GUDANG */
						/* bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
						if ($cek_tmp==0 and !empty($nodokref)) {
							if($cek_tmp>0) {
								redirect("ga/permintaan/form_bbk/input_fail/$nodok_isset");
							} else {
								$this->m_permintaan->insert_ajs_in_to_bbm($branch,$loccode,$nodokref,$nama,$inputdate);
												
								$this->db->where('userid',$nama);
								$this->db->where('modul','TMPSTBBM');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 0,
									'nomorakhir1' => $nodokref,
									'nomorakhir2' => '',
									'modul' => 'TMPSTBBM',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);
							}
						} else if ($cek_tmp>0 and !empty($nodokref)) {
							$dtl_tmp1bbm=$this->m_permintaan->q_tmp_bbm_mst_param($param_cek_1bbm)->row_array();
							if (isset($dtl_tmp1bbm['nodok'])){ $nodok_isset=trim($dtl_tmp1bbm['nodok']); } else { $nodok_isset='';	} 
							
							if ($nodok_isset<>trim($nama)) {
								redirect("ga/permintaan/form_bbm/input_fail/$nodok_isset");
							}
						}
						/* end bloking multi user harus ada 1 yg bisa ke temporary menarik dokumen pbk*/
						
						
						$data['bbm_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
						$bbm_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
						$data['list_bbm_tmp_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->result();
						$bbm_dtl=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->row_array();
						$data['list_bbm_tmp_dtl']=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->result();
						$bbm_dtlref=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->row_array();
						$data['list_bbm_tmp_dtlref']=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->result();
						
						
						
						$data['title']='INPUT BUKTI BARANG MASUK';
						//$data['list_nikpbk']=$this->m_akses->list_karyawan()->result();
						$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
						$kdcabang=trim($dtlnik['kdcabang']);
						$param1=" and loccode='$kdcabang'";
					
						$param_inp=" and nodok='$nama'";
						$dtlbranch=$this->m_akses->q_branch()->row_array();
						$branch=$dtlbranch['branch'];
						/* user hr akses */
						$userinfo=$this->m_akses->q_user_check()->row_array();
						$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
						$level_akses=strtoupper(trim($userinfo['level_akses']));
						$data['nama']=$nama;
						$data['userhr']=$userhr;
						$data['level_akses']=$level_akses;
						/*user hr end */
						
						$paramerror=" and userid='$nama' and modul='TMPSTBBM'";
						$dtlerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
						if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
					
							if($this->uri->segment(4)!="" and $errordesc<>''){
								$data['message']="<div class='alert alert-info'>$errordesc</div>";
							}else {
								$data['message']="";
							}
						
						$data['nodoktype']=trim($bbm_mst['nodoktype']);
						$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
						$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
						$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
						$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
						
						$this->template->display('ga/permintaan/v_bbm_input_bbm',$data);
						
						$paramerror=" and userid='$nama'";
						$dtlerror=$this->m_permintaan->q_deltrxerror($paramerror);
						/* ENDING TYPE PO */
		}
		
		
	}
	
		/* clear bbk temporary */
	function clear_tmp_bbm(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbm");
		}		
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['status']); 
				if ($status<>'I' and $status<>'E'){
						$nodoktmp=trim($dtledit['nodoktmp']); 
						/* restoring status  */
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nodoktmp);
						$this->db->update('sc_trx.stbbm_mst',$info);
						
						$info2 = array (
								'status' => 'A'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbm_dtl',$info2); 

				} else if ($status=='E'){
						$nodoktmp=trim($dtledit['nodoktmp']); 
						/* restoring status  */
						$info = array (
								'status' => 'A',
						);
						$this->db->where('nodok',$nodoktmp);
						$this->db->update('sc_trx.stbbm_mst',$info);
						
						$info2 = array (
								'status' => 'AE'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbm_dtl',$info2); 
				} else if ($status=='I') {
						$info2 = array (
								'status' => 'C'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbm_dtlref',$info2); 
				} 
				
				if ($status=='C') {
					/* clear tidak merubah detail & po*/
						$info2 = array (
								'status' => 'CL'
						);
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.stbbm_dtlref',$info2); 
				}
			
			/* clearing temporary  */
					
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbm_mst');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbm_dtl');
			$this->db->where('nodok',$nodok);
			$this->db->delete('sc_tmp.stbbm_dtlref');
				
			redirect("ga/permintaan/form_bbm/del_succes");
	}
	
	function cancel_tmp_bbm_dtl(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
 		$nama=$this->session->userdata('nik');
			$param3_1_2=" and nodok='$nama'";
			$dtledit=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1_2)->row_array(); //edit row array
			$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
			$enc_nodokref=bin2hex($this->encrypt->encode(trim($dtledit['nodokref']))); //inisial nodok tmp
			$status=trim($dtledit['status']); //inisial nodok tmp
		if(empty($nama)){
			redirect("ga/permintaan/form_bbm");
		}	
		
		if (trim($dtledit['nodoktype'])=='AJS') {
			$this->db->where('nodok',$nama);
			$this->db->delete('sc_tmp.stbbm_dtl');
			//redirect("ga/permintaan/edit_bbm/$enc_nodok");
			redirect("ga/permintaan/form_bbm");
		} else {	
			if ($status=='I') {
				$info = array (
					'qtybbm' => 0,
					'status' => '',
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stbbm_dtl',$info);

				redirect("ga/permintaan/input_bbm/$enc_nodokref");
			} else if ($status=='E') {
				$info = array (
					'qtybbm' => 0,
					'status' => ''
				);
				$this->db->where('nodok',$nama);
				$this->db->update('sc_tmp.stbbm_dtl',$info);
				redirect("ga/permintaan/edit_bbm/$enc_nodok");
			}  
			
		}

	}
	
	function save_bbm(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nik=strtoupper(trim($this->input->post('nik')));
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$fromcode=strtoupper($this->input->post('fromcode'));
		$nodoktmp=strtoupper($this->input->post('nodoktmp'));
		$id=strtoupper($this->input->post('id'));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		$loccode=strtoupper($this->input->post('loccode'));
		$desc_barang=strtoupper($this->input->post('desc_barang'));
		$qtyrec=(strtoupper(trim($this->input->post('qtyrec')))=='' ? '0' : strtoupper(trim($this->input->post('qtyrec'))));
		$qtyreckecil=(strtoupper(trim($this->input->post('qtyreckecil')))=='' ? '0' : strtoupper(trim($this->input->post('qtyreckecil'))));
		$qtybbm=(strtoupper(trim($this->input->post('qtybbm')))=='' ? '0' : strtoupper(trim($this->input->post('qtybbm'))));
		$qtybbmkecil=(strtoupper(trim($this->input->post('qtybbmkecil')))=='' ? '0' : strtoupper(trim($this->input->post('qtybbmkecil'))));
		$onhand=strtoupper($this->input->post('onhand'));
		$status=strtoupper($this->input->post('status'));
		$satminta=strtoupper($this->input->post('satminta'));
		$satkecil=strtoupper($this->input->post('satkecil'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$nodokfrom=strtoupper($this->input->post('nodokfrom'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_nodok=bin2hex($this->encrypt->encode($nodok));
		$enc_nodokref=bin2hex($this->encrypt->encode($nodokref));
		$enc_nodoktmp=bin2hex($this->encrypt->encode($nodoktmp));
		// if(empty($nodok)){
			// redirect("ga/permintaan/form_permintaan");
		// }
		if ($type=='EDTMPDTLREFBBM') {
			$param1=" and nodok='$nama' and nodokref='$nodokref' and fromcode='$fromcode' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode' and id='$id'";
			$dtlbbm=$this->m_permintaan->q_tmp_bbm_dtlref_param($param1)->row_array();
			
			if ($qtyrec<$qtybbm or $qtybbm<0){
					redirect("ga/permintaan/input_bbm/$enc_nodokref");
			}	else {
					$info = array (
								'qtybbm' => $qtybbm,
								'status' => '',
								'keterangan' => $keterangan,
								'updatedate' => $inputdate,
								'updateby' => $inputby	
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('fromcode',$fromcode);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtlref',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					} else {
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					}
			}
		//	ECHO $qtyrec<$qtybbm;

		} else if ($type=='EDTRXDTLREFBBM') {
			$param1=" and nodok='$nama' and nodokref='$nodokref' and fromcode='$fromcode' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode' and id='$id'";
			$dtlbbm=$this->m_permintaan->q_tmp_bbm_dtlref_param($param1)->row_array();
			
			if ($qtyrec<$qtybbm or $qtybbm<0){
					redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
			}	else {
					$info = array (
								'qtybbm' => $qtybbm,
								'status' => '',
								'keterangan' => $keterangan,
								'updatedate' => $inputdate,
								'updateby' => $inputby	
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('fromcode',$fromcode);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtlref',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					} else {
						redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					}
			}
		//	ECHO $qtyrec<$qtybbm;
		} else if ($type=='INPUTTMPDTLBBM') {
			$param1=" and nodok='$nama' and nodokref='$nodokref' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode' and id='$id'";
			$dtlbbm=$this->m_permintaan->q_tmp_bbm_dtl_param($param1)->row_array();
			
			if ($qtyrec<$qtybbm or $qtybbm<0){
				
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBM');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 1,
							'nomorakhir1' => $nodokref,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBM',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("ga/permintaan/input_bbm/$enc_nodokref");
			}	else {
					$info = array (
								'qtybbm' =>  (int)$qtybbm,
								'status' => '',
								'keterangan' => $keterangan,
								'updatedate' => $inputdate,
								'updateby' => $inputby	
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					} else {
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					}
			}
		} else if ($type=='INPUTTMPDTLBBM_NO_REFERENSI') {
			$param1=" and nodok='$nama' and nodokref='$nodokref'";
			$param2=" and nodok='$nama' and nodokref='$nodokref' and kdgroup='$kdgroup'  and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode'";
			$mstbbm=$this->m_permintaan->q_tmp_bbm_mst_param($param1)->row_array();
			$num_dtlbbm=$this->m_permintaan->q_tmp_bbm_dtl_param($param2)->num_rows();
			if ($qtybbm<=0 or $num_dtlbbm>0) {
				
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBM');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 1,
							'nomorakhir1' => $nodokref,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBM',
						);
					$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("ga/permintaan/input_bbm/$enc_nodokref");
			}	else {
					$info = array (
								'branch' => $branch,
								'nodok' => $nodok,
								'nodokref' => $nodokref,
								'kdgroup' => $kdgroup,
								'kdsubgroup' => $kdsubgroup,
								'stockcode' => $stockcode,
								'desc_barang' => $desc_barang,
								'loccode' => $loccode,
								'qtyrec' =>  (int)$qtybbm,
								'qtyreckecil' =>  (int)$qtybbm,
								'qtybbm' =>  (int)$qtybbm,
								'qtybbmkecil' =>  (int)$qtybbm,
								'satminta' =>  $satminta,
								'satkecil' =>  $satkecil,
								'status' => 'I',
								'keterangan' => $keterangan,
								'inputdate' => $inputdate,
								'inputby' => $inputby,	
								'id' => 0,
						);
						$this->db->insert('sc_tmp.stbbm_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					} else {
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					}
			}
		} else if ($type=='EDITTMPDTLBBM') {
			$param1=" and nodok='$nama' and nodokref='$nodokref' and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode' and id='$id'";
			$dtlbbm=$this->m_permintaan->q_tmp_bbm_dtl_param($param1)->row_array();
			
			if ($qtyrec<$qtybbm or $qtybbm<0){
				
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBM');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 1,
							'nomorakhir1' => $nodokref,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBM',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
			}	else {
					$info = array (
								'qtybbm' =>  (int)$qtybbm,
								'status' => '',
								'keterangan' => $keterangan,
								'updatedate' => $inputdate,
								'updateby' => $inputby	
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					} else {
						redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					}
			}
		} else if ($type=='INPUTFINALBBM') {
			$param1=" and nodok='$nama'";
			$dtlbbm=$this->m_permintaan->q_tmp_bbm_dtl_param($param1)->num_rows();
			
			if ($dtlbbm==0){
				
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBM');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 1,
							'nomorakhir1' => $nodokref,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBM',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("ga/permintaan/form_bbm");
			}	else {			
						$info = array (
									'status' => 'F',
									'nodokfrom' => $nodokfrom,
									'keterangan' => $keterangan,
									'updatedate' => $inputdate,
									'updateby' => $inputby	
							);
							$this->db->where('nodok',$nodok);
							$this->db->where('nodokref',$nodokref);
							$this->db->update('sc_tmp.stbbm_mst',$info); 
						
						$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
						$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
						if ($trxerror>0){
							redirect("ga/permintaan/input_bbm");
						} else {
							redirect("ga/permintaan/form_bbm");
						}
			}
		} else if ($type=='EDITTMPDTLBBM_NO_REFERENSI') {
			$param1=" and nodok='$nama' and nodokref='$nodokref'";
			$param2=" and nodok='$nama' and nodokref='$nodokref' and kdgroup='$kdgroup'  and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode'";
			$mstbbm=$this->m_permintaan->q_tmp_bbm_mst_param($param1)->row_array();
			$num_dtlbbm=$this->m_permintaan->q_tmp_bbm_dtl_param($param2)->num_rows();
			if ($qtybbm<=0 or $num_dtlbbm>0) {
				
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBM');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 1,
							'nomorakhir1' => $nodokref,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBM',
						);
					$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
			}	else {
					$info = array (
								'branch' => $branch,
								'nodok' => $nodok,
								'nodokref' => $nodokref,
								'kdgroup' => $kdgroup,
								'kdsubgroup' => $kdsubgroup,
								'stockcode' => $stockcode,
								'desc_barang' => $desc_barang,
								'loccode' => $loccode,
								'qtyrec' =>  (int)$qtybbm,
								'qtyreckecil' =>  (int)$qtybbm,
								'qtybbm' =>  (int)$qtybbm,
								'qtybbmkecil' =>  (int)$qtybbm,
								'satminta' =>  $satminta,
								'satkecil' =>  $satkecil,
								'status' => 'I',
								'keterangan' => $keterangan,
								'inputdate' => $inputdate,
								'inputby' => $inputby,	
								'nodoktmp' => $nodoktmp,	
								'id' => 0,
						);
						$this->db->insert('sc_tmp.stbbm_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					} else {
						redirect("ga/permintaan/edit_bbm/$enc_nodoktmp");
					}
			}
		} else if ($type=='EDITFINALBBM') {
						$info = array (
									'status' => 'F',
									'keterangan' => $keterangan,
									'updatedate' => $inputdate,
									'updateby' => $inputby	
							);
							$this->db->where('nodok',$nodok);
							$this->db->where('nodokref',$nodokref);
							$this->db->update('sc_tmp.stbbm_mst',$info); 
						
						$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
						$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
						if ($trxerror>0){
							redirect("ga/permintaan/edit_bbm");
						} else {
							redirect("ga/permintaan/form_bbm");
						}
		} else if ($type=='BATALFINALBBM') {
						$info = array (
									'status' => 'F',
									'keterangan' => $keterangan,
									'updatedate' => $inputdate,
									'updateby' => $inputby	
							);
							$this->db->where('nodok',$nodok);
							$this->db->where('nodokref',$nodokref);
							$this->db->update('sc_tmp.stbbm_mst',$info); 
						
						$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
						$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
						if ($trxerror>0){
							redirect("ga/permintaan/batal_bbm");
						} else {
							redirect("ga/permintaan/form_bbm");
						}
		}  else if ($type=='APPFINALBBM') {
			$param32_x=" and nodok='$nama' and status='C'"; // PARAM KUNCI DETAIL
			$cekrefbbm=$this->m_permintaan->q_tmp_bbm_dtlref_param($param32_x)->num_rows();
			
				if ($cekrefbbm>0) {
					
						$this->db->where('userid',$nama);
						$this->db->where('modul','TMPSTBBM');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 1,
							'nomorakhir1' => $nodokref,
							'nomorakhir2' => '',
							'modul' => 'TMPSTBBM',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
					
						redirect("ga/permintaan/approval_bbm/enc_nodoktmp");
				} else {
			
						$info = array (
									'status' => 'F',
									'keterangan' => $keterangan,
									'approvaldate' => $inputdate,
									'approvalby' => $inputby	
							);
							$this->db->where('nodok',$nodok);
							$this->db->where('nodokref',$nodokref);
							$this->db->update('sc_tmp.stbbm_mst',$info); 
						
						$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
						$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
						if ($trxerror>0){
							redirect("ga/permintaan/form_bbm");
						} else {
							redirect("ga/permintaan/form_bbm");
						}
				}
		}  else if ($type=='BBMAPPDTL') { /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
								'status' => 'P',
								'keterangan' => $keterangan,
								'approvaldate' => $inputdate,
								'approvalby' => $inputby	
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('fromcode',$fromcode);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtlref',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' ";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					} else {
						redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					}
				
		}  else if ($type=='REJAPPDTL') { /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
								'status' => 'C',
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('fromcode',$fromcode);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtlref',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					} else {
						redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					}
				
		}   else if ($type=='CAPPRDTL') {  /* REAPPROVE DETAIL DOKUMEN */
					$info = array (
								'status' => 'A',
								'keterangan' => $keterangan,
								'approvaldate' => $inputdate,
								'approvalby' => $inputby	
						);
						$this->db->where('nodok',$nodok);
						$this->db->where('nodokref',$nodokref);
						$this->db->where('fromcode',$fromcode);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->where('id',$id);
						$this->db->update('sc_tmp.stbbm_dtlref',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					} else {
						redirect("ga/permintaan/approval_bbm/$enc_nodoktmp");
					}
				
		}  else if ($type=='CANCELTRXMST') {
					/* FINAL SETELAH BATAL */
					$info = array (
							'status' => 'F',
							'updatedate' => date('Y-m-d H:i:s'),
							'updateby' => $nama	
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.stbbk_mst',$info);
					redirect("ga/permintaan/form_bbm/cancel_succes");
		} else if ($type=='HANGUSFINAL') {
					/* FINAL SETELAH PENGHANGUSAN */
					$info = array (
							'status' => 'F',
							'updatedate' => date('Y-m-d H:i:s'),
							'updateby' => $nama	
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.stbbk_mst',$info);
					redirect("ga/permintaan/form_bbm/inp_succes");
		} else if ($type=='DELETETRXMST') {
			$info = array (
						'status' => 'C',
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.stbbk_mst',$info);
				redirect("ga/permintaan/form_bbm/cancel_succes");
		} else if ($type=='DELETETMPDTLBBM_NO_REFERENSI') {
					$this->db->where('nodok',$nodok);
					$this->db->where('kdgroup',$kdgroup);
					$this->db->where('kdsubgroup',$kdsubgroup);
					$this->db->where('stockcode',$stockcode);
					$this->db->delete('sc_tmp.stbbm_dtl',$info); 
					
					$paramtrx=" and userid='$nama' and errorcode>'0' and modul='TMPSTBBM'";
					$trxerror=$this->m_permintaan->q_trxerror($paramtrx)->num_rows();	
					if ($trxerror>0){
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					} else {
						redirect("ga/permintaan/input_bbm/$enc_nodokref");
					}
			
		} else {
			redirect("ga/permintaan/form_bbm");
		}
		
	}
	
	function edit_bbm(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	 	$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbm");
		}
		
		$param_trxapprov=" and nodok='$nodok' and status in ('D','C','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_trx_bbm_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/permintaan/form_bbm/process_fail/$nodok");
		}
		//// REDIRECT JIKA USER LAIN KALAH CEPAT 
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_permintaan->q_tmp_bbm_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_tmp_bbm_mst_param($param3_first)->row_array();
		$param3_1=" and nodoktmp='$nodok'";
		$param3_2=" and nodoktmp='$nodok'";
		$param3_3=" and nodok='$nodok'";
		$dtldokref=$this->m_permintaan->q_trx_bbm_mst_param($param3_3)->row_array();
		
		$info = array (
				'status' => 'E',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stbbm_mst',$info);

		
		
		if (isset($dtldokref['nodokref'])) {
			$nodokref=trim($dtldokref['nodokref']);
		} else {
			$nodokref=""; 
		}
		
		$paramceknodokref_one=" and nodokref='$nodokref' ";
		$paramceknodokref_two=" and nodokref='$nodokref' and nodok='$nama'";
		$paramceknodokref_three=" and nodok='$nama'";
		$cek_first_nodokref_one=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_one)->num_rows();
		$cek_first_nodokref_two=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_two)->num_rows();
		$cek_first_nodokref_three=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_three)->num_rows();
		$dtl_first_nodokref=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_one)->row_array();
		$data['bbm_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
		$bbm_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
		if($cek_first_nodokref_one>0 and $cek_first_nodokref_two==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbm/edit_fail/$nodokfirst");
/*		} else if($cek_first_nodokref_three==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbm/edit_fail/$nodokfirst"); */
		}  else {
			$bbk_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
			$data['bbk_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
			$data['list_bbm_tmp_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->result();
			$bbm_dtl=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->row_array();
			$data['list_bbm_tmp_dtl']=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->result();
			$bbm_dtlref=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->row_array();
			$data['list_bbm_tmp_dtlref']=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->result();
			
			
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" EDIT INPUT BUKTI BARANG MASUK";
			if($this->uri->segment(5)=="bc_failed")
				$data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
			else if($this->uri->segment(5)=="edit_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
			else if($this->uri->segment(5)=="rep_succes")
				$data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
			else if($this->uri->segment(5)=="inp_succes")
				$data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
			else if($this->uri->segment(5)=="edit_succes")
				$data['message']="<div class='alert alert-success'>Ubah data Qty BBK berhasil</div>";
			else if($this->uri->segment(5)=="del_succes")
				$data['message']="<div class='alert alert-success'>Delete Succes</div>";
			else if($this->uri->segment(5)=="del_failed")
				$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
			else if($this->uri->segment(5)=="fail_value")
				$data['message']="<div class='alert alert-danger'>Stok harus tidak lebih besar dari referensi PBK</div>";
			else if($this->uri->segment(5)=="inp_kembar")
				$data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
			else if($this->uri->segment(5)=="wrong_format")
				$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
			else if($this->uri->segment(5)=="warn_onhand")
				$data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
			else {
						$paramerror=" and userid='$nama' and modul='TMPSTBBM'";
						$dtlerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
						if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
					
							if($this->uri->segment(4)!="" and $errordesc<>''){
								$data['message']="<div class='alert alert-info'>$errordesc</div>";
							}else {
								$data['message']="";
							}
			}
			$data['nodoktype']=trim($bbm_mst['nodoktype']);
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_bbm_edit_bbm.php',$data);	

						$paramerror=" and userid='$nama'";
						$dtlerror=$this->m_permintaan->q_deltrxerror($paramerror);
						/* ENDING TYPE TEST */			
		}
	}
	
	function detail_bbm(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	 	$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbm");
		}
		$param3_3="and nodok='$nodok'";	
		
			$data['list_bbm_trx_mst']=$this->m_permintaan->q_trx_bbm_mst_param($param3_3)->result();
			$bbm_dtl=$this->m_permintaan->q_trx_bbm_dtl_param($param3_3)->row_array();
			$data['list_bbm_trx_dtl']=$this->m_permintaan->q_trx_bbm_dtl_param($param3_3)->result();
			$bbm_dtlref=$this->m_permintaan->q_trx_bbm_dtlref_param($param3_3)->row_array();
			$data['list_bbm_trx_dtlref']=$this->m_permintaan->q_trx_bbm_dtlref_param($param3_3)->result();
			$data['bbm_mst']=$this->m_permintaan->q_trx_bbm_mst_param($param3_3)->row_array();
			$bbm_mst=$this->m_permintaan->q_trx_bbm_mst_param($param3_3)->row_array();
			
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" DETAIL INPUT BUKTI BARANG MASUK";
			if($this->uri->segment(5)=="bc_failed")
				$data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
			else if($this->uri->segment(5)=="edit_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
			else
				$data['message']='';
			
			
			$data['nodoktype']=trim($bbm_mst['nodoktype']);
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_bbm_detail_bbm.php',$data);					  
		
	}
	
	function batal_bbm(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	 	$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbm");
		}
		
		$param_trxapprov=" and nodok='$nodok' and status in ('D','H','P','F')";
		$cek_trxapprov=$this->m_permintaan->q_trx_bbm_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/permintaan/form_bbm/process_fail/$nodok");
		}
		//// REDIRECT JIKA USER LAIN KALAH CEPAT 
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_permintaan->q_tmp_bbm_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_tmp_bbm_mst_param($param3_first)->row_array();
		$param3_1=" and nodoktmp='$nodok'";
		$param3_2=" and nodoktmp='$nodok'";
		$param3_3=" and nodok='$nodok'";
		$dtldokref=$this->m_permintaan->q_trx_bbm_mst_param($param3_3)->row_array();
		
		$info = array (
				'status' => 'C',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stbbm_mst',$info);

		
		
		if (isset($dtldokref['nodokref'])) {
			$nodokref=trim($dtldokref['nodokref']);
		} else {
			$nodokref=""; 
		}
		
		$paramceknodokref_one=" and nodokref='$nodokref' ";
		$paramceknodokref_two=" and nodokref='$nodokref' and nodok='$nama'";
		$paramceknodokref_three=" and nodok='$nama'";
		$cek_first_nodokref_one=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_one)->num_rows();
		$cek_first_nodokref_two=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_two)->num_rows();
		$cek_first_nodokref_three=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_three)->num_rows();
		$dtl_first_nodokref=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_one)->row_array();
		
		if($cek_first_nodokref_one>0 and $cek_first_nodokref_two==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbm/edit_fail/$nodokfirst");
/*		} else if($cek_first_nodokref_three==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbm/edit_fail/$nodokfirst"); */
		}  else {
			$bbm_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
			$data['bbm_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
			$data['list_bbm_tmp_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->result();
			$bbm_dtl=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->row_array();
			$data['list_bbm_tmp_dtl']=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->result();
			$bbm_dtlref=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->row_array();
			$data['list_bbm_tmp_dtlref']=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->result();
			
			
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" BATAL INPUT BUKTI BARANG MASUK";
			if($this->uri->segment(5)=="bc_failed")
				$data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
			else if($this->uri->segment(5)=="edit_fail")
				$data['message']="<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
			else if($this->uri->segment(5)=="rep_succes")
				$data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
			else if($this->uri->segment(5)=="inp_succes")
				$data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
			else if($this->uri->segment(5)=="edit_succes")
				$data['message']="<div class='alert alert-success'>Ubah data Qty BBK berhasil</div>";
			else if($this->uri->segment(5)=="del_succes")
				$data['message']="<div class='alert alert-success'>Delete Succes</div>";
			else if($this->uri->segment(5)=="del_failed")
				$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
			else if($this->uri->segment(5)=="fail_value")
				$data['message']="<div class='alert alert-danger'>Stok harus tidak lebih besar dari referensi PBK</div>";
			else if($this->uri->segment(5)=="inp_kembar")
				$data['message']="<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
			else if($this->uri->segment(5)=="wrong_format")
				$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
			else if($this->uri->segment(5)=="warn_onhand")
				$data['message']="<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
			else
				$data['message']='';
			$data['nodoktype']=trim($bbm_mst['nodoktype']);
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_bbm_batal_bbm.php',$data);					  
		}
	}
	
	function approval_bbm(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
	 	$nama=$this->session->userdata('nik');
		if(empty($nodok)){
			redirect("ga/permintaan/form_bbm");
		}
		
		$param_trxapprov=" and nodok='$nodok' and status in ('D','H','C','F')";
		$cek_trxapprov=$this->m_permintaan->q_trx_bbm_mst_param($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/permintaan/form_bbm/process_fail/$nodok");
		}
		//// REDIRECT JIKA USER LAIN KALAH CEPAT 
		$param3_first=" and nodok<>'$nama' and nodoktmp='$nodok'";
		$cek_first=$this->m_permintaan->q_tmp_bbm_mst_param($param3_first)->num_rows();
		$dtl_first=$this->m_permintaan->q_tmp_bbm_mst_param($param3_first)->row_array();
		$param3_1=" and nodoktmp='$nodok'";
		$param3_2=" and nodoktmp='$nodok'";
		$param3_3=" and nodok='$nodok'";
		$dtldokref=$this->m_permintaan->q_trx_bbm_mst_param($param3_3)->row_array();

		
		$info = array (
				'status' => 'AP',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
		);
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.stbbm_mst',$info);

		
		
		if (isset($dtldokref['nodokref'])) {
			$nodokref=trim($dtldokref['nodokref']);
		} else {
			$nodokref=""; 
		}
		
		$paramceknodokref_one=" and nodokref='$nodokref' ";
		$paramceknodokref_two=" and nodokref='$nodokref' and nodok='$nama'";
		$paramceknodokref_three=" and nodok='$nama'";
		$cek_first_nodokref_one=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_one)->num_rows();
		$cek_first_nodokref_two=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_two)->num_rows();
		$cek_first_nodokref_three=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_three)->num_rows();
		$dtl_first_nodokref=$this->m_permintaan->q_tmp_bbm_mst_param($paramceknodokref_one)->row_array();
		$bbm_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
		$data['bbm_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
		
		if($cek_first_nodokref_one>0 and $cek_first_nodokref_two==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbm/edit_fail/$nodokfirst");
/*		} else if($cek_first_nodokref_three==0){
			$nodokfirst=trim($dtl_first_nodokref['nodok']);
			redirect("ga/permintaan/form_bbm/edit_fail/$nodokfirst"); */
		}  else {
			$bbk_mst=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
			$data['bbk_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->row_array();
			$data['list_bbm_tmp_mst']=$this->m_permintaan->q_tmp_bbm_mst_param($param3_1)->result();
			$bbm_dtl=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->row_array();
			$data['list_bbm_tmp_dtl']=$this->m_permintaan->q_tmp_bbm_dtl_param($param3_2)->result();
			$bbm_dtlref=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->row_array();
			$data['list_bbm_tmp_dtlref']=$this->m_permintaan->q_tmp_bbm_dtlref_param($param3_2)->result();
			
			
			$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
			$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
			$kdcabang=trim($dtlnik['kdcabang']);
			$param1=" and loccode='$kdcabang'";
			
			$data['title']=" BATAL INPUT BUKTI BARANG MASUK";
			
			
			$paramerror=" and userid='$nama' and modul='TMPSTBBM'";
			$dtlerror=$this->m_permintaan->q_trxerror($paramerror)->row_array();
			if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		
				if($this->uri->segment(4)!="" and $errordesc<>''){
					$data['message']="<div class='alert alert-info'>$errordesc</div>";
				}else {
					$data['message']="";
				}
			
			$data['nodoktype']=trim($bbm_mst['nodoktype']);
			$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
			$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
			$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
			$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_bbm_approval_bbm.php',$data);		
			$paramerror=" and userid='$nama'";
			$dtlerror=$this->m_permintaan->q_deltrxerror($paramerror);
		}
	}
	
	/* -----------------------------------------------HISTORY BBK-------------------------------------------------------------------------------*/
	
	function filter_history_bbk(){
			$data['title']='FILTER HISTORY PEMAKAIAN BARANG';
			$param_kanwil='';
			$data['list_kanwil']=$this->m_permintaan->q_mstkantor($param_kanwil)->result();
			//$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
			$this->template->display('ga/permintaan/v_filter_history_bbk.php',$data);	
	}
	function history_bbk(){
		$data['title']="LIST HISTORY BUKTI BARANG KELUAR PERIODE ";	
		$nama=$this->session->userdata('nik');
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		$nik=strtoupper($this->input->post('nik'));
		$tgl=explode(' - ',trim($this->input->post('tgl')));
		if(isset($tgl[0]) and isset($tgl[1])) {
			$tgl1=date('Y-m-d', strtotime(trim($tgl[0])));
			$tgl2=date('Y-m-d', strtotime(trim($tgl[1])));
		} else { redirect("ga/permintaan/filter_history_bbk");	} 
		
		//$qtyrec=(strtoupper(trim($this->input->post('qtyrec')))=='' ? '0' : strtoupper(trim($this->input->post('qtyrec'))));
		if(empty($kdgroup)or $kdgroup=='' or $kdgroup==null){ $kdgroup=""; } else { $kdgroup=" and kdgroup='$kdgroup'"; 	}
		if(empty($kdsubgroup)or $kdsubgroup=='' or $kdsubgroup==null){	$kdsubgroup="";	} else { $kdsubgroup=" and kdsubgroup='$kdsubgroup'"; }	
		if(empty($stockcode)or $stockcode=='' or $stockcode==null){	$stockcode="";	} else { $stockcode=" and stockcode='$stockcode'";	}
		if(empty($tgl)or $tgl=='' or $tgl==null){$tgl="";} else { 	$tgl=" and to_char(nodokdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2'";}
		if(empty($nik)or $nik=='' or $nik==null){$nik=""; } else { 	$nik=" and nik='$nik'";}

		$param_list_akses=$kdgroup.$kdsubgroup.$stockcode.$tgl.$nik."and status='P'";
				
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.C.2';
						$versirelease='I.G.C.2/ALPHA.001';
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
								

		$param1="";

		$data['list_scgroup']=$this->m_permintaan->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_permintaan->q_scsubgroup()->result();
		$data['list_mstbarangatk']=$this->m_permintaan->q_mstbarang_atk()->result();
		$data['list_stkgdw']=$this->m_permintaan->q_stkgdw_param1($param1)->result();
		//$data['list_mstbbk']=$this->m_permintaan->q_bbk_trx_mst_param($param_list_akses)->result();
		$data['list_dtlbbk']=$this->m_permintaan->q_bbk_trx_dtl_param($param_list_akses)->result();
        $this->template->display('ga/permintaan/v_list_history_bbk',$data);

	}
	
	
}