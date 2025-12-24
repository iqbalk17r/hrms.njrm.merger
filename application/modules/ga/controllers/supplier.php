<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Supplier extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('m_kendaraan','master/m_akses','m_supplier'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/supplier/v_index',$data);
	}
	
	function form_msupplier(){
		$data['title']="&nbsp MASTER SUPPLIER";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.7';
						$versirelease='I.G.D.7/ALPHA.001';
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
		else if($this->uri->segment(4)=="inp_fail")
            $data['message']="<div class='alert alert-danger'>Kode Sudah Ada Sebelumnya</div>";
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
		$data['list_scgroup']=$this->m_supplier->q_scgroup_supplier()->result();
		$data['list_supplier']=$this->m_supplier->q_supplier()->result();
        $this->template->display('ga/supplier/v_msupplier',$data);
	}
	
	function save_supplier(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		////$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$kdsupplier=strtoupper($this->input->post('kdsupplier'));
		$nmsupplier=strtoupper($this->input->post('nmsupplier'));
		////$addsupplier=strtoupper($this->input->post('addsupplier'));
		////$phone1=strtoupper($this->input->post('phone1'));
		////$phone2=strtoupper($this->input->post('phone2'));
		////$fax=strtoupper($this->input->post('fax'));
		////$email=strtoupper($this->input->post('email'));
		////$ownsupplier=strtoupper($this->input->post('ownsupplier'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		if ($type=='INPUT'){
			$param=" and kdsupplier='$kdsupplier'";
			$cekmst=$this->m_supplier->q_supplier_param($param)->num_rows();
			if ($cekmst==0) {
				$info = array (
						'kdsupplier' => $kdgroup.$kdsupplier,
						'kdgroup' => $kdgroup,
						'nmsupplier' => $nmsupplier,
						'status' => 'I',
						'inputdate' => $inputdate,
						'inputby' => $inputby,
						'keterangan' => $keterangan,
				);
				$this->db->insert('sc_mst.msupplier',$info);
				redirect("ga/supplier/form_msupplier/inp_succes");
			} else {
				redirect("ga/supplier/form_msupplier/inp_fail");
			}
		} else if ($type=='EDIT') {
				$info = array (
						'nmsupplier' => $nmsupplier,
						'keterangan' => $keterangan,
						'updatedate' => date('Y-m-d H:i:s'),
						'updateby' => $nama,
				);
				$this->db->where('kdsupplier',$kdsupplier);
				$this->db->update('sc_mst.msupplier',$info);
				redirect("ga/supplier/form_msupplier/inp_succes");
		}  else if ($type=='DELETE') {
				$param=" and kdsupplier='$kdsupplier'";
				$cekdtl=$this->m_supplier->q_subsupplier_param($param)->num_rows();
				if($cekdtl==0){
					$this->db->where('kdsupplier',$kdsupplier);
					$this->db->delete('sc_mst.msupplier');
					redirect("ga/supplier/form_msupplier/del_succes");
				} else {
					redirect("ga/supplier/form_msupplier/del_failed");
				}

		} else {
			redirect("ga/supplier/form_msupplier/fail_data");
		}
	}

	function form_msubsupplier(){
		$kdsupplier=trim($this->uri->segment(4));
		$data['title']="&nbsp LIST MASTER SUB SUPPLIER";
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.7';
						$versirelease='I.G.D.7/ALPHA.001';
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
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada Sebelumnya</div>";
		else if($this->uri->segment(5)=="wrong_format")
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
		if (!empty($kdsupplier) or $kdsupplier<>'')	{
			$param1=" and kdsupplier='$kdsupplier'";
		} else {
			$param1="";
		}
		$data['list_scgroup']=$this->m_supplier->q_scgroup_supplier()->result();
		$data['list_supplier']=$this->m_supplier->q_supplier()->result();
		$data['list_kanwil']=$this->m_supplier->q_mstkantor()->result();
		$data['list_subsupplier']=$this->m_supplier->q_subsupplier_param($param1)->result();
		$data['dtl']=$this->m_supplier->q_supplier_param($param1)->row_array();
        $this->template->display('ga/supplier/v_msubsupplier',$data);
	}

	function save_subsupplier(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		$kdsupplier=strtoupper(trim($this->input->post('kdsupplier')));
		$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
		$kdsubsupplier=strtoupper(trim($this->input->post('kdsubsupplier')));
		$nmsubsupplier=strtoupper(trim($this->input->post('nmsubsupplier')));
		$addsupplier=strtoupper(trim($this->input->post('addsupplier')));
		$pkp=strtoupper(trim($this->input->post('pkp')));
		$pkpname=strtoupper(trim($this->input->post('pkpname')));
		$phone1=strtoupper($this->input->post('phone1'));
		$phone2=strtoupper($this->input->post('phone2'));
		$fax=strtoupper($this->input->post('fax'));
		$email=strtoupper($this->input->post('email'));
		$ownsupplier=strtoupper($this->input->post('ownsupplier'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		if(empty($kdsupplier)){
			redirect("ga/supplier/form_msubsupplier");
		}
		
		if ($type=='INPUT'){
			$param1=" and kdsupplier='$kdsupplier' ";
			$param2=" and nmsubsupplier='$nmsubsupplier' ";
			$cekdouble=$this->m_supplier->q_subsupplier_param2($param1,$param2)->num_rows();
			if($cekdouble>0){
				redirect("ga/supplier/form_msubsupplier/$kdsupplier/inp_kembar");
			}
			
				$info = array (
						'kdsupplier' => $kdsupplier,   
						'kdsubsupplier' => $kdsubsupplier,   
						'nmsubsupplier' => $nmsubsupplier,   
						'kdcabang' => $kdcabang,      
						'addsupplier' => $addsupplier,   
						'pkp' => $pkp,   
						'pkpname' => $pkpname,   
						'phone1' => $phone1,   
						'phone2' => $phone2,   
						'fax' => $fax,   
						'email' => $email,   
						'ownsupplier' => $ownsupplier,   
						'status' => 'I',       
						'inputdate' => $inputdate,    
						'inputby' => $inputby,      
						'keterangan' => $keterangan,  
						'id' => 0,  
				);
				$this->db->insert('sc_mst.msubsupplier',$info);
				redirect("ga/supplier/form_msubsupplier/$kdsupplier/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
						'nmsubsupplier' => $nmsubsupplier,   
						'kdcabang' => $kdcabang,      
						'addsupplier' => $addsupplier,
						'pkp' => $pkp,   
						'pkpname' => $pkpname,						
						'phone1' => $phone1,   
						'phone2' => $phone2,   
						'fax' => $fax,   
						'email' => $email,   
						'ownsupplier' => $ownsupplier, 
						'keterangan' => $keterangan,
						'updatedate' => date('Y-m-d H:i:s'),
						'updateby' => $nama,
				);
				$this->db->where('kdsupplier',$kdsupplier);
				$this->db->where('kdsubsupplier',$kdsubsupplier);
				$this->db->update('sc_mst.msubsupplier',$info);
				redirect("ga/supplier/form_msubsupplier/$kdsupplier/up_succes");
		} else if ($type=='DELETE') {
				$this->db->where('kdsupplier',$kdsupplier);
				$this->db->where('kdsubsupplier',$kdsubsupplier);
				$this->db->delete('sc_mst.msubsupplier');
				redirect("ga/supplier/form_msubsupplier/$kdsupplier/del_succes");
		} else {
			redirect("ga/supplier/form_msubsupplier/fail_data");
		}
	}
	
	function hapus_supplier(){
		$kdsupplier=$this->uri->segment(4);
		$this->db->where('kdsupplier',$kdsupplier);
		$this->db->delete('sc_mst.msubsupplier');
		redirect("ga/supplier/form_msupplier/$kdsupplier/del_succes");
	}
	
	
}