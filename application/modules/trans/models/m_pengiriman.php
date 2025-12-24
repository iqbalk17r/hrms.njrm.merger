<?php
// FILE: models/M_pengiriman.php
// ===============================

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengiriman extends CI_Model {

    var $table = 'USERINFO';
    var $column = array('USERID','Badgenumber','Name');
    var $order = array('USERID' => 'asc');
    private $dbsby,$dbdmk,$dbcnd,$dbjkt;

    public function __construct()
    {
        parent::__construct();
    }

    function q_trxpengiriman(){
        return $this->db->query("select * from sc_mst.trxtype where jenistrx in ('INSPEKSI') and kdtrx in ('DIS10','DIS09') order by uraian ");
    }

    function q_karyawan(){
        return $this->db->query("select * from sc_mst.karyawan order by nmlengkap asc");
    }

    function q_driver(){
        return $this->db->query("select * from sc_mst.karyawan where jabatan ='DIS09' and statuskepegawaian <>'KO' order by nmlengkap asc");
    }

    function q_helper(){
        return $this->db->query("select * from sc_mst.karyawan where jabatan ='DIS10' and statuskepegawaian <>'KO' order by nmlengkap asc");
    }

    function q_department(){
        return $this->db->query("select * from sc_mst.departmen order by nmdept asc");
    }

    function q_armada(){
        return $this->db->query("
        SELECT DISTINCT ON (TRIM(a.nopol)) 
        a.nopol, 
        b.fleet_type, 
        CASE 
        WHEN b.fleet_type = 'D' THEN 'COLT DIESEL ENGKEL'
        WHEN b.fleet_type = 'B' THEN 'COLT DIESEL DOUBLE'
        ELSE NULL
        END AS fleet_description,*
        FROM sc_mst.mbarang a
        LEFT JOIN sc_trx.pengiriman_mst b 
        ON LOWER(REPLACE(TRIM(a.nopol), ' ', '')) = LOWER(REPLACE(TRIM(b.nopol), ' ', ''))
        WHERE a.kdgroup = 'KDN' 
        AND a.kdsubgroup = 'GDG' AND FLEET_TYPE IS NOT NULL
        ORDER BY TRIM(a.nopol)"
    );
    }
    
     public function q_pengiriman_koreksi_by_wilayah($kanwil, $tgl1, $tgl2)
    {
        $kanwil_safe = $this->db->escape($kanwil);
        $tgl1_safe = $this->db->escape($tgl1);
        $tgl2_safe = $this->db->escape($tgl2);

        $sql_original = "
            SELECT
                a.inspeksi as id, a.tanggal, a.nopol, c.uraian,
                string_agg(DISTINCT b.customer_id || ' (' || regexp_replace(b.customer_name, E'[\\n\\r,]+', ' ', 'g') || ') [' || b.sjpno || ']', '|||') AS customer_info,
                count(DISTINCT b.customer_id) AS customer_count,
                a.rittage, a.jarak_cust_terjauh,
                'Disetujui' as status,
                NULL as nik_atasan,
                '1' as is_original,
                2 AS sort_order
            FROM sc_trx.pengiriman_mst a
            LEFT JOIN sc_trx.pengiriman_dtl b ON a.inspeksi = b.inspeksi
            LEFT JOIN sc_mst.trxtype c ON a.fleet_type = c.kdtrx
            WHERE a.tanggal BETWEEN $tgl1_safe AND $tgl2_safe 
              AND c.jenistrx = 'ARMADA'
              AND EXISTS (
                  SELECT 1
                  FROM sc_trx.pengiriman_mst sub
                  JOIN sc_mst.karyawan k ON TRIM(sub.user_id) = TRIM(k.nik)
                  WHERE sub.inspeksi = a.inspeksi AND k.kdcabang = $kanwil_safe
              )
            GROUP BY a.inspeksi, a.tanggal, a.nopol, c.uraian, a.rittage, a.jarak_cust_terjauh
        ";

        $sql_koreksi = "
            SELECT
                d.id_koreksi as id, d.tanggal, d.nopol, f.uraian,
                string_agg(DISTINCT e.customer_id || ' (' || regexp_replace(e.customer_name, E'[\\n\\r,]+', ' ', 'g') || ') [' || e.sjp_no || ']', '|||') AS customer_info,
                MAX(d.customer_count) AS customer_count,
                MAX(d.rittage) as rittage,
                MAX(d.jarak_cust_terjauh) as jarak_cust_terjauh,
                CASE 
                    WHEN d.status = 'A' THEN 'Menunggu Persetujuan'
                    WHEN d.status = 'P' THEN 'Disetujui'
                    WHEN d.status = 'R' THEN 'Ditolak'
                    ELSE d.status 
                END as status,
                d.nik_atasan,
                '0' as is_original,
                CASE 
                    WHEN d.status = 'A' THEN 1
                    WHEN d.status = 'P' THEN 2
                    WHEN d.status = 'R' THEN 3
                    ELSE 4
                END as sort_order
            FROM sc_trx.koreksi_pengirimanmst d
            LEFT JOIN sc_trx.koreksi_pengirimandtl e ON d.id_koreksi = e.id_koreksi
            LEFT JOIN sc_mst.trxtype f ON d.fleet_type = f.kdtrx
            WHERE d.tanggal BETWEEN $tgl1_safe AND $tgl2_safe 
              AND f.jenistrx = 'ARMADA'
              AND (
                  EXISTS (
                      SELECT 1
                      FROM sc_trx.koreksi_pengirimanmst sub
                      JOIN sc_mst.karyawan k ON TRIM(sub.user_id) = TRIM(k.nik)
                      WHERE sub.id_koreksi = d.id_koreksi AND k.kdcabang = $kanwil_safe
                  )
                  OR EXISTS (
                      SELECT 1
                      FROM sc_mst.karyawan k_input
                      WHERE (TRIM(d.input_by) = TRIM(k_input.nik) OR TRIM(d.update_by) = TRIM(k_input.nik))
                      AND k_input.kdcabang = $kanwil_safe
                  )
              )
            GROUP BY d.id_koreksi, d.tanggal, d.nopol, f.uraian, d.status, d.nik_atasan
        ";

        $sql = "
            SELECT * FROM (
                ($sql_original)
                UNION ALL
                ($sql_koreksi)
            ) AS combined_results
            ORDER BY 
                sort_order, 
                tanggal DESC, 
                nopol;
        ";

        return $this->db->query($sql);
    }
    
    function q_pengiriman_koreksi($nopol, $tgl1, $tgl2){
        $nopol_safe = $this->db->escape_str(str_replace(' ', '', $nopol));
        $tgl1_safe = $this->db->escape($tgl1);
        $tgl2_safe = $this->db->escape($tgl2);

        $sql = "
            SELECT
                a.inspeksi as id, a.tanggal, a.nopol, c.uraian,
                string_agg(DISTINCT b.customer_id || ' (' || regexp_replace(b.customer_name, E'[\\n\\r,]+', ' ', 'g') || ') [' || b.sjpno || ']', '|||') AS customer_info,
                count(DISTINCT b.customer_id) AS customer_count,
                a.rittage, a.jarak_cust_terjauh,
                NULL as status,
                NULL as nik_atasan
            FROM sc_trx.pengiriman_mst a
            LEFT JOIN sc_trx.pengiriman_dtl b ON a.inspeksi = b.inspeksi
            LEFT JOIN sc_mst.trxtype c ON a.fleet_type = c.kdtrx
            WHERE REPLACE(a.nopol, ' ', '') = '$nopol_safe'
                AND a.tanggal BETWEEN $tgl1_safe AND $tgl2_safe AND c.jenistrx ='ARMADA'
            GROUP BY a.inspeksi, a.tanggal, a.nopol, c.uraian, a.rittage, a.jarak_cust_terjauh

            UNION ALL

            SELECT
                d.id_koreksi as id, d.tanggal, d.nopol, f.uraian,
                string_agg(DISTINCT e.customer_id || ' (' || regexp_replace(e.customer_name, E'[\\n\\r,]+', ' ', 'g') || ') [' || e.sjp_no || ']', '|||') AS customer_info,
                MAX(d.customer_count) AS customer_count,
                MAX(d.rittage) as rittage,
                MAX(d.jarak_cust_terjauh) as jarak_cust_terjauh,
                d.status,
                d.nik_atasan
            FROM sc_trx.koreksi_pengirimanmst d
            LEFT JOIN sc_trx.koreksi_pengirimandtl e ON d.id_koreksi = e.id_koreksi
            LEFT JOIN sc_mst.trxtype f ON d.fleet_type = f.kdtrx
            WHERE REPLACE(d.nopol, ' ', '') = '$nopol_safe'
                AND d.tanggal BETWEEN $tgl1_safe AND $tgl2_safe AND f.jenistrx ='ARMADA'
            GROUP BY d.id_koreksi, d.tanggal, d.nopol, f.uraian, d.status, d.nik_atasan
            ORDER BY tanggal DESC, nopol;
        ";

        return $this->db->query($sql);
    }

    public function get_pengiriman_for_edit($id)
    {
        $is_koreksi = (strpos($id, 'INS') === 0);

        if ($is_koreksi) {

            $this->db->select('d.id_koreksi, d.nopol, d.tanggal, d.rittage, d.jarak_cust_terjauh, d.fleet_type');
            $this->db->from('sc_trx.koreksi_pengirimanmst d');
            $this->db->where('d.id_koreksi', $id);
            $this->db->limit(1);
            $master = $this->db->get()->row_array();

            if (!$master) return null;

            $this->db->select("e.sjp_no as sjpno, e.customer_id");
            $this->db->from('sc_trx.koreksi_pengirimandtl e');
            $this->db->where('e.id_koreksi', $id);
            $master['details'] = $this->db->get()->result_array();

            $this->db->select("driver, helper");
            $this->db->from("sc_trx.koreksi_pengirimandtl");
            $this->db->where("id_koreksi", $id);
            $this->db->limit(1);
            $crew_from_dtl = $this->db->get()->row_array();

            if ($crew_from_dtl) {
                $master['driver_name'] = $crew_from_dtl['driver'];
                $master['helpers'] = !empty($crew_from_dtl['helper']) ? explode(', ', $crew_from_dtl['helper']) : [];
            } else {
                $master['driver_name'] = '';
                $master['helpers'] = [];
            }
            
            $master['is_original'] = false;

        } else {

            $this->db->select('a.inspeksi as id_koreksi, a.nopol, a.tanggal, a.rittage, a.jarak_cust_terjauh, a.fleet_type');
            $this->db->from('sc_trx.pengiriman_mst a');
            $this->db->where('a.inspeksi', $id);
            $this->db->limit(1);
            $master = $this->db->get()->row_array();

            if (!$master) return null;

            $this->db->select('b.sjpno, b.customer_id');
            $this->db->from('sc_trx.pengiriman_dtl b');
            $this->db->where('b.inspeksi', $id);
            $master['details'] = $this->db->get()->result_array();

            $this->db->select("pm.user_id, k.nmlengkap, k.jabatan");
            $this->db->from("sc_trx.pengiriman_mst pm");
            $this->db->join("sc_mst.karyawan k", "TRIM(pm.user_id) = TRIM(k.nik)", "LEFT");
            $this->db->where("pm.inspeksi", $id);
            $crew = $this->db->get()->result_array();

            $master['driver_name'] = '';
            $master['helpers'] = [];
            $driver_found = false;

            foreach ($crew as $person) {
                if ($person['jabatan'] === 'DIS09') {
                    $master['driver_name'] = !empty($person['nmlengkap']) ? $person['nmlengkap'] : $person['user_id'];
                    $driver_found = true;
                    break; 
                }
            }
            
            if (!$driver_found && !empty($crew)) {
                $first_person = $crew[0];
                $master['driver_name'] = !empty($first_person['nmlengkap']) ? $first_person['nmlengkap'] : $first_person['user_id'];
            }

            foreach ($crew as $person) {
                $name = !empty($person['nmlengkap']) ? $person['nmlengkap'] : $person['user_id'];
                if ($name !== $master['driver_name']) {
                    $master['helpers'][] = $name;
                }
            }
            
            $master['is_original'] = true;
        }
        
        return $master;
    }

    function q_kanwil(){
        return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang");
    }

    public function get_list_customer() {
        $this->db->select('customer_id, customer_name');
        $this->db->distinct();
        $this->db->from('sc_trx.pengiriman_dtl');
        $this->db->order_by('customer_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function simpan_koreksi_mst_dtl($data_master, $data_detail)
    {
        $this->db->trans_start();
        $user_id_pengaju = $this->session->userdata('nik');
        $atasan_info = $this->db->select('nik_atasan')->get_where('sc_mst.karyawan', ['nik' => $user_id_pengaju])->row();
        $nik_atasan = $atasan_info ? $atasan_info->nik_atasan : null;

        $prefix = 'INS' . date('ym');
        $this->db->select_max('id_koreksi');
        $this->db->like('id_koreksi', $prefix, 'after');
        $query = $this->db->get('sc_trx.koreksi_pengirimanmst');
        $last_id_row = $query->row();
        $sequence = 1;
        if ($last_id_row && $last_id_row->id_koreksi) {
            $last_sequence = (int) substr($last_id_row->id_koreksi, 7);
            $sequence = $last_sequence + 1;
        }
        $running_number = str_pad($sequence, 5, '0', STR_PAD_LEFT);
        $id_koreksi = $prefix . $running_number;

        $crew_list = [];
        if (!empty($data_master['driver_name'])) {
            $crew_list[] = $data_master['driver_name'];
        }
        if (!empty($data_master['helpers']) && is_array($data_master['helpers'])) {
            $valid_helpers = array_filter($data_master['helpers']);
            if (!empty($valid_helpers)) {
                $crew_list = array_merge($crew_list, $valid_helpers);
            }
        }

        if (!empty($crew_list)) {
            foreach ($crew_list as $nama_personil) {
                $nama_personil_trimmed = trim($nama_personil);
                if (empty($nama_personil_trimmed)) continue;

                $karyawan_info = $this->db->select('nik')->get_where('sc_mst.karyawan', ['nmlengkap' => $nama_personil_trimmed])->row();
                
                $user_id = $karyawan_info ? $karyawan_info->nik : $nama_personil_trimmed;

                $mst_to_insert = [
                    'id_koreksi'        => $id_koreksi, 'nopol' => $data_master['nopol'],
                    'user_id'           => $user_id, 'tanggal' => $data_master['tanggal'],
                    'fleet_type'        => $data_master['fleet_type'], 'customer_count' => count($data_detail),
                    'rittage'           => $data_master['rittage'], 'jarak_cust_terjauh' => $data_master['jarak_cust_terjauh'],
                    'status'            => 'A', 
                    'nik_atasan'        => $nik_atasan,
                    'input_by'          => $user_id_pengaju,
                    'input_date'        => date('Y-m-d H:i:s')
                ];
                $this->db->insert('sc_trx.koreksi_pengirimanmst', $mst_to_insert);
            }
        }

        if (!empty($data_detail) && is_array($data_detail)) {
            foreach ($data_detail as $detail) {
                if(empty($detail['customer_id']) || empty($detail['sjpno'])) continue;

                $customer_info = $this->db->select('customer_name')->get_where('sc_trx.pengiriman_dtl', ['customer_id' => $detail['customer_id']])->row();
                $customer_name = $customer_info ? $customer_info->customer_name : '';

                $dtl_to_insert = [
                    'id_koreksi'    => $id_koreksi, 'sjp_no' => $detail['sjpno'],
                    'customer_id'   => $detail['customer_id'], 'customer_name' => $customer_name,
                    'nopol'         => $data_master['nopol'], 'tanggal' => $data_master['tanggal'],
                    'driver'        => $data_master['driver_name'], 'helper' => is_array($data_master['helpers']) ? implode(', ', array_filter($data_master['helpers'])) : null,
                    'ritase'        => $data_master['rittage'], 'user_create'   => $this->session->userdata('nik'),
                    'tgl_create'    => date('Y-m-d H:i:s')
                ];
                $this->db->insert('sc_trx.koreksi_pengirimandtl', $dtl_to_insert);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function replace_original_data($original_id, $data_master, $data_detail)
    {
        $this->db->trans_start();

        $this->db->where('inspeksi', $original_id);
        $this->db->delete('sc_trx.pengiriman_dtl');

        $this->db->where('inspeksi', $original_id);
        $this->db->delete('sc_trx.pengiriman_mst');

        $this->simpan_koreksi_mst_dtl($data_master, $data_detail);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_koreksi_data($id_koreksi, $data_master, $data_detail)
    {
        $this->db->trans_start();

        $this->db->where('id_koreksi', $id_koreksi);
        $this->db->delete('sc_trx.koreksi_pengirimanmst');

        $this->db->where('id_koreksi', $id_koreksi);
        $this->db->delete('sc_trx.koreksi_pengirimandtl');

        $user_id_pengaju = $this->session->userdata('nik');
        $atasan_info = $this->db->select('nik_atasan')->get_where('sc_mst.karyawan', ['nik' => $user_id_pengaju])->row();
        $nik_atasan = $atasan_info ? $atasan_info->nik_atasan : null;

        $crew_list = [];
        if (!empty($data_master['driver_name'])) {
            $crew_list[] = $data_master['driver_name'];
        }
        if (!empty($data_master['helpers']) && is_array($data_master['helpers'])) {
            $valid_helpers = array_filter($data_master['helpers']);
            if (!empty($valid_helpers)) {
                $crew_list = array_merge($crew_list, $valid_helpers);
            }
        }

        if (!empty($crew_list)) {
            foreach ($crew_list as $nama_personil) {
                $nama_personil_trimmed = trim($nama_personil);
                if (empty($nama_personil_trimmed)) continue;

                $karyawan_info = $this->db->select('nik')->get_where('sc_mst.karyawan', ['nmlengkap' => $nama_personil_trimmed])->row();
                
                $user_id = $karyawan_info ? $karyawan_info->nik : $nama_personil_trimmed;

                $mst_to_insert = [
                    'id_koreksi'        => $id_koreksi, 'nopol' => $data_master['nopol'],
                    'user_id'           => $user_id, 'tanggal' => $data_master['tanggal'],
                    'fleet_type'        => $data_master['fleet_type'], 'customer_count' => count($data_detail),
                    'rittage'           => $data_master['rittage'], 'jarak_cust_terjauh' => $data_master['jarak_cust_terjauh'],
                    'status'            => 'A', 
                    'nik_atasan'        => $nik_atasan,
                    'update_by'         => $user_id_pengaju,
                    'update_date'       => date('Y-m-d H:i:s')
                ];
                $this->db->insert('sc_trx.koreksi_pengirimanmst', $mst_to_insert);
            }
        }

        if (!empty($data_detail) && is_array($data_detail)) {
            foreach ($data_detail as $detail) {
                if(empty($detail['customer_id']) || empty($detail['sjpno'])) continue;

                $customer_info = $this->db->select('customer_name')->get_where('sc_trx.pengiriman_dtl', ['customer_id' => $detail['customer_id']])->row();
                $customer_name = $customer_info ? $customer_info->customer_name : '';

                $dtl_to_insert = [
                    'id_koreksi'    => $id_koreksi, 'sjp_no' => $detail['sjpno'],
                    'customer_id'   => $detail['customer_id'], 'customer_name' => $customer_name,
                    'nopol'         => $data_master['nopol'], 'tanggal' => $data_master['tanggal'],
                    'driver'        => $data_master['driver_name'], 'helper' => is_array($data_master['helpers']) ? implode(', ', array_filter($data_master['helpers'])) : null,
                    'ritase'        => $data_master['rittage'], 'user_create' => $this->session->userdata('nik'),
                    'tgl_create'    => date('Y-m-d H:i:s')
                ];
                $this->db->insert('sc_trx.koreksi_pengirimandtl', $dtl_to_insert);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function execute_pr_hitung_gajipengiriman()
    {
        $this->db->query("SELECT sc_trx.pr_hitung_gajipengiriman();");
    }

    function q_gaji_pengiriman_ready($kanwil,$tglawal,$tglakhir,$ketsts){
        $sql = "
        SELECT a.*,
            CAST(b.upah_harian AS INTEGER) AS upah_harian,
            CAST(CASE WHEN a.rittage >= 1 THEN b.rit1 ELSE 0 END AS INTEGER) AS rit1,
            CAST(CASE WHEN a.rittage >= 2 THEN b.rit2 ELSE 0 END AS INTEGER) AS rit2,
            CAST(CASE WHEN a.jml_toko > 5 THEN b.jml_toko ELSE 0 END AS INTEGER) AS jml_toko,
            CAST(CASE WHEN a.jml_jarak > 60 AND a.jml_jarak <= 100 THEN b.jml_jarak1 WHEN a.jml_jarak > 100 THEN 0 ELSE 0 END AS INTEGER) AS jml_jarak1,
            CAST(CASE WHEN a.jml_jarak > 60 AND a.jml_jarak <= 100 THEN 0 WHEN a.jml_jarak > 100 THEN b.jml_jarak2 ELSE 0 END AS INTEGER) AS jml_jarak2,
            CAST((
                COALESCE(b.upah_harian, 0) +
                COALESCE(CASE WHEN a.rittage >= 1 THEN b.rit1 ELSE 0 END, 0) +
                COALESCE(CASE WHEN a.rittage >= 2 THEN b.rit2 ELSE 0 END, 0) +
                COALESCE(CASE WHEN a.jml_toko > 5 THEN b.jml_toko ELSE 0 END, 0) +
                COALESCE(CASE WHEN a.jml_jarak > 60 AND a.jml_jarak <= 100 THEN b.jml_jarak1 WHEN a.jml_jarak > 100 THEN 0 ELSE 0 END, 0) +
                COALESCE(CASE WHEN a.jml_jarak > 60 AND a.jml_jarak <= 100 THEN 0 WHEN a.jml_jarak > 100 THEN b.jml_jarak2 ELSE 0 END, 0)
            ) AS INTEGER) AS total,
            a.id_trx
        FROM (

            SELECT 
                nopol, TRIM(user_id) AS nik, nmlengkap, tanggal, 
                fleet_type AS armada, nmjabatan,
                CASE WHEN nmjabatan = 'DRIVER' THEN 'DR' WHEN nmjabatan = 'HELPER' THEN 'HK' ELSE 'HG' END AS kdjabatan,
                kdcabang, a.rittage, customer_count AS jml_toko, 
                jarak_cust_terjauh AS jml_jarak, a.inspeksi as id_trx
            FROM SC_TRX.pengiriman_mst a
            LEFT OUTER JOIN sc_mst.karyawan b ON TRIM(a.user_id) = TRIM(b.nik) 
            LEFT OUTER JOIN sc_mst.jabatan c ON b.bag_dept = c.kddept AND b.subbag_dept = c.kdsubdept AND b.jabatan = c.kdjabatan 
            WHERE tanggal BETWEEN '$tglawal' AND '$tglakhir' AND kdcabang = '$kanwil' $ketsts
            
            UNION ALL 

            SELECT 
                kp.nopol, TRIM(kp.user_id) as nik, COALESCE(d.nmlengkap, kp.user_id) as nmlengkap, 
                kp.tanggal, kp.fleet_type as armada, e.nmjabatan, 
                CASE WHEN e.nmjabatan = 'DRIVER' THEN 'DR' WHEN e.nmjabatan = 'HELPER' THEN 'HK' ELSE 'HG' END AS kdjabatan, 
                COALESCE(d.kdcabang, '$kanwil') as kdcabang, kp.rittage, 
                kp.customer_count AS jml_toko, kp.jarak_cust_terjauh AS jml_jarak,
                kp.id_koreksi as id_trx
            FROM SC_TRX.koreksi_pengirimanmst kp 
            LEFT JOIN sc_mst.karyawan d ON TRIM(kp.user_id) = TRIM(d.nik) 
            LEFT JOIN sc_mst.jabatan e ON d.bag_dept = e.kddept AND d.subbag_dept = e.kdsubdept AND d.jabatan = e.kdjabatan
            WHERE kp.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND kp.status = 'P' $ketsts

            UNION ALL

            SELECT
                'GUDANG' as nopol, a.nik, b.nmlengkap, a.tanggal,
                NULL as armada, 'HELPER GUDANG' as nmjabatan,
                'HG' as kdjabatan, -- Kode Jabatan untuk Helper Gudang
                a.kdcabang, 0 as rittage, 0 as jml_toko,
                0 as jml_jarak, CAST(a.id_koreksi_hg AS VARCHAR) as id_trx
            FROM sc_trx.koreksi_helpergudang a
            JOIN sc_mst.karyawan b ON a.nik = b.nik
            WHERE a.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND a.kdcabang = '$kanwil'

        ) AS a 
        LEFT OUTER JOIN (
            SELECT * FROM sc_mst.gajipengiriman WHERE kdjabatan <> 'HG'
            UNION ALL
            SELECT DISTINCT ON (kdcabang, kdjabatan) * FROM sc_mst.gajipengiriman WHERE kdjabatan = 'HG'
        ) b ON a.kdcabang = b.kdcabang 
          AND a.kdjabatan = b.kdjabatan 
          AND (a.kdjabatan = 'HG' OR a.armada = b.armada)
        WHERE a.kdcabang = '$kanwil'
        ORDER BY a.nik, a.tanggal
        ";
        return $this->db->query($sql);
    }

    function q_insentif_pengiriman($kanwil, $tglawal, $tglakhir, $ketsts) {
        return $this->q_gaji_pengiriman_ready($kanwil, $tglawal, $tglakhir, $ketsts);
    }

    public function get_detail_pengiriman_by_id($id)
    {
        $is_koreksi = (strpos($id, 'INS') === 0);
        $data = ['header' => null, 'details' => []];

        if ($is_koreksi) {
            $this->db->select("rittage, jarak_cust_terjauh");
            $this->db->from("sc_trx.koreksi_pengirimanmst");
            $this->db->where("id_koreksi", $id);
            $this->db->limit(1);
            $data['header'] = $this->db->get()->row();

            $this->db->select("sjp_no as sj, customer_id, customer_name");
            $this->db->from("sc_trx.koreksi_pengirimandtl");
            $this->db->where("id_koreksi", $id);
            $data['details'] = $this->db->get()->result();

        } else {
            $this->db->select("rittage, jarak_cust_terjauh");
            $this->db->from("sc_trx.pengiriman_mst");
            $this->db->where("inspeksi", $id);
            $this->db->limit(1);
            $data['header'] = $this->db->get()->row();

            $this->db->select("sjpno as sj, customer_id, customer_name");
            $this->db->from("sc_trx.pengiriman_dtl");
            $this->db->where("inspeksi", $id);
            $data['details'] = $this->db->get()->result();
        }
        
        return $data;
    }

    public function approve_koreksi($id, $approver_nik)
    {
        $data = [
            'status' => 'P', 
            'approval_by' => $approver_nik,
            'approval_date' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_koreksi', $id);
        return $this->db->update('sc_trx.koreksi_pengirimanmst', $data);
    }

    public function reject_koreksi($id, $rejector_nik)
    {
        $data = [
            'status' => 'R', 
            'approval_by' => $rejector_nik,
            'approval_date' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_koreksi', $id);
        return $this->db->update('sc_trx.koreksi_pengirimanmst', $data);
    }
    
    public function hapus_data_koreksi($id)
    {
        $this->db->trans_start();
        $this->db->where('id_koreksi', $id);
        $this->db->delete('sc_trx.koreksi_pengirimandtl');
        $this->db->where('id_koreksi', $id);
        $this->db->delete('sc_trx.koreksi_pengirimanmst');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function hapus_data_asli($id)
    {
        $this->db->trans_start();

        $this->db->where('inspeksi', $id);
        $this->db->delete('sc_trx.pengiriman_dtl');

        $this->db->where('inspeksi', $id);
        $this->db->delete('sc_trx.pengiriman_mst');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function q_insentif_driver($kanwil, $um_tgl1, $um_tgl2, $kehadiran_tgl1, $kehadiran_tgl2, $insentif_tgl1, $insentif_tgl2)
    {
        $safe_kanwil = $this->db->escape($kanwil);
        $safe_um_tgl1 = $this->db->escape($um_tgl1);
        $safe_um_tgl2 = $this->db->escape($um_tgl2);
        $safe_kehadiran_tgl1 = $this->db->escape($kehadiran_tgl1);
        $safe_kehadiran_tgl2 = $this->db->escape($kehadiran_tgl2);
        $safe_insentif_tgl1 = $this->db->escape($insentif_tgl1);
        $safe_insentif_tgl2 = $this->db->escape($insentif_tgl2);

        $sql = "
        WITH uangmakan AS (
            SELECT nik, kdjabatan, SUM(uang_makan) AS total_uang_makan
            FROM sc_trx.gajipengiriman
            WHERE tanggal BETWEEN $safe_um_tgl1 AND $safe_um_tgl2
            GROUP BY nik, kdjabatan
        ),
        kehadiran AS (
            SELECT nik, SUM(tjkehadiran) AS total_tunj_kehadiran
            FROM sc_trx.rekap_tjkehadiran
            WHERE tanggal_mulai BETWEEN $safe_kehadiran_tgl1 AND $safe_kehadiran_tgl2
            GROUP BY nik
        ),
        ritase AS (
            SELECT nik, COUNT(*) AS total_ritase, SUM(CASE WHEN rit2 > 0 THEN 1 ELSE 0 END) AS rit2_count
            FROM sc_trx.gajipengiriman
            WHERE tanggal BETWEEN $safe_insentif_tgl1 AND $safe_insentif_tgl2
            GROUP BY nik
        ),
        insentif AS (
            SELECT DISTINCT ON (r.nik) r.nik, g.kdcabang, g.kdjabatan, g.armada,
                CASE 
                    WHEN r.total_ritase = 0 THEN 0
                    WHEN (r.rit2_count::decimal / r.total_ritase) = 0.5 THEN gaji.insentif1
                    WHEN (r.rit2_count::decimal / r.total_ritase) > 0.5 AND (r.rit2_count::decimal / r.total_ritase) <= 0.8 THEN gaji.insentif2
                    WHEN (r.rit2_count::decimal / r.total_ritase) > 0.8 THEN gaji.insentif3
                    ELSE 0
                END AS total_insentif
            FROM ritase r
            JOIN (
                SELECT DISTINCT ON (nik) nik, kdcabang, kdjabatan, armada 
                FROM sc_trx.gajipengiriman WHERE tanggal BETWEEN $safe_insentif_tgl1 AND $safe_insentif_tgl2
                ORDER BY nik, tanggal DESC
            ) g ON r.nik = g.nik
            JOIN sc_mst.gajipengiriman gaji ON g.kdjabatan = gaji.kdjabatan AND g.armada = gaji.armada
        ),
        bpjs AS (
            SELECT bk.nik,
                SUM(CASE WHEN kb.kodekomponen = 'BPJSKES' THEN (kb.besarankaryawan / 100.0) * k.gajibpjs ELSE 0 END) AS bpjs_k,
                SUM(CASE WHEN kb.kodekomponen = 'JHT' THEN (kb.besarankaryawan / 100.0) * k.gajibpjs ELSE 0 END) AS bpjs_tk
            FROM sc_trx.bpjs_karyawan bk
            JOIN sc_mst.komponen_bpjs kb ON bk.kode_bpjs = kb.kode_bpjs AND kb.kodekomponen IN ('BPJSKES', 'JHT')
            JOIN sc_mst.karyawan k ON bk.nik = k.nik
            GROUP BY bk.nik
        )
        SELECT DISTINCT ON (k.nik) 
            k.nik, k.nmlengkap, j.nmjabatan,
            CASE WHEN j.nmjabatan = 'DRIVER' THEN 'DR' WHEN j.nmjabatan = 'HELPER' THEN 'HK' ELSE 'HG' END AS kdjabatan,
            k.kdcabang,
            COALESCE(um.total_uang_makan, 0) AS um,
            COALESCE(kd.total_tunj_kehadiran, 0) AS tunj_kehadiran,
            COALESCE(fi.total_insentif, 0) AS insentif,
            COALESCE(bp.bpjs_k, 0) AS bpjs_k,
            COALESCE(bp.bpjs_tk, 0) AS bpjs_tk,
            (COALESCE(um.total_uang_makan, 0) 
            + COALESCE(kd.total_tunj_kehadiran, 0) 
            + COALESCE(fi.total_insentif, 0) 
            - COALESCE(bp.bpjs_k, 0) 
            - COALESCE(bp.bpjs_tk, 0)) AS total
        FROM (
            SELECT DISTINCT TRIM(user_id) as nik FROM sc_trx.pengiriman_mst WHERE tanggal BETWEEN $safe_insentif_tgl1 AND $safe_insentif_tgl2
            UNION
            SELECT DISTINCT TRIM(user_id) as nik FROM sc_trx.koreksi_pengirimanmst WHERE tanggal BETWEEN $safe_insentif_tgl1 AND $safe_insentif_tgl2 AND status = 'P'
            UNION
            SELECT DISTINCT nik FROM sc_trx.koreksi_helpergudang WHERE tanggal BETWEEN $safe_insentif_tgl1 AND $safe_insentif_tgl2
        ) pm
        LEFT JOIN sc_mst.karyawan k ON pm.nik = k.nik 
        LEFT JOIN sc_mst.jabatan j ON k.bag_dept = j.kddept AND k.subbag_dept = j.kdsubdept AND k.jabatan = j.kdjabatan
        LEFT JOIN uangmakan um ON k.nik = um.nik
        LEFT JOIN kehadiran kd ON k.nik = kd.nik
        LEFT JOIN insentif fi ON k.nik = fi.nik
        LEFT JOIN bpjs bp ON k.nik = bp.nik
        WHERE k.kdcabang = $safe_kanwil AND k.nik IS NOT NULL AND K.statuskepegawaian <>'KO'
        ORDER BY k.nik;
        ";
        
        return $this->db->query($sql);
    }

    public function execute_pr_rekap_tjkehadiran()
    {
        $this->db->query("SELECT sc_trx.pr_rekap_tjkehadiran();");
    }
      public function q_helper_gudang_by_wilayah($kanwil, $tgl1, $tgl2)
    {
        $this->db->select('a.id_koreksi_hg, a.tanggal, a.nik, b.nmlengkap');
        $this->db->from('sc_trx.koreksi_helpergudang a');
        $this->db->join('sc_mst.karyawan b', 'a.nik = b.nik');
        $this->db->where('a.kdcabang', $kanwil);
        $this->db->where('a.tanggal >=', $tgl1);
        $this->db->where('a.tanggal <=', $tgl2);
        $this->db->order_by('a.tanggal', 'DESC');
        return $this->db->get();
    }

  
    public function simpan_helper_gudang($data_helper)
    {
        $this->db->trans_start();
        $user_id_pengaju = $this->session->userdata('nik');
        
        $helpers = $data_helper['helpers'];
        $tanggal = $data_helper['tanggal'];
        $kanwil = $data_helper['kanwil'];

        foreach ($helpers as $nik) {
            $data_to_insert = [
                'tanggal'   => $tanggal,
                'nik'       => $nik,
                'kdcabang'  => $kanwil,
                'input_by'  => $user_id_pengaju,
                'input_date'=> date('Y-m-d H:i:s')
            ];
            $this->db->insert('sc_trx.koreksi_helpergudang', $data_to_insert);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    
    public function hapus_helper_gudang($id)
    {
        $this->db->where('id_koreksi_hg', $id);
        return $this->db->delete('sc_trx.koreksi_helpergudang');
    }
}
