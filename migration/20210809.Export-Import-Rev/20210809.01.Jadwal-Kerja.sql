-------------------------------------------------- SC_TRX.JADWALKERJA --------------------------------------------------
CREATE OR REPLACE FUNCTION sc_trx.pr_jadwal_kerja_insert()
    RETURNS trigger AS
$BODY$
DECLARE

BEGIN
	INSERT INTO sc_trx.dtljadwalkerja (nik, shift, tgl, kdjamkerja, kdregu, kdmesin)
    SELECT b.nik, e.shift, tgl, kodejamkerja, a.kdregu, kdmesin
    FROM sc_trx.jadwalkerja a
    LEFT OUTER JOIN sc_mst.regu d ON a.kdregu = d.kdregu
    LEFT OUTER JOIN sc_mst.regu_opr b ON a.kdregu = b.kdregu
    LEFT OUTER JOIN sc_mst.karyawan c ON c.nik = b.nik
    LEFT OUTER JOIN sc_mst.jabatan e ON c.jabatan = e.kdjabatan AND e.kddept = c.bag_dept AND e.kdsubdept = c.subbag_dept
    WHERE a.kdregu = new.kdregu AND tgl = new.tgl AND COALESCE(c.nik, '') != ''
    ON CONFLICT (nik, tgl)
    DO NOTHING;

    RETURN new;
END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_trx.pr_jadwal_kerja_insert()
    OWNER TO postgres;
--#
CREATE OR REPLACE FUNCTION sc_trx.pr_jadwal_kerja_update()
    RETURNS trigger AS
$BODY$
DECLARE

BEGIN
	DELETE FROM sc_trx.dtljadwalkerja
	WHERE kdregu = new.kdregu and tgl = new.tgl;

	INSERT INTO sc_trx.dtljadwalkerja (nik, shift, tgl, kdjamkerja, kdregu, kdmesin)
    SELECT b.nik, e.shift, tgl, kodejamkerja, a.kdregu, kdmesin
    FROM sc_trx.jadwalkerja a
    LEFT OUTER JOIN sc_mst.regu d ON a.kdregu = d.kdregu
    LEFT OUTER JOIN sc_mst.regu_opr b ON a.kdregu = b.kdregu
    LEFT OUTER JOIN sc_mst.karyawan c ON c.nik = b.nik
    LEFT OUTER JOIN sc_mst.jabatan e ON c.jabatan = e.kdjabatan AND e.kddept = c.bag_dept AND e.kdsubdept = c.subbag_dept
    WHERE a.kdregu = new.kdregu AND tgl = new.tgl AND COALESCE(c.nik, '') != ''
	ON CONFLICT (nik, tgl)
    DO NOTHING;

    RETURN new;
END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_trx.pr_jadwal_kerja_update()
    OWNER TO postgres;
--#
CREATE OR REPLACE FUNCTION sc_trx.pr_jadwal_kerja_delete()
    RETURNS trigger AS
$BODY$
DECLARE

BEGIN
	DELETE FROM sc_trx.dtljadwalkerja
	WHERE kdregu = old.kdregu AND tgl = old.tgl;

    RETURN new;
END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_trx.pr_jadwal_kerja_delete()
    OWNER TO postgres;
-------------------------------------------------- END OF: SC_TRX.JADWALKERJA --------------------------------------------------
