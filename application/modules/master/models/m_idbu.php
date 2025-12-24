<?php
class M_idbu extends CI_Model{
	function q_idbu() {
		return $this->db->query("
            SELECT * 
            FROM sc_mst.idbu 
            ORDER BY idbu
        ");
	}
	
	
	function q_cekidbu($idbu){
		return $this->db->query("select * from sc_mst.idbu where trim(kddept)='$idbu'");
	}
	
}



