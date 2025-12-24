
<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Bonus extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_bonus');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="Setup Penghasilan Non Reguler";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Detail Rumus Tidak Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div onload='app_succes'></div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
			
		
		//echo $tgl.$nik;
		$data['list_karyawan']=$this->m_bonus->list_karyawan()->result();	
			
		
        $this->template->display('payroll/bonus/v_utama',$data);
    }
	
	function detail(){
		$data['title']="Detail Gaji Bonus";
		$nik=trim($this->input->post('nik'));
		//$bln=$this->input->post('bulan');
		
		if (empty($nik)){
			redirect('payroll/bonus/index');
		
		}
		
		/*if (empty($bln)){
			$bulan=date('m'); 
			
		} else {
			$bulan=$bln; 
			
		}
		switch ($bulan){
			case '01': $bul='Januari'; break;
			case '02': $bul='Februari'; break;
			case '03': $bul='Maret'; break;
			case '04': $bul='April'; break;
			case '05': $bul='Mei'; break;
			case '06': $bul='Juni'; break;
			case '07': $bul='Juli'; break;
			case '08': $bul='Agustus'; break;
			case '09': $bul='September'; break;
			case '10': $bul='Oktober'; break;
			case '11': $bul='November'; break;
			case '12': $bul='Desember'; break;
		}*/
		
		
		$gajipokok1=$this->m_bonus->q_gajipokok($nik)->row_array();
		$gajipokok=$gajipokok1['gajipokok'];
		
		$cek=$this->m_bonus->cek_gajibonus($nik)->num_rows();
		
		if ($cek==0) {
			$this->db->query("insert into sc_trx.bonus_nonreg (nik,no_urut,keterangan,nominal)
							select '$nik' as nik,no_urut,keterangan,0 as nominal from sc_mst.detail_formula where regular='F' and kdrumus='PR'");
			//echo 'sukses';
			$gajibonus1=$this->m_bonus->gajibonus($nik)->row_array();
			$gajibonus=$gajibonus1['nominal'];
			$koreksi1=$this->m_bonus->koreksi($nik)->row_array();
			$koreksi=$koreksi1['nominal'];
			$thr1=$this->m_bonus->thr($nik)->row_array();
			$thr=$thr1['nominal'];
			$insentif_pro1=$this->m_bonus->insentif_pro($nik)->row_array();
			$insentif_pro=$insentif_pro1['nominal'];
			$data['gajipokok']=$gajipokok;
			$data['gajibonus']=$gajibonus;
			$data['thr']=$thr;
			$data['koreksi']=$koreksi;
			$data['insentif_pro']=$insentif_pro;
			$data['nik']=$nik;
			$this->template->display('payroll/bonus/v_input',$data);
			//$this->template->display('payroll/bonus/v_test',$data);
		} else {
			$gajibonus1=$this->m_bonus->gajibonus($nik)->row_array();
			$gajibonus=$gajibonus1['nominal'];
			$koreksi1=$this->m_bonus->koreksi($nik)->row_array();
			$koreksi=$koreksi1['nominal'];
			$thr1=$this->m_bonus->thr($nik)->row_array();
			$thr=$thr1['nominal'];
			$insentif_pro1=$this->m_bonus->insentif_pro($nik)->row_array();
			$insentif_pro=$insentif_pro1['nominal'];
			$data['gajipokok']=$gajipokok;
			$data['gajibonus']=$gajibonus;
			$data['thr']=$thr;
			$data['koreksi']=$koreksi;
			$data['insentif_pro']=$insentif_pro;
			$data['nik']=$nik;
			//$data['bln']=$bln;
			$this->template->display('payroll/bonus/v_input',$data);
			//$this->template->display('payroll/bonus/v_test',$data);
			//echo 'wes onok mbut';
		}
		
		
	
	}
	
	function add_detail(){
		$insentif_pro=$this->input->post('insentif_pro');
		$bonus=$this->input->post('bonus');
		$thr=$this->input->post('thr');
		$koreksi=$this->input->post('koreksi');
		$nik=$this->input->post('nik');
		//$bln=$this->input->post('bln');
		$this->db->query("update sc_trx.bonus_nonreg set nominal='$insentif_pro' where no_urut='12' and nik='$nik'");
		$this->db->query("update sc_trx.bonus_nonreg set nominal='$bonus' where no_urut='14' and nik='$nik'");
		$this->db->query("update sc_trx.bonus_nonreg set nominal='$thr' where no_urut='13' and nik='$nik'");
		$this->db->query("update sc_trx.bonus_nonreg set nominal='$koreksi' where no_urut='5' and nik='$nik'");
		redirect('payroll/bonus/index/rep_succes');
						
	}
	
	

	function edit_detail(){
		//$nik1=explode('|',);
		$kdrumus=$this->input->post('kdrumus');
		$tipe=$this->input->post('tipe');
		$keterangan=$this->input->post('keterangan');
		$aksi=$this->input->post('aksi');
		$aksi_tipe=$this->input->post('aksi_tipe');
		$bonus=$this->input->post('bonus');
		$taxable=$this->input->post('taxable');
		$deductible=$this->input->post('deductible');
		$regular=$this->input->post('regular');
		$cash=$this->input->post('cash');
		$tgl_input=date('d-m-Y H:i:s');
		$inputby=$this->session->userdata('nik');
		$no_urut=$this->input->post('no_urut');
		
		$cek=$this->m_formula->cek($kdrumus)->num_rows();
		
		$detail=array(
			'tipe'=>strtoupper($tipe),
			'keterangan'=>strtoupper($keterangan),
			'aksi'=>$aksi,
			'aksi_tipe'=>$aksi_tipe,
			'bonus'=>$bonus,
			'taxable'=>$taxable,
			'deductible'=>$deductible,
			'regular'=>$regular,
			'cash'=>$cash,
			
		);
		
		$this->db->where('kdrumus',$kdrumus);
		$this->db->where('no_urut',$no_urut);
		$this->db->update('sc_mst.detail_formula',$detail);
		redirect("master/formula/detail/$kdrumus/edit_succes");
		
	}
	
	function hps_detail($kdrumus,$no_urut){
		$this->db->where('kdrumus',$kdrumus);
		$this->db->where('no_urut',$no_urut);
		$this->db->delete('sc_mst.detail_formula');
		redirect("master/formula/detail/$kdrumus/del_succes");
	}
	
	
	

}	