<?php
class M_cuti extends CI_Model{
	
	function q_pegawai($nip=null){
		if (empty($nip)) {
			$pegnip=" ";
		} else {			
			$pegnip=" where nip='$nip'";
		}
		return $this->db->query("select * from sc_hrd.pegawai $pegnip");
	}
	function q_jmlcuti($nip){
		return $this->db->query("select a.nip,a.nipatasan,e.nmlengkap as nmatasan,a.kddept,departement,a.kdjabatan,d.deskripsi,a.nmlengkap,tahun,totalcuti,pakaicuti,b.sisacuti from sc_hrd.pegawai a
								left outer join sc_hrd.jumlahcuti b on a.nip=b.nip
								left outer join sc_hrd.departement c on a.kddept=c.kddept
								left outer join sc_hrd.jabatan d on d.kdjabatan=a.kdjabatan
								left outer join sc_hrd.pegawai e on a.nipatasan=e.nip
								where a.nip='$nip' and tahun=to_char(now(),'YYYY')
								order by a.nip,b.tahun");
	}
	
	function q_cuti_in($tgl){		
		return $this->db->query("select a.branch, a.nip, nodokumen, c.departement,b.nmlengkap,e.nmlengkap as atasan, f.nmlengkap as pengganti,
								d.deskripsi,kddokumen, to_char(tglmulai,'DD-MM-YYYY') as tglmulai,to_char(tglahir,'DD-MM-YYYY') as tglahir,
								jmlcuti, keterangan, edit, a.editby, tahun, tglmasuk, a.sisacuti, alamatcuti,
								  notlpcuti, inputby, inputdate, a.status, flag 
								from sc_hrd.cuti a 
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.departement c on c.kddept=b.kddept
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kddept=b.kddept and d.kdsubdept=b.kdsubdept
								left outer join sc_hrd.pegawai e on a.atasan=e.nip
								left outer join sc_hrd.pegawai f on a.pengganti=f.nip
								where a.status='I' and to_char(inputdate,'mmYYYY')='$tgl'
								");
	}
	function q_cuti_ap($tgl){
		return $this->db->query("select a.branch, a.nip, nodokumen, c.departement,b.nmlengkap,e.nmlengkap as atasan, f.nmlengkap as pengganti,
								d.deskripsi,kddokumen, to_char(tglmulai,'DD-MM-YYYY') as tglmulai,to_char(tglahir,'DD-MM-YYYY') as tglahir,
								jmlcuti, keterangan, edit, a.editby, tahun, tglmasuk, a.sisacuti, alamatcuti,
								  notlpcuti, inputby, inputdate, a.status, flag 
								from sc_hrd.cuti a 
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.departement c on c.kddept=b.kddept
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kddept=b.kddept and d.kdsubdept=b.kdsubdept
								left outer join sc_hrd.pegawai e on a.atasan=e.nip
								left outer join sc_hrd.pegawai f on a.pengganti=f.nip
								where a.status='F' and to_char(inputdate,'mmYYYY')='$tgl'
								");
	}
	function q_cuti_ca($tgl){
		return $this->db->query("select a.branch, a.nip, nodokumen, c.departement,b.nmlengkap,e.nmlengkap as atasan, f.nmlengkap as pengganti,
								d.deskripsi,kddokumen, to_char(tglmulai,'DD-MM-YYYY') as tglmulai,to_char(tglahir,'DD-MM-YYYY') as tglahir,
								jmlcuti, keterangan, edit, a.editby, tahun, tglmasuk, a.sisacuti, alamatcuti,
								  notlpcuti, inputby, inputdate, a.status, flag 
								from sc_hrd.cuti a 
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.departement c on c.kddept=b.kddept
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kddept=b.kddept and d.kdsubdept=b.kdsubdept
								left outer join sc_hrd.pegawai e on a.atasan=e.nip
								left outer join sc_hrd.pegawai f on a.pengganti=f.nip
								where a.status='C' and to_char(inputdate,'mmYYYY')='$tgl'
								");
	}	
	function q_cuti($tgl){
		return $this->db->query("select a.branch, a.nip, nodokumen, c.departement,b.nmlengkap,e.nmlengkap as atasan, f.nmlengkap as pengganti,
								d.deskripsi,kddokumen, to_char(tglmulai,'DD-MM-YYYY') as tglmulai,to_char(tglahir,'DD-MM-YYYY') as tglahir,
								jmlcuti, keterangan, edit, a.editby, tahun, tglmasuk, a.sisacuti, alamatcuti,
								  notlpcuti, inputby, inputdate, a.status, flag 
								from sc_hrd.cuti a 
								left outer join sc_hrd.pegawai b on a.nip=b.nip
								left outer join sc_hrd.departement c on c.kddept=b.kddept
								left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kddept=b.kddept and d.kdsubdept=b.kdsubdept
								left outer join sc_hrd.pegawai e on a.atasan=e.nip
								left outer join sc_hrd.pegawai f on a.pengganti=f.nip					
								where to_char(inputdate,'mmYYYY')='$tgl'
								");
	}	
	
	function cek_param_cuti(){
		return $this->db->query("select * from sc_hrd.option where kodeopt='STR-H-CUTI'");
	}
	
	function q_departement(){
		return $this->db->query("select * from sc_hrd.departement");
	}
	
	function q_jabatan(){
		return $this->db->query("select * from sc_hrd.jabatan");
	}
	
	function q_sisa(){
		if($this->session->userdata('level')=='E' or $this->session->userdata('level')=='D'){
			$nip=$this->session->userdata('nip');
			$peg=" and a.nip='$nip' ";
		} else
		{
			$peg=" ";
		}
		return $this->db->query("select * 
								from sc_hrd.pegawai a
								left outer join sc_hrd.jabatan b on b.kddept=a.kddept and  b.kdsubdept=a.kdsubdept and a.kdjabatan=b.kdjabatan
								left outer join sc_hrd.departement c on a.kddept=c.kddept
								left outer join sc_hrd.subdepartement d on d.kdsubdept=a.kdsubdept and a.kddept=d.kddept
								left outer join sc_hrd.jumlahcuti e on e.nip=a.nip
								where 
								tahun=to_char(now(),'YYYY') $peg order by a.nip");
	}
	
	function simpan_cuti($info){
		$this->db->insert("sc_tmp.cuti",$info);
	}
	
	function up_tr_cuti($nip){
		return $this->db->query("update sc_tmp.cuti set status='I' where nip='$nip'");
	}
	function get_nodok($nip){
		return $this->db->query("select nodokumen from sc_hrd.cuti where nip='$nip' and status='I' ");
	}
	
	function tr_cuti_app($nodokumen){
		return $this->db->query("update sc_hrd.cuti set status='F' where nodokumen='$nodokumen'");
	}
	
	function tr_resendsms_cuti($nodokumen){
		return $this->db->query("update sc_hrd.cuti set status='I' where nodokumen='$nodokumen'");
	}
	
	function q_cuti_cancel($nodokumen){
		return $this->db->query("update sc_hrd.cuti set status='C' where nodokumen='$nodokumen'");
	}

}
