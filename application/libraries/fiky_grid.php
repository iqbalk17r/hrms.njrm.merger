<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 11/04/2019
 * Time: 15:41
 */

class Fiky_grid
{
    var $table ;
    var $column_order ;
    var $column_search ;
    var $order;
   /// protected $_CI;
    public function __construct($parameters)
    {
        parent::__construct();
        /* array assoc */
        $this->parameter1 = $parameters['arg1'];
        $this->parameter2 = $parameters['arg2'];
        $this->parameter3 = $parameters['arg3'];
        $this->parameter3 = $parameters['arg3'];

        /* object */
        $oParameters = (object) $parameters;

        $this->parameter1 = $oParameters->arg1;
        $this->parameter2 = $oParameters->arg2;
        $this->parameter3 = $oParameters->arg3;
        $this->parameter4 = $oParameters->arg4;


        //$this->_CI->load->database();
        //$colsearch = $this->column_search;
    }
/*
    protected $_CI;

       function __construct($parameter){
           $this->_CI=&get_instance();
           $this->_CI->load->model(array('master/m_akses'));
          // $this->_CI->load->library('session');
       }
*/

    function coba(){
        //return $this->parameter1;
        return 'ASIK';
        /**
         * P1 : KODEMENU
         * P2 : NAMA VERSI
         * P3 : SESSION
         */
    }
    function version($p1,$p2,$p3,$p4){
        /* CODE UNTUK VERSI */
        //$kodemenu='I.P.F.4';
        $kodemenu=$p1;
        //$versirelease='I.P.F.4/ALPHA.001';
        $versirelease=$p2;
        //$userid=$this->_CI->session->userdata('nama');
        $vrdb = $this->_CI->m_akses->q_versidb($kodemenu)->num_rows();
        if ($vrdb<=0){
            $this->_CI->m_akses->insert_version($kodemenu);
            $vdb=$this->_CI->m_akses->q_versidb($kodemenu)->row_array();
        } else {
            $vdb=$this->_CI->m_akses->q_versidb($kodemenu)->row_array();
        }

        $vmn=$this->_CI->m_akses->q_menuprg($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        if($versidb<>$versirelease){
            $infoversiold= array (
                'vreleaseold'   => $versidb,
                'vdateold'      => $vdb['vdate'],
                'vauthorold'    => $vdb['vauthor'],
                'vketeranganold'=> $vdb['vketerangan'],
            );
            $this->_CI->m_akses->q_update_version($kodemenu,$infoversiold);

            $infoversi= array (
                'vrelease'   => $versirelease,
                'vdate'      => date('2017-07-10 11:18:00'),
                'vauthor'    => 'FIKY',
                'vketerangan'=> 'PENAMBAHAN VERSION RELEASE',
                'update_date' => $p3,
                'update_by'   => $p4,
            );
            $this->_CI->m_akses->q_update_version($kodemenu,$infoversi);
        }
        $vdb=$this->_CI->m_akses->q_versidb($kodemenu)->row_array();
        $versidb=$vdb['vrelease'];
        $data['version']=$versidb;
        /* END CODE UNTUK VERSI */
        return $versidb;
    }


}
