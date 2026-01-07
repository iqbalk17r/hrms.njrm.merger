<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Insupplier extends MX_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model(array('m_insupplier'));
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

    function add_ajax_kdgroup($kdjsupplier=null){
        $param = "";
        $query = $this->m_insupplier->q_jsupplier($param);
        $data = "<option value=''>-- Select Group Supplier --</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='".$value->kdjsupplier."'>".$value->nmjsupplier."</option>";
        }
        echo $data;
    }

    function add_ajax_kdsubgroup($kdsupplier=null){
        $param = "";
        $query = $this->m_insupplier->q_kdsupplier_param($param);
        $data = "<option value=''> - Pilih Sub Group Supplier - </option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='".$value->kdsupplier."'>".$value->nmsupplier."</option>";
        }
        echo $data;
    }

    function add_ajax_supplier($kdsubsupplier=null){
        $param = "";
        $query = $this->m_insupplier->q_kdsubsupplier_param($param);
        $data = "<option value=''> - Pilih Suppler - </option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='".$value->kdsubsupplier."'>".$value->nmsubsupplier."</option>";
        }
        echo $data;
    }

    function add_supplier_ajax_kdgroup($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
        $param_c="";
        $count = $this->m_insupplier->q_jsupplier($param_c)->num_rows();
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

        $param=" and ((kdjsupplier like '%$search%' $paramkdgroupmodul ) or (nmjsupplier like '%$search%' $paramkdgroupmodul ))";
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

    function add_supplier_ajax_kdgroup_default_value($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
        $param_c="";
        $count = $this->m_insupplier->q_jsupplier($param_c)->num_rows();
        //$search = $this->input->post('_search_');
        //$search = strtoupper(urldecode($search));
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

        $param=" and ((kdjsupplier like '%$search%' $paramkdgroupmodul ) or (nmjsupplier like '%$search%' $paramkdgroupmodul ))";
        $result = $this->m_insupplier->q_jsupplier($param)->result();
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

    function add_supplier_ajax_kdsupplier($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
        $param_c="";
        $count = $this->m_insupplier->q_kdsupplier_param($param_c)->num_rows();
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
        $param=" and (kdgroup='$kdgroup' and kdsupplier like '%$search%') or (kdgroup='$kdgroup' and nmsupplier like '%$search%') ";
        $result = $this->m_insupplier->q_kdsupplier_param($param)->result();
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

    function add_supplier_ajax_kdsubsupplier($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
        $param_c="";
        $count = $this->m_insupplier->q_kdsubsupplier_param($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $page = intval($page);
        $kdgroup = $this->input->post('_kdgroup_');
        $kdsubgroup = $this->input->post('_kdsubgroup_');
        $limit = $perpage * $page;

        $param=" and ( kdsupplier='$kdsubgroup' and kdsubsupplier like '%$search%') or (kdsupplier='$kdgroup' and nmsubsupplier like '%$search%') order by nmsubsupplier asc";
        $result = $this->m_insupplier->q_kdsubsupplier_param($param)->result();
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
                'kdsubgroup' => $kdsubgroup
            ),
            JSON_PRETTY_PRINT
        );
    }

    function add_karyawan($search=null){
        $branch = $this->session->userdata('branch');
        $idbu = $this->session->userdata('idbu');
        $param_c="";
        $count = $this->m_insupplier->q_karyawan($param_c)->num_rows();
        $search = $this->input->post('_search_');
        $search = strtoupper(urldecode($search));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" order by nmlengkap asc";
        $result = $this->m_insupplier->q_karyawan($param)->result();
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

}
