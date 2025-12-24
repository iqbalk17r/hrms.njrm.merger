<?php
class M_backupdb extends CI_Model{
	function q_backupdb(){
		return $this->db->query("select * from sc_mst.setupbackup");
	}
	
	function q_trxerror($paramtrxerror){
		return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
	}
	
	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
	}
	
}	