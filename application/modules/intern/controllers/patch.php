<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Patch extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_patch','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','fiky_hexstring','image_lib')); 
	
    if(!$this->session->userdata('nama')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU,SILAHKAN PILIH MENU YANG ADA";
			$this->template->display('intern/cr_sj/v_index',$data);
	}
	
	
	function downloadPatch(){
		$startDate=$this->input->post('startDate');
		$endDate=$this->input->post('endDate');
		$userId=$this->input->post('userId');
		$patchid=$this->input->post('patchid');
		$patchdate=$this->input->post('patchdate');
        $order=" order by patchdate asc";
		$param=" 
		and (to_char(patchdate,'yyyy-mm-dd') > $patchdate
		and coalesce(useridspecification,'') in ('','$userId','ALL')
		and id!='$patchid''
		";

        $patchquery = $this->m_patch->q_patch_query($param,$order)->result();
        $row_patch = $this->m_patch->q_patch_query($param,$order)->num_rows();
		header("Content-Type: text/json");
		echo json_encode(
			array(
			'row' => $row_patch,
			'success' => true,
			'message' => '',
			'body' => array(
				'patchquery' => $patchquery,
                )
			)
		, JSON_PRETTY_PRINT);
	}
	
    function list_patch(){
        $data['title']="LIST PATCH";
        $nama=$this->session->userdata('nama');
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu='I.G.D.4';
        $versirelease='I.G.D.4/ALPHA.001';
        $userid=$this->session->userdata('nama');
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2018-08-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => date('Y-m-d H:i:s'),
                'update_by'   => $userid,
            );
            $this->db->where('kodemenu',$kodemenu);
            $this->db->update('sc_mst.version',$infoversi);
        }
        $vdb=$this->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */


        $paramerror=" and modul='PATCH' and userid='$nama'";
        $dtlerror=$this->m_patch->q_trxerror($paramerror)->row_array();
        if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }

        if($this->uri->segment(4)!=""){
            $data['message']="<div class='alert alert-info'>$errordesc</div>";
        }else {
            $data['message']="";
        }

        /* */
        $tgl=explode(' - ',$this->input->post('tgl'));
        if(!empty($this->input->post('tgl')) or ($this->input->post('tgl'))<>'') {
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $paramdate=" and to_char(patchdate,'yyyy-mm-dd') between '$tgl1' and '$tgl2' ";
        } else {
            $paramdate=" and to_char(patchdate,'yyyymm') = to_char(now(),'yyyymm') ";
        }
        $order=" order by patchdate desc ";
        $param=$paramdate;
        $data['list_patch']=$this->m_patch->q_patch_query($param,$order)->result();
        $this->template->display('intern/patch/v_list_patch',$data);
    }

    function save_patch(){
        $nama=$this->session->userdata('nama');
        $type=$this->input->post('type');
        $patchtext=$this->input->post('patchtext');
        $patchhold=$this->input->post('patchhold');
        $userspecification=$this->input->post('userspecification');
        $useridspecification=$this->input->post('useridspecification');
        $id=$this->input->post('id');
        $description=$this->input->post('description');
        $patchby=$nama;
        $patchdate=date('Y-m-d H:i:s');
        $inputdate=date('Y-m-d H:i:s');
        $inputby=$nama;

        $this->db->where('userid',$nama);
        $this->db->where('modul','PATCH');
        $this->db->delete('sc_mst.trxerror');

        if ($type=='inputPatch'){
            $infosave = array(
                'id                 ' => $nama     ,
                'patchdate          ' => $patchdate,
                'patchtext          ' => $patchtext,
                'patchby            ' => $patchby  ,
                'patchstatus        ' => 'I'       ,
                'patchhold          ' => 'NO'      ,
                'userspecification  ' => 'NO'      ,
                'useridspecification' => ''        ,
                'lastcommitdate     ' => NULL      ,
                'lastcommitby       ' => ''        ,
                'inputdate          ' => $inputdate,
                'inputby            ' => $inputby  ,
                'description        ' => $description
            );
            $this->db->insert('sc_mst.patch_query',$infosave);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PATCH');
            $this->db->delete('sc_mst.trxerror');
            $insinfo = array (
                'userid' => $nama,
                'errorcode' => 0,
                'modul' => 'PATCH'
            );
            $this->db->insert('sc_mst.trxerror',$insinfo);

        } else if ($type=='editPatch'){
            $infosaveedit = array(
                'patchtext          ' => $patchtext,
                'patchby            ' => $patchby  ,
                'patchstatus        ' => 'I'       ,
                'patchhold          ' => $patchhold,
                'userspecification  ' => $userspecification,
                'useridspecification' => $useridspecification,
                'updatedate          ' => $inputdate,
                'updateby            ' => $inputby  ,
                'description        ' => $description
            );
            $this->db->where('id',$id);
            $this->db->update('sc_mst.patch_query',$infosaveedit);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PATCH');
            $this->db->delete('sc_mst.trxerror');
            $insinfo = array (
                'nomorakhir1' => $id,
                'userid' => $nama,
                'errorcode' => 0,
                'modul' => 'PATCH'
            );
            $this->db->insert('sc_mst.trxerror',$insinfo);
        } else if ($type=='finalPatch'){
            $infosaveedit = array(
                'patchstatus        ' => 'F'       ,
                'updatedate          ' => $inputdate,
                'updateby            ' => $inputby
            );
            $this->db->where('id',$id);
            $this->db->update('sc_mst.patch_query',$infosaveedit);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PATCH');
            $this->db->delete('sc_mst.trxerror');
            $insinfo = array (
                'nomorakhir1' => $id,
                'userid' => $nama,
                'errorcode' => 0,
                'modul' => 'PATCH'
            );
            $this->db->insert('sc_mst.trxerror',$insinfo);
        } else if ($type=='cancelPatch'){
            $infosaveedit = array(
                'patchstatus        ' => 'C'       ,
                'updatedate          ' => $inputdate,
                'updateby            ' => $inputby
            );
            $this->db->where('id',$id);
            $this->db->update('sc_mst.patch_query',$infosaveedit);

            $this->db->where('userid',$nama);
            $this->db->where('modul','PATCH');
            $this->db->delete('sc_mst.trxerror');
            $insinfo = array (
                'nomorakhir1' => $id,
                'userid' => $nama,
                'errorcode' => 0,
                'modul' => 'PATCH'
            );
            $this->db->insert('sc_mst.trxerror',$insinfo);
        }
        redirect("intern/patch/list_patch");

    }

    function editPatch(){
        $id=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
        $nama=$this->session->userdata('nama');
        $order='';
        $param=" and id='$id'";

        $data['title']="UBAH PATCH OLEH $nama";
        $data['message']="PESAN";
        $data['dtl']=$this->m_patch->q_patch_query($param,$order)->row_array();

        $this->template->display('intern/patch/v_edit_patch',$data);
    }

    function detailPatch(){
        $id=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
        $nama=$this->session->userdata('nama');
        $order='';
        $param=" and id='$id'";

        $data['title']="DETAIL PATCH OLEH $nama";
        $data['message']="PESAN";
        $data['dtl']=$this->m_patch->q_patch_query($param,$order)->row_array();

        $this->template->display('intern/patch/v_detail_patch',$data);
    }

}