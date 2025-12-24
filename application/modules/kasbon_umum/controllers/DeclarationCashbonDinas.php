<?php defined('BASEPATH') or exit('No direct script access allowed');

class DeclarationCashbonDinas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('master/m_akses'));
        $this->load->library(array('template', 'flashmessage',));
        if (!$this->session->userdata('nik')) {
            redirect(base_url() . '/');
        }
    }

    public function setup($setupid)
    {
        $this->load->model(array('master/M_option'));
        $setup = $this->M_option->read(' AND kdoption = \''.$setupid.'\' ')->row();
        return $setup;
    }

    public function index()
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'M_DeclarationCashbon'));
        if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $this->datatablessp->datatable('table-declarationcashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, dutieid, cashbonid, documentid, documentdate, documentdateformat, departuredate, returndate, dutieperiod, employeeid, employeename, departmentname, subdepartmentname')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/declarationcashbon/actionpopup/$1') . '\' class=\'text-green popup\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Action</i></a>', 'branch, dutieid, cashbonid', true)
                ->querystring($this->M_DeclarationCashbon->q_cashbon_txt_where(' AND TRUE '))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dokumen', 'documentid', true, true, true)
                ->header('Tanggal Dokumen', 'documentdate', true, true, true, array('documentdateformat'))
                ->header('<u>N</u>ik', 'employeeid', true, true, true)
                ->header('Nama Karyawan', 'employeename', true, true, true)
                ->header('Departemen', 'departmentname', true, true, true, array('departmentname', 'subdepartmentname'))
                ->header('Tanggal Dinas', 'departuredate', true, true, true, array('dutieperiod'))
                ->header('Status', 'statustext', true, true, true)
                ->header('', 'action', false, false, true, array('popup'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Deklarasi Kasbon Dinas Karyawan';
            $this->template->display('kasbon_umum/declaration_cashbon/dinas/v_read', $data);
        } else {
            $this->datatablessp->datatable('table-declarationcashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, dutieid, cashbonid, documentid, documentdate, documentdateformat, departuredate, returndate, dutieperiod, employeeid, employeename, departmentname, subdepartmentname')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/declarationcashbon/actionpopup/$1') . '\' class=\'text-green popup\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Action</i></a>', 'branch, dutieid, cashbonid', true)
                ->querystring($this->M_DeclarationCashbon->q_cashbon_txt_where(' AND search ILIKE \'%' . trim($this->session->userdata('nik')) . '%\' '))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dokumen', 'documentid', false, true, true)
                ->header('Tanggal Dokumen', 'documentdate', true, true, true, array('documentdateformat'))
                ->header('<u>N</u>ik', 'employeeid', true, true, true)
                ->header('Nama Karyawan', 'employeename', true, true, true)
                ->header('Departemen', 'departmentname', true, true, true, array('departmentname', 'subdepartmentname'))
                ->header('Tanggal Dinas', 'departuredate', true, true, true, array('dutieperiod'))
                ->header('Status', 'statustext', true, true, true)
                ->header('', 'action', false, false, true, array('popup'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Deklarasi Kasbon Dinas Karyawan';
            $this->template->display('kasbon_umum/declaration_cashbon/dinas/v_read', $data);
        }
    }

    function actionpopup($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_DeclarationCashbon'));
        $declarationcashbon = $this->M_DeclarationCashbon->q_cashbon_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        header('Content-Type: application/json');
        if (!is_null($declarationcashbon->approveby) && !empty($declarationcashbon->approveby) && !is_null($declarationcashbon->approvedate)) {
            echo json_encode(array(
                'data' => $declarationcashbon,
                'canprint' => true,
                'next' => site_url('trans/declarationcashbon/printoption/' . bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid,)))),
            ));
        } else if (!is_null($declarationcashbon->declarationid) && !is_nan($declarationcashbon->declarationid) && !empty($declarationcashbon->declarationid)) {
            if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \'' . $declarationcashbon->declarationid . '\' AND superiors ILIKE \'%' . trim($this->session->userdata('nik')) . '%\' ')->num_rows() > 0) {
                echo json_encode(array(
                    'data' => $declarationcashbon,
                    'canapprove' => true,
                    'next' => array(
                        'update' => site_url('trans/declarationcashbon/update/' . bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid,)))),
                        'approve' => site_url('trans/declarationcashbon/approve/' . bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid,)))),
                    ),
                ));
            } else {
                echo json_encode(array(
                    'data' => $declarationcashbon,
                    'canupdate' => true,
                    'next' => site_url('trans/declarationcashbon/update/' . bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'declarationid' => $declarationcashbon->declarationid, 'cashbonid' => $declarationcashbon->cashbonid,)))),
                ));
            }
        } else {
            echo json_encode(array(
                'data' => array('dutieid' => $json->dutieid, 'cashbonid' => $json->cashbonid,),
                'cancreate' => true,
                'next' => site_url('trans/declarationcashbon/create/' . bin2hex(json_encode(array('branch' => empty($declarationcashbon->branch) ? $this->session->userdata('branch') : $declarationcashbon->branch, 'dutieid' => $declarationcashbon->dutieid, 'cashbonid' => $declarationcashbon->cashbonid,)))),
            ));
        }
    }

    function create($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas','M_CashbonComponentDinas', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
        $this->M_DeclarationCashbon->q_temporary_delete(array('declarationid' => trim($this->session->userdata('nik'))));
        $this->M_DeclarationCashbonComponentDinas->q_temporary_delete(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ');
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND dutieid = \'' . $json->dutieid . '\' 
            AND cashbonid = \'' . $json->cashbonid . '\' 
            AND TRIM(inputby) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>' . (strlen($edited->cashbonid) > 0 ? $edited->cashbonid : $edited->dutieid) . '</b> sedang diinput oleh <b>' . $edited->inputby . '</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
//        $json->cashbonid = 'CB230005';
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        if (!empty($cashbon)){
            $json->nik = $json->employeeid;
            $dutiein = "'" . trim(implode("','", explode(",", $cashbon->dutieid)),',') . "'";
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ')->result();
            $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $json->cashbonid . '\' ')->result();
            $casboned = TRUE;
            $filter = ' AND id IN ('.$dutiein.') ';
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
            $days=$this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' ')->result();
        }else{
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \'' . $json->dutieid . '\' ')->row();
            $days = array();
            $casboned = FALSE;
            $docno = $this->input->get_post('docno');
            if (!empty($docno) && strtolower($docno) != 'null') {
                $docno = "'" . trim(implode("','", explode(",", $docno)),',') . "'";
                $filter = ' AND id IN (' . $docno . ') ';
            } else {
                $filter = ' AND id = \'1\' ';
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
            $dutiein = ' \'X\' ';
        }
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->nik . '\' ')->row();
//        var_dump($dinas);die();
        $this->template->display('kasbon_umum/declaration_cashbon/dinas/v_create', array(
            'loadDocnoUrl' => site_url('kasbon_umum/declarationcashbondinas/loadDocno/' . bin2hex(json_encode(array('nik' => $json->nik, 'option' => 'CREATE', 'declarationid' => (empty($temporary->declarationid) ? trim($this->session->userdata('nik')) : $temporary->declarationid))))),
            'resetSelectUrl' => site_url('kasbon_umum/declarationcashbondinas/clearselect/' . bin2hex(json_encode(array('nik' => $json->nik, 'option' => 'CREATE', 'declarationid' => (empty($temporary->declarationid) ? trim($this->session->userdata('nik')) : $temporary->declarationid))))),
            'title' => 'Input Deklarasi Kasbon Dinas Karyawan',
            'employee' => $empleyee,
            'dinas' => $dinas,
            'CASHBONED' => $casboned,
            'maxLoad' => (!empty($this->setup('DCL:MAX:DUTIEID')) ? $this->setup('DCL:MAX:DUTIEID')->value3 : 1),
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'days' => $days,
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN( \'DN\',\'' . $dinas[0]->transportasi . '\') ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND active AND type IN (\'DN\',transportasi) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $json->cashbonid . '\' AND active AND type IN (\'DN\',transportasi) ')->result(),
//           'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' ')->result(),
             'cashboncomponents' => (!$casboned ? array() : $this->M_CashbonComponentDinas->q_transaction_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' ')->result() ),
        ));
    }

    function createcomponentpopup($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
//        var_dump($json);die();
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'trans/M_DestinationType', 'M_Cashbon', 'trans/M_CityCashbon', 'trans/M_MealAllowance', 'trans/M_Callplan'));
        $this->M_DeclarationCashbon->q_temporary_delete(array('declarationid' => trim($this->session->userdata('nik'))));
