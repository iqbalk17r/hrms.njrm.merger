<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Smscenter extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('m_smscenter'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
 function index(){

		$data['title']="SMS HRD";		
		$data['title1']="List Inbox SMS HRD";
		$data['title2']="List Sent Item SMS HRD";		
		$data['title3']="List Trash Inbox SMS HRD";
		$data['title4']="List Trash Outbox SMS HRD";
		if($this->uri->segment(4)=="bc_failed")
            $data['message']="<div class='alert alert-warning'>Pastikan Isi SMS ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
		}
		switch ($bulan){
			case '01': $bul='Januari'; break;
			case '02': $bul='Februari'; break;
			case '03': $bul='Maret'; break;
			case '04': $bul='April'; break;
			case '05': $bul='Mei'; break;
			case '06': $bul='Juni'; break;
			case '07': $bul='Juli'; break;
			case '08': $bul='Agustus'; break;
			case '09': $bul='September'; break;
			case '10': $bul='Oktober'; break;
			case '11': $bul='November'; break;
			case '12': $bul='Desember'; break;
		}
		
		//echo $tgl;	
		$data['list_sms']=$this->m_smscenter->q_list_sms($tgl)->result();
		$data['list_outbox']=$this->m_smscenter->q_list_outbox($tgl)->result();
		$data['list_trash_inbox']=$this->m_smscenter->q_list_trash_inbox($tgl)->result();
		$data['list_trash_outbox']=$this->m_smscenter->q_list_trash_outbox($tgl)->result();
        $this->template->display('sms/smscenter/v_sms',$data);
	}
	
	function hps_sms($np){
	
		$info=array(
			'id'=>$np
		);
		$this->db->insert('sc_log.trash_sms',$info);
		
		//$this->db->insert('sc_log,trash_sms');
		redirect('sms/smscenter/index/del_succes');
	}
	
	function outbox(){
		$data['title']="List Outbox SMS Poin";
		if($this->uri->segment(4)=="pwd_failed")
            $data['message']="<div class='alert alert-warning'>Password tidak terupdate</div>";
        else if($this->uri->segment(3)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukes Dikirim </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';	
		$tglan=$this->input->post('tgl');
		$data['tgl']=$this->input->post('tgl');
		
		if (!empty($tglan)) { //harus di input dulu variabelnya
			$tgl=explode(' - ',$this->input->post('tgl')); //tanda pemisah antara variabel satu dengan dua
			$awal=$tgl[0];
			$akhir=$tgl[1];
			$list_outbox=$this->m_sms->q_filter_outbox($awal,$akhir)->result();
		}else{
			$list_outbox=$this->m_sms->q_list_outbox()->result();
		}
		$data['list_outbox']=$list_outbox;	
		
		
        $this->template->display('hrd/sms/v_outbox',$data);
	}
	
	function input_sms(){
		$penerima=$this->input->post('penerima');
		$isi_sms=trim($this->input->post('isi'));
		$info=array(
			'DestinationNumber'=>$penerima,
			'TextDecoded'=>$isi_sms,
			'CreatorID'=>$this->session->userdata('nik')
		);
		//$this->db->where('custcode',$kode);
		$this->db->insert('public.outbox',$info);
		redirect('sms/smscenter/index/rep_succes');
	}
	
	function broadcast_sms(){
		$penerima=$this->m_smscenter->q_listhpkaryawan()->result();
		$isi_sms=$this->input->post('isi');
		if(empty($isi_sms) or $isi_sms=''){
			redirect('sms/smscenter/index/bc_failed');
		}	
		foreach ($penerima as $pn){
			$isi_sms=$this->input->post('isi');
			$contact=trim($pn->hpya);
			$info=array(
				'DestinationNumber'=>$contact,
				'TextDecoded'=>$isi_sms,
				'CreatorID'=>$this->session->userdata('nik')
			);
			//$this->db->where('custcode',$kode);
			$this->db->insert('public.outbox',$info);
		}
		redirect('sms/smscenter/index/rep_succes'); 
	}
	
	
	function hps_sentitem($np){
		$info=array(
			'id'=>$np	
		);
		$this->db->insert('sc_log.trash_outbox',$info);
		redirect('sms/smscenter/index/del_succes');
	}
	
	function list_trash_inbox(){
		if($this->uri->segment(4)=="pwd_failed")
            $data['message']="<div class='alert alert-warning'>Password tidak terupdate</div>";
        else if($this->uri->segment(3)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukses Dikirim </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['title']="List Trash Inbox SMS Poin";
		$data['tgl']=$this->input->post('tgl');	
		$tglan=$this->input->post('tgl');
		if (!empty($tglan)) { //harus di input dulu variabelnya
			$tgl=explode(' - ',$this->input->post('tgl')); //tanda pemisah antara variabel satu dengan dua
			$awal=$tgl[0];
			$akhir=$tgl[1];
			$list_trash_inbox=$this->m_sms->q_filter_list_trash_inbox($awal,$akhir)->result();
		} else {
			$list_trash_inbox=$this->m_sms->q_list_trash_inbox()->result();
		}
		$data['list_trash_inbox']=$list_trash_inbox;
		//$data['list_trash_inbox']=$this->m_sms->q_list_trash_inbox()->result();		
		//$data['message']="List Trash SMS masuk";
        $this->template->display('v_trash_inbox',$data);
	}
	
	function hps_trash_inbox($id){
		
		$this->db->where('id',$id);
		$this->db->delete('sc_log.trash_sms');
		redirect('hrd/sms/index/del_succes');
	}
	
	function list_trash_outbox(){
		if($this->uri->segment(4)=="pwd_failed")
            $data['message']="<div class='alert alert-warning'>Password tidak terupdate</div>";
        else if($this->uri->segment(3)=="rep_succes")
            $data['message']="<div class='alert alert-success'>SMS Sukses Dikirim </div>";
		else if($this->uri->segment(3)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['title']="List Trash Inbox SMS Poin";
		$data['tgl']=$this->input->post('tgl');	
		$tglan=$this->input->post('tgl');
		if (!empty($tglan)) { //harus di input dulu variabelnya
			$tgl=explode(' - ',$this->input->post('tgl')); //tanda pemisah antara variabel satu dengan dua
			$awal=$tgl[0];
			$akhir=$tgl[1];
			$list_trash_outbox=$this->m_sms->q_filter_list_trash_outbox($awal,$akhir)->result();
		} else {
			$list_trash_outbox=$this->m_sms->q_list_trash_outbox()->result();
		}
		$data['list_trash_outbox']=$list_trash_outbox;	
		$data['title']="List Trash Outbox SMS Poin";		
		//$data['list_trash_outbox']=$this->m_sms->q_list_trash_outbox()->result();		
		//$data['message']="List Trash SMS keluar";
        $this->template->display('v_trash_outbox',$data);
	}
	
	function hps_trash_outbox($id){
		$this->db->where('id',$id);
		$this->db->delete('sc_log.trash_outbox');
		redirect('hrd/sms/index/del_succes');
	}
	
	function empty_trash_inbox(){
		$this->db->query('delete from sc_log.trash_sms');
		redirect('hrd/sms/index/del_succes');
	}
	
	function empty_trash_outbox(){
		$this->db->query('delete from sc_log.trash_outbox');
		redirect('hrd/sms/index/del_succes');
	}
	
		
}