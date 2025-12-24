<?php
/*UPDATED BY RKM::20241105*/
class Generate extends CI_Controller
{
    public function uangmakan()
    {
        $this->load->model(array('master/M_RegionalOffice','trans/m_absensi','master/m_option','trans/m_uang_makan'));
        $limit = "- ".$this->m_option->q_master_read_default(' AND parameter = \'M:A:C:L\'', '1 day');
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end.$limit));
        if ((is_null($start) || $start == date('Y-m-d', 0))){
            $start = date('Y-m-d');
        }
        try {
            $this->db->trans_start();
            $arr = array();
            $dtl_opt = $this->m_absensi->q_dblink_option_uangmakan()->row_array();
			//var_dump($dtl_opt);die();
            $host = base64_decode($dtl_opt['c_hostaddr']);
            $dbname = base64_decode($dtl_opt['c_dbname']);
            $userpg = base64_decode($dtl_opt['c_userpg']);
            $passpg = base64_decode($dtl_opt['c_passpg']);
            $this->m_uang_makan->insert_rencana_kunjungan($host, $dbname, $userpg, $passpg, $start, $end);
            foreach ($this->M_RegionalOffice->read()->result() as $index => $item) {
                $this->db->query("select sc_tmp.pr_hitung_rekap_um('$item->kdcabang','$start', '$end')");
                $this->db->query("select sc_trx.pr_insert_meal_allowance('$start', '$end')");
                array_push($arr,array('office'=>$item->kdcabang));
            }
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(array(
                    'data' => $arr,
                    'statusText' => 'Berhasil',
                    'message' => 'Data berhasil disimpan',
                ));
            } else {
                throw new Exception("Error DB", 1);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
        }
    }

    public function uangmakantrial()
    {
        $this->load->model(array('master/M_RegionalOffice','trans/m_absensi','master/m_option','trans/m_uang_makan'));
        $limit = "- ".$this->m_option->q_master_read_default(' AND parameter = \'M:A:C:L\'', '1 day');
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end.$limit));
        if ((is_null($start) || $start == date('Y-m-d', 0))){
            $start = date('Y-m-d');
        }
        try {
            $this->db->trans_start();
            $arr = array();
            $dtl_opt = $this->m_absensi->q_dblink_option_uangmakan()->row_array();
            //var_dump($dtl_opt);die();
            $host = base64_decode($dtl_opt['c_hostaddr']);
            $dbname = base64_decode($dtl_opt['c_dbname']);
            $userpg = base64_decode($dtl_opt['c_userpg']);
            $passpg = base64_decode($dtl_opt['c_passpg']);
            $this->m_uang_makan->insert_rencana_kunjungan($host, $dbname, $userpg, $passpg, $start, $end);
            foreach ($this->M_RegionalOffice->read()->result() as $index => $item) {
                $this->db->query("select sc_tmp.pr_hitung_rekap_um('$item->kdcabang','$start', '$end')");
                $this->db->query("select sc_trx.pr_insert_meal_allowance('$start', '$end')");
                array_push($arr,array('office'=>$item->kdcabang));
            }
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->db->trans_commit();
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(array(
                    'data' => $arr,
                    'statusText' => 'Berhasil',
                    'message' => 'Data berhasil disimpan',
                ));
            } else {
                throw new Exception("Error DB", 1);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
        }
    }
}