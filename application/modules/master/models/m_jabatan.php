<?php
class M_jabatan extends CI_Model{
	function q_jabatan($params = "") {
		return $this->db->query("
            SELECT a.*, shift, CASE 
                WHEN shift = 'T' THEN 'YES'
                ELSE 'NO'
            END AS shift1, lembur, CASE
                WHEN lembur = 'T' THEN 'YES'
                else 'NO'
            END AS lembur1, b.nmdept, c.nmsubdept, d.nmgrade 
            FROM sc_mst.jabatan a 
            LEFT OUTER JOIN sc_mst.departmen b ON a.kddept = b.kddept
            LEFT OUTER JOIN sc_mst.subdepartmen c ON a.kdsubdept = c.kdsubdept
            LEFT OUTER JOIN sc_mst.jobgrade d ON a.kdgrade = d.kdgrade
            $params
            ORDER BY kdjabatan
        ");
	}
	
	function q_cekjabatan($kdjbt){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmgrade from sc_mst.jabatan a 
								left outer join sc_mst.departmen b on a.kddept=b.kddept
								left outer join sc_mst.subdepartmen c on a.kdsubdept=c.kdsubdept
								left outer join sc_mst.jobgrade d on a.kdgrade=d.kdgrade
								where trim(kdjabatan)='$kdjbt'");
	}
	
	function q_jobgrade($params = "") {
		return $this->db->query("
            SELECT a.*, b.nmlvljabatan 
            FROM sc_mst.jobgrade a
            LEFT OUTER JOIN sc_mst.lvljabatan b ON a.kdlvl = b.kdlvl
            $params
            ORDER BY kdgrade
        ");
	
	}
	function q_cekjobgrade($kdgrade){
		return $this->db->query("select a.*,b.nmlvljabatan from sc_mst.jobgrade a
								left outer join sc_mst.lvljabatan b on a.kdlvl=b.kdlvl
								where trim(kdgrade)='$kdgrade'");	
	
	}
	
	function chain_jobgrade(){
		return $this->db->query("select a.kdjabatan,a.nmjabatan,b.kdgrade ,b.nmgrade from sc_mst.jabatan a
		join sc_mst.jobgrade b on a.kdgrade=b.kdgrade");
	}

				
	
	
	function q_lvljabatan(){
		return $this->db->query("select * from sc_mst.lvljabatan order by kdlvl asc");
	}
	
	function q_ceklvljabatan($kdlvl){
		return $this->db->query("select * from sc_mst.lvljabatan where trim(kdlvl)='$kdlvl'");
	}

	function q_lvlgp($param = "") {
	    return $this->db->query("
            SELECT a.*, b.kdgrade 
            FROM sc_mst.m_lvlgp a
            LEFT JOIN sc_mst.jobgrade b ON a.kdlvlgp BETWEEN b.kdlvlgpmin AND b.kdlvlgpmax
            WHERE a.kdlvlgp IS NOT NULL AND a.c_hold = 'NO' 
            $param 
            ORDER BY a.kdlvlgp");
    }

    function q_m_grade_jabatan(){
        return $this->db->query("select * from sc_mst.m_grade_jabatan order by nmgradejabatan asc ");
    }
}



