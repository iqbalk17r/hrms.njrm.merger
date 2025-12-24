<?php
class M_bahasa extends CI_Model{
	function q_bahasa(){
		return $this->db->query("select * from sc_mst.bahasa order by kdbahasa asc");
	}
	
	function q_cekbahasa($kdbahasa){
		return $this->db->query("select * from sc_mst.bahasa where trim(kdbahasa)='$kdbahasa'");
	}
	
	function q_cekdel_bahasa($kdbahasa){
		return $this->db->query("select * from sc_trx.kompetensi_bahasa where trim(kdbahasa)='$kdbahasa'")->row_array();
	}
	
}	