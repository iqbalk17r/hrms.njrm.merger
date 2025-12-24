<?php
class M_kepegawaian extends CI_Model{
	function q_kepegawaian(){
		return $this->db->query("select * from sc_mst.status_kepegawaian order by kdkepegawaian asc");
	}
	
	function q_cekkepegawaian($kdkepegawaian){
		return $this->db->query("select * from sc_mst.status_kepegawaian where trim(kdkepegawaian)='$kdkepegawaian'");
	}
	
}	