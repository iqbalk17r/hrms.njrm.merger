<?php
class M_bonus extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								order by nmlengkap asc");
		
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where  a.nik='$nik'
								order by nmlengkap asc");
		
	}
	

	

	
	function list_detail($nik,$nodok){
		return $this->db->query("select a.*,to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1,b.uraian from sc_tmp.payroll_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nik='$nik' and a.nodok='$nodok'");
	
	}
	
	function cek_gajibonus($nik){
	
		return $this->db->query("select * from sc_trx.bonus_nonreg where  nik='$nik'");
	}
	
	function gajibonus($nik){
	
		return $this->db->query("select nominal from sc_trx.bonus_nonreg where no_urut='14' and nik='$nik'");
	}
	
	function q_gajipokok($nik){
		return $this->db->query("select gajipokok from sc_mst.karyawan where nik='$nik'");
		
	}
	
	function koreksi($nik){
		return $this->db->query("select nominal from sc_trx.bonus_nonreg where no_urut='5' and nik='$nik'");
	
	}
	
	function insentif_pro($nik){
		return $this->db->query("select nominal from sc_trx.bonus_nonreg where no_urut='12' and nik='$nik'");
	
	}
	
	function thr($nik){
		return $this->db->query("select nominal from sc_trx.bonus_nonreg where no_urut='13' and nik='$nik'");
	
	}
	
	function gajitetap($nik){
		return $this->db->query("select gajitetap from sc_mst.karyawan where nik='$nik'");
	}
	
}	