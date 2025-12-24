<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwalnew extends CI_Model {


	function q_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan order by nmlengkap asc");
	
	}
	
	function q_regu(){
		return $this->db->query("select * from sc_mst.regu where kdregu in (select kdregu from sc_mst.regu_opr)order by nmregu asc");
	}
	
	function q_regu_injadwal(){
		return $this->db->query("select * from sc_mst.regu where kdregu in (select kdregu from sc_trx.jadwalkerja) and kdregu in (select kdregu from sc_mst.regu_opr)order by nmregu asc");
	}
	
	function q_department(){
		return $this->db->query("select * from sc_mst.departmen order by nmdept asc");
	}
	
	function q_regu_detail(){
		return $this->db->query("select distinct kdregu,tgl from sc_trx.jadwalkerja");
	}
	
	function q_jamkerja(){
		return $this->db->query("select * from sc_mst.jam_kerja");
	}
	function q_offjadwalkerja($thn,$bln,$kdregu){
		return $this->db->query("select * from sc_trx.jadwalkerja where to_char(tgl,'yyyy')='$thn' and to_char(tgl,'mm')='$bln' and kdregu='$kdregu'");
	}
	function q_offjk_row($tgl,$kdregu){
		return $this->db->query("select * from sc_trx.jadwalkerja where to_char(tgl,'yyyy-mm-dd')='$tgl'and kdregu='$kdregu'");
	}
	
	function q_jadwalkerja($bulan,$tahun,$read){
		return $this->db->query("select a.*,b.nmlengkap,b.bag_dept from sc_trx.listjadwalkerja a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									where bulan='$bulan' and tahun='$tahun' $read
									order by b.nmlengkap,a.kdregu asc
								");
	}
	function q_vsebulanjadwal($nik,$bulan){
		return $this->db->query("select a.*,'OFF' as kdjamkerja,b.nmlengkap from sc_trx.listjadwalkerja a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									where a.nik='$nik' and a.bulan='$bulan'
									order by b.nmlengkap asc");
	}
	function q_dtljadwalkerja($tgl_kerja){
		return $this->db->query("select  id,kdregu,kodejamkerja,to_char(tgl,'DD-MM-YYYY') as tgl,b.jam_masuk,b.jam_pulang from sc_trx.jadwalkerja a 
								left outer join sc_mst.jam_kerja b on a.kodejamkerja=b.kdjam_kerja
								where tgl='$tgl_kerja'");
	}
	
	function q_tmpjadwal(){
		return $this->db->query("select * from sc_tmp.jadwalkerja  order by tgl");
	}
	
	function q_tmpjadwalid($userid){
		return $this->db->query("select * from sc_tmp.jadwalkerja where inputby='$userid'  order by tgl");
	}
	

	
	function q_dtljadwalkerja_regu($tgl_kerja,$kdregu){
		return $this->db->query("select to_char(tgl,'DD-MM-YYYY') as tglnya,to_char(tgl,'DDMMYYYY') as tglkode,b.nmlengkap,c.jam_masuk,c.jam_pulang,a.* from sc_trx.dtljadwalkerja a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.jam_kerja c on a.kdjamkerja=c.kdjam_kerja 

								where a.kdregu='$kdregu' and a.tgl='$tgl_kerja'");
	}
	
	function q_jadwalkerja_ns($tgl_kerja){
		return $this->db->query("select b.nmlengkap,a.* from sc_trx.jadwalkerja_ns a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.tgl='$tgl_kerja'");
	}
	
	function q_dtljadwalkerja_ns($tgl_kerja,$nik){
		return $this->db->query("select b.nmlengkap,a.* from sc_trx.jadwalkerja_ns a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nik='$nik' and a.tgl='$tgl_kerja'");
	}
	
	function q_mesin(){
		return $this->db->query("select * from sc_mst.mesin");
	}
	
	function cek_exist($kdregu,$tgl){
		return $this->db->query("select * from sc_trx.jadwalkerja a
								where kdregu='$kdregu' and tgl='$tgl'")->num_rows();
	}
	
	
	function cek_exist_detail($nik,$kdjamkerja,$tgl){
		return $this->db->query("select * from sc_trx.dtljadwalkerja a
								where nik='$nik' and kdjamkerja='$kdjamkerja' and tgl='$tgl'")->num_rows();
	}
		
	function cek_exist_detail2($nik,$kdregu,$tgl){
		return $this->db->query("select * from sc_trx.dtljadwalkerja a
								where nik='$nik' and kdregu='$kdregu' and tgl='$tgl'")->num_rows();
	}
	
	function cek_exist_ns($nik,$kdjamkerja,$tgl){
		return $this->db->query("select * from sc_trx.jadwalkerja_ns a
								where nik='$nik' and kodejamkerja='$kdjamkerja' and tgl='$tgl'")->num_rows();
	}
	
	function cek_shift($tgl_kerja,$shift){
		return $this->db->query("select * from sc_trx.jadwalkerja 
								where tgl='$tgl_kerja' and shift_tipe='$shift'")->num_rows();
	}
	
	function q_showcheckinout($tgl){
		return $this->db->query("select cast(to_char(checktime,'hh24:mi:ss')as time) as jam,c.kdjamkerja,* from 
								(select cast(to_char(a.checktime,'DD-MM-YYYY')as date) as tglchecktime,b.nik,a.* from sc_tmp.checkinout a
								left outer join sc_mst.karyawan b on a.badgenumber=b.nik
								where to_char(a.checktime,'DD-MM-YYYY')='$tgl' and b.nik in (select nik from sc_trx.dtljadwalkerja)) as t1 
								left outer join sc_trx.dtljadwalkerja c on c.nik=t1.nik and c.tgl=t1.tglchecktime
								left outer join sc_mst.jam_kerja d on d.kdjam_kerja=c.kdjamkerja");
										
	}
	
	
	function q_transready_old(){
		return $this->db->query("select cast((cast(tgl as date)- integer '1')||' '||to_char(jam_masuk_min,'hh24:mi:ss') as timestamp)as tgljadwal,
								cast(to_char(checktime,'hh24:mi:ss')as time) as jam,cast(to_char(checktime,'DD-MM-YYYY')as date) as tglcheck,* from sc_trx.transready 
								where to_char(checktime,'DD-MM-YYYY')='02-12-2015'	
								order by shiftke");
	
	}
	
	function q_loopingjadwal($tglawal,$tglakhir){
	
		return $this->db->query("select 
								a.nik,tgl,kdjamkerja,jam_masuk,jam_masuk_min,jam_pulang,jam_pulang_min,jam_pulang_max,kdharimasuk,kdharipulang,shiftke,
								case 
								when shiftke='3' and kdharimasuk='H-' then cast(to_char((cast(a.tgl as date)- integer '1'),'YYYY-MM-DD')||' '||to_char(b.jam_masuk_min,'HH24:MM:SS') as timestamp)	
								else cast(to_char((cast(a.tgl as date)),'YYYY-MM-DD')||' '||to_char(b.jam_masuk_min,'HH24:MM:SS') as timestamp) 
								end as tgl_min_masuk,
								case 
								when shiftke='2' and kdharipulang='H+' then cast(to_char((cast(a.tgl as date)+ integer '1'),'YYYY-MM-DD')||' '||to_char(b.jam_pulang_max,'HH24:MM:SS') as timestamp) 
								else cast(to_char((cast(a.tgl as date)),'YYYY-MM-DD')||' '||to_char(b.jam_pulang_max,'HH24:MM:SS') as timestamp)
								end as tgl_max_pulang
								from sc_trx.dtljadwalkerja a,sc_mst.jam_kerja b,sc_tmp.checkinout c, sc_mst.karyawan d
								where a.kdjamkerja=b.kdjam_kerja  and a.nik=d.nik and c.badgenumber=d.nik
								and to_char(tgl,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' 
								group by a.nik,tgl,kdjamkerja,jam_masuk,jam_masuk_min,jam_pulang,jam_pulang_min,jam_pulang_max,kdharimasuk,kdharipulang,shiftke
								order by shiftke,tgl,nik
								");
	}
	
	
	//to_char(a.tgl,'YYYY-MM-DD')=to_char(c.checktime,'YYYY-MM-DD') and c.checktime is not null
	
	function q_caricheckinout($nik,$tgl1,$tgl2){
	
		return $this->db->query("select b.nik,min(checktime) as tgl_min,max(checktime) as tgl_max from sc_tmp.checkinout a,sc_mst.karyawan b
								where a.badgenumber=b.nik and  to_char(a.checktime,'YYYY-MM-DD hh24:mi:ss')>= '$tgl1' 
								and to_char(a.checktime,'YYYY-MM-DD hh24:mi:ss')<='$tgl2' and b.nik='$nik'
								
								group by b.nik");
	}
	
	function q_transready_koreksi($nik,$tgl1,$tgl2){
		return $this->db->query("select b.nmlengkap, 
												case 
												when shiftke='1' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
												when shiftke='3' and jam_masuk_absen>=jam_masuk_min  then 'TIDAK TERLAMBAT'
												when shiftke='1' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='2' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='3' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='2' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
												when jam_masuk_absen is null and jam_pulang_absen is null then 'TIDAK MASUK KERJA'
												when shiftke='2' and jam_masuk=jam_pulang then 'TIDAK ABSEN MASUK/KELUAR'
												else 'TIDAK ABSEN MASUK/KELUAR'
												end as ketsts,
												a.* from sc_trx.transready a
												left outer join sc_mst.karyawan b on a.nik=b.nik
												where a.nik='$nik' and a.tgl between '$tgl1' and '$tgl2'
												order by tgl asc					
								");
	
	
	}
	
	function q_transready_koreksidept($kddept,$tgl1,$tgl2){
		return $this->db->query("select b.nmlengkap, 
												case 
												when shiftke='1' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
												when shiftke='3' and jam_masuk_absen>=jam_masuk_min  then 'TIDAK TERLAMBAT'
												when shiftke='1' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='2' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='3' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='2' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
												when jam_masuk_absen is null and jam_pulang_absen is null then 'TIDAK MASUK KERJA'
												when shiftke='2' and jam_masuk=jam_pulang then 'TIDAK ABSEN MASUK/KELUAR'
												else 'TIDAK ABSEN MASUK/KELUAR'
												end as ketsts,
												a.* from sc_trx.transready a
												left outer join sc_mst.karyawan b on a.nik=b.nik
												where b.bag_dept='$kddept' and a.tgl between '$tgl1' and '$tgl2'
												order by tgl asc					
								");
	
	
	}
	
	function q_transready($nik,$tgl1,$tgl2,$ketsts){
		return $this->db->query("select * from (select b.nmlengkap, 
												case 
												when shiftke='1' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
												when shiftke='3' and jam_masuk_absen>=jam_masuk_min  then 'TIDAK TERLAMBAT'
												when shiftke='1' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='2' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='3' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
												when shiftke='2' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk  then 'TIDAK TERLAMBAT'
												when jam_masuk_absen is null and jam_pulang_absen is null then 'TIDAK MASUK KERJA'
												when shiftke='2' and jam_masuk=jam_pulang then 'TIDAK ABSEN MASUK/KELUAR'
												else 'TIDAK ABSEN MASUK/KELUAR'
												end as ketsts,
												a.* from sc_trx.transready a
												left outer join sc_mst.karyawan b on a.nik=b.nik
												where a.nik='$nik' and a.tgl between '$tgl1' and '$tgl2'
												order by tgl asc) as t1
									where ketsts $ketsts						
								");
	
	
	}
	
	function q_transready_regu($kdregu,$tgl1,$tgl2,$ketsts){
		return $this->db->query("select * from (
								select b.nmlengkap,
								case when shiftke='1' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk then 'TIDAK TERLAMBAT' 
								when shiftke='3' and jam_masuk_absen>=jam_masuk_min then 'TIDAK TERLAMBAT' 
								when shiftke='1' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='2' and jam_masuk_absen>jam_masuk then 'TERLAMBAT' 
								when shiftke='3' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='2' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk then 'TIDAK TERLAMBAT' 
								when jam_masuk_absen is null and jam_pulang_absen is null then 'TIDAK MASUK KERJA'
								when shiftke='2' and jam_masuk=jam_pulang then 'TIDAK ABSEN MASUK/KELUAR' 
								else 'TIDAK ABSEN MASUK/KELUAR' end as ketsts, a.* from sc_trx.transready a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.regu_opr c on b.nik=c.nik 
								where c.kdregu='$kdregu' and a.tgl between '$tgl1' and '$tgl2' order by tgl asc) as t1
								where ketsts $ketsts					
								");
	
	
	}
	
	function q_transready_dept($kddept,$tgl1,$tgl2,$ketsts){
		return $this->db->query("select * from (
								select b.nmlengkap,
								case when shiftke='1' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk then 'TIDAK TERLAMBAT' 
								when shiftke='3' and jam_masuk_absen>=jam_masuk_min then 'TIDAK TERLAMBAT' 
								when shiftke='1' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='2' and jam_masuk_absen>jam_masuk then 'TERLAMBAT' 
								when shiftke='3' and jam_masuk_absen>jam_masuk then 'TERLAMBAT'
								when shiftke='2' and jam_masuk_absen>jam_masuk_min and jam_masuk_absen<=jam_masuk then 'TIDAK TERLAMBAT' 
								when jam_masuk_absen is null and jam_pulang_absen is null then 'TIDAK MASUK KERJA'
								when shiftke='2' and jam_masuk=jam_pulang then 'TIDAK ABSEN MASUK/KELUAR' 
								else 'TIDAK ABSEN MASUK/KELUAR' end as ketsts, a.* from sc_trx.transready a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
								where c.kddept='$kddept' and a.tgl between '$tgl1' and '$tgl2' order by tgl asc) as t1
								where ketsts $ketsts					
								");
	
	
	}
	
	function cek_absenexist($nik,$tgl,$kdjamkerja){
	
		return $this->db->query("select * from sc_trx.transready where nik='$nik' and tgl='$tgl' and kdjamkerja='$kdjamkerja'");
	}
	
	function tglakhir_ci(){
		return $this->db->query("select to_char(checktime,'YYYY-MM-DD')as tglakhir from sc_tmp.checkinout
		order by checktime desc
		limit 1");
		}

	function tglakhir_tr(){
		return $this->db->query("select to_char(tgl,'YYYY-MM-DD') as tglakhir from sc_trx.transready
		order by tgl desc
		limit 1");

	}
	
	function q_dtljadwalkerja_nik($nik,$tgl){
		return $this->db->query("select  nik,id,kdregu,kdjamkerja,to_char(tgl,'DD-MM-YYYY') as tgl,b.jam_masuk,b.jam_pulang from sc_trx.dtljadwalkerja a 
								left outer join sc_mst.jam_kerja b on a.kdjamkerja=b.kdjam_kerja
								where tgl='$tgl' and nik='$nik'");
	
	}
	
	function q_reguadajadwal($kdregubaru,$periode){
	
		return $this->db->query("select kdregu,kodejamkerja,inputdate,inputby,tgl,'I' as status from sc_trx.jadwalkerja
								where kdregu='$kdregubaru' and to_char(tgl,'YYYY-MM')='$periode'");
	}
	
	function q_excel_jadwalregu($thn,$bln){
		return $this->db->query("select * from sc_trx.jadwalkerja where to_char(tgl,'yyyy')='$thn' and to_char(tgl,'mm')='$bln' order by kdregu,tgl");
	}
	
	function q_excel_jadwalregusamping($thn,$bln){
		return $this->db->query("select kdregu,bulan,tahun,case when tgl1='NSA' or tgl1='NSB' or tgl1='NSC' or tgl1='SF' or tgl1='S7' or tgl1='SS' or tgl1='NS9' or tgl1='S9S' or tgl1='SF9' then 'NS' when tgl1='SF1' or tgl1='SK1A' or tgl1='SK1B' or tgl1='SK1C' then '1' when tgl1='SK2A' or tgl1='SK2B' or tgl1='SF2' then '2' when tgl1='SF3' then '3' 
									else 'OFF' end as tgl1,
									case when tgl2='NSA' or tgl2='NSB' or tgl2='NSC' or tgl2='SF' or tgl2='S7' or tgl2='SS' or tgl2='NS9' or tgl2='S9S' or tgl2='SF9' then 'NS' when tgl2='SF1' or tgl2='SK1A' or tgl2='SK1B' or tgl2='SK1C' then '1' when tgl2='SK2A' or tgl2='SK2B' or tgl2='SF2' then '2' when tgl2='SF3' then '3' 
									else 'OFF' end as tgl2,
									case when tgl3='NSA' or tgl3='NSB' or tgl3='NSC' or tgl3='SF' or tgl3='S7' or tgl3='SS' or tgl3='NS9' or tgl3='S9S' or tgl3='SF9' then 'NS' when tgl3='SF1' or tgl3='SK1A' or tgl3='SK1B' or tgl3='SK1C' then '1' when tgl3='SK2A' or tgl3='SK2B' or tgl3='SF2' then '2' when tgl3='SF3' then '3' 
									else 'OFF' end as tgl3,
									case when tgl4='NSA' or tgl4='NSB' or tgl4='NSC' or tgl4='SF' or tgl4='S7' or tgl4='SS' or tgl4='NS9' or tgl4='S9S' or tgl4='SF9' then 'NS' when tgl4='SF1' or tgl4='SK1A' or tgl4='SK1B' or tgl4='SK1C' then '1' when tgl4='SK2A' or tgl4='SK2B' or tgl4='SF2' then '2' when tgl4='SF3' then '3' 
									else 'OFF' end as tgl4,
									case when tgl5='NSA' or tgl5='NSB' or tgl5='NSC' or tgl5='SF' or tgl5='S7' or tgl5='SS' or tgl5='NS9' or tgl5='S9S' or tgl5='SF9' then 'NS' when tgl5='SF1' or tgl5='SK1A' or tgl5='SK1B' or tgl5='SK1C' then '1' when tgl5='SK2A' or tgl5='SK2B' or tgl5='SF2' then '2' when tgl5='SF3' then '3' 
									else 'OFF' end as tgl5,
									case when tgl6='NSA' or tgl6='NSB' or tgl6='NSC' or tgl6='SF' or tgl6='S7' or tgl6='SS' or tgl6='NS9' or tgl6='S9S' or tgl6='SF9' then 'NS' when tgl6='SF1' or tgl6='SK1A' or tgl6='SK1B' or tgl6='SK1C' then '1' when tgl6='SK2A' or tgl6='SK2B' or tgl6='SF2' then '2' when tgl6='SF3' then '3' 
									else 'OFF' end as tgl6,
									case when tgl7='NSA' or tgl7='NSB' or tgl7='NSC' or tgl7='SF' or tgl7='S7' or tgl7='SS' or tgl7='NS9' or tgl7='S9S' or tgl7='SF9' then 'NS' when tgl7='SF1' or tgl7='SK1A' or tgl7='SK1B' or tgl7='SK1C' then '1' when tgl7='SK2A' or tgl7='SK2B' or tgl7='SF2' then '2' when tgl7='SF3' then '3' 
									else 'OFF' end as tgl7,
									case when tgl8='NSA' or tgl8='NSB' or tgl8='NSC' or tgl8='SF' or tgl8='S7' or tgl8='SS' or tgl8='NS9' or tgl8='S9S' or tgl8='SF9' then 'NS' when tgl8='SF1' or tgl8='SK1A' or tgl8='SK1B' or tgl8='SK1C' then '1' when tgl8='SK2A' or tgl8='SK2B' or tgl8='SF2' then '2' when tgl8='SF3' then '3' 
									else 'OFF' end as tgl8,
									case when tgl9='NSA' or tgl9='NSB' or tgl9='NSC' or tgl9='SF' or tgl9='S7' or tgl9='SS' or tgl9='NS9' or tgl9='S9S' or tgl9='SF9' then 'NS' when tgl9='SF1' or tgl9='SK1A' or tgl9='SK1B' or tgl9='SK1C' then '1' when tgl9='SK2A' or tgl9='SK2B' or tgl9='SF2' then '2' when tgl9='SF3' then '3' 
									else 'OFF' end as tgl9,
									case when tgl10='NSA' or tgl10='NSB' or tgl10='NSC' or tgl10='SF' or tgl10='S7' or tgl10='SS' or tgl10='NS9' or tgl10='S9S' or tgl10='SF9' then 'NS' when tgl10='SF1' or tgl10='SK1A' or tgl10='SK1B' or tgl10='SK1C' then '1' when tgl10='SK2A' or tgl10='SK2B' or tgl10='SF2' then '2' when tgl10='SF3' then '3' 
									else 'OFF' end as tgl10,
									case when tgl11='NSA' or tgl11='NSB' or tgl11='NSC' or tgl11='SF' or tgl11='S7' or tgl11='SS' or tgl11='NS9' or tgl11='S9S' or tgl11='SF9' then 'NS' when tgl11='SF1' or tgl11='SK1A' or tgl11='SK1B' or tgl11='SK1C' then '1' when tgl11='SK2A' or tgl11='SK2B' or tgl11='SF2' then '2' when tgl11='SF3' then '3' 
									else 'OFF' end as tgl11,
									case when tgl12='NSA' or tgl12='NSB' or tgl12='NSC' or tgl12='SF' or tgl12='S7' or tgl12='SS' or tgl12='NS9' or tgl12='S9S' or tgl12='SF9' then 'NS' when tgl12='SF1' or tgl12='SK1A' or tgl12='SK1B' or tgl12='SK1C' then '1' when tgl12='SK2A' or tgl12='SK2B' or tgl12='SF2' then '2' when tgl12='SF3' then '3' 
									else 'OFF' end as tgl12,
									case when tgl13='NSA' or tgl13='NSB' or tgl13='NSC' or tgl13='SF' or tgl13='S7' or tgl13='SS' or tgl13='NS9' or tgl13='S9S' or tgl13='SF9' then 'NS' when tgl13='SF1' or tgl13='SK1A' or tgl13='SK1B' or tgl13='SK1C' then '1' when tgl13='SK2A' or tgl13='SK2B' or tgl13='SF2' then '2' when tgl13='SF3' then '3' 
									else 'OFF' end as tgl13,
									case when tgl14='NSA' or tgl14='NSB' or tgl14='NSC' or tgl14='SF' or tgl14='S7' or tgl14='SS' or tgl14='NS9' or tgl14='S9S' or tgl14='SF9' then 'NS' when tgl14='SF1' or tgl14='SK1A' or tgl14='SK1B' or tgl14='SK1C' then '1' when tgl14='SK2A' or tgl14='SK2B' or tgl14='SF2' then '2' when tgl14='SF3' then '3' 
									else 'OFF' end as tgl14,
									case when tgl15='NSA' or tgl15='NSB' or tgl15='NSC' or tgl15='SF' or tgl15='S7' or tgl15='SS' or tgl15='NS9' or tgl15='S9S' or tgl15='SF9' then 'NS' when tgl15='SF1' or tgl15='SK1A' or tgl15='SK1B' or tgl15='SK1C' then '1' when tgl15='SK2A' or tgl15='SK2B' or tgl15='SF2' then '2' when tgl15='SF3' then '3' 
									else 'OFF' end as tgl15,
									case when tgl16='NSA' or tgl16='NSB' or tgl16='NSC' or tgl16='SF' or tgl16='S7' or tgl16='SS' or tgl16='NS9' or tgl16='S9S' or tgl16='SF9' then 'NS' when tgl16='SF1' or tgl16='SK1A' or tgl16='SK1B' or tgl16='SK1C' then '1' when tgl16='SK2A' or tgl16='SK2B' or tgl16='SF2' then '2' when tgl16='SF3' then '3' 
									else 'OFF' end as tgl16,
									case when tgl17='NSA' or tgl17='NSB' or tgl17='NSC' or tgl17='SF' or tgl17='S7' or tgl17='SS' or tgl17='NS9' or tgl17='S9S' or tgl17='SF9' then 'NS' when tgl17='SF1' or tgl17='SK1A' or tgl17='SK1B' or tgl17='SK1C' then '1' when tgl17='SK2A' or tgl17='SK2B' or tgl17='SF2' then '2' when tgl17='SF3' then '3' 
									else 'OFF' end as tgl17,
									case when tgl18='NSA' or tgl18='NSB' or tgl18='NSC' or tgl18='SF' or tgl18='S7' or tgl18='SS' or tgl18='NS9' or tgl18='S9S' or tgl18='SF9' then 'NS' when tgl18='SF1' or tgl18='SK1A' or tgl18='SK1B' or tgl18='SK1C' then '1' when tgl18='SK2A' or tgl18='SK2B' or tgl18='SF2' then '2' when tgl18='SF3' then '3' 
									else 'OFF' end as tgl18,
									case when tgl19='NSA' or tgl19='NSB' or tgl19='NSC' or tgl19='SF' or tgl19='S7' or tgl19='SS' or tgl19='NS9' or tgl19='S9S' or tgl19='SF9' then 'NS' when tgl19='SF1' or tgl19='SK1A' or tgl19='SK1B' or tgl19='SK1C' then '1' when tgl19='SK2A' or tgl19='SK2B' or tgl19='SF2' then '2' when tgl19='SF3' then '3' 
									else 'OFF' end as tgl19,
									case when tgl20='NSA' or tgl20='NSB' or tgl20='NSC' or tgl20='SF' or tgl20='S7' or tgl20='SS' or tgl20='NS9' or tgl20='S9S' or tgl20='SF9' then 'NS' when tgl20='SF1' or tgl20='SK1A' or tgl20='SK1B' or tgl20='SK1C' then '1' when tgl20='SK2A' or tgl20='SK2B' or tgl20='SF2' then '2' when tgl20='SF3' then '3' 
									else 'OFF' end as tgl20,
									case when tgl21='NSA' or tgl21='NSB' or tgl21='NSC' or tgl21='SF' or tgl21='S7' or tgl21='SS' or tgl21='NS9' or tgl21='S9S' or tgl21='SF9' then 'NS' when tgl21='SF1' or tgl21='SK1A' or tgl21='SK1B' or tgl21='SK1C' then '1' when tgl21='SK2A' or tgl21='SK2B' or tgl21='SF2' then '2' when tgl21='SF3' then '3' 
									else 'OFF' end as tgl21,
									case when tgl22='NSA' or tgl22='NSB' or tgl22='NSC' or tgl22='SF' or tgl22='S7' or tgl22='SS' or tgl22='NS9' or tgl22='S9S' or tgl22='SF9' then 'NS' when tgl22='SF1' or tgl22='SK1A' or tgl22='SK1B' or tgl22='SK1C' then '1' when tgl22='SK2A' or tgl22='SK2B' or tgl22='SF2' then '2' when tgl22='SF3' then '3' 
									else 'OFF' end as tgl22,
									case when tgl23='NSA' or tgl23='NSB' or tgl23='NSC' or tgl23='SF' or tgl23='S7' or tgl23='SS' or tgl23='NS9' or tgl23='S9S' or tgl23='SF9' then 'NS' when tgl23='SF1' or tgl23='SK1A' or tgl23='SK1B' or tgl23='SK1C' then '1' when tgl23='SK2A' or tgl23='SK2B' or tgl23='SF2' then '2' when tgl23='SF3' then '3' 
									else 'OFF' end as tgl23,
									case when tgl24='NSA' or tgl24='NSB' or tgl24='NSC' or tgl24='SF' or tgl24='S7' or tgl24='SS' or tgl24='NS9' or tgl24='S9S' or tgl24='SF9' then 'NS' when tgl24='SF1' or tgl24='SK1A' or tgl24='SK1B' or tgl24='SK1C' then '1' when tgl24='SK2A' or tgl24='SK2B' or tgl24='SF2' then '2' when tgl24='SF3' then '3' 
									else 'OFF' end as tgl24,
									case when tgl25='NSA' or tgl25='NSB' or tgl25='NSC' or tgl25='SF' or tgl25='S7' or tgl25='SS' or tgl25='NS9' or tgl25='S9S' or tgl25='SF9' then 'NS' when tgl25='SF1' or tgl25='SK1A' or tgl25='SK1B' or tgl25='SK1C' then '1' when tgl25='SK2A' or tgl25='SK2B' or tgl25='SF2' then '2' when tgl25='SF3' then '3' 
									else 'OFF' end as tgl25,
									case when tgl26='NSA' or tgl26='NSB' or tgl26='NSC' or tgl26='SF' or tgl26='S7' or tgl26='SS' or tgl26='NS9' or tgl26='S9S' or tgl26='SF9' then 'NS' when tgl26='SF1' or tgl26='SK1A' or tgl26='SK1B' or tgl26='SK1C' then '1' when tgl26='SK2A' or tgl26='SK2B' or tgl26='SF2' then '2' when tgl26='SF3' then '3' 
									else 'OFF' end as tgl26,
									case when tgl27='NSA' or tgl27='NSB' or tgl27='NSC' or tgl27='SF' or tgl27='S7' or tgl27='SS' or tgl27='NS9' or tgl27='S9S' or tgl27='SF9' then 'NS' when tgl27='SF1' or tgl27='SK1A' or tgl27='SK1B' or tgl27='SK1C' then '1' when tgl27='SK2A' or tgl27='SK2B' or tgl27='SF2' then '2' when tgl27='SF3' then '3' 
									else 'OFF' end as tgl27,
									case when tgl28='NSA' or tgl28='NSB' or tgl28='NSC' or tgl28='SF' or tgl28='S7' or tgl28='SS' or tgl28='NS9' or tgl28='S9S' or tgl28='SF9' then 'NS' when tgl28='SF1' or tgl28='SK1A' or tgl28='SK1B' or tgl28='SK1C' then '1' when tgl28='SK2A' or tgl28='SK2B' or tgl28='SF2' then '2' when tgl28='SF3' then '3' 
									else 'OFF' end as tgl28,
									case when tgl29='NSA' or tgl29='NSB' or tgl29='NSC' or tgl29='SF' or tgl29='S7' or tgl29='SS' or tgl29='NS9' or tgl29='S9S' or tgl29='SF9' then 'NS' when tgl29='SF1' or tgl29='SK1A' or tgl29='SK1B' or tgl29='SK1C' then '1' when tgl29='SK2A' or tgl29='SK2B' or tgl29='SF2' then '2' when tgl29='SF3' then '3' 
									else 'OFF' end as tgl29,
									case when tgl30='NSA' or tgl30='NSB' or tgl30='NSC' or tgl30='SF' or tgl30='S7' or tgl30='SS' or tgl30='NS9' or tgl30='S9S' or tgl30='SF9' then 'NS' when tgl30='SF1' or tgl30='SK1A' or tgl30='SK1B' or tgl30='SK1C' then '1' when tgl30='SK2A' or tgl30='SK2B' or tgl30='SF2' then '2' when tgl30='SF3' then '3' 
									else 'OFF' end as tgl30,
									case when tgl31='NSA' or tgl31='NSB' or tgl31='NSC' or tgl31='SF' or tgl31='S7' or tgl31='SS' or tgl31='NS9' or tgl31='S9S' or tgl31='SF9' then 'NS' when tgl31='SF1' or tgl31='SK1A' or tgl31='SK1B' or tgl31='SK1C' then '1' when tgl31='SK2A' or tgl31='SK2B' or tgl31='SF2' then '2' when tgl31='SF3' then '3' 
									else 'OFF' end as tgl31  from sc_trx.exceljadwalregu where tahun='$thn' and bulan='$bln' order by kdregu");
	}
	
	function q_excel_dtljadwalregu($thn,$bln){
		return $this->db->query("select a.*,b.nmlengkap from sc_trx.listjadwalkerja a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									where bulan='$bln' and tahun='$thn'
									order by b.nmlengkap,a.kdregu asc");
	
	}
	function q_excel_jadwal_untukprd($thn,$bln){								
		return $this->db->query("	select a.nik,a.kdregu,a.bulan,a.tahun,
									case when tgl1='NSA' or tgl1='NSB' or tgl1='NSC' or tgl1='SF' or tgl1='S7' or tgl1='SS' or tgl1='NS9' or tgl1='S9S' or tgl1='SF9' then 'NS' when tgl1='SF1' or tgl1='SK1A' or tgl1='SK1B' or tgl1='SK1C' then '1' when tgl1='SK2A' or tgl1='SK2B' or tgl1='SF2' then '2' when tgl1='SF3' then '3' 
									else 'OFF' end as tgl1,
									case when tgl2='NSA' or tgl2='NSB' or tgl2='NSC' or tgl2='SF' or tgl2='S7' or tgl2='SS' or tgl2='NS9' or tgl2='S9S' or tgl2='SF9' then 'NS' when tgl2='SF1' or tgl2='SK1A' or tgl2='SK1B' or tgl2='SK1C' then '1' when tgl2='SK2A' or tgl2='SK2B' or tgl2='SF2' then '2' when tgl2='SF3' then '3' 
									else 'OFF' end as tgl2,
									case when tgl3='NSA' or tgl3='NSB' or tgl3='NSC' or tgl3='SF' or tgl3='S7' or tgl3='SS' or tgl3='NS9' or tgl3='S9S' or tgl3='SF9' then 'NS' when tgl3='SF1' or tgl3='SK1A' or tgl3='SK1B' or tgl3='SK1C' then '1' when tgl3='SK2A' or tgl3='SK2B' or tgl3='SF2' then '2' when tgl3='SF3' then '3' 
									else 'OFF' end as tgl3,
									case when tgl4='NSA' or tgl4='NSB' or tgl4='NSC' or tgl4='SF' or tgl4='S7' or tgl4='SS' or tgl4='NS9' or tgl4='S9S' or tgl4='SF9' then 'NS' when tgl4='SF1' or tgl4='SK1A' or tgl4='SK1B' or tgl4='SK1C' then '1' when tgl4='SK2A' or tgl4='SK2B' or tgl4='SF2' then '2' when tgl4='SF3' then '3' 
									else 'OFF' end as tgl4,
									case when tgl5='NSA' or tgl5='NSB' or tgl5='NSC' or tgl5='SF' or tgl5='S7' or tgl5='SS' or tgl5='NS9' or tgl5='S9S' or tgl5='SF9' then 'NS' when tgl5='SF1' or tgl5='SK1A' or tgl5='SK1B' or tgl5='SK1C' then '1' when tgl5='SK2A' or tgl5='SK2B' or tgl5='SF2' then '2' when tgl5='SF3' then '3' 
									else 'OFF' end as tgl5,
									case when tgl6='NSA' or tgl6='NSB' or tgl6='NSC' or tgl6='SF' or tgl6='S7' or tgl6='SS' or tgl6='NS9' or tgl6='S9S' or tgl6='SF9' then 'NS' when tgl6='SF1' or tgl6='SK1A' or tgl6='SK1B' or tgl6='SK1C' then '1' when tgl6='SK2A' or tgl6='SK2B' or tgl6='SF2' then '2' when tgl6='SF3' then '3' 
									else 'OFF' end as tgl6,
									case when tgl7='NSA' or tgl7='NSB' or tgl7='NSC' or tgl7='SF' or tgl7='S7' or tgl7='SS' or tgl7='NS9' or tgl7='S9S' or tgl7='SF9' then 'NS' when tgl7='SF1' or tgl7='SK1A' or tgl7='SK1B' or tgl7='SK1C' then '1' when tgl7='SK2A' or tgl7='SK2B' or tgl7='SF2' then '2' when tgl7='SF3' then '3' 
									else 'OFF' end as tgl7,
									case when tgl8='NSA' or tgl8='NSB' or tgl8='NSC' or tgl8='SF' or tgl8='S7' or tgl8='SS' or tgl8='NS9' or tgl8='S9S' or tgl8='SF9' then 'NS' when tgl8='SF1' or tgl8='SK1A' or tgl8='SK1B' or tgl8='SK1C' then '1' when tgl8='SK2A' or tgl8='SK2B' or tgl8='SF2' then '2' when tgl8='SF3' then '3' 
									else 'OFF' end as tgl8,
									case when tgl9='NSA' or tgl9='NSB' or tgl9='NSC' or tgl9='SF' or tgl9='S7' or tgl9='SS' or tgl9='NS9' or tgl9='S9S' or tgl9='SF9' then 'NS' when tgl9='SF1' or tgl9='SK1A' or tgl9='SK1B' or tgl9='SK1C' then '1' when tgl9='SK2A' or tgl9='SK2B' or tgl9='SF2' then '2' when tgl9='SF3' then '3' 
									else 'OFF' end as tgl9,
									case when tgl10='NSA' or tgl10='NSB' or tgl10='NSC' or tgl10='SF' or tgl10='S7' or tgl10='SS' or tgl10='NS9' or tgl10='S9S' or tgl10='SF9' then 'NS' when tgl10='SF1' or tgl10='SK1A' or tgl10='SK1B' or tgl10='SK1C' then '1' when tgl10='SK2A' or tgl10='SK2B' or tgl10='SF2' then '2' when tgl10='SF3' then '3' 
									else 'OFF' end as tgl10,
									case when tgl11='NSA' or tgl11='NSB' or tgl11='NSC' or tgl11='SF' or tgl11='S7' or tgl11='SS' or tgl11='NS9' or tgl11='S9S' or tgl11='SF9' then 'NS' when tgl11='SF1' or tgl11='SK1A' or tgl11='SK1B' or tgl11='SK1C' then '1' when tgl11='SK2A' or tgl11='SK2B' or tgl11='SF2' then '2' when tgl11='SF3' then '3' 
									else 'OFF' end as tgl11,
									case when tgl12='NSA' or tgl12='NSB' or tgl12='NSC' or tgl12='SF' or tgl12='S7' or tgl12='SS' or tgl12='NS9' or tgl12='S9S' or tgl12='SF9' then 'NS' when tgl12='SF1' or tgl12='SK1A' or tgl12='SK1B' or tgl12='SK1C' then '1' when tgl12='SK2A' or tgl12='SK2B' or tgl12='SF2' then '2' when tgl12='SF3' then '3' 
									else 'OFF' end as tgl12,
									case when tgl13='NSA' or tgl13='NSB' or tgl13='NSC' or tgl13='SF' or tgl13='S7' or tgl13='SS' or tgl13='NS9' or tgl13='S9S' or tgl13='SF9' then 'NS' when tgl13='SF1' or tgl13='SK1A' or tgl13='SK1B' or tgl13='SK1C' then '1' when tgl13='SK2A' or tgl13='SK2B' or tgl13='SF2' then '2' when tgl13='SF3' then '3' 
									else 'OFF' end as tgl13,
									case when tgl14='NSA' or tgl14='NSB' or tgl14='NSC' or tgl14='SF' or tgl14='S7' or tgl14='SS' or tgl14='NS9' or tgl14='S9S' or tgl14='SF9' then 'NS' when tgl14='SF1' or tgl14='SK1A' or tgl14='SK1B' or tgl14='SK1C' then '1' when tgl14='SK2A' or tgl14='SK2B' or tgl14='SF2' then '2' when tgl14='SF3' then '3' 
									else 'OFF' end as tgl14,
									case when tgl15='NSA' or tgl15='NSB' or tgl15='NSC' or tgl15='SF' or tgl15='S7' or tgl15='SS' or tgl15='NS9' or tgl15='S9S' or tgl15='SF9' then 'NS' when tgl15='SF1' or tgl15='SK1A' or tgl15='SK1B' or tgl15='SK1C' then '1' when tgl15='SK2A' or tgl15='SK2B' or tgl15='SF2' then '2' when tgl15='SF3' then '3' 
									else 'OFF' end as tgl15,
									case when tgl16='NSA' or tgl16='NSB' or tgl16='NSC' or tgl16='SF' or tgl16='S7' or tgl16='SS' or tgl16='NS9' or tgl16='S9S' or tgl16='SF9' then 'NS' when tgl16='SF1' or tgl16='SK1A' or tgl16='SK1B' or tgl16='SK1C' then '1' when tgl16='SK2A' or tgl16='SK2B' or tgl16='SF2' then '2' when tgl16='SF3' then '3' 
									else 'OFF' end as tgl16,
									case when tgl17='NSA' or tgl17='NSB' or tgl17='NSC' or tgl17='SF' or tgl17='S7' or tgl17='SS' or tgl17='NS9' or tgl17='S9S' or tgl17='SF9' then 'NS' when tgl17='SF1' or tgl17='SK1A' or tgl17='SK1B' or tgl17='SK1C' then '1' when tgl17='SK2A' or tgl17='SK2B' or tgl17='SF2' then '2' when tgl17='SF3' then '3' 
									else 'OFF' end as tgl17,
									case when tgl18='NSA' or tgl18='NSB' or tgl18='NSC' or tgl18='SF' or tgl18='S7' or tgl18='SS' or tgl18='NS9' or tgl18='S9S' or tgl18='SF9' then 'NS' when tgl18='SF1' or tgl18='SK1A' or tgl18='SK1B' or tgl18='SK1C' then '1' when tgl18='SK2A' or tgl18='SK2B' or tgl18='SF2' then '2' when tgl18='SF3' then '3' 
									else 'OFF' end as tgl18,
									case when tgl19='NSA' or tgl19='NSB' or tgl19='NSC' or tgl19='SF' or tgl19='S7' or tgl19='SS' or tgl19='NS9' or tgl19='S9S' or tgl19='SF9' then 'NS' when tgl19='SF1' or tgl19='SK1A' or tgl19='SK1B' or tgl19='SK1C' then '1' when tgl19='SK2A' or tgl19='SK2B' or tgl19='SF2' then '2' when tgl19='SF3' then '3' 
									else 'OFF' end as tgl19,
									case when tgl20='NSA' or tgl20='NSB' or tgl20='NSC' or tgl20='SF' or tgl20='S7' or tgl20='SS' or tgl20='NS9' or tgl20='S9S' or tgl20='SF9' then 'NS' when tgl20='SF1' or tgl20='SK1A' or tgl20='SK1B' or tgl20='SK1C' then '1' when tgl20='SK2A' or tgl20='SK2B' or tgl20='SF2' then '2' when tgl20='SF3' then '3' 
									else 'OFF' end as tgl20,
									case when tgl21='NSA' or tgl21='NSB' or tgl21='NSC' or tgl21='SF' or tgl21='S7' or tgl21='SS' or tgl21='NS9' or tgl21='S9S' or tgl21='SF9' then 'NS' when tgl21='SF1' or tgl21='SK1A' or tgl21='SK1B' or tgl21='SK1C' then '1' when tgl21='SK2A' or tgl21='SK2B' or tgl21='SF2' then '2' when tgl21='SF3' then '3' 
									else 'OFF' end as tgl21,
									case when tgl22='NSA' or tgl22='NSB' or tgl22='NSC' or tgl22='SF' or tgl22='S7' or tgl22='SS' or tgl22='NS9' or tgl22='S9S' or tgl22='SF9' then 'NS' when tgl22='SF1' or tgl22='SK1A' or tgl22='SK1B' or tgl22='SK1C' then '1' when tgl22='SK2A' or tgl22='SK2B' or tgl22='SF2' then '2' when tgl22='SF3' then '3' 
									else 'OFF' end as tgl22,
									case when tgl23='NSA' or tgl23='NSB' or tgl23='NSC' or tgl23='SF' or tgl23='S7' or tgl23='SS' or tgl23='NS9' or tgl23='S9S' or tgl23='SF9' then 'NS' when tgl23='SF1' or tgl23='SK1A' or tgl23='SK1B' or tgl23='SK1C' then '1' when tgl23='SK2A' or tgl23='SK2B' or tgl23='SF2' then '2' when tgl23='SF3' then '3' 
									else 'OFF' end as tgl23,
									case when tgl24='NSA' or tgl24='NSB' or tgl24='NSC' or tgl24='SF' or tgl24='S7' or tgl24='SS' or tgl24='NS9' or tgl24='S9S' or tgl24='SF9' then 'NS' when tgl24='SF1' or tgl24='SK1A' or tgl24='SK1B' or tgl24='SK1C' then '1' when tgl24='SK2A' or tgl24='SK2B' or tgl24='SF2' then '2' when tgl24='SF3' then '3' 
									else 'OFF' end as tgl24,
									case when tgl25='NSA' or tgl25='NSB' or tgl25='NSC' or tgl25='SF' or tgl25='S7' or tgl25='SS' or tgl25='NS9' or tgl25='S9S' or tgl25='SF9' then 'NS' when tgl25='SF1' or tgl25='SK1A' or tgl25='SK1B' or tgl25='SK1C' then '1' when tgl25='SK2A' or tgl25='SK2B' or tgl25='SF2' then '2' when tgl25='SF3' then '3' 
									else 'OFF' end as tgl25,
									case when tgl26='NSA' or tgl26='NSB' or tgl26='NSC' or tgl26='SF' or tgl26='S7' or tgl26='SS' or tgl26='NS9' or tgl26='S9S' or tgl26='SF9' then 'NS' when tgl26='SF1' or tgl26='SK1A' or tgl26='SK1B' or tgl26='SK1C' then '1' when tgl26='SK2A' or tgl26='SK2B' or tgl26='SF2' then '2' when tgl26='SF3' then '3' 
									else 'OFF' end as tgl26,
									case when tgl27='NSA' or tgl27='NSB' or tgl27='NSC' or tgl27='SF' or tgl27='S7' or tgl27='SS' or tgl27='NS9' or tgl27='S9S' or tgl27='SF9' then 'NS' when tgl27='SF1' or tgl27='SK1A' or tgl27='SK1B' or tgl27='SK1C' then '1' when tgl27='SK2A' or tgl27='SK2B' or tgl27='SF2' then '2' when tgl27='SF3' then '3' 
									else 'OFF' end as tgl27,
									case when tgl28='NSA' or tgl28='NSB' or tgl28='NSC' or tgl28='SF' or tgl28='S7' or tgl28='SS' or tgl28='NS9' or tgl28='S9S' or tgl28='SF9' then 'NS' when tgl28='SF1' or tgl28='SK1A' or tgl28='SK1B' or tgl28='SK1C' then '1' when tgl28='SK2A' or tgl28='SK2B' or tgl28='SF2' then '2' when tgl28='SF3' then '3' 
									else 'OFF' end as tgl28,
									case when tgl29='NSA' or tgl29='NSB' or tgl29='NSC' or tgl29='SF' or tgl29='S7' or tgl29='SS' or tgl29='NS9' or tgl29='S9S' or tgl29='SF9' then 'NS' when tgl29='SF1' or tgl29='SK1A' or tgl29='SK1B' or tgl29='SK1C' then '1' when tgl29='SK2A' or tgl29='SK2B' or tgl29='SF2' then '2' when tgl29='SF3' then '3' 
									else 'OFF' end as tgl29,
									case when tgl30='NSA' or tgl30='NSB' or tgl30='NSC' or tgl30='SF' or tgl30='S7' or tgl30='SS' or tgl30='NS9' or tgl30='S9S' or tgl30='SF9' then 'NS' when tgl30='SF1' or tgl30='SK1A' or tgl30='SK1B' or tgl30='SK1C' then '1' when tgl30='SK2A' or tgl30='SK2B' or tgl30='SF2' then '2' when tgl30='SF3' then '3' 
									else 'OFF' end as tgl30,
									case when tgl31='NSA' or tgl31='NSB' or tgl31='NSC' or tgl31='SF' or tgl31='S7' or tgl31='SS' or tgl31='NS9' or tgl31='S9S' or tgl31='SF9' then 'NS' when tgl31='SF1' or tgl31='SK1A' or tgl31='SK1B' or tgl31='SK1C' then '1' when tgl31='SK2A' or tgl31='SK2B' or tgl31='SF2' then '2' when tgl31='SF3' then '3' 
									else 'OFF' end as tgl31,
									b.nmlengkap from sc_trx.listjadwalkerja a 
										left outer join sc_mst.karyawan b on a.nik=b.nik
										where bulan='$bln' and tahun='$thn'
										order by b.nmlengkap,a.kdregu asc");							
	}
	function q_calendar_jad($kdregu,$bulan_akhir,$tahun_akhir){
		return $this->db->query("select * from (
									select tahun,bulan,kdregu,'minggu ke 1' as week,m01_1 as minggu,m01_2 as senin,m01_3 as selasa,m01_4 as rabu,m01_5 as kamis,m01_6 as jumat,m01_7 as sabtu from sc_tmp.calendar_jadwal 
									union all
									select tahun,bulan,kdregu,'minggu ke 2' as week,m02_8 as minggu,m02_9 as senin,m02_10 as selasa,m02_11 as rabu,m02_12 as kamis,m02_13 as jumat,m02_14 as sabtu from sc_tmp.calendar_jadwal
									union all
									select tahun,bulan,kdregu,'minggu ke 3' as week,m03_15 as minggu,m03_16 as senin,m03_17 as selasa,m03_18 as rabu,m03_19 as kamis,m03_20 as jumat,m03_21 as sabtu from sc_tmp.calendar_jadwal 
									union all
									select tahun,bulan,kdregu,'minggu ke 4' as week,m04_22 as minggu,m04_23 as senin,m04_24 as selasa,m04_25 as rabu,m04_26 as kamis,m04_27 as jumat,m04_28 as sabtu from sc_tmp.calendar_jadwal
									union all
									select tahun,bulan,kdregu,'minggu ke 5' as week,m05_29 as minggu,m05_30 as senin,m05_31 as selasa,m05_32 as rabu,m05_33 as kamis,m05_34 as jumat,m05_35 as sabtu from sc_tmp.calendar_jadwal )as t1
									where kdregu='$kdregu' and tahun='$tahun_akhir' and bulan='$bulan_akhir'");
	}
	
	function q_calendar_jad_rev($kdregu,$bulan_awal,$tahun_awal){
		return $this->db->query("select * from (
									select tahun,bulan,kdregu,'minggu ke 1' as week,m01_1 as minggu,m01_2 as senin,m01_3 as selasa,m01_4 as rabu,m01_5 as kamis,m01_6 as jumat,m01_7 as sabtu from sc_tmp.calendar_jadwal 
									union all
									select tahun,bulan,kdregu,'minggu ke 2' as week,m02_8 as minggu,m02_9 as senin,m02_10 as selasa,m02_11 as rabu,m02_12 as kamis,m02_13 as jumat,m02_14 as sabtu from sc_tmp.calendar_jadwal
									union all
									select tahun,bulan,kdregu,'minggu ke 3' as week,m03_15 as minggu,m03_16 as senin,m03_17 as selasa,m03_18 as rabu,m03_19 as kamis,m03_20 as jumat,m03_21 as sabtu from sc_tmp.calendar_jadwal 
									union all
									select tahun,bulan,kdregu,'minggu ke 4' as week,m04_22 as minggu,m04_23 as senin,m04_24 as selasa,m04_25 as rabu,m04_26 as kamis,m04_27 as jumat,m04_28 as sabtu from sc_tmp.calendar_jadwal
									union all
									select tahun,bulan,kdregu,'minggu ke 5' as week,m05_29 as minggu,m05_30 as senin,m05_31 as selasa,m05_32 as rabu,m05_33 as kamis,m05_34 as jumat,m05_35 as sabtu from sc_tmp.calendar_jadwal )as t1
									where kdregu='$kdregu' and tahun='$tahun_awal' and bulan='$bulan_awal'");
	}
	
	function q_hari_libur($tgl){
		return $this->db->query("select * from sc_mst.libur where tgl_libur='$tgl' order by tgl_libur");
	}
	function cek_master_template($kdregu,$bulan_akhir,$tahun_akhir){
		return $this->db->query("select * from sc_mst.template_jadwal where bulan='$bulan_akhir' and tahun='$tahun_akhir' and kdregu='$kdregu'");
	}
	
	function q_template_jadwal($kdregu,$bulan_akhir,$tahun_akhir){
		return $this->db->query("select * from ( select tahun,bulan,kdregu,kd_opt,eosf_index,eosf_val,eor_val,
									m01_1,m01_2,m01_3,m01_4,m01_5,m01_6,m01_7,m02_8,m02_9,m02_10,m02_11,m02_12,m02_13,m02_14,m03_15,m03_16,m03_17,m03_18,m03_19,m03_20,m03_21,m04_22,m04_23,m04_24,m04_25,m04_26,m04_27,m04_28,m05_29, m05_30,m05_31,m05_32,m05_33,m05_34,m05_35 from sc_tmp.template_jadwal
									union all
									select tahun,bulan,kdregu,'KODE JAM KERJA',	eosf_index,eosf_val,eor_val,
									m01_1_rev,m01_2_rev,m01_3_rev,m01_4_rev,m01_5_rev,m01_6_rev,m01_7_rev,m02_8_rev,m02_9_rev,m02_10_rev,m02_11_rev,m02_12_rev,m02_13_rev,m02_14_rev,m03_15_rev,m03_16_rev,m03_17_rev,m03_18_rev,m03_19_rev,m03_20_rev,m03_21_rev,m04_22_rev,m04_23_rev,m04_24_rev,m04_25_rev,m04_26_rev,m04_27_rev,m04_28_rev,m05_29_rev,m05_30_rev,m05_31_rev,m05_32_rev,m05_33_rev,m05_34_rev,m05_35_rev from sc_tmp.template_jadwal
									) as x  where x.bulan='$bulan_akhir' and x.tahun='$tahun_akhir' and x.kdregu='$kdregu'");
	}
	
	function q_template_tahunan($kdregu,$thn){
		return $this->db->query("select * from ( select tahun,bulan,kdregu,kd_opt,eosf_index,eosf_val,eor_val,
										m01_1,m01_2,m01_3,m01_4,m01_5,m01_6,m01_7,m02_8,m02_9,m02_10,m02_11,m02_12,m02_13,m02_14,m03_15,m03_16,m03_17,m03_18,m03_19,m03_20,m03_21,m04_22,m04_23,m04_24,m04_25,m04_26,m04_27,m04_28,m05_29, m05_30,m05_31,m05_32,m05_33,m05_34,m05_35,eosf_index_end,eosf_val_end,eor_val_end from sc_mst.template_jadwal
										union all
										select tahun,bulan,kdregu,'KODE JAM KERJA',eosf_index,eosf_val,eor_val,	
										m01_1_rev,m01_2_rev,m01_3_rev,m01_4_rev,m01_5_rev,m01_6_rev,m01_7_rev,m02_8_rev,m02_9_rev,m02_10_rev,m02_11_rev,m02_12_rev,m02_13_rev,m02_14_rev,m03_15_rev,m03_16_rev,m03_17_rev,m03_18_rev,m03_19_rev,m03_20_rev,m03_21_rev,m04_22_rev,m04_23_rev,m04_24_rev,m04_25_rev,m04_26_rev,m04_27_rev,m04_28_rev,m05_29_rev,m05_30_rev,m05_31_rev,m05_32_rev,m05_33_rev,m05_34_rev,m05_35_rev,
										eosf_index_end,eosf_val_end,eor_val_end from sc_mst.template_jadwal
										) as x  where x.tahun='$thn' and x.kdregu='$kdregu'
										order by x.bulan");
	}
	
	function cek_jadwal_1moon($kdregu,$bulan_akhir,$tahun_akhir){
		return $this->db->query("select * from sc_trx.jadwalkerja where to_char(tgl,'yyyy')='$tahun_akhir' and to_char(tgl,'mm')='$bulan_akhir' and kdregu='$kdregu'");
	}
	
}