//        $dutieid = $this->input->post('dutieid');
        $dutieid = $json->dutieid;
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND dutieid = \'' . $dutieid . '\' 
            AND cashbonid = \'' . $json->cashbonid . '\' 
            AND TRIM(inputby) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>' . (strlen($edited->cashbonid) > 0 ? $edited->cashbonid : $edited->dutieid) . '</b> sedang diinput oleh <b>' . $edited->inputby . '</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $dutiein = "'" . trim(implode("','", explode(",", $dutieid)),',') . "'";
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN (' . $dutiein . ') ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();

        $this->M_DeclarationCashbon->q_temporary_create(array(
            'branch' => $this->session->userdata('branch'),
            'declarationid' => trim($this->session->userdata('nik')),
            'cashbonid' => $json->cashbonid,
            'dutieid' => (!empty($cashbon) ? $cashbon->dutieid : $dutieid),
            'superior' => '',
            'status' => 'I',
            'totalcashbon' => (!empty($cashbon) ? $cashbon->totalcashbon : 0),
            'totaldeclaration' => 0,
            'returnamount' => 0,
            'inputby' => trim($this->session->userdata('nik')),
            'inputdate' => date('Y-m-d H:i:s'),
        ));


        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->nik . '\' ')->row();
        $callplan_data = $this->M_Callplan->check($empleyee->nik, $json->perday)->row();
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_create_component_modal', array(
            'title' => 'Detail Deklarasi Kasbon Tanggal ' . date('d-m-Y', strtotime($json->perday)),
            'employee' => $empleyee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'dinas' => $dinas,
            'callplan' => $callplan_data,
            'achieved' => ($dinas->callplan === 't' ? $callplan_data->achieved : 1),
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $dinas->jenis_tujuan . '\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $dinas->tujuan_kota . '\' ')->row(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND perday = \'' . $json->perday . '\' AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND active AND type IN (\'DN\',\'' . $dinas->transportasi . '\') ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND perday = \'' . $json->perday . '\' AND active AND type in (\'DN\',\'' . $dinas->transportasi . '\') ')->result(),
            'perday' => $json->perday,
        ));
    }

    public function docreatecomponentpopup($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );

        $this->load->model(array('M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'trans/M_MealAllowance', 'trans/m_dinas'));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \'' . $json->dutieid . '\' ')->row();
        $id = $this->input->post('id');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        $dutieid = (!empty($this->input->post('dutieid')) ? $this->input->post('dutieid') : $json->dutieid);
        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => $description[$index],
                'dutieid' => $dutieid[$index],
            )));
        }

        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => $description[$index],
            )));
        }


        $this->db->trans_start();
        foreach ($this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' AND active AND readonly ')->result() as $index => $row) {
            $this->M_DeclarationCashbonComponentDinas->q_temporary_delete(array(
                'declarationid' => trim($this->session->userdata('nik')),
                'componentid' => $row->componentid,
                'perday' => $row->perday,
                'dutieid' => $row->dutieid,
            ));
        }

        foreach ($this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' AND active AND readonly AND type IN ( \'DN\',\'' . $dinas->transportasi . '\') AND perday = \'' . $json->perday . '\' ')->result() as $index => $row) {

            $this->load->model(array('trans/M_Callplan'));
            if ($dinas->callplan == 't') {
                $callplan = $this->M_Callplan->check($dinas->nik, $row->perday)->row();
                $achieved = $callplan->achieved;
            } else {
                $achieved = 1;
            }
            if ((int)$row->defaultnominal > 0) {
                if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' AND dutieid = \'' . $row->dutieid . '\' AND nominal IS NOT NULL ')) {
                    $this->M_DeclarationCashbonComponentDinas->q_temporary_update(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => trim($this->session->userdata('nik')),
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->defaultnominal,
                        'description' => $row->description,
                        'inputby' => trim($this->session->userdata('nik')),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ), array(
                        'declarationid' => trim($this->session->userdata('nik')),
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid' => $row->dutieid,
                    ));
                } else {

                    $this->M_DeclarationCashbonComponentDinas->q_temporary_create(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => trim($this->session->userdata('nik')),
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid' => $row->dutieid,
//                        'nominal' => $row->defaultnominal,
                        'nominal' => (($row->componentid == 'UD' and $row->is_callplan == 't') ? ($achieved ? $row->defaultnominal : 0) : $row->defaultnominal),
                        'description' => $row->description,
                        'inputby' => trim($this->session->userdata('nik')),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                }
            }
        }

        $this->load->model(array('trans/M_Callplan'));
        if ($dinas->callplan == 't') {
            $callplan = $this->M_Callplan->check($dinas->nik, $json->perday)->row();
            $achieved = $callplan->achieved;
        } else {
            $achieved = 1;
        }

        $this->M_DeclarationCashbonComponentDinas->q_temporary_delete(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND perday = \'' . $json->perday . '\' ');
        foreach ($this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' AND perday = \'' . $json->perday . '\' AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ')->result() as $index => $row) {

            if ((int)$data[$row->componentid]->nominal > 0) {
                $this->M_DeclarationCashbonComponentDinas->q_temporary_create(array(
                    'branch' => $this->session->userdata('branch'),
                    'declarationid' => trim($this->session->userdata('nik')),
                    'componentid' => $row->componentid,
                    'perday' => $row->perday,
                    'dutieid' => $row->dutieid,
                    'nominal' => $row->readonly == 't' ? (($row->componentid == 'UD' and $row->is_callplan === 't') ? ($achieved ? $row->defaultnominal : 0) : $row->defaultnominal) : (int)$data[$row->componentid]->nominal,
                    'description' => $row->readonly == 't' ? $row->description : ($row->calculated == 't' ? $data[$row->componentid]->description : $row->description),
                    'inputby' => trim($this->session->userdata('nik')),
                    'inputdate' => date('Y-m-d H:i:s'),
                ));
            }
        }
