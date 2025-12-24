<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutpromot extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_mutpromot','master/m_department','master/m_jabatan','master/m_akses'));
		$this->load->library(array('form_validation','template','upload','pdf'));   
		
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	function index()
	{
		$nik=$this->session->userdata('nik');
	
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
		
		$nama=$nik;
		$kmenu='I.T.A.14';
		$data['list_opt_dept']=$this->m_department->q_department()->result();
		$data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
		$data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
		$data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
		$data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
		$data['list_opt_atasan']=$this->m_mutpromot->list_karyawan()->result();
		$data['list_karyawan']=$this->m_mutpromot->list_karyawan()->result();
		$data['list_mutasi']=$this->m_mutpromot->get_mutasi()->result();
		//$data['list_mutasi']=$this->m_mutpromot->list_mutasi->result();
		$data['title']='MUTASI & PROMOSI ';
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$this->template->display('trans/mutpromot/v_mutpromot',$data);
	}	
	
	function save (){		
		$type=trim($this->input->post('type'));
		$nik=trim($this->input->post('newnik'));
		$newkddept=strtoupper(trim($this->input->post('newkddept')));
		$newkdsubdept=strtoupper(trim($this->input->post('newkdsubdept')));
		$newkdjabatan=strtoupper(trim($this->input->post('newkdjabatan')));
		$newkdlevel=strtoupper(trim($this->input->post('newkdlevel')));
		$newnikatasan=strtoupper(trim($this->input->post('newnikatasan')));
		$newnikatasan2=strtoupper(trim($this->input->post('newnikatasan')));
		$nosk=strtoupper(trim($this->input->post('nodoksk')));
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
			  'newnikatasan2'=>$newnikatasan2,
			  'nodoksk'=>$nosk,
			  'tglsk'=>$tglsk,
			  'tglmemo'=>$tglmemo,
			  'tglefektif'=>$tglefektif,
			  'ket'=>$ket,
			  'inputdate'=>date('Y-m-d H:i:s'),
			  'inputby'=>$this->session->userdata('nik')			  
		);
		
		$this->db->insert('sc_tmp.mutasi',$info);
		redirect("trans/mutpromot/index/$nik/success");
	/*	if ($type=='input'){			
			$cek=$this->db->query("select * from sc_tmp.mutasi where nik='$nik'")->num_rows();
			if ($cek>0){
				redirect("trans/mutprom/index/$nik/app_pen");
			}
			$this->db->insert('sc_tmp.mutasi',$info);
			redirect("trans/mutprom/index/$nik/success");
		}
	*/	
	}
	
	function delete($id,$nik){		
		$this->db->where('nik',$nik);
		$this->db->where('nodokumen',$id);
		$this->db->delete('sc_mst.mutasi');
		redirect("trans/mutpromot/index/$nik/del");
	}
	function approve($id,$nik){		
		$this->db->query("update sc_mst.mutasi set status='P' where nodokumen='$id' and nik='$nik'");
		redirect("trans/mutpromot/index/$nik/app_success");
	}
	
}
