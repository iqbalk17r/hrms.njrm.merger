<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/25/19 8:56 AM
 *  * Last Modified: 4/23/19 3:52 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Pinjaman extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_pinjaman'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
        /*
         * usage information
         * $enc_xx=$this->fiky_encryption->enkrip($VAR);
         * $dec_xx=$this->fiky_encryption->deckrip($VAR));
         */

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

    public function  index(){
        $data['title']='HALO INI MENU MASTER PENGGAJIAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.J'; $versirelease='I.P.J/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $this->template->display('pinjaman/pinjaman/v_index',$data);
    }

    function mpinjaman(){
        $data['title']='MASTER PINJAMAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.J.1'; $versirelease='I.P.J.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $data['listkaryawan']= $this->m_akses->list_karyawan_param($param = null)->result();
        /* END CODE UNTUK VERSI */
        $this->template->display('pinjaman/pinjaman/v_list_pinjaman',$data);
    }

    function list_mpinjaman()
    {
        $list = $this->m_pinjaman->get_t_pinjaman();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $no++;
            $row = array();
            $id = $this->fiky_encryption->enkript($lm->docno);
            $row[] = $no;
            $row[] = $lm->docno;
            $row[] = $lm->nik;
            $row[] = $lm->nmlengkap;
            $row[] = $lm->description;
            $row[] = date('d-m-Y',strtotime($lm->tgl));
            $row[] = '<div align="right">'.number_format($lm->nominal, 2,',','.').'</div>';
            $row[] = '<div align="right">'.number_format($lm->sisa, 2,',','.').'</div>';
            $row[] = '<div align="right">'.number_format($lm->tenor, 2,',','.').'</div>';
            $row[] = '<div align="right">'.number_format($lm->npotong, 2,',','.').'</div>';
            $row[] = '<div align="right">'.$lm->nmstatus.'</div>';
            //add html for action

            if (trim($lm->status)==='I'){
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="ubah_pinjaman('."'".trim($id)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Persetujuan" onclick="persetujuan_pinjaman('."'".trim($id)."'".')"><i class="fa fa-check"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Batalkan" onclick="hapus_pinjaman('."'".trim($id)."'".')"><i class="fa fa-close"></i> </a>';
            } else {
                $row[] = 'NULL PROGRESS';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pinjaman->t_pinjaman_count_all(),
            "recordsFiltered" => $this->m_pinjaman->t_pinjaman_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function save_pinjaman()
    {
        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $docno = strtoupper($this->input->post('docno'));
        $description = strtoupper($this->input->post('description'));
        $tgl = strtoupper($this->input->post('tgl'));
        $nik = strtoupper($this->input->post('nik'));
        $nominal = str_replace('.','',$this->input->post('nominal') );
        $tenor = str_replace('.','',$this->input->post('tenor') );
        $npotong = str_replace('.','',$this->input->post('npotong') );
        $sisa = str_replace('.','',$this->input->post('sisa') );
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);

        if($type=='INPUT'){
            $data = array(
                'branch' => $branch,
                'docno' => $nama,
                'nik' => $nik,
                'description' => $description,
                'tgl' => $tgl.' '.date('H:i:s'),
                'nominal' => $nominal,
                'tenor' => $tenor,
                'npotong' => $npotong,
                //'sisa' => $sisa,
                'status' => "I",
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $insert = $this->m_pinjaman->simpan_t_pinjaman($data);
            echo json_encode(array("status" => TRUE));
        } else if ($type=='EDIT') {
            $data = array(

                'description' => $description,
                'nominal' => $nominal,
                'tenor' => $tenor,
                'npotong' => $npotong,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_pinjaman->ubah_t_pinjaman(array('docno' => $docno), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            $data = array(

                'status' => 'C',
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_pinjaman->ubah_t_pinjaman(array('docno' => $docno), $data);
            echo json_encode(array("status" => TRUE));
        }  else if($type=='APPROVE'){
            $data = array(

                'status' => 'F',
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_pinjaman->ubah_t_pinjaman(array('docno' => $docno), $data);
            echo json_encode(array("status" => TRUE));
        }


    }

    function show_edit_pinjaman($id)
    {
        $enc_id=$this->uri->segment(4);
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data = $this->m_pinjaman->get_t_pinjaman_by_id($id);
        echo json_encode($data);
    }
    function show_del_pinjaman($id)
    {
        $enc_id=$this->uri->segment(4);
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data = $this->m_pinjaman->get_t_pinjaman_by_id($id);
        echo json_encode($data);
    }

    function hitung_pinjaman(){
        $nama = $this->session->userdata('nik');
        $request_body= file_get_contents('php://input');
        $data = json_decode($request_body);
        if ($data->key=='KEY'){
            $databalik = $data->key;
            $this->m_pinjaman->q_hitung_pinjaman($nama,$nama);
            echo json_encode(array("enkript" => $databalik));
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        }
    }

    function inqpinjaman(){
        $data['title']='INQUIRY PINJAMAN KARYAWAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.J.2'; $versirelease='I.P.J.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $data['listkaryawan']= $this->m_akses->list_karyawan_param($param = null)->result();
        /* END CODE UNTUK VERSI */
        $this->template->display('pinjaman/pinjaman/v_list_karyawan_pinjaman',$data);
    }

    function list_karyawan_pinjam()
    {
        $list = $this->m_pinjaman->get_t_mstkaryawan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $no++;
            $row = array();
            $id = $this->fiky_encryption->enkript($lm->nik);
            $row[] = $no;
            $row[] = $lm->nik;
            $row[] = $lm->nmlengkap;
            $row[] = $lm->nmjabatan;
            //$row[] = date('d-m-Y',strtotime($lm->tgl));
            $row[] = '<div align="right">'.number_format($lm->pinjaman, 2,',','.').'</div>';
            //add html for action
            $row[] = '<a class="btn btn-sm btn-default" href="'.site_url('pinjaman/pinjaman/sub_dtl_pinjaman').'/'.trim($id).'" title="Detail"><i class="fa fa-bars"></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pinjaman->t_mstkaryawan_count_all(),
            "recordsFiltered" => $this->m_pinjaman->t_mstkaryawan_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function sub_dtl_pinjaman($enc_id){
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data['title']='DETAIL PINJAMAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.J.2'; $versirelease='I.P.J.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $data['listkaryawan']= $this->m_akses->list_karyawan_param($param = null)->result();
        /* END CODE UNTUK VERSI */
        $data['nik']=$id;
        $this->template->display('pinjaman/pinjaman/v_list_sub_karyawan_pinjaman',$data);
    }

    function list_sub_karyawan_pinjam($nik)
    {
        $list = $this->m_pinjaman->get_t_detail_pinjaman($nik);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $no++;
            $row = array();
            $nik = $this->fiky_encryption->enkript($lm->nik);
            $docno = $this->fiky_encryption->enkript($lm->docno);
            $row[] = $no;
            $row[] = $lm->docno;
            $row[] = $lm->nik;
            $row[] = $lm->nmlengkap;
            $row[] = $lm->description;
            $row[] = date('d-m-Y',strtotime($lm->tgl));
            $row[] = '<div align="right">'.number_format($lm->nominal, 2,',','.').'</div>';
            $row[] = '<div align="right">'.$lm->sisa.'</div>';
            $row[] = '<div align="right">'.number_format($lm->tenor, 2,',','.').'</div>';
            $row[] = '<div align="right">'.number_format($lm->npotong, 2,',','.').'</div>';
            $row[] = '<div align="right">'.$lm->nmstatus.'</div>';
            //add html for action
            $row[] = '<a class="btn btn-sm btn-default" href="'.site_url('pinjaman/pinjaman/dtl_inq_pinjaman').'/'.trim($docno).'/'.trim($nik).'" title="Detail"><i class="fa fa-bars"></i> </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pinjaman->t_detail_pinjaman_count_all($nik),
            "recordsFiltered" => $this->m_pinjaman->t_detail_pinjaman_count_filtered($nik),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function dtl_inq_pinjaman($enc_id,$enc_nik){

        $data['title']='DETAIL INQUIRY PINJAMAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.J.2'; $versirelease='I.P.J.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $docno=$this->fiky_encryption->dekript(trim($enc_id));
        $nik=$this->fiky_encryption->dekript(trim($enc_nik));
        $data['nik']=$nik;
        $data['docno']=$docno;
        $data['list_inq']= $this->m_pinjaman->t_inquiry($docno,$nik)->result();
        $this->template->display('pinjaman/pinjaman/v_inq_pinjaman',$data);
    }

    function ajax_enkrip(){
        $request_body= file_get_contents('php://input');
        $data = json_decode($request_body);
        $databalik = $this->fiky_encryption->enkript($data->data);
        echo json_encode(array("enkript" => $databalik));
    }

    function ajax_dekrip(){
        $request_body= file_get_contents('php://input');
        $data = json_decode($request_body);
        $databalik = $this->fiky_encryption->dekript($data->data);
        echo json_encode(array("dekript" => $databalik));
    }

    function test(){
        $x=$this->fiky_encryption->enkript('halo');
        $y=$this->fiky_encryption->dekript($x);
        echo $x.'</br>';
        echo $y.'</br>';
    }
}