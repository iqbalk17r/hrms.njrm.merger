<?php
class M_patch extends CI_Model{
	var $columntwinmst = array('fc_trxno');
	var $ordertwinmst = array('fc_trxno' => 'desc','fd_entrydate' => 'desc');
	
	var $columntwpomst = array('fc_pono','Status','fv_suppname','podate');
	var $ordertwpomst = array('fc_pono' => 'desc','fd_podate' => 'desc');
	/* RENEWAL DATABASE */
	private $d_transaksi,$d_temporary;
	
	public function __construct() {
		parent::__construct();
	   // $this->load->database();
	   // $this->d_transaksi = $this->load->database('d_transaksi', TRUE);
	   // $this->d_temporary = $this->load->database('d_temporary', TRUE);
	}


    function q_trxerror($paramtrxerror){
        return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }
	
	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from SC_MST.trxerror where userid IS NOT NULL $paramtrxerror");
	}

	function q_branch(){
		$param=" and fc_default='Yes'";
		return $this->db->query("select * from sc_mst.t_cabang where fc_branch is not null $param");
	}
	
	function q_branch_setup(){
		$param=" and fc_default='Yes'";
		return $this->db->query("select * from (
								select a.fc_branch,a.fv_value as fv_name,
								b.fv_value as fv_add1,
								c.fv_value as fv_add2,
								d.fv_value as fv_city,
								e.fv_value as fv_manager,
								f.fv_value as fv_npwp,
								g.fv_value as fv_telp,
								h.fv_value as fv_pkpdate
								from sc_mst.t_setup a
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch add1' ) b on a.fc_branch=b.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch add2' ) c on a.fc_branch=c.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch city' ) d on a.fc_branch=d.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch manager' ) e on a.fc_branch=e.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch npwp' ) f on a.fc_branch=f.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch telp' ) g on a.fc_branch=g.fc_branch
								left outer join (select fc_branch,fv_value,fv_parameter from sc_mst.t_setup where fv_parameter='branch tgl pkp' ) h on a.fc_branch=h.fc_branch
								where left(a.fv_parameter,6)='branch' and a.fv_parameter='branch name') as x
								where fc_branch is not null $param ");
	}
	
	function q_patch_query($param,$order){
	    return $this->db->query("select * from (
                                select 
                                coalesce(trim(id                 ::text),'') as id                 ,
                                coalesce(trim(patchdate          ::text),'') as patchdate          ,
                                coalesce(trim(patchtext          ::text),'') as patchtext          ,
                                coalesce(trim(patchby            ::text),'') as patchby            ,
                                coalesce(trim(patchstatus        ::text),'') as patchstatus        ,
                                coalesce(trim(patchhold          ::text),'') as patchhold          ,
                                coalesce(trim(userspecification  ::text),'') as userspecification  ,
                                coalesce(trim(useridspecification::text),'') as useridspecification,
                                coalesce(trim(lastcommitdate     ::text),'') as lastcommitdate     ,
                                coalesce(trim(lastcommitby       ::text),'') as lastcommitby       ,
                                coalesce(trim(inputdate          ::text),'') as inputdate          ,
                                coalesce(trim(inputby            ::text),'') as inputby            ,
                                coalesce(trim(updatedate         ::text),'') as updatedate         ,
                                coalesce(trim(updateby           ::text),'') as updateby           ,
                                coalesce(trim(holddate           ::text),'') as holddate           ,
                                coalesce(trim(holdby             ::text),'') as holdby             ,
                                coalesce(trim(description        ::text),'') as description,
                                case when patchstatus='I' then 'DALAM INPUTAN'
                                     when patchstatus='F' then 'SEDANG BEROPRASI'
                                     when patchstatus='C' then 'PATCH BERHENTI'
                                else 'INVALID' end as nmstatus       
                                from sc_mst.patch_query where id is not null $param $order
                                ) as x ");
    }
	

}	