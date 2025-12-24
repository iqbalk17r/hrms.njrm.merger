<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Prov extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geo'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Provinsi";	        
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
		$data['list_prov']=$this->m_geo->list_prov()->result();
		$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
		$this->template->display('master/geo/prov/v_prov',$data);
    }
	
	function edit($kodenegara,$kodeprov){
		if (empty($kodeprov)){
			redirect('master/prov/');
		} else {
			$data['title']='EDIT DATA prov';			
			if($this->uri->segment(6)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>"."<meta http-equiv='refresh' content='4; URL=http://poin.nusaboard.co.id'>";				
			}
			else {
				$data['message']='';
			}
			$data['dtl_prov']=$this->m_geo->dtl_prov($kodenegara,$kodeprov);
			$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
			$this->template->display('master/geo/prov/v_editprov',$data);
		}		
	}
	
	function hps($kodenegara,$kodeprov){	
		$cek_delete=$this->m_geo->cek_del_prov($kodenegara,$kodeprov);		
		if ($cek_delete>0) {
			redirect('master/prov/index/del_exist');
		} else {
			$this->db->where('kodeprov',$kodeprov);
			$this->db->delete('sc_mst.provinsi');
			redirect('master/prov/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodeprov=trim(strtoupper($this->input->post('kdprov')));
		$kodenegara=trim($this->input->post('negara'));
		$namaprov=strtoupper($this->input->post('namaprov'));				
		$cek_prov=$this->m_geo->cek_prov($kodenegara,$kodeprov,$namaprov);
		if ($tipe=='input') {
			if ($cek_prov>0){
				redirect('master/prov/index/exist');
			} else {
				$info_input=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodeprov'=>strtoupper($kodeprov),
					'namaprov'=>$namaprov,
					'inputdate'=>date('Y-m-d H:i:s'),						
					'inputby'=>$this->session->userdata('nik')						
				);
				$this->db->insert('sc_mst.provinsi',$info_input);				
				redirect('master/prov/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(
					'kodenegara'=>strtoupper($kodenegara),
					'namaprov'=>$namaprov,
					'updatedate'=>date('Y-m-d H:i:s'),						
					'updateby'=>$this->session->userdata('nik')	
			);	
			$this->db->where('kodenegara',$kodenegara);
			$this->db->where('kodeprov',$kodeprov);
			$this->db->update('sc_mst.provinsi',$info_edit1);
			//redirect("master/prov/edit/$kodenegara/$kodeprov/upsuccess");
			redirect('master/prov/index/success');
		} else {
			redirect('master/prov/index/notacces');
		}		
	}
}