<?php
class M_DtlJadwalKerja extends CI_Model{
    function q_transaction_read_where($clause = null)
    {
        return $this->db->query($this->q_transaction_txt_where($clause));
    }

    function q_transaction_txt_where($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT 
    *
FROM(
    SELECT
        COALESCE(TRIM(a.nik),'') AS nik, 
        a.tgl, 
        COALESCE(TRIM(a.kdjamkerja),'') AS kdjamkerja, 
        COALESCE(TRIM(a.kdregu),'') AS kdregu, 
        COALESCE(TRIM(a.kdmesin),'') AS kdmesin, 
        COALESCE(TRIM(a.inputby),'') AS inputby, 
        a.inputdate, 
        COALESCE(TRIM(a.updateby),'') AS updateby, 
        a.updatedate, 
        a.shift, 
        a.id
    FROM sc_trx.dtljadwalkerja a
) AS aa WHERE TRUE 
SQL
            ) . $clause;
    }

    function q_check_transaction_exists($where){
        return $this->db->query("
            SELECT * FROM (
                SELECT
                    *,
                    EXTRACT(YEAR FROM tgl::date) AS years,
                    EXTRACT(MONTH FROM tgl::date) AS months
                FROM sc_trx.dtljadwalkerja a
            ) aa
            WHERE TRUE
        ".$where)->num_rows() > 0;
    }

}