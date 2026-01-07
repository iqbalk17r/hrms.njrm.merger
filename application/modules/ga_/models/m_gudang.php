<?php
class M_gudang extends CI_Model{
	
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
	
    function q_mgudang(){
	    return $this->db->query("select * from sc_mst.mgudang order by locaname asc");
    }
	
}


