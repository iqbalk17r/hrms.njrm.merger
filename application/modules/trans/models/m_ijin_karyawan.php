<?php
class M_ijin_karyawan extends CI_Model{




	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept where a.tglkeluarkerja is null
								order by nmlengkap asc");

	}

	function list_ijin(){
		return $this->db->query("select * from sc_mst.ijin_absensi 
								order by nmijin_absensi asc");

	}

    function list_ijin_khusus() {
        return $this->db->query("select * from sc_mst.ijin_absensi 
								WHERE kdijin_absensi in ('IK','PA','DT')
								order by nmijin_absensi asc");
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


	function q_ijin_karyawan($tgl,$nikatasan,$status){
		return $this->db->query("select * from (select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
									to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
									a.status, 
									case
									when a.status='A' then 'PERLU PERSETUJUAN'
									when a.status='C' then 'DIBATALKAN'
									when a.status='I' then 'INPUT'
									when a.status='D' then 'DIHAPUS'
									when a.status='P' then 'DISETUJUI/PRINT'
									end as status1,
									a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_absensi,h.nmlengkap as nmatasan1,case when type_ijin='PB' then 'PRIBADI' when type_ijin='DN' then 'DINAS' end as kategori from sc_trx.ijin_karyawan a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on a.kddept=c.kddept 
									left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
									left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
									left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
									left outer join sc_mst.ijin_absensi g on a.kdijin_absensi=g.kdijin_absensi
									left outer join sc_mst.karyawan h on a.nmatasan=h.nik
								where to_char(a.tgl_kerja,'mmYYYY')='$tgl' and a.status $status
								order by a.nodok desc )as x1
								$nikatasan");
	}


	function q_ijin_karyawan_dtl($nodok){
		return $this->db->query("select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
								to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
								a.status, 
								case
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='D' then 'DIHAPUS'
								when a.status='P' then 'DISETUJUI/PRINT'
								end as status1,
								a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_absensi,h.nmlengkap as nmatasan1 from sc_trx.ijin_karyawan a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on a.kddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
								left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
								left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan  and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
								left outer join sc_mst.ijin_absensi g on a.kdijin_absensi=g.kdijin_absensi
								left outer join sc_mst.karyawan h on a.nmatasan=h.nik
								where a.nodok='$nodok'
								order by a.nodok desc");
	}

	function q_json_ijin_karyawan($param){
		return $this->db->query("select 
									trim(coalesce(tgl_dok1       ::text,'')) as tgl_dok1        ,
									trim(coalesce(tgl_kerja1     ::text,'')) as tgl_kerja1      ,
									trim(coalesce(status         ::text,'')) as status          ,
									trim(coalesce(status1        ::text,'')) as status1         ,
									trim(coalesce(nmtype         ::text,'')) as nmtype          ,
									trim(coalesce(nik            ::text,'')) as nik             ,
									trim(coalesce(nodok          ::text,'')) as nodok           ,
									trim(coalesce(tgl_dok        ::text,'')) as tgl_dok         ,
									trim(coalesce(kdijin_absensi ::text,'')) as kdijin_absensi  ,
									trim(coalesce(kddept         ::text,'')) as kddept          ,
									trim(coalesce(kdsubdept      ::text,'')) as kdsubdept       ,
									trim(coalesce(kdjabatan      ::text,'')) as kdjabatan       ,
									trim(coalesce(kdlvljabatan   ::text,'')) as kdlvljabatan    ,
									trim(coalesce(nmatasan       ::text,'')) as nmatasan        ,
									trim(coalesce(tgl_kerja      ::text,'')) as tgl_kerja       ,
									trim(coalesce(tgl_jam_mulai  ::text,'')) as tgl_jam_mulai   ,
									trim(coalesce(tgl_jam_selesai::text,'')) as tgl_jam_selesai ,
									trim(coalesce(durasi         ::text,'')) as durasi          ,
									trim(coalesce(status         ::text,'')) as status          ,
									trim(coalesce(keterangan     ::text,'')) as keterangan      ,
									trim(coalesce(input_date     ::text,'')) as input_date      ,
									trim(coalesce(approval_date  ::text,'')) as approval_date   ,
									trim(coalesce(input_by       ::text,'')) as input_by        ,
									trim(coalesce(approval_by    ::text,'')) as approval_by     ,
									trim(coalesce(delete_by      ::text,'')) as delete_by       ,
									trim(coalesce(cancel_by      ::text,'')) as cancel_by       ,
									trim(coalesce(update_date    ::text,'')) as update_date     ,
									trim(coalesce(delete_date    ::text,'')) as delete_date     ,
									trim(coalesce(cancel_date    ::text,'')) as cancel_date     ,
									trim(coalesce(update_by      ::text,'')) as update_by       ,
									trim(coalesce(type_ijin      ::text,'')) as type_ijin       ,
									trim(coalesce(nmlengkap      ::text,'')) as nmlengkap       ,
									trim(coalesce(nmdept         ::text,'')) as nmdept          ,
									trim(coalesce(nmsubdept      ::text,'')) as nmsubdept       ,
									trim(coalesce(nmlvljabatan   ::text,'')) as nmlvljabatan    ,
									trim(coalesce(nmjabatan      ::text,'')) as nmjabatan       ,
									trim(coalesce(nmijin_absensi ::text,'')) as nmijin_absensi  ,
									trim(coalesce(nmatasan1      ::text,'')) as nmatasan1       ,
									trim(coalesce(kendaraan      ::text,'')) as kendaraan       ,
									trim(coalesce(nopol      ::text,'')) as nopol               ,
									trim(coalesce(nikpengikut      ::text,'')) as nikpengikut   ,
									trim(coalesce(nmapproval     ::text,'')) as nmapproval  from (
									select to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
										to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1, 
										case
										when a.status='A' then 'PERLU PERSETUJUAN'
										when a.status='C' then 'DIBATALKAN'
										when a.status='I' then 'INPUT'
										when a.status='D' then 'DIHAPUS'
										when a.status='P' then 'DISETUJUI/PRINT'
										end as status1,
										case
										when a.type_ijin='DN' then 'DINAS'
										when a.type_ijin='PB' then 'PRIBADI'
										end as nmtype,
										a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmjabatan,g.nmijin_absensi,h.nmlengkap as nmatasan1,i2.nmlengkap as nmapproval from sc_trx.ijin_karyawan a 
										left outer join sc_mst.karyawan b on a.nik=b.nik
										left outer join sc_mst.departmen c on a.kddept=c.kddept
										left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
										left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
										left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan  and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
										left outer join sc_mst.ijin_absensi g on a.kdijin_absensi=g.kdijin_absensi
										left outer join sc_mst.karyawan h on a.nmatasan=h.nik
										left outer join sc_mst.karyawan i on a.approval_by=i.nik
                                        left outer join lateral(
                                            select
                                                u.username,
                                                k.nik,
                                                k.nmlengkap 
                                            from sc_mst.karyawan k
                                            left outer join sc_mst.user u on k.nik = u.nik
                                        ) i2 on true and (a.approval_by = i2.username or a.approval_by = i2.nik)
										) as x where nodok is not null $param order by nodok desc");
	}

	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.ijin_karyawan set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}

	function tr_app($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.ijin_karyawan set status='P',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}

	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nodok='$nodok' and status='P'");
	}

	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nodok='$nodok' and status='C'");
	}

	function cek_double($nik,$tgl_kerja){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nik='$nik' and tgl_kerja='$tgl_kerja' and (status='P' or status='A')");
	}

    function cek_input($nodok){
        return $this->db->query("select * from sc_trx.ijin_karyawan where nodok='$nodok' and status='A'");
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
	
	function q_cek_ijinkaryawan($nik,$tgl_kerja){
		return $this->db->query("select * from sc_trx.ijin_karyawan where nik='$nik' and tgl_kerja='$tgl_kerja' and (status='P' or status='A')");
	}

    function q_transaction_read_where($clause = null)
    {
        return $this->db->query($this->q_transaction_txt_where($clause));
    }

    function q_transaction_txt_where($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT 
    *
FROM(
    SELECT
    COALESCE(TRIM(a.nik, '')) AS nik,
    COALESCE(TRIM(a.nodok, '')) AS nodok,
    COALESCE(TRIM(a.status, '')) AS status,
    COALESCE(TRIM(a.type_ijin, '')) AS tipe_ijin,
    COALESCE(TRIM(a.kdijin_absensi, '')) AS kdijin_absensi,
    to_char(a.tgl_dok,'dd-mm-yyyy')as tgl_dok1,
    to_char(a.tgl_kerja,'dd-mm-yyyy')as permissiondate,
    to_char(a.tgl_kerja,'dd-mm-yyyy')as tgl_kerja1,
    case
        when a.status='A' then 'PERLU PERSETUJUAN'
        when a.status='C' then 'DIBATALKAN'
        when a.status='I' then 'INPUT'
        when a.status='D' then 'DIHAPUS'
        when a.status='P' then 'DISETUJUI/PRINT'
    end as status1,
    COALESCE(TRIM(b.nmlengkap, '')) AS nmlengkap,
    COALESCE(TRIM(c.nmdept, '')) AS nmdept,
    COALESCE(TRIM(d.nmsubdept, '')) AS nmsubdept,
    COALESCE(TRIM(e.nmlvljabatan, '')) AS nmlvljabatan,
    COALESCE(TRIM(f.nmjabatan, '')) AS nmjabatan,
    COALESCE(TRIM(g.nmijin_absensi, '')) AS nmijin_absensi,
    a.tgl_jam_mulai AS tgl_jam_mulai,
    a.tgl_jam_selesai AS tgl_jam_selesai,
    COALESCE(TRIM(i.nmlengkap, '')) AS nmatasan1,
    COALESCE(TRIM(j.nmlengkap, '')) AS nmatasan2,
    COALESCE(TRIM(b.nik_atasan, '')) AS nik_atasan,
    COALESCE(TRIM(b.nik_atasan2, '')) AS nik_atasan2,
    COALESCE(b.sisacuti ,0) AS sisacuti,
    COALESCE(TRIM(c.nmdept, '')) AS bagian,
    COALESCE(TRIM(a.keterangan, '')) AS keterangan,
    CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
    CASE
        WHEN a.status='P' THEN 'DISETUJUI/PRINT'
        WHEN a.status='C' THEN 'DIBATALKAN'
        WHEN a.status='I' THEN 'INPUT'
        WHEN a.status='A' THEN 'PERLU PERSETUJUAN'
        WHEN a.status='D' THEN 'DIHAPUS'
        END AS formatstatus,
    case
        when type_ijin='PB' then 'PRIBADI'
        when type_ijin='DN' then 'DINAS'
    end as kategori,
    CASE
        WHEN a.kdijin_absensi = 'IK' THEN CONCAT(a.tgl_jam_mulai,' s/d ',a.tgl_jam_selesai)::text
        WHEN a.kdijin_absensi = 'DT' THEN a.tgl_jam_mulai::text
        WHEN a.kdijin_absensi = 'PA' THEN a.tgl_jam_selesai::text
        ELSE 'dd'
        END AS permissiontime,
    TO_CHAR(a.input_date,'DD-MM-YYYY') AS input_date,
    CASE
        WHEN a.tgl_jam_mulai is null then concat(to_char(a.tgl_kerja,'dd-mm-yyyy '),a.tgl_jam_selesai)
        WHEN a.tgl_jam_selesai is null then concat(to_char(a.tgl_kerja,'dd-mm-yyyy '),a.tgl_jam_mulai)
        WHEN a.tgl_jam_mulai is not null then concat(to_char(a.tgl_kerja,'dd-mm-yyyy '),a.tgl_jam_mulai)
        ELSE '00:00:00'
        END AS begintime,
    CASE
        WHEN a.tgl_jam_mulai is null then concat(to_char(a.tgl_kerja,'dd-mm-yyyy '),a.tgl_jam_selesai)
        WHEN a.tgl_jam_selesai is null then concat(to_char(a.tgl_kerja,'dd-mm-yyyy '),a.tgl_jam_mulai)
        WHEN a.tgl_jam_selesai is not null then concat(to_char(a.tgl_kerja,'dd-mm-yyyy '),a.tgl_jam_selesai)
        ELSE '00:00:00'
        END AS endtime,
    to_char(a.tgl_kerja,'mmYYYY') AS filterdate
FROM sc_trx.ijin_karyawan a
         LEFT OUTER JOIN sc_mst.karyawan b ON a.nik=b.nik
         LEFT OUTER JOIN sc_mst.departmen c ON b.bag_dept=c.kddept
         left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=b.bag_dept
         left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
         left outer join sc_mst.jabatan f on a.kdjabatan=f.kdjabatan and f.kdsubdept=b.subbag_dept and f.kddept=b.bag_dept
         left outer join sc_mst.ijin_absensi g on a.kdijin_absensi=g.kdijin_absensi
         left outer join sc_mst.karyawan i on b.nik_atasan=i.nik
         left outer join sc_mst.karyawan j on b.nik_atasan2=j.nik
WHERE TRUE
  AND coalesce(upper(b.statuskepegawaian),'')!='KO'
 ) AS aa WHERE TRUE 
SQL
            ) . $clause;
    }
	
}
