<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 11/6/20, 10:44 AM
 *  * Last Modified: 11/6/20, 10:44 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

//error_reporting(0)
class Arsipdokumen extends MX_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->load->model(array('m_kendaraan', 'master/m_akses', 'master/m_geo', 'm_arsipdokumen'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'Excel_generator'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA, PENGARSIPAN DOKUMEN";
        $this->template->display('ga/arsipdokumen/v_index', $data);
    }


    /* FORM PENGARSIPAN DOKUMEN */
    function form_arsipdokumen()
    {
        $data['title'] = " FORM PENGARSIPAN DOKUMEN PERUSAHAAN ";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];


        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.B.2'; $versirelease='I.D.B.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $paramerror=" and userid='$nama' and modul='ACV'";
        $dtlerror=$this->m_arsipdokumen->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_arsipdokumen->q_trxerror($paramerror)->num_rows();
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
        $cekmst_na=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_1)->num_rows(); //input
        $cekmst_ne=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_2)->num_rows(); //edit
        $cekmst_napp=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_3)->num_rows(); //approv
        $cekmst_cancel=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_4)->num_rows(); //cancel
        $cekmst_hangus=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_5)->num_rows(); //hangus
        $cekmst_ra=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_6)->num_rows(); //REALISASI
        $cekmst_ch=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_7)->num_rows(); //REALISASI
        $dtledit=$this->m_arsipdokumen->q_tmp_arsipdokumen($param3_1_R)->row_array(); //edit row array

        $enc_nama=$this->fiky_encryption->enkript($nama);
        $data['enc_nama']=$this->fiky_encryption->enkript($nama);
        if ($cekmst_na>0) { //cek inputan
            $enc_docno=$this->fiky_encryption->enkript(trim($dtledit['docno']));
            $enc_archives_id=$this->fiky_encryption->enkript(trim($dtledit['archives_id']));
            redirect("ga/arsipdokumen/input_arsipdokumen/$enc_docno/$enc_archives_id");
        } else if ($cekmst_ne>0){
            $enc_docno=$this->fiky_encryption->enkript(trim($dtledit['docno']));
            $enc_archives_id=$this->fiky_encryption->enkript(trim($dtledit['archives_id']));
            redirect("ga/arsipdokumen/edit_arsipdokumen/$enc_docno/$enc_archives_id");
        } else if ($cekmst_napp>0){
            $enc_docno=$this->fiky_encryption->enkript(trim($dtledit['docno']));
            $enc_archives_id=$this->fiky_encryption->enkript(trim($dtledit['archives_id']));
            redirect("ga/arsipdokumen/approval_arsipdokumen/$enc_docno/$enc_archives_id");
        } else if ($cekmst_cancel>0){
            $enc_docno=$this->fiky_encryption->enkript(trim($dtledit['docno']));
            $enc_archives_id=$this->fiky_encryption->enkript(trim($dtledit['archives_id']));
            redirect("ga/arsipdokumen/cancel_arsipdokumen/$enc_docno/$enc_archives_id");
        }
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('periode'))));
        $archives_id=$this->input->post('kdbarang');

        if(!empty($archives_id)) { $param_id = " and archives_id='$archives_id'" ; } else { $param_id = ""; }
        if (!empty($tglYM)) { $periode=$tglYM; $param_postperiode=" and to_char(archives_exp,'yyyymm')='$periode'"; } else { $periode=date('Ym');  $param_postperiode=" "; }

        $paramtrxmst = $param_postperiode.$param_id;
        $data['list_kanwil'] = $this->m_arsipdokumen->q_mgudang()->result();
        $data['list_trx_mst'] = $this->m_arsipdokumen->q_his_arsipdokumen($paramtrxmst)->result();
        $this->template->display('ga/arsipdokumen/v_form_arsipdokumen', $data);

        $paramerror=" and userid='$nama'";
        $this->m_arsipdokumen->q_deltrxerror($paramerror);

    }

    function input_arsipdokumen(){
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.B.2'; $versirelease='I.D.B.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdgudang=$this->input->post('kdgudang');
        $archivescode=$this->input->post('kdbarang');

        $param_inp=" and docno='$nama' or (docno!='$nama' and archives_id='$archivescode')";

        $cekarchives_inp=$this->m_arsipdokumen->q_tmp_arsipdokumen($param_inp)->num_rows();

        if ($cekarchives_inp==0) {
            $param_insert=" and docno='$archivescode'";
            $this->m_arsipdokumen->insert_tmp_arsipdokumen($param_insert);
        }
        $paramview=" and docno='$nama'";
        $data['title']='INPUT PERPANJANGAN ARSIP DOKUMEN';
        $data['dtlmst'] = $this->m_arsipdokumen->q_tmp_arsipdokumen($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_input_arsipdokumen', $data);


    }

    function edit_arsipdokumen(){
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.B.2'; $versirelease='I.D.B.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */


        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $archives_id=$this->fiky_encryption->dekript($this->uri->segment(5));

        $param_edit=" and docno='$nama' or (docno!='$nama' and archives_id='$archives_id')";
        $paramcektmp= "and docno!='$nama' and archives_id='$archives_id'";
        $cek_edit=$this->m_arsipdokumen->q_tmp_arsipdokumen($param_edit)->num_rows();
        $dtluji=$this->m_arsipdokumen->q_tmp_arsipdokumen($paramcektmp)->num_rows();


        if ($cek_edit==0) {
            $info = array('status' => 'E','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.archives_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/arsipdokumen/form_arsipdokumen');
        }

        $paramview=" and docno='$nama'";
        $data['title']='UBAH DATA ARSIP DOKUMEN';
        $data['dtlmst'] = $this->m_arsipdokumen->q_tmp_arsipdokumen($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_edit_arsipdokumen', $data);

    }

    function approval_arsipdokumen(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $archives_id=$this->fiky_encryption->dekript($this->uri->segment(5));

        $param_edit=" and docno='$nama' or (docno!='$nama' and archives_id='$archives_id')";
        $paramcektmp= "and docno!='$nama' and archives_id='$archives_id'";
        $cek_edit=$this->m_arsipdokumen->q_tmp_arsipdokumen($param_edit)->num_rows();
        $dtluji=$this->m_arsipdokumen->q_tmp_arsipdokumen($paramcektmp)->num_rows();

        if ($cek_edit==0) {
            $info = array('status' => 'A1','approvaldate' => date('Y-m-d H:i:s'),'approvalby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.archives_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/arsipdokumen/form_arsipdokumen');
        }

        $paramview=" and docno='$nama'";
        $data['title']='APPROVAL DATA ARSIP';
        $data['dtlmst'] = $this->m_arsipdokumen->q_tmp_arsipdokumen($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_approval_arsipdokumen', $data);

    }

    function cancel_arsipdokumen(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $archives_id=$this->fiky_encryption->dekript($this->uri->segment(5));

        $param_edit=" and docno='$nama' or (docno!='$nama' and archives_id='$archives_id')";
        $paramcektmp= "and docno!='$nama' and archives_id='$archives_id'";
        $cek_edit=$this->m_arsipdokumen->q_tmp_arsipdokumen($param_edit)->num_rows();
        $dtluji=$this->m_arsipdokumen->q_tmp_arsipdokumen($paramcektmp)->num_rows();

        if ($cek_edit==0) {
            $info = array('status' => 'C','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.archives_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/arsipdokumen/form_arsipdokumen');
        }

        $paramview=" and docno='$nama'";
        $data['title']='PEMBATALAN DATA SIMPAN DATA ARSIP';
        $data['dtlmst'] = $this->m_arsipdokumen->q_tmp_arsipdokumen($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_cancel_arsipdokumen', $data);

    }

    function detail_arsipdokumen(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $archives_id=$this->fiky_encryption->dekript($this->uri->segment(5));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL DATA ARSIP DOKUMEN';
        $data['dtlmst'] = $this->m_arsipdokumen->q_his_arsipdokumen($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_detail_arsipdokumen', $data);

    }

    function save_arsipdokumen(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=strtoupper($this->input->post('docno'));
        $docdate=date('Y-m-d H:i:s');
        $docref=strtoupper($this->input->post('docref'));
        $archives_id=strtoupper($this->input->post('archives_id'));
        $archives_number=strtoupper($this->input->post('archives_number'));
        $path = "./assets/files/arsipDokumen";
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }


        $archives_exp=strtoupper($this->input->post('archives_exp'));
        if ($archives_exp==''){ $archives_exp=null; } else { $archives_exp=$archives_exp; }

        $old_archives_number=strtoupper($this->input->post('old_archives_number'));
        $old_archives_exp=strtoupper($this->input->post('old_archives_exp'));
        if ($old_archives_exp==''){ $old_archives_exp=null; } else { $old_archives_exp=$old_archives_exp; }
        $namapengurus=strtoupper($this->input->post('namapengurus'));
        $contactpengurus=strtoupper($this->input->post('contactpengurus'));
        $ttlvalue=strtoupper($this->input->post('ttlvalue'));
        $description=strtoupper($this->input->post('description'));
        $status=strtoupper($this->input->post('status'));
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;


        if ($type==='INPUTARSIPDOKUMEN'){
            $fileName = $_FILES['att_name']['name'];
            $config['upload_path'] = $path;
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size']		= 20000;
            $config['encrypt_name'] = true;

            $this->upload->initialize($config);
            $this->upload->do_upload('att_name');

            $fileData = $this->upload->data();
            $fileData['file_name'];
            $fileData['file_type'];
            $fileData['orig_name'];
            $infox = array(

                // 'docno' => $docno,
                'docdate' => $docdate,
                'docref' => $docref,
                'archives_id' => $archives_id,
                'archives_number' => $archives_number,
                'archives_exp' => $archives_exp,
                'old_archives_number' => $old_archives_number,
                'old_archives_exp' => $old_archives_exp,
                'namapengurus' => $namapengurus,
                'contactpengurus' => $contactpengurus,
                'ttlvalue' => str_replace('.','',$ttlvalue),
                'description' => $description,
                'status' => 'I',
                'inputdate' => $inputdate,
                'inputby' => $inputby,
                'att_name' => $fileData['file_name'] ,
                'att_dir' => $path.'/'.$fileData['file_name'] ,

            );
            $this->db->where('docno',$nama);
            $this->db->update('sc_tmp.archives_mst',$infox);

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');


            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_arsipdokumen->final_temporary_arsip();
            redirect('ga/arsipdokumen/form_arsipdokumen');

        } else if ($type==='EDITARSIPDOKUMEN'){
            $fileName = $_FILES['att_name']['name'];
            $config['upload_path'] = $path;
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size']		= 20000;
            $config['encrypt_name'] = true;

            $this->upload->initialize($config);
            $this->upload->do_upload('att_name');

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $fileData = $this->upload->data();
            $fileData['file_name'];
            $fileData['file_type'];
            $fileData['orig_name'];
            $info = array(
                'archives_id' => $archives_id,
                'archives_number' => $archives_number,
                'archives_exp' => $archives_exp,
                'old_archives_number' => $old_archives_number,
                'old_archives_exp' => $old_archives_exp,
                'namapengurus' => $namapengurus,
                'contactpengurus' => $contactpengurus,
                'ttlvalue' => str_replace('.', '', $ttlvalue),
                'description' => $description,
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
                'att_name' => $fileData['file_name'] ,
                'att_dir' => $path.'/'.$fileData['file_name'] ,
            );
            $this->db->where('docno', $nama);
            $this->db->update('sc_tmp.archives_mst', $info);


            $infotrxerror = array(
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror', $infotrxerror);
            /*final input */
            $this->m_arsipdokumen->final_temporary_arsip();
            redirect('ga/arsipdokumen/form_arsipdokumen');

        }  else if ($type==='APPROVALARSIPDOKUMEN'){
            $info = array(
                'approvaldate' => date('Y-m-d H:i:s'),
                'approvalby' => $nama,
            );
            $this->db->where('docno',$nama);
            $this->db->update('sc_tmp.archives_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_arsipdokumen->final_temporary_arsip();
            redirect('ga/arsipdokumen/form_arsipdokumen');

        }  else if ($type=='CANCELARSIPDOKUMEN'){

            $info = array(
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
            );
            $this->db->where('docno',$nama);
            $this->db->update('sc_tmp.archives_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_arsipdokumen->final_temporary_arsip();
            redirect('ga/arsipdokumen/form_arsipdokumen');

        }

    }

    function clear_arsipdokumen(){
        $type=trim(strtoupper($this->input->post('type')));
        $nama=trim($this->session->userdata('nik'));
        $stockcode=trim(strtoupper($this->input->post('type')));
        $paramview=" and docno='$nama'";
        $dtlmst = $this->m_arsipdokumen->q_tmp_arsipdokumen($paramview)->row_array();
        if(trim($dtlmst['status'])=='I') {
            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.archives_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/arsipdokumen/form_arsipdokumen');
        } else if(trim($dtlmst['status'])=='E') {
            $this->db->where('docno', trim($dtlmst['nodoktmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'nodoktmp' => '',
            );
            $this->db->update('sc_his.archives_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.archives_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/arsipdokumen/form_arsipdokumen');
        } else if(trim($dtlmst['status'])=='A') {
            $this->db->where('docno', trim($dtlmst['nodoktmp']));
            $info = array(
                'status' => 'A',
                'approvalby' => '',
                'approvaldate' => null,
                'nodoktmp' => '',
            );
            $this->db->update('sc_his.archives_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.archives_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/arsipdokumen/form_arsipdokumen');
        } else if(trim($dtlmst['status'])=='C') {
            $this->db->where('docno', trim($dtlmst['nodoktmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'nodoktmp' => '',
            );
            $this->db->update('sc_his.archives_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.archives_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/arsipdokumen/form_arsipdokumen');
        } else {
            redirect('ga/arsipdokumen/form_arsipdokumen');
        }
    }

    function final_tmp_mst(){
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $stockcode=$this->fiky_encryption->dekript($this->uri->segment(5));
    }

    function json_ujikir(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $stockcode=$this->fiky_encryption->dekript($this->uri->segment(5));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL DATA UJI KIR KENDARAAN';
        $data['dtlmst'] = $this->m_arsipdokumen->q_his_mst_ujikir($paramview)->row_array();

        $param=" and docno='$docno'";
        $datamst = $this->m_arsipdokumen->q_master_branch()->result();
        $datadtl = $this->m_arsipdokumen->q_json_ujikir_his($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'master' => $datamst,
                'detail' => $datadtl,
                 ), JSON_PRETTY_PRINT);
    }

    function sti_ujikir(){
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));
        $stockcode=$this->fiky_encryption->dekript($this->uri->segment(5));
        $enc_docno=$this->uri->segment(4);
        $data['jsonfile'] = "ga/ujikir/json_ujikir/$enc_docno";
        $data['report_file'] = 'assets/mrt/sti_ujikir.mrt';
        $this->load->view("ga/ujikir/sti_ujikir",$data);
    }

    /* FORM MASTERING ARSIP */
    function form_master_arsip() {

            $data['title'] = " MASTER DATA PENGARSIPAN DOKUMEN PERUSAHAAN ";
            $nama=trim($this->session->userdata('nik'));
            $dtlbranch = $this->m_akses->q_branch()->row_array();
            $branch = $dtlbranch['branch'];

            /* CODE UNTUK VERSI*/
            $nama=trim($this->session->userdata('nik'));
            $kodemenu='I.D.B.1'; $versirelease='I.D.B.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
            $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
            $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
            $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
            $data['kodemenu']=$kodemenu; $data['version']=$versidb;
            /* END CODE UNTUK VERSI */

            $paramerror=" and userid='$nama' and modul='ACV'";
            $dtlerror=$this->m_arsipdokumen->q_trxerror($paramerror)->row_array();
            $count_err=$this->m_arsipdokumen->q_trxerror($paramerror)->num_rows();
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

            $paramtrxmst="";
            $data['list_kanwil'] = $this->m_arsipdokumen->q_mgudang()->result();
            $data['list_trx_mst'] = $this->m_arsipdokumen->q_mst_archives($paramtrxmst)->result();
            $data['list_scgroup']=$this->m_arsipdokumen->q_scgroup()->result();
            $data['list_scsubgroup']=$this->m_arsipdokumen->q_scsubgroup()->result();
            $data['list_gudang']=$this->m_arsipdokumen->q_mgudang()->result();
            $this->template->display('ga/arsipdokumen/v_form_master_arsip', $data);

            $paramerror=" and userid='$nama'";
            $this->m_arsipdokumen->q_deltrxerror($paramerror);

    }

    function save_master_arsip(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=strtoupper($this->input->post('docno'));
        $docdate=date('Y-m-d H:i:s');
        $docref=strtoupper($this->input->post('docref'));
        $kdgroup=strtoupper($this->input->post('kdgroup'));
        $kdsubgroup=strtoupper($this->input->post('kdsubgroup'));
        $loccode=strtoupper($this->input->post('loccode'));
        $archives_id=strtoupper($this->input->post('archives_id'));
        $archives_number=strtoupper($this->input->post('archives_number'));
        $archives_name=strtoupper($this->input->post('archives_name'));
        $archives_own=strtoupper($this->input->post('archives_own'));
        $chold=strtoupper($this->input->post('chold'));
        $description=strtoupper($this->input->post('description'));
        $archives_exp=strtoupper($this->input->post('archives_exp'));
        if ($archives_exp==''){ $archives_exp=null; } else { $archives_exp = $archives_exp; }
        $inputby = $nama;
        $inputdate = date('Y-m-d H:m:s');

        if ($type === 'INPUT') {
            $info = array(
                'docno' => $nama,
                'docdate' => $docdate,
                'docref' => $docref,
                'kdgroup' => $kdgroup,
                'kdsubgroup' => $kdsubgroup,
                'archives_id' => $archives_id,
                'archives_number' => $archives_id,
                'archives_name' => $archives_name,
                'archives_own' => $archives_own,
                'loccode' => $loccode,
                'archives_exp' => $archives_exp,
                'description' => $description,
                'chold' => $chold,
                'inputdate' => $inputdate,
                'inputby' => $inputby,
            );
            $this->db->insert('sc_mst.archives',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
        } else if ($type === 'UPDATE') {
            $infou = array(
                'docref' => $docref,
                'archives_id' => $archives_id,
                'archives_number' => $archives_id,
                'archives_name' => $archives_name,
                'archives_own' => $archives_own,
                'loccode' => $loccode,
                'archives_exp' => $archives_exp,
                'description' => $description,
                'chold' => $chold,
                'updatedate' => $inputdate,
                'updateby' => $inputby,
            );
            $this->db->where('docno',$docno);
            $this->db->update('sc_mst.archives',$infou);

            $this->db->where('userid',$nama);
            $this->db->where('modul','ACV');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => $docno,
                'nomorakhir2' => '',
                'modul' => 'ACV',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
        } else if ($type === 'DELETE') {
            $this->db->where('docno',$docno);
            $this->db->delete('sc_mst.archives');
        }


        redirect('ga/arsipdokumen/form_master_arsip');

    }

    function edit_master_arsipdokumen(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.B.1'; $versirelease='I.D.B.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $paramview=" and docno='$docno'";
        $data['title']='UBAH DATA ARSIP DOKUMEN';
        $data['list_kanwil'] = $this->m_arsipdokumen->q_mgudang()->result();
        $data['list_scgroup']=$this->m_arsipdokumen->q_scgroup()->result();
        $data['list_scsubgroup']=$this->m_arsipdokumen->q_scsubgroup()->result();
        $data['list_gudang']=$this->m_arsipdokumen->q_mgudang()->result();
        $data['dtlmst'] = $this->m_arsipdokumen->q_mst_archives($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_edit_master_arsipdokumen', $data);

    }

    function detail_master_arsipdokumen(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript($this->uri->segment(4));

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.B.1'; $versirelease='I.D.B.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL DATA ARSIP DOKUMEN';
        $data['list_kanwil'] = $this->m_arsipdokumen->q_mgudang()->result();
        $data['list_scgroup']=$this->m_arsipdokumen->q_scgroup()->result();
        $data['list_scsubgroup']=$this->m_arsipdokumen->q_scsubgroup()->result();
        $data['list_gudang']=$this->m_arsipdokumen->q_mgudang()->result();
        $data['dtlmst'] = $this->m_arsipdokumen->q_mst_archives($paramview)->row_array();
        $this->template->display('ga/arsipdokumen/v_detail_master_arsipdokumen', $data);

    }
}
