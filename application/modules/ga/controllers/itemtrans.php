<?php
/*
	@author : fiky
	13-10-2017
*/
//error_reporting(0)
class Itemtrans extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
		$this->load->model(array('master/m_akses','m_itemtrans'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA TRANSFER BARANG, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/itemtrans/v_index',$data);
	}

	function form_itemtrans_in_trgd(){
		$data['title']="LIST TRANSFER BARANG ANTAR GUDANG";	
		$nama=$this->session->userdata('nik');
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.4';
						$versirelease='I.G.D.4/ALPHA.001';
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
						
				/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and nodok='$nama' and status='I'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param3_1_3=" and nodok='$nama' and status='A'";
		$param3_1_4=" and nodok='$nama' and status='C'";
		$param3_1_5=" and nodok='$nama' and status='H'";
		$param3_1_R=" and nodok='$nama'";
			$cekmstajst_na=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param3_1_1)->num_rows(); //input
			$cekmstajst_ne=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param3_1_2)->num_rows(); //edit
			$cekmstajst_napp=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param3_1_3)->num_rows(); //approv
			$cekmstajst_cancel=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param3_1_4)->num_rows(); //cancel
			$cekmstajst_hangus=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param3_1_5)->num_rows(); //hangus
			$dtledit=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			$enc_nik=bin2hex($this->encrypt->encode($nama));
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekmstajst_na>0) { //cek inputan
					redirect("ga/itemtrans/input_itemtrans_in_trgd");
			} else if ($cekmstajst_ne>0){	//cek edit
					redirect("ga/itemtrans/edit_itemtrans_in_trgd/$enc_nodok");
			} else if ($cekmstajst_napp>0){	//cek approv
					redirect("ga/itemtrans/approv_itemtrans_in_trgd/$enc_nodok");
			} else if ($cekmstajst_cancel>0){	//cek cancel
					redirect("ga/itemtrans/batal_itemtrans_in_trgd/$enc_nodok");
			} else if ($cekmstajst_hangus>0){	//cek cancel
					redirect("ga/itemtrans/hangus_po_atk/$enc_nodok");
			}
		
		
		$paramerror=" and modul='AJST_IN_TRGD' and userid='$nama'";
		$dtlerror=$this->m_itemtrans->q_trxerror($paramerror)->row_array();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		
		if($this->uri->segment(4)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada Harap Input Kode Yg Belum Tersedia</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$param="";				
		$data['list_itemtrans_in_trgd']=$this->m_itemtrans->q_trx_itemtrans_mst_param($param)->result();
		$this->template->display('ga/itemtrans/v_list_in_trgd',$data);
	}
	
	function input_itemtrans_in_trgd(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.4';
						$versirelease='I.G.D.4/ALPHA.001';
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
		
		$data['nik']=$nama;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$data['list_lk']=$this->m_akses->list_karyawan_index($nama)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nama)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param_inp=" and nodok='$nama'";
		/* user akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		/*user hr end */
		$cek_inp=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param_inp)->num_rows();
					
		if ($cek_inp==0) {
			$info_mst = array (
					'branch' => $branch,
					'nodok' => $nama,
					'status' => 'I',
					'description' => '',
					'inputdate' => date('Y-m-d H:i:s'),
					'inputby' => $nama	);	 
			$this->db->insert('sc_tmp.itemtrans_mst',$info_mst);
		}
		
		
		if($this->uri->segment(4)=="fail_input_mst_in_trgd")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Tidak Boleh Sama / Kode Barang Harus Beda </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_isidtl")
            $data['message']="<div class='alert alert-danger'> Detail Data Sudah Ada/Terisi data tidak Bisa Terupdate Kesalahan Data  </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_umm")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Harus Sama  Untuk Type Ajusment In Umum  </div>";
		else if($this->uri->segment(4)=="fail_input_dtl_in_trgd")
            $data['message']="<div class='alert alert-danger'> Input gagal detail qty tidak boleh 0 atau lebih kecil dari stock barang onhand / Kode Barang Sudah Tersedia</div>";
		else if($this->uri->segment(4)=="success_input_mst_in_trgd")
            $data['message']="<div class='alert alert-success'>Data Master Sudah Berhasil Di Update</div>";
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
		
		$data['title']=' INPUT ITEM TRANSFER ANTAR GUDANG ';
		$paramx=" and nodok='$nama'";
		$data['list_master']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->result();
		$data['list_detail']=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->result();
		$data['trg_mst']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$trg_mst=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$loccode=trim($trg_mst['loccode']);
		$data['list_scgroup']=$this->m_itemtrans->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_itemtrans->q_scsubgroup()->result();
		///$data['list_mstbarangatk']=$this->m_itemtrans->q_mstbarang_atk()->result();
		$param1=" and loccode='$loccode'";
		$data['list_stkgdw']=$this->m_itemtrans->q_stkgdw_param1($param1)->result();
		$data['desc_gudang']=$this->m_itemtrans->q_mstkantor()->result();
		
		$this->template->display('ga/itemtrans/v_input_in_trgd',$data);
	
	}
	
	function edit_itemtrans_in_trgd(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.4';
						$versirelease='I.G.D.4/ALPHA.001';
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
		
		$data['nik']=$nama;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$data['list_lk']=$this->m_akses->list_karyawan_index($nama)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nama)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param_inp=" and nodoktmp='$nodok'";
		/* user akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		/*user hr end */
		$cek_inp=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param_inp)->num_rows();
		if ($cek_inp>0){
						$this->db->where('userid',$nama);
						$this->db->where('modul','ITEMTRANS');
						$this->db->delete('sc_mst.trxerror');
						$insinfo = array (
							'userid' => $nama,
							'errorcode' => 1,
							'modul' => 'ITEMTRANS'
						);
					$this->db->insert('sc_mst.trxerror',$insinfo);
				//////redirect("ga/itemtrans/edit_itemtrans_in_trgd/fail_input_dtl_in_trgd");
		} else if ($cek_inp==0) {
			$info_mst = array (
					
					'status' => 'E',
					'updatedate' => date('Y-m-d H:i:s'),
					'updateby' => $nama);	 
			$this->db->where('nodok',$nodok);		
			$this->db->update('sc_trx.itemtrans_mst',$info_mst);
		}
		
		
		if($this->uri->segment(4)=="fail_input_mst_in_trgd")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Tidak Boleh Sama / Kode Barang Harus Beda </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_isidtl")
            $data['message']="<div class='alert alert-danger'> Detail Data Sudah Ada/Terisi data tidak Bisa Terupdate Kesalahan Data  </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_umm")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Harus Sama  Untuk Type Ajusment In Umum  </div>";
		else if($this->uri->segment(4)=="fail_input_dtl_in_trgd")
            $data['message']="<div class='alert alert-danger'> Input gagal detail qty tidak boleh 0 atau lebih kecil dari stock barang onhand / Kode Barang Sudah Tersedia</div>";
		else if($this->uri->segment(4)=="success_input_mst_in_trgd")
            $data['message']="<div class='alert alert-success'>Data Master Sudah Berhasil Di Update</div>";
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
		
		$data['title']=' UBAH DATA ITEM TRANSFER ANTAR GUDANG ';
		$paramx=" and nodok='$nama'";
		$data['list_master']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->result();
		$data['list_detail']=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->result();
		$data['trg_mst']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$trg_mst=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$loccode=trim($trg_mst['loccode']);
		$data['list_scgroup']=$this->m_itemtrans->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_itemtrans->q_scsubgroup()->result();
		///$data['list_mstbarangatk']=$this->m_itemtrans->q_mstbarang_atk()->result();
		$param1=" and loccode='$loccode'";
		$data['list_stkgdw']=$this->m_itemtrans->q_stkgdw_param1($param1)->result();
		$data['desc_gudang']=$this->m_itemtrans->q_mstkantor()->result();
		
		$this->template->display('ga/itemtrans/v_edit_in_trgd',$data);
	
	}
	
	function detail_itemtrans_in_trgd(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.4';
						$versirelease='I.G.D.4/ALPHA.001';
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
		
		$data['nik']=$nama;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$data['list_lk']=$this->m_akses->list_karyawan_index($nama)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nama)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param_inp=" and nodok='$nodok'";
		/* user akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		
		if($this->uri->segment(4)=="fail_input_mst_in_trgd")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Tidak Boleh Sama / Kode Barang Harus Beda </div>";
	    else
            $data['message']='';
		
		$data['title']=' DETAIL DATA ITEM TRANSFER ANTAR GUDANG ';
		$paramx=" and nodok='$nodok'";
		$data['list_master']=$this->m_itemtrans->q_trx_itemtrans_mst_param($paramx)->result();
		$data['list_detail']=$this->m_itemtrans->q_trx_itemtrans_dtl_param($paramx)->result();
		$data['trg_mst']=$this->m_itemtrans->q_trx_itemtrans_mst_param($paramx)->row_array();
		$trg_mst=$this->m_itemtrans->q_trx_itemtrans_mst_param($paramx)->row_array();
		$loccode=trim($trg_mst['loccode']);
		$data['list_scgroup']=$this->m_itemtrans->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_itemtrans->q_scsubgroup()->result();
		///$data['list_mstbarangatk']=$this->m_itemtrans->q_mstbarang_atk()->result();
		$param1=" and loccode='$loccode'";
		$data['list_stkgdw']=$this->m_itemtrans->q_stkgdw_param1($param1)->result();
		$data['desc_gudang']=$this->m_itemtrans->q_mstkantor()->result();
		
		$this->template->display('ga/itemtrans/v_detail_in_trgd',$data);
	
	}
	
	function batal_itemtrans_in_trgd(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.4';
						$versirelease='I.G.D.4/ALPHA.001';
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
		
		$data['nik']=$nama;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$data['list_lk']=$this->m_akses->list_karyawan_index($nama)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nama)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param_inp=" and nodoktmp='$nodok'";
		/* user akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		/*user hr end */
		$cek_inp=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param_inp)->num_rows();
		if ($cek_inp>0){
						$this->db->where('userid',$nama);
						$this->db->where('modul','ITEMTRANS');
						$this->db->delete('sc_mst.trxerror');
						$insinfo = array (
							'userid' => $nama,
							'errorcode' => 1,
							'modul' => 'ITEMTRANS'
						);
					$this->db->insert('sc_mst.trxerror',$insinfo);
				//////redirect("ga/itemtrans/edit_itemtrans_in_trgd/fail_input_dtl_in_trgd");
		} else if ($cek_inp==0) {
			$info_mst = array (
					
					'status' => 'C',
					'canceldate' => date('Y-m-d H:i:s'),
					'cancelby' => $nama);	 
			$this->db->where('nodok',$nodok);		
			$this->db->update('sc_trx.itemtrans_mst',$info_mst);
		}
		
		
		if($this->uri->segment(4)=="fail_input_mst_in_trgd")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Tidak Boleh Sama / Kode Barang Harus Beda </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_isidtl")
            $data['message']="<div class='alert alert-danger'> Detail Data Sudah Ada/Terisi data tidak Bisa Terupdate Kesalahan Data  </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_umm")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Harus Sama  Untuk Type Ajusment In Umum  </div>";
		else if($this->uri->segment(4)=="fail_input_dtl_in_trgd")
            $data['message']="<div class='alert alert-danger'> Input gagal detail qty tidak boleh 0 atau lebih kecil dari stock barang onhand / Kode Barang Sudah Tersedia</div>";
		else if($this->uri->segment(4)=="success_input_mst_in_trgd")
            $data['message']="<div class='alert alert-success'>Data Master Sudah Berhasil Di Update</div>";
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
		
		$data['title']=' UBAH DATA ITEM TRANSFER ANTAR GUDANG ';
		$paramx=" and nodok='$nama'";
		$data['list_master']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->result();
		$data['list_detail']=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->result();
		$data['trg_mst']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$trg_mst=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$loccode=trim($trg_mst['loccode']);
		$data['list_scgroup']=$this->m_itemtrans->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_itemtrans->q_scsubgroup()->result();
		///$data['list_mstbarangatk']=$this->m_itemtrans->q_mstbarang_atk()->result();
		$param1=" and loccode='$loccode'";
		$data['list_stkgdw']=$this->m_itemtrans->q_stkgdw_param1($param1)->result();
		$data['desc_gudang']=$this->m_itemtrans->q_mstkantor()->result();
		
		$this->template->display('ga/itemtrans/v_batal_in_trgd',$data);
	
	}
	
	function approv_itemtrans_in_trgd(){
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.4';
						$versirelease='I.G.D.4/ALPHA.001';
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
		
		$data['nik']=$nama;
		$data['enc_nodok']=bin2hex($this->encrypt->encode(trim($nama)));
		$data['list_lk']=$this->m_akses->list_karyawan_index($nama)->result();
		$data['dtlnik']=$this->m_akses->list_karyawan_index($nama)->row_array();
		
		$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
		$loccode=trim($dtlnik['kdcabang']);
		$param_inp=" and nodoktmp='$nodok'";
		/* user akses */
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		/*user hr end */
		$cek_inp=$this->m_itemtrans->q_tmp_itemtrans_mst_param($param_inp)->num_rows();
		if ($cek_inp>0){
						$this->db->where('userid',$nama);
						$this->db->where('modul','ITEMTRANS');
						$this->db->delete('sc_mst.trxerror');
						$insinfo = array (
							'userid' => $nama,
							'errorcode' => 1,
							'modul' => 'ITEMTRANS'
						);
					$this->db->insert('sc_mst.trxerror',$insinfo);
				//////redirect("ga/itemtrans/edit_itemtrans_in_trgd/fail_input_dtl_in_trgd");
		} else if ($cek_inp==0) {
			$info_mst = array (
					
					'status' => 'A1',
					'approvaldate' => date('Y-m-d H:i:s'),
					'approvalby' => $nama);	 
			$this->db->where('nodok',$nodok);		
			$this->db->update('sc_trx.itemtrans_mst',$info_mst);
		}
		
		
		if($this->uri->segment(4)=="fail_input_mst_in_trgd")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Tidak Boleh Sama / Kode Barang Harus Beda </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_isidtl")
            $data['message']="<div class='alert alert-danger'> Detail Data Sudah Ada/Terisi data tidak Bisa Terupdate Kesalahan Data  </div>";
		else if($this->uri->segment(4)=="fail_input_mst_in_umm")
            $data['message']="<div class='alert alert-danger'> Kode Gudang Harus Sama  Untuk Type Ajusment In Umum  </div>";
		else if($this->uri->segment(4)=="fail_input_dtl_in_trgd")
            $data['message']="<div class='alert alert-danger'> Input gagal detail qty tidak boleh 0 atau lebih kecil dari stock barang onhand / Kode Barang Sudah Tersedia</div>";
		else if($this->uri->segment(4)=="success_input_mst_in_trgd")
            $data['message']="<div class='alert alert-success'>Data Master Sudah Berhasil Di Update</div>";
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
		
		$data['title']=' UBAH DATA ITEM TRANSFER ANTAR GUDANG ';
		$paramx=" and nodok='$nama'";
		$data['list_master']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->result();
		$data['list_detail']=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->result();
		$data['trg_mst']=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$trg_mst=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$loccode=trim($trg_mst['loccode']);
		$data['list_scgroup']=$this->m_itemtrans->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_itemtrans->q_scsubgroup()->result();
		///$data['list_mstbarangatk']=$this->m_itemtrans->q_mstbarang_atk()->result();
		$param1=" and loccode='$loccode'";
		$data['list_stkgdw']=$this->m_itemtrans->q_stkgdw_param1($param1)->result();
		$data['desc_gudang']=$this->m_itemtrans->q_mstkantor()->result();
		
		$this->template->display('ga/itemtrans/v_approv_in_trgd',$data);
	
	}
	
	function save_itemtrans(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));


		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$nodoktmp=strtoupper(trim($this->input->post('nodoktmp')));
		
		$loccode=strtoupper(trim($this->input->post('loccode')));
		$loccode_destination=strtoupper(trim($this->input->post('loccode_destination')));
		$itemtrans_type=strtoupper(trim($this->input->post('itemtrans_type')));
		$itemtrans_category=strtoupper(trim($this->input->post('itemtrans_category')));
		if (!empty($this->input->post('nodok_date'))) { $nodok_date=date('d-m-Y', strtotime(trim($this->input->post('nodok_date')))); } else { $nodok_date=null; }
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		$stockcode=strtoupper(trim($this->input->post('stockcode')));
		$satkecil=strtoupper(trim($this->input->post('satkecil')));
		$qty=strtoupper(trim($this->input->post('qty')));
		$qtyonhand=strtoupper(trim($this->input->post('qtyonhand')));
		

		$description=strtoupper(trim($this->input->post('description')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		
		if ($type=='EDINPUT_IN_TRGD'){
			$paramx=" and nodok='$nama'";
			$cek_dtl=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->num_rows();
			if (($loccode==$loccode_destination and $itemtrans_category=='TRG') OR ($loccode!=$loccode_destination and $itemtrans_category=='UMM') OR $cek_dtl>0){
							$this->db->where('userid',$nama);
							$this->db->where('modul','AJST_IN_TRGD');
							$this->db->delete('sc_mst.trxerror');
							$insinfo = array (
								'userid' => $nama,
								'errorcode' => 1,
								'modul' => 'AJST_IN_TRGD'
							);
						$this->db->insert('sc_mst.trxerror',$insinfo);
				if ( $cek_dtl>0 ) {
				redirect("ga/itemtrans/input_itemtrans_in_trgd/fail_input_mst_in_isidtl");	
				} else if ( $itemtrans_category=='TRG' ) {
				redirect("ga/itemtrans/input_itemtrans_in_trgd/fail_input_mst_in_trgd");
				} else if ( $itemtrans_category=='UMM' ) {
				redirect("ga/itemtrans/input_itemtrans_in_trgd/fail_input_mst_in_umm");	
				}
						
			} else {
				$info = array (
							'nodokref           ' => $nodokref           ,
							'loccode            ' => $loccode            ,
							'loccode_destination' => $loccode_destination,
							'description        ' => $description        ,
							'nodok_date     	' => $nodok_date     ,
				);	
						$this->db->where('nodok',$nama);
						$this->db->update('sc_tmp.itemtrans_mst',$info);
						redirect("ga/itemtrans/input_itemtrans_in_trgd/success_input_mst_in_trgd");
			
						
			}
		} else if ($type=='INPUT_IN_TRGD_DTL'){
			$paramx=" and nodok='$nama' and kdgroup='$kdgroup'  and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode'";
			$cek_dtl=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->num_rows();
			if ($qty<=0 or $cek_dtl>0 or $qtyonhand<$qty ){
							$this->db->where('userid',$nama);
							$this->db->where('modul','ITEMTRANS');
							$this->db->delete('sc_mst.trxerror');
							$insinfo = array (
								'userid' => $nama,
								'errorcode' => 1,
								'modul' => 'ITEMTRANS'
							);
						$this->db->insert('sc_mst.trxerror',$insinfo);
						redirect("ga/itemtrans/input_itemtrans_in_trgd/fail_input_dtl_in_trgd");
			} else {
				$info = array (
							'branch           ' => $branch           		 ,
							'nodok           ' => $nama           		 ,
							'nodokref           ' => $nodokref           ,
							'kdgroup           ' => $kdgroup           	 ,
							'kdsubgroup           ' => $kdsubgroup       ,
							'stockcode           ' => $stockcode         ,
							'loccode            ' => $loccode            ,
							'loccode_destination' => $loccode_destination,
							'itemtrans_type     ' => $itemtrans_type     ,
							'itemtrans_category ' => $itemtrans_category ,
							'qty				' => $qty 			     ,
							'qtyonhand 			' => $qtyonhand 		 ,
							'satkecil        ' => $satkecil        ,
							'status        ' => 'I'        ,
							'description        ' => $description        ,
							'inputby        ' => $inputby        ,
							'inputdate        ' => $inputdate        ,
				);	
						$this->db->insert('sc_tmp.itemtrans_dtl',$info);
						redirect("ga/itemtrans/input_itemtrans_in_trgd/success_input_mst_in_trgd");
			
						
			}
		}  else if ($type=='EDIT_IN_TRGD_DTL'){  /* INPUT DETAIL AJUSTMENT */
			$paramx=" and nodok='$nama' and kdgroup='$kdgroup'  and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode'";
			$cek_dtl=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->num_rows();
			if ($qty<=0 or $qtyonhand<$qty ){
							$this->db->where('userid',$nama);
							$this->db->where('modul','ITEMTRANS');
							$this->db->delete('sc_mst.trxerror');
							$insinfo = array (
								'userid' => $nama,
								'errorcode' => 1,
								'modul' => 'ITEMTRANS'
							);
						$this->db->insert('sc_mst.trxerror',$insinfo);
						redirect("ga/itemtrans/input_itemtrans_in_trgd/fail_input_dtl_in_trgd");
			} else {
				$info = array (

							'qty				' => $qty 			     ,
							'status        ' => 'I'        ,
							'description        ' => $description        ,

				);	
						$this->db->where('nodok',$nama);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->update('sc_tmp.itemtrans_dtl',$info);
						redirect("ga/itemtrans/input_itemtrans_in_trgd/success_input_mst_in_trgd");
			
						
			}
		}  else if ($type=='EDIT_QTY_EDIT_IN_TRGD_DTL'){  /* EDIT QTY DETAIL */
			$paramx=" and nodok='$nama' and kdgroup='$kdgroup'  and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode'";
			$cek_dtl=$this->m_itemtrans->q_tmp_itemtrans_dtl_param($paramx)->num_rows();
			if ($qty<=0 or $qtyonhand<$qty ){
							$this->db->where('userid',$nama);
							$this->db->where('modul','ITEMTRANS');
							$this->db->delete('sc_mst.trxerror');
							$insinfo = array (
								'userid' => $nama,
								'errorcode' => 1,
								'modul' => 'ITEMTRANS'
							);
						$this->db->insert('sc_mst.trxerror',$insinfo);
						redirect("ga/itemtrans/form_itemtrans_in_trgd");
			} else {
				$info = array (

							'qty				' => $qty 			     ,
							'description        ' => $description        ,

				);	
						$this->db->where('nodok',$nama);
						$this->db->where('kdgroup',$kdgroup);
						$this->db->where('kdsubgroup',$kdsubgroup);
						$this->db->where('stockcode',$stockcode);
						$this->db->update('sc_tmp.itemtrans_dtl',$info);
						redirect("ga/itemtrans/form_itemtrans_in_trgd");
			
						
			}
		} else if ($type=='DEL_IN_TRGD_DTL'){  /* DELETE DETAIL AJUSTMENT */
				$this->db->where('nodok',$nama);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->where('stockcode',$stockcode);
				$this->db->delete('sc_tmp.itemtrans_dtl');
				redirect("ga/itemtrans/input_itemtrans_in_trgd/success_input_mst_in_trgd");
				
		} else {
				redirect("ga/itemtrans/input_itemtrans_in_trgd");
		}
	}

	function final_input_itemtrans_in(){
		$nama=$this->session->userdata('nik');	
		$paramx=" and nodok='$nama'";	
		$dtl_mst=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
		$status=trim($dtl_mst['status']);
		/* clearing temporary  */
		if ($status=='I') {
			$info = array (
					'status' => 'F',
			);
			$this->db->where('nodok',$nama);
			$this->db->update('sc_tmp.itemtrans_mst',$info);				
			redirect("ga/itemtrans/form_itemtrans_in_trgd/input_succes");
			
		} else if ($status=='E') {
			$info = array (
					'status' => 'F',
			);
			$this->db->where('nodok',$nama);
			$this->db->update('sc_tmp.itemtrans_mst',$info);				
			redirect("ga/itemtrans/form_itemtrans_in_trgd/edit_succes");
		} else if ($status=='C') {
			$info = array (
					'status' => 'F',
			);
			$this->db->where('nodok',$nama);
			$this->db->update('sc_tmp.itemtrans_mst',$info);				
			redirect("ga/itemtrans/form_itemtrans_in_trgd/batal_succes");
		}  else if ($status=='A') {
			$info = array (
					'status' => 'F',
			);
			$this->db->where('nodok',$nama);
			$this->db->update('sc_tmp.itemtrans_mst',$info);				
			redirect("ga/itemtrans/form_itemtrans_in_trgd/approval_succes");
		}

	}

	function clear_tmp_itemtrans_in(){
			$nama=$this->session->userdata('nik');	
			$paramx=" and nodok='$nama'";	
			$dtl_mst=$this->m_itemtrans->q_tmp_itemtrans_mst_param($paramx)->row_array();
			$status=trim($dtl_mst['status']);
			$nodoktmp=trim($dtl_mst['nodoktmp']);
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
				$this->db->update('sc_trx.itemtrans_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.itemtrans_dtl',$infodtl);				
				
			} else if ($status=='C') {
				$info = array (
						'status' => 'A',
						'canceldate' => null,
						'cancelby' => null,										
				);
				$infodtl = array (
						'status' => 'A',								
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.itemtrans_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.itemtrans_dtl',$infodtl);				
				
			}  else if ($status=='A') {
				$info = array (
						'status' => 'A',
						'approvaldate' => null,
						'approvalby' => null,										
				);
				$infodtl = array (
						'status' => 'A',								
				);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.itemtrans_mst',$info);
				$this->db->where('nodok',$nodoktmp);
				$this->db->update('sc_trx.itemtrans_dtl',$infodtl);				
				
			}
			
			/* clearing temporary  */
			$this->db->where('nodok',$nama);
			$this->db->delete('sc_tmp.itemtrans_mst');
			$this->db->where('nodok',$nama);
			$this->db->delete('sc_tmp.itemtrans_dtl');
				
		redirect("ga/itemtrans/form_itemtrans_in_trgd/clear_succes");
	}
	
}