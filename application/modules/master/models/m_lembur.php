<?php
class M_lembur extends CI_Model{
	function q_lembur(){
		return $this->db->query("select * from sc_mst.lembur order by kdlembur asc");
	}
	
	function q_ceklembur($kdlembur){
		return $this->db->query("select * from sc_mst.lembur where trim(kdlembur)='$kdlembur'");
	}

}	