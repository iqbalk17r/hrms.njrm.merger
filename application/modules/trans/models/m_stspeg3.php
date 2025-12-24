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
                                to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,d.uraian as nmstatus
                                 from sc_trx.status_kepegawaian a
                                left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
                                left outer join sc_mst.karyawan c on a.nik=c.nik
                                left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STSPEG'
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
                                left outer join sc_trx.status_kepegawaian b on a.nik=b.nik and a.statuskepegawaian=b.kdkepegawaian and b.status='B'
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
	    where coalesce(statuskepegawaian,'') != 'KO' and valueday<=60 and coalesce(statuskepegawaian,'') in ('OJ','PK') and y.status='B' $param order by valueday asc");
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
	
	function q_recent_employee_activities($day){
        return $this->db->query("select x.*, b.nmdept,b.nmlengkap from (
                                            select nik,nodok,keterangan,input_date,input_by,'CUTI' as nmdok from sc_trx.cuti_karyawan where status='P'
                                            union all
                                            select nik,nodok,keterangan,input_date,input_by,'IJIN' as nmdok from sc_trx.ijin_karyawan where status='P'
                                            union all
                                            select nik,nodok,keperluan,input_date,input_by,'DINAS' as nmdok from sc_trx.dinas where status='P'
                                            union all
                                            select nik,nodok,keterangan,input_date,input_by,'LEMBUR' as nmdok from sc_trx.lembur where status='P') as x
                                            left outer join sc_mst.lv_m_karyawan b on x.nik=b.nik
                                            where x.nik is not null and to_char(x.input_date,'yyyy-mm-dd')::date between to_char(now() - interval '$day day','yyyy-mm-dd')::date  and to_char(now(),'yyyy-mm-dd')::date 
                                            order by x.input_date desc
                                            ");
    }

    function q_transaction_read($where){
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_trx.status_kepegawaian');
    }

    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.status_kepegawaian', $value);
    }

    function q_transaction_select($select,$where){
        return $this->db
            ->select($select)
            ->where($where)
            ->get('sc_trx.status_kepegawaian');
    }

    function q_transaction_read_where($clause = null){
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    select
        COALESCE(TRIM(a.nik), '') AS nik,
        COALESCE(TRIM(a.nodok), '') AS nodok,
        COALESCE(TRIM(a.kdkepegawaian), '') AS kdkepegawaian,
        a.tgl_mulai AS tgl_mulai,
        a.tgl_selesai AS tgl_selesai,
        COALESCE(TRIM(a.cuti), '') AS cuti,
        COALESCE(TRIM(a.keterangan), '') AS keterangan,
        a.input_date AS  input_date,
        COALESCE(TRIM(a.input_by), '') AS input_by,
        a.update_date AS update_date ,
        COALESCE(TRIM(a.update_by), '') AS update_by,
        COALESCE(TRIM(a.nosk), '') AS nosk,
        COALESCE(TRIM(a.status), '') AS status,
        COALESCE(TRIM(b.nmkepegawaian), '') AS nmkepegawaian,
        COALESCE(TRIM(c.nmlengkap), '') AS nmlengkap,
        to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
        case 
        	when sk.kdkepegawaian is not null then sk.tgl_selesai 
        else a.tgl_selesai
        end as tgl_selesai1,
        --to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,
        to_char(a.tgl_mulai,'yyyymm') AS filterstart,
        to_char(a.tgl_selesai,'yyyymm') AS filterend,
        d.uraian as nmstatus,
        COALESCE(TRIM(e.nmdept), '') AS deptname,
        COALESCE(TRIM(f.nmsubdept), '') AS subdeptname,
        COALESCE(TRIM(g.nmjabatan), '') AS positionname,
        COALESCE(TRIM(c.statuskepegawaian), '') AS statuskepegawaian,
        c.tglkeluarkerja AS tglkeluarkerja,
        sk.kdkepegawaian as KO
    from sc_trx.status_kepegawaian a
        left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
        left outer join sc_mst.karyawan c on a.nik=c.nik
        left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STSPEG'
        LEFT OUTER JOIN sc_mst.departmen e ON c.bag_dept = e.kddept
        LEFT OUTER JOIN sc_mst.subdepartmen f ON c.bag_dept = f.kddept AND c.subbag_dept = f.kdsubdept
        LEFT OUTER JOIN sc_mst.jabatan g ON TRIM(c.bag_dept) = TRIM(g.kddept) AND TRIM(c.subbag_dept) = TRIM(g.kdsubdept) AND TRIM(c.jabatan) = TRIM(g.kdjabatan)
        left outer join (
        select nik,nodok,kdkepegawaian,tgl_selesai from sc_trx.status_kepegawaian sk where kdkepegawaian ='KO'
        ) sk on a.nik=sk.nik and a.nodok=sk.nodok
    order by b.nmkepegawaian asc
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }

    function q_spv($param = ''){
        return $this->db->query("select nmlengkap,jabatan,alamatktp,nmjabatan
    from (
            select * from sc_mst.karyawan a left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan
        ) x
        where true
            $param ");
    }

    function q_kar($nik,$nodok){
        return $this->db->query("with data as (select a.nik,a.nmlengkap,
                     case when a.jk = trim('L') then 'Laki-laki'::text else 'Perempuan'::text end as jk,
                     trim(c.namakotakab) as tmptlahir,
                     a.tgllahir,
                     a.noktp,
                     d.nmagama,
                     coalesce(a.alamatktp, '-')                                                   as alamatktp,
                     g.nmnikah,
                     e.nmjabatan,
                     f.nmdept,
                     b.nodok,
                     b.kdkepegawaian,
                     coalesce(to_char(b.tgl_mulai,'yyyy-mm-dd'),'-') as tgl_mulai,
                     coalesce(to_char(b.tgl_selesai,'yyyy-mm-dd'),'-') as tgl_selesai,
                     to_char(now(), 'yyyy-mm-dd')                                                 as tgl_cetak,
                     ROW_NUMBER() OVER (ORDER BY kdkepegawaian)
              from sc_mst.karyawan a
                       right outer join sc_trx.status_kepegawaian b on a.nik = b.nik
                       left outer join sc_mst.kotakab c on a.kotalahir = c.kodekotakab
                       left outer join sc_mst.agama d on a.kd_agama = d.kdagama
                       left outer join sc_mst.jabatan e on a.jabatan = e.kdjabatan
                       left outer join sc_mst.departmen f on a.bag_dept = f.kddept
                       left outer join sc_mst.status_nikah g on a.status_pernikahan = g.kdnikah
              where a.nik = '$nik' 
              )
                select *
                from data where nodok='$nodok'");
    }

}	