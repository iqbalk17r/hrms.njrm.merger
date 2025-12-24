<?php
class M_bank extends CI_Model{
	function q_bank(){
		return $this->db->query("select * from sc_mst.bank order by kdbank asc");
	}
	
	function q_cekbank($kdbank){
		return $this->db->query("select * from sc_mst.bank where trim(kdbank)='$kdbank'");
	}
	
}	