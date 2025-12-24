<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Indoc extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_indoc'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index() {
		//$data['provinsi']=$this->m_wilayah->get_all_provinsi();							
		echo "REFLECT A";
		//$this->load->view('wilayah', $data);
	}
	
	function add_ajax_kdgroup($kdgroup){
		//$query = $this->db->get_where('sc_mst.kotakab',array('kodeprov'=>$id_prov));
		$query = $this->db->query("select * from sc_mst.mgroup order by nmgroup");
		$data = "<option value=''>-- Select Kode Group --</option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->kdgroup."'>".$value->nmgroup."</option>";
		}
		echo $data;
	}
	
	function add_ajax_kdsubgroup($kdgroup){
		//$query = $this->db->get_where('sc_mst.kec',array('kodekotakab'=>$id_kab));
		$query = $this->db->query(" select * from sc_mst.msubgroup where kdgroup='$kdgroup' order by nmsubgroup");
		$data = "<option value=''> - Pilih  Kode Sub Group - </option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->kdsubgroup."'>".$value->nmsubgroup."</option>";
		}
		echo $data;
	}
	
	function add_ajax_stockcode($kdsubgroup){
		//$query = $this->db->get_where('sc_mst.keldesa',array('kodekec'=>$id_kec));
		$query = $this->db->query("select * from sc_mst.mbarang where kdsubgroup='$kdsubgroup'");
		$data = "<option value=''> - Pilih Kode Nama Barang - </option>";
		foreach ($query->result() as $value) {
			$data .= "<option value='".$value->nodok."'>".$value->nmbarang."</option>";
		}
		echo $data;
	}
	
    function add_stock_ajax_kdgroup($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
		$param_c="";
        $count = $this->m_indoc->q_kdgroup_param($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramkdgroupmodul = $this->input->post('_paramkdgroupmodul_');
        $page = intval($page);
        $limit = $perpage * $page;
		/*echo $param=' 
            and ( lower(kdgroup) like \'%'.$search.'%\' 
            or lower(nmgroup) like \'%'.$search.'%\'
            )
            order by nmgroup
            limit '.$limit.'
            ';
		*/
		
		$param=" and (kdgroup like '%$search%' $paramkdgroupmodul ) or (nmgroup like '%$search%' $paramkdgroupmodul ) order by nmgroup asc";
        $result = $this->m_indoc->q_kdgroup_param($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
                'paramkdgroupmodul' => $paramkdgroupmodul
            ),
            JSON_PRETTY_PRINT
        );
    }
	
    function add_stock_ajax_kdsubgroup($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
		$param_c="";
        $count = $this->m_indoc->q_kdsubgroup_param($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $page = intval($page);
		$kdgroup = $this->input->post('_kdgroup_');
        $limit = $perpage * $page;
		/*echo $param=' 
            and ( lower(kdgroup) like \'%'.$search.'%\' 
            or lower(nmgroup) like \'%'.$search.'%\'
            )
            order by nmgroup
            limit '.$limit.'
            ';*/		
		$param=" and (kdgroup='$kdgroup' and kdsubgroup like '%$search%') or (kdgroup='$kdgroup' and nmsubgroup like '%$search%') order by nmsubgroup asc";
        $result = $this->m_indoc->q_kdsubgroup_param($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
                'kdgroup' => $kdgroup
            ),
            JSON_PRETTY_PRINT
        );
    }
	
	function add_archive_ajax($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
		$param_c="";
        $count = $this->m_indoc->q_archive_param($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $page = intval($page);
		$kdgroup = $this->input->post('_kdgroup_');
		$kdsubgroup = $this->input->post('_kdsubgroup_');
		$kdgudang = $this->input->post('_kdgudang_');
        $limit = $perpage * $page;
	
		$param=" and (kdgroup='$kdgroup' and loccode='$kdgudang' and docno like '%$search%') or (kdgroup='$kdgroup' and loccode='$kdgudang' and archives_id like '%$search%')  or (kdgroup='$kdgroup' and loccode='$kdgudang' and archives_name like '%$search%') order by archives_name asc";
        $result = $this->m_indoc->q_archive_param($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
                'kdgroup' => $kdgroup,
                //'kdsubgroup' => $kdsubgroup
            ),
            JSON_PRETTY_PRINT
        );
    }
	
	function add_karyawan($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
		$param_c="";
        $count = $this->m_indoc->q_karyawan($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $page = intval($page);
        $limit = $perpage * $page;
	
		$param=" order by nmlengkap asc";
        $result = $this->m_indoc->q_karyawan($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
            ),
            JSON_PRETTY_PRINT
        );
    }
	
	function add_archive_ajax_universal($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
		$param_c="";
        $count = $this->m_indoc->q_stockcode_param($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $page = intval($page);
		$kdgroup = $this->input->post('_kdgroup_');
		$kdgudang = $this->input->post('_kdgudang_');
        $limit = $perpage * $page;
	
		$param=" and (kdgroup='$kdgroup' and kdgudang='$kdgudang' and nodok like '%$search%') or (kdgroup='$kdgroup' and kdgudang='$kdgudang' and nmbarang like '%$search%')  or (kdgroup='$kdgroup' and kdgudang='$kdgudang' and nopol like '%$search%') order by nmbarang asc";
        $result = $this->m_indoc->q_stockcode_param($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
                'kdgroup' => $kdgroup,
                'kdgudang' => $kdgudang,
               // 'kdsubgroup' => $kdsubgroup
            ),
            JSON_PRETTY_PRINT
        );
    }
}