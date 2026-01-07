<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Stspeg extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_stspeg','master/m_akses','pk/m_pk'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Status kepegawaian";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(5)=="rep_succes")
            $data['message']="<div class='alert alert-success'>kepegawaian Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="score_succes")
            $data['message']="<div class='alert alert-success'>Penilaian karyawan Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="score_failed")
            $data['message']="<div class='alert alert-danger'>Penilaian karyawan Gagal Disimpan </div>";
		else if($this->uri->segment(5)=="scoredit_succes")
            $data['message']="<div class='alert alert-success'>Edit Penilaian karyawan Sukses Disimpan </div>";
		else if($this->uri->segment(5)=="scoreedit_failed")
            $data['message']="<div class='alert alert-danger'>Edit Penilaian karyawan Gagal Disimpan </div>";
		else if($this->uri->segment(5)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(5)=="upload_succes")
            $data['message']="<div class='alert alert-success'>Upload dokumen Sukses</div>";
		else if($this->uri->segment(5)=="upload_failed")
            $data['message']="<div class='alert alert-danger'>Upload dokumen Gagal</div>";
        else
            $data['message']='';
		$nik=$this->uri->segment(4);
		$kmenu='I.T.A.4';
		$nama=$this->session->userdata('nik');
		$data['nik']=$nik;
		$data['list_karyawan']=$this->m_stspeg->list_karyawan()->result();
		$data['list_lk']=$this->m_stspeg->list_karyawan_index($nik)->row_array();
		$data['list_kepegawaian']=$this->m_stspeg->list_kepegawaian()->result();
		$data['list_stspeg']=$this->m_stspeg->q_stspeg($nik)->result();
		//var_dump($data['list_stspeg']);

		$nodok = $this->m_stspeg->q_stspeg($nik)->row()->nodok;
		$data['penilaianvalid'] = $nodok && $this->m_pk->q_get_detail_lain_cetak($nodok) ? true : false;
		$data['list_rk']=$this->m_stspeg->q_stspeg($nik)->row_array();
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['nikuser']=$nama;

        $this->template->display('trans/stspeg/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		$this->check_status();
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_stspeg->list_karyawan()->result();
		$this->template->display('trans/stspeg/v_list_karyawan',$data);
	}
	
	function add_stspeg(){
		$nik1=explode('|',$this->input->post('nik'));
		$nik=$this->input->post('nik');
		$nosk=$this->input->post('nosk');
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
			'kdkepegawaian'=>strtoupper($kdkepegawaian),
			'tgl_mulai'=>$tgl_mulai,
			'tgl_selesai'=>$tgl_selesai,
			'cuti'=>strtoupper($cuti),
			'keterangan'=>strtoupper($keterangan),
			'input_date'=>$tgl_input,
			'nosk'=>strtoupper($nosk),
			'input_by'=>strtoupper($inputby),
		);

		$this->db->insert('sc_tmp.status_kepegawaian',$info);
		redirect("trans/stspeg/index/$nik/rep_succes");
		//echo $inputby;
	}
	
	function edit($nik,$no_urut){
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
	
	function detail($nik,$no_urut){
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
		$ojt=$this->input->post('ojt');
		$duedateojt=$this->input->post('duedate_ojt');
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
			'ojt'=>strtoupper($ojt),
			'duedate_ojt'=>($duedateojt),
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
	
	function list_karkon(){
		
		$data['title']="Reminder Karyawan Kontrak";
		$data['list_karkon']=$this->m_stspeg->q_list_karkon()->result();
		$this->template->display('trans/stspeg/v_list_karkon',$data);
	
	}
	
	function list_karpen(){
		
		$data['title']="Reminder Karyawan Pensiun";
		$data['list_karpen']=$this->m_stspeg->q_list_karpen()->result();
		$this->template->display('trans/stspeg/v_list_karpen',$data);
	
	}
	
	
	
	function show_edit_karkon($nodok,$nik){
		
		$data['title']="Edit Karyawan Kontrak";
		$data['list_karkon']=$this->m_stspeg->q_show_edit_karkon($nodok)->row_array();
		$data['list_kepegawaian']=$this->m_stspeg->list_kepegawaian()->result();
		$data['list_lk']=$this->m_stspeg->list_karyawan_index($nik)->row_array();
		$data['nik']=$nik;
		$this->template->display('trans/stspeg/v_edit_karkon',$data);
	}
	
	function check_status()
    {
        $this->load->model(array('trans/M_Employee'));
        $allemployee = $this->M_Employee->q_mst_read_where()->result();
        foreach ($allemployee as $row) {
            foreach ($this->m_stspeg->q_transaction_read(' TRUE AND TRIM(nik) = \'' . trim($row->nik) . '\' AND status is null  ')->result() as $doc) {
				$max = $this->m_stspeg->q_transaction_read_where(' AND nik = \''.trim($row->nik).'\'  ORDER BY tgl_selesai DESC LIMIT 1 ')->row();
                        if ($max->tgl_selesai == $doc->tgl_selesai){
													
						$this->m_stspeg->q_transaction_update(array(
                                    'status' => 'B'
                                ), array(
                                    'nik' => trim($row->nik),
                                    'nodok' => trim($doc->nodok),
                                    'tgl_selesai' => $max->tgl_selesai,
									
						));	
						}else{
							$this->m_stspeg->q_transaction_update(array(
                                    'status' => 'C'
                                ), array(
                                    'nik' => trim($row->nik),
                                    'nodok' => trim($doc->nodok),
									
                                ));	
						}
                }
            }
    }
	
	public function printout($param){
        $json = json_decode(
            hex2bin($param)
        );
        $transaction = $this->m_stspeg->q_transaction_read_where(' AND nodok = \''.$json->nodok.'\' ')->row();
        var_dump($transaction);
    }
	
	function activated()
    {
        $nik = $this->encrypt->decode(hex2bin(trim($this->uri->segment(4))));
        $nodok = $this->encrypt->decode(hex2bin(trim($this->uri->segment(5))));
        $nama = trim($this->session->userdata('nik'));
        $this->db->where('nik', $nik);
        $this->db->where('nodok', $nodok);
        $info = array(
            'status' => 'B',
            'update_date' => date('Y-m-d H:m:s'),
            'update_by' => $nama,
        );
        $this->db->update("sc_trx.status_kepegawaian", $info);

        /* BERAKHIR YG TIDAK AKTIF */
        $this->db->where('nik', $nik);
        $this->db->where('nodok !=', $nodok);
        $info = array(
            'status' => 'C',
        );
        $this->db->update("sc_trx.status_kepegawaian", $info);
        redirect("trans/stspeg/karyawan/rep_succes/$nik");
    }

	function up_kontrakdoc(){
        $kddoc = trim($this->input->post('kddoc'));
        $nik = trim($this->input->post('nik'));

        // Setting konfigurasi upload file
        $config['upload_path'] = './assets/contractfile/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '5000';
        //$config['file_name'] = $nik . '_' . $kddoc . '_' . date('YmdHis');

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $data['message'] = "<div class='alert alert-danger'>File Tidak Sesuai</div>";
            echo 'File Tidak Sesuai</br>
                        Format yang sesuai:</br>
                        * Tipe file: PDF</br>
                        * Ukuran File yang diijinkan max 5MB</br>' . $config['file_ext'] . '</br>' . $this->upload->display_errors();
            echo $_FILES['file']['type'];
		} else {
			$res = $this->upload->data();
			$file_path = $res['file_path'];
			$orig_name = $res['orig_name'];
			$file_ext = $res['file_ext'];
			$file_size = $res['file_size'];
			$full_path = $res['full_path'];

			// Rename file setelah upload sukses
			$new_name = $nik . '_' . $kddoc . '_' . date('YmdHis') . $res['file_ext'];
			$new_path = 'assets/contractfile/' . $new_name;
			$old_path = $res['full_path'];
			$new_full_path = $res['file_path'] . $new_name;
			
			if (rename($old_path, $new_full_path)) {
			// Update nama file di database
			$info = array(
				'kdcontract' => $kddoc,
				'nik' => $nik,
				'file_name' => $new_name,
				'full_path' => $new_path,
				'orig_name' => $res['orig_name'],
				'file_ext' => $res['file_ext'],
				'file_size' => $res['file_size'],
				'input_date' => date('Y-m-d H:i:s'),
				'input_by' => $this->session->userdata('nik')
			);

			// Insert ke tabel
			$this->db->insert('sc_trx.document_contract', $info);

			// Redirect sukses
			redirect("trans/stspeg/index/$nik/upload_succes");
			} else {
			// Redirect gagal rename
			redirect("trans/stspeg/index/$nik/upload_failed");
			}
		}
        }

        function up_kontrakdoc2() {
            $kddoc = trim($this->input->post('kddoc'));
            $nik   = trim($this->input->post('nik'));
            $user  = $this->session->userdata('nik'); // user yang login
        
            // Konfigurasi upload
            $config['upload_path']   = './assets/contractfile/';
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = '5000'; // 5MB
        
            $this->upload->initialize($config);
        
            if (!$this->upload->do_upload('file')) {
                // Upload gagal
                $error = $this->upload->display_errors();
                echo "<div class='alert alert-danger'>File Tidak Sesuai</div>
                      Format yang sesuai:<br>
                      * Tipe file: PDF<br>
                      * Ukuran File maksimal: 5MB<br>
                      <strong>Error:</strong> $error<br>";
                echo 'Tipe file: ' . $_FILES['file']['type'];
            } else {
                // Upload berhasil
                $res        = $this->upload->data();
                $old_path   = $res['full_path'];
                $file_ext   = $res['file_ext'];
                $timestamp  = date('YmdHis');
                $new_name   = $nik . '_' . $kddoc . '_' . $timestamp . $file_ext;
                $new_path   = $res['file_path'] . $new_name;
                $db_path    = 'assets/contractfile/' . $new_name;
        
                // Cek data lama
                $this->db->where('kdcontract', $kddoc);
                $this->db->where('nik', $nik);
                $existing = $this->db->get('sc_trx.document_contract')->row();
        
                // Hapus file lama jika ada
                if ($existing && file_exists('./' . $existing->full_path)) {
                    unlink('./' . $existing->full_path);
                }
        
                // Rename file baru
                if (rename($old_path, $new_path)) {
                    $data_update = array(
                        'file_name'   => $new_name,
                        'full_path'   => $db_path,
                        'orig_name'   => $res['orig_name'],
                        'file_ext'    => $file_ext,
                        'file_size'   => $res['file_size']
                    );
        
					if ($existing) {
						// Mode: UPDATE
						$data_update['update_date'] = date('Y-m-d H:i:s');
						$data_update['update_by']   = $user;

						$this->db->where('kdcontract', $kddoc);
						$this->db->where('nik', $nik);
						if ($this->db->update('sc_trx.document_contract', $data_update)) {
							redirect("trans/stspeg/index/$nik/upload_succes");
						} else {
							redirect("trans/stspeg/index/$nik/upload_failed");
						}
					} else {
						// Mode: INSERT
						$data_update['kdcontract']  = $kddoc;
						$data_update['nik']         = $nik;
						$data_update['input_date']  = date('Y-m-d H:i:s');
						$data_update['input_by']    = $user;

						if ($this->db->insert('sc_trx.document_contract', $data_update)) {
							redirect("trans/stspeg/index/$nik/upload_succes");
						} else {
							redirect("trans/stspeg/index/$nik/upload_failed");
						}
					}
            }
        }
	}
}	
