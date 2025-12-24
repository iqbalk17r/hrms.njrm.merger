<?php
class M_uang extends Ci_model{
	
	function q_uang(){
		return $this->db->query("select * from sc_hrd.uangmakan");
	}
	
	function simpan_um($info){
		$this->db->insert("sc_hrd.uangmakan",$info);
	}
	
	function q_cabang($branch){
		return $this->db->query("select * from sc_hrd.fingerprint where ipaddress='$branch'");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_hrd.jabatan order by deskripsi");
	}
	
	function q_kantin(){
		return $this->db->query("select a.*,b.desc_cabang from sc_hrd.kantin a
								left outer join sc_mst.kantor b on a.kd_cab=b.kodecabang");
	}
}
