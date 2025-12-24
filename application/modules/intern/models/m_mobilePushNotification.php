<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 1/23/20, 10:50 AM
 *  * Last Modified: 11/16/18, 9:56 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

class M_mobilePushNotification extends CI_Model{


	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


    function mst_branch($param){
	    return $this->db->query("select * from sc_mst.branch where coalesce(cdefault,'')='YES'");
    }
	function mst_user($param){
	    return $this->db->query("select
                    coalesce(trim(username       ::text),'') as username,
                    coalesce(trim(nik     ::text),'') as nik       ,
                    coalesce(trim(loccode     ::text),'') as loccode,
                    coalesce(trim(branch     ::text),'') as branch,
                    coalesce(trim(level_id     ::text),'') as level_id,
                    coalesce(trim(level_akses     ::text),'') as level_akses
                    from sc_mst.user where username is not null $param "
        );
    }

	function list_approvals($param,$paramtop,$paramoffset){
	    return $this->db->query("select 
                    coalesce(trim(docno       ::text),'') as docno         ,          
                    coalesce(trim(docdate     ::text),'') as docdate       ,          
                    coalesce(trim(docref      ::text),'') as docref        ,          
                    coalesce(trim(doctype     ::text),'') as doctype       ,          
                    coalesce(trim(doctypename ::text),'') as doctypename   ,          
                    coalesce(trim(kdgroup     ::text),'') as kdgroup       ,          
                    coalesce(trim(kdsubgroup  ::text),'') as kdsubgroup    ,          
                    coalesce(trim(stockcode   ::text),'') as stockcode     ,          
                    coalesce(trim(suppcode    ::text),'') as suppcode      ,          
                    coalesce(trim(subsuppcode ::text),'') as subsuppcode   ,          
                    coalesce(trim(suppname    ::text),'') as suppname      ,          
                    coalesce(trim(stockname   ::text),'') as stockname     ,          
                    coalesce(trim(ppny        ::text),'') as ppny          ,          
                    coalesce(trim(exppn       ::text),'') as exppn         ,          
                    coalesce(trim(ttldiskon   ::text),'') as ttldiskon     ,          
                    coalesce(trim(ttldpp      ::text),'') as ttldpp        ,          
                    coalesce(trim(ttlppn      ::text),'') as ttlppn        ,          
                    coalesce(trim(ttlppnbm    ::text),'') as ttlppnbm      ,          
                    coalesce(trim(ttlnetto    ::text),'') as ttlnetto      ,          
                    coalesce(trim(description ::text),'') as description   ,          
                    coalesce(trim(status      ::text),'') as status        ,          
                    coalesce(trim(asstatus    ::text),'') as asstatus      ,          
                    coalesce(trim(inputdate   ::text),'') as inputdate     ,          
                    coalesce(trim(inputby     ::text),'') as inputby       ,          
                    coalesce(trim(updatedate  ::text),'') as updatedate    ,          
                    coalesce(trim(updateby    ::text),'') as updateby      ,          
                    coalesce(trim(approvaldate::text),'') as approvaldate  ,          
                    coalesce(trim(approvalby  ::text),'') as approvalby    ,          
                    coalesce(trim(canceldate  ::text),'') as canceldate    ,          
                    coalesce(trim(cancelby    ::text),'') as cancelby      ,          
                    coalesce(trim(docnotmp    ::text),'') as docnotmp      ,          
                    coalesce(trim(tabelname   ::text),'') as tabelname     ,          
                    coalesce(trim(astabelname ::text),'') as astabelname   ,          
                    coalesce(trim(erptype     ::text),'') as erptype       ,          
                    coalesce(trim(branch      ::text),'') as branch,
                    coalesce(trim(to_char(docdate,'dd-mm-yyyy')::text),'') as docdate1,
                    case when status='A' then 'BUTUH PERSETUJUAN' else 'DITOLAK' end as nmstatus from sc_trx.approvals_system
                    where docno is not null $param $paramoffset $paramtop");
    }

    function list_count_approvals($param){
	    return $this->db->query("select * from sc_trx.approvals_system where docno is not null $param");
    }

    function list_master_approvals($param){
        return $this->db->query("select * from sc_trx.approvals_system where docno is not null $param");
    }

    function list_dtl_approvals($param){
	    return $this->db->query("select 
                    coalesce(trim(docno       ::text),'') as docno         ,          
                    coalesce(trim(docdate     ::text),'') as docdate       ,          
                    coalesce(trim(docref      ::text),'') as docref        ,          
                    coalesce(trim(doctype     ::text),'') as doctype       ,          
                    coalesce(trim(doctypename ::text),'') as doctypename   ,          
                    coalesce(trim(kdgroup     ::text),'') as kdgroup       ,          
                    coalesce(trim(kdsubgroup  ::text),'') as kdsubgroup    ,          
                    coalesce(trim(stockcode   ::text),'') as stockcode     ,          
                    coalesce(trim(suppcode    ::text),'') as suppcode      ,          
                    coalesce(trim(subsuppcode ::text),'') as subsuppcode   ,          
                    coalesce(trim(suppname    ::text),'') as suppname      ,          
                    coalesce(trim(stockname   ::text),'') as stockname     ,          
                    coalesce(trim(ppny        ::text),'') as ppny          ,          
                    coalesce(trim(exppn       ::text),'') as exppn         ,          
                    coalesce(trim(ttldiskon   ::text),'') as ttldiskon     ,          
                    coalesce(trim(ttldpp      ::text),'') as ttldpp        ,          
                    coalesce(trim(ttlppn      ::text),'') as ttlppn        ,          
                    coalesce(trim(ttlppnbm    ::text),'') as ttlppnbm      ,          
                    coalesce(trim(ttlnetto    ::text),'') as ttlnetto      ,          
                    coalesce(trim(description ::text),'') as description   ,          
                    coalesce(trim(status      ::text),'') as status        ,          
                    coalesce(trim(asstatus    ::text),'') as asstatus      ,          
                    coalesce(trim(inputdate   ::text),'') as inputdate     ,          
                    coalesce(trim(inputby     ::text),'') as inputby       ,          
                    coalesce(trim(updatedate  ::text),'') as updatedate    ,          
                    coalesce(trim(updateby    ::text),'') as updateby      ,          
                    coalesce(trim(approvaldate::text),'') as approvaldate  ,          
                    coalesce(trim(approvalby  ::text),'') as approvalby    ,          
                    coalesce(trim(canceldate  ::text),'') as canceldate    ,          
                    coalesce(trim(cancelby    ::text),'') as cancelby      ,          
                    coalesce(trim(docnotmp    ::text),'') as docnotmp      ,          
                    coalesce(trim(tabelname   ::text),'') as tabelname     ,          
                    coalesce(trim(astabelname ::text),'') as astabelname   ,          
                    coalesce(trim(erptype     ::text),'') as erptype       ,          
                    coalesce(trim(branch      ::text),'') as branch,
                    coalesce(trim(to_char(docdate,'dd-mm-yyyy')::text),'') as docdate1,
                    case when status='A' then 'BUTUH PERSETUJUAN' else 'DITOLAK' end as nmstatus from sc_trx.approvals_system
                    where docno is not null $param ");
    }

    function list_dtl_cuti_approvals($param){
        return $this->db->query("select * from (select 
                    coalesce(trim(a.docno       ::text),'') as docno         ,          
                    a.docdate as docdate       ,          
                    coalesce(trim(a.docref      ::text),'') as docref        ,          
                    coalesce(trim(a.doctype     ::text),'') as doctype       ,          
                    coalesce(trim(a.doctypename ::text),'') as doctypename   ,          
                    coalesce(trim(a.kdgroup     ::text),'') as kdgroup       ,          
                    coalesce(trim(a.kdsubgroup  ::text),'') as kdsubgroup    ,          
                    coalesce(trim(a.stockcode   ::text),'') as stockcode     ,          
                    coalesce(trim(a.suppcode    ::text),'') as suppcode      ,          
                    coalesce(trim(a.subsuppcode ::text),'') as subsuppcode   ,          
                    coalesce(trim(a.suppname    ::text),'') as suppname      ,          
                    coalesce(trim(a.stockname   ::text),'') as stockname     ,          
                    coalesce(trim(a.ppny        ::text),'') as ppny          ,          
                    coalesce(trim(a.exppn       ::text),'') as exppn         ,          
                    coalesce(trim(a.ttldiskon   ::text),'') as ttldiskon     ,          
                    coalesce(trim(a.ttldpp      ::text),'') as ttldpp        ,          
                    coalesce(trim(a.ttlppn      ::text),'') as ttlppn        ,          
                    coalesce(trim(a.ttlppnbm    ::text),'') as ttlppnbm      ,          
                    coalesce(trim(a.ttlnetto    ::text),'') as ttlnetto      ,          
                    coalesce(trim(a.description ::text),'') as description   ,          
                    coalesce(trim(a.status      ::text),'') as status        ,          
                    coalesce(trim(a.asstatus    ::text),'') as asstatus      ,          
                    coalesce(trim(a.inputdate   ::text),'') as inputdate     ,          
                    coalesce(trim(a.inputby     ::text),'') as inputby       ,          
                    coalesce(trim(a.updatedate  ::text),'') as updatedate    ,          
                    coalesce(trim(a.updateby    ::text),'') as updateby      ,          
                    coalesce(trim(a.approvaldate::text),'') as approvaldate  ,          
                    coalesce(trim(a.approvalby  ::text),'') as approvalby    ,          
                    coalesce(trim(a.canceldate  ::text),'') as canceldate    ,          
                    coalesce(trim(a.cancelby    ::text),'') as cancelby      ,          
                    coalesce(trim(a.docnotmp    ::text),'') as docnotmp      ,          
                    coalesce(trim(a.tabelname   ::text),'') as tabelname     ,          
                    coalesce(trim(a.astabelname ::text),'') as astabelname   ,          
                    coalesce(trim(a.erptype     ::text),'') as erptype       ,          
                    coalesce(trim(a.branch      ::text),'') as branch,
                    coalesce(trim(b.nik      ::text),'') as nik,
                    coalesce(trim(b.nik_atasan      ::text),'') as nik_atasan1,
                    coalesce(trim(b.nik_atasan2      ::text),'') as nik_atasan2,
                    coalesce(trim(b.nmlengkap      ::text),'') as nmlengkap,
                    coalesce(trim(b.nmatasan1      ::text),'') as nmatasan1,
                    coalesce(trim(b.nmatasan2      ::text),'') as nmatasan2,
                    coalesce(trim(b.nmdept      ::text),'') as nmdept,
                    coalesce(trim(b.nmsubdept      ::text),'') as nmsubdept,
                    coalesce(trim(b.nmjabatan      ::text),'') as nmjabatan,
                    coalesce(trim(b.nmlvljabatan      ::text),'') as nmlvljabatan,
                    coalesce(trim(c.pelimpahan      ::text),'') as pelimpahan,
                    coalesce(trim(c.jumlah_cuti      ::text),'') as jumlah_cuti,
                    coalesce(trim(c1.nmlengkap      ::text),'') as nmpelimpahan,
                    coalesce(trim(to_char(c.tgl_mulai,'dd-mm-yyyy'      )::text),'') as tgl_awal,
                    coalesce(trim(to_char(c.tgl_selesai,'dd-mm-yyyy'     ) ::text),'') as tgl_akhir,
                    case 
                    when a.asstatus='A' then 'BUTUH PERSETUJUAN' 
                    when a.asstatus='A1' then 'BUTUH PERSETUJUAN' 
                    when a.asstatus='F' then 'FINAL' 
                    when a.asstatus='D' then 'DELETE' 
                    when a.asstatus='C' then 'CANCEL' 
                    when a.asstatus='P' then 'DISETUJUI' END as nmasstatus,
                    case 
                    when a.status='A' then 'BUTUH PERSETUJUAN' 
                    when a.status='A1' then 'BUTUH PERSETUJUAN' 
                    when a.status='F' then 'FINAL' 
                    when a.status='D' then 'DELETE' 
                    when a.status='C' then 'CANCEL' 
                    when a.status='P' then 'DISETUJUI' END as nmstatus
                    from sc_trx.approvals_system a
                    left outer join sc_mst.lv_m_karyawan b on a.docref=b.nik
                    left outer join sc_trx.cuti_karyawan c on a.docref=c.nik and a.docno=c.nodok
                    left outer join sc_mst.karyawan c1 on c.nik=c1.nik) as x where docno is not null $param");
    }



}
