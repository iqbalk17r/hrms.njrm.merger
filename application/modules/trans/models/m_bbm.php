<?php
class M_bbm extends CI_Model{

    function q_bbm_regu($kdcabang, $awal, $akhir, $callplan, $borong) {
        return $this->db->query("
            SELECT ROW_NUMBER() OVER () AS no, a.nik, a.tgl, CASE WHEN GROUPING(b.nmlengkap) = 0 THEN b.nmlengkap ELSE 'GRAND TOTAL UANG BBM' END AS nmlengkap, 
            b.callplan, c.nmdept, e.nmjabatan, TO_CHAR(a.tgl, 'TMDAY, DD-MM-YYYY') AS tglhari, a.checkin, a.checkout, 
            CASE 
                WHEN GROUPING(b.nmlengkap) = 0 AND GROUPING(keterangan) = 0 AND (a.checkin IS NOT NULL OR a.checkout IS NOT NULL)
                    THEN CONCAT(LPAD(a.checkin::TEXT, 8), ' | ', a.checkout::TEXT)
            END AS checktime, a.rencanacallplan, a.realisasicallplan,
            CASE 
                WHEN GROUPING(b.nmlengkap) = 0 AND GROUPING(keterangan) = 0 THEN keterangan 
                WHEN GROUPING(b.nmlengkap) = 0 AND GROUPING(keterangan) = 1 THEN 'TOTAL' 
            END AS keterangan, COALESCE(SUM(a.nominal), 0) AS nominalrp, GROUPING(b.nmlengkap) AS group_nmlengkap, GROUPING(keterangan) AS group_keterangan
            FROM sc_trx.bbmtrx a 
            LEFT JOIN sc_mst.karyawan b ON a.nik = b.nik
            LEFT JOIN sc_mst.departmen c ON b.bag_dept = c.kddept 
            LEFT JOIN sc_mst.subdepartmen d ON b.bag_dept = d.kddept AND b.subbag_dept = d.kdsubdept 
            LEFT JOIN sc_mst.jabatan e ON b.bag_dept = e.kddept AND b.jabatan = e.kdjabatan AND b.subbag_dept = e.kdsubdept 
            WHERE kdcabang = '$kdcabang' AND tgl::DATE BETWEEN '$awal' AND '$akhir' AND b.callplan = '$callplan'
            GROUP BY GROUPING SETS (
                (a.nik, a.tgl, b.nmlengkap, b.callplan, c.nmdept, e.nmjabatan, a.checkin, a.checkout, a.rencanacallplan, a.realisasicallplan, a.keterangan), 
                (a.nik, b.nmlengkap), 
                ()
            )
            ORDER BY b.nmlengkap, tgl
        ");
    }

    function q_kanwil(){
        return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang");
    }

    function q_regu($params = "") {
        return $this->db->query("
            SELECT DISTINCT a.kdregu, nmregu
            FROM sc_mst.regu_opr a
            INNER JOIN sc_mst.regu b ON b.kdregu = a.kdregu
            $params
            ORDER BY nmregu        
        ");
    }

    function q_kanwil_dtl($kdcabang){
        return $this->db->query("select * from sc_mst.kantorwilayah where kdcabang='$kdcabang' order by desc_cabang");
    }

    function q_regu_dtl($kdregu){
        return $this->db->query("select * from sc_mst.regu where kdregu='$kdregu'");
    }

    //list kantor
    function q_kantor(){
        return $this->db->query("select * from sc_mst.kantor");
    }

    function insert_rencana_kunjungan($host, $dbname, $dbuser, $dbpass, $awal, $akhir) {
        $nik = $this->session->userdata('nik');

        $this->db->query("DELETE FROM sc_tmp.scheduletolocation WHERE scheduledate BETWEEN '$awal' AND '$akhir'");
        return $this->db->query("
            INSERT INTO sc_tmp.scheduletolocation
            SELECT *
            FROM dblink (
                'hostaddr=$host dbname=$dbname user=$dbuser password=$dbpass port=5432',
                'SELECT DISTINCT ON (branch, scheduleid, locationid, locationidlocal)
				s.branch, s.userid, u.nip AS nik, s.scheduleid, s.scheduledate, 
                COALESCE(NULLIF(sl.locationid, ''''), c.custcode, '''') AS locationid, 
                COALESCE(NULLIF(sl.locationidlocal, ''''), c.customercodelocal, '''') AS locationidlocal,
                c.custname, c.type AS customertype, ''$nik''::TEXT AS createby, NOW() AS createdate
                FROM sc_trx.schedule s
                INNER JOIN sc_trx.scheduletolocation sl ON sl.scheduleid = s.scheduleid
                LEFT JOIN sc_mst.\"user\" u ON REGEXP_REPLACE(u.userid::TEXT, ''\s'', '''', ''g'') = REGEXP_REPLACE(s.userid::TEXT, ''\s'', '''', ''g'')
                LEFT JOIN sc_mst.customer c ON COALESCE(NULLIF(c.customercodelocal, ''''), c.custcode) = COALESCE(NULLIF(sl.locationidlocal, ''''), sl.locationid)
                WHERE COALESCE(NULLIF(sl.locationidlocal, ''''), sl.locationid) != '''' AND scheduledate BETWEEN ''$awal'' AND ''$akhir''
                ORDER BY branch, scheduleid, locationid, locationidlocal DESC, userid'
            ) AS t1 (
                branch CHARACTER VARYING, userid CHARACTER VARYING, nik CHARACTER(12), scheduleid CHARACTER VARYING, 
                scheduledate DATE, locationid CHARACTER VARYING, locationidlocal CHARACTER VARYING,
                custname CHARACTER VARYING(70), customertype CHARACTER(1),
                createby CHARACTER VARYING, createdate TIMESTAMP WITHOUT TIME ZONE
            );
        ");
    }

    function list_rencana_kunjungan($nik, $tgl) {
        $tgl = $tgl ?: date("Y-m-d");

        return $this->db->query("
            SELECT NULL AS no, locationid, locationidlocal, custname, customertype,
            CASE
                WHEN customertype = 'A' THEN 'KANTOR'
                WHEN customertype = 'U' THEN 'TEMPAT UMUM'
                WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
				WHEN customertype = 'P' THEN 'PROYEK'
				WHEN customertype = 'G' THEN 'GUDANG'
                ELSE 'BELUM TERDEFINISI'
            END AS nmcustomertype
            FROM sc_tmp.scheduletolocation
            WHERE nik = '$nik' AND scheduledate = '$tgl'::DATE
            ORDER BY custname
        ");
    }

    function list_realisasi_kunjungan($nik, $tgl) {
        $tgl = $tgl ?: date("Y-m-d");

        return $this->db->query("
            SELECT a.customeroutletcode, a.customercodelocal, a.custname, a.customertype,
            CASE
                WHEN customertype = 'A' THEN 'KANTOR'
                WHEN customertype = 'U' THEN 'TEMPAT UMUM'
                WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
				WHEN customertype = 'P' THEN 'PROYEK'
				WHEN customertype = 'G' THEN 'GUDANG'
                ELSE 'BELUM TERDEFINISI'
            END AS nmcustomertype, MIN(checktime::TIME) AS checkin, MAX(checktime::TIME) AS checkout
            FROM sc_tmp.checkinout a
            WHERE a.checktime::DATE = '$tgl' AND a.nik = '$nik'
            GROUP BY 1, 2, 3, 4
            ORDER BY 6, 7
        ");
    }

	function cek_realisasi_kunjungan($nik, $tgl) {
        $tgl = $tgl ?: date("Y-m-d");

        return $this->db->query("
		SELECT x.*,
		CASE
			WHEN COALESCE(NULLIF(x.locationid, ''), NULLIF(x.locationidlocal, '')) is null THEN 'X'
			ELSE 'Y'
		END as keterangan
		FROM (
		SELECT a.customeroutletcode, a.customercodelocal, a.custname, a.customertype,
					CASE
						WHEN a.customertype = 'A' THEN 'KANTOR'
						WHEN a.customertype = 'U' THEN 'TEMPAT UMUM'
						WHEN a.customertype = 'C' THEN 'CUSTOMER/TOKO'
						WHEN a.customertype = 'P' THEN 'PROYEK'
						WHEN a.customertype = 'G' THEN 'GUDANG'
						ELSE 'BELUM TERDEFINISI'
					END AS nmcustomertype, MIN(checktime::TIME) AS checkin, MAX(checktime::TIME) AS checkout,
					b.locationid , b.locationidlocal, b.custname
					FROM sc_tmp.checkinout a
					FULL OUTER JOIN (
					SELECT * FROM sc_tmp.scheduletolocation
						where scheduledate = '$tgl' and nik = '$nik'
					) b
					ON COALESCE(NULLIF(b.locationid, ''), NULLIF(b.locationidlocal, '')) = COALESCE(NULLIF(a.customeroutletcode, ''), NULLIF(a.customercodelocal, ''))
					WHERE a.checktime::DATE = '$tgl' AND a.nik = '$nik'
					GROUP BY 1, 2, 3, 4, 8, 9, 10
					ORDER BY 6
		) x
        ");
    }

    function list_realisasi_kunjungan_all($kdcabang, $awal, $akhir) {
        return $this->db->query("
            SELECT ROW_NUMBER() OVER (ORDER BY c.nmlengkap, a.checktime::DATE, MIN(checktime::TIME), MAX(checktime::TIME)) AS no, 
            c.nik, c.nmlengkap, d.nmdept, f.nmjabatan, TO_CHAR(MAX(a.checktime), 'DD-MM-YYYY') AS tgl, a.customeroutletcode, a.customercodelocal, a.custname, a.customertype,
            CASE
                WHEN customertype = 'A' THEN 'KANTOR'
                WHEN customertype = 'U' THEN 'TEMPAT UMUM'
                WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
				WHEN customertype = 'P' THEN 'PROYEK'
				WHEN customertype = 'G' THEN 'GUDANG'
                ELSE 'BELUM TERDEFINISI'
            END AS nmcustomertype, CASE 
                WHEN customertype = 'C' THEN 'V'
				WHEN customertype = 'A' THEN 'V'
				WHEN customertype = 'U' THEN 'V'
				WHEN customertype = 'P' THEN 'V'
				WHEN customertype = 'G' THEN 'V'
                ELSE 'X'
            END AS terhitung, MIN(checktime::TIME) AS checkin, MAX(checktime::TIME) AS checkout, CONCAT(MIN(checktime::TIME), ' | ', MAX(checktime::TIME)) AS checktime
            FROM sc_tmp.checkinout a
            INNER JOIN sc_mst.karyawan c ON c.nik = a.nik AND c.callplan = 't'
            LEFT JOIN sc_mst.departmen d ON d.kddept = c.bag_dept
            LEFT JOIN sc_mst.subdepartmen e ON e.kddept = c.bag_dept AND e.kdsubdept = c.subbag_dept
            LEFT JOIN sc_mst.jabatan f ON f.kddept = c.bag_dept AND f.kdjabatan = c.jabatan AND f.kdsubdept = c.subbag_dept
            WHERE c.kdcabang = '$kdcabang' AND a.checktime::DATE BETWEEN '$awal' AND '$akhir'
            GROUP BY c.nik, d.nmdept, f.nmjabatan, a.checktime::DATE, a.customeroutletcode, a.customercodelocal, a.custname, a.customertype
            ORDER BY c.nmlengkap, a.checktime::DATE, checkin, checkout
        ");
    }
}
