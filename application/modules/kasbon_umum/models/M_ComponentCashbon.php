<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_ComponentCashbon extends CI_Model {
    function q_component_read_where($clause = null){
        return $this->db->query($this->q_component_txt_where($clause));
    }
    function q_component_txt_where($clause = null){
        return sprintf(<<<'SQL'
select * from(
     select
         branch,
         componentid,
         description,
         unit,
         sort,
         type,
         b.uraian as cashbon_type,
         calculated,
         active,
         readonly,
         multiplication,
         rules,
         inputby,
         inputdate,
         updateby,
         updatedate,
         case
             when calculated = true then '<span class="badge badge-primary" style="background-color:darkgreen">Aktif</span>'
             else '<span class="badge badge-primary" style="background-color:darkred">Nonaktif</span>'
        end as formatcalculated,
         case
             when active = true then '<span class="badge badge-primary" style="background-color:darkgreen">Aktif</span>'
             else '<span class="badge badge-primary" style="background-color:darkred">Nonaktif</span>'
        end as formatreactive,
         case
             when readonly = true then '<span class="badge badge-primary" style="background-color:darkgreen">Aktif</span>'
             else '<span class="badge badge-primary" style="background-color:darkred">Nonaktif</span>'
        end as formatreadonly,
         case
             when multiplication = true then '<span class="badge badge-primary" style="background-color:darkgreen">Aktif</span>'
             else '<span class="badge badge-primary" style="background-color:darkred">Nonaktif</span>'
        end as formatmultiplication,
         'edit' as edited,
         'delete' as deleted
     from sc_mst.component_cashbon a
     left outer join sc_mst.trxtype b on a.type = b.kdtrx AND jenistrx = 'CBN:COMPONENT:TYPE'
     order by a.sort ASC
 ) as aa where true 
SQL
            ).$clause;
    }
    function create($value){
        return $this->db
            ->insert('sc_mst.component_cashbon', $value);
    }

    function exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_mst.component_cashbon')
                ->num_rows() > 0;
    }
    function delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_mst.component_cashbon');
    }
}