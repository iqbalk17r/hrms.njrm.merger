<?php
class M_filetrans extends CI_Model{
	function q_im_backup_db(){
		return $this->db->query("select * from sc_im.backup_db order by nmlisting ASC");
	}
	

	
}	