CREATE OR REPLACE FUNCTION sc_tmp.pr_hitung_rekap_um(vr_kdcabang CHARACTER, vr_tglawal DATE, vr_tglakhir DATE)
    RETURNS SETOF void
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE
    ROWS 1000
AS $BODY$
DECLARE
    -- Author By FIKY : 02/02/2017
    -- Update By ARBI : 29/10/2021
    -- Generate Uang Makan Sales Berdasarkan Jumlah Callplan, Hanya Berdasarkan Parameter Kolom Callplan Dari Tabel Karyawan
    vr_tglapproval DATE;
    vr_tgl_act DATE;
    vr_tgl_dok DATE;
    vr_nodok_ref CHARACTER(12);
    vr_nominal_um NUMERIC;
    vr_cek_nominal_um NUMERIC;
    vr_nik CHARACTER(12);
BEGIN
    FOR vr_nik IN SELECT TRIM(nik) FROM sc_mst.karyawan WHERE tglkeluarkerja IS NULL AND kdcabang = vr_kdcabang
    LOOP
        vr_nominal_um := CASE
                WHEN a.kdcabang = 'SMGDMK' THEN b.besaran - c.besaran
                ELSE b.besaran
                END AS nominal
            FROM sc_mst.karyawan a
            LEFT OUTER JOIN sc_mst.uangmakan b ON a.lvl_jabatan = b.kdlvl
            LEFT OUTER JOIN sc_mst.kantin c ON a.kdcabang = c.kdcabang
            WHERE a.nik = vr_nik;

        FOR vr_nodok_ref IN SELECT TRIM(dok_ref)
            FROM sc_trx.uangmakan
            WHERE nik = vr_nik AND dok_ref IS NOT NULL AND (LEFT(dok_ref, 2) = 'IK' OR LEFT(dok_ref, 2) = 'PA' OR LEFT(dok_ref,2) = 'DT')
            AND (TO_CHAR(tgl, 'YYYY-MM-DD') BETWEEN TO_CHAR(vr_tglawal - INTERVAL '1 WEEK', 'YYYY-MM-DD') AND TO_CHAR(vr_tglakhir, 'YYYY-MM-DD'))
        LOOP
            SELECT CAST(TO_CHAR(approval_date, 'YYYY-MM-DD') AS DATE) INTO vr_tglapproval FROM sc_trx.ijin_karyawan WHERE nodok = vr_nodok_ref;
            SELECT nominal INTO vr_cek_nominal_um FROM sc_trx.uangmakan WHERE dok_ref = vr_nodok_ref AND nik = vr_nik;

            IF(vr_cek_nominal_um = 0 OR vr_cek_nominal_um IS NULL) THEN
                UPDATE sc_trx.uangmakan SET nominal = vr_nominal_um, keterangan = '+ PERSETUJUAN NO IJIN : ' || vr_nodok_ref where tgl = vr_tglapproval AND nik = vr_nik;
            END IF;

            RETURN NEXT vr_nodok_ref;
        END LOOP;

        RETURN NEXT vr_nik;
    END LOOP;

    UPDATE sc_trx.uangmakan AS a
    SET rencanacallplan = x.rencanacallplan, realisasicallplan = x.realisasicallplan, nominal = x.nominal, keterangan = x.keterangan
    FROM (
    	SELECT a.nik, a.tgl, d.jumlah AS rencanacallplan, e.jumlah AS realisasicallplan,
    	CASE
            WHEN ((a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.tgl_jam_mulai <= f.jam_masuk AND h.tgl_jam_selesai >= jam_pulang)
                OR (d.jumlah > 0 AND e.jumlah >= d.jumlah)) AND a.keterangan NOT SIMILAR TO '(DINAS|CUTI)%' THEN g.nominal
            ELSE NULL
        END AS nominal,
        CASE
            WHEN (a.dok_ref IS NOT NULL AND h.kdijin_absensi = 'IK' AND h.type_ijin = 'DN' AND h.tgl_jam_mulai <= f.jam_masuk AND h.tgl_jam_selesai >= jam_pulang)
                OR (a.dok_ref IS NOT NULL AND h.kdijin_absensi NOT IN ('IK', 'DT', 'PA'))
                OR (a.checkin IS NULL AND a.checkout IS NULL) OR a.keterangan SIMILAR TO '(DINAS|CUTI)%' THEN SPLIT_PART(a.keterangan, ' + ', 1)
            WHEN d.jumlah = 0 THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + TIDAK ADA RENCANA CALLPLAN'
            WHEN e.jumlah >= d.jumlah THEN SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TERPENUHI'
            ELSE SPLIT_PART(a.keterangan, ' + ', 1) || ' + CALLPLAN TIDAK TERPENUHI'
        END AS keterangan
    	FROM sc_trx.uangmakan a
    	INNER JOIN sc_mst.karyawan b ON b.nik = a.nik AND b.tglkeluarkerja IS NULL AND b.callplan = 't' AND b.kdcabang = vr_kdcabang
    	INNER JOIN sc_mst.regu_opr c ON c.nik = b.nik
    	LEFT JOIN LATERAL (
    		SELECT COUNT(x.custcode) AS jumlah
    		FROM (
    			SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
    			FROM sc_tmp.scheduletolocation xa
    			WHERE xa.nik = a.nik AND xa.scheduledate = a.tgl
    			GROUP BY 1
    		) x
    	) d ON TRUE
    	LEFT JOIN LATERAL (
    		SELECT COUNT(x.custcode) AS jumlah
    		FROM (
    			SELECT COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode
    			FROM sc_tmp.checkinout xa
    			INNER JOIN sc_mst.user xb ON xb.username = xa.userid AND xb.nik = a.nik
    			WHERE xa.checktime::DATE = a.tgl AND xa.customertype = 'C'
    			GROUP BY 1
    		) x
    	) e ON TRUE
    	LEFT JOIN LATERAL (
    		SELECT jam_masuk, jam_pulang
    		FROM sc_mst.jam_kerja
    		WHERE kdjam_kerja = CASE
    			WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'SL' THEN 'SL1'
    			WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'SL' THEN 'SL2'
    			WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'SL' THEN 'SL3'
    			WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) AND c.kdregu = 'NC' THEN 'NC1'
                WHEN EXTRACT(DOW FROM a.tgl) IN (5) AND c.kdregu = 'NC' THEN 'NC2'
                WHEN EXTRACT(DOW FROM a.tgl) IN (6) AND c.kdregu = 'NC' THEN 'NC3'
    			WHEN EXTRACT(DOW FROM a.tgl) IN (1, 2, 3, 4) THEN 'NSA'
    			WHEN EXTRACT(DOW FROM a.tgl) IN (5) THEN 'NSB'
    			WHEN EXTRACT(DOW FROM a.tgl) IN (6) THEN 'NSC'
    		END
    	) f ON TRUE
    	LEFT JOIN LATERAL (
    		SELECT CASE
    			WHEN b.kdcabang = 'SMGDMK' THEN xa.besaran - xb.besaran
    			ELSE xa.besaran
    		END AS nominal
    		FROM sc_mst.uangmakan xa
    		LEFT JOIN sc_mst.kantin xb ON xb.kdcabang = b.kdcabang
    		WHERE xa.kdlvl = b.lvl_jabatan
    	) g ON TRUE
    	LEFT JOIN sc_trx.ijin_karyawan h ON h.nodok = a.dok_ref AND h.status = 'P'
    	WHERE a.tgl::DATE BETWEEN vr_tglawal AND vr_tglakhir
    	ORDER BY b.kdcabang, b.nmlengkap, a.tgl
    ) AS x
    WHERE a.nik = x.nik AND a.tgl = x.tgl;
END;
$BODY$;

ALTER FUNCTION sc_tmp.pr_hitung_rekap_um(CHARACTER, DATE, DATE)
    OWNER TO postgres;
