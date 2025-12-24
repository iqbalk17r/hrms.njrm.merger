<?php

class M_DestinationType extends CI_Model
{
	function q_master_search_where($clause=null) {
		return $this->db->query(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.branch), '') AS branch,
        COALESCE(TRIM(a.destinationid), '') AS id,
        COALESCE(TRIM(a.description), '') AS text,
        a.active AS active
    FROM sc_mst.destination_type a
    ORDER BY a.description
    ) AS a
WHERE TRUE
SQL
			.$clause
		);
	}
}
