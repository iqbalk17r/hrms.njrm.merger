<?php defined('BASEPATH') or exit('No direct script access allowed');

class BalanceCashbon extends CI_Controller
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

    public function index()
    {
        $this->load->model(array('M_BalanceCashbon'));
        $this->load->library(array('datatablessp'));

        if ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $this->datatablessp->datatable('table-balance-cashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('nik, nmlengkap, nmdept, nmsubdept, balance, balanceformat')
                ->addcolumn('no', 'no')
                ->addcolumn('reformatbalance','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'balanceformat')
                ->addcolumn('detail', '<a href="javascript:void(0)" data-href="' . site_url('kasbon_umum/balancecashbon/detail/$1') . '" class="btn btn-sm btn-info pull-right popup mr-2">Rincian</button>', 'nik', true)
                ->querystring($this->M_BalanceCashbon->q_balance_cashbon_txt_where(''))
                ->header('No.', 'no', true, false, true)
                ->header('NIK', 'nik', true, true, true, array('nik', 'detail'))
                ->header('Nama ', 'nmlengkap', true, true, true)
                ->header('Jabatan', 'nmdept', true, true, true, array('nmdept', 'nmsubdept'))
//            ->header('Sub. Dept', 'nmsubdept', true, false, true)
                ->header('Saldo', 'balance', true, true, true, array('reformatbalance'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Saldo Kasbon Karyawan';
            $this->template->display('kasbon_umum/cashbon_balance/v_read', $data);
        }else{
            $this->datatablessp->datatable('table-balance-cashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('nik, nmlengkap, nmdept, nmsubdept, balance, balanceformat')
                ->addcolumn('no', 'no')
                ->addcolumn('reformatbalance','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'balanceformat')
                ->addcolumn('detail', '<a href="javascript:void(0)" data-href="' . site_url('kasbon_umum/balancecashbon/detail/$1') . '" class="btn btn-sm btn-info pull-right popup mr-2">Rincian</button>', 'nik', true)
                ->querystring($this->M_BalanceCashbon->q_balance_cashbon_txt_where(' AND nik = \''.TRIM($this->session->userdata('nik')).'\' '))
                ->header('No.', 'no', true, false, true)
                ->header('NIK', 'nik', true, true, true, array('nik', 'detail'))
                ->header('Nama ', 'nmlengkap', true, true, true)
                ->header('Jabatan', 'nmdept', true, true, true, array('nmdept', 'nmsubdept'))
//            ->header('Sub. Dept', 'nmsubdept', true, false, true)
                ->header('Saldo', 'balance', true, true, true, array('reformatbalance'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Saldo Kasbon Karyawan';
            $this->template->display('kasbon_umum/cashbon_balance/v_read', $data);
        }
    }

    public function detail($param=null)
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_BalanceCashbon','trans/m_employee'));
        $json = json_decode(hex2bin($param));
        $employee = $this->m_employee->q_mst_read_where(' AND TRIM(nik) = \''.TRIM($json->nik).'\' ')->row();
        header('Content-Type: application/json');
        if (!is_null($employee->nik) && !is_null($employee->nik) && !empty($employee->nik)){
            echo json_encode(array(
                'statustext'    => ucwords('lihat Rincian Saldo'),
                'data' => $employee,
                'canread' => true,
                'next' => site_url('kasbon_umum/balancecashbon/balance_detail/'.bin2hex(json_encode(array('branch' => $employee->branch, 'nik' => $employee->nik )))),
            ));
        }

    }

    public function balance_detail($param=null)
    {
        $json = json_decode(hex2bin($param));

        $this->load->model(array('M_BalanceCashbon','trans/m_employee'));
        $this->load->library(array('datatablessp'));

        $employee = $this->m_employee->q_mst_read_where(' AND TRIM(nik) = \''.TRIM($json->nik).'\' ')->row();
//        $employee = $this->M_BalanceCashbon->q_balance_cashbon_read_where(' AND TRIM(nik) = \''.TRIM($json->nik).'\' ')->row();
        /*var_dump($this->M_BalanceCashbon->q_balance_cashbon_detail_txt_where(' AND TRIM(nik) = \''.$employee->nik.'\' '));
        die();*/
        $this->datatablessp->datatable('table-balance-cashbon-detail', 'table table-striped table-bordered table-hover', true)
            ->columns('nik, nmlengkap, doctype, docno, cash_in, cash_out, cash_informat, cash_outformat, balance, balanceformat, status, inputdate, inputby, reformatdate, reformattime, flag, voucher, cashier_status, cashier_status_color')
            ->addcolumn('no', 'no')
            ->addcolumn('reformatbalance','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'balanceformat')
            ->addcolumn('reformatcashin','<span class=\'pull-right h5 text-success text-right mr-3\'><b>$1</b></span>', 'cash_informat')
            ->addcolumn('reformatcashout','<span class=\'pull-right h5 text-danger text-right mr-3\'><b>$1</b></span>', 'cash_outformat')
            ->addcolumn('reformatcashier_status', '<span class=\'label mt-5 $2 \' style=\'font-size: small; \'>$1</span>','cashier_status, cashier_status_color')
            ->addcolumn('reformatvoucher', '<span class=\'label mt-5 bg-maroon \' style=\'font-size: small; \'>$1</span>','voucher')
            ->addcolumn('dateformat', '<div class="text-center"><span class="badge">$1</span> <span class="badge">$2</span></div>','reformatdate,reformattime')
            ->querystring($this->M_BalanceCashbon->q_balance_cashbon_detail_txt_where(' AND TRIM(nik) = \''.TRIM($employee->nik).'\' '))
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'docno', true, true, true)
            ->header('Tanggal', 'dateformat', true, true, true)
            ->header('Masuk', 'cash_in', true, true, true, array('reformatcashin'))
            ->header('Keluar', 'cash_out', true, true, true, array('reformatcashout'))
            ->header('Saldo', 'balance', true, true, true, array('reformatbalance'))
//            ->header('Status', 'status', true, true, true)
            ->header('Status Kasir', 'cashier_status', true, true, true, array('reformatcashier_status'))
            ->header('Kode Voucher', 'voucher', true, true, true, array('reformatvoucher'));
        $this->datatablessp->generateajax();
        $data = array(
            'title' => 'Rincian Saldo Kasbon Karyawan',
            'emp_name' => $employee->nmlengkap,
            'emp_deptname' => $employee->nmdept,
        );
        $this->template->display('kasbon_umum/cashbon_balance/v_detail', $data);
    }

    public function search() {
        header('Content-Type: application/json');
        $count = $this->m_balancecashbon->q_balance_cashbon_read_where()->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->m_balancecashbon->q_balance_cashbon_read_where('
            AND ( LOWER(componentid) LIKE \'%'.$search.'%\'
            OR LOWER(description) LIKE \'%'.$search.'%\'
            )
            ORDER BY componentid ASC
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
}