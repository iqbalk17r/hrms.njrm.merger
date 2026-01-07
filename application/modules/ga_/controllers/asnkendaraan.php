<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Asnkendaraan extends MX_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->load->model(array('m_kendaraan', 'master/m_akses', 'master/m_geo', 'm_asnkendaraan'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'Excel_generator'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA, PENCATATAN PEMBAHARUAN ASURANSI KENDARAAN";
        $this->template->display('ga/kendaraan/v_index', $data);
    }


    /* FORM BBM KENDARAAN */
    function form_asnkendaraan()
    {
        $data['title'] = " FORM HISTORY ASURANSI KENDARAAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.G.6';
        $versirelease = 'I.G.G.6/ALPHA.001';
        $userid = $this->session->userdata('nik');
        $vdb = $this->m_asnkendaraan->q_versidb($kodemenu)->row_array();
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
                'vdate' => date('2018-05-10 11:18:00'),
                'vauthor' => 'FIKY',
                'vketerangan' => 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => $userid,
            );
            $this->db->where('kodemenu', $kodemenu);
            $this->db->update('sc_mst.version', $infoversi);
        }
        $vdb = $this->m_asnkendaraan->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */
        $paramerror=" and userid='$nama' and modul='BC_ASN_K'";
        $dtlerror=$this->m_asnkendaraan->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_asnkendaraan->q_trxerror($paramerror)->num_rows();
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
        $cekmst_na=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_1)->num_rows(); //input
        $cekmst_ne=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_2)->num_rows(); //edit
        $cekmst_napp=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_3)->num_rows(); //approv
        $cekmst_cancel=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_4)->num_rows(); //cancel
        $cekmst_hangus=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_5)->num_rows(); //hangus
        $cekmst_ra=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_6)->num_rows(); //REALISASI
        $cekmst_ch=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_7)->num_rows(); //REALISASI
        $dtledit=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param3_1_R)->row_array(); //edit row array

        $enc_nama=bin2hex($this->encrypt->encode($nama));
        $data['enc_nama']=bin2hex($this->encrypt->encode($nama));
        if ($cekmst_na>0) { //cek inputan
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/asnkendaraan/input_asnkendaraan");
        } else if ($cekmst_ne>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/asnkendaraan/edit_asnkendaraan");
        } else if ($cekmst_napp>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/asnkendaraan/approval_asnkendaraan");
        } else if ($cekmst_cancel>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/asnkendaraan/cancel_asnkendaraan");
        }
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('periode'))));
        if (!empty($tglYM)) { $periode=$tglYM; $param_postperiode=" and to_char(docdate,'yyyymm')='$periode'"; } else { $periode=date('Ym');  $param_postperiode=" and to_char(docdate,'yyyymm')='$periode'"; }

        $paramtrxmst = $param_postperiode;
        $data['list_kanwil'] = $this->m_asnkendaraan->q_mstkantor()->result();
        $data['list_trx_mst'] = $this->m_asnkendaraan->q_his_asnkendaraan_mst($paramtrxmst)->result();
        $this->template->display('ga/asnkendaraan/v_form_asnkendaraan', $data);

        $paramerror=" and userid='$nama'";
        $this->m_asnkendaraan->q_deltrxerror($paramerror);


    }

    function input_asnkendaraan(){
        $nama = trim($this->session->userdata('nik'));

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdgudang=$this->input->post('kdgudang');
        $stockcode=$this->input->post('kdbarang');

        $param_inp=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";

        $cekBC_ASN_K_inp=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param_inp)->num_rows();

        if ($cekBC_ASN_K_inp==0) {
            $param_insert=" and nodok='$stockcode'";
            $this->m_asnkendaraan->insert_tmp_asnkendaraan($param_insert);
        }
        $paramview=" and docno='$nama'";
        $data['title']='INPUT PENCATATAN HISTORIS ASURANSI';
        $data['list_subasuransi'] = $this->m_asnkendaraan->q_mstsubasuransi()->result();
        $data['dtlmst'] = $this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/asnkendaraan/v_input_asnkendaraan', $data);


    }

    function edit_asnkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekBC_ASN_K_edit=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param_edit)->num_rows();
        $dtluji=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramcektmp)->num_rows();

        if ($cekBC_ASN_K_edit==0) {
            $info = array('status' => 'E','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.asnkendaraan_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/asnkendaraan/form_asnkendaraan');
        }

        $paramview=" and docno='$nama'";
        $data['title']='UBAH DATA HISTORIS ASURANSI KENDARAAN';
        $data['list_subasuransi'] = $this->m_asnkendaraan->q_mstsubasuransi()->result();
        $data['dtlmst'] = $this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/asnkendaraan/v_edit_asnkendaraan', $data);

    }

    function approval_asnkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekBC_ASN_K_edit=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param_edit)->num_rows();
        $dtluji=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramcektmp)->num_rows();

        if ($cekBC_ASN_K_edit==0) {
            $info = array('status' => 'A1','approvaldate' => date('Y-m-d H:i:s'),'approvalby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.asnkendaraan_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/asnkendaraan/form_asnkendaraan');
        }

        $paramview=" and docno='$nama'";
        $data['title']='APPROVAL HISTORIS ASURANSI KENDARAAN';
        $data['list_subasuransi'] = $this->m_asnkendaraan->q_mstsubasuransi()->result();
        $data['dtlmst'] = $this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/asnkendaraan/v_approval_asnkendaraan', $data);

    }

    function cancel_asnkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekBC_ASN_K_edit=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($param_edit)->num_rows();
        $dtluji=$this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramcektmp)->num_rows();

        if ($cekBC_ASN_K_edit==0) {
            $info = array('status' => 'C','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.asnkendaraan_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/asnkendaraan/form_asnkendaraan');
        }

        $paramview=" and docno='$nama'";
        $data['title']='BATAL INPUT ASURANSI KENDARAAN';
        $data['list_subasuransi'] = $this->m_asnkendaraan->q_mstsubasuransi()->result();
        $data['dtlmst'] = $this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/asnkendaraan/v_cancel_asnkendaraan', $data);

    }

    function detail_asnkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        //$stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL ASURANSI KENDARAAN';
        $data['dtlmst'] = $this->m_asnkendaraan->q_his_asnkendaraan_mst($paramview)->row_array();
        $data['list_subasuransi'] = $this->m_asnkendaraan->q_mstsubasuransi()->result();
        $this->template->display('ga/asnkendaraan/v_detail_asnkendaraan', $data);
    }

    function save_asnkendaraan(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdrangka=trim($this->input->post('kdrangka'));
        $kdmesin=trim($this->input->post('kdmesin'));
        $stockcode=trim($this->input->post('stockcode'));
        $kdasuransi=trim($this->input->post('kdasuransi'));
        $kdsubasuransi=trim($this->input->post('kdsubasuransi'));
        $expasuransi=trim($this->input->post('expasuransi'));
        $ttlvalue=trim($this->input->post('ttlvalue'));
        $docdate=trim($this->input->post('docdate'));
        $description=strtoupper($this->input->post('description'));

        if ($type=='INPUTASNKENDARAAN'){
            $info = array(
                'docdate' => $docdate,
                'kdsubasuransi' => $kdsubasuransi,
                'expasuransi' => $expasuransi,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'description' => $description,
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => $nama,
            );
            $this->db->update('sc_tmp.asnkendaraan_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_asnkendaraan->final_temporary_asnkendaraan();
            redirect('ga/asnkendaraan/form_asnkendaraan');

        } else if ($type=='EDITASNKENDARAAN'){
            $info = array(
                'docdate' => $docdate,
                'kdsubasuransi' => $kdsubasuransi,
                'expasuransi' => $expasuransi,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'description' => $description,
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
            );
            $this->db->update('sc_tmp.asnkendaraan_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_asnkendaraan->final_temporary_asnkendaraan();
            redirect('ga/asnkendaraan/form_asnkendaraan');

        }  else if ($type=='APPROVALASNKENDARAAN'){
            $info = array(
                'approvaldate' => date('Y-m-d H:i:s'),
                'approvalby' => $nama,
            );
            $this->db->update('sc_tmp.asnkendaraan_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_asnkendaraan->final_temporary_asnkendaraan();
            redirect('ga/asnkendaraan/form_asnkendaraan');

        }  else if ($type=='CANCELASNKENDARAAN'){

            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_asnkendaraan->final_temporary_asnkendaraan();
            redirect('ga/asnkendaraan/form_asnkendaraan');

        }

    }

    function clear_asnkendaraan(){
        $type=trim(strtoupper($this->input->post('type')));
        $nama=trim($this->session->userdata('nik'));
        $stockcode=trim(strtoupper($this->input->post('type')));
        $paramview=" and docno='$nama'";
        $dtlmst = $this->m_asnkendaraan->q_tmp_asnkendaraan_mst($paramview)->row_array();
        if(trim($dtlmst['status'])=='I') {
            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.asnkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/asnkendaraan/form_asnkendaraan');
        } else if(trim($dtlmst['status'])=='E') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.asnkendaraan_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.asnkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','asnkendaraan_mst');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/asnkendaraan/form_asnkendaraan');
        } else if(trim($dtlmst['status'])=='A') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'approvalby' => '',
                'approvaldate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.asnkendaraan_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.asnkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','asnkendaraan_mst');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/asnkendaraan/form_asnkendaraan');
        } else if(trim($dtlmst['status'])=='C') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.asnkendaraan_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.asnkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','BC_ASN_K');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BC_ASN_K',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/asnkendaraan/form_asnkendaraan');
        } else {
            redirect('ga/asnkendaraan/form_asnkendaraan');
        }
    }

    function final_tmp_mst(){
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
    }

    function json_asnkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL ASURANSI KENDARAAN';
        $data['dtlmst'] = $this->m_asnkendaraan->q_his_asnkendaraan_mst($paramview)->row_array();

        $param=" and docno='$docno'";
        $datamst = $this->m_asnkendaraan->q_master_branch()->result();
        $datadtl = $this->m_asnkendaraan->q_json_asnkendaraan_his($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'master' => $datamst,
                'detail' => $datadtl,
                 ), JSON_PRETTY_PRINT);
    }

    function sti_asnkendaraan(){
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
        $enc_docno=$this->uri->segment(4);
        $enc_stockcode=$this->uri->segment(4);
        $data['jsonfile'] = "ga/asnkendaraan/json_asnkendaraan/$enc_docno/$enc_stockcode";
        $data['report_file'] = 'assets/mrt/sti_asnkendaraan.mrt';
        $this->load->view("ga/asnkendaraan/sti_asnkendaraan",$data);
    }
}