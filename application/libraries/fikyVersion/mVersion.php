<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 11/04/2019
 * Time: 15:33
 */

class mVersion
{

    function q_versidb($kodemenu){
        return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
    }

    function q_menuprg($kodemenu){
        return $this->db->query("select * from sc_mst.menuprg where kodemenu='$kodemenu'");
    }

    function insert_version($kodemenu){
        return $this->db->query("insert into sc_mst.version
                                    (kodemenu)
                                values
                                    ('$kodemenu');");
    }
}