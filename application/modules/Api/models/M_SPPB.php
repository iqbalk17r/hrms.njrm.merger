<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_SPPB extends CI_Model
{

    function q_trx_exists($where)
    {
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_trx.sppb_mst')
            ->num_rows() > 0 ? true : false;
    }

    function q_trx_create($value)
    {
        return $this->db
            ->insert('sc_trx.sppb_mst', $value);
    }

    function q_trx_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.sppb_mst', $value);
    }

    function q_whatsapp_collect_where($clause = null)
    {
        return $this->db
            ->query(
                sprintf(
                    <<<'SQL'
SELECT 
COALESCE(TRIM(ck.nodok),'') AS nodok, 
COALESCE(TRIM(ck.nodokref),'') AS nodokref, 
COALESCE(TRIM(ck.nik),'') AS nik, 
COALESCE(TRIM(k.nmlengkap),'') AS nama, 
ck.tgldok, 
TO_CHAR(ck.tgldok, 'DD-MM-YYYY') AS formattgldok,
COALESCE(TRIM(sd.nmbarang),'') AS nmbarang, 
COALESCE(TRIM(g.locaname),'') AS loccname, 
COALESCE(TRIM(d.nmdept),'') AS departmen, 
COALESCE(TRIM(s.nmsubdept),'') AS subdepartmen, 
COALESCE(TRIM(j.nmjabatan),'') AS jabatan, 
COALESCE(TRIM(k2.nmlengkap),'') AS atasan, 
COALESCE(TRIM(k2.nik),'') AS approver, 
COALESCE(TRIM(ck.status),'') AS status, 
COALESCE(TRIM(t.uraian),'') AS ketstatus, 
ck.inputdate AS input_date, 
ck.approvaldate AS approval_date,
COALESCE(TRIM(k4.nmlengkap),'') AS input_by,
CASE 
	WHEN COALESCE(TRIM(k5.nmlengkap),'') = '' THEN ck.approvalby 
	ELSE COALESCE(TRIM(k5.nmlengkap),'')
END AS approval_by,
CONCAT(REGEXP_REPLACE(
        CASE LEFT(COALESCE(TRIM(k2.nohp1), '08815574311'), 1)
            WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(k2.nohp1), '08815574311'), -1))
            ELSE COALESCE(TRIM(k2.nohp1), '08815574311')
        END, '[^\w]+', '', 'g'), '@s.whatsapp.net') AS approverjid,
ck.whatsappsent AS whatsappsent,
ck.whatsappaccept AS whatsappaccept,
ck.whatsappreject AS whatsappreject,
COALESCE(ck.retry,0) AS retry,
COALESCE(ck.properties->>'last_sent',null) AS last_sent
FROM 
sc_trx.sppb_mst ck
JOIN sc_mst.karyawan k ON ck.nik = k.nik 
JOIN sc_mst.karyawan k2 ON k.nik_atasan = k2.nik 
JOIN sc_mst.departmen d ON k.bag_dept = d.kddept 
JOIN sc_mst.subdepartmen s ON k.subbag_dept = s.kdsubdept 
JOIN sc_mst.jabatan j ON k.jabatan  = j.kdjabatan AND j.kdsubdept = s.kdsubdept 
JOIN sc_mst.lvljabatan l ON k.lvl_jabatan = l.kdlvl 
JOIN sc_mst.karyawan k4 ON ck.inputby = k4.nik
LEFT OUTER JOIN sc_mst.karyawan k5 ON ck.approvalby = k5.nik 
JOIN sc_mst.trxtype t ON ck.status = t.kdtrx AND t.jenistrx = 'KTSTOCK'
JOIN (select a.branch,a.nodok,a.stockcode,b.nmbarang 
		from (select branch,nodok,min(stockcode) as stockcode from sc_trx.sppb_dtl
        group by branch,nodok) as a 
        left outer join sc_mst.mbarang b on a.stockcode=b.nodok) as sd on ck.nodok=sd.nodok
JOIN sc_mst.mgudang g ON ck.loccode = g.loccode
WHERE TRUE
SQL
                ) . $clause
            );
    }
}
