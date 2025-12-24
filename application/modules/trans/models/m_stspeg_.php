<?php
class M_stspeg extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(statuskepegawaian),'')!='KO' order by nmlengkap asc");
		
	}
	
	function list_kepegawaian(){
		return $this->db->query("select * from sc_mst.status_kepegawaian");
	}
	
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								where trim(a.nik)='$nik'");
	}
	
	
	function q_stspeg($nik){
		return $this->db->query("select a.*,b.nmkepegawaian,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
								to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' 	
								order by b.nmkepegawaian asc");
	}
	
	
	function q_stspeg_edit($nik,$nodok){
		return $this->db->query("sselect a.*,b.nmkepegawaian,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
								to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.nodok='$nodok'	
								order by b.nmkepegawaian asc");
	}
	
	function q_list_karkon(){
		return $this->db->query("select *,case when kuranghari<0 then 'TERLEWAT'
                                else 'AKAN HABIS' 
                                end as keteranganhari  from 
                                (select a.nmlengkap,cast(now() as date)-b.tgl_selesai as kuranghari,a.nik,b.nodok,b.kdkepegawaian,b.keterangan,c.nmkepegawaian,
                                to_char(b.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
                                to_char(b.tgl_selesai,'DD-MM-YYYY') as tgl_selesai1,a1.nmdept
                                from sc_mst.karyawan a
                                left outer join sc_mst.departmen a1 on a.bag_dept=a1.kddept
                                left outer join sc_trx.status_kepegawaian b on a.nik=b.nik --and a.statuskepegawaian=b.kdkepegawaian
                                left outer join sc_mst.status_kepegawaian c on trim(b.kdkepegawaian)=trim(c.kdkepegawaian)
                                where a.statuskepegawaian<>'KO' and coalesce(a.statuskepegawaian,'') in ('P1','P2','P3','P4','P5')
                                and to_char(tgl_selesai,'YYYYMM') between to_char(now() - interval '2 Months','YYYYMM') and  to_char(now() + interval '2 Months','YYYYMM')
                                ) as t1
                                order by kuranghari asc
								");
	}
	
	function q_show_edit_karkon($nodok){
		return $this->db->query("select b.nmlengkap,tgl_selesai-cast(now() as date) as kuranghari,a.nik,a.nodok,c.nmkepegawaian,a.kdkepegawaian,a.keterangan,
								to_char(a.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
								to_char(tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.status_kepegawaian c on a.kdkepegawaian=c.kdkepegawaian
								where a.nodok='$nodok'");
	
	}
	
	function q_list_karpen(){
		return $this->db->query("select  a.nmlengkap,a1.nmdept,to_char(age(a.tgllahir),'YY') as umur,cast(to_char(tgllahir,'DD-MM')||'-'||to_char(now(),'YYYY')as date) as tglultah,a.nik,b.nodok,b.kdkepegawaian,b.keterangan,c.nmkepegawaian,
                                to_char(b.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
                                to_char(b.tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
                                from sc_mst.karyawan a
                                left outer join sc_mst.departmen a1 on a.bag_dept=a1.kddept
                                left outer join sc_trx.status_kepegawaian b on a.statuskepegawaian=b.kdkepegawaian and a.nik=b.nik
                                left outer join sc_mst.status_kepegawaian c on b.kdkepegawaian=c.kdkepegawaian
                                where to_char(age(a.tgllahir),'YY')>='56' and coalesce(a.statuskepegawaian,'')!='KO'  
								");
	
	}
	function q_list_ojt($param=null){
        return $this->db->query("select *,  case 
	    when valueday<0 then 'TERLEWAT '||(valueday)*-1||' HARI' 
	    when valueday=0 then 'PAS HARI INI' 
	    when valueday>0 then 'KURANG '||(valueday)||' HARI LAGI' 
	    else '' end as eventketerangan 
	    from sc_mst.lv_m_karyawan x
	    left outer join (select a.*,b.nmkepegawaian,tgl_selesai-cast(now() as date) as valueday from (
	    select a.* from sc_trx.status_kepegawaian a, (	
	    select nik,kdkepegawaian,max(nodok) as nodok from sc_trx.status_kepegawaian 
	    group by nik,kdkepegawaian)b 
	    where a.nik=b.nik and a.kdkepegawaian = b.kdkepegawaian and a.nodok=b.nodok) a
	    left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
	    ) as y on x.nik=y.nik and x.statuskepegawaian=y.kdkepegawaian
	    where coalesce(statuskepegawaian,'') != 'KO' and valueday<=60 and coalesce(statuskepegawaian,'') in ('OJ','PK')  $param order by valueday asc");
    }
	
	function q_list_magang($param=null){
        return $this->db->query("select *,  case 
	    when valueday<0 then 'TERLEWAT '||(valueday)*-1||' HARI' 
	    when valueday=0 then 'PAS HARI INI' 
	    when valueday>0 then 'KURANG '||(valueday)||' HARI LAGI' 
	    else '' end as eventketerangan
	    from sc_mst.lv_m_karyawan x
	    left outer join (select a.*,b.nmkepegawaian,tgl_selesai-cast(now() as date) as valueday from (
	    select a.* from sc_trx.status_kepegawaian a, (	
	    select nik,kdkepegawaian,max(nodok) as nodok from sc_trx.status_kepegawaian 
	    group by nik,kdkepegawaian)b 
	    where a.nik=b.nik and a.kdkepegawaian = b.kdkepegawaian and a.nodok=b.nodok) a
	    left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
	    ) as y on x.nik=y.nik and x.statuskepegawaian=y.kdkepegawaian
	    where coalesce(statuskepegawaian,'') != 'KO' and valueday<=60 and coalesce(statuskepegawaian,'')='MG' $param order by valueday asc");
    }
}	