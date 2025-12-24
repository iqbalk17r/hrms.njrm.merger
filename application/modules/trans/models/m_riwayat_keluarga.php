<?php
class M_riwayat_keluarga extends CI_Model{
	
	function list_jnsbpjs(){
		return $this->db->query("select * from sc_mst.jenis_bpjs");
	}
	
	function list_bpjskomponen(){
		return $this->db->query("select * from sc_mst.komponen_bpjs");
	}
	
	function list_ptkp(){
		return $this->db->query("select * from sc_mst.ptkp");
	}
	
	function list_bracket(){
		return $this->db->query("select * from sc_mst.bracket");
	}
	
	function list_faskes(){
		return $this->db->query("select * from sc_mst.faskes_bpjs");
	}	
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan 
								order by nmlengkap asc");
		
	}
	
	function list_keluarga(){
		return $this->db->query("select * from sc_mst.keluarga");
	}
	function list_karyawan_index($nik){
		return $this->db->query("select * from sc_mst.karyawan where trim(nik)='$nik'");
	}
	
	function list_negara(){
		return $this->db->query("select * from sc_mst.negara");
	}
	
	function list_prov(){
		return $this->db->query("select * from sc_mst.provinsi a
								 left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
								 order by b.namanegara,namaprov asc");
	}	
	
	function list_kotakab(){
		return $this->db->query("select * from sc_mst.kotakab a
								 left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
								 left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov
								 order by b.namanegara,c.namaprov,a.namakotakab asc");
	}
	
	function list_jenjang_pendidikan(){
		return $this->db->query("select * from sc_mst.jenjang_pendidikan order by nmjenjang_pendidikan asc");
	}
	
	function q_riwayat_keluarga($nik,$no_urut){
		return $this->db->query("select to_char(a.tgl_lahir,'dd-mm-yyyy')as tgl_lahir1,
									to_char(a.npwp_tgl,'dd-mm-yyyy')as npwp_tgl1,
									to_char(a.tgl_berlaku,'dd-mm-yyyy')as tgl_berlaku1,
									a.*,case 
									when a.status_tanggungan='T' then 'YA'
									when a.status_tanggungan='F' then 'TIDAK'
									end as status_tanggungan1,
									b.nmlengkap,c.nmkeluarga,d.namanegara,e.namaprov,f.namakotakab,g.nmjenjang_pendidikan,
									h.nama_bpjs,i.namakomponen,j.namafaskes,k.namafaskes as namafaskes2,l.uraian
									from sc_trx.riwayat_keluarga a
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.keluarga c on a.kdkeluarga=c.kdkeluarga
									left outer join sc_mst.negara d on a.kodenegara=d.kodenegara
									left outer join sc_mst.provinsi e on a.kodeprov=e.kodeprov and a.kodenegara=e.kodenegara
									left outer join sc_mst.kotakab f on a.kodekotakab=f.kodekotakab 
									left outer join sc_mst.jenjang_pendidikan g on a.kdjenjang_pendidikan=g.kdjenjang_pendidikan
									left outer join sc_mst.jenis_bpjs h on a.kode_bpjs=h.kode_bpjs
									left outer join sc_mst.komponen_bpjs i on a.kodekomponen=i.kodekomponen and a.kode_bpjs=i.kode_bpjs
									left outer join sc_mst.faskes_bpjs j on a.kodefaskes=j.kodefaskes
									left outer join sc_mst.faskes_bpjs k on a.kodefaskes2=k.kodefaskes
									left outer join sc_mst.trxtype l on a.kelas=l.kdtrx and jenistrx='KELAS BPJS'
									where a.nik='$nik' 
									order by no_urut asc");
	}
	
	function q_riwayat_keluarga_edit($nik,$no_urut){
		return $this->db->query("select to_char(a.tgl_lahir,'dd-mm-yyyy')as tgl_lahir1,
									to_char(a.npwp_tgl,'dd-mm-yyyy')as npwp_tgl1,
									to_char(a.tgl_berlaku,'dd-mm-yyyy')as tgl_berlaku1,
									a.*,
									case 
									when a.status_tanggungan='T' then 'YA'
									when a.status_tanggungan='F' then 'TIDAK'
									end as status_tanggungan1,
									case 
									when a.status_hidup='T' then 'MASIH HIDUP'
									when a.status_hidup='F' then 'MENINGGAL'
									end as status_hidup1,
									b.nmlengkap,c.nmkeluarga,d.namanegara,e.namaprov,f.namakotakab,g.nmjenjang_pendidikan,h.nama_bpjs,
									i.namakomponen,j.namafaskes,k.namafaskes as namafaskes2,l.uraian
									from sc_trx.riwayat_keluarga a
									left outer join sc_mst.karyawan b on a.nik=b.nik
									left outer join sc_mst.keluarga c on a.kdkeluarga=c.kdkeluarga
									left outer join sc_mst.negara d on a.kodenegara=d.kodenegara
									left outer join sc_mst.provinsi e on a.kodeprov=e.kodeprov and a.kodenegara=e.kodenegara
									left outer join sc_mst.kotakab f on a.kodekotakab=f.kodekotakab 
									left outer join sc_mst.jenjang_pendidikan g on a.kdjenjang_pendidikan=g.kdjenjang_pendidikan
									left outer join sc_mst.jenis_bpjs h on a.kode_bpjs=h.kode_bpjs
									left outer join sc_mst.komponen_bpjs i on a.kodekomponen=i.kodekomponen and a.kode_bpjs=i.kode_bpjs
									left outer join sc_mst.faskes_bpjs j on a.kodefaskes=j.kodefaskes
									left outer join sc_mst.faskes_bpjs k on a.kodefaskes2=k.kodefaskes
									left outer join sc_mst.trxtype l on a.kelas=l.kdtrx and jenistrx='KELAS BPJS'
									where a.nik='$nik' and a.no_urut='$no_urut'
									order by no_urut asc");
	}
}	