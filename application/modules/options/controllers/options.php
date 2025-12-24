<?php

/*
	@author : Fiky Ashariza
	18-03-2016
*/

class Options extends MX_Controller{
		
	
	function __construct(){
        parent::__construct();
		       
		$this->load->model('m_options');
		$this->load->library('template');
		$this->load->helper('url');
		 if(!$this->session->userdata('username')){
           redirect('dashboard');
        }
       
	}
	
	
	
	function index(){
			
		$cek=$this->m_options->q_ceksesion()->num_rows();
		if($cek==0){
			redirect('dashboard');			
			$data['cek_it']=null;
		} else {
			$data['cek_it']='YES';
		}
		if($this->uri->segment(3)=="succes_add")
            $data['message']="<div class='alert alert-warning'>SUKSES TAMBAH</div>";
		else if($this->uri->segment(3)=="succes_upd")
			$data['message']="<div class='alert alert-warning'>SUKSES UPDATE</div>";
		else if($this->uri->segment(3)=="del_success")
			$data['message']="<div class='alert alert-warning'>SUKSES HAPUS</div>";
		else
			$data['message']="";
		
		
		$data['title']='CONFIGURASI SET';
		$data['opt']=$this->m_options->q_options()->result();
		
		$this->template->display('options/view_options',$data);
		
	}
	function simpan(){
		$type=$this->input->post('type');
		$kode=$this->input->post('kode1');
		$configname=$this->input->post('configname1');
		$valnum=$this->input->post('valnum1');
		$valchar=$this->input->post('valchar1');
		$valdate=$this->input->post('valdate1');
		$status=$this->input->post('status1');
		
		$info=array(
				'kode'=>$kode,
				'configname'=>$configname,
				'valnum'=>$valnum,
				'valchar'=>$valchar,
				'valdate'=>$valdate,
				'status'=>$status
		);
		if ($type=='input'){
			$this->db->insert('sc_poin.configpoin',$info);
			redirect("options/index/succes_add");
		} else if ($type=='edit'){
			$this->db->where('kode',$kode);
			$this->db->update('sc_poin.configpoin',$info);
			redirect("options/index/succes_upd");
		}  else {
			redirect("options/index/error");
		}
	}	
	
	function hps($kode){
		$this->db->where('kode',$kode);
		$this->db->delete('sc_poin.configpoin');
		redirect("options");
		
	}
	
	function ceknumrows(){
	$query = $this->db->query('select * from sc_mst.user');

	echo $query->num_rows();
	}
	
	
	function op_admin(){
		$username=$this->session->userdata('username');		
		$cek=$this->m_options->q_ceksesion2($username);
		if($cek==0){
			redirect('dashboard');
		}
		if($this->uri->segment(3)=="succes_add")
            $data['message']="<div class='alert alert-warning'>SUKSES TAMBAH</div>";
		else if($this->uri->segment(3)=="succes_upd")
			$data['message']="<div class='alert alert-warning'>SUKSES UPDATE</div>";
		else 
			$data['message']="";
		
		$data['title']='OPTIONS ADMIN';
		$data['opt']=$this->m_options->q_options()->result();
		
		$this->template->display('options/view_options2',$data);
		
	}
	
	function opt_config(){
		$data['title']='OPTIONS CONFIG';
		
		//$data['tahun']=$this->m_options->q_tahun()->row_array();
		
		$data['tahun']=$this->m_options->q_opt('THN');
		$data['awal']=$this->m_options->q_opt('ADM01');
		$data['akhir']=$this->m_options->q_opt('ADM02');
		$data['admin']=$this->m_options->q_opt('ADM');
		$data['hp']=$this->m_options->q_opt('HP');
		$data['list_admin']=$this->m_options->q_masteruser()->result();
		$this->template->display('options/view_options3',$data);
	}
	
	function simpanconfig(){
		

	
		$thn=$this->input->post('tahunperiode');
		$perawal=$this->input->post('tahunawal');
		$perakhir=$this->input->post('tahunakhir');
		$adm=$this->input->post('useradmin');
		$hp=$this->input->post('handphone');
		$data1 = array(		   
			  'kode' => 'My title' ,
			  'valchar' => 'My Name 2'			
		);
		
		//update tahun

		
		$this->db->where('kode','THN');		
		$this->db->update('sc_poin.configpoin',array('valchar'=>$thn));
		//update periode awal
		$this->db->where('kode','ADM01');
		$this->db->update('sc_poin.configpoin',array('valdate'=>$perawal));		
		//update periode akhir
		$this->db->where('kode','ADM02');
		$this->db->update('sc_poin.configpoin',array('valdate'=>$perakhir));	
		//update periode admin
		$this->db->where('kode','ADM');
		$this->db->update('sc_poin.configpoin',array('valchar'=>$adm));
		//update periode hp
		$this->db->where('kode','HP');
		$this->db->update('sc_poin.configpoin',array('valchar'=>$hp));
		
		redirect ("dashboard");
	
			
		
	}
	
}

































