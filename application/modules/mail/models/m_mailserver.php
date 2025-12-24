<?php
class M_mailserver extends CI_Model{
	function karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where statuskepegawaian<>'KO' order by nmlengkap");
	}
	function cekkaryawan($nik){
		return $this->db->query("select * from sc_mst.karyawan where statuskepegawaian<>'KO' and nik='$nik' order by nmlengkap");
	}
	
	function q_mailreceipt_list(){
		return $this->db->query("select * from sc_mst.setup_mail_sender where trim(type_owner)='receipients' order by no_dok");
	}
	function q_mailreceipt_send_kontr(){
		return $this->db->query("select * from sc_mst.setup_mail_sender where trim(type_owner)='receipients' and mail_hold='f' and type_receipt='REMDKT'");
	}
	function q_mailreceipt_send_pens(){
		return $this->db->query("select * from sc_mst.setup_mail_sender where trim(type_owner)='receipients' and mail_hold='f' and type_receipt='REMDPEN'");
	}
	
	function q_mailreceipt_dtl($no_dok){
		return $this->db->query("select * from sc_mst.setup_mail_sender where trim(type_owner)='receipients' and no_dok='$no_dok'");
	}
	function q_nik_receipt($nik){
		return $this->db->query("select * from sc_mst.setup_mail_sender where trim(type_owner)='receipients' and nik='$nik'");
	}
		
	
	function q_mailsender(){
		return $this->db->query("select * from sc_mst.setup_mail_sender where trim(nik)='1' and trim(type_owner)='sender'");
	}
	function q_smtp($no_dok){
		return $this->db->query("select * from sc_mst.setup_mail_smtp where no_dok='$no_dok'");
	}

    function q_base_url_email(){
        return $this->db->query("select value1 from sc_mst.option where kdoption='BUE'");
    }
	
}	