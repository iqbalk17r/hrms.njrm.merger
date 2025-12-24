<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DateDifference {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->helper('date');
    }

    public function getTimeDifference($start_date, $end_date, $unit = 'S') {
        $start_timestamp = strtotime($start_date);
        $end_timestamp = strtotime($end_date);

        $difference = $end_timestamp - $start_timestamp;

        switch (strtoupper($unit)) {
            case 'H':
                return (object)array(
                    'unit'=>'Hour',
                    'time'=>floor($difference / (60 * 60)),
                ); // Convert seconds to hours
                break;
            case 'M':
                return (object)array(
                    'unit'=>'Minute',
                    'time'=>floor($difference / 60),
                ); // Convert seconds to minutes
                break;
            case 'S':
            default:
                return (object)array(
                    'unit'=>'Second',
                    'time'=>$difference,
                ); // Return difference in seconds
                break;
        }
    }

    public function years($count = 1, $limit = 0)
    {
        $current_year = date('Y');
        $years_array = array();
        for ($i = 0; $i < $count; $i++) {
            if ($limit===0){
                $years_array[] = $current_year - $i;
            }else{
                if (($current_year - $i) > $limit){
                    $years_array[] = $current_year - $i;
                }
            }

        }

        return $years_array;
    }

    function months() {
        return array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
    }
}
