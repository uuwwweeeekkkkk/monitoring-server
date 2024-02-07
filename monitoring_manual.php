<?php
// $konek = mysqli_connect("localhost", "root", "", "telegram");

// $query = mysqli_query($konek, "SELECT * FROM data_ip");

// while ($data = mysqli_fetch_assoc($query)) {

//     // $ip = "101.255.125.77";
//     $ping = shell_exec("ping -c 1 -W 1 " . $data['ip_address']);
//     echo $ping . "<br>";

//     if (strpos(strtoupper($ping), "TTL=") <= 0 or strpos($ping, "TTL expired") > 0 or strpos($ping, "Request timed out") > 0 or strpos($ping, "Destination host unreachable") > 0) {

//         // ===== BEGIN / Function untuk Kirim Telegram =====
//         // function kirim_telegram($pesan)
//         // {
//         $pesan = "Test down server Ju.. " . $ping; // urlencode($pesan);
//         $bot_token = "1912282288:AAGnjvGcuGloJ0NWSB7TfmFJadDkiIEKJJc";
//         $chat_id = "706694762";
//         $proxy = "";
//         $cacert_file_path = "cacert.pem";

//         $token = "bot" . $bot_token;
//         $url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&disable_web_page_preview=true&text=$pesan";
//         $ch = curl_init();

//         if ($proxy == "") {
//             $optArray = array(
//                 CURLOPT_URL => $url,
//                 CURLOPT_RETURNTRANSFER => true,
//                 CURLOPT_CAINFO => "$cacert_file_path"
//             );
//         } else {
//             $optArray = array(
//                 CURLOPT_URL => $url,
//                 CURLOPT_RETURNTRANSFER => true,
//                 CURLOPT_PROXY => "$proxy",
//                 CURLOPT_CAINFO => "$cacert_file_path"
//             );
//         }

//         curl_setopt_array($ch, $optArray);
//         $result = curl_exec($ch);

//         $err = curl_error($ch);
//         curl_close($ch);

//         if ($err <> "") {
//             echo "<br><b>Error: $err</b><br><br>";
//         } else {
//             echo "<br><b> --- Telegram SENT ---</b><br><br>";
//         }
//         // }
//     }
// }


// include "../fungsi.php";
date_default_timezone_set("Asia/Jakarta");
$toleransi = VAR_RTOTIME_TOLERANT;
$waktu_kirim = "NULL";
$pesanUP = "";
$jumlahUP = 0;
$pesanDown = "";
$jumlahDown = 0;
$hasil_ping = "";

