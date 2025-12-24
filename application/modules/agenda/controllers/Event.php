<?php

class Event extends MX_Controller
{
    private $menuID;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('master/m_akses'));
        $this->load->library(array('template', 'flashmessage',));
        if (!$this->session->userdata('nik')) {
            redirect(base_url() . '/');
        }
        $this->menuID = 'I.Z.A.2';
    }

    private function userdata()
    {
        return $this->session->all_userdata();
    }

    public function index()
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_CounselingSession', 'agenda/M_AgendaAttendance'));
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
        $this->M_AgendaAttendance->tmp_delete(array('input_by' => trim($this->session->userdata('nik'))), array('update_by' => trim($this->session->userdata('nik'))));
        $userhr = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'DIR' or $this->m_akses->userhr();
        $superior = $this->m_akses->superiors_access();
        $event = $this->M_TrxType->q_master_search_where(' AND type = \'EVENT\' ')->result();
        $data = array(
            'menuID' => $this->menuID,
            'userhr' => $userhr,
            'inputUrl' => site_url('agenda/event/create'),
            'loadEventUrl' => site_url('agenda/event/loadevent'),
            'event' => $event,
            'title' => 'Jadwal Agenda',
            'content' => 'agenda/event/v_calendar',
        );
        $this->template->display($data['content'], $data);
    }

    public function docreate($param)
    {
        $this->load->model(array('master/M_Employee', 'master/M_Branch', 'trans/M_TrxType', 'agenda/M_Agenda'));
        $json = json_decode(hex2bin($param));
        $userhr = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'DIR' or $this->m_akses->userhr();
        $branchData = $this->M_Branch->read(' AND cdefault = \'YES\' ')->row();
        header('Content-Type: application/json');
        $room_id = $this->input->get_post('location');
        $room = $this->db->query("select room_name from sc_mst.room where room_id = ?", array($room_id))->row();
        $location = $room ? $room->room_name : null;

        $calendar = $this->post_google_calendar
            (strtoupper(strtolower($this->input->get_post('agenda_name'))), 
                strtoupper(strtolower($this->input->get_post('begin_date'))),
                strtoupper(strtolower($this->input->get_post('end_date'))),
                strtoupper(strtolower($location)),
                trim($this->input->get_post('link')));
        $calendarId = json_decode($calendar)->id;
       
        try {
            $this->db->trans_start();
            $this->M_Agenda->tmp_update(array(
                'agenda_name' => strtoupper(strtolower($this->input->get_post('agenda_name'))),
                'agenda_type' => strtoupper(strtolower($this->input->get_post('agenda_type'))),
                'organizer_type' => strtoupper(strtolower($this->input->get_post('organizer_type'))),
                'organizer_name' => strtoupper(strtolower($this->input->get_post('organizer_name'))),
                'description' => strtoupper(strtolower($this->input->get_post('description'))),
                'begin_date' => strtoupper(strtolower($this->input->get_post('begin_date'))),
                'end_date' => strtoupper(strtolower($this->input->get_post('end_date'))),
                'location' => strtoupper(strtolower($this->input->get_post('location'))),
                'link' => trim($this->input->get_post('link')),
                'status' => 'F',
                'branch_id' => $branchData->branch,
                'calendar_id' => $calendarId
            ), array(
                'agenda_id' => $this->session->userdata('nik'),
                'input_by' => $this->session->userdata('nik'),
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data berhasil disimpan',
                    'calendar_id' => $calendarId
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

    public function read($param)
    {
        $nikuser = trim($this->session->userdata('nik'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $check = $this->M_Agenda->checkpassedevent($json->agenda_id);
        if ($check){
             $paramtrx = $this->M_Agenda->readver2(' AND aa.agenda_id = \'' . $json->agenda_id . '\' order by g.kddok asc')->row();
        }
        else {
            $paramtrx = $this->M_Agenda->read(' AND aa.agenda_id = \'' . $json->agenda_id . '\' ')->row();
        }
        $transaction = $paramtrx;
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $agendaData = $this->M_AgendaAttendance->read(" and agenda_id =  '$json->agenda_id'  AND nik = '$nikuser' ")->row();
        
        $content = (!empty($json->detail) ? 'agenda/event/modals/v_read_only' : 'agenda/event/modals/v_read');
        $data = array(
            'modalTitle' => 'RINCIAN AGENDA <b>' . $transaction->agenda_name . '</b>',
            'modalSize' => 'modal-md',
            'canmodifyresult' => (strtotime(date('d-m-Y H:i:s')) > strtotime($transaction->end_date) ? TRUE : FALSE),
            'transaction' => $transaction,
            'agendaData' => $agendaData,
            'userhr' => $userhr,
            'notificationUrl' => site_url('agenda/event/broadcast/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'sendcalendarUrl' => site_url('agenda/event/patch_utils' . '?agenda_id=' . $transaction->agenda_id . '&calendar_id=' . $transaction->calendar_id),
            'attendUrl' => site_url('agenda/event/confirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => trim($this->session->userdata('nik')))))),
            'cancelUrl' => site_url('agenda/event/docancel/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => trim($this->session->userdata('nik')))))),
            // Add eventResult only if agenda_type is 'OJT'
            'eventResult' => ($transaction->agenda_type == 'OJT' ? site_url('agenda/event/listeventresultojt/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))) : site_url('agenda/event/listeventresult/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id))))),
            'updateUrl' => site_url('agenda/event/update/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'participantUrl' => site_url('agenda/event/createattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'participantResult' => site_url('agenda/event/listeventresult/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $agendaData->nik)))),
            'participantList' => site_url('agenda/event/listeventparticipant/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $agendaData->nik)))),
            'checkAttendanceUrl' => site_url('agenda/event/checkattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'addojt' => site_url('agenda/event/addojt/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'checkConfirmationUrl' => site_url('agenda/event/checkconfirmation/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'title' => 'Rincian Agenda',
            'content' => $content,
        );
        $this->load->view($data['content'], $data);
    }

    public function doreset($param = null)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_Agenda->tmp_delete(array('agenda_id' => trim($this->session->userdata('nik'))), array('update_by' => trim($this->session->userdata('nik'))));
            $this->M_AgendaAttendance->tmp_delete(array('input_by' => trim($this->session->userdata('nik'))), array('update_by' => trim($this->session->userdata('nik'))));
            if (!is_null($json->agenda_id)) {
                $this->M_AgendaAttendance->update(array(
                    'status' => 'F',
                ), array(
                    'agenda_id' => $json->agenda_id,
                ));
            }
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

    public function update($param = null)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'agenda/M_Room'));
        $branchData = $this->M_Branch->read(' AND cdefault = \'YES\' ')->row();
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $agenda_type = $this->M_TrxType->q_master_search_where(' AND type = \'EVENT\' ')->result();
        $organizer_type = $this->M_TrxType->q_master_search_where(' AND type = \'ORGANIZERTYPE\' ')->result();
        $roomData = $this->M_Room->read(' AND id = \''.$transaction->room_id.'\' ')->result();
        $edited = $this->M_Agenda->tmp_read(' AND agenda_id = \'' . $transaction->agenda_id . '\' AND trim(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' ORDER BY update_date DESC')->row();
        if (!empty($edited)) {
            $this->flashmessage
                ->set(array('Data agenda nomer <b>' . $edited->agenda_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>', 'warning'))
                ->redirect('agenda/counseling/');
        }
        $this->M_Agenda->update(array(
            'status' => 'U',
            'update_by' => trim($this->session->userdata('nik')),
            'update_date' => date('Y-m-d H:i:s'),
        ), array(
            'agenda_id' => $json->agenda_id
        ));
        $this->M_AgendaAttendance->update(array(
            'status' => 'U',
            'update_by' => trim($this->session->userdata('nik')),
            'update_date' => date('Y-m-d H:i:s'),
        ), array(
            'agenda_id' => $json->agenda_id
        ));
        $data = array(
            'branch' => $branchData,
            'transaction' => $transaction,
            'agendaType' => $agenda_type,
            'organizerType' => $organizer_type,
            'roomData' => $roomData,
            'formAction' => site_url('agenda/event/doupdate/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'title' => 'Ubah Agenda',
            'content' => 'agenda/event/v_update',
        );
        $this->template->display($data['content'], $data);
    }

    public function loadevent($param = null)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        header('Content-Type: application/json; charset=utf-8');
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        // var_dump($userhr);
        // die();
        if ($userhr) {
            $param = '';
        } else {
            $agenda = array();
            foreach ($this->M_AgendaAttendance->read(' AND nik = \'' . trim($this->session->userdata('nik')) . '\' ')->result() as $index => $item) {
                array_push($agenda, $item->agenda_id);
            }
            $agenda = "'" . implode("','", $agenda) . "'";
            $param = ' AND agenda_id IN (' . $agenda . ') ';
        }
        $events = array();
        foreach ($this->M_Agenda->read($param)->result() as $index => $item) {
            array_push($events, array(
                'id' => $item->agenda_id,
                'title' => $item->agenda_name,
                'start' => date('Y-m-d\TH:i:s', strtotime($item->begin_date)),
                'end' => date('Y-m-d\TH:i:s', strtotime($item->end_date)),
                'description' => $item->description,
                'color' => $item->agenda_type_color,
                'url' => site_url('agenda/event/read/' . bin2hex(json_encode(array('agenda_id' => $item->agenda_id)))),
                'allDay' => false,
            ));
        }
        echo json_encode($events);
    }

    public function doupdate($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        header('Content-Type: application/json; charset=utf-8');
        try {
            $this->db->trans_start();
            $this->M_Agenda->tmp_update(array(
                'agenda_name' => strtoupper(strtolower($this->input->get_post('agenda_name'))),
                'agenda_type' => $this->input->get_post('agenda_type'),
                'organizer_type' => $this->input->get_post('organizer_type'),
                'organizer_name' => strtoupper(strtolower($this->input->get_post('organizer_name'))),
                'begin_date' => $this->input->get_post('begin_date'),
                'end_date' => $this->input->get_post('end_date'),
                'location' => strtoupper(strtolower($this->input->get_post('location'))),
                'link' => trim($this->input->get_post('link')),
                'description' => strtoupper(strtolower($this->input->get_post('description'))),
                'update_by' => trim($this->session->userdata('nik')),
                'update_date' => date('Y-m-d H:i:s'),
                'status' => 'U',
            ), array(
                'agenda_id' => $transaction->agenda_id,
            ));
            if ($this->input->get_post('begin_date') <> $transaction->begin_date or $this->input->get_post('end_date') <> $transaction->end_date) {
                if ($transaction->participant_count > 0) {
                    $this->M_Agenda->update(array(
                        'status' => 'R',
                    ), array(
                        'agenda_id' => $transaction->agenda_id,
                    ));
                }
                $this->M_Agenda->history_create(array(
                    'agenda_id' => $transaction->agenda_id,
                    'begin_date' => $this->input->get_post('begin_date'),
                    'end_date' => $this->input->get_post('end_date'),
                    'reason' => $this->input->get_post('reason'),
                    'input_by' => trim($this->session->userdata('nik')),
                    'input_date' => date('Y-m-d H:i:s'),
                ));
            }
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

    public function createattendance($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $formatBeginDate = date('Y-m-d', strtotime($transaction->begin_date));
        $edited = $this->M_Agenda->tmp_read(' AND agenda_id = \'' . $transaction->agenda_id . '\' AND trim(update_by) <> \'' . trim($this->session->userdata('nik')) . '\' ORDER BY update_date DESC')->row();
        if (!empty($edited)) {
            $this->flashmessage
                ->set(array('Data agenda nomer <b>' . $edited->agenda_id . '</b> sedang diubah oleh <b> NIK ' . $edited->update_by . '</b>', 'warning'))
                ->redirect('agenda/counseling/');
        }
        $this->M_Agenda->update(array(
            'status' => 'U',
            'update_by' => trim($this->session->userdata('nik')),
            'update_date' => date('Y-m-d H:i:s'),
        ), array(
            'agenda_id' => $json->agenda_id
        ));
        $this->M_AgendaAttendance->update(array(
            'status' => 'U',
            'update_by' => trim($this->session->userdata('nik')),
            'update_date' => date('Y-m-d H:i:s'),
        ), array(
            'agenda_id' => $json->agenda_id
        ));
        $data = array(
            'transaction' => $transaction,
            'title' => 'PESERTA UNDANGAN',
            'selectUrl' => site_url('agenda/event/addParticipant/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'removeUrl' => site_url('agenda/event/removeParticipant/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'resetUrl' => site_url('agenda/event/clearParticipant/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'saveUrl' => site_url('agenda/event/docreateattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'scheduleUrl' => site_url('agenda/event/docreateattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'backUrl' => site_url('agenda/event/doreset'),
            'eventUrl' => site_url('agenda/event/read/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'detail' => TRUE)))),
            'filterUrl' => site_url('agenda/event/setfilter/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'addActiveUrl' => site_url('agenda/event/alignschedulewithagenda/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
        );
        $employee = $this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover dataTable', true)
            ->columns('nik, fullname, department_name, subdepartment_name, position_name, workid, shiftid, group_name, agenda_id')
            ->addcolumn('no', 'no')
            ->addcolumn('schedule', '<button class="btn btn-xs btn-info pull-right mr-3 schedule" data-schedule="' . $json->agenda_id . '" data-href="' . site_url('agenda/event/checkschedule/$1') . '" data-toggle="tooltip" title="Jadwal Kerja"><i class="fa fa-clock-o"></i></button>', 'nik, agenda_id', true)
            ->addcolumn('join', '<button class="btn btn-xs btn-success pull-right mr-3 join" data-schedule="' . $json->agenda_id . '" data-href="' . site_url('agenda/event/participation/join/$1') . '" data-toggle="tooltip" title="Ikut"><i class="fa fa-sign-in"></i></button>', 'nik, agenda_id', true)
            ->addcolumn('leave', '<button class="btn btn-xs btn-danger pull-right mr-3 leave" data-schedule="' . $json->agenda_id . '" data-href="' . site_url('agenda/event/participation/leave/$1') . '" data-toggle="tooltip" title="Batal Ikut"><i class="fa fa-sign-out"></i></button>', 'nik, agenda_id', true)
            ->addcolumn('formatNik', '
              <input class="form-check-input pull-right largerCheckbox employee" style="" type="checkbox" id="inlineCheckbox1" value="$1">
            ', 'nik')
            ->querystring($this->M_Agenda->employee_list_read_txt(' AND employment_status not in ( \'KO\',\'\') AND agenda_id = \'' . $transaction->agenda_id . '\' AND (workdate = \'' . $formatBeginDate . '\' OR workdate is null) AND nik NOT IN (SELECT nik FROM sc_tmp.agenda_attendance WHERE agenda_id = \'' . $transaction->agenda_id . '\') '))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, array('nik', 'formatNik', 'schedule', 'join'))
            ->header('Nama', 'fullname', true, true, true)
            ->header('Bagian', 'department_name', true, true, true)
            ->header('Subdepartemen', 'subdepartment_name', true, true, true)
            ->header('Jabatan', 'position_name', true, true, true)
            ->header("Shift Ke ($formatBeginDate)", 'shiftid', true, true, true)
            ->header("Nama Regu ($formatBeginDate)", 'group_name', true, true, true);
        if ($this->input->post('tableid') == 'table-employee') {
            $employee->generateajax();
        }
        $data['employee'] = array(
            'title' => 'Daftar Karyawan',
//            'count' => $this->M_Employee->read(' AND statuskepegawaian <> \'KO\' AND nik NOT IN (SELECT nik FROM sc_trx.agenda_attendance WHERE agenda_id = \''.$transaction->agenda_id.'\') ')->num_rows(),
            'generatetable' => $employee->generatetable('table-employee', false),
            'jquery' => $employee->jquery(1, 'table-employee', false),
        );
        $participant = $this->datatablessp->datatable('table-participant', 'table table-striped table-bordered table-hover dataTable', true)
            ->columns('nik, fullname, department_name, subdepartment_name, position_name, agenda_id')
            ->addcolumn('no', 'no')
            ->addcolumn('schedule', '<button class="btn btn-xs btn-info pull-right mr-3 schedule" data-schedule="' . $json->agenda_id . '" data-href="' . site_url('agenda/event/checkschedule/$1') . '" data-toggle="tooltip" title="Jadwal Kerja"><i class="fa fa-clock-o"></i></button>', 'nik, agenda_id', true)
            ->addcolumn('join', '<button class="btn btn-xs btn-success pull-right mr-3 join" data-schedule="' . $json->agenda_id . '" data-href="' . site_url('agenda/event/participation/join/$1') . '" data-toggle="tooltip" title="Ikut"><i class="fa fa-sign-in"></i></button>', 'nik, agenda_id', true)
            ->addcolumn('leave', '<button class="btn btn-xs btn-danger pull-right mr-3 leave" data-schedule="' . $json->agenda_id . '" data-href="' . site_url('agenda/event/participation/leave/$1') . '" data-toggle="tooltip" title="Batal Ikut"><i class="fa fa-sign-out"></i></button>', 'nik, agenda_id', true)
            ->addcolumn('formatNik', '
              <input class="form-check-input pull-right largerCheckbox participant" style="" type="checkbox" id="inlineCheckbox1" value="$1">
            ', 'nik')
            ->querystring($this->M_AgendaAttendance->tmp_participant_txt(' AND employment_status <> \'KO\' AND agenda_id = \'' . $transaction->agenda_id . '\' '))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, array('nik', 'formatNik', 'schedule', 'leave'))
            ->header('Nama', 'fullname', true, true, true)
            ->header('Bagian', 'department_name', true, true, true)
            ->header('Subdepartemen', 'subdepartment_name', true, true, true)
            ->header('Jabatan', 'position_name', true, true, true);
        if ($this->input->post('tableid') == 'table-participant') {
            $participant->generateajax();
        }
        $data['participant'] = array(
            'title' => 'Peserta',
//            'count' => $this->M_Employee->read(' AND statuskepegawaian <> \'KO\' AND nik NOT IN (SELECT nik FROM sc_trx.agenda_attendance WHERE agenda_id = \''.$transaction->agenda_id.'\') ')->num_rows(),
            'generatetable' => $participant->generatetable('table-participant', false),
            'jquery' => $participant->jquery(1, 'table-participant', false),
        );
        $this->template->display('agenda/event/v_employee', $data);
    }

    public function docreateattendance($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        header('Content-Type: application/json');
        if ($this->M_AgendaAttendance->tmp_exists(array('agenda_id' => $json->agenda_id))) {
            $participant_count = $this->M_AgendaAttendance->tmp_read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->num_rows();
            try {
                $this->db->trans_start();
                $this->M_Agenda->tmp_update(array(
                    'participant_count' => $participant_count,
                    'status' => 'U',
                ), array(
                    'agenda_id' => $transaction->agenda_id,
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
        } else {
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => '<b>BELUM ADA PESERTA YANG DIPILIH</b>'
            ));
        }
    }

    public function addParticipant($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        header('Content-Type: application/json');
//        var_dump($this->input->post('employee'));die();
        try {
            $this->db->trans_start();
            foreach ($this->input->post('employee') as $index => $item) {
                $this->M_AgendaAttendance->tmp_create(array(
                    'agenda_id' => $json->agenda_id,
                    'nik' => $item,
                    'status' => 'I',
                    'input_by' => trim($this->session->userdata('nik')),
                    'input_date' => date('Y-m-d H:i:s'),
                ));
            }

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

    public function removeParticipant($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        header('Content-Type: application/json');
        try {
            $this->db->trans_start();
            foreach ($this->input->post('participant') as $index => $item) {
                $this->M_AgendaAttendance->tmp_delete(array(
                    'agenda_id' => $json->agenda_id,
                    'nik' => $item,
                ));
            }
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

    public function clearParticipant($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        header('Content-Type: application/json');
        try {
            $this->db->trans_start();
            $this->M_AgendaAttendance->tmp_delete(array(
                'agenda_id' => $json->agenda_id,
            ));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data berhasil direset'
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

    public function listeventparticipant($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $this->datatablessp->datatable('table-event-participant', 'table table-borderless datatable', true)
            ->columns('nik, nmlengkap, nmdept, nmsubdept,nmjabatan, agenda_id, attend_status_text, attend_status, confirm_status_text, confirm_status')
            ->addcolumn('no', 'no')
            ->addcolumn('send', '<a href="javascript:void(0)" data-href=\'' . site_url('agenda/event/broadcast/$1') . '\' data-action=\'send\' class=\'btn btn-sm btn-instagram send-notification pull-right\' data-toggle=\'tooltip\' title=\'Kirim Notifikasi\'><span class="glyphicon glyphicon-envelope"> Kirim</span></a>', 'nik, agenda_id', true)
            ->querystring($this->M_AgendaAttendance->read_txt(($userhr ? ' AND agenda_id = \'' . $transaction->agenda_id . '\' ' : ' AND agenda_id = \'' . $transaction->agenda_id . '\' AND nik = \'' . trim($this->session->userdata('nik')) . '\' ')))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, array('nik', 'send'))
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Jabatan', 'nmjabatan', true, true, true)
            ->header('Undangan', 'confirm_status', true, true, true, array('confirm_status_text'))
            ->header('Kehadiran acara', 'attend_status', true, true, true, array('attend_status_text'));
        $this->datatablessp->generateajax();
        $data = array(
            'refreshUrl' => site_url('agenda/event/listeventparticipant/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id)))),
            'backUrl' => site_url('agenda/event/'),
            'title' => 'Kirim Notifikasi Peserta Agenda ' . $transaction->agenda_name,
            'content' => 'agenda/event/v_list_participant',
        );
        $this->template->display($data['content'], $data);

    }

    public function listeventresult($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $arrNik = ($userhr ? array('nik', 'action') : array('nik'));
        $this->datatablessp->datatable('table-event-result', 'table table-borderless datatable', true)
            ->columns('nik, nmlengkap, nmdept, nmsubdept,nmjabatan, agenda_id, attend_status_text')
            ->addcolumn('no', 'no')
            ->addcolumn('action', '<a href="javascript:void(0)" data-href=\'' . site_url('agenda/event/createeventresult/$1') . '\' data-action=\'create\' class=\'btn btn-sm btn-success create pull-right\' data-toggle=\'tooltip\' title=\'Input Hasil\'>Input Hasil</a>', 'nik, agenda_id', true)
            ->addcolumn('read', '<a href="javascript:void(0)" data-href=\'' . site_url('agenda/event/readeventresult/$1') . '\' data-action=\'read\' class=\'btn btn-sm btn-info read \' data-toggle=\'tooltip\' title=\'Lihat Hasil\'>Lihat Hasil</a>', 'nik, agenda_id', true)
            ->querystring($this->M_AgendaAttendance->read_txt(($userhr ? ' AND agenda_id = \'' . $transaction->agenda_id . '\' ' : ' AND agenda_id = \'' . $transaction->agenda_id . '\' AND nik = \'' . trim($this->session->userdata('nik')) . '\' ')))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, $arrNik)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Jabatan', 'nmjabatan', true, true, true)
            ->header('Kehadiran acara', 'attend_status', true, true, true, array('attend_status_text'))
            ->header('Aksi', 'action', true, false, true, array('read'));
        $this->datatablessp->generateajax();
        $data = array(
            'backUrl' => site_url('agenda/event/'),
            'title' => 'Hasil Agenda ' . $transaction->agenda_name,
            'content' => 'agenda/event/v_list_event_result',
        );
        $this->template->display($data['content'], $data);

    }

        public function listeventresultojt($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $attendtrans = $this->M_AgendaAttendance->read_txt(($userhr ? ' AND agenda_id = \'' . $transaction->agenda_id . '\' ' : ' AND agenda_id = \'' . $transaction->agenda_id . '\' AND nik = \'' . trim($this->session->userdata('nik')) . '\' '))->row;
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $arrNik = array('nik');
        $this->datatablessp->datatable('table-event-result', 'table table-borderless datatable', true)
            ->columns('nik, nmlengkap, nmdept, nmsubdept,nmjabatan, agenda_id, attend_status_text')
            ->addcolumn('no', 'no')
            ->addcolumn('read', '<a href="javascript:void(0)" data-href=\'' . site_url('ojt/list_ojtpen') . '\' data-action=\'read\' class=\'btn btn-sm btn-info read \' data-toggle=\'tooltip\' title=\'Lihat Hasil\'>Lihat Hasil</a>', 'nik, agenda_id', true)
            ->querystring($this->M_AgendaAttendance->read_txt(($userhr ? ' AND agenda_id = \'' . $transaction->agenda_id . '\' ' : ' AND agenda_id = \'' . $transaction->agenda_id . '\' AND nik = \'' . trim($this->session->userdata('nik')) . '\' ')))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, $arrNik)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Jabatan', 'nmjabatan', true, true, true)
            ->header('Kehadiran acara', 'attend_status', true, true, true, array('attend_status_text'))
         ->header(
                'Aksi',
                'action',
                true,
                false,
                true,
                (trim($attendtrans->ojt) != 'T' ? array('read', $attendtrans->ojt) : array( $attendtrans->ojt))
            );

        $this->datatablessp->generateajax();
        $data = array(
            'backUrl' => site_url('agenda/event/'),
            'title' => 'Hasil Agenda ' . $transaction->agenda_name,
            'content' => 'agenda/event/v_list_event_resultojt',
        );
        $this->template->display($data['content'], $data);

    }

    public function createeventresult($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'agenda/M_AgendaResult'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $json->nik . '\' ')->row();
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        if (!$this->M_AgendaAttendance->exists(array('agenda_id' => $transaction->agenda_id, 'nik' => $employee->nik, 'attend_status' => 't'))) {
            $data = array(
                'modalTitle' => 'LIHAT HASIL <b>' . $transaction->agenda_name . '</b>',
                'modalSize' => 'modal-md',
                'title' => 'Buat Hasil Agenda',
                'message' => 'Peserta tidak hadir',
                'content' => 'agenda/event/modals/v_block',
            );
        } else {
            if (!$this->M_AgendaResult->exists(array('agenda_id' => $transaction->agenda_id, 'nik' => $employee->nik))) {
                $data = array(
                    'modalTitle' => 'INPUT HASIL <b>' . $transaction->agenda_name . '</b>',
                    'modalSize' => 'modal-lg',
                    'formAction' => site_url('agenda/event/docreateeventresult/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $employee->nik)))),
                    'transaction' => $transaction,
                    'employee' => $employee,
                    'userhr' => $userhr,
                    'title' => 'Input Hasil Agenda',
                    'content' => 'agenda/event/result/modals/v_create',
                );
            } else {
                $result = $this->M_AgendaResult->read(' AND nik =\'' . $employee->nik . '\' AND agenda_id = \'' . $transaction->agenda_id . '\' ')->row();
                $data = array(
                    'modalTitle' => 'UBAH HASIL <b>' . $transaction->agenda_name . '</b>',
                    'modalSize' => 'modal-lg',
                    'formAction' => site_url('agenda/event/doupdateeventresult/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $employee->nik)))),
                    'transaction' => $transaction,
                    'employee' => $employee,
                    'userhr' => $userhr,
                    'result' => $result,
                    'title' => 'Ubah Hasil Agenda',
                    'content' => 'agenda/event/result/modals/v_update',
                );
            }
        }


        $this->load->view($data['content'], $data);

    }

    public function docreateeventresult($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'agenda/M_AgendaResult'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $this->input->post('nik') . '\' ')->row();
        header('Content-Type: application/json');
        if ($userhr) {
            if ($transaction->agenda_type == 'COACH') {
                $path = './uploads/agenda/' . $transaction->agenda_id . '/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $employee->nik . '-' . $employee->nmlengkap;
                $config['remove_spaces'] = FALSE;
                $this->load->library('upload', $config);
                $this->upload->display_errors('', '');
                $this->upload->initialize($config);
                if ($this->upload->do_upload('sertificate')) {
                    $upload = TRUE;
                    $uploadData = $this->upload->data();
                } else {
                    http_response_code(404);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => $this->upload->display_errors()
                    ));
                }
            }
            try {
                $this->db->trans_start();
                $this->M_AgendaResult->create(array(
                    'agenda_id' => $transaction->agenda_id,
                    'nik' => $this->input->post('nik'),
                    'pretest' => $this->input->post('pretest'),
                    'posttest' => $this->input->post('posttest'),
                    'score' => $this->input->post('score'),
                    'result_text' => strtoupper(strtolower($this->input->post('result_text'))),
                    'sertificate' => ($upload ? str_replace('.', '', $path) . $uploadData['file_name'] : null),
                    'branch_id' => $transaction->branch_id,
                    'status' => 'I',
                    'input_by' => trim($this->session->userdata('nik')),
                    'input_date' => date('Y-m-d H:i:s'),
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Data penilaian karyawan NIK: <b>' . $this->input->post('nik') . '</b> berhasil disimpan'
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
                'message' => 'Anda tidak memiliki akses'
            ));
        }
    }

    public function create($param = null)
    {
        $this->load->model(array('master/M_Employee', 'master/M_Branch', 'trans/M_TrxType', 'agenda/M_Agenda'));
        $branchData = $this->M_Branch->read(' AND cdefault = \'YES\' ')->row();
        $this->M_Agenda->tmp_delete(array(
            'agenda_id' => $this->session->userdata('nik'),
            'branch_id' => $branchData->branch,
            'status' => 'I',
            'input_by' => $this->session->userdata('nik'),
        ));
        $this->M_Agenda->tmp_create(array(
            'agenda_id' => $this->session->userdata('nik'),
            'branch_id' => $branchData->branch,
            'status' => 'I',
            'input_by' => $this->session->userdata('nik'),
            'input_date' => date('Y-m-d H:i:s'),
        ));
        $data = array(
            'branch' => $branchData,
            'formAction' => site_url('agenda/event/docreate/' . bin2hex(json_encode(array('agenda_id' => trim($this->session->userdata('nik')))))),
            'title' => 'Buat Agenda',
            'content' => 'agenda/event/v_create',
        );
        $this->template->display($data['content'], $data);
    }

    public function doupdateeventresult($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'agenda/M_AgendaResult'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $this->input->post('nik') . '\'  ')->row();
        $resultData = $this->M_AgendaResult->read(' AND agenda_id = \'' . $transaction->agenda_id . '\' AND nik = \'' . $employee->nik . '\' ')->row();
        header('Content-Type: application/json');
        if ($userhr) {
            if ($transaction->agenda_type == 'COACH') {
                if (!empty($_FILES['sertificate']['name'])) {
                    if (file_exists('.' . $resultData->sertificate)) {
                        unlink('.' . $resultData->sertificate);
                    }
                    $path = './uploads/agenda/' . $transaction->agenda_id . '/';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'pdf';
                    $config['file_name'] = $employee->nik . '-' . $employee->nmlengkap;
                    $config['remove_spaces'] = FALSE;
                    $this->load->library('upload', $config);
                    $this->upload->display_errors('', '');
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('sertificate')) {
                        $upload = TRUE;
                        $uploadData = $this->upload->data();
                    } else {
                        http_response_code(404);
                        echo json_encode(array(
                            'data' => array(),
                            'message' => $this->upload->display_errors()
                        ));
                    }
                }
            }
            try {
                $this->db->trans_start();
                $this->M_AgendaResult->update(array(
                    'pretest' => $this->input->post('pretest'),
                    'posttest' => $this->input->post('posttest'),
                    'score' => $this->input->post('score'),
                    'result_text' => strtoupper(strtolower($this->input->post('result_text'))),
                    'sertificate' => ($upload ? str_replace('.', '', $path) . $uploadData['file_name'] : $resultData->sertificate),
                    'update_by' => trim($this->session->userdata('nik')),
                    'update_date' => date('Y-m-d H:i:s'),
                ), array(
                    'agenda_id' => $transaction->agenda_id,
                    'nik' => $this->input->post('nik'),
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Data penilaian karyawan NIK: <b>' . $this->input->post('nik') . '</b> berhasil disimpan'
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
                'message' => 'Anda tidak memiliki akses'
            ));
        }
    }

    public function readeventresult($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'agenda/M_AgendaResult'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $employee = $this->M_Employee->read(' AND nik = \'' . $json->nik . '\' ')->row();
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        if ($this->M_AgendaResult->exists(array('agenda_id' => $transaction->agenda_id, 'nik' => $employee->nik))) {
            $result = $this->M_AgendaResult->read(' AND nik =\'' . $employee->nik . '\' AND agenda_id = \'' . $transaction->agenda_id . '\' ')->row();
            $data = array(
                'modalTitle' => 'Lihat HASIL <b>' . $transaction->agenda_name . '</b>',
                'modalSize' => 'modal-lg',
                'transaction' => $transaction,
                'employee' => $employee,
                'userhr' => $userhr,
                'result' => $result,
                'title' => 'Input Hasil Agenda',
                'content' => 'agenda/event/result/modals/v_read',
            );
        } else {
            $data = array(
                'modalTitle' => 'LIHAT HASIL <b>' . $transaction->agenda_name . '</b>',
                'modalSize' => 'modal-md',
                'title' => 'Ubah Hasil Agenda',
                'message' => 'Penilaian belum dibuat',
                'content' => 'agenda/event/modals/v_block',
            );
        }

        $this->load->view($data['content'], $data);
    }

    public function confirmattendance($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $transaction = $this->M_AgendaAttendance->read(' AND agenda_id = \'' . $json->agenda_id . '\' AND nik = \'' . $json->nik . '\' ')->row();
        header('Content-Type: application/json');
        if (!is_null($transaction->agenda_id) or !empty($transaction->agenda_id)) {
            if (strtotime(date('Y-m-d H:i:s')) < strtotime($agendaData->begin_date)) {
//                echo 'belum lewat';
                if (is_null($transaction->confirm_status) or empty($transaction->confirm_status)) {
                    http_response_code(200);
                    echo json_encode(array(
                        'cancreate' => TRUE,
                        'statusText' => 'Konfirmasi Kehadiran',
                        'message' => 'Konfirmasi kehadiran untuk undangan agenda <br>' . $agendaData->agenda_name,
                        'confirmText' => 'Hadir',
                        'denyText' => 'Tidak Hadir',
                        'next' => array(
                            'accept' => site_url('agenda/event/doconfirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $transaction->nik, 'type' => 'confirmstatus', 'action' => 'accept')))),
                            'reject' => site_url('agenda/event/doconfirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $transaction->nik, 'type' => 'confirmstatus', 'action' => 'reject')))),
                        )
                    ));
                } else {
                    $confirmText = ($transaction->confirm_status == 't' ? 'Batal hadir' : 'Hadir');
                    $action = ($transaction->confirm_status == 't' ? 'reject' : 'accept');
                    http_response_code(200);
                    echo json_encode(array(
                        'canupdate' => TRUE,
                        'statusText' => 'Konfirmasi Kehadiran',
                        'message' => 'Konfirmasi kehadiran untuk undangan agenda <br> ' . $agendaData->agenda_name,
                        'confirmText' => $confirmText,
                        'next' => array(
                            'confirm' => site_url('agenda/event/doconfirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $transaction->nik, 'type' => 'confirmstatus', 'action' => $action)))),
                        )
                    ));
                }
            } else if (strtotime(date('Y-m-d H:i:s')) > strtotime($agendaData->begin_date) and strtotime(date('Y-m-d H:i:s')) < strtotime($agendaData->end_date)) {
//                echo 'sudah lewat';
                if (!is_null($transaction->confirm_status) or !empty($transaction->confirm_status)) {
                    if ($transaction->confirm_status === 't') {
                        if (is_null($transaction->attend_status) or empty($transaction->attend_status)) {
                            http_response_code(200);
                            echo json_encode(array(
                                'canattend' => TRUE,
                                'statusText' => 'Konfirmasi Kehadiran',
                                'message' => 'Konfirmasi kehadiran saat agenda <br>' . $agendaData->agenda_name,
                                'confirmText' => 'Hadir',
                                'next' => array(
                                    'confirm' => site_url('agenda/event/doconfirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $transaction->nik, 'type' => 'attendstatus', 'action' => 'accept')))),
                                )
                            ));
                        } else {
                            if (strtotime(date('Y-m-d H:i:s')) < strtotime($agendaData->end_date) and $transaction->attend_status === 't') {
                                http_response_code(200);
                                echo json_encode(array(
                                    'canattend' => TRUE,
                                    'statusText' => 'Konfirmasi Kehadiran',
                                    'message' => 'Konfirmasi kehadiran saat agenda <br>' . $agendaData->agenda_name,
                                    'confirmText' => 'Batal Hadir',
                                    'next' => array(
                                        'confirm' => site_url('agenda/event/doconfirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $transaction->nik, 'type' => 'attendstatus', 'action' => 'reject')))),
                                    )
                                ));
                            } else if (strtotime(date('Y-m-d H:i:s')) < strtotime($agendaData->end_date) and $transaction->attend_status === 'f') {
                                http_response_code(200);
                                echo json_encode(array(
                                    'canattend' => TRUE,
                                    'statusText' => 'Konfirmasi Kehadiran',
                                    'message' => 'Konfirmasi kehadiran saat agenda <br>' . $agendaData->agenda_name,
                                    'confirmText' => 'Hadir',
                                    'next' => array(
                                        'confirm' => site_url('agenda/event/doconfirmattendance/' . bin2hex(json_encode(array('agenda_id' => $transaction->agenda_id, 'nik' => $transaction->nik, 'type' => 'attendstatus', 'action' => 'accept')))),
                                    )
                                ));
                            } else {
                                $attendStatus = ($transaction->attend_status === 't' ? 'Hadir' : 'Tidak Hadir');
                                http_response_code(403);
                                echo json_encode(array(
                                    'statusText' => 'Informasi',
                                    'icon' => 'warning',
                                    'message' => '<b>Konfirmasi kehadiran sudah dibuat. Anda ' . $attendStatus . ' </b>',
                                ));
                            }
                        }
                    } else {
                        http_response_code(403);
                        echo json_encode(array(
                            'statusText' => 'Informasi',
                            'icon' => 'warning',
                            'statusText' => 'Konfirmasi Kehadiran',
                            'message' => 'Anda menyatakan tidak hadir',
                        ));
                    }
                } else {
                    http_response_code(403);
                    echo json_encode(array(
                        'statusText' => 'Konfirmasi Kehadiran',
                        'message' => 'Konfirmasi kehadiran sudah lewat',
                    ));
                }
            } else {
                http_response_code(403);
                echo json_encode(array(
                    'statusText' => 'Terjadi kesalahan',
                    'message' => '<b>AGENDA TELAH BERAKHIR</b>',
                ));
            }
        } else {
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data tidak ditemukan'
            ));
        }

    }

    public function doconfirmattendance($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $transaction = $this->M_AgendaAttendance->read(' AND agenda_id = \'' . $json->agenda_id . '\' AND nik = \'' . $json->nik . '\' ')->row();
        header('Content-Type: application/json');
        switch ($json->type) {
            case "confirmstatus":
                try {
                    $this->db->trans_start();
                    $this->M_AgendaAttendance->update(array(
                        'confirm_status' => ($json->action == 'accept' ? 't' : 'f'),
                        'update_by' => trim($this->session->userdata('nik')),
                        'update_date' => date('Y-m-d H:i:s'),
                    ), array(
                        'agenda_id' => $agendaData->agenda_id,
                        'nik' => $transaction->nik,
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
                break;
            case "attendstatus":
                try {
                    $this->db->trans_start();
                    $this->M_AgendaAttendance->update(array(
                        'attend_status' => ($json->action == 'accept' ? 't' : 'f'),
                        'update_by' => trim($this->session->userdata('nik')),
                        'update_date' => date('Y-m-d H:i:s'),
                    ), array(
                        'agenda_id' => $agendaData->agenda_id,
                        'nik' => $transaction->nik,
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
                break;
        }
    }

    public function notificationpopup($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('agenda/M_NotificationRule', 'agenda/M_CounselingSession', 'master/M_Employee', 'agenda/M_Notifications', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'master/M_Branch'));
        header('Content-Type: application/json');
    }

    public function broadcast($param = null)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('agenda/M_NotificationRule', 'agenda/M_CounselingSession', 'master/M_Employee', 'agenda/M_Notifications', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'master/M_Branch'));
        $module = strtoupper(strtolower(strtok(basename(__FILE__), '.')));
        if (isset($json->nik)) {
            $filter = ' AND nik = \'' . $json->nik . '\' ';
        }
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $branch = $this->M_Branch->read(' AND TRIM(cdefault) = \'YES\' LIMIT 1 ')->row();
        header('Content-Type: application/json');
        if (!empty($transaction->participant_count) or $transaction->participant_count > 0) {
            try {
                $this->db->trans_start();
                foreach ($this->M_AgendaAttendance->read(' AND agenda_id = \'' . $transaction->agenda_id . '\' ' . (!is_null($filter) ? $filter : ''))->result() as $index => $agenda) {
                    switch ($transaction->status) {
                        case "S":
                            $notifications = array();
                            foreach ($this->M_NotificationRule->read(' AND active = TRUE AND status = \'' . $transaction->status . '\' AND module = \'' . strtolower($module) . '\' ')->result() as $index => $rule) {
                                $notif = array(
                                    'reference_id' => $agenda->agenda_id,
                                    'type' => $rule->type,
                                    'module' => $module,
                                    'subject' => 'SCHEDULE ' . $module,
                                    'action' => null,
                                    'status' => null,
                                );
                                switch ($rule->notified_to) {
                                    case "HRD":
                                        foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND statuskepegawaian <> \'KO\' ')->result() as $index => $hrd) {
                                            $notif['properties'] = json_encode(array(
                                                'type' => 'I.Z.A.2',
                                                'level' => 'hrd',
                                                'is_interactive' => TRUE,
                                            ));
                                            $notif['send_to'] = $hrd->nik;
                                            $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                            $data = array(
                                                'send_to' => $person->nmlengkap,
                                                'position' => $person->nmjabatan,
                                                'branchname' => $branch->branchname,
                                                'type' => 'Notifikasi',
                                                'status' => 'S',
                                                'statusText' => '',
                                                'transaction' => array(
                                                    'Kode_Agenda' => $agenda->agenda_id,
                                                    'Tipe_Agenda' => $transaction->agenda_type_name,
                                                    'Aplikasi' => 'HRMS',
                                                    'Nama_Agenda' => $transaction->agenda_name,
                                                    'Nama_Penyelenggara' => $transaction->organizer_name,
                                                    'Tanggal_Mulai' => $transaction->begin_date_reformat,
                                                    'Tanggal_Selesai' => $transaction->end_date_reformat,
                                                    'Lokasi' => $transaction->location,
                                                    'Link' => $transaction->link,
                                                )
                                            );
                                            if ($rule->type == 'wa') {
                                                $notif['content'] = $this->load->view('notification_template/event/whatsapp', $data, true);
                                            } else {
                                                $notif['content'] = $this->load->view('notification_template/event/email', $data, true);
                                            }
                                            array_push($notifications, $notif);
                                        }
                                        break;
                                    case "SUPERIOR":
                                        foreach (explode('.', $agenda->superiors) as $supperior) {
                                            $notif['properties'] = json_encode(array(
                                                'type' => 'I.Z.A.2',
                                                'level' => 'superior',
                                                'is_interactive' => TRUE,
                                            ));
                                            $notif['send_to'] = $supperior;
                                            $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                            $data = array(
                                                'send_to' => $person->nmlengkap,
                                                'position' => $person->nmjabatan,
                                                'branchname' => $branch->branchname,
                                                'type' => 'Notifikasi',
                                                'status' => 'S',
                                                'statusText' => '',
                                                'transaction' => array(
                                                    'Kode_Agenda' => $agenda->agenda_id,
                                                    'Tipe_Agenda' => $transaction->agenda_type_name,
                                                    'Aplikasi' => 'HRMS',
                                                    'Nama_Agenda' => $transaction->agenda_name,
                                                    'Nama_Penyelenggara' => $transaction->organizer_name,
                                                    'Tanggal_Mulai' => $transaction->begin_date_reformat,
                                                    'Tanggal_Selesai' => $transaction->end_date_reformat,
                                                    'Lokasi' => $transaction->location,
                                                    'Link' => $transaction->link,
                                                )
                                            );
                                            if ($rule->type == 'wa') {
                                                $notif['content'] = $this->load->view('notification_template/event/whatsapp', $data, true);
                                            } else {
                                                $notif['content'] = $this->load->view('notification_template/event/email', $data, true);
                                            }
                                            array_push($notifications, $notif);
                                        }
                                        break;
                                    case "EMPLOYEE":
                                        $notif['properties'] = json_encode(array(
                                            'type' => 'I.Z.A.2',
                                            'level' => 'employee',
                                            'is_interactive' => TRUE,
                                        ));
                                        $notif['send_to'] = $agenda->nik;
                                        $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                        $data = array(
                                            'send_to' => $person->nmlengkap,
                                            'position' => $person->nmjabatan,
                                            'branchname' => $branch->branchname,
                                            'type' => 'Undangan',
                                            'status' => 'S',
                                            'statusText' => 'Dijadwalkan',
                                            'transaction' => array(
                                                'Kode_Agenda' => $agenda->agenda_id,
                                                'Tipe_Agenda' => $transaction->agenda_type_name,
                                                'Aplikasi' => 'HRMS',
                                                'Nama_Agenda' => $transaction->agenda_name,
                                                'Nama_Penyelenggara' => $transaction->organizer_name,
                                                'Tanggal_Mulai' => $transaction->begin_date_reformat,
                                                'Tanggal_Selesai' => $transaction->end_date_reformat,
                                                'Lokasi' => $transaction->location,
                                                'Link' => $transaction->link,
                                            )
                                        );
                                        if ($rule->type == 'wa') {
                                            $notif['content'] = $this->load->view('notification_template/event/whatsapp', $data, true);
                                        } else {
                                            $notif['content'] = $this->load->view('notification_template/event/email', $data, true);
                                        }
                                        array_push($notifications, $notif);
                                        break;
                                }
                            }
//                            $countMessage = count($notifications);
                            // var_dump($notifications);
                            // die();
                            $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                            break;
                        case "R":
                            $notifications = array();
                            foreach ($this->M_NotificationRule->read('  AND active = TRUE AND status = \'' . $transaction->status . '\' AND module = \'' . strtolower($module) . '\' ')->result() as $index => $rule) {
                                $notif = array(
                                    'reference_id' => $agenda->agenda_id,
                                    'type' => $rule->type,
                                    'module' => $module,
                                    'subject' => 'RESCHEDULE ' . $module,
                                    'action' => null,
                                    'status' => null,
                                );
                                switch ($rule->notified_to) {
                                    case "HRD":
                                        foreach ($this->M_Employee->read(' AND bag_dept = \'OP\' AND subbag_dept = \'DPK\' AND statuskepegawaian <> \'KO\' ')->result() as $index => $hrd) {
                                            $notif['properties'] = json_encode(array(
                                                'type' => 'I.Z.A.2',
                                                'level' => 'hrd',
                                                'is_interactive' => true,
                                            ));
                                            $notif['send_to'] = $hrd->nik;
                                            $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                            $data = array(
                                                'send_to' => $person->nmlengkap,
                                                'position' => $person->nmjabatan,
                                                'branchname' => $branch->branchname,
                                                'type' => 'Notifikasi',
                                                'status' => 'R',
                                                'statusText' => '',
                                                'transaction' => array(
                                                    'Kode_Agenda' => $agenda->agenda_id,
                                                    'Tipe_Agenda' => $transaction->agenda_type_name,
                                                    'Aplikasi' => 'HRMS',
                                                    'Nama_Agenda' => $transaction->agenda_name,
                                                    'Nama_Penyelenggara' => $transaction->organizer_name,
                                                    'Tanggal_Mulai' => $transaction->begin_date_reformat,
                                                    'Tanggal_Selesai' => $transaction->end_date_reformat,
                                                    'Lokasi' => $transaction->location,
                                                    'Link' => $transaction->link,
                                                )
                                            );
                                            if ($rule->type == 'wa') {
                                                $notif['content'] = $this->load->view('notification_template/event/whatsapp', $data, true);
                                            } else {
                                                $notif['content'] = $this->load->view('notification_template/event/email', $data, true);
                                            }
                                            array_push($notifications, $notif);
                                        }
                                        break;
                                    case "SUPERIOR":
                                        foreach (explode('.', $agenda->superiors) as $superior) {
                                            $notif['properties'] = json_encode(array(
                                                'type' => 'I.Z.A.2',
                                                'level' => 'superior',
                                                'is_interactive' => true,
                                            ));
                                            $notif['send_to'] = $superior;
                                            $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                            $data = array(
                                                'send_to' => $person->nmlengkap,
                                                'position' => $person->nmjabatan,
                                                'branchname' => $branch->branchname,
                                                'type' => 'Notifikasi',
                                                'status' => 'R',
                                                'statusText' => '',
                                                'transaction' => array(
                                                    'Kode_Agenda' => $agenda->agenda_id,
                                                    'Tipe_Agenda' => $transaction->agenda_type_name,
                                                    'Aplikasi' => 'HRMS',
                                                    'Nama_Agenda' => $transaction->agenda_name,
                                                    'Nama_Penyelenggara' => $transaction->organizer_name,
                                                    'Tanggal_Mulai' => $transaction->begin_date_reformat,
                                                    'Tanggal_Selesai' => $transaction->end_date_reformat,
                                                    'Lokasi' => $transaction->location,
                                                    'Link' => $transaction->link,
                                                )
                                            );
                                            if ($rule->type == 'wa') {
                                                $notif['content'] = $this->load->view('notification_template/event/whatsapp', $data, true);
                                            } else {
                                                $notif['content'] = $this->load->view('notification_template/event/email', $data, true);
                                            }
                                            array_push($notifications, $notif);
                                        }
                                        break;
                                    case "EMPLOYEE":
                                        $notif['properties'] = json_encode(array(
                                            'type' => 'I.Z.A.2',
                                            'level' => 'employee',
                                            'is_interactive' => TRUE,
                                        ));
                                        $notif['send_to'] = $agenda->nik;
                                        $person = $this->M_Employee->read(' AND nik = \'' . $notif['send_to'] . '\' ')->row();
                                        $data = array(
                                            'send_to' => $person->nmlengkap,
                                            'position' => $person->nmjabatan,
                                            'branchname' => $branch->branchname,
                                            'type' => 'Undangan',
                                            'status' => 'R',
                                            'statusText' => 'Dijadwalkan ulang',
                                            'transaction' => array(
                                                'Kode_Agenda' => $agenda->agenda_id,
                                                'Tipe_Agenda' => $transaction->agenda_type_name,
                                                'Aplikasi' => 'HRMS',
                                                'Nama_Agenda' => $transaction->agenda_name,
                                                'Nama_Penyelenggara' => $transaction->organizer_name,
                                                'Tanggal_Mulai' => $transaction->begin_date_reformat,
                                                'Tanggal_Selesai' => $transaction->end_date_reformat,
                                                'Lokasi' => $transaction->location,
                                                'Link' => $transaction->link,
                                            )
                                        );
                                        if ($rule->type == 'wa') {
                                            $notif['content'] = $this->load->view('notification_template/event/whatsapp', $data, true);
                                        } else {
                                            $emailnotif = $this->load->view('notification_template/event/email', $data, true);
                                            $notif['content'] = pg_escape_string( $emailnotif);
                                        }
                                        array_push($notifications, $notif);
                                        break;
                                        
                                }
                            }
//                            $countMessage = count($notifications);
                            $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
                            // var_dump($notifications);
                            // exit;
                            break;
                    }
                }
            //     http_response_code(403);
            //    var_dump($notifications);die();
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    ob_start();
                    $this->load->library('../modules/Notifications/controllers/Whatsapp');
                    $whatsapp = new WhatsApp;
                    $whatsapp->handle('SBYNSA', $json->agenda_id);
                    $email= Modules::load('Api/Mailer');
                    $email->send_mail_agenda($json->agenda_id);
                    ob_clean();
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Pesan notifikasi telah dikirim'
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
                'message' => 'Peserta masih kosong',
            ));
        }

    }

    public function checkschedule($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('agenda/M_Agenda'));
        $scheduleData = $this->M_Agenda->getScheduleDetail($json->nik, $json->agenda_id)->result();
        $employeeData = $this->M_Agenda->employee_list_read(' AND nik = \'' . $json->nik . '\' ')->row();
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $data = array(
            'transaction' => $scheduleData,
            'agendaData' => $agendaData,
            'modalTitle' => 'Rincian Jadwal Kerja <b>' . $employeeData->nmlengkap . '</b>',
            'modalSize' => 'modal-md',
            'title' => 'Rincian Jadwal Kerja',
            'content' => 'agenda/event/modals/v_schedule',
        );
        $this->load->view($data['content'], $data);
    }

    public function participation($action, $param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $action = strtoupper($action);
        header('Content-Type: application/json');
        if ($action == 'JOIN') {
            try {
                $this->db->trans_start();
                $this->M_AgendaAttendance->tmp_create(array(
                    'agenda_id' => $json->agenda_id,
                    'nik' => $json->nik,
                    'status' => 'I',
                    'input_by' => trim($this->session->userdata('nik')),
                    'input_date' => date('Y-m-d H:i:s'),
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Data berhasil ditambahkan'
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
        if ($action == 'LEAVE') {
            try {
                $this->db->trans_start();
                $this->M_AgendaAttendance->tmp_delete(array(
                    'agenda_id' => $json->agenda_id,
                    'nik' => $json->nik,
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
    }

    public function setfilter($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('agenda/M_WorkHour'));
        $getShiftData = $this->M_WorkHour->get_shift()->result();
        $data = array(
            'getShiftData' => $getShiftData,
            'modalTitle' => 'Filter Karyawan',
            'modalSize' => 'modal-md',
            'content' => 'agenda/event/modals/v_filter',
        );
        $this->load->view($data['content'], $data);
    }

    public function alignschedulewithagenda($param)
    {
        header('Content-Type: application/json');
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance', 'agenda/M_WorkHour'));
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $beginHour = str_replace(':', '', $agendaData->begin_hour);
        $endHour = str_replace(':', '', $agendaData->end_hour);
        $formatBeginDate = date('Y-m-d', strtotime($agendaData->begin_date));
        $workidInclude = array();
        foreach ($this->M_WorkHour->read(' AND to_char(begin_time,\'HH24MI\')::INT BETWEEN \'' . $beginHour . '\'::INT AND \'' . $endHour . '\'::INT AND to_char(end_time,\'HH24MI\')::INT BETWEEN \'' . $beginHour . '\'::INT AND \'' . $endHour . '\'::INT ')->result() as $index => $item) {
            array_push($workidInclude, $item->workid);
        }
        $workidIncludeFormat = "'" . implode("','", $workidInclude) . "'";
        $transaction = $this->M_Agenda->employee_list_read(' AND employment_status <> \'KO\' AND agenda_id = \'' . $agendaData->agenda_id . '\' AND workdate = \'' . $formatBeginDate . '\' AND workid IN(' . $workidIncludeFormat . ')  AND nik NOT IN (SELECT nik FROM sc_tmp.agenda_attendance WHERE agenda_id = \'' . $agendaData->agenda_id . '\') ')->result();
        if (count($transaction) <= 0) {
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Karyawan sudah diikutsertakan'
            ));
            return;
        }
        try {
            $this->db->trans_start();
            foreach ($transaction as $index => $item) {
                $this->M_AgendaAttendance->tmp_create(array(
                    'agenda_id' => $item->agenda_id,
                    'nik' => $item->nik,
                    'status' => 'I',
                    'input_by' => trim($this->session->userdata('nik')),
                    'input_date' => date('Y-m-d H:i:s'),
                ));
            }
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data berhasil ditambahkan'
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

    public function checkattendance($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'master/M_Branch', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $data = array(
            'modalTitle' => 'Cek Kehadiran <b>' . $transaction->agenda_name . '</b>',
            'modalSize' => 'modal-lg',
            'title' => 'Cek Kehadiran',
            'content' => 'agenda/event/modals/v_check_attendance',
        );
        $actionArr = ($transaction->status == 'C' ? array('nik') : array('nik', 'empty', 'leave', 'join') );
        $participant = $this->datatablessp->datatable('table-participant', 'table table-striped table-bordered table-hover dataTable', true)
            ->columns('nik, nmlengkap, nmdept, nmsubdept, nmjabatan, agenda_id, attend_status_text, attend_status')
            ->addcolumn('no', 'no')
            ->addcolumn('join', '<button class="btn btn-xs btn-success pull-right mr-3 join" data-href="' . site_url('agenda/event/docheckattendance/accept/$1') . '" data-toggle="tooltip" title="Hadir"><i class="fa fa-sign-in"></i></button>', 'nik, agenda_id, confirm_join', true)
            ->addcolumn('leave', '<button class="btn btn-xs btn-danger pull-right mr-3 leave" data-href="' . site_url('agenda/event/docheckattendance/reject/$1') . '" data-toggle="tooltip" title="Tidak Hadir"><i class="fa fa-sign-out"></i></button>', 'nik, agenda_id, confirm_leave', true)
            ->addcolumn('empty', '<button class="btn btn-xs btn-github pull-right mr-3 empty" data-href="' . site_url('agenda/event/docheckattendance/empty/$1') . '" data-toggle="tooltip" title="Belum Konfirmasi"><i class="fa fa-times-circle-o"></i></button>', 'nik, agenda_id, confirm_leave', true)
            ->addcolumn('formatNik', '
              <input class="form-check-input pull-right largerCheckbox participate" style="" type="checkbox" id="inlineCheckbox1" value="$1">
            ', 'nik')
            ->querystring($this->M_AgendaAttendance->read_txt(' AND agenda_id = \'' . $transaction->agenda_id . '\'  '))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, $actionArr)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Kehadiran', 'attend_status', true, true, true, array('attend_status_text'))
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Subdepartemen', 'nmsubdept', true, true, true)
            ->header('Jabatan', 'nmjabatan', true, true, true);
        if ($this->input->post('tableid') == 'table-participant') {
            $participant->generateajax();
        }
        $data['participant'] = array(
            'title' => 'Peserta',
//            'count' => $this->M_Employee->read(' AND statuskepegawaian <> \'KO\' AND nik NOT IN (SELECT nik FROM sc_trx.agenda_attendance WHERE agenda_id = \''.$transaction->agenda_id.'\') ')->num_rows(),
            'generatetable' => $participant->generatetable('table-participant', false),
            'jquery' => $participant->jquery(1, 'table-participant', false),
        );
        $this->load->view($data['content'], $data);

    }

    public function docheckattendance($action, $param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $transaction = $this->M_AgendaAttendance->read(' AND agenda_id = \'' . $json->agenda_id . '\' AND nik = \'' . $json->nik . '\' ')->row();
        $action = strtolower($action);
        header('Content-Type: application/json');
        if ($transaction->confirm_status != 't') {
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Peserta tidak konfirmasi hadir'
            ));
            return;
        }
        if ($action == 'empty') {
            if (is_null($transaction->attend_status)) {
                http_response_code(400);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Sudah pernah dikonfirmasi'
                ));
                return;
            }
        } else {
            if (!is_null($transaction->attend_status)) {
                http_response_code(400);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Sudah pernah dikonfirmasi'
                ));
                return;
            }
        }
        try {
            $this->db->trans_start();
            $this->M_AgendaAttendance->update(array(
                'attend_status' => ($action == 'accept' ? 't' : ($action == 'reject' ? 'f' : null)),
                'update_by' => trim($this->session->userdata('nik')),
                'update_date' => date('Y-m-d H:i:s'),
            ), array(
                'agenda_id' => $agendaData->agenda_id,
                'nik' => $transaction->nik,
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

    public function checkconfirmation($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'master/M_Branch', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $data = array(
            'modalTitle' => 'Cek Konfirmasi <b>' . $transaction->agenda_name . '</b>',
            'modalSize' => 'modal-lg',
            'title' => 'Cek Kehadiran',
            'content' => 'agenda/event/modals/v_check_confirmation',
        );
        $actionArr = ($transaction->status == 'C' ? array('nik') : array('nik', 'empty', 'leave', 'join') );
        $participant = $this->datatablessp->datatable('table-participant', 'table table-striped table-bordered table-hover dataTable', true)
            ->columns('nik, nmlengkap, nmdept, nmsubdept, nmjabatan, agenda_id, confirm_status_text, confirm_status')
            ->addcolumn('no', 'no')
            ->addcolumn('join', '<button class="btn btn-xs btn-success pull-right mr-3 join" data-href="' . site_url('agenda/event/docheckconfirmation/accept/$1') . '" data-toggle="tooltip" title="Hadir"><i class="fa fa-sign-in"></i></button>', 'nik, agenda_id, confirm_join', true)
            ->addcolumn('leave', '<button class="btn btn-xs btn-danger pull-right mr-3 leave" data-href="' . site_url('agenda/event/docheckconfirmation/reject/$1') . '" data-toggle="tooltip" title="Tidak Hadir"><i class="fa fa-sign-out"></i></button>', 'nik, agenda_id, confirm_leave', true)
            ->addcolumn('empty', '<button class="btn btn-xs btn-github pull-right mr-3 empty" data-href="' . site_url('agenda/event/docheckconfirmation/empty/$1') . '" data-toggle="tooltip" title="Belum Konfirmasi"><i class="fa fa-times-circle-o"></i></button>', 'nik, agenda_id, confirm_leave', true)
            ->addcolumn('formatNik', '
              <input class="form-check-input pull-right largerCheckbox participate" style="" type="checkbox" id="inlineCheckbox1" value="$1">
            ', 'nik')
            ->querystring($this->M_AgendaAttendance->read_txt(' AND agenda_id = \'' . $transaction->agenda_id . '\'  '))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, $actionArr)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Konfirmasi', 'confirm_status', true, true, true, array('confirm_status_text'))
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Subdepartemen', 'nmsubdept', true, true, true)
            ->header('Jabatan', 'nmjabatan', true, true, true);
        if ($this->input->post('tableid') == 'table-participant') {
            $participant->generateajax();
        }
        $data['participant'] = array(
            'title' => 'Peserta',
//            'count' => $this->M_Employee->read(' AND statuskepegawaian <> \'KO\' AND nik NOT IN (SELECT nik FROM sc_trx.agenda_attendance WHERE agenda_id = \''.$transaction->agenda_id.'\') ')->num_rows(),
            'generatetable' => $participant->generatetable('table-participant', false),
            'jquery' => $participant->jquery(1, 'table-participant', false),
        );
        $this->load->view($data['content'], $data);

    }

    public function docheckconfirmation($action, $param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $transaction = $this->M_AgendaAttendance->read(' AND agenda_id = \'' . $json->agenda_id . '\' AND nik = \'' . $json->nik . '\' ')->row();
        $action = strtolower($action);
        header('Content-Type: application/json');
        if ($action == 'empty') {
            if (is_null($transaction->confirm_status)) {
                http_response_code(400);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Sudah pernah dikonfirmasi'
                ));
                return;
            }
        } else {
            if (!is_null($transaction->confirm_status)) {
                http_response_code(400);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Sudah pernah dikonfirmasi'
                ));
                return;
            }
        }
        try {
            $this->db->trans_start();
            $this->M_AgendaAttendance->update(array(
                'confirm_status' => ($action == 'accept' ? 't' : ($action == 'reject' ? 'f' : null)),
                'update_by' => trim($this->session->userdata('nik')),
                'update_date' => date('Y-m-d H:i:s'),
            ), array(
                'agenda_id' => $agendaData->agenda_id,
                'nik' => $transaction->nik,
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

    public function docancel($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $userhr = trim($this->q_user_checkhr()->row()->bag_dept) == 'HA';
//        $transaction->status = 'C';
        header('Content-Type: application/json');
        if ($userhr){
            if ($transaction->status == 'C') {
                http_response_code(403);
                echo json_encode(array(
                    'data' => array(),
                    'message' => "Agenda <b>$transaction->agenda_name</b> sudah pernah dibatalkan",
                ));
            }else{
                if (strtotime($transaction->end_date) < strtotime(date('Y-m-d H:i:s'))) {
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => "Agenda <b>$transaction->agenda_name</b> sudah berlalu tidak bisa dibatalkan",
                    ));
                }else{
                    try {
                        $this->db->trans_start();
                        $reason = $this->input->post('reason');
                        $this->M_Agenda->update(
                            array(
                                'cancel_by' => trim($this->session->userdata('nik')),
                                'cancel_date' => date('Y-m-d H:i:s'),
                                'cancel_reason' => $reason,
                                'status' => 'C',
                            ),
                            array(
                                'agenda_id' => $transaction->agenda_id
                            )
                        );  

                        //hapus event google calendar                        
                        $this->delete_google_calendar($transaction->calendar_id);    

                        $this->db->trans_complete();
                        if ($this->db->trans_status()) {
                            $this->db->trans_commit();
                            $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
                            if ((int)$transaction->participant_count > 0) {
                                $message = "Pemberitahuan: \n\nNama Agenda: $transaction->agenda_name \nStatus : $transaction->status_text. \n\n Alasan pembatalan : \n$reason ";
                                ob_start();
                                $email= Modules::load('Api/Mailer');
                                $email->send_cancel_mail_agenda($json->agenda_id);
                                ob_clean();                  
                                foreach ($this->M_AgendaAttendance->read(' AND agenda_id = \''.$transaction->agenda_id.'\' ')->result() as $index => $item) {
                                    $outboxFor = $item->employee_phone;
                                    ob_start();
                                    //$this->load->library('../modules/Api/controllers/Whatsapp');
                                    //$whatsapp = new Whatsapp;
                                    $whatsapp = Modules::load('Api/Whatsapp');
                                    $whatsapp->sendResponseMessage(array(
                                        'documentid' => $item->agenda_id,
                                        'message' => $message,
                                    ), $outboxFor);
                        
                                    //var_dump($whatsapp);exit;
                                    ob_clean();
                                }
                            }
                            //var_dump($whatsapp);die();
                            http_response_code(200);
                            echo json_encode(array(
                                'data' => array(),
                                'message' => 'Agenda berhasil dibatalkan'
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
        }else{
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => "Anda tidak memiliki akses",
            ));
        }

    }

    public function q_user_checkhr(){
        $nik=$this->session->userdata('nik');
        return $this->db->query("select bag_dept from sc_mst.karyawan where nik='$nik'");
    }

     public function addojt($param)
    {
        $this->load->library(array('datatablessp'));
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'master/M_Branch', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $data = array(
            'modalTitle' => 'pilih karyawan ojt <b>' . $transaction->agenda_name . '</b>',
            'modalSize' => 'modal-lg',
            'title' => 'pilih karyawan ojt',
            'content' => 'agenda/event/modals/v_add_ojt',
        );
        $actionArr = ($transaction->status == 'C' ? array('nik') : array('nik', 'empty','ojt') );
        $participant = $this->datatablessp->datatable('table-participant', 'table table-striped table-bordered table-hover dataTable', true)
            ->columns('nik, nmlengkap, nmdept, nmsubdept, nmjabatan, agenda_id, ojt_status_text, ojt_status')
            ->addcolumn('no', 'no')
            ->addcolumn('ojt', '<button class="btn btn-xs btn-success pull-right mr-3 join" data-href="' . site_url('agenda/event/doaddojt/ojt/$1') . '" data-toggle="tooltip" title="konfirmasi karyawan ojt"><i class="fa fa-sign-in"></i></button>', 'nik, agenda_id, confirm_ojt', true)
            ->addcolumn('empty', '<button class="btn btn-xs btn-github pull-right mr-3 empty" data-href="' . site_url('agenda/event/doaddojt/empty/$1') . '" data-toggle="tooltip" title="Belum Konfirmasi"><i class="fa fa-times-circle-o"></i></button>', 'nik, agenda_id, confirm_leave', true)
            ->addcolumn('formatNik', '
              <input class="form-check-input pull-right largerCheckbox participate" style="" type="checkbox" id="inlineCheckbox1" value="$1">
            ', 'nik')
            ->querystring($this->M_AgendaAttendance->read_txt(' AND agenda_id = \'' . $transaction->agenda_id . '\'  '))
            ->header('No.', 'no', false, false, true)
            ->header('Nik', 'nik', true, true, true, $actionArr)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Ojt', 'ojt_status', true, true, true, array('ojt_status_text'))
            ->header('Bagian', 'nmdept', true, true, true)
            ->header('Subdepartemen', 'nmsubdept', true, true, true)
            ->header('Jabatan', 'nmjabatan', true, true, true);
        if ($this->input->post('tableid') == 'table-participant') {
            $participant->generateajax();
        }
        $data['participant'] = array(
            'title' => 'Peserta',
//            'count' => $this->M_Employee->read(' AND statuskepegawaian <> \'KO\' AND nik NOT IN (SELECT nik FROM sc_trx.agenda_attendance WHERE agenda_id = \''.$transaction->agenda_id.'\') ')->num_rows(),
            'generatetable' => $participant->generatetable('table-participant', false),
            'jquery' => $participant->jquery(1, 'table-participant', false),
        );
        $this->load->view($data['content'], $data);

    }

    public function doaddojt($action, $param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'master/M_Branch', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $agendaData = $this->M_Agenda->read(' AND agenda_id = \'' . $json->agenda_id . '\' ')->row();
        $transaction = $this->M_AgendaAttendance->read(" AND agenda_id = '" . $json->agenda_id . "' AND nik = '" . $json->nik . "' and ojt_status = 't' ")->row();
        $qcheckojt = $this->db->query("select * from sc_trx.agenda_attendance where agenda_id = '" . $json->agenda_id . "' and ojt_status = 't' ")->row();
        $checkojt = $qcheckojt !== null ? true : false;
        $action = strtolower($action);
        header('Content-Type: application/json');
        if ($checkojt === true && (is_null($transaction->ojt_status))) {
            http_response_code(400);
            echo json_encode(array(
            'data' => array(),
            'message' => 'Karyawan OJT sudah ditentukan'
            ));
            return;
        }
        if ($action == 'empty') {
            if (is_null($transaction->ojt_status)) {
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Sudah pernah dikonfirmasi'
            ));
            return;
            }
        } else {
            if (!is_null($transaction->ojt_status)) {
            http_response_code(400);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Sudah pernah dikonfirmasi'
            ));
            return;
            }
        }
        try {
            $this->db->trans_start();
            // Debug: Show the update data and where clause
            $updateData = array(
                'ojt_status' => ($action == 'ojt' ? true : null),
                'update_by' => trim($this->session->userdata('nik')),
                'update_date' => date('Y-m-d H:i:s'),
            );
            $whereClause = array(
                'agenda_id' => $agendaData->agenda_id,
                'nik' => $json->nik,
            );
            // var_dump('Update Data:', $updateData);
            // var_dump('Where Clause:', $whereClause);
            // exit;

            $this->M_AgendaAttendance->update($updateData, $whereClause);
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

    public function patch_utils() {
        $agenda_id = $this->input->get('agenda_id');
        $calendar_id = $this->input->get('calendar_id');

        if (empty($agenda_id) || empty($calendar_id)) {
            http_response_code(400);
            echo json_encode(array(
            'data' => array(),
            'message' => 'Agenda ID and Calendar ID cannot be null'
            ));
            return;
        }

        $this->load->model(array('agenda/M_AgendaAttendance', 'M_Notifications'));

        // Ambil data agenda dari DB untuk summary, location, description, start, end
        $agenda = $this->db->query("SELECT agenda_name, location, link, begin_date, end_date FROM sc_trx.agenda WHERE agenda_id = ?", array($agenda_id))->row();
        $room = $this->db->query("select room_name from sc_mst.room where room_id = ?", array($agenda->location))->row();
        $location = $room ? $room->room_name : null;


        $event = array(
            'summary'     => $agenda->agenda_name,
            'location'    => $location,
            'description' => $agenda->link,
            'start' => array(
            'dateTime' => $this->format_datetime_gcalendar($agenda->begin_date),
            'timeZone' => 'Asia/Jakarta'
            ),
            'end' => array(
            'dateTime' =>  $this->format_datetime_gcalendar($agenda->end_date),
            'timeZone' => 'Asia/Jakarta'
            ),
            'attendees' => array()
        );
        $notifications = array();

        // Ambil daftar attendee dari DB
        $attendances = $this->M_AgendaAttendance->read_email(" AND agenda_id = '$agenda_id'")->result();
        foreach ($attendances as $agenda) {
            if (!empty($agenda->email_calendar && $agenda->email_calendar != '')) {
                $event['attendees'][] = array('email' => trim(strtolower($agenda->email_calendar)));

                $notifications[] = array(
                    'reference_id' => $agenda_id,
                    'type' => 'google_calendar',
                    'module' => 'EVENT',
                    'subject' => 'SCHEDULE EVENT',
                    'action' => null,
                    'status' => null,
                    'send_to' => $agenda->nik,
                    'input_by' => 'SYSTEM',
                    'input_date' => date('Y-m-d H:i:s'),
                    'content' => trim(strtolower($agenda->email_calendar))
                );
            }
        }

            //  var_dump($event);
            //  exit;

        if (!empty($notifications)) {
            $this->M_Notifications->createBatch(array_unique($notifications, SORT_REGULAR));
        }

        // Lakukan PATCH ke Google Calendar
        $result = $this->patch_google_calendar($event, $calendar_id);
        $responseObj = json_decode($result);

        $emails = [];

        if (json_last_error() !== JSON_ERROR_NONE || empty($responseObj)) {
            log_message('error', 'Google Calendar response invalid: ' . $result);
            return show_error('Gagal update Google Calendar. Respons tidak valid.', 500);
        }

        // Ambil semua email yang berhasil ditambahkan
        if (!empty($responseObj->attendees) && is_array($responseObj->attendees)) {
            foreach ($responseObj->attendees as $attendee) {
                if (!empty($attendee->email)) {
                    $emails[] = trim($attendee->email);
                }
            }
        }

        // Update status notifikasi
        if (!empty($emails)) {
            $escaped_emails = array_map(function ($e) {
                return $this->db->escape($e);
            }, $emails);

            $sql = "
                UPDATE sc_trx.notifications
                SET status = 'send to calendar'
                WHERE reference_id = ?
                AND type = 'google_calendar'
                AND trim(content) IN (" . implode(',', $escaped_emails) . ")
            ";

            $this->db->query($sql, array($agenda_id));
        }



    http_response_code(200);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Pesan notifikasi telah dikirim'
            ));

        
    }


    public function post_google_calendar($agendaname, $startdate, $enddate, $location, $link) {
        $auth = modules::load('api/Auth'); 

        // var_dump($agendaname, $startdate, $enddate, $description, $link);
        // exit;

        // ✅ Ambil token yang valid
        $access_token = $auth->option['GO:ACCESS-TOKEN']['value1'];
        if (!$access_token) {
            $access_token = $auth->get_token_valid(); // Ambil token valid jika tidak ada
            if (!$access_token) {
                echo "Gagal ambil token yang valid.";
                return;
            }
        }

        // Lanjut kirim event ke Google Calendar
        $event = array(
            'summary'     => $agendaname,
            'location'  => $location,
            'description' => $link,
            'start' => array(
                'dateTime' => $this->format_datetime_gcalendar($startdate),
                'timeZone' => 'Asia/Jakarta'
            ),
            'end' => array(
                'dateTime' => $this->format_datetime_gcalendar($enddate),
                'timeZone' => 'Asia/Jakarta'
            ),
            'reminders' => array(
                'useDefault' => false,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => isset($auth->option['GO:EMAILREMIND']['value1']) ? intval($auth->option['GO:EMAILREMIND']['value1']) : 30),
                    array('method' => 'popup', 'minutes' => isset($auth->option['GO:POPUPREMIND']['value1']) ? intval($auth->option['GO:POPUPREMIND']['value1']) : 10)
                )
            )
        );

        $ch = curl_init('https://www.googleapis.com/calendar/v3/calendars/primary/events');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($event));
        $response = curl_exec($ch);

        // Check if the response indicates an invalid token
        if (strpos($response, 'Invalid Credentials') !== false || strpos($response, 'invalid_grant') !== false) {
            $access_token = $auth->get_token_valid(); // Get a new valid token
            if ($access_token) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ));
            $response = curl_exec($ch); // Retry the request with the new token
            }
        }

        curl_close($ch);

        return $response;
    }

    public function patch_google_calendar($event,$eventId) {
        $auth = modules::load('api/Auth'); // Load library atau sesuai struktur kamu

        // ✅ Ambil token yang valid
        $access_token = $auth->option['GO:ACCESS-TOKEN']['value1'];
        if (!$access_token) {
            $access_token = $auth->get_token_valid(); 
            if (!$access_token) {
                echo "Gagal ambil token yang valid.";
                return;
            }
        }
        
        $url = 'https://www.googleapis.com/calendar/v3/calendars/primary/events/' . $eventId . '?sendUpdates=all';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // PATCH untuk update
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($event));

        $response = curl_exec($ch);

        // Cek token invalid, coba ulangi
        if (strpos($response, 'Invalid Credentials') !== false || strpos($response, 'invalid_grant') !== false) {
            $access_token = $auth->get_token_valid();
            if ($access_token) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $access_token,
                    'Content-Type: application/json'
                ));
                $response = curl_exec($ch);
            }
        }

        curl_close($ch);
        return $response;
    }

    public function delete_google_calendar($eventId) {
        $auth = modules::load('api/Auth'); 

        // ✅ Ambil token akses yang valid
        $access_token = $auth->option['GO:ACCESS-TOKEN']['value1'];
        if (!$access_token) {
            $access_token = $auth->get_token_valid();
            if (!$access_token) {
                echo "Gagal ambil token yang valid.";
                return;
            }
        }

        $url = 'https://www.googleapis.com/calendar/v3/calendars/primary/events/' . $eventId;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // DELETE untuk hapus
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token
        ));

        $response = curl_exec($ch);

        // Jika token invalid, coba refresh
        if (strpos($response, 'Invalid Credentials') !== false || strpos($response, 'invalid_grant') !== false) {
            $access_token = $auth->get_token_valid();
            if ($access_token) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $access_token
                ));
                $response = curl_exec($ch);
            }
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Tampilkan hasil
        if ($http_code == 204) {
            //echo "Event berhasil dihapus.";
            return true;
        } else {
            echo "Gagal menghapus event. Response: " . $response;
            return $response;
        }
    }

    public function get_google_calendar($eventId) {
        $auth = modules::load('api/Auth'); 

        // ✅ Ambil token akses yang valid
        $access_token = $auth->option['GO:ACCESS-TOKEN']['value1'];
        if (!$access_token) {
            $access_token = $auth->get_token_valid();
            if (!$access_token) {
                echo "Gagal ambil token yang valid.";
                return;
            }
        }

        $url = 'https://www.googleapis.com/calendar/v3/calendars/primary/events/' . $eventId;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token
        ));

        $response = curl_exec($ch);

        // Cek token invalid
        if (strpos($response, 'Invalid Credentials') !== false || strpos($response, 'invalid_grant') !== false) {
            $access_token = $auth->get_token_valid();
            if ($access_token) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $access_token
                ));
                $response = curl_exec($ch);
            }
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            // Event ditemukan
            echo "Detail Event:<br>";
            echo "<pre>" . print_r(json_decode($response, true), true) . "</pre>";
        } else {
            echo "Gagal mengambil detail event. HTTP Code: $http_code<br>Response: $response";
        }
    }

    public function format_datetime_gcalendar($datetimeStr, $timezone = 'Asia/Jakarta') {
        $tz = new DateTimeZone($timezone);
        $dt = DateTime::createFromFormat('d-m-Y H:i:s', $datetimeStr, $tz);
        
        if ($dt === false) {
            return null; // Gagal parsing
        }

        // Format RFC3339 (Y-m-dTH:i:sP) → Contoh: 2025-06-20T11:46:25+07:00
        return $dt->format('Y-m-d\TH:i:sP');
    }

    public function test_google($param){
        $auth = modules::load('api/Auth'); 
        

        if ($param == 'email'){
         var_dump(intval($auth->option['GO:EMAILREMIND']['value1']));
         exit;
        }
        else if ($param == 'pop'){
         echo $auth->option['GO:POPUPREMIND']['value1'];
        }
        else if ($param == 'remind'){
         echo $this->option['GO:EMAILREMIND']['value1'];
        }


    }


}
