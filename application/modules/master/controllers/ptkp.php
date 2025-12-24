<?php
/*
	@author : Junis
	10-12-2015
*/
//error_reporting(0);

class Ptkp extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        
        $this->load->model('m_bpjs');		
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Jenis PTKP";	        
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
		$data['list_ptkp']=$this->m_bpjs->list_ptkp()->result();		
		$this->template->display('master/bpjs/ptkp/v_list',$data);
    }
	
	function edit($kodebpjs){
		if (empty($kodebpjs)){
			redirect('master/bpjs/');
		} else {
			$data['title']='EDIT DATA PTKP';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_bpjs']=$this->m_bpjs->dtl_ptkp($kodebpjs);
			$this->template->display('master/bpjs/ptkp/v_edit',$data);
		}		
	}
	
	function hps($kodebpjs){	
		//$cek_delete=$this->m_bpjs->cek_del_bpjs($kodebpjs);		
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/ptkp/index/del_exist');
		} else {
			$this->db->where('kodeptkp',$kodebpjs);
			$this->db->delete('sc_mst.ptkp');
			redirect('master/ptkp/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodebpjs=strtoupper(trim($this->input->post('kdptkp')));
		$besaranptkp=strtoupper($this->input->post('besaranptkp'));				
		$cek_bpjs=$this->m_bpjs->cek_ptkp($kodebpjs);
		if ($tipe=='input') {
			if ($cek_bpjs>0){
				redirect('master/ptkp/index/exist');
			} else {
				$info_input=array(
					'kodeptkp'=>strtoupper($kodebpjs),
					'besaranpertahun'=>$besaranptkp,					
				);
				$this->db->insert('sc_mst.ptkp',$info_input);				
				redirect('master/ptkp/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																					
					'besaranpertahun'=>$besaranptkp,					
			);	
			$this->db->where('kodeptkp',$kodebpjs);
			$this->db->update('sc_mst.ptkp',$info_edit1);
			redirect('master/ptkp/index/success');
			//redirect("master/ptkp/edit/$kodebpjs/upsuccess");					
		} else {
			redirect('master/ptkp/index/notacces');
		}		
	}
}