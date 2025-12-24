<?php
/*
	@author : Junis
	10-12-2015
*/
//error_reporting(0);

class Faskes extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_bpjs'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Fasilitas Kesehatan BPJS";	        
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
		$data['list_faskes']=$this->m_bpjs->list_faskes()->result();		
		$this->template->display('master/bpjs/faskes/v_list',$data);
    }
	
	function edit($kodebpjs){
		if (empty($kodebpjs)){
			redirect('master/bpjs/');
		} else {
			$data['title']='Edit data faskes bpjs';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_faskes']=$this->m_bpjs->dtl_faskes($kodebpjs);
			$this->template->display('master/bpjs/faskes/v_edit',$data);
		}		
	}
	
	function hps($kodebpjs){	
		//$cek_delete=$this->m_bpjs->cek_del_bpjs($kodebpjs);		
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/faskes/index/del_exist');
		} else {
			$this->db->where('kodefaskes',$kodebpjs);
			$this->db->delete('sc_mst.faskes_bpjs');
			redirect('master/faskes/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodefaskes=strtoupper(trim($this->input->post('kdfaskes')));
		$namafaskes=strtoupper($this->input->post('namafaskes'));				
		$cek_faskes=$this->m_bpjs->cek_faskes($kodefaskes);
		if ($tipe=='input') {
			if ($cek_faskes>0){
				redirect('master/faskes/index/exist');
			} else {
				$info_input=array(
					'kodefaskes'=>strtoupper($kodefaskes),
					'namafaskes'=>$namafaskes,					
				);
				$this->db->insert('sc_mst.faskes_bpjs',$info_input);				
				redirect('master/faskes/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																					
					'namafaskes'=>$namafaskes,					
			);	
			$this->db->where('kodefaskes',$kodefaskes);
			$this->db->update('sc_mst.faskes_bpjs',$info_edit1);
			redirect('master/faskes/index/success');
			//redirect("master/faskes/edit/$kodefaskes/upsuccess");					
		} else {
			redirect('master/faskes/index/notacces');
		}		
	}
}