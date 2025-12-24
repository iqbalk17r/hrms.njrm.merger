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
		$data['title']="PLAN DO CHECK ACTION (PDCA)";	
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
		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$inputfill=strtoupper(trim($this->input->post('inputfill')));	
		$tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));	
		$fnik=strtoupper(trim($this->input->post('nik')));	
		
		if (!empty($tglYM)) { $periode=$tglYM; } else { $periode=date('Ym'); }
		if (!empty($inputfill)) { $filtertype=" and docno='$inputfill'"; } else { $filtertype=""; }
		

		if(($userhr>0)){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";
			} else { 
				$param_list_akses=" and planperiod='$periode'";
			}
			$param_list_akses_nik="";
		} 
	//	else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan1)>0 and $userhr==0 ){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan='$nama')";	
			} else { 
				//$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
				$param_list_akses="and planperiod='$periode' and (nik_atasan='$nama' or nik='$nama')";	
			}
			$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan2)>0 and $userhr==0 ){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
			} else { 
				//$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				$param_list_akses="and planperiod='$periode' and (nik_atasan2='$nama' or nik='$nama')";	
			}
			$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
			} else { 
				$param_list_akses="and planperiod='$periode' and nik='$nama' ";
			}
				$param_list_akses_nik=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;

		///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
		$data['list_pdca']=$this->m_pdca->q_view_periode_nik_pdca($param_list_akses)->result();
		$data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
		$this->template->display('pdca/pdca/v_list_pdca',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
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
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		/* if(($userhr>0)){
			$param_list_akses="";
		}  */
		//else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		if (($ceknikatasan1)>0 /*and $userhr==0 */){
			$param_list_akses="and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan2)>0 /*and $userhr==0 */){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 
		/*
		$param_list_akses=" and nik='$nama' "; */	
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$data['inputfill']=$inputfill;
		/* END APPROVE ATASAN */


		$data['list_nikpbk']=$this->m_akses->list_karyawan_param($param_list_akses)->result();
		$this->template->display('pdca/pdca/v_list_personal_karyawan',$data);
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function input_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and docno='$nama'";
		$param_cek_1date=" and nik='$nik' and docdate=to_char(now(),'yyyy-mm-dd') and doctype='ISD'";
		$cek_tmp=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc)->num_rows();
		$dtl_pdca=$this->m_pdca->q_tmp_pdca_dtl_param($param_cek_1doc)->row_array();
		$dtlalone=$this->m_akses->list_akses_alone()->row_array();
		$cek_his=$this->m_pdca->q_his_pdca_mst_param($param_cek_1date)->num_rows();
		/* PROTEKSI UNTUK NIK DAN DOKUMEN YG SAMA */
	    $param_cek_1doc_notin=" and nik='$nik' and docno!='$nama' and docdate=to_char(now(),'yyyy-mm-dd')  ";
	    $cek_tmp_nik_notin_docno=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc_notin)->num_rows();	
		if ($cek_tmp_nik_notin_docno>0) { 			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 22,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca"); 
				}
		
		
		if(isset($dtl_pdca['docno'])){ $nodok=$dtl_pdca['docno'];} else { $nodok='' ;}
		if ($cek_tmp==0 and !empty($nik) and $doctype!='BRK') {
			if($cek_tmp_nik_notin_docno>0) {
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
				if (trim($dtlalone['lvl_jabatan'])!='C'){
				/*	if ($cek_his>0){
							$this->db->where('userid',$nama);
							$this->db->where('modul','PDCA');
							$this->db->delete('sc_mst.trxerror');
							/* error handling *
							$infotrxerror = array (
								'userid' => $nama,
								'errorcode' => 18,
								'nomorakhir1' => $nodok,
								'nomorakhir2' => '',
								'modul' => 'PDCA',
							);
							$this->db->insert('sc_mst.trxerror',$infotrxerror);
							redirect("pdca/pdca/form_pdca");
					} else { */
						$this->m_pdca->insert_master_pdca_nonspv($nik,$doctype);
					//}			
				} else {
					$this->m_pdca->insert_master_pdca($nik,$doctype);	
				}
				
				/* error handling 
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
				$this->db->insert('sc_mst.trxerror',$infotrxerror); */
			}
		} else if (/*$cek_tmp>0 and */ !empty($nodok) and $doctype!='BRK') {
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
					'errorcode' => 0,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				//redirect("pdca/pdca/forssm_pdca");
			}
		} else if (!empty($nik) AND $doctype=='BRK'){
			//$enc_nik=hex2bin($this->encrypt->encode($nik));
			$enc_nik=bin2hex($this->encrypt->encode(trim($nik)));
			$enc_doctype=bin2hex($this->encrypt->encode(trim($doctype)));
			redirect("pdca/pdca/input_pdca_berkala/$enc_nik/$enc_doctype");
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
		$data['pdca_dtl_row']=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->num_rows();
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
		$param_cek_1doc=" and docno='$nama' and docdate='$docdate'";
		$param_cek_his=" and doctype='$doctype' and docdate='$docdate' and nik='$nik' and status in ('P','D','C')";
		$cek_tmp=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc)->num_rows();
		$cek_his=$this->m_pdca->q_his_pdca_mst_param($param_cek_his)->num_rows();
		/* PROTEKSI UNTUK NIK DAN DOKUMEN YG SAMA */
		$param_cek_1doc_notin=" and nik='$nik' and docno!='$nama' and docdate='$docdate'";
		$cek_tmp_nik_notin_docno=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc_notin)->num_rows();	
		if ($cek_tmp_nik_notin_docno>0) { 			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 22,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca"); 
				}

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
		$data['pdca_dtl_row']=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->num_rows();
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
		
		/* PROTEKSI UNTUK NIK DAN DOKUMEN YG SAMA */
		$param_cek_1doc_notin=" and nik='$nik' and docno!='$nama' and docdate='$docdate'";
		$cek_tmp_nik_notin_docno=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc_notin)->num_rows();	
		if ($cek_tmp_nik_notin_docno>0) { 			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 22,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca"); 
				}
		
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

			}
		} else if (/*$cek_tmp>0 and */!empty($nodok)) {
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
					'errorcode' => 0,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				
				//redirect("pdca/pdca/form_pdca");
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
		/* PROTEKSI UNTUK NIK DAN DOKUMEN YG SAMA */
		$param_cek_1doc_notin=" and nik='$nik' and docno!='$nama' and docdate='$docdate'";
		$cek_tmp_nik_notin_docno=$this->m_pdca->q_tmp_pdca_mst_param($param_cek_1doc_notin)->num_rows();	
		if ($cek_tmp_nik_notin_docno>0) { 			
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 22,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca"); 
				}
		
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
		$data['title']=' FORM PERSETUJAN ATASAN DATA PDCA ';
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

		$planperiod=date('Ym', strtotime($docdate));
		$data['enc_nik']=$enc_nik=bin2hex($this->encrypt->encode(trim($nik)));
		$data['enc_doctype']=$enc_doctype=bin2hex($this->encrypt->encode(trim($doctype)));
		$data['enc_docdate']=$enc_docdate=bin2hex($this->encrypt->encode(trim($docdate)));
		$data['enc_planperiod']=$enc_planperiod=bin2hex($this->encrypt->encode(trim($planperiod)));
		
		$data['title']=' DETAIL DATA FORM PDCA ';
		$paramlist=" and nik='$nik' and doctype='$doctype'  and docdate='$docdate'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_his_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_detail_pdca_tmp',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function hapus_pdca(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$docdate=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$nama=trim($this->session->userdata('nik'));

		$planperiod=date('Ym', strtotime($docdate));
		$data['enc_nik']=$enc_nik=bin2hex($this->encrypt->encode(trim($nik)));
		$data['enc_doctype']=$enc_doctype=bin2hex($this->encrypt->encode(trim($doctype)));
		$data['enc_docdate']=$enc_docdate=bin2hex($this->encrypt->encode(trim($docdate)));
		$data['enc_planperiod']=$enc_planperiod=bin2hex($this->encrypt->encode(trim($planperiod)));
		
		$data['title']=' HAPUS DETAIL DATA FORM PDCA 1 PERIODE MASTER';
		$paramlist=" and nik='$nik' and doctype='$doctype'  and docdate='$docdate'";
		$data['list_tmp_pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($paramlist)->result();
		$data['pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($paramlist)->row_array();
		$data['list_tmp_pdca_dtl']=$this->m_pdca->q_his_pdca_dtl_param($paramlist)->result();
		$this->template->display('pdca/pdca/v_hapus_pdca_tmp',$data);
		
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
		$planperiod=strtoupper(trim($this->input->post('planperiod')));
		$ttlpercent=strtoupper($this->input->post('ttlpercent'));
		$ttlplan=strtoupper($this->input->post('ttlplan'));
		$avgvalue=strtoupper($this->input->post('avgvalue'));
		/* entitas detail*/       
		$docno=$this->input->post('docno');
		$nomor=$this->input->post('nomor');
		$descplan=$this->input->post('descplan');
		$idbu=$this->input->post('idbu');
		$qtytime=$this->input->post('qtytime');
		$do_c=$this->input->post('do_c');
		$percentage_1=$this->input->post('percentage');
		if ($percentage_1!='') { $percentage =$percentage_1; } else { $percentage = 0; } 
		
		$remark=$this->input->post('remark');
		
		
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_doctype=bin2hex($this->encrypt->encode($doctype));
		$enc_docdate=bin2hex($this->encrypt->encode($docdate));
		$setupbackwards=$this->m_pdca->q_setup_day_backwards()->row_array();
		
		if ($type=='INPUT_MST_PDCA_ISL'){
			
			$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			if (trim($dtlarray['lvl_jabatan'])=='C'){  
				$docdate=date('Y-m-d', strtotime(trim($tglakhir))); 
				$parameter=" and nik='$nik' and docdate='$docdate' and doctype='$doctype'";
				$kisi='0';
			} else { 
				if(trim($setupbackwards['value1'])=='NO'){
					echo $kisi=($docdate < date('Y-m-d'));
				} else { 
					echo $kisi='0';
				}
				$parameter=" and nik='$nik' and docdate='$docdate' and doctype='$doctype'";
			}
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			//echo  $dtltrx.'<br>'.$kisi=='0';
			if ($dtltrx>0 and $kisi=='0') {
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
				
			} else if ($dtltrx>0 or $kisi=='1') {
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 20,
					'nomorakhir1' => '',
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
				
			} else {
				
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
			$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			$param_cek_1date=" and nik='$nik' and docdate='$docdate' and '$docdate'=to_char(now(),'yyyy-mm-dd') and doctype='ISD'";
			$cekhis=$this->m_pdca->q_his_pdca_mst_param($param_cek_1date)->num_rows();
			if (($dtlarray['lvl_jabatan'])=='C') {

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
									
								} else { 	
										$counter=900;			
										foreach($idbu as $index => $temp){
											$qtytime[$index];
											$qtytime_date=explode(' ',$qtytime[$index]);
											$qtytime_date1=date('Y-m-d',strtotime($qtytime_date[0]));
										/*
											if (date('Y-m-d',strtotime($dtlarray['tglakhir']))<	date('Y-m-d',strtotime($qtytime_date[0])) 
												OR
												date('Y-m-d',strtotime($dtlarray['tglawal']))>	date('Y-m-d',strtotime($qtytime_date[0]))){
												$this->db->where('userid',$nama);
												$this->db->where('modul','PDCA');
												$this->db->delete('sc_mst.trxerror');
												
												$infotrxerror = array (
													'userid' => $nama,
													'errorcode' => 19,
													'nomorakhir1' => '',
													'nomorakhir2' => '',
													'modul' => 'PDCA',
												);
												$this->db->insert('sc_mst.trxerror',$infotrxerror);
												redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
											}
											*/
												
											$info[$index]['nik']=$nik;//$noktp;
											$info[$index]['docno']=$docno;
											$info[$index]['nomor']=$counter;
											$info[$index]['doctype']=$doctype;
											$info[$index]['docref']=$docref;
											$info[$index]['docdate']=$docdate;
											$info[$index]['docpage']=$docpage;
											$info[$index]['revision']=$revision;
											$info[$index]['planperiod']=$planperiod;
											$info[$index]['descplan']=strtoupper($descplan[$index]);
											$info[$index]['idbu']=strtoupper($idbu[$index]);
											$info[$index]['qtytime']=$qtytime[$index];
											$info[$index]['do_c']=0;
											$info[$index]['percentage']=0;
											$info[$index]['remark']=strtoupper($remark[$index]);
											$info[$index]['status']='I';
											$info[$index]['inputdate']=$inputdate;
											$info[$index]['inputby']=$inputby;
											$counter++;

										}
										if(!empty($info)){
											$insert = $this->m_pdca->insert_dtl_pdca($info);
											/*$insert = $this->db->insert_batch('sc_tmp.pdca_dtl',($info = array()));
											return $insert?true:false;*/
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
										}
										
									redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
								}
			} else {
								if ($dtltrx>0 or (empty($docdate)) or $cekhis>0){
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
										$counter=900;			
										foreach($idbu as $index => $temp){

											$info[$index]['nik']=$nik;//$noktp;
											$info[$index]['docno']=$docno;
											$info[$index]['nomor']=$counter;
											$info[$index]['doctype']=$doctype;
											$info[$index]['docref']=$docref;
											$info[$index]['docdate']=$docdate;
											$info[$index]['docpage']=$docpage;
											$info[$index]['revision']=$revision;
											$info[$index]['planperiod']=$planperiod;
											$info[$index]['descplan']=strtoupper($descplan[$index]);
											$info[$index]['idbu']=strtoupper($idbu[$index]);
											$info[$index]['qtytime']=$qtytime[$index];
											$info[$index]['do_c']=0;
											$info[$index]['percentage']=0;
											$info[$index]['remark']=strtoupper($remark[$index]);
											$info[$index]['status']='I';
											$info[$index]['inputdate']=$inputdate;
											$info[$index]['inputby']=$inputby;
											$counter++;

										}
										if(!empty($info)){
											$insert = $this->m_pdca->insert_dtl_pdca($info);
											/*$insert = $this->db->insert_batch('sc_tmp.pdca_dtl',($info = array()));
											return $insert?true:false;*/
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
										}
										
									redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
								}
			}
			
	
		}  else if ($type=='EDIT_DTL_PDCA_ISL') { /* do terisi di modul realisasi*/
					$parameter=" and nik='$nik' and docdate is null and doctype='$doctype'";
					$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
					$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
					$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			if (($dtlarray['lvl_jabatan'])=='C') {
				$qtytime_date=explode(' ',$qtytime);
				$qtytime_date1=date('Y-m-d',strtotime($qtytime_date[0]));
				
				/*	if (date('Y-m-d',strtotime($dtlarray['tglakhir']))< date('Y-m-d',strtotime($qtytime_date[0])) 
						or
						date('Y-m-d',strtotime($dtlarray['tglawal']))>	date('Y-m-d',strtotime($qtytime_date[0]))){
						$this->db->where('userid',$nama);
						$this->db->where('modul','PDCA');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 19,
							'nomorakhir1' => '',
							'nomorakhir2' => '',
							'modul' => 'PDCA',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
						redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
					} else { */
						$info = array (

								'descplan' => strtoupper($descplan),
								'idbu' 		=> $idbu,
								'qtytime' 	=> $qtytime,
								'do_c' 		=> 0,
								'percentage'=> 0,
								'remark' 	=> strtoupper($remark),
								'status' 	=> '',
								'inputdate' => $inputdate,
								'inputby' 	=> $inputby,		
						);
						$this->db->where('docno',$nama);
						$this->db->where('nomor',$nomor);
						$this->db->update('sc_tmp.pdca_dtl',$info);
						
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
					///}
				} else {
					$qtytime_date=explode(' ',$qtytime);
					$qtytime_date1=date('Y-m-d',strtotime($qtytime_date[0]));
				///	$qtytime_date2=date('Y-m-d',strtotime($qtytime_date[1]));
					if (date('Y-m-d',strtotime($dtlarray['docdate']))!= $docdate){
						$this->db->where('userid',$nama);
						$this->db->where('modul','PDCA');
						$this->db->delete('sc_mst.trxerror');
						
						$infotrxerror = array (
							'userid' => $nama,
							'errorcode' => 19,
							'nomorakhir1' => '',
							'nomorakhir2' => '',
							'modul' => 'PDCA',
						);
						$this->db->insert('sc_mst.trxerror',$infotrxerror);
						redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");
					} else {
						$info = array (

								'descplan' => strtoupper($descplan),
								'idbu' 		=> $idbu,
								'qtytime' 	=> $qtytime,
								'do_c' 		=> 0,
								'percentage'=> 0,
								'remark' 	=> strtoupper($remark),
								'status' 	=> '',
								'inputdate' => $inputdate,
								'inputby' 	=> $inputby,		
						);
						$this->db->where('docno',$nama);
						$this->db->where('nomor',$nomor);
						$this->db->update('sc_tmp.pdca_dtl',$info);
						redirect("pdca/pdca/input_pdca/$enc_nik/$enc_doctype");		
					}
				}
		
		} else if ($type=='DEL_DTL_PDCA_ISL') {

				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->delete('sc_tmp.pdca_dtl');
				redirect("pdca/pdca/form_pdca");
		} else if ($type=='EDIT_MST_PDCA_ISL'){		////////////////                     EDIT__PDCA_ISL
			$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			if (trim($dtlarray['lvl_jabatan'])=='C'){  $docdate=date('Y-m-d', strtotime(trim($tglakhir))); }
			
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
			$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();

			if (($dtlarray['lvl_jabatan'])=='C') {
			
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
									
								} else { $counter=900;			
										foreach($idbu as $index => $temp){
											$qtytime[$index];
											$qtytime_date=explode(' ',$qtytime[$index]);
											$qtytime_date1=date('Y-m-d',strtotime($qtytime_date[0]));
										///	$qtytime_date2=date('Y-m-d',strtotime($qtytime_date[1]));
										/*	if (date('Y-m-d',strtotime($dtlarray['tglakhir']))<	date('Y-m-d',strtotime($qtytime_date[0])) 
												OR
												date('Y-m-d',strtotime($dtlarray['tglawal']))>	date('Y-m-d',strtotime($qtytime_date[0]))){
												$this->db->where('userid',$nama);
												$this->db->where('modul','PDCA');
												$this->db->delete('sc_mst.trxerror');
												
												$infotrxerror = array (
													'userid' => $nama,
													'errorcode' => 19,
													'nomorakhir1' => '',
													'nomorakhir2' => '',
													'modul' => 'PDCA',
												);
												$this->db->insert('sc_mst.trxerror',$infotrxerror);
												redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
											} */
											$info[$index]['nik']=$nik;//$noktp;
											$info[$index]['docno']=$docno;
											$info[$index]['nomor']=$counter;
											$info[$index]['doctype']=$doctype;
											$info[$index]['docref']=$docref;
											$info[$index]['docdate']=$docdate;
											$info[$index]['docpage']=$docpage;
											$info[$index]['revision']=$revision;
											$info[$index]['planperiod']=$planperiod;
											$info[$index]['descplan']=strtoupper($descplan[$index]);
											$info[$index]['idbu']=strtoupper($idbu[$index]);
											$info[$index]['qtytime']=$qtytime[$index];
											$info[$index]['do_c']=0;
											$info[$index]['percentage']=0;
											$info[$index]['remark']=strtoupper($remark[$index]);
											$info[$index]['status']='E';
											$info[$index]['inputdate']=$inputdate;
											$info[$index]['inputby']=$inputby;
											$counter++;

										}
										if(!empty($info)){
											$insert = $this->m_pdca->insert_dtl_pdca($info);

										}
									redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
								}
				} else {
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
									
								} else { $counter=900;			
										foreach($idbu as $index => $temp){
										
											$info[$index]['nik']=$nik;//$noktp;
											$info[$index]['docno']=$docno;
											$info[$index]['nomor']=$counter;
											$info[$index]['doctype']=$doctype;
											$info[$index]['docref']=$docref;
											$info[$index]['docdate']=$docdate;
											$info[$index]['docpage']=$docpage;
											$info[$index]['revision']=$revision;
											$info[$index]['planperiod']=$planperiod;
											$info[$index]['descplan']=strtoupper($descplan[$index]);
											$info[$index]['idbu']=strtoupper($idbu[$index]);
											$info[$index]['qtytime']=$qtytime[$index];
											$info[$index]['do_c']=0;
											$info[$index]['percentage']=0;
											$info[$index]['remark']=strtoupper($remark[$index]);
											$info[$index]['status']='E';
											$info[$index]['inputdate']=$inputdate;
											$info[$index]['inputby']=$inputby;
											$counter++;

										}
										if(!empty($info)){
											$insert = $this->m_pdca->insert_dtl_pdca($info);

										}
									redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
								}
				}
		} else if ($type=='EDIT_2EDIT_DTL_PDCA_ISL') {
			$parameter=" and nik='$nik' and docdate is null and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			
			if (($dtlarray['lvl_jabatan'])=='C') {
				$qtytime_date=explode(' ',$qtytime);
				$qtytime_date1=date('Y-m-d',strtotime($qtytime_date[0]));
			/*	if (date('Y-m-d',strtotime($dtlarray['tglakhir']))<	date('Y-m-d',strtotime($qtytime_date[0])) 
					OR
					date('Y-m-d',strtotime($dtlarray['tglawal']))>	date('Y-m-d',strtotime($qtytime_date[0]))){
					$this->db->where('userid',$nama);
					$this->db->where('modul','PDCA');
					$this->db->delete('sc_mst.trxerror');
					
					$infotrxerror = array (
						'userid' => $nama,
						'errorcode' => 19,
						'nomorakhir1' => '',
						'nomorakhir2' => '',
						'modul' => 'PDCA',
					);
					$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
				} else { */
					$info = array (
			
							'descplan' => $descplan,
							'idbu' 		=> $idbu,
							'qtytime' 	=> $qtytime,
							'do_c' 		=> 0,
							'percentage'=> 0,
							'remark' 	=> $remark,
							'status' 	=> '',
							'updatedate' => $inputdate,
							'updateby' 	=> $inputby,		
					);
					$this->db->where('docno',$nama);
					$this->db->where('nomor',$nomor);
					$this->db->update('sc_tmp.pdca_dtl',$info);
					
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
			///	}
			} else {
						$info = array (

								'descplan' => strtoupper($descplan),
								'idbu' 		=> $idbu,
								'qtytime' 	=> $qtytime,
								'do_c' 		=> 0,
								'percentage'=> 0,
								'remark' 	=> strtoupper($remark),
								'status' 	=> '',
								'updatedate' => $inputdate,
								'updateby' 	=> $inputby,		
						);
						$this->db->where('docno',$nama);
						$this->db->where('nomor',$nomor);
						$this->db->update('sc_tmp.pdca_dtl',$info);
						
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
				
			
		} else if ($type=='DEL_2EDIT_DTL_PDCA_ISL') {
        
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->delete('sc_tmp.pdca_dtl');
				redirect("pdca/pdca/edit_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='REJECT_APPROV_DTL_PDCA_ISL') {
			$info = array (
						'status' 	=> 'B',
						'percentage'=> $percentage,
						'do_c'		=> $do_c,
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
						'do_c'		=> $do_c,
						'percentage'=> $percentage,
						'approvdate' => $inputdate,
						'approvby' 	=> $inputby,		
				);
				$this->db->where('docno',$nama);
				$this->db->where('nomor',$nomor);
				$this->db->update('sc_tmp.pdca_dtl',$info);
				redirect("pdca/pdca/approv_pdca/$enc_nik/$enc_doctype/$enc_docdate");
		} else if ($type=='RESET_APPROV_DTL_PDCA_ISL') {
			
			$parameter_2=" and doctype='$doctype' and docdate='$docdate' and nomor='$nomor' and nik='$nik'";
			$dtlarray=$this->m_pdca->q_his_pdca_dtl_param($parameter_2)->row_array();
			//ECHO  $dtlarray['percentage'];
			$info = array (
					'percentage'=> $dtlarray['percentage'], 
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
			$parameter=" and nik='$nik' and docdate is null and doctype='$doctype'";
			$dtltrx=$this->m_pdca->q_his_pdca_mst_param($parameter)->num_rows();
			$parameter_2=" and nik='$nik' and docno='$nama' and doctype='$doctype'";
			$dtlarray=$this->m_pdca->q_tmp_pdca_mst_param($parameter_2)->row_array();
			$do_c_date=explode(' ',$do_c);
			
			if (($dtlarray['lvl_jabatan'])=='C') {			
			/*	if (date('Y-m-d',strtotime($dtlarray['tglakhir']))<	date('Y-m-d',strtotime($do_c_date[0])) 
					OR
					date('Y-m-d',strtotime($dtlarray['tglawal']))>	date('Y-m-d',strtotime($do_c_date[0]))){
					$this->db->where('userid',$nama);
					$this->db->where('modul','PDCA');
					$this->db->delete('sc_mst.trxerror');
					
					$infotrxerror = array (
						'userid' => $nama,
						'errorcode' => 19,
						'nomorakhir1' => '',
						'nomorakhir2' => '',
						'modul' => 'PDCA',
					);
					$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
				} else { */
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
			////	}
			} else {
				if ($docdate>date('Y-m-d')) {
					$this->db->where('userid',$nama);
					$this->db->where('modul','PDCA');
					$this->db->delete('sc_mst.trxerror');
					
					$infotrxerror = array (
						'userid' => $nama,
						'errorcode' => 21,
						'nomorakhir1' => '',
						'nomorakhir2' => '',
						'modul' => 'PDCA',
					);
					$this->db->insert('sc_mst.trxerror',$infotrxerror);
					redirect("pdca/pdca/realisasi_pdca/$enc_nik/$enc_doctype/$enc_docdate");
				} else {
				
						$info = array (
								'do_c' 		=> $do_c,
								'percentage'=> $percentage,
								'remark' 	=> strtoupper($remark),
								'status' 	=> '',
								'realisasidate' => $inputdate,
								'realisasiby' 	=> $inputby,		
						);
						$this->db->where('docno',$nama);
						$this->db->where('nomor',$nomor);
						$this->db->update('sc_tmp.pdca_dtl',$info);
						
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
				
			}
			
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
		$enc_nik=bin2hex($this->encrypt->encode(trim($dtl['nik'])));
		$enc_doctype=bin2hex($this->encrypt->encode(trim($dtl['doctype'])));
		$enc_planperiod=bin2hex($this->encrypt->encode(trim($dtl['planperiod'])));
		
		
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
        
		//redirect("pdca/pdca/form_pdca");
		redirect("pdca/pdca/form_view_pdca_sub_detail/$enc_nik/$enc_doctype/$enc_planperiod");
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
		$paramlist_2_x=" and docno='$nama' and status in ('A')";
		$dtlmst=$this->m_pdca->q_tmp_pdca_mst_param($paramlist)->row_array();
		$dtldtl=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist)->num_rows();
		$numrealisasi=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist_2)->num_rows();
		$numrealisasi_x=$this->m_pdca->q_tmp_pdca_dtl_param($paramlist_2_x)->num_rows();
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
		} else if($numrealisasi_x>0 and ($status_master=='R')){		/* REALISASI FINAL*/
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
	
	function hapus_input_pdca(){
		$nama=trim($this->session->userdata('nik'));

		$enc_nik=trim($this->uri->segment(4));
		$enc_doctype=trim($this->uri->segment(5));
		$enc_planperiod=trim($this->uri->segment(6));
		$enc_docdate=trim($this->uri->segment(7));
		
		$nik=$this->encrypt->decode(hex2bin(trim($enc_nik)));
		$doctype=$this->encrypt->decode(hex2bin(trim($enc_doctype)));
		$planperiod=$this->encrypt->decode(hex2bin(trim($enc_planperiod)));
		$docdate=$this->encrypt->decode(hex2bin(trim($enc_docdate)));
		
		
		$paramlist=" and nik='$nik' and doctype='$doctype' and docdate='$docdate' and planperiod='$planperiod'";
		$dtlmst=$this->m_pdca->q_his_pdca_mst_param($paramlist)->row_array();
		$dtldtl=$this->m_pdca->q_his_pdca_dtl_param($paramlist)->num_rows();
		$status_master=trim($dtlmst['status']);
		
		
		if(empty($dtlmst['docdate']) or ($status_master!='A')){
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
			redirect("pdca/pdca/form_view_pdca_sub_detail/$enc_nik/$enc_doctype/$enc_planperiod");
		} else {

			$this->db->where('nik',$nik);
			$this->db->where('doctype',$doctype);
			$this->db->where('planperiod',$planperiod);
			$this->db->where('docdate',$docdate);
			$this->db->delete('sc_his.pdca_mst');
			
			$this->db->where('nik',$nik);
			$this->db->where('doctype',$doctype);
			$this->db->where('planperiod',$planperiod);
			$this->db->where('docdate',$docdate);
			$this->db->delete('sc_his.pdca_dtl');						
						
			//redirect("pdca/pdca/form_pdca");
			redirect("pdca/pdca/form_view_pdca_sub_detail/$enc_nik/$enc_doctype/$enc_planperiod");
		}
	}
	
	function clear_tmp_pdca_berkala(){
		$nama=trim($this->session->userdata('nik'));
		$nik=trim($this->uri->segment(4));
		$planperiod=trim($this->uri->segment(5));
			$this->db->where('nik',$nik);
			$this->db->where('planperiod',$planperiod);
			$this->db->delete('sc_his.pdca_list_gen');
		redirect("pdca/pdca/form_pdca");
	}
	
	function form_view_pdca_sub_detail(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$nama=$this->session->userdata('nik');
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
			/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		//else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan1)>0 and $userhr==0 ){
			$param_list_akses="and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan2)>0 and $userhr==0 ){
			$param_list_akses=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			$param_list_akses=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		$enc_nik=trim($this->uri->segment(4));
		$enc_doctype=trim($this->uri->segment(5));
		$enc_planperiod=trim($this->uri->segment(6));
		
		$data['title']="PLAN DO CHECK ACTION";	

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
		
		if ($doctype=='ISD'){
					$param=" and nik='$nik' and doctype='$doctype' and planperiod='$planperiod'";				
					$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
					$data['pdca_mst']=$this->m_pdca->q_his_pdca_mst_param($param)->row_array();
					$pdca_mst=$this->m_pdca->q_his_pdca_mst_param($param)->row_array();
				if(isset($pdca_mst['lvl_jabatan'])){
				} else {
					redirect("pdca/pdca/form_pdca");
				}
				
					
					$this->template->display('pdca/pdca/v_list_pdca_sub_detail',$data);
		} else if ($doctype=='BRK') {
					////$param=" and nik='$nik' and doctype='$doctype' and planperiod='$planperiod'";				
					////$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
					////////$data['list_pdca']=$this->m_pdca->q_view_periode_nik_pdca($param)->result();
					////$this->template->display('pdca/pdca/v_list_pdca_sub_detail',$data);
					redirect("pdca/pdca/edit_pdca_berkala/$enc_nik/$enc_doctype/$enc_planperiod");
					
		}

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
		$data['title']="Report PDCA ISIDENTIL";
	//	$data['jsonfile'] = "pdca/pdca/json_pdca_isidentil/$enc_nik/$enc_doctype/$enc_planperiod";
		$data['jsonfile'] = "pdca/pdca/json_pdca_isidentil_limit/$enc_nik/$enc_doctype/$enc_planperiod";
	///	$data['report_file'] = 'assets/mrt/sti_pdca_isidentil.mrt';
		$data['report_file'] = 'assets/mrt/sti_pdca_isidentil_limit.mrt';
		$this->load->view("pdca/pdca/sti_v",$data);
	}
	
	function sti_pdca_isidentil_spv(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$enc_nik=(trim($this->uri->segment(4)));
		$enc_doctype=(trim($this->uri->segment(5)));
		$enc_planperiod=(trim($this->uri->segment(6)));
		
		$data['title']="Report PDCA ISIDENTIL";
		$data['jsonfile'] = "pdca/pdca/json_pdca_isidentil_spv/$enc_nik/$enc_doctype/$enc_planperiod";
		$data['report_file'] = 'assets/mrt/sti_pdca_isidentil_spv.mrt';
		$this->load->view("pdca/pdca/sti_v",$data);
	}
	
	function sti_pdca_berkala(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$enc_nik=(trim($this->uri->segment(4)));
		$enc_doctype=(trim($this->uri->segment(5)));
		$enc_planperiod=(trim($this->uri->segment(6)));
		$data['title']="Report PDCA Berkala";
		$data['jsonfile'] = "pdca/pdca/json_pdca_berkala/$enc_nik/$enc_doctype/$enc_planperiod";
		$data['report_file'] = 'assets/mrt/sti_pdca_berkala.mrt';
		$this->load->view("pdca/pdca/sti_v",$data);
	}
	
	function json_pdca_isidentil(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		///$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist_2=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status='P'";
				
		$datarekap = $this->m_pdca->q_view_periode_nik_pdca_status($paramlist)->result();
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
	
	function json_pdca_isidentil_spv(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		///$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist_2=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status='P'";
				
		$datarekap = $this->m_pdca->q_view_rekap_isd_cetak_spv($paramlist)->result();
		$datamst = $this->m_pdca->q_his_pdca_mst_param($paramlist_2)->result();
		$datadtl = $this->m_pdca->q_view_dtl_isd_cetak_spv($paramlist)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'rekap' => $datarekap,
				'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	function json_pdca_isidentil_limit(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$nama=trim($this->session->userdata('nik'));
		$this->db->query("select sc_his.pr_pdca_cetakpage('$nik', '$doctype', '$planperiod', '$nama');");
		///$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist_2=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status='P'";
				
		$datarekap = $this->m_pdca->q_view_rekap_isd_cetak($paramlist)->result();
		///$datamst = $this->m_pdca->q_view_mst_isd_cetak($paramlist_2)->result();
		$datadtl = $this->m_pdca->q_view_dtl_isd_cetak($paramlist)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'rekap' => $datarekap,
				//'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	
	function json_pdca_berkala(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod'";
				
		$datarekap = $this->m_pdca->q_view_periode_nik_pdca_status($paramlist)->result();
		$datamst = $this->m_pdca->q_view_periode_nik_pdca_status($paramlist)->result();
		///$datadtl = $this->m_pdca->q_his_pdca_list_gen($paramlist)->result();
		$datadtl = $this->m_pdca->q_his_pdca_list_gen_report($paramlist)->result();
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
		$data['title']="MASTER PLAN PDCA BERKALA, FORM MASTER PLAN";	
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
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		//else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan1)>0 and $userhr==0 ){
			$param_list_akses="and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 ){
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
		$data['title']="PLAN DO CHECK ACTION(PDCA) MASTER PLAN";	
		$data['title2']="Menu form untuk PDCA dalam 1 Periode Yang Aktif";	
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
        $data['nama']=$nama;
        $data['doctype']='BRK';
		$param=" and nik='$nik'";				
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
			} else if ($type=='RESTOREPLAN') {
				$info = array (
					 'holdplan' => 'NO',
					 'status' => 'F',
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
	
	function form_pdca_berkala(){
		$data['title']="FORM PDCA BERKALA";	
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
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
			// or $level_akses=='A'
		if(($userhr>0)){
			$param_list_akses="";
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 ){
			$param_list_akses="and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 ){
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
	
	function input_pdca_berkala(){
		$nama=trim($this->session->userdata('nik'));
		$nik1=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype1=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$periode1=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$nik2=$this->input->post('nik');
		$doctype2=strtoupper($this->input->post('doctype'));
		$type=strtoupper($this->input->post('type'));
		
		if (!empty($nik1) and empty($nik2)) { $nik=$nik1; } else if (empty($nik1) and !empty($nik2)){ $nik=$nik2; }
		if (!empty($doctype1) and empty($doctype2)) { $doctype=$doctype1; } else if (empty($doctype1) and !empty($doctype2)){ $doctype=$doctype2; }
		
		$tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));	
		$fnik=strtoupper(trim($this->input->post('nik')));	
		if (!empty($tglYM) and empty($periode1)) { $periode=$tglYM; } else if (empty($tglYM) and !empty($periode1)) { $periode=$periode1; } else { $periode=date('Ym'); }
		
		
		$param_cek_input=" and nik='$nik' and planperiod='$periode' and nomor='999' and status='I'";
		$cek_input=$this->m_pdca->q_his_pdca_list_gen($param_cek_input)->num_rows();
		if ($cek_input>0){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling */
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 18,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca");
		} else {
					$data['title']="PLAN DO CHECK ACTION DAILY/BERKALA";	
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
					$param_list_akses="and planperiod='$periode' and nik='$nik'";
					$param_list_akses_nik=" and nik='$nik' ";
				/* akses approve atasan */
				/*		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
					$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
					$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
					$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

					$userinfo=$this->m_akses->q_user_check()->row_array();
					$userhr=$this->m_akses->list_akses_od()->num_rows();
					$level_akses=strtoupper(trim($userinfo['level_akses']));
						

					if(($userhr>0)){
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$fnik'";
						} else { 
							$param_list_akses=" and planperiod='$periode'";
						}
						$param_list_akses_nik="";
					} 
					//else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
					else if (($ceknikatasan1)>0 and $userhr==0){
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
						} else { 
							$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
						}
						$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
						
					}
					//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
					else if (($ceknikatasan2)>0 and $userhr==0 ){
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
						} else { 
							$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
						}
						$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
							
					}
					else {
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
						} else { 
							$param_list_akses="and planperiod='$periode' and nik='$nama' ";
						}
							$param_list_akses_nik=" and nik='$nama' ";
					} */
					
					$data['nama']=$nama;
					$data['nik']=$nik;
					//$data['userhr']=$userhr;
					//$data['level_akses']=$level_akses;
					$data['periode']=$periode;
					$data['tglperiod']='01-'.substr($periode,-2).'-'.substr($periode,0,4);
					
					/* GENERATE DARI MASTER PLAN*/
					$param_his_mp=" and nik='$nik' and doctype='BRK' and holdplan='NO'";
					$cek_mp=$this->m_pdca->q_his_pdca_master_plan_daily($param_his_mp)->num_rows();
					if($cek_mp==0) {
							$this->db->where('userid',$nama);
							$this->db->where('modul','PDCA');
							$this->db->delete('sc_mst.trxerror');
							/* error handling */
							$infotrxerror = array (
								'userid' => $nama,
								'errorcode' => 17,
								'nomorakhir1' => $nodok,
								'nomorakhir2' => '',
								'modul' => 'PDCA',
							);
							$this->db->insert('sc_mst.trxerror',$infotrxerror);
							redirect("pdca/pdca/form_pdca");
					} else {
							$this->db->query("SELECT sc_his.pr_gr_pdca_masterplan('$nik', '$periode');");	
					}
					///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
					$data['list_pdca']=$this->m_pdca->q_his_pdca_list_gen($param_list_akses)->result();
					$data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
					$this->template->display('pdca/pdca/v_list_pdca_berkala',$data);
		}
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function edit_pdca_berkala(){ 
		$nama=trim($this->session->userdata('nik'));
		$nik1=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype1=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$periode1=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$nik2=$this->input->post('nik');
		$doctype2=strtoupper($this->input->post('doctype'));
		$type=strtoupper($this->input->post('type'));
		
		if (!empty($nik1) and empty($nik2)) { $nik=$nik1; } else if (empty($nik1) and !empty($nik2)){ $nik=$nik2; }
		if (!empty($doctype1) and empty($doctype2)) { $doctype=$doctype1; } else if (empty($doctype1) and !empty($doctype2)){ $doctype=$doctype2; }
		
		$tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));	
		
		if (!empty($tglYM) and empty($periode1)) { $periode=$tglYM; } else if (empty($tglYM) and !empty($periode1)) { $periode=$periode1; } else { $periode=date('Ym'); }
		
/*		
		$param_cek_input=" and nik='$nik' and planperiod='$periode' and nomor='999' and urutcategory='10' and status=''";
		$cek_input=$this->m_pdca->q_his_pdca_list_gen($param_cek_input)->num_rows();
		if ($cek_input>0){
				$this->db->where('userid',$nama);
				$this->db->where('modul','PDCA');
				$this->db->delete('sc_mst.trxerror');
				/* error handling 
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 18,
					'nomorakhir1' => $nodok,
					'nomorakhir2' => '',
					'modul' => 'PDCA',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror);
				redirect("pdca/pdca/form_pdca");
		} else {	}*/
					$data['title']="PLAN DO CHECK ACTION DAILY/BERKALA";	
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

					/* akses approve atasan */
					$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
					$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
					$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
					$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

					$userinfo=$this->m_akses->q_user_check()->row_array();
					$userhr=$this->m_akses->list_akses_od()->num_rows();
					$level_akses=strtoupper(trim($userinfo['level_akses']));
						
					$param_list_akses="and planperiod='$periode' and nik='$nik'";
					$param_list_akses_nik=" and nik='$nik' ";
				/* if(($userhr>0)){
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$nik'";
						} else { 
							$param_list_akses=" and planperiod='$periode'";
						}
						$param_list_akses_nik="";
					} 
					//else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
					else if (($ceknikatasan1)>0 and $userhr==0 ){
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$nik'";	
						} else { 
							$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
						}
						$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
						
					}
					//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
					else if (($ceknikatasan2)>0 and $userhr==0 ){
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='$nik'";	
						} else { 
							$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
						}
						$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
							
					}
					else {
						if (!empty($fnik)) {
							$param_list_akses="and planperiod='$periode' and nik='fnik'";	
						} else { 
							$param_list_akses="and planperiod='$periode' and nik='$nama' ";
						}
							$param_list_akses_nik=" and nik='$nama' ";
					} */
					
					$data['nama']=$nama;
					$data['nik']=$nik;
					$data['userhr']=$userhr;
					$data['level_akses']=$level_akses;
					$data['periode']=$periode;
					$data['tglperiod']='01-'.substr($periode,-2).'-'.substr($periode,0,4);
					$data['atasan1']=$ceknikatasan1;
					$data['atasan2']=$ceknikatasan2;
					$data['nikatasan1']=$ceknikatasan1;
					$data['nikatasan2']=$ceknikatasan2;
					/* GENERATE DARI MASTER PLAN*/
					$param_his_mp=" and nik='$nik' and doctype='BRK' and holdplan='NO'";
					$cek_mp=$this->m_pdca->q_his_pdca_master_plan_daily($param_his_mp)->num_rows();
					if($cek_mp==0) {
							$this->db->where('userid',$nama);
							$this->db->where('modul','PDCA');
							$this->db->delete('sc_mst.trxerror');
							/* error handling */
							$infotrxerror = array (
								'userid' => $nama,
								'errorcode' => 17,
								'nomorakhir1' => $nodok,
								'nomorakhir2' => '',
								'modul' => 'PDCA',
							);
							$this->db->insert('sc_mst.trxerror',$infotrxerror);
							redirect("pdca/pdca/form_pdca");
					} else {
						///	$this->db->query("SELECT sc_his.pr_gr_pdca_masterplan('$nik', '$periode');");	
					}
					///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
					//echo $nik;
					$param_status=" and nik='$nik' and nomor='999' and urutcategory='10' and planperiod='$periode'";
					$data['list_pdca']=$this->m_pdca->q_his_pdca_list_gen($param_list_akses)->result();
					$rowne=$this->m_pdca->q_his_pdca_list_gen($param_list_akses)->num_rows();
					if($rowne<=0){
						redirect("pdca/pdca/form_pdca");
					}
					$data['dtlstatus']=$this->m_pdca->q_his_pdca_list_gen($param_status)->row_array();
					$data['withconfirm']=$this->m_pdca->q_withconfirm_pdca_gen($param_status)->row_array();
					$data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
					
					$this->template->display('pdca/pdca/v_list_pdca_berkala_edit',$data);
			$paramerror=" and userid='$nama'";
			$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);

	}
	
	function edit_detail_pdca_berkala(){ //modal
		$nama=trim($this->session->userdata('nik'));
		$data['nik']=$nik=trim($this->uri->segment(4));
		$data['nomor']=$nomor=trim($this->uri->segment(5));
		$data['planperiod']=$planperiod=trim($this->uri->segment(6));
		$data['urutcategory']=$urutcategory=trim($this->uri->segment(7));
		$data['dy']=$dy=trim($this->uri->segment(8));
		$data['nama']=trim($this->session->userdata('nik'));
		$param_nik=" and nik='$nik'";
		$param_gen=" and nik='$nik' and nomor='$nomor' and planperiod='$planperiod' and urutcategory='$urutcategory'";
		$dtl_nik=$this->m_akses->list_karyawan_param($param_nik)->row_array();
		$dtl_gen=$this->m_pdca->q_his_pdca_list_gen($param_gen)->row_array();
		$data['dtl_gen']=$this->m_pdca->q_his_pdca_list_gen($param_gen)->row_array();
		
		switch ($dy) {
			case "01":	$data['category_date']=trim(strtoupper($dtl_gen['tgl1']));	break;
			case "02":	$data['category_date']=trim(strtoupper($dtl_gen['tgl2']));	break;
			case "03":	$data['category_date']=trim(strtoupper($dtl_gen['tgl3']));	break;
			case "04":	$data['category_date']=trim(strtoupper($dtl_gen['tgl4']));	break;
			case "05":	$data['category_date']=trim(strtoupper($dtl_gen['tgl5']));	break;
			case "06":	$data['category_date']=trim(strtoupper($dtl_gen['tgl6']));	break;
			case "07":	$data['category_date']=trim(strtoupper($dtl_gen['tgl7']));	break;
			case "08":	$data['category_date']=trim(strtoupper($dtl_gen['tgl8']));	break;
			case "09":	$data['category_date']=trim(strtoupper($dtl_gen['tgl9']));	break;
			case "10":	$data['category_date']=trim(strtoupper($dtl_gen['tgl10']));	break;
			case "11":	$data['category_date']=trim(strtoupper($dtl_gen['tgl11']));	break;
			case "12":	$data['category_date']=trim(strtoupper($dtl_gen['tgl12']));	break;
			case "13":	$data['category_date']=trim(strtoupper($dtl_gen['tgl13']));	break;
			case "14":	$data['category_date']=trim(strtoupper($dtl_gen['tgl14']));	break;
			case "15":	$data['category_date']=trim(strtoupper($dtl_gen['tgl15']));	break;
			case "16":	$data['category_date']=trim(strtoupper($dtl_gen['tgl16']));	break;
			case "17":	$data['category_date']=trim(strtoupper($dtl_gen['tgl17']));	break;
			case "18":	$data['category_date']=trim(strtoupper($dtl_gen['tgl18']));	break;
			case "19":	$data['category_date']=trim(strtoupper($dtl_gen['tgl19']));	break;
			case "20":	$data['category_date']=trim(strtoupper($dtl_gen['tgl20']));	break;
			case "21":	$data['category_date']=trim(strtoupper($dtl_gen['tgl21']));	break;
			case "22":	$data['category_date']=trim(strtoupper($dtl_gen['tgl22']));	break;
			case "23":	$data['category_date']=trim(strtoupper($dtl_gen['tgl23']));	break;
			case "24":	$data['category_date']=trim(strtoupper($dtl_gen['tgl24']));	break;
			case "25":	$data['category_date']=trim(strtoupper($dtl_gen['tgl25']));	break;
			case "26":	$data['category_date']=trim(strtoupper($dtl_gen['tgl26']));	break;
			case "27":	$data['category_date']=trim(strtoupper($dtl_gen['tgl27']));	break;
			case "28":	$data['category_date']=trim(strtoupper($dtl_gen['tgl28']));	break;
			case "29":	$data['category_date']=trim(strtoupper($dtl_gen['tgl29']));	break;
			case "30":	$data['category_date']=trim(strtoupper($dtl_gen['tgl30']));	break;
			case "31":	$data['category_date']=trim(strtoupper($dtl_gen['tgl31']));	break;
			case "XX":	$data['category_date']=trim(strtoupper($dtl_gen['remark']));	break;
			default: $data['category_date']='';
		}
		
		$data['title']="DETAIL PDCA BERKALA TANGGAL :: ".$dy.' - '.substr($planperiod,-2,2).' - '.substr($planperiod,0,4);
		$data['title2']="PDCA BY :: ".trim($dtl_nik['nmlengkap']);
		$this->load->view('pdca/pdca/v_modal_edit_detail_pdca_berkala',$data);
		
				$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function save_edit_pdca_brk(){
		$nama=trim($this->session->userdata('nik'));
		$category_date=trim(strtoupper($this->input->post('category_date')));
		$data['nik']			=$nik=$this->input->post('nik');
		$data['nomor']			=$nomor=$this->input->post('nomor');
		$data['planperiod']		=$planperiod=$this->input->post('planperiod');
		$data['urutcategory']	=$urutcategory=$this->input->post('urutcategory');
		$data['dy']				=$dy=$this->input->post('dy');
		$type=strtoupper($this->input->post('type'));
		$doctype='BRK';
		
		$enc_nik=bin2hex($this->encrypt->encode($nik));
		$enc_doctype=bin2hex($this->encrypt->encode($doctype));
		$enc_periode=bin2hex($this->encrypt->encode($planperiod));
		//$param_status=" and nik='$nik' and planperiod='$planperiod' and doctype='BRK'";
		//$dtl_periode=$this->m_pdca->q_view_periode_nik_pdca($param_status)->row_array();
		
		$param_status=" and nik='$nik' and planperiod='$planperiod' and nomor='999' and urutcategory='10' ";
		$dtl_periode=$this->m_pdca->q_his_pdca_list_gen($param_status)->row_array();
		//echo trim($dtl_periode['status']);
		
		if($type=='EDIT_CATEGORY_DATE'){
			$dtltrx=0; /* untuk blokingan */
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
				if ($dtl_periode['status']=='I') {
					redirect("pdca/pdca/edit_pdca_berkala/$enc_nik/$enc_doctype/$enc_periode");
				} else {
					redirect("pdca/pdca/input_pdca_berkala/$enc_nik/$enc_doctype/$enc_periode");
				}
				
				
			} else if ($dtltrx==0) {
				switch ($dy) {
					case "01":	$info_dtl = array ( 'tgl1'  => $category_date );	break;
					case "02":	$info_dtl = array ( 'tgl2'  => $category_date );	break;
					case "03":	$info_dtl = array ( 'tgl3'  => $category_date );	break;
					case "04":	$info_dtl = array ( 'tgl4'  => $category_date );	break;
					case "05":	$info_dtl = array ( 'tgl5'  => $category_date );	break;
					case "06":	$info_dtl = array ( 'tgl6'  => $category_date );	break;
					case "07":	$info_dtl = array ( 'tgl7'  => $category_date );	break;
					case "08":	$info_dtl = array ( 'tgl8'  => $category_date );	break;
					case "09":	$info_dtl = array ( 'tgl9'  => $category_date );	break;
					case "10":	$info_dtl = array ( 'tgl10' => $category_date );	break;
					case "11":	$info_dtl = array ( 'tgl11' => $category_date );	break;
					case "12":	$info_dtl = array ( 'tgl12' => $category_date );	break;
					case "13":	$info_dtl = array ( 'tgl13' => $category_date );	break;
					case "14":	$info_dtl = array ( 'tgl14' => $category_date );	break;
					case "15":	$info_dtl = array ( 'tgl15' => $category_date );	break;
					case "16":	$info_dtl = array ( 'tgl16' => $category_date );	break;
					case "17":	$info_dtl = array ( 'tgl17' => $category_date );	break;
					case "18":	$info_dtl = array ( 'tgl18' => $category_date );	break;
					case "19":	$info_dtl = array ( 'tgl19' => $category_date );	break;
					case "20":	$info_dtl = array ( 'tgl20' => $category_date );	break;
					case "21":	$info_dtl = array ( 'tgl21' => $category_date );	break;
					case "22":	$info_dtl = array ( 'tgl22' => $category_date );	break;
					case "23":	$info_dtl = array ( 'tgl23' => $category_date );	break;
					case "24":	$info_dtl = array ( 'tgl24' => $category_date );	break;
					case "25":	$info_dtl = array ( 'tgl25' => $category_date );	break;
					case "26":	$info_dtl = array ( 'tgl26' => $category_date );	break;
					case "27":	$info_dtl = array ( 'tgl27' => $category_date );	break;
					case "28":	$info_dtl = array ( 'tgl28' => $category_date );	break;
					case "29":	$info_dtl = array ( 'tgl29' => $category_date );	break;
					case "30":	$info_dtl = array ( 'tgl30' => $category_date );	break;
					case "31":	$info_dtl = array ( 'tgl31' => $category_date );	break;
					case "XX":	$info_dtl = array ( 'remark' => $category_date );	break;
					default: $info_dtl = array ( 'remark' => '' );
				}
						

				
				$this->db->where('nik',$nik);
				$this->db->where('nomor',$nomor);
				$this->db->where('planperiod',$planperiod);
				$this->db->where('urutcategory',$urutcategory);
				$this->db->update('sc_his.pdca_list_gen',$info_dtl);	
			
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
				if ($dtl_periode['status']=='I') {
					redirect("pdca/pdca/edit_pdca_berkala/$enc_nik/$enc_doctype/$enc_periode");
				} else {
					redirect("pdca/pdca/input_pdca_berkala/$enc_nik/$enc_doctype/$enc_periode");
				}
				
			} else {
				if ($dtl_periode['status']=='I') {
					redirect("pdca/pdca/edit_pdca_berkala/$enc_nik/$enc_doctype/$enc_periode");
				} else {
					redirect("pdca/pdca/input_pdca_berkala/$enc_nik/$enc_doctype/$enc_periode");
				}
			}
			
			
		} else {
			redirect('pdca/pdca/form_pdca');
		} 
		
	}
	
	function final_input_pdca_berkala(){
		$nama=trim($this->session->userdata('nik'));
		$nik=strtoupper($this->uri->segment(4));
		$periode=strtoupper($this->uri->segment(5));
		
		if (!empty($nik) or !empty($periode))	{
			$this->db->where('nik',$nik);
			$this->db->where('planperiod',$periode);
			$info = array (
				'status' => 'I'
			);
			$this->db->update('sc_his.pdca_list_gen',$info);
			
			$this->db->where('userid',$nama);
			$this->db->where('modul','PDCA');
			$this->db->delete('sc_mst.trxerror');
			/* error handling */
			$infotrxerror = array (
				'userid' => $nama,
				'errorcode' => 0,
				'nomorakhir1' => $periode,
				'nomorakhir2' => '',
				'modul' => 'PDCA',
			);
			$this->db->insert('sc_mst.trxerror',$infotrxerror);
			redirect("pdca/pdca/form_pdca");
		} else {
			$this->db->where('userid',$nama);
			$this->db->where('modul','PDCA');
			$this->db->delete('sc_mst.trxerror');
			/* error handling */
			$infotrxerror = array (
				'userid' => $nama,
				'errorcode' => 17,
				'nomorakhir1' => $nodok,
				'nomorakhir2' => '',
				'modul' => 'PDCA',
			);
			$this->db->insert('sc_mst.trxerror',$infotrxerror);
			redirect("pdca/pdca/form_pdca");
		}
	}
	
	function hapus_input_pdca_berkala(){
		$nik=trim($this->uri->segment(4));
		$periode=trim($this->uri->segment(5));
		$nama=trim($this->session->userdata('nik'));
		
		$this->db->where('nik',$nik);
		$this->db->where('planperiod',$periode);
		$this->db->delete('sc_his.pdca_list_gen');
		
		$this->db->where('userid',$nama);
		$this->db->where('modul','PDCA');
		$this->db->delete('sc_mst.trxerror');
		/* error handling */
		$infotrxerror = array (
			'userid' => $nama,
			'errorcode' => 0,
			'nomorakhir1' => $periode,
			'nomorakhir2' => '',
			'modul' => 'PDCA',
		);
		$this->db->insert('sc_mst.trxerror',$infotrxerror);
		redirect("pdca/pdca/form_pdca");
	}
	
	function form_report_pdca(){
		$data['title']="REPORT PLAN DO CHECK ACTION";	
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
								'vdate'      => date('2018-07-10 11:18:00'),
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

			$enc_nama=bin2hex($this->encrypt->encode($nama));
			$data['enc_nama']=bin2hex($this->encrypt->encode($nama));

		
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$inputfill=strtoupper(trim($this->input->post('inputfill')));	
		$tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));	
		$fnik=strtoupper(trim($this->input->post('nik')));	
		
		if (!empty($tglYM)) { $periode=$tglYM; } else { $periode=date('Ym'); }
		if (!empty($inputfill)) { $filtertype=" and docno='$inputfill'"; } else { $filtertype=""; }
		

		if(($userhr>0)){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";
			} else { 
				$param_list_akses=" and planperiod='$periode'";
			}
			$param_list_akses_nik="";
		} 
	//	else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan1)>0 and $userhr==0 ){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan='$nama')";	
			} else { 
				//$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
				$param_list_akses="and planperiod='$periode' and (nik_atasan='$nama' or nik='$nama')";	
			}
			$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan2)>0 and $userhr==0 ){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
			} else { 
				//$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				$param_list_akses="and planperiod='$periode' and (nik_atasan2='$nama' or nik='$nama')";	
			}
			$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				
		}
		else {
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";	
			} else { 
				$param_list_akses="and planperiod='$periode' and nik='$nama' ";
			}
				$param_list_akses_nik=" and nik='$nama' ";
		} 
		
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$param_doctype=" and doctype='ISD'";
		$parameter=$param_list_akses.$param_doctype;
		///$data['list_pdca']=$this->m_pdca->q_his_pdca_mst_param($param)->result();
		$data['list_pdca']=$this->m_pdca->q_view_periode_nik_pdca($parameter)->result();
		$data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
		$this->template->display('pdca/pdca/v_list_report_pdca',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_pdca->q_deltrxerror($paramerror);
	}
	
	function report_month_recapitulation(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
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
								'vdate'      => date('2018-07-10 11:18:00'),
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

		$param=" and nik='$nik' and planperiod='$planperiod' and doctype='$doctype' --AND status='P'";
		$paramniknya=" and nik='$nik'";
		$data['title']=" DETAIL PDCA KARYAWAN SATU BULAN ";
		$data['periode']='PERIODE  '.$planperiod;
		$data['dtlnik']=$this->m_akses->list_karyawan_param($paramniknya)->row_array();
		$data['list_pdca']=$this->m_pdca->q_pdca_recapitulation_of_the_month_oh_yes_oh_no_yes_no_ah_uh_ah_crooot($param)->result();
		///$data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
		$this->template->display('pdca/pdca/v_list_report_recapitulation_month',$data);
	}
	
	
	function sti_pdca_isidentil_report(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		
		$enc_nik=(trim($this->uri->segment(4)));
		$enc_doctype=(trim($this->uri->segment(5)));
		$enc_planperiod=(trim($this->uri->segment(6)));
	//	$data['jsonfile'] = "pdca/pdca/json_pdca_isidentil/$enc_nik/$enc_doctype/$enc_planperiod";
		$data['title']="Report PDCA ISIDENTIL";
		$data['jsonfile'] = "pdca/pdca/json_pdca_isidentil_report/$enc_nik/$enc_doctype/$enc_planperiod";
	///	$data['report_file'] = 'assets/mrt/sti_pdca_isidentil.mrt';
		$data['report_file'] = 'assets/mrt/sti_pdca_isidentil_report.mrt';
		$this->load->view("pdca/pdca/sti_v",$data);
	}
	
	function json_pdca_isidentil_report(){
		$nik=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$doctype=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
		$planperiod=$this->encrypt->decode(hex2bin(trim($this->uri->segment(6))));
		$nama=trim($this->session->userdata('nik'));
		///$this->db->query("select sc_his.pr_pdca_cetakpage('$nik', '$doctype', '$planperiod', '$nama');");
		///$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status in ('P','B')";
		$paramlist_2=" and nik='$nik' and doctype='$doctype'  and planperiod='$planperiod' and status='P'";
				
		$datarekap = $this->m_pdca->q_pdca_rekap_isd_report($paramlist)->result();
		///$datamst = $this->m_pdca->q_view_mst_isd_cetak($paramlist_2)->result();
		$datadtl = $this->m_pdca->q_pdca_dtl_isd_report($paramlist)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'rekap' => $datarekap,
				//'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	
	function php_test(){
		////   $tahun='2017';
		////   $bulan='12';
		////   
		////   $a_date=$tahun.'-'.$bulan;
		////   echo $cekdate=date("t",strtotime($a_date));
		////   echo '</br>';
		////   $periode='201712';
		////   echo $cekdate2=date("t",strtotime($periode));
		////   echo '</br>';
		////   
		////   $test='27-12-2017 12:00 - 28-12-2017 12:00';
		////   $qtytime_date=explode(' - ',$test);
		////   echo $qtytime_date1=date('Y-m-d',strtotime($qtytime_date[0]));
		////   echo '</br>';
		////   echo $qtytime_date2=date('Y-m-d',strtotime($qtytime_date[1]));
		////   
		
		echo $kisi=('2018-01-02' < date('Y-m-d'));
	}
	
}