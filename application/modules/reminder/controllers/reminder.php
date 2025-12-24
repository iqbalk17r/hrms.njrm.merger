<?php
/*
	@author : Junis pusaba
	@recreate : Fiky Ashariza
	12-12-2016
*/
class Reminder extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model(array('m_modular','m_geografis','web/m_user', "master/m_akses", "trans/m_stspeg", "trans/m_report", "ga/m_kendaraan","pk/m_pk"));
        $this->load->library(array('form_validation','template','Excel_Generator'));
        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
		$level=$this->session->userdata('lvl');
    }
    
    function index(){
        $data["title"] = "Home";
        $data["rowakses"] = $this->m_akses->list_aksesperdep()->num_rows();
        $data["level"] = $this->session->userdata("lvl");
		$nik = $this->session->userdata("nik");
		$hr = trim($this->db->query("select nik from sc_mst.karyawan where bag_dept = 'HA' and nik = '$nik'")
                                ->row()->nik);

        //if($data["rowakses"] > 0 || $data["level"] == "A") {
            $data["list_ojt"] = $this->m_stspeg->q_list_ojt()->result();
            $data["title_ojt"] = "Karyawan OJT (On Job Training)";

            $data["list_kontrak"] = $this->m_stspeg->q_list_karkon()->result();
            $data["title_kontrak"] = "Karyawan Kontrak";

            $data["list_pensiun"] = $this->m_stspeg->q_list_karpen()->result();
            $data["title_pensiun"] = "Karyawan Pensiun";

            $data["list_magang"] = $this->m_stspeg->q_list_magang()->result();
            $data["title_magang"] = "Karyawan Magang";

            $data["list_kendaraan"] = $this->m_kendaraan->q_mstkendaraan()->result();;
            $data["title_kendaraan"] = "Kendaraan";
			
			$data["list_kir_kendaraan"] = $this->m_kendaraan->q_kirkendaraan()->result();;
            $data["title_kir_kendaraan"] = "KIR Kendaraan";

			$data["list_cuti"] = $this->m_report->q_remind_cuti()->result();
			$data["title_cuti"] = "Karyawan Cuti / Cuti Khusus Harian";

			$data["list_dinas"] = $this->m_report->q_remind_dinas()->result();
			$data["title_dinas"] = "Karyawan Dinas";

			$data["list_ijin"] = $this->m_report->q_remind_ijin()->result();
			$data["title_ijin"] = "Karyawan Ijin";

			$data["list_lembur"] = $this->m_report->q_remind_lembur()->result();
			$data["title_lembur"] = "Karyawan Lembur";

			if(trim($hr) != trim($nik)){
			$parampk = "AND c.nik_atasan = '$nik' or c.nik_atasan2 = '$nik'";
				}
			$data["list_pk"] = $this->m_pk->q_remind_pk($parampk)->result();
			$data["title_pk"] = "Penilaian Karyawan kontrak";
			
			if(trim($hr) == trim($nik)){
			$data["list_tl"] = $this->m_report->q_remind_tl()->result();
			$data["title_tl"] = "Karyawan Terlambat";
				}
			
			if(empty($hr)){
			$paramsp = "AND nik = '$nik'";
			}
			$data["list_sp"] = $this->m_report->q_remind_sp($paramsp)->result();
			$data["title_sp"] = "informasi sp";
		//}
        if ($this->session->userdata('firstuse')){
            $this->load->model(array('trans/m_karyawan'));
            $employee = $this->m_karyawan->q_karyawan_read('TRUE AND trim(nik) = \'' . trim($this->session->userdata('nik')) . '\' ')->row();
            $user = $this->m_user->cekUser(trim($this->session->userdata('nik')))->row();
            $data['default'] = array(
                'user'=> trim($user->nik).'|'.trim($user->username),
                'tipe' => 'edit'
            );
            $data['modalTitle'] = 'Selamat datang '.(!empty($employee) ? $employee->callname : 'user');
        }
        $day = 4;
        $data["title_recent"] = "Aktifitas ". $day ." Hari Terakhir (Recent Latest Employee Activity)";

        $data['dtlbroadcast'] = $this->m_modular->q_broadcast_dashboard()->row_array();

		if($hr == $nik){
        $this->template->display("reminder/dashboard/remind",$data);
		} else{
		$this->template->display("reminder/dashboard/reminduser",$data);
		}


    }
    
    function userosin(){
        $data['title']="Data User Osin";		
		$data['nama']=strtoupper($this->session->userdata('username'));
        $data['userosin']=$this->m_user->semua()->result();
		$data['progmodul']=$this->m_user->list_modulprg()->result();
		$data['usermodul']=$this->m_user->list_modulusr()->result();
		$data['listmodul']=$this->m_user->list_modul()->result();
		$data['list_peg']=$this->m_hrd->q_listpeg()->result();
		$data['gudang']=$this->m_geografis->q_gudang()->result();
		$data['wilayah']=$this->m_geografis->q_wilayah()->result();		
		$data['divisi']=$this->m_user->divisi()->result();
        if($this->uri->segment(4)=="delete_success")
            $data['message']="<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if($this->uri->segment(4)=="add_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else if($this->uri->segment(4)=="update_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
		else if($this->uri->segment(4)=="data_sama")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada</div>";
		else if($this->uri->segment(4)=="pwd_beda")
            $data['message']="<div class='alert alert-danger'>Password Harus Sama</div>";
		else if($this->uri->segment(4)=="danger")
            $data['message']="<div class='alert alert-danger'>Terjadi kesalahan saat input</div>";
		else
            $data['message']='';
        $this->template->display('dashboard/userosin/index',$data);
    }
	//input user baru
	function add_user(){
		$userid=strtoupper($this->input->post('userid'));
		$usersname=$this->input->post('namauser');
		$nip=$this->input->post('nip');
		$userlname=$this->input->post('userpjg');				
		$password1=$this->input->post('passwordweb');				
		$password2=$this->input->post('passwordweb2');				
		$gudang=$this->input->post('gudang');								
		$divisi=$this->input->post('divisi');													
		$kunci=$this->input->post('kunci');				
		$timelock=$this->input->post('end_date');				
		$leveluser=$this->input->post('leveluser');				
		$wilayah=$this->input->post('wilayah');	
				
		$cek=$this->m_user->cekUser($userid);
            if($cek->num_rows()>0){
                redirect('dashboard/userosin/index/data_sama');
            }else{
				if ($password1<>$password2){
					redirect('dashboard/userosin/index/pwd_beda');
				} else {
					$info=array(
						'branch'=>'SBYNSA',
						'userid'=>trim($userid),
						'usersname'=>strtoupper($usersname),
						'nip'=>$nip,
						'userlname'=>strtoupper($userlname),                   
						'passwordweb'=>md5($password1),
						'location_id'=>$gudang,
						'groupuser'=>$divisi,
						'divisi'=>$divisi,
						'hold_id'=>strtoupper($kunci),
						'level_id'=>$leveluser,
						'custarea'=>$wilayah,
						'inputby'=>$this->session->userdata('username'),
						'timelock'=>$timelock,
						'inputdate'=>date("Y-m-d H:i:s"),
						'image'=>'admin.jpg');
					if ($userid<>null){
						$this->m_user->simpan($info);
					} else {
						redirect('dashboard/userosin/index/danger');	
					}
						//simpan modul
						$listmdl=$this->m_user->list_modulprg()->result();
						foreach ($listmdl as $mdl){
							$namamdl=trim($mdl->mdlprg);
							$cekmdl=$this->input->post($namamdl);
							if ($cekmdl=='Y') {
								$infomdl=array(
									'branch'=>'SBYNSA',
									'userid'=>$userid,
									'mdlprg'=>$mdl->mdlprg,
									'modul'=>$mdl->modul,
									'link'=>$mdl->LINK									
									);
									$this->m_user->simpan_mdl($infomdl);
							}
						}
						//end simpan modul
				}
									
					redirect('dashboard/userosin/index/add_success');	
			}
	}	
    
    function edit_user(){
		$userid=$this->input->post('userid');
		$usersname=$this->input->post('namauser');
		$nip=$this->input->post('nip');
		$userlname=$this->input->post('userpjg');				
		$passwordbaru=$this->input->post('passwordweb');				
		$passwordasli=$this->input->post('passwordwebasli');				
		if ($passwordasli==$passwordbaru) {
			$password=$passwordasli;
		} else {
			$password=md5($passwordbaru);
		}
		$gudang=$this->input->post('gudang');								
		$divisi=$this->input->post('divisi');													
		$kunci=$this->input->post('kunci');	
		$timelock=$this->input->post('end_date');			
		$leveluser=$this->input->post('leveluser');				
		$wilayah=$this->input->post('wilayah');	
		if ($password1<>$password2){
					redirect('dashboard/userosin/index/pwd_beda');
				} else {
					$info=array(
						'branch'=>'SBYNSA',
						'userid'=>strtoupper($userid),
						'usersname'=>strtoupper($usersname),
						'userlname'=>strtoupper($userlname),                    
						'passwordweb'=>$password,
						'location_id'=>$gudang,
						'groupuser'=>$divisi,
						'divisi'=>$divisi,
						'hold_id'=>strtoupper($kunci),
						'timelock'=>$timelock,
						'level_id'=>$leveluser,
						'custarea'=>$wilayah,					
						);				
					$this->m_user->update($userid,$info);
					$this->m_user->hapus_mdl(trim($userid));
					$listmdl=$this->m_user->list_modulprg()->result();
					foreach ($listmdl as $mdl){
						$namamdl=trim($mdl->mdlprg);
						$cekmdl=$this->input->post($namamdl);
						if ($cekmdl=='Y') {
							$cekmodul=$this->m_user->cek_modul($userid,$cekmdl);
							
							$infomdl=array(
								'branch'=>'SBYNSA',
								'userid'=>$userid,
								'mdlprg'=>$mdl->mdlprg,
								'modul'=>$mdl->modul,
								'link'=>$mdl->LINK
								);
							if($cekmodul->num_rows()>0) {
								$this->m_user->update_mdl($userid,$infomdl);
							} else {
								$this->m_user->simpan_mdl($infomdl);
							}
						}
					}
					redirect('dashboard/userosin/index/add_success'); 
				}
    }
    
    function hapus_user($kode){
		$level=$this->session->userdata('level');
		if ($level<>'A'){
		$data['message']='Level Anda di tolak';
		redirect('dashboard/userosin',$data);
		} else {
		$data['message']='Data Berhasil Di Hapus';
        $this->m_user->hapus($kode);
		redirect('dashboard/userosin',$data);
		}
    }
    
    function _set_rules(){
        $this->form_validation->set_rules('user','username','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
    
    function logout(){
        $this->session->unset_userdata('username');
		$this->session->sess_destroy();
        redirect('web');
    }
	
 
}
