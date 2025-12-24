<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Borong extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_borong','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Kategori Borong";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_exist")			
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
		
        else
            $data['message']='';
		$data['list_borong']=$this->m_borong->q_borong()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/borong/v_borong',$data);
    }
	function add_borong(){
		$kdborong=trim(strtoupper(str_replace(" ","",$this->input->post('kdborong'))));
		$nmborong=$this->input->post('nmborong');
		//$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdborong'=>$kdborong,
			'nmborong'=>strtoupper($nmborong),
			//'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_borong->q_cekborong($kdborong)->num_rows();
		if ($cek>0){
			redirect('master/borong/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.borong',$info);
			redirect('master/borong/index/rep_succes');
		}
		//echo $inputby;
	}
	
	function edit_borong(){
		$kdborong=trim($this->input->post('kdborong'));
		$nmborong=$this->input->post('nmborong');
		//$keterangan=$this->input->post('keterangan');
		//$kdsubdept=$this->input->post('kdsubdept');
		//$subdept=explode('|',$this->input->post('kdsubdept'));
		//$sub=$subdept[1];
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			//'kdborong'=>$kdborong,
			'nmborong'=>strtoupper($nmborong),
			//'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdborong',$kdborong);
			$this->db->update('sc_mst.borong',$info);
			redirect('master/borong/index/rep_succes');
		
		//echo $inputby;
	}
	
	function hps_borong($kdborong){
		$cek_delete=$this->m_borong->cek_del_borong($kdborong);		
		if ($cek_delete>0) {
			redirect('master/borong/index/del_exist');
		} else {
		$this->db->where('kdborong',$kdborong);
		$this->db->delete('sc_mst.borong');
		redirect('master/borong/index/del_succes');
		}
	}
	
	function sub_borong(){
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Sub Kategori Borong";
		
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="del_exist")
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
        else
            $data['message']='';
		
		$data['list_borong']=$this->m_borong->q_borong()->result();
		$data['list_sub_borong']=$this->m_borong->q_sub_borong()->result();
        $this->template->display('master/borong/v_sub_borong',$data);
	
	}
	function add_sub_borong(){
		$kdborong1=explode('|',$this->input->post('kdborong'));
		$kdborong=$kdborong1[0];
		$kdsub_borong=$this->input->post('kdsub_borong');
		$nmsub_borong=$this->input->post('nmsub_borong');
		$metrix=$this->input->post('metrix');
		$satuan=$this->input->post('satuan');
		$tarif_satuan=str_replace("_","",$this->input->post('tarif_satuan'));
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdborong'=>$kdborong,
			'kdsub_borong'=>strtoupper($kdsub_borong),
			'nmsub_borong'=>strtoupper($nmsub_borong),
			'metrix'=>strtoupper($metrix),
			'satuan'=>strtoupper($satuan),
			'tarif_satuan'=>$tarif_satuan,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		$cek=$this->m_borong->q_ceksub_borong($kdsub_borong)->num_rows();
		if ($cek>0){
			redirect('master/borong/sub_borong/kode_failed');
		} else {
			$this->db->insert('sc_mst.sub_borong',$info);
			redirect('master/borong/sub_borong/rep_succes');
		}
		//$this->db->insert('sc_mst.sub_borong',$info);
			//redirect('master/borong/sub_borong');
	}
	
	function hps_sub_borong($kdborong,$kdsub_borong){
		$cek_delete1=$this->m_borong->cek_del_sub_borong($kdborong,$kdsub_borong);		
		if ($cek_delete1>0) {
			redirect('master/borong/sub_borong/del_exist');
		} else {
		$this->db->where('kdsub_borong',$kdsub_borong);
		$this->db->delete('sc_mst.sub_borong');
		redirect('master/borong/sub_borong/del_succes');
		}
	}
	
	function edit_sub_borong(){
		$kdborong1=explode('|',$this->input->post('kdborong'));
		$kdborong=$kdborong1[0];
		$kdsub_borong=$this->input->post('kdsub_borong');
		$nmsub_borong=$this->input->post('nmsub_borong');
		$metrix=$this->input->post('metrix');
		$satuan=$this->input->post('satuan');
		$tarif_satuan=str_replace("_","",$this->input->post('tarif_satuan'));
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $sub;
		$info=array(
			'kdborong'=>$kdborong,
			'nmsub_borong'=>strtoupper($nmsub_borong),
			'metrix'=>strtoupper($metrix),
			'satuan'=>strtoupper($satuan),
			'tarif_satuan'=>$tarif_satuan,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			
			$this->db->where('kdsub_borong',$kdsub_borong);
			$this->db->update('sc_mst.sub_borong',$info);
			redirect('master/borong/sub_borong/rep_succes');
		
		//echo $inputby;
	}
	
	function target_borong(){
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Target Borong";
		//echo "test";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$data['list_borong']=$this->m_borong->q_borong()->result();
		$data['list_sub_borong']=$this->m_borong->q_sub_borong()->result();
        //var_dump($data['list_sub_borong']);die();
		$data['list_target_borong']=$this->m_borong->q_target_borong()->result();
        $this->template->display('master/borong/v_target_borong',$data);
	
	}
	
	function add_target_borong(){
		//$kdborong1=$this->input->post('kdborong'));
		$kdborong=$this->input->post('kdborong');
		//$kdsub_borong1=explode('|',$this->input->post('kdsub_borong'));
		$kdsub_borong=$this->input->post('kdsub_borong');
		$periode=$this->input->post('periode');
		$target1=str_replace("_","",$this->input->post('target1'));
		$target2=str_replace("_","",$this->input->post('target2'));
		$target3=str_replace("_","",$this->input->post('target3'));
		$target4=str_replace("_","",$this->input->post('target4'));
		$target5=str_replace("_","",$this->input->post('target5'));
		$target6=str_replace("_","",$this->input->post('target6'));
		$target7=str_replace("_","",$this->input->post('target7'));
		$target8=str_replace("_","",$this->input->post('target8'));
		$target9=str_replace("_","",$this->input->post('target9'));
		$target10=str_replace("_","",$this->input->post('target10'));
		$target11=str_replace("_","",$this->input->post('target11'));
		$target12=str_replace("_","",$this->input->post('target12'));
		$total_target=$target1+$target2+$target3+$target4+$target5+$target6+$target7+$target8+$target9+$target10+$target11+$target12;
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $kdsub_borong;
		$info=array(
			'kdborong'=>$kdborong,
			'kdsub_borong'=>$kdsub_borong,
			'periode'=>strtoupper($periode),
			'target1'=>$target1,
			'target2'=>$target2,
			'target3'=>$target3,
			'target4'=>$target4,
			'target5'=>$target5,
			'target6'=>$target6,
			'target7'=>$target7,
			'target8'=>$target8,
			'target9'=>$target9,
			'target10'=>$target10,
			'target11'=>$target11,
			'target12'=>$target12,
			'total_target'=>$total_target,
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_borong->q_ceksub_borong($kdsub_borong)->num_rows();
		if ($cek>0){
			redirect('master/borong/sub_borong/kode_failed');
		} else {
			$this->db->insert('sc_mst.sub_borong',$info);
			redirect('master/borong/sub_borong');
		}*/
		$this->db->insert('sc_mst.target_borong',$info);
		redirect('master/borong/target_borong/rep_succes');
	}
	function edit($no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("master/borong/target_borong");
		} else {
			$data['title']='EDIT DATA TARGET BORONG';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['list_borong']=$this->m_borong->q_borong()->result();
			$data['list_sub_borong']=$this->m_borong->q_sub_borong()->result();
			$data['list_tb']=$this->m_borong->q_target_borong_edit($no_urut)->row_array();
			$this->template->display('master/borong/v_edit_target_borong',$data);
		}
	}	
	function edit_target_borong(){
		$kdborong1=explode('|',$this->input->post('kdborong'));
		$kdborong=$kdborong1[0];
		$kdsub_borong1=explode('|',$this->input->post('kdsub_borong'));
		$kdsub_borong=$kdsub_borong1[0];
		$periode=$this->input->post('periode');
		$target1=str_replace("_","",$this->input->post('target1'));
		$target2=str_replace("_","",$this->input->post('target2'));
		$target3=str_replace("_","",$this->input->post('target3'));
		$target4=str_replace("_","",$this->input->post('target4'));
		$target5=str_replace("_","",$this->input->post('target5'));
		$target6=str_replace("_","",$this->input->post('target6'));
		$target7=str_replace("_","",$this->input->post('target7'));
		$target8=str_replace("_","",$this->input->post('target8'));
		$target9=str_replace("_","",$this->input->post('target9'));
		$target10=str_replace("_","",$this->input->post('target10'));
		$target11=str_replace("_","",$this->input->post('target11'));
		$target12=str_replace("_","",$this->input->post('target12'));
		$total_target=$target1+$target2+$target3+$target4+$target5+$target6+$target7+$target8+$target9+$target10+$target11+$target12;
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$no_urut=$this->input->post('no_urut');
		
		$info=array(
			'kdborong'=>$kdborong,
			'kdsub_borong'=>$kdsub_borong,
			'periode'=>strtoupper($periode),
			'target1'=>$target1,
			'target2'=>$target2,
			'target3'=>$target3,
			'target4'=>$target4,
			'target5'=>$target5,
			'target6'=>$target6,
			'target7'=>$target7,
			'target8'=>$target8,
			'target9'=>$target9,
			'target10'=>$target10,
			'target11'=>$target11,
			'target12'=>$target12,
			'total_target'=>$total_target,
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		$this->db->where('no_urut',$no_urut);
		$this->db->update('sc_mst.target_borong',$info);
		redirect('master/borong/target_borong/rep_succes');
		
	}
	
	function hps_target_borong($no_urut){
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_mst.target_borong');
		redirect('master/borong/target_borong/del_succes');
	}
}	