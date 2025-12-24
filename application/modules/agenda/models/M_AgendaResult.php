<?php

class M_AgendaResult extends CI_Model
{
    function read($clause = null)
    {
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null)
    {
        return sprintf(<<<'SQL'
SELECT *
    FROM (
    select
        a.result_id,
        a.agenda_id,
        a.branch_id,
        a.nik,
        a.pretest,
        a.posttest,
        a.score,
        a.result_text,
        a.sertificate,
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
        a.delete_reason,
        c.nmlengkap,
        d.nmdept,
        e.nmsubdept,
        f.nmjabatan
    from sc_trx.agenda_result a
        LEFT OUTER JOIN sc_trx.agenda b ON a.agenda_id = b.agenda_id
        LEFT OUTER JOIN sc_mst.karyawan c ON a.nik = c.nik
        LEFT OUTER JOIN sc_mst.departmen d ON c.bag_dept = d.kddept
        LEFT OUTER JOIN sc_mst.subdepartmen e ON c.subbag_dept = e.kdsubdept
        LEFT OUTER JOIN sc_mst.jabatan f ON c.jabatan = f.kdjabatan
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
                ->get('sc_trx.agenda_result')
                ->num_rows() > 0;
    }

    function create($value)
    {
        return $this->db
            ->insert('sc_trx.agenda_result', $value);
    }

    function update($value, $where)
    {
        return $this->db
            ->where($where)
            ->update('sc_trx.agenda_result', $value);
    }

    function delete($where)
    {
        return $this->db
            ->where($where)
            ->delete('sc_trx.agenda_result');
    }
}