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
    AND TRIM(b.nodok) IN (select UNNEST(STRING_TO_ARRAY(a.dutieid, ',')))
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(b.tgl_mulai::DATE, b.tgl_selesai::DATE, '1 DAY') AS day
    ) c ON TRUE 
    ORDER BY c.day 
) AS a WHERE TRUE 
SQL
            ).$clause);
    }

    function q_days_create_read_where($clause = null){
        return $this->db->query(sprintf(<<<'SQL'
SELECT * FROM (
      SELECT
          a.branch,
          COALESCE(TRIM(a.dutieid), '') AS dutieid,
          COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
          c.day::DATE,
          TO_CHAR(c.day, 'dd-mm-yyyy') AS dayformat
      FROM sc_trx.cashbon a 
          AND a.status <> 'C'
               LEFT JOIN LATERAL (
          SELECT GENERATE_SERIES(a.inputdate::DATE, a.inputdate::DATE, '1 DAY') AS day
          ) c ON TRUE
      ORDER BY c.day
  ) AS a WHERE TRUE 
SQL
            ).$clause);
    }

    function q_index_read_where($clause = null){
        return $this->db->query($this->q_index_txt_where($clause));
    }
    function q_index_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
       TO_CHAR(documentdate, 'dd-mm-yyyy') AS documentdateformat,
       CASE
           WHEN statustext = 'Disetujui' THEN 'label-success'
           WHEN statustext = 'Kondisi Lain' THEN 'label-danger'
           ELSE 'label-warning'
           END AS statuscolor
FROM (
         SELECT distinct ON (declarationid)
             COALESCE(TRIM(a.branch), '') AS branch,
             COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
             COALESCE(TRIM(g.uraian), 'TANPA KASBON') AS typetext,
             COALESCE(TRIM(d.nik), '') AS employeeid,
             COALESCE(TRIM(d.nmlengkap), '') AS employeename,
             COALESCE(TRIM(e.nmdept), '') AS departmentname,
             COALESCE(TRIM(f.nmsubdept), '') AS subdepartmentname,
             COALESCE(TRIM(a.declarationid), '') AS declarationid,
             COALESCE(TRIM(a.approveby), '') AS approveby,
             a.approvedate AS approvedate,
             CASE
                 WHEN COALESCE(a.status, '') IN ('I') THEN 'Menunggu Persetujuan'
                 WHEN COALESCE(a.status, '') IN ('C') THEN 'Dibatalkan'
                 WHEN a.approveby IS NOT NULL AND a.approveby IS NOT NULL THEN 'Disetujui'
                 ELSE 'Kondisi Lain'
             END AS statustext,
             CASE
                WHEN substring(a.dutieid,1,2) = 'DL' THEN 'DN'
                ELSE '-'
             END AS type,
             COALESCE(TRIM(a.declarationid), '') AS documentid,
             'DECLARATION'::TEXT  AS category,
             a.inputdate AS documentdate,
             CONCAT(COALESCE(TRIM(d.nik), ''), '.', COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), ''), '.') AS search
         FROM sc_trx.declaration_cashbon a
                  LEFT OUTER JOIN sc_trx.cashbon c ON TRIM(c.cashbonid) = TRIM(a.cashbonid)
                  LEFT OUTER JOIN sc_mst.karyawan d ON (TRIM(d.nik) = TRIM(a.employeeid) )
                  LEFT OUTER JOIN sc_mst.departmen e ON TRIM(e.kddept) = TRIM(d.bag_dept)
                  LEFT OUTER JOIN sc_mst.subdepartmen f ON TRIM(f.kdsubdept) = TRIM(d.subbag_dept) AND TRIM(f.kddept) = TRIM(d.bag_dept)
                  LEFT OUTER JOIN sc_mst.trxtype g ON TRIM(g.kdtrx) = TRIM(COALESCE(c.type, ''))
             AND TRIM(g.jenistrx) = TRIM('CASHBONTYPE')
         WHERE COALESCE(a.status, '') IN ('I', 'C') OR a.approveby IS NOT NULL
         ORDER BY declarationid
     ) AS aa
