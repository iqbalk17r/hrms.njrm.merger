<?php
class M_jenisbbm extends CI_Model{
	function q_jenisbbm(){
		return $this->db->query("select * from sc_mst.jenisbbm order by kdjenisbbm asc");
	}
	
	function q_cekjenisbbm($kdjenisbbm){
		return $this->db->query("select * from sc_mst.jenisbbm where trim(kdjenisbbm)='$kdjenisbbm'");
	}
	
}	
