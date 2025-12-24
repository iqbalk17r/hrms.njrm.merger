<?php

function vdump() {
    $arg_list = func_get_args();
    foreach($arg_list as $var) {
        echo "<div style='text-align: left;'>";
            CVarDumper::dump($var, 10, true);
        echo "</div><br/><br/>";
    }
}

function last_query($format = true) {
    if($format)
        echo SqlFormatter::format(get_instance()->db->last_query());
    else
        echo get_instance()->db->last_query();
}