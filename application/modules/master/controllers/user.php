<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class User extends MX_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model(array('m_user','m_menu','m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf'));

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

    function index(){
        $this->load->helper('user');
        $data['title']="Master User";
        $data['message']="";
		$data['list_user']=$this->m_user->list_user()->result();
		$data['list_kary']=$this->m_user->list_karyawan()->result();
		$data['list_lvljbt']=$this->m_user->list_lvljbt()->result();
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="success"){
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(4)=="notacces"){
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(4)=="del"){
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/user/v_user',$data);
    }

	function edit($nik,$username){
		if (empty($nik)){
			redirect('master/user/');
		} else {
			$data['title']='EDIT DATA USER';
			if($this->uri->segment(6)=="upsuccess"){
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
			$data['list_lvljbt']=$this->m_user->list_lvljbt()->result();
			//$this->template->display('master/user/v_edituser',$data);
			$this->template->display('master/user/v_edituser',$data);
		}
	}

	function editprofile($nik,$username){

		if (empty($nik)){
			redirect('dashboard');
		} else {
			$data['title']='UBAH PASSWORD USER';
			if($this->uri->segment(5)=="upsuccess"){
				$data['message']="<div class='alert alert-success'>Password Berhasil Diubah </div>";
				///redirect('dashboard/logout');
			}
			else if($this->uri->segment(5)=="pwnotmatch"){

				$data['message']="<div class='alert alert-danger'>PASSWORD Tidak Sama </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
			$this->template->display('master/user/v_editprofile',$data);
		}

	}


	function edit_akses($nik,$username,$kodemenu){
		if (empty($nik)){
			redirect('master/user/akses/');
		} else {
			$data['title']='EDIT DATA AKSES USER';
			if($this->uri->segment(5)=="upsuccess"){
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
			$data['akses']=$this->m_akses->detail_user_akses($nik,$kodemenu)->row_array();
			$this->template->display('master/user/v_edit_aksesuser',$data);
		}
	}

	function hps($nik,$username){
		$this->db->where('nik',$nik);
		$this->db->where('username',$username);
		$this->db->delete('sc_mst.user');
		redirect('master/user/index/del');
	}

	function hps_akses($nik,$kodemenu){
		$this->db->where('nik',$nik);
		$this->db->where('kodemenu',$kodemenu);
		$this->db->delete('sc_mst.akses');
		redirect("master/user/akses/$nik/del");
	}

	function akses($nik,$username){
		$data['title']="HAK AKSES USER $nik";
		$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
		$data['list_akses']=$this->m_akses->list_akses($nik,$username)->result();
		$data['list_menu']=$this->m_akses->list_menu($nik,$username)->result();
		$data['nik']=$nik;
		$data['username']=$username;
		if($this->uri->segment(5)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(5)=="success"){
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(6)=="upsuccess"){
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(5)=="notacces"){
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(5)=="del"){
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/user/v_akses_user',$data);
	}

	function save_akses(){
		$nik=strtoupper(trim($this->input->post('nik')));
		$username=strtoupper(trim($this->input->post('username')));
		$menu=trim($this->input->post('menu'));
		$hold=$this->input->post('hold');
		$view=$this->input->post('view');
		$input=$this->input->post('input');
		$update=$this->input->post('update');
		$delete=$this->input->post('delete');
		$approve=$this->input->post('approve');
		$approve2=$this->input->post('approve2');
		$approve3=$this->input->post('approve3');
		$convert=$this->input->post('convert');
		$print=$this->input->post('print');
		$download=$this->input->post('download');
		$tipe=$this->input->post('tipe');
		$filter=$this->input->post('aksesfilter');

		if ($tipe=='input'){
			$info_input=array(
				'nik'=>$nik,
				'username'=>$username,
				'kodemenu'=>$menu,
				'hold_id'=>$hold,
				'aksesview'=>$view,
				'aksesinput'=>$input,
				'aksesupdate'=>$update,
				'aksesdelete'=>$delete,
				'aksesapprove'=>$approve,
				'aksesapprove2'=>$approve2,
				'aksesapprove3'=>$approve3,
				'aksesconvert'=>$convert,
				'aksesprint'=>$print,
				'aksesdownload'=>$download,
				'aksesfilter'=>$filter

			);
			$cek=$this->m_akses->cek_input_akses($nik,$menu,$username);
			if ($cek>0){
				redirect("master/user/akses/$nik/exist");
			} else {
				$this->db->insert('sc_mst.akses',$info_input);
				redirect("master/user/akses/$nik/$username/upsuccess");
			}
		} else if ($tipe=='edit'){
			$info_update=array(
				'hold_id'=>$hold,
				'aksesview'=>$view,
				'aksesinput'=>$input,
				'aksesupdate'=>$update,
				'aksesdelete'=>$delete,
				'aksesapprove'=>$approve,
				'aksesapprove2'=>$approve2,
				'aksesapprove3'=>$approve3,
				'aksesconvert'=>$convert,
				'aksesprint'=>$print,
				'aksesdownload'=>$download,
				'aksesfilter'=>$filter
			);
			$this->m_akses->update_akses($nik,$menu,$info_update,$username);
			redirect("master/user/akses/$nik/$username/upsuccess");
		}
	}

	function save(){
		$tipe=$this->input->post('tipe');
		//$splituser=explode('|',$this->input->post('user'));
		//$nik=strtoupper(trim($splituser[0]));
		$nik=$this->input->post('nik');
		$username=strtoupper(trim($this->input->post('username')));
		$password=trim($this->input->post('passwordweb'));
		$lvlid=strtoupper(trim($this->input->post('lvlid')));
		$lvlakses=strtoupper(trim($this->input->post('lvlakses')));
		$initial=strtoupper(trim($this->input->post('initial')));


		$expdate=$this->input->post('expdate');
		$hold=$this->input->post('hold');
		$cek_user=$this->m_user->cek_user($username)->num_rows();
		if ($tipe=='input') {
			if ($cek_user>0){
				redirect('master/user/index/exist');
			} else {
				$info_input=array(
					'branch'=>'SBYNSA',
					'nik'=>$nik,
					'username'=>$username,
					'passwordweb'=>$password,
					'level_id'=>$lvlid,
					'level_akses'=>$lvlakses,
					'expdate'=>$expdate,
					'initial'=>$initial,
					'hold_id'=>$hold,
					'image'=>'admin.jpg',
					'inputdate'=>date('d-m-Y'),
					'inputby'=>$this->session->userdata('nik')
				);
				$this->db->insert('sc_mst.user',$info_input);
				echo 'CEK';
				redirect('master/user/index/success');
			}
		} else if ($tipe=='edit'){
            $this->load->model(array('master/M_UserSidia'));
            $this->load->library(array('generatepassword'));
			if (empty($password) or $password==''){
				$info_edit1=array(
					'expdate'=>$expdate,
                    'initial'=>$initial,
					'hold_id'=>$hold,
					'level_id'=>$lvlid,
					'level_akses'=>$lvlakses,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->where('username',$username);
				$this->db->update('sc_mst.user',$info_edit1);

                $this->M_UserSidia->q_transaction_update(array(
                    'hold' => ($hold == 'Y' ? 'Yes' : 'No'),
                    'updatedate' => date('Y-m-d H:i:s'),
                    'updateby' => trim($this->session->userdata('nik')),
                ),array(
                    'trim(nik)' => trim($nik),
                    'trim(userid)' => trim($nik),
                ));
				redirect("master/user/edit/$nik/$username/upsuccess");
			} else {
                $passwordGenerate = $this->generatepassword->sidia($password, TRUE);
				$info_edit2=array(
					'passwordweb'=>md5($password),
					'expdate'=>$expdate,
                    'initial'=>$initial,
					'hold_id'=>$hold,
					'level_id'=>$lvlid,
					'level_akses'=>$lvlakses,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->where('username',$username);
				$this->db->update('sc_mst.user',$info_edit2);
                $this->M_UserSidia->q_transaction_update(array(
                    'password' => $passwordGenerate,
                    'hold' => ($hold == 'Y' ? 'Yes' : 'No'),
                    'updatedate' => date('Y-m-d H:i:s'),
                    'updateby' => trim($this->session->userdata('nik')),
                ),array(
                    'trim(nik)' => trim($nik),
                    'trim(userid)' => trim($nik),
                ));
				redirect("master/user/edit/$nik/$username/upsuccess");
			}
		} else {
			redirect('master/user/index/notacces');
		}

	}


	function saveprofile(){
        $this->load->model(array('master/M_UserSidia'));
        $this->load->library(array('generatepassword'));
		$tipe=$this->input->post('tipe');
		$splituser=explode('|',$this->input->post('user'));
		$nik=strtoupper(trim($splituser[0]));
		$nama=strtoupper(trim($splituser[1]));
		$password=$this->input->post('passwordweb');
		$password2=$this->input->post('passwordweb2');
		$expdate=$this->input->post('expdate');
		$hold=$this->input->post('hold');
		$cek_user=$this->m_user->cek_user($nik);
		if ($tipe=='input') {
			/*if ($cek_user>0){
				redirect('master/user/index/exist');
			} else {
				$info_input=array(
					'nik'=>$nik,
					'username'=>$nama,
					'passwordweb'=>$password,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'inputdate'=>date('d-m-Y'),
					'inputby'=>$this->session->userdata('nik')
				);
				$this->db->insert('sc_mst.user',$info_input);
				echo 'CEK';
				redirect('master/user/saveprofile/success');
			} */
		} else if ($tipe=='edit'){
			if ($password<>$password2){

				redirect("master/user/editprofile/$nik/$nama/pwnotmatch");

			}
			if (empty($password) or $password==''){
				$info_edit1=array(
					//'expdate'=>$expdate,
					//'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit1);
				redirect("master/user/editprofile/$nik/$nama/upsuccess");
			} else {
                $passwordGenerate = $this->generatepassword->sidia($password, TRUE);
				$info_edit2=array(
					'passwordweb'=>md5($password),
					//'expdate'=>$expdate,
					//'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit2);
                $this->M_UserSidia->q_transaction_update(array(
                    'password' => $passwordGenerate,
                    'updatedate' => date('Y-m-d H:i:s'),
                    'updateby' => trim($this->session->userdata('nik')),
                ),array(
                    'trim(nik)' => trim($nik),
                    'trim(userid)' => trim($nik),
                ));
				redirect("master/user/editprofile/$nik/$nama/upsuccess");
			}
		} else {
			redirect('master/user/index/notacces');
		}
	}

	function input_view_akses($nik,$username){
		$data['title']="INPUT HAK AKSES USER $nik $username";
		$data['title1']="MENU PROGRAM";
		$data['title2']="MENU PROGRAM USER $username";
		$data['nik']=$nik;
		$data['username']=$username;
		$data['list_menu_child']=$this->m_user->q_childmenu($nik,$username)->result();
		$data['list_menu_user']=$this->m_user->q_childmenu_usertmp($nik,$username)->result();
		$data['cek_user']=$this->m_user->cek_tmp_akses($nik,$username)->num_rows();
		$this->template->display('master/user/v_akses_user_grid',$data);

	}

	function tambah_menu(){
        $this->db->cache_delete('master', 'user');

		$lb=$this->input->post('centang');
		$nik=$this->input->post('nik');
		$username=$this->input->post('username');

		if(empty($lb)){
			redirect("master/user/");
		}
		foreach($lb as $index => $temp){
			$kdmenu=trim($lb[$index]);
			//$lihat_nik=$this->m_dinas->list_karyawan_index($nik)->row_array();
			$info[$index]['nik']=$nik;
			$info[$index]['kodemenu']=$kdmenu;
			$info[$index]['hold_id']='t';
			$info[$index]['aksesview']='t';
			$info[$index]['aksesinput']='t';
			$info[$index]['aksesupdate']='t';
			$info[$index]['aksesdelete']='t';
			$info[$index]['aksesapprove']='t';
			$info[$index]['aksesconvert']='t';
			$info[$index]['aksesprint']='t';
			$info[$index]['aksesdownload']='t';
			$info[$index]['aksesapprove2']='t';
			$info[$index]['aksesapprove3']='t';
			$info[$index]['aksesfilter']='t';
			$info[$index]['username']=$username;

		}

			$insert = $this->m_user->add_kdmnu_tmp($info);
			redirect("master/user/input_view_akses/$nik/$username");
	}

	function kurangi_menu(){
        $this->db->cache_delete('master', 'user');
		$lb=$this->input->post('centang');
		$nik=$this->input->post('nik');
		$username=$this->input->post('username');

		if(empty($lb)){
			redirect("master/user/");
		}
		foreach($lb as $index => $temp){
			$kdmenu=trim($lb[$index]);
			//$lihat_nik=$this->m_dinas->list_karyawan_index($nik)->row_array();
			$info[$index]['nik']=$nik;
			//$info[$index]['kodemenu']=$kdmenu;
			//$info[$index]['username']=$username;
			$this->db->delete('sc_mst.akses', array('kodemenu' => $kdmenu,'nik' => $nik,'username' => $username));
			$this->db->delete('sc_tmp.akses', array('kodemenu' => $kdmenu,'nik' => $nik,'username' => $username));
		}

		//$this->db->where('IN ('.implode(',',$kdmenu).')', NULL, FALSE);
		//$this->db->delete('sc_mst.akses', $info = array());
		//$this->db->delete('sc_tmp.akses', $info = array());
		//$delete = $this->m_user->remove_kdmnu_tmp($info);
		redirect("master/user/input_view_akses/$nik/$username");
	}

	function add_menugrid($nik,$username){
		$this->m_user->fl_akses($nik,$username);
		$this->m_user->deltmp_akses($nik,$username);
        $this->db->cache_delete_all();
        $path = "./application/cache/";
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        };
		redirect("master/user/akses/$nik/$username");
	}

    public function resetpassword($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/m_akses'));
        $userhr = $this->m_akses->list_aksesperdep()->num_rows() > 0;
        $levelA = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A';
        header('Content-Type: application/json');
        if ($userhr OR $levelA){
            http_response_code(200);
            echo json_encode(array(
                'data' => array('nik'=>trim($json->nik)),
                'canreset' => true,
                'next' => site_url('master/user/doresetpassword/'.bin2hex(json_encode(array('nik'=>trim($json->nik),'action'=>'reset')))),
            ));
        }else{
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'canreset' => false,
                'message' => 'Anda tidak memiliki akses untuk melakukan ini!'
            ));
        }

    }

    public function doresetpassword($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/m_akses','master/M_UserSidia'));
        $this->load->library(array('generatepassword'));
        header('Content-Type: application/json');
        $userhr = $this->m_akses->list_aksesperdep()->num_rows() > 0;
        $levelA = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A';
        header('Content-Type: application/json');
        if ($userhr OR $levelA){
            $user = $this->m_user->q_user_read_where(' AND nik = \''.$json->nik.'\' ')->row();
//            var_dump(md5(trim($user->nik)));die();
            if (!empty($user)){
                if (strtoupper($user->hold_id) == 'N' ){
                    $this->m_user->q_transaction_update(array(
                        'passwordweb' => md5(trim($user->nik)),
                    ),array(
                        'trim(nik)' => trim($user->nik),
                        'trim(username)' => trim($user->username),
                    ));
                    if ($this->M_UserSidia->q_transaction_exists(' TRUE AND userid = \''.$user->nik.'\' OR nik = \''.$user->nik.'\' ')){
                        $passwordGenerate = $this->generatepassword->sidia($user->nik, TRUE);
                        $this->M_UserSidia->q_transaction_update(array(
                            'password' => $passwordGenerate,
                            'updatedate' => date('Y-m-d H:i:s'),
                            'updateby' => trim($this->session->userdata('nik')),
                        ),array(
                            'trim(nik)' => trim($user->nik),
                            'trim(userid)' => trim($user->nik),
                        ));
                    }
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Kata sandi berhasil direset',
                    ));
                }else{
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'User tidak aktif',
                    ));
                }
            }else{
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'User tidak ditemukan'
                ));
            }
        }else{
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Anda tidak memiliki akses untuk melakukan ini!'
            ));
        }
    }

    public function firstUpdatePassword()
    {
        $this->load->model(array('master/M_UserSidia'));
        $this->load->library(array('generatepassword'));
        $tipe=$this->input->post('tipe');
        $splituser=explode('|',$this->input->post('user'));
        $nik=strtoupper(trim($splituser[0]));
        $nama=strtoupper(trim($splituser[1]));
        $password=strtoupper($this->input->post('passwordweb'));
        $password2=strtoupper($this->input->post('passwordweb2'));
        $passwordGenerate = $this->generatepassword->sidia($password, TRUE);
        $info_edit2 = array(
            'passwordweb' => md5($password),
            'editdate' => date('d-m-Y'),
            'editby' => $this->session->userdata('nik')
        );
        $this->db->where('nik', $nik);
        $this->db->update('sc_mst.user', $info_edit2);
        $this->M_UserSidia->q_transaction_update(array(
            'password' => $passwordGenerate,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateby' => trim($this->session->userdata('nik')),
        ),array(
            'trim(nik)' => trim($nik),
            'trim(userid)' => trim($nik),
        ));
        $this->session->set_userdata(array(
            'firstuse' => (md5(trim($nik)) == md5($password) ? TRUE : FALSE),
        ));
    }

    public function giveaccesssidia($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/m_akses'));
        $userhr = $this->m_akses->list_aksesperdep()->num_rows() > 0;
        $levelA = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A';
        header('Content-Type: application/json');
        if ($userhr OR $levelA){
            http_response_code(200);
            echo json_encode(array(
                'data' => array('nik'=>trim($json->nik)),
                'canupdate' => true,
                'next' => site_url('master/user/dogiveaccess/'.bin2hex(json_encode(array('nik'=>trim($json->nik),'action'=>'give-access')))),
            ));
        }else{
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'canreset' => false,
                'message' => 'Anda tidak memiliki akses untuk melakukan ini!'
            ));
        }

    }
    public function dogiveaccess($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('master/m_akses','master/M_UserSidia'));
        $this->load->library(array('generatepassword'));
        $userhr = $this->m_akses->list_aksesperdep()->num_rows() > 0;
        $levelA = strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A';
        header('Content-Type: application/json');
        if ($userhr OR $levelA){
            $user = $this->m_user->q_user_read_where(' AND nik = \''.$json->nik.'\' ')->row();
//            var_dump(md5(trim($user->nik)));die();
            if (!empty($user)){
                if (strtoupper($user->hold_id) == 'N' ){
                    if ($this->M_UserSidia->q_transaction_exists(' TRUE AND userid = \''.$user->nik.'\' OR nik = \''.$user->nik.'\' ')){
                        $this->M_UserSidia->q_transaction_update(array(
                            'hold' => 'No',
                            'updatedate' => date('Y-m-d H:i:s'),
                            'updateby' => trim($this->session->userdata('nik')),
                        ),array(
                            'trim(nik)' => trim($user->nik),
                            'trim(userid)' => trim($user->nik),
                        ));
                    }
                    http_response_code(200);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Akses berhasil dibuka',
                    ));
                }else{
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'User tidak aktif',
                    ));
                }
            }else{
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'User tidak ditemukan'
                ));
            }
        }else{
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Anda tidak memiliki akses untuk melakukan ini!'
            ));
        }
    }

}
