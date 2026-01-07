<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Kendaraan extends MX_Controller{

    function __construct(){
        parent::__construct();



        $this->load->model(array('m_kendaraan','master/m_akses','master/m_geo'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','Excel_generator'));

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

    function index(){
        $data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";
        $this->template->display('ga/kendaraan/v_index',$data);
    }


    /* 02 ---- Master Kendaraan & STNKB*/
    function form_mstkendaraan(){
        $data['title']="FORM MASTER KENDARAAN";
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
        else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
        else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if($this->uri->segment(4)=="inp_kembar")
            $data['message']="<div class='alert alert-danger'>Data Kendaraan Sudah Ada</div>";
        else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';

        /* CODE UNTUK VERSI */
        $kodemenu='I.G.D.2';
        $versirelease='I.G.D.2/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_kendaraan->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_kendaraan->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $data['list_mstkendaraan']=$this->m_kendaraan->q_masterkendaraan()->result();
        $data['list_sckendaraan']=$this->m_kendaraan->q_sckendaraan()->result();
        $data['list_scsubkendaraan']=$this->m_kendaraan->q_scsubkendaraan()->result();
        $data['list_kanwil']=$this->m_kendaraan->q_gudangwilayah()->result();
        $param="";
        $data['list_asuransi']=$this->m_kendaraan->q_masuransi($param)->result();
        $data['list_subasuransi']=$this->m_kendaraan->q_msubasuransi($param)->result();
        $data['list_karyawan']=$this->m_akses->list_karyawan()->result();
        $this->template->display('ga/kendaraan/v_mstkendaraan',$data);

    }

    function cv_input_mstkendaraan(){

    }
    function cv_edit_mstkendaraan(){
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $parammst=" and nodok='$nodok'";
        $data['dtlmst']=$this->m_kendaraan->q_mstkendaraanwil($parammst)->row_array();
        $data['title']='UBAH MASTER KENDARAAN';
        $data['list_sckendaraan']=$this->m_kendaraan->q_sckendaraan()->result();
        $data['list_scsubkendaraan']=$this->m_kendaraan->q_scsubkendaraan()->result();
        $data['list_kanwil']=$this->m_kendaraan->q_gudangwilayah()->result();
        $param="";
        $data['list_asuransi']=$this->m_kendaraan->q_masuransi($param)->result();
        $data['list_subasuransi']=$this->m_kendaraan->q_msubasuransi($param)->result();
        $data['list_karyawan']=$this->m_akses->list_karyawan()->result();
        $this->template->display('ga/kendaraan/v_editmstkendaraan',$data);
    }
    function cv_delete_mstkendaraan(){
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $parammst=" and nodok='$nodok'";
        $data['dtlmst']=$this->m_kendaraan->q_mstkendaraanwil($parammst)->row_array();
        $data['title']='HAPUS MASTER KENDARAAN';
        $data['list_sckendaraan']=$this->m_kendaraan->q_sckendaraan()->result();
        $data['list_scsubkendaraan']=$this->m_kendaraan->q_scsubkendaraan()->result();
        $data['list_kanwil']=$this->m_kendaraan->q_gudangwilayah()->result();
        $param="";
        $data['list_asuransi']=$this->m_kendaraan->q_masuransi($param)->result();
        $data['list_subasuransi']=$this->m_kendaraan->q_msubasuransi($param)->result();
        $data['list_karyawan']=$this->m_akses->list_karyawan()->result();
        $this->template->display('ga/kendaraan/v_deletemstkendaraan',$data);
    }

    function cv_detail_mstkendaraan(){
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $parammst=" and nodok='$nodok'";
        $data['dtlmst']=$this->m_kendaraan->q_mstkendaraanwil($parammst)->row_array();
        $data['title']='DETAIL MASTER KENDARAAN';
        $data['list_sckendaraan']=$this->m_kendaraan->q_sckendaraan()->result();
        $data['list_scsubkendaraan']=$this->m_kendaraan->q_scsubkendaraan()->result();
        $data['list_kanwil']=$this->m_kendaraan->q_gudangwilayah()->result();
        $param="";
        $data['list_asuransi']=$this->m_kendaraan->q_masuransi($param)->result();
        $data['list_subasuransi']=$this->m_kendaraan->q_msubasuransi($param)->result();
        $data['list_karyawan']=$this->m_akses->list_karyawan()->result();
        $this->template->display('ga/kendaraan/v_detailmstkendaraan',$data);
    }

    function input_mstkendaraan(){
        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));

        $nmbarang=strtoupper(trim($this->input->post('nmkendaraan')));
        $kdgroup=strtoupper(trim($this->input->post('kdgroup')));
        $kdsubgroup=strtoupper(trim($this->input->post('kdsubgroup')));
        $kdgudang=strtoupper(trim($this->input->post('kdgudang')));
        $nmpemilik=strtoupper(trim($this->input->post('nmpemilik')));
        $addpemilik=strtoupper(trim($this->input->post('addpemilik')));
        $kdasuransi=strtoupper(trim($this->input->post('kdasuransi')));
        $kdsubasuransi=strtoupper(trim($this->input->post('kdsubasuransi')));
        $kdrangka=strtoupper(trim($this->input->post('kdrangka')));
        $kdmesin=strtoupper(trim($this->input->post('kdmesin')));
        $nopol=strtoupper(trim($this->input->post('nopol')));
        $hppemilik=strtoupper(trim($this->input->post('hppemilik')));
        $typeid=strtoupper(trim($this->input->post('typeid')));
        $jenisid=strtoupper(trim($this->input->post('jenisid')));
        $modelid=strtoupper(trim($this->input->post('modelid')));
        $tahunpembuatan=strtoupper(trim($this->input->post('tahunpembuatan')));
        $silinder=strtoupper(trim($this->input->post('silinder')));
        $warna=strtoupper(trim($this->input->post('warna')));
        $bahanbakar=strtoupper(trim($this->input->post('bahanbakar')));
        $warnatnkb=strtoupper(trim($this->input->post('warnatnkb')));
        $tahunreg=strtoupper(trim($this->input->post('tahunreg')));
        $nobpkb=strtoupper(trim($this->input->post('nobpkb')));
        $kdlokasi=strtoupper(trim($this->input->post('kdlokasi')));
        $expstnkb=strtoupper(trim($this->input->post('expstnkb')));
        $exppkbstnkb =strtoupper(trim($this->input->post('exppkbstnkb')));
        $nopkb=strtoupper(trim($this->input->post('nopkb')));
        //$nominalpkb=strtoupper(trim($this->input->post('nominalpkb')));
        $pprogresif=strtoupper(trim($this->input->post('pprogresif')));
        $brand=strtoupper(trim($this->input->post('brand')));
        $hold_item=strtoupper(trim($this->input->post('hold_item')));
        //$typebarang=strtoupper(trim($this->input->post('typebarang')));
        $expasuransi=strtoupper(trim($this->input->post('expasuransi')));
        $userpakai=strtoupper(trim($this->input->post('userpakai')));
        $ujikir=strtoupper(trim($this->input->post('ujikir')));
        $asuransi=strtoupper(trim($this->input->post('asuransi')));

        $keterangan=strtoupper(trim($this->input->post('keterangan')));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;

        if (empty($expstnkb)){ $expstnkb=null; };
        if (empty($exppkbstnkb)){ $exppkbstnkb=null; };
        if (empty($expasuransi)){ $expasuransi=null; };
        if (empty($pprogresif)){ $pprogresif=null; };

        if ($type=='INPUT'){
            $cekkendaraan=$this->m_kendaraan->q_cekkendaraan($kdrangka)->num_rows();
            if($cekkendaraan>0){
                redirect("ga/kendaraan/form_mstkendaraan/inp_kembar");
            };

            $info = array (
                'branch' => $branch,
                'nodok' => $kdrangka,
                'nodokref' => $inputby,
                'nmbarang' => $nmbarang,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'kdgudang' => $kdgudang,
                'nmpemilik' => $nmpemilik,
                'addpemilik' => $addpemilik,
                'kdasuransi' => $kdasuransi,
                'kdsubasuransi' => $kdsubasuransi,
                'kdrangka' => $kdrangka,
                'kdmesin' => $kdmesin,
                'nopol' => $nopol,
                'hppemilik' => $hppemilik,
                'typeid' => $typeid,
                'jenisid' => $jenisid,
                'modelid' => $modelid,
                'tahunpembuatan' => $tahunpembuatan,
                'silinder' => $silinder,
                'warna' => $warna,
                'bahanbakar' => $bahanbakar,
                'warnatnkb' => $warnatnkb,
                'tahunreg' => $tahunreg,
                'nobpkb' => $nobpkb,
                'kdlokasi' => $kdlokasi,
                'expstnkb' => $expstnkb,
                'exppkbstnkb' => $exppkbstnkb,
                'nopkb' => $nopkb,
                //'nominalpkb' => $nominalpkb,
                'pprogresif' => $pprogresif,
                'brand' => $brand,
                'hold_item' => $hold_item,
                //'qty' => $qty,
                'expasuransi' => $expasuransi,
                'userpakai' => $userpakai,
                'ujikir' => $ujikir,
                'asuransi' => $asuransi,
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,

            );
            $this->db->insert('sc_mst.mbarang',$info);
            redirect("ga/kendaraan/form_mstkendaraan/inp_succes");

        } else if ($type=='EDIT') {
            $info = array (
                'nmbarang' => $nmbarang,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'kdgudang' => $kdgudang,
                'nmpemilik' => $nmpemilik,
                'addpemilik' => $addpemilik,
                'kdasuransi' => $kdasuransi,
                'kdsubasuransi' => $kdsubasuransi,
                'kdrangka' => $kdrangka,
                'kdmesin' => $kdmesin,
                'nopol' => $nopol,
                'hppemilik' => $hppemilik,
                'typeid' => $typeid,
                'jenisid' => $jenisid,
                'modelid' => $modelid,
                'tahunpembuatan' => $tahunpembuatan,
                'silinder' => $silinder,
                'warna' => $warna,
                'bahanbakar' => $bahanbakar,
                'warnatnkb' => $warnatnkb,
                'tahunreg' => $tahunreg,
                'nobpkb' => $nobpkb,
                'kdlokasi' => $kdlokasi,
                'expstnkb' => $expstnkb,
                'exppkbstnkb' => $exppkbstnkb,
                'nopkb' => $nopkb,
                //'nominalpkb' => $nominalpkb,
                'pprogresif' => $pprogresif,
                'brand' => $brand,
                'hold_item' => $hold_item,
                //'qty' => $qty,
                'expasuransi' => $expasuransi,
                'userpakai' => $userpakai,
                'ujikir' => $ujikir,
                'asuransi' => $asuransi,
                'keterangan' => $keterangan,
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('kdrangka',$kdrangka);
            $this->db->where('kdmesin',$kdmesin);
            $this->db->update('sc_mst.mbarang',$info);
            redirect("ga/kendaraan/form_mstkendaraan/inp_succes");
        }  else if ($type=='DELETE') {
            $this->db->where('kdrangka',$kdrangka);
            $this->db->where('kdmesin',$kdmesin);
            $this->db->delete('sc_mst.mbarang');
            redirect("ga/kendaraan/form_mstkendaraan/del_succes");
        }  else {
            redirect("ga/kendaraan/form_mstkendaraan/fail_data");
        }
    }

    /* Asuransi */
    function form_mstasuransi(){
        $data['title']="FORM MASTER ASURANSI  (Ketik Detail Untuk Input Cabang Asuransi)";
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.D.3';
        $versirelease='I.G.D.3/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
        else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'>Data Succes Di Input</div>";
        else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
        else if($this->uri->segment(4)=="del_failed")
            $data['message']="<div class='alert alert-danger'>Data Tidak Bisa Terhapus Karena Pada Sub Group Masih Tertulis Kode Skema Ini</div>";
        else if($this->uri->segment(4)=="fail_input")
            $data['message']="<div class='alert alert-danger'>Data Asuransi Sudah Ada</div>";
        else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';

        $param="";
        $data['list_mstasuransi']=$this->m_kendaraan->q_masuransi($param)->result();
        $data['list_kanwil']=$this->m_kendaraan->q_gudangwilayah()->result();
        $data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
        $data['list_opt_kotakab']=$this->m_geo->list_opt_kotakab()->result();
        $data['list_opt_kec']=$this->m_geo->list_opt_kec()->result();
        $this->template->display('ga/kendaraan/v_mstasuransi',$data);

    }
    function form_msubasuransi(){
        $data['title']="MASTER CABANG ASURANSI";
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.D.3';
        $versirelease='I.G.D.3/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $kdasuransi=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        ///$kdsubasuransi=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        if (empty($kdasuransi)){
            redirect("ga/kendaraan/form_mstasuransi");
        }

        if($this->uri->segment(6)=="fail_input")
            $data['message']="<div class='alert alert-warning'>Input Gagal Kode Sudah Ada</div>";
        else if($this->uri->segment(6)=="rep_succes")
            $data['message']="<div class='alert alert-success'> Data Berhasil Ditambahkan</div>";
        else
            $data['message']='';


        $param="and kdasuransi='$kdasuransi'";

        $data['kdasuransi']=$kdasuransi;

        $data['dtlmst']=$this->m_kendaraan->q_masuransi($param)->row_array();
        $data['list_kanwil']=$this->m_kendaraan->q_mstkantor()->result();
        $data['list_asuransi']=$this->m_kendaraan->q_masuransi($param)->result();
        $data['list_msubasuransi']=$this->m_kendaraan->q_msubasuransi($param)->result();
        $this->template->display('ga/kendaraan/v_msubasuransi',$data);

    }



    function input_mstasuransi(){
        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));
        $kdcabang=strtoupper($this->input->post('kdcabang'));
        $kdasuransi=trim(strtoupper($this->input->post('kdasuransi')));
        $nmasuransi=strtoupper($this->input->post('nmasuransi'));
        $kodeprov=strtoupper($this->input->post('kodeprov'));
        $kodekotakab=strtoupper($this->input->post('kodekotakab'));
        $kodekec=strtoupper($this->input->post('kodekec'));
        $addasuransi=strtoupper($this->input->post('addasuransi'));
        $phone1=strtoupper($this->input->post('phone1'));
        $phone2=strtoupper($this->input->post('phone2'));
        $kdhold=strtoupper($this->input->post('kdhold'));
        //$startdate=strtoupper($this->input->post('startdate'));
        //$expdate=strtoupper($this->input->post('expdate'));
        //$groupreminder=strtoupper($this->input->post('groupreminder'));
        $keterangan=strtoupper($this->input->post('keterangan'));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;

        if ($type=='INPUT'){
            $param="and kdasuransi='$kdasuransi'";
            $cekdtl=$this->m_kendaraan->q_masuransi($param)->num_rows();
            if($cekdtl>0){
                redirect("ga/kendaraan/form_mstasuransi/fail_input");
            } else {
                $info = array (
                    'branch' => $branch,
                    'kdasuransi' => $kdasuransi,
                    'nmasuransi' => $nmasuransi,
                    'kdhold' => $kdhold,
                    'keterangan' => $keterangan,
                    'inputdate' => $inputdate,
                    'inputby' => $inputby,
                );
                $this->db->insert('sc_mst.masuransi',$info);
                redirect("ga/kendaraan/form_mstasuransi/inp_succes");
            }

        } else if ($type=='EDIT') {
            $info = array (
                'branch' => $branch,
                'nmasuransi' => $nmasuransi,
                'kdhold' => $kdhold,
                'keterangan' => $keterangan,
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('kdasuransi',$kdasuransi);
            $this->db->update('sc_mst.masuransi',$info);
            redirect("ga/kendaraan/form_mstasuransi/inp_succes");
        } else if ($type=='DELETE') {
            $this->db->where('kdasuransi',$kdasuransi);
            $this->db->delete('sc_mst.masuransi');
            redirect("ga/kendaraan/form_mstasuransi/del_succes");
        } else {
            redirect("ga/kendaraan/form_mstasuransi/fail_data");
        }

    }


    function input_mstsubasuransi(){
        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));
        $kdcabang=strtoupper($this->input->post('kdcabang'));
        $kdasuransi=trim(strtoupper($this->input->post('kdasuransi')));
        $kdsubasuransi=trim(strtoupper($this->input->post('kdsubasuransi')));
        $nmsubasuransi=strtoupper($this->input->post('nmsubasuransi'));
        $addsubasuransi=strtoupper($this->input->post('addsubasuransi'));
        $jenisasuransi=strtoupper($this->input->post('jenisasuransi'));
        $phone1=strtoupper($this->input->post('phone1'));
        $phone2=strtoupper($this->input->post('phone2'));
        $fax=strtoupper($this->input->post('fax'));
        $email=strtoupper($this->input->post('email'));
        $city=strtoupper($this->input->post('city'));
        $kdhold=strtoupper($this->input->post('kdhold'));
        $keterangan=strtoupper($this->input->post('keterangan'));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;
        $enc_kdasuransi=bin2hex($this->encrypt->encode(trim($kdasuransi)));
        if ($type=='INPUT'){
            $info = array (
                'branch        ' => $branch       ,
                'kdasuransi ' => $kdasuransi,
                'kdsubasuransi ' => '',
                'nmsubasuransi ' => $nmsubasuransi,
                'addsubasuransi' => $addsubasuransi,
                'city          ' => $city         ,
                'phone1        ' => $phone1       ,
                'phone2        ' => $phone2       ,
                'fax           ' => $fax          ,
                'email         ' => $email        ,
                'kdhold        ' => $kdhold       ,
                'kdcabang      ' => $kdcabang     ,
                'jenisasuransi ' => $jenisasuransi,
                'keterangan    ' => $keterangan   ,
                'inputdate     ' => $inputdate    ,
                'inputby       ' => $inputby      ,

            );
            $this->db->insert('sc_mst.msubasuransi',$info);
            redirect("ga/kendaraan/form_msubasuransi/$enc_kdasuransi/inp_succes");

        } else if ($type=='EDIT') {
            $info = array (
                'branch        ' => $branch       ,
                'nmsubasuransi ' => $nmsubasuransi,
                'addsubasuransi' => $addsubasuransi,
                'city          ' => $city         ,
                'phone1        ' => $phone1       ,
                'phone2        ' => $phone2       ,
                'fax           ' => $fax          ,
                'email         ' => $email        ,
                'kdhold        ' => $kdhold       ,
                'kdcabang      ' => $kdcabang     ,
                'jenisasuransi ' => $jenisasuransi,
                'keterangan    ' => $keterangan   ,
                'inputdate     ' => $inputdate    ,
                'inputby       ' => $inputby      ,

            );
            $this->db->where('kdsubasuransi',$kdsubasuransi);
            $this->db->update('sc_mst.msubasuransi',$info);
            redirect("ga/kendaraan/form_msubasuransi/$enc_kdasuransi/edit_succes");
        } else if ($type=='DELETE') {
            $this->db->where('kdsubasuransi',$kdsubasuransi);
            $this->db->delete('sc_mst.msubasuransi');
            redirect("ga/kendaraan/form_msubasuransi/$enc_kdasuransi/del_succes");
        } else {
            redirect("ga/kendaraan/form_masuransi");
        }

    }

    /* STNKB */
    function form_stnkbaru(){
        $data['title']="FORM PERGANTIAN STNK";
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.G.1';
        $versirelease='I.G.G.1/ALPHA.001';
        $userid=trim($this->session->userdata('nik'));
        $nama=trim($this->session->userdata('nik'));
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $paramerror=" and userid='$nama' and modul='STNKB'";
        $dtlerror=$this->m_kendaraan->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_kendaraan->q_trxerror($paramerror)->num_rows();
        if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
        if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
        if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }

        if($count_err>0 and $errordesc<>''){
            if ($dtlerror['errorcode']==0){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message']="<div class='alert alert-info'>$errordesc</div>";
            }

        }else {
            if ($errorcode=='0'){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message']="";
            }

        }

        /*cek jika ada inputan edit atau input*/
        $param3_1_1=" and nodok='$nama' and status='I'";
        $param3_1_2=" and nodok='$nama' and status='E'";
        $param3_1_3=" and nodok='$nama' and status='A'";
        $param3_1_4=" and nodok='$nama' and status='C'";
        $param3_1_R=" and nodok='$nama'";
        $cekstnk_na=$this->m_kendaraan->q_tmp_stnkb_param($param3_1_1)->num_rows(); //input
        $cekstnk_ne=$this->m_kendaraan->q_tmp_stnkb_param($param3_1_2)->num_rows(); //edit
        $cekstnk_napp=$this->m_kendaraan->q_tmp_stnkb_param($param3_1_3)->num_rows(); //approv
        $cekstnk_cancel=$this->m_kendaraan->q_tmp_stnkb_param($param3_1_4)->num_rows(); //cancel

        $dtledit=$this->m_kendaraan->q_tmp_stnkb_param($param3_1_R)->row_array(); //edit row array
        $enc_nodoktmp=bin2hex($this->encrypt->encode(trim(isset($dtledit['nodoktmp']))));
        $enc_nik=bin2hex($this->encrypt->encode($nama));
        $data['enc_nik']=bin2hex($this->encrypt->encode($nama));

        if ($cekstnk_na>0) { //cek inputan
            $enc_jenispengurusan=bin2hex($this->encrypt->encode(trim($dtledit['jenispengurusan'])));
            redirect("ga/kendaraan/input_stnktmp/$enc_jenispengurusan");

        } else if ($cekstnk_ne>0){	//cek edit
            $nodoktmp=trim($dtledit['nodoktmp']);
            $enc_jenispengurusan=bin2hex($this->encrypt->encode(trim($dtledit['jenispengurusan'])));
            redirect("ga/kendaraan/edit_stnktmp/$enc_nodoktmp/$enc_jenispengurusan");
            //redirect("ga/inventaris/direct_lost_input");
        } else if ($cekstnk_napp>0){	//cek approv
            $nodoktmp=trim($dtledit['nodoktmp']);
            $enc_jenispengurusan=bin2hex($this->encrypt->encode(trim($dtledit['jenispengurusan'])));
            redirect("ga/kendaraan/approval_stnktmp/$enc_nodoktmp/$enc_jenispengurusan");
        } else if ($cekstnk_cancel>0){	//cek cancel
            $nodoktmp=trim($dtledit['nodoktmp']);
            $enc_jenispengurusan=bin2hex($this->encrypt->encode(trim($dtledit['jenispengurusan'])));
            redirect("ga/kendaraan/cancel_stnktmp/$enc_nodoktmp/$enc_jenispengurusan");
        }


        $data['list_mstkendaraan']=$this->m_kendaraan->q_mstkendaraan()->result();
        $data['list_sckendaraan']=$this->m_kendaraan->q_sckendaraan()->result();
        $data['list_kanwil']=$this->m_kendaraan->q_mstkantor()->result();
        $param="";
        $data['list_histnkb']=$this->m_kendaraan->q_his_stnkb_param($param)->result();
        $this->template->display('ga/kendaraan/v_stnk',$data);

        $paramerror=" and userid='$nama'";
        $dtlerror=$this->m_kendaraan->q_deltrxerror($paramerror);
    }

    function list_kendaraanwil(){

        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));
        $kdgudang=strtoupper($this->input->post('kdcabang'));
        $tahun=strtoupper($this->input->post('tahun'));
        $data['title']="LIST DATA MOBIL WILAYAH $kdgudang";
        if(!empty($kdgudang) or $kdgudang<>''){
            if($kdgudang=='ALL'){ $param1=""; } else { $param1="and kdgudang='$kdgudang'"; };
        } else {
            redirect("ga/kendaraan/form_stnkbaru");
        }
        //	echo $param1;
        $data['list_mstkendaraan']=$this->m_kendaraan->q_mstkendaraanwil($param1)->result();
        $this->template->display('ga/kendaraan/v_listkendaraanwil',$data);
    }

    function input_stnktmp(){


        $nama=trim($this->session->userdata('nik'));
        $kdgroup=$this->input->post('kdgroup');
        $kdbarang=$this->input->post('kdbarang');
        $kdgudang=$this->input->post('kdgudang');
        $jenispkb1=$this->input->post('jenispkb');
        $jenispkb2=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        if(!empty($jenispkb1) and empty($jenispkb2)){ $jenispkb=$jenispkb1; }
        else if(empty($jenispkb1) and !empty($jenispkb2)) { $jenispkb=$jenispkb2; } else { redirect("ga/kendaraan/form_stnkbaru"); }

        if($jenispkb=='1T'){ $nmjenispkb='PAJAK TAHUNAN KENDARAAN'; } elseif($jenispkb=='5T'){ $nmjenispkb='PAJAK 5 TAHUNAN & PENGGANTIAN PLAT NOMOR KENDARAAN'; };
        $data['title']='INPUT PROSEDUR PEMBAHARUAN STNKB '.$nmjenispkb;
        if($this->uri->segment(5)=="inp_succes")
            $data['message']="<div class='alert alert-success'>DATA SPK BERHASIL DITAMBAHKAN</div>";
        else if($this->uri->segment(5)=="fail_datakembar")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH ADA SILAHKAN UBAH DATA TERSEBUT </div>";
        else if($this->uri->segment(5)=="fail_data_belum_lengkap")
            $data['message']="<div class='alert alert-danger'>PERINGATAN HARAP LENGKAPI DATA - DATA MASTER TERLEBIH DAHULU</div>";
        else if($this->uri->segment(4)=="input_fail")
            $data['message']="<div class='alert alert-danger'>DATA SUDAH DI PROSES DIGUNAKAN USER LAIN  </div>";
        else
            $data['message']='';
        $param_cek="  and (kdgroup='$kdgroup' and nodok='$kdbarang') or nodok='$nama'";
        $cektmp=$this->m_kendaraan->q_tmp_stnkb_param($param_cek)->num_rows();

        if ($cektmp==0) {
            $param_insert=" and kdgroup='$kdgroup' and nodok='$kdbarang' and kdgudang='$kdgudang'";
            $this->m_kendaraan->insert_tmp_stnkb($nama,$jenispkb,$param_insert);
        }


        $param=" and nodok='$nama'";
        $data['dtlstnk']=$this->m_kendaraan->q_tmp_stnkb_param($param)->row_array();
        $this->template->display('ga/kendaraan/v_inputstnk_v2',$data);
    }

    function edit_stnktmp(){

        $nama=trim($this->session->userdata('nik'));
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $jenispkb=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));

        if($jenispkb=='1T'){ $nmjenispkb='PAJAK TAHUNAN KENDARAAN'; } elseif($jenispkb=='5T'){ $nmjenispkb='PAJAK 5 TAHUNAN & PENGGANTIAN PLAT NOMOR KENDARAAN'; };
        $data['title']='UBAH DATA PROSEDUR PEMBAHARUAN STNKB '.$nmjenispkb;
        $data['message']='';
        $param_cek=" and nodok='$nama' and status='E'";
        $cektmp=$this->m_kendaraan->q_tmp_stnkb_param($param_cek)->num_rows();

        if ($cektmp==0) {
            $info = array(
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
                'status' => 'E'
            );
            $this->db->where('nodok',$nodok);
            $this->db->update('sc_his.stnkb',$info);
        }


        $param=" and nodok='$nama' and status='E'";
        $data['dtlstnk']=$this->m_kendaraan->q_tmp_stnkb_param($param)->row_array();
        $this->template->display('ga/kendaraan/v_editstnk_v2',$data);
    }

    function approv_stnktmp(){

        $nama=trim($this->session->userdata('nik'));
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $jenispkb=$this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));

        if($jenispkb=='1T'){ $nmjenispkb='PAJAK TAHUNAN KENDARAAN'; } elseif($jenispkb=='5T'){ $nmjenispkb='PAJAK 5 TAHUNAN & PENGGANTIAN PLAT NOMOR KENDARAAN'; };
        $data['title']='PERSETUJUAN DATA PROSEDUR PEMBAHARUAN STNKB '.$nmjenispkb;
        $data['message']='';
        $param_cek=" and nodok='$nama' and status='A'";
        $cektmp=$this->m_kendaraan->q_tmp_stnkb_param($param_cek)->num_rows();

        if ($cektmp==0) {
            $info = array(
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
                'status' => 'A1'
            );
            $this->db->where('nodok',$nodok);
            $this->db->update('sc_his.stnkb',$info);
        }

        $param=" and nodok='$nama' and status='A'";
        $data['dtlstnk']=$this->m_kendaraan->q_tmp_stnkb_param($param)->row_array();
        $this->template->display('ga/kendaraan/v_approvalstnk_v2',$data);
    }


    function clear_tmp_stnkb(){
        $nama=trim($this->session->userdata('nik'));
        $param=" and nodok='$nama'";
        $dtltmp=$this->m_kendaraan->q_tmp_stnkb_param($param)->row_array();
        if (trim($dtltmp['status'])=='E'){
            $info = array ( 'updatedate' => null, 'updateby' => null, 'status' => 'A' );
            $this->db->where('nodok',trim($dtltmp['nodoktmp']));
            $this->db->update('sc_his.stnkb',$info);
        }

        $this->db->where('nodok',$nama);
        $this->db->delete('sc_tmp.stnkb');
        redirect("ga/kendaraan/form_stnkbaru");
    }


    function input_pkb_tahunan($kdrangka,$kdmesin){
        $data['title']="INPUT PERPANJANGAN PKB TAHUNAN";
        $data['kdrangka']=$kdrangka;
        $data['kdmesin']=$kdmesin;
        $dtl=$this->m_kendaraan->q_cekkendaraan($kdrangka)->row_array();
        $data['nopol']=trim($dtl['nopol']);
        $this->template->display('ga/kendaraan/v_inputpkbtahunan',$data);
    }

    function input_stnkbaru($kdrangka,$kdmesin){
        $data['title']="INPUT STNK BARU";
        $data['kdrangka']=$kdrangka;
        $data['kdmesin']=$kdmesin;
        $this->template->display('ga/kendaraan/v_inputstnkbaru',$data);
    }

    function save_stnkbaru(){
        $nama=$this->session->userdata('nik');
        $nodok=strtoupper(trim($this->input->post('nodok')));
        $type=strtoupper(trim($this->input->post('type')));
        $kdrangka=strtoupper(trim($this->input->post('kdrangka')));
        $kdmesin=strtoupper(trim($this->input->post('kdmesin')));
        $nopol=strtoupper(trim($this->input->post('nopol')));
        $kdgroup=strtoupper(trim($this->input->post('kdgroup')));
        $kdcabang=strtoupper(trim($this->input->post('kdcabang')));
        $nmkendaraan=strtoupper(trim($this->input->post('nmkendaraan')));
        $nmpemilik=strtoupper(trim($this->input->post('nmpemilik')));
        $addpemilik=strtoupper(trim($this->input->post('addpemilik')));
        $hppemilik=strtoupper(trim($this->input->post('hppemilik')));
        $typeid=strtoupper(trim($this->input->post('typeid')));
        $jenisid=strtoupper(trim($this->input->post('jenisid')));
        $modelid=strtoupper(trim($this->input->post('modelid')));
        $tahunpembuatan=strtoupper(trim($this->input->post('tahunpembuatan')));
        $silinder=strtoupper(trim($this->input->post('silinder')));
        $warna=strtoupper(trim($this->input->post('warna')));
        $bahanbakar=strtoupper(trim($this->input->post('bahanbakar')));
        $warnatnkb=strtoupper(trim($this->input->post('warnatnkb')));
        $tahunreg=strtoupper(trim($this->input->post('tahunreg')));
        $nobpkb=strtoupper(trim($this->input->post('nobpkb')));
        $kdlokasi=strtoupper(trim($this->input->post('kdlokasi')));
        $expstnkb=strtoupper(trim($this->input->post('expstnkb')));
        $exppkbstnkb=strtoupper(trim($this->input->post('exppkbstnkb')));
        $nopkb=strtoupper(trim($this->input->post('nopkb')));
        $nominalpkb=strtoupper(trim($this->input->post('nominalpkb')));
        $noskum=strtoupper(trim($this->input->post('noskum')));
        $nokohir=strtoupper(trim($this->input->post('nokohir')));
        $hold_stnk=strtoupper(trim($this->input->post('hold_stnk')));
        $kdasuransi=strtoupper(trim($this->input->post('kdasuransi')));
        $keterangan=strtoupper(trim($this->input->post('keterangan')));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;
        $jenispengurusan=strtoupper(trim($this->input->post('jenispengurusan')));

        if (empty($expstnkb) or $expstnkb==''){ $expstnkb=null; };
        if (empty($exppkbstnkb) or $exppkbstnkb==''){ $exppkbstnkb=null; };
        if (empty($nominalpkb) or $nominalpkb==''){ $nominalpkb=null; };

        if ($type=='INPUT_1T'){

            $info = array (
                'nodok' => $nama,
                'tgldok' => date('Y-m-d H:i:s'),
                'exppkbstnkb' => date('Y-m-d', strtotime(trim($exppkbstnkb))),
                'nopkb' => $nopkb,
                'nominalpkb' => $nominalpkb,
                'noskum' => $noskum,
                'nokohir' => $nokohir,
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,
                'status' => 'F',
            );
            $this->db->where('nodok',$nama);
            $this->db->where('jenispengurusan',$jenispengurusan);
            $this->db->update('sc_tmp.stnkb',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PDCA');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'STNKB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/kendaraan/form_stnkbaru");
        } else if ($type=='INPUT_5T'){
            $info = array (

                'nopol' => $nopol,
                'nmkendaraan' => $nmkendaraan,
                'nmpemilik' => $nmpemilik,
                'addpemilik' => $addpemilik,
                'hppemilik' => $hppemilik,
                'typeid' => $typeid,
                'jenisid' => $jenisid,
                'modelid' => $modelid,
                'tahunpembuatan' => $tahunpembuatan,
                'silinder' => $silinder,
                'warna' => $warna,
                'bahanbakar' => $bahanbakar,
                'warnatnkb' => $warnatnkb,
                'tahunreg' => $tahunreg,
                'nobpkb' => $nobpkb,
                'kdlokasi' => $kdlokasi,
                'expstnkb' => $expstnkb,
                'exppkbstnkb' => $exppkbstnkb,
                'nopkb' => $nopkb,
                'nominalpkb' => $nominalpkb,
                'noskum' => $noskum,
                'nokohir' => $nokohir,
                'keterangan' => $keterangan,
                'status' => 'F',
                'inputdate' => $inputdate,
                'inputby' => $inputby,
            );
            $this->db->where('nodok',$nama);
            $this->db->where('jenispengurusan',$jenispengurusan);
            $this->db->update('sc_tmp.stnkb',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PDCA');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'STNKB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/kendaraan/form_stnkbaru");

        } else if ($type=='EDIT_1T'){
            //	echo $noskum;
            //	echo '</br>';
            //	echo $nokohir;
            $info = array (
                'nodok' => $nama,
                'tgldok' => date('Y-m-d H:i:s'),
                'exppkbstnkb' => date('Y-m-d', strtotime(trim($exppkbstnkb))),
                'nopkb' => $nopkb,
                'nominalpkb' => $nominalpkb,
                'noskum' => $noskum,
                'nokohir' => $nokohir,
                'keterangan' => $keterangan,
                'inputdate' => $inputdate,
                'inputby' => $inputby,
                'status' => 'F',
            );
            $this->db->where('nodok',$nama);
            $this->db->where('jenispengurusan',$jenispengurusan);
            $this->db->update('sc_tmp.stnkb',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PDCA');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'STNKB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/kendaraan/form_stnkbaru");
        } else if ($type=='EDIT_5T'){
            $info = array (

                'nopol' => $nopol,
                'nmkendaraan' => $nmkendaraan,
                'nmpemilik' => $nmpemilik,
                'addpemilik' => $addpemilik,
                'hppemilik' => $hppemilik,
                'typeid' => $typeid,
                'jenisid' => $jenisid,
                'modelid' => $modelid,
                'tahunpembuatan' => $tahunpembuatan,
                'silinder' => $silinder,
                'warna' => $warna,
                'bahanbakar' => $bahanbakar,
                'warnatnkb' => $warnatnkb,
                'tahunreg' => $tahunreg,
                'nobpkb' => $nobpkb,
                'kdlokasi' => $kdlokasi,
                'expstnkb' => $expstnkb,
                'exppkbstnkb' => $exppkbstnkb,
                'nopkb' => $nopkb,
                'nominalpkb' => $nominalpkb,
                'noskum' => $noskum,
                'nokohir' => $nokohir,
                'keterangan' => $keterangan,
                'status' => 'F',
                'inputdate' => $inputdate,
                'inputby' => $inputby,
            );
            $this->db->where('nodok',$nama);
            $this->db->where('jenispengurusan',$jenispengurusan);
            $this->db->update('sc_tmp.stnkb',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PDCA');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'STNKB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/kendaraan/form_stnkbaru");

        } else if ($type=='APPROVAL') {
            $info = array (
                'status' => 'F',
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('nodok',$nodok);
            $this->db->update('sc_his.stnkb',$info);
            redirect("ga/kendaraan/form_stnkbaru/inp_succes");
        }  else if ($type=='DELETE') {
            $this->db->where('nodok',$nodok);
            $this->db->delete('sc_his.stnkb');
            redirect("ga/kendaraan/form_stnkbaru/del_succes");
        }  else {
            redirect("ga/kendaraan/form_stnkbaru/fail_data");
        }
    }


    function inquirystnk(){
        $data['title']="FILTER INQIRY PERGANTIAN STNK";
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.G.2';
        $versirelease='I.G.G.2/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $data['list_kanwil']=$this->m_kendaraan->q_mstkantor()->result();
        $this->template->display('ga/kendaraan/v_filterinquirystnk',$data);

    }

    function listmobil_inquirystnk(){
        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));
        $kdgudang=strtoupper($this->input->post('kdcabang'));
        $tahun=strtoupper($this->input->post('tahun'));
        $data['title']="LIST DATA MOBIL WILAYAH $kdgudang";
        if(!empty($kdgudang) or $kdgudang<>''){
            if($kdgudang=='ALL'){ $param1=""; } else { $param1="and kdgudang='$kdgudang'"; };
        } else {
            redirect("ga/kendaraan/inquirystnk");
        }
        //	echo $param1;
        $data['kdgudang']=$kdgudang;
        $data['list_mstkendaraan']=$this->m_kendaraan->q_mstkendaraanwil($param1)->result();
        $this->template->display('ga/kendaraan/v_listwilquiry.php',$data);
    }

    function detail_logstnk($kdrangka,$kdmesin,$kdgudang){
        $data['title']="HISTORY STNK";
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.G.2';
        $versirelease='I.G.G.2/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $data['kdgudang']=$kdgudang;
        $data['list_kanwil']=$this->m_kendaraan->q_mstkantor()->result();
        $data['list_histnkb']=$this->m_kendaraan->q_inquirystnk($kdrangka,$kdmesin)->result();
        $this->template->display('ga/kendaraan/v_dtlinquirystnk.php',$data);
    }

    /* FORM MASTER BENGKEL */
    function form_mstbengkel(){
        $data['title']="&nbsp MASTER BENGKEL";
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.D.5';
        $versirelease='I.G.D.5/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        if($this->uri->segment(4)=="fail_input")
            $data['message']="<div class='alert alert-warning'>Input Gagal Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="inp_succes")
            $data['message']="<div class='alert alert-success'> Data Berhasil Ditambahkan</div>";
        else
            $data['message']='';


        $param='';
        $data['list_kanwil']=$this->m_kendaraan->q_mstkantor()->result();
        $data['list_bengkel']=$this->m_kendaraan->q_mbengkel($param)->result();
        $data['list_trxgbengkel']=$this->m_kendaraan->q_trxgbengkel()->result();
        $this->template->display('ga/kendaraan/v_mbengkel',$data);

    }

    function input_mstbengkel(){
        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));

        $kdbengkel=strtoupper(trim($this->input->post('kdbengkel')));
        $nmbengkel=strtoupper(trim($this->input->post('nmbengkel')));
        //$addbengkel=strtoupper(trim($this->input->post('addbengkel')));
        //$city=strtoupper(trim($this->input->post('city')));
        //$phone1=strtoupper(trim($this->input->post('phone1')));
        //$phone2=strtoupper(trim($this->input->post('phone2')));
        $kdhold=strtoupper(trim($this->input->post('kdhold')));
        $kdgroup=strtoupper(trim($this->input->post('kdgroup')));
        //$kdcabang=strtoupper(trim($this->input->post('kdcabang')));
        //$startdate=strtoupper(trim($this->input->post('startdate')));
        //$expdate=strtoupper(trim($this->input->post('expdate')));
        //$groupreminder=strtoupper(trim($this->input->post('groupreminder')));
        $keterangan=strtoupper(trim($this->input->post('keterangan')));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;

        if ($type=='INPUT'){
            $param="and kdbengkel='$kdbengkel'";
            $cekmst=$this->m_kendaraan->q_mbengkel($param)->num_rows();
            if($cekmst>0) {
                redirect("ga/kendaraan/form_mstbengkel/fail_input");
            } else {
                $info = array (
                    'branch' => $branch,
                    'kdbengkel' => $kdbengkel,
                    'nmbengkel' => $nmbengkel,
                    'kdhold' => $kdhold,
                    'kdgroup' => $kdgroup,
                    'keterangan' => $keterangan,
                    'inputdate' => $inputdate,
                    'inputby' => $inputby,
                );
                $this->db->insert('sc_mst.mbengkel',$info);
                redirect("ga/kendaraan/form_mstbengkel/inp_succes");
            }
        } else if ($type=='EDIT') {
            $info = array (
                'nmbengkel' => $nmbengkel,
                'kdhold' => $kdhold,
                'kdgroup' => $kdgroup,
                'keterangan' => $keterangan   ,
                'updatedate' => $inputdate    ,
                'updateby' => $inputby      ,
            );
            $this->db->where('kdbengkel',$kdbengkel);
            $this->db->update('sc_mst.mbengkel',$info);
            redirect("ga/kendaraan/form_mstbengkel/inp_succes");
        } else if ($type=='DELETE') {
            $this->db->where('kdbengkel',$kdbengkel);
            $this->db->delete('sc_mst.mbengkel');
            redirect("ga/kendaraan/form_mstbengkel/del_succes");
        } else {
            redirect("ga/kendaraan/form_mstbengkel/fail_data");
        }


    }

    function form_msubbengkel(){
        $data['title']="MASTER SUB BENGKEL";
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.D.5';
        $versirelease='I.G.D.5/ALPHA.001';
        $userid=$this->session->userdata('nik');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $kdbengkel=$this->uri->segment(4);
        $kdsubbengkel=$this->uri->segment(5);

        if($this->uri->segment(6)=="fail_input")
            $data['message']="<div class='alert alert-warning'>Input Gagal Kode Sudah Ada</div>";
        else if($this->uri->segment(6)=="rep_succes")
            $data['message']="<div class='alert alert-success'> Data Berhasil Ditambahkan</div>";
        else
            $data['message']='';


        $param="and kdbengkel='$kdbengkel'";

        $data['kdbengkel']=$kdbengkel;

        $data['dtlmst']=$this->m_kendaraan->q_mbengkel($param)->row_array();
        $data['list_kanwil']=$this->m_kendaraan->q_mstkantor()->result();
        $data['list_bengkel']=$this->m_kendaraan->q_mbengkel($param)->result();
        $data['list_trxgbengkel']=$this->m_kendaraan->q_trxgbengkel()->result();
        $data['list_msubbengkel']=$this->m_kendaraan->q_msubbengkel($param)->result();
        $this->template->display('ga/kendaraan/v_msubbengkel',$data);

    }

    function input_mstsubbengkel(){
        $nama=$this->session->userdata('nik');
        $type=strtoupper($this->input->post('type'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=strtoupper(trim($dtlbranch['branch']));

        $kdbengkel=strtoupper(trim($this->input->post('kdbengkel')));
        $kdsubbengkel=strtoupper(trim($this->input->post('kdsubbengkel')));
        $nmbengkel=strtoupper(trim($this->input->post('nmbengkel')));
        $addbengkel=strtoupper(trim($this->input->post('addbengkel')));
        $city=strtoupper(trim($this->input->post('city')));
        $phone1=strtoupper(trim($this->input->post('phone1')));
        $phone2=strtoupper(trim($this->input->post('phone2')));
        $fax=strtoupper(trim($this->input->post('fax')));
        $email=strtoupper(trim($this->input->post('email')));
        $kdhold=strtoupper(trim($this->input->post('kdhold')));
        $kdgroupbengkel=strtoupper(trim($this->input->post('kdgroupbengkel')));
        $kdcabang=strtoupper(trim($this->input->post('kdcabang')));
        $keterangan=strtoupper(trim($this->input->post('keterangan')));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;

        if ($type=='INPUT'){
            $param="and kdbengkel='$kdbengkel' and kdsubbengkel='$kdsubbengkel'";
            $ceksub=$this->m_kendaraan->q_msubbengkel($param)->num_rows();
            if($ceksub>0) {
                redirect("ga/kendaraan/form_msubbengkel/$kdbengkel/fail_input");
            }else {
                $info = array (
                    'branch' => $branch,
                    'kdbengkel' => $kdbengkel,
                    'kdsubbengkel' => $nama,
                    'nmbengkel' => $nmbengkel,
                    'addbengkel' => $addbengkel,
                    'city' => $city,
                    'phone1' => $phone1,
                    'phone2' => $phone2,
                    'fax' => $fax,
                    'email' => $email,
                    'kdhold' => $kdhold,
                    'kdgroup' => $kdgroupbengkel,
                    'kdcabang' => $kdcabang,
                    'keterangan' => $keterangan,
                    'inputdate' => $inputdate,
                    'inputby' => $inputby,

                );
                $this->db->insert('sc_mst.msubbengkel',$info);
                redirect("ga/kendaraan/form_msubbengkel/$kdbengkel/input_success");
            }

        } else if ($type=='EDIT') {
            $info = array (
                'nmbengkel' => $nmbengkel,
                'addbengkel' => $addbengkel,
                'city' => $city,
                'phone1' => $phone1,
                'phone2' => $phone2,
                'fax' => $fax,
                'email' => $email,
                'kdhold' => $kdhold,
                'kdgroup' => $kdgroupbengkel,
                'kdcabang' => $kdcabang,
                'keterangan' => $keterangan,
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('kdbengkel',$kdbengkel);
            $this->db->where('kdsubbengkel',$kdsubbengkel);
            $this->db->update('sc_mst.msubbengkel',$info);
            redirect("ga/kendaraan/form_msubbengkel/$kdbengkel/rep_succes");
        } else if ($type=='DELETE') {
            $this->db->where('kdbengkel',$kdbengkel);
            $this->db->where('kdsubbengkel',$kdsubbengkel);
            $this->db->delete('sc_mst.msubbengkel');
            redirect("ga/kendaraan/form_msubbengkel/$kdbengkel/del_succes");
        } else {
            redirect("ga/kendaraan/form_msubbengkel/$kdbengkel/fail_data");
        }


    }


    function sti_pengajuan_stnkb(){
        $nodok=trim(strtoupper($this->uri->segment(4)));
        $data['jsonfile'] = "ga/kendaraan/json_pengajuan_stnkb/$nodok";
        $data['report_file'] = 'assets/mrt/sti_stnkb.mrt';
        $this->load->view("ga/kendaraan/sti_pengajuan_stnkb",$data);
    }

    function json_pengajuan_stnkb(){
        $nodok=trim(strtoupper($this->uri->segment(4)));
        $param=" and nodok='$nodok'";
        $datamst = $this->m_kendaraan->q_master_branch()->result();
        $datadtl = $this->m_kendaraan->q_json_stnkb_param($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'master' => $datamst,
                'detail' => $datadtl,
            )
            , JSON_PRETTY_PRINT);
    }


    function excel_history_stnkb(){
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        $nama=$this->session->userdata('nik');
        $kdcabang=strtoupper($this->input->post('kdcabang'));

        if ($kdcabang=='ALL'){
            $param="";
        } else {
            $param=" and kdcabang='$kdcabang'";
        }

        $datane=$this->m_kendaraan->q_excel_stnkb($param);
        /*	foreach ($datane as $ls) {
                echo $ls->nmbarang.' | ';
                echo $ls->nopol.' | ';
                echo $ls->tahunpembuatan.' | ';
                echo $ls->nomorspk.' | ';
                echo $ls->nomorfaktur.' | ';
                echo $ls->tgl_perawatan.' | ';
                echo $ls->km_awal.' | ';
                echo $ls->km_akhir.' | ';
                echo $ls->nservis.' | ';
            } */


        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Tanggal', 'Nama Kendaraan', 'Nopol','Tahun Pembuatan','Masa Pajak Tahunan','Masa STNK 5 Tahunan','Biaya'));
        $this->excel_generator->set_column(array('tanggal','nmkendaraan','nopol','tahunpembuatan','masa1','masa5','nominalpkb'));

        $this->excel_generator->set_width(array(12,30,20,8,40,40,20));
        $this->excel_generator->exportTo2007('Laporan History STNK Kendaraan');

    }
	
	function excel_mstkendaraan(){
        $datane=$this->m_kendaraan->q_excel_mstkendaraan();
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nopol', 'Nama Pemilik', 'Merk/Type','Tahun Pembuatan','Rangka','Mesin','Masa Berlaku STKN','Masa Berlaku Pajak','Base','Pemakai'));
        $this->excel_generator->set_column(array('nopol','nmpemilik','brand','tahunpembuatan','kdrangka','kdmesin','masaberlakustnk','masaberlakupajak','locaname','nmlengkap'));

        $this->excel_generator->set_width(array(10,30,20,8,40,40,20,20,20,20));
        $this->excel_generator->exportTo2007('Laporan Master Kendaraan');

    }

}