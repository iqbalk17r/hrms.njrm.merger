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

class Master extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_master'));
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
        $kodemenu='I.P.I'; $versirelease='I.P.I/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_index',$data);
    }

    function maswil(){
        $data['title']='MASTER WILAYAH';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.I.1'; $versirelease='I.P.I.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_master_wilayah',$data);
    }

    function list_maswil()
    {
        $list = $this->m_master->get_t_wil();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $no++;
            $row_dtl = $this->m_master->q_master_wilayah_nominal(" and kdwilayah ='$lm->kdwilayah'")->num_rows();
            $row = array();
            $row[] = $no;
            $row[] = $lm->kdwilayah;
            $row[] = $lm->nmwilayah;
            $row[] = $lm->c_hold;
            if ($row_dtl > 0){
                //add html for action
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Wilayah" onclick="ubah_wilayah('."'".trim($lm->kdwilayah)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>';
            } else {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Wilayah" onclick="ubah_wilayah('."'".trim($lm->kdwilayah)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Wilayah" onclick="hapus_wilayah('."'".trim($lm->kdwilayah)."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
            }


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->t_will_count_all(),
            "recordsFiltered" => $this->m_master->t_will_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function save_wilayah()
    {
        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $kdwilayah = strtoupper($this->input->post('kdwilayah'));
        $nmwilayah = strtoupper($this->input->post('nmwilayah'));
        $c_hold = strtoupper($this->input->post('c_hold'));
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        if($type=='INPUT'){
            $data = array(
                'branch' => $branch,
                'kdwilayah' => $kdwilayah,
                'nmwilayah' => $nmwilayah,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $insert = $this->m_master->simpan_wilayah($data);
            echo json_encode(array("status" => TRUE));
        } else if ($type=='EDIT') {
            $data = array(
                'nmwilayah' => $nmwilayah,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_master->ubah_wilayah(array('kdwilayah' => $kdwilayah), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            $this->m_master->hapus_wilayah($kdwilayah);
            echo json_encode(array("status" => TRUE));
        }


    }

    function show_edit_wilayah($id)
    {
        $data = $this->m_master->get_t_will_by_id($id);
        echo json_encode($data);
    }
    function show_del_wilayah($id)
    {
        $data = $this->m_master->get_t_will_by_id($id);
        echo json_encode($data);
    }

    function maswil_salary(){
        $data['title']='MASTER WILAYAH DAN GAJI WILAYAH';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.I.2'; $versirelease='I.P.I.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $data['listwilayah']=$this->m_master->q_mst_wilayah($param=null)->result();
        $data['listgolongan']=$this->m_master->q_mst_jobgrade_golongan($param=null)->result();
        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_master_wilayah_salary',$data);
    }

    function list_maswil_salary()
    {
        $list = $this->m_master->get_t_wil_sal();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $no++;
            $row = array();
            ///echo " and kdwilayahnominal='$lm->kdwilayahnominal'";
            $row_check = $this->m_akses->list_karyawan_param(" and kdwilayahnominal='$lm->kdwilayahnominal'")->num_rows();
            $row[] = $no;
            $row[] = $lm->kdwilayahnominal;
            $row[] = $lm->nmwilayahnominal;
            //$row[] = $lm->golongan;
            $row[] = '<div align="right">'.number_format($lm->nominal, 2,',','.').'</div>';
            $row[] = $lm->c_hold;
            if ($row_check>0){
                //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Wilayah Nominal" onclick="ubah_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>';
            } else {
                //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Wilayah Nominal" onclick="ubah_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Wilayah Nominal" onclick="hapus_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->t_will_sal_count_all(),
            "recordsFiltered" => $this->m_master->t_will_sal_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }
    function save_wilayah_salary()
    {
        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $kdwilayah = strtoupper($this->input->post('kdwilayah'));
        $kdwilayahnominal = strtoupper($this->input->post('kdwilayahnominal'));
        $nmwilayahnominal = strtoupper($this->input->post('nmwilayahnominal'));
        //$golongan = strtoupper($this->input->post('golongan'));
        $nominal =  str_replace('.','',$this->input->post('nominal') );
        $c_hold = strtoupper($this->input->post('c_hold'));
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        if($type=='INPUT'){
            $data = array(
                'branch' => $branch,
                'kdwilayah' => $kdwilayah,
                'kdwilayahnominal' => $nama,
                'nmwilayahnominal' => $nmwilayahnominal,
                'nominal' => $nominal,
                ///'golongan' => $golongan,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $insert = $this->m_master->simpan_wilayah_sal($data);
            echo json_encode(array("status" => TRUE));
        } else if ($type=='EDIT') {
            $data = array(
                'nmwilayahnominal' => $nmwilayahnominal,
                'nominal' => $nominal,
                ///'golongan' => $golongan,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_master->ubah_wilayah_sal(array('kdwilayahnominal' => $kdwilayahnominal), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            $this->m_master->hapus_wilayah_sal($kdwilayahnominal);
            echo json_encode(array("status" => TRUE));
        }


    }
    function show_edit_wilayah_salary($id)
    {
        $data = $this->m_master->get_t_will_sal_by_id($id);
        echo json_encode($data);
    }
    function show_del_wilayah_salary($id)
    {
        $data = $this->m_master->get_t_will_sal_by_id($id);
        echo json_encode($data);
    }
    function masjab_salary(){
        $data['title']='MASTER GAJI JABATAN';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.I.3'; $versirelease='I.P.I.3/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $data['listwilayah']=$this->m_master->q_mst_wilayah($param=null)->result();
        $data['listgolongan']=$this->m_master->q_mst_jobgrade_golongan($param=null)->result();
        $data['listlvljabatan']=$this->m_master->q_mst_lvljabatan($param=null)->result();
        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_master_jabatan_salary',$data);
    }

    function list_masjab_salary()
    {
        $list = $this->m_master->get_t_masjab_sal();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $id=$this->fiky_encryption->enkript(trim($lm->kdjabatan));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = trim($lm->kdjabatan);
            $row[] = trim($lm->nmjabatan);
            $row[] = trim($lm->nmdept);
            $row[] = trim($lm->nmsubdept);
            $row[] = trim($lm->nmlvljabatan);
            $row[] = trim($lm->nmgrade);
            $row[] = '<div align="right">'.number_format($lm->nominal, 2,',','.').'</div>';

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Nominal Gaji" onclick="ubah_masjab('."'".$id."'".')"><i class="fa fa-gear"></i> </a>';
            /*
             * $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Nominal Gaji" onclick="ubah_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Nominal Gaji" onclick="hapus_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
            */

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->t_masjab_sal_count_all(),
            "recordsFiltered" => $this->m_master->t_masjab_sal_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function save_masjab_salary()
    {

        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $kdjabatan = strtoupper($this->input->post('kdjabatan'));
        $nmjabatan = strtoupper($this->input->post('nmjabatan'));
        $kdlvl = strtoupper($this->input->post('kdlvl'));
        $golongan = strtoupper($this->input->post('golongan'));
        $nominal =  str_replace('.','',$this->input->post('nominal') );
        //$c_hold = strtoupper($this->input->post('c_hold'));
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        if($type=='INPUT'){
            /* NULL PROSES INPUT*/
            echo json_encode(array("status" => TRUE));
        } else if ($type=='EDIT') {
            $data = array(
                'nominal' => $nominal,
                'update_by' => $inputby,
                'update_date' => $inputdate,
            );
            $this->m_master->ubah_masjab_sal(array('kdjabatan' => $kdjabatan), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            /*NULL PROSES UPDATE*/
            echo json_encode(array("status" => TRUE));
        }

    }

    function show_edit_masjab_salary()
    {
        $enc_id=$this->uri->segment(4);
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data = $this->m_master->get_t_masjab_sal_by_id($id);
        echo json_encode($data);
    }
/* START MASA KERJA */

    function masker_salary(){
        $data['title']='MASTER MASA KERJA DAN NOMINAL';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.I.4'; $versirelease='I.P.I.4/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_masa_kerja',$data);
    }

    function list_masker_salary()
    {
        $list = $this->m_master->get_masker_salary();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $id=$this->fiky_encryption->enkript(trim($lm->kdmasakerja));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = trim($lm->kdmasakerja);
            $row[] = trim($lm->nmmasakerja);
            $row[] = trim($lm->awal);
            $row[] = trim($lm->akhir);
            $row[] = '<div align="right">'.number_format($lm->nominal, 2,',','.').'</div>';
            $row[] = trim($lm->c_hold);

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Masa Kerja" onclick="ubah_masakerja('."'".$id."'".')"><i class="fa fa-gear"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Masa Kerja" onclick="hapus_masakerja('."'".$id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->t_masker_sal_count_all(),
            "recordsFiltered" => $this->m_master->t_masker_sal_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function save_masa_kerja()
    {

        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $kdmasakerja = strtoupper($this->input->post('kdmasakerja'));
        $nmmasakerja = strtoupper($this->input->post('nmmasakerja'));
        $awal = strtoupper($this->input->post('awal'));
        $akhir = strtoupper($this->input->post('akhir'));
        $nominal =  str_replace('.','',$this->input->post('nominal') );
        $c_hold = strtoupper($this->input->post('c_hold'));
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        if($type=='INPUT'){
            /* NULL PROSES INPUT*/
            $info = array(
                'branch' => $branch,
                'kdmasakerja' => $kdmasakerja,
                'nmmasakerja' => $nmmasakerja,
                'awal' => $awal,
                'akhir' => $akhir,
                'nominal' => $nominal,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_master->simpan_masker_sal($info);
            echo json_encode(array("status" => TRUE));
        } else if ($type=='EDIT') {
            $data = array(
                'nmmasakerja' => $nmmasakerja,
                'awal' => $awal,
                'akhir' => $akhir,
                'nominal' => $nominal,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate,
            );
            $this->m_master->ubah_masker_sal(array('kdmasakerja' => $kdmasakerja), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            $this->m_master->hapus_masker_sal($kdmasakerja);
            echo json_encode(array("status" => TRUE));
        }

    }

    function show_masa_kerja()
    {
        $enc_id=$this->uri->segment(4);
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data = $this->m_master->get_t_masker_sal_by_id($id);
        echo json_encode($data);
    }

    /* START SETTING PAYROLL */

    function mas_setting(){
        $data['title']='SETTING PAYROLL';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.I.5'; $versirelease='I.P.I.5/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $py2 = " and jenistrx='PAYROL02'"; $data['PAYROL02']=$this->m_master->q_trxtype($py2)->result();
        $py3 = " and jenistrx='PAYROL03'"; $data['PAYROL03']=$this->m_master->q_trxtype($py3)->result();
        $py4 = " and jenistrx='PAYROL04'"; $data['PAYROL04']=$this->m_master->q_trxtype($py4)->result();
        $sy4 = " and jenistrx='SYSTEM01'"; $data['SYSTEM01']=$this->m_master->q_trxtype($sy4)->result();

        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_master_setting',$data);
    }

    function list_mas_setting()
    {
        $list = $this->m_master->get_t_option();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $id=$this->fiky_encryption->enkript(trim($lm->kdoption));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = trim($lm->kdoption);
            $row[] = trim($lm->nmoption);
            $row[] = trim($lm->value1);
            $row[] = trim($lm->status);
            $row[] = trim($lm->keterangan);
            $row[] = trim($lm->group_option);

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Masa Kerja" onclick="ubah_option('."'".$id."'".')"><i class="fa fa-gear"></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->t_option_count_all(),
            "recordsFiltered" => $this->m_master->t_option_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function save_mas_setting()
    {

        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $kdoption = strtoupper($this->input->post('kdoption'));
        $nmoption = strtoupper($this->input->post('nmoption'));
        $value1 = strtoupper($this->input->post('value1'));
        $keterangan = strtoupper($this->input->post('keterangan'));
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        if ($type=='EDIT') {
            $data = array(
                //'branch' => $branch,
                //'nmoption' => $nmoption,
                'value1' => $value1,
                //'keterangan' => $keterangan,
                'update_by' => $inputby,
                'update_date' => $inputdate
            );

            $this->m_master->ubah_t_option(array('kdoption' => $kdoption), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            //$this->m_master->hapus_masker_sal($kdmasakerja);
            echo json_encode(array("status" => FALSE));
        }

    }

    function show_mas_setting()
    {
        $enc_id=$this->uri->segment(4);
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data = $this->m_master->get_t_option_by_id($id);
        echo json_encode($data);
    }

/* START VIEW LEVEL GAJI 1-37 MOHON JANGAN DIHAPUS */

    function mas_lvlgp(){
        $data['title']='MASTER NOMINAL LEVEL PAYROLL';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.I.6'; $versirelease='I.P.I.6/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        $py2 = " and jenistrx='PAYROL02'"; $data['PAYROL02']=$this->m_master->q_trxtype($py2)->result();
        $py3 = " and jenistrx='PAYROL03'"; $data['PAYROL03']=$this->m_master->q_trxtype($py3)->result();
        $py4 = " and jenistrx='PAYROL04'"; $data['PAYROL04']=$this->m_master->q_trxtype($py4)->result();
        $sy4 = " and jenistrx='SYSTEM01'"; $data['SYSTEM01']=$this->m_master->q_trxtype($sy4)->result();

        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/master/v_master_lvlgp',$data);
    }

    function list_mas_lvlgp()
    {
        $list = $this->m_master->get_t_m_lvlgp();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $id=$this->fiky_encryption->enkript(trim($lm->kdlvlgp));
            $row_check = $this->m_akses->list_karyawan_param(" and kdlvlgp='$lm->kdlvlgp'")->num_rows();
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = trim($lm->kdlvlgp);
            $row[] = '<div align="right">'.number_format($lm->nominal, 2,',','.').'</div>';
            $row[] = trim($lm->c_hold);

            if ($row_check > 0){
                //add html for action
            $row[] = '
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Level Gaji" onclick="ubah_lvlgp('."'".$id."'".')"><i class="fa fa-gear"></i> </a>';
            } else {
                //add html for action
            $row[] = '
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Level Gaji" onclick="ubah_lvlgp('."'".$id."'".')"><i class="fa fa-gear"></i> </a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Level Gaji" onclick="hapus_lvlgp('."'".$id."'".')"><i class="fa fa-trash-o"></i> </a>
            ';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->t_m_lvlgp_count_all(),
            "recordsFiltered" => $this->m_master->t_m_lvlgp_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
        //echo json_encode($output);
    }

    function save_mas_lvlgp()
    {

        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $kdlvlgp = strtoupper($this->input->post('kdlvlgp'));
        $nominal = str_replace('.','',$this->input->post('nominal'));
        $c_hold = $this->input->post('c_hold');
        $inputby = $nama;
        $inputdate = date('d-m-y H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        if ($type=='INPUT') {
            $data = array(
                'branch' => $branch,
                'kdlvlgp' => $kdlvlgp,
                'nominal' => $nominal,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate
            );
            $this->m_master->simpan_t_m_lvlgp($data);
            echo json_encode(array("status" => TRUE));
        } else if ($type=='EDIT') {
            $data = array(
                'nominal' => $nominal,
                'c_hold' => $c_hold,
                'inputby' => $inputby,
                'inputdate' => $inputdate
            );

            $this->m_master->ubah_t_m_lvlgp(array('kdlvlgp' => $kdlvlgp,'branch' => $branch), $data);
            echo json_encode(array("status" => TRUE));
        } else if($type=='DELETE'){
            $this->m_master->hapus_t_m_lvlgp($kdlvlgp);
            echo json_encode(array("status" => TRUE));
        }

    }

    function show_mas_lvlgp()
    {
        $enc_id=$this->uri->segment(4);
        $id=$this->fiky_encryption->dekript(trim($enc_id));
        $data = $this->m_master->get_t_m_lvlgp_by_id($id);
        echo json_encode($data);
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