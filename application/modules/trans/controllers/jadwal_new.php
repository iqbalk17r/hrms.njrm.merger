<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_new extends MX_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_jadwalnew','master/m_regu','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator'));
        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }


    function index()
    {

        if($this->uri->segment(4)=="failed"){

            $tgl=$this->uri->segment(5);
            $kdregu=$this->uri->segment(6);
            $data['message']="<div class='alert alert-danger'>Data Tanggal: <b>$tgl</b> Regu: <b>$kdregu</b> Sudah Terjadwal Silahkan Cek Kembali</div>";
        }
        else if($this->uri->segment(4)=="fail_input"){

            $bln=$this->uri->segment(5);
            $thn=$this->uri->segment(6);
            $kdregu=$this->uri->segment(7);
            $usid=$this->uri->segment(8);
            $data['message']="<div class='alert alert-danger'>Data Bulan: <b>$bln</b> Tahun: <b>$thn</b> Regu: <b>$kdregu</b>  Sedang Dalam Proses Penjadwalan Oleh User : <b>$usid</b> 
								Silahkan melakukan Konfirmasi Pada User Tersebut</div>";
        }
        else if($this->uri->segment(4)=="failed_sama"){

            $tgl=$this->uri->segment(5);
            $kdregu=$this->uri->segment(6);
            $data['message']="<div class='alert alert-danger'>Data  Regu <b>$kdregu</b> Bulan <b>$tgl</b> Sudah Terjadwal, Silahkan Cek Kembali</div>";
        }
        else if($this->uri->segment(4)=="template_sama"){

            $bln=$this->uri->segment(5);
            $thn=$this->uri->segment(6);
            $kdregu=$this->uri->segment(7);
            $data['message']="<div class='alert alert-danger'>Data  Regu <b>$kdregu</b> Bulan <b>$bln</b> Tahun <b>$thn</b> Template sudah ada, Silahkan Cek Kembali</div>";
        }
        else if($this->uri->segment(4)=="jadwal_sama"){

            $bln=$this->uri->segment(5);
            $thn=$this->uri->segment(6);
            $kdregu=$this->uri->segment(7);
            $data['message']="<div class='alert alert-danger'>Data  Regu <b>$kdregu</b> Bulan <b>$bln</b> Tahun <b>$thn</b> Sudah Terjadwal, Silahkan Cek Kembali</div>";
        }
        else if($this->uri->segment(4)=="rs_failed"){

            $bulan=$this->uri->segment(5);
            $tahun=$this->uri->segment(6);
            $kdregu=$this->uri->segment(7);
            $data['message']="<div class='alert alert-danger'>Data  Regu <b>$kdregu</b> Bulan <b>$bulan</b> Tahun <b>$tahun</b> sudah lewat tempo, Silahkan Cek Kembali</div>";
        }
        else if($this->uri->segment(4)=="input_succes"){
            $tgl=$this->uri->segment(5);
            $kdregu=$this->uri->segment(6);
            $kdjamkerja=$this->uri->segment(7);
            $data['message']="<div class='alert alert-success'>Data Tanggal: <b>$tgl</b> Regu: <b>$kdregu</b> Shift: <b>$kdjamkerja</b> Berhasil Di Input</div>";
        }
        else if($this->uri->segment(4)=="gr_succes"){
            $blnuri=$this->uri->segment(5);
            $thnuri=$this->uri->segment(6);
            $kdregu=$this->uri->segment(7);
            $data['message']="<div class='alert alert-success'>Data Jadwal Kerja Bulan: <b>$blnuri</b> Tahun: <b>$thnuri</b> Regu:  <b>$kdregu</b> Berhasil Di Generate Dari Bulan Sebelumnya</div>";
        }
        else if($this->uri->segment(4)=="edit_sukses"){
            $blnuri=$this->uri->segment(6);
            $thnuri=$this->uri->segment(7);
            $data['message']="<div class='alert alert-success'>Edit regu berhasil Bulan: <b>$blnuri</b> Tahun: <b>$thnuri</b></div>";
        }
        else if($this->uri->segment(4)=="delete_success")
            $data['message']="<div class='alert alert-success'>Data berhasil di hapus</div>";
        else if($this->uri->segment(4)=="no_data")
            $data['message']="<div class='alert alert-warning'>Silahkan Input Jadwal Per Regu Terlebih Dahulu</div>";

        else
            $data['message']='';


        $thn1=$this->input->post('thn');
        $bln1=$this->input->post('bln');
        if ((empty($bln1)) and (empty($thn1)) and (empty($blnuri)) and (empty($thnuri))) {
            $bln=date('m');
            $thn=date('Y');
        } else if((!empty($bln1)) and (!empty($thn1))){
            $bln=$bln1;
            $thn=$thn1;
        } else if((!empty($blnuri)) and (!empty($thnuri))){
            $bln=$blnuri;
            $thn=$thnuri;
        } else{
            $bln=date('m');
            $thn=date('Y');
        }





        $this->db->query("select sc_trx.pr_listdtljadwalkerja('$bln','$thn')");
        $nik=$this->input->post('nik');
        $kdregu=$this->input->post('kdregu');
        $nama=$this->session->userdata('nik');
        $kmenu='I.T.B.8';
        $q_cek_bagianses=$this->m_regu->q_karyawan_session($nama)->row_array();
        $q_akses_ses=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        $q_usernotin=$this->m_akses->user_notin($nama)->num_rows();
        if($q_usernotin>0){
            $bag_dept='';
        }
        else{
            $bag_dept=$q_cek_bagianses['bag_dept'];
        }



        if (empty($nik) and !empty ($kdregu)){
            if(trim($q_akses_ses['aksesfilter'])=='t'){
                $bag_dept="and b.bag_dept='$bag_dept'";
                $read="and a.kdregu='$kdregu' $bag_dept";
            }else{$bag_dept="";
                $read="and a.kdregu='$kdregu' $bag_dept";
            }
        } else if (!empty($nik) and empty ($kdregu)){
            if(trim($q_akses_ses['aksesfilter'])=='t'){
                $bag_dept="and b.bag_dept='$bag_dept'";
                $read="and a.nik='$nik' $bag_dept";
            }else{$bag_dept="";
                $read="and a.nik='$nik' $bag_dept";
            }
        } else if (!empty($nik) and !empty ($kdregu)){
            if(trim($q_akses_ses['aksesfilter'])=='t'){
                $bag_dept="and b.bag_dept='$bag_dept'";
                $read="and a.kdregu='$kdregu' and a.nik='$nik' $bag_dept";
            }else{$bag_dept="";
                $read="and a.kdregu='$kdregu' and a.nik='$nik' $bag_dept";}

        } else {
            if(trim($q_akses_ses['aksesfilter'])=='t'){
                $bag_dept="and b.bag_dept='$bag_dept'";
                $read=" $bag_dept";
            }else{$bag_dept="";
                $read='';}
        }
        if (empty($thn) and !empty($bln)){
            $tahun=date('Y'); $bulan=$bln;
        } else if (empty($bln) and !empty($thn)) {
            $tahun=$thn; $bulan=date('m');
        } else if (empty($bln) and empty($thn)) {
            $tahun=date('Y'); $bulan=date('m');
        } else {
            $tahun=trim($thn); $bulan=trim($bln);
        }


        $data['bulan']=$bulan;
        $data['tahun']=$tahun;
        $data['title']="JADWAL KERJA";
        $data['oprblmjadwal']=$this->m_regu->q_cekdtlregu()->num_rows();
        $data['list_jadwal']=$this->m_jadwalnew->q_jadwalkerja($bulan,$tahun,$read)->result();

        $data['list_regu']=$this->m_jadwalnew->q_regu()->result();
        //$data['list_reguinjadwal']=$this->m_jadwalnew->q_regu_injadwal()->result();
        $data['list_reguinjadwal']=$this->m_jadwalnew->q_regu()->result();
        $data['list_karyawan']=$this->m_jadwalnew->q_karyawan()->result();
        $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
        //$data['cekdate']=
        $this->template->display('trans/jadwal/v_jadwalnew',$data);

    }

    /*
        function input_jadwal(){
            $kdregu=$this->input->post('kdregu');
            $tgl=$this->input->post('tanggal');
            list($day, $month, $year) = explode('-', $tgl);
            $tglbulan=$month;
            $tgltahun=$year;
            $kdjamkerja=$this->input->post('kdjamkerja');
            $cek=$this->m_jadwalnew->cek_exist($kdregu,$tgl);
            $info = array(

                    'kdregu' => trim(strtoupper($kdregu)),
                    'kodejamkerja' => trim(strtoupper($kdjamkerja)),
                    'tgl' => $tgl,
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => trim($this->session->userdata('nik')),
                );
            if ($cek>0) {
                redirect("trans/jadwal_new/index/failed/$tgl/$kdregu/$kdjamkerja");
            } else {
                $this->db->insert('sc_trx.jadwalkerja',$info);
                $this->db->query("select sc_trx.pr_listdtljadwalkerja('$tglbulan','$tgltahun')");
                redirect("trans/jadwal_new/index/input_succes/$tgl/$kdregu/$kdjamkerja");
            }

        }
    */
    function ajax_cekjadwalinput($thn,$bln,$kdregu){

        $data = $this->m_jadwalnew->q_offjadwalkerja($thn,$bln,$kdregu)->num_rows();
        echo json_encode($data);
        //echo 'tae';
    }
    function view_jadwalsebulan(){
        $userid=$this->session->userdata('nik');

        $cektmp=$this->m_jadwalnew->q_tmpjadwalid($userid)->num_rows();
        $isivar=$this->m_jadwalnew->q_tmpjadwalid($userid)->row_array();
        if($cektmp>0){
            $kdregu=trim($isivar['kdregu']);
            $tgl=$isivar['tgl'];
            list($year, $month, $day) = explode('-', $tgl);
            $bln=$month;
            $thn=$year;
            redirect("trans/jadwal_new/view_tmpjadwal/$kdregu/$bln/$thn");
        }

        $data['title']="JADWAL KERJA BULANAN";

        $data['list_regu']=$this->m_jadwalnew->q_regu()->result();
        $data['list_karyawan']=$this->m_jadwalnew->q_karyawan()->result();
        $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
        $this->template->display('trans/jadwal/v_inputjadwalsebulan',$data);
    }

    function input_jadwalsebulan(){
        $kdregu=$this->input->post('kdregu');
        $bln=$this->input->post('bln');
        $thn=$this->input->post('thn');
        $tgl1=$this->input->post('tgl1');
        $tgl2=$this->input->post('tgl2');
        $tgl3=$this->input->post('tgl3');
        $tgl4=$this->input->post('tgl4');
        $tgl5=$this->input->post('tgl5');
        $tgl6=$this->input->post('tgl6');
        $tgl7=$this->input->post('tgl7');
        $tgl8=$this->input->post('tgl8');
        $tgl9=$this->input->post('tgl9');
        $tgl10=$this->input->post('tgl10');
        $tgl11=$this->input->post('tgl11');
        $tgl12=$this->input->post('tgl12');
        $tgl13=$this->input->post('tgl13');
        $tgl14=$this->input->post('tgl14');
        $tgl15=$this->input->post('tgl15');
        $tgl16=$this->input->post('tgl16');
        $tgl17=$this->input->post('tgl17');
        $tgl18=$this->input->post('tgl18');
        $tgl19=$this->input->post('tgl19');
        $tgl20=$this->input->post('tgl20');
        $tgl21=$this->input->post('tgl21');
        $tgl22=$this->input->post('tgl22');
        $tgl23=$this->input->post('tgl23');
        $tgl24=$this->input->post('tgl24');
        $tgl25=$this->input->post('tgl25');
        $tgl26=$this->input->post('tgl26');
        $tgl27=$this->input->post('tgl27');
        $tgl28=$this->input->post('tgl28');
        $tgl29=$this->input->post('tgl29');
        $tgl30=$this->input->post('tgl30');
        $tgl31=$this->input->post('tgl31');

        //$cektmp=$this->m_jadwalnew->q_tmpjadwal()->num_rows();
        $userid=$this->session->userdata('nik');
        $isivar=$this->m_jadwalnew->q_tmpjadwal()->row_array();
        $tgl=$isivar['tgl'];
        list($year, $month, $day) = explode('-', $tgl);
        $blntmp=$month;
        $thntmp=$year;
        $usid=trim($isivar['inputby']);
        $kdregutmp=trim($isivar['kdregu']);

        if($bln==$blntmp and $thn==$thntmp and $kdregu==$kdregutmp){

            $usid=trim($isivar['inputby']);
            redirect("trans/jadwal_new/index/fail_input/$bln/$thn/$kdregu/$usid");
        }



        if ($tgl1<>'OFF') {
            $tgl=trim("$thn-$bln-01");
            $kdjamkerja=$tgl1;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }
        if ($tgl2<>'OFF') {
            $tgl=trim("$thn-$bln-02");
            $kdjamkerja=$tgl2;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        } if ($tgl3<>'OFF') {
            $tgl=date("$thn-$bln-03");
            $kdjamkerja=$tgl3;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }  if ($tgl4<>'OFF') {
            $tgl=date("$thn-$bln-04");
            $kdjamkerja=$tgl4;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }  if ($tgl5<>'OFF') {
            $tgl=date("$thn-$bln-05");
            $kdjamkerja=$tgl5;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl6<>'OFF') {
            $tgl=date("$thn-$bln-06");
            $kdjamkerja=$tgl6;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl7<>'OFF') {
            $tgl=date("$thn-$bln-07");
            $kdjamkerja=$tgl7;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl8<>'OFF') {
            $tgl=date("$thn-$bln-08");
            $kdjamkerja=$tgl8;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl9<>'OFF') {
            $tgl=date("$thn-$bln-09");
            $kdjamkerja=$tgl9;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl10<>'OFF') {
            $tgl=date("$thn-$bln-10");
            $kdjamkerja=$tgl10;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl11<>'OFF') {
            $tgl=date("$thn-$bln-11");
            $kdjamkerja=$tgl11;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl12<>'OFF') {
            $tgl=date("$thn-$bln-12");
            $kdjamkerja=$tgl12;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl13<>'OFF') {
            $tgl=date("$thn-$bln-13");
            $kdjamkerja=$tgl13;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl14<>'OFF') {
            $tgl=date("$thn-$bln-14");
            $kdjamkerja=$tgl14;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl15<>'OFF') {
            $tgl=date("$thn-$bln-15");
            $kdjamkerja=$tgl15;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl16<>'OFF') {
            $tgl=date("$thn-$bln-16");
            $kdjamkerja=$tgl16;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl17<>'OFF') {
            $tgl=date("$thn-$bln-17");
            $kdjamkerja=$tgl17;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl18<>'OFF') {
            $tgl=date("$thn-$bln-18");
            $kdjamkerja=$tgl18;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl19<>'OFF') {
            $tgl=date("$thn-$bln-19");
            $kdjamkerja=$tgl19;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl20<>'OFF') {
            $tgl=date("$thn-$bln-20");
            $kdjamkerja=$tgl20;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl21<>'OFF') {
            $tgl=date("$thn-$bln-21");
            $kdjamkerja=$tgl21;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl22<>'OFF') {
            $tgl=date("$thn-$bln-22");
            $kdjamkerja=$tgl22;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl23<>'OFF') {
            $tgl=date("$thn-$bln-23");
            $kdjamkerja=$tgl23;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl24<>'OFF') {
            $tgl=date("$thn-$bln-24");
            $kdjamkerja=$tgl24;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl25<>'OFF') {
            $tgl=date("$thn-$bln-25");
            $kdjamkerja=$tgl25;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl26<>'OFF') {
            $tgl=date("$thn-$bln-26");
            $kdjamkerja=$tgl26;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl27<>'OFF') {
            $tgl=date("$thn-$bln-27");
            $kdjamkerja=$tgl27;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl28<>'OFF') {
            $tgl=date("$thn-$bln-28");
            $kdjamkerja=$tgl28;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl29<>'OFF') {
            $tgl=date("$thn-$bln-29");
            $kdjamkerja=$tgl29;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl30<>'OFF') {
            $tgl=date("$thn-$bln-30");
            $kdjamkerja=$tgl30;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }   if ($tgl31<>'OFF') {
            $tgl=date("$thn-$bln-31");
            $kdjamkerja=$tgl31;
            $info = array(
                'kdregu' => strtoupper($kdregu),
                'kodejamkerja' => strtoupper($kdjamkerja),
                'inputdate' => date('d-m-Y H:i:s'),
                'inputby' => $this->session->userdata('nik'),
                'tgl' => $tgl,
                'status'=> 'I'
            );
            $this->db->insert('sc_tmp.jadwalkerja',$info);

        }
        redirect("trans/jadwal_new/view_tmpjadwal/$kdregu/$bln/$thn");

    }

    function view_tmpjadwal(){
        $kdregu=$this->uri->segment(4);
        $bln=$this->uri->segment(5);
        $thn=$this->uri->segment(6);
        $userid=$this->session->userdata('nik');

        $data['title']='PROSES PENJADWALAN ';
        $data['kdregu']=$kdregu;
        $data['bln']=$bln;
        $data['thn']=$thn;

        $data['list_karyawan']=$this->m_jadwalnew->q_karyawan()->result();
        $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
        $data['list_tmpjadwal']=$this->m_jadwalnew->q_tmpjadwalid($userid)->result();
        $this->template->display('trans/jadwal/v_tmpjadwalkerja',$data);

    }

    function edit_tmpjadwal(){
        $kdregu=$this->input->post('kdregu');
        $tgl=$this->input->post('tgl');
        list($year, $month, $day) = explode('-', $tgl);
        $bln=$month;
        $thn=$year;
        $kodejamkerja=$this->input->post('kdjamkerja');
        $data = array(
            'kodejamkerja' => $kodejamkerja
        );

        $this->db->where('kdregu', $kdregu);
        $this->db->where('tgl', $tgl);
        $this->db->update('sc_tmp.jadwalkerja', $data);


        redirect("trans/jadwal_new/view_tmpjadwal/$kdregu/$bln/$thn");
    }

    function savefinal_tmpjadwal(){
        $tglbulan=$this->uri->segment(4);
        $tgltahun=$this->uri->segment(5);
        $userid=$this->session->userdata('nik');
        $status='F';
        $data = array(
            'status' => $status
        );
        $this->db->where('inputby',$userid);
        $this->db->update('sc_tmp.jadwalkerja', $data);
        $this->db->query("select sc_trx.pr_listdtljadwalkerja('$tglbulan','$tgltahun')");
        redirect("trans/jadwal_new/index");
    }

    function clear_tmpjadwal(){
        $userid=$this->session->userdata('nik');
        $this->db->query("delete from sc_tmp.jadwalkerja where inputby='$userid'");
        redirect("trans/jadwal_new/view_jadwalsebulan/$kdregu/$bln/$thn");
    }

    function delete_tmpjadwal(){
        $kdregu=trim($this->uri->segment(4));
        $tgl=trim($this->uri->segment(5));
        $kodejamkerja=trim($this->uri->segment(6));
        $userid=$this->session->userdata('nik');
        list($year, $month, $day) = explode('-', $tgl);
        $bln=$month;
        $thn=$year;
        //echo $kdregu, $tgl, $kodejamkerja;
        $this->db->where('kdregu', $kdregu);
        $this->db->where('tgl', $tgl);
        $this->db->where('kodejamkerja', $kodejamkerja);
        $this->db->where('inputby', $userid);
        $this->db->delete('sc_tmp.jadwalkerja');
        redirect("trans/jadwal_new/view_tmpjadwal/$kdregu/$bln/$thn");
    }

    function edit_jadwal(){
        $id=$this->input->post('id');
        $kdregu=$this->input->post('kdregu');
        //$shift=$this->input->post('shift');
        $tgl=$this->input->post('tanggal');
        $kdjamkerja=$this->input->post('kdjamkerja');
        $cek=$this->m_absensi->cek_exist($kdregu,$kdjamkerja,$tgl);
        $info = array(
            //'shift_tipe' => $this->input->post('shiftkrj'),
            'kdregu' => strtoupper($kdregu),
            'kodejamkerja' => strtoupper($kdjamkerja),
            'tgl' => $tgl,
            //'shift_tipe' => $shift,
            'updatedate' => date('d-m-Y H:i:s'),
            'updateby' => $this->session->userdata('nik'),
        );
        /*if ($cek>0) {
          echo "DATA SUDAH ADA";
        } else {
            $this->db->insert('sc_trx.jadwalkerja',$info);
            redirect('trans/jadwal_new/index');
        }*/
        $this->db->where('id',$id);
        $this->db->update('sc_trx.jadwalkerja',$info);
        redirect('trans/jadwal_new/index');

    }



    function edit_jadwal_detail(){
        $nik=$this->input->post('nik');
        $kdregu=$this->input->post('kdregu');
        $kdregu_old=$this->input->post('kdregu_old');
        $kdmesin=$this->input->post('kdmesin');
        //$shift=$this->input->post('shift');
        $tgl=$this->input->post('tanggal');
        $tgl_old=$this->input->post('tanggal_old');
        $id=$this->input->post('id');
        $kdjamkerja=$this->input->post('kdjamkerja');
        $cek=$this->m_absensi->cek_exist($kdregu,$kdjamkerja,$tgl);
        $info = array(
            //'shift_tipe' => $this->input->post('shiftkrj'),
            'kdregu' => strtoupper($kdregu),
            //'kdmesin' => strtoupper($kdmesin),
            'nik' => strtoupper($nik),
            'kdjamkerja' => strtoupper($kdjamkerja),
            'tgl' => $tgl,
            //'shift_tipe' => $shift,
            'updatedate' => date('d-m-Y H:i:s'),
            'updateby' => $this->session->userdata('nik'),
        );
        if ($cek>0) {
            //echo "BOLEH DI INSERT";
            $this->db->where('nik',$nik);
            $this->db->where('tgl',$tgl_old);
            $this->db->where('id',$id);
            $this->db->update('sc_trx.dtljadwalkerja',$info);
            redirect("trans/jadwal_new/detail_regu/$tgl_old/$kdregu_old");
        } else {
            echo "DATA BELUM ADA";
        }


    }


    function delete_jadwal($id){
        $this->db->where('id',$id);
        $this->db->delete('sc_trx.jadwalkerja');
        redirect('trans/jadwal_new/index');

    }

    function delete_jadwal_detail($id,$tgl_kerja,$kdregu){
        $this->db->where('id',$id);
        $this->db->delete('sc_trx.dtljadwalkerja');
        redirect("trans/jadwal_new/detail_regu/$tgl_kerja/$kdregu");

    }

    function edit_detail($nik,$tgl){
        //echo $nik.'||'.$tgl;
        $data['title']='EDIT JADWAL KERJA';
        $cek=$this->m_jadwalnew->q_dtljadwalkerja_nik($nik,$tgl)->num_rows();
        if ($cek>0){
            $data['dtl_jadwal']=$this->m_jadwalnew->q_dtljadwalkerja_nik($nik,$tgl)->row_array();
            $data['dtl_tgl']=$tgl;
            $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
            $this->template->display('trans/jadwal/v_editdtljadwalnew',$data);
        } else {
            $bulan=date("m",strtotime($tgl));
            $data['dtl_jadwal']=$this->m_jadwalnew->q_vsebulanjadwal($nik,$bulan)->row_array();
            $data['dtl_tgl']=$tgl;
            $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
            $this->template->display('trans/jadwal/v_editdtljadwalnew',$data);
            //redirect('trans/jadwal_new/index/no_data');
        }


    }

    function proses_edit_detail(){
        $nik=$this->input->post('nik');
        $kdregu=$this->input->post('kdregu');
        //$kdregu_old=$this->input->post('kdregu_old');
        //$kdmesin=$this->input->post('kdmesin');
        //$shift=$this->input->post('shift');
        $tgl=$this->input->post('tanggal');
        $tgl_old=$this->input->post('tanggal_old');
        $id=$this->input->post('id');
        $kdjamkerja=$this->input->post('kdjamkerja');

        $cekdtl=$this->m_jadwalnew->cek_exist_detail2($nik,$kdregu,$tgl);

        if($kdjamkerja=='OFF'){
            $this->db->where('nik',$nik);
            $this->db->where('kdregu',$kdregu);
            $this->db->where('tgl',$tgl);
            $this->db->delete('sc_trx.dtljadwalkerja');

        }else if($cekdtl=='0'){
            $info = array(

                'kdregu' => strtoupper(trim($kdregu)),
                'kdmesin' => strtoupper($kdmesin),
                'nik' =>trim($nik),
                'kdjamkerja' => strtoupper($kdjamkerja),
                'tgl' => $tgl,
                'updatedate' => date('d-m-Y H:i:s'),
                'updateby' => $this->session->userdata('nik'),
            );
            $this->db->where('nik',$nik);
            $this->db->where('kdregu',$kdregu);
            $this->db->insert('sc_trx.dtljadwalkerja',$info);
        }
        else{
            $info = array(

                'kdmesin' => strtoupper($kdmesin),
                'kdjamkerja' => strtoupper($kdjamkerja),
                'updatedate' => date('d-m-Y H:i:s'),
                'updateby' => $this->session->userdata('nik'),
            );
            $this->db->where('nik',$nik);
            $this->db->where('kdregu',$kdregu);
            $this->db->where('tgl',$tgl);
            $this->db->update('sc_trx.dtljadwalkerja',$info);
        }

        redirect("trans/jadwal_new/index");
        //echo $cekdtl;
    }

    function opr_belumjadwal() {
        $data["title"] = "NIK REGU YANG BELUM MEMILIKI JADWAL";
        if($this->uri->segment(4) == "failed") {
            $nik = $this->uri->segment(5);
            $kdregu = $this->uri->segment(6);
            $data["message"] = "<div class='alert alert-danger'>NIK: <b>$nik</b> Regu: <b>$kdregu</b> Tidak berhasil disimpan</div>";
        } else if($this->uri->segment(4) == "sukses") {
            $nik = $this->uri->segment(5);
            $kdregu = $this->uri->segment(6);
            $data["message"] = "<div class='alert alert-success'>NIK: <b>$nik</b> Regu: <b>$kdregu</b> Berhasil dijadwalkan</div>";
        } else {
            $data["message"] = "";
        }

        $data["list_regu"] = $this->m_jadwalnew->q_regu()->result();
        $data["list_jamkerja"] = $this->m_jadwalnew->q_jamkerja()->result();
        $this->template->display("trans/jadwal/v_inputoprbelum", $data);
    }

    function get_karyawan() {
        $periode = $this->input->post("periode");

        echo json_encode($this->m_regu->q_cekdtlregu_periode($periode)->result());
    }

    function simpan_oprdtljadwal() {
        $nik = $this->input->post("nik");
        $kdregu = $this->input->post("kdregu");
        $bulan = explode("-", $this->input->post("periode"))[0];
        $tahun = explode("-", $this->input->post("periode"))[1];
        $data = [];
        for($i = 1; $i <= 31; $i++) {
            $tgl = $this->input->post("tgl$i");
            if($tgl != "OFF" && checkdate($bulan, str_pad($i, 2, "0", 0), $tahun)) {
                $data[] = array (
                    "nik" => $nik,
                    "tgl" => trim("$tahun-$bulan-" . str_pad($i, 2, "0", 0)),
                    "kdjamkerja" => $tgl,
                    "kdregu" => strtoupper($kdregu),
                    "inputdate" => date("d-m-Y H:i:s"),
                    "inputby" => $this->session->userdata("nik")
                );
            }
        }
        $this->db->insert_batch('sc_trx.dtljadwalkerja', $data);
        
        $this->db->where("nik", $nik);
        $this->db->delete("sc_tmp.regu_opr");
        redirect("trans/jadwal_new/opr_belumjadwal/sukses/$nik/$kdregu");
    }


    function inputjadwal_sama(){
        $data['title']='PROSES PENJADWALAN ';
        $data['list_regu']=$this->m_jadwalnew->q_regu()->result();
        $data['list_karyawan']=$this->m_jadwalnew->q_karyawan()->result();
        $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
        $this->template->display('trans/jadwal/v_inputjadwalsama',$data);

    }
    function proses_inputjadwal_sama(){
        $userid=$this->session->userdata('nik');
        $kdregubaru=$this->input->post('kdregubaru');
        $kdregulama=$this->input->post('kdregulama');
        $bln=$this->input->post('bln');
        $thn=$this->input->post('thn');
        $periode=$thn.'-'.$bln;
        $cek=$this->m_jadwalnew->q_reguadajadwal($kdregubaru,$periode)->num_rows();
        if ($cek>0) {
            redirect("trans/jadwal_new/index/failed_sama/$bln/$kdregubaru");

        } else {
            $this->db->query("delete from sc_tmp.jadwalkerja where kdregu='$kdregubaru' and to_char(tgl,'YYYY-MM')='$periode'");
            $this->db->query("insert into sc_tmp.jadwalkerja(kdregu,kodejamkerja,inputdate,inputby,tgl,status)
								select '$kdregubaru' as kdregu,kodejamkerja,inputdate,'$userid' as inputby,tgl,'I' as status from sc_trx.jadwalkerja
								where kdregu='$kdregulama' and to_char(tgl,'YYYY-MM')='$periode'");
            redirect("trans/jadwal_new/view_tmpjadwal/$kdregubaru/$bln/$thn");
        }
    }

    function edit_jadwaloff(){
        $data['title']='EDIT JADWAL KERJA PER REGU';
        $kdregu=$this->input->post('kdregu2');
        $bln=$this->input->post('bln');
        $data['bln']=$bln;
        $thn=$this->input->post('thn');
        $data['thn']=$thn;
        $data['list_regu']=$this->m_jadwalnew->q_regu()->result();
        //$data['list_karyawan']=$this->m_jadwalnew->q_karyawan()->result();
        $data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();
        $dtl_jk=$this->m_jadwalnew->q_offjadwalkerja($thn,$bln,$kdregu)->result();
        $data['dtl']=$this->m_jadwalnew->q_offjadwalkerja($thn,$bln,$kdregu)->row_array();
        if(empty($data['dtl']['kdregu'])){
            redirect("trans/jadwal_new/index/no_data");
        }
        $j=1;for($i=31;$i>=$j;$j++){
            $data["tgl$j"]=array('kodejamkerja' => null);
        }

        foreach($dtl_jk as $jk){
            if(($jk->tgl)==("$thn-$bln-01")){
                $tgl="$thn-$bln-01";
                $data['tgl1']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-02")){
                $tgl="$thn-$bln-02";
                $data['tgl2']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-03")){
                $tgl="$thn-$bln-03";
                $data['tgl3']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-04")){
                $tgl="$thn-$bln-04";
                $data['tgl4']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-05")){
                $tgl="$thn-$bln-05";
                $data['tgl5']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-06")){
                $tgl="$thn-$bln-06";
                $data['tgl6']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-07")){
                $tgl="$thn-$bln-07";
                $data['tgl7']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-08")){
                $tgl="$thn-$bln-08";
                $data['tgl8']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-09")){
                $tgl="$thn-$bln-09";
                $data['tgl9']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-10")){
                $tgl="$thn-$bln-10";
                $data['tgl10']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-11")){
                $tgl="$thn-$bln-11";
                $data['tgl11']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-12")){
                $tgl="$thn-$bln-12";
                $data['tgl12']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-13")){
                $tgl="$thn-$bln-13";
                $data['tgl13']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-14")){
                $tgl="$thn-$bln-14";
                $data['tgl14']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-15")){
                $tgl="$thn-$bln-15";
                $data['tgl15']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-16")){
                $tgl="$thn-$bln-16";
                $data['tgl16']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-17")){
                $tgl="$thn-$bln-17";
                $data['tgl17']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-18")){
                $tgl="$thn-$bln-18";
                $data['tgl18']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-19")){
                $tgl="$thn-$bln-19";
                $data['tgl19']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-20")){
                $tgl="$thn-$bln-20";
                $data['tgl20']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-21")){
                $tgl="$thn-$bln-21";
                $data['tgl21']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-22")){
                $tgl="$thn-$bln-22";
                $data['tgl22']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-23")){
                $tgl="$thn-$bln-23";
                $data['tgl23']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-24")){
                $tgl="$thn-$bln-24";
                $data['tgl24']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-25")){
                $tgl="$thn-$bln-25";
                $data['tgl25']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-26")){
                $tgl="$thn-$bln-26";
                $data['tgl26']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-27")){
                $tgl="$thn-$bln-27";
                $data['tgl27']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-28")){
                $tgl="$thn-$bln-28";
                $data['tgl28']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-29")){
                $tgl="$thn-$bln-29";
                $data['tgl29']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-30")){
                $tgl="$thn-$bln-30";
                $data['tgl30']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();
            }
            if(($jk->tgl)==("$thn-$bln-31")){
                $tgl="$thn-$bln-31";
                $data['tgl31']=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->row_array();

            }

        }
        $this->template->display('trans/jadwal/v_editdtljadwaloff',$data);
    }
    function simpan_offjadwal(){
        $nik=$this->input->post('nik');
        $kdregu=$this->input->post('kdregu');
        $bln=$this->input->post('bln');
        $thn=$this->input->post('thn');
        $tgl1=$this->input->post('tgl1');
        $tgl2=$this->input->post('tgl2');
        $tgl3=$this->input->post('tgl3');
        $tgl4=$this->input->post('tgl4');
        $tgl5=$this->input->post('tgl5');
        $tgl6=$this->input->post('tgl6');
        $tgl7=$this->input->post('tgl7');
        $tgl8=$this->input->post('tgl8');
        $tgl9=$this->input->post('tgl9');
        $tgl10=$this->input->post('tgl10');
        $tgl11=$this->input->post('tgl11');
        $tgl12=$this->input->post('tgl12');
        $tgl13=$this->input->post('tgl13');
        $tgl14=$this->input->post('tgl14');
        $tgl15=$this->input->post('tgl15');
        $tgl16=$this->input->post('tgl16');
        $tgl17=$this->input->post('tgl17');
        $tgl18=$this->input->post('tgl18');
        $tgl19=$this->input->post('tgl19');
        $tgl20=$this->input->post('tgl20');
        $tgl21=$this->input->post('tgl21');
        $tgl22=$this->input->post('tgl22');
        $tgl23=$this->input->post('tgl23');
        $tgl24=$this->input->post('tgl24');
        $tgl25=$this->input->post('tgl25');
        $tgl26=$this->input->post('tgl26');
        $tgl27=$this->input->post('tgl27');
        $tgl28=$this->input->post('tgl28');
        $tgl29=$this->input->post('tgl29');
        $tgl30=$this->input->post('tgl30');
        $tgl31=$this->input->post('tgl31');

        if ($tgl1<>'OFF') { /* tgl1 */
            $tgl=trim("$thn-$bln-01");
            $kdjamkerja=$tgl1;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }

        } else if($tgl1=='OFF'){

            $tgl=trim("$thn-$bln-01");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');
            //echo 'off',$tgl,$kdregu;
        }
        if ($tgl2<>'OFF') { /* tgl2 */
            $tgl=trim("$thn-$bln-02");
            $kdjamkerja=$tgl2;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl2=='OFF'){

            $tgl=trim("$thn-$bln-02");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl3<>'OFF') { /* tgl3 */
            $tgl=trim("$thn-$bln-03");
            $kdjamkerja=$tgl3;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl3=='OFF'){

            $tgl=trim("$thn-$bln-03");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl4<>'OFF') { /* tgl4 */
            $tgl=trim("$thn-$bln-04");
            $kdjamkerja=$tgl4;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl4=='OFF'){

            $tgl=trim("$thn-$bln-04");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl5<>'OFF') { /* tgl5 */
            $tgl=trim("$thn-$bln-05");
            $kdjamkerja=$tgl5;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl5=='OFF'){

            $tgl=trim("$thn-$bln-05");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl6<>'OFF') { /* tgl6 */
            $tgl=trim("$thn-$bln-06");
            $kdjamkerja=$tgl6;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl6=='OFF'){

            $tgl=trim("$thn-$bln-06");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl7<>'OFF') { /* tgl7 */
            $tgl=trim("$thn-$bln-07");
            $kdjamkerja=$tgl7;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl7=='OFF'){

            $tgl=trim("$thn-$bln-07");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl8<>'OFF') { /* tgl8 */
            $tgl=trim("$thn-$bln-08");
            $kdjamkerja=$tgl8;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl8=='OFF'){

            $tgl=trim("$thn-$bln-08");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl9<>'OFF') { /* tgl9 */
            $tgl=trim("$thn-$bln-09");
            $kdjamkerja=$tgl9;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl9=='OFF'){

            $tgl=trim("$thn-$bln-09");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl10<>'OFF') { /* tgl10 */
            $tgl=trim("$thn-$bln-10");
            $kdjamkerja=$tgl10;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl10=='OFF'){

            $tgl=trim("$thn-$bln-10");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl11<>'OFF') { /* tgl11 */
            $tgl=trim("$thn-$bln-11");
            $kdjamkerja=$tgl11;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl11=='OFF'){

            $tgl=trim("$thn-$bln-11");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl12<>'OFF') { /* tgl12 */
            $tgl=trim("$thn-$bln-12");
            $kdjamkerja=$tgl12;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl12=='OFF'){

            $tgl=trim("$thn-$bln-12");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl13<>'OFF') { /* tgl13 */
            $tgl=trim("$thn-$bln-13");
            $kdjamkerja=$tgl13;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl13=='OFF'){

            $tgl=trim("$thn-$bln-13");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl14<>'OFF') { /* tgl14 */
            $tgl=trim("$thn-$bln-14");
            $kdjamkerja=$tgl14;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl14=='OFF'){

            $tgl=trim("$thn-$bln-14");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl15<>'OFF') { /* tgl15 */
            $tgl=trim("$thn-$bln-15");
            $kdjamkerja=$tgl15;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl15=='OFF'){

            $tgl=trim("$thn-$bln-15");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl16<>'OFF') { /* tgl16 */
            $tgl=trim("$thn-$bln-16");
            $kdjamkerja=$tgl16;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl16=='OFF'){

            $tgl=trim("$thn-$bln-16");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl17<>'OFF') { /* tgl17 */
            $tgl=trim("$thn-$bln-17");
            $kdjamkerja=$tgl17;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl17=='OFF'){

            $tgl=trim("$thn-$bln-17");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl18<>'OFF') { /* tgl18 */
            $tgl=trim("$thn-$bln-18");
            $kdjamkerja=$tgl18;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl18=='OFF'){

            $tgl=trim("$thn-$bln-18");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl19<>'OFF') { /* tgl19 */
            $tgl=trim("$thn-$bln-19");
            $kdjamkerja=$tgl19;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl19=='OFF'){

            $tgl=trim("$thn-$bln-19");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl20<>'OFF') { /* tgl20 */
            $tgl=trim("$thn-$bln-20");
            $kdjamkerja=$tgl20;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl20=='OFF'){

            $tgl=trim("$thn-$bln-20");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl21<>'OFF') { /* tgl21 */
            $tgl=trim("$thn-$bln-21");
            $kdjamkerja=$tgl21;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl21=='OFF'){

            $tgl=trim("$thn-$bln-21");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl22<>'OFF') { /* tgl22 */
            $tgl=trim("$thn-$bln-22");
            $kdjamkerja=$tgl22;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl22=='OFF'){

            $tgl=trim("$thn-$bln-22");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl23<>'OFF') { /* tgl23 */
            $tgl=trim("$thn-$bln-23");
            $kdjamkerja=$tgl23;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl23=='OFF'){

            $tgl=trim("$thn-$bln-23");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl24<>'OFF') { /* tgl24 */
            $tgl=trim("$thn-$bln-24");
            $kdjamkerja=$tgl24;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl24=='OFF'){

            $tgl=trim("$thn-$bln-24");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl25<>'OFF') { /* tgl25 */
            $tgl=trim("$thn-$bln-25");
            $kdjamkerja=$tgl25;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl25=='OFF'){

            $tgl=trim("$thn-$bln-25");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl26<>'OFF') { /* tgl26 */
            $tgl=trim("$thn-$bln-26");
            $kdjamkerja=$tgl26;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl26=='OFF'){

            $tgl=trim("$thn-$bln-26");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl27<>'OFF') { /* tgl27 */
            $tgl=trim("$thn-$bln-27");
            $kdjamkerja=$tgl27;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl27=='OFF'){

            $tgl=trim("$thn-$bln-27");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl28<>'OFF' && checkdate($bln, '28', $thn)) { /* tgl28 */
            $tgl=trim("$thn-$bln-28");
            $kdjamkerja=$tgl28;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl28=='OFF' && checkdate($bln, '28', $thn)){

            $tgl=trim("$thn-$bln-28");
            $this->db->where('tgl',$tgl);
            $this->db->where('kdregu',$kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl29<>'OFF' && checkdate($bln, '29', $thn)) { /* tgl29 */
            $tgl=trim("$thn-$bln-29");
            $kdjamkerja=$tgl29;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl29=='OFF' && checkdate($bln, '29', $thn)){

            $tgl = trim("$thn-$bln-29");
            $this->db->where('tgl', $tgl);
            $this->db->where('kdregu', $kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl30<>'OFF' && checkdate($bln, '30', $thn)) { /* tgl30 */
            $tgl=trim("$thn-$bln-30");
            $kdjamkerja=$tgl30;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            if(($cek_j)>0){
                $info = array(
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'updatedate' => date('d-m-Y H:i:s'),
                    'updateby' => $this->session->userdata('nik')
                );
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->update('sc_trx.jadwalkerja',$info);
            } else{
                $info = array(
                    'kdregu' => strtoupper($kdregu),
                    'kodejamkerja' => strtoupper($kdjamkerja),
                    'inputdate' => date('d-m-Y H:i:s'),
                    'inputby' => $this->session->userdata('nik'),
                    'tgl' => $tgl
                );
                $this->db->insert('sc_trx.jadwalkerja',$info);
            }
        } else if($tgl30=='OFF' && checkdate($bln, '30', $thn)){

            $tgl = trim("$thn-$bln-30");
            $this->db->where('tgl', $tgl);
            $this->db->where('kdregu', $kdregu);
            $this->db->delete('sc_trx.jadwalkerja');

        }
        if ($tgl31<>'OFF' && checkdate($bln, '31', $thn)) { /* tgl31 */
            $tgl=trim("$thn-$bln-31");
            $kdjamkerja=$tgl31;
            $cek_j=$this->m_jadwalnew->q_offjk_row($tgl,$kdregu)->num_rows();
            $a_date = $tgl;
            $endday=date("Y-m-t", strtotime($tgl));
            if($endday<=$tgl){
                if(($cek_j)>0){
                    $info = array(
                        'kodejamkerja' => strtoupper($kdjamkerja),
                        'updatedate' => date('d-m-Y H:i:s'),
                        'updateby' => $this->session->userdata('nik')
                    );
                    $this->db->where('tgl',$tgl);
                    $this->db->where('kdregu',$kdregu);
                    $this->db->update('sc_trx.jadwalkerja',$info);
                } else{
                    $info = array(
                        'kdregu' => strtoupper($kdregu),
                        'kodejamkerja' => strtoupper($kdjamkerja),
                        'inputdate' => date('d-m-Y H:i:s'),
                        'inputby' => $this->session->userdata('nik'),
                        'tgl' => $tgl
                    );
                    $this->db->insert('sc_trx.jadwalkerja',$info);
                }
            }
        } else if($tgl31=='OFF' && checkdate($bln, '31', $thn)){

            $tgl=trim("$thn-$bln-31");
            $endday=date("Y-m-t", strtotime($tgl));
            if($endday<=$tgl){
                $this->db->where('tgl',$tgl);
                $this->db->where('kdregu',$kdregu);
                $this->db->delete('sc_trx.jadwalkerja');
            }
        }

        redirect("trans/jadwal_new/index/edit_sukses/$kdregu/$bln/$thn");

    }

    public function excel_dtljadwalall(){

        $typedl=$this->input->post('typedl');
        $thn=$this->input->post('thn');
        $bln=$this->input->post('bln');
        $kdregu=$this->input->post('kdregu');

        if($typedl=='BS'){
            $datane=$this->m_jadwalnew->q_excel_jadwalregu($thn,$bln);
            $this->excel_generator->set_query($datane);
            $this->excel_generator->set_header(array('KODE REGU','KODE JAM KERJA','TANGGAL KERJA'
            ));
            $this->excel_generator->set_column(array('kdregu','kodejamkerja','tgl'
            ));
            $this->excel_generator->set_width(array(20,20,20
            ));
            $this->excel_generator->exportTo2007("JADWALKERJA_REGU");}
        else if($typedl=='BP'){
            $this->db->query("select sc_trx.pr_exceljadwalregu('$bln','$thn')");
            $datane=$this->m_jadwalnew->q_excel_jadwalregusamping($thn,$bln);
            $this->excel_generator->set_query($datane);
            $this->excel_generator->set_header(array('NAMA REGU','BULAN','TAHUN','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'
            ));
            $this->excel_generator->set_column(array('kdregu','bulan','tahun','tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
                'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31'
            ));
            $this->excel_generator->set_width(array(8,8,8,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,
                4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4
            ));
            $this->excel_generator->exportTo2007("JADWALKERJA_REGU $bln $thn");}

        else if($typedl=='DL'){
            $this->db->query("select sc_trx.pr_listdtljadwalkerja('$bln','$thn')");
            $datane=$this->m_jadwalnew->q_excel_dtljadwalregu($thn,$bln);
            $this->excel_generator->set_query($datane);
            $this->excel_generator->set_header(array('NIK','NAMA LENGKAP','KODE REGU','BULAN','TAHUN',
                '1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'
            ));
            $this->excel_generator->set_column(array('nik','nmlengkap','kdregu','bulan','tahun',
                'tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
                'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31'
            ));
            $this->excel_generator->set_width(array(20,20,20,4,8,5,
                4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,
                4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4
            ));
            $this->excel_generator->exportTo2007("JADWALKERJA_DTL");

        }
        else{
            $this->db->query("select sc_trx.pr_listdtljadwalkerja('$bln','$thn')");
            $datane=$this->m_jadwalnew->q_excel_jadwal_untukprd($thn,$bln);
            $this->excel_generator->set_query($datane);
            $this->excel_generator->set_header(array('NIK','NAMA LENGKAP','KODE REGU','BULAN','TAHUN',
                '1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'
            ));
            $this->excel_generator->set_column(array('nik','nmlengkap','kdregu','bulan','tahun',
                'tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
                'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31'
            ));
            $this->excel_generator->set_width(array(20,20,20,4,8,5,
                4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,
                4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4
            ));
            $this->excel_generator->exportTo2007("JADWALKERJA_DTLUPRD");

        }


    }

    function v_gr_jadwal(){

        $kdregu=$this->input->post('kdregu');
        $bulan_awal=$this->input->post('bln_awal');
        $tahun_awal=$this->input->post('thn_awal');
        $bulan_akhir=$this->input->post('bln_akhir');
        $tahun_akhir=$this->input->post('thn_akhir');
        $type_gr=trim($this->input->post('type_gr'));
        if($type_gr=='gr_copying'){
            $this->db->query("select sc_trx.pr_gr_jadwalkerja('$bulan_awal','$tahun_awal','$bulan_akhir','$tahun_akhir','$kdregu')");
            $data['title']="GENERATE JADWAL KERJA ANTAR BULAN";
            $data['title1']="BULAN REFERENSI $kdregu  BULAN:$bulan_awal TAHUN:$tahun_awal";
            $data['title2']="BULAN GENERATE JADWAL $kdregu  BULAN:$bulan_akhir TAHUN:$tahun_akhir";
            $data['kdregu']=$kdregu; $data['tahun_akhir']=$tahun_akhir; $data['bulan_akhir']=$bulan_akhir;
            $data['list_tgljadwal']=$this->m_jadwalnew->q_calendar_jad($kdregu,$bulan_akhir,$tahun_akhir)->result();
            $data['list_tgljadwalrev']=$this->m_jadwalnew->q_calendar_jad_rev($kdregu,$bulan_awal,$tahun_awal)->result();
            $this->template->display('trans/jadwal/v_gr_jadwal',$data);
        }
        else if($type_gr=='gr_template'){
            $cek_master_template=$this->m_jadwalnew->cek_master_template($kdregu,$bulan_akhir,$tahun_akhir)->num_rows();
            $cek_jadwal_1moon=$this->m_jadwalnew->cek_jadwal_1moon($kdregu,$bulan_akhir,$tahun_akhir)->num_rows();
            //if($cek_master_template<>0){
            //	redirect("trans/jadwal_new/index/template_sama/$bulan_akhir/$tahun_akhir/$kdregu");
            if($cek_jadwal_1moon<>0){
                redirect("trans/jadwal_new/index/jadwal_sama/$bulan_akhir/$tahun_akhir/$kdregu");
            }
            else{
                $this->db->query("delete from sc_tmp.template_jadwal where kdregu='$kdregu' and bulan='$bulan_akhir' and tahun='$tahun_akhir'"); //delete query
                //$this->db->query("delete from sc_tmp.template_jadwal where kdregu='$kdregu' and bulan='$bulan_awal' and tahun='$tahun_awal'"); //delete query
                $this->db->query("select sc_tmp.pr_gr_setupjadwal('$bulan_akhir','$tahun_akhir', '$kdregu')");
                $data['title']="GENERATE JADWAL VIA TEMPLATE SETUP";
                $data['kdregu']=$kdregu; $data['tahun']=$tahun_akhir; $data['bulan']=$bulan_akhir;
                $data['type_gr']=$type_gr;
                $data['list_template']=$this->m_jadwalnew->q_template_jadwal($kdregu,$bulan_akhir,$tahun_akhir)->result();
                $this->template->display('trans/jadwal/v_gr_jadwal_template',$data);
            }
        }
    }

    function gr_jadwal_perbulan(){
        $kdregu=$this->input->post('kdregu');
        $bulan_akhir=$this->input->post('bln_akhir');
        $tahun_akhir=$this->input->post('thn_akhir');
        $type_gr=trim($this->input->post('type_gr'));
        $inputdate=date('d-m-Y H:i:s');
        $inputby=$this->session->userdata('nik');
        if($type_gr=='gr_copying'){

            $this->db->query("select sc_trx.pr_gr_insertjadwal('$bulan_akhir','$tahun_akhir','$kdregu')");
            redirect("trans/jadwal_new/index/gr_succes/$bulan_akhir/$tahun_akhir/$kdregu");
        }
        else if($type_gr=='gr_template'){
            $this->db->query("update sc_tmp.template_jadwal set status='F' where kdregu='$kdregu' and bulan='$bulan_akhir' and tahun='$tahun_akhir'");
            $this->db->query("select sc_tmp.pr_template_jadwalkerja_ins('$bulan_akhir','$tahun_akhir','$kdregu','$inputdate','$inputby')");
            redirect("trans/jadwal_new/index/gr_succes/$bulan_akhir/$tahun_akhir/$kdregu");
        }

    }

    function reset_jadwal_bulanan(){
        $kdregu=$this->input->post('kdregu');
        $bln=$this->input->post('bln');
        $thn=$this->input->post('thn');
        $tgl=trim($thn.$bln);
        $tglnow=date('Ym');

        //if($tgl>$tglnow){
        $this->db->query("delete from sc_trx.jadwalkerja where kdregu='$kdregu' and to_char(tgl,'yyyymm')>='$tgl';");
        $this->db->query("delete from sc_trx.dtljadwalkerja where kdregu='$kdregu' and to_char(tgl,'yyyymm')>='$tgl';");
        $this->db->query("delete from sc_mst.template_jadwal where kdregu='$kdregu' and bulan='$bln' and tahun='$thn';");
        redirect("trans/jadwal_new/index/delete_success");
        //}else{
        //redirect("trans/jadwal_new/index/rs_failed/$bln/$thn/$kdregu");
        //}

    }

    function v_template(){
        $kdregu=$this->input->post('kdregu');
        $bln=$this->input->post('bln');
        $thn=$this->input->post('thn');
        $data['title']="TEMPLATE TAHUN $thn";
        $data['kdregu']=$kdregu; $data['tahun']=$thn; $data['bulan']=$bln;
        $data['list_template']=$this->m_jadwalnew->q_template_tahunan($kdregu,$thn)->result();
        $this->template->display('trans/jadwal/v_template_tahunan',$data);
    }

}
