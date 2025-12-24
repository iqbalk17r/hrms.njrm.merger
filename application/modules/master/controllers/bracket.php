<?php
/*
	@author : Junis
	10-12-2015
*/
//error_reporting(0);

class Bracket extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_bpjs'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Setting Bracket";	        
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
		$data['list_bracket']=$this->m_bpjs->list_bracket()->result();		
		$this->template->display('master/bpjs/bracket/v_list',$data);
    }
	
	function edit($kodebpjs){
		if (empty($kodebpjs)){
			redirect('master/bpjs/');
		} else {
			$data['title']='EDIT Setting Bracket';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_bracket']=$this->m_bpjs->dtl_bracket($kodebpjs);
			$this->template->display('master/bpjs/bracket/v_edit',$data);
		}		
	}
	
	function hps($kodebpjs){	
		//$cek_delete=$this->m_bpjs->cek_del_bpjs($kodebpjs);		
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/bracket/index/del_exist');
		} else {
			$this->db->where('nourut',$kodebpjs);
			$this->db->delete('sc_mst.bracket');
			redirect('master/bracket/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kdtipe=trim($this->input->post('kdtipe'));
		$batasatas=$this->input->post('batasatas');				
		$batasbawah=$this->input->post('batasbawah');				
		$nominal=$this->input->post('nominal');				
		$keterangan=$this->input->post('keterangan');				
		$cek_bpjs=$this->m_bpjs->cek_bracket($kodebpjs);
		if ($tipe=='input') {
			if ($cek_bpjs>0){
				redirect('master/bpjs/index/exist');
			} else {
				$info_input=array(
					'tipe'=>strtoupper($kdtipe),
					'batasbawah'=>$batasbawah,					
					'batasatas'=>$batasatas,					
					'nominal'=>$nominal,					
					'keterangan'=>$keterangan,					
				);
				$this->db->insert('sc_mst.bracket',$info_input);				
				redirect('master/bracket/index/success');
			}			
		} else if ($tipe=='edit'){			
			$nourut=$this->input->post('nourut');
			$info_edit1=array(																										
					'batasbawah'=>$batasbawah,					
					'batasatas'=>$batasatas,					
					'nominal'=>$nominal,					
					'keterangan'=>$keterangan,				
			);	
			$this->db->where('nourut',$nourut);
			$this->db->update('sc_mst.bracket',$info_edit1);
			redirect('master/bracket/index/success');
			//redirect("master/bracket/edit/$nourut/upsuccess");					
		} else {
			redirect('master/bracket/index/notacces');
		}		
	}
}