<?php
class M_hrd extends CI_Model{

	//function q_pegawai($pegawai){  //klo ga ada inputan ga usah di isi :)
	function q_pegawai($nip){
		if (!empty($nip)){
			return $this->db->query("select a.nip as list_nip,
									case when a.keluarkerja is null then age(a.masukkerja)
									else age(a.keluarkerja,a.masukkerja)
									end as masakerja,g.nmlengkap as nama_atasan,
									b.deskripsi,c.departement,i.subdepartement,e.desc_agama,h.kdkawin,h.desckawin as kawin,
									j.desc_cabang,a.nip,a.kddept,a.nipatasan,a.kdsubdept,a.kdjabatan,a.nmlengkap,
									to_char(a.masukkerja,'dd-mm-YYYY') as masukkerja,
									to_char(a.keluarkerja,'dd-mm-YYYY') as keluarkerja,a.kdkelamin,a.tempatlahir,a.tgllahir,a.alamat,a.kdstrumah,a.kota,a.telepon,a.kdagama,
									a.kdwn,a.ktp,a.kotaktp,a.tglmulaiktp,a.tglakhirktp,a.kdstnikah,a.idabsensi,a.goldarah,
									a.badgenumber,a.bpjs,a.bpjskes,a.npwp,a.norek,a.image,a.kdcabang,a.email,a.kduangmkn,k.descjabatan,a.ktp_seumurhdp from sc_hrd.pegawai a
									left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan and a.kddept=b.kddept and a.kdsubdept=b.kdsubdept
									left outer join sc_hrd.departement c on a.kddept=c.kddept
									left outer join sc_hrd.agama e on a.kdagama=e.kode_agama
									left outer join sc_hrd.pegawai g on g.nip=a.nipatasan
									left outer join sc_hrd.kawin h on h.kdkawin=a.kdstnikah
									left outer join sc_hrd.subdepartement i on i.kdsubdept=a.kdsubdept and i.kddept=a.kddept
									left outer join sc_mst.kantor j on j.kodecabang=a.kdcabang
									left outer join sc_hrd.uangmakan k on k.kdjabatan=a.kduangmkn
									where a.nip='$nip'
									order by right(a.nip,3)");
		} else {
			return $this->db->query("select a.nip as list_nip,
									case when a.keluarkerja is null then age(a.masukkerja)
									else age(a.keluarkerja,a.masukkerja)
									end as masakerja,g.nmlengkap as nama_atasan,
									b.deskripsi,c.departement,i.subdepartement,e.desc_agama,h.kdkawin,h.desckawin as kawin,
									j.desc_cabang,a.nip,a.kddept,a.nipatasan,a.kdsubdept,a.kdjabatan,a.nmlengkap,
									to_char(a.masukkerja,'dd-mm-YYYY') as masukkerja,
									to_char(a.keluarkerja,'dd-mm-YYYY') as keluarkerja,a.kdkelamin,a.tempatlahir,a.tgllahir,a.alamat,a.kdstrumah,a.kota,a.telepon,a.kdagama,
									a.kdwn,a.ktp,a.kotaktp,a.tglmulaiktp,a.tglakhirktp,a.kdstnikah,a.idabsensi,a.goldarah,
									a.badgenumber,a.bpjs,a.bpjskes,a.npwp,a.norek,a.image,a.kdcabang,a.email,a.kduangmkn,k.descjabatan,a.ktp_seumurhdp from sc_hrd.pegawai a
									left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan and a.kddept=b.kddept and a.kdsubdept=b.kdsubdept
									left outer join sc_hrd.departement c on a.kddept=c.kddept
									left outer join sc_hrd.agama e on a.kdagama=e.kode_agama
									left outer join sc_hrd.pegawai g on g.nip=a.nipatasan
									left outer join sc_hrd.kawin h on h.kdkawin=a.kdstnikah
									left outer join sc_hrd.subdepartement i on i.kdsubdept=a.kdsubdept and i.kddept=a.kddept
									left outer join sc_mst.kantor j on j.kodecabang=a.kdcabang
									left outer join sc_hrd.uangmakan k on k.kdjabatan=a.kduangmkn
									order by right(a.nip,3)");
		}
	}
	//pendidikan febri 16-04-2015
	function q_grade(){
		return $this->db->query("select * from sc_hrd.gradependidikan");
	}
	//Febri 16-04-2015
	function q_pendidikan($nip){
		return $this->db->query("select b.desc_pendidikan as gradepen,a.* from sc_hrd.pendidikan a
								left outer join sc_hrd.gradependidikan b on a.kdpendidikan=b.kdpendidikan
								where nip='$nip'
									order by kdpendidikan asc");
	}
	//Febri 16-04-2015
	function input_pen($info_pen){
		$this->db->insert("sc_hrd.pendidikan",$info_pen);
	}
	//Febri 16-04-2015
	function edit_pen($info_pen,$nip,$nomor){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$nomor);
		$this->db->update("sc_hrd.pendidikan",$info_pen);
	}
	//Febri 16-04-2015
	function hps_pendidikan($nip,$nomor){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$nomor);
		$this->db->delete('sc_hrd.pendidikan');
	}
	function q_kawin(){
		return $this->db->query("select * from sc_hrd.kawin");
	}
	
	function q_kodekontrak(){
		return $this->db->query("select * from sc_hrd.ketkontrak");
	}
	

	//riwayat mutasi
	function q_mutasi($nip){
		return $this->db->query("select a.*,b.deskripsi as oldjabatan,c.deskripsi as jabatan,d.departement as olddepartement,
								e.departement as departement,f.desc_cabang as kantorbaru, g.desc_cabang as kantorlama, h.nmlengkap 
								from sc_hrd.mutasi a 
								left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan and a.kddept=b.kddept 
								left outer join sc_hrd.jabatan c on a.newkdjabatan=c.kdjabatan and a.newkddept=c.kddept 
								left outer join sc_hrd.departement d on a.kddept=d.kddept 
								left outer join sc_hrd.departement e on a.newkddept=e.kddept 
								left outer join sc_mst.kantor f on f.kodecabang=a.newcabang
								left outer join sc_mst.kantor g on g.kodecabang=a.cabang
								left outer join sc_hrd.pegawai h on h.nip=a.nip
								where a.nip='$nip'
								order by nomor desc");
	}
	function q_mutasi_pdf($nip,$no){
		return $this->db->query("select a.*,b.deskripsi as oldjabatan,c.deskripsi as jabatan,d.departement as olddepartement,
								e.departement as departement,f.desc_cabang,g.nmlengkap 
								from sc_hrd.mutasi a 
								left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan and a.kddept=b.kddept 
								left outer join sc_hrd.jabatan c on a.newkdjabatan=c.kdjabatan and a.newkddept=c.kddept 
								left outer join sc_hrd.departement d on a.kddept=d.kddept 
								left outer join sc_hrd.departement e on a.newkddept=e.kddept 
								left outer join sc_mst.kantor f on f.kodecabang=a.newcabang
								left outer join sc_hrd.pegawai g on g.nip=a.nip 
								where a.nip='$nip' and a.nomor='$no'
								");
	}
	function input_mutasi($info_mutasi){
		$this->db->insert('sc_tmp.mutasi',$info_mutasi);
	}
	function updatests_mutasi($nodok){
		$this->db->query("update sc_tmp.mutasi set status='I' where kddokumen='$nodok' ");
	}
	
	function edit_mutasi($info_mutasi,$nip,$no){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$no);
		$this->db->update("sc_hrd.mutasi",$info_mutasi);
	}
	
	function hapus_mutasi($nip,$no){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$no);
		$this->db->delete("sc_hrd.mutasi");
	}
	//status kerja
	function input_stskerja($info_stskerja){
		$this->db->insert('sc_hrd.kontrak',$info_stskerja);
	}
	
	function edit_stskerja($info_stskerja,$nip,$no){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$no);
		$this->db->update('sc_hrd.kontrak',$info_stskerja);
	}
	function hps_stskerja($nip,$no){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$no);
		$this->db->delete('sc_hrd.kontrak');
	}
	//keluarga pegawai
	function q_keluarga($nip){
		return $this->db->query("select * from sc_hrd.keluarga where nir='$nip' order by nomor desc");
	}
	function input_keluarga($info_keluarga){
		$this->db->insert('sc_hrd.keluarga',$info_keluarga);
	}
	function edit_keluarga($info_ekul,$nip,$nom){
		$this->db->where('nir',$nip);
		$this->db->where('nomor',$nom);
		$this->db->update('sc_hrd.keluarga',$info_ekul);
	}
	function hps_keluarga($nip,$no){
		$this->db->where('nir',$nip);
		$this->db->where('nomor',$no);
		$this->db->delete('sc_hrd.keluarga');
	}
	//riwayat sakit
	function q_kesehatan($nip){
		return $this->db->query("select * from sc_hrd.kesehatan where nip='$nip'
								order by nomor desc");
	}
	function input_kes($info_kes){
		$this->db->insert("sc_hrd.kesehatan",$info_kes);
	}
	function edit_kes($info_kes,$nip,$nomor){
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$nomor);
		$this->db->update('sc_hrd.kesehatan',$info_kes);
	}
	function hps_kes($nip,$nomor){		
		$this->db->where('nip',$nip);
		$this->db->where('nomor',$nomor);
		$this->db->delete('sc_hrd.kesehatan');
	}
	//riwyar kerja
	function q_pglmkerja($nip){
		return $this->db->query("select * from sc_hrd.pglmkerja where nir='$nip'
								order by pglmke desc");
	}
	
	function input_pglmkerja($info_kerja){
		$this->db->insert("sc_hrd.pglmkerja",$info_kerja);
	}
	function edit_pglmkerja($info_kerja,$nip,$no){
		$this->db->where('nir',$nip);
		$this->db->where('pglmke',$no);
		$this->db->update('sc_hrd.pglmkerja',$info_kerja);
	}
	function hps_pglmkerja($nip,$no){
		$this->db->where('nir',$nip);
		$this->db->where('pglmke',$no);
		$this->db->delete('sc_hrd.pglmkerja');
	}
	
	//list kontrak pegawai
	function q_kontrak($nip){
		return $this->db->query("select a.*,to_char(a.tanggal1,'dd-mm-yyyy') as mulai,to_char(a.tanggal2,'dd-mm-yyyy') as akhir,b.desc_kontrak as kontrak from sc_hrd.kontrak a
								left outer join sc_hrd.ketkontrak b on a.kdkontrak=b.kdkontrak
								where nip='$nip'
								order by nomor desc");
	}
	
	
	//list kantor
	function q_kantor(){
		return $this->db->query("select * from sc_mst.kantor");
	}
	
	function q_listpeg(){		
			return $this->db->query("select a.nip as list_nip,* from sc_hrd.pegawai a
								left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan
								left outer join sc_hrd.departement c on a.kddept=c.kddept
								left outer join sc_mst.carea d on a.wilayah=d.area
								left outer join sc_hrd.agama e on a.kdagama=e.kode_agama
								left outer join sc_mst.user f on a.nip=f.nip
								order by a.nmlengkap");		
	}
	
	function q_sisa(){
		return $this->db->query("select * 
		from sc_hrd.pegawai a, sc_hrd.jabatan b, sc_hrd.departement c, sc_hrd.jumlahcuti d
		where a.kddept=c.kddept and a.kdjabatan=b.kdjabatan and a.nip=d.nip and tahun='2014' order by a.nip");
	}
	
	function q_idfinger(){
		return $this->db->query("select * from sc_hrd.fingerprint");
	}
	
	function simpan_finger($info_finger){
		$this->db->insert("sc_hrd.fingerprint",$info_finger);
	}
	
	function edit_finger($info_finger,$ip){
		$this->db->where("ipaddress",$ip);
		$this->db->update("sc_hrd.fingerprint",$info_finger);
	}
	function cek_finger($idfinger,$ip,$wil){
		return $this->db->query("select * from sc_hrd.fingerprint where fingerid='$idfinger' and wilayah='$wil' and ipaddress='$ip' ");
	}
	//download user dari finger
	function cek_userfp($ipne,$uid,$idfp,$namafp){
		return $this->db->query("select * from sc_hrd.user_finger where ipaddress='$ipne' and uid='$uid' and id='$idfp' and nama='$namafp'");
	}
	
	function simpan_tarik_user($info_userfp){
		$this->db->insert("sc_hrd.user_finger",$info_userfp);
	}
	//download log attedance
	function cek_idlogfp($userid,$uid,$ipne,$cktype,$ckdate,$cktime){
		return $this->db->query("select * from sc_hrd.transready where userid='$userid' and ipaddress='$ipne' 
								and badgenumber=(select id from sc_hrd.user_finger where uid='$userid' and ipaddress='$ipne')
								and checkdate='$ckdate' and checktime='$cktime' and checktype='$cktype'
								");
	}
	function simpan_logatt($userid,$uid,$ipne,$cktype,$ckdate,$cktime){
		//$this->db->insert("sc_hrd.transready",$info_logfp);
		$this->db->query("INSERT INTO sc_hrd.transready (userid,badgenumber,ipaddress,checktype,checkdate,checktime) VALUES ('$userid', 
							(select id from sc_hrd.user_finger where uid='$userid' and ipaddress='$ipne'), '$ipne', '$cktype','$ckdate' ,'$cktime')");
	}
	
	function q_absensi($branch,$awal,$akhir){
		return $this->db->query("
								select nmlengkap,badgenumber,checkdate,checkin,checkout,hari,uangmakan,deskripsi,departement,
								case	
									when checkin<'08:00:00' and checkout>'16:00:00' and checkout<'17:00:00' and hari<>'Sabtu' then 'Tepat Waktu'
									when checkin<'08:00:00' and checkout>'13:00:00' and hari='Sabtu' then 'Tepat Waktu'
									when checkin>'08:00:00' and checkout>'13:00:00' and hari='Sabtu' then 'Telat Masuk'
									when checkin<'08:00:00' and checkout>'11:00:00' and checkout<'13:00:00' and hari='Sabtu' then 'Tepat Waktu & Pulang Awal'
									when checkin<'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' then 'Loyalitas'
									when checkin>'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' then 'Telat Masuk'
									when checkin<'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' then 'Pulang Awal'
									when checkin>'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' then 'Telat & Pulang Awal'
									when checkin is null and checkout is null and badgenumber<>'TOTAL' and badgenumber<>'GRAND TOTAL' then 'Tidak Ceklog'
									when checkin is null and checkout is not null then 'Tidak Ceklog Masuk'
									when checkin is not null and checkout is null then 'Tidak Ceklog Keluar'
								end as ket
								from (
								select nmlengkap,badgenumber,to_char(checkdate,'dd-mm-YYYY') as checkdate,checkin,checkout,
									case when to_char(checkdate, 'Dy')='Mon' then 'Senin'
										 when to_char(checkdate, 'Dy')='Tue' then 'Selasa'
										 when to_char(checkdate, 'Dy')='Wed' then 'Rabu'
										 when to_char(checkdate, 'Dy')='Thu' then 'Kamis'
										 when to_char(checkdate, 'Dy')='Fri' then 'Jumat'
										 when to_char(checkdate, 'Dy')='Sat' then 'Sabtu'
									else 'Kiamat' end as hari,
									--to_char(checkdate, 'Dy') as hari,
									CASE 
									WHEN departement<>'NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' then c.besaran	     
									WHEN departement<>'NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and to_char(checkdate, 'Dy')='Sat' and checkout>'11:00:00' then c.besaran	     
									WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'STAFF GUDANG' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran
									WHEN departement='NUSA DISTRIBUSI' and deskripsi='STAFF GUDANG' and checkout>'13:00:00' and to_char(checkdate, 'Dy')='Sat'  then c.besaran
									WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'STAFF GUDANG' and checkout>'16:00:00'  then c.besaran
									WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'16:00:00' then c.besaran	
									WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' then c.besaran
									ELSE '0'
									END
									as uangmakan,
									deskripsi,departement from 
									(select t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement from 
										(select b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
										d.deskripsi,b.kduangmkn,e.departement from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept
										where checkdate between '$awal' and '$akhir' and 		
										checktype='IN'
										and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement				
										union all										
										select b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
											case when to_char(checkdate, 'Dy')='Sat' then min(a.checktime)
											     when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then min(a.checktime)
											end as checkout,
										d.deskripsi,b.kduangmkn,e.departement from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept
										where checkdate between '$awal' and '$akhir' and 
										checktype<>'IN' and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement		
										order by nmlengkap,checkdate ) as t1
									group by t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement) as t2
								left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn
								--order by nmlengkap
								union all
								--total
								select ttl.nmlengkap,'TOTAL' as badgenumber,null as checkdate, null as checktin, null as checkout, null as hari,sum(uangmakan),cast(count(nmlengkap)as character varying), null as departement from
									(select nmlengkap,badgenumber,checkdate,checkin,checkout,
										CASE 
											WHEN departement<>'NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' then c.besaran	     
										WHEN departement<>'NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and to_char(checkdate, 'Dy')='Sat' and checkout>'11:00:00' then c.besaran	     
										WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'STAFF GUDANG' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran
										WHEN departement='NUSA DISTRIBUSI' and deskripsi='STAFF GUDANG' and checkout>'13:00:00' and to_char(checkdate, 'Dy')='Sat'  then c.besaran
										WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'STAFF GUDANG' and checkout>'16:00:00'  then c.besaran
										WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'16:00:00' then c.besaran	
										WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' then c.besaran
										ELSE '0'
											END
											as uangmakan,		
										deskripsi,departement from 
										(select t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement from 
											(select b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
											d.deskripsi,b.kduangmkn,e.departement from sc_hrd.pegawai b
											left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
											left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
											left outer join sc_hrd.departement e on e.kddept=b.kddept
											where checkdate between '$awal' and '$akhir' and 		
											checktype='IN'
											and a.ipaddress='$branch'
											group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement				
											union all										
											select b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
												case when to_char(checkdate, 'Dy')='Sat' then min(a.checktime)
												     when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then min(a.checktime)
												end as checkout,
											d.deskripsi,b.kduangmkn,e.departement from sc_hrd.pegawai b
											left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
											left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
											left outer join sc_hrd.departement e on e.kddept=b.kddept
											where checkdate between '$awal' and '$akhir' and 
											checktype<>'IN' and a.ipaddress='$branch'
											group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement		
											order by nmlengkap,checkdate ) as t1
										group by t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement) as t2
									left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn) as ttl
								group by nmlengkap
								--grand total
								union all
								select null as nmlengkap,'GRAND TOTAL' as badgenumber,null as checkdate, null as checktin, null as checkout, null as hari, sum(uangmakan),cast(count(nmlengkap)as character varying), null as departement from
									(select nmlengkap,badgenumber,checkdate,checkin,checkout,
										CASE 
										WHEN departement<>'NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' then c.besaran	     
										WHEN departement<>'NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and to_char(checkdate, 'Dy')='Sat' and checkout>'11:00:00' then c.besaran	     
										WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'STAFF GUDANG' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran
										WHEN departement='NUSA DISTRIBUSI' and deskripsi='STAFF GUDANG' and checkout>'13:00:00' and to_char(checkdate, 'Dy')='Sat'  then c.besaran
										WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'STAFF GUDANG' and checkout>'16:00:00'  then c.besaran
										WHEN departement='NUSA DISTRIBUSI' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'16:00:00' then c.besaran	
										WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' then c.besaran
										ELSE '0'
											END
											as uangmakan,
										deskripsi,departement from 
										(select t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement from 
											(select b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
											d.deskripsi,b.kduangmkn,e.departement from sc_hrd.pegawai b
											left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
											left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
											left outer join sc_hrd.departement e on e.kddept=b.kddept
											where checkdate between '$awal' and '$akhir' and 		
											checktype='IN'
											and a.ipaddress='$branch'
											group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement				
											union all										
											select b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
												case when to_char(checkdate, 'Dy')='Sat' then min(a.checktime)
												     when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then min(a.checktime)
												end as checkout,
											d.deskripsi,b.kduangmkn,e.departement from sc_hrd.pegawai b
											left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
											left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
											left outer join sc_hrd.departement e on e.kddept=b.kddept
											where checkdate between '$awal' and '$akhir' and 
											checktype<>'IN' and a.ipaddress='$branch'
											group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement		
											order by nmlengkap,checkdate ) as t1
										group by t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement) as t2
									left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn) as ttl
								order by nmlengkap,checkdate
								) as um
							");
	}
	
	function q_pegabsen($branch,$awal,$akhir){
		return $this->db->query("select distinct nmlengkap from sc_hrd.pegawai b
								left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
								where checkdate between '$awal' and '$akhir' and checktype<>'INOUT' and a.ipaddress='$branch'
								order by nmlengkap");
	}
	
	function q_uang(){
		return $this->db->query("select ID_UM,b.deskripsi as DEKRIPSI,FM_BESARAN from sc_hrd.uangmakan a
								left outer join sc_hrd.jabatan b on b.kdjabatan=a.KDJABATAN");
	}
	
	function simpan_um($info){
		$this->db->insert("sc_hrd.uangmakan",$info);
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_hrd.jabatan");
	}
	
	function q_departement(){
		return $this->db->query("select * from sc_hrd.departement");
	}
	
	function q_subdepartement(){
		return $this->db->query("select * from sc_hrd.subdepartement");
	}
	function q_agama(){
		return $this->db->query("select kode as kode_agama,upper(deskripsi) as desc_agama from sc_mst.trxstatus
								 where trx='HRDA'");
	}
	//Pelatihan
	function q_pelatihan($nip){
		return $this->db->query("select * from sc_hrd.pelatihan where nip='$nip'");
	}
	
	function input_pelatihan($info_pel){
		$this->db->insert("sc_hrd.pelatihan",$info_pel);
	}
	
	function edit_pelatihan($nip,$kdpelatihan,$info_pel){
		$this->db->where("nip",$nip);
		$this->db->where("kdpelatihan",$kdpelatihan);
		$this->db->update("sc_hrd.pelatihan",$info_pel);
	}
	function hapus_pelatihan($nip,$kdpelatihan){
		$this->db->where("nip",$nip);
		$this->db->where("kdpelatihan",$kdpelatihan);
		$this->db->delete("sc_hrd.pelatihan");
	}
	
	//simpan data pegawai
	function save_peg($info_peg){
		$this->db->insert("sc_tmp.pegawai",$info_peg);
	}
	//edit data pegawai
	function edit_peg($oldnip,$info_peg){
		$this->db->where('nip',$oldnip);
		$this->db->update('sc_hrd.pegawai',$info_peg);
	}
	//simpan data jumlah cuti
	function save_jmlcuti($info_cuti){
		$this->db->insert("sc_hrd.jumlahcuti",$info_cuti);
	}
	//simpan foto
	function save_foto($nip,$info){
		$this->db->where('nip',$nip);
		$this->db->update('sc_hrd.pegawai',$info);
	}
	
}
