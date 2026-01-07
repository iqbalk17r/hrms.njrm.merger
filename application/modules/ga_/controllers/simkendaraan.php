<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Simkendaraan extends MX_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->load->model(array('m_kendaraan', 'master/m_akses', 'master/m_geo', 'm_simkendaraan'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'Excel_generator'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA, MENU REMINDER SIM KARYAWAN SIM KENDARAAN";
        $this->template->display('ga/kendaraan/v_index', $data);
    }


    /* FORM SIM PENGENDARA */
    function form_sim()
    {
        $data['title'] = " FORM SIM PENGENDARA KENDARAAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.G.4';
        $versirelease = 'I.G.G.4/ALPHA.001';
        $userid = $this->session->userdata('nik');
        $vdb = $this->m_simkendaraan->q_versidb($kodemenu)->row_array();
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
        $vdb = $this->m_simkendaraan->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */
        $paramerror=" and userid='$nama' and modul='SIM'";
        $dtlerror=$this->m_simkendaraan->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_simkendaraan->q_trxerror($paramerror)->num_rows();
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
        $param3_1_1=" and docno='$nama' and a.status='I'";
        $param3_1_2=" and docno='$nama' and a.status='E'";
        $param3_1_3=" and docno='$nama' and a.status in ('A','A1')";
        $param3_1_4=" and docno='$nama' and a.status='C'";
        $param3_1_5=" and docno='$nama' and a.status='H'";
        $param3_1_6=" and docno='$nama' and a.status='R'";
        $param3_1_7=" and docno='$nama' and a.status='O'";
        $param3_1_R=" and docno='$nama'";
        $cekmst_na=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_1)->num_rows(); //input
        $cekmst_ne=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_2)->num_rows(); //edit
        $cekmst_napp=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_3)->num_rows(); //approv
        $cekmst_cancel=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_4)->num_rows(); //cancel
        $cekmst_hangus=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_5)->num_rows(); //hangus
        $cekmst_ra=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_6)->num_rows(); //REALISASI
        $cekmst_ch=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_7)->num_rows(); //REALISASI
        $dtledit=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param3_1_R)->row_array(); //edit row array

        $enc_nama=bin2hex($this->encrypt->encode($nama));
        $data['enc_nama']=bin2hex($this->encrypt->encode($nama));
        if ($cekmst_na>0) { //cek inputan
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/simkendaraan/input_simkendaraan");
        } else if ($cekmst_ne>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/simkendaraan/edit_simkendaraan");
        } else if ($cekmst_napp>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/simkendaraan/approval_simkendaraan");
        } else if ($cekmst_cancel>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/simkendaraan/cancel_simkendaraan");
        }
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('periode'))));
        if (!empty($tglYM)) { $periode=$tglYM; $param_postperiode=" and to_char(a.docdate,'yyyymm')='$periode'"; } else { $periode=date('Ym');  $param_postperiode=" and to_char(a.docdate,'yyyymm')='$periode'"; }

        $paramtrxmst = $param_postperiode;
        $paramlistkaryawan = "and tglkeluarkerja is null";
        $data['list_kanwil'] = $this->m_simkendaraan->q_mstkantor()->result();
        $data['list_trx_mst'] = $this->m_simkendaraan->q_his_mst_simkendaraan($paramtrxmst)->result();
        $data['list_karyawan'] = $this->m_akses->list_karyawan_param($paramlistkaryawan)->result();
        $data['list_sim'] = $this->m_simkendaraan->q_trxtype_sim()->result();
        $this->template->display('ga/simkendaraan/v_form_simkendaraan', $data);

        $paramerror=" and userid='$nama'";
        $this->m_simkendaraan->q_deltrxerror($paramerror);


    }

    function input_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $paramdtl=" and docno='$nama'";
        $dtlsim = $this->m_simkendaraan->q_tmp_mst_simkendaraan($paramdtl)->row_array();
        IF (!empty($dtlsim['nik'])){
            $typesim=trim($dtlsim['typesim']);
            $nik=trim($dtlsim['nik']);
        } else {
            $typesim=trim($this->input->post('typesim'));
            $nik=trim($this->input->post('nik'));
        }


       $param_inp=" and a.docno='$nama' or (a.docno!='$nama' and a.nik='$nik')";
       $param_xnine=" and nik='$nik' and typesim='$typesim'";

       $cekkir_inp=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param_inp)->num_rows();
       $cekxnine=$this->m_simkendaraan->q_mst_sim($param_xnine)->num_rows();

       if($cekxnine==0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 3,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/simkendaraan/form_sim");
        }
        if ($cekkir_inp==0) {
            $param_insert=" and nik='$nik' and typesim='$typesim'";
            $this->m_simkendaraan->insert_tmp_simkendaraan($param_insert);
        }


        $paramview=" and docno='$nama'";
        $data['title']='INPUT PEMBAHARUAN SIM';
        $data['dtlmst'] = $this->m_simkendaraan->q_tmp_mst_simkendaraan($paramview)->row_array();
        $data['list_sim'] = $this->m_simkendaraan->q_trxtype_sim()->result();
        $this->template->display('ga/simkendaraan/v_input_simkendaraan', $data);

    }

    function edit_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));

        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and a.docno='$nama' or (a.docno!='$nama' and a.nik='$nik')";
        $paramcektmp= " and a.nik='$nik'";
        $ceksim_edit=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param_edit)->num_rows();
        $dtluji=$this->m_simkendaraan->q_tmp_mst_simkendaraan($paramcektmp)->num_rows();


        if ($ceksim_edit==0) {
            $info = array('status' => 'E','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.sim_mst',$info);
        }
        if($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/simkendaraan/form_sim");
        }

        $paramview=" and docno='$nama'";
        $data['title']='UBAH DATA PEMBAHARUAN SIM';
        $data['dtlmst'] = $this->m_simkendaraan->q_tmp_mst_simkendaraan($paramview)->row_array();
        $data['list_sim'] = $this->m_simkendaraan->q_trxtype_sim()->result();
        $this->template->display('ga/simkendaraan/v_edit_simkendaraan', $data);

    }

    function approval_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));

        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and a.docno='$nama' or (a.docno!='$nama' and a.nik='$nik')";
        $paramcektmp= " and a.nik='$nik'";
        $ceksim_edit=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param_edit)->num_rows();
        $dtluji=$this->m_simkendaraan->q_tmp_mst_simkendaraan($paramcektmp)->num_rows();


        if ($ceksim_edit==0) {
            $info = array('status' => 'A1','approvaldate' => date('Y-m-d H:i:s'),'approvalby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.sim_mst',$info);
        }
        if($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/simkendaraan/form_sim");
        }

        $paramview=" and docno='$nama'";
        $data['title']='APPROVAL DATA PEMBAHARUAN SIM';
        $data['dtlmst'] = $this->m_simkendaraan->q_tmp_mst_simkendaraan($paramview)->row_array();
        $data['list_sim'] = $this->m_simkendaraan->q_trxtype_sim()->result();
        $this->template->display('ga/simkendaraan/v_approval_simkendaraan', $data);

    }
    function cancel_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));

        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $param_edit=" and a.docno='$nama' or (a.docno!='$nama' and a.nik='$nik')";
        $paramcektmp= " and a.nik='$nik'";
        $ceksim_edit=$this->m_simkendaraan->q_tmp_mst_simkendaraan($param_edit)->num_rows();
        $dtluji=$this->m_simkendaraan->q_tmp_mst_simkendaraan($paramcektmp)->num_rows();


        if ($ceksim_edit==0) {
            $info = array('status' => 'C','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.sim_mst',$info);
        }
        if($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect("ga/simkendaraan/form_sim");
        }

        $paramview=" and docno='$nama'";
        $data['title']='CANCEL DATA PEMBAHARUAN SIM';
        $data['dtlmst'] = $this->m_simkendaraan->q_tmp_mst_simkendaraan($paramview)->row_array();
        $data['list_sim'] = $this->m_simkendaraan->q_trxtype_sim()->result();
        $this->template->display('ga/simkendaraan/v_cancel_simkendaraan', $data);

    }


    function detail_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_simkendaraan->q_his_mst_simkendaraan($paramview)->row_array();
        $this->template->display('ga/simkendaraan/v_detail_simkendaraan', $data);

    }

    function save_sim(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $nik=trim($this->input->post('nik'));

        $docsim=trim($this->input->post('docsim'));
        $typesim=trim($this->input->post('typesim'));
        $datecreate=trim($this->input->post('datecreate'));
        $expsim=trim($this->input->post('expsim'));
        $ttlvalue=trim($this->input->post('ttlvalue'));
        $namapengurus=strtoupper(trim($this->input->post('namapengurus')));
        $contactpengurus=strtoupper(trim($this->input->post('contactpengurus')));
        $description=strtoupper($this->input->post('description'));

        if ($type=='INPUTSIMKENDARAAN'){
            $info = array(
                'docsim' => $docsim,
                'typesim' => $typesim,
                'docsim' => $docsim,
                'datecreate' => $datecreate,
                'expsim' => $expsim,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'namapengurus' => $namapengurus,
                'contactpengurus' => $contactpengurus,
                'description' => $description,
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => $nama,
            );
            $this->db->update('sc_tmp.sim_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_simkendaraan->final_temporary_sim();
            redirect('ga/simkendaraan/form_sim');

        } else if ($type=='EDITSIMKENDARAAN'){
            $info = array(
                'docsim' => $docsim,
                'typesim' => $typesim,
                'docsim' => $docsim,
                'datecreate' => $datecreate,
                'expsim' => $expsim,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'namapengurus' => $namapengurus,
                'contactpengurus' => $contactpengurus,
                'description' => $description,
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
            );
            $this->db->update('sc_tmp.sim_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_simkendaraan->final_temporary_sim();
            redirect('ga/simkendaraan/form_sim');

        }  else if ($type=='APPSIMKENDARAAN'){
            $info = array(
                'approvaldate' => date('Y-m-d H:i:s'),
                'approvalby' => $nama,
            );
            $this->db->update('sc_tmp.kir_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_simkendaraan->final_temporary_sim();
            redirect('ga/simkendaraan/form_sim');

        }  else if ($type=='CANCELINPUTSIM'){
            $info = array(
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
            );
            $this->db->update('sc_tmp.kir_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_simkendaraan->final_temporary_sim();
            redirect('ga/simkendaraan/form_sim');

        }

    }

    function clear_simkendaraan(){
        $type=trim(strtoupper($this->input->post('type')));
        $nama=trim($this->session->userdata('nik'));
        $stockcode=trim(strtoupper($this->input->post('type')));
        $paramview=" and docno='$nama'";
        $dtlmst = $this->m_simkendaraan->q_tmp_mst_simkendaraan($paramview)->row_array();
        if(trim($dtlmst['status'])=='I') {
            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.sim_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/simkendaraan/form_sim');
        } else if(trim($dtlmst['status'])=='E') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.sim_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.sim_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/simkendaraan/form_sim');
        } else if(trim($dtlmst['status'])=='A') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'approvalby' => '',
                'approvaldate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.sim_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.sim_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/simkendaraan/form_sim');
        } else if(trim($dtlmst['status'])=='C') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.sim_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.sim_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/simkendaraan/form_sim');
        } else {
            redirect('ga/simkendaraan/form_sim');
        }
    }

    function final_tmp_mst(){
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $stockcode=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
    }

    function json_sim(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['dtlmst'] = $this->m_simkendaraan->q_json_simkendaraan_his($paramview)->row_array();

        $param=" and docno='$docno'";
        $datamst = $this->m_simkendaraan->q_master_branch()->result();
        $datadtl = $this->m_simkendaraan->q_json_simkendaraan_his($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'master' => $datamst,
                'detail' => $datadtl,
                 ), JSON_PRETTY_PRINT);
    }

    function sti_sim(){
        $docno=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
        $enc_docno=$this->uri->segment(4);
        $data['jsonfile'] = "ga/simkendaraan/json_sim/$enc_docno";
        $data['report_file'] = 'assets/mrt/sti_sim.mrt';
        $this->load->view("ga/simkendaraan/sti_sim",$data);
    }

    function form_master_sim(){
        $data['title'] = " FORM MASTER SURAT IJIN MENGEMUDI KENDARAAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.D.12';
        $versirelease = 'I.G.D.12/ALPHA.001';
        $userid = $this->session->userdata('nik');
        $vdb = $this->m_simkendaraan->q_versidb($kodemenu)->row_array();
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
        $vdb = $this->m_simkendaraan->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */
        $paramerror=" and userid='$nama' and modul='SIM'";
        $dtlerror=$this->m_simkendaraan->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_simkendaraan->q_trxerror($paramerror)->num_rows();
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
        $nikpost=trim($this->input->post('nik'));
        if (!empty($nikpost)){ $paramtrxmst = " and nik='$nikpost'"; } else { $paramtrxmst = " and nik is not null";  };

        $paramlistkaryawan = "and tglkeluarkerja is null";
        $data['list_kanwil'] = $this->m_simkendaraan->q_mstkantor()->result();
        $data['list_trx_mst'] = $this->m_simkendaraan->q_mst_sim($paramtrxmst)->result();
        $data['list_karyawan'] = $this->m_akses->list_karyawan_param($paramlistkaryawan)->result();
        $data['list_sim'] = $this->m_simkendaraan->q_trxtype_sim()->result();
        $this->template->display('ga/simkendaraan/v_form_master_sim', $data);

        $paramerror=" and userid='$nama'";
        $this->m_simkendaraan->q_deltrxerror($paramerror);

    }

    function input_master_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $typesim=strtoupper(trim($this->input->post('typesim')));
        $nik=strtoupper(trim($this->input->post('nik')));

        $paramview=" and nik='$nik' and typesim='$typesim'";

        $cekkir_inp=$this->m_simkendaraan->q_mst_sim($paramview)->num_rows();

        if ($cekkir_inp>0) {
            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 4,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/simkendaraan/form_master_sim');
        }
        $paramlistkaryawan=" and nik='$nik'";
        $data['title']='INPUT MASTER SIM KENDARAAN';
        $data['dtlmst'] = $this->m_akses->list_karyawan_param($paramlistkaryawan)->row_array();
        $data['typesim'] = $typesim;
        $this->template->display('ga/simkendaraan/v_input_master_sim', $data);
    }

    function detail_master_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $typesim=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));

        $paramview=" and nik='$nik' and typesim='$typesim'";

        $data['title']='DETAIL MASTER SIM KENDARAAN';
        $data['dtlmst'] = $this->m_simkendaraan->q_mst_sim($paramview)->row_array();
        $this->template->display('ga/simkendaraan/v_detail_master_sim', $data);
    }

    function delete_master_simkendaraan(){
        $nama = trim($this->session->userdata('nik'));

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $typesim=$this->encrypt->decode(trim(hex2bin($this->uri->segment(4))));
        $nik=$this->encrypt->decode(trim(hex2bin($this->uri->segment(5))));
        $this->db->where('nik',$nik);
        $this->db->where('typesim',$typesim);
        $this->db->delete("sc_mst.sim");

        $this->db->where('userid',$nama);
        $this->db->where('modul','SIM');
        $this->db->delete('sc_mst.trxerror');

        $infotrxerror = array (
            'userid' => $nama,
            'errorcode' => 0,
            'nomorakhir1' => '',
            'nomorakhir2' => '',
            'modul' => 'SIM',
        );
        $this->db->insert('sc_mst.trxerror',$infotrxerror);
        redirect('ga/simkendaraan/form_master_sim');
    }

    function save_master_sim(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $nik=trim($this->input->post('nik'));

        $docsim=trim($this->input->post('docsim'));
        $typesim=trim($this->input->post('typesim'));
        $datecreate=trim($this->input->post('datecreate'));
        $expsim=trim($this->input->post('expsim'));
        $chold=trim($this->input->post('chold'));
        $reminder=trim($this->input->post('reminder'));
        $description=strtoupper($this->input->post('description'));

        if ($type=='INPUTMASTERNYA'){
            $info = array(
                'nik' => $nik,
                'docsim' => $docsim,
                'typesim' => $typesim,
                'datecreate' => $datecreate,
                'expsim' => $expsim,
                'chold' => $chold,
                'reminder' => $reminder,
                'description' => $description,
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => $nama,
            );
            $this->db->insert('sc_mst.sim',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','SIM');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'SIM',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/simkendaraan/form_master_sim');

        }
    }
}