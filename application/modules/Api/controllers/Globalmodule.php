<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/21/20, 9:27 AM
 *  * Last Modified: 10/21/20, 9:27 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

class Globalmodule extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_globalmodule'));
        $this->load->library(array('fiky_encryption'));
        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        echo json_encode(ARRAY('cok' => 'ASUW','cik'=>'Jembut')) ;
    }

    function option_trxtype(){

        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = $this->input->post('_paramglobal_');
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (uraian like '%$search%' $paramglobal ) or ( kdtrx like '%$search%' $paramglobal ) order by uraian asc";
        $result = $this->m_globalmodule->q_trxtype($param)->result();
        $count = $this->m_globalmodule->q_trxtype($paramglobal)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }

    function option_trxtype_by_id(){

        $id = trim($this->input->get('var'));
        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = " and kdtrx='$id' and jenistrx='I.D.A.1_TYPE'";
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (uraian like '%$search%' $paramglobal ) or ( kdtrx like '%$search%' $paramglobal ) order by kdtrx asc";
        $result = $this->m_globalmodule->q_trxtype($param)->result();
        $count = $this->m_globalmodule->q_trxtype($paramglobal)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }
    function option_trxtype_ktg_by_id(){

        $id = trim($this->input->get('var'));
        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = " and kdtrx='$id' and jenistrx='I.D.A.1_KTG'";
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (uraian like '%$search%' $paramglobal ) or ( kdtrx like '%$search%' $paramglobal ) order by kdtrx asc";
        $result = $this->m_globalmodule->q_trxtype($param)->result();
        $count = $this->m_globalmodule->q_trxtype($paramglobal)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }

    function option_mcustomer(){

        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = $this->input->post('_paramglobal_');
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (custcode like '%$search%' $paramglobal ) or ( custname like '%$search%' $paramglobal ) order by custname asc";
        $result = $this->m_globalmodule->q_customer($param)->result();
        $count = $this->m_globalmodule->q_customer($param)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                'param' => $param,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }

    function option_mcustomer_by_id(){
        $id = trim($this->input->get('var'));
        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = " and custcode='$id'";
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (custcode like '%$search%' $paramglobal ) or ( custname like '%$search%' $paramglobal ) order by custname asc";
        $result = $this->m_globalmodule->q_customer($param)->result();
        $count = $this->m_globalmodule->q_customer($param)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                'param' => $param,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }

    function option_idbu(){

        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = $this->input->post('_paramglobal_');
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (kdcabang like '%$search%' $paramglobal ) or ( desc_cabang like '%$search%' $paramglobal ) order by desc_cabang asc";
        $result = $this->m_globalmodule->q_kantorwilayah($param)->result();
        $count = $this->m_globalmodule->q_kantorwilayah($param)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                'param' => $param,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }

    function option_idbu_by_id(){

        $id = trim($this->input->get('var'));
        $nama = $this->session->userdata('nik');
        $param_c="";
        //$count = $this->m_instock->q_kdgroup_param($param_c)->num_rows();
        $search = strtoupper($this->input->post('_search_'));
        $perpage = $this->input->post('_perpage_');
        $perpage = intval($perpage);
        //$perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->post('_page_');
        $paramglobal = " and kdcabang='$id' ";
        $page = intval($page);
        $limit = $perpage * $page;

        $param=" and (kdcabang like '%$search%' $paramglobal ) or ( desc_cabang like '%$search%' $paramglobal ) order by desc_cabang asc";
        $result = $this->m_globalmodule->q_kantorwilayah($param)->result();
        $count = $this->m_globalmodule->q_kantorwilayah($param)->num_rows();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'total_count' => $count,
                'search' => $search,
                'param' => $param,
                //'perpage' => $perpage,
                'items' => $result,
                //'limit' => $limit,
                'incomplete_results' => false,
                //'group' => $result,
                'paramglobal' => $paramglobal,
            ),
            JSON_PRETTY_PRINT
        );
    }

}
