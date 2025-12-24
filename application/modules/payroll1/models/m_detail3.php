<?php
class M_detail extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.grade_golongan is not null
								order by nmlengkap asc");
		
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.grade_golongan is not null and nik='$nik'
								order by nmlengkap asc");
		
	}
	
	function list_master_old($nik){
		return $this->db->query("select * from sc_tmp.payroll_master
								where nik='$nik'
								");
	
	
	}
	
	function list_master($nodok){
		return $this->db->query("select b.nmlengkap,a.* from sc_tmp.payroll_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok='$nodok'
								");
	
	
	}
	
	function list_detail($nik){
		return $this->db->query("select * from sc_tmp.payroll_detail where nik='$nik'");
	
	}
	
	function list_rekap($nodok){
		return $this->db->query("select * from sc_tmp.payroll_rekap where nodok='$nodok'");
	
	}
	
	function q_absensi($nodok,$nik){
		return $this->db->query("select * from sc_tmp.potongan_absen where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_shift($nodok,$nik){
		return $this->db->query("select * from sc_tmp.tunjangan_shift where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_upah_borong($nodok,$nik){
		return $this->db->query("select * from sc_tmp.payroll_borong where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_lembur($nodok,$nik){
		return $this->db->query("select * from sc_tmp.detail_lembur where nodok='$nodok' and nik='$nik'
								");
	
	}
	
}	