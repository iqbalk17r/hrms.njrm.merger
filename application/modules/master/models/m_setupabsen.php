<?php
/*
	@author : Fiky
	02-02-2016
*/
//error_reporting(0);
class M_setupabsen extends CI_Model{
	function q_template_jadwal(){
		return $this->db->query("select * from sc_mst.setup_grjadwal order by kd_opt asc");
	}	
	
	function q_jam_sf1(){
		return $this->db->query("select * from sc_mst.jam_kerja where shiftke='1' order by kdjam_kerja asc");
	}

	function q_jam_sf2(){
		return $this->db->query("select * from sc_mst.jam_kerja where shiftke='2' order by kdjam_kerja asc");
	}
	
	function q_jam_sf3(){
		return $this->db->query("select * from sc_mst.jam_kerja where shiftke='3' order by kdjam_kerja asc");
	}
	
	function q_template_jadwal_fetch($kd_opt){
		return $this->db->query("select * from sc_mst.setup_grjadwal where kd_opt='$kd_opt' order by kd_opt asc");
	}	
		
}	