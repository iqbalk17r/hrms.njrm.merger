<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)

class Department extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_department');
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Fiky_wilayah','Fiky_grade'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
 function index(){
        //echo "test";
		$nama=$this->session->userdata('username');
		$data['title']="List Master Department";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="kode_succes")
            $data['message']="<div class='alert alert-success'>Kode Berhasil Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		
		$data['list_department']=$this->m_department->q_department()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/department/v_department',$data);
    }
	
	function hps_department($kddept){
	
		$this->db->where('kddept',$kddept);
		$this->db->delete('sc_mst.departmen');
		redirect('master/department/index');
	}
	
	function hps_subdepartment($kdsubdept){
	
		$this->db->where('kdsubdept',$kdsubdept);
		$this->db->delete('sc_mst.subdepartmen');
		redirect('master/department/subdepartment');
	}
	
	function subdepartment(){
		//echo "test";
		$nama=$this->session->userdata('username');
		$data['title']="List Master Sub Department";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Berhasil Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_department']=$this->m_department->q_department()->result();
		$data['list_subdepartment']=$this->m_department->q_subdepartment()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/subdepartment/v_subdepartment',$data);
	}
	
	function add_department(){
		$kddept=trim(strtoupper(str_replace(" ","",$this->input->post('kddept'))));
		$nmdept=$this->input->post('nmdept');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$info=array(
			'kddept'=>$kddept,
			'nmdept'=>strtoupper($nmdept),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		
		$cek=$this->m_department->q_cekdepartment($kddept)->num_rows();
		if ($cek>0){
			redirect('master/department/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.departmen',$info);
			redirect('master/department/index/kode_succes');
		}
		//$this->db->where('custcode',$kode);
		
		
		//echo $inputby;
	}
	
	function add_subdepartment(){
		$kdsubdept=trim(strtoupper(str_replace(" ","",$this->input->post('kdsubdept'))));
		$kddept=$this->input->post('kddept');
		$nmdept=$this->input->post('nmsubdept');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$info=array(
			'kdsubdept'=>$kdsubdept,
			'kddept'=>strtoupper($kddept),
			'nmsubdept'=>strtoupper($nmdept),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		$cek1=$this->m_department->q_ceksubdepartment($kdsubdept)->num_rows();
		if ($cek1>0){
			redirect('master/department/subdepartment/kode_failed');
		} else {
			$this->db->insert('sc_mst.subdepartmen',$info);
			redirect('master/department/subdepartment/kode_succes');
		}
		
		//$this->db->where('custcode',$kode);
		//$this->db->insert('sc_mst.subdepartmen',$info);
		//redirect('master/department/subdepartment');
		//echo $inputby;
	}
	function edit_department($kddept){
		$kddept=$this->input->post('kddept');
		$nmdept=$this->input->post('nmdept');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		$info=array(
			//'kodeopt'=>strtoupper($kodeopt),
			//'kddept'=>strtoupper($kddept),
			'nmdept'=>strtoupper($nmdept),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
				
			);
		$this->db->where('kddept',$kddept);	
		$this->db->update("sc_mst.departmen",$info);
		//echo "sukses";
		redirect('master/department/index/rep_succes');
	}
	
	function edit_subdepartment($kdsubdept){
		$kdsubdept=$this->input->post('kdsubdept');
		$kddept=$this->input->post('kddept');
		$nmsubdept=$this->input->post('nmsubdept');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		$info=array(
			//'kodeopt'=>strtoupper($kodeopt),
			//'kddept'=>strtoupper($kddept),
			'kddept'=>strtoupper($kddept),
			'nmsubdept'=>strtoupper($nmsubdept),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
				
			);
		$this->db->where('kdsubdept',$kdsubdept);	
		$this->db->update("sc_mst.subdepartmen",$info);
		//echo "sukses";
		redirect('master/department/subdepartment');
	}

    function req_department($search=null){
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_')
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_grade->getDepartment($data);
    }

    function req_subdepartment($search=null){
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'kddept' => $this->input->post('kddept'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_grade->getSubDepartment($data);
    }

    function req_jabatan($search=null){
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'kdsubdept' => $this->input->post('kdsubdept'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_grade->getJabatan($data);
    }
}
