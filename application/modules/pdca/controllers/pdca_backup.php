<?php
/*
	@author : fiky
	13-12-2017
*/
//error_reporting(0)
class Pdca extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('master/m_akses','m_pdca'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU PDCA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('pdca/pdca/v_index',$data);
	}
	function underconstruction(){
			$data['title']="!!!!! WARNING ......... !!  UNDER CONSTRUCTION";	
			$this->template->display('pdca/pdca/v_index',$data);
	}

	function form_pdca(){
		$data['title']="PLAN DO CHECK ACTION";	
		$nama=trim($this->session->userdata('nik'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.C.I.1';
						$versirelease='I.C.I.1/ALPHA.001';
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
						

        $data['message']='';
		
				/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and docno='$nama' and status='I'";
		$param3_1_2=" and docno='$nama' and status='E'";
		$param3_1_3=" and docno='$nama' and status in ('A','AP')";
		$param3_1_4=" and docno='$nama' and status='C'";
		$param3_1_5=" and docno='$nama' and status='H'";
		$param3_1_6=" and docno='$nama' and status='R'";
		$param3_1_7=" and docno='$nama' and status='O'";
		$param3_1_R=" and docno='$nama'";
			$cekmst_na=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_1)->num_rows(); //input
			$cekmst_ne=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_2)->num_rows(); //edit
			$cekmst_napp=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_7)->num_rows(); //approv
			$cekmst_cancel=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_4)->num_rows(); //cancel
			$cekmst_hangus=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_5)->num_rows(); //hangus
			$cekmst_ra=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_6)->num_rows(); //REALISASI
			$cekmst_ch=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_7)->num_rows(); //REALISASI
			$dtledit=$this->m_pdca->q_tmp_pdca_mst_param($param3_1_R)->row_array(); //edit row array

			$enc_nama=bin2hex($this->encrypt->encode($nama));
			$data['enc_nama']=bin2hex($this->encrypt->encode($nama));
			if ($cekmst_na>0) { //cek inputan
					$enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
					$enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
					redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
			} else if ($cekmst_ne>0){	//cek edit
					$enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
					$enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
					$enc_docdate=bin2hex($this->encrypt->encode(trim($dtledit['docdate'])));
					redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
			}  else if ($cekmst_napp>0){	//cek APPROV
					$enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
					$enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
					$enc_docdate=bin2hex($this->encrypt->encode(trim($dtledit['docdate'])));
					redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
			}  else if ($cekmst_ra>0){	//cek REALISASI
					$enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
					$enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
					$enc_docdate=bin2hex($this->encrypt->encode(trim($dtledit['docdate'])));
					redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
			}
		
		
		
		$param="";				
		///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
		$data['list_pdca']=$this->m_pdca->q_view_periode_nik_pdca($param)->result();
		$this->template->display('pdca/pdca/v_list_pdca',$data);
	}
	
	
	function list_personal_karyawan(){
		$inputfill=strtoupper(trim($this->input->post('inputfill')));
		if(empty($inputfill)){
			redirect('pdca/pdca/form_pdca');
		}
		/* if($inputfill=='BRK'){
			redirect('pdca/pdca/underconstruction');
		} */
		
		
		$data['title']='DATA KARYAWAN UNTUK INPUT PDCA';
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
		$data['inputfill']=$inputfill;
		/* END APPROVE ATASAN */


		$data['list_nikpbk']=$this->m_akses->list_karyawan_param($param_list_akses)->result();
		$this->template->display('pdca/pdca/v_list_personal_karyawan',$data);
	}
	
	function input_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and docno='$nama'";
		$cek_tmp=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc)->num_rows();
		$dtl_pdca=$this->m_pdca->q_tmp_pdca_dtl_param($param_cek_1doc)->row_array();
		if(isset($dtl_pdca['docno'])){ $nodok=$dtl_pdca['docno'];} else { $nodok='' ;}
		if ($cek_tmp==0 and !empty($nik)) {
			if($cek_tmp>0) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca");
			} else {
				$this->m_pdca->insert_master_pdca($nik,$doctype);						
				/* error handling */
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
			}
		} else if ($cek_tmp>0 and !empty($nodok)) {
			$paramcekrev=" AND nik='$nik'";
			$dtl_tmp=$this->m_pdca->q_tmp_pdca_dtl_param($paramcekrev)->row_array();
			if (isset($dtl_tmp['docno'])){ $nodok_isset=trim($dtl_tmp['docno']); } else { $nodok_isset='';	} 
				
			if ($nodok_isset<>trim($nama)) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				
				redirect("pdca/pdca/form_pdca");
			}
		}
		$paramerror=" and userid='$nama' and modul='PDCA'";	
		$dtlerror=$this->m_pdca->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_pdca->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['errorcode']==0){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}
			
		}else {
			if ($errorcode=='0'){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="";
			}
			
		}	
		$data['title']=' INPUT FORM PDCA ';
		$paramlist=" and docno='$nama'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_input_pdca_tmp',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	
	function edit_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$docdate=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and docno='$nama'";
		$param_cek_his=" and doctype='$doctype' and docdate='$docdate' and nik='$nik' and status in ('P','D','C')";
		$cek_tmp=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc)->num_rows();
		$cek_his=$this->m_pdca->q_his_pdca_mst_param($param_cek_his)->num_rows();
		
		
		$dtl_pdca=$this->m_pdca->q_tmp_pdca_dtl_param($param_cek_1doc)->row_array();
		if(isset($dtl_pdca['docno'])){ $nodok=$dtl_pdca['docno'];} else { $nodok='' ;}
		if (($cek_tmp==0 and !empty($nik)) OR $cek_his>0) {
			if($cek_tmp>0) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca");
			} else {
				$this->db->where('nik',$nik);
				$this->db->where('doctype',$doctype);
				$this->db->where('docdate',$docdate);
				$infoedit = array (
					'status' => 'E',
					'updatedate' => date('Y-m-d H:i:s'),
					'updateby' => $nama,	
				);
				$this->db->update('sc_his.pdca_mst',$infoedit);

				
				/* error handling */
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
			}
		} else if ($cek_tmp>0 and !empty($nodok)) {
			$paramcekrev=" AND nik='$nik'";
			$dtl_tmp=$this->m_pdca->q_tmp_pdca_dtl_param($paramcekrev)->row_array();
			if (isset($dtl_tmp['docno'])){ $nodok_isset=trim($dtl_tmp['docno']); } else { $nodok_isset='';	} 
				
			if ($nodok_isset<>trim($nama)) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				
				redirect("pdca/pdca/form_pdca");
			}
		}
		$paramerror=" and userid='$nama' and modul='PDCA'";	
		$dtlerror=$this->m_pdca->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_pdca->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['errorcode']==0){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}
			
		}else {
			if ($errorcode=='0'){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="";
			}
			
		}	
		$data['title']=' UBAH DATA FORM PDCA ';
		$paramlist=" and docno='$nama'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_edit_pdca_tmp',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function realisasi_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$docdate=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and docno='$nama'";
		$param_cek_his=" and doctype='$doctype' and docdate='$docdate' and nik='$nik' and status in ('P','D','C')";
		$cek_tmp=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc)->num_rows();
		$cek_his=$this->m_pdca->q_his_pdca_mst_param($param_cek_his)->num_rows();
		
		
		$dtl_pdca=$this->m_pdca->q_tmp_pdca_dtl_param($param_cek_1doc)->row_array();
		if(isset($dtl_pdca['docno'])){ $nodok=$dtl_pdca['docno'];} else { $nodok='' ;}
		if (($cek_tmp==0 and !empty($nik)) OR $cek_his>0) {
			if($cek_tmp>0) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca");
			} else {
				$this->db->where('nik',$nik);
				$this->db->where('doctype',$doctype);
				$this->db->where('docdate',$docdate);
				$infoedit = array (
					'status' => 'R',
					'realisasidate' => date('Y-m-d H:i:s'),
					'realisasiby' => $nama,	
				);
				$this->db->update('sc_his.pdca_mst',$infoedit);

				
				/* error handling */
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
			}
		} else if ($cek_tmp>0 and !empty($nodok)) {
			$paramcekrev=" AND nik='$nik'";
			$dtl_tmp=$this->m_pdca->q_tmp_pdca_dtl_param($paramcekrev)->row_array();
			if (isset($dtl_tmp['docno'])){ $nodok_isset=trim($dtl_tmp['docno']); } else { $nodok_isset='';	} 
				
			if ($nodok_isset<>trim($nama)) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				
				redirect("pdca/pdca/form_pdca");
			}
		}
		$paramerror=" and userid='$nama' and modul='PDCA'";	
		$dtlerror=$this->m_pdca->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_pdca->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['errorcode']==0){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}
			
		}else {
			if ($errorcode=='0'){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="";
			}
			
		}	
		$data['title']=' UBAH DATA FORM PDCA ';
		$paramlist=" and docno='$nama'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_realisasi_pdca_tmp',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function approv_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$docdate=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and docno='$nama'";
		$param_cek_his=" and doctype='$doctype' and docdate='$docdate' and nik='$nik' and status in ('P','D','C')";
		$cek_tmp=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc)->num_rows();
		$cek_his=$this->m_pdca->q_his_pdca_mst_param($param_cek_his)->num_rows();
		
		
		$dtl_pdca=$this->m_pdca->q_tmp_pdca_dtl_param($param_cek_1doc)->row_array();
		if(isset($dtl_pdca['docno'])){ $nodok=$dtl_pdca['docno'];} else { $nodok='' ;}
		if (($cek_tmp==0 and !empty($nik)) OR $cek_his>0) {
			if($cek_tmp>0) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca");
			} else {
				$this->db->where('nik',$nik);
				$this->db->where('doctype',$doctype);
				$this->db->where('docdate',$docdate);
				$infoedit = array (
					'status' => 'A1',
					'approvdate' => date('Y-m-d H:i:s'),
					'approvby' => $nama,	
				);
				$this->db->update('sc_his.pdca_mst',$infoedit);

				
				/* error handling */
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
			}
		} else if ($cek_tmp>0 and !empty($nodok)) {
			$paramcekrev=" AND nik='$nik'";
			$dtl_tmp=$this->m_pdca->q_tmp_pdca_dtl_param($paramcekrev)->row_array();
			if (isset($dtl_tmp['docno'])){ $nodok_isset=trim($dtl_tmp['docno']); } else { $nodok_isset='';	} 
				
			if ($nodok_isset<>trim($nama)) {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 1,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				
				redirect("pdca/pdca/form_pdca");
			}
		}
		$paramerror=" and userid='$nama' and modul='PDCA'";	
		$dtlerror=$this->m_pdca->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_pdca->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['errorcode']==0){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}
			
		}else {
			if ($errorcode=='0'){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="";
			}
			
		}		
		$data['title']=' UBAH DATA FORM PDCA ';
		$paramlist=" and docno='$nama'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_approv_pdca_tmp',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function detail_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$docdate=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));

		$data['title']=' DETAIL DATA FORM PDCA ';
		$paramlist=" and nik='$nik' and doctype='$doctype'  and docdate='$docdate'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_his_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_detail_pdca_tmp',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function save_pdca(){
		$nama=trim($this->session->userdata('nik'));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nik=strtoupper(trim($this->input->post('nik')));
		/* entitas master*/
		$docdate_1=$this->input->post('docdate');
		if ($docdate_1!='') { $docdate = date('Y-m-d', strtotime(trim($docdate_1))); } else { $docdate = ''; } 
		
		///$docdate=date('Y-m-d', strtotime(trim($this->input->post('docdate'))));
		$docdaterange=explode(' - ',$this->input->post('docdaterange'));
		$tglawal=$docdaterange[0];
		$tglakhir=$docdaterange[1];
		$docref=strtoupper($this->input->post('docref'));
		$doctype=strtoupper(trim($this->input->post('doctype')));
		$docpage=strtoupper($this->input->post('docpage'));
		$revision=strtoupper($this->input->post('revision'));
		$global_desc=strtoupper($this->input->post('global_desc'));
		$planperiod=strtoupper($this->input->post('planperiod'));
		$ttlpercent=strtoupper($this->input->post('ttlpercent'));
		$ttlplan=strtoupper($this->input->post('ttlplan'));
		$avgvalue=strtoupper($this->input->post('avgvalue'));
		/* entitas detail*/       
		$docno=strtoupper($this->input->post('docno'));
		$nomor=strtoupper($this->input->post('nomor'));
		$descplan=strtoupper($this->input->post('descplan'));
		$idbu=strtoupper($this->input->post('idbu'));
		$qtytime=strtoupper($this->input->post('qtytime'));
		$do_c=strtoupper($this->input->post('do_c'));
		$percentage_1=$this->input->post('percentage');
		if ($percentage_1!='') { $percentage =$percentage_1; } else { $percentage = 0; } 
		
		$remark=strtoupper($this->input->post('remark'));
		
		
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_doctype=bin2hex($this->encrypt->encode($doctype));
		$enc_docdate=bin2hex($this->encrypt->encode($docdate));

		
		if ($type=='INPUT_MST_PDCA_ISL'){
			$parameter=" and nik='$nik' and docdate='$docdate' and doctype='$doctype'";
			echo $parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			if ($dtltrx>0){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 11,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
				
			} else {
				if (trim($dtlarray['lvl_jabatan'])=='C'){  $docdate=date('Y-m-d', strtotime(trim($tglakhir))); }
				$info_dtl = array (
						'docdate' => $docdate,
						'tglawal' => date('Y-m-d', strtotime(trim($tglawal))),
						'tglakhir' => date('Y-m-d', strtotime(trim($tglakhir))),
						'status' => '',
						'global_desc' => $global_desc	
				);
				$this->db->where('docno',$nama);
				$this->db->update('sc_tmp.pdca_mst',$info_dtl);	
			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
			}
		} else if ($type=='INPUT_DTL_PDCA_ISL') {
			$parameter=" and nik='$nik' and docdate is null and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			if ($dtltrx>0 or (empty($docdate))){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 11,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
				
			} else { $info = array (
						'nik' 		=> $nik,
						'docno'		=> $docno,
						'nomor' 	=> 0,
						'doctype' 	=> $doctype,
						'docref' 	=> $docref,
						'docdate' 	=> $docdate,
						'docpage' 	=> $docpage,
						'revision' 	=> $revision,
						'planperiod'=> $planperiod,
						'descplan' => $descplan,
						'idbu' 		=> $idbu,
						'qtytime' 	=> $qtytime,
						'do_c' 		=> $do_c,
						'percentage'=> $percentage,
						'remark' 	=> $remark,
						'status' 	=> 'I',
						'inputdate' => $inputdate,
						'inputby' 	=> $inputby,		
				);
				
				$this->db->insert('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
			}
		}  else if ($type=='EDIT_DTL_PDCA_ISL') {
			$info = array (

						'descplan' => $descplan,
						'idbu' 		=> $idbu,
						'qtytime' 	=> $qtytime,
						'do_c' 		=> $do_c,
						'percentage'=> $percentage,
						'remark' 	=> $remark,
						'status' 	=> '',
						'inputdate' => $inputdate,
						'inputby' 	=> $inputby,		
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
		} else if ($type=='DEL_DTL_PDCA_ISL') {

				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->delete('sc_tmp.pdca_dtl');
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
		} else if ($type=='EDIT_MST_PDCA_ISL'){		////////////////                     EDIT__PDCA_ISL
			$parameter=" and nik='$nik' and docdate='$docdate' and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			if ($dtltrx>0){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 11,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
				
			} else {
				$info_dtl = array (
						/////'docdate' => $docdate,
						'status' => '',
						'global_desc' => $global_desc	
				);
				$this->db->where('docno',$nama);
				$this->db->update('sc_tmp.pdca_mst',$info_dtl);	
			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
			}
		}  else if ($type=='EDITINP_DTL_PDCA_ISL') {
			$parameter=" and nik='$nik' and docdate is null and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			if ($dtltrx>0 or (empty($docdate))){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 11,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
				
			} else { $info = array (
						'nik' 		=> $nik,
						'docno'		=> $docno,
						'nomor' 	=> 0,
						'doctype' 	=> $doctype,
						'docref' 	=> $docref,
						'docdate' 	=> $docdate,
						'docpage' 	=> $docpage,
						'revision' 	=> $revision,
						'planperiod'=> $planperiod,
						'descplan' => $descplan,
						'idbu' 		=> $idbu,
						'qtytime' 	=> $qtytime,
						'do_c' 		=> $do_c,
						'percentage'=> $percentage,
						'remark' 	=> $remark,
						'status' 	=> 'E',
						'inputdate' => $inputdate,
						'inputby' 	=> $inputby,		
				);
				
				$this->db->insert('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
			}
		} else if ($type=='EDIT_2EDIT_DTL_PDCA_ISL') {
			$info = array (

						'descplan' => $descplan,
						'idbu' 		=> $idbu,
						'qtytime' 	=> $qtytime,
						'do_c' 		=> $do_c,
						'percentage'=> $percentage,
						'remark' 	=> $remark,
						'status' 	=> '',
						'updatedate' => $inputdate,
						'updateby' 	=> $inputby,		
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='DEL_2EDIT_DTL_PDCA_ISL') {

				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->delete('sc_tmp.pdca_dtl');
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='REJECT_APPROV_DTL_PDCA_ISL') {
			$info = array (
						'status' 	=> 'B',
						'percentage'=> $percentage,
						'remark' 	=> $remark,
						'canceldate' => $inputdate,
						'cancelby' 	=> $inputby,		
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='PROSES_APPROV_DTL_PDCA_ISL') {
			$info = array (
						'status' 	=> 'O',
						'remark' 	=> $remark,
						'percentage'=> $percentage,
						'approvdate' => $inputdate,
						'approvby' 	=> $inputby,		
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='RESET_APPROV_DTL_PDCA_ISL') {
			$info = array (
						'remark' 	=> '',
						'status' 	=> 'R',
						'approvdate' => NULL,
						'approvby' 	=> '',
						'canceldate' => NULL,
						'cancelby' 	=> ''						
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='REALISASI_MST_PDCA_ISL'){		////////////////                     REALISASI PDCA
			$parameter=" and nik='$nik' and docdate='$docdate' and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			if ($dtltrx>0){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 11,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
				
			} else {
				$info_dtl = array (
						/////'docdate' => $docdate,
						'status' => '',
						'global_desc' => $global_desc	
				);
				$this->db->where('docno',$nama);
				$this->db->update('sc_tmp.pdca_mst',$info_dtl);	
			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
			}
		} else if ($type=='REALISASI_2EDIT_DTL_PDCA_ISL') {
			$info = array (

						//'descplan' => $descplan,
						//'idbu' 		=> $idbu,
						//'qtytime' 	=> $qtytime,
						'do_c' 		=> $do_c,
						'percentage'=> $percentage,
						'remark' 	=> $remark,
						'status' 	=> '',
						'realisasidate' => $inputdate,
						'realisasiby' 	=> $inputby,		
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else {
			redirect("pdca/pdca/form_pdca");
		}
	}
		
	function clear_tmp_pdca(){
		echo $nama=trim($this->session->userdata('nik'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$paramlist=" and docno='$nama'";
		$dtl=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		/// $dtl['nik'];	/// $dtl['docdate'];		/// $dtl['doctype'];
		
		if(trim($dtl['status'])=='E'){
				$info = array (
				'status' => 'A',
				'updatedate' => null,
				'updateby' 	=> '',		
				);
				$this->db->where('nik',trim($dtl['nik']));
				$this->db->where('docdate',trim($dtl['docdate']));
				$this->db->where('doctype',trim($dtl['doctype']));			
				$this->db->update('sc_his.pdca_mst',$info);
		} else if(trim($dtl['status'])=='R'){
				$info = array (
				'status' => 'A',
				'realisasidate' => null,
				'realisasiby' 	=> '',		
				);
				$this->db->where('nik',trim($dtl['nik']));
				$this->db->where('docdate',trim($dtl['docdate']));
				$this->db->where('doctype',trim($dtl['doctype']));			
				$this->db->update('sc_his.pdca_mst',$info);
		} else if(trim($dtl['status'])=='O'){
				$info = array (
				'status' => 'R',
				'realisasidate' => null,
				'realisasiby' 	=> '',		
				);
				$this->db->where('nik',trim($dtl['nik']));
				$this->db->where('docdate',trim($dtl['docdate']));
				$this->db->where('doctype',trim($dtl['doctype']));			
				$this->db->update('sc_his.pdca_mst',$info);
		} else if (($dtl['status'])=='A'){
				$info = array (
				'approvdate' => null,
				'approvby' 	=> '',		
				);
				$this->db->where('nik',trim($dtl['nik']));
				$this->db->where('docdate',trim($dtl['docdate']));
				$this->db->where('doctype',trim($dtl['doctype']));			
				$this->db->update('sc_his.pdca_mst',$info);
		}

		
		$this->db->where('docno',$nama);
		$this->db->delete('sc_tmp.pdca_mst');
		
		$this->db->where('docno',$nama);
		$this->db->delete('sc_tmp.pdca_dtl');
        
		redirect("pdca/pdca/form_pdca");
	}
	function reset_dtl_tmp_pdca(){
		$nama=$this->session->userdata('nik');
		$paramlist=" and docno='$nama'";
		$dtl=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		
		$enc_nik=bin2hex($this->encrypt->encode(trim($dtl['nik'])));
		$enc_doctype=bin2hex($this->encrypt->encode(trim($dtl['doctype'])));
		
		$this->db->where('docno',$nama);
		$this->db->delete('sc_tmp.pdca_dtl');
		redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
	}
	
	function final_input_pdca(){
		$nama=trim($this->session->userdata('nik'));
		$paramlist=" and docno='$nama'";
		$paramlist_2=" and docno='$nama' and status in ('R','A')";
		$dtlmst=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		$dtldtl=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->num_rows();
		$numrealisasi=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist_2)->num_rows();
		$status_master=trim($dtlmst['status']);
		
		$enc_nik=bin2hex($this->encrypt->encode(trim($dtlmst['nik'])));
		$enc_doctype=bin2hex($this->encrypt->encode(trim($dtlmst['doctype'])));
		$enc_docdate=bin2hex($this->encrypt->encode(trim($dtlmst['docdate'])));
		$enc_planperiod=bin2hex($this->encrypt->encode(trim($dtlmst['planperiod'])));
		
		if(empty($dtlmst['docdate']) or $dtldtl==0 and ($status_master=='I')){
								$this->db->where('userid',$nama);
								$this->db->where('modul','PDCA');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 13,
									'nomorakhir1' => '',
									'nomorakhir2' => '',
									'modul' => 'PDCA',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);
			
			redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
		} else if(empty($dtlmst['docdate']) or $dtldtl==0 and ($status_master=='E')){
								$this->db->where('userid',$nama);
								$this->db->where('modul','PDCA');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 13,
									'nomorakhir1' => '',
									'nomorakhir2' => '',
									'modul' => 'PDCA',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);
			
			redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if($numrealisasi>0 and ($status_master=='A')){		/* APPROV FINAL*/
								$this->db->where('userid',$nama);
								$this->db->where('modul','PDCA');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 14,
									'nomorakhir1' => '',
									'nomorakhir2' => '',
									'modul' => 'PDCA',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);	
			redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if($numrealisasi<=0 and ($status_master=='R')){		/* REALISASI FINAL*/
								$this->db->where('userid',$nama);
								$this->db->where('modul','PDCA');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 15,
									'nomorakhir1' => '',
									'nomorakhir2' => '',
									'modul' => 'PDCA',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);	
			redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if($numrealisasi>0 and ($status_master=='O')){		/* REALISASI FINAL*/
								$this->db->where('userid',$nama);
								$this->db->where('modul','PDCA');
								$this->db->delete('sc_mst.trxerror');
								
								$infotrxerror = array (
									'userid' => $nama,
									'errorcode' => 16,
									'nomorakhir1' => '',
									'nomorakhir2' => '',
									'modul' => 'PDCA',
								);
								$this->db->insert('sc_mst.trxerror',$infotrxerror);	
			redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else {
			
			$info = array (
					'status' => 'F',
			);
			$this->db->where('docno',$nama);
			$this->db->update('sc_tmp.pdca_mst',$info);
								
			//redirect("pdca/pdca/form_pdca");
			redirect("pdca/pdca/form_view_pdca_sub_detail/$enc_nik/$enc_doctype/$enc_planperiod");
		}
	}
	
	function form_view_pdca_sub_detail(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$data['title']="PLAN DO CHECK ACTION";	
		$nama=$this->session->userdata('nik');
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.C.I.1';
						$versirelease='I.C.I.1/ALPHA.001';
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
						

        $data['message']='';
		$param=" and nik='$nik' and doctype='$doctype' and planperiod='$planperiod'";				
		$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
		////$data['list_pdca']=$this->m_pdca->q_view_periode_nik_pdca($param)->result();
		$this->template->display('pdca/pdca/v_list_pdca_sub_detail',$data);
	}
	
	function form_log_pdca(){
		$data['title']=' DETAIL PERUBAHAN DATA KESELURUHAN DATA PDCA ';
		$paramlist='';
		$data['list_pdca_log_dtl_activity']=$this->m_pdca->pdca_log_dtl_activity($paramlist)->result();
		$this->template->display('pdca/pdca/v_pdca_log_detail',$data);
	}
	
	function sti_pdca_isidentil(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$enc_nik=(trim($this->uri->segment(4)));
		$enc_doctype=(trim($this->uri->segment(5)));
		$enc_planperiod=(trim($this->uri->segment(6)));
		$data['jsonfile'] = "pdca/pdca/json_pdca_isidentil/$enc_nik/$enc_doctype/$enc_planperiod";
		$data['report_file'] = 'assets/mrt/sti_pdca_isidentil.mrt';
		$this->load->view("pdca/pdca/sti_v",$data);
	}
	function json_pdca_isidentil(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod'";
		$paramlist_2=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status='P'";
				
		$datarekap = $this->m_pdca->q_view_periode_nik_pdca($paramlist)->result();
		$datamst = $this->m_pdca->q_his_pdca_mst_param($paramlist_2)->result();
		$datadtl = $this->m_pdca->q_his_pdca_dtl_param($paramlist)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'rekap' => $datarekap,
				'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	
	function form_master_plan(){
		$data['title']="MASTER PLAN PDCA CONTINYU ATAU BERKALA";	
		$nama=trim($this->session->userdata('nik'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.C.I.1';
						$versirelease='I.C.I.1/ALPHA.001';
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
						
						
        $data['message']='';		
		$param="";				
		///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
		$data['list_pdca']=$this->m_pdca->q_view_periode_nik_pdca($param)->result();
		$data['list_nikmasterplan']=$this->m_akses->list_karyawan_param($param_list_akses)->result();
		$this->template->display('pdca/pdca/v_list_nik_masterplan',$data);
	}
	
	function form_list_plan(){
		$data['title']="PLAN DO CHECK ACTION MASTER PLAN";	
		$nama=trim($this->session->userdata('nik'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.C.I.1';
						$versirelease='I.C.I.1/ALPHA.001';
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
						
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $data['message']='';
        $data['nik']=$nik;
        $data['doctype']='BRK';
		$param="";				
		///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
		$data['list_master_plan']=$this->m_pdca->q_his_pdca_master_plan_daily($param)->result();
		$this->template->display('pdca/pdca/v_list_plan',$data);
	}
	
	function save_masterplan(){
		$nama=trim($this->session->userdata('nik'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$nik=trim($this->input->post('nik'));
		$nomor=trim($this->input->post('nomor'));
		$type=trim($this->input->post('type'));
		$descplan=strtoupper(trim($this->input->post('descplan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;	
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		if (empty($nik)){
			redirect("pdca/pdca/form_master_plan");
		} else {
			
			
			if($type=='INPUTPLAN') {
				$info = array (
					 'branch' => $branch,
					 'nik' => $nik,
					 'nomor' => 0,
					 'doctype' => 'BRK',
					 'statusplan' => '',
					 'conditionplan' => '',
					 'planperiod' => '',
					 'holdplan' => 'NO',
					 'status' => 'F',
					 'descplan' => $descplan,
					 'inputdate' => $inputdate,
					 'inputby' => $inputby,
				
				);
				$this->db->insert('sc_his.pdca_master_plan_daily',$info);
				redirect("pdca/pdca/form_list_plan/$enc_nik");
			} else if ($type=='EDITPLAN') {
				$info = array (
					 'descplan' => $descplan,
					 'updatedate' => $inputdate,
					 'updateby' => $inputby,				
				);
				$this->db->where('nik',$nik);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_his.pdca_master_plan_daily',$info);
				redirect("pdca/pdca/form_list_plan/$enc_nik");
			} else if ($type=='DELETEPLAN') {
				$info = array (
					 'holdplan' => 'YES',
					 'status' => 'D',
					 'updatedate' => $inputdate,
					 'updateby' => $inputby,				
				);
				$this->db->where('nik',$nik);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_his.pdca_master_plan_daily',$info);
				redirect("pdca/pdca/form_list_plan/$enc_nik");
			}
		}
		
	}
	
}