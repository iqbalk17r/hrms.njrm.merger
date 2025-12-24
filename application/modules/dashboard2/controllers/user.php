<?php
/*
	@author : Junis pusaba
	@recreate : Fiky Ashariza
	12-12-2016
*/
class User extends CI_Controller{
    private $limit=20;
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('template','pagination','form_validation','upload'));
        $this->load->model('web/m_user');
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function profile($id){
        $data['title']="Profile User";
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $nis=$this->input->post('id');
            //setting konfigurasi upload image
            $config['upload_path'] = './assets/img/profile/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '500';
			$config['max_width']  = '1024';
			$config['max_height']  = '1000';
                
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('gambar')){
                $gambar="";
				$data['message']="<div class='alert alert-danger'>Gambar Tidak Sesuai</div>";
            }else{
                $gambar=$this->upload->file_name;
				 $info=array(
                'image'=>$gambar
				);
				//update data angggota
				$this->m_user->update($id,$info);
				$data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
            }
            //tampilkan pesan
            
            
            //tampilkan data anggota 
            $data['anggota']=$this->m_user->cekId($id)->row_array();
            $this->template->display('dashboard/anggota/edit_profile',$data);
        }else{
            $data['anggota']=$this->m_user->cekId($id)->row_array();
            $data['message']="";
            $this->template->display('dashboard/anggota/edit_profile',$data);
        }
		//
    }
    
    
    function cari(){
        $data['title']="Pencarian";
        $cari=$this->input->post('cari');
        $cek=$this->m_anggota->cari($cari);
        if($cek->num_rows()>0){
            $data['message']="";
            $data['anggota']=$cek->result();
            $this->template->display('anggota/cari',$data);
        }else{
            $data['message']="<div class='alert alert-success'>Data tidak ditemukan</div>";
            $data['anggota']=$cek->result();
            $this->template->display('anggota/cari',$data);
        }
    }
    
    function _set_rules(){

        $this->form_validation->set_rules('nama','Nama','required|max_length[50]');

        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
}
