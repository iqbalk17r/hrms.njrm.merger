<?php
/*
	@author : hanif_anak_metal
	7-9-2014
*/
error_reporting(0);

class Uang extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
        //$this->load->model('hrd/m_hrd'); klo 1 folder ckup m_hrd
        $this->load->model(array('m_uang'));
        $this->load->library(array('form_validation','template','pdf'));
        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
		if($this->uri->segment(4)=="success"){
			$data['message']="<div class='alert alert-success'>Data Sukses Di Simpan/div>";
		} else if($this->uri->segment(4)=="exist"){
			$data['message']="<div class='alert alert-danger'>Peringatan Data Sudah Ada !!!</div>";
		} else if($this->uri->segment(4)=="del_exist"){
			$data['message']="<div class='alert alert-danger'>Ada data yang terkait</div>";
		} else {
			$data['message']='';
		}
        $data['title']="Daftar Besaran Uang Makan";
		$nama=$this->session->userdata('username');
		$data['jeneng']=strtoupper($nama);
		$data['qjabatan']=$this->m_uang->q_jabatan()->result();
		$data['userosin']=$this->m_uang->q_uang()->result();
		$data['kantin']=$this->m_uang->q_kantin()->result();
		$data['list_kantin']=$this->m_uang->q_kantor()->result();
		$this->template->display('master/uang/view_uang',$data);
    }
	
	function laporan(){
        $data['title']="Laporan Uang Makan";
		$nama=$this->session->userdata('username');
		/*$data['jeneng']=strtoupper($nama);
		$data['qjabatan']=$this->m_uang->q_jabatan()->result();
		$data['userosin']=$this->m_uang->q_uang()->result();*/
        $this->template->display('master/uang/view_laporan',$data);
    }

	function add_um(){		
		$kdlvl=$this->input->post('kdlvl');
		$keterangan=$this->input->post('keterangan');
		$besaran=$this->input->post('besaran');
		$inputby=$this->session->userdata('nik');
		$inputdate=date('Y-m-d');

		$cek=$this->m_uang->q_uang_cek($kdlvl)->num_rows();
		if($cek=0) {
			$info = array(
				'kdlvl' => strtoupper($kdlvl),
				'keterangan' => strtoupper($keterangan),
				'besaran' => $besaran,
				'inputby' => $inputby,
				'inputdate' => $inputdate,
			);
			$this->m_uang->simpan_um($info);
			redirect('master/uang/success');
		} else {
			redirect('master/uang/exist');
		}
	}
	
	function add_kantin(){				
		$kantorcabang=$this->input->post('kantorcabang');
		$besaran=$this->input->post('besaran');
			$uye=$this->m_uang->q_uang();
                $info=array(                    
                    'kd_cab'=>strtoupper($kantorcabang),
					'besaran'=>$this->input->post('besaran')					
                );
                $this->db->insert('sc_hrd.kantin',$info);				
                redirect('master/uang');
	}
	
	function hps_um($kd){
		$this->db->where('kdjabatan',$kd);
		$this->db->delete('sc_hrd.uangmakan');
		redirect('master/uang');
	}
	
	function hps_kantin($id){
		$this->db->where('id',$id);
		$this->db->delete('sc_hrd.kantin');
		redirect('master/uang');
	}
	
	function pdf(){
		$this->pdf->load_view('master/uang/view_pdf');
		$this->pdf->set_paper('folio','potrait');
		$this->pdf->render();
		$this->pdf->stream("Laporan Uang Makan.pdf");
	}
}