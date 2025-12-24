<?php
class M_menu extends CI_Model{

	function list_menu(){
		return $this->db->query("select * from sc_mst.menuprg order by kodemenu");
	}

	function list_menu_utama(){
		return $this->db->query("select kodemenu,urut,namamenu,parentmenu,								
								case holdmenu when 't' then 'DI HOLD' else 'TIDAK DI HOLD' end as holdmenu ,linkmenu 
								from sc_mst.menuprg where child='U' ");
	}

	function list_menu_sub(){
		return $this->db->query("select kodemenu,urut,namamenu,parentmenu,								
								case holdmenu when 't' then 'DI HOLD' else 'TIDAK DI HOLD' end as holdmenu ,linkmenu 
								from sc_mst.menuprg where child='S' ");
	}

	function list_menu_submenu(){
		return $this->db->query("select kodemenu,urut,namamenu,parentmenu,parentsub,								
								case holdmenu when 't' then 'DI HOLD' else 'TIDAK DI HOLD' end as holdmenu ,linkmenu 
								from sc_mst.menuprg where child='P' ");
	}

	function list_menu_opt_utama(){
		return $this->db->query("select * from sc_mst.menuprg where child='U'");
	}

	function list_menu_opt_sub(){
		return $this->db->query("select * from sc_mst.menuprg where child='S'");
	}

	function user_online(){
		return $this->db->query("select * from sc_mst.user");
	}

	function list_menu_sidebar_main(){
		$userne=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
        //$this->db->cache_on();
		return $this->db->query("select * from sc_mst.menuprg where child='U' and kodemenu in 
								(select trim(parentmenu) from sc_mst.menuprg a 
								left outer join sc_mst.akses b on a.kodemenu=b.kodemenu
								where b.nik='$userne' and b.username='$username' 
								group by parentmenu) order by urut asc");
	}

	function list_menu_sidebar_sub(){
		$userne=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
        //$this->db->cache_on();
		return $this->db->query("select * from sc_mst.menuprg 
								where (child='S' or child='P') and kodemenu in (select distinct parentsub from sc_mst.menuprg where child='P' and
								kodemenu in (select kodemenu from sc_mst.akses where nik='$userne' and username='$username')) order by urut asc");
	}       

	function list_menu_sidebar_submenu(){
		$userne=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
        //$this->db->cache_on();
		return $this->db->query("select left(kodemenu,5) as menuurut, cast(right(kodemenu,-6) as integer) as nourut, * from sc_mst.menuprg where child='P' and
								kodemenu in (select kodemenu from sc_mst.akses where nik='$userne' and username='$username')
								order by urut asc");
	}

	function dtl_menu($kodemenu){
		return $this->db->query("select * from sc_mst.menuprg where kodemenu='$kodemenu'")->row_array();
	}

    function q_menuprg($kodemenu){
        return $this->db->query("select * from (
                                    select a.*,b.namamenu as namaparent,c.namamenu as namaparentsub from sc_mst.menuprg a
                                    left outer join sc_mst.menuprg b on a.parentmenu=b.kodemenu
                                    left outer join sc_mst.menuprg c on a.parentsub=c.kodemenu) as x
                                    where kodemenu is not null and kodemenu='$kodemenu'");
    }

    function q_menuprg_ext($kodemenu){
	    return $this->db->query("select * from (
                                    select * from sc_mst.menuprg where trim(kodemenu) in (select trim(parentmenu) from sc_mst.menuprg where kodemenu='$kodemenu')
                                    union all
                                    select * from sc_mst.menuprg where trim(kodemenu) in (select trim(parentsub) from sc_mst.menuprg where kodemenu='$kodemenu')
                                    union all
                                    select * from sc_mst.menuprg where trim(kodemenu) in (select trim(kodemenu) from sc_mst.menuprg where kodemenu='$kodemenu')
                                    ) as x where kodemenu is not null order by trim(child) desc
        ");
    }

	function cek_del($kodemenu){
		return $this->db->query("select * from sc_mst.menuprg where trim(parentmenu)='$kodemenu' or trim(parentsub)='$kodemenu'")->num_rows();
	}

	function user_profile(){
		$kodemenu=$this->session->userdata('nik');
		$username=$this->session->userdata('nama');
		return $this->db->query("select * from 
                                    (select a.*,case 
                                    when b.nmlengkap is null then a.username
                                    else b.nmlengkap end as nmlengkap from 
                                    sc_mst.user a left outer join sc_mst.karyawan b on a.nik=b.nik) as x where nik='$kodemenu' and username='$username'");
	}

	function cek_menu($kodemenu){
		return $this->db->query("select * from sc_mst.menuprg where kodemenu='$kodemenu'")->num_rows();
	}

	function q_kontrak(){
		return $this->db->query("select *,case when kuranghari<0 then 'TERLEWAT'
									else 'AKAN HABIS' 
									end as keteranganhari  from 
									(select a.nmlengkap,b.tgl_selesai-cast(now() as date) as kuranghari,a.nik,b.nodok,a.statuskepegawaian,b.keterangan,c.nmkepegawaian,
									to_char(b.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
									to_char(b.tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
									from sc_mst.karyawan a
									left outer join sc_trx.status_kepegawaian b on a.nik=b.nik and a.statuskepegawaian=b.kdkepegawaian
									left outer join sc_mst.status_kepegawaian c on b.kdkepegawaian=c.kdkepegawaian
									where a.statuskepegawaian<>'KO' and a.statuskepegawaian<>'KT' 
									and to_char(tgl_selesai,'YYYYMM') between to_char(now() - interval '1 Months','YYYYMM') and  to_char(now(),'YYYYMM')) as t1 
								");
	}

	function q_pensiun(){
		return $this->db->query("select  a.nmlengkap,to_char(age(a.tgllahir),'YY'),cast(to_char(tgllahir,'DD-MM')||'-'||to_char(now(),'YYYY')as date) as tglultah,a.nik,b.nodok,b.kdkepegawaian,b.keterangan,c.nmkepegawaian,
											to_char(b.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
											to_char(b.tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
											from sc_mst.karyawan a
											left outer join sc_trx.status_kepegawaian b on a.statuskepegawaian=b.kdkepegawaian and a.nik=b.nik
											left outer join sc_mst.status_kepegawaian c on b.kdkepegawaian=c.kdkepegawaian
											where to_char(age(a.tgllahir),'YY')>='56' AND b.kdkepegawaian<>'KO' and b.kdkepegawaian<>'KP'  ");


	}
	/* list akses menu usernya belum custom */
	function q_nik_akses($nik){
		return $this->db->query("select a.*,b.bag_dept,b.subbag_dept,b.jabatan,b.grouppenggajian from sc_mst.user a
									left outer join sc_mst.karyawan b on a.nik=b.nik where a.nik='$nik'");
	}

	public function q_menu_url_dcms(){
		return $this->db->query("SELECT value1 FROM sc_mst.option where kdoption = 'DCMS';")->row()->value1;
	}

}


