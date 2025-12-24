<?php
class M_lembur extends CI_Model {
	function list_karyawan($param = "") {
		return $this->db->query("
            SELECT a.*, b.nmdept 
            FROM sc_mst.karyawan a
            LEFT OUTER JOIN sc_mst.departmen b ON a.bag_dept = b.kddept
            LEFT OUTER JOIN sc_mst.subdepartmen c ON a.bag_dept = c.kddept AND a.subbag_dept = c.kdsubdept
            LEFT OUTER JOIN sc_mst.jabatan d ON a.bag_dept = d.kddept AND a.subbag_dept = d.kdsubdept AND a.jabatan = d.kdjabatan
            WHERE COALESCE(UPPER(a.statuskepegawaian), '') != 'KO'
            $param
            ORDER BY nmlengkap
        ");
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
									where to_char(a.tgl_dok,'mm-YYYY')='$tgl' and a.status $status and a.nik $nik2
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
								cast(cast((durasi-(floor(durasi/60.)*60)) as integer)as character(12))||' Menit' as jam,b.nik_atasan,b.nik_atasan2
								from sc_trx.lembur a 
								left outer join sc_mst.karyawan b on a.nik=b.nik
								left outer join sc_mst.departmen c on a.kddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.kdsubdept=d.kdsubdept and d.kddept=c.kddept
								left outer join sc_mst.lvljabatan e on a.kdlvljabatan=e.kdlvl
								left outer join sc_mst.jabatan f on b.bag_dept=f.kddept and b.subbag_dept=f.kdsubdept and b.jabatan=f.kdjabatan
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

    function q_checkConflict($nik, $nodok, $jam_awal, $jam_akhir) {
        return $this->db->query("
            WITH x AS (
                SELECT '$nik'::TEXT AS nik, '$jam_awal'::TIMESTAMP AS jam_awal, '$jam_akhir'::TIMESTAMP AS jam_akhir
            )
            (SELECT dd::DATE AS tgl, '' AS nodok, a.tgl::TEXT AS tgl_masuk, (a.tgl + (b.jam_masuk >= b.jam_pulang)::INT)::TEXT AS tgl_pulang, 
            b.jam_masuk::TEXT AS jam_masuk, b.jam_pulang::TEXT AS jam_pulang, 
            CASE 
                WHEN a.kdjamkerja IS NULL AND c.nik IS NOT NULL
                THEN FALSE
                ELSE ((a.tgl || ' ' || b.jam_masuk)::TIMESTAMP, (a.tgl + (b.jam_masuk >= b.jam_pulang)::INT || ' ' || b.jam_pulang)::TIMESTAMP) OVERLAPS (x.jam_awal, x.jam_akhir) 
            END AS is_conflict
            FROM x
            LEFT JOIN GENERATE_SERIES((x.jam_awal::DATE - 1)::TIMESTAMP, (x.jam_awal::DATE + 1)::TIMESTAMP, '1 DAY'::INTERVAL) dd ON TRUE
            LEFT JOIN sc_trx.dtljadwalkerja a ON a.tgl = dd::DATE AND a.nik = x.nik
            LEFT JOIN sc_mst.jam_kerja b ON b.kdjam_kerja = a.kdjamkerja
            LEFT JOIN sc_trx.listjadwalkerja c ON c.nik = x.nik AND c.tahun = TO_CHAR(dd, 'YYYY') AND c.bulan = TO_CHAR(dd, 'MM')
            ORDER BY 1)
            UNION ALL
            (SELECT COALESCE(a.tgl_kerja, x.jam_awal::DATE) AS tgl, a.nodok, a.tgl_jam_mulai::DATE::TEXT AS tgl_masuk, a.tgl_jam_selesai::DATE::TEXT AS tgl_pulang, 
            a.tgl_jam_mulai::TIME::TEXT AS jam_masuk, a.tgl_jam_selesai::TIME::TEXT AS jam_pulang,
            CASE
                WHEN a.tgl_kerja IS NULL
                THEN FALSE
                ELSE (a.tgl_jam_mulai, a.tgl_jam_selesai) OVERLAPS (x.jam_awal, x.jam_akhir)
            END AS is_conflict 
            FROM x
            LEFT JOIN sc_trx.lembur a ON a.nik = x.nik AND a.status IN ('A', 'P')
            WHERE a.nodok <> '$nodok'
            ORDER BY a.tgl_jam_mulai, a.tgl_jam_selesai)
        ");
    }
}
