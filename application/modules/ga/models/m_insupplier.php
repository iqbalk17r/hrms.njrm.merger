<?php
class M_insupplier extends CI_Model{
	
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}

	function q_jsupplier($param){
	    return $this->db->query("select * from (
                                select kdtrx as kdjsupplier,uraian as nmjsupplier,jenistrx from sc_mst.trxtype) as x
                                where jenistrx='JSUPPLIER' $param order by nmjsupplier ");
    }

	function q_kdsupplier_param($param){
		return $this->db->query("select 
                                trim(coalesce(kdsupplier   ::text,''))as  kdsupplier,
                                trim(coalesce(kdgroup   ::text,''))as  kdgroup,
                                trim(coalesce(nmsupplier   ::text,''))as  nmsupplier  
                                from sc_mst.msupplier where kdsupplier is not null $param  
                                order by nmsupplier asc ");
	}
	
	function q_kdsubsupplier_param($param){
		return $this->db->query("select trim(coalesce(kdsubsupplier::text,'')) as kdsubsupplier  ,
                                trim(coalesce(kdsupplier::text,'')) as kdsupplier        ,
                                trim(coalesce(nmsubsupplier::text,'')) as nmsubsupplier,
                                trim(coalesce(kdcabang::text,'')) as kdcabang            ,
                                trim(coalesce(addsupplier::text,'')) as addsupplier      ,
                                trim(coalesce(npwp::text,'')) as npwp                    ,
                                trim(coalesce(npwpdate::text,'')) as npwpdate            ,
                                trim(coalesce(pkp::text,'')) as pkp                      ,
                                trim(coalesce(pkpname::text,'')) as pkpname              ,
                                trim(coalesce(phone1::text,'')) as phone1                ,
                                trim(coalesce(phone2::text,'')) as phone2                ,
                                trim(coalesce(fax::text,'')) as fax                      ,
                                trim(coalesce(email::text,'')) as email                  ,
                                trim(coalesce(ownsupplier::text,'')) as ownsupplier      ,
                                trim(coalesce(keterangan::text,'')) as keterangan from sc_mst.msubsupplier where kdsubsupplier is not null $param ");
	}

	function q_karyawan($param){
		return $this->db->query("select coalesce(trim(branch              ::text),'') as branch              ,
										coalesce(trim(nik                 ::text),'') as nik                 ,
										coalesce(trim(nmlengkap           ::text),'') as nmlengkap           ,
										coalesce(trim(callname            ::text),'') as callname            ,
										coalesce(trim(jk                  ::text),'') as jk                  ,
										coalesce(trim(neglahir            ::text),'') as neglahir            ,
										coalesce(trim(provlahir           ::text),'') as provlahir           ,
										coalesce(trim(kotalahir           ::text),'') as kotalahir           ,
										coalesce(trim(tgllahir            ::text),'') as tgllahir            ,
										coalesce(trim(kd_agama            ::text),'') as kd_agama            ,
										coalesce(trim(stswn               ::text),'') as stswn               ,
										coalesce(trim(stsfisik            ::text),'') as stsfisik            ,
										coalesce(trim(ketfisik            ::text),'') as ketfisik            ,
										coalesce(trim(noktp               ::text),'') as noktp               ,
										coalesce(trim(ktp_seumurhdp       ::text),'') as ktp_seumurhdp       ,
										coalesce(trim(ktpdikeluarkan      ::text),'') as ktpdikeluarkan      ,
										coalesce(trim(tgldikeluarkan      ::text),'') as tgldikeluarkan      ,
										coalesce(trim(status_pernikahan   ::text),'') as status_pernikahan   ,
										coalesce(trim(gol_darah           ::text),'') as gol_darah           ,
										coalesce(trim(negktp              ::text),'') as negktp              ,
										coalesce(trim(provktp             ::text),'') as provktp             ,
										coalesce(trim(kotaktp             ::text),'') as kotaktp             ,
										coalesce(trim(kecktp              ::text),'') as kecktp              ,
										coalesce(trim(kelktp              ::text),'') as kelktp              ,
										coalesce(trim(alamatktp           ::text),'') as alamatktp           ,
										coalesce(trim(negtinggal          ::text),'') as negtinggal          ,
										coalesce(trim(provtinggal         ::text),'') as provtinggal         ,
										coalesce(trim(kotatinggal         ::text),'') as kotatinggal         ,
										coalesce(trim(kectinggal          ::text),'') as kectinggal          ,
										coalesce(trim(keltinggal          ::text),'') as keltinggal          ,
										coalesce(trim(alamattinggal       ::text),'') as alamattinggal       ,
										coalesce(trim(nohp1               ::text),'') as nohp1               ,
										coalesce(trim(nohp2               ::text),'') as nohp2               ,
										coalesce(trim(npwp                ::text),'') as npwp                ,
										coalesce(trim(tglnpwp             ::text),'') as tglnpwp             ,
										coalesce(trim(bag_dept            ::text),'') as bag_dept            ,
										coalesce(trim(subbag_dept         ::text),'') as subbag_dept         ,
										coalesce(trim(jabatan             ::text),'') as jabatan             ,
										coalesce(trim(lvl_jabatan         ::text),'') as lvl_jabatan         ,
										coalesce(trim(grade_golongan      ::text),'') as grade_golongan      ,
										coalesce(trim(nik_atasan          ::text),'') as nik_atasan          ,
										coalesce(trim(nik_atasan2         ::text),'') as nik_atasan2         ,
										coalesce(trim(status_ptkp         ::text),'') as status_ptkp         ,
										coalesce(trim(besaranptkp         ::text),'') as besaranptkp         ,
										coalesce(trim(tglmasukkerja       ::text),'') as tglmasukkerja       ,
										coalesce(trim(tglkeluarkerja      ::text),'') as tglkeluarkerja      ,
										coalesce(trim(masakerja           ::text),'') as masakerja           ,
										coalesce(trim(statuskepegawaian   ::text),'') as statuskepegawaian   ,
										coalesce(trim(kdcabang            ::text),'') as kdcabang            ,
										coalesce(trim(branchaktif         ::text),'') as branchaktif         ,
										coalesce(trim(grouppenggajian     ::text),'') as grouppenggajian     ,
										coalesce(trim(gajipokok           ::text),'') as gajipokok           ,
										coalesce(trim(gajibpjs            ::text),'') as gajibpjs            ,
										coalesce(trim(namabank            ::text),'') as namabank            ,
										coalesce(trim(namapemilikrekening ::text),'') as namapemilikrekening ,
										coalesce(trim(norek               ::text),'') as norek               ,
										coalesce(trim(tjshift             ::text),'') as tjshift             ,
										coalesce(trim(idabsen             ::text),'') as idabsen             ,
										coalesce(trim(email               ::text),'') as email               ,
										coalesce(trim(bolehcuti           ::text),'') as bolehcuti           ,
										coalesce(trim(sisacuti            ::text),'') as sisacuti            ,
										coalesce(trim(inputdate           ::text),'') as inputdate           ,
										coalesce(trim(inputby             ::text),'') as inputby             ,
										coalesce(trim(updatedate          ::text),'') as updatedate          ,
										coalesce(trim(updateby            ::text),'') as updateby            ,
										coalesce(trim(image               ::text),'') as image               ,
										coalesce(trim(idmesin             ::text),'') as idmesin             ,
										coalesce(trim(cardnumber          ::text),'') as cardnumber          ,
										coalesce(trim(status              ::text),'') as status              ,
										coalesce(trim(tgl_ktp             ::text),'') as tgl_ktp             ,
										coalesce(trim(costcenter          ::text),'') as costcenter          ,
										coalesce(trim(tj_tetap            ::text),'') as tj_tetap            ,
										coalesce(trim(gajitetap           ::text),'') as gajitetap           ,
										coalesce(trim(gajinaker           ::text),'') as gajinaker           ,
										coalesce(trim(tjlembur            ::text),'') as tjlembur            ,
										coalesce(trim(tjborong            ::text),'') as tjborong            ,
										coalesce(trim(kdregu              ::text),'') as kdregu              ,
										coalesce(trim(nmdept              ::text),'') as nmdept              ,
										coalesce(trim(nmsubdept           ::text),'') as nmsubdept           ,
										coalesce(trim(nmlvljabatan        ::text),'') as nmlvljabatan        ,
										coalesce(trim(nmjabatan           ::text),'') as nmjabatan           ,
										coalesce(trim(nmatasan            ::text),'') as nmatasan            ,
										coalesce(trim(nmatasan2           ::text),'') as nmatasan2            from 
								(select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.tglkeluarkerja is null) as x where nik is not null $param
								");
	}
	
}


