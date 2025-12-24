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
        $this->load->model(['m_modular', 'm_geografis', 'web/m_user', 'master/m_akses', 'trans/m_stspeg', 'trans/m_report']);
        $this->load->library(['form_validation', 'template', 'Excel_Generator']);
        if (!$this->session->userdata('nik')) {
            redirect('web');
        }
        $level = $this->session->userdata('lvl');
    }

    function index()
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('ga/m_gudang','ga/m_kendaraan','ga/m_asnkendaraan'));
        $data['title'] = "Home";
        $data['rowakses'] = $this->m_akses->list_aksesperdep()->num_rows();

        if ($data['rowakses'] > 0) {
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



        /*need approval*/
        if ($this->m_akses->list_aksesperdep()->num_rows() > 0 and strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $query = array(
                'cutiTable' => $this->m_report->q_cuti_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'cutiCount' => $this->m_report->q_cuti_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'ijinTable' => $this->m_report->q_ijin_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'ijinCount' => $this->m_report->q_ijin_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'lemburTable' => $this->m_report->q_lembur_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'lemburCount' => $this->m_report->q_lembur_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'dinasTable' => $this->m_report->q_dinas_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
                'dinasCount' => $this->m_report->q_dinas_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' '),
            );

        } else {
            $query = array(
                'cutiTable' => $this->m_report->q_cuti_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'cutiCount' => $this->m_report->q_cuti_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'ijinTable' => $this->m_report->q_ijin_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'ijinCount' => $this->m_report->q_ijin_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'lemburTable' => $this->m_report->q_lembur_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'lemburCount' => $this->m_report->q_lembur_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'dinasTable' => $this->m_report->q_dinas_txt_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),
                'dinasCount' => $this->m_report->q_dinas_read_where(' AND status IN (\'A\') AND input_date = \''.date('d-m-Y').'\' AND (superiors ILIKE \'%' . TRIM($this->session->userdata('nik')) . '%\' OR nik = \'' . TRIM($this->session->userdata('nik')) . '\') '),

            );
        }
        $userlv = 'A';
        $cutiunapproved = $this->datatablessp->datatable('table-cuti-unapproved', 'table table-striped table-bordered table-hover dataTable-SSP', true)
            ->columns('nik, status, nmlengkap, bagian, input_date, keterangan, formatstatus, nodok')
            ->addcolumn('no', 'no')
            ->querystring($query['cutiTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true)
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'input_date', true, true, true)
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
            ->columns('nodok, nik, nmlengkap, bagian, tgl, tipe_ijin, formatstatus, kategori, status, superiors')
            ->addcolumn('no', 'no')
            ->querystring($query['ijinTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true)
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'tgl', true, true, true)
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
            ->querystring($query['lemburTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true)
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
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
            ->columns('nik, status, nmlengkap, bagian, tgl, nodok, tujuan')
            ->addcolumn('no', 'no')
            ->querystring($query['dinasTable'])
            ->header('No.', 'no', true, false, true)
            ->header('Dokumen', 'nodok', true, true, true)
            ->header('NIK', 'nik', true, true, true)
            ->header('Nama', 'nmlengkap', true, true, true)
            ->header('Jabatan', 'bagian', true, true, true)
            ->header('Tanggal', 'tgl', true, true, true)
            ->header('Tujuan', 'tujuan', true, true, true);
        if ($this->input->post('tableid') == 'table-dinas-unapproved') {
            $dinasunapproved->generateajax();
        }
        $data['dinasunapproved'] = array(
            'title' => 'Karyawan Dinas Perlu Persetujuan',
            'count' => $query['dinasCount']->num_rows(),
            'generatetable' => $dinasunapproved->generatetable('table-dinas-unapproved', false),
            'jquery' => $dinasunapproved->jquery(1, 'table-dinas-unapproved', false),
        );
        /*need approval*/
//        $data['isUserhr'] = ($data['rowakses'] > 0 ? TRUE : FALSE );
        $data['isUserhr'] = FALSE;
        $data['dtlbroadcast'] = $this->m_modular->q_broadcast_dashboard()->row_array();
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


}
