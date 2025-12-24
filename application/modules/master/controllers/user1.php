<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class User extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_user','m_menu','m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master User";	
        $data['message']="";			
		$data['list_user']=$this->m_user->list_user()->result();
		$data['list_kary']=$this->m_user->list_karyawan()->result();
		$data['list_lvljbt']=$this->m_user->list_lvljbt()->result();
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(4)=="notacces"){			
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(4)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/user/v_user',$data);
    }
	
	function edit($nik,$username){
		if (empty($nik)){
			redirect('master/user/');
		} else {
			$data['title']='EDIT DATA USER';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
			$data['list_lvljbt']=$this->m_user->list_lvljbt()->result();
			//$this->template->display('master/user/v_edituser',$data);			
			$this->template->display('master/user/v_edituser',$data);			
		}		
	}
	
	function editprofile($nik,$username){
	
		if (empty($nik)){
			redirect('dashboard');
		} else {
			$data['title']='UBAH PASSWORD USER';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Password Berhasil Diubah </div>";
				///redirect('dashboard/logout');
			}
			else if($this->uri->segment(5)=="pwnotmatch"){
				
				$data['message']="<div class='alert alert-danger'>PASSWORD Tidak Sama </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
			$this->template->display('master/user/v_editprofile',$data);			
		}
				
	}
	
	
	function edit_akses($nik,$username,$kodemenu){
		if (empty($nik)){
			redirect('master/user/akses/');
		} else {
			$data['title']='EDIT DATA AKSES USER';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
			$data['akses']=$this->m_akses->detail_user_akses($nik,$kodemenu)->row_array();
			$this->template->display('master/user/v_edit_aksesuser',$data);			
		}		
	}
	
	function hps($nik,$username){		
		$this->db->where('nik',$nik);
		$this->db->where('username',$username);
		$this->db->delete('sc_mst.user');
		redirect('master/user/index/del');
	}
	
	function hps_akses($nik,$kodemenu){		
		$this->db->where('nik',$nik);
		$this->db->where('kodemenu',$kodemenu);
		$this->db->delete('sc_mst.akses');
		redirect("master/user/akses/$nik/del");
	}
	
	function akses($nik,$username){
		$data['title']="HAK AKSES USER $nik";
		$data['dtl_user']=$this->m_user->dtl_user($nik,$username);
		$data['list_akses']=$this->m_akses->list_akses($nik,$username)->result();
		$data['list_menu']=$this->m_akses->list_menu($nik,$username)->result();
		$data['nik']=$nik;
		$data['username']=$username;
		if($this->uri->segment(5)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(5)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(6)=="upsuccess"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(5)=="notacces"){			
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(5)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/user/v_akses_user',$data);			
	}
	
	function save_akses(){
		$nik=strtoupper(trim($this->input->post('nik')));
		$username=strtoupper(trim($this->input->post('username')));
		$menu=trim($this->input->post('menu'));
		$hold=$this->input->post('hold');
		$view=$this->input->post('view');
		$input=$this->input->post('input');
		$update=$this->input->post('update');
		$delete=$this->input->post('delete');
		$approve=$this->input->post('approve');
		$approve2=$this->input->post('approve2');
		$approve3=$this->input->post('approve3');
		$convert=$this->input->post('convert');
		$print=$this->input->post('print');
		$download=$this->input->post('download');				
		$tipe=$this->input->post('tipe');				
		$filter=$this->input->post('aksesfilter');				
		
		if ($tipe=='input'){
			$info_input=array(
				'nik'=>$nik,
				'username'=>$username,
				'kodemenu'=>$menu,
				'hold_id'=>$hold,
				'aksesview'=>$view,
				'aksesinput'=>$input,
				'aksesupdate'=>$update,
				'aksesdelete'=>$delete,
				'aksesapprove'=>$approve,
				'aksesapprove2'=>$approve2,
				'aksesapprove3'=>$approve3,
				'aksesconvert'=>$convert,
				'aksesprint'=>$print,
				'aksesdownload'=>$download,
				'aksesfilter'=>$filter
				
			);
			$cek=$this->m_akses->cek_input_akses($nik,$menu,$username);
			if ($cek>0){
				redirect("master/user/akses/$nik/exist");
			} else {
				$this->db->insert('sc_mst.akses',$info_input);
				redirect("master/user/akses/$nik/$username/upsuccess");
			}
		} else if ($tipe=='edit'){
			$info_update=array(
				'hold_id'=>$hold,
				'aksesview'=>$view,
				'aksesinput'=>$input,
				'aksesupdate'=>$update,
				'aksesdelete'=>$delete,
				'aksesapprove'=>$approve,
				'aksesapprove2'=>$approve2,
				'aksesapprove3'=>$approve3,
				'aksesconvert'=>$convert,
				'aksesprint'=>$print,
				'aksesdownload'=>$download,
				'aksesfilter'=>$filter
			);
			$this->m_akses->update_akses($nik,$menu,$info_update,$username);			
			redirect("master/user/akses/$nik/$username/upsuccess");
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		//$splituser=explode('|',$this->input->post('user'));
		//$nik=strtoupper(trim($splituser[0]));
		$nik=$this->input->post('nik');
		$username=strtoupper(trim($this->input->post('username')));		
		$password=md5(($this->input->post('passwordweb')));	
		$lvlid=strtoupper(trim($this->input->post('lvlid')));
		$lvlakses=strtoupper(trim($this->input->post('lvlakses')));					
		
		
		$expdate=$this->input->post('expdate');
		$hold=$this->input->post('hold');
		$cek_user=$this->m_user->cek_user($nama)->num_rows();
		if ($tipe=='input') {
			if ($cek_user>0){
				redirect('master/user/index/exist');
			} else {
				$info_input=array(
					'branch'=>'SBYNSA',
					'nik'=>$nik,
					'username'=>$username,
					'passwordweb'=>$password,
					'level_id'=>$lvlid,
					'level_akses'=>$lvlakses,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'image'=>'admin.jpg',
					'inputdate'=>date('d-m-Y'),
					'inputby'=>$this->session->userdata('nik')
				);
				$this->db->insert('sc_mst.user',$info_input);
				echo 'CEK';
				redirect('master/user/index/success');
			}			
		} else if ($tipe=='edit'){
			if (empty($password) or $password==''){
				$info_edit1=array(												
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'level_id'=>$lvlid,
					'level_akses'=>$lvlakses,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);	
				$this->db->where('nik',$nik);
				$this->db->where('username',$username);
				$this->db->update('sc_mst.user',$info_edit1);
				redirect("master/user/edit/$nik/$username/upsuccess");
			} else {
				$info_edit2=array(							
					'passwordweb'=>$password,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'level_id'=>$lvlid,
					'level_akses'=>$lvlakses,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->where('username',$username);
				$this->db->update('sc_mst.user',$info_edit2);
				redirect("master/user/edit/$nik/$username/upsuccess");
			}		
		} else {
			redirect('master/user/index/notacces');
		}		
	
	}
	
	
	function saveprofile(){		
		$tipe=$this->input->post('tipe');
		$splituser=explode('|',$this->input->post('user'));
		$nik=strtoupper(trim($splituser[0]));
		$nama=strtoupper(trim($splituser[1]));		
		$password=md5(($this->input->post('passwordweb')));		
		$password2=md5(($this->input->post('passwordweb2')));		
		$expdate=$this->input->post('expdate');
		$hold=$this->input->post('hold');
		$cek_user=$this->m_user->cek_user($nik);
		if ($tipe=='input') {
			/*if ($cek_user>0){
				redirect('master/user/index/exist');
			} else {
				$info_input=array(
					'nik'=>$nik,
					'username'=>$nama,
					'passwordweb'=>$password,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'inputdate'=>date('d-m-Y'),
					'inputby'=>$this->session->userdata('nik')
				);
				$this->db->insert('sc_mst.user',$info_input);
				echo 'CEK';
				redirect('master/user/saveprofile/success');
			} */			
		} else if ($tipe=='edit'){
			if ($password<>$password2){
				
				redirect("master/user/editprofile/$nik/$nama/pwnotmatch");
				
			}
			if (empty($password) or $password==''){
				$info_edit1=array(												
					//'expdate'=>$expdate,
					//'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);	
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit1);
				redirect("master/user/editprofile/$nik/$nama/upsuccess");
			} else {
				$info_edit2=array(							
					'passwordweb'=>$password,
					//'expdate'=>$expdate,
					//'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit2);
				redirect("master/user/editprofile/$nik/$nama/upsuccess");
			}		
		} else {
			redirect('master/user/index/notacces');
		}		
	}
	
	function input_view_akses($nik,$username){
		$data['title']="INPUT HAK AKSES USER $nik $username";
		$data['title1']="MENU PROGRAM";
		$data['title2']="MENU PROGRAM USER $username";
		$data['nik']=$nik;
		$data['username']=$username;
		$data['list_menu_child']=$this->m_user->q_childmenu($nik,$username)->result();
		$data['list_menu_user']=$this->m_user->q_childmenu_usertmp($nik,$username)->result();
		$data['cek_user']=$this->m_user->cek_tmp_akses($nik,$username)->num_rows();
		$this->template->display('master/user/v_akses_user_grid',$data);			
		
	}
	
	function tambah_menu(){
		$lb=$this->input->post('centang');
		$nik=$this->input->post('nik');
		$username=$this->input->post('username');
		
		if(empty($lb)){
			redirect("master/user/");
		}
		foreach($lb as $index => $temp){
			$kdmenu=trim($lb[$index]);
			//$lihat_nik=$this->m_dinas->list_karyawan_index($nik)->row_array();
			$info[$index]['nik']=$nik;
			$info[$index]['kodemenu']=$kdmenu;
			$info[$index]['hold_id']='t';
			$info[$index]['aksesview']='t';
			$info[$index]['aksesinput']='t';
			$info[$index]['aksesupdate']='t';
			$info[$index]['aksesdelete']='t';
			$info[$index]['aksesapprove']='t';
			$info[$index]['aksesconvert']='t';
			$info[$index]['aksesprint']='t';
			$info[$index]['aksesdownload']='t';
			$info[$index]['aksesapprove2']='t';
			$info[$index]['aksesapprove3']='t';
			$info[$index]['aksesfilter']='t';
			$info[$index]['username']=$username;
	
		}

			$insert = $this->m_user->add_kdmnu_tmp($info);
			redirect("master/user/input_view_akses/$nik/$username");
	}
	
	function kurangi_menu(){
		$lb=$this->input->post('centang');
		$nik=$this->input->post('nik');
		$username=$this->input->post('username');
		
		if(empty($lb)){
			redirect("master/user/");
		}
		foreach($lb as $index => $temp){
			$kdmenu=trim($lb[$index]);
			//$lihat_nik=$this->m_dinas->list_karyawan_index($nik)->row_array();
			$info[$index]['nik']=$nik;
			//$info[$index]['kodemenu']=$kdmenu;
			//$info[$index]['username']=$username;
			$this->db->delete('sc_mst.akses', array('kodemenu' => $kdmenu,'nik' => $nik,'username' => $username)); 
			$this->db->delete('sc_tmp.akses', array('kodemenu' => $kdmenu,'nik' => $nik,'username' => $username)); 
		}
			
		//$this->db->where('IN ('.implode(',',$kdmenu).')', NULL, FALSE);	
		//$this->db->delete('sc_mst.akses', $info = array()); 
		//$this->db->delete('sc_tmp.akses', $info = array()); 
		//$delete = $this->m_user->remove_kdmnu_tmp($info);
		redirect("master/user/input_view_akses/$nik/$username");
	}
	
	function add_menugrid($nik,$username){
		$this->m_user->fl_akses($nik,$username);
		$this->m_user->deltmp_akses($nik,$username);
		redirect("master/user/akses/$nik/$username");	
	}
	
}