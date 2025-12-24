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

    function cli_mail_notification_broadcast(){
        $loop_app = $this->db->query("
        select a.*,b.nmlengkap,to_char(a.docdate,'dd-mm-yyyy') as docdate1 from sc_trx.approvals_system a 
        left outer join sc_mst.karyawan b on a.docref=b.nik where coalesce(sendmail,'NO')='NO' and coalesce(a.status,'A') NOT IN ('A','A1')  ORDER BY DOCNO ASC
        ");
        $loop_appx = $loop_app->result();


        foreach($loop_appx as $lr){
            /* BROADCAST STANDART APPROVAL */
            $docno = trim($lr->docno);
            $doctype = trim($lr->doctype);
            $erptype = trim($lr->erptype);
            $send_date = date('Y-m-d H:i:s');
            $doctypename = trim($lr->doctypename);


            if (trim($doctype)==='MCTI'){
                $dtlx = $this->m_mobileApprovals->list_dtl_cuti_approvals(" and docno='".$docno."'")->row_array();
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email(trim($lr->docref),$docno)->result();
            } else if (trim($doctype)==='MIJN') {
                $dtlx = $this->m_mobileApprovals->list_dtl_ijin_approvals(" and docno='".$docno."'")->row_array();
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email_ijin(trim($lr->docref),$docno)->result();
            } else if (trim($doctype)==='MDNS') {
                $dtlx = $this->m_mobileApprovals->list_dtl_dinas_approvals(" and docno='".$docno."'")->row_array();
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email_dinas(trim($lr->docref),$docno)->result();
            } else if (trim($doctype)==='MLBR') {
                $dtlx = $this->m_mobileApprovals->list_dtl_lembur_approvals(" and docno='".$docno."'")->row_array();
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email_lembur(trim($lr->docref),$docno)->result();
            } else if (trim($doctype)==='PSPB') {
                $dtlx = $this->m_mobileApprovals->list_dtl_ga_sppb_approvals(" and docno='".$docno."'")->row_array();
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email_ga_sppb(trim($lr->docref),$docno)->result();
            }



            $penerima_mail = null;
            $nmlengkap = null;

            foreach($loopreceiver as $lx){
                    $penerima_mail.=trim($lx->email).',';
                    $nmlengkap.=trim($lx->nmlengkap).'';
            }
            $mailto = $penerima_mail;

            $sender=$this->m_mailserver->q_smtp("NSANBI")->row_array();
            $dari=trim($sender['primarymail']);
            $mailsender = $dari.", 'PT NUSA UNGGUL SARANA ADICIPTA'";
            $mailcc = '';
            $mailbcc = '';
            $mailsubject ='Notifikasi Persetujuan: '.trim($lr->doctypename);
            $mailtype = 'html';

            $mailmessage ='';
            $mailmessage.= '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
<!--[if gte mso 9]><xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml><![endif]-->
<title>Nusa Mail Notification</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
<meta name="format-detection" content="telephone=no">
<!--[if !mso]><!-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<!--<![endif]-->
<style type="text/css">
body {
	margin: 0 !important;
	padding: 0 !important;
	-webkit-text-size-adjust: 100% !important;
	-ms-text-size-adjust: 100% !important;
	-webkit-font-smoothing: antialiased !important;
}
img {
	border: 0 !important;
	outline: none !important;
}
p {
	Margin: 0px !important;
	Padding: 0px !important;
}
table {
	border-collapse: collapse;
	mso-table-lspace: 0px;
	mso-table-rspace: 0px;
}
td, a, span {
	border-collapse: collapse;
	mso-line-height-rule: exactly;
}
.ExternalClass * {
	line-height: 100%;
}
.em_defaultlink a {
	color: inherit !important;
	text-decoration: none !important;
}
span.MsoHyperlink {
	mso-style-priority: 99;
	color: inherit;
}
span.MsoHyperlinkFollowed {
	mso-style-priority: 99;
	color: inherit;
}
 @media only screen and (min-width:481px) and (max-width:699px) {
.em_main_table {
	width: 100% !important;
}
.em_wrapper {
	width: 100% !important;
}
.em_hide {
	display: none !important;
}
.em_img {
	width: 100% !important;
	height: auto !important;
}
.em_h20 {
	height: 20px !important;
}
.em_padd {
	padding: 20px 10px !important;
}
}
@media screen and (max-width: 480px) {
.em_main_table {
	width: 100% !important;
}
.em_wrapper {
	width: 100% !important;
}
.em_hide {
	display: none !important;
}
.em_img {
	width: 100% !important;
	height: auto !important;
}
.em_h20 {
	height: 20px !important;
}
.em_padd {
	padding: 20px 10px !important;
}
.em_text1 {
	font-size: 16px !important;
	line-height: 24px !important;
}
u + .em_body .em_full_wrap {
	width: 100% !important;
	width: 100vw !important;
}
a { color: inherit; } 
}
</style>
</head>

<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
<table class="em_full_wrap" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
  <tbody><tr>
    <td valign="top" align="center"><table class="em_main_table" style="width:700px;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
        <!--Header section-->
        <tbody><tr>
          <!-- <td style="padding:15px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:12px; line-height:15px; color:#0d1121;" valign="top" align="center">Test Email Sample | <a href="#" target="_blank" style="color:#0d1121; text-decoration:underline;">View Online</a></td>
              </tr>
            </tbody></table></td> -->
        </tr>
        <!--//Header section--> 
        <!--Banner section-->
        <tr>
          <td valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                   <td valign="top" align="center"><img class="em_img" style="display:block; font-family:Arial, sans-serif; font-size:30px; line-height:34px; color:#000000; max-width:700px;" src="http://hrd.nusaboard.co.id:7070/hrdnew/assets/img/mail_template/image/approval_mgmt/header3.png" width="700" border="0" height="180"></td>
              </tr>
            </tbody></table></td>
        </tr>
        <!--//Banner section--> 
        <!--Content Text Section-->		
                 <tr>
          <td style="padding:35px 70px 30px;" class="em_padd" valign="top" bgcolor="#ffffff" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody>
			  <tr>
                <td style="font-family:Times; font-size:22px; line-height:30px; color:#000000; width: 50%; " valign="top" align="left">
				<strong>Yth. Karyawan PT NUSA </strong></td>
              </tr>
              <tr>
                <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
<!--—this is space of 15px to separate two paragraphs ---->
              </tr>
			  <tr>
                <td style="font-family:Times; font-size:18px; line-height:30px; color:#000000;" valign="top" align="left">
				Persetujuan Untuk </td>
              </tr>
			   <tr>
                <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
<!--—this is space of 15px to separate two paragraphs ---->
              </tr>
			   <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Nomor Dokumen</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;"  valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.trim($lr->docno).'</td>
              </tr>
              <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Tanggal Dokumen</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;"  valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.trim($lr->docdate1).'</td>
              </tr>
			   <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Aplikasi</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;"  valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.trim($lr->erptype).'</td>
              </tr>
			   <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Jenis Dokumen</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;"  valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.trim($lr->doctypename).'</td>
              </tr>
			  <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Pemohon</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.trim($lr->nmlengkap).'</td>
              </tr>';


            if (trim($doctype)==='MCTI') {
              $mailmessage.='<tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Tanggal Cuti</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['tgl_awal'].' s/d '.$dtlx['tgl_akhir'].'</td>
              </tr>
			  <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Jumlah Cuti</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['jumlah_cuti'].' Hari</td>
              </tr>
               <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Pelimpahan Ke Sdr/i</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;">'.$dtlx['nmpelimpahan'].'</td>
              </tr>
              <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Keterangan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['keterangan'].'</td>
              </tr>
              ';
            } else if (trim($doctype)==='MIJN') {
                $mailmessage.='<tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Tanggal Ijin</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['tgl_kerja'].'</td>
              </tr>
			  <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Kategori</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['kategori'].'</td>
              </tr>
               <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Type Ijin</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['type_ijin'].'</td>
              </tr>
              <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Keterangan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['keterangan'].'</td>
              </tr>';
            } else if (trim($doctype)==='MDNS') {
                $mailmessage.='<tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Tanggal Dinas</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['tgl_mulai'].' s/d '.$dtlx['tgl_selesai'].'</td>
              </tr>
			  <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Kategori</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['nmkategori'].'</td>
              </tr>
               <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Tujuan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['tujuan'].'</td>
              </tr>
              <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Keperluan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['keperluan'].'</td>
              </tr>';
            } else if (trim($doctype)==='MLBR') {
                $mailmessage.='<tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Tanggal Lembur</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['tgl_jam_mulai_1'].'<strong> s/d </strong>'.$dtlx['tgl_jam_selesai_1'].'</td>
              </tr>
              <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Jenis Lembur</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['nmjenis_lembur'].'</td>
              </tr>
			  <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Kategori</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['kategori_lembur'].'</td>
              </tr>
              <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Keterangan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['keterangan'].'</td>
              </tr>';
            }  else if (trim($doctype)==='PSPB') {
                $mailmessage.='
              <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Nama Barang/Jasa</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['nmbarang'].'</td>
              </tr>
			  <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Qty</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['qty'].'</td>
              </tr>
              <tr>
				<td style="width: 40%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Satuan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['satuan'].'</td>
              </tr>
              <tr>
				<td style="width: 20%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">Keterangan</td>
				<td style="width: 2%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="top">:</td>
				<td style="width: 58%; height: 19.4px;font-family:\'Times\'; font-size:12px;" valign="bottom" align="left">'.$dtlx['keterangan'].'</td>
              </tr>';
            }


			   $mailmessage.='<tr>
                <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
<!--—this is space of 15px to separate two paragraphs ---->
              </tr>
			   <tr>
                <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
<!--—this is space of 15px to separate two paragraphs ---->
              </tr>
			   <tr>

                ';
                if (trim($lr->status)=='U') {
                    //$mailmessage.= '<td style="font-family:Times; font-size:25px; line-height:30px; color:#09d92e;" valign="top" align="left"><strong><b>Telah Disetujui </b></strong></td>';
                    $mailmessage.= '<td align="center"><img class="em_img" style="display:block; font-family:Arial, sans-serif; font-size:30px; line-height:34px; color:#000000; max-width:300px;" src="http://hrd.nusaboard.co.id:7070/hrdnew/assets/img/mail_template/image/approval_mgmt/disetujui.png" width="300" border="0" height="50"></td>';
				} else {
                    //$mailmessage .= '<td style="font-family:Times; font-size:25px; line-height:30px; color:#ff0000;" valign="top" align="left"><strong><b>Telah Ditolak </b></strong></td>';
                    $mailmessage .= '<td align="center"><img class="em_img" style="display:block; font-family:Arial, sans-serif; font-size:30px; line-height:34px; color:#000000; max-width:300px;" src="http://hrd.nusaboard.co.id:7070/hrdnew/assets/img/mail_template/image/approval_mgmt/ditolak.png" width="300" border="0" height="50"></td>';
                }

                $mailmessage.= '
              </tr>
			  <tr>
                <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
<!--—this is space of 15px to separate two paragraphs ---->
              </tr>
			  <tr>
                <td style="font-family:Times; font-size:18px; line-height:30px; color:#000000;" valign="top" align="left">';
                if (trim($lr->status)=='U') {
                    $mailmessage.= '<strong>Catatan tambahan:</strong>';
                } else {
                    $mailmessage .= '<strong>Alasan:</strong>';
                }
                $mailmessage.= '</td>
              </tr>
              <tr>
                <td style="font-family:Times; font-size:12px; line-height:30px; color:#000000;" valign="top" align="left">
				'. ucfirst($lr->reason).'</td>
              </tr>

              <!-- <tr> -->
                <!-- <td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:18px; line-height:22px; color:#000000; letter-spacing:2px; padding-bottom:12px;" valign="top" align="center">This is paragraph 2 of font size 18px and #fbeb59 font color with a line spacing of 15px</td> -->
              <!-- </tr> -->
              <!-- <tr> -->
                <!-- <td class="em_h20" style="font-size:0px; line-height:0px; height:25px;" height="25">&nbsp;</td> -->

              <!-- </tr> -->
<!-- <tr> -->
                <!-- <td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:18px; line-height:22px; color:#000000; text-transform:uppercase; letter-spacing:2px; padding-bottom:12px;" valign="top" align="center"> This is paragraph 3 of font size 18px and #fbeb59 font color with a line spacing of 25px and Uppercase</td> -->
              <!-- </tr> -->
            </tbody></table></td>
        </tr>

        <!--//Content Text Section-->
        <!--Footer Section-->
        <tr>
          <td style="padding:38px 30px;" class="em_padd" valign="top" bgcolor="#009557" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td style="padding-bottom:16px;" valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody><tr>
                      <td valign="top" align="center"><a href="http://nusaboard.co.id:6060/nusaboard/" target="_blank" style="text-decoration:none;"><img src="http://hrd.nusaboard.co.id:7070/hrdnew/assets/img/mail_template/icon/browser.png" alt="yt" style="display:block; font-family:Arial, sans-serif; font-size:12px; line-height:14px; color:#ffffff; max-width:26px;" width="26" border="0" height="26">nusaboard.co.id</a></td>
					  <td style="width:6px;" width="6">&nbsp;</td>
                      <td valign="top" align="center"><a href="https://www.facebook.com/nusaboard/" target="_blank" style="text-decoration:none;"><img src="http://hrd.nusaboard.co.id:7070/hrdnew/assets/img/mail_template/icon/fb.png" alt="fb" style="display:block; font-family:Arial, sans-serif; font-size:12px; line-height:14px; color:#ffffff; max-width:26px;" width="26" border="0" height="26"> Nusaboard </a></td>
                      <td style="width:6px;" width="6">&nbsp;</td>
                      <td valign="top" align="center"><a href="https://www.instagram.com/nusaboard.co.id/" target="_blank" style="text-decoration:none;"><img src="http://hrd.nusaboard.co.id:7070/hrdnew/assets/img/mail_template/icon/ig.png" alt="tw" style="display:block; font-family:Arial, sans-serif; font-size:12px; line-height:14px; color:#ffffff; max-width:27px;" width="27" border="0" height="26"> @nusaboard.co.id </a></td>
                      <td style="width:6px;" width="6">&nbsp;</td>
                    </tr>
                  </tbody></table></td>
              </tr>
              <tr>
                <td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:11px; line-height:18px; color:#000000;" valign="top" align="center"><a href="#" target="_blank" style="color:#000000; text-decoration:underline;">PRIVACY STATEMENT</a> | <a href="#" target="_blank" style="color:#000000; text-decoration:underline;">TERMS OF SERVICE</a> | <a href="#" target="_blank" style="color:#000000; text-decoration:underline;">RETURNS</a><br>
                   Copyright IT Nusa Group 2020. All Rights Reserved.<br>
                  Mohon Jangan balas email ini, ini adalah email otomatis dari system <a href="#" target="_blank" style="text-decoration:none; color:#000000;">unsubscribe</a></td>
              </tr>
            </tbody></table></td>
        </tr>
        <tr>
          <td class="em_hide" style="line-height:1px;min-width:700px;background-color:#ffffff;">
<img alt="" src="#" style="max-height:1px; min-height:1px; display:block; width:700px; min-width:700px;" width="700" border="0" height="1"></td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
<div class="em_hide" style="white-space: nowrap; display: none; font-size:0px; line-height:0px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
</body></html>
';

            $mailattach = '';
            $sentby = 'SYSTEM';
            $mailstatus = 'NO_SENT';

            $info = array(
                'docno' => $docno,
                'doctype' => $doctype,
                'erptype' => $erptype,
                'send_date' => $send_date,
                'doctypename' => $doctypename,
                'mailto' => $mailto,
                'mailsender' => $mailsender,
                'mailcc' => $mailcc,
                'mailbcc' => $mailbcc,
                'mailsubject' => $mailsubject,
                'mailtype' => $mailtype,
                'mailmessage' => $mailmessage,
                'mailattach' => $mailattach,
                'sentby' => $sentby,
                'mailstatus' => $mailstatus,
            );
            if (!empty ($mailto)) {
                $this->db->insert('public.mail_outbox', $info);
            }
            /* BROADCAST STANDART APPROVAL */

            $this->db->query("update sc_trx.approvals_system set sendmail='YES' where docno='".$lr->docno."'");
            echo  "docno='".$lr->docno."'".'</br>';
        }
        //echo 'Coba Test';

    }

    function cli_sent_mail_notification__broadcast()
    {
        $loop_app = $this->db->query("
            select *,case 
when right(trim(mailto),1)=',' then left(trim(mailto),-1)
else trim(mailto) end as mailto2 from public.mail_outbox where coalesce(mailstatus,'NO_SENT')='NO_SENT' ORDER BY send_date ASC 
        ");
        $loop_appx = $loop_app->result();

        foreach ($loop_appx as $lr) {
            /* TAMBAHAN UNTUK PELIMPAHAN UNTUK CUTI SAJA */
                                $sender=$this->m_mailserver->q_smtp("NSANBI")->row_array();
                                $dari=$sender['primarymail'];
                                $subject='PERSETUJUAN UNTUK DOKUMEN : '.trim($lr->doctypename);
                                $this->email->from('noreply_nusa@nusaboard.co.id', 'PT NUSA UNGGUL SARANA ADICIPTA');
                                $this->email->to($lr->mailto2);
                                //$this->email->cc($cc);
                                //$this->email->bcc($bcc);
                                $this->email->subject($lr->mailsubject);
                                $this->email->set_mailtype("html");
                                $this->email->message($lr->mailmessage);

            if ($this->email->send()) {
                $this->db->query("update mail_outbox set mailstatus='SENT' where
                                    docno='".$lr->docno."' and
                                    doctype='".$lr->doctype."' and
                                    erptype='".$lr->erptype."' and
                                    send_date='".$lr->send_date."' and
                                    mailto='".$lr->mailto."'

                                    ");
                echo "docno='".$lr->docno."' and
                    doctype='".$lr->doctype."' and
                    erptype='".$lr->erptype."' and
                    send_date='".$lr->send_date."' and
                    mailto='".$lr->mailto."'";
                break;
            } else {
                show_error($this->email->print_debugger());
            }
            /* SENT EMAIL */
            //
            //echo  "docno='".$lr->docno."'".'</br>';
        }
    }
}
