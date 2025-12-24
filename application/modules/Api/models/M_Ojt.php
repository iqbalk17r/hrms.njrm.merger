<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Ojt extends CI_Model
{
 function q_ojt($clause = null)
    {
        return $this->db
            ->query(
                sprintf(
                    <<<'SQL'
                    select *,z.kddok ,to_char(y.duedate_ojt,'dd-mm-yyyy') as tgl_ojt,  case 
                        when valueday<0 then 'TERLEWAT '||(valueday)*-1||' HARI' 
                        when valueday=0 then 'PAS HARI INI' 
                        when valueday>0 then 'KURANG '||(valueday)||' HARI LAGI' 
                        else '' end as eventketerangan 
                        from sc_mst.lv_m_karyawan x
                        left outer join (select a.*,b.nmkepegawaian,duedate_ojt-cast(now() as date) as valueday from (
                        select a.* from sc_trx.status_kepegawaian a, (	
                        select nik,kdkepegawaian,max(nodok) as nodok from sc_trx.status_kepegawaian 
                        group by nik,kdkepegawaian)b 
                        where a.nik=b.nik and a.kdkepegawaian = b.kdkepegawaian and a.nodok=b.nodok) a
                        left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
                        where a.ojt = 'T' and status = 'B' order by input_date desc
                        ) as y on x.nik=y.nik and x.statuskepegawaian=y.kdkepegawaian
                        left outer join sc_pk.rekap_ojt z on y.nodok = z.kddok 
                        where coalesce(statuskepegawaian,'') != 'KO' 
                        and valueday BETWEEN -7 AND 7 and y.status='B' and coalesce(z.kddok, '') = '' 
                        order by y.duedate_ojt desc limit 15
SQL
                ) . $clause
            );
    }

     function q_whatsapp_collect_where($clause = null)
    {
        return $this->db
            ->query(
                sprintf(
                    <<<'SQL'
                      select a.*,CONCAT(REGEXP_REPLACE(
CASE LEFT(COALESCE(TRIM(b.nohp1), '08815574311'), 1)
WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(b.nohp1), '08815574311'), -1))
ELSE COALESCE(TRIM(b.nohp1), '08815574311')
END, '[^\w]+', '', 'g'), '@s.whatsapp.net') as nohp1, sc_trx.generate_unique_token(8) AS identifier
from(
SELECT unnest(string_to_array(value1, ',')) AS nik
FROM sc_mst.option 
WHERE kdoption = 'NOTIF-OJT') as a
left outer join sc_mst.karyawan b on a.nik = b.nik
SQL
                ) . $clause
            );
    }
}
