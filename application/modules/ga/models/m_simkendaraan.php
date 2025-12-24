<?php
class M_simkendaraan extends CI_Model{
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
    function q_trxerror($paramtrxerror){
        return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }
    function q_master_branch(){
        return $this->db->query("select 
								coalesce(branch    ,'')::text as branch      ,
								coalesce(branchname,'')::text as branchname  ,
								coalesce(address   ,'')::text as address     ,
								coalesce(phone1    ,'')::text as phone1      ,
								coalesce(phone2    ,'')::text as phone2      ,
								coalesce(fax       ,'')::text as fax from sc_mst.branch where cdefault='YES'");
    }
    function q_deltrxerror($paramtrxerror){
        return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
    }
	function q_ceksckendaraan($kdgroup){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
	}
	
	function q_sckendaraan(){
		return $this->db->query("select * from sc_mst.mgroup where left(kdgroup,3)='KDN' order by nmgroup");
	}

	function q_scsubkendaraan(){
		return $this->db->query("select * from sc_mst.msubgroup where left(kdgroup,3)='KDN' order by nmsubgroup");
	}
	
	function q_mstkendaraan(){
		return $this->db->query("select * from sc_mst.mbarang a left outer join sc_mst.karyawan b on b.nik=a.userpakai where left(kdgroup,3)='KDN' order by nmbarang");
	}
	function q_cekkendaraan($kdrangka){
		return $this->db->query("select * from sc_mst.mbarang where left(kdgroup,3)='KDN' and nodok='$kdrangka' order by nmbarang");
	}
	
	function q_mstkendaraanwil($param1){
		return $this->db->query("select * from sc_mst.mbarang where left(kdgroup,3)='KDN' $param1  order by nmbarang");
	}
	
	function q_mstkantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
	}

