<?php

class Update extends CI_Controller {
    protected $_repo = "hrms.nusa";

    function __construct() {
        parent::__construct();

        $this->load->model(["master/m_akses"]);
        $this->load->library(["template"]);
        $nik = trim($this->session->userdata("nik"));
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $level_akses = strtoupper(trim($userinfo["level_akses"]));
        if(empty($nik) || empty($level_akses) || !in_array($_SERVER["REMOTE_ADDR"], ["127.0.0.1", "::1"])) {
            redirect("dashboard");
        }
    }

    function index() {
        $data["title"] = "Update Website";
        $this->template->display("v_update", $data);
    }

    function exec() {
        if(is_null($_SERVER["HTTP_REFERER"])) {
            redirect("dashboard");
        }

        $filelog = APPPATH . "migrations/logs/git.txt";
        file_put_contents($filelog, date("Y-m-d H:i:s") . "\n\n");
        $arr = [
            "status" => "false",
            "logResult" => ""
        ];

        $result = "";
        $command = "git remote set-url origin https://nusantaragroup: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@github.com/itcenternusantaragroup/" . $this->_repo . " 2>&1";
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        $result = "";
        $command = "git rev-parse HEAD 2>&1";
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);
        $hash = $result[0];

        $result = "";
        $command = "git fetch 2>&1";
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        $result = "";
        $command = "git status -uno 2>&1";
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        if(!strpos(implode("\n", $result), "up to date")) {
            $result = "";
            $command = "git reset --hard origin/main 2>&1";
            file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
            exec($command, $result);
            file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);
            $arr["status"] = "true";

            $result = "";
            $command = "git log --pretty=format:%C(auto)%H%n%an%n%ai%n%s%n%b### $hash^..HEAD 2>&1";
            file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
            exec($command, $result);
            file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

            $logRaw = [];
            $i = 0;
            $j = 0;
            foreach($result as $k => $v) {
                if($v == "###") {
                    $j = 0;
                    $i++;
                    continue;
                }

                $logRaw[$i][$j] = $v;
                $j++;
            }
            $logResult = "";
            foreach($logRaw as $k => $v) {
                $logResult .= "
                <div class=\"box box-body\">
                    <div class=\"col-md-12\">
                        <h5 class=\"text-bold\" style=\"margin-bottom: 0;\">" . $v[3] . "</h5>
                    </div>
                    <div class=\"col-md-6\">
                        <h6 class=\"text-nowrap\"><i class=\"fa fa-hashtag\"></i>&nbsp; " . $v[0] . "</h6>
                    </div>
                    <div class=\"col-md-3\">
                        <h6 class=\"text-nowrap\"><i class=\"fa fa-user\"></i>&nbsp; " . $v[1] . "</h6>
                    </div>
                    <div class=\"col-md-3\">
                        <h6 class=\"text-nowrap\"><i class=\"fa fa-clock-o\"></i>&nbsp; " . date("d-m-Y H:i:s", strtotime($v[2])) . "</h6>
                    </div>
            ";
                if(sizeof($v) > 4) {
                    $logResult .= "
                    <div class=\"col-md-12\" style=\"border-top: 1px black solid;\">
                        <p style=\"margin: 10px; white-space: pre-line;\">";
                    for($i = 4; $i < sizeof($v); $i++) {
                        $logResult .= str_replace("*", "&nbsp;&nbsp;&nbsp;*", $v[$i]) . "<br>";
                    }
                    $logResult .= "</p>
                    </div>
                ";
                } else {
                    $logResult .= "<br>";
                }

                $logResult .= "
                </div>
            ";
            }
            $arr["logResult"] = $logResult;
        }
        ob_start();
        $this->load->library(["migration"]);
        if($this->migration->current() === TRUE && $arr["status"] == "false") {
            $arr["status"] = "false";
        } else if($this->migration->current() === FALSE) {
            $arr["status"] = "error";
        } else {
            $arr["status"] = "true";
        }
        ob_end_clean();

        echo json_encode($arr);
    }
}	
