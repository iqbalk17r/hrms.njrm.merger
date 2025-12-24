<?php
class M_borong extends CI_Model{
	function q_borong(){
		return $this->db->query("select * from sc_mst.borong order by kdborong asc");
	}
	
	function q_cekborong($kdborong){
		return $this->db->query("select * from sc_mst.borong where trim(kdborong)='$kdborong'");
	}
	
	function q_sub_borong(){
		return $this->db->query("select a.*,b.nmborong from sc_mst.sub_borong a 
								left outer join sc_mst.borong b on a.kdborong=b.kdborong 
								order by kdsub_borong asc");
	}
	
	function q_ceksub_borong($kdsub_borong){
		return $this->db->query("select * from sc_mst.sub_borong where trim(kdsub_borong)='$kdsub_borong'");
	}
	
	function q_target_borong(){
		return $this->db->query("select a.*,b.nmborong,c.nmsub_borong from sc_mst.target_borong a 
								left outer join sc_mst.borong b on a.kdborong=b.kdborong 
								left outer join sc_mst.sub_borong c on a.kdsub_borong=c.kdsub_borong
								order by a.kdsub_borong asc");
	}
	function q_target_borong_edit($no_urut){
		return $this->db->query("select a.*,b.nmborong,c.nmsub_borong from sc_mst.target_borong a 
								left outer join sc_mst.borong b on a.kdborong=b.kdborong 
								left outer join sc_mst.sub_borong c on a.kdsub_borong=c.kdsub_borong
								where no_urut='$no_urut'
								order by a.kdsub_borong asc");
	}
	
	//cek sebelum hapus()
	function cek_del_borong($kdborong){
		return $this->db->query("select * from sc_mst.sub_borong where trim(kdborong)='$kdborong'")->num_rows();
	}
	
	function cek_del_sub_borong($kdborong,$kdsub_borong){
		return $this->db->query("select * from sc_mst.target_borong where trim(kdborong)='$kdborong' and trim(kdsub_borong)='$kdsub_borong'")->num_rows();
	}
	

}	