<?php

class M_WorkHour extends CI_Model
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
        COALESCE(TRIM(kdjam_kerja),'') AS workid,
        jam_masuk AS begin_time,
        jam_pulang AS end_time,
        COALESCE(TRIM(shiftke),'') AS shiftid
    from sc_mst.jam_kerja
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function get_shift($clause = null)
    {
        return $this->db->query($this->get_shift_txt($clause));
    }
    function get_shift_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    select
        COALESCE(TRIM(a.shiftke),'') AS id,
        COALESCE('Shift-'||TRIM(a.shiftke),'') AS text
    from sc_mst.jam_kerja a
    GROUP BY a.shiftke
    ORDER BY a.shiftke
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }


}