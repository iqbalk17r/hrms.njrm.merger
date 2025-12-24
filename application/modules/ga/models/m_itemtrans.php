<?php
class M_itemtrans extends CI_Model{
	var $columnspk = array('nodok','nodokref','nopol','nmbarang','nmbengkel');
	var $orderspk = array('nodokref' => 'desc','nodok' => 'desc');
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
	function q_trxtype_satuan(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='QTYUNIT' order by uraian asc");
	}
	function q_trxtype_spkasset(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='SPKPSASSET' order by uraian asc");
	}
	function q_cekscgroup($kdgroup){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
	}
	function q_cekscsubgroup($kdgroup){
		return $this->db->query("select * from sc_mst.msubgroup where kdgroup='$kdgroup'");
	}
	function q_cekscsubgroup_2p($kdgroup,$kdsubgroup){
		return $this->db->query("select * from sc_mst.msubgroup where kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup'");
	}
	
	function q_scgroup(){
		return $this->db->query("select * from (
									select a.*,coalesce(b.rowdtl,0) as rowdtl from sc_mst.mgroup a
									left outer join (select count(*) as rowdtl,kdgroup from sc_mst.msubgroup 
									group by kdgroup) b on a.kdgroup=b.kdgroup ) x where kdgroup is not null
									order by nmgroup");
	}
	function q_scgroup_atk(){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='BRG' order by nmgroup");
	}
	
	function q_scgroup_ast(){
		return $this->db->query("select * from sc_mst.mgroup where left(kdgroup,3) in ('AST','KDN') order by nmgroup");
	}
	
	
	function q_scsubgroup(){
		return $this->db->query("select a.*,coalesce(b.rowdtl,0) as rowdtl from sc_mst.msubgroup a
									left outer join (select count(*) as rowdtl,kdsubgroup from sc_mst.mbarang 
									group by kdsubgroup) b on a.kdsubgroup=b.kdsubgroup
									order by nmsubgroup");
	}
	
	function q_scsubgroup_atk(){
		return $this->db->query("select * from sc_mst.msubgroup where kdgroup='BRG' order by nmsubgroup");
	}

	function q_mstbarang(){
		return $this->db->query("select *,case when typebarang='LJ' THEN 'BERKELANJUTAN'
				when typebarang='SP' then 'SEKALI PAKAI' end as nmtypebarang from sc_mst.mbarang where kdgroup='BRG'  order by nmbarang");
	}
	
	function q_stkgdw_param1($param1){
		return $this->db->query("select * from (select coalesce(a.onhand,0)as onhand,a.allocated,a.tmpalloca,a.laststatus,a.lastqty,a.lastdate,a.docno,a.stockcode,a.loccode,coalesce(a.onhand,0::numeric) as conhand,b.kdgroup,b.kdsubgroup,b.nmbarang from sc_mst.stkgdw a 
				left outer join sc_mst.mbarang b on a.stockcode=b.nodok  and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
				left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup) as x
				where stockcode is not null $param1
			");
	}
	
	function q_stgblcoitem_param($param1){
		return $this->db->query("select * from (
									select x.*,b.nmbarang,b.satkecil from (
									select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno,a.docref,a.qty_sld from sc_trx.stgblco a,
									(select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno,max(a.docref) as docref from sc_trx.stgblco a,
									(select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,max(a.docno) as docno from sc_trx.stgblco a,
									(select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,max(a.doctype) as doctype from sc_trx.stgblco a,
									(select branch,loccode,kdgroup,kdsubgroup,stockcode,max(trxdate) as trxdate from sc_trx.stgblco
									where branch is not null $param1--and branch='SBYNSA' and loccode='SBYMRG' and stockcode='PEN000002' 
									--where branch=new.branch and loccode=new.loccode and stockcode=new.stockcode
									group by branch,loccode,kdgroup,kdsubgroup,stockcode) as b
									where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate
									group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate) as  b
									where a.branch=b.branch and a.loccode=b.loccode  and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate and a.doctype=b.doctype 
									group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype) as b
									where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate and a.doctype=b.doctype and a.docno=b.docno
									group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno) as b
									where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate and a.doctype=b.doctype and a.docno=b.docno and a.docref=b.docref
									group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno,a.docref) as x
									left outer join sc_mst.mbarang b on x.kdgroup=b.kdgroup and x.kdsubgroup=x.kdsubgroup and x.stockcode=b.nodok) x1;
			");
	}
	
	
	function q_stgblco_param($param1){
		return $this->db->query("select * from (select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,to_char(a.trxdate,'dd-mm-yyyy hh24:mi:ss') as trxdate,a.doctype,a.docno,a.docref,a.qty_in,a.qty_out,a.qty_sld,a.hist,a.ctype,b.nmbarang from sc_trx.stgblco a 
								left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
								left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
								left outer join sc_mst.msubgroup d on b.kdsubgroup=d.kdsubgroup) as x
								where stockcode is not null $param1
			");
	}
	function q_mstkantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
	}
	

	function q_listkaryawanbarang(){
		return $this->db->query("select a.*,trim(coalesce(b.nodok,'NONE'))as nodok from sc_mst.karyawan a 
							left outer join sc_mst.mbarang b on a.nik=b.userpakai
							where  a.statuskepegawaian<>'KO' and a.tglkeluarkerja is null order by nmlengkap asc");
	}	

	function q_row_itemtrans_mst(){
		return $this->db->query("select * from sc_trx.stbbm_mst_view order by nodok desc");
	}
	
	function q_tmp_itemtrans_mst_param($param){
		return $this->db->query("select * from (
								select a.*,b.uraian as nmstatus from sc_tmp.itemtrans_mst a
								left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM') as x
								where nodok is not null $param");
	}
	
	function q_tmp_itemtrans_dtl_param($param){
		return $this->db->query("select * from (select a.*,b.nmbarang,c.uraian as nmsatkecil,d.uraian as nmstatus from sc_tmp.itemtrans_dtl a
								left outer join sc_mst.mbarang b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.nodok 
								left outer join sc_mst.trxtype c on a.satkecil=c.kdtrx and c.jenistrx='QTYUNIT'
								left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STBBM'
								) as x
								where nodok is not null $param");
	}
	

	function q_trx_itemtrans_mst_param($param){
		return $this->db->query("select * from (
								select a.*,b.uraian as nmstatus from sc_trx.itemtrans_mst a
								left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM') as x
								where nodok is not null $param order by nodok desc");
	}
	
	function q_trx_itemtrans_dtl_param($param){
		return $this->db->query("select * from (select a.*,b.nmbarang,c.uraian as nmsatkecil,d.uraian as nmstatus from sc_trx.itemtrans_dtl a
								left outer join sc_mst.mbarang b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.nodok 
								left outer join sc_mst.trxtype c on a.satkecil=c.kdtrx and c.jenistrx='QTYUNIT'
								left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STBBM'
								) as x
								where nodok is not null $param order by nodok desc");
	}
	
	function q_trxerror($paramtrxerror){
		return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
	}
	
}	