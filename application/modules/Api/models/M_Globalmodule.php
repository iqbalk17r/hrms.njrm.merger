<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/24/20, 10:57 AM
 *  * Last Modified: 10/24/20, 10:57 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */


class M_Globalmodule extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function q_versidb($kodemenu){
        return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
    }
    function q_trxerror($paramtrxerror){
        return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }
    function q_trxtype($paramtrxtype){
        return $this->db->query("select coalesce(kdtrx,'') as kdtrx, coalesce (jenistrx,'') as jenistrx,coalesce(uraian,'') as uraian,trim(kdtrx) as id from sc_mst.trxtype where kdtrx is not null $paramtrxtype");
    }
    function q_trxstatus($paramtrxstatus){
        return $this->db->query("select coalesce(kdtrx,'') as kdtrx, coalesce (jenistrx,'') as jenistrx,coalesce(uraian,'') as uraian,trim(kdtrx) as id from sc_mst.trxstatus where kdtrx is not null $paramtrxstatus");
    }
    function q_master_branch(){
        return $this->db->query("select 
								coalesce(branch    ,'')::text as branch      ,
								coalesce(branchname,'')::text as branchname  ,
								coalesce(address   ,'')::text as address     ,
								coalesce(phone1    ,'')::text as phone1      ,
								coalesce(phone2    ,'')::text as phone2      ,
								coalesce(fax       ,'')::text as fax from sc_mst.branch where coalesce(cdefault,'')='YES'");
    }
    function q_deltrxerror($paramtrxerror){
        return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
    }

    function q_customer($param){
        return $this->db->query("select *,coalesce(custcode,'') as id from sc_mst.customer where coalesce(custcode,'')!='' $param ");
    }

    function q_lv_m_karyawan($param){
        return $this->db->query("select *,coalesce(nik,'') as id from sc_mst.lv_m_karyawan where coalesce(statuskepegawaian,'')!='KO' $param ");
    }

    function q_kantorwilayah($param){
        return $this->db->query("select *,coalesce(kdcabang,'') as id from sc_mst.kantorwilayah where coalesce(kdcabang,'')!='' $param ");
    }


}