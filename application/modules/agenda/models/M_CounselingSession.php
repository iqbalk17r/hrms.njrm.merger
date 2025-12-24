<?php

class M_CounselingSession extends CI_Model
{
    function read($clause = null)
    {
        return $this->db->query($this->read_txt($clause));
    }

    function read_txt($clause = null)
    {
        $this->db->query(" SET lc_time = 'id' ");
        return sprintf(<<<'SQL'
SELECT *,
       '<button class="btn btn-sm btn-instagram check-schedule" data-key="' ||encoded||'">cek jadwal</button>' AS schedule_button,
       concat(begin_time,'-',end_time) AS merge_time,
       CASE 
           WHEN begin_time IS NOT NULL OR end_time IS NOT NULL THEN CONCAT(begin_time_format,'-',end_time_format)
           ELSE ''
       END AS merge_time_format,
       to_char(session_date::date, 'TMDay, dd TMMonth YYYY') AS session_date_reformat
    FROM (
    select
        encode(concat('{"session_id":"',a.session_id,'","counselee":"',a.counselee,'"}')::bytea, 'hex') AS encoded,
        a.session_id,
        a.branch_id,
        a.counselee,
        TRIM(b.nmlengkap) AS counselee_name,
        a.counselor,
        COALESCE(trim(c.nmlengkap),a.counselor) AS counselor_name,
        a.session_date AS session_date,
        a.begin_time AS begin_time,
        a.end_time AS end_time,
        a.location AS location,
        COALESCE(a.session_date,'BELUM DITENTUKAN') AS session_date_format,
        COALESCE(a.begin_time::varchar,'BELUM DITENTUKAN') AS begin_time_format,
        COALESCE(a.end_time::varchar,'BELUM DITENTUKAN') AS end_time_format,
        COALESCE(a.location::varchar,'BELUM DITENTUKAN') AS location_format,
        a.description,
        a.status,
        case
            when a.status='A' then 'PERLU PERSETUJUAN ATASAN'
            when a.status='C' then 'DIBATALKAN'
            when a.status='I' then 'BELUM DIJADWALKAN'
            when a.status='R' then 'DIJADWALKAN ULANG / PERLU PERSETUJUAN ATASAN'
            when a.status='D' then 'DIHAPUS'
            when a.status='P' then 'DISETUJUI'
        end as status_text,
        CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
        CASE
            WHEN (select nik FROM sc_mst.karyawan qq WHERE bag_dept = 'OP' AND subbag_dept = 'DPK' AND nik = a.input_by ) = a.input_by THEN 'HRD'
            WHEN (select nik FROM sc_mst.karyawan ww WHERE nik = a.counselee ) = a.input_by THEN 'EMPLOYEE'
            ELSE 'SUPERIOR'
        END AS input_by_type,
        a.score,
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
    from sc_trx.counseling_session a
    LEFT OUTER JOIN sc_mst.karyawan b ON a.counselee = trim(b.nik)
    LEFT OUTER JOIN sc_mst.karyawan c ON a.counselor = trim(c.nik)
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function exists($where)
    {
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.counseling_session')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_trx.counseling_session', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.counseling_session', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_trx.counseling_session');
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
        encode(concat('{"session_id":"',a.session_id,'","counselee":"',a.counselee,'"}')::bytea, 'hex') AS encoded,
        a.session_id,
        a.branch_id,
        a.counselee,
        b.nmlengkap AS counselee_name,
        a.counselor,
        COALESCE(c.nmlengkap,a.counselor) AS counselor_name,
        COALESCE(a.session_date,'BELUM DITENTUKAN') AS session_date,
        COALESCE(a.begin_time::varchar,'BELUM DITENTUKAN') AS begin_time,
        COALESCE(a.end_time::varchar,'BELUM DITENTUKAN') AS end_time,
        COALESCE(a.location::varchar,'BELUM DITENTUKAN') AS location,
        a.description,
        a.status,
        case
            when a.status='A' then 'PERLU PERSETUJUAN ATASAN'
            when a.status='C' then 'DIBATALKAN'
            when a.status='I' then 'BELUM DIJADWALKAN'
            when a.status='R' then 'DIJADWALKAN ULANG'
            when a.status='D' then 'DIHAPUS'
            when a.status='P' then 'DISETUJUI'
        end as status_text,
        CONCAT(COALESCE(TRIM(b.nik_atasan), ''), '.', COALESCE(TRIM(b.nik_atasan2), '')) AS superiors,
        a.score,
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
    from sc_tmp.counseling_session a
    LEFT OUTER JOIN sc_mst.karyawan b ON a.counselee = trim(b.nik)
    LEFT OUTER JOIN sc_mst.karyawan c ON a.counselor = trim(c.nik)
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
                ->get('sc_tmp.counseling_session')
                ->num_rows() > 0;
    }

    function tmp_create($value)
    {
        return $this->db
            ->insert('sc_tmp.counseling_session', $value);
    }

    function tmp_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_tmp.counseling_session', $value);
    }

    function tmp_delete($where, $or_where = '')
    {
        if (!empty($or_where)) {
            return $this->db
                ->where($where)
                ->or_where($or_where)
                ->delete('sc_tmp.counseling_session');
        } else {
            return $this->db
                ->where($where)
                ->delete('sc_tmp.counseling_session');
        }
    }

    function history_create($value)
    {
        return $this->db
            ->insert('sc_his.counseling_schedule', $value);
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
        a.session_id, 
        a.session_date, 
        a.begin_time, 
        a.end_time, 
        a.location, 
        a.reason, 
        a.input_by, 
        a.input_date
    FROM sc_his.counseling_schedule a
    ORDER BY input_date DESC
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function detail_read($clause = null)
    {
        return $this->db->query($this->detail_read_txt($clause));
    }

    function detail_read_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    SELECT 
        a.detail_id, 
        a.session_id, 
        a.sort, 
        a.problem, 
        a.solution, 
        a.score, 
        a.input_by, 
        a.input_date, 
        a.update_by, 
        a.update_date
    FROM sc_trx.counseling_session_detail a
    order by sort ASC, input_date ASC
) as aa
WHERE TRUE 
SQL
            ) . $clause;
    }

    function detail_create($value)
    {
        return $this->db
            ->insert('sc_trx.counseling_session_detail', $value);
    }

    function detail_update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.counseling_session_detail', $value);
    }

    function detail_delete($where, $or_where = '')
    {
        if (!empty($or_where)) {
            return $this->db
                ->where($where)
                ->or_where($or_where)
                ->delete('sc_trx.counseling_session_detail');
        } else {
            return $this->db
                ->where($where)
                ->delete('sc_trx.counseling_session_detail');
        }
    }


}