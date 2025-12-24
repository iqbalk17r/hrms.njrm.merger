<?php

class M_CityCashbon extends CI_Model
{
	function q_master_search_where($clause=null) {
		return $this->db->query(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(a.cityid), '') AS id,
        COALESCE(TRIM(b.namakotakab), '') AS text,
        COALESCE(TRIM(a.destinationid), '') AS group
    FROM sc_mst.city_cashbon a
    LEFT OUTER JOIN sc_mst.kotakab b ON TRUE 
    AND TRIM(b.kodekotakab) = TRIM(a.cityid)
    ORDER BY b.namakotakab
    ) AS a
WHERE TRUE
SQL
			.$clause
		);
	}
}
