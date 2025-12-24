<?php
/*
	@author : Fiky
	02-02-2016
*/
//error_reporting(0);

class Setupabsen extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_setupabsen'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
       /* $data['title']="Master Provinsi";	        
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
		$data['list_prov']=$this->m_geo->list_prov()->result();
		$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
		$this->template->display('master/geo/prov/v_prov',$data); */
		echo 'ndasmu penceng';
    }
	
	function setup_template_jadwal(){
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="add_success"){			
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
		$data['title']="SETUP TEMPLATE JADWAL";
		$data['list_settemp']=$this->m_setupabsen->q_template_jadwal()->result();
		$data['list_sf1']=$this->m_setupabsen->q_jam_sf1()->result();
		$data['list_sf2']=$this->m_setupabsen->q_jam_sf2()->result();
		$data['list_sf3']=$this->m_setupabsen->q_jam_sf3()->result();
		$this->template->display('master/setupabsen/v_setup_template_jadwal',$data);
	}
	
	function add_setup(){
		$kd_opt=$this->input->post('kdopt');
		$nm_opt=$this->input->post('nmopt');
		$hraktif=$this->input->post('hraktif');
		$hrlibur=$this->input->post('hrlibur');
		$kon_1=$this->input->post('kondisi_1');
		$kon_2=$this->input->post('kondisi_2');
		$maxweek=$this->input->post('maxweek');
		$ritme_1=$this->input->post('ritme_1');
		$ritme_2=$this->input->post('ritme_2');
		$ritme_3=$this->input->post('ritme_3');
		$tglinput=$this->input->post('tglinput');
		$inputby=$this->input->post('inputby');
		$sf1_all=$this->input->post('sf1_all');
		$sf1_jumat=$this->input->post('sf1_jumat');
		$sf1_sabtu=$this->input->post('sf1_sabtu');
		$sf2_all=$this->input->post('sf2_all');
		$sf2_jumat=$this->input->post('sf2_jumat');
		$sf2_sabtu=$this->input->post('sf2_sabtu');
		$sf3_all=$this->input->post('sf3_all');
		$sf3_jumat=$this->input->post('sf3_jumat');
		$sf3_sabtu=$this->input->post('sf3_sabtu');
		$operatorlist=$this->input->post('operatorlist');
				if($maxweek=='' or empty($maxweek)){ $maxweek=null;}
		If($hraktif=='' or empty($hraktif)){ $hraktif=null;}	
		if($kon_1=='' or empty($kon_1)){$kon_1=null;}			
		if($kon_2=='' or empty($kon_2)){$kon_2=null;}			
		if($ritme_1=='' or empty($ritme_1)){$ritme_1=null;}
		if($ritme_2=='' or empty($ritme_2)){$ritme_2=null;}
		if($ritme_3=='' or empty($ritme_3)){$ritme_3=null;}
				if($sf1_all=='' or empty($sf1_all)){$sf1_all=null;}
		if($sf1_jumat=='' or empty($sf1_jumat)){$sf1_jumat=null;}
		if($sf1_sabtu=='' or empty($sf1_sabtu)){$sf1_sabtu=null;}
				if($sf2_all=='' or empty($sf2_all)){$sf2_all=null;}
		if($sf2_jumat=='' or empty($sf2_jumat)){$sf2_jumat=null;}
		if($sf2_sabtu=='' or empty($sf2_sabtu)){$sf2_sabtu=null;}
				if($sf3_all=='' or empty($sf3_all)){$sf3_all=null;}
		if($sf3_jumat=='' or empty($sf3_jumat)){$sf3_jumat=null;}
		if($sf3_sabtu=='' or empty($sf3_sabtu)){$sf3_sabtu=null;}
		
		$info=array(
			'kd_opt'=>strtoupper($kd_opt),
			'nm_opt'=>strtoupper($nm_opt),
			'hr_aktif'=>$hraktif,
			'hr_libur'=>$hrlibur,
			'kon_1'=>$kon_1,
			'kon_2'=>$kon_2,
			'maxweek'=>$maxweek,
			'ritme_1'=>$ritme_1,
			'ritme_2'=>$ritme_2,
			'ritme_3'=>$ritme_3,
			'inputdate'=>$tglinput,
			'inputby'=>$inputby,
			'sf1_all'=>$sf1_all,
			'sf1_jumat'=>$sf1_jumat,
			'sf1_sabtu'=>$sf1_sabtu,
			'sf2_all'=>$sf2_all,
			'sf2_jumat'=>$sf2_jumat,
			'sf2_sabtu'=>$sf2_sabtu,
			'sf3_all'=>$sf3_all,
			'sf3_jumat'=>$sf3_jumat,
			'sf3_sabtu'=>$sf3_sabtu,
			'operatorlist'=>$operatorlist
		);
		$cek=$this->m_setupabsen->q_template_jadwal_fetch($kd_opt)->num_rows();
		if($cek==0){
			$this->db->insert('sc_mst.setup_grjadwal',$info);
			redirect('master/setupabsen/setup_template_jadwal/add_success');
		} else {
			redirect('master/setupabsen/setup_template_jadwal/exist');
		}
		
	}
	
	function del_setup($kd_opt){
		$this->db->where('kd_opt',$kd_opt);
		$this->db->delete('sc_mst.setup_grjadwal');
		redirect("master/setupabsen/setup_template_jadwal/add_success");
	}
	
	function view_edit($kd_opt){
		$data['message']='';
		$data['title']="SETUP TEMPLATE JADWAL $kd_opt";
		$data['list_settemp']=$this->m_setupabsen->q_template_jadwal()->result();
		$data['dtl']=$this->m_setupabsen->q_template_jadwal_fetch($kd_opt)->row_array();
		$data['list_sf1']=$this->m_setupabsen->q_jam_sf1()->result();
		$data['list_sf2']=$this->m_setupabsen->q_jam_sf2()->result();
		$data['list_sf3']=$this->m_setupabsen->q_jam_sf3()->result();
		$this->template->display('master/setupabsen/v_edit_template_jadwal',$data);
	}
	
	function save_edit(){
		$kd_opt=strtoupper($this->input->post('kdopt'));
		$nm_opt=strtoupper($this->input->post('nmopt'));
		$hraktif=trim($this->input->post('hraktif'));
		$hrlibur=trim($this->input->post('hrlibur'));
		$kon_1=trim($this->input->post('kondisi_1'));
		$kon_2=trim($this->input->post('kondisi_2'));
		$maxweek=trim($this->input->post('maxweek'));
		$ritme_1=trim($this->input->post('ritme_1'));
		$ritme_2=trim($this->input->post('ritme_2'));
		$ritme_3=trim($this->input->post('ritme_3'));
		$tglinput=$this->input->post('tglinput');
		$inputby=$this->input->post('inputby');
		$sf1_all=$this->input->post('sf1_all');
		$sf1_jumat=$this->input->post('sf1_jumat');
		$sf1_sabtu=$this->input->post('sf1_sabtu');
		$sf2_all=$this->input->post('sf2_all');
		$sf2_jumat=$this->input->post('sf2_jumat');
		$sf2_sabtu=$this->input->post('sf2_sabtu');
		$sf3_all=$this->input->post('sf3_all');
		$sf3_jumat=$this->input->post('sf3_jumat');
		$sf3_sabtu=$this->input->post('sf3_sabtu');
		$operatorlist=$this->input->post('operatorlist');
		
		if($maxweek=='' or empty($maxweek)){ $maxweek=null;}
		If($hraktif=='' or empty($hraktif)){ $hraktif=null;}	
		if($kon_1=='' or empty($kon_1)){$kon_1=null;}			
		if($kon_2=='' or empty($kon_2)){$kon_2=null;}			
		if($ritme_1=='' or empty($ritme_1)){$ritme_1=null;}
		if($ritme_2=='' or empty($ritme_2)){$ritme_2=null;}
		if($ritme_3=='' or empty($ritme_3)){$ritme_3=null;}
				if($sf1_all=='' or empty($sf1_all)){$sf1_all=null;}
		if($sf1_jumat=='' or empty($sf1_jumat)){$sf1_jumat=null;}
		if($sf1_sabtu=='' or empty($sf1_sabtu)){$sf1_sabtu=null;}
				if($sf2_all=='' or empty($sf2_all)){$sf2_all=null;}
		if($sf2_jumat=='' or empty($sf2_jumat)){$sf2_jumat=null;}
		if($sf2_sabtu=='' or empty($sf2_sabtu)){$sf2_sabtu=null;}
				if($sf3_all=='' or empty($sf3_all)){$sf3_all=null;}
		if($sf3_jumat=='' or empty($sf3_jumat)){$sf3_jumat=null;}
		if($sf3_sabtu=='' or empty($sf3_sabtu)){$sf3_sabtu=null;}
		$info=array(
			//'kd_opt'=>strtoupper($kd_opt),
			'nm_opt'=>strtoupper($nm_opt),
			'hr_aktif'=>$hraktif,
			'hr_libur'=>$hrlibur,
			'kon_1'=>$kon_1,
			'kon_2'=>$kon_2,
			'maxweek'=>$maxweek,
			'ritme_1'=>$ritme_1,
			'ritme_2'=>$ritme_2,
			'ritme_3'=>$ritme_3,
			'inputdate'=>$tglinput,
			'inputby'=>$inputby,
			'sf1_all'=>$sf1_all,
			'sf1_jumat'=>$sf1_jumat,
			'sf1_sabtu'=>$sf1_sabtu,
			'sf2_all'=>$sf2_all,
			'sf2_jumat'=>$sf2_jumat,
			'sf2_sabtu'=>$sf2_sabtu,
			'sf3_all'=>$sf3_all,
			'sf3_jumat'=>$sf3_jumat,
			'sf3_sabtu'=>$sf3_sabtu,
			'operatorlist'=>$operatorlist
		);
		$cek=$this->m_setupabsen->q_template_jadwal_fetch($kd_opt)->num_rows();
		//if($cek==0){
			$this->db->where('kd_opt',$kd_opt);
			$this->db->update('sc_mst.setup_grjadwal',$info);
			redirect('master/setupabsen/setup_template_jadwal/add_success');
		//} else {
		//	redirect('master/setupabsen/setup_template_jadwal/exist');
		//}
		
	}
	
}