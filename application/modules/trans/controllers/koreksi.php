<?php

class Koreksi extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		//$this->load->model('m_cuti_karyawan');
        $this->load->model(array('m_koreksi','m_cuti_karyawan','master/m_akses'));
		$this->load->library(array('form_validation','template','upload','pdf','encrypt'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
		$data['title']="KOREKSI CUTI KARYAWAN";
        $nama=trim($this->session->userdata('nik'));
        $dtlbranch=$this->m_akses->q_branch()->row_array();
        $branch=$dtlbranch['branch'];
        /* CODE UNTUK VERSI */
        $kodemenu='I.C.I.1';
        $versirelease='I.C.I.1/ALPHA.001';
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
                'vdate'      => date('2017-07-10 11:18:00'),
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
        $paramerror=" and userid='$nama' and modul='KCB'";
        $dtlerror=$this->m_koreksi->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_koreksi->q_trxerror($paramerror)->num_rows();
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
        $tglYM=str_replace('-','',strtoupper(trim($this->input->post('tglYM'))));
        $fnik=strtoupper(trim($this->input->post('nik')));

        if (!empty($tglYM)) { $periode= $tglYM; } else { $periode=date('Ym'); }
        if (!empty($fnik)) { $pnik=" and nik='$fnik'"; } else {  $pnik=" "; }
        $ptgl = " and to_char(tgl_dok,'yyyymm')='$periode'";

            $data['list_koreksi']=$this->m_koreksi->list_trx_koreksicb($param=$ptgl.$pnik)->result();
        $this->template->display('trans/koreksi/v_koreksi',$data);
        $paramerror=" and userid='$nama'";
        $dtlerror=$this->m_koreksi->q_deltrxerror($paramerror);
	}

	function inputkoreksi(){
        $data['title']="INPUT KOREKSI";
        $data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
        $data['lTypeKoreksi']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI'")->result();
        $data['lTypeOperator']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI_OP'")->result();
        $data['listcb']=$this->m_koreksi->list_cb()->result();
        $this->template->display('trans/koreksi/v_inputkcb',$data);
    }

	function kcutibersama(){
		$data['title']="KOREKSI CUTI BERSAMA KARYAWAN";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve Atau Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes"){
			$nik=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Cuti NIK : <b>$nik</b> Sukses Disimpan </div>";
		}	
		else if($this->uri->segment(4)=="del_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Dihapus </div>";
		}	
		else if($this->uri->segment(4)=="app_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Di Approval</div>";
		}
		else if($this->uri->segment(4)=="cancel_succes"){	
            $nodok=$this->uri->segment(5);
			$data['message']="<div class='alert alert-danger'>Dokumen Dengan Nomor <b>$nodok</b> Telah Dibatalkan</div>";
		}
		else if($this->uri->segment(4)=="edit_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Data dengan Nomor: <b>$nodok</b> Berhasil Diubah</div>";
		}
        else if($this->uri->segment(4)=="nohakcuti")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Memilik Hak Cuti</div>";
		else
            $data['message']='';
		$data['list_kcb']=$this->m_koreksi->list_kcb()->result();
		$this->template->display('trans/koreksi/v_koreksicutibersama',$data);
	}
	
	function inputkcb(){
		$data['title']="INPUT KOREKSI";
		$data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
		$data['listcb']=$this->m_koreksi->list_cb()->result();
		$this->template->display('trans/koreksi/v_inputkcbersama',$data);
	}

    function editkcb(){
        $data['title']="EDIT KOREKSI";
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
        $data['listcb']=$this->m_koreksi->list_cb()->result();
        $data['lTypeKoreksi']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI'")->result();
        $data['lTypeOperator']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI_OP'")->result();
        $data['dtl']=$this->m_koreksi->list_trx_koreksicb($param=" and nodok = '".$nodok."'")->row_array();
        $this->template->display('trans/koreksi/v_editkcb',$data);
    }

    function approvkcb(){
        $data['title']="PERSETUJUAN KOREKSI";
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
        $data['listcb']=$this->m_koreksi->list_cb()->result();
        $data['lTypeKoreksi']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI'")->result();
        $data['lTypeOperator']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI_OP'")->result();
        $data['dtl']=$this->m_koreksi->list_trx_koreksicb($param=" and nodok = '".$nodok."'")->row_array();
        $this->template->display('trans/koreksi/v_approvkcb',$data);
    }

    function detailkcb(){
        $data['title']="DETAIL KOREKSI";
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
        $data['listcb']=$this->m_koreksi->list_cb()->result();
        $data['lTypeKoreksi']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI'")->result();
        $data['lTypeOperator']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI_OP'")->result();
        $data['dtl']=$this->m_koreksi->list_trx_koreksicb($param=" and nodok = '".$nodok."'")->row_array();
        $this->template->display('trans/koreksi/v_detailkcb',$data);
    }

    function cancelkcb(){
        $data['title']="BATAL KOREKSI";
        $nodok=$this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));

        $data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
        $data['listcb']=$this->m_koreksi->list_cb()->result();
        $data['lTypeKoreksi']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI'")->result();
        $data['lTypeOperator']=$this->m_koreksi->q_trxtype(" and jenistrx='K_CUTI_OP'")->result();
        $data['dtl']=$this->m_koreksi->list_trx_koreksicb($param=" and nodok = '".$nodok."'")->row_array();
        $this->template->display('trans/koreksi/v_cancelkcb',$data);
    }

	function savekcb(){
        $nama =  $this->session->userdata('nik');
        $type =  $this->input->post('type');
		$nodok=$this->input->post('nodok');
		$nik=$this->input->post('nik');
		$doctype=$this->input->post('doctype');
		$docref=$this->input->post('docref');
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$jumlahcuti=$this->input->post('jumlahcuti');
		$operator=$this->input->post('operator');
		$keterangan=strtoupper($this->input->post('keterangan'));
		$inputdate = date('Y-m-d H:i:s');
		$inputby = $nama;

        if ($type=='INPUT') {
            $info = array(
                'nodok'=>$nama,
                'tgl_dok'=>$inputdate,
                'nik'=>$nik,
                'docref'=>$docref,
                'tgl_awal'=>$tgl_awal,
                'tgl_akhir'=>$tgl_akhir,
                'jumlahcuti'=>$jumlahcuti,
                'doctype'=>$doctype,
                'operator'=>$operator,
                'keterangan'=>$keterangan,
                'input_date'=>$inputdate,
                'input_by'=>$inputby,
            );
            $this->db->insert('sc_tmp.koreksicb',$info);

            /* INSERT BARU */
            $this->db->where('userid',$nama);
            $this->db->where('modul','KCB');
            $this->db->delete('sc_mst.trxerror');
            /* error handling */
            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => '',
                'nomorakhir2' => '',
                'modul' => 'KCB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
        } else if ($type=='EDIT') {
            $info = array(
                'nik'=>$nik,
                'docref'=>$docref,
                'tgl_awal'=>$tgl_awal,
                'tgl_akhir'=>$tgl_akhir,
                'jumlahcuti'=>$jumlahcuti,
                'doctype'=>$doctype,
                'operator'=>$operator,
                'keterangan'=>$keterangan,
                'update_date'=>$inputdate,
                'update_by'=>$inputby,
            );
            $this->db->where('nodok',$nodok);
            $this->db->update('sc_trx.koreksicb',$info);

            /* INSERT BARU */
            $this->db->where('userid',$nama);
            $this->db->where('modul','KCB');
            $this->db->delete('sc_mst.trxerror');
            /* error handling */
            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => $nodok,
                'nomorakhir2' => '',
                'modul' => 'KCB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
        } else if ($type=='APPROVAL') {
            $info = array (
                'status' => 'P'
            );
            $this->db->where('nodok',$nodok);
            $this->db->update('sc_trx.koreksicb',$info);

            /* INSERT BARU */
            $this->db->where('userid',$nama);
            $this->db->where('modul','KCB');
            $this->db->delete('sc_mst.trxerror');
            /* error handling */
            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => $nodok,
                'nomorakhir2' => '',
                'modul' => 'KCB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
        } else if ($type=='CANCEL') {
            $info = array (
                'status' => 'C'
            );
            $this->db->where('nodok',$nodok);
            $this->db->update('sc_trx.koreksicb',$info);

            /* INSERT BARU */
            $this->db->where('userid',$nama);
            $this->db->where('modul','KCB');
            $this->db->delete('sc_mst.trxerror');
            /* error handling */
            $infotrxerror = array (
                'userid' => $nama,
                'errorcode' => 0,
                'nomorakhir1' => $nodok,
                'nomorakhir2' => '',
                'modul' => 'KCB',
            );
            $this->db->insert('sc_mst.trxerror',$infotrxerror);
        }

		redirect("trans/koreksi");
		
	}
	
	function hapuskcb(){
			$cek=$this->m_koreksi->cek_kcb($nodok)->num_rows();
			
			if ($cek==0) {
				redirect("trans/cuti_karyawan/cutibersama/index/kode_failed");
			} else {
				
				$this->db->query("delete from sc_trx.kcutibersama where nodok='$nodok' and status='I'");
				redirect("trans/cuti_karyawan/cutibersama/del_succes/$nodok");
			}
		
	}
	
	//view otoritas
	function viewotokcb($nodok){
		$data['title']='SAVE FINAL KOREKSI';
		$data['listcb']=$this->m_koreksi->list_cb()->result();
		$data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
		$data['dtl']=$this->m_koreksi->cek_kcb($nodok)->row_array();
		$this->template->display('trans/koreksi/v_otoinputkcbersama',$data);
	}
	
	
	
	//otoritas koresi
	function otokcb(){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$status='P';
		$tgldok=$this->input->post('tgl_dok');
		$docref=$this->input->post('docref');
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$jumlahcuti=$this->input->post('jumlahcuti');
		$tglinput=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$keterangan=$this->input->post('keterangan');
		$info=array(
			//'nodok'=>$nodok,
			'nik'=>$nik,
			'status'=>$status,
			'tgl_dok'=>$tgldok,
			'docref'=>$docref,
			'tgl_awal'=>$tgl_awal,
			'tgl_akhir'=>$tgl_akhir,
			'jumlahcuti'=>$jumlahcuti,
			'input_date'=>$tglinput,
			'input_by'=>$inputby,
			'keterangan'=>$keterangan
			
		);
			$this->db->where('nodok',$nodok);
					$this->db->update('sc_trx.koreksicb',$info);
					redirect("trans/koreksi/kcutibersama/index/app_succes/$nodok");
		/*$cek=$this->m_koreksi->cek_kcb($nodok)->row_array();

			if (trim($cek['status'])=='I') {

					$this->db->where('nodok',$nodok);
					$this->db->update('sc_trx.koreksicb',$info);
					redirect("trans/koreksi/kcutibersama/index/app_succes/$nodok");
			} 	
			else {	
					redirect("trans/koreksi/kcutibersama/kode_failed");
			}
			*/
	}
	
	
	function koreksi_khusus(){
		$data['title']="KOREKSI CUTI KONDISI KHUSUS";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve Atau Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes"){
			$nik=$this->uri->segment(5);
			$data['message']="<div class='alert alert-success'>Cuti NIK : <b>$nik</b> Sukses Disimpan </div>";
		}	
		else if($this->uri->segment(4)=="del_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Dihapus </div>";
		}	
		else if($this->uri->segment(4)=="app_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-success'>Dokumen Dengan Nomor <b>$nodok</b> Sukses Di Approval</div>";
		}
		else if($this->uri->segment(4)=="cancel_succes"){	
            $nodok=$this->uri->segment(5);
			$data['message']="<div class='alert alert-danger'>Dokumen Dengan Nomor <b>$nodok</b> Telah Dibatalkan</div>";
		}
		else if($this->uri->segment(4)=="edit_succes"){
			$nodok=$this->uri->segment(5);
            $data['message']="<div class='alert alert-danger'>Data dengan Nomor: <b>$nodok</b> Berhasil Diubah</div>";
		}
        else if($this->uri->segment(4)=="nohakcuti")
            $data['message']="<div class='alert alert-warning'>Anda Tidak Memilik Hak Cuti</div>";
		else
            $data['message']='';
		$data['list_kkstmp']=$this->m_koreksi->list_kkstmp()->result();
		$data['list_kksfinal']=$this->m_koreksi->list_kks()->result();
		
		$this->template->display('trans/koreksi/v_koreksikondisikhusus',$data);
	}
	
	function edit_koreksick(){
		$data['title']='EDIT KOREKSI CUTI KONDISI KHUSUS';
		$nodok=$this->uri->segment(4);
		$nik=$this->uri->segment(5);
		$jumlahcuti=$this->uri->segment(6);
		$data['listcb']=$this->m_koreksi->list_cb()->result();
		$data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
		$data['dtl']=$this->m_koreksi->cek_kks($nodok,$nik,$jumlahcuti)->row_array();
		$this->template->display('trans/koreksi/v_editkoreksikhusus',$data);
	}
	

	function koreksi_khususdtl(){
		
		$nik=$this->input->post('kdkaryawan');
		$tahun=$this->input->post('tahunlek');
		$nikht=$this->input->post('htgkry');
		$data['title']='List Balance';	
		$data['listkaryawan']=$this->m_koreksi->list_karyawan_index_2()->result();
		$data['listblc']=$this->m_koreksi->q_cutiblcdtl($nik,$tahun)->result();
		$data['tahun']=$tahun;
		$this->m_cuti_karyawan->q_proc_htg($nikht);
		$this->template->display('trans/koreksi/v_koreksikondisikhususdtl',$data);
		
	}
	function inputkoreksikhusus(){
		$data['title']="INPUT KOREKSI KONDISI KHUSUS";
		$data['list_karyawan']=$this->m_koreksi->list_karyawan()->result();
		$data['listcb']=$this->m_koreksi->list_cb()->result();
		$data['listcb2']=$this->m_koreksi->list_cb()->row_array();
		$this->template->display('trans/koreksi/v_inputkoreksikhusus',$data);
	}
	
	function save_finalkck(){
		$nodok=$this->uri->segment(4);
		$nik=$this->uri->segment(5);
		$tgl_dok=str_replace('%20',' ',$this->uri->segment(6));
		$jumlahcuti=$this->uri->segment(7);
		
		
		
		$info=array(
			'status'=>'P',
		);
		$this->db->where('nodok',$nodok);
		$this->db->where('nik',$nik);
		$this->db->where('tgl_dok',$tgl_dok);
		$this->db->where('jumlahcuti',$jumlahcuti);
		$this->db->update('sc_tmp.koreksicb',$info);
		$this->db->query("delete from sc_tmp.koreksicb 
							where nodok='$nodok' and nik='$nik' and tgl_dok='$tgl_dok' and jumlahcuti='$jumlahcuti' and doctype='X' ");
		redirect("trans/koreksi/koreksi_khusus");
		
	}
	
	function save_inputckk(){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodoksmt');;
		$status='I';
		$tgldok=$this->input->post('tgl_dok');
		$docref=$this->input->post('docref');
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$jumlahcuti=$this->input->post('jumlahcuti');
		$tglinput=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$doctype=$this->input->post('doctype');
		$keterangan=$this->input->post('keterangan');
	
		
		$info=array(
			'nodok'=>$nodok,
			'nik'=>$nik,
			'status'=>$status,
			'tgl_dok'=>$tgldok,
			'docref'=>$docref,
			'tgl_awal'=>$tgl_awal,
			'tgl_akhir'=>$tgl_akhir,
			'jumlahcuti'=>$jumlahcuti,
			'input_date'=>$tglinput,
			'input_by'=>$inputby,
			'doctype'=>$doctype,
			'keterangan'=>$keterangan
			
		);

		$this->db->insert('sc_tmp.koreksicb',$info);
		redirect("trans/koreksi/koreksi_khusus");
		
	}
	
	function save_editckk(){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodoksmt');;
		//$status='I';
		$tgldok=$this->input->post('tgl_dok');
		$docref=$this->input->post('docref');
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$jumlahcuti=$this->input->post('jumlahcuti');
		$tglinput=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$doctype=$this->input->post('doctype');
		$keterangan=$this->input->post('keterangan');
	
		
		$info=array(
			'nodok'=>$nodok,
			'nik'=>$nik,
			//'status'=>$status,
			'tgl_dok'=>$tgldok,
			'docref'=>$docref,
			//'tgl_awal'=>$tgl_awal,
			//'tgl_akhir'=>$tgl_akhir,
			'jumlahcuti'=>$jumlahcuti,
			'input_date'=>$tglinput,
			'input_by'=>$inputby,
			'doctype'=>$doctype,
			'keterangan'=>$keterangan
			
		);
		$this->db->where('nodok',$nodok);
		$this->db->where('status','I');
		$this->db->where('jumlahcuti',$jumlahcuti);
		$this->db->update('sc_tmp.koreksicb',$info);
		redirect("trans/koreksi/koreksi_khusus");
		
	}
	
	function hps_kck(){
			$nodok=$this->uri->segment(4);
			$nik=$this->uri->segment(5);
			$tgl_dok=str_replace('%20',' ',$this->uri->segment(6));
			$jumlahcuti=$this->uri->segment(7);
			$cek=$this->m_koreksi->cek_kks($nodok,$nik,$jumlahcuti)->num_rows();
			
			if ($cek=0) {
				redirect("trans/koreksi/koreksi_khusus/kode_failed");
			} else {
				
				$this->db->query("delete from sc_tmp.koreksicb 
				where nik='$nik' and nodok='$nodok' and tgl_dok='$tgl_dok' and jumlahcuti='$jumlahcuti' and doctype='X'");
				redirect("trans/koreksi/koreksi_khusus/del_succes/$nodok");
			}
		
	}
	
	
	
	
}