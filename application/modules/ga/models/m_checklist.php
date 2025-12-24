<?php
class M_checklist extends CI_Model {
    function list_checklist($params = "") {
        return $this->db->query("
            SELECT a.*, b.nama_periode, c.nama_lokasi, CASE
                WHEN a.kode_periode = 'JAM' THEN TO_CHAR(a.tanggal_mulai, 'DD-MM-YYYY')
                WHEN a.kode_periode = 'HARI' THEN TO_CHAR(a.tanggal_mulai, 'MM-YYYY')
                WHEN a.kode_periode = 'BULAN' THEN TO_CHAR(a.tanggal_mulai, 'YYYY')
                WHEN a.kode_periode = 'TAHUN' THEN TO_CHAR(a.tanggal_mulai, 'YYYY')
            END AS tanggal, CASE
                WHEN a.kode_periode = 'JAM' THEN TO_CHAR(a.tanggal_mulai, 'DD-MM-YYYY')
                WHEN a.kode_periode = 'HARI' THEN TO_CHAR(a.tanggal_mulai, 'MM-YYYY')
                WHEN a.kode_periode = 'BULAN' THEN TO_CHAR(a.tanggal_mulai, 'YYYY')
                WHEN a.kode_periode = 'TAHUN' THEN TO_CHAR(a.tanggal_mulai, 'YYYY') || '-' || TO_CHAR(a.tanggal_selesai, 'YYYY')
            END AS tanggal_label
            FROM sc_trx.checklist a
            INNER JOIN sc_mst.checklist_periode b ON b.kode_periode = a.kode_periode
            INNER JOIN sc_mst.checklist_lokasi c ON c.kode_lokasi = a.kode_lokasi
            WHERE a.delete_date IS NULL
            $params
        ");
    }

    function list_realisasi($params = "") {
        return $this->db->query("
            SELECT b.*, d.off AS off_user, d.tanggal_hasil, e.nama_periode, f.nama_lokasi
            FROM sc_trx.checklist a
            INNER JOIN sc_trx.checklist_tanggal b ON b.id_checklist = a.id_checklist
            INNER JOIN sc_trx.checklist_user c ON c.id_checklist = a.id_checklist
            LEFT JOIN LATERAL (
                SELECT *
                FROM sc_trx.checklist_realisasi x
                WHERE x.id_checklist = a.id_checklist AND x.nik = c.nik AND x.tanggal_mulai = b.tanggal_mulai AND x.tanggal_selesai = b.tanggal_selesai
                LIMIT 1
            ) d ON TRUE
            INNER JOIN sc_mst.checklist_periode e ON e.kode_periode = a.kode_periode
            INNER JOIN sc_mst.checklist_lokasi f ON f.kode_lokasi = a.kode_lokasi
            WHERE a.delete_date IS NULL 
            $params
            ORDER BY b.tanggal_mulai, b.tanggal_selesai
        ");
    }

    function list_realisasi_hasil($params = "") {
        return $this->db->query("
            SELECT c.*, d.urutan, d.nama_parameter, d.target_parameter
            FROM sc_trx.checklist a
            INNER JOIN sc_trx.checklist_tanggal b ON b.id_checklist = a.id_checklist
            INNER JOIN sc_trx.checklist_realisasi c ON c.id_checklist = a.id_checklist AND c.tanggal_mulai = b.tanggal_mulai AND c.tanggal_selesai = b.tanggal_selesai
            INNER JOIN sc_trx.checklist_parameter d ON d.id_checklist = a.id_checklist AND d.kode_parameter = c.kode_parameter
            WHERE a.delete_date IS NULL AND NOW() BETWEEN b.tanggal_mulai AND b.tanggal_selesai AND b.off = 'F' 
            $params
            ORDER BY d.urutan, d.nama_parameter
        ");
    }

    function list_checklist_user($params = "") {
        return $this->db->query("
            SELECT *
            FROM sc_trx.checklist_user
            $params
        ");
    }

    function list_checklist_parameter($params = "", $nik = "", $tanggal = "") {
        return $this->db->query("
            SELECT a.*, b.hasil, b.realisasi, b.keterangan, b.tanggal_hasil
            FROM sc_trx.checklist_parameter a
            LEFT JOIN sc_trx.checklist_realisasi b ON b.id_checklist = a.id_checklist AND b.kode_parameter = a.kode_parameter AND b.nik = '$nik' AND b.tanggal_mulai::TEXT = '$tanggal'
            WHERE CASE 
                WHEN '$nik' != '' THEN a.id_checklist = b.id_checklist
                ELSE TRUE
            END
            $params
        ");
    }

    function list_checklist_tanggal($params = "", $nik = "") {
        return $this->db->query("
            SELECT a.*, b.nik, b.off AS off_user
            FROM sc_trx.checklist_tanggal a
            LEFT JOIN LATERAL (
                SELECT *
                FROM sc_trx.checklist_realisasi ax
                WHERE ax.id_checklist = a.id_checklist AND ax.tanggal_mulai = a.tanggal_mulai AND ax.nik = '$nik'
                LIMIT 1
            ) b ON TRUE
            $params
            ORDER BY tanggal_mulai
        ");
    }

    function list_checklist_tanggal_dis($params = "") {
        return $this->db->query("
            SELECT DISTINCT tanggal_mulai::DATE
            FROM sc_trx.checklist
            WHERE delete_date IS NULL
            $params
            ORDER BY 1
        ");
    }
}	
