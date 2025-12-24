<?php
class M_nomor extends CI_Model{
	function q_nomor(){
		return $this->db->query("select cekclose,
								case 
								when cekclose='T' then 'YA'
								when cekclose='F' then 'TIDAK'
								end as cekclose1,
								* from sc_mst.nomor");
	}
	
	function q_ceknomor($dokumen,$part){
		return $this->db->query("select * from sc_mst.nomor where trim(dokumen)='$dokumen' and trim(part)='$part'");
	}
	
	function q_nomorlalu(){
		return $this->db->query("select cekclose,
								case 
								when cekclose='T' then 'YA'
								when cekclose='F' then 'TIDAK'
								end as cekclose1,
								* from sc_mst.nomorlalu");
	}
	
	function q_ceknomorlalu($dokumen,$part){
		return $this->db->query("select * from sc_mst.nomorlalu where trim(dokumen)='$dokumen' and trim(part)='$part'");
	}
	
	function q_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan order by nmlengkap asc");
	}
}	