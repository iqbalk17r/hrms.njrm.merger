<?php
class M_penyakit extends CI_Model{
	function q_penyakit(){
		return $this->db->query("select * from sc_mst.penyakit order by kdpenyakit asc");
	}
	
	function q_cekpenyakit($kdpenyakit){
		return $this->db->query("select * from sc_mst.penyakit where trim(kdpenyakit)='$kdpenyakit'");
	}
	
}	