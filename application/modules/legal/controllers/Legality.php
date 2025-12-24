<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/21/20, 9:27 AM
 *  * Last Modified: 10/21/20, 9:27 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

class Legality extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'template', 'upload', 'pdf', 'encrypt'));
        $this->load->model(array('m_legality','api/m_globalmodule'));

        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        $data['title'] = "SELAMAT DATANG DI MENU GA AJUSTMENT, SILAHKAN PILIH MENU YANG ADA";
        $this->template->display('ga/ajustment/v_index', $data);
    }

    function form_legal(){
        $data['title']='FORM LEGALITY';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.A.1'; $versirelease='I.D.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        //$this->db->cache_delete('legal','legality');
        $nama = trim($this->session->userdata('nik'));
        $data['cektmp']=$this->db->query("select * from sc_tmp.legal_master where docno='$nama'")->num_rows();

        $this->template->display('legal/legality/v_form_legal',$data);
    }

    function input_form_legal(){
        $data['title'] = 'FORM INPUT DOKUMEN LEGAL';
        $this->load->view('legal/legality/v_modal_input',$data);
    }

    function edit_form_legal(){
        $nama = trim($this->session->userdata('nik'));
        $docno = $this->input->get('docno');
        $info = array(
            'status' => 'E',
            'updateby' => $nama,
            'updatedate' => date('Y-m-d H:i:s'),

        );
        $this->db->where('docno',$docno);
        $this->db->update('sc_his.legal_master',$info);
        redirect('legal/legality/form_legal');
    }

    function detaiL_legal(){
        $data['title']='FORM LEGALITY';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $enc_docno = $this->uri->segment(4);
        $docno = $this->fiky_encryption->dekript($enc_docno);
        $kodemenu='I.D.A.1'; $versirelease='I.D.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $p1 = " and docno='$docno'";
        $p2 = " and docno='$docno'";
        $data['mst']=$this->m_legality->q_his_legal_master($p1)->result();
        $data['dtl']=$this->m_legality->q_his_legal_detail($p2)->result();
        $data['enc_docno']=$enc_docno;

        $this->template->display('legal/legality/v_detail_legal',$data);
    }

    function edit_legal(){
        $data['title']='EDIT FORM LEGALITY';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $enc_docno = $this->uri->segment(4);
        $docno = $this->fiky_encryption->dekript($enc_docno);
        $kodemenu='I.D.A.1'; $versirelease='I.D.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $p1 = " and docno='$docno'";
        $p2 = " and docno='$docno'";
        $data['mst']=$this->m_legality->q_his_legal_master($p1)->result();
        $data['mstRow']=$this->m_legality->q_his_legal_master($p1)->row_array();
        $data['dtl']=$this->m_legality->q_his_legal_detail($p2)->result();

        $this->template->display('legal/legality/v_edit_legal',$data);
    }

    function save_legal()
    {
        $type = trim($this->input->post('type'));
        $docno = trim($this->input->post('docno'));
        $sort = trim($this->input->post('sort'));
        $docref = $this->input->post('docref');
        $dateoperation = $this->input->post('dateoperation');
        $operationcategory = $this->input->post('operationcategory');
        $progress = strtoupper($this->input->post('progress'));
        $description = strtoupper($this->input->post('description'));
        $enc_docno = $this->fiky_encryption->enkript($docno);
        $path = "./assets/archive/documenlegal/";
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        /* $files = glob('/archive/documenlegal/*'); // get all file names
         foreach ($files as $file) { // iterate files
             if (is_file($file))
                 unlink($file); // delete file
         }*/


        if ($type === 'INPUT_DETAIL_HIS') {
            $config['upload_path'] = $path;
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $config['max_size'] = 25 * 1000; //10:mb
            $this->upload->initialize($config);

            $upload_data = $this->upload->do_upload('attachment');
            /*if (!$upload_data) {
                $show = $this->upload->display_errors();
            }*/
            $dtlmst = $this->m_legality->q_his_legal_master($param = " and coalesce(docno,'') = '$docno'")->row_array();
            $upil = $this->upload->data();
            $file_name = $upil['file_name'];
            $file_type = $upil['file_type'];
            $file_origname = $upil['orig_name'];
            $file_ext = $upil['file_ext'];
            $file_path = $path . $file_name;
            $file_size = $upil['file_size'];

            $infox = array(
                'sort' => 0,
                'docno' => $docno,
                'docref' => $docref,
                'dateoperation' => date('Y-m-d H:i:s', strtotime($dateoperation)),
                'operationcategory' => $operationcategory,
                'doctype' => $dtlmst['doctype'],
                'docname' => $dtlmst['docname'],
                'coperator' => $dtlmst['coperator'],
                'coperatorname' => $dtlmst['coperatorname'],
                'idbu' => $dtlmst['idbu'],
                'namebu' => $dtlmst['nmbux'],
                'progress' => $progress,
                'attachment' => $file_name,
                'attachment_dir' => $file_path,
                'status' => 'I',
                'docdate' => date('Y-m-d H:i:s'),
                'description' => $description,
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => trim($this->session->userdata('nik')),
            );

            if ($this->db->insert('sc_his.legal_detail', $infox)) {
                $this->db->cache_delete('api', 'legality');
                $this->db->cache_delete('legal', 'legality');
                redirect('legal/legality/edit_legal' . '/' . $enc_docno);
            } else {
                redirect('legal/legality/edit_legal' . '/' . $enc_docno. '/FAILED');
            }


        } else if ($type === 'DEL_DETAIL_HIS') {

            $this->db->where(array('docno' => $docno, 'sort' => $sort));
            if ($this->db->delete('sc_his.legal_detail')) {
                $this->db->cache_delete('api', 'legality');
                $this->db->cache_delete('legal', 'legality');
                redirect('legal/legality/edit_legal' . '/' . $enc_docno);
            } else {
                // redirect('legal/legality/edit_legal'.'/'.$enc_docno);
                redirect('legal/legality/edit_legal' . '/' . $enc_docno. '/FAILED');
            }
        }
    }

    function final_perkara($enc_docno){
        $docno = $this->fiky_encryption->dekript($enc_docno);
        $inputby = trim($this->session->userdata('nik'));
        $inputdate = date('Y-m-d H:i:s');

        $infox = array(
            'status' => 'F',
            'finishby' => $inputby,
            'finishdate' => $inputdate,
        );
        $this->db->where('docno' , $docno);
        $this->db->update('sc_his.legal_master' , $infox);
        redirect('legal/legality/form_legal');
    }


    // For Report Legal
    function laporan(){
        $data['title'] = 'LAPORAN LEGAL PER-WILAYAH';
        $data['title_sby']='DOCUMENT LEGAL AKTIF SELURUH CABANG';
        $data['title_smg']='NUSA RETAIL SEMARANG';
        $data['title_dmk']='NUSA RETAIL DEMAK';
        $data['title_jog']='NUSA RETAIL JOGJAKARTA';
        $data['title_nas']='NUSA RETAIL NASIONAL';
        $data['title_skh']='NUSA RETAIL SUKOHARJO';
        $data['title_jkt']='NUSA RETAIL JAKARTA';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.D.A.2'; $versirelease='I.D.A.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        //$this->db->cache_delete('legal','legality');
        $nama = trim($this->session->userdata('nik'));
        $data['listkantor'] = $this->m_globalmodule->q_kantorwilayah($param = null )->result();
        $data['SBY'] = $this->m_legality->q_report_legal(" and idbu='SBYMRG'")->result();
        $data['DMK'] = $this->m_legality->q_report_legal(" and idbu='SMGDMK'")->result();
        $data['JKT'] = $this->m_legality->q_report_legal(" and idbu='JKTKPK'")->result();
        $data['SKH'] = $this->m_legality->q_report_legal(" and idbu='SKHRJ'")->result();
        $data['NAS'] = $this->m_legality->q_report_legal(" and idbu='NAS'")->result();
        $data['SMG'] = $this->m_legality->q_report_legal(" and idbu='SMGCND'")->result();
        $data['JOG'] = $this->m_legality->q_report_legal(" and idbu='JOG'")->result();
        $this->template->display('legal/legality/v_laporan_legal',$data);
    }


    /*report tester*/

    function view_report(){
        $enc_docno =$this->input->get('enc_docno');
        $docno=$this->fiky_encryption->dekript($enc_docno);

        $title = " Reporting Point";
        $session = trim($this->session->userdata('nik'));
        $datajson =  base_url("api/legality/reportJson?enc_docno=$enc_docno") ;
        $datamrt =  base_url("assets/mrt/rpt_legal_report.mrt") ;

        /*$updet = array(
            'printyes' => 'YES',
            'printby' => trim($session),
            'printdate' => date('Y-m-d H:i:s')
        );
        $this->db->where('docno',$docno);
        $this->db->update('sc_his.bbmkendaraan_mst',$updet);*/
       // return $this->fiky_report->render($datajson,$datamrt,$title,$session);
    }


}
