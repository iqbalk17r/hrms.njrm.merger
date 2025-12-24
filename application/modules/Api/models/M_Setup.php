<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Setup extends CI_Model
{

    function q_mst_exist($where)
    {
        return $this->db
            ->select('kdoption')
            ->where($where)
            ->get('sc_mst.option')
            ->num_rows() > 0 ? true : false;
    }
    function q_mst_read_value($clause, $default)
    {
        $setup = $this->db
            ->query(
                sprintf(
                    <<<'SQL'
SELECT * FROM (
    SELECT 
        COALESCE(TRIM(a.kdoption), '') AS parameter,
        COALESCE(TRIM(a.value1), '0') AS value    
    FROM sc_mst.option a WHERE TRUE
    ORDER BY parameter
) AS a WHERE TRUE 
SQL
                ) . $clause
            )->row();
        return (isset($setup->value) ? $setup->value : $default);
    }

    function q_mst_download_where($clause = null)
    {
        return $this->db->query(
            <<<'SQL'

select * from (
select
coalesce(trim(a.branch::text), '') as branch,
coalesce(trim(a.parameter::text), '') as parameter,
coalesce(trim(a.value::text), '') as value,
coalesce(trim(a.type::text), '') as type,
coalesce(trim(a.app::text), '') as app,
'I' as status 
from sc_mst.setup a
union
select
( select branch from sc_mst.cabang where lower("default") = 'yes') as branch,
concat('PP:', approver) as parameter,
'Y' as value,
' ' as type,
'P' as app,
'I' as status 
from sc_mst.userapproval c
where trim(c.action)='P.P'
) as t1
where branch <> ''

SQL
                . $clause
        );
    }

    function get_value($param)
    {
        return $this->db->get_where('sc_mst.setup', array('parameter' => $param))->row()->value;
    }
}
