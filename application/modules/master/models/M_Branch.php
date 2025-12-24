<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Branch extends CI_Model {
    function q_master_read_where($clause = null){
        return $this->db->query($this->q_master_txt_where($clause));
    }
    function q_master_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.branch)) AS branch,
        COALESCE(TRIM(a.branchname)) AS branchname,
        COALESCE(TRIM(a.address)) AS address,
        a.phone1,
        a.phone2,
        a.fax,
        COALESCE(TRIM(a.cdefault)) AS cdefault
    FROM sc_mst.branch a
) AS a WHERE TRUE
SQL
            ).$clause;
    }

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
        COALESCE(TRIM(a.branch),'') AS branch, 
        COALESCE(TRIM(a.branchname),'') AS branchname, 
        COALESCE(TRIM(a.address),'') AS address, 
        a.phone1, 
        a.phone2, 
        COALESCE(TRIM(a.fax),'') AS fax, 
        COALESCE(TRIM(a.cdefault),'') AS cdefault
    FROM sc_mst.branch a
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
                ->get('sc_mst.branch')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_mst.branch', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_mst.branch', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_mst.branch');
    }
}
