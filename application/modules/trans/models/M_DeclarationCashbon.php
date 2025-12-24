<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_DeclarationCashbon extends CI_Model {
    function q_temporary_exists($where){
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_tmp.declaration_cashbon')
            ->num_rows() > 0;
    }
    function q_transaction_exists($where){
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_trx.declaration_cashbon')
            ->num_rows() > 0;
    }
    function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.declaration_cashbon', $value);
    }
    function q_temporary_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.declaration_cashbon', $value);
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.declaration_cashbon', $value);
    }
    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.declaration_cashbon');
    }
    function q_days_read_where($clause = null){
        return $this->db->query(sprintf(<<<'SQL'
SELECT * FROM (
    SELECT
        a.branch,
        COALESCE(TRIM(b.nodok), '') AS dutieid,
        COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
        c.day::DATE,
        TO_CHAR(c.day, 'dd-mm-yyyy') AS dayformat
    FROM sc_trx.dinas b
    LEFT JOIN sc_trx.cashbon a ON TRUE
    AND TRIM(b.nodok) = TRIM(a.dutieid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(b.tgl_mulai::DATE, b.tgl_selesai::DATE, '1 DAY') AS day
    ) c ON TRUE 
    ORDER BY c.day 
) AS a WHERE TRUE 
SQL
            ).$clause);
    }
    function q_cashbon_read_where($clause = null){
        return $this->db->query($this->q_cashbon_txt_where($clause));
    }
    function q_cashbon_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
    TO_CHAR(documentdate, 'dd-mm-yyyy') AS documentdateformat
