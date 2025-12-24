<?php
class M_akses extends CI_Model{	
	function list_akses($nik,$username){
		return $this->db->query("select nik,a.kodemenu,namamenu,
										case when hold_id='t' then 'IYA' else 'TIDAK' end as hold_id, 
										case when aksesview='t' then 'IYA' else 'TIDAK' end as aksesview, 
										case when aksesinput='t' then 'IYA' else 'TIDAK' end as aksesinput, 
										case when aksesupdate='t' then 'IYA' else 'TIDAK' end as aksesupdate, 
										case when aksesdelete='t' then 'IYA' else 'TIDAK' end as aksesdelete, 
										case when aksesapprove='t' then 'IYA' else 'TIDAK' end as aksesapprove, 
										case when aksesapprove2='t' then 'IYA' else 'TIDAK' end as aksesapprove2, 
										case when aksesapprove3='t' then 'IYA' else 'TIDAK' end as aksesapprove3, 
										case when aksesconvert='t' then 'IYA' else 'TIDAK' end as aksesconvert, 
										case when aksesprint='t' then 'IYA' else 'TIDAK' end as aksesprint, 
										case when aksesdownload='t' then 'IYA' else 'TIDAK' end as aksesdownload,
										case when aksesfilter='t' then 'IYA' else 'TIDAK' end as aksesfilter,
										trim(a.username) as username
									from sc_mst.akses a
									left outer join sc_mst.menuprg b on a.kodemenu=b.kodemenu
									where nik='$nik' and username='$username'");
	}
	
	function list_aksespermenu($nama,$kmenu){
		return $this->db->query(" select a.kodemenu,a.linkmenu,b.* from sc_mst.menuprg a join sc_mst.akses b on a.kodemenu=b.kodemenu 
								where b.nik='$nama' and a.kodemenu='$kmenu'");
	}
	function list_aksesatasan1($nama){
		return $this->db->query("select nik from sc_mst.karyawan where nik_atasan='$nama'");
	}
	
	function list_aksesatasan2($nama){
		return $this->db->query("select nik from sc_mst.karyawan where nik_atasan2='$nama'");
	}
	
	function list_aksesperdep(){
		$nik=$this->session->userdata('nik');
		return $this->db->query(" select * from sc_mst.karyawan where nik='$nik' and bag_dept in ('PG','FA') and subbag_dept in ('P4')");
	}
	
	function list_aksesperdepcuti(){
		$nik=$this->session->userdata('nik');
		return $this->db->query(" select * from sc_mst.karyawan where nik='$nik' and bag_dept in ('PG','FA') and subbag_dept in ('P4')");
	}
	
	function list_akses_od(){
		$nik=$this->session->userdata('nik');
		return $this->db->query(" select * from sc_mst.karyawan where nik='$nik' and bag_dept='FA' and subbag_dept='P4'
								");
	}
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.tglkeluarkerja is null order by nmlengkap asc");
	}
	
	function list_akses_alone(){
		$nik=$this->session->userdata('nik');
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.nik='$nik' and f.tglkeluarkerja is null");
	}
	
	function q_user_check(){
		$nik=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
		return $this->db->query("select * from sc_mst.user where nik='$nik' and username='$username'");
	}
	
	function list_menu($nik,$username){	
		$userne=$nik;
		return $this->db->query("select left(kodemenu,5) as menuurut, cast(right(kodemenu,-6) as integer) as nourut, * from sc_mst.menuprg where child='P' and
								kodemenu not in (select kodemenu from sc_mst.akses where nik='$userne' and username='$username' )
								order by menuurut,nourut asc");
	}
	
	function cek_input_akses($nik,$menu,$username){
		return $this->db->query("select * from sc_mst.akses where nik='$nik' and username='$username' and kodemenu='$menu'")->num_rows();
	}
	function detail_user_akses($nik,$menu){
		return $this->db->query("select a.*,b.namamenu from sc_mst.akses a
								left outer join sc_mst.menuprg b on a.kodemenu=b.kodemenu
								where nik='$nik' and a.kodemenu='$menu'");
	}
	
	function update_akses($nik,$menu,$info_update,$username){
		$this->db->where('nik',$nik);
		$this->db->where('kodemenu',$menu);
		$this->db->where('username',$username);
		$this->db->update('sc_mst.akses',$info_update);
	}
	
	function user_notin($nama){
		return $this->db->query("select * from sc_mst.user where nik not in (select trim(nik) from sc_mst.karyawan) and nik='$nama'");
	}
	
	function mstuser($nama){
		return $this->db->query("select * from sc_mst.user where nik='$nama'");
		}


	function q_branch(){
		return $this->db->query("select * from sc_mst.branch where cdefault='YES'");
		}

	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
		}

	function q_menuprg($kodemenu){
	    return $this->db->query("select * from sc_mst.menuprg where kodemenu='$kodemenu'");
    }

    function q_update_version($kodemenu,$data){
        $this->db->where('kodemenu',$kodemenu);
        $this->db->update('sc_mst.version',$data);
    }
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
		left outer join sc_mst.departmen b on a.bag_dept=b.kddept
		left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
		left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
		left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
		left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
		left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
		where a.nik='$nik' and f.tglkeluarkerja is null
		");
		}
		
	function list_karyawan_param($param_list_akses){
		return $this->db->query("select * from (select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.tglkeluarkerja is null  ) as x
								where nik is not null $param_list_akses order by nmlengkap asc");
	}	
	
	function list_aksesperdeppo(){
		$nik=$this->session->userdata('nik');
		//return $this->db->query(" select * from sc_mst.karyawan where nik='$nik' and bag_dept='KNA' and subbag_dept='KNA03'");
		return $this->db->query(" select * from sc_mst.karyawan where nik='$nik' and (bag_dept='HA' or bag_dept='PG')");
	}

    function list_aksespermenu_rev($param){
        return $this->db->query(" select * from (select a.linkmenu,b.* from sc_mst.menuprg a join sc_mst.akses b on a.kodemenu=b.kodemenu) as x 
								where kodemenu is not null $param");
    }

    function insert_version($kodemenu){
	    return $this->db->query("insert into sc_mst.version
                                    (kodemenu)
                                values
                                    ('$kodemenu');");
    }

    function q_option($param=null){
        return $this->db->query("select * from sc_mst.option where kdoption is not null $param");
    }

    function q_option_special_user($param=null){
        return $this->db->query("select * from sc_mst.option_special_user where nik is not null $param");
    }

    function reduce_progress(){
        $this->fiky_encryption->codeigniter_environment();
    }
}


