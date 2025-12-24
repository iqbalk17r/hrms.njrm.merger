<?php
class M_gaji extends CI_Model{
	function q_gaji(){
		return $this->db->query("select * from sc_mst.gaji order by kdgrade asc");
	}
	
	function q_cekgaji($kdgrade,$periode){
		return $this->db->query("select * from sc_mst.gaji where trim(kdgrade)='$kdgrade' and trim(periode)='$periode'");
	}
	
	function q_jobgrade(){
		return $this->db->query("select * from sc_mst.jobgrade order by kdgrade asc");
	}
	
	function q_kodegaji(){
		return $this->db->query("select * from sc_mst.kodegaji order by kdgaji asc");
	
	}
	
	function q_cekkodegaji($kdgaji,$uraian){
		return $this->db->query("select * from sc_mst.kodegaji where trim(kdgaji)='$kdgaji' and trim(uraian)='$uraian'");
	}
	
	
}	