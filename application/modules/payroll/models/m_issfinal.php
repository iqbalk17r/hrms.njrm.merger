<?php
class M_issfinal extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								order by nmlengkap asc");
		
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmjabatan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.jabatan c on a.jabatan=c.kdjabatan
								where a.nik='$nik'
								order by nmlengkap asc");
		
	}
	
	function list_master_old($nik){
		return $this->db->query("select * from sc_tmp.payroll_master
								where nik='$nik'
								");
	
	
	}
	
	function list_master($nama){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_upah,0),'999G999G999G990D00') as total_upah1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1,
								b.norek
								from sc_trx.payroll_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nik='$nama' order by nodok desc
								");
	
	
	}
	
	function list_masterexcel($nodok){
		return $this->db->query("select b.nmlengkap,a.*,cast(total_upah as integer) as total_upah1,
								b.norek
								from sc_trx.payroll_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok='$nodok'");
	
	}
	
	
	function list_master_pph($nodok){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1,
								b.norek
								from sc_trx.p21_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok='$nodok'
								");
	
	
	}
	
	
	function total_gaji($nodok,$nik){
		return $this->db->query("select to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1 from sc_trx.payroll_master
								where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function total_pajak($nodok,$nik){
		return $this->db->query("select to_char(round(total_pajak,0),'999G999G999G990D00') as total_pajak1 from sc_trx.p21_master
								where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function list_detail($nodok,$nik){
		return $this->db->query("select b.uraian,a.*,
								case when aksi='B' and nominal>0 then to_char(cast('-'||round(nominal,0)as numeric),'999G999G999G990D00')
								when aksi='B' and nominal<0 then to_char(round(@(nominal),0),'999G999G999G990D00')
								else to_char(round(nominal,0),'999G999G999G990D00')
								end as nominal1
								from sc_trx.payroll_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nodok='$nodok' and a.nik='$nik'
								and (no_urut not in (2,3,16,17,18,19,20))
								order by a.no_urut asc");
	
	}
	
	function list_detail_pph($nodok,$nik){
		return $this->db->query("select b.uraian,a.*,
								to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1
								from sc_trx.p21_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nodok='$nodok' and a.nik='$nik'
								order by a.no_urut asc");
	
	}
	function list_detail_excel_old($nodok,$nik){
		return $this->db->query("select nik,no_urut,keterangan,uraian,cast(tipe as character(20)),to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from (
								select nodok,nik,no_urut,keterangan,nominal,aksi,tipe from sc_trx.payroll_detail
								union all
								select nodok,nik,29 as no_urut,'TOTAL UPAH' as keterangan,total_upah,'A' as aksi,'OTOMATIS' as tipe from sc_trx.payroll_master 
								) as t1
							left outer join sc_mst.trxtype b on t1.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
							where t1.nik='$nik' and t1.nodok='$nodok'
							order by t1.no_urut");
	
	}
	
	function list_detail_excel($nodok,$nik){
		return $this->db->query("select nik,no_urut,keterangan,uraian,cast(tipe as character(20)),case when aksi='B' and nominal>0 then to_char(cast('-'||round(nominal,0)as numeric),'999G999G999G990D00')
								 when aksi='B' and nominal<0 then to_char(round(@(nominal),0),'999G999G999G990D00')
								else to_char(round(nominal,0),'999G999G999G990D00')
								end as nominal1 from (
									select nodok,nik,no_urut,keterangan,nominal,aksi,tipe from sc_trx.payroll_detail
									union all
									select nodok,nik,29 as no_urut,'TOTAL UPAH' as keterangan,total_upah,'A' as aksi,'OTOMATIS' as tipe from sc_trx.payroll_master 
									) as t1
								left outer join sc_mst.trxtype b on t1.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where t1.nik='$nik' and t1.nodok='$nodok'
								order by t1.no_urut");
		
	}
	
	
	
	function list_rekap($nodok){
		return $this->db->query("select *,to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1,
								to_char(round(total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_trx.payroll_rekap
								order by right(nodok,4) desc");
	
	}
	
	
	function list_rekap_pph($nodok){
		return $this->db->query("select *,to_char(round(total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_trx.p21_rekap
								order by right(nodok,1) desc");
	
	}
	/* TUNJANGAN DETAIL */
	function q_absensi($nodok,$nik){
		return $this->db->query("select *,to_char(round(cuti_nominal,0),'999G999G999G990D00') as cuti_nominal1 from sc_trx.potongan_absen where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_shift($nodok,$nik){
		return $this->db->query("select *,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_trx.tunjangan_shift where nodok='$nodok' and nik='$nik'
								");
	
	
	}
	
	function q_upah_borong($nodok,$nik){
		return $this->db->query("select *,to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1 from (
									select a.*,'PR'||trim(b.bag_dept)||to_char(a.tgl_dok,'YYMM') as nodok_help from sc_tmp.cek_borong a left outer join
									sc_mst.karyawan b on a.nik=b.nik) as x
									where x.nik='$nik' and x.nodok_help='$nodok'
								");
	
	
	}
	
	function q_lembur($nodok,$nik){
		return $this->db->query("select *,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_trx.detail_lembur where nodok='$nodok' and nik='$nik'
								");
	
	}
	
	function q_detail_setahun_old($nik){
		return $this->db->query("select * from
								(
								select a.no_urut,a.nik,a.keterangan,a.nominal as januari,b.nominal as februari,c.nominal as maret,d.nominal as april,e.nominal as mei,f.nominal as juni,
								g.nominal as juli,h.nominal as agustus,i.nominal as september,j.nominal as oktober,k.nominal as november,l.nominal as desember from 
								(select nik,keterangan,nominal,no_urut from sc_trx.p21_detail where periode_mulai=1 ) as a
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=2) as b
								on a.nik=b.nik and a.no_urut=b.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=3) as c
								on a.nik=c.nik and a.no_urut=c.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=4) as d
								on a.nik=d.nik and a.no_urut=d.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=5) as e
								on a.nik=e.nik and a.no_urut=e.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=6) as f
								on a.nik=f.nik and a.no_urut=f.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=7) as g
								on a.nik=g.nik and a.no_urut=g.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=8) as h
								on a.nik=h.nik and a.no_urut=h.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=9) as i
								on a.nik=i.nik and a.no_urut=i.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=10) as j
								on a.nik=j.nik and a.no_urut=j.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=11) as k
								on a.nik=k.nik and a.no_urut=k.no_urut
								join (select nik,nominal,no_urut from sc_trx.p21_detail where periode_mulai=12) as l
								on a.nik=l.nik and a.no_urut=l.no_urut
								) as t1
								where t1.nik='$nik'
								order by t1.no_urut
								");
	
	}
	
	function q_detail_setahun($nik){
	
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
	
	function q_slipgaji($nodok,$nik){
		return $this->db->query("select to_char(round(sum(gajipokok),0),'999G999G999G990D') as gajipokok,to_char(round(sum(tj_jabatan),0),'999G999G999G990D') as tj_jabatan,to_char(round(sum(tj_masakerja),0),'999G999G999G990D') as tj_masakerja,to_char(round(sum(tj_prestasi),0),'999G999G999G990D') as tj_prestasi,
																		to_char(round(sum(tj_shift),0),'999G999G999G990D') as tj_shift,to_char(round(sum(lembur),0),'999G999G999G990D') as lembur,to_char(round(sum(jht),0),'999G999G999G990D') as jht,to_char(round(sum(jp),0),'999G999G999G990D') as jp,to_char(round(sum(bpjs),0),'999G999G999G990D') as bpjs,to_char(round(sum(pph21),0),'999G999G999G990D') as pph21,
																		to_char(round(sum(ptg_absensi),0),'999G999G999G990D') as ptg_absensi,to_char(round(sum(ptg_idcard),0),'999G999G999G990D') as ptg_idcard,to_char(round(sum(pinjaman),0),'999G999G999G990D') as pinjaman,to_char(round(sum(total_ptg),0),'999G999G999G990D') as total_ptg,
																		to_char(round(sum(pen_lain),0),'999G999G999G990D') as pen_lain,
																		to_char(round(sum(gajikotor),0),'999G999G999G990D') as gajikotor,to_char(round(sum(gajibersih),0),'999G999G999G990D') as gajibersih,to_char(round(sum(totalupah),0),'999G999G999G990D') as totalupah,to_char(round(sum(upah_borong),0),'999G999G999G990D') as upah_borong,
																		to_char(round(sum(koreksibulanlalu),0),'999G999G999G990D') as koreksibulanlalu,to_char(round(sum(insentif_produksi),0),'999G999G999G990D') as insentif_produksi,to_char(round(sum(thr),0),'999G999G999G990D') as thr,to_char(round(sum(bonus),0),'999G999G999G990D') as bonus,to_char(round(sum(jkk),0),'999G999G999G990D') as jkk,
																		to_char(round(sum(jkm),0),'999G999G999G990D') as jkm,to_char(round(sum(ptg_lain),0),'999G999G999G990D') as ptg_lain,to_char(round(sum(ptg_koperasi),0),'999G999G999G990D') as ptg_koperasi
									from 
									(
										select nik,no_urut,keterangan,nominal as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=1
																			union all 
																			select nik,no_urut,keterangan,0 as gajipokok,nominal as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=7
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, nominal as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=8
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,nominal as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=9
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,nominal as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=10
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,nominal as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,nominal as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard ,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=21
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, nominal as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=23
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,nominal as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=22
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,nominal as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and   nodok='$nodok' and no_urut=28
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,nominal as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=4
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,nominal as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=24
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,nominal as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=26
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,nominal as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and aksi='B'
																			union all
																			select nik,29 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,sum(nominal) as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and (no_urut=5 or no_urut=6 or no_urut=12 or no_urut=13 or no_urut=14) and  nodok='$nodok'
																			group by nik,keterangan
																			union all 
																			select nik,30 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,sum(total_pendapatan) as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_master 
																			where nik='$nik' and  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,sum(total_pendapatan) as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_master 
																			where  nik='$nik' and nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,sum(total_upah) as totalupah,0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_master 
																			where  nik='$nik' and nodok='$nodok'
																			group by nik 
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,nominal as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=6
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,nominal as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=5
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,nominal as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=12	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,nominal as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=13
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,nominal as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=14
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,nominal as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where nik='$nik' and  nodok='$nodok' and no_urut=16
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,nominal as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=17	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,nominal as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=29
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,0 as ptg_lain,nominal as ptg_koperasi from sc_trx.payroll_detail 
																			where  nik='$nik' and nodok='$nodok' and no_urut=30
																			
									) as t1
									");
	
	}
	
	function q_report_payrolldetail($nodok){
		return $this->db->query("
								select a.*,b.nmlengkap,b.norek,c.nmdept from
									(select nik,to_char(round(sum(gajipokok),0),'999G999G999G990D') as gajipokok,to_char(round(sum(tj_jabatan),0),'999G999G999G990D') as tj_jabatan,to_char(round(sum(tj_masakerja),0),'999G999G999G990D') as tj_masakerja,to_char(round(sum(tj_prestasi),0),'999G999G999G990D') as tj_prestasi,
																		to_char(round(sum(tj_shift),0),'999G999G999G990D') as tj_shift,to_char(round(sum(lembur),0),'999G999G999G990D') as lembur,to_char(round(sum(jht),0),'999G999G999G990D') as jht,to_char(round(sum(jp),0),'999G999G999G990D') as jp,to_char(round(sum(bpjs),0),'999G999G999G990D') as bpjs,to_char(round(sum(pph21),0),'999G999G999G990D') as pph21,
																		to_char(round(sum(ptg_absensi),0),'999G999G999G990D') as ptg_absensi,to_char(round(sum(ptg_idcard),0),'999G999G999G990D') as ptg_idcard,to_char(round(sum(pinjaman),0),'999G999G999G990D') as pinjaman,to_char(round(sum(total_ptg),0),'999G999G999G990D') as total_ptg,
																		to_char(round(sum(pen_lain),0),'999G999G999G990D') as pen_lain,
																		to_char(round(sum(gajikotor),0),'999G999G999G990D') as gajikotor,to_char(round(sum(gajibersih),0),'999G999G999G990D') as gajibersih,to_char(round(sum(totalupah),0),'999G999G999G990D') as totalupah,to_char(round(sum(upah_borong),0),'999G999G999G990D') as upah_borong,
																		to_char(round(sum(koreksibulanlalu),0),'999G999G999G990D') as koreksibulanlalu,to_char(round(sum(insentif_produksi),0),'999G999G999G990D') as insentif_produksi,to_char(round(sum(thr),0),'999G999G999G990D') as thr,to_char(round(sum(bonus),0),'999G999G999G990D') as bonus,to_char(round(sum(jkk),0),'999G999G999G990D') as jkk,
																		to_char(round(sum(jkm),0),'999G999G999G990D') as jkm,to_char(round(sum(ptg_lain),0),'999G999G999G990D') as ptg_lain,to_char(round(sum(ptg_koperasi),0),'999G999G999G990D') as ptg_koperasi
																		from 
																		(
																			select nik,no_urut,keterangan,nominal as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=1
																			union all 
																			select nik,no_urut,keterangan,0 as gajipokok,nominal as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=7
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, nominal as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=8
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,nominal as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=9
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,nominal as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=10
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,nominal as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,nominal as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard ,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=21
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, nominal as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=23
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,nominal as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=22
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,nominal as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=28
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,nominal as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=4
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,nominal as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=24
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,nominal as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=26
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,nominal as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and aksi='B'
																			union all
																			select nik,29 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,sum(nominal) as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where (no_urut=16 or no_urut=17 or no_urut=5 or no_urut=6 or no_urut=12 or no_urut=13 or no_urut=14) and  nodok='$nodok'
																			group by nik,keterangan 
																			union all 
																			select nik,30 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,sum(total_pendapatan) as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_master 
																			where  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,sum(total_pendapatan) as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_master 
																			where  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,sum(total_upah) as totalupah,0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_master 
																			where  nodok='$nodok'
																			group by nik 
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,nominal as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=6
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,nominal as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=5
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,nominal as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=12	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,nominal as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=13
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,nominal as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=14
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,nominal as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=16
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,nominal as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=17	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,nominal as ptg_lain, 0 as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=29
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,0 as ptg_lain, nominal as ptg_koperasi from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=30		
																		) as t1
																		group by nik) a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
								
								
		
		
		");
	
	
	
	}
	
	function q_report_payrolldetail_borong($nodok){
	
	
		return $this->db->query("select a.*,b.nmlengkap,b.norek,c.nmdept from
									(select nik,to_char(round(sum(gajipokok),0),'999G999G999G990D') as gajipokok,to_char(round(sum(tj_jabatan),0),'999G999G999G990D') as tj_jabatan,to_char(round(sum(tj_masakerja),0),'999G999G999G990D') as tj_masakerja,to_char(round(sum(tj_prestasi),0),'999G999G999G990D') as tj_prestasi,
																		to_char(round(sum(tj_shift),0),'999G999G999G990D') as tj_shift,to_char(round(sum(lembur),0),'999G999G999G990D') as lembur,to_char(round(sum(jht),0),'999G999G999G990D') as jht,to_char(round(sum(jp),0),'999G999G999G990D') as jp,to_char(round(sum(bpjs),0),'999G999G999G990D') as bpjs,to_char(round(sum(pph21),0),'999G999G999G990D') as pph21,
																		to_char(round(sum(ptg_absensi),0),'999G999G999G990D') as ptg_absensi,to_char(round(sum(ptg_idcard),0),'999G999G999G990D') as ptg_idcard,to_char(round(sum(pinjaman),0),'999G999G999G990D') as pinjaman,to_char(round(sum(total_ptg),0),'999G999G999G990D') as total_ptg,
																		to_char(round(sum(pen_lain),0),'999G999G999G990D') as pen_lain,
																		to_char(round(sum(gajikotor),0),'999G999G999G990D') as gajikotor,to_char(round(sum(gajibersih),0),'999G999G999G990D') as gajibersih,to_char(round(sum(totalupah),0),'999G999G999G990D') as totalupah,to_char(round(sum(upah_borong),0),'999G999G999G990D') as upah_borong,
																		to_char(round(sum(koreksibulanlalu),0),'999G999G999G990D') as koreksibulanlalu,to_char(round(sum(insentif_produksi),0),'999G999G999G990D') as insentif_produksi,to_char(round(sum(thr),0),'999G999G999G990D') as thr,to_char(round(sum(bonus),0),'999G999G999G990D') as bonus,to_char(round(sum(jkk),0),'999G999G999G990D') as jkk,
																		to_char(round(sum(jkm),0),'999G999G999G990D') as jkm,to_char(round(sum(ptg_lain),0),'999G999G999G990D') as ptg_lain
																		from 
																		(
																			select nik,no_urut,keterangan,nominal as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=1
																			union all 
																			select nik,no_urut,keterangan,0 as gajipokok,nominal as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=7
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, nominal as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=8
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,nominal as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=9
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,nominal as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=10
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,nominal as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,nominal as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard ,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=21
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, nominal as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=23
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,nominal as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=22
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,nominal as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=28
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,nominal as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=4
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,nominal as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=24
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,nominal as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=26
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,nominal as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and aksi='B'
																			union all
																			select nik,29 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,sum(nominal) as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where (no_urut=16 or no_urut=17 or no_urut=5 or no_urut=6 or no_urut=12 or no_urut=13 or no_urut=14) and  nodok='$nodok'
																			group by nik,keterangan 
																			union all 
																			select nik,30 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,sum(total_pendapatan) as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_master 
																			where  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,sum(total_pendapatan) as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_master 
																			where  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,sum(total_upah) as totalupah,0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_master 
																			where  nodok='$nodok'
																			group by nik 
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,nominal as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=6
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,nominal as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=5
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,nominal as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=12	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,nominal as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=13
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,nominal as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=14
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,nominal as jkk, 0 as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=16
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,nominal as jkm,0 as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=17	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,nominal as ptg_lain from sc_trx.payroll_detail 
																			where  nodok='$nodok' and no_urut=29
																					
																		) as t1
																		group by nik) a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									where b.tjborong='t'");
	
	}
	
	function q_exceldetail_pph21($nodok){
		return $this->db->query("insert into sc_his.pph21rekap
								select t1.nik,b.nmlengkap,sum(t1.gajipokok),sum(tj_jabatan),sum(tj_masakerja),sum(tj_prestasi),sum(tj_shift),sum(tj_lain),sum(upah_borong),sum(lembur),sum(pengobatan),sum(jkk),sum(jkm),
								sum(bpjskes),sum(subtotalpengreg),sum(nonreg),sum(subtotalbruto),sum(bijabatan),sum(jht),sum(jp),sum(subtotalptg),sum(totalnetto),sum(pengregblnjln),sum(propengregthnjln), 
								sum(totalpropengregthn),sum(pengnonregblnjln),sum(totalperbruto),sum(bijabatansetahun),sum(jhtsetahun),sum(sisaptgjht),sum(jpsetahun),sum(sisaptgjp),sum(totalptgsetahun),sum(totalnettosetahun),sum(ptkp),
								sum(pkpsetahun),sum(pphsetahun),sum(bijabatanreg),sum(ptgjhtreg),sum(sisaptgjhtreg),sum(ptgjpreg),sum(sisaptgjpreg),sum(totalptgreg),sum(totalnettoreg),sum(ptkpreg),sum(pkpreg),
								sum(pphsetahunre),sum(ratioblnjln),sum(ratioblnsd),sum(pphblnjln),sum(pphblnsd),sum(selisih),sum(pphblnjlnbn),sum(pphkrgbayar),sum(selisih21),sum(sisablnamor),sum(amorblnjln),
								sum(pphblnjlnnor),sum(pph21all),sum(pph21reg),sum(pph21nonreg),sum(pph21nonregjln),sum(totalpph21reg),sum(totalpph21nonreg),sum(totalpph21) from 
								(
								select nik,nominal as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm ,0 as bpjskes,0 as subtotalpengreg ,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht ,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=1 and nodok='$nodok'
								union all 
								select nik, 0 as gajipokok,nominal as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg ,0 as subtotalbruto,0 as bijabatan ,0 as jht ,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun ,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=2 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,nominal as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan ,0 as jht,0 as jp,0 as subtotalptg ,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg ,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=3 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,nominal as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan ,0 as jkk,0 as jkm ,0 as bpjskes,0 as subtotalpengreg,0 as nonreg  ,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln ,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun ,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=4 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,nominal as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk ,0 as jkm ,0 as bpjskes,0 as subtotalpengreg,0 as nonreg ,0 as subtotalbruto,0 as bijabatan ,0 as jht ,0 as jp,0 as subtotalptg,0 as totalnetto ,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun ,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=5 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,nominal as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk ,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht ,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun,0 as  sisaptgjp ,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=6 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,nominal as upah_borong,0 as lembur,0 as pengobatan,0 as jkk ,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg ,0 as subtotalbruto,0 as bijabatan,0 as jht ,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun ,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=7 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,nominal as lembur,0 as pengobatan,0 as jkk ,0 as jkm,0 as bpjskes,0 as subtotalpengreg ,0 as nonreg,0 as subtotalbruto ,0 as bijabatan ,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg ,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=8 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,nominal as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg ,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun  ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=9 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,nominal as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg ,0 as nonreg ,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun ,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=10 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,nominal as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht ,0 as jp,0 as subtotalptg,0 as totalnetto ,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn ,0 as pengnonregblnjln ,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun ,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg  ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=11 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,nominal as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun  ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=12 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,nominal as subtotalpengreg,0 as nonreg,0 as subtotalbruto ,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto ,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto ,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=13 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,nominal as nonreg,0 as subtotalbruto ,0 as bijabatan,0 as jht,0 as jp ,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=14 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,nominal as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=15 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,nominal as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun ,0 as  totalnettosetahun ,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=16 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,nominal as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp ,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg  ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=17 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,nominal as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln ,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun ,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=18 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,nominal as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg ,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=19 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,nominal as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht ,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=20 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,nominal as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn ,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp ,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=21 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,nominal as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=22 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,nominal as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun ,0 as  sisaptgjp ,0 as  totalptgsetahun,0 as  totalnettosetahun ,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=23 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,nominal as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp ,0 as  totalptgsetahun ,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=24 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,nominal as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg  ,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=25 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,nominal as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp ,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=26 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,nominal as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=27 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,nominal as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp ,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun,0 as  bijabatanreg  ,0 as  ptgjhtreg,0 as  sisaptgjhtreg ,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=28 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,nominal as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=29 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,nominal as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp ,0 as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=30 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,nominal as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun ,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg ,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=30 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,nominal as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=31 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,nominal as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg ,0 as  ptgjhtreg ,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=32 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,nominal as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg ,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=33 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,nominal as  pkpsetahun,0 as  pphsetahun ,0 as  bijabatanreg ,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=34 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,nominal as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg ,0 as  sisaptgjhtreg ,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=35 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,nominal as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=36 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,nominal as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=37 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,nominal as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg ,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=38 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,nominal as  ptgjpreg,0 as  sisaptgjpreg ,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=39 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,nominal as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=40 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,nominal as  totalptgreg,0 as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=41 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,nominal as  totalnettoreg,0 as   ptkpreg, 0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                     sc_trx.p21_detail where no_urut=42 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,nominal as  ptkpreg,0 as   pkpreg, 0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                    sc_trx.p21_detail where no_urut=43 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,nominal as  pkpreg,0 as   pphsetahunre, 0 as  ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                   sc_trx.p21_detail where no_urut=44 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,nominal as  pphsetahunre,0 as   ratioblnjln, 0 as  ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                  sc_trx.p21_detail where no_urut=45 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,nominal as  ratioblnjln,0 as   ratioblnsd, 0 as  pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                 sc_trx.p21_detail where no_urut=46 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,nominal as  ratioblnsd,0 as   pphblnjln, 0 as  pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from                sc_trx.p21_detail where no_urut=47 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,nominal as  pphblnjln,0 as   pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from               sc_trx.p21_detail where no_urut=48 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,nominal as   pphblnsd, 0 as selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from               sc_trx.p21_detail where no_urut=49 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,nominal as  selisih, 0 as pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from              sc_trx.p21_detail where no_urut=50 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,nominal as  pphblnjlnbn, 0 as pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from             sc_trx.p21_detail where no_urut=51 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,nominal as  pphkrgbayar, 0 as selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from            sc_trx.p21_detail where no_urut=52 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,nominal as  selisih21, 0 as sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from           sc_trx.p21_detail where no_urut=53 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,nominal as  sisablnamor, 0 as amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from          sc_trx.p21_detail where no_urut=54 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,nominal as  amorblnjln, 0 as pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from         sc_trx.p21_detail where no_urut=55 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,nominal as  pphblnjlnnor, 0 as pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from        sc_trx.p21_detail where no_urut=56 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,nominal as  pph21all, 0 as pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from       sc_trx.p21_detail where no_urut=57 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,0 as  pph21all,nominal as  pph21reg, 0 as pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from      sc_trx.p21_detail where no_urut=58 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,0 as  pph21all,0 as  pph21reg,nominal as  pph21nonreg, 0 as pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from     sc_trx.p21_detail where no_urut=59 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,0 as  pph21all,0 as  pph21reg,0 as  pph21nonreg,nominal as  pph21nonregjln, 0 as totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from    sc_trx.p21_detail where no_urut=60 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,0 as  pph21all,0 as  pph21reg,0 as  pph21nonreg,0 as  pph21nonregjln,nominal as  totalpph21reg, 0 as totalpph21nonreg, 0 as totalpph21 from   sc_trx.p21_detail where no_urut=61 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,0 as  pph21all,0 as  pph21reg,0 as  pph21nonreg,0 as  pph21nonregjln,0 as  totalpph21reg,nominal as  totalpph21nonreg, 0 as totalpph21 from  sc_trx.p21_detail where no_urut=62 and nodok='$nodok'
								union all
								select nik, 0 as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as tj_lain,0 as upah_borong,0 as lembur,0 as pengobatan,0 as jkk,0 as jkm,0 as bpjskes,0 as subtotalpengreg,0 as nonreg,0 as subtotalbruto,0 as bijabatan,0 as jht,0 as jp,0 as subtotalptg,0 as totalnetto,0 as pengregblnjln,0 as propengregthnjln,0 as totalpropengregthn,0 as pengnonregblnjln,0 as  totalperbruto,0 as  bijabatansetahun,0 as  jhtsetahun,0 as  sisaptgjht,0 as  jpsetahun,0 as  sisaptgjp,0 as  totalptgsetahun,0 as  totalnettosetahun,0 as  ptkp,0 as  pkpsetahun,0 as  pphsetahun,0 as  bijabatanreg,0 as  ptgjhtreg,0 as  sisaptgjhtreg,0 as  ptgjpreg,0 as  sisaptgjpreg,0 as  totalptgreg,0 as  totalnettoreg,0 as  ptkpreg,0 as  pkpreg,0 as  pphsetahunre,0 as  ratioblnjln,0 as  ratioblnsd,0 as  pphblnjln,0 as  pphblnsd,0 as  selisih,0 as  pphblnjlnbn,0 as  pphkrgbayar,0 as  selisih21,0 as  sisablnamor,0 as  amorblnjln,0 as  pphblnjlnnor,0 as  pph21all,0 as  pph21reg,0 as  pph21nonreg,0 as  pph21nonregjln,0 as  totalpph21reg,0 as  totalpph21nonreg,nominal as  totalpph21 from sc_trx.p21_detail where no_urut=63 and nodok='$nodok'

								) as t1
								left outer join sc_mst.karyawan b on t1.nik=b.nik
								group by t1.nik,b.nmlengkap");
	
	
	}
	
	
		/* PPH21 FORM 1721 */
	function q_1721rekaptrx($tahun,$kdgroup_pg){
		return $this->db->query("select * from sc_trx.p1721_rekap where to_char(tgl_dok,'yyyy')='$tahun' and grouppenggajian='$kdgroup_pg'");
		
	}
	function q_1721detailnik($nik){
		return $this->db->query("select * from sc_trx.p1721_detail where nik='$nik' and no_urut<>'99' order by no_urut");
	}
	
	function q_1721detail($kddept,$tahun,$kdgroup_pg){
		return $this->db->query("select t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,sum(t1.gajipokok)as gaji_pokok,sum(tj_pph) as tj_pph,sum(tj_lain) as tj_lain,sum(honorarium) as honorarium,sum(premiasuransi) as premiasuransi,sum(natuna) as natuna,sum(p_nonreg) as p_nonreg,sum(subtotal_bruto) as subtotal_bruto,sum(biaya_jabatan) as biaya_jabatan,
		sum(pensiun) as pensiun,sum(subtotal_potongan) as subtotal_potongan,sum(sub_netto) as sub_netto,sum(netto_sebelumnya) as netto_sebelumnya,sum(netto_untukpph21) as netto_untukpph21,sum(ptkp_setahun) as ptkp_setahun,sum(pkp_setahun) as pkp_setahun,sum(pph21_setahun) as pph21_setahun,sum(pph21_masa_sebelumnya) as pph21_masa_sebelumnya,
		sum(pph21_terutang) as pph21_terutang,sum(pph2126_dipotong) as pph21_dipotong,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan from 
		(select nik,nominal as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=1
		union all
		select nik,0 as gajipokok,nominal as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=2
		union all
		select nik,0 as gajipokok,0 as tj_pph,nominal as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=3
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,nominal as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=4
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,nominal as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=5
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,nominal as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=6
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,nominal as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=7
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,nominal as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=8
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,nominal as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=9
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,nominal as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=10
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,nominal as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=11
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,nominal as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=12
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,nominal as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=13
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,nominal as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=14
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,nominal as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=15
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,nominal as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=16
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,nominal as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=17
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,nominal as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=18
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,nominal as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=19
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,nominal as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=20
		) as t1 
		left outer join sc_mst.karyawan b on t1.nik=b.nik
		left outer join (select * from sc_trx.p1721_detail where no_urut=99) c on t1.nik=c.nik
		where b.bag_dept='$kddept' and b.grouppenggajian='$kdgroup_pg'
		group by t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan
		order by b.nmlengkap asc");
		
	}
	
	function q_1721nik($nik,$kddept,$kdgroup_pg){
		return $this->db->query("select t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,round(sum(t1.gajipokok))as gaji_pokok,round(sum(tj_pph)) as tj_pph,round(sum(tj_lain)) as tj_lain,round(sum(honorarium)) as honorarium,round(sum(premiasuransi)) as premiasuransi,round(sum(natuna)) as natuna,round(sum(p_nonreg)) as p_nonreg,round(sum(subtotal_bruto)) as subtotal_bruto,round(sum(biaya_jabatan)) as biaya_jabatan,
		round(sum(pensiun)) as pensiun,round(sum(subtotal_potongan)) as subtotal_potongan,round(sum(sub_netto)) as sub_netto,round(sum(netto_sebelumnya)) as netto_sebelumnya,round(sum(netto_untukpph21)) as netto_untukpph21,round(sum(ptkp_setahun)) as ptkp_setahun,round(sum(pkp_setahun)) as pkp_setahun,round(sum(pph21_setahun)) as pph21_setahun,round(sum(pph21_masa_sebelumnya)) as pph21_masa_sebelumnya,
		round(sum(pph21_terutang)) as pph21_terutang,round(sum(pph2126_dipotong)) as pph21_dipotong,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan,substring(c.nomor_pelaporan,5,2) as bl,substring(c.nomor_pelaporan,8,2) as th,right(c.nomor_pelaporan,6) as urut from 
		(select nik,nominal as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=1
		union all
		select nik,0 as gajipokok,nominal as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=2
		union all
		select nik,0 as gajipokok,0 as tj_pph,nominal as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=3
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,nominal as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=4
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,nominal as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=5
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,nominal as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=6
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,nominal as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=7
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,nominal as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=8
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,nominal as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=9
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,nominal as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=10
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,nominal as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=11
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,nominal as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=12
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,nominal as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=13
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,nominal as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=14
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,nominal as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=15
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,nominal as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=16
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,nominal as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=17
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,nominal as pph21_masa_sebelumnya,0 as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=18
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,nominal as pph21_terutang,0 as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=19
		union all
		select nik,0 as gajipokok,0 as tj_pph,0 as tj_lain,0 as honorarium,0 as premiasuransi,0 as natuna,0 as p_nonreg,0 as subtotal_bruto ,0 as biaya_jabatan,0 as pensiun ,0 as subtotal_potongan,0 as sub_netto,0 as netto_sebelumnya,0 as netto_untukpph21,0 as ptkp_setahun,0 as pkp_setahun,0 as pph21_setahun,0 as pph21_masa_sebelumnya,0 as pph21_terutang,nominal as pph2126_dipotong  from sc_trx.p1721_detail where no_urut=20
		) as t1 
		left outer join sc_mst.karyawan b on t1.nik=b.nik
		left outer join (select * from sc_trx.p1721_detail where no_urut=99) c on t1.nik=c.nik
		where t1.nik='$nik' and b.grouppenggajian='$kdgroup_pg'
		group by t1.nik,b.nmlengkap,b.bag_dept,b.grouppenggajian,c.periode_mulai,c.periode_akhir,c.nomor_pelaporan
		order by b.nmlengkap asc");
		
	}
	
	function q_dtl_kary($nik,$kddept,$kdgroup_pg){
		return $this->db->query("select a.*,b.nmjabatan from sc_mst.karyawan a 
		left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan where nik='$nik' and grouppenggajian='$kdgroup_pg'");
	}
	
	
	
}	