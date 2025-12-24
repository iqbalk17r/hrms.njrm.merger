-- DROP FUNCTION sc_trx.pr_hitung_gajipengiriman();

CREATE OR REPLACE FUNCTION sc_trx.pr_hitung_gajipengiriman()
 RETURNS void
 LANGUAGE plpgsql
AS $function$
BEGIN

    DELETE FROM sc_trx.gajipengiriman;

    INSERT INTO sc_trx.gajipengiriman (
        nik, tanggal, kdcabang, kdjabatan, armada, upah_harian, rit1, rit2, jml_toko, jml_jarak1, jml_jarak2, uang_makan
    ) 
SELECT 
    a.nik, a.tanggal, a.kdcabang, a.kdjabatan, a.armada, 
    b.upah_harian,
    CASE WHEN a.rittage <> 1 THEN b.rit1 ELSE b.rit1 END AS rit1,
    CASE WHEN a.rittage = 2 THEN b.rit2 ELSE 0 END AS rit2,
    CASE WHEN a.jml_toko > 5 THEN b.jml_toko ELSE 0 END AS jml_toko,
    CASE 
        WHEN a.jml_jarak > 60 AND a.jml_jarak <= 100 THEN b.jml_jarak1 
        WHEN a.jml_jarak > 100 THEN 0 
        ELSE 0 
    END AS jml_jarak1,
    CASE 
        WHEN a.jml_jarak > 60 AND a.jml_jarak <= 100 THEN 0 
        WHEN a.jml_jarak > 100 THEN b.jml_jarak2 
        ELSE 0 
    END AS jml_jarak2,
    COALESCE(um.nominal, 0) AS uang_makan
FROM (
    SELECT 
        a.user_id AS nik, 
        a.tanggal, 
        b.kdcabang, 
        CASE 
            WHEN c.nmjabatan = 'DRIVER' THEN 'DR' 
            WHEN c.nmjabatan = 'HELPER' THEN 'HK' 
            ELSE 'HG' 
        END AS kdjabatan, 
        a.fleet_type AS armada, 
        a.rittage, 
        a.customer_count AS jml_toko, 
        a.jarak_cust_terjauh AS jml_jarak
    FROM SC_TRX.pengiriman_mst a
    LEFT JOIN sc_mst.karyawan b ON a.user_id = b.nik 
    LEFT JOIN sc_mst.jabatan c ON b.bag_dept = c.kddept 
        AND b.subbag_dept = c.kdsubdept 
        AND b.jabatan = c.kdjabatan
   --query utama select pengiriman dari erpro     
    union all 
    --query koreksi pengiriman 
    select kp.user_id,
    kp.tanggal,
    d.kdcabang, 
        CASE 
            WHEN e.nmjabatan = 'DRIVER' THEN 'DR' 
            WHEN e.nmjabatan = 'HELPER' THEN 'HK' 
            ELSE 'HG' 
        END AS kdjabatan, 
        kp.fleet_type AS armada, 
        kp.rittage, 
        kp.customer_count AS jml_toko, 
        kp.jarak_cust_terjauh AS jml_jarak
    FROM SC_TRX.koreksi_pengirimanmst kp 
    LEFT JOIN sc_mst.karyawan d ON kp.user_id = d.nik 
    LEFT JOIN sc_mst.jabatan e ON d.bag_dept = e.kddept 
        AND d.subbag_dept = e.kdsubdept 
        AND d.jabatan = e.kdjabatan
) AS a 
LEFT JOIN sc_mst.gajipengiriman b 
    ON a.kdcabang = b.kdcabang 
    AND a.armada = b.armada 
    AND a.kdjabatan = b.kdjabatan
LEFT JOIN sc_trx.uangmakan um 
    ON a.nik = um.nik 
    AND a.tanggal = um.tgl
ORDER BY a.nik, a.tanggal;
END;
$function$
;
