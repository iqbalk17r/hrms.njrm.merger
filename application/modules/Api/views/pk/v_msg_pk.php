<?php
//$lastFormat = ($interval > 0 ? " akan berakhir dalam {$interval} hari ke depan." : ($interval == 0 ? "berakhir hari ini.":"telah berakhir."));
$message = "*\"Notifikasi Otomatis Sistem: PERHATIAN - Pemberitahuan Penilaian Kontrak Kerja\"*\n\n";

//$message .= "*Perhatian!* Masa kontrak kerja Tim anda {$lastFormat}\n\n";

// Loop through the employees to add each one's contract details

    $employee_name = trim($item->nmlengkap);
    $nodok = trim($item->nodok);
    $nik = trim($item->nik);
    $end_date = trim($item->tgl_selesai1);
    $type = trim($item->nmkepegawaian);
    $jabatan = trim($item->nmjabatan);
    $departemen = trim($item->nmdept);
    $status = !empty($item->deskappr) ? $item->deskappr : 'MENUNGGU PENILAIAN ATASAN 1';
    if (empty($item->statuspen)) {
        $appr = trim($item->nmlengkapa1);
    } elseif ($item->statuspen == 'N') {
        $appr = trim($item->nmlengkapa2);
    } else {
        $appr = trim($item->nmlengkap_appr);
    }

    $message .= "Yth. {$appr},\n\n\n";

    $message .= "Nama Karyawan    :        {$employee_name}\n\n";
    $message .= "NIK              :        {$nik}\n\n";
    $message .= "Bagian           :        {$departemen}\n\n";
    $message .= "Jabatan          :        {$jabatan}\n\n";
    $message .= "Nomor Kontrak    :        {$nodok}\n\n";
    $message .= "Tanggal Berakhir :        {$end_date}\n\n";
    $message .= "Jenis Kontrak    :        {$type}\n\n";
    $message .= "Status           :        {$status}\n\n";

$message .= "\n";
$message .= "*Segera menilai/meyetujui dokumen penilaian karyawan kontrak yang tertera diatas.*\n";
$message .= "Terima kasih.\nOSIN\n\n";

$message .="_ref:{$ref}_";
// Echo the complete message
echo $message;