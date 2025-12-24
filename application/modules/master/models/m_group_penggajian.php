<?php
class M_group_penggajian extends CI_Model{
	function q_group_penggajian(){
		return $this->db->query("select * from sc_mst.group_penggajian order by kdgroup_pg asc");
	}
	
	function q_cekpg($kdgroup_pg){
		return $this->db->query("select * from sc_mst.group_penggajian where trim(kdgroup_pg)='$kdgroup_pg'");
	}
}