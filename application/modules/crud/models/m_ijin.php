<?php
class M_ijin extends CI_Model{
	function q_kodeatt($kode){
		if (empty($kode)) {
			return $this->db->query("select * from sc_hrd.kodeatt");
		} else {
			return $this->db->query("select * from sc_hrd.kodeatt where kdatt='$kode'");
		}
	}
	function peg($nip){
		return $this->db->query("select * from sc_hrd.pegawai where nip='$nip'");
	}
	
	function q_app_ijin(){
		return $this->db->query("update sc_hrd.pegawai set status='F' where id='$id'");
	}
	
	
	function q_list_ijin(){
		return $this->db->query("select a.*,b.nmlengkap,c.desc_kdatt,d.deskripsi,to_char(tglijin,'dd-mm-yyyy') as tgl,e.departement 
								from sc_hrd.ijin a
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.kodeatt c on c.kdatt=a.kdijin
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan
								left outer join sc_hrd.departement e on e.kddept=b.kddept");
	}
	
	function q_ijin_pdf($id){
		return $this->db->query("select a.*,b.nmlengkap,c.desc_kdatt,d.deskripsi,to_char(tglijin,'dd-mm-yyyy') as tgl,
								case to_char(tglijin,'dy')
								when 'mon' then 'Senin'
								when 'tue' then 'Selasa'
								when 'wed' then 'Rabu'
								when 'thu' then 'Kamis'
								when 'fri' then 'Jumat'
								when 'sat' then 'Sabtu'
								end as hari,
								e.departement 
								from sc_hrd.ijin a
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.kodeatt c on c.kdatt=a.kdijin
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan
								left outer join sc_hrd.departement e on e.kddept=b.kddept
								where id=$id");
	}
	
	function input_ijin($info_ijin){
		$this->db->insert('sc_hrd.ijin',$info_ijin);
	}
}
