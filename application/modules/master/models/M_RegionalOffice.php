<?php

class M_RegionalOffice extends CI_Model
{
    function read($clause = null){
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.branch),'') branch,
        COALESCE(TRIM(a.kdcabang),'') kdcabang,
        COALESCE(TRIM(a.desc_cabang),'') desc_cabang,
        CASE
            WHEN kdcabang IN ('SMGCND','SMGDMK','JKTKPK') THEN COALESCE(split_part(TRIM(a.desc_cabang),' ',2),'')
            WHEN kdcabang IN ('NAS') THEN 'SURABAYA'
            ELSE COALESCE(split_part(TRIM(a.desc_cabang),' ',1),'')
        END AS regional_name,
        COALESCE(TRIM(a.initial),'') initial
    FROM sc_mst.kantorwilayah a
) as aa
WHERE TRUE
SQL
            ).$clause;
    }
}