<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Gaji_pokok extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_gaji_pokok');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index($nik){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="List Tunjangan Shift Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
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
			
		//$thn=$this->input->post('tahun');
		//$bln=$this->input->post('bulan');		
		//$nik=$this->input->post('nik');		
		
		$data['list_gp']=$this->m_gaji_pokok->q_gaji_pokok($nik)->result();	
		
		//$data['list_karyawan']=$this->m_cuti->list_karyawan()->result();
		
        $this->template->display('payroll/gaji_pokok/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		//echo "test";
		
		$data['title']="List Karyawan Payroll";
		$data['list_karyawan']=$this->m_gaji_pokok->list_karyawan()->result();
		//$data['list_ijin_khusus']=$this->m_cuti->list_ijin_khusus()->result();
		//$data['list_trxtype']=$this->m_cuti->list_trxtype()->result();
		//$data['list_lk2']=$this->m_cuti->list_karyawan_index($nik)->row_array();
		$data['list_lk']=$this->m_gaji_pokok->list_karyawan()->result();
		$this->template->display('payroll/gaji_pokok/v_list_karyawan',$data);
		
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