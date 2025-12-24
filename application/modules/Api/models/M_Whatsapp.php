<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_WhatsApp extends CI_Model {
    function read($clause = null){
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT *
    FROM (
	SELECT
        a.notification_id,
        a.ticket_id,
        a.branch,
        a.type,
        a.subject,
        a.content,
        a.send_to,
        b.simsn,
        a.action,
        a.status,
        a.input_by,
        a.input_date,
        a.update_by,
        a.update_date
	FROM sc_trx.notifications a
	LEFT OUTER JOIN sc_mst.user b ON a.send_to = b.userid
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }

    function update($id)
    {
        return $this->db->query("
            UPDATE sc_trx.openauthorityso u SET
                wasent = TRUE,
                wasentdate = now()
            FROM sc_trx.openauthorityso a
            LEFT JOIN sc_mst.user b ON TRUE
                AND b.userid = a.sales
            LEFT JOIN sc_mst.userapproval c ON TRUE
                AND c.level = a.sendtipe
                AND c.current = a.status
                AND c.userid = b.custarea
            LEFT JOIN sc_mst.user d ON TRUE
                AND d.userid = c.approver
            WHERE TRUE
                AND u.authorityno = '$id'
                AND a.status IN ('2', '3')
                AND NOT a.wasent
                AND c.action = 'O.A.S.O'
        ");
    }

    function read_openauthorityso($clause) {
        return $this->db->query("
            
  $clause
                ");
    }
}