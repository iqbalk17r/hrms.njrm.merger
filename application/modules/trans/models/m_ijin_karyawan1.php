<?php
class M_ijin_karyawan extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept where a.tglkeluarkerja is null
								order by nmlengkap asc");
		
	}
	
	function list_ijin(){
		return $this->db->query("select * from sc_mst.ijin_absensi 
								order by nmijin_absensi asc");
		
	}
	function list_ijin_khusus(){
		return $this->db->query("select * from sc_mst.ijin_absensi 
								WHERE kdijin_absensi not in ('KD','IM','AL','AB')
								order by nmijin_absensi asc");
		
	}
	
	
	
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.nik='$nik' and f.tglkeluarkerja is null
								");
	}
	
	
	function q_ijin_karyawan($tgl,$nikatasan,$status){
		return $this->db->query("select * from (select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
									a.status, 
									case
									when a.status='A' then 'PERLU PERSETUJUAN'
									when a.status='C' then 'DIBATALKAN'
									when a.status='I' then 'INPUT'
									when a.status='D' then 'DIHAPUS'
									when a.status='P' then 'DISETUJUI/PRINT'
									end as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_absensi,h.nmlengkap as nmatasan1,case when type_ijin='PB' then 'PRIBADI' when type_ijin='DN' then 'DINAS' end as kategori from sc_trx.ijin_karyawan a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept 
									left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
									left outer join sc_mst.ijin_absensi g on a.kdijin_absensi=g.kdijin_absensi
									left outer join sc_mst.karyawan h on a.nmatasan=h.nik
								where to_char(a.tgl_kerja,'mmYYYY')='$tgl' and a.status $status
								order by a.nodok desc )as x1
								$nikatasan");
	}
	
	
	function q_ijin_karyawan_dtl($nodok){
		return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
								to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
								a.status, 
								case
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='D' then 'DIHAPUS'
								when a.status='P' then 'DISETUJUI/PRINT'
								end as status1,
								a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_absensi,h.nmlengkap as nmatasan1 from sc_trx.ijin_karyawan a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on a.kddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
								left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
								left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan  and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
								left outer join sc_mst.ijin_absensi g on a.kdijin_absensi=g.kdijin_absensi
								left outer join sc_mst.karyawan h on a.nmatasan=h.nik
								where a.nodok='$nodok'
								order by a.nodok desc");
	}
	
	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.ijin_karyawan set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_app($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.ijin_karyawan set status='P',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nodok='$nodok' and status='P'");
	}
	
	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nodok='$nodok' and status='C'");
	}
	
	function cek_double($nik,$tgl_kerja){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nik='$nik' and tgl_kerja='$tgl_kerja' and (status='P' or status='A')");
	}
}	