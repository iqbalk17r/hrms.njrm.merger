<?php


class Counseling extends MX_Controller
{

    private $module;
    private $menuID;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('master/m_akses'));
        $this->load->library(array('template', 'flashmessage',));
        $this->module = 'counseling';
        $this->menuID = 'I.Z.A.1';
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
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $year = $this->input->get_post('year');
        $month = $this->input->get_post('month');
        if (!empty($year) && strtolower($year) != 'null') {
            $filter = ' AND to_char(input_date,\'mmYYYY\') = \'' . $month . $year . '\' ';
        } else {
            $filter = ' AND to_char(input_date,\'mmYYYY\') = \'' . date('m') . date('Y') . '\' ';
        }
        $status = $this->input->get_post('status');
        if (!empty($status) && strtolower($status) != 'null') {
            if (!isset($filter)) $filter = '';
            $filter .= ' AND status = \'' . $status . '\' ';
        }
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $superior = $this->m_akses->superiors_access();
        if ($userhr) {
            $query = $this->M_CounselingSession->read_txt(' AND TRUE ' . (isset($filter) ? $filter : ''));
        } else if ($superior) {
            $query = $this->M_CounselingSession->read_txt(' AND counselee = \'' . $this->session->userdata('nik') . '\' OR superiors ilike \'%' . $this->session->userdata('nik') . '%\' ' . (isset($filter) ? $filter : ''));
        } else {
            $query = $this->M_CounselingSession->read_txt(' AND counselee = \'' . $this->session->userdata('nik') . '\' ' . (isset($filter) ? $filter : ''));
        }
        $this->datatablessp->datatable('table-counseling', 'table table-borderless datatable', true)
            ->columns('session_id, branch_id, counselee, counselee_name, counselor, counselor_name, session_date, begin_time, end_time, location, description, status, score, schedule_button, session_date_format, begin_time_format, end_time_format, location_format, merge_time_format')
            ->addcolumn('no', 'no')
            ->addcolumn('schedule_date', '<span>$2</span><br><span>$1</span>', 'merge_time_format, session_date_format')
            ->addcolumn('detail', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('agenda/counseling/read/$1') . '\' data-action=\'detail\' data-toggle=\'tooltip\' title=\'Rincian\' class=\'btn btn-sm btn-default detail margin-right-20\' ><i class=\'fa fa-bars\'></i></a>', 'session_id, counselee', true)
            ->addcolumn('schedule', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('agenda/counseling/schedule/$1') . '\' data-action=\'schedule\' class=\'btn btn-sm btn-twitter schedule margin-right-20\' >Jadwal</a>', 'session_id, counselee', true)
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('agenda/counseling/actionpopup/$1') . '\' data-action=\'read\' data-toggle=\'tooltip\' title=\'Aksi\' class=\'btn btn-sm btn-facebook popup float-end margin-right-20\' ><i class=\'glyphicon glyphicon-flash\'></i></a>', 'session_id, counselee', true)
            ->addcolumn('cancelhr', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('agenda/counseling/docancel/$1') . '\' data-action=\'cancelhr\' class=\'btn btn-sm btn-danger cancel float-end margin-right-20\' >Batal</a>', 'session_id, counselee', true)
            ->querystring($query)
            ->header('NO.', 'no', false, false, true)
            ->header('ID SESI', 'session_id', true, true, true)
            ->header('KONSELI', 'counselee_name', true, true, true)
            ->header('KONSELOR', 'counselor_name', true, true, true)
            ->header('JADWAL', 'session_date_format', true, true, true, array((( $userhr) ? 'schedule' : 'schedule_date')))
            ->header('STATUS', 'status_text', true, true, true)
            ->header('AKSI', 'action', true, false, true, array('action',));
        $this->datatablessp->generateajax();

        $data = array(
            'menuID' => $this->menuID,
            'title' => 'Konseling Karyawan',
            'content' => 'agenda/counseling/v_list',
            'inputUrl' => site_url('agenda/counseling/employee'),
        );
        $this->template->display($data['content'], $data);
    }

    public function employee()
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $superior = $this->m_akses->superiors_access();
        if ($userhr) {
            $query = $this->M_Employee->read_txt(' AND statuskepegawaian <> \'KO\' ');
        } else if ($superior) {
            $query = $this->M_Employee->read_txt(' AND statuskepegawaian <> \'KO\' AND nik = \'' . $this->session->userdata('nik') . '\' OR superiors ilike \'%' . $this->session->userdata('nik') . '%\' ');
        } else {
            $query = $this->M_Employee->read_txt(' AND statuskepegawaian <> \'KO\' AND nik = \'' . trim($this->session->userdata('nik')) . '\' ');
        }
        $this->M_CounselingSession->tmp_delete(array(
            'session_id' => $this->session->userdata('nik'),
            'input_by' => $this->session->userdata('nik'),
        ));
        $this->datatablessp->datatable('table-employee', 'table table-borderless ', true)
            ->columns('nik, nmlengkap, nmdept, nmlvljabatan')
            ->addcolumn('no', 'no')
            ->addcolumn('action', '<a href=\'' . site_url('agenda/counseling/create/$1') . '\' data-action=\'read\' class=\'btn btn-sm btn-info popup \' data-toggle=\'tooltip\' title=\'Rincian\'>Input Konseling</a>', 'nik', true)
            ->querystring($query)
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Jabatan', 'nmlvljabatan', true, true, true)
            ->header('Aksi', 'action', true, false, true, array('action'));
        $this->datatablessp->generateajax();
        $data = array(
            'content' => 'agenda/counseling/v_employee',
            'backUrl' => site_url('agenda/counseling'),
        );
        $this->template->display($data['content'], $data);
    }

    public function actionpopup($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();

        header('Content-Type: application/json; charset=utf-8');
        if (!is_null($transaction->session_id) && !is_null($transaction->session_id) && !empty($transaction->session_id)) {
            if ($transaction->status == 'C') {
                echo json_encode(array(
                    'statusText' => 'Konfirmasi',
                    'message' => 'Lihat rincian dokumen <b>' . $transaction->session_id . '</b> ?',
                    'data' => $transaction,
                    'canread' => true,
                    'next' => array(
                        'read' => site_url('agenda/counseling/read/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id,)))),
                    )
                ));
            } else {
                if (!is_null($transaction->approve_by) && !empty($transaction->approve_by) && !is_null($transaction->approve_date)) {
                    if ($userhr or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_CounselingSession->read(' AND session_id = \'' . $transaction->session_id . '\' AND counselor = \'' . $this->session->userdata('nik') . '\' ')->num_rows() > 0) {
                        echo json_encode(array(
                            'statusText' => 'Konfirmasi',
                            'message' => 'Lihat data',
                            'data' => $transaction,
                            'cancreate' => true,
                            'next' => array(
                                'read' => site_url('agenda/counseling/read/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id,)))),
                            )
                        ));
                    } else {
                        echo json_encode(array(
                            'statusText' => 'Konfirmasi',
                            'message' => 'Lihat data',
                            'data' => $transaction,
                            'canread' => true,
                            'next' => array(
                                'read' => site_url('agenda/counseling/read/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id,)))),
                            )
                        ));
                    }
                } else if (!is_null($transaction->session_id) && !is_null($transaction->session_id) && !empty($transaction->session_id)) {
//                    if ($userhr or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_CounselingSession->read(' AND session_id = \'' . $transaction->session_id . '\' AND superiors ILIKE \'%' . $this->session->userdata('nik') . '%\' ')->num_rows() > 0) {
                    if ($this->M_CounselingSession->read(' AND session_id = \'' . $transaction->session_id . '\' AND superiors ILIKE \'%' . trim($this->session->userdata('nik')) . '%\' ')->num_rows() > 0) {
                        echo json_encode(array(
                            'statusText' => 'Konfirmasi persetujuan',
                            'message' => 'Apakah anda ingin menyetujui dokumen <b>' . $transaction->session_id . '</b> ?',
                            'data' => $transaction,
                            'canapprove' => true,
                            'next' => array(
                                'update' => site_url('agenda/counseling/update/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id,)))),
                                'approve' => site_url('agenda/counseling/approve/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id,)))),
                            ),
                        ));
                    } else {
                        echo json_encode(array(
                            'statusText' => 'Konfirmasi ubah',
                            'message' => 'Apakah anda ingin mengubah dokumen <b>' . $transaction->session_id . '</b> ?',
                            'data' => $transaction,
                            'canupdate' => true,
                            'next' => array(
                                'update' => site_url('agenda/counseling/update/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id,)))),
                            ),
                        ));
                    }
                }
            }
        }
    }

    public function read($param)
    {

        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        $this->datatablessp->datatable('table-counseling-detail', 'table table-borderless datatable', true)
            ->columns('detail_id, session_id, sort, problem, solution, score, input_by, input_date, update_by, update_date')
            ->addcolumn('no', 'no')
            ->addcolumn('edit', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('agenda/counseling/updatedetail/$1') . '\' data-action=\'edit\' data-toggle=\'tooltip\' title=\'Edit\' class=\'btn btn-sm btn-instagram edit\' ><i class=\'fa fa-edit\'></i></a>', 'session_id, detail_id', true)
            ->addcolumn('delete', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('agenda/counseling/dodeletedetail/$1') . '\' data-action=\'delete\' data-toggle=\'tooltip\' title=\'Hapus\' class=\'btn btn-sm btn-danger delete\' ><i class=\'fa fa-trash-o\'></i></a>', 'session_id, detail_id', true)
            ->querystring($this->M_CounselingSession->detail_read_txt(' AND session_id = \'' . $transaction->session_id . '\' '))
            ->header('NO.', 'no', false, false, true)
            ->header('Masalah', 'problem', true, true, true)
            ->header('Solusi', 'solution', true, true, true);
        if ($userhr) {
            $this->datatablessp->header('Aksi', 'edit', true, true, true, array('edit', 'delete'));
        }
        $this->datatablessp->generateajax();
        $data = array(
            'title' => 'RINCIAN KONSELING KARYAWAN ' . $employee->nmlengkap . ' TANGGAL : ' . ((!is_null($transaction->session_date) or !empty($transaction->session_date)) ? $transaction->session_date . ' JAM : ' . $transaction->merge_time : $transaction->session_date_format),
            'counselor' => $this->M_Employee->read(' AND TRUE ')->result(),
            'transaction' => $transaction,
            'backUrl' => site_url('agenda/counseling'),
            'inputDetailUrl' => site_url('agenda/counseling/createdetail/' . bin2hex(json_encode(array('session_id' => $transaction->session_id, 'counselee' => $transaction->counselee)))),
            'userhr' => $userhr,
            'iscounselor' => (trim($this->session->userdata('nik') == $transaction->counselor) ? TRUE : FALSE),
            'formAction' => site_url('agenda/counseling/doapprove/' . bin2hex(json_encode(array('session_id' => $transaction->session_id)))),
            'employee' => $employee,
            'content' => 'agenda/counseling/v_read'
        );
        $this->template->display($data['content'], $data);
    }

    public function schedule($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        header('Content-Type: application/json');
        if ($userhr) {
            if (!is_null($transaction->session_id) && !is_null($transaction->session_id) && !empty($transaction->session_id)) {
                if ($transaction->status <> 'C') {
                    if (is_null($transaction->approve_by) && empty($transaction->approve_by) && is_null($transaction->approve_date)) {
                        $edited = $this->M_CounselingSession->tmp_read(' AND session_id = \'' . $transaction->session_id . '\' AND trim(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' ORDER BY update_date DESC')->row();
                        if (!empty($edited)) {
                            http_response_code(403);
                            echo json_encode(array(
                                'data' => array(),
                                'message' => 'Data konseling  karyawan nomer <b>' . $edited->session_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>',
                            ));
                            $this->flashmessage
                                ->set(array('Data konseling  karyawan nomer <b>' . $edited->session_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>','warning'))
                                ->redirect('agenda/counseling/');
                        }
                        $this->M_CounselingSession->update(array(
                            'status' => 'U',
                            'update_by' => trim($this->session->userdata('nik')),
                            'update_date' => date('Y-m-d H:i:s'),
                        ), array(
                            'session_id' => $json->session_id
                        ));
                        if (is_null($transaction->session_date) && empty($transaction->begin_time) && is_null($transaction->end_time)) {
                            echo json_encode(array(
                                'statusText' => 'Konfirmasi Buat Jadwal',
                                'message' => 'Apakah anda ingin membuat jadwal untuk dokumen <b>' . $transaction->session_id . '</b> ?',
                                'cancreate' => true,
                                'next' => array(
                                    'create' => site_url('agenda/counseling/schedulemodify/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id, 'action' => 'create')))),
                                ),
                            ));
                        } else {
                            echo json_encode(array(
                                'statusText' => 'Konfirmasi Ubah Jadwal',
                                'message' => 'Apakah anda ingin membuat ulang jadwal untuk dokumen <b>' . $transaction->session_id . '</b> ?',
                                'canupdate' => true,
                                'next' => array(
                                    'update' => site_url('agenda/counseling/schedulemodify/' . bin2hex(json_encode(array('branch' => empty($transaction->branch_id) ? $this->session->userdata('branch') : $transaction->branch_id, 'session_id' => $transaction->session_id, 'action' => 'update')))),
                                ),
                            ));
                        }
                    } else {
                        http_response_code(403);
                        echo json_encode(array(
                            'data' => array(),
                            'message' => 'Dokumen yang sudah disetujui tidak dapat diubah'
                        ));
                    }
                } else {
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Dokumen sudah dibatalkan'
                    ));
                }
            } else {
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Dokumen tidak ditemukan'
                ));
            }
        } else {
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Anda tidak memiliki akses'
            ));
        }

    }

    public function update($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        $edited = $this->M_CounselingSession->tmp_read(' AND session_id = \'' . $transaction->session_id . '\' AND trim(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' ORDER BY update_date DESC')->row();
        if (!empty($edited)) {
            $this->flashmessage
                ->set(array( 'Data konseling  karyawan nomer <b>' . $edited->session_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>','warning'))
                ->redirect('agenda/counseling/');
        }
        $this->M_CounselingSession->update(array(
            'status' => 'U',
            'update_by' => trim($this->session->userdata('nik')),
            'update_date' => date('Y-m-d H:i:s'),
        ), array(
            'session_id' => $json->session_id
        ));
        $data = array(
            'title' => 'UPDATE DATA KONSELING',
            'counselor' => $this->M_Employee->read(' AND TRUE ')->result(),
            'transaction' => $transaction,
            'canmodify' => (trim($this->session->userdata('nik') == $transaction->counselee) ? TRUE : FALSE),
            'formAction' => site_url('agenda/counseling/doupdate/' . bin2hex(json_encode(array('session_id' => $transaction->session_id)))),
            'cancelAction' => site_url('agenda/counseling/docancel/' . bin2hex(json_encode(array('session_id' => $transaction->session_id)))),
            'employee' => $employee,
            'content' => 'agenda/counseling/v_update'
        );
        $this->template->display($data['content'], $data);
    }

    public function schedulemodify($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        switch ($json->action) {
            case "create":
                $data = array(
                    'formAction' => site_url('agenda/counseling/doschedulemodify/' . bin2hex(json_encode(array('session_id' => $transaction->session_id, 'counselee' => $transaction->counselee, 'action' => 'create')))),
                    'timeCheckUrl' => site_url('agenda/counseling/timecheck'),
                    'modalTitle' => 'Buat Jadwal Dokumen <b>' . $transaction->session_id . '</b>',
                    'modalSize' => 'modal-md',
                    'content' => 'agenda/counseling/modals/v_create_schedule'
                );
                $this->load->view($data['content'], $data);
                break;
            case "update":
                $this->datatablessp->datatable('table-schedule-history', 'table table-borderless datatable', true)
                    ->columns('session_id, session_date, begin_time, end_time, location, reason, input_by, input_date')
                    ->addcolumn('no', 'no')
                    ->addcolumn('time', '<span> $1 - $2 </span>', 'begin_time,end_time')
                    ->querystring($this->M_CounselingSession->history_read_txt(' AND session_id = \'' . $transaction->session_id . '\' '))
                    ->header('NO.', 'no', false, false, true)
                    ->header('Tanggal', 'session_date', true, true, true)
                    ->header('Waktu', 'begin_time', true, true, true, array('time'))
                    ->header('Lokasi', 'location', true, true, true)
                    ->header('Alasan', 'reason', true, true, true);
                $this->datatablessp->generateajax();
                $data = array(
                    'transaction' => $transaction,
                    'formAction' => site_url('agenda/counseling/doschedulemodify/' . bin2hex(json_encode(array('session_id' => $transaction->session_id, 'counselee' => $transaction->counselee, 'action' => 'update')))),
                    'timeCheckUrl' => site_url('agenda/counseling/timecheck'),
                    'modalTitle' => 'Ubah Jadwal Dokumen <b>' . $transaction->session_id . '</b>',
                    'modalSize' => 'modal-md',
                    'content' => 'agenda/counseling/modals/v_update_schedule'
                );
                $this->load->view($data['content'], $data);
                break;
        }

    }

    public function doschedulemodify($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        header('Content-Type: application/json');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->tmp_update(array(
                'session_date' => $this->input->get_post('session_date'),
                'begin_time' => $this->input->get_post('begin_time'),
                'end_time' => $this->input->get_post('end_time'),
                'location' => strtoupper(strtolower($this->input->get_post('location'))),
                'status' => 'U',
            ), array(
                'session_id' => $transaction->session_id,
            ));
            $this->M_CounselingSession->update(array(
                'status' => ($json->action == 'create' ? 'A' : 'R'),
            ), array(
                'session_id' => $transaction->session_id,
            ));
            $this->M_CounselingSession->history_create(array(
                'session_id' => $transaction->session_id,
                'session_date' => $this->input->get_post('session_date'),
                'begin_time' => $this->input->get_post('begin_time'),
                'end_time' => $this->input->get_post('end_time'),
                'location' => strtoupper(strtolower($this->input->get_post('location'))),
                'reason' => strtoupper(strtolower($this->input->get_post('reason'))),
                'input_by' => trim($this->session->userdata('nik')),
                'input_date' => date('Y-m-d H:i:s'),
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                $this->collectstatus();
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

    public function collectstatus()
    {
        $this->load->model(array('agenda/M_NotificationRule', 'agenda/M_CounselingSession', 'master/M_Employee', 'agenda/M_Notifications','master/M_Branch'));
        $module = strtoupper(strtolower(strtok(basename(__FILE__), '.')));
        $branch = $this->M_Branch->read(' AND TRIM(cdefault) = \'YES\' LIMIT 1 ')->row();
//        foreach ($this->M_CounselingSession->read(' AND session_id NOT IN (SELECT reference_id FROM sc_trx.notifications) ')->result() as $index => $session) {
        foreach ($this->M_CounselingSession->read(' AND TRUE AND session_id NOT IN (SELECT reference_id FROM sc_trx.notifications) ')->result() as $index => $session) {
            switch ($session->status) {
                case "I":
                    $notifications = array();
                    foreach ($this->M_NotificationRule->read(' AND active = TRUE AND status = \''.$session->status.'\' AND module = \'' . strtolower($module) . '\' AND input_by = \''.$session->input_by_type.'\' ')->result() as $index => $rule) {
                        $notif = array(
                            'reference_id' => $session->session_id,
                            'type' => $rule->type,
                            'module' => $module,
                            'subject' => 'INPUT ' . $module,
                            'action' => null,
                            'status' => null,
                        );
                        switch ($rule->notified_to) {
                            case "HRD":
                                foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND jabatan IN (\'STDKL\',\'SPVPLT\',\'ADMTRA\',\'STPLT\',\'KBGDPK\',\'SCCHR\',\'SAKHR\')  AND statuskepegawaian <> \'KO\'  ')->result() as $index => $hrd) {
                                    $notif['send_to'] = $hrd->nik;
                                    $notif['properties'] = json_encode(array('send_to' => $hrd->nik, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'I',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }

                                break;
                            case "SUPERIOR":
                                foreach (explode('.', $session->superiors) as $superior) {
                                    $notif['send_to'] = $superior;
                                    $notif['properties'] = json_encode(array('send_to' => $superior, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'I',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }
                                break;
                            case "EMPLOYEE":
                                $notif['send_to'] = $session->counselee;
                                $notif['properties'] = json_encode(array('send_to' => $session->counselee, 'reference_id' => $session->session_id));
                                $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                $data = array(
                                    'send_to' => $person->nmlengkap,
                                    'position' => $person->nmjabatan,
                                    'branchname' => $branch->branchname,
                                    'type' => 'Pemberitahuan',
                                    'status' => 'I',
                                    'transaction' => array(
                                        'Kode_Agenda' => $session->session_id,
                                        'Tipe_Agenda' => 'KONSELING',
                                        'Aplikasi' => 'HRMS',
                                        'Nama_Konseli' => $session->counselee_name,
                                        'Nama_Konselor' => $session->counselor_name,
                                    )
                                );
                                if ($rule->type == 'wa') {
                                    $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                } else {
                                    $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                }
                                array_push($notifications, $notif);
                                break;
                        }
                    }
                    $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                    break;
                case "S":
                    $notifications = array();
                    foreach ($this->M_NotificationRule->read(' AND active = TRUE AND status = \''.$session->status.'\' AND module = \'' . strtolower($module) . '\' ')->result() as $index => $rule) {
                        $notif = array(
                            'reference_id' => $session->session_id,
                            'type' => $rule->type,
                            'module' => $module,
                            'subject' => 'SCHEDULE ' . $module,
                            'action' => null,
                            'status' => null,
                        );
                        switch ($rule->notified_to) {
                            case "HRD":
                                foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND jabatan IN (\'STDKL\',\'SPVPLT\',\'ADMTRA\',\'STPLT\',\'KBGDPK\',\'SCCHR\',\'SAKHR\')  AND statuskepegawaian <> \'KO\'  ')->result() as $index => $hrd) {
                                    $notif['send_to'] = $hrd->nik;
                                    $notif['properties'] = json_encode(array('send_to' => $hrd->nik, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'S',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }

                                break;
                            case "SUPERIOR":
                                foreach (explode('.', $session->superiors) as $superior) {
                                    $notif['send_to'] = $superior;
                                    $notif['properties'] = json_encode(array('send_to' => $superior, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'S',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }
                                break;
                            case "EMPLOYEE":
                                $notif['send_to'] = $session->counselee;
                                $notif['properties'] = json_encode(array('send_to' => $session->counselee, 'reference_id' => $session->session_id));
                                $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                $data = array(
                                    'send_to' => $person->nmlengkap,
                                    'position' => $person->nmjabatan,
                                    'branchname' => $branch->branchname,
                                    'type' => 'Pemberitahuan',
                                    'status' => 'S',
                                    'transaction' => array(
                                        'Kode_Agenda' => $session->session_id,
                                        'Tipe_Agenda' => 'KONSELING',
                                        'Aplikasi' => 'HRMS',
                                        'Nama_Konseli' => $session->counselee_name,
                                        'Nama_Konselor' => $session->counselor_name,
                                        'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                        'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                        'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                        'Keterangan' => $session->description,
                                    )
                                );
                                if ($rule->type == 'wa') {
                                    $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                } else {
                                    $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                }
                                array_push($notifications, $notif);
                                break;
                        }

                    }
                    $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                    break;
                case "R":
                    $notifications = array();
                    foreach ($this->M_NotificationRule->read(' AND active = TRUE AND status = \''.$session->status.'\' AND module = \'' . strtolower($module) . '\' ')->result() as $index => $rule) {
                        $notif = array(
                            'reference_id' => $session->session_id,
                            'type' => $rule->type,
                            'module' => $module,
                            'subject' => 'RESCHEDULE ' . $module,
                            'action' => null,
                            'status' => null,
                        );

                        switch ($rule->notified_to) {
                            case "HRD":
                                foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND jabatan IN (\'STDKL\',\'SPVPLT\',\'ADMTRA\',\'STPLT\',\'KBGDPK\',\'SCCHR\',\'SAKHR\')  AND statuskepegawaian <> \'KO\'  ')->result() as $index => $hrd) {
                                    $notif['send_to'] = $hrd->nik;
                                    $notif['properties'] = json_encode(array('send_to' => $hrd->nik, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'R',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }

                                break;
                            case "SUPERIOR":
                                foreach (explode('.', $session->superiors) as $superior) {
                                    $notif['send_to'] = $superior;
                                    $notif['properties'] = json_encode(array('send_to' => $superior, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'R',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => $session->session_date_reformat,
                                            'Waktu_Acara' => $session->merge_time_format,
                                            'Lokasi' => $session->location,
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }
                                break;
                            case "EMPLOYEE":
                                $notif['send_to'] = $session->counselee;
                                $notif['properties'] = json_encode(array('send_to' => $session->counselee, 'reference_id' => $session->session_id));
                                $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                $data = array(
                                    'send_to' => $person->nmlengkap,
                                    'position' => $person->nmjabatan,
                                    'branchname' => $branch->branchname,
                                    'type' => 'Pemberitahuan',
                                    'status' => 'R',
                                    'transaction' => array(
                                        'Kode_Agenda' => $session->session_id,
                                        'Tipe_Agenda' => 'KONSELING',
                                        'Aplikasi' => 'HRMS',
                                        'Nama_Konseli' => $session->counselee_name,
                                        'Nama_Konselor' => $session->counselor_name,
                                        'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                        'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                        'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                        'Keterangan' => $session->description,
                                    )
                                );
                                if ($rule->type == 'wa') {
                                    $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                } else {
                                    $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                }
                                array_push($notifications, $notif);
                                break;
                        }
                    }
                    $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                    break;
                case "P":
                    $notifications = array();
                    foreach ($this->M_NotificationRule->read(' AND active = TRUE AND status = \''.$session->status.'\' AND module = \'' . strtolower($module) . '\' ')->result() as $index => $rule) {
                        $notif = array(
                            'reference_id' => $session->session_id,
                            'type' => $rule->type,
                            'module' => $module,
                            'subject' => 'APPROVE ' . $module,
                            'action' => null,
                            'status' => null,
                            'content' => '-',
                        );
                        switch ($rule->notified_to) {
                            case "HRD":
                                foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND jabatan IN (\'STDKL\',\'SPVPLT\',\'ADMTRA\',\'STPLT\',\'KBGDPK\',\'SCCHR\',\'SAKHR\')  AND statuskepegawaian <> \'KO\'  ')->result() as $index => $hrd) {
                                    $notif['send_to'] = $hrd->nik;
                                    $notif['properties'] = json_encode(array('send_to' => $hrd->nik, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'P',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }

                                break;
                            case "SUPERIOR":
                                foreach (explode('.', $session->superiors) as $superior) {
                                    $notif['send_to'] = $superior;
                                    $notif['properties'] = json_encode(array('send_to' => $superior, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'P',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }
                                break;
                            case "EMPLOYEE":
                                $notif['send_to'] = $session->counselee;
                                $notif['properties'] = json_encode(array('send_to' => $session->counselee, 'reference_id' => $session->session_id));
                                $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                $data = array(
                                    'send_to' => $person->nmlengkap,
                                    'position' => $person->nmjabatan,
                                    'branchname' => $branch->branchname,
                                    'type' => 'Pemberitahuan',
                                    'status' => 'P',
                                    'transaction' => array(
                                        'Kode_Agenda' => $session->session_id,
                                        'Tipe_Agenda' => 'KONSELING',
                                        'Aplikasi' => 'HRMS',
                                        'Nama_Konseli' => $session->counselee_name,
                                        'Nama_Konselor' => $session->counselor_name,
                                        'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                        'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                        'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                        'Keterangan' => $session->description,
                                    )
                                );
                                if ($rule->type == 'wa') {
                                    $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                } else {
                                    $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                }
                                array_push($notifications, $notif);
                                break;
                        }
                    }
                    $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                    break;
                case "C":
                    $notifications = array();
                    foreach ($this->M_NotificationRule->read(' AND active = TRUE AND status = \''.$session->status.'\' AND module = \'' . strtolower($module) . '\' ')->result() as $index => $rule) {
                        $notif = array(
                            'reference_id' => $session->session_id,
                            'type' => $rule->type,
                            'module' => $module,
                            'subject' => 'CANCEL ' . $module,
                            'action' => null,
                            'status' => null,
                        );
                        switch ($rule->notified_to) {
                            case "HRD":
                                foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND jabatan IN (\'STDKL\',\'SPVPLT\',\'ADMTRA\',\'STPLT\',\'KBGDPK\',\'SCCHR\',\'SAKHR\')  AND statuskepegawaian <> \'KO\'  ')->result() as $index => $hrd) {
                                    $notif['send_to'] = $hrd->nik;
                                    $notif['properties'] = json_encode(array('send_to' => $hrd->nik, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'C',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }

                                break;
                            case "SUPERIOR":
                                foreach (explode('.', $session->superiors) as $superior) {
                                    $notif['send_to'] = $superior;
                                    $notif['properties'] = json_encode(array('send_to' => $superior, 'reference_id' => $session->session_id));
                                    $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                    $data = array(
                                        'send_to' => $person->nmlengkap,
                                        'position' => $person->nmjabatan,
                                        'branchname' => $branch->branchname,
                                        'type' => 'Pemberitahuan',
                                        'status' => 'C',
                                        'transaction' => array(
                                            'Kode_Agenda' => $session->session_id,
                                            'Tipe_Agenda' => 'KONSELING',
                                            'Aplikasi' => 'HRMS',
                                            'Nama_Konseli' => $session->counselee_name,
                                            'Nama_Konselor' => $session->counselor_name,
                                            'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                            'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                            'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                            'Keterangan' => $session->description,
                                        )
                                    );
                                    if ($rule->type == 'wa') {
                                        $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                    } else {
                                        $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                    }
                                    array_push($notifications, $notif);
                                }
                                break;
                            case "EMPLOYEE":
                                $notif['send_to'] = $session->counselee;
                                $notif['properties'] = json_encode(array('send_to' => $session->counselee, 'reference_id' => $session->session_id));
                                $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                $data = array(
                                    'send_to' => $person->nmlengkap,
                                    'position' => $person->nmjabatan,
                                    'branchname' => $branch->branchname,
                                    'type' => 'Pemberitahuan',
                                    'status' => 'C',
                                    'transaction' => array(
                                        'Kode_Agenda' => $session->session_id,
                                        'Tipe_Agenda' => 'KONSELING',
                                        'Aplikasi' => 'HRMS',
                                        'Nama_Konseli' => $session->counselee_name,
                                        'Nama_Konselor' => $session->counselor_name,
                                        'Tanggal_Acara' => (!empty($session->session_date_reformat) ? $session->session_date_reformat : '-'),
                                        'Waktu_Acara' => (!empty($session->merge_time_format) ? $session->merge_time_format : '-'),
                                        'Lokasi' => (!empty($session->location) ? $session->location : '-'),
                                        'Keterangan' => $session->description,
                                    )
                                );
                                if ($rule->type == 'wa') {
                                    $notif['content'] = $this->load->view('notification_template/counseling/whatsapp', $data, true);
                                } else {
                                    $notif['content'] = $this->load->view('notification_template/counseling/email', $data, true);
                                }
                                array_push($notifications, $notif);
                                break;
                        }
                    }
                    $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                    break;
                default:
                    break;

            }
        }

    }

    public function create($param)
    {

        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $this->M_CounselingSession->tmp_delete(array(
            'session_id' => $this->session->userdata('nik'),
            'status' => 'I',
            'input_by' => $this->session->userdata('nik'),
        ));
        $this->M_CounselingSession->tmp_create(array(
            'session_id' => $this->session->userdata('nik'),
            'counselee' => $json->nik,
            'status' => 'I',
            'input_by' => $this->session->userdata('nik'),
            'input_date' => date('Y-m-d H:i:s'),
        ));
        $employee = $this->M_Employee->read(' AND nik = \'' . $json->nik . '\' AND statuskepegawaian <> \'KO\' ')->row();
        $data = array(
            'title' => 'INPUT DATA KONSELING',
            'formAction' => site_url('agenda/counseling/docreate/' . bin2hex(json_encode(array('nik' => $json->nik)))),
            'employee' => $employee,
            'superior' => $employee->atasan,
            'content' => 'agenda/counseling/v_create'
        );
        $this->template->display($data['content'], $data);
    }

    public function docreate($param = null)
    {
        $status = 'I';
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'master/M_Branch', 'trans/M_TrxType', 'agenda/M_CounselingSession', 'agenda/M_NotificationRule'));
        $branchData = $this->M_Branch->read(' AND cdefault = \'YES\' ')->row();
        header('Content-Type: application/json');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->tmp_update(array(
                'counselor' => $this->input->get_post('counselor'),
                'description' => strtoupper(strtolower($this->input->get_post('description'))),
                'status' => 'F',
                'branch_id' => $branchData->branch
            ), array(
                'session_id' => $this->session->userdata('nik'),
                'input_by' => $this->session->userdata('nik'),
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                $this->collectstatus();
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

    public function doupdate($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->tmp_update(array(
                'counselor' => $this->input->get_post('counselor'),
                'description' => strtoupper(strtolower($this->input->get_post('description'))),
                'status' => 'U',
            ), array(
                'session_id' => $transaction->session_id,
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                $this->collectstatus();
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

    public function approve($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        $edited = $this->M_CounselingSession->tmp_read(' AND session_id = \'' . $transaction->session_id . '\' AND trim(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' ORDER BY update_date DESC')->row();
        if (!empty($edited)) {
            $this->flashmessage
                ->set(array('Data konseling  karyawan nomer <b>' . $edited->session_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>','warning',))
                ->redirect('agenda/counseling/');
        }
        if ($this->M_CounselingSession->exists(array('session_id' => $json->session_id, 'session_date' => null))) {
            $this->flashmessage
                ->set(array( 'Data konseling  karyawan nomer <b>' . $transaction->session_id . '</b> belum dijadwalkan</b>','warning',))
                ->redirect('agenda/counseling/');
        }
        $data = array(
            'title' => 'APPROVE DATA KONSELING',
            'counselor' => $this->M_Employee->read(' AND TRUE ')->result(),
            'transaction' => $transaction,
            'formAction' => site_url('agenda/counseling/doapprove/' . bin2hex(json_encode(array('session_id' => $transaction->session_id)))),
            'employee' => $employee,
            'content' => 'agenda/counseling/v_approve'
        );
        $this->template->display($data['content'], $data);

    }

    public function doapprove($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        $edited = $this->M_CounselingSession->tmp_read(' AND session_id = \'' . $transaction->session_id . '\' AND trim(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' ORDER BY update_date DESC')->row();
        if (!empty($edited)) {
            $this->flashmessage
                ->set(array( 'Data konseling  karyawan nomer <b>' . $edited->session_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>','warning'))
                ->redirect('agenda/counseling/');
        }
        header('Content-Type: application/json; charset=utf-8');
        if ($this->M_CounselingSession->exists(array('session_id' => $json->session_id, 'session_date' => null))) {
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Konseling belum dijadwalkan'
            ));
        } else {
            try {
                $this->db->trans_start();
                $this->M_CounselingSession->update(array(
                    'approve_by' => $this->session->userdata('nik'),
                    'approve_date' => date('Y-m-d H:i:s'),
                    'status' => 'P',
                ), array(
                    'session_id' => $transaction->session_id,
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $this->collectstatus();
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


    }

    public function docancel($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        header('Content-Type: application/json; charset=utf-8');
        if ($this->M_CounselingSession->exists(array('session_id' => $json->session_id, 'status <> ' => 'C'))) {
            try {
                $this->db->trans_start();
                $this->M_CounselingSession->update(array(
                    'status' => 'C',
                    'cancel_by' => $this->session->userdata('nik'),
                    'cancel_date' => date('Y-m-d H:i:s'),
                ), array(
                    'session_id' => $json->session_id,
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $this->collectstatus();
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Data berhasil dibatalkan'
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
        } else {
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Dokumen tidak ditemukan / sudah dibatalkan'
            ));
        }

    }

    public function doreset($param = null)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->tmp_delete(array('session_id' => trim($this->session->userdata('nik'))), array('update_by' => trim($this->session->userdata('nik'))));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data berhasil dibatalkan'
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

    public function createdetail($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();

        $data = array(
            'title' => 'INPUT HASIL KONSELING',
            'counselor' => $this->M_Employee->read(' AND TRUE ')->result(),
            'transaction' => $transaction,
            'formAction' => site_url('agenda/counseling/docreatedetail/' . bin2hex(json_encode(array('session_id' => $transaction->session_id)))),
            'employee' => $employee,
            'content' => 'agenda/counseling/v_create_detail',
        );
        $this->template->display($data['content'], $data);
    }

    public function docreatedetail($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        $detailData = $this->M_CounselingSession->detail_read(' AND session_id = \'' . $transaction->session_id . '\' ORDER BY sort DESC LIMIT 1 ')->row();
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->detail_create(array(
                'session_id' => $transaction->session_id,
                'sort' => (!is_null($detailData->sort) ? $detailData->sort + 1 : 1),
                'problem' => strtoupper(strtolower($this->input->get_post('problem'))),
                'solution' => strtoupper(strtolower($this->input->get_post('solution'))),
                'score' => ((is_null($this->input->get_post('score')) or empty($this->input->get_post('score'))) ? null : $this->input->get_post('score')),
                'input_by' => trim($this->session->userdata('nik')),
                'input_date' => date('Y-m-d H:i:s'),
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

    public function updatedetail($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->read(' AND session_id = \'' . $json->session_id . '\' ')->row();
        $detail = $this->M_CounselingSession->detail_read(' AND session_id = \'' . $transaction->session_id . '\' AND detail_id = \'' . $json->detail_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        $data = array(
            'title' => 'UBAH HASIL KONSELING',
            'counselor' => $this->M_Employee->read(' AND TRUE ')->result(),
            'transaction' => $transaction,
            'detail' => $detail,
            'formAction' => site_url('agenda/counseling/doupdatedetail/' . bin2hex(json_encode(array('session_id' => $detail->session_id, 'detail_id' => $detail->detail_id)))),
            'employee' => $employee,
            'content' => 'agenda/counseling/v_update_detail',
        );
        $this->template->display($data['content'], $data);
    }

    public function doupdatedetail($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->detail_read(' AND session_id = \'' . $json->session_id . '\' AND detail_id = \'' . $json->detail_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->detail_update(array(
                'problem' => strtoupper(strtolower($this->input->get_post('problem'))),
                'solution' => strtoupper(strtolower($this->input->get_post('solution'))),
                'score' => ((is_null($this->input->get_post('score')) or empty($this->input->get_post('score'))) ? null : $this->input->get_post('score')),
                'update_by' => trim($this->session->userdata('nik')),
                'update_date' => date('Y-m-d H:i:s'),
            ), array(
                'session_id' => $transaction->session_id,
                'detail_id' => $transaction->detail_id,
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

    public function dodeletedetail($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession'));
        $transaction = $this->M_CounselingSession->detail_read(' AND session_id = \'' . $json->session_id . '\' AND detail_id = \'' . $json->detail_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $transaction->counselee . '\' ')->row();
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_CounselingSession->detail_delete(array(
                'session_id' => $transaction->session_id,
                'detail_id' => $transaction->detail_id,
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

    public function timeCheck()
    {
        header('Content-Type: application/json; charset=utf-8');
        if (strtotime($this->input->get_post('begin')) >= strtotime($this->input->get_post('end'))) {
            http_response_code(400);
            echo json_encode(array(
                'statusText' => 'Terjadi kesalahan',
                'message' => '<b>Jam selesai tidak boleh sama atau lebih kecil dari jam mulai</b>',
            ));
        } else {
            http_response_code(200);
            echo json_encode(array());
        }
    }

    public function loadmailtemplate_ori()
    {
        $data = array(
            'send_to' => 'AGA',
            'transaction' => array(
                'Kode_Agenda' => 'CO230036',
                'Tipe_Agenda' => 'KONSELING',
                'Aplikasi' => 'HRMS',
                'Nama_Konseli' => 'DIDIK SETIAWAN',
                'Nama_Konselor' => 'YOZEF HERNINDYO HANDONO',
                'Tanggal_Acara' => 'Thursday, 24 August 2023',
                'Waktu_Acara' => '12:00:00 - 12:00:00',
                'Lokasi' => 'RUANG MEETING',
            )
        );
        $this->load->view('notification_template/counseling/email_', $data);
    }

    public function loadmailtemplate()
    {
        $data = array(
            'send_to' => 'AGA',
            'status' => 'P',
            'transaction' => array(
                'Kode_Agenda' => 'CO230036',
                'Tipe_Agenda' => 'KONSELING',
                'Aplikasi' => 'HRMS',
                'Nama_Konseli' => 'DIDIK SETIAWAN',
                'Nama_Konselor' => 'YOZEF HERNINDYO HANDONO',
                'Tanggal_Acara' => 'Thursday, 24 August 2023',
                'Waktu_Acara' => '12:00:00 - 12:00:00',
                'Lokasi' => 'RUANG MEETING',
            )
        );
        $this->load->view('notification_template/counseling/email', $data);
    }

    public function q_user_checkhr(){
        $nik=$this->session->userdata('nik');
        return $this->db->query("select bag_dept from sc_mst.karyawan where nik='$nik'");
    }
}