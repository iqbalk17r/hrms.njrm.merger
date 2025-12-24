<?php

class M_WorkSchedule extends CI_Model
{
    function read($clause = null){
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.nik),'') AS nik,
        a.tgl,
        COALESCE(TRIM(a.kdjamkerja),'') AS kdjamkerja,
        COALESCE(TRIM(a.kdregu),'') AS kdregu,
        COALESCE(TRIM(a.kdmesin),'') AS kdmesin,
        a.shift,
        a.id,
        a.inputby,
        a.inputdate,
        a.updateby,
        a.updatedate,
        b.jam_masuk AS checkin_schedule,
        b.jam_pulang AS checkout_schedule
    FROM sc_trx.dtljadwalkerja a
    LEFT OUTER JOIN sc_mst.jam_kerja b ON a.kdjamkerja = b.kdjam_kerja
) as aa
WHERE TRUE
SQL
            ).$clause;
    }
}