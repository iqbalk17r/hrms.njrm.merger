<?php
class M_user extends CI_Model{


    private $table='sc_mst.user';
    //untuk proses login
    function cek($username,$password){
        $this->db->where("username",$username);
        $this->db->where("passwordweb",$password);
        return $this->db->get("user");
    }
    
	function cek_user_login($username, $password,$hold='N'){
		$tglskg=date("Y-m-d H:i:s");
		$this->db->select('*');		
		$this->db->where('expdate >',$tglskg);		
		$this->db->where('hold_id',$hold);
		$this->db->where('username',$username);
		$this->db->where('passwordweb',md5($password));
		$query = $this->db->get($this->table, 1);
		if ($query->num_rows() == 1)
		{
			return $query->row_array();
		}
	}
	
	function list_modulprg(){		
		return $this->db->query("select * from sc_mst.mdlprg order by mdlprg");			
	} 
	
	function list_modul(){		
		return $this->db->query("select a.*,b.userid from sc_mst.mdlprg a
								left outer join sc_mst.usermdl b on a.mdlprg=b.mdlprg order by a.mdlprg");			
	}
	//Febri 17-04-2015
	function q_ubah_status(){
		$day = strtotime("+1 days");
		$day_start = date('Y-m-d', $day);
		return $this->db->query("update sc_hrd.reminder_kontrak set status='R' where tglreminder<='$day_start' and status!='S'");			
	}
	
	function list_menu(){
		return $this->db->query("select * from sc_mst.menu_utama");
	}
	function list_modulusr(){
		$userne=$this->session->userdata('username');
		return $this->db->query("select a.modul as menu,* from sc_mst.mdlprg a
								left outer join sc_mst.usermdl b on a.mdlprg=b.mdlprg 
								where b.userid='$userne'
								order by a.mdlprg");			
	}
	
	function semua(){
		return $data=$this->db->query("select b.locaname,c.areaname,d.divisiname,a.* from sc_mst.user a
										left outer join sc_mst.gudang b on b.loccode=a.location_id 
										left outer join sc_mst.carea c on c.area=a.custarea
										left outer join sc_mst.mdivisi d on d.divisi=a.divisi");					
	}
	function user (){
		//return $this->db
	}
	
	function divisi(){
		return $this->db->query(" select * from sc_mst.mdivisi");
	}
    
    function cekUser($userid){
        $this->db->where("nik",$userid);
        return $this->db->get("sc_mst.user");
		//return $this->db->query('select userid from "sc_mst".user ');
    }

	function user_profile(){
		$userid=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
		return $this->db->query("select * from sc_mst.user where nik='$userid' and username='$username'");
	}
	
	function user_online(){
		$user=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
		$this->db->query("update sc_mst.user a set image=coalesce(b.image,'admin.jpg') from sc_mst.karyawan b
	    where a.nik=b.nik;");
		return $this->db->query("select userid,ip_address,username,nik,image from (
                                select distinct a.userid,ip_address,b.username,b.nik ,b.image
                                from osin_sessions a
                                left outer join sc_mst.user b on a.userid=b.username
                                where a.userid<>'USER' and nik<>'$user'
                                union all
                                select distinct a.userid,ip_address,b.username,b.nik,b.image 
                                from osin_sessions a
                                left outer join sc_mst.user b on a.userid=b.username
                                where a.userid<>'USER'	and nik='$user' and username='$username') as x");
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

    function cek_modul($userid,$cekmdl){
		return $this->db->query("select mdlprg from sc_mst.usermdl where branch='SBYNSA' and userid='$userid' and mdlprg='$cekmdl' ");
	}
	
    function cekId($kode){
        $this->db->where("nik",$kode);
        return $this->db->get("sc_mst.user");
    }
    
    function update($userid,$info){
        $this->db->where("nik",$userid);
        $this->db->update('sc_mst.user',$info);		
    }
    
    function simpan($info){
        $this->db->insert("sc_mst.user",$info);
    }
    
	function simpan_mdl($infomdl){
        $this->db->insert("sc_mst.usermdl",$infomdl);
    }
	
	function update_mdl($userid,$infomdl){
        $this->db->where("userid",$userid);
        $this->db->update('sc_mst.usermdl',$infomdl);		
    }
	
    function hapus($kode){
        $this->db->where("nik",$kode);
        $this->db->delete("sc_mst.user");
    }
	
	function hapus_mdl($userid){
        $this->db->where("nik",$userid);
        $this->db->delete("sc_mst.usermdl");
    }

    function schedular(){
        $tgl = date('Y-m-d');
        return $this->db->query("select sc_trx.pr_cutirata_tgl('$tgl')");
        //return $this->db->query("select sc_trx.pr_cutibased_nusa('$tgl')");
    }

    /**/
    function read_validation(){
        return $this->fiky_encryption->sw_lc();
    }

    function read_db(){
        return $this->fiky_encryption->readpublic_pb();
    }
    function chickchikbumbum(){
        return $this->fiky_encryption->read4db();
    }
    function loginx($a){
        $this->fiky_encryption->CP_login($a);
    }
    function cruds(){
        $this->fiky_encryption->createtable();
    }

    function insert_log_who_access_web($p1){
        $this->fiky_encryption->getAccessPage($p1);
    }
    function insert_log_what_access_modules($p1){
        $this->fiky_encryption->keyAccess($p1);
    }
    function direct_validation(){
        $this->fiky_encryption->checkDirectMac();
    }
    function del_validation(){
        $this->fiky_encryption->checkdelfiles();
    }
    function coldown(){
        $this->fiky_encryption->timerCountDown();
    }
    /**/
}