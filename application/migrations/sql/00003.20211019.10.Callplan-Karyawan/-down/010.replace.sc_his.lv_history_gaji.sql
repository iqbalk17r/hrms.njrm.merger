CREATE OR REPLACE VIEW sc_his.lv_history_gaji AS
SELECT x.branch,
    x.nik,
    x.periode,
    x.nominal,
    x.inputdate,
    x.inputby,
    x.updatedate,
    x.updateby,
    x.gajipokok,
    x.gajitj,
    x.k_gplvl,
    x.k_gpwil,
    x.nmlengkap,
    x.nmdept,
    x.nmjabatan,
    x.grouppenggajian
FROM (
    SELECT a.branch,
        a.nik,
        a.periode,
        a.nominal,
        a.inputdate,
        a.inputby,
        a.updatedate,
        a.updateby,
        a.gajipokok,
        a.gajitj,
        a.k_gplvl,
        a.k_gpwil,
        b.nmlengkap,
        b.nmdept,
        b.nmjabatan,
        b.grouppenggajian
    FROM sc_his.history_gaji a
    LEFT JOIN sc_mst.lv_m_karyawan b ON a.nik = b.nik
) x;

ALTER TABLE sc_his.lv_history_gaji
    OWNER TO postgres;
COMMENT ON VIEW sc_his.lv_history_gaji
    IS '
        Create By :Fiky Ashariza
        Update Clue
        ALTER VIEW a_view ALTER COLUMN ts SET DEFAULT now();
        INSERT INTO a_view(id) VALUES(2);  -- ts will receive the current time
    ';
