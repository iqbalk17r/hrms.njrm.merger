
CREATE OR REPLACE FUNCTION sc_trx.generate_unique_token(
    p_length     INTEGER
)
    RETURNS TEXT AS $$
DECLARE
    charset       CONSTANT TEXT := 'abcdefghijklmnopqrstuvwxyz0123456789';
    result        TEXT;
    exists_flag   BOOLEAN;
    final_length  INTEGER := COALESCE(NULLIF(p_length, 0), 8);  -- default to 8 if NULL or 0
BEGIN
    LOOP
        -- Generate random lowercase alphanumeric string
        result := (
            SELECT string_agg(
                           substr(charset, floor(random() * length(charset) + 1)::int, 1),
                           ''
                   )
            FROM generate_series(1, final_length)
        );

        -- Check if token already exists in target table
        SELECT EXISTS (
            SELECT 1 FROM sc_trx.secret WHERE secret_id = result
        )
        INTO exists_flag;

        EXIT WHEN NOT exists_flag;  -- exit loop if unique
    END LOOP;

    -- Log the generated token
    /*INSERT INTO sc_log.generated_token (
        token,
        generate_by,
        generate_date
    ) VALUES (
                 result,
                 'SYSTEM',
                 now()
             );*/

    RETURN result;
END;
$$ LANGUAGE plpgsql;