<?php
class M_kenaikan_grade extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_grade(){
		return $this->db->query("select * from sc_mst.jobgrade 
								order by nmgrade asc");	
	}
	
	function list_group_pg(){
		return $this->db->query("select * from sc_mst.group_penggajian 
								order by nmgroup_pg asc");	
	}
	
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	
	function q_kenaikan_grade($nik){
		return $this->db->query("select to_char(a.tgl_sk,'dd-mm-yyyy')as tgl_sk1,a.status, 
								case
								when status='A' then 'PERLU PERSETUJUAN'
								when status='C' then 'DIBATALKAN'
								when status='I' then 'INPUT'
								when status='F' then 'FINAL'
								when status='P' then 'DISETUJUI'
								end as status1,
								a.*,b.nmgrade,c.nmgroup_pg from sc_trx.kenaikan_grade a
								left outer join sc_mst.jobgrade b on a.kdgrade=b.kdgrade
								left outer join sc_mst.group_penggajian c on a.kdgroup_pg=c.kdgroup_pg
								where a.nik='$nik' 	
								order by a.nodok asc");
	}
	
	
	function q_kenaikan_grade_edit($nik,$nodok){
		return $this->db->query("select to_char(a.tgl_sk,'dd-mm-yyyy')as tgl_sk1,a.status, 
								case
								when status='A' then 'DISETUJUI'
								when status='C' then 'DIBATALKAN'
								when status='I' then 'INPUT'
								end as status1,
								a.*,b.nmgrade,c.nmgroup_pg from sc_trx.kenaikan_grade a
								left outer join sc_mst.jobgrade b on a.kdgrade=b.kdgrade
								left outer join sc_mst.group_penggajian c on a.kdgroup_pg=c.kdgroup_pg
								where a.nik='$nik' and a.nodok='$nodok' 
								order by a.nodok asc");
	}
	
	function tr_cancel($nodok){
		return $this->db->query("update sc_trx.kenaikan_grade set status='C' where nodok='$nodok'");
	}
	
	function tr_app($nodok){
		return $this->db->query("update sc_trx.kenaikan_grade set status='F' where nodok='$nodok'");
	}
}	