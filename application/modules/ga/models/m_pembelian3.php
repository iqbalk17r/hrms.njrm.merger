<?php
class M_pembelian extends CI_Model{
	var $column = array('nodok','nmsupplier','nmsubsupplier');
	var $order = array('nodok' => 'desc');
	
	var $columnpricelist = array('kdgroup','kdsubgroup','stockcode','nmbarang','pricedate');
	var $orderpricelist = array('pricedate' => 'desc');
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function q_master_branch(){
		return $this->db->query("select 
								coalesce(branch    ,'')::text as branch      ,
								coalesce(branchname,'')::text as branchname  ,
								coalesce(address   ,'')::text as address     ,
								coalesce(phone1    ,'')::text as phone1      ,
								coalesce(phone2    ,'')::text as phone2      ,
								coalesce(fax       ,'')::text as fax from sc_mst.branch where branch='MJKCNI'");
	}
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
	
	function q_trxerror($paramtrxerror){
		return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null and modul='TMPPO' $paramtrxerror");
	}
	function ins_trxerror($param1error,$param2error){
		return $this->db->query("
				delete from sc_mst.trxerror where userid is not null and modul='TMPPO' and userid='$param1error' ;
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				('$param1error',$param1error,'$param2error','','TMPPO')");
	}
	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from sc_mst.trxerror where modul='TMPPO' $paramtrxerror");
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
	function q_mstkantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
	}
	function q_scgroup(){
		return $this->db->query("select * from sc_mst.mgroup order by nmgroup");
	}
	function q_scgroup_supplier(){
		return $this->db->query("select * from sc_mst.mgroup where left(kdgroup,3)='SUP' order by nmgroup");
	}
	function q_scsubgroup(){
		return $this->db->query("select * from sc_mst.msubgroup order by nmsubgroup");
	}
	function q_scgroup_atk(){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='BRG' order by nmgroup");
	}
	function q_mstbarang_atk(){
		return $this->db->query("select * from sc_mst.mbarang where kdgroup='BRG' order by nmbarang");
	}
	function q_mstbarang_atk_param($param){
		return $this->db->query("select * from (select a.*,b.uraian as nmsatkecil from sc_mst.mbarang a
								left outer join sc_mst.trxtype b on b.jenistrx='QTYUNIT' and a.satkecil=b.kdtrx) as x
								where kdgroup='BRG' and nodok is not null $param order by nmbarang	");
	}
	function q_trxqtyunit($param1){
		return $this->db->query("select * from (select a.*,b.uraian as nmsatkecil,c.kdtrx,c.uraian as nmsatbesar from sc_mst.mapping_satuan_brg a 
			left outer join sc_mst.trxtype b on b.jenistrx='QTYUNIT' and a.satkecil=b.kdtrx
			left outer join sc_mst.trxtype c on c.jenistrx='QTYUNIT' and a.satbesar=c.kdtrx) as x where stockcode is not null $param1");
	}
	
	function q_trxqtyunit_full($param1){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='QTYUNIT' and kdtrx is not null $param1");
	}
	function q_trxqtyunit_sppb($param1){
		return $this->db->query("select * from sc_mst.trxtype where jenistrx='QTYUNIT' and kdtrx is not null $param1");
	}
	
	function q_listpembelian(){
		return $this->db->query("select * from sc_trx.po_mst_view order by nodok desc,status asc");
	}
	
	function q_listpembelian_param($param2_1){
		return $this->db->query("select * from sc_trx.po_mst_view where nodok is not null $param2_1 ");
	}
		
	function q_stkgdw_param1($param1){
		return $this->db->query("select * from (select coalesce(a.onhand,0)as onhand,a.allocated,a.tmpalloca,a.laststatus,a.lastqty,a.lastdate,a.docno,a.stockcode,a.loccode,coalesce(a.onhand,0::numeric) as conhand,a.kdgroup,a.kdsubgroup,b.nmbarang,a.satkecil,e.uraian as nmsatkecil,f.qty as qtymapkecil from sc_mst.stkgdw a 
					left outer join sc_mst.mbarang b on a.stockcode=b.nodok  and b.kdgroup=a.kdgroup  and b.kdsubgroup=a.kdsubgroup
					left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup 
					left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and b.kdsubgroup=d.kdsubgroup
					left outer join sc_mst.trxtype e on a.satkecil=e.kdtrx and e.jenistrx='QTYUNIT'
					left outer join sc_mst.mapping_satuan_brg f on a.stockcode=f.stockcode and a.kdgroup=f.kdgroup and a.kdsubgroup=f.kdsubgroup and
					a.satkecil=f.satkecil and a.satkecil=f.satbesar
					) as x
					where stockcode is not null $param1
			");
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
	
	
	private function _get_query_po()
	{
		/*$this->db->select("	
							approvalby,
							nmbarang,
							nmgroup,
							nmsubgroup,
							desc_cabang",FALSE);
			$this->db->from('sc_trx.list_po_atk');
			$this->db->order_by("inputdate","desc");
			$this->db->order_by("status","desc");*/
			$this->db->select('*');
			$this->db->from('sc_trx.po_mst_view');
			$this->db->order_by("inputdate","desc");
			$this->db->order_by("status","desc");
			

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
			//($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
				$this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));

			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

	}
	
	
	function get_list_po(){
		$this->_get_query_po();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function q_po_receipt($nodok){
		return $this->db->query("select * from (select a.*,b.nmbarang,c.nmgroup,d.nmsubgroup,e.desc_cabang from sc_trx.po_receipt a
			left outer join sc_mst.mbarang b on a.stockcode=b.nodok
			left outer join sc_mst.mgroup c on a.kdgroup=c.kdgroup
			left outer join sc_mst.msubgroup d on a.kdgroup=d.kdgroup and  a.kdsubgroup=d.kdsubgroup 
			left outer join sc_mst.kantorwilayah e on a.loccode=e.kdcabang) as x
			order by id,nodokpo");
	}
	
	
	function q_list_sppbparam($param_list_akses){
		return $this->db->query("select * from (
				select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,d.uraian as ketstatus from sc_trx.sppb_mst a 
				left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
					left outer join sc_mst.departmen b on a.bag_dept=b.kddept
					left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
					left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
					left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
					left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
					left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
				left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='KTSTOCK'
					) as x
					where nodok is not null $param_list_akses
				order by nodok desc");
	}
	
	function q_sppb_tmp_mst_param($param3_1){
		return $this->db->query("	select * from (
		select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,f.uraian as ketstatus from sc_tmp.sppb_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype f on a.status=f.kdtrx and f.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}
	
	function q_sppb_tmp_dtl_param($param1){
		return $this->db->query("select * from (
								select a.*,b.nmbarang,c.*,d.uraian as nmsatkecil,e.uraian as nmsatminta,f.uraian as ketstatus  from sc_tmp.sppb_dtl a 
								left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
								left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
								left outer join sc_mst.trxtype e on a.satminta=e.kdtrx and e.jenistrx='QTYUNIT'
								left outer join sc_mst.trxtype f on a.status=f.kdtrx and f.jenistrx='KTSTOCK') as x
								where nodok is not null $param1
								order by id asc,nodok desc
								");
	}
	
	function q_sppb_tmp_mst(){
		return $this->db->query("select a.*,c.* from sc_tmp.sppb_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
								order by nodok desc");
	}
	
	function q_sppb_tmp_dtl(){
		return $this->db->query("select a.*,b.nmbarang,c.*,d.uraian as nmsatkecil,e.uraian as nmsatminta from sc_tmp.sppb_dtl a 
								left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
								left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
								left outer join sc_mst.trxtype e on a.satminta=e.kdtrx and e.jenistrx='QTYUNIT'
								order by id asc,nodok desc");
	}
	
	function q_mapsatuan_barang_param($param){
		return $this->db->query("select * from (
								select a.*,b.uraian as desc_satkecil,c.uraian as desc_satbesar,trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim  from sc_mst.mapping_satuan_brg a
									left outer join sc_mst.trxtype b on a.satkecil=b.kdtrx and b.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype c on a.satbesar=c.kdtrx and c.jenistrx='QTYUNIT') as x
									where satkecil is not null $param");
	}
	
	function q_sppb_trx_mst_param_inputby($paraminputby){
		return $this->db->query("select * from sc_trx.sppb_mst where nodok is not null $paraminputby order by inputdate desc limit 1");
	}
	
	function q_sppb_trx_mst_param($param3_1){
		return $this->db->query("	select coalesce(trim(branch      ::text),'')  as branch      ,
											coalesce(trim(nodok       ::text),'')  as nodok       ,
											coalesce(trim(nodokref    ::text),'')  as nodokref    ,
											coalesce(trim(x.nik         ::text),'')  as nik         ,
											coalesce(trim(loccode     ::text),'')  as loccode     ,
											coalesce(trim(status      ::text),'')  as status      ,
											coalesce(trim(keterangan  ::text),'')  as keterangan  ,
											coalesce(trim(inputdate   ::text),'')  as inputdate   ,
											coalesce(trim(inputby     ::text),'')  as inputby     ,
											coalesce(trim(updatedate  ::text),'')  as updatedate  ,
											coalesce(trim(updateby    ::text),'')  as updateby    ,
											coalesce(trim(approvaldate::text),'')  as approvaldate,
											coalesce(trim(approvalby  ::text),'')  as approvalby  ,
											coalesce(trim(nodoktmp    ::text),'')  as nodoktmp    ,
											coalesce(trim(hangusdate  ::text),'')  as hangusdate  ,
											coalesce(trim(hangusby    ::text),'')  as hangusby    ,
											coalesce(trim(canceldate  ::text),'')  as canceldate  ,
											coalesce(trim(cancelby    ::text),'')  as cancelby    ,
											coalesce(trim(nmlengkap   ::text),'')  as nmlengkap   ,
											coalesce(trim(bag_dept    ::text),'')  as bag_dept    ,
											coalesce(trim(subbag_dept ::text),'')  as subbag_dept ,
											coalesce(trim(jabatan     ::text),'')  as jabatan     ,
											coalesce(trim(lvl_jabatan ::text),'')  as lvl_jabatan ,
											coalesce(trim(nik_atasan  ::text),'')  as nik_atasan  ,
											coalesce(trim(nik_atasan2 ::text),'')  as nik_atasan2 ,
											coalesce(trim(nmdept      ::text),'')  as nmdept      ,
											coalesce(trim(nmsubdept   ::text),'')  as nmsubdept   ,
											coalesce(trim(nmlvljabatan::text),'')  as nmlvljabatan,
											coalesce(trim(nmjabatan   ::text),'')  as nmjabatan   ,
											coalesce(trim(nmatasan    ::text),'')  as nmatasan    ,
											coalesce(trim(nmatasan2   ::text),'')  as nmatasan2   ,
											coalesce(trim(ketstatus   ::text),'')  as ketstatus    from (
								select a.*,c.nmlengkap,c.bag_dept,c.subbag_dept,c.jabatan,c.lvl_jabatan,c.nik_atasan,c.nik_atasan2,c.nmdept,c.nmsubdept,c.nmlvljabatan,c.nmjabatan,c.nmatasan,c.nmatasan2,f.uraian as ketstatus from sc_trx.sppb_mst a 
								left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype f on a.status=f.kdtrx and f.jenistrx='KTSTOCK') as x 
									where nodok is not null $param3_1
								order by nodok desc");
	}

	function q_sppb_trx_dtl_param($param1){
		return $this->db->query("select coalesce(trim(branch      ::text),'') as  branch      ,        
											coalesce(trim(nodok       ::text),'') as  nodok       ,        
											coalesce(trim(niksppb         ::text),'') as  nik         ,        
											coalesce(trim(kdgroup     ::text),'') as  kdgroup     ,        
											coalesce(trim(kdsubgroup  ::text),'') as  kdsubgroup  ,        
											coalesce(trim(stockcode   ::text),'') as  stockcode   ,        
											coalesce(trim(loccode     ::text),'') as  loccode     ,        
											coalesce(trim(desc_barang ::text),'') as  desc_barang ,        
											coalesce(trim(qtysppbkecil::text),'') as  qtysppbkecil,        
											coalesce(trim(qtysppbminta::text),'') as  qtysppbminta,        
											coalesce(trim(qtyrefonhand::text),'') as  qtyrefonhand,        
											coalesce(trim(qtypo       ::text),'') as  qtypo       ,        
											coalesce(trim(qtypokecil  ::text),'') as  qtypokecil  ,        
											coalesce(trim(qtybbm      ::text),'') as  qtybbm      ,        
											coalesce(trim(qtybbmkecil ::text),'') as  qtybbmkecil ,        
											coalesce(trim(status      ::text),'') as  status      ,        
											coalesce(trim(satkecil    ::text),'') as  satkecil    ,        
											coalesce(trim(satminta    ::text),'') as  satminta    ,        
											coalesce(trim(keterangan  ::text),'') as  keterangan  ,        
											coalesce(trim(inputdate   ::text),'') as  inputdate   ,        
											coalesce(trim(inputby     ::text),'') as  inputby     ,        
											coalesce(trim(updatedate  ::text),'') as  updatedate  ,        
											coalesce(trim(updateby    ::text),'') as  updateby    ,        
											coalesce(trim(approvaldate::text),'') as  approvaldate,        
											coalesce(trim(approvalby  ::text),'') as  approvalby  ,        
											coalesce(trim(nodokref    ::text),'') as  nodokref    ,        
											coalesce(trim(nodoktmp    ::text),'') as  nodoktmp    ,        
											coalesce(trim(fromstock   ::text),'') as  fromstock   ,        
											coalesce(trim(id          ::text),'') as  id          ,        
											coalesce(trim(nmbarang    ::text),'') as  nmbarang    ,        
											coalesce(trim(nmlengkap   ::text),'') as  nmlengkap   ,        
											coalesce(trim(bag_dept    ::text),'') as  bag_dept    ,        
											coalesce(trim(subbag_dept ::text),'') as  subbag_dept ,        
											coalesce(trim(jabatan     ::text),'') as  jabatan     ,        
											coalesce(trim(lvl_jabatan ::text),'') as  lvl_jabatan ,        
											coalesce(trim(nik_atasan  ::text),'') as  nik_atasan  ,        
											coalesce(trim(nik_atasan2 ::text),'') as  nik_atasan2 ,        
											coalesce(trim(nmdept      ::text),'') as  nmdept      ,        
											coalesce(trim(nmsubdept   ::text),'') as  nmsubdept   ,        
											coalesce(trim(nmlvljabatan::text),'') as  nmlvljabatan,        
											coalesce(trim(nmjabatan   ::text),'') as  nmjabatan   ,        
											coalesce(trim(nmatasan    ::text),'') as  nmatasan    ,        
											coalesce(trim(nmatasan2   ::text),'') as  nmatasan2   ,        
											coalesce(trim(nmsatkecil  ::text),'') as  nmsatkecil  ,        
											coalesce(trim(nmsatminta  ::text),'') as  nmsatminta  ,        
											coalesce(trim(ketstatus   ::text),'') as  ketstatus    from (
									select a.*,b.nmbarang,c.*,a.nik as niksppb,d.uraian as nmsatkecil,e.uraian as nmsatminta,f.uraian as ketstatus  from sc_trx.sppb_dtl a 
									left outer join sc_mst.mbarang b on a.stockcode=b.nodok 
									left outer join (select a.nik,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.lvl_jabatan,a.nik_atasan,a.nik_atasan2,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik) c on a.nik=c.nik
									left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype e on a.satminta=e.kdtrx and e.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype f on a.status=f.kdtrx and f.jenistrx='KTSTOCK') as x
									where nodok is not null $param1
								order by id asc,nodok desc
								");
	}
	
	function q_tmp_po_mst(){
		return $this->db->query("select branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,status,totalprice,keterangan,inputdate,inputby,updatedate,updateby,
								approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp from sc_tmp.po_mst order by nodok desc,podate desc");
	}
	
	function q_tmp_po_dtl(){
		return $this->db->query("select branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtykecil,0) as qtykecil,satkecil,coalesce(qtyminta,0) as qtyminta,satminta,coalesce(qtyunitprice,0) as qtyunitprice,coalesce(qtytotalprice,0) as qtytotalprice,
								qtyreceipt,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby from sc_tmp.po_dtl");
	}
	
	function q_tmp_po_dtlref(){
		return $this->db->query("select branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,loccode,coalesce(qtykecil,0) as qtykecil,satkecil,coalesce(qtyminta,0) as qtyminta,satminta,status,keterangan
								from sc_tmp.po_dtlref");
	}
	
	function q_tmp_po_mst_param($param_tmp_mst){
		return $this->db->query("select * from (select a.branch,a.nodok,a.nodokref,a.loccode,a.podate,a.kdgroupsupplier,a.kdsupplier,a.kdsubsupplier,a.kdcabangsupplier,a.pkp,a.exppn,
									coalesce(a.disc1,0) as disc1,
									coalesce(a.disc2,0) as disc2,
									coalesce(a.disc3,0) as disc3,
									coalesce(a.disc4,0) as disc4,
									coalesce(a.ttlbrutto,0) as ttlbrutto,
									coalesce(a.ttldiskon,0) as ttldiskon,
									coalesce(a.ttldpp,0) as ttldpp,
									coalesce(a.ttlppn,0) as ttlppn,
									coalesce(a.ttlnetto,0) as ttlnetto,
									coalesce(a.payterm,0) as payterm,
									a.keterangan,a.inputdate,a.inputby,a.updatedate,a.updateby,a.approvaldate,a.approvalby,a.hangusdate,
									a.hangusby,a.canceldate,a.cancelby,a.nodoktmp,a.status,c.nmsupplier,b.nmsubsupplier,b.addsupplier,b.kdcabang,b.phone1,b.phone2,b.fax,b.email,b.ownsupplier,d.uraian as ketstatus from sc_tmp.po_mst a
									left outer join sc_mst.msubsupplier b on a.kdsupplier=b.kdsupplier and a.kdsubsupplier=b.kdsubsupplier
									left outer join sc_mst.msupplier c on  a.kdgroupsupplier=c.kdgroup and a.kdsupplier=c.kdsupplier 
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='POATK') as x
									where nodok is not null $param_tmp_mst order by nodok desc,podate desc");
	}
	
	function q_tmp_po_dtl_param($param_tmp_dtl){
		return $this->db->query("select * from (
									select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.nodokref,a.desc_barang,coalesce(a.qtykecil,0) as qtykecil,a.satkecil,coalesce(a.qtyminta,0) as qtyminta,
									a.satminta,coalesce(a.qtyreceipt,0) as qtyreceipt,coalesce(a.qtyreceiptkecil,0) as qtyreceiptkecil,
									coalesce(a.disc1,0) as disc1,
									coalesce(a.disc2,0) as disc2,
									coalesce(a.disc3,0) as disc3,
									coalesce(a.disc4,0) as disc4,
									exppn,
									coalesce(round(a.ttlbrutto),0) as ttlbrutto,
									coalesce(round(a.ttldiskon),0) as ttldiskon,coalesce(round(a.ttldpp),0) as ttldpp,coalesce(round(a.ttlppn),0) as ttlppn,coalesce(round(a.ttlnetto),0) as ttlnetto,
									a.keterangan,a.inputdate,a.inputby,a.updatedate,a.updateby,a.approvaldate,a.approvalby,a.status,a.id,b.nmbarang,c.uraian as nmsatkecil,d.uraian as nmsatbesar,e.uraian as ketstatus,coalesce(round(a.unitprice,2),0) as unitprice from sc_tmp.po_dtl a
									left outer join sc_mst.mbarang b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.nodok
									left outer join sc_mst.trxtype c on a.satkecil=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on a.satminta=d.kdtrx and d.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype e on a.status=e.kdtrx and e.jenistrx='POATK') as x where x.nodok is not null
									$param_tmp_dtl order by id asc");
	}
	
	function q_tmp_po_dtlref_param($param_tmp_dtlref){
		return $this->db->query("select * from (
									select a.branch,a.nodok,a.nodokref,a.nik,a.kdgroup,a.kdsubgroup,a.stockcode,a.id,a.loccode,a.desc_barang,coalesce(a.qtykecil,0) as qtykecil,a.satkecil,coalesce(a.qtyminta,0) as qtyminta,a.satminta,a.keterangan,coalesce(a.qtyminta_tmp,0) as qtyminta_tmp,coalesce(a.qtyminta_tmp_kecil,0) as qtyminta_tmp_kecil,
									coalesce(a.qtyterima,0) as qtyterima,coalesce(a.qtyterima_kecil,0) as qtyterima_kecil,a.status,b.nmbarang,
									c.nmlengkap,c.nik_atasan,c.nik_atasan2,c.nmatasan,c.nmatasan2,c.bag_dept,c.nmdept,c.subbag_dept,c.nmsubdept,c.jabatan,c.nmjabatan,d.uraian as nmsatkecil,e.uraian as nmsatminta,row_number() over (order by a.nodok,a.stockcode desc) as rowid,b.satkecil as satkecilmaster,e.uraian as ketstatus,trim(a.nodokref)||trim(a.nik)||trim(a.desc_barang)  as strtrimref
										from sc_tmp.po_dtlref a 
										left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
										left outer join sc_mst.masterkaryawan c on a.nik=c.nik
										left outer join sc_mst.trxtype d on a.satkecil=d.kdtrx and d.jenistrx='QTYUNIT'
										left outer join sc_mst.trxtype e on a.satminta=e.kdtrx and e.jenistrx='QTYUNIT'
										left outer join sc_mst.trxtype f on a.status=f.kdtrx and f.jenistrx='POATK'
										) as x
										where nodok is not null $param_tmp_dtlref order by nodok,stockcode,rowid asc ");
	}
	
	function q_dtlref_po_query_param($param_dtlref_query){
		return $this->db->query("select * from (
									select branch,nodok,x.nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,(coalesce(qtyminta,0)-coalesce(qtypo,0)) as qtyminta,qtybbk as qtyterima,qtyonhand,satkecil,satminta,status,keterangan,inputdate,inputby,qtypo,strtrimref,row_number() over (order by inputdate desc,nodok desc) as rowid,b.nmlengkap,b.nik_atasan,b.nik_atasan2,b.nmatasan,b.nmatasan2,b.bag_dept,b.nmdept,b.subbag_dept,b.nmsubdept,b.jabatan,b.nmjabatan,id,c.uraian as nmsatkecil,d.uraian as nmsatminta from (
									select a.branch,a.nodok,a.nik,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.desc_barang,coalesce(a.qtypbk,0)-coalesce(a.qtybbk,0) as qtyminta,coalesce(a.qtybbk,0) as qtybbk,a.qtyonhand,b.satkecil,b.satkecil as satminta,a.status,a.keterangan,a.inputdate,a.inputby,coalesce(a.qtypo,0) as qtypo,trim(nodok)||trim(nik)||trim(desc_barang)  as strtrimref,id from sc_trx.stpbk_dtl a
										left outer join sc_mst.stkgdw b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.loccode=b.loccode
										where a.status in ('P','S')
										union all
										select branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtysppbminta,0) as qtyminta,coalesce(qtypo,0) as qtypo,qtyrefonhand,satkecil,satminta,status,keterangan,inputdate,inputby,coalesce(qtypo,0) qtypo,trim(nodok)||trim(nik)||trim(desc_barang)  as strtrimref,id from sc_trx.sppb_dtl where status in('P','S')) as x
									left outer join sc_mst.masterkaryawan b on x.nik=b.nik
									left outer join sc_mst.trxtype c on x.satkecil=c.kdtrx and c.jenistrx='QTYUNIT'
									left outer join sc_mst.trxtype d on x.satminta=d.kdtrx and d.jenistrx='QTYUNIT'
									where coalesce(qtypo,0)<coalesce(qtyminta,0) and trim(nodok)||trim(x.nik)||trim(desc_barang) not in
									(select trim(nodokref)||trim(x.nik)||trim(desc_barang) as strtrimref  from sc_tmp.po_dtlref where nodok is not null) 
									) as a where nodok is not null $param_dtlref_query order by rowid asc");
		}
	
	function q_dtlref_po_query_param_null($param_dtlref_query){
		return $this->db->query("select * from (select x.*,trim(trim(x.nodok)||trim(replace(x.nik,'.',''))||trim(x.desc_barang)) as strtrimref,(coalesce(x.qtyminta,0)-coalesce(x.qtypo,0)) as qtysumpo,b.nmlengkap,b.nik_atasan,b.nik_atasan2,b.nmatasan,b.nmatasan2,b.bag_dept,b.nmdept,b.subbag_dept,b.nmsubdept,b.jabatan,b.nmjabatan from (
									select branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk as qtyminta,qtybbk as qtyterima,qtyonhand,satkecil,satminta,status,keterangan,inputdate,inputby,qtypo,row_number() over (order by inputdate desc,nodok desc) as rowid from (
									select a.branch,a.nodok,a.nik,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.desc_barang,a.qtypbk,a.qtybbk,a.qtyonhand,b.satkecil,b.satkecil as satminta,a.status,a.keterangan,a.inputdate,a.inputby,a.qtypo from sc_trx.stpbk_dtl a
										left outer join sc_mst.stkgdw b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.loccode=b.loccode
										where status='P'
										union all
										select branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbminta,qtypo,qtyrefonhand,satkecil,satminta,status,keterangan,inputdate,inputby,qtypo from sc_trx.sppb_dtl where status='P') as x
									) as x 
									left outer join sc_mst.masterkaryawan b on x.nik=b.nik) as y
									where nodok is not null  and trim(nodok)||trim(nik)||trim(desc_barang) not in (
									select strtrimref from 
										(select trim(nodokref)||trim(nik)||trim(desc_barang) as strtrimref from sc_tmp.po_dtlref where nodok is not null
										union all
										select trim(nodokref)||trim(nik)||trim(desc_barang)  as strtrimref from sc_trx.po_dtlref where nodok is not null) as x
										where  strtrimref is not null $param_dtlref_query) $param_dtlref_query
									order by inputdate desc,nodok desc");
										}
	
	function q_dtlref_po_query_paramdua($param_dtlref_query){
		return $this->db->query("select * from (select x.*,trim(trim(x.nodok)||trim(replace(x.nik,'.',''))||trim(x.desc_barang)) as strtrimref,(coalesce(x.qtyminta,0)-coalesce(x.qtypo,0)) as qtysumpo,b.nmlengkap,b.nik_atasan,b.nik_atasan2,b.nmatasan,b.nmatasan2,b.bag_dept,b.nmdept,b.subbag_dept,b.nmsubdept,b.jabatan,b.nmjabatan from (
								select branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk as qtyminta,qtybbk as qtyterima,qtyonhand,satkecil,satminta,status,keterangan,inputdate,inputby,qtypo,row_number() over (order by inputdate desc,nodok desc) as rowid from (
								select a.branch,a.nodok,a.nik,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.desc_barang,a.qtypbk,a.qtybbk,a.qtyonhand,b.satkecil,b.satkecil as satminta,a.status,a.keterangan,a.inputdate,a.inputby,a.qtypo from sc_trx.stpbk_dtl a
									left outer join sc_mst.stkgdw b on a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.loccode=b.loccode
									where status='P'
									union all
									select branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbminta,qtypo,qtyrefonhand,satkecil,satminta,status,keterangan,inputdate,inputby,qtypo from sc_trx.sppb_dtl where status='P') as x
								) as x 
								left outer join sc_mst.masterkaryawan b on x.nik=b.nik) as y
								where nodok is not null  and trim(nodok)||trim(nik)||trim(desc_barang) not in (
								select strtrimref from 
									(select trim(nodokref)||trim(nik)||trim(desc_barang) as strtrimref from sc_tmp.po_dtlref where nodok is not null
									union all
									select trim(nodokref)||trim(nik)||trim(desc_barang)  as strtrimref from sc_trx.po_dtlref where nodok is not null) as x
									where  strtrimref is not null $param_dtlref_query) $param_dtlref_query
								order by inputdate desc,nodok desc");
	}
	
	function add_po_dtlref($data = array()){
        $insert = $this->db->insert_batch('sc_tmp.po_dtlref',$data);
        return $insert?true:false;
    }
	
	function q_trx_po_mst_param($param_trx_mst){
		return $this->db->query("select coalesce(trim(branch          ::text),'') as  	branch          ,
										coalesce(trim(nodok           ::text),'') as  	nodok           ,
										coalesce(trim(nodokref        ::text),'') as  	nodokref        ,
										coalesce(trim(loccode         ::text),'') as  	loccode         ,
										coalesce(trim(podate          ::text),'') as  	podate          ,
										coalesce(trim(kdgroupsupplier ::text),'') as  	kdgroupsupplier ,
										coalesce(trim(kdsupplier      ::text),'') as  	kdsupplier      ,
										coalesce(trim(kdsubsupplier   ::text),'') as  	kdsubsupplier   ,
										coalesce(trim(kdcabangsupplier::text),'') as  	kdcabangsupplier,
										coalesce(trim(pkp             ::text),'') as  	pkp             ,
										coalesce(trim(disc1           ::text),'') as  	disc1           ,
										coalesce(trim(disc2           ::text),'') as  	disc2           ,
										coalesce(trim(disc3           ::text),'') as  	disc3           ,
										coalesce(trim(disc4           ::text),'') as  	disc4           ,
										coalesce(trim(exppn           ::text),'') as  	exppn           ,
										coalesce(trim(ttlbrutto       ::text),'') as  	ttlbrutto       ,
										coalesce(trim(ttldiskon       ::text),'') as  	ttldiskon       ,
										coalesce(trim(ttldpp          ::text),'') as  	ttldpp          ,
										coalesce(trim(ttlppn          ::text),'') as  	ttlppn          ,
										coalesce(trim(ttlnetto        ::text),'') as  	ttlnetto        ,
										coalesce(trim(payterm         ::text),'') as  	payterm         ,
										coalesce(trim(keterangan      ::text),'') as  	keterangan      ,
										coalesce(trim(inputdate       ::text),'') as  	inputdate       ,
										coalesce(trim(inputby         ::text),'') as  	inputby         ,
										coalesce(trim(updatedate      ::text),'') as  	updatedate      ,
										coalesce(trim(updateby        ::text),'') as  	updateby        ,
										coalesce(trim(approvaldate    ::text),'') as  	approvaldate    ,
										coalesce(trim(approvalby      ::text),'') as  	approvalby      ,
										coalesce(trim(hangusdate      ::text),'') as  	hangusdate      ,
										coalesce(trim(hangusby        ::text),'') as  	hangusby        ,
										coalesce(trim(canceldate      ::text),'') as  	canceldate      ,
										coalesce(trim(cancelby        ::text),'') as  	cancelby        ,
										coalesce(trim(nodoktmp        ::text),'') as  	nodoktmp        ,
										coalesce(trim(status          ::text),'') as  	status          ,
										coalesce(trim(nmsupplier      ::text),'') as  	nmsupplier      ,
										coalesce(trim(nmsubsupplier   ::text),'') as  	nmsubsupplier   ,
										coalesce(trim(addsupplier     ::text),'') as  	addsupplier     ,
										coalesce(trim(kdcabang        ::text),'') as  	kdcabang        ,
										coalesce(trim(phone1          ::text),'') as  	phone1          ,
										coalesce(trim(phone2          ::text),'') as  	phone2          ,
										coalesce(trim(fax             ::text),'') as  	fax             ,
										coalesce(trim(email           ::text),'') as  	email           ,
										coalesce(trim(ownsupplier     ::text),'') as  	ownsupplier     ,
										coalesce(trim(ketstatus       ::text),'') as  	ketstatus        from (
									select a.branch,a.nodok,a.nodokref,a.loccode,a.podate,a.kdgroupsupplier,a.kdsupplier,a.kdsubsupplier,a.kdcabangsupplier,a.pkp,a.disc1,a.disc2,a.disc3,a.disc4,a.exppn,a.ttlbrutto,
									a.ttldiskon,a.ttldpp,a.ttlppn,a.ttlnetto,a.payterm,a.keterangan,a.inputdate,a.inputby,a.updatedate,a.updateby,a.approvaldate,a.approvalby,a.hangusdate,a.hangusby,a.canceldate,a.cancelby,a.nodoktmp,a.status,c.nmsupplier,
									b.nmsubsupplier,b.addsupplier,b.kdcabang,b.phone1,b.phone2,b.fax,b.email,b.ownsupplier,d.uraian as ketstatus from sc_trx.po_mst a
									left outer join sc_mst.msubsupplier b on a.kdsupplier=b.kdsupplier and a.kdsubsupplier=b.kdsubsupplier
									left outer join sc_mst.msupplier c on  a.kdgroupsupplier=c.kdgroup and a.kdsupplier=c.kdsupplier 
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='POATK') as x
									where nodok is not null  $param_trx_mst order by nodok desc,podate desc");
	}
	
	function q_trx_po_dtl_param($param_trx_dtl){
		return $this->db->query("select coalesce(trim(branch         ::text),'') as  branch         ,  
										coalesce(trim(nodok          ::text),'') as  nodok          ,  
										coalesce(trim(kdgroup        ::text),'') as  kdgroup        ,  
										coalesce(trim(kdsubgroup     ::text),'') as  kdsubgroup     ,  
										coalesce(trim(stockcode      ::text),'') as  stockcode      ,  
										coalesce(trim(loccode        ::text),'') as  loccode        ,  
										coalesce(trim(nodokref       ::text),'') as  nodokref       ,  
										coalesce(trim(desc_barang    ::text),'') as  desc_barang    ,  
										coalesce(trim(qtykecil       ::text),'') as  qtykecil       ,  
										coalesce(trim(satkecil       ::text),'') as  satkecil       ,  
										coalesce(trim(qtyminta       ::text),'') as  qtyminta       ,  
										coalesce(trim(satminta       ::text),'') as  satminta       ,  
										coalesce(trim(qtyreceipt     ::text),'') as  qtyreceipt     ,  
										coalesce(trim(qtyreceiptkecil::text),'') as  qtyreceiptkecil,  
										coalesce(trim(disc1          ::text),'') as  disc1          ,  
										coalesce(trim(disc2          ::text),'') as  disc2          ,  
										coalesce(trim(disc3          ::text),'') as  disc3          ,  
										coalesce(trim(disc4          ::text),'') as  disc4          ,  
										coalesce(trim(exppn          ::text),'') as  exppn          ,  
										coalesce(trim(ttlbrutto      ::text),'') as  ttlbrutto      ,  
										coalesce(trim(ttldiskon      ::text),'') as  ttldiskon      ,  
										coalesce(trim(ttldpp         ::text),'') as  ttldpp         ,  
										coalesce(trim(ttlppn         ::text),'') as  ttlppn         ,  
										coalesce(trim(ttlnetto       ::text),'') as  ttlnetto       ,  
										coalesce(trim(keterangan     ::text),'') as  keterangan     ,  
										coalesce(trim(inputdate      ::text),'') as  inputdate      ,  
										coalesce(trim(inputby        ::text),'') as  inputby        ,  
										coalesce(trim(updatedate     ::text),'') as  updatedate     ,  
										coalesce(trim(updateby       ::text),'') as  updateby       ,  
										coalesce(trim(approvaldate   ::text),'') as  approvaldate   ,  
										coalesce(trim(approvalby     ::text),'') as  approvalby     ,  
										coalesce(trim(id             ::text),'') as  id             ,  
										coalesce(trim(status         ::text),'') as  status         ,  
										coalesce(trim(pkp            ::text),'') as  pkp            ,  
										coalesce(trim(nmbarang       ::text),'') as  nmbarang       ,  
										coalesce(trim(nmsatkecil     ::text),'') as  nmsatkecil     ,  
										coalesce(trim(nmsatbesar     ::text),'') as  nmsatbesar     ,  
										coalesce(trim(rowselect      ::text),'') as  rowselect      ,  
										coalesce(trim(ketstatus      ::text),'') as  ketstatus      ,  
										coalesce(trim(unitprice      ::text),'') as  unitprice      from (
									select a.branch,a.nodok,a.kdgroup,a.kdsubgroup,a.stockcode,a.loccode,a.nodokref,a.desc_barang,a.qtykecil,a.satkecil,a.qtyminta,a.satminta,a.qtyreceipt,a.qtyreceiptkecil,a.disc1,a.disc2,a.disc3,a.disc4,
									a.exppn,a.ttlbrutto,a.ttldiskon,a.ttldpp,a.ttlppn,a.ttlnetto::numeric(18,2),a.keterangan,a.inputdate,a.inputby,a.updatedate,a.updateby,a.approvaldate,a.approvalby,a.id,a.status,a.pkp,b.nmbarang,c.uraian as nmsatkecil,d.uraian as nmsatbesar,
									(trim(a.nodok)||trim(a.kdgroup)||trim(a.kdsubgroup)||trim(a.stockcode)) as rowselect,e.uraian as ketstatus,coalesce(round(a.unitprice),0)::numeric(18,2) as unitprice  from sc_trx.po_dtl a
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
	
	private function _get_query_pricelist(){

			$this->db->select('*');
			$this->db->from('sc_mst.v_pricelist');
			$this->db->order_by("pricedate","desc");


		$i = 0;
	
		foreach ($this->columnpricelist as $item) 
		{
			if($_POST['search']['value'])
			//($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
				$this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));

			$columnpricelist[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['orderpricelist']))
		{
			$this->db->order_by($columnpricelist[$_POST['orderpricelist']['0']['columnpricelist']], $_POST['orderpricelist']['0']['dir']);
		} 
		else if(isset($this->orderpricelist))
		{
			$orderpricelist = $this->orderpricelist;
			$this->db->order_by(key($orderpricelist), $orderpricelist[key($orderpricelist)]);
		}

	}
	
	function get_list_pricelist(){
		$this->_get_query_pricelist();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function q_listpricelist(){
		return $this->db->query("select * from sc_mst.v_pricelist order by pricedate desc");
	}
	
	function q_pricelist_param($param){
		return $this->db->query("select * from sc_mst.v_pricelist where id is not null $param order by pricedate desc");
	}
	
}	