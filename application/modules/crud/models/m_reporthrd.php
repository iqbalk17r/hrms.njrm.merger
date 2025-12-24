<?php
class M_reporthrd extends CI_Model{

	function q_kantor(){
		return $this->db->query("select * from sc_mst.kantor");
	}
	
	function q_laporan(){
		return $this->db->query("select * from sc_mst.mst_reporthrd");
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
									case when kdcabang='SBYMRG' and kdkelamin='B' then count(a.nip) end as mmrg,
									case when kdcabang='SBYMRG' and kdkelamin='A' then count(a.nip) end as fmrg,
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
									case when kdcabang='SBYMRG' and kdkelamin='B' then count(a.nip) end as mmrg,
									case when kdcabang='SBYMRG' and kdkelamin='A' then count(a.nip) end as fmrg,
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
									case when kdcabang='SBYMRG' and kdkelamin='B' then count(a.nip) end as mmrg,
									case when kdcabang='SBYMRG' and kdkelamin='A' then count(a.nip) end as fmrg,
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
								departement,subdepartement,null as jabt, null as ttl,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null from sc_hrd.departement a
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
	//Febri 18-04-2015
	function q_status_kepegawaian($tahun,$bulan){
		return $this->db->query("select distinct a.nip,f.nmlengkap,g.departement, h.subdepartement,i.deskripsi,to_char(f.masukkerja,'dd-mm-yyyy') as masuk,
								to_char(b.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(b.tanggal2,'dd-mm-yyyy') as ojt,
								to_char(c.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(c.tanggal2,'dd-mm-yyyy') as pwkt1,
								to_char(d.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(d.tanggal2,'dd-mm-yyyy') as pwkt2, 
								to_char(e.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(e.tanggal2,'dd-mm-yyyy') as tetap
								from sc_hrd.kontrak a
								left outer join sc_hrd.kontrak b on a.nip=b.nip and b.kdkontrak='AA' and '$tahun-$bulan'  between to_char(b.tanggal1,'yyyy-mm') and to_char(b.tanggal2,'yyyy-mm')
								left outer join sc_hrd.kontrak c on a.nip=c.nip and c.kdkontrak='AB' and '$tahun-$bulan'  between to_char(c.tanggal1,'yyyy-mm') and to_char(c.tanggal2,'yyyy-mm')
								left outer join sc_hrd.kontrak d on a.nip=d.nip and d.kdkontrak='AC' and '$tahun-$bulan'  between to_char(d.tanggal1,'yyyy-mm') and to_char(d.tanggal2,'yyyy-mm')
								left outer join sc_hrd.kontrak e on a.nip=e.nip and e.kdkontrak='AD' and '$tahun-$bulan'  between to_char(e.tanggal1,'yyyy-mm') and to_char(e.tanggal2,'yyyy-mm')
								left outer join sc_hrd.pegawai f on a.nip=f.nip
								left outer join sc_hrd.departement g on f.kddept=g.kddept
								left outer join sc_hrd.subdepartement h on f.kdsubdept=h.kdsubdept and f.kddept=h.kddept
								left outer join sc_hrd.jabatan i on f.kdsubdept=i.kdsubdept and f.kddept=i.kddept and f.kdjabatan=i.kdjabatan
								where f.keluarkerja is null and '$tahun-$bulan'  between to_char(a.tanggal1,'yyyy-mm') and to_char(a.tanggal2,'yyyy-mm')
								order by nmlengkap asc");
	}
	function q_total_status_kepegawaian($tahun,$bulan){
		return $this->db->query("select count(ojt) as ojt,count(pwkt1) as pkwt1,count(pwkt2) as pkwt2,count(tetap) as tetap from (
								select distinct a.nip,f.nmlengkap,g.departement, h.subdepartement,i.deskripsi,to_char(f.masukkerja,'dd-mm-yyyy') as masuk,
								to_char(b.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(b.tanggal2,'dd-mm-yyyy') as ojt,
								to_char(c.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(c.tanggal2,'dd-mm-yyyy') as pwkt1,
								to_char(d.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(d.tanggal2,'dd-mm-yyyy') as pwkt2, 
								to_char(e.tanggal1,'dd-mm-yyyy')||' hingga '||to_char(e.tanggal2,'dd-mm-yyyy') as tetap
								from sc_hrd.kontrak a
								left outer join sc_hrd.kontrak b on a.nip=b.nip and b.kdkontrak='AA' and '$tahun-$bulan'  between to_char(b.tanggal1,'yyyy-mm') and to_char(b.tanggal2,'yyyy-mm')
								left outer join sc_hrd.kontrak c on a.nip=c.nip and c.kdkontrak='AB' and '$tahun-$bulan'  between to_char(c.tanggal1,'yyyy-mm') and to_char(c.tanggal2,'yyyy-mm')
								left outer join sc_hrd.kontrak d on a.nip=d.nip and d.kdkontrak='AC' and '$tahun-$bulan'  between to_char(d.tanggal1,'yyyy-mm') and to_char(d.tanggal2,'yyyy-mm')
								left outer join sc_hrd.kontrak e on a.nip=e.nip and e.kdkontrak='AD' and '$tahun-$bulan'  between to_char(e.tanggal1,'yyyy-mm') and to_char(e.tanggal2,'yyyy-mm')
								left outer join sc_hrd.pegawai f on a.nip=f.nip
								left outer join sc_hrd.departement g on f.kddept=g.kddept
								left outer join sc_hrd.subdepartement h on f.kdsubdept=h.kdsubdept and f.kddept=h.kddept
								left outer join sc_hrd.jabatan i on f.kdsubdept=i.kdsubdept and f.kddept=i.kddept and f.kdjabatan=i.kdjabatan
								order by nmlengkap asc ) as t1");
								
	}
	//Febri 18-04-2015
	function q_chart(){
		return $this->db->query("select t2.desc_kontrak,t1.total from (
								select kdkontrak,count(nip)as total from sc_hrd.kontrak
								group by kdkontrak) as t1
								left outer join sc_hrd.ketkontrak t2 on t2.kdkontrak=t1.kdkontrak");
	}
	
	function q_turn_over($tahun,$bulan){
		if ($bulan<>'12') {
			$thn1=$tahun;	
			$thn2=$tahun;	
			$bln1=$bulan;
			$bln2=$bulan+1;
		} else {
			$thn1=$tahun;
			$thn2=$tahun+1;
			$bln1=$bulan;
			$bln2=1;
		}
		return $this->db->query("select 
								case when keluarkerja is null then '1B.MASUK' else '2B.KELUAR' end as urut,
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
								where masukkerja>='$thn1-$bln1-1' and masukkerja<'$thn2-$bln2-1' and desc_cabang is not null
								union all
								select '1' as urut,desc_cabang,null,null,null,null,null,null,null,null,null,null,null
								from sc_mst.kantor

								union all
								select '1A.MASUK' as urut,desc_cabang,null,null,null,null,null,null,null,null,null,null,null
								from sc_mst.kantor
								union all
								select '2A.KELUAR' as urut,desc_cabang,null,null,null,null,null,null,null,null,null,null,null
								from sc_mst.kantor
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
	
	function q_kar_slskontrak(){
		return $this->db->query("select a.nmlengkap,a.nip,a.masukkerja,b.tanggal1 from sc_hrd.pegawai a
								left outer join sc_hrd.kontrak b on a.nip=b.nip
								order by nmlengkap asc");
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

	}
