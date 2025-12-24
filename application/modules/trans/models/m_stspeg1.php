<?php
class M_stspeg extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(status),'')!='KO' order by nmlengkap asc");
		
	}
	
	function list_kepegawaian(){
		return $this->db->query("select * from sc_mst.status_kepegawaian");
	}
	
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								where trim(a.nik)='$nik'");
	}
	
	
	function q_stspeg($nik){
		return $this->db->query("select a.*,b.nmkepegawaian,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
								to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' 	
								order by b.nmkepegawaian asc");
	}
	
	
	function q_stspeg_edit($nik,$nodok){
		return $this->db->query("sselect a.*,b.nmkepegawaian,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
								to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.nodok='$nodok'	
								order by b.nmkepegawaian asc");
	}
}	