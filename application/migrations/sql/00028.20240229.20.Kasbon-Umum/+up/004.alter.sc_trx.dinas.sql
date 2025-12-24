DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'retry' ) THEN
            ALTER TABLE sc_trx.dinas ADD COLUMN retry INTEGER DEFAULT 0;
            COMMENT ON COLUMN sc_trx.dinas.retry IS 'reference whaatsapp retry count to be sent';
        END IF;
    END
$$;