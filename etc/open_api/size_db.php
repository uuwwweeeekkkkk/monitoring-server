<?php
// Izinkan akses dari semua domain atau alamat IP
header("Access-Control-Allow-Origin: *");
// Izinkan metode HTTP yang diizinkan (GET, POST, dll.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Izinkan header tambahan jika diperlukan
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Set header untuk memberitahu bahwa ini adalah respons JSON
header('Content-Type: application/json');

$koneksi = mysqli_connect("localhost", "root", "kambingjawa", "information_schema");

$query = mysqli_query($koneksi, "SELECT
                                        table_schema AS nm_db,
                                        SUM(data_length + index_length) AS size_db,
                                        ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_db_mb
                                    FROM information_schema.tables 
                                    GROUP BY table_schema
                                    ORDER BY SUM(data_length + index_length) DESC
                        ");
// echo json_encode($row = mysqli_fetch_assoc($query));
$no = 0;
while ($row = mysqli_fetch_array($query)) {
    $data[$no]['nm_db'] = $row['nm_db'];
    $data[$no]['size_db'] = $row['size_db'];
    $data[$no]['size_db_mb'] = $row['size_db_mb'];

    $no++;
}
echo json_encode($data);
