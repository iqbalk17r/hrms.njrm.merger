<?php
/*
	@author : randy
	13-04-2015
*/

//error_reporting(0)
class Ijin_karyawan extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        //$enc_nodok=bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp'])));
        //$nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $this->load->model(array('m_ijin_karyawan', 'master/m_akses'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'Excel_generator', 'fiky_encryption', 'fiky_notification_push'));
        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        //echo "test";
        //redirect(trans/ijin_karyawan/index);
        $nama = $this->session->userdata('nik');
        $data['title'] = "List Ijin Karyawan";

        /* CODE UNTUK VERSI*/
        $nama = trim($this->session->userdata('nik'));
        $kodemenu = 'I.T.B.4';
        $versirelease = 'I.T.B.4/ALPHA.001';
        $releasedate = date('2019-04-12 00:00:00');
        $versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
        $x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
        $data['x'] = $x['rows'];
        $data['y'] = $x['res'];
        $data['t'] = $x['xn'];
        $data['kodemenu'] = $kodemenu;
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */

        $paramerror = " and userid='$nama' and modul='IJIN'";
        $dtlerror = $this->m_ijin_karyawan->q_trxerror($paramerror)->row_array();
        $count_err = $this->m_ijin_karyawan->q_trxerror($paramerror)->num_rows();
        if (isset($dtlerror['description'])) {
            $errordesc = trim($dtlerror['description']);
        } else {
            $errordesc = '';
        }
        if (isset($dtlerror['nomorakhir1'])) {
            $nomorakhir1 = trim($dtlerror['nomorakhir1']);
        } else {
            $nomorakhir1 = '';
        }
        if (isset($dtlerror['errorcode'])) {
            $errorcode = trim($dtlerror['errorcode']);
        } else {
            $errorcode = '';
        }

        if ($count_err > 0 and $errordesc <> '') {
            if ($dtlerror['errorcode'] == 0) {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message'] = "<div class='alert alert-info'>$errordesc</div>";
            }

        } else {
            if ($errorcode == '0') {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message'] = "";
            }
        }


        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        $status1 = $this->input->post('status');

        if (empty($thn) and empty($status1)) {
            $tahun = date('Y');
            $bulan = date('m');
            $tgl = $bulan . $tahun;
            $status = 'is not NULL';

        } else if (empty($status1)) {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
            $status = 'is not NULL';

        } else {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
            $status = "='$status1'";
        }
        switch ($bulan) {
            case '01':
                $bul = 'Januari';
                break;
            case '02':
                $bul = 'Februari';
                break;
            case '03':
                $bul = 'Maret';
                break;
            case '04':
                $bul = 'April';
                break;
            case '05':
                $bul = 'Mei';
                break;
            case '06':
                $bul = 'Juni';
                break;
            case '07':
                $bul = 'Juli';
                break;
            case '08':
                $bul = 'Agustus';
                break;
            case '09':
                $bul = 'September';
                break;
            case '10':
                $bul = 'Oktober';
                break;
            case '11':
                $bul = 'November';
                break;
            case '12':
                $bul = 'Desember';
                break;
        }

        //echo $status;

        $kmenu = 'I.T.B.4';
        $nama = $this->session->userdata('nik');
        /* akses approve atasan */
        $ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));

        if (($userhr > 0 or $level_akses == 'A')) {
            $nikatasan = '';
        } else if (($ceknikatasan1) > 0 and $userhr == 0 and ($level_akses == 'B' or $level_akses == 'C' or $level_akses == 'D')) {
            $nikatasan = "where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or x1.nik='$nama'";

        } else if (($ceknikatasan2) > 0 and $userhr == 0 and ($level_akses == 'B' or $level_akses == 'C' or $level_akses == 'D')) {
            $nikatasan = "where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or x1.nik='$nama'";
        } else {
            $nikatasan = "where x1.nik='$nama'";
        }
        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;
        /* END APPROVE ATASAN */

        $data['akses'] = $this->m_akses->list_aksespermenu($nama, $kmenu)->row_array();
        $data['list_ijin_karyawan'] = $this->m_ijin_karyawan->q_ijin_karyawan($tgl, $nikatasan, $status)->result();
        $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin()->result();

        $this->template->display('trans/ijin_karyawan/v_list', $data);
        $paramerror = " and userid='$nama'";
        $dtlerror = $this->m_ijin_karyawan->q_deltrxerror($paramerror);
    }

    function karyawan()
    {
        //$data['title']="List Master Riwayat Keluarga";

        $data['title'] = "List Karyawan";
        //$data['list_karyawan']=$this->m_ijin_karyawan->list_karyawan()->result();
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));

        if ($userhr > 0 or $level_akses == 'A') {
            $data['list_karyawan'] = $this->m_akses->list_karyawan()->result();
        } else {
            $data['list_karyawan'] = $this->m_akses->list_akses_alone()->result();
        }


        $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin()->result();
        //$data['list_lk2']=$this->m_ijin_karyawan->list_karyawan_index($nik)->row_array();
        //$data['list_lk']=$this->m_ijin_karyawan->list_karyawan_index()->result();
        $this->template->display('trans/ijin_karyawan/v_list_karyawan', $data);
    }

    function proses_input($nik)
    {
        $data['title'] = "Input Ijin Karyawan";
        if ($this->uri->segment(5) == "input_failed") {
            $data['message'] = "<div class='alert alert-danger'>Data Sudah Ada/Pernah Di Input</div>";
        } else {
            $data['message'] = '';
        }

        $nama = $this->session->userdata('nik');
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdepcuti()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;

        $data['list_lk'] = $this->m_ijin_karyawan->list_karyawan_index($nik)->result();
        if ($userhr > 0) {
            $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin()->result();
        } else {
            $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin_khusus()->result();
        }
        //$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
        $this->template->display('trans/ijin_karyawan/v_input', $data);
    }

    function add_ijin_karyawan()
    {
        //$nik1=explode('|',);
        $this->load->model('trans/M_WorkSchedule');
        $nama = $this->session->userdata('nik');
        $nik = $this->input->post('nik');
        $tgl_kerja1 = $this->input->post('tgl_kerja');
        $workSchedule = $this->M_WorkSchedule->read(' AND nik = \'' . $nik . '\' AND tgl = \'' . date('Y-m-d', strtotime($tgl_kerja1)) . '\' ')->row();
        //$nodok=$this->input->post('nodok');
        $kddept = $this->input->post('department');
        $kdsubdept = $this->input->post('subdepartment');
        $kdjabatan = $this->input->post('jabatan');
        $kdlvljabatan = $this->input->post('kdlvl');
        $atasan = $this->input->post('atasan');
        $kdijin_absensi = $this->input->post('kdijin_absensi');

        if ($tgl_kerja1 == '') {
            $tgl_kerja = NULL;
        } else {
            $tgl_kerja = $tgl_kerja1;
        }
        /*$durasi1=$this->input->post('durasi');
        if ($durasi1==''){
            $durasi=NULL;
        } else {
            $durasi=$durasi1;
        }*/

        $tgl_jam_awal1 = $this->input->post('tgl_jam_awal');
        if ($tgl_jam_awal1 == '') {
            $tgl_jam_awal = NULL;
        } else {
            $tgl_jam_awal = $tgl_jam_awal1;
        }
        $jam_awal1 = $this->input->post('jam_awal');
        if ($jam_awal1 == '') {
            $jam_awal = NULL;
        } else {
            $jam_awal = $jam_awal1;
        }

        $tgl_jam_selesai1 = $this->input->post('tgl_jam_selesai');
        if ($tgl_jam_selesai1 == '') {
            $tgl_jam_selesai = NULL;
        } else {
            $tgl_jam_selesai = $tgl_jam_selesai1;
        }
        $jam_selesai1 = $this->input->post('jam_selesai');
        if ($jam_selesai1 == '') {
            $jam_selesai = NULL;
        } else {
            $jam_selesai = $jam_selesai1;
        }

        switch ($kdijin_absensi) {
            case 'DT':
                $jam_awal = $workSchedule->checkin_schedule;
                $jam_selesai = $this->input->post('jam_awal');
                break;
            case 'PA':
                $jam_awal = $this->input->post('jam_selesai');
                $jam_selesai = $workSchedule->checkout_schedule;
                break;
            case 'IK':
                $jam_awal = $this->input->post('jam_awal');
                $jam_selesai = $this->input->post('jam_selesai');
                break;
        }
        $durasi = abs(strtotime($jam_selesai) - strtotime($jam_awal)) / 60;
        $tgl_dok = $this->input->post('tgl_dok');
        $keterangan = $this->input->post('keterangan');
        $status = $this->input->post('status');
        $tgl_input = $this->input->post('tgl');
        $inputby = $this->input->post('inputby');
        $ktgijin = $this->input->post('ktgijin');
        $kendaraan = $this->input->post('kendaraan');
        $nopol = $this->input->post('nopol');
//        var_dump($tgl_jam_awal);die();
        //echo $gaji_bpjs;
        $primaryType = array('IK','DT','PA');

        $info = array(
            'nik' => $nik,
            'nodok' => $this->session->userdata('nik'),
            'kddept' => strtoupper($kddept),
            'kdsubdept' => strtoupper($kdsubdept),
            'durasi' => $durasi,
            //'kdjabatan'=>$kdjabatan,
            'kdlvljabatan' => strtoupper($kdlvljabatan),
            'kdjabatan' => strtoupper($kdjabatan),
            'nmatasan' => $atasan,
            'tgl_dok' => $tgl_dok,
            'kdijin_absensi' => strtoupper($kdijin_absensi),
            'tgl_kerja' => $tgl_kerja,
            'tgl_jam_mulai' => ( in_array($kdijin_absensi,$primaryType) ? (($kdijin_absensi == 'PA' AND $kdijin_absensi != 'IK') ?  null : $jam_awal1) : null),
            'tgl_jam_selesai' => ( in_array($kdijin_absensi,$primaryType) ? (($kdijin_absensi == 'DT' AND $kdijin_absensi != 'IK') ?  null : $jam_selesai1) : null),
            'keterangan' => strtoupper($keterangan),
            'status' => 'I',
            'input_date' => $tgl_input,
            'input_by' => strtoupper($inputby),
            'type_ijin' => strtoupper($ktgijin),
            'kendaraan' => strtoupper($kendaraan),
            'nopol' => strtoupper($nopol),
            'tgl_mulai' => $tgl_jam_awal,
            'tgl_selesai' => $tgl_jam_selesai,
        );

//        var_dump($info);die();

        $cek = $this->m_ijin_karyawan->cek_double($nik, $tgl_kerja)->num_rows();
        if ($cek > 0 && in_array(strtoupper($ktgijin), array('IK'))) {
            redirect("trans/ijin_karyawan/proses_input/$nik/input_failed");
        } else {
            $this->db->insert('sc_tmp.ijin_karyawan', $info);
            $dtl_push = $this->m_akses->q_lv_mkaryawan(" and nik='$nik'")->row_array();
            $paramerror = " and userid='$nama' and modul='IJIN'";
            $dtlerror = $this->m_ijin_karyawan->q_trxerror($paramerror)->row_array();
            if ($this->fiky_notification_push->onePushVapeApprovalHrms($nik, trim($dtl_push['nik_atasan']), trim($dtlerror['nomorakhir1']))) {
                redirect("trans/ijin_karyawan/index/rep_succes");
            } else {
                redirect("trans/ijin_karyawan/index/rep_succes");
            }
        }


    }


    function edit()
    {
        //echo "test";
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $data['title'] = 'EDIT DATA IJIN KARYAWAN';
        if ($this->uri->segment(5) == "upsuccess") {
            $data['message'] = "<div class='alert alert-success'>Data Berhasil di update </div>";
        } else {
            $data['message'] = '';
        }
        $nama = $this->session->userdata('nik');
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;
        if ($userhr > 0) {
            $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin()->result();
        } else {
            $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin_khusus()->result();
        }
        $data['list_ijin_karyawan_dtl'] = $this->m_ijin_karyawan->q_ijin_karyawan_dtl($nodok)->result();

        $this->template->display('trans/ijin_karyawan/v_edit', $data);

    }

    function detail()
    {
        //echo "test";
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $data['title'] = 'DETAIL DATA IJIN KARYAWAN';
        $data['list_ijin'] = $this->m_ijin_karyawan->list_ijin()->result();
        $data['list_ijin_karyawan_dtl'] = $this->m_ijin_karyawan->q_ijin_karyawan_dtl($nodok)->result();
        $this->template->display('trans/ijin_karyawan/v_detail', $data);

    }

    function edit_ijin_karyawan()
    {
        //$nik1=explode('|',);
        $this->load->model('trans/M_WorkSchedule');
        $nik = $this->input->post('nik');
        $nodok = $this->input->post('nodok');
        $kddept = $this->input->post('department');
        $kdsubdept = $this->input->post('subdepartment');
        $kdjabatan = $this->input->post('jabatan');
        $kdlvljabatan = $this->input->post('kdlvl');
        $atasan = $this->input->post('atasan');
        $kdijin_absensi = $this->input->post('kdijin_absensi');
        $tgl_kerja1 = $this->input->post('tgl_kerja');
        $workSchedule = $this->M_WorkSchedule->read(' AND nik = \'' . $nik . '\' AND tgl = \'' . date('Y-m-d', strtotime($tgl_kerja1)) . '\' ')->row();
        if ($tgl_kerja1 == '') {
            $tgl_kerja = NULL;
        } else {
            $tgl_kerja = $tgl_kerja1;
        }
        $tgl_dok = $this->input->post('tgl_dok');
        $keterangan = $this->input->post('keterangan');
        $status = $this->input->post('status');
        $tgl_input = $this->input->post('tgl');
        $inputby = $this->input->post('inputby');
        $kendaraan = $this->input->post('kendaraan');
        $nopol = $this->input->post('nopol');
        //$no_urut=$this->input->post('no_urut');

        $tgl_jam_awal1 = $this->input->post('tgl_jam_awal');
        if ($tgl_jam_awal1 == '') {
            $tgl_jam_awal = NULL;
        } else {
            $tgl_jam_awal = $tgl_jam_awal1;
        }
        $jam_awal1 = $this->input->post('jam_awal');
        if ($jam_awal1 == '') {
            $jam_awal = NULL;
        } else {
            $jam_awal = $jam_awal1;
        }

        $tgl_jam_selesai1 = $this->input->post('tgl_jam_selesai');
        if ($tgl_jam_selesai1 == '') {
            $tgl_jam_selesai = NULL;
        } else {
            $tgl_jam_selesai = $tgl_jam_selesai1;
        }
        $jam_selesai1 = $this->input->post('jam_selesai');
        if ($jam_selesai1 == '') {
            $jam_selesai = NULL;
        } else {
            $jam_selesai = $jam_selesai1;
        }
        switch ($kdijin_absensi) {
            case 'DT':
                $jam_awal = $workSchedule->checkin_schedule;
                $jam_selesai = $this->input->post('jam_awal');
                break;
            case 'PA':
                $jam_awal = $this->input->post('jam_selesai');
                $jam_selesai = $workSchedule->checkout_schedule;
                break;
            case 'IK':
                $jam_awal = $this->input->post('jam_awal');
                $jam_selesai = $this->input->post('jam_selesai');
                break;
        }
        $durasi = abs(strtotime($jam_selesai) - strtotime($jam_awal)) / 60;
        $primaryType = array('IK','DT','PA');
        $info = array(
            'durasi' => $durasi,
            'kdijin_absensi' => strtoupper($kdijin_absensi),
            'tgl_kerja' => $tgl_kerja,
            'tgl_jam_mulai' => ( in_array($kdijin_absensi,$primaryType) ? (($kdijin_absensi == 'PA' AND $kdijin_absensi != 'IK') ?  null : $jam_awal1) : null),
            'tgl_jam_selesai' => ( in_array($kdijin_absensi,$primaryType) ? (($kdijin_absensi == 'DT' AND $kdijin_absensi != 'IK') ?  null : $jam_selesai1) : null),
            'keterangan' => strtoupper($keterangan),
            'update_date' => $tgl_input,
            'update_by' => strtoupper($inputby),
            'tgl_mulai' => $tgl_jam_awal,
            'tgl_selesai' => $tgl_jam_selesai,
            'kendaraan' => strtoupper($kendaraan),
            'nopol' => strtoupper($nopol),
        );

        $cek = $this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
        $cek2 = $this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
        //if ($cek>0 or $cek2>0) {
        if ($cek2 > 0) {
            redirect("trans/ijin_karyawan/index/kode_failed");
        } else {
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.ijin_karyawan', $info);
            redirect("trans/ijin_karyawan/index/upsuccess");
        }
    }

    function hps_ijin_karyawan()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $cek = $this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
        $cek2 = $this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
        //if ($cek>0 or $cek2>0) {
        if ($cek2 > 0) {
            redirect("trans/ijin_karyawan/index/kode_failed");
        } else {
            $info = array('status' => 'C');
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.ijin_karyawan', $info);
            redirect("trans/ijin_karyawan/index/del_succes");
        }


    }

    function resend_sms()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $cek = $this->m_ijin_karyawan->cek_input($nodok)->num_rows();

        if ($cek == 0) {
            redirect("trans/ijin_karyawan/index/kode_failed");
        } else {

            $this->db->query("update sc_trx.ijin_karyawan set status='M' where nodok='$nodok'");
            redirect("trans/ijin_karyawan/index/sendsms_succes/$nodok");
        }

    }

    function approval($nik, $nodok)
    {
        $nik = $this->input->post('nik');
        $nodok = $this->input->post('nodok');
        $tgl_input = $this->input->post('tgl');
        $inputby = $this->input->post('inputby');
        //echo $nik;
        //echo $nodok;
        $cek = $this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
        $cek2 = $this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
        if ($cek > 0 or $cek2 > 0) {
            redirect("trans/ijin_karyawan/index/kode_failed");
        } else {
            $this->m_ijin_karyawan->tr_app($nodok, $inputby, $tgl_input);
            redirect("trans/ijin_karyawan/index/app_succes");
        }
    }


    function cancel($nik, $nodok)
    {
        $nik = $this->input->post('nik');
        $nodok = $this->input->post('nodok');
        $tgl_input = $this->input->post('tgl');
        $inputby = $this->input->post('inputby');
        //echo $nik;
        //echo $nodok;
        $cek = $this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
        $cek2 = $this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
        if ($cek > 0 or $cek2 > 0) {
            redirect("trans/ijin_karyawan/index/kode_failed");
        } else {
            $this->m_ijin_karyawan->tr_cancel($nodok, $inputby, $tgl_input);
            redirect("trans/ijin_karyawan/index/cancel_succes");
        }
    }

    function sti_ijin_karyawan()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $data['jsonfile'] = "trans/ijin_karyawan/json_ijin_karyawan/$nodok";
        $data['report_file'] = 'assets/mrt/sp_ijin_karyawan.mrt';
        //$this->load->view("trans/dinas/sti_form_dinas", $data);
        $this->load->view("stimulsoft/viewer_new",$data);
    }

    function json_ijin_karyawan($nodok)
    {
        header('Content-Type: application/json');
        echo json_encode(array(
            'ijin_karyawan' => $this->m_ijin_karyawan->q_json_ijin_karyawan('
                and (nodok)=(\'' . $nodok . '\')
                ')->result(),

        ), JSON_PRETTY_PRINT);

    }

    function getJadwal()
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $userhr = $this->m_akses->list_aksesperdepcuti()->num_rows();
        if ($data->key == '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO') {
            $dataprocess = $data->body;
            $tanggal = trim($dataprocess->tanggal);
            $nik = trim($dataprocess->nik);
            if (!empty($nik) && !empty($tanggal)) {
                $begintime = date('d-m-Y H:i:s', strtotime($dataprocess->tanggal . ' ' . ($dataprocess->awal != '' ? $dataprocess->awal : $dataprocess->selesai) . ':00'));
                $endtime = date('d-m-Y H:i:s', strtotime($dataprocess->tanggal . ' ' . ($dataprocess->selesai != '' ? $dataprocess->selesai : $dataprocess->awal) . ':00'));
                if (strtotime($endtime) < strtotime($begintime)) {
                    header('Content-Type: application/json');
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Jam selesai tidak boleh lebih kecil dari jam mulai',
                    ));
                } else {
                    $in = date('Ymd', strtotime($dataprocess->tanggal));
                    $now = date('Ymd');
                    if ($userhr == 0 and ($now > $in)) {
                        header('Content-Type: application/json');
                        http_response_code(403);
                        echo json_encode(array(
                            'data' => array(),
                            'message' => 'Tanggal yang dipilih sudah terlewati',
                        ));
                    } else {
                        $split = explode("-", $tanggal);
                        $tgl = (int)$split[0];
                        $bln = $split[1];
                        $thn = $split[2];
                        $this->db->select('trim(tgl' . $tgl . ") as jadwal");
                        $this->db->where('nik', $nik);
                        $this->db->where('bulan', $bln);
                        $this->db->where('tahun', $thn);
                        $query = $this->db->get('sc_trx.listjadwalkerja');
                        $result = $query->row_array();
                        if ($result) {
                            if ($result['jadwal'] <> 'OFF'){
                                $category = $dataprocess->category;
                                $param = '';
                                switch ($dataprocess->type) {
                                    case "DT":
                                        $param .= "AND kdijin_absensi = 'DT' ";
                                    case "PA":
                                        $param .= "AND kdijin_absensi = 'PA' ";
                                        break;
                                }
                                $isEdit = (strtoupper($dataprocess->config) == 'UPDATE' ? " AND trim(nodok) <> '$dataprocess->docno' " : "");
                                $find = $this->m_ijin_karyawan->q_transaction_read_where($isEdit . ' AND status NOT IN (\'C\',\'D\') AND  nik = \'' . trim($nik) . '\' AND tgl_kerja1 = \'' . $dataprocess->tanggal . '\' AND (begintime::timestamp between \'' . $begintime . '\' AND \'' . $endtime . '\' OR endtime::timestamp between  \'' . $begintime . '\' AND \'' . $endtime . '\' ) ')->row();
                                if ($find) {
                                    header('Content-Type: application/json');
                                    http_response_code(404);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'message' => 'Sudah ada ijin di rentang waktu tersebut ',//<br> atau ada ijin dengan kategori yang sama<br> dan <b>belum dibatalkan/sudah disetujui</b>',
                                    ));
                                } else {
                                    $transaction = $this->m_ijin_karyawan->q_transaction_read_where($isEdit . ' AND status NOT IN (\'C\',\'D\') AND  nik = \'' . trim($nik) . '\' AND tgl_kerja1 = \'' . $dataprocess->tanggal.'\' AND kdijin_absensi = \''.$dataprocess->type.'\' ')->row();
//                                    var_dump($transaction);die();
                                    if ($transaction->kdijin_absensi == $dataprocess->type AND $dataprocess->category == 'PB' AND ($dataprocess->type == 'DT' OR $dataprocess->type == 'PA' )){
                                        header('Content-Type: application/json');
                                        http_response_code(404);
                                        echo json_encode(array(
                                            'data' => array(),
                                            'message' => 'SUDAH ADA IJIN PULANG AWAL / DATANG TERLAMBAT PRIBADI DI TANGGAL YANG DIPILIH',//<br> atau ada ijin dengan kategori yang sama<br> dan <b>belum dibatalkan/sudah disetujui</b>',
                                        ));
                                    }else{
                                        $this->db->where('trim(kdjam_kerja)', $result["jadwal"]);
                                        $query = $this->db->get('sc_mst.jam_kerja');
                                        $result2 = $query->row_array();
                                        $tomorrow = date('d-m-Y', strtotime($tanggal . ' +1 day'));
                                        if ($dataprocess->type == 'DT' and $dataprocess->awal != '') {
                                            $input = (int)str_replace(':', '', $dataprocess->awal);
                                            $jam_masuk = (int)str_replace(':', '', $result2['jam_masuk']);
                                            $jam_masuk_max = (int)str_replace(':', '', $result2['jam_masuk_max']);
                                            $tgl_masuk_max = $dataprocess->tanggal;
                                            if ($jam_masuk_max < $jam_masuk) {
                                                $tgl_masuk_max = $tomorrow;
                                            } else {
                                                $tgl_masuk_max = $dataprocess->tanggal;
                                            }
                                            $dateInput = $begintime;
                                            $dateCompare = $tgl_masuk_max . ' ' . $result2['jam_masuk_max'];
                                            $dataNext = $tomorrow . ' ' . $result2['jam_masuk_max'];
                                            if (trim($result2['kdjam_kerja']) == 'SH3') {

                                                if ($dataNext > $dateCompare and $category == 'PB') {
                                                    header('Content-Type: application/json');
                                                    http_response_code(404);
                                                    echo json_encode(array(
                                                        'data' => array(),
                                                        'message' => 'JAM MASUK MAKSIMAL ' . $dateCompare,
                                                    ));
                                                }
                                            } else {
                                                if ($dateInput > $dateCompare and $category == 'PB') {
                                                    header('Content-Type: application/json');
                                                    http_response_code(404);
                                                    echo json_encode(array(
                                                        'data' => array('status' => true, 'tomorrow' => $tomorrow, 'kode' => $result["jadwal"], 'jadwal' => $result2),
                                                        'message' => 'JAM MASUK MAKSIMAL ' . $dateCompare,
                                                    ));
                                                } else {
                                                    header('Content-Type: application/json');
                                                    http_response_code(200);
                                                    echo json_encode(array(
                                                        'data' => array('status' => true, 'tomorrow' => $tomorrow, 'kode' => $result["jadwal"], 'jadwal' => $result2),
                                                        'message' => 'JAM MASUK MAKSIMAL ',
                                                    ));
                                                }
                                            }
                                        } else if ($dataprocess->type == 'PA' and $dataprocess->selesai != '') {
                                            $input = (int)str_replace(':', '', $dataprocess->selesai);
                                            $jam_masuk = (int)str_replace(':', '', $result2['jam_masuk']);
                                            $jam_pulang_min = (int)str_replace(':', '', $result2['jam_pulang_min']);

                                            if ($input < $jam_masuk) {
                                                $tgl_masuk_min = $tomorrow;
                                            } else {
                                                $tgl_masuk_min = $dataprocess->tanggal;
                                            }
                                            $tgl_pulang_min = $dataprocess->tanggal;
                                            if ($jam_pulang_min < $jam_masuk) {
                                                $tgl_pulang_min = $tomorrow;
                                            }
                                            $dateInput = $endtime;
                                            $dateCompare = $tgl_pulang_min . ' ' . $result2['jam_pulang_min'];
                                            if ((strtotime($dateInput) < strtotime($dateCompare)) and $category == 'PB') {
                                                header('Content-Type: application/json');
                                                http_response_code(404);
                                                echo json_encode(array(
//                                                    'data' => array('status' => true, 'tomorrow' => $tomorrow, 'kode' => $result["jadwal"], 'jadwal' => $result2),
                                                    'data' => array(),
                                                    'message' => 'JAM PULANG MINIMAL ' . $dateCompare,
                                                ));
                                            } else {
                                                header('Content-Type: application/json');
                                                http_response_code(200);
                                                echo json_encode(array(
                                                    'data' => array('status' => true, 'tomorrow' => $tomorrow, 'kode' => $result["jadwal"], 'jadwal' => $result2),
                                                ));
                                            }
                                        } else {
                                            header('Content-Type: application/json');
                                            http_response_code(200);
                                            echo json_encode(array(
                                                'data' => array('status' => true, 'tomorrow' => $tomorrow, 'kode' => $result["jadwal"], 'jadwal' => $result2),
                                            ));
                                        };
                                    }

                                }
                            }else{
                                header('Content-Type: application/json');
                                http_response_code(403);
                                echo json_encode(array(
                                    'status' => false,
                                    'message' => 'Jadwal karyawan libur',
                                ));
                            }
                        } else {
                            header('Content-Type: application/json');
                            http_response_code(403);
                            echo json_encode(array(
                                'status' => false,
                                'message' => 'Jadwal kerja karyawan<br> <b>NIK ' . $nik . '<br> Tanggal ' . $tanggal . '</b><br> tidak ditemukan',
                            ));
                            /*$result = array('status' => false, 'messages' => 'Data Gagal Di Proses Ada Kesalahan Data 2.1');
                            echo json_encode($result);*/
                        }
                    }
                }
            } else {
                $result = array('status' => false, 'messages' => 'Data Gagal Di Proses Ada Kesalahan Data 2.2');
                echo json_encode($result);
            }


        } else {
            $result = array('status' => false, 'messages' => 'Data Gagal Di Proses Ada Kesalahan Data 2.3');
            echo json_encode($result);
        }
    }

    function getJadwal_()
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        if ($data->key == '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO') {
            $dataprocess = $data->body;
            $tanggal = trim($dataprocess->tanggal);
            $nik = trim($dataprocess->nik);

            if (!empty($nik) && !empty($tanggal)) {
                $split = explode("-", $tanggal);
                $tgl = (int)$split[0];
                $bln = $split[1];
                $thn = $split[2];

                $this->db->select('trim(tgl' . $tgl . ") as jadwal");
                $this->db->where('nik', $nik);
                $this->db->where('bulan', $bln);
                $this->db->where('tahun', $thn);
                $query = $this->db->get('sc_trx.listjadwalkerja');
                $result = $query->row_array();

                if ($result) {
                    $this->db->where('trim(kdjam_kerja)', $result["jadwal"]);
                    $query = $this->db->get('sc_mst.jam_kerja');
                    $result2 = $query->row_array();
                    $tomorrow = date('d-m-Y', strtotime($tanggal . ' +1 day'));

                    $result = array('status' => true, 'messages' => 'Sukses', 'tomorrow' => $tomorrow, 'kode' => $result["jadwal"], 'jadwal' => $result2);
                    echo json_encode($result);
                } else {
                    $result = array('status' => false, 'messages' => 'Data Gagal Di Proses Ada Kesalahan Data 2');
                    echo json_encode($result);
                }
            } else {
                $result = array('status' => false, 'messages' => 'Data Gagal Di Proses Ada Kesalahan Data 2');
                echo json_encode($result);
            }


        } else {
            $result = array('status' => false, 'messages' => 'Data Gagal Di Proses Ada Kesalahan Data');
            echo json_encode($result);
        }


    }



}
