<?php
class M_mail extends CI_Model{

	//function untuk mengambil data nip dan email
	function q_mail(){
		return $this->db->query("select a.nip, b.nmlengkap, a.tglreminder, b.email, d.subject, d.isi from sc_hrd.reminder_kontrak a
							left outer join sc_hrd.pegawai b on a.nip=b.nip
							left outer join sc_hrd.reminder c on a.tglreminder=c.tglreminder
							left outer join sc_mst.ketmail d on d.kdmail=c.kdmail
							where a.status!='S'");
	}
	
	function q_get_reminder($day){
		$day_start = date('Y-m-d', $day);
		return $this->db->query("select a.nip, b.nmlengkap, a.tglreminder, b.email, d.subject, d.isi, a.status from sc_hrd.reminder_kontrak a
							left outer join sc_hrd.pegawai b on a.nip=b.nip
							left outer join sc_hrd.reminder c on a.tglreminder=c.tglreminder
							left outer join sc_mst.ketmail d on d.kdmail=c.kdmail
							where a.tglreminder<='$day_start' and a.status='R'");
	}
	//Febri 17-04-2015
	function q_mark($status){
		 return $this->db->where('status', $status)->update('sc_hrd.reminder_kontrak', array('status' => 'S'));
	}
	//Febri 17-04-2015
	function q_get_mail(){
		return $this->db->query("select * from sc_hrd.ketmail");
	}
	//Febri 17-04-2015
	function q_input_mail($info_mail){
		return $this->db->insert("sc_hrd.ketmail", $info_mail);
	}
	//Febri 17-04-2015
	function q_edit_mail($info_mail,$kdmail){
		$this->db->where("kdmail", $info_mail['kdmail']);
		$this->db->update("sc_hrd.ketmail", $info_mail);
	}
	//Febri 17-04-2015
	function q_delete_mail($kdmail){
		$this->db->where("kdmail", $kdmail);
		$this->db->delete("sc_hrd.ketmail");
	}
}
