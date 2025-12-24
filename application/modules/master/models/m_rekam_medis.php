<?php
class M_rekam_medis extends CI_Model{
	function q_rekam_medis(){
		return $this->db->query("select a.*,b.uraian from sc_mst.rekam_medis a
								left outer join sc_mst.trxtype b on a.kdtrx=b.kdtrx and b.jenistrx='REKAM MEDIS'
								order by a.kdrekam_medis asc");
	}
	
	function q_cekrekam_medis($kdrekam_medis){
		return $this->db->query("select * from sc_mst.rekam_medis where trim(kdrekam_medis)='$kdrekam_medis'");
	}
	
	function q_trxtype(){
		return $this->db->query("select * from sc_mst.trxtype
								where jenistrx='REKAM MEDIS' ");
	}
	
}	