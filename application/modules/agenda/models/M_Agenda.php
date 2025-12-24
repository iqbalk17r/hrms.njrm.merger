<?php

class M_Agenda extends CI_Model
{
    function read($clause = null)
    {
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null)
    {
        $this->db->query(' set lc_time = \'id\' ');
        return sprintf(<<<'SQL'
SELECT *,
        to_char(begin_date::timestamptz, 'TMDay, FMdd TMMonth YYYY HH24:MI:SS') AS begin_date_reformat,
        to_char(end_date::timestamptz, 'TMDay, FMdd TMMonth YYYY HH24:MI:SS') AS end_date_reformat
    FROM (
    select
        a.agenda_id,
        a.branch_id,
        a.agenda_name,
        a.agenda_type,
        b.uraian AS agenda_type_name,
        a.organizer_type,
        c.uraian AS organizer_type_name,
        a.organizer_name,
        a.description,
        a.resulttext,
        a.sertificate_validity_period,
        a.participant_count,
        a.begin_date,
        a.end_date,
        to_char(a.begin_date::timestamp,'HH24:MI') AS begin_hour,
        to_char(a.end_date::timestamp,'HH24:MI') AS end_hour,
        COALESCE(TRIM(f.room_name), a.location) AS location,
        f.room_id,
        a.link,
        a.status,
        case
            when a.status='C' then 'label-danger'
            else 'label-info'
            end as status_color,
        case
            when a.status='A' then 'PERLU PERSETUJUAN ATASAN'
            when a.status='C' then 'DIBATALKAN'
            when a.status='I' then 'BELUM DIJADWALKAN'
            when a.status='S' then 'DIJADWALKAN'
            when a.status='D' then 'DIHAPUS'
            when a.status='P' then 'DISETUJUI'
            end as status_text,
        d.uraian AS agenda_type_color,
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
        a.calendar_id,
        e.nmlengkap AS cancel_by_name
    FROM sc_trx.agenda a
    LEFT OUTER JOIN sc_mst.trxtype b ON a.agenda_type = b.kdtrx AND b.jenistrx = 'EVENT'
    LEFT OUTER JOIN sc_mst.trxtype c ON a.organizer_type = c.kdtrx AND c.jenistrx = 'ORGANIZERTYPE'
    LEFT OUTER JOIN sc_mst.trxtype d ON a.agenda_type = d.kdtrx AND d.jenistrx = 'EVENT:COLOR'
    LEFT OUTER JOIN sc_mst.karyawan e ON a.cancel_by = e.nik
    LEFT OUTER JOIN sc_mst.room f ON a.location = f.room_id
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }


    function readver2($clause = null)
    {
        return $this->db->query($this->read_txt2($clause));
    }
    function read_txt2($clause = null)
    {
        $this->db->query(' set lc_time = \'id\' ');
        return sprintf(<<<'SQL'
SELECT *,
        to_char(begin_date::timestamptz, 'TMDay, FMdd TMMonth YYYY HH24:MI:SS') AS begin_date_reformat,
        to_char(end_date::timestamptz, 'TMDay, FMdd TMMonth YYYY HH24:MI:SS') AS end_date_reformat,
        g.kddok,
        h.nik as nikparam
    FROM (
    select
        a.agenda_id,
        a.branch_id,
        a.agenda_name,
        a.agenda_type,
        b.uraian AS agenda_type_name,
        a.organizer_type,
        c.uraian AS organizer_type_name,
        a.organizer_name,
        a.description,
        a.resulttext,
        a.sertificate_validity_period,
        a.participant_count,
        a.begin_date,
        a.end_date,
        a.calendar_id,
        to_char(a.begin_date::timestamp,'HH24:MI') AS begin_hour,
        to_char(a.end_date::timestamp,'HH24:MI') AS end_hour,
        COALESCE(TRIM(f.room_name), a.location) AS location,
        f.room_id,
        a.link,
        a.status,
        case
            when a.status='C' then 'label-danger'
            else 'label-info'
            end as status_color,
        case
            when a.status='A' then 'PERLU PERSETUJUAN ATASAN'
            when a.status='C' then 'DIBATALKAN'
            when a.status='I' then 'BELUM DIJADWALKAN'
            when a.status='S' then 'DIJADWALKAN'
            when a.status='D' then 'DIHAPUS'
            when a.status='P' then 'DISETUJUI'
            end as status_text,
        d.uraian AS agenda_type_color,
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
        e.nmlengkap AS cancel_by_name
    FROM sc_trx.agenda a
    LEFT OUTER JOIN sc_mst.trxtype b ON a.agenda_type = b.kdtrx AND b.jenistrx = 'EVENT'
    LEFT OUTER JOIN sc_mst.trxtype c ON a.organizer_type = c.kdtrx AND c.jenistrx = 'ORGANIZERTYPE'
    LEFT OUTER JOIN sc_mst.trxtype d ON a.agenda_type = d.kdtrx AND d.jenistrx = 'EVENT:COLOR'
    LEFT OUTER JOIN sc_mst.karyawan e ON a.cancel_by = e.nik
    LEFT OUTER JOIN sc_mst.room f ON a.location = f.room_id
) as aa
LEFT OUTER JOIN sc_trx.agenda_attendance h ON h.agenda_id = aa.agenda_id
LEFT OUTER JOIN sc_pk.master_ojt g ON g.nik = h.nik
WHERE TRUE
SQL
            ) . $clause;
    }


    function exists($where)
    {
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.agenda')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_trx.agenda', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.agenda', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_trx.agenda');
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
        a.branch_id,
        a.agenda_name,
        a.agenda_type,
        b.uraian AS agenda_type_name,
        a.organizer_type,
        c.uraian AS organizer_type_name,
        a.organizer_name,
        a.description,
        a.resulttext,
        a.sertificate_validity_period,
        a.participant_count,
        a.begin_date,
        a.end_date,
        COALESCE(TRIM(f.room_name), a.location) AS location,
        f.room_id,
        a.link,
        a.status,
        case
            when a.status='A' then 'PERLU PERSETUJUAN ATASAN'
            when a.status='C' then 'DIBATALKAN'
            when a.status='I' then 'BELUM DIJADWALKAN'
            when a.status='D' then 'DIHAPUS'
            when a.status='P' then 'DISETUJUI'
            end as status_text,
        CASE 
            WHEN a.agenda_type = 'MEET' THEN '#389FD6'
            WHEN a.agenda_type = 'COUCH' THEN '#FFAF0F'
            WHEN a.agenda_type = 'SERT' THEN '#107C41'
        END AS agenda_type_color,
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
    FROM sc_tmp.agenda a
    LEFT OUTER JOIN sc_mst.trxtype b ON a.agenda_type = b.kdtrx AND b.jenistrx = 'EVENT'
    LEFT OUTER JOIN sc_mst.trxtype c ON a.organizer_type = c.kdtrx AND c.jenistrx = 'ORGANIZERTYPE'
    LEFT OUTER JOIN sc_mst.room f ON a.location = f.room_id
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
                ->get('sc_tmp.agenda')
                ->num_rows() > 0;
    }

    function tmp_create($value)
    {
        return $this->db
            ->insert('sc_tmp.agenda', $value);
    }

    function tmp_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_tmp.agenda', $value);
    }

