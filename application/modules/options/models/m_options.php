<?php
class M_options extends CI_Model{
	

	function q_options(){
		return $this->db->query("select to_char(valdate,'DD-MM-YYYY') as tgl,* from sc_poin.configpoin");
	}

	function q_optupdt($kode){
		return $this->db->query("update from sc_poin.configpoin set configname='$configname', valnum='$valnum', valchar,='$valchar', valdate='$valdate',status='$status' where kode='$kode'");
	}

	function q_ceksesion(){
		$username=$this->session->userdata('username');	
		return $this->db->query("select a.userid,b.nmlengkap,b.kddept from sc_mst.user a 
									left outer join sc_hrd.pegawai b on a.nip=b.nip
									where b.kddept='IT' and a.userid='$username'");
	}
	
	function q_optakses(){
		return $this->db->query("select valchar from sc_poin.configpoin
									where kode='ADM'");
	}
	

	function q_opt($kode){
		return $this->db->query("select to_char(valdate,'DD-MM-YYYY') as tgl,* from sc_poin.configpoin where kode='$kode'")->row_array();
	}

	
	function q_masteruser(){
		return $this->db->query("select * from sc_mst.user");
	}
}