//        die();
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail deklarasi kasbon berhasil dibuat'
        ));
    }

    public function createcomponent($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $dutiepost = $this->input->get_post('dutieid');
        $json->dutieid = ((!empty($dutiepost)) ? $this->input->post('dutieid') : $json->dutieid);
        $dutiein = "'" . trim(implode("','", explode(",", $json->dutieid)),',') . "'";
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        if ($this->M_DeclarationCashbon->q_temporary_exists(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\'   ')) {
            $this->M_DeclarationCashbon->q_temporary_update(array(
                'dutieid' => (empty($json->dutieid) ? $dutiepost : $json->dutieid),
            ), array(
                'declarationid' => trim($this->session->userdata('nik')),
                'inputby' => trim($this->session->userdata('nik')),
            ));
        }
        if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\'   ')) {
            $this->M_DeclarationCashbonComponentDinas->q_temporary_delete('TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND dutieid NOT IN (' . $dutiein . ') ');
        }

//        var_dump($this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \''.$json->dutieid.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row());die();
        $cashbon = $this->M_Cashbon->q_transaction_read_where('  AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN (' . $dutiein . ') ')->result();
        $includeComponentArr=array(
            'SM',
            'M'
        );
        foreach ($dinas as $index => $item) {
            if (in_array($item->transportasi,$includeComponentArr)){
                $transportasi = $item->transportasi;
            }
        }
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->employeeid . '\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_component_read', array(
            'employee' => $empleyee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'dinas' => $dinas,
            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row(),
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN ( \'DN\', \'' . $transportasi . '\' ) ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND active AND type IN ( \'DN\', \'' . $dinas[0]->transportasi . '\' ) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND active AND type IN ( \'DN\', \'' . $dinas[0]->transportasi . '\' ) ')->result(),
        ));
    }

    public function docreate($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        if ($this->M_DeclarationCashbon->q_temporary_exists(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ') && $this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ')) {
            $this->M_DeclarationCashbon->q_temporary_update(array(
                'status' => 'F',
                'inputby' => trim($this->session->userdata('nik')),
                'inputdate' => date('Y-m-d H:i:s'),
            ), array(
                'declarationid' => trim($this->session->userdata('nik')),
            ));
            $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' 
                AND inputby = \'' . trim($this->session->userdata('nik')) . '\' 
                ORDER BY inputdate DESC 
                ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                $this->M_DeclarationCashbon->q_transaction_update(array(
                    'employeeid' => $this->input->post('employeeid'),
                ), array(
                    'declarationid' => $transaction->declarationid,
                ));
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data deklarasi kasbon dinas karyawan berhasil dibuat dengan nomer <b>' . $transaction->declarationid . '</b>'
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

    function update($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent','M_CashbonComponentDinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'trans/M_TrxType', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
        $this->db->trans_start();
        $this->M_DeclarationCashbon->q_temporary_delete(array('updateby' => trim($this->session->userdata('nik'))));
        $this->M_DeclarationCashbonComponentDinas->q_temporary_delete(' TRUE AND updateby = \'' . trim($this->session->userdata('nik')) . '\' ');
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \'' . $json->declarationid . '\' 
            AND TRIM(updateby) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY updatedate DESC 
            ')->row();
//        var_dump($edited);
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>' . $edited->declarationid . '</b> sedang diupdate oleh <b>' . $edited->updateby . '</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $this->M_DeclarationCashbon->q_transaction_update(
            array('status' => 'U', 'updateby' => trim($this->session->userdata('nik')), 'updatedate' => date('Y-m-d H:i:s'),),
            array('declarationid' => $json->declarationid,)
        );
        $temporary = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \'' . $json->declarationid . '\' 
            AND updateby = \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY updatedate DESC 
            ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \'' . $temporary->cashbonid . '\' ')->row();
        if (!empty($cashbon)){
            $dutiein = "'" . trim(implode("','", explode(",", $cashbon->dutieid)),',') . "'";
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ');
            $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $json->cashbonid . '\' ')->result();
            $casboned = TRUE;
            $days=$this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' ')->result();
        }else{
			$dutiein = "'" . trim(implode("','", explode(",", $json->dutieid)),',') . "'";
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.')  ');
            $days = array();
            $casboned = FALSE;

        }
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->row()->nik . '\' ')->row();
        $json->nik = $empleyee->nik;
        $docno = $this->input->get_post('docno');

        if (!empty($docno) && strtolower($docno) != 'null') {
            $docno = "'" . trim(implode("','", explode(",", $docno)),',') . "'";
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
        $this->template->display('kasbon_umum/declaration_cashbon/dinas/v_update', array(
            'loadDocnoUrl' => site_url('kasbon_umum/declarationcashbondinas/loadDocno/' . bin2hex(json_encode(array('nik' => $json->nik, 'option' => 'UPDATE', 'declarationid' => (empty($temporary->declarationid) ? trim($this->session->userdata('nik')) : $temporary->declarationid))))),
            'resetSelectUrl' => site_url('kasbon_umum/declarationcashbondinas/clearselect/' . bin2hex(json_encode(array('nik' => $json->nik, 'option' => 'UPDATE', 'declarationid' => (empty($temporary->declarationid) ? trim($this->session->userdata('nik')) : $temporary->declarationid))))),
            'title' => 'Update Deklarasi Kasbon Dinas Karyawan',
            'employee' => $empleyee,
            'CASHBONED' => $casboned,
            'declaration' => $temporary,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'maxLoad' => (!empty($this->setup('DCL:MAX:DUTIEID')) ? $this->setup('DCL:MAX:DUTIEID')->value3 : 1),
            'dinas' => $dinas->result(),
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN(' . $dutiein . ') AND cashbonid = \'' . $temporary->cashbonid . '\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN( \'DN\',\'' . $dinas->result()[0]->transportasi . '\') ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $temporary->cashbonid . '\' AND declarationid = \'' . $json->declarationid . '\' AND active AND type IN (\'DN\',transportasi) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $temporary->cashbonid . '\' AND type IN (\'DN\',transportasi) ')->result(),
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' AND active AND calculated ')->result(),
        ));
    }

    function updatecomponentpopup($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'trans/M_DestinationType', 'M_Cashbon', 'trans/M_CityCashbon', 'trans/M_MealAllowance', 'trans/M_Callplan'));
        $this->M_DeclarationCashbon->q_temporary_update(array(
            'updateby' => trim($this->session->userdata('nik')),
            'updatedate' => date('Y-m-d H:i:s'),
        ), array(
            'cashbonid' => $json->cashbonid,
        ));
        if (!is_null($json->cashbonid)){
            $dutieid = $json->dutieid;
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        }else{
            //$dutieid = (!empty($this->input->post('dutieid')) ? $this->input->post('dutieid') : $json->dutieid);
            $dutieid = $json->dutieid;
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \''.$dutieid.'\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        }
        $dutiein = "'" . trim(implode("','", explode(",", $dutieid)),',') . "'";

        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN (' . $dutiein . ') ')->row();
        $filter = ($dinas->tipe_transportasi == 'TDN' ? " AND componentid <> 'SWK' " : "");
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->nik . '\' ')->row();
        $callplan_data = $this->M_Callplan->check($empleyee->nik, $json->perday)->row();
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_update_component_modal', array(
            'title' => 'Detail Deklarasi Kasbon Tanggal ' . date('d-m-Y', strtotime($json->perday)),
            'employee' => $empleyee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'dinas' => $dinas,
            'callplan' => $callplan_data,
            'achieved' => ($dinas->callplan === 't' ? $callplan_data->achieved : 1),
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $dinas->jenis_tujuan . '\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $dinas->tujuan_kota . '\' ')->row(),
//            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \'' . $dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row(),
            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND declarationid = \''.$json->declarationid.'\' ')->row(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND perday = \'' . $json->perday . '\' AND declarationid = \'' . $json->declarationid . '\' AND active AND type IN (\'DN\',transportasi) ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND perday = \'' . $json->perday . '\' AND active AND type IN (\'DN\',\'transportasi\') ')->result(),
            'perday' => $json->perday,
        ));
    }

    public function doupdatecomponentpopup($param = null)
    {

        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'trans/M_MealAllowance', 'trans/m_dinas'));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \'' . $json->dutieid . '\' ')->row();
        $id = $this->input->post('id');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        $dutieid = (!empty($this->input->post('dutieid')) ? $this->input->post('dutieid') : $json->dutieid);
        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => $description[$index],
                'dutieid' => $dutieid,
            )));
        }
        /*header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(array(
            'data' => $data
        ));
        die();*/
        $this->db->trans_start();
        foreach ($this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' AND active AND readonly ')->result() as $index => $row) {

            $this->M_DeclarationCashbonComponentDinas->q_temporary_delete(array(
                'declarationid' => $json->declarationid,
                'componentid' => $row->componentid,
                'perday' => $row->perday,
                'dutieid' => $row->dutieid,
            ));
        }
        $type = (substr(trim($json->dutieid), 0, 2) == 'DL' ? 'DN' : '-');

        foreach ($this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' AND active AND readonly AND type IN (\'' . $type . '\',transportasi) ')->result() as $index => $row) {
            $this->load->model(array('trans/M_Callplan'));
            if ($dinas->callplan == 't') {
                $callplan = $this->M_Callplan->check($dinas->nik, $row->perday)->row();
                $achieved = $callplan->achieved;
            } else {
                $achieved = 1;
            }
            if ((int)$row->defaultnominal > 0) {

                if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' AND nominal IS NOT NULL ')) {
                    $a = 'zzzz';
                    $this->M_DeclarationCashbonComponentDinas->q_temporary_update(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->defaultnominal,
                        'description' => $row->description,
                        'updateby' => trim($this->session->userdata('nik')),
                        'updatedate' => date('Y-m-d H:i:s'),
                    ), array(
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid' => $row->dutieid,
                    ));
                } else {
                    $a = 'fffff';

                    $this->M_DeclarationCashbonComponentDinas->q_temporary_create(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid'=> $row->dutieid,
//                        'nominal' => $row->defaultnominal,
                        'nominal' => (($row->componentid == 'UD' AND $row->is_callplan == 't') ? ($achieved ? $row->defaultnominal : 0 ) : $row->defaultnominal ),
                        'description' => $row->description,
                        'inputby' => trim($this->session->userdata('nik')),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                }

            }
        }
        $this->load->model(array('trans/M_Callplan'));
        if ($dinas->callplan == 't') {
            $callplan = $this->M_Callplan->check($dinas->nik, $json->perday)->row();
            $achieved = $callplan->achieved;
        } else {
            $achieved = 1;
        }
        $value = array();
        foreach ($this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid = \'' . $dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' AND perday = \'' . $json->perday . '\' ')->result() as $index => $row) {
//            $callplan = $this->M_MealAllowance->read(' AND nik = \''.$json->employeeid.'\' AND workdate = \''.$row->perday.'\' ')->row();

            if ((int)$data[$row->componentid]->nominal > 0) {
                if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\' AND componentid = \'' . $row->componentid . '\' AND perday = \'' . $row->perday . '\' AND nominal IS NOT NULL ')) {
                    $a = 'wwww';
                    $this->M_DeclarationCashbonComponentDinas->q_temporary_update(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'nominal' => $row->readonly == 't' ? $row->defaultnominal : (int)$data[$row->componentid]->nominal,
                        'description' => $row->readonly == 't' ? $row->description : ($row->calculated == 't' ? $data[$row->componentid]->description : $row->description),
                        'updateby' => trim($this->session->userdata('nik')),
                        'updatedate' => date('Y-m-d H:i:s'),
                    ), array(
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid' => $row->dutieid,
                    ));
                    $nominal = $row->readonly == 't' ? $row->defaultnominal : (int)$data[$row->componentid]->nominal;
                } else {
                    $a = 'dddd';
                    array_push($value, array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid' => $row->dutieid,
//                        'nominal' => $row->defaultnominal,
                        'nominal' => (($row->componentid == 'UD' and $row->is_callplan == 't') ? ($achieved ? $row->defaultnominal : 0) : $row->defaultnominal),
                        'description' => $row->description,
                        'inputby' => trim($this->session->userdata('nik')),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                    $this->M_DeclarationCashbonComponentDinas->q_temporary_create(array(
                        'branch' => $this->session->userdata('branch'),
                        'declarationid' => $json->declarationid,
                        'componentid' => $row->componentid,
                        'perday' => $row->perday,
                        'dutieid' => $row->dutieid,
//                        'nominal' => $row->readonly == 't' ? $row->defaultnominal : (int)$data[$row->componentid]->nominal,
                        'nominal' => $row->readonly == 't' ? (($row->componentid == 'UD' and $row->is_callplan == 't') ? ($achieved ? $row->defaultnominal : 0) : $row->defaultnominal) : (int)$data[$row->componentid]->nominal,
                        'description' => $row->readonly == 't' ? $row->description : ($row->calculated == 't' ? $data[$row->componentid]->description : $row->description),
                        'inputby' => trim($this->session->userdata('nik')),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ));
                }
            }

        }

        $this->db->trans_complete();
        header('Content-Type: application/json');
