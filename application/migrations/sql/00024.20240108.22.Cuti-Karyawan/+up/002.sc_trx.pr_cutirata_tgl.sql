CREATE OR REPLACE FUNCTION sc_trx.pr_cutirata_tgl(vr_date date)
    RETURNS SETOF void
    LANGUAGE plpgsql
AS $function$

DECLARE
    -- Author By FIKY : 08/04/2016
    -- Update By ARBI : 11/01/2022
    -- Hak Cuti Karyawan P0 Dihilangkan
    -- Update By RKM : 09/01/2024 => PENYESUAIAN CUTI ULANG TAHUN
    vr_ceknik CHAR(12);
    vr_cekpkblc INTEGER;
    vr_check_adjustment INTEGER;
    vr_adjusment_in INTEGER;
    vr_cekpklalu INTEGER;
    vr_cutilalu2month CHAR(12);
    vr_sisarate NUMERIC;
    vr_hangus NUMERIC;
BEGIN
    -- Cek Cuti Rata Ulang Tahun Karyawan Hingga -5 Hari Dari Hari H Ulang Tahun Antisipasi Kabisat
    FOR vr_ceknik in
        SELECT TRIM(nik)
        FROM sc_mst.karyawan
        WHERE (
                    tglmasukkerja <= TO_CHAR(vr_date::DATE - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                    tglmasukkerja <=
                    TO_CHAR((vr_date::DATE + INTERVAL '1 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                    tglmasukkerja <=
                    TO_CHAR((vr_date::DATE + INTERVAL '2 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                    tglmasukkerja <=
                    TO_CHAR((vr_date::DATE + INTERVAL '3 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                    tglmasukkerja <= TO_CHAR((vr_date::DATE + INTERVAL '4 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE
            ) AND TO_CHAR(tglmasukkerja, 'MM-DD') BETWEEN TO_CHAR(vr_date::DATE - INTERVAL '5 DAYS', 'MM-DD') AND TO_CHAR(vr_date::DATE, 'MM-DD')
          AND COALESCE(UPPER(statuskepegawaian), '') != 'KO' AND COALESCE(UPPER(grouppenggajian), '') != 'P0'
        ORDER BY tglmasukkerja DESC
        LOOP
            vr_hangus := COUNT(*) FROM sc_trx.cuti_blc WHERE status = 'HANGUS' AND TO_CHAR(tanggal, 'YYYY') = TO_CHAR(vr_date, 'YYYY') AND nik = vr_ceknik;
            vr_cekpkblc := COUNT(*) FROM sc_trx.cuti_blc WHERE nik = vr_ceknik AND status = 'Cuti ' || TO_CHAR(vr_date, 'YYYY') AND doctype = 'IN';
            vr_check_adjustment := COUNT(*) FROM sc_trx.cuti_blc WHERE nik = vr_ceknik AND no_dokumen = 'ADJ'|| TO_CHAR(vr_date, 'YYYY') AND doctype = 'IN';
--             raise notice '%',vr_cekpkblc;
            IF (vr_check_adjustment > 0) THEN
                vr_adjusment_in = in_cuti FROM sc_trx.cuti_blc WHERE nik = vr_ceknik AND no_dokumen = 'ADJ'|| TO_CHAR(vr_date, 'YYYY') AND doctype = 'IN';
                /*INSERT INTO sc_trx.cuti_blc
                SELECT
                    vr_ceknik AS nik,
                    TO_CHAR(vr_date, 'YYYY-MM-DD 00:03:03')::TIMESTAMP AS tanggal,
                    'CTUL' || TO_CHAR(vr_date, 'YYYY') AS no_dokumen,
                    0 AS in_cuti,
                    vr_adjusment_in AS out_cuti,
                    (select sisacuti from sc_mst.karyawan where nik = vr_ceknik) - vr_adjusment_in AS sisacuti,
                    'OUT' AS doctype,
                    'HANGUS ADJ ' || TO_CHAR(vr_date, 'YYYY') AS status
                FROM sc_mst.karyawan
                WHERE nik = vr_ceknik;*/
            end if;
            IF(vr_cekpkblc = 0) THEN
                -- Hapus Cuti Kemudian Tambah
                PERFORM sc_trx.pr_hanguscuti_nik_manual(vr_ceknik, vr_date);
                -- Penambahan Cuti Ulang Tahun Normal
                INSERT INTO sc_trx.cuti_blc
                SELECT
                    vr_ceknik AS nik,
                    TO_CHAR(vr_date, 'YYYY-MM-DD 00:06:06')::TIMESTAMP AS tanggal,
                    'CTUL' || TO_CHAR(vr_date, 'YYYY') AS no_dokumen,
                    12 AS in_cuti,
                    0 AS out_cuti,
                    0 AS sisacuti,
                    'IN' AS doctype,
                    'Cuti ' || TO_CHAR(vr_date, 'YYYY') AS status
                FROM sc_mst.karyawan
                WHERE nik = vr_ceknik;
            END IF;
            RETURN NEXT vr_ceknik;
        END LOOP;
    RAISE NOTICE '%', vr_ceknik;
    RETURN;
END;
$function$