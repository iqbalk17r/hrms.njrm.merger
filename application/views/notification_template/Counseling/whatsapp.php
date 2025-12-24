<?php
echo 'Yth. '.$send_to.PHP_EOL.
    $position.' '.$branchname.PHP_EOL.PHP_EOL.
    $type. ' untuk:'.PHP_EOL.PHP_EOL.
    'Kode Agenda  : '.$transaction['Kode_Agenda'].PHP_EOL.
    'Tipe Agenda : '. $transaction['Tipe_Agenda'].PHP_EOL.
    'Aplikasi : '. 'HRMS'.PHP_EOL.
    'Nama Konseli : '. $transaction['Nama_Konseli'].PHP_EOL.
    'Nama Konselor : '. $transaction['Nama_Konselor'].PHP_EOL.
    'Tanggal : '. $transaction['Tanggal_Acara'].PHP_EOL.
    'Waktu : '. $transaction['Waktu_Acara'].PHP_EOL.
    'Lokasi :'. $transaction['Lokasi'].PHP_EOL.
    'Keterangan :'. $transaction['Keterangan'].PHP_EOL;
