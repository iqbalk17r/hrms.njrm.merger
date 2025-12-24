<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Cr_sj extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_cr_sj'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','fiky_hexstring','image_lib')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/cr_sj/v_index',$data);
	}
	
	function form_cr_sj(){
		$data['title']="&nbsp LIST DATA PENGIRIMAN";	
		$nama=trim($this->session->userdata('nama'));
		
		$paramerror=" and fc_userid='$nama'";
		$dtlerror=$this->m_cr_sj->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_cr_sj->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['DESKRIPSI'])) { $errordesc=trim($dtlerror['DESKRIPSI']); } else { $errordesc='';  }
		if(isset($dtlerror['fc_nomorakhir1'])) { $nomorakhir1=trim($dtlerror['fc_nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['fc_errorcode'])) { $errorcode=trim($dtlerror['fc_errorcode']); } else { $errorcode='';  }

		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['fc_errorcode']==0){
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
		/*cek jika ada inputan edit atau input*/
		$param3_1_1=" and fc_trxno='$nama' and fc_status='I'";
		$param3_1_2=" and fc_trxno='$nama' and fc_status='E'";
		$param3_1_3=" and fc_trxno='$nama' and fc_status='A'";
		$param3_1_R=" and fc_trxno='$nama'";
			$cekdtl_na=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param3_1_1)->num_rows(); //input
			$cekdtl_ne=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param3_1_2)->num_rows(); //edit
			$cekdtl_napp=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param3_1_3)->num_rows(); //edit
			$dtledit=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param3_1_R)->row_array(); //edit row array
			//echo $coba=trim(isset($dtledit['nodoktmp']));	
			//$data['enc_nik']=bin2hex($this->encrypt->encode($nama));
			if ($cekdtl_na>0) { //cek inputan
					$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($dtledit['fv_reference'])));
					redirect("intern/cr_sj/input_cr_sj/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			} else if ($cekdtl_ne>0){	//cek edit
					$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($dtledit['fv_reference'])));
					redirect("intern/cr_sj/input_cr_sj/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}  else if ($cekdtl_napp>0){	//cek APPROVAL
					$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($dtledit['fv_reference'])));
					redirect("ga/cr_sj/input_cr_sj/$enc_nodok");
					//redirect("ga/permintaan/direct_lost_input");
			}					
		$param='';
		//$data['list_inmst']=$this->m_cr_sj->q_trans_inmst($param)->result();
        $this->template->display('intern/cr_sj/v_list_sj',$data);
		
		$dtlerror=$this->m_cr_sj->q_deltrxerror($paramerror);
		/* RESET TRXERRROR */
	}
	
	function cr_sj_pagination(){
		$nama=$this->session->userdata('nama');
		$param_list_akses='';
		$list = $this->m_cr_sj->get_transaksi_T_INMST_WEB($param_list_akses);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lpo) {
			$no++;
			$row = array();	
			$row[] = $no;
			IF (TRIM($lpo->fc_status)=='I') {
			$row[] = '
				<a class="btn btn-sm btn-default" href="'.site_url('intern/cr_sj/detail_cr_sj').'/'.$this->fiky_hexstring->b2h($this->encrypt->encode(trim($lpo->fc_trxno))).'" title="Detail Load"><i class="glyphicon glyphicon-search"></i> Detail </a>
				<a class="btn btn-sm btn-danger" href="'.site_url('intern/cr_sj/batal_cr_sj').'/'.$this->fiky_hexstring->b2h($this->encrypt->encode(trim($lpo->fc_trxno))).'" title="Cancel Load"><i class="glyphicon glyphicon-search"></i> Batal </a>';
				/*<a class="btn btn-sm btn-warning" href="'.site_url('intern/printer/print_text').'/'.($lpo->fc_trxno).'" title="Detail Load"><i class="glyphicon glyphicon-search"></i> Cetak </a>';	*/
			} ELSE {
			$row[] = '			
				<a class="btn btn-sm btn-default" href="'.site_url('intern/cr_sj/detail_cr_sj').'/'.$this->fiky_hexstring->b2h($this->encrypt->encode(trim($lpo->fc_trxno))).'" title="Detail Load"><i class="glyphicon glyphicon-search"></i> Detail </a>';
	

			}
			$row[] = TRIM($lpo->fc_trxno);
			$row[] = TRIM($lpo->fv_reference);
			$row[] = TRIM($lpo->status);
			$data[] = $row;
	
		}
    
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_cr_sj->q_row_transaksi_T_INMST_WEB($param_list_akses)->num_rows(),
						"recordsFiltered" => $this->m_cr_sj->q_row_transaksi_T_INMST_WEB($param_list_akses)->num_rows(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
					
	}
	
	function chose_option_cr_sj(){
		$inputfill=strtoupper(trim($this->input->post('inputfill')));
		$nama=trim($this->session->userdata('nama'));
		if ($inputfill=='POB'){
			redirect("intern/cr_sj/f_vlist_po_mst/B");
		} else 	if ($inputfill=='POA'){
			redirect("intern/cr_sj/f_vlist_po_mst/A");
		}  
	}
	
	function f_vlist_po_mst(){
		$data['title']='PURCHASE ORDER LIST';
		$nama=$this->session->userdata('nama');
		$jenis=trim($this->uri->segment(4));			
		//$param_mst=" and fc_potipe='B' and fc_postatus IN ('F','S');
		if($jenis=='A'){
			$param_mst=" and fc_potipe IN ('A') and fc_postatus IN ('P','S','F') 
		and fc_pono in (select pono
					from 
					(
						select x.pono,sum(x.jmlpo) as jmlpo,sum(x.jmlweb) as jmlweb,sum(x.jmlpo)-sum(x.jmlweb) as selisih
						from (
							select a.fc_pono as pono,b.fc_stockcode,(b.fn_qty+b.fn_extra) as jmlpo,0 as jmlweb
							from sc_trx.t_pomst a 
							left outer join sc_trx.t_podtl b 
								on a.fc_pono=b.fc_pono
							where a.fc_postatus in ('S','P','F')
							union all
							select a.FC_FROMNO as pono,b.fc_stockcode,0 as jmlpo,(b.fn_qtyrec+b.fn_extrarec) as jmlweb
							from sc_trx.t_inmst_web a 
							left outer join sc_trx.t_indtl_web b 
								on a.fc_trxno=b.fc_trxno
							where a.fc_status<>'C'
						) as x
						group by x.pono
					) as y
					where y.selisih>0)
		order by fc_pono desc,fd_podate desc";
		} else if($jenis=='B'){
			$param_mst=" and fc_potipe IN ('B') and fc_postatus IN ('P','S','F') 
		and fc_pono in (select pono
					from 
					(
						select x.pono,sum(x.jmlpo) as jmlpo,sum(x.jmlweb) as jmlweb,sum(x.jmlpo)-sum(x.jmlweb) as selisih
						from (
							select a.fc_pono as pono,b.fc_stockcode,(b.fn_qty+b.fn_extra) as jmlpo,0 as jmlweb
							from sc_trx.t_pomst a 
							left outer join sc_trx.t_podtl b 
								on a.fc_pono=b.fc_pono
							where a.fc_postatus in ('S','P','F')
							union all
							select a.fc_fromno as pono,b.fc_stockcode,0 as jmlpo,(b.fn_qtyrec+b.fn_extrarec) as jmlweb
							from sc_trx.t_inmst_web a 
							left outer join sc_trx.t_indtl_web b 
								on a.fc_trxno=b.fc_trxno
							where a.fc_status<>'C'
						) as x
						group by x.pono
					) as y
					where y.selisih>0)
		order by fc_pono desc,fd_podate desc";
		}
		
		$param_dtl="";
		$data['list_transaksi_vw_tw_pomst']=$this->m_cr_sj->q_d_transaksi_vw_tw_pomst($param_mst)->result();
		$data['list_transaksi_vw_tw_podtl']=$this->m_cr_sj->q_d_transaksi_vw_tw_podtl($param_dtl)->result();

		$this->template->display('intern/cr_sj/v_listpo_for_cr_sj',$data);
	}
	
	function lihat(){
		echo $this->fiky_hexstring->b2h('test');
	}
	
	function input_cr_sj(){
	    $nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
	    $nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
	    
		
		/* UNTUK INPUT TYPE GUDANG */
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and FC_FROMNO='$nodok'";
		$cek_tmp=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param_cek_1doc)->num_rows();
		
		if ($cek_tmp==0 and !empty($nodok)) {
			if($cek_tmp>0) {
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 75,
					'fc_nomorakhir1' => $nodok,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);	
				redirect("intern/cr_sj/form_cr_sj");
			} else {
				$this->m_cr_sj->insert_pomst_to_inmst($nodok,$nama,$loccode);						
			/*	$this->db->where('userid',$nama);
				$this->db->where('modul','TMPSTBBM');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => $nodokref,
					'nomorakhir2' => '',
					'modul' => 'TMPSTBBM',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror); */
			}
		} else if ($cek_tmp>0 and !empty($nodok)) {
			$paramcekrev=" and fc_fromno='$nodok'";
			$dtl_tmp=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($paramcekrev)->row_array();
			if (isset($dtl_tmp['fc_trxno'])){ $nodok_isset=trim($dtl_tmp['fc_trxno']); } else { $nodok_isset='';	} 
			
			if ($nodok_isset<>trim($nama)) {
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 75,
					'fc_nomorakhir1' => $nodok,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);	
				redirect("intern/cr_sj/form_cr_sj");
			}
		}
		/* end bloking multi user harus ada 1 yg bisa ke temporary*/
						
		$param_tmp_inmst=" and fc_trxno='$nama'";
		$param_tmp_indtl=" and fc_trxno='$nama'";
		
		$paramerror=" and fc_userid='$nama'";
		$dtlerror=$this->m_cr_sj->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_cr_sj->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['deskripsi'])) { $errordesc=trim($dtlerror['deskripsi']); } else { $errordesc='';  }
		if(isset($dtlerror['fc_nomorakhir1'])) { $nomorakhir1=trim($dtlerror['fc_nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['fc_errorcode'])) { $errorcode=trim($dtlerror['fc_errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['fc_errorcode']==0){
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
		
		$data['title']="LIST DATA PENGIRIMAN BY $nama";
		$data['nama']=$nama;
		$data['list_tmp_T_INMST_WEB']=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param_tmp_inmst)->result();
		$data['list_tmp_T_INDTL_WEB']=$this->m_cr_sj->q_d_temporary_vw_T_INDTL_WEB($param_tmp_indtl)->result();
		$data['dtl_tmp_PONO']=$this->m_cr_sj->q_link_pono($param_tmp_inmst)->row_array();
		$data['list_expedisi']=$this->m_cr_sj->q_expedisi()->result();
		$data['list_gudang']=$this->m_cr_sj->q_gudang()->result();
		$this->template->display('intern/cr_sj/v_input_cr_sj',$data);
		
						
		$dtlerror=$this->m_cr_sj->q_deltrxerror($paramerror);
		/* RESET TRXERRROR */
	}
	
	function clear_tmp_inmst(){
		$nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
	    $nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
		
		/*if(empty($nodok)){
			redirect("intern/cr_sj/form_cr_sj/clear_fail");
		}*/		
			$param3_1_2=" and fc_trxno='$nama'";
			$dtledit=$this->m_cr_sj->q_d_temporary_vw_t_inmst_web($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['fc_status']); 

			/* clearing temporary  */
			$this->db->where('fc_trxno',$nama);
			$this->db->delete('sc_tmp.t_inmst_web');
			$this->db->where('fc_trxno',$nama);
			$this->db->delete('sc_tmp.t_indtl_web');
					
			redirect("intern/cr_sj/form_cr_sj/clear_success");
	}
	
	

	function save_cr_sj(){
		$nama=trim($this->session->userdata('nama'));
		$loccode=trim($this->session->userdata('location'));
		$type=strtoupper(trim($this->input->post('type')));
		$fc_trxno=strtoupper(trim($this->input->post('fc_trxno')));
		$fc_docno=strtoupper(trim($this->input->post('fc_docno')));
		$fc_fromno=strtoupper(trim($this->input->post('fc_fromno')));
		$fv_reference=strtoupper(trim($this->input->post('fv_reference')));
		$fd_reftgl=strtoupper(trim($this->input->post('fd_reftgl')));
		$fc_expedisi=strtoupper(trim($this->input->post('fc_expedisi')));
		$fc_hpdriver=strtoupper(trim($this->input->post('fc_hpdriver')));
		$fc_namedriver=strtoupper(trim($this->input->post('fc_namedriver')));
		$fc_nopol=strtoupper(trim($this->input->post('fc_nopol')));
		$fn_nomor=strtoupper(trim($this->input->post('fn_nomor')));
		$fc_stockcode=strtoupper(trim($this->input->post('fc_stockcode')));
		$fn_qty=strtoupper(trim($this->input->post('fn_qty')));
		$fn_qtyrec=strtoupper(trim($this->input->post('fn_qtyrec')));
		$fn_extra=strtoupper(trim($this->input->post('fn_extra')));
		$fn_extrarec=strtoupper(trim($this->input->post('fn_extrarec')));
		$fc_loccode=strtoupper(trim($this->input->post('fc_loccode')));
		$fc_franco=strtoupper(trim($this->input->post('fc_franco')));
		
			
		if ($type=='EDINPUT_INMST_WEB'){
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$config['upload_path'] = './assets/img/foto_sj';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '50000';
				$config['max_width']  = '36240';
				$config['max_height']  = '32000';
				$config['file_name']  =  $fc_fromno.date('Y-m-d H:i:s', strtotime(trim($fd_reftgl)));
				$config['encrypt_name'] = true;
						
				$n_w = 273; // destination image's width
				$n_h = 246; // destination image's height		
				$config2['image_library'] = 'gd2';
				$config2['new_image'] = './assets/img/foto_sj';
				$config2['maintain_ratio'] = TRUE;
				$config2['width'] = $n_w;
				$config2['height'] = $n_h;				
					
				$this->upload->initialize($config);
				$this->image_lib->initialize($config2);
				
				$coba=$this->upload->do_upload('ft_image');
			    $this->image_lib->resize($coba);	
				
				if(!$coba){
					$gambar="";
					$data['message']="<div class='alert alert-danger'>Gambar Tidak Sesuai</div>";
					echo 'Gambar Tidak Sesuai</br>
						Format yang sesuai:</br>
						* Ukuran File yang di ijinkan max 2MB</br>
						* Lebar Max 2000 pixel</br>
						* Tinggi Max 2000 pixel</br>					
						';
				} else {
						//Image Resizing
												
					$n_w = 273; // destination image's width
					$n_h = 246; // destination image's height		
					$config2['image_library'] = 'gd2';
					$config2['new_image'] = './assets/img/foto_sj';
					$config2['maintain_ratio'] = TRUE;
					$config2['width'] = $n_w;
					$config2['height'] = $n_h;		
					$this->image_lib->initialize($config2);
					
					$tester = $this->upload->data();
					$this->image_lib->resize($tester);
					$config['source_image'] = $this->upload->upload_path.$this->upload->$tester['file_name'];
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 480;
					$config['height'] = 640;
		
					$file_name = $tester['file_name'];
					$file_type = $tester['file_type'];
					$file_path = base_url('/assets/img/foto_sj/'.$tester['file_name']);
					$file_origname = $tester['orig_name'];
					$file_ext = $tester['file_ext'];
					$file_size = $tester['file_size'];
					$this->image_lib->resize($config);		
					$this->load->library('image_lib', $config);
					//echo $fd_reftgl;
				}	
				
					$info_dtl = array (
						'fv_reference' => $fv_reference,	
						'fd_reftgl' =>  date('Y-m-d', strtotime(trim($fd_reftgl))),	
						'fc_expedisi' => $fc_expedisi,	
						'fc_hpdriver' => $fc_hpdriver,	
						'fc_namedriver' => $fc_namedriver,	
						'fc_nopol' => $fc_nopol,	
						'fc_loccode' => $fc_loccode,	
						'fc_franco' => $fc_franco,	
						'ft_image' => $file_name,	
					);
					$this->db->where('fc_trxno',$nama);
					$this->db->update('sc_tmp.t_inmst_web',$info_dtl);
				$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($fv_reference)));
				redirect("intern/cr_sj/input_cr_sj/$enc_nodok");
		} else if ($type=='EDINPUT_INDTL_WEB'){
			if ($fn_qty<$fn_qtyrec or $fn_qtyrec<=0 or $fn_extra<$fn_extrarec){
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 75,
					'fc_nomorakhir1' => $nama,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);
				$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($fv_reference)));
				redirect("intern/cr_sj/input_cr_sj/$enc_nodok");
			} else {
				$info_dtl = array (
					'fn_qtyrec' => $fn_qtyrec,	
					'fn_extrarec' => $fn_extrarec,	
				);
				$this->db->where('fc_trxno',$fc_trxno);
				$this->db->where('fn_nomor',$fn_nomor);
				$this->db->where('fc_stockcode',$fc_stockcode);
				$this->db->update('sc_tmp.t_indtl_web',$info_dtl);
				
				/* DELETE TRXERROR */
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 0,
					'fc_nomorakhir1' => $fv_reference,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);
				$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($fv_reference)));				
				redirect("intern/cr_sj/input_cr_sj/$enc_nodok");
			}

		} else {
			redirect("intern/cr_sj/form_cr_sj");
		}
		
	}
	
	function reset_input(){
		$nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');

			$param3_1_2=" and fc_trxno='$nama'";
			$dtledit=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param3_1_2)->row_array(); //edit row array
			$status=trim($dtledit['fc_status']); 
			$nodok=trim($dtledit['fc_fromno']); 

			/* clearing temporary  */
			
			$info = array (
				'fn_qtyrec' => 0,	
				'fn_extrarec' => 0,	
			);
			
			$this->db->where('fc_trxno',$nama);
			$this->db->update('sc_tmp.t_indtl_web',$info);
					
			redirect("intern/cr_sj/form_cr_sj");
	}
	
	function final_input_cr_sj(){
		$nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');

			$param3_1_2=" and fc_trxno='$nama'";
			$dtledit=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param3_1_2)->row_array(); //edit row array
			$row_dtl=$this->m_cr_sj->q_d_temporary_vw_T_INDTL_WEB_SUMARY($param3_1_2)->row_array();
			
			
			$status=trim($dtledit['fc_status']); 
			$nodok=trim($dtledit['fc_fromno']); 
			$row_cek=$row_dtl['sum_qtyrec'];
			

			
			if ($row_cek==0 OR (empty($dtledit['fv_reference']) or ($dtledit['fv_reference'])=='' or ($dtledit['fv_reference'])== NULL)) {
				$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($nodok)));
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 75,
					'fc_nomorakhir1' => $nodok,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);		
				redirect("intern/cr_sj/input_cr_sj/$enc_nodok");
			} else {
				/* final temporary  */
				$info = array (
					'fc_status' => 'F',	
				);
				
				$this->db->where('fc_trxno',$nama);
				$this->db->UPDATE('sc_tmp.t_inmst_web',$info);
				
				$param3_1_3=" and fc_fromno='$nodok'";
				$row_trx=$this->m_cr_sj->q_max_inmst_web($param3_1_3)->row_array();
				
								/* DELETE TRXERROR */
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 0,
					'fc_nomorakhir1' => $row_trx['fc_trxno'],
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);		
				redirect("intern/cr_sj/form_cr_sj");
			}
	}
	
	function detail_cr_sj(){
	    $nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
	    $nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
	    
					
		$param_trx_inmst=" and fc_trxno='$nodok' ";
		$param_trx_indtl=" and fc_trxno='$nodok' ";
		
		$paramerror=" and fc_userid='$nama'";
		$dtlerror=$this->m_cr_sj->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_cr_sj->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['DESKRIPSI'])) { $errordesc=trim($dtlerror['DESKRIPSI']); } else { $errordesc='';  }
		if(isset($dtlerror['fc_nomorakhir1'])) { $nomorakhir1=trim($dtlerror['fc_nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['fc_errorcode'])) { $errorcode=trim($dtlerror['fc_errorcode']); } else { $errorcode='';  }
		
		$data['message']="";

		$data['title']="LIST DATA PENGIRIMAN BY $nama";
		$data['nama']=$nama;
		$data['trxno']=trim($this->uri->segment(4));
		$data['list_trx_t_inmst_web']=$this->m_cr_sj->q_d_transaksi_vw_T_INMST_WEB($param_trx_inmst)->result();
		$data['list_trx_t_indtl_web']=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB($param_trx_indtl)->result();
		$data['list_expedisi']=$this->m_cr_sj->q_expedisi()->result();
		$this->template->display('intern/cr_sj/v_detail_cr_sj',$data);
		
						
		$dtlerror=$this->m_cr_sj->q_deltrxerror($paramerror);
		/* RESET TRXERRROR */
	}
	
	function edit_cr_sj(){
	    $nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
	    $nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
	    
		
		/* UNTUK INPUT TYPE GUDANG */
		/* bloking multi user harus ada 1 yg bisa ke temporary*/
		$param_cek_1doc=" and FC_FROMNO='$nodok'";
		$cek_tmp=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param_cek_1doc)->num_rows();
		
		if ($cek_tmp==0 and !empty($nodok)) {
			if($cek_tmp>0) {
				redirect("intern/cr_sj/form_cr_sj/input_fail");
			} else {
				$this->m_cr_sj->insert_pomst_to_inmst($nodok,$nama,$loccode);						
			/*	$this->db->where('userid',$nama);
				$this->db->where('modul','TMPSTBBM');
				$this->db->delete('sc_mst.trxerror');
				
				$infotrxerror = array (
					'userid' => $nama,
					'errorcode' => 0,
					'nomorakhir1' => $nodokref,
					'nomorakhir2' => '',
					'modul' => 'TMPSTBBM',
				);
				$this->db->insert('sc_mst.trxerror',$infotrxerror); */
			}
		} else if ($cek_tmp>0 and !empty($nodok)) {
			$paramcekrev=" AND FC_FROMNO='$nodok'";
			$dtl_tmp=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($paramcekrev)->row_array();
			if (isset($dtl_tmp['fc_trxno'])){ $nodok_isset=trim($dtl_tmp['fc_trxno']); } else { $nodok_isset='';	} 
			
			if ($nodok_isset<>trim($nama)) {
				redirect("intern/cr_sj/form_cr_sj/input_fail");
			}
		}
		/* end bloking multi user harus ada 1 yg bisa ke temporary*/
						
		$param_tmp_inmst='';
		$param_tmp_indtl='';
		
		$paramerror=" and fc_userid='$nama'";
		$dtlerror=$this->m_cr_sj->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_cr_sj->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['DESKRIPSI'])) { $errordesc=trim($dtlerror['DESKRIPSI']); } else { $errordesc='';  }
		if(isset($dtlerror['fc_nomorakhir1'])) { $nomorakhir1=trim($dtlerror['fc_nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['fc_errorcode'])) { $errorcode=trim($dtlerror['fc_errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['fc_errorcode']==0){
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
		
		$data['title']="LIST DATA PENGIRIMAN BY $nama";
		$data['nama']=$nama;
		$data['list_tmp_T_INMST_WEB']=$this->m_cr_sj->q_d_temporary_vw_T_INMST_WEB($param_tmp_inmst)->result();
		$data['list_tmp_T_INDTL_WEB']=$this->m_cr_sj->q_d_temporary_vw_T_INDTL_WEB($param_tmp_indtl)->result();
		$data['list_expedisi']=$this->m_cr_sj->q_expedisi()->result();
		$this->template->display('intern/cr_sj/v_input_cr_sj',$data);
		
						
		$dtlerror=$this->m_cr_sj->q_deltrxerror($paramerror);
		/* RESET TRXERRROR */
	}
	
	function batal_cr_sj(){
	    $nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
	    $nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
	    
					
		$param_trx_inmst=" and fc_trxno='$nodok' ";
		$param_trx_indtl=" and fc_trxno='$nodok' ";
		
		$paramerror=" and fc_userid='$nama'";
		$dtlerror=$this->m_cr_sj->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_cr_sj->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['DESKRIPSI'])) { $errordesc=trim($dtlerror['DESKRIPSI']); } else { $errordesc='';  }
		if(isset($dtlerror['fc_nomorakhir1'])) { $nomorakhir1=trim($dtlerror['fc_nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['fc_errorcode'])) { $errorcode=trim($dtlerror['fc_errorcode']); } else { $errorcode='';  }
		
		$data['message']="";

		$data['title']="LIST DATA PENGIRIMAN BY $nama";
		$data['nama']=$nama;
		$data['nodok']=$nodok;
		$data['list_trx_t_inmst_web']=$this->m_cr_sj->q_d_transaksi_vw_T_INMST_WEB($param_trx_inmst)->result();
		$data['list_trx_t_indtl_web']=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB($param_trx_indtl)->result();
		$this->template->display('intern/cr_sj/v_batal_cr_sj',$data);
		
						
		$dtlerror=$this->m_cr_sj->q_deltrxerror($paramerror);
		/* RESET TRXERRROR */
	}

	function batal_input_cr_sj(){
		$nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
		$nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
		
			$param3_1_2=" and fc_trxno='$nodok'";
			$dtledit=$this->m_cr_sj->q_d_transaksi_vw_T_INMST_WEB($param3_1_2)->row_array(); //edit row array
		
			
			
			$status=trim($dtledit['fc_status']); 
			
			

			if ($status!='I') {
				$enc_nodok=$this->fiky_hexstring->b2h($this->encrypt->encode(trim($nodok)));
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 75,
					'fc_nomorakhir1' => $nodok,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);
				//	echo 'A';
				redirect("intern/cr_sj/form_cr_sj");
			} else {
				/* final temporary  */
				$info = array (
					'fc_status' => 'C',	
				);
				
				$this->db->where('fc_trxno',$nodok);
				$this->db->update('sc_trx.t_inmst_web',$info);
						
								/* DELETE TRXERROR */
				$this->db->where('fc_userid',$nama);
				$this->db->delete('sc_mst.t_trxerror');
				
				$infotrxerror = array (
					'fc_userid' => $nama,
					'fc_errorcode' => 0,
					'fc_nomorakhir1' => $nodok,
					'fc_nomorakhir2' => '',
				);
				$this->db->insert('sc_mst.t_trxerror',$infotrxerror);		
				redirect("intern/cr_sj/form_cr_sj");
				//echo 'B';
			}
	}

	function form_list_po(){
		$data['title']="&nbsp LIST DATA PURCHASE ORDER";	
		$nama=trim($this->session->userdata('nama'));
		
		$data['message']="";
        $this->template->display('intern/cr_sj/v_list_pomst',$data);

		/* RESET TRXERRROR */
	}
	
	function cr_sj_pomst_pagination(){
		$nama=$this->session->userdata('nama');
		$param_list_akses=''; //PARAMETER UNTUK LIST PO
		$list = $this->m_cr_sj->get_transaksi_T_PO_MST($param_list_akses);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lpo) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $lpo->fc_pono;
			if (isset($lpo->fv_podate)) { $row[] = date('d-m-Y', strtotime(trim($lpo->fv_podate))); } else { $row[] = ''; } 
			$row[] = $lpo->status;
			$row[] = $lpo->fv_suppname;		
			$row[] = $lpo->tipe;		
			$row[] = '			
				<a class="btn btn-sm btn-default" href="'.site_url('intern/cr_sj/detail_po_mst').'/'.$this->fiky_hexstring->b2h($this->encrypt->encode(trim($lpo->fc_pono))).'" title="Detail Load"><i class="glyphicon glyphicon-search"></i> Detail </a>';

			$data[] = $row;
	
		}
    
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_cr_sj->q_row_transaksi_T_PO_MST($param_list_akses)->num_rows(),
						"recordsFiltered" => $this->m_cr_sj->q_row_transaksi_T_PO_MST($param_list_akses)->num_rows(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
					
	}

	function detail_po_mst(){
	    $nama=$this->session->userdata('nama');
	    $loccode=$this->session->userdata('location');
	    $nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($this->uri->segment(4))));
	    
					
		$param_trx_pomst=" and fc_pono='$nodok' ";
		$param_trx_podtl=" and fc_pono='$nodok' ";
		
		$paramerror=" and fc_userid='$nama'";
		$dtlerror=$this->m_cr_sj->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_cr_sj->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['deskripsi'])) { $errordesc=trim($dtlerror['deskripsi']); } else { $errordesc='';  }
		if(isset($dtlerror['fc_nomorakhir1'])) { $nomorakhir1=trim($dtlerror['fc_nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['fc_errorcode'])) { $errorcode=trim($dtlerror['fc_errorcode']); } else { $errorcode='';  }
		
		$data['message']="";

		$data['title']="LIST DATA PO DETAIL BY $nama";
		$data['nama']=$nama;
		$data['list_trx_t_pomst']=$this->m_cr_sj->q_d_transaksi_vw_tw_pomst($param_trx_pomst)->result();
		$data['list_trx_t_podtl']=$this->m_cr_sj->q_d_transaksi_vw_tw_podtl($param_trx_podtl)->result();
		$this->template->display('intern/cr_sj/v_detail_pomst',$data);
		
						
		$dtlerror=$this->m_cr_sj->q_deltrxerror($paramerror);
		/* RESET TRXERRROR */
	}	
	
	function testupload(){
		$data['title']="&nbsp LIST DATA PURCHASE ORDER";	
		$nama=trim($this->session->userdata('nama'));
		
		$data['message']="";
        $this->template->display('intern/cr_sj/v_list_pomst',$data);
	}
	
}