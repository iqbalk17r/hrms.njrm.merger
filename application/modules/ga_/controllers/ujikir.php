<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Ujikir extends MX_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->load->model(array('m_kendaraan', 'master/m_akses', 'master/m_geo', 'm_ujikir'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'Excel_generator'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA, MENU REMINDER UJI KIR";
        $this->template->display('ga/kendaraan/v_index', $data);
    }


    /* FORM UJI KIR KENDARAAN */
    function form_ujikir()
    {
        $data['title'] = " FORM UJI KIR KENDARAAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.G.3';
        $versirelease = 'I.G.G.3/ALPHA.001';
        $userid = $this->session->userdata('nik');
        $vdb = $this->m_ujikir->q_versidb($kodemenu)->row_array();
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
        $vdb = $this->m_ujikir->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */
        $paramerror=" and userid='$nama' and modul='KIR'";
        $dtlerror=$this->m_ujikir->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_ujikir->q_trxerror($paramerror)->num_rows();
        if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
        if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
        if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }

        if($count_err>0 and $errordesc<>''){
            if ($dtlerror['errorcode']==0){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH/DIPROSES $nomorakhir1 </div>";
            } else {
                $data['message']="<div class='alert alert-info'>$errordesc</div>";
            }

        } else {
            if ($errorcode=='0'){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH/DIPROSES $nomorakhir1 </div>";
            } else {
                $data['message']="";
            }

        }

        /*cek jika ada inputan edit atau input*/
        $param3_1_1=" and docno='$nama' and status='I'";
        $param3_1_2=" and docno='$nama' and status='E'";
        $param3_1_3=" and docno='$nama' and status in ('A','A1')";
        $param3_1_4=" and docno='$nama' and status='C'";
        $param3_1_5=" and docno='$nama' and status='H'";
        $param3_1_6=" and docno='$nama' and status='R'";
        $param3_1_7=" and docno='$nama' and status='O'";
        $param3_1_R=" and docno='$nama'";
        $cekmst_na=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_1)->num_rows(); //input
        $cekmst_ne=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_2)->num_rows(); //edit
        $cekmst_napp=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_3)->num_rows(); //approv
        $cekmst_cancel=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_4)->num_rows(); //cancel
        $cekmst_hangus=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_5)->num_rows(); //hangus
        $cekmst_ra=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_6)->num_rows(); //REALISASI
        $cekmst_ch=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_7)->num_rows(); //REALISASI
        $dtledit=$this->m_ujikir->q_tmp_mst_ujikir($param3_1_R)->row_array(); //edit row array

        $enc_nama=bin2hex($this->encrypt->encode($nama));
        $data['enc_nama']=bin2hex($this->encrypt->encode($nama));
        if ($cekmst_na>0) { //cek inputan
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/ujikir/input_ujikir");
        } else if ($cekmst_ne>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/ujikir/edit_ujikir");
        } else if ($cekmst_napp>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/ujikir/approval_ujikir");
        } else if ($cekmst_cancel>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/ujikir/cancel_ujikir");
        }
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('periode'))));
        if (!empty($tglYM)) { $periode=$tglYM; $param_postperiode=" and to_char(a.expkir,'yyyymm')='$periode'"; } else { $periode=date('Ym');  $param_postperiode=" and to_char(a.expkir,'yyyymm')='$periode'"; }

        $paramtrxmst = $param_postperiode;
        $data['list_kanwil'] = $this->m_ujikir->q_mstkantor()->result();
        $data['list_trx_mst'] = $this->m_ujikir->q_his_mst_ujikir($paramtrxmst)->result();
        $this->template->display('ga/ujikir/v_form_uji_kir', $data);

        $paramerror=" and userid='$nama'";
        $this->m_ujikir->q_deltrxerror($paramerror);


    }

    function input_ujikir(){
        $nama = trim($this->session->userdata('nik'));

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdgudang=$this->input->post('kdgudang');
        $stockcode=$this->input->post('kdbarang');

        $param_inp=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";

        $cekkir_inp=$this->m_ujikir->q_tmp_mst_ujikir($param_inp)->num_rows();

        if ($cekkir_inp==0) {
            $param_insert=" and nodok='$stockcode'";
            $this->m_ujikir->insert_tmp_ujikir($param_insert);
        }
        $paramview=" and docno='$nama'";
        $data['title']='INPUT UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_ujikir->q_tmp_mst_ujikir($paramview)->row_array();
        $this->template->display('ga/ujikir/v_input_uji_kir', $data);


    }

    function edit_ujikir(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekkir_edit=$this->m_ujikir->q_tmp_mst_ujikir($param_edit)->num_rows();
        $dtluji=$this->m_ujikir->q_tmp_mst_ujikir($paramcektmp)->num_rows();

        if ($cekkir_edit==0) {
            $info = array('status' => 'E','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.kir_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/ujikir/form_ujikir');
        }

        $paramview=" and docno='$nama'";
        $data['title']='UBAH DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_ujikir->q_tmp_mst_ujikir($paramview)->row_array();
        $this->template->display('ga/ujikir/v_edit_uji_kir', $data);

    }

    function approval_ujikir(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekkir_edit=$this->m_ujikir->q_tmp_mst_ujikir($param_edit)->num_rows();
        $dtluji=$this->m_ujikir->q_tmp_mst_ujikir($paramcektmp)->num_rows();

        if ($cekkir_edit==0) {
            $info = array('status' => 'A1','approvaldate' => date('Y-m-d H:i:s'),'approvalby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.kir_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/ujikir/form_ujikir');
        }

        $paramview=" and docno='$nama'";
        $data['title']='APPROVAL DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_ujikir->q_tmp_mst_ujikir($paramview)->row_array();
        $this->template->display('ga/ujikir/v_approval_uji_kir', $data);

    }

    function cancel_ujikir(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekkir_edit=$this->m_ujikir->q_tmp_mst_ujikir($param_edit)->num_rows();
        $dtluji=$this->m_ujikir->q_tmp_mst_ujikir($paramcektmp)->num_rows();

        if ($cekkir_edit==0) {
            $info = array('status' => 'C','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.kir_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/ujikir/form_ujikir');
        }

        $paramview=" and docno='$nama'";
        $data['title']='PEMBATALAN INPUTAN DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_ujikir->q_tmp_mst_ujikir($paramview)->row_array();
        $this->template->display('ga/ujikir/v_cancel_uji_kir', $data);

    }

    function detail_ujikir(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_ujikir->q_his_mst_ujikir($paramview)->row_array();
        $this->template->display('ga/ujikir/v_detail_uji_kir', $data);

    }

    function save_ujikir(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdrangka=trim($this->input->post('kdrangka'));
        $kdmesin=trim($this->input->post('kdmesin'));
        $stockcode=trim($this->input->post('stockcode'));
        $old_docujikir=trim($this->input->post('old_docujikir'));
        $old_expkir=trim($this->input->post('old_expkir'));
        $docujikir=strtoupper(trim($this->input->post('docujikir')));
        $expkir=trim($this->input->post('expkir'));
        $ttlvalue=trim($this->input->post('ttlvalue'));
        $namapengurus=strtoupper(trim($this->input->post('namapengurus')));
        $contactpengurus=strtoupper(trim($this->input->post('contactpengurus')));
        $description=strtoupper($this->input->post('description'));

        if ($type=='INPUTUJIKIR'){
            $info = array(
                'docujikir' => $docujikir,
                'expkir' => $expkir,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'namapengurus' => $namapengurus,
                'contactpengurus' => $contactpengurus,
                'description' => $description,
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => $nama,
            );
            $this->db->update('sc_tmp.kir_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_ujikir->final_temporary_kir();
            redirect('ga/ujikir/form_ujikir');

        } else if ($type=='EDITUJIKIR'){
            $info = array(
                'docujikir' => $docujikir,
                'expkir' => $expkir,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'namapengurus' => $namapengurus,
                'contactpengurus' => $contactpengurus,
                'description' => $description,
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
            );
            $this->db->update('sc_tmp.kir_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_ujikir->final_temporary_kir();
            redirect('ga/ujikir/form_ujikir');

        }  else if ($type=='APPROVALUJIKIR'){
            $info = array(
                'approvaldate' => date('Y-m-d H:i:s'),
                'approvalby' => $nama,
            );
            $this->db->update('sc_tmp.kir_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_ujikir->final_temporary_kir();
            redirect('ga/ujikir/form_ujikir');

        }  else if ($type=='CANCELUJIKIR'){

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_ujikir->final_temporary_kir();
            redirect('ga/ujikir/form_ujikir');

        }

    }

    function clear_ujikir(){
        $type=trim(strtoupper($this->input->post('type')));
        $nama=trim($this->session->userdata('nik'));
        $stockcode=trim(strtoupper($this->input->post('type')));
        $paramview=" and docno='$nama'";
        $dtlmst = $this->m_ujikir->q_tmp_mst_ujikir($paramview)->row_array();
        if(trim($dtlmst['status'])=='I') {
            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.kir_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/ujikir/form_ujikir');
        } else if(trim($dtlmst['status'])=='E') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.kir_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.kir_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/ujikir/form_ujikir');
        } else if(trim($dtlmst['status'])=='A') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'approvalby' => '',
                'approvaldate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.kir_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.kir_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/ujikir/form_ujikir');
        } else if(trim($dtlmst['status'])=='C') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.kir_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.kir_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','KIR');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KIR',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/ujikir/form_ujikir');
        } else {
            redirect('ga/ujikir/form_ujikir');
        }
    }

    function final_tmp_mst(){
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
    }

    function json_ujikir(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_ujikir->q_his_mst_ujikir($paramview)->row_array();

        $param=" and docno='$docno'";
        $datamst = $this->m_ujikir->q_master_branch()->result();
        $datadtl = $this->m_ujikir->q_json_ujikir_his($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'master' => $datamst,
                'detail' => $datadtl,
                 ), JSON_PRETTY_PRINT);
    }

    function sti_ujikir(){
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
        $enc_docno=$this->uri->segment(4);
        $data['jsonfile'] = "ga/ujikir/json_ujikir/$enc_docno";
        $data['report_file'] = 'assets/mrt/sti_ujikir.mrt';
        $this->load->view("ga/ujikir/sti_ujikir",$data);
    }
}