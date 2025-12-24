<?php
class M_finger extends Ci_model{
	
	function q_finger(){
		return $this->db->query("select * from sc_mst.fingerprint order by fingerid");
	}

	function q_userfinger(){
		return $this->db->query("select * from sc_mst.userfinger order by kdcabang,nik");
	}
	
	function q_edit_finger($fingerid){
		return $this->db->query("select * from sc_mst.fingerprint where fingerid='$fingerid'");
	}
	
	function list_userfinger(){
		return $this->db->query("select * from sc_mst.kantorwilayah where kdcabang not in ( select fingerid from sc_mst.fingerprint)");
	}

    function q_listwilayah(){
        return $this->db->query("select * from sc_mst.kantorwilayah");
    }
	
	function q_listwilayahdtl($kdcabang){
		return $this->db->query("select * from sc_mst.kantorwilayah where kdcabang='$kdcabang'");
	}
}
