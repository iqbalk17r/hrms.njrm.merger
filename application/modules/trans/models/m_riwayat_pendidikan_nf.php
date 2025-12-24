<?php
class M_riwayat_pendidikan_nf extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_keahlian(){
		return $this->db->query("select * from sc_mst.keahlian");
	}
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_riwayat_pendidikan_nf($nik){
		return $this->db->query("select to_char(a.tahun_masuk,'dd-mm-yyyy')as tahun_masuk1,
								to_char(a.tahun_keluar,'dd-mm-yyyy')as tahun_keluar1,
								a.*,b.nmkeahlian,c.nmlengkap from sc_trx.riwayat_pendidikan_nf a
								left outer join sc_mst.keahlian b on a.kdkeahlian=b.kdkeahlian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' 	
								order by b.nmkeahlian asc");
	}
	
	
	function q_riwayat_pendidikan_nf_edit($nik,$no_urut){
		return $this->db->query("select to_char(a.tahun_masuk,'dd-mm-yyyy')as tahun_masuk1,
								to_char(a.tahun_keluar,'dd-mm-yyyy')as tahun_keluar1, 
								a.*,b.nmkeahlian,c.nmlengkap from sc_trx.riwayat_pendidikan_nf a
								left outer join sc_mst.keahlian b on a.kdkeahlian=b.kdkeahlian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.no_urut='$no_urut'	
								order by b.nmkeahlian asc");
	}
}	