    function q_his_mst_simkendaraan($param){
	    return $this->db->query("select a.*,b.nmlengkap,b.bag_dept,c1.nmdept,b.subbag_dept,c2.nmsubdept,b.jabatan,c3.nmjabatan,b.lvl_jabatan,c4.nmlvljabatan,z.uraian as nmstatus from sc_his.sim_mst a
                                    left outer join sc_mst.karyawan b on a.nik=b.nik
                                    left outer join sc_mst.departmen c1 on b.bag_dept=c1.kddept
                                    left outer join sc_mst.subdepartmen c2 on b.bag_dept=c2.kddept and b.subbag_dept=c2.kdsubdept
                                    left outer join sc_mst.jabatan c3 on b.bag_dept=c3.kddept and b.subbag_dept=c3.kdsubdept and b.jabatan=c3.kdjabatan
                                    left outer join sc_mst.lvljabatan c4 on b.lvl_jabatan=c4.kdlvl
                                    left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB'
                                where docno is not null $param
                                order by docno desc");
    }
    function q_tmp_mst_simkendaraan($param){
        return $this->db->query("select a.*,b.nmlengkap,b.bag_dept,c1.nmdept,b.subbag_dept,c2.nmsubdept,b.jabatan,c3.nmjabatan,b.lvl_jabatan,c4.nmlvljabatan,z.uraian as nmstatus from sc_tmp.sim_mst a
                                    left outer join sc_mst.karyawan b on a.nik=b.nik
                                    left outer join sc_mst.departmen c1 on b.bag_dept=c1.kddept
                                    left outer join sc_mst.subdepartmen c2 on b.bag_dept=c2.kddept and b.subbag_dept=c2.kdsubdept
                                    left outer join sc_mst.jabatan c3 on b.bag_dept=c3.kddept and b.subbag_dept=c3.kdsubdept and b.jabatan=c3.kdjabatan
                                    left outer join sc_mst.lvljabatan c4 on b.lvl_jabatan=c4.kdlvl
                                    left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB'
                                where docno is not null $param
                                order by docno desc");
    }
    function insert_tmp_simkendaraan($paraminput){
        $nama=trim($this->session->userdata('nik'));
        return $this->db->query("   insert into sc_tmp.sim_mst(docno,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,status,
                                    inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
                                    (select * from 
                                    (select '$nama',to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,'' as docref,a.nik,docsim,typesim,to_char(now(),'yyyy-mm-dd')::date as datecreate,null::date as expsim,b.docsim as old_docsim,b.expsim as old_expsim,'' as reminder,null::date as reminderdate,'' as namapengurus,'' as contactpengurus,0 as ttlvalue,'' as description,'I' as status,
                                    to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp as inputdate,'$nama' as inputby,null::date as updatedate,null as updateby,null::date as approvaldate,null as approvalby,null as docnotmp 
                                    from sc_mst.karyawan a
                                    left outer join sc_mst.sim b on a.nik=b.nik) as x
                                    where nik is not null $paraminput);
                                ");
    }

    function q_trxtype_sim(){
        return $this->db->query("select * from sc_mst.trxtype where jenistrx='SIM' order by kdtrx");
    }
    function q_mst_sim($param){
        return $this->db->query("select * from (select a.*,b.nmlengkap,b.bag_dept,c1.nmdept,b.subbag_dept,c2.nmsubdept,b.jabatan,c3.nmjabatan,b.lvl_jabatan,c4.nmlvljabatan from sc_mst.sim a 
                                        left outer join sc_mst.karyawan b on a.nik=b.nik
                                        left outer join sc_mst.departmen c1 on b.bag_dept=c1.kddept
                                        left outer join sc_mst.subdepartmen c2 on b.bag_dept=c2.kddept and b.subbag_dept=c2.kdsubdept
                                        left outer join sc_mst.jabatan c3 on b.bag_dept=c3.kddept and b.subbag_dept=c3.kdsubdept and b.jabatan=c3.kdjabatan
                                        left outer join sc_mst.lvljabatan c4 on b.lvl_jabatan=c4.kdlvl) as x where nik is not null $param");
    }
    function final_temporary_sim(){
        $nama=trim($this->session->userdata('nik'));
        return $this->db->query(" update sc_tmp.sim_mst set status='F' where docno='$nama'");
    }

    function q_json_simkendaraan_his($param){
        return $this->db->query("select 
                                    coalesce((docno           ::text),'') as docno          ,
                                    coalesce((coalesce(to_char(docdate,'dd-mm-yyyy')::text,'')          ::text),'') as docdate        ,
                                    coalesce((docref          ::text),'') as docref         ,
                                    coalesce((nik             ::text),'') as nik            ,
                                    coalesce((docsim          ::text),'') as docsim         ,
                                    coalesce((typesim         ::text),'') as typesim        ,
                                    coalesce((coalesce(to_char(datecreate,'dd-mm-yyyy')::text,'')       ::text),'') as datecreate     ,
                                    coalesce((coalesce(to_char(expsim,'dd-mm-yyyy')::text,'')           ::text),'') as expsim         ,
                                    coalesce((old_docsim      ::text),'') as old_docsim     ,
                                    coalesce((coalesce(to_char(old_expsim,'dd-mm-yyyy')::text,'')       ::text),'') as old_expsim     ,
                                    coalesce((reminder        ::text),'') as reminder       ,
                                    coalesce((coalesce(to_char(reminderdate,'dd-mm-yyyy')::text,'')     ::text),'') as reminderdate   ,
                                    coalesce((namapengurus    ::text),'') as namapengurus   ,
                                    coalesce((contactpengurus ::text),'') as contactpengurus,
                                    coalesce((ttlvalue        ::text),'') as ttlvalue       ,
                                    coalesce((description     ::text),'') as description    ,
                                    coalesce((status          ::text),'') as status         ,
                                    coalesce((inputdate       ::text),'') as inputdate      ,
                                    coalesce((inputby         ::text),'') as inputby        ,
                                    coalesce((updatedate      ::text),'') as updatedate     ,
                                    coalesce((updateby        ::text),'') as updateby       ,
                                    coalesce((approvaldate    ::text),'') as approvaldate   ,
                                    coalesce((approvalby      ::text),'') as approvalby     ,
                                    coalesce((docnotmp        ::text),'') as docnotmp       ,
                                    coalesce((nmlengkap       ::text),'') as nmlengkap      ,
                                    coalesce((bag_dept        ::text),'') as bag_dept       ,
                                    coalesce((nmdept          ::text),'') as nmdept         ,
                                    coalesce((subbag_dept     ::text),'') as subbag_dept    ,
                                    coalesce((nmsubdept       ::text),'') as nmsubdept      ,
                                    coalesce((jabatan         ::text),'') as jabatan        ,
                                    coalesce((nmjabatan       ::text),'') as nmjabatan      ,
                                    coalesce((lvl_jabatan     ::text),'') as lvl_jabatan    ,
                                    coalesce((nmlvljabatan    ::text),'') as nmlvljabatan   ,
                                    coalesce((nmstatus        ::text),'') as nmstatus      from (
                                    select a.*,b.nmlengkap,b.bag_dept,c1.nmdept,b.subbag_dept,c2.nmsubdept,b.jabatan,c3.nmjabatan,b.lvl_jabatan,c4.nmlvljabatan,z.uraian as nmstatus from sc_his.sim_mst a
                                        left outer join sc_mst.karyawan b on a.nik=b.nik
                                        left outer join sc_mst.departmen c1 on b.bag_dept=c1.kddept
                                        left outer join sc_mst.subdepartmen c2 on b.bag_dept=c2.kddept and b.subbag_dept=c2.kdsubdept
                                        left outer join sc_mst.jabatan c3 on b.bag_dept=c3.kddept and b.subbag_dept=c3.kdsubdept and b.jabatan=c3.kdjabatan
                                        left outer join sc_mst.lvljabatan c4 on b.lvl_jabatan=c4.kdlvl
                                        left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB') as x
                                    where docno is not null $param
                                    order by docno desc");
    }

}