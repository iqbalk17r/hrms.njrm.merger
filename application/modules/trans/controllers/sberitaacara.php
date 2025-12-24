<?php

class Sberitaacara extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(['master/m_akses', 'm_sberitaacara', 'master/m_trxerror', 'master/M_ApprovalRule']);
        $this->load->library(['form_validation', 'template', 'upload', 'pdf', 'fiky_encryption', 'Fiky_report']);
        if(!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

	function index() {
        $this->load->model(array('master/M_ApprovalRule'));
        $this->clearTemporary();
        $data['title'] = "Berita Acara";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $userinfo = $this->m_akses->q_user_check()->row_array();
//        $data['userhr'] = $this->m_akses->list_aksesperdep()->num_rows();
        //$data['userhr'] = $this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'BA\' ');
        $data['userhr'] = trim($this->db->query("select nik from sc_mst.karyawan where lvl_jabatan = 'C' and jabatan = 'HR02'")
                                ->row()->nik);
        $data['level_akses'] = strtoupper(trim($userinfo['level_akses']));
        $paramerror = " AND userid = '$nik' AND modul = 'I.T.C.1'";
        $dtlerror = $this->m_trxerror->q_trxerror($paramerror)->row_array();

        $errordesc = isset($dtlerror['description']) ? trim($dtlerror['description']) : '';
        $nomorakhir1 = isset($dtlerror['nomorakhir1']) ? trim($dtlerror['nomorakhir1']) : '';
        $errorcode = isset($dtlerror['errorcode']) ? trim($dtlerror['errorcode']) : '';

        $data['message'] = "";

        if($dtlerror) {
            if($errorcode == 0) {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH: $nomorakhir1</div>";
            } else if($errorcode == 1) {
                $data['message'] = "<div class='alert alert-success'>DOKUMEN TELAH DISETUJUI: $nomorakhir1</div>";
            } else if($errorcode == 2) {
                $data['message'] = "<div class='alert alert-danger'>DOKUMEN TELAH DIBATALKAN: $nomorakhir1</div>";
            } else if($errorcode == 3) {
                $data['message'] = "<div class='alert alert-warning'>DOKUMEN SEDANG DIPROSES: $nomorakhir1</div>";
            } else if($errordesc <> '') {
                $data['message'] = "<div class='alert alert-warning'>$errordesc</div>";
            }
        }
        $this->showUnfinish();
        /*die();*/
        $paramtrx = "";
        if ($data['userhr'] == $nik) {
            $paramtrx .= " AND TRUE";
        }else{
            $paramtrx .= " AND ( superiors ilike '%$nik%' OR witness ilike '%$nik%' OR inputby = '$nik' ) ";
        }
        $data['tglrange'] = $this->input->post('tglrange');
        if($data['tglrange']) {
            $tgl = explode(" - ", $this->input->post('tglrange'));
            $paramtrx .= " AND docdate::DATE BETWEEN '" . date("Y-m-d", strtotime($tgl[0])) . "'::DATE AND '" . date("Y-m-d", strtotime($tgl[1])) . "'::DATE";
        }
        $data['listtrx'] = $this->m_sberitaacara->read_trxberitaacara($paramtrx)->result();
        $data['superuser'] = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'HR\' AND groupid = \'SU\' ');

        $this->template->display('trans/sberitaacara/v_sberitaacara', $data);
        $pterror = " AND userid = '$nik'";
        $this->m_trxerror->q_deltrxerror($pterror);
    }

    function detail() {
        $data['title'] = "Detail Berita Acara";
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }

        $param = " AND COALESCE(docno, '') = '$docno'";
        $data['dtl'] = $this->m_sberitaacara->read_trxberitaacara($param)->row();
        $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
        $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
        $data['list_departmen'] = $this->m_sberitaacara->q_list_master_departmen()->result_array();
        if($data['dtl']->peringatan != '') {
            $data['list_tindakan'] = $this->m_sberitaacara->q_list_master_tindakan()->result_array();
        }
        $this->template->display('trans/sberitaacara/v_detail_sberitaacara', $data);
    }

    function input() {
        $data['title'] = "Input Berita Acara";
        $nik = trim($this->session->userdata('nik'));

        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if(!$dtl) {
            $info = [
                'docno' => $nik,
                'docdate' => date('Y-m-d H:i:s'),
                'status' => 'I',
                'saksi' => 'f',
                'inputby' => $nik,
                'inputdate' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('sc_tmp.berita_acara', $info);
        }

        $data['type'] = 'INPUT';
        $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
        $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
        $data['list_departmen'] = $this->m_sberitaacara->q_list_master_departmen()->result_array();
        $this->template->display('trans/sberitaacara/v_input_sberitaacara', $data);
    }

    function edit() {
        $data['title'] = "Edit Berita Acara";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if($dtl !== null) {
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
            redirect('trans/sberitaacara');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'E',
                'updateby' => $nik,
                'updatedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if($this->db->update('sc_trx.berita_acara', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'EDIT';
                $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
                $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
                $data['list_departmen'] = $this->m_sberitaacara->q_list_master_departmen()->result_array();
                $this->template->display('trans/sberitaacara/v_input_sberitaacara', $data);
            }
        }
    }

    function saksi1() {
        $data['title'] = "Approval Berita Acara";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if($dtl !== null) {
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
            redirect('trans/sberitaacara');
        } else {
//            var_dump($docno);die();
            $info = [
                'docnotmp' => $docno,
                'status' => 'S1P',
                'saksi1_approvedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if($this->db->update('sc_trx.berita_acara', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'APRS1';
                $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
                $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
                $data['list_departmen'] = $this->m_sberitaacara->q_list_master_departmen()->result_array();
                $this->template->display('trans/sberitaacara/v_approval_sberitaacara', $data);
            }
        }
    }

    function saksi2() {
        $data['title'] = "Approval Berita Acara";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if($dtl) {
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
            redirect('trans/sberitaacara');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'S2P',
                'saksi2_approvedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if($this->db->update('sc_trx.berita_acara', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'APRS2';
                $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
                $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();

                $this->template->display('trans/sberitaacara/v_approval_sberitaacara', $data);
            }
        }
    }

    function atasan() {
        $nama= trim($this->session->userdata('username'));
        $data['title'] = "Approval Berita Acara Atasan $nama";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if($dtl) {
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
            redirect('trans/sberitaacara');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'AP1',
                'approveby' => $nik,
                'approvedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if($this->db->update('sc_trx.berita_acara', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'APRA1';
                $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
                $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
                $data['list_tindakan'] = $this->m_sberitaacara->q_list_master_tindakan()->result_array();

                $this->template->display('trans/sberitaacara/v_approval_sberitaacara', $data);
            }
        }
    }

        function atasan2() {
        $nama= trim($this->session->userdata('username'));
        $data['title'] = "Approval Berita Acara Atasan $nama";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }

        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if($dtl) {
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
            redirect('trans/sberitaacara');
        } else {
            $info = [
                'docnotmp' => $docno,
                'status' => 'AP2',
                'approveby' => $nik,
                'approvedate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('docno', $docno);
            if($this->db->update('sc_trx.berita_acara', $info)) {
                $param = " AND COALESCE(docno, '') = '$nik'";
                $data['type'] = 'APRA2';
                $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
                $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
                $data['list_tindakan'] = $this->m_sberitaacara->q_list_master_tindakan()->result_array();

                $this->template->display('trans/sberitaacara/v_approval_sberitaacara', $data);
            }
        }
    }

    function hrd() {
        $this->load->model(array('master/M_ApprovalRule'));
        $data['title'] = "Approval Berita Acara";
        $nik = $data['nik'] = trim($this->session->userdata('nik'));
        $docno = $data['docno'] = $this->fiky_encryption->dekript(trim($this->input->get('enc_docno')));
        if($docno == "") {
            redirect('trans/sberitaacara');
        }
        $param = " AND COALESCE(docno, '') != '$nik' AND docnotmp = '$docno'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if($dtl) {
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
            redirect('trans/sberitaacara');
        } else {
            if (trim($this->db->query("select nik from sc_mst.karyawan where lvl_jabatan = 'C' and jabatan = 'HR02'")
                                ->row()->nik) == $nik){
                $info = [
                    'docnotmp' => $docno,
                    'status' => 'BP',
                    'hrd_approveby' => $nik,
                    'hrd_approvedate' => date('Y-m-d H:i:s')
                ];
                $this->db->where('docno', $docno);
                if($this->db->update('sc_trx.berita_acara', $info)) {
                    $param = " AND COALESCE(docno, '') = '$nik'";
                    $data['type'] = 'APRB';
                    $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                    $data['list_karyawan'] = $this->m_sberitaacara->q_lv_m_karyawan()->result_array();
                    $data['list_kejadian'] = $this->m_sberitaacara->q_list_master_kejadian()->result_array();
                    $data['list_tindakan'] = $this->m_sberitaacara->q_list_master_tindakan()->result_array();
                    $data['list_departmen'] = $this->m_sberitaacara->q_list_master_departmen()->result_array();
                    $this->template->display('trans/sberitaacara/v_approval_sberitaacara', $data);
                }
            }
        }
    }

    function saveEntry() {
        $nik = trim($this->session->userdata('nik'));
        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        $submit = trim($this->input->post('submit'));
        $type = $this->input->post('type');
        //var_dump($submit, $type); 
        //die(); 
        if(in_array(trim($this->input->post('type')), ["INPUT", "EDIT"])) {
            $info = [
                'nik' => trim($this->input->post('nik')),
                'docdate' => trim($this->input->post('docdate')) ?: NULL,
                'laporan' => trim($this->input->post('laporan')),
                'lokasi' => trim($this->input->post('lokasi')),
                'uraian' => trim($this->input->post('uraian')),
                'solusi' => trim($this->input->post('solusi')),
                'saksi' => 'f',
                'saksi1' => NULL,
                'saksi2' => NULL,
                'status' => 'A1',
                'subjek' => strtoupper(trim($this->input->post('subjek'))),
                'todepartmen' => strtoupper(trim($this->input->post('todepartmen'))),
            ];
            if ($info['saksi'] == 't1') {
                $info['saksi1'] = trim($this->input->post('saksi1'));
            } else if ($info['saksi'] == 't2') {
                $info['saksi1'] = trim($this->input->post('saksi1'));
                $info['saksi2'] = trim($this->input->post('saksi2'));
            }
      
        } else if(trim($this->input->post('type')) == "APRS1") {
            if($submit == "setuju") {
                $info = [
                    'status' => $dtl->formatsaksi == "t1" ? "B" : "S2"
                ];
            } else if($submit == "batal") {
                $info = [
                    'status' => "X",
                    'saksi1_approvedate' => NULL,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
        } else if(trim($this->input->post('type')) == "APRS2") {
            if($submit == "setuju") {
                $info = [
                    'status' => "B"
                ];
            } else if($submit == "batal") {
                $info = [
                    'status' => "X",
                    'saksi2_approvedate' => NULL,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
        } else if(trim($this->input->post('type')) == "APRA1") {
            if($submit == "setuju") {
                $info = [
                    'peringatan' => trim($this->input->post('peringatan')),
                    'tindakan' => NULL,
                    'tindaklanjut' => NULL,
                    'status' => "A2"
                ];
            } else if($submit == "batal") {
                $info = [
                    'peringatan' => trim($this->input->post('peringatan')),
                    'tindakan' => NULL,
                    'tindaklanjut' => NULL,
                    'status' => "X",
                    'approveby' => NULL,
                    'approvedate' => NULL,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
            if($info['peringatan'] == 'y') {
                $info['tindakan'] = trim($this->input->post('tindakan'));
            } else if($info['peringatan'] == 'n') {
                $info['tindaklanjut'] = trim($this->input->post('tindaklanjut'));
            }
        } else if(trim($this->input->post('type')) == "APRA2") {
            if($submit == "setuju") {
                $info = [
                    'peringatan' => trim($this->input->post('peringatan')),
                    'tindakan' => NULL,
                    'tindaklanjut' => NULL,
                    'status' => "B"
                ];
            } else if($submit == "batal") {
                $info = [
                    'peringatan' => trim($this->input->post('peringatan')),
                    'tindakan' => NULL,
                    'tindaklanjut' => NULL,
                    'status' => "X",
                    'approveby' => NULL,
                    'approvedate' => NULL,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
            if($info['peringatan'] == 'y') {
                $info['tindakan'] = trim($this->input->post('tindakan'));
            } else if($info['peringatan'] == 'n') {
                $info['tindaklanjut'] = trim($this->input->post('tindaklanjut'));
            }
        } else if(trim($this->input->post('type')) == "APRB") {
            if($submit == "setuju") {
                $info = [
                    'peringatan' => trim($this->input->post('peringatan')),
                    'tindakan' => NULL,
                    'tindaklanjut' => NULL,
                    'status' => "P"
                ];
            } else if($submit == "batal") {
                $info = [
                    'peringatan' => trim($this->input->post('peringatan')),
                    'tindakan' => NULL,
                    'tindaklanjut' => NULL,
                    'status' => "X",
                    'hrd_approveby' => NULL,
                    'hrd_approvedate' => NULL,
                    'cancelby' => $nik,
                    'canceldate' => date('Y-m-d H:i:s')
                ];
            }
            if($info['peringatan'] == 'y') {
                $info['tindakan'] = trim($this->input->post('tindakan'));
            } else if($info['peringatan'] == 'n') {
                $info['tindaklanjut'] = trim($this->input->post('tindaklanjut'));
            }
        }
            //   var_dump($info);
            // die();
        $this->db->where('docno', trim($this->input->post('docno')));
        if($this->db->update('sc_tmp.berita_acara', $info)) {
            redirect('trans/sberitaacara');
        }
    }

    function clearEntry() {
        $nik = trim($this->session->userdata('nik'));
        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
//        var_dump($dtl);die();
        $this->db->where('docno', $nik);
        if($this->db->delete('sc_tmp.berita_acara')) {
            if(trim($dtl->status) == "E") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => $dtl->saksi == 'f' ? 'A' : 'S1',
                    'updateby' => NULL,
                    'updatedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "S1P") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'S1',
                    'saksi1_approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "S2P") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'S2',
                    'saksi2_approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "AP1") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'A1',
                    'approveby' => NULL,
                    'approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            
            } else if(trim($dtl->status) == "AP2") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'A2',
                    'approveby' => NULL,
                    'approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            
            }  else if(trim($dtl->status) == "BP") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'B',
                    'hrd_approveby' => NULL,
                    'hrd_approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            }
            redirect('trans/sberitaacara');
        }
    }

    public function clearTemporary(){
        $nik = trim($this->session->userdata('nik'));
        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
//        var_dump($dtl);die();
        $this->db->where('docno', $nik);
        if($this->db->delete('sc_tmp.berita_acara')) {
            if(trim($dtl->status) == "E") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => $dtl->saksi == 'f' ? 'A' : 'S1',
                    'updateby' => NULL,
                    'updatedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "S1P") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'S1',
                    'saksi1_approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "S2P") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'S2',
                    'saksi2_approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "AP") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'A',
                    'approveby' => NULL,
                    'approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            } else if(trim($dtl->status) == "BP") {
                $info = [
                    'docnotmp' => NULL,
                    'status' => 'B',
                    'hrd_approveby' => NULL,
                    'hrd_approvedate' => NULL
                ];
                $this->db->where('docno', $dtl->docnotmp);
                $this->db->update('sc_trx.berita_acara', $info);
            }
        }
    }

    function showUnfinish() {
        $nik = trim($this->session->userdata('nik'));
        $param = " AND COALESCE(docno, '') = '$nik'";
        $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
        if(trim($dtl->status) == "I") {
            $this->clearEntry();
        } else if(trim($dtl->status) == "E") {
            redirect("trans/sberitaacara/edit?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        } else if(trim($dtl->status) == "S1") {
            redirect("trans/sberitaacara/saksi1?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        } else if(trim($dtl->status) == "S2") {
            redirect("trans/sberitaacara/saksi2?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        } else if(trim($dtl->status) == "A") {
            redirect("trans/sberitaacara/atasan?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        } else if(trim($dtl->status) == "B") {
            redirect("trans/sberitaacara/hrd?enc_docno=" . $this->fiky_encryption->enkript(trim($dtl->docnotmp)));
        }
    }

    function cetak() {
        $nama = trim($this->session->userdata('nama'));
        $enc_docno = $this->input->get('enc_docno');
        $title = "Cetak Berita Acara";
        $data['jsonfile'] = "trans/sberitaacara/api_cetak/?enc_docno=$enc_docno";
        $data['report_file'] = 'assets/mrt/berita_acara.mrt';
        $data['title'] = $title;
        $this->load->view("stimulsoft/viewer_new",$data);
    }

    function api_cetak() {
        $docno = $this->fiky_encryption->dekript($this->input->get('enc_docno'));
        $datamst = array_map('trim', $this->m_akses->q_branch()->row_array());
        $dataopt = array_map('trim', $this->m_sberitaacara->q_option_cetak()->row_array());
        $param = " AND docno = '$docno'";
        $dtl = array_map('trim', $this->m_sberitaacara->read_trxberitaacara($param)->row_array());
        $originaltext = array();
        $fix=array();
        $maxWidthCm = 20;
        $dpi = 106;
        $fontPath = './assets/fonts/times.ttf';
        $fontSize = 12;
        $minLine = 15;
        $maxWidthPx = $this->cmToPixels($maxWidthCm, $dpi);
        //$dtl['uraian'] = "(trial) pada hari rabu telah terjadi kehilangan berkas surat lamaran yang mana berkas tersebut di simpan didalam lemari arsip. namun setelah didapati berkas tersebut tidak ada.";
        $chunks = $this->splitTextByPixelWidth($dtl['uraian'], $maxWidthPx, $fontPath, $fontSize);
        $config = $this->getSetup();
        foreach ($chunks as $chunk) {
            array_push($originaltext, array('xxx' => $chunk));
        }

        foreach ($originaltext as $index => $t) {
            $data = preg_split("/\r\n|\n|\r/", $t['xxx']);
            foreach ($data as $datum) {
                array_push($fix, array('detail' => implode('', preg_split("/\r\n|\n|\r/", $datum))));
            }
        }

        switch (date('m',strtotime($dtl['docdate']))){
            case 01:
                $bulan='Januari';
                break;
            case 02:
                $bulan='Februari';
                break;
            case 03:
                $bulan='Maret';
                break;
            case 04:
                $bulan='April';
                break;
            case 05:
                $bulan='Mei';
                break;
            case 06:
                $bulan='Juni';
                break;
            case 07:
                $bulan='Juli';
                break;
            case 08:
                $bulan='Agustus';
                break;
            case 09:
                $bulan='September';
                break;
            case 10:
                $bulan='Oktober';
                break;
            case 11:
                $bulan='November';
                break;
            case 12:
                $bulan='Desember';
                break;
        }
        $dataopt['print_type'] = $config['I:P:T'];
        $availableType = array(1,2);
        if (!in_array($config['I:P:T'], $availableType)){
            $dataopt['print_type'] = 1;
        }
        $this->load->helper('my_helper');
        $dtl['docdate1']=date('d',strtotime($dtl['docdate'])).' '.$bulan.' '.date('Y',strtotime($dtl['docdate']));
        $dtl['alamattinggal'] = $dtl['alamattinggal'] ?: '-';
        $dtl['nohp1'] = $dtl['noph1'] ?: '-';
        $dtl['s1_nmlengkap'] = $dtl['s1_nmlengkap'] ?: '-';
        $dtl['s2_nmlengkap'] = $dtl['s2_nmlengkap'] ?: '-';
        $dtl['daynow'] = nmhari($dtl['docdate']);
        $dtl['hournow'] = date('H:i',strtotime($dtl['docdate']));
        header("Content-Type: text/json");
        echo json_encode(
            [
                'master' => $datamst,
                'option' => $dataopt,
                'detail' => $dtl,
                'text' => $fix
            ], JSON_PRETTY_PRINT
        );
    }

    public function actionpopup($param){
        $this->load->model(array('trans/m_sberitaacara','master/M_ApprovalRule'));
        $json = json_decode(
            hex2bin($param)
        );
        $transaction = $this->m_sberitaacara->q_transaction_read_where(' AND docno = \''.$json->docno.'\' ')->row();
        if ($transaction) {
            if ($transaction->status == 'S1' AND $transaction->saksi1 == trim($this->session->userdata('nik')) ){
                $type = 'Saksi 1';
                $approveUrl = site_url('trans/sberitaacara/saksi1/?enc_docno='.$this->fiky_encryption->enkript(trim($transaction->docno)));
            }else if ($transaction->status == 'S2' AND $transaction->saksi2 == trim($this->session->userdata('nik')) ){
                $type = 'Saksi 2';
                $approveUrl = site_url('trans/sberitaacara/saksi2/?enc_docno='.$this->fiky_encryption->enkript(trim($transaction->docno)));
            }else if ($transaction->status == 'B' AND $this->M_ApprovalRule->q_transaction_approver(' AND departmentid = \'HR\'  AND groupid = \'BA\' ') ){
                $type = 'HRD';
                $approveUrl = site_url('trans/sberitaacara/saksi2/?enc_docno='.$this->fiky_encryption->enkript(trim($transaction->docno)));
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
                'type' => $type, //paramater berita acara
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

    function splitTextByPixelWidth($text, $maxWidthPx, $fontPath, $fontSize) {
        $lines = [];
        $currentLine = '';

        $words = explode(' ', $text);
        foreach ($words as $word) {
            $newLine = $currentLine . ($currentLine ? ' ' : '') . $word;
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $newLine);
            $lineWidth = $bbox[2] - $bbox[0];

            if ($lineWidth > $maxWidthPx) {
                if ($currentLine) {
                    $lines[] = trim($currentLine);
                }
                $currentLine = $word;
            } else {
                $currentLine = $newLine;
            }
        }

        // Add any remaining text
        if ($currentLine) {
            $lines[] = trim($currentLine);
        }

        return $lines;
    }

    function cmToPixels($cm, $dpi) {
        $inches = $cm * 0.393701;
        return $inches * $dpi;
    }
    function getAverageCharWidth($fontSize) {
        return $fontSize * 0.6;
    }

    public function getSetup()
    {
        $this->load->model(array('master/m_option'));
        $defaultArr = array(
            'I:P:T' => '1',
        );
        $parameterArr = array();
        foreach ($defaultArr as $index => $item) {
            array_push($parameterArr,$index);
        }
        $parameterIn = "'".implode("','",$parameterArr)."'";
        $getSetup = $this->m_option->q_master_read_default_array(' AND parameter IN('.$parameterIn.') ',$defaultArr);
        return $getSetup;

    }
}
