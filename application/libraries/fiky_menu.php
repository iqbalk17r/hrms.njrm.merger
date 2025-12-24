<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 11/04/2019
 * Time: 15:41
 */

class Fiky_menu
{

    protected $_CI;

       function __construct(){
           $this->_CI=&get_instance();
           $this->_CI->load->model(array('master/m_akses','master/m_menu'));
           $this->_CI->load->library(array('session'));
       }

    function coba(){
        return 'TEST';
        /**
         * P1 : KODEMENU
         * P2 : NAMA VERSI
         * P3 : SESSION
         */
    }
    function menus($p1,$p2){
        /* CODE UNTUK VERSI */
        //$kodemenu='I.P.F.4';
        $kodemenu=$p1;
        //$versirelease='I.P.F.4/ALPHA.001';
        $versirelease=$p2;
        $userid=$this->_CI->session->userdata('nama');
        $vmn=$this->_CI->m_menu->q_menuprg($kodemenu)->row_array();
        $vmext=$this->_CI->m_menu->q_menuprg_ext($kodemenu)->result();
        $data['rows'] = $vmn;
        $data['res'] = $vmext;
        $data['xn'] = 'Author: '.$this->_CI->config->item('xauthor').' : ';
        /* END CODE UNTUK VERSI */
        return $data;
    }

    function public_hair($p1,$p2){
        $title='xxx';
            //$printhtml = '';
            //$printhtml = '<div class="content-wrapper">';
            //$printhtml = '<!-- Content Header (Page header) -->';
            //$printhtml = '<section class="content-header">';
            //$printhtml ='    <legend>';
            //$printhtml ='        '. $title .' ';
            //$printhtml ='    </legend> ';
        /*$printhtml =    <ol class="breadcrumb">\';
        $printhtml =<div class="pull-right">Versi: <?php echo $version; ?></div>\';
        $printhtml =<?php foreach ($y as $y1) { ?>\';
        $printhtml =<?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>\';
        $printhtml =<li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>\';
        $printhtml =<?php } else { ?>\';
        $printhtml =<li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>\';
        $printhtml =<?php } ?>\';
        $printhtml =<?php } ?>\';
        $printhtml =</ol>\';
        $printhtml =</section>\';*/
        $x=$this->menus($p1,$p2);
        $printhtml = $this->_CI->load->view('/breadcrumb.php',$x);
        return $printhtml;
    }

}
