<?php
class M_regu extends CI_Model{
	function q_regu(){
		return $this->db->query("select b.nmmesin,a.* from sc_mst.regu a 
								left outer join sc_mst.mesin b on a.kdmesin=b.kdmesin
								order by a.kdregu asc");
	}
	function q_karyawan_session($nama){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nama'");
	}
	
	function q_cekregu($kdregu){
		return $this->db->query("select * from sc_mst.regu where trim(kdregu)='$kdregu'");
	}
	
	function q_regu_opr(){
		return $this->db->query("select a.*,b.nmregu,c.nik,c.nmlengkap,d.nmdept from sc_mst.regu_opr a
								left outer join sc_mst.regu b on a.kdregu=b.kdregu
								left outer join sc_mst.karyawan c on a.nik=c.nik
								left outer join sc_mst.departmen d on c.bag_dept=d.kddept
								order by a.kdregu asc");
	}
	
	function q_regu_oprv($bag_dept){
		return $this->db->query("select a.*,b.nmregu,c.nik,c.nmlengkap,d.nmdept,c.bag_dept from sc_mst.regu_opr a
								left outer join sc_mst.regu b on a.kdregu=b.kdregu
								left outer join sc_mst.karyawan c on a.nik=c.nik
								left outer join sc_mst.departmen d on c.bag_dept=d.kddept
								$bag_dept
								order by a.kdregu asc");
	}
	
	function q_regu_opr_edit($id){
		return $this->db->query("select a.*,b.nmregu,c.nik,c.nmlengkap from sc_mst.regu_opr a
								left outer join sc_mst.regu b on a.kdregu=b.kdregu
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where no_urut='$id'");
	}
	
	function q_regu_opr_filter($kdregu,$bag_dept){
		return $this->db->query("select a.*,b.nmregu,c.nik,c.nmlengkap,d.nmdept from sc_mst.regu_opr a
								left outer join sc_mst.regu b on a.kdregu=b.kdregu
								left outer join sc_mst.karyawan c on a.nik=c.nik
								left outer join sc_mst.departmen d on c.bag_dept=d.kddept
								where a.kdregu='$kdregu' $bag_dept
								order by a.kdregu asc");
	}
	
	function q_regu_filterold(){
		return $this->db->query("select * from sc_mst.regu 
								where kdregu in (select kdregu from sc_mst.regu_opr)");
	}
	
	function q_regu_filter(){
		return $this->db->query("select * from sc_mst.regu 
								");
	}
	
	function q_list_mesin(){
		return $this->db->query("select * from sc_mst.mesin");	
	}
	
	function q_cekregu_opr($kdregu,$nik){
		return $this->db->query("select * from sc_mst.regu_opr where trim(kdregu)='$kdregu' and nik='$nik'");
	}
	function q_list_nik(){
		return $this->db->query("select * from sc_mst.karyawan 
								where nik not in(select nik from sc_mst.regu_opr where nik not in (select nik from sc_mst.karyawan where statuskepegawaian='KO') ) and statuskepegawaian<>'KO' 
								order by nmlengkap asc");
	}
	
	function q_list_warna(){
		return $this->db->query("select * from sc_mst.warna");
	}
	
	function q_cek_del_regu($kdregu){
		return $this->db->query("select * from sc_trx.jadwalkerja where kdregu='$kdregu'");
			
	}
	
	function q_cekdtlregu(){
		return $this->db->query("select a.*,b.nmlengkap from sc_mst.regu_opr a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where (a.nik not in (select nik from sc_trx.dtljadwalkerja))");
	}
	function q_cektmpregu($nama){
		return $this->db->query("select a.*,b.nmlengkap from sc_tmp.regu_opr a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where (a.nik not in (select nik from sc_trx.dtljadwalkerja)) and input_by='$nama'");
	}
	
	
	function q_cekdtlreguopr($nik){
		return $this->db->query("select * from sc_mst.regu_opr where (nik not in (select nik from sc_trx.dtljadwalkerja)) and nik='$nik'");
	}
	
}	