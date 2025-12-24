CREATE OR REPLACE FUNCTION sc_trx.pr_meal_allowance()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE
    number VARCHAR;
BEGIN
    INSERT INTO sc_trx.meal_allowance
        (branch, nik, tgl, checkin, checkout, nominal, keterangan, tgl_dok, dok_ref, rencanacallplan, realisasicallplan, bbm, sewa_kendaraan)
    SELECT * FROM sc_trx.uangmakan a
	WHERE a.tgl >= current_date - interval '7 days'
    ON CONFLICT (nik,tgl)
    DO UPDATE SET
        (checkin,
        checkout,
        nominal,
        keterangan,
        tgl_dok,
        dok_ref,
        rencanacallplan,
        realisasicallplan,
        bbm,
        sewa_kendaraan) =
        (EXCLUDED.checkin, EXCLUDED.checkout, EXCLUDED.nominal, EXCLUDED.keterangan, EXCLUDED.tgl_dok, EXCLUDED.dok_ref, EXCLUDED.rencanacallplan,EXCLUDED.realisasicallplan,EXCLUDED.bbm,EXCLUDED.sewa_kendaraan);
    RETURN NEW;
END;
$function$
;