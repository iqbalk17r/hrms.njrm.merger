<?php defined('BASEPATH') or exit('No direct script access allowed');

class DeclarationCashbon extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('master/m_akses'));
        $this->load->library(array('template', 'flashmessage', ));
        if (!$this->session->userdata('nik')) {
            redirect(base_url() . '/');
        }
    }
    public function index($param = null) {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType','trans/m_employee', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent' ,'master/m_option'));
        $this->checkdutieidcharacter();
        $data['type'] = $this->M_TrxType->q_master_search_where('
			AND a.group IN (\'CASHBONTYPE\')
			')->result();
        $filter = '';
        if (!is_null($param)){

            $json = json_decode(hex2bin($param));

            if (!is_null($json)){
                if (!empty($json->month)){
                    $filter .= ' AND TO_CHAR(documentdate,\'yyyymm\') = \''.$json->month.'\' ';
                }
                if (!empty($json->status)){
                    $filter .= ' AND lower(statustext) = \''.$json->status.'\'  ';
                }
                if(!empty($json->type)){
                    $filter .= ' AND lower(typetext) = \''.$json->type.'\'  ';
                }
            }else{
                redirect('kasbon_umum/declarationcashbon/index');
            }

        }else{
            $filter = ' AND TO_CHAR(documentdate,\'yyyymm\') = \''.date('Ym').'\' ';
        }
        $this->M_DeclarationCashbon->q_temporary_delete(' TRUE AND  (declarationid = \''.trim($this->session->userdata('nik')).'\' OR inputby = \''.trim($this->session->userdata('nik')).'\' OR updateby = \''.trim($this->session->userdata('nik')).'\'  ) ');
        $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND  (declarationid = \''.trim($this->session->userdata('nik')).'\' OR inputby = \''.trim($this->session->userdata('nik')).'\' OR updateby = \''.trim($this->session->userdata('nik')).'\'  ) ');
        $data['status'] = array('Menunggu Persetujuan' => 'Menunggu Persetujuan','Disetujui'=>'Disetujui','Dibatalkan'=>'Dibatalkan','Belum Dibuat Kasbon'=>'Belum Dibuat Kasbon','Belum Dibuat Deklarasi'=>'Belum Dibuat Deklarasi',''=>'Semua');
        $limitDate = $this->m_option->read(' AND kdoption = \'DCL:LIMIT:DATE\' AND group_option = \'DECLARATION\' ')->row();
        $limitDate = ((is_null($limitDate) OR empty($limitDate)) ? date('Y-m-d',strtotime('2023-09-01')) : $limitDate->value1 );

        if ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $this->datatablessp->datatable('table-declarationcashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, declarationid, type, typetext, documentdate, documentdateformat, departuredate, employeeid, employeename, departmentname, subdepartmentname, statustext, statuscolor, category')
                ->addcolumn('no', 'no')
                ->addcolumn('reformatstatus', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','statustext, statuscolor')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/actionpopup/$1').'\' class=\'btn btn-sm btn-info popup pull-right\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;AKSI</i></a>', 'branch, declarationid, type', true)
                ->addcolumn('detail', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/detail/$1').'\' class=\'btn btn-sm bg-maroon read-detail pull-right\'><i class=\'fa fa-bars\'>&nbsp;&nbsp;RINCIAN</i></a>', 'branch, type, declarationid', true)
                ->querystring($this->M_DeclarationCashbon->q_index_txt_where(' AND TO_CHAR(documentdate,\'yyyy-mm-dd\') >= \''.$limitDate.'\'  '.(isset($filter) ? $filter : '')))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dokumen', 'documentid', true, true, true, array('documentid','popup'))
                ->header('Tanggal Dokumen', 'documentdate', true, true, true, array('documentdateformat'))
                ->header('Nama Karyawan', 'employeename', true, true, true)
                ->header('Jabatan', 'departmentname', true, true, true, array('departmentname', 'subdepartmentname'))
                ->header('Tipe', 'typetext', true, true, true, array('typetext'))
                ->header('Status', 'statustext', true, true, true, array('reformatstatus'))
                ->header('', '', false, false, true, array('detail'));
            $this->datatablessp->generateajax();
        } else {
            $this->datatablessp->datatable('table-declarationcashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, declarationid, type, typetext, documentdate, documentdateformat, departuredate, employeeid, employeename, departmentname, subdepartmentname, statustext, statuscolor, category')
                ->addcolumn('no', 'no')
                ->addcolumn('reformatstatus', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','statustext, statuscolor')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/actionpopup/$1').'\' class=\'btn btn-sm btn-info popup pull-right\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;AKSI</i></a>', 'branch, declarationid, type', true)
                ->addcolumn('detail', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/detail/$1').'\' class=\'btn btn-sm bg-maroon read-detail pull-right\'><i class=\'fa fa-bars\'>&nbsp;&nbsp;RINCIAN</i></a>', 'branch, type, declarationid', true)
                ->querystring($this->M_DeclarationCashbon->q_index_txt_where(' AND search LIKE \'%'.$this->session->userdata('nik').'%\' AND TO_CHAR(documentdate,\'yyyy-mm-dd\') >= \''.'2024-02-01'.'\' '.(isset($filter) ? $filter : '')))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dokumen', 'documentid', true, true, true, array('documentid','popup'))
                ->header('Tanggal Dokumen', 'documentdate', true, true, true, array('documentdateformat'))
                ->header('Nama Karyawan', 'employeename', true, true, true)
                ->header('Jabatan', 'departmentname', true, true, true, array('departmentname', 'subdepartmentname'))
                ->header('Tipe', 'typetext', true, true, true, array('typetext'))
                ->header('Status', 'statustext', true, true, true, array('reformatstatus'))
                ->header('', '', false, false, true, array('detail'));
            $this->datatablessp->generateajax();

        }
        $data['title'] = 'Deklarasi Kasbon Karyawan';
        $data['createUrl'] = site_url('kasbon_umum/declarationcashbon/employee');
        $data['filterUrl'] = site_url('kasbon_umum/declarationcashbon/filter');
        $this->template->display('kasbon_umum/declaration_cashbon/v_read', $data);
    }

    public function filter()
    {
        $this->load->model(array('trans/M_TrxType','trans/m_employee', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent' ,'master/m_option'));
        $this->load->library(array('datedifference'));
        $getType = $this->M_TrxType->q_master_search_where(' AND a.group IN (\'CASHBONTYPE\') ')->result();
        $data = array(
            'type' => $getType,
            'status' => array(''=>'Semua','Menunggu Persetujuan' => 'Menunggu Persetujuan','Disetujui'=>'Disetujui','Dibatalkan'=>'Dibatalkan',),
            'modalTitle' => 'Filter Pencarian',
            'content' => 'kasbon_umum/declaration_cashbon/v_filter',
            'formAction' => site_url('kasbon_umum/declarationcashbon/dofilter'),
            'years' => $this->datedifference->years(5,2022),
            'months' => $this->datedifference->months(),
        );
        $this->load->view($data['content'],$data);
    }

    public function dofilter()
    {

        $filterArr = array();
        $month = sprintf("%02d", (int)$this->input->post('month'));
        $year = $this->input->post('year');
        $type = $this->input->post('declarationcashbontype');
        $status = $this->input->post('declarationcashbonstatus');
        if (!empty($status)){
            $filterArr['status'] = strtolower($status);
        }
        if (!empty($type)){
            $filterArr['type'] = strtolower($type);
        }
        if (!empty($year) && !empty($month)){
            $setFilter = $year.$month;
            $filterArr['month'] = $setFilter;
        }
        redirect('kasbon_umum/declarationcashbon/index/'.bin2hex(json_encode($filterArr)));
    }

    public function documentlist($param = null) {
        $json = json_decode(hex2bin($param));
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType','trans/m_employee', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent' ,'master/m_option','M_Cashbon'));
        $data['type'] = $this->M_TrxType->q_master_search_where('
			AND a.group IN (\'CASHBONTYPE\')
			')->result();
        $this->M_DeclarationCashbon->q_temporary_delete(' TRUE AND  (declarationid = \''.trim($this->session->userdata('nik')).'\' OR inputby = \''.trim($this->session->userdata('nik')).'\' OR updateby = \''.trim($this->session->userdata('nik')).'\'  ) ');
        $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND  (declarationid = \''.trim($this->session->userdata('nik')).'\' OR inputby = \''.trim($this->session->userdata('nik')).'\' OR updateby = \''.trim($this->session->userdata('nik')).'\'  ) ');
        $data['status'] = array('Menunggu Persetujuan' => 'Menunggu Persetujuan','Disetujui'=>'Disetujui','Dibatalkan'=>'Dibatalkan','Belum Dibuat Kasbon'=>'Belum Dibuat Kasbon','Belum Dibuat Deklarasi'=>'Belum Dibuat Deklarasi',''=>'Semua');
        $limitDate = $this->m_option->read(' AND kdoption = \'DCL:LIMIT:DATE\' AND group_option = \'DECLARATION\' ')->row();
        $limitDate = ((is_null($limitDate) OR empty($limitDate)) ? date('Y-m-d',strtotime('2023-09-01')) : $limitDate->value1 );
//        $startdate = date('Y-m-d',strtotime('2023-09-01'));
        $filter = ' AND employeeid = \''.$json->nik.'\' AND status =\'P\' AND cashbonid NOT IN( select dc.cashbonid FROM sc_trx.declaration_cashbon dc WHERE dc.status IN(\'I\',\'P\') and dc.cashbonid is not null)';
        $this->datatablessp->datatable('table-declarationcashbon', 'table table-striped table-bordered table-hover', true)
            ->columns('branch, nik, nmlengkap, totalcashbonformat, statustext, nmdept, nmsubdept, type, statuscolor, cashbonid, dutieid, superior, status, paymenttype, formatpaymenttype, totalcashbon, formattype, inputby, inputdate, approveby, approvedate, superiors, employeeid')
            ->addcolumn('no', 'no')
            ->addcolumn('reformatnominal','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'totalcashbonformat')
            ->addcolumn('status', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','statustext, statuscolor')
            ->addcolumn('create', '<a href=\''.site_url('kasbon_umum/declarationcashbon/checktype/$1').'\'  class=\'btn btn-sm btn-info popup pull-right\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;PILIH</i></a>', 'branch, cashbonid, type, dutieid, employeeid', true)
            ->querystring($this->M_Cashbon->q_transaction_txt_where(' AND TRUE '.(isset($filter) ? $filter : '')))
            ->header('No.', 'no', false, false, true)
            ->header('<u>N</u>o. Kasbon', 'cashbonid', true, true, true,array('cashbonid','create'))
//            ->header('Status', 'statustext', true, true, true, array('status'))
            ->header('Nominal (Rp)', 'totalcashbon', true, true, true, array('reformatnominal'))
            ->header('Pembayaran', 'formatpaymenttype', true, true, true, array('formatpaymenttype'))
            ->header('Tipe', 'formattype', true, true, true);
        /*
        ->columns('branch, dutieid, cashbonid, type, typetext, documentid, employeeid, employeename, departmentname, subdepartmentname, positionname, statustext, statuscolor, category')
        ->addcolumn('no', 'no')
        ->addcolumn('reformatstatus', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','statustext, statuscolor')
        ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/actionpopup/$1').'\' class=\'btn btn-sm btn-info popup pull-right\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;AKSI</i></a>', 'branch, dutieid, cashbonid, type,category, employeeid', true)
        ->addcolumn('detail', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/detail/$1').'\' class=\'btn btn-sm bg-maroon read-detail pull-right\'><i class=\'fa fa-bars\'>&nbsp;&nbsp;RINCIAN</i></a>', 'branch, documentid, type, dutieid, category', true)
        ->querystring($this->M_Cashbon->q_transaction_txt_where(' AND TO_CHAR(inputdate,\'yyyy-mm-dd\') >= \''.$limitDate.'\'  '))
        ->header('No.', 'no', false, false, true)
        ->header('<u>N</u>o.Dokumen', 'documentid', true, true, true, array('documentid','popup'))
        ->header('Tanggal Dokumen', 'documentdate', true, true, true, array('documentdateformat'))
        ->header('Nama Karyawan', 'employeename', true, true, true)
        ->header('Departemen', 'departmentname', true, true, true, array( 'departmentname','subdepartmentname'))
        ->header('Tipe', 'typetext', true, true, true, array('typetext'))
        ->header('Tanggal Dinas', 'departuredate', true, true, false, array('dutieperiod'))
        ->header('Status', 'statustext', true, true, true, array('reformatstatus'));*/
        $this->datatablessp->generateajax();
        $data['title'] = 'Pilih Dokumen Kasbon Karyawan';
        $data['createUrl'] = site_url('kasbon_umum/declarationcashbon/employee');
        $this->template->display('kasbon_umum/declaration_cashbon/v_cashbon', $data);
    }

    public function employee()
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_Employee'));
        if ($this->m_akses->list_aksesperdep()->num_rows() < 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, nik, nmlengkap, nmdept, nmsubdept, nmjabatan')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/createoption/$1').'\' class=\'btn btn-sm btn-success popup pull-right\'>Buat Deklarasi</a>', 'branch, nik', true)
                ->querystring($this->M_Employee->q_mst_txt_where(' AND TRUE '))
                ->header('No.', 'no', false, false, true)
                ->header('Nik', 'nik', true, true, true, array('nik','popup') )
                ->header('Nama Karyawan', 'nmlengkap', true, true, true )
                ->header('Departemen', 'nmdept', true, true, true)
                ->header('Subdepartemen', 'nmsubdept', true, true, true)
                ->header('Jabatan', 'nmjabatan', true, true, true);
            $this->datatablessp->generateajax();
        } else {
            $this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, nik, nmlengkap, nmdept, nmsubdept, nmjabatan')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/declarationcashbon/createoption/$1').'\' class=\'btn btn-sm btn-success popup pull-right\'>Buat Deklarasi</a>', 'branch, nik', true)
                ->querystring($this->M_Employee->q_mst_txt_where(' AND search ilike \'%'.trim($this->session->userdata('nik')).'%\' '))
                ->header('No.', 'no', false, false, true)
                ->header('Nik', 'nik', true, true, true, array('nik','popup') )
                ->header('Nama Karyawan', 'nmlengkap', true, true, true )
                ->header('Departemen', 'nmdept', true, true, true)
                ->header('Subdepartemen', 'nmsubdept', true, true, true)
                ->header('Jabatan', 'nmjabatan', true, true, true);
            $this->datatablessp->generateajax();

        }
        $data['title'] = 'Daftar Karyawan';
        $data['direct'] = site_url('kasbon_umum/declarationcashbon/createoption/'.bin2hex(json_encode(array('createtype'=>'DI'))));
        $data['nondirect'] = site_url('kasbon_umum/declarationcashbon/createoption/'.bin2hex(json_encode(array('createtype'=>'ND'))));
        $this->template->display('kasbon_umum/declaration_cashbon/v_employee', $data);
    }
    function actionpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_DeclarationCashbon'));
        //$declarationcashbon = $this->M_DeclarationCashbon->q_cashbon_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $declarationcashbon = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row();
        $urlpath = ($json->type == 'DN')?'kasbon_umum/declarationcashbondinas':'kasbon_umum/declarationcashbon';
        header('Content-Type: application/json');
        if ($declarationcashbon->status == 'C' ){
            http_response_code(403);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Dokumen deklarasi kasbon sudah pernah dibatalkan'
            ));
        }else{

            if (!is_null($declarationcashbon->approveby) && !empty($declarationcashbon->approveby) && !is_null($declarationcashbon->approvedate) && $declarationcashbon->status <> 'C') {
                echo json_encode(array(
                    'data' => $declarationcashbon,
                    'canprint' => true,
                    'next' => site_url($urlpath.'/printoption/'.bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid, )))),
                ));
            } else if (!is_null($declarationcashbon->declarationid) && !is_nan($declarationcashbon->declarationid) && !empty($declarationcashbon->declarationid)) {
                if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$declarationcashbon->declarationid.'\' AND superiors ILIKE \'%'.$this->session->userdata('nik').'%\' ')->num_rows() > 0) {
                    echo json_encode(array(
                        'data' => $declarationcashbon,
                        'canapprove' => true,
                        'next' => array(
                            'update' => site_url($urlpath.'/update/'.bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid, )))),
                            'approve' => site_url($urlpath.'/approve/'.bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid, )))),
                        ),
                    ));
                } else {
                    echo json_encode(array(
                        'data' => $declarationcashbon,
                        'canupdate' => true,
                        'next' => site_url($urlpath.'/update/'.bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid, )))),
                    ));
                }
            } else {
                echo json_encode(array(
                    'data' => array('dutieid' => $json->dutieid, 'cashbonid' => $json->cashbonid, ),
                    'cancreate' => true,
                    'next' => site_url($urlpath.'/create/'.bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'cashbonid' => $declarationcashbon->cashbonid, 'type' => $declarationcashbon->type, 'nik'=>$json->employeeid )))),
                ));
            }
        }

    }
    function create($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
//        var_dump($json);die();
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent'));
        $this->M_DeclarationCashbon->q_temporary_delete(array('declarationid' => trim($this->session->userdata('nik'))));
        $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND declarationid = \''.$this->session->userdata('nik').'\' ');
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND dutieid = \''.$json->dutieid.'\' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(inputby) <> \''.$this->session->userdata('nik').'\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon karyawan nomer <b>'.(strlen($edited->cashbonid) > 0 ? $edited->cashbonid : $edited->dutieid).'</b> sedang diinput oleh <b>'.$edited->inputby.'</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->dutieid.'\' ')->row();
        $this->template->display('kasbon_umum/declaration_cashbon/v_create', array(
            'title' => 'Input Deklarasi Kasbon Karyawan',
            'employee' => $employee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND declarationid = \''.$this->session->userdata('nik').'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated AND type = \''.$json->type.'\' ')->result(),
        ));
    }
    function createcomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', 'trans/M_DestinationType', 'M_Cashbon', 'trans/M_CityCashbon'));
        $this->M_DeclarationCashbon->q_temporary_delete(array('declarationid' => trim($this->session->userdata('nik'))));
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND dutieid = \''.$json->dutieid.'\' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(inputby) <> \''.$this->session->userdata('nik').'\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>'.(strlen($edited->cashbonid) > 0 ? $edited->cashbonid : $edited->dutieid).'</b> sedang diinput oleh <b>'.$edited->inputby.'</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $this->M_DeclarationCashbon->q_temporary_create(array(
            'branch' => $this->session->userdata('branch'),
            'declarationid' => $this->session->userdata('nik'),
            'cashbonid' => $json->cashbonid,
            'dutieid' => $json->dutieid,
            'superior' => '',
            'status' => 'I',
            'totalcashbon' => 0,
            'totaldeclaration' => 0,
            'returnamount' => 0,
            'inputby' => $this->session->userdata('nik'),
            'inputdate' => date('Y-m-d H:i:s'),
        ));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $json->perday = date('Y-m-d',strtotime($cashbon->inputdate));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->dutieid.'\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/v_create_component_modal', array(
            'title' => 'Detail Deklarasi Kasbon',
            'employee' => $employee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND declarationid = \''.$this->session->userdata('nik').'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'perday' => $json->perday,
        ));
    }
    public function docreatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->model(array('M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
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
        foreach ($this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND readonly ')->result() as $index => $row) {
            $this->M_DeclarationCashbonComponent->q_temporary_delete(array(
                'declarationid' => $this->session->userdata('nik'),
                'componentid' => $row->componentid,
                'perday' => $row->perday,
            ));
        }


        foreach ($this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND readonly ')->result() as $index => $row) {
            if ((int)$row->defaultnominal > 0) {
                if ($this->M_DeclarationCashbonComponent->q_temporary_exists(' TRUE AND declarationid = \'' . $this->session->userdata('nik') . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' AND nominal IS NOT NULL ')) {
                    $this->M_DeclarationCashbonComponent->q_temporary_update(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $this->session->userdata('nik'),
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->defaultnominal,
                        'description' => $row->description,
                        'inputby' => $this->session->userdata('nik'),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ), array(
                        'declarationid' => $this->session->userdata('nik'),
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                    ));
                } else {
                    $this->M_DeclarationCashbonComponent->q_temporary_create(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $this->session->userdata('nik'),
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->defaultnominal,
                        'description' => $row->description,
                        'inputby' => $this->session->userdata('nik'),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                }
            }else{
                $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND declarationid = \'' . $json->declarationid . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' ');
            }
        }

        $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND declarationid = \''.$this->session->userdata('nik').'\' AND perday = \''.$json->perday.'\' ');
        foreach ($this->M_DeclarationCashbonComponent->q_empty_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND type IN (\''.$json->type.'\', \'DC\' ) ')->result() as $index => $row) {
            if ((int)$data[$row->componentid]->nominal > 0) {
                $this->M_DeclarationCashbonComponent->q_temporary_create(array(
                    'branch' => $this->session->userdata('branch'),
                    'declarationid' => $this->session->userdata('nik'),
                    'componentid' => $row->componentid,
                    'perday' => $json->perday,
                    'nominal' => $row->readonly == 't' ? $row->defaultnominal : (int)$data[$row->componentid]->nominal,
                    'description' => $row->readonly == 't' ? $row->description : ($row->calculated == 't' ? $data[$row->componentid]->description : $row->description),
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ));
            }
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail deklarasi kasbon berhasil dibuat'
        ));
    }
    public function createcomponent($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->dutieid.'\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/v_component_read', array(
            'employee' => $employee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND declarationid = \''.$this->session->userdata('nik').'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
        ));
    }
    public function docreate($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        if ($this->M_DeclarationCashbon->q_temporary_exists(' TRUE AND declarationid = \''.$this->session->userdata('nik').'\' ') && $this->M_DeclarationCashbonComponent->q_temporary_exists(' TRUE AND declarationid = \''.$this->session->userdata('nik').'\' ')) {
            $this->M_DeclarationCashbon->q_temporary_update(array(
                'status' => 'F',
                'inputby' => $this->session->userdata('nik'),
                'inputdate' => date('Y-m-d H:i:s'),
            ), array(
                'declarationid' => $this->session->userdata('nik'),
            ));
            $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' 
                AND inputby = \''.trim($this->session->userdata('nik')).'\' 
                ORDER BY inputdate DESC 
                ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                $this->M_DeclarationCashbon->q_transaction_update(array(
                    'employeeid' => $transaction->dutieid,
                ), array(
                    'declarationid' => $transaction->declarationid,
                ));
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data deklarasi kasbon dinas karyawan berhasil dibuat dengan nomer <b>'.$transaction->declarationid.'</b>'
                ));
            } else {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data deklarasai kasbon dinas karyawan gagal dibuat'
                ));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>detail deklarasi kasbon</b> kosong, silahkan input terlebih dahulu'
            ));
        }
    }

    function checkcomponenttemporary($param=null){
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        if( $this->M_DeclarationCashbon->q_temporary_exists('TRUE AND cashbonid = \''.$json->cashbonid.'\' AND inputby = \''.$this->session->userdata('nik').'\' ') OR $this->M_DeclarationCashbonComponent->q_temporary_exists('TRUE AND inputby = \''.$this->session->userdata('nik').'\' ')){
            if ($this->M_DeclarationCashbon->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND cashbonstatus = \'P\' ')->row()->totaldeclaration > 0 ){
                return true;
            }else{
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data <b>detail deklarasi kasbon</b> kosong, silahkan input terlebih dahulu'
                ));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>detail deklarasi kasbon</b> kosong, silahkan input terlebih dahulu'
            ));
        }
    }

    function update($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', 'trans/M_TrxType', ));
        $this->db->trans_start();
        $this->M_DeclarationCashbon->q_temporary_delete(array('updateby' => trim($this->session->userdata('nik'))));
        $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND updateby = \''.$this->session->userdata('nik').'\' ');
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \''.$json->declarationid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>'.$edited->declarationid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $this->M_DeclarationCashbon->q_transaction_update(
            array('status' => 'U', 'updateby' => $this->session->userdata('nik'), 'updatedate' => date('Y-m-d H:i:s'), ),
            array('declarationid' => $json->declarationid, )
        );
        $temporary = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \''.$json->declarationid.'\' 
            AND updateby = \''.$this->session->userdata('nik').'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($temporary) && !is_nan($temporary)) {
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$temporary->dutieid.'\' AND cashbonid = \''.$temporary->cashbonid.'\' ')->row();
            $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
            $this->db->trans_complete();
            $this->template->display('kasbon_umum/declaration_cashbon/v_update', array(
                'title' => 'Update Deklarasi Kasbon Karyawan',
                'employee' => $employee,
                'declaration' => $temporary,
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$temporary->dutieid.'\' AND cashbonid = \''.$temporary->cashbonid.'\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$temporary->dutieid.'\' AND cashbonid = \''.$temporary->cashbonid.'\' AND declarationid = \''.$json->declarationid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$temporary->dutieid.'\' AND cashbonid = \''.$temporary->cashbonid.'\' AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$temporary->dutieid.'\' AND cashbonid = \''.$temporary->cashbonid.'\' AND active AND calculated ')->result(),
            ));
        }
    }
    function updatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', 'trans/M_DestinationType', 'M_Cashbon', 'trans/M_CityCashbon'));
        $this->M_DeclarationCashbon->q_temporary_update(array(
            'updateby' => $this->session->userdata('nik'),
            'updatedate' => date('Y-m-d H:i:s'),
        ), array(
            'cashbonid' => $json->cashbonid,
        ));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $json->perday = date('Y-m-d',strtotime($cashbon->inputdate));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->dutieid.'\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/v_update_component_modal', array(
            'title' => 'Detail Deklarasi Kasbon',
            'employee' => $employee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND declarationid = \''.$json->declarationid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'perday' => $json->perday,
        ));
    }
    public function doupdatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
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
        foreach ($this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND readonly ')->result() as $index => $row) {
            $this->M_DeclarationCashbonComponent->q_temporary_delete(array(
                'declarationid' => $json->declarationid,
                'componentid' => $row->componentid,
                'perday' => $row->perday,
            ));
        }
        foreach ($this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND readonly ')->result() as $index => $row) {
//            if ((int)$row->defaultnominal > 0) {
            if ($this->M_DeclarationCashbonComponent->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' AND nominal IS NOT NULL ')) {
                $this->M_DeclarationCashbonComponent->q_temporary_update(array(
                    'branch' => $this->session->userdata('branch'),
                    'declarationid' => $json->declarationid,
                    'componentid' => $row->componentid,
                    'perday' => $row->perday,
                    'nominal' => $row->defaultnominal,
                    'description' => $row->description,
                    'updateby' => $this->session->userdata('nik'),
                    'updatedate' => date('Y-m-d H:i:s'),
                ), array(
                    'declarationid' => $json->declarationid,
                    'componentid' => $row->componentid,
                    'perday' => $row->perday,
                ));
            } else {
                $this->M_DeclarationCashbonComponent->q_temporary_create(array(
                    'branch' => $this->session->userdata('branch'),
                    'declarationid' => $json->declarationid,
                    'componentid' => $row->componentid,
                    'perday' => $row->perday,
                    'nominal' => $row->defaultnominal,
                    'description' => $row->description,
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ));
            }