if (isInternetConnected()) {
    // NAMPILIN SEMUA IP DIMASTER DATA
    $queryCek = mysqli_query($konek, "SELECT * FROM data_ip
									-- WHERE id_ip NOT IN (SELECT ip_id FROM monitoring_rto
									--					WHERE status = 'offline'
									--					AND tanggal_reply IS NULL)
									ORDER BY ip_address ASC
							");
    $jumlahCek = mysqli_num_rows($queryCek);

    if ($jumlahCek > 0) {
        while ($dataCek = mysqli_fetch_assoc($queryCek)) {
            $id_ip = $dataCek['id_ip'];
            $ip_address = $dataCek['ip_address'];

            $ping = shell_exec("ping -c 1 -W 1 " . $ip_address);
            // $ping = exec("ping -n 1 -w 1 " . $ip_address, $output, $status);

            // CEK UDH ADA DITBL RTO BLM
            $cekRTO = mysqli_query($konek, "SELECT id_rto, kd_ip, ip_address, nm_unit, nm_pic, gps_x, gps_y,
											kategori, status, tanggal_rto, ip_address, kirim_telegram,
											TIMEDIFF(NOW(), tanggal_rto) as lama_padam,
											DATE_FORMAT(tanggal_rto, '%d %M %Y Jam %H:%i WIB') AS waktu_rto,
											DATE_FORMAT(NOW(), '%d %M %Y Jam %H:%i WIB') AS waktu_up
										FROM monitoring_rto
			 							LEFT JOIN data_ip
			 								ON id_ip = ip_id
										LEFT JOIN pic
											ON id_pic = pic_id
										WHERE ip_id = '$id_ip'
										AND dipindai = 1
										AND status = 'offline'
										AND tanggal_reply IS NULL
						");
            $jumlahRTO = mysqli_num_rows($cekRTO);
            $dataRTO = mysqli_fetch_assoc($cekRTO);
            $id_rto =  $dataRTO['id_rto'];
            $tanggal_rto = date_create($dataRTO['tanggal_rto']);
            $tanggal_reply = date_create();
            $durasi = terbilang_durasi($tanggal_rto, $tanggal_reply);

            if (strpos(strtoupper($ping), "TTL=") <= 0 || strpos($ping, "TTL expired") > 0 || strpos($ping, "Request timed out") > 0 || strpos($ping, "Destination host unreachable") > 0) {
                // JIKA BLM ADA MAKA INSERT KE TBL RTO
                if ($jumlahRTO == 0) {
                    $insRTO = mysqli_query($konek, "INSERT INTO monitoring_rto (ip_id, tanggal_rto, dipindai, status, keterangan) VALUES
												($id_ip, NOW(), '1', 'offline', '$ping')
							");
                } else {
                    // JIKA UDH PADAM / GABISA DIPING LEBIH DARI 3 MENIT MAKA NGIRIM TELEGRAM) 
                    if ($dataRTO['lama_padam'] >= "00:$toleransi:00" && is_null($dataRTO['kirim_telegram'])) {
                        $lokasi = "[Lihat Lokasi.](http://maps.google.com/maps?q=" . $dataRTO['gps_y'] . "," . $dataRTO['gps_x'] . ")";
                        $pesanDown = $pesanDown . $dataRTO['nm_unit'] . " (" . $dataRTO['ip_address'] . ") barusan aja *DOWN* " . $dataRTO['waktu_rto'] . ". Teknisinya " . $dataRTO['nm_pic'] . " buruan dicek yah! " . $lokasi . "\n\n";
                        $waktu_kirim = "NOW()";
                        $jumlahDown++;
                    }

                    $updStatus = mysqli_query($konek, "UPDATE monitoring_rto SET kirim_telegram = $waktu_kirim WHERE id_rto = '$id_rto' AND kirim_telegram IS NULL");
                }
            } else {
                // JIKA UDH BISA DIPING MAKA NGIRIM TELEGRAM & UPDATE STATUSNYA
                if ($jumlahRTO > 0) {
                    if ($dataRTO['lama_padam'] >= "00:$toleransi:00") {
                        $pesanUP = $pesanUP . $dataRTO['nm_unit'] . " (" . $dataRTO['ip_address'] . ") barusan udah *UP* " . $dataRTO['waktu_up'] . ". Waktu pemulihannya " . $durasi . ".\n\n";
                        $waktu_kirim = "NOW()";
                        $jumlahUP++;
                    }

                    $updStatus = mysqli_query($konek, "UPDATE monitoring_rto SET tanggal_reply = NOW(), kirim_telegram = $waktu_kirim, dipindai = 0, status = 'online', durasi = '$durasi'
													WHERE id_rto = '$id_rto'
								");
                }
            }
            $hasil_ping = $hasil_ping . str_replace("PING ", "Monitoring ", "$ping") . "<br>";
        }

        // KIRIM TELEGRAM
        if ($jumlahUP > 0) {
            $pesanUP = $salam . " Ada info terbaru nih...\n\n" . $pesanUP;
            kirim_telegram($pesanUP);
        }

        if ($jumlahDown > 0) {
            $pesanDown = $salam . " Ada info terbaru nih...\n\n" . $pesanDown;
            kirim_telegram($pesanDown);
        }
    }

    // NAMPILIN DATA & KIRIM KE TELEGRAM JIKA ADA YG DOWN
    // $queryDown = mysqli_query($konek, "SELECT kd_ip, ip_address, nm_unit, gps_x, gps_y, kategori, status,
    // 										DATE_FORMAT(tanggal_rto, '%d %M %Y Jam %H:%i WIB') AS tanggal_rto,
    // 										CAST(TIMEDIFF(NOW(), tanggal_rto) AS CHAR) AS lama_padam
    // 									FROM monitoring_rto
    // 									INNER JOIN data_ip
    // 										ON id_ip = ip_id
    // 									INNER JOIN pic
    // 										ON id_pic = pic_id
    // 									WHERE dipindai = '1'
    // 									AND STATUS = 'offline'
    // 									AND TIMEDIFF(NOW(), tanggal_rto) > '00:$toleransi:00'
    // 				");
    // $jumlahDown = mysqli_num_rows($queryDown);

    // if ($jumlahDown > 0) {
    // 	while ($dataDown = mysqli_fetch_assoc($queryDown)) {
    // 		if (isset($dataDown['kd_ip'])) {
    // 			$kd_ip = " Kode " . $dataDown['kd_ip'];
    // 		} else {
    // 			$kd_ip = "";
    // 		}

    // 		if (isset($dataDown['gps_x']) && isset($dataDown['gps_y'])) {
    // 			$gps = "[Lihat Lokasi.](https://maps.google.com/maps?p=" . $dataDown['gps_x'] . "," . $dataDown['gps_y'] . ")";
    // 		} else {
    // 			$gps = "";
    // 		}
    // 	}
    // }
} else {
    $hasil_ping = "Koneksi internet sedang tidak stabil.";
}
