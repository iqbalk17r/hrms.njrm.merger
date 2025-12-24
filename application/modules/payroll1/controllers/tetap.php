
<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Tetap extends MX_Controller{
    
    function __construct(){
        parent::__construct();

        $this->load->model(array('m_tetap','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Default_style'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
        //$nama=$this->session->userdata('nik');
        $data['title']="Setup Gaji Tetap";
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.F.2'; $versirelease='I.P.F.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

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

        /* SPESIAL USER FOR APPROVAL P2 */
        $nama = $this->session->userdata('nik');
        $paramspesial = " and nik='$nama' and optioncode='PYR001' and optionhold='NO' and optiongroup='PAYROLL'";
        $cekspesial = $this->m_akses->q_option_special_user($paramspesial)->num_rows();
        if ($cekspesial > 0) {
            $param = " ";
        } else {
            $param = " and kdgroup_pg not in ('P2','P3')";
        }

        $data['list_karyawan']=$this->m_tetap->list_karyawan()->result();
        $data['list_gp'] =  $this->m_tetap->q_grouppenggajian($param)->result();

        redirect('payroll/tetap/detail');
        //$this->template->display('payroll/tetap/v_utama',$data);
    }
	
	function all_gaji(){
		$data['title']="List View Gaji Semua Karyawan";
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
		$data['list_gaji']=$this->m_tetap->all_gaji()->result();	
		
        $this->template->display('payroll/tetap/v_list',$data);
	
	}
	
	function detail(){
		$data['title']="Detail Gaji Tetap";
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.F.2'; $versirelease='I.P.F.2/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

		$nik=trim($this->input->post('nik'));
        $enc_kdgroup_pg = $this->fiky_encryption->dekript(trim($this->uri->segment(4)));

        $kdgroup_pg_post = strtoupper(trim($this->input->post('kdgroup_pg')));
        if (! empty($kdgroup_pg_post)){
            $kdgroup_pg = $kdgroup_pg_post;
        } else {
            $kdgroup_pg = $enc_kdgroup_pg;
        }

        $pkdg = " and kdgroup_pg in ('P1','P2','P3','P4')";
        $dtl=$this->m_tetap->q_grouppenggajian($pkdg)->row_array();
        $data['nmlengkap']=' SEMUA KARYAWAN '; //$dtl['nmgroup_pg'];
        $data['kdgroup_pg']=trim($dtl['kdgroup_pg']);
        $data['enc_kdgroup_pg']=$this->fiky_encryption->enkript(trim($dtl['kdgroup_pg']));;
        $data['paramlist']= $param = " and grouppenggajian='$kdgroup_pg'";
        /* SETTING UP */
        $p1=" and kdoption='PAYROL02'";
        $data['setup']=$this->m_tetap->setup_payroll($p1)->row_array();
       /// $this->m_tetap->recalculate_gaji_wilayah();
        //$data['list_dtlgaji']=$this->m_tetap->q_dtlgajikaryawan($param)->result();
        $this->template->display('payroll/tetap/v_input',$data);
	
	}

    function list_detail_gaji()
    {
        $kdgroup_pg = $this->fiky_encryption->dekript($this->uri->segment(4));
        $list = $this->m_tetap->get_t_dtlgaji($kdgroup_pg);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lm) {
            $enc_nik = $this->fiky_encryption->enkript(trim($lm->nik));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $lm->nik;
            $row[] = $lm->nmlengkap;
            $row[] = $lm->grouppenggajian;
            $row[] = $lm->nmjabatan;
            $row[] = '<div align="right">'.$lm->gaji.'</div>';
            $row[] = '<div align="right">'.$lm->tj_jabatan.'</div>';
            $row[] = '<div align="right">'.$lm->tj_masakerja.'</div>';
            $row[] = '<div align="right">'.$lm->tj_prestasi.'</div>';
            $row[] = '<div align="right">'.$lm->gajibpjs1.'</div>';
            $row[] = '<div align="right">'.$lm->gajinaker1.'</div>';
            //add html for action
            /*$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Wilayah Nominal" onclick="Ubah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Wilayah Nominal" onclick="hapus_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';*/
            $row[] = '<a data-url="'.site_url("/payroll/tetap/modaldetail/$enc_nik").'" class="btn btn-primary btn-sm showon" style="margin-left:10px;  margin-top:5px" data-toggle="modal" data-target=".lod">
                    <i class="fa fa-gear"></i>
                                        </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_tetap->t_dtlgaji_all($kdgroup_pg),
            "recordsFiltered" => $this->m_tetap->t_dtlgaji_count_filtered($kdgroup_pg),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

    function modaldetail(){
        //$this->fiky_encryption->dekript(trim($this->uri->segment(4))));
        //$this->fiky_encryption->enkript(trim($nama)));

        $nik = $this->fiky_encryption->dekript(trim($this->uri->segment(4)));
        $cek=$this->m_tetap->cek_gajitetap($nik)->num_rows();
        if ($cek==0) {
            $this->m_tetap->ins_dtlgaji($nik);
        }
        $param = "and nik='$nik'";
        $data['title'] = 'DETAIL GAJI : ';
        $data['_getCustom']=$this->default_style->_getCustom();
        $data['dtl']=$this->m_tetap->q_dtlgajikaryawan($param)->row_array();
        $this->load->view('payroll/tetap/v_modalinput',$data);
    }
	
	function add_detail(){
        $gajipokok= str_replace(',','',$this->input->post('gajipokok') );
        $tj_masakerja= str_replace(',','',$this->input->post('tj_masakerja') );
        $tj_jabatan= str_replace(',','',$this->input->post('tj_jabatan') );
        $tj_prestasi=str_replace(',','',$this->input->post('tj_prestasi') );
        $gajibpjs=str_replace(',','',$this->input->post('gajibpjs') );
        $gajinaker=str_replace(',','',$this->input->post('gajinaker') );
        $nik=$this->input->post('nik');
        $kdgroup_pg=strtoupper($this->input->post('kdgroup_pg'));
        /*penambahan log edit*/
        $nama=$this->session->userdata('nik');
        $tglnya=date('Y-m-d');

        //if ($)

        $this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$gajipokok',editby='$nama',editdate='$tglnya' ,status='I' where no_urut='1' and nik='$nik'");
        $this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$tj_jabatan',editby='$nama',editdate='$tglnya',status='I' where no_urut='7' and nik='$nik'");
        $this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$tj_masakerja',editby='$nama',editdate='$tglnya',status='I' where no_urut='8' and nik='$nik'");
        $this->db->query("update sc_mst.dtlgaji_karyawan set nominal='$tj_prestasi',editby='$nama',editdate='$tglnya',status='I' where no_urut='9' and nik='$nik'");

        $this->db->query("update sc_mst.dtlgaji_karyawan set status='P' where nik='$nik'");

        /*
        $this->db->query("update sc_mst.karyawan set gajitetap=
                        (select sum(nominal) from sc_mst.dtlgaji_karyawan where nik='$nik')
                        where nik='$nik'");
        $this->db->query("update sc_mst.karyawan set tj_tetap=
                        (select sum(nominal) from sc_mst.dtlgaji_karyawan where nik='$nik' and no_urut<>'1')
                        where nik='$nik'");
        $this->db->query("update sc_mst.karyawan set gajipokok=
                        (select sum(nominal) from sc_mst.dtlgaji_karyawan where nik='$nik' and no_urut='1')
                        where nik='$nik'");
        */

        $this->db->query("update sc_mst.karyawan set gajibpjs=$gajibpjs where nik='$nik'");
        $this->db->query("update sc_mst.karyawan set gajinaker=$gajinaker where nik='$nik'");

        //$enc_kdgroup_pg = $this->fiky_encryption->enkript(trim($kdgroup_pg));
        //redirect('payroll/tetap/detail'.'/'.$enc_kdgroup_pg);
        echo json_encode(array("status" => TRUE));
		
	}
	
	

	function edit_detail(){
		//$nik1=explode('|',);
		$kdrumus=$this->input->post('kdrumus');
		$tipe=$this->input->post('tipe');
		$keterangan=$this->input->post('keterangan');
		$aksi=$this->input->post('aksi');
		$aksi_tipe=$this->input->post('aksi_tipe');
		$tetap=$this->input->post('tetap');
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
			'tetap'=>$tetap,
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

	function recalculate_gaji_wilayah(){
        $request_body= file_get_contents('php://input');
        $data = json_decode($request_body);
        if ($data->key=='KEY'){
            $databalik = $data->key;
            $this->m_tetap->recalculate_gaji_wilayah();
            echo json_encode(array("enkript" => $databalik));
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        }
    }
	
	
	

}	