<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_BalanceCashbon extends CI_Model {
    function q_balance_cashbon_read_where($clause = null){
        return $this->db->query($this->q_balance_cashbon_txt_where($clause));
    }
    function q_balance_cashbon_txt_where($clause = null){
        return sprintf(<<<'SQL'
select 
    *,
    SPLIT_PART(REGEXP_REPLACE(balance::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS balanceformat
from(
     select
        COALESCE(a.nik, '') AS nik,
        COALESCE(a.nmlengkap, '') AS nmlengkap,
        COALESCE(a.bag_dept, '') AS bag_dept,
        COALESCE(a.subbag_dept, '') AS subbag_dept,
        COALESCE(b.nmdept, '') AS nmdept,
        COALESCE(c.nmsubdept, '') AS nmsubdept,
        COALESCE(d.balances, 0) AS balance
    from sc_mst.karyawan a
             left join sc_mst.departmen b on a.bag_dept = b.kddept
             left join sc_mst.subdepartmen c on a.subbag_dept = c.kdsubdept
            LEFT JOIN LATERAL (
                select
                    sum(cash_in) - sum(cash_out) AS balances
                from sc_trx.cashbon_blc
                where nik = a.nik
            ) d ON TRUE
    where true
      and coalesce(upper(a.statuskepegawaian),'')!='KO'
 ) as aa where true 
SQL
            ).$clause;
    }


    function q_balance_cashbon_detail_read_where($clause = null){
        return $this->db->query($this->q_balance_cashbon_detail_txt_where($clause));
    }

    function q_balance_cashbon_detail_txt_where($clause = null){
        return sprintf(<<<'SQL'
select 
    *,
    SPLIT_PART(REGEXP_REPLACE(balance::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS balanceformat,
    SPLIT_PART(REGEXP_REPLACE(cash_in::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS cash_informat,
    SPLIT_PART(REGEXP_REPLACE(cash_out::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS cash_outformat
from(
    select
        COALESCE(TRIM(a.nik), '') AS nik,
        COALESCE(TRIM(a.nmlengkap), '') AS nmlengkap,
        COALESCE(b.doctype, '') AS doctype,
        COALESCE(b.docno, '') AS docno,
        b.cash_in AS cash_in,
        b.cash_out AS cash_out,
        b.balance AS balance,
        COALESCE(b.status, '') AS status,
        COALESCE(b.flag, '') AS flag,
        COALESCE(b.voucher, '') AS voucher,
        CASE
            WHEN COALESCE(b.flag, '') = 'NO' THEN upper('Belum dibuat voucher')
            ELSE UPPER('Sudah dibuat voucher')
        END AS cashier_status,
        CASE
            WHEN COALESCE(b.flag, '') = 'NO' THEN 'label-warning'
            ELSE 'label-success'
        END AS cashier_status_color,
        b.inputdate,
        TO_CHAR(b.inputdate, 'DD-MM-YYYY') as reformatdate,
        TO_CHAR(b.inputdate, 'HH:MM:SS') as reformattime,
        COALESCE(b.inputby, '') AS inputby,
        TO_CHAR(b.inputdate::TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS') AS inputdate
    from sc_mst.karyawan a
    inner join sc_trx.cashbon_blc b on TRIM(a.nik) = TRIM(b.nik)
    where true
    and coalesce(upper(a.statuskepegawaian),'')!='KO'
    ORDER BY b.docno ASC
) as aa where true
SQL
            ).$clause;
    }

    function delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_trx.cashbon_blc');
    }

    function update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.cashbon_blc', $value);
    }
    function create($value){
        return $this->db
            ->insert('sc_trx.cashbon_blc', $value);
    }

    function exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.cashbon_blc')
                ->num_rows() > 0;
    }
}