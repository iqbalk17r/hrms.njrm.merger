<?php
class M_mtsasset extends CI_Model{
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
	
	function q_cekscgroup($kdgroup){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
	}
	
	function q_scgroup(){
		return $this->db->query("select * from sc_mst.mgroup order by nmgroup");
	}
	
	function q_scsubgroup(){
		return $this->db->query("select * from sc_mst.msubgroup order by nmsubgroup");
	}

	function q_mstbarang(){
		return $this->db->query("select * from sc_mst.mbarang where kdgroup in (select kdgroup from sc_mst.mgroup where groupreminder<>'KENDARAAN')  order by nmbarang");
	}
	
	function q_mstkantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
	}
	
	function q_masuransi(){
		return $this->db->query("select * from sc_mst.masuransi order by nmasuransi");
	}
	
	function q_listkaryawanbarang(){
		return $this->db->query("select a.*,trim(coalesce(b.nodok,'NONE'))as nodok from sc_mst.karyawan a 
							left outer join sc_mst.mbarang b on a.nik=b.userpakai
							where  a.statuskepegawaian<>'KO' and a.tglkeluarkerja is null order by nmlengkap asc");
	}	
	function q_hisperawatan(){
		return $this->db->query("select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.kdcabang,b.nmdept,c.nmsubdept,d.nmjabatan as jabpengguna,e.nmlengkap as nmpemohon,h.nmjabatan as jabpemohon,count(i.nodok) as spk  from (
									select a.*,b.nmbarang,b.kdgroup,
									case 	when b.nopol is null or b.nopol='' then b.nodok 
										when b.nopol is not null and b.nopol<>'' then b.nopol end as numberitem,
									case	when b.userpakai is null or b.userpakai='' then a.nikpakai
										when b.userpakai is not null and b.userpakai<>'' then b.userpakai end as userpakai
										 from sc_his.perawatanasset a 
												left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
												order by nodok desc) as x 
												left outer join sc_mst.karyawan a on x.userpakai=a.nik
												left outer join sc_mst.departmen b on a.bag_dept=b.kddept
												left outer join sc_mst.subdepartmen c on a.bag_dept=c.kddept and a.subbag_dept=c.kdsubdept
												left outer join sc_mst.jabatan d on a.bag_dept=d.kddept and a.subbag_dept=d.kdsubdept and a.jabatan=d.kdjabatan
												left outer join sc_mst.karyawan e on x.nikmohon=e.nik
												left outer join sc_mst.departmen f on e.bag_dept=f.kddept
												left outer join sc_mst.subdepartmen g on e.bag_dept=g.kddept and e.subbag_dept=g.kdsubdept
												left outer join sc_mst.jabatan h on e.bag_dept=h.kddept and e.subbag_dept=h.kdsubdept and e.jabatan=h.kdjabatan
												left outer join sc_his.perawatanspk i on x.nodok=i.nodok
								group by x.nodok,x.dokref,x.kdbarang,x.descbarang,x.nikpakai,x.nikmohon,x.jnsperawatan,x.tgldok,x.keterangan,x.laporanpk,x.laporanpsp,x.laporanksp,x.status,x.inputdate,x.inputby,x.updatedate,x.updateby,
								x.nmbarang,x.kdgroup,x.numberitem,x.userpakai,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.kdcabang,b.nmdept,c.nmsubdept,d.nmjabatan,e.nmlengkap,h.nmjabatan
								");
	}
	
	function q_listbarang(){
		return $this->db->query("select a.*,b.nmlengkap as nmuserpakai from sc_mst.mbarang a 
								left outer join sc_mst.karyawan b on a.userpakai=b.nik
								order by nmbarang");
	}
	
	function q_listassetinput($param1){
		return $this->db->query("select * from (
			select a.*,b.nmlengkap as nmuserpakai,c.nmgroup,d.nmsubgroup,e.desc_cabang as namagudang from sc_mst.mbarang a 
			left outer join sc_mst.karyawan b on a.userpakai=b.nik
			left outer join sc_mst.mgroup c on a.kdgroup=c.kdgroup
			left outer join sc_mst.msubgroup d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup
			left outer join sc_mst.kantorwilayah e on a.kdgudang=e.kdcabang) as x
			where nodok is not null $param1
			order by nmbarang");
	}
	
	function q_listbengkel(){
		return $this->db->query("select * from sc_mst.mbengkel order by nmbengkel");
	}
	
	function q_mutasiasset($param){
		return $this->db->query("
select * from (
select a.*,b.nmbarang,b.kdgroup,b.kdsubgroup,b.nopol,c.nmgroup,d.nmsubgroup,e.nmlengkap as nmuserpakai,f.nmlengkap as nmolduserpakai,g.uraian as nmstatus from sc_his.mtsasset a
									left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
									left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
									left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
									left outer join sc_mst.karyawan e on a.userpakai=e.nik
									left outer join sc_mst.karyawan f on a.olduserpakai=f.nik 
									left outer join sc_mst.trxtype g on a.status=g.kdtrx and g.jenistrx='PASSET') as x
									where nodok is not null $param
									order by nodok desc
								");
	}
	/*serah terima mutasi*/
	function q_mutasiasset_st(){
		return $this->db->query("select a.*,b.nmbarang,b.kdgroup,b.kdsubgroup,b.nopol,c.nmgroup,d.nmsubgroup,e.nmlengkap as nmuserpakai,f.nmlengkap as nmolduserpakai,g.nmlengkap as nmusertau from sc_his.mtsasset_st a
									left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
									left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
									left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
									left outer join sc_mst.karyawan e on a.userpakai=e.nik
									left outer join sc_mst.karyawan f on a.olduserpakai=f.nik 
									left outer join sc_mst.karyawan g on a.usertau=g.nik 
									order by a.nodok desc
								");
	}
	
	function q_hisperawatanspk($nodok){
		return $this->db->query("select a.*,b.nmbarang,b.kdgudang,c.nmbengkel,c.addbengkel,c.city,c.phone1,c.phone2,d.kdgroup from sc_his.perawatanspk a
									left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
									left outer join sc_mst.mbengkel c on c.kdbengkel=a.kdbengkel
									left outer join sc_mst.mbarang d on d.nodok=a.kdbarang
									where a.nodok='$nodok'");
	}
	
	function cek_spkdouble($nodok){
		return $this->db->query("select * from sc_his.perawatanspk where nodok='$nodok'");
	}
	
	function q_lampiran_at($nodok){
		return $this->db->query("select * from sc_his.perawatan_lampiran where  trim(nodok)='$nodok' order by id desc");
	}
	
	function insert_attachmentspk($data = array()){
        $insert = $this->db->insert_batch('sc_his.perawatan_lampiran',$data);
        return $insert?true:false;
    }
	

	
	function q_skmemo($param){
		return $this->db->query("select * from (select a.*,b.nmlengkap as nmuserpakai,c.nmlengkap as nmolduserpakai,d.nmbarang,d.nopol as noseri,d.kdgroup,d.kdsubgroup,e.uraian as nmstatus from sc_his.sk_mtsasset a
								left outer join sc_mst.karyawan b on a.userpakai=b.nik
								left outer join sc_mst.karyawan c on a.olduserpakai=c.nik 
								left outer join sc_mst.mbarang d on a.kdbarang=d.nodok 
								left outer join sc_mst.trxtype e on a.status=e.kdtrx and e.jenistrx='PASSET') as x 
								where nodok is not null $param
								order by nodok desc");
	}
	
	function q_skmemofinal(){
		return $this->db->query("select a.*,b.nmbarang,b.kdgroup,b.kdsubgroup,b.nopol,c.nmgroup,d.nmsubgroup,e.nmlengkap as nmuserpakai,f.nmlengkap as nmolduserpakai from sc_his.sk_mtsasset a
								left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
								left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
								left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
								left outer join sc_mst.karyawan e on a.userpakai=e.nik
								left outer join sc_mst.karyawan f on a.olduserpakai=f.nik 
								where a.status='P' and a.nodok not in (select trim(nodokref) from sc_his.mtsasset where (status='P' or status='A')) order by a.nodok desc");
	}
	
	function q_skmemofinalparam($nodokref){
		return $this->db->query("select a.*,b.nmbarang,b.kdgroup,b.kdsubgroup,b.nopol,c.nmgroup,d.nmsubgroup,e.nmlengkap as nmuserpakai,f.nmlengkap as nmolduserpakai from sc_his.sk_mtsasset a
								left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
								left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
								left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
								left outer join sc_mst.karyawan e on a.userpakai=e.nik
								left outer join sc_mst.karyawan f on a.olduserpakai=f.nik 
								where a.status='P' and a.nodokref not in (select trim(nodok) from sc_his.mtsasset where  (status='P' or status='A')) and a.nodok='$nodokref' order by a.nodok desc");
	}
	
	function q_mtsassetfinal(){
		return $this->db->query("select a.*,b.nmbarang,b.kdgroup,b.kdsubgroup,b.nopol,c.nmgroup,d.nmsubgroup,e.nmlengkap as nmuserpakai,f.nmlengkap as nmolduserpakai from sc_his.mtsasset a
								left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
								left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
								left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
								left outer join sc_mst.karyawan e on a.userpakai=e.nik
								left outer join sc_mst.karyawan f on a.olduserpakai=f.nik 
								where a.status='P' and a.nodok not in (select trim(nodokref) from sc_his.mtsasset_st where (status='P' or status='A')) order by a.nodok desc");
	}
		
	function q_mtsassetfinalparam($nodokref){
		return $this->db->query("select a.*,b.nmbarang,b.kdgroup,b.kdsubgroup,b.nopol,c.nmgroup,d.nmsubgroup,e.nmlengkap as nmuserpakai,f.nmlengkap as nmolduserpakai from sc_his.mtsasset a
								left outer join sc_mst.mbarang b on a.kdbarang=b.nodok
								left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
								left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
								left outer join sc_mst.karyawan e on a.userpakai=e.nik
								left outer join sc_mst.karyawan f on a.olduserpakai=f.nik 
								where a.status='P' and a.nodok not in (select trim(nodokref) from sc_his.mtsasset_st where (status='P' or status='A')) and a.nodok='$nodokref'  order by a.nodok desc");
	
	}
	
	function q_listassetparam($param1,$param2,$param3){
		return $this->db->query("select * from (
			select a.*,b.nmlengkap as nmuserpakai,c.nmgroup,d.nmsubgroup,e.desc_cabang as namagudang from sc_mst.mbarang a 
			left outer join sc_mst.karyawan b on a.userpakai=b.nik
			left outer join sc_mst.mgroup c on a.kdgroup=c.kdgroup
			left outer join sc_mst.msubgroup d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup
			left outer join sc_mst.kantorwilayah e on a.kdgudang=e.kdcabang) as x
			where nodok is not null $param1 $param2 $param3
			order by nmbarang");
	}
	
	function q_listmbarang_hps(){
		return $this->db->query("select * from (
			select a.*,b.nmlengkap as nmuserpakai,c.nmgroup,d.nmsubgroup,e.desc_cabang as namagudang from sc_his.mbarang_hps a
			left outer join sc_mst.karyawan b on a.userpakai=b.nik
			left outer join sc_mst.mgroup c on a.kdgroup=c.kdgroup
			left outer join sc_mst.msubgroup d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup
			left outer join sc_mst.kantorwilayah e on a.kdgudang=e.kdcabang) as x
			order by nodok desc");
	}
	
	
	
}	