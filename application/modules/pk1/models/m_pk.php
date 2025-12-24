<?php
class M_pk extends CI_Model
{
	var $columnspk = array('nodok', 'nodokref', 'nopol', 'nmbarang', 'nmbengkel');
	var $orderspk = array('nodokref' => 'desc', 'nodok' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function q_setup_day_backwards()
	{
		return $this->db->query("select * from sc_mst.option where kdoption='PDCACL01'");
	}

	function q_versidb($kodemenu)
	{
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}

	function q_pk_atasan()
	{
		return $this->db->query("select * from sc_mst.option where kdoption='PKPA:S' and status='T'");
	}

	function q_option_close_fs()
	{
		return $this->db->query("select *,coalesce(status,'') as statusclose from sc_mst.option where kdoption='PKPACL'");
	}
	function q_trxerror($paramtrxerror)
	{
		return $this->db->query("select * from (
                                    select a.*,b.description from sc_mst.trxerror a
                                    left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
                                    where userid is not null $paramtrxerror");
	}

	function q_folowing_atasan($param)
	{
		return $this->db->query("select nik,nikatasan from (
					select nik,nik as nikatasan from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
					union all
					select nik,nik_atasan as nikatasan from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
					union all
					select nik,nik_atasan2 as nikatasan from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO') as x
					where nik is not null $param");
	}

	function q_deltrxerror($paramtrxerror)
	{
		return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
	}

	function q_view_generate_kriteria($param)
	{
		return $this->db->query("select * from (
			select a1.nodok,a1.idbu,a1.periode,a1.status as statustx,a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,
			f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2,h.uraian as nmstatus 
			from sc_pk.pa_form_pa_trx_mst a1
			left outer join sc_mst.karyawan a on a.nik=a1.nik
			left outer join sc_mst.departmen b on a.bag_dept=b.kddept
			left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
			left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
			left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
			left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
			left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
			left outer join sc_mst.trxtype h on a1.status=h.kdtrx and h.jenistrx='PKPA'
			) as x
			where branch is not null $param
			order by CASE WHEN x.statustx = 'A' THEN 1 ELSE 2 END, 
			periode desc,nmlengkap asc ");
	}

	function q_tx_form_pa_tmp_mst($param)
	{
		return $this->db->query("select * from (
									select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,case when tpa='A1' then 'ATASAN 1' when tpa='A2' then 'ATASAN 2' end as tipeatasan,c.uraian as nmstatus 
									from sc_pk.pa_form_pa_tmp_mst a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='PKPA') as x
									where branch is not null   $param");
	}

	function q_tx_form_pa_tmp_mst_nonatasan($param)
	{
		$nama = trim($this->session->userdata('nik'));
		return $this->db->query("select branch       ,
										idbu         ,
										nodok        ,
										periode      ,
										nik          ,
										tpa          ,
										nikatasan1   ,
										nikatasan2   ,
										ttlvalue1    ,
										ttlvalue2    ,
										f_value      ,
										f_value_ktg  ,
										description  ,
										note  		 ,
										suggestion   ,
										inputdate    ,
										inputby      ,
										updatedate   ,
										updateby     ,
										nodoktmp     ,
										status       ,
										f_kdvalue_ktg,
										f_desc_ktg   ,
										nmlengkap    ,
										nmatasan1    ,
										nmatasan2    ,
										tipeatasan   ,
										nmstatus from (
									select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,case when tpa='A1' then 'ATASAN 1' when tpa='A2' then 'ATASAN 2' end as tipeatasan,c.uraian as nmstatus 
									from sc_pk.pa_form_pa_tmp_mst a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='PKPA') as x
									where branch is not null   $param");
	}


	function q_tx_form_pa_tmp_dtl($param)
	{
		$order = " ORDER BY periode,nik,tpa,kdaspek,kdkriteria;";
		$limit = "";
		return $this->db->query("select * from (
                                    select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.description as nmaspek,case when tpa='A1' then 'ATASAN 1' when tpa='A2' then 'ATASAN 2' end as tipeatasan,d.uraian as nmstatus, e.fulldescription
									from sc_pk.pa_form_pa_tmp_dtl a
                                    left outer join sc_mst.karyawan b1 on a.nik=b1.nik
                                    left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
                                    left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
                                    left outer join sc_pk.m_aspek c on a.kdaspek=c.kdaspek
                                    join sc_pk.m_aspek_kriteria e on a.kdkriteria=e.kdkriteria
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='PKPA') as x
                                    where branch is not null $param $order");
	}

	function q_tx_form_pa_trx_mst($param)
	{
		return $this->db->query("select * from (
                                    select a.*,b1.bag_dept,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,case when tpa='A1' then 'ATASAN 1' when tpa='A2' then 'ATASAN 2' end as tipeatasan,c.uraian as nmstatus,a.status as statustx
									from sc_pk.pa_form_pa_trx_mst a
                                    left outer join sc_mst.karyawan b1 on a.nik=b1.nik
                                    left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
                                    left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='PKPA') as x
                                    where branch is not null   $param");
	}

	function q_tx_form_pa_trx_dtl($param)
	{
		$order = " ORDER BY periode,nik,tpa,kdaspek,kdkriteria;";
		$limit = "";
		return $this->db->query("select * from (
									select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.description as nmaspek,case when tpa='A1' then 'ATASAN 1' when tpa='A2' then 'ATASAN 2' end as tipeatasan,d.uraian as nmstatus, e.fulldescription 
									from sc_pk.pa_form_pa_trx_dtl a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_pk.m_aspek c on a.kdaspek=c.kdaspek
									join sc_pk.m_aspek_kriteria e on a.kdkriteria=e.kdkriteria
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='PKPA') as x
									where branch is not null $param $order");
	}

	function q_list_report($param)
	{
		$order = " ORDER BY periode desc, nmlengkap;";
		$limit = "";
		return $this->db->query("select * from (
									select a.*,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,b.nmlengkap,b1.nmlengkap as nmatasan1,b2.nmlengkap as nmatasan2,g.kdvalue as kdbpa,g.description as bpa from sc_pk.pa_report_final a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.karyawan b1 on b.nik_atasan=b1.nik
									left outer join sc_mst.karyawan b2 on b.nik_atasan2=b2.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept
									left outer join sc_mst.subdepartmen d on b.subbag_dept=d.kdsubdept and d.kddept=b.bag_dept
									left outer join sc_mst.lvljabatan e on b.lvl_jabatan=e.kdlvl 
									left outer join sc_mst.jabatan f on b.jabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
									left outer join sc_pk.m_bobot g on g.value1::numeric=ceil(a.f_value_ktg::numeric) and g.kdcategory='PA') as x
									where nodok is not null $param $order");
	}

	function q_list_report_new($param)
	{
		$order = " ORDER BY periode desc, nmlengkap;";
		return $this->db->query("SELECT a.*, c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,b.nmlengkap,b1.nmlengkap as nmatasan1,b2.nmlengkap as nmatasan2,g.kdvalue as kdbpa,g.description as bpa 
					FROM(
						select m.branch,m.idbu,m.nodok,m.periode,m.nik,m.nikatasan1,m.nikatasan2,ttlvalue1,f_value_ktg,
						max(CASE WHEN kdkriteria = 'AS01-01' THEN d.value1 END) as na1,
						max(CASE WHEN kdkriteria = 'AS01-02' THEN d.value1 END) as na2,
						max(CASE WHEN kdkriteria = 'AS01-03' THEN d.value1 END) as na3,
						max(CASE WHEN kdkriteria = 'AS01-04' THEN d.value1 END) as na4,
						max(CASE WHEN kdkriteria = 'AS01-05' THEN d.value1 END) as na5,
						max(CASE WHEN kdkriteria = 'AS02-01' THEN d.value1 END) as na6,
						max(CASE WHEN kdkriteria = 'AS02-02' THEN d.value1 END) as na7,
						max(CASE WHEN kdkriteria = 'AS02-03' THEN d.value1 END) as na8,
						max(CASE WHEN kdkriteria = 'AS02-04' THEN d.value1 END) as na9,
						max(CASE WHEN kdkriteria = 'AS02-05' THEN d.value1 END) as na10,
						max(CASE WHEN kdkriteria = 'AS02-06' THEN d.value1 END) as na11,
						max(CASE WHEN kdkriteria = 'AS03-01' THEN d.value1 END) as na12,
						max(CASE WHEN kdkriteria = 'AS03-02' THEN d.value1 END) as na13,
						m.note, m.suggestion
						from sc_pk.pa_form_pa_trx_mst m
						full join sc_pk.pa_form_pa_trx_dtl d on m.nodok = d.nodok
						where m.status='P'
						GROUP BY m.branch,m.idbu,m.nodok,m.periode,m.nik,m.nikatasan1,m.nikatasan2) a
					left outer join sc_mst.karyawan b on a.nik=b.nik
					left outer join sc_mst.karyawan b1 on b.nik_atasan=b1.nik
					left outer join sc_mst.karyawan b2 on b.nik_atasan2=b2.nik
					left outer join sc_mst.departmen c on b.bag_dept=c.kddept
					left outer join sc_mst.subdepartmen d on b.subbag_dept=d.kdsubdept and d.kddept=b.bag_dept
					left outer join sc_mst.lvljabatan e on b.lvl_jabatan=e.kdlvl 
					left outer join sc_mst.jabatan f on b.jabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
					left outer join sc_pk.m_bobot g on g.value1::numeric=ceil(a.f_value_ktg::numeric) and g.kdcategory='PA'
					where nodok is not null $param 
					$order
				");
	}

	function q_mst_dokumen_inspek_all($param)
	{
		return $this->db->query("select * from sc_pk.m_dokumen where branch is not null $param order by branch,kdjabatan,kdarea,kdpa");
	}

	function q_mst_dokumen_inspek($param)
	{
		return $this->db->query("select * from sc_pk.m_dokumen where branch is not null and kdpa not in (select trim(kdpa) as kdpa from sc_pk.m_mapping_tmp_area where branch is not null $param) order by branch,kdjabatan,kdarea,kdpa");
	}

	function q_tmp_mapping($param)
	{
		return $this->db->query("select * from sc_pk.m_mapping_tmp_area where branch is not null $param order by branch,nik,kdarea,kdpa");
	}

	function q_mst_mapping($param)
	{
		return $this->db->query("select * from sc_pk.m_mapping_area where branch is not null $param order by branch,nik,kdarea,kdpa");
	}

	function add_mapping_inspek_tmp($data = array())
	{
		$insert = $this->db->insert_batch('sc_pk.m_mapping_tmp_area', $data);
		return $insert ? true : false;
	}

	function add_mapping_inspek_tmp_automatic($nik)
	{
		return $this->db->query("	delete from sc_pk.m_mapping_tmp_area where nik='$nik';
									insert into sc_pk.m_mapping_tmp_area (select * from sc_pk.m_mapping_area where nik='$nik' order by nomor asc);
		");
	}

	function add_mapping_inspek_trx($nik)
	{
		return $this->db->query("	delete from sc_pk.m_mapping_area where nik='$nik';
									insert into sc_pk.m_mapping_area (select * from sc_pk.m_mapping_tmp_area where nik='$nik' order by nomor asc);
									delete from sc_pk.m_mapping_tmp_area where nik='$nik';
		");
	}

	function q_inspek_tmp_mst($param)
	{
		return $this->db->query("select * from (
									select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.uraian as nmstatus 
									from sc_pk.vw_inspek_tmp_mst a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='PKPA') as x
									where branch is not null   $param
								");
	}

	function q_inspek_tmp_dtl($param)
	{
		$order = " ORDER BY periode,nik,kdpa,kdarea;";
		$limit = "";
		return $this->db->query("select * from (
									select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.description as nmarea,c.pic,d.uraian as nmstatus 
									from sc_pk.inspek_tmp_dtl a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_pk.m_area c on a.kdarea=c.kdarea
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='PKPA') as x
									where branch is not null $param $order
								");
	}

	function q_inspek_trx_mst($param)
	{
		return $this->db->query("select * from (
									select a.*,b1.nmlengkap as nmlengkap,b1.bag_dept as kddept,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.uraian as nmstatus 
									from sc_pk.vw_inspek_trx_mst a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='PKPA') as x
									where branch is not null   $param
								");
	}

	function q_inspek_trx_dtl($param)
	{
		$order = " ORDER BY periode,nik,kdpa,kdarea;";
		$limit = "";
		return $this->db->query("select * from (
									select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.description as nmarea,c.pic,d.uraian as nmstatus 
									from sc_pk.inspek_trx_dtl a
									left outer join sc_mst.karyawan b1 on a.nik=b1.nik
									left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
									left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
									left outer join sc_pk.m_area c on a.kdarea=c.kdarea
									left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='PKPA') as x
									where branch is not null $param $order
								");
	}

	function q_view_final_kpi($param)
	{
		return $this->db->query("select * from (
									select a1.nodok,a1.idbu,a1.periode,a1.status as statustx,a1.rownya,a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2,h.uraian as nmstatus,i.status as statusfinalpk from 
									(
									select branch,idbu,periode,nik,status,nodok,right(nodok,1)::int as rownya 
									from sc_pk.kpi_trx_mst where branch is not null 
									group by branch,idbu,periode,nik,status,nodok 
									) as a1
									left outer join sc_mst.karyawan a on a.nik=a1.nik
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
									left outer join sc_mst.trxtype h on a1.status=h.kdtrx and h.jenistrx='PKPA'
									left outer join sc_pk.final_report_pk i on a1.nik=i.nik and i.periode=a1.periode) as x
									where branch is not null $param
									order by branch,idbu,periode,nmlengkap  
								");
	}

	function q_view_trx_inspek_notmax($param)
	{
		return $this->db->query("select * from (
									select a1.nodok,a1.idbu,a1.periode,a1.status as statustx,a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2,h.uraian as nmstatus from 
									(
									select branch,idbu,periode,nik,status,nodok from sc_pk.inspek_trx_mst   where branch is not null 
									group by branch,idbu,periode,nik,status,nodok 
									) as a1
									left outer join sc_mst.karyawan a on a.nik=a1.nik
									left outer join sc_mst.departmen b on a.bag_dept=b.kddept
									left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
									left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
									left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
									left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
									left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
									left outer join sc_mst.trxtype h on a1.status=h.kdtrx and h.jenistrx='PKPA') as x
									where branch is not null $param
									order by branch,idbu,periode,nmlengkap,nodok  
								");

	}

	function q_view_final_kondite($param)
	{
		return $this->db->query("select * from (
			select a1.nodok,a1.idbu,a1.periode,a1.status as statustx,a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2,h.uraian as nmstatus 
			FROM sc_pk.kondite_trx_rekap a1
			left outer join sc_mst.karyawan a on a.nik=a1.nik
			left outer join sc_mst.departmen b on a.bag_dept=b.kddept
			left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
			left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
			left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
			left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
			left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
			left outer join sc_mst.trxtype h on a1.status=h.kdtrx and h.jenistrx='PKPA') as x
			where branch is not null $param
			order by CASE WHEN x.statustx = 'A' THEN 1 ELSE 2 END, 
			periode desc,nmlengkap asc ");

	}

	function q_kondite_trx_rekap($param)
	{
		$order = " ORDER BY periode,nik,nmlengkap;";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan, g.uraian as nmstatus
										from sc_pk.kondite_trx_rekap a
										left outer join sc_mst.karyawan b1 on a.nik=b1.nik
										left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
										left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
										left outer join sc_mst.departmen c on b1.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b1.subbag_dept=d.kdsubdept and d.kddept=b1.bag_dept
										left outer join sc_mst.lvljabatan e on b1.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b1.jabatan=f.kdjabatan and f.kdsubdept=b1.subbag_dept and f.kddept=b1.bag_dept
										left outer join sc_mst.trxtype g on a.status=g.kdtrx and g.jenistrx='PKPA'
										) as x
										where branch is not null $param $order
								");
	}

	function q_kondite_tmp_rekap($param)
	{
		$order = " ORDER BY periode,nik,nmlengkap;";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan, g.uraian as nmstatus 
										from sc_pk.kondite_tmp_rekap a
										left outer join sc_mst.karyawan b1 on a.nik=b1.nik
										left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
										left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
										left outer join sc_mst.departmen c on b1.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b1.subbag_dept=d.kdsubdept and d.kddept=b1.bag_dept
										left outer join sc_mst.lvljabatan e on b1.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b1.jabatan=f.kdjabatan and f.kdsubdept=b1.subbag_dept and f.kddept=b1.bag_dept
										left outer join sc_mst.trxtype g on a.status=g.kdtrx and g.jenistrx='PKPA'
										) as x
										where branch is not null $param $order
								");
	}

	function q_kondite_trx_mst($param)
	{
		$order = " ORDER BY periode,nik,nmlengkap;";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan, g.uraian as nmstatus
										from sc_pk.kondite_trx_mst a
										left outer join sc_mst.karyawan b1 on a.nik=b1.nik
										left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
										left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
										left outer join sc_mst.departmen c on b1.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b1.subbag_dept=d.kdsubdept and d.kddept=b1.bag_dept
										left outer join sc_mst.lvljabatan e on b1.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b1.jabatan=f.kdjabatan and f.kdsubdept=b1.subbag_dept and f.kddept=b1.bag_dept
										left outer join sc_mst.trxtype g on a.status=g.kdtrx and g.jenistrx='PKPA'
										) as x
										where branch is not null $param $order
								");
	}

	function q_kondite_tmp_mst($param)
	{
		$order = " ORDER BY periode,nik,nmlengkap;";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,b1.nmlengkap as nmlengkap,b2.nmlengkap as nmatasan1,b3.nmlengkap as nmatasan2,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan, g.uraian as nmstatus 
										from sc_pk.kondite_tmp_mst a
										left outer join sc_mst.karyawan b1 on a.nik=b1.nik
										left outer join sc_mst.karyawan b2 on a.nikatasan1=b2.nik
										left outer join sc_mst.karyawan b3 on a.nikatasan2=b3.nik
										left outer join sc_mst.departmen c on b1.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b1.subbag_dept=d.kdsubdept and d.kddept=b1.bag_dept
										left outer join sc_mst.lvljabatan e on b1.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b1.jabatan=f.kdjabatan and f.kdsubdept=b1.subbag_dept and f.kddept=b1.bag_dept
										left outer join sc_mst.trxtype g on a.status=g.kdtrx and g.jenistrx='PKPA'
										) as x
										where branch is not null $param $order
								");
	}

	function add_kondite_tmp_rekap($data)
	{
		$this->db->insert('sc_pk.kondite_tmp_rekap', $data);
	}

	function q_list_inspek_report($param)
	{
		$order = " ORDER BY periode,nik";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,b.nmlengkap,b1.nmlengkap as nmatasan1,b2.nmlengkap as nmatasan2,g.kdvalue as kdbpa,g.description as bpa from sc_pk.inspek_report_final a 
										left outer join sc_mst.karyawan b on a.nik=b.nik
										left outer join sc_mst.karyawan b1 on b.nik_atasan=b1.nik
										left outer join sc_mst.karyawan b2 on b.nik_atasan2=b2.nik
										left outer join sc_mst.departmen c on b.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b.subbag_dept=d.kdsubdept and d.kddept=b.bag_dept
										left outer join sc_mst.lvljabatan e on b.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b.jabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
										left outer join sc_pk.m_bobot g on g.value1=a.f_fs and g.kdcategory='INSPEK') as x
										where nodok is not null $param");
	}

	function q_list_kondite_report($param)
	{
		$order = " ORDER BY periode";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,b.nmlengkap,b1.nmlengkap as nmatasan1,b2.nmlengkap as nmatasan2,g.kdvalue as kdbpa,g.description as bpa from sc_pk.kondite_trx_mst a 
										left outer join sc_mst.karyawan b on a.nik=b.nik
										left outer join sc_mst.karyawan b1 on b.nik_atasan=b1.nik
										left outer join sc_mst.karyawan b2 on b.nik_atasan2=b2.nik
										left outer join sc_mst.departmen c on b.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b.subbag_dept=d.kdsubdept and d.kddept=b.bag_dept
										left outer join sc_mst.lvljabatan e on b.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b.jabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
										left outer join sc_pk.m_bobot g on g.kdvalue=a.f_kdvalue_fs and g.kdcategory='KONDITE') as x
										where nodok is not null $param $order");
	}

	function q_summary_kondite_report($param)
	{
		$order = " ORDER BY periode";
		$limit = "";
		return $this->db->query("SELECT branch, nik, nmlengkap, nmsubdept, nmjabatan, min(periode)||'-'||max(periode) as periode, 
					SUM(ttlvalueip::numeric) as ttlvalueip, SUM(ttlvaluesd::numeric) as ttlvaluesd, SUM(ttlvalueal::numeric) as ttlvalueal, 
					SUM(ttlvaluetl::numeric) as ttlvaluetl, SUM(ttlvaluesp1::numeric) as ttlvaluesp1, SUM(ttlvaluesp2::numeric) as ttlvaluesp2, 
					SUM(ttlvaluesp3::numeric) as ttlvaluesp3, SUM(ttlvaluect::numeric) as ttlvaluect, SUM(ttlvalueik::numeric) as ttlvalueik, 
					SUM(ttlvalueitl::numeric) as ttlvalueitl, SUM(ttlvalueipa::numeric) as ttlvalueipa, SUM(c2_ttlvalueip::numeric) as c2_ttlvalueip,
					SUM(c2_ttlvaluesd::numeric) as c2_ttlvaluesd, SUM(c2_ttlvalueal::numeric) as c2_ttlvalueal, SUM(c2_ttlvaluetl::numeric) as c2_ttlvaluetl,
					SUM(c2_ttlvaluesp1::numeric) as c2_ttlvaluesp1, SUM(c2_ttlvaluesp2::numeric) as c2_ttlvaluesp2, SUM(c2_ttlvaluesp3::numeric) as c2_ttlvaluesp3,
					SUM(c2_ttlvaluect::numeric) as c2_ttlvaluect, SUM(c2_ttlvalueik::numeric) as c2_ttlvalueik, SUM(c2_ttlvalueitl::numeric) as c2_ttlvalueitl,
					SUM(c2_ttlvalueipa::numeric) as c2_ttlvalueipa, SUM(ttlvalueitl::numeric) as ttlvalueitl, SUM(ttlvalueipa::numeric) as ttlvalueipa,
					(SUM(c2_ttlvaluesd::numeric) + SUM(c2_ttlvalueal::numeric) + SUM(c2_ttlvaluetl::numeric) + SUM(c2_ttlvaluesp1::numeric) + SUM(c2_ttlvaluesp2::numeric) 
					+ SUM(c2_ttlvaluesp3::numeric) + SUM(c2_ttlvaluect::numeric) + SUM(c2_ttlvalueik::numeric) + SUM(c2_ttlvalueitl::numeric) + SUM(c2_ttlvalueipa::numeric)) as total_score
				FROM (
					SELECT a.*, c.nmdept, d.nmsubdept, e.nmlvljabatan, f.nmjabatan, b.nmlengkap, b1.nmlengkap as nmatasan1, 
						b2.nmlengkap as nmatasan2, g.kdvalue as kdbpa, g.description as bpa
					FROM sc_pk.kondite_trx_mst a 
					LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
					LEFT OUTER JOIN sc_mst.karyawan b1 ON b.nik_atasan = b1.nik
					LEFT OUTER JOIN sc_mst.karyawan b2 ON b.nik_atasan2 = b2.nik
					LEFT OUTER JOIN sc_mst.departmen c ON b.bag_dept = c.kddept
					LEFT OUTER JOIN sc_mst.subdepartmen d ON b.subbag_dept = d.kdsubdept AND d.kddept = b.bag_dept
					LEFT OUTER JOIN sc_mst.lvljabatan e ON b.lvl_jabatan = e.kdlvl 
					LEFT OUTER JOIN sc_mst.jabatan f ON b.jabatan = f.kdjabatan AND f.kdsubdept = b.subbag_dept AND f.kddept = b.bag_dept
					LEFT OUTER JOIN sc_pk.m_bobot g ON g.kdvalue = a.f_kdvalue_fs AND g.kdcategory = 'KONDITE'
					WHERE true $param
					$order 
				) AS x
				WHERE nodok IS NOT NULL
				GROUP BY branch, nik, nmlengkap, nmsubdept, nmjabatan");
	}

	function q_list_kpi_report($param)
	{
		$order = " ORDER BY nmsubdept,nmjabatan,nmlengkap";
		$limit = "";
		return $this->db->query("select * from (
										select a.*,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,b.nmlengkap,b1.nmlengkap as nmatasan1,b2.nmlengkap as nmatasan2
										from sc_pk.kpi_trx_mst a 
										left outer join sc_mst.karyawan b on a.nik=b.nik
										left outer join sc_mst.karyawan b1 on b.nik_atasan=b1.nik
										left outer join sc_mst.karyawan b2 on b.nik_atasan2=b2.nik
										left outer join sc_mst.departmen c on b.bag_dept=c.kddept
										left outer join sc_mst.subdepartmen d on b.subbag_dept=d.kdsubdept and d.kddept=b.bag_dept
										left outer join sc_mst.lvljabatan e on b.lvl_jabatan=e.kdlvl 
										left outer join sc_mst.jabatan f on b.jabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept) as x
										where nodok is not null $param
										order by periode desc, nmlengkap asc");
	}

	function q_final_report_pk_trx($param)
	{
		return $this->db->query("select * from (
										select a1.*,a1.status as statustx,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan1,g.nmlengkap as nmatasan2,h.uraian as nmstatus,i.description as nmfs1,i1.description as nmfs2,b.nmdept from 
										(
										select * from sc_pk.final_report_pk   where branch is not null 
										group by branch,idbu,periode,nik,status,nodok 
										) as a1
										left outer join sc_mst.karyawan a on a.nik=a1.nik
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
										left outer join sc_mst.trxtype h on a1.status=h.kdtrx and h.jenistrx='PKPA'
										left outer join sc_pk.m_bobot i on a1.ktgs1=i.kdvalue and i.kdcategory='KONDITE' 
										left outer join sc_pk.m_bobot i1 on a1.ktgs2=i1.kdvalue and i1.kdcategory='KONDITE' ) as x
										where branch is not null $param
										order by inputdate desc, periode desc,nmlengkap asc");

	}

	function q_final_report_pk_tmp($param)
	{
		return $this->db->query("select * from (
										select a1.*,a1.status as statustx,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan1,g.nmlengkap as nmatasan2,h.uraian as nmstatus,i.description as nmfs1,i1.description as nmfs2 from 
										(
										select * from sc_pk.final_report_pk_tmp   where branch is not null 
										group by branch,idbu,periode,nik,status,nodok 
										) as a1
										left outer join sc_mst.karyawan a on a.nik=a1.nik
										left outer join sc_mst.departmen b on a.bag_dept=b.kddept
										left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
										left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
										left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
										left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
										left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
										left outer join sc_mst.trxtype h on a1.status=h.kdtrx and h.jenistrx='PKPA'
										left outer join sc_pk.m_bobot i on a1.ktgs1=i.kdvalue and i.kdcategory='KONDITE' 
										left outer join sc_pk.m_bobot i1 on a1.ktgs2=i1.kdvalue and i1.kdcategory='KONDITE' ) as x
										where branch is not null $param
										order by branch,idbu,periode,nmlengkap ");

	}

	function q_pk_option($param)
	{
		return $this->db->query("select * from sc_pk.m_pk_option where branch is not null $param");

	}

	function q_countofremidi($param)
	{
		return $this->db->query("select * from (
                                    select 	row_number() over (order by kdtrx,jenistrx,uraian nulls last) as nomor,* from sc_mst.trxtype 
                                    where jenistrx='REMIDIPK'
                                    ) as t1
                                    where jenistrx='REMIDIPK' $param");
	}

	function q_mstdepartmen($param)
	{
		return $this->db->query("select * from sc_mst.departmen where kddept is not null $param");
	}

	function q_final_score_pk_rekap_trx($param)
	{
		return $this->db->query("select * from (
                                      select a.*,b.nmdept,h.uraian as nmstatus, ''::varchar AS nik from sc_pk.rekap_final_report_pk_trx a
                                      left outer join sc_mst.departmen b on a.kddept=b.kddept
                                      left outer join sc_mst.trxtype h on a.status=h.kdtrx and h.jenistrx='PKPA') as x 
                                      where branch is not null $param");
	}

	function q_final_score_pk_rekap_tmp($param)
	{
		return $this->db->query("select * from (
                                      select a.*,b.nmdept,h.uraian as nmstatus, ''::VARCHAR AS nik from sc_pk.rekap_final_report_pk_tmp a
                                      left outer join sc_mst.departmen b on a.kddept=b.kddept
                                      left outer join sc_mst.trxtype h on a.status=h.kdtrx and h.jenistrx='PKPA') as x 
                                      where branch is not null $param");
	}

	function q_cekclosepa($param)
	{
		return $this->db->query("select * from sc_pk.inspek_trx_mst where status in ('A','I')  and periode='201810';
select * from sc_pk.kondite_trx_mst where status in ('A','I') and periode='201810';
select * from sc_pk.pa_form_pa_trx_mst where status in ('A','I')  and periode='201810';");
	}



	/* M_KARYAWAN LIST FOR KONDITE START */
	var $t_lv_karyawan_kondite = "sc_mst.lv_m_karyawan";
	var $t_lv_karyawan_kondite_column = array('nik', 'nmlengkap', 'nmdept'); //set column field database for datatable
	var $t_lv_karyawan_kondite_order = array('nmlengkap' => 'asc'); // default order

	private function _get_t_lv_karyawan_kondite_query($param_list_akses_nik)
	{
		$this->db->where(" nik is not null $param_list_akses_nik", NULL, FALSE);
		$this->db->where("coalesce(statuskepegawaian,'') !=", "KO");
		$this->db->from($this->t_lv_karyawan_kondite);
		$i = 0;

		foreach ($this->t_lv_karyawan_kondite_column as $item) {
			if ($_POST['search']['value'])
				($i === 0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			if ($_POST['order']['0']['column'] != 0) { //diset klo post column 0
				$this->db->order_by($this->t_lv_karyawan_kondite_order[$_POST['order']['0']['column'] - 1], $_POST['order']['0']['dir']);
			}
		} else if (isset($this->t_lv_karyawan_kondite_order)) {
			$order = $this->t_lv_karyawan_kondite_order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function get_t_lv_karyawan_kondite($param_list_akses_nik)
	{
		$this->_get_t_lv_karyawan_kondite_query($param_list_akses_nik);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function t_lv_karyawan_kondite_count_filtered($param_list_akses_nik)
	{
		$this->_get_t_lv_karyawan_kondite_query($param_list_akses_nik);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function t_lv_karyawan_kondite_count_all($param_list_akses_nik)
	{
		$this->db->where(" nik is not null $param_list_akses_nik", NULL, FALSE);
		$this->db->where("coalesce(statuskepegawaian,'') !=", "KO");
		$this->db->from($this->t_lv_karyawan_kondite);
		return $this->db->count_all_results();
	}

	public function get_t_lv_karyawan_kondite_by_id($id)
	{
		$this->db->from($this->t_lv_karyawan_kondite);
		$this->db->where('nik', $id);
		$query = $this->db->get();

		return $query->row();
	}

	/* M_KARYAWAN LIST FOR KONDITE END */

	public function get_final_penilaian_karyawan($nik, $periode)
	{
		return $this->db->query("SELECT k.nmlengkap as nama, f.nik as nik, j.nmjabatan as jabatan, d.nmdept as bagian, to_char(k.tglmasukkerja, 'DD-MM-YYYY') AS tglmasukkerja, CONCAT(TO_CHAR(TO_DATE(SUBSTRING(f.periode,1,6), 'YYYYMM'), 'Month YYYY'),' sd ',TO_CHAR(TO_DATE(SUBSTRING(f.periode,8,6), 'YYYYMM'), 'Month YYYY')) as periode,  
								a1.nmlengkap as atasan1, a2.nmlengkap as atasan2, f.note as catatan, f.suggestion as saran, fs1_pa as pa, fs1_kondite as kondite, f.fs1_kpi as kpi,
								ttls1 AS nilai_akhir
								from sc_pk.final_report_pk f 
								join sc_mst.karyawan k on f.nik = k.nik 
								join sc_mst.jabatan j on k.jabatan = j.kdjabatan 
								join sc_mst.departmen d on k.bag_dept = d.kddept
								join sc_mst.karyawan a1 on a1.nik = k.nik_atasan 
								join sc_mst.karyawan a2 on a2.nik = k.nik_atasan2 
								where f.nik = '$nik' and f.periode ='$periode'");
	}

	public function get_penilaian_pa($nik, $periode)
	{
		return $this->db->query("SELECT ma.description as aspek, mak.description as kriteria, p.value1 as penilaian1, p.value2 as penilaian2, 
								(p.value1::double precision + p.value2::double precision) as total, (p.value1::double precision + p.value2::double precision)/2 as rata_rata 
								from sc_pk.pa_form_pa_trx_dtl p
								join sc_pk.m_aspek ma on p.kdaspek = ma.kdaspek 
								join sc_pk.m_aspek_kriteria mak on p.kdkriteria = mak.kdkriteria 
								where p.nik = '$nik' and p.periode ='$periode'
								ORDER BY nomor::NUMERIC asc");
	}

	public function get_penilaian_kondite($nik, $periode)
	{
		return $this->db->query("SELECT sum(ttlvalueip::NUMERIC) AS jml_ip, sum(ttlvaluesd::NUMERIC) AS jml_sd, sum(ttlvalueal::NUMERIC) AS jml_al, sum(ttlvaluetl::NUMERIC) AS jml_tl,sum(ttlvalueitl::NUMERIC) AS jml_itl,sum(ttlvalueipa::NUMERIC) AS jml_ipa, sum(ttlvaluesp1::NUMERIC) AS jml_sp1, sum(ttlvaluesp2::NUMERIC) AS jml_sp2, 
								sum(ttlvaluesp3::NUMERIC) AS jml_sp3, sum(ttlvaluect::NUMERIC) AS jml_ct, sum(ttlvalueik::NUMERIC) AS jml_ik, sum(c2_ttlvalueip::NUMERIC) AS nilai_ip, sum(c2_ttlvaluesd::NUMERIC) AS nilai_sd, sum(c2_ttlvalueal::NUMERIC) AS nilai_al,
								sum(c2_ttlvaluetl::NUMERIC) AS nilai_tl, sum(c2_ttlvalueitl::NUMERIC) AS nilai_itl, sum(c2_ttlvalueipa::NUMERIC) AS nilai_ipa, sum(c2_ttlvaluesp1::NUMERIC) AS nilai_sp1, sum(c2_ttlvaluesp2::NUMERIC) AS nilai_sp2, sum(c2_ttlvaluesp3::NUMERIC)  AS nilai_sp3, sum(c2_ttlvaluect::NUMERIC) AS nilai_ct, 
								sum(c2_ttlvalueik::NUMERIC) AS nilai_ik,
								sum(c2_ttlvalueip::NUMERIC) + sum(c2_ttlvaluesd::NUMERIC) + sum(c2_ttlvalueal::NUMERIC) + sum(c2_ttlvaluetl::NUMERIC) + sum(c2_ttlvalueitl::NUMERIC) + sum(c2_ttlvalueipa::NUMERIC) + sum(c2_ttlvaluetl::NUMERIC) + sum(c2_ttlvaluesp1::NUMERIC) + sum(c2_ttlvaluesp2::NUMERIC) 
								+ sum(c2_ttlvaluesp3::NUMERIC) + sum(c2_ttlvaluect::NUMERIC) + sum(c2_ttlvalueik::NUMERIC) AS total								
								from sc_pk.kondite_trx_mst k
								where k.nik = '$nik' and k.periode between SUBSTRING('$periode',1,6) and SUBSTRING('$periode',8,6)");
	}

	function q_transaction_read_where_pa($clause = null)
	{
		return $this->db->query($this->q_transaction_txt_where_pa($clause));
	}
	function q_transaction_txt_where_pa($clause = null)
	{
		return sprintf(<<<'SQL'
			SELECT * FROM (
				SELECT
                    COALESCE(TRIM(a.nik), '') AS nik,
                    COALESCE(TRIM(a.nodok), '') AS nodok,
                    COALESCE(TRIM(a.periode), '') AS periode,
                    COALESCE(TRIM(a.status), '') AS status,
                    COALESCE(TRIM(a.inputby), '') AS input_by,
                    COALESCE(TRIM(a.updateby), '') AS update_by,
                    a.updatedate AS update_date,
                    COALESCE(TRIM(b.nmlengkap, '')) AS nmlengkap,
                    nmdept as bagian,
                    CONCAT(COALESCE(TRIM(nikatasan1), ''), '.', COALESCE(TRIM(nikatasan2), '')) AS superiors,
                    CASE
                        WHEN a.status='P' THEN 'DISETUJUI/PRINT'    
                        WHEN a.status='C' THEN 'DIBATALKAN'
                        WHEN a.status='I' THEN 'INPUT'
                        WHEN a.status='A' THEN 'PERLU PERSETUJUAN'
                        WHEN a.status='D' THEN 'DIHAPUS'
                    END AS formatstatus,
                    TO_CHAR(a.inputdate,'DD-MM-YYYY') AS input_date
				FROM sc_pk.pa_form_pa_trx_mst a
				left outer join sc_mst.karyawan b on a.nik=b.nik
                left outer join sc_mst.departmen c on b.bag_dept=c.kddept
                where TRUE
			) AS aa WHERE TRUE
SQL
		) . $clause;
	}

	function q_transaction_read_where_kondite($clause = null)
	{
		return $this->db->query($this->q_transaction_txt_where_kondite($clause));
	}
	function q_transaction_txt_where_kondite($clause = null)
	{
		return sprintf(<<<'SQL'
			SELECT * FROM (
				SELECT
                    COALESCE(TRIM(a.nik), '') AS nik,
                    COALESCE(TRIM(a.nodok), '') AS nodok,
                    COALESCE(TRIM(a.periode), '') AS periode,
                    COALESCE(TRIM(a.status), '') AS status,
                    COALESCE(TRIM(a.inputby), '') AS input_by,
                    COALESCE(TRIM(a.updateby), '') AS update_by,
                    a.updatedate AS update_date,
                    COALESCE(TRIM(b.nmlengkap, '')) AS nmlengkap,
                    nmdept as bagian,
                    CONCAT(COALESCE(TRIM(nikatasan1), ''), '.', COALESCE(TRIM(nikatasan2), '')) AS superiors,
                    CASE
                        WHEN a.status='P' THEN 'DISETUJUI/PRINT'    
                        WHEN a.status='C' THEN 'DIBATALKAN'
                        WHEN a.status='I' THEN 'INPUT'
                        WHEN a.status='A' THEN 'PERLU PERSETUJUAN'
                        WHEN a.status='D' THEN 'DIHAPUS'
                    END AS formatstatus,
                    TO_CHAR(a.inputdate,'DD-MM-YYYY') AS input_date
				FROM sc_pk.kondite_trx_rekap a
				left outer join sc_mst.karyawan b on a.nik=b.nik
                left outer join sc_mst.departmen c on b.bag_dept=c.kddept
                where TRUE
			) AS aa WHERE TRUE
SQL
		) . $clause;
	}

	function q_transaction_read_where_fpk($clause = null)
	{
		return $this->db->query($this->q_transaction_txt_where_fpk($clause));
	}
	function q_transaction_txt_where_fpk($clause = null)
	{
		return sprintf(<<<'SQL'
			SELECT * FROM (
				SELECT
                    COALESCE(TRIM(a.nodok), '') AS nodok,
                    COALESCE(TRIM(a.periode), '') AS periode,
					COALESCE(TRIM(a.kddept), '') AS kddept,
                    COALESCE(TRIM(a.status), '') AS status,
                    COALESCE(TRIM(a.inputby), '') AS input_by,
                    COALESCE(TRIM(a.updateby), '') AS update_by,
                    a.updatedate AS update_date,
                    nmdept as bagian,
                    CASE
                        WHEN a.status='P' THEN 'DISETUJUI/PRINT'    
                        WHEN a.status='C' THEN 'DIBATALKAN'
                        WHEN a.status='I' THEN 'INPUT'
                        WHEN a.status='A' THEN 'PERLU PERSETUJUAN'
                        WHEN a.status='D' THEN 'DIHAPUS'
                    END AS formatstatus,
                    TO_CHAR(a.inputdate,'DD-MM-YYYY') AS input_date
				FROM sc_pk.rekap_final_report_pk_trx a
                left outer join sc_mst.departmen c on a.kddept=c.kddept
                where TRUE
			) AS aa WHERE TRUE
SQL
		) . $clause;
	}

	function recalculateConditeeBySelection($date = null, $nik = '')
	{
		$beginDate = (is_null($date) ? date('Y-m-d') : $date);
		$user = $nik;
		if (!empty($nik)) {
			return $this->db->query("select sc_pk.pr_autogenerate_conditee_recalculate_month_nik('SYSTEM','$user','$beginDate');");
		} else {
			return $this->db->query("select sc_pk.pr_autogenerate_conditee_recalculate_month('SYSTEM','$beginDate');");
		}
	}

	function list_pa_questions()
	{
		$this->db->select('kdkriteria, questionid, point, description');
		$query = $this->db->get('sc_pk.m_aspek_question');

		return $query;
	}

	function q_option($arg)
	{
		$query = $this->db->select('*')->where($arg)->get('sc_mst.option');
		return $query;
	}

	function q_list_kpi_report_yearly($arg)
	{

		return $this->db->query("SELECT * from (SELECT 
				nik,
				nmlengkap,
				nmsubdept,
				nmjabatan,
				tahun,  
				ROUND(MAX(Januari), 2) AS Januari,
				ROUND(MAX(Februari), 2) AS Februari,
				ROUND(MAX(Maret), 2) AS Maret,
				ROUND(MAX(April), 2) AS April,
				ROUND(MAX(Mei), 2) AS Mei,
				ROUND(MAX(Juni), 2) AS Juni,
				ROUND(MAX(Juli), 2) AS Juli,
				ROUND(MAX(Agustus), 2) AS Agustus,
				ROUND(MAX(September), 2) AS September,
				ROUND(MAX(Oktober), 2) AS Oktober,
				ROUND(MAX(November), 2) AS November,
				ROUND(MAX(Desember), 2) AS Desember,
				ROUND(
					COALESCE(
						(SUM(COALESCE(Januari, 0) + COALESCE(Februari, 0) + COALESCE(Maret, 0) + COALESCE(April, 0) + COALESCE(Mei, 0) + COALESCE(Juni, 0) +
						COALESCE(Juli, 0) + COALESCE(Agustus, 0) + COALESCE(September, 0) + COALESCE(Oktober, 0) + COALESCE(November, 0) + COALESCE(Desember, 0))
						/ NULLIF(COUNT(
							CASE WHEN COALESCE(Januari, 0) != 0 THEN 1
								WHEN COALESCE(Februari, 0) != 0 THEN 1
								WHEN COALESCE(Maret, 0) != 0 THEN 1
								WHEN COALESCE(April, 0) != 0 THEN 1
								WHEN COALESCE(Mei, 0) != 0 THEN 1
								WHEN COALESCE(Juni, 0) != 0 THEN 1
								WHEN COALESCE(Juli, 0) != 0 THEN 1
								WHEN COALESCE(Agustus, 0) != 0 THEN 1
								WHEN COALESCE(September, 0) != 0 THEN 1
								WHEN COALESCE(Oktober, 0) != 0 THEN 1
								WHEN COALESCE(November, 0) != 0 THEN 1
								WHEN COALESCE(Desember, 0) != 0 THEN 1
							END
						), 0)), 0
					), 2
				) AS average
			FROM (
				SELECT 
					a.nodok, 
					a.nik,
					s.nmsubdept,
					f.nmjabatan, 
					b.nmlengkap,
					SUBSTRING(a.periode FROM 1 FOR 4) AS tahun,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '01' THEN a.kpi_point END AS Januari,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '02' THEN a.kpi_point END AS Februari,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '03' THEN a.kpi_point END AS Maret,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '04' THEN a.kpi_point END AS April,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '05' THEN a.kpi_point END AS Mei,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '06' THEN a.kpi_point END AS Juni,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '07' THEN a.kpi_point END AS Juli,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '08' THEN a.kpi_point END AS Agustus,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '09' THEN a.kpi_point END AS September,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '10' THEN a.kpi_point END AS Oktober,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '11' THEN a.kpi_point END AS November,
					CASE WHEN SUBSTRING(a.periode FROM 5 FOR 2) = '12' THEN a.kpi_point END AS Desember
				FROM sc_pk.kpi_trx_mst a 
				LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik 
				LEFT OUTER JOIN sc_mst.jabatan f ON b.jabatan = f.kdjabatan AND f.kdsubdept = b.subbag_dept AND f.kddept = b.bag_dept
				LEFT OUTER JOIN sc_mst.subdepartmen s ON b.subbag_dept = s.kdsubdept
			) AS x
			GROUP BY 
				nik, nmlengkap, nmsubdept, nmjabatan, tahun
			ORDER BY 
				nmlengkap asc) z
			where true $arg;");
	}
}