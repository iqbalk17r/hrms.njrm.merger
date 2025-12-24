<?php

class Tracking extends MX_Controller {
    function __construct(){
        parent::__construct();
		$this->load->model(['m_tracking']);
        $this->load->library(['form_validation', 'template', 'upload', 'pdf']);
		 if(!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }
	function index() {
		$data['title'] = "Tracking Dokumen";
        $paramtrx = "";
        $data['tglrange'] = $this->input->post('tglrange');
        if($data['tglrange']) {
            $tgl = explode(" - ", $this->input->post('tglrange'));
            $paramtrx .= " AND docdate::DATE BETWEEN '" . date("Y-m-d", strtotime($tgl[0])) . "'::DATE AND '" . date("Y-m-d", strtotime($tgl[1])) . "'::DATE";
        }
		$data['list_tracking'] = $this->m_tracking->q_tracking($paramtrx)->result();
		$this->template->display('trans/tracking/v_tracking',$data);
    }
}
