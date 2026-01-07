<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uang_makan extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_uang_makan', 'm_absensi', 'master/m_akses'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'Excel_generator'));
        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }


    function index()
    {
        $branch = $this->input->post('branch');
        $data['title'] = "Laporan Absensi Uang Makan";
        $data['kanwil'] = $this->m_uang_makan->q_kanwil()->result();
        $data['regu'] = $this->m_uang_makan->q_regu()->result();
        if ($this->uri->segment(4) == "exist_data")
            $data['message'] = "<div class='alert alert-danger'>Data Sudah Ada</div>";
        else if ($this->uri->segment(4) == "add_success")
            $data['message'] = "<div class='alert alert-success'>Input Data Sukses</div>";
        else if ($this->uri->segment(4) == "fp_success")
            $data['message'] = "<div class='alert alert-success'>Download Data Sukses</div>";
        $this->template->display('trans/uang_makan/view_filter', $data);
    }

    function list_um()
    {
        $data['title'] = "Laporan Absensi Uang Makan";
        $tgl = explode(' - ', $this->input->post('tgl'));
        $kdcabang = strtoupper(trim($this->input->post('kanwil')));
        $borong = trim($this->input->post('borong'));
        $callplan = trim($this->input->post('callplan'));
        if (empty($tgl) or empty($kdcabang)) {
            redirect('trans/uang_makan');
        }
        $awal = date("Y-m-d", strtotime($tgl[0]));
        $akhir = date("Y-m-d", strtotime($tgl[1]));
        $data['kdcabang'] = $kdcabang;
        $data['borong'] = $borong;
        $data['callplan'] = $callplan;
        $data['kanwil'] = $this->m_uang_makan->q_kanwil()->result();
        $data['tgl'] = $this->input->post('tgl');
        $data['tgl1'] = $awal;
        $data['tgl2'] = $akhir;
		//var_dump($data);
        $this->db->trans_start();

        /*if ($callplan == "t") {
            $dtl_opt = $this->m_absensi->q_dblink_option()->row_array();
            $host = base64_decode($dtl_opt['c_hostaddr']);
            $dbname = base64_decode($dtl_opt['c_dbname']);
            $userpg = base64_decode($dtl_opt['c_userpg']);
            $passpg = base64_decode($dtl_opt['c_passpg']);
            $this->m_uang_makan->insert_rencana_kunjungan($host, $dbname, $userpg, $passpg, $awal, $akhir);
        }*/
//        $this->db->query("select sc_tmp.pr_hitung_rekap_um('$kdcabang','$awal', '$akhir')");
//        $this->db->query("select sc_tmp.pr_hitung_rekap_bbm('$kdcabang','$awal', '$akhir')");
//        $this->db->query("select sc_tmp.pr_hitung_rekap_sewakendaraan('$kdcabang','$awal', '$akhir')");

        $cabang_regu = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        if (in_array($kdcabang, $cabang_regu, true)) {
            $data['list_um'] = $this->m_uang_makan->q_uangmakan_regu_old($kdcabang, $awal, $akhir, $callplan, $borong)->result();
            $this->db->trans_commit();
        } else {
            $data['list_um'] = $this->m_uang_makan->q_uangmakan_regu_old($kdcabang, $awal, $akhir, $callplan, $borong)->result();
            $this->db->trans_commit();
        }

        $this->template->display('trans/uang_makan/view_absensi', $data);
    }
    function list_um_regenerate($param)
    {
        $json = json_decode(hex2bin($param));
        $kdcabang = $json->kdcabang;
        $tgl1 = $json->tgl1;
        $tgl2 = $json->tgl2;
        $borong = $json->borong;
        $callplan = $json->callplan;
        $tgl = $json->tgl;
        $data['title'] = "Laporan Absensi Uang Makan";
        if (empty($tgl) or empty($kdcabang)) {
            redirect('trans/uang_makan');
        }
        $awal = date("Y-m-d", strtotime($tgl1));
        $akhir = date("Y-m-d", strtotime($tgl2));
        $data['kdcabang'] = $kdcabang;
        $data['borong'] = $borong;
        $data['callplan'] = $callplan;
        $data['kanwil'] = $this->m_uang_makan->q_kanwil()->result();
        $data['tgl'] = $json->tgl;
        $data['tgl1'] = $awal;
        $data['tgl2'] = $akhir;
        $this->db->trans_start();

        if ($callplan == "t") {
        $dtl_opt = $this->m_absensi->q_dblink_option()->row_array();
            $host = base64_decode($dtl_opt['c_hostaddr']);
            $dbname = base64_decode($dtl_opt['c_dbname']);
            $userpg = base64_decode($dtl_opt['c_userpg']);
            $passpg = base64_decode($dtl_opt['c_passpg']);
            $this->m_uang_makan->insert_rencana_kunjungan($host, $dbname, $userpg, $passpg, $awal, $akhir);
        }

        $cabang_regu = ['01','02','03','04','05','06','07','08','09','10','11','12'];

        if (in_array($kdcabang, $cabang_regu, true)) {
            $this->m_uang_makan->generate_meal_allowance($kdcabang, $awal, $akhir);
            $data['list_um'] = $this->m_uang_makan->q_uangmakan_regu_njrm($kdcabang, $awal, $akhir, $callplan, $borong)->result();
            $this->db->trans_commit();
        } else {
            $this->db->query("select sc_tmp.pr_hitung_rekap_um('$kdcabang','$awal', '$akhir')");
            $data['list_um'] = $this->m_uang_makan->q_uangmakan_regu($kdcabang, $awal, $akhir, $callplan, $borong)->result();
            $this->db->trans_commit();
        }
        $this->template->display('trans/uang_makan/view_absensi', $data);
    }

    function pdf()
    {
        $kdcabang = $this->input->post('kdcabang');
        $tgl = explode(' - ', $this->input->post('tgl'));
        $borong = $this->input->post('borong');
        $callplan = $this->input->post('callplan');
        if (empty($tgl) or empty($kdcabang)) {
            redirect('trans/uang_makan');
        }
        $tglawal = $tgl[0];
        $tglakhir = $tgl[1];
        $awal = date("Y-m-d", strtotime($tgl[0]));
        $akhir = date("Y-m-d", strtotime($tgl[1]));
        $data['tgl1'] = $tglawal;
        $data['tgl2'] = $tglakhir;
        $data['kdcabang'] = $kdcabang;

        $judul = $this->m_uang_makan->q_kanwil_dtl($kdcabang)->row_array();
        $jdl = trim($judul['desc_cabang']) . ($borong == "t" ? " (Borong)" : ($callplan == "t" ? " (Callplan)" : ""));
        $data['cabang'] = trim($judul['desc_cabang']) . ($borong == "t" ? " (Borong)" : ($callplan == "t" ? " (Callplan)" : ""));
        $data['callplan'] = $callplan;

        $cabang_regu = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        if (in_array($kdcabang, $cabang_regu, true)) {
            $data['list_um'] = $this->m_uang_makan->q_uangmakan_regu_njrm($kdcabang, $awal, $akhir, $callplan, $borong)->result();
         } else {
            $data['list_um'] = $this->m_uang_makan->q_uangmakan_regu($kdcabang, $awal, $akhir, $callplan, $borong)->result();
        }

        $this->pdf->load_view('trans/uang_makan/view_pdf', $data);
        $this->pdf->set_paper('A4', 'potrait');
        $this->pdf->render();
        $this->pdf->stream("Laporan Absensi $jdl $tglawal Hingga $tglakhir.pdf");

        //$this->load->view('trans/uang_makan/view_pdf',$data);
    }

    function json_uangmakan($kdcabang, $awal, $akhir)
    {
        $nama = $this->session->userdata('nama');
        header('Content-Type: application/json');
        echo json_encode(array(
            'uangmakan' => $this->m_uang_makan->q_uangmakan_absensi_json($kdcabang, $awal, $akhir, $nama)->result(),
            'mstuangmakan' => $this->m_uang_makan->q_uangmakan_mst_json($kdcabang, $awal, $akhir, $nama)->result(),
        ), JSON_PRETTY_PRINT);

    }

    function cetak_uangmakan($kdcabang, $awal, $akhir)
    {
        $data['jsonfile'] = "trans/uang_makan/json_uangmakan/$kdcabang/$awal/$akhir";
        $data['report_file'] = 'assets/mrt/rpt_uangmakan.mrt';
        $this->load->view("trans/uang_makan/sti_uangmakan", $data);
    }

    public function excel_absensi_new($kdcabang, $awal, $akhir, $borong, $callplan)
    {
        $judul = $this->m_uang_makan->q_kanwil_dtl($kdcabang)->row_array();
        $jdl = trim($judul['desc_cabang']) . ($borong == "t" ? " (Borong)" : ($callplan == "t" ? " (Callplan)" : ""));
        $tglawal = date("d-m-Y", strtotime($awal));
        $tglakhir = date("d-m-Y", strtotime($akhir));
        //$datane = $this->m_uang_makan->q_uangmakan_regu($kdcabang, $awal, $akhir, $callplan, $borong);
        //$this->excel_generator->set_query($datane);


        //$data = $this->m_uang_makan->q_kanwil();
        $data = $this->db->query('select nik, username from sc_mst.user limit 50');
        $this->excel_generator->set_query($data);

        $this->excel_generator->set_header(array('NIK', 'NAMA'));
        $this->excel_generator->set_column(array('nik', 'username'));
        $this->excel_generator->set_width(array(50, 50));

        $this->excel_generator->exportTo2007("tes");
        //$this->excel_generator->exportTo2007("Laporan Absensi $jdl $tglawal Hingga $tglakhir");
    }

    public function excel_absensi($kdcabang, $awal, $akhir, $borong, $callplan)
    {
        $judul = $this->m_uang_makan->q_kanwil_dtl($kdcabang)->row_array();
        $jdl = trim($judul['desc_cabang']) . ($borong == "t" ? " (Borong)" : ($callplan == "t" ? " (Callplan)" : ""));
        $tglawal = date("d-m-Y", strtotime($awal));
        $tglakhir = date("d-m-Y", strtotime($akhir));
        $cabang_regu = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        if (in_array($kdcabang, $cabang_regu, true)) {
            $datane = $this->m_uang_makan->q_uangmakan_regu_njrm($kdcabang, $awal, $akhir, $callplan, $borong)->result();
         } else {
        $datane = $this->m_uang_makan->q_uangmakan_regu($kdcabang, $awal, $akhir, $callplan, $borong);
        }
        $this->excel_generator->set_query($datane);

        if ($callplan == "t") {
            $this->excel_generator->set_header(array('NO', 'NIK', 'NAMA', 'DEPARTEMEN', 'JABATAN', 'TANGGAL', 'CHECKTIME', 'CALLPLAN', 'REALISASI', 'KETERANGAN', 'UANG MAKAN', 'BBM', 'SEWA KENDARAAN', 'SUB TOTAL'));
            $this->excel_generator->set_column(array('no', 'nik', 'nmlengkap', 'nmdept', 'nmjabatan', 'tglhari', 'checktime', 'rencanacallplan', 'realisasicallplan', 'keterangan', 'nominalrp', 'bbm', 'sewa_kendaraan', 'subtotal'));
            $this->excel_generator->set_width(array(5, 12, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25));
        } else {
            $this->excel_generator->set_header(array('NO', 'NIK', 'NAMA', 'DEPARTEMEN', 'JABATAN', 'TANGGAL', 'CHECKTIME', 'KETERANGAN', 'UANG MAKAN', 'BBM', 'SEWA KENDARAAN', 'SUB TOTAL'));
            $this->excel_generator->set_column(array('no', 'nik', 'nmlengkap', 'nmdept', 'nmjabatan', 'tglhari', 'checktime', 'keterangan', 'nominalrp', 'bbm', 'sewa_kendaraan', 'subtotal'));
            $this->excel_generator->set_width(array(5, 12, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25));
        }

        $this->excel_generator->exportTo2007("Laporan Absensi $jdl $tglawal Hingga $tglakhir");
    }

    public function excel_realisasi($kdcabang, $awal, $akhir)
    {
        $judul = $this->m_uang_makan->q_kanwil_dtl($kdcabang)->row_array();

        $jdl = trim($judul['desc_cabang']);
        $tglawal = date("d-m-Y", strtotime($awal));
        $tglakhir = date("d-m-Y", strtotime($akhir));
        $datane = $this->m_uang_makan->list_realisasi_kunjungan_all($kdcabang, $awal, $akhir);
        $this->excel_generator->set_query($datane);

        $this->excel_generator->set_header(array('NO', 'NIK', 'NAMA', 'DEPARTEMEN', 'JABATAN', 'TANGGAL', 'KODE CUSTOMER', 'CUSTOMER NOO', 'NAMA CUSTOMER', 'TIPE CUSTOMER', 'CHECKTIME', 'TERHITUNG'));
        $this->excel_generator->set_column(array('no', 'nik', 'nmlengkap', 'nmdept', 'nmjabatan', 'tgl', 'customeroutletcode', 'customercodelocal', 'custname', 'nmcustomertype', 'checktime', 'terhitung'));
        $this->excel_generator->set_width(array(5, 12, 25, 25, 25, 25, 25, 25, 25, 25, 25, 12));

        $this->excel_generator->exportTo2007("Laporan Realisasi Callplan $jdl $tglawal Hingga $tglakhir.pdf");
    }

    function tarik()
    {
        $data['title'] = "Tarik Data Absensi";
        $data['fingerprintwil'] = $this->m_uang_makan->q_idfinger()->result();
        $this->template->display('hrd/absensi/view_tarikfp', $data);
    }


    function add_finger()
    {
        $idfinger = $this->input->post('fingerid');
        $wil = strtoupper($this->input->post('wilayah'));
        $ip = $this->input->post('ipaddress');
        $cek = $this->m_hrd->cek_finger($idfinger, $ip, $wil);
        echo $cek->num_rows();
        /*
        if($cek->num_rows()>0){
            echo 'aa';
            //redirect('hrd/absensi/index/exist_data');
        } else {
        */
        $info_finger = array('fingerid' => $idfinger,
            'wilayah' => $wil,
            'ipaddress' => $ip
        );
        $this->m_hrd->simpan_finger($info_finger);
        redirect('hrd/absensi/index/add_success');
        /*
        }
        */
    }

    function edit_finger()
    {
        $idfinger = $this->input->post('fingerid');
        $wil = strtoupper($this->input->post('wilayah'));
        $ip = $this->input->post('ipaddress');
        $info_finger = array('fingerid' => $idfinger,
            'wilayah' => $wil,
            'ipaddress' => $ip
        );
        $this->m_hrd->edit_finger($info_finger, $ip);
        redirect('hrd/absensi/index/add_success');
    }

    function tarik_userfp($ipne)
    {
        $branch = $this->input->post('branch');
        $data['title'] = "Tarik Data Absensi";
        //$ipne='192.168.0.222';
        $aq = $this->absen->tarik($ipne);
        if (empty($aq)) {
            redirect('hrd/absensi/index/fp_success');
        } else {
            redirect('hrd/absensi/index/fp_gagal');
        }
    }

    function tarik_logfp($ipne)
    {
        $branch = $this->input->post('branch');
        $data['title'] = "Tarik Data Absensi";
        //$ipne='192.168.0.222';
        $aq = $this->absen->logfp($ipne);
        exec("ping -n 4 $ipne 2>&1", $output, $retval);
        if ($retval != 0) {
            echo "DISCONNECT!";
            redirect('hrd/absensi/index/fp_gagal');
        } else {
            echo "CONNECTED!";
            redirect('hrd/absensi/index/fp_success');
        }
        /*
        if (empty($aq)) {
            redirect('hrd/absensi/index/fp_success');
        } else {
            redirect('hrd/absensi/index/fp_gagal');
        }
        */
    }

    function cek_koneksifp()
    {
        $ip = "192.168.0.221";
        //$_SERVER["192.168.0.222"];
        //exec("ping -n 4 $ip 2>&1", $output, $retval);
        exec("ping $ip ", $output, $retval);
        if ($retval != 0) {
            echo "DISCONNECT!";
        } else {
            echo "CONNECTED!";
        }
    }

    public function excel07()
    {
        $datane = $this->m_rkap->q_absensi($branch, $awal, $akhir);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('nama', 'checktime'));
        $this->excel_generator->set_column(array('nama', 'checktime'));
        $this->excel_generator->set_width(array(10, 15));
        $this->excel_generator->exportTo2007('Laporan Absensi');
    }

    function rencana_callplan()
    {
        $nik = $this->input->post('nik');
        $tgl = $this->input->post('tgl');

        $output = array(
            "data" => $this->m_uang_makan->list_rencana_kunjungan($nik, $tgl)->result()
        );

        echo json_encode($output);
    }

    function realisasi_callplan()
    {
        $nik = $this->input->post('nik');
        $tgl = $this->input->post('tgl');

        $data = [];
        foreach ($this->m_uang_makan->list_realisasi_kunjungan($nik, $tgl)->result() as $v) {
            $data[] = [
                "no" => null,
                "locationid" => $v->customeroutletcode,
                "locationidlocal" => $v->customercodelocal,
                "custname" => $v->custname,
                "customertype" => $v->customertype,
                "nmcustomertype" => $v->nmcustomertype,
                "checktime" => "<span style=\"width: 45px; float: left;\">" . ($v->checkin ?: "&nbsp;") . "</span>" . " | <span style=\"width: 45px;\">" . ($v->checkout != $v->checkin ? $v->checkout : "&nbsp;") . "</span>",
                "terhitung" => ($v->customertype == "C" AND !is_null($v->schedule_location)) ? "<i class=\"fa fa-check text-success\"></i>" : "<i class=\"fa fa-times text-danger\"></i>"
            ];
        }

        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }
}
