<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Cabang extends CI_Model
{
    function q_mst_download_where($clause = null){
        $cabang = $this->db
            ->query(
                sprintf(
                    <<<'SQL'
                select * from (
                    select
                    coalesce(trim(a.branch::text), '') as branch, 
                    UPPER(a.cdefault::CHAR) AS default
                    from sc_mst.branch a
                    order by branch
                    ) as a
                where branch <> ''
SQL
                ).$clause)->row()->branch;
        return $cabang;
    }
}
