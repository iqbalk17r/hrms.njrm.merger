<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Pk extends CI_Model
{
 function q_whatsapp_collect_where($clause = null)
    {
        return $this->db
            ->query(
                sprintf(
                    <<<'SQL'
                     select * from (
                            select a.*,
                            b.nmkepegawaian,
                            c.nik_atasan,
                            c.nmlengkap,
                            c1.nik as nik_atasan1,
                            c1.nohp1 as nohpa1,
                            c1.nmlengkap as nmlengkapa1,
                            c2.nik as nik_atasan2,
                            c2.nohp1 as nohpa2,
                            c2.nmlengkap as nmlengkapa2,
                            c3.nik as nik_appr,
                            c3.nmlengkap as nmlengkap_appr,
                            c3.nohp1 as nohpappr,
                            g.nmdept,
                            h.nmjabatan,
                            to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
                            to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,
                            d.uraian as nmstatus,
                            e.status as statuspen,
                            e.kddok, 
                            f.description as deskappr,
							case 
								when  coalesce(e.status,'') = '' then CONCAT(REGEXP_REPLACE(
                                    CASE LEFT(COALESCE(TRIM(c1.nohp1), '08815574311'), 1)
                                        WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c1.nohp1), '08815574311'), -1))
                                        ELSE COALESCE(TRIM(c1.nohp1), '08815574311')
                                    END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                                                            when  coalesce(e.status,'') = 'N' then CONCAT(REGEXP_REPLACE(
                                    CASE LEFT(COALESCE(TRIM(c2.nohp1), '08815574311'), 1)
                                        WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c2.nohp1), '08815574311'), -1))
                                        ELSE COALESCE(TRIM(c2.nohp1), '08815574311')
                                    END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                                                            when  coalesce(e.status,'') = 'A2' then CONCAT(REGEXP_REPLACE(
                                    CASE LEFT(COALESCE(TRIM(c3.nohp1), '08815574311'), 1)
                                        WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c3.nohp1), '08815574311'), -1))
                                        ELSE COALESCE(TRIM(c3.nohp1), '08815574311')
                                    END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                                                            when  coalesce(e.status,'') = 'HR' then CONCAT(REGEXP_REPLACE(
                                    CASE LEFT(COALESCE(TRIM(c3.nohp1), '08815574311'), 1)
                                        WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c3.nohp1), '08815574311'), -1))
                                        ELSE COALESCE(TRIM(c3.nohp1), '08815574311')
                                    END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                                                            when  coalesce(e.status,'') = 'GM' then CONCAT(REGEXP_REPLACE(
                                    CASE LEFT(COALESCE(TRIM(c3.nohp1), '08815574311'), 1)
                                        WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c3.nohp1), '08815574311'), -1))
                                        ELSE COALESCE(TRIM(c3.nohp1), '08815574311')
                                    END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
                                    else CONCAT(REGEXP_REPLACE(
                                    CASE LEFT(COALESCE(TRIM(c1.nohp1), '08815574311'), 1)
                                        WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c1.nohp1), '08815574311'), -1))
                                        ELSE COALESCE(TRIM(c1.nohp1), '08815574311')
                                    END, '[^\w]+', '', 'g'), '@s.whatsapp.net')
							end as approver,
                            sc_trx.generate_unique_token(8) AS identifier
							from sc_trx.status_kepegawaian a
							left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
							left outer join sc_mst.karyawan c on a.nik=c.nik
							left outer join sc_mst.karyawan c1 on c.nik_atasan=c1.nik
							left outer join sc_mst.karyawan c2 on c.nik_atasan2=c2.nik
							left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STSPEG'
							left outer join sc_pk.master_pk e on a.nodok=e.kdcontract
							left outer join sc_pk.master_appr_list appr on trim(
												CASE 
												    WHEN e.status = 'A2' THEN 'HRGA'
												    WHEN e.status = 'HR' THEN 'GM'
												    WHEN e.status = 'GM' THEN 'D'
												    ELSE e.status
												END
											    ) = trim(appr.jobposition)
							left outer join sc_mst.karyawan c3 on appr.nik = c3.nik
							left outer join sc_pk.master_appr f on e.status = f.kdappr
							left outer join sc_mst.departmen g on g.kddept = c.bag_dept
                            left outer join sc_mst.jabatan h on h.kdjabatan = c.jabatan
							where true
							and a.kdkepegawaian not in('KO', 'KT','MG','PK') 
							and a.status='B' 
							and coalesce(e.status,'') <> 'P'	
							and tgl_selesai - INTERVAL '2 months' <= CURRENT_DATE 
							--and a.nodok = 'STSPG0000156'
							order by a.tgl_selesai asc) as a where true
SQL
                ) . $clause
            );
    }
}
