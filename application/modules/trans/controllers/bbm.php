<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bbm extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_bbm', 'm_absensi', 'master/m_akses'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'Excel_generator'));
        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $branch = $this->input->post('branch');
        $data['kanwil'] = $this->m_bbm->q_kanwil()->result();
        $data['title'] = "Tarikan BBM";
        if ($this->uri->segment(4) == "exist_data")
            $data['message'] = "<div class='alert alert-danger'>Data Sudah Ada</div>";
        else if ($this->uri->segment(4) == "add_success")
            $data['message'] = "<div class='alert alert-success'>Input Data Sukses</div>";
        else if ($this->uri->segment(4) == "fp_success")
            $data['message'] = "<div class='alert alert-success'>Download Data Sukses</div>";
        $this->template->display('trans/bbm/view_filter', $data);
    }

    function list_bbm()
    {
        $data['title'] = "Laporan BBM";
        $tgl = explode(' - ', $this->input->post('tgl'));
        $kdcabang = strtoupper(trim($this->input->post('kanwil')));
        // $callplan = trim($this->input->post('callplan'));
        $callplan = 't';
        if (empty($tgl) or empty($kdcabang)) {
            redirect('trans/bbm');
        }
        $awal = date("Y-m-d", strtotime($tgl[0]));
        $akhir = date("Y-m-d", strtotime($tgl[1]));
        $data['kdcabang'] = $kdcabang;
        $data['callplan'] = $callplan;
        $data['kanwil'] = $this->m_bbm->q_kanwil()->result();
        $data['tgl'] = $this->input->post('tgl');
        $data['tgl1'] = $awal;
        $data['tgl2'] = $akhir;
        $this->db->trans_start();

        // if ($callplan == "t") {
        //     $dtl_opt = $this->m_absensi->q_dblink_option()->row_array();
        //     $host = base64_decode($dtl_opt['c_hostaddr']);
        //     $dbname = base64_decode($dtl_opt['c_dbname']);
        //     $userpg = base64_decode($dtl_opt['c_userpg']);
        //     $passpg = base64_decode($dtl_opt['c_passpg']);
        //     $this->m_bbm->insert_rencana_kunjungan($host, $dbname, $userpg, $passpg, $awal, $akhir);
        // }
        $this->db->query("select sc_tmp.pr_hitung_rekap_bbm('$kdcabang','$awal', '$akhir')");
        $data['list_bbm'] = $this->m_bbm->q_bbm_regu($kdcabang, $awal, $akhir, $callplan)->result();

        $this->db->trans_commit();

        $this->template->display('trans/bbm/view_list_bbm', $data);
    }

    public function excel_bbm($kdcabang, $tgl1, $tgl2, $callplan)
	{
		$nama = $this->session->userdata('nik');
        $cbg = $this->m_bbm->q_kanwil_dtl($kdcabang)->row_array();
        $nmcbg = $cbg['desc_cabang'];
        $jdl = "List Uang BBM Cabang $nmcbg tanggal $tgl1 sampai $tgl2";
        $datane = $this->m_bbm->q_bbm_regu($kdcabang, $tgl1, $tgl2, $callplan);

		$this->excel_generator->set_query($datane);
		$this->excel_generator->set_header(array('NO', 'NIK', 'NAMA', 'DEPARTEMEN', 'JABATAN', 'TANGGAL', 'CHECKTIME', 'KETERANGAN', 'UANG BBM'));
        $this->excel_generator->set_column(array('no', 'nik', 'nmlengkap', 'nmdept', 'nmjabatan', 'tglhari', 'checktime', 'keterangan', 'nominalrp'));
        $this->excel_generator->set_width(array(5, 12, 25, 25, 25, 25, 25, 25, 25));
		$this->excel_generator->exportTo2007("$jdl");
	}

    function rencana_callplan()
    {
        $nik = $this->input->post('nik');
        $tgl = $this->input->post('tgl');

        $output = array(
            "data" => $this->m_bbm->list_rencana_kunjungan($nik, $tgl)->result()
        );

        echo json_encode($output);
    }

    function realisasi_callplan()
    {
        $nik = $this->input->post('nik');
        $tgl = $this->input->post('tgl');

        $data = [];

        foreach ($this->m_bbm->cek_realisasi_kunjungan($nik, $tgl)->result() as $v) {
            $data[] = [
                "no" => null,
                "locationid" => $v->customeroutletcode,
                "locationidlocal" => $v->customercodelocal,
                "custname" => $v->custname,
                "customertype" => $v->customertype,
                "nmcustomertype" => $v->nmcustomertype,
                "checktime" => "<span style=\"width: 45px; float: left;\">" . ($v->checkin ?: "&nbsp;") . "</span>" . " | <span style=\"width: 45px;\">" . ($v->checkout != $v->checkin ? $v->checkout : "&nbsp;") . "</span>",
                "terhitung" => $v->keterangan == 'Y' ? "<i class=\"fa fa-check text-success\"></i>" : "<i class=\"fa fa-times text-danger\"></i>",
                "keterangan" => $v->keterangan == 'Y' ? "Sesuai Callplan" : "Diluar Callplan"
            ];
        }

        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }
}