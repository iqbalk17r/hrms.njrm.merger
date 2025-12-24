<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class M_mutpromot extends CI_Model {

	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(statuskepegawaian),'')!='KO'");
	}
	
	function list_nik($id){
		return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(statuskepegawaian),'')!='KO' and nik='$id'");
	}
	
	function get_mutasi()
	{
		return $this->db->query(" select a.status,b.nmdept as olddept,c.nmdept as newdept,
											d.nmsubdept as newsubdept,e.nmsubdept as oldsubdept,
											f.nmjabatan as newjabatan,g.nmjabatan as oldjabatan,
											j.nmlvljabatan as newlevel,i.nmlvljabatan as oldlevel,
											k.nmlengkap as oldatasan,l.nmlengkap as newatasan,m.nmlengkap as newatasan2,
											a.* from sc_mst.mutasi a
											left outer join sc_mst.departmen b on a.oldkddept=b.kddept
											left outer join sc_mst.departmen c on a.newkddept=c.kddept
											left outer join sc_mst.subdepartmen d on a.newkdsubdept=d.kdsubdept and a.newkddept=d.kddept
											left outer join sc_mst.subdepartmen e on a.oldkdsubdept=e.kdsubdept and a.oldkddept=e.kddept
											left outer join sc_mst.jabatan f on a.newkdjabatan=f.kdjabatan and a.newkdsubdept=f.kdsubdept and a.newkddept=f.kddept
											left outer join sc_mst.jabatan g on a.oldkdjabatan=g.kdjabatan and a.oldkdsubdept=g.kdsubdept and a.oldkddept=g.kddept
											left outer join sc_mst.lvljabatan i on a.oldkdlevel=i.kdlvl
											left outer join sc_mst.lvljabatan j on a.newkdlevel=j.kdlvl
											left outer join sc_mst.karyawan k on a.oldnikatasan=k.nik
											left outer join sc_mst.karyawan l on a.newnikatasan=l.nik
											left outer join sc_mst.karyawan m on a.newnikatasan2=m.nik order by nodokumen
											");
		
	}
	function get_mutasinik($id)
	{
		return $this->db->query(" select a.status,b.nmdept as olddept,c.nmdept as newdept,
											d.nmsubdept as newsubdept,e.nmsubdept as oldsubdept,
											f.nmjabatan as newjabatan,g.nmjabatan as oldjabatan,
											j.nmlvljabatan as newlevel,i.nmlvljabatan as oldlevel,
											k.nmlengkap as oldatasan,l.nmlengkap as newatasan,m.nmlengkap as newatasan2,
											a.* from sc_mst.mutasi a
											left outer join sc_mst.departmen b on a.oldkddept=b.kddept
											left outer join sc_mst.departmen c on a.newkddept=c.kddept
											left outer join sc_mst.subdepartmen d on a.newkdsubdept=d.kdsubdept and a.newkddept=d.kddept
											left outer join sc_mst.subdepartmen e on a.oldkdsubdept=e.kdsubdept and a.oldkddept=e.kddept
											left outer join sc_mst.jabatan f on a.newkdjabatan=f.kdjabatan and a.newkdsubdept=f.kdsubdept and a.newkddept=f.kddept
											left outer join sc_mst.jabatan g on a.oldkdjabatan=g.kdjabatan and a.oldkdsubdept=g.kdsubdept and a.oldkddept=g.kddept
											left outer join sc_mst.lvljabatan i on a.oldkdlevel=i.kdlvl
											left outer join sc_mst.lvljabatan j on a.newkdlevel=j.kdlvl
											left outer join sc_mst.karyawan k on a.oldnikatasan=k.nik
											left outer join sc_mst.karyawan l on a.newnikatasan=l.nik
											left outer join sc_mst.karyawan m on a.newnikatasan2=m.nik
											where a.nik='$id'
											order by nodokumen

											");
		
	}
	
}
