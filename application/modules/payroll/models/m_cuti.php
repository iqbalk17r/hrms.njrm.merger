<?php
class M_cuti extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
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
	
	
	function list_karyawan_index(){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								");
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	function q_cuti_mst(){
			return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_mulai,'dd-mm-yyyy')as tgl_mulai1,
									to_char(a.tgl_selesai,'dd-mm-yyyy')as tgl_selesai1,
									a.status, 
									case
									when a.status='A' then 'PERLU PERSETUJUAN'
									when a.status='C' then 'DIBATALKAN'
									when a.status='I' then 'INPUT'
									when a.status='F' then 'FINAL'
									when a.status='P' then 'DISETUJUI/PRINT'
									when a.status='D' then 'DIHAPUS'
									end as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,i.nmlengkap as nmatasan1,g.nmijin_khusus,
									j.nmlengkap as nmpelimpahan
									from sc_trx.cuti_karyawan a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept
									left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
									left outer join sc_mst.karyawan i on a.nmatasan=i.nik
									left outer join sc_mst.karyawan j on a.pelimpahan=j.nik
									left outer join sc_mst.ijin_khusus g on a.kdijin_khusus=g.kdijin_khusus
									order by a.nodok
								");
	}
	
	function q_cuti_mst_detail($nik,$tgl){
			return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_mulai,'dd-mm-yyyy')as tgl_mulai1,
									to_char(a.tgl_selesai,'dd-mm-yyyy')as tgl_selesai1,
									a.status, 
									case
									when a.status='A' then 'PERLU PERSETUJUAN'
									when a.status='C' then 'DIBATALKAN'
									when a.status='I' then 'INPUT'
									when a.status='F' then 'FINAL'
									when a.status='P' then 'DISETUJUI/PRINT'
									when a.status='D' then 'DIHAPUS'
									end as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,i.nmlengkap as nmatasan1,g.nmijin_khusus,
									j.nmlengkap as nmpelimpahan
									from sc_trx.cuti_karyawan a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept
									left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
									left outer join sc_mst.karyawan i on a.nmatasan=i.nik
									left outer join sc_mst.karyawan j on a.pelimpahan=j.nik
									left outer join sc_mst.ijin_khusus g on a.kdijin_khusus=g.kdijin_khusus
									where a.nik='$nik' and a.status='P' and to_char(tgl_mulai,'MMYYYY')='$tgl'
									order by a.nodok desc
								");
	}
	
	function q_cuti_dtl($nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmborong,d.nmsub_borong,d.metrix,d.satuan,d.tarif_satuan,e.total_target
								from sc_trx.cuti_dtl a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.borong c on a.kdborong=c.kdborong
								left outer join sc_mst.sub_borong d on a.kdsub_borong=d.kdsub_borong 
								left outer join sc_mst.target_borong e on a.kdsub_borong=e.kdsub_borong 
								where a.nodok='$nodok'
								order by a.no_urut desc
								");
	}
	
	function q_cuti_dtl_2($nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmborong,d.nmsub_borong,d.metrix,d.satuan,d.tarif_satuan,e.total_target
								from sc_tmp.cuti_dtl a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.borong c on a.kdborong=c.kdborong
								left outer join sc_mst.sub_borong d on a.kdsub_borong=d.kdsub_borong 
								left outer join sc_mst.target_borong e on a.kdsub_borong=e.kdsub_borong 
								where a.nodok='$nodok'
								order by a.no_urut desc
								");
	}
	
	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.cuti_mst set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_app($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.cuti_mst set status='F',update_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_final($nodok){
		return $this->db->query("update sc_tmp.cuti_mst set status='F' where nodok='$nodok'");
	}
	
	function total_upah($nodok){
		return $this->db->query("select sum(cuti) as total_upah from sc_trx.cuti_dtl
								where nodok='$nodok'
								");
	}
	
	function total_upah_mst($nodok){
		return $this->db->query("select sum(cuti) as total_upah from sc_tmp.cuti_dtl
								where nodok='$nodok'
								");
	}
	
	function cek_detail($nodok){
		return $this->db->query("select * from sc_tmp.cuti_dtl where nodok='$nodok'");
	}
	
	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.cuti_mst where nodok='$nodok' and status='P'");
	}
	
	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.cuti_mst where nodok='$nodok' and status='C'");
	}
	function beri_no_urut($nodok){
		
		return $this->db->query("select max(no_urut) as nomor from sc_tmp.cuti_dtl where nodok='$nodok'");
		
	}
	
	function q_transready($nik,$tgl){
		return $this->db->query("select * from 
								(select b.nmlengkap, 
								case 
								when shiftke='1' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
								when shiftke='3' and jam_masuk_absen>=jam_masuk_min  then 'TIDAK TERLAMBAT'
								when shiftke='1' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='2' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='3' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='2' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
								when jam_masuk_absen is null and jam_pulang_absen is null then 'TIDAK MASUK KERJA'
								when shiftke='2' and jam_masuk=jam_pulang then 'TIDAK ABSEN MASUK/KELUAR'
								else 'TIDAK ABSEN MASUK/KELUAR'
								end as ketsts,
								a.* from sc_trx.transready a
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								where a.nik='$nik' and to_char(a.tgl,'MMYYYY')='$tgl') as t1
								where ketsts='TIDAK MASUK KERJA'
								order by tgl asc   
								");
	
	
	}
	
}	