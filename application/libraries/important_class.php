<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/3/19 8:44 AM
 *  * Last Modified: 4/12/19 11:11 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Important_class
{

    protected $_CI;
    function __construct(){
        set_error_handler(
            function ($severity, $message, $file, $line) {
                ///throw new ErrorException($message, $severity, $severity, $file, $line);
            }
        );
        $this->_CI=&get_instance();
        //$this->_CI->load->model(array('master/m_akses','master/m_menu'));
        $this->_CI->load->library(array('Fiky_version','Fiky_string','Fiky_menu','Fiky_wilayah','Fiky_string','Fiky_encryption'));
    }

    function cobazz($var){
        return $var;
        /**
         * P1 : KODEMENU
         * P2 : NAMA VERSI
         * P3 : SESSION
         */
    }
    function capture_fn(){
        /* Nulled by request */
        return '';
    }

    function drp_fn(){
        /* Nulled by request */
        return '';
    }

    function rest_fn(){
        /* Nulled by request */
        return '';
    }

    function test(){
        /* Nulled by request */
        return '';
    }

    function capture_tr(){
        /* Nulled by request */
        return ''; }

    function drp_tr(){
        /* Nulled by request */
        return '';
    }

    function rest_tr(){
        /* Nulled by request */
        return '';
    }

    /* view */
    function capture_view(){/* Nulled by request */
        return '';
    }

    function drp_view(){/* Nulled by request */
        return '';}

    function rest_view(){
        /* Nulled by request */
        return '';
    }

    function fill_b_fn($dir,$type){
        /* Nulled by request */
        return '';
    }

    function fill_b_tr($dir,$type){
        /* Nulled by request */
        return '';
    }

    function read_capture_tr($dir){
        /* Nulled by request */
        return '';
    }
    function read_capture_fn($dir){
        /* Nulled by request */
        return '';
    }
    function unlinkForStableSystem(){/* Nulled by request */
        return '';
    }

}
