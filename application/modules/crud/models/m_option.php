<?php
class M_option extends Ci_model{
	
	function q_pj_hrd(){
		return $this->db->query("select a.nip,a.nmlengkap,a.telepon,b.cuti,b.ijin,b.dll,b.lembur,b.kanwil_sby,b.kanwil_dmk,b.kanwil_jkt,b.kanwil_smg 
								from sc_hrd.pegawai a
								left outer join sc_hrd.notif_sms b
								on a.nip=b.nip 
								where a.kddept='HR'");
	}
	
	function q_add_notif($info){
		$this->db->insert("sc_hrd.snotif_sms",$info);
	}
	function q_jam_absen(){
		return $this->db->query("select to_char(value2,'DD-MM-YYYY')as tanggal_input,status as t1, 
									case
									when status='t' then 'AKTIF'
									when status='f' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,
									* from sc_hrd.option
									where group_option='ABSEN'");

	}
	function q_option_master(){
		return $this->db->query("select status as t1, 
									case 
									when status='t' then 'AKTIF'
									when status='f' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,*
									from sc_hrd.option");
	}
	
	function q_option_cuti(){
		return $this->db->query("select to_char(value2,'YYYY-MM-DD')as tanggal_mulai,status as t1, 
									case
									when status='t' then 'AKTIF'
									when status='f' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,
									* from sc_hrd.option
									where group_option='CUTI'");

	}
	
	function q_option_reminder(){
		return $this->db->query("select status as t1, 
									case
									when status='t' then 'AKTIF'
									when status='f' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,
									* from sc_hrd.option
									where group_option='REMINDER'");

	}
	
	function q_tgl_libur($tgl){
		return $this->db->query("select to_char(tgl_libur,'DD-MM-YYYY')as tanggal_libur,* from sc_mst.libur_nasional 
								where to_char(tgl_libur,'YYYY')='$tgl'
								order by tgl_libur desc");
		
	}
	
	function q_hari_kerja(){
		return $this->db->query("select hari from sc_hrd.hari_kerja");
	}
	
	function q_cek_exist($nip){
		return $this->db->query("select * from sc_hrd.notif_sms where nip='$nip'");
	}
	/*
	
	function q_cabang($branch){
		return $this->db->query("select * from sc_hrd.fingerprint where ipaddress='$branch'");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_hrd.jabatan order by deskripsi");
	}
	
	function q_kantin(){
		return $this->db->query("select a.*,b.desc_cabang from sc_hrd.kantin a
								left outer join sc_mst.kantor b on a.kd_cab=b.kodecabang");
	}
	*/
}
