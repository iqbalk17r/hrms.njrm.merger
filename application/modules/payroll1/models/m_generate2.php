<?php
class M_generate extends CI_Model{
	
	
	
	
	function list_karyawan_old($tgl){
		return $this->db->query("select a.*,b.nmdept,coalesce(c.sisa_cuti,0) as sisa_cuti from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join (
								select  a.nik,coalesce(sisacuti,0) as sisa_cuti from sc_trx.cuti_blc a,
								(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
								(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'MMYYYY')='$tgl'
								group by nik) as b
								where a.nik=b.nik and a.tanggal=b.tanggal
								group by a.nik,a.tanggal) b
								where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen) c on a.nik=c.nik
								where a.grade_golongan is not null and a.nik in (select nik from sc_trx.transready)
								order by nmlengkap asc
								");
	}
	
	function list_karyawan($tgl,$kdgroup_pg,$kddept){
	
		return $this->db->query("select a.*,b.nmdept,coalesce(c.sisa_cuti,0) as sisa_cuti from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join (
								select  a.nik,coalesce(sisacuti,0) as sisa_cuti from sc_trx.cuti_blc a,
								(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
								(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'MMYYYY')='$tgl'
								group by nik) as b
								where a.nik=b.nik and a.tanggal=b.tanggal
								group by a.nik,a.tanggal) b
								where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen) c on a.nik=c.nik
								where a.grouppenggajian='$kdgroup_pg' and a.bag_dept='$kddept'
								order by nmlengkap asc
								");
	
	}
	
	function gp($nik){
		return $this->db->query("select gajipokok from sc_mst.karyawan where nik='$nik'")->row_array();
	}
	
	function jkk(){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kodekomponen='JKK'")->row_array();
	}
	
	function jkm(){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kodekomponen='JKM'")->row_array();
	}
	
	function jht(){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kodekomponen='JHT'")->row_array();
	}
	
	function jp(){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kodekomponen='JP'")->row_array();
	}
	
	function bpjskes(){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kodekomponen='BPJSKES'")->row_array();
	}
	
	
	function q_transready_shift($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
		return $this->db->query("select * from 
								(select b.nmlengkap, 
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawalfix' and '$tglakhirfix' and (shiftke='3' or shiftke='2') 
								and b.grouppenggajian='$kdgroup_pg' and b.bag_dept='$kddept') as t1
								where ketsts<>'TIDAK MASUK KERJA'		
								order by tgl asc   
								");
	
	
	}
	
	function q_transready_absen_old($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
		return $this->db->query("select * from 
								(select b.nmlengkap, 
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawalfix' and '$tglakhirfix'
								and b.grouppenggajian='$kdgroup_pg' and b.bag_dept='$kddept') as t1
								where ketsts='TIDAK MASUK KERJA'
								order by tgl asc   
								");
	
	
	}
	
	function q_transready_absen($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
	
		return $this->db->query("select a.* from sc_tmp.cek_absen a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where to_char(a.tgl_kerja,'YYYY-MM-DD') between '$tglawalfix' and '$tglakhirfix'
								and b.grouppenggajian='$kdgroup_pg' and b.bag_dept='$kddept'");
	
	}
	
	function q_lembur_old($tglawalfix,$tglakhirfix){
		
		return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
								to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
								a.status, 
								case
								when a.status='P' then 'DISETUJUI/PRINT'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='D' then 'DIHAPUS'
								end as status1,
								a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.tplembur,h.uraian,i.nmlengkap as nmatasan1,
								j.tgl,j.kdjamkerja,k.jam_masuk_absen,k.jam_pulang_absen
								from sc_trx.lembur a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on a.kddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
								left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
								left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
								left outer join sc_mst.lembur g on a.kdlembur=cast(g.kdlembur as char)
								left outer join sc_mst.trxtype h on a.kdtrx=h.kdtrx
								left outer join sc_mst.karyawan i on a.nmatasan=i.nik
								left outer join sc_trx.dtljadwalkerja j on a.nik=j.nik and a.tgl_kerja=j.tgl
								left outer join sc_trx.transready k on j.nik=k.nik and tgl_kerja=k.tgl
								where to_char(a.tgl_kerja,'YYYY-MM-DD')='$tglawalfix' and '$tglakhirfix' and a.status='P'
								order by a.nodok desc
								");
	}
	
	function q_lembur($tglawalfix,$tglakhirfix){
		return $this->db->query("select *,cast(to_char(tgl_jam_absen,'HH24:mi:ss') as time) as jam_absen  from (
									select a.nik,a.nodok,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
									a.durasi,a.tgl_kerja,max(b.checktime)as tgl_jam_absen from sc_trx.lembur a 
									left outer join sc_tmp.checkinout b on a.nik=b.badgenumber and to_char(a.tgl_kerja,'YYYY-MM-DD')=to_char(b.checktime,'YYYY-MM-DD')
									where a.status='P' and to_char(a.tgl_kerja,'YYYY-MM-DD') between '$tglawalfix' and '$tglakhirfix'
									group by a.nik,a.nodok,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
									a.durasi,a.tgl_kerja) as t1
								");
	
	
	
	}
	
	function q_upah_borong($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept) {
	
		return $this->db->query("select a.* from sc_trx.upah_borong_mst a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where (to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawalfix' and '$tglakhirfix') and a.status='P'
								and b.grouppenggajian='$kdgroup_pg' and b.bag_dept='$kddept'
								");
	}
	
	function q_setup_formula(){
	
		return $this->db->query("select * from sc_mst.detail_formula where kdrumus='PR' order by no_urut asc");
	
	}
	
	function q_setup_formula_21(){
	
		return $this->db->query("select * from sc_mst.detail_formula where kdrumus='P21' order by no_urut asc");
	
	}
	
	function q_nominal_shift2(){
		return $this->db->query("select value3 from sc_mst.option where kdoption='D'");
		
	}
	
	function q_nominal_shift3(){
		return $this->db->query("select value3 from sc_mst.option where kdoption='F'");
		
	}
	
	function q_tglclosingawal(){
		return $this->db->query("select value3 from sc_mst.option
								where kdoption='STPC1' and trim(nmoption)='SETUP CLOSING AWAL'");	
	}
	
	function q_tglclosingakhir(){
		return $this->db->query("select value3 from sc_mst.option
								where kdoption='STPC2' and trim(nmoption)='SETUP CLOSING AKHIR'");	
	}
	
	function q_group_penggajian(){
		return $this->db->query("select * from sc_mst.group_penggajian order by kdgroup_pg asc");
	
	}
	
	function q_departmen(){
		return $this->db->query("select * from sc_mst.departmen order by nmdept asc");
	
	
	}
	
	function q_cek_gt($kddept,$kdgroup_pg){
		return $this->db->query("select * from sc_mst.karyawan where bag_dept='$kddept' and grouppenggajian='$kdgroup_pg'
								and gajitetap is null");
	
	}
	
	function q_cek_tgl_lembur($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
		return $this->db->query("select a.tgl_kerja from sc_trx.lembur a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where b.bag_dept='$kddept' and b.grouppenggajian='$kdgroup_pg' and
								a.tgl_kerja between '$tglawalfix' and '$tglakhirfix' and a.tgl_kerja not in (select tgl_kerja from sc_tmp.cek_lembur) and a.status='P'");
	
	}
	
	function q_cek_tgl_borong($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
		return $this->db->query("select a.tgl_kerja from sc_trx.upah_borong_mst a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where b.bag_dept='$kddept' and b.grouppenggajian='$kdgroup_pg' and
								a.tgl_kerja between '$tglawalfix' and '$tglakhirfix' and a.tgl_kerja not in (select tgl_kerja from sc_tmp.cek_borong) and a.status='P'");
	
	}
	
	function q_cek_tgl_absen($tglawalfix,$tglakhirfix,$kdgroup_pg,$kddept){
		return $this->db->query("select * from 
								(select b.nmlengkap, 
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawalfix' and '$tglakhirfix'
								and b.grouppenggajian='$kdgroup_pg' and b.bag_dept='$kddept' 
								) as t1
								where ketsts='TIDAK MASUK KERJA' and tgl not in (select tgl_kerja from sc_tmp.cek_absen where tgl_kerja between '$tglawalfix' and '$tglakhirfix') 
								order by tgl asc
								");
	
	}
}	