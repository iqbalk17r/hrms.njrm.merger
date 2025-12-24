-- sc_mst.notification_rule definition

-- Drop table

-- DROP TABLE sc_mst.notification_rule;

CREATE TABLE sc_mst.notification_rule (
	id bigserial NOT NULL,
	status varchar NOT NULL,
	notified_to varchar NOT NULL,
	"type" varchar NOT NULL,
	"module" varchar NOT NULL,
	description varchar NOT NULL,
	active bool DEFAULT true NOT NULL,
	input_by varchar NULL,
	input_date timestamp NULL,
	update_by varchar NULL,
	update_date timestamp NULL,
	deleted bool NULL,
	delete_by varchar NULL,
	delete_date timestamp NULL,
	delete_reason varchar NULL,
	CONSTRAINT notification_rule_key UNIQUE (status, notified_to, type, module, input_by),
	CONSTRAINT notification_rule_pkey PRIMARY KEY (id)
);

-- sc_trx.notifications definition

-- Drop table

-- DROP TABLE sc_trx.notifications;

CREATE TABLE sc_trx.notifications (
	notification_id bigserial NOT NULL,
	reference_id varchar NOT NULL,
	"type" varchar NOT NULL,
	"module" varchar NOT NULL,
	subject varchar NULL,
	"content" text NOT NULL,
	send_to varchar NOT NULL,
	"action" varchar NULL,
	status varchar NULL,
	properties json NULL,
	input_by varchar DEFAULT 'SYSTEM'::character varying NULL,
	input_date timestamp DEFAULT now() NULL,
	CONSTRAINT notifications_pkey PRIMARY KEY (notification_id)
);

INSERT INTO sc_mst.notification_rule
(id, status, notified_to, "type", "module", description, active, input_by, input_date, update_by, update_date, deleted, delete_by, delete_date, delete_reason)
VALUES(96, 'S', 'EMPLOYEE', 'wa', 'event', 'dijadwalkan/Schedule', true, 'SYSTEM', '2023-08-24 15:43:22.791', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO sc_mst.notification_rule
(id, status, notified_to, "type", "module", description, active, input_by, input_date, update_by, update_date, deleted, delete_by, delete_date, delete_reason)
VALUES(102, 'R', 'EMPLOYEE', 'wa', 'event', 'dijadwalkan ulang/Reschedule', true, 'SYSTEM', '2023-08-24 15:43:22.791', NULL, NULL, NULL, NULL, NULL, NULL);