<?php
class M_kompetensi_bahasa extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_bahasa(){
		return $this->db->query("select * from sc_mst.bahasa");
	}
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	function q_cek_bahasa($nik,$kdbahasa){
		return $this->db->query("select * from sc_trx.kompetensi_bahasa where trim(nik)='$nik' and trim(kdbahasa)='$kdbahasa'");
	}
	
	function q_kompetensi_bahasa($nik){
		return $this->db->query("select a.*,b.nmbahasa,c.nmlengkap from sc_trx.kompetensi_bahasa a
								left outer join sc_mst.bahasa b on a.kdbahasa=b.kdbahasa
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' 	
								order by b.nmbahasa asc");
	}
	
	
	function q_kompetensi_bahasa_edit($nik,$no_urut){
		return $this->db->query("select a.*,b.nmbahasa,c.nmlengkap from sc_trx.kompetensi_bahasa a
								left outer join sc_mst.bahasa b on a.kdbahasa=b.kdbahasa
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.no_urut='$no_urut'	
								order by b.nmbahasa asc");
	}
}	