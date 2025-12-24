<?php
class M_jenjang_pendidikan extends CI_Model{
	function q_jenjang_pendidikan(){
		return $this->db->query("select * from sc_mst.jenjang_pendidikan order by kdjenjang_pendidikan asc");
	}
	
	function q_cekjenjang_pendidikan($kdjenjang_pendidikan){
		return $this->db->query("select * from sc_mst.jenjang_pendidikan where trim(kdjenjang_pendidikan)='$kdjenjang_pendidikan'");
	}
	
}	