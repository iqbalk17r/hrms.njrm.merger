<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Mtsasset extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_kendaraan','master/m_akses','m_mtsasset'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/mtsasset/v_index',$data);
	}
	
	function form_skmemo(){
		$data['title']="INPUT (SK) MEMO UNTUK MUTASI ASSET";
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.1';
						$versirelease='I.G.F.1/ALPHA.001';
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
        /* */
        $tgl=explode(' - ',$this->input->post('tgl'));
        if(!empty($this->input->post('tgl')) or ($this->input->post('tgl'))<>'') {
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $paramdate=" and to_char(tgldok,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
        } else {
            $paramdate=" and to_char(tgldok,'yyyymm') = to_char(now(),'yyyymm') ";
        }
        $parameter=$paramdate;
						/* END CODE UNTUK VERSI */
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_mtsasset->q_masuransi()->result();
		$data['list_skmemo']=$this->m_mtsasset->q_skmemo($parameter)->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_skmemo',$data);
								
	}
	
	function save_skmemo(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nodok=strtoupper($this->input->post('nodok'));                   
		$kdbarang=strtoupper($this->input->post('kdbarang'));                   
		$kdgudang=strtoupper($this->input->post('kdgudang'));                   
		$oldkdgudang=strtoupper($this->input->post('oldkdgudang'));                   
		$olduserpakai=strtoupper($this->input->post('olduserpakai'));
		$userpakai=strtoupper($this->input->post('userpakai'));
		$nosk=strtoupper($this->input->post('nosk'));
		$tglev=strtoupper($this->input->post('tglev'));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		
		if ($type=='INPUT'){
				$info = array (
					'nodok' => $nama,        
				    'nodokref' => '',     
				    'kdbarang' => $kdbarang, 
					'userpakai' => $userpakai, 					
					'kdgudang' => $kdgudang, 					
				    'oldkdgudang' => $oldkdgudang,      
				    'olduserpakai' => $olduserpakai, 					
				    'nosk' => $nosk,         
				    'tgldok' => $inputdate,       
				    'tglev' => $tglev,        
				    'keterangan' => $keterangan,   
				    'status' => 'I',       
				    'inputdate' => $inputdate,    
				    'inputby' => $inputby,      
			 
				);
				$this->db->insert('sc_tmp.sk_mtsasset',$info);
				redirect("ga/mtsasset/form_skmemo/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
					     
				    'kdbarang' => $kdbarang, 
					'userpakai' => $userpakai, 					
					'kdgudang' => $kdgudang, 					
				    'oldkdgudang' => $oldkdgudang,      
				    'olduserpakai' => $olduserpakai, 					
				    'nosk' => $nosk,         
				    'tgldok' => $inputdate,       
				    'tglev' => $tglev,        
				    'keterangan' => $keterangan,   
				    'status' => 'A',       
				    'updatedate' => $inputdate,    
				    'updateby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.sk_mtsasset',$info);
				redirect("ga/mtsasset/form_skmemo/inp_succes");
		} else if ($type=='APPROVAL') {
				$info = array (
  
				    'status' => 'P',       
				    'approvaldate' => $inputdate,    
				    'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.sk_mtsasset',$info);
				redirect("ga/mtsasset/form_skmemo/app_succes");
		}  else if ($type=='DELETE') {
				$this->db->where('nodok',$nodok);
				$this->db->delete('sc_his.sk_mtsasset');
				redirect("ga/mtsasset/form_skmemo/del_succes");
		}  else {
			redirect("ga/mtsasset/form_skmemo/fail_data");
		}	
	}
	
	function filter_mtsasset(){
				$data['title']="FILTER DATA MUTASI ASSET";	
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.2';
						$versirelease='I.G.F.2/ALPHA.001';
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
			$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
			$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
			$this->template->display('ga/mtsasset/v_filter_mtsasset',$data);
	}
	
	function form_mtsasset(){
		$data['title']="MUTASI ASSET KENDARAAN";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
	//$tglist=str_replace('%20',' ',$this->input->post('tgl'));
	//$tgl=explode(' - ',str_replace('%20',' ',$this->input->post('tgl')));
	//$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
	//$tglawal=date('Y-m-d', strtotime(trim($tgl[0])));
	//$tglakhir=date('Y-m-d', strtotime(trim($tgl[1])));
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.2';
						$versirelease='I.G.F.2/ALPHA.001';
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

		/*				
		if(empty($kdcabang)) {
			redirect("ga/mtsasset/filter_mtsasset");
		} */
		
	//if(!empty($kdcabang) and $kdcabang<>'ALL') { $param1=" and a.kdgudang='$kdcabang'"; } else { $param1=""; };
	//if(!empty($tglawal)) { $param2=" and (to_char(a.tglev,'yyyy-mm-dd') between '$tglawal' and '$tglakhir')"; } else { $param2=""; } ;
	////if(!empty($kdgroup) and $kdgroup<>'ALL') { $param3=" and x.kdgroup='$kdgroup'";  } else { $param3=""; } ;
        $tgl=explode(' - ',$this->input->post('tgl'));
        if(!empty($this->input->post('tgl')) or ($this->input->post('tgl'))<>'') {
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $paramdate=" and to_char(tgldok,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
        } else {
            $paramdate=" and to_char(tgldok,'yyyymm') = to_char(now(),'yyyymm') ";
        }

        $parameter = $paramdate;
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_mutasi']=$this->m_mtsasset->q_mutasiasset($parameter)->result();
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_bengkel']=$this->m_mtsasset->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_skmemofinal']=$this->m_mtsasset->q_skmemofinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_mtsasset',$data);
	}
	
	function flist_skfinal(){
		$data['title']="LIST SURAT SK MEMO FINAL";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.2';
						$versirelease='I.G.F.2/ALPHA.001';
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
		$ceknon=$this->uri->segment(4);
		if($ceknon<>'PxwoOnoandoI'){ redirect("ga/mtsasset/form_mtsasset"); }
		
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_mtsasset->q_masuransi()->result();
		//$data['list_skmemo']=$this->m_mtsasset->q_skmemo()->result();
		$data['list_skmemofinal']=$this->m_mtsasset->q_skmemofinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_flist_skfinal',$data);
	}
	
	function inputmutasi_skfinal(){
		$nodokref=$this->uri->segment(4);
		$data['title']="INPUT MUTASI ASSET DOKUMEN REFERENSI = $nodokref";	
		if($nodokref==''){ redirect("ga/mtsasset/form_mtsasset"); }
		
		$data['dtl']=$this->m_mtsasset->q_skmemofinalparam($nodokref)->row_array();
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_mtsasset->q_masuransi()->result();
		//$data['list_skmemo']=$this->m_mtsasset->q_skmemo()->result();
		$data['list_skmemofinal']=$this->m_mtsasset->q_skmemofinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_inp_mtsasset',$data);
	}

	function save_mtsasset(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nodok=strtoupper($this->input->post('nodok'));                   
		$kdbarang=strtoupper($this->input->post('kdbarang'));                   
		$kdgudang=strtoupper($this->input->post('kdgudang'));                   
		$oldkdgudang=strtoupper($this->input->post('oldkdgudang'));                   
		$olduserpakai=strtoupper($this->input->post('olduserpakai'));
		$userpakai=strtoupper($this->input->post('userpakai'));
		$nosk=strtoupper($this->input->post('nosk'));
		$tglev=strtoupper($this->input->post('tglev'));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		
		if ($type=='INPUT'){
				$info = array (
					'nodok' => $nama,        
				    'nodokref' => $nodok,     
				    'kdbarang' => $kdbarang, 
					'userpakai' => $userpakai, 					
					'kdgudang' => $kdgudang, 					
				    'oldkdgudang' => $oldkdgudang,      
				    'olduserpakai' => $olduserpakai, 					
				    'nosk' => $nosk,         
				    'tgldok' => $inputdate,       
				    'tglev' => $tglev,        
				    'keterangan' => $keterangan,   
				    'status' => 'I',       
				    'inputdate' => $inputdate,    
				    'inputby' => $inputby,      
			 
				);
				$this->db->insert('sc_tmp.mtsasset',$info);
				redirect("ga/mtsasset/form_mtsasset/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
					     
				    'kdbarang' => $kdbarang, 
					'userpakai' => $userpakai, 					
					'kdgudang' => $kdgudang, 					
				    'oldkdgudang' => $oldkdgudang,      
				    'olduserpakai' => $olduserpakai, 					
				    'nosk' => $nosk,         
				    'tgldok' => $inputdate,       
				    'tglev' => $tglev,        
				    'keterangan' => $keterangan,   
				    'status' => 'A',       
				    'updatedate' => $inputdate,    
				    'updateby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.mtsasset',$info);
				redirect("ga/mtsasset/form_mtsasset/inp_succes");
		} else if ($type=='APPROVAL') {
				$info = array (
  
				    'status' => 'P',       
				    'approvaldate' => $inputdate,    
				    'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.mtsasset',$info);
				redirect("ga/mtsasset/form_mtsasset/app_succes");
		}  else if ($type=='DELETE') {
				$info = array (
  				    'status' => 'C',       
				    'approvaldate' => $inputdate,    
				    'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.mtsasset',$info);
				redirect("ga/mtsasset/form_mtsasset/del_succes");
		}  else {
			redirect("ga/mtsasset/form_mtsasset/fail_data");
		}	
	}
	
	function form_st_mtsasset(){
		$data['title']="SERAH TERIMA MUTASI BARANG & ASSET";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
	//$tglist=str_replace('%20',' ',$this->input->post('tgl'));
	//$tgl=explode(' - ',str_replace('%20',' ',$this->input->post('tgl')));
	//$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
	//$tglawal=date('Y-m-d', strtotime(trim($tgl[0])));
	//$tglakhir=date('Y-m-d', strtotime(trim($tgl[1])));
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.3';
						$versirelease='I.G.F.3/ALPHA.001';
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

		/*				
		if(empty($kdcabang)) {
			redirect("ga/mtsasset/filter_mtsasset");
		} */
		
	//if(!empty($kdcabang) and $kdcabang<>'ALL') { $param1=" and a.kdgudang='$kdcabang'"; } else { $param1=""; };
	//if(!empty($tglawal)) { $param2=" and (to_char(a.tglev,'yyyy-mm-dd') between '$tglawal' and '$tglakhir')"; } else { $param2=""; } ;
	////if(!empty($kdgroup) and $kdgroup<>'ALL') { $param3=" and x.kdgroup='$kdgroup'";  } else { $param3=""; } ;

		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_mutasi_st']=$this->m_mtsasset->q_mutasiasset_st()->result();
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_bengkel']=$this->m_mtsasset->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_skmemofinal']=$this->m_mtsasset->q_skmemofinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_st_mtsasset',$data);
	
	}
	
	function flist_mtassetfinal(){
		$data['title']="LIST MUTASI ASSET FINAL";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.2';
						$versirelease='I.G.F.2/ALPHA.001';
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
		$ceknon=$this->uri->segment(4);
		if($ceknon<>'PxwoOnoandoI'){ redirect("ga/mtsasset/form_st_mtsasset"); }
		
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_mtsasset->q_masuransi()->result();
		//$data['list_skmemo']=$this->m_mtsasset->q_skmemo()->result();
		$data['list_mutasifinal']=$this->m_mtsasset->q_mtsassetfinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_flist_mtsassetfinal',$data);
	}
	
	function serahterima_mtsassetfinal(){
		$nodokref=$this->uri->segment(4);
		$data['title']="FORM BUKTI SERAH TERIMA BARANG REF MUTASI = $nodokref";	
		if($nodokref==''){ redirect("ga/mtsasset/form_st_mtsasset"); }
		
		$data['dtl']=$this->m_mtsasset->q_mtsassetfinalparam($nodokref)->row_array();
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_mtsasset->q_masuransi()->result();
		//$data['list_skmemo']=$this->m_mtsasset->q_skmemo()->result();
		$data['list_mutasifinal']=$this->m_mtsasset->q_mtsassetfinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_inp_stmtsasset',$data);
	}
	
	/* save serah terima barang */
	function save_mtsasset_st(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nodok=strtoupper($this->input->post('nodok'));                   
		$kdbarang=strtoupper($this->input->post('kdbarang'));                   
		$kdgudang=strtoupper($this->input->post('kdgudang'));                   
		$oldkdgudang=strtoupper($this->input->post('oldkdgudang'));                   
		$olduserpakai=strtoupper($this->input->post('olduserpakai'));
		$userpakai=strtoupper($this->input->post('userpakai'));
		$usertau=strtoupper($this->input->post('usertau'));
		$nosk=strtoupper($this->input->post('nosk'));
		$tglev=strtoupper($this->input->post('tglev'));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		
		if ($type=='INPUT'){
				$info = array (
					'nodok' => $nama,        
				    'nodokref' => $nodok,     
				    'kdbarang' => $kdbarang, 
					'userpakai' => $userpakai, 					
					'usertau' => $usertau, 					
					'kdgudang' => $kdgudang, 					
				    'oldkdgudang' => $oldkdgudang,      
				    'olduserpakai' => $olduserpakai, 					
				    'nosk' => $nosk,         
				    'tgldok' => $inputdate,       
				    'tglev' => $tglev,        
				    'keterangan' => $keterangan,   
				    'status' => 'I',       
				    'inputdate' => $inputdate,    
				    'inputby' => $inputby,      
			 
				);
				$this->db->insert('sc_tmp.mtsasset_st',$info);
				redirect("ga/mtsasset/form_st_mtsasset/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
					     
				    'kdbarang' => $kdbarang, 
					'userpakai' => $userpakai,
					'usertau' => $usertau, 					
					'kdgudang' => $kdgudang, 					
				    'oldkdgudang' => $oldkdgudang,      
				    'olduserpakai' => $olduserpakai, 					
				    'nosk' => $nosk,         
				    'tgldok' => $inputdate,       
				    'tglev' => $tglev,        
				    'keterangan' => $keterangan,   
				    'status' => 'A',       
				    'updatedate' => $inputdate,    
				    'updateby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.mtsasset_st',$info);
				redirect("ga/mtsasset/form_st_mtsasset/inp_succes");
		} else if ($type=='APPROVAL') {
				$info = array (
  
				    'status' => 'P',       
				    'approvaldate' => $inputdate,    
				    'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.mtsasset_st',$info);
				redirect("ga/mtsasset/form_st_mtsasset/app_succes");
		}  else if ($type=='DELETE') {
				$info = array (
  				    'status' => 'C',       
				    'approvaldate' => $inputdate,    
				    'approvalby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.mtsasset_st',$info);
				redirect("ga/mtsasset/form_st_mtsasset/del_succes");
		}  else {
			redirect("ga/mtsasset/form_st_mtsasset/fail_data");
		}	
	}
	
	function penghapusan_asset(){
			$data['title']="FILTER DATA UNTUK PENGHAPUSAN ASSET";	
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.5';
						$versirelease='I.G.F.5/ALPHA.001';
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
			$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
			$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
			$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
			$this->template->display('ga/mtsasset/v_filter_hpusasset',$data);
	}
	

	function flist_hapusasset(){
		$data['title']="LIST ASSET UNTUK PROSES PENGHAPUSAN";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.5';
						$versirelease='I.G.F.5/ALPHA.001';
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
		$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		
		if(empty($kdcabang) and $kdcabang==''){ $param1=""; } else { $param1=" and kdgudang='$kdcabang' "; }
		if(empty($kdgroup) and $kdgroup==''){ $param2=""; } else { $param2=" and kdgroup='$kdgroup' "; }
		if(empty($kdsubgroup) and $kdsubgroup==''){ $param3=""; } else { $param3=" and kdsubgroup='$kdsubgroup' "; }
		
		$data['list_barang']=$this->m_mtsasset->q_listassetparam($param1,$param2,$param3)->result();
		$this->template->display('ga/mtsasset/v_flist_hapusasset',$data);
	}
	
	function input_hapusasset(){
		$nodok=$this->uri->segment(4);
		$data['title']="FORM BUKTI PENGHAPUSAN ASSET = $nodok";	
		if($nodok==''){ redirect("ga/mtsasset/penghapusan_asset"); }
		$param1=" and nodok='$nodok' ";
		$data['dtl']=$this->m_mtsasset->q_listassetinput($param1)->row_array();
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_mtsasset->q_masuransi()->result();
		//$data['list_skmemo']=$this->m_mtsasset->q_skmemo()->result();
		$data['list_mutasifinal']=$this->m_mtsasset->q_mtsassetfinal()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$this->template->display('ga/mtsasset/v_inp_hapusasset',$data);
	}
		/* save input hapus asset */
	function save_input_hapusasset(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$nodok=strtoupper($this->input->post('nodok'));                   
		$kdbarang=strtoupper($this->input->post('kdbarang'));                   
		$kdgudang=strtoupper($this->input->post('kdgudang'));                   
		$userpakai=strtoupper($this->input->post('userpakai'));
		$usertau=strtoupper($this->input->post('usertau'));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		
		if ($type=='INPUT'){
				$info = array (
					'branch' => $branch,
					'nodok' => $nama,
					'kdbarang' => $kdbarang,
					'keterangan_hps' => $keterangan,
					'usertau' => $usertau,
					'status' => 'A',
					'deletedate' => $inputdate,
					'deleteby' => $inputby,
				);
				$this->db->insert('sc_tmp.mbarang_hps',$info);
				redirect("ga/mtsasset/inquiry_penghapusan_asset/$kdbarang/inp_succes");
		} else if ($type=='APPROVAL') {
					$info = array (
	  
						'status' => 'P',       
						'updatedate' => $inputdate,    
						'updateby' => $inputby,
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_his.mbarang_hps',$info);
					redirect("ga/mtsasset/inquiry_penghapusan_asset/app_succes");
		}  else {
				redirect("ga/mtsasset/form_st_mtsasset/fail_data");
		}	
	}
	
	function inquiry_penghapusan_asset(){
		$data['title']="LIST & INQUIRY PENGHAPUSAN ASSET ";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.F.6';
						$versirelease='I.G.F.6/ALPHA.001';
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
		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Approval</div>";
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
						/* END CODE UNTUK VERSI */
/*		$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		
		if(empty($kdcabang) and $kdcabang==''){ $param1=""; } else { $param1=" and kdgudang='$kdcabang' "; }
		if(empty($kdgroup) and $kdgroup==''){ $param2=""; } else { $param2=" and kdgroup='$kdgroup' "; }
		if(empty($kdsubgroup) and $kdsubgroup==''){ $param3=""; } else { $param3=" and kdsubgroup='$kdsubgroup' "; } */
		$data['list_barang']=$this->m_mtsasset->q_listbarang()->result();
		$data['list_scgroup']=$this->m_mtsasset->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_mtsasset->q_scsubgroup()->result();
		$data['list_kanwil']=$this->m_mtsasset->q_mstkantor()->result();
		$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		$data['list_mbarang_hps']=$this->m_mtsasset->q_listmbarang_hps()->result();
		$this->template->display('ga/mtsasset/v_flist_inqhpsasset',$data);
	}
}