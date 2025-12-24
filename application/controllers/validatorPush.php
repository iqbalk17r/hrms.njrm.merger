<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 12/12/19, 3:54 PM
 *  * Last Modified: 8/29/19, 8:48 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class ValidatorPush extends CI_Controller{

    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		$this->load->model(array('payroll/m_final','intern/m_mobileApprovals','mail/m_mailserver'));
		//$this->load->library(array('Fiky_encryption','Fiky_mailer','fiky_pdf','fiky_pdf_mpdf_extension'));
		$this->load->library(array('Fiky_encryption','Fiky_mailer','fiky_notification_push'));
    }
	function index(){
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    }

	function validate_links(){
        //$data['title'] =  "Isi Title";
		//$this->load->view("leavesession/v_validator_mailer",$data);
		$this->load->view("leavesession/v_validator_mailer");
	}

   function repush_otomatis(){
       $this->db->cache_delete('validatorPush','repush_otomatis');

       $param = " and trim(coalesce(status,''))='A'";
       $loop = $this->m_mobileApprovals->q_push_approval_system($param)->result();

       $cek = $this->m_mobileApprovals->q_push_approval_system($param)->num_rows();
       if ($cek > 0){
           foreach ($loop as $lp) {
               $this->fiky_notification_push->onePushVapeApprovalHrms(trim($lp->docref),trim($lp->nik_atasan),trim($lp->docno));
           }
           echo json_encode(array('status' => true, 'messages' => 'Data Sukses Di Proses'));
       } else {
           echo json_encode(array('status' => false, 'messages' => 'Tidak Ada Data Di Proses'));
       }

   }

}
