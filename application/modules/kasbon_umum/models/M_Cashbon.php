<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Cashbon extends CI_Model {
    function q_temporary_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_tmp.cashbon')
                ->num_rows() > 0;
    }
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.cashbon')
                ->num_rows() > 0;
    }
    function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.cashbon', $value);
    }
    function q_temporary_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.cashbon', $value);
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.cashbon', $value);
    }
    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.cashbon');
    }
    function q_temporary_delete_new($cashbonid, $updateby, $dutieid){
        $getdetail = $this->db->query("
            select *
            from sc_tmp.cashbon a
            left join sc_tmp.cashbon_component b on a.cashbonid = b.cashbonid
            where true
                and a.dutieid = '$dutieid'
        ")->row();
        if ($getdetail){
            $deldetail = $this->db
                ->where('cashbonid',$cashbonid)
                ->or_where('updateby',$updateby)
                ->delete('sc_tmp.cashbon_component');
        }
        if ($deldetail) {
            return $this->db
                ->where('TRUE AND cashbonid = \'' . $cashbonid . '\' OR updateby = \'' . $updateby . '\' ')
                ->delete('sc_tmp.cashbon');
        }
    }

    function q_cashbon_read_where($clause = null){
        return $this->db->query($this->q_cashbon_txt_where($clause));
    }

    function q_cashbon_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
SELECT
    COALESCE(TRIM(b.branch), '') AS branch,
    COALESCE(TRIM(a.nodok), '') AS dutieid,
    a.tgl_mulai AS departuredate,
    a.tgl_selesai AS returndate,
    CONCAT(TO_CHAR(a.tgl_mulai, 'dd-mm-yyyy'), ', ', TO_CHAR(a.tgl_selesai, 'dd-mm-yyyy')) AS dutieperiod,
    COALESCE(TRIM(c.nik), '') AS employeeid,
    COALESCE(TRIM(c.nmlengkap), '') AS employeename,
    COALESCE(TRIM(d.nmdept), '') AS departmentname,
    COALESCE(TRIM(e.nmsubdept), '') AS subdepartmentname,
    COALESCE(TRIM(b.cashbonid), '') AS cashbonid,
    COALESCE(TRIM(b.approveby), '') AS approveby,
    b.approvedate AS approvedate,
    CASE
        WHEN b.branch IS NULL THEN 'Belum Dibuat Kasbon'
        WHEN COALESCE(b.status, '') IN ('I') THEN 'Menunggu Persetujuan'
        WHEN b.approveby IS NOT NULL AND b.approveby IS NOT NULL THEN 'Disetujui'
        ELSE 'Kondisi Lain'
    END AS statustext,
    CONCAT(COALESCE(TRIM(c.nik), ''), '.', COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), ''), '.') AS search
FROM sc_trx.dinas a
LEFT OUTER JOIN sc_trx.cashbon b ON TRUE
AND TRIM(b.dutieid) = TRIM(a.nodok)
LEFT OUTER JOIN sc_mst.karyawan c ON TRUE
AND TRIM(c.nik) = TRIM(a.nik)
LEFT OUTER JOIN sc_mst.departmen d ON TRUE
AND TRIM(d.kddept) = TRIM(c.bag_dept)
LEFT OUTER JOIN sc_mst.subdepartmen e ON TRUE
AND TRIM(e.kdsubdept) = TRIM(c.subbag_dept)
AND TRIM(e.kddept) = TRIM(c.bag_dept)
WHERE TRUE 
AND COALESCE(TRIM(a.status), '') IN ('P')
AND COALESCE(TRIM(a.nodok), '') NOT IN ( SELECT dutieid FROM sc_trx.declaration_cashbon WHERE TRUE AND COALESCE(TRIM(cashbonid), '') = '' )
ORDER BY cashbonid
) as aa
WHERE TRUE
SQL
            ).$clause;
    }

    function q_dutie_read_where($clause = null){
        return $this->db->query($this->q_dutie_txt_where($clause));
    }



    function q_dutie_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
