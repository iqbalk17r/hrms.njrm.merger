<?php
class M_ijin_khusus extends CI_Model{
	function q_ijin_khusus(){
		return $this->db->query("select * from sc_mst.ijin_khusus order by kdijin_khusus asc");
	}
	
	function q_cekijin_khusus($kdijin_khusus){
		return $this->db->query("select * from sc_mst.ijin_khusus where trim(kdijin_khusus)='$kdijin_khusus'");
	}

}	