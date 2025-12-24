<?php

class M_Dashboard extends CI_Model{
    function document_list($clause = null){
        return $this->db->query($this->document_list_txt($clause));
    }

    function document_list_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
SELECT
    coalesce(trim(aa.nik),'') AS nik,
    coalesce(trim(aa.docno),'') AS docno,
    coalesce(trim(aa.document_type),'') AS document_type,
    aa.workdate,
    aa.start,
    aa.finish,
    aa.detail_information,
    aa.description,
    COALESCE(TRIM(aa.status),'') AS status,
    bb.nmlengkap AS fullname,
    dd.nmdept AS department_name,
    ff.nmsubdept AS subdepartment_name,
    gg.nmjabatan AS position_name,
    CONCAT(COALESCE(TRIM(bb.nik), ''), '.', COALESCE(TRIM(bb.nik_atasan), ''), '.', COALESCE(TRIM(bb.nik_atasan2), ''), '.',coalesce(aa.witness),'') AS search,
   CASE
       WHEN document_type = 'CT' THEN 'CUTI'
       WHEN document_type = 'LB' THEN 'LEMBUR'
       WHEN document_type = 'DN' THEN 'DINAS'
       WHEN document_type = 'BA' THEN 'BERITA ACARA'
       ELSE cc.nmijin_absensi
       END AS document_name
FROM (
         SELECT
               a.nik,
               a.nik AS witness,
               a.nodok AS docno,
               'CT' AS document_type,
               TO_CHAR(tgl_dok, 'YYYY-MM-DD') AS workdate,
               '' AS start,
               '' AS finish,
               to_char(tgl_mulai,'DD-MM-YYYY')||'<br>'||' s/d '||'<br>'|| to_char(tgl_selesai,'DD-MM-YYYY') AS detail_information,
               a.keterangan AS description,
               a.status AS status
           FROM sc_trx.cuti_karyawan a
           UNION ALL
           SELECT
               a.nik,
               a.nik AS witness,
               a.nodok AS docno,
               a.kdijin_absensi AS document_type,
               TO_CHAR(tgl_kerja, 'YYYY-MM-DD') AS workdate,
               '' AS start,
               '' AS finish,
               concat(to_char(tgl_kerja,'DD-MM-YYYY')||'<br>'||to_char(tgl_jam_mulai,'HH:MI:SS')||' s/d '||to_char(tgl_jam_selesai,'HH:MI:SS')) AS detail_information,
               a.keterangan AS description,
               a.status AS status
           FROM sc_trx.ijin_karyawan a
    
           UNION ALL
           SELECT
               a.nik,
               a.nik AS witness,
               a.nodok AS docno,
               'LB' AS document_type,
               TO_CHAR(tgl_kerja, 'YYYY-MM-DD') AS workdate,
               '' AS start,
               '' AS finish,
               TO_CHAR(tgl_kerja, 'DD-MM-YYYY')||chr(10)||'<br>'||concat(cast(cast(floor(durasi/60.) as integer)as character(12))|| ' Jam '||
                               cast(cast((durasi-(floor(durasi/60.)*60)) as integer)as character(12))||' Menit')::text||chr(10)||'<br>'||case
                                                                                                                                when a.jenis_lembur='D1' then 'DURASI ABSEN'
                                                                                                                                when a.jenis_lembur='D2' then 'NON DURASI'
                                                                                                                                else 'UNKNOWN' end AS detail_information,
               a.keterangan AS description,
               a.status AS status
           FROM sc_trx.lembur a
           UNION ALL
           SELECT
               a.nik,
               a.nik AS witness,
               a.nodok AS docno,
               'DN' AS document_type,
               TO_CHAR(tgl_dok, 'YYYY-MM-DD') AS workdate,
               '' AS start,
               '' AS finish,
               to_char(tgl_mulai,'DD-MM-YYYY')||'<br>'||' s/d '||'<br>'|| to_char(tgl_selesai,'DD-MM-YYYY') AS detail_information,
               a.keperluan AS description,
               a.status AS status
           FROM sc_trx.dinas a
           UNION ALL
           SELECT
               a.nik,
               CONCAT(COALESCE(TRIM(a.saksi1), ''), '.', COALESCE(TRIM(a.saksi2), ''), '.') AS witness,
               a.docno AS docno,
               'BA' AS document_type,
               to_char(docdate,'YYYY-MM-DD') as workdate,
               '' as start,
               '' as finish,
               '<b>LAPORAN KEJADIAN:</b>'||'<br>'||b.nmkejadian||';<br>'||'<b>LOKASI:</b>'||'<br>'||a.lokasi||'<br>;'||'<b>SOLUSI:</b>'||'<br>'||a.solusi AS detail_information,
               a.uraian AS aditional_information,
               a.status AS status
           FROM sc_trx.berita_acara a
           LEFT OUTER JOIN sc_mst.kejadian b ON a.laporan = b.kdkejadian
     ) aa
    LEFT OUTER JOIN sc_mst.karyawan bb ON aa.nik = bb.nik
    LEFT OUTER JOIN sc_mst.ijin_absensi cc ON aa.document_type = cc.kdijin_absensi
    LEFT OUTER JOIN sc_mst.departmen dd ON bb.bag_dept = dd.kddept
    LEFT OUTER JOIN sc_mst.subdepartmen ff ON bb.bag_dept = ff.kddept AND bb.subbag_dept = ff.kdsubdept
    LEFT OUTER JOIN sc_mst.jabatan gg ON bb.jabatan = gg.kdjabatan
ORDER BY workdate DESC
) as aaa
WHERE TRUE
SQL
            ).$clause;
    }

    function update_status_document_list($docno,$documentType,$status,$reason = null){
        $value = array('status'=>$status);
        switch (strtoupper($documentType)){
            case "CT":
                $where = array('nodok'=>$docno);
                $this->db
                    ->where($where)
                    ->update('sc_trx.cuti_karyawan', $value);
                return ($this->db->affected_rows() > 0);
                break;
            case "LB":
                $where = array('nodok'=>$docno);
                if (trim($status) == 'P'){
                    $value['approve_reason'] = $reason;
                }else{
                    $value['reject_reason'] = $reason;
                }
                $this->db
                    ->where($where)
                    ->update('sc_trx.lembur', $value);
                return ($this->db->affected_rows() > 0);
                break;
            case "DN":
                $where = array('nodok'=>$docno);
                $this->db
                    ->where($where)
                    ->update('sc_trx.dinas', $value);
                return ($this->db->affected_rows() > 0);
                break;
            case "BA":
                $where = array('docno'=>$docno);
                $this->db
                    ->where($where)
                    ->update('sc_trx.berita_acara', $value);
                return ($this->db->affected_rows() > 0);
                break;
            default:
                $where = array('nodok'=>$docno);
                $this->db
                    ->where($where)
                    ->update('sc_trx.ijin_karyawan', $value);
                return ($this->db->affected_rows() > 0);
                break;
        }
    }

    function generateConditee(){
        return $this->db->query("select sc_pk.pr_autogenerate_conditee('SYSTEM');");
    }

    function recalculateConditee($date = null){
        $beginDate = (is_null($date) ? date('Y-m-d') : $date);
        return $this->db->query("select sc_pk.pr_autogenerate_conditee_recalculate_month('SYSTEM','$beginDate');");
    }

    function recalculateConditeeUser($date = null){
        $beginDate = (is_null($date) ? date('Y-m-d') : $date);
        $user = trim($this->session->userdata('nik'));
        return $this->db->query("select sc_pk.pr_autogenerate_conditee_recalculate_month_nik('SYSTEM','$user','$beginDate');");
    }


}