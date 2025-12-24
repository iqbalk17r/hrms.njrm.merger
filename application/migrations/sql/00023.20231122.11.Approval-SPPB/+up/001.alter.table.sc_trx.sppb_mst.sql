DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'sppb_mst' AND column_name = 'whatsappsent' ) THEN
            ALTER TABLE sc_trx.sppb_mst ADD whatsappsent bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'sppb_mst' AND column_name = 'whatsappaccept' ) THEN
            ALTER TABLE sc_trx.sppb_mst ADD whatsappaccept bool NULL DEFAULT false;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'sppb_mst' AND column_name = 'whatsappreject' ) THEN
            ALTER TABLE sc_trx.sppb_mst ADD whatsappreject bool NULL DEFAULT false;
        END IF;
    END
$$;