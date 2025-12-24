<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 13/04/2019
 * Time: 10:26
 */

class Index extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_master'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator','Fiky_version','Fiky_string','Fiky_menu'));

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

    public function  index(){
        $data['title']='HALO INI SELAMAT DATANG DI MENU PAYROLL';
        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.P'; $versirelease='I.P/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        $this->template->display('payroll/index/v_index',$data);
    }


}