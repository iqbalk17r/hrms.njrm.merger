<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Jabatan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_jabatan','m_department'));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Fiky_wilayah','Fiky_grade'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
 function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Jabatan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_department']=$this->m_department->q_department()->result();
		$data['list_subdepartment']=$this->m_department->q_subdepartment()->result();
		$data['list_jobgrade']=$this->m_jabatan->q_jobgrade()->result();
		$data['list_jabatan']=$this->m_jabatan->q_jabatan()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/jabatan/v_jabatan',$data);
    }
	function lvljabatan(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Job Grade";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_lvljabatan']=$this->m_jabatan->q_lvljabatan()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/lvljabatan/v_lvljabatan',$data);
    }
	function jobgrade(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Level Grade";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		//$data['list_department']=$this->m_department->q_department()->result();
		//$data['list_subdepartment']=$this->m_department->q_subdepartment()->result();
		//$data['list_lvljabatan']=$this->m_jabatan->q_lvljabatan()->result();
		$data['list_lvljabatan']=$this->m_jabatan->q_lvljabatan()->result();
		$data['list_jobgrade']=$this->m_jabatan->q_jobgrade()->result();
		$data['list_kdlvl']=$this->m_jabatan->q_lvlgp($param=null)->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/jobgrade/v_jobgrade',$data);
    }
	
	
	function add_jabatan(){
		
		$kdjbt=trim(strtoupper(str_replace(" ","",$this->input->post('kdjb'))));
		$kddept=$this->input->post('kddept');
		//$kdsubdept=$this->input->post('kdsubdept');
		$subdept=explode('|',$this->input->post('kdsubdept'));
		$sub=$subdept[1];
		$kdgrade=$this->input->post('kdgrade');
		$nmjbt=$this->input->post('nmjbt');
		$costcenter=$this->input->post('costcenter');
		$uraian=$this->input->post('uraian');
		$lembur=$this->input->post('lembur');
		$shift=$this->input->post('shift');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
        $dtlgrade = $this->m_jabatan->q_cekjobgrade($kdgrade)->row_array();
		$kdlvl = trim($dtlgrade['kdlvl']);

		if ($shift=='t'){
			$shift1=$shift;
		} else{ 
			$shift1='f';
		}
		if ($lembur=='t'){
			$lembur1=$lembur;
		} else{ 
			$lembur1='f';
		}
		//echo $sub;
		$info=array(
			'kdjabatan'=>$kdjbt,
			'kdsubdept'=>strtoupper($sub),
			'kddept'=>strtoupper($kddept),
			'kdgrade'=>strtoupper($kdgrade),
			'nmjabatan'=>strtoupper($nmjbt),
			'uraian'=>strtoupper($uraian),
			'costcenter'=>strtoupper($costcenter),
			'shift'=>strtoupper($shift1),
			'lembur'=>strtoupper($lembur1),
			'kdlvl'=>strtoupper($kdlvl),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_jabatan->q_cekjabatan($kdjbt)->num_rows();
		if ($cek>0){
			redirect('master/jabatan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.jabatan',$info);
			redirect('master/jabatan/index');
		}
		//echo $inputby;
	}
	
	function add_lvljabatan(){
		
		$kdlvl=trim(strtoupper(str_replace(" ","",$this->input->post('kdlvl'))));
		$nmjbt=$this->input->post('nmjbt');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $sub;
		$info=array(
			'kdlvl'=>$kdlvl,
			'nmlvljabatan'=>strtoupper($nmjbt),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		$cek=$this->m_jabatan->q_ceklvljabatan($kdlvl)->num_rows();
		if ($cek>0){
			redirect('master/jabatan/lvljabatan/kode_failed');
		} else {
		//$this->db->where('custcode',$kode);
		$this->db->insert('sc_mst.lvljabatan',$info);
		redirect('master/jabatan/lvljabatan/rep_succes');
		}
		//echo $inputby;
	}
	
	function add_jobgrade(){
		//echo "test";
		$kdgrade=trim(strtoupper(str_replace(" ","",$this->input->post('kdgrade'))));
		//$kddept=$this->input->post('kddept');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$kdlvl=$this->input->post('kdlvl');
		$nmjg=$this->input->post('nmjg');
		$bobot1=str_replace("_","",$this->input->post('bobot1'));
		$bobot2=str_replace("_","",$this->input->post('bobot2'));
		if ($bobot1==NULL){
			$bobot1=0;
		}else {
			$bobot1=$bobot1;
		}
		if ($bobot2==NULL){
			$bobot2=0;
		}else {
			$bobot2=$bobot2;
		}
        $kdlvlgpmin=trim($this->input->post('kdlvlgpmin'));
		$kdlvlgpmax=trim($this->input->post('kdlvlgpmax'));

		$ket=$this->input->post('ket');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $kdjg;
		$info=array(
			'kdgrade'=>$kdgrade,
			'kdlvl'=>strtoupper($kdlvl),
			'nmgrade'=>strtoupper($nmjg),
			'bobot1'=>strtoupper($bobot1),
			'bobot2'=>strtoupper($bobot2),
			'kdlvlgpmin'=>strtoupper($kdlvlgpmin),
			'kdlvlgpmax'=>strtoupper($kdlvlgpmax),
			'keterangan'=>strtoupper($ket),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		$cek=$this->m_jabatan->q_cekjobgrade($kdgrade)->num_rows();
		if ($cek>0){
			redirect('master/jabatan/jobgrade/kode_failed');
		} else {
		//$this->db->where('custcode',$kode);
		$this->db->insert('sc_mst.jobgrade',$info);
		redirect('master/jabatan/jobgrade/rep_succes');
		}
		//echo $inputby;
	}
	
	
	function edit_jabatan($kdjbt){
		$kdjbt=trim(strtoupper(str_replace(" ","",$this->input->post('kdjb'))));
		$kddept=$this->input->post('kddept');
		//$kdsubdept=$this->input->post('kdsubdept');
		$subdept=explode('|',$this->input->post('kdsubdept'));
		$sub=$subdept[1];
		$kdgrade=$this->input->post('kdgrade');
		$nmjbt=$this->input->post('nmjbt');
		$costcenter=$this->input->post('costcenter');
		$uraian=$this->input->post('uraian');
		$lembur=$this->input->post('lembur');
		$shift=$this->input->post('shift');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
        $dtlgrade = $this->m_jabatan->q_cekjobgrade($kdgrade)->row_array();
        $kdlvl = trim($dtlgrade['kdlvl']);
		
		if ($shift=='t'){
			$shift1=$shift;
		} else{ 
			$shift1='f';
		}
		if ($lembur=='t'){
			$lembur1=$lembur;
		} else{ 
			$lembur1='f';
		}
		
		$info=array(
			//'kdjabatan'=>$kdjbt,
			'kdsubdept'=>strtoupper($sub),
			'kdlvl'=>strtoupper($kdlvl),
			'kddept'=>strtoupper($kddept),
			'kdgrade'=>strtoupper($kdgrade),
			'nmjabatan'=>strtoupper($nmjbt),
			'costcenter'=>strtoupper($costcenter),
			'uraian'=>strtoupper($uraian),
			'shift'=>strtoupper($shift1),
			'lembur'=>strtoupper($lembur1),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//echo $kddept;
		//echo $kdsubdept;	
		$this->db->where('kdjabatan',$kdjbt);	
		$this->db->update("sc_mst.jabatan",$info);
		//echo "sukses";
		redirect('master/jabatan/index');
	}
	
	function edit_lvljabatan($kdlvl){
		$kdlvl=$this->input->post('kdlvl'); 
		$nmjbt=$this->input->post('nmjbt');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		$info=array(
			//'kodeopt'=>strtoupper($kodeopt),
			//'kddept'=>strtoupper($kddept),
			'nmlvljabatan'=>strtoupper($nmjbt),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
				
			);
		//echo $kddept;
		//echo $kdsubdept;	
		$this->db->where('kdlvl',$kdlvl);	
		$this->db->update("sc_mst.lvljabatan",$info);
		//echo "sukses";
		redirect('master/jabatan/lvljabatan');
	}
	
	
	function edit_jobgrade($kdgrade){
		$kdgrade=$this->input->post('kdgrade');
		//$kddept=$this->input->post('kddept');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$kdlvl=$this->input->post('kdlvl');
		$nmjg=$this->input->post('nmjg');
		$bobot1=str_replace("_","",$this->input->post('bobot1'));
		$bobot2=str_replace("_","",$this->input->post('bobot2'));
		if ($bobot1==NULL){
			$bobot1=0;
		}else {
			$bobot1=$bobot1;
		}
		if ($bobot2==NULL){
			$bobot2=0;
		}else {
			$bobot2=$bobot2;
		}
        $kdlvlgpmin=trim($this->input->post('kdlvlgpmin'));
        $kdlvlgpmax=trim($this->input->post('kdlvlgpmax'));
		$ket=$this->input->post('ket');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $kdjg;
		$info=array(
			//'kdgrade'=>strtoupper(str_replace(" ","",$kdjg)),
			'kdlvl'=>strtoupper($kdlvl),
			'nmgrade'=>strtoupper($nmjg),
			'bobot1'=>strtoupper($bobot1),
			'bobot2'=>strtoupper($bobot2),
			'kdlvlgpmin'=>strtoupper($kdlvlgpmin),
			'kdlvlgpmax'=>strtoupper($kdlvlgpmax),
			'keterangan'=>strtoupper($ket),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		$this->db->where('kdgrade',$kdgrade);	
		$this->db->update("sc_mst.jobgrade",$info);
		//echo "sukses";
		redirect('master/jabatan/jobgrade');
			
	}		
	function hps_jabatan($kdjabatan){
	
		$this->db->where('kdjabatan',$kdjabatan);
		$this->db->delete('sc_mst.jabatan');
		redirect('master/jabatan/index');
	}
	
	function hps_lvljabatan($kdlvl){
	
		$this->db->where('kdlvl',$kdlvl);
		$this->db->delete('sc_mst.lvljabatan');
		redirect('master/jabatan/lvljabatan');
	}
	function hps_jobgrade($kdjg){
	
		$this->db->where('kdgrade',$kdjg);
		$this->db->delete('sc_mst.jobgrade');
		redirect('master/jabatan/jobgrade');
	}

    /* INI LEVEL JABATAN */
    function req_lvljabatan($search=null){
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_')
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_grade->getLvljabatan($data);
    }

    function req_jobgrade($search=null){
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'lvl_jabatan' => $this->input->post('lvl_jabatan'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_grade->getJobgrade($data);
    }

    function req_kdlvlgp($search=null){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'grade_golongan' => $this->input->post('grade_golongan'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_grade->getKdlvlgp($data);

    }
	
	
}	
