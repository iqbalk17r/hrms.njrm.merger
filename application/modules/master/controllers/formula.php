<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Formula extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_formula');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="List Setup Formula";
		
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
		$data['list_master']=$this->m_formula->list_master()->result();	
		$data['list_trxtype']=$this->m_formula->q_trxtype()->result();	
		
		//$data['list_karyawan']=$this->m_cuti->list_karyawan()->result();
		
        $this->template->display('master/formula/v_list',$data);
    }
	
	
	function add_formula(){
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
		$no_urut1=$this->m_formula->beri_no_urut($kdrumus)->row_array();
		$no_urut=$no_urut1['nomor']+1;
		$cek=$this->m_formula->cek($kdrumus)->num_rows();
		$master=array(
			'kdrumus'=>strtoupper($kdrumus),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		
		$detail=array(
			'kdrumus'=>strtoupper($kdrumus),
			'tipe'=>strtoupper($tipe),
			'keterangan'=>strtoupper($keterangan),
			'aksi'=>$aksi,
			'aksi_tipe'=>$aksi_tipe,
			'no_urut'=>$no_urut,
			'tetap'=>$teta,
			'taxable'=>$taxable,
			'deductible'=>$deductible,
			'regular'=>$regular,
			'cash'=>$cash,
			
			
		);
		if ($cek==0) {
			$this->db->insert('sc_mst.master_formula',$master);
			//$this->db->insert('sc_mst.detail_formula',$detail);
		
		} else {
			$this->db->insert('sc_mst.detail_formula',$detail);
		}
		
		redirect("master/formula/index/rep_succes");
		
	}
	
	function detail($kdrumus){
		$data['title']="List Setup Detail Formula";
		$data['kdrumus']=$kdrumus;
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Detail Rumus Tidak Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(5)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
			
		$data['list_detail']=$this->m_formula->list_detail($kdrumus)->result();
		$data['list_trxtype']=$this->m_formula->q_trxtype()->result();		
		  $this->template->display('master/formula/v_detail',$data);
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
	
	public function ajax_list()
	{
		$list = $this->m_cuti->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->nik;		
			$row[] = $person->nmlengkap;		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-success" href="'.site_url('trans/karyawan/detail').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
					<a class="btn btn-sm btn-success" href="'.site_url('trans/mutprom/index').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Mutasi</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->nik)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_karyawan->count_all(),
						"recordsFiltered" => $this->m_karyawan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	

}	