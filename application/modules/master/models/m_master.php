<?php
class M_master extends CI_Model{
	

		
	function q_list_department(){
		return $this->db->query("select * from sc_mst.departmen");
	}	
}
