<?php
class M_formula extends CI_Model{
	
	
	
	
	function list_master(){
		return $this->db->query("select * from sc_mst.master_formula");
	}
	
	function list_detail($kdrumus){
		return $this->db->query("select c.uraian,
								case 
								when a.tetap='T' then 'TETAP'
								when a.tetap='F' then 'TIDAK TETAP'
								else 'N.A' 
								end as tetap1,
								case
								when a.taxable='T' then 'TAXABLE'
								when a.taxable='F' then 'NON TAXABLE'
								else 'N.A' 
								end as taxable1,
								case 
								when a.deductible='T' then 'DEDUCTIBLE'
								when a.deductible='F' then 'NON DEDUCTIBLE'
								else 'N.A' 
								end as deductible1, 
								case
								when a.regular='T' then 'REGULAR'
								when a.regular='F' then 'NON REGULAR'
								else 'N.A' 
								end as regular1,
								case
								when a.cash='T' then 'CASH'
								when a.cash='F' then 'NON CASH'
								else 'N.A' 
								end as cash1,
								a.* from sc_mst.detail_formula a
								left outer join sc_mst.master_formula b on a.kdrumus=b.kdrumus
								left outer join sc_mst.trxtype c on a.aksi=c.kdtrx and c.jenistrx='KOMPONEN PAYROLL'
								where a.kdrumus='$kdrumus'
								order by a.no_urut asc");
	}
	
	function cek2($kdrumus){
		return $this->db->query("select a.* from sc_mst.detail_formula a
								left outer join sc_mst.master_formula b on a.kdrumus=b.kdrumus
								where a.kdrumus='$kdrumus'");
	}
	
	function cek($kdrumus){
		return $this->db->query("select * from sc_mst.master_formula where kdrumus='$kdrumus' ");
	
	}
	
	function beri_no_urut($kdrumus){
		
		return $this->db->query("select max(no_urut) as nomor from sc_mst.detail_formula where kdrumus='$kdrumus'");
		
	}
	
	function q_trxtype(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='KOMPONEN PAYROLL'");
	
	}
	
	
	
}	