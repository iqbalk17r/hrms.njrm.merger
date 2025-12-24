<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/21/20, 11:38 AM
 *  * Last Modified: 10/21/20, 11:38 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */


class M_Legality extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    var $t_legal_master = "(select * from (
            select a.*,z1.uraian as nmtype,z2.uraian as nmdocname, z3.uraian as nmstatus,b.desc_cabang as nmbu from sc_his.legal_master a
            left outer join sc_mst.kantorwilayah b on a.idbu=b.kdcabang
            left outer join sc_mst.trxtype z1 on trim(a.doctype)=z1.kdtrx and trim(z1.jenistrx)='I.D.A.1_TYPE'
            left outer join sc_mst.trxtype z2 on trim(a.docname)=z2.kdtrx and trim(z2.jenistrx)='I.D.A.1_KTG'
            left outer join sc_mst.trxstatus z3 on trim(a.status)=z3.kdtrx and trim(z3.jenistrx)='I.D.A.1') as x
            where docno is not null) as x";
    var $t_legal_master_column = array('docno','docname','doctype','docdate','docref','docrefname','nmtype','nmdocname','nmstatus','nmbu','inputdate',
        'coperatorname','coperator','progress','description'
    );
    var $t_legal_master_order = array("docno" => 'desc'); // default order
    private function _get_query_legality()
    {

        if($this->input->post('tglrange')) {
            $tgl=explode(' - ',$this->input->post('tglrange'));
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $this->db->where("docdate BETWEEN '$tgl1' AND '$tgl2'","", FALSE);
        }

        if($this->input->post('fcoperator')) {
            $coperator = trim($this->input->post('fcoperator'));
            $this->db->where(" coperator in ('$coperator') ","", FALSE);
        }


        $this->db->from($this->t_legal_master);
        $i = 0;

        foreach ($this->t_legal_master_column as $item)
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", $_POST['search']['value']);
                }

                if(count($this->t_legal_master_column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            if ($_POST['order']['0']['column']!= 0){ //diset klo post column 0
                $this->db->order_by($this->t_legal_master_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_legal_master_order))
        {
            $order = $this->t_legal_master_order;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }
        }

    }


    function get_list_legality(){
        $this->_get_query_legality();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'],$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    function t_legal_master_count_filtered()
    {
        $this->_get_query_legality();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_legal_master_count_all()
    {
        $this->db->from($this->t_legal_master);
        return $this->db->count_all_results();
    }
    public function get_t_legal_master_by_id($id)
    {
        $this->db->from($this->t_legal_master);
        $this->db->where('docno',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_tmp_t_legal_master_by_id($id)
    {
        $this->db->from("sc_tmp.legal_master");
        $this->db->where('docno',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_tmp_t_legal_param($param){
        return $this->db->query("select 
docno         ::text as docno         ,
docname       ::text as docname       ,
doctype       ::text as doctype       ,
docdate       ::text as docdate       ,
docref        ::text as docref        ,
trim(docrefname    ::text) as docrefname    ,
trim(coperator     ::text) as coperator     ,
trim(coperatorname ::text) as coperatorname ,
trim(idbu          ::text) as idbu          ,
trim(namebu        ::text) as namebu        ,
trim(status        ::text) as status        ,
trim(progress      ::text) as progress      ,
trim(description   ::text) as description   ,
trim(inputdate     ::text) as inputdate     ,
trim(inputby       ::text) as inputby       ,
trim(updatedate    ::text) as updatedate    ,
trim(updateby      ::text) as updateby      ,
trim(finishdate    ::text) as finishdate    ,
trim(finishby      ::text) as finishby      ,
trim(docnokeep     ::text) as docnokeep     ,
trim(docnotmp      ::text) as docnotmp      ,
trim(attachment    ::text) as attachment    ,
trim(attachment_dir::text) as attachment_dir,
trim(nmtype        ::text) as nmtype        ,
trim(nmdocname     ::text) as nmdocname     ,
trim(nmstatus      ::text) as nmstatus      ,
trim(nmbu          ::text) as nmbu           from (
            select a.*,z1.uraian as nmtype,z2.uraian as nmdocname, z3.uraian as nmstatus,b.desc_cabang as nmbu from sc_tmp.legal_master a
            left outer join sc_mst.kantorwilayah b on a.idbu=b.kdcabang
            left outer join sc_mst.trxtype z1 on trim(a.doctype)=z1.kdtrx and trim(z1.jenistrx)='I.D.A.1_TYPE'
            left outer join sc_mst.trxtype z2 on trim(a.docname)=z2.kdtrx and trim(z2.jenistrx)='I.D.A.1_KTG'
            left outer join sc_mst.trxstatus z3 on trim(a.status)=z3.kdtrx and trim(z3.jenistrx)='I.D.A.1') as x
            where docno is not null $param");

    }

    function insert_to_tmp_legal_master($nama,$docno){
        return $this->db->query("
insert into sc_tmp.legal_master
            (docno,docname,doctype,docdate,docref,docrefname,coperator,coperatorname,idbu,status,progress,description,
            inputdate,inputby,updatedate,updateby,finishdate,finishby,docnokeep,docnotmp,attachment,attachment_dir)
            values
            ('$nama','A','' ,now()::timestamp,'','','','','','I','INPUT','',
            now()::timestamp,'$nama',null,null,null,null,null,null,null ,null );");
    }



    /* LOAD TMP LEGAL DETAIL */
    var $t_legal_detail = "(
            select a.*,z1.uraian as nmtype,z2.uraian as nmdocname, z3.uraian as nmstatus,b.desc_cabang as nmbu,z4.uraian as nmoperationcategory from sc_tmp.legal_detail a
            left outer join sc_mst.kantorwilayah b on a.idbu=b.kdcabang
            left outer join sc_mst.trxtype z1 on trim(a.doctype)=z1.kdtrx and trim(z1.jenistrx)='I.D.A.1_TYPE'
            left outer join sc_mst.trxtype z2 on trim(a.docname)=z2.kdtrx and trim(z2.jenistrx)='I.D.A.1_KTG'
            left outer join sc_mst.trxstatus z3 on trim(a.status)=z3.kdtrx and trim(z3.jenistrx)='I.D.A.1'
            left outer join sc_mst.trxtype z4 on trim(a.operationcategory)=z4.kdtrx and trim(z4.jenistrx)='I.D.A.1_KTG') as x";
    var $t_legal_detail_column = array('docno','docname','doctype','docdate','docref','docrefname','dateoperation','operationcategory','attachment','nmoperationcategory');
    var $t_legal_detail_order = array("docno" => 'desc'); // default order
    private function _get_query_tmp_legal_detail()
    {

        if($this->input->post('tglrange')) {
            $tgl=explode(' - ',$this->input->post('tglrange'));
            $tgl1= date('Y-m-d',strtotime($tgl[0]));
            $tgl2= date('Y-m-d',strtotime($tgl[1]));
            $this->db->where("podate BETWEEN '$tgl1' AND '$tgl2'","", FALSE);
        }

        $this->db->from($this->t_legal_detail);
        $i = 0;

        foreach ($this->t_legal_detail_column as $item)
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", $_POST['search']['value']);
                }

                if(count($this->t_legal_detail_column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            if ($_POST['order']['0']['column']!= 0){ //diset klo post column 0
                $this->db->order_by($this->t_legal_detail_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_legal_detail_order))
        {
            $order = $this->t_legal_detail_order;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }
        }

    }


    function get_list_tmp_legal_detail($docno){
        $this->_get_query_tmp_legal_detail();
        if($_POST['length'] != -1)
            //$this->db->where('docno',$docno);
            $this->db->limit($_POST['length'],$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    function t_legal_detail_count_filtered()
    {
        $this->_get_query_legality();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function t_legal_detail_count_all()
    {
        $docno = trim($this->session->userdata('nik'));
        $this->db->where('docno',$docno);
        $this->db->from($this->t_legal_detail);
        return $this->db->count_all_results();
    }
    public function get_t_legal_detail_by_id($docno,$id)
    {
        $this->db->from($this->t_legal_detail);
        $this->db->where('docno',$docno);
        $this->db->where('sort',$id);
        $query = $this->db->get();
        return $query->row();
    }

    /* END LOAD TMP LEGAL DETAIL */



    /*LEGAL DETAIL*/
    function q_his_legal_master($param){
        return $this->db->query("select * from (select * from (
            select a.*,z1.uraian as nmtype,z2.uraian as nmdocname, z3.uraian as nmstatus,b.desc_cabang as nmbu from sc_his.legal_master a
            left outer join sc_mst.kantorwilayah b on a.idbu=b.kdcabang
            left outer join sc_mst.trxtype z1 on trim(a.doctype)=z1.kdtrx and trim(z1.jenistrx)='I.D.A.1_TYPE'
            left outer join sc_mst.trxtype z2 on trim(a.docname)=z2.kdtrx and trim(z2.jenistrx)='I.D.A.1_KTG'
            left outer join sc_mst.trxstatus z3 on trim(a.status)=z3.kdtrx and trim(z3.jenistrx)='I.D.A.1') as x
            where docno is not null) as x where docno is not null $param ");
    }

    function q_his_legal_detail($param){
        return $this->db->query("select * from (
            select a.*,z1.uraian as nmtype,z2.uraian as nmdocname, z3.uraian as nmstatus,b.desc_cabang as nmbu,z4.uraian as nmoperationcategory from sc_his.legal_detail a
            left outer join sc_mst.kantorwilayah b on a.idbu=b.kdcabang
            left outer join sc_mst.trxtype z1 on trim(a.doctype)=z1.kdtrx and trim(z1.jenistrx)='I.D.A.1_TYPE'
            left outer join sc_mst.trxtype z2 on trim(a.docname)=z2.kdtrx and trim(z2.jenistrx)='I.D.A.1_KTG'
            left outer join sc_mst.trxstatus z3 on trim(a.status)=z3.kdtrx and trim(z3.jenistrx)='I.D.A.1'
            left outer join sc_mst.trxtype z4 on trim(a.operationcategory)=z4.kdtrx and trim(z4.jenistrx)='I.D.A.1_KTG') as x where docno is not null $param order by inputdate desc");
    }

    function q_report_legal($param){
        return $this->db->query("
            select x.*,negosiasi,negosiasi_date,klarifikasi,klarifikasi_date,sp1,sp1_date,sp2,sp2_date,sp3,sp3_date,somasi,somasi_date,y.desc_cabang as nmbu,y.initial from sc_his.legal_master x
            left outer join 
            (select a.docno,case when operationcategory='A' then 'NEGOSIASI' else '' end as negosiasi,a.dateoperation as negosiasi_date from sc_his.legal_detail a,
            (select max(docdate) as docdate,docno from sc_his.legal_detail where operationcategory='A' 
            group by docno) as b
            where a.docno=b.docno and a.docdate=b.docdate) a on x.docno=a.docno
            left outer join 
            (select a.docno,case when operationcategory='B' then 'KLARIFIKASI' else '' end as klarifikasi,a.dateoperation as klarifikasi_date from sc_his.legal_detail a,
            (select max(docdate) as docdate,docno from sc_his.legal_detail where operationcategory='B'   
            group by docno) as b
            where a.docno=b.docno and a.docdate=b.docdate) b on x.docno=b.docno
            left outer join 
            (select a.docno,case when operationcategory='C' then 'SP1' else '' end as sp1,a.dateoperation as sp1_date from sc_his.legal_detail a,
            (select max(docdate) as docdate,docno from sc_his.legal_detail where operationcategory='C'  
            group by docno) as b
            where a.docno=b.docno and a.docdate=b.docdate) c on x.docno=c.docno
            left outer join 
            (select a.docno,case when operationcategory='D' then 'SP2' else '' end as sp2,a.dateoperation as sp2_date from sc_his.legal_detail a,
            (select max(docdate) as docdate,docno from sc_his.legal_detail where operationcategory='D' 
            group by docno) as b
            where a.docno=b.docno and a.docdate=b.docdate) d on x.docno=d.docno
            left outer join 
            (select a.docno,case when operationcategory='E' then 'SP3' else '' end as sp3,a.dateoperation as sp3_date from sc_his.legal_detail a,
            (select max(docdate) as docdate,docno from sc_his.legal_detail where operationcategory='E'  
            group by docno) as b
            where a.docno=b.docno and a.docdate=b.docdate) e on x.docno=e.docno
            left outer join
            (select a.docno,case when operationcategory='F' then 'SOMASI' else '' end as somasi,a.dateoperation as somasi_date from sc_his.legal_detail a,
            (select max(docdate) as docdate,docno from sc_his.legal_detail where operationcategory='F'  
            group by docno) as b
            where a.docno=b.docno and a.docdate=b.docdate) f on x.docno=f.docno
            left outer join sc_mst.kantorwilayah y on x.idbu=y.kdcabang
            where a.docno is not null $param

");
    }


    /* LOAD TMP LEGAL DETAIL */
    var $t_report_legal_detail = "sc_his.v_legal_report";
    var $t_report_legal_detail_column = array('docno','nmbu','coperatorname','negosiasi_date','klarifikasi_date','sp1_date','sp2_date','sp3_date','somasi_date','attachment','progress');
    var $t_report_legal_detail_order = array("docno" => 'desc'); // default order
    private function _get_query_t_report_legal_detail()
    {

        if($this->input->post('idbu')) {
            $x=$this->input->post('idbu');

           $this->db->where_in('idbu',$x);
        }

        $this->db->from($this->t_report_legal_detail);
        $i = 0;

        foreach ($this->t_report_legal_detail_column as $item)
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", $_POST['search']['value']);
                }

                if(count($this->t_report_legal_detail_column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            if ($_POST['order']['0']['column']!= 0){ //diset klo post column 0
                $this->db->order_by($this->t_report_legal_detail_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_report_legal_detail_order))
        {
            $order = $this->t_report_legal_detail_order;
            foreach ($order as $key => $item){
                $this->db->order_by($key, $item);
            }
        }

    }


    function get_list_t_report_legal_detail(){
        $this->_get_query_t_report_legal_detail();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'],$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    function t_report_legal_detail_count_filtered()
    {
        $this->_get_query_t_report_legal_detail();
        $query = $this->db->get();
        return $query->row();
    }
    public function t_report_legal_detail_count_all()
    {
        $this->db->from($this->t_report_legal_detail);
        return $this->db->count_all_results();
    }

}
