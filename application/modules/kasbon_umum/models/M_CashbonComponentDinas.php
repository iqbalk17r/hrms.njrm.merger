<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_CashbonComponentDinas extends CI_Model {
    function q_temporary_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_tmp.cashbon_component')
                ->num_rows() > 0;
    }
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.cashbon_component')
                ->num_rows() > 0;
    }
    function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.cashbon_component', $value);
    }
    function q_temporary_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.cashbon_component', $value);
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.cashbon_component', $value);
    }
    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.cashbon_component');
    }
    function q_empty_read_where($clause = null){
        return $this->db->query($this->q_empty_txt_where($clause));
    }
    function q_empty_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *, 
    SPLIT_PART(REGEXP_REPLACE(nominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nominalformat,
    SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat
FROM (
SELECT
    COALESCE(TRIM(b.branch), '') AS branch,
    COALESCE(TRIM(a.nodok), '') AS dutieid,
    COALESCE(TRIM(a.tipe_transportasi), '') AS transtype,
    COALESCE(TRIM(b.componentid), '') AS componentid,
    COALESCE(TRIM(b.description), '') AS componentname,
    '' AS description,
    COALESCE(TRIM(b.unit), '') AS unit,
    COALESCE(f.nominal, 0) AS nominal,
    c.quantityday + (b.rules) AS quantityday,
    CASE
        WHEN b.multiplication THEN COALESCE(f.nominal, 0) * (c.quantityday + (b.rules))
        ELSE COALESCE(f.nominal, 0)
    END AS totalcashbon,
    COALESCE(TRIM(b.sort), '') AS sort,
    b.calculated AS calculated,
    b.active AS active,
    b.readonly AS readonly,
    b.sort AS sort,
    b.rules AS rules,
    b.multiplication AS multiplication
FROM sc_trx.dinas a
LEFT OUTER JOIN sc_mst.component_cashbon b ON TRUE AND TRIM(b.type) = 'DN'
LEFT JOIN LATERAL (
    SELECT (EXTRACT(EPOCH FROM AGE(a.tgl_selesai, a.tgl_mulai)) / (24 * 60 * 60))::INTEGER + 1 AS quantityday
) AS c ON TRUE
LEFT OUTER JOIN sc_mst.karyawan d ON TRUE
AND TRIM(d.nik) = TRIM(a.nik)
LEFT OUTER JOIN sc_mst.destination_type e ON TRUE
AND TRIM(e.destinationid) = TRIM(a.jenis_tujuan)
LEFT OUTER JOIN sc_mst.jobposition_cashbon f ON TRUE
AND TRIM(f.componentid) = TRIM(b.componentid)
AND TRIM(f.destinationid) = TRIM(e.destinationid)
AND TRIM(f.jobposition) = TRIM(d.lvl_jabatan)
WHERE TRUE
ORDER BY a.nodok ASC ,b.readonly desc, b.sort
) AS a WHERE TRUE AND dutieid IS NOT NULL 
SQL
            ).$clause;
    }
    function q_temporary_read_where($clause = null){
        return $this->db->query($this->q_temporary_txt_where($clause));
    }
    function q_temporary_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *, 
    SPLIT_PART(REGEXP_REPLACE(nominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nominalformat,
    SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat 
FROM (
SELECT
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
--     COALESCE(TRIM(a.dutieid), '') AS dutieid,
    COALESCE(TRIM(b.dutieid), a.dutieid) AS dutieid,
    COALESCE(TRIM(b.componentid), '') AS componentid,
    COALESCE(TRIM(c.description), '') AS componentname,
    b.description AS description,
    b.nominal AS nominal,
    f.lvl_jabatan,
    g.jobposition,
    COALESCE(TRIM(c.unit), '') AS unit,
    e.quantityday + (c.rules) AS quantityday,
    CASE
        WHEN c.multiplication THEN COALESCE(b.nominal, 0) * (e.quantityday + (c.rules))
        ELSE COALESCE(b.nominal, 0)
    END AS totalcashbon,
    COALESCE(TRIM(c.sort), '') AS sort,
    c.calculated AS calculated,
    c.active AS active,
    c.readonly AS readonly,
    c.sort AS sort,
    c.rules AS rules,
    c.multiplication AS multiplication
FROM sc_tmp.cashbon_component b
LEFT OUTER JOIN sc_tmp.cashbon a ON TRUE
AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
LEFT OUTER JOIN sc_mst.component_cashbon c ON TRUE
AND TRIM(c.componentid) = TRIM(b.componentid) AND TRIM(c.type) = 'DN'
LEFT OUTER JOIN sc_trx.dinas d ON TRUE
AND TRIM(d.nodok) = TRIM(b.dutieid)
LEFT JOIN LATERAL (
    SELECT (EXTRACT(EPOCH FROM AGE(d.tgl_selesai, d.tgl_mulai)) / (24 * 60 * 60))::INTEGER + 1 AS quantityday
) AS e ON TRUE
LEFT OUTER JOIN sc_mst.karyawan f ON TRUE
AND TRIM(f.nik) = TRIM(d.nik)
LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
AND TRIM(g.componentid) = TRIM(b.componentid)
AND TRIM(g.jobposition) = TRIM(f.lvl_jabatan)
AND TRIM(g.destinationid) = TRIM(d.tujuan_kota)
ORDER BY b.dutieid ASC, c.readonly desc, c.sort
) AS a WHERE TRUE AND dutieid IS NOT NULL 
SQL
            ).$clause;
    }
    function q_transaction_read_where($clause = null){
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *, 
    SPLIT_PART(REGEXP_REPLACE(nominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nominalformat,
    SPLIT_PART(REGEXP_REPLACE(totalcashbon::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS totalcashbonformat 
FROM (
SELECT
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
    COALESCE(TRIM(a.dutieid), '') AS dutieid,
    COALESCE(TRIM(a.dutieid), 'sss') AS dutieid_p,
    COALESCE(TRIM(b.componentid), '') AS componentid,
    COALESCE(TRIM(c.description), '') AS componentname,
    b.description AS description,
    b.nominal AS nominal,
    f.lvl_jabatan,
    g.jobposition,
    COALESCE(TRIM(c.unit), '') AS unit,
    e.quantityday + (c.rules) AS quantityday,
    CASE
        WHEN c.multiplication THEN COALESCE(b.nominal, 0) * (e.quantityday + (c.rules))
        ELSE COALESCE(b.nominal, 0)
    END AS totalcashbon,
    COALESCE(TRIM(c.sort), '') AS sort,
    COALESCE(TRIM(c.type), '') AS type, 
    c.calculated AS calculated,
    c.active AS active,
    c.readonly AS readonly,
    c.sort AS sort,
    c.rules AS rules,
    c.multiplication AS multiplication
FROM sc_trx.cashbon_component b
LEFT OUTER JOIN sc_trx.cashbon a ON TRUE
AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
LEFT OUTER JOIN sc_mst.component_cashbon c ON TRUE
AND TRIM(c.componentid) = TRIM(b.componentid)
LEFT OUTER JOIN sc_trx.dinas d ON TRUE
AND TRIM(d.nodok) = a.dutieid
LEFT JOIN LATERAL (
    SELECT (EXTRACT(EPOCH FROM AGE(d.tgl_selesai, d.tgl_mulai)) / (24 * 60 * 60))::INTEGER + 1 AS quantityday
) AS e ON TRUE
LEFT OUTER JOIN sc_mst.karyawan f ON TRUE
AND TRIM(f.nik) = TRIM(d.nik)
LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
AND TRIM(g.componentid) = TRIM(b.componentid)
AND TRIM(g.jobposition) = TRIM(f.lvl_jabatan)
AND TRIM(g.destinationid) = TRIM(d.tujuan_kota)
ORDER BY a.dutieid ASC, c.readonly desc, c.sort
) AS a WHERE TRUE AND dutieid IS NOT NULL 
SQL
            ).$clause;
    }
}
