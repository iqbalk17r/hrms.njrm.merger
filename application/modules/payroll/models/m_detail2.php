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
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_upah,0),'999G999G999G990D00') as total_upah1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.payroll_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok='$nodok'
								");
	
	
	}
	
	function list_master_pph($nodok){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.gaji_netto,0),'999G999G999G990D00') as gaji_netto1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.p21_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok='$nodok'
								");
	
	
	}
	
	function list_detail($nik,$nodok){
		return $this->db->query("select a.*,to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1,b.uraian from sc_tmp.payroll_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nik='$nik' and a.nodok='$nodok'");
	
	}
	
	function list_detail_pph($nik,$nodok){
		return $this->db->query("select a.*,to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1,b.uraian from sc_tmp.p21_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nik='$nik' and a.nodok='$nodok'");
	
	}
	
	function list_rekap($nodok){
		return $this->db->query("select *,to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1,
								to_char(round(total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.payroll_rekap where nodok='$nodok'");
	
	}
	
	function list_rekap_pph($nodok){
		return $this->db->query("select *,to_char(round(total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.p21_rekap where nodok='$nodok'");
	
	}
	
	function q_absensi($nodok,$nik){
		return $this->db->query("select *,to_char(round(cuti_nominal,0),'999G999G999G990D00') as cuti_nominal1 from sc_tmp.cek_absen where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_shift($nodok,$nik){
		return $this->db->query("select *,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_tmp.tunjangan_shift where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_upah_borong($nodok,$nik){
		return $this->db->query("select *,to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1 from sc_tmp.cek_borong where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_lembur($nodok,$nik){
		return $this->db->query("select *,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_tmp.cek_lembur where nodok='$nodok' and nik='$nik'
								");
	
	}
	
}	