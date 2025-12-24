<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 1/23/20, 10:49 AM
 *  * Last Modified: 9/29/18, 11:03 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Master extends MX_Controller{

    function __construct(){
        parent::__construct();

		$this->load->model(array('m_master','intern/m_mobileApprovals'));
        $this->load->library(array('form_validation','template','upload','pdf','fiky_encryption','image_lib','fiky_ordencrypt'));

/* 		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        } */
    }

	function index(){
			$data['title']="SELAMAT DATANG SILAHKAN PILIH MENU YANG ADA";
			$this->template->display('intern/cr_sj/v_index',$data);
	}

	function testConnect(){
		$branch=trim($this->input->post('branch'));
		$userId=trim($this->input->post('userId'));
		$ip=trim($this->input->post('ip'));
				$cekuser = $this->m_master->q_branch()->num_rows();
				echo json_encode(
				array(
					'success' => true,
					'message' => "Koneksi ke $ip Berhasil",
					'status' => 'success',
					'row' => $cekuser,
					'allow' => true
				));
	}

	function downloadMst(){
		$startDate=$this->input->post('startDate');
		$endDate=$this->input->post('endDate');
		$userId=trim($this->input->post('userId'));
		//$lb=$this->m_cr_sj->q_branch()->row_array();
		//$branch=trim($lb['fc_branch']);
		$this->m_master->q_insert_usermobile($userId);



		$param="";
		//$paramuser="";
		$paramuser=" and username='$userId'";
        	$paramuserhrms=" and username='$userId'";

            $dtlUsr=$this->m_master->q_mst_userhrms($paramuserhrms)->row_array();
            $updpw = array(
                'nik' => trim($dtlUsr['nik']),
                'passwordweb' => trim($dtlUsr['passwordweb']),
                'expdate' =>  trim($dtlUsr['expdate']),
                'hold_id' => trim($dtlUsr['hold_id'])
            );
            $this->db->where('username',$userId);
            $this->db->update('sc_mst.t_user_mobile',$updpw);


		$user = $this->m_master->q_mst_user($paramuser)->result();
		$cekuser = $this->m_master->q_mst_user($paramuser)->num_rows();
		//header("Content-Type: text/json");
		if ($cekuser>0){
			echo json_encode(
				array(
					'success' => true,
					'message' => 'Master User Sukses DI Download',
					'body' => array(
						'user' => $user,
					)
				));
		} else {
			echo json_encode(
				array(
					'success' => false,
					'message' => 'Data Master User HRMS Tidak Ada, Silahkan Ubah Username Pada Konfigurasi Server',
					'body' => array(
						'user' => $user,
					)
				));
		}
	}

	function getDeviceId(){
        $userId=$this->input->post('userId');
        $id_device=$this->input->post('id_device');
        $id_brand=$this->input->post('id_brand');
        $id_os=$this->input->post('id_os');
        $id_gps_location=$this->input->post('id_gps_location');
        $branch=$this->input->post('branch');
        $erptype=$this->input->post('erptype');
        $playerId=$this->input->post('playerId');
        $registrationId=$this->input->post('registrationId');

//        $param_q_cek = " and username = '$userId' ";
//        $q_cek = $this->m_master->q_mst_user($param_q_cek)->row_array();
//        if ($q_cek > 0) { //cek keberadaan user di intern
            if ($userId != 'ADMIN' and !empty($userId)) {
                $info = array(
                    'branch' => $branch,
                    'username' => $userId,
                    'erptype' => $erptype,
                    'id_device' => $id_device,
                    'id_brand' =>  $id_brand,
                    'id_os' =>  $id_os,
                    'id_gps_location' => $id_gps_location,
                    'playerid' => $playerId,
                    'registrationid' => $registrationId,
                    'lastlogdate' => date('Y-m-d H:i:s')
                );
                $this->db->insert('sc_log.t_user_device_id',$info);

                $infoDevice = array(
                    'playerid' => $playerId,
                    'registrationid' => $registrationId
                );
                $this->db->where('username',$userId);
                $this->db->update('sc_mst.t_user_mobile',$infoDevice);

                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Device Sukses Disisispkan',
                        'status' => 'true',
                        'allow' =>  true,
                    )
                );
            } else {
                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Device Gagal Disisipkan',
                        'status' => 'false',
                        'allow' =>  false,
                    )
                );
            }
//        } else {
//            header("Content-Type: text/json");
//            echo json_encode(
//                array(
//                    'success' => false,
//                    'message' => 'User Di Aplikasi Kedua Tidak Tersedia, Harap Cek',
//                    'status' => 'false',
//                    'allow' =>  false,
//                )
//            );
//        }

    }


}
