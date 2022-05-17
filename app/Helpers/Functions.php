<?php

// run composer dump-autoload 
// generate function global

function getCurrentUrl()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    // Append the host(domain name, ip) to the URL.   
    $url .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL   
    $url .= $_SERVER['REQUEST_URI'];

    return $url;
}

function lengthChar($text, $length)
{
    if (strlen($text) > $length) $text = substr($text, 0, $length) . ' ...';

    return $text;
}

function formatTglFestival($tanggal)
{
    $hari = formatHari($tanggal);
    $tgl = date("d", strtotime($tanggal));
    $bln = date("M", strtotime($tanggal));
    $tahun = date("Y", strtotime($tanggal));

    return $hari . ', ' . $tgl . ' ' . $bln . ' ' . $tahun;
}

function formatJamFestival($tanggal)
{
    $jam = date("H", strtotime($tanggal));
    $menit = date("i", strtotime($tanggal));

    return $jam . ':' . $menit . ' WIB';
}

function formatHari($tanggal)
{
    $hari = date("D", strtotime($tanggal));

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    return $hari_ini;
}

function bulanString($bulan)
{
    switch ($bulan) {
        case '01':
            $bulanStr = "Januari";
            break;

        case '02':
            $bulanStr = "Februari";
            break;

        case '03':
            $bulanStr = "Maret";
            break;

        case '04':
            $bulanStr = "April";
            break;

        case '05':
            $bulanStr = "Mei";
            break;

        case '06':
            $bulanStr = "Juni";
            break;

        case '07':
            $bulanStr = "Juli";
            break;

        case '08':
            $bulanStr = "Agustus";
            break;

        case '09':
            $bulanStr = "September";
            break;

        case '10':
            $bulanStr = "Oktober";
            break;

        case '11':
            $bulanStr = "Nopember";
            break;

        case '12':
            $bulanStr = "Desember";
            break;

        default:
            $bulanStr = "Semua Bulan";
            break;
    }

    return $bulanStr;
}

function terbilang($angka)
{
    $angka = abs($angka);
    $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

    $terbilang = "";
    if ($angka < 12) {
        $terbilang = " " . $baca[$angka];
    } else if ($angka < 20) {
        $terbilang = terbilang($angka - 10) . " Belas";
    } else if ($angka < 100) {
        $terbilang = terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);
    } else if ($angka < 200) {
        $terbilang = " Seratus" . terbilang($angka - 100);
    } else if ($angka < 1000) {
        $terbilang = terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);
    } else if ($angka < 2000) {
        $terbilang = " Seribu" . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        $terbilang = terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        $terbilang = terbilang($angka / 1000000) . " Juta" . terbilang($angka % 1000000);
    }

    return $terbilang;
}

function input_angka($angka)
{
    return preg_replace("/[^0-9]/", "", $angka);
}

function rupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ",", ".");
}

function telepon_id($number)
{
    $kode_telp = substr($number, 0, 2);
    if ($kode_telp == '08') {
        $telepon = '628' . substr($number, 2, 12);

        return $telepon;
    } else {
        return $number;
    }
}

function telepon_back($number)
{
    $kode_telp = substr($number, 0, 3);
    if ($kode_telp == '628') {
        $telepon = '08' . substr($number, 3, 12);

        return $telepon;
    } else {
        return $number;
    }
}

function tanggal_id($tanggal)
{
    //potong 
    $tanggal2 = substr($tanggal, 8, 2);
    $bulan = substr($tanggal, 5, 2);
    $tahun = substr($tanggal, 0, 4);

    if ($tahun == null) {
        $result = null;
    } else {
        $result = $tanggal2 . '-' . $bulan . '-' . $tahun;
    }
    return $result;
}

function tanggal_en($tanggal)
{
    $tanggal2 = substr($tanggal, 0, 2);
    $bulan = substr($tanggal, 3, 2);
    $tahun = substr($tanggal, 6, 4);
    return $tahun . '-' . $bulan . '-' . $tanggal2;
}

function checkHariLibur($list, $index)
{
    foreach ($list as $item) {
        if ($item == $index) {
            return true;
        }
    }
}
