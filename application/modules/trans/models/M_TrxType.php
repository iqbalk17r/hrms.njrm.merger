<?php

class M_TrxType extends CI_Model
{
	function q_master_search_where($clause=null) {
		return $this->db->query(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.kdtrx), '') AS id,
        COALESCE(TRIM(a.uraian), '') AS text,
        COALESCE(TRIM(a.jenistrx), '') AS group,
        COALESCE(TRIM(a.jenistrx), '') AS type
    FROM sc_mst.trxtype a
    ORDER BY a.jenistrx, a.kdtrx
    ) AS a
WHERE TRUE
SQL
			.$clause
		);
	}
}
