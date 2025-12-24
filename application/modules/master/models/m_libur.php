<?php
class M_libur extends CI_Model{
	function q_libur(){
		return $this->db->query("select * from sc_mst.libur order by tgl_libur asc");
	}
	
	function q_ceklibur($tgl_libur){
		return $this->db->query("select * from sc_mst.libur where tgl_libur='$tgl_libur'");
	}
	
}	