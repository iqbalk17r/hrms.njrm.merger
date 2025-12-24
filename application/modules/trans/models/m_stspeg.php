<?php
class M_stspeg extends CI_Model
{

    function list_jnsbpjs()
    {
        return $this->db->query("select * from sc_mst.jenis_bpjs");
    }


    function list_karyawan()
    {
        return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(statuskepegawaian),'')!='KO' order by nmlengkap asc");
    }

    function list_kepegawaian()
    {
        return $this->db->query("select * from sc_mst.status_kepegawaian");
    }

    function list_karyawan_index($nik)
    {
        return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								where trim(a.nik)='$nik'");
    }


    function q_stspeg($nik)
    {
        return $this->db->query("select a.*,b.nmkepegawaian,c.nik_atasan,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
                                to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,d.uraian as nmstatus,e.status as statuspen,e.kddok, f.full_path
                                from sc_trx.status_kepegawaian a
                                left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
                                left outer join sc_mst.karyawan c on a.nik=c.nik
                                left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STSPEG'
                                left outer join sc_pk.master_pk e on a.nodok=e.kdcontract
                                left outer join sc_trx.document_contract f on a.nodok = f.kdcontract 
                                where a.nik = '$nik'
                                order by b.nmkepegawaian asc");
    }


    function q_stspeg_edit($nik, $nodok)
    {
        return $this->db->query("select a.*,b.nmkepegawaian,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
								to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.nik='$nik' and a.nodok='$nodok'	
								order by b.nmkepegawaian asc");
    }

    function q_list_karkon()
    {
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

    function q_show_edit_karkon($nodok)
    {
        return $this->db->query("select b.nmlengkap,tgl_selesai-cast(now() as date) as kuranghari,a.nik,a.nodok,c.nmkepegawaian,a.kdkepegawaian,a.keterangan,
								to_char(a.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
								to_char(tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
								 from sc_trx.status_kepegawaian a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.status_kepegawaian c on a.kdkepegawaian=c.kdkepegawaian
								where a.nodok='$nodok'");
    }

    function q_list_karpen()
    {
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
    function q_list_ojt()
    {
        return $this->db->query("select * ,y.duedate_ojt as tgl_ojt,  case 
	    when valueday<0 then 'TERLEWAT '||(valueday)*-1||' HARI' 
	    when valueday=0 then 'PAS HARI INI' 
	    when valueday>0 then 'KURANG '||(valueday)||' HARI LAGI' 
	    else '' end as eventketerangan 
	    from sc_mst.lv_m_karyawan x
	    left outer join (select a.*,b.nmkepegawaian,duedate_ojt-cast(now() as date) as valueday from (
	    select a.* from sc_trx.status_kepegawaian a, (	
	    select nik,kdkepegawaian,max(nodok) as nodok from sc_trx.status_kepegawaian 
	    group by nik,kdkepegawaian)b 
	    where a.nik=b.nik and a.kdkepegawaian = b.kdkepegawaian and a.nodok=b.nodok) a
	    left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
	    where a.ojt = 'T' and status = 'B' order by input_date desc
	    ) as y on x.nik=y.nik and x.statuskepegawaian=y.kdkepegawaian
	    where coalesce(statuskepegawaian,'') != 'KO' and valueday<=120 and y.status='B' order by y.duedate_ojt desc");
    }

        function q_list_ojt2($param = null)
    {
        return $this->db->query("SELECT *,  
                CASE 
                WHEN DATE_PART('day', valueday) < 0 THEN 
                    'TERLEWAT ' || (DATE_PART('day', valueday) * -1)::text || ' HARI'
                WHEN DATE_PART('day', valueday) = 0 THEN 
                    'PAS HARI INI'
                WHEN DATE_PART('day', valueday) > 0 THEN 
                    'KURANG ' || DATE_PART('day', valueday)::text || ' HARI LAGI'
                ELSE '' 
                END AS eventketerangan
            FROM sc_mst.lv_m_karyawan x
            LEFT OUTER JOIN (
                SELECT a.*, b.nmkepegawaian,
                CASE 
                WHEN posisi = 'D' THEN (tgl_mulai + INTERVAL '90 day') - CURRENT_DATE
                WHEN posisi = 'C' THEN (tgl_mulai + INTERVAL '150 day') - CURRENT_DATE
                ELSE NULL  -- Or another default logic
                END AS valueday,
                CASE
                WHEN posisi = 'D' THEN (tgl_mulai + INTERVAL '90 day')::date 
                WHEN posisi = 'C' THEN (tgl_mulai + INTERVAL '150 day')::date 
                ELSE NULL  -- Or another default logic
                END AS tgl_ojt
                FROM (
                SELECT a.*,c.lvl_jabatan as posisi
                FROM sc_trx.status_kepegawaian a
                JOIN (
                    SELECT a.nik, a.kdkepegawaian, MAX(nodok) AS nodok 
                    FROM sc_trx.status_kepegawaian a
                    GROUP BY nik, kdkepegawaian
                ) b ON a.nik = b.nik AND a.kdkepegawaian = b.kdkepegawaian AND a.nodok = b.nodok
                JOIN sc_mst.karyawan c on a.nik = c.nik
                ) a
                LEFT OUTER JOIN sc_mst.status_kepegawaian b ON a.kdkepegawaian = b.kdkepegawaian
            ) y ON x.nik = y.nik AND x.statuskepegawaian = y.kdkepegawaian
            WHERE 
                coalesce(x.statuskepegawaian, '') != 'KO'
                AND y.status = 'B'
                AND  
                (x.lvl_jabatan = 'D' AND EXTRACT(DAY FROM valueday) <= 90  AND y.ojt = 'T')
                OR 
                (x.lvl_jabatan = 'C' AND EXTRACT(DAY FROM valueday) <= 150 AND y.ojt = 'T' )
                
            ORDER BY valueday ASC;
            ");
    }

    function q_list_magang($param = null)
    {
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

    function q_recent_employee_activities($day)
    {
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

    function q_transaction_read($where)
    {
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_trx.status_kepegawaian');
    }

    function q_transaction_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.status_kepegawaian', $value);
    }

    function q_transaction_select($select, $where)
    {
        return $this->db
            ->select($select)
            ->where($where)
            ->get('sc_trx.status_kepegawaian');
    }

    function q_transaction_read_where($clause = null)
    {
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null)
    {
        $this->db->query('set lc_time = \'ID\' ');
        return sprintf(
            <<<'SQL'
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
    COALESCE(TRIM(c.status), '') AS status,
    COALESCE(TRIM(a.status), '') AS contract_status,
    COALESCE(TRIM(b.nmkepegawaian), '') AS nmkepegawaian,
    COALESCE(TRIM(c.nmlengkap), '') AS nmlengkap,
    to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
    to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,
    to_char(a.tgl_mulai,'yyyymm') AS filterstart,
    to_char(a.tgl_selesai,'yyyymm') AS filterend,
    d.uraian as nmstatus,
    COALESCE(TRIM(e.nmdept), '') AS deptname,
    COALESCE(TRIM(f.nmsubdept), '') AS subdeptname,
    COALESCE(TRIM(g.nmjabatan), '') AS positionname,
    COALESCE(TRIM(c.statuskepegawaian), '') AS statuskepegawaian,
    CASE
        when tgl_selesai is null THEN concat(to_char(tgl_mulai,'FMDD Mon YYYY') )
        ELSE concat(to_char(tgl_mulai,'FMDD Mon YYYY') ||' - '||to_char(tgl_selesai,'FMDD Mon YYYY'))
    END as period,
    CASE
        when tgl_selesai is null THEN concat(to_char(c.tglmasukkerja,'FMDD Mon '),to_char(now(),'YY'))
        ELSE to_char(tgl_selesai,'FMDD Mon YYYY')
    END as leave_limit,
    c.tglkeluarkerja AS tglkeluarkerja
from sc_trx.status_kepegawaian a
         left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
         left outer join sc_mst.karyawan c on a.nik=c.nik
         left outer join sc_mst.trxtype d on c.status=d.kdtrx and d.jenistrx='STSPEG'
         LEFT OUTER JOIN sc_mst.departmen e ON c.bag_dept = e.kddept
         LEFT OUTER JOIN sc_mst.subdepartmen f ON c.bag_dept = e.kddept AND c.subbag_dept = f.kdsubdept
         LEFT OUTER JOIN sc_mst.jabatan g ON TRIM(c.bag_dept) = TRIM(e.kddept) AND TRIM(c.subbag_dept) = TRIM(f.kdsubdept) AND TRIM(c.jabatan) = TRIM(g.kdjabatan)
order by b.nmkepegawaian asc
) as aa
WHERE TRUE 
SQL
        ) . $clause;
    }


    function q_spv($param = '')
    {
        return $this->db->query("select nmlengkap,jabatan,alamatktp,nmjabatan
    from (
            select * from sc_mst.karyawan a left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan
        ) x
        where true
            $param ");
    }

    function q_kar($nik, $nodok)
    {
        return $this->db->query("with data as (select a.nik,a.nmlengkap,
                     case when a.jk = trim('L') then 'Laki-laki'::text else 'Perempuan'::text end as jk,
                     trim(c.namakotakab) as tmptlahir,
                     a.tgllahir,
                     a.noktp,
                     a.tglmasukkerja,
                     d.nmagama,
                     coalesce(a.alamatktp, '-') as alamatktp,
                     g.nmnikah,
                     e.nmjabatan,
                     e.jabatan_cetak,
                     f.nmdept,
                     f.dept_cetak,
                     b.nodok,
                     b.kdkepegawaian,
                     b.tgl_mulai,
		             b.tgl_selesai,
                     j.nmkepegawaian,
                     h.nmlengkap as nmatasan,
                     i.nmlengkap as nmatasan2,
                     sb.nmsubdept,
                REPLACE(
            REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(k.masakerja1::text,
                    'years', 'tahun'),
                    'year', 'tahun'),
                    'mons', 'bulan'),
                    'mon', 'bulan'),
                'days', 'hari'),
                'day', 'hari') as masakerja,
                l.kdpendidikan as pendidikan,
                        to_char(now(), 'yyyy-mm-dd') as tgl_cetak,
                        ROW_NUMBER() OVER (ORDER BY b.kdkepegawaian)
                from sc_mst.karyawan a
                        right outer join sc_trx.status_kepegawaian b on a.nik = b.nik
                        left outer join sc_mst.kotakab c on a.kotalahir = c.kodekotakab
                        left outer join sc_mst.agama d on a.kd_agama = d.kdagama
                        left outer join sc_mst.jabatan e on a.jabatan = e.kdjabatan
                        left outer join sc_mst.departmen f on a.bag_dept = f.kddept
                        left outer join sc_mst.status_nikah g on a.status_pernikahan = g.kdnikah
                        LEFT OUTER JOIN sc_mst.karyawan h ON a.nik_atasan = h.nik
                        LEFT OUTER JOIN sc_mst.karyawan i ON a.nik_atasan2 = i.nik
                        LEFT OUTER JOIN sc_mst.status_kepegawaian j ON b.kdkepegawaian = j.kdkepegawaian
                        LEFT OUTER JOIN sc_mst.lv_m_karyawan k ON a.nik = k.nik
                        LEFT OUTER JOIN sc_mst.subdepartmen sb ON k.subbag_dept = sb.kdsubdept
                        LEFT JOIN (
                        SELECT *
                            FROM (
                                SELECT nik,kdpendidikan,
                                ROW_NUMBER() OVER (
                                    PARTITION BY nik
                                    ORDER BY 
                                    CASE kdpendidikan
                                    WHEN 'SD' THEN 1
                                    WHEN 'SMP' THEN 2
                                    WHEN 'SMA' THEN 3
                                    WHEN 'D1' THEN 4
                                    WHEN 'D2' THEN 5
                                    WHEN 'D3' THEN 6
                                    WHEN 'S1' THEN 7
                                    WHEN 'S2' THEN 8
                                    WHEN 'S3' THEN 9
                                    ELSE 0
                                    END DESC
                                ) AS rn
                                FROM sc_trx.riwayat_pendidikan
                                ) sub
                            WHERE rn = 1 
                    ) l ON a.nik = l.nik
                where a.nik = '$nik' 
                )
                select *
                from data 
                where nodok='$nodok'
                 limit 1");
    }

    function insert_stspeg_document($nodok, $uniquekey)
    {
        if (
            $this->db
                ->where('nodok', $nodok)
                ->count_all_results('sc_trx.status_kepegawaian_document') > 0
        ) {
            return $this->db
                ->where('nodok', $nodok)
                ->update(
                    'sc_trx.status_kepegawaian_document',
                    [
                        'uniquekey' => $uniquekey,
                        'update_date' => date('Y-m-d H:i:s'),
                        'update_by' => $this->session->userdata('nik'),
                        'status' => 'input',
                    ]
                );
        } else {
            return $this->db
                ->insert(
                    'sc_trx.status_kepegawaian_document',
                    [
                        'nodok' => $nodok,
                        'uniquekey' => $uniquekey,
                        'input_date' => date('Y-m-d H:i:s'),
                        'input_by' => $this->session->userdata('nik'),
                        'status' => 'input',
                    ]
                );
        }
    }

    function transaction_document_read($clause = null)
    {
        $this->db->query("
            SELECT * FROM sc_trx.status_kepegawaian_document
        ".$clause);
    }

    function transaction_document_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.status_kepegawaian_document')
                ->num_rows() > 0;
    }

    function update_stspeg_document($nodok, $data)
    {
        if (
            $this->db
                ->where('nodok', $nodok)
                ->count_all_results('sc_trx.status_kepegawaian_document') > 0
        ) {
            $this->db
                ->where('nodok', $nodok)
                ->update(
                    'sc_trx.status_kepegawaian_document',
                    $data
                );
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    function stspeg_document_exist($nodok)
    {
        if (
            $this->db
                ->where('nodok', $nodok)
                ->where('file IS NOT NULL')
                ->count_all_results('sc_trx.status_kepegawaian_document') > 0
        ) {
            return true;
        }
        return false;
    }

    function get_stspeg_document_key_pages($nodok, $uniquekey, $pages)
    {
        $query = $this->db
            ->where(['nodok' => $nodok, 'uniquekey' => $uniquekey, 'pages' => $pages])
            ->get('sc_trx.status_kepegawaian_document');

        return $query->num_rows() > 0;
    }

    function insert_log_document_download($nodok)
    {
        $nik = $this->session->userdata('nik');
        $this->db->insert('sc_log.document_download', [
            'nodok' => $nodok,
            'download_by' => $nik,
            'document_type' => 'contract',
            'download_date' => date('Y-m-d H:i:s'),
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    
}
