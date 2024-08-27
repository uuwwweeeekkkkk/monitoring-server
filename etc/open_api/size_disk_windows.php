<?php
// Izinkan akses dari semua domain atau alamat IP
header("Access-Control-Allow-Origin: *");
// Izinkan metode HTTP yang diizinkan (GET, POST, dll.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Izinkan header tambahan jika diperlukan
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Set header untuk memberitahu bahwa ini adalah respons JSON
header('Content-Type: application/json');

$directoryC = 'C:/';
$directoryD = 'D:/';

// Mendapatkan total kapasitas ruang disk pada direktori
$totalSpaceC = disk_total_space($directoryC);
$totalSpaceD = disk_total_space($directoryD);

// Mendapatkan kapasitas ruang disk yang belum terisi pada direktori
$freeSpaceC = disk_free_space($directoryC);
$freeSpaceD = disk_free_space($directoryD);

// Menghitung kapasitas ruang disk yang telah terisi
$usedSpaceC = $totalSpaceC - $freeSpaceC;
$usedSpaceD = $totalSpaceD - $freeSpaceD;

// Konversi ke dalam format yang mudah dibaca manusia (dalam gigabyte)
$totalSpaceCGB = round($totalSpaceC / (1024 * 1024 * 1024), 2);
$usedSpaceCGB = round($usedSpaceC / (1024 * 1024 * 1024), 2);
$freeSpaceCGB = round($freeSpaceC / (1024 * 1024 * 1024), 2);

$totalSpaceDGB = round($totalSpaceD / (1024 * 1024 * 1024), 2);
$usedSpaceDGB = round($usedSpaceD / (1024 * 1024 * 1024), 2);
$freeSpaceDGB = round($freeSpaceD / (1024 * 1024 * 1024), 2);

// Membuat array yang berisi data kapasitas ruang disk
$totalSpaceGB = $totalSpaceCGB + $totalSpaceDGB;
$usedSpaceGB = $usedSpaceCGB + $usedSpaceDGB;
$freeSpaceGB = $freeSpaceCGB + $freeSpaceDGB;

$data = [
    'totalSpaceGB' => $totalSpaceDGB,
    'usedSpaceGB' => $usedSpaceDGB,
    'freeSpaceGB' => $freeSpaceDGB
];

// Mengembalikan data sebagai respons JSON
echo json_encode($data);
