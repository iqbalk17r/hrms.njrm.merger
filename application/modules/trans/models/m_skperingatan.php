<?php
class M_skPeringatan extends CI_Model {
    function read_trxskperingatan($param = '') {
        return $this->db->query("
            SELECT * 
            FROM (
                SELECT 
                    a.*, 
                    CASE 
                        WHEN a.startdate IS NULL OR a.enddate IS NULL THEN '' 
                        ELSE TO_CHAR(a.startdate, 'DD-MM-YYYY') || ' - ' || TO_CHAR(a.enddate, 'DD-MM-YYYY') 
                    END AS startdatex, 
                    b.nmlengkap, 
                    b.nmdept, 
                    b.bag_dept, 
                    b.nmjabatan, 
                    b.nik_atasan AS nikatasan1, 
                    b.nmatasan1, 
                    b.nik_atasan2 AS nikatasan2, 
                    b.nmatasan2, 
                    b.nmsubdept, 
                    e.jabatan_cetak,
                    f.dept_cetak,
                    b.nmlvljabatan, 
                    b.alamattinggal, 
                    COALESCE(b.nohp1, b.nohp2, '-') AS nohp1, 
                    COALESCE(b.email, '') AS email, 
                    c.docname AS spname, 
                    z.uraian AS nmstatus, 
                    d.docno AS nmdocref,                 
                    TO_CHAR(a.startdate, 'DD-MM-YYYY') AS startdate1, 
                    TO_CHAR(a.enddate, 'DD-MM-YYYY') AS enddate1, 
                    TO_CHAR(a.docdate, 'DD-MM-YYYY') AS docdate2,
                    CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors
                FROM sc_trx.sk_peringatan a
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
                LEFT OUTER JOIN sc_mst.sk_peringatan c ON a.tindakan = c.docno
                LEFT OUTER JOIN sc_trx.berita_acara d ON a.nik = d.nik AND a.docref = d.docno
                LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx AND z.jenistrx = 'I.T.B.27'
                left outer join sc_mst.jabatan e on b.jabatan = e.kdjabatan
                left outer join sc_mst.departmen f on b.bag_dept = f.kddept
                ORDER BY a.docdate DESC
            ) AS x 
            WHERE COALESCE(docno, '') != ''
            $param
        ");
    }

    function read_tmpskperingatan($param = '') {
        return $this->db->query("
            SELECT 
                *,
                TO_CHAR(startdate, 'DD-MM-YYYY') AS formatstartdate   
            FROM (
                SELECT 
                    a.*, 
                    CASE WHEN a.startdate IS NULL OR a.enddate IS NULL 
                        THEN '' 
                        ELSE TO_CHAR(a.startdate, 'DD-MM-YYYY') || ' - ' || TO_CHAR(a.enddate, 'DD-MM-YYYY') 
                    END AS startdatex, b.nmlengkap, b.nmdept, b.bag_dept, b.nmjabatan, b.nik_atasan AS nikatasan1, b.nmatasan1, b.nik_atasan2 AS nikatasan2, b.nmatasan2, 
                    b.nmsubdept, b.nmlvljabatan, b.alamattinggal, COALESCE(b.nohp1, b.nohp2, '-') AS nohp1, COALESCE(b.email, '') AS email, c.docname AS spname, 
                    z.uraian AS nmstatus, d.docno AS nmdocref, TO_CHAR(a.startdate, 'DD-MM-YYYY') AS startdate1, TO_CHAR(a.enddate, 'DD-MM-YYYY') AS enddate1, 
                    TO_CHAR(a.docdate, 'DD-MM-YYYY') AS docdate2
                FROM sc_tmp.sk_peringatan a
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
                LEFT OUTER JOIN sc_mst.sk_peringatan c ON a.tindakan = c.docno
                LEFT OUTER JOIN sc_trx.berita_acara d ON a.nik = d.nik AND a.docref = d.docno
                LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx AND z.jenistrx = 'I.T.B.27'
            ) AS x 
            WHERE COALESCE(docno, '') != ''
            $param
        ");
    }

    function q_lv_m_karyawan($param = '') {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.lv_m_karyawan 
            WHERE TRUE
            AND COALESCE(statuskepegawaian, '') != 'KO' 
            $param 
            ORDER BY nmlengkap
        ");
    }

    function q_lv_m_karyawan_detail($param = '') {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.lv_m_karyawan 
            WHERE TRUE
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

    function q_list_master_tindakan($param = '') {
        return $this->db->query("
            SELECT *
            FROM sc_mst.sk_peringatan 
            WHERE docno IS NOT NULL 
            $param
            ORDER BY docno
        ");
    }

    function q_list_docref($param = '', $param_skp = '') {
        return $this->db->query("
            SELECT *
            FROM sc_trx.berita_acara
            WHERE status = 'P' AND peringatan = 'y'
            AND docno NOT IN (SELECT docref FROM sc_trx.sk_peringatan WHERE status != 'X' $param_skp)
            $param
            ORDER BY docno
        ");
    }

    function q_option_cetak($docno) {
        return $this->db->query("
            WITH setfilter AS (
            SELECT
                '$docno'::TEXT AS docno
            )
            select
                a.kepala_rd,
                a.nodok,
                a.tgl_berlaku,
                a.revisi,
                a.halaman,
                a.configsignature,
                b.docno,
                b.inputby,
                CASE
                    WHEN configsignature = 'Y' THEN kepala_sdm
                    ELSE UPPER(c.nmlengkap)
                END AS kepala_sdm,
                CASE
                    WHEN configsignature = 'Y' THEN jabatan_sdm
                    ELSE UPPER(d.nmjabatan)
                END AS position_name
            FROM (
                 SELECT
                     MAX(CASE WHEN kdoption = 'DOK1' THEN value1 END) AS kepala_sdm,
                     MAX(CASE WHEN kdoption = 'DOK2' THEN value1 END) AS kepala_rd,
                     MAX(CASE WHEN kdoption = 'DOK3' THEN value1 END) AS jabatan_sdm,
                     MAX(CASE WHEN kdoption = 'SPC1' THEN value1 END) AS nodok,
                     MAX(CASE WHEN kdoption = 'SPC2' THEN value1 END) AS tgl_berlaku,
                     MAX(CASE WHEN kdoption = 'SPC3' THEN LPAD(value3::TEXT, 2, '0') END) AS revisi,
                     MAX(CASE WHEN kdoption = 'SPC4' THEN value3 END) || ' dari ' || MAX(CASE WHEN kdoption = 'SPC5' THEN value3 END) AS halaman,
                     MAX(CASE WHEN kdoption = 'SIGNATUREBYCONFIG' THEN LEFT(upper(value1),1) END) AS configsignature
                 FROM sc_mst.option
                 WHERE kdoption IN ('DOK1', 'DOK2', 'SPC1', 'SPC2', 'SPC3', 'SPC4', 'SPC5','DOK3','SIGNATUREBYCONFIG')
                 GROUP BY group_option
            ) a,setfilter
            LEFT OUTER JOIN sc_trx.sk_peringatan b ON TRUE AND trim(b.docno) = setfilter.docno
            LEFT OUTER JOIN sc_mst.karyawan c ON b.inputby = c.nik
            LEFT OUTER JOIN sc_mst.jabatan d ON c.bag_dept = d.kddept AND c.subbag_dept = d.kdsubdept AND c.jabatan = d.kdjabatan
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
    select
        COALESCE(TRIM(a.docno), '') AS docno ,
        COALESCE(TRIM(a.nik), '') AS nik ,
        a.docdate,
        COALESCE(TRIM(a.status), '') AS status ,
        a.startdate,
        a.enddate,
        CONCAT(to_char(a.startdate, 'dd-mm-yyyy'), ' s/d ',to_char(a.enddate, 'dd-mm-yyyy')) AS format_periode,
        COALESCE(TRIM(a.tindakan), '') AS tindakan ,
        COALESCE(TRIM(a.docref), '') AS docref ,
        COALESCE(TRIM(a.description), '') AS description ,
        COALESCE(TRIM(a.solusi), '') AS solusi ,
        COALESCE(TRIM(a.att_name), '') AS att_name ,
        COALESCE(TRIM(a.att_dir), '') AS att_dir ,
        COALESCE(TRIM(a.docnotmp), '') AS docnotmp ,
        COALESCE(TRIM(a.inputby), '') AS inputby ,
        a.inputdate,
        COALESCE(TRIM(a.updateby), '') AS updateby ,
        a.updatedate,
        COALESCE(TRIM(a.cancelby), '') AS cancelby ,
        a.canceldate,
        COALESCE(TRIM(a.approveby), '') AS approveby ,
        a.approvedate,
        concat(COALESCE(TRIM(c.nmdept), ''),' (', COALESCE(TRIM(d.nmsubdept), ''),')') AS dept_name,
        CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
        COALESCE(TRIM(b.nmlengkap),'') AS nmlengkap ,
        COALESCE(TRIM(f.docname),'') AS docname ,
        COALESCE(TRIM(z.uraian),'') AS status_name
    from sc_trx.sk_peringatan a
    LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
    LEFT OUTER JOIN sc_mst.departmen c ON b.bag_dept = c.kddept
    LEFT OUTER JOIN sc_mst.subdepartmen d ON b.bag_dept = c.kddept AND b.subbag_dept = d.kdsubdept
    LEFT OUTER JOIN sc_trx.berita_acara e ON a.docref = e.docno
    LEFT OUTER JOIN sc_mst.sk_peringatan f ON a.tindakan = f.docno
    LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx AND z.jenistrx = 'I.T.B.27'
    ORDER BY a.docno ASC 
) as aa
WHERE TRUE 
SQL
            ).$clause;
    }

    function dashboardSkP($nik) {
        return $this->db->query("select b.docname, a.startdate,a.enddate from sc_trx.sk_peringatan a
        join sc_mst.sk_peringatan b on b.docno = a.tindakan
        where a.status = 'P' and a.tindakan not in ('TT','TL') and nik = '$nik'
        order by enddate desc limit 1");
    }

}


