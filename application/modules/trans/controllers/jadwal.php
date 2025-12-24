<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_karyawan','m_jadwal','master/m_geo','master/m_agama','master/m_nikah','master/m_department','master/m_jabatan','master/m_bpjs','master/m_group_penggajian','master/m_bank'));
		$this->load->library(array('form_validation','template','upload','pdf'));   
		
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	public function index()
	{		
		$data['title']='Jadwal Karyawan';
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(4)=="upsuccess"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate </div>";
		}
		else if($this->uri->segment(4)=="notacces"){			
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(4)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
		else if($this->uri->segment(4)=="del_exist"){			
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
		}
        else {
            $data['message']='';
		}
		$data['opt_regu']=$this->m_jadwal->opt_regu()->result();
		$data['opt_jamkerja']=$this->m_jadwal->opt_jamkerja()->result();
		$this->template->display('trans/jadwal/v_jadwal',$data);		
	}
	public function ajax_add()
	{
		$kdregu=$this->input->post('regu');
		$kdjamkrja=$this->input->post('kodejamkerja');
		$tgl=$this->input->post('tgl');
		
		$cek=$this->m_jadwal->cek_exist($kdregu,$kdjamkrja,$tgl);
		if ($cek>0){
			echo json_encode(array("status" => FALSE));
		} else {
			$isi = array(								
				//'shift_tipe' => $this->input->post('shiftkrj'),				
				'kdregu' => $this->input->post('regu'),				
				'kodejamkerja' => $this->input->post('kodejamkerja'),				
				'tgl' => $this->input->post('tgl'),				
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik'),		
			);
			$insert = $this->db->insert('sc_trx.jadwalkerja',$isi);
			echo json_encode(array("status" => TRUE));
		}
				
	}
	public function ajax_list()
	{
		$list = $this->m_jadwal->jadwalkerja()->result();				
		
		$data = array();		
		foreach ($list as $fetch) {			
			$e = array();
			$e['id'] = $fetch->id;
			$e['title'] = $fetch->kdregu.' mesin '.$fetch->kdmesin.' '.$fetch->nmjam_kerja;
			$e['start'] = $fetch->tgl;
			$e['isi'] = '';
			$e['urlhps'] = '<a class="btn btn-sm btn-primary" href="javascript:void()" data-dismiss="modal" title="Edit" onclick="edit_person('."'".trim($fetch->id)."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
						<a class="btn btn-sm btn-warning" href="javascript:void()" data-dismiss="modal" title="Detail" onclick="detail_person('."'".trim($fetch->id)."'".')"><i class="glyphicon glyphicon-file"></i> Detail</a>
						<a class="btn btn-sm btn-danger" href="javascript:void()" data-dismiss="modal" title="Hapus" onclick="delete_person('."'".trim($fetch->id)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$e['inputid'] =trim($fetch->id);		
			$e['backgroundColor'] = trim($fetch->warna);	
			$e['borderColor'] = trim($fetch->warna);				
			$data[] = $e;
		}

		//$output = array(						
			//			"events" => $data,
			//	);
		//output to json format
		//echo json_encode($output);
		echo json_encode($data);
	}
	
	public function ajax_edit($id)
	{
		//$id=$this->input->post('eventid');
		$data = $this->m_jadwal->jadwalkerja_id($id)->row();
		echo json_encode($data);
	}	
	
	function cek_ajax(){
		$id=$this->input->post('eventid');		
		echo json_encode(array("status" => TRUE,"idevent"=>$id));
	}
	
	public function ajax_delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('sc_trx.jadwalkerja');
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_update()
	{
		$data = array(
				//'shift_tipe' => $this->input->post('shiftkrj'),
				'kdregu' => $this->input->post('regu'),
				'kodejamkerja' => $this->input->post('kodejamkerja'),
				'tgl' => $this->input->post('tgl'),
				'updatedate' => date('d-m-Y H:i:s'),
				'updateby' => $this->session->userdata('nik'),
			);
		$this->m_jadwal->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));		
		$data['message']='Update succes';
	}
	
	public function detail_list()
	{
		$list = $this->m_karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->nik;		
			$row[] = $person->nmlengkap;		
			$row[] = $person->nmdept;		
			$row[] = $person->nmjabatan;		
			$row[] = $person->tglmasuk;		

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
