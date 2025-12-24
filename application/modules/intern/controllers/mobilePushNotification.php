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
class MobilePushNotification extends MX_Controller{

    function __construct(){
        parent::__construct();

		$this->load->model(array('intern/m_mobilePushNotification','intern/m_master','intern/m_mobileApprovals'));
        $this->load->library(array('form_validation','template','upload','pdf','fiky_encryption','image_lib','fiky_ordencrypt'));

    }

	function index()
    {
			ECHO "FORBIDDEN";
	}


    function onePushVapeApprovalHrms($nikUser,$nikPicApprove,$docno)
    {
        // Tag Customization
        $penerima=null;
        $paramreceiver = " and nik='$nikPicApprove'";
        $dtlAppr = $this->m_mobileApprovals->list_master_approvals(" and docno='$docno'")->row_array();

        $loopreceiver=$this->m_master->q_mst_user($paramreceiver)->result();
        foreach($loopreceiver as $lr){
            $penerima.=trim($lr->playerid).'';
        }

        // Tag One Signal Object
        $content = array(
            "en" => 'English Message'
        );

        $fields = array(
            'app_id' => $this->config->item('app_id'),
            'include_player_ids' => array($penerima),
            'data' => array(
                "Aplikasi" => $dtlAppr['erptype'],
                "Dokumen" => $dtlAppr['doctypename'],
                "Kirim Ke" => $penerima,
            ),
            'contents' => $content
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic ZjZlYzE3NjctZjhmMi00MzEyLThhNmMtMDkxYzFmMTQ5YmVi'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }


    function testSend()
    {
        $this->onePushVapeApprovalHrms('1115.184','0512.070','CT190001');

       /* $response = $this->onePushVapeApprovalHrms('1115.184','0512.070','CT190001');
        $return["allresponses"] = $response;
        $return = json_encode( $return);

        print("\n\nJSON received:\n");
        print($return);
        print("\n");*/
    }


}
