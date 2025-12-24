<?php
class M_cr_sj extends CI_Model{
	var $columntwinmst = array('fc_trxno');
	var $ordertwinmst = array('fc_trxno' => 'desc','fd_entrydate' => 'desc');
	
	var $columntwpomst = array('fc_pono','Status','fv_suppname','podate');
	var $ordertwpomst = array('fc_pono' => 'desc','fd_podate' => 'desc');
	/* RENEWAL DATABASE */
	private $d_transaksi,$d_temporary;
	
	public function __construct() {
		parent::__construct();
	   // $this->load->database();
	   // $this->d_transaksi = $this->load->database('d_transaksi', TRUE);
	   // $this->d_temporary = $this->load->database('d_temporary', TRUE);
	}
	
	
	function q_trxerror($param){
		return $this->db->query("SELECT * FROM 
									(SELECT A.*,B.FT_DESCREIPTION AS DESKRIPSI FROM SC_MST.T_TRXERROR A
									LEFT OUTER JOIN SC_MST.T_ERROR B ON A.FC_ERRORCODE=B.FC_ERRORCODE) AS A
									WHERE FC_USERID IS NOT NULL	 $param");
	}
	
	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from SC_MST.T_TRXERROR where FC_USERID IS NOT NULL $paramtrxerror");
	}

	function q_branch(){
		$param=" and fc_default='Yes'";
		return $this->db->query("select * from sc_mst.t_cabang where fc_branch is not null $param");
	}
	
