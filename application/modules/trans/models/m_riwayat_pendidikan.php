<?php
class M_riwayat_pendidikan extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_pendidikan(){
		return $this->db->query("select * from sc_mst.pendidikan");
	}
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_riwayat_pendidikan($nik){
		return $this->db->query("select a.*,b.nmpendidikan,c.nmlengkap from sc_trx.riwayat_pendidikan a
								left outer join sc_mst.pendidikan b on a.kdpendidikan=b.kdpendidikan
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' 	
								order by b.nmpendidikan asc");
	}
	
	
	function q_riwayat_pendidikan_edit($nik,$no_urut){
		return $this->db->query("select a.*,b.nmpendidikan,c.nmlengkap from sc_trx.riwayat_pendidikan a
								left outer join sc_mst.pendidikan b on a.kdpendidikan=b.kdpendidikan
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.no_urut='$no_urut'	
								order by b.nmpendidikan asc");
	}
}	