<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_ComponentCashbon extends CI_Model {
    function q_temporary_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_tmp.component_cashbon')
                ->num_rows() > 0;
    }
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.component_cashbon')
                ->num_rows() > 0;
    }
    function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.component_cashbon', $value);
    }
    function q_temporary_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.component_cashbon', $value);
    }
    function q_master_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_mst.component_cashbon', $value);
    }
    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.component_cashbon');
    }
    function q_temporary_read_where($clause = null){
        return $this->db->query($this->q_temporary_txt_where($clause));
    }
    function q_temporary_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
SELECT
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.componentid), '') AS componentid,
    COALESCE(TRIM(a.description), '') AS description,
    COALESCE(TRIM(a.unit), '') AS unit,
    COALESCE(TRIM(a.sort), '') AS sort,
    a.calculated AS calculated,
    a.active AS active,
    a.readonly AS readonly,
    COALESCE(TRIM(a.inputby), '') AS inputby,
    a.inputdate AS inputdate,
    COALESCE(TRIM(a.updateby), '') AS updateby,
    a.updatedate AS updatedate
FROM sc_tmp.cashbon_component b
ORDER BY sort
) AS a WHERE TRUE
SQL
            ).$clause;
    }
    function q_master_read_where($clause = null){
        return $this->db->query($this->q_master_txt_where($clause));
    }
    function q_master_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
SELECT
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.componentid), '') AS componentid,
    COALESCE(TRIM(a.description), '') AS description,
    COALESCE(TRIM(a.unit), '') AS unit,
    COALESCE(TRIM(a.sort), '') AS sort,
    COALESCE(TRIM(a.type), '') AS type,
    a.calculated AS calculated,
    a.active AS active,
    a.readonly AS readonly,
    COALESCE(TRIM(a.inputby), '') AS inputby,
    a.inputdate AS inputdate,
    COALESCE(TRIM(a.updateby), '') AS updateby,
    a.updatedate AS updatedate
FROM sc_mst.component_cashbon a
ORDER BY readonly DESC , sort ASC
) AS a WHERE TRUE
SQL
            ).$clause;
    }
}
