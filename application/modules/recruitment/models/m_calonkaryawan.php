<?php
class M_calonkaryawan extends CI_Model{
	function q_calonkaryawan(){
		return $this->db->query("select *,to_char(age(tgllahir),'YY') as usia from sc_rec.calonkaryawan order by nmlengkap asc");
	}
	
	function q_pelamarfilter($tgllow1,$tgllow2,$ktpnya,$statusnya){
		return $this->db->query("select a.*,to_char(age(a.tgllahir),'YY')as usia,b.uraian as statusnya 
									from sc_rec.calonkaryawan a left outer join
									sc_mst.trxtype b on a.status=b.kdtrx 
									where to_char(tgllowongan,'yyyy-mm-dd') between '$tgllow1' and '$tgllow2' $ktpnya $statusnya order by nmlengkap asc");
	}
	function q_cekcalonkaryawan($noktp){
		return $this->db->query("select * from sc_rec.calonkaryawan where trim(noktp)='$noktp'");
	}
		
	function q_calon_detail($noktp,$tgllowongan,$tgllamaran){
		return $this->db->query("select *,to_char(tgllahir,'dd-mm-yyyy') as tgllahir1,to_char(tgllowongan,'dd-mm-yyyy') as tgllowongan1,to_char(tgllamaran,'dd-mm-yyyy') as tgllamaran1 from sc_rec.calonkaryawan where trim(noktp)='$noktp' and tgllamaran='$tgllamaran' and tgllowongan='$tgllowongan'");
	}
	
	function q_riwayat_pendidikan($noktp,$tgllowongan,$tgllamaran){
		return $this->db->query("select * from sc_rec.riwayat_pendidikan where trim(noktp)='$noktp' and tgllamaran='$tgllamaran' and tgllowongan='$tgllowongan'");
	}
	function q_riwayat_pengalaman($noktp,$tgllowongan,$tgllamaran){
		return $this->db->query("select * from sc_rec.riwayat_pengalaman where  trim(noktp)='$noktp' and tgllamaran='$tgllamaran' and tgllowongan='$tgllowongan'");
	}
	
	function q_lampiran_dp($noktp,$tgllowongan,$tgllamaran){
		return $this->db->query("select max(file_name) as file_name,max(tgllowongan) as tgllowongan,max(tgllamaran) as tgllamaran from sc_rec.lampiran where  trim(noktp)='$noktp' and ref_type='DP' and tgllamaran='$tgllamaran' and tgllowongan='$tgllowongan'");
	}
	function q_lampiran_dp_min($noktp,$tgllowongan,$tgllamaran){
		return $this->db->query("select min(file_name) as file_name,min(tgllowongan) as tgllowongan,min(tgllamaran) as tgllamaran from sc_rec.lampiran where  trim(noktp)='$noktp' and ref_type='DP' and tgllamaran='$tgllamaran' and tgllowongan='$tgllowongan'");
	}
	
	function q_lampiran_at($noktp,$tgllowongan,$tgllamaran){
		return $this->db->query("select * from sc_rec.lampiran where  trim(noktp)='$noktp' and ref_type='AT' and tgllamaran='$tgllamaran' and tgllowongan='$tgllowongan'");
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
	
	function update_image($noktp,$updatedate,$updateby,$data = array()){
		$this->db->where('noktp', $noktp);
		$this->db->where('update_date', $updatedate);
		$this->db->where('update_by', $updateby);
        $update = $this->db->update('sc_rec.lampiran',$data);
        return $update?true:false;
    }
	function update_attachment($noktp,$updatedate,$updateby,$data = array()){
		$this->db->where('noktp', $noktp);
		$this->db->where('update_date', $updatedate);
		$this->db->where('update_by', $updateby);
        $update = $this->db->update_batch('sc_rec.lampiran',$data);
        return $update?true:false;
    }
	
	function q_linkinputkaryawan($noktp){
		return $this->db->query("	select max(noktp) as noktp,max(nmlengkap) as nmlengkap,max(jk)as jk,trim(max(neglahir)) as neglahir,
									trim(max(kotalahir)) as kotalahir,max(tgllahir) as tgllahir,trim(max(kd_agama)) as kd_agama,trim(max(stswn)) as stswn, trim(max(status_pernikahan))  as status_pernikahan,trim(max(negtinggal)) as negtinggal,
									trim(max(provtinggal)) as provtinggal,trim(max(kotatinggal)) as kotatinggal,trim(max(kectinggal)) as kectinggal, trim(max(keltinggal)) as keltinggal, trim(max(alamattinggal)) as alamattinggal, cast(max(nohp1)as character(20)) as nohp1,cast(max(nohp1)as character(20)) as nohp2,
									trim(max(email)) as email, max(inputdate) as inputdate, max(inputby) as inputby, max(updatedate) as updatedate, max(updateby) as updateby, max(image) as image, max(status) as status, max(kdposisi) as kdposisi,
									max(imageupload) as imageupload, max(fileupload) as fileupload,max(tgllowongan) as tgllowongan,max(tgllamaran)as tgllamaran from sc_rec.calonkaryawan
									where noktp='$noktp'
									group by noktp");
	}
	
	function q_maxktpcalon(){
		return $this->db->query("	select max(trim(noktp)) as noktp,max(trim(nmlengkap)) as nmlengkap,max(jk)as jk,trim(max(neglahir)) as neglahir,
									trim(max(kotalahir)) as kotalahir,max(tgllahir) as tgllahir,trim(max(kd_agama)) as kd_agama,trim(max(stswn)) as stswn, trim(max(status_pernikahan))  as status_pernikahan,trim(max(negtinggal)) as negtinggal,
									trim(max(provtinggal)) as provtinggal,trim(max(kotatinggal)) as kotatinggal,trim(max(kectinggal)) as kectinggal, trim(max(keltinggal)) as keltinggal, trim(max(alamattinggal)) as alamattinggal, cast(max(nohp1)as character(20)) as nohp1,cast(max(nohp1)as character(20)) as nohp2,
									trim(max(email)) as email, max(inputdate) as inputdate, max(inputby) as inputby, max(updatedate) as updatedate, max(updateby) as updateby, max(image) as image, max(status) as status, max(kdposisi) as kdposisi,
									max(imageupload) as imageupload, max(fileupload) as fileupload,max(tgllowongan) as tgllowongan,max(tgllamaran)as tgllamaran from sc_rec.calonkaryawan
									where status='AG'
									group by noktp");
	}
	
	function q_ajaxktp($noktp){
		return $this->db->query("select * from sc_mst.karyawan where noktp='$noktp'");
	}
	
	function q_list_pelamar_lebih(){
		return $this->db->query("select max(noktp) as noktp,max(nmlengkap) as nmlengkap,max(jk)as jk,trim(max(neglahir)) as neglahir,
									trim(max(kotalahir)) as kotalahir,max(tgllahir) as tgllahir,trim(max(kd_agama)) as kd_agama,trim(max(stswn)) as stswn, trim(max(status_pernikahan))  as status_pernikahan,trim(max(negtinggal)) as negtinggal,
									trim(max(provtinggal)) as provtinggal,trim(max(kotatinggal)) as kotatinggal,trim(max(kectinggal)) as kectinggal, trim(max(keltinggal)) as keltinggal, trim(max(alamattinggal)) as alamattinggal, cast(max(nohp1)as numeric) as nohp1,cast(max(nohp1)as numeric) as nohp2,
									trim(max(email)) as email, max(inputdate) as inputdate, max(inputby) as inputby, max(updatedate) as updatedate, max(updateby) as updateby, max(image) as image, max(status) as status, max(kdposisi) as kdposisi,
									max(imageupload) as imageupload, max(fileupload) as fileupload,max(tgllowongan) as tgllowongan,max(tgllamaran)as tgllamaran from sc_rec.calonkaryawan
									where noktp in (select noktp from sc_rec.calonkaryawan group by noktp having count (noktp)>1)
									group by noktp");
	}
	
	function q_jenis_seleksi(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='CKARY' order by kdtrx asc");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_mst.jabatan 
									order by nmjabatan ");	
	
	}
	
	
}	