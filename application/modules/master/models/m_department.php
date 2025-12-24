<?php
class M_department extends CI_Model{
	function q_department() {
		return $this->db->query("
            SELECT * 
            FROM sc_mst.departmen 
            ORDER BY kddept
        ");
	}
	
	function q_subdepartment($params = "") {
		return $this->db->query("
            SELECT a.*, b.nmdept 
            FROM sc_mst.subdepartmen a 
            LEFT OUTER JOIN sc_mst.departmen b ON a.kddept = b.kddept
            $params
            ORDER BY kdsubdept
        ");
	}
	
	function q_cekdepartment($kddept){
		return $this->db->query("select * from sc_mst.departmen where trim(kddept)='$kddept'");
	}
	
	function q_ceksubdepartment($kdsubdept){
		return $this->db->query("select * from sc_mst.subdepartmen where trim(kdsubdept)='$kdsubdept'");
	}
}



