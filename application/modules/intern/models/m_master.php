<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 1/23/20, 10:50 AM
 *  * Last Modified: 11/16/18, 9:56 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

class M_master extends CI_Model{


	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function q_trxerror($param){
		return $this->db->query("select * from 
									(select a.fc_userid,a.fc_errorcode,a.fc_nomorakhir1,a.fc_nomorakhir2,b.ft_descreiption as deskripsi from d_master..t_trxerror a
									left outer join d_master..t_error b on a.fc_errorcode=b.fc_errorcode) as a
									where fc_userid is not null	 $param");
	}
	function q_trxtype($param){
		return $this->db->query("select * from d_master..t_trxtype where fc_trx is not null ");
	}

	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from D_MASTER..T_TRXERROR where FC_USERID IS NOT NULL $paramtrxerror");
	}

	function q_branch(){
		$param=" and coalesce(cdefault,'')='YES'";
		return $this->db->query("select * from sc_mst.branch where branch is not null $param");
	}


	function q_expedisi(){
		return $this->db->query("select * from d_master..T_EXPEDISI ORDER BY FV_EXPDNAME ASC");
	}

	function q_gudang(){
		return $this->db->query("select * from d_master..T_GUDANG ORDER BY FC_LOCANAME ASC");
	}

	function q_insert_usermobile($userId){
		return $this->db->query("
          insert into sc_mst.t_user_mobile
          (branch,nik,username,passwordweb,level_id,level_akses,expdate,hold_id,inputdate,inputby,updatedate,updateby,
          lastlogin,image,loccode,erptype,id_device,lock_device,location,divisi,groupuser,idbu)
          (select branch,nik,username,passwordweb,level_id,level_akses,expdate,hold_id,inputdate,inputby,NULL AS updatedate,null as updateby,
lastlogin,image,loccode,'HRMS' as erptype,'XX' as id_device,'NO' as lock_device,
(select trim(kdcabang) from sc_mst.karyawan where nik in (select nik from sc_mst.user where username='$userId')) as location,
(select trim(bag_dept) from sc_mst.karyawan where nik in (select nik from sc_mst.user where username='$userId')) as divisi,'HRMS' as groupuser,'AA' as idbu  
from sc_mst.user where username='$userId' and username not in (select username from sc_mst.t_user_mobile));
		");
	}

	function q_mst_userhrms($param){
		return $this->db->query("
		select 
			* from 
			sc_mst.user where username is not null and coalesce(hold_id,'Y')='N' $param
			");
	}

	function q_mst_user($param){
		return $this->db->query("
select trim(coalesce(branch::text),'') as branch    ,
trim(coalesce(nik         ::text),'') as nik        ,
trim(coalesce(username    ::text),'') as username   ,
trim(coalesce(passwordweb ::text),'') as passwordweb,
trim(coalesce(level_id    ::text),'') as level_id   ,
trim(coalesce(level_akses ::text),'') as level_akses,
trim(coalesce(expdate     ::text),'') as expdate    ,
trim(coalesce(hold_id     ::text),'') as hold_id    ,
trim(coalesce(inputdate   ::text),'') as inputdate  ,
trim(coalesce(inputby     ::text),'') as inputby    ,
trim(coalesce(updatedate  ::text),'') as updatedate ,
trim(coalesce(updateby    ::text),'') as updateby   ,
trim(coalesce(lastlogin   ::text),'') as lastlogin  ,
trim(coalesce(image       ::text),'') as image      ,
trim(coalesce(loccode     ::text),'') as loccode    ,
trim(coalesce(erptype     ::text),'') as erptype    ,
trim(coalesce(id_device   ::text),'') as id_device  ,
trim(coalesce(lock_device ::text),'') as lock_device,
trim(coalesce(location    ::text),'') as location   ,
trim(coalesce(divisi      ::text),'') as divisi     ,
trim(coalesce(groupuser   ::text),'') as groupuser  ,
trim(coalesce(idbu        ::text),'') as idbu ,
trim(coalesce(playerid        ::text),'') as playerid,
trim(coalesce(bag_dept        ::text),'') as id_dept,
trim(coalesce(nmdept        ::text),'') as nm_dept,
trim(coalesce(subbag_dept        ::text),'') as id_subdept,
trim(coalesce(nmsubdept        ::text),'') as nm_subdept,
trim(coalesce(jabatan        ::text),'') as id_jabatan,
trim(coalesce(nmjabatan        ::text),'') as nm_jabatan,
trim(coalesce(kdcabang        ::text),'') as id_wilayah,
trim(coalesce(nmcabang        ::text),'') as nm_wilayah,
trim(coalesce(nmlengkap        ::text),'') as nmlengkap
from (select a.*,b.bag_dept,b.subbag_dept,b.nmsubdept,b.nmdept,b.nmjabatan,b.nmcabang,b.jabatan,b.nmlengkap,b.kdcabang from  
sc_mst.t_user_mobile a
left outer join sc_mst.lv_m_karyawan b on a.nik=b.nik) as x where username is not null $param");
	}
}
