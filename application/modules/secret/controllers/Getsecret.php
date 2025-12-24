<?php

class Getsecret extends MX_Controller
{

    private $branchId = 'BBTSNI';
    private $userId;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('secret/M_Secret','web/m_user'));
        $this->load->library(array(
//            'secret',
            'session'
        ));
    }

    public function index($secretid)
    {

        $this->load->library(array('fiky_encryption'));
        $secret = $this->M_Secret->q_transaction_read(" AND secret_id = '{$secretid}' AND actived ")->row();
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($secret)) {
            $userdata = $this->M_Secret->q_master_user_read(' AND nik = \''.$secret->employee_id.'\' ')->row();
            if (!empty($userdata)) {
                $this->load->library('session');
                $session_data = array
                (
                    'user'    => $userdata->nik,
                    'nama'    => $userdata->username,
                    'lvl'     => $userdata->level_akses,
                    'nik'     => $userdata->nik,
                    'loccode' => $userdata->loccode,
                    'secretid'  => $secretid
                );
                $log_data = array(
                    'nik' => trim($userdata->nik),
                    'tgl' => date("Y-m-d H:i:s"),
                    'ip' => $ip
                );
                $this->session->set_userdata($session_data);
                $this->db->insert("sc_log.log_time", $log_data);
//                $this->m_user->cruds();
                $this->m_user->loginx($log_data);
                /*$this->M_Secret->q_transaction_update(array(
                    'actived'=> FALSE,
                    'update_by' => $userdata->nik,
                    'update_date' => date('Y-m-d H:i:s'),
                ),array(
                    'employee_id' => $userdata->nik,
                    'secret_id' => $secretid,
                ));*/
                redirect($secret->url);
            }else{
                redirect('s/invalid');
            }
        }else{
            redirect('s/invalid');
        }

    }

    public function invalidurl()
    {
        $this->load->view('secret/v_invalid',array());
    }


}