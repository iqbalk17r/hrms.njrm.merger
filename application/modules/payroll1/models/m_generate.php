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
	
	function detail_karyawan($nik){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nik'");
	}
	function list_karyawan($kdgroup_pg,$kddept){
	
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.grouppenggajian='$kdgroup_pg' and a.bag_dept='$kddept'
								order by nmlengkap asc
								");
	
	}
	
	function list_karyawan_new($kdgroup_pg,$kddept,$keluarkerja){
		return $this->db->query("select a.statuskepegawaian,a.tglkeluarkerja,a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.grouppenggajian='$kdgroup_pg' and a.bag_dept='$kddept' and ((a.statuskepegawaian<>'KO') OR ((a.statuskepegawaian='KO') and (to_char(a.tglkeluarkerja,'YYYYMM')='$keluarkerja')))								
								order by nmlengkap asc");
	
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
								and gajitetap is null and statuskepegawaian<>'KO'");
	
	}
	function q_cek_tmppayroll($tglawalfix,$tglakhirfix,$kddept){
		return $this->db->query("select * from sc_tmp.payroll_rekap where periode_mulai='$tglawalfix' and  periode_akhir='$tglakhirfix' and kddept='$kddept'");
	}
	function q_cek_trxpayroll($tglawalfix,$tglakhirfix,$kddept){
		return $this->db->query("select * from sc_trx.payroll_rekap where periode_mulai='$tglawalfix' and  periode_akhir='$tglakhirfix' and kddept='$kddept'");
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
	
	function q_cek_close($periodeclose,$kddept){
		return $this->db->query("select * from sc_trx.payroll_rekap
								where to_char(periode_akhir,'YYYYMM')='$periodeclose' and kddept='$kddept'");
	
	}
	
	function list_karyawan_resign($periode){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
					left outer join sc_mst.departmen b on a.bag_dept=b.kddept
					where a.grouppenggajian='P1' and a.statuskepegawaian='KO' and to_char(a.tglkeluarkerja,'yyyymm')='$periode' 
					and a.nik not in (select nik from sc_trx.payroll_resign)								
					order by nmdept,nmlengkap asc
								");
	
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select cast(lama_bekerja as char(24)) as masa_bekerja,* from (select case when a.tglkeluarkerja is null then age(a.tglmasukkerja)
								else age(a.tglkeluarkerja,a.tglmasukkerja)
								end as lama_bekerja,a.statuskepegawaian,a.tglkeluarkerja,a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.nik='$nik') as t1					
								");
	
	}
	
	function q_finalresign(){
		return $this->db->query("select case when b.tglkeluarkerja is null then age(b.tglmasukkerja)
								else age(b.tglkeluarkerja,b.tglmasukkerja)
								end as lama_bekerja,
								b.nmlengkap,a.*,c.nmdept from sc_trx.payroll_resign a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
								order by nmdept,tgl_dok desc");
	
	}
	
	function q_detailfinalresign($nik){
		return $this->db->query("select case when b.tglkeluarkerja is null then age(b.tglmasukkerja)
								else age(b.tglkeluarkerja,b.tglmasukkerja)
								end as lama_bekerja,
								b.nmlengkap,a.*,c.nmdept ,to_char(a.tgl_pembayaran,'dd-mm-yyyy') as tgl_bayar from sc_trx.payroll_resign a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
								where a.nik='$nik'");
	
	}
	
	function q_detailfinalresign_pdf($nik){
		return $this->db->query("select case when b.tglkeluarkerja is null then age(b.tglmasukkerja)
								else age(b.tglkeluarkerja,b.tglmasukkerja)
								end as lama_bekerja,
								b.nmlengkap,a.nik,a.nodok,to_char(round(a.gajitetap,0),'999G999G999G990D') as gajitetap,
								to_char(round(a.tj_pesangon,0),'999G999G999G990D') as tj_pesangon,
								to_char(round(a.tj_masakerja,0),'999G999G999G990D') as tj_masakerja,
								to_char(round(a.tj_lain,0),'999G999G999G990D') as tj_lain,
								to_char(round(a.tj_cuti,0),'999G999G999G990D') as tj_cuti,
								to_char(round(a.tj_penggantianhak,0),'999G999G999G990D') as tj_penggantianhak,
								to_char(round(a.tj_absen,0),'999G999G999G990D') as tj_absen,
								to_char(round(a.total_upah,0),'999G999G999G990D') as total_upah,
								to_char(round(a.potongan,0),'999G999G999G990D') as potongan,
								to_char(round(a.ttl_pph_resign,0),'999G999G999G990D') as ttl_pph_resign,
								to_char(round(a.ttl_pph21,0),'999G999G999G990D') as ttl_pph21,
								to_char(round(a.tj_lembur,0),'999G999G999G990D') as ttl_lembur,
								to_char(round(a.tj_shift,0),'999G999G999G990D') as ttl_shift,
								to_char(round(a.tj_borong,0),'999G999G999G990D') as ttl_borong,
								to_char(round(a.tj_absen,0),'999G999G999G990D') as ttl_absen,
								c.nmdept,to_char(a.tgl_dok,'DD-MM-YYYY') as tgl_dok,to_char(a.tgl_pembayaran,'DD-MM-YYYY') as tgl_bayar,a.status from sc_trx.payroll_resign a 
								left outer join sc_mst.karyawan b on a.nik=b.nik 
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
								where a.nik='$nik'");
	
	}
	
		
	/* PPH21 FORM 1721 */
	function q_1721rekaptmp($nodoktemp,$kddept,$tahun,$kdgroup_pg){
		return $this->db->query("select * from sc_tmp.p1721_rekap where nodok='$nodoktemp' $kddept and to_char(tgl_dok,'yyyy')='$tahun' and grouppenggajian='$kdgroup_pg'");
		
	}
	function q_1721rekaptmpcek($nodoktemp,$kddept,$tahun,$kdgroup_pg){
		return $this->db->query("select * from sc_tmp.p1721_rekap where nodok='$nodoktemp' and kddept='$kddept' and to_char(tgl_dok,'yyyy')='$tahun' and grouppenggajian='$kdgroup_pg'");
		
	}
	function q_1721detailnik($nik){
		return $this->db->query("select * from sc_tmp.p1721_detail where nik='$nik' and no_urut<>99 order by no_urut");
	}
	
	function q_1721detail($kddept,$tahun,$kdgroup_pg){
		return $this->db->query("select t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,sum(t1.gajipokok)as gaji_pokok,sum(tj_pph) as tj_pph,sum(tj_lain) as tj_lain,sum(honorarium) as honorarium,sum(premiasuransi) as premiasuransi,sum(natuna) as natuna,sum(p_nonreg) as p_nonreg,sum(subtotal_bruto) as subtotal_bruto,sum(biaya_jabatan) as biaya_jabatan,
		sum(pensiun) as pensiun,sum(subtotal_potongan) as subtotal_potongan,sum(sub_netto) as sub_netto,sum(netto_sebelumnya) as netto_sebelumnya,sum(netto_untukpph21) as netto_untukpph21,sum(ptkp_setahun) as ptkp_setahun,sum(pkp_setahun) as pkp_setahun,sum(pph21_setahun) as pph21_setahun,sum(pph21_masa_sebelumnya) as pph21_masa_sebelumnya,
		sum(pph21_terutang) as pph21_terutang,sum(pph2126_dipotong) as pph21_dipotong,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan from 
		(select nik,nominal as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=1
		union all
		select nik,0 as gajipokok,nominal as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=2
		union all
		select nik,0 as gajipokok,0 as tj_pph,nominal as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=3
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,nominal as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=4
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,nominal as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=5
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,nominal as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=6
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,nominal as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=7
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,nominal as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=8
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,nominal as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=9
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,nominal as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=10
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,nominal as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=11
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,nominal as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=12
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,nominal as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=13
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,nominal as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=14
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,nominal as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=15
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,nominal as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=16
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,nominal as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=17
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,nominal as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=18
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,nominal as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=19
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,nominal as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=20
		) as t1 
		left outer join sc_mst.karyawan b on t1.nik=b.nik
		left outer join (select * from sc_tmp.p1721_detail where no_urut=99) c on t1.nik=c.nik
		where b.bag_dept='$kddept' and b.grouppenggajian='$kdgroup_pg'
		group by t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan
		order by b.nmlengkap asc");
		
	}
	
	function q_1721nik($nik,$kddept,$kdgroup_pg){
		return $this->db->query("select t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,round(sum(t1.gajipokok))as gaji_pokok,round(sum(tj_pph)) as tj_pph,round(sum(tj_lain)) as tj_lain,round(sum(honorarium)) as honorarium,round(sum(premiasuransi)) as premiasuransi,round(sum(natuna)) as natuna,round(sum(p_nonreg)) as p_nonreg,round(sum(subtotal_bruto)) as subtotal_bruto,round(sum(biaya_jabatan)) as biaya_jabatan,
		round(sum(pensiun)) as pensiun,round(sum(subtotal_potongan)) as subtotal_potongan,round(sum(sub_netto)) as sub_netto,round(sum(netto_sebelumnya)) as netto_sebelumnya,round(sum(netto_untukpph21)) as netto_untukpph21,round(sum(ptkp_setahun)) as ptkp_setahun,round(sum(pkp_setahun)) as pkp_setahun,round(sum(pph21_setahun)) as pph21_setahun,round(sum(pph21_masa_sebelumnya)) as pph21_masa_sebelumnya,
		round(sum(pph21_terutang)) as pph21_terutang,round(sum(pph2126_dipotong)) as pph21_dipotong,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan,substring(c.nomor_pelaporan,5,2) as bl,substring(c.nomor_pelaporan,8,2) as th,right(c.nomor_pelaporan,6) as urut from 
		(select nik,nominal as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=1
		union all
		select nik,0 as gajipokok,nominal as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=2
		union all
		select nik,0 as gajipokok,0 as tj_pph,nominal as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=3
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,nominal as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=4
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,nominal as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=5
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,nominal as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=6
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,nominal as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=7
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,nominal as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=8
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,nominal as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=9
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,nominal as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=10
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,nominal as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=11
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,nominal as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=12
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,nominal as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=13
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,nominal as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=14
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,nominal as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=15
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,nominal as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=16
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,nominal as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=17
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,nominal as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=18
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,nominal as pph21_terutang,0 as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=19
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,nominal as pph2126_dipotong  from sc_tmp.p1721_detail where no_urut=20
		) as t1 
		left outer join sc_mst.karyawan b on t1.nik=b.nik
		left outer join (select * from sc_tmp.p1721_detail where no_urut=99) c on t1.nik=c.nik
		where t1.nik='$nik' and b.grouppenggajian='$kdgroup_pg'
		group by t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan
		order by b.nmlengkap asc");
		
	}
	
	function q_dtl_kary($nik,$kddept,$kdgroup_pg){
		return $this->db->query("select a.*,b.nmjabatan from sc_mst.karyawan a 
		left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan where nik='$nik' and grouppenggajian='$kdgroup_pg'");
	}
	
	function q_detail_pph21setahun($nik){
	
		return $this->db->query("
								select nik,no_urut,keterangan,sum(total_01) as januari, sum(total_02) as februari, sum(total_03) as maret, sum(total_04) as april,sum(total_05) as mei,
								sum(total_06) as juni,sum(total_07) as juli,sum(total_08) as agustus,sum(total_09) as september,sum(total_10) as oktober,sum(total_11) as november,sum(total_12)as desember
								from (
									select nik,no_urut,keterangan,nominal as total_01,0 as total_02,0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=1 
									union all
									select nik,no_urut,keterangan, 0 as total_01,nominal as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=2 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, nominal as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=3
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,nominal as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=4 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,nominal as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=5 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,nominal as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=6 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,nominal as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=7 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,nominal as total_08,0 as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=8 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,nominal as total_09,0 as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=9 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,nominal as total_10,0 as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=10 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,nominal as total_11,0 as total_12 from sc_trx.p21_detail where periode_mulai=11 
									union all
									select nik,no_urut,keterangan, 0 as total_01, 0 as total_02, 0 as total_03,0 as total_04,0 as total_05,0 as total_06,0 as total_07,0 as total_08,0 as total_09,0 as total_10,0 as total_11,nominal as total_12 from sc_trx.p21_detail where periode_mulai=12 
								) as t1
								where t1.nik='$nik'
								group by nik,keterangan,no_urut	
								order by nik,no_urut

								");
	}
	
	
	function list_lembur_resign($nik){
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
								from sc_trx.cek_lembur_resign a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nik='$nik'
								order by a.nodok_ref desc");
	
	
	}
	
	function list_shift_resign($nik){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_trx.cek_shift_resign a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								 where a.nik='$nik'
								");
	}
	
	function list_absen_resign($nik){
		return $this->db->query("select b.nmlengkap,
								case
								when a.cuti_nominal=null then 'BERMASALAH'
								when a.cuti_nominal=0 then 'POTONG CUTI'
								else 'POTONG GAJI'
								end as ketsts,
								a.* from sc_trx.cek_absen_resign a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nik='$nik'
								order by tgl_kerja asc");
	
	
	}
	
	function list_borong_resign($nik){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_upah,0),'999G999G999G990D00') as total_upah1 
								from sc_trx.cek_borong_resign a
								left outer join sc_mst.karyawan b on a.nik=b.nik	
								where a.nik='$nik'
								order by a.nodok_ref desc");
	
		}
	
	function q_sum_lembur($nik){
		return $this->db->query("select coalesce(sum(nominal),0) as nominal from sc_trx.cek_lembur_resign where nik='$nik'");
	}
	function q_sum_shift($nik){
		return $this->db->query("select coalesce(sum(nominal),0) as nominal from sc_trx.cek_shift_resign where nik='$nik'");
	}
	function q_sum_borong($nik){
		return $this->db->query("select coalesce(sum(total_upah),0) as nominal from sc_trx.cek_borong_resign where nik='$nik'");
	}
	function cektrx($nodok){
		return $this->db->query("select * from sc_mst.trxerror where userid='$nodok' and modul='PAYROLL_GEN' and errorcode='0'");
	}
	
	function q_setup_option_dept(){
		return $this->db->query("select * from sc_mst.option where kdoption='PAYROL01'");
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}	