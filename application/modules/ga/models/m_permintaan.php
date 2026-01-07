<?php
class M_permintaan extends CI_Model{
	var $columnbbm = array('nodok','nodokref');
	var $orderbbm = array('nodok' => 'desc');
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
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
	function q_mstkantor($param_kanwil){
		return $this->db->query("select * from sc_mst.kantorwilayah where kdcabang is not null $param_kanwil order by desc_cabang asc");
	}
	
	function q_trxerror($paramtrxerror){
		return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
	}

	function ins_trxerror($param1error,$param2error){
		return $this->db->query("
				delete from sc_mst.trxerror where userid is not null and modul='TMPSTBBM' and userid='$param1error' ;
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				('$param1error',$param1error,'$param2error','','TMPSTBBM')");
	}
	
	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from sc_mst.trxerror where modul='TMPSTBBM' $paramtrxerror");
	}
	
	function q_deltrxerror_bbk($paramtrxerror){
		return $this->db->query("delete from sc_mst.trxerror where modul='TMPSTBBK' $paramtrxerror");
	}
	function q_trxsupplier(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='JSUPPLIER' order by uraian asc");
	}
	
	function q_msupplier(){
		return $this->db->query("select * from sc_mst.msupplier order by nmsupplier");
	}
	
	function q_msubsupplier(){
		return $this->db->query("select * from sc_mst.msubsupplier order by nmsubsupplier");
	}
	
	function q_msubsupplier_param($param){
		return $this->db->query("select * from (
									select a.*,b.kdgroup as kdgroupsupplier from sc_mst.msubsupplier a
									left outer join sc_mst.msupplier b on a.kdsupplier=b.kdsupplier) as x
									where kdsubsupplier is not null $param order by nmsubsupplier,kdcabang");
	}
	
	
	function q_scgroup(){
		return $this->db->query("select * from sc_mst.mgroup order by nmgroup");
	}
	function q_scsubgroup(){
		return $this->db->query("select * from sc_mst.msubgroup order by nmsubgroup");
	}
	function q_scgroup_atk(){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='BRG' order by nmgroup");
	}
	
