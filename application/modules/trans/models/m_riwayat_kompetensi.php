<?php
class M_riwayat_kompetensi extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_kompetensi(){
		return $this->db->query("select a.*,b.uraian from sc_mst.kompetensi a
								left outer join sc_mst.ind_prilaku b on a.lvl_indikator=b.lvl_indikator 
								order by a.nmkom asc");	
	}
	
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_riwayat_kompetensi($nik){
		return $this->db->query("select a.*,b.nmkom,c.uraian from sc_trx.riwayat_kompetensi a
								left outer join sc_mst.kompetensi b on a.kdkom=b.kdkom and a.lvl_indikator=b.lvl_indikator
								left outer join sc_mst.ind_prilaku c on a.lvl_indikator=c.lvl_indikator
								where a.nik='$nik' 	
								order by a.no_urut asc");
	}
	
	
	function q_riwayat_kompetensi_edit($nik,$kdkom){
		return $this->db->query("select a.*,b.nmkom,c.uraian from sc_trx.riwayat_kompetensi a
								left outer join sc_mst.kompetensi b on a.kdkom=b.kdkom and a.lvl_indikator=b.lvl_indikator
								left outer join sc_mst.ind_prilaku c on a.lvl_indikator=c.lvl_indikator
								where a.nik='$nik' and a.kdkom='$kdkom' 
								order by a.no_urut asc");
	}
}	