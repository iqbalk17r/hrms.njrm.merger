<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 12/12/19, 9:13 AM
 *  * Last Modified: 4/12/19, 11:11 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Fiky_mailer
{

    protected $_CI;

       function __construct(){
           $this->_CI=&get_instance();
           $this->_CI->load->library(array('encrypt','fiky_encryption'));
           $no_dok='NSANBI';
           $config_smtp=$this->_CI->db->query("select * from sc_mst.setup_mail_smtp where no_dok='$no_dok'")->row_array();
           $config = Array(
               'protocol' => trim($config_smtp['protocol']),
               'smtp_host' => trim($config_smtp['smtp_host']),
               'smtp_port' => trim($config_smtp['smtp_port']),
               'smtp_user' => trim($config_smtp['smtp_user']),
               'smtp_pass' => $this->_CI->encrypt->decode($config_smtp['smtp_pass']),
               'mailtype'  => trim($config_smtp['mail_type']),
               'charset'   => trim($config_smtp['charset'])
           );
           $this->_CI->load->library('email', $config);
           $this->_CI->email->set_newline("\r\n");
       }



}
