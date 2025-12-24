<?php
class M_user extends CI_Model{
	function list_user(){
		return $this->db->query("select * from sc_mst.user order by username asc");
	}
	function user_online(){
		$user=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
		return $this->db->query("select distinct a.userid,ip_address,b.username,b.nik 
								from osin_sessions a
								left outer join sc_mst.user b on a.userid=b.username
								where a.userid<>'USER' and nik<>'$user'
								union all
								select distinct a.userid,ip_address,b.username,b.nik 
								from osin_sessions a
								left outer join sc_mst.user b on a.userid=b.username
								where a.userid<>'USER'	and nik='$user' and username='$username'");
	}
	
	function q_user_last_login(){
		return $this->db->query("select a.nik,tgl,ip,b.username
								from sc_log.log_time a
								left outer join sc_mst.user b on a.nik=b.nik
								where a.nik<>'12345'
								order by tgl desc
								limit 5");
	
	}
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where tglkeluarkerja is null order by nmlengkap");
	}
	
	function dtl_user($nik,$username){
		return $this->db->query("select *,to_char(expdate,'dd-mm-yyyy') as exdate from sc_mst.user where nik='$nik' and username='$username'")->row_array();
	}
	
	function user_profile(){ //awas user profile untuk template bukan disini!!!!
		$nik=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
		return $this->db->query("select * from sc_mst.user where nik='$nik' and username='$username'");
	}
	
	function cek_user($nama){
		return $this->db->query("select * from sc_mst.user where username='$nama'");
	}
	
	function list_lvljbt(){
		return $this->db->query("select * from sc_mst.lvljabatan order by kdlvl asc");
	}
	
	function q_childmenu($nik,$username){
		return $this->db->query("select a.*,trim(trim(coalesce(c.namamenu,''))||'/'||trim(coalesce(b.namamenu,''))||'/'||trim(coalesce(a.namamenu,''))) as menunya from sc_mst.menuprg a left outer join 
									sc_mst.menuprg b on a.parentsub=b.kodemenu and b.child='S' left outer join 
									sc_mst.menuprg c on a.parentmenu=c.kodemenu and c.child='U' 
									where a.child='P' and a.kodemenu not in (select trim(kodemenu) as kodemenu from (
									select trim(kodemenu) as kodemenu,nik,username from sc_mst.akses 
									union all
									select trim(kodemenu) as kodemenu,nik,username from sc_tmp.akses ) as x
									where x.nik='$nik' and x.username='$username') order by menunya");
	}
	
	function q_childmenu_usertmp($nik,$username){
		return $this->db->query("select * from (
									select a.nik,a.username,a.kodemenu,b.menunya from sc_mst.akses a left outer join (
									select a.*,trim(trim(coalesce(c.namamenu,''))||'/'||trim(coalesce(b.namamenu,''))||'/'||trim(coalesce(a.namamenu,''))) as menunya from sc_mst.menuprg a left outer join 
									sc_mst.menuprg b on a.parentsub=b.kodemenu and b.child='S' left outer join 
									sc_mst.menuprg c on a.parentmenu=c.kodemenu and c.child='U' 
									where a.child='P' 
									order by namamenu asc) b on a.kodemenu=b.kodemenu
									union all
									select a.nik,a.username,a.kodemenu,b.menunya from sc_tmp.akses a left outer join (
									select a.*,trim(trim(c.namamenu)||'/'||trim(b.namamenu)||'/'||trim(a.namamenu)) as menunya from sc_mst.menuprg a left outer join 
									sc_mst.menuprg b on a.parentsub=b.kodemenu and b.child='S' left outer join 
									sc_mst.menuprg c on a.parentmenu=c.kodemenu and c.child='U' 
									where a.child='P' 
									order by namamenu asc) b on a.kodemenu=b.kodemenu) as x
									where x.nik='$nik' and x.username='$username'
									group by nik,username,kodemenu,menunya
									order by menunya");
	}
	
	function add_kdmnu_tmp($data = array()){
        $insert = $this->db->insert_batch('sc_tmp.akses',$data);
        return $insert?true:false;
    }
	
	function remove_kdmnu_tmp($data = array()){
        $delete = $this->db->delete('sc_mst.akses',$data);
        $delete = $this->db->delete('sc_tmp.akses',$data);
        return $delete?true:false;
    }
	
	function fl_akses($nik,$username){
		return $this->db->query("insert into sc_mst.akses(
								select * from sc_tmp.akses where nik='$nik' and  username='$username')
								");
	}
	function deltmp_akses($nik,$username){
		return $this->db->query("delete from sc_tmp.akses where nik='$nik' and  username='$username'");
	}
	function cek_tmp_akses($nik,$username){
		return $this->db->query("select * from sc_tmp.akses where nik='$nik' and  username='$username'");
	}
	
}



