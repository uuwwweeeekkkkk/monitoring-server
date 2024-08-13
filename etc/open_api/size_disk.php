<?php
// Izinkan akses dari semua domain atau alamat IP
header("Access-Control-Allow-Origin: *");
// Izinkan metode HTTP yang diizinkan (GET, POST, dll.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Izinkan header tambahan jika diperlukan
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Set header untuk memberitahu bahwa ini adalah respons JSON
header('Content-Type: application/json');

$directory = '/';

// Mendapatkan total kapasitas ruang disk pada direktori
$totalSpace = disk_total_space($directory);

// Mendapatkan kapasitas ruang disk yang belum terisi pada direktori
$freeSpace = disk_free_space($directory);

// Menghitung kapasitas ruang disk yang telah terisi
$usedSpace = $totalSpace - $freeSpace;

// Konversi ke dalam format yang mudah dibaca manusia (dalam gigabyte)
$totalSpaceGB = round($totalSpace / (1024 * 1024 * 1024), 2);
$usedSpaceGB = round($usedSpace / (1024 * 1024 * 1024), 2);
$freeSpaceGB = round($freeSpace / (1024 * 1024 * 1024), 2);

// Membuat array yang berisi data kapasitas ruang disk
$data = [
    'totalSpaceGB' => $totalSpaceGB,
    'usedSpaceGB' => $usedSpaceGB,
    'freeSpaceGB' => $freeSpaceGB,
    'os' => php_uname()
];

// Mengembalikan data sebagai respons JSON
echo json_encode($data);
