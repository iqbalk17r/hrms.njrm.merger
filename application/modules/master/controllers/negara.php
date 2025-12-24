<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Negara extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geo'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Negara";	        
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
		$data['list_negara']=$this->m_geo->list_negara()->result();
		$this->template->display('master/geo/negara/v_negara',$data);
    }
	
	function edit($kodenegara){
		if (empty($kodenegara)){
			redirect('master/negara/');
		} else {
			$data['title']='EDIT DATA negara';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_negara']=$this->m_geo->dtl_negara($kodenegara);
			$this->template->display('master/geo/negara/v_editnegara',$data);
		}		
	}
	
	function hps($kodenegara){	
		$cek_delete=$this->m_geo->cek_del_negara($kodenegara);		
		if ($cek_delete>0) {
			redirect('master/negara/index/del_exist');
		} else {
			$this->db->where('kodenegara',$kodenegara);
			$this->db->delete('sc_mst.negara');
			redirect('master/negara/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodenegara=trim(strtoupper($this->input->post('kdnegara')));
		$namanegara=strtoupper($this->input->post('namanegara'));				
		$cek_negara=$this->m_geo->cek_negara($kodenegara);
		if ($tipe=='input') {
			if ($cek_negara>0){
				redirect('master/negara/index/exist');
			} else {
				$info_input=array(
					'kodenegara'=>strtoupper($kodenegara),
					'namanegara'=>$namanegara,
					'inputdate'=>date('Y-m-d H:i:s'),						
					'inputby'=>$this->session->userdata('nik')						
				);
				$this->db->insert('sc_mst.negara',$info_input);				
				redirect('master/negara/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																					
					'namanegara'=>$namanegara,
					'updatedate'=>date('Y-m-d H:i:s'),						
					'updateby'=>$this->session->userdata('nik')	
			);	
			$this->db->where('kodenegara',$kodenegara);
			$this->db->update('sc_mst.negara',$info_edit1);
			redirect("master/negara/edit/$kodenegara/upsuccess");					
		} else {
			redirect('master/negara/index/notacces');
		}		
	}
}