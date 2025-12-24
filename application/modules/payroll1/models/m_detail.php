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
								where tglkeluarkerja is null and grouppenggajian='$kdgroup_pg' and bag_dept='$kddept' 
								and nik not in (select nik from sc_tmp.payroll_master where kddept='$kddept')
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
	
	
}	