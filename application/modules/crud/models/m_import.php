<?php
class M_import extends CI_Model{	
	function cek_upload($kodetr,$username){
		return $this->db->query("select * from sc_poin.htgpoin where kodetrans='$kodetr' --and inputby='$username'");
	}
	
	function cek_upload_tmp($kodetr,$username){
		return $this->db->query("select * from sc_tmp.htgpoin where kodetrans='$kodetr' --and inputby='$username'");
	}
	function cek_upexist($username){
		return $this->db->query("select * from sc_tmp.htgpoin where inputby='$username'");
	}
	function list_saledisb($username){
		return $this->db->query("select a.*,x.otladd,
									case 
										when b.custname is null then 'DISB BELUM DI MAPPING' 
										else 'OKE'
									end as mapcust,
									case 
										when c.outletname is null then 'OUTLET/TOKO BELUM DI MAPPING' 
										else 'OKE'
									end as mapoutlet,
									case 
										when d.produk is null then 'PRODUK BELUM DI MAPPING' 
										else 'OKE'
									end as mapproduk 
								from sc_tmp.htgpoin a
								left outer join sc_poin.mapcust b on a.disb=b.disbname
								left outer join sc_poin.mapoutlet c on c.nama_toko=a.nama_toko and a.kd_toko=c.kd_toko
								left outer join sc_mst.outlet x on x.outletcode=c.outletcode
								left outer join sc_poin.mapproduk d on d.produk=a.produk
								where a.inputby='$username'");
	}
	function mapcust($username){
		return $this->db->query("select distinct disb from sc_tmp.htgpoin where disb not in (select disbname from sc_poin.mapcust) and inputby='$username'");
	}
	function mapoutlet($username){
		return $this->db->query("select distinct kd_toko,nama_toko,left(kodetrans,4) as disb from sc_tmp.htgpoin where nama_toko not in (select nama_toko from sc_poin.mapoutlet) and inputby='$username'");
	}
	function mapproduk($username){
		return $this->db->query("select distinct produk from sc_tmp.htgpoin where produk not in (select produk from sc_poin.mapproduk) and inputby='$username'");
	}
	
	function q_disb_barat(){
	return $this->db->query("select * from sc_mst.customer where custarea='BA' and left(custcode,1)='1' 
order by custname ");
	
	}
	function q_disb_tengah(){
	return $this->db->query("select * from sc_mst.customer where custarea='TA' and left(custcode,1)='1' 
order by custname ");
	}
}
