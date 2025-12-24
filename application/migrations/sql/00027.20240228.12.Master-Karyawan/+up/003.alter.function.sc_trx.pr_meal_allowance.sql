DROP trigger if EXISTS tr_meal_allowance ON sc_trx.uangmakan;
CREATE OR REPLACE FUNCTION sc_trx.pr_insert_meal_allowance(start_date DATE, end_date DATE)
 RETURNS VARCHAR
 LANGUAGE plpgsql
AS $function$
DECLARE 
	/*UPDATE BY RKM::20240228*/
BEGIN		
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
    RETURN 'SUKSES';	
END;
$function$