//            }
        }
        foreach ($this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND perday = \''.$json->perday.'\' ')->result() as $index => $row) {
            if ((int)$data[$row->componentid]->nominal > 0 OR ($row->type == 'DC' AND (int)$data[$row->componentid]->nominal >= 0 )) {
                if ($this->M_DeclarationCashbonComponent->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' AND nominal IS NOT NULL ')) {
                    $this->M_DeclarationCashbonComponent->q_temporary_update(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->readonly == 't' ? $row->defaultnominal : (int)$data[$row->componentid]->nominal,
                        'description' => $row->readonly == 't' ? $row->description : ($row->calculated == 't' ? $data[$row->componentid]->description : $row->description),
                        'updateby' => $this->session->userdata('nik'),
                        'updatedate' => date('Y-m-d H:i:s'),
                    ), array(
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                    ));
                } else {
                    $this->M_DeclarationCashbonComponent->q_temporary_create(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->readonly == 't' ? $row->defaultnominal : (int)$data[$row->componentid]->nominal,
                        'description' => $row->readonly == 't' ? $row->description : ($row->calculated == 't' ? $data[$row->componentid]->description : $row->description),
                        'inputby' => $this->session->userdata('nik'),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                }
            }else{
                $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND declarationid = \'' . $json->declarationid . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' ');
            }
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail biaya kasbon berhasil diupdate'
        ));
    }
    public function updatecomponent($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $declaration = $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/v_component_read', array(
            'employee' => $employee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'declaration' => $declaration,
            'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND declarationid = \''.$declaration->declarationid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
        ));
    }
    public function doupdate($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        if ($this->M_DeclarationCashbon->q_temporary_exists(' TRUE AND declarationid = \''.$json->declarationid.'\' ') && $this->M_DeclarationCashbonComponent->q_temporary_exists(' TRUE AND declarationid = \''.$json->declarationid.'\' ')) {
            $this->M_DeclarationCashbon->q_temporary_update(array(
                'status' => 'U',
                'updateby' => $this->session->userdata('nik'),
                'updatedate' => date('Y-m-d H:i:s'),
            ), array(
                'declarationid' => $json->declarationid,
            ));
            $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' 
                AND updateby = \''.trim($this->session->userdata('nik')).'\' 
                ORDER BY updatedate DESC 
                ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                $this->M_DeclarationCashbon->q_transaction_update(array(
                    'employeeid' => $transaction->dutieid,
                ), array(
                    'declarationid' => $transaction->declarationid,
                ));
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data deklarasi kasbon dinas karyawan dengan nomer <b>'.$transaction->declarationid.'</b> berhasil diubah'
                ));
            } else {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data deklarasi kasbon dinas karyawan gagal diubah'
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
    public function componentbalance($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->employeid.'\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/v_component_balance', array(
            'employee' => $employee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND declarationid = \''.$this->session->userdata('nik').'\' AND active ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active ')->result(),
        ));
    }
    public function docancel($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        $this->db->trans_start();
        if ($this->M_DeclarationCashbon->q_temporary_delete(' TRUE AND declarationid = \''.$this->session->userdata('nik').'\' OR updateby = \''.$this->session->userdata('nik').'\' ') && $this->M_DeclarationCashbonComponent->q_temporary_delete(' TRUE AND declarationid = \''.$this->session->userdata('nik').'\' OR updateby = \''.$this->session->userdata('nik').'\' ')) {
            $this->db->trans_complete();
            header('Content-Type: application/json');
            echo json_encode(array(
                'message' => 'Data deklarasi kasbon dinas karyawan berhasil direset'
            ));
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>deklarasi kasbon dinas karyawan</b> tidak berhasil direset'
            ));
        }
    }
    function approve($param=null) {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', 'trans/M_TrxType',));
        $this->db->trans_start();
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \''.$json->declarationid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>'.$edited->declarationid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' AND approvedate IS NULL ')->row();
        if (!is_null($transaction) && !is_nan($transaction)) {
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' ')->row();
            $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$transaction->dutieid.'\' ')->row();
            $this->db->trans_complete();
            $this->template->display('kasbon_umum/declaration_cashbon/v_approve', array(
                'title' => 'Persetujuan Deklarasi Kasbon Karyawan',
                'employee' => $employee,
                'declaration' => $transaction,
                'approve' => true,
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_transaction_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' AND declarationid = \''.$json->declarationid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' AND active AND calculated ')->result(),
            ));
        }
    }
    public function doapprove($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', ));
        $this->db->trans_start();
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \''.$json->declarationid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon karyawan nomer <b>'.$edited->declarationid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('kasbon_umum/cashbon/');
        }
        $this->M_DeclarationCashbon->q_transaction_update(
            array('status' => 'P', 'approveby' => $this->session->userdata('nik'), 'approvedate' => date('Y-m-d H:i:s'),),
            array('declarationid' => $json->declarationid,)
        );
        $this->db->trans_complete();
        echo json_encode(array(
            'message' => 'Data deklarasi kasbon karyawan berhasil disetujui'
        ));
    }

    function detail($param=null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_DeclarationCashbon'));
        header('Content-Type: application/json');
        $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row();
//        var_dump($transaction);die();
        $this->load->model(array('M_DeclarationCashbon','M_Cashbon'));
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$declaration->cashbonid.'\' ')->row();
        echo  json_encode(array(
            'canread' => true,
            'next' => site_url( 'kasbon_umum/declarationcashbon/dodetail/'.bin2hex(json_encode(array('branch' => empty($declaration->branch) ? $this->session->userdata('branch') : $declaration->branch, 'cashbonid' => $declaration->cashbonid, 'declarationid' => $declaration->declarationid, 'dutieid' => $declaration->dutieid, 'type' => $cashbon->type, 'category' => 'DECLARATION')))),
        ));
        die();
        switch ($transaction->d_type_text){
            case "DINAS":
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Untuk melihat rincian dokumen ini,<br> silahkan ke menu <b>Dinas Karyawan</b>'
                ));
                break;
            case "CASHBON":
                $this->load->model(array('M_Cashbon'));
                $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$transaction->documentid.'\' ')->row();
                echo  json_encode(array(
                    'canread' => true,
                    'next' => site_url( 'kasbon_umum/cashbon/detail/'.bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid, 'type' => $cashbon->type, 'category' => 'DECLARATION')))),
                ));
                break;
            case "DECLARATION":
                $this->load->model(array('M_DeclarationCashbon','M_Cashbon'));
                $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row();
                $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$declaration->cashbonid.'\' ')->row();
                echo  json_encode(array(
                    'canread' => true,
                    'next' => site_url( 'kasbon_umum/declarationcashbon/dodetail/'.bin2hex(json_encode(array('branch' => empty($declaration->branch) ? $this->session->userdata('branch') : $declaration->branch, 'cashbonid' => $declaration->cashbonid, 'declarationid' => $declaration->declarationid, 'dutieid' => $declaration->dutieid, 'type' => $cashbon->type, 'category' => 'DECLARATION')))),
                ));
                break;
        }
    }

    public function dodetail($param=null){
        $json = json_decode(
            hex2bin($param)
        );
        $json->type = (substr($json->dutieid,0,2)=='DL' ? 'DN' : $json->type);
        $this->load->model(array('master/m_akses'));
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        $cancancel = (($userhr > 0 or $level_akses == 'A') ? TRUE : FALSE);
        $this->load->library(array('datatablessp'));
        if ($json->type == 'DN'){
            $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'kasbon_umum/M_Cashbon', 'kasbon_umum/M_CashbonComponentDinas', 'kasbon_umum/M_DeclarationCashbon', 'kasbon_umum/M_DeclarationCashbonComponentDinas', 'trans/M_TrxType', 'trans/M_DestinationType', 'trans/M_CityCashbon','kasbon_umum/M_CashbonComponent'));
            $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row();
            $dutiein = "'".implode("','",explode(",",$transaction->dutieid))."'";
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$transaction->cashbonid.'\' ')->row();
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ');
//            var_dump($dinas->result());die();
            $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->row()->nik.'\' ')->row();
            if (!empty($docno) && strtolower($docno) != 'null') {
                $docno = "'" . implode("','", explode(",", $docno)) . "'";
                $filter = ' AND id IN (' . $docno . ') ';
            } else {
                $filter = ' AND id IN (' . $dutiein . ') ';
            }
            $this->datatablessp->datatable('table-dutie', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, id, dutieperiod, nik, callplan_reformat, tujuan_kota_text, transportasi_text, tipe_transportasi_text, keperluan')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/cashbon/actionpopup/$1') . '\' class=\'text-green popup\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Action</i></a>', 'branch, id', true)
                ->querystring($this->m_dinas->q_transaction_txt_where(' AND TRUE ' . $filter))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dinas', 'id', false, true, true)
                ->header('Tanggal Dinas', 'dutieperiod', false, true, true)
                ->header('Kota Tujuan', 'tujuan_kota_text', false, true, true)
                ->header('Callplan', 'callplan_reformat', false, true, true)
                ->header('Sarana Transportasi', 'transportasi_text', false, true, true)
                ->header('Tipe Kendaraan', 'tipe_transportasi_text', false, true, true)
                ->header('Keperluan', 'keperluan', false, true, true);
            $this->datatablessp->generateajax();
            $this->db->trans_complete();
