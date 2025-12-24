<?php
class M_nikah extends CI_Model{
	function q_nikah(){
		return $this->db->query("select * from sc_mst.status_nikah order by kdnikah asc");
	}
	
	function q_ceknikah($kdnikah){
		return $this->db->query("select * from sc_mst.status_nikah where trim(kdnikah)='$kdnikah'");
	}
	
}	