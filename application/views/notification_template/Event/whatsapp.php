<?php
echo 'Yth. '.$send_to.PHP_EOL.
    $position.' '.$branchname.PHP_EOL.PHP_EOL.
    $statusText. ' '.$type. ' untuk:'.PHP_EOL.PHP_EOL.
    'Tipe Agenda : '. $transaction['Tipe_Agenda'].PHP_EOL.
    'Nama Agenda : '. $transaction['Nama_Agenda'].PHP_EOL;

if (trim($transaction['Tipe_Agenda']) != 'EVALUASI OJT') {
    echo 'Nama Penyelenggara : '. $transaction['Nama_Penyelenggara'].PHP_EOL;
}

echo 'Tanggal Mulai : '. $transaction['Tanggal_Mulai'].PHP_EOL.
    'Tanggal Selesai : '. $transaction['Tanggal_Selesai'].PHP_EOL;

if ($transaction['Link'] == '') {
    echo 'Lokasi : '. $transaction['Lokasi'].PHP_EOL;
} else {
    echo 'Lokasi : '. $transaction['Lokasi'].PHP_EOL.
        'Link : '. $transaction['Link'].PHP_EOL;
}

