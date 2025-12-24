<?php
//require_once dirname(__FILE__) . '/zklib/zklib.php';

class Fiky_report  {
    protected $_CI;
    function __construct(){
        $this->_CI=&get_instance();
        //load utama
        //assets/stimulsoft
        //views/stimulsoft
        //library/stimulsoft
        //fiky_report

    }
    public function render($datajson,$datamrt,$title,$session) {
        $head_def = '';
        $head_def.= '<!-- Office2013 style -->';
        $head_def.= ' <link href="'.base_url('assets/stimulsoft/css/stimulsoft.viewer.office2013.whiteteal.css'). '"  rel="stylesheet">';
        $head_def.= ' <!-- Stimusloft Reports.JS -->';
        $head_def.= ' <script src="'.base_url('assets/jquery/jquery-2.1.4.min.js'). '" type="text/javascript"></script> ';
        $head_def.= ' <script src="'.base_url('assets/stimulsoft/scripts/stimulsoft.reports.js'). '" type="text/javascript"></script> ';
        $head_def.= ' <script src="'.base_url('assets/stimulsoft/scripts/stimulsoft.reports.maps.js'). '" type="text/javascript"></script> ';
        $head_def.= ' <!-- Stimusloft Dashboards.JS -->';
        $head_def.= ' <script src="'.base_url('assets/stimulsoft/scripts/stimulsoft.dashboards.js'). '" type="text/javascript"></script> ';
        $head_def.= ' <script src="'.base_url('assets/stimulsoft/scripts/stimulsoft.viewer.js'). '" type="text/javascript"></script> ';


        $data['header'] = $head_def;
        $data['title'] =  $title;
        $data['license'] =  $this->loadLicense();
        //$data['reportnya'] =  $this->loadReport();
        $data['reportnya'] =  $datamrt;
        $data['jsonfile'] =  $datajson;
        $data['helper'] =  $this->loadHelper();
        //$data['handler'] =  $this->handler();
        return $this->_CI->load->view('stimulsoft/viewer', $data);
    }


    public function handler(){
        /* MASIH MENJADI MISTERI */
        //return include(dirname(__FILE__) ."/stimulsoft/handler.php");
        $this->loadHelper();
        error_reporting(0);
// Please configure the security level as you required.
// By default is to allow any requests from any domains.
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token");
        //$handler = new StiHandler();
        //$handler->registerErrorHandlers();

    }

    function cekloadlib(){
        include_once(dirname(__FILE__) ."/stimulsoft/test.php");
    }

    function loadLicense(){
        //include(dirname(__FILE__) ."/stimulsoft/license.php");
        //return include(dirname(__FILE__) ."/stimulsoft/license.php");
        return base_url("assets/stimulsoft/license.php");
    }

    function loadReport(){
        return base_url("assets/mrt/reports/SimpleList.mrt");
    }

    function loadJson(){
        return base_url("assets/mrt/reports/Demo.json");
    }
    function loadHelper(){
        return dirname(__FILE__) ."/stimulsoft/helper.php";
    }

    function testLoad(){
        include_once(dirname(__FILE__) ."/stimulsoft/test.php");
    }
}

