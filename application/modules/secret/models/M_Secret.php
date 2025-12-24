<?php
class M_Secret extends CI_Model{
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.secret')
                ->num_rows() > 0;
    }

    function q_transaction_read($clause)
    {
        return $this->db->query($this->q_transaction_txt_read($clause));
    }

    function q_transaction_txt_read($clause = null){
        return sprintf(<<<'SQL'
SELECT 
    *
FROM (
    select
        a.employee_id,
        a.secret_id,
        a.url,
        a.description,
        a.status,
        a.actived,
        a.input_by,
        a.input_date,
        a.update_by,
        a.update_date,
        a.approve_by,
        a.approve_date,
        a.cancel_by,
        a.cancel_date,
        a.deleted,
        a.delete_by,
        a.delete_date,
        a.properties
    from sc_trx.secret a
) a WHERE TRUE
SQL
            ).$clause;
    }



    function q_transaction_create($value){
        return $this->db
            ->insert('sc_trx.secret', $value);
    }



    function q_transaction_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.secret', $value);
    }



    function q_transaction_delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_trx.secret');
    }

    function q_master_user_read($clause){
        return $this->db->query("
            select * FROM(
                select
                    TRIM(a.branch) AS branch,
                    TRIM(a.nik) AS nik,
                    TRIM(a.username) AS username,
                    TRIM(a.passwordweb) AS passwordweb,
                    TRIM(a.level_id) AS level_id,
                    TRIM(a.level_akses) AS level_akses,
                    a.expdate AS expdate,
                    TRIM(a.hold_id) AS hold_id,
                    a.inputdate AS inputdate,
                    TRIM(a.inputby) AS inputby,
                    a.editdate AS editdate,
                    TRIM(a.editby) AS editby,
                    a.lastlogin AS lastlogin,
                    TRIM(a.image) AS image,
                    TRIM(a.loccode) AS loccode
                from sc_mst.user a
            ) a
            WHERE TRUE
        ".$clause);
    }


}	