SELECT
    COALESCE(TRIM(b.branch), '') AS branch,
    COALESCE(TRIM(a.nodok), '') AS dutieid,
    a.tgl_mulai AS departuredate,
    a.tgl_selesai AS returndate,
    CONCAT(TO_CHAR(a.tgl_mulai, 'dd-mm-yyyy'), ', ', TO_CHAR(a.tgl_selesai, 'dd-mm-yyyy')) AS dutieperiod,
    COALESCE(TRIM(c.nik), '') AS employeeid,
    COALESCE(TRIM(c.nmlengkap), '') AS employeename,
    COALESCE(TRIM(d.nmdept), '') AS departmentname,
    COALESCE(TRIM(e.nmsubdept), '') AS subdepartmentname,
    COALESCE(TRIM(b.cashbonid), '') AS cashbonid,
    COALESCE(TRIM(b.approveby), '') AS approveby,
    b.approvedate AS approvedate,
    CASE
        WHEN b.branch IS NULL THEN 'Belum Dibuat Kasbon'
        WHEN COALESCE(b.status, '') IN ('I') THEN 'Menunggu Persetujuan'
        WHEN b.approveby IS NOT NULL AND b.approveby IS NOT NULL THEN 'Disetujui'
        ELSE 'Kondisi Lain'
    END AS statustext,
    CONCAT(COALESCE(TRIM(c.nik), ''), '.', COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), ''), '.') AS search
FROM sc_trx.dinas a
LEFT OUTER JOIN sc_trx.cashbon b ON TRUE
AND TRIM(b.dutieid) = TRIM(a.nodok)
LEFT OUTER JOIN sc_mst.karyawan c ON TRUE
AND TRIM(c.nik) = TRIM(a.nik)
LEFT OUTER JOIN sc_mst.departmen d ON TRUE
AND TRIM(d.kddept) = TRIM(c.bag_dept)
LEFT OUTER JOIN sc_mst.subdepartmen e ON TRUE
AND TRIM(e.kdsubdept) = TRIM(c.subbag_dept)
AND TRIM(e.kddept) = TRIM(c.bag_dept)
WHERE TRUE 
AND COALESCE(TRIM(a.status), '') IN ('P')
AND COALESCE(TRIM(a.nodok), '') NOT IN ( SELECT dutieid FROM sc_trx.declaration_cashbon WHERE TRUE AND COALESCE(TRIM(cashbonid), '') = '' )
ORDER BY cashbonid
) as aa
WHERE TRUE
SQL
            ).$clause;
    }
    function q_temporary_read_where($clause = null){
        return $this->db->query($this->q_temporary_txt_where($clause));
    }
    function q_temporary_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
    SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat
FROM (
SELECT 
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
    COALESCE(TRIM(a.dutieid), '') AS dutieid,
    COALESCE(TRIM(a.superior), '') AS superior,
    COALESCE(TRIM(a.status), '') AS status,
    COALESCE(TRIM(a.paymenttype), '') AS paymenttype,
    COALESCE(TRIM(a.type), '') AS type,
    COALESCE(TRIM(d.uraian), '') AS typetext,
    a.totalcashbon AS totalcashbon,
    COALESCE(TRIM(a.inputby), '') AS inputby,
    a.inputdate AS inputdate,
    COALESCE(TRIM(a.updateby), '') AS updateby,
    a.updatedate AS updatedate,
    COALESCE(TRIM(a.approveby), '') AS approveby,
    a.approvedate AS approvedate,
    CONCAT(COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), '')) AS superiors
