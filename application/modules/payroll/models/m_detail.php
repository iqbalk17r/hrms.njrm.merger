<?php
class M_detail extends CI_Model{




	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								order by nmlengkap asc");

	}

	function list_karyawan_detail($nik){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where nik='$nik'
								order by nmlengkap asc");

	}

	function list_master_old($nik){
		return $this->db->query("select * from sc_tmp.payroll_master
								where nik='$nik'
								");


	}

	function list_master($nodok,$kddept,$periode){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_upah,0),'999G999G999G990D00') as total_upah1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.payroll_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok is not null and a.kddept='$kddept' and to_char(a.periode_akhir,'MM')='$periode' $nodok
								order by b.nmlengkap
								");


	}

	function list_master_pph($nodok,$kddept){
		return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.gaji_netto,0),'999G999G999G990D00') as gaji_netto1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.p21_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok is not null and a.kddept='$kddept' $nodok
								order by b.nmlengkap
								");


	}

    function report_master_pph($nodok,$kddept){
        return $this->db->query("select b.nmlengkap,a.*,to_char(round(a.total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(a.total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(a.gaji_netto,0),'999G999G999G990D00') as gaji_netto1,
								to_char(round(a.total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.p21_master a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								where a.nodok is not null and a.nodok='$nodok'
								order by b.nmlengkap
								");


    }

	function list_detail_old($nik,$nodok){
		return $this->db->query("select a.*,to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1,b.uraian from sc_tmp.payroll_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nik='$nik' and a.nodok='$nodok'");

	}

	function list_detail($nik,$nodok){
		return $this->db->query("select nik,no_urut,keterangan,uraian,cast(tipe as character(20)),to_char(round(nominal,0),'999G999G999G990D00') as nominal1,nominal from (
								select nodok,nik,no_urut,keterangan,nominal,aksi,tipe from sc_tmp.payroll_detail
								union all
								select nodok,nik,99 as no_urut,'TOTAL UPAH' as keterangan,total_upah,'A' as aksi,'OTOMATIS' as tipe from sc_tmp.payroll_master 
								) as t1
							left outer join sc_mst.trxtype b on t1.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
							where t1.nik='$nik' and t1.nodok='$nodok'
							order by t1.no_urut
							");

	}

	function list_detail_pph($nik,$nodok){
		return $this->db->query("select a.*,to_char(round(a.nominal,2),'999G999G999G990D00') as nominal1,b.uraian from sc_tmp.p21_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nik='$nik' and a.nodok='$nodok'");

	}

	function list_rekap($nodok,$kddept,$periode){
		return $this->db->query("select *,to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1,
								to_char(round(total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.payroll_rekap 
								where nodok is not null and kddept='$kddept' and to_char(periode_akhir,'MM')='$periode' $nodok");

	}

	function list_rekap_pph($nodok,$kddept){
		return $this->db->query("select *,to_char(round(total_pajak,0),'999G999G999G990D00') as total_pajak1,
								to_char(round(total_pendapatan,0),'999G999G999G990D00') as total_pendapatan1,
								to_char(round(total_potongan,0),'999G999G999G990D00') as total_potongan1 from sc_tmp.p21_rekap where nodok is not null
								and kddept='$kddept' $nodok");

	}
	function cek_p21rekap($nodok,$periode,$kddept){
		return $this->db->query("select * from sc_tmp.p21_rekap where nodok='$nodok' and periode_mulai='$periode' and periode_akhir='$periode' and kddept='$kddept'");
	}
	function q_absensi($nodok,$nik){
		return $this->db->query("select *,to_char(round(cuti_nominal,0),'999G999G999G990D00') as cuti_nominal1 from sc_tmp.cek_absen where  nik='$nik'
								");


	}

	function q_shift($nodok,$nik){
		return $this->db->query("select *,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_tmp.tunjangan_shift where  nik='$nik'
								");


	}

	function q_upah_borong($nodok,$nik){
		return $this->db->query("select *,to_char(round(total_upah,0),'999G999G999G990D00') as total_upah1 from sc_tmp.cek_borong where  nik='$nik'
								");


	}

	function q_lembur($nodok,$nik){
		return $this->db->query("select *,to_char(round(nominal,0),'999G999G999G990D00') as nominal1 from sc_tmp.cek_lembur where  nik='$nik'
								");

	}

	function q_tglperiode($nodok){
		return $this->db->query("select distinct periode_akhir from sc_tmp.payroll_rekap where nodok='$nodok'");
	}

	function list_karyawan_tmp(){
		return $this->db->query("select * from sc_tmp.payroll_master 
								where nodok='$nodok'
								order by nik asc");

	}

	function list_department(){
		return $this->db->query("select * from sc_mst.departmen");

	}

	function list_karyawan_susulan($kdgroup_pg,$kddept){
		return $this->db->query("select * from sc_mst.karyawan 
								where tglkeluarkerja is null and grouppenggajian='$kdgroup_pg' 
								and nik not in (select nik from sc_tmp.payroll_master where TRUE)
								order by nmlengkap asc");

	}

	function cektrx($nodok){
		return $this->db->query("select * from sc_mst.trxerror where userid='$nodok' and modul='PPH21_GEN' and errorcode='0'");
	}

	function q_setup_option_dept(){
		return $this->db->query("select * from sc_mst.option where kdoption='PAYROL01'");
	}

	function q_capture_pinjaman($param = null){
	    return $this->db->query("select * from (
                                      select a.*,b.nmlengkap,c.status as statusmst from sc_trx.payroll_pinjaman_inq a
                                      left outer join sc_mst.karyawan b on a.nik=b.nik
                                       join sc_trx.payroll_pinjaman_mst c on a.docno=c.docno
                                      ) as x
                                      where nik is not null  $param ");
    }

    function q_pinjaman_mst($param =  null){
	    return $this->db->query("select * from sc_trx.payroll_pinjaman_mst where docno is not null $param ");
    }

    function q_report_payrolldetail($nodok,$periode_akhir){
        return $this->db->query("
								select a.*,b.nmlengkap,to_char(b.tglmasukkerja,'dd-mm-yyyy') as tglmasukkerjax,b.kdlvlgp,b.norek,c.nmdept,d.nominal as his_gajitetap,d.gajipokok as his_gajipokok,d.gajitj as his_gajitj, to_char(round(d.k_gplvl,0),'999G999G999G990D') as his_k_gplvl, to_char(round(d.k_gpwil,0),'999G999G999G990D') as his_k_gpwil  from
									(select nik,to_char(round(sum(gajipokok),0),'999G999G999G990D') as gajipokok,to_char(round(sum(tj_jabatan),0),'999G999G999G990D') as tj_jabatan,to_char(round(sum(tj_masakerja),0),'999G999G999G990D') as tj_masakerja,to_char(round(sum(tj_prestasi),0),'999G999G999G990D') as tj_prestasi,
																		to_char(round(sum(tj_shift),0),'999G999G999G990D') as tj_shift,to_char(round(sum(lembur),0),'999G999G999G990D') as lembur,to_char(round(sum(jht),0),'999G999G999G990D') as jht,to_char(round(sum(jp),0),'999G999G999G990D') as jp,to_char(round(sum(bpjs),0),'999G999G999G990D') as bpjs,to_char(round(sum(pph21),0),'999G999G999G990D') as pph21,
																		to_char(round(sum(ptg_absensi),0),'999G999G999G990D') as ptg_absensi,to_char(round(sum(ptg_idcard),0),'999G999G999G990D') as ptg_idcard,to_char(round(sum(pinjaman),0),'999G999G999G990D') as pinjaman,to_char(round(sum(total_ptg),0),'999G999G999G990D') as total_ptg,
																		to_char(round(sum(pen_lain),0),'999G999G999G990D') as pen_lain,
																		to_char(round(sum(gajikotor),0),'999G999G999G990D') as gajikotor,to_char(round(sum(gajibersih),0),'999G999G999G990D') as gajibersih,to_char(round(sum(totalupah),0),'999G999G999G990D') as totalupah,to_char(round(sum(upah_borong),0),'999G999G999G990D') as upah_borong,
																		to_char(round(sum(koreksibulanlalu),0),'999G999G999G990D') as koreksibulanlalu,to_char(round(sum(insentif_produksi),0),'999G999G999G990D') as insentif_produksi,to_char(round(sum(thr),0),'999G999G999G990D') as thr,to_char(round(sum(bonus),0),'999G999G999G990D') as bonus,to_char(round(sum(jkk),0),'999G999G999G990D') as jkk,
																		to_char(round(sum(jkm),0),'999G999G999G990D') as jkm,to_char(round(sum(ptg_lain),0),'999G999G999G990D') as ptg_lain,to_char(round(sum(ptg_koperasi),0),'999G999G999G990D') as ptg_koperasi
																		from 
																		(
																			select nik,no_urut,keterangan,nominal as gajipokok,0 as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=1
																			union all 
																			select nik,no_urut,keterangan,0 as gajipokok,nominal as tj_jabatan,0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=7
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, nominal as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=8
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,nominal as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=9
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,nominal as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=10
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,nominal as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=11
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,nominal as jht,0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard ,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=21
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, nominal as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=23
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,nominal as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=22
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,nominal as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=28
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,nominal as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=4
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,nominal as ptg_idcard,0 as pinjaman,0 as total_ptg ,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=24
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,nominal as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=26
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,nominal as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and aksi='B'
																			union all
																			select nik,29 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,sum(nominal) as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where (no_urut=16 or no_urut=17 or no_urut=5 or no_urut=6 or no_urut=12 or no_urut=13 or no_urut=14) and  nodok='$nodok'
																			group by nik,keterangan 
																			union all 
																			select nik,30 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,sum(total_pendapatan) as gajikotor,0 as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_master 
																			where  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,sum(total_pendapatan) as gajibersih,0 as totalupah, 0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_master 
																			where  nodok='$nodok'
																			group by nik
																			union all 
																			select nik,31 as no_urut,null as keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,sum(total_upah) as totalupah,0 as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_master 
																			where  nodok='$nodok'
																			group by nik 
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,nominal as upah_borong, 0 as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=6
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,nominal as koreksibulanlalu, 0 as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=5
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,nominal as insentif_produksi, 0 as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=12	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,nominal as thr, 0 as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=13
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,nominal as bonus, 0 as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=14
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,nominal as jkk, 0 as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=16
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,nominal as jkm,0 as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=17	
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,nominal as ptg_lain, 0 as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=29
																			union all
																			select nik,no_urut,keterangan,0 as gajipokok,0 as tj_jabatan, 0 as tj_masakerja,0 as tj_prestasi,0 as tj_shift,0 as lembur,0 as jht, 0 as jp,0 as bpjs,0 as pph21,0 as ptg_absensi,0 as ptg_idcard,0 as pinjaman,0 as total_ptg,0 as pen_lain,0 as gajikotor,0 as gajibersih,0 as totalupah,0 as upah_borong,0 as koreksibulanlalu,0 as insentif_produksi,0 as thr,0 as bonus,0 as jkk,0 as jkm,0 as ptg_lain, nominal as ptg_koperasi from sc_tmp.payroll_detail 
																			where  nodok='$nodok' and no_urut=30		
																		) as t1
																		group by nik) a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									left outer join sc_his.history_gaji d on a.nik=d.nik and right(trim(periode),4)=right(trim('$periode_akhir'),4) 
								order by b.nmlengkap asc
								
		
		
		");



    }

    function capture_tmp_payroll_rekap($nodok){
	    return $this->db->query("select * from sc_tmp.payroll_rekap where nodok ='$nodok'");
    }
}
