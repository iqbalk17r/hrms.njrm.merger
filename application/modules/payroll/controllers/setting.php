<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/26/19 4:03 PM
 *  * Last Modified: 4/26/19 4:02 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Setting extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('master/m_akses','m_setting'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }


	function index(){
        $data['title']="View Gaji Tetap Per Periode";
        /* CODE UNTUK VERSI */
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P.F.4'; $versirelease='I.P.F.4/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $periode=$this->input->post('periode');
        if (empty($periode)){ $data['enc_periode']='';} else { $data['enc_periode']=$this->fiky_encryption->enkript($periode); }
        $data['enc_kdgroup_pg']='';
		$this->template->display('payroll/setting/v_index',$data);
	}

    function list_gaji_per_periode()
    {
        $seg4=$this->uri->segment(4);
        if (empty($seg4)) { $periode = '';
            $param = null;
        } else { $periode = $this->fiky_encryption->dekript($seg4);
            $param = $this->db->where(array('periode' => $periode));
        }


        $list = $this->m_setting->get_t_historygaji($param);
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
            $row[] = $lm->periode;
            $row[] = '<div align="right">'.number_format($lm->gajipokok,2).'</div>';
            $row[] = '<div align="right">'.number_format($lm->gajitj,2).'</div>';
            //add html for action
            /*$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah Wilayah Nominal" onclick="Ubah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus Wilayah Nominal" onclick="hapus_wilayah('."'".trim($lm->kdwilayahnominal)."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';*/
           /* $row[] = '<a data-url="'.site_url("/payroll/tetap/modaldetail/$enc_nik").'" class="btn btn-primary btn-sm showon" style="margin-left:10px;  margin-top:5px" data-toggle="modal" data-target=".lod">
                    <i class="fa fa-gear"></i>
                                        </a>';*/
           $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_setting->t_historygaji_all($param),
            "recordsFiltered" => $this->m_setting->t_historygaji_count_filtered($param),
            "data" => $data,
        );
        echo $this->fiky_encryption->jDatatable($output);
    }

	
}