drop table if exists sc_trx.meal_allowance;
create table if not exists sc_trx.meal_allowance
(
    branch            char(6),
    nik               char(12) not null,
    tgl               date     not null,
    checkin           time,
    checkout          time,
    nominal           numeric,
    keterangan        text,
    tgl_dok           date,
    dok_ref           char(25),
    rencanacallplan   integer,
    realisasicallplan integer,
    bbm               numeric,
    sewa_kendaraan    numeric,
    primary key (nik, tgl)
);

DO
$$
    BEGIN
        IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'meal_allowance' ) THEN
            INSERT INTO sc_trx.meal_allowance
                (branch, nik, tgl, checkin, checkout, nominal, keterangan, tgl_dok, dok_ref, rencanacallplan, realisasicallplan, bbm, sewa_kendaraan)
            SELECT * FROM sc_trx.uangmakan
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
        END IF;
    END
$$;


CREATE OR REPLACE FUNCTION "sc_trx"."pr_meal_allowance"()
    RETURNS "pg_catalog"."trigger" AS $BODY$
DECLARE
    number VARCHAR;
BEGIN
    INSERT INTO sc_trx.meal_allowance
        (branch, nik, tgl, checkin, checkout, nominal, keterangan, tgl_dok, dok_ref, rencanacallplan, realisasicallplan, bbm, sewa_kendaraan)
    SELECT * FROM sc_trx.uangmakan a

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
$BODY$
    LANGUAGE plpgsql VOLATILE
                     COST 100;


DROP TRIGGER IF EXISTS tr_meal_allowance ON sc_trx.uangmakan;
CREATE TRIGGER tr_meal_allowance
    AFTER INSERT OR UPDATE
    ON sc_trx.uangmakan
    FOR EACH ROW
    EXECUTE PROCEDURE sc_trx.pr_meal_allowance();
