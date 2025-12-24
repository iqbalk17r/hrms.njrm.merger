<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/26/19 4:03 PM
 *  * Last Modified: 4/26/19 3:56 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class M_setting extends CI_Model{
    /* Detail Gaji */
    var $t_historygaji = "sc_his.lv_history_gaji";
    var $t_historygaji_column = array('nik','nmlengkap','grouppenggajian','periode','gajipokok','gajitj'); //set column field database
    var $t_historygaji_default_order = array('nmlengkap' => 'asc','periode' => 'desc'); // default order


    function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								order by nmlengkap asc");
		
	}


    private function _get_t_historygaji_query($param)
    {
        //if(isset($param)){
        $param;
        $this->db->from($this->t_historygaji);
        $i = 0;

        foreach ($this->t_historygaji_column as $item)
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                }
                else
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                }
                if(count($this->t_historygaji_column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket

            }
            //$x_column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            if ($_POST['order']['0']['column']!=0){ //diset klo post column 0
                $this->db->order_by($this->t_historygaji_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_historygaji_default_order))
        {
            $order = $this->t_historygaji_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_historygaji($param = null)
    {
        $this->_get_t_historygaji_query($param);
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function t_historygaji_count_filtered($param = null)
    {
        $this->_get_t_historygaji_query($param);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function t_historygaji_all($param = null)
    {
        $param;
        $this->db->from($this->t_historygaji);
        return $this->db->count_all_results();
    }

    public function get_t_historygaji_by_id($id)
    {
        $this->db->from($this->t_historygaji);
        $this->db->where('nik',$id);
        $query = $this->db->get();

        return $query->row();
    }
	
	
}	