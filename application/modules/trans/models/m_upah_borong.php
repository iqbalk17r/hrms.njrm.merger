<?php
class M_upah_borong extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where tjborong='t'
								order by nmlengkap asc");
		
	}
	
	function list_borong(){
		return $this->db->query("select * from sc_mst.borong 
								order by nmborong asc");
		
	}
	
	function list_sub_borong(){
		return $this->db->query("select * from sc_mst.sub_borong 
								order by nmsub_borong asc");
		
	}
	
	function list_target_borong(){
		return $this->db->query("select * from sc_mst.target_borong 
								order by no_urut asc");
		
	}
	
	
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								where a.nik='$nik'
								");
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	function q_upah_borong_mst($tgl,$status){
			return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
									a.status, 
									case
									when a.status='A' then 'PERLU PERSETUJUAN'
									when a.status='C' then 'DIBATALKAN'
									when a.status='I' then 'INPUT'
									when a.status='F' then 'FINAL'
									when a.status='P' then 'DISETUJUI/PRINT'
									when a.status='D' then 'DIHAPUS'
									end as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,i.nmlengkap as nmatasan1
									from sc_trx.upah_borong_mst a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept
									left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
									left outer join sc_mst.karyawan i on a.nmatasan=i.nik
									where to_char(a.tgl_dok,'mmYYYY')='$tgl' and a.status $status
									order by a.nodok desc
								");
	}
	
	function q_upah_borong_mst_detail($nodok,$nik){
			return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
									a.status, 
									case
									when a.status='A' then 'PERLU PERSETUJUAN'
									when a.status='C' then 'DIBATALKAN'
									when a.status='I' then 'INPUT'
									when a.status='F' then 'FINAL'
									when a.status='P' then 'DISETUJUI/PRINT'
									when a.status='D' then 'DIHAPUS'
									end as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,i.nmlengkap as nmatasan1
									from sc_tmp.upah_borong_mst a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept
									left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
									left outer join sc_mst.karyawan i on a.nmatasan=i.nik
									where nodok='$nodok' and a.nik='$nik'
									order by a.nodok desc
								");
	}
	
	function q_upah_borong_dtl($nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmborong,d.nmsub_borong,d.metrix,d.satuan,d.tarif_satuan,e.total_target
								from sc_trx.upah_borong_dtl a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.borong c on a.kdborong=c.kdborong
								left outer join sc_mst.sub_borong d on a.kdsub_borong=d.kdsub_borong 
								left outer join sc_mst.target_borong e on a.kdsub_borong=e.kdsub_borong 
								where a.nodok='$nodok'
								order by a.no_urut desc
								");
	}
	
	function q_upah_borong_dtl_2($nodok,$nik){
		return $this->db->query("select a.*,b.nmlengkap,c.nmborong,d.nmsub_borong,d.metrix,d.satuan,d.tarif_satuan,e.total_target
								from sc_tmp.upah_borong_dtl a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.borong c on a.kdborong=c.kdborong
								left outer join sc_mst.sub_borong d on a.kdsub_borong=d.kdsub_borong 
								left outer join sc_mst.target_borong e on a.kdsub_borong=e.kdsub_borong 
								where a.nodok='$nodok' and a.nik='$nik'
								order by a.no_urut desc
								");
	}
	
	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.upah_borong_mst set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_app($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.upah_borong_mst set status='F',update_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_final($nodok){
		return $this->db->query("update sc_tmp.upah_borong_mst set status='F' where nodok='$nodok'");
	}
	
	function total_upah($nodok){
		return $this->db->query("select sum(upah_borong) as total_upah from sc_trx.upah_borong_dtl
								where nodok='$nodok'
								");
	}
	
	function total_upah_mst($nodok,$nik){
		return $this->db->query("select sum(upah_borong) as total_upah from sc_tmp.upah_borong_dtl
								where nodok='$nodok' and nik='$nik'
								");
	}
	
	function cek_detail($nodok,$nik){
		return $this->db->query("select * from sc_tmp.upah_borong_dtl where nodok='$nodok' and nik='$nik'");
	}
	
	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.upah_borong_mst where nodok='$nodok' and status='P'");
	}
	
	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.upah_borong_mst where nodok='$nodok' and status='C'");
	}
	
	function cek_dokumen3($nodok){
		return $this->db->query("select tgl_dok from sc_trx.upah_borong_mst where nodok='$nodok'");
	}
	
	function beri_no_urut($nodok){
		
		return $this->db->query("select max(no_urut) as nomor from sc_tmp.upah_borong_dtl where nodok='$nodok'");
		
	}
	
	function cek_tmp($nodok,$nik){
		return $this->db->query("select * from sc_tmp.upah_borong_mst where nodok='$nodok' and nik='$nik'");
	
	}
	
	function tgl_closing(){
		return $this->db->query("select cast(value1 as date) from sc_mst.option where kdoption='TGLCLS' and trim(nmoption)='TANGGAL CLOSING'");
	}
}	