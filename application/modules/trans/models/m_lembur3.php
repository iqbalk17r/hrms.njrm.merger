<?php
class M_lembur extends CI_Model{
	
	
	
	
	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
		left outer join sc_mst.departmen b on a.bag_dept=b.kddept
		left outer join sc_mst.subdepartmen c on a.bag_dept=c.kddept and a.subbag_dept=c.kdsubdept
		left outer join sc_mst.jabatan d on a.bag_dept=d.kddept and a.subbag_dept=d.kdsubdept and a.jabatan=d.kdjabatan
		where coalesce(upper(a.statuskepegawaian),'')!='KO'
		order by nmlengkap asc");
		
	}
	
	function list_lembur(){
		return $this->db->query("select tplembur from sc_mst.lembur 
								group by tplembur
								order by tplembur asc");
		
	}
	
	function list_trxtype(){
		return $this->db->query("select * from sc_mst.trxtype
								where trim(jenistrx)='ALASAN LEMBUR'
								order by kdtrx asc");
		
	}
	function list_karyawan_index($nik){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on  a.bag_dept=c.kddept and a.subbag_dept=c.kdsubdept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl
								left outer join sc_mst.jabatan e on a.bag_dept=e.kddept and a.subbag_dept=e.kdsubdept and a.jabatan=e.kdjabatan
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								where a.nik='$nik'
								");
	}
	
	
	function q_lembur($tgl,$status,$nik2,$nikatasan){
		
		return $this->db->query("select * from (select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
									a.status,j.uraian as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,h.uraian,i.nmlengkap as nmatasan1,
									cast(cast(floor(durasi/60.) as integer)as character(12))|| ' Jam '||
									cast(cast((durasi-(floor(durasi/60.)*60)) as integer)as character(12))||' Menit' as jam
									from sc_trx.lembur a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept
									left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on b.bag_dept=f.kddept and b.subbag_dept=f.kdsubdept and b.jabatan=f.kdjabatan
									left outer join sc_mst.trxtype h on a.kdtrx=h.kdtrx and trim(h.jenistrx)='ALASAN LEMBUR'
									left outer join sc_mst.karyawan i on a.nmatasan=i.nik
									left outer join sc_mst.trxtype j on a.status=j.kdtrx and j.jenistrx='LEMBUR'
									where to_char(a.tgl_dok,'mmYYYY')='$tgl' and a.status $status and a.nik $nik2
									order by a.nodok desc) as x1
									$nikatasan
								");
	}
	
	
	function q_lembur_edit($nodok){
		return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
								to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
								to_char(a.tgl_jam_selesai,'dd-mm-yyyy')as tgl_kerja2,
								cast(to_char(a.tgl_jam_mulai,'HH24:MI:SS')as time)as jam_awal,
								cast(to_char(a.tgl_jam_selesai,'HH24:MI:SS')as time)as jam_akhir,
								a.status,j.uraian as status1,
								a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,h.uraian,i.nmlengkap as nmatasan1,
								cast(cast(floor(durasi/60.) as integer)as character(12))|| ' Jam '||
								cast(cast((durasi-(floor(durasi/60.)*60)) as integer)as character(12))||' Menit' as jam	
								from sc_trx.lembur a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on a.kddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=c.kddept
								left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
								left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan and f.kdsubdept=d.kdsubdept and f.kddept=c.kddept
								left outer join sc_mst.trxtype h on a.kdtrx=h.kdtrx and trim(h.jenistrx)='ALASAN LEMBUR'
								left outer join sc_mst.karyawan i on a.nmatasan=i.nik
								left outer join sc_mst.trxtype j on a.status=j.kdtrx and j.jenistrx='LEMBUR'
								where a.nodok='$nodok'
								order by a.nodok desc
								");
	}
	
	function q_lembur_dtl(){
		return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
								to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
								a.status, 
								case
								when a.status='P' then 'DISETUJUI'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='D' then 'DIHAPUS'
								end as status1,
								a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,h.uraian,i.nmlengkap as nmatasan1,
								cast(cast(floor(durasi/60.) as integer)as character(12))|| ' Jam '||
								cast(cast((durasi-(floor(durasi/60.)*60)) as integer)as character(12))||' Menit' as jam	
								from sc_trx.lembur a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on a.kddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept
								left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
								left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan
								left outer join sc_mst.trxtype h on a.kdtrx=h.kdtrx and trim(h.jenistrx)='ALASAN LEMBUR'
								left outer join sc_mst.karyawan i on a.nmatasan=i.nik
								order by a.nodok desc
								");
	}
	
	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.lembur set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}
	
	function tr_app($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.lembur set status='P',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}
	
	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.lembur where nodok='$nodok' and status='P'");
	}
	
	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.lembur where nodok='$nodok' and status='C'");
	}
	
	
	function cek_dokumen3($nodok){
		return $this->db->query("select * from sc_trx.lembur where nodok='$nodok' and status<>'D'");
	}
	
	
	function cek_position($nik){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nik'");
	
	}
	
	function tgl_closing(){
		return $this->db->query("select cast(value1 as date) from sc_mst.option where kdoption='TGLCLS' and trim(nmoption)='TANGGAL CLOSING'");
	}
	
	function q_cekdouble($nik,$tgl_kerja,$jam_awal1){
		return $this->db->query("select * from sc_trx.lembur
								where nik='$nik' and tgl_kerja='$tgl_kerja' and tgl_jam_mulai='$jam_awal1' and status='P'");
	
	}
}	