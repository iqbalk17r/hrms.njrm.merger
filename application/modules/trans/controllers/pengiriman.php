<?php
// FILE: controllers/Pengiriman.php
// ===================================

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(array('m_pengiriman','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','Excel_generator'));
        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }

    function filter_detail(){
        $kmenu='I.L.P.01';
        $nama=$this->session->userdata('nik');
        $data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        $data['title']='Filter Detail Data Gaji Pengiriman';
        $data['list_karyawan']=$this->m_pengiriman->q_karyawan()->result();
        $data['list_kanwil']=$this->m_pengiriman->q_kanwil()->result();
        $data['list_dept']=$this->m_pengiriman->q_department()->result();
        $data['list_trxpengiriman']=$this->m_pengiriman->q_trxpengiriman()->result();
        $this->template->display('trans/pengiriman/v_filterdetailpengiriman',$data);
    }

    function filter_koreksi(){
        $data['message'] = $this->session->flashdata('message');
        $kmenu='I.L.P.02';
        $nama=$this->session->userdata('nik');
        $data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
        $data['title']='Filter Koreksi Data Pengiriman';
        $data['list_kanwil']=$this->m_pengiriman->q_kanwil()->result();
        $data['list_helper']=$this->m_pengiriman->q_helper()->result();
        $this->template->display('trans/pengiriman/v_filterkoreksi',$data);
    }

    function koreksipengiriman(){
        $tanggal = $this->input->post('tgl');
        $tgl = explode(' - ', $tanggal);
        $tgl1 = $tgl[0];
        $tgl2 = $tgl[1];
        $kanwil = trim($this->input->post('kanwil'));

        if (empty($tanggal) || empty($kanwil)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Silakan pilih wilayah dan tanggal terlebih dahulu.</div>');
            redirect('trans/pengiriman/filter_koreksi');
        } else {
            redirect("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil)."/{$tgl1}/{$tgl2}");
        }
    }

    function lihat_koreksi_kar($kanwil_encoded, $tgl1, $tgl2){
        $data['message'] = $this->session->flashdata('message');
        $data['title']="KOREKSI DATA PENGIRIMAN";
        
        $kanwil = rawurldecode($kanwil_encoded);
        $tgl1_db = date('Y-m-d', strtotime($tgl1));
        $tgl2_db = date('Y-m-d', strtotime($tgl2));

        $list_pengiriman_raw = $this->m_pengiriman->q_pengiriman_koreksi_by_wilayah($kanwil, $tgl1_db, $tgl2_db)->result();
        
        $list_pengiriman_with_details = [];
        foreach($list_pengiriman_raw as $row) {
            $detail_data = $this->m_pengiriman->get_pengiriman_for_edit($row->id);
            
            if (!empty($detail_data['fleet_type'])) {
                $armada_info = $this->db->get_where('sc_mst.trxtype', ['kdtrx' => $detail_data['fleet_type']])->row();
                $detail_data['armada_description'] = $armada_info ? $armada_info->uraian : 'Tidak diketahui';
            } else {
                $detail_data['armada_description'] = 'Tidak ada';
            }
            
            $row->detail_payload = $detail_data;
            $list_pengiriman_with_details[] = $row;
        }
        
        $data['list_pengiriman'] = $list_pengiriman_with_details;
        
        $data['list_armada']=$this->m_pengiriman->q_armada()->result();
        $data['list_driver']=$this->m_pengiriman->q_driver()->result();
        $data['list_helper']=$this->m_pengiriman->q_helper()->result();
        $data['list_customer'] = $this->m_pengiriman->get_list_customer();
        
        $data['kanwil_filter'] = $kanwil;
        $data['tgl1_filter'] = $tgl1;
        $data['tgl2_filter'] = $tgl2;
        
        $this->template->display('trans/pengiriman/v_koreksipengiriman',$data);
    }

    public function edit_pengiriman($id, $kanwil_filter_encoded, $tgl1_filter, $tgl2_filter)
    {
        $data['title'] = "Edit Data Pengiriman";
        
        $data['pengiriman'] = $this->m_pengiriman->get_pengiriman_for_edit($id);
        
        if (!$data['pengiriman']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan.</div>');
            redirect('trans/pengiriman/filter_koreksi');
            return;
        }

        $data['list_driver'] = $this->m_pengiriman->q_driver()->result();
        $data['list_helper'] = $this->m_pengiriman->q_helper()->result();
        $data['list_customer'] = $this->m_pengiriman->get_list_customer();

        $data['kanwil_filter'] = rawurldecode($kanwil_filter_encoded);
        $data['tgl1_filter'] = $tgl1_filter;
        $data['tgl2_filter'] = $tgl2_filter;

        $this->template->display('trans/pengiriman/v_edit_pengiriman', $data);
    }

    public function input_pengiriman()
    {
        $data_master = [
            'nopol'                 => $this->input->post('nopol'),
            'tanggal'               => $this->input->post('tanggal'),
            'fleet_type'            => $this->input->post('armada'),
            'driver_name'           => $this->input->post('driver'),
            'rittage'               => $this->input->post('ritase'),
            'jarak_cust_terjauh'    => $this->input->post('jarak'),
            'helpers'               => $this->input->post('helpers')
        ];

        $surat_jalan_list = $this->input->post('surat_jalan');
        $customer_list = $this->input->post('customer');
        $data_detail = [];
        if (is_array($surat_jalan_list)) {
            for ($i = 0; $i < count($surat_jalan_list); $i++) {
                if (!empty($surat_jalan_list[$i])) {
                    $data_detail[] = ['sjpno' => $surat_jalan_list[$i], 'customer_id' => $customer_list[$i]];
                }
            }
        }

        $kanwil_filter = $this->input->post('kanwil_filter');
        $tgl1_filter = $this->input->post('tgl1_filter');
        $tgl2_filter = $this->input->post('tgl2_filter');

        $success = $this->m_pengiriman->simpan_koreksi_mst_dtl($data_master, $data_detail);

        if ($success) {
            $message = ['type' => 'success', 'text' => 'Data pengiriman baru berhasil disimpan dan menunggu approval.'];
            $this->session->set_flashdata('message', $message);
        } else {
            $message = ['type' => 'danger', 'text' => 'Gagal menyimpan data pengiriman baru.'];
            $this->session->set_flashdata('message', $message);
        }

        redirect("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}");
    }

    public function update_pengiriman()
    {
        $id_koreksi = $this->input->post('id_koreksi');
        $is_original = $this->input->post('is_original');

        $kanwil_filter = $this->input->post('kanwil_filter');
        $tgl1_filter = $this->input->post('tgl1_filter');
        $tgl2_filter = $this->input->post('tgl2_filter');

        if (!$id_koreksi || !$kanwil_filter || !$tgl1_filter || !$tgl2_filter) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Terjadi kesalahan, parameter tidak lengkap.</div>');

            redirect('trans/pengiriman/filter_koreksi');
            return;
        }

        $data_master = [
            'nopol'                 => $this->input->post('nopol'),
            'tanggal'               => $this->input->post('tanggal'),
            'fleet_type'            => $this->input->post('armada'),
            'driver_name'           => $this->input->post('driver'),
            'rittage'               => $this->input->post('ritase'),
            'jarak_cust_terjauh'    => $this->input->post('jarak'),
            'helpers'               => $this->input->post('helpers')
        ];

        $surat_jalan_list = $this->input->post('surat_jalan');
        $customer_list = $this->input->post('customer');
        $data_detail = [];
        if (is_array($surat_jalan_list)) {
            for ($i = 0; $i < count($surat_jalan_list); $i++) {
                if (!empty($surat_jalan_list[$i])) {
                    $data_detail[] = ['sjpno' => $surat_jalan_list[$i], 'customer_id' => $customer_list[$i]];
                }
            }
        }

        $success = false;
        if ($is_original) {
            $success = $this->m_pengiriman->replace_original_data($id_koreksi, $data_master, $data_detail);
        } else {
            $success = $this->m_pengiriman->update_koreksi_data($id_koreksi, $data_master, $data_detail);
        }

        if ($success) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil diupdate dan menunggu approval.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal mengupdate data.</div>');
        }
        redirect("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}");
    }

    function detailgajipengiriman() {
        $tanggal = $this->input->post('tgl');
        $tgl = explode(' - ', $tanggal);
        $ketsts1 = $this->input->post('ketsts');
    
        if (!empty($ketsts1)) {
            $ketsts = "and jabatan='$ketsts1'";
        } else {
            $ketsts = '';
        }
    
        $tglawal = date('Y-m-d', strtotime($tgl[0]));
        $tglakhir = date('Y-m-d', strtotime($tgl[1]));
        $kanwil = trim($this->input->post('kanwil'));
    
        if (empty($tanggal) || empty($kanwil)) {
            redirect('trans/pengiriman/filter_detail');
        } else {
            
            $this->m_pengiriman->execute_pr_hitung_gajipengiriman();
            
            $data['title'] = "DETAIL DATA PENGGAJIAN PER WILAYAH";
            $data['list_gaji'] = $this->m_pengiriman->q_gaji_pengiriman_ready($kanwil, $tglawal, $tglakhir, $ketsts)->result();
            $data['kdcabang'] = $kanwil;
            $data['tgl1'] = $tglawal;
            $data['tgl2'] = $tglakhir;
            $data['ketsts'] = $ketsts;
    
            $this->template->display('trans/pengiriman/v_detailgajipengiriman', $data);
        }
    }

    function insentifpengiriman() {
        $tanggal = $this->input->post('tgl');
        $tgl = explode(' - ', $tanggal);
        $ketsts1 = $this->input->post('ketsts');
    
        if (!empty($ketsts1)) {
            $ketsts = "and jabatan='$ketsts1'";
        } else {
            $ketsts = '';
        }
    
        $tglawal = date('Y-m-d', strtotime($tgl[0]));
        $tglakhir = date('Y-m-d', strtotime($tgl[1]));
        $kanwil = trim($this->input->post('kanwil'));
    
        if (empty($tanggal) || empty($kanwil)) {
            
            redirect('trans/pengiriman/filter_detail');
        } else {
            
            $this->m_pengiriman->execute_pr_hitung_gajipengiriman();
            
            $data['title'] = "DETAIL DATA INSENTIF PER WILAYAH";
            
            $data['list_insentif'] = $this->m_pengiriman->q_insentif_pengiriman($kanwil, $tglawal, $tglakhir, $ketsts)->result();
            $data['kdcabang'] = $kanwil;
            $data['tgl1'] = $tglawal;
            $data['tgl2'] = $tglakhir;
            $data['ketsts'] = $ketsts;
    
            
            $this->template->display('trans/pengiriman/v_detailinsentifpengiriman', $data);
        }
    }
    
    public function excel_gaji_pengiriman()
    {
        $kdcabang = $this->input->post('kdcabang');
        $tgl1     = $this->input->post('tgl1');
        $tgl2     = $this->input->post('tgl2');
        $ketsts   = $this->input->post('ketsts');

        if (!$kdcabang || !$tgl1 || !$tgl2) {
            show_error("Parameter tidak lengkap. Harap pilih cabang dan tanggal.");
        }

        $tglawal_fmt  = date("d-m-Y", strtotime($tgl1));
        $tglakhir_fmt = date("d-m-Y", strtotime($tgl2));
        $filename = "Laporan Gaji Pengiriman Wilayah $kdcabang $tglawal_fmt Hingga $tglakhir_fmt.xls";

       
        $list_gaji = $this->m_pengiriman->q_gaji_pengiriman_ready($kdcabang, $tgl1, $tgl2, $ketsts)->result();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo '<table border="1">';
        echo '<thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Nopol</th>
                    <th>Jabatan</th>
                    <th>Upah Harian</th>
                    <th>Insentf Rit1</th>
                    <th>Insentf Rit2</th>
                    <th>Insentif Toko</th>
                    <th>Insentif Jarak 1</th>
                    <th>Insentif Jarak 2</th>
                    <th>Total</th>
                </tr>
              </thead>';
        echo '<tbody>';
        
        $current_nik = null;
        $previous_name = '';
        $subtotal_upah = 0; $subtotal_rit1 = 0; $subtotal_rit2 = 0; $subtotal_toko = 0;
        $subtotal_jarak1 = 0; $subtotal_jarak2 = 0; $subtotal_total = 0;
        
        $grand_total_upah = 0; $grand_total_rit1 = 0; $grand_total_rit2 = 0; $grand_total_toko = 0;
        $grand_total_jarak1 = 0; $grand_total_jarak2 = 0; $grand_total_total = 0;

        $no = 0;
       
        $total_records = count($list_gaji);

       
        foreach ($list_gaji as $index => $la) {
            if ($current_nik !== null && $current_nik !== $la->nik) {
                echo '<tr style="font-weight: bold;">
                        <td></td>
                        <td>'.$current_nik.'</td>
                        <td>'.strtoupper($previous_name).'</td>
                        <td></td>
                        <td></td>
                        <td align="center">TOTAL</td>
                        <td align="right">'.number_format($subtotal_upah, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_rit1, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_rit2, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_toko, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_jarak1, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_jarak2, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_total, 0, ',', '.').'</td>
                      </tr>';
                $subtotal_upah = 0; $subtotal_rit1 = 0; $subtotal_rit2 = 0; $subtotal_toko = 0;
                $subtotal_jarak1 = 0; $subtotal_jarak2 = 0; $subtotal_total = 0;
            }

            $current_nik = $la->nik;
            $previous_name = $la->nmlengkap;
            $no++;

            $subtotal_upah += $la->upah_harian; $subtotal_rit1 += $la->rit1; $subtotal_rit2 += $la->rit2;
            $subtotal_toko += $la->jml_toko; $subtotal_jarak1 += $la->jml_jarak1; $subtotal_jarak2 += $la->jml_jarak2;
            $subtotal_total += $la->total;
            
            $grand_total_upah += $la->upah_harian; $grand_total_rit1 += $la->rit1; $grand_total_rit2 += $la->rit2;
            $grand_total_toko += $la->jml_toko; $grand_total_jarak1 += $la->jml_jarak1; $grand_total_jarak2 += $la->jml_jarak2;
            $grand_total_total += $la->total;

            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$la->nik.'</td>
                    <td>'.$la->nmlengkap.'</td>
                    <td>'.date('d-m-Y', strtotime($la->tanggal)).'</td>
                    <td>'.$la->nopol.'</td>
                    <td>'.$la->nmjabatan.'</td>
                    <td align="right">'.number_format($la->upah_harian, 0, ',', '.').'</td>
                    <td align="right">'.number_format($la->rit1, 0, ',', '.').'</td>
                    <td align="right">'.number_format($la->rit2, 0, ',', '.').'</td>
                    <td align="right">'.number_format($la->jml_toko, 0, ',', '.').'</td>
                    <td align="right">'.number_format($la->jml_jarak1, 0, ',', '.').'</td>
                    <td align="right">'.number_format($la->jml_jarak2, 0, ',', '.').'</td>
                    <td align="right">'.number_format($la->total, 0, ',', '.').'</td>
                  </tr>';

            if ($index === $total_records - 1) {
                echo '<tr style="font-weight: bold;">
                        <td></td>
                        <td>'.$current_nik.'</td>
                        <td>'.strtoupper($previous_name).'</td>
                        <td></td>
                        <td></td>
                        <td align="center">TOTAL</td>
                        <td align="right">'.number_format($subtotal_upah, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_rit1, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_rit2, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_toko, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_jarak1, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_jarak2, 0, ',', '.').'</td>
                        <td align="right">'.number_format($subtotal_total, 0, ',', '.').'</td>
                      </tr>';
            }
        }
        
        echo '</tbody>';
        echo '<tfoot>
                <tr style="font-weight: bold; background-color: #333; color: #fff;">
                    <td colspan="6" align="right">GRAND TOTAL</td>
                    <td align="right">'.number_format($grand_total_upah, 0, ',', '.').'</td>
                    <td align="right">'.number_format($grand_total_rit1, 0, ',', '.').'</td>
                    <td align="right">'.number_format($grand_total_rit2, 0, ',', '.').'</td>
                    <td align="right">'.number_format($grand_total_toko, 0, ',', '.').'</td>
                    <td align="right">'.number_format($grand_total_jarak1, 0, ',', '.').'</td>
                    <td align="right">'.number_format($grand_total_jarak2, 0, ',', '.').'</td>
                    <td align="right">'.number_format($grand_total_total, 0, ',', '.').'</td>
                </tr>
              </tfoot>';

        echo '</table>';
        exit;
    }

    public function approve_koreksi($id, $kanwil, $tgl1, $tgl2)
    {
        $approver_nik = $this->session->userdata('nik');
        $this->m_pengiriman->approve_koreksi($id, $approver_nik);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil diapprove.</div>');

        redirect("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil)."/{$tgl1}/{$tgl2}");
    }

    public function reject_koreksi($id, $kanwil, $tgl1, $tgl2)
    {
        $rejector_nik = $this->session->userdata('nik');
        $this->m_pengiriman->reject_koreksi($id, $rejector_nik);
        $this->session->set_flashdata('message', '<div class="alert alert-warning">Data berhasil direject.</div>');

        redirect("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil)."/{$tgl1}/{$tgl2}");
    }
    

    public function hapus_pengiriman($id, $kanwil, $tgl1, $tgl2)
    {
        $is_koreksi = (strpos($id, 'INS') === 0);

        if ($is_koreksi) {
            $success = $this->m_pengiriman->hapus_data_koreksi($id);
        } else {
            $success = $this->m_pengiriman->hapus_data_asli($id);
        }

        if ($success) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus secara permanen.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus data.</div>');
        }

        redirect("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil)."/{$tgl1}/{$tgl2}");
    }
    
    public function laporan_insentif_driver()
    {
        $kanwil = trim($this->input->post('kanwil'));
        
        $tgl_um_raw = $this->input->post('tgl_um');
        $tgl_kehadiran_raw = $this->input->post('tgl_kehadiran');
        $tgl_insentif_raw = $this->input->post('tgl_insentif');

        if (empty($kanwil) || empty($tgl_um_raw) || empty($tgl_kehadiran_raw) || empty($tgl_insentif_raw)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Silakan pilih wilayah dan semua rentang tanggal.</div>');

            redirect('trans/pengiriman/filter_detail');
        }

        $tgl_um_arr = explode(' - ', $tgl_um_raw);
        $um_tgl1 = date('Y-m-d', strtotime($tgl_um_arr[0]));
        $um_tgl2 = date('Y-m-d', strtotime($tgl_um_arr[1]));

        $tgl_kehadiran_arr = explode(' - ', $tgl_kehadiran_raw);
        $kehadiran_tgl1 = date('Y-m-d', strtotime($tgl_kehadiran_arr[0]));
        $kehadiran_tgl2 = date('Y-m-d', strtotime($tgl_kehadiran_arr[1]));

        $tgl_insentif_arr = explode(' - ', $tgl_insentif_raw);
        $insentif_tgl1 = date('Y-m-d', strtotime($tgl_insentif_arr[0]));
        $insentif_tgl2 = date('Y-m-d', strtotime($tgl_insentif_arr[1]));

        $this->m_pengiriman->execute_pr_hitung_gajipengiriman();
        $this->m_pengiriman->execute_pr_rekap_tjkehadiran();

        $data['list_insentif'] = $this->m_pengiriman->q_insentif_driver(
            $kanwil, $um_tgl1, $um_tgl2, 
            $kehadiran_tgl1, $kehadiran_tgl2, 
            $insentif_tgl1, $insentif_tgl2
        )->result();

        $data['title'] = "Laporan Insentif Driver Wilayah " . $kanwil;
        $data['kdcabang'] = $kanwil;
        $data['tgl_um_raw'] = $tgl_um_raw;
        $data['tgl_kehadiran_raw'] = $tgl_kehadiran_raw;
        $data['tgl_insentif_raw'] = $tgl_insentif_raw;

        $this->template->display('trans/pengiriman/v_laporan_insentif', $data);
    }

    public function excel_insentif_driver()
    {
        $kdcabang = $this->input->post('kdcabang');
        $tgl_um_raw = $this->input->post('tgl_um');
        $tgl_kehadiran_raw = $this->input->post('tgl_kehadiran');
        $tgl_insentif_raw = $this->input->post('tgl_insentif');

        $tgl_um_arr = explode(' - ', $tgl_um_raw);
        $um_tgl1 = date('Y-m-d', strtotime($tgl_um_arr[0]));
        $um_tgl2 = date('Y-m-d', strtotime($tgl_um_arr[1]));

        $tgl_kehadiran_arr = explode(' - ', $tgl_kehadiran_raw);
        $kehadiran_tgl1 = date('Y-m-d', strtotime($tgl_kehadiran_arr[0]));
        $kehadiran_tgl2 = date('Y-m-d', strtotime($tgl_kehadiran_arr[1]));

        $tgl_insentif_arr = explode(' - ', $tgl_insentif_raw);
        $insentif_tgl1 = date('Y-m-d', strtotime($tgl_insentif_arr[0]));
        $insentif_tgl2 = date('Y-m-d', strtotime($tgl_insentif_arr[1]));
        
        $this->m_pengiriman->execute_pr_hitung_gajipengiriman();
        $this->m_pengiriman->execute_pr_rekap_tjkehadiran();

        $list_insentif = $this->m_pengiriman->q_insentif_driver(
            $kdcabang, $um_tgl1, $um_tgl2, 
            $kehadiran_tgl1, $kehadiran_tgl2, 
            $insentif_tgl1, $insentif_tgl2
        )->result();

        $filename = "Laporan Insentif Driver Wilayah $kdcabang.xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $data['list_insentif'] = $list_insentif;
        $data['tgl_um_raw'] = $tgl_um_raw;
        $data['tgl_kehadiran_raw'] = $tgl_kehadiran_raw;
        $data['tgl_insentif_raw'] = $tgl_insentif_raw;

        $this->load->view('trans/pengiriman/v_excel_insentif', $data);
    }

    public function koreksihelpergudang()
    {
        $tanggal = $this->input->post('tgl_hg');
        $tgl = explode(' - ', $tanggal);
        $tgl1 = $tgl[0];
        $tgl2 = $tgl[1];
        $kanwil = trim($this->input->post('kanwil_hg'));

        if (empty($tanggal) || empty($kanwil)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Silakan pilih wilayah dan tanggal untuk Helper Gudang.</div>');

            redirect('trans/pengiriman/filter_koreksi');
        } else {
            
            redirect("trans/pengiriman/lihat_helper_gudang/".rawurlencode($kanwil)."/{$tgl1}/{$tgl2}");
        }
    }

    public function lihat_helper_gudang($kanwil_encoded, $tgl1, $tgl2)
    {
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = "KOREKSI DATA HELPER GUDANG";
        
        $kanwil = rawurldecode($kanwil_encoded);
        $tgl1_db = date('Y-m-d', strtotime($tgl1));
        $tgl2_db = date('Y-m-d', strtotime($tgl2));
        
        $data['list_helper_gudang'] = $this->m_pengiriman->q_helper_gudang_by_wilayah($kanwil, $tgl1_db, $tgl2_db)->result();
        $data['list_helper_master'] = $this->m_pengiriman->q_helper()->result();
        
        $data['kanwil_filter'] = $kanwil;
        $data['tgl1_filter'] = $tgl1;
        $data['tgl2_filter'] = $tgl2;
        
        
        $this->template->display('trans/pengiriman/v_koreksihelpergudang', $data);
    }

    public function input_helper_gudang()
    {
        $kanwil_filter = $this->input->post('kanwil_filter');
        $tgl1_filter = $this->input->post('tgl1_filter');
        $tgl2_filter = $this->input->post('tgl2_filter');

        $data_helper = [
            'tanggal' => $this->input->post('tanggal'),
            'helpers' => $this->input->post('helpers'),
            'kanwil'  => $kanwil_filter
        ];

        if (empty($data_helper['tanggal']) || empty($data_helper['helpers'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Tanggal dan Helper tidak boleh kosong.</div>');
        } else {
            $success = $this->m_pengiriman->simpan_helper_gudang($data_helper);
            if ($success) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">Data helper gudang berhasil disimpan.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menyimpan data helper gudang.</div>');
            }
        }
        
        
        redirect("trans/pengiriman/lihat_helper_gudang/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}");
    }

    public function hapus_helper_gudang($id, $kanwil, $tgl1, $tgl2)
    {
        $success = $this->m_pengiriman->hapus_helper_gudang($id);

        if ($success) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data absensi helper gudang berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus data.</div>');
        }
        redirect("trans/pengiriman/lihat_helper_gudang/".rawurlencode($kanwil)."/{$tgl1}/{$tgl2}");
    }

    public function detail_pengiriman_ajax()
    {
        // Set header ke JSON
        header('Content-Type: application/json');

        $id = $this->input->post('id');
        if (!$id) {
            echo json_encode(['html' => '<p class="text-danger">Error: ID tidak valid.</p>']);
            return;
        }

        $data = $this->m_pengiriman->get_detail_pengiriman_by_id($id);
        $html = '';

        if ($data && $data['header']) {
            $html .= '<p><strong>Ritase:</strong> ' . html_escape($data['header']->rittage) . '</p>';
            $html .= '<p><strong>Jarak Terjauh:</strong> ' . html_escape($data['header']->jarak_cust_terjauh) . ' KM</p>';
            
            $html .= '<hr><h4>Detail Customer & SJ</h4>';
            if (!empty($data['details'])) {
                $html .= '<table class="table table-bordered table-striped">';
                $html .= '<thead><tr><th style="width:50px;">No.</th><th>No. SJ</th><th>Customer</th></tr></thead>';
                $html .= '<tbody>';
                $no = 1;
                foreach ($data['details'] as $detail) {
                    $html .= '<tr>';
                    $html .= '<td>' . $no++ . '</td>';
                    $html .= '<td>' . html_escape($detail->sj) . '</td>';
                    $html .= '<td>' . html_escape($detail->customer_id) . ' - ' . html_escape($detail->customer_name) . '</td>';
                    $html .= '</tr>';
                }
                $html .= '</tbody></table>';
            } else {
                $html .= '<p>Tidak ada data detail customer.</p>';
            }
        } else {
            // Jika data tidak ditemukan, cek apakah ini helper gudang
            if (is_numeric($id)) {
                 $html = '<p>Detail tidak tersedia untuk Helper Gudang.</p>';
            } else {
                 $html = '<p class="text-danger">Data tidak ditemukan untuk ID: ' . html_escape($id) . '</p>';
            }
        }

        echo json_encode(['html' => $html]);
    }
}
