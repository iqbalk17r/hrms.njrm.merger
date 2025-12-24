<?php

class M_sberitaacara extends CI_Model {
    function read_trxberitaacara($param = '') {
        return $this->db->query("
            SELECT * 
            FROM (
                SELECT 
                    a.*, d.nmdept as departmen_tujuan, b.nmlengkap, b.nmdept, b.bag_dept, b.nmjabatan, b.nik_atasan AS nikatasan1, b.nik_atasan2 AS nikatasan2, b.nmatasan1, b.nmatasan2, b.nmsubdept, 
                    b.nmlvljabatan, b.alamattinggal, COALESCE(b.nohp1, b.nohp2, '-') AS nohp1, COALESCE(b.email, '') AS email, z.uraian AS nmstatus, b1.nmlengkap AS s1_nmlengkap, 
                    b2.nmlengkap AS s2_nmlengkap, b3.nmkejadian AS nmlaporan, COALESCE(b4.docname, a.tindaklanjut) AS nmtindakan, 
                    COALESCE(b6.nmlengkap, '-') AS nmpelapor, TO_CHAR(NOW(),'DD-MM-YYYY') AS now,
                    CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
                    CONCAT(COALESCE(TRIM(a.saksi1), ''), '.', COALESCE(TRIM(a.saksi2), '')) AS witness, k.nmlengkap as nmhrdapprove
                FROM sc_trx.berita_acara a
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b1 ON a.saksi1 = b1.nik
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b2 ON a.saksi2 = b2.nik
                LEFT OUTER JOIN sc_mst.kejadian b3 ON a.laporan = b3.kdkejadian
                LEFT OUTER JOIN sc_mst.sk_peringatan b4 ON a.tindakan = b4.docno
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b6 ON a.inputby = b6.nik
                LEFT OUTER JOIN sc_mst.departmen d ON a.todepartmen = d.kddept
                LEFT OUTER JOIN sc_mst.karyawan k ON a.hrd_approveby = k.nik
                LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx and z.jenistrx = 'I.T.B.27'
                ORDER BY a.docdate DESC
            ) AS x 
            WHERE COALESCE(docno, '') != ''
            $param
        ");
    }

    function read_tmpberitaacara($param = '') {
        return $this->db->query("
            SELECT * 
            FROM (
                SELECT 
                    a.*,
                    COALESCE(TRIM(a.saksi), '') AS formatsaksi,
                    b.nmlengkap, b.nmdept, b.bag_dept, b.nmjabatan, b.nik_atasan AS nikatasan1, b.nik_atasan2 AS nikatasan2, b.nmatasan1, b.nmatasan2, b.nmsubdept, 
                    b.nmlvljabatan, b.alamattinggal, COALESCE(b.nohp1, b.nohp2, '-') AS nohp1, COALESCE(b.email, '') AS email, z.uraian AS nmstatus, b1.nmlengkap AS s1_nmlengkap, 
                    b2.nmlengkap AS s2_nmlengkap, b3.nmkejadian AS nmlaporan, COALESCE(b4.docname, a.tindaklanjut) AS nmtindakan, 
                    COALESCE(b6.nmlengkap, '-') AS nmpelapor, TO_CHAR(NOW(),'DD-MM-YYYY') AS now
                FROM sc_tmp.berita_acara a
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b1 ON a.saksi1 = b1.nik
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b2 ON a.saksi2 = b2.nik
                LEFT OUTER JOIN sc_mst.kejadian b3 ON a.laporan = b3.kdkejadian
                LEFT OUTER JOIN sc_mst.sk_peringatan b4 ON a.tindakan = b4.docno
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b6 ON a.inputby = b6.nik
                LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx and z.jenistrx = 'I.T.C.1'
            ) AS x 
            WHERE COALESCE(docno, '') != ''
            $param
        ");
    }

    function q_lv_m_karyawan($param = '') {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.lv_m_karyawan 
            WHERE COALESCE(statuskepegawaian, '') != 'KO' 
            $param 
            ORDER BY nmlengkap
        ");
    }

    function q_list_master_kejadian($param = '') {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.kejadian 
            WHERE kdkejadian IS NOT NULL 
            $param
            ORDER BY nmkejadian
        ");
    }
    function q_list_master_departmen($param = '') {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.departmen 
            WHERE kddept IS NOT NULL 
            $param
            ORDER BY nmdept
        ");
    }

    function q_list_master_tindakan($param = '') {
        return $this->db->query("
            SELECT *
            FROM sc_mst.sk_peringatan 
            WHERE docno IS NOT NULL 
            $param
            ORDER BY docno
        ");
    }

    function q_option_cetak() {
        return $this->db->query("
            SELECT MAX(CASE WHEN kdoption = 'DOK1' THEN value1 END) AS kepala_sdm,
                MAX(CASE WHEN kdoption = 'BAC1' THEN value1 END) AS nodok,
                MAX(CASE WHEN kdoption = 'BAC2' THEN value1 END) AS tgl_berlaku,
                MAX(CASE WHEN kdoption = 'BAC3' THEN LPAD(value3::TEXT, 2, '0') END) AS revisi,
                MAX(CASE WHEN kdoption = 'BAC4' THEN value3 END) || ' dari ' || MAX(CASE WHEN kdoption = 'BAC5' THEN value3 END) AS halaman
            FROM sc_mst.option
            WHERE kdoption IN ('DOK1', 'BAC1', 'BAC2', 'BAC3', 'BAC4', 'BAC5')
            GROUP BY group_option
        ");
    }

    function q_transaction_read_where($clause = null){
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause = null){
        return sprintf(<<<'SQL'
SELECT 
    *,
    to_char(docdate, 'dd-mm-yyyy') AS format_docdate
FROM (
    SELECT
        COALESCE(TRIM(a.docno),'') AS docno ,
        COALESCE(TRIM(a.nik),'') AS nik ,
        a.docdate,
        COALESCE(TRIM(a.status),'') AS status ,
        COALESCE(TRIM(a.saksi),'') AS saksi ,
        COALESCE(TRIM(a.saksi1),'') AS saksi1 ,
        a.saksi1_approvedate,
        COALESCE(TRIM(a.saksi2),'') AS saksi2 ,
        a.saksi2_approvedate,
        COALESCE(TRIM(a.laporan),'') AS laporan ,
        COALESCE(TRIM(a.lokasi),'') AS lokasi ,
        COALESCE(TRIM(a.uraian),'') AS uraian ,
        COALESCE(TRIM(a.solusi),'') AS solusi ,
        COALESCE(TRIM(a.peringatan),'') AS peringatan ,
        COALESCE(TRIM(a.tindakan),'') AS tindakan ,
        COALESCE(TRIM(a.tindaklanjut),'') AS tindaklanjut ,
        COALESCE(TRIM(a.docnotmp),'') AS docnotmp ,
        COALESCE(TRIM(a.subjek),'') AS subjek ,
        COALESCE(TRIM(a.todepartmen),'') AS todepartmen ,
        COALESCE(TRIM(a.inputby),'') AS inputby ,
        a.inputdate,
        COALESCE(TRIM(a.updateby),'') AS updateby ,
        a.updatedate,
        COALESCE(TRIM(a.cancelby),'') AS cancelby ,
        a.canceldate,
        COALESCE(TRIM(a.approveby),'') AS approveby ,
        a.approvedate,
        COALESCE(TRIM(a.hrd_approveby),'') AS hrd_approveby ,
        a.hrd_approvedate,
        COALESCE(TRIM(b.nmlengkap),'') AS nmlengkap,
        concat(COALESCE(TRIM(d.nmdept), ''),' (', COALESCE(TRIM(e.nmsubdept), ''),')') AS dept_name,
        COALESCE(TRIM(d1.nmdept), '') AS to_dept_name,
        CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
        CONCAT(COALESCE(TRIM(a.saksi1), ''), '.', COALESCE(TRIM(a.saksi2), '')) AS witness,
        CASE
            WHEN saksi = 'f' THEN 'Tanpa Saksi'
            ELSE trim(concat(COALESCE(TRIM(c1.nmlengkap), ''),', ',COALESCE(TRIM(c2.nmlengkap), '')),', ')
        END AS witness_name,
        COALESCE(TRIM(z.uraian), '') AS status_name,
        COALESCE(TRIM(f.nmkejadian), '') AS accident_name
    FROM sc_trx.berita_acara a
    LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
    LEFT OUTER JOIN sc_mst.karyawan c1 ON a.saksi1 = c1.nik AND saksi <> 'f'
    LEFT OUTER JOIN sc_mst.karyawan c2 ON a.saksi2 = c2.nik AND saksi <> 'f'
    LEFT OUTER JOIN sc_mst.departmen d ON b.bag_dept = d.kddept
    LEFT OUTER JOIN sc_mst.departmen d1 ON a.todepartmen = d1.kddept
    LEFT OUTER JOIN sc_mst.subdepartmen e ON b.subbag_dept = e.kdsubdept
    LEFT OUTER JOIN sc_mst.kejadian f ON a.laporan = f.kdkejadian
    LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx and z.jenistrx = 'I.T.C.1'
    ORDER BY a.docno ASC 
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }
}
