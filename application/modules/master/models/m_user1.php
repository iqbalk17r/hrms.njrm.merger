<?php
class M_user extends CI_Model{
	function list_user(){
		return $this->db->query("select * from sc_mst.user");
	}
	function user_online(){
		$user=$this->session->userdata('nik');
		return $this->db->query("select distinct a.userid,ip_address,b.username 
								from osin_sessions a
								left outer join sc_mst.user b on a.userid=b.nik
								where a.userid<>'USER'");
	}
	
	function q_user_last_login(){
		//$user=$this->session->userdata('nik');
		return $this->db->query("select a.nik,tgl,ip,b.username
								from sc_log.log_time a
								left outer join sc_mst.user b on a.nik=b.nik
								where a.nik<>'12345'
								order by tgl desc
								limit 5");
	
	}
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where nik not in (select nik from sc_mst.user)");
	}
	
	function dtl_user($nik){
		return $this->db->query("select *,to_char(expdate,'dd-mm-yyyy') as exdate from sc_mst.user where nik='$nik'")->row_array();
	}
	
	function user_profile(){
		$nik=$this->session->userdata('nik');
		return $this->db->query("select * from sc_mst.user where nik='$nik'");
	}
	
	function cek_user($nik){
		return $this->db->query("select * from sc_mst.user where nik='$nik'")->num_rows();
	}
}



