<?php

include "fungsi.php";
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
} else {
    echo "Koneksi internet sedang tidak stabil.";
}
