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
class MobileApprovals extends MX_Controller{

    function __construct(){
        parent::__construct();

		$this->load->model(array('m_mobileApprovals','mail/m_mailserver'));
        $this->load->library(array('form_validation','template','upload','pdf','fiky_encryption','image_lib','fiky_ordencrypt','Fiky_mailer'));

    }

	function index(){
			ECHO "FORBIDDEN";
	}


    function listMobileApprovals(){
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');

        $startDateN=date('Ymd',strtotime($startDate));
        $endDateN=date('Ymd',strtotime($endDate));

        $userId=$this->input->post('userId');
        $count=$this->input->post('count');
        $total=$this->input->post('total');
        $offset = trim($this->input->post('pages'));
        if($offset>0){
            $pages = ($offset - 1);
        } else {
           $pages = 0;
        }





        $finduser = $this->m_mobileApprovals->mst_user(" and username ='$userId'")->row_array();
        $nama = trim($finduser['nik']);
        $level_akses=strtoupper(trim($finduser['level_akses']));
        /* akses approve atasan */
        $ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();

        $userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();


        if (($ceknikatasan1)>0){
            $nikatasan="and docref in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')";

        }
        else if (($ceknikatasan2)>0 ){
            $nikatasan="and docref in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama')";
        }
        else {
            $nikatasan="and docref!='$nama'";
        }


        //$pages=0;
        $query = (isset($_REQUEST['search'])) ? ($_REQUEST['search']) : '';

        if ( strlen(trim($query)) > 0 ) {
            $query = str_replace(' ', '', $query);
            $clausesearch = " and ( docno like '%$query%' or to_char(docdate,'dd-mm-yyyy') like '%$query%' )" ;
        } else { $clausesearch = ' '; }

        $param=" and to_char(docdate,'yyyymmdd') between '$startDateN' and '$endDateN' $nikatasan $clausesearch ";
        $paramx=" and to_char(docdate,'yyyymmdd') between '$startDateN' and '$endDateN'";
        $paramtop=" limit $total offset ($pages) "; //$paramtop=" limit $total ";
        $paramoffset="	and docno != '' and coalesce(status,'')='A'
							$paramx order by docdate desc" ;

        $approvals_records = $this->m_mobileApprovals->list_approvals($param,$paramtop,$paramoffset)->result();
        $approvals_total = $this->m_mobileApprovals->list_count_approvals($param,'')->num_rows();

        header("Content-Type: text/json");
        echo json_encode(
            array(
                'success' => true,
                'message' => '',
                'status' => 'success',
                'allow' =>  true,
                'date' =>  date('d-m-Y H:m:s'),
                'count' =>  $count,
                'total' =>  $approvals_total,
                'pages' =>  $pages,
                'search' => $query,
                'records' => $approvals_records,
            )
        );
    }
    function listMobileApprovalsFinish(){
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');

        $startDateN=date('Ymd',strtotime($startDate));
        $endDateN=date('Ymd',strtotime($endDate));

        $userId=$this->input->post('userId');
        $count=$this->input->post('count');
        $total=$this->input->post('total');
        $offset = trim($this->input->post('pages'));
        if($offset>0){
            $pages = ($offset - 1);
        } else {
            $pages = 0;
        }


        $finduser = $this->m_mobileApprovals->mst_user(" and username ='$userId'")->row_array();
        $nama = trim($finduser['nik']);
        $level_akses=strtoupper(trim($finduser['level_akses']));
        /* akses approve atasan */
        $ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();

        $userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();


        if (($ceknikatasan1)>0){
            $nikatasan="and docref in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama')";

        }
        else if (($ceknikatasan2)>0 ){
            $nikatasan="and docref in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama')";
        }
        else {
            $nikatasan="and docref!='$nama'";
        }


        $pages=0;
        $query = (isset($_REQUEST['search'])) ? ($_REQUEST['search']) : '';

        if ( strlen(trim($query)) > 0 ) {
            $query = str_replace(' ', '', $query);
            $clausesearch = " and ( docno like '%$query%' or to_char(docdate,'dd-mm-yyyy') like '%$query%' )" ;
        } else { $clausesearch = ' '; }

        $param=" and to_char(docdate,'yyyymmdd') between '$startDateN' and '$endDateN' $nikatasan $clausesearch ";
        $paramx=" and to_char(docdate,'yyyymmdd') between '$startDateN' and '$endDateN'";
        $paramtop=" limit $total offset ($pages) "; //$paramtop=" limit $total ";
        $paramoffset="	and docno != '' and coalesce(status,'')!='A'
							$paramx order by docdate desc" ;

        $approvals_records = $this->m_mobileApprovals->list_approvals($param,$paramtop,$paramoffset)->result();
        $approvals_total = $this->m_mobileApprovals->list_count_approvals($param,'')->num_rows();

        header("Content-Type: text/json");
        echo json_encode(
            array(
                'success' => true,
                'message' => '',
                'status' => 'success',
                'allow' =>  true,
                'date' =>  date('d-m-Y H:m:s'),
                'count' =>  $count,
                'total' =>  $approvals_total,
                'pages' =>  $pages,
                'search' => $query,
                'records' => $approvals_records,
            )
        );
    }
    function listDetailMobileApprovals(){
        $branch=$this->input->post('branch');
        $docno=$this->input->post('docno');
        $userId=$this->input->post('userId');
        $stockcode=$this->input->post('stockcode');
        $count=$this->input->post('count');
        $total=$this->input->post('total');
        $pages=$this->input->post('pages');
        $query = (isset($_REQUEST['search'])) ? ($_REQUEST['search']) : '';

        $param_dtl_trans = " and coalesce(docno,'') = '$docno'";
        $dtl_trans = $this->m_mobileApprovals->list_master_approvals($param_dtl_trans)->row_array();

        //ERP TYPE
        if (trim($dtl_trans['erptype'])==='HRMS'){
            // HRMS TYPE CUTI
            if (trim($dtl_trans['doctype'])==='MCTI'){
                $paramx = " and coalesce(docno,'') = '$docno'";
                $dtl_records = $this->m_mobileApprovals->list_dtl_approvals($paramx)->result();
                $dtl_total = $this->m_mobileApprovals->list_dtl_approvals($paramx)->num_rows();
                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => '',
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s'),
                        'count' =>  0,
                        'total' =>  $dtl_total,
                        'pages' =>  null,
                        'search' => null,
                        'records' => $dtl_records,
                    )
                );
            // HRMS TYPE IJIN
            } else if (trim($dtl_trans['doctype'])==='MIJN'){
                $paramx = " and coalesce(docno,'') = '$docno'";
                $dtl_records = $this->m_mobileApprovals->list_dtl_approvals($paramx)->result();
                $dtl_total = $this->m_mobileApprovals->list_dtl_approvals($paramx)->num_rows();
                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => '',
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s'),
                        'count' =>  0,
                        'total' =>  $dtl_total,
                        'pages' =>  null,
                        'search' => null,
                        'records' => $dtl_records,
                    )
                );
            } else if (trim($dtl_trans['doctype'])==='MDNS') { // HRMS TYPE DINAS
                $paramx = " and coalesce(docno,'') = '$docno'";
                $dtl_records = $this->m_mobileApprovals->list_dtl_approvals($paramx)->result();
                $dtl_total = $this->m_mobileApprovals->list_dtl_approvals($paramx)->num_rows();
                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => '',
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s'),
                        'count' =>  0,
                        'total' =>  $dtl_total,
                        'pages' =>  null,
                        'search' => null,
                        'records' => $dtl_records,
                    )
                );
            } else if (trim($dtl_trans['doctype'])==='MLBR') { // HRMS TYPE LEMBUR
                $paramx = " and coalesce(docno,'') = '$docno'";
                $dtl_records = $this->m_mobileApprovals->list_dtl_approvals($paramx)->result();
                $dtl_total = $this->m_mobileApprovals->list_dtl_approvals($paramx)->num_rows();
                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => '',
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s'),
                        'count' =>  0,
                        'total' =>  $dtl_total,
                        'pages' =>  null,
                        'search' => null,
                        'records' => $dtl_records,
                    )
                );
            } else if (trim($dtl_trans['doctype'])==='PSPB') { // HRMS TYPE GA APPROVAL
                $paramx = " and coalesce(docno,'') = '$docno'";
                $dtl_records = $this->m_mobileApprovals->list_dtl_approvals($paramx)->result();
                $dtl_total = $this->m_mobileApprovals->list_dtl_approvals($paramx)->num_rows();
                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => '',
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s'),
                        'count' =>  0,
                        'total' =>  $dtl_total,
                        'pages' =>  null,
                        'search' => null,
                        'records' => $dtl_records,
                    )
                );
            }
        } else {
            header("Content-Type: text/json");
            echo json_encode(
                array(
                    'success' => false,
                    'message' => 'Data Tidak Ada Tidak Tersingkron',
                    'status' => 'error',
                    'allow' =>  false,
                    'date' =>  date('d-m-Y H:m:s'),
                    'count' =>  0,
                    'total' =>  0,
                    'pages' =>  null,
                    'search' => null,
                    'records' => null,
                )
            );
        }
    }

    function xUp(){
        $branch=$this->input->post('branch');
        $docno=$this->input->post('docno');
        $userId=$this->input->post('userId');
        $key=$this->input->post('key');
        $erptype=$this->input->post('erptype');
        $doctype=$this->input->post('doctype');
        $doctypename=$this->input->post('doctypename');
        $typeVal=$this->input->post('typeVal');
        $reason=$this->input->post('reason');

        $dtlBranch = $this->m_mobileApprovals->mst_branch($param = null)->row_array();
        $countUser = $this->m_mobileApprovals->mst_user(" and username='$userId'")->num_rows();
        $dtlAp = $this->m_mobileApprovals->list_dtl_approvals(" and docno='$docno'")->row_array();



        if (trim($dtlBranch['branch'])===trim($branch) and trim($key)==='xMiyabiXdoDolanPermenSusuX' and $countUser>0 )
        {

            if ($typeVal==='YES'){
                $info = array(
                    'status' => 'U',
                    'asstatus' => 'U',
                    'approvaldate' => date('d-m-Y H:m:s'),
                    'approvalby' => $userId,
                    'reason' => $reason,
                );
                $this->db->where('docno',$docno);
                $this->db->update('sc_trx.approvals_system',$info);

                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'reason' => 'Dokumen '.$doctypename.' Dengan Nomor '.$docno.' Sukses Di Approve',
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s')
                    )
                );

                /* #1 TESTING EMAIL APPLICATION

                $penerima_mail = null;
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email(trim($dtlAp['docref']))->result();
                foreach($loopreceiver as $lr){
                    $penerima_mail.=trim($lr->email).',';
                }

                $sender=$this->m_mailserver->q_smtp("NSANBI")->row_array();
                $dari=$sender['primarymail'];
                $subject='PERSETUJUAN UNTUK DOKUMEN : '.trim($dtlAp['doctypename']);

                $this->email->from($dari, 'PT NUSA UNGGUL SARANA ADICIPTA');
                $this->email->to($penerima_mail);
                //$this->email->cc($cc);
                //$this->email->bcc($bcc);
                $this->email->subject($subject);
                $this->email->message('DOKUMEN : '.trim($dtlAp['docno']).' JENIS APLIKASI : '.trim($dtlAp['erptype']).' TYPE : '.trim($dtlAp['doctypename']).'
                SUKSES DI APPROVAL
                DENGAN ALASAN : '.$reason);

                if ($this->email->send()) {

                    if (trim($doctype)==='MCTI'){ */
                        /* TAMBAHAN UNTUK PELIMPAHAN UNTUK CUTI SAJA
                        $penerima_mailx = null;
                        $loopreceiverx=$this->m_mobileApprovals->q_who_receive_email_pelimpahan(trim($dtlAp['docno']))->result();
                        $dtl_cuti = $this->m_mobileApprovals->list_dtl_cuti_approvals(" and docno='".trim($dtlAp['docno'])."'")->row_array();
                        foreach($loopreceiverx as $lr){
                            $penerima_mailx.=trim($lr->email).',';
                        }
                        $sender=$this->m_mailserver->q_smtp("NSANBI")->row_array();
                        $dari=$sender['primarymail'];
                        $subject='PERSETUJUAN UNTUK DOKUMEN : '.trim($dtlAp['doctypename']);

                        $this->email->from($dari, 'PT NUSA UNGGUL SARANA ADICIPTA');
                        $this->email->to($penerima_mailx);
                        //$this->email->cc($cc);
                        //$this->email->bcc($bcc);
                        $this->email->subject($subject);
                        $this->email->message("Sdr /i ".trim($dtl_cuti['nmpelimpahan'])." CUTI : ".trim($dtl_cuti['nmlengkap'])." DILIMPAHKAN KE Sdr /i");

                        if ($this->email->send()) {
                            header("Content-Type: text/json");
                            echo json_encode(
                                array(
                                    'success' => true,
                                    'reason' => 'Dokumen '.$doctypename.' Dengan Nomor '.$docno.' Telah Di Setujui I',
                                    'status' => 'success',
                                    'allow' =>  true,
                                    'date' =>  date('d-m-Y H:m:s')
                                )
                            );
                        } else {
                            show_error($this->email->print_debugger());
                        } */
                        /* TAMBAHAN UNTUK PELIMPAHAN UNTUK CUTI SAJA
                    } else {
                        header("Content-Type: text/json");
                        echo json_encode(
                            array(
                                'success' => true,
                                'reason' => 'Dokumen '.$doctypename.' Dengan Nomor '.$docno.' Sukses Di Approve',
                                'status' => 'success',
                                'allow' =>  true,
                                'date' =>  date('d-m-Y H:m:s')
                            )
                        );
                    }

                } else {
                    show_error($this->email->print_debugger());
                }*/
                /* #1 TESTING EMAIL APPLICATION */

            } else if ($typeVal==='NO') {
                $info = array(
                    'status' => 'C',
                    'asstatus' => 'C',
                    'canceldate' => date('d-m-Y H:m:s'),
                    'cancelby' => $userId,
                    'reason' => $reason,
                );
                $this->db->where('docno',$docno);
                $this->db->update('sc_trx.approvals_system',$info);

                header("Content-Type: text/json");
                echo json_encode(
                    array(
                        'success' => true,
                        'reason' => 'Dokumen '.$doctypename.' Dengan Nomor '.$docno.' Telah Ditolak , Alasan: '.$reason,
                        'status' => 'success',
                        'allow' =>  true,
                        'date' =>  date('d-m-Y H:m:s')
                    )
                );

                /* TESTING EMAIL APPLICATION

                $penerima_mail = null;
                $loopreceiver=$this->m_mobileApprovals->q_who_receive_email(trim($dtlAp['docref']))->result();
                foreach($loopreceiver as $lr){
                    $penerima_mail.=trim($lr->email).',';
                }

                $sender=$this->m_mailserver->q_smtp("NSANBI")->row_array();
                $dari=$sender['primarymail'];
                $subject='PERSETUJUAN UNTUK DOKUMEN : '.trim($dtlAp['doctypename']);

                $this->email->from($dari, 'PT NUSA UNGGUL SARANA ADICIPTA');
                $this->email->to($penerima_mail);
                //$this->email->cc($cc);
                //$this->email->bcc($bcc);
                $this->email->subject($subject);
                $this->email->message('DOKUMEN : '.trim($dtlAp['docno']).' JENIS APLIKASI : '.trim($dtlAp['erptype']).' TYPE : '.trim($dtlAp['doctypename']).'
                TELAH DITOLAK
                DENGAN ALASAN : '.$reason);

                if ($this->email->send()) {
                    header("Content-Type: text/json");
                    echo json_encode(
                        array(
                            'success' => true,
                            'reason' => 'Dokumen '.$doctypename.' Dengan Nomor '.$docno.' Telah Ditolak',
                            'status' => 'success',
                            'allow' =>  true,
                            'date' =>  date('d-m-Y H:m:s')
                        )
                    );
                } else {
                    show_error($this->email->print_debugger());
                }*/
                /* TESTING APPLICATION */

            }

        } else {
            //FAIL
            header("Content-Type: text/json");
            echo json_encode(
                array(
                    'success' => false,
                    'reason' => 'Maaf Galat',
                    'status' => 'success',
                    'allow' =>  false,
                    'date' =>  date('d-m-Y H:m:s')
                )
            );
        }

    }




}
