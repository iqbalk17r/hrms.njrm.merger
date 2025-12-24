<?php

class M_NotificationRule extends CI_Model
{
    function read($clause = null)
    {
        return $this->db->query($this->read_txt($clause));
    }

    function read_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    SELECT
        a.id,
        a.status,
        a.notified_to,
        a.type,
        a.module,
        a.description,
        a.active,
        a.input_by,
        a.input_date,
        a.update_by,
        a.update_date,
        a.deleted,
        a.delete_by,
        a.delete_date,
        a.delete_reason
    FROM sc_mst.notification_rule a
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function exists($where)
    {
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_mst.notification_rule')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_mst.notification_rule', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_mst.notification_rule', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_mst.notification_rule');
    }
}