<?php
class M_bpjs extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	function list_bpjskomponen(){
		return $this->db->query("select * from sc_mst.komponen_bpjs");
	}
	
	function list_ptkp(){
		return $this->db->query("select * from sc_mst.ptkp order by kodeptkp");
	}
	
	function list_bracket(){
		return $this->db->query("select * from sc_mst.bracket");
	}
	
	function list_faskes(){
		return $this->db->query("select * from sc_mst.faskes_bpjs");
	}	
	
	
	//list option
	function dtl_jnsbpjs($kodebpjs){
		return $this->db->query("select * from sc_mst.jenis_bpjs where kode_bpjs='$kodebpjs'")->row_array();
	}
	
	function dtl_ptkp($kode){
		return $this->db->query("select * from sc_mst.ptkp where kodeptkp='$kode'")->row_array();
	}
	
	function dtl_bracket($kode){
		return $this->db->query("select * from sc_mst.bracket where nourut='$kode'")->row_array();
	}
	
	function dtl_faskes($kode){
		return $this->db->query("select * from sc_mst.faskes_bpjs where kodefaskes='$kode'")->row_array();
	}
	
	function dtl_bpjskomponen($kodekomponen){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kodekomponen='$kodekomponen'")->row_array();
	}
	//buat controller riwayat keluarga
	function q_bpjs_karyawan(){
		return $this->db->query("select a.*,b.nama_bpjs,c.namakomponen,d.namafaskes,f.namafaskes as namafaskes2,e.nmlengkap from sc_trx.bpjs_karyawan a 
									left outer join sc_mst.jenis_bpjs b on a.kode_bpjs=b.kode_bpjs  
									left outer join sc_mst.komponen_bpjs c on a.kodekomponen=c.kodekomponen
									left outer join sc_mst.faskes_bpjs d on a.kodefaskes=d.kodefaskes
									left outer join sc_mst.faskes_bpjs f on a.kodefaskes2=f.kodefaskes
									left outer join sc_mst.karyawan e on a.nik=e.nik
									order by nik desc");
	}
	//buat controller bpjs karyawan
	function list_bpjs_karyawan($nik){
		return $this->db->query("select a.*,b.nama_bpjs,c.namakomponen,d.namafaskes,f.namafaskes as namafaskes2,e.nmlengkap,g.uraian, 
									to_char(tgl_berlaku,'DD-MM-YYYY') as tgl_berlaku1 from sc_trx.bpjs_karyawan a 
									left outer join sc_mst.jenis_bpjs b on a.kode_bpjs=b.kode_bpjs  
									left outer join sc_mst.komponen_bpjs c on a.kodekomponen=c.kodekomponen
									left outer join sc_mst.faskes_bpjs d on a.kodefaskes=d.kodefaskes
									left outer join sc_mst.faskes_bpjs f on a.kodefaskes2=f.kodefaskes
									left outer join sc_mst.karyawan e on a.nik=e.nik
									left outer join sc_mst.trxtype g on a.kelas=g.kdtrx and g.jenistrx='KELAS BPJS'
									where a.nik='$nik'
									order by nik desc");
	}
	function q_cek_bpjs($kode_bpjs,$nik,$kodekomponen,$id_bpjs){
		return $this->db->query("select * from sc_trx.bpjs_karyawan
								where nik='$nik' and kode_bpjs='$kode_bpjs' and kodekomponen='$kodekomponen' and id_bpjs='$id_bpjs'");
	}
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.lv_m_karyawan where coalesce(statuskepegawaian,'')!='KO' order by nmlengkap asc");
		
	}
	
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nik'");
		
	}
	
	function q_trxtype(){
		return $this->db->query("select * from sc_mst.trxtype
								where jenistrx='KELAS BPJS' ");
	}
	
	//cek seblum hapus
	function cek_del_negara($kodenegara){
		return $this->db->query("select * from sc_mst.provinsi where trim(kodenegara)='$kodenegara'")->num_rows();
	}
	
	function cek_del_prov($kodenegara,$kodeprov){
		return $this->db->query("select * from sc_mst.provinsi where trim(kodenegara)='$kodenegara' and trim(kodeprov)='$kodeprov'")->num_rows();
	}
	
	function cek_del_bpjs($kodebpjs,$kodekomp){
		return $this->db->query("select * from sc_trx.bpjs_karyawan where trim(kode_bpjs)='$kodebpjs' and trim(kodekomponen)='$kodekomp'")->num_rows();
	}
	
	function user_profile(){
		$kodenegara=$this->session->userdata('nik');
		return $this->db->query("select * from sc_mst.user where nik='$kodenegara'");
	}
	// cek seblum input
	function cek_jnsbpjs($kode_bpjs){
		return $this->db->query("select * from sc_mst.jenis_bpjs where kode_bpjs='$kode_bpjs'")->num_rows();
	}
	
	function cek_ptkp($kode){
		return $this->db->query("select * from sc_mst.ptkp where kodeptkp='$kode'")->num_rows();
	}
	
	function cek_bracket($kode){
		return $this->db->query("select * from sc_mst.bracket where tipe='$kode'")->num_rows();
	}
	
	function cek_faskes($kode){
		return $this->db->query("select * from sc_mst.faskes_bpjs where kodefaskes='$kode'")->num_rows();
	}
	
	function cek_bpjskomponen($kode_bpjs,$kodekompbjps){
		return $this->db->query("select * from sc_mst.komponen_bpjs where kode_bpjs='$kode_bpjs' and kodekomponen='$kodekompbjps'")->num_rows();
	}
}


