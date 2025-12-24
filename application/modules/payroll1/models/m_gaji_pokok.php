<?php
class M_gaji_pokok extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.grade_golongan is not null
								order by nmlengkap asc");
		
	}
	
	function q_gaji_pokok($nik){
		return $this->db->query("select nik,nmlengkap,grade_golongan,gajipokok
								from sc_mst.karyawan 
								where nik='$nik'
								");
	
	
	}
	
	
	
}	