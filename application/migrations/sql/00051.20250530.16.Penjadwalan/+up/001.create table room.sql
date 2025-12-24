
CREATE TABLE sc_mst.room
(
  room_id character varying NOT NULL,
  room_name character varying,
  branch character varying,
  capacity numeric,
  category character varying,
  coordinate text,
  description text,
  actived boolean DEFAULT true,
  input_by character varying,
  input_date timestamp without time zone DEFAULT now(),
  update_by character varying,
  update_date timestamp without time zone,
  deleted boolean DEFAULT false,
  delete_by character varying,
  delete_date timestamp without time zone,
  properties jsonb DEFAULT '{}'::jsonb,
  CONSTRAINT room_pkey PRIMARY KEY (room_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE sc_mst.room
  OWNER TO postgres;

--============================FUNCTION====================

-- Function: sc_mst.pr_room()

-- DROP FUNCTION sc_mst.pr_room();

CREATE OR REPLACE FUNCTION sc_mst.pr_room()
  RETURNS trigger AS
$BODY$
DECLARE
    vr_branch varchar;
    vr_numbering varchar;
BEGIN
    -- Detect INSERT operation
    IF TG_OP = 'INSERT' THEN
        vr_branch := branch FROM sc_mst.branch where "left"(upper(cdefault),1) = 'Y';
        vr_numbering := sc_mst.pr_generate_numbering('I.Z.A.3', 'SYSTEM_TEST', '{"count3": 9, "prefix": "ROM", "counterid": 1, "xno": 1}');
        UPDATE sc_mst.room SET
            branch = vr_branch,
            room_id = vr_numbering
        WHERE TRUE
            AND input_by = new.input_by
            AND room_id = new.room_id;

        -- Detect UPDATE operation
    ELSIF TG_OP = 'UPDATE' THEN
        RAISE NOTICE 'Update detected: OLD: %, NEW: %', OLD, NEW;

        -- Detect DELETE operation
    ELSIF TG_OP = 'DELETE' THEN
        RAISE NOTICE 'Delete detected: %', OLD;
    END IF;

    RETURN NEW; -- For INSERT/UPDATE, return NEW. For DELETE, return OLD if required.
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_mst.pr_room()
  OWNER TO postgres;




--============================TRIGGER====================
CREATE TRIGGER tr_room
  AFTER INSERT OR UPDATE
  ON sc_mst.room
  FOR EACH ROW
  EXECUTE PROCEDURE sc_mst.pr_room();

