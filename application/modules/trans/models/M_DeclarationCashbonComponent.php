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
        COALESCE(TRIM(b.declarationid), '') AS declarationid,
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
        COALESCE(TRIM(c.nodok), '') AS dutieid,
        d.day::DATE AS perday,
        c.callplan AS is_callplan,
        CASE
            WHEN c.nodok is not null AND c.tipe_transportasi = 'TDN' AND LEFT(COALESCE(TRIM(a.componentid), ''),3) = 'SWK' THEN 0
            ELSE COALESCE(g.nominal, 0)
        END AS defaultnominal,
        c.transportasi,
        /*CASE
           WHEN c.tgl_mulai::DATE = d.day::DATE AND COALESCE(TRIM(a.componentid), '') = 'UD' THEN 0
           ELSE COALESCE(g.nominal, 0)
       END AS defaultnominal,*/
        NULL::NUMERIC AS nominal,
        NULL::VARCHAR AS description
    FROM sc_mst.component_cashbon a
    LEFT OUTER JOIN sc_tmp.declaration_cashbon b ON TRUE
    LEFT OUTER JOIN sc_trx.dinas c ON TRUE
    AND TRIM(c.nodok) = TRIM(b.dutieid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c.tgl_mulai::DATE, c.tgl_selesai::DATE, '1 DAY') AS day
    ) d ON TRUE
    LEFT OUTER JOIN sc_mst.karyawan e ON TRUE
    AND TRIM(e.nik) = TRIM(c.nik)
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
        COALESCE(TRIM(c.nodok), '') AS dutieid,
        COALESCE(TRIM(b.declarationid), '') AS declarationid,
        d.day::DATE AS perday,
        CASE
            WHEN c.nodok is not null AND c.tipe_transportasi = 'TDN' AND LEFT(COALESCE(TRIM(a.componentid), ''),3) = 'SWK' THEN 0
            ELSE COALESCE(g.nominal, 0)
        END AS defaultnominal,
        /*CASE
           WHEN c.tgl_mulai::DATE = d.day::DATE AND COALESCE(TRIM(a.componentid), '') = 'UD' THEN 0
           ELSE COALESCE(g.nominal, 0)
        END AS defaultnominal,*/
        h.nominal AS nominal,
        c.callplan AS iscallplan,
        c.transportasi,
        COALESCE(TRIM(h.description), '') AS description
    FROM sc_mst.component_cashbon a
    LEFT OUTER JOIN sc_tmp.declaration_cashbon b ON TRUE
    LEFT OUTER JOIN sc_trx.dinas c ON TRUE
    AND TRIM(c.nodok) = TRIM(b.dutieid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c.tgl_mulai::DATE, c.tgl_selesai::DATE, '1 DAY') AS day
    ) d ON TRUE
    LEFT OUTER JOIN sc_mst.karyawan e ON TRUE
    AND TRIM(e.nik) = TRIM(c.nik)
    LEFT OUTER JOIN sc_mst.destination_type f ON TRUE
    AND TRIM(f.destinationid) = TRIM(c.jenis_tujuan)
    LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
    AND TRIM(g.componentid) = TRIM(a.componentid)
    AND TRIM(g.destinationid) = TRIM(f.destinationid)
    AND TRIM(g.jobposition) = TRIM(e.lvl_jabatan)
    LEFT OUTER JOIN sc_tmp.declaration_cashbon_component h ON TRUE
    AND TRIM(h.declarationid) = TRIM(b.declarationid)
    AND TRIM(h.componentid) = TRIM(a.componentid)
    AND h.perday = d.day
    ORDER BY d.day,readonly DESC , sort
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
        COALESCE(TRIM(c.nodok), '') AS dutieid,
        COALESCE(TRIM(b.declarationid), '') AS declarationid,
        d.day::DATE AS perday,
        COALESCE(g.nominal, 0) AS defaultnominal,
        h.nominal AS nominal,
        COALESCE(TRIM(h.description), '') AS description,
        c.transportasi
    FROM sc_mst.component_cashbon a
    LEFT OUTER JOIN sc_trx.declaration_cashbon b ON TRUE
    LEFT OUTER JOIN sc_trx.dinas c ON TRUE
    AND TRIM(c.nodok) = TRIM(b.dutieid)
    LEFT JOIN LATERAL (
        SELECT GENERATE_SERIES(c.tgl_mulai::DATE, c.tgl_selesai::DATE, '1 DAY') AS day
    ) d ON TRUE
    LEFT OUTER JOIN sc_mst.karyawan e ON TRUE
    AND TRIM(e.nik) = TRIM(c.nik)
    LEFT OUTER JOIN sc_mst.destination_type f ON TRUE
    AND TRIM(f.destinationid) = TRIM(c.jenis_tujuan)
    LEFT OUTER JOIN sc_mst.jobposition_cashbon g ON TRUE
    AND TRIM(g.componentid) = TRIM(a.componentid)
    AND TRIM(g.destinationid) = TRIM(f.destinationid)
    AND TRIM(g.jobposition) = TRIM(e.lvl_jabatan)
    LEFT OUTER JOIN sc_trx.declaration_cashbon_component h ON TRUE
    AND TRIM(h.declarationid) = TRIM(b.declarationid)
    AND TRIM(h.componentid) = TRIM(a.componentid)
    AND h.perday = d.day
    ORDER BY d.day, sort
) AS a WHERE TRUE
SQL
            ).$clause;
    }
}
