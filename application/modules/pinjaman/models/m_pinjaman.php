<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/4/19 10:58 AM
 *  * Last Modified: 5/2/19 3:45 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class M_pinjaman extends CI_Model{
    var $t_pinjaman = "(select a.*,b.nmlengkap,c.uraian as nmstatus from sc_trx.payroll_pinjaman_mst a
                            left outer join sc_mst.lv_m_karyawan b on a.nik=b.nik
                            left outer join sc_mst.trxtype c on a.status=c.kdtrx and c.jenistrx='P_PINJAMAN'
                            where coalesce(statuskepegawaian,'')!='KO') as x";
    var $t_pinjaman_column = array('docno','nik','nmlengkap','tgl','nominal','sisa','tenor','npotong','status'); //set column field database
    var $t_pinjaman_default_order = array('docno' => 'desc'); // default order

    var $t_mstkaryawan = "(select * from sc_mst.lv_m_karyawan where coalesce(statuskepegawaian,'')!='KO') as x";
    var $t_mstkaryawan_column = array('nik','nmlengkap','nmjabatan','pinjaman'); //set column field database
    var $t_mstkaryawan_default_order = array('pinjaman' => 'desc','nmlengkap' => 'asc'); // default order


    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }
/* M_PINJAMAN START */
    private function _get_t_pinjaman_query()
    {
        $this->db->from($this->t_pinjaman);
        $i = 0;

        foreach ($this->t_pinjaman_column as $item)
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
                $this->db->order_by($this->t_pinjaman_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_pinjaman_default_order))
        {
            $order = $this->t_pinjaman_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_pinjaman()
    {
        $this->_get_t_pinjaman_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_pinjaman_count_filtered()
    {
        $this->_get_t_pinjaman_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_pinjaman_count_all()
    {
        $this->db->from($this->t_pinjaman);
        return $this->db->count_all_results();
    }
    public function get_t_pinjaman_by_id($id)
    {
        $this->db->from($this->t_pinjaman);
        $this->db->where('docno',$id);
        $query = $this->db->get();

        return $query->row();
    }
    function simpan_t_pinjaman($data)
    {
        $this->db->insert("sc_tmp.payroll_pinjaman_mst", $data);
        //return $this->db->insert();
    }
    function ubah_t_pinjaman($where, $data)
    {
        $this->db->update("sc_trx.payroll_pinjaman_mst", $data, $where);
        return $this->db->affected_rows();
    }
    function hapus_t_pinjaman($id)
    {
        $this->db->where('docno', $id);
        $this->db->delete($this->t_pinjaman);
    }
/* t_pinjaman END */

/* V PINJAMAN KARYAWAN START */
    private function _get_t_mstkaryawan_query()
    {
        $this->db->from($this->t_mstkaryawan);
        $i = 0;

        foreach ($this->t_mstkaryawan_column as $item)
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
                $this->db->order_by($this->t_mstkaryawan_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_mstkaryawan_default_order))
        {
            $order = $this->t_mstkaryawan_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_mstkaryawan()
    {
        $this->_get_t_mstkaryawan_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_mstkaryawan_count_filtered()
    {
        $this->_get_t_mstkaryawan_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_mstkaryawan_count_all()
    {
        $this->db->from($this->t_mstkaryawan);
        return $this->db->count_all_results();
    }
    public function get_t_mstkaryawan_by_id($id)
    {
        $this->db->from($this->t_mstkaryawan);
        $this->db->where('nik',$id);
        $query = $this->db->get();
        return $query->row();
    }

/* VIEW PINJAMAN KARYAWAN */
    function q_trxtype($param){
        return $this->db->query("select * from sc_mst.trxtype where kdtrx is not null $param order by uraian asc");
    }
    function q_hitung_pinjaman($nodok = null,$nama = null){
        return $this->db->query("select sc_trx.pr_hitung_pinjaman('$nodok'||'|'||''||'|'||'$nama')");
    }
    private function _get_t_sub_detail_pinjaman_query($param)
    {
        $this->db->where(array('nik' => $param));
        $this->db->from($this->t_pinjaman);
        $i = 0;

        foreach ($this->t_pinjaman_column as $item)
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
                $this->db->order_by($this->t_pinjaman_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_pinjaman_default_order))
        {
            $order = $this->t_pinjaman_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_detail_pinjaman($param = null)
    {
        $this->_get_t_sub_detail_pinjaman_query($param);
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function t_detail_pinjaman_count_filtered($param = null)
    {
        $this->_get_t_sub_detail_pinjaman_query($param);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function t_detail_pinjaman_count_all($param = null)
    {
        $this->db->where(array('nik' => $param));
        $this->db->from($this->t_pinjaman);
        return $this->db->count_all_results();
    }
    function get_t_detail_pinjaman_by_id($id)
    {
        $this->db->from($this->t_pinjaman);
        $this->db->where('docno',$id);
        $query = $this->db->get();
        return $query->row();
    }
/* DETAIL INQUIRY */
    function t_inquiry($docno,$nik){
        $query = $this->db->query("select  * from (
                            select a.*,b.nmlengkap,c.status as statusmst from sc_trx.payroll_pinjaman_inq a
                            left outer join sc_mst.karyawan b on a.nik=b.nik
                            join sc_trx.payroll_pinjaman_mst c on a.docno=c.docno
                            order by nik,docno,tgl,doctype,docref
                            ) as x where docno='$docno' and nik='$nik'");
        return $query;
    }
}	