<?php
class M_riwayat_kesehatan extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_penyakit(){
		return $this->db->query("select * from sc_mst.penyakit");
	}
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_riwayat_kesehatan($nik){
		return $this->db->query("select a.*,kdpenyakit as nmpenyakit,c.nmlengkap from sc_trx.riwayat_kesehatan a
									left outer join sc_mst.karyawan c on a.nik=c.nik
									where a.nik='$nik' 	
									order by periode asc");
	}
	
	
	function q_riwayat_kesehatan_edit($nik,$no_urut){
		return $this->db->query("select a.*,a.kdpenyakit as nmpenyakit,c.nmlengkap from sc_trx.riwayat_kesehatan a
									left outer join sc_mst.penyakit b on a.kdpenyakit=b.kdpenyakit
									left outer join sc_mst.karyawan c on a.nik=c.nik
									where a.nik='$nik' and no_urut='$no_urut'	
									order by a.periode asc");
	}
}	