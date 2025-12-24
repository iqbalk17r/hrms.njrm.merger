<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Ijin extends CI_Model
{

    function q_trx_exists($where)
    {
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_trx.ijin_karyawan')
            ->num_rows() > 0 ? true : false;
    }

    function q_trx_create($value)
    {
        return $this->db
            ->insert('sc_trx.ijin_karyawan', $value);
    }

    function q_trx_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.ijin_karyawan', $value);
    }

    function q_whatsapp_collect_where($clause = null)
    {
        return $this->db
            ->query(
                sprintf(
                    <<<'SQL'
SELECT 
COALESCE(TRIM(ck.nodok),'') AS nodok, 
COALESCE(TRIM(ck.nik),'') AS nik, 
COALESCE(TRIM(k.nmlengkap),'') AS nama, 
ck.tgl_dok, 
COALESCE(TRIM(t.uraian),'') AS jenis_ijin, 
COALESCE(TRIM(d.nmdept),'') AS departmen, 
COALESCE(TRIM(s.nmsubdept),'') AS subdepartmen, 
COALESCE(TRIM(j.nmjabatan),'') AS jabatan, 
COALESCE(TRIM(k2.nmlengkap),'') AS atasan, 
COALESCE(TRIM(k2.nik),'') AS approver, 
TO_CHAR(ck.tgl_kerja, 'DD-MM-YYYY') AS tgl_kerja, 
ck.tgl_jam_mulai AS jam_mulai,
ck.tgl_jam_selesai AS jam_selesai,
COALESCE(TRIM(ck.status),'') AS status, 
COALESCE(TRIM(ck.keterangan),'') AS keterangan,
ck.input_date AS input_date, 
ck.approval_date AS approval_date,
COALESCE(TRIM(k4.nmlengkap),'') AS input_by,
CASE 
	WHEN COALESCE(TRIM(k5.nmlengkap),'') = '' THEN ck.approval_by 
	ELSE COALESCE(TRIM(k5.nmlengkap),'')
END AS approval_by,
COALESCE(TRIM(k5.nmlengkap),'') AS approval_by,
CONCAT(REGEXP_REPLACE(
        CASE LEFT(COALESCE(TRIM(k2.nohp1), '08815574311'), 1)
            WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(k2.nohp1), '08815574311'), -1))
            ELSE COALESCE(TRIM(k2.nohp1), '08815574311')
        END, '[^\w]+', '', 'g'), '@s.whatsapp.net') AS approverjid,
CONCAT(REGEXP_REPLACE(
        CASE LEFT(COALESCE(TRIM(k.nohp1), '08815574311'), 1)
            WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(k.nohp1), '08815574311'), -1))
            ELSE COALESCE(TRIM(k.nohp1), '08815574311')
        END, '[^\w]+', '', 'g'), '@s.whatsapp.net') AS userjid,
        CASE
	WHEN ck.type_ijin = 'DN' THEN 'DINAS'
	WHEN ck.type_ijin = 'PB' THEN 'PRIBADI'
END AS tipe_ijin,
COALESCE(TRIM(ck.kendaraan),'') AS kendaraan,
COALESCE(TRIM(ck.nopol),'') AS nopol,
ck.whatsappsent AS whatsappsent,
ck.whatsappaccept AS whatsappaccept,
ck.whatsappreject AS whatsappreject,
COALESCE(ck.retry,0) AS retry,
COALESCE(ck.properties->>'last_sent',null) AS last_sent
FROM 
sc_trx.ijin_karyawan ck
JOIN sc_mst.karyawan k ON ck.nik = k.nik 
JOIN sc_mst.karyawan k2 ON k.nik_atasan = k2.nik 
JOIN sc_mst.departmen d ON ck.kddept = d.kddept 
JOIN sc_mst.subdepartmen s ON ck.kdsubdept = s.kdsubdept 
JOIN sc_mst.jabatan j ON ck.kdjabatan = j.kdjabatan AND j.kdsubdept = s.kdsubdept 
JOIN sc_mst.lvljabatan l ON ck.kdlvljabatan = l.kdlvl 
JOIN sc_mst.karyawan k4 ON ck.input_by = k4.nik
LEFT OUTER JOIN sc_mst.karyawan k5 ON ck.approval_by = k5.nik
JOIN sc_mst.trxtype t ON ck.kdijin_absensi = t.kdtrx AND t.jenistrx = 'ABSEN'
WHERE TRUE
SQL
                ) . $clause
            );
    }
}
