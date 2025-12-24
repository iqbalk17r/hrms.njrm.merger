<?php
class M_eg_jabatan extends CI_Model{
	
	function q_trxtype(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='EG JABATAN'");
	}
	
	function q_eg_jabatan(){
		return $this->db->query("select a.*,b.nmjabatan,c.uraian,d.nmdept,e.nmsubdept from sc_mst.eg_jabatan a
									left outer join sc_mst.jabatan b on a.kdjabatan=b.kdjabatan 
									left outer join sc_mst.trxtype c on a.kdtrx=c.kdtrx and c.jenistrx='EG JABATAN'
									left outer join sc_mst.departmen d on a.kddept=d.kddept
									left outer join sc_mst.subdepartmen e on a.kdsubdept=e.kdsubdept
									order by no_eg asc");
	}
	
 	function q_department(){
		return $this->db->query("select * from sc_mst.departmen order by nmdept asc");
	}
	
	function q_subdepartment(){
		return $this->db->query("select * from sc_mst.subdepartmen order by nmsubdept asc");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_mst.jabatan order by nmjabatan asc");
	}
	
	function q_keahlian(){
		return $this->db->query("select * from sc_mst.keahlian 
									order by kdkeahlian asc");
	}
	
	function q_cekkeahlian($kdkeahlian){
		return $this->db->query("select * from sc_mst.keahlian 
									where kdkeahlian='$kdkeahlian'");
	}
}	