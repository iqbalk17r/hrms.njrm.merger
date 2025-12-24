<?php

function checkAccessSidia($nik){
    $CI = &get_instance();
    $CI->load->model(array('master/M_UserSidia'));
    $accessSidia = $CI->M_UserSidia->q_transaction_read_where(' AND nik = \''.$nik.'\' ')->row();
    if (!empty($accessSidia)){
        if (strtolower($accessSidia->hold) == 'yes'){
            return false;
        }else{
            return true;
        }
    }else{
        return true;
    }
}