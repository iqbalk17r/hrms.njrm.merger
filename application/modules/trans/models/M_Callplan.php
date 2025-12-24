<?php

class M_Callplan extends CI_Model
{
    function read($clause = null){
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
    select true
) as aa
WHERE TRUE
SQL
            ).$clause;
    }
    function check($nik,$date ){
        $date = ((!is_null($date) OR !empty($date)) ? $date : date('Y-m-d'));
        return $this->db->query("
            with filter AS (
                select
                    '$nik'::varchar AS fnik,
                    '$date'::date AS fdate
            )
            select
                COALESCE(TRIM(a.nik),'') AS nik,
                TRIM(b.callplan) = 't' AS is_callplan,
                a.tgl AS workdate,
                COALESCE(a.rencanacallplan,0) AS callplan,
                COALESCE(a.realisasicallplan,0) AS realization,
                CASE
                    WHEN extract(day from now()::timestamp - b.tglmasukkerja::timestamp) <= 30 AND a.rencanacallplan >= 1  THEN 1
                    WHEN (a.realisasicallplan >= a.rencanacallplan) AND a.rencanacallplan >= 1 THEN 1
                    ELSE 0
                    END AS achieved
            from sc_trx.meal_allowance a
            LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
            WHERE TRUE
                AND a.nik = (select fnik from filter)
                AND a.tgl = (select fdate from filter)
        ");
    }
    function check_old($nik,$date ){
        $date = ((!is_null($date) OR !empty($date)) ? $date : date('Y-m-d'));
        return $this->db->query("
            with filter AS (
                select
                    '$nik'::varchar AS fnik,
                    '$date'::date AS fdate
            )
            select
                COALESCE(TRIM(a.nik),'') AS nik,
                TRIM(a.callplan) = 't' AS is_callplan,
                (select fdate from filter) AS workdate,
                b.schedule AS callplan,
                c.realization,
                CASE
                    WHEN extract(day from now()::timestamp - a.tglmasukkerja::timestamp) <= 30 AND b.schedule >= 1  THEN 1
                    WHEN (c.realization >= b.schedule) AND b.schedule >= 1 THEN 1
                    ELSE 0
                END AS achieved
            from sc_mst.karyawan a
                     LEFT JOIN LATERAL (
                SELECT count(*) AS schedule
                FROM sc_tmp.scheduletolocation xa
                WHERE xa.nik = a.nik AND xa.scheduledate = (select fdate from filter)
                ) b ON TRUE
                     LEFT JOIN LATERAL (
                SELECT COUNT(x.custcode) AS realization
                FROM (
                         SELECT COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode
                         FROM sc_tmp.checkinout xa
                         WHERE xa.checktime::DATE = (select fdate from filter)
                           AND xa.nik = a.nik
                           AND xa.customertype = 'C'
                           AND COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) IN (
                             SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
                             FROM sc_tmp.scheduletolocation xa
                             WHERE xa.nik = a.nik AND xa.scheduledate = (select fdate from filter)
                             GROUP BY 1
                         )
                         GROUP BY 1
                     ) x
                )c ON TRUE
            WHERE TRUE
              AND a.nik = (select fnik from filter)
        ");
    }
}