<?php
class M_modular extends CI_Model {
	function list_modul() {
		return $this->db->query("
            SELECT * 
            FROM sc_mst.mdlprg		
		");
	}

    function q_broadcast_dashboard() {
        return $this->db->query("
            SELECT *
            FROM sc_mst.option
            WHERE kdoption = 'BCDASH' AND status = 'T'
        ");
    }
}
