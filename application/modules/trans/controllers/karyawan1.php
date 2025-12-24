<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_karyawan','master/m_geo','master/m_agama','master/m_nikah','master/m_department','master/m_jabatan','m_bpjs','master/m_group_penggajian','master/m_bank',
            'm_riwayat_keluarga','m_riwayat_kesehatan','m_riwayat_pengalaman','m_riwayat_pendidikan','m_riwayat_pendidikan_nf','master/m_akses','recruitment/m_calonkaryawan','m_mutpromot','m_stspeg','payroll/m_master'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['title']='Data Karyawan';

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.T.A.1'; $versirelease='I.T.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
        $data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
        $data['list_opt_agama']=$this->m_agama->q_agama()->result();
        $data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $data['list_opt_m_grade_jabatan']=$this->m_jabatan->q_m_grade_jabatan()->result();
        $data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
        $data['list_chainjobgrade']=$this->m_jabatan->chain_jobgrade()->result();//
        $data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
        $data['list_opt_ptkp']=$this->m_bpjs->list_ptkp()->result();
        //$data['list_opt_ptkp']=$this->m_karyawan->list_ptkp()->result();
        $data['list_opt_grp_gaji']=$this->m_group_penggajian->q_group_penggajian()->result();
        $data['list_opt_bank']=$this->m_bank->q_bank()->result();
        $data['list_resignkary']=$this->m_karyawan->list_karyresgn()->result();//
        $data['list_borong']=$this->m_karyawan->list_karyborong()->result();//
        $data['calon_karyawan']=$this->m_calonkaryawan->q_maxktpcalon()->result();//
        $data['list_finger']=$this->m_karyawan->q_finger()->result();//
        $data['list_kanwil']=$this->m_karyawan->q_kanwil()->result();// kantor wilayah
        $data['list_wilnom']=$this->m_karyawan->q_wilayah_nominal($p=null)->result();// wilayah nominal

        if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
        }
        else if($this->uri->segment(4)=="success"){
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
        }
        else if($this->uri->segment(4)=="upsuccess"){
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate </div>";
        }
        else if($this->uri->segment(4)=="notacces"){
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
        }
        else if($this->uri->segment(4)=="del"){
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
        }
        else if($this->uri->segment(4)=="del_exist"){
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
        }
        else {
            $data['message']='';
        }

        $data['akses']=$this->m_akses->list_aksespermenu($nama,$kodemenu)->row_array();
        $this->template->display('trans/karyawan/v_karyawan',$data);
    }

    public function ajax_list()
    {
        $list = $this->m_karyawan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $nama=trim($this->session->userdata('nik'));
        $kmenu='I.T.A.1';
        $akses=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $person->nik;
            $row[] = $person->nmlengkap;
            if ($person->image<>'') {
                $row[] = 					//'test';
                    '<div align="center" class=" image">
					<img height="50px" width="50px" alt="User Image" class="img-box" src="'.site_url('/assets/img/profile').'/'.trim($person->image).'">
				</div>';
            } else {
                $row[] =
                    '<div align="center"  class="image">
					<img height="50px" width="50px" alt="User Image" src="'.site_url('/assets/img/user.png').'">
				</div>';
            }
            $row[] = $person->nmdept;
            $row[] = $person->nmjabatan;
            $row[] = $person->tglmasukkerja1;
            $row[] = $person->kdcabang;
            //$row[] = $person->grouppenggajian;
            //<a class="btn btn-sm btn-success" href="'.site_url('trans/mutprom/index').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Mutasi</a>
            //add html for action
            if($akses['aksesdelete']=='t' and $akses['aksesupdate']=='t'){
                $row[] =
                    '<a class="btn btn-sm btn-default" href="'.site_url('trans/karyawan/detail').'/'.trim($person->nik).'" title="Detail"><i class="fa fa-bars"></i> </a>
						<a class="btn btn-sm btn-danger" href="'.site_url('trans/karyawan/ajax_delete').'/'.trim($person->nik).'" title="Hapus" onclick="return confirm('."'Apakah Anda Yakin Menghapus Nik Ini?  ".trim($person->nik)."'".')"><i class="fa fa-trash-o"></i> </a>';

            } else if ($akses['aksesdelete']=='f' and $akses['aksesupdate']=='t'){
                $row[]='<a class="btn btn-sm btn-success" href="'.site_url('trans/karyawan/detail').'/'.trim($person->nik).'" title="Detail"><i class="fa fa-bars"></i> </a>';
            } else if ($akses['aksesdelete']=='t' and $akses['aksesupdate']=='f'){
                $row[]='<a class="btn btn-sm btn-danger" href="'.site_url('trans/karyawan/ajax_delete').'/'.trim($person->nik).'" title="Hapus" onclick="return confirm('."'Apakah Anda Yakin Menghapus Nik Ini?  ".trim($person->nik)."'".')"><i class="fa fa-trash-o"></i> </a>';
            } else{
                $row[]='';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_karyawan->count_all(),
            "recordsFiltered" => $this->m_karyawan->count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->m_karyawan->get_by_id($id)->row();
        echo json_encode($data);
    }
    public function detail($id)
    {
        $nik=$this->uri->segment(4);
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.T.A.1'; $versirelease='I.T.A.1/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $data['message']='';
        $data['nik']=$nik;
        $data['list_opt_agama']=$this->m_agama->q_agama()->result();
        $data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
        $data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
        $data['list_opt_ptkp']=$this->m_bpjs->list_ptkp()->result();
        $data['list_opt_grp_gaji']=$this->m_group_penggajian->q_group_penggajian()->result();
        $data['list_opt_bank']=$this->m_bank->q_bank()->result();
        $data['list_riwayat_pengalaman']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->result();
        $data['list_riwayat_pendidikan']=$this->m_riwayat_pendidikan->q_riwayat_pendidikan($nik)->result();
        $data['list_finger']=$this->m_karyawan->q_finger()->result();//
        $data['list_kanwil']=$this->m_karyawan->q_kanwil()->result();//
        $data['list_wilnom']=$this->m_karyawan->q_wilayah_nominal($p=null)->result();// wilayah nominal

        /*MUTASI*/
        //$data['list_karyawan']=$this->m_mutpromot->list_karyawan()->result();
        $data['list_karyawan']=$this->m_mutpromot->list_nik($id)->result();
        $data['list_mutasi']=$this->m_mutpromot->get_mutasinik($id)->result();
        /*END MUTASI*/
        /*STATUS KEPEGAWAIN*/
        $data['list_lk']=$this->m_stspeg->list_karyawan_index($id)->row_array();
        $data['list_kepegawaian']=$this->m_stspeg->list_kepegawaian()->result();
        $data['list_stspeg']=$this->m_stspeg->q_stspeg($id)->result();
        $data['list_rk']=$this->m_stspeg->q_stspeg($id)->row_array();
        /**/
        /*BPJS KARYAWAN*/
        $data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
        $data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
        $data['list_bpjskaryawan']=$this->m_bpjs->list_bpjs_karyawan($id)->result();
        $data['list_faskes']=$this->m_bpjs->list_faskes()->result();
        $data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
        $data['list_karyawan_bpjs']=$this->m_bpjs->list_karyawan()->result();
        /*ADD RIWAYAT KELUARGA*/
        $data['list_keluarga']=$this->m_riwayat_keluarga->list_keluarga()->result();
        $data['list_negara']=$this->m_riwayat_keluarga->list_negara()->result();
        $data['list_prov']=$this->m_riwayat_keluarga->list_prov()->result();
        $data['list_kotakab']=$this->m_riwayat_keluarga->list_kotakab()->result();
        $data['list_jenjang_pendidikan']=$this->m_riwayat_keluarga->list_jenjang_pendidikan()->result();
        $data['list_riwayat_keluarga']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->result();
        $data['list_rku']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->row_array();
        /**/
        /*RIWAYAT KESEHATAN*/

        $data['list_karyawan_kesehatan']=$this->m_riwayat_kesehatan->list_karyawan()->result();
        $data['list_lkes']=$this->m_riwayat_kesehatan->list_karyawan_index($nik)->row_array();
        $data['list_penyakit']=$this->m_riwayat_kesehatan->list_penyakit()->result();
        $data['list_riwayat_kesehatan']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->result();
        $data['list_rkes']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->row_array();
        //$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        /**/
        /*RIWAYAT KERJA /PENGALAMAN*/

        $data['list_riwayat_pengalaman']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->result();
        $data['list_rpglm']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->row_array();
        /**/

        /* PELATIHAN KARYAWAN */
        $data['list_pennf']=$this->m_riwayat_pendidikan_nf->list_karyawan_index($nik)->row_array();
        $data['list_keahlian']=$this->m_riwayat_pendidikan_nf->list_keahlian()->result();
        $data['list_riwayat_pendidikan_nf']=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf($nik)->result();
        /**/

        /*PENDIDIKAN */
        $data['list_pendidikan']=$this->m_riwayat_pendidikan->list_pendidikan()->result();
        $data['list_riwayat_pendidikan']=$this->m_riwayat_pendidikan->q_riwayat_pendidikan($nik)->result();
        /**/


        $data['title'] = "Detail Karyawan";
        //$data['dtl'] = $this->m_karyawan->get_dtl_id($id)->row_array();
        $data['lp'] = $this->m_karyawan->get_dtl_id($id)->row_array();
        $this->template->display('trans/karyawan/v_detailhrdkary',$data);
    }

    public function detail_resign($id)
    {
        $nik=$this->uri->segment(4);
        $data['message']='';
        $data['nik']=$nik;
        $data['list_opt_agama']=$this->m_agama->q_agama()->result();
        $data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
        $data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
        $data['list_opt_ptkp']=$this->m_bpjs->list_ptkp()->result();
        $data['list_opt_grp_gaji']=$this->m_group_penggajian->q_group_penggajian()->result();
        $data['list_opt_bank']=$this->m_bank->q_bank()->result();
        $data['list_riwayat_pengalaman']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->result();
        $data['list_riwayat_pendidikan']=$this->m_riwayat_pendidikan->q_riwayat_pendidikan($nik)->result();
        $data['list_finger']=$this->m_karyawan->q_finger()->result();//
        $data['list_kanwil']=$this->m_karyawan->q_kanwil()->result();//
        $data['list_wilnom']=$this->m_karyawan->q_wilayah_nominal($p=null)->result();// wilayah nominal

        /*MUTASI*/
        //$data['list_karyawan']=$this->m_mutpromot->list_karyawan()->result();
        $data['list_karyawan']=$this->m_mutpromot->list_nik($id)->result();
        $data['list_mutasi']=$this->m_mutpromot->get_mutasinik($id)->result();
        /*END MUTASI*/
        /*STATUS KEPEGAWAIN*/
        $data['list_lk']=$this->m_stspeg->list_karyawan_index($id)->row_array();
        $data['list_kepegawaian']=$this->m_stspeg->list_kepegawaian()->result();
        $data['list_stspeg']=$this->m_stspeg->q_stspeg($id)->result();
        $data['list_rk']=$this->m_stspeg->q_stspeg($id)->row_array();
        /**/
        /*BPJS KARYAWAN*/
        $data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
        $data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
        $data['list_bpjskaryawan']=$this->m_bpjs->list_bpjs_karyawan($id)->result();
        $data['list_faskes']=$this->m_bpjs->list_faskes()->result();
        $data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
        $data['list_karyawan_bpjs']=$this->m_bpjs->list_karyawan()->result();
        /*ADD RIWAYAT KELUARGA*/
        $data['list_keluarga']=$this->m_riwayat_keluarga->list_keluarga()->result();
        $data['list_negara']=$this->m_riwayat_keluarga->list_negara()->result();
        $data['list_prov']=$this->m_riwayat_keluarga->list_prov()->result();
        $data['list_kotakab']=$this->m_riwayat_keluarga->list_kotakab()->result();
        $data['list_jenjang_pendidikan']=$this->m_riwayat_keluarga->list_jenjang_pendidikan()->result();
        $data['list_riwayat_keluarga']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->result();
        $data['list_rku']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->row_array();
        /**/
        /*RIWAYAT KESEHATAN*/

        $data['list_karyawan_kesehatan']=$this->m_riwayat_kesehatan->list_karyawan()->result();
        $data['list_lkes']=$this->m_riwayat_kesehatan->list_karyawan_index($nik)->row_array();
        $data['list_penyakit']=$this->m_riwayat_kesehatan->list_penyakit()->result();
        $data['list_riwayat_kesehatan']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->result();
        $data['list_rkes']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->row_array();
        //$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        /**/
        /*RIWAYAT KERJA /PENGALAMAN*/

        $data['list_riwayat_pengalaman']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->result();
        $data['list_rpglm']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->row_array();
        /**/

        /* PELATIHAN KARYAWAN */
        $data['list_pennf']=$this->m_riwayat_pendidikan_nf->list_karyawan_index($nik)->row_array();
        $data['list_keahlian']=$this->m_riwayat_pendidikan_nf->list_keahlian()->result();
        $data['list_riwayat_pendidikan_nf']=$this->m_riwayat_pendidikan_nf->q_riwayat_pendidikan_nf($nik)->result();
        /**/

        /*PENDIDIKAN */
        $data['list_pendidikan']=$this->m_riwayat_pendidikan->list_pendidikan()->result();
        $data['list_riwayat_pendidikan']=$this->m_riwayat_pendidikan->q_riwayat_pendidikan($nik)->result();
        /**/


        $data['title'] = "Detail Karyawan";
        //$data['dtl'] = $this->m_karyawan->get_dtl_id($id)->row_array();
        $data['lp'] = $this->m_karyawan->get_dtl_id($id)->row_array();
        $this->template->display('trans/karyawan/v_detailhrdkary_resign',$data);
    }

    public function edit($id) {
        $data["message"] = "";
        $data["list_opt_neg"] = $this->m_geo->list_opt_negara()->result();
        $data["list_opt_agama"] = $this->m_agama->q_agama()->result();
        $data["list_opt_nikah"] = $this->m_nikah->q_nikah()->result();
        $data["list_opt_dept"] = $this->m_department->q_department()->result();
        $data["list_opt_lvljabt"] = $this->m_jabatan->q_lvljabatan()->result();
        $data["list_opt_atasan"] = $this->m_karyawan->list_karyawan()->result();

        $data["list_opt_ptkp"] = $this->m_bpjs->list_ptkp()->result();
        $data["list_opt_grp_gaji"] = $this->m_group_penggajian->q_group_penggajian()->result();
        $data["list_opt_bank"] = $this->m_bank->q_bank()->result();
        $data["list_finger"] = $this->m_karyawan->q_finger()->result();
        $data["list_kanwil"] = $this->m_karyawan->q_kanwil()->result();
        $data["list_wilnom"] = $this->m_karyawan->q_wilayah_nominal($p = null)->result();
        $data["title"] = "Edit Karyawan";
        
        /* CODE UNTUK VERSI*/
        $nama = trim($this->session->userdata("nik"));
        $kodemenu = "I.T.A.1";
        $versirelease = "I.T.A.1/ALPHA.001";
        $releasedate = date("2019-04-12 00:00:00");
        $versidb = $this->fiky_version->version($kodemenu, $versirelease, $releasedate, $nama);
        $x = $this->fiky_menu->menus($kodemenu, $versirelease, $releasedate);
        $data["x"] = $x["rows"];
        $data["y"] = $x["res"];
        $data["t"] = $x["xn"];
        $data["kodemenu"] = $kodemenu;
        $data["version"] = $versidb;
        /* END CODE UNTUK VERSI */

        $data["dtl"] = $this->m_karyawan->get_by_id($id)->row_array();
        $this->template->display("trans/karyawan/v_editkary", $data);
    }

    public function ajax_add()
    {
        $nama = trim($this->session->userdata('nik'));
        $branch=strtoupper($this->input->post('branch'));
        $unlimitedktp=$this->input->post('ktp_seumurhdp');
        ///if ($unlimitedktp=='f' or $unlimitedktp=='F'){
        $tgl_ktp1=$this->input->post('ktpberlaku');
        $nik=trim(strtoupper($this->input->post('nik')));
        $tglnpwps=$this->input->post('tglnpwp');
        //$besaranptkp=strtoupper($this->input->post('besaranptkp'));
        $ktpkeluar=strtoupper($this->input->post('ktpdikeluarkan'));
        $tglkeluar=strtoupper($this->input->post('tgldikeluarkan'));
        $tgllahir= strtoupper($this->input->post('tgllahir'));
        $gp=$this->input->post('gajipokok');
        $gbpjs=$this->input->post('gajibpjs');
        $gjnaker1=$this->input->post('gajinaker');
        $status_ptkp=strtoupper($this->input->post('status_ptkp'));
        $kdcabang=strtoupper($this->input->post('kdcabang'));
        $besaranptkp1=$this->m_karyawan->q_besaranptkp($status_ptkp)->row_array();
        $besaranptkp=$besaranptkp1['besaranpertahun'];
        $dfktp=$this->input->post('dfktp');
        $nokk=trim($this->input->post('nokk'));
        $kdwilayahnominal=trim($this->input->post('kdwilayahnominal'));
        $kdlvlgp=trim($this->input->post('kdlvlgp'));
        if($dfktp=='t'){ $noktp=strtoupper($this->input->post('noktp2')); } else { $noktp=strtoupper($this->input->post('noktp1')); };

        if(empty($tgl_ktp1)){
            $tgl_ktp=null;
        } else {
            $tgl_ktp=$tgl_ktp1;
        }
        if (empty($tgllahir)){
            $tgllahir1=null;
        } else {
            $tgllahir1=$tgllahir;
        }
        if (empty($ktpkeluar)){
            $ktpdikeluarkan=null;
        } else{
            $ktpdikeluarkan=$ktpkeluar;
        }
        if (empty($tglkeluar)){
            $tgldikeluarkan=null;
        } else{
            $tgldikeluarkan=$tglkeluar;
        }
        if (empty($besaranptkp))
        {
            $ptkp=null;
        } else {
            $ptkp=$besaranptkp;
        }
        if (empty($tglnpwps)){
            $tglnpwp=null;
        } else {
            $tglnpwp=$tglnpwps;
        }
        if (empty($gp)){
            $gajipokok=null;
        } else {
            $gajipokok=$gp;
        }
        if (empty($gbpjs)){
            $gajibpjs=null;
        } else {
            $gajibpjs=$gbpjs;
        }
        if (empty($gjnaker1)){
            $gjnaker=null;
        } else {
            $gjnaker=$gjnaker1;
        }



        $data = array(
            'branch'=>$branch,
            'nik' =>$nama,
            'nmlengkap' => strtoupper($this->input->post('nmlengkap')),
            'callname' => strtoupper($this->input->post('callname')),
            'jk' => strtoupper($this->input->post('jk')),
            'neglahir' => strtoupper($this->input->post('neglahir')),
            'provlahir' => strtoupper($this->input->post('provlahir')),
            'kotalahir' => strtoupper($this->input->post('kotalahir')),
            'tgllahir' => $tgllahir1,
            'kd_agama' => strtoupper($this->input->post('kd_agama')),
            'stswn' => strtoupper($this->input->post('stswn')),
            'stsfisik' => strtoupper($this->input->post('stsfisik')),
            'ketfisik' => strtoupper($this->input->post('ketfisik')),
            'noktp' => $noktp,
            'tgl_ktp' => $tgl_ktp,
            'ktp_seumurhdp' => strtoupper($this->input->post('ktp_seumurhdp')),
            'ktpdikeluarkan' => $ktpdikeluarkan,
            'tgldikeluarkan' => $tgldikeluarkan,
            'status_pernikahan' => strtoupper($this->input->post('stastus_pernikahan')),
            'gol_darah' => strtoupper($this->input->post('gol_darah')),
            'negktp' => strtoupper($this->input->post('negktp')),
            'provktp' => strtoupper($this->input->post('provktp')),
            'kotaktp' => strtoupper($this->input->post('kotaktp')),
            'kecktp' => strtoupper($this->input->post('kecktp')),
            'kelktp' => strtoupper($this->input->post('kelktp')),
            'alamatktp' => strtoupper($this->input->post('alamatktp')),
            'negtinggal' => strtoupper($this->input->post('negtinggal')),
            'provtinggal' => strtoupper($this->input->post('provtinggal')),
            'kotatinggal' => strtoupper($this->input->post('kotatinggal')),
            'kectinggal' => strtoupper($this->input->post('kectinggal')),
            'keltinggal' => strtoupper($this->input->post('keltinggal')),
            'alamattinggal' => strtoupper($this->input->post('alamattinggal')),
            'nohp1' => strtoupper($this->input->post('nohp1')),
            'nohp2' => strtoupper($this->input->post('nohp2')),
            'npwp' => strtoupper($this->input->post('npwp')),
            'tglnpwp' => $tglnpwp,
            'bag_dept' => strtoupper($this->input->post('bag_dept')),
            'subbag_dept' => strtoupper($this->input->post('subbag_dept')),
            'jabatan' => strtoupper($this->input->post('jabatan')),
            'lvl_jabatan' => strtoupper($this->input->post('lvl_jabatan')),
            'kdgradejabatan' => strtoupper($this->input->post('kdgradejabatan')),
            'grade_golongan' => strtoupper($this->input->post('grade_golongan')),
            'nik_atasan' => strtoupper($this->input->post('nik_atasan')),
            'nik_atasan2' => strtoupper($this->input->post('nik_atasan2')),
            'status_ptkp' => strtoupper($this->input->post('status_ptkp')),
            'besaranptkp' => $besaranptkp,
            'tglmasukkerja' => strtoupper($this->input->post('tglmasukkerja')),
            //'tglkeluarkerja' => strtoupper($this->input->post('tglkeluarkerja')),
            'masakerja' => strtoupper($this->input->post('masakerja')),
            //'statuskepegawaian' => strtoupper($this->input->post('statuskepegawaian')),
            'grouppenggajian' => strtoupper($this->input->post('grouppenggajian')),
            'gajipokok' => $gajipokok,
            'gajibpjs' => $gajibpjs,
            'gajinaker' => $gjnaker,
            'namabank' => strtoupper($this->input->post('namabank')),
            'namapemilikrekening' => strtoupper($this->input->post('namapemilikrekening')),
            'norek' => strtoupper($this->input->post('norek')),
            //'shift' => strtoupper($this->input->post('shift')),
            'idabsen' => strtoupper($this->input->post('idabsen')),
            'idmesin' => $this->input->post('idmesin'),
            'cardnumber' => $this->input->post('cardnumber'),
            'email' => strtoupper($this->input->post('email')),
            //'bolehcuti' => strtoupper($this->input->post('bolehcuti')),
            //'sisacuti' => strtoupper($this->input->post('sisacuti')),
            'inputdate'=>date("d-m-Y H:i:s"),
            'inputby'=>$this->session->userdata('nik'),
            'tjborong'=>$this->input->post('borong'),
            'tjshift'=>$this->input->post('shift'),
            'tjlembur'=>$this->input->post('lembur'),
            'kdcabang'=>$kdcabang,
            'nokk'=>$nokk,
            'kdwilayahnominal'=>$kdwilayahnominal,
            'kdlvlgp' => $kdlvlgp,
            'callplan' => $this->input->post('callplan')
        );
        $cek=$this->m_karyawan->cek_exist($nik);
        if ($cek>0) {
            redirect('trans/karyawan/index/exist');
        } else {
            $insert = $this->m_karyawan->save($data);
            $this->load->model(array('master/m_option', 'master/m_akses', 'master/m_user','master/M_UserSidia',));
            $employee = $this->m_karyawan->q_karyawan_read('TRUE AND trim(noktp) = \'' . trim($noktp) . '\' ')->row();
//            $this->createUser(trim($employee->nik));
            if(trim($this->input->post('borong')) == 'f'){
                if ($this->createUser(trim($employee->nik)) == TRUE){
                    echo json_encode(array("status" => TRUE));
                    redirect('trans/karyawan/index/success');
                }else{
                    echo json_encode(array("status" => FALSE));
                }
            }else{
                echo json_encode(array("status" => TRUE));
                redirect('trans/karyawan/index/success');
            }

        }

    }

    public function ajax_update()
    {
        $nama = trim($this->session->userdata('nik'));
        $username = trim($this->session->userdata('nama'));
        $inputdate = date('Y-m-d H:i:s');
        $branch=strtoupper($this->input->post('branch'));
        $unlimitedktp=$this->input->post('ktp_seumurhdp');
        if ($unlimitedktp=='f'){
            $tgl_ktp=$this->input->post('tgl_ktp');
        } else {
            $tgl_ktp=null;
        }
        $nik=trim(strtoupper($this->input->post('nik')));
        $tglnpwps=$this->input->post('tglnpwp');
        //$besaranptkp=strtoupper($this->input->post('besaranptkp'));
        $ktpkeluar=strtoupper($this->input->post('ktpdikeluarkan'));
        $tglkeluar=strtoupper($this->input->post('tgldikeluarkan'));
        $tgllahir= strtoupper($this->input->post('tgllahir'));
        //$gp=$this->input->post('gajipokok'); //disabled by request
        //$gbpjs=$this->input->post('gajibpjs');
        //$gjnaker1=$this->input->post('gajibpjs');
        $status_ptkp=strtoupper($this->input->post('status_ptkp'));
        $besaranptkp1=$this->m_karyawan->q_besaranptkp($status_ptkp)->row_array();
        $besaranptkp=$besaranptkp1['besaranpertahun'];
        $kdcabang=$this->input->post('kdcabang');
        $nokk=trim($this->input->post('nokk'));
        $kdwilayahnominal=trim($this->input->post('kdwilayahnominal'));
        //$kdlvlgp=trim($this->input->post('kdlvlgp'));
        $deviceid=trim($this->input->post('deviceid'));
        if (empty($tgllahir)){
            $tgllahir1=null;
        } else {
            $tgllahir1=$tgllahir;
        }
        if (empty($ktpkeluar)){
            $ktpdikeluarkan=null;
        } else{
            $ktpdikeluarkan=$ktpkeluar;
        }
        if (empty($tglkeluar)){
            $tgldikeluarkan=null;
        } else{
            $tgldikeluarkan=$tglkeluar;
        }
        if (empty($besaranptkp))
        {
            $ptkp=null;
        } else {
            $ptkp=$besaranptkp;
        }
        if (empty($tglnpwps)){
            $tglnpwp=null;
        } else {
            $tglnpwp=$tglnpwps;
        }
        if (empty($gp)){
            $gajipokok=null;
        } else {
            $gajipokok=$gp;
        }
        if (empty($gbpjs)){
            $gajibpjs=null;
        } else {
            $gajibpjs=$gbpjs;
        }
        if (empty($gjnaker1)){
            $gjnaker=null;
        } else {
            $gjnaker=$gjnaker1;
        }



        $data = array(
            'branch' =>$branch,
            'nik' =>$nik,
            'nmlengkap' => strtoupper($this->input->post('nmlengkap')),
            'callname' => strtoupper($this->input->post('callname')),
            'jk' => strtoupper($this->input->post('jk')),
            'neglahir' => strtoupper($this->input->post('neglahir')),
            'provlahir' => strtoupper($this->input->post('provlahir')),
            'kotalahir' => strtoupper($this->input->post('kotalahir')),
            'tgllahir' => $tgllahir1,
            'kd_agama' => strtoupper($this->input->post('kd_agama')),
            'stswn' => strtoupper($this->input->post('stswn')),
            'stsfisik' => strtoupper($this->input->post('stsfisik')),
            'ketfisik' => strtoupper($this->input->post('ketfisik')),
            'noktp' => strtoupper($this->input->post('noktp')),
            'tgl_ktp' => $tgl_ktp,
            'ktp_seumurhdp' => strtoupper($this->input->post('ktp_seumurhdp')),
            'ktpdikeluarkan' => $ktpdikeluarkan,
            'tgldikeluarkan' => $tgldikeluarkan,
            'status_pernikahan' => strtoupper($this->input->post('status_pernikahan')),
            'gol_darah' => strtoupper($this->input->post('gol_darah')),
            'negktp' => strtoupper($this->input->post('negktp')),
            'provktp' => strtoupper($this->input->post('provktp')),
            'kotaktp' => strtoupper($this->input->post('kotaktp')),
            'kecktp' => strtoupper($this->input->post('kecktp')),
            'kelktp' => strtoupper($this->input->post('kelktp')),
            'alamatktp' => strtoupper($this->input->post('alamatktp')),
            'negtinggal' => strtoupper($this->input->post('negtinggal')),
            'provtinggal' => strtoupper($this->input->post('provtinggal')),
            'kotatinggal' => strtoupper($this->input->post('kotatinggal')),
            'kectinggal' => strtoupper($this->input->post('kectinggal')),
            'keltinggal' => strtoupper($this->input->post('keltinggal')),
            'alamattinggal' => strtoupper($this->input->post('alamattinggal')),
            'nohp1' => strtoupper($this->input->post('nohp1')),
            'nohp2' => strtoupper($this->input->post('nohp2')),
            'npwp' => strtoupper($this->input->post('npwp')),
            'tglnpwp' =>$tglnpwp,
            'bag_dept' => strtoupper($this->input->post('dept')),
            'subbag_dept' => strtoupper($this->input->post('subbag_dept')),
            'jabatan' => strtoupper($this->input->post('jabatan')),
            'lvl_jabatan' => strtoupper($this->input->post('lvl_jabatan')),
            //'kdgradejabatan' => strtoupper($this->input->post('kdgradejabatan')),
            'grade_golongan' => strtoupper($this->input->post('grade_golongan')),
            'nik_atasan' => strtoupper($this->input->post('nik_atasan')),
            'nik_atasan2' => strtoupper($this->input->post('nik_atasan2')),
            'status_ptkp' => strtoupper($this->input->post('status_ptkp')),
            'besaranptkp' => $besaranptkp,
            'tglmasukkerja' =>date('Y-m-d',strtotime($this->input->post('tglmasukkerja'))),
            //'tglkeluarkerja' => strtoupper($this->input->post('tglkeluarkerja')),
            'masakerja' => strtoupper($this->input->post('masakerja')),
            ///'statuskepegawaian' => strtoupper($this->input->post('statuskepegawaian')),
            'grouppenggajian' => strtoupper($this->input->post('grouppenggajian')),
            //'gajipokok' => $gajipokok,
            //'gajibpjs' => $gajibpjs,
            //'gajinaker' => $gjnaker,
            'namabank' => strtoupper($this->input->post('namabank')),
            'namapemilikrekening' => strtoupper($this->input->post('namapemilikrekening')),
            'norek' => strtoupper($this->input->post('norek')),
            //'shift' => strtoupper($this->input->post('shift')),
            'idabsen' => strtoupper($this->input->post('idabsen')),
            'idmesin' => strtoupper($this->input->post('idmesin')),
            'email' => strtoupper($this->input->post('email')),
            //'bolehcuti' => strtoupper($this->input->post('bolehcuti')),
            //'sisacuti' => strtoupper($this->input->post('sisacuti')),
            'inputdate'=>date("d-m-Y H:i:s"),
            'inputby'=>$this->session->userdata('nik'),
            'tjborong'=>$this->input->post('borong'),
            'tjshift'=>$this->input->post('shift'),
            'tjlembur'=>$this->input->post('lembur'),
            'kdcabang'=>$kdcabang,
            'nokk'=>$nokk,
            'kdwilayahnominal'=>$kdwilayahnominal,
            //'kdlvlgp'=>$kdlvlgp,
            'deviceid'=>$deviceid,
            'updateby' => $username,
            'updatedate' => $inputdate,
            'callplan' => $this->input->post('callplan')
        );
		
		//print_r($data);die();

        $this->m_karyawan->update(array('nik' => $this->input->post('nik')), $data);
        echo json_encode(array("status" => TRUE));
        redirect('trans/karyawan/index/upsuccess');

    }

    public function ajax_delete($id)
    {
        $this->m_karyawan->delete_by_id($id);
        //echo json_encode(array("status" => TRUE));
        redirect('trans/karyawan/index/del');
    }

    public function excel_listkaryawan(){

        $datane=$this->m_karyawan->list_karyawan();
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama lengkap','Panggilan','kelamin','Negara lahir','Prov lahir','Kota lahir','Tgllahir','Kode Agama','No ktp',
            'Status Pernikahan','Golongan Darah','Negara','Provinsi','Kota',
            'Kecamatan','Kelurahan','Alamat','No HP1','No HP2','NPWP','TGL NPWP','Bagian','Sub Bagian','Jabatan','Lvl Jabatan','Grade golongan','Atasan1','Atasan2','Status PTKP',
            'Besaran PTKP','Tgl masuk kerja','Tgl keluar kerja','Masakerja','Status kepegawaian','Group penggajian','Bank','Nama pemilik rekening','no rekening','ID absen','Email',
            'Sisa Cuti','id mesin','Card number','Status','Mobile Deviceid'
        ));



        $this->excel_generator->set_column(array('nik','nmlengkap','callname','jk','namanegara','nmprovlahir','nmkotalahir','tgllahir','nmagama','noktp',
            'status_pernikahan','gol_darah','namanegara','nmprovtinggal','nmkotatinggal',
            'nmkectinggal','nmdesatinggal','alamattinggal','nohp1','nohp2','npwp','tglnpwp','nmdept','nmsubdept','nmjabatan','nmlvljabatan','nmgrade','nik_atasan','nik_atasan2','status_ptkp',
            'besaranptkp','tglmasukkerja','tglkeluarkerja','masakerja','statuskepegawaian','grouppenggajian','namabank','namapemilikrekening','norek','idabsen','email',
            'sisacuti','idmesin','cardnumber','status','deviceid'
        ));

        $this->excel_generator->set_width(array(10,20,20,20,20,20,20,20,20,20,
            20,20,20,20,20,
            10,20,20,20,20,20,20,20,20,20,20,20,20,20,20,
            10,20,20,20,20,20,20,20,20,20,20,
            20,20,20,20,20
        ));
        $this->excel_generator->exportTo2007('Master Karyawan');
    }

    public function excel_listkaryawan_resign(){

        $datane=$this->m_karyawan->list_karyawan_resign();
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama lengkap','Panggilan','kelamin','Negara lahir','Prov lahir','Kota lahir','Tgllahir','Kode Agama','No ktp',
            'Status Pernikahan','Golongan Darah','Negara','Provinsi','Kota',
            'Kecamatan','Kelurahan','Alamat','No HP1','No HP2','NPWP','TGL NPWP','Bagian','Sub Bagian','Jabatan','Lvl Jabatan','Grade golongan','Atasan1','Atasan2','Status PTKP',
            'Besaran PTKP','Tgl masuk kerja','Tgl keluar kerja','Masakerja','Status kepegawaian','Group penggajian','Bank','Nama pemilik rekening','no rekening','ID absen','Email',
            'Sisa Cuti','id mesin','Card number','Status','Mobile Deviceid'
        ));



        $this->excel_generator->set_column(array('nik','nmlengkap','callname','jk','namanegara','nmprovlahir','nmkotalahir','tgllahir','nmagama','noktp',
            'status_pernikahan','gol_darah','namanegara','nmprovtinggal','nmkotatinggal',
            'nmkectinggal','nmdesatinggal','alamattinggal','nohp1','nohp2','npwp','tglnpwp','nmdept','nmsubdept','nmjabatan','nmlvljabatan','nmgrade','nik_atasan','nik_atasan2','status_ptkp',
            'besaranptkp','tglmasukkerja','tglkeluarkerja','masakerja','statuskepegawaian','grouppenggajian','namabank','namapemilikrekening','norek','idabsen','email',
            'sisacuti','idmesin','cardnumber','status','deviceid'
        ));

        $this->excel_generator->set_width(array(10,20,20,20,20,20,20,20,20,20,
            20,20,20,20,20,
            10,20,20,20,20,20,20,20,20,20,20,20,20,20,20,
            10,20,20,20,20,20,20,20,20,20,20,
            20,20,20,20,20
        ));
        $this->excel_generator->exportTo2007('Daftar Karyawan Resign');
    }


    function up_foto(){
        $data['title']="Profile User";
        $nik=$this->input->post('nik');
        $nm=$this->m_karyawan->get_by_id($nik)->row_array();
        $nama=$nm['nmlengkap'];
        //setting konfigurasi upload image
        $config['upload_path'] = './assets/img/profile/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']	= '5000';
        $config['max_width']  = '3624';
        $config['max_height']  = '3200';

        $this->upload->initialize($config);
        if(!$this->upload->do_upload('gambar')){
            $gambar="";
            $data['message']="<div class='alert alert-danger'>Gambar Tidak Sesuai</div>";
            echo 'Gambar Tidak Sesuai</br>
					Format yang sesuai:</br>
					* Ukuran File yang di ijinkan max 2MB</br>
					* Lebar Max 2000 pixel</br>
					* Tinggi Max 2000 pixel</br>					
					';
        }else{
            //Image Resizing
            $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 480;
            $config['height'] = 640;

            $this->load->library('image_lib', $config);

            if ( ! $this->image_lib->resize()){
                $this->session->set_flashdata('message', $this->image_lib->display_errors('', ''));
            } else {
                $res = $this->upload->data();
                $file_path     = $res['file_path'];
                $file         = $res['full_path'];
                $file_ext     = $res['file_ext'];
                $final_file_name = trim(trim($nik)).$file_ext;
                if(file_exists($file_path.$final_file_name)){
                    unlink($file_path.$final_file_name);
                }
                rename($file,$file_path.$final_file_name);
                //$gambar=$this->upload->file_name;
                $gambar=$final_file_name;
                $info=array('image'=>$gambar);
                //update foto pegawai
                $this->m_karyawan->save_foto($nik,$info);
                $data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
                //redirect("hrd/hrd/detail_peg/$nip");
            }

            $x=base_url('assets/img/profile/'.$gambar);
            //echo "<img id='gbr' src='$x' width='100%' height='100%' alt='User Image'>";
            redirect("trans/karyawan/detail/$nik");
        }
        //tampilkan pesan

        //tampilkan data anggota
        //$data['anggota']=$this->m_user->cekId($id)->row_array();
        //$this->template->display('hrd/hrd/view_detail_pegawai',$data);
    }

    function ajax_req_recruitment($ktp){

        $data = $this->m_calonkaryawan->q_linkinputkaryawan($ktp)->row_array();
        echo json_encode($data);

    }

    function ajax_cekktpkembar($noktp){

        $data = $this->m_calonkaryawan->q_ajaxktp($noktp)->num_rows();
        echo json_encode($data);
        //echo 'tae';
    }
    public function excel_karyborong(){

        $datane=$this->m_karyawan->list_karyborong();
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nik','Nama lengkap','Panggilan','kelamin','Negara lahir','Prov lahir','Kota lahir','Tgllahir','Kode Agama','No ktp',
            'Status Pernikahan','Golongan Darah','Negara','Provinsi','Kota',
            'Kecamatan','Kelurahan','Alamat','No HP1','No HP2','NPWP','TGL NPWP','Bagian','Sub Bagian','Jabatan','Lvl Jabatan','Grade golongan','Atasan1','Atasan2','Status PTKP',
            'Besaran PTKP','Tgl masuk kerja','Tgl keluar kerja','Masakerja','Status kepegawaian','Group penggajian','Gaji pokok','Gaji bpjs','Bank','Nama pemilik rekening','no rekening','Shift','ID absen','Email',
            'Sisa Cuti','id mesin','Card number','Status','Cost center','tj tetap','Gaji tetap','Gaji naker','Borong'
        ));



        $this->excel_generator->set_column(array('nik','nmlengkap','callname','jk','neglahir','provlahir','kotalahir','tgllahir','kd_agama','noktp',
            'status_pernikahan','gol_darah','negtinggal','provtinggal','kotatinggal',
            'kectinggal','keltinggal','alamattinggal','nohp1','nohp2','npwp','tglnpwp','bag_dept','subbag_dept','jabatan','lvl_jabatan','grade_golongan','nik_atasan','nik_atasan2','status_ptkp',
            'besaranptkp','tglmasukkerja','tglkeluarkerja','masakerja','statuskepegawaian','grouppenggajian','gajipokok','gajibpjs','namabank','namapemilikrekening','norek','tjshift','idabsen','email',
            'sisacuti','idmesin','cardnumber','status','costcenter','tj_tetap','gajitetap','gajinaker','tjborong'
        ));

        $this->excel_generator->set_width(array(10,20,20,20,20,20,20,20,20,20,
            20,20,20,20,20,
            10,20,20,20,20,20,20,20,20,20,20,20,20,20,20,
            10,20,20,20,20,20,20,20,20,20,20,20,20,20,
            20,20,20,20,20,20,20,20,7
        ));
        $this->excel_generator->exportTo2007('Master Karyawan Borong');
    }

    /* MUTASI */
    function simpanmutasi (){
        $type=trim($this->input->post('type'));
        $nik=trim($this->input->post('newnik'));
        $newkddept=strtoupper(trim($this->input->post('newkddept')));
        $newkdsubdept=strtoupper(trim($this->input->post('newkdsubdept')));
        $newkdjabatan=strtoupper(trim($this->input->post('newkdjabatan')));
        $newkdlevel=strtoupper(trim($this->input->post('newkdlevel')));
        $newnikatasan=strtoupper(trim($this->input->post('newnikatasan')));
        $newnikatasan2=strtoupper(trim($this->input->post('newnikatasan2')));
        $nosk=strtoupper(trim($this->input->post('nodoksk')));
        $tglsk=strtoupper(trim($this->input->post('tglsk')));
        $tglmemo=strtoupper(trim($this->input->post('tglmemo')));
        $tglefektif=strtoupper(trim($this->input->post('tglefektif')));
        $ket=strtoupper(trim($this->input->post('ket')));
        $info=array(
            'nik'=>$nik,
            'newkddept'=>$newkddept,
            'newkdsubdept'=>$newkdsubdept,
            'newkdjabatan'=>$newkdjabatan,
            'newkdlevel'=>$newkdlevel,
            'newnikatasan'=>$newnikatasan,
            'newnikatasan2'=>$newnikatasan2,
            'nodoksk'=>$nosk,
            'tglsk'=>$tglsk,
            'tglmemo'=>$tglmemo,
            'tglefektif'=>$tglefektif,
            'ket'=>$ket,
            'inputdate'=>date('Y-m-d H:i:s'),
            'inputby'=>$this->session->userdata('nik')
        );

        $this->db->insert('sc_tmp.mutasi',$info);
        redirect("trans/karyawan/detail/$nik/success");

    }

    function deletemutasi($id,$nik){
        $this->db->where('nik',$nik);
        $this->db->where('nodokumen',$id);
        $this->db->delete('sc_mst.mutasi');
        redirect("trans/karyawan/detail/$nik/success");
    }
    function approvemutasi($id,$nik){
        $this->db->query("update sc_mst.mutasi set status='P' where nodokumen='$id' and nik='$nik'");
        redirect("trans/karyawan/detail/$nik/success");
    }

    /*ADD MUTASI & PROMOSI KARYAWAN*/

    function add_stspeg(){
        $nik1=explode('|',$this->input->post('nik'));
        $nik=trim($this->input->post('nik'));
        $nosk=$this->input->post('noskstspeg');
        $kdkepegawaian=$this->input->post('kdkepegawaian');
        $tgl_mulai=$this->input->post('tgl_mulai');
        $tgl_selesai=$this->input->post('tgl_selesai');
        if ($tgl_mulai==''){
            $tgl_mulai=null;
        }
        if ($tgl_selesai==''){
            $tgl_selesai=null;
        }
        $cuti=$this->input->post('cuti');
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');

        //echo $sub;
        $info=array(
            'nik'=>$nik,
            'nodok'=>$this->session->userdata('nik'),
            'nosk'=>$nosk,
            'kdkepegawaian'=>strtoupper($kdkepegawaian),
            'tgl_mulai'=>$tgl_mulai,
            'tgl_selesai'=>$tgl_selesai,
            'cuti'=>strtoupper($cuti),
            'keterangan'=>strtoupper($keterangan),
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );

        $this->db->insert('sc_tmp.status_kepegawaian',$info);
        redirect("trans/karyawan/detail/$nik/success");
        //echo $inputby;
    }

    function editview_stspeg($nik,$no_urut){
        //echo "test";

        if (empty($no_urut)){
            redirect("trans/stspeg/index/$nik");
        } else {
            $data['title']='EDIT DATA RIWAYAT KELUARGA';
            if($this->uri->segment(5)=="upsuccess"){
                $data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
            }
            else {
                $data['message']='';
            }
            $nik=$this->uri->segment(4);
            $data['nik']=$nik;
            $data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
            $data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
            $data['list_bpjskaryawan']=$this->m_bpjs->q_bpjs_karyawan()->result();
            $data['list_faskes']=$this->m_bpjs->list_faskes()->result();
            $data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
            $data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
            $data['list_keluarga']=$this->m_stspeg->list_keluarga()->result();
            $data['list_negara']=$this->m_stspeg->list_negara()->result();
            $data['list_prov']=$this->m_stspeg->list_prov()->result();
            $data['list_tgl_mulai']=$this->m_stspeg->list_tgl_mulai()->result();
            $data['list_jenjang_kepegawaian']=$this->m_stspeg->list_jenjang_kepegawaian()->result();
            $data['list_rk']=$this->m_stspeg->q_stspeg_edit($nik,$no_urut)->row_array();
            $this->template->display('trans/stspeg/v_edit',$data);
        }
    }

    function detail_stspeg($nik,$no_urut){
        //echo "test";

        if (empty($no_urut)){
            redirect("trans/stspeg/index/$nik");
        } else {
            $data['title']='DETAIL DATA RIWAYAT KELUARGA';
            if($this->uri->segment(5)=="upsuccess"){
                $data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
            }
            else {
                $data['message']='';
            }
            $nik=$this->uri->segment(4);
            $data['nik']=$nik;
            $data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
            $data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
            $data['list_bpjskaryawan']=$this->m_bpjs->q_bpjs_karyawan()->result();
            $data['list_faskes']=$this->m_bpjs->list_faskes()->result();
            $data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
            $data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
            $data['list_keluarga']=$this->m_stspeg->list_keluarga()->result();
            $data['list_negara']=$this->m_stspeg->list_negara()->result();
            $data['list_prov']=$this->m_stspeg->list_prov()->result();
            $data['list_tgl_mulai']=$this->m_stspeg->list_tgl_mulai()->result();
            $data['list_jenjang_kepegawaian']=$this->m_stspeg->list_jenjang_kepegawaian()->result();
            $data['list_rk']=$this->m_stspeg->q_stspeg_edit($nik,$no_urut)->row_array();
            $this->template->display('trans/stspeg/v_detail',$data);
        }
    }
    function edit_stspeg(){
        //$nik1=explode('|',);
        $nodok=$this->input->post('nodok');
        $nik=$this->input->post('nik');
        $kdkepegawaian=$this->input->post('kdkepegawaian');
        $tgl_selesai=$this->input->post('tgl_selesai');

        if ($tgl_selesai==''){
            $tgl_selesai=null;
        }

        $cuti=$this->input->post('cuti');
        $tgl_mulai=$this->input->post('tgl_mulai');
        if ($tgl_mulai==''){
            $tgl_mulai=null;
        }
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');
        //$no_urut=$this->input->post('no_urut');

        $info=array(
            'kdkepegawaian'=>strtoupper($kdkepegawaian),
            'tgl_mulai'=>($tgl_mulai),
            'tgl_selesai'=>($tgl_selesai),
            'cuti'=>strtoupper($cuti),
            'keterangan'=>strtoupper($keterangan),
            'update_date'=>$tgl_input,
            'update_by'=>strtoupper($inputby),
        );
        //$this->db->where('custcode',$kode);


        $this->db->where('nodok',$nodok);
        $this->db->where('nik',$nik);
        //$this->db->where('kdkepegawaian',$kdkepegawaian);
        $this->db->update('sc_trx.status_kepegawaian',$info);
        redirect("trans/stspeg/index/$nik/rep_succes");

        //echo $inputby;
    }

    function hps_stspeg($nik,$nodok){
        $this->db->where('nodok',$nodok);
        $this->db->delete('sc_trx.status_kepegawaian');
        redirect("trans/stspeg/index/$nik/del_succes");
    }

    /* ---------------------ADD BPJS KARYAWAN ------------------------*/

    function add_bpjs(){
        $id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
        //$nmbpjs=$this->input->post('nmbpjs');
        //$kdsubdept=$this->input->post('kdsubdept');
        //$subdept=explode('|',$this->input->post('kdsubdept'));
        //$sub=$subdept[1];
        //$kode_bpjs1=explode('|',);
        $kode_bpjs=strtoupper($this->input->post('kode_bpjs'));
        //$kodekomponen1=explode('|',;
        $kodekomponen=strtoupper($this->input->post('kodekomponen'));
        //$kodefaskes1=explode
        $kodefaskes=strtoupper($this->input->post('kodefaskes'));
        //$kodefaskes3=explode('|',;
        $kodefaskes2=strtoupper($this->input->post('kodefaskes2'));
        $nik=$this->input->post('nik');
        $kelas=$this->input->post('kelas');
        $keterangan=$this->input->post('keterangan');
        $tgl_berlaku=$this->input->post('tgl_berlaku');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');


        //echo $sub;
        $info=array(
            'id_bpjs'=>$id_bpjs,
            'kode_bpjs'=>$kode_bpjs,
            'kodekomponen'=>$kodekomponen,
            'kodefaskes'=>$kodefaskes,
            'kodefaskes2'=>$kodefaskes2,
            'nik'=>$nik,
            'kelas'=>strtoupper($kelas),
            'keterangan'=>strtoupper($keterangan),
            'tgl_berlaku'=>$tgl_berlaku,
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );

        $cek=$this->m_bpjs->q_cek_bpjs($kode_bpjs,$nik,$kodekomponen,$id_bpjs)->num_rows();
        if ($cek>0){
            redirect("trans/karyawan/detail/$nik/kode_failed");;
        } else {
            $this->db->insert('sc_trx.bpjs_karyawan',$info);
            redirect("trans/karyawan/detail/$nik/success");
        }

    }

    function edit_bpjs(){
        $id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
        //$nmbpjs=$this->input->post('nmbpjs');
        //$kdsubdept=$this->input->post('kdsubdept');
        //$subdept=explode('|',$this->input->post('kdsubdept'));
        //$sub=$subdept[1];
        //$kode_bpjs1=explode('|',);
        $kode_bpjs=strtoupper($this->input->post('kode_bpjs'));
        //$kodekomponen1=explode('|',;
        $kodekomponen=strtoupper($this->input->post('kodekomponen'));
        //$kodefaskes1=explode
        $kodefaskes=strtoupper($this->input->post('kodefaskes'));
        //$kodefaskes3=explode('|',;
        $kodefaskes2=strtoupper($this->input->post('kodefaskes2'));
        $nik=$this->input->post('nik');
        $kelas=$this->input->post('kelas');
        $keterangan=$this->input->post('keterangan');
        $tgl_berlaku=$this->input->post('tgl_berlaku');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');
        $info=array(
            'kode_bpjs'=>$kode_bpjs,
            'kodekomponen'=>$kodekomponen,
            'kodefaskes'=>$kodefaskes,
            'kodefaskes2'=>$kodefaskes2,
            'nik'=>$nik,
            'kelas'=>strtoupper($kelas),
            'keterangan'=>strtoupper($keterangan),
            'tgl_berlaku'=>$tgl_berlaku,
            'update_date'=>$tgl_input,
            'update_by'=>strtoupper($inputby),
        );
        //$this->db->where('custcode',$kode);

        $this->db->where('nik',$nik);
        $this->db->where('kode_bpjs',$kode_bpjs);
        $this->db->where('kodekomponen',$kodekomponen);
        $this->db->where('id_bpjs',$id_bpjs);
        $this->db->update('sc_trx.bpjs_karyawan',$info);
        redirect("trans/karyawan/detail/$nik/success");

    }

    function hps_bpjs($nik,$id_bpjs){

        $this->db->where('id_bpjs',$id_bpjs);
        $this->db->delete('sc_trx.bpjs_karyawan');
        redirect("trans/karyawan/detail/$nik/del_success");
    }


    function karyawan_self(){
        $data['title']='Profile Karyawan';
        $nama=$this->session->userdata('nik');
        $id=$nama;
        $data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
        $data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
        $data['list_opt_agama']=$this->m_agama->q_agama()->result();
        $data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
        $data['list_chainjobgrade']=$this->m_jabatan->chain_jobgrade()->result();//
        $data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
        $data['list_opt_ptkp']=$this->m_bpjs->list_ptkp()->result();
        //$data['list_opt_ptkp']=$this->m_karyawan->list_ptkp()->result();
        $data['list_opt_grp_gaji']=$this->m_group_penggajian->q_group_penggajian()->result();
        $data['list_opt_bank']=$this->m_bank->q_bank()->result();
        $data['list_resignkary']=$this->m_karyawan->list_karyresgn()->result();//
        $data['list_borong']=$this->m_karyawan->list_karyborong()->result();//
        $data['calon_karyawan']=$this->m_calonkaryawan->q_maxktpcalon()->result();//
        $data['list_finger']=$this->m_karyawan->q_finger()->result();//
        $data['list_kanwil']=$this->m_karyawan->q_kanwil()->result();//
        $data['list_self']=$this->m_karyawan->get_dtl_id($id)->result();

        if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
        }
        else if($this->uri->segment(4)=="success"){
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
        }
        else if($this->uri->segment(4)=="upsuccess"){
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate </div>";
        }
        else if($this->uri->segment(4)=="notacces"){
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
        }
        else if($this->uri->segment(4)=="del"){
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
        }
        else if($this->uri->segment(4)=="del_exist"){
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
        }
        else {
            $data['message']='';
        }


        $this->template->display('trans/karyawan/v_karyawan_self',$data);
    }

    function detail_self($id)
    {
        $nik=$this->uri->segment(4);
        $data['message']='';
        $data['list_opt_agama']=$this->m_agama->q_agama()->result();
        $data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
        $data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
        $data['list_opt_ptkp']=$this->m_bpjs->list_ptkp()->result();
        $data['list_opt_grp_gaji']=$this->m_group_penggajian->q_group_penggajian()->result();
        $data['list_opt_bank']=$this->m_bank->q_bank()->result();
        $data['list_riwayat_keluarga']=$this->m_riwayat_keluarga->q_riwayat_keluarga($nik,$no_urut=null)->result();
        $data['list_riwayat_kesehatan']=$this->m_riwayat_kesehatan->q_riwayat_kesehatan($nik)->result();
        $data['list_riwayat_pengalaman']=$this->m_riwayat_pengalaman->q_riwayat_pengalaman($nik)->result();
        $data['list_riwayat_pendidikan']=$this->m_riwayat_pendidikan->q_riwayat_pendidikan($nik)->result();
        $data['list_finger']=$this->m_karyawan->q_finger()->result();//
        $data['list_kanwil']=$this->m_karyawan->q_kanwil()->result();//

        /*MUTASI*/
        //$data['list_karyawan']=$this->m_mutpromot->list_karyawan()->result();
        $data['list_karyawan']=$this->m_mutpromot->list_nik($id)->result();
        $data['list_mutasi']=$this->m_mutpromot->get_mutasinik($id)->result();
        /*END MUTASI*/
        /*STATUS KEPEGAWAIN*/
        $data['list_lk']=$this->m_stspeg->list_karyawan_index($id)->row_array();
        $data['list_kepegawaian']=$this->m_stspeg->list_kepegawaian()->result();
        $data['list_stspeg']=$this->m_stspeg->q_stspeg($id)->result();
        $data['list_spg']=$this->m_stspeg->q_stspeg($id)->row_array();
        /**/
        /*BPJS KARYAWAN*/
        $data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();
        $data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
        $data['list_bpjskaryawan']=$this->m_bpjs->list_bpjs_karyawan($id)->result();
        $data['list_faskes']=$this->m_bpjs->list_faskes()->result();
        $data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
        $data['list_karyawan_bpjs']=$this->m_bpjs->list_karyawan()->result();
        $data['list_lk']=$this->m_bpjs->list_karyawan_index($id)->row_array();


        $data['title'] = "Detail Karyawan";
        //$data['dtl'] = $this->m_karyawan->get_dtl_id($id)->row_array();
        $data['lp'] = $this->m_karyawan->get_dtl_id($id)->row_array();
        $this->template->display('trans/karyawan/v_detailhrdkary_self',$data);
    }
    function edit_self($id)
    {
        $data['message']='';
        $data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
        $data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
        $data['list_opt_kotakab']=$this->m_geo->list_opt_kotakab()->result();
        $data['list_opt_kec']=$this->m_geo->list_opt_kec()->result();
        //$data['list_opt_keldesa']=$this->m_geo->list_opt_keldesa()->result();
        $data['list_opt_agama']=$this->m_agama->q_agama()->result();
        $data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $data['list_opt_goljabt']=$this->m_jabatan->q_jobgrade()->result();
        $data['list_opt_atasan']=$this->m_karyawan->list_karyawan()->result();
        $data['list_opt_ptkp']=$this->m_bpjs->list_ptkp()->result();
        $data['list_opt_grp_gaji']=$this->m_group_penggajian->q_group_penggajian()->result();
        $data['list_opt_bank']=$this->m_bank->q_bank()->result();
        $data['list_finger']=$this->m_karyawan->q_finger()->result();//
        $data['list_kanwil']=$this->m_karyawan->q_kanwil()->result();//
        $data['title'] = "Edit Karyawan";
        $data['dtl'] = $this->m_karyawan->get_by_id($id)->row_array();
        $this->template->display('trans/karyawan/v_editkary_self',$data);
    }

    function update_self_person(){
        $nik=trim($this->input->post('nik'));
        $nohp1=trim($this->input->post('nohp1'));
        $nohp2=trim($this->input->post('nohp2'));
        $email=trim($this->input->post('email'));
        $info=array(
            'nohp1'=>$nohp1,
            'nohp2'=>$nohp2,
            'email'=>$email
        );
        $this->db->where('nik',$nik);
        $this->db->update('sc_mst.karyawan',$info);
        redirect("trans/karyawan/karyawan_self/upsuccess");
    }

    function add_riwayat_keluarga(){
        $nik1=explode('|',$this->input->post('nik'));
        $nik=$nik1[0];
        $kdkeluarga=$this->input->post('kdkeluarga');
        $nama=$this->input->post('nama');
        $kelamin=$this->input->post('kelamin');
        $kodenegara=$this->input->post('kodenegara');
        $kodeprov=$this->input->post('kodeprov');
        $kodekotakab=$this->input->post('kodekotakab');
        $tgl_lahir=$this->input->post('tgl_lahir');
        $kdjenjang_pendidikan=$this->input->post('kdjenjang_pendidikan');
        $pekerjaan=$this->input->post('pekerjaan');
        $status_hidup=$this->input->post('status_hidup');
        $status_tanggungan=$this->input->post('status_tanggungan');
        $npwp_tgl1=$this->input->post('npwp_tgl');
        if ($npwp_tgl1==''){
            $npwp_tgl=NULL;
        } else {
            $npwp_tgl=$npwp_tgl1;
        }
        $id_bpjs=trim(strtoupper(str_replace(" ","",$this->input->post('id_bpjs'))));
        $no_npwp1=str_replace("_","",$this->input->post('no_npwp'));
        if ($no_npwp1==''){
            $no_npwp=NULL;
        } else {
            $no_npwp=$no_npwp1;
        }
        $kode_bpjs1=explode('|',$this->input->post('kode_bpjs'));
        $kode_bpjs=$kode_bpjs1[0];
        $kodekomponen1=explode('|',$this->input->post('kodekomponen'));
        $kodekomponen=$kodekomponen1[0];
        $kodefaskes1=explode('|',$this->input->post('kodefaskes'));
        $kodefaskes=$kodefaskes1[0];
        $kodefaskes3=explode('|',$this->input->post('kodefaskes2'));
        $kodefaskes2=$kodefaskes3[0];
        $kelas=$this->input->post('kelas');
        $keterangan=$this->input->post('keterangan');
        $tgl_berlaku1=$this->input->post('tgl_berlaku');
        if ($tgl_berlaku1==''){
            $tgl_berlaku=NULL;
        } else {
            $tgl_berlaku=$tgl_berlaku1;
        }
        $tgl_input=date('Y-m-d');
        $inputby=$this->session->userdata('nik');
        if (empty($kdkeluarga)){
            redirect("trans/karyawan/index/");
        }

        $info=array(
            'nik'=>$nik,
            'kdkeluarga'=>$kdkeluarga,
            'nama'=>strtoupper($nama),
            'kelamin'=>$kelamin,
            'kodenegara'=>$kodenegara,
            'kodeprov'=>$kodeprov,
            'kodekotakab'=>$kodekotakab,
            'tgl_lahir'=>$tgl_lahir,
            'kdjenjang_pendidikan'=>$kdjenjang_pendidikan,
            'pekerjaan'=>strtoupper($pekerjaan),
            'status_hidup'=>strtoupper($status_hidup),
            'status_tanggungan'=>strtoupper($status_tanggungan),
            'no_npwp'=>$no_npwp,
            'npwp_tgl'=>$npwp_tgl,
            'id_bpjs'=>$id_bpjs,
            'kode_bpjs'=>$kode_bpjs,
            'kodekomponen'=>$kodekomponen,
            'kodefaskes'=>$kodefaskes,
            'kodefaskes2'=>$kodefaskes2,
            'kelas'=>strtoupper($kelas),
            'keterangan'=>strtoupper($keterangan),
            'tgl_berlaku'=>$tgl_berlaku,
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );

        $this->db->insert('sc_trx.riwayat_keluarga',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");


    }

    function add_riwayat_kesehatan(){
        $nik=$this->input->post('nik');
        $kdpenyakit=$this->input->post('kdpenyakit');
        $periode=$this->input->post('periode');
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');
        $info=array(
            'nik'=>$nik,
            'kdpenyakit'=>strtoupper($kdpenyakit),
            'periode'=>$periode,
            'keterangan'=>strtoupper($keterangan),
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );
        $this->db->insert('sc_trx.riwayat_kesehatan',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }

    function edit_riwayat_kesehatan(){
        $nik=$this->input->post('nik');
        $kdpenyakit=$this->input->post('kdpenyakit');
        $periode=$this->input->post('periode');
        $keterangan=$this->input->post('keterangan');
        $inputby=$this->input->post('inputby');
        $no_urut=$this->input->post('no_urut');

        $info=array(
            'kdpenyakit'=>strtoupper($kdpenyakit),
            'periode'=>strtoupper($periode),
            'keterangan'=>strtoupper($keterangan),
            'update_date'=>$tgl_input,
            'update_by'=>strtoupper($inputby),
        );
        $this->db->where('nik',$nik);
        $this->db->where('no_urut',$no_urut);
        $this->db->update('sc_trx.riwayat_kesehatan',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }

    function hps_riwayat_kesehatan($nik,$no_urut){
        $this->db->where('nik',$nik);
        $this->db->where('no_urut',$no_urut);
        $this->db->delete('sc_trx.riwayat_kesehatan');
        redirect("trans/karyawan/detail/$nik/del_succes");
    }

    function add_riwayat_pengalaman(){

        $nik=$this->input->post('nik');
        $nmperusahaan=$this->input->post('nmperusahaan');
        $bidang_usaha=$this->input->post('bidang_usaha');
        $tahun_masuk=$this->input->post('tahun_masuk');
        $tahun_keluar=$this->input->post('tahun_keluar');
        $bagian=$this->input->post('bagian');
        $jabatan=$this->input->post('jabatan');
        $nmatasan=$this->input->post('nmatasan');
        $jbtatasan=$this->input->post('jbtatasan');
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');

        $info=array(
            'nik'=>$nik,
            'nmperusahaan'=>strtoupper($nmperusahaan),
            'bidang_usaha'=>strtoupper($bidang_usaha),
            'bagian'=>strtoupper($bagian),
            'jabatan'=>strtoupper($jabatan),
            'nmatasan'=>strtoupper($nmatasan),
            'jbtatasan'=>strtoupper($jbtatasan),
            'tahun_masuk'=>$tahun_masuk,
            'tahun_keluar'=>$tahun_keluar,
            'keterangan'=>strtoupper($keterangan),
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );

        $this->db->insert('sc_trx.riwayat_pengalaman',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }

    function edit_riwayat_pengalaman(){
        $nik=$this->input->post('nik');
        $nmperusahaan=$this->input->post('nmperusahaan');
        $bidang_usaha=$this->input->post('bidang_usaha');
        $tahun_masuk=$this->input->post('tahun_masuk');
        $tahun_keluar=$this->input->post('tahun_keluar');
        $bagian=$this->input->post('bagian');
        $jabatan=$this->input->post('jabatan');
        $nmatasan=$this->input->post('nmatasan');
        $jbtatasan=$this->input->post('jbtatasan');
        $keterangan=$this->input->post('keterangan');
        $inputby=$this->input->post('inputby');
        $no_urut=$this->input->post('no_urut');

        $info=array(
            'nmperusahaan'=>strtoupper($nmperusahaan),
            'bidang_usaha'=>strtoupper($bidang_usaha),
            'bagian'=>strtoupper($bagian),
            'jabatan'=>strtoupper($jabatan),
            'nmatasan'=>strtoupper($nmatasan),
            'jbtatasan'=>strtoupper($jbtatasan),
            'tahun_masuk'=>$tahun_masuk,
            'tahun_keluar'=>$tahun_keluar,
            'keterangan'=>strtoupper($keterangan),
            'update_date'=>$tgl_input,
            'update_by'=>strtoupper($inputby),
        );
        $this->db->where('nik',$nik);
        $this->db->where('no_urut',$no_urut);
        $this->db->update('sc_trx.riwayat_pengalaman',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }

    function hps_riwayat_pengalaman($nik,$no_urut){
        $this->db->where('nik',$nik);
        $this->db->where('no_urut',$no_urut);
        $this->db->delete('sc_trx.riwayat_pengalaman');
        redirect("trans/karyawan/detail/$nik/del_succes");
    }


    function add_riwayat_pendidikan_nf(){

        $nik=$this->input->post('nik');
        $kdkeahlian=$this->input->post('kdkeahlian');
        $nmkursus=$this->input->post('nmkursus');
        $nminstitusi=$this->input->post('nminstitusi');
        $tahun_masuk=str_replace("_","",$this->input->post('tahun_masuk'));
        $tahun_keluar=str_replace("_","",$this->input->post('tahun_keluar'));
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');

        $info=array(
            'nik'=>$nik,
            'kdkeahlian'=>$kdkeahlian,
            'nmkursus'=>strtoupper($nmkursus),
            'nminstitusi'=>strtoupper($nminstitusi),
            'tahun_keluar'=>strtoupper($tahun_keluar),
            'tahun_masuk'=>strtoupper($tahun_masuk),
            'keterangan'=>strtoupper($keterangan),
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );

        $this->db->insert('sc_trx.riwayat_pendidikan_nf',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }

    function edit_riwayat_pendidikan_nf(){

        $nik=$this->input->post('nik');
        $kdkeahlian=$this->input->post('kdkeahlian');
        $nmkursus=$this->input->post('nmkursus');
        $nminstitusi=$this->input->post('nminstitusi');
        $tahun_masuk=str_replace("_","",$this->input->post('tahun_masuk'));
        $tahun_keluar=str_replace("_","",$this->input->post('tahun_keluar'));
        $keterangan=$this->input->post('keterangan');
        $inputby=$this->input->post('inputby');
        $no_urut=$this->input->post('no_urut');

        $info=array(
            'nmkursus'=>strtoupper($nmkursus),
            'kdkeahlian'=>strtoupper($kdkeahlian),
            'nminstitusi'=>strtoupper($nminstitusi),
            'tahun_keluar'=>strtoupper($tahun_keluar),
            'tahun_masuk'=>strtoupper($tahun_masuk),
            'keterangan'=>strtoupper($keterangan),
            'update_date'=>$tgl_input,
            'update_by'=>strtoupper($inputby),
        );

        $this->db->where('no_urut',$no_urut);
        $this->db->update('sc_trx.riwayat_pendidikan_nf',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");
    }

    function hps_riwayat_pendidikan_nf($nik,$no_urut){
        $this->db->where('no_urut',$no_urut);
        $this->db->delete('sc_trx.riwayat_pendidikan_nf');
        redirect("trans/karyawan/detail/$nik/del_succes");
    }

    function add_riwayat_pendidikan(){

        $nik=$this->input->post('nik');
        $kdpendidikan=$this->input->post('kdpendidikan');
        $nmsekolah=$this->input->post('nmsekolah');
        $jurusan=$this->input->post('jurusan');
        $program_studi=$this->input->post('program_studi');
        $kodeprov=$this->input->post('kodeprov');
        $kotakab=$this->input->post('kotakab');
        $tahun_masuk=str_replace("_","",$this->input->post('tahun_masuk'));
        $tahun_keluar=str_replace("_","",$this->input->post('tahun_keluar'));
        $nilai=$this->input->post('nilai');
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');

        $info=array(
            'nik'=>$nik,
            'kdpendidikan'=>$kdpendidikan,
            'nmsekolah'=>strtoupper($nmsekolah),
            'kotakab'=>strtoupper($kotakab),
            'jurusan'=>strtoupper($jurusan),
            'program_studi'=>strtoupper($program_studi),
            'nilai'=>strtoupper($nilai),
            'tahun_keluar'=>strtoupper($tahun_keluar),
            'tahun_masuk'=>strtoupper($tahun_masuk),
            'keterangan'=>strtoupper($keterangan),
            'input_date'=>$tgl_input,
            'input_by'=>strtoupper($inputby),
        );

        $this->db->insert('sc_trx.riwayat_pendidikan',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }
    function edit_riwayat_pendidikan(){
        $nik=$this->input->post('nik');
        $kdpendidikan=$this->input->post('kdpendidikan');
        $nmsekolah=$this->input->post('nmsekolah');
        $jurusan=$this->input->post('jurusan');
        $program_studi=$this->input->post('program_studi');
        $kodeprov=$this->input->post('kodeprov');
        $kotakab=$this->input->post('kotakab');
        $tahun_masuk=str_replace("_","",$this->input->post('tahun_masuk'));
        $tahun_keluar=str_replace("_","",$this->input->post('tahun_keluar'));
        $nilai=$this->input->post('nilai');
        $keterangan=$this->input->post('keterangan');
        $tgl_input=$this->input->post('tgl');
        $inputby=$this->input->post('inputby');
        $no_urut=$this->input->post('no_urut');

        $info=array(
            'nmsekolah'=>strtoupper($nmsekolah),
            'kotakab'=>strtoupper($kotakab),
            'jurusan'=>strtoupper($jurusan),
            'program_studi'=>strtoupper($program_studi),
            'nilai'=>strtoupper($nilai),
            'tahun_keluar'=>strtoupper($tahun_keluar),
            'tahun_masuk'=>strtoupper($tahun_masuk),
            'keterangan'=>strtoupper($keterangan),
            'update_date'=>$tgl_input,
            'update_by'=>strtoupper($inputby),
        );

        $this->db->where('no_urut',$no_urut);
        $this->db->update('sc_trx.riwayat_pendidikan',$info);
        redirect("trans/karyawan/detail/$nik/rep_succes");

    }

    function hps_riwayat_pendidikan($nik,$no_urut){
        $this->db->where('no_urut',$no_urut);
        $this->db->delete('sc_trx.riwayat_pendidikan');
        redirect("trans/karyawan/detail/$nik/del_succes");
    }

    function get_provinsi() {
        $kodenegara = $this->input->post("kodenegara");
        echo json_encode($this->m_geo->list_opt_prov("WHERE kodenegara = '$kodenegara'")->result());
    }

    function get_kotakab() {
        $kodeprov = $this->input->post("kodeprov");
        echo json_encode($this->m_geo->list_opt_kotakab("WHERE kodeprov = '$kodeprov'")->result());
    }

    function get_kec() {
        $kodekotakab = $this->input->post("kodekotakab");
        echo json_encode($this->m_geo->list_opt_kec("WHERE kodekotakab = '$kodekotakab'")->result());
    }

    function get_keldesa() {
        $kodekec = $this->input->post("kodekec");
        echo json_encode($this->m_geo->list_opt_keldesa("WHERE kodekec = '$kodekec'")->result());
    }

    function get_subdept() {
        $kddept = $this->input->post("kddept");
        echo json_encode($this->m_department->q_subdepartment("WHERE a.kddept = '$kddept'")->result());
    }

    function get_jabatan() {
        $kddept = $this->input->post("kddept");
        $kdsubdept = $this->input->post("kdsubdept");
        echo json_encode($this->m_jabatan->q_jabatan("WHERE a.kddept = '$kddept' AND a.kdsubdept = '$kdsubdept'")->result());
    }

    function get_grade_golongan() {
        $kdlvl = $this->input->post("kdlvl");
        echo json_encode($this->m_jabatan->q_jobgrade("WHERE a.kdlvl = '$kdlvl'")->result());
    }

    function get_kdlvlgp() {
        $kdgrade = $this->input->post("kdgrade");
        echo json_encode($this->m_jabatan->q_lvlgp(" AND b.kdgrade = '$kdgrade'")->result());
    }

    public function createUser($nik = null, $password= null){
        $this->load->library(array('generatepassword'));
        $this->load->model(array('master/m_option','master/m_user','master/M_UserSidia','master/M_Branch',));
        $employee = $this->m_karyawan->q_karyawan_read('TRUE AND trim(nik) = \'' . trim($nik) . '\' ')->row();
        $branchDefault = $this->M_Branch->q_master_read_where(' AND cdefault = \'YES\' ')->row();
        $defaultAccess = $this->m_option->q_cekoption(trim('DEFACS'))->row()->value1;
        $menu = ($defaultAccess ? explode('/',$defaultAccess) : array('I.T.B.4d', 'I.T.B.16', 'I.T.A.15') );
        $passwordGenerate = $this->generatepassword->sidia(trim($employee->nik), TRUE);
        /*Notification::begin*/
        $search = array('[fullname]', '[companyName]', '[appname1]', '[username1]', '[password1]','[appname2]', '[username2]', '[password2]','[appname3]', '[username3]', '[password3]', );
        $replace = array(trim($employee->nmlengkap), $branchDefault->branchname, 'HRMS', trim($employee->nik), trim($employee->nik), 'Mobile', trim($employee->nik), trim($employee->nik), 'Sidia', trim($employee->nik), trim($employee->nik));
        $mailMessage = str_replace($search, $replace, $this->load->view('template/mailmessage/account_information',array(), true));
        /*Notification::end*/
        try {
            $this->db->trans_start();
            $this->m_user->q_user_create(array(
                'branch' => trim($employee->kdcabang),
                'nik' => trim($employee->nik),
                'username' => trim($employee->nik),
                'passwordweb' => md5(trim($employee->nik)),
                'level_id' => trim($employee->lvl_jabatan),
                'level_akses' => trim($employee->lvl_jabatan),
                'expdate' => date('Y-m-d', strtotime(' + 1 years')),
                'hold_id' => 'N',
                'image' => 'admin.jpg',
                'loccode' => trim($employee->kdcabang),
                'inputdate' => date('d-m-Y'),
                'inputby' => $this->session->userdata('nik')
            ));
            foreach ($menu as $row) {
                $this->m_akses->q_akses_create(array(
                    'nik' => trim($employee->nik),
                    'kodemenu' => $row,
                    'hold_id' => true,
                    'aksesview' => true,
                    'aksesinput' => true,
                    'aksesupdate' => true,
                    'aksesdelete' => true,
                    'aksesapprove' => true,
                    'aksesconvert' => true,
                    'aksesprint' => true,
                    'aksesdownload' => true,
                    'aksesapprove2' => true,
                    'aksesapprove3' => true,
                    'aksesfilter' => true,
                    'username' => trim($employee->nik),
                ));
            }
            $this->M_UserSidia->q_transaction_create(array(
                'branch' => (!empty($employee->branch) ? $employee->branch : $branchDefault->branch),
                'nik' => $employee->nik,
                'userid' => $employee->nik,
                'usersname' => trim($employee->callname),
                'userlname' => trim($employee->callname),
                'password' => $passwordGenerate,
                'groupuser' => 'IT',
                'level' => 'E',
                'location' => 'JA',
                'divisi' => 'AC',
                'hold' => 'Yes',
                'expdate' => date('Y-m-d H:i:s', strtotime('+1 years')),
                'inputdate' => date('Y-m-d H:i:s'),
                'inputby' => trim($this->session->userdata('nik')),
                'email' => $employee->email,
            ));

            $info = array(
                'docno' => $employee->nik,
                'doctype' => 'ACCOUNT',
                'erptype' => 'HRMS',
                'send_date' => date('Y-m-d H:i:s'),
                'doctypename' => 'ACCOUNT INFORMATION',
                'mailto' => $employee->email,
                'mailsender' =>'noreply_nusa@nusaboard.co.id',
                'mailsubject' => 'Informasi akun karyawan',
                'mailtype' => 'html',
                'mailmessage' => $mailMessage,
                'sentby' => 'SYSTEM',
                'mailstatus' => 'NO_SENT',
            );
            if (!empty ($employee->email)) {
                $this->db->insert('public.mail_outbox', $info);
            }
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                return true;
            } else {
                throw new Exception("Error DB", 1);
                return false;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
        }
    }

    public function actionaccountpopup($param)
    {
        $json = json_decode(hex2bin($param));
        $employee = $this->m_karyawan->q_karyawan_read('TRUE AND trim(nik) = \'' . trim($json->nik) . '\' ')->row();
        header('Content-Type: application/json');
        switch (strtolower($this->input->get_post('action'))) {
            case 'read':
                echo json_encode(array(
                    'data' => array(),
                    'canread' => true,
                    'next' => site_url('trans/karyawan/accountread/' . bin2hex(json_encode(array('nik'=>trim($employee->nik))))),
                ));
                break;
        }

    }
    public function accountread($param)
    {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('generatepassword'));
        $this->load->model(array('master/m_user','master/M_UserSidia'));
        $employee = $this->m_karyawan->q_karyawan_read('TRUE AND trim(nik) = \'' . trim($json->nik) . '\' ')->row();
        $userHrms = $this->m_user->q_user_read_where(' AND trim(nik) = \''.trim($employee->nik).'\' ')->row();
        $userSidia = $this->M_UserSidia->q_transaction_read_where(' AND nik = \''.trim($employee->nik).'\' ')->row();

        $accountList = array();

        if (!empty($userSidia) && !empty($userHrms)){
            $passDecript = $this->generatepassword->sidia($userSidia->password,FALSE);
            array_push($accountList,array('application'=>'HRMS','username'=>$userHrms->username,'password'=>$passDecript));
            array_push($accountList,array('application'=>'SIDIA','username'=>$userSidia->userid,'password'=>$passDecript));
        }else{
            array_push($accountList,array('application'=>'HRMS','username'=>$userHrms->username));
        }
        $this->load->view('trans/karyawan/modals/v_account', array(
            'accountList' => $accountList,
            'modalTitle' => 'Daftar Akun',
            'modalSize' => 'modal-sm'
        ));
    }
}
