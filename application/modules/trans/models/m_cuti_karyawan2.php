<?php
class M_cuti_karyawan extends CI_Model{
	
	
	//var $table = 'sc_trx.cuti_karyawan';	
	//var $column = array('nodok','nik','nmlengkap','nmdept','status1');
	//var $order = array('nodok' => 'asc');

	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept where coalesce(upper(a.status),'')!='KO'  
								order by nmlengkap asc");
		
	}
	
	function list_pelimpahan($nik){
		return $this->db->query("select * from sc_mst.karyawan 
								where nik<>'$nik' and coalesce(upper(status),'')!='KO' and bag_dept in (select bag_dept from sc_mst.karyawan where nik='$nik') ");
	}
	
	function list_pelimpahan2(){
		return $this->db->query("select nik,nmlengkap,bag_dept,jabatan from sc_mst.karyawan where coalesce(upper(status),'')!='KO' limit 10");
	}
	function list_karyawan_pelimpahan($nik){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where a.nik<>'$nik' and coalesce(upper(a.status),'')!='KO'
								order by nmlengkap asc");
		
	}
	
	function list_ijin_khusus(){
		return $this->db->query("select * from sc_mst.ijin_khusus 
								order by nmijin_khusus asc");
		
	}
	
	function list_karyawan_index_2(){
	
		return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(status),'')!='KO'");
	}
	

	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.nik='$nik' and coalesce(upper(f.status),'')!='KO'
								");
	}
	
	function cek_cuti_karyawan($nik){
		return $this->db->query(" select nik,to_char(tgl_mulai,'dd-mm-yyyy')as tgl_mulai,to_char(tgl_selesai,'dd-mm-yyyy')as tgl_selesai from sc_trx.cuti_karyawan where nik='$nik'");
	}
	
	function cek_cuti_karyawan2($nik,$tgl_awal,$tgl_selesai){
		/*return $this->db->query("select nik, to_char(tgl_mulai,'dd-mm-yyyy')as tgl_mulai,tgl_selesai from sc_trx.cuti_karyawan
								where nik='$nik' and (tgl_mulai='$tgl_awal' or tgl_selesai='$tgl_selesai')"); */
		return $this->db->query("select nik, to_char(tgl_mulai,'dd-mm-yyyy')as tgl_mulai,tgl_selesai from sc_trx.cuti_karyawan
								where nik='$nik' 
								and (tgl_mulai>='$tgl_selesai' or tgl_selesai>='$tgl_awal')
								and (tgl_mulai<='$tgl_selesai' or tgl_selesai<='$tgl_awal')");				
	}
	
	function q_cuti_karyawan($tgl,$status,$nikatasan){
		return $this->db->query(" select * from (
									select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_mulai,'dd-mm-yyyy')as tgl_mulai1,
									to_char(a.tgl_selesai,'dd-mm-yyyy')as tgl_selesai1,
									case when a.status='A' then 'PERLU PERSETUJUAN'
									 when a.status='A1' then 'APROVAL 1'
									 when a.status='A2' then 'APROVAL 2'
									 when a.status='C' then 'DIBATALKAN'
									 when a.status='I' then 'INPUT'
									 when a.status='D' then 'DIHAPUS'
									 when a.status='P' then 'DISETUJUI/PRINT'
									end as status1,
									case when trim(a.tpcuti)='A' then 'CUTI'
									 when trim(a.tpcuti)='B' then 'CUTI KHUSUS'
									 when trim(a.tpcuti)='C' then 'CUTI DINAS'
									end as tpcuti1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_khusus,h.nmlengkap as nmpelimpahan,i.nmlengkap as nmatasan1,j.nmlengkap as nmatasan2,
									b.nik_atasan,b.nik_atasan2,b.sisacuti
									 from sc_trx.cuti_karyawan a 
									left outer join sc_mst.karyawan b 
									 on a.nik=b.nik
									left outer join sc_mst.departmen c 
									 on a.kddept=c.kddept
									left outer join sc_mst.subdepartmen d 
									 on a.kdsubdept=d.kdsubdept
									left outer join sc_mst.lvljabatan e 
									 on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f 
									 on a.kdjabatan=f.kdjabatan
									left outer join sc_mst.ijin_khusus g 
									 on a.kdijin_khusus=g.kdijin_khusus
									left outer join sc_mst.karyawan h 
									 on a.pelimpahan=h.nik
									left outer join sc_mst.karyawan i 
									 on b.nik_atasan=i.nik
									left outer join sc_mst.karyawan j 
									 on b.nik_atasan2=j.nik
									where coalesce(upper(b.status),'')!='KO' and to_char(a.input_date,'mmYYYY')='$tgl' and a.status $status
									order by a.nodok desc ) as x1
									$nikatasan

		
								");
	}
	
	
	function q_cuti_karyawan_dtl($nodok){
		return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
										to_char(a.tgl_mulai,'dd-mm-yyyy')as tgl_mulai1,
										to_char(a.tgl_selesai,'dd-mm-yyyy')as tgl_selesai1,
										a.status, 
										case
										when a.status='A' then 'PERLU PERSETUJUAN'
										when a.status='A1' then 'APROVAL 1'
										when a.status='A2' then 'APROVAL 2'
										when a.status='C' then 'DIBATALKAN'
										when a.status='I' then 'INPUT'
										when a.status='D' then 'DIHAPUS'
										when a.status='P' then 'DISETUJUI/PRINT'
										end as status1,
										case 
										when trim(a.tpcuti)='A' then 'CUTI'
										when trim(a.tpcuti)='B' then 'IJIN KHUSUS'
										when trim(a.tpcuti)='C' then 'IJIN DINAS'
										end as tpcuti1,
										case 
										when a.status_ptg='A1' then 'POTONG CUTI'
										when a.status_ptg='A2' then 'POTONG GAJI'
										end as status_ptg1,	
										a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_khusus,h.nmlengkap as nmpelimpahan,i.nmlengkap as nmatasan1,j.nmlengkap as nmatasan2
										from sc_trx.cuti_karyawan a 
										left outer join sc_mst.karyawan b on a.nik=b.nik
										left outer join sc_mst.departmen c on a.kddept=c.kddept
										left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
										left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
										left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
										left outer join sc_mst.ijin_khusus g on a.kdijin_khusus=g.kdijin_khusus
										left outer join sc_mst.karyawan h on a.pelimpahan=h.nik
										left outer join sc_mst.karyawan i on b.nik_atasan=i.nik
										left outer join sc_mst.karyawan j on b.nik_atasan2=j.nik
										where a.nodok='$nodok'
										order by a.nodok desc	");
	}
	

	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.cuti_karyawan set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_appa1($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.cuti_karyawan set status='A1',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_appa2($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.cuti_karyawan set status='A2',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}	
	
	function tr_appa3($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.cuti_karyawan set status='P',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.cuti_karyawan where nodok='$nodok'");
	}
	
	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.cuti_karyawan where nodok='$nodok' and status='C'");
	}
	
	function q_departmen(){
		return $this->db->query("select * from sc_mst.departmen");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_mst.jabatan");
	}


	function cek_closing(){
		return $this->db->query("select cast(value1 as date) as value1 from sc_mst.option where kdoption='TGLCLS'");
	}
	
	function q_hiscuti(){
		return $this->db->query("select * from sc_trx.cutibersama");
	}
	
