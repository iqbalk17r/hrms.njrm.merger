<?php
class M_keluarga extends CI_Model{
	function q_keluarga(){
		return $this->db->query("select * from sc_mst.keluarga order by kdkeluarga asc");
	}
	
	function q_cekkeluarga($kdkeluarga){
		return $this->db->query("select * from sc_mst.keluarga where trim(kdkeluarga)='$kdkeluarga'");
	}
	
}	