CREATE TABLE IF NOT EXISTS sc_trx.notification_generate (
    notification_generate_id serial4 NOT NULL,
    notification_generate_sendto varchar NULL,
    notification_generate_content varchar NULL,
    notification_generate_type varchar NOT NULL,
    notification_generate_modul varchar NULL,
    notification_generate_create date DEFAULT now() NULL,
    notification_generate_lastsend date NULL,
    properties jsonb DEFAULT '{}'::jsonb NULL,
    CONSTRAINT notification_generate_pkey PRIMARY KEY (notification_generate_id),
    CONSTRAINT unique_notification_generate UNIQUE (notification_generate_sendto, notification_generate_content, notification_generate_type, notification_generate_modul, notification_generate_create)
);