FROM sc_tmp.cashbon a
LEFT OUTER JOIN sc_trx.dinas b ON TRUE
AND TRIM(b.nodok) = TRIM(a.dutieid)
LEFT OUTER JOIN sc_mst.karyawan c ON TRUE
AND TRIM(c.nik) = TRIM(b.nik)
LEFT OUTER JOIN sc_mst.trxtype d ON a.type = d.kdtrx AND jenistrx = 'CASHBONTYPE'
ORDER BY cashbonid
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }

    function q_transaction_read_where($clause = null){
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
       SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat,
       case
           when statuscode = 0 then 'label-warning'
           when statuscode = 1 then 'label-success'
           when statuscode = 2 then 'label-danger'
           else 'label-info'
        end as statuscolor
FROM (
         SELECT
             COALESCE(TRIM(c.nik), '') AS nik,
             COALESCE(TRIM(a.employeeid), '') AS employeeid,
             COALESCE(TRIM(c.nmlengkap), '') AS nmlengkap,
             COALESCE(TRIM(a.branch), '') AS branch,
             COALESCE(TRIM(d.nmdept), '') AS nmdept,
             COALESCE(TRIM(e.nmsubdept), '') AS nmsubdept,
             COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
             COALESCE(TRIM(a.dutieid), '') AS dutieid,
             COALESCE(TRIM(a.dutieid), '') AS docno,
             COALESCE(TRIM(a.type), '') AS type,
             COALESCE(TRIM(f.uraian), '') AS formattype,
             COALESCE(TRIM(a.superior), '') AS superior,
             COALESCE(TRIM(a.status), '') AS status,
             COALESCE(TRIM(a.paymenttype), '') AS paymenttype,
             COALESCE(UPPER(TRIM(g.uraian)), '') AS formatpaymenttype,
             a.totalcashbon AS totalcashbon,
             COALESCE(TRIM(a.inputby), '') AS inputby,
             a.inputdate AS inputdate,
             COALESCE(TRIM(a.updateby), '') AS updateby,
             a.updatedate AS updatedate,
             COALESCE(TRIM(a.approveby), '') AS approveby,
             a.approvedate AS approvedate,
             CASE
                 WHEN COALESCE(a.status, '') IN ('I') THEN 'Menunggu Persetujuan'
                 WHEN a.approveby IS NOT NULL AND a.approveby IS NOT NULL THEN 'Disetujui'
                 WHEN COALESCE(a.status, '') IN ('C') THEN 'Dibatalkan'
                 ELSE 'Kondisi Lain'
                 END AS statustext,
             CASE
                 WHEN COALESCE(a.status, '') IN ('I') THEN 0
                 WHEN a.approveby IS NOT NULL AND a.approveby IS NOT NULL THEN 1
                 WHEN COALESCE(a.status, '') IN ('C') THEN 2
                 ELSE 99
                 END AS statuscode,
             CONCAT(COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), '')) AS superiors,
             CONCAT(COALESCE(TRIM(c.nik), ''), '.', COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), ''), '.') AS search
         FROM sc_trx.cashbon a
                  LEFT OUTER JOIN sc_trx.dinas b ON TRUE AND TRIM(b.nodok) = split_part(a.dutieid,',',1)
                  LEFT OUTER JOIN sc_mst.karyawan c ON TRUE AND TRIM(c.nik) = TRIM(b.nik) OR TRIM(c.nik) = TRIM(a.dutieid)
                  LEFT OUTER JOIN sc_mst.departmen d ON TRUE AND TRIM(d.kddept) = TRIM(c.bag_dept)
                  LEFT OUTER JOIN sc_mst.subdepartmen e ON TRUE AND TRIM(e.kdsubdept) = TRIM(c.subbag_dept)
                  LEFT OUTER JOIN sc_mst.trxtype f ON TRUE AND TRIM(a.type) = TRIM(f.kdtrx) AND TRIM(f.jenistrx) = 'CASHBONTYPE'
                  LEFT OUTER JOIN sc_mst.trxtype g ON TRUE AND TRIM(a.paymenttype) = TRIM(g.kdtrx) AND TRIM(g.jenistrx) = 'PAYTYPE'
         WHERE TRUE
         AND COALESCE(TRIM(a.dutieid), '') NOT IN ( SELECT dutieid FROM sc_trx.declaration_cashbon WHERE TRUE AND COALESCE(TRIM(cashbonid), '') = '' )
         ORDER BY cashbonid
         
     ) as aa
WHERE TRUE 
SQL
            ).$clause;
    }

}
