<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/3/19 8:44 AM
 *  * Last Modified: 4/12/19 11:11 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */
class Wilayah extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geo','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Fiky_wilayah'));

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index() {
		$data['provinsi']=$this->m_wilayah->get_all_provinsi();							
		$this->load->view('wilayah', $data);
	}
	
	function add_ajax_kab($id_prov){
		//$query = $this->db->get_where('sc_mst.kotakab',array('kodeprov'=>$id_prov));
		$query = $this->db->query("select * from sc_mst.kotakab where kodeprov='$id_prov' order by namakotakab");
		$data = "<option value=''>- Select Kabupaten -</option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->kodekotakab."'>".$value->namakotakab."</option>";
		}
		echo $data;
	}
	
	function add_ajax_kec($id_kab){
		//$query = $this->db->get_where('sc_mst.kec',array('kodekotakab'=>$id_kab));
		$query = $this->db->query(" select * from sc_mst.kec where kodekotakab='$id_kab' order by namakec");
		$data = "<option value=''> - Pilih Kecamatan - </option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->kodekec."'>".$value->namakec."</option>";
		}
		echo $data;
	}
	
	function add_ajax_des($id_kec){
		//$query = $this->db->get_where('sc_mst.keldesa',array('kodekec'=>$id_kec));
		$query = $this->db->query("select * from sc_mst.keldesa where kodekec='$id_kec'");
		$data = "<option value=''> - Pilih Desa - </option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->kodekeldesa."'>".$value->namakeldesa."</option>";
		}
		echo $data;
	}

/* INI NEGARANYA */
    function add_negara($search=null){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'paramxnegara' => $this->input->post('_paramxnegara_'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_wilayah->getNegara($data);
    }

    function add_prov($search=null){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'kodenegara' => $this->input->post('_kodenegara_'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_wilayah->getProvince($data);
    }

    function add_kota($search=null){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'kodenegara' => $this->input->post('_kodenegara_'),
                'kodeprov' => $this->input->post('_kodeprov_'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_wilayah->getKota($data);

    }

    function add_kec($search=null){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'kodenegara' => $this->input->post('_kodenegara_'),
                'kodeprov' => $this->input->post('_kodeprov_'),
                'kodekotakab' => $this->input->post('_kodekotakab_'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_wilayah->getKecamatan($data);

    }

    function add_desa($search=null){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        $data = json_encode(
            array(
                'search' => $this->input->post('_search_'),
                'perpage' => $this->input->post('_perpage_'),
                'page' => $this->input->post('_page_'),
                'kodenegara' => $this->input->post('_kodenegara_'),
                'kodeprov' => $this->input->post('_kodeprov_'),
                'kodekotakab' => $this->input->post('_kodekotakab_'),
                'kodekec' => $this->input->post('_kodekec_'),
            ),JSON_PRETTY_PRINT
        );
        echo $this->fiky_wilayah->getDesa($data);

    }

    function test(){
       /* $name="FIKY '1";
        $age="28";
        $city="SURABAYA";
        echo $data = json_encode(
            array(
                'totalcount' => $name,
                'search' => $age,
                'perpage' => $city,
            ),
            JSON_PRETTY_PRINT
        );
        echo '<br>';
        $gmed=json_decode($data);
        echo $gmed->totalcount;*/
    }

}