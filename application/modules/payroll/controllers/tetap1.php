
<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Tetap extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_tetap');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Setup Gaji Tetap";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Detail Rumus Tidak Ada</div>";
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
			
		
		//echo $tgl.$nik;
		$data['list_karyawan']=$this->m_tetap->list_karyawan()->result();	
			
		
        $this->template->display('payroll/tetap/v_utama',$data);
    }
	
	function all_gaji(){
		$data['title']="List View Gaji Semua Karyawan";
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Detail Rumus Tidak Ada</div>";
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
		$data['list_gaji']=$this->m_tetap->all_gaji()->result();	
		
        $this->template->display('payroll/tetap/v_list',$data);
	
	}
	
	function detail(){
		$data['title']="Detail Gaji Tetap";
		$nik=trim($this->input->post('nik'));
		$detail_karyawan=$this->m_tetap->list_karyawan_detail($nik)->row_array();
		$nmlengkap=$detail_karyawan['nmlengkap'];
		$data['nmlengkap']=$nmlengkap;
		if (empty($nik)){
			redirect('payroll/tetap/index');
		
		}
		$gajipokok1=$this->m_tetap->q_gajipokok($nik)->row_array();
		$gajipokok=$gajipokok1['gajipokok'];
		$gajibpjs1=$this->m_tetap->q_gajibpjs($nik)->row_array();
		$gajibpjs=$gajibpjs1['gajibpjs'];
		$gajinaker1=$this->m_tetap->q_gajinaker($nik)->row_array();
		$gajinaker=$gajinaker1['gajinaker'];
		
		$cek=$this->m_tetap->cek_gajitetap($nik)->num_rows();
		
		if ($cek==0) {
			$this->db->query("insert into sc_mst.dtlgaji_karyawan (nik,no_urut,keterangan,nominal)
							select '$nik' as nik,no_urut,keterangan,0 as nominal from sc_mst.detail_formula where tetap='T' and kdrumus='PR'
							and trim('$nik'||trim(cast(no_urut as character(3)))) not in (select trim(nik||trim(cast(no_urut as character(3)))) from sc_mst.dtlgaji_karyawan)");
			//echo 'sukses';
			
			$tj_jabatan1=$this->m_tetap->tj_jabatan($nik)->row_array();
			$tj_jabatan=$tj_jabatan1['nominal'];
			$tj_masakerja1=$this->m_tetap->tj_masakerja($nik)->row_array();
			$tj_masakerja=$tj_masakerja1['nominal'];
			$tj_prestasi1=$this->m_tetap->tj_prestasi($nik)->row_array();
			$tj_prestasi=$tj_prestasi1['nominal'];
			$gajitetap1=$this->m_tetap->gajitetap($nik)->row_array();
			$gajitetap=$gajitetap1['nominal'];
			$data['gajipokok']=$gajipokok;
			$data['gajibpjs']=$gajibpjs;
			$data['gajinaker']=$gajinaker;
			$data['tj_jabatan']=$tj_jabatan;
			$data['tj_masakerja']=$tj_masakerja;
			$data['tj_prestasi']=$tj_prestasi;
			$data['gajitetap']=$gajitetap;
			$data['nik']=$nik;
			$this->template->display('payroll/tetap/v_input',$data);
			//$this->template->display('payroll/tetap/v_test',$data);
		} else {
			$tj_jabatan1=$this->m_tetap->tj_jabatan($nik)->row_array();
			$tj_jabatan=$tj_jabatan1['nominal'];
			$tj_masakerja1=$this->m_tetap->tj_masakerja($nik)->row_array();
			$tj_masakerja=$tj_masakerja1['nominal'];
			$tj_prestasi1=$this->m_tetap->tj_prestasi($nik)->row_array();
			$tj_prestasi=$tj_prestasi1['nominal'];
			$gajitetap1=$this->m_tetap->gajitetap($nik)->row_array();
			$gajitetap=$gajitetap1['nominal'];
			$data['gajipokok']=$gajipokok;
			$data['gajibpjs']=$gajibpjs;
			$data['gajinaker']=$gajinaker; 
			$data['tj_jabatan']=$tj_jabatan;
			$data['tj_masakerja']=$tj_masakerja;
			$data['tj_prestasi']=$tj_prestasi;
			$data['gajitetap']=$gajitetap;
			$data['nik']=$nik;
			$this->template->display('payroll/tetap/v_input',$data);
			//$this->template->display('payroll/tetap/v_test',$data);
			//echo 'wes onok mbut';
		}
		
		
	
	}
	
	function add_detail(){
		$gajipokok=$this->input->post('gajipokok');
		$tj_jabatan=$this->input->post('tj_jabatan');
		$tj_masakerja=$this->input->post('tj_masakerja');
		$tj_prestasi=$this->input->post('tj_prestasi');
		$gajibpjs=$this->input->post('gajibpjs');
		$gajinaker=$this->input->post('gajinaker');
		$nik=$this->input->post('nik');
		$this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$gajipokok' where no_urut='1' and nik='$nik'");
		$this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$tj_jabatan' where no_urut='7' and nik='$nik'");
		$this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$tj_masakerja' where no_urut='8' and nik='$nik'");
		$this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$tj_prestasi' where no_urut='9' and nik='$nik'");
		$this->db->query("update sc_mst.karyawan set gajitetap=
						(select sum(nominal) from sc_mst.dtlgaji_karyawan where nik='$nik')
						where nik='$nik'");
		$this->db->query("update sc_mst.karyawan set tj_tetap=
						(select sum(nominal) from sc_mst.dtlgaji_karyawan where nik='$nik' and no_urut<>'1')
						where nik='$nik'");				
		$this->db->query("update sc_mst.karyawan set gajipokok=
						(select sum(nominal) from sc_mst.dtlgaji_karyawan where nik='$nik' and no_urut='1')
						where nik='$nik'");
		$this->db->query("update sc_mst.karyawan set gajibpjs=$gajibpjs where nik='$nik'");
		$this->db->query("update sc_mst.karyawan set gajinaker=$gajinaker where nik='$nik'");			
		redirect('payroll/tetap/index/rep_succes');
	}
	
	

	function edit_detail(){
		//$nik1=explode('|',);
		$kdrumus=$this->input->post('kdrumus');
		$tipe=$this->input->post('tipe');
		$keterangan=$this->input->post('keterangan');
		$aksi=$this->input->post('aksi');
		$aksi_tipe=$this->input->post('aksi_tipe');
		$tetap=$this->input->post('tetap');
		$taxable=$this->input->post('taxable');
		$deductible=$this->input->post('deductible');
		$regular=$this->input->post('regular');
		$cash=$this->input->post('cash');
		$tgl_input=date('d-m-Y H:i:s');
		$inputby=$this->session->userdata('nik');
		$no_urut=$this->input->post('no_urut');
		
		$cek=$this->m_formula->cek($kdrumus)->num_rows();
		
		$detail=array(
			'tipe'=>strtoupper($tipe),
			'keterangan'=>strtoupper($keterangan),
			'aksi'=>$aksi,
			'aksi_tipe'=>$aksi_tipe,
			'tetap'=>$tetap,
			'taxable'=>$taxable,
			'deductible'=>$deductible,
			'regular'=>$regular,
			'cash'=>$cash,
			
		);
		
		$this->db->where('kdrumus',$kdrumus);
		$this->db->where('no_urut',$no_urut);
		$this->db->update('sc_mst.detail_formula',$detail);
		redirect("master/formula/detail/$kdrumus/edit_succes");
		
	}
	
	function hps_detail($kdrumus,$no_urut){
		$this->db->where('kdrumus',$kdrumus);
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_mst.detail_formula');
		redirect("master/formula/detail/$kdrumus/del_succes");
	}
	
	
	

}	