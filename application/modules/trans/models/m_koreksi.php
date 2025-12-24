<?php
class M_koreksi extends CI_Model{



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

	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept where coalesce(upper(a.statuskepegawaian),'')!='KO' 
								order by nmlengkap asc");
		
	}
	
	function list_kcb(){
		return $this->db->query("select a.*,b.nmlengkap from sc_trx.koreksicb a 
								 left outer join sc_mst.karyawan b on a.nik=b.nik where a.doctype='Y'");
	}	
	
	function list_kks(){
		return $this->db->query("select a.*,b.nmlengkap,b.nmlengkap,b.tglmasukkerja,to_char(cast(to_char(b.tglmasukkerja,to_char(input_date,'yyyy')||'-mm-dd')as date)+interval '2 months','yyyy-mm-dd') as tglhgscuti ,to_char(a.tgl_dok,'yyyy-mm-dd') as tgl_dok2
								from sc_trx.koreksicb a 
								left outer join sc_mst.karyawan b on a.nik=b.nik where a.doctype='X' and a.status='P'
							    ");
	}
	function list_kkstmp(){
		return $this->db->query("select a.*,b.nmlengkap,b.nmlengkap,b.tglmasukkerja,to_char(cast(to_char(b.tglmasukkerja,to_char(input_date,'yyyy')||'-mm-dd')as date)+interval '2 months','yyyy-mm-dd') as tglhgscuti,to_char(a.tgl_dok,'yyyy-mm-dd') as tgl_dok2 
								from sc_tmp.koreksicb a 
								left outer join sc_mst.karyawan b on a.nik=b.nik where a.doctype='X' and a.status='I'
							    ");
	}
	
	function cek_kks($nodok,$nik,$jumlahcuti){
		return $this->db->query("select a.*,b.nmlengkap,b.tglmasukkerja,to_char(cast(to_char(b.tglmasukkerja,to_char(input_date,'yyyy')||'-mm-dd')as date)+interval '2 months','yyyy-mm-dd') as tglhgscuti,to_char(a.tgl_dok,'dd-mm-yyyy') as tgl_dok2  from sc_tmp.koreksicb a 
								 left outer join sc_mst.karyawan b on a.nik=b.nik where a.doctype='X' and a.nodok='$nodok' and a.nik='$nik' and jumlahcuti='$jumlahcuti'");
	}
	
	
	function cek_kcb($nodok,$nik,$jumlahcuti){
		return $this->db->query("select a.*,b.nmlengkap from sc_tmp.koreksicb a
								left outer join sc_mst.karyawan b on a.nik=b.nik where a.nodok='$nodok' and a.nik='$nik' and a.jumlahcuti='$jumlahcuti'");
	}
	
	function list_cb(){
		return $this->db->query("select * from sc_trx.cutibersama where status='P'");
	}
	
	function q_koreksikhusus($tahun,$dept){
		return $this->db->query("
									select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept from sc_mst.karyawan a
										join(
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
	
	function q_departmen(){
		return $this->db->query("select * from sc_mst.departmen");
	}


    function list_trx_koreksicb($param){
        return $this->db->query("select * from (
                                    select a1.*,a.nmlengkap,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2,a2.uraian as nmdoctype,a3.uraian as nmoperator,a4.uraian as nmstatus from sc_trx.koreksicb a1
                                    left outer join sc_mst.karyawan a on a.nik=a1.nik
                                    left outer join sc_mst.departmen b on a.bag_dept=b.kddept
                                    left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
                                    left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
                                    left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
                                    left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
                                    left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
                                    left outer join sc_mst.trxtype a2 on a1.doctype=a2.kdtrx and a2.jenistrx='K_CUTI'
                                    left outer join sc_mst.trxtype a3 on a1.operator=a3.kdtrx and a3.jenistrx='K_CUTI_OP'
                                    left outer join sc_mst.trxtype a4 on a1.status=a4.kdtrx and a4.jenistrx='PDCA'
                                    ) as x
                                    where nik is not null $param 
                                    order by tgl_dok desc, nodok desc");
    }

    function list_tmp_koreksicb($param){
        return $this->db->query("select * from (
                                    select a1.*,a.nmlengkap,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2,a2.uraian as nmdoctype,a3.uraian as nmoperator,a4.uraian as nmstatus from sc_tmp.koreksicb a1
                                    left outer join sc_mst.karyawan a on a.nik=a1.nik
                                    left outer join sc_mst.departmen b on a.bag_dept=b.kddept
                                    left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
                                    left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
                                    left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
                                    left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
                                    left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
                                    left outer join sc_mst.trxtype a2 on a1.doctype=a2.kdtrx and a2.jenistrx='K_CUTI'
                                    left outer join sc_mst.trxtype a3 on a1.operator=a3.kdtrx and a3.jenistrx='K_CUTI_OP'
                                    left outer join sc_mst.trxtype a4 on a1.status=a4.kdtrx and a4.jenistrx='PDCA'
                                    ) as x
                                    where nik is not null $param 
                                    order by tgl_dok desc, nodok desc");
    }

    function q_trxtype($param){
        return $this->db->query("select * from sc_mst.trxtype where kdtrx is not null $param order by uraian asc");
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}