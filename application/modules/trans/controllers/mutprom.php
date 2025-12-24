<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutprom extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_mutprom','master/m_department','master/m_jabatan','m_karyawan'));
		$this->load->library(array('form_validation','template','upload','pdf'));   
		
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	public function index($nik)
	{
		if (empty($nik)){
			redirect('trans/karyawan/index');
		}
		
		if($this->uri->segment(5)=="app_pen") {
            $data['message']="<div class='alert alert-warning'>Data Sebelumnya Belum di Approval!</div>";
		}
		else if($this->uri->segment(5)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(5)=="upsuccess"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate </div>";
		}
		else if($this->uri->segment(5)=="app_success"){			
            $data['message']="<div class='alert alert-success'>Data Telah di Approval</div>";
		}
		else if($this->uri->segment(5)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
		else if($this->uri->segment(5)=="del_exist"){			
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
		}
        else {
            $data['message']='';
		}
		$data['list_opt_dept']=$this->m_department->q_department()->result();
		$data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
		$data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
		$data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
		$data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
		$data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
		$data['list_mutasi']=$this->m_mutprom->get_mutasi($nik)->result();
		$nm=$this->db->query("select nmlengkap from sc_mst.karyawan where nik='$nik'")->row_array();
		$data['nama']=$nm['nmlengkap'];
		$data['title']='MUTASI & PROMOSI '.$nm['nmlengkap'];
		$data['nik']=$nik;
		$this->template->display('trans/mutprom/v_mutprom',$data);
	}	
	
	function save (){		
		$type=trim($this->input->post('type'));
		$nik=trim($this->input->post('nik'));
		$newkddept=strtoupper(trim($this->input->post('newkddept')));
		$newkdsubdept=strtoupper(trim($this->input->post('newkdsubdept')));
		$newkdjabatan=strtoupper(trim($this->input->post('newkdjabatan')));
		$newkdlevel=strtoupper(trim($this->input->post('newkdlevel')));
		$newnikatasan=strtoupper(trim($this->input->post('newnikatasan')));
		$nodoksk=strtoupper(trim($this->input->post('nodoksk')));
		$tglsk=strtoupper(trim($this->input->post('tglsk')));
		$tglmemo=strtoupper(trim($this->input->post('tglmemo')));
		$tglefektif=strtoupper(trim($this->input->post('tglefektif')));
		$ket=strtoupper(trim($this->input->post('ket')));
		$info=array(
			  'nik'=>$nik,			  			  			  
			  'newkddept'=>$newkddept,
			  'newkdsubdept'=>$newkdsubdept,
			  'newkdjabatan'=>$newkdjabatan,
			  'newkdlevel'=>$newkdlevel,
			  'newnikatasan'=>$newnikatasan,
			  'nodoksk'=>$nodoksk,
			  'tglsk'=>$tglsk,
			  'tglmemo'=>$tglmemo,
			  'tglefektif'=>$tglefektif,
			  'ket'=>$ket,
			  'inputdate'=>date('Y-m-d H:i:s'),
			  'inputby'=>$this->session->userdata('nik')			  
		);
		if ($type=='input'){			
			$cek=$this->db->query("select * from sc_tmp.mutasi where nik='$nik'")->num_rows();
			if ($cek>0){
				redirect("trans/mutprom/index/$nik/app_pen");
			}
			$this->db->insert('sc_tmp.mutasi',$info);
			redirect("trans/mutprom/index/$nik/success");
		}
	}
	
	function delete($id,$nik){		
		$this->db->where('nik',$nik);
		$this->db->where('nodokumen',$id);
		$this->db->delete('sc_tmp.mutasi');
		redirect("trans/mutprom/index/$nik/del");
	}
	function approve($id,$nik){
		$this->db->query("insert into sc_mst.mutasi select * from sc_tmp.mutasi where nodokumen='$id'");
		redirect("trans/mutprom/index/$nik/app_success");
	}
	
}
