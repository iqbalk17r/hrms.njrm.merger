<?php
/*
	@author : Junis pusaba
	@recreate : Fiky Ashariza
	12-12-2016
*/
class Web extends MX_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('m_user'));
		$this->load->helper(array('url','captcha'));
        if($this->session->userdata('username')){
           redirect('dashboard');
        }
    }
    
    function index(){
        $vals = array(
			'img_path' => './assets/captcha/',
			'img_url' => base_url().'/assets/captcha/',
			'img_width' => 150,
			'img_height' => 30,
			'border' => 0, 
            'expiration' => 7200
			);
		$cap = create_captcha($vals);
		$capword=md5(strtolower($cap['word']));
		$this->session->set_userdata('keycode',$capword);
		$data['captcha_img'] = $cap['image'];
        $this->load->view('web/web/index',$data);
    }  
    function login(){
        $this->load->view('web/web/login');
    }
    
    function proses(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','required|trim|xss_clean');
        $this->form_validation->set_rules('password','password','required|trim|xss_clean');
		$ip=$_SERVER['REMOTE_ADDR'];
		$captcha =strtolower($this->input->post('captcha'));
        $paramdelallexpired=" and (to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp without time zone-to_timestamp(last_activity)::timestamp without time zone)>='00:03:30'::interval ";
        $this->m_user->deluser($paramdelallexpired);
        if(md5($captcha)<>$this->session->userdata('keycode')){		   
			redirect('web?cap_error=1','refresh');
		} else {	
			if($this->form_validation->run()==false){
				$this->session->set_flashdata('message','Username dan password harus diisi');
				redirect('web');
			}else{
                $username = strtoupper($this->input->post('username'));
				$password = $this->input->post('password');
				$login_data = $this->m_user->cek_user_login($username, $password);
                $useraktif = $this->m_user->useraktif($username)->num_rows();
                $rowexpire = $this->m_user->time_expired_login($username)->num_rows();

				if ($login_data == TRUE) {
				    if($useraktif>0){ //PENAMBAHAN USER AKTIF
                                /* $output = array(
                                     "success"=> 'AKTIF',
                                     "status" => 'AKTIF',
                                     //"url" => 'dashboard',
                                 );
                                 if($rowexpire>0){
                                     /* user expire delete *//*
                                    $paramdel1=" and userid='$username'";
                                    $paramdel2=" and userid='USER'";
                                    $this->m_user->deluser($paramdel1);
                                   // $this->m_user->deluser($paramdel2);
                                } */

                                $this->session->set_flashdata('message','User anda sedang aktif Silahkan Login 2-3 Menit Lagi Jika Tidak Ada Aktifitas');
                                redirect('web');
                    } else {
                                $session_data = array
                                (
                                    'user' => $login_data['nik'],
                                    'nama' => $login_data['username'],
                                    'lvl' => $login_data['level_akses'],
                                    'nik' => $login_data['nik'],
                                );
                                $log_data = array(
                                    'nik' => trim($login_data['nik']),
                                    'tgl' => date("Y-m-d H:i:s"),
                                    'ip' => $ip
                                );
                                $this->session->set_userdata($session_data);
                                $this->db->insert("sc_log.log_time", $log_data);
                                $identity = trim($login_data['username']);
                                $session_id = $this->session->userdata('session_id');
                                $this->db->where('session_id', $session_id);
                                $this->db->update('osin_sessions', array('userid' => $identity));
                                redirect('dashboard');
                            }
						
				} else{
                                //login gagal
                                $this->session->set_flashdata('message','Username atau password salah');
                                redirect('web');
				}
			}
		}
    }
}