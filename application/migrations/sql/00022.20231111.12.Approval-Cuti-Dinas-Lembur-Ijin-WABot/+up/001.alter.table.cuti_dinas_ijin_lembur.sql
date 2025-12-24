DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'whatsappsent' ) THEN
            ALTER TABLE sc_trx.dinas ADD whatsappsent bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'whatsappaccept' ) THEN
            ALTER TABLE sc_trx.dinas ADD whatsappaccept bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'whatsappreject' ) THEN
            ALTER TABLE sc_trx.dinas ADD whatsappreject bool NULL DEFAULT false;
        END IF;

         IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'lembur' AND column_name = 'whatsappsent' ) THEN
            ALTER TABLE sc_trx.lembur ADD whatsappsent bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'lembur' AND column_name = 'whatsappaccept' ) THEN
            ALTER TABLE sc_trx.lembur ADD whatsappaccept bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'lembur' AND column_name = 'whatsappreject' ) THEN
            ALTER TABLE sc_trx.lembur ADD whatsappreject bool NULL DEFAULT false;
        END IF;

        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cuti_karyawan' AND column_name = 'whatsappsent' ) THEN
            ALTER TABLE sc_trx.cuti_karyawan ADD whatsappsent bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cuti_karyawan' AND column_name = 'whatsappaccept' ) THEN
            ALTER TABLE sc_trx.cuti_karyawan ADD whatsappaccept bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'cuti_karyawan' AND column_name = 'whatsappreject' ) THEN
            ALTER TABLE sc_trx.cuti_karyawan ADD whatsappreject bool NULL DEFAULT false;
        END IF;

         IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'ijin_karyawan' AND column_name = 'whatsappsent' ) THEN
            ALTER TABLE sc_trx.ijin_karyawan ADD whatsappsent bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'ijin_karyawan' AND column_name = 'whatsappaccept' ) THEN
            ALTER TABLE sc_trx.ijin_karyawan ADD whatsappaccept bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'ijin_karyawan' AND column_name = 'whatsappreject' ) THEN
            ALTER TABLE sc_trx.ijin_karyawan ADD whatsappreject bool NULL DEFAULT false;
        END IF;
    END
$$;