//            var_dump($dutiein);die();
            $this->template->display('kasbon_umum/declaration_cashbon/dinas/v_detail', array(
                'cancancel' => (($cancancel && $transaction->status <> 'C') ? TRUE : FALSE),
                'cancelUrl' => site_url('kasbon_umum/declarationcashbon/docanceldocument/'.bin2hex(json_encode(array('declarationid'=>$json->declarationid,'cashbonid'=>$transaction->cashbonid)))),
                'title' => 'Rincian Deklarasi Kasbon Karyawan',
                'employee' => $empleyee,
                'declaration' => $transaction,
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'dinas' => $dinas->result(),
                'approve' => true,
                'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \''.$transaction->cashbonid.'\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN( \'DN\', \''.$dinas->row()->transportasi.'\') ')->result(),
                'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_transaction_read_where(' AND dutieid IN('.$dutiein.') AND cashbonid = \''.$transaction->cashbonid.'\' AND declarationid = \''.$json->declarationid.'\' AND active AND type IN (\'DN\',transportasi) ')->result(),
                'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN('.$dutiein.') AND cashbonid = \''.$transaction->cashbonid.'\' AND active ')->result(),
                'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \''.$transaction->cashbonid.'\' AND active AND calculated ')->result(),
//                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
            ));
        }else{
            $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent', 'trans/M_TrxType',));
            $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row();
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' ')->row();
            $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$transaction->dutieid.'\' ')->row();
            $this->template->display('kasbon_umum/declaration_cashbon/v_detail', array(
                'cancancel' => $cancancel,
                'cancelUrl' => site_url('kasbon_umum/declarationcashbon/docanceldocument/'.bin2hex(json_encode(array('declarationid'=>$json->declarationid,'cashbonid'=>$transaction->cashbonid)))),
                'title' => 'Rincian Deklarasi Kasbon Karyawan',
                'employee' => $employee,
                'declaration' => $transaction,
                'approve' => true,
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_transaction_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' AND declarationid = \''.$json->declarationid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declarationcomponentsempty' => $this->M_DeclarationCashbonComponent->q_empty_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$transaction->dutieid.'\' AND cashbonid = \''.$transaction->cashbonid.'\' AND active AND calculated ')->result(),
            ));
        }

    }

    public function docanceldocument($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->model(array('kasbon_umum/M_DeclarationCashbon','kasbon_umum/M_BalanceCashbon',));
        header('Content-Type: application/json');
        if ($this->M_DeclarationCashbon->q_transaction_exists(' TRUE AND declarationid = \''.$json->declarationid.'\'  ')){
            if (!$this->M_DeclarationCashbon->q_transaction_exists(' TRUE AND declarationid = \''.$json->declarationid.'\' AND status = \'P\' ')){
                if (!$this->M_BalanceCashbon->exists(' TRUE AND docno = \''.$json->declarationid.'\' AND flag = \'NO\' AND voucher is not null ')){
                    $balance = $this->M_BalanceCashbon->q_balance_cashbon_detail_read_where(' AND docno = \''.$json->declarationid.'\' ')->row();
                    try {
                        $this->db->trans_start();
                        $this->M_BalanceCashbon->delete(array(
                            'docno' => $balance->docno,
                        ));
                        $this->M_DeclarationCashbon->q_transaction_update(array(
                            'status' => 'C',
                            'cancelby' => $this->session->userdata('nik'),
                            'canceldate' => date('Y-m-d H:i:s'),
                        ),array(
                            'declarationid' => $json->declarationid
                        ));
                        $this->db->trans_complete();
                        if ($this->db->trans_status()) {
                            $this->db->trans_commit();
                            header('Content-Type: application/json');
                            http_response_code(200);
                            echo json_encode(array(
                                'statusText' => 'Berhasil',
                                'message' => 'Data berhasil dibatalkan',
                            ));
                        } else {
                            throw new Exception("Error DB", 1);
                        }
                    } catch (Exception $e) {
                        $this->db->trans_rollback();
                    }
                }else{
                    header('Content-Type: application/json');
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Data yang sudah dibuat voucher tidak dapat dibatalkan'
                    ));
                }
            }else{
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Dokumen sudah pernah disetujui'
                ));
            }
        }else{
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data tidak ditemukan'
            ));
        }
    }

    public function printoption($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent',  'M_DeclarationCashbon', 'M_DeclarationCashbonComponent','master/m_option', 'master/M_RegionalOffice' ));
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' AND approvedate IS NOT NULL ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' AND approvedate IS NOT NULL ORDER BY updatedate DESC ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$employee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->load->view('kasbon_umum/declaration_cashbon/v_print_option', array(
            'title' => 'Cetak Deklarasi Kasbon Karyawan '.$declaration->declarationid,
            'city' => ucfirst(strtolower($city)).', ',
            'employee' => $employee,
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
            'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declaration' => $declaration,
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_transaction_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' AND declarationid = \''.$declaration->declarationid.'\' AND active ')->result(),
        ));
    }
    public function preview($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponent','master/m_option', 'master/M_RegionalOffice' ));
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' AND approvedate IS NOT NULL ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' AND approvedate IS NOT NULL ORDER BY updatedate DESC ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$employee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->load->view('kasbon_umum/declaration_cashbon/v_read_pdf', array(
            'title' => 'Cetak Deklarasi Kasbon Karyawan '.$cashbon->cashbonid,
            'city' => ucfirst(strtolower($city)).', ',
            'fontsize' => $fontsize,
            'marginsize' => $marginsize,
            'paddingsize' => $paddingsize,
            'employee' => $employee,
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
            'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
            'declaration' => $declaration,
            'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_transaction_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' AND declarationid = \''.$declaration->declarationid.'\' AND active ')->result(),
        ));
    }
    public function exportpdf($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library('pdfs');
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent',  'M_DeclarationCashbon', 'M_DeclarationCashbonComponent','master/m_option', 'master/M_RegionalOffice' ));
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \''.$json->declarationid.'\' AND approvedate IS NOT NULL ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' AND approvedate IS NOT NULL ORDER BY updatedate DESC ')->row();
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \''.$cashbon->dutieid.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$employee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->pdfs->loadHtml(
            $this->load->view('kasbon_umum/declaration_cashbon/v_read_pdf', array(
                'title' => 'Cetak Deklarasi Kasbon Karyawan '.$cashbon->cashbonid,
                'city' => ucfirst(strtolower($city)).', ',
                'fontsize' => $fontsize,
                'marginsize' => $marginsize,
                'paddingsize' => $paddingsize,
                'employee' => $employee,
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid = \''.$cashbon->dutieid.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
                'days' => $this->M_DeclarationCashbon->q_days_create_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\''.$cashbon->type.'\', \'DC\' ) ')->result(),
                'declaration' => $declaration,
                'declarationcomponents' => $this->M_DeclarationCashbonComponent->q_transaction_read_where(' AND dutieid = \''.$declaration->dutieid.'\' AND cashbonid = \''.$declaration->cashbonid.'\' AND declarationid = \''.$declaration->declarationid.'\' AND active ')->result(),
            ), true)
        );
        $this->pdfs->setPaper('A4', 'landscape');
        $this->pdfs->render();
        $this->pdfs->stream('DECLARATION'.$json->complaintid.'.PDF', array('Attachment' => 0));
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

    public function createoption($param = null)
    {
        $json = json_decode(hex2bin($param));
        http_response_code(200);
        echo json_encode(array(
            'cancreate' => true,
            'next' => array(
                'nondirect' => site_url('kasbon_umum/declarationcashbon/documentlist/'.bin2hex(json_encode(array('nik'=>$json->nik, 'createtype'=>'ND')))),
                'direct' => site_url('kasbon_umum/declarationcashbondinas/create/'.bin2hex(json_encode(array('nik'=>$json->nik, 'createtype'=>'DI')))),
            )
        ));
    }

    public function checktype($param = null)
    {
        $json = json_decode(hex2bin($param));
        if ($json->type == 'DN'){
            redirect(site_url('kasbon_umum/declarationcashbondinas/create/'.bin2hex(json_encode(array('employeeid'=>$json->employeeid, 'cashbonid'=>$json->cashbonid,'type'=>$json->type,'dutieid'=>$json->dutieid)))));
        }else{
            redirect(site_url('kasbon_umum/declarationcashbon/create/'.bin2hex(json_encode(array('employeeid'=>$json->employeeid, 'cashbonid'=>$json->cashbonid,'type'=>$json->type,'dutieid'=>$json->dutieid)))));
        }
    }

    private function checkdutieidcharacter(){
        $this->load->model(array('kasbon_umum/M_DeclarationCashbon'));
        if ($this->M_DeclarationCashbon->q_transaction_exists('TRUE AND dutieid ~ \'^,\' ')){
            foreach ($this->M_DeclarationCashbon->q_transaction_read_where(' AND dutieid ~ \'^,\' ')->result() as $index => $item) {
                $dutieidFormat = trim($item->dutieid, ',');
                $this->M_DeclarationCashbon->q_transaction_update(array(
                    'dutieid' => $dutieidFormat,
                ),array(
                    'declarationid' => $item->declarationid,
                ));
            }
        }
    }
}
