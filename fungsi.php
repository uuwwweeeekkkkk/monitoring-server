<?php

date_default_timezone_set("Asia/Jakarta");
// ===== BEGIN / Input Variable =====
define("VAR_MYSQL_HOST", "localhost");
define("VAR_MYSQL_USER", "root"); // username mysql
define("VAR_MYSQL_PASSWORD", ""); // password mysql
define("VAR_MYSQL_DBNAME", "monitoring");
define("VAR_BOT_TOKEN", "token_sent"); // isi dengan token telegram pengirim
define("VAR_TELEGRAM_CHATID", "token_receipt"); // isi dengan token telegram penerima
define("VAR_PROXY_SERVER", "");
define("VAR_CACERT_PATHFILE", "/etc/ssl/certs/cacert.pem");
define("VAR_RTOTIME_TOLERANT", "04"); // max 59 minutes

// ===== BEGIN / Connection =====
$konek = mysqli_connect(VAR_MYSQL_HOST, VAR_MYSQL_USER, VAR_MYSQL_PASSWORD, VAR_MYSQL_DBNAME);

// ===== BEGIN / Function untuk Kirim Telegram =====
function kirim_telegram($pesan)
{
    $pesan = urlencode($pesan);
    $bot_token = "bot" . VAR_BOT_TOKEN;
    $chat_id = VAR_TELEGRAM_CHATID;
    $proxy = VAR_PROXY_SERVER;
    $cacert_file_path = VAR_CACERT_PATHFILE;

    $url = file_get_contents("https://api.telegram.org/$bot_token/sendMessage?parse_mode=markdown&chat_id=$chat_id&disable_web_page_preview=true&text=$pesan");

    // ------------ METODE LAMA, SEKARANG PAKE YG DIATAS 'file_get_contents' ------------
    // $url = "https://api.telegram.org/$bot_token/sendMessage?parse_mode=markdown&chat_id=$chat_id&disable_web_page_preview=true&text=$pesan";
    // $ch = curl_init();

    // if ($proxy == "") {
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CAINFO => "$cacert_file_path"
    //     );
    // } else {
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_PROXY => "$proxy",
    //         CURLOPT_CAINFO => "$cacert_file_path"
    //     );
    // }

    // curl_setopt_array($ch, $optArray);
    // $result = curl_exec($ch);

    // $err = curl_error($ch);
    // curl_close($ch);

    // if ($url <> "") {
    //     echo "<br><b>Error: $url</b><br><br>";
    // } else {
    //     echo "<br><b> --- Message telegram has been sent ---</b><br><br>";
    // }
}

function terbilang_durasi($tanggal_rto, $tanggal_reply)
{
    // global $durasi;
    $cek_waktu = date_diff($tanggal_rto, $tanggal_reply);

    if ($cek_waktu->d == 0) {
        if ($cek_waktu->h >= 1) {
            $durasi = $cek_waktu->h . ' Jam ' . $cek_waktu->i . ' Menit';
        } else {
            $durasi = $cek_waktu->i . ' Menit ';
        }
    } else {
        $durasi = $cek_waktu->d . ' Hari ' . $cek_waktu->h . ' Jam ' . $cek_waktu->i . ' Menit';
    }
    return $durasi;
}

// BUAT NGUCAPIN SALAM DITELEGRAM
if (date("H") >= 21) {
    $salam = "Sorry ganggu waktu istirahatnya..";
} else if (date("H") >= 20) {
    $salam = "Hallo belum tidur kan..?";
} else if (date("H") >= 19) {
    $salam = "Malem semua..";
} else if (date("H") >= 18) {
    $salam = "Met petang semua..";
} else if (date("H") >= 15) {
    $salam = "Sore semua..";
} else if (date("H") >= 13) {
    $salam = "Siang semua..";
} else if (date("H") >= 12) {
    $salam = "Hai dah makan siang belum..?";
} else if (date("H") >= 10) {
    $salam = "Siang semua..";
} else if (date("H") >= 8) {
    $salam = "Pagi semua..";
} else if (date("H") >= 7) {
    $salam = "Hai dah sarapan kan..?";
} else if (date("H") >= 5) {
    $salam = "Pagi semua..";
} else if (date("H") >= 4) {
    $salam = "Halo dah bangun kan..?";
} else {
    $salam = "Sorry ganggu waktu tidurnya..";
}


function enkripsi($data)
{
    return $data = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($data)))));
}

function dekripsi($data)
{
    return $data = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data)))));
}

// ngecek foto jika tidak ada fotonya maka pakai fito default
function cek_foto($data)
{
    $foto = file_exists("../assets/img/foto/$data") && isset($data) ? $data : 'avatars.png';

    return $foto;
}
// $cek_foto = !file_exists("../assets/img/foto/" . $dataUser['foto'] . "");
// if (is_null($dataUser['foto']) || $dataUser['foto'] == "" || $cek_foto) {
// 	$foto = "avatars.png";
// } else {
// 	$foto = $dataUser['foto'];
// }

function isInternetConnected()
{
    $url = "https://www.google.com"; // URL yang akan diakses untuk memeriksa koneksi internet
    $headers = @get_headers($url);

    if ($headers && strpos($headers[0], "200") !== false) {
        return true; // Koneksi internet aktif
    } else {
        return false; // Tidak ada koneksi internet
    }
}
