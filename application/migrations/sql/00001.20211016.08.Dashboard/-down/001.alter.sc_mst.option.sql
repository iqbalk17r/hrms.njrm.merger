DO
$$
BEGIN
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'option' AND column_name = 'value1') THEN
        ALTER TABLE IF EXISTS sc_mst.option ALTER COLUMN value1 SET DATA TYPE CHARACTER VARYING(20);
    END IF;
END
$$
