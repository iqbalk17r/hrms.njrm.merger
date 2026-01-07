<?php
class M_supplier extends CI_Model{

    function q_versidb($kodemenu){
        return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
    }

    function q_cekscgroup($kdgroup){
        return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
    }
    function q_cekscsubgroup($kdgroup){
        return $this->db->query("select * from sc_mst.msubgroup where kdgroup='$kdgroup'");
    }
    function q_cekscsubgroup_2p($kdgroup,$kdsubgroup){
        return $this->db->query("select * from sc_mst.msubgroup where kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup'");
    }
    function q_mstkantor(){
        return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
    }
    function q_gudangwilayah(){
        return $this->db->query("select * from sc_mst.mgudang order by locaname");
    }
    function q_scgroup(){
        return $this->db->query("select * from sc_mst.mgroup order by nmgroup");
    }
    function q_scgroup_supplier(){
        return $this->db->query("select * from sc_mst.trxtype where jenistrx='JSUPPLIER' order by kdtrx asc");
    }

    function q_scsubgroup(){
        return $this->db->query("select * from sc_mst.msubgroup order by nmsubgroup");
    }

    function q_scsubgroup_suplier(){
        return $this->db->query("select * from sc_mst.msubgroup where left(kdgroup,3)='SUP' order by nmsubgroup");
    }

    function q_supplier(){
        return $this->db->query("select * from (
								select a.*,b.uraian as nmjenis,coalesce(c.rowdtl,0) as rowdtl from sc_mst.msupplier a 
								left outer join sc_mst.trxtype b on a.kdgroup=b.kdtrx 
								left outer join (select count(*) as rowdtl,kdsupplier from  sc_mst.msubsupplier group by kdsupplier) c on a.kdsupplier=c.kdsupplier
								order by a.nmsupplier) as x");
    }
    function q_supplier_param($param1){
        return $this->db->query("select a.*,b.uraian as nmjenis from sc_mst.msupplier a left outer join sc_mst.trxtype b on a.kdgroup=b.kdtrx 
		where kdsupplier is not null $param1 order by a.nmsupplier");
    }

    function q_subsupplier(){
        return $this->db->query("select a.*,b.nmsupplier,c.uraian as nmjenis,d.desc_cabang from sc_mst.msubsupplier a
								left outer join sc_mst.msupplier b on a.kdsupplier=b.kdsupplier 
								left outer join sc_mst.trxtype c on b.kdgroup=c.kdtrx
								left outer join sc_mst.kantorwilayah d on a.kdcabang=d.kdcabang
								order by a.nmsubsupplier asc");
    }
    function q_subsupplier_param($param1){
        return $this->db->query("select * from (
							select a.*,b.nmsupplier,c.uraian as nmjenis,d.desc_cabang,coalesce(e.rowdtl,0) as rowdtl from sc_mst.msubsupplier a
								left outer join sc_mst.msupplier b on a.kdsupplier=b.kdsupplier 
								left outer join sc_mst.trxtype c on b.kdgroup=c.kdtrx
								left outer join sc_mst.kantorwilayah d on a.kdcabang=d.kdcabang
								left outer join (select count(kdsupplier) as rowdtl,kdsubsupplier from sc_mst.pricelst
								group by kdsubsupplier) e on a.kdsubsupplier=e.kdsubsupplier
								order by a.nmsubsupplier asc) as x where kdsubsupplier is not null $param1 order by kdsubsupplier desc");
    }

    function q_subsupplier_param2($param1,$param2){
        return $this->db->query("select * from (
		select a.*,b.nmsupplier,c.uraian as nmjenis,d.desc_cabang from sc_mst.msubsupplier a
								left outer join sc_mst.msupplier b on a.kdsupplier=b.kdsupplier 
								left outer join sc_mst.trxtype c on b.kdgroup=c.kdtrx
								left outer join sc_mst.kantorwilayah d on a.kdcabang=d.kdcabang
								order by a.nmsubsupplier asc) as x where kdsubsupplier is not null $param1 $param2");
    }


}	