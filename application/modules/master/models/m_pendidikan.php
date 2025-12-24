<?php
class M_pendidikan extends CI_Model{
	function q_pendidikan(){
		return $this->db->query("select * from sc_mst.pendidikan order by kdpendidikan asc");
	}
	
	function q_cekpendidikan($kdpendidikan){
		return $this->db->query("select * from sc_mst.pendidikan where trim(kdpendidikan)='$kdpendidikan'");
	}
	
}	