<?php
/*
	@author : Junis pusaba
	@recreate : Fiky Ashariza
	12-12-2016
*/
//error_reporting(0);

class Menu extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_menu'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Menu";	        
		$data['list_menu_utama']=$this->m_menu->list_menu_utama()->result();		
		$data['list_menu_sub']=$this->m_menu->list_menu_sub()->result();		
		$data['list_menu_submenu']=$this->m_menu->list_menu_submenu()->result();		
		$data['list_menu_opt_utama']=$this->m_menu->list_menu_opt_utama()->result();		
		$data['list_menu_opt_sub']=$this->m_menu->list_menu_opt_sub()->result();		
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
		else if($this->uri->segment(4)=="del_exist"){			
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/menu/v_menu',$data);
    }
	
	function edit($kodemenu){
		if (empty($kodemenu)){
			redirect('master/menu/');
		} else {
			$data['title']='EDIT DATA MENU';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_menu']=$this->m_menu->dtl_menu($kodemenu);
			$data['list_menu_opt_utama']=$this->m_menu->list_menu_opt_utama()->result();
			$data['list_menu_opt_sub']=$this->m_menu->list_menu_opt_sub()->result();
			$this->template->display('master/menu/v_editmenu',$data);
		}		
	}
	
	function hps($kodemenu){	
		$cek_delete=$this->m_menu->cek_del($kodemenu);
		if ($cek_delete>0) {
			redirect('master/menu/index/del_exist');
		} else {
			$this->db->where('kodemenu',$kodemenu);
			$this->db->delete('sc_mst.menuprg');
			redirect('master/menu/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodemenu=trim($this->input->post('kdmenu'));
		$namamenu=$this->input->post('namamenu');
		$parentmenu=$this->input->post('parentmenu');
		$parentsubmenu=$this->input->post('parentsubmenu');
		$urut=$this->input->post('urut');
		$child=$this->input->post('childmenu');
		$holdmenu=$this->input->post('holdmenu');
		$linkmenu=$this->input->post('linkmenu');
		$iconmenu=$this->input->post('iconmenu');		
		$cek_menu=$this->m_menu->cek_menu($kodemenu);
		if ($tipe=='input') {
			if ($cek_menu>0){
				redirect('master/menu/index/exist');
			} else {
				$info_input=array(
					'kodemenu'=>$kodemenu,
					'namamenu'=>$namamenu,
					'parentmenu'=>$parentmenu,
					'parentsub'=>$parentsubmenu,
					'urut'=>$urut,
					'child'=>$child,
					'holdmenu'=>$holdmenu,
					'linkmenu'=>$linkmenu,
					'iconmenu'=>$iconmenu,						
				);
				$this->db->insert('sc_mst.menuprg',$info_input);
				echo 'CEK';
				redirect('master/menu/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(																	
				'namamenu'=>$namamenu,
				'parentmenu'=>$parentmenu,	
				'parentsub'=>$parentsubmenu,	
				'holdmenu'=>$holdmenu,
				'linkmenu'=>$linkmenu,
				'iconmenu'=>$iconmenu,
				'urut'=>$urut,
			);	
			$this->db->where('kodemenu',$kodemenu);
			$this->db->update('sc_mst.menuprg',$info_edit1);
			redirect("master/menu/edit/$kodemenu/upsuccess");					
		} else {
			redirect('master/menu/index/notacces');
		}		
	}
}