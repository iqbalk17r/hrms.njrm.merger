<?php

class Skperingatan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['master/m_akses', 'm_skperingatan', 'm_sberitaacara' , 'master/m_trxerror']);
        $this->load->library(['form_validation', 'template', 'upload', 'pdf', 'fiky_encryption', 'Fiky_report']);
        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "Surat Peringatan";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $nikhr = $data['nikhr'] = trim($this->db->query("select nik from sc_mst.karyawan where lvl_jabatan = 'C' and jabatan = 'HR02'")
                                ->row()->nik);
        $userinfo=$this->m_akses->q_user_check()->row_array();
        $paramerror = " AND userid = '$nik' AND modul = 'I.T.B.27'";
        $dtlerror = $this->m_trxerror->q_trxerror($paramerror)->row_array();

        $errordesc = isset($dtlerror['description']) ? trim($dtlerror['description']) : '';
        $nomorakhir1 = isset($dtlerror['nomorakhir1']) ? trim($dtlerror['nomorakhir1']) : '';
        $errorcode = isset($dtlerror['errorcode']) ? trim($dtlerror['errorcode']) : '';

        $data['message'] = "";
        if ($dtlerror) {
            if ($errorcode == 0) {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH: $nomorakhir1</div>";
            } else if ($errorcode == 1) {
                $data['message'] = "<div class='alert alert-success'>DOKUMEN TELAH DISETUJUI: $nomorakhir1</div>";
            } else if ($errorcode == 2) {
                $data['message'] = "<div class='alert alert-danger'>DOKUMEN TELAH DIBATALKAN: $nomorakhir1</div>";
            } else if ($errorcode == 3) {
                $data['message'] = "<div class='alert alert-warning'>DOKUMEN SEDANG DIPROSES: $nomorakhir1</div>";
            } else if ($errordesc <> '') {
                $data['message'] = "<div class='alert alert-warning'>$errordesc</div>";
            }
        }
        $this->showUnfinish();

        $paramtrx = "";
        if ($data['userhr'] == $nik) {
            $paramtrx .= " AND TRUE";
        }else{
            $paramtrx .= " AND (nik = '$nik' OR superiors ilike '%$nik%' OR inputby = '$nik') ";
        }
        $data['tglrange'] = $this->input->post('tglrange');
        if ($data['tglrange']) {
            $tgl = explode(" - ", $this->input->post('tglrange'));
            $paramtrx .= " AND docdate::DATE BETWEEN '" . date("Y-m-d", strtotime($tgl[0])) . "'::DATE AND '" . date("Y-m-d", strtotime($tgl[1])) . "'::DATE";
        }
        $data['listtrx'] = $this->m_skperingatan->read_trxskperingatan($paramtrx)->result();

        $this->template->display('trans/skperingatan/v_skperingatan', $data);
        $pterror = " AND userid = '$nik'";
        $this->m_trxerror->q_deltrxerror($pterror);
    }

    function detail()
    {
        $this->load->model(array('M_Employee'));
        $data['title'] = "Detail Surat Peringatan";
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if ($docno == "") {
            redirect('trans/skperingatan');
        }

        $param = " AND COALESCE(docno, '') = '$docno'";
        $data['dtl'] = $this->m_skperingatan->read_trxskperingatan($param)->row();
        $param_karyawan = " AND TRIM(nik) = '" . trim($data['dtl']->nik) . "'";
        $data['employee'] = $this->M_Employee->q_mst_read_where($param_karyawan)->row();
        $this->template->display('trans/skperingatan/v_detail_skperingatan', $data);
    }

    function input()
    {
        $data['title'] = "Input Surat Peringatan";
        $nik = trim($this->session->userdata('nik'));

        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();

        if (!$dtl) {
            $info = [
                'docno' => $nik,
                'docdate' => date('Y-m-d H:i:s'),
                'startdate' => date('Y-m-d'),
                'enddate' => date('Y-m-d'),
                'status' => 'I',
                'inputby' => $nik,
                'inputdate' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('sc_tmp.sk_peringatan', $info);
        }

        $data['type'] = 'INPUT';
        $data['dtl'] = $this->m_skperingatan->read_tmpskperingatan($param)->row();
        $fromTransaction = FALSE;
        $param_karyawan = ' AND statuskepegawaian <> \'KO\' ';
        if ($fromTransaction) {
            $param_karyawan = " AND nik IN (
                SELECT nik
                FROM sc_trx.berita_acara
                WHERE status = 'P' AND peringatan = 'y'
                AND docno NOT IN (SELECT docref FROM sc_trx.sk_peringatan WHERE status != 'X')
            )";
        }

        $data['list_karyawan'] = $this->m_skperingatan->q_lv_m_karyawan($param_karyawan)->result_array();

        $this->template->display('trans/skperingatan/v_input_skperingatan', $data);
    }

    function edit()
    {
        $data['title'] = "Edit Surat Peringatan";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if ($docno == "") {
            redirect('trans/skperingatan');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();
        if ($dtl) {
            $this->db->where('userid', $nik);
            $this->db->where('modul', 'I.T.B.27');
            $this->db->delete('sc_mst.trxerror');
            $infotrxerror = [
                'userid' => $nik,
                'errorcode' => 3,
                'nomorakhir1' => $docno,
                'nomorakhir2' => '',
                'modul' => 'I.T.B.27'
            ];
            $this->db->insert('sc_mst.trxerror', $infotrxerror);
            redirect('trans/skperingatan');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'E',
                'updateby' => $nik,
                'updatedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if ($this->db->update('sc_trx.sk_peringatan', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'EDIT';
                $data['dtl'] = $this->m_skperingatan->read_tmpskperingatan($param)->row();
                $fromTransaction = FALSE;
                $param_karyawan = ' AND statuskepegawaian <> \'KO\' ';
                if ($fromTransaction) {
                    $param_karyawan = " AND nik IN (
                        SELECT nik
                        FROM sc_trx.berita_acara
                        WHERE status = 'P' AND peringatan = 'y'
                        AND docno NOT IN (SELECT docref FROM sc_trx.sk_peringatan WHERE status != 'X')
                    )";
                }
                $data['list_karyawan'] = $this->m_skperingatan->q_lv_m_karyawan($param_karyawan)->result_array();

                $this->template->display('trans/skperingatan/v_input_skperingatan', $data);
            }
        }
    }

    function atasan()
    {
        $data['title'] = "Approval Surat Peringatan";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if ($docno == "") {
            redirect('trans/skperingatan');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();
        if ($dtl) {
            $this->db->where('userid', $nik);
            $this->db->where('modul', 'I.T.C.1');
            $this->db->delete('sc_mst.trxerror');
            $infotrxerror = [
                'userid' => $nik,
                'errorcode' => 3,
                'nomorakhir1' => $docno,
                'nomorakhir2' => '',
                'modul' => 'I.T.C.1'
            ];
            $this->db->insert('sc_mst.trxerror', $infotrxerror);
            redirect('trans/skperingatan');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'AP',
                'approveby' => $nik,
                'approvedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if ($this->db->update('sc_trx.sk_peringatan', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'APRA';
                $data['dtl'] = $this->m_skperingatan->read_tmpskperingatan($param)->row();
                $param_karyawan = " AND nik = '" . $data['dtl']->nik . "'";
                $data['list_karyawan'] = $this->m_skperingatan->q_lv_m_karyawan($param_karyawan)->result_array();

                $this->template->display('trans/skperingatan/v_approval_skperingatan', $data);
            }
        }
    }

    function hrd()
    {
        $data['title'] = "Approval Surat Peringatan";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if ($docno == "") {
            redirect('trans/skperingatan');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();
        if ($dtl) {
            $this->db->where('userid', $nik);
            $this->db->where('modul', 'I.T.C.1');
            $this->db->delete('sc_mst.trxerror');
            $infotrxerror = [
                'userid' => $nik,
                'errorcode' => 3,
                'nomorakhir1' => $docno,
                'nomorakhir2' => '',
                'modul' => 'I.T.C.1'
            ];
            $this->db->insert('sc_mst.trxerror', $infotrxerror);
            redirect('trans/skperingatan');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'BP',
                'approveby' => $nik,
                'approvedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if ($this->db->update('sc_trx.sk_peringatan', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'APRA';
                $data['dtl'] = $this->m_skperingatan->read_tmpskperingatan($param)->row();
                $param_karyawan = " AND nik = '" . $data['dtl']->nik . "'";
                $data['list_karyawan'] = $this->m_skperingatan->q_lv_m_karyawan($param_karyawan)->result_array();

                $this->template->display('trans/skperingatan/v_approval_skperingatanhr', $data);
            }
        }
    }

    function saveEntry()
    {
        $nik = trim($this->session->userdata('nik'));
        $submit = trim($this->input->post('submit'));
        if (in_array(trim($this->input->post('type')), ["INPUT", "EDIT"])) {
            $this->load->model('master/M_ReminderLetter');
            $docno = $this->input->post('tindakan');
            $startdate = $this->input->post('startdate');
            $startdate = date('Y-m-d', strtotime($startdate));
            $master = $this->M_ReminderLetter->q_transaction_read_where(' AND docno = \'' . $docno . '\' ')->row();
            $finishdate = $this->M_ReminderLetter->find($startdate, $master->period_value, $master->time_unit);
            $info = [
                'nik' => trim($this->input->post('nik')),
                'startdate' => trim($startdate),
                'enddate' => trim($finishdate->modifydate),
                'tindakan' => trim($this->input->post('tindakan')),
                'docref' => trim($this->input->post('docref')),
                'description' => trim($this->input->post('description')),
                'solusi' => trim($this->input->post('solusi')),
                'status' => 'B'
            ];
            $path = "./assets/files/skperingatan";
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $fileName = $_FILES['att_name']['name'];
            if (isset($fileName) && !is_null($fileName) && $fileName != "") {
                $config['upload_path'] = $path;
                $config['file_name'] = $fileName;
                $config['allowed_types'] = '*';
                $config['max_size'] = 20000;
                $config['encrypt_name'] = true;

                $this->upload->initialize($config);
                $this->upload->do_upload('att_name');
                $fileData = $this->upload->data();

                $info['att_name'] = $fileData['file_name'];
                $info['att_dir'] = $path . '/' . $fileData['file_name'];

                if (trim($this->input->post('type')) == "EDIT") {
                    $param = " AND COALESCE(docno, '') = '$nik'";
                    $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();
                    @unlink($dtl->att_dir);
                }
            }
        } else if (trim($this->input->post('type')) == "APRA") {
            if ($submit == "setuju") {
                $info = [
                    'status' => "B"
                ];
            } else if ($submit == "batal") {
                $info = [
                    'status' => "X",
                    'approveby' => null,
                    'approvedate' => null,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
        }
        $this->db->where('docno', trim($this->input->post('docno')));
        if ($this->db->update('sc_tmp.sk_peringatan', $info)) {
            redirect('trans/skperingatan');
        }
    }

    
    function saveEntryhr()
    {
        $nik = trim($this->session->userdata('nik'));
        $submit = trim($this->input->post('submit'));
        if (in_array(trim($this->input->post('type')), ["INPUT", "EDIT"])) {
            $this->load->model('master/M_ReminderLetter');
            $docno = $this->input->post('tindakan');
            $startdate = $this->input->post('startdate');
            $startdate = date('Y-m-d', strtotime($startdate));
            $master = $this->M_ReminderLetter->q_transaction_read_where(' AND docno = \'' . $docno . '\' ')->row();
            $finishdate = $this->M_ReminderLetter->find($startdate, $master->period_value, $master->time_unit);
            $info = [
                'nik' => trim($this->input->post('nik')),
                'startdate' => trim($startdate),
                'enddate' => trim($finishdate->modifydate),
                'tindakan' => trim($this->input->post('tindakan')),
                'docref' => trim($this->input->post('docref')),
                'description' => trim($this->input->post('description')),
                'solusi' => trim($this->input->post('solusi')),
                'status' => 'A'
            ];
            $path = "./assets/files/skperingatan";
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $fileName = $_FILES['att_name']['name'];
            if (isset($fileName) && !is_null($fileName) && $fileName != "") {
                $config['upload_path'] = $path;
                $config['file_name'] = $fileName;
                $config['allowed_types'] = '*';
                $config['max_size'] = 20000;
                $config['encrypt_name'] = true;

                $this->upload->initialize($config);
                $this->upload->do_upload('att_name');
                $fileData = $this->upload->data();

                $info['att_name'] = $fileData['file_name'];
                $info['att_dir'] = $path . '/' . $fileData['file_name'];

                if (trim($this->input->post('type')) == "EDIT") {
                    $param = " AND COALESCE(docno, '') = '$nik'";
                    $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();
                    @unlink($dtl->att_dir);
                }
            }
        } else if (trim($this->input->post('type')) == "APRA") {
            if ($submit == "setuju") {
                $info = [
                    'status' => "P"
                ];
            } else if ($submit == "batal") {
                $info = [
                    'status' => "X",
                    'approveby' => null,
                    'approvedate' => null,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
        }
        $this->db->where('docno', trim($this->input->post('docno')));
        if ($this->db->update('sc_tmp.sk_peringatan', $info)) {
            redirect('trans/skperingatan');
        }
    }

    function clearEntry()
    {
        $nik = trim($this->session->userdata('nik'));
        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();

        $this->db->where('docno', $nik);
        if ($this->db->delete('sc_tmp.sk_peringatan')) {
            if (trim($dtl->status) == "E") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'A',
                    'updateby' => null,
                    'updatedate' => null
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.sk_peringatan', $info);
            } else if (trim($dtl->status) == "AP") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'A',
                    'approveby' => null,
                    'approvedate' => null
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.sk_peringatan', $info);
            } else if (trim($dtl->status) == "BP") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'B',
                    'approveby' => null,
                    'approvedate' => null
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.sk_peringatan', $info);
            }
            
            redirect('trans/skperingatan');
        }
    }

    function showUnfinish()
    {
        $nik = trim($this->session->userdata('nik'));
        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_skperingatan->read_tmpskperingatan($param)->row();
        if (trim($dtl->status) == "I") {
            $this->clearEntry();
        } else if (trim($dtl->status) == "E") {
            redirect("trans/skperingatan/edit?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        } else if (trim($dtl->status) == "A") {
            redirect("trans/skperingatan/atasan?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        }
    }

    function get_tindakan()
    {
        $docno = $this->input->post('docno');
        $nik = $this->input->post('nik');
        $bypassAction = TRUE;
        $param_tindakan = '';
        if (!$bypassAction){
            $param_tindakan = " AND docno IN (
                SELECT tindakan
                FROM sc_trx.berita_acara
                WHERE nik = '$nik' AND status = 'P' AND peringatan = 'y'
                AND docno NOT IN (SELECT docref FROM sc_trx.sk_peringatan WHERE status != 'X' AND docno != '$docno')
            )";
        }
        echo json_encode($this->m_skperingatan->q_list_master_tindakan($param_tindakan)->result());
    }

    function get_docref()
    {
        $docno = $this->input->post('docno');
        $nik = $this->input->post('nik');
        $tindakan = $this->input->post('tindakan');
        $param_docref = " AND nik = '$nik' AND tindakan = '$tindakan'";
        $param_skp = " AND docno != '$docno'";
        echo json_encode($this->m_skperingatan->q_list_docref($param_docref, $param_skp)->result());
    }

    
    function getBeritaAcaraOnNodoc(){
        $docno = $this->input->post('docno');
        //$param = " AND docno = '$docno'";
       // $param = " AND docno = '$docno'";
        $data = $this->m_sberitaacara->read_trxberitaacara($param)->result();
        $test = $this->db->query('select * from sc_trx.berita_acara')->result();
        echo json_encode($test);
    }

    function get_enddate()
    {
        $this->load->model('master/M_ReminderLetter');
        $docno = $this->input->post('tindakan');
        $startdate = $this->input->post('startdate');
        $startdate = date('Y-m-d', strtotime($startdate));
        $master = $this->M_ReminderLetter->q_transaction_read_where(' AND docno = \'' . $docno . '\' ')->row();
        $finishdate = $this->M_ReminderLetter->find($startdate, $master->period_value, $master->time_unit);
        echo json_encode(array('finishdate'=>$finishdate->modifydate));
    }

    function cetak()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $nama = trim($this->session->userdata('nama'));
        $enc_docno = $this->input->get('enc_docno');
        $data['jsonfile'] = "trans/skperingatan/api_cetak/?enc_docno=$enc_docno";
        $data['report_file'] = 'assets/mrt/skperingatan.mrt';
        $data['title'] = 'Cetak Surat Peringatan';
        $this->load->view("stimulsoft/viewer_new",$data);
    }

    function api_cetak()
    {   $this->load->helper('my');
        $docno = $this->fiky_encryption->dekript($this->input->get('enc_docno'));
        $datamst = array_map('trim', $this->m_akses->q_branch()->row_array());
        $dataopt = array_map('trim', $this->m_skperingatan->q_option_cetak($docno)->row_array());
        $param = " AND docno = '$docno'";
        $dtl = array_map('trim', $this->m_skperingatan->read_trxskperingatan($param)->row_array());
        $dtl['nmlengkap'] = $this->ucstring(trim($dtl['nmlengkap']));
        $dtl['nmjabatan'] = !empty($dtl['jabatan_cetak']) ? $dtl['jabatan_cetak'] : $this->ucstring(trim($dtl['nmjabatan']));
        $dtl['nmdept'] = !empty($dtl['dept_cetak']) ? $dtl['dept_cetak'] : $this->ucstring(trim($dtl['nmdept']));
        $dtl['enddate1'] = formattgl($dtl['enddate1']);
        $dtl['description'] = strtoupper($dtl['description']);
        $dataopt['print_date']= formattgl(date('Y-m-d'));
        header("Content-Type: text/json");
        echo json_encode(
            [
                'master' => $datamst,
                'option' => $dataopt,
                'detail' => $dtl
            ], JSON_PRETTY_PRINT
        );
    }

    public function actionpopup($param){
        $this->load->model(array('trans/m_skperingatan','master/M_ApprovalRule','trans/M_Employee','master/m_akses'));
        $json = json_decode(
            hex2bin($param)
        );
        $transaction = $this->m_skperingatan->q_transaction_read_where(' AND docno = \''.$json->docno.'\'  ')->row();
        if (!is_null($transaction->docno) && !is_null($transaction->docno) && !empty($transaction->docno)) {
            if ( strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->m_skperingatan->q_transaction_read_where(' AND docno = \'' . $transaction->docno . '\' AND superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' ')->num_rows() > 0) {
                $type = 'Atasan';
                $approveUrl = site_url('trans/skperingatan/atasan/?enc_docno='.$this->fiky_encryption->enkript(trim($transaction->docno)));
            }else{
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Anda tidak memiliki akses'
                ));
                return;
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'canapprove' => TRUE,
                'investigationReport' => TRUE,
                'type' => 'Surat Peringatan',
                'next' => array(
                    'approve' => $approveUrl
                ),
                'data' => $transaction,
            ));
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data tidak ditemukan'
            ));
        }
    }

        function ucstring($string) {
            // Step 1: Replace spaces with underscores and convert to uppercase
            $string = strtolower(str_replace(' ', '_', $string));
                
            // Step 2: Replace underscores back with spaces
            $string = str_replace('_', ' ', $string);
            
            // Step 3: Capitalize the first letter of each word
            $string = ucwords(strtolower($string));

            return $string;
    }
}
