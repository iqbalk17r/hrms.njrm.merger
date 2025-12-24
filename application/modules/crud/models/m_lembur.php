<?php

class M_lembur extends ci_model{
	
	function q_pegawai(){
		return $this->db->query("select * from sc_hrd.pegawai");
	}
	
	function q_lembur($tgl){
		return $this->db->query("select b.nmlengkap,b.badgenumber,b.idabsensi,a.*  
								from sc_hrd.lembur a, sc_hrd.pegawai b
								where a.nip=b.nip and to_char(tanggal,'mmYYYY')='$tgl'
								order by notransaksi");
	}
	
	function q_lembur_dtl($tgl){
		return $this->db->query("select b.nmlengkap,b.badgenumber,b.idabsensi,c.jenis_pekerjaan,c.tanggal,a.*  
								from sc_tmp.hitunglembur a
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.lembur c on c.notransaksi=a.notransaksi
								where to_char(c.tanggal,'mmYYYY')='$tgl'
								order by notransaksi");
	}
	
	function q_lembur_app($tgl){
		return $this->db->query("select a.nip,b.nmlengkap,gajipokok,sum(a.jamlembur) as jamlembur, sum(a.menitlembur) as menitlembur,
									sum(ttl_waktulembur) as lamalembur, sum(gajilembur) as gajilembur, gajipokok+(sum(gajilembur)) as totalgaji from sc_tmp.hitunglembur a
									left outer join sc_hrd.pegawai b on a.nip=b.nip
									left outer join sc_hrd.lembur c on a.notransaksi=c.notransaksi
									where to_char(tanggal,'mmYYYY')='$tgl'
									group by a.nip,b.nmlengkap,a.gajipokok
									");
	}
	
	function q_cek_absen($tgl,$idabsen,$badgenumber){
		return $this->db->query("select checkdate from sc_hrd.transready
								where checkdate='$tgl' and badgenumber='$badgenumber'");
	}
	
	function update_penomoran($userid){
		return $this->db->query("update sc_tmp.lembur set status='I' where notransaksi='$userid'");
	}
	
	function proses_lembur($nip,$periode,$up_proses){
		$this->db->where('nip',$nip);
		//$this->db->where("to_char(periode,'mmYYYY')",$periode);
		$this->db->update('sc_tmp.hitunglembur',$up_proses);
	}
	
	function simpan_lembur($info){
		$this->db->insert("sc_tmp.lembur",$info);
	}
	function get_nodok_lembur($nip){
		return $this->db->query("select notransaksi from sc_hrd.lembur where nip='$nip'");
	}
	function app_lembur($nip,$tgl,$notransaksi,$info_up){
		$this->db->where('nip',$nip);
		$this->db->where('tanggal',$tgl);
		$this->db->where('notransaksi',$notransaksi);
		$this->db->update("sc_hrd.lembur",$info_up);
	}
	
}