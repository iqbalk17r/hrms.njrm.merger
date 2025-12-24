<?php
class M_pdca extends CI_Model{
	var $columnspk = array('nodok','nodokref','nopol','nmbarang','nmbengkel');
	var $orderspk = array('nodokref' => 'desc','nodok' => 'desc');
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function q_setup_day_backwards(){
		return $this->db->query("select * from sc_mst.option where kdoption='PDCACL01'");
	}
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}

	function q_trxerror($paramtrxerror){
		return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
	}
	
	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
	}
	
	function q_his_pdca_mst_param($param){
		return $this->db->query("select * from sc_his.v_pdca_mst where docno is not null $param order by docno,docdate asc");
	}
	
	function q_tmp_pdca_mst_param($param){
		return $this->db->query("select * from sc_tmp.v_pdca_mst where docno is not null $param");
	}
	
	
	function q_his_pdca_dtl_param($param){
		//$ordernya=" order by docno,docdate asc,nomor asc";
		$ordernya=" order by docno,docdate,qtytime,nomor";
		return $this->db->query("select coalesce(nik       ::text,'') as nik       ,
				coalesce(docno     ::text,'') as docno     ,
				coalesce(nomor     ::text,'') as nomor     ,
				coalesce(doctype   ::text,'') as doctype   ,
				coalesce(docref    ::text,'') as docref    ,
				coalesce(docdate   ::text,'') as docdate   ,
				coalesce(to_char(docdate,'dd-mm-yyyy')::text,'') as docdate2   ,
				coalesce(docpage   ::text,'') as docpage   ,
				coalesce(revision  ::text,'') as revision  ,
				coalesce(planperiod::text,'') as planperiod,
				coalesce(descplan  ::text,'') as descplan  ,
				coalesce(idbu      ::text,'') as idbu      ,
				coalesce(qtytime   ::text,'') as qtytime   ,
				coalesce(do_c      ::text,'') as do_c      ,
				coalesce(percentage::text,'') as percentage,
				coalesce(remark    ::text,'') as remark    ,
				coalesce(inputdate ::text,'') as inputdate ,
				coalesce(inputby   ::text,'') as inputby   ,
				coalesce(updatedate::text,'') as updatedate,
				coalesce(updateby  ::text,'') as updateby  ,
				coalesce(canceldate::text,'') as canceldate,
				coalesce(cancelby  ::text,'') as cancelby  ,
				coalesce(approvdate::text,'') as approvdate,
				coalesce(approvby  ::text,'') as approvby  ,
				coalesce(status    ::text,'') as status    ,
				coalesce(nmstatus  ::text,'') as nmstatus  from (select a.*,b.uraian as nmstatus from sc_his.pdca_dtl a 
			left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='PDCA') as x where nik is not null $param $ordernya");
	}
	
	function q_tmp_pdca_dtl_param($param){
		$ordernya=" order by docno,docdate,qtytime,nomor";
		return $this->db->query("select * from (select a.*,b.uraian as nmstatus from sc_tmp.pdca_dtl a 
			left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='PDCA') as x where nik is not null $param $ordernya");
	}
	
	function q_his_pdca_log_dtl_activity($param){
		return $this->db->query("select * from sc_his.pdca_log_dtl_activity where nik is not null $param");
	}
	function q_his_pdca_master_plan_daily($param){
		return $this->db->query("select * from (
				select a.*,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
				f1.uraian as nmstatus,f2.uraian as nmdoctype from sc_his.pdca_master_plan_daily a
					left outer join sc_mst.karyawan b on a.nik=b.nik
					left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
					left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
					left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
					left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
					left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
					left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
					left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
					left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
					left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'

					) as x
				 where nik is not null $param order by nik,nomor asc");
	}
	
	function insert_master_pdca($nik,$doctype){
		$nama=$this->session->userdata('nik');
		return $this->db->query("
		insert into sc_tmp.pdca_mst
				(branch,nik,docno,docdate,docref,doctype,docpage,revision,tglawal,tglakhir,global_desc,planperiod,ttlpercent,ttlplan,avgvalue,
				inputdate,inputby,updatedate,updateby,canceldate,cancelby,approvdate,approvby,status)
				(select branch,nik,'$nama',null::date,'','$doctype','','',null,null,'','',null,null,null,
				to_char(now(),'YYYY-MM-DD hh24:mi:ss')::timestamp,'$nama',null,null,null,null,null,null,'I' from sc_mst.karyawan 
				where nik is not null and nik='$nama' and nik not in (select nik from sc_tmp.pdca_mst));
				
				
				");
	}
	
	function insert_master_pdca_nonspv($nik,$doctype){
		$nama=$this->session->userdata('nik');
		return $this->db->query("
		insert into sc_tmp.pdca_mst
				(branch,nik,docno,docdate,docref,doctype,docpage,revision,tglawal,tglakhir,global_desc,planperiod,ttlpercent,ttlplan,avgvalue,
				inputdate,inputby,updatedate,updateby,canceldate,cancelby,approvdate,approvby,status)
				(select branch,nik,'$nama',to_char(now(),'YYYY-MM-DD')::date,'','$doctype','','',null,null,'','',null,null,null,
				to_char(now(),'YYYY-MM-DD hh24:mi:ss')::timestamp,'$nama',null,null,null,null,null,null,'I' from sc_mst.karyawan 
				where nik is not null and nik='$nama' and nik not in (select nik from sc_tmp.pdca_mst where docdate=to_char(now(),'YYYY-MM-DD')::date));
				
				
				");
	}
	
	function q_view_periode_nik_pdca($param){
		return $this->db->query("select 
									coalesce(branch        ::text,'') as branch        ,
									coalesce(nik           ::text,'') as nik           ,
									coalesce(docno         ::text,'') as docno         ,
									coalesce(doctype       ::text,'') as doctype       ,
									coalesce(planperiod    ::text,'') as planperiod    ,
									coalesce(nmlengkap     ::text,'') as nmlengkap     ,
									coalesce(bag_dept      ::text,'') as bag_dept      ,
									coalesce(nmdept        ::text,'') as nmdept        ,
									coalesce(subbag_dept   ::text,'') as subbag_dept   ,
									coalesce(nmsubdept     ::text,'') as nmsubdept     ,
									coalesce(jabatan       ::text,'') as jabatan       ,
									coalesce(nmjabatan     ::text,'') as nmjabatan     ,
									coalesce(lvl_jabatan   ::text,'') as lvl_jabatan   ,
									coalesce(nmlvljabatan  ::text,'') as nmlvljabatan  ,
									coalesce(grade_golongan::text,'') as grade_golongan,
									coalesce(nmgrade       ::text,'') as nmgrade       ,
									coalesce(nik_atasan    ::text,'') as nik_atasan    ,
									coalesce(nik_atasan2   ::text,'') as nik_atasan2   ,
									coalesce(nmatasan1     ::text,'') as nmatasan1     ,
									coalesce(nmatasan2     ::text,'') as nmatasan2     ,
									coalesce(nmdoctype     ::text,'') as nmdoctype     ,
									coalesce(ttlpercent    ::text,'') as ttlpercent    ,
									coalesce(ttlplan       ::text,'') as ttlplan       ,
									coalesce(avgvalue      ::text,'') as avgvalue  	   ,
									coalesce(status      ::text,'') as status  from 
				(
				select a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
				f2.uraian as nmdoctype,
				sum(a.ttlpercent) as ttlpercent,
				sum(a.ttlplan)as ttlplan,
				round(sum(a.ttlpercent)/sum(a.ttlplan),2) as avgvalue,'' as status
				from sc_his.pdca_mst a 
				left outer join sc_mst.karyawan b on a.nik=b.nik
				left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
				left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
				left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
				left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
				left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
				left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
				left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
				left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
				left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'
				where a.doctype='ISD' /*and coalesce(a.status,'')='P'*/		
				group by f2.uraian,a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap
				union all
				select f.branch,a.nik,'PDCA'||a.planperiod::text as docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
				f2.uraian as nmdoctype,
				0 as ttlpercent,
				0 as ttlplan,
				0 as avgvalue,a.status
				from sc_his.pdca_list_gen a 
				left outer join sc_mst.karyawan b on a.nik=b.nik
				left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
				left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
				left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
				left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
				left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
				left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
				left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
				left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
				left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'
				join sc_his.pdca_master_plan_daily f on a.nik=f.nik and a.nomor::numeric=f.nomor and f.holdplan='NO' and a.nomor::numeric<>999
				where  a.urutcategory='3' and coalesce(a.status,'')<>''
				group by f2.uraian,f.branch,a.nik,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap,a.status

				) as x
				where docno is not null $param order by nik,planperiod desc");
	}
	
	function q_view_periode_nik_pdca_status($param){
		return $this->db->query("select 
									coalesce(branch        ::text,'') as branch        ,
									coalesce(nik           ::text,'') as nik           ,
									coalesce(docno         ::text,'') as docno         ,
									coalesce(doctype       ::text,'') as doctype       ,
									coalesce(planperiod    ::text,'') as planperiod    ,
									coalesce(nmlengkap     ::text,'') as nmlengkap     ,
									coalesce(bag_dept      ::text,'') as bag_dept      ,
									coalesce(nmdept        ::text,'') as nmdept        ,
									coalesce(subbag_dept   ::text,'') as subbag_dept   ,
									coalesce(nmsubdept     ::text,'') as nmsubdept     ,
									coalesce(jabatan       ::text,'') as jabatan       ,
									coalesce(nmjabatan     ::text,'') as nmjabatan     ,
									coalesce(lvl_jabatan   ::text,'') as lvl_jabatan   ,
									coalesce(nmlvljabatan  ::text,'') as nmlvljabatan  ,
									coalesce(grade_golongan::text,'') as grade_golongan,
									coalesce(nmgrade       ::text,'') as nmgrade       ,
									coalesce(nik_atasan    ::text,'') as nik_atasan    ,
									coalesce(nik_atasan2   ::text,'') as nik_atasan2   ,
									coalesce(nmatasan1     ::text,'') as nmatasan1     ,
									coalesce(nmatasan2     ::text,'') as nmatasan2     ,
									coalesce(nmdoctype     ::text,'') as nmdoctype     ,
									coalesce(ttlpercent    ::text,'') as ttlpercent    ,
									coalesce(ttlplan       ::text,'') as ttlplan       ,
									coalesce(avgvalue      ::text,'') as avgvalue  	   ,
									coalesce(left(planperiod::text,4) ::text,'') as tahun,  
									case 
									when coalesce(right(planperiod::text,2)::text,'')='01' then 'JANUARI'
									when coalesce(right(planperiod::text,2)::text,'')='02' then 'FEBRUARI'
									when coalesce(right(planperiod::text,2)::text,'')='03' then 'MARET'
									when coalesce(right(planperiod::text,2)::text,'')='04' then 'APRIL'
									when coalesce(right(planperiod::text,2)::text,'')='05' then 'MEI'
									when coalesce(right(planperiod::text,2)::text,'')='06' then 'JUNI'
									when coalesce(right(planperiod::text,2)::text,'')='07' then 'JULI'
									when coalesce(right(planperiod::text,2)::text,'')='08' then 'AGUSTUS'
									when coalesce(right(planperiod::text,2)::text,'')='09' then 'SEPTEMBER'
									when coalesce(right(planperiod::text,2)::text,'')='10' then 'OKTOBER'
									when coalesce(right(planperiod::text,2)::text,'')='11' then 'NOVEMBER'
									when coalesce(right(planperiod::text,2)::text,'')='12' then 'DESEMBER'
									end as bulan,  
									coalesce(status      ::text,'') as status  from 
								(
								select a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
								f2.uraian as nmdoctype,
								sum(a.ttlpercent) as ttlpercent,
								sum(a.ttlplan)as ttlplan,
								round(sum(a.ttlpercent)/sum(a.ttlplan),2) as avgvalue,a.status
								from sc_his.pdca_mst a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
								left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
								left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
								left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
								left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
								left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
								left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
								left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
								left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'
								where a.doctype='ISD' and coalesce(a.status,'')='P'
								group by f2.uraian,a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap,a.status
								union all
								select f.branch,a.nik,'PDCA'||a.planperiod::text as docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
								f2.uraian as nmdoctype,
								0 as ttlpercent,
								0 as ttlplan,
								0 as avgvalue,a.status
								from sc_his.pdca_list_gen a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
								left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
								left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
								left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
								left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
								left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
								left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
								left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
								left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'
								join sc_his.pdca_master_plan_daily f on a.nik=f.nik and a.nomor::numeric=f.nomor and f.holdplan='NO' and a.nomor::numeric<>999
								where  a.urutcategory='3' and coalesce(a.status,'')<>''
								group by f2.uraian,f.branch,a.nik,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap,a.status

								) as x
								where docno is not null $param order by nik,planperiod desc");
	}	
	
	function q_view_rekap_isd_cetak($param){
		$nama=trim($this->session->userdata('nik'));
		return $this->db->query("select 
								trim(coalesce(branch        ::text,'')) as branch        ,
								trim(coalesce(nik           ::text,'')) as nik           ,
								trim(coalesce(docno         ::text,'')) as docno         ,
								trim(coalesce(doctype       ::text,'')) as doctype       ,
								trim(coalesce(planperiod    ::text,'')) as planperiod    ,
								trim(coalesce(nmlengkap     ::text,'')) as nmlengkap     ,
								trim(coalesce(bag_dept      ::text,'')) as bag_dept      ,
								trim(coalesce(nmdept        ::text,'')) as nmdept        ,
								trim(coalesce(subbag_dept   ::text,'')) as subbag_dept   ,
								trim(coalesce(nmsubdept     ::text,'')) as nmsubdept     ,
								trim(coalesce(jabatan       ::text,'')) as jabatan       ,
								trim(coalesce(nmjabatan     ::text,'')) as nmjabatan     ,
								trim(coalesce(lvl_jabatan   ::text,'')) as lvl_jabatan   ,
								trim(coalesce(nmlvljabatan  ::text,'')) as nmlvljabatan  ,
								trim(coalesce(grade_golongan::text,'')) as grade_golongan,
								trim(coalesce(nmgrade       ::text,'')) as nmgrade       ,
								trim(coalesce(nik_atasan    ::text,'')) as nik_atasan    ,
								trim(coalesce(nik_atasan2   ::text,'')) as nik_atasan2   ,
								trim(coalesce(nmatasan1     ::text,'')) as nmatasan1     ,
								trim(coalesce(nmatasan2     ::text,'')) as nmatasan2     ,
								trim(coalesce(nmdoctype     ::text,'')) as nmdoctype     ,
								trim(coalesce(ttlpercent    ::text,'')) as ttlpercent    ,
								trim(coalesce(ttlplan       ::text,'')) as ttlplan       ,
								trim(coalesce(avgvalue      ::text,'')) as avgvalue  	   ,
								trim(coalesce(status        ::text,'')) as status,
								trim(coalesce(to_char(maxdocdate::date,'dd-mm-yyyy')        ::text,'')) as maxdocdate,
								trim(coalesce(to_char(mindocdate::date,'dd-mm-yyyy')        ::text,'')) as mindocdate,
								trim(coalesce(page      ::text,'')) as page , 
								'_'||trim(coalesce(page      ::text,'')) as stipage , 
								'_'||trim(coalesce(planperiod      ::text,'')) as stiplanperiod 
								
								from 
								(select
								a1.page,a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
								f2.uraian as nmdoctype,
								a1.ttlpercent as ttlpercent,
								--sum(a1.ttlplan)as ttlplan,
								a1.ttlplan as ttlplan,
								round((a1.ttlpercent::numeric)/a1.ttlplan,0) as avgvalue,a.status,a1.maxdocdate,a1.mindocdate
								from (	SELECT page,nik,planperiod,doctype, COUNT(*)::numeric as ttlplan ,sum(percentage::numeric) as ttlpercent,max(docdate) as maxdocdate,min(docdate) as mindocdate
									FROM sc_his.pdca_cetakpage where userprint='$nama'
									GROUP BY  page,nik,planperiod,doctype) a1
								left outer join sc_his.pdca_mst a on a1.nik=a.nik and a1.planperiod=a.planperiod 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
								left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
								left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
								left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
								left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
								left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
								left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade 
								left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
								left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'
								where a.status='P'
								group by f2.uraian,a1.page,a1.ttlpercent,a1.maxdocdate,a1.mindocdate,a1.ttlplan,a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap,a.status) as x
								where docno is not null  $param order by page asc,nik,planperiod desc");
	}
	
	function q_view_mst_isd_cetak($param){
		return $this->db->query("select * from sc_his.v_pdca_mst where docno is not null $param order by docno,docdate asc");
	}
	
	function q_view_dtl_isd_cetak($param){
		$nama=trim($this->session->userdata('nik'));
		//$ordernya=" order by docno,docdate asc,nomor asc";
		$ordernya=" order by page asc,docno,docdate,qtytime,nomor";
		return $this->db->query("select trim(coalesce(nik       ::text,'')) as nik       ,
										trim(coalesce(docno     ::text,'')) as docno     ,
										trim(coalesce(nomor     ::text,'')) as nomor     ,
										trim(coalesce(doctype   ::text,'')) as doctype   ,
										trim(coalesce(docref    ::text,'')) as docref    ,
										trim(coalesce(docdate   ::text,'')) as docdate   ,
										trim(coalesce(to_char(docdate::date,'dd-mm-yyyy')::text,'')) as docdate2   ,
										trim(coalesce(docpage   ::text,'')) as docpage   ,
										trim(coalesce(revision  ::text,'')) as revision  ,
										trim(coalesce(planperiod::text,'')) as planperiod,
										trim(coalesce(descplan  ::text,'')) as descplan  ,
										trim(coalesce(idbu      ::text,'')) as idbu      ,
										trim(coalesce(qtytime   ::text,'')) as qtytime   ,
										trim(coalesce(do_c      ::text,'')) as do_c      ,
										trim(coalesce(percentage::text,'')) as percentage,
										trim(coalesce(remark    ::text,'')) as remark    ,
										trim(coalesce(inputdate ::text,'')) as inputdate ,
										trim(coalesce(inputby   ::text,'')) as inputby   ,
										trim(coalesce(updatedate::text,'')) as updatedate,
										trim(coalesce(updateby  ::text,'')) as updateby  ,
										trim(coalesce(canceldate::text,'')) as canceldate,
										trim(coalesce(cancelby  ::text,'')) as cancelby  ,
										trim(coalesce(approvdate::text,'')) as approvdate,
										trim(coalesce(approvby  ::text,'')) as approvby  ,
										trim(coalesce(status    ::text,'')) as status    ,
										trim(coalesce(page ::text,'')) as page ,
										'_'||trim(coalesce(page      ::text,'')) as stipage , 
										'_'||trim(coalesce(planperiod      ::text,'')) as stiplanperiod ,
										trim(coalesce(nmstatus  ::text,'')) as nmstatus  from (select a1.*,b.uraian as nmstatus ,a.page,a.userprint
									from sc_his.pdca_cetakpage a 
								left outer join sc_his.pdca_dtl a1 on a.nik=a1.nik and a.docno=a1.docno and a.nomor=a1.nomor and a.doctype=a1.doctype and a.docdate::date=a1.docdate
								left outer join sc_mst.trxtype b on a1.status=b.kdtrx and b.jenistrx='PDCA') as x where nik is not null and userprint='$nama'  $param $ordernya");
	}
	
	
	function q_view_rekap_isd_cetak_spv($param){
		return $this->db->query("select 
										trim(coalesce(branch        ::text,'')) as branch        ,
										trim(coalesce(nik           ::text,'')) as nik           ,
										trim(coalesce(docno         ::text,'')) as docno         ,
										trim(coalesce(doctype       ::text,'')) as doctype       ,
										trim(coalesce(planperiod    ::text,'')) as planperiod    ,
										trim(coalesce(nmlengkap     ::text,'')) as nmlengkap     ,
										trim(coalesce(bag_dept      ::text,'')) as bag_dept      ,
										trim(coalesce(nmdept        ::text,'')) as nmdept        ,
										trim(coalesce(subbag_dept   ::text,'')) as subbag_dept   ,
										trim(coalesce(nmsubdept     ::text,'')) as nmsubdept     ,
										trim(coalesce(jabatan       ::text,'')) as jabatan       ,
										trim(coalesce(nmjabatan     ::text,'')) as nmjabatan     ,
										trim(coalesce(lvl_jabatan   ::text,'')) as lvl_jabatan   ,
										trim(coalesce(nmlvljabatan  ::text,'')) as nmlvljabatan  ,
										trim(coalesce(grade_golongan::text,'')) as grade_golongan,
										trim(coalesce(nmgrade       ::text,'')) as nmgrade       ,
										trim(coalesce(nik_atasan    ::text,'')) as nik_atasan    ,
										trim(coalesce(nik_atasan2   ::text,'')) as nik_atasan2   ,
										trim(coalesce(nmatasan1     ::text,'')) as nmatasan1     ,
										trim(coalesce(nmatasan2     ::text,'')) as nmatasan2     ,
										trim(coalesce(nmdoctype     ::text,'')) as nmdoctype     ,
										trim(coalesce(ttlpercent    ::text,'')) as ttlpercent    ,
										trim(coalesce(ttlplan       ::text,'')) as ttlplan       ,
										trim(coalesce(round(avgvalue,0)      ::text,'')) as avgvalue  	   ,
										trim(coalesce(status        ::text,'')) as status,
										'_'||trim(coalesce(planperiod      ::text,'')) as stiplanperiod ,
										'_'||trim(coalesce(to_char(docdate::date,'dd-mm-yyyy')        ::text,'')) as stidocdate,
										trim(coalesce(to_char(tglakhir::date,'dd-mm-yyyy')        ::text,'')) as tglakhir,
										trim(coalesce(to_char(tglawal::date,'dd-mm-yyyy')        ::text,'')) as tglawal
										 from (select
										a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
										f2.uraian as nmdoctype,
										sum(a.ttlpercent) as ttlpercent,
										--sum(a1.ttlplan)as ttlplan,
										sum(a.ttlplan) as ttlplan,
										sum(a.avgvalue) as avgvalue,a.status,a.tglawal,a.tglakhir,a.docdate
										from sc_his.pdca_mst a
										left outer join sc_mst.karyawan b on a.nik=b.nik
										left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
										left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
										left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
										left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
										left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
										left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
										left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
										left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
										left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA' 
										where a.status='P'
										group by f2.uraian,a.branch,a.docdate,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap,a.status,a.tglawal,a.tglakhir) as x
										where docno is not null  $param order by nik,planperiod desc");
	}
	
	function q_view_dtl_isd_cetak_spv($param){
		//$ordernya=" order by docno,docdate asc,nomor asc";
		$ordernya=" order by docno,docdate,qtytime,nomor";
		return $this->db->query("select trim(coalesce(nik       ::text,'')) as nik       ,
										trim(coalesce(docno     ::text,'')) as docno     ,
										trim(coalesce(nomor     ::text,'')) as nomor     ,
										trim(coalesce(doctype   ::text,'')) as doctype   ,
										trim(coalesce(docref    ::text,'')) as docref    ,
										trim(coalesce(docdate   ::text,'')) as docdate   ,
										trim(coalesce(to_char(docdate::date,'dd-mm-yyyy')::text,'')) as docdate2   ,
										trim(coalesce(docpage   ::text,'')) as docpage   ,
										trim(coalesce(revision  ::text,'')) as revision  ,
										trim(coalesce(planperiod::text,'')) as planperiod,
										trim(coalesce(descplan  ::text,'')) as descplan  ,
										trim(coalesce(idbu      ::text,'')) as idbu      ,
										trim(coalesce(qtytime   ::text,'')) as qtytime   ,
										trim(coalesce(do_c      ::text,'')) as do_c      ,
										trim(coalesce(percentage::text,'')) as percentage,
										trim(coalesce(remark    ::text,'')) as remark    ,
										trim(coalesce(inputdate ::text,'')) as inputdate ,
										trim(coalesce(inputby   ::text,'')) as inputby   ,
										trim(coalesce(updatedate::text,'')) as updatedate,
										trim(coalesce(updateby  ::text,'')) as updateby  ,
										trim(coalesce(canceldate::text,'')) as canceldate,
										trim(coalesce(cancelby  ::text,'')) as cancelby  ,
										trim(coalesce(approvdate::text,'')) as approvdate,
										trim(coalesce(approvby  ::text,'')) as approvby  ,
										trim(coalesce(status    ::text,'')) as status    ,
										'_'||trim(coalesce(planperiod      ::text,'')) as stiplanperiod ,
										'_'||trim(coalesce(to_char(docdate::date,'dd-mm-yyyy')      ::text,'')) as stidocdate ,
										trim(coalesce(nmstatus  ::text,'')) as nmstatus  
										from (select a.*,b.uraian as nmstatus 
										from sc_his.pdca_dtl a 
								left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='PDCA') as x where nik is not null  $param $ordernya");
	}
	
	function pdca_log_dtl_activity($paramlist){
		return $this->db->query("select a.*,b.nmlengkap,b1.nmlengkap as nmubah from sc_his.pdca_log_dtl_activity a
				left outer join sc_mst.karyawan b on a.nik=b.nik 
				left outer join sc_mst.karyawan b1 on a.updateby=b1.nik $paramlist order by docdate desc");
	}
	
	function insert_dtl_pdca($data = array()){
		$insert = $this->db->insert_batch('sc_tmp.pdca_dtl',$data);
		return $insert?true:false;
	}
	
	function q_his_pdca_list_gen($param){
		return $this->db->query("select  DENSE_RANK() OVER(ORDER BY nomor) as urutnye,coalesce(trim(nik           ::text),'') as nik           ,
										coalesce(trim(nomor         ::text),'') as nomor         ,
										coalesce(trim(planperiod    ::text),'') as planperiod    ,
										coalesce(trim(doctype       ::text),'') as doctype       ,
										coalesce(trim(category      ::text),'') as category      ,
										coalesce(trim(urutcategory      ::text),'') as urutcategory      ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl1  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl1  ::text),'0') end as tgl1          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl2  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl2  ::text),'0') end as tgl2          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl3  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl3  ::text),'0') end as tgl3          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl4  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl4  ::text),'0') end as tgl4          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl5  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl5  ::text),'0') end as tgl5          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl6  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl6  ::text),'0') end as tgl6          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl7  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl7  ::text),'0') end as tgl7          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl8  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl8  ::text),'0') end as tgl8          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl9  ::numeric,0)        ::text),'0') else    coalesce(trim(tgl9  ::text),'0') end as tgl9          ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl10 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl10 ::text),'0') end as tgl10         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl11 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl11 ::text),'0') end as tgl11         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl12 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl12 ::text),'0') end as tgl12         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl13 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl13 ::text),'0') end as tgl13         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl14 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl14 ::text),'0') end as tgl14         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl15 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl15 ::text),'0') end as tgl15         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl16 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl16 ::text),'0') end as tgl16         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl17 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl17 ::text),'0') end as tgl17         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl18 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl18 ::text),'0') end as tgl18         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl19 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl19 ::text),'0') end as tgl19         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl20 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl20 ::text),'0') end as tgl20         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl21 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl21 ::text),'0') end as tgl21         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl22 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl22 ::text),'0') end as tgl22         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl23 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl23 ::text),'0') end as tgl23         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl24 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl24 ::text),'0') end as tgl24         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl25 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl25 ::text),'0') end as tgl25         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl26 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl26 ::text),'0') end as tgl26         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl27 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl27 ::text),'0') end as tgl27         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl28 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl28 ::text),'0') end as tgl28         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl29 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl29 ::text),'0') end as tgl29         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl30 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl30 ::text),'0') end as tgl30         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl31 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl31 ::text),'0') end as tgl31         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl32 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl32 ::text),'0') end as tgl32         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl33 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl33 ::text),'0') end as tgl33         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl34 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl34 ::text),'0') end as tgl34         ,
										case when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl35 ::numeric,0)        ::text),'0') else    coalesce(trim(tgl35 ::text),'0') end as tgl35         ,
										coalesce(trim(remark        ::text),'0') as remark        ,
										coalesce(trim(status        ::text),'') as status        ,
										coalesce(trim(nmlengkap     ::text),'') as nmlengkap     ,
										coalesce(trim(bag_dept      ::text),'') as bag_dept      ,
										coalesce(trim(nmdept        ::text),'') as nmdept        ,
										coalesce(trim(subbag_dept   ::text),'') as subbag_dept   ,
										coalesce(trim(nmsubdept     ::text),'') as nmsubdept     ,
										coalesce(trim(jabatan       ::text),'') as jabatan       ,
										coalesce(trim(nmjabatan     ::text),'') as nmjabatan     ,
										coalesce(trim(lvl_jabatan   ::text),'') as lvl_jabatan   ,
										coalesce(trim(nmlvljabatan  ::text),'') as nmlvljabatan  ,
										coalesce(trim(grade_golongan::text),'') as grade_golongan,
										coalesce(trim(nmgrade       ::text),'') as nmgrade       ,
										coalesce(trim(nik_atasan    ::text),'') as nik_atasan    ,
										coalesce(trim(nik_atasan2   ::text),'') as nik_atasan2   ,
										coalesce(trim(nmatasan1     ::text),'') as nmatasan1     ,
										coalesce(trim(nmatasan2     ::text),'') as nmatasan2     ,
										coalesce(trim(descplan      ::text),'') as descplan  from (
				select a.*,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,f.descplan from sc_his.pdca_list_gen a
					left outer join sc_mst.karyawan b on a.nik=b.nik
					left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
					left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
					left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
					left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
					left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
					left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
					left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
					left outer join sc_his.pdca_master_plan_daily f on a.nomor::numeric=f.nomor and a.nik=f.nik and f.doctype='BRK' and f.holdplan='NO'
					) as x	
				where nik is not null and trim(nomor||urutcategory)!='9994'  $param 
				order by nik,planperiod,doctype,nomor::numeric asc,urutcategory::numeric asc");
	}
	
	function q_his_pdca_list_gen_report($param){
		return $this->db->query("select  DENSE_RANK() OVER(ORDER BY nomor) as urutnye,coalesce(trim(nik           ::text),'') as nik           ,
									coalesce(trim(nomor         ::text),'') as nomor         ,
									coalesce(trim(planperiod    ::text),'') as planperiod    ,
									coalesce(trim(doctype       ::text),'') as doctype       ,
									coalesce(trim(category      ::text),'') as category      ,
									coalesce(trim(urutcategory      ::text),'') as urutcategory      ,
									case when nomor='999' and urutcategory='10' and tgl1 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl1  ::numeric,0)        ::text),'0')else coalesce(trim(tgl1          ::text),'_') end as tgl1          ,
									case when nomor='999' and urutcategory='10' and tgl2 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl2  ::numeric,0)        ::text),'0')else coalesce(trim(tgl2          ::text),'_') end as tgl2          ,
									case when nomor='999' and urutcategory='10' and tgl3 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl3  ::numeric,0)        ::text),'0')else coalesce(trim(tgl3          ::text),'_') end as tgl3          ,
									case when nomor='999' and urutcategory='10' and tgl4 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl4  ::numeric,0)        ::text),'0')else coalesce(trim(tgl4          ::text),'_') end as tgl4          ,
									case when nomor='999' and urutcategory='10' and tgl5 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl5  ::numeric,0)        ::text),'0')else coalesce(trim(tgl5          ::text),'_') end as tgl5          ,
									case when nomor='999' and urutcategory='10' and tgl6 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl6  ::numeric,0)        ::text),'0')else coalesce(trim(tgl6          ::text),'_') end as tgl6          ,
									case when nomor='999' and urutcategory='10' and tgl7 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl7  ::numeric,0)        ::text),'0')else coalesce(trim(tgl7          ::text),'_') end as tgl7          ,
									case when nomor='999' and urutcategory='10' and tgl8 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl8  ::numeric,0)        ::text),'0')else coalesce(trim(tgl8          ::text),'_') end as tgl8          ,
									case when nomor='999' and urutcategory='10' and tgl9 !='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl9  ::numeric,0)        ::text),'0')else coalesce(trim(tgl9          ::text),'_') end as tgl9          ,
									case when nomor='999' and urutcategory='10' and tgl10!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl10 ::numeric,0)        ::text),'0')else coalesce(trim(tgl10         ::text),'_') end as tgl10         ,
									case when nomor='999' and urutcategory='10' and tgl11!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl11 ::numeric,0)        ::text),'0')else coalesce(trim(tgl11         ::text),'_') end as tgl11         ,
									case when nomor='999' and urutcategory='10' and tgl12!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl12 ::numeric,0)        ::text),'0')else coalesce(trim(tgl12         ::text),'_') end as tgl12         ,
									case when nomor='999' and urutcategory='10' and tgl13!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl13 ::numeric,0)        ::text),'0')else coalesce(trim(tgl13         ::text),'_') end as tgl13         ,
									case when nomor='999' and urutcategory='10' and tgl14!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl14 ::numeric,0)        ::text),'0')else coalesce(trim(tgl14         ::text),'_') end as tgl14         ,
									case when nomor='999' and urutcategory='10' and tgl15!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl15 ::numeric,0)        ::text),'0')else coalesce(trim(tgl15         ::text),'_') end as tgl15         ,
									case when nomor='999' and urutcategory='10' and tgl16!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl16 ::numeric,0)        ::text),'0')else coalesce(trim(tgl16         ::text),'_') end as tgl16         ,
									case when nomor='999' and urutcategory='10' and tgl17!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl17 ::numeric,0)        ::text),'0')else coalesce(trim(tgl17         ::text),'_') end as tgl17         ,
									case when nomor='999' and urutcategory='10' and tgl18!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl18 ::numeric,0)        ::text),'0')else coalesce(trim(tgl18         ::text),'_') end as tgl18         ,
									case when nomor='999' and urutcategory='10' and tgl19!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl19 ::numeric,0)        ::text),'0')else coalesce(trim(tgl19         ::text),'_') end as tgl19         ,
									case when nomor='999' and urutcategory='10' and tgl20!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl20 ::numeric,0)        ::text),'0')else coalesce(trim(tgl20         ::text),'_') end as tgl20         ,
									case when nomor='999' and urutcategory='10' and tgl21!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl21 ::numeric,0)        ::text),'0')else coalesce(trim(tgl21         ::text),'_') end as tgl21         ,
									case when nomor='999' and urutcategory='10' and tgl22!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl22 ::numeric,0)        ::text),'0')else coalesce(trim(tgl22         ::text),'_') end as tgl22         ,
									case when nomor='999' and urutcategory='10' and tgl23!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl23 ::numeric,0)        ::text),'0')else coalesce(trim(tgl23         ::text),'_') end as tgl23         ,
									case when nomor='999' and urutcategory='10' and tgl24!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl24 ::numeric,0)        ::text),'0')else coalesce(trim(tgl24         ::text),'_') end as tgl24         ,
									case when nomor='999' and urutcategory='10' and tgl25!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl25 ::numeric,0)        ::text),'0')else coalesce(trim(tgl25         ::text),'_') end as tgl25         ,
									case when nomor='999' and urutcategory='10' and tgl26!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl26 ::numeric,0)        ::text),'0')else coalesce(trim(tgl26         ::text),'_') end as tgl26         ,
									case when nomor='999' and urutcategory='10' and tgl27!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl27 ::numeric,0)        ::text),'0')else coalesce(trim(tgl27         ::text),'_') end as tgl27         ,
									case when nomor='999' and urutcategory='10' and tgl28!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl28 ::numeric,0)        ::text),'0')else coalesce(trim(tgl28         ::text),'_') end as tgl28         ,
									case when nomor='999' and urutcategory='10' and tgl29!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl29 ::numeric,0)        ::text),'0')else coalesce(trim(tgl29         ::text),'_') end as tgl29         ,
									case when nomor='999' and urutcategory='10' and tgl30!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl30 ::numeric,0)        ::text),'0')else coalesce(trim(tgl30         ::text),'_') end as tgl30         ,
									case when nomor='999' and urutcategory='10' and tgl31!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl31 ::numeric,0)        ::text),'0')else coalesce(trim(tgl31         ::text),'_') end as tgl31         ,
									case when nomor='999' and urutcategory='10' and tgl32!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl32 ::numeric,0)        ::text),'0')else coalesce(trim(tgl32         ::text),'_') end as tgl32         ,
									case when nomor='999' and urutcategory='10' and tgl33!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl33 ::numeric,0)        ::text),'0')else coalesce(trim(tgl33         ::text),'_') end as tgl33         ,
									case when nomor='999' and urutcategory='10' and tgl34!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl34 ::numeric,0)        ::text),'0')else coalesce(trim(tgl34         ::text),'_') end as tgl34         ,
									case when nomor='999' and urutcategory='10' and tgl35!='FINAL' then '_' when nomor='999' and urutcategory='3' then coalesce(trim(round(tgl35 ::numeric,0)        ::text),'0')else coalesce(trim(tgl35         ::text),'_') end as tgl35         ,
									coalesce(trim(remark        ::text),'_') as remark        ,
									coalesce(trim(status        ::text),'') as status        ,
									coalesce(trim(nmlengkap     ::text),'') as nmlengkap     ,
									coalesce(trim(bag_dept      ::text),'') as bag_dept      ,
									coalesce(trim(nmdept        ::text),'') as nmdept        ,
									coalesce(trim(subbag_dept   ::text),'') as subbag_dept   ,
									coalesce(trim(nmsubdept     ::text),'') as nmsubdept     ,
									coalesce(trim(jabatan       ::text),'') as jabatan       ,
									coalesce(trim(nmjabatan     ::text),'') as nmjabatan     ,
									coalesce(trim(lvl_jabatan   ::text),'') as lvl_jabatan   ,
									coalesce(trim(nmlvljabatan  ::text),'') as nmlvljabatan  ,
									coalesce(trim(grade_golongan::text),'') as grade_golongan,
									coalesce(trim(nmgrade       ::text),'') as nmgrade       ,
									coalesce(trim(nik_atasan    ::text),'') as nik_atasan    ,
									coalesce(trim(nik_atasan2   ::text),'') as nik_atasan2   ,
									coalesce(trim(nmatasan1     ::text),'') as nmatasan1     ,
									coalesce(trim(nmatasan2     ::text),'') as nmatasan2     ,
									coalesce(trim(descplan      ::text),'') as descplan  from (
								select a.*,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,f.descplan from sc_his.pdca_list_gen a
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
								left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
								left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
								left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
								left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
								left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
								left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade
								left outer join sc_his.pdca_master_plan_daily f on a.nomor::numeric=f.nomor and a.nik=f.nik and f.doctype='BRK' and f.holdplan='NO'
								) as x	
				where nik is not null and trim(nomor||urutcategory) not in ('9994')  $param 
				order by nik,planperiod,doctype,nomor::numeric asc,urutcategory::numeric asc");
	}
	
	
	function q_withconfirm_pdca_gen($param){
		return $this->db->query("select count(*) as withconfirm from sc_his.pdca_list_gen where nik is not null  
				  and (coalesce(tgl1 ,'0') not in ('0','INPUT')
					or coalesce(tgl2 ,'0') not in ('0','INPUT')
					or coalesce(tgl3 ,'0') not in ('0','INPUT')
					or coalesce(tgl4 ,'0') not in ('0','INPUT')
					or coalesce(tgl5 ,'0') not in ('0','INPUT')
					or coalesce(tgl6 ,'0') not in ('0','INPUT')
					or coalesce(tgl7 ,'0') not in ('0','INPUT')
					or coalesce(tgl8 ,'0') not in ('0','INPUT')
					or coalesce(tgl9 ,'0') not in ('0','INPUT')
					or coalesce(tgl10,'0') not in ('0','INPUT')
					or coalesce(tgl11,'0') not in ('0','INPUT')
					or coalesce(tgl12,'0') not in ('0','INPUT')
					or coalesce(tgl13,'0') not in ('0','INPUT')
					or coalesce(tgl14,'0') not in ('0','INPUT')
					or coalesce(tgl15,'0') not in ('0','INPUT')
					or coalesce(tgl16,'0') not in ('0','INPUT')
					or coalesce(tgl17,'0') not in ('0','INPUT')
					or coalesce(tgl18,'0') not in ('0','INPUT')
					or coalesce(tgl19,'0') not in ('0','INPUT')
					or coalesce(tgl20,'0') not in ('0','INPUT')
					or coalesce(tgl21,'0') not in ('0','INPUT')
					or coalesce(tgl22,'0') not in ('0','INPUT')
					or coalesce(tgl23,'0') not in ('0','INPUT')
					or coalesce(tgl24,'0') not in ('0','INPUT')
					or coalesce(tgl25,'0') not in ('0','INPUT')
					or coalesce(tgl26,'0') not in ('0','INPUT')
					or coalesce(tgl27,'0') not in ('0','INPUT')
					or coalesce(tgl28,'0') not in ('0','INPUT')
					or coalesce(tgl29,'0') not in ('0','INPUT')
					or coalesce(tgl30,'0') not in ('0','INPUT')
					or coalesce(tgl31,'0') not in ('0','INPUT')
					or coalesce(tgl32,'0') not in ('0','INPUT')
					or coalesce(tgl33,'0') not in ('0','INPUT')
					or coalesce(tgl34,'0') not in ('0','INPUT')
					or coalesce(tgl35,'0') not in ('0','INPUT')) 
					$param ");	
		}
		
	function q_pdca_recapitulation_of_the_month_oh_yes_oh_no_yes_no_ah_uh_ah_crooot($param){
			$ordernya=" order by urut";
			return $this->db->query("select * from (
						select x.urut,x.nik,x.docno,x.nomor,x.doctype,x.docref,x.docdate,x.docpage,x.revision,x.planperiod,x.descplan,x.idbu,x.qtytime,x.do_c,x.percentage,x.remark,x.status,b.nmlengkap from (
						select '1' as urut,nik,docno,nomor,doctype,docref,docdate,docpage,revision,planperiod,descplan,idbu,qtytime,do_c,percentage,remark,status from sc_his.pdca_dtl 
						union all
						select '2' as urut,nik,docno,'' as nomor,doctype,'' as docref,null as docdate,'' as docpage,'' as revision,planperiod,'' as descplan,'' as idbu,'' as qtytime,'TOTAL' as do_c,sum(percentage) as percentage, '' as remark,'P' AS status from sc_his.pdca_dtl 
						group by nik,docno,doctype,planperiod
						union all
						select '3' as urut,nik,docno,'' as nomor,doctype,'' as docref,null as docdate,'' as docpage,'' as revision,planperiod,'' as descplan,'' as idbu,'' as qtytime,'TOTAL PLAN' as do_c,count(percentage) as percentage,  '' as remark,'P' AS status from sc_his.pdca_dtl 
						group by nik,docno,doctype,planperiod
						union all
						select '4' as urut,nik,docno,'' as nomor,doctype,'' as docref,null as docdate,'' as docpage,'' as revision,planperiod,'' as descplan,'' as idbu,'' as qtytime,'NILAI RATA-RATA' as do_c,ROUND(sum(percentage)/count(percentage),2) as percentage,'' as remark,'P' AS status from sc_his.pdca_dtl 
						group by nik,docno,doctype,planperiod) as x
						left outer join sc_mst.karyawan b on x.nik=b.nik) as x
					where nik is not null $param $ordernya --and nik='1115.184' and planperiod='201803' AND status='P'
					");
		}
	
	function q_pdca_rekap_isd_report($param){
		return $this->db->query("select 
						trim(coalesce(branch        ::text,'')) as branch        ,
						trim(coalesce(nik           ::text,'')) as nik           ,
						trim(coalesce(docno         ::text,'')) as docno         ,
						trim(coalesce(doctype       ::text,'')) as doctype       ,
						trim(coalesce(planperiod    ::text,'')) as planperiod    ,
						trim(coalesce(nmlengkap     ::text,'')) as nmlengkap     ,
						trim(coalesce(bag_dept      ::text,'')) as bag_dept      ,
						trim(coalesce(nmdept        ::text,'')) as nmdept        ,
						trim(coalesce(subbag_dept   ::text,'')) as subbag_dept   ,
						trim(coalesce(nmsubdept     ::text,'')) as nmsubdept     ,
						trim(coalesce(jabatan       ::text,'')) as jabatan       ,
						trim(coalesce(nmjabatan     ::text,'')) as nmjabatan     ,
						trim(coalesce(lvl_jabatan   ::text,'')) as lvl_jabatan   ,
						trim(coalesce(nmlvljabatan  ::text,'')) as nmlvljabatan  ,
						trim(coalesce(grade_golongan::text,'')) as grade_golongan,
						trim(coalesce(nmgrade       ::text,'')) as nmgrade       ,
						trim(coalesce(nik_atasan    ::text,'')) as nik_atasan    ,
						trim(coalesce(nik_atasan2   ::text,'')) as nik_atasan2   ,
						trim(coalesce(nmatasan1     ::text,'')) as nmatasan1     ,
						trim(coalesce(nmatasan2     ::text,'')) as nmatasan2     ,
						trim(coalesce(nmdoctype     ::text,'')) as nmdoctype     ,
						trim(coalesce(ttlpercent    ::text,'')) as ttlpercent    ,
						trim(coalesce(ttlplan       ::text,'')) as ttlplan       ,
						trim(coalesce(avgvalue      ::text,'')) as avgvalue  	   ,
						trim(coalesce(status        ::text,'')) as status from 
						(select a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap as nmatasan1,d.nmlengkap as nmatasan2,
						f2.uraian as nmdoctype,
						sum(a.ttlpercent) as ttlpercent,
						--sum(a1.ttlplan)as ttlplan,
						sum(a.ttlplan) as ttlplan,
						round((sum(a.ttlpercent::numeric))/sum(a.ttlplan),0) as avgvalue,a.status
						from sc_his.pdca_mst a 
						left outer join sc_mst.karyawan b on a.nik=b.nik
						left outer join sc_mst.karyawan c on b.nik_atasan=c.nik
						left outer join sc_mst.karyawan d on b.nik_atasan2=d.nik
						left outer join sc_mst.departmen e1 on b.bag_dept=e1.kddept 
						left outer join sc_mst.subdepartmen e2 on b.bag_dept=e2.kddept and b.subbag_dept=e2.kdsubdept
						left outer join sc_mst.jabatan e3 on b.bag_dept=e3.kddept and b.subbag_dept=e3.kdsubdept and b.jabatan=e3.kdjabatan
						left outer join sc_mst.lvljabatan e4 on b.lvl_jabatan=e4.kdlvl 
						left outer join sc_mst.jobgrade e5 on b.grade_golongan=e5.kdgrade 
						left outer join sc_mst.trxtype f1 on a.status=f1.kdtrx and f1.jenistrx='PDCA'
						left outer join sc_mst.trxtype f2 on a.doctype=f2.kdtrx and f2.jenistrx='PDCA'  
						where a.status='P'
						group by f2.uraian,a.branch,a.nik,a.docno,a.doctype,a.planperiod,b.nmlengkap,b.bag_dept,e1.nmdept,b.subbag_dept,e2.nmsubdept,b.jabatan,e3.nmjabatan,b.lvl_jabatan,e4.nmlvljabatan,b.grade_golongan,e5.nmgrade,b.nik_atasan,b.nik_atasan2,c.nmlengkap,d.nmlengkap,a.status) as x
						where docno is not null $param order by nik,planperiod desc
		");
	}
	
	function q_pdca_dtl_isd_report($param){
		$ordernya=" order by docno,docdate asc,nomor asc";
		return $this->db->query("select trim(coalesce(nik       ::text,'')) as nik       ,
									trim(coalesce(docno     ::text,'')) as docno     ,
									trim(coalesce(nomor     ::text,'')) as nomor     ,
									trim(coalesce(doctype   ::text,'')) as doctype   ,
									trim(coalesce(docref    ::text,'')) as docref    ,
									trim(coalesce(docdate   ::text,'')) as docdate   ,
									trim(coalesce(to_char(docdate::date,'dd-mm-yyyy')::text,'')) as docdate2   ,
									trim(coalesce(docpage   ::text,'')) as docpage   ,
									trim(coalesce(revision  ::text,'')) as revision  ,
									trim(coalesce(planperiod::text,'')) as planperiod,
									trim(coalesce(descplan  ::text,'')) as descplan  ,
									trim(coalesce(idbu      ::text,'')) as idbu      ,
									trim(coalesce(qtytime   ::text,'')) as qtytime   ,
									trim(coalesce(do_c      ::text,'')) as do_c      ,
									trim(coalesce(percentage::text,'')) as percentage,
									trim(coalesce(remark    ::text,'')) as remark    ,
									trim(coalesce(inputdate ::text,'')) as inputdate ,
									trim(coalesce(inputby   ::text,'')) as inputby   ,
									trim(coalesce(updatedate::text,'')) as updatedate,
									trim(coalesce(updateby  ::text,'')) as updateby  ,
									trim(coalesce(canceldate::text,'')) as canceldate,
									trim(coalesce(cancelby  ::text,'')) as cancelby  ,
									trim(coalesce(approvdate::text,'')) as approvdate,
									trim(coalesce(approvby  ::text,'')) as approvby  ,
									trim(coalesce(status    ::text,'')) as status,    
									trim(coalesce(nmstatus  ::text,'')) as nmstatus  from (select a.*,b.uraian as nmstatus 
									from  sc_his.pdca_dtl a
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='PDCA') as x where nik is not null  $param $ordernya");
	}
	
	
}	