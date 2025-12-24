<?php
class M_calonkaryawan extends CI_Model{
	function q_calonkaryawan(){
		return $this->db->query("select *,to_char(age(tgllahir),'YY') as usia from sc_rec.calonkaryawan order by nmlengkap asc");
	}
	
	function q_cekcalonkaryawan($noktp){
		return $this->db->query("select * from sc_rec.calonkaryawan where trim(noktp)='$noktp'");
	}
	
	function q_riwayat_pendidikan($noktp){
		return $this->db->query("select * from sc_rec.riwayat_pendidikan where trim(noktp)='$noktp'");
	}
	function q_riwayat_pengalaman($noktp){
		return $this->db->query("select * from sc_rec.riwayat_pengalaman where  trim(noktp)='$noktp'");
	}
	
	function q_lampiran_dp($noktp){
		return $this->db->query("select * from sc_rec.lampiran where  trim(noktp)='$noktp' and ref_type='DP'");
	}
	function q_lampiran_at($noktp){
		return $this->db->query("select * from sc_rec.lampiran where  trim(noktp)='$noktp' and ref_type='AT'");
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
	
	function q_linkinputkaryawan($noktp){
		return $this->db->query("	select max(noktp) as noktp,max(nmlengkap) as nmlengkap,max(jk)as jk,trim(max(neglahir)) as neglahir,
									trim(max(kotalahir)) as kotalahir,max(tgllahir) as tgllahir,trim(max(kd_agama)) as kd_agama,trim(max(stswn)) as stswn, trim(max(status_pernikahan))  as status_pernikahan,trim(max(negtinggal)) as negtinggal,
									trim(max(provtinggal)) as provtinggal,trim(max(kotatinggal)) as kotatinggal,trim(max(kectinggal)) as kectinggal, trim(max(keltinggal)) as keltinggal, trim(max(alamattinggal)) as alamattinggal, cast(max(nohp1)as numeric) as nohp1,cast(max(nohp1)as numeric) as nohp2,
									trim(max(email)) as email, max(inputdate) as inputdate, max(inputby) as inputby, max(updatedate) as updatedate, max(updateby) as updateby, max(image) as image, max(status) as status, max(kdposisi) as kdposisi,
									max(imageupload) as imageupload, max(fileupload) as fileupload,max(tgllowongan) as tgllowongan,max(tgllamaran)as tgllamaran from sc_rec.calonkaryawan
									where noktp='$noktp'
									group by noktp");
	}
	
	function q_maxktpcalon(){
		return $this->db->query("	select max(noktp) as noktp,max(nmlengkap) as nmlengkap,max(jk)as jk,trim(max(neglahir)) as neglahir,
									trim(max(kotalahir)) as kotalahir,max(tgllahir) as tgllahir,trim(max(kd_agama)) as kd_agama,trim(max(stswn)) as stswn, trim(max(status_pernikahan))  as status_pernikahan,trim(max(negtinggal)) as negtinggal,
									trim(max(provtinggal)) as provtinggal,trim(max(kotatinggal)) as kotatinggal,trim(max(kectinggal)) as kectinggal, trim(max(keltinggal)) as keltinggal, trim(max(alamattinggal)) as alamattinggal, cast(max(nohp1)as numeric) as nohp1,cast(max(nohp1)as numeric) as nohp2,
									trim(max(email)) as email, max(inputdate) as inputdate, max(inputby) as inputby, max(updatedate) as updatedate, max(updateby) as updateby, max(image) as image, max(status) as status, max(kdposisi) as kdposisi,
									max(imageupload) as imageupload, max(fileupload) as fileupload,max(tgllowongan) as tgllowongan,max(tgllamaran)as tgllamaran from sc_rec.calonkaryawan
									group by noktp");
	}
	
	function q_ajaxktp($noktp){
		return $this->db->query("select * from sc_mst.karyawan where noktp='$noktp'");
	}
	
	
}	