	function q_listpbk(){
		return $this->db->query("select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_trx.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK'
								order by nodok desc");
	}
		
	function q_listpbk_param($param_list_akses){
		return $this->db->query("select * from (
								select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_trx.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK'
									) as x
									where nodok is not null $param_list_akses
								order by nodok desc");
	}
	
	function q_listbbk(){
		return $this->db->query("select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_trx.stbbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK'
								order by nodok desc");
	}
	
	function q_pbk_tmp_mst(){
		return $this->db->query("select a.*,c.*,z.uraian as nmstatus  from sc_tmp.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK'
								order by nodok desc");
	}
	function q_pbk_tmp_mst_param($param3_1){
		return $this->db->query("	select * from (
		select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_tmp.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}
	
	function q_pbk_trx_mst_param($param3_1){
		return $this->db->query("	select * from (
		select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_trx.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}
	
	function q_pbk_tmp_dtl(){
		return $this->db->query("select a.*,b.nmbarang,c.*,z.uraian as nmstatus from sc_tmp.stpbk_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
										left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK'
									order by nodok desc");
	}
	
	function q_pbk_tmp_dtl_param($param1){
		return $this->db->query(" select * from (
		select a.*,coalesce(a.qtypbk,0) as cqtypbk,coalesce(a.qtybbk,0) as cqtybbk,b.nmbarang,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_tmp.stpbk_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
										left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
										where nodok is not null $param1
									order by id asc");
	}
	
	
	
	function q_pbk_trx_dtl_param($param3_2){
		return $this->db->query(" select * from (
		select a.*,coalesce(a.qtypbk,0) as cqtypbk,coalesce(a.qtybbk,0) as cqtybbk,b.nmbarang,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_trx.stpbk_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
										left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
										where nodok is not null $param3_2
									order by nodok desc");
	}
	
	function q_pbk_trx_mst_param_inputby($paraminputby){
		return $this->db->query("select * from sc_trx.stpbk_mst where nodok is not null $paraminputby order by inputdate desc limit 1");
	}
	
	
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.nik='$nik' and f.tglkeluarkerja is null
								");
	}

	function q_mstbarang_atk(){
		return $this->db->query("select * from sc_mst.mbarang where kdgroup='ATK001' order by nmbarang");
	}
	
	function q_stkgdw_param1($param1){
		return $this->db->query("select * from (
								select coalesce(a.onhand,0)as onhand,a.allocated,a.tmpalloca,a.laststatus,a.lastqty,a.lastdate,a.docno,a.stockcode,a.loccode,coalesce(a.onhand,0::numeric) as conhand,b.kdgroup,b.kdsubgroup,b.nmbarang,a.satkecil,e.uraian as nmsatkecil 
								from sc_mst.stkgdw a 
								left outer join sc_mst.mbarang b on a.stockcode=b.nodok
								left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
								left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and b.kdsubgroup=d.kdsubgroup
								left outer join sc_mst.trxtype e on a.satkecil=e.kdtrx and e.jenistrx='QTYUNIT'
								) as x
								where stockcode is not null $param1
			");
	}
	
	function q_trxqtyunit(){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='QTYUNIT' order by uraian asc");
	}
	
	
	function q_pbk_his_mst_param($param3_1){
		return $this->db->query("	select * from (
		select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_his.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}
	
	function q_pbk_his_dtl_param($param3_2){
		return $this->db->query(" select * from (
		select a.*,coalesce(a.qtypbk,0) as cqtypbk,coalesce(a.qtybbk,0) as cqtybbk,b.nmbarang,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_his.stpbk_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
										left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
										where nodok is not null $param3_2
									order by nodok desc");
	}
	
	function q_listpbk_hangus_param($param_list_akses){
		return $this->db->query("select * from (
								select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_his.stpbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
									where nodok is not null $param_list_akses
								order by nodok desc");
	}
	
	/* BBK PARAMETER */
	function q_bbk_tmp_mst_param($param3_1){
		return $this->db->query("	select * from (
		select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_tmp.stbbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}
	
	function q_bbk_tmp_dtl_param($param3_2){
		return $this->db->query(" select * from (
									select a.*,coalesce(a.qtypbk,0) as cqtypbk,coalesce(a.qtybbk,0) as cqtybbk,b.nmbarang,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,coalesce(a.qtybbk,0) as qtybbk1,coalesce(h.onhand,0) as onhand_stkgdw,coalesce(h.tmpalloca,0) as tmpalloca_stkgdw, 
									(coalesce(h.onhand,0)-(coalesce(h.tmpalloca,0))) as onhand_tmp ,z.uraian as nmstatus 
									from sc_tmp.stbbk_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
										left outer join sc_mst.stkgdw h on a.kdgroup=h.kdgroup and a.kdsubgroup=h.kdsubgroup and a.stockcode=h.stockcode and a.loccode=h.loccode
										left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
										where nodok is not null $param3_2 
									order by loccode,stockcode desc");
	}
	
	function q_bbk_tmp_dtl_normal($param3_2){
		return $this->db->query(" select sum(qtybbk) as ttlqtybbk from  sc_tmp.stbbk_dtl where nodok is not null $param3_2");
	}
	
	function q_bbk_trx_mst_normal($param){
		return $this->db->query(" select max(nodok) as nodok from  sc_trx.stbbk_mst where nodok is not null $param");
	}
	
	function q_listbbk_param($param_list_akses){
		return $this->db->query("select * from (
								select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus  from sc_trx.stbbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
									where nodok is not null $param_list_akses
								order by nodok desc");
	}
	
	
	function insert_trx_pbk_to_bbk($nodokpbk,$nama,$inputdate){
		return $this->db->query("
								insert into sc_tmp.stbbk_mst
									(branch,nodok,nodokref,nik,nodoktype,nodokdate,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby)
									(select branch,'$nama',nodok,nik,'PBK',to_char(inputdate,'yyyy-mm-dd')::date,loccode,'I',keterangan,'$inputdate','$nama',null,null,null,null 
									from sc_trx.stpbk_mst where (status='P' or status='S')  and nodok='$nodokpbk' and not exists (select nodokref from sc_tmp.stbbk_mst where nodokref='$nodokpbk')) ;

								insert into sc_tmp.stbbk_dtl
									(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref)
									(select branch,'$nama',nik,kdgroup,kdsubgroup,stockcode,'PBK',loccode,desc_barang,coalesce(qtypbk,0)-coalesce(qtybbk,0) as qtypbk,0 as qtybbk,qtyonhand,'I',keterangan,'$inputdate','$nama',null,null,null,null,nodok
									from sc_trx.stpbk_dtl where (status='P' or status='S') and nodok='$nodokpbk' and not exists (select nodokref from sc_tmp.stbbk_dtl where nodokref='$nodokpbk'));
			");
	}
	
	function insert_ajs_to_bbk($branch,$nodokbbk,$nama,$inputdate,$kdcabang){
		return $this->db->query("
								insert into sc_tmp.stbbk_mst
									(branch,nodok,nodokref,nik,nodoktype,nodokdate,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby)
									values
									('$branch','$nama','$nodokbbk','$nama','AJS',to_char('$inputdate'::date,'yyyy-mm-dd')::date,'$kdcabang','I','','$inputdate','$nama',null,null,null,null);

			");
	}
	
	
	function q_bbk_trx_mst_param($param3_1){
		return $this->db->query("	select * from (
		select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,z.uraian as nmstatus from sc_trx.stbbk_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}
	
	function q_bbk_trx_dtl_param($param3_2){
		return $this->db->query(" select * from (
		select a.*,b.nmbarang,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,coalesce(a.qtybbk,0) as qtybbk1,z.uraian as nmstatus,d.nodokdate from sc_trx.stbbk_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
										left outer join sc_trx.stbbk_mst d on a.nodok=d.nodok
										left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='KTSTOCK') as x
										where nodok is not null $param3_2
									order by loccode,stockcode desc");
	}
	
		/* TRX PO MST PARAMETER */
	
	function get_list_bbm($param_list_akses){
		$this->_get_query_bbm($param_list_akses);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	

	
	private function _get_query_bbm($param_list_akses){

			$this->db->select('*');
			$this->db->from('sc_trx.stbbm_mst_view');
			$this->db->where("nodok is not null $param_list_akses " );
			$this->db->order_by("nodok","desc");


		$i = 0;
	
		foreach ($this->columnbbm as $item) 
		{
			if($_POST['search']['value'])
			//($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
				$this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));

			$columnbbm[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['orderbbm']))
		{
			$this->db->order_by($columnbbm[$_POST['orderbbm']['0']['columnbbm']], $_POST['orderbbm']['0']['dir']);
		} 
		else if(isset($this->orderbbm))
		{
			$orderbbm = $this->orderbbm;
			$this->db->order_by(key($orderbbm), $orderbbm[key($orderbbm)]);
		}

	}
	

	function q_row_bbm(){
		return $this->db->query("select * from sc_trx.stbbm_mst_view order by nodok desc");
	}
	
	function q_tmp_bbm_mst_param($param){
		return $this->db->query("select * from 
									(select a.*,b.uraian as nmstatus from sc_tmp.stbbm_mst a
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM') x 
									where nodok is not null $param order by nodok desc");
	}
	
	function q_tmp_bbm_dtl_param($param){
		return $this->db->query("select * from 
									(select a.*,b.uraian as nmstatus,c.uraian as nmsatminta,d.uraian as nmsatkecil,e.nmbarang as nmbarang  from sc_tmp.stbbm_dtl a 
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM'
									left outer join sc_mst.trxtype c on a.satminta=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.mbarang e on a.kdgroup=e.kdgroup and a.kdsubgroup=e.kdsubgroup and a.stockcode=e.nodok
									) x 
									where nodok is not null $param order by nmbarang desc");
	}
	
	function q_tmp_bbm_dtlref_param($param){
		return $this->db->query("select * from 
									(select a.*,b.uraian as nmstatus,c.uraian as nmsatminta,d.uraian as nmsatkecil,e.nmbarang as nmbarang from sc_tmp.stbbm_dtlref a 
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM'
									left outer join sc_mst.trxtype c on a.satminta=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.mbarang e on a.kdgroup=e.kdgroup and a.kdsubgroup=e.kdsubgroup and a.stockcode=e.nodok
									) x 
									where nodok is not null $param  order by fromcode asc");
	}
	
	function q_trx_bbm_mst_param($param){
		return $this->db->query("select * from 
									(select a.*,b.uraian as nmstatus from sc_trx.stbbm_mst a
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM') x 
									where nodok is not null $param order by nodok desc");
	}
	
	function q_trx_bbm_dtl_param($param){
		return $this->db->query("select * from 
									(select a.*,b.uraian as nmstatus,c.uraian as nmsatminta,d.uraian as nmsatkecil,e.nmbarang as nmbarang  from sc_trx.stbbm_dtl a 
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM'
									left outer join sc_mst.trxtype c on a.satminta=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.mbarang e on a.kdgroup=e.kdgroup and a.kdsubgroup=e.kdsubgroup and a.stockcode=e.nodok
									) x 
									where nodok is not null $param order by nmbarang desc");
	}
	
	function q_trx_bbm_dtlref_param($param){
		return $this->db->query("select * from 
									(select a.*,b.uraian as nmstatus,c.uraian as nmsatminta,d.uraian as nmsatkecil,e.nmbarang as nmbarang from sc_trx.stbbm_dtlref a 
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STBBM'
									left outer join sc_mst.trxtype c on a.satminta=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.mbarang e on a.kdgroup=e.kdgroup and a.kdsubgroup=e.kdsubgroup and a.stockcode=e.nodok
									) x 
									where nodok is not null $param  order by nmbarang desc");
	}
	
	
	function q_trx_po_mst_param($param_trx_mst){
		return $this->db->query("select * from (
									select a.branch,a.nodok,a.nodokref,a.loccode,a.podate,a.kdgroupsupplier,a.kdsupplier,a.kdsubsupplier,a.kdcabangsupplier,a.pkp,a.disc1,a.disc2,a.disc3,a.disc4,a.exppn,a.ttlbrutto,
									a.ttldiskon,a.ttldpp,a.ttlppn,a.ttlnetto,a.payterm,a.keterangan,a.inputdate,a.inputby,a.updatedate,a.updateby,a.approvaldate,a.approvalby,a.hangusdate,a.hangusby,a.canceldate,a.cancelby,a.nodoktmp,a.status,a.itemtype,c.nmsupplier,
									b.nmsubsupplier,b.addsupplier,b.kdcabang,b.phone1,b.phone2,b.fax,b.email,b.ownsupplier,d.uraian as ketstatus from sc_trx.po_mst a
									left outer join sc_mst.msubsupplier b on a.kdsupplier=b.kdsupplier and a.kdsubsupplier=b.kdsubsupplier
									left outer join sc_mst.msupplier c on  a.kdgroupsupplier=c.kdgroup and a.kdsupplier=c.kdsupplier 
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='POATK') as x
									where nodok is not null  /*$param_trx_mst*/ order by nodok desc,podate desc");
	}
	
	function q_trx_po_dtl_param($param_trx_dtl){
		return $this->db->query("select * from (
									select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.nodokref,a.desc_barang,a.qtykecil,a.satkecil,a.qtyminta,a.satminta,a.qtyreceipt,a.qtyreceiptkecil,a.disc1,a.disc2,a.disc3,a.disc4,
									a.exppn,a.ttlbrutto,a.ttldiskon,a.ttldpp,a.ttlppn,a.ttlnetto,a.keterangan,a.inputdate,a.inputby,a.updatedate,a.updateby,a.approvaldate,a.approvalby,a.id,a.status,a.pkp,b.nmbarang,c.uraian as nmsatkecil,d.uraian as nmsatbesar,
									(trim(a.nodok)||trim(a.kdgroup)||trim(a.kdsubgroup)||trim(a.stockcode)) as rowselect,e.uraian as ketstatus from sc_trx.po_dtl a
									left outer join sc_mst.mbarang b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.nodok
									left outer join sc_mst.trxtype c on a.satkecil=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on a.satminta=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype e on a.status=e.kdtrx and e.jenistrx='POATK') as x where x.nodok is not null
									$param_trx_dtl");
	}
	
	function q_trx_po_dtlref_param($param_trx_dtlref){
		return $this->db->query("select * from (
								select a.branch,a.nodok,a.nik,a.nodokref,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.desc_barang,coalesce(a.qtykecil,0) as qtykecil,a.satkecil,coalesce(a.qtyminta,0) as qtyminta,a.satminta,a.status,a.keterangan,b.nmbarang,
								c.nmlengkap,c.nik_atasan,c.nik_atasan2,c.nmatasan,c.nmatasan2,c.bag_dept,c.nmdept,c.subbag_dept,c.nmsubdept,c.jabatan,c.nmjabatan,d.uraian as nmsatkecil,e.uraian as nmsatminta,
								(trim(a.nodok)||trim(a.nodokref)||trim(replace(a.nik,'.',''))||trim(a.kdgroup)||trim(a.kdsubgroup)||trim(a.stockcode)) as rowselect,f.uraian as ketstatus 
									from sc_trx.po_dtlref a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
									left outer join sc_mst.masterkaryawan c on a.nik=c.nik
									left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype e on a.satminta=e.kdtrx and e.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype f on a.status=f.kdtrx and f.jenistrx='POATK'
									) as x
									where nodok is not null $param_trx_dtlref");
	}
	
	function insert_trx_po_to_bbm($nodokref,$nama,$inputdate){
		return $this->db->query("
		insert into sc_tmp.stbbm_mst
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,
			updateby,approvaldate,approvalby,nodoktmp,status)
			(select branch,'$nama','$nodokref',loccode,'$nama',podate,'PO'::text nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,'$inputdate','$nama',null,
			null,null,null,null,'I' as status from sc_trx.po_mst where nodok='$nodokref' and (status='P' or status='S') and not exists (select nodokref from sc_tmp.stbbm_mst where nodokref='$nodokref'));

		insert into sc_tmp.stbbm_dtl
			(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,exppn,nbrutto,
			ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,
			coalesce(qtyrec,0) as qtyrec,
			coalesce(qtyreckecil,0) as qtyreckecil ,
			coalesce(qtybbm,0) as qtybbm,
			coalesce(qtybbmkecil,0) as qtybbmkecil,
			coalesce(qtyonhand,0) as qtyonhand,satminta,satkecil,
			coalesce(disc1,0) as disc1,
			coalesce(disc2,0) as disc2,
			coalesce(disc3,0) as disc3,
			coalesce(disc4,0) as disc4,exppn,
			coalesce(nbrutto,0) as nbrutto,
			coalesce(ndiskon,0) as ndiskon,
			coalesce(ndpp,0) as ndpp,
			coalesce(nppn,0) as nppn,
			coalesce(nnetto,0) as nnetto,pkp,
			coalesce(unitprice,0) as unitprice,
			coalesce(pricelist,0) as pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
			coalesce(qtybbm_tmp,0) as qtybbm_tmp ,
			coalesce(qtybbmkecil_tmp,0) as qtybbmkecil_tmp,'I' as status from 
			(select 
				a.branch,
				'$nama'::text as nodok,
				a.nodok as nodokref,
				a.loccode,
				a.kdgroup,
				a.kdsubgroup,
				a.stockcode,
				a.id,
				a.desc_barang,
				coalesce(coalesce(a.qtyminta,0)-coalesce(a.qtyreceipt,0),0) as qtyrec,
				coalesce(coalesce(a.qtykecil,0)-coalesce(a.qtyreceiptkecil,0),0) as qtyreckecil,
				0 as qtybbm,
				0 as qtybbmkecil,
				0 as qtyonhand,
				a.satminta,
				a.satkecil,
				a.disc1,
				a.disc2,
				a.disc3,
				a.disc4,
				a.exppn,
				a.ttlbrutto as nbrutto,
				a.ttldiskon as ndiskon,
				a.ttldpp as ndpp,
				a.ttlppn as nppn,
				a.ttlnetto as nnetto,
				a.pkp,
				0 as unitprice,
				0 as pricelist,
				''::text as keterangan,
				a.inputdate,
				a.inputby,
				a.updatedate,
				a.updateby,
				a.approvaldate,
				a.approvalby,
				''::text as nodoktmp,
				0 as qtybbm_tmp,
				0 as qtybbmkecil_tmp,
				status 
			from sc_trx.po_dtl a) x where status in ('S','P') and nodokref='$nodokref' and not exists (select nodokref from sc_tmp.stbbm_dtl where nodokref='$nodokref'));
			
			insert into sc_tmp.stbbm_dtlref 
				(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
				(select branch,'$nama',nodok as nodokref,nodokref as fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,(coalesce(qtyminta,0)-coalesce(qtyterima,0)) as qtyrec,(coalesce(qtykecil,0)-coalesce(qtyterima_kecil,0)) as qtyreckecil,0 as qtybbm,0 as qtybbmkecil,satminta,satkecil,
				keterangan,null as inputdate,null as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,'' as nodoktmp,null as qtybbm_tmp,null as qtybbmkecil_tmp,'I' as status
			from sc_trx.po_dtlref where nodok='$nodokref' and status in ('S','P') and not exists (select nodokref from sc_tmp.stbbm_dtlref where nodokref='$nodokref'));

			");
	}
	
	function insert_trgd_po_to_bbm($nodokref,$nama,$inputdate) {
			return $this->db->query("
			insert into sc_tmp.stbbm_mst
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status)
				(select branch,'$nama ' as nodok,nodok as nodokref,loccode_destination,inputby as nodokopr,to_char(now(),'yyyy-mm-dd')::date,'TRG' as nodoktype,0,0,0,0,'',0,0,0,0,0,'',description as keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'I' as status from sc_trx.itemtrans_mst
				where nodok='$nodokref' and status in ('S','P') and not exists (select nodokref from sc_tmp.stbbm_mst where nodokref='$nodokref'));

			insert into sc_tmp.stbbm_dtl
				(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,
				disc2,disc3,disc4,exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,
				qtybbmkecil_tmp,status)
				(select * from  
				(select a.branch,'$nama',a.nodok as nodokref,loccode_destination as loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.id,b.nmbarang as desc_barang,(coalesce(a.qty,0)-coalesce(a.qtybbm,0)) as qtyrec,(coalesce(a.qty,0)-coalesce(a.qtybbm,0)) as qtyreckecil,0 as qtybbm,0 as qtybbmkecil,a.qtyonhand,a.satkecil as satminta,a.satkecil,0,
				0,0,0,'',0,0,0,0,0,'',0,0,a.description as keterangan,a.inputdate,a.inputby,null::timestamp,null,null::timestamp,null,null,0,
				0,'I' as status from sc_trx.itemtrans_dtl a 
				left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				where a.nodok='$nodokref' and a.status in ('S','P') and not exists (select nodokref from sc_tmp.stbbm_dtl where nodokref='$nodokref')
				) as x	);");
	}
	
	function insert_ajs_in_to_bbm($branch,$loccode,$nodokref,$nama,$inputdate) {
			return $this->db->query("
			insert into sc_tmp.stbbm_mst
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status)
				values
				('$branch','$nama','$nodokref','$loccode','$nama',to_char(now(),'yyyy-mm-dd')::date,'AJS' ,0,0,0,0,'',0,0,0,0,0,'','',to_char(now(),'yyyy-mm-dd')::date,
				'$nama',null::date,null::character,null::date,null::character,null::character,'I');
				
				
				
			");
	}
	
	
}	