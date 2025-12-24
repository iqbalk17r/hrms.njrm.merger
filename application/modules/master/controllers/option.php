<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Option extends MX_Controller{

    function __construct(){
        parent::__construct();

		$this->load->model(array('m_option','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Option";

		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Data Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Sudah Diubah</div>";
        else
            $data['message']='';
		$data['list_option']=$this->m_option->q_option()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/option/v_option',$data);
    }
	function add_option(){
		$kdoption=trim(strtoupper(str_replace(" ","",$this->input->post('kdoption'))));
		$nmoption=$this->input->post('nmoption');
		$value21=trim(strtoupper(str_replace("_","",$this->input->post('value2'))));
		if ($value21==''){
			$value2==NULL;
		} else {
			$value2=$value21;
		}
		$value1=$this->input->post('value1');
		$value31=trim(strtoupper(str_replace("_","",$this->input->post('value3'))));
		if ($value31==''){
			$value3=NULL;
		} else {
			$value3=$value31;
		}
		$keterangan=$this->input->post('keterangan');
		$group_option=$this->input->post('group_option');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');


		//echo $value2;
		$info=array(
			'kdoption'=>$kdoption,
			'nmoption'=>strtoupper($nmoption),
			'value1'=>strtoupper($value1),
			'value2'=>$value2,
			'value3'=>$value3,
			'keterangan'=>strtoupper($keterangan),
			'group_option'=>strtoupper($group_option),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_option->q_cekoption($kdoption)->num_rows();
		if ($cek>0){
			redirect('master/option/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.option',$info);
			redirect('master/option/index/rep_succes');
		}
		//echo $inputby;
	}

	function edit_option(){
		$kdoption=trim(strtoupper(str_replace(" ","",$this->input->post('kdoption'))));
		$nmoption=$this->input->post('nmoption');
		$value21=trim(strtoupper(str_replace("_","",$this->input->post('value2'))));
		if ($value21==''){
			$value2==NULL;
		} else {
			$value2=$value21;
		}
		$value1=$this->input->post('value1');
		$value31=trim(strtoupper(str_replace("_","",$this->input->post('value3'))));
		if ($value31==''){
			$value3=NULL;
		} else {
			$value3=$value31;
		}
		$keterangan=$this->input->post('keterangan');
		$group_option=$this->input->post('group_option');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $sub;
		$info=array(
			//'kdoption'=>$kdoption,
			'nmoption'=>strtoupper($nmoption),
			'value1'=>strtoupper($value1),
			'value2'=>$value2,
			'value3'=>$value3,
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);

		$this->db->where('group_option',trim($group_option));
		$this->db->where('kdoption',trim($kdoption));
		$this->db->update('sc_mst.option',$info);

        $this->db->cache_delete('master', 'option');
		redirect('master/option/index/edit_succes');

	}

	function hps_option($kdoption,$group_option){
		$this->db->where('group_option',$group_option);
		$this->db->where('kdoption',$kdoption);
		$this->db->delete('sc_mst.option');
        $this->db->cache_delete('master', 'option');
		redirect('master/option/index/del_succes');
	}

	function hrd_option(){


       if($this->uri->segment(4)=="pwd_failed")
            $data['message']="<div class='alert alert-warning'>Password tidak terupdate</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Save succes</div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['title']="Option HRD";
		$data['title1']="SMS Option HRD";
		$data['title2']="Jam Absen HRD";
		$data['title3']="Tanggal Libur Nasional";
		$data['title4']="Option Cuti";
		$data['title5']="Option Reminder Status Karyawan";
		$nama=$this->session->userdata('username');
		$data['jeneng']=strtoupper($nama);
		$data['list_kantor']=$this->m_option->q_kantor()->result();
		$data['list_hari']=$this->m_option->q_hari_kerja()->result();
		$data['option_sms']=$this->m_option->q_pj_hrd()->result();
		$data['option_absen']=$this->m_option->q_jam_absen()->result();
		$data['option_absen_edit']=$this->m_option->q_jam_absen()->row_array();
		$data['option_cuti']=$this->m_option->q_option_cuti()->result();
		$data['option_reminder']=$this->m_option->q_option_reminder()->result();
		$data['option_broadcast']=$this->m_option->q_option_mail_broadcast()->result();
		$data['list_karyawan']=$this->m_option->q_list_karyawan($param = null)->result();
		$thn=$this->input->post('tahun');
		if (empty($thn)){
			$tahun=date('Y'); $tgl=$tahun;
		} else {
			$tahun=$thn;  $tgl=$tahun;
		}


        $this->template->display('master/option/v_option_hrd',$data);
    }

	function add_notifsms(){

		$nik=$this->input->post('nik');
		$nipa=substr($nik,5,3);
		$telp=$this->input->post('telepon');
		$ijin=$this->input->post("ijin$nipa");
		if ($ijin=='Y'){
			$ijin1=$ijin;
		} else{
			$ijin1=NULL;
		}
		$cuti=$this->input->post("cuti$nipa");
		if ($cuti=='Y'){
			$cuti1=$cuti;
		} else{
			$cuti1=NULL;
		}
		$lembur=$this->input->post("lembur$nipa");
		if ($lembur=='Y'){
			$lembur1=$lembur;
		} else{
			$lembur1=NULL;
		}
		$dinas=$this->input->post("dinas$nipa");
		if ($dinas=='Y'){
			$dinas1=$dinas;
		} else{
			$dinas1=NULL;
		}
		$dll=$this->input->post("dll$nipa");
		if ($dll=='Y'){
			$dll1=$dll;
		} else{
			$dll1=NULL;
		}
		$sby=$this->input->post("sby$nipa");
		if ($sby=='Y'){
			$sby1=$sby;
		} else{
			$sby1=NULL;
		}
		$smg=$this->input->post("smg$nipa");
		if ($smg=='Y'){
			$smg1=$smg;
		} else{
			$smg1=NULL;
		}
		$dmk=$this->input->post("dmk$nipa");
		if ($dmk=='Y'){
			$dmk1=$dmk;
		} else{
			$dmk1=NULL;
		}
		$jkt=$this->input->post("jkt$nipa");
		if ($jkt=='Y'){
			$jkt1=$jkt;
		} else{
			$jkt1=NULL;
		}


		$this->db->query("update sc_mst.notif_sms set cuti='$cuti1',ijin='$ijin1',
		dll='$dll1',lembur='$lembur1',dinas='$dinas1',kanwil_sby='$sby1',kanwil_smg='$smg1',kanwil_dmk='$dmk1',kanwil_jkt='$jkt1' where nik='$nik'");


		redirect('master/option/hrd_option/rep_succes');
	}

	function add_jam_absen(){


		$kodeopt=$this->input->post('kodeopt');
		//$kodeopt=strtoupper($kodeopt1);
		$desc_opt=$this->input->post('desc_opt');
		$hari=$this->input->post('hari');
		$tgl=$this->input->post('tgl');
		$jam=$this->input->post('jam');
		$kantor=$this->input->post('kantorcabang');
		$status=$this->input->post('aktif');
		if ($status=='t'){
			$status1=$status;
		} else{
			$status1='f';
		}
		$input=$this->input->post('input');
			$info=array(
			'kodeopt'=>strtoupper(str_replace(" ","",$kodeopt)),
			'desc_opt'=>strtoupper($desc_opt),
			'hari'=>$hari,
			'value2'=>$tgl,
			'value3'=>$jam,
			'wilayah'=>strtoupper($kantor),
			'status'=>$status1,
			'inputby'=>$input,

			);
		$this->db->insert("sc_hrd.option",$info);
		//echo "sukses";
			redirect('hrd/option/index/rep_succes');
	}

	function add_tgl_libur(){
		$data['title']="Input Tanggal Libur Nasional";

		$tgl_libur=$this->input->post('tgl2');
		$ket_libur=$this->input->post('ket_libur');
			$info=array(
			'tgl_libur'=>($tgl_libur),
			'ket_libur'=>strtoupper($ket_libur),
			);
		$this->db->insert("sc_mst.libur_nasional",$info);
		redirect('hrd/option/index/rep_succes');
	}

	function hps_tgl_libur($tgl){
		$this->db->where('tgl_libur',$tgl);
		$this->db->delete('sc_mst.libur_nasional');
		redirect('hrd/option/index/del_succes');
	}
	function edit_jam_absen($kodeopt){
		$kodeopt=$this->input->post('kodeopt');
		$desc_opt=$this->input->post('desc_opt');
		$hari=$this->input->post('hari');
		$tgl=$this->input->post('tgl');
		$jam=$this->input->post('jam');
		$kantor=$this->input->post('kantorcabang');
		$status=$this->input->post('aktif');
		if ($status=='T'){
			$status1=$status;
		} else{
			$status1='F';
		}
		$input=$this->input->post('input');

		$info=array(
			'nmoption'=>strtoupper($desc_opt),
			'value1'=>$hari,
			'value2'=>$jam,
			'value3'=>null,
			'status'=>$status1,
			'input_by'=>$input,

			);
		$this->db->where('kdoption',$kodeopt);
		$this->db->update("sc_mst.option",$info);
		redirect('master/option/hrd_option/rep_succes');
	}

	function hps_jam_absen($kodeopt){
		$this->db->where('kodeopt',$kodeopt);
		$this->db->delete('sc_hrd.option');
		redirect('hrd/option/index/del_succes');
	}

	function edit_option_cuti($kodeopt){
		$kodeopt=$this->input->post('kodeopt');
		$desc_opt=$this->input->post('desc_opt');
		$tgl=$this->input->post('tgl');
		$batas=$this->input->post('batas');
		$status=$this->input->post('aktif');
		if ($status=='t'){
			$status1=$status;
		} else{
			$status1='f';
		}
		$input=$this->input->post('input');

		$info=array(
			//'kodeopt'=>strtoupper($kodeopt),
			'desc_opt'=>strtoupper($desc_opt),
			'value2'=>$tgl,
			'value4'=>str_replace("_","",$batas),
			'status'=>$status1,
			'inputby'=>$input,

			);
		$this->db->where('kodeopt',$kodeopt);
		$this->db->update("sc_hrd.option",$info);
		echo $tgl;
		redirect('master/option/index/rep_succes');

	}

	function edit_option_reminder($kodeopt){
		$kodeopt=$this->input->post('kodeopt');
		$desc_opt=$this->input->post('desc_opt');
		$reminder1=$this->input->post('reminder1');
		$status=$this->input->post('aktif');
		if ($status=='T'){
			$status1=$status;
		} else{
			$status1='F';
		}
		$input=$this->input->post('input');

		$info=array(
			'keterangan'=>strtoupper($desc_opt),
			'value3'=>str_replace("_","",$reminder1),
			'status'=>$status1,
			'input_by'=>$input,

			);
		$this->db->where('kdoption',$kodeopt);
		$this->db->update("sc_mst.option",$info);
		//echo "sukses";
		redirect('master/option/hrd_option/rep_succes');

	}
    function del_option_mail_broadcast($nik,$doctype){

        $this->db->where('doctype',$doctype);
        $this->db->where('nik',$nik);
        $this->db->delete("sc_mst.option_broadcast");
        redirect('master/option/hrd_option/rep_succes');

    }

    function input_option_mail_broadcast(){
        $nama = $this->session->userdata('nik');

        $nik = $this->input->post('nik');
        $doctype = $this->input->post('doctype');
        $erptype = $this->input->post('erptype');
        $grouptype = $this->input->post('grouptype');
        $module = $this->input->post('module');
        $chold = $this->input->post('chold');

        $inputby= $nama;
        $inputdate = date('Y-m-d H:i:s');

        $info = array(
            'nik' => $nik,
            'doctype' => $doctype,
            'erptype' => $erptype,
            'grouptype' => $grouptype,
            'module' => $module,
            'mailyes' => 'YES',
            'smsyes' => 'YES',
            'mobileyes' => 'YES',
            'chold' => $chold,
            'inputby' => $inputby,
            'inputdate' => $inputdate,
        );
        $this->db->insert("sc_mst.option_broadcast",$info);
        redirect('master/option/hrd_option/rep_succes');
    }
}
