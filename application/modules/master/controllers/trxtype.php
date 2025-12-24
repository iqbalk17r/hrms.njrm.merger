<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trxtype extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_trxtype'));
		$this->load->library(array('form_validation','template','upload','pdf'));   
		
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	public function index()
	{
		$data['title']='KODE TRX TYPE';
		$data['message']='';
		$this->template->display('master/trxtype/v_trxtype',$data);
	}

	public function ajax_list()
	{
		$list = $this->m_trxtype->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->kdtrx;
			$row[] = $person->jenistrx;
			$row[] = $person->uraian;			

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".trim($person->kdtrx)."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->kdtrx)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_trxtype->count_all(),
						"recordsFiltered" => $this->m_trxtype->count_filtered(),
						"data" => $data,
				);
		//output to json format
        header('Content-Type: application/json; charset=utf-8');//view serializing json in browser
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->m_trxtype->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'kdtrx' => strtoupper($this->input->post('kdtrx')),
				'jenistrx' => strtoupper($this->input->post('jenistrx')),
				'uraian' => strtoupper($this->input->post('uraian')),
			);
		$insert = $this->m_trxtype->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'kdtrx' => $this->input->post('kdtrx'),
				'jenistrx' => $this->input->post('jenistrx'),
				'uraian' => $this->input->post('uraian'),
			);
		$this->m_trxtype->update(array('kdtrx' => $this->input->post('kdtrx')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_trxtype->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	    public function search()
    {
        $this->load->model(array('master/M_TrxType'));
        header('Content-Type: application/json');
        $param = (!is_null($this->input->get_post('type')) ? ' AND type = \''.$this->input->get_post('type').'\' ' : '' );
        $count = $this->M_TrxType->q_master_search_where(' AND TRUE '.$param)->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->M_TrxType->q_master_search_where($param.'
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
        ));
    }

}
