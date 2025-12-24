<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Absensi extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_absensi');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//$nama=$this->session->userdata('nik');
		$data['title']="List Absensi Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve atau Sudah Dibatalkan</div>";
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
			
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$nik=$this->input->post('nik');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
			$nik=$nik;
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			$nik=$nik;
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
		}
		//echo $tgl.$nik;
		$data['list_absensi']=$this->m_absensi->q_transready($nik,$tgl)->result();	
		
		//$data['list_karyawan']=$this->m_cuti->list_karyawan()->result();
		
        $this->template->display('payroll/absensi/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		//echo "test";
		
		$data['title']="List Karyawan Payroll";
		$data['list_karyawan']=$this->m_absensi->list_karyawan()->result();
		//$data['list_ijin_khusus']=$this->m_cuti->list_ijin_khusus()->result();
		//$data['list_trxtype']=$this->m_cuti->list_trxtype()->result();
		//$data['list_lk2']=$this->m_cuti->list_karyawan_index($nik)->row_array();
		$data['list_lk']=$this->m_absensi->list_karyawan()->result();
		$this->template->display('payroll/absensi/v_list_karyawan',$data);
		
	}
	
	function add_cuti(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		//$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		/*$kdijin_khusus1=$this->input->post('kdijin_khusus');
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		*/
		$tgl_kerja1=$this->input->post('tgl_kerja');
		if ($tgl_kerja1==''){
			$tgl_kerja=NULL;
		} else {
			$tgl_kerja=$tgl_kerja1;
		}
		
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		//$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		$periode=str_replace("_","",$this->input->post('periode'));
		//$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$alamat=$this->input->post('alamat');
		$pelimpahan=$this->input->post('pelimpahan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		
		
		//echo $tpcuti;
		$info=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'kddept'=>strtoupper($kddept),
			'kdsubdept'=>strtoupper($kdsubdept),
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			'nmatasan'=>$atasan,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_dok'=>$tgl_dok,
			'periode'=>$periode,
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $kdcuti;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_cuti->q_cuti($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_tmp.cuti_mst',$info);
		redirect("payroll/cuti/detail_mst/$nik/$nodok/");
		
	}
	
	

	
	
	
	public function ajax_list()
	{
		$list = $this->m_cuti->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->nik;		
			$row[] = $person->nmlengkap;		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-success" href="'.site_url('trans/karyawan/detail').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>
					<a class="btn btn-sm btn-success" href="'.site_url('trans/mutprom/index').'/'.trim($person->nik).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Mutasi</a>
					<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->nik)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_karyawan->count_all(),
						"recordsFiltered" => $this->m_karyawan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	

}	