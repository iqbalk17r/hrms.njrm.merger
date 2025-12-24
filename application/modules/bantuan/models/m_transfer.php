<?php
class M_transfer extends CI_Model{
	function karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where statuskepegawaian<>'KO' order by nmlengkap");
	}
	function cekkaryawan($nik){
		return $this->db->query("select * from sc_mst.karyawan where statuskepegawaian<>'KO' and nik='$nik' order by nmlengkap");
	}
	
	function q_finger(){
		return $this->db->query("select * from sc_mst.fingerprint order by wilayah asc");
	}
	function q_finger_list($kdcabang){
		return $this->db->query("select * from sc_mst.fingerprint where kodecabang='$kdcabang' order by wilayah asc");
	}
	
	function cek_wilayah($kdcabang,$awal,$akhir,$hostaddr,$dbname,$userpg,$passpg){
		return $this->db->query("select * from dblink('hostaddr=$hostaddr dbname=$dbname user=$userpg password=$passpg',
									   'select userid,badgenumber,nama,checktime,inputan,editan,inputby,id from sc_tmp.checkinout')
									as t1(
									  userid numeric,
									  badgenumber character(25),
									  nama character(150),
									  checktime timestamp without time zone,
									  inputan character(5),
									  editan boolean,
									  inputby character(50),
									  id integer
									) where badgenumber in (select idabsen from sc_mst.karyawan where kdcabang='$kdcabang' and tglkeluarkerja is null) and (to_char(checktime,'dd-mm-yyyy') between '$awal' and '$akhir')
								");
	}
	function cek_lokal($kdcabang,$awal,$akhir){
		return $this->db->query("select * from sc_tmp.checkinout where badgenumber in (select idabsen from sc_mst.karyawan where kdcabang='$kdcabang' and tglkeluarkerja is null) and (to_char(checktime,'dd-mm-yyyy') between '$awal' and '$akhir')");
	}
	function del_checkinout($kdcabang,$awal,$akhir){
		return $this->db->query("delete from sc_tmp.checkinout where badgenumber in (select idabsen from sc_mst.karyawan where kdcabang='$kdcabang' and tglkeluarkerja is null) and (to_char(checktime,'dd-mm-yyyy') between '$awal' and '$akhir')");
	}
	function ins_checkinout($kdcabang,$awal,$akhir,$hostaddr,$dbname,$userpg,$passpg){
		return $this->db->query("insert into sc_tmp.checkinout(
		select * from dblink('hostaddr=$hostaddr dbname=$dbname user=$userpg password=$passpg',
									   'select userid,badgenumber,nama,checktime,inputan,editan,inputby,id from sc_tmp.checkinout')
									as t1(
									  userid numeric,
									  badgenumber character(25),
									  nama character(150),
									  checktime timestamp without time zone,
									  inputan character(5),
									  editan boolean,
									  inputby character(50),
									  id integer
									) where badgenumber in (select idabsen from sc_mst.karyawan where kdcabang='$kdcabang' and tglkeluarkerja is null) and (to_char(checktime,'dd-mm-yyyy') between '$awal' and '$akhir'))");
	}
	
	
}	