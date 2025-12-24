<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cashbon extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('master/m_akses'));
		$this->load->library(array('template', 'flashmessage', ));
		if (!$this->session->userdata('nik')) {
			redirect(base_url() . '/');
		}
	}
	public function cook() {
        sleep(60 * 2);
        echo 'Ok';
    }
	public function index() {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'M_Cashbon','trans/M_TrxType'));
        $data['type'] = $this->M_TrxType->q_master_search_where('
			AND a.group IN (\'CASHBONTYPE\') AND id not in (\'DN\')
			')->result();
        $data['status'] = array('Menunggu Persetujuan' => 'Menunggu Persetujuan','Disetujui'=>'Disetujui','Dibatalkan'=>'Dibatalkan',''=>'Semua');

        if ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $this->datatablessp->datatable('table-cashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, nik, nmlengkap, totalcashbonformat, statustext, nmdept, nmsubdept, type, statuscolor, cashbonid, dutieid, superior, status, paymenttype, formatpaymenttype, totalcashbon, formattype, inputby, inputdate, approveby, approvedate, superiors')
                ->addcolumn('no', 'no')
                ->addcolumn('reformatnominal','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'totalcashbonformat')
                ->addcolumn('status', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','statustext, statuscolor')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/cashbon/actionpopup/$1').'\' class=\'btn btn-sm btn-info popup pull-right\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;AKSI</i></a>', 'branch, cashbonid, type, dutieid', true)
                ->addcolumn('detail', '<a href=\''.site_url('kasbon_umum/cashbon/detail/$1').'\' class=\'btn btn-sm bg-maroon read-detail pull-right\'><i class=\'fa fa-bars\'>&nbsp;&nbsp;RINCIAN</i></a>', 'branch, cashbonid, type, dutieid', true)
                ->querystring($this->M_Cashbon->q_transaction_txt_where(' AND TRUE '))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o. Kasbon', 'cashbonid', true, true, true,array('cashbonid','popup'))
                ->header('Status', 'statustext', true, true, true, array('status'))
                ->header('Nama Karyawan', 'nmlengkap', true, true, true)
                ->header('Jabatan', 'nmdept', true, true, true, array('nmdept', 'nmsubdept'))
                ->header('Nominal (Rp)', 'totalcashbon', true, true, true, array('reformatnominal'))
                ->header('Pembayaran', 'formatpaymenttype', true, true, true, array('formatpaymenttype'))
                ->header('Tipe', 'formattype', true, true, true)
                ->header('', '', false, false, true, array('detail'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Kasbon Karyawan';
            $this->template->display('kasbon_umum/cashbon/v_read', $data);
        } else {
            $this->datatablessp->datatable('table-cashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, nik, nmlengkap, totalcashbonformat, statustext, nmdept, nmsubdept, type, statuscolor, cashbonid, dutieid, superior, status, paymenttype, formatpaymenttype, totalcashbon, formattype, inputby, inputdate, approveby, approvedate, superiors')
                ->addcolumn('no', 'no')
                ->addcolumn('reformatnominal','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'totalcashbonformat')
                ->addcolumn('status', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','statustext, statuscolor')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/cashbon/actionpopup/$1').'\' class=\'btn btn-sm btn-info popup pull-right\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;AKSI</i></a>', 'branch, cashbonid, type, dutieid', true)
                ->addcolumn('detail', '<a href=\''.site_url('kasbon_umum/cashbon/detail/$1').'\' class=\'btn btn-sm bg-maroon read-detail pull-right\'><i class=\'fa fa-bars\'>&nbsp;&nbsp;RINCIAN</i></a>', 'branch, cashbonid, type, dutieid', true)
                ->querystring($this->M_Cashbon->q_transaction_txt_where(' AND search ILIKE \'%'.$this->session->userdata('nik').'%\' '))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o. Kasbon', 'cashbonid', true, true, true,array('cashbonid','popup'))
                ->header('Status', 'statustext', true, true, true, array('status'))
                ->header('Nama Karyawan', 'nmlengkap', true, true, true)
                ->header('Jabatan', 'nmdept', true, true, true, array('nmdept', 'nmsubdept'))
                ->header('Nominal (Rp)', 'totalcashbon', true, true, true, array('reformatnominal'))
                ->header('Pembayaran', 'formatpaymenttype', true, true, true, array('formatpaymenttype'))
                ->header('Tipe', 'formattype', true, true, true)
                ->header('', '', false, false, true, array('detail'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Kasbon Karyawan';
            $this->template->display('kasbon_umum/cashbon/v_read', $data);
        }
	}

    function actionpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_Cashbon'));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $url = (trim($cashbon->type) == 'DN' ) ? 'trans/':'kasbon_umum/';
        header('Content-Type: application/json');
        if (!is_null($cashbon->approveby) && !empty($cashbon->approveby) && !is_null($cashbon->approvedate)) {
            echo json_encode(array(
                'data' => $cashbon,
                'canprint' => true,
                'next' => site_url( $url.'cashbon/printoption/'.bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid, )))),
            ));
        } else if (!is_null($cashbon->cashbonid) && !is_null($cashbon->cashbonid) && !empty($cashbon->cashbonid)) {
            if ($cashbon->status != 'C'){
                if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$cashbon->cashbonid.'\' AND superiors ILIKE \'%'.$this->session->userdata('nik').'%\' ')->num_rows() > 0) {
                    echo json_encode(array(
                        'data' => $cashbon,
                        'canapprove' => true,
                        'next' => array(
                            'update' => site_url($url.'cashbon/update/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid, 'type' => $cashbon->type)))),
                            'approve' => site_url($url.'cashbon/approve/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid, 'type' => $cashbon->type)))),
                        ),
                    ));
                } else {
                    echo json_encode(array(
                        'data' => $cashbon,
                        'canupdate' => true,
                        'next' => site_url($url.'cashbon/update/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                    ));
                }
            }else{
                echo json_encode(array(
                    'data' => $cashbon,
                    'canceled' => true,
                ));
            }

        } else {
            echo json_encode(array(
                'data' => array('dutieid' => $json->dutieid),
                'cancreate' => true,
                'next' => site_url($url.'cashbon/create/'.bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'dutieid' => $cashbon->dutieid, )))),
            ));
        }
    }

    function actionpopup_new($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_Cashbon'));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();

        header('Content-Type: application/json');
        if (!is_null($cashbon->approveby) && !empty($cashbon->approveby) && !is_null($cashbon->approvedate)) {
            echo json_encode(array(
                'data' => $cashbon,
                'canprint' => true,
                'next' => site_url('kasbon_umum/cashbon/printoption/'.bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid, )))),
            ));
        } else if (!is_null($cashbon->cashbonid) && !is_null($cashbon->cashbonid) && !empty($cashbon->cashbonid)) {
            if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$cashbon->cashbonid.'\' AND superiors ILIKE \'%'.$this->session->userdata('nik').'%\' ')->num_rows() > 0) {
                echo json_encode(array(
                    'data' => $cashbon,
                    'canapprove' => true,
                    'next' => array(
                        'update' => site_url('kasbon_umum/cashbon/update/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                        'approve' => site_url('kasbon_umum/cashbon/approve/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                    ),
                ));
            } else {
                echo json_encode(array(
                    'data' => $cashbon,
                    'canupdate' => true,
                    'next' => site_url('kasbon_umum/cashbon/update/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                ));
            }
        }
    }

    function create_cashbon($param)
    {
        $this->load->model(array('M_CashbonComponent','M_Cashbon','M_FindDocument'));
        $this->M_Cashbon->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $this->M_CashbonComponent->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $this->M_FindDocument->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));

        if ($param){
            $json = json_decode(
                hex2bin($param)
            );
            $this->load->model(array('trans/M_TrxType'));
            $type = $this->M_TrxType->q_master_search_where('
			    AND a.group IN (\'CASHBONTYPE\') AND id IN (\''.$json->type.'\')
			')->row();
            if ($type) {

                switch ($type->id){
                    case "PO":
                        $this->M_FindDocument->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ');
                        $data = array(
                            'saveurl' => site_url('kasbon_umum/cashbon/docreate_cashbon'),
                            'title' => ' Kasbon ' . $type->text,
                            'title_detail' => ' Dokumen ' . $type->text,
                            'code_type' => $json->type,
                            'type'  => $param,
                            'formattype'    => $type->text,
                            'cashboncomponents'         => $this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                            'cashboncomponentsempty'    => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                        );
                        $this->template->display('kasbon_umum/cashbon/v_create_po', $data);
                        break;
                    case "BL":
                        $data = array(
                            'saveurl'                   => site_url('kasbon_umum/cashbon/docreate_cashbon'),
                            'title'                     => ' Kasbon ' . $type->text,
                            'title_detail'              => ' Dokumen ' . $type->text,
                            'code_type'                 => $json->type,
                            'type'                      => $param,
                            'formattype'    => $type->text,
                            'cashboncomponents'         => $this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                            'cashboncomponentsempty'    => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                        );
                        $this->template->display('kasbon_umum/cashbon/v_create_bl', $data);
                        break;
                    case "AI":
                        $data = array(
                            'saveurl'                   => site_url('kasbon_umum/cashbon/docreate_cashbon'),
                            'title'                     => ' Kasbon ' . $type->text,
                            'title_detail'              => ' Dokumen ' . $type->text,
                            'code_type'                 => $json->type,
                            'type'                      => $param,
                            'formattype'                => $type->text,
                            'cashboncomponents'         => $this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                            'cashboncomponentsempty'    => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                        );
                        $this->template->display('kasbon_umum/cashbon/v_create_bl', $data);
                        break;
                }

            }else{
                redirect('kasbon_umum/cashbon/index');
            }
        }else{
            redirect('kasbon_umum/cashbon/index');
        }


    }

    function createcomponentpopuppo($param=null)
    {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->model(array('trans/m_employee','M_Cashbon','M_CashbonComponent','M_FindDocument'));
        $this->load->library(array('datatablessp'));
        $this->M_Cashbon->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik')),'dutieid' => $this->input->get_post('data') ));
        //$this->M_FindDocument->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$this->input->get_post('data').'\' ')->row();
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND TRIM(cashbonid) = \''.$this->session->userdata('nik').'\' 
            AND TRIM(dutieid) = \''.trim($employee->nik).'\' 
            AND TRIM(inputby) <> \''.$this->session->userdata('nik').'\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon karyawan nomer <b>'.$edited->dutieid.'</b> sedang diinput oleh <b>'.$edited->inputby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }
        $this->M_Cashbon->q_temporary_create(array(
            'branch' => $this->session->userdata('branch'),
            'cashbonid' => $this->session->userdata('nik'),
            'dutieid' => $employee->nik,
            'superior' => '',
            'status' => 'I',
            'paymenttype' => '',
            'totalcashbon' => 0,
            'type'      => $json->type,
            'inputby' => $this->session->userdata('nik'),
            'inputdate' => date('Y-m-d H:i:s'),
        ));
        $temporary = $this->M_FindDocument->q_master_po_where(' AND pono in (select pono from sc_tmp.cashbon_component_po)')->result();
        $this->load->view('kasbon_umum/cashbon/v_create_component_modal_po', array(
            'temporary' => $temporary,
            'title' => 'Tambah PO',
            'employee' => $employee,
            'type' => $json->type,
        ));
    }

    function createcomponentpopup($param=null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee','M_Cashbon','M_CashbonComponent'));
        $this->load->library(array('datatablessp'));
        $this->M_Cashbon->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik')),'dutieid' => $this->input->get_post('data') ));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$this->input->get_post('data').'\' ')->row();
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND TRIM(cashbonid) = \''.$this->session->userdata('nik').'\' 
            AND TRIM(dutieid) = \''.trim($employee->nik).'\' 
            AND TRIM(inputby) <> \''.$this->session->userdata('nik').'\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon karyawan nomer <b>'.$edited->dutieid.'</b> sedang diinput oleh <b>'.$edited->inputby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }
        $this->M_Cashbon->q_temporary_create(array(
            'branch' => $this->session->userdata('branch'),
            'cashbonid' => $this->session->userdata('nik'),
            'dutieid' => $employee->nik,
            'superior' => '',
            'status' => 'I',
            'paymenttype' => '',
            'totalcashbon' => 0,
            'type'      => $json->type,
            'inputby' => $this->session->userdata('nik'),
            'inputdate' => date('Y-m-d H:i:s'),
        ));

        $this->load->view('kasbon_umum/cashbon/v_create_component_modal', array(
            'title' => 'Detail Biaya Kasbon',
            'employee' => $employee,
            'type' => $json->type,
            'cashboncomponents' => $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
        ));
    }

    public function createcomponent($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $nik = $this->input->get_post('data');
        $this->load->model(array('trans/m_employee','M_Cashbon', 'M_CashbonComponent'));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$nik.'\' ')->row();
        $total = $this->M_Cashbon->q_temporary_read_where('AND cashbonid = \''.$this->session->userdata('nik').'\' AND type = \''.$json->type.'\' ')->row();
        if($this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\' ') AND $this->M_Cashbon->q_temporary_read_where('  AND cashbonid = \''.$this->session->userdata('nik').'\' ') ){
            $totalcashbon = $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\' ')->row();
        }

        $this->load->view('kasbon_umum/cashbon/v_component_read', array(
            'cashbon' => ($total) ? $total : $totalcashbon,
            'cashboncomponents' => $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
        ));
    }

    public function createcomponentpo($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $nik = $this->input->get_post('data');
        $this->load->model(array('trans/m_employee','M_Cashbon', 'M_CashbonComponent','M_FindDocument'));

        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$nik.'\' ')->row();
        $this->load->view('kasbon_umum/cashbon/v_component_po_read', array(
            'cashboncomponentspo' => $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' ')->result(),
        ));
    }

    public function docreatecomponentpopuppo($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_Cashbon', 'M_CashbonComponent','M_FindDocument' ));
        $documentid = $this->input->post('documentid');
        $documentid_clause = sprintf("'%s'", implode("', '", $documentid));
        $podetail = $this->M_FindDocument->q_master_po_detail_where(' AND a.pono in ( '.$documentid_clause.' ) ')->result();
        $this->db->trans_start();
        foreach ($podetail as $row){
            $this->M_FindDocument->q_temporary_create(array(
                'branch'        =>  $this->session->userdata('branch'),
                'cashbonid'      =>  $this->session->userdata('nik'),
                'pono'          =>  $row->pono,
                'nomor'         =>  $row->nomor,
                'stockcode'      =>  $row->stockcode,
                'stockname'     =>  $row->stockname,
                'qty'     =>  $row->qty,
                'pricelist'     =>  str_replace('.','',$row->pricelistformat),
                'brutto'     =>  str_replace('.','',$row->bruttoformat),
                'netto'     =>  str_replace('.','',$row->nettoformat),
                'dpp'     =>  str_replace('.','',$row->dppformat),
                'ppn'     =>  str_replace('.','',$row->ppnformat),
                'inputby'     =>  $this->session->userdata('nik'),
                'inputdate'     =>  date('Y-m-d H:i:s')
            ));
        }
        $this->db->trans_complete();
        $totaltemporary = $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' ');
        $description = $this->M_FindDocument->q_selected_document(' AND inputby = \''.$this->session->userdata('nik').'\' ')->row();

        $this->db->trans_start();
        if ($this->M_CashbonComponent->q_temporary_exists(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ') AND $this->M_Cashbon->q_temporary_exists(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' AND type = \''.$json->type.'\' ') ){
            foreach ($this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND type = \''.$json->type.'\'')->result() as $index => $row) {
                $this->M_CashbonComponent->q_temporary_update(array(
                    'nominal' => $row->componentid == 'BPO' ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'quantityday' => 0,
                    'totalcashbon' => $row->componentid == 'BPO' ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'description' => $row->componentid == 'BPO' ? $description->selectedpono : $row->description,
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ),array(
                    'branch' => $this->session->userdata('branch'),
                    'cashbonid' => $this->session->userdata('nik'),
                    'componentid' => $row->componentid,
                ));
            }
        }else{
            foreach ($this->M_CashbonComponent->q_empty_read_where(' AND type = \''.$json->type.'\'')->result() as $index => $row) {
                $this->M_CashbonComponent->q_temporary_create(array(
                    'branch' => $this->session->userdata('branch'),
                    'cashbonid' => $this->session->userdata('nik'),
                    'componentid' => $row->componentid,
                    'nominal' => $row->componentid == 'BPO' ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'quantityday' => 0,
                    'totalcashbon' => $row->componentid == 'BPO' ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'description' => $row->componentid == 'BPO' ? rtrim($description,', ') : $row->description,
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ));
            }
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail PO berhasil ditambahkan'
        ));
    }


    public function docreatecomponentpopup($param=null) {

        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_Cashbon', 'M_CashbonComponent', ));

        $id = $this->input->post('id');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => strtoupper($description[$index]),
            )));
        }
        $this->M_CashbonComponent->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\'  ');
        $this->db->trans_start();
        foreach ($this->M_CashbonComponent->q_empty_read_where(' AND active AND type = \''.$json->type.'\'')->result() as $index => $row) {
            $row->nominal = ($data[$row->componentid]->componentid == 'BPO') ? (int)$data[$row->componentid]->nominal : $row->nominal;
            $row->totalcashbon = ($data[$row->componentid]->componentid == 'BPO') ? (int)$data[$row->componentid]->nominal : $row->totalcashbon;
            $row->description = ($data[$row->componentid]->componentid == 'BPO') ? $data[$row->componentid]->description : $row->description;
            $this->M_CashbonComponent->q_temporary_create(array(
                'branch' => $this->session->userdata('branch'),
                'cashbonid' => $this->session->userdata('nik'),
                'componentid' => $row->componentid,
                'nominal' => $row->readonly == 't' ? $row->nominal : (int)$data[$row->componentid]->nominal,
                'quantityday' => 0,
                'totalcashbon' => $row->readonly == 't' ? $row->totalcashbon : (int)$data[$row->componentid]->nominal,
                'description' => $row->readonly == 't' ? $row->description : $data[$row->componentid]->description,
                'inputby' => $this->session->userdata('nik'),
                'inputdate' => date('Y-m-d H:i:s'),
            ));
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail biaya kasbon berhasil dibuat'
        ));
    }


    public function docreate($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'M_FindDocument' ));

        if ($json->type == 'PO'){
            if (!$this->M_FindDocument->q_temporary_exists(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ') AND !$this->M_Cashbon->q_temporary_exists(' TRUE AND dutieid = \''.$this->input->post('emp_nik').'\' ') ){
                header('Content-Type: application/json');
                echo json_encode(array(
                    'message' => 'ddddd'
                ));
            }
        }
        if ($this->M_Cashbon->q_temporary_exists(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ') && $this->M_CashbonComponent->q_temporary_exists(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ')) {
            $this->M_Cashbon->q_temporary_update(array(
                'paymenttype' => $this->input->post('paymenttype'),
                'status' => 'F',
                'inputby' => $this->session->userdata('nik'),
                'inputdate' => date('Y-m-d H:i:s'),
            ), array(
                'cashbonid' => $this->session->userdata('nik'),
            ));
            $transaction = $this->M_Cashbon->q_transaction_read_where(' 
                    AND inputby = \''.trim($this->session->userdata('nik')).'\' 
                    ORDER BY inputdate DESC 
                    ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data kasbon karyawan berhasil dibuat dengan nomer <b>'.$transaction->cashbonid.'</b>'
                ));
            } else {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data kasbon karyawan gagal dibuat'
                ));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>detail biaya kasbon</b> kosong, silahkan input terlebih dahulu'
            ));
        }
    }

    public function docancel($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $nik = $this->input->get_post('data');
        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'M_FindDocument' ));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$nik.'\' ')->row();
        $this->db->trans_start();
        if ($this->M_Cashbon->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' OR updateby = \''.$this->session->userdata('nik').'\' OR inputby = \''.$this->session->userdata('nik').'\' ') && $this->M_CashbonComponent->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\'  OR updateby = \''.$this->session->userdata('nik').'\' OR inputby = \''.$this->session->userdata('nik').'\' ') && $this->M_FindDocument->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\'  OR updateby = \''.$this->session->userdata('nik').'\' OR inputby = \''.$this->session->userdata('nik').'\' ') ) {
            $this->db->trans_complete();
            header('Content-Type: application/json');
            echo json_encode(array(
                'message' => 'Data kasbon karyawan berhasil direset'
            ));
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>kasbon karyawan</b> tidak berhasil direset'
            ));
        }
    }

    function update($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'M_FindEmployee','M_FindDocument', 'M_Cashbon', 'M_CashbonComponent', 'trans/M_TrxType'));

        $this->db->trans_start();
        $this->M_Cashbon->q_temporary_delete(array('updateby' => trim($this->session->userdata('nik'))));
        $this->M_CashbonComponent->q_temporary_delete(' TRUE AND updateby = \''.$this->session->userdata('nik').'\'  ');
        $this->M_FindDocument->q_temporary_delete(' TRUE AND updateby = \''.$this->session->userdata('nik').'\'  ');

        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();

        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon  karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }

        $this->M_Cashbon->q_transaction_update(
            array('status' => 'U', 'updateby' => $this->session->userdata('nik'), 'updatedate' => date('Y-m-d H:i:s'),),
            array('cashbonid' => $json->cashbonid,)
        );

        $temporary = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND updateby = \''.$this->session->userdata('nik').'\' 
            ORDER BY updatedate DESC 
            ')->row();

        if (!is_null($temporary) && !is_nan($temporary)) {
            $cashbonfind = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' ')->row();
            $employee = $this->M_FindEmployee->q_mst_txt_where(' AND nik = \''.trim($cashbonfind->nik).'\' ')->row();
            $view = ($json->type == 'PO' ) ? 'kasbon_umum/cashbon/v_update_po':'kasbon_umum/cashbon/v_update';
            $this->db->trans_complete();
            $this->template->display($view, array(
                'title' => 'Update Kasbon Karyawan',
                'employee' => $employee,
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$temporary->paymenttype.'\' ')->result(),
                'cashbon' => $temporary,
                'cashboncomponentspo' => $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND inputby = \''.trim($this->session->userdata('nik')).'\' ')->result(),
                'cashboncomponents' => $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
                'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
            ));
        }
    }

    function updatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_FindEmployee' ,'M_CashbonComponent'));

        $this->M_Cashbon->q_temporary_update(array(
            'updateby' => $this->session->userdata('nik'),
            'updatedate' => date('Y-m-d H:i:s'),
        ), array(
            'cashbonid' => $json->cashbonid,
        ));
        $cashbonfind = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' ')->row();
        $employee = $this->M_FindEmployee->q_mst_txt_where(' AND nik = \''.trim($cashbonfind->nik).'\' ')->row();
        $this->load->view('kasbon_umum/cashbon/v_update_component_modal', array(
            'title' => 'Detail Biaya Kasbon',
            'employee' => $employee,
            'cashbon' => $this->M_Cashbon->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'cashboncomponents' => $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
        ));
    }

    public function doupdatecomponentpopuppo($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'M_FindEmployee','M_Cashbon', 'M_CashbonComponent','M_FindDocument' ));
        $documentid = $this->input->post('documentid');
        $documentid_clause = sprintf("'%s'", implode("', '", $documentid));
        $podetail = $this->M_FindDocument->q_master_po_detail_where(' AND a.pono in ( '.$documentid_clause.' ) ')->result();
        $this->db->trans_start();
        foreach ($podetail as $row){
            $this->M_FindDocument->q_temporary_create(array(
                'branch'        =>  $json->branch,
                'cashbonid'      =>  $json->cashbonid,
                'pono'          =>  $row->pono,
                'nomor'         =>  $row->nomor,
                'stockcode'      =>  $row->stockcode,
                'stockname'     =>  $row->stockname,
                'qty'     =>  $row->qty,
                'pricelist'     =>  str_replace('.','',$row->pricelistformat),
                'brutto'     =>  str_replace('.','',$row->bruttoformat),
                'netto'     =>  str_replace('.','',$row->nettoformat),
                'dpp'     =>  str_replace('.','',$row->dppformat),
                'ppn'     =>  str_replace('.','',$row->ppnformat),
                'inputby'     =>  $this->session->userdata('nik'),
                'inputdate'     =>  date('Y-m-d H:i:s')
            ));
        }
        $this->db->trans_complete();
        $totaltemporary = $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ');
        foreach ($totaltemporary->result() as $item){
            $description .= $item->pono.', ';
        }
        $this->db->trans_start();
        if ($this->M_CashbonComponent->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ') AND $this->M_Cashbon->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' AND type = \''.$json->type.'\' ') ){

            foreach ($this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND type = \''.$json->type.'\'')->result() as $index => $row) {
                $this->M_CashbonComponent->q_temporary_update(array(
                    'nominal' => $index == 0  ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'quantityday' => 0,
                    'totalcashbon' => $index == 0  ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'description' => $index == 0  ? rtrim($description,', ') : $row->description,
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ),array(
//                    'branch' => $json->branch,
                    'cashbonid' => $json->cashbonid,
                    'componentid' => $row->componentid,
                ));
            }
        }else{
            foreach ($this->M_CashbonComponent->q_empty_read_where(' AND type = \''.$json->type.'\'')->result() as $index => $row) {
                $this->M_CashbonComponent->q_temporary_create(array(
                    'branch' => $json->branch,
                    'cashbonid' => $json->cashbonid,
                    'componentid' => $row->componentid,
                    'nominal' => $row->readonly == 't' ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'quantityday' => 0,
                    'totalcashbon' => $row->readonly == 't' ? $totaltemporary->row()->sumnetto : $row->nominal,
                    'description' => $row->readonly == 't' ? rtrim($description,', ') : $row->description,
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ));
            }
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail PO berhasil ditambahkan'
        ));
    }

    function updatecomponentpopuppo($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_FindEmployee' ,'M_FindDocument' ,'M_CashbonComponent'));
        $this->M_Cashbon->q_temporary_update(array(
            'updateby' => $this->session->userdata('nik'),
            'updatedate' => date('Y-m-d H:i:s'),
        ), array(
            'cashbonid' => $json->cashbonid,
        ));
        $cashbonfind = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' ')->row();
        $employee = $this->M_FindEmployee->q_mst_txt_where(' AND nik = \''.trim($cashbonfind->nik).'\' ')->row();
        $temporary = $this->M_FindDocument->q_master_po_where(' AND pono in (select pono from sc_tmp.cashbon_component_po)')->result();
        $this->load->view('kasbon_umum/cashbon/v_update_component_modal_po', array(
            'title' => 'Tambah PO',
            'type' => $json->type,
            'temporary' => $temporary,
            'employee' => $employee,
            'cashbon' => $this->M_Cashbon->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'cashboncomponents' => $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
        ));
    }

    public function updatecomponent($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array( 'M_Cashbon', 'M_CashbonComponent', 'trans/m_employee'));
        $cashbonfind = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->employeeid.'\' ')->row();
        $total = $this->M_Cashbon->q_temporary_read_where('  AND cashbonid = \''.$json->cashbonid.'\' AND type = \''.$json->type.'\' ')->row();
        if($this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\' ') AND $this->M_Cashbon->q_temporary_read_where('  AND cashbonid = \''.$this->session->userdata('nik').'\' ') ){
            $totalcashbon = $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\' ')->row();
        }
        $this->load->view('kasbon_umum/cashbon/v_component_read', array(
            'cashbon' => ($total) ? $total : $totalcashbon,
            'cashboncomponents' => $this->M_CashbonComponent->q_temporary_read_where(' AND dutieid = \''.$employee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\'  ')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
        ));
    }
    public function updatecomponentpo($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee','M_Cashbon', 'M_CashbonComponent','M_FindDocument'));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->employeid.'\' ')->row();
        $this->load->view('kasbon_umum/cashbon/v_component_po_read', array(
            'cashboncomponentspo' => $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
        ));
    }

    public function doupdatecomponentpopuppo_old($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_Cashbon', 'M_CashbonComponent','M_FindDocument' ));
        $documentid = $this->input->post('documentid');
        $documentid_clause = sprintf("'%s'", implode("', '", $documentid));
        $this->M_FindDocument->q_temporary_delete(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ');
        $this->M_CashbonComponent->q_temporary_delete(' TRUE AND cashbonid = \''.$json->cashbonid.'\' AND componentid = \'BPO\' ');
        $podetail = $this->M_FindDocument->q_master_po_detail_where(' AND a.pono in ( '.$documentid_clause.' ) ')->result();
        $this->db->trans_start();
        foreach ($podetail as $row){
            $this->M_FindDocument->q_temporary_create(array(
                'branch'        =>  $json->branch,
                'cashbonid'      =>  $json->cashbonid,
                'pono'          =>  $row->pono,
                'nomor'         =>  $row->nomor,
                'stockcode'      =>  $row->stockcode,
                'stockname'     =>  $row->stockname,
                'qty'     =>  $row->qty,
                'pricelist'     =>  str_replace('.','',$row->pricelistformat),
                'brutto'     =>  str_replace('.','',$row->bruttoformat),
                'netto'     =>  str_replace('.','',$row->nettoformat),
                'dpp'     =>  str_replace('.','',$row->dppformat),
                'ppn'     =>  str_replace('.','',$row->ppnformat),
                'inputby'     =>  $this->session->userdata('nik'),
                'inputdate'     =>  date('Y-m-d H:i:s')
            ));
        }
        $this->db->trans_complete();
        $totaltemporary = $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $this->db->trans_start();
        foreach ($this->M_CashbonComponent->q_empty_read_where(' AND active AND type = \''.$json->type.'\'')->result() as $index => $row) {
            if ($row->readonly == 't'){
                $this->M_CashbonComponent->q_temporary_create(array(
                    'branch'        =>  $json->branch,
                    'cashbonid'      =>  $json->cashbonid,
                    'componentid' => $row->componentid,
                    'nominal'           => $row->readonly == 't' ? $totaltemporary->sumnetto : $row->nominal ,
                    'quantityday'           => 0,
                    'totalcashbon'           => $row->readonly == 't' ?  $totaltemporary->sumnetto : $row->nominal,
                    'description'           => $row->readonly == 't' ? str_replace('\'','',$documentid_clause) : $row->description,
                    'inputby'           => $this->session->userdata('nik'),
                    'inputdate'           => date('Y-m-d H:i:s'),
                ));
            }
        }

        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail PO berhasil ditambahkan'
        ));
    }

    public function doupdatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_Cashbon', 'M_CashbonComponent', ));
        $id = $this->input->post('id');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => strtoupper($description[$index]),
            )));
        }
        $this->db->trans_start();
        foreach ($this->M_CashbonComponent->q_empty_read_where(' AND active ')->result() as $index => $row) {
            $row->nominal = ($data[$row->componentid]->componentid == 'BPO') ? (int)$data[$row->componentid]->nominal : $row->nominal;
            $row->totalcashbon = ($data[$row->componentid]->componentid == 'BPO') ? (int)$data[$row->componentid]->nominal : $row->totalcashbon;
            $row->description = ($data[$row->componentid]->componentid == 'BPO') ? $data[$row->componentid]->description : $row->description;
            $this->M_CashbonComponent->q_temporary_update(array(
                'branch' => $json->branch,
                'cashbonid' => $json->cashbonid,
                'componentid' => $row->componentid,
                'nominal' => $row->readonly == 't' ? $row->nominal : (int)$data[$row->componentid]->nominal,
                'totalcashbon' => $row->readonly == 't' ? $row->totalcashbon : (int)$data[$row->componentid]->nominal,
                'description' => $row->readonly == 't' ? $row->description : $data[$row->componentid]->description,
                'updateby' => $this->session->userdata('nik'),
                'updatedate' => date('Y-m-d H:i:s'),
            ), array(
                'cashbonid' => $json->cashbonid,
                'componentid' => $row->componentid,
            ));
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail biaya kasbon berhasil diupdate'
        ));
    }

    public function doupdate($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'M_FindDocument' ));
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->dutieid.'\' ')->row();
        if ($json->type == 'PO'){
            if ($this->M_Cashbon->q_temporary_exists('TRUE AND dutieid = \''.$empleyee->nik.'\' ') && !$this->M_FindDocument->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ') ){
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'message' => 'Dokumen PO kosong',
                ));
                return;
            }
        }
        if ($this->M_Cashbon->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ') && $this->M_CashbonComponent->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ')) {
            $this->M_Cashbon->q_temporary_update(array(
                'paymenttype' => $this->input->post('paymenttype'),
                'status' => 'U',
                'updateby' => $this->session->userdata('nik'),
                'updatedate' => date('Y-m-d H:i:s'),
            ), array(
                'cashbonid' => $json->cashbonid,
            ));
            $transaction = $this->M_Cashbon->q_transaction_read_where(' 
                    AND updateby = \''.trim($this->session->userdata('nik')).'\' 
                    ORDER BY updatedate DESC 
                ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data kasbon karyawan dengan nomer <b>'.$transaction->cashbonid.'</b> berhasil diubah'
                ));
            } else {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data kasbon karyawan gagal diubah'
                ));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>detail biaya kasbon</b> kosong, silahkan input terlebih dahulu'
            ));
        }
    }

    function approve($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'M_TrxType', 'M_FindDocument' ));
        $this->db->trans_start();
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }
        $transaksi = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND approvedate IS NULL ')->row();
        if (!is_null($transaksi) && !is_nan($transaksi)) {
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
            $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
            $this->db->trans_complete();
            $this->template->display('kasbon_umum/cashbon/v_approve', array(
                'title' => 'Persetujuan Kasbon Karyawan',
                'approve' => true,
                'employee' => $empleyee,
                'dinas' => $cashbon,
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$transaksi->paymenttype.'\' ')->row(),
                'cashbon' => $transaksi,
                'cashboncomponentspo' => $this->M_FindDocument->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$empleyee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND TRIM(type) = \''.trim($cashbon->type).'\' ')->result(),
                'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND TRIM(type) = \''.trim($cashbon->type).'\' ')->result(),
            ));
        }
    }

    public function doapprove($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', ));
        $this->db->trans_start();
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }
        $this->M_Cashbon->q_transaction_update(
            array('status' => 'P', 'approveby' => $this->session->userdata('nik'), 'approvedate' => date('Y-m-d H:i:s'),),
            array('cashbonid' => $json->cashbonid,)
        );
        $this->db->trans_complete();
        echo json_encode(array(
            'message' => 'Data kasbon karyawan berhasil disetujui'
        ));
    }

    function detail($param=null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $json->category = (is_null($json->category)) ? 'CASHBON' : $json->category;

        $this->load->library(array('datatablessp'));
        if ($json->type == 'DN'){
            $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'trans/m_dinas', 'trans/M_Cashbon', 'trans/M_CashbonComponent', 'trans/M_TrxType', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
            $transaksi = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
            if (!is_null($transaksi) && !is_nan($transaksi)) {
                $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->dutieid.'\' ')->row();
                $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
                $this->template->display('trans/cashbon/v_detail', array(
                    'title' => 'Rincian Kasbon Karyawan',
                    'employee' => $empleyee,
                    'category' => $json->category,
                    'dinas' => $dinas,
                    'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \''.$dinas->jenis_tujuan.'\' ')->row(),
                    'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \''.$dinas->tujuan_kota.'\' ')->row(),
                    'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \''.$dinas->transportasi.'\' ')->row(),
                    'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$transaksi->paymenttype.'\' ')->row(),
                    'cashbon' => $transaksi,
                    'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated ')->result(),
                    'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND active AND calculated ')->result(),
                ));
            }
        }else{
            $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'M_TrxType', 'M_FindDocument',));
            $transaksi = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
            if (!is_null($transaksi) && !is_nan($transaksi)) {
                $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
                $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
                $this->db->trans_complete();
                $this->template->display('kasbon_umum/cashbon/v_detail', array(
                    'title' => 'Rincian Kasbon Karyawan',
                    'approve' => true,
                    'employee' => $empleyee,
                    'category' => $json->category,
                    'dinas' => $cashbon,
                    'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$transaksi->paymenttype.'\' ')->row(),
                    'cashbon' => $transaksi,
                    'cashboncomponentspo' => $this->M_FindDocument->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
                    'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$empleyee->nik.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND TRIM(type) = \''.trim($cashbon->type).'\' ')->result(),
                    'cashboncomponentsempty' => $this->M_CashbonComponent->q_empty_read_where(' AND active AND calculated AND TRIM(type) = \''.trim($cashbon->type).'\' ')->result(),
                ));
            }
        }

    }

	public function search() {
		header('Content-Type: application/json');
		$brand = $this->input->get_post('brand');
		$count = $this->M_DestinationType->q_master_search_where('
			AND a.active
			')->num_rows();
		$search = $this->input->get_post('search');
		$search = strtolower(urldecode($search));
		$perpage = $this->input->get_post('perpage');
		$perpage = intval($perpage);
		$perpage = $perpage < 1 ? $count : $perpage;
		$page = $this->input->get_post('page');
		$page = intval($page > 0 ? $page : 1);
		$limit = $perpage * ($page -1);
		$result = $this->M_DestinationType->q_master_search_where('
            AND a.active
            AND ( LOWER(id) LIKE \'%'.$search.'%\'
            OR LOWER(text) LIKE \'%'.$search.'%\'
            )
            ORDER BY text ASC
            LIMIT '.$perpage.' OFFSET '.$limit.'
            ')->result();
		echo json_encode(array(
			'totalcount' => $count,
			'search' => $search,
			'perpage' => $perpage,
			'page' => $page,
			'limit' => $limit,
			'location' => $result
		), JSON_NUMERIC_CHECK);
	}

    public function searchdocument() {
        $this->load->model(array('M_FindDocument'));
        $json = json_decode(
            hex2bin($this->input->get_post('group'))
        );
        switch ($json->type){
            case "PO":
                header('Content-Type: application/json');
                $count = $this->M_FindDocument->q_master_search_po_where('
                    AND id NOT IN (SELECT dutieid FROM sc_trx.cashbon)
                    AND id NOT IN (SELECT dutieid FROM sc_tmp.cashbon)
                    AND id NOT IN (SELECT pono FROM sc_trx.cashbon_component_po)
                    AND id NOT IN (SELECT pono FROM sc_tmp.cashbon_component_po)
                ')->num_rows();
                $search = $this->input->get_post('search');
                $search = strtolower(urldecode($search));
                $perpage = $this->input->get_post('perpage');
                $perpage = intval($perpage);
                $perpage = $perpage < 1 ? $count : $perpage;
                $page = $this->input->get_post('page');
                $page = intval($page > 0 ? $page : 1);
                $limit = $perpage * ($page -1);
                $result = $this->M_FindDocument->q_master_search_po_where('
                    AND id NOT IN (SELECT dutieid FROM sc_trx.cashbon)
                    AND id NOT IN (SELECT dutieid FROM sc_tmp.cashbon)
                    AND id NOT IN (SELECT pono FROM sc_trx.cashbon_component_po)
                    AND id NOT IN (SELECT pono FROM sc_tmp.cashbon_component_po)
                    AND ( LOWER(id) LIKE \'%'.$search.'%\'
                    OR LOWER(text) LIKE \'%'.$search.'%\'
                    )
                    ORDER BY id ASC
                    LIMIT '.$perpage.' OFFSET '.$limit.'
                ')->result();
                echo json_encode(array(
                    'totalcount' => $count,
                    'search' => $search,
                    'perpage' => $perpage,
                    'page' => $page,
                    'limit' => $limit,
                    'location' => $result
                ), JSON_NUMERIC_CHECK);
                break;
        }


    }

    public function printoption($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'trans/M_DestinationType', 'trans/M_CityCashbon','master/m_option', 'master/M_RegionalOffice' ));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ORDER BY updatedate DESC ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$empleyee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->load->view('kasbon_umum/cashbon/v_print_option', array(
            'title' => 'Cetak Kasbon '.ucwords(strtolower($cashbon->formattype)).' '.$cashbon->cashbonid,
            'city' => ucfirst(strtolower($city)).', ',
            'employee' => $empleyee,
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
            'cashbon' => $cashbon,
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
        ));
    }

    public function preview($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'M_Cashbon', 'M_CashbonComponent','master/m_option', 'master/M_RegionalOffice'  ));
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ORDER BY updatedate DESC ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$empleyee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->load->view('kasbon_umum/cashbon/v_read_pdf', array(
            'title' => 'Cetak Kasbon Karyawan '.$cashbon->cashbonid,
            'city' => ucfirst(strtolower($city)).', ',
            'fontsize' => $fontsize,
            'marginsize' => $marginsize,
            'paddingsize' => $paddingsize,
            'employee' => $empleyee,
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
            'cashbon' => $cashbon,
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
        ));
    }

    public function exportpdf($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library('pdfs');
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'trans/M_DestinationType', 'trans/M_CityCashbon', 'master/m_option', 'master/M_RegionalOffice'));
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ORDER BY updatedate DESC ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$empleyee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->pdfs->loadHtml(
            $this->load->view('kasbon_umum/cashbon/v_read_pdf', array(
                'title' => 'Cetak Kasbon Dinas Karyawan '.$cashbon->cashbonid,
                'city' => ucfirst(strtolower($city)).', ',
                'fontsize' => $fontsize,
                'marginsize' => $marginsize,
                'paddingsize' => $paddingsize,
                'employee' => $empleyee,
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
                'cashbon' => $cashbon,
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
            ), true)
        );
        $this->pdfs->setPaper('A4', 'landscape');
        $this->pdfs->render();
        $this->pdfs->stream('CASHBON'.$json->complaintid.'.PDF', array('Attachment' => 0));
    }

    public function searchemployee() {
        $this->load->model(array('M_FindEmployee'));
        header('Content-Type: application/json');
        $count = $this->M_FindEmployee->q_mst_txt_where(' AND nmlengkap is not null')->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->M_FindEmployee->q_mst_txt_where('
                    AND nmlengkap is not null
                    AND ( LOWER(id) LIKE \'%'.$search.'%\'
                    OR LOWER(text) LIKE \'%'.$search.'%\'
                    )
                    ORDER BY text ASC
                    LIMIT '.$perpage.' OFFSET '.$limit.'
                ')->result();
        echo json_encode(array(
            'totalcount' => $count,
            'search' => $search,
            'perpage' => $perpage,
            'page' => $page,
            'limit' => $limit,
            'location' => $result
        ), JSON_NUMERIC_CHECK);
    }

    function employeeautofill()
    {
        $this->load->model(array('M_FindEmployee'));
        $employee = $this->M_FindEmployee->q_mst_txt_where(' AND nik = \''.$this->input->post('nik').'\' ')->row();
        echo json_encode(array(
            'name'  => $employee->nmlengkap,
            'deptname'  => $employee->nmdept.' '.$employee->nmsubdept,
            'positionname'  => $employee->nmjabatan,
            'phone'  => (!$employee->nohp1 and !$employee->nohp2 )?'(belum diatur)':$employee->merge_phone,
            'account'  => (!$employee->norek)?'(belum diatur)':$employee->norek.' ['.$employee->namabank.']',
        ));
    }

    function documentdetail($param)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_FindDocument','M_CashbonComponent'));
        $type           = $this->input->post('documenttype');
        $documentid     = $this->input->post('documentid');
        switch ($type){
            case "PO":
                if ($documentid){
                    $documentid_clause = sprintf("'%s'", implode("', '", $documentid));
                    if($this->M_CashbonComponent->q_temporary_exists(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ')){
                        $this->M_CashbonComponent->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\'  ');
                    }
                    $pomaster = $this->M_FindDocument->q_master_po_where(' AND a.pono in ( '.$documentid_clause.' ) ')->result();
                    $total = $this->M_FindDocument->q_master_po_where(' AND a.pono in ( '.$documentid_clause.' ) ')->row()->sumtotal;

                    foreach ($pomaster as $row){
                        $pono .= $row->pono.',';
                    }
                    $pono = rtrim($pono, ", ");
                    $this->db->trans_start();
                    $this->M_CashbonComponent->q_temporary_create(array(
                        'branch' => $this->session->userdata('branch'),
                        'cashbonid' => $this->session->userdata('nik'),
                        'componentid' => 'BPO',
                        'nominal' => $total,
                        'quantityday' => 0,
                        'totalcashbon' => $total,
                        'description' => $pono,
                        'inputby' => $this->session->userdata('nik'),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                    $this->db->trans_complete();

                    die();
                    $podetail = $this->M_FindDocument->q_master_po_detail_where(' AND a.pono in ( '.$documentid_clause.' ) ')->result();
                    $data = array(
                        'total'     => ($total > 0)?$total:0,
                        'detail'    => $this->M_FindDocument->q_master_po_detail_where(' AND a.pono in ( '.$documentid_clause.' ) ')->result(),
                    );
                    $this->load->view('kasbon_umum/cashbon/v_detail_po',$data);
                }else{
                    echo 'pilih nomor PO';
                }

                break;
        }
    }

    function deletecomponentpo($param)
    {
        //test
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_FindDocument','M_CashbonComponent'));
        $json->cashbondid = ($json->cashbondid ? $json->cashbondid : $this->input->post('nik'));
        $this->M_FindDocument->q_temporary_delete(' TRUE AND cashbonid = \''.$json->cashbondid.'\' AND pono = \''.$json->pono.'\'  ');
        if ($this->M_FindDocument->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbondid.'\'' )){
            $exist = true;
            $totaltemporary = $this->M_FindDocument->q_temporary_read_where(' AND cashbonid = \''.$json->cashbondid.'\' ');
            $description = $this->M_FindDocument->q_selected_document(' AND inputby = \''.$this->session->userdata('nik').'\' ')->row();
        }

        $this->db->trans_start();

        foreach ($this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$json->cashbondid.'\' AND type = \''.$json->type.'\'')->result() as $index => $row) {
            $this->M_CashbonComponent->q_temporary_update(array(
                'nominal' => ($row->componentid == 'BPO' ? $totaltemporary->row()->sumnetto : $row->nominal),
                'quantityday' => 0,
                'totalcashbon' => ($row->componentid == 'BPO' ? $totaltemporary->row()->sumnetto : $row->nominal),
                'description' => ($row->componentid == 'BPO' ? $description->selectedpono : $row->description),
                'inputby' => $this->session->userdata('nik'),
                'inputdate' => date('Y-m-d H:i:s'),
            ),array(
                'cashbonid' => $json->cashbondid,
                'componentid' => $row->componentid,
            ));
        }
        $this->db->trans_complete();
    }

    function doinvalidate($param){
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'M_Cashbon', 'M_CashbonComponent', 'M_FindDocument' ));

        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }
        $transaksi = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND approvedate IS NULL ')->row();
        $this->db->trans_start();
        if ($transaksi){
            $this->M_Cashbon->q_transaction_update(
                array(
                    'status' => 'C',
                    'updateby' => $this->session->userdata('nik'),
                    'updatedate' => date('Y-m-d H:i:s')
                ),array(
                    'cashbonid' => $transaksi->cashbonid
                )
            );

            $this->M_Cashbon->q_temporary_delete(' TRUE AND cashbonid = \''.$json->cashbonid.'\' OR updateby = \''.$this->session->userdata('nik').'\' OR inputby = \''.$this->session->userdata('nik').'\' ');
            $this->M_CashbonComponent->q_temporary_delete(' TRUE AND cashbonid = \''.$json->cashbonid.'\'  OR updateby = \''.$this->session->userdata('nik').'\' OR inputby = \''.$this->session->userdata('nik').'\' ');
            $this->M_FindDocument->q_temporary_delete(' TRUE AND cashbonid = \''.$json->cashbonid.'\'  OR updateby = \''.$this->session->userdata('nik').'\' OR inputby = \''.$this->session->userdata('nik').'\' ');

        }
        $this->db->trans_complete();
        echo json_encode(array(
            'message' => 'Data kasbon karyawan berhasil dibatalkan'
        ));
    }

    function checkcomponenttemporary($param=null){
        $json = json_decode(
            hex2bin($param)
        );
        $id = $this->input->post('id');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => strtoupper($description[$index]),
            )));
        }
        $json->cashbonid = (is_null($json->cashbonid)) ? $this->session->userdata('nik') : $json->cashbonid;

        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponent', ));
        if( $this->M_CashbonComponent->q_temporary_exists('TRUE AND inputby = \''.$json->cashbonid.'\' ')){
            if ($this->M_Cashbon->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row()->totalcashbon > 0 ){
                return true;
            }else{
                foreach ($this->M_CashbonComponent->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->result() as $index => $row){
                    if($data[$row->componentid]->nominal <= 0 OR $data[$row->componentid]->description == ''){
                        header('Content-Type: application/json');
                        http_response_code(404);
                        echo json_encode(array(
                            'data' => array(),
                            'message' => 'Data '.$row->componentname.' tidak boleh kosong atau nol.'
                        ));
                    }
                }
            }
        } else {
            if( $this->M_Cashbon->q_temporary_exists('TRUE AND inputby = \''.$json->cashbonid.'\' ')){
                foreach ($this->M_CashbonComponent->q_empty_read_where(' AND type = \''.$json->type.'\' ')->result() as $index => $row){
                    if($data[$row->componentid]->nominal <= 0 OR $data[$row->componentid]->description == ''){
                        header('Content-Type: application/json');
                        http_response_code(404);
                        echo json_encode(array(
                            'data' => array(),
                            'message' => 'Data '.$row->componentname.' tidak boleh kosong atau nol.'
                        ));
                    }else{
                        return true;
                    }
                }
            }else{
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Total detail kasbon tidak boleh kosong atau nol.'
                ));
            }


        }
    }
}
