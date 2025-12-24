<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Regu extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_regu','m_jabatan','trans/m_jadwalnew','m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Regu";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_alert")
            $data['message']="<div class='alert alert-warning'>Data Sudah Digunakan, Hapus Data Child Terlebih Dahulu</div>";	
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_regu']=$this->m_regu->q_regu()->result();
		$data['list_mesin']=$this->m_regu->q_list_mesin()->result();
		
		//$data['message']="List SMS Masuk";
        $this->template->display('master/regu/v_regu',$data);
    }
	function add_regu(){
		$kdregu=trim(strtoupper(str_replace(" ","",$this->input->post('kdregu'))));
		$nmregu=$this->input->post('nmregu');
		$keterangan=$this->input->post('keterangan');
		$warna=$this->input->post('warna');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdregu'=>$kdregu,
			'nmregu'=>strtoupper($nmregu),
			'kdmesin'=>strtoupper($keterangan),
			'warna'=>strtoupper($warna),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_regu->q_cekregu($kdregu)->num_rows();
		if ($cek>0){
			redirect('master/regu/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.regu',$info);
			redirect('master/regu/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_regu(){
		$kdregu=trim($this->input->post('kdregu'));
		$nmregu=$this->input->post('nmregu');
		$keterangan=$this->input->post('keterangan');
		$warna=$this->input->post('warna');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdregu'=>$kdregu,
			'nmregu'=>strtoupper($nmregu),
			'kdmesin'=>strtoupper($keterangan),
			'warna'=>strtoupper($warna),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdregu',$kdregu);
			$this->db->update('sc_mst.regu',$info);
			redirect('master/regu/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_regu($kdregu){
		$cek=$this->m_regu->q_cek_del_regu($kdregu)->num_rows();
		if ($cek>0) {
			redirect('master/regu/index/del_alert');
		} else {
			$this->db->where('kdregu',$kdregu);
			$this->db->delete('sc_mst.regu');
			redirect('master/regu/index/del_succes');
		}
	}
	
	function regu_opr(){
		
		$nama=$this->session->userdata('nik');
		$kmenu='I.M.F.3';
		$data['title']="List Master Regu Operator";
		
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_alert")
            $data['message']="<div class='alert alert-warning'>Data Sudah Digunakan, Hapus Data Child Terlebih Dahulu</div>";	
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$cek_tmpregu=$this->m_regu->q_cektmpregu($nama)->num_rows();
		$tmpreguopr=$this->m_regu->q_cektmpregu($nama)->row_array();
		$q_cek_bagianses=$this->m_regu->q_karyawan_session($nama)->row_array();
		$q_akses_ses=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$q_usernotin=$this->m_akses->user_notin($nama)->num_rows();
		if($q_usernotin>0){
			$bag_dept='';
		}
			else{
			$bag_dept=$q_cek_bagianses['bag_dept'];
		}
		
		
		$department=$bag_dept;
		if($cek_tmpregu>0){
			$niktmp=trim($tmpreguopr['nik']);
			$kdregutmp=trim($tmpreguopr['kdregu']);
			redirect("master/regu/inputdtljadwal/$niktmp/$kdregutmp");
		}
		
		//echo "sukses";
		$kdregu=$this->input->post('kdregu');
		if (!empty($kdregu)){
			$data['list_regu']=$this->m_regu->q_regu()->result();
			$data['list_regu_filter']=$this->m_regu->q_regu_filter()->result();
			$data['list_nik']=$this->m_regu->q_list_nik()->result();
			if(trim($q_akses_ses['aksesfilter'])=='t'){
			$bag_dept="and c.bag_dept='$bag_dept'";		
				$data['list_regu_opr']=$this->m_regu->q_regu_opr_filter($kdregu,$bag_dept)->result();
			}else{
				$bag_dept="";
				$data['list_regu_opr']=$this->m_regu->q_regu_opr_filter($kdregu,$bag_dept)->result();
			}
			
			$this->template->display('master/regu/v_regu_opr',$data);
		} else {
			$data['list_regu']=$this->m_regu->q_regu()->result();
			$data['list_regu_filter']=$this->m_regu->q_regu_filter()->result();
			$data['list_nik']=$this->m_regu->q_list_nik()->result();
			
			if(trim($q_akses_ses['aksesfilter'])=='t'){
				$bag_dept="where c.bag_dept='$bag_dept'";
				$data['list_regu_opr']=$this->m_regu->q_regu_oprv($bag_dept)->result();
			}else{
				$bag_dept="";
				$data['list_regu_opr']=$this->m_regu->q_regu_oprv($bag_dept)->result();
			}
			$data['bag_dept']=$department;
			//$data['list_regu_opr_filter']=$this->m_regu->q_regu_opr_filter($kdregu)->result();
			$this->template->display('master/regu/v_regu_opr',$data);
		}
	
	}
	function add_regu_opr(){
		$kdregu1=explode('|',$this->input->post('kdregu'));
		$kdregu=$kdregu1[0];
		//$nmregu=$this->input->post('nmregu');
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		//$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$nama=$this->session->userdata('nik');
		
		//echo $sub;
		$info=array(
			'kdregu'=>$kdregu,
			'nik'=>$nik,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_regu->q_cekregu_opr($kdregu,$nik)->num_rows();
		$cekdtlregu=$this->m_regu->q_cekdtlreguopr($nik)->num_rows();
		if ($cek>0){
			redirect('master/regu/regu_opr/kode_failed');
		} else {
			$this->db->insert('sc_mst.regu_opr',$info);
			$this->db->insert('sc_tmp.regu_opr',$info);
			
			if ($cekdtlregu==0){
				redirect("master/regu/inputdtljadwal/$nik/$kdregu");
			}
			redirect('master/regu/regu_opr/rep_succes');	
			
		
		}
		
		//$this->db->insert('sc_mst.regu_opr',$info);
			//redirect('master/regu/regu_opr');
			
		
		
			
	}
	
	function hps_regu_opr($no_urut){
		$kdregu=$this->uri->segment(5);
		$cek=$this->m_regu->q_cek_del_regu($kdregu)->num_rows();
		//echo $kdregu;
		//echo $no_urut;
		/*if ($cek>0){
			redirect('master/regu/regu_opr/del_alert');
		} else {
			$this->db->where('no_urut',$no_urut);
			//$this->db->where('kdregu',$kdregu);
			$this->db->delete("sc_mst.regu_opr");
			redirect('master/regu/regu_opr/del_succes');
		}*/
		
		$this->db->where('no_urut',$no_urut);
		$this->db->delete("sc_mst.regu_opr");
		redirect('master/regu/regu_opr/del_succes');
	}
	
	function show_edit($id){
		
		$data['title']="Edit Master Regu Operator";
		
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_alert")
            $data['message']="<div class='alert alert-warning'>Data Sudah Digunakan, Hapus Data Child Terlebih Dahulu</div>";	
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		//echo "sukses";
		
			$data['list_regu']=$this->m_regu->q_regu()->result();
			$data['list_nik']=$this->m_regu->q_list_nik()->result();
			$data['lk']=$this->m_regu->q_regu_opr_edit($id)->row_array();
			$this->template->display('master/regu/v_edit_reguopr',$data);
	
	}
	function edit_regu_opr(){
		$kdregu=trim($this->input->post('kdregu'));
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$nik1[0];
		//$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		//echo $sub;
		$info=array(
			'kdregu'=>$kdregu,
			//'nik'=>$nik,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('no_urut',$no_urut);
			$this->db->update('sc_mst.regu_opr',$info);
			redirect('master/regu/regu_opr/rep_succes');
		
		//echo $inputby;
	}
	
	function inputdtljadwal(){
		$data['title']="NIK REGU OPR YANG BELUM MEMILIKI JADWAL";
		$nik=$this->uri->segment(4);
		$kdregu=$this->uri->segment(5);
		$nama=$this->session->userdata('nik');
		$data['list_regu']=$this->m_jadwalnew->q_regu()->result();
		$data['list_jamkerja']=$this->m_jadwalnew->q_jamkerja()->result();	
		$data['list_nik']=$this->m_regu->q_cektmpregu($nama)->result();			
		$data['nik']=$nik; $data['kdregu']=$kdregu;
		//$data['list_regu']=$this->m_regu->q_regu()->result();
		$this->template->display('master/regu/v_inputdtljadwal.php',$data);
	}
	
	function simpan_oprdtljadwal(){
		$nik=$this->input->post('nik');
		$kdregu=$this->input->post('kdregu');
		$bln=$this->input->post('bln');
		$thn=$this->input->post('thn');
		$tgl1=$this->input->post('tgl1');
		$tgl2=$this->input->post('tgl2');
		$tgl3=$this->input->post('tgl3');
		$tgl4=$this->input->post('tgl4');
		$tgl5=$this->input->post('tgl5');
		$tgl6=$this->input->post('tgl6');
		$tgl7=$this->input->post('tgl7');
		$tgl8=$this->input->post('tgl8');
		$tgl9=$this->input->post('tgl9');
		$tgl10=$this->input->post('tgl10');
		$tgl11=$this->input->post('tgl11');
		$tgl12=$this->input->post('tgl12');
		$tgl13=$this->input->post('tgl13');
		$tgl14=$this->input->post('tgl14');
		$tgl15=$this->input->post('tgl15');
		$tgl16=$this->input->post('tgl16');
		$tgl17=$this->input->post('tgl17');
		$tgl18=$this->input->post('tgl18');
		$tgl19=$this->input->post('tgl19');
		$tgl20=$this->input->post('tgl20');
		$tgl21=$this->input->post('tgl21');
		$tgl22=$this->input->post('tgl22');
		$tgl23=$this->input->post('tgl23');
		$tgl24=$this->input->post('tgl24');
		$tgl25=$this->input->post('tgl25');
		$tgl26=$this->input->post('tgl26');
		$tgl27=$this->input->post('tgl27');
		$tgl28=$this->input->post('tgl28');
		$tgl29=$this->input->post('tgl29');
		$tgl30=$this->input->post('tgl30');
		$tgl31=$this->input->post('tgl31');
		
		
		if ($tgl1<>'OFF') {
			$tgl=trim("$thn-$bln-01");
			$kdjamkerja=$tgl1;
				$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	
			
		} 	
		if ($tgl2<>'OFF') {
			$tgl=trim("$thn-$bln-02");
			$kdjamkerja=$tgl2;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);		

		} if ($tgl3<>'OFF') {
			$tgl=date("$thn-$bln-03");
			$kdjamkerja=$tgl3;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}  if ($tgl4<>'OFF') {
			$tgl=date("$thn-$bln-04");
			$kdjamkerja=$tgl4;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}  if ($tgl5<>'OFF') {
			$tgl=date("$thn-$bln-05");
			$kdjamkerja=$tgl5;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl6<>'OFF') {
			$tgl=date("$thn-$bln-06");
			$kdjamkerja=$tgl6;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);		

		}   if ($tgl7<>'OFF') {
			$tgl=date("$thn-$bln-07");
			$kdjamkerja=$tgl7;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl8<>'OFF') {
			$tgl=date("$thn-$bln-08");
			$kdjamkerja=$tgl8;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl9<>'OFF') {
			$tgl=date("$thn-$bln-09");
			$kdjamkerja=$tgl9;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl10<>'OFF') {
			$tgl=date("$thn-$bln-10");
			$kdjamkerja=$tgl10;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl11<>'OFF') {
			$tgl=date("$thn-$bln-11");
			$kdjamkerja=$tgl11;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl12<>'OFF') {
			$tgl=date("$thn-$bln-12");
			$kdjamkerja=$tgl12;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl13<>'OFF') {
			$tgl=date("$thn-$bln-13");
			$kdjamkerja=$tgl13;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl14<>'OFF') {
			$tgl=date("$thn-$bln-14");
			$kdjamkerja=$tgl14;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl15<>'OFF') {
			$tgl=date("$thn-$bln-15");
			$kdjamkerja=$tgl15;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl16<>'OFF') {
			$tgl=date("$thn-$bln-16");
			$kdjamkerja=$tgl16;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl17<>'OFF') {
			$tgl=date("$thn-$bln-17");
			$kdjamkerja=$tgl17;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl18<>'OFF') {
			$tgl=date("$thn-$bln-18");
			$kdjamkerja=$tgl18;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl19<>'OFF') {
			$tgl=date("$thn-$bln-19");
			$kdjamkerja=$tgl19;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl20<>'OFF') {
			$tgl=date("$thn-$bln-20");
			$kdjamkerja=$tgl20;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl21<>'OFF') {
			$tgl=date("$thn-$bln-21");
			$kdjamkerja=$tgl21;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl22<>'OFF') {
			$tgl=date("$thn-$bln-22");
			$kdjamkerja=$tgl22;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl23<>'OFF') {
			$tgl=date("$thn-$bln-23");
			$kdjamkerja=$tgl23;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl24<>'OFF') {
			$tgl=date("$thn-$bln-24");
			$kdjamkerja=$tgl24;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl25<>'OFF') {
			$tgl=date("$thn-$bln-25");
			$kdjamkerja=$tgl25;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl26<>'OFF') {
			$tgl=date("$thn-$bln-26");
			$kdjamkerja=$tgl26;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl27<>'OFF') {
			$tgl=date("$thn-$bln-27");
			$kdjamkerja=$tgl27;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl28<>'OFF') {
			$tgl=date("$thn-$bln-28");
			$kdjamkerja=$tgl28;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl29<>'OFF') {
			$tgl=date("$thn-$bln-29");
			$kdjamkerja=$tgl29;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl30<>'OFF') {
			$tgl=date("$thn-$bln-30");
			$kdjamkerja=$tgl30;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}   if ($tgl31<>'OFF') {
			$tgl=date("$thn-$bln-31");
			$kdjamkerja=$tgl31;
			$info = array(		
				'nik' => $nik,
				'tgl' => $tgl,	
				'kdjamkerja' => strtoupper($kdjamkerja),	
				'kdregu' => strtoupper($kdregu),
				'inputdate' => date('d-m-Y H:i:s'),				
				'inputby' => $this->session->userdata('nik')		
			);
			$this->db->insert('sc_trx.dtljadwalkerja',$info);	

		}  
		$this->db->where('nik',$nik);
		$this->db->delete('sc_tmp.regu_opr');
		redirect("master/regu/regu_opr/rep_succes");
	
	}
		
	
	function download_excel_reguopr(){
		$nama=$this->session->userdata('nik');
		$kmenu='I.M.F.3';
		$q_cek_bagianses=$this->m_regu->q_karyawan_session($nama)->row_array();
		$q_akses_ses=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$bag_dept=$q_cek_bagianses['bag_dept'];
		//$bag_dept=str_replace(' ',"%20",$bag_dept);
		if(trim($q_akses_ses['aksesfilter'])=='t'){
				$bag_dept="where c.bag_dept='$bag_dept'";
				$datane=$this->m_regu->q_regu_oprv($bag_dept);
		}else{
				$bag_dept="";
				$datane=$this->m_regu->q_regu_oprv($bag_dept);
		}		
		
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK', 'Nama Lengkap', 'Department','Kode Regu', 'Nama Regu'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap', 'nmdept', 'kdregu','nmregu'));
        $this->excel_generator->set_width(array(20,50,30,20,20));
        $this->excel_generator->exportTo2007("List Regu Operator");
	}
	
}	