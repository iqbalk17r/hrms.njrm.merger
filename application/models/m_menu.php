<?php
/*
	author : Junis P
	12-12-2014
*/
class M_menu extends CI_Model{
   
	public function q_menusidebar(){
		return $this->db->query("select * from SC_MST.usermdl order by progmodul");
	}	
}