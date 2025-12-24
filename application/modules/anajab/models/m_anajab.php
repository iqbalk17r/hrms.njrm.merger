<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/25/19 8:54 AM
 *  * Last Modified: 1/2/19 10:48 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class M_anajab extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


    function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}

	function q_trxerror($paramtrxerror){
		return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
	}

	function q_deltrxerror($paramtrxerror){
		return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
	}

    //var $t_anajab_mst = "sc_his.v_anajab_mst";
    var $t_anajab_mst = "sc_his.v_anajab_mst_jabatan";
    var $t_anajab_mst_column = array('docno','docdate1','nmdept','nmsubdept','nmjabatan','file_name','nmstatus'); //set column field database
    var $t_anajab_mst_default_order = array('nmjabatan' => 'asc'); // default order

    private function _get_t_anajab_mst_query()
    {
        if(!empty($this->input->post('kdjabatan'))) {
            $kddept = $this->input->post('kddept');
            $kdsubdept = $this->input->post('kdsubdept');
            $kdjabatan = $this->input->post('kdjabatan');
                $this->db->where(" kddept in ('$kddept') and kdsubdept in ('$kdsubdept') and kdjabatan in ('$kdjabatan') ","", FALSE);
                //$this->db->where(" kdsubdept in ('$kdsubdept') ","", FALSE);
               // $this->db->where(" kdjabatan in ('$kdjabatan') ","", FALSE);
        }

        $this->db->from($this->t_anajab_mst);
        $i = 0;

        foreach ($this->t_anajab_mst_column as $item)
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                }
                else
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                }

            }
            //$x_column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            if ($_POST['order']['0']['column']!=0){ //diset klo post column 0
                $this->db->order_by($this->t_anajab_mst_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_anajab_mst_default_order))
        {
            $order = $this->t_anajab_mst_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_anajab_mst()
    {
        $this->_get_t_anajab_mst_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function t_anajab_mst_count_filtered()
    {
        $this->_get_t_anajab_mst_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function t_anajab_mst_count_all()
    {
        $this->db->from($this->t_anajab_mst);
        return $this->db->count_all_results();
    }

    public function get_t_anajab_mst_by_id($id)
    {
        $this->db->from($this->t_anajab_mst);
        $this->db->where('docno',$id);
        $query = $this->db->get();

        return $query->row();
    }

    function q_jabatan($param){
        return $this->db->query("select a.*,b.nmdept,c.nmsubdept,e.nmlvljabatan,coalesce(b.nmdept,'')||' - '||coalesce(c.nmsubdept,'')||' - '||coalesce(a.nmjabatan,'') as alljabatan  from sc_mst.jabatan a
                                        left outer join sc_mst.departmen b on a.kddept=b.kddept
                                        left outer join sc_mst.subdepartmen c on a.kddept=c.kddept and a.kdsubdept=c.kdsubdept
                                        left outer join sc_mst.lvljabatan e on a.kdlvl=e.kdlvl where b.nmdept is not null $param");
    }

    function q_anajab_mst($param){
        return $this->db->query("select * from sc_his.anajab_mst where kdjabatan is not null $param ");
    }
}
