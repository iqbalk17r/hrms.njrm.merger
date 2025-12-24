<?php
/*
	@author : randy
	13-04-2015
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
		$data['list_pelamar']=$this->m_calonkaryawan->q_calonkaryawan()->result();
		//$data['message']="List SMS Masuk";
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
		$posisi=$this->input->post('posisi');
		$status_pernikahan=$this->input->post('status_pernikahan');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
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
			'tgllowongan'=>$this->input->post('tgllowongan'),
			'tgllamaran'=>$this->input->post('tgllamaran'),
		);
		$cek=$this->m_calonkaryawan->q_cekcalonkaryawan($noktp)->num_rows();
		if ($cek>0){
			redirect('recruitment/calonkaryawan/index/kode_failed');
		} else {
			$this->m_calonkaryawan->insert_master($info);
		}
		$this->add_riwayat_pendidikan($noktp);
		$this->add_riwayat_pekerjaan($noktp);
		$this->add_foto($noktp);
		$this->add_attachment($noktp);
		redirect('recruitment/calonkaryawan/index/rep_succes');
	}
	
	function add_riwayat_pendidikan($noktp){
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
		}
		if(!empty($info)){
                $insert = $this->m_calonkaryawan->insert_pendidikan($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
	}	

	function add_riwayat_pekerjaan($noktp){
		$nmperusahaan=$this->input->post('pkj_nmperusahaan');
		$bidang_usaha=$this->input->post('pkj_bidang_usaha');
		$tahun_masuk=$this->input->post('pkj_tahun_masuk');
		$tahun_keluar=$this->input->post('pkj_tahun_keluar');
		$bagian=$this->input->post('pkj_bagian');
		$jabatan=$this->input->post('pkj_jabatan');
		$nmatasan=$this->input->post('pkj_nmatasan');
		$jbtatasan=$this->input->post('pkj_jbtatasan');
		$keterangan=$this->input->post('pkj_keterangan');
			
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
		}
		if(!empty($info)){
                $insert = $this->m_calonkaryawan->insert_pekerjaan($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
	}
	
	function add_foto($noktp){
        
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
                    'ref_type'=> 'DP',);
							
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
    }
	
	function add_attachment($noktp){
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
                }
            }
            
            if(!empty($info)){
                $insert = $this->m_calonkaryawan->insert_attachment($info);
                //$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                //$this->session->set_flashdata('statusMsg',$statusMsg);
            }
        }
	}
	
	function dtlpelamar(){
		$data['title']="DETAIL PELAMAR";
		$noktp=$this->uri->segment(4);
		$data['dtlpel']=$this->m_calonkaryawan->q_cekcalonkaryawan($noktp)->row_array();
		$data['listpdk']=$this->m_calonkaryawan->q_riwayat_pendidikan($noktp)->result();
		$data['listpgl']=$this->m_calonkaryawan->q_riwayat_pengalaman($noktp)->result();
		$data['dtllamp_dp']=$this->m_calonkaryawan->q_lampiran_dp($noktp)->row_array();
		$data['dtllamp_at']=$this->m_calonkaryawan->q_lampiran_at($noktp)->result();
		
		$data['list_opt_neg']=$this->m_geo->list_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_prov()->result();
		$data['list_opt_kotakab']=$this->m_geo->list_kotakab()->result();
		$data['list_opt_kecamatan']=$this->m_geo->list_kec()->result();
		$data['list_opt_agama']=$this->m_agama->q_agama()->result();
		$data['list_opt_nikah']=$this->m_nikah->q_nikah()->result();
		$data['list_pendidikan']=$this->m_riwayat_pendidikan->list_pendidikan()->result();
		
        $this->template->display('recruitment/calonkaryawan/v_detailpelamar',$data);
	}

	
}	