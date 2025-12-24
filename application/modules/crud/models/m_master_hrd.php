<?php
class M_master_hrd extends CI_Model{
	//departement
	function q_departement($kddept){
		if (empty($kddept)){
			return $this->db->query("select * from sc_hrd.departement");
		} else {
			return $this->db->query("select * from sc_hrd.departement where kddept='$kddept'");
		}		
	}
	
	function simpandept($info_dept){
		$this->db->insert('sc_hrd.departement',$info_dept);
	} 
	
	function editdept($info_dept,$kddept){
		$this->db->where('kddept',$kddept);
		$this->db->update('sc_hrd.departement',$info_dept);
	}
	//subdepartement	
	function q_subdept($kddept,$kdsubdept){
		if (empty($kddept)){
			return $this->db->query("select a.*,b.departement from sc_hrd.subdepartement a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								");
		} else {
			return $this->db->query("select a.*,b.departement from sc_hrd.subdepartement a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								where a.kddept='$kddept' and kdsubdept='$kdsubdept'
								");
		}
	}
	
	function simpansubdept($info_subdept){
		$this->db->insert('sc_hrd.subdepartement',$info_subdept);
	}
	
	function editsubdept($info_subdept,$kddept,$kdsubdept){
		$this->db->where('kddept',$kddept);
		$this->db->where('kdsubdept',$kdsubdept);
		$this->db->update('sc_hrd.subdepartement',$info_subdept);
	}
	
	
	function q_jabatan($kddept,$kdsubdept,$kdjabt){
		if (empty($kddept)){
			return $this->db->query("select a.*,b.departement,c.subdepartement from sc_hrd.jabatan a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								left outer join sc_hrd.subdepartement c on a.kdsubdept=c.kdsubdept and a.kddept=c.kddept
								");
		} else {
			return $this->db->query("select a.*,b.departement,c.subdepartement from sc_hrd.jabatan a
								left outer join sc_hrd.departement b on a.kddept=b.kddept
								left outer join sc_hrd.subdepartement c on a.kdsubdept=c.kdsubdept and a.kddept=c.kddept
								where a.kddept='$kddept' and a.kdsubdept='$kdsubdept' and a.kdjabatan='$kdjabt'
								");
		}
	}
	
	function simpanjabt($info_jabt){
		$this->db->insert('sc_hrd.jabatan',$info_jabt);
	}
	
	function edit_jabt($info_jabt,$kddept,$kdsubdept,$kdjabt){
		$this->db->where('kddept',$kddept);
		$this->db->where('kdsubdept',$kdsubdept);
		$this->db->where('kdjabatan',$kdjabt);
		$this->db->update('sc_hrd.jabatan',$info_jabt);
	}
	//kantor
	function q_kantor($kdkantor){
		if (empty($kdkantor)){
			return $this->db->query("select * from sc_mst.kantor");
		} else {
			return $this->db->query("select * from sc_mst.kantor where kodecabang='$kdkantor'");
		}
	}
	
	function simpankantor($info_kantor){
		$this->db->insert('sc_mst.kantor',$info_kantor);
	}
	
	function edit_kantor($info_ekantor,$kdcab){
		$this->db->where('kodecabang',$kdcab);
		$this->db->update('sc_mst.kantor',$info_ekantor);
	}
	function hapus_kantor($kdcab){
		$this->db->where('kodecabang',$kdcab);
		$this->db->delete('sc_mst.kantor');
	}
	//EOY
	function q_eoy($tahun='2015'){
		return $this->db->query("select 
						extract(Day from last_day(to_date('$tahun-01','YYYY-MM'))) as jan,
						extract(Day from last_day(to_date('$tahun-02','YYYY-MM')))as feb,
						extract(Day from last_day(to_date('$tahun-03','YYYY-MM')))as mar,
						extract(Day from last_day(to_date('$tahun-04','YYYY-MM')))as apr,
						extract(Day from last_day(to_date('$tahun-05','YYYY-MM')))as mei,
						extract(Day from last_day(to_date('$tahun-06','YYYY-MM')))as jun,
						extract(Day from last_day(to_date('$tahun-07','YYYY-MM')))as jul,
						extract(Day from last_day(to_date('$tahun-08','YYYY-MM')))as ags,
						extract(Day from last_day(to_date('$tahun-09','YYYY-MM')))as sep,
						extract(Day from last_day(to_date('$tahun-10','YYYY-MM')))as okt,
						extract(Day from last_day(to_date('$tahun-11','YYYY-MM')))as nov,
						extract(Day from last_day(to_date('$tahun-12','YYYY-MM'))) as des"
						);
	}
	
	function q_option(){
		return $this->db->query("select * from sc_hrd.option");
	}
}
