<?php
class M_ceklembur extends CI_Model{
	
	
	
	
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
	
	function list_karyawan(){
	
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								order by nmlengkap asc
								");
	
	}
	
	function q_karyawan($nik){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nik'");
	}

	
	
	function q_transready_shift_old($tglawal,$tglakhir,$nik){
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' and (shiftke='3' or shiftke='2') 
								and a.nik='$nik') as t1
								where ketsts<>'TIDAK MASUK KERJA'		
								order by tgl asc   
								");
	
	
	}
	
	function q_transready_shift($tglawal,$tglakhir,$kddept){
	
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawal' and '$tglakhir' and (shiftke='3' or shiftke='2') 
								and  b.bag_dept='$kddept' and b.tjshift='t' and b.statuskepegawaian<>'KO') as t1
								where ketsts<>'TIDAK MASUK KERJA'		
								order by tgl asc");
	
	}
	
	function q_shiftall($tglawal,$tglakhir,$kddept){
		return $this->db->query("select a.nik,b.nmlengkap,to_char(round(sum(a.nominal),0),'999G999G999G990D00') as  nominal1 from sc_tmp.cek_shift a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where b.bag_dept='$kddept' and to_char(a.tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								group by a.nik,b.nmlengkap
								order by b.nmlengkap");
	
	}
	
	function q_transready_absen($tglawal,$tglakhir,$kdgroup_pg,$kddept){
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and b.bag_dept='$kddept' and b.statuskepegawaian<>'KO'
								) as t1
								where ketsts='TIDAK MASUK KERJA'
								order by tgl asc   
								");
	
	
	}
	
	
	function q_transready_absen_gt($tglawal,$tglakhir,$kdgroup_pg,$kddept){
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
								where to_char(a.tgl,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and  b.bag_dept='$kddept' and b.gajitetap is null
								) as t1
								where ketsts='TIDAK MASUK KERJA'
								order by tgl asc   
								");
	
	
	}
	
	
	function q_shift($nodok,$nik){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_tmp.cek_shift a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								 where nodok='$nodok' and a.nik='$nik'
								");
	
	
	}
	
	function total_nominal_shift($nodok,$nik){
		return $this->db->query("select to_char(round(sum(nominal),0),'999G999G999G990D00') as total_nominal  from sc_tmp.cek_shift where nodok='$nodok' and nik='$nik'");
	
	}
	
	function q_lembur_trans_old($tglawal,$tglakhir){
		
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
	
	function q_lembur_checkinout_old($tglawal,$tglakhir,$kdgroup_pg,$kddept){
		return $this->db->query("select *,cast(to_char(tgl_jam_absen,'HH24:mi:ss') as time) as jam_absen  from (
									select a.nik,a.nodok,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
									a.durasi,a.tgl_kerja,,min(b.checktime) as min_jam_absen,max(b.checktime)as tgl_jam_absen,
									k.jam_masuk_absen,k.jam_pulang_absen from sc_trx.lembur a 
									left outer join sc_tmp.checkinout b on a.nik=b.badgenumber and to_char(a.tgl_kerja,'YYYY-MM-DD')=to_char(b.checktime,'YYYY-MM-DD')
									left outer join sc_mst.karyawan c on a.nik=c.nik
									left outer join sc_trx.dtljadwalkerja j on a.nik=j.nik and a.tgl_kerja=j.tgl
									left outer join sc_trx.transready k on j.nik=k.nik and tgl_kerja=k.tgl
									where a.status='P' and to_char(a.tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
									and c.grouppenggajian='$kdgroup_pg' and c.bag_dept='$kddept'
									group by a.nik,a.nodok,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
									k.jam_masuk_absen,k.jam_pulang_absen,
									a.durasi,a.tgl_kerja) as t1
								");
	
	
	
	}
	
	function q_lembur_trans($nik,$tgl_kerja){
		return $this->db->query("select * from sc_trx.transready 
								where nik='$nik' and to_char(tgl,'YYYY-MM-DD')='$tgl_kerja'");
	
	}
	
	function q_lembur($tglawal,$tglakhir,$kdgroup_pg,$kddept){
		return $this->db->query("select a.nik,a.nodok,a.tgl_kerja,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
								a.durasi,a.jenis_lembur
								from sc_trx.lembur a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.status='P' and to_char(a.tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and  b.bag_dept='$kddept'
								order by a.nodok desc");
	
	}
	
	function q_lembur_checkinout($nik,$tgl_kerja){
		return $this->db->query("select b.nik,min(a.checktime)as jam_masuk_absen,max(a.checktime) as jam_pulang_absen from sc_tmp.checkinout a
								left outer join sc_mst.karyawan b on a.badgenumber=b.nik
								where to_char(checktime,'YYYY-MM-DD')='$tgl_kerja' and b.nik='$nik'
								group by badgenumber,nik");
	
	
	}
	
	function q_lembur_gt($tglawal,$tglakhir,$kdgroup_pg,$kddept){
		return $this->db->query("select *,cast(to_char(tgl_jam_absen,'HH24:mi:ss') as time) as jam_absen  from (
								select a.nik,a.nodok,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
								a.durasi,a.tgl_kerja,max(b.checktime)as tgl_jam_absen from sc_trx.lembur a 
								left outer join sc_tmp.checkinout b on a.nik=b.badgenumber and to_char(a.tgl_kerja,'YYYY-MM-DD')=to_char(b.checktime,'YYYY-MM-DD')
								left outer join sc_mst.karyawan c on a.nik=c.nik
								where a.status='P' and to_char(a.tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and c.bag_dept='$kddept' and gajitetap is  null
								group by a.nik,a.nodok,a.tgl_dok,a.kdlembur,a.tgl_jam_mulai,a.tgl_jam_selesai,
								a.durasi,a.tgl_kerja) as t1
								");
	
	
	
	}
	
	function q_cek_absen($nodok,$tglawal,$tglakhir,$kddept){
		return $this->db->query("select b.nmlengkap,
								case
								when a.cuti_nominal=null then 'BERMASALAH'
								when a.cuti_nominal=0 then 'POTONG CUTI'
								else 'POTONG GAJI'
								end as ketsts,
								a.* from sc_tmp.cek_absen a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where nodok='$nodok' and to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and b.bag_dept='$kddept'
								order by tgl_kerja asc");
	
	
	}
	
	
	
	function q_upah_borong($tglawal,$tglakhir,$kdgroup_pg,$kddept) {
	
		return $this->db->query("select a.* from sc_trx.upah_borong_mst a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where (to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir') and a.status='P'
								and b.bag_dept='$kddept'
								");
	}
	
	
	function list_lembur_nominal($tglawal,$tglakhir,$nodok,$kddept){
		return $this->db->query("select to_char(a.tgl_nodok_ref,'dd-mm-yyyy')as tgl_dok1,
								to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
								a.status,to_char(a.jam_mulai_absen,'HH24:mi:ss') as jam_mulai_absen1,
								to_char(a.jam_selesai_absen,'HH24:mi:ss') as jam_selesai_absen1,	
								to_char(a.jam_selesai,'HH24:mi:ss') as jam_selesai1,	
								to_char(a.jam_mulai,'HH24:mi:ss') as jam_mulai1,	
								case
								when a.nominal is null then 'BERMASALAH'
								when a.jam_mulai_absen is null and a.jam_selesai_absen is null and trim(a.jenis_lembur)='D1' then 'ABSEN BERMASALAH'
								else 'TIDAK BERMASALAH'
								end as ketsts,
								a.*,b.nmlengkap,
								cast(cast(floor(jumlah_jam/60.) as integer)as character(12))|| ' Jam '||
								cast(cast((jumlah_jam-(floor(jumlah_jam/60.)*60)) as integer)as character(12))||' Menit' as jam,
								cast(cast(floor(jumlah_jam_absen/60.) as integer)as character(12))|| ' Jam '||
								cast(cast((jumlah_jam_absen-(floor(jumlah_jam_absen/60.)*60)) as integer)as character(12))||' Menit' as jam2,
								to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1
								from sc_tmp.cek_lembur a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where nodok='$nodok' and to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and b.bag_dept='$kddept'
								order by a.nodok_ref desc");
	
	
	}
	
	function q_cek_borong($nodok,$tglawal,$tglakhir,$kddept){
	
		return $this->db->query("select a.nik,b.nmlengkap,a.nodok,sum(a.total_upah)as total_upah,to_char(round(sum(a.total_upah),0),'999G999G999G990D00') as total_upah1 
									from sc_tmp.cek_borong a
									left outer join sc_mst.karyawan b on a.nik=b.nik
									where nodok='$nodok' and to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
									and b.bag_dept='$kddept' 
									group by b.nmlengkap,a.nodok,a.nik,a.periode
									order by b.nmlengkap asc");
								
	}	
	function q_cek_borong_detail($nodok,$tglawal,$tglakhir,$nik){
	
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_upah,0),'999G999G999G990D00') as total_upah1 
								from sc_tmp.cek_borong a
								left outer join sc_mst.karyawan b on a.nik=b.nik	
								where nodok='$nodok' and to_char(tgl_kerja,'YYYY-MM-DD') between '$tglawal' and '$tglakhir'
								and a.nik='$nik'
								order by a.nodok_ref desc");
								
	}
	function q_setup_formula(){
	
		return $this->db->query("select * from sc_mst.detail_formula where kdrumus='PR' order by no_urut asc");
	
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
	
	function q_jamkerja(){
	
		return $this->db->query("select * from sc_mst.jam_kerja order by kdjam_kerja asc");
	}
	
	function cek_absen($nik,$tgl_kerja){
		return $this->db->query("select * from sc_trx.transready where nik='$nik' and tgl='$tgl_kerja'");
	
	}
	
	function q_absenbelum($tglbelum,$kdgroup_pg,$kddept){
	
		return $this->db->query("select a.* from sc_tmp.cek_absen a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where to_char(tgl_kerja,'YYYY-MM-DD')='$tglbelum' 
								and b.bag_dept='$kddept'");
	}
	
	function q_borongbelum($tglbelum,$kdgroup_pg,$kddept){
		return $this->db->query("select a.* from sc_tmp.cek_borong a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where to_char(tgl_kerja,'YYYY-MM-DD')='$tglbelum' 
								and b.bag_dept='$kddept'");
	}
	
	function total_upah_dtl($nodok){
		return $this->db->query("select sum(upah_borong) as total_upah from sc_trx.upah_borong_dtl
								where nodok='$nodok'");
	}
	
	function q_upah_borong_detail($nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmborong,d.nmsub_borong,d.metrix,d.satuan,d.tarif_satuan,e.total_target
								from sc_trx.upah_borong_dtl a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.borong c on a.kdborong=c.kdborong
								left outer join sc_mst.sub_borong d on a.kdsub_borong=d.kdsub_borong 
								left outer join sc_mst.target_borong e on a.kdsub_borong=e.kdsub_borong 
								where a.nodok='$nodok' 
								order by a.no_urut desc");
			
	}
	
	function q_history_gaji($nik,$periodegaji){
		return $this->db->query("select * from sc_his.history_gaji where nik='$nik' and periode='$periodegaji'");
	}

}	