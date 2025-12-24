<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/3/19 8:44 AM
 *  * Last Modified: 4/12/19 11:11 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Fiky_wilayah
{

    protected $_CI;

       function __construct(){
           $this->_CI=&get_instance();
           $this->_CI->load->model(array('master/m_akses','master/m_menu'));
           $this->_CI->load->library(array('session','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
       }

    function coba(){
        return 'TEST';
        /**
         * P1 : KODEMENU
         * P2 : NAMA VERSI
         * P3 : SESSION
         */
    }

    function list_negara_param($param = null){
        return $this->_CI->db->query("select * from sc_mst.negara where kodenegara is not null $param");
    }

    function list_prov_param($param = null){
        return $this->_CI->db->query("select * from(
                                     select a.*,b.namanegara from sc_mst.provinsi a
                                     left outer join sc_mst.negara b on a.kodenegara=b.kodenegara) as x
                                     where kodeprov is not null $param
                                     order by namanegara,namaprov");
    }

    function list_kotakab_param($param = null){
        return $this->_CI->db->query("select * from (
                                    select a.*,b.namanegara,c.namaprov from sc_mst.kotakab a
                                    left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
                                    left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov) as x
                                    where kodeprov is not null $param
                                    order by namanegara,namaprov,namakotakab");
    }

    function list_kec_param($param = null){
        return $this->_CI->db->query("select * from (
                                    select a.*,b.namanegara,c.namaprov,d.namakotakab from sc_mst.kec a
                                    left outer join sc_mst.kotakab d on a.kodekotakab=d.kodekotakab
                                    left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
                                    left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov) as x
                                    where kodekec is not null $param
                                    order by namanegara,namaprov,namakotakab,namakec");
    }

    function list_keldesa_param($param = null){
        return $this->_CI->db->query("select * from (
                                    select a.*,b.namanegara,c.namaprov,d.namakotakab,e.namakec from sc_mst.keldesa a
                                    left outer join sc_mst.kec e on e.kodekec=a.kodekec
                                    left outer join sc_mst.kotakab d on a.kodekotakab=d.kodekotakab
                                    left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
                                    left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov) as x
                                    where kodekeldesa is not null $param
                                    order by namanegara,namaprov,namakotakab,namakec,namakeldesa");
    }

   function getNegara($p){
       $gmed=json_decode($p);
       $gmed->search;
       $search = $gmed->search;
       $perpage = $gmed->perpage;
       $page = $gmed->page;
       $paramxnegara = $gmed->paramxnegara;
       $param_c="";
       $count = $this->list_negara_param($param_c)->num_rows();
       $search = strtoupper(urldecode($search));

       $perpage = intval($perpage);
       $perpage = $perpage < 1 ? $count : $perpage;


       $page = intval($page);
       $limit = $perpage * $page;

       $param=" and (namanegara like '%$search%' $paramxnegara ) order by namanegara asc";
       $result = $this->list_negara_param($param)->result();
       header('Content-Type: application/json');
       $datanya = json_encode(
           array(
               'totalcount' => $count,
               'search' => $search,
               'perpage' => $perpage,
               'page' => $page,
               'limit' => $limit,
               'group' => $result,
               'paramxnegara' => $paramxnegara
           ),
           JSON_PRETTY_PRINT
       );
       return $datanya;
   }

   function getProvince($p){
       $gmed=json_decode($p);
       $gmed->search;
       $search = $gmed->search;
       $perpage = $gmed->perpage;
       $page = $gmed->page;
       $kodenegara = $gmed->kodenegara;

       $param_c="";
       $count = $this->list_prov_param($param_c)->num_rows();

       $search = strtoupper(urldecode($search));

       $perpage = intval($perpage);
       $perpage = $perpage < 1 ? $count : $perpage;

       $page = intval($page);
       $limit = $perpage * $page;
       $param=" and (kodenegara='$kodenegara' and namaprov like '%$search%') or (kodenegara='$kodenegara' and namaprov like '%$search%')";
       $result = $this->list_prov_param($param)->result();
       header('Content-Type: application/json');
       echo json_encode(
           array(
               'totalcount' => $count,
               'search' => $search,
               'perpage' => $perpage,
               'page' => $page,
               'limit' => $limit,
               'group' => $result,
               'kodenegara' => $kodenegara
           ),
           JSON_PRETTY_PRINT
       );
   }

   function getKota($p){
       $gmed=json_decode($p);
       $gmed->search;
       $search = $gmed->search;
       $perpage = $gmed->perpage;
       $page = $gmed->page;
       $kodenegara = $gmed->kodenegara;
       $kodeprov = $gmed->kodeprov;

       $param_c="and kodeprov='$kodeprov'";
       $count = $this->list_kotakab_param($param_c)->num_rows();
       $search = strtoupper(urldecode($search));
       $perpage = intval($perpage);
       $perpage = $perpage < 1 ? $count : $perpage;

       $page = intval($page);
       $limit = $perpage * $page;
       $param=" and (kodeprov='$kodeprov' and namakotakab like '%$search%') ";
       $result = $this->list_kotakab_param($param)->result();
       header('Content-Type: application/json');
       echo json_encode(
           array(
               'totalcount' => $count,
               'search' => $search,
               'perpage' => $perpage,
               'page' => $page,
               'limit' => $limit,
               'group' => $result,
               'kodenegara' => $kodenegara,
               'kodeprov' => $kodeprov,
           ),
           JSON_PRETTY_PRINT
       );
   }

   function getKecamatan($p){
       $gmed=json_decode($p);
       $search = $gmed->search;
       $perpage = $gmed->perpage;
       $page = $gmed->page;
       $kodenegara = $gmed->kodenegara;
       $kodeprov = $gmed->kodeprov;
       $kodekotakab = $gmed->kodekotakab;

       $param_c="and kodekotakab='$kodekotakab'";
       $count = $this->list_kec_param($param_c)->num_rows();
       $search = strtoupper(urldecode($search));
       $perpage = intval($perpage);
       $perpage = $perpage < 1 ? $count : $perpage;

       $page = intval($page);
       $limit = $perpage * $page;
       $param=" and (kodekotakab='$kodekotakab' and namakec like '%$search%')";
       $result = $this->list_kec_param($param)->result();
       header('Content-Type: application/json');
       echo json_encode(
           array(
               'totalcount' => $count,
               'search' => $search,
               'perpage' => $perpage,
               'page' => $page,
               'limit' => $limit,
               'group' => $result,
               'kodenegara' => $kodenegara,
               'kodeprov' => $kodeprov,
               'kodekotakab' => $kodekotakab,
           ),
           JSON_PRETTY_PRINT
       );
   }

   function getDesa($p){
        $gmed=json_decode($p);
        $search = $gmed->search;
        $perpage = $gmed->perpage;
        $page = $gmed->page;
        $kodenegara = $gmed->kodenegara;
        $kodeprov = $gmed->kodeprov;
        $kodekotakab = $gmed->kodekotakab;
        $kodekec = $gmed->kodekec;

        $param_c="and kodekec='$kodekec'";
        $count = $this->list_keldesa_param($param_c)->num_rows();
        $search = strtoupper(urldecode($search));
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;

        $page = intval($page);
        $limit = $perpage * $page;
        $param=" and (kodekec='$kodekec' and namakeldesa like '%$search%')";
        $result = $this->list_keldesa_param($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
                'kodenegara' => $kodenegara,
                'kodeprov' => $kodeprov,
                'kodekotakab' => $kodekotakab,
                'kodekec' => $kodekec,
            ),
            JSON_PRETTY_PRINT
        );
    }



}
