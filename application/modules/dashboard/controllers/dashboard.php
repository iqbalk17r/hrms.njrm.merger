<?php

/*
	@author : Junis pusaba
	@recreate : Fiky Ashariza
	12-12-2016
*/

class Dashboard extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['m_modular', 'm_geografis', 'web/m_user', 'master/m_akses', 'trans/m_stspeg', 'trans/m_report', 'pk/m_pk','trans/m_skperingatan', "ga/m_kendaraan"]);
        $this->load->library(['form_validation', 'template', 'Excel_Generator']);
        if (!$this->session->userdata('nik')) {
            redirect('web');
        }
        $level = $this->session->userdata('lvl');
    }

    public function index()
    {
        $directory = 'application/modules/dashboard/views/dashboard/content/';
        $countTemplate = count(glob($directory . "*.{php}",GLOB_BRACE));

        $this->load->model(array('master/m_option'));
        // $setupData = $this->m_option->q_master_read(' TRUE AND kdoption = \'DASHBOARD:ACTIVE\' ')->row();
        // $version = (empty($setupData) ? 1 : ($setupData->value3 == null ? 1 : $setupData->value3));
        
        $nik = $this->session->userdata("nik");
        $hr = trim($this->db->query("select nik from sc_mst.karyawan where bag_dept = 'HA' and nik = '$nik' and jabatan != 'HR06'")
                                ->row()->nik);
        if ($hr == $nik) {
            //setup option
        $versionhr = trim($this->db->query("select value1 from sc_mst.option where trim(kdoption) = 'DEFAULT-DASHBOARD-HR'")
                                ->row()->value1);
        $version = $versionhr;
        }
        else {
        $version = 2;

        }
        $data = array(
            'title' => 'DASHBOARD '.$version,
            'content' => 'dashboard/dashboard/base',
            'url' => site_url('dashboard/version/'.$version),
        );
        $this->template->display($data['content'], $data);
    }

    public function version($version)
    {
        $userid = trim($this->session->userdata('nik'));
//        var_dump($userid);die();
        switch ($version) {
            case 1:
                $this->load->library(array('datatablessp'));
                $this->load->model(array('ga/m_gudang', 'ga/m_kendaraan', 'ga/m_asnkendaraan', 'trans/m_cuti_karyawan', 'trans/m_ijin_karyawan', 'trans/m_dinas', 'trans/m_lembur', 'master/M_ApprovalRule', 'trans/m_absensi', 'trans/m_sberitaacara', 'trans/m_skperingatan'));
                $isHaveAccess = $this->m_akses->list_aksesperdepcuti()->num_rows() > 0 or TRIM($this->m_akses->q_user_check()->row()->level_akses) == 'A';
                $data['title'] = "Home";
                $data['rowakses'] = $isHaveAccess;
                $superiors = $this->m_akses->superiors_access()->num_rows() > 0;
                $approver = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'SPS\' ');
                if ($data['rowakses']) {
                    $attendanceTable = $this->datatablessp->datatable('table-attendance', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                        ->columns('nik, nmlengkap, ketsts, ketcuti, ketijin, bag_dept, nodokcuti, nodokijin, ketercuti, keterijin, tgl_kerja, formatdate, tgl')
                        ->addcolumn('no', 'no')
                        ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('dashboard/dashboard/actionpopup/$1') . '\' class=\' btn btn-sm btn-info pull-right actionpopup \' >Aksi</a>', ' nik, tgl', true)
                        ->querystring($this->m_absensi->q_transready_txt_where(' AND kdjamkerja <> \'OFF\' AND statuskepegawaian<>\'KO\' AND ketsts = \'TIDAK MASUK KERJA\' AND (ketcuti = \'ALPHA\' OR ketijin = \'ALPHA\' ) '))
                        ->header('No.', 'no', true, false, true)
                        ->header('NIK.', 'nik', true, true, true, array('nik', 'action'))
                        ->header('Nama Karyawan', 'nmlengkap', true, true, true)
                        ->header('Departemen', 'bag_dept', true, true, true)
                        ->header('Tanggal', 'formatdate', true, true, true)
                        ->header('Status Absensi', 'ketsts', true, true, true)
                        ->header('Status Ijin', 'ketijin', true, true, true)
                        ->header('Status Cuti', 'ketcuti', true, true, true);
                    if ($this->input->post('tableid') == 'table-attendance') {
                        $attendanceTable->generateajax();
                    }
                    $data['attendanceTable'] = array(
                        'title' => 'Daftar absensi bermasalah',
                        'count' => $this->m_absensi->q_transready_read_where(' AND kdjamkerja <> \'OFF\' AND statuskepegawaian<>\'KO\' AND ketsts = \'TIDAK MASUK KERJA\' AND (ketcuti = \'ALPHA\' OR ketijin = \'ALPHA\' ) ')->num_rows(),
                        'generatetable' => $attendanceTable->generatetable('table-attendance', false),
                        'jquery' => $attendanceTable->jquery(1, 'table-attendance', false),
                        'linkmenu' => site_url('trans/absensi/filter_koreksi'),
                    );
                    $vehicleTable = $this->datatablessp->datatable('table-vehicle', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                        ->columns('nodok, nmbarang, nopol, locaname, expstnkb, exppkbstnkb, formatexpstnkb, formatexppkbstnkb')
                        ->addcolumn('no', 'no')
                        ->querystring($this->m_gudang->q_goods_txt_where(' AND LEFT(kdgroup, 3) = \'KDN\' AND (to_char(expstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') OR to_char(exppkbstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') ) AND hold_item = \'NO\' '))
                        ->header('No.', 'no', true, false, true)
                        ->header('KODE.', 'nodok', true, true, true)
                        ->header('KENDARAAN', 'nmbarang', true, true, true)
                        ->header('NOPOL', 'nopol', true, true, true)
                        ->header('BASE', 'locaname', true, true, true)
                        ->header('EXP. STNK', 'formatexpstnkb', true, true, true, array('formatexpstnkb'))
                        ->header('EXP. BPKB', 'formatexppkbstnkb', true, true, true, array('formatexppkbstnkb'));
                    if ($this->input->post('tableid') == 'table-vehicle') {
                        $vehicleTable->generateajax();
                    }
                    $data['vehicleTable'] = array(
                        'title' => 'Daftar Masa Berlaku STNK Segera Habis',
                        'count' => $this->m_gudang->q_goods_read_where(' AND LEFT(kdgroup, 3) = \'KDN\' AND (to_char(expstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') OR to_char(exppkbstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') ) AND hold_item = \'NO\'  ')->num_rows(),
                        'generatetable' => $vehicleTable->generatetable('table-vehicle', false),
                        'jquery' => $vehicleTable->jquery(1, 'table-vehicle', false),
                        'linkmenu' => site_url('ga/kendaraan/form_stnkbaru'),
                    );

                    $kirVehicleTable = $this->datatablessp->datatable('table-kir-vehicle', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                        ->columns('stockcode, expkir, formatexpkir, nmbarang, nopol, locaname')
                        ->addcolumn('no', 'no')
                        ->querystring($this->m_kendaraan->q_vehicle_kir_txt_where(' AND LEFT(kdgroup, 3) = \'KDN\' AND (to_char(expkir,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\')) AND hold_item = \'NO\' '))
                        ->header('No.', 'no', true, false, true)
                        ->header('Kode Kendaraan', 'stockcode', true, true, true)
                        ->header('Nama KendaraanN', 'nmbarang', true, true, true)
                        ->header('Nopol', 'nopol', true, true, true)
                        ->header('Base', 'locaname', true, true, true)
                        ->header('Berlaku KIR', 'formatexpkir', true, true, true);
                    if ($this->input->post('tableid') == 'table-kir-vehicle') {
                        $kirVehicleTable->generateajax();
                    }
                    $data['vehicleKirTable'] = array(
                        'title' => 'Daftar Masa Berlaku KIR Segera Habis',
                        'count' => $this->m_kendaraan->q_vehicle_kir_read_where(' AND to_char(expkir,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') AND hold_item = \'NO\'  ')->num_rows(),
                        'generatetable' => $kirVehicleTable->generatetable('table-kir-vehicle', false),
                        'jquery' => $kirVehicleTable->jquery(1, 'table-kir-vehicle', false),
                        'linkmenu' => site_url('ga/ujikir/form_ujikir'),
                    );

                    $asnVehicleTable = $this->datatablessp->datatable('table-asn-vehicle', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                        ->columns('docno, docdate, nmbarang, nopol, nmsubasuransi, expasuransi, nmstatus, description')
                        ->addcolumn('no', 'no')
                        ->querystring($this->m_asnkendaraan->q_asn_vehicle_txt_where(' AND (to_char(expasuransi,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\')) '))
                        ->header('No.', 'no', true, false, true)
                        ->header('Kode Kendaraan', 'docno', true, true, true)
                        ->header('Nama KendaraanN', 'docdate', true, true, true)
                        ->header('Nopol', 'nmbarang', true, true, true)
                        ->header('Base', 'nopol', true, true, true)
                        ->header('Base', 'nmsubasuransi', true, true, true)
                        ->header('Base', 'expasuransi', true, true, true)
                        ->header('Base', 'nmstatus', true, true, true)
                        ->header('Berlaku KIR', 'description', true, true, true);
                    if ($this->input->post('tableid') == 'table-asn-vehicle') {
                        $asnVehicleTable->generateajax();
                    }
                    $data['vehicleAsnTable'] = array(
                        'title' => 'Daftar Masa Berlaku Asuransi Segera Habis',
                        'count' => $this->m_asnkendaraan->q_asn_vehicle_read_where(' AND to_char(expasuransi,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\')   ')->num_rows(),
                        'generatetable' => $asnVehicleTable->generatetable('table-asn-vehicle', false),
                        'jquery' => $asnVehicleTable->jquery(1, 'table-asn-vehicle', false),
                        'linkmenu' => site_url('ga/asnkendaraan/form_asnkendaraan'),
                    );

                    $data['list_ojt'] = $this->m_stspeg->q_list_ojt()->result();
                    $data['title_ojt'] = 'Karyawan OJT (On Job Training)';

                    $data['list_kontrak'] = $this->m_stspeg->q_list_karkon()->result();
                    $data['title_kontrak'] = 'Karyawan Kontrak';

                    $data['list_pensiun'] = $this->m_stspeg->q_list_karpen()->result();
                    $data['title_pensiun'] = 'Karyawan Pensiun';

                    $data['list_magang'] = $this->m_stspeg->q_list_magang()->result();
                    $data['title_magang'] = 'Karyawan Magang';

                    $data['list_cuti'] = $this->m_report->q_remind_cuti()->result();
                    $data['title_cuti'] = 'Karyawan Cuti / Cuti Khusus Harian Disetujui';

                    $data['list_dinas'] = $this->m_report->q_remind_dinas()->result();
                    $data['title_dinas'] = 'Karyawan Dinas Disetujui';

                    $data['list_ijin'] = $this->m_report->q_remind_ijin()->result();
                    $data['title_ijin'] = 'Karyawan Ijin Disetujui';

                    $data['list_lembur'] = $this->m_report->q_remind_lembur()->result();
                    $data['title_lembur'] = 'Karyawan Lembur Disetujui';

                    $day = 4;
                    $data['title_recent'] = 'Aktifitas ' . $day . ' Hari Terakhir (Recent Latest Employee Activity)';

                    $data['OJT'] = $this->m_akses->q_option(" AND kdoption = 'REMB7' AND status = 'T'")->num_rows();
                    $data['PENSIUN'] = $this->m_akses->q_option(" AND kdoption = 'REMB8' AND status = 'T'")->num_rows();
                    $data['KONTRAK'] = $this->m_akses->q_option(" AND kdoption = 'REMB9' AND status = 'T'")->num_rows();


                }

                if ($isHaveAccess or $approver) {
                    $query = array(
                        'cutiTable' => $this->m_cuti_karyawan->q_transaction_txt_where(' AND status IN (\'A\')  '),
                        'cutiCount' => $this->m_cuti_karyawan->q_transaction_read_where(' AND status IN (\'A\')  '),
                        'ijinTable' => $this->m_ijin_karyawan->q_transaction_txt_where(' AND status IN (\'A\')  '),
                        'ijinCount' => $this->m_ijin_karyawan->q_transaction_read_where(' AND status IN (\'A\')  '),
                        'lemburTable' => $this->m_lembur->q_transaction_txt_where(' AND status IN (\'A\')  '),
                        'lemburCount' => $this->m_lembur->q_transaction_read_where(' AND status IN (\'A\')  '),
                        'dinasTable' => $this->m_dinas->q_transaction_txt_where(' AND status IN (\'A\')  '),
                        'dinasCount' => $this->m_dinas->q_transaction_read_where(' AND status IN (\'A\')  '),
                        'paTable' => $this->m_pk->q_transaction_txt_where_pa(' AND status IN (\'A\')  '),
                        'paCount' => $this->m_pk->q_transaction_read_where_pa(' AND status IN (\'A\')  '),
                        'fpkTable' => $this->m_pk->q_transaction_txt_where_fpk(' AND status IN (\'A\')  '),
                        'fpkCount' => $this->m_pk->q_transaction_read_where_fpk(' AND status IN (\'A\')  '),
                    );
                } else {
                    $query = array(
                        'cutiTable' => $this->m_cuti_karyawan->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'cutiCount' => $this->m_cuti_karyawan->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'ijinTable' => $this->m_ijin_karyawan->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'ijinCount' => $this->m_ijin_karyawan->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'lemburTable' => $this->m_lembur->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'lemburCount' => $this->m_lembur->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'dinasTable' => $this->m_dinas->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'dinasCount' => $this->m_dinas->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'paTable' => $this->m_pk->q_transaction_txt_where_pa(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'paCount' => $this->m_pk->q_transaction_read_where_pa(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'fpkTable' => $this->m_pk->q_transaction_txt_where_fpk(' AND status IN (\' \') '),
                        'fpkCount' => $this->m_pk->q_transaction_read_where_fpk(' AND status IN (\' \') '),
                    );
                }

                $cutiunapproved = $this->datatablessp->datatable('table-cuti-unapproved', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                    ->columns('nik, status, nmlengkap, bagian, input_date, keterangan, formatstatus, nodok, offday')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/cuti_karyawan/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
                    ->querystring($query['cutiTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors or $approver) ? 'action' : 'dummy')))
                    ->header('NIK', 'nik', true, true, true)
                    ->header('Nama', 'nmlengkap', true, true, true)
                    ->header('Jabatan', 'bagian', true, true, true)
                    ->header('Tanggal', 'offday', true, true, true)
                    ->header('Status', 'formatstatus', true, true, true)
                    ->header('Keterangan', 'keterangan', true, true, true);
                if ($this->input->post('tableid') == 'table-cuti-unapproved') {
                    $cutiunapproved->generateajax();
                }
                $data['cutiunapproved'] = array(
                    'title' => 'Karyawan Cuti / Cuti Khusus Harian Perlu Persetujuan',
                    'count' => $query['cutiCount']->num_rows(),
                    'generatetable' => $cutiunapproved->generatetable('table-cuti-unapproved', false),
                    'jquery' => $cutiunapproved->jquery(1, 'table-cuti-unapproved', false),
                );
                $ijinunapproved = $this->datatablessp->datatable('table-ijin-unapproved', 'table table-striped table-bordered table-hover', true)
                    ->columns('nodok, nik, nmlengkap, bagian, permissiontime, permissiondate, tipe_ijin, formatstatus, kategori, status, superiors')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/ijin_karyawan/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
                    ->querystring($query['ijinTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('NIK', 'nik', true, true, true)
                    ->header('Nama', 'nmlengkap', true, true, true)
                    ->header('Jabatan', 'bagian', true, true, true)
                    ->header('Tanggal', 'permissiondate', true, true, true)
                    ->header('Waktu', 'permissiontime', true, true, true)
                    ->header('Tipe', 'tipe_ijin', true, true, true)
                    ->header('Kategori', 'kategori', true, true, true)
                    ->header('Keterangan', 'formatstatus', true, true, true);
                if ($this->input->post('tableid') == 'table-ijin-unapproved') {
                    $ijinunapproved->generateajax();
                }
                $data['ijinunapproved'] = array(
                    'title' => 'Karyawan Ijin Perlu Persetujuan',
                    'count' => $query['ijinCount']->num_rows(),
 
                   'jquery' => $ijinunapproved->jquery(1, 'table-ijin-unapproved', false),
                );

                $lemburunapproved = $this->datatablessp->datatable('table-lembur-unapproved', 'table table-striped table-bordered table-hover', true)
                    ->columns('nodok, nik, formattgldok, formattglkerja, formatstatus, nmlengkap, bagian, nmsubdept, nmlvljabatan, nmjabatan, uraian, nmatasan1, jam, nmjenis_lembur, status')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/lembur/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
                    ->querystring($query['lemburTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('NIK', 'nik', true, true, true)
                    ->header('Nama', 'nmlengkap', true, true, true)
                    ->header('Jabatan', 'bagian', true, true, true)
                    ->header('Tanggal', 'formattglkerja', true, true, true)
                    ->header('Jam', 'jam', true, true, true)
                    ->header('Jenis', 'nmjenis_lembur', true, true, true)
                    ->header('Keterangan', 'keterangan', true, true, true);
                if ($this->input->post('tableid') == 'table-lembur-unapproved') {
                    $lemburunapproved->generateajax();
                }
                $data['lemburunapproved'] = array(
                    'title' => 'Karyawan Lembur Perlu Persetujuan',
                    'count' => $query['lemburCount']->num_rows(),
                    'generatetable' => $lemburunapproved->generatetable('table-lembur-unapproved', false),
                    'jquery' => $lemburunapproved->jquery(1, 'table-lembur-unapproved', false),
                );

                $dinasunapproved = $this->datatablessp->datatable('table-dinas-unapproved', 'table table-striped table-bordered table-hover', true)
                    ->columns('nik, status, nmlengkap, bagian, tgl, nodok, tujuan_kota, onduty')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/dinas/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
                    ->querystring($query['dinasTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('NIK', 'nik', true, true, true)
                    ->header('Nama', 'nmlengkap', true, true, true)
                    ->header('Jabatan', 'bagian', true, true, true)
                    ->header('Tanggal', 'onduty', true, true, true)
                    ->header('Tujuan', 'tujuan_kota', true, true, true);
                if ($this->input->post('tableid') == 'table-dinas-unapproved') {
                    $dinasunapproved->generateajax();
                }
                $data['dinasunapproved'] = array(
                    'title' => 'Karyawan Dinas Perlu Persetujuan',
                    'count' => $query['dinasCount']->num_rows(),
                    'generatetable' => $dinasunapproved->generatetable('table-dinas-unapproved', false),
                    'jquery' => $dinasunapproved->jquery(1, 'table-dinas-unapproved', false),
                );

                $paunapproved = $this->datatablessp->datatable('table-pa-unapproved', 'table table-striped table-bordered table-hover', true)
                    ->columns('nik, status, nmlengkap, bagian, periode, nodok')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('pk/pk/actionpopuppa/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok', true)
                    ->querystring($query['paTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('Periode', 'periode', true, true, true)
                    ->header('NIK', 'nik', true, true, true)
                    ->header('Nama', 'nmlengkap', true, true, true)
                    ->header('Departmen', 'bagian', true, true, true);
                if ($this->input->post('tableid') == 'table-pa-unapproved') {
                    $paunapproved->generateajax();
                }
                $data['paunapproved'] = array(
                    'title' => 'Penilaian Appraisal Karyawan Perlu Persetujuan',
                    'count' => $query['paCount']->num_rows(),
                    'generatetable' => $paunapproved->generatetable('table-pa-unapproved', false),
                    'jquery' => $paunapproved->jquery(1, 'table-pa-unapproved', false),
                );

                $fpkunapproved = $this->datatablessp->datatable('table-fpk-unapproved', 'table table-striped table-bordered table-hover', true)
                    ->columns('nik, status, nmlengkap, bagian, periode, nodok')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('pk/pk/actionpopupfpk/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
                    ->querystring($query['fpkTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('Periode', 'periode', true, true, true)
                    ->header('Departmen', 'bagian', true, true, true);
                if ($this->input->post('tableid') == 'table-fpk-unapproved') {
                    $fpkunapproved->generateajax();
                }
                $data['fpkunapproved'] = array(
                    'title' => 'Final Penilaian Karyawan Perlu Persetujuan',
                    'count' => $query['fpkCount']->num_rows(),
                    'generatetable' => $fpkunapproved->generatetable('table-fpk-unapproved', false),
                    'jquery' => $fpkunapproved->jquery(1, 'table-fpk-unapproved', false),
                );
                /*need approval*/

                $userlogin = trim($this->session->userdata('nik'));
                if ($approver) {
                    $query = array(
                        'investigationReportTable' => $this->m_sberitaacara->q_transaction_txt_where(' AND status NOT IN ( \'P\',\'A\')  '),
                        'investigationReportCount' => $this->m_sberitaacara->q_transaction_read_where(' AND status NOT IN ( \'P\',\'A\')  '),
                        'warningLetterTable' => $this->m_skperingatan->q_transaction_txt_where(' AND status NOT IN ( \'P\')  '),
                        'warningLetterCount' => $this->m_skperingatan->q_transaction_read_where(' AND status NOT IN ( \'P\')  '),
                        'konditeTable' => $this->m_pk->q_transaction_txt_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'konditeCount' => $this->m_pk->q_transaction_read_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                    );
                } else {
                    $query = array(
                        'investigationReportTable' => $this->m_sberitaacara->q_transaction_txt_where(' AND status NOT IN ( \'P\',\'A\') AND ( nik = \'' . $userlogin . '\' OR superiors ILIKE \'%' . $userlogin . '%\' OR witness ILIKE \'%' . $userlogin . '%\' )  '),
                        'investigationReportCount' => $this->m_sberitaacara->q_transaction_read_where(' AND status NOT IN ( \'P\',\'A\') AND ( nik = \'' . $userlogin . '\' OR superiors ILIKE \'%' . $userlogin . '%\' OR witness ILIKE \'%' . $userlogin . '%\' )  '),
                        'warningLetterTable' => $this->m_skperingatan->q_transaction_txt_where(' AND status NOT IN ( \'P\') AND ( nik = \'' . $userlogin . '\' OR superiors ILIKE \'%' . $userlogin . '%\' ) '),
                        'warningLetterCount' => $this->m_skperingatan->q_transaction_read_where(' AND status NOT IN ( \'P\') AND ( nik = \'' . $userlogin . '\' OR superiors ILIKE \'%' . $userlogin . '%\' ) '),
                        'konditeTable' => $this->m_pk->q_transaction_txt_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                        'konditeCount' => $this->m_pk->q_transaction_read_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                    );
                }
                $investigationReportTable = $this->datatablessp->datatable('table-investigation-report', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                    ->columns('docno, nik, docdate, status, laporan, lokasi, peringatan, tindakan, subjek, nmlengkap, dept_name, to_dept_name, superiors, witness, witness_name, status_name, accident_name, format_docdate')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/sberitaacara/actionpopup/$1') . '\' class=\' btn btn-sm btn-info pull-right actionpopup \' >Aksi</a>', ' nik, docno', true)
                    ->querystring($query['investigationReportTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen.', 'docno', true, true, true, array('docno', 'action'))
                    ->header('NIK.', 'nik', true, true, true, array('nik'))
                    ->header('Nama Karyawan', 'nmlengkap', true, true, true)
                    ->header('Departemen', 'dept_name', true, true, true)
                    ->header('Tanggal', 'docdate', true, true, true, array('format_docdate'))
                    ->header('Saksi', 'witness_name', true, true, true)
                    ->header('Keterangan', 'accident_name', true, true, true)
                    ->header('Status', 'status_name', true, true, true);
                if ($this->input->post('tableid') == 'table-investigation-report') {
                    $investigationReportTable->generateajax();
                }
                $data['investigationReportTable'] = array(
                    'title' => ucwords(strtolower('Daftar berita acara perlu persetujuan')),
                    'count' => $query['investigationReportCount']->num_rows(),
                    'generatetable' => $investigationReportTable->generatetable('table-investigation-report', false),
                    'jquery' => $investigationReportTable->jquery(1, 'table-investigation-report', false),
                    'linkmenu' => site_url('trans/sberitaacara'),
                );
                $warningLetterTable = $this->datatablessp->datatable('table-warning-letter', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                    ->columns('format_docdate, format_periode, docno, nik, docref, description, dept_name, superiors, docname, status_name, nmlengkap')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/skperingatan/actionpopup/$1') . '\' class=\' btn btn-sm btn-info pull-right actionpopup \' >Aksi</a>', ' nik, docno', true)
                    ->querystring($query['warningLetterTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen.', 'docno', true, true, true, array('docno', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('NIK.', 'nik', true, true, true, array('nik'))
                    ->header('Nama Karyawan', 'nmlengkap', true, true, true)
                    ->header('Departemen', 'dept_name', true, true, true)
                    ->header('Tindakan', 'docname', true, true, true)
                    ->header('Periode', 'format_periode', true, true, true, array('format_periode'))
                    ->header('Referensi', 'docref', true, true, true)
                    ->header('Status', 'status_name', true, true, true);
                if ($this->input->post('tableid') == 'table-warning-letter') {
                    $warningLetterTable->generateajax();
                }
                $data['warningLetterTable'] = array(
                    'title' => ucwords(strtolower('Daftar surat peringatan perlu persetujuan')),
                    'count' => $query['warningLetterCount']->num_rows(),
                    'generatetable' => $warningLetterTable->generatetable('table-warning-letter', false),
                    'jquery' => $warningLetterTable->jquery(1, 'table-warning-letter', false),
                    'linkmenu' => site_url('trans/skperingatan'),
                );

                $konditeunapproved = $this->datatablessp->datatable('table-kondite-unapproved', 'table table-striped table-bordered table-hover', true)
                    ->columns('nik, status, nmlengkap, bagian, periode, nodok')
                    ->addcolumn('no', 'no')
                    ->addcolumn('dummy', '')
                    ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('pk/pk/actionpopupkondite/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok', true)
                    ->querystring($query['konditeTable'])
                    ->header('No.', 'no', true, false, true)
                    ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
                    ->header('Periode', 'periode', true, true, true)
                    ->header('NIK', 'nik', true, true, true)
                    ->header('Nama', 'nmlengkap', true, true, true)
                    ->header('Departmen', 'bagian', true, true, true);
                if ($this->input->post('tableid') == 'table-kondite-unapproved') {
                    $konditeunapproved->generateajax();
                }
                $data['konditeunapproved'] = array(
                    'title' => 'Penilaian Kondite Karyawan Perlu Persetujuan',
                    'count' => $query['konditeCount']->num_rows(),
                    'generatetable' => $konditeunapproved->generatetable('table-kondite-unapproved', false),
                    'jquery' => $konditeunapproved->jquery(1, 'table-kondite-unapproved', false),
                );

//        $data['isUserhr'] = ($data['rowakses'] > 0 ? TRUE : FALSE );
                $data['isUserhr'] = FALSE;
                $data['dtlbroadcast'] = $this->m_modular->q_broadcast_dashboard()->row_array();
//                $this->load->view('dashboard/dashboard/content/v1', $data,true);
                $data['content'] = 'dashboard/dashboard/content/v1';
                break;
            case 2:
                $this->load->helper('my');
                $this->load->library(array('datatablessp'));
                $this->load->model(array('trans/M_Employee','trans/M_Stspeg','dashboard/M_Dashboard','pk/m_pk','master/m_option'));
//                $currentDate = new DateTime();
//                $this->M_Dashboard->generateConditee();
//                $this->M_Dashboard->recalculateConditeeUser();
                $employeeData = $this->M_Employee->q_mst_read_where(' AND NIK = \''.$userid.'\' ')->row();
                $datasp = $this->m_skperingatan->dashboardSkp($userid)->row();
                if(!is_null($datasp)) {
                    $periodesp = formattgl($datasp->startdate) . ' - ' . formattgl($datasp->enddate);
                }
                else {
                    $periodesp = '-';
                }
                $datamstlvm = $this->db->query("select masakerja1, nmcabang from sc_mst.lv_m_karyawan where nik='$userid'")->row();
                $masakerja = $datamstlvm->masakerja1;
                $kanwil = $datamstlvm->nmcabang;
                $currentDate = new DateTime();
                $startDate = clone $currentDate;
                $startDate = $currentDate->modify('0 months')->format('Ym01');
                $startDateFormat = monthYear(date('Y-m', strtotime($startDate)));
                $finishDate = clone $currentDate;
                $finishDate = $currentDate->modify('-11 months')->format('Ym01');
                $finishDateFormat = monthYear(date('Y-m', strtotime($finishDate)));
                $conditee['series'] = array();
                $conditee['drilldown'] = array();
                $kpi['series'] = array();
                $kpi['drilldown'] = array();
//                var_dump($jsonData->conditee->series);die();
//                $periodMonth = $this->generateMonthlyDates($finishDate,$startDate);
                $processedMonths = array();
                foreach ($this->generateMonthlyDates($finishDate, $startDate) as $index => $generateMonthlyDate) {
                    $currentMonth = substr($generateMonthlyDate, 0, 6);
                    // Check if the month has already been processed
                    if (!in_array($currentMonth, $processedMonths)) {
                        $processedMonths[] = $currentMonth; // Mark the month as processed
                        // Check if the current month is already in $conditee
                        $existingMonthIndex = array_search($currentMonth, array_column($conditee, 'name'));
                        // If the month is not in $conditee, add a new entry
                        if ($existingMonthIndex === false) {
                            $itemFound = false;
                            foreach ($this->m_pk->q_list_kpi_report(' AND trim(nik) = \'' . $employeeData->nik . '\' ')->result() as $indexKpi => $itemKpi) {
                                if ($currentMonth === trim($itemKpi->periode)) {
                                    array_push($kpi['series'], array(
                                        'name' => date('M-y', strtotime($generateMonthlyDate)),
                                        'y' => (float)$itemKpi->kpi_point,
                                        'drilldown' => null,
                                    ));
                                    $itemFound = true;
                                    break; // No need to continue checking other items
                                }
                            }

                            // foreach ($this->m_pk->q_list_kondite_report(' AND nik = \'' . $employeeData->nik . '\' ')->result() as $indexConditee => $itemConditee) {
                            //     if ($currentMonth === $itemConditee->periode) {
                            //         array_push($conditee['series'], array(
                            //             'name' => date('M-y', strtotime($generateMonthlyDate)),
                            //             //tondo 
                            //             'y' => ((float)$itemConditee->f_score_k < 0 ? 0 : (float)$itemConditee->f_score_k),
                            //             'drilldown' => date('M-y', strtotime($generateMonthlyDate)),
                            //         ));
                            //         array_push($conditee['drilldown'],array(
                            //             'name' => date('M-y', strtotime($generateMonthlyDate)),
                            //             'id' => date('M-y', strtotime($generateMonthlyDate)),
                            //             'data' => array(
                            //                 array('Alpha',(float)$itemConditee->c2_ttlvalueal),
                            //                 array('Ijin Pribadi',(float)$itemConditee->c2_ttlvalueip),
                            //                 array('Surat Dokter',(float)$itemConditee->c2_ttlvaluesd),
                            //                 array('Terlambat',(float)$itemConditee->c2_ttlvaluetl),
                            //                 array('Cuti',(float)$itemConditee->c2_ttlvaluect),
                            //                 array('Ijin Keluar',(float)$itemConditee->c2_ttlvalueik),
                            //                 array('Ijin Terlambat',(float)$itemConditee->c2_ttlvalueitl),
                            //                 array('Ijin Pulang Awal',(float)$itemConditee->c2_ttlvalueipa),
                            //                 array('SP1',(float)$itemConditee->c2_ttlvaluesp1),
                            //                 array('SP2',(float)$itemConditee->c2_ttlvaluesp2),
                            //                 array('SP3',(float)$itemConditee->c2_ttlvaluesp3),
                            //             )
                            //         ));
                            //         $itemFound = true;
                            //         break; // No need to continue checking other items
                            //     }
                            // }
                             foreach ($this->m_pk->q_list_kondite_report(' AND nik = \'' . $employeeData->nik . '\' ')->result() as $indexConditee => $itemConditee) {
                                if ($currentMonth === $itemConditee->periode) {
                                    array_push($conditee['series'], array(
                                        'name' => date('M-y', strtotime($generateMonthlyDate)),
                                        //tondo 
                                        'y' => (float)$itemConditee->f_score_k,
                                        'drilldown' => date('M-y', strtotime($generateMonthlyDate)),
                                    ));
                                    array_push($conditee['drilldown'],array(
                                        'name' => date('M-y', strtotime($generateMonthlyDate)),
                                        'id' => date('M-y', strtotime($generateMonthlyDate)),
                                        'data' => array(
                                            array('Alpha',(int)$itemConditee->ttlvalueal),
                                            array('Ijin Pribadi',(int)$itemConditee->ttlvalueip),
                                            array('Surat Dokter',(int)$itemConditee->ttlvaluesd),
                                            array('Terlambat',(int)$itemConditee->ttlvaluetl),
                                            array('Cuti',(int)$itemConditee->ttlvaluect),
                                            array('Ijin Keluar',(int)$itemConditee->ttlvalueik),
                                            array('Ijin Terlambat',(int)$itemConditee->ttlvalueitl),
                                            array('Ijin Pulang Awal',(int)$itemConditee->ttlvalueipa),
                                            array('SP1',(int)$itemConditee->ttlvaluesp1),
                                            array('SP2',(int)$itemConditee->ttlvaluesp2),
                                            array('SP3',(int)$itemConditee->ttlvaluesp3),
                                        )
                                    ));
                                    $itemFound = true;
                                    break; // No need to continue checking other items
                                }
                            } 
                       
                            // If the item was not found, add a default entry
                            if (!$itemFound) {
                                array_push($kpi['series'], array(
                                    'name' => date('M-y', strtotime($generateMonthlyDate)),
                                    'y' => 0,
                                    'drilldown' => null,
                                ));
                                array_push($conditee['series'], array(
                                    'name' => date('M-y', strtotime($generateMonthlyDate)),
                                    'y' => 0,
                                    'drilldown' => null,
                                ));

                            }
                            
                        }
                    }
                }
                //var_dump($conditee['series']);die();
//                var_dump($kpi['series']);die();
                $contractData = $this->M_Stspeg->q_transaction_read_where(' AND nik = \''.$employeeData->nik.'\' ORDER BY tgl_mulai DESC LIMIT 1 ')->row();
                $chartTypes = array(
                    'column',
                    'line',
                    'spline',
                    'area',
                    'areaspline',
                    'scatter',
                );
                $data = array(
                    'default' => (object)array(
                        'employee' => $employeeData,
                        'contract' => $contractData,
                        'datasp' => $datasp,
                        'masakerja' => $masakerja,
                        'kanwil' => $kanwil,
                        'periodesp' => $periodesp,
                        'period' => $finishDateFormat.' - '.$startDateFormat,
                        'intervalSetup' => $this->m_option->q_master_read_default(' AND parameter = \'REFRESH:INTERVAL\' ',5000),
                    ),
                    'url' => (object)array(
                        'kpi' => site_url('pk/pk/form_report_kpi_karyawan/'.$employeeData->nik),
                        'conditee' => site_url('pk/pk/report_kondite_karyawan/'.$employeeData->nik),
                    ),
                    'highchart' => (object)array(
                        'chartTypes' => (object)$chartTypes,
                        'conditee'=>(object)array(
                            'series'=>json_encode($conditee['series'],JSON_PRETTY_PRINT),
                            'drilldown'=>json_encode($conditee['drilldown'],JSON_PRETTY_PRINT),
                        ),
                        'kpi'=>(object)array(
                            'series'=>json_encode($kpi['series'],JSON_PRETTY_PRINT),
                            'drilldown'=>json_encode($kpi['drilldown'],JSON_PRETTY_PRINT),
                        ),
                    ),
                    'content' => 'dashboard/dashboard/content/v2',
                );
                if ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
                    $this->datatablessp->datatable('table-document-list', 'table table-striped table-bordered table-hover', true)
                        ->columns('fullname, nik, docno, document_type, document_name, workdate, start, finish, detail_information, description, status, search, department_name, subdepartment_name, position_name')
                        ->addcolumn('no', 'no')
                        ->addcolumn('docno_format', '<span class="text-black font-weight-bold">$1</span>','docno')
                        ->addcolumn('userid', '<span class="text-black">$1</span><br><span class="text-info"><b>$2</b></span>','nik,fullname')
                        ->addcolumn('detail_info', '<span class="h5"><center>$1</center></span>','detail_information')
                        ->addcolumn('position', '<span class="text-black">$1</span><br><span class="text-info"><b>$2</b></span>','department_name,position_name')
                        ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('dashboard/actionapproval/$1').'\' class=\'btn btn-xs btn-success popupv2 pull-right ml-3\' title="Persetujuan"><i class=\'fa fa-check\'></i></a>', 'nik, docno, document_type', true)
                        ->addcolumn('detail', '<a href=\'javascript:void(0)\' data-href=\''.site_url('dashboard/actiondetail/$1').'\' class=\'btn btn-xs bg-maroon popupv3 read-detail pull-right ml-3\' title="Rincian"><i class=\'fa fa-bars\'></i></a>', 'nik, docno, document_type', true)
                        ->querystring($this->M_Dashboard->document_list_txt(' AND TRUE AND status IN(\'A\',\'S1\',\'S2\',\'B\',\'BP\') '))
                        ->header('No.', 'no', false, false, true)
                        ->header('Dokumen', 'docno', true, true, true, array('docno_format','popup','detail'))
                        ->header('Jenis Dokumen', 'document_name', true, true, true)
                        ->header('Karyawan', 'fullname', true, true, true, array('userid'))
                        ->header('Departemen', 'department_name', true, true, true,array('position'))
                        ->header('Detail Informasi', 'detail_information', true, true, true,array('detail_info'))
                        ->header('Keterangan', 'description', true, true, true);

//                        ->header('Aksi', '', false, false, true, array('detail'));
                    $this->datatablessp->generateajax();
                } else {
                    $this->datatablessp->datatable('table-document-list', 'table table-striped table-bordered table-hover', true)
                        ->columns('fullname, nik, docno, document_type, document_name, workdate, start, finish, detail_information, description, status, search, department_name, subdepartment_name, position_name')
                        ->addcolumn('no', 'no')
                        ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('dashboard/actionapproval/$1').'\' class=\'btn btn-xs btn-success popupv2 pull-right ml-3\' title="Persetujuan"><i class=\'fa fa-check\'></i></a>', 'nik, docno, document_type', true)
                        ->addcolumn('detail', '<a href=\'javascript:void(0)\' data-href=\''.site_url('dashboard/actiondetail/$1').'\' class=\'btn btn-xs bg-maroon popupv3 read-detail pull-right ml-3\' title="Rincian"><i class=\'fa fa-bars\'></i></a>', 'nik, docno, document_type', true)
                        ->querystring($this->M_Dashboard->document_list_txt(' AND search ILIKE \'%'.$employeeData->nik.'%\' AND status IN(\'A\',\'S1\',\'S2\',\'B\') '))
                        ->header('No.', 'no', false, false, true)
                        ->header('Dokumen', 'docno', true, true, true,array('docno','detail'))
                        ->header('Jenis Dokumen', 'document_name', true, true, true)
                        ->header('Karyawan', 'fullname', true, true, true)
                        ->header('Departemen', 'department_name', true, true, true)
                        ->header('Detail Informasi', 'detail_information', true, true, true)
                        ->header('Keterangan', 'description', true, true, true);

//                        ->header('Aksi', '', false, false, true, array('detail'));
                    $this->datatablessp->generateajax();
                }
                    break;
                case 3:

            $data["title"] = "Home";
            $data["rowakses"] = $this->m_akses->list_aksesperdep()->num_rows();
            $nik = $this->session->userdata("nik");
          
            $hr = trim($this->db->query("select nik from sc_mst.karyawan where bag_dept = 'HA' and nik = '$nik'")
                                    ->row()->nik);
        

        //if($data["rowakses"] > 0 || $data["level"] == "A") {
            $data["list_ojt"] = $this->m_stspeg->q_list_ojt()->result();
            $data["title_ojt"] = "Karyawan OJT (On Job Training)";

            $data["list_kontrak"] = $this->m_stspeg->q_list_karkon()->result();
            $data["title_kontrak"] = "Karyawan Kontrak";

            $data["list_pensiun"] = $this->m_stspeg->q_list_karpen()->result();
            $data["title_pensiun"] = "Karyawan Pensiun";

            $data["list_magang"] = $this->m_stspeg->q_list_magang()->result();
            $data["title_magang"] = "Karyawan Magang";

            $data["list_kendaraan"] = $this->m_kendaraan->q_mstkendaraan()->result();;
            $data["title_kendaraan"] = "Kendaraan";
			
			$data["list_kir_kendaraan"] = $this->m_kendaraan->q_kirkendaraan()->result();;
            $data["title_kir_kendaraan"] = "KIR Kendaraan";

			$data["list_cuti"] = $this->m_report->q_remind_cuti()->result();
			$data["title_cuti"] = "Karyawan Cuti / Cuti Khusus Harian";

			$data["list_dinas"] = $this->m_report->q_remind_dinas()->result();
			$data["title_dinas"] = "Karyawan Dinas";

			$data["list_ijin"] = $this->m_report->q_remind_ijin()->result();
			$data["title_ijin"] = "Karyawan Ijin";

			$data["list_lembur"] = $this->m_report->q_remind_lembur()->result();
			$data["title_lembur"] = "Karyawan Lembur";
            
            $data["title_pk"] = "Penilaian Karyawan kontrak HRGA";
			if(trim($hr) != trim($nik)){
			$parampk = "AND c.nik_atasan = '$nik' or c.nik_atasan2 = '$nik'";
            $data["title_pk"] = "Penilaian Karyawan kontrak";
				}
			$data["list_pk"] = $this->m_pk->q_remind_pk($parampk)->result();
			
			
			if(trim($hr) == trim($nik)){
			$data["list_tl"] = $this->m_report->q_remind_tl()->result();
			$data["title_tl"] = "Karyawan Terlambat";
				}
			
			if(empty($hr)){
			$paramsp = "AND nik = '$nik'";
			}
			$data["list_sp"] = $this->m_report->q_remind_sp($paramsp)->result();
			$data["title_sp"] = "informasi sp";
		//}
        if ($this->session->userdata('firstuse')){
            $this->load->model(array('trans/m_karyawan'));
            $employee = $this->m_karyawan->q_karyawan_read('TRUE AND trim(nik) = \'' . trim($this->session->userdata('nik')) . '\' ')->row();
            $user = $this->m_user->cekUser(trim($this->session->userdata('nik')))->row();
            $data['default'] = array(
                'user'=> trim($user->nik).'|'.trim($user->username),
                'tipe' => 'edit'
            );
            $data['modalTitle'] = 'Selamat datang '.(!empty($employee) ? $employee->callname : 'user');
        }
        $day = 4;
        $data["title_recent"] = "Aktifitas ". $day ." Hari Terakhir (Recent Latest Employee Activity)";

        $data['dtlbroadcast'] = $this->m_modular->q_broadcast_dashboard()->row_array();

		$data['content'] = 'dashboard/dashboard/content/v3';
        break;
        }
           // data pk
        // $nikuser = $this->session->userdata("nik");
        // $parampk = "AND c.nik_atasan = '$nikuser' or c.nik_atasan2 = '$nikuser' and a.kdkepegawaian not in('KO', 'KT','MG','PK') and a.status='B' and tgl_selesai - INTERVAL '2 months' <= CURRENT_DATE ";
        // $data["leveljbt"] = trim($this->db->query("select lvl_jabatan from sc_mst.karyawan where nik = '$nikuser'")
        //                             ->row()->lvl_jabatan);   
        // $data["list_pk"] = $this->m_pk->q_remind_pk($parampk)->result();
        


        $this->load->view($data['content'],$data);
    }
    function index_old()
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('ga/m_gudang', 'ga/m_kendaraan', 'ga/m_asnkendaraan', 'trans/m_cuti_karyawan', 'trans/m_ijin_karyawan', 'trans/m_dinas', 'trans/m_lembur', 'master/M_ApprovalRule', 'trans/m_absensi', 'trans/m_sberitaacara', 'trans/m_skperingatan'));
        $isHaveAccess = $this->m_akses->list_aksesperdepcuti()->num_rows() > 0 or TRIM($this->m_akses->q_user_check()->row()->level_akses) == 'A';
        $data['title'] = "Home";
        $data['rowakses'] = $isHaveAccess;
        $superiors = $this->m_akses->superiors_access()->num_rows() > 0;
        $approver = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'SPS\' ');
        if ($data['rowakses']) {
            $attendanceTable = $this->datatablessp->datatable('table-attendance', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                ->columns('nik, nmlengkap, ketsts, ketcuti, ketijin, bag_dept, nodokcuti, nodokijin, ketercuti, keterijin, tgl_kerja, formatdate, tgl')
                ->addcolumn('no', 'no')
                ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('dashboard/dashboard/actionpopup/$1') . '\' class=\' btn btn-sm btn-info pull-right actionpopup \' >Aksi</a>', ' nik, tgl', true)
                ->querystring($this->m_absensi->q_transready_txt_where(' AND kdjamkerja <> \'OFF\' AND statuskepegawaian<>\'KO\' AND ketsts = \'TIDAK MASUK KERJA\' AND (ketcuti = \'ALPHA\' OR ketijin = \'ALPHA\' ) '))
                ->header('No.', 'no', true, false, true)
                ->header('NIK.', 'nik', true, true, true, array('nik', 'action'))
                ->header('Nama Karyawan', 'nmlengkap', true, true, true)
                ->header('Departemen', 'bag_dept', true, true, true)
                ->header('Tanggal', 'formatdate', true, true, true)
                ->header('Status Absensi', 'ketsts', true, true, true)
                ->header('Status Ijin', 'ketijin', true, true, true)
                ->header('Status Cuti', 'ketcuti', true, true, true);
            if ($this->input->post('tableid') == 'table-attendance') {
                $attendanceTable->generateajax();
            }
            $data['attendanceTable'] = array(
                'title' => 'Daftar absensi bermasalah',
                'count' => $this->m_absensi->q_transready_read_where(' AND kdjamkerja <> \'OFF\' AND statuskepegawaian<>\'KO\' AND ketsts = \'TIDAK MASUK KERJA\' AND (ketcuti = \'ALPHA\' OR ketijin = \'ALPHA\' ) ')->num_rows(),
                'generatetable' => $attendanceTable->generatetable('table-attendance', false),
                'jquery' => $attendanceTable->jquery(1, 'table-attendance', false),
                'linkmenu' => site_url('trans/absensi/filter_koreksi'),
            );
            $vehicleTable = $this->datatablessp->datatable('table-vehicle', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                ->columns('nodok, nmbarang, nopol, locaname, expstnkb, exppkbstnkb, formatexpstnkb, formatexppkbstnkb')
                ->addcolumn('no', 'no')
                ->querystring($this->m_gudang->q_goods_txt_where(' AND LEFT(kdgroup, 3) = \'KDN\' AND (to_char(expstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') OR to_char(exppkbstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') ) AND hold_item = \'NO\' '))
                ->header('No.', 'no', true, false, true)
                ->header('KODE.', 'nodok', true, true, true)
                ->header('KENDARAAN', 'nmbarang', true, true, true)
                ->header('NOPOL', 'nopol', true, true, true)
                ->header('BASE', 'locaname', true, true, true)
                ->header('EXP. STNK', 'formatexpstnkb', true, true, true, array('formatexpstnkb'))
                ->header('EXP. BPKB', 'formatexppkbstnkb', true, true, true, array('formatexppkbstnkb'));
            if ($this->input->post('tableid') == 'table-vehicle') {
                $vehicleTable->generateajax();
            }
            $data['vehicleTable'] = array(
                'title' => 'Daftar Masa Berlaku STNK Segera Habis',
                'count' => $this->m_gudang->q_goods_read_where(' AND LEFT(kdgroup, 3) = \'KDN\' AND (to_char(expstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') OR to_char(exppkbstnkb,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') ) AND hold_item = \'NO\'  ')->num_rows(),
                'generatetable' => $vehicleTable->generatetable('table-vehicle', false),
                'jquery' => $vehicleTable->jquery(1, 'table-vehicle', false),
                'linkmenu' => site_url('ga/kendaraan/form_stnkbaru'),
            );

            $kirVehicleTable = $this->datatablessp->datatable('table-kir-vehicle', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                ->columns('stockcode, expkir, formatexpkir, nmbarang, nopol, locaname')
                ->addcolumn('no', 'no')
                ->querystring($this->m_kendaraan->q_vehicle_kir_txt_where(' AND LEFT(kdgroup, 3) = \'KDN\' AND (to_char(expkir,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\')) AND hold_item = \'NO\' '))
                ->header('No.', 'no', true, false, true)
                ->header('Kode Kendaraan', 'stockcode', true, true, true)
                ->header('Nama KendaraanN', 'nmbarang', true, true, true)
                ->header('Nopol', 'nopol', true, true, true)
                ->header('Base', 'locaname', true, true, true)
                ->header('Berlaku KIR', 'formatexpkir', true, true, true);
            if ($this->input->post('tableid') == 'table-kir-vehicle') {
                $kirVehicleTable->generateajax();
            }
            $data['vehicleKirTable'] = array(
                'title' => 'Daftar Masa Berlaku KIR Segera Habis',
                'count' => $this->m_kendaraan->q_vehicle_kir_read_where(' AND to_char(expkir,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\') AND hold_item = \'NO\'  ')->num_rows(),
                'generatetable' => $kirVehicleTable->generatetable('table-kir-vehicle', false),
                'jquery' => $kirVehicleTable->jquery(1, 'table-kir-vehicle', false),
                'linkmenu' => site_url('ga/ujikir/form_ujikir'),
            );

            $asnVehicleTable = $this->datatablessp->datatable('table-asn-vehicle', 'table table-striped table-bordered table-hover dataTable-SSP', true)
                ->columns('docno, docdate, nmbarang, nopol, nmsubasuransi, expasuransi, nmstatus, description')
                ->addcolumn('no', 'no')
                ->querystring($this->m_asnkendaraan->q_asn_vehicle_txt_where(' AND (to_char(expasuransi,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\')) '))
                ->header('No.', 'no', true, false, true)
                ->header('Kode Kendaraan', 'docno', true, true, true)
                ->header('Nama KendaraanN', 'docdate', true, true, true)
                ->header('Nopol', 'nmbarang', true, true, true)
                ->header('Base', 'nopol', true, true, true)
                ->header('Base', 'nmsubasuransi', true, true, true)
                ->header('Base', 'expasuransi', true, true, true)
                ->header('Base', 'nmstatus', true, true, true)
                ->header('Berlaku KIR', 'description', true, true, true);
            if ($this->input->post('tableid') == 'table-asn-vehicle') {
                $asnVehicleTable->generateajax();
            }
            $data['vehicleAsnTable'] = array(
                'title' => 'Daftar Masa Berlaku Asuransi Segera Habis',
                'count' => $this->m_asnkendaraan->q_asn_vehicle_read_where(' AND to_char(expasuransi,\'YYYYMM\') between to_char(now() - interval \'2 Months\',\'YYYYMM\') and  to_char(now() + interval \'2 Months\',\'YYYYMM\')   ')->num_rows(),
                'generatetable' => $asnVehicleTable->generatetable('table-asn-vehicle', false),
                'jquery' => $asnVehicleTable->jquery(1, 'table-asn-vehicle', false),
                'linkmenu' => site_url('ga/asnkendaraan/form_asnkendaraan'),
            );

            $data['list_ojt'] = $this->m_stspeg->q_list_ojt()->result();
            $data['title_ojt'] = 'Karyawan OJT (On Job Training)';

            $data['list_kontrak'] = $this->m_stspeg->q_list_karkon()->result();
            $data['title_kontrak'] = 'Karyawan Kontrak';

            $data['list_pensiun'] = $this->m_stspeg->q_list_karpen()->result();
            $data['title_pensiun'] = 'Karyawan Pensiun';

            $data['list_magang'] = $this->m_stspeg->q_list_magang()->result();
            $data['title_magang'] = 'Karyawan Magang';

            $data['list_cuti'] = $this->m_report->q_remind_cuti()->result();
            $data['title_cuti'] = 'Karyawan Cuti / Cuti Khusus Harian Disetujui';

            $data['list_dinas'] = $this->m_report->q_remind_dinas()->result();
            $data['title_dinas'] = 'Karyawan Dinas Disetujui';

            $data['list_ijin'] = $this->m_report->q_remind_ijin()->result();
            $data['title_ijin'] = 'Karyawan Ijin Disetujui';

            $data['list_lembur'] = $this->m_report->q_remind_lembur()->result();
            $data['title_lembur'] = 'Karyawan Lembur Disetujui';

            $day = 4;
            $data['title_recent'] = 'Aktifitas ' . $day . ' Hari Terakhir (Recent Latest Employee Activity)';

            $data['OJT'] = $this->m_akses->q_option(" AND kdoption = 'REMB7' AND status = 'T'")->num_rows();
            $data['PENSIUN'] = $this->m_akses->q_option(" AND kdoption = 'REMB8' AND status = 'T'")->num_rows();
            $data['KONTRAK'] = $this->m_akses->q_option(" AND kdoption = 'REMB9' AND status = 'T'")->num_rows();


        }

        if ($isHaveAccess or $approver) {
            $query = array(
                'cutiTable' => $this->m_cuti_karyawan->q_transaction_txt_where(' AND status IN (\'A\')  '),
                'cutiCount' => $this->m_cuti_karyawan->q_transaction_read_where(' AND status IN (\'A\')  '),
                'ijinTable' => $this->m_ijin_karyawan->q_transaction_txt_where(' AND status IN (\'A\')  '),
                'ijinCount' => $this->m_ijin_karyawan->q_transaction_read_where(' AND status IN (\'A\')  '),
                'lemburTable' => $this->m_lembur->q_transaction_txt_where(' AND status IN (\'A\')  '),
                'lemburCount' => $this->m_lembur->q_transaction_read_where(' AND status IN (\'A\')  '),
                'dinasTable' => $this->m_dinas->q_transaction_txt_where(' AND status IN (\'A\')  '),
                'dinasCount' => $this->m_dinas->q_transaction_read_where(' AND status IN (\'A\')  '),
                'paTable' => $this->m_pk->q_transaction_txt_where_pa(' AND status IN (\'A\')  '),
                'paCount' => $this->m_pk->q_transaction_read_where_pa(' AND status IN (\'A\')  '),
                'fpkTable' => $this->m_pk->q_transaction_txt_where_fpk(' AND status IN (\'A\')  '),
                'fpkCount' => $this->m_pk->q_transaction_read_where_fpk(' AND status IN (\'A\')  '),
            );
        } else {
            $query = array(
                'cutiTable' => $this->m_cuti_karyawan->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'cutiCount' => $this->m_cuti_karyawan->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'ijinTable' => $this->m_ijin_karyawan->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'ijinCount' => $this->m_ijin_karyawan->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'lemburTable' => $this->m_lembur->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'lemburCount' => $this->m_lembur->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'dinasTable' => $this->m_dinas->q_transaction_txt_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'dinasCount' => $this->m_dinas->q_transaction_read_where(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'paTable' => $this->m_pk->q_transaction_txt_where_pa(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'paCount' => $this->m_pk->q_transaction_read_where_pa(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'fpkTable' => $this->m_pk->q_transaction_txt_where_fpk(' AND status IN (\' \') '),
                'fpkCount' => $this->m_pk->q_transaction_read_where_fpk(' AND status IN (\' \') '),
            );
        }

        $cutiunapproved = $this->datatablessp->datatable('table-cuti-unapproved', 'table table-striped table-bordered table-hover dataTable-SSP', true)
            ->columns('nik, status, nmlengkap, bagian, input_date, keterangan, formatstatus, nodok, offday')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/cuti_karyawan/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
            ->querystring($query['cutiTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors or $approver) ? 'action' : 'dummy')))
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'offday', true, true, true)
            ->header('Status', 'formatstatus', true, true, true)
            ->header('Keterangan', 'keterangan', true, true, true);
        if ($this->input->post('tableid') == 'table-cuti-unapproved') {
            $cutiunapproved->generateajax();
        }
        $data['cutiunapproved'] = array(
            'title' => 'Karyawan Cuti / Cuti Khusus Harian Perlu Persetujuan',
            'count' => $query['cutiCount']->num_rows(),
            'generatetable' => $cutiunapproved->generatetable('table-cuti-unapproved', false),
            'jquery' => $cutiunapproved->jquery(1, 'table-cuti-unapproved', false),
        );
        $ijinunapproved = $this->datatablessp->datatable('table-ijin-unapproved', 'table table-striped table-bordered table-hover', true)
            ->columns('nodok, nik, nmlengkap, bagian, permissiontime, permissiondate, tipe_ijin, formatstatus, kategori, status, superiors')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/ijin_karyawan/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
            ->querystring($query['ijinTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'permissiondate', true, true, true)
            ->header('Waktu', 'permissiontime', true, true, true)
            ->header('Tipe', 'tipe_ijin', true, true, true)
            ->header('Kategori', 'kategori', true, true, true)
            ->header('Keterangan', 'formatstatus', true, true, true);
        if ($this->input->post('tableid') == 'table-ijin-unapproved') {
            $ijinunapproved->generateajax();
        }
        $data['ijinunapproved'] = array(
            'title' => 'Karyawan Ijin Perlu Persetujuan',
            'count' => $query['ijinCount']->num_rows(),
            'generatetable' => $ijinunapproved->generatetable('table-ijin-unapproved', false),
            'jquery' => $ijinunapproved->jquery(1, 'table-ijin-unapproved', false),
        );

        $lemburunapproved = $this->datatablessp->datatable('table-lembur-unapproved', 'table table-striped table-bordered table-hover', true)
            ->columns('nodok, nik, formattgldok, formattglkerja, formatstatus, nmlengkap, bagian, nmsubdept, nmlvljabatan, nmjabatan, uraian, nmatasan1, jam, nmjenis_lembur, status')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/lembur/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
            ->querystring($query['lemburTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'formattglkerja', true, true, true)
            ->header('Jam', 'jam', true, true, true)
            ->header('Jenis', 'nmjenis_lembur', true, true, true)
            ->header('Keterangan', 'keterangan', true, true, true);
        if ($this->input->post('tableid') == 'table-lembur-unapproved') {
            $lemburunapproved->generateajax();
        }
        $data['lemburunapproved'] = array(
            'title' => 'Karyawan Lembur Perlu Persetujuan',
            'count' => $query['lemburCount']->num_rows(),
            'generatetable' => $lemburunapproved->generatetable('table-lembur-unapproved', false),
            'jquery' => $lemburunapproved->jquery(1, 'table-lembur-unapproved', false),
        );

        $dinasunapproved = $this->datatablessp->datatable('table-dinas-unapproved', 'table table-striped table-bordered table-hover', true)
            ->columns('nik, status, nmlengkap, bagian, tgl, nodok, tujuan_kota, onduty')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/dinas/actionpopup/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
            ->querystring($query['dinasTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'onduty', true, true, true)
            ->header('Tujuan', 'tujuan_kota', true, true, true);
        if ($this->input->post('tableid') == 'table-dinas-unapproved') {
            $dinasunapproved->generateajax();
        }
        $data['dinasunapproved'] = array(
            'title' => 'Karyawan Dinas Perlu Persetujuan',
            'count' => $query['dinasCount']->num_rows(),
            'generatetable' => $dinasunapproved->generatetable('table-dinas-unapproved', false),
            'jquery' => $dinasunapproved->jquery(1, 'table-dinas-unapproved', false),
        );

        $paunapproved = $this->datatablessp->datatable('table-pa-unapproved', 'table table-striped table-bordered table-hover', true)
            ->columns('nik, status, nmlengkap, bagian, periode, nodok')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('pk/pk/actionpopuppa/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok', true)
            ->querystring($query['paTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('Periode', 'periode', true, true, true)
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Departmen', 'bagian', true, true, true);
        if ($this->input->post('tableid') == 'table-pa-unapproved') {
            $paunapproved->generateajax();
        }
        $data['paunapproved'] = array(
            'title' => 'Penilaian Appraisal Karyawan Perlu Persetujuan',
            'count' => $query['paCount']->num_rows(),
            'generatetable' => $paunapproved->generatetable('table-pa-unapproved', false),
            'jquery' => $paunapproved->jquery(1, 'table-pa-unapproved', false),
        );

        $fpkunapproved = $this->datatablessp->datatable('table-fpk-unapproved', 'table table-striped table-bordered table-hover', true)
            ->columns('nik, status, nmlengkap, bagian, periode, nodok')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('pk/pk/actionpopupfpk/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok, nik', true)
            ->querystring($query['fpkTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('Periode', 'periode', true, true, true)
            ->header('Departmen', 'bagian', true, true, true);
        if ($this->input->post('tableid') == 'table-fpk-unapproved') {
            $fpkunapproved->generateajax();
        }
        $data['fpkunapproved'] = array(
            'title' => 'Final Penilaian Karyawan Perlu Persetujuan',
            'count' => $query['fpkCount']->num_rows(),
            'generatetable' => $fpkunapproved->generatetable('table-fpk-unapproved', false),
            'jquery' => $fpkunapproved->jquery(1, 'table-fpk-unapproved', false),
        );
        /*need approval*/

        $userlogin = trim($this->session->userdata('nik'));
        if ($approver) {
            $query = array(
                'investigationReportTable' => $this->m_sberitaacara->q_transaction_txt_where(' AND status NOT IN ( \'P\',\'A\')  '),
                'investigationReportCount' => $this->m_sberitaacara->q_transaction_read_where(' AND status NOT IN ( \'P\',\'A\')  '),
                'warningLetterTable' => $this->m_skperingatan->q_transaction_txt_where(' AND status NOT IN ( \'P\')  '),
                'warningLetterCount' => $this->m_skperingatan->q_transaction_read_where(' AND status NOT IN ( \'P\')  '),
                'konditeTable' => $this->m_pk->q_transaction_txt_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'konditeCount' => $this->m_pk->q_transaction_read_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
            );
        } else {
            $query = array(
                'investigationReportTable' => $this->m_sberitaacara->q_transaction_txt_where(' AND status NOT IN ( \'P\',\'A\') AND ( nik = \''.$userlogin.'\' OR superiors ILIKE \'%' . $userlogin . '%\' OR witness ILIKE \'%' . $userlogin . '%\' )  '),
                'investigationReportCount' => $this->m_sberitaacara->q_transaction_read_where(' AND status NOT IN ( \'P\',\'A\') AND ( nik = \''.$userlogin.'\' OR superiors ILIKE \'%' . $userlogin . '%\' OR witness ILIKE \'%' . $userlogin . '%\' )  '),
                'warningLetterTable' => $this->m_skperingatan->q_transaction_txt_where(' AND status NOT IN ( \'P\') AND ( nik = \''.$userlogin.'\' OR superiors ILIKE \'%' . $userlogin . '%\' ) '),
                'warningLetterCount' => $this->m_skperingatan->q_transaction_read_where(' AND status NOT IN ( \'P\') AND ( nik = \''.$userlogin.'\' OR superiors ILIKE \'%' . $userlogin . '%\' ) '),
                'konditeTable' => $this->m_pk->q_transaction_txt_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'konditeCount' => $this->m_pk->q_transaction_read_where_kondite(' AND status IN (\'A\') AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),            
            );
        }
        $investigationReportTable = $this->datatablessp->datatable('table-investigation-report', 'table table-striped table-bordered table-hover dataTable-SSP', true)
            ->columns('docno, nik, docdate, status, laporan, lokasi, peringatan, tindakan, subjek, nmlengkap, dept_name, to_dept_name, superiors, witness, witness_name, status_name, accident_name, format_docdate')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/sberitaacara/actionpopup/$1') . '\' class=\' btn btn-sm btn-info pull-right actionpopup \' >Aksi</a>', ' nik, docno', true)
            ->querystring($query['investigationReportTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen.', 'docno', true, true, true, array('docno', 'action'))
            ->header('NIK.', 'nik', true, true, true, array('nik'))
            ->header('Nama Karyawan', 'nmlengkap', true, true, true)
            ->header('Departemen', 'dept_name', true, true, true)
            ->header('Tanggal', 'docdate', true, true, true, array('format_docdate'))
            ->header('Saksi', 'witness_name', true, true, true)
            ->header('Keterangan', 'accident_name', true, true, true)
            ->header('Status', 'status_name', true, true, true);
        if ($this->input->post('tableid') == 'table-investigation-report') {
            $investigationReportTable->generateajax();
        }
        $data['investigationReportTable'] = array(
            'title' => ucwords(strtolower('Daftar berita acara perlu persetujuan')),
            'count' => $query['investigationReportCount']->num_rows(),
            'generatetable' => $investigationReportTable->generatetable('table-investigation-report', false),
            'jquery' => $investigationReportTable->jquery(1, 'table-investigation-report', false),
            'linkmenu' => site_url('trans/sberitaacara'),
        );
        $warningLetterTable = $this->datatablessp->datatable('table-warning-letter', 'table table-striped table-bordered table-hover dataTable-SSP', true)
            ->columns('format_docdate, format_periode, docno, nik, docref, description, dept_name, superiors, docname, status_name, nmlengkap')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('trans/skperingatan/actionpopup/$1') . '\' class=\' btn btn-sm btn-info pull-right actionpopup \' >Aksi</a>', ' nik, docno', true)
            ->querystring($query['warningLetterTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen.', 'docno', true, true, true, array('docno', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('NIK.', 'nik', true, true, true, array('nik'))
            ->header('Nama Karyawan', 'nmlengkap', true, true, true)
            ->header('Departemen', 'dept_name', true, true, true)
            ->header('Tindakan', 'docname', true, true, true)
            ->header('Periode', 'format_periode', true, true, true, array('format_periode'))
            ->header('Referensi', 'docref', true, true, true)
            ->header('Status', 'status_name', true, true, true);
        if ($this->input->post('tableid') == 'table-warning-letter') {
            $warningLetterTable->generateajax();
        }
        $data['warningLetterTable'] = array(
            'title' => ucwords(strtolower('Daftar surat peringatan perlu persetujuan')),
            'count' => $query['warningLetterCount']->num_rows(),
            'generatetable' => $warningLetterTable->generatetable('table-warning-letter', false),
            'jquery' => $warningLetterTable->jquery(1, 'table-warning-letter', false),
            'linkmenu' => site_url('trans/skperingatan'),
        );

        $konditeunapproved = $this->datatablessp->datatable('table-kondite-unapproved', 'table table-striped table-bordered table-hover', true)
            ->columns('nik, status, nmlengkap, bagian, periode, nodok')
            ->addcolumn('no', 'no')
            ->addcolumn('dummy', '')
            ->addcolumn('action', '<a href=\'javascript:void(0)\' data-href=\'' . site_url('pk/pk/actionpopupkondite/$1') . '\' class=\' btn btn-sm btn-success pull-right actionpopup \' >Persetujuan</a>', 'nodok', true)
            ->querystring($query['konditeTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true, array('nodok', (($superiors === TRUE or $approver === TRUE) ? 'action' : 'dummy')))
            ->header('Periode', 'periode', true, true, true)
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Departmen', 'bagian', true, true, true);
        if ($this->input->post('tableid') == 'table-kondite-unapproved') {
            $konditeunapproved->generateajax();
        }
        $data['konditeunapproved'] = array(
            'title' => 'Penilaian Kondite Karyawan Perlu Persetujuan',
            'count' => $query['konditeCount']->num_rows(),
            'generatetable' => $konditeunapproved->generatetable('table-kondite-unapproved', false),
            'jquery' => $konditeunapproved->jquery(1, 'table-kondite-unapproved', false),
        );

//        $data['isUserhr'] = ($data['rowakses'] > 0 ? TRUE : FALSE );
        $data['isUserhr'] = FALSE;
        $data['dtlbroadcast'] = $this->m_modular->q_broadcast_dashboard()->row_array();
        // data pk
        $nikuser = $this->session->userdata("nik") ? $this->session->userdata("nik") : 	'0321.438';
        var_dump($nikuser);
        // $parampk = "AND c.nik_atasn = '$nikuser' or c.nik_atasan2 = '$nikuser'";
        // $data["list_pk"] = $this->m_pk->q_remind_pk($parampk)->result();
        $this->template->display('dashboard/dashboard/index', $data);
    }

    function userosin()
    {
        $data['title'] = "Data User Osin";
        $data['nama'] = strtoupper($this->session->userdata('username'));
        $data['userosin'] = $this->m_user->semua()->result();
        $data['progmodul'] = $this->m_user->list_modulprg()->result();
        $data['usermodul'] = $this->m_user->list_modulusr()->result();
        $data['listmodul'] = $this->m_user->list_modul()->result();
        $data['list_peg'] = $this->m_hrd->q_listpeg()->result();
        $data['gudang'] = $this->m_geografis->q_gudang()->result();
        $data['wilayah'] = $this->m_geografis->q_wilayah()->result();
        $data['divisi'] = $this->m_user->divisi()->result();
        if ($this->uri->segment(4) == "delete_success")
            $data['message'] = "<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if ($this->uri->segment(4) == "add_success")
            $data['message'] = "<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else if ($this->uri->segment(4) == "update_success")
            $data['message'] = "<div class='alert alert-success'>Data Berhasil diupdate</div>";
        else if ($this->uri->segment(4) == "data_sama")
            $data['message'] = "<div class='alert alert-danger'>Data Sudah Ada</div>";
        else if ($this->uri->segment(4) == "pwd_beda")
            $data['message'] = "<div class='alert alert-danger'>Password Harus Sama</div>";
        else if ($this->uri->segment(4) == "danger")
            $data['message'] = "<div class='alert alert-danger'>Terjadi kesalahan saat input</div>";
        else
            $data['message'] = '';
        $this->template->display('dashboard/userosin/index', $data);
    }

    //input user baru
    function add_user()
    {
        $userid = strtoupper($this->input->post('userid'));
        $usersname = $this->input->post('namauser');
        $nip = $this->input->post('nip');
        $userlname = $this->input->post('userpjg');
        $password1 = $this->input->post('passwordweb');
        $password2 = $this->input->post('passwordweb2');
        $gudang = $this->input->post('gudang');
        $divisi = $this->input->post('divisi');
        $kunci = $this->input->post('kunci');
        $timelock = $this->input->post('end_date');
        $leveluser = $this->input->post('leveluser');
        $wilayah = $this->input->post('wilayah');

        $cek = $this->m_user->cekUser($userid);
        if ($cek->num_rows() > 0) {
            redirect('dashboard/userosin/index/data_sama');
        } else {
            if ($password1 <> $password2) {
                redirect('dashboard/userosin/index/pwd_beda');
            } else {
                $info = array(
                    'branch' => 'SBYNSA',
                    'userid' => trim($userid),
                    'usersname' => strtoupper($usersname),
                    'nip' => $nip,
                    'userlname' => strtoupper($userlname),
                    'passwordweb' => md5($password1),
                    'location_id' => $gudang,
                    'groupuser' => $divisi,
                    'divisi' => $divisi,
                    'hold_id' => strtoupper($kunci),
                    'level_id' => $leveluser,
                    'custarea' => $wilayah,
                    'inputby' => $this->session->userdata('username'),
                    'timelock' => $timelock,
                    'inputdate' => date("Y-m-d H:i:s"),
                    'image' => 'admin.jpg');
                if ($userid <> null) {
                    $this->m_user->simpan($info);
                } else {
                    redirect('dashboard/userosin/index/danger');
                }
                //simpan modul
                $listmdl = $this->m_user->list_modulprg()->result();
                foreach ($listmdl as $mdl) {
                    $namamdl = trim($mdl->mdlprg);
                    $cekmdl = $this->input->post($namamdl);
                    if ($cekmdl == 'Y') {
                        $infomdl = array(
                            'branch' => 'SBYNSA',
                            'userid' => $userid,
                            'mdlprg' => $mdl->mdlprg,
                            'modul' => $mdl->modul,
                            'link' => $mdl->LINK
                        );
                        $this->m_user->simpan_mdl($infomdl);
                    }
                }
                //end simpan modul
            }

            redirect('dashboard/userosin/index/add_success');
        }
    }

    function edit_user()
    {
        $userid = $this->input->post('userid');
        $usersname = $this->input->post('namauser');
        $nip = $this->input->post('nip');
        $userlname = $this->input->post('userpjg');
        $passwordbaru = $this->input->post('passwordweb');
        $passwordasli = $this->input->post('passwordwebasli');
        if ($passwordasli == $passwordbaru) {
            $password = $passwordasli;
        } else {
            $password = md5($passwordbaru);
        }
        $gudang = $this->input->post('gudang');
        $divisi = $this->input->post('divisi');
        $kunci = $this->input->post('kunci');
        $timelock = $this->input->post('end_date');
        $leveluser = $this->input->post('leveluser');
        $wilayah = $this->input->post('wilayah');
        if ($password1 <> $password2) {
            redirect('dashboard/userosin/index/pwd_beda');
        } else {
            $info = array(
                'branch' => 'SBYNSA',
                'userid' => strtoupper($userid),
                'usersname' => strtoupper($usersname),
                'userlname' => strtoupper($userlname),
                'passwordweb' => $password,
                'location_id' => $gudang,
                'groupuser' => $divisi,
                'divisi' => $divisi,
                'hold_id' => strtoupper($kunci),
                'timelock' => $timelock,
                'level_id' => $leveluser,
                'custarea' => $wilayah,
            );
            $this->m_user->update($userid, $info);
            $this->m_user->hapus_mdl(trim($userid));
            $listmdl = $this->m_user->list_modulprg()->result();
            foreach ($listmdl as $mdl) {
                $namamdl = trim($mdl->mdlprg);
                $cekmdl = $this->input->post($namamdl);
                if ($cekmdl == 'Y') {
                    $cekmodul = $this->m_user->cek_modul($userid, $cekmdl);

                    $infomdl = array(
                        'branch' => 'SBYNSA',
                        'userid' => $userid,
                        'mdlprg' => $mdl->mdlprg,
                        'modul' => $mdl->modul,
                        'link' => $mdl->LINK
                    );
                    if ($cekmodul->num_rows() > 0) {
                        $this->m_user->update_mdl($userid, $infomdl);
                    } else {
                        $this->m_user->simpan_mdl($infomdl);
                    }
                }
            }
            redirect('dashboard/userosin/index/add_success');
        }
    }

    function hapus_user($kode)
    {
        $level = $this->session->userdata('level');
        if ($level <> 'A') {
            $data['message'] = 'Level Anda di tolak';
            redirect('dashboard/userosin', $data);
        } else {
            $data['message'] = 'Data Berhasil Di Hapus';
            $this->m_user->hapus($kode);
            redirect('dashboard/userosin', $data);
        }
    }

    function _set_rules()
    {
        $this->form_validation->set_rules('user', 'username', 'required|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>", "</div>");
    }

    function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        redirect('web');
    }

    public function actionpopup($param)
    {
        $this->load->model(array('master/M_ApprovalRule', 'trans/m_absensi'));
        $this->load->model(array('trans/m_cuti_karyawan'));
        $json = json_decode(
            hex2bin($param)
        );
        if ($this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'SPS\' ')) {
            $transaction = $this->m_absensi->q_transready_read_where(' AND statuskepegawaian<>\'KO\' AND ketsts = \'TIDAK MASUK KERJA\' AND nik = \'' . $json->nik . '\' AND tgl = \'' . $json->tgl . '\' ')->row();
            header('Content-Type: application/json');
            echo json_encode(array(
                'cancreate' => TRUE,
                'next' => array(
                    'urlcuti' => site_url('trans/cuti_karyawan/input/' . $json->nik),
                    'urlijin' => site_url('trans/ijin_karyawan/proses_input/' . $json->nik),
                    'urlkoreksi' => site_url('trans/absensi/lihat_koreksi_kar/' . $transaction->nik . '/' . $transaction->tgl . '/' . $transaction->tgl),
                    'urlschedule' => site_url('trans/absensi/schedule'),
                ),
                'data' => $transaction,
            ));
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Anda tidak memiliki akses'
            ));
        }

    }

    function generateMonthlyDates($startDate, $endDate) {
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        $currentDate = new DateTime($startDate->format('Ym01'));

        $result = array();

        while ($currentDate <= $endDate) {
            $result[] = $currentDate->format('Ymd');
            $currentDate->modify('+1 month');
        }

        return $result;
    }

    public function actionapproval($param = null)
    {
        $this->load->model(array('master/M_ApprovalRule','trans/m_sberitaacara'));
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_Dashboard','trans/M_Employee'));
        $documentData = $this->M_Dashboard->document_list(' AND status IN(\'A\',\'B\') AND docno = \''.$json->docno.'\' ')->row();
        $employeeData = $this->M_Employee->q_mst_read_where(' AND id = \''.trim($documentData->nik).'\' ')->row();
        $dataAction = $this->m_sberitaacara->q_list_master_tindakan()->result_array();
        $superuser = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'SPS\' AND groupid = \'SU\' ');
        $userLogin = trim($this->session->userdata('nik'));
        if (count($documentData) > 0){
            $contentPage = (strtoupper($documentData->document_type) == 'BA' ? 'dashboard/dashboard/modals/v_approve_problem' : 'dashboard/dashboard/modals/v_approve');
//            switch (strtoupper($documentData->document_type))
            if (strtoupper($documentData->document_type) == 'BA'){
                $userhr = $this->M_ApprovalRule->q_transaction_approver(' AND groupid = \''.strtoupper($documentData->document_type).'\' ');
                $superiorArr = explode(".",$employeeData->atasan);
                if ($documentData->status == 'A' AND (in_array(trim($this->session->userdata('nik')),$superiorArr) OR $superuser)){
                    $info = [
                        'docnotmp' => $documentData->docno,
                        'status' => 'AP',
                        'approveby' => trim($this->session->userdata('nik')),
                        'approvedate' => date('Y-m-d H:i:s')
                    ];
                    $this->db->where('docno', $documentData->docno);
                    if($this->db->update('sc_trx.berita_acara', $info)) {
                        $param = " AND COALESCE(docno, '') = '$userLogin' ";
                        $data = array(
                            'modalTitle' => 'PERSETUJUAN DOKUMEN BERITA ACARA OLEH ATASAN',
                            'modalSize' => 'modal-md',
                            'default' => $documentData,
                            'decisionUrl' => site_url('dashboard/iscanmakedecision/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                            'content' => $contentPage,
                            'list_tindakan' => $this->m_sberitaacara->q_list_master_tindakan()->result_array(),
                            'list_kejadian' => $this->m_sberitaacara->q_list_master_kejadian()->result_array(),
                            'clearTemporaryUrl' => site_url('dashboard/clearEntryDocumentCaseReport/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                        );
                        $data['type'] = 'APRA';
                        $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                    }
                }else if ($documentData->status == 'B' AND $userhr){
                    $info = [
                        'docnotmp' => $documentData->docno,
                        'status' => 'BP',
                        'hrd_approveby' => trim($this->session->userdata('nik')),
                        'hrd_approvedate' => date('Y-m-d H:i:s')
                    ];
                    $this->db->where('docno', $documentData->docno);
                    if($this->db->update('sc_trx.berita_acara', $info)) {
                        $param = " AND COALESCE(docno, '') = '$userLogin' ";
                        $data = array(
                            'modalTitle' => 'PERSETUJUAN DOKUMEN BERITA ACARA OLEH HRD',
                            'modalSize' => 'modal-md',
                            'default' => $documentData,
                            'decisionUrl' => site_url('dashboard/iscanmakedecision/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                            'content' => $contentPage,
                            'list_tindakan' => $this->m_sberitaacara->q_list_master_tindakan()->result_array(),
                            'list_kejadian' => $this->m_sberitaacara->q_list_master_kejadian()->result_array(),
                            'clearTemporaryUrl' => site_url('dashboard/clearEntryDocumentCaseReport/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                        );
                        $data['type'] = 'APRB';
                        $data['dtl'] = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                    }
                }else{
                    $data = array(
                        'modalTitle' => 'PERSETUJUAN DOKUMEN',
                        'modalSize' => 'modal-md',
                        'errorMessage' => 'Anda tidak memiliki akses',
                        'content' => 'dashboard/dashboard/modals/v_blocked',
                    );
                }
            }else{
                if ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
                    $data = array(
                        'modalTitle' => 'PERSETUJUAN DOKUMEN OLEH HRD',
                        'modalSize' => 'modal-md',
                        'default' => $documentData,
                        'decisionUrl' => site_url('dashboard/iscanmakedecision/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                        'content' => $contentPage,
                        'list_tindakan' => $dataAction,
                        'clearTemporaryUrl' => site_url('dashboard/clearEntryDocumentCaseReport/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                    );
                }else{
                    $superiorArr = explode(".",$employeeData->atasan);
                    if (in_array(trim($this->session->userdata('nik')),$superiorArr)){
                        $data = array(
                            'modalTitle' => 'PERSETUJUAN DOKUMEN OLEH ATASAN',
                            'modalSize' => 'modal-md',
                            'default' => $documentData,
                            'decisionUrl' => site_url('dashboard/iscanmakedecision/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                            'content' => $contentPage,
                            'list_tindakan' => $dataAction,
                            'clearTemporaryUrl' => site_url('dashboard/clearEntryDocumentCaseReport/'.bin2hex(json_encode(array('docno'=>$documentData->docno)))),
                        );
                    }else{
                        $data = array(
                            'modalTitle' => 'PERSETUJUAN DOKUMEN',
                            'modalSize' => 'modal-md',
                            'errorMessage' => 'Anda tidak memiliki akses',
                            'content' => 'dashboard/dashboard/modals/v_blocked',
                        );
                    }
                }
            }
        }else{
            $data = array(
                'modalTitle' => 'Persetujuan dokumen',
                'modalSize' => 'modal-md',
                'errorMessage' => 'Data tidak ditemukan',
                'content' => 'dashboard/dashboard/modals/v_blocked',
            );
        }
        $this->load->view($data['content'],$data);

    }

    public function iscanmakedecision($param)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('dashboard/M_Dashboard','master/M_ApprovalRule','trans/m_sberitaacara'));
        $postData = json_decode(file_get_contents('php://input'),true);
        $documentData = $this->M_Dashboard->document_list(' AND status IN (\'A\',\'B\',\'BP\') AND docno = \''.$json->docno.'\' ')->row();
        $isHaveAccess = $this->m_akses->list_aksesperdepcuti()->num_rows() > 0 or TRIM($this->m_akses->q_user_check()->row()->level_akses) == 'A';
        $superiors = $this->m_akses->superiors_access()->num_rows() > 0;
        $approver = $this->M_ApprovalRule->q_transaction_approver(' AND departmentid =\'SPS\' AND groupid = \''.$documentData->document_type.'\' ');
        header('Content-Type: application/json');
        $this->db->trans_start();
        if (count($documentData) > 0){
            if ($isHaveAccess or $superiors or $approver){
                switch (strtoupper($postData['action'])){
                    case "APPROVE":
                        $reason = $postData['reason'];
                        if ($documentData->document_type == 'BA'){
                            $nik = trim($this->session->userdata('nik'));
                            $param = " AND COALESCE(docno, '') = '$nik'";
                            $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
                            if(trim($postData['typeApproval']) == "APRA") {
                                $info = array(
                                    'peringatan' => trim($postData['needReminder']),
                                    'tindakan' => NULL,
                                    'tindaklanjut' => NULL,
                                    'status' => "B"
                                );
                            } else if(trim($postData['typeApproval']) == "APRB") {
                                $info = array(
                                    'peringatan' => trim($postData['needReminder']),
                                    'tindakan' => NULL,
                                    'tindaklanjut' => NULL,
                                    'status' => "P"
                                );
                            }
                            if($info['peringatan'] == 'y') {
                                $info['tindakan'] = trim($postData['documentAction']);
                            } else if($info['peringatan'] == 'n') {
                                $info['tindaklanjut'] = strtoupper(trim($postData['followUp']));
                            }
                            $this->db->where('docno', trim($dtl->docno));
                            if($this->db->update('sc_tmp.berita_acara', $info)) {
                                $this->db->trans_complete();
                                http_response_code(200);
                                echo json_encode(array(
                                    'data' => array(),
                                    'statusText' => 'Persetujuan Dokumen',
                                    'message' => 'Dokumen '.$documentData->document_name.' berhasil disetujui',
                                ));
                            }else{
                                http_response_code(404);
                                echo json_encode(array(
                                    'data' => array(),
                                    'message' => 'Gagal disetujui'
                                ));
                            }
                        }else{
                            if ($documentData->document_type == 'LB'){
                                $this->load->model(array('trans/m_lembur'));
                                $approver = $this->m_lembur->checkIsCanApprove($documentData->docno);
                                $superUser = TRIM($this->m_akses->q_user_check()->row()->level_akses) == 'A';
                                $approver = $this->m_lembur->checkIsCanApprove($documentData->docno);
                                $userhr = $this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'LB\' ');
                                if ($superUser OR $approver OR $userhr){
                                    if($this->M_Dashboard->update_status_document_list($documentData->docno,$documentData->document_type,'P',$reason)){
                                        $this->db->trans_complete();
                                        http_response_code(200);
                                        echo json_encode(array(
                                            'data' => array(),
                                            'statusText' => 'Persetujuan Dokumen',
                                            'message' => 'Dokumen '.$documentData->document_name.' berhasil disetujui',
                                        ));
                                    }else{
                                        http_response_code(404);
                                        echo json_encode(array(
                                            'data' => array(),
                                            'message' => 'Gagal disetujui'
                                        ));
                                    }
                                }else{
                                    http_response_code(403);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'message' => 'Anda tidak memiliki akses'
                                    ));
                                }
                            }else{
                                if($this->M_Dashboard->update_status_document_list($documentData->docno,$documentData->document_type,'P',$reason)){
                                    $this->db->trans_complete();
                                    http_response_code(200);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'statusText' => 'Persetujuan Dokumen',
                                        'message' => 'Dokumen '.$documentData->document_name.' berhasil disetujui',
                                    ));
                                }else{
                                    http_response_code(404);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'message' => 'Gagal disetujui'
                                    ));
                                }
                            }

                        }
                        break;
                    case "CANCEL":
                        $reason = $postData['reason'];
                        if ($documentData->document_type == 'BA'){
                            $nik = trim($this->session->userdata('nik'));
                            $param = " AND COALESCE(docno, '') = '$nik'";
                            $dtl = $this->m_sberitaacara->read_tmpberitaacara($param)->row();
//                            var_dump($postData);die();
                            if(trim($postData['typeApproval']) == "APRA") {
                                $info = array(
                                    'peringatan' => trim($postData['needReminder']),
                                    'tindakan' => NULL,
                                    'tindaklanjut' => NULL,
                                    'status' => "X",
                                    'approveby' => NULL,
                                    'approvedate' => NULL,
                                    'cancelby' => $nik,
                                    'canceldate' => date('Y-m-d H:i:s')
                                );
                            } else if(trim($postData['typeApproval']) == "APRB") {
                                $info = array(
                                    'peringatan' => trim($postData['needReminder']),
                                    'tindakan' => NULL,
                                    'tindaklanjut' => NULL,
                                    'status' => "X",
                                    'hrd_approveby' => NULL,
                                    'hrd_approvedate' => NULL,
                                    'cancelby' => $nik,
                                    'canceldate' => date('Y-m-d H:i:s')
                                );
                            }
                            if($info['peringatan'] == 'y') {
                                $info['tindakan'] = trim($postData['documentAction']);
                            } else if($info['peringatan'] == 'n') {
                                $info['tindaklanjut'] = strtoupper(trim($postData['followUp']));
                            }
                            $this->db->where('docno', trim($dtl->docno));
                            if($this->db->update('sc_tmp.berita_acara', $info)) {
                                $this->db->trans_complete();
                                http_response_code(200);
                                echo json_encode(array(
                                    'data' => array(),
                                    'statusText' => 'Persetujuan Dokumen',
                                    'message' => 'Dokumen '.$documentData->document_name.' berhasil ditolak',
                                ));
                            }else{
                                http_response_code(404);
                                echo json_encode(array(
                                    'data' => array(),
                                    'message' => 'Gagal ditolak'
                                ));
                            }
                        }else{
                            if ($documentData->document_type == 'LB'){
                                $this->load->model(array('trans/m_lembur'));
                                $approver = $this->m_lembur->checkIsCanApprove($documentData->docno);
                                $superUser = TRIM($this->m_akses->q_user_check()->row()->level_akses) == 'A';
                                $approver = $this->m_lembur->checkIsCanApprove($documentData->docno);
                                $userhr = $this->M_ApprovalRule->q_transaction_approver(' AND groupid = \'LB\' ');
                                if ($superUser OR $approver OR $userhr){
                                    if($this->M_Dashboard->update_status_document_list($documentData->docno,$documentData->document_type,'C',$reason)){
                                        $this->db->trans_complete();
                                        http_response_code(200);
                                        echo json_encode(array(
                                            'data' => array(),
                                            'statusText' => 'Persetujuan Dokumen',
                                            'message' => 'Dokumen '.$documentData->document_name.' berhasil dibatalkan',
                                        ));
                                    }else{
                                        http_response_code(404);
                                        echo json_encode(array(
                                            'data' => array(),
                                            'message' => 'Gagal dibatalkan'
                                        ));
                                    }
                                }else{
                                    http_response_code(403);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'message' => 'Anda tidak memiliki akses'
                                    ));
                                }
                            }else{
                                if($this->M_Dashboard->update_status_document_list($documentData->docno,$documentData->document_type,'C',$reason)){
                                    $this->db->trans_complete();
                                    http_response_code(200);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'statusText' => 'Persetujuan Dokumen',
                                        'message' => 'Dokumen '.$documentData->document_name.' berhasil dibatalkan',
                                    ));
                                }else{
                                    http_response_code(404);
                                    echo json_encode(array(
                                        'data' => array(),
                                        'message' => 'Gagal dibatalkan'
                                    ));
                                }
                            }

                        }
                        break;
                }
            }else{
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Anda tidak memiliki akses'
                ));
            }
        }else{
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Dokumen tidak ditemukan'
            ));
        }
    }
    public function actiondetail($param)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('dashboard/M_Dashboard','master/M_ApprovalRule'));
        $this->load->library(array('Fiky_encryption'));
        $documentData = $this->M_Dashboard->document_list(' AND docno = \''.$json->docno.'\' ')->row();
        header('Content-Type: application/json');

        if (count($documentData) > 0){
            //var_dump(strtoupper($documentData->document_type));die();
            switch (strtoupper($documentData->document_type)){
                case "BA":
                    http_response_code(200);
                    echo json_encode(array(
                        'next' => site_url('trans/sberitaacara/detail/?enc_docno='.$this->fiky_encryption->enkript(trim($documentData->docno))),
                    ));
                    break;
                case "CT":
                    http_response_code(200);

                    echo json_encode(array(
                        'next' => site_url('trans/cuti_karyawan/detail/'.bin2hex($this->encrypt->encode(trim($documentData->docno)))),
                    ));
                    break;
                case "PA":
                    http_response_code(200);
                    echo json_encode(array(
                        'next' => site_url('trans/ijin_karyawan/detail/'.bin2hex($this->encrypt->encode(trim($documentData->docno)))),
                    ));
                    break;
                case "IK":
                    http_response_code(200);
                    echo json_encode(array(
                        'next' => site_url('trans/ijin_karyawan/detail/'.bin2hex($this->encrypt->encode(trim($documentData->docno)))),
                    ));
                    break;
                case "DT":
                    http_response_code(200);
                    echo json_encode(array(
                        'next' => site_url('trans/ijin_karyawan/detail/'.bin2hex($this->encrypt->encode(trim($documentData->docno)))),
                    ));
                    break;
                case "DN":
                    http_response_code(200);
                    echo json_encode(array(
                        'next' => site_url("trans/dinas/detaildinas/".bin2hex(json_encode(array('nik' => trim($documentData->nik), 'nodok' => trim($documentData->docno), )))),
                    ));
                    break;
                case "LB":
                    http_response_code(200);
                    echo json_encode(array(
                        'next' => site_url("trans/lembur/detail/".trim($documentData->docno)),
                    ));
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Jenis dokumen tidak terdaftar'
                    ));
                    break;
            }

        }else{
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Dokumen tidak ditemukan'
            ));
        }

    }
    public function seriesData()
    {
        $this->load->helper('my');
        $this->load->model(array('trans/M_Employee', 'trans/M_Stspeg', 'dashboard/M_Dashboard', 'pk/m_pk'));
        $this->M_Dashboard->recalculateConditeeUser();
        $userid = trim($this->session->userdata('nik'));
        $employeeData = $this->M_Employee->q_mst_read_where(' AND nik = \''.$userid.'\' ')->row();
        $currentDate = new DateTime();
        $startDate = clone $currentDate;
        $startDate = $currentDate->modify('0 months')->format('Ym01');
        $startDateFormat = monthYear(date('Y-m', strtotime($startDate)));
        $finishDate = clone $currentDate;
        $finishDate = $currentDate->modify('-11 months')->format('Ym01');
        $finishDateFormat = monthYear(date('Y-m', strtotime($finishDate)));
        $conditee['series'] = array();
        $conditee['drilldown'] = array();
        $kpi['series'] = array();
        $kpi['drilldown'] = array();
//                var_dump($jsonData->conditee->series);die();
//                $periodMonth = $this->generateMonthlyDates($finishDate,$startDate);
        $processedMonths = array();
        foreach ($this->generateMonthlyDates($finishDate, $startDate) as $index => $generateMonthlyDate) {
            $currentMonth = substr($generateMonthlyDate, 0, 6);
            // Check if the month has already been processed
            if (!in_array($currentMonth, $processedMonths)) {
                $processedMonths[] = $currentMonth; // Mark the month as processed
                // Check if the current month is already in $conditee
                $existingMonthIndex = array_search($currentMonth, array_column($conditee, 'name'));
                // If the month is not in $conditee, add a new entry
                if ($existingMonthIndex === false) {
                    $itemFound = false;
                    foreach ($this->m_pk->q_list_kpi_report(' AND trim(nik) = \'' . $employeeData->nik . '\' ')->result() as $indexKpi => $itemKpi) {
                        if ($currentMonth === trim($itemKpi->periode)) {
                            array_push($kpi['series'], array(
                                'name' => date('M-y', strtotime($generateMonthlyDate)),
                                'y' => (float)$itemKpi->kpi_point,
                                'drilldown' => null,
                            ));
                            $itemFound = true;
                            break; // No need to continue checking other items
                        }
                    }

                    foreach ($this->m_pk->q_list_kondite_report(' AND nik = \'' . $employeeData->nik . '\' ')->result() as $indexConditee => $itemConditee) {
                        if ($currentMonth === $itemConditee->periode) {
                            array_push($conditee['series'], array(
                                'name' => date('M-y', strtotime($generateMonthlyDate)),
                                'y' => (float)$itemConditee->f_score_k,
                                'drilldown' => date('M-y', strtotime($generateMonthlyDate)),
                            ));
                            array_push($conditee['drilldown'],array(
                                'name' => date('M-y', strtotime($generateMonthlyDate)),
                                'id' => date('M-y', strtotime($generateMonthlyDate)),
                                'data' => array(
                                    array('Alpha',(int)$itemConditee->ttlvalueal),
                                    array('Ijin Pribadi',(int)$itemConditee->ttlvalueip),
                                    array('Surat Dokter',(int)$itemConditee->ttlvaluesd),
                                    array('Terlambat',(int)$itemConditee->ttlvaluetl),
                                    array('Cuti',(int)$itemConditee->ttlvaluect),
                                    array('Ijin Keluar',(int)$itemConditee->ttlvalueik),
                                    array('Ijin Terlambat',(int)$itemConditee->ttlvalueitl),
                                    array('Ijin Pulang Awal',(int)$itemConditee->ttlvalueipa),
                                    array('SP1',(int)$itemConditee->ttlvaluesp1),
                                    array('SP2',(int)$itemConditee->ttlvaluesp2),
                                    array('SP3',(int)$itemConditee->ttlvaluesp3),
                                )
                            ));
                            $itemFound = true;
                            break; // No need to continue checking other items
                        }
                    }
                    // If the item was not found, add a default entry
                    if (!$itemFound) {
                        array_push($kpi['series'], array(
                            'name' => date('M-y', strtotime($generateMonthlyDate)),
                            'y' => 0,
                            'drilldown' => null,
                        ));
                        array_push($conditee['series'], array(
                            'name' => date('M-y', strtotime($generateMonthlyDate)),
                            'y' => 0,
                            'drilldown' => null,
                        ));

                    }
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'highchart' => (object)array(
                'conditee'=>(object)array(
                    'series'=>$conditee['series'],
                    'drilldown'=>$conditee['drilldown'],
                ),
                'kpi'=>(object)array(
                    'series'=>$kpi['series'],
                    'drilldown'=>$kpi['drilldown'],
                ),
            ),
        ));
    }
}