/*	function list_tmp_cb($nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmdept from sc_tmp.cuti_blc a left outer join
									sc_mst.karyawan b on a.nik=b.nik left outer join
									sc_mst.departmen c on b.bag_dept=c.kddept where a.no_dokumen='$nodok' and a.status='F'");
	}
*/
	function list_tmp_cb($nodok,$dept,$jabatan){
		return $this->db->query("select a.*,b.nmlengkap,c.nmdept,d.nmjabatan from sc_tmp.cuti_blc a left outer join
								sc_mst.karyawan b on a.nik=b.nik left outer join
								sc_mst.departmen c on b.bag_dept=c.kddept left outer join 
								sc_mst.jabatan d on d.kdjabatan=b.jabatan
								where a.no_dokumen='$nodok' and a.status='F' and b.bag_dept $dept and d.kdjabatan $jabatan
								");
	}

	function list_tmp_cb_c($nodok,$dept,$jabatan){
		return $this->db->query("select a.*,b.nmlengkap,c.nmdept,d.nmjabatan from sc_tmp.cuti_blc a left outer join
								sc_mst.karyawan b on a.nik=b.nik left outer join
								sc_mst.departmen c on b.bag_dept=c.kddept left outer join 
								sc_mst.jabatan d on d.kdjabatan=b.jabatan
								where a.no_dokumen='$nodok' and a.status='C' and b.bag_dept $dept and d.kdjabatan $jabatan
								");
	}

	
/*	
	function list_tmp_cb_c($nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmdept from sc_tmp.cuti_blc a left outer join
									sc_mst.karyawan b on a.nik=b.nik left outer join
									sc_mst.departmen c on b.bag_dept=c.kddept where a.no_dokumen='$nodok' and a.status='C'");
	}
*/	
	function cek_tmp_cb($nik,$nodok){
		return $this->db->query("select a.*,b.nmlengkap,c.nmdept from sc_tmp.cuti_blc a left outer join
									sc_mst.karyawan b on a.nik=b.nik left outer join
									sc_mst.departmen c on b.bag_dept=c.kddept where a.no_dokumen='$nodok' and b.nik='$nik'");
	}
	
	function cek_cbersama($nodok){
		return $this->db->query("select *,to_char(tgl_awal,'dd-mm-yyyy')as tgl_awal1,to_char(tgl_akhir,'dd-mm-yyyy')as tgl_akhir1 from sc_trx.cutibersama where nodok='$nodok'");
	}
	
	function ot_cutibersama($nodok){
		return $this->db->query("update sc_trx.cuti_karyawan set status='P',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
/*	function q_cutiblc($tahun,$dept){
		return $this->db->query("
									select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept from sc_mst.karyawan a
										join(
										select a.nik,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_blc a,
										(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_blc a,
										(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
										(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'yyyy')='2016'
										group by nik) as b
										where a.nik=b.nik and a.tanggal=b.tanggal
										group by a.nik,a.tanggal) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
										group by a.nik,a.tanggal,a.no_dokumen) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) x
										on a.nik=x.nik where to_char(tanggal,'yyyy')='2016' and case when '$dept'<>'' then bag_dept='$dept' else bag_dept <> '' end

								"); */
								
	function q_cutiblc($tahun,$dept){
		return $this->db->query("
									select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept from sc_mst.karyawan a
										left outer join(
										select a.nik,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_blc a,
										(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_blc a,
										(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
										(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'yyyy')='$tahun'
										group by nik) as b
										where a.nik=b.nik and a.tanggal=b.tanggal
										group by a.nik,a.tanggal) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
										group by a.nik,a.tanggal,a.no_dokumen) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) x
										on a.nik=x.nik where to_char(tanggal,'yyyy')='$tahun' and bag_dept $dept and coalesce(upper(a.status),'')!='KO'
										/* trim(coalesce,'')<>'N'*/

								");
	}
	
	function q_cutilalu($tahun,$dept){
		return $this->db->query("
									select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept from sc_mst.karyawan a
										left outer join(
										select a.nik,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_lalu a,
										(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_lalu a,
										(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_lalu a,
										(select nik,max(tanggal) as tanggal from sc_trx.cuti_lalu where to_char(tanggal,'yyyy')='$tahun'
										group by nik) as b
										where a.nik=b.nik and a.tanggal=b.tanggal
										group by a.nik,a.tanggal) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
										group by a.nik,a.tanggal,a.no_dokumen) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) x
										on a.nik=x.nik where to_char(tanggal,'yyyy')='$tahun' and bag_dept $dept and coalesce(upper(a.status),'')!='KO'
										/* trim(coalesce,'')<>'N'*/

								");
	}	
	
	function excel_cutiblc($tahun){
		return $this->db->query("
									select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept from sc_mst.karyawan a
										left outer join(
										select a.nik,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_blc a,
										(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_blc a,
										(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
										(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'yyyy')='$tahun'
										group by nik) as b
										where a.nik=b.nik and a.tanggal=b.tanggal
										group by a.nik,a.tanggal) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
										group by a.nik,a.tanggal,a.no_dokumen) b
										where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) x
										on a.nik=x.nik where to_char(tanggal,'yyyy')='$tahun' and coalesce(upper(a.status),'')!='KO'
										

								");
	}
	
	function q_cutilaludtl($nik,$tahun){
		//return $this->db->query("select * from sc_trx.cuti_blc where nik='$nik' and  to_char(tanggal,'yyyy')='$tahun' order by tanggal asc");
		return $this->db->query("select x.nik,x.nmlengkap,x.tanggal,x.no_dokumen,x.in_cuti,x.out_cuti,x.sisacuti,x.doctype,x.status
									from (
										select a.nik,a.nmlengkap,(select cast(trim ('$tahun')||'-01-01' as timestamp) - INTERVAL '1 DAY') as tanggal,'SALDO' as no_dokumen,
										coalesce(b.sisacuti,0) as in_cuti,0 as out_cuti,coalesce(b.sisacuti,0) as sisacuti,'SLD' as doctype,'SALDO LALU' as status
										from sc_mst.karyawan a
										left outer join (
											select a.nik,coalesce(sisacuti,0) as sisacuti,a.tanggal from sc_trx.cuti_lalu a,
											(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_lalu a,
											(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_lalu a,
											(select nik,max(tanggal) as tanggal from sc_trx.cuti_lalu where to_char(tanggal,'YYYY')<'$tahun'
											group by nik) as b
											where a.nik=b.nik and a.tanggal=b.tanggal
											group by a.nik,a.tanggal) b
											where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
											group by a.nik,a.tanggal,a.no_dokumen) b
											where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) b
											 on a.nik=b.nik
										where a.nik='$nik'
										union all
										select a.nik,b.nmlengkap,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_lalu a, sc_mst.karyawan b where a.nik=b.nik and to_char(a.tanggal,'YYYY')='$tahun'
										and a.nik='$nik' and coalesce(upper(b.status),'')!='KO'
									) as x
									where x.nik='$nik'
									order by x.nik,x.tanggal,x.no_dokumen");
	}
	
	function q_cutiblcdtl($nik,$tahun){
		//return $this->db->query("select * from sc_trx.cuti_blc where nik='$nik' and  to_char(tanggal,'yyyy')='$tahun' order by tanggal asc");
		return $this->db->query("select x.nik,x.nmlengkap,x.tanggal,x.no_dokumen,x.in_cuti,x.out_cuti,x.sisacuti,x.doctype,x.status
									from (
										select a.nik,a.nmlengkap,(select cast(trim ('$tahun')||'-01-01' as timestamp) - INTERVAL '1 DAY') as tanggal,'SALDO' as no_dokumen,
										coalesce(b.sisacuti,0) as in_cuti,0 as out_cuti,coalesce(b.sisacuti,0) as sisacuti,'SLD' as doctype,'SALDO LALU' as status
										from sc_mst.karyawan a
										left outer join (
											select a.nik,coalesce(sisacuti,0) as sisacuti,a.tanggal from sc_trx.cuti_blc a,
											(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_blc a,
											(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
											(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'YYYY')<'$tahun'
											group by nik) as b
											where a.nik=b.nik and a.tanggal=b.tanggal
											group by a.nik,a.tanggal) b
											where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
											group by a.nik,a.tanggal,a.no_dokumen) b
											where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) b
											 on a.nik=b.nik
										where a.nik='$nik'
										union all
										select a.nik,b.nmlengkap,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_blc a, sc_mst.karyawan b where a.nik=b.nik and to_char(a.tanggal,'YYYY')='$tahun'
										and a.nik='$nik' and coalesce(upper(b.status),'')!='KO'
									) as x
									where x.nik='$nik'
									order by x.nik,x.tanggal,x.no_dokumen");
	}
	
	function excel_cutiblcdtl($tahun){
		//return $this->db->query("select * from sc_trx.cuti_blc where nik='$nik' and  to_char(tanggal,'yyyy')='$tahun' order by tanggal asc");
		return $this->db->query("select x.nik,x.nmlengkap,x.tanggal,x.no_dokumen,x.in_cuti,x.out_cuti,x.sisacuti,x.doctype,x.status
									from (
										select a.nik,a.nmlengkap,(select cast(trim ('$tahun')||'-01-01' as timestamp) - INTERVAL '1 DAY') as tanggal,'SALDO' as no_dokumen,
										coalesce(b.sisacuti,0) as in_cuti,0 as out_cuti,coalesce(b.sisacuti,0) as sisacuti,'SLD' as doctype,'SALDO LALU' as status
										from sc_mst.karyawan a
										left outer join (
											select a.nik,coalesce(sisacuti,0) as sisacuti,a.tanggal from sc_trx.cuti_blc a,
											(select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_blc a,
											(select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
											(select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where to_char(tanggal,'YYYY')<'$tahun'
											group by nik) as b
											where a.nik=b.nik and a.tanggal=b.tanggal
											group by a.nik,a.tanggal) b
											where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
											group by a.nik,a.tanggal,a.no_dokumen) b
											where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype) b
											 on a.nik=b.nik
										
										union all
										select a.nik,b.nmlengkap,a.tanggal,a.no_dokumen,a.in_cuti,a.out_cuti,a.sisacuti,a.doctype,a.status from sc_trx.cuti_blc a, sc_mst.karyawan b where a.nik=b.nik and to_char(a.tanggal,'YYYY')='$tahun'
										and coalesce(upper(b.status),'')!='KO'
									) as x
									order by x.nik,x.tanggal,x.no_dokumen");
	}
	
	function list_blc(){
		return $this->db->query("select * from sc_trx.cuti_blc where coalesce(upper(status),'')!='KO'");
		
	}
	
	function q_proc_htg($nikht){
		return $this->db->query("select sc_trx.pr_rekap_cutiblc('$nikht')");
	}
	
	function q_cekhakcuti($nik){
		return $this->db->query("select * from sc_mst.karyawan where age(tglmasukkerja)<interval'1 year' and nik='$nik'");
	}
	
	function q_addprctbr(){
		return $this->db->query("select sc_trx.pr_cutikaryawanbaru()");
	}
	
	function q_addprctrata(){
		return $this->db->query("select sc_trx.pr_cutirata()");
	}
	
	function q_prhgscuti(){
		return $this->db->query("select sc_trx.pr_hanguscuti()");
	}
		
	function q_hitungallcuti(){
		return $this->db->query("select sc_trx.pr_rekap_cutiblcall()");
	}
	
	function cek_tglmsukkerja(){
		return $this->db->query("select count(tglmasukkerja) as ceker from sc_mst.karyawan where tglmasukkerja<=cast(to_char(now()-interval '1 year','yyyy-mm-dd')as date)
									and to_char(tglmasukkerja,'mm-dd')= to_char(now(),'mm-dd') ");
	}
	/*private function _get_datatables_query()
	{
		$this->db->select("to_char(a.tgl_dok,'dd-mm-yyyy') as tgl_dok1,
								to_char(a.tgl_mulai,'dd-mm-yyyy')as tgl_mulai1,
								to_char(a.tgl_selesai,'dd-mm-yyyy')as tgl_selesai1,
								a.status, 
								case
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='P' then 'DISETUJUI/PRINT'
								when a.status='D' then 'DIHAPUS'
								end as status1,
								case 
								when trim(a.tpcuti)='A' then 'CUTI'
								when trim(a.tpcuti)='B' then 'IJIN KHUSUS'
								when trim(a.tpcuti)='C' then 'IJIN DINAS'
								end as tpcuti1,
								a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_khusus,h.nmlengkap as nmpelimpahan,i.nmlengkap as nmatasan1");	
		$this->db->from('sc_trx.cuti_karyawan a ');
		$this->db->join('sc_mst.karyawan b','a.nik=b.nik');
		$this->db->join('sc_mst.departmen c','a.kddept=c.kddept');
		$this->db->join('sc_mst.subdepartmen d','a.kdsubdept=d.kdsubdept');
		$this->db->join('sc_mst.lvljabatan e','a.kdlvljabatan=e.kdlvl');
		$this->db->join('sc_mst.jabatan f','a.kdjabatan=f.kdjabatan');
		$this->db->join('sc_mst.ijin_khusus g','a.kdijin_khusus=g.ijin_khusus');
		$this->db->join('sc_mst.karyawan h','a.pelimpahan=b.nik');
		$this->db->join('sc_mst.karyawan i','a.nmatasan=b.nik');
		//$this->db->query("select * from sc_mst.trxtype");

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])				
				($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
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
	function get_datatables()
	{
		$this->_get_datatables_query();
		
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}*/
}	