//         http_response_code(403);
        echo json_encode(array(
            'data' => [$a, $dutieid, $data,$value],
            'message' => 'Data detail biaya kasbon berhasil diupdate'
        ));
    }

    public function updatecomponent($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
//        var_dump($json);die();
        $dutiepost = $this->input->get_post('dutieid');
        $json->dutieid = ((!empty($dutiepost)) ? $this->input->post('dutieid') : $json->dutieid);
        $dutiein = "'" . trim(implode("','", explode(",", $json->dutieid)),',') . "'";
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        if ($this->M_DeclarationCashbon->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\'   ')) {
            $this->M_DeclarationCashbon->q_temporary_update(array(
                'dutieid' => (empty($json->dutieid) ? $dutiepost : $json->dutieid),
            ), array(
                'declarationid' => $json->declarationid,
                'updateby' => trim($this->session->userdata('nik')),
            ));
        }
        if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid. '\'   ')) {
            $this->M_DeclarationCashbonComponentDinas->q_temporary_delete('TRUE AND declarationid = \'' . $json->declarationid . '\' AND dutieid NOT IN (' . $dutiein . ') ');
        }
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));

        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        $declaration = $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ')->result();
        $includeComponentArr=array(
            'SM',
            'M'
        );
        foreach ($dinas as $index => $item) {
            if (in_array($item->transportasi,$includeComponentArr)){
                $transportasi = $item->transportasi;
            }
        }
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->nik . '\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_component_read', array(
            'employee' => $empleyee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'dinas' => $dinas,
            'declaration' => $declaration,
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type in( \'DN\', \'' . $dinas[0]->transportasi . '\' ) ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND declarationid = \'' . $declaration->declarationid . '\' AND active ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND active ')->result(),
        ));
    }

    public function doupdate($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        if ($this->M_DeclarationCashbon->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\' ') && $this->M_DeclarationCashbonComponentDinas->q_temporary_exists(' TRUE AND declarationid = \'' . $json->declarationid . '\' ')) {
            $this->M_DeclarationCashbon->q_temporary_update(array(
                'status' => 'U',
                'updateby' => trim($this->session->userdata('nik')),
                'updatedate' => date('Y-m-d H:i:s'),
            ), array(
                'declarationid' => $json->declarationid,
            ));
            $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' 
                AND updateby = \'' . trim($this->session->userdata('nik')) . '\' 
                ORDER BY updatedate DESC 
                ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                $this->M_DeclarationCashbon->q_transaction_update(array(
                    'employeeid' => $this->input->post('employeeid'),
                ), array(
                    'declarationid' => $transaction->declarationid,
                ));
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data deklarasi kasbon dinas karyawan dengan nomer <b>' . $transaction->declarationid . '</b> berhasil dirubah'
                ));
            } else {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data deklarasi kasbon dinas karyawan gagal dirubah'
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

    public function componentbalance($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $dutiepost = $this->input->get_post('dutieid');
        $json->dutieid = ((!empty($dutiepost)) ? $this->input->post('dutieid') : $json->dutieid);
        $dutiein = "'" . trim(implode("','", explode(",", $json->dutieid)),',') . "'";
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN (' . $dutiein . ') ')->result();

        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas[0]->nik . '\' ')->row();
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_component_balance', array(
            'employee' => $empleyee,
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'dinas' => $dinas,
            'declaration' => $this->M_DeclarationCashbon->q_temporary_read_where(' AND dutieid = \'' . $json->dutieid . '\' AND cashbonid = \'' . $json->cashbonid . '\' ')->row(),
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active ')->result(),
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_temporary_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' AND active ')->result(),
            'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN (' . $dutiein . ') AND cashbonid = \'' . $json->cashbonid . '\' AND active ')->result(),
        ));
    }

    public function docancel($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        $this->db->trans_start();
        if ($this->M_DeclarationCashbon->q_temporary_delete(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' OR updateby = \'' . trim($this->session->userdata('nik')) . '\' ') && $this->M_DeclarationCashbonComponentDinas->q_temporary_delete(' TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' OR updateby = \'' . trim($this->session->userdata('nik')) . '\' ')) {
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

    function approve($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
//        var_dump($json);die();
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent','M_CashbonComponentDinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'trans/M_TrxType', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
        $this->db->trans_start();
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \'' . $json->declarationid . '\' 
            AND TRIM(updateby) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>' . $edited->declarationid . '</b> sedang diupdate oleh <b>' . $edited->updateby . '</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $transaction = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \'' . $json->declarationid . '\' AND approvedate IS NULL ')->row();
        if (!is_null($transaction) && !is_nan($transaction)) {
            $dutiein = "'".trim(implode("','",explode(",",$transaction->dutieid)),',')."'";
            $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \'' . $transaction->cashbonid . '\' ')->row();
//            var_dump($cashbon);die();
            $filter = ' AND id IN ('.$dutiein.') ';
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ');
            $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->row()->nik . '\' ')->row();
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
            $this->template->display('kasbon_umum/declaration_cashbon/dinas/v_approve', array(
                'approve' => TRUE,
                'title' => 'Persetujuan Deklarasi Kasbon Dinas Karyawan',
                'employee' => $empleyee,
                'declaration' => $transaction,
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'dinas' => $dinas->result(),
                'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $transaction->cashbonid . '\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN( \'DN\', \'' . $dinas->result()[0]->transportasi . '\' ) ')->result(),
                'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $transaction->cashbonid . '\' AND declarationid = \'' . $json->declarationid . '\' AND active ')->result(),
                'declarationcomponentsempty' => $this->M_DeclarationCashbonComponentDinas->q_empty_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $transaction->cashbonid . '\' AND active ')->result(),
                'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND cashbonid = \'' . $transaction->cashbonid . '\' AND active AND calculated ')->result(),
            ));
        }
    }

    public function doapprove($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas',));
        $this->db->trans_start();
        $edited = $this->M_DeclarationCashbon->q_temporary_read_where(' 
            AND declarationid = \'' . $json->declarationid . '\' 
            AND TRIM(updateby) <> \'' . trim($this->session->userdata('nik')) . '\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data deklarasi kasbon dinas karyawan nomer <b>' . $edited->declarationid . '</b> sedang diupdate oleh <b>' . $edited->updateby . '</b>', 'warning'))
                ->redirect('kasbon_umum/declarationcashbon/');
        }
        $this->M_DeclarationCashbon->q_transaction_update(
            array(
                'status' => 'P',
                'approveby' => trim($this->session->userdata('nik')),
                'approvedate' => date('Y-m-d H:i:s'),
            ),
            array(
                'declarationid' => $json->declarationid,
            )
        );
        $this->db->trans_complete();
        echo json_encode(array(
            'message' => 'Data deklarasi kasbon dinas karyawan berhasil disetujui'
        ));
    }

    public function printoption($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'trans/M_DestinationType', 'trans/M_CityCashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'master/m_option', 'master/M_RegionalOffice'));
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \'' . $json->declarationid . '\' AND approvedate IS NOT NULL ')->row();
        $dutiein = "'" . trim(implode("','", explode(",", $declaration->dutieid)),',') . "'";
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' AND approvedate IS NOT NULL ORDER BY updatedate DESC ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ');
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->row()->nik . '\' ')->row();
        if ($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0) {
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        } else {
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \'' . $empleyee->kdcabang . '\' ')->row()->regional_name;
        }
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_print_option', array(
            'title' => 'Cetak Deklarasi Kasbon Dinas Karyawan ' . $declaration->declarationid,
            'city' => ucfirst(strtolower($city)) . ', ',
            'employee' => $empleyee,
            'dinas' => $dinas->result(),
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $dinas->jenis_tujuan . '\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $dinas->tujuan_kota . '\' ')->row(),
            'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \'' . $dinas->transportasi . '\' ')->row(),
            'transptype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSPTYPE\' AND id = \'' . $dinas->tipe_transportasi . '\' ')->row(),
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \'' . $cashbon->paymenttype . '\' ')->row(),
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $cashbon->cashbonid . '\' AND active AND calculated AND type = \'DN\' ')->result(),
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\'DN\',\'' . $dinas->row()->transportasi . '\') ')->result(),
            'declaration' => $declaration,
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' AND declarationid = \'' . $declaration->declarationid . '\' AND active AND type IN (\'DN\',transportasi) ')->result(),
        ));
    }

    public function preview($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'trans/M_DestinationType', 'trans/M_CityCashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'master/m_option', 'master/M_RegionalOffice'));
        $setup = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row();
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \'' . $json->declarationid . '\' AND approvedate IS NOT NULL ')->row();
        $dutiein = "'" . trim(implode("','", explode(",", $declaration->dutieid)),',') . "'";
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \'' . $declaration->dutieid . '\' AND cashbonid = \'' . $declaration->cashbonid . '\' AND approvedate IS NOT NULL ORDER BY updatedate DESC ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ');
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->row()->nik . '\' ')->row();
        if ($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0) {
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        } else {
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \'' . $empleyee->kdcabang . '\' ')->row()->regional_name;
        }
        $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_read_pdf', array(
            'title' => 'Cetak Deklarasi Kasbon Dinas Karyawan ' . $cashbon->cashbonid,
            'city' => ucfirst(strtolower($city)) . ', ',
            'fontsize' => $fontsize,
            'marginsize' => $marginsize,
            'paddingsize' => $paddingsize,
            'employee' => $empleyee,
            'dinas' => $dinas->result(),
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $dinas->jenis_tujuan . '\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $dinas->tujuan_kota . '\' ')->row(),
            'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \'' . $dinas->transportasi . '\' ')->row(),
            'transptype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSPTYPE\' AND id = \'' . $dinas->tipe_transportasi . '\' ')->row(),
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \'' . $cashbon->paymenttype . '\' ')->row(),
            'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
            'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $cashbon->cashbonid . '\' AND active AND calculated AND type = \'DN\' ')->result(),
            'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' ')->result(),
            'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\'DN\',\'' . $dinas->row()->transportasi . '\') ')->result(),
            'declaration' => $declaration,
            'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' AND declarationid = \'' . $declaration->declarationid . '\' AND active AND type IN (\'DN\',transportasi) ')->result(),

        ));
    }

    public function exportpdf($param = null)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library('pdfs');
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'trans/M_DestinationType', 'trans/M_CityCashbon', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas', 'master/m_option', 'master/M_RegionalOffice'));
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $declaration = $this->M_DeclarationCashbon->q_transaction_read_where(' AND declarationid = \'' . $json->declarationid . '\' AND approvedate IS NOT NULL ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND dutieid = \'' . $declaration->dutieid . '\' AND cashbonid = \'' . $declaration->cashbonid . '\' AND approvedate IS NOT NULL ORDER BY updatedate DESC ')->row();
        $dutiein = "'" . trim(implode("','", explode(",", $declaration->dutieid)),',') . "'";
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ');
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $dinas->row()->nik . '\' ')->row();
        if ($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0) {
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        } else {
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \'' . $empleyee->kdcabang . '\' ')->row()->regional_name;
        }
        $this->pdfs->loadHtml(
            $this->load->view('kasbon_umum/declaration_cashbon/dinas/v_read_pdf', array(
                'title' => 'Cetak Deklarasi Kasbon Dinas Karyawan ' . $cashbon->cashbonid,
                'city' => ucfirst(strtolower($city)) . ', ',
                'fontsize' => $fontsize,
                'marginsize' => $marginsize,
                'paddingsize' => $paddingsize,
                'employee' => $empleyee,
                'dinas' => $dinas->result(),
                'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \'' . $dinas->jenis_tujuan . '\' ')->row(),
                'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \'' . $dinas->tujuan_kota . '\' ')->row(),
                'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \'' . $dinas->transportasi . '\' ')->row(),
                'transptype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSPTYPE\' AND id = \'' . $dinas->tipe_transportasi . '\' ')->row(),
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \'' . $cashbon->paymenttype . '\' ')->row(),
                'cashbon' => (!is_null($cashbon) && !is_nan($cashbon)) ? $cashbon : array(),
                'cashboncomponents' => $this->M_CashbonComponent->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $cashbon->cashbonid . '\' AND active AND calculated  ')->result(),
                'days' => $this->M_DeclarationCashbon->q_days_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' ')->result(),
                'components' => $this->M_ComponentCashbon->q_master_read_where(' AND active AND type IN (\'DN\',\'' . $dinas->row()->transportasi . '\') ')->result(),
                'declaration' => $declaration,
                'declarationcomponents' => $this->M_DeclarationCashbonComponentDinas->q_transaction_read_where(' AND dutieid IN ('.$dutiein.') AND cashbonid = \'' . $declaration->cashbonid . '\' AND declarationid = \'' . $declaration->declarationid . '\' AND active ')->result(),
            ), true)
        );
        $this->pdfs->setPaper('A4', 'landscape');
        $this->pdfs->render();
        $this->pdfs->stream('DECLARATION-' . $json->declarationid, array('Attachment' => 0));
    }

    public function search()
    {
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
        $limit = $perpage * ($page - 1);
        $result = $this->M_DestinationType->q_master_search_where('
            AND a.active
            AND ( LOWER(id) LIKE \'%' . $search . '%\'
            OR LOWER(text) LIKE \'%' . $search . '%\'
            )
            ORDER BY text ASC
            LIMIT ' . $perpage . ' OFFSET ' . $limit . '
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

    public function loadDocno($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas'));
        $docno = $this->input->get_post('docno');
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->nik . '\' ')->row();
        header('Content-Type: application/json');
        switch (strtoupper($json->option)) {
            case "CREATE":
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(
                        'url' => array(
                            'detail' => site_url('kasbon_umum/declarationcashbondinas/createcomponent/' . bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $docno, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'schema' => 'temporary', 'createoption' => 'DI')))),
                            'balance' => site_url('kasbon_umum/declarationcashbondinas/componentbalance/' . bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $docno, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'declarationid' => isset($declararation->declarationid) ? $declararation->declarationid : trim($this->session->userdata('nik')), 'schema' => 'temporary')))),
                        )
                    ),
                ));
                break;
            case "UPDATE":
                http_response_code(200);
                echo json_encode(array(
                    'data' => array(
                        'url' => array(
                            'detail' => site_url('kasbon_umum/declarationcashbondinas/updatecomponent/' . bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $docno, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'declarationid' => isset($json->declarationid) ? $json->declarationid : trim($this->session->userdata('nik')), 'schema' => 'temporary', 'createoption' => 'DI')))),
                            'balance' => site_url('kasbon_umum/declarationcashbondinas/componentbalance/' . bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $docno, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'declarationid' => isset($json->declarationid) ? $json->declarationid : trim($this->session->userdata('nik')), 'schema' => 'temporary')))),
                        )
                    ),
                ));
                break;
        }

    }

    public function clearselect($param)
    {
        $json = json_decode(hex2bin($param));
        $this->load->model(array('trans/m_employee', 'master/M_ComponentCashbon', 'M_Cashbon', 'M_CashbonComponent', 'M_DeclarationCashbon', 'M_DeclarationCashbonComponentDinas'));
        $employee = $this->m_employee->q_mst_read_where(' AND nik = \'' . $json->nik . '\' ')->row();
        header('Content-Type: application/json');
        switch (strtoupper($json->option)) {
            case "CREATE":
                $declararation = $this->M_DeclarationCashbon->q_temporary_read_where(' AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ')->row();
                if ($this->M_DeclarationCashbon->q_temporary_exists('TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ')) {
                    $this->M_DeclarationCashbon->q_temporary_update(array('dutieid' => false), array('declarationid' => trim($this->session->userdata('nik'))));
                }
                if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists('TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ')) {
                    $this->M_DeclarationCashbonComponentDinas->q_temporary_delete('TRUE AND declarationid = \'' . trim($this->session->userdata('nik')) . '\' ');
                }
                http_response_code(200);
                echo json_encode(array(
                    'CLEARED' => TRUE,
                    'url' => site_url('kasbon_umum/declarationcashbondinas/componentbalance/' . bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $declararation->dutieid, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'declarationid' => isset($declararation->declarationid) ? $declararation->declarationid : trim($this->session->userdata('nik')), 'schema' => 'temporary')))),
                ));
                break;
            case "UPDATE":
                $declararation = $this->M_DeclarationCashbon->q_temporary_read_where(' AND declarationid = \'' . $json->declarationid . '\' ')->row();
                if ($this->M_DeclarationCashbon->q_temporary_exists('TRUE AND declarationid = \'' . $json->declarationid . '\' ')) {
                    $this->M_DeclarationCashbon->q_temporary_update(array('dutieid' => false), array('declarationid' => $json->declarationid));
                }
                if ($this->M_DeclarationCashbonComponentDinas->q_temporary_exists('TRUE AND declarationid = \'' . $json->declarationid . '\' ')) {
                    $this->M_DeclarationCashbonComponentDinas->q_temporary_delete('TRUE AND declarationid = \'' . $json->declarationid . '\' ');
                }
                http_response_code(200);
                echo json_encode(array(
                    'CLEARED' => TRUE,
                    'url' => site_url('kasbon_umum/declarationcashbondinas/componentbalance/' . bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $declararation->dutieid, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'declarationid' => isset($declararation->declarationid) ? $declararation->declarationid : trim($this->session->userdata('nik')), 'schema' => 'temporary')))),
                ));
                break;
        }


    }
}
