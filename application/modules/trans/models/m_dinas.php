<?php
class M_dinas extends CI_Model{

	function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept where a.tglkeluarkerja is null
								order by nmlengkap asc");

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

	function q_dinas_karyawan($tgl,$status,$nikatasan){
		return $this->db->query(" 
        select *,
           CASE
               WHEN namakotakab IS NULL THEN tujuan_kota
               ELSE namakotakab
           END AS namakotakab,
           CASE
               WHEN jenis_tujuan IS NULL THEN 'LL'
               ELSE jenis_tujuan
           END AS jenis_tujuan,
        ( select true from sc_trx.cashbon where dutieid = x1.nodok and status='P' ) as casboned, (select true from sc_trx.declaration_cashbon where dutieid = x1.nodok and status='P') as declared from 
		(select a.*,b.nmlengkap,c.nmdept,b.nohp1,g.destination_text AS namakotakab,
								case
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='D' then 'DIHAPUS'
								when a.status='P' then 'DISETUJUI/PRINT'
								end as status1,
		                        (SELECT count(*) FROM sc_his.dinas WHERE nodok = a.nodok AND nik = a.nik AND status = 'P') AS history_approve
		                        from sc_trx.dinas a
								left outer join sc_mst.karyawan b on a.nik=b.nik								
								left outer join sc_mst.departmen c on b.bag_dept=c.kddept
								left outer join sc_mst.kotakab d on a.tujuan_kota = d.kodekotakab
		                        LEFT OUTER JOIN (
                                      select
                                          string_agg(aa.namakotakab,', ') AS destination_text,
                                          nodok
                                      from(
                                              select
                                                  a.nodok,
                                                  b.namakotakab
                                              from sc_trx.dinas a
                                                       LEFT OUTER JOIN sc_mst.kotakab b ON b.kodekotakab IN (select unnest(string_to_array(a.tujuan_kota,',')))
                                    ) aa
                                    group by aa.nodok
                                ) g ON a.nodok = g.nodok
								where to_char(a.tgl_mulai, 'mmYYYY')='$tgl' and a.status $status)
								as x1 $nikatasan
								order by tgl_dok desc");
	}


	function q_dinas_karyawan_dtl($nodok){
		return $this->db->query("select a.*,b.nik_atasan,b.nik_atasan2,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmjabatan,f.nmlengkap as nmatasan1,g.nmlengkap as nmatasan2,to_char(tgl_mulai,'dd-mm-yyyy')||' - '||to_char(tgl_selesai,'dd-mm-yyyy') as daterange1,
								case
								when a.status='A' then 'PERLU PERSETUJUAN'
								when a.status='C' then 'DIBATALKAN'
								when a.status='I' then 'INPUT'
								when a.status='D' then 'DIHAPUS/EXPIRED'
								when a.status='P' then 'DISETUJUI/PRINT'
								end as status1 from sc_trx.dinas a
		left outer join sc_mst.karyawan b on a.nik=b.nik								
		left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
		left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept 
		left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.subbag_dept=e.kdsubdept and b.jabatan=e.kdjabatan 
		left outer join sc_mst.karyawan f on b.nik_atasan=f.nik
		left outer join sc_mst.karyawan g on b.nik_atasan2=g.nik
		where a.nodok='$nodok' order by tgl_dok asc");
	}




	function tr_cancel($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.dinas set status='C',cancel_by='$inputby',cancel_date='$tgl_input' where nodok='$nodok'");
	}

	function tr_app($nodok,$inputby,$tgl_input){
		return $this->db->query("update sc_trx.dinas set status='F',approval_by='$inputby',approval_date='$tgl_input' where nodok='$nodok'");
	}

	function cek_dokumen($nodok){
		return $this->db->query("select * from sc_trx.dinas where nodok='$nodok' and status='P'");
	}

	function cek_dokumen2($nodok){
		return $this->db->query("select * from sc_trx.dinas where nodok='$nodok' and status='C'");
	}

    function cek_input($nodok){
        return $this->db->query("select * from sc_trx.dinas where nodok='$nodok' and status='A'");
    }

	function cek_double($nik,$tglberangkat,$tglkembali){
		return $this->db->query("select * from sc_trx.dinas where nik='$nik' and (tgl_mulai>='$tglkembali' or tgl_selesai>='$tglberangkat')
								and (tgl_mulai<='$tglkembali' or tgl_selesai<='$tglberangkat') and (status='P' or status='A')");
	}
    function cek_tmp_dinas($nama){
        return $this->db->query("select * from sc_tmp.dinas where nodok='$nama' ");
    }

    function cek_tmp_dinas_param($param){
        return $this->db->query("select * from sc_tmp.dinas where nodok is not null $param limit 1");
    }

    function cek_tmp_dinasx($nik){
        return $this->db->query("select * from sc_tmp.dinas where nik='$nik' limit 1");
    }

    function cek_trx_dinas($nodok){
        return $this->db->query("select * from sc_trx.dinas where nodok='$nodok' ");
    }

	function add_multinik($data = array()){
        $insert = $this->db->insert_batch('sc_tmp.dinas',$data);
        return $insert?true:false;
    }

	function list_tmp_dinas($nama,$tglberangkat,$tglkembali){
		return $this->db->query("select a.*,b.nmlengkap,b.nik_atasan,c.nmdept,d.nmsubdept,e.nmjabatan from sc_tmp.dinas a 
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
									left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept 
									left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.subbag_dept=e.kdsubdept and b.jabatan=e.kdjabatan 
									where a.nodok='$nama' and a.tgl_mulai='$tglberangkat' and a.tgl_selesai='$tglkembali'");
	}

	function cek_tmp($nama){
		return $this->db->query("select * from sc_tmp.dinas where nodok='$nama' limit 1");
	}

	function q_ktg_dinas(){
		return $this->db->query("select * from sc_mst.kategori where typekategori='DINAS' order by kdkategori");
	}



	function q_sti_dinas_dtl($nodok){
		return $this->db->query("select	trim(coalesce(nik::text,'')) as nik,               
		trim(coalesce(nodok::text,'')) as nodok,             
		trim(coalesce(to_char(tgl_dok,'dd-mm-yyyy')::text,'')) as tgl_dok,           
		trim(coalesce(nmatasan::text,'')) as nmatasan,          
		trim(coalesce(to_char(tgl_mulai,'dd-mm-yyyy')::text,'')) as tgl_mulai,         
		trim(coalesce(to_char(tgl_selesai,'dd-mm-yyyy')::text,'')) as tgl_selesai,       
		trim(coalesce(status::text,'')) as status,            
		trim(coalesce(keperluan::text,'')) as keperluan,         
		trim(coalesce(namakotakab::text,'Lainnya')) as tujuan,            
		trim(coalesce(input_date::text,'')) as input_date,        
		trim(coalesce(input_by::text,'')) as input_by,          
		trim(coalesce(to_char(approval_date,'dd-mm-yyyy HH:mm')::text,'')) as approval_date,     
		trim(coalesce(approval_by::text,'')) as approval_by,       
		trim(coalesce(delete_date::text,'')) as delete_date,       
		trim(coalesce(delete_by::text,'')) as delete_by,         
		trim(coalesce(update_by::text,'')) as update_by,         
		trim(coalesce(update_date::text,'')) as update_date,       
		trim(coalesce(cancel_by::text,'')) as cancel_by,         
		trim(coalesce(cancel_date::text,'')) as cancel_date,       
		trim(coalesce(nmlengkap::text,'')) as nmlengkap,         
		trim(coalesce(nmdept::text,'')) as nmdept,            
		trim(coalesce(nmsubdept::text,'')) as nmsubdept,         
		trim(coalesce(nmjabatan::text,'')) as nmjabatan,         
		trim(coalesce(nmatasan1::text,'')) as nmatasan1,         
		trim(coalesce(nmatasan2::text,'')) as nmatasan2,         
		trim(coalesce(daterange1::text,'')) as daterange1,        
		trim(coalesce(status1::text,''))  as status1, 
		trim(coalesce(kdkategori::text,''))  as kdkategori, 
		trim(coalesce(nmkategori::text,''))  as nmkategori, 
		trim(coalesce(da::text,'')) as da, 
		trim(coalesce(db::text,'')) as db, 
		trim(coalesce(dc::text,'')) as dc, 
		trim(coalesce(dd::text,'')) as dd, 
		trim(coalesce(de::text,'')) as de, 
		trim(coalesce(df::text,'')) as df, 
		trim(coalesce(da_k::text,'')) as da_k, 
		trim(coalesce(db_k::text,'')) as db_k, 
		trim(coalesce(dc_k::text,'')) as dc_k, 
		trim(coalesce(dd_k::text,'')) as dd_k, 
		trim(coalesce(de_k::text,'')) as de_k, 
		trim(coalesce(df_k::text,'')) as df_k,
		trim(coalesce(to_char(tgl_dok,'dd-mm-yyyy')::text,'')) as tgldok_p
		from 
		(select a.*,b.nmlengkap,c.nmdept,d.nmsubdept,e.nmjabatan,f.nmlengkap as nmatasan1,g.nmlengkap as nmatasan2,to_char(tgl_mulai,'dd-mm-yyyy')||' - '||to_char(tgl_selesai,'dd-mm-yyyy') as daterange1, i.namakotakab,
										case
										when a.status='A' then 'PERLU PERSETUJUAN'
										when a.status='C' then 'DIBATALKAN'
										when a.status='I' then 'INPUT'
										when a.status='D' then 'DIHAPUS'
										when a.status='P' then 'DISETUJUI/PRINT'
										end as status1,h.nmkategori,
										case when a.kdkategori='DA' then 'X' end as da,
										case when a.kdkategori='DB' then 'X' end as db,
										case when a.kdkategori='DC' then 'X' end as dc,
										case when a.kdkategori='DD' then 'X' end as dd,
										case when a.kdkategori='DE' then 'X' end as de,
										case when a.kdkategori='DF' then 'X' end as df,
										case when a.kdkategori='DA' then a.keperluan end as da_k,
										case when a.kdkategori='DB' then a.keperluan end as db_k,
										case when a.kdkategori='DC' then a.keperluan end as dc_k,
										case when a.kdkategori='DD' then a.keperluan end as dd_k,
										case when a.kdkategori='DE' then a.keperluan end as de_k,
										case when a.kdkategori='DF' then a.keperluan end as df_k
										from sc_trx.dinas a
				left outer join sc_mst.karyawan b on a.nik=b.nik								
				left outer join sc_mst.departmen c on b.bag_dept=c.kddept 
				left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept 
				left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.subbag_dept=e.kdsubdept and b.jabatan=e.kdjabatan 
				left outer join sc_mst.karyawan f on b.nik_atasan=f.nik
				left outer join sc_mst.karyawan g on b.nik_atasan2=g.nik
				left outer join sc_mst.kategori h on h.kdkategori=a.kdkategori and h.typekategori='DINAS'
				 left outer join sc_mst.kotakab i on i.kodekotakab=a.tujuan_kota
				) as t1  
				where nodok <> '' 
		".$nodok);
	}
	function q_trx_deklarasi_mst($parameter){
		return $this->db->query("select * from (select * from sc_trx.deklarasi_mst) as x 
		where x.nodok_ref<>'' ".$parameter." order by tgl_dok desc");
	}

	function q_deklarasi_mst($parameter){
		return $this->db->query("select * from (select * from sc_tmp.deklarasi_mst) as x 
		where x.nodok_ref<>'' ".$parameter." order by tgl_dok desc");
	}

	function q_deklarasi_dtl($nodok,$nik){
		return $this->db->query("select 
									trim(coalesce(nik::text,'')) as nik,
									trim(coalesce(nodok::text,'')) as nodok,
									trim(coalesce(nodok_ref::text,'')) as nodok_ref,
									trim(coalesce(tgl::text,'')) as tgl,
									trim(coalesce(status::text,'')) as status,
									trim(coalesce(km_awal::text,'')) as km_awal,
									trim(coalesce(km_akhir::text,'')) as km_akhir,
									trim(coalesce(bbm_liter::text,'')) as bbm_liter,
									trim(coalesce(bbm_rupiah::text,'')) as bbm_rupiah,
									trim(coalesce(parkir::text,'')) as parkir,
									trim(coalesce(tol::text,'')) as tol,
									trim(coalesce(uangsaku::text,'')) as uangsaku,
									trim(coalesce(laundry::text,'')) as laundry,
									trim(coalesce(transport::text,'')) as transport,
									trim(coalesce(lain::text,'')) as lain,
									trim(coalesce(keterangan::text,'')) as keterangan,
									trim(coalesce(update_date::text,'')) as update_date,
									trim(coalesce(update_by::text,'')) as update_by,
									trim(coalesce(input_date::text,'')) as input_date,
									trim(coalesce(input_by::text,'')) as input_by,
									trim(coalesce(id::text,'')) as id
									from sc_tmp.deklarasi_dtl where nodok<>''
									".$nodok." ".$nik."order by tgl");
	}

	function q_trxdeklarasi_dtl($nodok,$nik){
		return $this->db->query("select 
									trim(coalesce(nik::text,'')) as nik,
									trim(coalesce(nodok::text,'')) as nodok,
									trim(coalesce(nodok_ref::text,'')) as nodok_ref,
									trim(coalesce(tgl::text,'')) as tgl,
									trim(coalesce(status::text,'')) as status,
									trim(coalesce(km_awal::text,'')) as km_awal,
									trim(coalesce(km_akhir::text,'')) as km_akhir,
									trim(coalesce(bbm_liter::text,'')) as bbm_liter,
									trim(coalesce(bbm_rupiah::text,'')) as bbm_rupiah,
									trim(coalesce(parkir::text,'')) as parkir,
									trim(coalesce(tol::text,'')) as tol,
									trim(coalesce(uangsaku::text,'')) as uangsaku,
									trim(coalesce(laundry::text,'')) as laundry,
									trim(coalesce(transport::text,'')) as transport,
									trim(coalesce(lain::text,'')) as lain,
									trim(coalesce(keterangan::text,'')) as keterangan,
									trim(coalesce(update_date::text,'')) as update_date,
									trim(coalesce(update_by::text,'')) as update_by,
									trim(coalesce(input_date::text,'')) as input_date,
									trim(coalesce(input_by::text,'')) as input_by,
									trim(coalesce(id::text,'')) as id
									from sc_trx.deklarasi_dtl where nodok<>''
									".$nodok." ".$nik."order by tgl");
	}

	function q_dinas_nik(){
		return $this->db->query("select * from sc_trx.dinas 
		where nodok not in (select nodok_ref from sc_tmp.deklarasi_mst union all select nodok from sc_trx.deklarasi_mst)  order by tgl_mulai");
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

	function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.dinas', $value);
    }
    function q_temporary_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_tmp.dinas', $value);
    }
    function q_transaction_update($value, $where){
        return $this->db
            ->where($where)
            ->update('sc_trx.dinas', $value);
    }
    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.dinas');
    }
    function q_transaction_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_trx.dinas');
    }
    function q_transaction_read_where($clause=null) {
        return $this->db->query($this->q_transaction_txt_where($clause));
    }
    function q_transaction_txt_where($clause=null){
        return sprintf(<<<'SQL'
			SELECT * FROM (
				SELECT
                    COALESCE(TRIM(a.nodok), '') AS id,
                    COALESCE(TRIM(b.nmlengkap), '') AS text,
                    COALESCE(TRIM(a.nik), '') AS nik,
                    COALESCE(TRIM(a.nodok), '') AS nodok,
                    a.tgl_dok AS tgl_dok,
                    COALESCE(TRIM(a.nmatasan), '') AS nmatasan,
                    a.tgl_mulai AS tgl_mulai,
                    a.jam_mulai AS jam_mulai,
                    a.tgl_selesai AS tgl_selesai,
                    a.jam_selesai AS jam_selesai,
                    COALESCE(TRIM(a.status), '') AS status,
                    a.keperluan AS keperluan,
                    COALESCE(a.callplan, false) AS callplan,
                    CASE
                        WHEN a.callplan IS TRUE THEN 'YA'
                        ELSE 'TIDAK'
                        END AS callplan_reformat,
                    COALESCE(TRIM(a.tujuan_kota), '') AS tujuan_kota,
                    COALESCE(TRIM(g.destination_text), c.namakotakab) AS tujuan_kota_text,
                    CONCAT(TO_CHAR(a.tgl_mulai, 'dd-mm-yyyy'), ', ', TO_CHAR(a.tgl_selesai, 'dd-mm-yyyy')) AS dutieperiod,
                    a.input_date AS input_date,
                    COALESCE(TRIM(a.input_by), '') AS input_by,
                    a.approval_date AS approval_date,
                    COALESCE(TRIM(a.approval_by), '') AS approval_by,
                    a.delete_date AS delete_date,
                    COALESCE(TRIM(a.delete_by), '') AS delete_by,
                    COALESCE(TRIM(a.update_by), '') AS update_by,
                    a.update_date AS update_date,
                    COALESCE(TRIM(a.cancel_by), '') AS cancel_by,
                    a.cancel_date AS cancel_date,
                    COALESCE(TRIM(a.kdkategori), '') AS kdkategori,
                    COALESCE(TRIM(a.transportasi), '') AS transportasi,
                    COALESCE(TRIM(e.uraian), 'Lain - Lain') AS transportasi_text,
                    COALESCE(TRIM(a.tipe_transportasi), '') AS tipe_transportasi,
                    COALESCE(TRIM(d.uraian), 'Lain - Lain') AS tipe_transportasi_text,
                    COALESCE(TRIM(a.jenis_tujuan), '') AS jenis_tujuan,
                    COALESCE(TRIM(f.description), '') AS jenis_tujuan_text,
                    COALESCE(TRIM(a.no_telp), '') AS no_telp
                FROM sc_trx.dinas a
                    LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
                    LEFT OUTER JOIN sc_mst.kotakab c ON a.tujuan_kota = c.kodekotakab
                    LEFT OUTER JOIN sc_mst.trxtype d ON a.tipe_transportasi = d.kdtrx AND d.jenistrx = 'TRANSPTYPE'
                    LEFT OUTER JOIN sc_mst.trxtype e ON a.transportasi = e.kdtrx AND e.jenistrx = 'TRANSP'
                    LEFT OUTER JOIN sc_mst.destination_type f ON a.jenis_tujuan = f.destinationid
                    LEFT OUTER JOIN lateral (
                          select
                              string_agg(aa.namakotakab,', ') AS destination_text
                          from(
                                  select
                                      b.namakotakab
                                  from sc_mst.kotakab b where b.kodekotakab IN (select unnest(string_to_array(a.tujuan_kota,',')))
                        ) aa
                    ) g ON TRUE
                WHERE TRUE
                order by TO_CHAR(tgl_mulai,'yyyymmdd') DESC
			) AS aa WHERE TRUE
			
SQL
            ).$clause;
    }
    function q_temporary_read_where($clause=null) {
        return $this->db->query($this->q_temporary_txt_where($clause));
    }
    function q_temporary_txt_where($clause=null){
        return sprintf(<<<'SQL'
			SELECT * FROM (
				SELECT
                    COALESCE(TRIM(a.nik), '') AS nik,
                    COALESCE(TRIM(a.nodok), '') AS nodok,
                    a.tgl_dok AS tgl_dok,
                    COALESCE(TRIM(a.nmatasan), '') AS nmatasan,
                    a.tgl_mulai AS tgl_mulai,
                    a.jam_mulai AS jam_mulai,
                    a.tgl_selesai AS tgl_selesai,
                    a.jam_selesai AS jam_selesai,
                    COALESCE(TRIM(a.status), '') AS status,
                    a.keperluan AS keperluan,
                    a.callplan AS callplan,
                    CASE
                        WHEN a.callplan IS TRUE THEN 'YA'
                        ELSE 'TIDAK'
                    END AS callplan_reformat,
                    COALESCE(TRIM(a.tujuan_kota), '') AS tujuan_kota,
                    a.input_date AS input_date,
                    COALESCE(TRIM(a.input_by), '') AS input_by,
                    a.approval_date AS approval_date,
                    COALESCE(TRIM(a.approval_by), '') AS approval_by,
                    a.delete_date AS delete_date,
                    COALESCE(TRIM(a.delete_by), '') AS delete_by,
                    COALESCE(TRIM(a.update_by), '') AS update_by,
                    a.update_date AS update_date,
                    COALESCE(TRIM(a.cancel_by), '') AS cancel_by,
                    a.cancel_date AS cancel_date,
                    COALESCE(TRIM(a.kdkategori), '') AS kdkategori,
                    COALESCE(TRIM(a.transportasi), '') AS transportasi,
                    COALESCE(TRIM(a.tipe_transportasi), '') AS tipe_transportasi,
                    COALESCE(TRIM(a.jenis_tujuan), '') AS jenis_tujuan,
                    COALESCE(TRIM(a.no_telp), '') AS no_telp
				FROM sc_tmp.dinas a WHERE TRUE
			) AS aa WHERE TRUE
SQL
            ).$clause;
    }

    function history_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_his.dinas')
                ->num_rows() > 0;
    }
}
