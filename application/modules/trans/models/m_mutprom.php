<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mutprom extends CI_Model {

	function get_mutasi($nik)
	{
		return $this->db->query("select 'A' as tipe,b.nmdept as olddept,c.nmdept as newdept,
								d.nmsubdept as newsubdept,e.nmsubdept as oldsubdept,
								f.nmjabatan as newjabatan,g.nmjabatan as oldjabatan,
								j.nmlvljabatan as newlevel,i.nmlvljabatan as oldlevel,
								k.nmlengkap as oldatasan,l.nmlengkap as newatasan,
								a.* from sc_tmp.mutasi a
								left outer join sc_mst.departmen b on a.oldkddept=b.kddept
								left outer join sc_mst.departmen c on a.newkddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.newkdsubdept=d.kdsubdept
								left outer join sc_mst.subdepartmen e on a.oldkdsubdept=e.kdsubdept
								left outer join sc_mst.jabatan f on a.newkdjabatan=f.kdjabatan
								left outer join sc_mst.jabatan g on a.oldkdjabatan=g.kdjabatan
								left outer join sc_mst.lvljabatan i on a.oldkdlevel=i.kdlvl
								left outer join sc_mst.lvljabatan j on a.newkdlevel=j.kdlvl
								left outer join sc_mst.karyawan k on a.oldnikatasan=k.nik
								left outer join sc_mst.karyawan l on a.newnikatasan=l.nik
								where a.nik='$nik'
								union all
								select 'B' as tipe,b.nmdept as olddept,c.nmdept as newdept,
								d.nmsubdept as newsubdept,e.nmsubdept as oldsubdept,
								f.nmjabatan as newjabatan,g.nmjabatan as oldjabatan,
								j.nmlvljabatan as newlevel,i.nmlvljabatan as oldlevel,
								k.nmlengkap as oldatasan,l.nmlengkap as newatasan,
								a.* from sc_mst.mutasi a
								left outer join sc_mst.departmen b on a.oldkddept=b.kddept
								left outer join sc_mst.departmen c on a.newkddept=c.kddept
								left outer join sc_mst.subdepartmen d on a.newkdsubdept=d.kdsubdept
								left outer join sc_mst.subdepartmen e on a.oldkdsubdept=e.kdsubdept
								left outer join sc_mst.jabatan f on a.newkdjabatan=f.kdjabatan
								left outer join sc_mst.jabatan g on a.oldkdjabatan=g.kdjabatan
								left outer join sc_mst.lvljabatan i on a.oldkdlevel=i.kdlvl
								left outer join sc_mst.lvljabatan j on a.newkdlevel=j.kdlvl
								left outer join sc_mst.karyawan k on a.oldnikatasan=k.nik
								left outer join sc_mst.karyawan l on a.newnikatasan=l.nik
								where a.nik='$nik' order by nodokumen");
	}
}
