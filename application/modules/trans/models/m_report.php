<?php
class M_report extends CI_Model{

	function q_kantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah");
	}
	
	function q_laporan(){
		return $this->db->query("select * from sc_mst.report where type_report='HRD' order by desc_report");
	}
	
	function q_man_power($tahun,$bulan){		
		if ($bulan<>'12') {
			$thn1=$tahun;
			$thn2=$tahun;
			$bln1=$bulan;
			$bln2=$bulan+1;
		} else {
			$thn2=$thn+1;
			$thn1=$tahun;
			$bln1=$bulan;
			$bln2=1;
		}
		return $this->db->query("select '2' as urut,ROW_NUMBER() OVER (ORDER BY dept) AS nomor,dept,subdept,jabt,count(jabt) as ttl,
									sum(sar) as srj, sum(dpm) as dpm, sum(sma) as sma,sum(smp) as smp,sum(sd) as sd,
									sum(mdmak) as dmkm,sum(fdmak) as dmkf, 
									sum(mcnd) as cndm,sum(fcnd) as cndf, 
									sum(mmrg) as mrgm,sum(fmrg) as mrgf, 
									sum(mkpk) as kpkm,sum(fkpk) as kpkf,
									coalesce(sum(mdmak),0)+coalesce(sum(mcnd),0)+coalesce(sum(mmrg),0)+coalesce(sum(mkpk),0) as nasm,
									coalesce(sum(fdmak),0)+coalesce(sum(fcnd),0)+coalesce(sum(fmrg),0)+coalesce(sum(fkpk),0) as nasf,									
									sum(newemp) as newemp,sum(resign) as resign  
									from 
									(select  b.departement as dept,e.subdepartement as subdept,c.deskripsi as jabt,
									case when kdpen='I' or kdpen='J' or kdpen='K'  then count(a.nip) end as sar,
									case when kdpen='D' or kdpen='E' or kdpen='F' or kdpen='G'  then count(a.nip) end as dpm,
									case when kdpen='C' then count(a.nip) end as sma,
									case when kdpen='B' then count(a.nip) end as smp,
									case when kdpen='A' then count(a.nip) end as sd,
									case when kdcabang='SMGDMK' and kdkelamin='B' then count(a.nip) end as mdmak,
									case when kdcabang='SMGDMK' and kdkelamin='A' then count(a.nip) end as fdmak,
									case when kdcabang='SMGCND' and kdkelamin='B' then count(a.nip) end as mcnd,
									case when kdcabang='SMGCND' and kdkelamin='A' then count(a.nip) end as fcnd,
									case when kdcabang='$kantor' and kdkelamin='B' then count(a.nip) end as mmrg,
									case when kdcabang='$kantor' and kdkelamin='A' then count(a.nip) end as fmrg,
									case when kdcabang='JKTKPK' and kdkelamin='B' then count(a.nip) end as mkpk,
									case when kdcabang='JKTKPK' and kdkelamin='A' then count(a.nip) end as fkpk,
									case when masukkerja>='$thn1-$bln1-1' and masukkerja<'$thn2-$bln2-1'   then count(a.nip) end as newemp,	
									case when keluarkerja>='$thn1-$bln1-1' and keluarkerja<'$thn2-$bln2-1'    then count(a.nip) end as resign
									from sc_hrd.pegawai a
									left outer join sc_hrd.departement b on a.kddept=b.kddept
									left outer join sc_hrd.jabatan c on a.kdjabatan=c.kdjabatan and a.kddept=c.kddept and a.kdsubdept=c.kdsubdept
									left outer join sc_hrd.subdepartement e on a.kddept=e.kddept and a.kdsubdept=e.kdsubdept
									left outer join (select max(kdpendidikan) as kdpen,nip from sc_hrd.pendidikan group by nip) as f on a.nip=f.nip	
									group by a.nmlengkap,b.departement,e.subdepartement,c.deskripsi,a.keluarkerja,kdcabang,kdkelamin,masukkerja,kdpen
									having a.keluarkerja>'$thn1-$bln1-1' or a.keluarkerja is null
									order by dept,subdept asc
									) as t1 
								group by dept,subdept,jabt
								union all
								select '3' as urut,ROW_NUMBER() OVER (ORDER BY dept) AS nomor,dept,subdept,'SUB TOTAL' as jabt,count(subdept) as ttl,
									sum(sar) as srj, sum(dpm) as dpm, sum(sma) as sma,sum(smp) as smp,sum(sd) as sd,
									sum(mdmak) as dmkm,sum(fdmak) as dmkf, 
									sum(mcnd) as cndm,sum(fcnd) as cndf, 
									sum(mmrg) as mrgm,sum(fmrg) as mrgf, 
									sum(mkpk) as kpkm,sum(fkpk) as kpkf,
									coalesce(sum(mdmak),0)+coalesce(sum(mcnd),0)+coalesce(sum(mmrg),0)+coalesce(sum(mkpk),0) as nasm,
									coalesce(sum(fdmak),0)+coalesce(sum(fcnd),0)+coalesce(sum(fmrg),0)+coalesce(sum(fkpk),0) as nasf,
									sum(newemp) as newemp,sum(resign) as resign 
									from 
									(select  b.departement as dept,e.subdepartement as subdept,c.deskripsi as jabt,
									case when kdpen='I' or kdpen='J' or kdpen='K'  then count(a.nip) end as sar,
									case when kdpen='D' or kdpen='E' or kdpen='F' or kdpen='G'  then count(a.nip) end as dpm,
									case when kdpen='C' then count(a.nip) end as sma,
									case when kdpen='B' then count(a.nip) end as smp,
									case when kdpen='A' then count(a.nip) end as sd,
									case when kdcabang='SMGDMK' and kdkelamin='B' then count(a.nip) end as mdmak,
									case when kdcabang='SMGDMK' and kdkelamin='A' then count(a.nip) end as fdmak,
									case when kdcabang='SMGCND' and kdkelamin='B' then count(a.nip) end as mcnd,
									case when kdcabang='SMGCND' and kdkelamin='A' then count(a.nip) end as fcnd,
									case when kdcabang='$kantor' and kdkelamin='B' then count(a.nip) end as mmrg,
									case when kdcabang='$kantor' and kdkelamin='A' then count(a.nip) end as fmrg,
									case when kdcabang='JKTKPK' and kdkelamin='B' then count(a.nip) end as mkpk,
									case when kdcabang='JKTKPK' and kdkelamin='A' then count(a.nip) end as fkpk,
									case when masukkerja>='$thn1-$bln1-1' and masukkerja<'$thn2-$bln2-1'   then count(a.nip) end as newemp,	
									case when keluarkerja>='$thn1-$bln1-1' and keluarkerja<'$thn2-$bln2-1'    then count(a.nip) end as resign
									from sc_hrd.pegawai a
									left outer join sc_hrd.departement b on a.kddept=b.kddept
									left outer join sc_hrd.jabatan c on a.kdjabatan=c.kdjabatan and a.kddept=c.kddept and a.kdsubdept=c.kdsubdept
									left outer join sc_hrd.subdepartement e on a.kddept=e.kddept and a.kdsubdept=e.kdsubdept	
									left outer join (select max(kdpendidikan) as kdpen,nip from sc_hrd.pendidikan group by nip) as f on a.nip=f.nip								
									group by a.nmlengkap,b.departement,e.subdepartement,c.deskripsi,a.keluarkerja,kdcabang,kdkelamin,masukkerja,kdpen
									having a.keluarkerja>'$thn1-$bln1-1' or a.keluarkerja is null
									order by dept,subdept asc
									) as t1 
								group by dept,subdept
								union all
								select '4' as urut,null,null,null,'TOTAL' as jabt,count(subdept) as ttl,sum(sar) as srj, sum(dpm) as dpm, sum(sma) as sma,sum(smp) as smp,sum(sd) as sd,sum(mdmak) as dmkm,sum(fdmak) as dmkf, 	
									sum(mcnd) as cndm,sum(fcnd) as cndf, 
									sum(mmrg) as mrgm,sum(fmrg) as mrgf, 
									sum(mkpk) as kpkm,sum(fkpk) as kpkf,
									coalesce(sum(mdmak),0)+coalesce(sum(mcnd),0)+coalesce(sum(mmrg),0)+coalesce(sum(mkpk),0) as nasm,
									coalesce(sum(fdmak),0)+coalesce(sum(fcnd),0)+coalesce(sum(fmrg),0)+coalesce(sum(fkpk),0) as nasf,
									sum(newemp) as newemp,sum(resign) as resign
									from 
									(select  b.departement as dept,e.subdepartement as subdept,c.deskripsi as jabt,
									case when kdpen='I' or kdpen='J' or kdpen='K'  then count(a.nip) end as sar,
									case when kdpen='D' or kdpen='E' or kdpen='F' or kdpen='G'  then count(a.nip) end as dpm,
									case when kdpen='C' then count(a.nip) end as sma,
									case when kdpen='B' then count(a.nip) end as smp,
									case when kdpen='A' then count(a.nip) end as sd,
									case when kdcabang='SMGDMK' and kdkelamin='B' then count(a.nip) end as mdmak,
									case when kdcabang='SMGDMK' and kdkelamin='A' then count(a.nip) end as fdmak,
									case when kdcabang='SMGCND' and kdkelamin='B' then count(a.nip) end as mcnd,
									case when kdcabang='SMGCND' and kdkelamin='A' then count(a.nip) end as fcnd,
									case when kdcabang='$kantor' and kdkelamin='B' then count(a.nip) end as mmrg,
									case when kdcabang='$kantor' and kdkelamin='A' then count(a.nip) end as fmrg,
									case when kdcabang='JKTKPK' and kdkelamin='B' then count(a.nip) end as mkpk,
									case when kdcabang='JKTKPK' and kdkelamin='A' then count(a.nip) end as fkpk,
									case when masukkerja>='$thn1-$bln1-1' and masukkerja<'$thn2-$bln2-1'   then count(a.nip) end as newemp,	
									case when keluarkerja>='$thn1-$bln1-1' and keluarkerja<'$thn2-$bln2-1'    then count(a.nip) end as resign
									from sc_hrd.pegawai a
									left outer join sc_hrd.departement b on a.kddept=b.kddept
									left outer join sc_hrd.jabatan c on a.kdjabatan=c.kdjabatan and a.kddept=c.kddept and a.kdsubdept=c.kdsubdept
									left outer join sc_hrd.subdepartement e on a.kddept=e.kddept and a.kdsubdept=e.kdsubdept								
									left outer join (select max(kdpendidikan) as kdpen,nip from sc_hrd.pendidikan group by nip) as f on a.nip=f.nip								
									group by a.nmlengkap,b.departement,e.subdepartement,c.deskripsi,a.keluarkerja,kdcabang,kdkelamin,masukkerja,kdpen
									having a.keluarkerja>'$thn1-$bln1-1' or a.keluarkerja is null
									order by dept,subdept asc
									) as t1 
								union all
								select '1' as urut,ROW_NUMBER() OVER (order by departement,subdepartement) AS nomor,--ROW_NUMBER() OVER (ORDER BY departement,subdepartement) AS nomor2,
								departement,subdepartement,null as jabt, null as ttl,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null from sc_hrd.departement a
								left outer join sc_hrd.subdepartement b on a.kddept=b.kddept
								order by dept,subdept,urut,nomor		
							");
	}
	

	function q_detail_mp($tahun,$bulan){
		if ($bulan<>'12') {
			$thn=$tahun;
			$bln1=$bulan;
			$bln2=$bulan+1;
		} else {
			$thn=$thn+1;
			$bln=1;
		}
		return $this->db->query("select distinct a.nmlengkap,b.departement,e.subdepartement,c.deskripsi,d.desc_cabang from sc_hrd.pegawai a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								left outer join sc_hrd.jabatan c on a.kdjabatan=c.kdjabatan and a.kddept=c.kddept and a.kdsubdept=c.kdsubdept
								left outer join sc_mst.kantor d on a.kdcabang=d.kodecabang
								left outer join sc_hrd.subdepartement e on a.kddept=e.kddept and a.kdsubdept=e.kdsubdept								
								group by a.nmlengkap,b.departement,e.subdepartement,c.deskripsi,d.desc_cabang,a.keluarkerja
								having a.keluarkerja>'$thn-$bln1-1' or a.keluarkerja is null
								order by departement,subdepartement asc
								");
	}
	
	function q_group(){
		return $this->db->query("select count(b.departement) as jumlah, b.departement from sc_hrd.pegawai a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								left outer join sc_hrd.jabatan c on a.kdjabatan=c.kdjabatan
								left outer join sc_mst.kantor d on a.kdcabang=d.kodecabang
								group by b,departement
								order by b.departement asc");
	}
	//Febri 18-04-2015 revisi junis 15-12-2015
	function q_status_kepegawaian($tahun,$bulan){
		return $this->db->query("select distinct a.nip,f.nmlengkap,g.departement, h.subdepartement,i.deskripsi,to_char(f.masukkerja,'dd-mm-yyyy') as masuk,
								to_char(b.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(b.tanggal2,'dd-mm-yyyy') as ojt,
								to_char(c.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(c.tanggal2,'dd-mm-yyyy') as pwkt1,
								to_char(d.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(d.tanggal2,'dd-mm-yyyy') as pwkt2, 
								'Ditetapkan '||to_char(e.tanggal1,'dd-mm-yyyy') as tetap
								from sc_hrd.kontrak a
								left outer join sc_hrd.kontrak b on a.nip=b.nip and b.kdkontrak='AA' and '$tahun$bulan'  between to_char(b.tanggal1,'yyyymm') and to_char(b.tanggal2,'yyyymm')
								left outer join sc_hrd.kontrak c on a.nip=c.nip and c.kdkontrak='AB' and '$tahun$bulan'  between to_char(c.tanggal1,'yyyymm') and to_char(c.tanggal2,'yyyymm')
								left outer join sc_hrd.kontrak d on a.nip=d.nip and d.kdkontrak='AC' and '$tahun$bulan'  between to_char(d.tanggal1,'yyyymm') and to_char(d.tanggal2,'yyyymm')
								left outer join sc_hrd.kontrak e on a.nip=e.nip and e.kdkontrak='AD' and to_char(e.tanggal1,'yyyymm')<='$tahun$bulan'
								left outer join sc_hrd.pegawai f on a.nip=f.nip
								left outer join sc_hrd.departement g on f.kddept=g.kddept
								left outer join sc_hrd.subdepartement h on f.kdsubdept=h.kdsubdept and f.kddept=h.kddept
								left outer join sc_hrd.jabatan i on f.kdsubdept=i.kdsubdept and f.kddept=i.kddept and f.kdjabatan=i.kdjabatan
								where f.keluarkerja is null and '$tahun$bulan'  between to_char(a.tanggal1,'yyyymm') and to_char(a.tanggal2,'yyyymm')
								or to_char(e.tanggal1,'yyyymm')<='$tahun$bulan'
								order by nmlengkap asc");
	}
	function q_total_status_kepegawaian($tahun,$bulan){
		return $this->db->query("select count(ojt) as ojt,count(pwkt1) as pkwt1,count(pwkt2) as pkwt2,count(tetap) as tetap from (
								select distinct a.nip,f.nmlengkap,g.departement, h.subdepartement,i.deskripsi,to_char(f.masukkerja,'dd-mm-yyyy') as masuk,
								to_char(b.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(b.tanggal2,'dd-mm-yyyy') as ojt,
								to_char(c.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(c.tanggal2,'dd-mm-yyyy') as pwkt1,
								to_char(d.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(d.tanggal2,'dd-mm-yyyy') as pwkt2, 
								'Ditetapkan '||to_char(e.tanggal1,'dd-mm-yyyy') as tetap
								from sc_hrd.kontrak a
								left outer join sc_hrd.kontrak b on a.nip=b.nip and b.kdkontrak='AA' and '$tahun$bulan'  between to_char(b.tanggal1,'yyyymm') and to_char(b.tanggal2,'yyyymm')
								left outer join sc_hrd.kontrak c on a.nip=c.nip and c.kdkontrak='AB' and '$tahun$bulan'  between to_char(c.tanggal1,'yyyymm') and to_char(c.tanggal2,'yyyymm')
								left outer join sc_hrd.kontrak d on a.nip=d.nip and d.kdkontrak='AC' and '$tahun$bulan'  between to_char(d.tanggal1,'yyyymm') and to_char(d.tanggal2,'yyyymm')
								left outer join sc_hrd.kontrak e on a.nip=e.nip and e.kdkontrak='AD' and to_char(e.tanggal1,'yyyymm')<='$tahun$bulan'
								left outer join sc_hrd.pegawai f on a.nip=f.nip
								left outer join sc_hrd.departement g on f.kddept=g.kddept
								left outer join sc_hrd.subdepartement h on f.kdsubdept=h.kdsubdept and f.kddept=h.kddept
								left outer join sc_hrd.jabatan i on f.kdsubdept=i.kdsubdept and f.kddept=i.kddept and f.kdjabatan=i.kdjabatan
								where f.keluarkerja is null and '$tahun$bulan'  between to_char(a.tanggal1,'yyyymm') and to_char(a.tanggal2,'yyyymm')
								or to_char(e.tanggal1,'yyyymm')<='$tahun$bulan'
								order by nmlengkap asc ) as t1");
								
	}
	//Febri 18-04-2015
	function q_chart(){
		return $this->db->query("select t2.desc_kontrak,t1.total from (
								select kdkontrak,count(nip)as total from sc_hrd.kontrak
								group by kdkontrak) as t1
								left outer join sc_hrd.ketkontrak t2 on t2.kdkontrak=t1.kdkontrak");
	}
	
	function q_turn_over($periode,$kantor){
		/*if ($bulan<>'12') {
			$thn1=$tahun;	
			$thn2=$tahun;	
			$bln1=$bulan;
			$bln2=$bulan+1;
		} else {
			$thn1=$tahun;
			$thn2=$tahun+1;
			$bln1=$bulan;
			$bln2=1;
		}*/
		
		if (trim($kantor)<>'NAS'){
			$kantor1="= '$kantor'";
		
		} else {
			$kantor1=" is not null";
		
		}
		
		return $this->db->query("select 
										case when to_char(masukkerja,'YYYYMM')='$periode' then '1B.MASUK' else '2B.KELUAR' end as urut,
										e.desc_cabang, row_number() over (order by desc_cabang,nmlengkap) as nomor,
										a.nmlengkap,a.nip,b.departement,c.subdepartement,d.deskripsi,TO_CHAR(a.masukkerja, 'dd-mm-YYYY') as masuk,to_char(a.keluarkerja,'dd-mm-yyyy') as keluar,f.desc_pendidikan,a.alamat,age(a.tgllahir) as usia 
										from sc_hrd.pegawai a
										left outer join sc_hrd.departement b on a.kddept=b.kddept
										left outer join sc_hrd.subdepartement c on a.kdsubdept=c.kdsubdept and a.kddept=c.kddept
										left outer join sc_hrd.jabatan d on a.kddept=d.kddept and a.kdsubdept=d.kdsubdept and a.kdjabatan=d.kdjabatan
										left outer join sc_mst.kantor e on a.kdcabang=e.kodecabang
										left outer join (select nip,desc_pendidikan from 
													(select max(a.kdpendidikan) as kode,a.nip,b.nmlengkap from sc_hrd.pendidikan a
													left outer join sc_hrd.pegawai b on a.nip=b.nip
													group by a.nip,b.nmlengkap) as t1
													left outer join sc_hrd.gradependidikan c on t1.kode=c.kdpendidikan
												) as f on a.nip=f.nip
										where a.kdcabang $kantor1 and (to_char(masukkerja,'YYYYMM')='$periode'  or to_char(keluarkerja,'YYYYMM')='$periode') 

									union all
									select '1' as urut,desc_cabang,null,null,null,null,null,null,null,null,null,null,null
									from sc_mst.kantor
									where kodecabang $kantor1
									union all
									select '1A.MASUK' as urut,desc_cabang,null,null,null,null,null,null,null,null,null,null,null
									from sc_mst.kantor
									where kodecabang $kantor1
									union all
									select '2A.KELUAR' as urut,desc_cabang,null,null,null,null,null,null,null,null,null,null,null
									from sc_mst.kantor
									where kodecabang $kantor1
									union all 
									select '1' as urut,'TOTAL TURN OVER' as desc_cabang,null,null,null,null,null,null,null,null,null,null,null
									union all
									select '3' as urut,null,null,'TOTAL PEGAWAI MASUK' as nmlengkap, inkar,null,null,null,null,null,null,null,null
									from 
									(select cast(count(nip) as char(2)) as inkar
									from sc_hrd.pegawai 
									where to_char(masukkerja,'YYYYMM')='$periode' and kdcabang $kantor1) as t1
									union all
									select '4' as urut,null,null,'TOTAL PEGAWAI KELUAR' as nmlengkap, outkar,null,null,null,null,null,null,null,null
									from 
									(select cast(count(nip) as char(2)) as outkar
									from sc_hrd.pegawai 
									where to_char(keluarkerja,'YYYYMM')='$periode' and kdcabang $kantor1) as t1
									order by desc_cabang,urut asc
																			");
	}	
	
	function q_att(){
		return $this->db->query("select c.departement,
								a.kdatt from sc_hrd.attlog a
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.departement c on b.kddept=c.kddept");
	}

	function q_detail_attendance(){
		return $this->db->query("select a.nmlengkap,a.nip,b.deskripsi,c.deskripsi,d.ijin,d.terlambat,e.tgl,e.kdatt,f.desc_att,g.jmlcuti from sc_hrd.pegawai a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								left outer join sc_hrd.jabatan c on a.kdjabatan=c.kdjabatan
								left outer join sc_hrd.absensi d on a.nip=d.nip
								left outer join sc_hrd.attlog e on a.nip=e.nip
								left outer join sc_hrd.kodeatt f on e.kdatt=f.kdatt
								left outer join sc_hrd.cuti g on a.nip=g.nip
								order by nmlengkap asc");
	}
	
	function q_kar_slskontrak($tahun,$bulan){
		return $this->db->query("select t2.nmlengkap,t1.* from (
								select to_char(tanggal2,'dd-mm-yyyy') as tgl,b.desc_kontrak,a.* from sc_hrd.kontrak a
								left outer join sc_hrd.ketkontrak b on a.kdkontrak=b.kdkontrak  
								where a.kdkontrak='AB' or a.kdkontrak='AC') as t1
								left outer join sc_hrd.pegawai t2 on t1.nip=t2.nip
								where to_char(tanggal2,'mmyyyy')='$bulan$tahun'
								order by tanggal2,nmlengkap asc");
	}
	
	function q_lap_pemakaianatk(){
		return $this->db->query("select a.nmbarang,b.departement,a.qty,a.total from sc_hrd.atk a
								left outer join sc_hrd.departement b on a.kddept=b.kddept");
	}
	
	function q_stock_atk(){
		return $this->db->query("select nmbarang,stokawal,stokakhir from sc_hrd.atk");
	}
	
	function q_mtc_cost(){
		return $this->db->query("select a.no_pol,a.tipe,a.userkend,b.tglservis,c.tglrsk from sc_hrd.invkendaraan a
								left outer join sc_hrd.inv_servisrutin b on a.kdkend=b.kdkend
								left outer join sc_hrd.inv_servisrsk c on a.kdkend=c.kdkend
								order by tglservis");
	}
	
	function q_late_rpt_old($periode){
		return $this->db->query("select * from 
								(select b.nama,t2.*,cast(to_char(durasi_terlambat,'HH24') as integer) || ' Jam ' || cast(to_char(durasi_terlambat,'mi') as integer)|| ' Menit'  as durasi_keterlambatan 
								from (select badgenumber,checkdate,absen,cast(absen-'08:00:00' as time)as durasi_terlambat 
								from (select badgenumber,checkdate,min(checktime) as absen, 
								case when checktime>'08:00:00' and checktype='IN' then 'TERLAMBAT'
								else 'TIDAK TERLAMBAT' 
								end as keterangan from sc_hrd.transready 
								where to_char(checkdate,'YYYYMM')='$periode' and checktype='IN'
								group by badgenumber,checkdate,checktime,checktype) as t1
								where t1.keterangan='TERLAMBAT') as t2
								left outer join sc_hrd.user_finger b on t2.badgenumber=b.id
								order by nama,checkdate) as t3
								");
	
	}
	
	function q_late_report_new($periode,$kantor){
			return $this->db->query("select kode,nik,nmlengkap,tgl,jam_masuk,jam_masuk_absen,total_terlambat,nodok_ref from (
										select 'A' as kode,a.badgenumber,a.nik,b.nmlengkap,a.tgl,a.kdjamkerja,a.shiftke,a.jam_masuk,
											a.jam_masuk_absen,a.jam_pulang,a.jam_pulang_absen,to_char(a.jam_masuk_absen-a.jam_masuk,'hh24:mi:ss') as total_terlambat,
											case when tc.nodok is not null  then tc.nodok
											when td.nodok is not null then td.nodok
											end as nodok_ref
											from sc_trx.transready a 
											left outer join sc_mst.karyawan b on a.nik=b.nik
											left outer join sc_trx.ijin_karyawan tc on tc.nik=a.nik and tc.tgl_kerja=a.tgl and tc.status='P' and tc.type_ijin='DN'
											left outer join sc_trx.dinas td on td.nik=a.nik and (a.tgl between td.tgl_mulai and td.tgl_selesai) and td.status='P'
											where jam_masuk<=jam_masuk_absen and jam_masuk_absen is not null and to_char(jam_masuk_absen,'hh24:m1:ss')<='13:01:01' 
											and to_char(a.tgl,'YYYYmm')='$periode' and b.kdcabang='$kantor'
										union all
										select 'B' as kode,a.badgenumber,'TOTAL TERLAMBAT',b.nmlengkap,null as tgl, null as kdjamkerja,null as shiftke,null as jam_masuk,null as jam_masuk_absen,null as jam_pulang,null as jam_pulang_absen,cast(count(a.nik) as character) as total_terlambat,
											null as nodok_ref
											from sc_trx.transready a 
											left outer join sc_mst.karyawan b on a.nik=b.nik
											left outer join sc_trx.ijin_karyawan tc on tc.nik=a.nik and tc.tgl_kerja=a.tgl and tc.status='P' and tc.type_ijin='DN'
											left outer join sc_trx.dinas td on td.nik=a.nik and (a.tgl between td.tgl_mulai and td.tgl_selesai) and td.status='P'
											where jam_masuk<=jam_masuk_absen and jam_masuk_absen is not null and to_char(jam_masuk_absen,'hh24:m1:ss')<='13:01:01' 
											and to_char(a.tgl,'YYYYmm')='$periode' and b.kdcabang='$kantor'
											group by a.badgenumber,a.nik,b.nmlengkap ) as x1
										order by nmlengkap,kode,tgl");
	
	
	}
	
	function q_ijin_report_old($periode){
		return $this->db->query("select a.kdijin||':'||to_char(a.tglijin,'yymm')||a.id as nodok,a.*,b.nmlengkap,c.desc_kdatt,d.deskripsi,to_char(tglijin,'dd-mm-yyyy') as tgl,e.departement 
								from sc_hrd.ijin a
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.kodeatt c on c.kdatt=a.kdijin
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan
								left outer join sc_hrd.departement e on e.kddept=b.kddept
								where to_char(tglijin,'YYYYMM')='$periode'
								order by nmlengkap,tglijin 

								");
	
	
	}
	
	function q_ijin_report($periode){
		return $this->db->query("select * from (
									select 'A' as kode,0 as total,nodok,a.nik,a.tgl_jam_mulai,a.tgl_jam_selesai,a.keterangan,
									b.nmlengkap,d.nmijin_absensi,to_char(tgl_kerja,'dd-mm-yyyy') as tgl_kerja,c.nmdept
									from sc_trx.ijin_karyawan a
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									left outer join sc_mst.ijin_absensi d on a.kdijin_absensi=d.kdijin_absensi
									where to_char(tgl_kerja,'YYYYMM')='$periode'	
									union all 
									select 'B' as kode,COUNT(a.NIK) as total,'TOTAL IJIN : ' AS nodok,a.nik,null as tgl_jam_mulai,null as tgl_jam_selesai,null as keterangan,
									b.nmlengkap,null as nmijin_absensi,null as tgl_kerja,null as nmdept
									from sc_trx.ijin_karyawan a
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									left outer join sc_mst.ijin_absensi d on a.kdijin_absensi=d.kdijin_absensi
									where to_char(tgl_kerja,'YYYYMM')='$periode'
									group by a.nik,b.nmlengkap) as t1
									order by nmlengkap,kode
	");
	
	
	}
	
	function q_cuti_report($periode){
		return $this->db->query("select * from (
		select a.nik,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmregu,f.nmjabatan,b.grouppenggajian,b.tglmasukkerja,a.nodok,
		case when trim(a.tpcuti)='A'  and trim(a.status_ptg)='A1' then 'CUTI'
			when trim(a.tpcuti)='A'  and trim(a.status_ptg)='A2' then 'CUTI POTONG GAJI'
			when trim(a.tpcuti)='B' then 'CUTI KHUSUS'
			when trim(a.tpcuti)='C' then 'CUTI DINAS'
		end as tpcuti,
		g.nmijin_khusus,a.tgl_mulai,a.tgl_selesai,a.keterangan,a.jumlah_cuti,coalesce(b.sisacuti,0) as sisacuti
		from sc_trx.cuti_karyawan a 
		left outer join sc_mst.karyawan b 
			on a.nik=b.nik
		left outer join sc_mst.departmen c 
			on a.kddept=c.kddept
		left outer join sc_mst.subdepartmen d 
			on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
			left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on a.nik=e.nik
		left outer join sc_mst.jabatan f 
			on a.kdjabatan=f.kdjabatan  and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
		left outer join sc_mst.ijin_khusus g 
			on a.kdijin_khusus=g.kdijin_khusus
		where coalesce(upper(b.statuskepegawaian),'')!='KO' and to_char(a.tgl_mulai,'YYYYMM')='$periode' and a.status='P'

		UNION ALL

		select a.nik,g.nmlengkap,c.nmdept,d.nmsubdept,e.nmregu,f.nmjabatan,g.grouppenggajian,g.tglmasukkerja,a.no_dokumen as nodok,
		case when a.no_dokumen like '%CB%' then 'CUTI BERSAMA'
		when a.no_dokumen like '%ADJ%' then 'ADJUSTMEN CUTI'
		end as tpcuti,
		'' as nmijin_khusus,b.tgl_awal as tgl_mulai,b.tgl_akhir as tgl_selesai,b.keterangan,a.out_cuti as jumlah_cuti,a.sisacuti
		from sc_trx.cuti_blc a
		left outer join sc_trx.cutibersama b on a.no_dokumen=b.nodok
		left outer join sc_mst.karyawan g on a.nik=g.nik
		left outer join sc_mst.departmen c 
			on g.bag_dept=c.kddept
		left outer join sc_mst.subdepartmen d 
			on g.subbag_dept=d.kdsubdept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
			left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on g.nik=e.nik
		left outer join sc_mst.jabatan f 
			on g.jabatan=f.kdjabatan
		where coalesce(upper(g.statuskepegawaian),'')!='KO' and a.no_dokumen like '%CB%' and a.status='F'
		and to_char(b.tgl_awal,'YYYYMM')='$periode'
	) as x1
	order by nik asc	
								");
	
	}
	
	function q_ijin_report_excel($periode){
		return $this->db->query("select *,case when kode='B' then 'TOTAL IJIN :' ||total 
								else nodok 
								end as nodok_new from (
								select * from (
								select 'A' as kode,0 as total,nodok,a.nik,a.tgl_jam_mulai,a.tgl_jam_selesai,a.keterangan,
								b.nmlengkap,d.nmijin_absensi,to_char(tgl_kerja,'dd-mm-yyyy') as tgl_kerja,c.nmdept
								from sc_trx.ijin_karyawan a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept
								left outer join sc_mst.ijin_absensi d on a.kdijin_absensi=d.kdijin_absensi
								where to_char(tgl_kerja,'YYYYMM')='$periode'	
								union all 
								select 'B' as kode,COUNT(a.NIK) as total,'TOTAL IJIN : ' AS nodok,a.nik,null as tgl_jam_mulai,null as tgl_jam_selesai,null as keterangan,
								b.nmlengkap,null as nmijin_absensi,null as tgl_kerja,null as nmdept
								from sc_trx.ijin_karyawan a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept
								left outer join sc_mst.ijin_absensi d on a.kdijin_absensi=d.kdijin_absensi
								where to_char(tgl_kerja,'YYYYMM')='$periode'
								group by a.nik,b.nmlengkap) as t1
								order by nmlengkap,kode) as t2
								order by nmlengkap,kode
								");
	
	}
	
	function q_cuti_report_excel($periode){
		return $this->db->query("select *,case when kode='B' then 'JUMLAH CUTI :'||cast(total as character)
								else cast(jmlcuti as character)
								end as jmlcuti_new from (
										select 'A' as kode,0 as total,b.nmlengkap,a.nip,a.nodokumen,to_char(a.tglmulai,'DD-MM-YYYY') as tglmulai,to_char(a.tglahir,'DD-MM-YYYY') as tglahir,a.jmlcuti,a.keterangan from sc_hrd.cuti a 
										left outer join sc_hrd.pegawai b on a.nip=b.nip 
										where to_char(tglmulai,'YYYYMM')='$periode' and a.status<>'C' and a.status<>'B'
										union all
										select 'B' as kode,sum(a.jmlcuti) as total,b.nmlengkap,a.nip,null as nodokumen,null as tglmulai,null as tglahir,null as jmlcuti,null as keterangan from sc_hrd.cuti a 
										left outer join sc_hrd.pegawai b on a.nip=b.nip 
										where to_char(tglmulai,'YYYYMM')='$periode' and a.status<>'C' and a.status<>'B'
										group by a.nip,b.nmlengkap) as t1 
								order by nmlengkap,kode");
	
	}
	
	function q_att_new($periode){
		return $this->db->query("SELECT x.nik AS nik,x.nmlengkap,x.nmdept,x.nmsubdept,x.nmregu,x.nmjabatan,x.grouppenggajian,x.tglmasukkerja, sum(x.jumlah_jadwal) AS jumlah_jadwal , 
sum(x.jumlah_cuti) AS cuti ,  sum(x.izin_dt) AS izin_dt , sum(x.Cuti_ptggaji) AS cuti_ptggaji, sum(x.cuti_khusus) AS cuti_khusus, sum(x.izin_pa) AS izin_pa,
sum(x.dinas) as dinas, sum(x.izin_keluar ) as izin_keluar , sum(x.dt) as dt, sum(x.pa) as pa, sum(x.padt) as padt, sum(x.alpha) as Alpha,sum(x.izin_sakit) as izin_sakit,
sum(x.cuti_bersama) as cuti_bersama, sum(x.jumlah_cuti) AS cuti_terpakai, sum (x.sisa_cuti) AS sisa_cuti
FROM (
	/*JADWAL KERJA*/
	SELECT a.nik AS nik,a.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,a.grouppenggajian,a.tglmasukkerja, count(d.id) AS jumlah_jadwal , 
	0 AS jumlah_cuti ,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan a
	left outer join sc_trx.dtljadwalkerja d on a.nik=d.nik
	left outer join sc_mst.departmen b on a.bag_dept=b.kddept
	left outer join
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on a.nik=e.nik
	left outer join sc_mst.subdepartmen c on a.bag_dept=c.kddept and a.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on a.bag_dept=f.kddept and a.subbag_dept=f.kdsubdept and a.jabatan=f.kdjabatan
	WHERE to_char(d.tgl, 'YYYYMM') = '$periode' and a.statuskepegawaian not in ('KO') and a.grouppenggajian not in ('P0')
	GROUP BY a.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,a.tglmasukkerja
	
	UNION ALL

	/*CUTI POTONG CUTI*/
	SELECT k.nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	sum(ck.jumlah) AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join 
		(select a.nik,a.tgl_mulai,a.tgl_selesai,a.status,a.status_ptg,a.tpcuti,count(*) as jumlah from sc_trx.cuti_karyawan a
		left outer join sc_trx.dtljadwalkerja b on a.nik=b.nik and kdjamkerja<>'OFF' and b.tgl>=a.tgl_mulai and b.tgl<=a.tgl_selesai 
		where to_char(b.tgl,'YYYYMM')='$periode'
		group by a.nik,a.nodok) ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join 
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE k.statuskepegawaian not in ('KO') and to_char(ck.tgl_mulai,'YYYYMM')='$periode' and k.grouppenggajian not in ('P0')
	AND ck.status = 'P' and ck.status_ptg='A1' and ck.tpcuti='A' 
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja
	
	UNION ALL

	/*IZIN DATANG TERLAMBAT PRIBADI DENGAN DOKUMEN IZIN*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  count(ck.nodok) AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join sc_trx.ijin_karyawan ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join 
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE ck.kdijin_absensi = 'DT' and to_char(ck.tgl_kerja, 'YYYYMM') = '$periode' and k.statuskepegawaian not in ('KO')
	AND ck.status = 'P' and ck.type_ijin='PB' and k.grouppenggajian not in ('P0')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja
	
	UNION ALL

	/*CUTI POTONG GAJI*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, sum(ck.jumlah_cuti) as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join sc_trx.cuti_karyawan ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join 
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE ck.tpcuti = 'A' and to_char(ck.tgl_mulai, 'YYYYMM') = '$periode' and k.statuskepegawaian not in ('KO')
	AND ck.status = 'P' and ck.status_ptg='A2' and k.grouppenggajian not in ('P0')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja

	UNION ALL

	/*CUTI KHUSUS*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,sum(ck.jumlah_cuti) as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join sc_trx.cuti_karyawan ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join 
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE ck.tpcuti = 'B' and ck.kdijin_khusus != 'AG' and to_char(ck.tgl_mulai, 'YYYYMM') = '$periode'
	AND ck.status = 'P' and k.grouppenggajian not in ('P0') and k.statuskepegawaian not in ('KO')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja

	UNION ALL
	
	/*IZIN PULANG AWAL PRIBADI DENGAN DOKUMEN*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, count(ck.nodok) AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join sc_trx.ijin_karyawan ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join 
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE ck.kdijin_absensi = 'PA' and to_char(ck.tgl_kerja, 'YYYYMM') = '$periode' and k.statuskepegawaian not in ('KO')
	AND ck.status = 'P' and ck.type_ijin='PB' and k.grouppenggajian not in ('P0')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja

	UNION ALL
	
	/*DINAS*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa,sum(ck.jumlah) as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join
	(select a.nik,a.tgl_mulai,a.tgl_selesai,a.status,count(*) as jumlah from sc_trx.dinas a
		left outer join sc_trx.dtljadwalkerja b on a.nik=b.nik and kdjamkerja<>'OFF' and b.tgl>=a.tgl_mulai and b.tgl<=a.tgl_selesai 
		where to_char(b.tgl,'YYYYMM')='$periode' --and a.nik='22076'
		group by a.nik,a.nodok) ck ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE k.statuskepegawaian not in ('KO') and to_char(ck.tgl_mulai,'YYYYMM')='$periode'
	AND ck.status = 'P' and k.grouppenggajian not in ('P0')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja

	UNION ALL
	/*IZIN KELUAR PRIBADI DENGAN DOKUMEN*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa,0 as dinas, count(ck.nodok) as izin_keluar, 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join sc_trx.ijin_karyawan ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE to_char(ck.tgl_kerja, 'YYYYMM') = '$periode' and k.statuskepegawaian not in ('KO')
	AND ck.status = 'P' and ck.kdijin_absensi='IK' and ck.type_ijin='PB' and k.grouppenggajian not in ('P0')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.tglmasukkerja

	UNION ALL

	/*DATANG TERLAMBAT TANPA DOKUMEN IZIN*/
	SELECT j.nik AS nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa,0 as dinas,0 as izin_keluar, sum(j.hasil) as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	from
		(select a.nik,a.tgl,a.nmlengkap,a.nmdept,a.nmsubdept,a.nmregu,a.nmjabatan,a.grouppenggajian,a.tglmasukkerja,d.kdijin_absensi,d.nodok,e.nodok,f.nodok as ikd,a.docref,
		case when d.kdijin_absensi is null and d.nodok is null and e.nodok is null and f.nodok is null and a.docref='DT' then 1
		when d.kdijin_absensi not in ('DT') and d.nodok is not null and e.nodok is null and f.nodok is null and a.docref='DT' then 1
		else 0 end as hasil
		from 
		(select b.nik,a.tgl,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmregu,b.nmjabatan,b.grouppenggajian,b.tglmasukkerja,
	case when a.jam_masuk_absen > c.jam_masuk and a.jam_pulang_absen >=c.jam_pulang then 'DT'
	when a.jam_masuk_absen <= c.jam_masuk and a.jam_pulang_absen < c.jam_pulang then 'PA'
	when a.jam_masuk_absen > c.jam_masuk and a.jam_pulang_absen < c.jam_pulang then 'PADT'
	end as docref
	from sc_trx.transready a
	left outer join
		(select k.nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja
		FROM sc_mst.karyawan k
		left outer join sc_mst.departmen b on k.bag_dept=b.kddept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
		left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
		left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
		where k.statuskepegawaian not in ('KO') and k.grouppenggajian not in ('P0'))
	b on a.nik=b.nik
	left outer join sc_mst.jam_kerja c on c.kdjam_kerja=a.kdjamkerja
	where to_char(a.tgl,'YYYYMM')='$periode'
	group by b.nik,a.tgl,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmregu,b.nmjabatan,b.grouppenggajian,b.tglmasukkerja,
	a.jam_masuk_absen,c.jam_masuk,a.jam_pulang_absen,c.jam_pulang
	order by nik,tgl) as a
	left outer join sc_trx.ijin_karyawan d on d.nik=a.nik and a.tgl=d.tgl_kerja and d.status='P'
	left outer join sc_trx.dinas e on e.nik=a.nik and a.tgl>=e.tgl_mulai and a.tgl<=e.tgl_selesai and d.status='P'
	left outer join (SELECT a_2.nik,
                            a_2.nodok,
                            a_2.tgl_kerja,
                            a_2.tgl_jam_mulai,
                            a_2.tgl_jam_selesai,
                            a_2.durasi,
                            a_2.keterangan,
                            a_2.type_ijin,
                            a_2.status,
                            a_2.input_by,
                            a_2.input_date,
                            a_2.approval_by,
                            a_2.approval_date,
                                CASE
                                    WHEN a_2.tgl_jam_mulai <= c_1.jam_masuk AND a_2.tgl_jam_selesai >= c_1.jam_pulang THEN 'IKD'::text
                                    ELSE NULL::text
                                END AS kdpokok
                           FROM sc_trx.ijin_karyawan a_2
                             LEFT JOIN sc_trx.dtljadwalkerja b_1_1 ON a_2.nik = b_1_1.nik AND a_2.tgl_kerja = b_1_1.tgl
                             LEFT JOIN sc_mst.jam_kerja c_1 ON b_1_1.kdjamkerja = c_1.kdjam_kerja
                          WHERE a_2.type_ijin = 'DN'::bpchar AND a_2.status = 'P'::bpchar) f ON a.nik = f.nik AND a.tgl = f.tgl_kerja AND f.kdpokok IS NOT NULL
	group by a.nik,a.tgl,a.nmlengkap,a.nmdept,a.nmsubdept,a.nmregu,a.nmjabatan,a.grouppenggajian,a.tglmasukkerja,a.docref,d.kdijin_absensi,d.nodok,e.nodok,f.nodok
	) as j
	group by j.nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja
	
	
	UNION ALL

	/*PULANG AWAL TANPA DOKUMEN IZIN*/
	SELECT j.nik AS nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa,0 as dinas,0 as izin_keluar,0 as dt,
	 sum(j.hasil) as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	from
		(select a.nik,a.tgl,a.nmlengkap,a.nmdept,a.nmsubdept,a.nmregu,a.nmjabatan,a.grouppenggajian,a.tglmasukkerja,d.kdijin_absensi,d.nodok,e.nodok,f.nodok as ikd,a.docref,
		case when d.kdijin_absensi is null and d.nodok is null and e.nodok is null and f.nodok is null and a.docref='PA' then 1
		when d.kdijin_absensi not in ('PA') and d.nodok is not null and e.nodok is null and f.nodok is null and a.docref='PA' then 1
		else 0 end as hasil
		from 
		(select b.nik,a.tgl,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmregu,b.nmjabatan,b.grouppenggajian,b.tglmasukkerja,
	case when a.jam_masuk_absen > c.jam_masuk and a.jam_pulang_absen >=c.jam_pulang then 'DT'
	when a.jam_masuk_absen <= c.jam_masuk and a.jam_pulang_absen < c.jam_pulang then 'PA'
	when a.jam_masuk_absen > c.jam_masuk and a.jam_pulang_absen < c.jam_pulang then 'PADT'
	end as docref
	from sc_trx.transready a
	left outer join
		(select k.nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja
		FROM sc_mst.karyawan k
		left outer join sc_mst.departmen b on k.bag_dept=b.kddept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
		left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
		left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
		where k.statuskepegawaian not in ('KO') and k.grouppenggajian not in ('P0'))
	b on a.nik=b.nik
	left outer join sc_mst.jam_kerja c on c.kdjam_kerja=a.kdjamkerja
	where to_char(a.tgl,'YYYYMM')='$periode'
	group by b.nik,a.tgl,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmregu,b.nmjabatan,b.grouppenggajian,b.tglmasukkerja,
	a.jam_masuk_absen,c.jam_masuk,a.jam_pulang_absen,c.jam_pulang
	order by nik,tgl) as a
	left outer join sc_trx.ijin_karyawan d on d.nik=a.nik and a.tgl=d.tgl_kerja and d.status='P'
	left outer join sc_trx.dinas e on e.nik=a.nik and a.tgl>=e.tgl_mulai and a.tgl<=e.tgl_selesai and d.status='P'
	left outer join (SELECT a_2.nik,
                            a_2.nodok,
                            a_2.tgl_kerja,
                            a_2.tgl_jam_mulai,
                            a_2.tgl_jam_selesai,
                            a_2.durasi,
                            a_2.keterangan,
                            a_2.type_ijin,
                            a_2.status,
                            a_2.input_by,
                            a_2.input_date,
                            a_2.approval_by,
                            a_2.approval_date,
                                CASE
                                    WHEN a_2.tgl_jam_mulai <= c_1.jam_masuk AND a_2.tgl_jam_selesai >= c_1.jam_pulang THEN 'IKD'::text
                                    ELSE NULL::text
                                END AS kdpokok
                           FROM sc_trx.ijin_karyawan a_2
                             LEFT JOIN sc_trx.dtljadwalkerja b_1_1 ON a_2.nik = b_1_1.nik AND a_2.tgl_kerja = b_1_1.tgl
                             LEFT JOIN sc_mst.jam_kerja c_1 ON b_1_1.kdjamkerja = c_1.kdjam_kerja
                          WHERE a_2.type_ijin = 'DN'::bpchar AND a_2.status = 'P'::bpchar) f ON a.nik = f.nik AND a.tgl = f.tgl_kerja AND f.kdpokok IS NOT NULL
	group by a.nik,a.tgl,a.nmlengkap,a.nmdept,a.nmsubdept,a.nmregu,a.nmjabatan,a.grouppenggajian,a.tglmasukkerja,a.docref,d.kdijin_absensi,d.nodok,e.nodok,f.nodok
	) as j
	group by j.nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja
	

	UNION ALL

	/*PULANG AWAL DAN DATANG TERLAMBAT TANPA DOKUMEN IZIN*/
	SELECT j.nik AS nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa,0 as dinas,0 as izin_keluar,0 as dt,
	 0 as pa, sum(j.hasil) as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	from
		(select a.nik,a.tgl,a.nmlengkap,a.nmdept,a.nmsubdept,a.nmregu,a.nmjabatan,a.grouppenggajian,a.tglmasukkerja,d.kdijin_absensi,d.nodok,e.nodok,f.nodok as ikd,a.docref,
		case when d.kdijin_absensi is null and d.nodok is null and e.nodok is null and f.nodok is null and a.docref='PADT' then 1
		when d.kdijin_absensi not in ('PA','DT') and d.nodok is not null and e.nodok is null and f.nodok is null and a.docref='PADT' then 1
		else 0 end as hasil
		from 
		(select b.nik,a.tgl,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmregu,b.nmjabatan,b.grouppenggajian,b.tglmasukkerja,
	case when a.jam_masuk_absen > c.jam_masuk and a.jam_pulang_absen >=c.jam_pulang then 'DT'
	when a.jam_masuk_absen <= c.jam_masuk and a.jam_pulang_absen < c.jam_pulang then 'PA'
	when a.jam_masuk_absen > c.jam_masuk and a.jam_pulang_absen < c.jam_pulang then 'PADT'
	end as docref
	from sc_trx.transready a
	left outer join
		(select k.nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja
		FROM sc_mst.karyawan k
		left outer join sc_mst.departmen b on k.bag_dept=b.kddept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
		left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
		left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
		where k.statuskepegawaian not in ('KO') and k.grouppenggajian not in ('P0'))
	b on a.nik=b.nik
	left outer join sc_mst.jam_kerja c on c.kdjam_kerja=a.kdjamkerja
	where to_char(a.tgl,'YYYYMM')='$periode'
	group by b.nik,a.tgl,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmregu,b.nmjabatan,b.grouppenggajian,b.tglmasukkerja,
	a.jam_masuk_absen,c.jam_masuk,a.jam_pulang_absen,c.jam_pulang
	order by nik,tgl) as a
	left outer join sc_trx.ijin_karyawan d on d.nik=a.nik and a.tgl=d.tgl_kerja and d.status='P'
	left outer join sc_trx.dinas e on e.nik=a.nik and a.tgl>=e.tgl_mulai and a.tgl<=e.tgl_selesai and d.status='P'
	left outer join (SELECT a_2.nik,
                            a_2.nodok,
                            a_2.tgl_kerja,
                            a_2.tgl_jam_mulai,
                            a_2.tgl_jam_selesai,
                            a_2.durasi,
                            a_2.keterangan,
                            a_2.type_ijin,
                            a_2.status,
                            a_2.input_by,
                            a_2.input_date,
                            a_2.approval_by,
                            a_2.approval_date,
                                CASE
                                    WHEN a_2.tgl_jam_mulai <= c_1.jam_masuk AND a_2.tgl_jam_selesai >= c_1.jam_pulang THEN 'IKD'::text
                                    ELSE NULL::text
                                END AS kdpokok
                           FROM sc_trx.ijin_karyawan a_2
                             LEFT JOIN sc_trx.dtljadwalkerja b_1_1 ON a_2.nik = b_1_1.nik AND a_2.tgl_kerja = b_1_1.tgl
                             LEFT JOIN sc_mst.jam_kerja c_1 ON b_1_1.kdjamkerja = c_1.kdjam_kerja
                          WHERE a_2.type_ijin = 'DN'::bpchar AND a_2.status = 'P'::bpchar) f ON a.nik = f.nik AND a.tgl = f.tgl_kerja AND f.kdpokok IS NOT NULL
	group by a.nik,a.tgl,a.nmlengkap,a.nmdept,a.nmsubdept,a.nmregu,a.nmjabatan,a.grouppenggajian,a.tglmasukkerja,a.docref,d.kdijin_absensi,d.nodok,e.nodok,f.nodok
	) as j
	group by j.nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja
	
	
	UNION ALL

	/*Sisa Cuti*/
	SELECT j.nik AS nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus,0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,sum(j.sisacuti) as sisa_cuti, 0 as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM 
	(select k.nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja,(select sisacuti from sc_trx.cuti_blc b where b.nik=k.nik and to_char(b.tanggal,'YYYYMM')<='$periode' order by b.tanggal desc limit 1) as sisacuti,
	(select tanggal from sc_trx.cuti_blc b where b.nik=k.nik and to_char(b.tanggal,'YYYYMM')<='$periode' order by b.tanggal desc limit 1) as tanggal
	from sc_mst.karyawan k
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE k.statuskepegawaian not in ('KO') and k.grouppenggajian not in ('P0')
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja) as j where j.nik is not null
	group by j.nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja
	
	UNION ALL
	
	/*ALPHA*/
		SELECT j.nik AS nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa,0 as dinas,0 as izin_keluar, 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti, sum(j.docref) as alpha,0 AS izin_sakit, 0 as cuti_bersama
	FROM
	(select trim(e.nik) as nik,e.nmlengkap,e.nmdept,e.nmsubdept,e.nmregu,e.nmjabatan,e.grouppenggajian,e.tglmasukkerja,a.kdjamkerja,a.jam_masuk_absen,a.jam_pulang_absen,a.tgl,
	b.nodok as cuti,c.nodok as dinas, d.nodok as izin_sakit,
	case when a.kdjamkerja<>'' and to_char(a.jam_masuk_absen,'HH24:MI:SS') is null and to_char(a.jam_pulang_absen,'HH24:MI:SS') is null
	and b.nodok is null and c.nodok is null and d.nodok is null then 1
	else 0 end as docref
	from sc_trx.transready a
	left outer join sc_trx.cuti_karyawan b on a.nik=b.nik and b.status='P' and a.tgl::DATE >= b.tgl_mulai::DATE and a.tgl::DATE<=b.tgl_selesai::DATE
	left outer join sc_trx.dinas c on a.nik=c.nik and c.status='P' and a.tgl::DATE>=c.tgl_mulai::DATE and a.tgl::DATE<=c.tgl_selesai::DATE 
	left outer join sc_trx.ijin_karyawan d on a.nik=d.nik and d.status='P' and a.tgl::DATE=d.tgl_kerja::DATE
	left outer join 
	(select k.nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja,k.statuskepegawaian
		FROM sc_mst.karyawan k
		left outer join sc_mst.departmen b on k.bag_dept=b.kddept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
		left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
		left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
		)
	e on a.nik=e.nik
	where to_char(a.tgl,'YYYYMM')='202302' and a.kdjamkerja<>'' and e.statuskepegawaian<>'KO' and e.grouppenggajian<>'P0' and a.nik='0522.504'
	group by e.nik,e.nmlengkap,e.nmdept,e.nmsubdept,e.nmregu,e.nmjabatan,e.grouppenggajian,e.tglmasukkerja,a.kdjamkerja,a.jam_masuk_absen,a.jam_pulang_absen,a.tgl,b.nodok,c.nodok,a.tgl,d.nodok
	order by nik) as j where j.nik is not null and docref=1
	group by j.nik,j.nmlengkap,j.nmdept,j.nmsubdept,j.nmregu,j.nmjabatan,j.grouppenggajian,j.tglmasukkerja

	
	
	UNION ALL
	
	/*IZIN SAKIT KARYAWAN*/
	SELECT k.nik AS nik,k.nmlengkap,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,count(ck.nodok) AS izin_sakit, 0 as cuti_bersama
	FROM sc_mst.karyawan k
	left outer join sc_trx.ijin_karyawan ck  ON k.nik = ck.nik
	left outer join sc_mst.departmen b on k.bag_dept=b.kddept
	left outer join
		(select a.nik,b.nmregu from sc_mst.regu_opr a
		left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on k.nik=e.nik
	left outer join sc_mst.subdepartmen c on k.bag_dept=c.kddept and k.subbag_dept=c.kdsubdept
	left outer join sc_mst.jabatan f on k.bag_dept=f.kddept and k.subbag_dept=f.kdsubdept and k.jabatan=f.kdjabatan
	WHERE to_char(ck.tgl_kerja, 'YYYYMM') = '$periode' and k.statuskepegawaian not in ('KO') and ck.kdijin_absensi='KD'
	AND ck.status = 'P'
	GROUP BY k.nik,b.nmdept,c.nmsubdept,e.nmregu,f.nmjabatan,k.grouppenggajian,k.tglmasukkerja
	
	UNION ALL
	
	/*CUTI BERSAMA*/
	select a.nik,g.nmlengkap,c.nmdept,d.nmsubdept,e.nmregu,f.nmjabatan,g.grouppenggajian,g.tglmasukkerja, 0 AS jumlah_jadwal , 
	0 AS jumlah_cuti,  0 AS izin_dt, 0 as Cuti_ptggaji,0 as cuti_khusus, 0 AS izin_pa, 0 as dinas, 0 as izin_keluar , 0 as dt,
	0 as pa, 0 as padt,0 as sisa_cuti,0 as alpha,0 AS izin_sakit, sum(a.out_cuti) as cuti_bersama
		from sc_trx.cuti_blc a
		left outer join sc_trx.cutibersama b on a.no_dokumen=b.nodok
		left outer join sc_mst.karyawan g on a.nik=g.nik
		left outer join sc_mst.departmen c 
			on g.bag_dept=c.kddept
		left outer join sc_mst.subdepartmen d 
			on g.subbag_dept=d.kdsubdept
		left outer join
			(select a.nik,b.nmregu from sc_mst.regu_opr a
			left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on g.nik=e.nik
		left outer join sc_mst.jabatan f 
			on g.jabatan=f.kdjabatan
		where coalesce(upper(g.statuskepegawaian),'')!='KO' and a.no_dokumen like '%CB%' and a.status='F'
		and to_char(b.tgl_awal,'YYYYMM')='$periode' and g.grouppenggajian not in ('P0')
	group by a.nik,g.nmlengkap,c.nmdept,d.nmsubdept,e.nmregu,f.nmjabatan,g.grouppenggajian,g.tglmasukkerja
	) AS x 
where nmdept<>'DIREKSI'
GROUP BY x.nik,x.nmlengkap,x.nmdept,x.nmsubdept,x.nmregu,x.nmjabatan,x.grouppenggajian,x.tglmasukkerja
order by x.nik
	");

	}
	
	function q_generate_absensi($periode){
		$txt='select sc_tmp.generate_reportabsensi('.chr(39).$periode.chr(39).')';
		return $this->db->query($txt);
		
	
	
	}
	
	function q_turnover_excel($periode,$kantor){
		if ($kantor<>'NAS'){
			$kantor1="= '$kantor'";
		
		} else {
			$kantor1=" is not null";
		
		}
		return $this->db->query("select 
									case when to_char(masukkerja,'YYYYMM')='$periode' then '1A.MASUK' else '1B.KELUAR' end as urut,
									e.desc_cabang, row_number() over (order by desc_cabang,nmlengkap) as nomor,
									a.nmlengkap,a.nip,b.departement,c.subdepartement,d.deskripsi,TO_CHAR(a.masukkerja, 'dd-mm-YYYY') as masuk,to_char(a.keluarkerja,'dd-mm-yyyy') as keluar,f.desc_pendidikan,a.alamat,age(a.tgllahir) as usia,
									case when to_char(masukkerja,'YYYYMM')='$periode' then 'MASUK' else 'KELUAR' end as status 
									from sc_hrd.pegawai a
									left outer join sc_hrd.departement b on a.kddept=b.kddept
									left outer join sc_hrd.subdepartement c on a.kdsubdept=c.kdsubdept and a.kddept=c.kddept
									left outer join sc_hrd.jabatan d on a.kddept=d.kddept and a.kdsubdept=d.kdsubdept and a.kdjabatan=d.kdjabatan
									left outer join sc_mst.kantor e on a.kdcabang=e.kodecabang
									left outer join (select nip,desc_pendidikan from 
												(select max(a.kdpendidikan) as kode,a.nip,b.nmlengkap from sc_hrd.pendidikan a
												left outer join sc_hrd.pegawai b on a.nip=b.nip
												group by a.nip,b.nmlengkap) as t1
												left outer join sc_hrd.gradependidikan c on t1.kode=c.kdpendidikan
											) as f on a.nip=f.nip
									where a.kdcabang $kantor1 and (to_char(masukkerja,'YYYYMM')='$periode' or to_char(keluarkerja,'YYYYMM')='$periode') 
							union all 
							select '2' as urut,'TOTAL KARYAWAN MASUK' as desc_cabang,null as nomor,cast(count(nip) as char(2)) as nmlengkap,null,null,null,null,null,null,null,null,null,null
							from sc_hrd.pegawai 
							where to_char(masukkerja,'YYYYMM')='$periode' and kdcabang $kantor1	
							union all 
							select '3' as urut,'TOTAL KARYAWAN KELUAR' as desc_cabang,null as nomor,cast(count(nip) as char(2)) as nmlengkap,null,null,null,null,null,null,null,null,null,null
							from sc_hrd.pegawai 
							where to_char(keluarkerja,'YYYYMM')='$periode' and kdcabang $kantor1	
							order by urut,desc_cabang

");
	
	}
	
	function q_lembur_report($periode){
		return $this->db->query("
								select * from
								(select 'A' AS kode,0 as total,a.nodok,a.nik,b.nmlengkap,c.nmdept,to_char(a.tgl_kerja,'DD-MM-YYYY') AS tgl_kerja,to_char(a.tgl_jam_mulai,'HH24:MI:SS') as jammulai,to_char(a.tgl_jam_selesai,'HH24:MI:SS') as jamselesai,a.durasi,a.keterangan from sc_trx.lembur a
																left outer join sc_mst.karyawan b on a.nik=b.nik 
																left outer join sc_mst.departmen c on b.bag_dept=c.kddept
																where to_char(tgl_kerja,'YYYYMM')='$periode' and a.status='P'
																--order by b.nmlengkap
																union all	
								select 'B' AS kode,COUNT(a.NIK) as total,'TOTAL IJIN' AS  nodok,a.nik,b.nmlengkap,NULL AS nmdept, NULL AS tgl_kerja,NULL AS  jammulai,NULL as jamselesai,sum(durasi) AS durasi,NULL AS keterangan from sc_trx.lembur a
																left outer join sc_mst.karyawan b on a.nik=b.nik 
																left outer join sc_mst.departmen c on b.bag_dept=c.kddept
																where to_char(tgl_kerja,'YYYYMM')='$periode' and a.status='P'
																group by a.nik,b.nmlengkap) as t1

								order by nmlengkap,kode	
		");
	
	
	}
	
	function q_lembur_report_excel($periode){
	
		return $this->db->query("select *,case when kode='B' then 'TOTAL IJIN :' ||total 
								else nodok 
								end as nodok_new
								from (
									select * from
									(select 'A' AS kode,0 as total,a.nodok,a.nik,b.nmlengkap,c.nmdept,to_char(a.tgl_kerja,'DD-MM-YYYY') AS tgl_kerja1,to_char(a.tgl_jam_mulai,'HH24:MI:SS') as jammulai,to_char(a.tgl_jam_selesai,'HH24:MI:SS') as jamselesai,a.durasi,a.keterangan from sc_trx.lembur a
									left outer join sc_mst.karyawan b on a.nik=b.nik 
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									where to_char(tgl_kerja,'YYYYMM')='$periode' and a.status='P'
																	--order by b.nmlengkap
																	union all	
									select 'B' AS kode,COUNT(a.NIK) as total,'TOTAL IJIN' AS  nodok,a.nik,b.nmlengkap,NULL AS nmdept, NULL AS tgl_kerja1,NULL AS  jammulai,NULL as jamselesai,sum(durasi) AS durasi,NULL AS keterangan from sc_trx.lembur a
									left outer join sc_mst.karyawan b on a.nik=b.nik 
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									where to_char(tgl_kerja,'YYYYMM')='$periode' and a.status='P'
									group by a.nik,b.nmlengkap) as t1
								order by nmlengkap,kode) as t2
								order by nmlengkap,kode
								");
	
	
	}

    function q_idbu(){
        return $this->db->query("select * from sc_crm.carea order by areaname");
    }

    function q_op($idbu, $tglAwal, $tglAkhir) {
	    $whereIdbu = $whereTglAwal = $whereTglAkhir = $whereThnAwal = $whereThnAkhir = "";
	    if(!is_null($idbu) && $idbu != "") {
	        $whereIdbu = "where x3.area='$idbu'";
        }
        if(!is_null($tglAwal) && $tglAwal != "") {
            $whereTglAwal = "and a.orderdate>='$tglAwal'";
            $whereThnAwal = "and left(orderdate,4)>=left('$tglAwal',4)";
        }
        if(!is_null($tglAkhir) && $tglAkhir != "") {
            $whereTglAkhir = "and a.orderdate<='$tglAkhir'";
            $whereThnAkhir = "and left(orderdate,4)<=left('$tglAkhir',4)";
        }
        return $this->db->query("
            select x3.areaname,x3.nip,x4.nmlengkap,x1.*,x2.orderid,
            case
                when x2.status='F' then 'Faktur/SJ'
                when x2.status='U' then 'Konfirmasi'
                when x2.status='P' then 'Pending(OD/Plafon)'
                when x2.status='A' then 'Perlu Persetujuan'
            else 'NN' end as Status						
            from (
                select a.orderdate,a.userid,count(a.orderid) as jmlorder
                from sc_crm.order a
                where a.status in ('F','U') 
                $whereTglAwal 
                $whereTglAkhir  
                group by a.orderdate,a.userid
            ) as x1
            left outer join (
                select a.orderdate,a.userid,a.orderid,a.status
                from sc_crm.order a
                where a.status in ('F','U')
                $whereTglAwal 
                $whereTglAkhir
            ) as x2 on x1.userid=x2.userid and x1.orderdate=x2.orderdate
            left outer join (
                select x1.*,x2.nip,x2.custarea,x3.area,x3.areaname
                from (
                    select distinct userid
                    from sc_crm.order
                    where 1=1 
                    $whereThnAwal 
                    $whereThnAkhir
                ) as x1
                left outer join sc_crm.user x2 on x1.userid=x2.userid
                left outer join sc_crm.carea x3 on x2.custarea=x3.area
            ) as x3 on x1.userid=x3.userid
            left outer join sc_mst.karyawan x4 on x3.nip = x4.nik
            $whereIdbu
            order by x4.nmlengkap,x1.orderdate,x2.orderid
        ");
    }

function q_remind_cuti(){
        return $this->db->query("select a.nik,nmlengkap,nmdept as bagian,to_char(now(),'DD-MM-YYYY') as tgl,a.keterangan
									from sc_trx.cuti_karyawan a
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									where a.status='P' 
									and to_char(now(),'YYYYMMDD') >= to_char(tgl_mulai,'YYYYMMDD')  
									and to_char(now(),'YYYYMMDD')<= to_char(tgl_selesai,'YYYYMMDD')
									");
    }

    function q_remind_dinas() {
        return $this->db->query("select a.nik,nmlengkap,nmdept as bagian,to_char(now(),'DD-MM-YYYY') as tgl,a.tujuan_kota, k.namakotakab
								from sc_trx.dinas a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept
								left outer join sc_mst.kotakab k on a.tujuan_kota = k.kodekotakab 
								where a.status='P' 
								and to_char(now(),'YYYYMMDD') >= to_char(tgl_mulai,'YYYYMMDD')  
								and to_char(now(),'YYYYMMDD')<= to_char(tgl_selesai,'YYYYMMDD')

								");
    }

    function q_remind_ijin() {
        return $this->db->query("select a.nodok,a.nik,nmlengkap,nmdept as bagian,to_char(now(),'DD-MM-YYYY') as tgl,
								tgl_jam_mulai as jam_awal,tgl_jam_selesai as jam_akhir,
								nmijin_absensi as tipe_ijin,d.uraian as kategori,a.keterangan
								from sc_trx.ijin_karyawan a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept
								left outer join (select * from sc_mst.trxtype where jenistrx='IJIN INPUT') as d on a.type_ijin=d.kdtrx
								left outer join sc_mst.ijin_absensi e on a.kdijin_absensi=e.kdijin_absensi
								where a.status='P' 
								and to_char(now(),'YYYYMMDD') >= to_char(tgl_kerja,'YYYYMMDD')  
								and to_char(now(),'YYYYMMDD')<= to_char(tgl_kerja,'YYYYMMDD')
		");
    }

    function q_remind_lembur() {
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
                                        a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,h.uraian,i.nmlengkap as nmatasan1,
                                        cast(cast(floor(durasi/60.) as integer)as character(12))|| ' Jam '||
                                        cast(cast((durasi-(floor(durasi/60.)*60)) as integer)as character(12))||' Menit' as jam,
                                case when a.jenis_lembur='D1' then 'DI-DURASI ABSEN'
                                when a.jenis_lembur='D2' then 'D2-NON DURASI'
                                else 'UNKNOWN' end as nmjenis_lembur
                                        from sc_trx.lembur a 
                                        left outer join sc_mst.karyawan b on a.nik=b.nik
                                        left outer join sc_mst.departmen c on a.kddept=c.kddept
                                        left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
                                        left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
                                        left outer join sc_mst.jabatan f on b.bag_dept=f.kddept and b.subbag_dept=f.kdsubdept and b.jabatan=f.kdjabatan
                                        left outer join sc_mst.trxtype h on a.kdtrx=h.kdtrx and trim(h.jenistrx)='ALASAN LEMBUR'
                                        left outer join sc_mst.karyawan i on a.nmatasan=i.nik
                                        where a.status='P'
                                            and to_char(now(),'YYYYMMDD') >= to_char(tgl_kerja,'YYYYMMDD')  
                                            and to_char(now(),'YYYYMMDD')<= to_char(tgl_kerja,'YYYYMMDD')
                                        order by a.nodok desc
                                        ");
    }
	
	function izin_sakit($periode){
		return $this->db->query("select * from (
							select a.nik,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmregu,f.nmjabatan,b.grouppenggajian,b.tglmasukkerja,a.nodok,
							g.nmijin_absensi,a.tgl_kerja,a.keterangan
							from sc_trx.ijin_karyawan a 
							left outer join sc_mst.karyawan b 
								on a.nik=b.nik
							left outer join sc_mst.departmen c 
								on a.kddept=c.kddept
							left outer join sc_mst.subdepartmen d 
								on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
							left outer join
								(select a.nik,b.nmregu from sc_mst.regu_opr a
								left outer join sc_mst.regu b on a.kdregu=b.kdregu) e on a.nik=e.nik
							left outer join sc_mst.jabatan f 
								on a.kdjabatan=f.kdjabatan  and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
							left outer join sc_mst.ijin_absensi g 
								on a.kdijin_absensi=g.kdijin_absensi
							where coalesce(upper(b.statuskepegawaian),'')!='KO' and to_char(a.tgl_kerja,'YYYYMM')='$periode' and a.status='P'
							and a.type_ijin='PB' and a.kdijin_absensi='KD'
						
					) as x1
					order by nik asc");

	}

	function q_remind_tl() {
		return $this->db->query("WITH periode_bulan_ini AS (
						SELECT TO_CHAR(current_date, 'YYYYMM') AS periode
					),
					data_karyawan AS (
						SELECT 
							k.nik,
							k.nmlengkap,
							p.periode,
							
							-- Total Telat (TL)
							(
								SELECT COUNT(*) 
								FROM sc_trx.listlinkjadwalcuti tl
								WHERE TO_CHAR(tl.tgl, 'YYYYMM') = p.periode
								AND tl.kdpokok = 'TL'
								AND tl.nik = k.nik
							) AS ttlvaluetl,
							
							-- Total Izin Telat (ITL)
							(
								SELECT COUNT(*) 
								FROM sc_trx.ijin_karyawan ik
								WHERE TO_CHAR(ik.tgl_kerja, 'YYYYMM') = p.periode
								AND ik.kdijin_absensi IN ('DT')
								AND ik.type_ijin = 'PB'
								AND COALESCE(ik.status, '') = 'P'
								AND ik.nik = k.nik
							) AS ttlvalueitl
						FROM 
							sc_mst.karyawan k
						CROSS JOIN 
							periode_bulan_ini p
					)
					SELECT 
						nik,
						nmlengkap,
						periode,
						(ttlvaluetl + ttlvalueitl) AS total_terlambat
					FROM 
						data_karyawan
					WHERE 
						(ttlvaluetl + ttlvalueitl) >= 3
					ORDER BY 
						total_terlambat DESC");
			}

	function q_remind_sp($param = ''){
		     return $this->db->query("
            SELECT * 
            FROM (
                SELECT 
                    a.*, 
                    CASE 
                        WHEN a.startdate IS NULL OR a.enddate IS NULL THEN '' 
                        ELSE TO_CHAR(a.startdate, 'DD-MM-YYYY') || ' - ' || TO_CHAR(a.enddate, 'DD-MM-YYYY') 
                    END AS startdatex, 
                    b.nmlengkap, 
                    b.nmdept, 
                    b.bag_dept, 
                    b.nmjabatan, 
                    b.nik_atasan AS nikatasan1, 
                    b.nmatasan1, 
                    b.nik_atasan2 AS nikatasan2, 
                    b.nmatasan2, 
                    b.nmsubdept, 
                    b.nmlvljabatan, 
                    b.alamattinggal, 
                    COALESCE(b.nohp1, b.nohp2, '-') AS nohp1, 
                    COALESCE(b.email, '') AS email, 
                    c.docname AS spname, 
                    z.uraian AS nmstatus, 
                    d.docno AS nmdocref,                 
                    TO_CHAR(a.startdate, 'DD-MM-YYYY') AS startdate1, 
                    TO_CHAR(a.enddate, 'DD-MM-YYYY') AS enddate1, 
                    TO_CHAR(a.docdate, 'DD-MM-YYYY') AS docdate2,
                    CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors
                FROM sc_trx.sk_peringatan a
                LEFT OUTER JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
                LEFT OUTER JOIN sc_mst.sk_peringatan c ON a.tindakan = c.docno
                LEFT OUTER JOIN sc_trx.berita_acara d ON a.nik = d.nik AND a.docref = d.docno
                LEFT OUTER JOIN sc_mst.trxtype z ON a.status = z.kdtrx AND z.jenistrx = 'I.T.B.27'
                ORDER BY a.docdate DESC
            ) AS x 
            WHERE COALESCE(docno, '') != '' and trim(status) = 'P' and enddate::date >= CURRENT_DATE;
            $param
        ");
	}
	

}
