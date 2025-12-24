<?php
class M_uang extends Ci_model{
	
	function q_uang(){
		return $this->db->query("select * from sc_mst.uangmakan");
	}
	function q_uang_cek($kdlvl){
		return $this->db->query("select * from sc_mst.uangmakan where kdlvl='$kdlvl'");
	}
	function simpan_um($info){

	}
	
	function q_cabang($branch){
		return $this->db->query("select * from sc_mst.fingerprint where ipaddress='$branch'");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_mst.jabatan order by nmjabatan");
	}
	
	function q_kantin(){
		return $this->db->query("select a.*,b.desc_cabang from sc_mst.kantin a
								left outer join sc_mst.kantorwilayah b on a.kdcabang=b.kdcabang");
	}

	function q_kantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah");
	}
}
