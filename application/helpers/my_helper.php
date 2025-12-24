<?php

function formattgl($param) {
    switch (date('m',strtotime($param))){
        case '01':
            $bulan='Januari';
            break;
        case '02':
            $bulan='Februari';
            break;
        case '03':
            $bulan='Maret';
            break;
        case '04':
            $bulan='April';
            break;
        case '05':
            $bulan='Mei';
            break;
        case '06':
            $bulan='Juni';
            break;
        case '07':
            $bulan='Juli';
            break;
        case '08':
            $bulan='Agustus';
            break;
        case '09':
            $bulan='September';
            break;
        case '10':
            $bulan='Oktober';
            break;
        case '11':
            $bulan='November';
            break;
        case '12':
            $bulan='Desember';
            break;
            default;
    }
    return  date('j',strtotime($param)).' '.$bulan.' '.date('Y',strtotime($param));
}

function nmbulan($param) {
    switch (date('m',strtotime($param))){
        case '01':
            $bulan='Januari';
            break;
        case '02':
            $bulan='Februari';
            break;
        case '03':
            $bulan='Maret';
            break;
        case '04':
            $bulan='April';
            break;
        case '05':
            $bulan='Mei';
            break;
        case '06':
            $bulan='Juni';
            break;
        case '07':
            $bulan='Juli';
            break;
        case '08':
            $bulan='Agustus';
            break;
        case '09':
            $bulan='September';
            break;
        case '10':
            $bulan='Oktober';
            break;
        case '11':
            $bulan='November';
            break;
        case '12':
            $bulan='Desember';
            break;
        default;
    }
    return $bulan;
}

function nmhari($param) {
    switch (date('D', strtotime($param))){
        case 'Sun':
            $hari='Minggu';
            break;
        case 'Mon':
            $hari='Senin';
            break;
        case 'Tue':
            $hari='Selasa';
            break;
        case 'Wed':
            $hari='Rabu';
            break;
        case 'Thu':
            $hari='Kamis';
            break;
        case 'Fri':
            $hari='Jumat';
            break;
        case 'Sat':
            $hari='Sabtu';
            break;
        default;
    }
    return $hari;
}

function monthYear($param){
    $month = nmbulan($param);
    $year = date('Y',strtotime($param));
    return $month.' '.$year;
}

function convertNumberToRomanInString($input) {
    // Mapping angka ke angka romawi
    $romanMap = array(
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X'
    );

    // Cari angka di akhir string
    if (preg_match('/^(.*?)(\d+)$/', $input, $matches)) {
        $text = trim($matches[1]);
        $number = (int)$matches[2];
        $roman = isset($romanMap[$number]) ? $romanMap[$number] : $number;
        return $text . ' ' . $roman;
    }
    else if ($input == 'PKWT 1 (PERCOBAAN)') {
        return 'PKWT Percobaan';
    }

    // Kalau tidak ada angka, kembalikan string asli
    return $input;
}