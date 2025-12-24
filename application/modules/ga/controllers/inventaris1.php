<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Inventaris extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('m_kendaraan','master/m_akses','m_inventaris'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','Excel_generator')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/inventaris/v_index',$data);
	}
	function js_master_stock(){
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
		
		
		$param1=$param_buff1_1.$param_buff2_1.$param_buff3_1;
		
		$data = $this->m_inventaris->q_mbarang_param($param1)->row_array();
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
		
		$data = $this->m_inventaris->q_stkgdw_param1($param1)->row_array();
		echo json_encode($data, JSON_PRETTY_PRINT);
	
	}
	
	function form_scbarang(){
		$data['title']="SKEMA BARANG & ASSET";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.1';
						$versirelease='I.G.D.1/ALPHA.001';
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
		$data['list_scbarang']=$this->m_inventaris->q_scgroup()->result();
		$data['dtl_scsubgroup']=$this->m_inventaris->q_scgroup()->row_array();
        $this->template->display('ga/inventaris/v_scbarang',$data);
	}
	
	function input_scbarang(){
		$nama=$this->session->userdata('nama');
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$nmgroup=strtoupper($this->input->post('nmgroup'));
		$grouphold=strtoupper($this->input->post('grouphold'));
		//$groupreminder=strtoupper($this->input->post('groupreminder'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));

		
		if ($type=='INPUT'){
			$ceksc=$this->m_inventaris->q_cekscgroup($kdgroup)->num_rows();
			if($ceksc>0){
				redirect("ga/inventaris/form_scbarang/inp_kembar");
			}
				$info = array (
					'branch' => $branch,
					'kdgroup' => $kdgroup,
					'nmgroup' => $nmgroup,
					'grouphold' => $grouphold,
					'keterangan' => $keterangan,
					'inputdate' => date('Y-m-d H:i:s'),
					'inputby' => $nama,
				);
				$this->db->insert('sc_mst.mgroup',$info);
				redirect("ga/inventaris/form_scbarang/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
					'nmgroup' => $nmgroup,
					'grouphold' => $grouphold,
					'keterangan' => $keterangan,
					'updatedate' => date('Y-m-d H:i:s'),
					'updateby' => $nama,
				);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->update('sc_mst.mgroup',$info);
				redirect("ga/inventaris/form_scbarang/inp_succes");
		} else {
			redirect("ga/inventaris/form_scbarang/fail_data");
		}
	}
	
	function del_scbarang(){
		$nama=$this->session->userdata('nama');
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$nmgroup=strtoupper($this->input->post('nmgroup'));
		$grouphold=strtoupper($this->input->post('grouphold'));
		$groupreminder=strtoupper($this->input->post('groupreminder'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$ceksubgroup=$this->m_inventaris->q_cekscsubgroup($kdgroup)->num_rows();
		if ($ceksubgroup>0) {
			redirect("ga/inventaris/form_scbarang/del_succes");
		} else {
			$this->db->where('kdgroup',$kdgroup);
			$this->db->delete('sc_mst.mgroup');
			redirect("ga/inventaris/form_scbarang/del_succes"); 
		}
	}
	
	function form_scsubbarang(){
		$data['title']="SUB SKEMA BARANG & ASSET";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
										/* CODE UNTUK VERSI */
						$kodemenu='I.G.D.6';
						$versirelease='I.G.D.6/ALPHA.001';
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
		$data['list_msubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_mgroup']=$this->m_inventaris->q_scgroup()->result();
        $this->template->display('ga/inventaris/v_scsubbarang',$data);
	}
	
	
	function input_msubgroup(){
		$nama=$this->session->userdata('nama');
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$nmgroup=strtoupper($this->input->post('nmgroup'));
		$ujikir=strtoupper($this->input->post('ujikir'));
		$grouphold=strtoupper($this->input->post('grouphold'));
		//$groupreminder=strtoupper($this->input->post('groupreminder'));
		$keterangan=strtoupper($this->input->post('keterangan'));
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		if ($type=='INPUT'){
			$ceksc=$this->m_inventaris->q_cekscsubgroup_2p($kdgroup,$kdsubgroup)->num_rows();
			if($ceksc>0){
				redirect("ga/inventaris/form_scsubbarang/inp_kembar");
			}
				$info = array (
					'branch' => $branch,
					'kdsubgroup' => $kdsubgroup,
					'kdgroup' => $kdgroup,
					'nmsubgroup' => $nmgroup,
					'ujikir' => $ujikir,
					'grouphold' => $grouphold,
					'keterangan' => $keterangan,
					'inputdate' => date('Y-m-d H:i:s'),
					'inputby' => $nama,
				);
				$this->db->insert('sc_mst.msubgroup',$info);
				redirect("ga/inventaris/form_scsubbarang/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
					'branch' => $branch,
					'nmsubgroup' => $nmgroup,
					'ujikir' => $ujikir,
					'grouphold' => $grouphold,
					'keterangan' => $keterangan,
					'updatedate' => date('Y-m-d H:i:s'),
					'updateby' => $nama,
				);
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->update('sc_mst.msubgroup',$info);
				redirect("ga/inventaris/form_scsubbarang/inp_succes");
		} else if ($type=='DELETE') {
				$this->db->where('kdgroup',$kdgroup);
				$this->db->where('kdsubgroup',$kdsubgroup);
				$this->db->delete('sc_mst.msubgroup');
				redirect("ga/inventaris/form_scsubbarang/del_succes");
		}
		else {
			redirect("ga/inventaris/form_scsubbarang/fail_data");
		}
	}
	
	
	/* 01 ---- MASTER BARANG & ATK*/
	function form_mstbarang(){
		$data['title']="FORM MASTER BARANG";	
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		
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
						
			
		if (!empty($stockcode) or ($stockcode!='')) {
			$param=" and nodok='$stockcode'";
		} else {
			$param="";
		}	
		$data['list_mstbarang']=$this->m_inventaris->q_mst_barang_param($param)->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$this->template->display('ga/inventaris/v_mstbarang',$data);
								
	}
	
	function edit_view_mst_brg(){
		$data['title']="UBAH MASTER BARANG";
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
		else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
			$data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
			$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
			$data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
			$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else
			$data['message']='';
		$param=" and nodok='$nodok'";				
		$data['dtl_mstbarang']=$this->m_inventaris->q_mst_barang_param($param)->row_array();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$this->template->display('ga/inventaris/v_edit_master_brg',$data);
	}
	
	function hapus_view_mst_brg(){
		$data['title']="HAPUS MASTER BARANG";
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
		else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
			$data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
			$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
			$data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
			$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else
			$data['message']='';
		$param=" and nodok='$nodok'";				
		$data['dtl_mstbarang']=$this->m_inventaris->q_mst_barang_param($param)->row_array();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$this->template->display('ga/inventaris/v_hapus_master_brg',$data);
	}
	
	function detail_view_mst_brg(){
		$data['title']="DETAIL MASTER BARANG";
		$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
		else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
			$data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
			$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
			$data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
			$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else
			$data['message']='';
		$param=" and nodok='$nodok'";				
		$data['dtl_mstbarang']=$this->m_inventaris->q_mst_barang_param($param)->row_array();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$this->template->display('ga/inventaris/v_detail_master_brg',$data);
	}
	
	function input_mstbarang(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nmbarang=str_replace('"',' ',strtoupper(trim($this->input->post('nmbarang'))));
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		
		$satkecil=strtoupper(trim($this->input->post('satkecil')));
		$typebarang=strtoupper(trim($this->input->post('typebarang')));
		$expdate=strtoupper(trim($this->input->post('expdate')));

		$hold_item=strtoupper(trim($this->input->post('hold_item')));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		
		if ($type=='INPUT'){
				$info = array (
						'branch' => $branch,
						'nodok' => $nama,
						'nmbarang' => $nmbarang,
						'kdgroup' => $kdgroup,
						'kdsubgroup' => $kdsubgroup,
						'satkecil' => $satkecil,
						'typebarang' => $typebarang,
						'hold_item' => $hold_item,
						'keterangan' => $keterangan,
						'inputdate' => $inputdate,
						'inputby' => $inputby,
				);
				$this->db->insert('sc_tmp.mbarang',$info);
				redirect("ga/inventaris/form_mstbarang/inp_succes");
			
		} else if ($type=='EDIT') {
				$info = array (
					
						'nmbarang' => $nmbarang,
						'typebarang' => $typebarang,
						'hold_item' => $hold_item,
						'keterangan' => $keterangan,
						'updatedate' => $inputdate,
						'updateby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_mst.mbarang',$info);
				redirect("ga/inventaris/form_mstbarang/inp_succes");
		}  else if ($type=='HAPUS') {
				$this->db->where('nodok',$nodok);
				$this->db->delete('sc_mst.mbarang');
				redirect("ga/inventaris/form_mstbarang/del_succes");
		}  else {
			redirect("ga/inventaris/form_mstbarang/fail_data");
		}

		
	}
	
	/************** FORM PERAWATAN ASET ***********************/
	function form_perawatan(){
		$data['title']="FORM PERAWATAN ASSET";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.E.1';
						$versirelease='I.G.E.1/ALPHA.001';
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
		

		if($this->uri->segment(4)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
        else if($this->uri->segment(4)=="inp_succes"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Data Sukses Disimpan $nodoktmp </div>";
		}           
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_fail")
            $data['message']="<div class='alert alert-danger'>Data sudah tercatat Final tidak dapat Hapus</div>";
		else if($this->uri->segment(4)=="input_fail")
            $data['message']="<div class='alert alert-danger'>Data sudah tercatat Final tidak dapat Input</div>";
		else if($this->uri->segment(4)=="edit_succes"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah $nodoktmp</div>";
		}

		else if($this->uri->segment(4)=="edit_fail")
            $data['message']="<div class='alert alert-danger'>Data sudah tercatat Final tidak dapat edit</div>";
		else if($this->uri->segment(4)=="approval_fail")
            $data['message']="<div class='alert alert-danger'>Data sudah tercatat Final tidak dapat Approval</div>";
		else if($this->uri->segment(4)=="cancel_fail"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-danger'>Data Sedang Diakses Oleh User $nodoktmp </div>";	
		} 
		else if($this->uri->segment(4)=="process_fail"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-danger'>Data Sudah Terproses/Diakses Oleh User $nodoktmp </div>";	
		}  
		else if($this->uri->segment(4)=="app_succes"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Data Sukses Di APPROVAL $nodoktmp </div>";	
		}		
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';		
		/* akses approve atasan */
		$nama=$this->session->userdata('nik');
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		// or $level_akses=='A'
		if(($userhr>0 )){
			$param="";
			$param2="";
			
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /* and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D') */){
			$param=" and nikmohon in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nikmohon='$nama'";	
			$param2=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /* and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D') */){
			$param=" and nikmohon in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nikmohon='$nama'";
			$param2=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";		
		}
		else {
			$param=" and nikmohon='$nama' ";
			$param2=" and nik='$nama' ";
			
		} 

		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$data['ceknikatasan1']=$ceknikatasan1;
		/* END APPROVE ATASAN */
		
		
		
				/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and nodok='$nama' and status='I'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param3_1_3=" and nodok='$nama' and status='A'";
		$param3_1_4=" and nodok='$nama' and status='C'";
		$param3_1_5=" and nodok='$nama' and status='H'";
		$param3_1_R=" and nodok='$nama'";
			$cekmstpo_na=$this->m_inventaris->q_hisperawatan_tmp($param3_1_1)->num_rows(); //input
			$cekmstpo_ne=$this->m_inventaris->q_hisperawatan_tmp($param3_1_2)->num_rows(); //edit
			$cekmstpo_napp=$this->m_inventaris->q_hisperawatan_tmp($param3_1_3)->num_rows(); //approv
			$cekmstpo_cancel=$this->m_inventaris->q_hisperawatan_tmp($param3_1_4)->num_rows(); //cancel
			$cekmstpo_hangus=$this->m_inventaris->q_hisperawatan_tmp($param3_1_5)->num_rows(); //hangus
			$dtledit=$this->m_inventaris->q_hisperawatan_tmp($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			///$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			
			$enc_nik=bin2hex($this->encrypt->encode($nama));

			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekmstpo_na>0) { //cek inputan
					redirect("ga/inventaris/input_po/$enc_nik");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_ne>0){	//cek edit
					$nodok=trim($dtledit['nodoktmp']);
					redirect("ga/inventaris/edit_view_perawatanasset/$nodok");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_napp>0){	//cek approv
					$nodok=trim($dtledit['nodoktmp']);
					redirect("ga/inventaris/approval_view_perawatanasset/$nodok");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_cancel>0){	//cek cancel
					$nodok=trim($dtledit['nodoktmp']);
					redirect("ga/inventaris/hapus_view_perawatanasset/$nodok");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_hangus>0){	//cek cancel
                    $nodok=trim($dtledit['nodoktmp']);
                    $enc_nodok=bin2hex($this->encrypt->encode($nodok));
					redirect("ga/inventaris/hangus_po_atk/$enc_nodok");
					//redirect("ga/inventaris/direct_lost_input");
			}
		$tgl=explode(' - ',$this->input->post('tgl'));
		if(!empty($this->input->post('tgl')) or ($this->input->post('tgl'))<>'') {
			$tgl1= date('Y-m-d',strtotime($tgl[0]));
			$tgl2= date('Y-m-d',strtotime($tgl[1]));
			$paramdate=" and to_char(tgldok::date,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
		} else {
			$paramdate=" and to_char(tgldok::date,'yyyymm') = to_char(now(),'yyyymm') ";
		}
		$parameter=$param.$paramdate;
	
	
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_perawatan']=$this->m_inventaris->q_hisperawatan($parameter)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
		$data['list_karyawanparam']=$this->m_inventaris->list_karyawan($param2)->result();
		
		$this->template->display('ga/inventaris/v_formperawatan',$data);
	}
	
	function clear_tmp_perawatanasset(){
		$nama=$this->session->userdata('nik');
		$param3_first="and nodok='$nama'";
		$dtl_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->row_array();
		$status=trim($dtl_first['status']);
		$nodok=trim($dtl_first['nodoktmp']);
		if($status=='I'){
			$info = array (
				'status' => 'A',
				'inputby' => NULL,
				'inputdate' => NULL,
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_his.perawatanasset',$info);
			
		} else if($status=='E'){
			$info = array (
				'status' => 'A',
				'updateby' => NULL,
				'updatedate' => NULL,
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_his.perawatanasset',$info);
			
		} else if($status=='C'){
			$info = array (
				'status' => 'A',
				'cancelby' => $nama,
				'canceldate' => date('Y-m-d H:i:s'),
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_his.perawatanasset',$info);
		}
		
		$this->db->where('nodok',$nama);
		$this->db->delete('sc_tmp.perawatanasset');
		
		redirect("ga/inventaris/form_perawatan");
	}
	
	
	
	function input_view_perawatanasset(){
			$data['title']="FORM INPUT PERAWATAN ASSET";
			$dtlbranch=$this->m_akses->q_branch()->row_array();
			$branch=$dtlbranch['branch'];
							/* CODE UNTUK VERSI */
							$kodemenu='I.G.E.1';
							$versirelease='I.G.E.1/ALPHA.001';
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
		$nama=$this->session->userdata('nik');
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		// or $level_akses=='A'
		if(($userhr>0 )){
			$param="";
			$param2="";
			
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 /* and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D') */){
			$param=" and nikmohon in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nikmohon='$nama'";	
			$param2=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 /* and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D') */){
			$param=" and nikmohon in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nikmohon='$nama'";
			$param2=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";		
		}
		else {
			$param=" and nikmohon='$nama' ";
			$param2=" and nik='$nama' ";
			
		} 				
			
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$data['list_perawatan']=$this->m_inventaris->q_hisperawatan($param)->result();
			$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
			$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
			$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
			$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
			$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
			$data['list_karyawanparam']=$this->m_inventaris->list_karyawan($param2)->result();
			$this->template->display('ga/inventaris/v_input_perawatanasset.php',$data);
	}
	
	
	function edit_view_perawatanasset(){
			$nodok=trim($this->uri->segment(4));
			$nama=$this->session->userdata('nik');
			
			if(empty($nodok)){
				redirect("ga/inventaris/form_perawatan");
			}
			
			
			
			$param_trxapprov=" and nodok='$nodok' and status in ('P','D','C','H')";
			$cek_trxapprov=$this->m_inventaris->q_hisperawatan($param_trxapprov)->num_rows();
			if($cek_trxapprov>0){
				redirect("ga/inventaris/form_perawatan/process_fail/$nodok");
			}	
			/* REDIRECT JIKA USER LAIN KALAH CEPAT */
			$param3_first=" and nodoktmp='$nodok' and nodok<>'$nama'";
			$param4_first=" and nodok='$nama'";
			$cek_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->num_rows();
			$cek_first_nik=$this->m_inventaris->q_hisperawatan_tmp($param4_first)->num_rows();
			$dtl_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->row_array();
			
			
			if($cek_first>0){
				$nodokfirst=trim($dtl_first['nodok']);
				redirect("ga/inventaris/form_perawatan/edit_fail/nodokfirst");
			} else {
				$info = array (
					'status' => 'E',
					'updateby' => $nama,
					'updatedate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.perawatanasset',$info);
			}
		

		/*	$paramstatus=" and nodok='$nodok' and status not in ('A')";
			$cekstatus=$this->m_inventaris->q_hisperawatan($paramstatus)->num_rows();
			if($cekstatus>0){
				redirect("ga/inventaris/form_perawatan/edit_fail");
			} 
		*/
		
		
			$data['title']="FORM INPUT PERAWATAN ASSET";
			$dtlbranch=$this->m_akses->q_branch()->row_array();
			$branch=$dtlbranch['branch'];
							/* CODE UNTUK VERSI */
							$kodemenu='I.G.E.1';
							$versirelease='I.G.E.1/ALPHA.001';
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
			$param=" and nodok='$nama'";												
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$data['dtl_perawatan']=$this->m_inventaris->q_hisperawatan_tmp($param)->row_array();
			$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
			$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
			$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
			$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
			$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
			$this->template->display('ga/inventaris/v_edit_perawatanasset.php',$data);
	}
	
	
	function detail_view_perawatanasset(){
			$nodok=trim($this->uri->segment(4));
			
			if(empty($nodok)){
				redirect("ga/inventaris/form_perawatan");
			}
		
			$data['title']="FORM INPUT PERAWATAN ASSET";
			$dtlbranch=$this->m_akses->q_branch()->row_array();
			$branch=$dtlbranch['branch'];
							/* CODE UNTUK VERSI */
							$kodemenu='I.G.E.1';
							$versirelease='I.G.E.1/ALPHA.001';
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
			$param=" and nodok='$nodok'";												
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$data['dtl_perawatan']=$this->m_inventaris->q_hisperawatan($param)->row_array();
			$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
			$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
			$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
			$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
			$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
			$this->template->display('ga/inventaris/v_detail_perawatanasset.php',$data);
	}
	
	function hapus_view_perawatanasset(){
			$nodok=trim($this->uri->segment(4));
			$nama=$this->session->userdata('nik');
			
			if(empty($nodok)){
				redirect("ga/inventaris/form_perawatan");
			}
			
			
			$param_trxapprov=" and nodok='$nodok' and status in ('P','D','H')";
			$cek_trxapprov=$this->m_inventaris->q_hisperawatan($param_trxapprov)->num_rows();
			if($cek_trxapprov>0){
				redirect("ga/inventaris/form_perawatan/process_fail/$nodok");
			}	
			/* REDIRECT JIKA USER LAIN KALAH CEPAT */
			$param3_first=" and nodoktmp='$nodok' and nodok<>'$nama'";
			$param4_first=" and nodok='$nama'";
			$cek_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->num_rows();
			$cek_first_nik=$this->m_inventaris->q_hisperawatan_tmp($param4_first)->num_rows();
			$dtl_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->row_array();
			
			
			if($cek_first>0){
				$nodokfirst=trim($dtl_first['nodok']);
				redirect("ga/inventaris/form_perawatan/cancel_fail/$nodokfirst");
			} else {
				$info = array (
					'status' => 'C',
					'cancelby' => $nama,
					'canceldate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.perawatanasset',$info);
			}
		
			
			$data['title']="FORM INPUT PERAWATAN ASSET";
			$dtlbranch=$this->m_akses->q_branch()->row_array();
			$branch=$dtlbranch['branch'];
							/* CODE UNTUK VERSI */
							$kodemenu='I.G.E.1';
							$versirelease='I.G.E.1/ALPHA.001';
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
			$param=" and nodok='$nama'";												
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$data['dtl_perawatan']=$this->m_inventaris->q_hisperawatan_tmp($param)->row_array();
			$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
			$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
			$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
			$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
			$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
			$this->template->display('ga/inventaris/v_hapus_perawatanasset.php',$data);
	}
	
	function approval_view_perawatanasset(){
			$nodok=trim($this->uri->segment(4));
			$nama=$this->session->userdata('nik');
			
			if(empty($nodok)){
				redirect("ga/inventaris/form_perawatan");
			}
			
			
			$param_trxapprov=" and nodok='$nodok' and status in ('P','D','C','H')";
			$cek_trxapprov=$this->m_inventaris->q_hisperawatan($param_trxapprov)->num_rows();
			if($cek_trxapprov>0){
				redirect("ga/inventaris/form_perawatan/process_fail/$nodok");
			}	
			/* REDIRECT JIKA USER LAIN KALAH CEPAT */
			$param3_first=" and nodoktmp='$nodok' and nodok<>'$nama'";
			$param4_first=" and nodok='$nama'";
			$param5_first=" and nodok='$nodok'";
			$cek_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->num_rows();
			$cek_first_nik=$this->m_inventaris->q_hisperawatan_tmp($param4_first)->num_rows();
			$dtl_status=$this->m_inventaris->q_hisperawatan($param5_first)->row_array();
			$dtl_first=$this->m_inventaris->q_hisperawatan_tmp($param3_first)->row_array();
			
			
			if($cek_first>0){
				$nodokfirst=trim($dtl_first['nodok']);
				redirect("ga/inventaris/form_perawatan/cancel_fail/$nodokfirst");
			} else if (trim($dtl_status['status'])=='A') {
				$info = array (
					'status' => 'A',
					'approvalby' => $nama,
					'approvaldate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.perawatanasset',$info);
			} else if (trim($dtl_status['status'])=='A1') {
				$info = array (
					'status' => 'A1',
					'approvalby' => $nama,
					'approvaldate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_his.perawatanasset',$info);
			}
		
		
			$data['title']="FORM INPUT PERAWATAN ASSET";
			$dtlbranch=$this->m_akses->q_branch()->row_array();
			$branch=$dtlbranch['branch'];
							/* CODE UNTUK VERSI */
							$kodemenu='I.G.E.1';
							$versirelease='I.G.E.1/ALPHA.001';
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
			$param=" and nodok='$nama'";												
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$data['dtl_perawatan']=$this->m_inventaris->q_hisperawatan_tmp($param)->row_array();
			$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
			$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
			$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
			$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
			$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
			$this->template->display('ga/inventaris/v_approval_perawatanasset.php',$data);
	}
	
	function input_perawatanasset(){
		$nama=$this->session->userdata('nik');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodoktmp=strtoupper(trim($this->input->post('nodoktmp')));
		$dokref=strtoupper(trim($this->input->post('dokref')));
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		$stockcode=strtoupper(trim($this->input->post('stockcode')));
		$descbarang=strtoupper(trim($this->input->post('descbarang'))); 
		$nikpakai=strtoupper(trim($this->input->post('userpakai'))); 
		$nikmohon=strtoupper(trim($this->input->post('usermohon')));
		$jnsperawatan=strtoupper(trim($this->input->post('jnsperawatan')));  
		$tgldok=strtoupper(trim($this->input->post('tgldok')));   
		$keterangan=strtoupper(trim($this->input->post('keterangan')));  
		$laporanpk=strtoupper(trim($this->input->post('laporanpk')));  
		$laporanpsp=strtoupper(trim($this->input->post('laporanpsp')));  
		$laporanksp=strtoupper(trim($this->input->post('laporanksp')));  
		$km_awal=strtoupper(trim($this->input->post('km_awal')));  
		$km_akhir=strtoupper(trim($this->input->post('km_akhir')));  
				if (empty($km_awal)) { $km_awal=0; }
				if (empty($km_akhir)) { $km_akhir=0; }	
		$status=strtoupper(trim($this->input->post('status')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;

		
		if ($type=='INPUT'){
			$paramstatus=" and nodok='$nodok' and status not in ('A')";
			$cekstatus=$this->m_inventaris->q_hisperawatan($paramstatus)->num_rows();

			if($cekstatus>0){
				redirect("ga/inventaris/form_perawatan/input_fail");
			}
			

				$info = array (
					'nodok' => $nama,  
					'kdgroup' => $kdgroup,
					'kdsubgroup' => $kdsubgroup,
					'stockcode'  => $stockcode,          
					'descbarang' => $descbarang,   
					'nikpakai' => $nikpakai,     
					'nikmohon' => $nikmohon,     
					'jnsperawatan' => $jnsperawatan, 
					'tgldok' => $tgldok,       
					'keterangan' => $keterangan,   
					'laporanpk' => $laporanpk,    
					'laporanpsp' => $laporanpsp,   
					'laporanksp' => $laporanksp,   
					'km_awal' => $km_awal,   
					'km_akhir' => $km_akhir,   
					'status' => 'I',       
					'inputdate' => $inputdate,    
					'inputby' => $inputby,  
				
				);
				$this->db->insert('sc_tmp.perawatanasset',$info);
				
				$param=" and modul='PERAWATANASSET' and userid='$nama'";
				$dtltrx=$this->m_inventaris->trxerror($param)->row_array();
				$nodoktmp=trim($dtltrx['nomorakhir1']);
				redirect("ga/inventaris/form_perawatan/inp_succes/$nodoktmp");
			
		} else if ($type=='EDIT') {
			$paramstatus=" and nodok='$nodok' and status not in ('A')";
			$cekstatus=$this->m_inventaris->q_hisperawatan($paramstatus)->num_rows();
			if($cekstatus>0){
				redirect("ga/inventaris/form_perawatan/edit_fail");
			}
				$info = array (
					'kdgroup' => $kdgroup,
					'kdsubgroup' => $kdsubgroup,
					'stockcode'  => $stockcode,     
					'descbarang' => $descbarang,   
					'nikpakai' => $nikpakai,     
					'nikmohon' => $nikmohon,     
					'jnsperawatan' => $jnsperawatan, 
					'tgldok' => $tgldok,       
					'keterangan' => $keterangan,   
					'laporanpk' => $laporanpk,    
					'laporanpsp' => $laporanpsp,   
					'laporanksp' => $laporanksp, 
					'km_awal' => $km_awal,   
					'km_akhir' => $km_akhir,  					
					'status' => 'F',       
					'updatedate' => $inputdate,    
					'updateby' => $inputby,  
				
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.perawatanasset',$info);
				redirect("ga/inventaris/form_perawatan/edit_succes/$nodoktmp");
		} else if ($type=='APPROVAL') {
			$paramstatus=" and nodok='$nodoktmp' and status in ('P','C','D')";
			$cekstatus=$this->m_inventaris->q_hisperawatan($paramstatus)->num_rows();
			$paramcek=" and nodoktmp='$nodoktmp'";
			$dtl=$this->m_inventaris->q_hisperawatan_tmp($paramcek)->row_array();
			if($cekstatus>0){
				redirect("ga/inventaris/form_perawatan/approval_fail");
			}
				if($status=='A'){
					$info = array (
							'status' => 'F',    
							'updatedate' => $inputdate,
							'updateby' => $inputby,
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.perawatanasset',$info);
					
				}else if ($status=='A1'){
					$info = array (
							'status' => 'F',    
							'updatedate' => $inputdate,
							'updateby' => $inputby,
					);
					$this->db->where('nodok',$nodok);
					$this->db->update('sc_tmp.perawatanasset',$info);
				}

				redirect("ga/inventaris/form_perawatan/app_succes/$nodoktmp");
		}  else if ($type=='HAPUS') {
			$paramstatus=" and nodok='$nodok' and status not in ('A')";
			$cekstatus=$this->m_inventaris->q_hisperawatan($paramstatus)->num_rows();
			if($cekstatus>0){
				redirect("ga/inventaris/form_perawatan/del_fail");
			}
				$info = array (
						'status' => 'F',    
						'canceldate' => $inputdate,
						'cancelby' => $inputby,
				);
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_tmp.perawatanasset',$info);
				redirect("ga/inventaris/form_perawatan/del_succes/$nodoktmp");
		}  else {
			redirect("ga/inventaris/form_perawatan/fail_data");
		}	
	}
	
	
	function sti_perawatan_asset(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$data['jsonfile'] = "ga/inventaris/json_perawatan_asset/$nodok";
		$data['report_file'] = 'assets/mrt/sti_perawatanasset.mrt';
		$this->load->view("ga/inventaris/sti_v_spk_perawatan",$data);
	}
	function json_perawatan_asset(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$param=" and nodok='$nodok'";
		$datamst = $this->m_inventaris->q_master_branch()->result();
		$datadtl = $this->m_inventaris->q_hisperawatan($param)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	
	
		/************** FORM PERAWATAN ASET ***********************/
		
/*		
	function form_spk(){
			$data['title']="FILTER DATA PERAWATAN ASSET & INPUT SPK";	
						/* CODE UNTUK VERSI 
						$kodemenu='I.G.E.2';
						$versirelease='I.G.E.2/ALPHA.001';
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
						/* END CODE UNTUK VERSI 
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$this->template->display('ga/inventaris/v_filterspk',$data);
								
	}*/
	
	
	
	function index_spk(){
		$data['title']="FORM PERAWATAN ASSET INPUT SPK";	
		$nama=$this->session->userdata('nik');	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.E.2';
						$versirelease='I.G.E.2/ALPHA.001';
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

		if($this->uri->segment(4)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
        else if($this->uri->segment(4)=="inp_succes"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Data Sukses Disimpan $nodoktmp </div>";
		} else if($this->uri->segment(4)=="del_succes"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Data Input Sukses Hapus $nodoktmp </div>";
		} else if($this->uri->segment(4)=="final_succes"){
			$nodoktmp=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Finalisasi Perawatan Sukses $nodoktmp </div>";
		} else if($this->uri->segment(4)=="input_fail")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH DI PROSES DIGUNAKAN USER LAIN  </div>";
		else {
			$data['message']="";
		}				
						
				
		/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and nodok='$nama' and status='I'";
		$param3_1_2=" and nodok='$nama' and status='E'";
		$param3_1_3=" and nodok='$nama' and status='A'";
		$param3_1_4=" and nodok='$nama' and status='C'";
		$param3_1_5=" and nodok='$nama' and status='H'";
		$param3_1_R=" and nodok='$nama'";
			$cekmstpo_na=$this->m_inventaris->q_hisperawatanspk_tmp($param3_1_1)->num_rows(); //input
			$cekmstpo_ne=$this->m_inventaris->q_hisperawatanspk_tmp($param3_1_2)->num_rows(); //edit
			$cekmstpo_napp=$this->m_inventaris->q_hisperawatanspk_tmp($param3_1_3)->num_rows(); //approv
			$cekmstpo_cancel=$this->m_inventaris->q_hisperawatanspk_tmp($param3_1_4)->num_rows(); //cancel
			$cekmstpo_hangus=$this->m_inventaris->q_hisperawatanspk_tmp($param3_1_5)->num_rows(); //hangus
			$dtledit=$this->m_inventaris->q_hisperawatanspk_tmp($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));
			$enc_nodok=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
			$enc_nik=bin2hex($this->encrypt->encode($nama));
			
			$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekmstpo_na>0) { //cek inputan
					$nodokref=trim($dtledit['nodokref']);
					redirect("ga/inventaris/inputspk_view/$nodokref");
					
			} else if ($cekmstpo_ne>0){	//cek edit
					$nodoktmp=trim($dtledit['nodoktmp']);
					redirect("ga/inventaris/edit_inputspk/$nodoktmp");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_napp>0){	//cek approv
					redirect("ga/inventaris/approval_po_atk/$enc_nodok");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_cancel>0){	//cek cancel
					redirect("ga/inventaris/batal_po_atk/$enc_nodok");
					//redirect("ga/inventaris/direct_lost_input");
			} else if ($cekmstpo_hangus>0){	//cek cancel
					redirect("ga/inventaris/hangus_po_atk/$enc_nodok");
					//redirect("ga/inventaris/direct_lost_input");
			}
		
		$param=" and status in ('P','X')";
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_perawatan']=$this->m_inventaris->q_hisperawatan($param)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$this->template->display('ga/inventaris/v_form_index_spk',$data);
		
	}
	
	
	function perawatanspk_pagin(){
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

			
		
		
		$param='';
		$list = $this->m_inventaris->get_list_perawatanspk();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lpo) {
			$enc_nodok=bin2hex($this->encrypt->encode(trim($lpo->nodok)));
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $lpo->nodok;		
			$row[] = $lpo->nodokref;		
			$row[] = $lpo->nmbarang;		
			$row[] = $lpo->nopol;		
			$row[] = $lpo->nmbengkel;				
			$row[] = $lpo->nmstatus;				
			/*$row[] = $lpo->nmsubsupplier;
			$row[] = $lpo->ketstatus;
			$row[] = ' <span class="pull-right" >'.number_format($lpo->ttlnetto).' </span>';
			/&$row[] = $lpo->inputby;
			if (isset($lpo->inputdate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->inputdate))); } else { $row[] = ''; } 
			$row[] = $lpo->approvalby;
			if(isset($lpo->approvaldate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->approvaldate))); } else { $row[] ='';} 
			$row[] = $lpo->keterangan; */
			if ((trim($lpo->status)!='A') AND (trim($lpo->status)!='P')) {
			$row[] = 
			'<a class="btn btn-sm btn-default" href="'.site_url('ga/inventaris/detail_inputspk').'/'.$lpo->nodok.'" title="Detail SPK"><i class="fa fa-bars"></i></a>';
			} else if (trim($lpo->status)=='P' or trim($lpo->status)=='S') {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/inventaris/detail_inputspk').'/'.$lpo->nodok.'" title="Detail SPK"><i class="fa fa-bars"></i></a>
			<a class="btn btn-sm btn-warning" href="'.site_url('ga/inventaris/sti_po_final').'/'.trim($lpo->nodok).'" title="Cetak PO"><i class="fa fa-print"></i></a>
			<a class="btn btn-sm btn-danger" href="'.site_url('ga/inventaris/hangus_po_atk').'/'.$enc_nodok.'" title="Hangus PO"><i class="fa fa-trash-o"></i></a>';
			} else if ((trim($lpo->status)=='A' and $param_list2==1) or $userhr>0) {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/inventaris/detail_inputspk').'/'.$lpo->nodok.'" title="Detail SPK"><i class="fa fa-bars"></i></a>
			<a class="btn btn-sm btn-primary" href="'.site_url('ga/inventaris/edit_inputspk').'/'.$lpo->nodok.'" title="Edit SPK"><i class="fa fa-gear"></i></a>
			<a class="btn btn-sm btn-warning" href="'.site_url('ga/inventaris/sti_spk_perawatan').'/'.$lpo->nodok.'" title="Cetak SPK"><i class="fa fa-print"></i></a>';
			
			
			} else if (trim($lpo->status)=='A' and $param_list2==0) {
			$row[] = '
			<a class="btn btn-sm btn-default" href="'.site_url('ga/inventaris/detail_inputspk').'/'.$lpo->nodok.'" title="Detail SPK"><i class="fa fa-bars"></i></a>
			<a class="btn btn-sm btn-primary" href="'.site_url('ga/inventaris/edit_inputspk').'/'.$lpo->nodok.'" title="Edit SPK"><i class="fa fa-gear"></i></a>
			<a class="btn btn-sm btn-warning" href="'.site_url('ga/inventaris/sti_spk_perawatan').'/'.$lpo->nodok.'" title="Cetak SPK"><i class="fa fa-print"></i></a>';
			}
 	
			/*
			<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
			<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
			<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a>
			<a  data-url="'.site_url('ga/inventaris/form_inventaris/modal_edit_po_atk').'/'.trim($lpo->nodok).'" data-toggle="modal" data-target=".pp" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT
			*/
			$data[] = $row;
		}
    
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_inventaris->q_hisperawatanspk($param)->num_rows(),
						"recordsFiltered" => $this->m_inventaris->q_hisperawatanspk($param)->num_rows(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
				//echo '1342';
	}
	
	
	function form_spk(){
		$data['title']="FORM PERAWATAN ASSET INPUT SPK";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.E.2';
						$versirelease='I.G.E.2/ALPHA.001';
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

		$param=" and status in ('P') and spk=0 ";
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_perawatan']=$this->m_inventaris->q_hisperawatan($param)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$this->template->display('ga/inventaris/v_listperawatanspk',$data);
	}
	
	
	function list_perawatan(){
		$data['title']="FORM PERAWATAN ASSET INPUT SPK";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$tglist=str_replace('%20',' ',$this->input->post('tgl'));
		$tgl=explode(' - ',str_replace('%20',' ',$this->input->post('tgl')));
		$kdcabang=$this->input->post('kdcabang');
		$tglawal=date('Y-m-d', strtotime(trim($tgl[0])));
		$tglakhir=date('Y-m-d', strtotime(trim($tgl[1])));
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.E.2';
						$versirelease='I.G.E.2/ALPHA.001';
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

						
		if(empty($kdcabang)) {
			redirect("ga/inventaris/form_spk");
		}
			
		$data['tgl']=$tglist;
		$data['kdcabang']=$kdcabang;
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_perawatan']=$this->m_inventaris->q_hisperawatanlist($kdcabang,$tglawal,$tglakhir)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$this->template->display('ga/inventaris/v_listperawatanspk',$data);
			
	}
	
	function inputspk_view(){
		$data['title']='DATA SURAT PERINTAH KERJA DENGAN NOMOR REFERENSI ::  ';
		$nodok=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');

		if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(5)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH ADA SILAHKAN UBAH DATA TERSEBUT </div>";
		 else if($this->uri->segment(5)=="fail_data_belum_lengkap")
            $data['message']="<div class='alert alert-danger'>PERINGATAN HARAP LENGKAPI DATA - DATA MASTER TERLEBIH DAHULU</div>";
		else if($this->uri->segment(4)=="input_fail")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH DI PROSES DIGUNAKAN USER LAIN  </div>";
        else
            $data['message']='';
		
		if(empty($nodok)){
			redirect("ga/inventaris/form_perawatan");
		}
				
		$param_trxapprov=" and nodok='$nodok' and status in ('P','D','C','H')";
		$cek_trxapprov=$this->m_inventaris->q_hisperawatanspk($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/inventaris/inputspk_view/process_fail/$nodok");
		}	
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodokref='$nodok' and nodok<>'$nama'";
		$param4_first=" and nodok='$nama'";
		$param5_first=" and nodok='$nodok'";
		$cek_first=$this->m_inventaris->q_hisperawatanspk_tmp($param3_first)->num_rows();
		$cek_first_nik=$this->m_inventaris->q_hisperawatanspk_tmp($param4_first)->num_rows();
		$dtl_first=$this->m_inventaris->q_hisperawatanspk_tmp($param3_first)->row_array();
		$dtl_passet=$this->m_inventaris->q_hisperawatan($param5_first)->row_array();
		
		
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/inventaris/index_spk/input_fail");
		} else {	
					$param_tmp_spk=" and nodok='$nama'";
					$cek_tmp_spk=$this->m_inventaris->q_hisperawatanspk_tmp($param_tmp_spk)->num_rows();
					if ($cek_tmp_spk==0){
						$info = array (
						'nodok'     => $nama,
						'nodokref'   => $nodok,
						'status'   => 'I',
						'inputby'   => $nama,
						'inputdate' => date('Y-m-d H:i:s'),
						'tgldok' => trim($dtl_passet['tgldok']),
						'keterangan' => trim($dtl_passet['keterangan']),
						'km_awal' => trim($dtl_passet['km_awal']),
						'km_akhir' => trim($dtl_passet['km_akhir']),
						
						);
						$this->db->insert('sc_tmp.perawatanspk',$info);
					} 
		/*	$info = array (
				'status' => 'E',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_his.perawatanasset',$info);*/
		}

		if(empty($nodok)) {
			redirect("ga/inventaris/form_spk");
		}
		$param1=" and nodok='$nodok' and status in ('P','X')";
		$param2=" and nodok='$nama'";
		$data['nodok']=$nodok;
		
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatan($param1)->row_array();
		$data['list_spk']=$this->m_inventaris->q_hisperawatanspk_tmp($param2)->result();
		$data['dtl_spkrow']=$this->m_inventaris->q_hisperawatanspk_tmp($param2)->num_rows();
		
		$dtl_spk=$this->m_inventaris->q_hisperawatanspk_tmp($param2)->row_array();
		$nodokspk=trim($dtl_spk['nodok']);
		$data['nodokspk']=trim($dtl_spk['nodok']);
		$parama1=" and nodok='$nodokspk'";
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		//$data['list_perawatan']=$this->m_inventaris->q_hisperawatan()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at_tmp($param2)->result();
		$this->template->display('ga/inventaris/v_inputspk',$data);
	}
	
	function input_perawatan_mst_lampiran(){
		$data['title']='DATA SURAT PERINTAH KERJA INPUT FAKTUR';

		//$nodok=trim(strtoupper($this->uri->segment(4)));
		$strtrimref=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if($this->uri->segment(7)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(7)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SPK SUDAH ADA SILAHKAN UBAH DATA SPK TERSEBUT </div>";
        else
            $data['message']='';
		

		if(empty($strtrimref)) {
			redirect("ga/inventaris/index_spk");
		}
		
		$parama1=" and strtrimref='$strtrimref'";
		$parama2=" and strtrimref='$strtrimref'";
		$parama3=" and strtrimref='$strtrimref'";
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->result();
		$data['perawatan_detail_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_dtl_lampiran_tmp($parama2)->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->row_array();
		$data['dtl_faktur']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->row_array();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at_tmp($parama3)->result();
		$this->template->display('ga/inventaris/v_input_perawatan_mst_lampiran',$data);
	}
	
	function edit_perawatan_mst_lampiran(){
		$data['title']='DATA SURAT PERINTAH KERJA INPUT FAKTUR';

		//$nodok=trim(strtoupper($this->uri->segment(4)));
		$strtrimref=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if($this->uri->segment(7)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(7)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SPK SUDAH ADA SILAHKAN UBAH DATA SPK TERSEBUT </div>";
        else
            $data['message']='';
		

		if(empty($strtrimref)) {
			redirect("ga/inventaris/index_spk");
		}
		
		$parama1=" and strtrimref='$strtrimref'";
		$parama2=" and strtrimref='$strtrimref'";
		$parama3=" and strtrimref='$strtrimref'";
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->result();
		$data['perawatan_detail_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_dtl_lampiran_tmp($parama2)->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->row_array();
		$dtl_mst=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->row_array();
		$param_ff=" and nodok='$nama'";
		$dtl_spk=$this->m_inventaris->q_hisperawatanspk_tmp($param_ff)->row_array();
		$data['nodoktmp']=$dtl_spk['nodoktmp'];
		$data['dtl_faktur']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->row_array();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at_tmp($parama3)->result();
		$this->template->display('ga/inventaris/v_edit_perawatan_mst_lampiran',$data);
	}
	
	
	function detail_perawatan_mst_lampiran(){
		$data['title']='DATA SURAT PERINTAH KERJA INPUT FAKTUR';

		//$nodok=trim(strtoupper($this->uri->segment(4)));
		$strtrimref=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if($this->uri->segment(7)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(7)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SPK SUDAH ADA SILAHKAN UBAH DATA SPK TERSEBUT </div>";
        else
            $data['message']='';
		

		$parama1=" and strtrimref='$strtrimref'";
		$parama2=" and strtrimref='$strtrimref'";
		$parama3=" and strtrimref='$strtrimref'";
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->result();
		$data['perawatan_detail_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_dtl_lampiran($parama2)->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->row_array();
		$data['dtl_faktur']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->row_array();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at($parama3)->result();
		$this->template->display('ga/inventaris/v_detail_perawatan_mst_lampiran',$data);
	}
	
	function save_spk_lampiran(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		
		/* $tgl=explode(' - ',str_replace('%20',' ',$this->input->post('tgl')));
		$tglawal=date('Y-m-d', strtotime(trim($tgl[0])));
		if (empty($tglawal)) { $tglawal=null; } else {$tglawal=$tglawal;}
		$tglakhir=date('Y-m-d', strtotime(trim($tgl[1])));
		if (empty($tglakhir)) { $tglakhir=null; } else {$tglakhir=$tglakhir;} */
		
		
		$id=strtoupper(trim($this->input->post('id')));
		$idfaktur=strtoupper(trim($this->input->post('idfaktur')));
		$nnetto=strtoupper(trim($this->input->post('nnetto')));
		$ndpp=strtoupper(trim($this->input->post('ndpp')));
		$nppn=strtoupper(trim($this->input->post('nppn')));
		$ndiskon=strtoupper(trim($this->input->post('ndiskon')));
		$nservis=strtoupper(trim($this->input->post('nservis')));
		$tgl=strtoupper(trim($this->input->post('tgl')));
		$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$nodoktmp=strtoupper(trim($this->input->post('nodoktmp')));
		if(empty($nodok)) { redirect("ga/inventaris/input_perawatan_mst_lampiran/$nama/inp_failed"); }
		
		$dokref=strtoupper(trim($this->input->post('dokref')));
		$descbarang=strtoupper(trim($this->input->post('descbarang')));
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		$stockcode=strtoupper(trim($this->input->post('stockcode')));
		$jnsperawatan=strtoupper(trim($this->input->post('jnsperawatan')));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$strtrimref=$this->encrypt->decode(hex2bin(trim($this->input->post('strtrimref'))));
		$enc_strtrimref=trim($this->input->post('strtrimref'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$cekdouble=$this->m_inventaris->cek_spkdouble($nodok)->num_rows();
		if ($type=='INPUTTMPMSTFAKTUR'){
			$paramidfaktur=" and idfaktur='$idfaktur' and nodok='$nodok'";
			$cekdoublefaktur=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($paramidfaktur)->num_rows();
			
			
			if ($cekdoublefaktur>0) {
				redirect("ga/inventaris/inputspk_view/$nodokref/fail_datakembar");
			} else {
				$info = array (
							'nodok       ' =>  $nodok       ,
							'nodokref    ' =>  $nodokref    ,
							'id		     ' =>  0,
							'idfaktur    ' =>  $idfaktur    ,
							'tgl         ' =>  $tgl         ,
							'keterangan  ' =>  $keterangan  ,
							'nservis     ' =>  $nservis     ,
							'ndiskon     ' =>  $ndiskon     ,
							'ndpp        ' =>  $ndpp        ,
							'nppn        ' =>  $nppn        ,
							'nnetto      ' =>  $nnetto      ,
							'jnsperawatan' =>  $jnsperawatan,
							'status' =>  'I',
							'inputdate   ' =>  $inputdate   ,
							'inputby     ' =>  $inputby     ,
							///'ref_type    ' =>  $ref_type    ,
					
					);	
					$this->db->insert('sc_tmp.perawatan_mst_lampiran',$info);
					redirect("ga/inventaris/inputspk_view/$nodokref/inp_succes");	
			}
						
		} else if ($type=='INPUTTMPMSTFAKTUR_E'){
				$info = array (
							'tgl         ' =>  $tgl         ,
							'keterangan  ' =>  $keterangan  ,
							'nservis     ' =>  $nservis     ,
							'ndiskon     ' =>  $ndiskon     ,
							'ndpp        ' =>  $ndpp        ,
							'nppn        ' =>  $nppn        ,
							'nnetto      ' =>  $nnetto      ,
							'jnsperawatan' =>  $jnsperawatan,
							'status' =>  'I',
							'updatedate   ' =>  $inputdate   ,
							'updateby     ' =>  $inputby     ,
							///'ref_type    ' =>  $ref_type    ,
					
					);	
				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->update('sc_tmp.perawatan_mst_lampiran',$info);
				redirect("ga/inventaris/inputspk_view/$nodokref/inp_succes");	
						
		}  else if ($type=='EDITTMPMSTFAKTUR_E'){
				$info = array (
							'tgl         ' =>  $tgl         ,
							'keterangan  ' =>  $keterangan  ,
							'nservis     ' =>  $nservis     ,
							'ndiskon     ' =>  $ndiskon     ,
							'ndpp        ' =>  $ndpp        ,
							'nppn        ' =>  $nppn        ,
							'nnetto      ' =>  $nnetto      ,
							'jnsperawatan' =>  $jnsperawatan,
							'status' =>  'I',
							'updatedate   ' =>  $inputdate   ,
							'updateby     ' =>  $inputby     ,
							///'ref_type    ' =>  $ref_type    ,
					
					);	
				$this->db->where('nodok',$nodok);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->update('sc_tmp.perawatan_mst_lampiran',$info);
				redirect("ga/inventaris/edit_inputspk/$nodoktmp/inp_succes");	
						
		} else if ($type=='INPUTEDITTMPMSTFAKTUR'){
			$paramidfaktur=" and idfaktur='$idfaktur' and nodok='$nodok'";
			$cekdoublefaktur=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($paramidfaktur)->num_rows();
			
			
			if ($cekdoublefaktur>0) {
				redirect("ga/inventaris/edit_inputspk/$nodoktmp/fail_datakembar");
			} else {
				$info = array (
							'nodok       ' =>  $nodok       ,
							'nodokref    ' =>  $nodokref    ,
							'id		     ' =>  0,
							'idfaktur    ' =>  $idfaktur    ,
							'tgl         ' =>  $tgl         ,
							'keterangan  ' =>  $keterangan  ,
							'nservis     ' =>  $nservis     ,
							'ndiskon     ' =>  $ndiskon     ,
							'ndpp        ' =>  $ndpp        ,
							'nppn        ' =>  $nppn        ,
							'nnetto      ' =>  $nnetto      ,
							'jnsperawatan' =>  $jnsperawatan,
							'status' =>  'I',
							'inputdate   ' =>  $inputdate   ,
							'inputby     ' =>  $inputby     ,
							///'ref_type    ' =>  $ref_type    ,
					
					);	
					$this->db->insert('sc_tmp.perawatan_mst_lampiran',$info);
					redirect("ga/inventaris/edit_inputspk/$nodoktmp/inp_succes");	
			}
						
		} else if ($type=='INPUTDTLFAKTUR'){
				$info = array (
						'nodok       ' =>  $nodok       ,
						'nodokref    ' =>  $nodokref    ,
						'id		     ' =>  0,
						'idfaktur    ' =>  $idfaktur    ,
						'keterangan  ' =>  $keterangan  ,
						'nservis     ' =>  $nservis     ,
						'status' =>  'I',
						'inputdate   ' =>  $inputdate   ,
						'inputby     ' =>  $inputby     ,
						///'ref_type    ' =>  $ref_type    ,
				
				);	
			if ($cekdouble>0) {
				redirect("ga/inventaris/input_perawatan_mst_lampiran/$enc_strtrimref/inp_failed");
			} else {
				$this->db->insert('sc_tmp.perawatan_detail_lampiran',$info);
				redirect("ga/inventaris/input_perawatan_mst_lampiran/$enc_strtrimref/inp_succes");
			}
			
		} else if ($type=='INPUTEDITDTLFAKTUR'){
				$info = array (
						'nodok       ' =>  $nodok       ,
						'nodokref    ' =>  $nodokref    ,
						'id		     ' =>  0,
						'idfaktur    ' =>  $idfaktur    ,
						'keterangan  ' =>  $keterangan  ,
						'nservis     ' =>  $nservis     ,
						'status' =>  'E',
						'inputdate   ' =>  $inputdate   ,
						'inputby     ' =>  $inputby     ,
						///'ref_type    ' =>  $ref_type    ,
				
				);	
			if ($cekdouble>0) {
				redirect("ga/inventaris/edit_perawatan_mst_lampiran/$enc_strtrimref/inp_failed");
			} else {
				$this->db->insert('sc_tmp.perawatan_detail_lampiran',$info);
				redirect("ga/inventaris/edit_perawatan_mst_lampiran/$enc_strtrimref/inp_succes");
			}
			
		} else if ($type=='EDITDTLFAKTUR'){
				$info = array (
						'keterangan  ' =>  $keterangan  ,
						'nservis     ' =>  $nservis     ,
						'status' =>  'I',
						'updatedate   ' =>  $inputdate   ,
						'updateby     ' =>  $inputby     ,
						///'ref_type    ' =>  $ref_type    ,
				
				);	
				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->update('sc_tmp.perawatan_detail_lampiran',$info);
				redirect("ga/inventaris/input_perawatan_mst_lampiran/$enc_strtrimref/edit_succes");
		
			
		}   else if ($type=='EDITDTLEDITFAKTUR'){
				$info = array (
						'keterangan  ' =>  $keterangan  ,
						'nservis     ' =>  $nservis     ,
						'status' =>  'I',
						'updatedate   ' =>  $inputdate   ,
						'updateby     ' =>  $inputby     ,
						///'ref_type    ' =>  $ref_type    ,
				
				);	
				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->update('sc_tmp.perawatan_detail_lampiran',$info);
				redirect("ga/inventaris/edit_perawatan_mst_lampiran/$enc_strtrimref/edit_succes");
		
			
		} else if ($type=='DELDTLFAKTUR'){

				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->delete('sc_tmp.perawatan_detail_lampiran');
				redirect("ga/inventaris/input_perawatan_mst_lampiran/$enc_strtrimref/del_succes");
		
			
		} else if ($type=='DELDTLEDITFAKTUR'){

				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->delete('sc_tmp.perawatan_detail_lampiran');
				redirect("ga/inventaris/edit_perawatan_mst_lampiran/$enc_strtrimref/del_succes");
		
			
		}  else if ($type=='DELTMPMSTFAKTUR'){

				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->delete('sc_tmp.perawatan_mst_lampiran');
				redirect("ga/inventaris/inputspk_view/$nodokref/del_succes");
		
			
		}  else if ($type=='DELEDITTMPMSTFAKTUR'){

				$this->db->where('nodok',$nodok);
				$this->db->where('nodokref',$nodokref);
				$this->db->where('idfaktur',$idfaktur);
				$this->db->where('id',$id);
				$this->db->delete('sc_tmp.perawatan_mst_lampiran');
				redirect("ga/inventaris/edit_inputspk/$nodoktmp/del_succes");
		
			
		} else if ($type=='EDITTMP'){
			$info = array (
					       
					'kdgroup' => $kdgroup,       
					'kdsubgroup' => $kdsubgroup,       
					'stockcode' => $stockcode,       
					'kdbengkel' => $kdbengkel,       
					'kdsubbengkel' => $kdsubbengkel,       
					'upbengkel' => $upbengkel,       
					'jnsperawatanref' => $jnsperawatanref,         
					'tglawal' => $tglawal,       
					'tglakhir' => $tglakhir,  
					'km_awal' => $kmawal,       
					'km_akhir' => $kmakhir,  					
					'ttlservis' => $ttlservis,  					
					'descbarang' => $descbarang,       
					'keterangan' => $keterangan,       
					'status' => 'I',       
					'updatedate' => $inputdate,       
					'updateby' => $inputby
				
				);	
			$this->db->where('nodok',$nodok);	
			$this->db->where('nodokref',$nodokref);	
			$this->db->update('sc_tmp.perawatanspk',$info);
			redirect("ga/inventaris/inputspk_view/$nodokref/edit_succes");	
				
		}  else if ($type=='DELETE'){

			$this->db->where('nodok',$nodok);	
			$this->db->where('nodokref',$nodokref);	
			$this->db->delete('sc_his.perawatanspk');
			redirect("ga/inventaris/inputspk_view/$nodok/del_succes");	
				
		}
	
	}
	
	
	function save_spk(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		//$tgl=strtoupper(trim($this->input->post('tgl')));
		$tgl=explode(' - ',str_replace('%20',' ',$this->input->post('tgl')));
		$tglawal=date('Y-m-d', strtotime(trim($tgl[0])));
		if (empty($tglawal)) { $tglawal=null; } else {$tglawal=$tglawal;}
		$tglakhir=date('Y-m-d', strtotime(trim($tgl[1])));
		if (empty($tglakhir)) { $tglakhir=null; } else {$tglakhir=$tglakhir;}
		$ttlnetto=strtoupper(trim($this->input->post('ttlnetto')));
		$ttldpp=strtoupper(trim($this->input->post('ttldpp')));
		$ttlppn=strtoupper(trim($this->input->post('ttlppn')));
		$ttldiskon=strtoupper(trim($this->input->post('ttldiskon')));
		$ttlservis=strtoupper(trim($this->input->post('ttlservis')));
		$kmawal=strtoupper(trim($this->input->post('kmawal')));
		$kmakhir=strtoupper(trim($this->input->post('kmakhir')));
		
		$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
		$id=strtoupper(trim($this->input->post('id')));
		
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$nodoktmp=strtoupper(trim($this->input->post('nodoktmp')));
		if(empty($nodok)) { redirect("ga/inventaris/form_spk"); }
		
		$dokref=strtoupper(trim($this->input->post('dokref')));
		$descbarang=strtoupper(trim($this->input->post('descbarang')));
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		$stockcode=strtoupper(trim($this->input->post('stockcode')));
		$kdbengkel=strtoupper(trim($this->input->post('kdbengkel')));
		$kdsubbengkel=strtoupper(trim($this->input->post('kdsubbengkel')));
		$upbengkel=strtoupper(trim($this->input->post('upbengkel')));
		$jnsperawatan=strtoupper(trim($this->input->post('jnsperawatan')));
		$jnsperawatanref=strtoupper(trim($this->input->post('jnsperawatanref')));
		$tgldok=date('Y-m-d H:i:s');

		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$cekdouble=$this->m_inventaris->cek_spkdouble($nodok)->num_rows();
		if ($type=='INPUT'){
				$info = array (
					'nodok' => $nama,       
					'nodokref' => $nodok,       
					'descbarang' => $descbarang,       
					'kdgroup' => $kdgroup,       
					'kdsubgroup' => $kdsubgroup,       
					'stockcode' => $stockcode,       
					'kdbengkel' => $kdbengkel,       
					'kdsubbengkel' => $kdsubbengkel,       
					'upbengkel' => $upbengkel,       
					'jnsperawatan' => $jnsperawatan,       
					'jnsperawatanref' => $jnsperawatanref,       
					'tgldok' => $tgldok,       
					'tglawal' => $tglawal,       
					'tglakhir' => $tglakhir, 
					'km_awal' => $kmawal,       
					'km_akhir' => $kmakhir,  					
					'ttlservis' => $ttlservis,  					
					'keterangan' => $keterangan,       
					'status' => 'I',       
					'inputdate' => $inputdate,       
					'inputby' => $inputby
				
				);	
			if ($cekdouble>0) {
				redirect("ga/inventaris/inputspk_view/$nodok/fail_datakembar");
			} else {
				$this->db->insert('sc_tmp.perawatanspk',$info);
				redirect("ga/inventaris/inputspk_view/$nodok/inp_succes");
			}
			
		} else if ($type=='EDITTMP'){
			$info = array (
					       
					'kdgroup' => $kdgroup,       
					'kdsubgroup' => $kdsubgroup,       
					'stockcode' => $stockcode,       
					'kdbengkel' => $kdbengkel,       
					'kdsubbengkel' => $kdsubbengkel,       
					'upbengkel' => $upbengkel,       
					'jnsperawatanref' => $jnsperawatanref,         
					'tglawal' => $tglawal,       
					'tglakhir' => $tglakhir,  
					'km_awal' => $kmawal,       
					'km_akhir' => $kmakhir,  					
					'ttlservis' => $ttlservis,  					
					'descbarang' => $descbarang,       
					'keterangan' => $keterangan,       
					'status' => 'I',       
					'updatedate' => $inputdate,       
					'updateby' => $inputby
				
				);	
			$this->db->where('nodok',$nodok);	
			$this->db->where('nodokref',$nodokref);	
			$this->db->update('sc_tmp.perawatanspk',$info);
			redirect("ga/inventaris/inputspk_view/$nodokref/edit_succes");	
				
		} else if ($type=='EDITTMPEDIT'){
			$info = array (
					       
	      
					'kdbengkel' => $kdbengkel,       
					'kdsubbengkel' => $kdsubbengkel,       
					'upbengkel' => $upbengkel,       
					'jnsperawatanref' => $jnsperawatanref,         
					'tglawal' => $tglawal,       
					'tglakhir' => $tglakhir,  
					'km_awal' => $kmawal,       
					'km_akhir' => $kmakhir,  					
					'ttlservis' => $ttlservis,  					
					'descbarang' => $descbarang,       
					'keterangan' => $keterangan,       
					'updatedate' => $inputdate,       
					'updateby' => $inputby
				
				);	
			$this->db->where('nodok',$nodok);	
			$this->db->where('nodokref',$nodokref);	
			$this->db->update('sc_tmp.perawatanspk',$info);
			redirect("ga/inventaris/edit_inputspk/$nodoktmp/edit_succes");	
				
		}   else if ($type=='DELETE'){

			$this->db->where('nodok',$nodok);	
			$this->db->where('nodokref',$nodokref);	
			$this->db->delete('sc_his.perawatanspk');
			redirect("ga/inventaris/inputspk_view/$nodok/del_succes");	
				
		}
	
	}
	
	function add_attachmentspk(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
	///	$tgl=strtoupper(trim($this->input->post('tgl')));
	///	$kdcabang=strtoupper(trim($this->input->post('kdcabang')));

		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$idfaktur=strtoupper(trim($this->input->post('idfaktur')));
		$enc_strtrimref=strtoupper(trim($this->input->post('strtrimref')));
		if(empty($enc_strtrimref)) { redirect("ga/inventaris/form_spk"); }
		
		if(!empty($_FILES['userFiles']['name'])){
            $filesCount = count($_FILES['userFiles']['name']);
            for($index = 0; $index < $filesCount; $index++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$index];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$index];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$index];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$index];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$index];

                $uploadPath = './assets/attachment/att_spkperawatan/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|zip|rar|doc|docx|ppt|pptx|xls|xlsx';
                $config['encrypt_name'] = true;
			
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $info[$index]['file_name'] = $fileData['file_name'];
                    $info[$index]['file_type'] = $fileData['file_type'];
                    $info[$index]['full_path'] = base_url('/assets/attachment/att_spkperawatan/'.$fileData['file_name']);//$fileData['full_path'];
                    $info[$index]['orig_name'] = $fileData['orig_name'];
                    $info[$index]['file_ext'] = $fileData['file_ext'];
                    $info[$index]['file_size'] = $fileData['file_size'];
					$info[$index]['ref_type'] = 'AT';
					$info[$index]['nodok'] = $nodok;
					$info[$index]['nodokref'] = $nodokref;
					$info[$index]['idfaktur'] = $idfaktur;
                    $info[$index]['inputdate'] = date("Y-m-d H:i:s");
                    $info[$index]['inputby'] = $nama;

                }
            }
            
            if(!empty($info)){
                $insert = $this->m_inventaris->insert_attachmentspk($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
        }
	
	//redirect("ga/inventaris/inputspk_view/$nodok/$kdcabang/$tgl/inp_succes");
	
		if($type=='SAVEINPUTDTLLAMPIRAN'){
			redirect("ga/inventaris/input_perawatan_mst_lampiran/$enc_strtrimref");
		} else if ($type=='SAVEEDITDTLLAMPIRAN'){
			redirect("ga/inventaris/edit_perawatan_mst_lampiran/$enc_strtrimref");
		}
	}
	
	function hps_lampiranspk(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		
		$file_name=trim($this->input->post('file_name'));
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$idfaktur=strtoupper(trim($this->input->post('idfaktur')));
		$enc_strtrimref=strtoupper(trim($this->input->post('strtrimref')));
		$id=$this->input->post('id');
		if(empty($enc_strtrimref)) { redirect("ga/inventaris/form_spk"); }
		
			$target="assets/attachment/att_spkperawatan/$file_name";
			if(file_exists($target)){
				unlink($target); 	
			}
			$this->db->where('nodok',$nodok);
			$this->db->where('file_name',$file_name);
			$this->db->delete('sc_tmp.perawatan_lampiran');
			if($type=='DELDTLINPUT'){
				redirect("ga/inventaris/input_perawatan_mst_lampiran/$enc_strtrimref/del_succes");	
			} else if ($type=='DELDTLEDIT'){
				redirect("ga/inventaris/edit_perawatan_mst_lampiran/$enc_strtrimref/del_succes");	
			}
			
	}
	
	function clear_tmpspk(){
	echo $nodok=strtoupper(trim($this->input->post('nodok')));
	echo $nodoktmp=strtoupper(trim($this->input->post('nodoktmp')));
		
		$param=" and nodok='$nodok' and nodoktmp='$nodoktmp'";
		$dtlmst_tmp=$this->m_inventaris->q_hisperawatanspk_tmp($param)->row_array();
		echo $status=trim($dtlmst_tmp['status']);
		echo $nodoktmp=trim($dtlmst_tmp['nodoktmp']);
		if ($status=='E'){
			$info = array (
					'status' => 'A',       
					'updatedate' => NULL,       
					'updateby' => NULL,
				
				);	
			$this->db->where('nodok',$nodoktmp);	
			$this->db->update('sc_his.perawatanspk',$info);		
		}
		
		
		
		$this->db->where('nodok',$nodok);
		//$this->db->where('nodokref',$nodokref);
		$this->db->delete('sc_tmp.perawatanspk');
		$this->db->where('nodok',$nodok);
		//$this->db->where('nodokref',$nodokref);
		$this->db->delete('sc_tmp.perawatan_mst_lampiran');
		$this->db->where('nodok',$nodok);
		//$this->db->where('nodokref',$nodokref);
		$this->db->delete('sc_tmp.perawatan_detail_lampiran');
		$this->db->where('nodok',$nodok);
		//$this->db->where('nodokref',$nodokref);
		$this->db->delete('sc_tmp.perawatan_lampiran');
		
		
		$param2=" and modul='PERAWATAN-SPK' and userid='$nama'";
		$dtltrx=$this->m_inventaris->trxerror($param2)->row_array();
		$nodoktmp=trim($dtltrx['nomorakhir1']);
		
		redirect("ga/inventaris/index_spk/del_succes/$nodokref");
	}
	
	function final_inputspk(){
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$nama=$this->session->userdata('nik');
		$paramtmp=" and nodok='$nodok' and coalesce(stockcode,'')='' and coalesce(kdsubbengkel,'')='' ";
		$cek_tmp=$this->m_inventaris->q_hisperawatanspk_tmp($paramtmp)->num_rows();
		if($cek_tmp>0){
			redirect("ga/inventaris/inputspk_view/$nodokref/fail_data_belum_lengkap");
		} else {
			$info = array (
				'status' => 'F',       
									
					);	
			$this->db->where('nodok',$nodok);
			$this->db->where('nodokref',$nodokref);
			$this->db->update('sc_tmp.perawatanspk',$info);
			$param=" and modul='PERAWATAN-SPK' and userid='$nama'";
			$dtltrx=$this->m_inventaris->trxerror($param)->row_array();
			$nodoktmp=trim($dtltrx['nomorakhir1']);
			redirect("ga/inventaris/index_spk/inp_succes/$nodoktmp");
		}
		


		
		
	}
	
	function final_editspk(){
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$info = array (
				'status' => 'F',       
									
				);	
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_tmp.perawatanspk',$info);
		
		
		$param=" and modul='PERAWATAN-SPK' and userid='$nama'";
		$dtltrx=$this->m_inventaris->trxerror($param)->row_array();
		$nodoktmp=trim($dtltrx['nomorakhir1']);
		
		redirect("ga/inventaris/index_spk/edit_succes/$nodoktmp");
	}
	
	function finalisasi_perawatan(){
		$nodok=strtoupper(trim($this->input->post('nodok')));
		$nodokref=strtoupper(trim($this->input->post('nodokref')));
		$info = array (
				'status' => 'X',       
									
				);	
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_his.perawatanspk',$info);
		
		
		$param=" and modul='PERAWATAN-SPK' and userid='$nama'";
		$dtltrx=$this->m_inventaris->trxerror($param)->row_array();
		$nodoktmp=trim($dtltrx['nomorakhir1']);
		
		redirect("ga/inventaris/index_spk/final_succes/$nodok");
	}
	
	function sti_spk_perawatan(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$data['jsonfile'] = "ga/inventaris/json_spk_perawatan/$nodok";
		$data['report_file'] = 'assets/mrt/sti_spk_perawatanasset.mrt';
		$this->load->view("ga/inventaris/sti_v_spk_perawatan",$data);
	}
	function json_spk_perawatan(){
		$nodok=trim(strtoupper($this->uri->segment(4)));
		$param=" and nodok='$nodok'";
		$datamst = $this->m_inventaris->q_master_branch()->result();
		$datadtl = $this->m_inventaris->q_hisperawatanspk($param)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
				'master' => $datamst,
				'detail' => $datadtl,
			)	
		, JSON_PRETTY_PRINT);
	}
	
	function final_spk(){
		$nodok=strtoupper(trim($this->uri->segment(4)));
		if(!empty($nodok)){
			$info = array (
					'status' => 'X',       
					'updatedate' => $inputdate,       
					'updateby' => $inputby
				
				);	
			$this->db->where('nodok',$nodok);	
			$this->db->update('sc_his.perawatanspk',$info);
			$this->db->where('nodok',$nodok);	
			$this->db->update('sc_his.perawatanasset',$info);
			redirect("ga/inventaris/form_spk/approval_succes");	
		}
		redirect("ga/inventaris/form_spk/fail_final");	
	
	}
	
	function detail_inputspk(){
		$data['title']='DATA SURAT PERINTAH KERJA DENGAN NOMOR REFERENSI ::  ';
		$nodok=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');

		if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(5)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH ADA SILAHKAN UBAH DATA TERSEBUT </div>";
        else
            $data['message']='';


		$param2=" and nodok='$nodok'";
		$data['nodok']=$nodok;
		
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatanspk($param2)->row_array();
		$data['list_spk']=$this->m_inventaris->q_hisperawatanspk($param2)->result();
		$data['dtl_spkrow']=$this->m_inventaris->q_hisperawatanspk($param2)->num_rows();
		
		$dtl_spk=$this->m_inventaris->q_hisperawatanspk($param2)->row_array();
		$nodokspk=trim($dtl_spk['nodok']);
		$data['nodokspk']=trim($dtl_spk['nodok']);
		$parama1=" and nodok='$nodokspk'";
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		//$data['list_perawatan']=$this->m_inventaris->q_hisperawatan()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at($param2)->result();
		$this->template->display('ga/inventaris/v_detail_inputspk',$data);
	}
	
	function edit_inputspk(){
		$data['title']='DATA SURAT PERINTAH KERJA DENGAN NOMOR REFERENSI ::  ';
		$nodok=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');

		if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(5)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH ADA SILAHKAN UBAH DATA TERSEBUT </div>";
        else
            $data['message']='';
		
		if(empty($nodok)){
			redirect("ga/inventaris/index_spk");
		}
				
		$param_trxapprov=" and nodok='$nodok' and status in ('P','D','C','H')";
		$cek_trxapprov=$this->m_inventaris->q_hisperawatanspk($param_trxapprov)->num_rows();
		if($cek_trxapprov>0){
			redirect("ga/inventaris/index_spk/process_fail/$nodok");
		}	
		/* REDIRECT JIKA USER LAIN KALAH CEPAT */
		$param3_first=" and nodoktmp='$nodok' and nodok<>'$nama'";
		$param4_first=" and nodok='$nama'";
		$cek_first=$this->m_inventaris->q_hisperawatanspk_tmp($param3_first)->num_rows();
		$cek_first_nik=$this->m_inventaris->q_hisperawatanspk_tmp($param4_first)->num_rows();
		$dtl_first=$this->m_inventaris->q_hisperawatanspk_tmp($param3_first)->row_array();
		
		
		if($cek_first>0){
			$nodokfirst=trim($dtl_first['nodok']);
			redirect("ga/inventaris/index_spk/input_fail");
		} else {	
					$param_tmp_spk=" and nodok='$nama'";
					$cek_tmp_spk=$this->m_inventaris->q_hisperawatanspk_tmp($param_tmp_spk)->num_rows();
					if ($cek_tmp_spk==0){
						$info = array (
						'status'     => 'E',
						'updateby'   => $nama,
						'updatedate' => date('Y-m-d H:i:s'),
						
						);
						$this->db->where('nodok',$nodok);
						$this->db->update('sc_his.perawatanspk',$info);
					} 
		/*	$info = array (
				'status' => 'E',
				'updateby' => $nama,
				'updatedate' => date('Y-m-d H:i:s'),
			);
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_his.perawatanasset',$info);*/
		}

		if(empty($nodok)) {
			redirect("ga/inventaris/form_spk");
		}
		$param1=" and nodoktmp='$nodok'";
		$param2=" and nodok='$nama'";
		$data['nodok']=$nodok;
		
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatanspk_tmp($param1)->row_array();
		$data['list_spk']=$this->m_inventaris->q_hisperawatanspk_tmp($param2)->result();
		$data['dtl_spkrow']=$this->m_inventaris->q_hisperawatanspk_tmp($param2)->num_rows();
		
		$dtl_spk=$this->m_inventaris->q_hisperawatanspk_tmp($param2)->row_array();
		$nodokspk=trim($dtl_spk['nodok']);
		$data['nodokspk']=trim($dtl_spk['nodok']);
		$data['nodokref']=trim($dtl_spk['nodokref']);
		$parama1=" and nodok='$nodokspk'";
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran_tmp($parama1)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		//$data['list_perawatan']=$this->m_inventaris->q_hisperawatan()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at_tmp($param4_first)->result();
		$this->template->display('ga/inventaris/v_edit_inputspk',$data);
	}
	
	
	
	function filter_historyperawatan(){
			$data['title']="FILTER DATA PERAWATAN ASSET & INPUT SPK";	
						/* CODE UNTUK VERSI */
						$kodemenu='I.G.E.3';
						$versirelease='I.G.E.3/ALPHA.001';
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
			$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
			$data['list_scgroup']=$this->m_inventaris->q_scgroup_ast()->result();
			$this->template->display('ga/inventaris/v_filterhistoryperawatan.php',$data);
								
	}
	
	
	function history_perawatan(){
		$data['title']="HISTORY PERAWATAN ASSET";	
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];
		$nama=$this->session->userdata('nik');
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		$nik=strtoupper($this->input->post('nik'));
		$tgl=explode(' - ',trim($this->input->post('tgl')));

						/* CODE UNTUK VERSI */
						$kodemenu='I.G.E.3';
						$versirelease='I.G.E.3/ALPHA.001';
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

						
		if(isset($tgl[0]) and isset($tgl[1])) {
			$tgl1=date('Y-m-d', strtotime(trim($tgl[0])));
			$tgl2=date('Y-m-d', strtotime(trim($tgl[1])));
		} else { redirect("ga/inventaris/history_perawatan");	} 
		
		//$qtyrec=(strtoupper(trim($this->input->post('qtyrec')))=='' ? '0' : strtoupper(trim($this->input->post('qtyrec'))));
		if(empty($kdgroup)or $kdgroup=='' or $kdgroup==null){ $kdgroup=""; } else { $kdgroup=" and kdgroup='$kdgroup'"; 	}
		if(empty($kdsubgroup)or $kdsubgroup=='' or $kdsubgroup==null){	$kdsubgroup="";	} else { $kdsubgroup=" and kdsubgroup='$kdsubgroup'"; }	
		if(empty($stockcode)or $stockcode=='' or $stockcode==null){	$stockcode="";	} else { $stockcode=" and stockcode='$stockcode'";	}
		if(empty($tgl)or $tgl=='' or $tgl==null){$tgl="";} else { 	$tgl=" and to_char(tgldok,'yyyy-mm-dd') between '$tgl1' and '$tgl2'";}
		if(empty($nik)or $nik=='' or $nik==null){$nik=""; } else { 	$nik=" and nikmohon='$nik'";}

		$param=$kdgroup.$kdsubgroup.$stockcode.$tgl.$nik."and status!='C'";
		$data['kdgroup']=$kdgroup;
		$data['stockcode']=$stockcode;
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_perawatan']=$this->m_inventaris->q_hisperawatanspk($param)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_karyawanbarang']=$this->m_inventaris->q_listkaryawanbarang()->result();
		$this->template->display('ga/inventaris/v_historyperawatan',$data);
	}
	
	function history_spkperawatan(){
		$data['title']='DATA SURAT PERINTAH KERJA DENGAN NOMOR REFERENSI ::  ';
		$nodok=trim($this->uri->segment(4));
		$nama=$this->session->userdata('nik');

		if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(5)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH ADA SILAHKAN UBAH DATA TERSEBUT </div>";
        else
            $data['message']='';


		$param2=" and nodok='$nodok'";
		$data['nodok']=$nodok;
		
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatanspk($param2)->row_array();
		$data['list_spk']=$this->m_inventaris->q_hisperawatanspk($param2)->result();
		$data['dtl_spkrow']=$this->m_inventaris->q_hisperawatanspk($param2)->num_rows();
		
		$dtl_spk=$this->m_inventaris->q_hisperawatanspk($param2)->row_array();
		$nodokspk=trim($dtl_spk['nodok']);
		$data['nodokspk']=trim($dtl_spk['nodok']);
		$parama1=" and nodok='$nodokspk'";
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->result();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		//$data['list_perawatan']=$this->m_inventaris->q_hisperawatan()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at($param2)->result();
		$this->template->display('ga/inventaris/v_detail_inputspk_history',$data);
	}
	
	function detail_perawatan_mst_lampiran_history(){
		$data['title']='DATA SURAT PERINTAH KERJA LIST FAKTUR';

		//$nodok=trim(strtoupper($this->uri->segment(4)));
		$strtrimref=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		$nama=$this->session->userdata('nik');
		if($this->uri->segment(7)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(7)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SPK SUDAH ADA SILAHKAN UBAH DATA SPK TERSEBUT </div>";
        else
            $data['message']='';
		

		$parama1=" and strtrimref='$strtrimref'";
		$parama2=" and strtrimref='$strtrimref'";
		$parama3=" and strtrimref='$strtrimref'";
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['perawatan_mst_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->result();
		$data['perawatan_detail_lampiran']=$this->m_inventaris->q_hisperawatan_perawatan_dtl_lampiran($parama2)->result();
		$data['dtl_mst']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->row_array();
		$data['dtl_faktur']=$this->m_inventaris->q_hisperawatan_perawatan_mst_lampiran($parama1)->row_array();
		$data['list_barang']=$this->m_inventaris->q_listbarang()->result();
		$data['list_bengkel']=$this->m_inventaris->q_listbengkel()->result();
		$data['list_subbengkel']=$this->m_inventaris->q_listsubbengkel()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup()->result();
		$data['list_trxtypespk']=$this->m_inventaris->q_trxtype_spkasset()->result();
		$data['dtllamp_at']=$this->m_inventaris->q_lampiran_at($parama3)->result();
		$this->template->display('ga/inventaris/v_detail_perawatan_mst_lampiran_history',$data);
	}
	
	function master_mapping_satuan_brg(){
		$data['title']="FORM MASTER MAPPING SATUAN BARANG & ATK";	
		$kdgroup=strtoupper($this->input->post('kdgroup'));
		$kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
		$stockcode=strtoupper($this->input->post('kdbarang'));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
            $data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		if (!empty($stockcode) or ($stockcode!='')) {
			$param=" and stockcode='$stockcode'";
		} else {
			$param="";
		}
						
		$data['list_mstbarang']=$this->m_inventaris->q_mstbarang()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$data['list_mapping']=$this->m_inventaris->q_mapsatuan_barang_param($param)->result();
		$data['cekdelmap']=$this->m_inventaris->cek_delmap()->row_array();
		$this->template->display('ga/inventaris/v_mst_mapping_satuan_brg',$data);
	}
	
	function edit_view_mapping_satuan_brg(){
		$data['title']="DETAIL MASTER MAPPING SATUAN BARANG";
		$id=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
		else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
			$data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
			$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
			$data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
			$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else
			$data['message']='';
		$param=" and id='$id'";				
		$data['list_mstbarang']=$this->m_inventaris->q_mstbarang()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$data['list_mapping']=$this->m_inventaris->q_mapsatuan_barang_param($param)->result();
		$data['dtl_map']=$this->m_inventaris->q_mapsatuan_barang_param($param)->row_array();
		$data['cekdelmap']=$this->m_inventaris->cek_delmap()->row_array();
		$this->template->display('ga/inventaris/v_edit_mapping_satuan_brg',$data);
	}
	
	function detail_view_mapping_satuan_brg(){
		$data['title']="UBAH MASTER MAPPING SATUAN BARANG";
		$id=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
		else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
			$data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
			$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
			$data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
			$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else
			$data['message']='';
		$param=" and id='$id'";				
		$data['list_mstbarang']=$this->m_inventaris->q_mstbarang()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$data['list_mapping']=$this->m_inventaris->q_mapsatuan_barang_param($param)->result();
		$data['dtl_map']=$this->m_inventaris->q_mapsatuan_barang_param($param)->row_array();
		$data['cekdelmap']=$this->m_inventaris->cek_delmap()->row_array();
		$this->template->display('ga/inventaris/v_detail_mapping_satuan_brg',$data);
	}
	
	function hapus_view_mapping_satuan_brg(){
		$data['title']="HAPUS MASTER MAPPING SATUAN BARANG";
		$id=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
		
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
		if($this->uri->segment(4)=="fail_datakembar")
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada Silahkan Edit/Input Baru Dengan Kode Yang Lain</div>";
		else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Satuan Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
			$data['message']="<div class='alert alert-success'>Delete Satuan Succes</div>";
		else if($this->uri->segment(4)=="del_failed")
			$data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
		else if($this->uri->segment(4)=="edit_succes")
			$data['message']="<div class='alert alert-success'>Data Satuan Berhasil Di Ubah</div>";
		else if($this->uri->segment(4)=="edit_fail")
			$data['message']="<div class='alert alert-danger'>Data sudah tercatat pada PO/SPPB tidak boleh terhapus</div>";
		else if($this->uri->segment(4)=="wrong_format")
			$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else
			$data['message']='';
		$param=" and id='$id'";				
		$data['list_mstbarang']=$this->m_inventaris->q_mstbarang()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$data['list_mapping']=$this->m_inventaris->q_mapsatuan_barang_param($param)->result();
		$data['dtl_map']=$this->m_inventaris->q_mapsatuan_barang_param($param)->row_array();
		$data['cekdelmap']=$this->m_inventaris->cek_delmap()->row_array();
		$this->template->display('ga/inventaris/v_hapus_mapping_satuan_brg',$data);
	}
	
	function input_mapping_satuan_brg(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
				
		$stockcode=strtoupper(trim($this->input->post('kdbarang')));
		if(empty($stockcode)) { redirect("ga/inventaris/master_mapping_satuan_brg"); }
		$kdgroup=strtoupper(trim($this->input->post('kdgroup')));
		$kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
		$satkecil=strtoupper(trim($this->input->post('satkecil')));
		$satbesar=strtoupper(trim($this->input->post('satbesar')));

		$qty=strtoupper(trim($this->input->post('qty')));
		$qtykecil=strtoupper(trim($this->input->post('qtykecil')));
		$keterangan=strtoupper(trim($this->input->post('keterangan')));
		$id=trim($this->input->post('id'));
		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$param1_1="and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode' and satkecil='$satkecil' and satbesar='$satbesar'";
		$cek_mapping_kembar=$this->m_inventaris->q_mapsatuan_barang_param($param1_1)->num_rows();
		
		if ($type=='INPUT'){
			
			if ($cek_mapping_kembar==0) {
				$info = array (
					'branch' => $branch,
					'satkecil' => $satkecil,
					'satbesar' => $satbesar,
					'qty' => $qty,
					'keterangan' => $keterangan,
					'inputdate' => $inputdate,
					'inputby' => $inputby,
					'kdgroup' => $kdgroup,
					'kdsubgroup' => $kdsubgroup,
					'stockcode' => $stockcode,
					'qtykecil' => $qtykecil,
									
				);	
			
				$this->db->insert('sc_mst.mapping_satuan_brg',$info);
				redirect("ga/inventaris/master_mapping_satuan_brg/rep_succes");
			} else {
				redirect("ga/inventaris/master_mapping_satuan_brg/fail_datakembar");
			}
		} else if ($type=='EDIT'){
			
				$info = array (
					'satkecil' => $satkecil,
					'satbesar' => $satbesar,
					'qty' => $qty,
					'qtykecil' => $qtykecil,
					'keterangan' => $keterangan,
					'updatedate' => $inputdate,
					'updateby' => $inputby,
									
				);	
				$this->db->where('id',$id);
				$this->db->update('sc_mst.mapping_satuan_brg',$info);
				redirect("ga/inventaris/master_mapping_satuan_brg/edit_succes");

		}  else if ($type=='DELETE'){
			$this->db->where('id',$id);	
			$this->db->delete('sc_mst.mapping_satuan_brg');
			redirect("ga/inventaris/master_mapping_satuan_brg/del_succes");
		}
		
		
	}
	
	function master_satuan_brg(){
		$data['title']="FORM MASTER SATUAN BARANG & ATK";	
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
		$data['list_mstbarang']=$this->m_inventaris->q_mstbarang()->result();
		$data['list_scgroup']=$this->m_inventaris->q_scgroup_atk()->result();
		$data['list_scsubgroup']=$this->m_inventaris->q_scsubgroup_atk()->result();
		$data['list_kanwil']=$this->m_inventaris->q_mstkantor()->result();
		$data['list_asuransi']=$this->m_inventaris->q_masuransi()->result();
		$data['list_satuan']=$this->m_inventaris->q_trxtype_satuan()->result();
		$data['list_mastersatuan']=$this->m_inventaris->q_master_satuan_barang_param($param)->result();
		$data['dtl']=$this->m_inventaris->q_master_satuan_barang_param($param)->row_array();
		$this->template->display('ga/inventaris/v_mst_satuan_brg',$data);
	}
	
	function input_master_satuan_brg(){
		$nama=$this->session->userdata('nama');
		$type=strtoupper($this->input->post('type'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=strtoupper(trim($dtlbranch['branch']));
		$kdtrx=strtoupper(trim($this->input->post('kdtrx')));
		$uraian=strtoupper(trim($this->input->post('uraian')));
		$jenistrx='QTYUNIT';

		$inputdate=date('Y-m-d H:i:s');
		$inputby=$nama;
		$param1_1=" and kdtrx='$kdtrx' ";
		$cek_master_kembar=$this->m_inventaris->q_master_satuan_barang_param($param1_1)->num_rows();
		if(empty($kdtrx)) { redirect("ga/inventaris/master_satuan_brg"); }
		if ($type=='INPUT'){
			
			if ($cek_master_kembar==0) {
				$info = array (
					'kdtrx' => $kdtrx,
					'jenistrx' => $jenistrx,
					'uraian' => $uraian,
				);	
				$this->db->insert('sc_mst.trxtype',$info);
				redirect("ga/inventaris/master_satuan_brg/rep_succes");
			} else {
				redirect("ga/inventaris/master_satuan_brg/fail_datakembar");
			}
		} else if ($type=='EDIT'){
			
				$info = array (
						'uraian' => $uraian,
									
				);	
				$this->db->where('kdtrx',$kdtrx);
				$this->db->where('jenistrx',$jenistrx);
				$this->db->update('sc_mst.trxtype',$info);
				redirect("ga/inventaris/master_satuan_brg/edit_succes");

		}  else if ($type=='DELETE'){

			$this->db->where('kdtrx',$kdtrx);
			$this->db->where('jenistrx',$jenistrx);
			$this->db->delete('sc_mst.trxtype');
			redirect("ga/inventaris/master_satuan_brg/del_succes");
				
		}
		
		
	}
	
	function master_gudang(){
		$data['title']="FORM MASTER GUDANG WILAYAH";
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

        $loccode=strtoupper(trim($this->input->post('loccode')));
        if (empty($loccode)) {
            $loccode=$this->session->userdata('loccode');
            $param=" and loccode='$loccode'";
            $paramoptimize="$loccode";
        } else {
            $param=" and loccode='$loccode'";
            $paramoptimize="$loccode";
        }
        $this->m_inventaris->optimize_region_stock($paramoptimize);
		$data['list_stkgdw']=$this->m_inventaris->q_stkgdw_param1($param)->result();
        $data['list_kanwil']=$this->m_inventaris->q_gudangwilayah()->result();
		$this->template->display('ga/inventaris/v_mst_stkgdw',$data);
	}
		
	function inquiry_stock(){
		$data['title']="FORM MASTER SATUAN BARANG & ATK";	
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
		
		$loccode=trim(strtoupper($this->input->post('loccode')));
		if (!empty($loccode)){
				$kdcabang="$loccode";
		} else {
				$kdcabang="MJKCNI";
		}
		
		
		$param="and loccode='$kdcabang'";
		$data['kdcabang']=$kdcabang;
		$data['list_stgblcoitem']=$this->m_inventaris->q_stgblcoitem_param($param)->result();
        $data['list_kanwil']=$this->m_inventaris->q_gudangwilayah()->result();
		//$data['list_stgblco']=$this->m_inventaris->q_stgblco_param($param)->result();
		$this->template->display('ga/inventaris/v_mst_inquiry_stock',$data);
	}
	
	function inquiry_stock_detail(){
		$data['title']="DETAIL HISTORY ITEM BARANG";
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

		$data['message']='';
		$kdgroup=trim($this->uri->segment(4));
		$kdsubgroup=trim($this->uri->segment(5));
		$stockcode=trim($this->uri->segment(6));
		$loccode=trim($this->uri->segment(7));
		
		$param=" and kdgroup='$kdgroup'  and kdsubgroup='$kdsubgroup' and stockcode='$stockcode' and loccode='$loccode'";
		//$data['list_stgblcoitem']=$this->m_inventaris->q_stgblcoitem_param($param)->result();
		$data['list_stgblco']=$this->m_inventaris->q_stgblco_param($param)->result();
		$this->template->display('ga/inventaris/v_mst_inquiry_stock_dtl',$data);
	}
	
	function excel_inquiry_stock(){
		$kdcabang1=trim($this->uri->segment(4));
		if (!empty($kdcabang1)){
				$kdcabang="$kdcabang1";
		} else {
				$kdcabang="MJKCNI";
		}
		
		
		$param="and loccode='$kdcabang'";
		$datane=$this->m_inventaris->q_stgblcoitem_param($param);
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Kode Wilayah','Kode Barang', 'Nama Barang', 'Sisa','Satuan'));
        $this->excel_generator->set_column(array('loccode','stockcode', 'nmbarang','qty_sld','nmsatkecil'));
        $this->excel_generator->set_width(array(10,10,50,20,20));
        $this->excel_generator->exportTo2007('Master Stock Barang');

	}
	
	
}