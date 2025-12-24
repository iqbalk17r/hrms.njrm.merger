<?php defined('BASEPATH') or exit('No direct script access allowed');

class TransactionType extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_TrxType'));
        $this->load->library(array());
        if (!$this->session->userdata('nik')) {
            redirect(base_url() . 'login');
        }
    }

    public function index() {
    }

    public function search() {
        header('Content-Type: application/json');
        $group = $this->input->get_post('group');
        $transtype = $this->input->get_post('transtype');
        $filter = '';
        if (!empty($transtype)){
            if ($transtype == 'TPB'){
                $filter = ' AND id IN(\'SM\',\'M\') ';
            }else{
                $filter = ' AND id NOT IN(\'SM\',\'M\') ';
            }
        }

        $count = $this->M_TrxType->q_master_search_where((isset($filter) ? $filter:'' ).'
			AND a.group IN (\''.$group.'\')
			')->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->M_TrxType->q_master_search_where((isset($filter) ? $filter:'' ).'
            AND a.group IN (\''.$group.'\')
            AND ( LOWER(id) LIKE \'%'.$search.'%\'
            OR LOWER(text) LIKE \'%'.$search.'%\'
            )
            ORDER BY text ASC
            LIMIT '.$perpage.' OFFSET '.$limit.'
            ')->result();
        echo json_encode(array(
            'totalcount' => $count,
            'search' => $search,
            'perpage' => $perpage,
            'page' => $page,
            'limit' => $limit,
            'location' => $result
        ), JSON_NUMERIC_CHECK);
    }
}
