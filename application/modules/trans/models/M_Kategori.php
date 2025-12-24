<?php

class M_Kategori extends CI_Model
{
	function q_master_search_where($clause=null) {
		return $this->db->query(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.kdkategori), '') AS id,
        COALESCE(TRIM(a.nmkategori), '') AS text,
        COALESCE(TRIM(a.typekategori), '') AS group
    FROM sc_mst.kategori a
    ORDER BY a.nmkategori
    ) AS a
WHERE TRUE
SQL
			.$clause
		);
	}
}
