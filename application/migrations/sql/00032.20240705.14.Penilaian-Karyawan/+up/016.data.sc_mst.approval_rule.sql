-- sc_mst.approval_rule definition

-- Drop table

-- DROP TABLE sc_mst.approval_rule;

CREATE TABLE IF NOT EXISTS sc_mst.approval_rule (
	approval_rule_id varchar DEFAULT concat('APPR', date_part('epoch'::text, now()::timestamp without time zone + '00:00:02'::interval)::integer) NOT NULL,
	approval_rule_name varchar NOT NULL,
	departmentid varchar NOT NULL,
	groupid varchar NULL,
	nik _varchar NOT NULL,
	actived bool DEFAULT true NOT NULL,
	status varchar NOT NULL,
	properties json NULL,
	inputby varchar NULL,
	inputdate timestamp NULL,
	updateby varchar NULL,
	updatedate timestamp NULL,
	deleteby varchar NULL,
	deletedate timestamp NULL,
	delete_reason varchar NULL,
	CONSTRAINT approval_rule_pkey PRIMARY KEY (approval_rule_id)
);

INSERT INTO sc_mst.approval_rule (approval_rule_name,departmentid,groupid,nik,actived,status,properties,inputby,inputdate) VALUES
	 ('PERFORMA APPRAISAL','PST','PA','{0321.438}',true,'P',NULL,'MIGRATION',now())
ON CONFLICT
    DO NOTHING ;