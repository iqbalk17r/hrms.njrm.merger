<?php

class M_ReminderLetter extends CI_Model
{
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_mst.sk_peringatan')
                ->num_rows() > 0;
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_mst.sk_peringatan', $value);
    }
    function q_transaction_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_mst.sk_peringatan');
    }

    function q_transaction_read_where($clause = null)
    {
        return $this->db->query($this->q_transaction_txt_where($clause));
    }

    function q_transaction_txt_where($clause = null)
    {
        return sprintf(<<<'SQL'
select 
    *
from(
    select 
        COALESCE(TRIM(a.docno), '') AS docno, 
        COALESCE(TRIM(a.docname), '') AS docname, 
        COALESCE(TRIM(a.chold), '') AS chold, 
        COALESCE(TRIM(a.description), '') AS description, 
        COALESCE(TRIM(a.period_value), '') AS period_value, 
        COALESCE(TRIM(a.period_type), '') AS period_type,
        CASE
              WHEN a.period_type = 'D' THEN 'day'
              WHEN a.period_type = 'W' THEN 'week'
              WHEN a.period_type = 'M' THEN 'month'
              WHEN a.period_type = 'Y' THEN 'year'
              ELSE 'second'
          END AS time_unit,
        CASE
              WHEN a.period_type = 'D' THEN 'Hari'
              WHEN a.period_type = 'W' THEN 'Minggu'
              WHEN a.period_type = 'M' THEN 'Bulan'
              WHEN a.period_type = 'Y' THEN 'Tahun'
              ELSE 'Detik'
          END AS formattime_unit,
        COALESCE(TRIM(a.inputby), '') AS inputby, 
        a.inputdate, 
        COALESCE(TRIM(a.updateby), '') AS updateby, 
        a.updatedate
    from sc_mst.sk_peringatan a
 ) as aa where true 
SQL
            ) . $clause;
    }
    function q_transaction_read($clause = null)
    {
        return $this->db->query(<<<'SQL'
SELECT * FROM (
    
    ) AS a
WHERE TRUE
SQL
            . $clause
        );
    }

    function q_transaction_create($value){
        return $this->db
            ->insert('sc_mst.sk_peringatan', $value);
    }

    function find($date, $value, $type)
    {
        return $this->db->query(" SELECT TO_CHAR('$date'::date + INTERVAL '$value $type', 'DD-MM-YYYY') AS modifydate")->row();
    }
}


