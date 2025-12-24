<?php

class M_Notifications extends CI_Model
{
/**/
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
        a.notification_id,
        a.reference_id,
        a.type,
        a.module,
        a.subject,
        a.content,
        a.send_to,
       CASE
         WHEN (COALESCE(TRIM(b.nohp1), '') IS NOT NULL OR b.nohp1 = '' ) THEN COALESCE(TRIM(b.nohp1), '')
         ELSE '000000000000'
         END AS phone,
	    b.email,
        a.action,
        a.status,
        a.properties,
        (a.properties->>'is_interactive')::boolean AS is_interactive,
        COALESCE(TRIM(a.properties->>'is_agree_text'),'Setuju') AS agree_text,
        COALESCE(TRIM(a.properties->>'is_disagree_text'),'Tolak') AS disagree_text
    FROM sc_trx.notifications a
    LEFT OUTER JOIN sc_mst.karyawan b ON a.send_to = b.nik
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
                ->get('sc_trx.notifications')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_trx.notifications', $value);
    }
    function createBatch($value)
    {
        if (empty($value) || !is_array($value)) {
            return false;
        }
        return $this->db
            ->insert_batch('sc_trx.notifications', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.notifications', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_trx.notifications');
    }
}