<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 11/6/20, 10:44 AM
 *  * Last Modified: 7/9/20, 1:22 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

class M_trxerror extends CI_Model{

    function q_versidb($kodemenu){
        return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
    }

    function q_trxerror($paramtrxerror){
        return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }

    function q_deltrxerror($paramtrxerror){
        return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
    }

    function ins_trxerror($userid,$errorcode,$nomorakhir1,$nomorakhir2,$modul){
        $this->db->where('userid',$userid);
        $this->db->where('modul',$modul);
        $this->db->delete('sc_mst.trxerror');
        /* error handling */
        $infotrxerror = array (
            'userid' => $userid,
            'errorcode' => $errorcode,
            'nomorakhir1' => $nomorakhir1,
            'nomorakhir2' => $nomorakhir2,
            'modul' => $modul,
        );
        $this->db->insert('sc_mst.trxerror',$infotrxerror);
        return $this->db->affected_rows();
    }

    function unfinish($name,$urlclear,$urlnext,$title,$body){
        return"
            <!-- Bootstrap modal -->
<div class=\"modal fade\" id=\"modal_unfinish\" role=\"dialog\">
    <div class=\"modal-dialog modal-md\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h4 class=\"modal-title\" align=\"center\"> $title   $name </h4>
            </div>
            <div class=\"modal-body form\">
                <h5 class=\"modal-title\"  align=\"center\"> $body </h5>
            </div>
            <div class=\"modal-footer\">
                <a href=\"$urlnext\" type=\"button\" class=\"btn btn-primary pull-right\"><i class='fa fa-arrow-right'></i> Lanjutkan</a>
                <a href=\"$urlclear\" type=\"button\" class=\"btn btn-danger pull-left\" ><i class='fa fa-trash'></i> Clear</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type=\"text/javascript\">
            $('#modal_unfinish').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            }); // show bootstrap modal
</script>            
            ";

    }
}

