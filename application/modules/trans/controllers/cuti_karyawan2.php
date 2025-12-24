<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Cuti_karyawan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_cuti_karyawan');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Cuti/Ijin Khusus/Dinas Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve Atau Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div class='alert alert-success'>Approve Succes</div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$nik=$this->uri->segment(4);
		//$data['nik']=$nik;
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$status1=$this->input->post('status');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
			$status='is not NULL';
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			$status="='$status1'";
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
		
		//$data['list_lk']=$this->m_cuti_karyawan->list_karyawan_index($nik)->row_array();
		$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();
		$data['list_cuti_karyawan']=$this->m_cuti_karyawan->q_cuti_karyawan($tgl,$status)->result();
		$data['list_cuti_karyawan_dtl']=$this->m_cuti_karyawan->q_cuti_karyawan_dtl()->result();
		$data['list_karyawan']=$this->m_cuti_karyawan->list_karyawan()->result();
		//$data['list_trxtype']=$this->m_cuti_karyawan->list_trxtype()->result();
		//$data['list_cuti_karyawan']=$this->m_cuti_karyawan->list_cuti_karyawan()->result();
		//$data['list_rk']=$this->m_cuti_karyawan->q_cuti_karyawan($nik)->row_array();
		
        $this->template->display('trans/cuti_karyawan/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		//echo "test";
		
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_cuti_karyawan->list_karyawan()->result();

		
		$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();
		//$data['list_trxtype']=$this->m_cuti_karyawan->list_trxtype()->result();
		//$data['list_lk2']=$this->m_cuti_karyawan->list_karyawan_index($nik)->row_array();
		//$data['list_lk']=$this->m_cuti_karyawan->list_karyawan_index()->result();
		$this->template->display('trans/cuti_karyawan/v_list_karyawan',$data);
		
	}
	
	function input($nik){
		$data['title']="Input Cuti Karyawan";
		$data['list_pelimpahan']=$this->m_cuti_karyawan->list_pelimpahan($nik)->result();
		$data['list_lk']=$this->m_cuti_karyawan->list_karyawan_index($nik)->result();
		$data['list_ijin_khusus']=$this->m_cuti_karyawan->list_ijin_khusus()->result();	
		$this->template->display('trans/cuti_karyawan/v_input_cuti',$data);
		
	}
	function add_cuti_karyawan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		//$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdijin_khusus1=$this->input->post('kdijin_khusus');
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		$tgl_awal1=$this->input->post('tgl_awal');
		if ($tgl_awal1==''){
			$tgl_awal=NULL;
		} else {
			$tgl_awal=$tgl_awal1;
		}
		$tgl_selesai1=$this->input->post('tgl_selesai');
		if ($tgl_selesai1==''){
			$tgl_selesai=NULL;
		} else {
			$tgl_selesai=$tgl_selesai1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
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
			'tpcuti'=>strtoupper($tpcuti),
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			'nmatasan'=>$atasan,
			'tgl_dok'=>$tgl_dok,
			'kdijin_khusus'=>$kdijin_khusus,
			'tgl_mulai'=>$tgl_awal,
			'tgl_selesai'=>$tgl_selesai,
			'jumlah_cuti'=>$jumlah_cuti,
			'pelimpahan'=>$pelimpahan,
			'keterangan'=>strtoupper($keterangan),
			'alamat'=>strtoupper($alamat),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		//echo $kdcuti_karyawan;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_cuti_karyawan->q_cuti_karyawan($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$this->db->insert('sc_tmp.cuti_karyawan',$info);
		redirect("trans/cuti_karyawan/index/rep_succes");
		
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/cuti_karyawan/index/$nik");
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
			$data['list_keluarga']=$this->m_cuti_karyawan->list_keluarga()->result();
			$data['list_negara']=$this->m_cuti_karyawan->list_negara()->result();
			$data['list_prov']=$this->m_cuti_karyawan->list_prov()->result();
			$data['list_kotakab']=$this->m_cuti_karyawan->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_cuti_karyawan->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_cuti_karyawan->q_cuti_karyawan_edit($nik,$nodok)->row_array();
			$this->template->display('trans/cuti_karyawan/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/cuti_karyawan/index/$nik");
		} else {
			$data['title']='DETAIL DATA RIWAYAT PENGALAMAN KERJA';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$nik=$this->uri->segment(4);
			$data['nik']=$nik;
			
			$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_rk']=$this->m_cuti_karyawan->q_cuti_karyawan_edit($nik,$nodok)->row_array();
			$this->template->display('trans/cuti_karyawan/v_detail',$data);
		}	
	}
	function edit_cuti_karyawan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdijin_khusus1=$this->input->post('kdijin_khusus');
		if ($kdijin_khusus1==''){
			$kdijin_khusus=NULL;
		} else {
			$kdijin_khusus=$kdijin_khusus1;
		}
		$tpcuti1=$this->input->post('tpcuti');
		$tpcuti=substr($tpcuti1,0,1);
		$tgl_awal1=$this->input->post('tgl_awal');
		if ($tgl_awal1==''){
			$tgl_awal=NULL;
		} else {
			$tgl_awal=$tgl_awal1;
		}
		$tgl_selesai1=$this->input->post('tgl_selesai');
		if ($tgl_selesai1==''){
			$tgl_selesai=NULL;
		} else {
			$tgl_selesai=$tgl_selesai1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jumlah_cuti=$this->input->post('jumlah_cuti');
		//$jumlah_cuti=$tgl_selesai-$tgl_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		//$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$alamat=$this->input->post('alamat');
		$pelimpahan=$this->input->post('pelimpahan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//$no_urut=$this->input->post('no_urut');
		
		$info=array(
			//'nodok'=>strtoupper($nodok),
			
			'jumlah_cuti'=>$jumlah_cuti,
			'kdijin_khusus'=>$kdijin_khusus,
			'tpcuti'=>strtoupper($tpcuti),
			'tgl_mulai'=>$tgl_awal,
			'tgl_selesai'=>$tgl_selesai,
			'pelimpahan'=>$pelimpahan,
			'alamat'=>strtoupper($pelimpahan),
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_cuti_karyawan->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek>0) {
				redirect("trans/cuti_karyawan/index/kode_failed");
			} else {
				$this->db->where('nodok',$nodok);				
				$this->db->update('sc_trx.cuti_karyawan',$info);
				redirect("trans/cuti_karyawan/index/edit_succes");
			}
		//echo $inputby;
	}
	
	function hps_cuti_karyawan($nik,$nodok){
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_cuti_karyawan->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek>0) {
				redirect("trans/cuti_karyawan/index/kode_failed");
			} else {
				//$this->db->where('nodok',$nodok);
				$this->db->query("update sc_trx.cuti_karyawan set status='D' where nodok='$nodok'");
				redirect("trans/cuti_karyawan/index/del_succes");
			}
		
	}
	
	function approval($nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_cuti_karyawan->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek>0) {
				redirect("trans/cuti_karyawan/index/kode_failed");
			} else {
				$this->m_cuti_karyawan->tr_app($nodok,$inputby,$tgl_input);	
				redirect("trans/cuti_karyawan/index/app_succes");
			}
	
	}
	
	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$cek=$this->m_cuti_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_cuti_karyawan->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek>0) {
				redirect("trans/cuti_karyawan/index/kode_failed");
			} else {
				$this->m_cuti_karyawan->tr_cancel($nodok,$inputby,$tgl_input);	
				redirect("trans/cuti_karyawan/index/cancel_succes");
			}
		
	}
	
	public function ajax_list()
	{
		$list = $this->m_cuti_karyawan->get_datatables();
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