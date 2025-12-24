<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_DeclarationCashbonComponent extends CI_Model {
    function q_temporary_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_tmp.declaration_cashbon_component')
                ->num_rows() > 0;
    }
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.declaration_cashbon_component')
                ->num_rows() > 0;
    }
    function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.declaration_cashbon_component', $value);
    }
    function q_temporary_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.declaration_cashbon_component', $value);
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.declaration_cashbon_component', $value);
    }
    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.declaration_cashbon_component');
    }
    function q_empty_read_where($clause = null){
        return $this->db->query($this->q_empty_txt_where($clause));
    }
    function q_empty_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
    SPLIT_PART(REGEXP_REPLACE(defaultnominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS defaultnominalformat,
    SPLIT_PART(REGEXP_REPLACE(nominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nominalformat
FROM (
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(a.componentid), '') AS componentid,
        COALESCE(TRIM(a.description), '') AS componentname,
        COALESCE(TRIM(a.unit), '') AS unit,
        COALESCE(TRIM(a.sort), '') AS sort,
        COALESCE(TRIM(a.type), '') AS type,
        a.calculated AS calculated,
        a.active AS active,
        a.readonly AS readonly,
        a.rules AS rules,
        a.multiplication AS multiplication,
        COALESCE(TRIM(a.inputby), '') AS inputby,
        a.inputdate AS inputdate,
        COALESCE(TRIM(a.updateby), '') AS updateby,
        a.updatedate AS updatedate,
        COALESCE(TRIM(b.cashbonid), '') AS cashbonid,
        CASE
            WHEN COALESCE(TRIM(a.type), '') in ('DN') THEN COALESCE(TRIM(c.nodok), '')
            ELSE COALESCE(TRIM(e.nik), '')
        END AS dutieid,
        CASE
            WHEN a.type = 'DN' THEN d.day::DATE
            ELSE d1.day::DATE
        END AS perday,
        COALESCE(g.nominal, 0) AS defaultnominal,
        NULL::NUMERIC AS nominal,
        NULL::VARCHAR AS description
    FROM sc_mst.component_cashbon a
    LEFT OUTER JOIN sc_tmp.declaration_cashbon b ON TRUE
    LEFT OUTER JOIN sc_trx.dinas c ON TRUE
    AND TRIM(c.nodok) = TRIM(b.dutieid)
    LEFT OUTER JOIN sc_trx.cashbon c1 ON TRUE
    AND TRIM(c1.cashbonid) = TRIM(b.cashbonid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c.tgl_mulai::DATE, c.tgl_selesai::DATE, '1 DAY') AS day
    ) d ON TRUE
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c1.inputdate::DATE, c1.inputdate::DATE, '1 DAY') AS day
    ) d1 ON TRUE
    LEFT OUTER JOIN sc_mst.karyawan e ON TRUE
    AND CASE
            WHEN TRIM(a.type) in ('DN') THEN TRIM(e.nik) = TRIM(c.nik)
            ELSE TRIM(e.nik) = TRIM(b.dutieid)
        END
    LEFT OUTER JOIN sc_mst.destination_type f ON TRUE
    AND TRIM(f.destinationid) = TRIM(c.jenis_tujuan)
    LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
    AND TRIM(g.componentid) = TRIM(a.componentid)
    AND TRIM(g.destinationid) = TRIM(f.destinationid)
    AND TRIM(g.jobposition) = TRIM(e.lvl_jabatan)
    ORDER BY d.day, sort
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
    SPLIT_PART(REGEXP_REPLACE(defaultnominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS defaultnominalformat,
    SPLIT_PART(REGEXP_REPLACE(nominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nominalformat
FROM (
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(a.componentid), '') AS componentid,
        COALESCE(TRIM(a.description), '') AS componentname,
        COALESCE(TRIM(a.unit), '') AS unit,
        COALESCE(TRIM(a.sort), '') AS sort,
        COALESCE(TRIM(a.type), '') AS type,
        a.calculated AS calculated,
        a.active AS active,
        a.readonly AS readonly,
        COALESCE(TRIM(a.inputby), '') AS inputby,
        a.inputdate AS inputdate,
        COALESCE(TRIM(a.updateby), '') AS updateby,
        a.updatedate AS updatedate,
        COALESCE(TRIM(b.cashbonid), '') AS cashbonid,
        COALESCE(TRIM(b.declarationid), '') AS declarationid,
        CASE
            WHEN COALESCE(TRIM(a.type), '') in ('DN') THEN COALESCE(TRIM(c.nodok), '')
            ELSE COALESCE(TRIM(e.nik), '')
        END AS dutieid,
        CASE
            WHEN a.type = 'DN' THEN d.day::DATE
            ELSE d1.day::DATE
        END AS perday,
        COALESCE(g.nominal, 0) AS defaultnominal,
        h.nominal AS nominal,
        COALESCE(TRIM(h.description), '') AS description
    FROM sc_mst.component_cashbon a
    LEFT OUTER JOIN sc_tmp.declaration_cashbon b ON TRUE
    LEFT OUTER JOIN sc_trx.dinas c ON TRUE
        AND TRIM(c.nodok) = TRIM(b.dutieid)
    LEFT OUTER JOIN sc_trx.cashbon c1 ON TRUE 
        AND TRIM(b.cashbonid) = TRIM(c1.cashbonid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c.tgl_mulai::DATE, c.tgl_selesai::DATE, '1 DAY') AS day
    ) d ON TRUE
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c1.inputdate::DATE, c1.inputdate::DATE, '1 DAY') AS day
    ) d1 ON TRUE
    LEFT OUTER JOIN sc_mst.karyawan e ON TRUE
    AND CASE
            WHEN TRIM(a.type) in ('DN') THEN TRIM(e.nik) = TRIM(c.nik)
            ELSE TRIM(e.nik) = TRIM(b.dutieid)
        END
    LEFT OUTER JOIN sc_mst.destination_type f ON TRUE
    AND TRIM(f.destinationid) = TRIM(c.jenis_tujuan)
    LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
    AND TRIM(g.componentid) = TRIM(a.componentid)
    AND TRIM(g.destinationid) = TRIM(f.destinationid)
    AND TRIM(g.jobposition) = TRIM(e.lvl_jabatan)
    LEFT OUTER JOIN sc_tmp.declaration_cashbon_component h ON TRUE
    AND TRIM(h.declarationid) = TRIM(b.declarationid)
    AND TRIM(h.componentid) = TRIM(a.componentid)
    ORDER BY d.day, sort
) AS a WHERE TRUE
SQL
            ).$clause;
    }
    function q_transaction_read_where($clause = null){
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
    SPLIT_PART(REGEXP_REPLACE(defaultnominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS defaultnominalformat,
    SPLIT_PART(REGEXP_REPLACE(nominal::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nominalformat
FROM (
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(a.componentid), '') AS componentid,
        COALESCE(TRIM(a.description), '') AS componentname,
        COALESCE(TRIM(a.unit), '') AS unit,
        COALESCE(TRIM(a.sort), '') AS sort,
        COALESCE(TRIM(a.type), '') AS type,
        a.calculated AS calculated,
        a.active AS active,
        a.readonly AS readonly,
        COALESCE(TRIM(a.inputby), '') AS inputby,
        a.inputdate AS inputdate,
        COALESCE(TRIM(a.updateby), '') AS updateby,
        a.updatedate AS updatedate,
        COALESCE(TRIM(b.cashbonid), '') AS cashbonid,
        CASE
            WHEN COALESCE(TRIM(a.type), '') in ('DN') THEN COALESCE(TRIM(c.nodok), '')
            ELSE COALESCE(TRIM(e.nik), '')
        END AS dutieid,
        COALESCE(TRIM(b.declarationid), '') AS declarationid,
        CASE
            WHEN a.type = 'DN' THEN d.day::DATE
            ELSE d1.day::DATE
        END AS perday,
        COALESCE(g.nominal, 0) AS defaultnominal,
        COALESCE(h.nominal, 0) AS nominal,
        COALESCE(TRIM(h.description), '') AS description
    FROM sc_mst.component_cashbon a
    LEFT OUTER JOIN sc_trx.declaration_cashbon b ON TRUE
    LEFT OUTER JOIN sc_trx.dinas c ON TRUE
        AND TRIM(c.nodok) = TRIM(b.dutieid)
    LEFT OUTER JOIN sc_trx.cashbon c1 ON TRUE 
        AND TRIM(b.cashbonid) = TRIM(c1.cashbonid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c.tgl_mulai::DATE, c.tgl_selesai::DATE, '1 DAY') AS day
    ) d ON TRUE
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c1.inputdate::DATE, c1.inputdate::DATE, '1 DAY') AS day
    ) d1 ON TRUE
    LEFT OUTER JOIN sc_mst.karyawan e ON TRUE
        AND CASE
            WHEN TRIM(a.type) in ('DN') THEN TRIM(e.nik) = TRIM(c.nik)
            ELSE TRIM(e.nik) = TRIM(b.dutieid)
        END
    LEFT OUTER JOIN sc_mst.destination_type f ON TRUE
    AND TRIM(f.destinationid) = TRIM(c.jenis_tujuan)
    LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
    AND TRIM(g.componentid) = TRIM(a.componentid)
    AND TRIM(g.destinationid) = TRIM(f.destinationid)
    AND TRIM(g.jobposition) = TRIM(e.lvl_jabatan)
    LEFT OUTER JOIN sc_trx.declaration_cashbon_component h ON TRUE
    AND TRIM(h.declarationid) = TRIM(b.declarationid)
    AND TRIM(h.componentid) = TRIM(a.componentid)
    AND CASE
            WHEN TRIM(c1.type) IN ('DN') THEN h.perday = d.day
            ELSE h.perday = d1.day
        END
    ORDER BY d.day, sort
) AS a WHERE TRUE
SQL
            ).$clause;
    }
}
