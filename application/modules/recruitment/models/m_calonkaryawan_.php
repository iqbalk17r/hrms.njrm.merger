<?php
class M_calonkaryawan extends CI_Model{
	function q_calonkaryawan(){
		return $this->db->query("select *,to_char(age(tgllahir),'YY') as usia from sc_rec.calonkaryawan order by nmlengkap asc");
	}
	
	function q_cekcalonkaryawan($noktp){
		return $this->db->query("select * from sc_rec.calonkaryawan where trim(noktp)='$noktp'");
	}
	function insert_master($data){
        $insert = $this->db->insert('sc_rec.calonkaryawan',$data);
        return $insert?true:false;
    }
	function insert_pendidikan($data = array()){
        $insert = $this->db->insert_batch('sc_rec.riwayat_pendidikan',$data);
        return $insert?true:false;
    }
	function insert_pekerjaan($data = array()){
        $insert = $this->db->insert_batch('sc_rec.riwayat_pengalaman',$data);
        return $insert?true:false;
    }
	function insert_image($data = array()){
        $insert = $this->db->insert('sc_rec.lampiran',$data);
        return $insert?true:false;
    }
	function insert_attachment($data = array()){
        $insert = $this->db->insert_batch('sc_rec.lampiran',$data);
        return $insert?true:false;
    }
	
}	