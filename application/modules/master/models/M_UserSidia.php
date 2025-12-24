<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_UserSidia extends CI_Model {
    function q_transaction_create($value){
        return $this->db
            ->insert('sc_mst.user_sidia', $value);
    }

    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_mst.user_sidia')
                ->num_rows() > 0;
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_mst.user_sidia', $value);
    }
    function q_transaction_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_mst.user_sidia');
    }
    function q_transaction_read_where($clause = null){
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
SELECT
        COALESCE(TRIM(a.branch),'') AS branch, 
        COALESCE(TRIM(a.nik),'') AS nik, 
        COALESCE(TRIM(a.userid),'') AS userid, 
        COALESCE(TRIM(a.usersname),'') AS usersname, 
        COALESCE(TRIM(a.userlname),'') AS userlname, 
        a.password, 
        COALESCE(TRIM(a.groupuser),'') AS groupuser, 
        COALESCE(TRIM(a.level),'') AS level, 
        COALESCE(TRIM(a.location),'') AS location, 
        COALESCE(TRIM(a.divisi),'') AS divisi, 
        COALESCE(TRIM(a.brand),'') AS brand, 
        a.hold, 
        COALESCE(TRIM(a.lockusr),'') AS lockusr, 
        a.login, 
        a.expdate, 
        a.inputdate, 
        a.inputby, 
        a.timelock, 
        COALESCE(TRIM(a.email),'') AS email, 
        COALESCE(TRIM(a.status),'') AS status, 
        a.explocking, 
        a.retrydate, 
        COALESCE(TRIM(a.sendstatus),'') AS sendstatus, 
        COALESCE(TRIM(a.custcode),'') AS custcode, 
        COALESCE(TRIM(a.depcode),'') AS depcode, 
        COALESCE(TRIM(a.supervisorid),'') AS supervisorid, 
        COALESCE(TRIM(a.managerid),'') AS managerid
    FROM sc_mst.user_sidia a
) AS a WHERE TRUE
SQL
            ).$clause;
    }

}
