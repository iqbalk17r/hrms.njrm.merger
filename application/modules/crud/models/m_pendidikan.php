<?php
class M_pendidikan extends CI_Model{

	//function q_pegawai($pegawai){  //klo ga ada inputan ga usah di isi :)
	function q_pendidikan($kd){
		if (!empty($kd)){
			return $this->db->query("select a.kdpendidikan, a.jurusan, a.keterangan, a.editby, a.tgledit, a.nilai, a.status, b.nip, b.nmlengkap, a.nmsekolah, a.kota, a.jurusan, a.periodeaw, a.periodeak, a.nilai from sc_hrd.pendidikan a
									left outer join sc_hrd.pegawai b on b.nip=a.nip where a.kdpendidikan='$kd'
									group by a.kdpendidikan, a.jurusan, a.keterangan, a.editby, a.tgledit, a.nilai, a.status, b.nip, b.nmlengkap, a.nmsekolah, a.kota, a.jurusan, a.periodeaw, a.periodeak, a.nilai
									order by a.kdpendidikan");
		}
		else {
			return $this->db->query("select a.kdpendidikan, a.jurusan, a.keterangan, a.editby, a.tgledit, a.nilai, a.status, b.nip, b.nmlengkap, a.nmsekolah, a.kota, a.jurusan, a.periodeaw, a.periodeak, a.nilai from sc_hrd.pendidikan a
									left outer join sc_hrd.pegawai b on b.nip=a.nip 
									group by a.kdpendidikan, a.jurusan, a.keterangan, a.editby, a.tgledit, a.nilai, a.status, b.nip, b.nmlengkap, a.nmsekolah, a.kota, a.jurusan, a.periodeaw, a.periodeak, a.nilai
									order by a.kdpendidikan");
		}
	}
	function save_pen($info_pen){
		$this->db->insert("sc_hrd.pendidikan",$info_pen);
	}
	//edit data pegawai
	function edit_pen($info_pen){
		$this->db->where("kdpendidikan",$info_pen['kdpendidikan']);
		$this->db->update("sc_hrd.pendidikan",$info_pen);
	}
	
	function delete_pen($kd){
		$this->db->where("kdpendidikan",$kd);
		$this->db->delete("sc_hrd.pendidikan");
	}
	
}
