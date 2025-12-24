<?php
class M_ijin_absensi extends CI_Model{
	function q_ijin_absensi(){
		return $this->db->query("select case 
									when ptg_cuti='T' then 'YES'
									when ptg_cuti='F' then 'NO'
									end as ptg_cuti1, 
									* from sc_mst.ijin_absensi order by kdijin_absensi asc");
	}
	
	function q_cekijin_absensi($kdijin_absensi){
		return $this->db->query("select * from sc_mst.ijin_absensi where trim(kdijin_absensi)='$kdijin_absensi'");
	}

}	