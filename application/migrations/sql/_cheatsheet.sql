-------------------------------------------------- ALTER TABLE [ADD / ALTER] COLUMN --------------------------------------------------
DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'table_schema' AND table_name = 'table_name' AND column_name = 'column_name') THEN
        -- YOUR ALTER QUERY
    END IF;
END
$$
-------------------------------------------------- ALTER TABLE [ADD / ALTER] COLUMN --------------------------------------------------
--#
--#
-------------------------------------------------- INSERT TABLE IF CONFLICT DO NOTHING --------------------------------------------------
INSERT INTO [table_name]
    ([p_key], [column_name], [column_name])
VALUES
    ('value', 'value', 'value')
ON CONFLICT ([p_key])
DO NOTHING;
-------------------------------------------------- INSERT TABLE IF CONFLICT DO NOTHING --------------------------------------------------
--#
--#
-------------------------------------------------- INSERT TABLE IF CONFLICT DO UPDATE --------------------------------------------------
INSERT INTO [table_name]
    ([p_key_1], [p_key_2], [column_name_1], [column_name_2], [column_name_3])
VALUES
    ('value', 'value', 'value', 'value', 'value')
ON CONFLICT ([p_key_1], [p_key_2])
DO UPDATE SET
    ([column_name_1], [column_name_2]) =
    (EXCLUDED.[column_name_1], EXCLUDED.[column_name_2])
;
-------------------------------------------------- INSERT TABLE IF CONFLICT DO UPDATE --------------------------------------------------
