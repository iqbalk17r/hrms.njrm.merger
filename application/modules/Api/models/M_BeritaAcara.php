<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_BeritaAcara extends CI_Model
{
 function q_whatsapp_collect_where($clause = null)
    {
        return $this->db
            ->query(
                sprintf(
                    <<<'SQL'
                  SELECT * 
            FROM (
                SELECT 
                    a.*, d.nmdept as departmen_tujuan, b.nmlengkap, b.nmdept, b.bag_dept, b.nmjabatan, b.nik_atasan AS nikatasan1, b.nik_atasan2 AS nikatasan2, b.nmatasan1, b.nmatasan2,c1.nohp1 as nohpatasan1,c2.nohp1 as nohpatasan2,appr.nik as nikhrd,c3.nmlengkap as nmhrd,c3.nohp1 as nohphrd,b.nmsubdept, 
                    b.nmlvljabatan, b.alamattinggal, COALESCE(b.nohp1, b.nohp2, '-') AS nohp1, COALESCE(b.email, '') AS email, z.uraian AS nmstatus, b1.nmlengkap AS s1_nmlengkap, 
                    b2.nmlengkap AS s2_nmlengkap, b3.nmkejadian AS nmlaporan, COALESCE(b4.docname, a.tindaklanjut) AS nmtindakan, 
                    COALESCE(b6.nmlengkap, '-') AS nmpelapor, TO_CHAR(NOW(),'DD-MM-YYYY') AS now,
                    CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
                    CONCAT(COALESCE(TRIM(a.saksi1), ''), '.', COALESCE(TRIM(a.saksi2), '')) AS witness, k.nmlengkap as nmhrdapprove, 
                    	case 
				    when  coalesce(a.status,'') = 'A1' then CONCAT(REGEXP_REPLACE(
                CASE LEFT(COALESCE(TRIM(c1.nohp1), '08815574311'), 1)
                WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c1.nohp1), '08815574311'), -1))
                ELSE COALESCE(TRIM(c2.nohp1), '08815574311')
                END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                        when  coalesce(a.status,'') = 'A2' then CONCAT(REGEXP_REPLACE(
                CASE LEFT(COALESCE(TRIM(c2.nohp1), '08815574311'), 1)
                WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c3.nohp1), '08815574311'), -1))
                ELSE COALESCE(TRIM(c3.nohp1), '08815574311')
                END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                        when  coalesce(a.status,'') = 'B' then CONCAT(REGEXP_REPLACE(
                CASE LEFT(COALESCE(TRIM(c3.nohp1), '08815574311'), 1)
                WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c3.nohp1), '08815574311'), -1))
                ELSE COALESCE(TRIM(c3.nohp1), '08815574311')
                END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                end as approver,
                sc_trx.generate_unique_token(8) AS identifier
                FROM sc_trx.berita_acara a
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b1 ON a.saksi1 = b1.nik
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b2 ON a.saksi2 = b2.nik
                LEFT OUTER JOIN sc_mst.kejadian b3 ON a.laporan = b3.kdkejadian
                LEFT OUTER JOIN sc_mst.sk_peringatan b4 ON a.tindakan = b4.docno
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b6 ON a.inputby = b6.nik
                LEFT OUTER JOIN sc_mst.departmen d ON a.todepartmen = d.kddept
                LEFT OUTER JOIN sc_mst.karyawan c1 ON b.nik_atasan = c1.nik
                LEFT OUTER JOIN sc_mst.karyawan c2 ON b.nik_atasan2 = c2.nik
                LEFT OUTER JOIN sc_mst.karyawan k ON a.hrd_approveby = k.nik
                LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx and z.jenistrx = 'I.T.B.27'
                LEFT JOIN LATERAL (
		    SELECT nik
		    FROM sc_pk.master_appr_list
		    WHERE jobposition = 'HRGA'
		) appr ON TRUE
		LEFT OUTER JOIN sc_mst.karyawan c3 ON appr.nik = c3.nik
                ORDER BY a.docdate DESC
            ) AS x 
            WHERE COALESCE(docno, '') != ''
SQL
                ) . $clause
            );
    }
}
