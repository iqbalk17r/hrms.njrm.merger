<?php

class M_MealAllowance extends CI_Model
{
    function read($clause = null){
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
    select
        COALESCE(TRIM(a.branch),'') AS branch,
        COALESCE(TRIM(a.nik),'') AS nik,
        a.tgl AS workdate,
        a.checkin,
        a.checkout,
        a.nominal AS amount,
        COALESCE(TRIM(a.keterangan),'') AS information,
        a.tgl_dok AS docdate,
        COALESCE(TRIM(a.dok_ref),null) AS docref,
        COALESCE(a.rencanacallplan,0) AS callplan,
        COALESCE(a.realisasicallplan,0) AS realization,
        CASE
            WHEN extract(day from now()::timestamp - c.tglmasukkerja::timestamp) <= 30 AND a.rencanacallplan > 1 AND b.callplan = 't' THEN 1
            WHEN (a.realisasicallplan >= a.rencanacallplan) AND a.rencanacallplan > 0 AND b.callplan = 't' THEN 1
            WHEN b.callplan = 'f' THEN 1
        ELSE 0
    END AS achieved,
    b.nodok AS dutieid
    from sc_trx.uangmakan a
    LEFT OUTER JOIN sc_trx.dinas b ON a.nik = b.nik
    LEFT OUTER JOIN sc_mst.karyawan c ON a.nik = c.nik
) as aa
WHERE TRUE
SQL
            ).$clause;
    }
}