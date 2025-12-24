<?php


class Room extends MX_Controller
{

    private $module;
    private $menuID;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('master/m_akses'));
        $this->load->library(array('template', 'flashmessage',));
        $this->module = 'ROOM';
        $this->menuID = 'I.Z.B.1';
        if (!$this->session->userdata('nik')) {
            redirect(base_url() . '/');
        }
    }


    private function userdata()
    {

//        return $this->session->all_userdata();
    }

    public function index()
    {

        $this->load->library(array('datatablessp'));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_Room'));
        if (!empty($status) && strtolower($status) != 'null') {
            if (!isset($filter)) $filter = '';
            $filter .= ' AND status = \'' . $status . '\' ';
        }
        $query = $this->M_Room->read_txt(' AND TRUE AND actived AND( properties = \'{}\' OR NOT (aa.properties->>\'core\')::boolean) ');
        $userhr = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'DIR' OR $this->m_akses->userhr();
        $superior = $this->m_akses->superiors_access();
        $this->datatablessp->datatable('table-room', 'table table-borderless datatable', true)
            ->columns('id, text, room_id, room_name, branch, capacity, category, actived')
            ->addcolumn('no', 'no')
            ->addcolumn('action', '<a href="javascript:void(0)" data-href=\'' . site_url('agenda/room/actionpopup/$1') . '\' data-action=\'read\' data-toggle=\'tooltip\' title=\'Aksi\' class=\'btn btn-sm btn-facebook popup float-end margin-right-20\' ><i class=\'glyphicon glyphicon-flash\'></i></a>', 'id, branch', true)
            ->addcolumn('update', '<a href="javascript:void(0)" data-href=\'' . site_url('agenda/room/update/$1') . '\' data-action=\'update\' data-toggle=\'tooltip\' title=\'Ubah\' class=\'btn btn-sm btn-warning update float-end margin-right-20\' ><i class=\'glyphicon glyphicon-pencil\'></i></a>', 'id, branch', true)
            ->addcolumn('delete', '<a href="javascript:void(0)" data-href=\'' . site_url('agenda/room/dodelete/$1') . '\' data-action=\'deactivate\' data-toggle=\'tooltip\' title=\'Hapus\' class=\'btn btn-sm btn-danger delete float-end margin-right-20\' ><i class=\'glyphicon glyphicon-trash\'></i></a>', 'id, branch', true)
            ->querystring($query)
            ->header('NO.', 'no', false, false, true)
            ->header('ID RUANGAN', 'room_id', true, true, true)
            ->header('NAMA RUANGAN', 'room_name', true, true, true)
            ->header('KAPASITAS ', 'capacity', true, true, true)
            ->header('AKSI', 'action', true, false, true, array('update','delete'));
        $this->datatablessp->generateajax();

        $data = array(
            'menuID' => $this->menuID,
            'title' => 'Master Ruangan',
            'content' => 'agenda/room/v_list',
            'inputUrl' => site_url('agenda/room/create'),
        );
        $this->template->display($data['content'], $data);
    }

    public function search()
    {
        $this->load->model(array('agenda/M_Room', 'agenda/M_Agenda'));
        header('Content-Type: application/json');
        $config = $this->input->get('config');
        $type = $this->input->get('type');
        $filter = '';
        if ($type == 'EVENT') {
            $beginDate = $this->input->get('begin');
            $endDate = $this->input->get('end');
            $agendaId = $this->input->get('agendaid');
            if ($config == 'CREATE'){
                $filter .= " AND room_id NOT IN (SELECT location FROM sc_trx.agenda WHERE status <> 'C' AND (begin_date BETWEEN '$beginDate' AND '$endDate' OR end_date BETWEEN '$beginDate' AND '$endDate')) ";
            }
            if ($config == 'UPDATE'){
                $filter .= " AND room_id NOT IN (SELECT location FROM sc_trx.agenda WHERE agenda_id <> '$agendaId' AND status <> 'C' AND (begin_date BETWEEN '$beginDate' AND '$endDate' OR end_date BETWEEN '$beginDate' AND '$endDate')) ";
            }
        }
        $count = $this->M_Room->read(' AND TRUE AND actived '. (isset($filter) ? $filter : ''))->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->M_Room->read((isset($filter) ? $filter : '').'
            AND actived
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

    public function create($param = '')
    {
        $json = json_decode(hex2bin($param));
        $data = array(
            'modalTitle' => 'Tambah Ruangan',
            'modalSize' => 'modal-md',
            'userhr' => $userhr,
            'title' => 'Rincian Agenda',
            'formAction' => site_url('agenda/room/docreate'),
            'content' => 'agenda/room/modals/v_create',
        );
        $this->load->view($data['content'], $data);
    }

    public function docreate($param = '')
    {
        $json = json_decode(hex2bin($param));
        $this->load->model('agenda/M_Room');
        header('Content-Type: application/json; charset=utf-8');
        try {
            $roomName = $this->input->post('room_name');
            $capacity = $this->input->post('capacity');
            $this->db->trans_start();
            $this->M_Room->create(array(
                'room_id' => trim($this->session->userdata('nik')),
                'room_name' => $roomName,
                'capacity' => $capacity,
                'input_by' => trim($this->session->userdata('nik')),
                'input_date' => date('Y-m-d H:i:s')
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data berhasil disimpan'
                ));
            } else {
                throw new Exception("Error DB", 1);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error = ['error_message' => $e->getMessage()];
            $error_db = $this->db->error();
            if ($error_db && !empty($error_db['message'])) $error['error_message'] = $error_db['message'];
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => $error_db['message']
            ));
        }
    }

    public function update($param = '')
    {
        $json = json_decode(hex2bin($param));
        $this->load->model('agenda/M_Room');
        $transaction = $this->M_Room->read(' AND id = \''.$json->id.'\' ')->row();
        $data = array(
            'modalTitle' => 'Ubah Ruangan ',
            'modalSize' => 'modal-md',
            'userhr' => $userhr,
            'title' => 'Ubah Ruangan',
            'transaction' => $transaction,
            'formAction' => site_url('agenda/room/doupdate/'.$param),
            'content' => 'agenda/room/modals/v_update',
        );
        $this->load->view($data['content'], $data);
    }

    public function doupdate($param = '')
    {
        $json = json_decode(hex2bin($param));
        $this->load->model('agenda/M_Room');
        header('Content-Type: application/json; charset=utf-8');
        try {
            $roomName = $this->input->post('room_name');
            $capacity = $this->input->post('capacity');
            $this->db->trans_start();
            $this->M_Room->update(array(
                'room_name' => $roomName,
                'capacity' => $capacity,
                'update_by' => trim($this->session->userdata('nik')),
                'update_date' => date('Y-m-d H:i:s')
            ),array(
                'room_id' => $json->id
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data berhasil disimpan'
                ));
            } else {
                throw new Exception("Error DB", 1);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error = ['error_message' => $e->getMessage()];
            $error_db = $this->db->error();
            if ($error_db && !empty($error_db['message'])) $error['error_message'] = $error_db['message'];
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => $error_db['message']
            ));
        }
    }

    public function delete($param = '')
    {
        $json = json_decode(hex2bin($param));
        $this->load->model('agenda/M_Room');
        $transaction = $this->M_Room->read(' AND id = \''.$json->id.'\' ')->row();
        $data = array(
            'modalTitle' => 'Ubah Ruangan ',
            'modalSize' => 'modal-md',
            'userhr' => $userhr,
            'title' => 'Ubah Ruangan',
            'transaction' => $transaction,
            'formAction' => site_url('agenda/room/doupdate/'.$param),
            'content' => 'agenda/room/modals/v_update',
        );
        $this->load->view($data['content'], $data);
    }

    public function dodelete($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model('agenda/M_Room');
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            if ($this->M_Room->exists(' TRUE AND room_id = \''.$json->id.'\' AND actived ')) {
                $this->M_Room->update(array(
                    'actived' => FALSE,
                    'deleted' => TRUE,
                    'delete_by' => trim($this->session->userdata('nik')),
                    'delete_date' => date('Y-m-d H:i:s')
                ),array(
                    'room_id' => $json->id
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Data berhasil dihapus'
                    ));
                } else {
                    throw new Exception("Error DB", 1);
                }
            }else{
                throw new Exception("Ruangan Tidak ditemukan", 1);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $error = ['error_message' => $e->getMessage()];
            $error_db = $this->db->error();
            if ($error_db && !empty($error_db['message'])) $error['error_message'] = $error_db['message'];
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => $error_db['message']
            ));
        }
    }
}
