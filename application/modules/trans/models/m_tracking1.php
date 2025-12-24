<?php

class M_tracking extends CI_Model {
	function q_tracking($param = '') {
		return $this->db->query("
            SELECT a.docno, a.nik, b.nmlengkap, TO_CHAR(docdate, 'DD-MM-YYYY') AS tgl_dok, c.nmlengkap AS nmsaksi1, d.nmlengkap AS nmsaksi2, laporan, lokasi, uraian, solusi,
            e.dokumen_tg, TO_CHAR(e.enddate, 'DD-MM-YYYY') AS tgl_tg, dokumen_sp, TO_CHAR(f.enddate, 'DD-MM-YYYY') AS tgl_sp, dokumen_sp2, 
            TO_CHAR(g.enddate, 'DD-MM-YYYY') AS tgl_sp2, dokumen_sp3, TO_CHAR(h.enddate, 'DD-MM-YYYY') AS tgl_sp3
            FROM sc_trx.berita_acara a
            LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik 
            LEFT OUTER JOIN sc_mst.karyawan c ON a.saksi1 = c.nik
            LEFT OUTER JOIN sc_mst.karyawan d ON a.saksi2 = d.nik 
            LEFT OUTER JOIN (
                SELECT docno AS dokumen_tg, docref, tindakan, startdate, enddate
                FROM sc_trx.sk_peringatan 
                WHERE tindakan = 'TG'  
            ) AS e ON a.docno = e.docref
            LEFT OUTER JOIN (
                SELECT docno AS dokumen_sp, docref, tindakan, startdate, enddate
                FROM sc_trx.sk_peringatan 
                WHERE tindakan = 'SP1'
            ) AS f ON a.docno = f.docref
            LEFT OUTER JOIN (
                SELECT docno AS dokumen_sp2, docref, tindakan, startdate, enddate
                FROM sc_trx.sk_peringatan 
                WHERE tindakan = 'SP2'
            ) AS g ON a.docno = g.docref
            LEFT OUTER JOIN (
                SELECT docno AS dokumen_sp3, docref, tindakan, startdate, enddate
                FROM sc_trx.sk_peringatan 
                WHERE tindakan = 'SP3'
            ) AS h ON a.docno = h.docref
            WHERE COALESCE(a.docno, '') != ''
            $param
        ");
	}
}