FROM (
    (
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(a.dutieid), '') AS dutieid,
        COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
        b.tgl_mulai AS departuredate,
        b.tgl_selesai AS returndate,
        CONCAT(TO_CHAR(b.tgl_mulai, 'dd-mm-yyyy'), ', ', TO_CHAR(b.tgl_selesai, 'dd-mm-yyyy')) AS dutieperiod,
        COALESCE(TRIM(d.nik), '') AS employeeid,
        COALESCE(TRIM(d.nmlengkap), '') AS employeename,
        COALESCE(TRIM(e.nmdept), '') AS departmentname,
        COALESCE(TRIM(f.nmsubdept), '') AS subdepartmentname,
        COALESCE(TRIM(a.declarationid), '') AS declarationid,
        COALESCE(TRIM(a.approveby), '') AS approveby,
        a.approvedate AS approvedate,
        CASE
        WHEN COALESCE(a.status, '') IN ('I') THEN 'Menunggu Persetujuan'
        WHEN a.approveby IS NOT NULL AND a.approveby IS NOT NULL THEN 'Disetujui'
        ELSE 'Kondisi Lain'
        END AS statustext,
        COALESCE(TRIM(a.declarationid), '') AS documentid,
        a.inputdate AS documentdate,
        CONCAT(COALESCE(TRIM(d.nik), ''), '.', COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), ''), '.') AS search
    FROM sc_trx.declaration_cashbon a
    LEFT OUTER JOIN sc_trx.dinas b ON TRUE
    AND TRIM(b.nodok) = TRIM(a.dutieid)
    LEFT OUTER JOIN sc_trx.cashbon c ON TRUE
    AND TRIM(c.cashbonid) = TRIM(a.cashbonid)
    LEFT OUTER JOIN sc_mst.karyawan d ON TRUE
    AND TRIM(d.nik) = TRIM(b.nik)
    LEFT OUTER JOIN sc_mst.departmen e ON TRUE
    AND TRIM(e.kddept) = TRIM(d.bag_dept)
    LEFT OUTER JOIN sc_mst.subdepartmen f ON TRUE
    AND TRIM(f.kdsubdept) = TRIM(d.subbag_dept)
    AND TRIM(f.kddept) = TRIM(d.bag_dept)
    WHERE TRUE
    ORDER BY declarationid
    ) UNION ALL ( 
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(b.nodok), '') AS dutieid,
        COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
        b.tgl_mulai AS departuredate,
        b.tgl_selesai AS returndate,
        CONCAT(TO_CHAR(b.tgl_mulai, 'dd-mm-yyyy'), ', ', TO_CHAR(b.tgl_selesai, 'dd-mm-yyyy')) AS dutieperiod,
        COALESCE(TRIM(d.nik), '') AS employeeid,
        COALESCE(TRIM(d.nmlengkap), '') AS employeename,
        COALESCE(TRIM(e.nmdept), '') AS departmentname,
        COALESCE(TRIM(f.nmsubdept), '') AS subdepartmentname,
        '' AS declarationid,
        '' AS approveby,
        NULL::TIMESTAMP AS approvedate,
        'Belum Dibuat Deklarasi' AS statustext,
        COALESCE(TRIM(a.cashbonid), '') AS documentid,
        a.inputdate AS documentdate,
        CONCAT(COALESCE(TRIM(d.nik), ''), '.', COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), ''), '.') AS search
    FROM sc_trx.cashbon a
    LEFT OUTER JOIN sc_trx.dinas b ON TRUE
    AND TRIM(b.nodok) = TRIM(a.dutieid)
    LEFT OUTER JOIN sc_mst.karyawan d ON TRUE
    AND TRIM(d.nik) = TRIM(b.nik)
    LEFT OUTER JOIN sc_mst.departmen e ON TRUE
    AND TRIM(e.kddept) = TRIM(d.bag_dept)
    LEFT OUTER JOIN sc_mst.subdepartmen f ON TRUE
    AND TRIM(f.kdsubdept) = TRIM(d.subbag_dept)
    AND TRIM(f.kddept) = TRIM(d.bag_dept)
    WHERE TRUE
    AND COALESCE(TRIM(a.status), '') IN ('P')
    AND COALESCE(TRIM(a.cashbonid), '') NOT IN ( SELECT declaration_cashbon.cashbonid FROM sc_trx.declaration_cashbon )
    ORDER BY declarationid
    ) UNION ALL ( 
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(b.nodok), '') AS dutieid,
        COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
        b.tgl_mulai AS departuredate,
        b.tgl_selesai AS returndate,
        CONCAT(TO_CHAR(b.tgl_mulai, 'dd-mm-yyyy'), ', ', TO_CHAR(b.tgl_selesai, 'dd-mm-yyyy')) AS dutieperiod,
        COALESCE(TRIM(d.nik), '') AS employeeid,
        COALESCE(TRIM(d.nmlengkap), '') AS employeename,
        COALESCE(TRIM(e.nmdept), '') AS departmentname,
        COALESCE(TRIM(f.nmsubdept), '') AS subdepartmentname,
        '' AS declarationid,
        '' AS approveby,
        NULL::TIMESTAMP AS approvedate,
        'Belum Dibuat Kasbon' AS statustext,
        COALESCE(TRIM(b.nodok), '') AS documentid,
        b.input_date AS documentdate,
        CONCAT(COALESCE(TRIM(d.nik), ''), '.', COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), ''), '.') AS search
    FROM sc_trx.dinas b
    LEFT OUTER JOIN sc_trx.cashbon a ON TRUE
    AND TRIM(b.nodok) = TRIM(a.dutieid)
    LEFT OUTER JOIN sc_mst.karyawan d ON TRUE
    AND TRIM(d.nik) = TRIM(b.nik)
    LEFT OUTER JOIN sc_mst.departmen e ON TRUE
    AND TRIM(e.kddept) = TRIM(d.bag_dept)
    LEFT OUTER JOIN sc_mst.subdepartmen f ON TRUE
    AND TRIM(f.kdsubdept) = TRIM(d.subbag_dept)
    AND TRIM(f.kddept) = TRIM(d.bag_dept)
    WHERE TRUE
    AND COALESCE(TRIM(b.status), '') IN ('P')
    AND COALESCE(TRIM(b.nodok), '') NOT IN ( SELECT dutieid FROM sc_trx.cashbon )
    AND COALESCE(TRIM(b.nodok), '') NOT IN ( SELECT dutieid FROM sc_trx.declaration_cashbon )
    )
) AS aa
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
    SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat,
    SPLIT_PART(REGEXP_REPLACE(totaldeclaration::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totaldeclarationformat,
    SPLIT_PART(REGEXP_REPLACE(returnamount::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS returnamountformat
FROM (
SELECT 
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.declarationid), '') AS declarationid,
    COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
    COALESCE(TRIM(a.dutieid), '') AS dutieid,
    COALESCE(TRIM(a.superior), '') AS superior,
    COALESCE(TRIM(a.status), '') AS status,
    a.totalcashbon AS totalcashbon,
    a.totaldeclaration AS totaldeclaration,
    a.returnamount AS returnamount,
    COALESCE(TRIM(a.inputby), '') AS inputby,
    a.inputdate AS inputdate,
    COALESCE(TRIM(a.updateby), '') AS updateby,
    a.updatedate AS updatedate,
    COALESCE(TRIM(a.approveby), '') AS approveby,
    a.approvedate AS approvedate,
    CONCAT(COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), '')) AS superiors
FROM sc_tmp.declaration_cashbon a
LEFT OUTER JOIN sc_trx.cashbon b ON TRUE 
AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
LEFT OUTER JOIN sc_trx.dinas c ON TRUE
AND TRIM(c.nodok) = TRIM(b.dutieid) OR TRIM(c.nodok) = TRIM(a.dutieid)
LEFT OUTER JOIN sc_mst.karyawan d ON TRUE
AND TRIM(d.nik) = TRIM(c.nik)
ORDER BY declarationid
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
    SPLIT_PART(REGEXP_REPLACE(totaldeclaration::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totaldeclarationformat,
    SPLIT_PART(REGEXP_REPLACE(returnamount::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS returnamountformat
FROM (
SELECT 
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.declarationid), '') AS declarationid,
    COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
    COALESCE(TRIM(a.dutieid), '') AS dutieid,
    COALESCE(TRIM(a.superior), '') AS superior,
    COALESCE(TRIM(a.status), '') AS status,
    a.totalcashbon AS totalcashbon,
    a.totaldeclaration AS totaldeclaration,
    a.returnamount AS returnamount,
    COALESCE(TRIM(a.inputby), '') AS inputby,
    a.inputdate AS inputdate,
    COALESCE(TRIM(a.updateby), '') AS updateby,
    a.updatedate AS updatedate,
    COALESCE(TRIM(a.approveby), '') AS approveby,
    a.approvedate AS approvedate,
    CONCAT(COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), '')) AS superiors
FROM sc_trx.declaration_cashbon a
LEFT OUTER JOIN sc_trx.cashbon b ON TRUE 
AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
LEFT OUTER JOIN sc_trx.dinas c ON TRUE
AND TRIM(c.nodok) = TRIM(b.dutieid) OR TRIM(c.nodok) = TRIM(a.dutieid)
LEFT OUTER JOIN sc_mst.karyawan d ON TRUE
AND TRIM(d.nik) = TRIM(c.nik)
ORDER BY cashbonid
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }
}