	function q_branch_setup(){
		$param=" and fc_default='Yes'";
		return $this->db->query("select * from (
								select a.fc_branch,a.fv_value as fv_name,
								b.fv_value as fv_add1,
								c.fv_value as fv_add2,
								d.fv_value as fv_city,
								e.fv_value as fv_manager,
								f.fv_value as fv_npwp,
								g.fv_value as fv_telp,
								h.fv_value as fv_pkpdate
								from sc_mst.t_setup a
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch add1' ) b on a.fc_branch=b.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch add2' ) c on a.fc_branch=c.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch city' ) d on a.fc_branch=d.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch manager' ) e on a.fc_branch=e.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch npwp' ) f on a.fc_branch=f.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch telp' ) g on a.fc_branch=g.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch tgl pkp' ) h on a.fc_branch=h.fc_branch
								where left(a.fv_parameter,6)='branch' and a.fv_parameter='branch name') as x
								where fc_branch is not null $param ");
	}
	
	
	
	function q_expedisi(){
		return $this->db->query("select * from SC_MST.T_EXPEDISI ORDER BY 
		fv_expdname ASC");
	}
	
	function q_gudang(){
		return $this->db->query("select * from SC_MST.T_GUDANG ORDER BY FC_LOCANAME ASC");
	}
	
	function q_trans_inmst($param){
		return $this->db->query("SELECT FC_BRANCH    ,
													fc_trxno     ,
													FD_ENTRYDATE ,
													FC_OPERATOR  ,
													FC_STATUS    ,
													FC_LOCCODE   ,
													FC_FROM      ,
													FC_FROMNO    ,
													FV_REFERENCE ,
													FD_REFTGL    ,
													FC_FROMCODE  ,
													FN_ITEM      ,
													FM_NETTO     ,
													FM_DPP       ,
													FM_PPN       ,
													FM_VALUESTOCK,
													FD_UPDATEDATE,
													FC_REASON    ,
													FC_USERUPD   ,
													FT_NOTE      ,
													FN_PPN       ,
													FC_IDBU      ,
													FC_TRFWH     ,
													FC_HUBRK     ,
													FD_TGLCONF   ,
													FC_USERCONF  ,
													FN_PPH22     ,
													FM_TTLPPH22  ,
													FC_STATUSGNT FROM SC_TRX.T_INMST WHERE fc_trxno IS NOT NULL $param ");
	}
	
	
	private function _get_q_transaksi_T_INMST_WEB($param_list_akses){

			$this->db->select('*');
			$this->db->from("sc_trx.vw_t_inmst_web");
			$this->db->where("fc_trxno is not null $param_list_akses " );
			//$this->db->order_by("fc_trxno","desc");


		$i = 0;
	
		foreach ($this->columntwinmst as $item) 
		{
			if($_POST['search']['value'])
			//($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
				$this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));

			$columntwinmst[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['ordertwinmst']))
		{
			$this->db->order_by($columntwinmst[$_POST['ordertwinmst']['0']['columntwinmst']], $_POST['ordertwinmst']['0']['dir']);
		} 
		else if(isset($this->ordertwinmst))
		{
			$ordertwinmst = $this->ordertwinmst;
			$this->db->order_by(key($ordertwinmst), $ordertwinmst[key($ordertwinmst)]);
		//	$this->db->order_by(key($ordertwinmst), $ordertwinmst[key($ordertwinmst)]);
		}

	}
	
	function get_transaksi_T_INMST_WEB($param_list_akses){
		$this->_get_q_transaksi_T_INMST_WEB($param_list_akses);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function q_row_transaksi_T_INMST_WEB($param){
		return $this->db->query(" select *  from SC_TRX.VW_T_INMST_WEB  where fc_trxno IS NOT NULL$param ");
	}
	/*		TRANSAKSI & TEMPORARY 		*/
	function q_d_transaksi_vw_T_INMST_WEB($param){
		return $this->db->query(" select *  from SC_TRX.VW_T_INMST_WEB  where fc_trxno IS NOT NULL $param");
	}
	function q_d_transaksi_vw_T_INDTL_WEB($param){
		return $this->db->query(" select *  from SC_TRX.VW_T_INDTL_WEB  where fc_trxno IS NOT NULL $param");
	}
	function q_d_transaksi_vw_T_INDTL_WEB_PRINT($param){
		return $this->db->query(" select FN_NOMOR,STOCKNAME,PACKNAME,FN_QTY,FN_QTYREC,FN_EXTRA,FN_EXTRAREC  
									from SC_TRX.VW_T_INDTL_WEB where fc_trxno IS NOT NULL $param");
	}
	
	
	function q_d_temporary_vw_T_INMST_WEB($param){
		return $this->db->query(" select *  from SC_TMP.VW_T_INMST_WEB  where fc_trxno IS NOT NULL $param");
	}
	function q_d_temporary_vw_T_INDTL_WEB($param){
		return $this->db->query(" select *  from SC_TMP.VW_T_INDTL_WEB  where fc_trxno IS NOT NULL $param");
	}
	function q_d_temporary_vw_T_INDTL_WEB_SUMARY($param){
		return $this->db->query(" select coalesce(sum(fn_qtyrec),0) as sum_qtyrec  from SC_TMP.VW_T_INDTL_WEB  where fc_trxno IS NOT NULL $param");
	}
	
	
	function q_d_transaksi_vw_tw_pomst($param){
		return $this->db->query(" select *  from  SC_TRX.vw_t_pomst  where fc_pono IS NOT NULL $param limit 10");
	}
	function q_d_transaksi_vw_tw_podtl($param){
		return $this->db->query(" select *  from  SC_TRX.vw_t_podtl  where fc_pono IS NOT NULL $param limit 10");
	}
	
	function q_link_pono($param){
		return $this->db->query("	select * from (select a.*,trim(b.fc_potipe) as fc_potipe,b.tipe from sc_tmp.t_inmst_web a
									left outer join sc_trx.vw_t_pomst b on b.fc_pono=a.fc_fromno) as x
									where fc_trxno is not null $param");
	}
	
	function q_max_inmst_web($param){
		return $this->db->query("select max(fc_trxno) as fc_trxno from SC_TRX.t_inmst_web where fc_trxno is not null ");
	}
	function insert_pomst_to_inmst($nodok,$nama,$loccode){
		$idbu=$this->session->userdata('idbu');
		return $this->db->query("
			INSERT INTO SC_TMP.T_INMST_WEB
			(FC_BRANCH,fc_trxno,FD_ENTRYDATE,FC_OPERATOR,FC_STATUS,FC_LOCCODE,
			FC_FROM,FC_FROMNO,FV_REFERENCE,FD_REFTGL,FC_FROMCODE,FN_ITEM,FM_NETTO,FM_DPP,FM_PPN,FM_VALUESTOCK,
			FD_UPDATEDATE,FC_REASON,FC_USERUPD,FT_NOTE,FN_PPN,FC_IDBU,FC_TRFWH,FC_HUBRK,FD_TGLCONF,FC_USERCONF,FN_PPH22,FM_TTLPPH22,FC_STATUSGNT)
			(SELECT 
			FC_BRANCH,'$nama',to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,'$nama' AS FC_OPERATOR,'I',fc_shipto,
			1,fc_pono AS FC_FROMNO,NULL AS FV_REFERENCE,NULL AS FD_REFTGL,FC_SUPPCODE AS FC_FROMCODE,FN_ITEMPO AS FN_ITEM,FM_TTLNETTO,FM_TTLDPP,FM_TTLPPN,0 AS FM_VALUESTOCK,
			NULL AS FD_UPDATEDATE,FC_POSTATUS AS FC_REASON,NULL AS FC_USERUPD,FT_NOTE,FN_PPN,FC_IDBU,NULL AS FC_TRFWH,NULL AS FC_HUBRK,NULL AS FD_TGLCONF,NULL AS FC_USERCONF,FN_PPH22,FM_TTLPPH22,NULL AS FC_STATUSGNT
			FROM SC_TRX.T_POMST  WHERE fc_pono='$nodok' AND fc_pono NOT IN (SELECT FC_FROMNO FROM SC_TMP.T_INMST_WEB));
		
			INSERT INTO SC_TMP.T_INDTL_WEB
			(FC_BRANCH,fc_trxno,FC_STOCKCODE,FN_NOMOR,FN_QTY,FN_QTYREC,FN_EXTRA,FN_EXTRAREC,FC_REASON,FM_PRICELIST,FN_DISC1P,FN_DISC2P,FN_DISC3P,FM_FORMULA,FC_EXCLUDEPPN,
			FM_BRUTTO,FM_NETTO,FM_DPP,FM_PPN,FM_VALUESTOCK,FC_EDITCOST,FC_UPDATE,FC_DOCNO,FC_TAXIN,FN_PPH22,FM_PPH22,FN_QTYGNT,FN_EXTRAGNT,FN_QTYGNTMP,FN_EXTRAGNTMP)

			(SELECT a.FC_BRANCH,'$nama' as fc_trxno,a.FC_STOCKCODE,a.FN_NOMOR,
			COALESCE(a.FN_QTY,0)-COALESCE(b.FN_QTYREC,0) as FN_QTY
			,0 AS FN_QTYREC,
			a.FN_EXTRA-COALESCE(b.FN_EXTRAREC,0),0 AS FN_EXTRAREC,a.FC_EXTRATYPE AS FC_REASON,a.FM_PRICELIST,a.FN_DISC1P,a.FN_DISC2P,a.FN_DISC3P,a.FM_FORMULA,a.FC_EXCLUDEPPN,
			a.FM_BRUTTO,a.FM_NETTO,a.FM_DPP,a.FM_PPN,0 AS FM_VALUESTOCK,0 AS FC_EDITCOST,'' AS FC_UPDATE,a.fc_pono AS FC_DOCNO,NULL AS FC_TAXIN,a.FN_PPH22,a.FM_PPH22,NULL AS FN_QTYGNT,NULL FN_EXTRAGNT,NULL AS FN_QTYGNTMP,NULL AS FN_EXTRAGNTMP
			FROM SC_TRX.T_PODTL A
			LEFT OUTER JOIN 
			(
			select FC_DOCNO AS fc_pono,trim(FC_STOCKCODE)||trim(FC_DOCNO) AS LISTRIM,
			SUM(COALESCE(FN_QTYREC,0)) AS FN_QTYREC,
			SUM(COALESCE(FN_EXTRAREC,0)) AS FN_EXTRAREC from SC_TRX.t_inmst_web a
			join SC_TRX.t_indtl_web b on b.fc_trxno=a.fc_trxno and a.fc_status NOT IN ('C','D')
			GROUP BY FC_DOCNO,trim(FC_STOCKCODE)||trim(FC_DOCNO)

			) B on trim(a.FC_STOCKCODE)||trim(a.fc_pono)=b.LISTRIM
			WHERE A.fc_pono='$nodok')");
	
	/*	return $this->db->query
		("
		INSERT INTO SC_TMP.T_INMST_WEB
		(FC_BRANCH,fc_trxno,FD_ENTRYDATE,FC_OPERATOR,FC_STATUS,FC_LOCCODE,
		FC_FROM,FC_FROMNO,FV_REFERENCE,FD_REFTGL,FC_FROMCODE,FN_ITEM,FM_NETTO,FM_DPP,FM_PPN,FM_VALUESTOCK,
		FD_UPDATEDATE,FC_REASON,FC_USERUPD,FT_NOTE,FN_PPN,FC_IDBU,FC_TRFWH,FC_HUBRK,FD_TGLCONF,FC_USERCONF,FN_PPH22,FM_TTLPPH22,FC_STATUSGNT)
		(SELECT 
		FC_BRANCH,'$nama',GETDATE(),CONVERT(CHAR(10),'$nama') AS FC_OPERATOR,'I','$loccode',
		1,fc_pono AS FC_FROMNO,NULL AS FV_REFERENCE,NULL AS FD_REFTGL,FC_SUPPCODE AS FC_FROMCODE,FN_ITEMPO AS FN_ITEM,FM_TTLNETTO,FM_TTLDPP,FM_TTLPPN,0 AS FM_VALUESTOCK,
		NULL AS FD_UPDATEDATE,FC_POSTATUS AS FC_REASON,NULL AS FC_USERUPD,FT_NOTE,FN_PPN,FC_IDBU,NULL AS FC_TRFWH,NULL AS FC_HUBRK,NULL AS FD_TGLCONF,NULL AS FC_USERCONF,FN_PPH22,FM_TTLPPH22,NULL AS FC_STATUSGNT
		FROM SC_TRX.T_POMST  WHERE fc_pono='$nodok' AND fc_pono NOT IN (SELECT FC_FROMNO FROM SC_TMP.T_INMST_WEB));
		
		INSERT INTO SC_TMP.T_INDTL_WEB
		(FC_BRANCH,fc_trxno,FC_STOCKCODE,FN_NOMOR,FN_QTY,FN_QTYREC,FN_EXTRA,FN_EXTRAREC,FC_REASON,FM_PRICELIST,FN_DISC1P,FN_DISC2P,FN_DISC3P,FM_FORMULA,FC_EXCLUDEPPN,
		FM_BRUTTO,FM_NETTO,FM_DPP,FM_PPN,FM_VALUESTOCK,FC_EDITCOST,FC_UPDATE,FC_DOCNO,FC_TAXIN,FN_PPH22,FM_PPH22,FN_QTYGNT,FN_EXTRAGNT,FN_QTYGNTMP,FN_EXTRAGNTMP)
		
		(SELECT a.FC_BRANCH,'$nama',a.FC_STOCKCODE,a.FN_NOMOR,
		COALESCE(a.FN_QTY,0)-COALESCE(b.FN_QTYREC,0) as FN_QTY
		,0 AS FN_QTYREC,
		a.FN_EXTRA-COALESCE(b.FN_EXTRAREC,0),0 AS FN_EXTRAREC,a.FC_EXTRATYPE AS FC_REASON,a.FM_PRICELIST,a.FN_DISC1P,a.FN_DISC2P,a.FN_DISC3P,a.FM_FORMULA,a.FC_EXCLUDEPPN,
		a.FM_BRUTTO,a.FM_NETTO,a.FM_DPP,a.FM_PPN,0 AS FM_VALUESTOCK,0 AS FC_EDITCOST,'' AS FC_UPDATE,a.fc_pono AS FC_DOCNO,NULL AS FC_TAXIN,a.FN_PPH22,a.FM_PPH22,NULL AS FN_QTYGNT,NULL FN_EXTRAGNT,NULL AS FN_QTYGNTMP,NULL AS FN_EXTRAGNTMP
		FROM SC_TRX.T_PODTL A
		LEFT OUTER JOIN 
		(
		select FC_DOCNO AS fc_pono,LTRIM(RTRIM(FC_STOCKCODE))+LTRIM(RTRIM(FC_DOCNO)) AS LISTRIM,
		SUM(COALESCE(FN_QTYREC,0)) AS FN_QTYREC,
		SUM(COALESCE(FN_EXTRAREC,0)) AS FN_EXTRAREC from SC_TRX.t_inmst_web a
		join SC_TRX.t_indtl_web b on b.fc_trxno=a.fc_trxno and a.fc_status NOT IN ('C','D')
		GROUP BY FC_DOCNO,LTRIM(RTRIM(FC_STOCKCODE))+LTRIM(RTRIM(FC_DOCNO))

		) B on LTRIM(RTRIM(a.FC_STOCKCODE))+LTRIM(RTRIM(a.fc_pono))=b.LISTRIM
		WHERE A.fc_pono='$nodok')

		"); */
	}
	
	private function _get_q_transaksi_T_POMST($param_list_akses){

			$this->db->select('*');
			$this->db->from("sc_trx.vw_t_pomst");
			$this->db->where("fc_pono is not null $param_list_akses " );

		$i = 0;
	
		foreach ($this->columntwpomst as $item) 
		{
			if($_POST['search']['value'])
			$this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));

			$columntwpomst[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['ordertwpomst']))
		{
			$this->db->order_by($columntwpomst[$_POST['ordertwpomst']['0']['columntwpomst']], $_POST['ordertwpomst']['0']['dir']);
		} 
		else if(isset($this->ordertwpomst))
		{
			$ordertwpomst = $this->ordertwpomst;
			$this->db->order_by(key($ordertwpomst), $ordertwpomst[key($ordertwpomst)]);
		}

	}
	
	function get_transaksi_T_PO_MST($param_list_akses){
		$this->_get_q_transaksi_T_POMST($param_list_akses);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function q_row_transaksi_T_PO_MST($param){
		return $this->db->query(" select *  from SC_TRX.VW_T_POMST where fc_pono IS NOT NULL $param ");
	}
	
	
	function pomst($param){
		return $this->db->query("select coalesce(trim(fc_branch      ::text),'') as fc_branch     ,
										coalesce(trim(fc_pono        ::text),'') as fc_pono       ,
										coalesce(trim(fd_podate      ::text),'') as fd_podate     ,
										coalesce(trim(fc_operator    ::text),'') as fc_operator   ,
										coalesce(trim(fc_postatus    ::text),'') as fc_postatus   ,
										coalesce(trim(fc_potipe      ::text),'') as fc_potipe     ,
										coalesce(trim(fc_employee    ::text),'') as fc_employee   ,
										coalesce(trim(fc_shiptype    ::text),'') as fc_shiptype   ,
										coalesce(trim(fc_shipterm    ::text),'') as fc_shipterm   ,
										coalesce(trim(fd_shipdate    ::text),'') as fd_shipdate   ,
										coalesce(trim(fn_itempo      ::text),'0') as fn_itempo     ,
										coalesce(trim(fn_itemappreq  ::text),'0') as fn_itemappreq ,
										coalesce(trim(fn_itemappved  ::text),'0') as fn_itemappved ,
										coalesce(trim(fn_itemappdelv ::text),'0') as fn_itemappdelv,
										coalesce(trim(fn_itempodelv  ::text),'0') as fn_itempodelv ,
										coalesce(trim(fn_itempodel   ::text),'0') as fn_itempodel  ,
										coalesce(trim(fd_agepo       ::text),'') as fd_agepo      ,
										coalesce(trim(fc_suppcode    ::text),'') as fc_suppcode   ,
										coalesce(trim(fc_custcode    ::text),'') as fc_custcode   ,
										coalesce(trim(fc_shipto      ::text),'') as fc_shipto     ,
										coalesce(trim(fm_ttldisc     ::numeric::text),'0') as fm_ttldisc    ,
										coalesce(trim(fm_ttlbrutto   ::numeric::text),'0') as fm_ttlbrutto  ,
										coalesce(trim(fm_ttlnetto    ::numeric::text),'0') as fm_ttlnetto   ,
										coalesce(trim(fm_ttldpp      ::numeric::text),'0') as fm_ttldpp     ,
										coalesce(trim(fm_ttlppn      ::numeric::text),'0') as fm_ttlppn     ,
										coalesce(trim(fv_approvedby1 ::text),'') as fv_approvedby1,
										coalesce(trim(fv_approvedby2 ::text),'') as fv_approvedby2,
										coalesce(trim(fc_flagprint   ::text),'') as fc_flagprint  ,
										coalesce(trim(ft_note        ::text),'') as ft_note       ,
										coalesce(trim(fn_ppn         ::text),'0') as fn_ppn        ,
										coalesce(trim(fc_idbu        ::text),'') as fc_idbu       ,
										coalesce(trim(fn_pph22       ::text),'0') as fn_pph22      ,
										coalesce(trim(fm_ttlpph22    ::numeric::text),'0') as fm_ttlpph22   ,
										coalesce(trim(fc_pognt       ::text),'') as fc_pognt      ,
										coalesce(trim(fc_sjgntref    ::text),'') as fc_sjgntref from (select *,to_char(fd_podate,'yyyy-mm-dd') as fc_podate,to_char(fd_shipdate,'yyyy-mm-dd') as fc_shipdate from sc_trx.t_pomst) as x where fc_pono is not null $param");	
	}
	
	function podtl($param){
		return $this->db->query("select coalesce(trim(fc_branch     ::text),'') as fc_branch     ,
										coalesce(trim(fc_pono       ::text),'') as fc_pono       ,
										coalesce(trim(fc_stockcode  ::text),'') as fc_stockcode  ,
										coalesce(trim(fn_nomor      ::text),'0') as fn_nomor      ,
										coalesce(trim(fd_pricedate  ::text),'') as fd_pricedate  ,
										coalesce(trim(fn_term       ::text),'0') as fn_term       ,
										coalesce(trim(fn_qty        ::text),'0') as fn_qty        ,
										coalesce(trim(fc_extratype  ::text),'') as fc_extratype  ,
										coalesce(trim(fn_extra      ::text),'0') as fn_extra      ,
										coalesce(trim(fc_kondisi    ::text),'') as fc_kondisi    ,
										coalesce(trim(fm_formula    ::numeric::text),'0') as fm_formula    ,
										coalesce(trim(fm_pricelist  ::numeric::text),'0') as fm_pricelist  ,
										coalesce(trim(fn_disc1p     ::text),'0') as fn_disc1p     ,
										coalesce(trim(fn_disc2p     ::text),'0') as fn_disc2p     ,
										coalesce(trim(fn_disc3p     ::text),'0') as fn_disc3p     ,
										coalesce(trim(fm_discval    ::numeric::text),'0') as fm_discval    ,
										coalesce(trim(fc_excludeppn ::text),'') as fc_excludeppn ,
										coalesce(trim(fm_brutto     ::numeric::text),'0') as fm_brutto     ,
										coalesce(trim(fm_netto      ::numeric::text),'0') as fm_netto      ,
										coalesce(trim(fm_dpp        ::numeric::text),'0') as fm_dpp        ,
										coalesce(trim(fm_ppn        ::numeric::text),'0') as fm_ppn        ,
										coalesce(trim(fc_approved   ::text),'') as fc_approved   ,
										coalesce(trim(fc_approvedref::text),'') as fc_approvedref,
										coalesce(trim(fn_qtydelv    ::text),'0') as fn_qtydelv    ,
										coalesce(trim(fn_extradelv  ::text),'0') as fn_extradelv  ,
										coalesce(trim(fc_reason     ::text),'') as fc_reason     ,
										coalesce(trim(fc_status     ::text),'') as fc_status     ,
										coalesce(trim(fn_pph22      ::text),'0') as fn_pph22      ,
										coalesce(trim(fm_pph22      ::numeric::text),'0') as fm_pph22, 
										coalesce(trim(fc_podate      ::text),'') as fc_podate, 
										coalesce(trim(fc_shipdate      ::text),'') as fc_shipdate
										from (select a.*,to_char(b.fd_podate,'yyyy-mm-dd') as fc_podate,to_char(b.fd_shipdate,'yyyy-mm-dd') as fc_shipdate from sc_trx.t_podtl a
										left outer join sc_trx.t_pomst b on a.fc_pono=b.fc_pono ) as x
										where fc_pono is not null $param");	
	}
	
	function popps($param){
		return $this->db->query("select coalesce(trim(fc_branch     ::text),'') as fc_branch     ,
										coalesce(trim(fc_pono       ::text),'') as fc_pono       ,
										coalesce(trim(fn_nomor      ::text),'') as fn_nomor      ,
										coalesce(trim(fc_kapal      ::text),'') as fc_kapal      ,
										coalesce(trim(fc_pps        ::text),'') as fc_pps        ,
										coalesce(trim(fc_tonase     ::text),'') as fc_tonase     ,
										coalesce(trim(fc_inputby    ::text),'') as fc_inputby    ,
										coalesce(trim(fd_inputdate  ::text),'') as fd_inputdate  ,
										coalesce(trim(fc_updateby   ::text),'') as fc_updateby   ,
										coalesce(trim(fd_updatedate ::text),'') as fd_updatedate ,
										coalesce(trim(fc_flag       ::text),'') as fc_flag       ,
										coalesce(trim(fc_status     ::text),'') as fc_status     ,
										coalesce(trim(fc_expedisi   ::text),'') as fc_expedisi   ,
										coalesce(trim(fc_kontainerno::text),'') as fc_kontainerno from 
										(select a.*,to_char(b.fd_podate,'yyyy-mm-dd') as fc_podate,to_char(b.fd_shipdate,'yyyy-mm-dd') as fc_shipdate from sc_trx.t_popps a
										left outer join sc_trx.t_pomst b on a.fc_pono=b.fc_pono ) as x
										where fc_pono is not null $param");
	}
	
	function q_t_inmst_web($param){
		return $this->db->query("select 
								 coalesce(trim(fc_branch    ::text),'') as fc_branch    ,
								 coalesce(trim(fc_trxno     ::text),'') as fc_trxno     ,
								 coalesce(trim(fd_entrydate ::text),'') as fd_entrydate ,
								 coalesce(trim(fc_operator  ::text),'') as fc_operator  ,
								 coalesce(trim(fc_status    ::text),'') as fc_status    ,
								 coalesce(trim(fc_loccode   ::text),'') as fc_loccode   ,
								 coalesce(trim(fc_from      ::text),'') as fc_from      ,
								 coalesce(trim(fc_fromno    ::text),'') as fc_fromno    ,
								 coalesce(trim(fv_reference ::text),'') as fv_reference ,
								 coalesce(trim(fd_reftgl    ::text),'') as fd_reftgl    ,
								 coalesce(trim(fc_fromcode  ::text),'') as fc_fromcode  ,
								 coalesce(trim(fn_item      ::text),'0') as fn_item      ,
								 coalesce(trim(fm_netto     ::numeric::text),'0') as fm_netto     ,
								 coalesce(trim(fm_dpp       ::numeric::text),'0') as fm_dpp       ,
								 coalesce(trim(fm_ppn       ::numeric::text),'0') as fm_ppn       ,
								 coalesce(trim(fm_valuestock::numeric::text),'0') as fm_valuestock,
								 coalesce(trim(fd_updatedate::text),'') as fd_updatedate,
								 coalesce(trim(fc_reason    ::text),'') as fc_reason    ,
								 coalesce(trim(fc_userupd   ::text),'') as fc_userupd   ,
								 coalesce(trim(ft_note      ::text),'') as ft_note      ,
								 coalesce(trim(fn_ppn       ::text),'0') as fn_ppn       ,
								 coalesce(trim(fc_idbu      ::text),'') as fc_idbu      ,
								 coalesce(trim(fc_trfwh     ::text),'') as fc_trfwh     ,
								 coalesce(trim(fc_hubrk     ::text),'') as fc_hubrk     ,
								 coalesce(trim(fd_tglconf   ::text),'') as fd_tglconf   ,
								 coalesce(trim(fc_userconf  ::text),'') as fc_userconf  ,
								 coalesce(trim(fn_pph22     ::text),'0') as fn_pph22     ,
								 coalesce(trim(fm_ttlpph22  ::numeric::text),'0') as fm_ttlpph22  ,
								 coalesce(trim(fc_statusgnt ::text),'') as fc_statusgnt ,
								 coalesce(trim(fc_expedisi  ::text),'') as fc_expedisi  ,
								 coalesce(trim(fc_nopol     ::text),'') as fc_nopol     ,
								 coalesce(trim(fc_namedriver::text),'') as fc_namedriver,
								 coalesce(trim(fc_hpdriver  ::text),'') as fc_hpdriver  ,
								 coalesce(trim(fc_franco    ::text),'') as fc_franco    ,
								 coalesce(trim(ft_image     ::text),'') as ft_image 	,
								 coalesce(trim(fc_entrydate     ::text),'') as fc_entrydate 
					from (select * ,to_char(fd_entrydate,'yyyy-mm-dd')as fc_entrydate from  sc_trx.t_inmst_web) as x where fc_trxno is not null $param");
	}
	
	function q_t_indtl_web($param){
		return $this->db->query("select coalesce(trim(fc_branch    ::text),'') as fc_branch    ,
										coalesce(trim(fc_trxno     ::text),'') as fc_trxno     ,
										coalesce(trim(fc_stockcode ::text),'') as fc_stockcode ,
										coalesce(trim(fn_nomor     ::text),'0') as fn_nomor     ,
										coalesce(trim(fn_qty       ::text),'0') as fn_qty       ,
										coalesce(trim(fn_qtyrec    ::text),'0') as fn_qtyrec    ,
										coalesce(trim(fn_extra     ::text),'0') as fn_extra     ,
										coalesce(trim(fn_extrarec  ::text),'0') as fn_extrarec  ,
										coalesce(trim(fc_reason    ::text),'0') as fc_reason    ,
										coalesce(trim(fm_pricelist ::numeric::text),'0') as fm_pricelist ,
										coalesce(trim(fn_disc1p    ::text),'0') as fn_disc1p    ,
										coalesce(trim(fn_disc2p    ::text),'0') as fn_disc2p    ,
										coalesce(trim(fn_disc3p    ::text),'0') as fn_disc3p    ,
										coalesce(trim(fm_formula   ::numeric::text),'') as fm_formula   ,
										coalesce(trim(fc_excludeppn::text),'') as fc_excludeppn,
										coalesce(trim(fm_brutto    ::numeric::text),'0') as fm_brutto    ,
										coalesce(trim(fm_netto     ::numeric::text),'0') as fm_netto     ,
										coalesce(trim(fm_dpp       ::numeric::text),'0') as fm_dpp       ,
										coalesce(trim(fm_ppn       ::numeric::text),'0') as fm_ppn       ,
										coalesce(trim(fm_valuestock::numeric::text),'0') as fm_valuestock,
										coalesce(trim(fc_editcost  ::text),'') as fc_editcost  ,
										coalesce(trim(fc_update    ::text),'') as fc_update    ,
										coalesce(trim(fc_docno     ::text),'') as fc_docno     ,
										coalesce(trim(fc_taxin     ::text),'') as fc_taxin     ,
										coalesce(trim(fn_pph22     ::text),'0') as fn_pph22     ,
										coalesce(trim(fm_pph22     ::numeric::text),'0') as fm_pph22     ,
										coalesce(trim(fn_qtygnt    ::text),'0') as fn_qtygnt    ,
										coalesce(trim(fn_extragnt  ::text),'0') as fn_extragnt  ,
										coalesce(trim(fn_qtygntmp  ::text),'0') as fn_qtygntmp  ,
										coalesce(trim(fn_extragntmp::text),'0') as fn_extragntmp,
										coalesce(trim(ft_note      ::text),'') as ft_note      ,
										coalesce(trim(fc_entrydate ::text),'') as fc_entrydate from (
								select a.*,to_char(fd_entrydate,'yyyy-mm-dd')as fc_entrydate from sc_trx.t_indtl_web a 
								left outer join sc_trx.t_inmst_web b on a.fc_trxno=b.fc_trxno) as x where fc_trxno is not null $param");
	}
	
	function q_mst_customer($param){
		return $this->db->query("select 
									coalesce(trim(fc_branch    ::text),'') as fc_branch    ,
									coalesce(trim(fc_custcode  ::text),'') as fc_custcode  ,
									coalesce(trim(fv_custname  ::text),'') as fv_custname  ,
									coalesce(trim(fv_custadd1  ::text),'') as fv_custadd1  ,
									coalesce(trim(fv_custadd2  ::text),'') as fv_custadd2  ,
									coalesce(trim(fv_custcity  ::text),'') as fv_custcity  ,
									coalesce(trim(fv_custpro   ::text),'') as fv_custpro   ,
									coalesce(trim(fv_custzip   ::text),'') as fv_custzip   ,
									coalesce(trim(fv_custtel   ::text),'') as fv_custtel   ,
									coalesce(trim(fv_custfax   ::text),'') as fv_custfax   ,
									coalesce(trim(fd_inputdate ::text),'') as fd_inputdate ,
									coalesce(trim(fc_reference ::text),'') as fc_reference ,
									coalesce(trim(fd_lastsales ::text),'') as fd_lastsales ,
									coalesce(trim(fd_updatedate::text),'') as fd_updatedate,
									coalesce(trim(fc_updateby  ::text),'') as fc_updateby  ,
									coalesce(trim(fc_colladm   ::text),'') as fc_colladm   ,
									coalesce(trim(fc_custtype  ::text),'') as fc_custtype  ,
									coalesce(trim(fc_custjenis ::text),'') as fc_custjenis ,
									coalesce(trim(fc_custarea  ::text),'') as fc_custarea  ,
									coalesce(trim(fn_bounch    ::numeric::text),'0') as fn_bounch    ,
									coalesce(trim(fc_custhold  ::text),'') as fc_custhold  ,
									coalesce(trim(fc_grdsales  ::text),'') as fc_grdsales  ,
									coalesce(trim(fc_grdpaymt  ::text),'') as fc_grdpaymt  ,
									coalesce(trim(fc_statuspkp ::text),'') as fc_statuspkp ,
									coalesce(trim(fm_crdlimit  ::numeric::text),'0') as fm_crdlimit  ,
									coalesce(trim(fm_totalso   ::numeric::text),'0') as fm_totalso   ,
									coalesce(trim(fm_totalar   ::numeric::text),'0') as fm_totalar   ,
									coalesce(trim(fm_totalpdc  ::numeric::text),'0') as fm_totalpdc  ,
									coalesce(trim(fm_cashpay   ::numeric::text),'0') as fm_cashpay   ,
									coalesce(trim(fm_pdcpay    ::numeric::text),'0') as fm_pdcpay    ,
									coalesce(trim(fm_cashtitip ::numeric::text),'0') as fm_cashtitip ,
									coalesce(trim(fm_pdctitip  ::numeric::text),'0') as fm_pdctitip  ,
									coalesce(trim(fm_cashlebih ::numeric::text),'0') as fm_cashlebih ,
									coalesce(trim(fm_pdclebih  ::numeric::text),'0') as fm_pdclebih  ,
									coalesce(trim(fn_shipto    ::numeric::text),'0') as fn_shipto    ,
									coalesce(trim(fn_defaultshp::numeric::text),'0') as fn_defaultshp,
									coalesce(trim(fv_ownname   ::text),'') as fv_ownname   ,
									coalesce(trim(fv_ownadd    ::text),'') as fv_ownadd    ,
									coalesce(trim(fv_owncity   ::text),'') as fv_owncity   ,
									coalesce(trim(fv_telephone ::text),'') as fv_telephone ,
									coalesce(trim(fv_sales     ::text),'') as fv_sales     ,
									coalesce(trim(fc_relegion  ::text),'') as fc_relegion  ,
									coalesce(trim(fd_birtdate  ::text),'') as fd_birtdate  ,
									coalesce(trim(ft_note      ::text),'') as ft_note      ,
									coalesce(trim(fm_pdctolak  ::numeric::text),'0') as fm_pdctolak  ,
									coalesce(trim(fc_updcrdby  ::text),'') as fc_updcrdby  ,
									coalesce(trim(fd_updcrddate::text),'') as fd_updcrddate,
									coalesce(trim(fc_potensial ::text),'') as fc_potensial ,
									coalesce(trim(fc_idbu      ::text),'') as fc_idbu  from sc_mst.t_customer where fc_custcode is not null $param ");
	}
	
	function q_mst_expedisi($param){
		return $this->db->query("select coalesce(trim(fc_branch     ::text),'') as fc_branch     ,
										coalesce(trim(fc_expedisi   ::text),'') as fc_expedisi   ,
										coalesce(trim(fv_expdname   ::text),'') as fv_expdname   ,
										coalesce(trim(fv_expdadd1   ::text),'') as fv_expdadd1   ,
										coalesce(trim(fv_expdadd2   ::text),'') as fv_expdadd2   ,
										coalesce(trim(fv_expdcity   ::text),'') as fv_expdcity   ,
										coalesce(trim(fc_expdzip    ::text),'') as fc_expdzip    ,
										coalesce(trim(fv_epxdpro    ::text),'') as fv_epxdpro    ,
										coalesce(trim(fv_expdtel    ::text),'') as fv_expdtel    ,
										coalesce(trim(fv_expdfax    ::text),'') as fv_expdfax    ,
										coalesce(trim(fc_inputby    ::text),'') as fc_inputby    ,
										coalesce(trim(fd_inputdate  ::text),'') as fd_inputdate  ,
										coalesce(trim(fc_updateby   ::text),'') as fc_updateby   ,
										coalesce(trim(fd_updatedate ::text),'') as fd_updatedate ,
										coalesce(trim(fc_expdhold   ::text),'') as fc_expdhold   ,
										coalesce(trim(fd_lasttrx    ::text),'') as fd_lasttrx    ,
										coalesce(trim(fm_crdlimit   ::numeric::text),'0') as fm_crdlimit   ,
										coalesce(trim(fm_totalclaim ::numeric::text),'0') as fm_totalclaim ,
										coalesce(trim(fm_totalreturn::numeric::text),'0') as fm_totalreturn,
										coalesce(trim(fn_patokan    ::numeric::text),'0') as fn_patokan    ,
										coalesce(trim(fm_pricelist  ::numeric::text),'0') as fm_pricelist  ,
										coalesce(trim(fc_status     ::text),'') as fc_status     ,
										coalesce(trim(ft_note1      ::text),'') as ft_note1      ,
										coalesce(trim(ft_note2      ::text),'') as ft_note2      ,
										coalesce(trim(fv_expdnpwp   ::text),'') as fv_expdnpwp   ,
										coalesce(trim(fd_expdpkp    ::text),'') as fd_expdpkp    ,
										coalesce(trim(fv_expdpkpname::text),'') as fv_expdpkpname,
										coalesce(trim(fv_ownername  ::text),'') as fv_ownername  ,
										coalesce(trim(fv_bankname   ::text),'') as fv_bankname   ,
										coalesce(trim(fv_bankacct   ::text),'') as fv_bankacct   ,
										coalesce(trim(fv_bankarea   ::text),'') as fv_bankarea   ,
										coalesce(trim(fv_bankcity   ::text),'') as fv_bankcity   from sc_mst.t_expedisi where fc_expedisi is not null $param");
	}
	
	function q_mst_gudang($param){
		return $this->db->query("select coalesce(trim(fc_loccode ::text),'') as fc_loccode ,
										coalesce(trim(fc_locaname::text),'') as fc_locaname,
										coalesce(trim(fc_locaadd ::text),'') as fc_locaadd ,
										coalesce(trim(fc_locacity::text),'') as fc_locacity,
										coalesce(trim(fc_status  ::text),'') as fc_status  ,
										coalesce(trim(fc_hold    ::text),'') as fc_hold    ,
										coalesce(trim(fc_flag    ::text),'') as fc_flag    ,
										coalesce(trim(fc_custcode::text),'') as fc_custcode,
										coalesce(trim(fc_sms     ::text),'') as fc_sms     ,
										coalesce(trim(fc_type    ::text),'') as fc_type    ,
										coalesce(trim(fc_idbu    ::text),'') as fc_idbu    ,
										coalesce(trim(fc_reject  ::text),'') as fc_reject  ,
										coalesce(trim(fc_locgnt  ::text),'') as fc_locgnt  from sc_mst.t_gudang where fc_loccode is not null $param");
	}
	
	function q_mst_cabang($param){
		return $this->db->query("select coalesce(trim(fc_branch     ::text),'') as fc_branch     ,
										coalesce(trim(fc_groupcabang::text),'') as fc_groupcabang,
										coalesce(trim(fv_name       ::text),'') as fv_name       ,
										coalesce(trim(fv_add1       ::text),'') as fv_add1       ,
										coalesce(trim(fv_add2       ::text),'') as fv_add2       ,
										coalesce(trim(fv_city       ::text),'') as fv_city       ,
										coalesce(trim(fv_area       ::text),'') as fv_area       ,
										coalesce(trim(fv_email      ::text),'') as fv_email      ,
										coalesce(trim(fv_contac     ::text),'') as fv_contac     ,
										coalesce(trim(fv_directory  ::text),'') as fv_directory  ,
										coalesce(trim(fc_default    ::text),'') as fc_default    ,
										coalesce(trim(fc_statusprs  ::text),'') as fc_statusprs  ,
										coalesce(trim(fd_prsdate    ::text),'') as fd_prsdate    ,
										coalesce(trim(fd_potrfdate  ::text),'') as fd_potrfdate  ,
										coalesce(trim(fd_bpbtrfdate ::text),'') as fd_bpbtrfdate ,
										coalesce(trim(fd_stktrfdate ::text),'') as fd_stktrfdate ,
										coalesce(trim(fd_suptrfdate ::text),'') as fd_suptrfdate ,
										coalesce(trim(fc_statustrf  ::text),'') as fc_statustrf  ,
										coalesce(trim(fc_corporate  ::text),'') as fc_corporate  ,
										coalesce(trim(fc_active     ::text),'') as fc_active  from sc_mst.t_cabang where fc_branch is not null $param ");

	}
	
	function q_mst_supplier($param){
		return $this->db->query("select coalesce(trim(fc_branch    ::text),'') as fc_branch             ,
										coalesce(trim(fc_suppcode  ::text),'') as fc_suppcode           ,
										coalesce(trim(fv_suppname  ::text),'') as fv_suppname           ,
										coalesce(trim(fv_suppadd1  ::text),'') as fv_suppadd1           ,
										coalesce(trim(fv_suppadd2  ::text),'') as fv_suppadd2           ,
										coalesce(trim(fv_suppcity  ::text),'') as fv_suppcity           ,
										coalesce(trim(fc_suppzip   ::text),'') as fc_suppzip            ,
										coalesce(trim(fv_supppro   ::text),'') as fv_supppro            ,
										coalesce(trim(fv_supptel   ::text),'') as fv_supptel            ,
										coalesce(trim(fv_supptfax  ::text),'') as fv_supptfax           ,
										coalesce(trim(fd_updatedate::text),'') as fd_updatedate         ,
										coalesce(trim(fc_updateby  ::text),'') as fc_updateby           ,
										coalesce(trim(fd_inputdate ::text),'') as fd_inputdate          ,
										coalesce(trim(fc_supphold  ::text),'') as fc_supphold           ,
										coalesce(trim(fd_lastpurch ::text),'') as fd_lastpurch          ,
										coalesce(trim(fd_lasttrx   ::text),'') as fd_lasttrx            ,
										coalesce(trim(fm_crdlimit  ::numeric::text),'0') as fm_crdlimit ,
										coalesce(trim(fm_totalpo   ::numeric::text),'0') as fm_totalpo  ,
										coalesce(trim(fm_totalap   ::numeric::text),'0') as fm_totalap  ,
										coalesce(trim(fc_status    ::text),'') as fc_status             ,
										coalesce(trim(ft_note1     ::text),'') as ft_note1              ,
										coalesce(trim(ft_note2     ::text),'') as ft_note2              ,
										coalesce(trim(fv_npwp      ::text),'') as fv_npwp               ,
										coalesce(trim(fd_pkp       ::text),'') as fd_pkp                ,
										coalesce(trim(fv_pkpname   ::text),'') as fv_pkpname            ,
										coalesce(trim(fm_cashtitip ::numeric::text),'0') as fm_cashtitip,
										coalesce(trim(fm_pdctitip  ::numeric::text),'0') as fm_pdctitip ,
										coalesce(trim(fc_supptype  ::text),'') as fc_supptype ,
										coalesce(trim(fc_pps  ::text),'') as fc_pps ,
										coalesce(trim(fc_pph22  ::text),'') as fc_pph22 ,
										coalesce(trim(fm_pph22  ::text),'') as fm_pph22 
										from sc_mst.t_supplier where fc_branch is not null $param");
	}
	
	function q_mst_stock($param){
		return $this->db->query("select coalesce(trim(fc_branch    ::text),'') as fc_branch              ,
										coalesce(trim(fc_stockcode ::text),'') as fc_stockcode           ,
										coalesce(trim(fv_stockname ::text),'') as fv_stockname           ,
										coalesce(trim(fm_valuestock::numeric::text),'0') as fm_valuestock,
										coalesce(trim(fm_hpp       ::numeric::text),'0') as fm_hpp       ,
										coalesce(trim(fn_onhand    ::numeric::text),'0') as fn_onhand    ,
										coalesce(trim(fn_allocated ::numeric::text),'0') as fn_allocated ,
										coalesce(trim(fn_valuealloc::numeric::text),'0') as fn_valuealloc,
										coalesce(trim(fn_tmpalloca ::numeric::text),'0') as fn_tmpalloca ,
										coalesce(trim(fv_colorname ::text),'') as fv_colorname           ,
										coalesce(trim(fv_colorcode ::text),'') as fv_colorcode           ,
										coalesce(trim(fd_lastupdate::text),'') as fd_lastupdate          ,
										coalesce(trim(fd_inputdate ::text),'') as fd_inputdate           ,
										coalesce(trim(fv_updateby  ::text),'') as fv_updateby            ,
										coalesce(trim(fd_lastsales ::text),'') as fd_lastsales           ,
										coalesce(trim(fd_lastpurch ::text),'') as fd_lastpurch           ,
										coalesce(trim(fc_divisi    ::text),'') as fc_divisi              ,
										coalesce(trim(fc_brand     ::text),'') as fc_brand               ,
										coalesce(trim(fc_group     ::text),'') as fc_group               ,
										coalesce(trim(fc_subgrp    ::text),'') as fc_subgrp              ,
										coalesce(trim(fc_type      ::text),'') as fc_type                ,
										coalesce(trim(fc_pack      ::text),'') as fc_pack                ,
										coalesce(trim(fn_reorder   ::numeric::text),'0') as fn_reorder   ,
										coalesce(trim(fn_outstpurch::numeric::text),'0') as fn_outstpurch,
										coalesce(trim(fn_outstsales::numeric::text),'0') as fn_outstsales,
										coalesce(trim(fn_uninvoiced::numeric::text),'0') as fn_uninvoiced,
										coalesce(trim(fn_valueuninv::numeric::text),'0') as fn_valueuninv,
										coalesce(trim(fn_openblnc  ::numeric::text),'0') as fn_openblnc  ,
										coalesce(trim(fn_maxpurch  ::numeric::text),'0') as fn_maxpurch  ,
										coalesce(trim(fn_minpurch  ::numeric::text),'0') as fn_minpurch  ,
										coalesce(trim(fn_maxsales  ::numeric::text),'0') as fn_maxsales  ,
										coalesce(trim(fn_minsales  ::numeric::text),'0') as fn_minsales  ,
										coalesce(trim(fn_maxstock  ::numeric::text),'0') as fn_maxstock  ,
										coalesce(trim(fn_minstock  ::numeric::text),'0') as fn_minstock  ,
										coalesce(trim(fc_gradeinout::text),'') as fc_gradeinout,
										coalesce(trim(fc_hold      ::text),'') as fc_hold      ,
										coalesce(trim(fc_pictureclr::text),'') as fc_pictureclr,
										coalesce(trim(fc_report    ::text),'') as fc_report    ,
										coalesce(trim(fn_volume    ::numeric::text),'0') as fn_volume    ,
										coalesce(trim(fm_lasthpp   ::numeric::text),'0') as fm_lasthpp   ,
										coalesce(trim(fm_lastprice ::numeric::text),'0') as fm_lastprice ,
										coalesce(trim(fn_lastdisc1 ::numeric::text),'0') as fn_lastdisc1 ,
										coalesce(trim(fn_lastdisc2 ::numeric::text),'0') as fn_lastdisc2 ,
										coalesce(trim(fn_lastdisc3 ::numeric::text),'0') as fn_lastdisc3 ,
										coalesce(trim(ft_note      ::text),'') as ft_note                ,
										coalesce(trim(fc_minus     ::text),'') as fc_minus               ,
										coalesce(trim(fc_stocktype ::text),'') as fc_stocktype  from sc_mst.t_stock where fc_stockcode is not null $param");
	}
	
	function q_mst_mpack($param){
		return $this->db->query("select 
										coalesce(trim(fc_brand::text),'') as fc_brand,
										coalesce(trim(fc_group::text),'') as fc_group,
										coalesce(trim(fc_subgrp::text),'') as fc_subgrp,
										coalesce(trim(fc_type::text),'') as fc_type,
										coalesce(trim(fc_pack::text),'') as fc_pack,
										coalesce(trim(fv_packname::text),'') as fv_packname,
										coalesce(trim(fc_stocktype::text),'') as fc_stocktype,
										coalesce(trim(fc_packhold::text),'') as fc_packhold,
										coalesce(trim(fc_editable::text),'') as fc_editable,
										coalesce(trim(fc_konsinyasi::text),'') as fc_konsinyasi
										from sc_mst.t_mpack where fc_pack is not null $param");
	}
	
	function q_mst_user($param){
		return $this->db->query("select coalesce(trim(branch     ::text),'') as branch     ,
										coalesce(trim(nik        ::text),'') as nik        ,
										coalesce(trim(username   ::text),'') as username   ,
										coalesce(trim(passwordweb::text),'') as passwordweb,
										coalesce(trim(location   ::text),'') as location   ,
										coalesce(trim(level_id   ::text),'') as level_id   ,
										coalesce(trim(level_akses::text),'') as level_akses,
										coalesce(trim(divisi     ::text),'') as divisi     ,
										coalesce(trim(groupuser  ::text),'') as groupuser  ,
										coalesce(trim(expdate    ::text),'') as expdate    ,
										coalesce(trim(hold_id    ::text),'') as hold_id    ,
										coalesce(trim(inputdate  ::text),'') as inputdate  ,
										coalesce(trim(inputby    ::text),'') as inputby    ,
										coalesce(trim(editdate   ::text),'') as editdate   ,
										coalesce(trim(editby     ::text),'') as editby     ,
										coalesce(trim(lastlogin  ::text),'') as lastlogin  ,
										coalesce(trim(image      ::text),'') as image      ,
										coalesce(trim(idbu       ::text),'') as idbu  from sc_mst.t_user_web where username is not null $param");
	}
	
	function q_createTrxInmst($value){
        return $this->db
            ->insert_batch('sc_tmp.t_inmst_web_replication', $value);
    }
	
	function q_createTrxIndtl($value){
        return $this->db
            ->insert_batch('sc_tmp.t_indtl_web_replication', $value);
    }
	
	function q_commitTrxInmst($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.t_inmst_web_replication', $value);
    }

	function q_commitTrxIndtl($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.t_indtl_web_replication', $value);
    }
	
	function q_DelTmpInmst($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.t_inmst_web_replication');
    }
	function q_DelTmpIndtl($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.t_indtl_web_replication');
    }
	
	function q_DelResultUpload($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.resultupload');
    }
	
	function q_tmp_result_where($param=null){
		return $this->db->query("select coalesce(trim(branch::text),'') as branch     ,
										coalesce(trim(userid::text),'') as userid        ,
										coalesce(trim(uploadid::text),'') as uploadid   ,
										coalesce(trim(uploadname::text),'') as uploadname,
										coalesce(trim(uploaddate::text),'') as uploaddate   ,
										coalesce(trim(uploadby::text),'') as uploadby   ,
										coalesce(trim(upload::text),'') as upload,
										coalesce(trim(schema::text),'') as schema  from sc_tmp.resultupload where userid is not null $param");
	}
	
	function q_createBackupNumber($value){
        return $this->db
            ->insert_batch('sc_mst.backupnumber', $value);
    }
	
	function q_mst_backup_number_result_where($param=null){
		return $this->db->query("select coalesce(trim(branch    ::text),'') as branch    ,
										coalesce(trim(userid    ::text),'') as userid    ,
										coalesce(trim(documen   ::text),'') as documen   ,
										coalesce(trim(part      ::text),'') as part      ,
										coalesce(trim(count     ::text),'') as count     ,
										coalesce(trim(prefix    ::text),'') as prefix    ,
										coalesce(trim(suffix    ::text),'') as suffix    ,
										coalesce(trim(docno     ::text),'') as docno     ,
										coalesce(trim(increment ::text),'') as increment ,
										coalesce(trim(comparison::text),'') as comparison,
										coalesce(trim(status    ::text),'') as status  
										from sc_mst.backupnumber where branch is not null $param");
	}
	
	function q_DelBackupNumber($where){
        return $this->db
            ->where($where)
            ->delete('sc_mst.backupnumber');
    }

    function q_t_inmst_web_pagin($param,$paramtop,$paramoffset){
        return $this->db->query("select coalesce(trim(fc_branch          ::text),'') as fc_branch,
                                        coalesce(trim(fc_trxno           ::text),'') as fc_trxno,
                                        coalesce(trim(fd_entrydate       ::text),'') as fd_entrydate,
                                        coalesce(trim(fc_operator        ::text),'') as fc_operator,
                                        coalesce(trim(fc_status          ::text),'') as fc_status,
                                        coalesce(trim(fc_loccode         ::text),'') as fc_loccode,
                                        coalesce(trim(fc_from            ::text),'') as fc_from,
                                        coalesce(trim(fc_fromno          ::text),'') as fc_fromno,
                                        coalesce(trim(fv_reference       ::text),'') as fv_reference,
                                        coalesce(trim(fd_reftgl          ::text),'') as fd_reftgl,
                                        coalesce(trim(fc_fromcode        ::text),'') as fc_fromcode,
                                        coalesce(trim(fn_item            ::text),'') as fn_item,
                                        coalesce(trim(fm_netto           ::text),'') as fm_netto,
                                        coalesce(trim(fm_dpp             ::text),'') as fm_dpp,
                                        coalesce(trim(fm_ppn             ::text),'') as fm_ppn,
                                        coalesce(trim(fm_valuestock      ::text),'') as fm_valuestock,
                                        coalesce(trim(fd_updatedate      ::text),'') as fd_updatedate,
                                        coalesce(trim(fc_reason          ::text),'') as fc_reason,
                                        coalesce(trim(fc_userupd         ::text),'') as fc_userupd,
                                        coalesce(trim(ft_note            ::text),'') as ft_note,
                                        coalesce(trim(fn_ppn             ::text),'') as fn_ppn,
                                        coalesce(trim(fc_idbu::text),'') as fc_idbu,
                                        coalesce(trim(fc_trfwh::text),'') as fc_trfwh,
                                        coalesce(trim(fc_hubrk::text),'') as fc_hubrk,
                                        coalesce(trim(fd_tglconf::text),'') as fd_tglconf,
                                        coalesce(trim(fc_userconf::text),'') as fc_userconf,
                                        coalesce(trim(fn_pph22::text),'') as fn_pph22,
                                        coalesce(trim(fm_ttlpph22::text),'') as fm_ttlpph22,
                                        coalesce(trim(fc_statusgnt::text),'') as fc_statusgnt,
                                        coalesce(trim(fc_expedisi::text),'') as fc_expedisi,
                                        coalesce(trim(fc_nopol::text),'') as fc_nopol,
                                        coalesce(trim(fc_namedriver::text),'') as fc_namedriver,
                                        coalesce(trim(fc_hpdriver::text),'') as fc_hpdriver,
                                        coalesce(trim(fc_franco::text),'') as fc_franco,
                                        coalesce(trim(ft_image::text),'') as ft_image,
                                        coalesce(trim(status::text),'') as status,
                                        coalesce(trim(locname::text),'') as locname,
                                        coalesce(trim(fc_locaname::text),'') as fc_locaname,
                                        coalesce(trim(fc_locaadd::text),'') as fc_locaadd,
                                        coalesce(trim(tipe::text),'') as tipe,
                                        coalesce(trim(fv_suppname::text),'') as fv_suppname,
                                        coalesce(trim(fv_suppadd1::text),'') as fv_suppadd1,
                                        coalesce(trim(fv_suppcity::text),'') as fv_suppcity,
                                        coalesce(trim(fv_expdname::text),'') as fv_expdname,
                                        coalesce(trim(fv_entrydate::text),'') as fv_entrydate,
                                        coalesce(trim(fv_reftgl::text),'') as fv_reftgl,
                                        coalesce(trim(fc_custcode::text),'') as fc_custcode,
                                        coalesce(trim(fc_potipe::text),'') as fc_potipe,
                                        coalesce(trim(fv_custname::text),'') as fv_custname,
                                        coalesce(trim(fv_custadd1::text),'') as fv_custadd1,
                                        coalesce(trim(fv_custcity::text),'') as fv_custcity
                                        from  sc_trx.vw_t_inmst_web where fc_trxno is not null $param
					order by fd_entrydate desc $paramtop $paramoffset ");
    }


    function q_t_indtl_web_online($param){
        return $this->db->query("select coalesce(trim(fc_branch    ::text),'') as fc_branch    ,
                                        coalesce(trim(fc_trxno     ::text),'') as fc_trxno     ,
                                        coalesce(trim(fc_stockcode ::text),'') as fc_stockcode ,
                                        coalesce(trim(fn_nomor     ::text),'') as fn_nomor     ,
                                        coalesce(trim(fn_qty       ::text),'') as fn_qty       ,
                                        coalesce(trim(fn_qtyrec    ::text),'') as fn_qtyrec    ,
                                        coalesce(trim(fn_extra     ::text),'') as fn_extra     ,
                                        coalesce(trim(fn_extrarec  ::text),'') as fn_extrarec  ,
                                        coalesce(trim(fc_reason    ::text),'') as fc_reason    ,
                                        coalesce(trim(fm_pricelist ::text),'') as fm_pricelist ,
                                        coalesce(trim(fn_disc1p    ::text),'') as fn_disc1p    ,
                                        coalesce(trim(fn_disc2p    ::text),'') as fn_disc2p    ,
                                        coalesce(trim(fn_disc3p    ::text),'') as fn_disc3p    ,
                                        coalesce(trim(fm_formula   ::text),'') as fm_formula   ,
                                        coalesce(trim(fc_excludeppn::text),'') as fc_excludeppn,
                                        coalesce(trim(fm_brutto    ::text),'') as fm_brutto    ,
                                        coalesce(trim(fm_netto     ::text),'') as fm_netto     ,
                                        coalesce(trim(fm_dpp       ::text),'') as fm_dpp       ,
                                        coalesce(trim(fm_ppn       ::text),'') as fm_ppn       ,
                                        coalesce(trim(fm_valuestock::text),'') as fm_valuestock,
                                        coalesce(trim(fc_editcost  ::text),'') as fc_editcost  ,
                                        coalesce(trim(fc_update    ::text),'') as fc_update    ,
                                        coalesce(trim(fc_docno     ::text),'') as fc_docno     ,
                                        coalesce(trim(fc_taxin     ::text),'') as fc_taxin     ,
                                        coalesce(trim(fn_pph22     ::text),'') as fn_pph22     ,
                                        coalesce(trim(fm_pph22     ::text),'') as fm_pph22     ,
                                        coalesce(trim(fn_qtygnt    ::text),'') as fn_qtygnt    ,
                                        coalesce(trim(fn_extragnt  ::text),'') as fn_extragnt  ,
                                        coalesce(trim(fn_qtygntmp  ::text),'') as fn_qtygntmp  ,
                                        coalesce(trim(fn_extragntmp::text),'') as fn_extragntmp,
                                        coalesce(trim(ft_note      ::text),'') as ft_note      ,
                                        coalesce(trim(stockname    ::text),'') as stockname    ,
                                        coalesce(trim(packname     ::text),'') as packname     ,
										coalesce(trim(fc_entrydate ::text),'') as fc_entrydate from (
								select a.*,to_char(fd_entrydate,'yyyy-mm-dd')as fc_entrydate from sc_trx.vw_t_indtl_web a 
								left outer join sc_trx.t_inmst_web b on a.fc_trxno=b.fc_trxno) as x where fc_trxno is not null $param");
    }

    function check_t_image($param){
	    return $this->db->query("select * from sc_trx.t_image where docno is not null $param");
    }

    function q_inmstxdtl_web_online($param){
	    return $this->db->query("select * from (
                                    select 
                                    b.*,a.fc_stockcode,a.fn_nomor,a.fn_qty,a.fn_qtyrec,a.fn_extra,a.fn_extrarec,a.fc_docno,a.stockname,a.packname
                                    from sc_trx.vw_t_indtl_web a 
                                    left outer join sc_trx.vw_t_inmst_web b on a.fc_trxno=b.fc_trxno) as x
                                    where fc_trxno is not null $param
                                    order by fc_trxno");
    }

}	