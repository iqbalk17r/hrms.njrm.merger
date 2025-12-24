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
        $this->load->model(array('legal/m_legality','api/m_globalmodule'));
        $this->load->library(array('fiky_encryption', 'template','upload'));
        if (!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index()
    {
        echo json_encode(ARRAY('cok' => 'ASUW','cik'=>'Jembut')) ;
    }

    function listDatatable(){

        $list = $this->m_legality->get_list_legality();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lx) {
            $enc_docno=trim($this->fiky_encryption->enkript(trim($lx->docno)));
            $no++;
            $row = array();
            $row[] = $no;
            if (trim($lx->status)==='A') {
            $row[] = '
            <a class="btn btn-sm btn-primary" href="'.site_url('legal/legality/edit_legal').'/'.$enc_docno.'" title="Ubah Data Legal"><i class="fa fa-gear"></i> </a>
            <a class="btn btn-sm btn-default" href="'.site_url('legal/legality/detail_legal').'/'.$enc_docno.'" title="Detail Legal"><i class="fa fa-bars"></i> </a>
			';
            } else {
            /*$row[] = '
            <a class="btn btn-sm btn-primary" href="'.site_url('legal/legality/edit_form_legal').'?docno='.trim($lx->docno).'" title="Ubah Data Legal"><i class="fa fa-gear"></i> </a>
            <a class="btn btn-sm btn-default" href="'.site_url('legal/legality/detail_legal').'/'.$enc_docno.'" title="Detail Legal"><i class="fa fa-bars"></i> </a>
			';
            } else {*/
            $row[] = '
            <a class="btn btn-sm btn-default" href="'.site_url('legal/legality/detail_legal').'/'.$enc_docno.'" title="Detail Legal"><i class="fa fa-bars"></i> </a>
			';
            }

            $row[] = $lx->docref;
            $row[] = $lx->docno;
            $row[] = $lx->nmtype;
            $row[] = $lx->coperatorname;
            $row[] = $lx->nmbu;
            $row[] = date('d-m-Y H:m:s',strtotime($lx->docdate));
            $row[] = $lx->nmstatus;
            $row[] = $lx->nmdocname;
            $row[] = $lx->progress;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_legality->t_legal_master_count_all(),
            "recordsFiltered" => $this->m_legality->t_legal_master_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');

    }

    function read_tmp_master_legality()
    {
        $nama = trim($this->session->userdata('nik'));
        $docno = $this->input->get('docno');

        $check = $this->m_legality->read_tmp_t_legal_param($param = " and docno='$nama'")->num_rows();
        if ($check == 0){
            $this->m_legality->insert_to_tmp_legal_master($nama,$docno);
        }

        //$id=$this->fiky_encryption->dekript(trim($nama));
        $data = $this->m_legality->read_tmp_t_legal_param($param = " and coalesce(docno,'') = '$nama'")->row();


        echo json_encode( array('dataread' => $data ,'success' => true ) , JSON_PRETTY_PRINT);
    }

    function rolled_back(){
        $data = 'kontol';
        echo json_encode( array('data' => $data ,'success' => true ) , JSON_PRETTY_PRINT);
    }

    function save_initialize_master(){
        $this->db->cache_delete('api','globalmodule');
        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');

        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $docno = $this->input->post('docno');
        $docname = $this->input->post('docname');
        $doctype = $this->input->post('doctype');
        $coperator = trim($this->input->post('coperator'));
        $coperatornamepost = strtoupper(trim($this->input->post('coperatorname')));
        $idbu = $this->input->post('idbu');
        $docref = strtoupper($this->input->post('docref'));
        $docrefname = strtoupper($this->input->post('docrefname'));
        $description = strtoupper($this->input->post('description'));
        $progress = $this->input->post('progress');
        $status = $this->input->post('status');
        $dtl = $this->m_globalmodule->q_customer(" AND custcode='$coperator'")->row_array();
        $coperatorname = trim($dtl['custname']);

        $check = $this->m_legality->read_tmp_t_legal_param($param = " and docno='$nama'")->num_rows();
        if ($check > 0){

            if (trim($doctype)==='PA'){
                //$dtl = $this->m_globalmodule->q_lv_m_karyawan()->row_array();
                $dtl = $this->m_globalmodule->q_customer(" AND custcode='$coperator'")->row_array();
                if ($coperator==='OTHER'){
                    $coperatorname =$coperatornamepost;
                } else {
                    $coperatorname = trim($dtl['custname']);
                }
            } else {
                $dtl = $this->m_globalmodule->q_customer(" AND custcode='$coperator'")->row_array();
                if ($coperator==='OTHER'){
                    $coperatorname =$coperatornamepost;
                } else {
                    $coperatorname = trim($dtl['custname']);
                }
            }

            $info = array(
                //'docname' => $docref,
                'doctype' => $doctype,
                'coperator' => $coperator,
                'coperatorname' => $coperatorname,
                'idbu' => $idbu,
                'docref' => $docref,
                'docrefname' => $docrefname,
                'description' => $description,
            );
            $this->db->where('docno',$nama);
           if(! $this->db->update('sc_tmp.legal_master',$info)) {
               $data = $this->m_legality->read_tmp_t_legal_param($param = " and coalesce(docno,'') = '$nama'")->row();
               echo json_encode( array('dataread' => $data ,'success' => false ,
                   'testpost' => array(
                       'cek' => $check,
                       'nama' => $nama,
                       'type' => $type,
                       'docno' => $docno,
                       'docref' => $docref,
                       'docrefname' => $docrefname,
                       'coperator' => $coperator,
                       'coperatorname' => $coperatorname,
                       'description' => $description,
                   ),
               ) , JSON_PRETTY_PRINT);
           } else {
               //$id=$this->fiky_encryption->dekript(trim($nama));

               $data = $this->m_legality->read_tmp_t_legal_param($param = " and coalesce(docno,'') = '$nama'")->row();
               echo json_encode( array('dataread' => $data ,'success' => true ,
                   'testpost' => array(
                       'cek' => $check,
                       'nama' => $nama,
                       'type' => $type,
                       'docno' => $docno,
                       'docref' => $docref,
                       'docrefname' => $docrefname,
                       'coperator' => $coperator,
                       'coperatorname' => $coperatorname,
                       'description' => $description,
                   ),
               ) , JSON_PRETTY_PRINT);



           }
        }

        $this->db->cache_delete('api','globalmodule');
        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');
    }


    function save_initialize_detail()
    {
        $type = trim($this->input->post('type'));
        $docno = trim($this->input->post('docno'));
        $sort = trim($this->input->post('sort'));
        $docref = $this->input->post('docref');
        $dateoperation = $this->input->post('dateoperation');
        $operationcategory = $this->input->post('operationcategory');
        $progress = strtoupper($this->input->post('progress'));

        $path = "./assets/archive/documenlegal/";
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
       /* $files = glob('/archive/documenlegal/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }*/

        if ($type==='INPUT') {
            $config['upload_path'] = $path;
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $config['max_size'] = 25 * 1000; //10:mb
            $this->upload->initialize($config);

            $upload_data = $this->upload->do_upload('attachment');
//            if (!$upload_data) {
//                $show = $this->upload->display_errors();
//            } else {
                $dtlmst = $this->m_legality->read_tmp_t_legal_param($param = " and coalesce(docno,'') = '$docno'")->row_array();
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
                    'inputdate' => date('Y-m-d H:i:s'),
                    'inputby' => trim($this->session->userdata('nik')),
                );

                if ($this->db->insert('sc_tmp.legal_detail', $infox)) {
                    $show = $file_name . ' SUKSES TERUPLOAD';
                    $arr = array('status' => true, 'show' => $show);
                    echo json_encode($arr, JSON_PRETTY_PRINT);
//                } else {
//                    $show = $file_name . ' GAGAL UPLOAD';
//                    $arr = array('status' => false, 'show' => $show);
//                    echo json_encode($arr, JSON_PRETTY_PRINT);
//                }
            }
        } else if ($type==='FINAL') {
            $infofinal = array(
                'status' => 'F',
                'updatedate' => date('Y-m-d H:i:s'),
                'updateby' => trim($this->session->userdata('nik')),
            );
            $this->db->where('docno',$docno);
            $this->db->where('sort',$sort);
            if ($this->db->update('sc_tmp.legal_detail', $infofinal)) {
                $show = ' SUKSES TERUBAH';
                $arr = array('status' => true, 'show' => $show);
                echo json_encode($arr, JSON_PRETTY_PRINT);
            } else {
                $show = ' GAGAL TERUBAH';
                $arr = array('status' => false, 'show' => $show);
                echo json_encode($arr, JSON_PRETTY_PRINT);
            }
        } else if ($type==='DELETE') {

            $this->db->where('docno',$docno);
            $this->db->where('sort',$sort);
            if ($this->db->delete('sc_tmp.legal_detail')) {
                $show = ' SUKSES TERHAPUS';
                $arr = array('status' => true, 'show' => $show);
                echo json_encode($arr, JSON_PRETTY_PRINT);
            } else {
                $show = ' GAGAL TERHAPUS';
                $arr = array('status' => false, 'show' => $show);
                echo json_encode($arr, JSON_PRETTY_PRINT);
            }
        } else {
            $show = 'TIDAK ADA DATA TERPROSES';
            $arr = array('status' => false, 'show' => $show);
            echo json_encode($arr, JSON_PRETTY_PRINT);
        }

            // $this->session->set_flashdata('msg','Upload & Extract successfully.');

        $this->db->cache_delete('api','globalmodule');
        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');
    }



    function loadTmpLegalDetail(){
        $docno = $this->input->get('docno');
        $list = $this->m_legality->get_list_tmp_legal_detail($docno);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lx) {
            $enc_docno=trim($this->fiky_encryption->enkript(trim($lx->docno)));
            $typeFinal ='FINAL';
            $typeDelete ='DELETE';
            $typeDetail ='DETAIL';
            $no++;
            $row = array();
            $row[] = $no;
            if ($lx->status!=='F') {
                $row[] = '
                <a class="btn btn-sm btn-success" onclick="detailLegalApprove('."'". trim($lx->docno)."','". trim($lx->sort) ."','". $typeFinal ."'".')" title="Detail Legal"><i class="fa fa-bars"></i> </a>
                <a class="btn btn-sm btn-danger" onclick="detailLegalApprove('."'". trim($lx->docno)."','". trim($lx->sort) ."','". $typeDelete ."'".')" title="Delete Legal"><i class="fa fa-trash"></i> </a>
                ';
            } else {
                $row[] = '
                <a class="btn btn-sm btn-default" onclick="detailLegalApprove('."'". trim($lx->docno)."','". trim($lx->sort) ."','". $typeDetail ."'".')" title="Detail Legal"><i class="fa fa-bars"></i> </a>
                ';
            }

            $row[] = $lx->docref;
            $row[] = date('d-m-Y H:i:s',strtotime($lx->docdate));
            $row[] = date('d-m-Y H:i:s',strtotime($lx->dateoperation));
            $row[] = $lx->nmoperationcategory;
            $row[] = $lx->nmstatus;
            $row[] = '
            <a class="btn btn-sm btn-success" target="_blank" href="'.site_url('assets/archive/documenlegal').'/'.$lx->attachment.'" title="Download"><i class="fa fa-download"></i>
             </a>';
            $row[] = $lx->progress;
            ;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_legality->t_legal_detail_count_all(),
            "recordsFiltered" => $this->m_legality->t_legal_detail_count_filtered(),
            "data" => $data,
            "options" => array('option' => 1),
            "files" => array('files' => 1),
            "searchPanes" => array('options' => 1),
        );
        echo $this->fiky_encryption->jDatatable($output);
        //$this->db->cache_delete('api','legality');
        //$this->db->cache_delete('legal','legality');
    }

    function check_tmp_legal_detail(){
        $docno = trim($this->input->get('docno'));
        $id = trim($this->input->get('id'));
        $data = $this->m_legality->get_t_legal_detail_by_id($docno,$id);
        echo json_encode(array('status' => true,'data' => $data));
    }

    function clearTmpLegal(){
        $dtl = $this->m_legality->read_tmp_t_legal_param()->row_array();
        if(!empty($dtl['docnotmp'])) {
            $infoxz = array(
                'status' => 'A'
            );
            $this->db->where('docno',trim($dtl['docnotmp']));
            $this->db->update('sc_his.legal_master',$infoxz);

        }

        $nama = trim($this->session->userdata('nik'));
        $this->db->where('docno',$nama);
        $this->db->delete('sc_tmp.legal_master');

        $this->db->where('docno',$nama);
        $this->db->delete('sc_tmp.legal_detail');

        echo json_encode(array (
            'status' => true,
            'messages' => 'Data sukses di kembalikan',
        ), JSON_PRETTY_PRINT);
        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');
    }
    function finalisasi_entry(){
        $nama = trim($this->session->userdata('nik'));
        $info = array(
            'status' => 'F'
        );
        $this->db->where('docno',$nama);
        if ($this->db->update('sc_tmp.legal_master',$info)) {
            echo json_encode(array (
                'status' => true,
                'messages' => 'Data Sukses Di Proses',
            ), JSON_PRETTY_PRINT);
        } else {
            echo json_encode(array (
                'status' => false,
                'messages' => 'Ada kesalahan data',
            ), JSON_PRETTY_PRINT);
        }

        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');
    }

    function reportlistDatatable(){

        $list = $this->m_legality->get_list_t_report_legal_detail();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lx) {
            $enc_docno=trim($this->fiky_encryption->enkript(trim($lx->docno)));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $lx->docno;
            $row[] = $lx->nmbu;
            $row[] = $lx->coperatorname;
            $row[] = (empty($lx->negosiasi_date)) ? '' : date('d-m-Y',strtotime($lx->negosiasi_date));
            $row[] = (empty($lx->klarifikasi_date)) ? '' : date('d-m-Y',strtotime($lx->klarifikasi_date));
            $row[] = (empty($lx->sp1_date)) ? '' : date('d-m-Y',strtotime($lx->sp1_date));
            $row[] = (empty($lx->sp2_date)) ? '' : date('d-m-Y',strtotime($lx->sp2_date));
            $row[] = (empty($lx->sp3_date)) ? '' : date('d-m-Y',strtotime($lx->sp3_date));
            $row[] = (empty($lx->somasi_date)) ? '' : date('d-m-Y',strtotime($lx->somasi_date));
            $row[] = $lx->attachment;
            $row[] = $lx->progress;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_legality->t_report_legal_detail_count_all(),
            "recordsFiltered" => $this->m_legality->t_report_legal_detail_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
        $this->db->cache_delete('api','legality');
        $this->db->cache_delete('legal','legality');

    }

    function reportJson() {
        $enc_docno =$this->input->get('enc_docno');
        $docno=$this->fiky_encryption->dekript($enc_docno);

        $datamst = $this->m_legality->q_his_legal_master($param = " and docno = '$docno'" )->result();
        $datadtl = $this->m_legality->q_his_legal_detail($param = " and docno = '$docno'" )->result();

        header("Content-Type: text/json");
        echo json_encode(
            array(
                'docno' => $docno,
                'master' => $datamst,
                'detail' => $datadtl,
            ), JSON_PRETTY_PRINT);
    }


    function ajaxtest(){
       echo  '{
  "data": [
    {
      "DT_RowId": "row_1",
      "first_name": "Tiger",
      "last_name": "Nixon",
      "position": "System Architect",
      "email": "t.nixon@datatables.net",
      "office": "Edinburgh",
      "extn": 5421,
      "age": 61,
      "salary": 320800,
      "start_date": "2011-04-25"
    },
    {
      "DT_RowId": "row_2",
      "first_name": "Garrett",
      "last_name": "Winters",
      "position": "Accountant",
      "email": "g.winters@datatables.net",
      "office": "Tokyo",
      "extn": 8422,
      "age": 63,
      "salary": 170750,
      "start_date": "2011-07-25"
    },
    {
      "DT_RowId": "row_3",
      "first_name": "cok",
      "last_name": "Cox",
      "position": "Junior Technical Author",
      "email": "a.cox@datatables.net",
      "office": "San Francisco",
      "extn": 1562,
      "age": 66,
      "salary": 86000,
      "start_date": "2009-01-21"
    },
    {
      "DT_RowId": "row_4",
      "first_name": "Cedric",
      "last_name": "Kelly",
      "position": "Senior Javascript Developer",
      "email": "c.kelly@datatables.net",
      "office": "Edinburgh",
      "extn": 6224,
      "age": 22,
      "salary": 433060,
      "start_date": "2012-03-29"
    },
    {
      "DT_RowId": "row_5",
      "first_name": "sf",
      "last_name": "sd",
      "position": "sf",
      "email": "a.satou@datatables.net",
      "office": "sdf",
      "extn": "sf",
      "age": 33,
      "salary": 162700,
      "start_date": "2020-10-30"
    },
    {
      "DT_RowId": "row_6",
      "first_name": "Brielle",
      "last_name": "Williamson",
      "position": "Integration Specialist",
      "email": "b.williamson@datatables.net",
      "office": "New York",
      "extn": 4804,
      "age": 61,
      "salary": 372000,
      "start_date": "2012-12-02"
    },
    {
      "DT_RowId": "row_7",
      "first_name": "Herrod",
      "last_name": "Chandler",
      "position": "Sales Assistant",
      "email": "h.chandler@datatables.net",
      "office": "San Francisco",
      "extn": 9608,
      "age": 59,
      "salary": 137500,
      "start_date": "2012-08-06"
    },
    {
      "DT_RowId": "row_8",
      "first_name": "Rhona",
      "last_name": "Davidson",
      "position": "Integration Specialist",
      "email": "r.davidson@datatables.net",
      "office": "Tokyo",
      "extn": 6200,
      "age": 55,
      "salary": 327900,
      "start_date": "2010-10-14"
    },
    {
      "DT_RowId": "row_9",
      "first_name": "Colleen",
      "last_name": "Hurst",
      "position": "Javascript Developer",
      "email": "c.hurst@datatables.net",
      "office": "San Francisco",
      "extn": 2360,
      "age": 39,
      "salary": 205500,
      "start_date": "2009-09-15"
    },
    {
      "DT_RowId": "row_10",
      "first_name": "Sonya",
      "last_name": "Frost",
      "position": "Software Engineer",
      "email": "s.frost@datatables.net",
      "office": "Edinburgh",
      "extn": 1667,
      "age": 23,
      "salary": 103600,
      "start_date": "2008-12-13"
    },
    {
      "DT_RowId": "row_11",
      "first_name": "Jena",
      "last_name": "Gaines",
      "position": "Office Manager",
      "email": "j.gaines@datatables.net",
      "office": "London",
      "extn": 3814,
      "age": 30,
      "salary": 90560,
      "start_date": "2008-12-19"
    },
    {
      "DT_RowId": "row_12",
      "first_name": "Quinn",
      "last_name": "Flynn",
      "position": "Support Lead",
      "email": "q.flynn@datatables.net",
      "office": "Edinburgh",
      "extn": 9497,
      "age": 22,
      "salary": 342000,
      "start_date": "2013-03-03"
    },
    {
      "DT_RowId": "row_13",
      "first_name": "Charde",
      "last_name": "Marshall",
      "position": "Regional Director",
      "email": "c.marshall@datatables.net",
      "office": "San Francisco",
      "extn": 6741,
      "age": 36,
      "salary": 470600,
      "start_date": "2008-10-16"
    },
    {
      "DT_RowId": "row_14",
      "first_name": "Haley",
      "last_name": "Kennedy",
      "position": "Senior Marketing Designer",
      "email": "h.kennedy@datatables.net",
      "office": "London",
      "extn": 3597,
      "age": 43,
      "salary": 313500,
      "start_date": "2012-12-18"
    },
    {
      "DT_RowId": "row_15",
      "first_name": "Tatyana",
      "last_name": "Fitzpatrick",
      "position": "Regional Director",
      "email": "t.fitzpatrick@datatables.net",
      "office": "London",
      "extn": 1965,
      "age": 19,
      "salary": 385750,
      "start_date": "2010-03-17"
    },
    {
      "DT_RowId": "row_16",
      "first_name": "Michael",
      "last_name": "Silva",
      "position": "Marketing Designer",
      "email": "m.silva@datatables.net",
      "office": "London",
      "extn": 1581,
      "age": 66,
      "salary": 198500,
      "start_date": "2012-11-27"
    },
    {
      "DT_RowId": "row_17",
      "first_name": "Paul",
      "last_name": "Byrd",
      "position": "Chief Financial Officer (CFO)",
      "email": "p.byrd@datatables.net",
      "office": "New York",
      "extn": 3059,
      "age": 64,
      "salary": 725000,
      "start_date": "2010-06-09"
    },
    {
      "DT_RowId": "row_18",
      "first_name": "Gloria",
      "last_name": "Little",
      "position": "Systems Administrator",
      "email": "g.little@datatables.net",
      "office": "New York",
      "extn": 1721,
      "age": 59,
      "salary": 237500,
      "start_date": "2009-04-10"
    },
    {
      "DT_RowId": "row_19",
      "first_name": "cok",
      "last_name": "Greer",
      "position": "Software Engineer",
      "email": "b.greer@datatables.net",
      "office": "London",
      "extn": 2558,
      "age": 41,
      "salary": 132000,
      "start_date": "2012-10-13"
    },
    {
      "DT_RowId": "row_20",
      "first_name": "Dai",
      "last_name": "Rios",
      "position": "Personnel Lead",
      "email": "d.rios@datatables.net",
      "office": "Edinburgh",
      "extn": 2290,
      "age": 35,
      "salary": 217500,
      "start_date": "2012-09-26"
    },
    {
      "DT_RowId": "row_21",
      "first_name": "Jenette",
      "last_name": "Caldwell",
      "position": "Development Lead",
      "email": "j.caldwell@datatables.net",
      "office": "New York",
      "extn": 1937,
      "age": 30,
      "salary": 345000,
      "start_date": "2011-09-03"
    },
    {
      "DT_RowId": "row_22",
      "first_name": "Yuri",
      "last_name": "Berry",
      "position": "Chief Marketing Officer (CMO)",
      "email": "y.berry@datatables.net",
      "office": "New York",
      "extn": 6154,
      "age": 40,
      "salary": 675000,
      "start_date": "2009-06-25"
    },
    {
      "DT_RowId": "row_23",
      "first_name": "Caesar",
      "last_name": "Vance",
      "position": "Pre-Sales Support",
      "email": "c.vance@datatables.net",
      "office": "New York",
      "extn": 8330,
      "age": 21,
      "salary": 106450,
      "start_date": "2011-12-12"
    },
    {
      "DT_RowId": "row_24",
      "first_name": "Doris",
      "last_name": "Wilder",
      "position": "Sales Assistant",
      "email": "d.wilder@datatables.net",
      "office": "Sydney",
      "extn": 3023,
      "age": 23,
      "salary": 85600,
      "start_date": "2010-09-20"
    },
    {
      "DT_RowId": "row_25",
      "first_name": "sf",
      "last_name": "sd",
      "position": "sf",
      "email": "a.ramos@datatables.net",
      "office": "sdf",
      "extn": "sf",
      "age": 47,
      "salary": 1200000,
      "start_date": "2020-10-30"
    },
    {
      "DT_RowId": "row_26",
      "first_name": "Gavin",
      "last_name": "Joyce",
      "position": "Developer",
      "email": "g.joyce@datatables.net",
      "office": "Edinburgh",
      "extn": 8822,
      "age": 42,
      "salary": 92575,
      "start_date": "2010-12-22"
    },
    {
      "DT_RowId": "row_27",
      "first_name": "Jennifer",
      "last_name": "Chang",
      "position": "Regional Director",
      "email": "j.chang@datatables.net",
      "office": "Singapore",
      "extn": 9239,
      "age": 28,
      "salary": 357650,
      "start_date": "2010-11-14"
    },
    {
      "DT_RowId": "row_28",
      "first_name": "Brenden",
      "last_name": "Wagner",
      "position": "Software Engineer",
      "email": "b.wagner@datatables.net",
      "office": "San Francisco",
      "extn": 1314,
      "age": 28,
      "salary": 206850,
      "start_date": "2011-06-07"
    },
    {
      "DT_RowId": "row_29",
      "first_name": "Fiona",
      "last_name": "Green",
      "position": "Chief Operating Officer (COO)",
      "email": "f.green@datatables.net",
      "office": "San Francisco",
      "extn": 2947,
      "age": 48,
      "salary": 850000,
      "start_date": "2010-03-11"
    },
    {
      "DT_RowId": "row_30",
      "first_name": "Shou",
      "last_name": "Itou",
      "position": "Regional Marketing",
      "email": "s.itou@datatables.net",
      "office": "Tokyo",
      "extn": 8899,
      "age": 20,
      "salary": 163000,
      "start_date": "2011-08-14"
    },
    {
      "DT_RowId": "row_31",
      "first_name": "Michelle",
      "last_name": "House",
      "position": "Integration Specialist",
      "email": "m.house@datatables.net",
      "office": "Sydney",
      "extn": 2769,
      "age": 37,
      "salary": 95400,
      "start_date": "2011-06-02"
    },
    {
      "DT_RowId": "row_32",
      "first_name": "Suki",
      "last_name": "Burks",
      "position": "Developer",
      "email": "s.burks@datatables.net",
      "office": "London",
      "extn": 6832,
      "age": 53,
      "salary": 114500,
      "start_date": "2009-10-22"
    },
    {
      "DT_RowId": "row_33",
      "first_name": "Prescott",
      "last_name": "Bartlett",
      "position": "Technical Author",
      "email": "p.bartlett@datatables.net",
      "office": "London",
      "extn": 3606,
      "age": 27,
      "salary": 145000,
      "start_date": "2011-05-07"
    },
    {
      "DT_RowId": "row_34",
      "first_name": "Gavin",
      "last_name": "Cortez",
      "position": "Team Leader",
      "email": "g.cortez@datatables.net",
      "office": "San Francisco",
      "extn": 2860,
      "age": 22,
      "salary": 235500,
      "start_date": "2008-10-26"
    },
    {
      "DT_RowId": "row_35",
      "first_name": "Martena",
      "last_name": "Mccray",
      "position": "Post-Sales support",
      "email": "m.mccray@datatables.net",
      "office": "Edinburgh",
      "extn": 8240,
      "age": 46,
      "salary": 324050,
      "start_date": "2011-03-09"
    },
    {
      "DT_RowId": "row_36",
      "first_name": "Unity",
      "last_name": "Butler",
      "position": "Marketing Designer",
      "email": "u.butler@datatables.net",
      "office": "San Francisco",
      "extn": 5384,
      "age": 47,
      "salary": 85675,
      "start_date": "2009-12-09"
    },
    {
      "DT_RowId": "row_37",
      "first_name": "Howard",
      "last_name": "Hatfield",
      "position": "Office Manager",
      "email": "h.hatfield@datatables.net",
      "office": "San Francisco",
      "extn": 7031,
      "age": 51,
      "salary": 164500,
      "start_date": "2008-12-16"
    },
    {
      "DT_RowId": "row_38",
      "first_name": "Hope",
      "last_name": "Fuentes",
      "position": "Secretary",
      "email": "h.fuentes@datatables.net",
      "office": "San Francisco",
      "extn": 6318,
      "age": 41,
      "salary": 109850,
      "start_date": "2010-02-12"
    },
    {
      "DT_RowId": "row_39",
      "first_name": "Vivian",
      "last_name": "Harrell",
      "position": "Financial Controller",
      "email": "v.harrell@datatables.net",
      "office": "San Francisco",
      "extn": 9422,
      "age": 62,
      "salary": 452500,
      "start_date": "2009-02-14"
    },
    {
      "DT_RowId": "row_40",
      "first_name": "Timothy",
      "last_name": "Mooney",
      "position": "Office Manager",
      "email": "t.mooney@datatables.net",
      "office": "London",
      "extn": 7580,
      "age": 37,
      "salary": 136200,
      "start_date": "2008-12-11"
    },
    {
      "DT_RowId": "row_41",
      "first_name": "Jackson",
      "last_name": "Bradshaw",
      "position": "Director",
      "email": "j.bradshaw@datatables.net",
      "office": "New York",
      "extn": 1042,
      "age": 65,
      "salary": 645750,
      "start_date": "2008-09-26"
    },
    {
      "DT_RowId": "row_42",
      "first_name": "Olivia",
      "last_name": "Liang",
      "position": "Support Engineer",
      "email": "o.liang@datatables.net",
      "office": "Singapore",
      "extn": 2120,
      "age": 64,
      "salary": 234500,
      "start_date": "2011-02-03"
    },
    {
      "DT_RowId": "row_43",
      "first_name": "Bruno",
      "last_name": "Nash",
      "position": "Software Engineer",
      "email": "b.nash@datatables.net",
      "office": "London",
      "extn": 6222,
      "age": 38,
      "salary": 163500,
      "start_date": "2011-05-03"
    },
    {
      "DT_RowId": "row_44",
      "first_name": "Sakura",
      "last_name": "Yamamoto",
      "position": "Support Engineer",
      "email": "s.yamamoto@datatables.net",
      "office": "Tokyo",
      "extn": 9383,
      "age": 37,
      "salary": 139575,
      "start_date": "2009-08-19"
    },
    {
      "DT_RowId": "row_45",
      "first_name": "Thor",
      "last_name": "Walton",
      "position": "Developer",
      "email": "t.walton@datatables.net",
      "office": "New York",
      "extn": 8327,
      "age": 61,
      "salary": 98540,
      "start_date": "2013-08-11"
    },
    {
      "DT_RowId": "row_46",
      "first_name": "Finn",
      "last_name": "Camacho",
      "position": "Support Engineer",
      "email": "f.camacho@datatables.net",
      "office": "San Francisco",
      "extn": 2927,
      "age": 47,
      "salary": 87500,
      "start_date": "2009-07-07"
    },
    {
      "DT_RowId": "row_47",
      "first_name": "Serge",
      "last_name": "Baldwin",
      "position": "Data Coordinator",
      "email": "s.baldwin@datatables.net",
      "office": "Singapore",
      "extn": 8352,
      "age": 64,
      "salary": 138575,
      "start_date": "2012-04-09"
    },
    {
      "DT_RowId": "row_48",
      "first_name": "Zenaida",
      "last_name": "Frank",
      "position": "Software Engineer",
      "email": "z.frank@datatables.net",
      "office": "New York",
      "extn": 7439,
      "age": 63,
      "salary": 125250,
      "start_date": "2010-01-04"
    },
    {
      "DT_RowId": "row_49",
      "first_name": "Zorita",
      "last_name": "Serrano",
      "position": "Software Engineer",
      "email": "z.serrano@datatables.net",
      "office": "San Francisco",
      "extn": 4389,
      "age": 56,
      "salary": 115000,
      "start_date": "2012-06-01"
    },
    {
      "DT_RowId": "row_50",
      "first_name": "Jennifer",
      "last_name": "Acosta",
      "position": "Junior Javascript Developer",
      "email": "j.acosta@datatables.net",
      "office": "Edinburgh",
      "extn": 3431,
      "age": 43,
      "salary": 75650,
      "start_date": "2013-02-01"
    },
    {
      "DT_RowId": "row_51",
      "first_name": "Cara",
      "last_name": "Stevens",
      "position": "Sales Assistant",
      "email": "c.stevens@datatables.net",
      "office": "New York",
      "extn": 3990,
      "age": 46,
      "salary": 145600,
      "start_date": "2011-12-06"
    },
    {
      "DT_RowId": "row_52",
      "first_name": "Hermione",
      "last_name": "Butler",
      "position": "Regional Director",
      "email": "h.butler@datatables.net",
      "office": "London",
      "extn": 1016,
      "age": 47,
      "salary": 356250,
      "start_date": "2011-03-21"
    },
    {
      "DT_RowId": "row_53",
      "first_name": "Lael",
      "last_name": "Greer",
      "position": "Systems Administrator",
      "email": "l.greer@datatables.net",
      "office": "London",
      "extn": 6733,
      "age": 21,
      "salary": 103500,
      "start_date": "2009-02-27"
    },
    {
      "DT_RowId": "row_54",
      "first_name": "Jonas",
      "last_name": "Alexander",
      "position": "Developer",
      "email": "j.alexander@datatables.net",
      "office": "San Francisco",
      "extn": 8196,
      "age": 30,
      "salary": 86500,
      "start_date": "2010-07-14"
    },
    {
      "DT_RowId": "row_55",
      "first_name": "Shad",
      "last_name": "Decker",
      "position": "Regional Director",
      "email": "s.decker@datatables.net",
      "office": "Edinburgh",
      "extn": 6373,
      "age": 51,
      "salary": 183000,
      "start_date": "2008-11-13"
    },
    {
      "DT_RowId": "row_56",
      "first_name": "Michael",
      "last_name": "Bruce",
      "position": "Javascript Developer",
      "email": "m.bruce@datatables.net",
      "office": "Singapore",
      "extn": 5384,
      "age": 29,
      "salary": 183000,
      "start_date": "2011-06-27"
    },
    {
      "DT_RowId": "row_57",
      "first_name": "Donna",
      "last_name": "Snider",
      "position": "Customer Support",
      "email": "d.snider@datatables.net",
      "office": "New York",
      "extn": 4226,
      "age": 27,
      "salary": 112000,
      "start_date": "2011-01-25"
    }
  ],
  "options": [],
  "files": [],
  "searchPanes": {
    "options": []
  }
}';
    }
}
