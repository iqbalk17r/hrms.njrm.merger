create OR REPLACE function sc_trx.pr_insert_meal_allowance(start_date date, end_date date) returns character varying
    language plpgsql
as
$$
DECLARE
    record_count INT;
BEGIN
    -- Check if there is data to insert
    SELECT COUNT(*) INTO record_count 
    FROM sc_trx.uangmakan 
    WHERE tgl BETWEEN start_date AND end_date;
    
    IF record_count = 0 THEN
        RAISE NOTICE 'No records found in the date range.';
        RETURN 'NO DATA FOUND';
    END IF;

    -- Insert data with conflict handling
    INSERT INTO sc_trx.meal_allowance
        (branch, nik, tgl, checkin, checkout, nominal, keterangan, tgl_dok, dok_ref, rencanacallplan, realisasicallplan, bbm, sewa_kendaraan)
    SELECT branch, nik, tgl, checkin, checkout, nominal, keterangan, tgl_dok, dok_ref, rencanacallplan, realisasicallplan, bbm, sewa_kendaraan
    FROM sc_trx.uangmakan a
    WHERE a.tgl BETWEEN start_date AND end_date
    ON CONFLICT (nik, tgl)
    DO UPDATE SET
        checkin = EXCLUDED.checkin,
        checkout = EXCLUDED.checkout,
        nominal = EXCLUDED.nominal,
        keterangan = EXCLUDED.keterangan,
        tgl_dok = EXCLUDED.tgl_dok,
        dok_ref = EXCLUDED.dok_ref,
        rencanacallplan = EXCLUDED.rencanacallplan,
        realisasicallplan = EXCLUDED.realisasicallplan,
        bbm = EXCLUDED.bbm,
        sewa_kendaraan = EXCLUDED.sewa_kendaraan;

    RAISE NOTICE 'Inserted or updated % records.', record_count;
    RETURN 'SUKSES';
END;
$$;