WHERE TRUE
SQL
            ).$clause;
    }

    function q_cashbon_read_where($clause = null){
        return $this->db->query($this->q_cashbon_txt_where($clause));
    }
    function q_cashbon_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
       TO_CHAR(documentdate, 'dd-mm-yyyy') AS documentdateformat,
       CASE
           WHEN statustext = 'Disetujui' THEN 'label-success'
           WHEN statustext = 'Kondisi Lain' THEN 'label-danger'
           ELSE 'label-warning'
           END AS statuscolor
FROM (
         SELECT distinct ON (declarationid)
             COALESCE(TRIM(a.branch), '') AS branch,
             CASE
                 WHEN b.nodok is not null THEN COALESCE(TRIM(a.dutieid), '')
                 WHEN COALESCE(TRIM(c.type), '') = 'DN' THEN COALESCE(TRIM(a.dutieid), '')
                 ELSE COALESCE(TRIM(d.nik), '')
             END AS dutieid,
             COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
             CASE
                 WHEN b.nodok is not null THEN 'DN'
                 ELSE COALESCE(TRIM(c.type), '')
                 END AS type,
             COALESCE(TRIM(g.uraian), 'TANPA KASBON') AS typetext,
             COALESCE(TRIM(d.nik), '') AS employeeid,
             COALESCE(TRIM(d.nmlengkap), '') AS employeename,
             COALESCE(TRIM(e.nmdept), '') AS departmentname,
             COALESCE(TRIM(f.nmsubdept), '') AS subdepartmentname,
             COALESCE(TRIM(a.declarationid), '') AS declarationid,
             COALESCE(TRIM(a.approveby), '') AS approveby,
             a.approvedate AS approvedate,
             CASE
                 WHEN COALESCE(a.status, '') IN ('I') THEN 'Menunggu Persetujuan'
                 WHEN COALESCE(a.status, '') IN ('C') THEN 'Dibatalkan'
                 WHEN a.approveby IS NOT NULL AND a.approveby IS NOT NULL THEN 'Disetujui'
                 ELSE 'Kondisi Lain'
                 END AS statustext,
             COALESCE(TRIM(a.declarationid), '') AS documentid,
             'DECLARATION'::TEXT  AS category,
             a.inputdate AS documentdate,
             CONCAT(COALESCE(TRIM(d.nik), ''), '.', COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), ''), '.') AS search
         FROM sc_trx.declaration_cashbon a
                  LEFT OUTER JOIN sc_trx.dinas b ON TRIM(b.nodok) = ANY(string_to_array(a.dutieid, ','))
                  LEFT OUTER JOIN sc_trx.cashbon c ON TRIM(c.cashbonid) = TRIM(a.cashbonid)
                  LEFT OUTER JOIN sc_mst.karyawan d ON (TRIM(d.nik) = TRIM(b.nik) )
                  LEFT OUTER JOIN sc_mst.departmen e ON TRIM(e.kddept) = TRIM(d.bag_dept)
                  LEFT OUTER JOIN sc_mst.subdepartmen f ON TRIM(f.kdsubdept) = TRIM(d.subbag_dept) AND TRIM(f.kddept) = TRIM(d.bag_dept)
                  LEFT OUTER JOIN sc_mst.trxtype g ON TRIM(g.kdtrx) = TRIM(COALESCE(c.type, ''))
             AND TRIM(g.jenistrx) = TRIM('CASHBONTYPE')
         WHERE COALESCE(a.status, '') IN ('I', 'C') OR a.approveby IS NOT NULL
         ORDER BY declarationid
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
    COALESCE(TRIM(b.status), '') AS cashbonstatus,
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
    TO_CHAR(documentdate, 'dd-mm-yyyy') AS documentdateformat,
    CASE 
           WHEN statustext = 'Disetujui' THEN 'label-success'
           WHEN statustext = 'Kondisi Lain' THEN 'label-danger'
           ELSE 'label-warning'
    END AS statuscolor,
    SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat,
    SPLIT_PART(REGEXP_REPLACE(totaldeclaration::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totaldeclarationformat,
    SPLIT_PART(REGEXP_REPLACE(returnamount::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS returnamountformat
FROM (
SELECT
             COALESCE(TRIM(a.declarationid), '') AS documentid,
             COALESCE(TRIM(a.branch), '') AS branch,
             COALESCE(TRIM(d.nik), '') AS employeeid,
             COALESCE(TRIM(d.nik), '') AS nik,
             COALESCE(TRIM(d.nmlengkap), '') AS employeename,
             COALESCE(TRIM(a.declarationid), '') AS declarationid,
             COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
             COALESCE(TRIM(a.dutieid), '') AS dutieid,
             COALESCE(TRIM(e.nmdept),'') AS departmentname,
             COALESCE(TRIM(f.nmsubdept),'') AS subdepartmentname,
             COALESCE(TRIM(g.nmjabatan),'') AS positionname,
             COALESCE(TRIM(a.superior), '') AS superior,
             COALESCE(TRIM(a.status), '') AS status,
             CASE
                WHEN COALESCE(a.status, '') IN ('I') THEN 'Menunggu Persetujuan'
                WHEN COALESCE(a.status, '') IN ('C') THEN 'Dibatalkan'
                WHEN COALESCE(a.status, '') IN ('P') THEN 'Disetujui'
             ELSE 'Kondisi Lain'
             END AS statustext,
             CASE
                 WHEN c.nodok is not null THEN 'DN'
                 WHEN b.cashbonid is not null THEN 'CB'
                 ELSE 'DC'
             END AS d_type,
             CASE
                 WHEN b.cashbonid is not null THEN 'CASHBON'
                 ELSE 'DECLARATION'
             END AS d_type_text,
             COALESCE(TRIM(b.type), 'DI') AS type,
             COALESCE(TRIM(g.uraian), 'TANPA KASBON') AS typetext,
             a.totalcashbon AS totalcashbon,
             a.totaldeclaration AS totaldeclaration,
             a.returnamount AS returnamount,
             COALESCE(TRIM(a.inputby), '') AS inputby,
             a.inputdate AS inputdate,
             a.inputdate AS documentdate,
             COALESCE(TRIM(a.updateby), '') AS updateby,
             a.updatedate AS updatedate,
             COALESCE(TRIM(a.approveby), '') AS approveby,
             a.approvedate AS approvedate,
             CONCAT(COALESCE(TRIM(d.nik_atasan), ''), '.', COALESCE(TRIM(d.nik_atasan2), '')) AS superiors
         FROM sc_trx.declaration_cashbon a
            LEFT OUTER JOIN sc_trx.cashbon b ON TRUE AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
            LEFT OUTER JOIN sc_trx.dinas c ON TRUE AND TRIM(c.nodok) = TRIM(b.dutieid) OR TRIM(c.nodok) = ANY(string_to_array(a.dutieid, ','))
            LEFT OUTER JOIN sc_mst.karyawan d ON TRUE AND TRIM(d.nik) = TRIM(c.nik)
            LEFT OUTER JOIN sc_mst.departmen e ON trim(d.bag_dept) = trim(e.kddept)
            LEFT OUTER JOIN sc_mst.subdepartmen f ON trim(d.bag_dept) = trim(f.kddept) AND trim(d.subbag_dept) = trim(f.kdsubdept)
            LEFT OUTER JOIN sc_mst.jabatan g ON trim(d.bag_dept) = trim(g.kddept) AND trim(d.subbag_dept) = trim(g.kdsubdept) AND trim(g.kdjabatan) = trim(d.jabatan)
            LEFT OUTER JOIN sc_mst.trxtype h ON TRUE AND TRIM(h.kdtrx) = TRIM(b.type) AND TRIM(h.jenistrx) = TRIM('CASHBONTYPE')
         ORDER BY cashbonid
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }
}
