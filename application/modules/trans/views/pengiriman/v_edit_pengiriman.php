<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<legend>Edit Data Pengiriman</legend>

<!-- Pustaka CSS dan Font -->
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
</style>

<div class="box">
    <div class="box-body">
        <form action="<?php echo site_url('trans/pengiriman/update_pengiriman')?>" method="post" id="shipping-form-edit">
            <input type="hidden" name="id_koreksi" value="<?php echo html_escape($pengiriman['id_koreksi']); ?>">
            <input type="hidden" name="is_original" value="<?php echo $pengiriman['is_original'] ? '1' : '0'; ?>">
            <input type="hidden" name="kanwil_filter" value="<?php echo html_escape($kanwil_filter); ?>">
            <input type="hidden" name="tgl1_filter" value="<?php echo html_escape($tgl1_filter); ?>">
            <input type="hidden" name="tgl2_filter" value="<?php echo html_escape($tgl2_filter); ?>">

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nopol" class="block mb-2 text-sm font-medium text-gray-900">Nopol</label>
                        <input type="text" name="nopol" id="nopol" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="<?php echo html_escape(trim($pengiriman['nopol']));?>" readonly>
                    </div>
                    <div>
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo html_escape($pengiriman['tanggal']);?>" required>
                    </div>
                    <div>
                        <label for="armada_text" class="block mb-2 text-sm font-medium text-gray-900">Armada</label>
                        <?php
                        $armada_description = '';
                        $fleet_type_value = '';
                        if (isset($pengiriman['fleet_type'])) {
                            $fleet_type = trim(strtoupper($pengiriman['fleet_type']));
                            $fleet_type_value = $pengiriman['fleet_type'];
                            if ($fleet_type == 'B') {
                                $armada_description = 'COLT DIESEL DOUBLE';
                            } elseif ($fleet_type == 'D') {
                                $armada_description = 'COLT DIESEL ENGKEL';
                            }
                        }
                        ?>
                        <input type="text" id="armada_text" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="<?php echo $armada_description; ?>" readonly>
                        <input type="hidden" name="armada" id="armada" value="<?php echo html_escape($fleet_type_value); ?>">
                    </div>
                    <div>
                        <label for="driver" class="block mb-2 text-sm font-medium text-gray-900">Driver</label>
                        <input type="text" list="driver-list" id="driver" name="driver" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required placeholder="Ketik nama atau pilih dari daftar" value="<?php echo html_escape($pengiriman['driver_name']); ?>">
                        <datalist id="driver-list">
                            <?php foreach ($list_driver as $ld){ ?>
                                <option value="<?php echo html_escape(trim($ld->nmlengkap));?>">
                            <?php } ?>
                        </datalist>
                    </div>
                    <div>
                        <label for="ritase" class="block mb-2 text-sm font-medium text-gray-900">Ritase</label>
                        <input type="number" name="ritase" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jumlah Ritase" value="<?php echo html_escape($pengiriman['rittage']);?>" required>
                    </div>
                    <div>
                        <label for="jarak" class="block mb-2 text-sm font-medium text-gray-900">Jarak (KM)</label>
                        <input type="number" name="jarak" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jarak Terjauh" value="<?php echo html_escape($pengiriman['jarak_cust_terjauh']);?>" required>
                    </div>
                </div>
                <div class="mt-4 border-t pt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Surat Jalan & Customer</label>
                    <div id="sj-customer-container-edit" class="space-y-2">
                        <?php 
                        $details = isset($pengiriman['details']) ? $pengiriman['details'] : [];
                        if (!empty($details)):
                            foreach ($details as $index => $detail): ?>
                                <div class="grid grid-cols-[1fr_1fr_auto] gap-x-2 items-center">
                                    <input type="text" name="surat_jalan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nomor Surat Jalan" value="<?php echo html_escape($detail['sjpno']); ?>" required>
                                    <select name="customer[]" class="customer-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="">--Pilih Customer--</option>
                                        <?php foreach ($list_customer as $customer): ?>
                                            <option value="<?php echo html_escape($customer->customer_id); ?>" <?php echo ($detail['customer_id'] == $customer->customer_id) ? 'selected' : ''; ?>>
                                                <?php echo html_escape($customer->customer_id . ' (' . $customer->customer_name . ')'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if ($index == 0): ?>
                                        <button type="button" id="add-sj-customer-btn-edit" class="bg-green-500 hover:bg-green-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" onclick="removeRow(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="mt-4 border-t pt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Helper</label>
                    <datalist id="helper-list">
                        <?php foreach ($list_helper as $lh){ ?>
                            <option value="<?php echo html_escape(trim($lh->nmlengkap));?>">
                        <?php } ?>
                    </datalist>
                    <div id="helper-container-edit" class="space-y-2">
                        <?php 
                        $helpers = isset($pengiriman['helpers']) ? $pengiriman['helpers'] : [];
                        if (!empty($helpers)):
                            foreach ($helpers as $index => $helper_name): ?>
                                <div class="grid grid-cols-[1fr_auto] gap-x-2 items-center">
                                    <input type="text" list="helper-list" name="helpers[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ketik nama atau pilih dari daftar" value="<?php echo html_escape($helper_name); ?>">
                                    <?php if ($index == 0): ?>
                                        <button type="button" id="add-helper-btn-edit" class="bg-green-500 hover:bg-green-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" onclick="removeRow(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="grid grid-cols-[1fr_auto] gap-x-2 items-center">
                                <input type="text" list="helper-list" name="helpers[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ketik nama atau pilih dari daftar">
                                <button type="button" id="add-helper-btn-edit" class="bg-green-500 hover:bg-green-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="flex items-center justify-end p-5 space-x-3 border-t border-gray-200 rounded-b-lg">
                <a href="<?php echo site_url("trans/pengiriman/lihat_koreksi_kar/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}");?>" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</a>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    const listCustomer = <?php echo json_encode($list_customer); ?>;
    
    const customerOptionsHtml = '<option value="">--Pilih Customer--</option>' + listCustomer.map(c => `<option value="${c.customer_id}">${c.customer_id} (${c.customer_name})</option>`).join('');

    // Fungsi global untuk menghapus baris
    window.removeRow = function(button) {
        $(button).closest('.grid').remove();
    }

    // Fungsi untuk menambah baris SJ & Customer
    function addSjCustomerRow(containerId) {
        const newRowHtml = `
            <div class="grid grid-cols-[1fr_1fr_auto] gap-x-2 items-center fade-in">
                <input type="text" name="surat_jalan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nomor Surat Jalan" required>
                <select name="customer[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>${customerOptionsHtml}</select>
                <button type="button" onclick="removeRow(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg>
                </button>
            </div>
        `;
        $('#' + containerId).append(newRowHtml);
    }

    // Fungsi untuk menambah baris Helper
    function addHelperRow(containerId) {
        const newRowHtml = `
            <div class="grid grid-cols-[1fr_auto] gap-x-2 items-center fade-in">
                <input type="text" list="helper-list" name="helpers[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ketik nama atau pilih dari daftar">
                <button type="button" onclick="removeRow(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold p-2.5 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg>
                </button>
            </div>
        `;
        $('#' + containerId).append(newRowHtml);
    }

    // Event listener untuk tombol tambah (delegasi event ke body)
    $('body').on('click', '#add-sj-customer-btn-edit', function() { addSjCustomerRow('sj-customer-container-edit'); });
    $('body').on('click', '#add-helper-btn-edit', function() { addHelperRow('helper-container-edit'); });
});
</script>
