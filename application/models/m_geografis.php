<?php
/*
	author : Junis P
	10-11-2014
*/
class M_geografis extends CI_Model{
   
	public function q_kota(){
		return $this->db->query("select * from sc_mst.wl2city order by citydesc");					
	}
	
	public function q_gudang(){
		return $this->db->query("select * from sc_mst.gudang");					
	}
	
	public function q_wilayah(){
		return $this->db->query("select * from sc_mst.carea");					
	}
	public function q_provinsi(){
		return $this->db->query("select * from sc_mst.wl1province");
	}
	public function q_kabupaten(){
		return $this->db->query("select * from sc_mst.wl2city");
	}
	public function q_kecamatan(){
		return $this->db->query("select * from sc_mst.wl3district");
	}
	public function q_desa(){
		return $this->db->query("select * from sc_mst.wl4region");
	}
	
	
}