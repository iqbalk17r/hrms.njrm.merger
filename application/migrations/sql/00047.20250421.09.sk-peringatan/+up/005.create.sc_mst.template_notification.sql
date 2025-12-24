CREATE TABLE IF NOT EXISTS sc_mst.template_notification (
    template_notification_id serial4 NOT NULL,
    template_notification_content varchar NULL,
    template_notification_type varchar NOT NULL,
    template_notification_modul varchar NULL,
    template_notification_procedure varchar NULL,
    template_notification_level varchar NULL,
    properties jsonb DEFAULT '{}'::jsonb NULL,
    "parameter" jsonb DEFAULT '{}'::jsonb NULL,
    CONSTRAINT template_notification_pkey PRIMARY KEY (template_notification_id)
);