    function tmp_delete($where, $or_where = '')
    {
        if (!empty($or_where)) {
            return $this->db
                ->where($where)
                ->or_where($or_where)
                ->delete('sc_tmp.agenda');
        } else {
            return $this->db
                ->where($where)
                ->delete('sc_tmp.agenda');
        }
    }

    function history_create($value)
    {
        return $this->db
            ->insert('sc_his.agenda_schedule', $value);
    }
    function history_read($clause = null)
    {
        return $this->db->query($this->history_read_txt($clause));
    }

    function history_read_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    SELECT 
        a.agenda_id, 
        a.begin_date, 
        a.end_date, 
        a.reason, 
        a.input_by, 
        a.input_date
    FROM sc_his.agenda_schedule a
    ORDER BY input_date DESC
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function employee_list_read($clause = null){
        return $this->db->query($this->employee_list_read_txt($clause));
    }
    function employee_list_read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM(
     SELECT
         COALESCE(TRIM(c.nik), '') AS nik,
         COALESCE(TRIM(c.nmlengkap), '') AS fullname,
         COALESCE(TRIM(c.bag_dept), '') AS departementid,
         COALESCE(TRIM(c.subbag_dept), '') AS subdepartementid,
         COALESCE(TRIM(c.jabatan), '') AS positionid,
         COALESCE(TRIM(c.statuskepegawaian), '') AS employment_status,
         COALESCE(TRIM(d.nmdept), '') AS department_name,
         COALESCE(TRIM(e.nmsubdept), '') AS subdepartment_name,
         COALESCE(TRIM(f.nmjabatan), '') AS position_name,
         COALESCE(TRIM(c.lvl_jabatan), '') AS levelid,
         h.tgl::DATE AS workdate,
         COALESCE(TRIM(i.kdjam_kerja),'OFF') AS workid,
         COALESCE(TRIM(g.agenda_id),'') AS agenda_id,
         i.jam_masuk AS begin_hour,
         i.jam_pulang AS end_hour,
         COALESCE(TRIM(i.shiftke),'OFF') AS shiftid,
         COALESCE(TRIM(h.kdregu),'OFF') AS groupid,
         COALESCE(TRIM(j.nmregu),'OFF') AS group_name
     FROM sc_mst.karyawan c
              LEFT JOIN sc_mst.departmen d
                        ON c.bag_dept = d.kddept
              LEFT JOIN sc_mst.subdepartmen e
                        ON c.bag_dept = e.kddept AND c.subbag_dept = e.kdsubdept
              LEFT JOIN sc_mst.jabatan f
                        ON c.bag_dept = f.kddept AND c.subbag_dept = f.kdsubdept AND c.jabatan = f.kdjabatan
              LEFT OUTER JOIN sc_trx.agenda g ON TRUE
              LEFT OUTER JOIN sc_trx.dtljadwalkerja h ON c.nik = h.nik AND h.tgl::date BETWEEN g.begin_date::DATE AND g.end_date::DATE
              LEFT OUTER JOIN sc_mst.jam_kerja i ON h.kdjamkerja = i.kdjam_kerja
              LEFT OUTER JOIN sc_mst.regu j ON j.kdregu = h.kdregu
     WHERE TRUE
) a WHERE TRUE
SQL
            ).$clause;
    }

    function getScheduleDetail($nik, $agendaid){
        return $this->db->query("
            WITH setfilter AS(
                    SELECT
                        '$nik'::VARCHAR AS nik,
                        '$agendaid'::VARCHAR AS agenda_id
                ),
                date_series AS (
                    SELECT generate_series(b.begin_date::date, b.end_date::date, '1 day'::interval) AS tgl
                    FROM sc_trx.agenda b, setfilter
                    WHERE b.agenda_id = setfilter.agenda_id
                )
                SELECT
                    ds.tgl::date AS date,
                    TO_CHAR(ds.tgl::date,'DD-MM-YYYY') AS date_format,
                    COALESCE(TRIM(a.nik),sf.nik) AS nik,
                    COALESCE(TRIM(a.kdjamkerja),'OFF') AS kdjamkerja,
                    COALESCE(TRIM(a.kdregu),'OFF') AS groupid,
                    COALESCE(TRIM(c.shiftke),'OFF') AS shiftid,
                    COALESCE(TRIM(c.nmjam_kerja),'OFF') AS workhour_name,
                    COALESCE(TRIM(d.nmregu),'OFF') AS group_name,
                    c.jam_masuk AS entry_hour,
                    c.jam_pulang AS leave_hour
                FROM date_series ds
                    LEFT OUTER JOIN setfilter sf ON TRUE
                    LEFT OUTER JOIN sc_trx.dtljadwalkerja a ON ds.tgl = a.tgl AND a.nik = sf.nik
                    LEFT OUTER JOIN sc_trx.agenda b ON ds.tgl BETWEEN b.begin_date::date AND b.end_date::date
                    LEFT OUTER JOIN sc_mst.jam_kerja c ON a.kdjamkerja = c.kdjam_kerja
                    LEFT OUTER JOIN sc_mst.regu d ON a.kdregu = d.kdregu
                WHERE b.agenda_id = sf.agenda_id
        ");
    }


    public function checkroom($param)
    {
        return $this->db->query("
            SELECT * FROM(
                select 
                    begin_date, 
                    end_date, 
                    location
                from sc_trx.agenda
                WHERE status <> 'C' AND location <> 'ROM000000000'
            ) a WHERE TRUE
        ".$param);
    }

    public function checkpassedevent($param)
    {
        $row = $this->db->query("select count(*) as jml from sc_trx.agenda where agenda_id='$param' and end_date::date < current_date and agenda_type = 'OJT'")->row();
        return $row && isset($row->jml) && $row->jml > 0 ? true : false;
    }



}