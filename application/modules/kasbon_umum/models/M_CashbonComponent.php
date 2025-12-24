<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_CashbonComponent extends CI_Model {
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
    COALESCE(TRIM(b.componentid), '') AS componentid,
    COALESCE(TRIM(b.description), '') AS componentname,
    '' AS description,
    COALESCE(TRIM(b.unit), '') AS unit,
    COALESCE(TRIM(b.type), '') AS type,
    0 AS nominal,
    0 AS totalcashbon,
    COALESCE(TRIM(b.sort), '') AS sort,
    b.calculated AS calculated,
    b.active AS active,
    b.readonly AS readonly,
    b.sort AS sort,
    b.rules AS rules,
    b.multiplication AS multiplication 
FROM sc_mst.component_cashbon b
LEFT OUTER JOIN sc_tmp.cashbon_component a on b.componentid = a.componentid
WHERE TRUE
ORDER BY b.readonly desc, b.sort
) AS a WHERE TRUE
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
             COALESCE(TRIM(a.dutieid), '') AS dutieid,
             COALESCE(TRIM(b.componentid), '') AS componentid,
             COALESCE(TRIM(c.description), '') AS componentname,
             b.description AS description,
             b.nominal AS nominal,
             g.jobposition,
             COALESCE(TRIM(c.unit), '') AS unit,
             b.totalcashbon,
             COALESCE(TRIM(c.sort), '') AS sort,
             COALESCE(TRIM(c.type), '') AS type,
             c.calculated AS calculated,
             c.active AS active,
             c.readonly AS readonly,
             c.sort AS sort
         FROM sc_tmp.cashbon_component b
                  LEFT OUTER JOIN sc_tmp.cashbon a ON TRUE
             AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
                  LEFT OUTER JOIN sc_mst.component_cashbon c ON TRUE
             AND TRIM(c.componentid) = TRIM(b.componentid)
                  LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
             AND TRIM(g.componentid) = TRIM(b.componentid)
         ORDER BY c.readonly desc, c.sort
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
             COALESCE(TRIM(b.componentid), '') AS componentid,
             COALESCE(TRIM(c.description), '') AS componentname,
             b.description AS description,
             b.nominal AS nominal,
             g.jobposition,
             COALESCE(TRIM(c.unit), '') AS unit,
             COALESCE(TRIM(c.type), '') AS type,
             b.totalcashbon,
             COALESCE(TRIM(c.sort), '') AS sort,
             c.calculated AS calculated,
             c.active AS active,
             c.readonly AS readonly,
             c.sort AS sort
         FROM sc_trx.cashbon_component b
                  LEFT OUTER JOIN sc_trx.cashbon a ON TRUE
             AND TRIM(b.cashbonid) = TRIM(a.cashbonid)
                  LEFT OUTER JOIN sc_mst.component_cashbon c ON TRUE
             AND TRIM(c.componentid) = TRIM(b.componentid)
                  LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
             AND TRIM(g.componentid) = TRIM(b.componentid)
         ORDER BY c.readonly desc, c.sort
     ) AS a WHERE TRUE AND dutieid IS NOT NULL 
SQL
            ).$clause;
    }
}
