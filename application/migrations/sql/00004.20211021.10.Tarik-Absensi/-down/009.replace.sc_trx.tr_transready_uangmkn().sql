CREATE OR REPLACE FUNCTION sc_trx.tr_transready_uangmkn()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
DECLARE
    vr_um_max01 TIME WITHOUT TIME ZONE;
    vr_um_max02 TIME WITHOUT TIME ZONE;
    vr_um_min01 TIME WITHOUT TIME ZONE;
    vr_um_min02 TIME WITHOUT TIME ZONE;
    vr_date_now DATE;
    vr_dok_lembur CHARACTER(25);
BEGIN
	DELETE FROM sc_trx.uangmakan WHERE nik = new.nik AND tgl = new.tgl;
	vr_date_now := CAST(TO_CHAR(NOW(), 'YYYY-MM-DD') AS DATE);

	IF(TRIM(new.kdregu) = 'NC') THEN
		vr_um_max01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX01' AND group_option = 'NC'; --'13:00:00'
		vr_um_max02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX02' AND group_option = 'NC'; --'11:00:00'
		vr_um_min01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN01' AND group_option = 'NC'; --'07:55:00'
		vr_um_min02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN02' AND group_option = 'NC'; --'07:55:00'
	ELSE
		vr_um_max01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX01' AND group_option = 'DEFAULT'; --'13:00:00'
		vr_um_max02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX02' AND group_option = 'DEFAULT'; --'11:00:00'
		vr_um_min01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN01' AND group_option = 'DEFAULT'; --'07:55:00'
		vr_um_min02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN02' AND group_option = 'DEFAULT'; --'07:55:00'
	END IF;

	INSERT INTO sc_trx.uangmakan (
	    SELECT 'SBYNSA', ta.nik, ta.tgl, ta.checkin, ta.checkout,
            CASE
                WHEN kdcabang <> 'SMGDMK' AND checkin IS NULL AND td.nodok IS NULL AND tc.nodok IS NULL AND tf.tgl_libur IS NULL AND checkout IS NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NULL AND LEFT(td.nodok, 2) = 'DL' THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NULL AND LEFT(td.nodok, 2) <> 'DL' THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NOT NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NOT NULL THEN besaran + besaran
                WHEN kdcabang <> 'SMGDMK' AND (checkin IS NOT NULL OR checkout IS NOT NULL) AND lvl_jabatan = 'B' THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin > vr_um_min01 AND vr_um_max01 < checkout AND tc.kdijin_absensi IS NULL AND te.nodok IS NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin > vr_um_min01 AND vr_um_max01 < checkout AND tc.kdijin_absensi IS NULL AND te.nodok IS NOT NULL THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin > vr_um_min01 AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL AND te.nodok IS NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin > vr_um_min01 AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL AND te.nodok IS NOT NULL THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin IS NULL AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND checkout IS NULL AND tc.kdijin_absensi IS NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND checkout < vr_um_max01 AND tc.kdijin_absensi IS NULL THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND td.nodok IS NULL THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND LEFT(td.nodok, 2) = 'DL' THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' AND LEFT(td.nodok, 2) = 'DL' THEN NULL
                WHEN kdcabang <> 'SMGDMK' AND checkin < vr_um_min01 AND (checkout IS NULL OR checkout < jam_pulang) AND tc.kdijin_absensi = 'IK' AND CAST(TO_CHAR(tc.approval_date, 'YYYY-MM-DD') AS DATE) <= vr_date_now THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin >= jam_masuk AND checkout > jam_pulang AND tc.kdijin_absensi IS NOT NULL THEN besaran
                WHEN kdcabang <> 'SMGDMK' AND checkin IS NULL AND checkout IS NULL AND tc.kdijin_absensi IS NOT NULL THEN besaran
                --WHEN kdcabang <> 'SMGDMK' AND CAST(TO_CHAR(tc.approval_date, 'YYYY-MM-DD') AS DATE) = ta.tgl THEN BESARAN
                /*SEMARANG DEMAK*/
                WHEN kdcabang = 'SMGDMK' AND checkin IS NULL AND checkout IS NULL AND td.nodok IS NULL AND tc.nodok IS NULL THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NULL AND LEFT(td.nodok, 2) = 'DL' THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NULL AND LEFT(td.nodok, 2) <> 'DL' THEN besaran - kantin
                WHEN kdcabang = 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NOT NULL THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin <= vr_um_min01 AND checkout > jam_pulang AND te.nodok IS NOT NULL THEN (besaran - kantin) + besaran
                WHEN kdcabang = 'SMGDMK' AND (checkin IS NOT NULL OR checkout IS NOT NULL) AND lvl_jabatan = 'B' THEN besaran - kantin
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' THEN besaran - kantin
                WHEN kdcabang = 'SMGDMK' AND checkin > vr_um_min01 AND vr_um_max01 < checkout AND tc.kdijin_absensi IS NULL AND te.nodok IS NULL THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin > vr_um_min01 AND vr_um_max01 < checkout AND tc.kdijin_absensi IS NULL AND te.nodok IS NOT NULL THEN besaran - kantin
                WHEN kdcabang = 'SMGDMK' AND checkin > vr_um_min01 AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL AND te.nodok IS NULL  THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin > vr_um_min01 AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL AND te.nodok IS NOT NULL THEN besaran - kantin
                WHEN kdcabang = 'SMGDMK' AND checkin IS NULL AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND checkout IS NULL  AND tc.kdijin_absensi IS NULL THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND checkout < vr_um_max01 AND tc.kdijin_absensi IS NULL THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND td.nodok IS NULL AND tc.kdijin_absensi IS NULL THEN besaran - kantin
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max01 AND TO_CHAR(tgl, 'DY') <> 'SAT' AND LEFT(td.nodok, 2) = 'DL' THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND checkout >= vr_um_max02 AND TO_CHAR(tgl, 'DY') = 'SAT' AND LEFT(td.nodok, 2) = 'DL' THEN NULL
                WHEN kdcabang = 'SMGDMK' AND checkin < vr_um_min01 AND tc.kdijin_absensi='IK' AND CAST(TO_CHAR(tc.approval_date,'YYYY-MM-DD')AS date)<=ta.tgl THEN besaran
                WHEN kdcabang = 'SMGDMK' AND checkin IS NULL AND checkout IS NULL AND tc.kdijin_absensi = 'IK' AND CAST(TO_CHAR(tc.approval_date, 'YYYY-MM-DD') AS DATE) <= vr_date_now THEN besaran
                WHEN kdcabang = 'SMGDMK' AND CAST(TO_CHAR(tc.approval_date, 'YYYY-MM-DD')AS date) = ta.tgl  THEN besaran - kantin
                --ELSE besaran
            END AS nominal,
	        CASE
	            WHEN checkin IS NULL AND checkout IS NULL AND td.nodok IS NULL AND tc.nodok IS NULL AND tf.tgl_libur IS NULL AND th.nodok IS NULL THEN 'TIDAK MASUK KANTOR'
                WHEN checkin IS NULL AND checkout IS NULL AND td.nodok IS NULL  AND tf.tgl_libur IS NOT NULL AND th.nodok IS NULL THEN tf.ket_libur
                WHEN td.nodok IS NOT NULL THEN 'DINAS DENGAN NO DINAS :' || td.nodok || '|| APP TGL: ' || TO_CHAR(td.approval_date, 'YYYY-MM-DD')
                WHEN th.nodok IS NOT NULL THEN 'CUTI DENGAN NO CUTI :' || th.nodok || '|| APP TGL: ' || TO_CHAR(th.approval_date, 'YYYY-MM-DD')
                WHEN checkin < jam_masuk AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NULL THEN 'TEPAT WAKTU'
                WHEN checkin < jam_masuk AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NOT NULL THEN tf.ket_libur
                WHEN checkin < jam_masuk AND checkout > jam_pulang AND te.nodok IS NOT NULL THEN 'TEPAT WAKTU + Lembur :' ||te.nodok
                WHEN checkin > jam_masuk AND checkout < jam_pulang THEN 'TELAT MASUK/PULANG AWAL'
                WHEN checkin >= jam_masuk AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL AND te.nodok IS NULL AND tg.kdijin_absensi IS NULL  THEN 'TELAT MASUK'
                WHEN checkin >= jam_masuk AND checkout > jam_pulang AND tg.kdijin_absensi IS NOT NULL AND te.nodok IS NULL THEN 'IJIN PRIBADI NO :' ||tg.nodok
                WHEN checkin >= jam_masuk AND checkout > jam_pulang AND tc.kdijin_absensi IS NULL AND te.nodok IS NOT NULL THEN 'TELAT MASUK + Lembur :' ||te.nodok
                WHEN checkin >= jam_masuk AND checkout > jam_pulang AND tc.kdijin_absensi IS NOT NULL THEN 'IJIN DGN NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                WHEN checkin IS NULL AND checkout IS NULL AND tc.kdijin_absensi IS NOT NULL THEN 'IJIN DGN NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                WHEN checkin IS NULL AND checkout > jam_pulang THEN 'TIDAK CEKLOG MASUK'
                WHEN checkin < jam_masuk AND checkout IS NULL AND tc.kdijin_absensi IS NULL THEN 'TIDAK CEKLOG PULANG'
				WHEN checkin < jam_masuk AND checkout < jam_pulang AND tc.kdijin_absensi IS NULL AND tg.kdijin_absensi IS NULL THEN 'PULANG AWAL'
                WHEN checkin < jam_masuk AND checkout < jam_pulang AND tg.kdijin_absensi IS NOT NULL THEN 'IJIN PRIBADI NO :' || tg.nodok
                WHEN checkin < vr_um_min01  AND (checkout IS NULL OR checkout < jam_pulang)  AND tc.kdijin_absensi = 'IK' THEN 'IJIN DGN NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
	        END AS keterangan, vr_date_now AS tgl_dok, CASE WHEN tc.nodok IS NOT NULL THEN tc.nodok ELSE td.nodok END AS nodok
        FROM (
            SELECT 'SBYNSA' AS branch, a.nik, b.nmlengkap, c.kddept, c.nmdept, e.kdjabatan, e.nmjabatan, a.tgl,
                CASE
                    WHEN a.jam_masuk_absen = a.jam_pulang_absen AND a.jam_masuk_absen > vr_um_max01 THEN NULL
                    ELSE a.jam_masuk_absen END AS checkin,
                CASE
                    WHEN a.jam_masuk_absen = a.jam_pulang_absen AND a.jam_pulang_absen <= vr_um_max01 THEN NULL
                    ELSE a.jam_pulang_absen END AS checkout, NULL AS nominal, '' AS keterangan, b.kdcabang, b.lvl_jabatan, a.jam_masuk, a.jam_pulang, f.besaran AS kantin
            FROM sc_trx.transready a
            LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
            LEFT OUTER JOIN sc_mst.departmen c ON b.bag_dept = c.kddept
            LEFT OUTER JOIN sc_mst.subdepartmen d ON b.subbag_dept = d.kdsubdept AND b.bag_dept = d.kddept
            LEFT OUTER JOIN sc_mst.jabatan e ON b.jabatan = e.kdjabatan AND b.subbag_dept = e.kdsubdept AND b.bag_dept = e.kddept
            LEFT OUTER JOIN sc_mst.kantin f ON b.kdcabang = f.kdcabang
        ) AS ta
        LEFT OUTER JOIN sc_mst.uangmakan tb ON tb.kdlvl = ta.lvl_jabatan
        LEFT OUTER JOIN sc_trx.ijin_karyawan tc ON tc.nik = ta.nik AND tc.tgl_kerja = ta.tgl AND tc.status = 'P' AND tc.type_ijin = 'DN' --AND TO_CHAR(tc.approval_date, 'YYYY-MM-DD') <= TO_CHAR(NOW(), 'YYYY-MM-DD')
        LEFT OUTER JOIN sc_trx.dinas td ON td.nik = ta.nik AND (ta.tgl BETWEEN td.tgl_mulai AND td.tgl_selesai) AND td.status = 'P'
        LEFT OUTER JOIN sc_trx.lembur te ON te.nik = ta.nik AND te.tgl_kerja = ta.tgl AND TO_CHAR(ta.checkout, 'HH24:MI:SS') >= '18:00:00' AND (te.status = 'P' OR te.status = 'F') AND te.kdlembur = 'BIASA' AND TO_CHAR(te.tgl_jam_mulai, 'HH24:MI:SS') >= '13:00:00' /*LEMBUR BIASA*/
        LEFT OUTER JOIN sc_mst.libur tf ON tf.tgl_libur = ta.tgl
        LEFT OUTER JOIN sc_trx.ijin_karyawan tg ON tg.nik = ta.nik AND tg.tgl_kerja = ta.tgl AND tg.status = 'P' AND tg.type_ijin = 'PB'
        LEFT OUTER JOIN sc_trx.cuti_karyawan th ON th.nik = ta.nik AND (ta.tgl BETWEEN th.tgl_mulai AND th.tgl_selesai) AND th.status = 'P'
        WHERE ta.lvl_jabatan <> 'A' AND ta.nik = new.nik AND ta.tgl = new.tgl
        GROUP BY ta.nik, ta.nmlengkap, ta.tgl, ta.checkin, ta.checkout, ta.kdcabang, ta.jam_masuk, ta.jam_pulang, tb.besaran, ta.lvl_jabatan, ta.kantin, tc.kdijin_absensi,
            tg.kdijin_absensi, tg.nodok, tc.tgl_kerja, td.nodok, td.approval_date, tc.nodok, tc.approval_date, te.nodok, tf.tgl_libur, tf.ket_libur, th.nodok, th.approval_date
        ORDER BY nmlengkap
	);

    RETURN new;
END;
$BODY$;

ALTER FUNCTION sc_trx.tr_transready_uangmkn()
    OWNER TO postgres;
