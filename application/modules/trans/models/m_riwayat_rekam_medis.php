<?php
class M_riwayat_rekam_medis extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_rekam_medis(){
		return $this->db->query("select * from sc_mst.rekam_medis");
	}
	function list_tipe_medis(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='REKAM MEDIS'");
	}
	function list_level_medis(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='LEVEL REKAM MEDIS'");
	}
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_riwayat_rekam_medis($nik){
		return $this->db->query("select to_char(a.tgl_tes,'dd-mm-yyyy') as tgl_tes1, 
								a.*,b.nmrekam_medis,c.nmlengkap,d.uraian,e.uraian as uraian2 from sc_trx.riwayat_rekam_medis a
								left outer join sc_mst.rekam_medis b on a.kdrekam_medis=b.kdrekam_medis
								left outer join sc_mst.karyawan c on a.nik=c.nik
								left outer join sc_mst.trxtype d on a.kdtipe=d.kdtrx and d.jenistrx='REKAM MEDIS'
								left outer join sc_mst.trxtype e on a.kdlevel=e.kdtrx and e.jenistrx='LEVEL REKAM MEDIS'
								where a.nik='$nik' 	
								order by b.nmrekam_medis asc");
	}
	
	
	function q_riwayat_rekam_medis_edit($nik,$no_urut){
		return $this->db->query("select to_char(a.tgl_tes,'dd-mm-yyyy') as tgl_tes1, 
								a.*,b.nmrekam_medis,c.nmlengkap,d.uraian,e.uraian as uraian2 from sc_trx.riwayat_rekam_medis a
								left outer join sc_mst.rekam_medis b on a.kdrekam_medis=b.kdrekam_medis
								left outer join sc_mst.karyawan c on a.nik=c.nik
								left outer join sc_mst.trxtype d on a.kdtipe=d.kdtrx and d.jenistrx='REKAM MEDIS'
								left outer join sc_mst.trxtype e on a.kdlevel=e.kdtrx and e.jenistrx=LEVEL REKAM MEDIS'
								where a.nik='$nik' and a.no_urut='$no_urut'
								order by b.nmrekam_medis asc");
	}
}	