<?php
// FILE: views/trans/pengiriman/v_koreksipengiriman.php
// =================================================================================
defined('BASEPATH') OR exit('No direct script access allowed');
// Mengambil NIK pengguna yang sedang login untuk perbandingan di level baris
$loggedInNik = $this->session->userdata('nik'); 
?>
<script>
    document.querySelectorAll('.d-inline.h5.alert.alert-d').forEach(function(el) {
    el.style.display = 'none';
});
</script>
<legend><?php echo $title;?></legend>

<!-- Pustaka CSS dan Font (Tailwind, Inter) -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', sans-serif; }
    .fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .modal-dialog { width: 100%; max-width: 56rem; }
    .modal-content { border: none; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
    .status-badge {
        display: inline-block; padding: .25em .6em; font-size: 75%; font-weight: 700;
        line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25rem;
    }
    .status-data-app { color: #fff; background-color: #17a2b8; } /* Info Blue */
    .status-approved { color: #fff; background-color: #28a745; } /* Success Green */
    .status-rejected { color: #fff; background-color: #dc3545; } /* Danger Red */
    .status-awaiting { color: #212529; background-color: #ffc107; } /* Warning Yellow */
    /* Style untuk field readonly di modal detail */
    .detail-field {
        background-color: #f3f4f6; /* bg-gray-200 */
        border: 1px solid #d1d5db; /* border-gray-300 */
        color: #1f2937; /* text-gray-800 */
        font-size: 0.875rem; /* text-sm */
        border-radius: 0.5rem; /* rounded-lg */
        padding: 0.625rem; /* p-2.5 */
        width: 100%;
        min-height: 42px; /* Samakan tinggi dengan input */
        display: flex;
        align-items: center;
    }
</style>

<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-header">
        <div class="col-sm-12"> 
          <a href="#" data-toggle="modal" data-target="#inputModal" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Pengiriman</a>
          <!-- Mengubah URL kembali ke controller pengiriman -->
          <a href="<?php echo site_url('trans/pengiriman/filter_koreksi');?>" class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
        </div>
      </div>
      <div class="box-body table-responsive">
        
        <!-- Mengubah ID tabel -->
        <table id="table-koreksi" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nopol</th>
              <th>Armada</th>
              <th>Customer & SJ</th>
              <th>Jml Cust</th>
              <th>Ritase</th>
              <th>Jarak</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Mengubah variabel dari $list_absen menjadi $list_pengiriman -->
            <?php foreach ($list_pengiriman as $la){ ?>
              <tr> 
                <td><?php echo date('d-m-Y', strtotime($la->tanggal));?></td>
                <td><?php echo $la->nopol;?></td> 
                <td><?php echo $la->uraian;?></td>
                <td>
                  <?php 
                  $info = explode('|||', $la->customer_info); 
                  foreach($info as $cust){
                      echo '- ' . trim(html_escape($cust)) . '<br>';
                  }
                  ?>
                </td>
                <td><?php echo $la->customer_count;?></td>
                <td><?php echo $la->rittage;?></td> 
                <td><?php echo $la->jarak_cust_terjauh;?> KM</td>
                <td>
                    <?php
                        $status_text = $la->status;
                        $status_class = '';
                        if ($status_text == 'Disetujui' && $la->is_original == '1') {
                            $status_class = 'status-data-app';
                            $status_text = 'Data App';
                        } elseif ($status_text == 'Disetujui') {
                            $status_class = 'status-approved';
                        } elseif ($status_text == 'Ditolak') {
                            $status_class = 'status-rejected';
                        } elseif ($status_text == 'Menunggu Persetujuan') {
                            $status_class = 'status-awaiting';
                        }
                        echo "<span class='status-badge {$status_class}'>{$status_text}</span>";
                    ?>
                </td>
                <td>
                    <div class="btn-group-vertical">
                        <?php
                            $status = $la->status;
                            $is_original = $la->is_original == '1';
                            $isAtasan = (trim($la->nik_atasan) == trim($loggedInNik));

                            // Simpan payload detail lengkap sebagai atribut data, siap digunakan oleh JavaScript
                            $detail_json = html_escape(json_encode($la->detail_payload));
                            echo '<a href="#" class="btn btn-info btn-xs detail-btn" data-toggle="modal" data-target="#detailModal" data-detail-payload=\''.$detail_json.'\'><i class="fa fa-eye"></i> Detail</a>';

                            if ($status == 'Disetujui' && !$is_original) {
                                // Untuk data koreksi yang sudah disetujui, tidak ada tombol lain
                            } else if ($status == 'Menunggu Persetujuan' && $isAtasan) {
                                // Mengubah URL ke controller pengiriman
                                echo '<a href="'.site_url("trans/pengiriman/approve_koreksi/{$la->id}/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}").'" class="btn btn-success btn-xs" onclick="return confirm(\'Anda yakin ingin MENYETUJUI data ini?\')"><i class="fa fa-check"></i> Approve</a>';
                                echo '<a href="'.site_url("trans/pengiriman/reject_koreksi/{$la->id}/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}").'" class="btn btn-danger btn-xs" onclick="return confirm(\'Anda yakin ingin MENOLAK data ini?\')"><i class="fa fa-times"></i> Reject</a>';
                            } else {
                                echo '<a href="'.site_url("trans/pengiriman/edit_pengiriman/{$la->id}/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}").'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>';
                                // Mengubah URL dan nama fungsi hapus
                                echo '<a href="'.site_url("trans/pengiriman/hapus_pengiriman/{$la->id}/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}").'" class="btn btn-warning btn-xs" onclick="return confirm(\'Anda yakin ingin MENGHAPUS data ini secara permanen?\')"><i class="fa fa-trash-o"></i> Delete</a>';
                            }
                        ?>
                    </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- MODAL UNTUK INPUT DATA BARU -->
<div class="modal fade" id="inputModal" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Mengubah URL action ke controller pengiriman -->
      <form action="<?php echo site_url('trans/pengiriman/input_pengiriman')?>" method="post" id="shipping-form">
        <div class="flex justify-between items-center p-5 border-b border-gray-200 rounded-t-lg">
            <h3 class="text-xl font-semibold text-gray-900">Input Data Pengiriman Baru</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-dismiss="modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
            </button>
        </div>
        <input type="hidden" name="kanwil_filter" value="<?php echo html_escape($kanwil_filter); ?>">
        <input type="hidden" name="tgl1_filter" value="<?php echo html_escape($tgl1_filter); ?>">
        <input type="hidden" name="tgl2_filter" value="<?php echo html_escape($tgl2_filter); ?>">
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nopol" class="block mb-2 text-sm font-medium text-gray-900">Nopol</label>
                    <select name="nopol" id="nopol" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">--Pilih Nopol--</option>
                        <?php foreach($list_armada as $armada) { ?>
                            <option value="<?php echo trim($armada->nopol); ?>" data-fleet-type="<?php echo $armada->fleet_type; ?>" data-fleet-description="<?php echo $armada->fleet_description; ?>"><?php echo trim($armada->nopol); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="armada_text" class="block mb-2 text-sm font-medium text-gray-900">Armada</label>
                    <input type="text" id="armada_text" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Pilih nopol terlebih dahulu" readonly>
                    <input type="hidden" name="armada" id="armada" required>
                </div>
                <div>
                    <label for="driver" class="block mb-2 text-sm font-medium text-gray-900">Driver</label>
                    <input type="text" list="driver-list" id="driver" name="driver" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required placeholder="Ketik nama atau pilih dari daftar">
                    <datalist id="driver-list">
                        <?php foreach ($list_driver as $ld){ ?><option value="<?php echo trim($ld->nmlengkap);?>"><?php } ?>
                    </datalist>
                </div>
                <div>
                    <label for="ritase" class="block mb-2 text-sm font-medium text-gray-900">Ritase</label>
                    <input type="number" name="ritase" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jumlah Ritase" required>
                </div>
                <div>
                    <label for="jarak" class="block mb-2 text-sm font-medium text-gray-900">Jarak (KM)</label>
                    <input type="number" name="jarak" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jarak Terjauh" required>
                </div>
            </div>
            <div class="mt-4 border-t pt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Surat Jalan & Customer</label>
                <div id="sj-customer-container" class="space-y-2">
                    <div class="grid grid-cols-[1fr_1fr_auto] gap-x-2 items-center">
                        <input type="text" name="surat_jalan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nomor Surat Jalan" required>
                        <select name="customer[]" class="customer-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></select>
                        <button type="button" id="add-sj-customer-btn" class="bg-green-500 hover:bg-green-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></button>
                    </div>
                </div>
            </div>
            <div class="mt-4 border-t pt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Helper</label>
                <datalist id="helper-list"><?php foreach ($list_helper as $lh){ ?><option value="<?php echo trim($lh->nmlengkap);?>"><?php } ?></datalist>
                <div id="helper-container" class="space-y-2">
                    <div class="grid grid-cols-[1fr_auto] gap-x-2 items-center">
                        <input type="text" list="helper-list" name="helpers[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ketik nama atau pilih dari daftar">
                        <button type="button" id="add-helper-btn" class="bg-green-500 hover:bg-green-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end p-5 space-x-3 border-t border-gray-200 rounded-b-lg">
            <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100" data-dismiss="modal">Batal</button>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL DETAIL BARU -->
<div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="flex justify-between items-center p-5 border-b border-gray-200 rounded-t-lg">
            <h3 class="text-xl font-semibold text-gray-900">Detail Data Pengiriman</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-dismiss="modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4" id="detailModalBody">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nopol</label>
                    <div id="detail_nopol" class="detail-field"></div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                    <div id="detail_tanggal" class="detail-field"></div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Driver</label>
                    <div id="detail_driver" class="detail-field"></div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Ritase</label>
                    <div id="detail_ritase" class="detail-field"></div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jarak (KM)</label>
                    <div id="detail_jarak" class="detail-field"></div>
                </div>
            </div>
            <div class="mt-4 border-t pt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Surat Jalan & Customer</label>
                <div id="detail_sj_customer_container" class="space-y-2"></div>
            </div>
            <div class="mt-4 border-t pt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Helper</label>
                <div id="detail_helper_container" class="space-y-2"></div>
            </div>
        </div>
        <div class="flex items-center justify-end p-5 space-x-3 border-t border-gray-200 rounded-b-lg">
            <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100" data-dismiss="modal">Tutup</button>
        </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    const listCustomer = <?php echo json_encode($list_customer); ?>;
    const customerOptionsHtml = '<option value="">--Pilih Customer--</option>' + listCustomer.map(c => `<option value="${c.customer_id}">${c.customer_id} (${c.customer_name})</option>`).join('');

    window.removeRow = function(button) { $(button).closest('.grid').remove(); }
    
    function addSjCustomerRow(containerId) {
        const newRowHtml = `<div class="grid grid-cols-[1fr_1fr_auto] gap-x-2 items-center fade-in"><input type="text" name="surat_jalan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nomor Surat Jalan" required><select name="customer[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>${customerOptionsHtml}</select><button type="button" onclick="removeRow(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg></button></div>`;
        $('#' + containerId).append(newRowHtml);
    }

    function addHelperRow(containerId) {
        const newRowHtml = `<div class="grid grid-cols-[1fr_auto] gap-x-2 items-center fade-in"><input type="text" list="helper-list" name="helpers[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ketik nama atau pilih dari daftar"><button type="button" onclick="removeRow(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg></button></div>`;
        $('#' + containerId).append(newRowHtml);
    }

    $('#add-sj-customer-btn').on('click', function() { addSjCustomerRow('sj-customer-container'); });
    $('#add-helper-btn').on('click', function() { addHelperRow('helper-container'); });
    $('#sj-customer-container .customer-select').html(customerOptionsHtml);
    
    // Mengubah ID tabel dan menonaktifkan pengurutan awal
    $('#table-koreksi').DataTable({
        "order": []
    });

    $('#nopol').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const fleetType = selectedOption.data('fleet-type');
        const fleetDescription = selectedOption.data('fleet-description');
        $('#armada').val(fleetType || '');
        $('#armada_text').val(fleetDescription || '');
    });

    // JAVASCRIPT BARU UNTUK MODAL DETAIL (TANPA AJAX)
    $('.detail-btn').on('click', function() {
        // Kosongkan konten lama
        $('#detail_nopol, #detail_tanggal, #detail_driver, #detail_ritase, #detail_jarak').text('');
        $('#detail_sj_customer_container, #detail_helper_container').empty();

        try {
            var detailPayload = $(this).data('detail-payload');
            
            // Isi field utama
            $('#detail_nopol').text(detailPayload.nopol || '-');
            $('#detail_tanggal').text(detailPayload.tanggal || '-');
            $('#detail_driver').text(detailPayload.driver_name || '-');
            $('#detail_ritase').text(detailPayload.rittage || '0');
            $('#detail_jarak').text((detailPayload.jarak_cust_terjauh || '0') + ' KM');

            // Isi list Surat Jalan & Customer
            var sjContainer = $('#detail_sj_customer_container');
            if (detailPayload.details && detailPayload.details.length > 0) {
                detailPayload.details.forEach(function(detail) {
                    var customer = listCustomer.find(c => c.customer_id == detail.customer_id);
                    var customerDisplay = detail.customer_id;
                    if (customer) {
                        customerDisplay += ` (${customer.customer_name})`;
                    }
                    sjContainer.append(`<div class="grid grid-cols-2 gap-x-2 items-center"><div class="detail-field">${detail.sjpno}</div><div class="detail-field">${customerDisplay}</div></div>`);
                });
            } else {
                sjContainer.append(`<p class="text-gray-500">Tidak ada data.</p>`);
            }
            
            // Isi list Helper
            var helperContainer = $('#detail_helper_container');
            if (detailPayload.helpers && detailPayload.helpers.length > 0) {
                detailPayload.helpers.forEach(function(helper) {
                    if(helper) helperContainer.append(`<div class="detail-field">${helper}</div>`);
                });
            } else {
                helperContainer.append(`<p class="text-gray-500">Tidak ada data.</p>`);
            }

        } catch (e) {
            console.error("Gagal mem-parsing atau menampilkan data detail:", e);
            $('#detailModalBody').prepend('<p class="text-red-500 text-center">Gagal menampilkan data detail.</p>');
        }
    });
});
</script>
