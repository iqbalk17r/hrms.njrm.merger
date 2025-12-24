<?php
/*
	@author : Junis
	10-12-2015
*/
//error_reporting(0);

class Jnsbpjs extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_bpjs'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Jenis BPJS";	        
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
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
		$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();		
		$this->template->display('master/bpjs/jnsbpjs/v_list',$data);
    }
	
	function edit($kodebpjs){
		if (empty($kodebpjs)){
			redirect('master/bpjs/');
		} else {
			$data['title']='EDIT DATA bpjs';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_bpjs']=$this->m_bpjs->dtl_jnsbpjs($kodebpjs);
			$this->template->display('master/bpjs/jnsbpjs/v_edit',$data);
		}		
	}
	
	function hps($kodebpjs){	
		$cek_delete=$this->m_bpjs->cek_del_bpjsjns($kodebpjs);		
		//$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/jnsbpjs/index/del_exist');
		} else {
			$this->db->where('kode_bpjs',$kodebpjs);
			$this->db->delete('sc_mst.jenis_bpjs');
			redirect('master/jnsbpjs/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodebpjs=strtoupper(trim($this->input->post('kdbpjs')));
		$namabpjs=strtoupper($this->input->post('namabpjs'));				
		$cek_bpjs=$this->m_bpjs->cek_jnsbpjs($kodebpjs);
		if ($tipe=='input') {
			if ($cek_bpjs>0){
				redirect('master/jnsbpjs/index/exist');
			} else {
				$info_input=array(
					'kode_bpjs'=>strtoupper($kodebpjs),
					'nama_bpjs'=>$namabpjs,					
				);
				$this->db->insert('sc_mst.jenis_bpjs',$info_input);				
				redirect('master/jnsbpjs/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																					
					'nama_bpjs'=>$namabpjs,					
			);	
			$this->db->where('kode_bpjs',$kodebpjs);
			$this->db->update('sc_mst.jenis_bpjs',$info_edit1);
			redirect('master/jnsbpjs/index/success');
			//redirect("master/jnsbpjs/edit/$kodebpjs/upsuccess");					
		} else {
			redirect('master/jnsbpjs/index/notacces');
		}		
	}
}