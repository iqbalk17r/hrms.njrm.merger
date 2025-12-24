<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Finger extends CI_Model {
    function q_log_read_where($clause = null){
        return $this->db->query($this->q_log_txt_where($clause));
    }
    function q_log_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT *,
       TO_CHAR(timestamp, 'dd-mm-yyyy, hh24:mi:ss') AS timestampformat
FROM (
    SELECT
        a.uid,
        a.punch,
        a.status,
        a.deviceid,
        c.devicename,
        a.userid,
        b.name AS username,
        a.timestamp
    FROM sc_log.checkin a
    LEFT OUTER JOIN sc_log.user b ON TRUE
    AND b.deviceid = a.deviceid
    AND b.userid = a.userid
    LEFT OUTER JOIN sc_log.device c ON TRUE
    AND CONCAT('SN=', c.serialnumber, ',MAC=', c.mac) = a.deviceid
    ORDER BY timestamp
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }
}
