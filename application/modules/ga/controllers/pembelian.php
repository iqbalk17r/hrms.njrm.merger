<?php
/*
    @author : Fiky
    @modul	: Permintaan Barang Dan Permintaan Pembelian
    13-10-2017
*/
//error_reporting(0)
class Pembelian extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('m_kendaraan', 'master/m_akses', 'm_supplier', 'm_pembelian'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'fiky_encryption', 'Fiky_notification_push'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA PEMBELIAN, SILAHKAN PILIH MENU YANG ADA";
        $this->template->display('ga/pembelian/v_index', $data);
    }

    function js_viewstock_back()
    {
        $param_buff1 = trim($this->uri->segment(4));
        $param_buff2 = trim($this->uri->segment(5));
        $param_buff3 = trim($this->uri->segment(6));
        $param_buff4 = trim($this->uri->segment(7));

        if (empty($param_buff1) or $param_buff1 == '' or $param_buff1 == null) {
            $param_buff1_1 = "";
        } else {
            $param_buff1_1 = " and kdgroup='$param_buff1'";
        }

        if (empty($param_buff2) or $param_buff2 == '' or $param_buff2 == null) {
            $param_buff2_1 = "";

        } else {
            $param_buff2_1 = " and kdsubgroup='$param_buff2'";
        }

        if (empty($param_buff3) or $param_buff3 == '' or $param_buff3 == null) {
            $param_buff3_1 = "";

        } else {
            $param_buff3_1 = " and stockcode='$param_buff3'";
        }

        if (empty($param_buff4) or $param_buff4 == '' or $param_buff4 == null) {
            $param_buff4_1 = "";

        } else {
            $param_buff4_1 = " and loccode='$param_buff4'";
        }

        $param1 = $param_buff1_1 . $param_buff2_1 . $param_buff3_1 . $param_buff4_1;

        $data = $this->m_pembelian->q_stkgdw_param1($param1)->row_array();
        echo json_encode($data, JSON_PRETTY_PRINT);

    }

    function js_viewstock_name()
    {
        $param_buff1 = str_replace('%20', ' ', trim($this->uri->segment(4)));


        if (empty($param_buff1) or $param_buff1 == '' or $param_buff1 == null) {
            $param_buff1_1 = "";
        } else {
            $param_buff1_1 = " and nmbarang = '$param_buff1'";
        }


        $param1 = $param_buff1_1;

        $data = $this->m_pembelian->q_mstbarang_atk_param($param1)->row_array();
        $cek = $this->m_pembelian->q_mstbarang_atk_param($param1)->num_rows();
        ///	echo json_encode($data, JSON_PRETTY_PRINT);


        if ($cek > 0) {
            echo json_encode($data, JSON_PRETTY_PRINT);
            echo json_encode(array("statusajax" => TRUE));
        } else {
            echo json_encode(array("statusajax" => FALSE));
        }

    }

    function js_tmp_name()
    {
        $param_buff1 = strtoupper(str_replace('%20', ' ', trim($this->uri->segment(4))));


        if (empty($param_buff1) or $param_buff1 == '' or $param_buff1 == null) {
            $param_buff1_1 = "";
        } else {
            $param_buff1_1 = " and desc_barang = '$param_buff1'";
        }

        $nama = $this->session->userdata('nik');
        $param_buff_0 = " and nodok='$nama' ";
        $param1 = $param_buff_0 . $param_buff1_1;

        $data = $this->m_pembelian->q_sppb_tmp_dtl_param($param1)->row_array();
        $cek = $this->m_pembelian->q_sppb_tmp_dtl_param($param1)->num_rows();
        ///	echo json_encode($data, JSON_PRETTY_PRINT);


        if ($cek > 0) {
            echo json_encode($data, JSON_PRETTY_PRINT);
            //	echo json_encode(array("statusajax" => TRUE));
        } else {
            echo json_encode(array("statusajax" => FALSE));
        }

    }

    function js_mapping_satuan()
    {
        $param_buff1 = trim($this->uri->segment(4));
        $param_buff2 = trim($this->uri->segment(5));
        $param_buff3 = trim($this->uri->segment(6));
        $param_buff4 = trim($this->uri->segment(7));
        $param_buff5 = trim($this->uri->segment(8));

        if (empty($param_buff1) or $param_buff1 == '' or $param_buff1 == null) {
            $param_buff1_1 = "";
        } else {
            $param_buff1_1 = " and kdgroup='$param_buff1'";
        }

        if (empty($param_buff2) or $param_buff2 == '' or $param_buff2 == null) {
            $param_buff2_1 = "";

        } else {
            $param_buff2_1 = " and kdsubgroup='$param_buff2'";
        }

        if (empty($param_buff3) or $param_buff3 == '' or $param_buff3 == null) {
            $param_buff3_1 = "";

        } else {
            $param_buff3_1 = " and stockcode='$param_buff3'";
        }

        if (empty($param_buff4) or $param_buff4 == '' or $param_buff4 == null) {
            $param_buff4_1 = "";

        } else {
            $param_buff4_1 = " and satkecil='$param_buff4'";
        }
        if (empty($param_buff5) or $param_buff5 == '' or $param_buff5 == null) {
            $param_buff5_1 = "";

        } else {
            $param_buff5_1 = " and satbesar='$param_buff5'";
        }
        $param = $param_buff1_1 . $param_buff2_1 . $param_buff3_1 . $param_buff4_1 . $param_buff5_1;

        $data = $this->m_pembelian->q_mapsatuan_barang_param($param)->row_array();
        echo json_encode($data, JSON_PRETTY_PRINT);

    }

    function js_mbarang()
    {
        $param_buff1 = trim($this->uri->segment(4));
        $param_buff2 = trim($this->uri->segment(5));
        $param_buff3 = trim($this->uri->segment(6));

        if (empty($param_buff1) or $param_buff1 == '' or $param_buff1 == null) {
            $param_buff1_1 = "";
        } else {
            $param_buff1_1 = " and kdgroup='$param_buff1'";
        }

        if (empty($param_buff2) or $param_buff2 == '' or $param_buff2 == null) {
            $param_buff2_1 = "";

        } else {
            $param_buff2_1 = " and kdsubgroup='$param_buff2'";
        }

        if (empty($param_buff3) or $param_buff3 == '' or $param_buff3 == null) {
            $param_buff3_1 = "";

        } else {
            $param_buff3_1 = " and nodok='$param_buff3'";
        }

        $param = $param_buff1_1 . $param_buff2_1 . $param_buff3_1;

        $data = $this->m_pembelian->q_mstbarang_atk_param($param)->row_array();
        echo json_encode($data, JSON_PRETTY_PRINT);

    }

    function js_supplier()
    {
        $param_buff1 = trim($this->uri->segment(4));
        $param_buff2 = trim($this->uri->segment(5));
        $param_buff3 = trim($this->uri->segment(6));


        if (empty($param_buff1) or $param_buff1 == '' or $param_buff1 == null) {
            $param_buff1_1 = "";
        } else {
            $param_buff1_1 = " and kdgroupsupplier='$param_buff1'";
        }

        if (empty($param_buff2) or $param_buff2 == '' or $param_buff2 == null) {
            $param_buff2_1 = "";

        } else {
            $param_buff2_1 = " and kdsupplier='$param_buff2'";
        }

        if (empty($param_buff3) or $param_buff3 == '' or $param_buff3 == null) {
            $param_buff3_1 = "";

        } else {
            $param_buff3_1 = " and kdsubsupplier='$param_buff3'";
        }

        $param = $param_buff1_1 . $param_buff2_1 . $param_buff3_1;

        $data = $this->m_pembelian->q_msubsupplier_param($param)->row_array();
        echo json_encode($data, JSON_PRETTY_PRINT);

    }

    function form_sppb()
    {
        $data['title'] = "LIST SURAT PERMINTAAN PEMBELIAN BARANG";
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        /* CODE UNTUK VERSI*/
        $nama = trim($this->session->userdata('nik'));
        $kodemenu = 'I.G.H.4';
        $versirelease = 'I.G.H.4/ALPHA.001';
        $releasedate = date('2019-04-12 00:00:00');
        $versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
        $x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
        $data['x'] = $x['rows'];
        $data['y'] = $x['res'];
        $data['t'] = $x['xn'];
        $data['kodemenu'] = $kodemenu;
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */

        $paramerror = " and userid='$nama' and modul='TMPSPPB'";
        $dtlerror = $this->m_pembelian->q_trxerror_global($paramerror)->row_array();
        $count_err = $this->m_pembelian->q_trxerror_global($paramerror)->num_rows();
        if (isset($dtlerror['description'])) {
            $errordesc = trim($dtlerror['description']);
        } else {
            $errordesc = '';
        }
        if (isset($dtlerror['nomorakhir1'])) {
            $nomorakhir1 = trim($dtlerror['nomorakhir1']);
        } else {
            $nomorakhir1 = '';
        }
        if (isset($dtlerror['errorcode'])) {
            $errorcode = trim($dtlerror['errorcode']);
        } else {
            $errorcode = '';
        }

        if ($count_err > 0 and $errordesc <> '') {
            if ($dtlerror['errorcode'] == 0) {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message'] = "<div class='alert alert-info'>$errordesc</div>";
            }

        } else {
            if ($errorcode == '0') {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message'] = "";
            }
        }

        if ($this->uri->segment(4) == "success_input") {
            $data['message'] = "<div class='alert alert-success'>DATA QUOTATION SUKSES DISIMPAN/DIUBAH, MENUNGGU PERSETUJUAN</div>";
        }
        if ($this->uri->segment(4) == "approve_succes") {
            $data['message'] = "<div class='alert alert-success'>DATA QUOTATION BERHASIL SETUJUI</div>";
        }


        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        if (empty($thn)) {
            $tahun = date('Y');
            $bulan = date('m');
            $tgl = $bulan . $tahun;
        } else {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
        }
        switch ($bulan) {
            case '01':
                $bul = 'Januari';
                break;
            case '02':
                $bul = 'Februari';
                break;
            case '03':
                $bul = 'Maret';
                break;
            case '04':
                $bul = 'April';
                break;
            case '05':
                $bul = 'Mei';
                break;
            case '06':
                $bul = 'Juni';
                break;
            case '07':
                $bul = 'Juli';
                break;
            case '08':
                $bul = 'Agustus';
                break;
            case '09':
                $bul = 'September';
                break;
            case '10':
                $bul = 'Oktober';
                break;
            case '11':
                $bul = 'November';
                break;
            case '12':
                $bul = 'Desember';
                break;
        }

        //echo $tgl;
        $nama = trim($this->session->userdata('nik'));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        /*cek jika ada inputan edit atau input*/
        $param3_1_1 = " and nodok='$nama' and status='I'";
        $param3_1_2 = " and nodok='$nama' and status='E'";
        $param3_1_3 = " and nodok='$nama' and status='A'";
        $param3_1_4 = " and nodok='$nama' and status='H'";
        $param3_1_5 = " and nodok='$nama' and status='C'";
        $param3_1_R = " and nodok='$nama'";
        $ceksppbdtl_na = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_1)->num_rows(); //input
        $ceksppbdtl_ne = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->num_rows(); //edit
        $ceksppbdtl_napp = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_3)->num_rows(); //edit
        $ceksppbdtl_hangus = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_4)->num_rows(); //edit
        $dtledit = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_R)->row_array(); //edit row array
        //echo $coba=trim(isset($dtledit['nodoktmp']));
        $enc_nodok = bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));

        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        if ($ceksppbdtl_na > 0) { //cek inputan
            $enc_nik = bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            redirect("ga/pembelian/input_sppb/$enc_nik");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($ceksppbdtl_ne > 0) {	//cek edit
            redirect("ga/pembelian/edit_sppb/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($ceksppbdtl_napp > 0) {	//cek edit
            redirect("ga/pembelian/approval_sppb/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($ceksppbdtl_hangus > 0) {	//cek hangus
            redirect("ga/pembelian/hangus_sppb/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        }

        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();

        /* akses approve atasan */
        $ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdepcuti()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        // or $level_akses=='A'
        if (($userhr > 0)) {
            $param_list_akses = "";
        } else if (($ceknikatasan1) > 0 and $userhr == 0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/) {
            $param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama' or nik_atasan2='$nama') or nik='$nama'";

        } else if (($ceknikatasan2) > 0 and $userhr == 0 /*and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')*/) {
            $param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where  nik_atasan='$nama' or nik_atasan2='$nama') or nik='$nama'";

        } else {
            $param_list_akses = " and nik='$nama' ";
        }

        $hrdept = $this->m_akses->hrdept();
        $data['isSPVGA'] = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'C', 'subbag_dept' => $hrdept))->num_rows() > 0;

        $data['nama'] = $nama;
        $data['userhr'] = $userhr > 0;
        $data['level_akses'] = $level_akses;
        $data['ceknikatasan1'] = $ceknikatasan1;
        $data['nikatasan1'] = $nikatasan1;
        /* END APPROVE ATASAN */
        /* AKSES MENU INPUTAN */
        $paramakses = " and nik='$nama' and kodemenu='$kodemenu'";
        $data['dtlakses'] = $this->m_akses->list_aksespermenu_rev($paramakses)->row_array();
        /* */
        $tgl = explode(' - ', $this->input->post('tgl'));
        if (!empty($this->input->post('tgl')) or ($this->input->post('tgl')) <> '') {
            $tgl1 = date('Y-m-d', strtotime($tgl[0]));
            $tgl2 = date('Y-m-d', strtotime($tgl[1]));
            $paramdate = " and to_char(tgldok,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
        } else {
            $paramdate = " and to_char(tgldok,'yyyymm') = to_char(now(),'yyyymm') ";
        }
        $parameter = $param_list_akses . $paramdate;

        //$data['list_sppb']=$this->m_pembelian->q_lisppb()->result();
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_sppb'] = $this->m_pembelian->q_list_sppbparam($parameter)->result();
        $this->template->display('ga/pembelian/v_sppb', $data);

        $paramerror = " and userid='$nama'";
        $dtlerror = $this->m_pembelian->q_deltrxerror_global($paramerror);

    }


    function list_niksppb()
    {
        $data['title'] = 'DATA KARYAWAN UNTUK SURAT PERMINTAAN PEMBELIAN BARANG';
        $nama = $this->session->userdata('nik');
        /* akses approve atasan */
        $ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        // or $level_akses=='A'
        if (($userhr > 0)) {
            $param_list_akses = "";
        } else if (($ceknikatasan1) > 0 and $userhr == 0 and ($level_akses == 'B' or $level_akses == 'C' or $level_akses == 'D')) {
            $param_list_akses = "and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";

        } else if (($ceknikatasan2) > 0 and $userhr == 0 and ($level_akses == 'B' or $level_akses == 'C' or $level_akses == 'D')) {
            $param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";

        } else {
            $param_list_akses = " and nik='$nama' ";
        }

        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;
        /* END APPROVE ATASAN */


        $data['list_niksppb'] = $this->m_akses->list_karyawan_param($param_list_akses)->result();
        $this->template->display('ga/pembelian/v_list_niksppb', $data);
    }


    function input_sppb()
    {

        $nik = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();

        $branch = strtoupper(trim($dtlbranch['branch']));
        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();

        //$dtlnik=$this->m_akses->list_karyawan_index($nama)->row_array();
        $loccode = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$loccode'";
        $param_kanwil = "";
        $param_inp = " and nodok='$nama' or nik='$nik'";
        $param_inp_sc = " and nodok='$nama'";
        ///st_not_null
        /* user hr akses */
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;
        /*user hr end */

        $ceksppbmst_inp = $this->m_pembelian->q_sppb_tmp_mst_param($param_inp)->num_rows();
        $ceksppbmst_inp_sc = $this->m_pembelian->q_sppb_tmp_mst_param($param_inp_sc)->num_rows();

        if ($ceksppbmst_inp == 0) {
            $info_mst = array(
                'branch' => $branch,
                'nodok' => $nama,
                'nik' => $nik,
                'loccode' => $loccode,
                'status' => 'I',
                'keterangan' => '',
                'tgldok' => date('Y-m-d'),
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => $nama
            );
            $this->db->insert('sc_tmp.sppb_mst', $info_mst);
        }

        if ($ceksppbmst_inp_sc == 0) {
            redirect("ga/pembelian/form_sppb/inp_fail");
        }


        if ($this->uri->segment(5) == "fail_input")
            $data['message'] = "<div class='alert alert-warning'>Barang Belum ada yang di Sisipkan Atau Belum Terinput</div>";
        else if ($this->uri->segment(5) == "st_not_null")
            $data['message'] = "<div class='alert alert-warning'>Qty Barang Tidak Boleh Kosong/ Minus</div>";
        else if ($this->uri->segment(5) == "fail_fill")
            $data['message'] = "<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
        else if ($this->uri->segment(5) == "warn_onhand")
            $data['message'] = "<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
        else if ($this->uri->segment(5) == "edit_fail")
            $data['message'] = "<div class='alert alert-danger'>Gagal, Ada kesalahan data, ubah tanggal tidak diperbolehkan ketika sudah terisi detail</div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Detail Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';

        $data['title'] = ' INPUT SPPB ';
        $paramx = '';
        //$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_sppb($paramx)->result();
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_sppb_tmp_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param_inp_sc)->result();
        $data['list_sppb_tmp_dtl'] = $this->m_pembelian->q_sppb_tmp_dtl_param($param_inp_sc)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_kanwil'] = $this->m_pembelian->q_gudangwilayah($param_kanwil)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param_inp)->row_array();
        $this->template->display('ga/pembelian/v_input_niksppb', $data);

    }

    function add_map_satuan($paramsatuan)
    {
        //$query = $this->db->get_where('sc_mst.kotakab',array('kodeprov'=>$id_prov));
        //$query = $this->db->query("select * from sc_mst.kotakab where kodeprov='$id_prov' order by namakotakab");
        $paramsat = " and strtrim='$paramsatuan'";
        $query = $this->m_pembelian->q_mapsatuan_barang_param($paramsat);
        $data = "<option value=''>- Pilih Satuan -</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->satbesar . "'>" . $value->desc_satbesar . "</option>";
        }
        echo $data;
    }

    function clear_tmp_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $param3_1_2 = " and nodok='$nama'";
        $dtledit = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
        $status = trim($dtledit['status']);
        $nodoktmp = trim($dtledit['nodoktmp']);
        /* restoring status  */
        if (trim($dtledit['status']) <> 'A') {
            $info = array(
                'updatedate' => null,
                'updateby' => '',
                'approvaldate' => null,
                'approvalby' => '',
                'canceldate' => null,
                'cancelby' => '',
                'status' => 'A',

            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.sppb_mst', $info);
        }
        ////		$this->db->where('nodok',$nodoktmp);
        ////		$this->db->update('sc_trx.sppb_dtl',$info);


        /* clearing temporary  */
        $this->db->where('nodok', $nama);
        $this->db->delete('sc_tmp.sppb_mst');
        $this->db->where('nodok', $nama);
        $this->db->delete('sc_tmp.sppb_dtl');

        redirect("ga/pembelian/form_sppb/del_succes");
    }

    function clear_tmp_sppb_hangus()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        } else {
            $param3_1_2 = " and nodok='$nama'";
            $dtledit = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
            $status = trim($dtledit['status']);
            $nodoktmp = trim($dtledit['nodoktmp']);
            /* restoring status  */
            $info = array(
                'status' => 'P',
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.sppb_mst', $info);
        }
        ////		$this->db->where('nodok',$nodoktmp);
        ////		$this->db->update('sc_trx.sppb_dtl',$info);


        /* clearing temporary  */
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.sppb_mst');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.sppb_dtl');

        redirect("ga/pembelian/form_sppb/del_succes");
    }


    function cancel_tmp_sppb_dtl()
    {
        $nik = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $enc_nik = trim($this->uri->segment(4));
        $nama = $this->session->userdata('nik');
        $param3_1_2 = " and nodok='$nama'";
        $dtledit = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
        $enc_nodok = bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
        $status = trim($dtledit['status']); //inisial nodok tmp

        if (empty($nama)) {
            redirect("ga/pembelian/form_sppb");
        }
        if ($status == 'I') {
            $this->db->where('nodok', $nama);
            $this->db->delete('sc_tmp.sppb_dtl');
            redirect("ga/pembelian/input_sppb/$enc_nik/del_succes");
        } else if ($status == 'E') {
            $this->db->where('nodok', $nama);
            $this->db->delete('sc_tmp.sppb_dtl');
            redirect("ga/pembelian/edit_sppb/$enc_nodok/del_succes");
        }
    }


    function save_sppb()
    {
        $nama = $this->session->userdata('nik');
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $nik = strtoupper($this->input->post('nik'));
        $nodok = strtoupper($this->input->post('nodok'));
        $kdgroup = strtoupper($this->input->post('kdgroup'));
        $kdsubgroup = strtoupper($this->input->post('kdsubgroup'));
        $stockcode = strtoupper($this->input->post('kdbarang'));
        $loccode = strtoupper($this->input->post('loccode'));
        $desc_barang = strtoupper($this->input->post('desc_barang'));
        $fromstock = strtoupper($this->input->post('daristock'));
        $satkecil = strtoupper($this->input->post('satkecil'));
        $satminta = strtoupper($this->input->post('satminta'));
        $satminta2 = strtoupper($this->input->post('satminta2'));
        $onhand = strtoupper($this->input->post('onhand'));
        $tgldok = strtoupper(trim($this->input->post('tgldok')));
        $itemtype = strtoupper(trim($this->input->post('itemtype')));
        if ($onhand == '' or empty($onhand)) {
            $qtyonhand = 0;
        } else {
            $qtyonhand = $onhand;
        }

        $qtysppbkecil1 = strtoupper($this->input->post('qtykonversi'));
        $qtysppbminta1 = strtoupper($this->input->post('qtysppbminta'));
        if ($qtysppbkecil1 == '' or empty($qtysppbkecil1)) {
            $qtysppbkecil = 0;
        } else {
            $qtysppbkecil = $qtysppbkecil1;
        }

        if ($qtysppbminta1 == '' or empty($qtysppbminta1)) {
            $qtysppbminta = 0;
        } else {
            $qtysppbminta = $qtysppbminta1;
        }
        $onhand = strtoupper($this->input->post('onhand'));
        $keterangan = strtoupper($this->input->post('keterangan'));
        $nodoktmp = strtoupper($this->input->post('nodoktmp'));
        $id = strtoupper($this->input->post('id'));
        $inputdate = date('Y-m-d H:i:s');
        $inputby = $nama;
        $enc_nik = bin2hex($this->encrypt->encode($nik));
        $enc_nodok = bin2hex($this->encrypt->encode($nodok));
        // if(empty($nodok)){
        // redirect("ga/pembelian/form_pembelian");
        // }
        if ($type == 'INPUTTMPDTLINPUT') {

            $param_item_kembar = " and nodok='$nama' and desc_barang='$desc_barang'";
            $cek_sppb_kembar = $this->m_pembelian->q_sppb_tmp_dtl_param($param_item_kembar)->num_rows();

            if ($qtysppbminta <= 0) {
                redirect("ga/pembelian/input_sppb/$enc_nik/st_not_null");
            } else if ($cek_sppb_kembar > 0) {
                redirect("ga/pembelian/input_sppb/$enc_nik/fail_fill");
            }

            if ($fromstock == 'YES') {
                $satminta = $satminta2;
            } else {
                $satminta = $satminta;
            }

            $info_dtl = array(
                'branch' => $branch,
                'nodok' => $nama,
                'nik' => $nik,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'stockcode' => $stockcode,
                'loccode' => $loccode,
                'desc_barang' => $desc_barang,
                'qtyrefonhand' => $qtyonhand,
                'qtysppbkecil' => $qtysppbkecil,
                'qtysppbminta' => $qtysppbminta,
                'satkecil' => $satkecil,
                'satminta' => $satminta,
                'status' => 'I',
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,
                'fromstock' => $fromstock,
                'id' => 99999,
            );

            $this->db->insert('sc_tmp.sppb_dtl', $info_dtl);
            redirect("ga/pembelian/input_sppb/$enc_nik/inp_succes");


        } else if ($type == 'INPUTTMPDTLEDIT') {
            $param_item_kembar = " and nodok='$nama' and desc_barang='$desc_barang'";
            $cek_sppb_kembar = $this->m_pembelian->q_sppb_tmp_dtl_param($param_item_kembar)->num_rows();

            if ($qtysppbminta <= 0) {
                redirect("ga/pembelian/edit_sppb/$enc_nik/st_not_null");
            } else if ($cek_sppb_kembar > 0) {
                redirect("ga/pembelian/edit_sppb/$enc_nik/fail_fill");
            }

            if ($fromstock == 'YES') {
                $satminta = $satminta2;
            } else {
                $satminta = $satminta;
            }

            $info_dtl = array(
                'branch' => $branch,
                'nodok' => $nama,
                'nik' => $nik,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'stockcode' => $stockcode,
                'loccode' => $loccode,
                'desc_barang' => $desc_barang,
                'qtyrefonhand' => $qtyonhand,
                'qtysppbkecil' => $qtysppbkecil,
                'qtysppbminta' => $qtysppbminta,
                'satkecil' => $satkecil,
                'satminta' => $satminta,
                'status' => 'A',
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,
                'fromstock' => $fromstock,
                'nodoktmp' => $nodoktmp,
                'id' => 99999,
            );

            $this->db->insert('sc_tmp.sppb_dtl', $info_dtl);
            redirect("ga/pembelian/edit_sppb/$enc_nik/inp_succes");


        } else if ($type == 'EDITTMPDTLINPUT') {
            if ($qtysppbminta <= 0) {
                redirect("ga/pembelian/input_sppb/$enc_nodok/st_not_null");
            }
            $info = array(

                'desc_barang' => $desc_barang,
                'qtyrefonhand' => $qtyonhand,
                'qtysppbminta' => $qtysppbminta,
                'satminta' => $satminta,
                'status' => '',
                'keterangan' => $keterangan,
                'updatedate' => $inputdate,
                'updateby' => $inputby,

            );
            $this->db->where('nodok', $nama);
            $this->db->where('id', $id);
            $this->db->update('sc_tmp.sppb_dtl', $info);
            if ($onhand == 0) {
                redirect("ga/pembelian/input_sppb/$enc_nodok/warn_onhand");
            } else {
                redirect("ga/pembelian/input_sppb/$enc_nodok/edit_succes");
            }
        } else if ($type == 'EDITTMPDTL') {
            if ($qtysppbminta <= 0) {
                redirect("ga/pembelian/edit_sppb/$enc_nodok/st_not_null");
            } else {
                $info = array(
                    'desc_barang' => $desc_barang,
                    'qtysppbminta' => $qtysppbminta,
                    'satminta' => $satminta,
                    'status' => '',
                    'keterangan' => $keterangan,
                    'updatedate' => $inputdate,
                    'updateby' => $inputby,

                );
                $this->db->where('nodok', $nama);
                $this->db->where('id', $id);
                $this->db->update('sc_tmp.sppb_dtl', $info);
                if ($onhand == 0) {
                    redirect("ga/pembelian/edit_sppb/$enc_nodok/warn_onhand");
                } else {
                    redirect("ga/pembelian/edit_sppb/$enc_nodok/edit_succes");
                }
            }
        } else if ($type == 'EDITTMPMST') {
            $param_cek = " and nodok='$nama'";
            $ceksppbdtl = $this->m_pembelian->q_sppb_tmp_dtl_param($param_cek)->num_rows();
            if ($ceksppbdtl > 0) {
                redirect("ga/pembelian/input_sppb/$enc_nik/edit_fail");
            } else {
                $info_mst = array(
                    'loccode' => $loccode,
                    'itemtype' => $itemtype,
                    'status' => 'I',
                    'keterangan' => $keterangan,
                    'tgldok' => $tgldok,
                    'updatedate' => date('Y-m-d H:i:s'),
                    'updateby' => $nama
                );
                $this->db->where('nik', $nik);
                $this->db->where('nodok', $nodok);
                $this->db->update('sc_tmp.sppb_mst', $info_mst);
                redirect("ga/pembelian/input_sppb/$enc_nik/edit_succes");
            }
        } else if ($type == 'APPROVETMPMST') {
            $param_apv = " and nodok='$nama' and status='A'";
            $ceksppbdtl_approv = $this->m_pembelian->q_sppb_tmp_dtl_param($param_apv)->num_rows();
            if ($ceksppbdtl_approv > 0) {
                redirect("ga/pembelian/approval_sppb/$enc_nik/cant_final");
            } else {
                $info = array(
                    'status' => 'F',
                );
                $this->db->where('nik', $nik);
                $this->db->where('nodok', $nodok);
                $this->db->update('sc_tmp.sppb_mst', $info);
                redirect("ga/pembelian/form_sppb/app_succes");
            }
        } else if ($type == 'APPRDTLTRX') {
            $info = array(
                'status' => 'P',
                'qtysppbminta' => $qtysppbminta,
            );
            $this->db->where('nodok', $nama);
            $this->db->where('id', $id);
            $this->db->update('sc_tmp.sppb_dtl', $info);
            redirect("ga/pembelian/approval_sppb/$enc_nik/succ_dtlfinal");

        } else if ($type == 'REJAPPDTL') { /* REAPPROVE DETAIL DOKUMEN */
            $info = array(
                'status' => 'C',
            );
            $this->db->where('nodok', $nama);
            $this->db->where('id', $id);
            $this->db->update('sc_tmp.sppb_dtl', $info);
            redirect("ga/pembelian/approval_sppb/$enc_nik/succ_rejectdtlfinal");

        } else if ($type == 'CAPPRDTL') {  /* REAPPROVE DETAIL DOKUMEN */
            $info = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nama);
            $this->db->where('id', $id);
            $this->db->update('sc_tmp.sppb_dtl', $info);
            redirect("ga/pembelian/approval_sppb/$enc_nik/succ_dtlfinal");

        } else if ($type == 'DELETE') {
            $info = array(
                'status' => 'C',
            );
            $this->db->where('nik', $nik);
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.sppb_mst', $info);
            redirect("ga/pembelian/form_sppb/del_succes");
        } else if ($type == 'DELTRXMST') {
            $info = array(
                'status' => 'F',
            );
            $this->db->where('nik', $nik);
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_tmp.sppb_mst', $info);
            redirect("ga/pembelian/form_sppb/del_succes");
        } else if ($type == 'DELETETMPDTLINPUT') {
            $this->db->where('nodok', $nama);
            $this->db->where('id', $id);
            $this->db->delete('sc_tmp.sppb_dtl');
            redirect("ga/pembelian/input_sppb/$enc_nik/del_succes");
        } else if ($type == 'DELETETMPDTLEDIT') {
            $this->db->where('nodok', $nama);
            $this->db->where('id', $id);
            $this->db->delete('sc_tmp.sppb_dtl');
            redirect("ga/pembelian/edit_sppb/$enc_nodok/del_succes");
        } else if ($type == 'HANGUSFINAL') {
            /* FINAL SETELAH PENGHANGUSAN */
            $info = array(
                'status' => 'F',
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama
            );
            $this->db->where('nik', $nik);
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_tmp.sppb_mst', $info);
            redirect("ga/pembelian/form_sppb/inp_succes");
        } else {
            redirect("ga/pembelian/form_sppb");
        }
    }

    function final_input_sppb()
    {
        /*
         *  $dtl_push = $this->m_akses->q_lv_mkaryawan(" and nik='$nik'")->row_array();
            $paramerror=" and userid='$nama' and modul='CUTI'";
            $dtlerror=$this->m_cuti_karyawan->q_trxerror($paramerror)->row_array();
            if ($this->fiky_notification_push->onePushVapeApprovalHrms($nik,trim($dtl_push['nik_atasan']),trim($dtlerror['nomorakhir1']))){
                redirect("trans/cuti_karyawan/index/rep_succes/$nik");
            }
         * */

        $nik = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $enc_nik = trim($this->uri->segment(4));

        $nama = trim($this->session->userdata('nik'));

        if (empty($nama)) {
            redirect("ga/pembelian/form_sppb");
        }

        $param3_1 = " and nodok='$nama'";
        $param_inputby = " and inputby='$nama'";
        $param3_1_2 = " and nodok='$nama'";
        $dtledit = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1_2)->row_array(); //edit row array
        $enc_nodok = bin2hex($this->encrypt->encode(trim($dtledit['nodoktmp']))); //inisial nodok tmp
        $status = trim($dtledit['status']); //inisial nodok tmp
        $nodoktmp = trim($dtledit['nodoktmp']); //inisial nodok tmp
        $cek_tmp_sppb_dtl = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_1)->num_rows();

        if ($cek_tmp_sppb_dtl > 0 and $status == 'I') {	//finish input
            $info = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nama);
            $this->db->update('sc_tmp.sppb_mst', $info);
            $dtl = $this->m_pembelian->q_sppb_trx_mst_param_inputby($param_inputby)->row_array();
            $nodokfinal = trim($dtl['nodok']);

            $dtl_push = $this->m_akses->q_lv_mkaryawan(" and nik='$nik'")->row_array();
            $paramerror = " and userid='$nama' and modul='TMPSPPB'";
            $dtlerror = $this->m_pembelian->q_trxerror_global($paramerror)->row_array();
            if ($this->fiky_notification_push->onePushVapeApprovalHrms($nik, trim($dtl_push['nik_atasan']), trim($dtlerror['nomorakhir1']))) {
                redirect("ga/pembelian/form_sppb/final_succes/$nodokfinal");
            }


            //ECHO 'FINAL INPUT';

        } else if ($cek_tmp_sppb_dtl > 0 and $status == 'E') { //finish edit
            $info = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nama);
            $this->db->update('sc_tmp.sppb_mst', $info);
            redirect("ga/pembelian/form_sppb/edit_succes/$nodoktmp");

            //ECHO 'FINAL EDIT';
        } else if ($cek_tmp_sppb_dtl <= 0 and $status == 'E') { //finish edit
            //ECHO 'EDIT FAIL';
            redirect("ga/pembelian/edit_sppb/$enc_nodok/edit_fail");
        } else {
            //ECHO 'CONCLUSION';
            redirect("ga/pembelian/input_sppb/$enc_nik/fail_input");
        }


    }


    function detail_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        if (empty($nodok)) {
            redirect("ga/pembelian/form_pembelian");
        }
        $nama = $this->session->userdata('nik');

        $param3_1 = " and nodok='$nodok'";
        $param3_2 = " and nodok='$nodok'";
        $sppb_mst = $this->m_pembelian->q_sppb_trx_mst_param($param3_1)->row_array();
        $data['sppb_mst'] = $this->m_pembelian->q_sppb_trx_mst_param($param3_1)->row_array();
        $data['list_sppb_trx_mst'] = $this->m_pembelian->q_sppb_trx_mst_param($param3_1)->result();
        $sppb_dtl = $this->m_pembelian->q_sppb_trx_dtl_param($param3_2)->row_array();
        $data['list_sppb_trx_dtl'] = $this->m_pembelian->q_sppb_trx_dtl_param($param3_2)->result();
        $nik = trim($sppb_mst['nik']);

        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();
        $param_inp = " and nodok='$nodok'";
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $data['title'] = 'DETAIL INPUT SPPB ';
        if ($this->uri->segment(5) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(5) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(5) == "fail_fill")
            $data['message'] = "<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_trx_mst_param($param_inp)->row_array();
        $this->template->display('ga/pembelian/v_detail_sppb', $data);

    }

    function input_quotation_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $nama = $this->session->userdata('nik');

        $param3_1 = " and nodok='$nodok'";
        $param3_2 = " and nodok='$nodok'";
        $sppb_mst = $this->m_pembelian->q_sppb_trx_mst_param($param3_1)->row_array();
        $data['sppb_mst'] = $this->m_pembelian->q_sppb_trx_mst_param($param3_1)->row_array();
        $data['list_sppb_trx_mst'] = $this->m_pembelian->q_sppb_trx_mst_param($param3_1)->result();
        $sppb_dtl = $this->m_pembelian->q_sppb_trx_dtl_param($param3_2)->row_array();
        $data['list_sppb_trx_dtl'] = $this->m_pembelian->q_sppb_trx_dtl_param($param3_2)->result();
        $nik = trim($sppb_mst['nik']);

        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();
        $param_inp = " and nodok='$nodok'";
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $data['title'] = 'INPUT QUOTATION SPPB ';
        if ($this->uri->segment(5) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(5) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(5) == "fail_fill")
            $data['message'] = "<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_trx_mst_param($param_inp)->row_array();

        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $param_tmp_po = " and nodok='$nama'";
        $cek_tmp_po = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->num_rows();
        if ($cek_tmp_po == 0) {
            $info = array(
                'branch' => $branch,
                'nodok' => $nama,
                'loccode' => $kdcabang,
                'podate' => date('Y-m-d H:i:s'),
                'status' => 'I',
                'inputby' => $nama,
                'inputdate' => date('Y-m-d H:i:s'),

            );
            $this->db->insert('sc_tmp.po_mst', $info);
        }
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();


        $this->template->display('ga/pembelian/v_input_quotation_sppb', $data);

    }

    function edit_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }

        $param_trxapprov = " and nodok='$nodok' and status in ('D','C','H','P','F')";
        $cek_trxapprov = $this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_sppb/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodok<>'$nama' and nodoktmp='$nodok'";
        $cek_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_sppb/edit_fail/$nodokfirst");
        } else {
            $info = array(

                'updateby' => $nama,
                'updatedate' => date('Y-m-d H:i:s'),
                'status' => 'E',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.sppb_mst', $info);
        }




        $param3_1 = " and nodok='$nama'";
        $param3_2 = " and nodok='$nama'";
        $sppb_mst = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['sppb_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['list_sppb_tmp_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
        $sppb_dtl = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
        $data['list_sppb_tmp_dtl'] = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
        $nik = trim($sppb_mst['nik']);

        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();

        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $data['title'] = " EDIT INPUT SPPB DETAIL";
        if ($this->uri->segment(5) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(5) == "edit_fail")
            $data['message'] = "<div class='alert alert-danger'>Peringatan Perimintaan & Stok Tidak Boleh Kosong </div>";
        else if ($this->uri->segment(5) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(5) == "st_not_null")
            $data['message'] = "<div class='alert alert-warning'>Qty Barang Tidak Boleh Kosong/ Minus</div>";
        else if ($this->uri->segment(5) == "fail_fill")
            $data['message'] = "<div class='alert alert-warning'>Kode Barang/Nama Barang Sudah Tersedia Harap Input Yang Lain</div>";
        else if ($this->uri->segment(5) == "warn_onhand")
            $data['message'] = "<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else if ($this->uri->segment(5) == "warn_onhand")
            $data['message'] = "<div class='alert alert-warning'>Peringatan Stock Kosong, Harap Dibuatkan PO Untuk Membeli barang Tsb</div>";
        else
            $data['message'] = '';
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_sppb($paramx)->result();
        //$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $this->template->display('ga/pembelian/v_edit_sppb', $data);

    }

    function approval_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $nama = $this->session->userdata('nik');
        $param_trxapprov = " and nodok='$nodok' and status in ('D','C','H','P','F')";
        $cek_trxapprov = $this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_sppb/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodok<>'$nama' and nodoktmp='$nodok'";
        $cek_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
        $data['nama'] = $this->session->userdata('nik');
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_sppb/approv_fail/$nodokfirst");
        } else {
            $info = array(
                'approvalby' => $nama,
                'approvaldate' => date('Y-m-d H:i:s'),
                'status' => 'A',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.sppb_mst', $info);
        }

        $param3_1 = " and nodok='$nama'";
        $param3_2 = " and nodok='$nama'";
        $sppb_mst = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['sppb_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['list_sppb_tmp_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
        $sppb_dtl = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
        $data['list_sppb_tmp_dtl'] = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
        $nik = trim($sppb_mst['nik']);

        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();

        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $data['title'] = " PERSETUJUAN PERMINTAAN PEMBELIAN BARANG KELUAR";
        if ($this->uri->segment(5) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(5) == "edit_fail")
            $data['message'] = "<div class='alert alert-danger'>Peringatan Stok Tidak Boleh Kosong </div>";
        else if ($this->uri->segment(5) == "cant_final")
            $data['message'] = "<div class='alert alert-danger'>Peringatan Seluruh Permintaan Detail Harus Teraprove/Ter Reject Terlebih Dahulu </div>";
        else if ($this->uri->segment(5) == "succ_dtlfinal")
            $data['message'] = "<div class='alert alert-success'>Detail sukses Terapprove </div>";
        else if ($this->uri->segment(5) == "succ_rejectdtlfinal")
            $data['message'] = "<div class='alert alert-success'> Reject Permintaan Barang Sukses Di Lakukan </div>";
        else if ($this->uri->segment(5) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_sppb($paramx)->result();
        //$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $this->template->display('ga/pembelian/v_approval_sppb', $data);

    }

    function hapus_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $nama = $this->session->userdata('nik');
        $param_trxapprov = " and nodok='$nodok' and status in ('H','P','F')";
        $cek_trxapprov = $this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_sppb/process_fail/$nodok");
        }

        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodok<>'$nama' and nodoktmp='$nodok'";
        $cek_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_sppb/approv_fail/$nodokfirst");
        } else {
            $info = array(
                'cancelby' => $nama,
                'canceldate' => date('Y-m-d H:i:s'),
                'status' => 'C',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.sppb_mst', $info);
        }


        $param3_1 = " and nodok='$nama'";
        $param3_2 = " and nodok='$nama'";
        $sppb_mst = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();

        $data['nama'] = $this->session->userdata('nik');
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['sppb_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['list_sppb_tmp_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
        $sppb_dtl = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
        $data['list_sppb_tmp_dtl'] = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
        $nik = trim($sppb_mst['nik']);

        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();

        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $data['title'] = " PEMBATALAN PBK";
        if ($this->uri->segment(5) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(5) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $this->template->display('ga/pembelian/v_hapus_sppb', $data);

    }

    function hangus_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $nama = $this->session->userdata('nik');
        $param_trxapprov = " and nodok='$nodok' and status in ('D','C')";
        $cek_trxapprov = $this->m_pembelian->q_sppb_trx_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/permintaan/form_sppb/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodok<>'$nama' and nodoktmp='$nodok'";
        $cek_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_sppb_tmp_mst_param($param3_first)->row_array();
        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_sppb/approv_fail/$nodokfirst");
        } else {
            $data['nama'] = $this->session->userdata('nik');
            $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
            $info = array(
                'hangusby' => $nama,
                'hangusdate' => date('Y-m-d H:i:s'),
                'status' => 'H',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.sppb_mst', $info);
        }


        $param3_1 = " and nodok='$nama'";
        $param3_2 = " and nodok='$nama'";
        $sppb_mst = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['sppb_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $data['list_sppb_tmp_mst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->result();
        $sppb_dtl = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->row_array();
        $data['list_sppb_tmp_dtl'] = $this->m_pembelian->q_sppb_tmp_dtl_param($param3_2)->result();
        $nik = trim($sppb_mst['nik']);

        $data['nik'] = $nik;
        $data['enc_nodok'] = bin2hex($this->encrypt->encode(trim($nama)));
        //$data['list_niksppb']=$this->m_akses->list_karyawan()->result();
        $data['list_lk'] = $this->m_akses->list_karyawan_index($nik)->result();
        $data['dtlnik'] = $this->m_akses->list_karyawan_index($nik)->row_array();

        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $data['title'] = " PENGHANGUSAN SURAT PERMINTAAN PEMBELIAN BARANG";
        if ($this->uri->segment(5) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(5) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(5) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(5) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(5) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(5) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Barang/Stock Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(5) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['dtlmst'] = $this->m_pembelian->q_sppb_tmp_mst_param($param3_1)->row_array();
        $this->template->display('ga/pembelian/v_hangus_sppb', $data);

    }

    function sti_sppb_final()
    {
        $nodok = trim(strtoupper($this->uri->segment(4)));
        $data['jsonfile'] = "ga/pembelian/json_sppb_final/$nodok";
        $data['report_file'] = 'assets/mrt/form_sppb.mrt';
        $data['title'] = "Permintaan Pembelian Barang";
        $this->load->view("ga/pembelian/sti_v_form.php", $data);
    }
    function json_sppb_final()
    {
        $nodok = $this->fiky_encryption->dekript($this->uri->segment(4));
        $param1 = " and nodok='$nodok'";
        $param2 = " and nodok='$nodok'";
        $databranch = $this->m_pembelian->q_master_branch()->result();
        $datamst = $this->m_pembelian->q_sppb_trx_mst_param($param1)->result();
        $datadtl = $this->m_pembelian->q_sppb_trx_dtl_param($param2)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'branch' => $databranch,
                'master' => $datamst,
                'detail' => $datadtl,
            )
            ,
            JSON_PRETTY_PRINT
        );
    }

    function resend_sms_sppb()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $info = array('status' => 'R');
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_trx.sppb_mst', $info);

        redirect("ga/pembelian/form_sppb/sms_success");
    }


    /// PEMBELIAN 	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN	/// PEMBELIAN

    function form_pembelian()
    {
        $data['title'] = "LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR";
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        $nama = $this->session->userdata('nik');
        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.H.1';
        $versirelease = 'I.G.H.1/ALPHA.001';
        $userid = $this->session->userdata('nama');
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        if ($versidb <> $versirelease) {
            $infoversiold = array(
                'vreleaseold' => $versidb,
                'vdateold' => $vdb['vdate'],
                'vauthorold' => $vdb['vauthor'],
                'vketeranganold' => $vdb['vketerangan'],
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversiold);

            $infoversi = array(
                'vrelease' => $versirelease,
                'vdate' => date('2017-07-10 11:18:00'),
                'vauthor' => 'FIKY',
                'vketerangan' => 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => $userid,
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversi);
        }
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */

        $isGMIncluded = $this->db->get_where('sc_mst.option', array('kdoption' => 'PO:APPROVAL:GM'))->row()->value1 == 'Y';

        $this->db->query("UPDATE sc_mst.trxtype
				SET uraian = CASE kdtrx
					WHEN 'A4' THEN 'APPROVAL GM'
					WHEN 'A5' THEN 'APPROVAL MANAGER KEUANGAN'
					WHEN 'AF4' THEN 'APPROVAL GM'
					WHEN 'AF5' THEN 'APPROVAL MANAGER KEUANGAN'
				END
				WHERE kdtrx IN ('A4','A5','AF4','AF5')
				AND jenistrx = 'POATK'");

        $paramerror = " and userid='$nama'";
        $dtlerror = $this->m_pembelian->q_trxerror($paramerror)->row_array();
        if (isset($dtlerror['description'])) {
            $errordesc = trim($dtlerror['description']);
        } else {
            $errordesc = '';
        }

        if ($this->uri->segment(4) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(4) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(4) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(4) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(4) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(4) == "edit_failed")
            $data['message'] = "<div class='alert alert-danger'>User masih ada dokumen yang belum selesai</div>";
        else if ($this->uri->segment(4) == "edit_failed_doc") {
            $nodokfirst = $this->uri->segment(5);
            $data['message'] = "<div class='alert alert-danger'>Dokumen sedang diakses user $nodokfirst</div>";
        } else if ($this->uri->segment(4) == "process_fail") {
            $nodokfirst = $this->uri->segment(5);
            $data['message'] = "<div class='alert alert-danger'>Dokumen Sudah Terproses No Rev:: $nodokfirst</div>";
        } else if ($this->uri->segment(4) == "inp_kembar") {
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        } else if ($this->uri->segment(4) == "success_input") {
            $nodokfirst = $this->uri->segment(5);
            $data['message'] = "<div class='alert alert-success'>DATA PO SUKSES DISIMPAN DOKUMEN : $nodokfirst </div>";
        } else if ($this->uri->segment(4) == "wrong_format") {
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        } elseif ($this->uri->segment(4) == "payment_success") {
            $data['message'] = "<div class='alert alert-success'>Input Pembayaran Success</div>";
        } elseif ($this->uri->segment(4) == "fail_user_exist") {
            $data['message'] = "<div class='alert alert-danger'>Input Pembayaran Untuk Dokumen ini sedang dilakukan oleh user lain</div>";
        } else {
            if ($this->uri->segment(4) != "") {
                $data['message'] = "<div class='alert alert-info'>$errordesc</div>";
            } else {
                $data['message'] = "";
            }

        }

        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        if (empty($thn)) {
            $tahun = date('Y');
            $bulan = date('m');
            $tgl = $bulan . $tahun;
        } else {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
        }
        switch ($bulan) {
            case '01':
                $bul = 'Januari';
                break;
            case '02':
                $bul = 'Februari';
                break;
            case '03':
                $bul = 'Maret';
                break;
            case '04':
                $bul = 'April';
                break;
            case '05':
                $bul = 'Mei';
                break;
            case '06':
                $bul = 'Juni';
                break;
            case '07':
                $bul = 'Juli';
                break;
            case '08':
                $bul = 'Agustus';
                break;
            case '09':
                $bul = 'September';
                break;
            case '10':
                $bul = 'Oktober';
                break;
            case '11':
                $bul = 'November';
                break;
            case '12':
                $bul = 'Desember';
                break;
        }

        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        /*cek jika ada inputan edit atau input*/
        $param3_1_1 = " and nodok='$nama' and status='I'";
        $param3_1_2 = " and nodok='$nama' and status='E'";
        $param3_1_3 = " and nodok='$nama' and status='A'";
        $param3_1_4 = " and nodok='$nama' and status='C'";
        $param3_1_5 = " and nodok='$nama' and status='H'";
        $param3_1_R = " and nodok='$nama'";
        $cekmstpo_na = $this->m_pembelian->q_tmp_po_mst_param($param3_1_1)->num_rows(); //input
        $cekmstpo_ne = $this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->num_rows(); //edit
        $cekmstpo_napp = $this->m_pembelian->q_tmp_po_mst_param($param3_1_3)->num_rows(); //approv
        $cekmstpo_cancel = $this->m_pembelian->q_tmp_po_mst_param($param3_1_4)->num_rows(); //cancel
        $cekmstpo_hangus = $this->m_pembelian->q_tmp_po_mst_param($param3_1_5)->num_rows(); //hangus
        $dtledit = $this->m_pembelian->q_tmp_po_mst_param($param3_1_R)->row_array(); //edit row array
        $enc_nodok = bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        if ($cekmstpo_na > 0) { //cek inputan
            // redirect("ga/pembelian/input_po/$enc_nik");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($cekmstpo_ne > 0) {	//cek edit
            // redirect("ga/pembelian/edit_po_atk/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($cekmstpo_napp > 0) {	//cek approv
            redirect("ga/pembelian/approval_po_atk/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($cekmstpo_cancel > 0) {	//cek cancel
            redirect("ga/pembelian/batal_po_atk/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        } else if ($cekmstpo_hangus > 0) {	//cek cancel
            redirect("ga/pembelian/hangus_po_atk/$enc_nodok");
            //redirect("ga/pembelian/direct_lost_input");
        }
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_po'] = $this->m_pembelian->q_listpembelian()->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $this->template->display('ga/pembelian/v_list_po', $data);

        $paramerror = " and userid='$nama'";
        $dtlerror = $this->m_pembelian->q_deltrxerror($paramerror);
    }

    function sti_po_final()
    {
        $nodok = trim(strtoupper($this->uri->segment(4)));
        $data['jsonfile'] = "ga/pembelian/json_po_final/$nodok";
        $data['report_file'] = 'assets/mrt/form_po.mrt';
        $data['title'] = "Pembelian Barang";
        $this->load->view("ga/pembelian/sti_v_form.php", $data);
    }

    function json_po_final()
    {
        $nodok = trim(strtoupper($this->uri->segment(4)));
        $param = " and nodok='$nodok'";
        $databranch = $this->m_pembelian->q_master_branch()->result();
        $datamst = $this->m_pembelian->q_trx_po_mst_param($param)->result();
        $datadtl = $this->m_pembelian->q_trx_po_dtl_param($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'branch' => $databranch,
                'master' => $datamst,
                'detail' => $datadtl,
            )
            ,
            JSON_PRETTY_PRINT
        );
    }

    function input_quotation($nodok)
    {
        $this->session->set_userdata('nodoksppb', $nodok);
        redirect("ga/pembelian/input_po");
    }

    function input_po()
    {
        $nodoksppb = $this->encrypt->decode(hex2bin(trim($this->session->userdata('nodoksppb'))));
        $nama = $this->session->userdata('nik');
        $tgl = explode(' - ', trim($this->input->post('tgl')));
        if (isset($tgl[0]) and isset($tgl[1])) {
            $tgl1 = date('Y-m-d', strtotime(trim($tgl[0])));
            $tgl2 = date('Y-m-d', strtotime(trim($tgl[1])));
        } else {
            $tgl2 = date('Y-m-d');
            $tgl1 = date('Y-m-d', strtotime($tgl2 . "-5 days"));
        }

        $data['title'] = 'INPUT PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";

        $paramerror = " and userid='$nama' and modul='TMPPO'";
        $dtlerror = $this->m_pembelian->q_trxerror($paramerror)->row_array();
        $count_err = $this->m_pembelian->q_trxerror($paramerror)->num_rows();
        if (isset($dtlerror['description'])) {
            $errordesc = trim($dtlerror['description']);
        } else {
            $errordesc = '';
        }
        if (isset($dtlerror['nomorakhir1'])) {
            $nomorakhir1 = trim($dtlerror['nomorakhir1']);
        } else {
            $nomorakhir1 = '';
        }
        if (isset($dtlerror['errorcode'])) {
            $errorcode = trim($dtlerror['errorcode']);
        } else {
            $errorcode = '';
        }

        if ($count_err > 0 and $errordesc <> '') {
            if ($dtlerror['errorcode'] == 0) {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message'] = "<div class='alert alert-info'>$errordesc</div>";
            }

        } else {
            if ($errorcode == '0') {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message'] = "";
            }
        }

        $cek_tmp_po = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->num_rows();
        if ($cek_tmp_po == 0) {
            $info = array(
                'branch' => $branch,
                'nodok' => $nama,
                'loccode' => $kdcabang,
                'podate' => date('Y-m-d H:i:s'),
                'status' => 'I',
                'inputby' => $nama,
                'inputdate' => date('Y-m-d H:i:s'),

            );
            $this->db->insert('sc_tmp.po_mst', $info);
        }
        $dtltmppo = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();

        $itemtype = trim($dtltmppo['itemtype']);
        $param_dtlref_query = " and to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2' and kdgroup='$itemtype' and nodok='$nodoksppb' ";
        $param_cekmapdtlref = " and nodok='$nama' and status<>'M'";
        $paramx = '';
        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
        $data['list_tmp_po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
        $data['list_tmp_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
        $data['nodoksppb'] = $nodoksppb;
        $data['enc_nodok'] = trim($this->session->userdata('nodoksppb'));
        $this->template->display('ga/pembelian/v_input_po', $data);
        $this->m_pembelian->q_deltrxerror($paramerror);
    }

    function clear_tmp_quotation($encNodok, $oldStatus = 'A')
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($encNodok)));
        $nama = $this->session->userdata('nik');
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $param3_1_2 = " and nodok='$nodok'";
        $dtledit = $this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array(); //edit row array
        $status = trim($dtledit['status']);
        $nodoktmp = trim($dtledit['nodoktmp']);
        /* restoring status  kecuali A */
        if (in_array($status, ['E', 'H'])) {
            $info = array(
                'status' => trim($oldStatus),
            );
            $infodtl = array(
                'status' => $oldStatus,
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            // $this->db->where('nodok', $nodoktmp);
            // $this->db->update('sc_trx.po_dtl', $infodtl);
            // $this->db->where('nodok', $nodoktmp);
            // $this->db->update('sc_trx.po_dtlref', $infodtl);

            // $info2 = array(
            //     'status' => '',
            // );
            // $this->db->where('nodok', $nama);
            // $this->db->update('sc_tmp.po_dtlref', $info2);
        } else if ($status == 'I') {
            $info = array(
                'status' => 'A',
            );
            $infodtl = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtl', $infodtl);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtlref', $infodtl);
        } else if ($status == 'C') {
            $info = array(
                'status' => 'A',
                'canceldate' => null,
                'cancelby' => null,
            );
            $infodtl = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtl', $infodtl);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtlref', $infodtl);
        }


        /* clearing temporary  */
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_mst');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtl');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtlref');

        if (in_array($status, ['E', 'H'])) {
            redirect("ga/pembelian/form_sppb/");
        } else if ($status == 'I') {
            redirect("ga/pembelian/form_sppb/");
        } else if ($status == 'C') {
            redirect("ga/pembelian/form_pembelian/");
        } else {
            redirect("ga/pembelian/form_sppb/");
        }
    }

    function clear_tmp_po($encNodok, $oldStatus = 'A')
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($encNodok)));
        $nama = $this->session->userdata('nik');
        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }
        $param3_1_2 = " and nodok='$nodok'";
        $dtledit = $this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array(); //edit row array
        $status = trim($dtledit['status']);
        $nodoktmp = trim($dtledit['nodoktmp']);
        /* restoring status  kecuali A */
        if (in_array($status, ['E', 'H'])) {
            $info = array(
                'status' => $oldStatus,
            );
            $infodtl = array(
                'status' => $oldStatus,
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            // $this->db->where('nodok', $nodoktmp);
            // $this->db->update('sc_trx.po_dtl', $infodtl);
            // $this->db->where('nodok', $nodoktmp);
            // $this->db->update('sc_trx.po_dtlref', $infodtl);

            // $info2 = array(
            //     'status' => '',
            // );
            // $this->db->where('nodok', $nama);
            // $this->db->update('sc_tmp.po_dtlref', $info2);
        } else if ($status == 'I') {
            $info = array(
                'status' => 'A',
            );
            $infodtl = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtl', $infodtl);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtlref', $infodtl);
        } else if ($status == 'C') {
            $info = array(
                'status' => 'A',
                'canceldate' => null,
                'cancelby' => null,
            );
            $infodtl = array(
                'status' => 'A',
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtl', $infodtl);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtlref', $infodtl);
        }


        /* clearing temporary  */
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_mst');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtl');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtlref');

        if (in_array($status, ['E', 'H'])) {
            redirect("ga/pembelian/form_pembelian/");
        } else if ($status == 'I') {
            redirect("ga/pembelian/form_sppb/");
        } else if ($status == 'C') {
            redirect("ga/pembelian/form_pembelian/");
        }
    }

    function clear_tmp_po_hangus()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        if (empty($nodok)) {
            redirect("ga/pembelian/form_pembelian");
        }
        $param3_1_2 = " and nodok='$nodok'";
        $dtledit = $this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array(); //edit row array
        $status = trim($dtledit['status']);
        $nodoktmp = trim($dtledit['nodoktmp']);
        /* restoring status  kecuali A */
        if ($status == 'H') {
            $info = array(
                'status' => 'P',
            );
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_mst', $info);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtl', $info);
            $this->db->where('nodok', $nodoktmp);
            $this->db->update('sc_trx.po_dtlref', $info);
        }

        $info2 = array(
            'status' => '',
        );
        $this->db->where('nodok', $nama);
        $this->db->update('sc_tmp.po_dtlref', $info2);

        /*}
////		$this->db->where('nodok',$nodoktmp);
////		$this->db->update('sc_trx.sppb_dtl',$info); */


        /* clearing temporary  */
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_mst');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtl');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtlref');

        redirect("ga/pembelian/form_pembelian/del_succes");
    }

    function tambah_itempo()
    {
        $lb = $this->input->post('centang');
        $nik = $this->input->post('nik');
        $nama = $this->session->userdata('nik');
        $username = $this->input->post('username');

        if (empty($lb)) {
            redirect("ga/pembelian/input_po");
        }
        foreach ($lb as $index => $temp) {
            $strtrimref = trim(preg_replace('/\s\s+/', ' ', $lb[$index]));
            $strtrimref = trim($lb[$index]);
            $param_dtlref_query = " and strtrimref='$strtrimref'";
            //$param_dtlref_query=" and rowid='$strtrimref'";
            $dtl = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->row_array();

            $this->db->where('nodok', $nama);
            $this->db->where('nodokref', trim(strtoupper($dtl['nodok'])));
            $this->db->where('nik', trim(strtoupper($dtl['nik'])));
            $this->db->where('desc_barang', trim(strtoupper($dtl['desc_barang'])));
            $this->db->delete('sc_tmp.po_dtlref');

            $cekpodtlref = $this->m_pembelian->q_tmp_po_dtlref_param($param_dtlref_query)->num_rows();
            if ($cekpodtlref > 0) {
                //redirect("ga/pembelian/input_po/data_used");
                $this->db->where('userid', $nama);
                $this->db->where('modul', 'TMPPO');
                $this->db->delete('sc_mst.trxerror');
                $insinfo = array(
                    'userid' => $nama,
                    'errorcode' => 5,
                    'modul' => 'TMPPO'
                );
                $this->db->insert('sc_mst.trxerror', $insinfo);
                redirect('/ga/pembelian/input_po');
            }



            $info[$index]['branch'] = trim(strtoupper($dtl['branch']));
            $info[$index]['nodok'] = $nama;
            $info[$index]['nik'] = trim(strtoupper($dtl['nik']));
            $info[$index]['nodokref'] = trim(strtoupper($dtl['nodok']));
            $info[$index]['kdgroup'] = trim(strtoupper($dtl['kdgroup']));
            $info[$index]['kdsubgroup'] = trim(strtoupper($dtl['kdsubgroup']));
            $info[$index]['stockcode'] = trim(strtoupper($dtl['stockcode']));
            $info[$index]['loccode'] = trim(strtoupper($dtl['loccode']));
            $info[$index]['desc_barang'] = trim(strtoupper($dtl['desc_barang']));
            $info[$index]['qtykecil'] = 0;
            $info[$index]['qtyminta'] = trim(strtoupper($dtl['qtyforpo']));
            $info[$index]['satminta'] = trim(strtoupper($dtl['satminta']));
            $info[$index]['status'] = 'I';
            $info[$index]['keterangan'] = trim(strtoupper($dtl['keterangan']));
            $info[$index]['qtyminta_tmp'] = trim(strtoupper($dtl['qtyforpo']));
            $info[$index]['id'] = trim(strtoupper($dtl['id']));
            ;

        }
        $insert = $this->m_pembelian->add_po_dtlref($info);
        redirect("ga/pembelian/input_po");
    }

    function kurang_itempo()
    {
        $lb = $this->input->post('centang');
        $nik = $this->input->post('nik');
        $nama = $this->session->userdata('nik');
        $username = $this->input->post('username');
        $param_dtlref_cekmap = " nodok=$nama and status='M'";
        if (empty($lb)) {
            redirect("ga/pembelian/input_po");
        }

        /*$cek_po_dtlref=$this->m_pembelian->q_tmp_po_dtlref_param($param_dtlref_cekmap)->num_rows();
        if($cek_po_dtlref>0){
            redirect("ga/pembelian/input_po/fail_after_mapping");
        }*/

        foreach ($lb as $index => $temp) {
            $rowid .= trim($lb[$index]) . ',';
        }
        $newrow = rtrim($rowid, ',');
        ///echo substr_replace($rowid, "", -1);
        $param_dtlref = " and rowid in ($newrow)";
        $dtl_result = $this->m_pembelian->q_tmp_po_dtlref_param($param_dtlref)->result();
        foreach ($dtl_result as $ls) {

            $this->db->delete('sc_tmp.po_dtlref', array(
                'nodok' => $nama,
                'desc_barang' => trim(strtoupper($ls->desc_barang)),
                'nodokref' => trim(strtoupper($ls->nodokref))
            ));
        }
        redirect("ga/pembelian/input_po");
    }

    function reset_po_dtlrev()
    {
        $nama = $this->session->userdata('nik');
        $this->db->delete('sc_tmp.po_dtlref', array('nodok' => $nama));
        $this->db->delete('sc_tmp.po_dtl', array('nodok' => $nama));
        redirect("ga/pembelian/form_sppb/reset_success");
    }

    function mapping_po_dtlrev()
    {
        $rowid = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama' and rowid='$rowid'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $dtlforparam = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->row_array();
        /* 		$kdgroup=trim($dtlforparam['kdgroup']);
                $kdsubgroup=trim($dtlforparam['kdsubgroup']);
                $stockcode=trim($dtlforparam['stockcode']); */
        //$paramx=" and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup' and stockcode='$stockcode'";
        //$data['trxqtyunit']=$this->m_pembelian->q_trxqtyunit($paramx)->result();
        $paramx = "";
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_full($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->row_array();
        $this->template->display('ga/pembelian/v_mapping_po_dtlrev', $data);
    }

    function remapping_po_dtl()
    {
        $rowid = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));

        $param_tmp_mst = " and nodok='$nama'";
        $param_tmp_po = " and nodok='$nama' and id='$rowid'";

        /* CEK MASTER SUPPLIER HARUS TERISI TERLEBIH DAHULU*/
        $param_cek_supplier = " and nodok='$nama' and coalesce(kdsubsupplier,'')='' ";
        $cek_sup = $this->m_pembelian->q_tmp_po_mst_param($param_cek_supplier)->num_rows();
        if ($cek_sup > 0) {
            $this->db->where('userid', $nama);
            $this->db->where('modul', 'TMPPO');
            $this->db->delete('sc_mst.trxerror');
            $insinfo = array(
                'userid' => $nama,
                'errorcode' => 4,
                'modul' => 'TMPPO'
            );
            $this->db->insert('sc_mst.trxerror', $insinfo);
            redirect('/ga/pembelian/form_pembelian');

        }
        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $po_dtl = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();
        $kdgroup = trim($po_dtl['kdgroup']);
        $kdsubgroup = trim($po_dtl['kdsubgroup']);
        $stockcode = trim($po_dtl['stockcode']);
        $param1 = " and loccode='$kdcabang' ";
        $param2 = " and kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup'  and stockcode='$stockcode' ";

        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();

        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_mst)->row_array();
        $data['po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();

        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($param2)->result();

        //$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();



        $this->template->display('ga/pembelian/v_remapping_po_dtl', $data);
    }

    function hapus_detail_inputpo()
    {
        $rowid = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $param1 = "and nodok='$nama' and id='$rowid'";
        $dtl = $this->m_pembelian->q_tmp_po_dtl_param($param1)->row_array();


        $this->db->where('nodok', $nama);
        $this->db->where('id', $rowid);
        $this->db->delete('sc_tmp.po_dtl');


        $nodok = $nama;
        $kdgroup = trim($dtl['kdgroup']);
        $kdsubgroup = trim($dtl['kdsubgroup']);
        $stockcode = trim($dtl['stockcode']);

        $this->db->where('nodok', $nodok);
        $this->db->where('kdgroup', $kdgroup);
        $this->db->where('kdsubgroup', $kdsubgroup);
        $this->db->where('stockcode', $stockcode);
        $this->db->delete('sc_tmp.po_dtlref');

        redirect("ga/pembelian/input_po/del_succes");
    }

    function detail_po_dtl()
    {
        $rowid = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nodok = substr(trim($this->encrypt->decode(hex2bin(trim($this->uri->segment(4))))), 0, 10);
        $nama = $this->session->userdata('nik');
        $data['title'] = 'MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";

        $param_trx_mst = " and nodok='$nodok'";
        $param_trx_po = " and rowselect='$rowid'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_full($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_mst)->row_array();
        $data['po_dtl'] = $this->m_pembelian->q_trx_po_dtl_param($param_trx_po)->row_array();
        $this->template->display('ga/pembelian/v_detail_po_dtl', $data);
    }

    function detail_po_dtl_tmp()
    {
        $rowid = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'MAPPING ITEM PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_mst = " and nodok='$nama'";
        $param_tmp_po = " and nodok='$nama' and id='$rowid'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_mst)->row_array();
        $data['po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();
        $this->template->display('ga/pembelian/v_detail_po_dtl_tmp.php', $data);
    }

    function detail_po_dtl_tmp_hangus()
    {
        $rowid = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'UBAH HARGA HANGUS ITEM PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_mst = " and nodok='$nama'";
        $param_tmp_po = " and nodok='$nama' and id='$rowid'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_mst)->row_array();
        $data['po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->row_array();
        $this->template->display('ga/pembelian/v_detail_po_dtl_tmp_hangus.php', $data);
    }

    function input_supplier_po_mst()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nodoksppb = trim($this->uri->segment(5));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'Input/Edit Supplier Master Quotation PO';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";

        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
        $data['nodoksppb'] = $nodoksppb;
        $this->template->display('ga/pembelian/v_input_supplier_po_mst', $data);
    }

    function detail_supplier_po_mst_tmp()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $data['oldStatus'] = trim($this->uri->segment(5));
        $data['nextStatus'] = trim($this->uri->segment(6));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'Detail Supplier Master PO';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
        $this->template->display('ga/pembelian/v_detail_supplier_po_mst_tmp', $data);
    }

    function detail_supplier_po_mst()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nama = $this->session->userdata('nik');
        $data['title'] = 'Detail Supplier Master PO';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_trx_po = " and nodok='$nodok'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['po_mst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->row_array();
        $this->template->display('ga/pembelian/v_detail_supplier_po_mst', $data);
    }

    function save_po()
    {
        $nama = $this->session->userdata('nik');
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $nik = strtoupper($this->input->post('nik'));
        $nodok = strtoupper(trim($this->input->post('nodok')));
        $nodokref = strtoupper($this->input->post('nodokref'));
        $nodoksppb = strtoupper($this->input->post('nodoksppb'));
        $kdgroup = strtoupper($this->input->post('kdgroup'));
        $kdsubgroup = strtoupper($this->input->post('kdsubgroup'));
        $stockcode = strtoupper($this->input->post('kdbarang'));
        $loccode = strtoupper($this->input->post('loccode'));
        $desc_barang = strtoupper($this->input->post('desc_barang'));
        $qtyunit = strtoupper($this->input->post('qtyunit'));
        $satminta = strtoupper(trim($this->input->post('satminta')));
        $pkp = strtoupper($this->input->post('pkp'));
        $podate = strtoupper($this->input->post('podate'));
        $exppn = strtoupper($this->input->post('exppn'));
        $qtyminta = (strtoupper(trim($this->input->post('qtyminta'))) == '' ? '0' : strtoupper(trim($this->input->post('qtyminta'))));
        $satkecil = strtoupper($this->input->post('satkecil'));
        $qtykecil = (strtoupper(trim($this->input->post('qtykecil'))) == '' ? '0' : strtoupper(trim($this->input->post('qtykecil'))));
        $unitprice = (strtoupper(trim($this->input->post('unitprice'))) == '' ? '0' : str_replace(',', '.', (trim($this->input->post('unitprice')))));
        $unitprice = str_replace(".", "", $unitprice);
        $unitprice = (strtoupper(trim($this->input->post('unitprice'))) == '' ? '0' : str_replace(',', '.', (trim($this->input->post('unitprice')))));
        $unitprice = str_replace('.', '', $unitprice);
        // var_dump($unitprice);die();
        $checkdisc = strtoupper($this->input->post('checkdisc'));

        if ($checkdisc == 'NO') {
            $disc1 = 0;
            $disc2 = 0;
            $disc3 = 0;
            $disc4 = 0;
        } else {
            $disc1 = str_replace(',', '.', (strtoupper(trim($this->input->post('disc1'))) == '' ? '0' : str_replace(',', '.', (trim($this->input->post('disc1'))))));
            $disc2 = str_replace(',', '.', (strtoupper(trim($this->input->post('disc2'))) == '' ? '0' : str_replace(',', '.', (trim($this->input->post('disc2'))))));
            $disc3 = str_replace(',', '.', (strtoupper(trim($this->input->post('disc3'))) == '' ? '0' : str_replace(',', '.', (trim($this->input->post('disc3'))))));
            $disc4 = str_replace(',', '.', (strtoupper(trim($this->input->post('disc4'))) == '' ? '0' : str_replace(',', '.', (trim($this->input->post('disc4'))))));
        }

        $ttldpp = (strtoupper(trim($this->input->post('ttldpp'))) == '' ? '0' : str_replace(',', '', (trim($this->input->post('ttldpp')))));
        $ttldiskon = (strtoupper(trim($this->input->post('ttldiskon'))) == '' ? '0' : str_replace(',', '', (trim($this->input->post('ttldiskon')))));
        $ttlbrutto = (strtoupper(trim($this->input->post('ttlbrutto'))) == '' ? '0' : str_replace(',', '', (trim($this->input->post('ttlbrutto')))));
        $ttlnetto = (strtoupper(trim($this->input->post('ttlnetto'))) == '' ? '0' : str_replace(',', '', (trim($this->input->post('ttlnetto')))));
        $payterm = strtoupper(trim($this->input->post('payterm')));
        $ttlppn = (strtoupper(trim($this->input->post('ttlppn'))) == '' ? '0' : str_replace(',', '', (trim($this->input->post('ttlppn')))));
        $qtypo = (strtoupper(trim($this->input->post('qtypo'))) == '' ? '0' : strtoupper(trim($this->input->post('qtypo'))));
        $qtyreceipt = (strtoupper(trim($this->input->post('qtyreceipt'))) == '' ? '0' : strtoupper(trim($this->input->post('qtyreceipt'))));
        $kdgroupsupplier = strtoupper(trim($this->input->post('kdgroupsupplier')));
        $kdsupplier = strtoupper(trim($this->input->post('kdsupplier')));
        $kdsubsupplier = strtoupper(trim($this->input->post('kdsubsupplier')));
        $kdcabangsupplier = strtoupper(trim($this->input->post('kdcabangsupplier')));
        $rowid = strtoupper(trim($this->input->post('id')));
        // if ($kdgroupsupplier=='BRG') { $itemtype='BRG'; /* barang */ } else if ($kdgroupsupplier=='JSAB') {  $itemtype='JSA'; /* jasa */  }
        $itemtype = $kdgroupsupplier;
        $keterangan = strtoupper($this->input->post('keterangan'));
        $inputdate = date('Y-m-d H:i:s');
        $inputby = $nama;

        if ($type == 'INPUT') {
            if (empty($stockcode)) {
                redirect("ga/pembelian/form_pembelian");
            }
            $info = array(
                'branch' => $branch,
                'nodok' => $nama,
                'nodokref' => $nodokref,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'stockcode' => $stockcode,
                'loccode' => $loccode,
                'desc_barang' => $desc_barang,
                'unitprice' => $unitprice,
                'qtytotalprice' => $qtytotalprice,
                'qtypo' => $qtypo,
                'qtyreceipt' => $qtyreceipt,
                'qtyunit' => $qtyunit,
                'kdgroupsup' => $kdgroupsup,
                'kdsupplier' => $kdsupplier,
                'kdsubsupplier' => $kdsubsupplier,
                'status' => 'I',
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,

            );
            $this->db->insert('sc_tmp.po_order', $info);
            redirect("ga/pembelian/form_pembelian/inp_succes");

        } else if ($type == 'EDIT') {
            $info = array(
                'nodokref' => $nodokref,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'stockcode' => $stockcode,
                'loccode' => $loccode,
                'desc_barang' => $desc_barang,
                'unitprice' => $unitprice,
                'qtytotalprice' => $qtytotalprice,
                'qtypo' => $qtypo,
                'qtyreceipt' => $qtyreceipt,
                'qtyunit' => $qtyunit,
                'kdgroupsup' => $kdgroupsup,
                'kdsupplier' => $kdsupplier,
                'kdsubsupplier' => $kdsubsupplier,
                'status' => 'A',
                'keterangan' => $keterangan,
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/inp_succes");
        } else if ($type == 'MAPREVITEM') {
            $info = array(
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'stockcode' => $stockcode,
                'loccode' => $loccode,
                'satminta' => $satminta,
                'qtyminta' => $qtyminta,
                'satkecil' => $satkecil,
                'qtykecil' => $qtykecil,
                'status' => 'I',
            );
            $this->db->where('desc_barang', $desc_barang);
            $this->db->where('nodok', $nodok);
            $this->db->where('nodokref', $nodokref);
            $this->db->where('nik', $nik);
            $this->db->update('sc_tmp.po_dtlref', $info);
            redirect("ga/pembelian/input_po/app_succes");
        } else if ($type == 'MAP_PODTL_ITEM') {

            $info = array(
                'unitprice' => $unitprice,
                'disc1' => $disc1,
                'disc2' => $disc2,
                'disc3' => $disc3,
                'disc4' => $disc4,
                'pkp' => $pkp,
                'exppn' => $exppn,
                'satminta' => $satminta,
                'qtyminta' => $qtyminta,
                'satkecil' => $satkecil,
                'qtykecil' => $qtykecil,
                'ttlbrutto' => $ttlbrutto,
                'status' => '',
                'keterangan' => $keterangan,
            );
            //$this->db->where('id',$rowid);
            $this->db->where('nodok', $nodok);
            $this->db->where('kdgroup', $kdgroup);
            $this->db->where('kdsubgroup', $kdsubgroup);
            $this->db->where('stockcode', $stockcode);
            $this->db->update('sc_tmp.po_dtl', $info);
            redirect("ga/pembelian/input_po/app_succes");
        } else if ($type == 'MAP_PODTL_ITEM_EDIT') {
            $param_tmpmst = " and nodok='$nama'";
            $dtl_tmpmst = $this->m_pembelian->q_tmp_po_mst_param($param_tmpmst)->row_array();
            $nodoktmp = trim($dtl_tmpmst['nodoktmp']);
            $enc_nodoktmp = bin2hex($this->encrypt->encode(trim($nodoktmp)));


            $info = array(
                'unitprice' => $unitprice,
                'disc1' => $disc1,
                'disc2' => $disc2,
                'disc3' => $disc3,
                'disc4' => $disc4,
                'pkp' => $pkp,
                'exppn' => $exppn,
                'satminta' => $satminta,
                'qtyminta' => $qtyminta,
                'satkecil' => $satkecil,
                'qtykecil' => $qtykecil,
                'ttlbrutto' => $ttlbrutto,

                'status' => '',
                'keterangan' => $keterangan,
            );
            //$this->db->where('id',$rowid);
            $this->db->where('nodok', $nodok);
            $this->db->where('kdgroup', $kdgroup);
            $this->db->where('kdsubgroup', $kdsubgroup);
            $this->db->where('stockcode', $stockcode);
            $this->db->update('sc_tmp.po_dtl', $info);
            redirect("ga/pembelian/edit_po_atk/$enc_nodoktmp/app_succes");
        } else if ($type == 'ADD_SUPPLIER_MST') {
            $param_change_supplier = " and nodok='$nodok'";
            $dtlceksupp = $this->m_pembelian->q_cek_ubah_supplier($param_change_supplier)->row_array();
            if (isset($dtlceksupp['kdgroup'])) {
                if (trim($dtlceksupp['kdgroup']) != $itemtype) {
                    /* INSERT TRX ERROR */
                    $param1error = 55;
                    $param2error = $nama;
                    $this->m_pembelian->ins_trxerror($param1error, $param2error);
                    redirect("ga/pembelian/input_po");
                } else {
                    $info = array(
                        'itemtype' => $itemtype,
                        'podate' => $podate,
                        'disc1' => $disc1,
                        'disc2' => $disc2,
                        'disc3' => $disc3,
                        'disc4' => $disc4,
                        'pkp' => $pkp,
                        'exppn' => $exppn,
                        'payterm' => $payterm,
                        'kdgroupsupplier' => $kdgroupsupplier,
                        'kdsupplier' => $kdsupplier,
                        'kdsubsupplier' => $kdsubsupplier,
                        'kdcabangsupplier' => $kdcabangsupplier,
                        'status' => '',
                        'keterangan' => $keterangan,
                    );
                    $this->db->where('nodok', $nodok);
                    $this->db->update('sc_tmp.po_mst', $info);

                    /* INSERT TRX ERROR */
                    $param1error = 0;
                    $param2error = $nama;
                    $this->m_pembelian->ins_trxerror($param1error, $param2error);
                    redirect("ga/pembelian/input_po/$nodoksppb/app_succes");
                }
            } else {
                $info = array(
                    'itemtype' => $itemtype,
                    'podate' => $podate,
                    'disc1' => $disc1,
                    'disc2' => $disc2,
                    'disc3' => $disc3,
                    'disc4' => $disc4,
                    'pkp' => $pkp,
                    'exppn' => $exppn,
                    'payterm' => $payterm,
                    'kdgroupsupplier' => $kdgroupsupplier,
                    'kdsupplier' => $kdsupplier,
                    'kdsubsupplier' => $kdsubsupplier,
                    'kdcabangsupplier' => $kdcabangsupplier,
                    'status' => '',
                    'keterangan' => $keterangan,
                );
                $this->db->where('nodok', $nodok);
                $this->db->update('sc_tmp.po_mst', $info);
                /* INSERT TRX ERROR */
                $param1error = 0;
                $param2error = $nama;
                $this->m_pembelian->ins_trxerror($param1error, $param2error);
                redirect("ga/pembelian/input_po/$nodoksppb/app_succes");

            }

        } else if ($type == 'EDIT_SUPPLIER_MST') {
            $param_tmpmst = " and nodok='$nama'";
            $dtl_tmpmst = $this->m_pembelian->q_tmp_po_mst_param($param_tmpmst)->row_array();
            $nodoktmp = trim($dtl_tmpmst['nodoktmp']);
            $enc_nodoktmp = bin2hex($this->encrypt->encode(trim($nodoktmp)));

            $param_change_supplier = " and nodok='$nodok'";
            $dtlceksupp = $this->m_pembelian->q_cek_ubah_supplier($param_change_supplier)->row_array();
            if (isset($dtlceksupp['kdgroup'])) {
                if (trim($dtlceksupp['kdgroup']) != $itemtype) {
                    /* INSERT TRX ERROR */
                    $param1error = 55;
                    $param2error = $nama;
                    $this->m_pembelian->ins_trxerror($param1error, $param2error);
                    redirect("ga/pembelian/input_po");
                } else {
                    $info = array(
                        'itemtype' => $itemtype,
                        'podate' => $podate,
                        'disc1' => $disc1,
                        'disc2' => $disc2,
                        'disc3' => $disc3,
                        'disc4' => $disc4,
                        'pkp' => $pkp,
                        'exppn' => $exppn,
                        'payterm' => $payterm,
                        'kdgroupsupplier' => $kdgroupsupplier,
                        'kdsupplier' => $kdsupplier,
                        'kdsubsupplier' => $kdsubsupplier,
                        'kdcabangsupplier' => $kdcabangsupplier,
                        'status' => '',
                        'keterangan' => $keterangan,
                    );
                    $this->db->where('nodok', $nodok);
                    $this->db->update('sc_tmp.po_mst', $info);
                    /* INSERT TRX ERROR */
                    $param1error = 0;
                    $param2error = $nama;
                    $this->m_pembelian->ins_trxerror($param1error, $param2error);
                    redirect("ga/pembelian/edit_po_atk/$enc_nodoktmp/edit_succes");
                }
            } else {
                $info = array(
                    'itemtype' => $itemtype,
                    'podate' => $podate,
                    'disc1' => $disc1,
                    'disc2' => $disc2,
                    'disc3' => $disc3,
                    'disc4' => $disc4,
                    'pkp' => $pkp,
                    'exppn' => $exppn,
                    'payterm' => $payterm,
                    'kdgroupsupplier' => $kdgroupsupplier,
                    'kdsupplier' => $kdsupplier,
                    'kdsubsupplier' => $kdsubsupplier,
                    'kdcabangsupplier' => $kdcabangsupplier,
                    'status' => '',
                    'keterangan' => $keterangan,
                );
                $this->db->where('nodok', $nodok);
                $this->db->update('sc_tmp.po_mst', $info);
                /* INSERT TRX ERROR */
                $param1error = 0;
                $param2error = $nama;
                $this->m_pembelian->ins_trxerror($param1error, $param2error);
                redirect("ga/pembelian/edit_po_atk/$enc_nodoktmp/edit_succes");
            }
        } else if ($type == 'APPROVAL') {
            $info = array(
                'status' => 'P',
                'approvaldate' => $inputdate,
                'approvalby' => $inputby,
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/app_succes");
        } else if ($type == 'APPMAPING') {
            /* CEK MASTER SUPPLIER HARUS TERISI TERLEBIH DAHULU*/
            $param_cek_supplier = " and nodok='$nama' and coalesce(kdsubsupplier,'')='' ";
            $cek_sup = $this->m_pembelian->q_tmp_po_mst_param($param_cek_supplier)->num_rows();
            if ($cek_sup > 0) {
                $this->db->where('userid', $nama);
                $this->db->where('modul', 'TMPPO');
                $this->db->delete('sc_mst.trxerror');
                $insinfo = array(
                    'userid' => $nama,
                    'errorcode' => 4,
                    'modul' => 'TMPPO'
                );
                $this->db->insert('sc_mst.trxerror', $insinfo);
                redirect('/ga/pembelian/form_pembelian');

            } else {

                $info1 = array(
                    'qtyminta' => $qtyminta,
                    'status' => 'M',
                );
                $this->db->where('nodok', $nodok);
                $this->db->where('nodokref', $nodokref);
                $this->db->where('kdgroup', $kdgroup);
                $this->db->where('kdsubgroup', $kdsubgroup);
                $this->db->where('stockcode', $stockcode);
                $this->db->where('id', $rowid);
                $this->db->update('sc_tmp.po_dtlref', $info1);

                $info_dtl = array(
                    'status' => '',
                );
                $this->db->update('sc_tmp.po_dtl', $info_dtl);

                redirect("ga/pembelian/input_po/$nodoksppb/app_succes");
            }
        } else if ($type == 'DELETE') {
            $info = array(
                'status' => 'C',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/del_succes");
        } else if ($type == 'UPDATE_HARGA_HANGUS') {
            $param_tmpmst = " and nodok='$nama'";
            $dtl_tmpmst = $this->m_pembelian->q_tmp_po_mst_param($param_tmpmst)->row_array();
            $nodoktmp = trim($dtl_tmpmst['nodoktmp']);
            $enc_nodoktmp = bin2hex($this->encrypt->encode(trim($nodoktmp)));
            $info = array(

                'ttlbrutto' => $ttlbrutto,
                'status' => ''
            );
            $this->db->where('id', $rowid);
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_tmp.po_dtl', $info);
            redirect("ga/pembelian/hangus_po_atk/$enc_nodoktmp/app_succes");
        } else {
            redirect("ga/pembelian/form_pembelian");
        }
    }

    function final_input_po()
    {
        $enc_nik = trim($this->uri->segment(4));
        $enc_nodok = trim($this->uri->segment(5));
        $nama = trim($this->session->userdata('nik'));
        $param_tmp_po = " and nodok='$nama'";
        $nodok = $this->encrypt->decode(hex2bin($enc_nik));
        $nodoksppb = $this->encrypt->decode(hex2bin($enc_nodok));

        if ($this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row()->ttlnetto > 0):
            $info = array(
                'status' => 'A',
                'nodokref' => $nodoksppb,
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_tmp.po_mst', $info);

            $info = array(
                'status' => 'QA',
            );
            $this->db->where('nodok', $nodoksppb);
            $this->db->update('sc_trx.sppb_mst', $info);

            $paramerror = " and userid='$nama'";
            $dtlerror = $this->m_pembelian->q_trxerror($paramerror)->row_array();
            if (isset($dtlerror['errorcode'])) {
                $errorcode = (trim($dtlerror['errorcode']));
                $nodoktmp = ($dtlerror['nomorakhir1']);
            } else {
                $errorcode = '';
            }

            if ($errorcode > 0) {
                redirect("ga/pembelian/form_sppb/inp_succes");
            } else if ($errorcode == 0) {
                redirect("ga/pembelian/form_sppb/success_input/$nodoktmp");
            }
        endif;
        redirect($_SERVER['HTTP_REFERER']);
    }

    function final_approval_quotation($enc_nik, $status, $encNodokSppb)
    {
        $nama = $this->session->userdata('nik');
        $nodok = $this->encrypt->decode(hex2bin($enc_nik));
        $nodokSppb = $this->encrypt->decode(hex2bin($encNodokSppb));
        $info = array(
            'status' => $status,
            'approvaldate' => date('Y-m-d H:i:s'),
            'approvalby' => $nama,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info);

        $info2 = array(
            'status' => 'QP',
            'approvaldate' => date('Y-m-d H:i:s'),
            'approvalby' => $nama,
        );
        $this->db->where('nodok', $nodokSppb);
        $this->db->update('sc_trx.sppb_mst', $info2);
        redirect("ga/pembelian/form_sppb/approve_succes");
    }

    function final_approval_po($enc_nik, $status)
    {
        $nama = $this->session->userdata('nik');
        $nodok = $this->encrypt->decode(hex2bin($enc_nik));
        $info = array(
            'status' => $status,
            'approvaldate' => date('Y-m-d H:i:s'),
            'approvalby' => $nama,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info);
        redirect("ga/pembelian/form_pembelian/inp_succes");
    }


    function reject_approval_quotation($encNodok, $oldStatus)
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($encNodok)));
        $nama = $this->session->userdata('nik');

        if (empty($nodok)) {
            redirect("ga/pembelian/form_sppb");
        }

        $param3_1_2 = " and nodok='$nodok'";
        $dtledit = $this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array();
        $status = trim($dtledit['status']);
        $nodoktmp = trim($dtledit['nodoktmp']);
        $nodokSppb = trim($dtledit['nodokref']);

        $info = array(
            'status' => $oldStatus,
        );
        $infodtl = array(
            'status' => $oldStatus,
        );
        $this->db->where('nodok', $nodoktmp);
        $this->db->update('sc_trx.po_mst', $info);
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_mst');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtl');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtlref');

        $info2 = array(
            'status' => 'C',
            'cancelby' => $nama,
            'canceldate' => date('Y-m-d H:i:s'),
        );
        $this->db->where('nodok', $nodoktmp);
        $this->db->update('sc_trx.po_mst', $info2);

        $info3 = array(
            'status' => 'F',
            'canceldate' => date('Y-m-d H:i:s'),
            'cancelby' => $nama,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info3);

        $info4 = array(
            'status' => 'P',
            'approvaldate' => date('Y-m-d H:i:s'),
            'approvalby' => $nama,
        );
        $this->db->where('nodok', $nodokSppb);
        $this->db->update('sc_trx.sppb_mst', $info4);
        redirect("ga/pembelian/form_sppb/cancel_succes");
    }

    function reject_approval_po($encNodok, $oldStatus)
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($encNodok)));
        $nama = $this->session->userdata('nik');

        if (empty($nodok)) {
            redirect("ga/pembelian/form_pembelian");
        }

        $param3_1_2 = " and nodok='$nodok'";
        $dtledit = $this->m_pembelian->q_tmp_po_mst_param($param3_1_2)->row_array();
        $status = trim($dtledit['status']);
        $nodoktmp = trim($dtledit['nodoktmp']);
        $nodokSppb = trim($dtledit['nodokref']);

        $info = array(
            'status' => $oldStatus,
        );
        $infodtl = array(
            'status' => $oldStatus,
        );
        $this->db->where('nodok', $nodoktmp);
        $this->db->update('sc_trx.po_mst', $info);
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_mst');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtl');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_dtlref');

        $info2 = array(
            'status' => 'C',
            'cancelby' => $nama,
            'canceldate' => date('Y-m-d H:i:s'),
        );
        $this->db->where('nodok', $nodoktmp);
        $this->db->update('sc_trx.po_mst', $info2);

        $info3 = array(
            'status' => 'F',
            'canceldate' => date('Y-m-d H:i:s'),
            'cancelby' => $nama,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info3);

        $info4 = array(
            'status' => 'P',
            'approvaldate' => date('Y-m-d H:i:s'),
            'approvalby' => $nama,
        );
        $this->db->where('nodok', $nodokSppb);
        $this->db->update('sc_trx.sppb_mst', $info4);
        redirect("ga/pembelian/form_pembelian/cancel_succes");
    }

    function final_batal_po()
    {
        $enc_nik = trim($this->uri->segment(4));
        $nama = $this->session->userdata('nik');
        $nodok = $this->encrypt->decode(hex2bin($enc_nik));
        $info = array(
            'status' => 'F',
            'canceldate' => date('Y-m-d H:i:s'),
            'cancelby' => $nama,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info);
        redirect("ga/pembelian/form_pembelian/inp_succes");
    }
    function final_hangus_po()
    {
        $enc_nik = trim($this->uri->segment(4));
        $nama = $this->session->userdata('nik');
        $nodok = $this->encrypt->decode(hex2bin($enc_nik));
        $info = array(
            'status' => 'F',
            'hangusdate' => date('Y-m-d H:i:s'),
            'hangusby' => $nama,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info);
        redirect("ga/pembelian/form_pembelian/inp_succes");
    }

    function batal_hangus_po($enc_nik, $oldStatus)
    {
        $nama = $this->session->userdata('nik');
        $nodok = $this->encrypt->decode(hex2bin($enc_nik));
        $info = array(
            'status' => $oldStatus,
        );
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_tmp.po_mst', $info);
        redirect("ga/pembelian/form_pembelian");
    }

    function cobapagin()
    {
        $nama = $this->session->userdata('nik');

        /* akses approve atasan */
        $ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdeppo()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        $jabatan = '';
        $cek_jabatan = $this->db->select('jabatan')
            ->from('sc_mst.karyawan')
            ->where('nik', $nama)
            ->get()->row_array();
        if (!empty($cek_jabatan)) {
            $jabatan = strtoupper(trim($cek_jabatan['jabatan']));
        }
        $all = ($level_akses === 'A') || ($jabatan === 'FIN01');
        if ($userhr > 0) {
            $param_list_akses = " ";
        } else if ($all) {
            $param_list_akses = " ";
        } else if (($ceknikatasan1) > 0 and $userhr == 0) {
            $param_list_akses = " and nik_atasan2='$nama' or nik_atasan='$nama' or nik='$nama'";
            $param_list2 = 1;
        } else if (($ceknikatasan2) > 0 and $userhr == 0) {
            $param_list_akses = " and nik_atasan2='$nama' or nik_atasan='$nama' or nik='$nama'";
            $param_list2 = 1;
        } else {
            $param_list_akses = " and nik='$nama' ";
            $param_list2 = 0;
        }

        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;
        /* END APPROVE ATASAN */

        $list = $this->m_pembelian->get_list_po($param_list_akses)->result();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lpo) {
            $status = trim($lpo->status);
            $enc_nodok = bin2hex($this->encrypt->encode(trim($lpo->nodok)));
            $approve = (substr($status, 0, 1) == 'A') ? $this->m_pembelian->po_approver(trim($lpo->nodok)) : false;

            $no++;
            $row = [
                $no,
                $lpo->nodok,
                $lpo->nmsubsupplier,
                '<span class="pull-right">' . number_format($lpo->ttlnetto) . '</span>',
                $lpo->nmbarang,
                $lpo->keterangan,
                $lpo->ketstatus
            ];

            $buttons = '<a class="btn btn-sm btn-default" href="' . site_url('ga/pembelian/detail_po_atk/' . $enc_nodok) . '" title="Detail PO"><i class="fa fa-bars"></i></a>';

            if (in_array($status, ['P', 'S', 'FP'])) {
                if ($userhr == 0) {
                    $buttons .= ' <a class="btn btn-sm btn-warning" target="_blank" href="' . site_url('ga/pembelian/sti_po_final/' . $lpo->nodok) . '" title="Cetak PO"><i class="fa fa-print"></i></a>';
                } else {
                    $buttons .= ' <a class="btn btn-sm btn-danger" href="' . site_url('ga/pembelian/hangus_po_atk/' . $enc_nodok . '/' . $status) . '" title="Hangus PO"><i class="fa fa-bars"></i></a>
                          <a class="btn btn-sm btn-success" href="' . site_url('ga/pembelian/pembayaran_po/' . $enc_nodok . '/' . $status) . '" title="Pembayaran PO"><i class="fa fa-money"></i></a>
                          <a class="btn btn-sm btn-primary" href="' . site_url('ga/pembelian/inputpo_faktur/' . $enc_nodok . '/' . $status) . '" title="Faktur PO"><i class="fa fa-sticky-note"></i></a>';
                }
            } elseif ($approve && $status) {
                $buttons .= ' <a class="btn btn-sm btn-success" href="' . site_url('ga/pembelian/approval_po_atk/' . $enc_nodok . '/' . $status . '/' . $approve['next_status']) . '" title="Approval PO"><i class="fa fa-check"></i></a>';
            } elseif (in_array($status, ['A1', 'AF1']) && $param_list2 == 0) {
                $buttons .= ' <a class="btn btn-sm btn-primary" href="' . site_url('ga/pembelian/edit_po_atk/' . $enc_nodok) . '" title="Edit PO"><i class="fa fa-gear"></i></a>
                      <a class="btn btn-sm btn-danger" href="' . site_url('ga/pembelian/batal_po_atk/' . $enc_nodok) . '" title="Hapus PO"><i class="fa fa-trash-o"></i></a>';
            }

            $row[] = $buttons;
            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pembelian->q_listpembelian()->num_rows(),
            "recordsFiltered" => $this->m_pembelian->get_list_po($param_list_akses)->num_rows(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function edit_po_atk()
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $nama = trim($this->session->userdata('nik'));
        $data['title'] = 'EDIT PEMBELIAN/PURCHASE ORDER (PO)';


        $tgl = explode(' - ', trim($this->input->post('tgl')));
        if (isset($tgl[0]) and isset($tgl[1])) {
            $tgl1 = date('Y-m-d', strtotime(trim($tgl[0])));
            $tgl2 = date('Y-m-d', strtotime(trim($tgl[1])));
        } else {
            $tgl2 = date('Y-m-d');
            $tgl1 = date('Y-m-d', strtotime($tgl2 . "-5 days"));

        }

        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";
        $param_dtlref_query = " and to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2' and nodok='X92Y4HWJDAOWEF8O9J' ";
        $param_cekmapdtlref = " and nodok='$nama' and status<>'M'";


        $paramerror = " and userid='$nama'";
        $dtlerror = $this->m_pembelian->q_trxerror($paramerror)->row_array();
        if (isset($dtlerror['description'])) {
            $errordesc = trim($dtlerror['description']);
        } else {
            $errordesc = '';
        }
        if ($this->uri->segment(5) != "") {
            $data['message'] = "<div class='alert alert-info'>$errordesc</div>";
        } else {
            $data['message'] = "";
        }

        $param_trxapprov = " and nodok='$nodok' and status in ('P','D','C','H')";
        $cek_trxapprov = $this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodoktmp='$nodok'";
        $param4_first = " and nodok='$nama'";
        $cek_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
        $cek_first_nik = $this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();


        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_pembelian/edit_failed_doc/$nodokfirst");
        } else {
            $info = array(
                'status' => 'E',
                'updateby' => $nama,
                'updatedate' => date('Y-m-d H:i:s'),
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_mst', $info);
        }

        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nodok'] = trim($this->uri->segment(4));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
        $data['list_tmp_po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
        $data['list_tmp_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
        $this->template->display('ga/pembelian/v_edit_po', $data);
        $this->m_pembelian->q_deltrxerror($paramerror);
    }

    function approval_quotation($encNodok, $oldStatus, $nextStatus)
    {
        $nodok = $this->encrypt->decode(hex2bin($encNodok));

        $nama = trim($this->session->userdata('nik'));
        $data['title'] = 'APPROVAL PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";
        $param_dtlref_query = " and nodok='x'";
        $param_cekmapdtlref = " and nodok='$nama' and status<>'M'";

        $param_trxapprov = " and nodok='$nodok' and status in ('P','D','C','H')";
        $cek_trxapprov = $this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodokref='$nodok' and nodok = '$nama'";
        $param4_first = " and nodok='$nama'";
        $cek_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
        $cek_first_nik = $this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();

        if ($cek_first == 0) {
            // var_dump($nama, $nodok);die();
            $info = array(
                'status' => 'E',
                'updateby' => $nama,
                'updatedate' => date('Y-m-d H:i:s'),
            );
            $this->db->where('nodokref', $nodok);
            $this->db->update('sc_trx.po_mst', $info);
        }

        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = $enc_nik;
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_full($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
        $data['list_tmp_po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
        $data['list_tmp_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
        $data['oldStatus'] = $oldStatus;
        $data['nextStatus'] = $nextStatus;
        $data['nodoksppb'] = $encNodok;

        $data['trx_po_pembayaran'] = $this->m_pembelian->q_po_pembayaran('trx', $nodok)->result();
        $parama1 = " and nodok='$nodok'";

        $data['perawatan_mst_lampiran'] = $this->m_pembelian->q_po_mst_lampiran('trx', $parama1)->result();
        $this->template->display('ga/pembelian/v_approval_quotation', $data);
    }

    function approval_po_atk($encNodok, $oldStatus, $nextStatus)
    {
        $nodok = $this->encrypt->decode(hex2bin($encNodok));

        $nama = trim($this->session->userdata('nik'));
        $data['title'] = 'APPROVAL PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";
        $param_dtlref_query = " and nodok='x'";
        $param_cekmapdtlref = " and nodok='$nama' and status<>'M'";

        $param_trxapprov = " and nodok='$nodok' and status in ('P','D','C','H')";
        $cek_trxapprov = $this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodoktmp='$nodok' and nodok = '$nama'";
        $param4_first = " and nodok='$nama'";
        $cek_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
        $cek_first_nik = $this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();

        if ($cek_first == 0) {
            $info = array(
                'status' => 'E',
                'updateby' => $nama,
                'updatedate' => date('Y-m-d H:i:s'),
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_mst', $info);
        }

        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = $enc_nik;
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit_full($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
        $data['list_tmp_po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
        $data['list_tmp_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->row_array();
        $data['oldStatus'] = $oldStatus;
        $data['nextStatus'] = $nextStatus;

        $data['trx_po_pembayaran'] = $this->m_pembelian->q_po_pembayaran('trx', $nodok)->result();
        $parama1 = " and nodok='$nodok'";

        $data['perawatan_mst_lampiran'] = $this->m_pembelian->q_po_mst_lampiran('trx', $parama1)->result();
        $this->template->display('ga/pembelian/v_approval_po', $data);
    }

    function detail_po_atk($enc_nodok)
    {
        $nodok = $this->encrypt->decode(hex2bin($enc_nodok));
        $nama = $this->session->userdata('nik');
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param2_1 = " and nodok='$nodok'";
        $param_trx_po = " and nodok='$nodok'";
        $param_dtlref_query = "and nodok='xaeradFAWEFADSFAS3eadAEawdf123sfQESEDGASD'";
        $param_cekmapdtlref = " and nodok='x'";

        $data['title'] = 'DETAIL ORDER PEMBELIAN ATK';
        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_trx_po_mst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->result();
        $data['list_trx_po_dtl'] = $this->m_pembelian->q_trx_po_dtl_param($param_trx_po)->result();
        $data['list_trx_po_dtlref'] = $this->m_pembelian->q_trx_po_dtlref_param($param_trx_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_trx_po)->num_rows();
        $data['list_trx_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->row_array();
        $data['trx_po_pembayaran'] = $this->m_pembelian->q_po_pembayaran('trx', $nodok)->result();
        $parama1 = " and nodok='$nodok'";

        $data['perawatan_mst_lampiran'] = $this->m_pembelian->q_po_mst_lampiran('trx', $parama1)->result();
        $this->template->display('ga/pembelian/v_detail_po', $data);
    }

    function batal_po_atk($enc_nodok)
    {
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $nama = trim($this->session->userdata('nik'));
        $data['title'] = 'BATAL PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";
        $param_dtlref_query = " and nodok='x'";
        $param_cekmapdtlref = " and nodok='$nama' and status<>'M'";

        $param_trxapprov = " and nodok='$nodok' and status in ('P','H')";
        $cek_trxapprov = $this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodoktmp='$nodok'";
        $param4_first = " and nodok='$nama'";
        $cek_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
        $cek_first_nik = $this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();


        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_pembelian/edit_failed_doc/$nodokfirst");
        } else {
            $info = array(
                'status' => 'C',
                'cancelby' => $nama,
                'canceldate' => date('Y-m-d H:i:s'),
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_mst', $info);
        }

        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
        $data['list_tmp_po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
        $data['list_tmp_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();

        $this->template->display('ga/pembelian/v_batal_po', $data);
    }

    function hangus_po_atk($enc_nodok, $oldStatus)
    {
        $nodok = $this->encrypt->decode(hex2bin($enc_nodok));

        $nama = trim($this->session->userdata('nik'));
        $data['title'] = 'HANGUS PEMBELIAN/PURCHASE ORDER (PO)';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_tmp_po = " and nodok='$nama'";
        $param_dtlref_query = " and nodok='KSDJFAPSFJOPAOSJNDFPNJASDPF'";
        $param_cekmapdtlref = " and nodok='$nama' and status<>'M'";


        $paramerror = " and userid='$nama'";
        $dtlerror = $this->m_pembelian->q_trxerror($paramerror)->row_array();
        if (isset($dtlerror['description'])) {
            $errordesc = trim($dtlerror['description']);
        } else {
            $errordesc = '';
        }

        if ($this->uri->segment(5) != "") {
            $data['message'] = "<div class='alert alert-info'>$errordesc</div>";
        } else {
            $data['message'] = "";
        }


        $param_trxapprov = " and nodok='$nodok' and status in ('U')";
        $cek_trxapprov = $this->m_pembelian->q_trx_po_mst_param($param_trxapprov)->num_rows();
        if ($cek_trxapprov > 0) {
            redirect("ga/pembelian/form_pembelian/process_fail/$nodok");
        }
        /* REDIRECT JIKA USER LAIN KALAH CEPAT */
        $param3_first = " and nodoktmp='$nodok'";
        $param4_first = " and nodok='$nama'";
        $cek_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->num_rows();
        $cek_first_nik = $this->m_pembelian->q_tmp_po_mst_param($param4_first)->num_rows();
        $dtl_first = $this->m_pembelian->q_tmp_po_mst_param($param3_first)->row_array();


        if ($cek_first > 0) {
            $nodokfirst = trim($dtl_first['nodok']);
            redirect("ga/pembelian/form_pembelian/hangus_failed_doc/$nodokfirst");
        } else {
            $info = array(
                'status' => 'H',
                'hangusby' => $nama,
                'hangusdate' => date('Y-m-d H:i:s'),
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_mst', $info);
        }

        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_tmp_po_mst'] = $this->m_pembelian->q_tmp_po_mst_param($param_tmp_po)->result();
        $data['list_tmp_po_dtl'] = $this->m_pembelian->q_tmp_po_dtl_param($param_tmp_po)->result();
        $data['list_tmp_po_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_tmp_po)->num_rows();
        $data['list_tmp_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['oldStatus'] = $oldStatus;
        $data['encNik'] = $enc_nik;

        $this->template->display('ga/pembelian/v_hangus_po', $data);
        $this->m_pembelian->q_deltrxerror($paramerror);
    }


    function inquiry_pembelian()
    {
        $data['title'] = "FILTER HISTORY LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR";
        $data['kanwil'] = $this->m_pembelian->q_gudangwilayah()->result();
        $this->template->display('ga/pembelian/v_filter_his_po', $data);
    }

    function dtl_inquiry_pembelian()
    {

        //$data['title']=$this->encryption->encrypt('HALO');
        //$data['title2']=$this->encryption->decrypt('HALO');
        //$this->encrypt->encode($smtp_pass);
        //$this->encrypt->decode($smtp_pass);
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.H.2';
        $versirelease = 'I.G.H.2/ALPHA.001';
        $userid = $this->session->userdata('nama');
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        if ($versidb <> $versirelease) {
            $infoversiold = array(
                'vreleaseold' => $versidb,
                'vdateold' => $vdb['vdate'],
                'vauthorold' => $vdb['vauthor'],
                'vketeranganold' => $vdb['vketerangan'],
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversiold);

            $infoversi = array(
                'vrelease' => $versirelease,
                'vdate' => date('2017-07-10 11:18:00'),
                'vauthor' => 'FIKY',
                'vketerangan' => 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => $userid,
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversi);
        }
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */


        if ($this->uri->segment(4) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(4) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(4) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(4) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(4) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(4) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(4) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        if (empty($thn)) {
            $tahun = date('Y');
            $bulan = date('m');
            $tgl = $bulan . $tahun;
        } else {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
        }
        switch ($bulan) {
            case '01':
                $bul = 'Januari';
                break;
            case '02':
                $bul = 'Februari';
                break;
            case '03':
                $bul = 'Maret';
                break;
            case '04':
                $bul = 'April';
                break;
            case '05':
                $bul = 'Mei';
                break;
            case '06':
                $bul = 'Juni';
                break;
            case '07':
                $bul = 'Juli';
                break;
            case '08':
                $bul = 'Agustus';
                break;
            case '09':
                $bul = 'September';
                break;
            case '10':
                $bul = 'Oktober';
                break;
            case '11':
                $bul = 'November';
                break;
            case '12':
                $bul = 'Desember';
                break;
        }

        //echo $tgl;
        $nama = $this->session->userdata('nik');
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        //$kdcabang=trim($this->session->userdata('loccode'));
        //$param1=" and loccode='$kdcabang'";

        $tgl = explode(' - ', trim($this->input->post('tgl')));
        $data['tgl1'] = $tgl1 = date('Y-m-d', strtotime(trim($tgl[0])));
        $data['tgl2'] = $tgl2 = date('Y-m-d', strtotime(trim($tgl[1])));
        $data['kdcabang'] = $kdcabang = trim(strtoupper($this->input->post('loccode')));
        if (empty($kdcabang)) {
            redirect("ga/pembelian/inquiry_pembelian");
        }

        $param2_1 = " and (to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2') and loccode='$kdcabang' and status='P'";
        $data['title'] = "HISTORY LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR $kdcabang";
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_po'] = $this->m_pembelian->q_listpembelian_param($param2_1)->result();
        //$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $this->template->display('ga/pembelian/v_list_po_historis', $data);
    }

    function filter_po_receipt()
    {
        $data['title'] = "FILTER PENERIMAAN BARANG DARI PEMBELIAN / PO RECEIPT";
        $data['kanwil'] = $this->m_pembelian->q_gudangwilayah()->result();
        $this->template->display('ga/pembelian/v_filter_po_receipt', $data);
    }

    function dtl_po_receipt()
    {

        //$data['title']=$this->encryption->encrypt('HALO');
        //$data['title2']=$this->encryption->decrypt('HALO');
        //$this->encrypt->encode($smtp_pass);
        //$this->encrypt->decode($smtp_pass);
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.H.3';
        $versirelease = 'I.G.H.2/ALPHA.001';
        $userid = $this->session->userdata('nama');
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        if ($versidb <> $versirelease) {
            $infoversiold = array(
                'vreleaseold' => $versidb,
                'vdateold' => $vdb['vdate'],
                'vauthorold' => $vdb['vauthor'],
                'vketeranganold' => $vdb['vketerangan'],
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversiold);

            $infoversi = array(
                'vrelease' => $versirelease,
                'vdate' => date('2017-07-10 11:18:00'),
                'vauthor' => 'FIKY',
                'vketerangan' => 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => $userid,
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversi);
        }
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */


        if ($this->uri->segment(4) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(4) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(4) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(4) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(4) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(4) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(4) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        if (empty($thn)) {
            $tahun = date('Y');
            $bulan = date('m');
            $tgl = $bulan . $tahun;
        } else {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
        }
        switch ($bulan) {
            case '01':
                $bul = 'Januari';
                break;
            case '02':
                $bul = 'Februari';
                break;
            case '03':
                $bul = 'Maret';
                break;
            case '04':
                $bul = 'April';
                break;
            case '05':
                $bul = 'Mei';
                break;
            case '06':
                $bul = 'Juni';
                break;
            case '07':
                $bul = 'Juli';
                break;
            case '08':
                $bul = 'Agustus';
                break;
            case '09':
                $bul = 'September';
                break;
            case '10':
                $bul = 'Oktober';
                break;
            case '11':
                $bul = 'November';
                break;
            case '12':
                $bul = 'Desember';
                break;
        }

        //echo $tgl;
        $nama = $this->session->userdata('nik');
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        //$kdcabang=trim($this->session->userdata('loccode'));
        //$param1=" and loccode='$kdcabang'";

        $tgl = explode(' - ', trim($this->input->post('tgl')));
        $data['tgl1'] = $tgl1 = date('Y-m-d', strtotime(trim($tgl[0])));
        $data['tgl2'] = $tgl2 = date('Y-m-d', strtotime(trim($tgl[1])));
        $data['kdcabang'] = $kdcabang = trim(strtoupper($this->input->post('loccode')));
        if (empty($kdcabang)) {
            redirect("ga/pembelian/filter_po_receipt");
        }

        $param2_1 = " and (to_char(inputdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2') and loccode='$kdcabang' and status='P'";
        $data['title'] = "DETAIL LIST PO/PEMBELIAN BARANG/ALAT TULIS KANTOR $kdcabang";
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_po'] = $this->m_pembelian->q_listpembelian_param($param2_1)->result();
        //$data['list_stkgdw']=$this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $this->template->display('ga/pembelian/v_list_po_final', $data);
    }

    function po_receipt($enc_nodok)
    {
        if ($this->uri->segment(4) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(4) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(4) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(4) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(4) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(4) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(4) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = '';
        $nodok = $this->encrypt->decode(hex2bin($enc_nodok));
        $data['title'] = "LIST TERIMA BARANG PO RECEIPT $nodok";
        $data['nodok'] = $nodok;
        $param2_1 = " and nodok='$nodok'";
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['dtl_po'] = $this->m_pembelian->q_listpembelian_param($param2_1)->row_array();
        $data['qtypo'] = "QTY PO OUTSTANDING: 10";
        $data['list_po_receipt'] = $this->m_pembelian->q_po_receipt($nodok)->result();
        $this->template->display('ga/pembelian/v_list_po_receipt', $data);
    }

    function save_po_receipt()
    {
        $nodokpo = strtoupper(trim($this->input->post('$nodokpo')));
        $nama = $this->session->userdata('nik');
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $qtyreceipt = (strtoupper(trim($this->input->post('qtyreceipt'))) == '' ? '0' : strtoupper(trim($this->input->post('qtyreceipt'))));
        $enc_nodok = bin2hex(trim($this->encrypt->encode($nodokpo)));
        $keterangan = strtoupper($this->input->post('keterangan'));
        $inputdate = date('Y-m-d H:i:s');
        $inputby = $nama;

        if ($type == 'INPUT') {
            if (empty($nodokpo)) {
                redirect("ga/pembelian/po_receipt/$enc_nodok/fail_input");
            }
            $info = array(
                'nodokpo' => $nodokpo,
                'nodokref' => '',
                'qtyreceipt' => $qtyreceipt,
                'receiptdate' => $inputdate,
                'status' => $status,
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,


            );
            $this->db->insert('sc_trx.po_receipt', $info);
            redirect("ga/pembelian/po_receipt/$enc_nodok/inp_succes");

        } else if ($type == 'EDIT') {
            $info = array(
                'nodokref' => $nodokref,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'stockcode' => $stockcode,
                'loccode' => $loccode,
                'desc_barang' => $desc_barang,
                'qtyunitprice' => $qtyunitprice,
                'qtytotalprice' => $qtytotalprice,
                'qtypo' => $qtypo,
                'qtyreceipt' => $qtyreceipt,
                'qtyunit' => $qtyunit,
                'kdgroupsup' => $kdgroupsup,
                'kdsupplier' => $kdsupplier,
                'kdsubsupplier' => $kdsubsupplier,
                'status' => 'A',
                'keterangan' => $keterangan,
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/inp_succes");
        } else if ($type == 'APPROVAL') {
            $info = array(
                'status' => 'P',
                'approvaldate' => $inputdate,
                'approvalby' => $inputby,
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/app_succes");
        } else if ($type == 'DELETE') {
            $info = array(
                'status' => 'C',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/del_succes");
        } else {
            redirect("ga/pembelian/form_pembelian");
        }

    }


    function history_pricelist()
    {
        $data['title'] = "HISTORY PRICE LIST TERBARU ";
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];
        $nama = $this->session->userdata('nik');
        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.H.5';
        $versirelease = 'I.G.H.5/ALPHA.001';
        $userid = $this->session->userdata('nama');
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        if ($versidb <> $versirelease) {
            $infoversiold = array(
                'vreleaseold' => $versidb,
                'vdateold' => $vdb['vdate'],
                'vauthorold' => $vdb['vauthor'],
                'vketeranganold' => $vdb['vketerangan'],
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversiold);

            $infoversi = array(
                'vrelease' => $versirelease,
                'vdate' => date('2017-07-10 11:18:00'),
                'vauthor' => 'FIKY',
                'vketerangan' => 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => $userid,
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversi);
        }
        $vdb = $this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */


        if ($this->uri->segment(4) == "bc_failed")
            $data['message'] = "<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if ($this->uri->segment(4) == "rep_succes")
            $data['message'] = "<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if ($this->uri->segment(4) == "inp_succes")
            $data['message'] = "<div class='alert alert-success'>Data Succes Di Input</div>";
        else if ($this->uri->segment(4) == "del_succes")
            $data['message'] = "<div class='alert alert-success'>Delete Succes</div>";
        else if ($this->uri->segment(4) == "del_failed")
            $data['message'] = "<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if ($this->uri->segment(4) == "edit_failed")
            $data['message'] = "<div class='alert alert-danger'>User masih ada dokumen yang belum selesai</div>";
        else if ($this->uri->segment(4) == "edit_failed_doc") {
            $nodokfirst = $this->uri->segment(5);
            $data['message'] = "<div class='alert alert-danger'>Dokumen sedang diakses user $nodokfirst</div>";
        } else if ($this->uri->segment(4) == "process_fail") {
            $nodokfirst = $this->uri->segment(5);
            $data['message'] = "<div class='alert alert-danger'>Dokumen Sudah Terproses No Rev:: $nodokfirst</div>";
        } else if ($this->uri->segment(4) == "inp_kembar")
            $data['message'] = "<div class='alert alert-danger'>Kode Schema Sudah Ada Sebelumnya</div>";
        else if ($this->uri->segment(4) == "wrong_format")
            $data['message'] = "<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message'] = "<div class='alert alert-success'></div>";
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        if (empty($thn)) {
            $tahun = date('Y');
            $bulan = date('m');
            $tgl = $bulan . $tahun;
        } else {
            $tahun = $thn;
            $bulan = $bln;
            $tgl = $bulan . $tahun;
        }
        switch ($bulan) {
            case '01':
                $bul = 'Januari';
                break;
            case '02':
                $bul = 'Februari';
                break;
            case '03':
                $bul = 'Maret';
                break;
            case '04':
                $bul = 'April';
                break;
            case '05':
                $bul = 'Mei';
                break;
            case '06':
                $bul = 'Juni';
                break;
            case '07':
                $bul = 'Juli';
                break;
            case '08':
                $bul = 'Agustus';
                break;
            case '09':
                $bul = 'September';
                break;
            case '10':
                $bul = 'Oktober';
                break;
            case '11':
                $bul = 'November';
                break;
            case '12':
                $bul = 'Desember';
                break;
        }
        $this->template->display('ga/pembelian/v_list_master_pricelist', $data);

    }

    function pagin_history_pricelist()
    {
        $nama = $this->session->userdata('nik');

        /* akses approve atasan */
        $ceknikatasan1 = $this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2 = $this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1 = $this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2 = $this->m_akses->list_aksesatasan2($nama)->result();

        $userinfo = $this->m_akses->q_user_check()->row_array();
        $userhr = $this->m_akses->list_aksesperdep()->num_rows();
        $level_akses = strtoupper(trim($userinfo['level_akses']));
        // or $level_akses=='A'
        if (($ceknikatasan1) > 0 and $userhr == 0) {
            $param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";
            $param_list2 = 1;
        } else if (($ceknikatasan2) > 0 and $userhr == 0) {
            $param_list_akses = " and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
            $param_list2 = 1;
        } else {
            $param_list_akses = " and nik='$nama' ";
            $param_list2 = 0;
        }

        $data['nama'] = $nama;
        $data['userhr'] = $userhr;
        $data['level_akses'] = $level_akses;
        /* END APPROVE ATASAN */


        $list = $this->m_pembelian->get_list_pricelist();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lpo) {
            $enc_stockcode = bin2hex($this->encrypt->encode(trim($lpo->stockcode)));
            $id = trim($lpo->id);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = trim($lpo->stockcode);
            $row[] = trim($lpo->nmbarang);
            $row[] = ' <span class="pull-right" >' . number_format($lpo->qtykecil) . ' </span>';
            $row[] = trim($lpo->nmsatkecil);
            $row[] = ' <span class="pull-right" >' . number_format($lpo->unitprice) . ' </span>';
            if (isset($lpo->pricedate)) {
                $row[] = date('d-m-Y H:i:s', strtotime(trim($lpo->pricedate)));
            } else {
                $row[] = '';
            }
            $row[] = trim($lpo->nodokref);
            $row[] =
                '<a class="btn btn-sm btn-default" href="' . site_url('ga/pembelian/edit_pricelst') . '/' . $id . '" title="Edit PRICE LIST"><i class="glyphicon glyphicon-search"></i> DETAIL </a>';
            /*
            <a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
            <a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
            <a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a>
            <a  data-url="'.site_url('ga/pembelian/form_pembelian/modal_edit_po_atk').'/'.trim($lpo->nodok).'" data-toggle="modal" data-target=".pp" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT
            */
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pembelian->q_listpricelist()->num_rows(),
            "recordsFiltered" => $this->m_pembelian->q_listpricelist()->num_rows(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
        //echo '1342';
    }


    function edit_pricelst()
    {
        $id = trim($this->uri->segment(4));
        $nama = $this->session->userdata('nik');
        ///$data['title']='Input/Edit Supplier Master PO';
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $dtlnik = $this->m_akses->list_karyawan_index($nama)->row_array();
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $pricelstparam = " and id='$id'";



        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = bin2hex($this->encrypt->encode($nama));
        $data['list_scgroupatk'] = $this->m_pembelian->q_scgroup_atk()->result(); //GROUP ATK
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_supplier()->result(); //GROUP SUPPLIER
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['pricelst'] = $this->m_pembelian->q_pricelist_param($pricelstparam)->row_array();
        $this->template->display('ga/pembelian/v_edit_pricelst', $data);
    }

    function save_history_pricelst()
    {
        $id = trim($this->input->post('id'));
        $type = trim($this->input->post('type'));
        $unitprice = trim($this->input->post('unitprice'));
        $kdgroupsupplier = strtoupper(trim($this->input->post('kdgroupsupplier')));
        $kdsupplier = strtoupper(trim($this->input->post('kdsupplier')));
        $kdsubsupplier = strtoupper(trim($this->input->post('kdsubsupplier')));
        $kdgroupbarang = strtoupper(trim($this->input->post('kdgroupbarang')));
        $kdsubgroupbarang = strtoupper(trim($this->input->post('kdsubgroupbarang')));
        $stockcode = strtoupper(trim($this->input->post('stockcode')));
        $pkp = strtoupper(trim($this->input->post('pkp')));
        $qtykecil = strtoupper(trim($this->input->post('qtykecil')));
        $satkecil = strtoupper(trim($this->input->post('satkecil')));
        $unitprice = strtoupper(trim($this->input->post('unitprice')));
        $payterm = strtoupper(trim($this->input->post('payterm')));
        $nodokref = strtoupper(trim($this->input->post('nodokref')));

        if ($type == 'EDIT_PRICELST') {
            $info = array(
                'branch          ' => $branch,
                'jenisprice      ' => 'I',
                'satkecil        ' => $satkecil,
                'qtykecil        ' => $qtykecil,
                'payterm         ' => $payterm,
                'unitprice       ' => $unitprice,
                'updateby        ' => $updateby,
                'updatedate      ' => $updatedate,
                'nodokref        ' => $nodokref,
                'pkp             ' => $pkp,
                'exppn           ' => $exppn,

            );
            $this->db->where('id', $id);
            $this->db->update('sc_mst.pricelst', $info);
            redirect("ga/pembelian/history_pricelist");
        } else if ($type == 'DELETE') {
            $info = array(
                'status' => 'C',
            );
            $this->db->where('nodok', $nodok);
            $this->db->update('sc_trx.po_order', $info);
            redirect("ga/pembelian/form_pembelian/del_succes");
        } else {
            redirect("ga/pembelian/form_pembelian");
        }

    }

    function pembayaran_po($encNodok)
    {
        $nodok = $this->encrypt->decode(hex2bin($encNodok));
        $nama = $this->session->userdata('nik');
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_trx_po = " and nodok='$nodok'";
        $param_dtlref_query = "and nodok='xaeradFAWEFADSFAS3eadAEawdf123sfQESEDGASD'";
        $param_cekmapdtlref = " and nodok='x'";

        $po_pembayaran_tmp = function () use ($nodok, $nama) {
            return $this->db->get_where('sc_tmp.po_pembayaran', array('nodokref' => $nodok))->result()[0]->inputby;
        };

        if ($po_pembayaran_tmp() != null && trim($po_pembayaran_tmp()) != $nama) {
            redirect("ga/pembelian/form_pembelian/fail_user_exist");
        }

        $data['title'] = 'INPUT PEMBAYARAN ATK';
        $data['nodok'] = $nodok;
        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = $enc_nik;
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_trx_po_mst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->result();
        $data['list_trx_po_dtl'] = $this->m_pembelian->q_trx_po_dtl_param($param_trx_po)->result();
        $data['list_trx_po_dtlref'] = $this->m_pembelian->q_trx_po_dtlref_param($param_trx_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_trx_po)->num_rows();
        $data['list_trx_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->row_array();
        $data['trx_po_pembayaran'] = $this->m_pembelian->q_po_pembayaran('trx', $nodok)->result();
        $data['tmp_po_pembayaran'] = $this->m_pembelian->q_po_pembayaran('tmp', $nodok)->result();

        $this->template->display('ga/pembelian/v_input_po_pembayaran', $data);
    }

    function save_input_po_pembayaran()
    {
        $nodokref = strtoupper(trim($this->input->post('nodokref')));
        $paymentId = strtoupper(trim($this->input->post('nomorpembayaran')));
        $keterangan = strtoupper(trim($this->input->post('keterangan')));
        $paymentDate = date('Y-m-d', strtotime(trim($this->input->post('tgl'))));
        $paymentType = trim($this->input->post('tipe_pembayaran'));
        $nominal = trim($this->input->post('nnetto'));

        $isExist = $this->db->get_where('sc_tmp.po_pembayaran', array('nodokref' => $nodokref, 'nodok' => $paymentId, 'payment_type' => 'DP'))->num_rows() > 0;

        if ($isExist):
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal disimpan, DP atau nomor pembayaran sudah ada', 'type' => 'error')));
            return;
        endif;

        $this->db->insert('sc_tmp.po_pembayaran', array(
            'nodokref' => $nodokref,
            'nodok' => $paymentId,
            'tgl' => $paymentDate,
            'payment_type' => $paymentType,
            'nnetto' => $nominal,
            'keterangan' => $keterangan,
            'inputby' => trim($this->session->userdata('nik')),
            'inputdate' => date('Y-m-d H:i:s'),
            'status' => 'I',
            'nodoktmp' => $paymentId
        ));
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil disimpan', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal disimpan', 'type' => 'error')));
    }

    function update_input_po_pembayaran()
    {
        $id = trim($this->input->post('id'));
        $nodokref = strtoupper(trim($this->input->post('nodokref')));
        $paymentId = strtoupper(trim($this->input->post('nomorpembayaran')));
        $keterangan = strtoupper(trim($this->input->post('keterangan')));
        $paymentDate = date('Y-m-d', strtotime(trim($this->input->post('tgl'))));
        $paymentType = trim($this->input->post('tipe_pembayaran'));
        $nominal = trim($this->input->post('nnetto'));

        $updateData = array(
            'updateby' => trim($this->session->userdata('nik')),
            'updatedate' => date('Y-m-d H:i:s'),
        );

        if (!empty($paymentDate)) {
            $updateData['tgl'] = $paymentDate;
        }
        if (!empty($paymentType)) {
            $updateData['payment_type'] = $paymentType;
        }
        if (!empty($nominal)) {
            $updateData['nnetto'] = $nominal;
        }
        if (!empty($keterangan)) {
            $updateData['keterangan'] = $keterangan;
        }

        $this->db->where('nodokref', $nodokref);
        $this->db->where('nodok', $paymentId);
        $this->db->where('id', $id);
        $this->db->update('sc_tmp.po_pembayaran', $updateData);

        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil disimpan', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal disimpan', 'type' => 'error')));
    }

    function delete_input_po_pembayaran_temp()
    {
        $id = trim($this->input->post('id'));
        $this->db->where('id', $id);
        $this->db->delete('sc_tmp.po_pembayaran');
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil di hapus', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal di hapus', 'type' => 'error')));
    }

    function cancel_input_po_pembayaran_temp()
    {
        $nodokref = trim($this->input->post('nodokref'));
        $this->db->where('nodokref', $nodokref);
        $this->db->delete('sc_tmp.po_pembayaran');
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil di hapus', 'type' => 'success', 'link' => base_url('ga/pembelian/form_pembelian'))));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal di hapus', 'type' => 'error')));
    }

    function final_save_po_pembayaran()
    {
        $nodokref = trim($this->input->post('nodokref'));
        $this->db->trans_start();
        $this->db->where('nodokref', $nodokref);
        $query = $this->db->get('sc_tmp.po_pembayaran');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $insertData = array(
                    'nodokref' => $row->nodokref,
                    'nodok' => $row->nodok,
                    'status' => 'P',
                    'id' => $row->id,
                    'tgl' => $row->tgl,
                    'payment_type' => $row->payment_type,
                    'nnetto' => $row->nnetto,
                    'keterangan' => $row->keterangan,
                    'inputby' => $row->inputby,
                    'inputdate' => $row->inputdate,
                    'updateby' => $row->updateby,
                    'updatedate' => $row->updatedate,
                    'nodoktmp' => $row->nodoktmp
                );
                $this->db->insert('sc_trx.po_pembayaran', $insertData);
            }
        }
        $this->db->where('nodokref', $nodokref);
        $this->db->delete('sc_tmp.po_pembayaran');
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil di simpan', 'type' => 'success', 'link' => base_url('ga/pembelian/form_pembelian/payment_success'))));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal di simpan', 'type' => 'error')));
    }

    function inputpo_faktur()
    {
        $encNodok = trim($this->uri->segment(4));

        $nodok = $this->encrypt->decode(hex2bin($encNodok));
        $nama = $this->session->userdata('nik');
        $kdcabang = trim($this->session->userdata('loccode'));
        $param1 = " and loccode='$kdcabang'";
        $param_trx_po = " and nodok='$nodok'";
        $param_dtlref_query = "and nodok='xaeradFAWEFADSFAS3eadAEawdf123sfQESEDGASD'";
        $param_cekmapdtlref = " and nodok='x'";

        $po_faktur_tmp = function () use ($nodok, $nama) {
            return $this->db->get_where('sc_tmp.po_mst_lampiran', array('nodok' => $nodok))->result()[0]->inputby;
        };

        if ($po_faktur_tmp() != null && trim($po_faktur_tmp()) != $nama) {
            redirect("ga/pembelian/form_pembelian/fail_user_exist");
        }

        $data['title'] = 'INPUT FAKTUR';
        $data['nodok'] = $nodok;
        $enc_nik = bin2hex($this->encrypt->encode($nama));
        $data['enc_nik'] = $enc_nik;
        $data['list_scgroup'] = $this->m_pembelian->q_scgroup_atk()->result();
        $data['list_scsubgroup'] = $this->m_pembelian->q_scsubgroup()->result();
        $data['list_mstbarangatk'] = $this->m_pembelian->q_mstbarang_atk()->result();
        $paramx = '';
        $data['trxqtyunit'] = $this->m_pembelian->q_trxqtyunit($paramx)->result();
        $data['list_stkgdw'] = $this->m_pembelian->q_stkgdw_param1($param1)->result();
        $data['list_msupplier'] = $this->m_pembelian->q_msupplier()->result();
        $data['list_msubsupplier'] = $this->m_pembelian->q_msubsupplier()->result();
        $data['trxsupplier'] = $this->m_pembelian->q_trxsupplier()->result();
        $data['list_trx_po_mst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->result();
        $data['list_trx_po_dtl'] = $this->m_pembelian->q_trx_po_dtl_param($param_trx_po)->result();
        $data['list_trx_po_dtlref'] = $this->m_pembelian->q_trx_po_dtlref_param($param_trx_po)->result();
        $data['row_dtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_trx_po)->num_rows();
        $data['list_trx_po_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->result();
        $data['row_dtlref_query'] = $this->m_pembelian->q_dtlref_po_query_param_null($param_dtlref_query)->num_rows();
        $data['cek_full_mappdtlref'] = $this->m_pembelian->q_tmp_po_dtlref_param($param_cekmapdtlref)->num_rows();
        $data['dtlmst'] = $this->m_pembelian->q_trx_po_mst_param($param_trx_po)->row_array();
        $data['trx_po_pembayaran'] = $this->m_pembelian->q_po_pembayaran('trx', $nodok)->result();
        $parama1 = " and nodok='$nodok'";

        $data['perawatan_mst_lampiran'] = $this->m_pembelian->q_po_mst_lampiran('tmp', $parama1)->result();
        $this->template->display('ga/pembelian/v_input_faktur_po', $data);
    }

    function save_input_po_faktur()
    {
        $nodok = trim($this->input->post('nodok'));
        $paymentId = trim($this->input->post('nodokref'));
        $keterangan = trim($this->input->post('keterangan'));
        $paymentDate = date('Y-m-d', strtotime(trim($this->input->post('tgl'))));
        $nominal = trim($this->input->post('nnetto'));
        $idfaktur = strtoupper(trim($this->input->post('idfaktur')));

        $this->db->insert('sc_tmp.po_mst_lampiran', array(
            'nodok' => $nodok,
            'nodokref' => $paymentId,
            'idfaktur' => $idfaktur,
            'tgl' => $paymentDate,
            'nnetto' => $nominal,
            'keterangan' => $keterangan,
            'inputby' => trim($this->session->userdata('nik')),
            'inputdate' => date('Y-m-d H:i:s'),
            'status' => 'I',
        ));
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil disimpan', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal disimpan', 'type' => 'error')));
    }

    function update_input_po_faktur()
    {
        $id = trim($this->input->post('id'));
        $nodok = trim($this->input->post('nodok'));
        $paymentId = trim($this->input->post('nodokref'));
        $keterangan = trim($this->input->post('keterangan'));
        $paymentDate = date('Y-m-d', strtotime(trim($this->input->post('tgl'))));
        $nominal = trim($this->input->post('nnetto'));
        $idfaktur = trim($this->input->post('idfaktur'));

        $updateData = array(
            'updateby' => trim($this->session->userdata('nik')),
            'updatedate' => date('Y-m-d H:i:s'),
        );

        if (!empty($paymentDate)) {
            $updateData['tgl'] = $paymentDate;
        }
        if (!empty($nominal)) {
            $updateData['nnetto'] = $nominal;
        }
        if (!empty($keterangan)) {
            $updateData['keterangan'] = $keterangan;
        }
        if (!empty($idfaktur)) {
            $updateData['idfaktur'] = $idfaktur;
        }

        $this->db->where('nodok', $nodok);
        $this->db->where('nodokref', $paymentId);
        $this->db->where('id', $id);
        $this->db->update('sc_tmp.po_mst_lampiran', $updateData);

        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil disimpan', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal disimpan', 'type' => 'error')));
    }


    function delete_input_po_faktur_temp()
    {
        $id = trim($this->input->post('id'));
        $this->db->where('id', $id);
        $this->db->delete('sc_tmp.po_mst_lampiran');
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil di hapus', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal di hapus', 'type' => 'error')));
    }

    function detail_po_mst_lampiran()
    {
        $data['title'] = 'DATA PO INPUT FAKTUR';

        $strtrimref = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        if (empty($strtrimref)) {
            redirect("ga/pembelian/index_spk");
        }

        $parama1 = " and strtrimref='$strtrimref'";
        $data['po_detail_lampiran'] = $this->m_pembelian->q_po_dtl_lampiran('trx', $parama1)->result();
        $data['dtl_mst'] = $this->m_pembelian->q_po_mst_lampiran('trx', $parama1)->row_array();
        $data['dtllamp_at'] = $this->m_pembelian->q_lampiran_at('trx', $parama1)->result();
        $this->template->display('ga/pembelian/v_detail_po_mst_lampiran', $data);
    }

    function edit_po_mst_lampiran()
    {
        $data['title'] = 'DATA PO INPUT FAKTUR';

        $strtrimref = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        if (empty($strtrimref)) {
            redirect("ga/pembelian/index_spk");
        }

        $parama1 = " and strtrimref='$strtrimref'";
        $data['po_detail_lampiran'] = $this->m_pembelian->q_po_dtl_lampiran('tmp', $parama1)->result();
        $data['dtl_mst'] = $this->m_pembelian->q_po_mst_lampiran('tmp', $parama1)->row_array();
        $data['dtllamp_at'] = $this->m_pembelian->q_lampiran_at('tmp', $parama1)->result();
        $this->template->display('ga/pembelian/v_edit_po_mst_lampiran', $data);
    }

    function add_attachment_po()
    {
        $nama = $this->session->userdata('nik');
        $nodok = strtoupper(trim($this->input->post('nodok')));
        $nodokref = strtoupper(trim($this->input->post('nodokref')));
        $idfaktur = strtoupper(trim($this->input->post('idfaktur')));
        $enc_strtrimref = strtoupper(trim($this->input->post('strtrimref')));
        if (empty($enc_strtrimref)) {
            // redirect("ga/inventaris/form_spk");
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Paramater tidak lengkap ', 'type' => 'error')));
            return;
        }

        if (!empty($_FILES['userFiles']['name'])) {
            $filesCount = count($_FILES['userFiles']['name']);
            for ($index = 0; $index < $filesCount; $index++) {
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$index];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$index];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$index];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$index];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$index];

                $uploadPath = './assets/attachment/att_po/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|zip|rar|doc|docx|ppt|pptx|xls|xlsx';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $info[$index]['file_name'] = $fileData['file_name'];
                    $info[$index]['file_type'] = $fileData['file_type'];
                    $info[$index]['full_path'] = base_url('/assets/attachment/att_po/' . $fileData['file_name']);
                    $info[$index]['orig_name'] = $fileData['orig_name'];
                    $info[$index]['file_ext'] = $fileData['file_ext'];
                    $info[$index]['file_size'] = $fileData['file_size'];
                    $info[$index]['ref_type'] = 'AT';
                    $info[$index]['nodok'] = $nodok;
                    $info[$index]['nodokref'] = $nodokref;
                    $info[$index]['idfaktur'] = $idfaktur;
                    $info[$index]['inputdate'] = date("Y-m-d H:i:s");
                    $info[$index]['inputby'] = $nama;

                }
            }

            if (!empty($info)) {
                $insert = $this->m_pembelian->insert_attachment_po($info);
            }
        }

        if ($insert) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Berhasil ', 'type' => 'success')));
        } else {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Gagal Disimpan ', 'type' => 'error')));
        }

        $this->db->cache_delete('ga', 'pembelian');
        return;
    }

    function delete_attachment_po()
    {
        $file_name = trim($this->input->post('filename'));
        $enc_strtrimref = strtoupper(trim($this->input->post('strtrimref')));
        $id = $this->input->post('id');
        if (empty($enc_strtrimref)) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Paramater tidak lengkap ', 'type' => 'error')));
        }

        $target = "assets/attachment/att_po/$file_name";
        if (file_exists($target)) {
            if (unlink($target)) {
                $this->db->where('id', $id);
                $this->db->delete('sc_tmp.po_lampiran');
            }
        }
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Berhasil dihapus', 'type' => 'success')));
            return;
        }

        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Gagal Dihapus ', 'type' => 'error')));
    }

    function save_po_lampiran()
    {
        $nama = $this->session->userdata('nik');
        $idfaktur = strtoupper(trim($this->input->post('idfaktur')));
        $nnetto = strtoupper(trim($this->input->post('nnetto')));
        $nodok = strtoupper(trim($this->input->post('nodok')));
        $nodokref = strtoupper(trim($this->input->post('nodokref')));
        $keterangan = strtoupper(trim($this->input->post('keterangan')));
        $enc_strtrimref = trim($this->input->post('strtrimref'));
        $inputdate = date('Y-m-d H:i:s');
        $inputby = $nama;
        if (empty($enc_strtrimref)) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Paramater tidak lengkap ', 'type' => 'error')));
        }

        $info = array(
            'nodok       ' => $nodok,
            'nodokref    ' => $nodokref,
            'idfaktur    ' => $idfaktur,
            'keterangan  ' => $keterangan,
            'nnetto      ' => $nnetto,
            'status      ' => 'I',
            'inputdate   ' => $inputdate,
            'inputby     ' => $inputby,
        );
        $this->db->insert('sc_tmp.po_detail_lampiran', $info);
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Berhasil ', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Gagal Disimpan ', 'type' => 'error')));
    }

    function update_po_lampiran()
    {
        $nama = $this->session->userdata('nik');
        $idfaktur = strtoupper(trim($this->input->post('idfaktur')));
        $nnetto = strtoupper(trim($this->input->post('nnetto')));
        $nodok = strtoupper(trim($this->input->post('nodok')));
        $nodokref = strtoupper(trim($this->input->post('nodokref')));
        $keterangan = strtoupper(trim($this->input->post('keterangan')));
        $enc_strtrimref = trim($this->input->post('strtrimref'));
        $id = $this->input->post('id');
        $inputdate = date('Y-m-d H:i:s');
        $inputby = $nama;
        if (empty($enc_strtrimref)) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Paramater tidak lengkap ', 'type' => 'error')));
        }

        $info = array(
            'status      ' => 'E',
            'inputdate   ' => $inputdate,
            'inputby     ' => $inputby,
        );
        if (!empty($nnetto)) {
            $info['nnetto'] = $nnetto;
        }
        if (!empty($keterangan)) {
            $info['keterangan'] = $keterangan;
        }
        $this->db->where('id', $id);
        $this->db->update('sc_tmp.po_detail_lampiran', $info);
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Berhasil ', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Gagal Disimpan ', 'type' => 'error')));
    }

    function delete_po_lampiran()
    {
        $id = trim($this->input->post('id'));
        $this->db->where('id', $id);
        $this->db->delete('sc_tmp.po_detail_lampiran');
        if ($this->db->affected_rows() > 0) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data berhasil di hapus', 'type' => 'success')));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data gagal di hapus', 'type' => 'error')));
    }

    function cancel_input_po_faktur()
    {
        $nodok = trim($this->input->post('nodok'));
        $this->db->trans_start();
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_mst_lampiran');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_detail_lampiran');
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_tmp.po_lampiran');
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Berhasil Dibatalkan', 'type' => 'success', 'link' => base_url('ga/pembelian/form_pembelian'))));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Gagal Dibatalkan ', 'type' => 'error')));
    }

    function save_final_po_faktur()
    {
        $nodok = trim($this->input->post('nodok'));
        $this->db->trans_start();
        $this->db->where('nodok', $nodok);
        $this->db->update('sc_trx.po_mst', array('status' => 'F'));
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Berhasil ', 'type' => 'success', 'link' => base_url('ga/pembelian/form_pembelian'))));
            return;
        }
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(array('message' => 'Data Gagal Disimpan ', 'type' => 'error')));
    }

    function calculation_remap_detail()
    {
        $nama = $this->session->userdata('nik');
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        if ($data->key == 'KUNCI') {
            $databalik = $data->key;
            $dataprocess = $data->body;
            $dataprocess->qtyminta;
            $dataprocess->unitprice;
            $dataprocess->checkdisc;
            $dataprocess->disc1;
            $dataprocess->disc2;
            $dataprocess->disc3;
            $dataprocess->checkppn;
            $dataprocess->exppn;

            $info = array(
                'keterangan' => $dataprocess->keterangan,
                'unitprice' => $dataprocess->unitprice,
                'disc1' => $dataprocess->disc1,
                'disc2' => $dataprocess->disc2,
                'disc3' => $dataprocess->disc3,
                'pkp' => $dataprocess->checkppn,
                'exppn' => $dataprocess->exppn,
                'satminta' => $dataprocess->satminta,
                'qtyminta' => $dataprocess->qtyminta,
                'qtyminta' => 3,
                'status' => ''
            );
            //$this->db->where('id',$rowid);
            $this->db->where('nodok', $nama);
            $this->db->where('kdgroup', $dataprocess->kdgroup);
            $this->db->where('kdsubgroup', $dataprocess->kdsubgroup);
            $this->db->where('stockcode', $dataprocess->stockcode);
            $this->db->update('sc_tmp.po_dtl', $info);


            $parampodtl = " and nodok='$nama' and stockcode='$dataprocess->stockcode'";
            $dtlpodtl = $this->m_pembelian->q_tmp_po_dtl_param($parampodtl)->row_array();
            echo json_encode(array("enkript" => $databalik, "fill" => $dtlpodtl));


        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        }
    }
}