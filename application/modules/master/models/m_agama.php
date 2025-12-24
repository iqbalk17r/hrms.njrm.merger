<?php
class M_agama extends CI_Model{
	function q_agama(){
		return $this->db->query("select * from sc_mst.agama order by kdagama asc");
	}
	
	function q_cekagama($kdagama){
		return $this->db->query("select * from sc_mst.agama where trim(kdagama)='$kdagama'");
	}
	
}	