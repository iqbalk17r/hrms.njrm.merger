<?php
class M_libur extends ci_model{
	
	function q_libur(){
		return $this->db->query("select * from sc_hrd.harilibur order by tgl");
	}
	
	function simpan_libur($info){
		$this->db->insert("sc_hrd.harilibur",$info);
	}
	
	function hapus($tgl){
        $this->db->where("tgl",$tgl);
        $this->db->delete("sc_hrd.harilibur");
    }
}