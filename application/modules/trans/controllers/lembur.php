<?php

class Lembur extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->model(['m_lembur', 'master/m_akses', 'master/m_option']);
        $this->load->library(['form_validation', 'template', 'upload', 'pdf', 'fiky_encryption', 'Fiky_notification_push']);
        if(!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

	function index() {
		$nik = $this->session->userdata("nik");
		$data["title"] = "List Lembur Karyawan";

        $paramerror = " AND userid = '$nik' AND modul = 'LEMBUR'";
        $dtlerror = $this->m_lembur->q_trxerror($paramerror)->row_array();
        $errordesc = isset($dtlerror["description"]) ? strtoupper(trim($dtlerror["description"])) : "";
        $nomorakhir1 = isset($dtlerror["nomorakhir1"]) ? trim($dtlerror["nomorakhir1"]) : "";
        $errorcode = isset($dtlerror["errorcode"]) ? trim($dtlerror["errorcode"]) : "";

        $data['message'] = "";
        if($dtlerror) {
            if($errorcode == 0) {
                $data['message'] = "<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH: $nomorakhir1</div>";
            } else if($errordesc <> '') {
                $data['message'] = "<div class='alert alert-warning'>$errordesc</div>";
            }
        }

		$periode = $this->input->post("periode");
		$status1 = $this->input->post("status");
		$nik1 = $this->input->post("nik");

		if(empty($periode)) {
            $periode = date("m-Y");
		}
        if($status1 == "") {
            $status = "IS NOT NULL";
        } else {
            $status = "= '$status1'";
        }
        if($nik1 == "") {
            $nik2 = "IS NOT NULL";
        } else {
            $nik2 = "= '$nik1'";
        }
		$cek2 = $this->m_lembur->cek_position($nik)->num_rows();
		if($cek2 <= 0) {
			$position = "IT";
		} else {
			$cek = $this->m_lembur->cek_position($nik)->row_array();
			$position = trim($cek["bag_dept"]);
		}
        $data["position"] = $position;
        $data["periode"] = $periode;
        $data["nik"] = $nik1;
        $data["status"] = $status1;

		/* AKSES APPROVE ATASAN */
		$ceknikatasan1 = $this->m_akses->list_aksesatasan1($nik)->num_rows();
		$ceknikatasan2 = $this->m_akses->list_aksesatasan2($nik)->num_rows();

		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo["level_akses"]));
        $karyawan_filter = "";
        $data["karyawan_filter"] = true;

		if($userhr > 0 || $level_akses == "A") {
			$nikatasan = "";
		} else if($ceknikatasan1 > 0 && $userhr == 0 && in_array($level_akses, ["B", "C", "D"])) {
			$nikatasan = "WHERE x1.nik IN (SELECT TRIM(nik) FROM sc_mst.karyawan WHERE nik_atasan = '$nik') OR x1.nik = '$nik'";
            $karyawan_filter = " AND (a.nik = '$nik' OR a.nik_atasan = '$nik')";
		} else if($ceknikatasan2 > 0 && $userhr == 0 && in_array($level_akses, ["B", "C", "D"])) {
			$nikatasan = "WHERE x1.nik IN (SELECT TRIM(nik) FROM sc_mst.karyawan WHERE nik_atasan2 = '$nik') OR x1.nik = '$nik'";
            $karyawan_filter = " AND (a.nik = '$nik' OR a.nik_atasan2 = '$nik')";
		} else {
			$nikatasan = "WHERE x1.nik = '$nik'";
            $karyawan_filter = " AND a.nik = '$nik'";
            $data["karyawan_filter"] = false;
		}
		$data["nama"] = $nik;
		$data["userhr"] = $userhr;
		$data["level_akses"] = $level_akses;
		/* END APPROVE ATASAN */

		$kmenu = "I.T.B.3";
		$data["akses"] = $this->m_akses->list_aksespermenu($nik, $kmenu)->row_array();
		$data["list_lembur_edit"] = $this->m_lembur->list_lembur()->result();
		$data["list_karyawan"] = $this->m_lembur->list_karyawan($karyawan_filter)->result();
		$data["list_lembur"] = $this->m_lembur->q_lembur($periode, $status, $nik2, $nikatasan)->result();
		$data["list_lembur_dtl"] = $this->m_lembur->q_lembur_dtl()->result();
		$data["list_trxtype"] = $this->m_lembur->list_trxtype()->result();

        $this->template->display("trans/lembur/v_list", $data);

        $paramerror = " AND userid = '$nik'";
        $dtlerror = $this->m_lembur->q_deltrxerror($paramerror);
    }
    
	function karyawan() {
		$data["title"] = "List Karyawan";
		$userinfo = $this->m_akses->q_user_check()->row_array();
		$userhr = $this->m_akses->list_aksesperdep()->num_rows();
		$level_akses = strtoupper(trim($userinfo["level_akses"]));

		if($userhr > 0 || $level_akses == "A") {
			$data["list_karyawan"] = $this->m_akses->list_karyawan()->result();
		} else {
			$data["list_karyawan"] = $this->m_akses->list_akses_alone()->result();
		}
		$this->template->display("trans/lembur/v_list_karyawan", $data);
	}


	function proses_input($nik) {
		$data["title"] = "Input Data Lembur";
        $nama=$this->session->userdata('nik');
        $userinfo=$this->m_akses->q_user_check()->row_array();
        $userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
        $level_akses=strtoupper(trim($userinfo['level_akses']));
        $data['nama']=$nama;
        $data['userhr']=$userhr;
        $data['level_akses']=$level_akses;

		$data["list_lk"] = $this->m_lembur->list_karyawan_index($nik)->result();
		$data["list_lembur"] = $this->m_lembur->list_lembur()->result();
		$data["list_trxtype"] = $this->m_lembur->list_trxtype()->result();
        $data['opsi_lembur'] = null;
        if($data['userhr'] == 0) {
            $opsi_lembur = $this->m_option->q_cekoption('BLKLB')->row();
            if($opsi_lembur->status == "T") {
                $data['opsi_lembur'] = strtolower($opsi_lembur->value1);
            }
        }
		$this->template->display("trans/lembur/v_input", $data);
	}

	function add_lembur(){
		//$nik1=explode('|',);
		$lintashari=$this->input->post('lintashari');
		$tgllintas=$this->input->post('tgllin');

		$nik=$this->input->post('nik');
		$nodok=$this->session->userdata('nik');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdlembur=$this->input->post('kdlembur');
		$tgl_kerja1=$this->input->post('tgl_kerja');




		if ($tgl_kerja1==''){
			$tgl_kerja=NULL;
		} else {
			$tgl_kerja=$tgl_kerja1;
		}


		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jam_awal=str_replace("_","",$this->input->post('jam_awal'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$durasi_istirahat=str_replace("_","",$this->input->post('durasi_istirahat'));
		//$durasi=$jam_selesai-$jam_awal;
		//$tgl_dok=$this->input->post('tgl_dok');
		$tgl_dok=$tgl_kerja;
		$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$jenis_lembur=$this->input->post('jenis_lembur');

		if($lintashari=='t'){
			$jenis_lembur='D2';
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgllintas)).' '.$jam_selesai);

		} else{
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_selesai);
		}

		//echo $jam_awal1.'<br>';
		//echo $jam_selesai1.'<br>';

		//echo $gaji_bpjs;
		$info=array(
			'nik'=>$nik,
			'nodok'=>strtoupper($nodok),
			'kddept'=>strtoupper($kddept),
			'kdsubdept'=>strtoupper($kdsubdept),
			//'durasi'=>$durasi,
			'durasi_istirahat'=>$durasi_istirahat,
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			'nmatasan'=>$atasan,
			'tgl_dok'=>date('Y-m-d H:i:s'),
			'kdlembur'=>$kdlembur,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal1,
			'tgl_jam_selesai'=>$jam_selesai1,
			'kdtrx'=>strtoupper($kdtrx),
			'jenis_lembur'=>strtoupper($jenis_lembur),
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);

		var_dump($info);
		//echo $durasi;
		$cek=$this->m_lembur->q_cekdouble($nik,$tgl_kerja,$jam_awal1)->num_rows();
		if ($cek>0) {
			redirect("trans/lembur/index/lembur_failed");
		} else {
            $nama = $this->session->userdata('nik');
            $this->db->insert('sc_tmp.lembur',$info);
            $dtl_push = $this->m_akses->q_lv_mkaryawan(" and nik='$nik'")->row_array();
            $paramerror=" and userid='$nama' and modul='LEMBUR'";
            $dtlerror=$this->m_lembur->q_trxerror($paramerror)->row_array();
            if ($this->fiky_notification_push->onePushVapeApprovalHrms($nik,trim($dtl_push['nik_atasan']),trim($dtlerror['nomorakhir1']))){
                redirect("trans/lembur/index/rep_succes/$nik");
            }else{
                redirect("trans/lembur/index/rep_succes/$nik");
            }

		}

	}

	function edit($nodok) {
		$data["title"] = "Edit Data Lembur";
		if($this->uri->segment(5) == "upsuccess") {
			$data['message'] = "<div class='alert alert-success'>Data Berhasil di update </div>";
		} else {
			$data["message"] = "";
		}
        $nik = $this->uri->segment(4);
        $nama=$this->session->userdata('nik');
        $userinfo=$this->m_akses->q_user_check()->row_array();
        $userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
        $level_akses=strtoupper(trim($userinfo['level_akses']));
        $data['nama']=$nama;
        $data['userhr']=$userhr;
        $data['level_akses']=$level_akses;

		$data["list_lembur_edit"] = $this->m_lembur->list_lembur()->result();
		$data["list_lembur_dtl"] = $this->m_lembur->q_lembur_edit($nodok)->result();
		$data["list_trxtype"] = $this->m_lembur->list_trxtype()->result();
        $data['opsi_lembur'] = null;
        if($data['userhr'] == 0) {
            $opsi_lembur = $this->m_option->q_cekoption('BLKLB')->row();
            if($opsi_lembur->status == "T") {
                $data['opsi_lembur'] = strtolower($opsi_lembur->value1);
            }
        }
		$this->template->display("trans/lembur/v_edit", $data);
	}

	function detail($nodok){
		//echo "test";
		$nama=trim($this->session->userdata('nik'));
		$data['title'] = 'Detail Data Lembur';
		if($this->uri->segment(5)=="upsuccess"){
			$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
		}
		else {
			$data['message']='';
		}
		//$nik=$this->uri->segment(4);
		//$data['nik']=$nik;
		$dtl=$this->m_lembur->q_lembur_edit($nodok)->row_array();
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));

		if(($userhr>0)){
			//$nikatasan='';
			$cekatasan=1;
		}
		else if (trim($dtl['nik_atasan'])==$nama and $userhr==0 ){
			//$nikatasan="where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or x1.nik='$nama'";
			$cekatasan=1;
		}
		else if (trim($dtl['nik_atasan2'])==$nama and $userhr==0 ){
			//$nikatasan="where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or x1.nik='$nama'";
			$cekatasan=1;
		}
		else {
			//$nikatasan="where x1.nik='$nama'";
			$cekatasan=0;
		}
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$data['cekatasan']=$cekatasan;
		/* END APPROVE ATASAN */

		$data['list_lembur_edit']=$this->m_lembur->list_lembur()->result();
		//$data['list_lembur']=$this->m_lembur->q_lembur($tgl,$status)->result();
		$data['list_lembur_dtl']=$this->m_lembur->q_lembur_edit($nodok)->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		$this->template->display('trans/lembur/v_detail',$data);
	}

	function edit_lembur(){
		//$nik1=explode('|',);
		$lintashari=$this->input->post('lintashari');
		$tgllintas=$this->input->post('tgllin');


		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdlembur=$this->input->post('kdlembur');
		$tgl_kerja1=$this->input->post('tgl_kerja');
		if ($tgl_kerja1==''){
			$tgl_kerja=NULL;
		} else {
			$tgl_kerja=$tgl_kerja1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jam_awal=str_replace("_","",$this->input->post('jam_awal'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$durasi_istirahat=str_replace("_","",$this->input->post('durasi_istirahat'));
		$kdtrx=$this->input->post('kdtrx');
		$tgl_dok=$this->input->post('tgl_dok');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$jenis_lembur=$this->input->post('jenis_lembur');
		//$no_urut=$this->input->post('no_urut');

		if($lintashari=='t'){
			$jenis_lembur='D2';
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgllintas)).' '.$jam_selesai);

		} else{
			//$jenis_lembur='D1';
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_selesai);
		}


		$info=array(
			//'nodok'=>strtoupper($nodok),

			'durasi_istirahat'=>$durasi_istirahat,
			'kdlembur'=>$kdlembur,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal1,
			'tgl_jam_selesai'=>$jam_selesai1,
			'kdtrx'=>strtoupper($kdtrx),
			'keterangan'=>strtoupper($keterangan),
			'jenis_lembur'=>strtoupper($jenis_lembur),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);

			$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
			$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
			//if ($cek>0 or $cek2>0) {
			if ($cek2>0) {
				redirect("trans/lembur/index/kode_failed");
			} else {
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.lembur',$info);
				$this->db->query("update sc_trx.lembur set status='U' where nodok='$nodok'");
				redirect("trans/lembur/index/$nodok/upsuccess");
			}


		//echo $inputby;
	}

	function hps_lembur($nodok){
		//$this->db->where('nodok',$nodok);
		$cek=$this->m_lembur->cek_dokumen3($nodok)->row_array();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		$tgl_closing1=$this->m_lembur->tgl_closing()->row_array();
		$tgl_closing=$tgl_closing1['value1'];
		$tgl_dok=$cek['tgl_dok'];
		$info=array(
			'delete_date'=>date('Y-m-d H:i:s'),
			'delete_by'=>$this->session->userdata('nik'),
			'status'=>'D',
		);

		/*if ($cek>0 or $cek2>0) {
			redirect("trans/lembur/index/kode_failed");
		} else {
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.lembur',$info);
			redirect("trans/lembur/index/del_succes");
		}*/


		if ($tgl_closing>=$tgl_dok){
			redirect("trans/lembur/index/del_failed");
		} else {
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.lembur',$info);
			redirect("trans/lembur/index/del_succes");
		}
	}

	function approval() {
		$submit = $this->input->post("submit");
        $nodok = $this->input->post("nodok");
        $tgl_input = $this->input->post("tgl");
        $inputby = $this->input->post("inputby");
        $cek = $this->m_lembur->cek_dokumen($nodok)->num_rows();
        $cek2 = $this->m_lembur->cek_dokumen2($nodok)->num_rows();

        if($submit == "approve") {
            if ($cek > 0) {
                redirect("trans/lembur/index/kode_failed");
            } else if ($cek2 > 0) {
                redirect("trans/lembur/index/kode_failed");
            } else {
                $this->m_lembur->tr_app($nodok, $inputby, $tgl_input);
                redirect("trans/lembur/index/app_succes");
            }
        } else if($submit == "cancel") {
            if($cek>0) {
                redirect("trans/lembur/index/kode_failed");
            } else if($cek2>0) {
                redirect("trans/lembur/index/kode_failed");
            } else {
                $this->m_lembur->tr_cancel($nodok, $inputby, $tgl_input);
                redirect("trans/lembur/index/cancel_succes");
            }
        }
	}

	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		if ($cek>0) {
				redirect("trans/lembur/index/kode_failed");
			} else if ($cek2>0){
				redirect("trans/lembur/index/kode_failed");
			} else {
				$this->m_lembur->tr_cancel($nodok,$inputby,$tgl_input);
				redirect("trans/lembur/index/cancel_succes");
			}

	}

    function checkConflict() {
        $this->load->library('DateDifference');
        $this->load->model(array('master/m_option'));
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $tgl_awal = explode(" ", $data->jam_awal)[0];
        $tgl_selesai = explode(" ", $data->jam_selesai)[0];

        $result = [
            "status" => true,
            "message" => ""
        ];
        $error = [];
        $bulan = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];

        $check = $this->m_lembur->q_checkConflict($data->nik, $data->nodok, $data->jam_awal, $data->jam_selesai)->result_array();
        if(is_null($check[0]["is_conflict"]) && $check[0]["tgl_masuk"] != $check[0]["tgl_pulang"]) {
            $error[] = $bulan[date_format(date_create($check[0]["tgl"]),"m") - 1] . " " . date_format(date_create($check[0]["tgl"]),"Y");
        }
        if(is_null($check[1]["is_conflict"])) {
            $error[] = $bulan[date_format(date_create($check[1]["tgl"]),"m") - 1] . " " . date_format(date_create($check[1]["tgl"]),"Y");
        }
        if(is_null($check[2]["is_conflict"]) && $tgl_awal != $tgl_selesai) {
            $error[] = $bulan[date_format(date_create($check[2]["tgl"]),"m") - 1] . " " . date_format(date_create($check[2]["tgl"]),"Y");
        }
        $error = array_unique($error);
        if(sizeof($error) > 0) {
            $result = [
                "status" => false,
                "message" => "PERINGATAN!! ANDA BELUM MEMILIKI JADWAL PADA BULAN " . (implode(" DAN ", $error)) . ". HARAP SEGERA HUBUNGI HRD."
            ];
        } else {
            $calculateRest = FALSE;
            $start_date = $data->jam_awal;
            $end_date = $data->jam_selesai;
            $parameters = $this->m_option->read(' AND kdoption IN (\'OVERTIME:MIN\',\'OVERTIME:MAX\',\'OVERTIME:CALC:REST\') AND status = \'T\' ')->result();
            foreach ($parameters as $index => $parameter) {
                if ($parameter->kdoption == 'OVERTIME:MIN'){
                    $setupMinTime = $parameter->value1;
                }
                if ($parameter->kdoption == 'OVERTIME:MAX'){
                    $setupMaxTime = $parameter->value1;
                }
                if ($parameter->kdoption == 'OVERTIME:CALC:REST'){
                    $calculateRest = ($parameter->value1 == 'T' ? TRUE : FALSE);
                }
            }
            $minTime = (!is_numeric($setupMinTime) ? 0 : $setupMinTime);
            $maxTime = (!is_numeric($setupMaxTime) ? 6 : $setupMaxTime);
            $difference = $this->datedifference->getTimeDifference($start_date, $end_date,'S');
            if ($calculateRest){
                $rest = $this->calculateRestTime($difference->time);
                $duration = $difference->time - $rest;
                if ($this->secondsToHours($duration) >= 4){
                    $duration = $duration;
                }else{
                    $duration = $difference->time;
                }
            }else{
                $duration = $difference->time;
            }
            $minTimeInSecond = $this->hoursToSeconds($minTime);
            $maxTimeInSecond= $this->hoursToSeconds($maxTime);
            $error = [];
            if ($duration < $minTimeInSecond) {
                $result = [
                    "status" => false,
                    "message" => "MINIMAL LEMBUR {$minTime} JAM",
                ];
            } elseif ($duration > $maxTimeInSecond) {
                $result = [
                    "status" => false,
                    "message" => "MAKSIMAL LEMBUR {$maxTime} JAM",
                ];
            } else {
                $rest = 'within';
                if($check[0]["is_conflict"] == 't' && $check[0]["tgl_masuk"] != $check[0]["tgl_pulang"]) {
                    $error[] = "* " . date_format(date_create($check[0]["tgl_masuk"]),"d-m-Y") . " " . $check[0]["jam_masuk"] . " S/D " . date_format(date_create($check[0]["tgl_pulang"]),"d-m-Y") . " " . $check[0]["jam_pulang"] . ".";
                }
                if($check[1]["is_conflict"] == 't') {
                    $error[] = "* " . date_format(date_create($check[1]["tgl_masuk"]),"d-m-Y") . " " . $check[1]["jam_masuk"] . " S/D " . date_format(date_create($check[1]["tgl_pulang"]),"d-m-Y") . " " . $check[1]["jam_pulang"] . ".";
                }
                if($check[2]["is_conflict"] == 't' && $tgl_awal != $tgl_selesai) {
                    $error[] = "* " . date_format(date_create($check[2]["tgl_masuk"]),"d-m-Y")  . " " . $check[2]["jam_masuk"] . " S/D " . date_format(date_create($check[2]["tgl_pulang"]),"d-m-Y") . " " . $check[2]["jam_pulang"] . ".";
                }
                if(sizeof($error) > 0) {
                    $result = [
                        "status" => false,
                        "message" => "PERINGATAN!! ANDA TIDAK DAPAT MENGAJUKAN LEMBUR SAAT JAM KERJA. PERHATIKAN JADWAL KERJA BERIKUT:<br>" . implode("<br>", $error)
                    ];
                } else {
                    $error = [];
                    for($i = 3; $i < sizeof($check); $i++) {
                        if($check[$i]["is_conflict"] == 't') {
                            $error[] = "* NODOK: " . $check[$i]["nodok"] . " (" . date_format(date_create($check[$i]["tgl_masuk"]),"d-m-Y") . " " . $check[$i]["jam_masuk"] . " S/D " . date_format(date_create($check[$i]["tgl_pulang"]),"d-m-Y") . " " . $check[$i]["jam_pulang"] . ").";
                        }
                    }
                    if(sizeof($error) > 0) {
                        $result = [
                            "status" => false,
                            "message" => "PERINGATAN!! ANDA SUDAH MENGAJUKAN LEMBUR PADA HARI DAN JAM TERSEBUT. PERHATIKAN PENGAJUAN LEMBUR BERIKUT:<br>" . implode("<br>", $error)
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    private function secondsToHours($second) {
        return $second / 3600;
    }
    private function hoursToSeconds($hours) {
        return $hours * 3600;
    }

    function calculateRestTime($duration) {
        $restTime = 0;
        while ($duration >= 14400) {
            $duration -= 14400; // Subtract 4 hours
            $restTime += 3600;  // Add 60 minutes
        }
        return $restTime;
    }
}
