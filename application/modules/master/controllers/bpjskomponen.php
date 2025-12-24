<?php
/*
	@author : Junis
	10-12-2015
*/
//error_reporting(0);

class Bpjskomponen extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_bpjs'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Komponen BPJS";	        
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
		$data['list_bpjs']=$this->m_bpjs->list_bpjskomponen()->result();
		$data['list_opt_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
		$this->template->display('master/bpjs/bpjskomponen/v_list',$data);
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
			$data['dtl_bpjs']=$this->m_bpjs->dtl_bpjskomponen($kodebpjs);
			$data['list_opt_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
			$this->template->display('master/bpjs/bpjskomponen/v_edit',$data);
		}		
	}
	
	function hps($kodekomp){	
		$cek_delete=$this->m_bpjs->cek_del_bpjskom($kodekomp);		
		//$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/bpjskomponen/index/del_exist');
		} else {			
			$this->db->where('kodekomponen',$kodekomp);
			$this->db->delete('sc_mst.komponen_bpjs');
			redirect('master/bpjskomponen/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodebpjs=strtoupper(trim($this->input->post('kdbpjs')));
		$kodekompbpjs=strtoupper(trim($this->input->post('kdkompbpjs')));
		$namakompbpjs=strtoupper($this->input->post('namakompbpjs'));				
		$besper=$this->input->post('perusahaan');				
		$beskar=$this->input->post('karyawan');				
		$total=$this->input->post('total');				
		$cek_bpjs=$this->m_bpjs->cek_bpjskomponen($kodebpjs,$kodekompbpjs);
		if ($tipe=='input') {
			if ($cek_bpjs>0){
				redirect('master/bpjs/index/exist');
			} else {
				$info_input=array(
					'kode_bpjs'=>strtoupper($kodebpjs),
					'kodekomponen'=>$kodekompbpjs,					
					'namakomponen'=>$namakompbpjs,					
					'besaranperusahaan'=>$besper,					
					'besarankaryawan'=>$beskar,					
					'totalbesaran'=>$total					
				);
				$this->db->insert('sc_mst.komponen_bpjs',$info_input);				
				redirect('master/bpjskomponen/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																					
					'kode_bpjs'=>strtoupper($kodebpjs),
					'kodekomponen'=>$kodekompbpjs,					
					'namakomponen'=>$namakompbpjs,					
					'besaranperusahaan'=>$besper,					
					'besarankaryawan'=>$beskar,					
					'totalbesaran'=>$total					
			);				
			$this->db->where('kodekomponen',$kodekompbpjs);
			$this->db->update('sc_mst.komponen_bpjs',$info_edit1);
			redirect('master/bpjskomponen/index/success');
			//redirect("master/bpjskomponen/edit/$kodekompbpjs/upsuccess");					
		} else {
			redirect('master/bpjskomponen/index/notacces');
		}		
	}
}