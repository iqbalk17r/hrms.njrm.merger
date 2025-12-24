<?php
/*
	@author : team
	
*/
//error_reporting(0)
class Calonkaryawan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array(
							'm_calonkaryawan',
							'master/m_geo',
							'master/m_agama',
							'master/m_nikah',							
							'trans/m_riwayat_pendidikan',
						));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Data Pelamar";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Nomer KTP Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		
		$tgllowongan=$this->input->post('tgl1');
		$noktp=$this->input->post('noktp');
		$status=$this->input->post('status');
		
		$tgllow=explode(' - ',$tgllowongan);
		
		if (!empty($tgllowongan) and empty($no_ktp) and empty($status)) {
			$tgllow1=date("Y-m-d",strtotime($tgllow[0]));
			$tgllow2=date("Y-m-d",strtotime($tgllow[1]));
			$ktpnya="";
			$statusnya="";
		
		} else if (!empty($tgllowongan) and !empty($no_ktp) and !empty($status)) {
			$tgllow1=date("Y-m-d",strtotime($tgllow[0]));
			$tgllow2=date("Y-m-d",strtotime($tgllow[1]));
			$ktpnya="and noktp='$noktp' ";
			$statusnya=" and status='$status'";
		} else if (!empty($tgllowongan) and !empty($no_ktp) and empty($status)) {
			$tgllow1=date("Y-m-d",strtotime($tgllow[0]));
			$tgllow2=date("Y-m-d",strtotime($tgllow[1]));
			$ktpnya="and noktp='$noktp'";
			$statusnya="";
		} 		
		else if (empty($tgllowongan) and empty($noktp) and empty($status)){
			$tgllow1=date("Y-m-01");
			$tgllow2=date("Y-m-t");
			$ktpnya="";
			$statusnya="";
		}
		else if(empty($tgllowongan) and !empty($noktp) and empty($status)) {
			$tgllow1=date("2000-m-01");
			$tgllow2=date("2099-m-t");
			$ktpnya=" and noktp='$noktp'";
			$statusnya="";
		} 
		else if(empty($tgllowongan) and empty($noktp) and !empty($status)) {
			$tgllow1=date("2000-m-01");
			$tgllow2=date("2099-m-t");
			$ktpnya="";
			$statusnya=" and status='$status'";
		}else if (!empty($tgllowongan) and empty($no_ktp) and !empty($status)) {
			$tgllow1=date("Y-m-d",strtotime($tgllow[0]));
			$tgllow2=date("Y-m-d",strtotime($tgllow[1]));
			$ktpnya="";
			$statusnya=" and status='$status'";
		
		} 	
		
		
		///echo $tgllow1.'<br>';
		///echo $tgllow2.'<br>';
		///echo $ktpnya.'<br>';
		///echo $statusnya.'<br>';
		$data['jenis_seleksi']=$this->m_calonkaryawan->q_jenis_seleksi()->result();		
		$data['list_pelamar2']=$this->m_calonkaryawan->q_calonkaryawan()->result();
		$data['list_pelamar']=$this->m_calonkaryawan->q_pelamarfilter($tgllow1,$tgllow2,$ktpnya,$statusnya)->result();
        $this->template->display('recruitment/calonkaryawan/v_list',$data);
    }
	
	function uploader(){
		$this->load->view('recruitment/calonkaryawan/uploader');
	}
	
	function input(){
		$data['title']="Input Data Pelamar Kerja";
		$data['list_opt_neg']=$this->m_geo->list_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_prov()->result();
		$data['list_opt_kotakab']=$this->m_geo->list_kotakab()->result();
		$data['list_opt_kecamatan']=$this->m_geo->list_kec()->result();
		$data['list_opt_agama']=$this->m_agama->q_agama()->result();
		$data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
		$data['list_jabatan']=$this->m_calonkaryawan->q_jabatan()->result();
		$data['list_pendidikan']=$this->m_riwayat_pendidikan->list_pendidikan()->result();
		$this->template->display('recruitment/calonkaryawan/v_inputmaster',$data);
	
	
	}
	function add_master(){
		$noktp=trim(strtoupper(str_replace(" ","",$this->input->post('noktp'))));
		$nmlengkap=$this->input->post('nmlengkap');
		$tgllahir=$this->input->post('tgllahir');
		$jk=$this->input->post('jk');
		$neglahir=$this->input->post('neglahir');
		$provlahir=$this->input->post('provlahir');
		$kotalahir=$this->input->post('kotalahir');
		$kdagama=$this->input->post('kdagama');
		$provtinggal=$this->input->post('provtinggal');
		$kotatinggal=$this->input->post('kotatinggal');
		$kecamatan=$this->input->post('kecamatan');
		$alamat=$this->input->post('alamat');
		$nohp1=$this->input->post('nohp1');
		$nohp2=$this->input->post('nohp2');
		$email=$this->input->post('email');
		$posisi_awal=$this->input->post('posisi_awal');
		if ($posisi_awal=='ZZ'){
			$posisi=$this->input->post('posisi_lain');
		} else {
			$posisi=$posisi_awal;	
		};
		$status_pernikahan=$this->input->post('status_pernikahan');
		$tgllowongan=$this->input->post('tgllowongan');
		$tgllamaran=$this->input->post('tgllamaran');
		
		//echo $sub;
		$info=array(
			'noktp'=>$noktp,
			'nmlengkap'=>strtoupper($nmlengkap),
			'tgllahir'=>$tgllahir,
			'jk'=>strtoupper($jk),
			'neglahir'=>strtoupper($neglahir),
			'provlahir'=>strtoupper($provlahir),
			'kotalahir'=>strtoupper($kotalahir),
			'kd_agama'=>strtoupper($kdagama),
			'provtinggal'=>strtoupper($provtinggal),
			'kotatinggal'=>strtoupper($kotatinggal),
			'kectinggal'=>strtoupper($kecamatan),
			'alamattinggal'=>strtoupper($alamat),
			'nohp1'=>strtoupper($nohp1),
			'nohp2'=>strtoupper($nohp2),
			'email'=>strtoupper($email),
			'status_pernikahan'=>strtoupper($status_pernikahan),
			'kdposisi'=>strtoupper($posisi),
			'inputdate'=>date('Y-m-d'),
			'inputby'=>$this->session->userdata('nik'),
			'tgllowongan'=>$tgllowongan,
			'tgllamaran'=>$tgllamaran,
		);
		$cek=$this->m_calonkaryawan->q_cekcalonkaryawan($noktp)->num_rows();
		$this->m_calonkaryawan->insert_master($info);
	/*	if ($cek>0){
			redirect('recruitment/calonkaryawan/index/kode_failed');
		} else {
			$this->m_calonkaryawan->insert_master($info);
		}*/
		$this->add_riwayat_pendidikan($noktp,$tgllowongan,$tgllamaran);
		
	}
	
	function add_riwayat_pendidikan($noktp,$tgllowongan,$tgllamaran){
		$kdpendidikan=$this->input->post('pdk_kdpendidikan');
		$nmsekolah=$this->input->post('pdk_nmsekolah');
		$jurusan=$this->input->post('pdk_jurusan');
		$program_studi=$this->input->post('pdk_program_studi');
		$kotakab=$this->input->post('pdk_kotakab');
		$tahun_masuk=$this->input->post('pdk_tahun_masuk');
		$tahun_keluar=$this->input->post('pdk_tahun_keluar');
		$nilai=$this->input->post('pdk_nilai');
		$keterangan=$this->input->post('pdk_keterangan');
	
			
		foreach($kdpendidikan as $index => $temp){
			$info[$index]['noktp']=$noktp;//$noktp;
			$info[$index]['kdpendidikan']=strtoupper($kdpendidikan[$index]);
			$info[$index]['nmsekolah']=strtoupper($nmsekolah[$index]);
			$info[$index]['kotakab']=strtoupper($kotakab[$index]);
			$info[$index]['jurusan']=strtoupper($jurusan[$index]);
			$info[$index]['program_studi']=strtoupper($program_studi[$index]);
			$info[$index]['tahun_masuk']=str_replace("_","",$tahun_masuk[$index]);
			$info[$index]['tahun_keluar']=str_replace("_","",$tahun_keluar[$index]);
			$info[$index]['nilai']=strtoupper($nilai[$index]);
			$info[$index]['keterangan']=strtoupper($keterangan[$index]);
			$info[$index]['input_date']=date("Y-m-d H:i:s");
			$info[$index]['input_by']=$this->session->userdata('nik');
			$info[$index]['tgllowongan']=$tgllowongan;
			$info[$index]['tgllamaran']=$tgllamaran;
		}
		          
		if(!empty($info)){
				$insert = $this->m_calonkaryawan->insert_pendidikan($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
			
		$this->add_riwayat_pekerjaan($noktp,$tgllowongan,$tgllamaran);
		
	}	

	function add_riwayat_pekerjaan($noktp,$tgllowongan,$tgllamaran){
		$nmperusahaan=$this->input->post('pkj_nmperusahaan');
		$bidang_usaha=$this->input->post('pkj_bidang_usaha');
		$tahun_masuk=$this->input->post('pkj_tahun_masuk');
		$tahun_keluar=$this->input->post('pkj_tahun_keluar');
		$bagian=$this->input->post('pkj_bagian');
		$jabatan=$this->input->post('pkj_jabatan');
		$nmatasan=$this->input->post('pkj_nmatasan');
		$jbtatasan=$this->input->post('pkj_jbtatasan');
		$keterangan=$this->input->post('pkj_keterangan');
		$tgllowongan=$this->input->post('tgllowongan');
		$tgllamaran=$this->input->post('tgllamaran');
			
		foreach($nmperusahaan as $index => $temp){
			$info[$index]['noktp']=$noktp;
			$info[$index]['nmperusahaan']=strtoupper($nmperusahaan[$index]);
			$info[$index]['bidang_usaha']=strtoupper($bidang_usaha[$index]);
			$info[$index]['tahun_masuk']=str_replace("_","",trim($tahun_masuk[$index]));
			$info[$index]['tahun_keluar']=str_replace("_","",trim($tahun_keluar[$index]));
			$info[$index]['bagian']=strtoupper($bagian[$index]);
			$info[$index]['jabatan']=strtoupper($jabatan[$index]);
			$info[$index]['nmatasan']=strtoupper($nmatasan[$index]);
			$info[$index]['jbtatasan']=strtoupper($jbtatasan[$index]);
			$info[$index]['keterangan']=strtoupper($keterangan[$index]);
			$info[$index]['input_date']=date("Y-m-d H:i:s");
			$info[$index]['input_by']=$this->session->userdata('nik');
			$info[$index]['tgllowongan']=$tgllowongan;
			$info[$index]['tgllamaran']=$tgllamaran;
		}
		
		
		if(!empty($info)){
                $insert = $this->m_calonkaryawan->insert_pekerjaan($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
			
			$this->add_foto($noktp,$tgllowongan,$tgllamaran);
		
	}
	
	function add_foto($noktp,$tgllowongan,$tgllamaran){
     

			
		
	//$gambar=$this->input->post('gambar');
	//if(empty($gambar)){
		
	//}else{	//setting konfigurasi upload image
            $config['upload_path'] = './assets/attachment/fotoprofil';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '5000';
			$config['max_width']  = '3624';
			$config['max_height']  = '3200';
			$config['file_name']  = $noktp;
            $config['encrypt_name'] = true;
				
				
            $this->upload->initialize($config);
			$coba=$this->upload->do_upload('gambar');

		   if(!$coba){
                $gambar="";
				$data['message']="<div class='alert alert-danger'>Gambar Tidak Sesuai</div>";
				echo 'Gambar Tidak Sesuai</br>
					Format yang sesuai:</br>
					* Ukuran File yang di ijinkan max 2MB</br>
					* Lebar Max 2000 pixel</br>
					* Tinggi Max 2000 pixel</br>					
					';
            }else{
				//Image Resizing
			//	$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 480;
				$config['height'] = 640;

				$tester = $this->upload->data();
				$file_name = $tester['file_name'];
				$file_type = $tester['file_type'];
				$file_path = base_url('/assets/attachment/fotoprofil/'.$tester['file_name']);
				$file_origname = $tester['orig_name'];
				$file_ext = $tester['file_ext'];
				$file_size = $tester['file_size'];
			
				
				$this->load->library('image_lib', $config);
				
				
					$uploadData=array('file_name'=>$file_name,
					'full_path'=>base_url('/assets/attachment/fotoprofil/'.$file_name),
                    'file_type'=> $file_type,
                    'orig_name'=> $file_origname,
                    'file_ext'=> $file_ext,
                    'file_size'=> $file_size,
					'noktp'=> $noktp,
                    'input_date'=> date("Y-m-d H:i:s"),
                    'input_by'=> $this->session->userdata('nik'),
                    'ref_type'=> 'DP',
					'tgllowongan'=>$tgllowongan,
					'tgllamaran'=>$tgllamaran,
					
					);			
					//update foto pegawai
					$this->m_calonkaryawan->insert_image($uploadData);
					
					$data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
				
				if ( ! $this->image_lib->resize()){
					$this->session->set_flashdata('message', $this->image_lib->display_errors('', ''));
				} else {
					
					$res = $this->upload->data();
					$file_name = $res['file_name'];
					$file_type = $res['file_type'];
					$file_path = base_url('/assets/attachment/fotoprofil/'.$res['file_name']);
					$file_origname = $res['orig_name'];
					$file_ext = $res['file_ext'];
					$file_size = $res['file_size'];
					
					$uploadData=array(
					'file_name'=>$file_name,
					'full_path'=>base_url('/assets/attachment/fotoprofil/'.$file_name),
                    'file_type'=> $file_type,
                    'orig_name'=> $file_origname,
                    'file_ext'=> $file_ext,
                    'file_size'=> $file_size,
					'noktp'=> $noktp,
                    'input_date'=> date("Y-m-d H:i:s"),
                    'input_by'=> $this->session->userdata('nik'),
                    'ref_type'=> 'DP',
					'tgllowongan'=>$tgllowongan,
					'tgllamaran'=>$tgllamaran,
					
					);
							
					//update foto pegawai
					$this->m_calonkaryawan->insert_lampiran2($uploadData);
					
					$data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
					
				}				
				
				//$x=base_url('assets/attachment/fotoavatar'.$gambar);
				//echo "<img id='gbr' src='$x' width='100%' height='100%' alt='User Image'>";
			//	echo "SUKSES UPLOAD";
            }
            //tampilkan pesan
			
				//echo $file_name;
				//echo $file_type;
				//echo $file_path;
				//echo $file_origname;
				//echo $file_ext;
				//echo $file_size;
            //tampilkan data anggota 
            //$data['anggota']=$this->m_user->cekId($id)->row_array();
            //$this->template->display('hrd/hrd/view_detail_pegawai',$data);
	//}		
		//$this->add_attachment($noktp);
		//redirect('recruitment/calonkaryawan/index/rep_succes');
		$this->add_attachment($noktp,$tgllowongan,$tgllamaran);
		
    }
	
	function add_attachment($noktp,$tgllowongan,$tgllamaran){
		if(!empty($_FILES['userFiles']['name'])){
            $filesCount = count($_FILES['userFiles']['name']);
            for($index = 0; $index < $filesCount; $index++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$index];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$index];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$index];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$index];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$index];

                $uploadPath = './assets/attachment/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|zip|rar|doc|docx|ppt|pptx|xls|xlsx';
                $config['encrypt_name'] = true;
			
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $info[$index]['file_name'] = $fileData['file_name'];
                    $info[$index]['file_type'] = $fileData['file_type'];
                    $info[$index]['full_path'] = base_url('/assets/attachment/'.$fileData['file_name']);//$fileData['full_path'];
                    $info[$index]['orig_name'] = $fileData['orig_name'];
                    $info[$index]['file_ext'] = $fileData['file_ext'];
                    $info[$index]['file_size'] = $fileData['file_size'];
					$info[$index]['ref_type'] = 'AT';
					$info[$index]['noktp'] = $noktp;
                    $info[$index]['input_date'] = date("Y-m-d H:i:s");
                    $info[$index]['input_by'] = $this->session->userdata('nik');
					$info[$index]['tgllowongan']=$tgllowongan;
					$info[$index]['tgllamaran']=$tgllamaran;
                }
            }
            
            if(!empty($info)){
                $insert = $this->m_calonkaryawan->insert_attachment($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
        }
		
		redirect('recruitment/calonkaryawan/index/rep_succes');
	}
	
	function dtlpelamar(){
		$data['title']="DETAIL PELAMAR";
		$noktp=$this->uri->segment(4);
		$tgllowongan=$this->uri->segment(5);
		$tgllamaran=$this->uri->segment(6);
		$data['dtlpel']=$this->m_calonkaryawan->q_calon_detail($noktp,$tgllowongan,$tgllamaran)->row_array();
		$data['listpdk']=$this->m_calonkaryawan->q_riwayat_pendidikan($noktp,$tgllowongan,$tgllamaran)->result();
		$data['listpgl']=$this->m_calonkaryawan->q_riwayat_pengalaman($noktp,$tgllowongan,$tgllamaran)->result();
		$data['dtllamp_dp']=$this->m_calonkaryawan->q_lampiran_dp($noktp,$tgllowongan,$tgllamaran)->row_array();
		$data['dtllamp_at']=$this->m_calonkaryawan->q_lampiran_at($noktp,$tgllowongan,$tgllamaran)->result();
		
		$data['list_opt_neg']=$this->m_geo->list_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_prov()->result();
		$data['list_opt_kotakab']=$this->m_geo->list_kotakab()->result();
		$data['list_opt_kecamatan']=$this->m_geo->list_kec()->result();
		$data['list_opt_agama']=$this->m_agama->q_agama()->result();
		$data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
		$data['list_pendidikan']=$this->m_riwayat_pendidikan->list_pendidikan()->result();
		$data['noktp']=$noktp;
		$data['tgllowongan']=$tgllowongan;
		$data['tgllamaran']=$tgllamaran;
		
        $this->template->display('recruitment/calonkaryawan/v_detailpelamar',$data);
	}

	function list_pelamar_lebih(){
		$data['title']="LIST PELAMAR LEBIH DARI 1 LAMARAN";
		$data['list_lebih']=$this->m_calonkaryawan->q_list_pelamar_lebih()->result();
				if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Nomer KTP Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$this->template->display('recruitment/calonkaryawan/v_list_pelamar_lebih',$data);
	}
	
	function dtllist_pelamar_lebih($noktp){
		$data['title']="DETAIL PELAMAR LEBIH DARI 1 LAMARAN";
		$data['list_lebih']=$this->m_calonkaryawan->q_cekcalonkaryawan($noktp)->result();
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Nomer KTP Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$this->template->display('recruitment/calonkaryawan/v_dtl_pelamar_lebih',$data);
	}
	
	function edit_pelamar(){
		$noktp=$this->uri->segment(4);
		$tgllowongan=$this->uri->segment(5);
		$tgllamaran=$this->uri->segment(6);
		$data['title']="EDIT DATA PELAMAR";
		$data['dtlpel']=$this->m_calonkaryawan->q_calon_detail($noktp,$tgllowongan,$tgllamaran)->row_array();
		$data['listpdk']=$this->m_calonkaryawan->q_riwayat_pendidikan($noktp,$tgllowongan,$tgllamaran)->result();
		$data['listpgl']=$this->m_calonkaryawan->q_riwayat_pengalaman($noktp,$tgllowongan,$tgllamaran)->result();
		$data['dtllamp_dp']=$this->m_calonkaryawan->q_lampiran_dp($noktp,$tgllowongan,$tgllamaran)->row_array();
		$data['dtllamp_at']=$this->m_calonkaryawan->q_lampiran_at($noktp,$tgllowongan,$tgllamaran)->result();
		
		$data['list_opt_neg']=$this->m_geo->list_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_prov()->result();
		$data['list_opt_kotakab']=$this->m_geo->list_kotakab()->result();
		$data['list_opt_kecamatan']=$this->m_geo->list_kec()->result();
		$data['list_opt_agama']=$this->m_agama->q_agama()->result();
		$data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
		$data['list_pendidikan']=$this->m_riwayat_pendidikan->list_pendidikan()->result();
		$data['noktp']=$noktp;
		$data['tgllowongan']=$tgllowongan;
		$data['tgllamaran']=$tgllamaran;
		
        $this->template->display('recruitment/calonkaryawan/v_editpelamar',$data);
	}
	
	function edit_master(){
		$nmlengkap=$this->input->post('nmlengkap');
		$tgllahir=$this->input->post('tgllahir');
		$jk=$this->input->post('jk');
		$neglahir=$this->input->post('neglahir');
		$provlahir=$this->input->post('provlahir');
		$kotalahir=$this->input->post('kotalahir');
		$kdagama=$this->input->post('kdagama');
		$provtinggal=$this->input->post('provtinggal');
		$kotatinggal=$this->input->post('kotatinggal');
		$kecamatan=$this->input->post('kecamatan');
		$alamat=$this->input->post('alamat');
		$nohp1=$this->input->post('nohp1');
		$nohp2=$this->input->post('nohp2');
		$email=$this->input->post('email');
		$posisi=$this->input->post('posisi');
		$status_pernikahan=$this->input->post('status_pernikahan');
		$tgllowongan2=$this->input->post('tgllowongan2');
		$tgllamaran2=$this->input->post('tgllamaran2');
		$tgllowongan=$this->input->post('tgllowongan');
		$tgllamaran=$this->input->post('tgllamaran');
		$noktp=$this->input->post('noktp');
	//$this->replace_foto($noktp,$tgllowongan,$tgllamaran); cok g kenek2
		
		//echo $sub;
		$info=array(
			//'noktp'=>$noktp,
			'nmlengkap'=>strtoupper($nmlengkap),
			'tgllahir'=>$tgllahir,
			'jk'=>strtoupper($jk),
			'neglahir'=>($neglahir),
			'provlahir'=>($provlahir),
			'kotalahir'=>($kotalahir),
			'kd_agama'=>($kdagama),
			'provtinggal'=>($provtinggal),
			'kotatinggal'=>($kotatinggal),
			'kectinggal'=>($kecamatan),
			'alamattinggal'=>strtoupper($alamat),
			'nohp1'=>strtoupper($nohp1),
			'nohp2'=>strtoupper($nohp2),
			'email'=>strtoupper($email),
			'status_pernikahan'=>strtoupper($status_pernikahan),
			'kdposisi'=>strtoupper($posisi),
			'updatedate'=>date('Y-m-d'),
			'updateby'=>$this->session->userdata('nik'),
			'tgllowongan'=>$tgllowongan2,
			'tgllamaran'=>$tgllamaran2,
		);
		
		$info2=array(
				
			'tgllowongan'=>$tgllowongan2,
			'tgllamaran'=>$tgllamaran2,
		);
		/*$cek=$this->m_calonkaryawan->q_cekcalonkaryawan($noktp)->num_rows();
		if ($cek>0){
			redirect('recruitment/calonkaryawan/index/kode_failed');
		} else {
			
		}*/
		//$this->edit_riwayat_pendidikan($noktp);
		//$this->edit_riwayat_pekerjaan($noktp);
		$this->db->where('tgllowongan',$tgllowongan);
		$this->db->where('tgllamaran',$tgllamaran);
		$this->db->where('noktp',$noktp);
		$this->db->update('sc_rec.calonkaryawan',$info);
		
		
		$this->db->where('tgllowongan',$tgllowongan);
		$this->db->where('tgllamaran',$tgllamaran);
		$this->db->where('noktp',$noktp);
		$this->db->update('sc_rec.lampiran',$info2);
		
		$this->db->where('tgllowongan',$tgllowongan);
		$this->db->where('tgllamaran',$tgllamaran);
		$this->db->where('noktp',$noktp);
		$this->db->update('sc_rec.riwayat_pendidikan',$info2);
		
		$this->db->where('tgllowongan',$tgllowongan);
		$this->db->where('tgllamaran',$tgllamaran);
		$this->db->where('noktp',$noktp);
		$this->db->update('sc_rec.riwayat_pengalaman',$info2);
		
		$this->add_foto($noktp,$tgllowongan,$tgllamaran);
		
		
		
		redirect('recruitment/calonkaryawan/index/rep_succes');
	}
	
	function tambah_riwayat_pendidikan(){ //tambah pendidikan edit
		$noktp=$this->input->post('noktp');
		$kdpendidikan=$this->input->post('pdk_kdpendidikan');
		$nmsekolah=$this->input->post('pdk_nmsekolah');
		$jurusan=$this->input->post('pdk_jurusan');
		$program_studi=$this->input->post('pdk_program_studi');
		$kotakab=$this->input->post('pdk_kotakab');
		$tahun_masuk=$this->input->post('pdk_tahun_masuk');
		$tahun_keluar=$this->input->post('pdk_tahun_keluar');
		$nilai=$this->input->post('pdk_nilai');
		$keterangan=$this->input->post('pdk_keterangan');
		$tgllowongan=$this->input->post('tgllowongan');
		$tgllamaran=$this->input->post('tgllamaran');
			
		$info=array(
			'noktp'=>$noktp,
			'kdpendidikan'=>$kdpendidikan,
			'nmsekolah'=>strtoupper($nmsekolah),
			'kotakab'=>strtoupper($kotakab),
			'jurusan'=>strtoupper($jurusan),
			'program_studi'=>strtoupper($program_studi),
			'tahun_masuk'=>$tahun_masuk,
			'tahun_keluar'=>$tahun_keluar,
			'nilai'=>strtoupper($nilai),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>date('Y-m-d'),
			'update_by'=>$this->session->userdata('nik'),
			'tgllowongan'=>$tgllowongan,
			'tgllamaran'=>$tgllamaran,
		);	
		
		$this->db->insert('sc_rec.riwayat_pendidikan',$info);
		redirect("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");	
	
	}
	function tambah_riwayat_pengalaman(){ //tambah pengalaman edit
		$noktp=$this->input->post('noktp');
		$nmperusahaan=$this->input->post('pkj_nmperusahaan');
		$bidang_usaha=$this->input->post('pkj_bidang_usaha');
		$tahun_masuk=$this->input->post('pkj_tahun_masuk');
		$tahun_keluar=$this->input->post('pkj_tahun_keluar');
		$bagian=$this->input->post('pkj_bagian');
		$jabatan=$this->input->post('pkj_jabatan');
		$nmatasan=$this->input->post('pkj_nmatasan');
		$jbtatasan=$this->input->post('pkj_jbtatasan');
		$keterangan=$this->input->post('pkj_keterangan');
		$tgllowongan=$this->input->post('tgllowongan');
		$tgllamaran=$this->input->post('tgllamaran');
		
		$info=array(
			'noktp'=>$noktp,
			'nmperusahaan'=>strtoupper($nmperusahaan),
			'bidang_usaha'=>strtoupper($bidang_usaha),
			'tahun_masuk'=>($tahun_masuk),
			'tahun_keluar'=>($tahun_keluar),
			'bagian'=>strtoupper($bagian),
			'jabatan'=>strtoupper($jabatan),
			'nmatasan'=>strtoupper($nmatasan),
			'jbtatasan'=>strtoupper($jbtatasan),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>date('Y-m-d'),
			'update_by'=>$this->session->userdata('nik'),
			'tgllowongan'=>$tgllowongan,
			'tgllamaran'=>$tgllamaran,
		);	
		
		$this->db->insert('sc_rec.riwayat_pengalaman',$info);
		redirect("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");	
	
	}
	
	function hps_riwayat_pendidikan($noktp,$tgllowongan,$tgllamaran){
			$this->db->where('noktp',$noktp);
			$this->db->where('tgllowongan',$tgllowongan);
			$this->db->where('tgllamaran',$tgllamaran);
			$this->db->delete('sc_rec.riwayat_pendidikan');
			redirect("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");	
	}
	
	function hps_riwayat_pengalaman($noktp,$tgllowongan,$tgllamaran){
			$this->db->where('noktp',$noktp);
			$this->db->where('tgllowongan',$tgllowongan);
			$this->db->where('tgllamaran',$tgllamaran);
			$this->db->delete('sc_rec.riwayat_pengalaman');
			redirect("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");	
		
	}
	
	function hps_lampiran($noktp,$tgllowongan,$tgllamaran,$file_name){
			$target="assets/attachment/$file_name";
			if(file_exists($target)){
				unlink($target); 	
			}
			$this->db->where('noktp',$noktp);
			$this->db->where('tgllowongan',$tgllowongan);
			$this->db->where('tgllamaran',$tgllamaran);
			$this->db->where('file_name',$file_name);
			$this->db->delete('sc_rec.lampiran');
			redirect("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");	
	}
	
	function replace_foto($noktp,$tgllowongan,$tgllamaran){
			
			$tgllowongan=date($tgllowongan);
			$tgllamaran=date($tgllamaran);
			$eksis=$this->m_calonkaryawan->q_lampiran_dp_min($noktp,$tgllowongan,$tgllamaran)->row_array();
			$profile_eksis=trim($eksis['file_name']);
			$target="assets/attachment/fotoprofil/$profile_eksis";
			if(file_exists($target)){
				unlink($target); 	
			}
			$this->db->where('file_name',$profile_eksis);
			$this->db->delete('sc_rec.lampiran');
			redirect("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");	
			
			
	}
	
	function hps_pelamar($noktp,$tgllowongan,$tgllamaran){
			$this->db->where('noktp',$noktp);
			$this->db->where('tgllowongan',$tgllowongan);
			$this->db->where('tgllamaran',$tgllamaran);
			$this->db->delete('sc_rec.calonkaryawan');

			$this->db->where('noktp',$noktp);
			$this->db->where('tgllowongan',$tgllowongan);
			$this->db->where('tgllamaran',$tgllamaran);
			$this->db->delete('sc_rec.riwayat_pendidikan');
			
			$this->db->where('noktp',$noktp);
			$this->db->where('tgllowongan',$tgllowongan);
			$this->db->where('tgllamaran',$tgllamaran);
			$this->db->delete('sc_rec.riwayat_pengalaman');
			
			$eksis=$this->m_calonkaryawan->q_lampiran_dp_min($noktp,$tgllowongan,$tgllamaran)->row_array();
			$profile_eksis=trim($eksis['file_name']);
			$target="assets/attachment/fotoprofil/$profile_eksis";
			
			if(file_exists($target)){
				unlink($target); 	
			}
			$this->db->where('file_name',$profile_eksis);
			$this->db->delete('sc_rec.lampiran');
			
			$eksisfile=$this->m_calonkaryawan->q_lampiran_at($noktp,$tgllowongan,$tgllamaran)->result();
			foreach($eksisfile as $lop){
							$file_target=trim($lop->file_name);
							$target2="assets/attachment/$file_target";
			
							if(file_exists($target2)){
								unlink($target2); 	
							}
							$this->db->where('file_name',$file_target);
							$this->db->delete('sc_rec.lampiran');
			}
			
			
			redirect("recruitment/calonkaryawan/index/del_success");	
		
	}
	
	function up_status($noktp,$tgllowongan,$tgllamaran){
		$data['title']='PILIH MERUBAH STATUS KARYAWAN KANDIDAT';
		$data['noktp']=$noktp;
		$data['tgllowongan']=$tgllowongan;
		$data['tgllamaran']=$tgllamaran;
		$data['jenis_seleksi']=$this->m_calonkaryawan->q_jenis_seleksi()->result();			
		$this->load->view('recruitment/calonkaryawan/v_up_status_modal',$data);
		
	}
	
	function edit_status_seleksi(){
		$noktp=$this->input->post('noktp');
		$tgllowongan=$this->input->post('tgllowongan');
		$tgllamaran=$this->input->post('tgllamaran');
		$stsseleksi=$this->input->post('stsseleksi');
			
		$info=array(
			'status'=>$stsseleksi,
			'updatedate'=>date('Y-m-d'),
			'updateby'=>$this->session->userdata('nik'),
	
		);	
		$this->db->where('noktp',$noktp);
		$this->db->where('tgllowongan',$tgllowongan);
		$this->db->where('tgllamaran',$tgllamaran);
		$this->db->update('sc_rec.calonkaryawan',$info);
		redirect("recruitment/calonkaryawan/index/rep_succes");	
		
	}
	
}	