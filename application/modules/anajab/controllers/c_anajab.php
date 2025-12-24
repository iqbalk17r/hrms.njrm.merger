<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/25/19 8:54 AM
 *  * Last Modified: 1/2/19 10:50 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class C_anajab extends MX_Controller{

    function __construct(){
        parent::__construct();



		$this->load->model(array('master/m_akses','m_anajab','master/m_department','master/m_jabatan',));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_encryption'));

		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

	function index(){
			$data['title']="SILAHKAN PILIH MENU YANG ADA";
			$this->template->display('anajab/anajab/v_index',$data);
	}
	function underconstruction(){
			$data['title']="!!!!! WARNING ......... !!  UNDER CONSTRUCTION";
			$this->template->display('anajab/anajab/v_index',$data);
	}

	function upload_anajab(){
		$data['title']="DATA ANAJAB KARYAWAN";
		$nama=trim($this->session->userdata('nik'));
		$dtlbranch=$this->m_akses->q_branch()->row_array();
		$branch=$dtlbranch['branch'];

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.CA.A.2'; $versirelease='I.CA.A.2/ALPHA.001'; $releasedate=date('2020-02-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */


       	$paramerror=" and userid='$nama' and modul='I.CA'";
		$dtlerror=$this->m_anajab->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_anajab->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }

		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['errorcode']==0){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}

		}else {
			if ($errorcode=='0'){
				$data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
			} else {
				$data['message']="";
			}

		}


		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_akses_od()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$inputfill=strtoupper(trim($this->input->post('inputfill')));
		$tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));
		$fnik=strtoupper(trim($this->input->post('nik')));

		if (!empty($tglYM)) { $periode=$tglYM; } else { $periode=date('Ym'); }
		if (!empty($inputfill)) { $filtertype=" and docno='$inputfill'"; } else { $filtertype=""; }


		if(($userhr>0)){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";
			} else {
				$param_list_akses=" and planperiod='$periode'";
			}
			$param_list_akses_nik="";
		}
	//	else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan1)>0 and ($ceknikatasan2)==0 and $userhr==0 ){
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan='$nama')";
			} else {
				//$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";
				$param_list_akses="and planperiod='$periode' and (nik_atasan='$nama' or nik='$nama')";
			}
			$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";

		} else if (($ceknikatasan1)==0 and ($ceknikatasan2)>0 and $userhr==0 ){
            if (!empty($fnik)) {
                $param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan2='$nama')";
            } else {
                //$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";
                $param_list_akses="and planperiod='$periode' and (nik_atasan2='$nama' or nik='$nama')";
            }
            $param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";

        }
		//else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
		else if (($ceknikatasan1)>0 and ($ceknikatasan2)>0 and $userhr==0 ){
			if (!empty($fnik)) {
				//$param_list_akses="and planperiod='$periode' and nik='$fnik' ";
                //$param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan2='$nama')";
                $param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan2='$nama' or nik_atasan='$nama')";
            } else {
				//$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
				$param_list_akses="and planperiod='$periode' and (nik_atasan2='$nama' or nik='$nama' or nik_atasan='$nama')";
			}
			$param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama' or nik_atasan2='$nama') or nik='$nama'";

		}
		else {
			if (!empty($fnik)) {
				$param_list_akses="and planperiod='$periode' and nik='$fnik'";
			} else {
				$param_list_akses="and planperiod='$periode' and nik='$nama' ";
			}
				$param_list_akses_nik=" and nik='$nama' ";
		}

		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;


		$data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
		$data['list_jabatan']=$this->m_anajab->q_jabatan($param = null)->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
		$this->template->display('anajab/anajab/v_upload_anajab',$data);

		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_anajab->q_deltrxerror($paramerror);
	}


    function list_upload_anajab()
    {
        $list = $this->m_anajab->get_t_anajab_mst();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $no++;
            $row = array();
            $row[] = $no;
           // $row[] = '<div align="right">'.$lm->docdate1.'</div>';
            $row[] = $lm->nmdept;
            $row[] = $lm->nmsubdept;
            $row[] = $lm->nmjabatan;
            $row[] = $lm->docno;
            $row[] = $lm->nmstatus;
                //add html for action
            if (empty($lm->file_name)) {
                $row[] = '<div align="center"><a href="#" class="ratakanan" onclick="return confirm(\'File Anajab Belum Terupload atau Tidak Tersedia\');"> <img border="0" src="'.base_url('assets/img/icons_block.png').'" width="40px" height="40px"></a></div>';
            } else {
                $row[] = '<div align="center"><a href="#" class="ratakanan" onclick="window.open('."'".site_url(trim($lm->file_patch))."'".')"> <img border="0" src="'.base_url('assets/img/icons_pdf.png').'" width="40px" height="40px"></a></div>';
            }
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_anajab->t_anajab_mst_count_all(),
            "recordsFiltered" => $this->m_anajab->t_anajab_mst_count_filtered(),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function save_anajab()
    {
        $nama = trim($this->session->userdata('nik'));
        $type = $this->input->post('type');
        $docno = strtoupper($this->input->post('docno'));
        $docdate = strtoupper($this->input->post('docdate'));
        $docref = strtoupper($this->input->post('docref'));
        $kddept = strtoupper($this->input->post('kddept'));
        $kdsubdept = strtoupper($this->input->post('kdsubdept'));
        $kdjabatan = strtoupper($this->input->post('kdjabatan'));
        $kdlvljabatan = strtoupper($this->input->post('kdlvljabatan'));
        $description = strtoupper($this->input->post('description'));
        $inputby = $nama;
        $inputdate = date('Y-m-d H:i:s');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch = trim($dtlbranch['branch']);
        $uploadPath = './assets/attachment/anajab_file/';
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if($type=='INPUT'){
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = true;
            $config['max_size'] = 25 * 1000; //10:mb
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('uploadAnajab')){
                $cek = $this->m_anajab->q_anajab_mst(" and kddept='$kddept' and kdsubdept='$kdsubdept' and kdjabatan='$kdjabatan'")->num_rows();

                if ($cek>0) {
                    $fileData = $this->upload->data();
                    $data = array(
                        'docno' => $docno,
                        'docdate' => date('Y-m-d'),
                        'docref' => $docref,
                        'kdlvljabatan' => $kdlvljabatan,
                        'file_dir' => $uploadPath,
                        'file_name' => $fileData['file_name'],
                        'file_patch' => $uploadPath.$fileData['file_name'],
                        'description' => $description,
                        'status' => 'P',
                        'updatedate' => $inputdate,
                        'updateby' => $inputby,
                    );
                    $this->db->update("sc_his.anajab_mst",$data);
                    echo json_encode(array("status" => TRUE));
                } else {
                    $fileData = $this->upload->data();
                    $data = array(
                        'docno' => $docno,
                        'docdate' => date('Y-m-d'),
                        'docref' => $docref,
                        'kddept' => $kddept,
                        'kdsubdept' => $kdsubdept,
                        'kdjabatan' => $kdjabatan,
                        'kdlvljabatan' => $kdlvljabatan,
                        'file_dir' => $uploadPath,
                        'file_name' => $fileData['file_name'],
                        'file_patch' => $uploadPath.$fileData['file_name'],
                        'description' => $description,
                        'status' => 'P',
                        'inputdate' => $inputdate,
                        'inputby' => $inputby,
                    );
                    $this->db->insert("sc_his.anajab_mst",$data);
                    echo json_encode(array("status" => TRUE));
                }

            } else {
                echo json_encode(array("status" => FALSE));
            }

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


    function list_anajab(){
        $data['title']="DATA ANAJAB KARYAWAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.CA.A.2'; $versirelease='I.CA.A.2/ALPHA.001'; $releasedate=date('2020-02-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */


        $paramerror=" and userid='$nama' and modul='I.CA'";
        $dtlerror=$this->m_anajab->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_anajab->q_trxerror($paramerror)->num_rows();
        if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
        if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
        if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }

        if($count_err>0 and $errordesc<>''){
            if ($dtlerror['errorcode']==0){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message']="<div class='alert alert-info'>$errordesc</div>";
            }

        }else {
            if ($errorcode=='0'){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message']="";
            }

        }


        /* akses approve atasan */
        $ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();
        $ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();
        $nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();
        $nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();

        $userinfo=$this->m_akses->q_user_check()->row_array();
        $userhr=$this->m_akses->list_akses_od()->num_rows();
        $level_akses=strtoupper(trim($userinfo['level_akses']));
        $inputfill=strtoupper(trim($this->input->post('inputfill')));
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));
        $fnik=strtoupper(trim($this->input->post('nik')));

        if (!empty($tglYM)) { $periode=$tglYM; } else { $periode=date('Ym'); }
        if (!empty($inputfill)) { $filtertype=" and docno='$inputfill'"; } else { $filtertype=""; }


        if(($userhr>0)){
            if (!empty($fnik)) {
                $param_list_akses="and planperiod='$periode' and nik='$fnik'";
            } else {
                $param_list_akses=" and planperiod='$periode'";
            }
            $param_list_akses_nik="";
        }
        //	else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
        else if (($ceknikatasan1)>0 and ($ceknikatasan2)==0 and $userhr==0 ){
            if (!empty($fnik)) {
                $param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan='$nama')";
            } else {
                //$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";
                $param_list_akses="and planperiod='$periode' and (nik_atasan='$nama' or nik='$nama')";
            }
            $param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";

        } else if (($ceknikatasan1)==0 and ($ceknikatasan2)>0 and $userhr==0 ){
            if (!empty($fnik)) {
                $param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan2='$nama')";
            } else {
                //$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or nik='$nama'";
                $param_list_akses="and planperiod='$periode' and (nik_atasan2='$nama' or nik='$nama')";
            }
            $param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";

        }
        //else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
        else if (($ceknikatasan1)>0 and ($ceknikatasan2)>0 and $userhr==0 ){
            if (!empty($fnik)) {
                //$param_list_akses="and planperiod='$periode' and nik='$fnik' ";
                //$param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan2='$nama')";
                $param_list_akses="and planperiod='$periode' and (nik='$fnik' or nik_atasan2='$nama' or nik_atasan='$nama')";
            } else {
                //$param_list_akses="and planperiod='$periode' and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or nik='$nama'";
                $param_list_akses="and planperiod='$periode' and (nik_atasan2='$nama' or nik='$nama' or nik_atasan='$nama')";
            }
            $param_list_akses_nik=" and nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama' or nik_atasan2='$nama') or nik='$nama'";

        }
        else {
            if (!empty($fnik)) {
                $param_list_akses="and planperiod='$periode' and nik='$fnik'";
            } else {
                $param_list_akses="and planperiod='$periode' and nik='$nama' ";
            }
            $param_list_akses_nik=" and nik='$nama' ";
        }

        $data['nama']=$nama;
        $data['userhr']=$userhr;
        $data['level_akses']=$level_akses;


        $data['list_nik']=$this->m_akses->list_karyawan_param($param_list_akses_nik)->result();
        $data['list_jabatan']=$this->m_anajab->q_jabatan($param = null)->result();
        $data['list_opt_dept']=$this->m_department->q_department()->result();
        $data['list_opt_subdept']=$this->m_department->q_subdepartment()->result();
        $data['list_opt_jabt']=$this->m_jabatan->q_jabatan()->result();
        $data['list_opt_lvljabt']=$this->m_jabatan->q_lvljabatan()->result();
        $this->template->display('anajab/anajab/v_list_anajab',$data);

        $paramerror=" and userid='$nama'";
        $dtlerror=$this->m_anajab->q_deltrxerror($paramerror);
    }

}
