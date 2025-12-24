<?php
class Checklistmaster extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(array("m_checklist_master", "master/m_department"));
        $this->load->library(array("form_validation", "template", "upload", "pdf"));
        if(!$this->session->userdata("nik")) {
            redirect("dashboard");
        }
    }

    function periode() {
        $data["title"] = "Daftar Master Periode";
        $data["kodemenu"] = "I.G.J.1";
        $data["list_periode"] = $this->m_checklist_master->list_periode()->result();
        $this->template->display("ga/checklist_master/v_periode", $data);
    }

    function edit_periode() {
        $kode_periode = strtoupper(str_replace(" ", "", trim($this->input->post("kode_periode"))));
        $nama_periode = strtoupper(trim($this->input->post("nama_periode")));
        $hold = strtoupper(trim($this->input->post("hold")));
        $update_date = date("Y-m-d H:i:s");
        $update_by = trim($this->session->userdata("nik"));

        $info = array(
            "nama_periode" => $nama_periode,
            "hold" => $hold,
            "update_date" => $update_date,
            "update_by" => $update_by
        );

        $this->db->where("kode_periode", $kode_periode);
        $this->db->update("sc_mst.checklist_periode", $info);
        $this->session->set_flashdata("message", ["Data Sukses Diubah", "info"]);
        redirect("ga/checklistmaster/periode");
    }

    function lokasi() {
        $data["title"] = "Daftar Master Lokasi";
        $data["kodemenu"] = "I.G.J.2";
        $data["list_lokasi"] = $this->m_checklist_master->list_lokasi()->result();
        $this->template->display("ga/checklist_master/v_lokasi", $data);
    }

    function add_lokasi() {
        $kode_lokasi = strtoupper(str_replace(" ", "", trim($this->input->post("kode_lokasi"))));
        $nama_lokasi = strtoupper(trim($this->input->post("nama_lokasi")));
        $hold = strtoupper(trim($this->input->post("hold")));
        $input_date = date("Y-m-d H:i:s");
        $input_by = trim($this->session->userdata("nik"));

        $cek = $this->m_checklist_master->list_lokasi("WHERE kode_lokasi = '$kode_lokasi'")->num_rows();
        if($cek == 0) {
            $info = array(
                "kode_lokasi" => $kode_lokasi,
                "nama_lokasi" => $nama_lokasi,
                "hold" => $hold,
                "input_date" => $input_date,
                "input_by" => $input_by
            );
            $this->db->insert("sc_mst.checklist_lokasi", $info);
            $this->session->set_flashdata("message", ["Data Sukses Disimpan", "success"]);
        } else {
            $this->session->set_flashdata("message", ["Kode Sudah Ada", "warning"]);
        }

        redirect("ga/checklistmaster/lokasi");
    }

    function edit_lokasi() {
        $kode_lokasi = strtoupper(str_replace(" ", "", trim($this->input->post("kode_lokasi"))));
        $nama_lokasi = strtoupper(trim($this->input->post("nama_lokasi")));
        $hold = strtoupper(trim($this->input->post("hold")));
        $update_date = date("Y-m-d H:i:s");
        $update_by = trim($this->session->userdata("nik"));

        $info = array(
            "nama_lokasi" => $nama_lokasi,
            "hold" => $hold,
            "update_date" => $update_date,
            "update_by" => $update_by
        );

        $this->db->where("kode_lokasi", $kode_lokasi);
        $this->db->update("sc_mst.checklist_lokasi", $info);
        $this->session->set_flashdata("message", ["Data Sukses Diubah", "info"]);
        redirect("ga/checklistmaster/lokasi");
    }

    function hapus_lokasi($kode_lokasi) {
        $this->db->where("kode_lokasi", $kode_lokasi);
        $this->db->delete("sc_mst.checklist_lokasi");
        $this->session->set_flashdata("message", ["Data Sukses Dihapus", "danger"]);
        redirect("ga/checklistmaster/lokasi");
    }

    function parameter() {
        $data["title"] = "Daftar Master Parameter";
        $data["kodemenu"] = "I.G.J.3";
        $data["list_periode"] = $this->m_checklist_master->list_periode("WHERE hold = 'F'")->result();
        $data["list_lokasi"] = $this->m_checklist_master->list_lokasi("WHERE a.hold = 'F'")->result();
        $data["list_parameter"] = $this->m_checklist_master->list_parameter()->result();
        $data["list_departemen"] = $this->m_department->q_department()->result();
        $this->template->display("ga/checklist_master/v_parameter", $data);
    }

    function add_parameter() {
        $kode_parameter = date("YmdHis");
        $kode_periode = strtoupper(trim($this->input->post("kode_periode")));
        $kode_lokasi = strtoupper(trim($this->input->post("kode_lokasi")));
        $urutan = trim($this->input->post("urutan"));
        $nama_parameter = strtoupper(trim($this->input->post("nama_parameter")));
        $target_parameter = strtoupper(trim($this->input->post("target_parameter")));
        $hold = strtoupper(trim($this->input->post("hold")));
        $kddept = $this->input->post("kddept");
        $input_date = date("Y-m-d H:i:s");
        $input_by = trim($this->session->userdata("nik"));

        $cek = $this->m_checklist_master->list_parameter("WHERE a.kode_parameter = '$kode_parameter'")->num_rows();
        if($cek == 0) {
            $this->db->trans_begin();
            $info = array(
                "kode_parameter" => $kode_parameter,
                "kode_periode" => $kode_periode,
                "kode_lokasi" => $kode_lokasi,
                "urutan" => $urutan,
                "nama_parameter" => $nama_parameter,
                "target_parameter" => $target_parameter,
                "hold" => $hold,
                "input_date" => $input_date,
                "input_by" => $input_by
            );
            $this->db->insert("sc_mst.checklist_parameter", $info);

            $dept_info = [];
            foreach($kddept as $v) {
                $dept_info[] = [
                    "kode_parameter" => $kode_parameter,
                    "kddept" => $v
                ];
            }
            $this->db->insert_batch("sc_mst.checklist_parameter_dept", $dept_info);

            $this->db->trans_commit();
            $this->session->set_flashdata("message", ["Data Sukses Disimpan", "success"]);
        } else {
            $this->session->set_flashdata("message", ["Kode Sudah Ada", "warning"]);
        }

        redirect("ga/checklistmaster/parameter");
    }

    function edit_parameter() {
        $kode_parameter = strtoupper(str_replace(" ", "", trim($this->input->post("kode_parameter"))));
        $kode_periode = strtoupper(trim($this->input->post("kode_periode")));
        $kode_lokasi = strtoupper(trim($this->input->post("kode_lokasi")));
        $urutan = trim($this->input->post("urutan"));
        $nama_parameter = strtoupper(trim($this->input->post("nama_parameter")));
        $target_parameter = strtoupper(trim($this->input->post("target_parameter")));
        $hold = strtoupper(trim($this->input->post("hold")));
        $kddept = $this->input->post("kddept");
        $update_date = date("Y-m-d H:i:s");
        $update_by = trim($this->session->userdata("nik"));

        $this->db->trans_begin();
        $info = array(
            "kode_periode" => $kode_periode,
            "kode_lokasi" => $kode_lokasi,
            "urutan" => $urutan,
            "nama_parameter" => $nama_parameter,
            "target_parameter" => $target_parameter,
            "hold" => $hold,
            "update_date" => $update_date,
            "update_by" => $update_by
        );
        $this->db->where("kode_parameter", $kode_parameter);
        $this->db->update("sc_mst.checklist_parameter", $info);

        $this->db->where("kode_parameter", $kode_parameter);
        $this->db->delete("sc_mst.checklist_parameter_dept");

        $dept_info = [];
        foreach($kddept as $v) {
            $dept_info[] = [
                "kode_parameter" => $kode_parameter,
                "kddept" => $v
            ];
        }
        $this->db->insert_batch("sc_mst.checklist_parameter_dept", $dept_info);

        $this->db->trans_commit();
        $this->session->set_flashdata("message", ["Data Sukses Diubah", "info"]);
        redirect("ga/checklistmaster/parameter");
    }

    function hapus_parameter($kode_parameter) {
        $this->db->where("kode_parameter", $kode_parameter);
        $this->db->delete("sc_mst.checklist_parameter_dept");

        $this->db->where("kode_parameter", $kode_parameter);
        $this->db->delete("sc_mst.checklist_parameter");
        $this->session->set_flashdata("message", ["Data Sukses Dihapus", "danger"]);
        redirect("ga/checklistmaster/parameter");
    }
}
