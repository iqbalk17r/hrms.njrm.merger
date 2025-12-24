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
        $this->load->library(array('Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Important_class','Fiky_ddos_protector'));
        if($this->session->userdata('nik')){
           redirect('dashboard');
        }
    }
    
    function index(){
		$img_path = './assets/captcha/';
		if (!is_dir($img_path)) {
			mkdir($img_path, 0755, true);
		}
		$vals = array(
			'img_path' => $img_path,
			'img_url' => base_url().$img_path,
			'img_width' => 150,
			'img_height' => 30,
			'border' => 0, 
			'expiration' => 7200
		);
		$cap = create_captcha($vals);
		$capword=md5(strtolower($cap['word']));
		$this->session->set_userdata('keycode',$capword);
        $data['cap'] = $cap['word'];
        $data['currentYear'] = date('Y');
		$data['captcha_img'] = $cap['image'];
        $data['xvw']=$this->m_user->read_validation();
        $data['coldown']=$this->fiky_encryption->timerCountDown();
        //$data['_getviewer']=$this->m_user->insert_log_who_access_web('PAGE_LOGIN');
        //$data['_getmodule']=$this->m_user->insert_log_what_access_modules('PAGE_LOGIN');
        $data['_lchecking']=$this->fiky_encryption->checkDirectLc();
        $data['_checking']=$this->fiky_encryption->checkDirectMac();
        $data['_checking_']=''; //$this->fiky_encryption->checkdelfiles();
        //echo $this->important_class->cobazz();
		
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
				if ($login_data == TRUE)
				{
					$session_data = array
					(				
						'user' =>    trim($login_data['nik']),
						'nama' =>    trim($login_data['username']),
						'lvl' =>     trim($login_data['level_akses']),
						'nik' =>     trim($login_data['nik']),
                        'firstuse' => (trim($username) == $password ? TRUE : FALSE),
						'loccode' => trim($login_data['loccode']),
					);
					$log_data=array(
							'nik' => trim($login_data['nik']),	
							'tgl'=>date("Y-m-d H:i:s"),
							'ip'=>$ip
						);
					$this->session->set_userdata($session_data);
					$this->db->insert("sc_log.log_time",$log_data);
                    $this->m_user->schedular();
                    $this->m_user->cruds();
                    $this->m_user->loginx($log_data);
					$identity=trim($login_data['username']);
					$session_id = $this->session->userdata('session_id');
					$this->db->where('session_id', $session_id);
					$this->db->update('osin_sessions', array('userid' => $identity));
					$this->load->view('template/sidebar',$password);
					redirect('dashboard');
						
				}else{
					//login gagal
					$this->session->set_flashdata('message','Username atau password salah');
					redirect('web');
				}
			}
		}
    }
}
