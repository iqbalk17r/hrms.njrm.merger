<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Bbmkendaraan extends MX_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->load->model(array('m_kendaraan', 'master/m_akses', 'master/m_geo', 'm_bbmkendaraan', 'm_insupplier', 'm_instock'));
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt', 'Excel_generator','fiky_report'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA, PENCATATAN BBM KENDARAN";
        $this->template->display('ga/kendaraan/v_index', $data);
    }


    /* FORM BBM KENDARAAN */
    function form_bbmkendaraan()
    {
        $data['title'] = " FORM HISTORY PEMAKAIAN BAHAN BAKAR KENDARAAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = $dtlbranch['branch'];

        /* CODE UNTUK VERSI */
        $kodemenu = 'I.G.G.5';
        $versirelease = 'I.G.G.5/ALPHA.001';
        $userid = $this->session->userdata('nik');
        $vdb = $this->m_bbmkendaraan->q_versidb($kodemenu)->row_array();
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
        $vdb = $this->m_bbmkendaraan->q_versidb($kodemenu)->row_array();
        $versidb = $vdb['vrelease'];
        $data['version'] = $versidb;
        /* END CODE UNTUK VERSI */
        $paramerror=" and userid='$nama' and modul='BA_BK'";
        $dtlerror=$this->m_bbmkendaraan->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_bbmkendaraan->q_trxerror($paramerror)->num_rows();
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
        $cekmst_na=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_1)->num_rows(); //input
        $cekmst_ne=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_2)->num_rows(); //edit
        $cekmst_napp=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_3)->num_rows(); //approv
        $cekmst_cancel=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_4)->num_rows(); //cancel
        $cekmst_hangus=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_5)->num_rows(); //hangus
        $cekmst_ra=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_6)->num_rows(); //REALISASI
        $cekmst_ch=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_7)->num_rows(); //REALISASI
        $dtledit=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param3_1_R)->row_array(); //edit row array
        $isCanReopenPrint = ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR TRIM($this->session->userdata('lvl')) == 'A');
        $enc_nama=bin2hex($this->encrypt->encode($nama));
        $data['enc_nama']=bin2hex($this->encrypt->encode($nama));
        if ($cekmst_na>0) { //cek inputan
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/bbmkendaraan/input_bbmkendaraan");
        } else if ($cekmst_ne>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/bbmkendaraan/edit_bbmkendaraan");
        } else if ($cekmst_napp>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/bbmkendaraan/approval_bbmkendaraan");
        } else if ($cekmst_cancel>0){
            $enc_nik=bin2hex($this->encrypt->encode(trim($dtledit['nik'])));
            $enc_doctype=bin2hex($this->encrypt->encode(trim($dtledit['doctype'])));
            redirect("ga/bbmkendaraan/cancel_bbmkendaraan");
        }
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('periode'))));
        $kdgudang=$this->input->post('kdgudangfl');
        $stockcode=$this->input->post('kdbarangfl');
        if (!empty($tglYM)) {

            $periode=$tglYM; $param_postperiode=" and to_char(docdate,'yyyymm')='$periode'"; }
        else if ( empty($tglYM) and (!empty($kdgudang) or !empty($stockcode)) ) {
            $param_postperiode="";
        } else
            {
            $periode=date('Ym');  $param_postperiode=" and to_char(docdate,'yyyymm')='$periode'";
        }

        if (!empty($kdgudang)) {

            $param_postgudang=" and kdgudang='$kdgudang'"; } else { $param_postgudang=""; }

        if (!empty($stockcode)) {

            $param_poststock=" and stockcode='$stockcode'"; } else { $param_poststock=""; }


        $paramtrxmst = $param_postperiode.$param_postgudang.$param_poststock;
        $data['list_kanwil'] = $this->m_bbmkendaraan->q_mstkantor()->result();
        $data['isCanReopenPrint'] = $isCanReopenPrint;
        $data['list_trx_mst'] = $this->m_bbmkendaraan->q_his_bbmkendaraan_mst($paramtrxmst)->result();
        $data['enc_param_excel'] = bin2hex($this->encrypt->encode($paramtrxmst));
        $this->template->display('ga/bbmkendaraan/v_form_bbmkendaraan', $data);

        $paramerror=" and userid='$nama'";
        $this->m_bbmkendaraan->q_deltrxerror($paramerror);


    }

    function input_bbmkendaraan(){
        $nama = trim($this->session->userdata('nik'));

        $type = strtoupper($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdgudang=$this->input->post('kdgudang');
        $stockcode=$this->input->post('kdbarang');

        $param_inp=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";

        $cekBA_BK_inp=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param_inp)->num_rows();

        if ($cekBA_BK_inp==0) {
            $param_insert=" and nodok='$stockcode'";
            $this->m_bbmkendaraan->insert_tmp_bbmkendaraan($param_insert);
        }
        $paramview=" and docno='$nama'";
        $data['title']='INPUT PEMAKAIAN BIAYA BBM KENDARAAN';
        $data['dtlmst'] = $this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramview)->row_array();
        $data['jenisbbm'] = $this->m_bbmkendaraan->q_mstjenisbbm()->result_array();
        $data['kategorisupplier'] = $this->m_insupplier->q_jsupplier(" and kdjsupplier = 'J3'")->result_array();
        $this->template->display('ga/bbmkendaraan/v_input_bbmkendaraan', $data);


    }

    function edit_bbmkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekBA_BK_edit=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param_edit)->num_rows();
        $dtluji=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramcektmp)->num_rows();

        if ($cekBA_BK_edit==0) {
            $info = array('status' => 'E','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.bbmkendaraan_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        }

        $paramview=" and docno='$nama'";
        $data['title']='UBAH PEMAKAIAN BAHAN BAKAR KENDARAAN';
        $data['dtlmst'] = $this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramview)->row_array();
        $data['jenisbbm'] = $this->m_bbmkendaraan->q_mstjenisbbm()->result_array();
        $data['kategorisupplier'] = $this->m_insupplier->q_jsupplier(" and kdjsupplier = 'J3'")->result_array();
        $data['supplier'] = $this->m_insupplier->q_kdsupplier_param(" and kdgroup = '" . trim($data['dtlmst']['kdgroup']) . "'")->result_array();
        $data['subsupplier'] = $this->m_insupplier->q_kdsubsupplier_param(" and kdsupplier = '" . trim($data['dtlmst']['suppcode']) . "'")->result_array();

        $this->template->display('ga/bbmkendaraan/v_edit_bbmkendaraan', $data);

    }

    function approval_bbmkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekBA_BK_edit=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param_edit)->num_rows();
        $dtluji=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramcektmp)->num_rows();

        if ($cekBA_BK_edit==0) {
            $info = array('status' => 'A1','approvaldate' => date('Y-m-d H:i:s'),'approvalby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.bbmkendaraan_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        }

        $paramview=" and docno='$nama'";
        $data['title']='APPROVAL PEMAKAIAN BAHAN BAKAR KENDARAAN';
        $data['dtlmst'] = $this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/bbmkendaraan/v_approval_bbmkendaraan', $data);

    }

    function cancel_bbmkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));

        $param_edit=" and docno='$nama' or (docno!='$nama' and stockcode='$stockcode')";
        $paramcektmp= " and stockcode='$stockcode'";
        $cekBA_BK_edit=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($param_edit)->num_rows();
        $dtluji=$this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramcektmp)->num_rows();

        if ($cekBA_BK_edit==0) {
            $info = array('status' => 'C','updatedate' => date('Y-m-d H:i:s'),'updateby' => $nama);
            $this->db->where('docno',$docno);
            $this->db->update('sc_his.bbmkendaraan_mst',$info);
        }

        if ($dtluji>0){
            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 2,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        }

        $paramview=" and docno='$nama'";
        $data['title']='BATAL PEMAKAIAN BAHAN BAKAR KENDARAAN';
        $data['dtlmst'] = $this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/bbmkendaraan/v_cancel_bbmkendaraan', $data);

    }

    function detail_bbmkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL PEMAKAIAN BAHAN BAKAR KENDARAAN';
        $data['dtlmst'] = $this->m_bbmkendaraan->q_his_bbmkendaraan_mst($paramview)->row_array();
        $this->template->display('ga/bbmkendaraan/v_detail_bbmkendaraan', $data);
    }

    function save_bbmkendaraan(){
        $nama=trim($this->session->userdata('nik'));
        $type=trim($this->input->post('type'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $kdrangka=trim($this->input->post('kdrangka'));
        $kdmesin=trim($this->input->post('kdmesin'));
        $stockcode=trim($this->input->post('stockcode'));
        $bahanbakar=trim($this->input->post('bahanbakar'));
        $km_awal=str_replace('.','',$this->input->post('km_awal'));
        $km_awal=intval(str_replace(',','.',$km_awal));
        $km_akhir=str_replace('.','',$this->input->post('km_akhir'));
        $km_akhir=intval(str_replace(',','.',$km_akhir));
        $ttlvalue=str_replace('.','',$this->input->post('ttlvalue'));
        $ttlvalue=str_replace(',','.',$ttlvalue);
        $ttlvalue=intval(str_replace(',','.',$ttlvalue));
        $docdate=trim($this->input->post('docdate'));
        $suppcode=trim($this->input->post('kdsupplier'));
        $subsuppcode=trim($this->input->post('kdsubsupplier'));
        $kupon=strtoupper($this->input->post('kupon'));
        $liters=str_replace('.','',$this->input->post('liters'));
        $liters=str_replace(',','.',$liters);
        $description=strtoupper($this->input->post('description'));
        $hargasatuan=str_replace('.','',$this->input->post('hargasatuan'));
        $hargasatuan=str_replace(',','.',$hargasatuan);
        $hargasatuan = $hargasatuan ?: null;
        if ($type==='INPUTBBMKENDARAAN'){
            $info = array(
                'docdate' => $docdate,
                'docref' => $kupon,
                'bahanbakar' => $bahanbakar,
                'km_awal' => $km_awal,
                'km_akhir' => $km_akhir,
                'ttlvalue' => $ttlvalue,
                'suppcode' => $suppcode,
                'subsuppcode' => $subsuppcode,
                'description' => $description,
                'kupon' => $kupon,
                'liters' => $liters,
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => $nama,
                'hargasatuan' => $hargasatuan,
            );
            $this->db->update('sc_tmp.bbmkendaraan_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_bbmkendaraan->final_temporary_bbmkendaraan();
            redirect('ga/bbmkendaraan/form_bbmkendaraan');

        } else if ($type==='EDITBBMKENDARAAN'){
            $info = array(
                ////'docdate' => $docdate,
                'docref' => $kupon,
                'bahanbakar' => $bahanbakar,
                'km_awal' => $km_awal,
                'km_akhir' => $km_akhir,
                'ttlvalue' => str_replace(',','',$ttlvalue),
                'suppcode' => $suppcode,
                'subsuppcode' => $subsuppcode,
                'description' => $description,
                'kupon' => $kupon,
                'liters' => $liters,
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => $nama,
                'hargasatuan' => $hargasatuan,
            );
            $this->db->update('sc_tmp.bbmkendaraan_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_bbmkendaraan->final_temporary_bbmkendaraan();
            redirect('ga/bbmkendaraan/form_bbmkendaraan');

        }  else if ($type=='APPROVALBBMKENDARAAN'){
            $info = array(
                'approvaldate' => date('Y-m-d H:i:s'),
                'approvalby' => $nama,
            );
            $this->db->update('sc_tmp.bbmkendaraan_mst',$info);

            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_bbmkendaraan->final_temporary_bbmkendaraan();
            redirect('ga/bbmkendaraan/form_bbmkendaraan');

        }  else if ($type=='CANCELBBMKENDARAAN'){

            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            /*final input */
            $this->m_bbmkendaraan->final_temporary_bbmkendaraan();
            redirect('ga/bbmkendaraan/form_bbmkendaraan');

        }

    }

    function clear_bbmkendaraan(){
        $type=trim(strtoupper($this->input->post('type')));
        $nama=trim($this->session->userdata('nik'));
        $stockcode=trim(strtoupper($this->input->post('type')));
        $paramview=" and docno='$nama'";
        $dtlmst = $this->m_bbmkendaraan->q_tmp_bbmkendaraan_mst($paramview)->row_array();
        if(trim($dtlmst['status'])=='I') {
            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.bbmkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        } else if(trim($dtlmst['status'])=='E') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.bbmkendaraan_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.bbmkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','bbmkendaraan_mst');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        } else if(trim($dtlmst['status'])=='A') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'approvalby' => '',
                'approvaldate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.bbmkendaraan_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.bbmkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','bbmkendaraan_mst');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        } else if(trim($dtlmst['status'])=='C') {
            $this->db->where('docno', trim($dtlmst['docnotmp']));
            $info = array(
                'status' => 'A',
                'updateby' => '',
                'updatedate' => null,
                'docnotmp' => '',
            );
            $this->db->update('sc_his.bbmkendaraan_mst',$info);

            $this->db->where('docno', $nama);
            $this->db->delete('sc_tmp.bbmkendaraan_mst');

            $this->db->where('userid',$nama);
            $this->db->where('modul','BA_BK');
            $this->db->delete('sc_mst.trxerror');

            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'BA_BK',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);

            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        } else {
            redirect('ga/bbmkendaraan/form_bbmkendaraan');
        }
    }

    public function excel_bbmkendaraan(){
        $param = $this->fiky_encryption->dekript((($this->uri->segment(4))));

        $datane=$this->m_bbmkendaraan->q_excel_bbmkendaraan_mst($param);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Dokumen','Tanggal','Nama Kendaraan','Nopol','Tahun Pembuatan','Nama Supplier','Bahan Bakar','Harga Satuan','KM Awal','KM Akhir','Liters','Keterangan','Biaya'
        ));



        $this->excel_generator->set_column(array('docno','tgldoc','nmbarang','nopol','tahunpembuatan','nmsubsupplier','bahanbakar','hargasatuan','km_awal','km_akhir','liters','description','ttlvalue'
        ));

        $this->excel_generator->set_width(array(15,20,20,10,10,15,10,10,10,10,10,100,18
        ));
        $this->excel_generator->exportTo2007('BBM Kendaraan');
    }

    function final_tmp_mst(){
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));
    }

    function json_bbmkendaraan(){
        $nama = trim($this->session->userdata('nik'));
        $dtlbranch = $this->m_akses->q_branch()->row_array();
        $branch = strtoupper(trim($dtlbranch['branch']));
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));

        $paramview=" and docno='$docno'";
        $data['title']='DETAIL PEMAKAIAN BAHAN BAKAR KENDARAAN';
        $data['dtlmst'] = $this->m_bbmkendaraan->q_his_bbmkendaraan_mst($paramview)->row_array();

        $param=" and docno='$docno'";
        $datamst = $this->m_bbmkendaraan->q_master_branch()->result();
        $datadtl = $this->m_bbmkendaraan->q_json_bbmkendaraan_his($param)->result();
        header("Content-Type: text/json");
        echo json_encode(
            array(
                'master' => $datamst,
                'detail' => $datadtl,
                 ), JSON_PRETTY_PRINT);
    }

    function sti_bbmkendaraan(){
        $docno=$this->fiky_encryption->dekript((($this->uri->segment(4))));
        $stockcode=$this->fiky_encryption->dekript((($this->uri->segment(5))));
        $enc_docno=$this->uri->segment(4);
        $enc_stockcode=$this->uri->segment(4);
        $title = " Report BBM Kendaraan ";
        $session = $this->session->userdata('nik');
        $datajson =  base_url("ga/bbmkendaraan/json_bbmkendaraan/$enc_docno/$enc_stockcode") ;
        $datamrt =  base_url("assets/mrt/sti_bbmkendaraan.mrt") ;

        $updet = array(
            'printyes' => 'YES',
            'printby' => trim($session),
            'printdate' => date('Y-m-d H:i:s')
        );
        $this->db->where('docno',$docno);
        $this->db->update('sc_his.bbmkendaraan_mst',$updet);
        return $this->fiky_report->render($datajson,$datamrt,$title,$session);
    }

    function cek_lib(){
        //information usage
        //public function render($datajson,$datamrt,$title,$session) {
        //echo $this->fiky_report->handler();
        echo $this->fiky_report->render();
        //echo $this->fiky_report->loadLicense();
       // echo $this->fiky_report->cekloadlib();
       //echo $this->fiky_report->testLoad();
    }

    function get_supplier() {
        $kdgroup = $this->input->post('kdgroup');
        echo json_encode($this->m_insupplier->q_kdsupplier_param(" and kdgroup = '$kdgroup'")->result());
    }

    function get_subsupplier() {
        $kdsupplier = $this->input->post('kdsupplier');
        echo json_encode($this->m_insupplier->q_kdsubsupplier_param(" and kdsupplier = '$kdsupplier'")->result());
    }

    function get_barang() {
        $kdgudang = $this->input->post('kdgudang');
        $kdgroup = $this->input->post('kdgroup');
        echo json_encode($this->m_instock->q_stockcode_param(" and kdgroup='$kdgroup' and kdgudang='$kdgudang'")->result());
    }

    public function reopenprint($param = null)
    {
        $json = json_decode(hex2bin($param));
        $isCanReopenPrint = ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR TRIM($this->session->userdata('lvl')) == 'A');
        if ($isCanReopenPrint){
            $transaction = $this->m_bbmkendaraan->q_his_bbmkendaraan_mst(' AND docno = \''.$json->docno.'\' ')->row();
            if (!empty($transaction)){
                if ($this->m_bbmkendaraan->q_transaction_update(array(
                    'printyes' => 'NO',
                ),array(
                    'docno' => trim($transaction->docno),
                ))){
                    header('Content-Type: application/json');
                    http_response_code('200');
                    echo json_encode(array(
                        'message' => 'DATA <b>'.trim($transaction->docno).'</b> BERHASIL DIUBAH',
                        'redirect' => site_url('ga/bbmkendaraan/form_bbmkendaraan'),
                    ));
                }

            }else{
                header('Content-Type: application/json');
                http_response_code('403');
                echo json_encode(array(
                    'message' => 'DATA TIDAK DITEMUKAN',
                ));
            }
        }else{
            header('Content-Type: application/json');
            http_response_code('403');
            echo json_encode(array(
                'message' => 'ANDA TIDAK MEMILIKI AKSES',
            ));
        }
    }

    public function chooseprinttype($param = null){
        $json = json_decode(hex2bin($param));
        $transaction = $this->m_bbmkendaraan->q_his_bbmkendaraan_mst(' AND docno = \''.$json->docno.'\' ')->row();
        if (!empty($transaction)){
            $prinType = strtoupper($this->input->post('printype'));
//            $this->printdocument();
            header('Content-Type: application/json');
            http_response_code('200');
            echo json_encode(array(
                'url' => site_url('ga/bbmkendaraan/printdocument/'.bin2hex(json_encode(array('docno' => $json->docno, 'stockcode'=> $json->stockcode, 'printtype'=>$prinType))))
            ));
        }else{
            header('Content-Type: application/json');
            http_response_code('403');
            echo json_encode(array(
                'message' => 'DATA TIDAK DITEMUKAN',
            ));
        }
    }

    function printdocument($param = null){
        $json = json_decode(hex2bin($param));
        $docno=$json->docno;
        $stockcode=$json->stockcode;
        $enc_docno= $this->fiky_encryption->enkript((trim($json->docno)));
        $enc_stockcode= $this->fiky_encryption->enkript((trim($json->stockcode)));
        $title = " Report BBM Kendaraan ";
        $session = $this->session->userdata('nik');
        $datajson =  base_url("ga/bbmkendaraan/json_bbmkendaraan/$enc_docno/$enc_stockcode");
        if ($json->printtype == 'NONZERO'){
            $datamrt =  base_url("assets/mrt/sti_bbmkendaraan.mrt") ;
        }else{
            $datamrt =  base_url("assets/mrt/sti_bbmkendaraan_zero.mrt") ;
        }
        $update = array(
            'printyes' => 'YES',
            'printby' => trim($session),
            'printdate' => date('Y-m-d H:i:s')
        );
        $this->db->where('docno',$docno);
        $this->db->update('sc_his.bbmkendaraan_mst',$update);
        return $this->fiky_report->render($datajson,$datamrt,$title,$session);
    }
}
