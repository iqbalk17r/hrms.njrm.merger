<?php
class M_kompetensi extends CI_Model{
	function q_kompetensi(){
		return $this->db->query("select * from sc_mst.kompetensi order by kdkom asc");
	}
	
	function q_cekkompetensi($kdkom){
		return $this->db->query("select * from sc_mst.kompetensi where trim(kdkom)='$kdkom'");
	}
	
	function q_jeniskom(){
		return $this->db->query("select * from sc_mst.trxtype 
								where jenistrx='JENIS KOMPETENSI'");
	}
	
	function q_ind_prilaku(){
		return $this->db->query("select * from sc_mst.ind_prilaku");
	}
	
	function dtl_indperilaku($lvl_indikator){
		return $this->db->query("select * from sc_mst.ind_prilaku where lvl_indikator='$lvl_indikator'");
	}
	
	function q_dk_jabatan(){
		return $this->db->query("select a.*,b.nmjabatan,c.nmkom from sc_mst.dk_jabatan a
								left outer join sc_mst.jabatan b on a.kdjabatan=b.kdjabatan 
								left outer join sc_mst.kompetensi c on a.kdkom=c.kdkom
								order by no_dk asc");
	}
	
	function q_cek_dk_jabatan($no_urut){
		return $this->db->query("select a.*,b.nmjabatan,c.nmkom from sc_mst.dk_jabatan a
								left outer join sc_mst.jabatan b on a.kdjabatan=b.kdjabatan 
								left outer join sc_mst.kompetensi c on a.kdkom=c.kdkom
								where no_urut='$no_urut'");
	}
}