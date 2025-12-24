DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'status_kepegawaian' AND column_name = 'status') THEN
            ALTER TABLE IF EXISTS sc_tmp.status_kepegawaian ADD COLUMN status varchar;
        END IF;
    END
$$;
