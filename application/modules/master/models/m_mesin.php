<?php
class M_mesin extends CI_Model{
	function q_mesin(){
		return $this->db->query("select * from sc_mst.mesin order by kdmesin asc");
	}
	
	function q_cekmesin($kdmesin){
		return $this->db->query("select * from sc_mst.mesin where trim(kdmesin)='$kdmesin'");
	}
	
	function q_cekdel_mesin($kdmesin){
		return $this->db->query("select * from sc_mst.regu where trim(kdmesin)='$kdmesin'");
	
	}
	
}	