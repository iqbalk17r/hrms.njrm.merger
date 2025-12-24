<?php

class M_Room extends CI_Model
{
    function read($clause = null)
    {
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null)
    {
        $this->db->query(' set lc_time = \'id\' ');
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    select
        a.room_id AS id,
        a.room_name AS text,
        a.room_id,
        a.room_name,
        a.branch,
        a.capacity,
        a.category,
        a.coordinate,
        a.description,
        a.actived,
        a.input_by,
        a.input_date,
        a.update_by,
        a.update_date,
        a.deleted,
        a.delete_by,
        a.delete_date,
        a.properties
    from sc_mst.room a
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
                ->get('sc_mst.room')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_mst.room', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_mst.room', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_mst.room');
    }




}