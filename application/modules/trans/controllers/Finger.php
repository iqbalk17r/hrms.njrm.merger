<?php defined('BASEPATH') or exit('No direct script access allowed');

class Finger extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('master/m_akses'));
		$this->load->library(array('template', ));
		if (!$this->session->userdata('nik')) {
			redirect(base_url() . '/');
		}
	}
	public function cook() {
        sleep(60 * 2);
        echo 'Ok';
    }
	public function index() {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('m_employee', 'M_Finger'));
        $this->datatablessp->datatable('table-finger', 'table table-striped table-bordered table-hover', true)
            ->columns('userid, username, timestamp, timestampformat, deviceid, devicename')
            ->addcolumn('no', 'no')
            ->querystring($this->M_Finger->q_log_txt_where(' AND TRUE AND (userid IN ( SELECT TRIM(idabsen) FROM sc_mst.karyawan WHERE TRUE ) OR userid IN ( SELECT TRIM(nik) FROM sc_mst.karyawan WHERE TRUE )) '))
            ->header('No.', 'no', false, false, true)
            ->header('<u>U</u>ser', 'userid', true, true, true)
            ->header('<u>N</u>ama', 'username', true, true, true)
            ->header('Waktu', 'timestamp', true, true, true, array('timestampformat', ))
            ->header('ID Mesin', 'deviceid', true, true, true)
            ->header('Nama Mesin', 'devicename', true, true, true);
        $this->datatablessp->generateajax();
        $data['title'] = 'Data Tarikan Mesin Finger';
        $this->template->display('trans/finger/v_read', $data);
	}
}
