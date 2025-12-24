<?php
class Checklist extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(array("m_checklist", "m_checklist_master", "trans/m_karyawan", "master/m_department"));
        $this->load->library(array("form_validation", "template", "upload", "pdf"));
        if(!$this->session->userdata("nik")) {
            redirect("dashboard");
        }
    }

    function jadwal() {
        $data["title"] = "List Jadwal Checklist";
        $data["kodemenu"] = "I.G.J.4";
        $data["nik"] = $this->session->userdata("nik");
        $data["list_jadwal"] = $this->m_checklist->list_checklist()->result();
        $this->template->display("ga/checklist/v_list", $data);
    }

    function input() {
        $data["title"] = "Generate Jadwal Checklist";
        $data["kodemenu"] = "I.G.J.4";
        $data["list_periode"] = $this->m_checklist_master->list_periode("WHERE hold = 'F'")->result();
        $data["list_lokasi"] = $this->m_checklist_master->list_lokasi("WHERE a.hold = 'F'")->result();
        $data["list_departemen"] = $this->m_department->q_department()->result();
        $this->template->display("ga/checklist/v_add", $data);
    }

    function add() {
        $min = $this->input->post("min");
        $max = $this->input->post("max");
        $kode_periode = $this->input->post("kode_periode");
        $kode_lokasi = $this->input->post("kode_lokasi");
        $tanggal = $this->input->post("tanggal");
        $nik = $this->input->post("nik");
        $off = $this->input->post("off");
        $jadwal = $this->input->post("jadwal");
        $this->db->trans_start();

        ## CHECKLIST
        $tanggal_mulai = $tanggal_selesai = "";
        $minTmp = str_pad($min,2,"0", STR_PAD_LEFT);
        $maxTmp = str_pad($max,2,"0", STR_PAD_LEFT);
        if($kode_periode == "JAM") {
            $tglTmp = date("Y-m-d", strtotime($tanggal));
            $tanggal_mulai =  "$tglTmp $minTmp:00:00";
            $tanggal_selesai = "$tglTmp $maxTmp:59:59";
        } else if($kode_periode == "HARI") {
            $tglTmp = implode("-", array_reverse(explode("-", $tanggal)));
            $tanggal_mulai =  "$tglTmp-$minTmp 00:00:00";
            $tanggal_selesai = date("Y-m-t H:i:s", strtotime("$tglTmp-$maxTmp 23:59:59"));
        } else if($kode_periode == "BULAN") {
            $tanggal_mulai = "$tanggal-$minTmp-01 00:00:00";
            $tanggal_selesai = date("Y-m-t H:i:s", strtotime("$tanggal-$maxTmp-01 23:59:59"));
        } else if($kode_periode == "TAHUN") {
            $tanggal_mulai = "$minTmp-01-01 00:00:00";
            $tanggal_selesai = date("Y-m-t H:i:s", strtotime("$maxTmp-12-01 23:59:59"));
        }
        $dataChecklist = [
            "id_checklist" => date("YmdHis"),
            "kode_periode" => $kode_periode,
            "kode_lokasi" => $kode_lokasi,
            "tanggal_mulai" => $tanggal_mulai,
            "tanggal_selesai" => $tanggal_selesai,
            "status" => "P",
            "input_date" => date("Y-m-d H:i:s"),
            "input_by" => $this->session->userdata("nik")
        ];
        $this->db->insert("sc_trx.checklist", $dataChecklist);

        ## CHECKLIST USER
        $dataChecklistUser = [];
        foreach($nik as $v) {
            $dataChecklistUser[] = [
                "id_checklist" => $dataChecklist["id_checklist"],
                "nik" => $v
            ];
        }
        $this->db->insert_batch("sc_trx.checklist_user", $dataChecklistUser);

        ## CHECKLIST PARAMETER
        $listParameter = $this->m_checklist_master->list_parameter("WHERE a.hold = 'F' AND a.kode_periode = '$kode_periode' AND a.kode_lokasi = '$kode_lokasi'")->result();
        $dataChecklistParameter = [];
        foreach($listParameter as $v) {
            $dataChecklistParameter[] = [
                "id_checklist" => $dataChecklist["id_checklist"],
                "kode_parameter" => $v->kode_parameter,
                "nama_parameter" => $v->nama_parameter,
                "target_parameter" => $v->target_parameter,
                "urutan" => $v->urutan,
                "kddept" => $v->kddept,
                "nmdept" => $v->nmdept
            ];
        }
        $this->db->insert_batch("sc_trx.checklist_parameter", $dataChecklistParameter);

        ## CHECKLIST TANGGAL
        $dataChecklistTanggal = [];
        $minTmp = $min;
        foreach($off as $v) {
            $tanggal_mulai = $tanggal_selesai = "";
            $minItr = str_pad($minTmp,2,"0", STR_PAD_LEFT);
            if($kode_periode == "JAM") {
                $tglTmp = date("Y-m-d", strtotime($tanggal));
                $tanggal_mulai =  "$tglTmp $minItr:00:00";
                $tanggal_selesai = "$tglTmp $minItr:59:59";
            } else if($kode_periode == "HARI") {
                $tglTmp = implode("-", array_reverse(explode("-", $tanggal)));
                $tanggal_mulai = "$tglTmp-$minItr 00:00:00";
                $tanggal_selesai = "$tglTmp-$minItr 23:59:59";
            } else if($kode_periode == "BULAN") {
                $tanggal_mulai = "$tanggal-$minItr-01 00:00:00";
                $tanggal_selesai = date("Y-m-t H:i:s", strtotime("$tanggal-$minItr-01 23:59:59"));
            } else if($kode_periode == "TAHUN") {
                $tanggal_mulai = "$minItr-01-01 00:00:00";
                $tanggal_selesai = date("Y-m-t H:i:s", strtotime("$minItr-12-01 23:59:59"));
            }
            $dataChecklistTanggal[] = [
                "id_checklist" => $dataChecklist["id_checklist"],
                "tanggal_mulai" => $tanggal_mulai,
                "tanggal_selesai" => $tanggal_selesai,
                "off" => $v
            ];
            $minTmp++;
        }
        $this->db->insert_batch("sc_trx.checklist_tanggal", $dataChecklistTanggal);

        ## CHECKLIST REALISASI
        $dataChecklistRealisasi = [];
        foreach($dataChecklistUser as $vUser) {
            $minTmp = $min;
            $bag_dept = trim($this->m_karyawan->list_lvkaryawan("WHERE nik = '" . $vUser["nik"] . "'")->row()->bag_dept);
            foreach($dataChecklistTanggal as $vTanggal) {
                if($vTanggal["off"] == "F") {
                    foreach ($listParameter as $vParameter) {
                        if(in_array($bag_dept, explode(", ", $vParameter->kddept))) {
                            $dataChecklistRealisasi[] = [
                                "id_checklist" => $dataChecklist["id_checklist"],
                                "nik" => $vUser["nik"],
                                "tanggal_mulai" => $vTanggal["tanggal_mulai"],
                                "tanggal_selesai" => $vTanggal["tanggal_selesai"],
                                "kode_parameter" => $vParameter->kode_parameter,
                                "off" => !in_array($vUser["nik"] . "-" . $minTmp, $jadwal) ? "T" : "F"
                            ];
                        }
                    }
                }
                $minTmp++;
            }
        }
        $this->db->insert_batch("sc_trx.checklist_realisasi", $dataChecklistRealisasi);

        $this->db->trans_commit();
        $this->session->set_flashdata("message", ["Data Sukses Disimpan", "success"]);
        redirect("ga/checklist/jadwal");
    }

    function update($id) {
        $data["title"] = "Update Jadwal Checklist";
        $data["kodemenu"] = "I.G.J.4";
        $data["checklist"] = $this->m_checklist->list_checklist("AND id_checklist = '$id'")->row();
        $data["list_user"] = [];
        foreach($this->m_checklist->list_checklist_user("WHERE id_checklist = '$id'")->result() as $v) {
            $data["list_user"][] = trim($v->nik);
        }
        $data["list_karyawan"] = $this->m_karyawan->list_lvkaryawan("
            WHERE COALESCE(statuskepegawaian, '') != 'KO' AND bag_dept IN (
                SELECT DISTINCT UNNEST(STRING_TO_ARRAY(kddept, ', ')) AS kddept
                FROM sc_trx.checklist_parameter
                WHERE id_checklist = '$id'
            )
        ")->result();
        $data["list_parameter"] = $this->m_checklist->list_checklist_parameter("AND a.id_checklist = '$id'")->result();
        $data["list_tanggal"] = $this->m_checklist->list_checklist_tanggal("WHERE a.id_checklist = '$id'")->result();
        $data["list_periode"] = $this->m_checklist_master->list_periode()->result();
        $data["list_lokasi"] = $this->m_checklist_master->list_lokasi()->result();
        $data["list_departemen"] = $this->m_department->q_department()->result();
        $this->template->display("ga/checklist/v_edit", $data);
    }

    function edit() {
        $id_checklist = $this->input->post("id_checklist");
        $nikadd = $this->input->post("nikadd");
        $off = $this->input->post("off");
        $this->db->trans_start();

        ## CHECKLIST USER
        $dataChecklistUser = [];
        foreach($nikadd as $v) {
            $dataChecklistUser[] = [
                "id_checklist" => $id_checklist,
                "nik" => $v
            ];
        }
        if(sizeof($dataChecklistUser) > 0) {
            $this->db->insert_batch("sc_trx.checklist_user", $dataChecklistUser);
        }

        ## CHECKLIST TANGGAL
        $listTanggal = $this->m_checklist->list_checklist_tanggal("WHERE a.id_checklist = '$id_checklist'")->result();
        foreach($listTanggal as $k => $v) {
            if($v->tanggal_mulai > date("Y-m-d H:i:s")) {
                $dataChecklistTanggal = [
                    "off" => $off[$k]
                ];
                $whereChecklistTanggal = [
                    "id_checklist" => $id_checklist,
                    "tanggal_mulai" => $v->tanggal_mulai,
                    "tanggal_selesai" => $v->tanggal_selesai,
                ];
                $this->db->update('sc_trx.checklist_tanggal', $dataChecklistTanggal, $whereChecklistTanggal);
            }
        }

        ## CHECKLIST REALISASI
//        $dataChecklistRealisasi = [];
//        foreach($dataChecklistUser as $vUser) {
//            $minTmp = $min;
//            foreach($dataChecklistTanggal as $vTanggal) {
//                if($vTanggal["off"] == "F") {
//                    foreach ($listParameter as $vParameter) {
//                        $dataChecklistRealisasi[] = [
//                            "id_checklist" => $dataChecklist["id_checklist"],
//                            "nik" => $vUser["nik"],
//                            "tanggal_mulai" => $vTanggal["tanggal_mulai"],
//                            "tanggal_selesai" => $vTanggal["tanggal_selesai"],
//                            "kode_parameter" => $vParameter->kode_parameter,
//                            "off" => !in_array($vUser["nik"] . "-" . $minTmp, $jadwal) ? "T" : "F"
//                        ];
//                    }
//                }
//                $minTmp++;
//            }
//        }
//        $this->db->insert_batch("sc_trx.checklist_realisasi", $dataChecklistRealisasi);

//        vdump($off, $listTanggal);
        die;
        $this->db->trans_commit();
        $this->session->set_flashdata("message", ["Data Sukses Diubah", "info"]);
        redirect("ga/checklist/jadwal");
    }

    function detail($id) {
        $data["title"] = "Detail Jadwal Checklist";
        $data["kodemenu"] = "I.G.J.4";
        $data["checklist"] = $this->m_checklist->list_checklist("AND id_checklist = '$id'")->row();
        $data["list_user"] = [];
        foreach($this->m_checklist->list_checklist_user("WHERE id_checklist = '$id'")->result() as $v) {
            $data["list_user"][] = trim($v->nik);
        }
        $data["list_karyawan"] = $this->m_karyawan->list_lvkaryawan("
            WHERE COALESCE(statuskepegawaian, '') != 'KO' AND bag_dept IN (
                SELECT DISTINCT UNNEST(STRING_TO_ARRAY(kddept, ', ')) AS kddept
                FROM sc_trx.checklist_parameter
                WHERE id_checklist = '$id'
            )
        ")->result();
        $data["list_parameter"] = $this->m_checklist->list_checklist_parameter("AND a.id_checklist = '$id'")->result();
        $data["list_tanggal"] = $this->m_checklist->list_checklist_tanggal("WHERE a.id_checklist = '$id'")->result();
        $data["list_periode"] = $this->m_checklist_master->list_periode()->result();
        $data["list_lokasi"] = $this->m_checklist_master->list_lokasi()->result();
        $this->template->display("ga/checklist/v_detail", $data);
    }

    function realisasi() {
        $data["title"] = "Realisasi Checklist";
        $data["kodemenu"] = "I.G.J.5";
        $data["nik"] = $this->session->userdata("nik");
        $data["list_realisasi"] = $this->m_checklist->list_realisasi("AND d.tanggal_hasil IS NULL AND NOW() BETWEEN b.tanggal_mulai AND b.tanggal_selesai AND b.off = 'F' AND c.nik = '" . $data["nik"] . "'")->result();
        $this->template->display("ga/checklist/v_realisasi", $data);
    }

    function answer($id) {
        $data["title"] = "Realisasi Checklist";
        $data["kodemenu"] = "I.G.J.5";
        $data["nik"] = $this->session->userdata("nik");
        $data["checklist"] = $this->m_checklist->list_checklist("AND id_checklist = '$id'")->row();
        $data["list_hasil"] = $this->m_checklist->list_realisasi_hasil("AND a.id_checklist = '$id' AND c.nik = '" . $data["nik"] . "'")->result();
        $this->template->display("ga/checklist/v_answer", $data);
    }

    function answeradd() {
        $nik = $this->session->userdata("nik");
        $id_checklist = $this->input->post("id_checklist");
        $hasil = $this->input->post("hasil");
        $realisasi = $this->input->post("realisasi");
        $keterangan = $this->input->post("keterangan");
        $this->db->trans_start();

        $list_realisasi = $this->m_checklist->list_realisasi_hasil("AND a.id_checklist = '$id_checklist' AND c.nik = '$nik'")->result();
        foreach($list_realisasi as $k => $v) {
            $dataHasil = [
                "hasil" => in_array($v->kode_parameter, $hasil) ? "T" : "F",
                "realisasi" => strtoupper(trim($realisasi[$k])),
                "keterangan" => strtoupper(trim($keterangan[$k])),
                "tanggal_hasil" => date("Y-m-d H:i:s")
            ];
            $whereHasil = [
                "id_checklist" => $v->id_checklist,
                "nik" => trim($v->nik),
                "tanggal_mulai" => $v->tanggal_mulai,
                "tanggal_selesai" => $v->tanggal_selesai,
                "kode_parameter" => $v->kode_parameter
            ];
            $this->db->update('sc_trx.checklist_realisasi', $dataHasil, $whereHasil);
        }

        $this->db->trans_commit();
        $this->session->set_flashdata("message", ["Data Sukses Disimpan", "success"]);
        redirect("ga/checklist/realisasi");
    }

    function list_paramater() {
        $kode_periode = $this->input->post("kode_periode");
        $kode_lokasi = $this->input->post("kode_lokasi");

        $output = array(
            "data" => $this->m_checklist_master->list_parameter("WHERE a.hold = 'F' AND a.kode_periode = '$kode_periode' AND a.kode_lokasi = '$kode_lokasi'")->result()
        );

        echo json_encode($output);
    }

    function list_paramater_detail() {
        $id_checklist = $this->input->post("id_checklist");
        $nik = $this->input->post("nik");
        $tanggal_mulai = $this->input->post("tanggal_mulai");

        $data = [];
        foreach($this->m_checklist->list_checklist_parameter("AND a.id_checklist = '$id_checklist'", $nik, $tanggal_mulai)->result() as $k => $v) {
            $data[] = [
                $k + 1,
                $v->nama_parameter,
                $v->nmdept,
                $v->target_parameter,
                $v->hasil == "T" ? "YA" : ($v->hasil == "F" ? "TIDAK" : "-"),
                $v->realisasi ?: "-",
                $v->keterangan ?: "-",
                $v->tanggal_hasil ? " (" . date("d-m-Y H:i:s", strtotime($v->tanggal_hasil)) . ")" : ""
            ];
        }

        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }

    function list_karyawan() {
        $kode_periode = $this->input->post("kode_periode");
        $kode_lokasi = $this->input->post("kode_lokasi");

        echo json_encode($this->m_karyawan->list_lvkaryawan("
            WHERE COALESCE(statuskepegawaian, '') != 'KO' AND bag_dept IN (
                SELECT b.kddept
                FROM sc_mst.checklist_parameter a
                INNER JOIN sc_mst.checklist_parameter_dept b ON b.kode_parameter = a.kode_parameter
                WHERE a.kode_periode = '$kode_periode' AND a.kode_lokasi = '$kode_lokasi'
            )
        ")->result());
    }

    function list_tanggal() {
        $id_checklist = $this->input->post("id_checklist");
        $kode_periode = $this->input->post("kode_periode");
        $kode_lokasi = $this->input->post("kode_lokasi");

        echo json_encode($this->m_checklist->list_checklist_tanggal_dis("AND id_checklist != '$id_checklist' AND kode_periode = '$kode_periode' AND kode_lokasi = '$kode_lokasi'")->result());
    }

    function list_jadwal() {
        $nik_info = $this->input->post("nik_info");
        $min = $this->input->post("min");
        $max = $this->input->post("max");

        usort($nik_info, function($a, $b) {
            return strcasecmp($a["nmdept"] . $a["nmlengkap"], $b["nmdept"] . $b["nmlengkap"]);
        });

        $data = [];
        foreach($nik_info as $k => $v) {
            $data[$k] = [
                "no" => $k + 1,
                "nik" => $v["nik"],
                "nmlengkap" => $v["nmlengkap"],
                "nmdept" => $v["nmdept"],
                "elnik" => "<input type='checkbox' class='all' value='nik-$k' onclick='checkJadwal(this)'>"
            ];
            for($i = $min; $i <= $max; $i++) {
                $data[$k]["el$i"] = "<input type='checkbox' name='jadwal[]' class='all nik-$k j$i' value='" . $v["nik"] . "-$i'>";
            }
        }

        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }

    function list_jadwal_edit() {
        $id_checklist = $this->input->post("id_checklist");
        $nik_info = $this->input->post("nik_info");
        $min = $this->input->post("min");
        $max = $this->input->post("max");

        $data = [];
        foreach($nik_info as $k => $v) {
            $data[$k] = [
                $k + 1,
                $v["nik"],
                $v["nmlengkap"],
                $v["nmdept"],
                "<input type='checkbox' class='all label-check' value='nik-$k' onclick='checkJadwal(this)'>"
            ];
            $list_tanggal = $this->m_checklist->list_checklist_tanggal("WHERE a.id_checklist = '$id_checklist'", $v["nik"])->result();
            for($i = $min; $i <= $max; $i++) {
                if($list_tanggal[$i]->tanggal_mulai < date("Y-m-d H:i:s")) {
                    if($list_tanggal[$i]->off == "T") {
                        $data[$k][] = "<i class='fa fa-ban text-danger' title='OFF'></i>";
                    } else if($list_tanggal[$i]->off_user == "F") {
                        $data[$k][] = "<i class='fa fa-check text-success' title='PIC'></i>";
                    } else {
                        $data[$k][] = "<i class='fa fa-minus text-warning'></i>";
                    }
                } else {
                    if ($list_tanggal[$i]->off_user == "F") {
                        $data[$k][] = "<input type='checkbox' name='jadwal[]' class='all nik-$k j$i' value='" . $v["nik"] . "-$i' checked>";
                    } else {
                        $data[$k][] = "<input type='checkbox' name='jadwal[]' class='all nik-$k j$i' value='" . $v["nik"] . "-$i'>";
                    }
                }
            }
        }

        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }

    function list_jadwal_detail() {
        $id_checklist = $this->input->post("id_checklist");
        $nik_info = $this->input->post("nik_info");
        $min = $this->input->post("min");
        $max = $this->input->post("max");

        usort($nik_info, function($a, $b) {
            return strcasecmp($a["nmdept"] . $a["nmlengkap"], $b["nmdept"] . $b["nmlengkap"]);
        });

        $data = [];
        foreach($nik_info as $k => $v) {
            $data[$k] = [
                $k + 1,
                $v["nik"],
                $v["nmlengkap"],
                $v["nmdept"]
            ];
            $list_tanggal = $this->m_checklist->list_realisasi("AND a.id_checklist = '$id_checklist' AND c.nik = '" . $v["nik"] . "'")->result();
            for($i = $min; $i <= $max; $i++) {
                $dataTmp = "";
                if($list_tanggal[$i - $min]->off == "T") {
                    $dataTmp = "<i class='fa fa-ban text-danger' style='color: white;'></i>";
                } else if($list_tanggal[$i - $min]->off_user == "F") {
                    if(!is_null($list_tanggal[$i - $min]->tanggal_hasil)) {
                        $dataTmp = "<i class='fa fa-check text-success'></i>";
                    } else if($list_tanggal[$i - $min]->tanggal_selesai < date("Y-m-d H:i:s")) {
                        $dataTmp = "<i class='fa fa-times text-danger'></i>";
                    } else {
                        $dataTmp = "<i class='fa fa-clock-o text-info'></i>";
                    }
                } else {
                    if (!is_null($list_tanggal[$i - $min]->tanggal_hasil)) {
                        $dataTmp = "<i class='fa fa-check-circle text-success'></i>";
                    } else if($list_tanggal[$i - $min]->tanggal_selesai < date("Y-m-d H:i:s")) {
                        $dataTmp = "<i class='fa fa-minus text-warning'></i>";
                    } else {
                        $dataTmp = "<i>&nbsp;</i>";
                    }
                }
                $dataTmp .= "
                    <input type='hidden' value='" . $v["nik"] . "'>
                    <input type='hidden' value='" . $list_tanggal[$i - $min]->tanggal_mulai . "'>
                    <input type='hidden' value='" . $list_tanggal[$i - $min]->off . "'>
                ";
                $data[$k][] = $dataTmp;
            }
        }

        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }
}
