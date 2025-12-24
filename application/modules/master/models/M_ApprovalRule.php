<?php
class M_ApprovalRule extends CI_Model{

    function q_transaction_approver($param){
        $nik = TRIM($this->session->userdata('nik'));
        return $this->q_transaction_exists(' TRUE AND actived = true AND \''.$nik.'\' = any(nik) '.$param);
    }

    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_mst.approval_rule')
                ->num_rows() > 0;
    }
    function q_transaction_create($value){
        return $this->db
            ->insert('sc_mst.approval_rule', $value);
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_mst.approval_rule', $value);
    }
    function q_transaction_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_mst.approval_rule');
    }
}


