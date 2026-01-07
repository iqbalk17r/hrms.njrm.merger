<?php
class M_checklist_master extends CI_Model {
	function list_periode($params = "") {
		return $this->db->query("
            SELECT * 
            FROM sc_mst.checklist_periode
            $params
            ORDER BY urutan
        ");
	}

    function list_lokasi($params = "") {
        return $this->db->query("
            SELECT *
            FROM sc_mst.checklist_lokasi a
            LEFT JOIN LATERAL (
                SELECT 1 AS used
                FROM sc_mst.checklist_parameter x
                WHERE x.kode_lokasi = a.kode_lokasi
                LIMIT 1
            ) b ON TRUE
            $params
            ORDER BY nama_lokasi
        ");
    }

    function list_parameter($params = "") {
        return $this->db->query("
            SELECT a.*, b.nama_periode, c.nama_lokasi, STRING_AGG (e.kddept, ', ' ORDER BY e.nmdept) AS kddept, 
                STRING_AGG (e.nmdept, ', ' ORDER BY e.nmdept) AS nmdept, f.used, ROW_NUMBER() OVER() AS urut
            FROM sc_mst.checklist_parameter a
            INNER JOIN sc_mst.checklist_periode b ON b.kode_periode = a.kode_periode
            INNER JOIN sc_mst.checklist_lokasi c ON c.kode_lokasi = a.kode_lokasi
            INNER JOIN sc_mst.checklist_parameter_dept d ON d.kode_parameter = a.kode_parameter
            INNER JOIN sc_mst.departmen e ON e.kddept = d.kddept
            LEFT JOIN LATERAL (
                SELECT 1 AS used
                FROM sc_trx.checklist_parameter x
                WHERE x.kode_parameter = a.kode_parameter
                LIMIT 1
            ) f ON TRUE
            $params
            GROUP BY a.kode_parameter, b.kode_periode, c.kode_lokasi, f.used
            ORDER BY urut, a.nama_parameter
        ");
    }
}	
