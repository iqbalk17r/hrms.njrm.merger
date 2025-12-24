<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Indperilaku extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_kompetensi'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Indikator Perilaku";	        
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
		$data['list_indperilaku']=$this->m_kompetensi->q_ind_prilaku()->result();
		$this->template->display('master/indperilaku/v_indperilaku',$data);
    }
	
	function edit($lvl_indikator){		
		if (empty($lvl_indikator)){
			redirect('master/indperilaku/');
		} else {
			$data['title']='EDIT DATA Indikator Perilaku';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_indperilaku']=$this->m_kompetensi->dtl_indperilaku($lvl_indikator)->row_array();
			$this->template->display('master/indperilaku/v_edit',$data);
		}		
	}
	
	function hps($lvl_indikator){	
		//$cek_delete=$this->m_kompetensi->cek_del_indperilaku($lvl_indikator);		
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/indperilaku/index/del_exist');
		} else {
			$this->db->where('lvl_indikator',$lvl_indikator);
			$this->db->delete('sc_mst.ind_prilaku');
			redirect('master/indperilaku/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$lvl_indikator=strtoupper(trim($this->input->post('kdindperilaku')));
		$namaindperilaku=strtoupper($this->input->post('namaindperilaku'));				
		$cek_indperilaku=$this->m_kompetensi->dtl_indperilaku($lvl_indikator)->num_rows();
		if ($tipe=='input') {
			if ($cek_indperilaku>0){
				redirect('master/indperilaku/index/exist');
			} else {
				$info_input=array(
					'lvl_indikator'=>strtoupper($lvl_indikator),
					'uraian'=>$namaindperilaku,					
				);
				$this->db->insert('sc_mst.ind_prilaku',$info_input);				
				redirect('master/indperilaku/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																					
					'uraian'=>$namaindperilaku
			);	
			$this->db->where('lvl_indikator',$lvl_indikator);
			$this->db->update('sc_mst.ind_prilaku',$info_edit1);
			redirect('master/indperilaku/index/success');
			//redirect("master/indperilaku/edit/$lvl_indikator/upsuccess");					
		} else {
			redirect('master/indperilaku/index/notacces');
		}		
	}
}