<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Kotakab extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geo'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Kota / Kabupaten";	        
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
		$data['list_kotakab']=$this->m_geo->list_kotakab()->result();
		$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
		$this->template->display('master/geo/kotakab/v_kotakab',$data);
    }
	
	function edit($kodenegara,$kodeprov,$kodekotakab){
		if (empty($kodekotakab)){
			redirect('master/kotakab/');
		} else {
			$data['title']='EDIT DATA kotakab';			
			if($this->uri->segment(7)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_kotakab']=$this->m_geo->dtl_kotakab($kodenegara,$kodeprov,$kodekotakab);
			$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
			$data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
			$this->template->display('master/geo/kotakab/v_editkotakab',$data);
		}		
	}
	
	function hps($kodekotakab){	
		//$cek_delete=$this->m_geo->cek_del($kodekotakab);
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/kotakab/index/del_exist');
		} else {
			$this->db->where('kodekotakab',$kodekotakab);
			$this->db->delete('sc_mst.kotakab');
			redirect('master/kotakab/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodekotakab=strtoupper(trim($this->input->post('kdkotakab')));
		$kodenegara=trim($this->input->post('negara'));
		$kodeprov=trim($this->input->post('provinsi'));
		$namakotakab=strtoupper($this->input->post('namakotakab'));				
		$cek_kotakab=$this->m_geo->cek_kotakab($kodenegara,$kodeprov,$kodekotakab,$namakotakab);
		if ($tipe=='input') {
			if ($cek_kotakab>0){
				redirect('master/kotakab/index/exist');
			} else {
				$info_input=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodeprov'=>strtoupper($kodeprov),
					'kodekotakab'=>strtoupper($kodekotakab),
					'namakotakab'=>$namakotakab,
					'inputdate'=>date('Y-m-d H:i:s'),						
					'inputby'=>$this->session->userdata('nik')						
				);
				$this->db->insert('sc_mst.kotakab',$info_input);				
				redirect('master/kotakab/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodeprov'=>strtoupper($kodeprov),					
					'namakotakab'=>$namakotakab,
					'updatedate'=>date('Y-m-d H:i:s'),						
					'updateby'=>$this->session->userdata('nik')	
			);	
			$this->db->where('kodenegara',$kodenegara);
			$this->db->where('kodeprov',$kodeprov);
			$this->db->where('kodekotakab',$kodekotakab);
			$this->db->update('sc_mst.kotakab',$info_edit1);
			redirect('master/kotakab/index/success');
			//redirect("master/kotakab/edit/$kodenegara/$kodeprov/$kodekotakab/upsuccess");					
		} else {
			redirect('master/kotakab/index/notacces');
		}		
	}
}