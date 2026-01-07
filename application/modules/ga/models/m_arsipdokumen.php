<?php
class M_arsipdokumen extends CI_Model{
	
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
								coalesce(fax       ,'')::text as fax from sc_mst.branch where branch='SBYNSA'");
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

    function q_mgudang(){
        return $this->db->query("select * from sc_mst.mgudang order by locaname asc");
    }
    function q_his_arsipdokumen($param){
	    return $this->db->query("select * from (
                                    select a.*,b.archives_name,b.archives_own,c.uraian as nmstatus from sc_his.archives_mst a
                                    left outer join sc_mst.archives b on a.archives_id = b.docno
                                    left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='STNKB'
                                    ) as x
                                    where docno is not null $param
                                    order by docno desc");
    }
    function q_tmp_arsipdokumen($param){
        return $this->db->query("select * from (
                                    select a.*,b.archives_name,b.archives_own,c.uraian as nmstatus from sc_tmp.archives_mst a
                                    left outer join sc_mst.archives b on a.archives_id = b.docno
                                    left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='STNKB'
                                    ) as x
                                    where docno is not null $param
                                    order by docno desc");
    }
    function insert_tmp_arsipdokumen($paraminput){
        $nama=trim($this->session->userdata('nik'));
        return $this->db->query("insert into sc_tmp.archives_mst
                                    (docno,docdate,docref,archives_id,archives_number,archives_exp,old_archives_number,old_archives_exp,namapengurus,contactpengurus,
                                    ttlvalue,description,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp)
                                    (select '$nama',to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,'' as docref,docno as archives_id,archives_number,archives_exp,archives_number as old_archives_number,null as old_archives_exp,namapengurus,contactpengurus,
                                    ttlvalue,'' as description,'I' as status,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,'$nama',null,null,null as approvaldate,null as approvalby,null as nodoktmp
                                    from sc_mst.archives where docno is not null $paraminput)
                                ");
    }

    function final_temporary_arsip(){
        $nama=trim($this->session->userdata('nik'));
        return $this->db->query(" update sc_tmp.archives_mst set status='F' where docno='$nama'");
    }

    function q_json_ujikir_his($param){
        return $this->db->query("   
                                select
                                coalesce(docno::text,'') as  docno,
                                coalesce(to_char(docdate,'dd-mm-yyyy')::text,'') as  docdate,
                                coalesce(docref::text,'') as  docref,
                                coalesce(kdgroup::text,'') as  kdgroup,
                                coalesce(kdsubgroup::text,'') as  kdsubgroup,
                                coalesce(stockcode::text,'') as  stockcode,
                                coalesce(docujikir::text,'') as  docujikir,
                                coalesce(to_char(expkir,'dd-mm-yyyy')::text,'') as  expkir,
                                coalesce(old_docujikir::text,'') as  old_docujikir,
                                coalesce(to_char(old_expkir,'dd-mm-yyyy')::text,'') as  old_expkir,
                                coalesce(reminder::text,'') as  reminder,
                                coalesce(reminderdate::text,'') as  reminderdate,
                                coalesce(namapengurus::text,'') as  namapengurus,
                                coalesce(contactpengurus::text,'') as  contactpengurus,
                                coalesce(ttlvalue::text,'') as  ttlvalue,
                                coalesce(description::text,'') as  description,
                                coalesce(status::text,'') as  status,
                                coalesce(inputdate::text,'') as  inputdate,
                                coalesce(inputby::text,'') as  inputby,
                                coalesce(updatedate::text,'') as  updatedate,
                                coalesce(updateby::text,'') as  updateby,
                                coalesce(approvaldate::text,'') as  approvaldate,
                                coalesce(approvalby::text,'') as  approvalby,
                                coalesce(docnotmp::text,'') as  docnotmp,
                                coalesce(nmbarang::text,'') as  nmbarang,
                                coalesce(kdgudang::text,'') as  kdgudang,
                                coalesce(nmpemilik::text,'') as  nmpemilik,
                                coalesce(addpemilik::text,'') as  addpemilik,
                                coalesce(nopol::text,'') as  nopol,
                                coalesce(kdrangka::text,'') as  kdrangka,
                                coalesce(kdmesin::text,'') as  kdmesin,
                                coalesce(nmstatus::text,'') as  nmstatus, 
                                coalesce(modelid::text,'') as  modelid,
                                coalesce(typeid::text,'') as  typeid,
                                coalesce(jenisid::text,'') as  jenisid,
                                coalesce(silinder::text,'') as  silinder,
                                coalesce(tahunpembuatan::text,'') as  tahunpembuatan,
                                coalesce(bahanbakar::text,'') as  bahanbakar,
                                coalesce(warna::text,'') as  warna,
                                coalesce(kdlokasi::text,'') as  kdlokasi
                                from (
                                select a.*,b.nmbarang,b.kdgudang,b.nmpemilik,b.addpemilik,b.nopol,b.kdrangka,b.kdmesin,z.uraian as nmstatus,
                                b.modelid,b.typeid,b.jenisid,b.silinder,b.tahunpembuatan,b.bahanbakar,b.warna,b.kdlokasi
                                    from sc_his.kir_mst a
                                    left outer join sc_mst.mbarang b on b.nodok=a.stockcode
                                    left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB'
                                    where docno is not null $param
                                    ) as x
                                    order by docno desc");
    }

    function q_mst_archives($param){
	    return $this->db->query("select * from (
                                    select a.*,b.locaname from sc_mst.archives a
                                    left outer join sc_mst.mgudang b on a.loccode=b.loccode) as x
                                    where docno is not null $param order by docno desc");
    }

    function q_scgroup(){
        return $this->db->query("select * from sc_mst.mgroup where kdgroup in ('DCN') order by nmgroup");
    }


    function q_scsubgroup(){
        return $this->db->query("select * from sc_mst.msubgroup where kdgroup in ('DCN') order by nmsubgroup");
    }
}