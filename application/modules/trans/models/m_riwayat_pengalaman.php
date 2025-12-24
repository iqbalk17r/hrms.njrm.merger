<?php
class M_riwayat_pengalaman extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_riwayat_pengalaman($nik){
		return $this->db->query("select to_char(a.tahun_masuk,'dd-mm-yyyy') as tahun_masuk1,
								to_char(a.tahun_keluar,'dd-mm-yyyy') as tahun_keluar1, 
								a.*,c.nmlengkap from sc_trx.riwayat_pengalaman a
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' 	
								order by a.tahun_masuk asc");
	}
	
	
	function q_riwayat_pengalaman_edit($nik,$no_urut){
		return $this->db->query("select to_char(a.tahun_masuk,'dd-mm-yyyy') as tahun_masuk1,
								to_char(a.tahun_keluar,'dd-mm-yyyy') as tahun_keluar1, 
								a.*,c.nmlengkap from sc_trx.riwayat_pengalaman a
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.no_urut='$no_urut'
								order by a.tahun_masuk asc");
	}
}	