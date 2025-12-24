<?php

class Migrate extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model(["master/m_akses"]);
        $this->load->library(["migration"]);
        $nik = trim($this->session->userdata("nik"));
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $level_akses = strtoupper(trim($userinfo["level_akses"]));
        if(empty($nik) || empty($level_akses) || !in_array($_SERVER["REMOTE_ADDR"], ["127.0.0.1", "::1"])) {
            redirect("dashboard");
        }
    }

    public function index() {
        if($this->migration->current() === FALSE) {
            echo $this->migration->error_string();
        }
    }
}
