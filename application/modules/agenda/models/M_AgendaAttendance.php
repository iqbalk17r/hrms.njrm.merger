<?php

class M_AgendaAttendance extends CI_Model
{
    function read($clause = null)
    {
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *,
       CASE
           WHEN confirm_status IS NULL THEN 'Belum konfirmasi'
           WHEN confirm_status = TRUE THEN 'Hadir'
           ELSE 'Tidak Hadir'
           END AS confirm_status_text,
       CASE
           WHEN attend_status IS NULL THEN 'Belum konfirmasi'
           WHEN attend_status = TRUE THEN 'Hadir'
           ELSE 'Tidak Hadir'
           END AS attend_status_text,
       CASE
           WHEN ojt_status IS NULL THEN 'PANELIST'
           WHEN ojt_status = TRUE THEN 'PESERTA OJT'
           ELSE 'PANELIST'
           END AS ojt_status_text
FROM (
         select
             a.agenda_id,
             a.nik,
             TRUE AS confirm_join,
             TRUE AS confirm_leave,
             a.branch_id,
             a.confirm_status,
             a.attend_status,
             a.ojt_status,
             a.properties,
             a.input_by,
             a.input_date,
             a.update_by,
             a.update_date,
             a.approve_by,
             a.approve_date,
             a.cancel_by,
             a.cancel_date,
             a.cancel_reason,
             a.delete_by,
             a.delete_date,
             a.delete_reason,
             CONCAT(COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), '')) AS superiors,
             c.nmlengkap,
             d.nmdept,
             e.nmsubdept,
             f.nmjabatan,
             c.email,
             c.email2,
             CASE 
                WHEN STRPOS(LOWER(c.email), '@gmail') = 0 THEN c.email2
                ELSE c.email
            END AS email_calendar,
             CONCAT(REGEXP_REPLACE(
                CASE LEFT(COALESCE(TRIM(c.nohp1), g.value1), 1)
                    WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c.nohp1), g.value1), -1))
                    ELSE COALESCE(TRIM(c.nohp1), g.value1)
                    END, '[^\w]+', '', 'g'
            ), '@s.whatsapp.net') AS employee_phone,
            h.ojt
        FROM sc_trx.agenda_attendance a
        LEFT OUTER JOIN sc_trx.agenda b ON a.agenda_id = b.agenda_id
        LEFT OUTER JOIN sc_mst.karyawan c ON a.nik = c.nik
        LEFT OUTER JOIN sc_mst.departmen d ON c.bag_dept = d.kddept
        LEFT OUTER JOIN sc_mst.subdepartmen e ON c.subbag_dept = e.kdsubdept
        LEFT OUTER JOIN sc_mst.jabatan f ON c.jabatan = f.kdjabatan
        LEFT OUTER JOIN sc_mst.option g ON TRUE AND g.kdoption = 'D:N'
        LEFT OUTER JOIN sc_trx.status_kepegawaian h on h.nik = a.nik and h.status = 'B'
     ) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function read_email($param){
        $result = $this->db->query("SELECT *,
            CASE
                WHEN confirm_status IS NULL THEN 'Belum konfirmasi'
                WHEN confirm_status = TRUE THEN 'Hadir'
                ELSE 'Tidak Hadir'
                END AS confirm_status_text,
            CASE
                WHEN attend_status IS NULL THEN 'Belum konfirmasi'
                WHEN attend_status = TRUE THEN 'Hadir'
                ELSE 'Tidak Hadir'
                END AS attend_status_text,
            CASE
                WHEN ojt_status IS NULL THEN 'PANELIST'
                WHEN ojt_status = TRUE THEN 'PESERTA OJT'
                ELSE 'PANELIST'
                END AS ojt_status_text
        FROM (
                select
                    a.agenda_id,
                    a.nik,
                    TRUE AS confirm_join,
                    TRUE AS confirm_leave,
                    a.branch_id,
                    a.confirm_status,
                    a.attend_status,
                    a.ojt_status,
                    a.properties,
                    a.input_by,
                    a.input_date,
                    a.update_by,
                    a.update_date,
                    a.approve_by,
                    a.approve_date,
                    a.cancel_by,
                    a.cancel_date,
                    a.cancel_reason,
                    a.delete_by,
                    a.delete_date,
                    a.delete_reason,
                    CONCAT(COALESCE(TRIM(c.nik_atasan), ''), '.', COALESCE(TRIM(c.nik_atasan2), '')) AS superiors,
                    c.nmlengkap,
                    d.nmdept,
                    e.nmsubdept,
                    f.nmjabatan,
                    c.email,
                    CASE 
                        WHEN LOWER(c.email) NOT LIKE '%@gmail%' THEN c.email2
                        ELSE c.email
                    END AS email_calendar, 
                    CONCAT(REGEXP_REPLACE(
                        CASE LEFT(COALESCE(TRIM(c.nohp1), g.value1), 1)
                            WHEN '0' THEN CONCAT('62', RIGHT(COALESCE(TRIM(c.nohp1), g.value1), -1))
                            ELSE COALESCE(TRIM(c.nohp1), g.value1)
                            END, '[^\w]+', '', 'g'
                    ), '@s.whatsapp.net') AS employee_phone,
                    h.ojt
                FROM sc_trx.agenda_attendance a
                LEFT OUTER JOIN sc_trx.agenda b ON a.agenda_id = b.agenda_id
                LEFT OUTER JOIN sc_mst.karyawan c ON a.nik = c.nik
                LEFT OUTER JOIN sc_mst.departmen d ON c.bag_dept = d.kddept
                LEFT OUTER JOIN sc_mst.subdepartmen e ON c.subbag_dept = e.kdsubdept
                LEFT OUTER JOIN sc_mst.jabatan f ON c.jabatan = f.kdjabatan
                LEFT OUTER JOIN sc_mst.option g ON TRUE AND g.kdoption = 'D:N'
                LEFT OUTER JOIN sc_trx.status_kepegawaian h on h.nik = a.nik and h.status = 'B'
            ) as aa
        WHERE TRUE $param ");
        return $result;
    }

    function exists($where)
    {
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.agenda_attendance')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_trx.agenda_attendance', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.agenda_attendance', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_trx.agenda_attendance');
    }

    function tmp_read($clause = null)
    {
        return $this->db->query($this->tmp_read_txt($clause));
    }
    function tmp_read_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    select
        a.agenda_id, 
        a.nik, 
        a.branch_id, 
        a.confirm_status,
        a.attend_status, 
        a.status,
        a.properties, 
        a.input_by, 
        a.input_date, 
        a.update_by, 
        a.update_date, 
        a.approve_by, 
        a.approve_date, 
        a.cancel_by, 
        a.cancel_date, 
        a.cancel_reason, 
        a.delete_by, 
        a.delete_date, 
        a.delete_reason
    from sc_tmp.agenda_attendance a
    LEFT OUTER JOIN sc_trx.agenda b ON a.agenda_id = b.agenda_id
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function tmp_exists($where)
    {
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_tmp.agenda_attendance')
                ->num_rows() > 0;
    }

    function tmp_create($value)
    {
        return $this->db
            ->insert('sc_tmp.agenda_attendance', $value);
    }

    function tmp_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_tmp.agenda_attendance', $value);
    }

    function tmp_delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_tmp.agenda_attendance');
    }

    function tmp_participant($clause = null)
    {
        return $this->db->query($this->tmp_participant_txt($clause));
    }
    function tmp_participant_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    select
        a.nik,
        a.agenda_id,
        COALESCE(TRIM(c.nmlengkap), '') AS fullname,
        COALESCE(TRIM(c.bag_dept), '') AS departementid,
        COALESCE(TRIM(c.subbag_dept), '') AS subdepartementid,
        COALESCE(TRIM(c.jabatan), '') AS positionid,
        COALESCE(TRIM(c.statuskepegawaian), '') AS employment_status,
        COALESCE(TRIM(d.nmdept), '') AS department_name,
        COALESCE(TRIM(e.nmsubdept), '') AS subdepartment_name,
        COALESCE(TRIM(f.nmjabatan), '') AS position_name,
        COALESCE(TRIM(c.lvl_jabatan), '') AS levelid
    from sc_tmp.agenda_attendance a
    LEFT OUTER JOIN sc_mst.karyawan c ON a.nik = c.nik
        LEFT JOIN sc_mst.departmen d
    ON c.bag_dept = d.kddept
        LEFT JOIN sc_mst.subdepartmen e
        ON c.bag_dept = e.kddept AND c.subbag_dept = e.kdsubdept
        LEFT JOIN sc_mst.jabatan f
        ON c.bag_dept = f.kddept AND c.subbag_dept = f.kdsubdept AND c.jabatan = f.kdjabatan
    WHERE TRUE
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }
}