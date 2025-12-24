<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 13/04/2019
 * Time: 10:26
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class M_master extends CI_Model{
    var $t_wilayah = "sc_mst.m_wilayah";
    ///var $t_wil_order = array('kdwilayah','nmwilayah','c_hold'); //set column field database for datatable orderable
    var $t_wil_column = array('kdwilayah','nmwilayah','c_hold'); //set column field database
    var $t_wil_default_order = array('kdwilayah' => 'asc'); // default order

    var $t_wilayah_sal = "sc_mst.m_wilayah_nominal";
    var $t_wil_sal_column = array('kdwilayahnominal','nmwilayahnominal','golongan','nominal','c_hold'); //set column field database for datatable
    var $t_wil_sal_default_order = array('kdwilayahnominal' => 'asc'); // default order

    var $t_masjab_sal = "sc_mst.lv_m_jabatan";
    var $t_masjab_sal_column = array('kdjabatan','nmjabatan','nmdept','nmsubdept','nmlvljabatan','nmgrade','nominal'); //set column field database for datatable
    var $t_masjab_sal_default_order = array('nmdept' => 'asc','nmjabatan' => 'asc'); // default order

    var $t_masker_sal = "sc_mst.m_masakerja";
    var $t_masker_sal_column = array('kdmasakerja','nmmasakerja','awal','akhir','c_hold','nominal'); //set column field database for datatable
    var $t_masker_sal_default_order = array('kdmasakerja' => 'asc'); // default order

    var $t_option = "sc_mst.option";
    var $t_option_column = array('kdoption','nmoption','value1','status','keterangan','group_option'); //set column field database for datatable
    var $t_option_order = array('kdoption' => 'asc'); // default order

    var $t_m_lvlgp = "sc_mst.m_lvlgp";
    var $t_m_lvlgp_column = array('kdlvlgp','nominal','c_hold'); //set column field database for datatable
    var $t_m_lvlgp_order = array("kdlvlgp" => 'asc'); // default order

    var $t_m_grade_jabatan = "sc_mst.m_grade_jabatan";
    var $t_m_grade_jabatan_column = array('kdgradejabatan','nmgradejabatan','c_hold','nominal'); //set column field database for datatable
    var $t_m_grade_jabatan_order = array("groupgradejabatan" => 'asc',"kdgradejabatan" => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }
/* M_WILAYAH START */

    function q_mst_wilayah($param =  null){
        return $this->db->query("select * from sc_mst.m_wilayah where kdwilayah is not null $param order by nmwilayah");
    }
    function q_mst_jobgrade_golongan($param =  null){
        return $this->db->query("select * from sc_mst.jobgrade where kdgrade is not null $param order by kdgrade asc");
    }
    function q_mst_lvljabatan($param =  null){
        return $this->db->query("select * from sc_mst.lvljabatan where kdlvl is not null $param order by kdlvl asc");
    }
    private function _get_t_will_query()
    {
        $this->db->from($this->t_wilayah);
        $i = 0;

        foreach ($this->t_wil_column as $item)
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
                $this->db->order_by($this->t_wil_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_wil_default_order))
        {
            $order = $this->t_wil_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_wil()
    {
        $this->_get_t_will_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function t_will_count_filtered()
    {
        $this->_get_t_will_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function t_will_count_all()
    {
        $this->db->from($this->t_wilayah);
        return $this->db->count_all_results();
    }

    public function get_t_will_by_id($id)
    {
        $this->db->from($this->t_wilayah);
        $this->db->where('kdwilayah',$id);
        $query = $this->db->get();

        return $query->row();
    }

    function list_menu(){
        return $this->db->query("select * from sc_mst.menuprg order by kodemenu");
    }

    function simpan_wilayah($data)
    {
        $this->db->insert($this->t_wilayah, $data);
        //return $this->db->insert();
    }
    function ubah_wilayah($where, $data)
    {
        $this->db->update($this->t_wilayah, $data, $where);
        return $this->db->affected_rows();
    }

    function hapus_wilayah($id)
    {
        $this->db->where('kdwilayah', $id);
        $this->db->delete($this->t_wilayah);
    }
/* M_WILAYAH END */
/* M_WILAYAH SALARY START */
    private function _get_t_will_sal_query()
    {
        $this->db->from($this->t_wilayah_sal);
        $i = 0;

        foreach ($this->t_wil_sal_column as $item)
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
            $x_column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            if ($_POST['order']['0']['column']!=0){ //diset klo post column 0
                $this->db->order_by($this->t_wil_sal_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_wil_sal_default_order))
        {
            $order = $this->t_wil_sal_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_wil_sal()
    {
        $this->_get_t_will_sal_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_will_sal_count_filtered()
    {
        $this->_get_t_will_sal_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function t_will_sal_count_all()
    {
        $this->db->from($this->t_wilayah_sal);
        return $this->db->count_all_results();
    }
    function get_t_will_sal_by_id($id)
    {
        $this->db->from($this->t_wilayah_sal);
        $this->db->where('kdwilayahnominal',$id);
        $query = $this->db->get();

        return $query->row();
    }
    function simpan_wilayah_sal($data)
    {
        $this->db->insert($this->t_wilayah_sal, $data);
        //return $this->db->insert();
    }
    function ubah_wilayah_sal($where, $data)
    {
        $this->db->update($this->t_wilayah_sal, $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_wilayah_sal($id)
    {
        $this->db->where('kdwilayahnominal', $id);
        $this->db->delete($this->t_wilayah_sal);
    }
/* M_WILAYAH SALARY END */
/* START MASTER JABATAN*/
    function _get_t_masjab_query()
    {
        $this->db->from($this->t_masjab_sal);
        $i = 0;

        foreach ($this->t_masjab_sal_column as $item)
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
                $this->db->order_by($this->t_masjab_sal_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_masjab_sal_default_order))
        {
            $order = $this->t_masjab_sal_default_order  ;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }

        }
    }
    function get_t_masjab_sal()
    {
        $this->_get_t_masjab_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_masjab_sal_count_filtered()
    {
        $this->_get_t_masjab_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function t_masjab_sal_count_all()
    {
        $this->db->from($this->t_masjab_sal);
        return $this->db->count_all_results();
    }
    function get_t_masjab_sal_by_id($id)
    {
        $this->db->from($this->t_masjab_sal);
        $this->db->where('kdjabatan',$id);
        $query = $this->db->get();

        return $query->row();
    }
    function simpan_masjab_sal($data)
    {
        $this->db->insert("sc_mst.jabatan", $data);
        //return $this->db->insert();
    }
    function ubah_masjab_sal($where, $data)
    {
        $this->db->update("sc_mst.jabatan", $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_masjab_sal($id)
    {
        $this->db->where('kdjabatan', $id);
        $this->db->delete("sc_mst.jabatan");
    }
/* M_WILAYAH END */
/* START MASKER SALARY */
    function _get_t_masker_sal_query()
    {
        $this->db->from($this->t_masker_sal);
        $i = 0;

        foreach ($this->t_masker_sal_column as $item)
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
                $this->db->order_by($this->t_masker_sal_default_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_masker_sal_default_order))
        {
            $order = $this->t_masker_sal_default_order  ;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }
        }
    }
    function get_masker_salary()
    {
        $this->_get_t_masker_sal_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_masker_sal_count_filtered()
    {
        $this->_get_t_masker_sal_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_masker_sal_count_all()
    {
        $this->db->from($this->t_masker_sal);
        return $this->db->count_all_results();
    }
    public function get_t_masker_sal_by_id($id)
    {
        $this->db->from($this->t_masker_sal);
        $this->db->where('kdmasakerja',$id);
        $query = $this->db->get();

        return $query->row();
    }
    function simpan_masker_sal($data)
    {
        $this->db->insert("sc_mst.m_masakerja", $data);
        //return $this->db->insert();
    }
    function ubah_masker_sal($where, $data)
    {
        $this->db->update("sc_mst.m_masakerja", $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_masker_sal($id)
    {
        $this->db->where('kdmasakerja', $id);
        $this->db->delete("sc_mst.m_masakerja");
    }
/* END */
/* START MASKER SALARY */
    function _get_t_option_query()
    {
        $this->db->from($this->t_option);
        $this->db->where('group_option','PAYROLL');
        $i = 0;

        foreach ($this->t_option_column as $item)
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
                $this->db->order_by($this->t_option_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_option_order))
        {
            $order = $this->t_option_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_option()
    {
        $this->_get_t_option_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_option_count_filtered()
    {
        $this->_get_t_option_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_option_count_all()
    {
        $this->db->from($this->t_option);
        return $this->db->count_all_results();
    }
    public function get_t_option_by_id($id)
    {
        $this->db->from($this->t_option);
        $this->db->where('kdoption',$id);
        $query = $this->db->get();
        return $query->row();
    }
    function simpan_t_option($data)
    {
        $this->db->insert("sc_mst.option", $data);
        //return $this->db->insert();
    }
    function ubah_t_option($where, $data)
    {
        $this->db->update("sc_mst.option", $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_t_option($id)
    {
        $this->db->where('kdmasakerja', $id);
        $this->db->delete("sc_mst.m_masakerja");
    }
/* END */

/* START MASTER M_LVLGP */
    function _get_t_m_lvlgp_query()
    {
        $this->db->from($this->t_m_lvlgp);
        $i = 0;

        foreach ($this->t_m_lvlgp_column as $item)
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
            if ($_POST['order']['0']['column']!= 0){ //diset klo post column 0
                $this->db->order_by($this->t_m_lvlgp_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_m_lvlgp_order))
        {
            $order = $this->t_m_lvlgp_order  ;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }
        }
    }
    function get_t_m_lvlgp()
    {
        $this->_get_t_m_lvlgp_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_m_lvlgp_count_filtered()
    {
        $this->_get_t_m_lvlgp_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_m_lvlgp_count_all()
    {
        $this->db->from($this->t_m_lvlgp);
        return $this->db->count_all_results();
    }
    public function get_t_m_lvlgp_by_id($id)
    {
        $this->db->from($this->t_m_lvlgp);
        $this->db->where('kdlvlgp',$id);
        $query = $this->db->get();
        return $query->row();
    }
    function simpan_t_m_lvlgp($data)
    {
        $this->db->insert("sc_mst.m_lvlgp", $data);
        //return $this->db->insert();
    }
    function ubah_t_m_lvlgp($where, $data)
    {
        $this->db->update("sc_mst.m_lvlgp", $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_t_m_lvlgp($id)
    {
        $this->db->where('kdlvlgp', $id);
        $this->db->delete("sc_mst.m_lvlgp");
    }
/* END */

/* START MASTER GRADE JABATAN */
    //$t_m_grade_jabatan
    function _get_t_m_grade_jabatan_query()
    {
        $this->db->from($this->t_m_grade_jabatan);
        $i = 0;

        foreach ($this->t_m_grade_jabatan_column as $item)
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
            if ($_POST['order']['0']['column']!= 0){ //diset klo post column 0
                $this->db->order_by($this->t_m_grade_jabatan_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else
        {
            $order = $this->t_m_grade_jabatan_order  ;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }
        }
    }
    function get_t_m_grade_jabatan()
    {
        $this->_get_t_m_grade_jabatan_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_m_grade_jabatan_count_filtered()
    {
        $this->_get_t_m_grade_jabatan_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_m_grade_jabatan_count_all()
    {
        $this->db->from($this->t_m_grade_jabatan);
        return $this->db->count_all_results();
    }
    public function get_t_m_grade_jabatan_by_id($id)
    {
        $this->db->from($this->t_m_grade_jabatan);
        $this->db->where('kdgradejabatan',$id);
        $query = $this->db->get();
        return $query->row();
    }
    function simpan_t_m_grade_jabatan($data)
    {
        $this->db->insert("sc_mst.m_grade_jabatan", $data);
        //return $this->db->insert();
    }
    function ubah_t_m_grade_jabatan($where, $data)
    {
        $this->db->update("sc_mst.m_grade_jabatan", $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_t_m_grade_jabatan($id)
    {
        $this->db->where('kdgradejabatan', $id);
        $this->db->delete("sc_mst.m_grade_jabatan");
    }
    /* END */


    function q_trxtype($param){
        return $this->db->query("select * from sc_mst.trxtype where kdtrx is not null $param order by uraian asc");
    }

    function q_master_lvl_gp($p1){
        return $this->db->query("select * from sc_mst.m_lvlgp where kdlvlgp is not null $p1");
    }

    function q_master_wilayah_nominal($p1){
        return $this->db->query("select * from sc_mst.m_wilayah_nominal where kdwilayahnominal is not null $p1");
    }

    function q_cek_input_master_masakerja($param){
        return $this->db->query("select * from sc_mst.m_masakerja where kdmasakerja is not null $param ");
    }
}

